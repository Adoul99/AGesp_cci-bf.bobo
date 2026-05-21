<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Gestion Candidats')" class="grid">
                    <flux:sidebar.item icon="users" :href="route('candidats.index')" :current="request()->routeIs('candidats.*')" wire:navigate>
                        Candidats
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="folder" :href="route('dossiers.index')" :current="request()->routeIs('dossiers.*')" wire:navigate>
                        Dossiers
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="check-circle" :href="route('inscriptions.index')" :current="request()->routeIs('inscriptions.*')" wire:navigate>
                        Inscriptions
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Gestion Formation')" class="grid">
                    <flux:sidebar.item icon="document" :href="route('formations.index')" :current="request()->routeIs('formations.*')" wire:navigate>
                        Formations
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="map-pin" :href="route('lieu_formations.index')" :current="request()->routeIs('lieu_formations.*')" wire:navigate>
                        Lieux Formation
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="user-group" :href="route('groupes.index')" :current="request()->routeIs('groupes.*')" wire:navigate>
                        Groupes
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calendar" :href="route('session_formations.index')" :current="request()->routeIs('session_formations.*')" wire:navigate>
                        Sessions Formation
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="rectangle-stack" :href="route('type_sessions.index')" :current="request()->routeIs('type_sessions.*')" wire:navigate>
                        Types Session
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Gestion Examens')" class="grid">
                    <flux:sidebar.item icon="pencil" :href="route('examens.index')" :current="request()->routeIs('examens.*')" wire:navigate>
                        Examens
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="star" :href="route('evaluations.index')" :current="request()->routeIs('evaluations.*')" wire:navigate>
                        Évaluations
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calendar" :href="route('programmations.index')" :current="request()->routeIs('programmations.*')" wire:navigate>
                        Programmations
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Gestion Administrative')" class="grid">
                    <flux:sidebar.item icon="credit-card" :href="route('paiements.index')" :current="request()->routeIs('paiements.*')" wire:navigate>
                        Paiements
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="clipboard-document-list" :href="route('recus.index')" :current="request()->routeIs('recus.*')" wire:navigate>
                        Reçus
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="academic-cap" :href="route('attestations.index')" :current="request()->routeIs('attestations.*')" wire:navigate>
                        Attestations
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="tag" :href="route('categorie_permis.index')" :current="request()->routeIs('categorie_permis.*')" wire:navigate>
                        Catégories Permis
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Gestion Ressources')" class="grid">
                    <flux:sidebar.item icon="user" :href="route('moniteurs.index')" :current="request()->routeIs('moniteurs.*')" wire:navigate>
                        Moniteurs
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="cube" :href="route('vehicules.index')" :current="request()->routeIs('vehicules.*')" wire:navigate>
                        Véhicules
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="code-bracket" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="document-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
/>

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>