<x-layouts::app.sidebar title="Fiche Candidat">
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
@media print { .no-print { display:none !important; } body { background:white !important; } }
</style>

<div class="content-wrapper" style="padding:2rem;">

    {{-- En-tête --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Fiche — {{ $candidat->nom }} {{ $candidat->prenom }}
        </h1>
        <div style="display:flex; gap:0.75rem;" class="no-print">
            <a href="{{ route('candidats.edit', $candidat->id) }}"
               style="padding:0.6rem 1.25rem; background:rgba(0,122,94,0.1); color:var(--color-green-dark); border:2px solid var(--color-green); border-radius:var(--radius-md); font-weight:600; text-decoration:none; font-size:0.8rem;">
                ✎ Modifier
            </a>
            <button onclick="window.print()"
                    style="padding:0.6rem 1.25rem; background:linear-gradient(135deg,var(--color-gold) 0%,var(--color-gold-dark) 100%); color:var(--color-dark); border:2px solid var(--color-gold); border-radius:var(--radius-md); font-weight:600; cursor:pointer; font-size:0.8rem;">
                🖨️ Imprimer
            </button>
            <a href="{{ route('candidats.index') }}"
               style="padding:0.6rem 1.25rem; background:var(--color-gray-100); color:var(--color-dark); border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-weight:600; text-decoration:none; font-size:0.8rem;">
                ← Retour
            </a>
        </div>
    </div>

    {{-- CARTE STATUT --}}
    @php
        $statutConfig = [
            'inscrit'      => ['label'=>'Inscrit',      'icon'=>'📝', 'bg'=>'rgba(102,102,102,0.1)',       'color'=>'#444',                  'border'=>'#999'],
            'en_formation' => ['label'=>'En Formation', 'icon'=>'📚', 'bg'=>'rgba(0,122,94,0.1)',          'color'=>'var(--color-green-dark)', 'border'=>'var(--color-green)'],
            'code_admis'   => ['label'=>'Code Admis',   'icon'=>'✅', 'bg'=>'rgba(229,184,0,0.15)',        'color'=>'var(--color-gold-dark)',  'border'=>'var(--color-gold)'],
            'admis'        => ['label'=>'Admis',        'icon'=>'🏆', 'bg'=>'rgba(0,122,94,0.15)',         'color'=>'var(--color-green-dark)', 'border'=>'var(--color-green)'],
            'ajourne'      => ['label'=>'Ajourné',      'icon'=>'❌', 'bg'=>'rgba(206,17,38,0.1)',         'color'=>'var(--color-red-dark)',   'border'=>'var(--color-red)'],
        ];
        $sc = $statutConfig[$candidat->statut] ?? $statutConfig['inscrit'];
    @endphp

    <div style="margin-bottom:2rem; background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:2px solid {{ $sc['border'] }}; overflow:hidden;">
        <div style="background:{{ $sc['bg'] }}; padding:1.5rem 2rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
            <div style="display:flex; align-items:center; gap:1rem;">
                <div style="font-size:3rem; line-height:1;">{{ $sc['icon'] }}</div>
                <div>
                    <div style="font-size:0.75rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700; letter-spacing:0.5px;">Niveau actuel</div>
                    <div style="font-size:1.75rem; font-weight:800; color:{{ $sc['color'] }};">{{ $sc['label'] }}</div>
                </div>
            </div>
            {{-- Progression visuelle --}}
            <div style="display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap;">
                @foreach(['inscrit'=>'📝 Inscrit', 'en_formation'=>'📚 Formation', 'code_admis'=>'✅ Code', 'admis'=>'🏆 Admis'] as $s => $label)
                @php
                    $ordre = ['inscrit'=>1,'en_formation'=>2,'code_admis'=>3,'admis'=>4,'ajourne'=>2];
                    $ordreActuel = $ordre[$candidat->statut] ?? 1;
                    $ordreCible  = $ordre[$s] ?? 1;
                    $actif = $s === $candidat->statut;
                    $passe = $ordreCible < $ordreActuel;
                @endphp
                <div style="display:flex; align-items:center; gap:0.4rem;">
                    <div style="padding:0.4rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:700;
                        background:{{ $actif ? $sc['bg'] : ($passe ? 'rgba(0,122,94,0.1)' : 'var(--color-gray-100)') }};
                        color:{{ $actif ? $sc['color'] : ($passe ? 'var(--color-green-dark)' : 'var(--color-gray-500)') }};
                        border:1.5px solid {{ $actif ? $sc['border'] : ($passe ? 'var(--color-green)' : 'var(--color-gray-200)') }};
                        ">
                        {{ $label }}
                    </div>
                    @if($s !== 'admis') <span style="color:var(--color-gray-500);">→</span> @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-bottom:1.5rem;">

        {{-- INFOS PERSONNELLES --}}
        <div style="background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); overflow:hidden;">
            <div style="padding:1rem 1.5rem; border-bottom:2px solid var(--color-gold); background:rgba(252,209,22,0.05);">
                <h2 style="margin:0; font-size:0.9rem; font-weight:700; color:var(--color-dark);">👤 Informations Personnelles</h2>
            </div>
            <div style="padding:1.25rem 1.5rem;">
                @php
                    $infos = [
                        'Nom'           => $candidat->nom,
                        'Prénom'        => $candidat->prenom,
                        'Téléphone'     => $candidat->telephone ?? '—',
                        'Email'         => $candidat->email ?? '—',
                        'Date naissance'=> $candidat->dateNaissance ? \Carbon\Carbon::parse($candidat->dateNaissance)->format('d/m/Y') : '—',
                        'Lieu naissance'=> $candidat->lieuNaissance ?? '—',
                    ];
                @endphp
                @foreach($infos as $label => $val)
                <div style="display:flex; justify-content:space-between; padding:0.5rem 0; border-bottom:1px solid var(--color-gray-100); font-size:0.875rem;">
                    <span style="color:var(--color-gray-500); font-weight:600;">{{ $label }}</span>
                    <span style="color:var(--color-dark); font-weight:600; text-align:right;">{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- PERMIS C --}}
        <div style="background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); overflow:hidden;">
            <div style="padding:1rem 1.5rem; border-bottom:2px solid var(--color-gold); background:rgba(252,209,22,0.05);">
                <h2 style="margin:0; font-size:0.9rem; font-weight:700; color:var(--color-dark);">🪪 Permis C</h2>
            </div>
            <div style="padding:1.25rem 1.5rem;">
                @php
                    $permis = [
                        'Numéro'      => $candidat->numeroPermisC ?? '—',
                        'Date délivrance' => $candidat->dateDelivrancePermisC ? \Carbon\Carbon::parse($candidat->dateDelivrancePermisC)->format('d/m/Y') : '—',
                        'Lieu délivrance' => $candidat->lieuDelivrancePermisC ?? '—',
                    ];
                @endphp
                @foreach($permis as $label => $val)
                <div style="display:flex; justify-content:space-between; padding:0.5rem 0; border-bottom:1px solid var(--color-gray-100); font-size:0.875rem;">
                    <span style="color:var(--color-gray-500); font-weight:600;">{{ $label }}</span>
                    <span style="color:var(--color-dark); font-weight:600;">{{ $val }}</span>
                </div>
                @endforeach

                {{-- Sessions --}}
                <div style="margin-top:1rem; padding-top:0.75rem; border-top:2px solid var(--color-gray-100);">
                    <div style="font-size:0.75rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700; margin-bottom:0.5rem;">Sessions participées</div>
                    <div style="font-size:1.5rem; font-weight:800; color:var(--color-dark);">
                        {{ $candidat->sessions->count() }}
                        <span style="font-size:0.8rem; font-weight:400; color:var(--color-gray-500);">session(s)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- HISTORIQUE ÉVALUATIONS --}}
    <div style="background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); overflow:hidden;">
        <div style="padding:1rem 1.5rem; border-bottom:2px solid var(--color-gold); background:rgba(252,209,22,0.05);">
            <h2 style="margin:0; font-size:0.9rem; font-weight:700; color:var(--color-dark);">📊 Historique des Évaluations</h2>
        </div>

        @if($candidat->evaluations->isEmpty())
        <div style="padding:2rem; text-align:center; color:var(--color-gray-500);">
            📭 Aucune évaluation enregistrée
        </div>
        @else
        <table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
            <thead style="background:linear-gradient(90deg,var(--color-green) 0%,var(--color-green-light) 100%); color:white; font-size:0.75rem; text-transform:uppercase;">
                <tr>
                    <th style="padding:0.75rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Date</th>
                    <th style="padding:0.75rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Type</th>
                    <th style="padding:0.75rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Note /30</th>
                    <th style="padding:0.75rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Résultat</th>
                    <th style="padding:0.75rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Observation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidat->evaluations->sortByDesc('dateEvaluation') as $eval)
                <tr style="border-bottom:1px solid var(--color-gray-100);">
                    <td style="padding:0.75rem 1.25rem; font-weight:600;">
                        {{ \Carbon\Carbon::parse($eval->dateEvaluation)->format('d/m/Y') }}
                    </td>
                    <td style="padding:0.75rem 1.25rem; text-align:center;">
                        @switch($eval->typeSession?->type)
                            @case('code')     <span style="background:rgba(0,122,94,0.1); color:var(--color-green); padding:0.25rem 0.65rem; border-radius:50px; font-size:0.75rem; font-weight:700;">📋 Code</span> @break
                            @case('creneau')  <span style="background:rgba(229,184,0,0.15); color:var(--color-gold-dark); padding:0.25rem 0.65rem; border-radius:50px; font-size:0.75rem; font-weight:700;">🔧 Créneau</span> @break
                            @case('conduite') <span style="background:rgba(206,17,38,0.1); color:var(--color-red); padding:0.25rem 0.65rem; border-radius:50px; font-size:0.75rem; font-weight:700;">🚗 Conduite</span> @break
                            @default <span style="color:var(--color-gray-500);">—</span>
                        @endswitch
                    </td>
                    <td style="padding:0.75rem 1.25rem; text-align:center; font-weight:800; font-size:1.1rem; color:{{ !is_null($eval->note) && $eval->note >= 25 ? 'var(--color-green)' : 'var(--color-red)' }};">
                        {{ $eval->note ?? '—' }}
                    </td>
                    <td style="padding:0.75rem 1.25rem; text-align:center;">
                        @if($eval->resultat === 'Admis')
                            <span style="background:rgba(0,122,94,0.15); color:var(--color-green-dark); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:700;">🟢 Admis</span>
                        @elseif($eval->resultat === 'Ajourné')
                            <span style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:700;">🔴 Ajourné</span>
                        @else
                            <span style="background:rgba(229,184,0,0.15); color:var(--color-gold-dark); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:700;">⏳ En attente</span>
                        @endif
                    </td>
                    <td style="padding:0.75rem 1.25rem; color:var(--color-gray-500); font-style:italic; font-size:0.8rem;">
                        {{ $eval->observation ?? '—' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
</x-layouts::app.sidebar>
