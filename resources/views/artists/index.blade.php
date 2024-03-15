<x-app-layout>
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
            @endforeach
        @endisset
        @foreach ($artists as $artist)
            <div class="">
                <p class="">{{ $artist->name }}</p>
            </div>
        @endforeach
        {{-- ページネーション --}}
        <div class="paginate">{{ $artists->links() }}</div>
    </div>
</x-app-layout>
