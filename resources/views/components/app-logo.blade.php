@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="" href="{{ route('dashboard') }}" wire:navigate>
        <x-slot:logo>
            <img src="{{ asset('images/logo.jpeg') }}" alt="" class="h-8 w-auto">
        </x-slot:logo>
    </flux:sidebar.brand>
@else
    <flux:brand name="AGesp" href="{{ route('dashboard') }}" wire:navigate>
        <x-slot:logo>
            <img src="{{ asset('images/logo.jpg') }}" alt="AGesp Logo" class="h-8 w-auto">
        </x-slot:logo>
    </flux:brand>
@endif