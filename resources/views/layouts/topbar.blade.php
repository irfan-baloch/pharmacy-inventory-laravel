<header
    class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between"
>
    <h2 class="text-lg md:text-xl font-semibold text-gray-800">
        @yield('page_title', 'Dashboard')
    </h2>
    <div class="flex items-center gap-3">
        <a
            href="{{ route('sales.create') }}"
            class="hidden sm:flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
        >
            <span>+</span>
            <span>Quick Sale</span>
        </a>
        <a
            href="{{ route('profile.edit') }}"
            class="flex items-center gap-2 text-gray-600 hover:text-gray-900"
        >
            <div
                class="w-8 h-8 rounded-full bg-slate-600 flex items-center justify-center text-white text-sm font-bold"
            >
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span class="hidden md:inline text-sm"
                >{{ auth()->user()->name }}</span
            >
        </a>
    </div>
</header>
