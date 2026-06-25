<x-layouts::app :title="__('Dashboard')">

<style>
:root {
    --r  : #CE1126;
    --rd : #A00D20;
    --v  : #007A5E;
    --vd : #004D3A;
    --vp : #e6f4f0;
    --o  : #FCD116;
    --od : #c9a800;
    --dk : #1A1A1A;
    --sub: #5a6a60;
    --bg : #f2f5f3;
    --brd: #dde5e0;
}

.db-wrap { padding: 14px 18px; font-family: 'Source Sans 3', sans-serif; }

/* ── Titre section ── */
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
.section-title .right {
    font-weight: 700; font-size: 0.75rem; color: var(--sub); margin-left: auto;
}

/* ── Grille étapes (5 colonnes) ── */
.etapes-grid {
    display: grid; grid-template-columns: repeat(5, 1fr);
    gap: 10px; margin-bottom: 14px;
}
.etape-card {
    border-radius: 10px; padding: 14px;
    color: white; position: relative; overflow: hidden;
    box-shadow: 0 3px 12px rgba(0,0,0,0.15);
}
.etape-card::after {
    content: ''; position: absolute;
    bottom: -14px; right: -14px;
    width: 60px; height: 60px;
    border-radius: 50%; background: rgba(255,255,255,0.1);
}
.etape-lbl { font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; opacity: 0.88; margin-bottom: 4px; }
.etape-val { font-family: 'Nunito', sans-serif; font-size: 1.75rem; font-weight: 900; line-height: 1; }
.etape-ico { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-size: 1.8rem; opacity: 0.15; }

