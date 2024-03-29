<x-app-layout>
    <div class="pb-8 flex flex-col items-center justify-center">
        <div class="mt-8 w-96 flex flex-col items-center justify-center">
            {{-- ユーザー名 --}}
            <div class="">
                <p class="text-4xl text-gray-900 dark:text-white">{{ $user_name }}</p>
            </div>
            {{-- Spotifyアーティスト --}}
            <div class="mt-8">
                <h2 class="text-xl text-gray-900 dark:text-white">Spotifyアーティストを追加</h2>
            </div>
            {{-- アーティスト検索フォーム全体 --}}
            <div class="mt-4 w-full flex justify-center">
                {{-- POSTリクエストでsearchArtistsメソッドを使用 --}}
                <form method="POST" action="{{ route('artists.searchArtists') }}" class="">
                    {{-- CSRF保護 --}}
                    @csrf
                    <div class="w-full flex">
                        <div class="flex flex-col">
                            {{-- 入力エリア --}}
                            <input
                                type="text"
                                name="keyword"
                                placeholder="アーティスト名を入力してください"
                                value="{{ old('keyword') }}"
                                class="rounded shadow-md"
                            />
                            {{-- エラーメッセージを表示する --}}
                            <x-input-error :messages="$errors->get('keyword')" class="" />
                        </div>
                        {{-- 送信ボタン --}}
                        <x-primary-button class="ml-2 shadow-md">検索</x-primary-button>
                    </div>
                </form>
            </div>

            {{-- 検索結果が存在する場合に表示 --}}
            @isset($result_artists)
                {{-- 検索結果を表示 --}}
                <div class="mt-4 mb-32 w-full">
                    <h3 class="text-xl text-center text-gray-900 dark:text-white">検索結果</h3>
                    {{-- 検索結果一覧を表示 --}}
                    @foreach ($result_artists as $result_artist)
                        <a href="{{ $result_artist['external_urls']['spotify'] }}" class="cursor-pointer mt-4 w-full scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div class="flex w-full items-center justify-between">
                                {{-- アーティスト名 --}}
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $result_artist['name'] }}</p>
                                {{-- spotify_idを保存するフォーム --}}
                                <form method="POST" action="{{ route('spotify.storeSpotifyId') }}">
                                    {{-- CSRF保護 --}}
                                    @csrf
                                    {{-- spotify_id入力フォーム（非表示） --}}
                                    <input type="hidden" name="spotify_id" value="{{ $result_artist['id'] }}">
                                    {{-- エラーを表示 --}}
                                    <x-input-error :messages="$errors->get('spotify_id')" class="" />
                                    {{-- 送信ボタン --}}
                                    <x-primary-button class="shadow-md">リストに追加</x-primary-button>
                                </form>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endisset

            {{-- Spotify_artistsが存在する場合 --}}
            @isset($spotify_artists)
                {{-- Spotifyアーティスト一覧を表示 --}}
                <div class="mt-4 w-full">
                    {{-- Spotify上のアーティストを表示 --}}
                    @foreach ($spotify_artists as $spotify_artist)
                        <a href="{{ $spotify_artist['external_urls']['spotify'] }}" class="cursor-pointer mt-4 w-full scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div class="flex w-full items-center justify-between">
                                {{-- アーティスト名 --}}
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $spotify_artist['name'] }}</p>
                                {{-- 削除 --}}
                                <form method="POST" action="{{ route('spotify.detach', $spotify_artist['id']) }}">
                                    @csrf
                                    @method('delete')
                                    <x-primary-button
                                        type="submit"
                                        class="bg-red-500 shadow-md"
                                        onclick="return confirm('本当に削除しますか？')"
                                    >削除</x-primary-button>
                                </form>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endisset

            {{-- カスタムアーティスト --}}
            <div class="mt-8">
                <h2 class="text-xl text-gray-900 dark:text-white">カスタムアーティストを追加</h2>
            </div>
            {{-- アーティスト追加フォーム全体 --}}
            <div class="mt-4 w-full flex justify-center">
                {{-- POSTリクエストでaddメソッドを使用 --}}
                <form method="POST" action="{{ route('artists.add') }}">
                    {{-- CSRF保護 --}}
                    @csrf
                    {{-- 入力エリア --}}
                    <div class="w-full flex">
                        <div class="flex flex-col">
                            <input
                                type="text"
                                name="name"
                                placeholder="アーティスト名を入力してください"
                                value="{{ old('name') }}"
                                class="rounded shadow-md"
                            />
                            {{-- エラーメッセージを表示する --}}
                            <x-input-error :messages="$errors->get('name')" class="" />
                        </div>
                        {{-- 送信ボタン --}}
                        <x-primary-button class="ml-2 shadow-md">リストに追加</x-primary-button>
                    </div>
                </form>
            </div>

            {{-- カスタムアーティストが存在する場合 --}}
            @isset($artists)
                {{-- カスタムアーティスト一覧を表示 --}}
                <div class="mt-4 w-full">
                    @foreach ($artists as $artist)
                        <div class="mt-4 w-full scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex">
                            <div class="flex w-full items-center justify-between">
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $artist->name }}</p>
                                {{-- もし削除権限がある場合に表示する --}}
                                @if ($artist->users->contains(auth()->user()))
                                    <form method="POST" action="{{ route('artists.detach', $artist) }}">
                                        @csrf
                                        @method('delete')
                                        <x-primary-button
                                            type="submit"
                                            class="bg-red-500 shadow-md"
                                            onclick="return confirm('本当に削除しますか？')"
                                        >削除</x-primary-button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    {{-- ページネーション --}}
                    <div class="paginate text-center">{{ $artists->links() }}</div>
                </div>
            @endisset
        </div>
    </div>
</x-app-layout>
