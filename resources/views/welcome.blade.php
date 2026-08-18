<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ \App\Models\Setting::getValue('pharmacy_name', 'PharmaStock') }} — Smart Pharmacy Inventory System</title>
    <meta name="description" content="Modern pharmacy inventory management with FIFO logic, batch tracking, expiry alerts, and sales reporting.">
    
    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: { 450: '#10b981' },
                        slate: { 950: '#020617', 900: '#0f172a' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes float-delayed {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float-delayed 7s ease-in-out 1s infinite; }
        .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
        .animate-pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }
        
        .gradient-text {
            background: linear-gradient(135deg, #34d399 0%, #2dd4bf 40%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .hero-glow {
            background: 
                radial-gradient(ellipse 80% 50% at 50% -10%, rgba(16, 185, 129, 0.12), transparent),
                radial-gradient(ellipse 50% 40% at 85% 85%, rgba(45, 212, 191, 0.06), transparent);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px -10px rgba(16, 185, 129, 0.5);
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(16, 185, 129, 0.3);
        }
        
        .step-arrow::after {
            content: '';
            position: absolute;
            top: 2rem;
            right: -50%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, rgba(16,185,129,0.5), transparent);
        }
        @media (max-width: 768px) {
            .step-arrow::after { display: none; }
        }
    </style>
