<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Tableau de Bord</h1>
            <p class="text-gray-600 dark:text-gray-400">Bienvenue dans AGesp - Gestion Permis E</p>
        </div>

        <!-- Statistiques -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <!-- Total Candidats -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Candidats</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalCandidats }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3.623A2.623 2.623 0 011 18.377V5.623A2.623 2.623 0 013.623 3h12.754A2.623 2.623 0 0119 5.623v12.754A2.623 2.623 0 0116.377 21z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Inscriptions Actives -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Inscriptions Actives</p>
                        <p class="text-3xl font-bold mt-2">{{ $inscriptionsActives }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Paiements Effectués -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Paiements Effectués</p>
                        <p class="text-3xl font-bold mt-2">{{ $paiementsEffectues }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Formations en Cours -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Formations en Cours</p>
                        <p class="text-3xl font-bold mt-2">{{ $formationsEnCours }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-900">
                        <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques et Informations -->
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Dernières Inscriptions -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h2 class="text-lg font-bold mb-4">Dernières Inscriptions</h2>
                <div class="space-y-3">
                    @forelse($derniereInscriptions as $inscription)
                        <div class="flex items-center justify-between pb-3 border-b last:border-b-0">
                            <div>
                                <p class="font-medium">{{ $inscription->candidat->nom }} {{ $inscription->candidat->prenom }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $inscription->dateInscription }}</p>
                            </div>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                @if($inscription->statutInscription == 'actif') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($inscription->statutInscription == 'abandon') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @endif">
                                {{ ucfirst($inscription->statutInscription) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-600 dark:text-gray-400">Aucune inscription</p>
                    @endforelse
                </div>
            </div>

            <!-- Paiements Récents -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h2 class="text-lg font-bold mb-4">Paiements Récents</h2>
                <div class="space-y-3">
                    @forelse($paiementsRecents as $paiement)
                        <div class="flex items-center justify-between pb-3 border-b last:border-b-0">
                            <div>
                                <p class="font-medium">{{ $paiement->candidat->nom }} {{ $paiement->candidat->prenom }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $paiement->datePaiement }}</p>
                            </div>
                            <span class="font-bold text-green-600 dark:text-green-400">
                                {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-600 dark:text-gray-400">Aucun paiement</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>