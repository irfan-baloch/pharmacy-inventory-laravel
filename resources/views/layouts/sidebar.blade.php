<aside class="w-full md:w-64 bg-slate-800 text-white flex-shrink-0">
    <div class="h-full flex flex-col">
        <div class="p-4 border-b border-slate-700">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div
                    class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center font-bold text-white"
                >
                    {{ substr(\App\Models\Setting::getValue('pharmacy_name', 'PharmaStock'), 0, 1) }}

                </div>
                <div>
                    <h1 class="text-base font-bold">{{ \App\Models\Setting::getValue('pharmacy_name', 'PharmaStock') }}</h1>
                    <p class="text-xs text-slate-400">Inventory System</p>
                </div>
            </a>
        </div>
        <nav class="flex-1 overflow-y-auto p-3 space-y-1">
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{
request()->routeIs('dashboard') ? 'bg-emerald-600 text-white' : 'text-slate-300
hover:bg-slate-700 hover:text-white' }}"
            >
                <span class="text-lg">&#x229E;</span>
                <span>Dashboard</span>
            </a>
            <a
                href="{{ route('medicines.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{
request()->routeIs('medicines.*') ? 'bg-emerald-600 text-white' : 'text-slate-300
hover:bg-slate-700 hover:text-white' }}"
            >
                <span class="text-lg">&#x1F48A;</span>
                <span>Medicines</span>
            </a>
            <a
                href="{{ route('batches.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{
request()->routeIs('batches.*') ? 'bg-emerald-600 text-white' : 'text-slate-300
hover:bg-slate-700 hover:text-white' }}"
            >
                <span class="text-lg">&#x1F4E6;</span>
                <span>Batches & Stock</span>
            </a>
            <a
                href="{{ route('sales.create') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{
request()->routeIs('sales.*') ? 'bg-emerald-600 text-white' : 'text-slate-300
hover:bg-slate-700 hover:text-white' }}"
            >
                <span class="text-lg">&#x1F4B0;</span>
                <span>New Sale</span>
            </a>
            @if(auth()->user()->isAdmin())
            <div class="pt-4 mt-4 border-t border-slate-700">
                <p
                    class="px-3 text-xs font-semibold text-slate-500 uppercase mb-2"
                >
                    Admin
                </p>
                <a
                    href="{{ route('categories.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{
request()->routeIs('categories.*') ? 'bg-emerald-600 text-white' :
'text-slate-300 hover:bg-slate-700 hover:text-white' }}"
                >
                    <span class="text-lg">&#x1F3F7;</span>
                    <span>Categories</span>
                </a>
                <a
                    href="{{ route('suppliers.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{
request()->routeIs('suppliers.*') ? 'bg-emerald-600 text-white' :
'text-slate-300 hover:bg-slate-700 hover:text-white' }}"
                >
                    <span class="text-lg">&#x1F3ED;</span>
                    <span>Suppliers</span>
                </a>
                <a
                    href="{{ route('settings.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{
request()->routeIs('settings.*') ? 'bg-emerald-600 text-white' : 'text-slate-300
hover:bg-slate-700 hover:text-white' }}"
                >
                    <span class="text-lg">&#x2699;</span>
                    <span>Settings</span>
                </a>
            </div>
            @endif
            <div class="pt-4 mt-4 border-t border-slate-700">
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase mb-2">Reports</p>

                <a href="{{ route('reports.stock') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('reports.stock') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <span class="text-lg">&#x1F4CA;</span>
                    <span>Stock Report</span>
                </a>

                <a href="{{ route('reports.expiry') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('reports.expiry') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <span class="text-lg">&#x23F0;</span>
                    <span>Expiry Report</span>
                </a>

                <a href="{{ route('reports.sales') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('reports.sales') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <span class="text-lg">&#x1F4B8;</span>
                    <span>Sales Report</span>
                </a>
            </div>
        </nav>
        <div class="p-4 border-t border-slate-700">
            <div class="flex items-center gap-3 mb-3">
                <div
                    class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white text-sm font-bold"
                >
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-slate-400">
                        {{ auth()->user()->isAdmin() ? 'Admin' : 'Staff' }}
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm text-red-300 hover:bg-red-900/30 hover:text-red-200 transition-colors"
                >
                    <span>&#x1F6AA;</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
