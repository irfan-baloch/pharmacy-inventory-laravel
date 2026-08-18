<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'staff';

        event(new Registered($user = User::create($validated)));
        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white mb-1">Get Started</h2>
        <p class="text-slate-400 text-sm">Create your pharmacy account</p>
    </div>

    <form wire:submit="register" class="space-y-4">
        <!-- Name -->
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Full Name</label>
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <input wire:model="name" type="text" required autofocus autocomplete="name"
                    class="input-glow w-full pl-12 pr-4 py-3.5 rounded-xl text-sm"
                    placeholder="Ali Ahmed">
            </div>
            @error('name')
                <p class="text-red-400 text-xs mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                <input wire:model="email" type="email" required autocomplete="username"
                    class="input-glow w-full pl-12 pr-4 py-3.5 rounded-xl text-sm"
                    placeholder="ali@medicalstore.com">
            </div>
            @error('email')
                <p class="text-red-400 text-xs mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <input wire:model="password" type="password" required autocomplete="new-password"
                    class="input-glow w-full pl-12 pr-4 py-3.5 rounded-xl text-sm"
                    placeholder="••••••••">
            </div>
            @error('password')
                <p class="text-red-400 text-xs mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Confirm Password</label>
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <input wire:model="password_confirmation" type="password" required autocomplete="new-password"
                    class="input-glow w-full pl-12 pr-4 py-3.5 rounded-xl text-sm"
                    placeholder="••••••••">
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-glow w-full py-3.5 rounded-xl font-bold text-white shadow-lg text-sm tracking-wide mt-2">
            Create Account
        </button>
    </form>

    <!-- Divider -->
    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-white/10"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="px-4 text-slate-500 bg-[#131c2e]">Already have an account?</span>
        </div>
    </div>

    <!-- Login Link -->
    <a href="{{ route('login') }}" wire:navigate 
        class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl border border-slate-700 hover:border-emerald-500/30 text-slate-300 hover:text-emerald-400 font-medium text-sm transition-all hover:bg-emerald-500/5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
        <span>Sign In Instead</span>
    </a>
</div>