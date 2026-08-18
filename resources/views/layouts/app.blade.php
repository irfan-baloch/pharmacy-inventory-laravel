<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💊</text></svg>">
        <meta name="description" content="Pharmacy Inventory Management System - Track medicines, batches, expiry, and sales">
        <meta name="theme-color" content="#059669">
        <title>@yield('title', 'Dashboard') | {{ \App\Models\Setting::getValue('pharmacy_name', 'PharmaStock') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap"
            rel="stylesheet"
            
        />
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @media print {
                .no-print { display: none !important; }
                body { background: white; }
                .shadow { box-shadow: none !important; }
                .min-h-screen { min-height: auto !important; }
                .flex-col.md\\:flex-row { display: block !important; }
                aside { display: none !important; }
                header { display: none !important; }
                main { margin: 0 !important; padding: 0 !important; }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col md:flex-row">
            @include('layouts.sidebar')
            <div class="flex-1 flex flex-col min-w-0">
                @include('layouts.topbar') @if(session('success'))
                <div
                    class="mx-4 mt-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700  rounded"
                >
                    {{ session('success') }}
                </div>
                @endif @if(session('error'))
                <div
                    class="mx-4 mt-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded"
                >
                    {{ session('error') }}
                </div>
                @endif
                <main class="flex-1 p-4 md:p-6 overflow-x-hidden">
                    @yield('content')
                </main>
                <footer
                    class="bg-white border-t px-4 py-3 text-xs text-gray-500 text-center"
                >
                    Pharmacy Inventory System &copy; {{ date('Y') }}
                </footer>
            </div>
        </div>
    </body>
</html>
