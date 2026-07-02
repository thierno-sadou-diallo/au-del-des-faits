<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="admin-kicker">Gestion</p>
                <h1 class="mt-1 text-3xl font-semibold text-white">Abonnés Newsletter</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-200">Gérez et suivez les abonnés à votre newsletter.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.newsletter-subscribers.export') }}" class="rounded-xl border border-amber-300/40 bg-amber-300/15 px-4 py-2 text-sm font-black text-amber-100 transition hover:bg-amber-300/25">
                    <i class="fas fa-download me-2"></i>Exporter CSV
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Statistiques -->
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Total d'abonnés</p>
                        <p class="mt-2 text-3xl font-black text-slate-950">{{ $count }}</p>
                    </div>
                    <div class="text-5xl text-amber-400 opacity-20">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Inscriptions ce mois</p>
                        <p class="mt-2 text-3xl font-black text-slate-950">{{ $countThisMonth }}</p>
                    </div>
                    <div class="text-5xl text-emerald-400 opacity-20">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="GET" class="space-y-4">
                <div class="flex flex-col gap-4 sm:flex-row">
                    <div class="flex-1">
                        <input type="text" name="search" placeholder="Rechercher par email..." value="{{ request('search') }}" 
                               class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
                    </div>
                    <select name="sort" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-900 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>
                            Trier par: Date
                        </option>
                        <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>
                            Trier par: Email (A-Z)
                        </option>
                    </select>
                    <select name="order" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-900 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
                        <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>
                            Plus récent
                        </option>
                        <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>
                            Plus ancien
                        </option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Liste des abonnés -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            @if($subscribers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-slate-200 bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left">
                                    <input type="checkbox" class="h-4 w-4 rounded border-slate-300" id="select-all">
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Date d'inscription</th>
                                <th class="px-6 py-4 text-right text-sm font-semibold text-slate-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($subscribers as $subscriber)
                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" class="subscriber-checkbox h-4 w-4 rounded border-slate-300" value="{{ $subscriber->id }}">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-amber-400 to-amber-600 text-sm font-bold text-white">
                                                {{ strtoupper(substr($subscriber->email, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-slate-900">{{ $subscriber->email }}</p>
                                                <p class="text-xs text-slate-500">ID: #{{ $subscriber->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600">
                                            <p>{{ $subscriber->created_at->locale('fr')->diffForHumans() }}</p>
                                            <p class="text-xs text-slate-500">{{ $subscriber->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}" method="POST" style="display: inline;" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet abonné ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="border-t border-slate-200 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-600">
                            Affichage {{ $subscribers->firstItem() }} à {{ $subscribers->lastItem() }} 
                            sur {{ $subscribers->total() }} abonnés
                        </p>
                        <div class="flex gap-2">
                            {{ $subscribers->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="py-12 text-center">
                    <div class="text-5xl text-slate-300 opacity-50 mb-4">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Aucun abonné trouvé</p>
                </div>
            @endif
        </div>

        <!-- Barre d'actions groupées -->
        @if($subscribers->count() > 0)
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hidden" id="bulk-actions">
                <form action="{{ route('admin.newsletter-subscribers.destroy-multiple') }}" method="POST" 
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer les abonnés sélectionnés ?');">
                    @csrf
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-sm font-medium text-slate-900">
                            <span id="selected-count">0</span> abonné(s) sélectionné(s)
                        </p>
                        <div id="ids-container"></div>
                        <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
                            <i class="fas fa-trash-alt me-2"></i>Supprimer la sélection
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.subscriber-checkbox');
        const bulkActions = document.getElementById('bulk-actions');
        const selectedCount = document.getElementById('selected-count');
        const idsContainer = document.getElementById('ids-container');

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActions();
            });
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkActions();
                
                if (selectAll) {
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    selectAll.checked = allChecked;
                    selectAll.indeterminate = anyChecked && !allChecked;
                }
            });
        });

        function updateBulkActions() {
            const selected = Array.from(checkboxes).filter(cb => cb.checked);
            const selectedIds = selected.map(cb => cb.value);

            if (selectedIds.length > 0) {
                bulkActions.classList.remove('hidden');
                selectedCount.textContent = selectedIds.length;
                
                idsContainer.innerHTML = selectedIds
                    .map(id => `<input type="hidden" name="ids[]" value="${id}">`)
                    .join('');
            } else {
                bulkActions.classList.add('hidden');
            }
        }
    });
    </script>
    @endpush
</x-app-layout>
