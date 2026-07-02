<nav x-data="{ open: false, openNotifications: false }" class="admin-topbar sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
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
                    <x-nav-link :href="route('admin.appointments.index')" :active="request()->routeIs('admin.appointments.*')">
                        Rendez-vous
                    </x-nav-link>
                    <x-nav-link :href="route('admin.availability-slots.index')" :active="request()->routeIs('admin.availability-slots.*')">
                        Créneaux
                    </x-nav-link>
                    <x-nav-link :href="route('admin.comments.index')" :active="request()->routeIs('admin.comments.*')">
                        Commentaires
                    </x-nav-link>
                    <x-nav-link :href="route('admin.service-reviews.index')" :active="request()->routeIs('admin.service-reviews.*')">
                        Avis
                    </x-nav-link>
                    <x-nav-link :href="route('admin.newsletter-subscribers.index')" :active="request()->routeIs('admin.newsletter-subscribers.*')">
                        Abonnés
                    </x-nav-link>
                    <x-nav-link :href="route('admin.posts.index')" :active="request()->routeIs('admin.posts.*')">
                        Articles
                    </x-nav-link>
                    <x-nav-link :href="route('admin.portfolios.index')" :active="request()->routeIs('admin.portfolios.*')">
                        Médias
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('home') }}" class="mr-4 rounded-full border border-amber-200 bg-white/70 px-4 py-2 text-sm font-bold text-slate-700 shadow-sm transition hover:border-amber-400 hover:text-amber-800">Voir le site</a>
                @php
                    $pendingAppointmentCount = \App\Models\Appointment::where('status', 'pending')->count();
                    $latestPendingAppointments = \App\Models\Appointment::with('availabilitySlot')
                        ->where('status', 'pending')
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp
                <div class="relative me-4">
                    <button @click="openNotifications = ! openNotifications" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-slate-300 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-300">
                        <span class="sr-only">Notifications</span>
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8c0-3.31-2.69-6-6-6S6 4.69 6 8c0 7-3 8-3 8h18s-3-1-3-8"></path>
                            <path d="M13.73 21a2 2 0 01-3.46 0"></path>
                        </svg>
                        @if($pendingAppointmentCount)
                            <span class="absolute -top-1 -end-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-rose-600 px-1.5 text-[0.65rem] font-semibold text-white shadow-sm">{{ $pendingAppointmentCount > 99 ? '99+' : $pendingAppointmentCount }}</span>
                        @endif
                    </button>
                    <div x-show="openNotifications" x-cloak @click.away="openNotifications = false" class="absolute end-0 z-50 mt-2 w-96 origin-top-right overflow-hidden rounded-3xl border border-slate-200 bg-white p-4 shadow-2xl">
                        <div class="mb-3 flex items-center justify-between border-b border-slate-200 pb-3">
                            <span class="font-semibold text-slate-900">Demandes de rendez-vous</span>
                            <span class="rounded-full bg-rose-50 px-2.5 py-1 text-xs font-black text-rose-700">{{ $pendingAppointmentCount }} en attente</span>
                        </div>
                        @if($latestPendingAppointments->isEmpty())
                            <p class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-500">Aucune demande en attente.</p>
                        @else
                            <ul class="space-y-2">
                                @foreach($latestPendingAppointments as $appointment)
                                    <li>
                                        <a href="{{ route('admin.appointments.show', $appointment) }}" class="block rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-800 transition hover:border-amber-300 hover:bg-amber-50">
                                            <div class="flex items-start justify-between gap-3">
                                                <strong class="text-slate-950">{{ $appointment->name }}</strong>
                                                <span class="shrink-0 text-[0.68rem] font-bold text-slate-500">{{ $appointment->created_at->diffForHumans(null, true) }}</span>
                                            </div>
                                            <p class="mt-1 text-xs font-semibold text-slate-500">{{ \Illuminate\Support\Str::limit($appointment->subject, 58) }}</p>
                                            @if($appointment->availabilitySlot)
                                                <p class="mt-1 text-xs text-slate-500">{{ $appointment->availabilitySlot->start_time->format('d/m/Y H:i') }}</p>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('admin.appointments.index') }}" class="mt-3 block rounded-xl bg-slate-950 px-4 py-2 text-center text-sm font-black text-white hover:bg-teal-700">Voir toutes les demandes</a>
                        @endif
                    </div>
                </div>
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

                    </x-slot>
                </x-dropdown>

                <form method="POST" action="{{ route('logout') }}" class="ms-3">
                    @csrf
                    <button type="submit" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-red-200 bg-red-50 text-red-700 shadow-sm transition hover:border-red-300 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-200" title="Déconnexion" aria-label="Déconnexion">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H9.75m0 0l3-3m-3 3l3 3" />
                        </svg>
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
                <x-responsive-nav-link :href="route('admin.appointments.index')" :active="request()->routeIs('admin.appointments.*')">
                    Rendez-vous
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.availability-slots.index')" :active="request()->routeIs('admin.availability-slots.*')">
                    Créneaux
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.comments.index')" :active="request()->routeIs('admin.comments.*')">
                    Commentaires
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.service-reviews.index')" :active="request()->routeIs('admin.service-reviews.*')">
                    Avis
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.newsletter-subscribers.index')" :active="request()->routeIs('admin.newsletter-subscribers.*')">
                    Abonnés
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.posts.index')" :active="request()->routeIs('admin.posts.*')">
                    Articles
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.portfolios.index')" :active="request()->routeIs('admin.portfolios.*')">
                    Médias
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

                    <button type="submit" class="flex w-full items-center gap-3 border-l-4 border-transparent py-2 pe-4 ps-3 text-start text-base font-medium text-slate-600 transition duration-150 ease-in-out hover:border-red-300 hover:bg-red-50 hover:text-red-700 focus:border-red-300 focus:bg-red-50 focus:text-red-700 focus:outline-none" aria-label="Déconnexion">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H9.75m0 0l3-3m-3 3l3 3" />
                        </svg>
                        <span class="sr-only">Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
