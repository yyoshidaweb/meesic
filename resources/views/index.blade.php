<x-app-layout>
    <div class="flex flex-col relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="w-96 mx-auto p-6 lg:p-8">
            <div class="flex flex-col justify-center items-center">
                {{-- ロゴ --}}
                <p class="text-lg font-semibold text-gray-600 dark:text-gray-400">
                    好きな音楽をまとめよう
                </p>
                <a href="/" class="mt-4 text-7xl font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    Meesic
                </a>
            </div>
            {{-- 各ボタン全体 --}}
            <div class="mt-8">
                <div class="flex flex-col items-center">
                    {{-- 新規登録ボタン --}}
                    <a href="{{ route('register') }}" class="w-full mt-4 scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                        <div class="flex w-full items-center justify-center">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">新規登録</h2>
                        </div>
                    </a>
                    <p class="mt-2 text-xs text-gray-900 dark:text-white">※登録無料 / 広告なし</p>
                    {{-- ゲストログインボタン --}}
                    <a href="{{ route('guest.register') }}" class="mt-4 w-full scale-100 p-6 bg-gray-800/50  rounded-lg shadow-md flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                        <div class="flex w-full items-center justify-center">
                            <h2 class="text-xl font-semibold text-white">ゲストログイン</h2>
                        </div>
                    </a>
                    <p class="mt-2 text-xs text-gray-900 dark:text-white">※ゲストログイン中のデータは保存されません</p>
                </div>
            </div>
        </div>
        {{-- Meesicの説明文 --}}
        <div class="w-full mt-8 px-6 py-40 flex flex-col items-center bg-white rounded-xl">
            <div class="w-96">
                <div class="flex items-end">
                    <h2 class="text-5xl font-semibold text-gray-600 dark:text-gray-400">
                        Meesic
                    </h2>
                    <p class="ml-1 font-semibold text-gray-600 dark:text-gray-400">とは？</p>
                </div>
                <div class="mt-8">
                    <p class="">あなたの好きなアーティストを簡単にまとめるサービスです。</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
