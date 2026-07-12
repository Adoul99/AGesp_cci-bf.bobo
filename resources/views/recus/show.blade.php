<x-layouts::app title="Reçu {{ $recus->numero_recu }}">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-dark: #A00D20; --color-green-dark: #004D3A;
    --color-dark: #1A1A1A; --color-gray-100: #E8E8E8; --color-gray-500: #666666;
    --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --radius-md: 8px; --radius-lg: 12px;
}
@media print {
    .no-print { display:none !important; }
    body { background:white !important; }
    .receipt-card { box-shadow:none !important; border:1px solid #ccc !important; }

    /* Masquer la sidebar et la topbar du layout */
    .as, .at {
        display: none !important;
    }

    /* Le conteneur principal ne doit plus être décalé par la sidebar */
    .am {
        margin-left: 0 !important;
    }

    /* Supprimer le padding du contenu et les animations d'entrée */
    .ac {
        padding: 0 !important;
    }
    .ac > * {
        animation: none !important;
    }

    /* Éviter que le reçu se coupe sur 2 pages si possible */
    .receipt-card {
        page-break-inside: avoid;
    }
}
</style>

<div class="content-wrapper" style="padding:2rem; max-width:800px; margin:0 auto;">

    {{-- Barre d'action (masquée à l'impression) --}}
    <div class="no-print" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <a href="{{ route('recus.index') }}"
           style="color:var(--color-dark); text-decoration:none; font-weight:600; font-size:0.875rem;">
            ← Retour à la liste
        </a>
        <button onclick="window.print()"
                style="background:linear-gradient(135deg,var(--color-gold) 0%,#E5B800 100%); color:var(--color-dark); padding:0.75rem 1.5rem; border-radius:var(--radius-md); border:2px solid var(--color-gold); font-weight:700; cursor:pointer; font-size:0.8rem; text-transform:uppercase;">
            ⬇️ Télécharger / Imprimer en PDF
        </button>
    </div>

    @php
        $inscription = $recus->paiement?->inscription;
        $montantTotal = \App\Models\Paiement::MONTANT_TOTAL_FORMATION;
        $montantRestant = $montantTotal - $recus->montant;
    @endphp

    {{-- Reçu --}}
    <div class="receipt-card" style="background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); overflow:hidden; border:1px solid var(--color-gray-100);">

        {{-- En-tête officiel --}}
        <div style="background:linear-gradient(90deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); height:8px;"></div>
        <div style="padding:2rem 2.5rem; border-bottom:2px dashed var(--color-gray-100);">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <h1 style="margin:0; font-size:1.1rem; font-weight:800; color:var(--color-dark); letter-spacing:0.5px;">
                        CHAMBRE DE COMMERCE ET D'INDUSTRIE DU BURKINA FASO
                    </h1>
                    <p style="margin:0.25rem 0 0; font-size:0.8rem; color:var(--color-gray-500);">
                        CCI-BF — Bobo-Dioulasso
                    </p>
                    <p style="margin:0.15rem 0 0; font-size:0.8rem; color:var(--color-gray-500);">
                        Auto-École GESP — Module Permis E
                    </p>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:0.7rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700;">Reçu N°</div>
                    <div style="font-family:monospace; font-size:1.1rem; font-weight:800; color:var(--color-green-dark);">
                        {{ $recus->numero_recu ?? '—' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Corps --}}
        <div style="padding:2.5rem;">
            <h2 style="text-align:center; font-size:1.4rem; font-weight:800; color:var(--color-dark); text-transform:uppercase; letter-spacing:1px; margin:0 0 2rem;">
                Reçu de Paiement
            </h2>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem 2rem; margin-bottom:2rem;">
                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; font-weight:700; color:var(--color-gray-500); margin-bottom:0.25rem;">Candidat</div>
                    <div style="font-size:1rem; font-weight:700; color:var(--color-dark);">
                        👤 {{ $recus->paiement?->candidat?->nom }} {{ $recus->paiement?->candidat?->prenom }}
                    </div>
                </div>
                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; font-weight:700; color:var(--color-gray-500); margin-bottom:0.25rem;">Date du reçu</div>
                    <div style="font-size:1rem; font-weight:700; color:var(--color-dark);">
                        📅 {{ \Carbon\Carbon::parse($recus->dateRecus)->format('d/m/Y') }}
                    </div>
                </div>
                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; font-weight:700; color:var(--color-gray-500); margin-bottom:0.25rem;">Catégorie de permis</div>
                    <div style="font-size:1rem; font-weight:700; color:var(--color-dark);">
                        🚗 {{ $inscription?->categoriePermis?->nomCategorie ?? '—' }}
                    </div>
                </div>
                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; font-weight:700; color:var(--color-gray-500); margin-bottom:0.25rem;">Référence dossier</div>
                    <div style="font-size:1rem; font-weight:700; color:var(--color-dark);">
                        📋 {{ $inscription?->reference ?? '—' }}
                    </div>
                </div>
            </div>

            {{-- Montants --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:2rem;">
                <div style="background:rgba(0,122,94,0.06); border:2px solid var(--color-green); border-radius:var(--radius-md); padding:1.5rem; text-align:center;">
                    <div style="font-size:0.75rem; text-transform:uppercase; font-weight:700; color:var(--color-green-dark); letter-spacing:0.5px;">
                        Montant encaissé
                    </div>
                    <div style="font-size:1.9rem; font-weight:800; color:var(--color-green-dark); margin-top:0.25rem;">
                        {{ number_format($recus->montant, 0, ',', ' ') }} <span style="font-size:1rem;">FCFA</span>
                    </div>
                </div>
                <div style="background:rgba(206,17,38,0.05); border:2px solid var(--color-red); border-radius:var(--radius-md); padding:1.5rem; text-align:center;">
                    <div style="font-size:0.75rem; text-transform:uppercase; font-weight:700; color:var(--color-red-dark); letter-spacing:0.5px;">
                        Montant restant
                    </div>
                    <div style="font-size:1.9rem; font-weight:800; color:var(--color-red-dark); margin-top:0.25rem;">
                        {{ number_format(max($montantRestant, 0), 0, ',', ' ') }} <span style="font-size:1rem;">FCFA</span>
                    </div>
                </div>
            </div>

            <div style="text-align:center; font-size:0.78rem; color:var(--color-gray-500); margin-bottom:2rem;">
                Montant total de la formation : <strong>{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</strong>
            </div>

            {{-- Signatures --}}
            <div style="display:flex; justify-content:space-between; margin-top:3rem; padding-top:1.5rem;">
                <div style="text-align:center; width:45%;">
                    <div style="border-top:1.5px solid var(--color-dark); padding-top:0.5rem; font-size:0.8rem; color:var(--color-gray-500);">
                        Signature du Candidat
                    </div>
                </div>
                <div style="text-align:center; width:45%;">
                    <div style="border-top:1.5px solid var(--color-dark); padding-top:0.5rem; font-size:0.8rem; color:var(--color-gray-500);">
                        Signature de l'Agent Comptable
                    </div>
                </div>
            </div>
        </div>

        {{-- Pied de page --}}
        <div style="background:var(--color-dark); color:white; text-align:center; padding:0.85rem; font-size:0.72rem;">
            Document généré automatiquement — AGesP CCI-BF © {{ date('Y') }}
        </div>
    </div>
</div>
</x-layouts::app>