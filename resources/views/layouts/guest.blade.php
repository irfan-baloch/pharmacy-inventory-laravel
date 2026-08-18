<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Auth' }} | {{ \App\Models\Setting::getValue('pharmacy_name', 'PharmaStock') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { 
            background: #020617; 
            color: white;
            overflow-x: hidden; /* Sirf horizontal scroll band */
        }
        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .input-glow {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            transition: all 0.3s ease;
        }
        .input-glow:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16,185,129,0.15), 0 0 20px rgba(16,185,129,0.1);
        }
        .input-glow::placeholder { color: #64748b; }
        
        .btn-glow {
            background: linear-gradient(135deg, #059669, #0d9488);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px -10px rgba(16,185,129,0.6);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes float-delayed {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float-delayed 7s ease-in-out 1s infinite; }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-white relative">

    {{-- Background blobs --}}
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl animate-float-delayed"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4 py-12">
        
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-xl shadow-emerald-500/20">
                💊
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight">
                {{ \App\Models\Setting::getValue('pharmacy_name', 'Pharma') }}<span class="text-emerald-400"> Stock</span>
            </h1>
            <p class="text-slate-400 text-sm mt-2">Smart Pharmacy Inventory System</p>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-md">
            <div class="glass rounded-3xl p-8 md:p-10 shadow-2xl">
                {{ $slot }}
            </div>
        </div>

        {{-- Back Link --}}
        <div class="mt-8">
            <a href="/" class="text-sm text-slate-500 hover:text-emerald-400 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to home
            </a>
        </div>
    </div>

</body>
</html>