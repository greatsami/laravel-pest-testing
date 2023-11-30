<x-layouts.app>
    <x-slot name="header">
        Sign in
    </x-slot>

    <form action="{{ route('login') }}" method="post" class="mt-4 space-y-4">
        @csrf
        <div class="space-y-1">
            <label for="email" class="block">Your email</label>
            <input type="text" name="email" id="name" placeholder="e.g. sami@gmail.com" class="rounded block w-full">
            @error('email')
            <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="password" class="block">Your password</label>
            <input type="password" name="password" id="password" placeholder="********" class="rounded block w-full">
            @error('password')
            <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-slate-200 px-3 py-2 rounded">
            Sign in
        </button>
    </form>
</x-layouts.app>
