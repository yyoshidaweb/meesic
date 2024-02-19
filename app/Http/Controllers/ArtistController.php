<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     * アーティスト一覧を表示する
     */
    public function index(): View
    {
        return view('artists.index', [
            'artists' => Artist::with('user')->latest()->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * アーティスト名を追加する
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
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artist $artist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * アーティスト名を削除する
     */
    public function destroy(Artist $artist): RedirectResponse
    {
        $this->authorize('delete', $artist);
        $artist->delete();
        return redirect(route('artists.index'));
    }
}
