<x-layouts::app.sidebar title="Alertes">
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
.alert-section { background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); overflow:hidden; margin-bottom:1.5rem; border:1px solid var(--color-gray-100); }
.alert-head { padding:1rem 1.5rem; display:flex; align-items:center; justify-content:space-between; }
.alert-empty { padding:2rem; text-align:center; color:var(--color-gray-500); font-size:0.9rem; }
.alert-table { width:100%; border-collapse:collapse; font-size:0.875rem; }
.alert-table th { padding:0.75rem 1.25rem; text-align:left; font-size:0.72rem; text-transform:uppercase; font-weight:700; color:var(--color-gray-500); border-bottom:2px solid var(--color-gray-100); }
.alert-table td { padding:0.75rem 1.25rem; border-bottom:1px solid var(--color-gray-100); }
.alert-table tr:hover td { background:rgba(0,122,94,0.03); }
.badge-pill { padding:0.25rem 0.7rem; border-radius:50px; font-size:0.72rem; font-weight:700; display:inline-flex; align-items:center; gap:0.3rem; }
.action-btn { padding:0.4rem 0.9rem; border-radius:var(--radius-md); font-size:0.78rem; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:0.3rem; transition:all 0.2s; }
</style>

<div class="content-wrapper" style="padding:2rem;">

    {{-- En-tête --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            🔔 Alertes & Rappels
        </h1>
        <span style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); padding:0.5rem 1.25rem; border-radius:50px; font-weight:800; font-size:1rem;">
            {{ $totalAlertes }} alerte(s)
        </span>
    </div>

    @if($totalAlertes === 0)
    <div style="background:white; padding:3rem; text-align:center; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); color:var(--color-green-dark);">
        <div style="font-size:3rem; margin-bottom:1rem;">✅</div>
        <div style="font-size:1.1rem; font-weight:700;">Tout est à jour !</div>
        <div style="color:var(--color-gray-500); font-size:0.9rem; margin-top:0.5rem;">Aucune alerte en attente pour le moment.</div>
    </div>
    @endif

    {{-- 1) Candidats sans évaluation depuis longtemps --}}
    <div class="alert-section">
        <div class="alert-head" style="background:rgba(206,17,38,0.06); border-bottom:2px solid var(--color-red-light);">
            <h2 style="margin:0; font-size:1rem; font-weight:700; color:var(--color-red-dark);">
                ⏰ Candidats sans évaluation depuis +{{ \App\Http\Controllers\AlerteController::JOURS_SANS_EVALUATION }} jours
            </h2>
            <span class="badge-pill" style="background:rgba(206,17,38,0.15); color:var(--color-red-dark);">{{ $candidatsSansEvaluation->count() }}</span>
        </div>
        @if($candidatsSansEvaluation->isEmpty())
            <div class="alert-empty">✅ Aucun candidat en attente d'évaluation depuis trop longtemps.</div>
        @else
        <table class="alert-table">
            <thead><tr><th>Candidat</th><th>Inscrit depuis</th><th>Statut</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($candidatsSansEvaluation as $c)
                <tr>
                    <td style="font-weight:700; color:var(--color-dark);">👤 {{ $c->nom }} {{ $c->prenom }}</td>
                    <td style="color:var(--color-gray-500);">{{ \Carbon\Carbon::parse($c->created_at)->diffForHumans() }}</td>
                    <td><span class="badge-pill" style="background:var(--color-gray-100); color:var(--color-gray-500);">{{ $c->statut_label ?? $c->statut }}</span></td>
                    <td><a href="{{ route('candidats.show', $c->id) }}" class="action-btn" style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); border:1.5px solid var(--color-red-light);">👁️ Voir fiche</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 2) Évaluation ancienne (en cours de formation, plus de note récente) --}}
    <div class="alert-section">
        <div class="alert-head" style="background:rgba(252,209,22,0.08); border-bottom:2px solid var(--color-gold);">
            <h2 style="margin:0; font-size:1rem; font-weight:700; color:var(--color-gold-dark);">
                📋 Candidats sans nouvelle note depuis +{{ \App\Http\Controllers\AlerteController::JOURS_SANS_EVALUATION }} jours
            </h2>
            <span class="badge-pill" style="background:rgba(252,209,22,0.2); color:var(--color-gold-dark);">{{ $candidatsEvaluationAncienne->count() }}</span>
        </div>
        @if($candidatsEvaluationAncienne->isEmpty())
            <div class="alert-empty">✅ Toutes les évaluations sont à jour.</div>
        @else
        <table class="alert-table">
            <thead><tr><th>Candidat</th><th>Dernière évaluation</th><th>Statut</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($candidatsEvaluationAncienne as $c)
                @php $derniere = $c->evaluations->max('dateEvaluation'); @endphp
                <tr>
                    <td style="font-weight:700; color:var(--color-dark);">👤 {{ $c->nom }} {{ $c->prenom }}</td>
                    <td style="color:var(--color-gray-500);">{{ $derniere ? \Carbon\Carbon::parse($derniere)->format('d/m/Y') . ' (' . \Carbon\Carbon::parse($derniere)->diffForHumans() . ')' : '—' }}</td>
                    <td><span class="badge-pill" style="background:var(--color-gray-100); color:var(--color-gray-500);">{{ $c->statut }}</span></td>
                    <td><a href="{{ route('evaluations.create') }}" class="action-btn" style="background:rgba(252,209,22,0.15); color:var(--color-gold-dark); border:1.5px solid var(--color-gold);">📝 Évaluer</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 3) Sessions ouvertes depuis trop longtemps --}}
    <div class="alert-section">
        <div class="alert-head" style="background:rgba(0,122,94,0.06); border-bottom:2px solid var(--color-green);">
            <h2 style="margin:0; font-size:1rem; font-weight:700; color:var(--color-green-dark);">
                🔓 Sessions ouvertes depuis +{{ \App\Http\Controllers\AlerteController::JOURS_SESSION_OUVERTE }} jours (à clôturer)
            </h2>
            <span class="badge-pill" style="background:rgba(0,122,94,0.15); color:var(--color-green-dark);">{{ $sessionsAOuvertesLongtemps->count() }}</span>
        </div>
        @if($sessionsAOuvertesLongtemps->isEmpty())
            <div class="alert-empty">✅ Aucune session bloquée trop longtemps.</div>
        @else
        <table class="alert-table">
            <thead><tr><th>Date ouverture</th><th>Groupe</th><th>Moniteur</th><th>Candidats</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($sessionsAOuvertesLongtemps as $s)
                <tr>
                    <td style="font-weight:700; color:var(--color-dark);">📅 {{ \Carbon\Carbon::parse($s->dateDebut)->format('d/m/Y') }}
                        <div style="font-size:0.72rem; color:var(--color-red-dark); font-weight:600;">{{ \Carbon\Carbon::parse($s->dateDebut)->diffForHumans() }}</div>
                    </td>
                    <td>{{ $s->groupe->nomGroupe ?? '—' }}</td>
                    <td>{{ $s->moniteur ? $s->moniteur->nom.' '.$s->moniteur->prenom : '—' }}</td>
                    <td style="text-align:center; font-weight:700;">{{ $s->candidats->count() }}</td>
                    <td><a href="{{ route('session_formations.cloture', $s->id) }}" class="action-btn" style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); border:1.5px solid var(--color-red-light);">🔒 Clôturer</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 4) Candidats admis sans attestation --}}
    <div class="alert-section">
        <div class="alert-head" style="background:rgba(0,122,94,0.08); border-bottom:2px solid var(--color-green-light);">
            <h2 style="margin:0; font-size:1rem; font-weight:700; color:var(--color-green-dark);">
                🏆 Candidats admis sans attestation
            </h2>
            <span class="badge-pill" style="background:rgba(0,122,94,0.15); color:var(--color-green-dark);">{{ $candidatsAdmisSansAttestation->count() }}</span>
        </div>
        @if($candidatsAdmisSansAttestation->isEmpty())
            <div class="alert-empty">✅ Tous les candidats admis ont leur attestation.</div>
        @else
        <table class="alert-table">
            <thead><tr><th>Candidat</th><th>Admis depuis</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($candidatsAdmisSansAttestation as $c)
                <tr>
                    <td style="font-weight:700; color:var(--color-dark);">🏆 {{ $c->nom }} {{ $c->prenom }}</td>
                    <td style="color:var(--color-gray-500);">{{ \Carbon\Carbon::parse($c->updated_at)->diffForHumans() }}</td>
                    <td><a href="{{ route('attestations.create') }}" class="action-btn" style="background:rgba(0,122,94,0.1); color:var(--color-green-dark); border:1.5px solid var(--color-green);">🎓 Créer attestation</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 5) Candidats ajournés --}}
    <div class="alert-section">
        <div class="alert-head" style="background:rgba(206,17,38,0.06); border-bottom:2px solid var(--color-red-light);">
            <h2 style="margin:0; font-size:1rem; font-weight:700; color:var(--color-red-dark);">
                ❌ Candidats ajournés (à replanifier)
            </h2>
            <span class="badge-pill" style="background:rgba(206,17,38,0.15); color:var(--color-red-dark);">{{ $candidatsAjournes->count() }}</span>
        </div>
        @if($candidatsAjournes->isEmpty())
            <div class="alert-empty">✅ Aucun candidat ajourné en attente.</div>
        @else
        <table class="alert-table">
            <thead><tr><th>Candidat</th><th>Ajourné depuis</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($candidatsAjournes as $c)
                <tr>
                    <td style="font-weight:700; color:var(--color-dark);">❌ {{ $c->nom }} {{ $c->prenom }}</td>
                    <td style="color:var(--color-gray-500);">{{ \Carbon\Carbon::parse($c->updated_at)->diffForHumans() }}</td>
                    <td><a href="{{ route('programmations.create') }}" class="action-btn" style="background:rgba(252,209,22,0.15); color:var(--color-gold-dark); border:1.5px solid var(--color-gold);">📅 Replanifier</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
</x-layouts::app.sidebar>
