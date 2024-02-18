<x-app-layout>
    {{-- アーティスト追加フォーム全体 --}}
    <div class="">
        {{-- POSTリクエストでstoreメソッドを使用 --}}
        <form method="POST" action="{{ route('artists.store') }}">
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

        {{-- アーティスト一覧を表示 --}}
        <div class="">
            @foreach ($artists as $artist)
                <div class="">
                    <p class="">{{ $artist->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