.ec-grey  { background: linear-gradient(135deg, #4b5563, #6b7280); }
.ec-red   { background: linear-gradient(135deg, var(--rd), var(--r)); }
.ec-gold  { background: linear-gradient(135deg, var(--od), var(--o)); color: #1a1a1a; }
.ec-dark  { background: linear-gradient(135deg, #1a2520, #3a4a40); }
.ec-green { background: linear-gradient(135deg, var(--vd), var(--v)); }

/* ── Panneau graphique centré ── */
.chart-panel {
    background: white; border-radius: 12px; padding: 16px 20px;
    box-shadow: 0 2px 10px rgba(0,122,94,0.08);
    border: 1px solid var(--brd);
    margin-bottom: 6px;
    display: flex; align-items: center; gap: 30px;
}
.chart-panel-canvas { flex-shrink: 0; width: 240px; height: 240px; }
.chart-panel-legend { flex: 1; }
.chart-panel-legend .lbl {
    font-family: 'Nunito', sans-serif; font-weight: 700;
    font-size: 0.78rem; color: var(--dk); margin-bottom: 14px;
}
.legend-item {
    display: flex; align-items: center; gap: 10px;
    padding: 7px 0; border-bottom: 1px solid var(--brd);
    font-size: 0.78rem;
}
.legend-item:last-child { border-bottom: none; }
.legend-dot {
    width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0;
}
.legend-name { flex: 1; color: var(--sub); font-weight: 600; }
.legend-val  { font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1rem; color: var(--dk); }

/* ── Séparateur visuel entre D et E ── */
.perm-separator {
    border: none; border-top: 2px dashed var(--brd);
    margin: 24px 0;
}

/* ── Graphique global centré ── */
.global-chart-panel {
    background: white; border-radius: 12px; padding: 20px;
    box-shadow: 0 2px 10px rgba(0,122,94,0.08);
    border: 1px solid var(--brd);
    display: flex; justify-content: center; align-items: center;
    gap: 40px;
}
.global-chart-canvas { width: 260px; height: 260px; flex-shrink: 0; }

@media (max-width: 992px) {
    .chart-panel { flex-direction: column; }
    .chart-panel-canvas { width: 200px; height: 200px; }
    .global-chart-panel { flex-direction: column; }
}
@media (max-width: 768px) {
    .etapes-grid { grid-template-columns: repeat(3, 1fr); }
}
</style>

<div class="db-wrap">

    {{-- ── En-tête ── --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:8px;">
        <div>
            <div style="font-family:'Nunito',sans-serif;font-weight:800;font-size:1.05rem;color:var(--dk);display:flex;align-items:center;gap:7px;">
                <span style="width:4px;height:18px;background:linear-gradient(180deg,var(--r),var(--o) 50%,var(--v));border-radius:3px;display:inline-block;flex-shrink:0;"></span>
                Tableau de bord — CFTRA Bobo-Dioulasso
            </div>
            <div style="font-size:0.7rem;color:var(--sub);margin-top:1px;">Permis de conduire D &amp; E · AGesP</div>
        </div>
        <div style="font-size:0.68rem;color:var(--sub);background:#f3f6f4;padding:3px 10px;border-radius:20px;border:1px solid var(--brd);">
            <i class="bi bi-calendar3 me-1"></i>{{ now()->locale('fr')->isoFormat('ddd D MMM YYYY') }}
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- PERMIS D : étapes + graphique                         --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="section-title">
        <span class="bar"></span>
        <i class="bi bi-bus-front-fill" style="color:#2563eb;"></i>
        Répartition par étape de formation — Permis D
        <span class="right">Total : {{ $statsD['inscrits'] }} candidats</span>
    </div>

    <div class="etapes-grid">
        <div class="etape-card ec-grey">
            <div class="etape-lbl">Inscrits</div>
            <div class="etape-val">{{ $statsD['inscrits'] }}</div>
            <span class="etape-ico">📋</span>
        </div>
        <div class="etape-card ec-red">
            <div class="etape-lbl">Code</div>
            <div class="etape-val">{{ $statsD['code'] }}</div>
            <span class="etape-ico">📖</span>
        </div>
        <div class="etape-card ec-gold">
            <div class="etape-lbl">Créneau</div>
            <div class="etape-val">{{ $statsD['creneau'] }}</div>
            <span class="etape-ico">🕐</span>
        </div>
        <div class="etape-card ec-dark">
            <div class="etape-lbl">Conduite en ville</div>
            <div class="etape-val">{{ $statsD['conduite'] }}</div>
            <span class="etape-ico">🚌</span>
        </div>
        <div class="etape-card ec-green">
            <div class="etape-lbl">Admis</div>
            <div class="etape-val">{{ $statsD['admis'] }}</div>
            <span class="etape-ico">🏆</span>
        </div>
    </div>

    {{-- Graphique Permis D --}}
    <div class="chart-panel">
        <canvas id="chartD" class="chart-panel-canvas"></canvas>
        <div class="chart-panel-legend">
            <div class="lbl">Répartition visuelle — Permis D</div>
            @php
                $etapesD = [
                    ['Inscrits',         $statsD['inscrits'], '#6b7280'],
                    ['Code',             $statsD['code'],     '#CE1126'],
                    ['Créneau',          $statsD['creneau'],  '#FCD116'],
                    ['Conduite en ville',$statsD['conduite'], '#3a4a40'],
                    ['Admis',            $statsD['admis'],    '#007A5E'],
                ];
            @endphp
            @foreach($etapesD as $e)
                <div class="legend-item">
                    <div class="legend-dot" style="background:{{ $e[2] }};"></div>
                    <div class="legend-name">{{ $e[0] }}</div>
                    <div class="legend-val">{{ $e[1] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <hr class="perm-separator">

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- PERMIS E : étapes + graphique                         --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="section-title">
        <span class="bar"></span>
        <i class="bi bi-truck-front-fill" style="color:var(--v);"></i>
        Répartition par étape de formation — Permis E
        <span class="right">Total : {{ $statsE['inscrits'] }} candidats</span>
    </div>

    <div class="etapes-grid">
        <div class="etape-card ec-grey">
            <div class="etape-lbl">Inscrits</div>
            <div class="etape-val">{{ $statsE['inscrits'] }}</div>
            <span class="etape-ico">📋</span>
        </div>
        <div class="etape-card ec-red">
            <div class="etape-lbl">Code</div>
            <div class="etape-val">{{ $statsE['code'] }}</div>
            <span class="etape-ico">📖</span>
        </div>
        <div class="etape-card ec-gold">
            <div class="etape-lbl">Créneau</div>
            <div class="etape-val">{{ $statsE['creneau'] }}</div>
            <span class="etape-ico">🕐</span>
        </div>
        <div class="etape-card ec-dark">
            <div class="etape-lbl">Conduite en ville</div>
            <div class="etape-val">{{ $statsE['conduite'] }}</div>
            <span class="etape-ico">🚛</span>
        </div>
        <div class="etape-card ec-green">
            <div class="etape-lbl">Admis</div>
            <div class="etape-val">{{ $statsE['admis'] }}</div>
            <span class="etape-ico">🏆</span>
        </div>
    </div>

    {{-- Graphique Permis E --}}
    <div class="chart-panel">
        <canvas id="chartE" class="chart-panel-canvas"></canvas>
        <div class="chart-panel-legend">
            <div class="lbl">Répartition visuelle — Permis E</div>
            @php
                $etapesE = [
                    ['Inscrits',         $statsE['inscrits'], '#6b7280'],
                    ['Code',             $statsE['code'],     '#CE1126'],
                    ['Créneau',          $statsE['creneau'],  '#FCD116'],
                    ['Conduite en ville',$statsE['conduite'], '#3a4a40'],
                    ['Admis',            $statsE['admis'],    '#007A5E'],
                ];
            @endphp
            @foreach($etapesE as $e)
                <div class="legend-item">
                    <div class="legend-dot" style="background:{{ $e[2] }};"></div>
                    <div class="legend-name">{{ $e[0] }}</div>
                    <div class="legend-val">{{ $e[1] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <hr class="perm-separator">

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- STATISTIQUES GLOBALES                                  --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="section-title">
        <span class="bar"></span>
        Statistiques globales — Répartition par catégorie de permis
    </div>

    <div class="global-chart-panel">
        <canvas id="chartPermis" class="global-chart-canvas"></canvas>
        <div>
            <div style="font-family:'Nunito',sans-serif;font-weight:700;font-size:0.82rem;color:var(--dk);margin-bottom:14px;">
                Total candidats : <span style="font-size:1.4rem;font-weight:900;">{{ $totalCandidats }}</span>
            </div>
            @foreach($repartitionPermis as $cat => $total)
                @php
                    $colors = ['D' => '#007A5E', 'E' => '#FCD116'];
                    $color  = $colors[$cat] ?? '#CE1126';
                @endphp
                <div class="legend-item">
                    <div class="legend-dot" style="background:{{ $color }};"></div>
                    <div class="legend-name">Permis {{ $cat }}</div>
                    <div class="legend-val">{{ $total }}</div>
                </div>
            @endforeach
        </div>
    </div>

</div>{{-- /db-wrap --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function () {
    const ff  = "'Source Sans 3', sans-serif";
    const etapeLabels = ['Inscrits', 'Code', 'Créneau', 'Conduite en ville', 'Admis'];
    const etapeColors = ['#6b7280', '#CE1126', '#FCD116', '#3a4a40', '#007A5E'];
    const baseOpts = {
        responsive: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ' ' + ctx.label + ' : ' + ctx.raw } }
        }
    };

    // ── Permis D ──
    new Chart(document.getElementById('chartD'), {
        type: 'doughnut',
        data: {
            labels: etapeLabels,
            datasets: [{ data: [{{ $statsD['inscrits'] }}, {{ $statsD['code'] }}, {{ $statsD['creneau'] }}, {{ $statsD['conduite'] }}, {{ $statsD['admis'] }}], backgroundColor: etapeColors, borderWidth: 2, borderColor: '#fff' }]
        },
        options: { ...baseOpts, cutout: '60%' }
    });

    // ── Permis E ──
    new Chart(document.getElementById('chartE'), {
        type: 'doughnut',
        data: {
            labels: etapeLabels,
            datasets: [{ data: [{{ $statsE['inscrits'] }}, {{ $statsE['code'] }}, {{ $statsE['creneau'] }}, {{ $statsE['conduite'] }}, {{ $statsE['admis'] }}], backgroundColor: etapeColors, borderWidth: 2, borderColor: '#fff' }]
        },
        options: { ...baseOpts, cutout: '60%' }
    });

    // ── Global catégories ──
    new Chart(document.getElementById('chartPermis'), {
        type: 'doughnut',
        data: {
            labels: @json($repartitionPermis->keys()),
            datasets: [{ data: @json($repartitionPermis->values()), backgroundColor: ['#007A5E', '#FCD116', '#CE1126', '#3a4a40'], borderWidth: 2, borderColor: '#fff' }]
        },
        options: { ...baseOpts, cutout: '62%' }
    });
})();
</script>

</x-layouts::app>