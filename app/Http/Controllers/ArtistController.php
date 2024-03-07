<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArtistController extends Controller
{
    /**
     * アーティストリストを表示する
     * (URLで指定されたユーザーのリストを表示)
     *
     * @return View
     */
    public function index(Request $request): View
    {
        // リクエストされたパスとurl_nameが一致するユーザーを検索する
        $user = User::where('url_name', $request->path())->first();

        // リクエストされたurl_nameと紐づくユーザーのアーティストリストを表示する
        return view('artists.index', [
            'artists' => $user->artists()->latest()->paginate(20),
        ]);
    }

    /**
     * アーティスト名を追加する
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function add(Request $request): RedirectResponse
    {
        // リクエストされた値にバリデーションを行う
        $validated = $request->validate([
            'name' => 'required | string | max:100',
        ]);

        // リクエストを送信したユーザーの情報を取得
        $user = $request->user();
        // artistsテーブル内のnameカラムの値と、リクエストされた値が一致するアーティストを取得
        $artist = Artist::where('name', $validated)->first();

        // 一致するアーティストが存在し、まだユーザーに紐づけられていない場合
        if ($artist && $artist->users->doesntContain($user)) {
            // 一致するアーティストとユーザーを紐づける
            $artist->users()->attach($user->id);
        } else if (!$artist) {
            // アーティストモデル内に新しいアーティストを作成する
            $artist = Artist::create($validated);
            // 作成されたアーティストとログイン中ユーザーを紐づける
            $artist->users()->attach($user->id);
        }

        // 編集ページにリダイレクトする
        return redirect(route('artists.editArtists'));
    }

    /**
     * アーティストリスト編集ページを表示する
     * (ログイン中のユーザーのリストを表示)
     *
     * @param Artist $artist
     * @return View
     */
    public function editArtists(Artist $artist): View
    {
        // 認証情報に関するユーザー情報を取得する
        $authUser = Auth::user();
        // 認証情報のIDからアーティスト情報を管理するためのユーザー情報を取得する
        $user = User::find($authUser->getAuthIdentifier());

        return view('artists.edit-artists', [
            'artists' => $user->artists()->latest()->paginate(20),
        ]);
    }

    /**
     * アーティスト名を削除する
     *
     * @param Artist $artist
     * @return RedirectResponse
     */
    public function detach(Artist $artist): RedirectResponse
    {
        // ユーザーがdetachを行うことを認可されているか判定する
        $this->authorize('detach', $artist);

        // アーティストのIDから削除するアーティストデータを取得
        $detachArtist = Artist::find($artist->id);
        // 中間テーブルから紐付けを解除
        $detachArtist->users()->detach(auth()->user()->id);

        // アーティストリスト編集ページにリダイレクトする
        return redirect(route('artists.editArtists'));
    }
}
