@extends('layouts.app')

@section('title', 'Profile')
@section('page_title', 'My Profile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-1">Profile Information</h2>
        <p class="text-sm text-gray-500 mb-6">Update your account's profile information and email address.</p>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('email') border-red-500 @enderror">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                    Save Changes
                </button>
                @if(session('success'))
                    <span class="text-emerald-600 text-sm">{{ session('success') }}</span>
                @endif
            </div>
        </form>
    </div>

    {{-- Delete Account --}}
    <div class="bg-white rounded-lg shadow p-6 border border-red-100">
        <h2 class="text-xl font-bold text-red-600 mb-1">Delete Account</h2>
        <p class="text-sm text-gray-500 mb-6">Once your account is deleted, all of its resources and data will be permanently deleted.</p>

        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                    placeholder="Enter password to confirm">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                Delete Account
            </button>
        </form>
    </div>
</div>
@endsection