<x-app-layout>
    {{-- アーティスト一覧を表示 --}}
    <div class="">
        @foreach ($artists as $artist)
            <div class="">
                <p class="">{{ $artist->name }}</p>
            </div>
        @endforeach
        {{-- ページネーション --}}
        <div class="paginate">{{ $artists->links() }}</div>
    </div>
</x-app-layout>
