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
            'artists' => Artist::where('user_id', $user->id)->latest()->paginate(20),
        ]);
    }

    /**
     * アーティスト名を追加する
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required | string | max:100',
        ]);
        // アーティスト名を追加して、編集ページにリダイレクトする
        $request->user()->artists()->create($validated);
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
        $user = Auth::user();

        return view('artists.editArtists', [
            'artists' => Artist::where('user_id', $user->id)->latest()->paginate(20),
        ]);
    }

    /**
     * アーティスト名を削除する
     *
     * @param Artist $artist
     * @return RedirectResponse
     */
    public function destroy(Artist $artist): RedirectResponse
    {
        $this->authorize('delete', $artist);
        $artist->delete();
        return redirect(route('artists.index'));
    }
}
