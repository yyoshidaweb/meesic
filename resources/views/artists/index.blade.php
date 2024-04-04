<x-app-layout>
    {{-- アーティスト一覧の全体 --}}
    <div class="pb-8 flex flex-col items-center justify-center">
        <div class="mt-8 w-96 flex flex-col items-center justify-center font-semibold">
            {{-- ユーザー名 --}}
            <div class="">
                <p class="text-4xl text-gray-900 dark:text-white">{{ $user_name }}</p>
            </div>
            {{-- Spotify_artistsが存在する場合 --}}
            @isset($spotify_artists)
                <div class="mt-8 w-full">
                    {{-- Spotify上のアーティストを表示 --}}
                    @foreach ($spotify_artists as $spotify_artist)
                        <a href="{{ $spotify_artist['external_urls']['spotify'] }}" class="cursor-pointer mt-4 w-full scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div class="flex w-full items-center justify-center">
                                {{-- アーティスト名 --}}
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $spotify_artist['name'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endisset
            {{-- カスタムアーティストが存在する場合 --}}
            @isset($artists)
                <div class="w-full">
                    @foreach ($artists as $artist)
                        <div class="mt-4 w-full scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex">
                            <div class="flex w-full items-center justify-center">
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $artist->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- ページネーション --}}
                <div class="paginate">{{ $artists->links() }}</div>
            @endisset
        </div>
    </div>
</x-app-layout>
