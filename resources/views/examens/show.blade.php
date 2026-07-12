<x-layouts::app title="Détail Examen">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-dark: #A00D20; --color-green-light: #00A572;
    --color-green-dark: #004D3A; --color-gold-dark: #E5B800;
    --color-dark: #1A1A1A; --color-gray-100: #E8E8E8;
    --color-gray-200: #D1D1D1; --color-gray-500: #666666;
    --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --radius-md: 8px; --radius-lg: 12px;
}
@media print { .no-print { display:none !important; } body { background:white !important; } }
</style>

<div class="content-wrapper" style="padding:2rem;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            {{ $examen->libelle }}
        </h1>
        <div style="display:flex; gap:0.75rem;" class="no-print">
            <a href="{{ route('examens.edit', $examen->id) }}"
               style="padding:0.6rem 1.25rem; background:rgba(0,122,94,0.1); color:var(--color-green-dark); border:2px solid var(--color-green); border-radius:var(--radius-md); font-weight:600; text-decoration:none; font-size:0.8rem;">
                ✎ Modifier
            </a>
            <button onclick="window.print()"
                    style="padding:0.6rem 1.25rem; background:linear-gradient(135deg,var(--color-gold) 0%,var(--color-gold-dark) 100%); color:var(--color-dark); border:2px solid var(--color-gold); border-radius:var(--radius-md); font-weight:600; cursor:pointer; font-size:0.8rem;">
                🖨️ Imprimer
            </button>
            <a href="{{ route('examens.index') }}"
               style="padding:0.6rem 1.25rem; background:var(--color-gray-100); color:var(--color-dark); border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-weight:600; text-decoration:none; font-size:0.8rem;">
                ← Retour
            </a>
        </div>
    </div>

    {{-- Infos examen --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:1rem; margin-bottom:2rem;">
        @php
            $statuts = [
                'ouvert'     => ['🟢 Ouvert', 'var(--color-green)', 'rgba(0,122,94,0.1)'],
                'en_attente' => ['⏳ En attente', 'var(--color-gold-dark)', 'rgba(252,209,22,0.15)'],
                'termine'    => ['🔴 Terminé', 'var(--color-red-dark)', 'rgba(206,17,38,0.1)'],
            ];
            [$statutLabel, $statutColor, $statutBg] = $statuts[$examen->statutExamen] ?? ['—', '#666', '#eee'];
        @endphp
        <div style="background:white; padding:1.25rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-green); text-align:center;">
            <div style="font-size:0.7rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700;">Statut</div>
            <div style="font-size:1.1rem; font-weight:800; color:{{ $statutColor }}; margin-top:0.4rem;">{{ $statutLabel }}</div>
        </div>
        <div style="background:white; padding:1.25rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-gold); text-align:center;">
            <div style="font-size:0.7rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700;">Date Début</div>
            <div style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-top:0.4rem;">{{ \Carbon\Carbon::parse($examen->dateDebut)->format('d/m/Y') }}</div>
        </div>
        <div style="background:white; padding:1.25rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red); text-align:center;">
            <div style="font-size:0.7rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700;">Date Fin</div>
            <div style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-top:0.4rem;">{{ \Carbon\Carbon::parse($examen->dateFin)->format('d/m/Y') }}</div>
        </div>
        <div style="background:white; padding:1.25rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-green); text-align:center;">
            <div style="font-size:0.7rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700;">Moniteur</div>
            <div style="font-size:0.9rem; font-weight:700; color:var(--color-dark); margin-top:0.4rem;">{{ $examen->moniteur ? $examen->moniteur->nom.' '.$examen->moniteur->prenom : '—' }}</div>
        </div>
        <div style="background:white; padding:1.25rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-gold); text-align:center;">
            <div style="font-size:0.7rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700;">Candidats</div>
            <div style="font-size:1.75rem; font-weight:800; color:var(--color-dark); margin-top:0.2rem;">{{ $examen->candidats->count() }}</div>
        </div>
    </div>

    {{-- Tableau des candidats --}}
    <div style="background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); overflow:hidden;">
        <div style="padding:1rem 1.5rem; border-bottom:2px solid var(--color-gold); background:rgba(252,209,22,0.05); display:flex; justify-content:space-between; align-items:center;">
            <h2 style="margin:0; font-size:1rem; font-weight:700; color:var(--color-dark);">📋 Liste des candidats</h2>
            @if($examen->candidats->isNotEmpty())
            @php
                $admis = $examen->candidats->where('pivot.resultat', 'Admis')->count();
                $ajournes = $examen->candidats->where('pivot.resultat', 'Ajourné')->count();
            @endphp
            <div style="display:flex; gap:0.75rem; font-size:0.8rem; font-weight:700;">
                <span style="background:rgba(0,122,94,0.15); color:var(--color-green-dark); padding:0.3rem 0.75rem; border-radius:50px;">✅ {{ $admis }} Admis</span>
                <span style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); padding:0.3rem 0.75rem; border-radius:50px;">❌ {{ $ajournes }} Ajournés</span>
                <span style="background:rgba(252,209,22,0.2); color:var(--color-gold-dark); padding:0.3rem 0.75rem; border-radius:50px;">⏳ {{ $examen->candidats->count() - $admis - $ajournes }} En attente</span>
            </div>
            @endif
        </div>

        @if($examen->candidats->isEmpty())
        <div style="padding:3rem; text-align:center; color:var(--color-gray-500);">
            📭 Aucun candidat inscrit à cet examen
        </div>
        @else
        <table style="width:100%; border-collapse:collapse;">
            <thead style="background:linear-gradient(90deg,var(--color-green) 0%,var(--color-green-light) 100%); color:white; font-size:0.78rem; text-transform:uppercase; letter-spacing:0.5px;">
                <tr>
                    <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">#</th>
                    <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Candidat</th>
                    <th style="padding:0.875rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Résultat</th>
                    <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Observation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($examen->candidats as $i => $candidat)
                <tr style="border-bottom:1px solid var(--color-gray-100);"
                    onmouseover="this.style.backgroundColor='rgba(0,122,94,0.04)'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <td style="padding:0.875rem 1.25rem; color:var(--color-gray-500); font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td style="padding:0.875rem 1.25rem; font-weight:700; color:var(--color-dark);">
                        👤 {{ $candidat->nom }} {{ $candidat->prenom }}
                    </td>
                    <td style="padding:0.875rem 1.25rem; text-align:center;">
                        @if($candidat->pivot->resultat === 'Admis')
                            <span style="background:rgba(0,122,94,0.15); color:var(--color-green-dark); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.75rem; font-weight:700;">✅ Admis</span>
                        @elseif($candidat->pivot->resultat === 'Ajourné')
                            <span style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.75rem; font-weight:700;">❌ Ajourné</span>
                        @else
                            <span style="background:rgba(252,209,22,0.2); color:var(--color-gold-dark); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.75rem; font-weight:700;">⏳ En attente</span>
                        @endif
                    </td>
                    <td style="padding:0.875rem 1.25rem; color:var(--color-gray-500); font-size:0.85rem; font-style:italic;">
                        {{ $candidat->pivot->observation ?? '—' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
</x-layouts::app>
