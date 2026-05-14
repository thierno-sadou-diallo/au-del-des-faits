<nav x-data="{ open: false }" class="admin-topbar sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.PNG') }}" alt="Logo Au-dela des faits" class="h-10 w-10 rounded-xl object-cover shadow-lg shadow-slate-900/20">
                        <span class="hidden text-sm font-black text-slate-950 sm:block">Au-dela des faits Admin</span>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        Tableau de bord
                    </x-nav-link>
                    <x-nav-link :href="route('admin.posts.index')" :active="request()->routeIs('admin.posts.*')">
                        Articles
                    </x-nav-link>
                    <x-nav-link :href="route('admin.portfolios.index')" :active="request()->routeIs('admin.portfolios.*')">
                        Medias & portfolio
                    </x-nav-link>
                    <x-nav-link :href="route('admin.comments.index')" :active="request()->routeIs('admin.comments.*')">
                        Commentaires
                    </x-nav-link>
                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        Categories
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('home') }}" class="mr-4 rounded-full border border-amber-200 bg-white/70 px-4 py-2 text-sm font-bold text-slate-700 shadow-sm transition hover:border-amber-400 hover:text-amber-800">Voir le site</a>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium leading-4 text-slate-600 transition hover:border-slate-300 hover:text-slate-900 focus:outline-none">
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
                            Profil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-slate-700 transition duration-150 ease-in-out hover:bg-red-50 hover:text-red-700 focus:bg-red-50 focus:text-red-700 focus:outline-none">
                                Déconnexion
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>

                <form method="POST" action="{{ route('logout') }}" class="ms-3">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-bold text-red-700 shadow-sm transition hover:border-red-300 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-200">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H9.75m0 0l3-3m-3 3l3 3" />
                        </svg>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                Tableau de bord
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.posts.index')" :active="request()->routeIs('admin.posts.*')">
                Articles
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.portfolios.index')" :active="request()->routeIs('admin.portfolios.*')">
                Medias & portfolio
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.comments.index')" :active="request()->routeIs('admin.comments.*')">
                Commentaires
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                Categories
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('home')">
                Voir le site
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="block w-full border-l-4 border-transparent py-2 pe-4 ps-3 text-start text-base font-medium text-slate-600 transition duration-150 ease-in-out hover:border-red-300 hover:bg-red-50 hover:text-red-700 focus:border-red-300 focus:bg-red-50 focus:text-red-700 focus:outline-none">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
