<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16">
            <div class="flex w-full justify-between">
                {{-- ロゴ(未ログインユーザーにも表示) --}}
                <div class="shrink-0 flex items-center">
                    <a href="/" class="text-xl font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        Meesic
                    </a>
                    {{-- ゲストユーザーのみに表示 --}}
                    @can('guest-higher')
                        <div class="ml-4 p-1 rounded-lg bg-gray-800/50">
                            <p class=" font-semibold text-white">ゲストユーザーとしてログイン中</p>
                        </div>
                    @endcan
                </div>


                {{-- ナビゲーション(ログイン済ユーザーにのみ表示) --}}
                @auth
                    <div class="hidden space-x-8  sm:-my-px sm:ms-10 sm:flex">
                        {{-- ダッシュボードへのリンク --}}
                        <x-nav-link
                            :href="route('dashboard')"
                            :active="request()->routeIs('dashboard')"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                        >{{ __('Dashboard') }}</x-nav-link>
                        {{-- アーティストリストへのリンク --}}
                        <x-nav-link
                            :href="route('artists.index', ['url_name' => Auth::user()->url_name])"
                            :active="request()->routeIs('artists.index')"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                        >ホーム</x-nav-link>
                        {{-- アーティストリスト編集ページへのリンク --}}
                        <x-nav-link
                            :href="route('artists.editArtists')"
                            :active="request()->routeIs('artists.editArtists')"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                        >編集</x-nav-link>
                    </div>
                @else
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        {{-- ログインボタン --}}
                        <x-nav-link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                            ログイン
                        </x-nav-link>
                        @if (Route::has('register'))
                            {{-- 新規登録ボタン --}}
                            <x-nav-link :href="route('register')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                新規登録
                            </x-nav-link>
                        @endif
                    </div>
                @endauth
            </div>

            {{-- アカウント設定用ドロップダウン(ログイン済ユーザーのみ表示) --}}
            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            {{-- ここからモバイル向けナビゲーション --}}

            {{-- ハンバーガーメニュー(全てのユーザーのみに表示) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- モバイル向けナビゲーション(ログイン済ユーザーのみに表示) --}}
    @auth
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                {{-- モバイル向けアーティストリストページへのリンク --}}
                <x-responsive-nav-link :href="route('artists.index', ['url_name' => Auth::user()->url_name])" :active="request()->routeIs('artists.index')">
                    ホーム
                </x-responsive-nav-link>
                {{-- アーティストリスト編集ページへのリンク --}}
                <x-responsive-nav-link :href="route('artists.editArtists')" :active="request()->routeIs('artists.editArtists')">
                    編集
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                {{-- ログイン --}}
                <x-responsive-nav-link :href="route('login')">
                    ログイン
                </x-responsive-nav-link>
                {{-- 新規登録 --}}
                <x-responsive-nav-link :href="route('register')">
                    新規登録
                </x-responsive-nav-link>
                {{-- アーティストリスト編集ページへのリンク --}}
            </div>
        </div>
    @endauth
</nav>
