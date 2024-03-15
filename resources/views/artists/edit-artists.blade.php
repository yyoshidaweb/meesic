<x-app-layout>
    {{-- アーティスト検索フォーム全体 --}}
    <div class="">
        {{-- POSTリクエストでsearchArtistsメソッドを使用 --}}
        <form method="POST" action="{{ route('artists.searchArtists') }}">
            {{-- CSRF保護 --}}
            @csrf
            {{-- 入力エリア --}}
            <label>
                <input
                    type="text"
                    name="keyword"
                    placeholder="アーティスト名を入力してください"
                    value="{{ old('keyword') }}"
                    class=""
                />
                {{-- エラーメッセージを表示する --}}
                <x-input-error :messages="$errors->get('keyword')" class="" />
                {{-- 送信ボタン --}}
                <x-primary-button class="">検索</x-primary-button>
            </label>
        </form>
    </div>

    {{-- 検索結果を表示 --}}
    <div class="">
        {{-- 検索結果が存在する場合に表示 --}}
        @isset($result_artists)
            <p class="">検索結果:</p>
            {{-- 検索結果一覧を表示 --}}
            @foreach ($result_artists as $result_artist)
                <div class="flex mb-2">
                    {{-- アーティスト名 --}}
                    <p class="mr-4">{{ $result_artist['name'] }}</p>
                    {{-- spotify_idを保存するフォーム --}}
                    <form method="POST" action="{{ route('spotify.storeSpotifyId') }}">
                        {{-- CSRF保護 --}}
                        @csrf
                        {{-- spotify_id入力フォーム（非表示） --}}
                        <input type="hidden" name="spotify_id" value="{{ $result_artist['id'] }}">
                        {{-- エラーを表示 --}}
                        <x-input-error :messages="$errors->get('spotify_id')" class="" />
                        {{-- 送信ボタン --}}
                        <x-primary-button class="">リストに追加</x-primary-button>
                    </form>
                </div>
            @endforeach
        @endisset
    </div>

    {{-- アーティスト追加フォーム全体 --}}
    <div class="">
        {{-- POSTリクエストでaddメソッドを使用 --}}
        <form method="POST" action="{{ route('artists.add') }}">
            {{-- CSRF保護 --}}
            @csrf
            {{-- 入力エリア --}}
            <label>
                アーティスト名
                <input
                    type="text"
                    name="name"
                    placeholder="アーティスト名を入力してください"
                    value="{{ old('name') }}"
                    class=""
                />
                {{-- エラーメッセージを表示する --}}
                <x-input-error :messages="$errors->get('name')" class="" />
                {{-- 送信ボタン --}}
                <x-primary-button class="">アーティストを追加</x-primary-button>
            </label>
        </form>
    </div>

    {{-- アーティスト一覧を表示 --}}
    <div class="">
        {{-- Spotify_artistsが存在する場合 --}}
        @isset($spotify_artists)
            {{-- Spotify上のアーティストを表示 --}}
            @foreach ($spotify_artists as $spotify_artist)
                <div class="">
                    {{-- アーティスト名 --}}
                    <p class="">{{ $spotify_artist['name'] }}</p>
                </div>
                {{-- 削除 --}}
                <form method="POST" action="{{ route('spotify.detach', $spotify_artist['id']) }}">
                    @csrf
                    @method('delete')
                    <x-primary-button
                        type="submit"
                        class="bg-red-500"
                        onclick="return confirm('本当に削除しますか？')"
                    >削除</x-primary-button>
                </form>
            @endforeach
        @endisset

        @foreach ($artists as $artist)
            <div class="">
                <p class="">{{ $artist->name }}</p>
            </div>
            {{-- もし削除権限がある場合に表示する --}}
            @if ($artist->users->contains(auth()->user()))
                <form method="POST" action="{{ route('artists.detach', $artist) }}">
                    @csrf
                    @method('delete')
                    <x-primary-button
                        type="submit"
                        class="bg-red-500"
                        onclick="return confirm('本当に削除しますか？')"
                    >削除</x-primary-button>
                </form>
            @endif
        @endforeach
        {{-- ページネーション --}}
        <div class="paginate">{{ $artists->links() }}</div>
    </div>
</x-app-layout>
