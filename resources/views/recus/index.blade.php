<x-layouts::app.sidebar title="Liste des Reçus">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-light: #E85040; --color-red-dark: #A00D20;
    --color-green-light: #00A572; --color-green-dark: #004D3A;
    --color-gold-dark: #E5B800; --color-dark: #1A1A1A;
    --color-gray-100: #E8E8E8; --color-gray-200: #D1D1D1; --color-gray-500: #666666;
    --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --radius-md: 8px; --radius-lg: 12px;
}
@media print {
    .no-print { display:none !important; }
    body { background:white !important; }
}
</style>

<div class="content-wrapper" style="padding:2rem;">

    @if(session('success'))
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(0,122,94,0.1); border-left:4px solid var(--color-green); border-radius:var(--radius-md); color:var(--color-green-dark); font-weight:600;">
        {{ session('success') }}
    </div>
    @endif

    {{-- En-tête --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Liste des Reçus
        </h1>
        <div style="display:flex; gap:1rem;" class="no-print">
            <a href="{{ route('recus.create') }}"
               style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:0.75rem 1.5rem; border-radius:var(--radius-md); text-decoration:none; font-weight:600; border:2px solid var(--color-red); font-size:0.8rem; text-transform:uppercase; display:inline-flex; align-items:center; gap:0.5rem;"
               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                + Nouveau Reçu
            </a>
            <button onclick="window.print()"
                    style="background:linear-gradient(135deg,var(--color-gold) 0%,var(--color-gold-dark) 100%); color:var(--color-dark); padding:0.75rem 1.5rem; border-radius:var(--radius-md); border:2px solid var(--color-gold); font-weight:600; cursor:pointer; font-size:0.8rem; text-transform:uppercase;">
                ⬇️ Exporter PDF
            </button>
        </div>
    </div>

    {{-- Tableau --}}
    <div style="background:white; border-radius:var(--radius-lg); overflow:hidden; box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100);">
        <table style="width:100%; border-collapse:collapse;">
            <thead style="background:linear-gradient(90deg,var(--color-green) 0%,var(--color-green-light) 100%); color:white; font-size:0.78rem; text-transform:uppercase; letter-spacing:0.5px;">
                <tr>
                    <th style="padding:1rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">N° Reçu</th>
                    <th style="padding:1rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Candidat</th>
                    <th style="padding:1rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Motif</th>
                    <th style="padding:1rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Montant</th>
                    <th style="padding:1rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Date</th>
                    <th style="padding:1rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);" class="no-print">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recus as $recu)
                <tr style="border-bottom:1px solid var(--color-gray-100);"
                    onmouseover="this.style.backgroundColor='rgba(0,122,94,0.04)'"
                    onmouseout="this.style.backgroundColor='transparent'">

                    <td style="padding:0.875rem 1.25rem;">
                        <span style="background:rgba(0,122,94,0.1); color:var(--color-green-dark); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.8rem; font-weight:700; font-family:monospace;">
                            🔖 {{ $recu->numero_recu ?? '—' }}
                        </span>
                    </td>

                    <td style="padding:0.875rem 1.25rem; font-weight:600; color:var(--color-dark); font-size:0.875rem;">
                        👤 {{ $recu->paiement?->candidat?->nom ?? '—' }}
                        {{ $recu->paiement?->candidat?->prenom ?? '' }}
                    </td>

                    <td style="padding:0.875rem 1.25rem; font-size:0.85rem;">
                        @if($recu->recus_paiement)
                            <a href="{{ Storage::url($recu->recus_paiement) }}" target="_blank"
                               style="color:var(--color-green-dark); font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem;">
                                @if(str_ends_with(strtolower($recu->recus_paiement), '.pdf'))
                                    📕 Voir PDF
                                @else
                                    🖼️ Voir image
                                @endif
                            </a>
                        @else
                            <span style="color:var(--color-gray-500); font-style:italic;">—</span>
                        @endif
                    </td>

                    <td style="padding:0.875rem 1.25rem; text-align:center; font-weight:700; color:var(--color-dark);">
                        {{ number_format($recu->montant, 0, ',', ' ') }} <span style="font-size:0.75rem; color:var(--color-gray-500);">FCFA</span>
                    </td>

                    <td style="padding:0.875rem 1.25rem; text-align:center;">
                        <span style="background:rgba(0,122,94,0.1); color:var(--color-green-dark); padding:0.3rem 0.65rem; border-radius:var(--radius-md); font-size:0.78rem; font-weight:600;">
                            {{ \Carbon\Carbon::parse($recu->dateRecus)->format('d/m/Y') }}
                        </span>
                    </td>

                    <td style="padding:0.875rem 1.25rem; text-align:center;" class="no-print">
                        <div style="display:flex; gap:0.4rem; justify-content:center;">
                            <a href="{{ route('recus.show', $recu->id) }}"
                               style="padding:0.4rem 0.7rem; background:rgba(252,209,22,0.15); color:#8a6900; border:1.5px solid var(--color-gold); border-radius:var(--radius-md); font-size:0.75rem; font-weight:600; text-decoration:none;" title="Voir / Imprimer PDF">🖨️</a>
                            <a href="{{ route('recus.edit', $recu->id) }}"
                               style="padding:0.4rem 0.85rem; background:rgba(0,122,94,0.1); color:var(--color-green); border:1.5px solid var(--color-green); border-radius:var(--radius-md); font-size:0.75rem; font-weight:600; text-decoration:none;" title="Modifier">✎</a>
                            <form method="POST" action="{{ route('recus.destroy', $recu->id) }}" style="display:inline;" onsubmit="return confirm('Supprimer ce reçu ?');">
                                @csrf @method('DELETE')
                                <button type="submit" style="padding:0.4rem 0.7rem; background:rgba(206,17,38,0.08); color:#D32F2F; border:1.5px solid #D32F2F; border-radius:var(--radius-md); cursor:pointer; font-size:0.75rem;" title="Supprimer">✕</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:3rem; text-align:center; color:var(--color-gray-500);">
                        📭 Aucun reçu enregistré
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($recus->count() > 0)
    <div style="margin-top:1.5rem; padding:1rem; background:rgba(0,122,94,0.08); border-left:4px solid var(--color-green); border-radius:var(--radius-md); color:var(--color-green-dark); font-size:0.875rem;">
        <strong>Total :</strong> {{ $recus->count() }} reçu(s) —
        <strong>{{ number_format($recus->sum('montant'), 0, ',', ' ') }} FCFA</strong> encaissés
    </div>
    @endif
</div>
</x-layouts::app.sidebar>