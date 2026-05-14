<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-teal-600">Media</p>
            <h1 class="text-2xl font-semibold text-slate-950">Publier un media ou projet</h1>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.portfolios.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @include('admin.portfolio.partials.form')
        </form>
    </div>
</x-app-layout>
