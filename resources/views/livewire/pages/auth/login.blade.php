<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white mb-1">Welcome Back</h2>
        <p class="text-slate-400 text-sm">Sign in to your pharmacy dashboard</p>
    </div>

    @if (session('status'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login" class="space-y-5">
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                <input wire:model="form.email" type="email" required autofocus autocomplete="username"
                    class="input-glow w-full pl-12 pr-4 py-3.5 rounded-xl text-sm"
                    placeholder="admin@pharma.com">
            </div>
            @error('form.email')
                <p class="text-red-400 text-xs mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <input wire:model="form.password" type="password" required autocomplete="current-password"
                    class="input-glow w-full pl-12 pr-4 py-3.5 rounded-xl text-sm"
                    placeholder="••••••••">
            </div>
            @error('form.password')
                <p class="text-red-400 text-xs mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input wire:model="form.remember" type="checkbox" 
                    class="w-5 h-5 rounded-lg border-slate-600 bg-slate-800/50 text-emerald-500 focus:ring-emerald-500/20">
                <span class="text-sm text-slate-400">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate
                    class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors font-medium">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-glow w-full py-3.5 rounded-xl font-bold text-white shadow-lg text-sm tracking-wide">
            Sign In to Dashboard
        </button>
    </form>

    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-white/10"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="px-4 text-slate-500 bg-[#131c2e]">New here?</span>
        </div>
    </div>

    <a href="{{ route('register') }}" wire:navigate 
        class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl border border-slate-700 hover:border-emerald-500/30 text-slate-300 hover:text-emerald-400 font-medium text-sm transition-all hover:bg-emerald-500/5">
        <span>Create an Account</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
    </a>
</div>