</head>
<body class="bg-slate-950 text-white antialiased overflow-x-hidden">

    {{-- Navbar --}}
    <nav class="fixed top-0 w-full z-50 border-b border-white/5 bg-slate-950/90 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-lg shadow-lg shadow-emerald-500/20">
                        💊
                    </div>
                    <span class="font-bold text-xl tracking-tight">{{ \App\Models\Setting::getValue('pharmacy_name', 'Pharma') }}<span class="text-emerald-400"> Stock</span></span>
                </div>
                
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm text-slate-400 hover:text-white transition-colors">Features</a>
                    <a href="#how-it-works" class="text-sm text-slate-400 hover:text-white transition-colors">How It Works</a>
                    <a href="#tech" class="text-sm text-slate-400 hover:text-white transition-colors">Tech Stack</a>
                </div>
                
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm text-slate-300 hover:text-white transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:block text-sm text-slate-300 hover:text-white transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-primary text-white px-5 py-2 rounded-lg text-sm font-semibold">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 lg:pt-44 lg:pb-28 hero-glow overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl animate-float pointer-events-none"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl animate-float-delayed pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto animate-fade-in-up">
                
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium mb-8">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse-dot"></span>
                    Laravel 12 + Tailwind CSS
                </div>

                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 leading-tight text-white">
                    Manage Your Pharmacy<br>
                    <span class="gradient-text">Like a Pro</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Intelligent inventory system with <span class="text-emerald-400 font-semibold">FIFO logic</span>, 
                    batch tracking, expiry alerts, and real-time sales reporting — 
                    built for modern pharmacies.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('register') }}" class="btn-primary text-white px-8 py-4 rounded-xl font-bold text-lg flex items-center gap-2">
                        Start Free Trial
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 border border-slate-700 hover:border-slate-500 text-slate-300 hover:text-white rounded-xl font-bold text-lg transition-all">
                        Login to System
                    </a>
                </div>

                <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto">
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <div class="text-2xl font-bold text-emerald-400 mb-1">100%</div>
                        <div class="text-xs text-slate-500 uppercase tracking-wider font-medium">FIFO Accurate</div>
                    </div>
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <div class="text-2xl font-bold text-teal-400 mb-1">Real-time</div>
                        <div class="text-xs text-slate-500 uppercase tracking-wider font-medium">Stock Updates</div>
                    </div>
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <div class="text-2xl font-bold text-blue-400 mb-1">Role</div>
                        <div class="text-xs text-slate-500 uppercase tracking-wider font-medium">Based Access</div>
                    </div>
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <div class="text-2xl font-bold text-purple-400 mb-1">Smart</div>
                        <div class="text-xs text-slate-500 uppercase tracking-wider font-medium">Expiry Alerts</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Grid --}}
    <section id="features" class="py-20 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Everything You Need</h2>
                <p class="text-slate-400 max-w-2xl mx-auto">A complete pharmacy management solution designed to save time, reduce waste, and increase efficiency.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="feature-card p-7 rounded-2xl bg-slate-900/80 border border-slate-800">
                    <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center text-2xl mb-5">📦</div>
                    <h3 class="text-lg font-bold mb-2 text-white">Batch Tracking</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Track every medicine batch with unique IDs, expiry dates, suppliers, and purchase history.</p>
                </div>

                <div class="feature-card p-7 rounded-2xl bg-slate-900/80 border border-slate-800">
                    <div class="w-12 h-12 bg-teal-500/10 rounded-xl flex items-center justify-center text-2xl mb-5">⚡</div>
                    <h3 class="text-lg font-bold mb-2 text-white">FIFO Sales Logic</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Automatic First-In-First-Out deduction ensures oldest stock sells first, minimizing waste.</p>
                </div>

                <div class="feature-card p-7 rounded-2xl bg-slate-900/80 border border-slate-800">
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-2xl mb-5">⏰</div>
                    <h3 class="text-lg font-bold mb-2 text-white">Expiry Monitoring</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Get instant alerts for medicines expiring soon. Color-coded status indicators.</p>
                </div>

                <div class="feature-card p-7 rounded-2xl bg-slate-900/80 border border-slate-800">
                    <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center text-2xl mb-5">📊</div>
                    <h3 class="text-lg font-bold mb-2 text-white">Smart Reports</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Generate stock, expiry, and sales reports with date range filters and summaries.</p>
                </div>

                <div class="feature-card p-7 rounded-2xl bg-slate-900/80 border border-slate-800">
                    <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center text-2xl mb-5">🔔</div>
                    <h3 class="text-lg font-bold mb-2 text-white">Low Stock Alerts</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Set custom thresholds and get notified when inventory runs low automatically.</p>
                </div>

                <div class="feature-card p-7 rounded-2xl bg-slate-900/80 border border-slate-800">
                    <div class="w-12 h-12 bg-rose-500/10 rounded-xl flex items-center justify-center text-2xl mb-5">🔒</div>
                    <h3 class="text-lg font-bold mb-2 text-white">Role-Based Access</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Admin gets full control, Staff gets sales access. Secure middleware protection.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="how-it-works" class="py-20 bg-slate-900/50 border-y border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">How It Works</h2>
                <p class="text-slate-400">Simple 4-step workflow designed for busy pharmacies</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="relative text-center step-arrow">
                    <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-xl font-bold mx-auto mb-5 shadow-lg shadow-emerald-600/20 text-white">1</div>
                    <h4 class="font-bold text-lg mb-2 text-white">Add Medicine</h4>
                    <p class="text-sm text-slate-400">Create medicine profiles with categories, pricing, and packaging details.</p>
                </div>
                <div class="relative text-center step-arrow">
                    <div class="w-14 h-14 bg-teal-600 rounded-2xl flex items-center justify-center text-xl font-bold mx-auto mb-5 shadow-lg shadow-teal-600/20 text-white">2</div>
                    <h4 class="font-bold text-lg mb-2 text-white">Stock In</h4>
                    <p class="text-sm text-slate-400">Record purchases with batch numbers, expiry dates, and suppliers.</p>
                </div>
                <div class="relative text-center step-arrow">
                    <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-xl font-bold mx-auto mb-5 shadow-lg shadow-blue-600/20 text-white">3</div>
                    <h4 class="font-bold text-lg mb-2 text-white">Sell (FIFO)</h4>
                    <p class="text-sm text-slate-400">Process sales with automatic batch deduction using FIFO logic.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-purple-600 rounded-2xl flex items-center justify-center text-xl font-bold mx-auto mb-5 shadow-lg shadow-purple-600/20 text-white">4</div>
                    <h4 class="font-bold text-lg mb-2 text-white">Analyze</h4>
                    <p class="text-sm text-slate-400">View reports, track expiry, and monitor stock levels in real-time.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Tech Stack --}}
    <section id="tech" class="py-20 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-12 text-white">Built With Modern Tech</h2>
            <div class="flex flex-wrap justify-center gap-3">
                <span class="px-5 py-2.5 rounded-full bg-slate-900 border border-slate-700 text-slate-300 font-medium text-sm hover:border-red-500/50 hover:text-red-400 transition-colors cursor-default">Laravel 12</span>
                <span class="px-5 py-2.5 rounded-full bg-slate-900 border border-slate-700 text-slate-300 font-medium text-sm hover:border-cyan-500/50 hover:text-cyan-400 transition-colors cursor-default">Tailwind CSS</span>
                <span class="px-5 py-2.5 rounded-full bg-slate-900 border border-slate-700 text-slate-300 font-medium text-sm hover:border-orange-500/50 hover:text-orange-400 transition-colors cursor-default">MySQL</span>
                <span class="px-5 py-2.5 rounded-full bg-slate-900 border border-slate-700 text-slate-300 font-medium text-sm hover:border-yellow-500/50 hover:text-yellow-400 transition-colors cursor-default">PHP 8.3</span>
                <span class="px-5 py-2.5 rounded-full bg-slate-900 border border-slate-700 text-slate-300 font-medium text-sm hover:border-blue-500/50 hover:text-blue-400 transition-colors cursor-default">Breeze Auth</span>
                <span class="px-5 py-2.5 rounded-full bg-slate-900 border border-slate-700 text-slate-300 font-medium text-sm hover:border-emerald-500/50 hover:text-emerald-400 transition-colors cursor-default">Alpine.js</span>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/30 to-teal-900/30"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold mb-6 text-white">Ready to Streamline<br>Your Pharmacy?</h2>
            <p class="text-slate-400 text-lg mb-10 max-w-xl mx-auto">Join pharmacies already using {{ \App\Models\Setting::getValue('pharmacy_name', 'PharmaStock') }} to manage inventory smarter, not harder.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-primary text-white px-8 py-4 rounded-xl font-bold text-lg">
                    Create Free Account
                </a>
                <a href="{{ route('login') }}" class="px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white rounded-xl font-bold text-lg transition-all">
                    Existing User Login
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-white/5 py-10 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="text-xl">💊</span>
                    <span class="font-bold text-lg text-white">{{ \App\Models\Setting::getValue('pharmacy_name', 'Pharma') }}<span class="text-emerald-400"> Stock</span></span>
                </div>
                <div class="text-slate-500 text-sm">
                    {{ \App\Models\Setting::getValue('pharmacy_name', 'PharmaStock') }} Inventory System © {{ date('Y') }} — Built with Laravel 12 & Tailwind CSS
                </div>
                <div class="flex gap-6 text-sm text-slate-500">
                    <span class="hover:text-emerald-400 cursor-pointer transition-colors">Privacy</span>
                    <span class="hover:text-emerald-400 cursor-pointer transition-colors">Terms</span>
                    <span class="hover:text-emerald-400 cursor-pointer transition-colors">Contact</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>