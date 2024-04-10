<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            アーティストリスト編集
        </h2>
    </x-slot>
    <div class="pb-8 flex flex-col items-center justify-center">
        <div class="mt-8 w-96 flex flex-col items-center justify-center">
            {{-- ユーザー名 --}}
            <div class="">
                <h2 class="mt-4 font-semibold text-2xl text-gray-900 dark:text-white">こんにちは！{{ $user_name }}</h2>
                <p class="mt-4 text-gray-900 dark:text-white">
                    ここではあなたのページに表示されるアーティストリストを編集できます。
                </p>
            </div>
            {{-- Spotifyアーティスト --}}
            <div class="mt-16">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">好きなアーティストがSpotifyに登録されている場合はこちら</h2>
                <div class="mt-4 p-4 bg-white rounded-3xl shadow-inner">
                    <h3 class="font-semibold text-xl text-gray-900 dark:text-white">アーティストの追加方法</h3>
                    <ol class="ml-5 list-decimal list-outside">
                        <li class="mt-4 text-gray-900 dark:text-white">下の検索フォームに好きなアーティスト名を入力</li>
                        <li class="mt-4 text-gray-900 dark:text-white"><strong>検索</strong>ボタンをクリック</li>
                        <li class="mt-4 text-gray-900 dark:text-white">検索結果の中から好きなアーティストを探す</li>
                        <li class="mt-4 text-gray-900 dark:text-white">好きなアーティストが見つかったら<strong>リストに追加</strong>ボタンをクリック！</li>
                    </ol>
                </div>
            </div>
            {{-- アーティスト検索フォーム全体 --}}
            <div class="flex flex-col mt-8 w-full flex justify-center">
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
                                placeholder="アーティスト名で検索"
                                value="{{ old('keyword') }}"
                                class="w-72 rounded shadow-md"
                            />
                            {{-- エラーメッセージを表示する --}}
                            <x-input-error :messages="$errors->get('keyword')" class="" />
                        </div>
                        {{-- 送信ボタン --}}
                        <x-primary-button class="ml-2 max-h-10 shadow-md">検索</x-primary-button>
                    </div>
                </form>
                <p class="mt-2 text-xs text-gray-900 dark:text-white">※Spotifyに登録されているアーティストのみを検索します。</p>
            </div>

            {{-- 検索結果が存在する場合に表示 --}}
            @isset($result_artists)
                {{-- 検索結果を表示 --}}
                <div class="mt-4 w-full">
                    <h3 class="mt-4 font-semibold text-xl text-gray-900 dark:text-white">検索結果</h3>
                    {{-- 検索結果一覧を表示 --}}
                    @foreach ($result_artists as $result_artist)
                        <a href="{{ $result_artist['external_urls']['spotify'] }}" class="cursor-pointer mt-4 w-full scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div class="flex w-full items-center justify-between">
                                {{-- アーティスト情報全体 --}}
                                <div class="flex items-center">
                                    {{-- アーティスト画像 --}}
                                    @isset($result_artist['images']['0']['url'])
                                        <img
                                            src="{{ $result_artist['images']['0']['url'] }}"
                                            alt="{{ $result_artist['name'] }}のアーティスト画像"
                                            class="min-w-20 w-20 h-20 rounded-full shadow-md"
                                        >
                                    @else
                                        <div class="min-w-20 w-20 h-20 flex justify-center items-center bg-gray-600 rounded-full shadow-md">
                                            {{-- Googleマテリアルアイコン --}}
                                            <span class="material-symbols-outlined text-3xl text-white rounded-full">
                                                person
                                            </span>
                                        </div>
                                    @endisset
                                    {{-- アーティスト名 --}}
                                    <p class="ml-4 font-semibold text-gray-900 dark:text-white">{{ $result_artist['name'] }}</p>
                                </div>
                                {{-- spotify_idを保存するフォーム --}}
                                <form method="POST" action="{{ route('spotify.storeSpotifyId') }}">
                                    {{-- CSRF保護 --}}
                                    @csrf
                                    {{-- spotify_id入力フォーム（非表示） --}}
                                    <input type="hidden" name="spotify_id" value="{{ $result_artist['id'] }}">
                                    {{-- エラーを表示 --}}
                                    <x-input-error :messages="$errors->get('spotify_id')" class="" />
                                    {{-- 送信ボタン --}}
                                    <x-primary-button class="ml-4 min-w-32 min-h-11 flex justify-center shadow-md">リストに追加</x-primary-button>
                                </form>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endisset

            {{-- Spotify_artistsが存在する場合 --}}
            @isset($spotify_artists)
                {{-- Spotifyアーティスト一覧を表示 --}}
                <div class="mt-8 w-full">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">アーティストリスト（Spotify）</h3>
                    {{-- Spotify上のアーティストを表示 --}}
                    @foreach ($spotify_artists as $spotify_artist)
                        <a href="{{ $spotify_artist['external_urls']['spotify'] }}" class="cursor-pointer mt-4 w-full scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div class="flex w-full items-center justify-between">
                                {{-- アーティスト情報全体 --}}
                                <div class="flex items-center justify-start">
                                    {{-- アーティスト画像 --}}
                                    @isset($spotify_artist['images']['0']['url'])
                                        <img
                                            src="{{ $spotify_artist['images']['0']['url'] }}"
                                            alt="{{ $spotify_artist['name'] }}のアーティスト画像"
                                            class="w-20 h-20 rounded-full shadow-md"
                                        >
                                    @else
                                        <div class="w-20 h-20 flex justify-center items-center bg-gray-600 rounded-full shadow-md">
                                            {{-- Googleマテリアルアイコン --}}
                                            <span class="material-symbols-outlined text-3xl text-white rounded-full">
                                                person
                                            </span>
                                        </div>
                                    @endisset
                                    {{-- アーティスト名 --}}
                                    <p class="ml-4 font-semibold text-gray-900 dark:text-white">{{ $spotify_artist['name'] }}</p>
                                </div>
                                {{-- 削除 --}}
                                <form method="POST" action="{{ route('spotify.detach', $spotify_artist['id']) }}">
                                    @csrf
                                    @method('delete')
                                    <x-primary-button
                                        type="submit"
                                        class="ml-4 min-w-16 flex justify-center bg-red-500 shadow-md"
                                        onclick="return confirm('本当に削除しますか？')"
                                    >削除</x-primary-button>
                                </form>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endisset

            {{-- カスタムアーティスト --}}
            <div class="mt-32">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">好きなアーティストがSpotifyに登録されていない場合はこちら</h2>
                <div class="mt-4 p-4 bg-white rounded-3xl shadow-inner">
                    <h3 class="font-semibold text-xl text-gray-900 dark:text-white">アーティストの追加方法</h3>
                    <ol class="ml-5 list-decimal list-outside">
                        <li class="mt-4 text-gray-900 dark:text-white">下の入力フォームに好きなアーティスト名を入力</li>
                        <li class="mt-4 text-gray-900 dark:text-white">あとは<strong>リストに追加</strong>ボタンをクリックするだけ！</li>
                    </ol>
                </div>
            </div>
            {{-- アーティスト追加フォーム全体 --}}
            <div class="flex flex-col mt-8 w-full flex justify-center">
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
                                placeholder="アーティスト名を入力して追加"
                                value="{{ old('name') }}"
                                class="w-64 rounded shadow-md"
                            />
                            {{-- エラーメッセージを表示する --}}
                            <x-input-error :messages="$errors->get('name')" class="" />
                        </div>
                        {{-- 送信ボタン --}}
                        <x-primary-button class="ml-2 max-h-10 shadow-md">リストに追加</x-primary-button>
                    </div>
                </form>
                <p class="mt-2 text-xs text-gray-900 dark:text-white">※<strong>リストに追加</strong>ボタンをクリックするとすぐに追加されます。</p>
            </div>

            {{-- カスタムアーティストが存在する場合 --}}
            @isset($artists)
                {{-- カスタムアーティスト一覧を表示 --}}
                <div class="mt-8 w-full">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">アーティストリスト（手動）</h3>
                    @foreach ($artists as $artist)
                        <div class="mt-4 w-full scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex">
                            <div class="flex w-full items-center justify-between">
                                {{-- アーティスト情報全体 --}}
                                <div class="flex items-center">
                                    {{-- アーティスト画像 --}}
                                    <div class="min-w-20 w-20 h-20 flex justify-center items-center bg-gray-600 rounded-full shadow-md">
                                        {{-- Googleマテリアルアイコン --}}
                                        <span class="material-symbols-outlined text-3xl text-white rounded-full">
                                            person
                                        </span>
                                    </div>
                                    {{-- アーティスト名 --}}
                                    <p class="ml-4 font-semibold text-gray-900 dark:text-white">{{ $artist->name }}</p>
                                </div>
                                {{-- もし削除権限がある場合に表示する --}}
                                @if ($artist->users->contains(auth()->user()))
                                    <form method="POST" action="{{ route('artists.detach', $artist) }}">
                                        @csrf
                                        @method('delete')
                                        <x-primary-button
                                            type="submit"
                                            class="ml-4 min-w-16 flex justify-center bg-red-500 shadow-md"
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
