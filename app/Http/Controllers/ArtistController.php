<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtistController extends Controller
{
    /**
     * アーティストリストを表示する
     *
     * @return View
     */
    public function index(): View
    {
        return view('artists.index', [
            'artists' => Artist::with('user')->latest()->paginate(20),
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

        // アーティスト名を追加して、ホームにリダイレクトする
        $request->user()->artists()->create($validated);
        return redirect(route('artists.index'));
    }

    /**
     * アーティストリスト編集ページを表示する
     *
     * @param Artist $artist
     * @return View
     */
    public function edit(Artist $artist): View
    {
        return view('artists.edit', [
            'artists' => Artist::with('user')->latest()->paginate(20),
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
