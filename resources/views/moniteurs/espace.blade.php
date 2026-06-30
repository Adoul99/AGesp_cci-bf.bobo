<x-layouts::app :title="__('Espace Moniteur')">

<style>
:root {
    --r  : #CE1126; --rd : #A00D20;
    --v  : #007A5E; --vd : #004D3A; --vp : #e6f4f0;
    --o  : #FCD116; --od : #c9a800;
    --dk : #1A1A1A; --sub: #5a6a60; --brd: #dde5e0;
}
.mon-wrap { padding: 14px 18px; font-family: 'Source Sans 3', sans-serif; }

.section-title {
    font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 0.85rem;
    color: var(--dk); margin: 20px 0 10px;
    display: flex; align-items: center; gap: 7px;
}
.section-title .bar {
    width: 4px; height: 16px;
    background: linear-gradient(180deg, var(--r), var(--o) 50%, var(--v));
    border-radius: 3px; flex-shrink: 0;
}

.kpi-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 10px; margin-bottom: 20px;
}
.kpi-card {
    background: white; border-radius: 10px; padding: 16px;
    box-shadow: 0 2px 10px rgba(0,122,94,0.08);
    border: 1px solid var(--brd);
}
.kpi-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--sub); margin-bottom: 6px; }
.kpi-val   { font-family: 'Nunito', sans-serif; font-size: 1.8rem; font-weight: 900; color: var(--dk); line-height: 1; }

.table-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,122,94,0.08);
    border: 1px solid var(--brd); overflow: hidden;
    margin-bottom: 20px;
}
.table-card-header {
    padding: 12px 18px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--brd);
}
.table-card-header h6 {
    font-family: 'Nunito', sans-serif; font-weight: 800;
    font-size: 0.85rem; color: var(--dk); margin: 0;
    display: flex; align-items: center; gap: 7px;
}
.tbl thead th {
    background: var(--v); color: white;
    font-size: 0.72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.04em;
    padding: 10px 14px; border: none;
}
.tbl tbody td { padding: 10px 14px; font-size: 0.82rem; vertical-align: middle; border-color: var(--brd); }
.tbl tbody tr:hover { background: var(--vp); }

.badge-statut {
    padding: 2px 10px; border-radius: 20px;
    font-size: 0.72rem; font-weight: 700; color: white;
}
</style>

<div class="mon-wrap">

    {{-- ── En-tête ── --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:8px;">
        <div>
            <div style="font-family:'Nunito',sans-serif;font-weight:800;font-size:1.05rem;color:var(--dk);display:flex;align-items:center;gap:7px;">
                <span style="width:4px;height:18px;background:linear-gradient(180deg,var(--r),var(--o) 50%,var(--v));border-radius:3px;display:inline-block;flex-shrink:0;"></span>
                Bonjour, {{ $moniteur->prenom }} {{ $moniteur->nom }}
            </div>
            <div style="font-size:0.7rem;color:var(--sub);margin-top:1px;">Espace Moniteur — AGesP / CFTRA Bobo-Dioulasso</div>
        </div>
        <div style="font-size:0.68rem;color:var(--sub);background:#f3f6f4;padding:3px 10px;border-radius:20px;border:1px solid var(--brd);">
            <i class="bi bi-calendar3 me-1"></i>{{ now()->locale('fr')->isoFormat('ddd D MMM YYYY') }}
        </div>
    </div>

    {{-- ── KPI ── --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Sessions assignées</div>
            <div class="kpi-val" style="color:var(--v);">{{ $sessionsCount }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Spécialité</div>
            <div style="font-size:1rem;font-weight:700;color:var(--dk);margin-top:6px;">{{ strtoupper($moniteur->specialite ?? '—') }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Disponibilité</div>
            <div style="margin-top:8px;">
                @if($moniteur->disponibilite)
                    <span style="background:#007A5E;color:white;padding:3px 12px;border-radius:20px;font-size:0.78rem;font-weight:700;">Disponible</span>
                @else
                    <span style="background:#6b7280;color:white;padding:3px 12px;border-radius:20px;font-size:0.78rem;font-weight:700;">Indisponible</span>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Info accès rapide ── --}}
    <div style="background:rgba(0,122,94,0.08);border-left:4px solid var(--v);border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:0.82rem;color:var(--vd);">
        <i class="bi bi-info-circle-fill me-2"></i>
        Utilisez le <strong>menu latéral gauche</strong> pour accéder aux formations, sessions, évaluations, examens et programmations.
    </div>

    {{-- ── Prochaines sessions ── --}}
    <div class="section-title">
        <span class="bar"></span>
        Mes prochaines sessions de formation
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <h6><i class="bi bi-calendar-check" style="color:var(--v);"></i> Sessions à venir</h6>
        </div>
        @if($prochainesSessions->isEmpty())
            <div style="text-align:center;padding:30px;color:var(--sub);font-size:0.85rem;">
                <i class="bi bi-calendar-x" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                Aucune session à venir pour le moment.
            </div>
        @else
            <div class="table-responsive">
                <table class="table tbl mb-0">
                    <thead>
                        <tr>
                            <th>Date de début</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prochainesSessions as $session)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($session->dateDebut)->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $badgeColor = match($session->statutSession ?? '') {
                                            'ouvert'  => '#007A5E',
                                            'cloture' => '#6b7280',
                                            default   => '#c9a800',
                                        };
                                    @endphp
                                    <span class="badge-statut" style="background:{{ $badgeColor }};">
                                        {{ ucfirst($session->statutSession ?? 'En cours') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>{{-- /mon-wrap --}}

</x-layouts::app>