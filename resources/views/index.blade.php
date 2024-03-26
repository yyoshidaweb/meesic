<x-app-layout>
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                {{-- ロゴ --}}
                <a href="/" class="text-5xl font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    Meesic
                </a>
            </div>

            <div class="mt-24">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <a href="{{ route('login') }}" class="scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                        <div class="flex w-full items-center justify-center">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">ログイン</h2>
                        </div>
                    </a>

                    <a href="{{ route('register') }}" class="scale-100 bg-white p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-md dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                        <div class="flex w-full items-center justify-center">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">新規登録</h2>
                        </div>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
