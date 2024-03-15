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
        @isset($result_artists)
            <p class="">検索結果:</p>
            @foreach ($result_artists as $result_artist)
                <div class="flex">
                    <p class="mr-4">{{ $result_artist['name'] }}</p>
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
