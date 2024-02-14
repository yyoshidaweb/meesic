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
                <textarea
                    name="message"
                    placeholder="アーティスト名を入力してください"
                    class=""
                >{{ old('message') }}</textarea>
                {{-- エラーメッセージを表示する --}}
                <x-input-error :messages="$errors->get('message')" class="" />
                {{-- 送信ボタン --}}
                <x-primary-button class="">アーティストを追加</x-primary-button>
            </label>
        </form>
    </div>
</x-app-layout>
