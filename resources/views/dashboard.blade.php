{{--
    Tableau de bord administrateur AGesp
    Variables attendues (avec valeurs de secours si non transmises par le contrôleur) :
    $permisD = ['total'=>0,'inscrits'=>0,'code'=>0,'creneau'=>0,'conduite'=>0,'admis'=>0]
    $permisE = ['total'=>0,'inscrits'=>0,'code'=>0,'creneau'=>0,'conduite'=>0,'admis'=>0]
--}}
<x-layouts::app.sidebar :title="'Tableau de bord'">

    @php
        $permisD = $permisD ?? ['total'=>7,'inscrits'=>7,'code'=>1,'creneau'=>0,'conduite'=>2,'admis'=>2];
        $permisE = $permisE ?? ['total'=>5,'inscrits'=>5,'code'=>0,'creneau'=>0,'conduite'=>1,'admis'=>4];

        // ⚠️ Le total vient TOUJOURS du contrôleur (candidats uniques), jamais d'une somme
        // des étapes ci-dessous : 'inscrits' n'est pas mutuellement exclusif avec les autres.
        $totalD = $permisD['total'] ?? array_sum($permisD);
        $totalE = $permisE['total'] ?? array_sum($permisE);
        $totalGlobal = $totalD + $totalE;

        // Construit les segments (couleur, %) du donut à partir des SEULES étapes de
        // progression mutuellement exclusives. 'inscrits' est volontairement exclu :
        // c'est un total, pas une étape, il fausserait la somme des segments à 100%.
        $buildSegments = function(array $data, int $total) {
            $colors = [
                'code'     => '#c0281e',   // rouge CCI-BF
                'creneau'  => '#d4a017',   // or CCI-BF
                'conduite' => '#0e4525',   // vert foncé
                'admis'    => '#8b1a12',   // rouge foncé
            ];
            $segments = [];
            $cursor = 0;
            foreach ($colors as $key => $color) {
                $val = $data[$key] ?? 0;
                $pct = $total > 0 ? ($val / $total) * 100 : 0;
                $segments[] = ['color' => $color, 'start' => $cursor, 'end' => $cursor + $pct];
                $cursor += $pct;
            }
            // Reste = candidats encore au stade "inscrit" (aucune étape de progression atteinte)
            if ($cursor < 100) {
                $segments[] = ['color' => '#cfd8d2', 'start' => $cursor, 'end' => 100];
            }
            return $segments;
        };

        $segD = $buildSegments($permisD, $totalD);
        $segE = $buildSegments($permisE, $totalE);

        $gradD = 'conic-gradient(' . collect($segD)->map(fn($s) => "{$s['color']} {$s['start']}% {$s['end']}%")->implode(', ') . ')';
        $gradE = 'conic-gradient(' . collect($segE)->map(fn($s) => "{$s['color']} {$s['start']}% {$s['end']}%")->implode(', ') . ')';

        // Donut global Permis D vs Permis E
        $pctGlobalD = $totalGlobal > 0 ? ($totalD / $totalGlobal) * 100 : 0;
        $gradGlobal = "conic-gradient(#1a6b3a 0% {$pctGlobalD}%, #d4a017 {$pctGlobalD}% 100%)";
    @endphp

    <style>
        /* ── Fond du contenu (image + voile clair pour garder la lisibilité) ── */
        .dash-bg {
            background:
                linear-gradient(rgba(243,246,244,0.94), rgba(243,246,244,0.94)),
                url('{{ $heroImage ?? asset('images/image6.JPEG') }}') center/cover no-repeat fixed;
            border-radius: 18px;
            padding: 24px;
            margin: -1.25rem -1.25rem 0;
        }

        /* ── KPI Hero ── */
        .kpi-row { display:grid; grid-template-columns:repeat(3, 1fr); gap:22px; margin-bottom:32px; }
        .kpi-card {
            background:#fff; border-radius:16px; padding:26px 24px;
            box-shadow: 0 2px 14px rgba(26,107,58,0.06);
            display:flex; align-items:center; gap:18px;
        }
        .kpi-icon {
            width:54px; height:54px; border-radius:14px; flex-shrink:0;
            display:flex; align-items:center; justify-content:center; font-size:1.4rem; color:#fff;
        }
        .kpi-num { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.7rem; line-height:1.1; color:#1a2520; }
        .kpi-label { font-size:0.8rem; color:#6b7a70; margin-top:2px; }

        /* ── Section card ── */
        .panel {
            background:#fff; border-radius:18px; padding:32px; margin-bottom:32px;
            box-shadow: 0 2px 14px rgba(26,107,58,0.06);
        }
        .panel-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:8px; }
        .panel-title {
            font-family:'Nunito',sans-serif; font-weight:800; font-size:1.05rem; color:#1a2520;
            display:flex; align-items:center; gap:10px;
        }
        .panel-title i { color:#1a6b3a; }
        .panel-total { font-size:0.8rem; color:#6b7a70; }
        .panel-total strong { color:#1a2520; }

        .panel-body { display:grid; grid-template-columns: 220px 1fr; gap:36px; align-items:center; }

        /* ── Anneau (donut) en CSS pur ── */
        .donut-wrap { display:flex; flex-direction:column; align-items:center; gap:10px; }
        .donut {
            width:180px; height:180px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            position:relative;
        }
        .donut::before {
            content:''; position:absolute; inset:16px; background:#fff; border-radius:50%;
        }
        .donut-center { position:relative; z-index:1; text-align:center; }
        .donut-center .num { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.6rem; color:#1a2520; }
        .donut-center .lbl { font-size:0.7rem; color:#6b7a70; text-transform:uppercase; letter-spacing:0.04em; }

        /* ── Étapes en grille aérée ── */
        .stage-grid { display:grid; grid-template-columns:repeat(5, 1fr); gap:16px; }
        .stage-tile {
            border-radius:14px; padding:20px 16px; text-align:center;
            border:1px solid #e6ece8;
        }
        .stage-tile .stage-label {
            font-family:'Nunito',sans-serif; font-weight:800; font-size:0.68rem;
            text-transform:uppercase; letter-spacing:0.05em; margin-bottom:10px; opacity:0.85;
        }
        .stage-tile .stage-num { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.9rem; }

        .tile-inscrits  { background:#e8f2ec; color:#1a6b3a; }
        .tile-code      { background:#fbeaea; color:#c0281e; }
        .tile-creneau   { background:#fdf8e1; color:#a87c10; }
        .tile-conduite  { background:#e3ede7; color:#0e4525; }
        .tile-admis     { background:#c0281e; color:#fff; }

        /* ── Légende d'un donut multi-catégories ── */
        .legend { display:flex; flex-direction:column; gap:2px; }
        .legend-item {
            display:flex; align-items:center; gap:10px;
            padding:10px 4px; font-size:0.85rem; color:#1a2520;
            border-bottom:1px solid #e6ece8;
        }
        .legend-item:last-child { border-bottom:none; }
        .legend-dot { width:11px; height:11px; border-radius:50%; flex-shrink:0; }
        .legend-item .legend-val { margin-left:auto; font-family:'Nunito',sans-serif; font-weight:800; }

        /* ── Panneau statistiques globales ── */
        .global-body { display:grid; grid-template-columns:220px 1fr; gap:36px; align-items:center; }
        .global-total { font-size:0.95rem; color:#6b7a70; margin-bottom:14px; }
        .global-total strong { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.3rem; color:#1a2520; }

        @media (max-width:1100px) {
            .kpi-row { grid-template-columns:1fr; }
            .panel-body, .global-body { grid-template-columns:1fr; }
            .stage-grid { grid-template-columns:repeat(2, 1fr); }
        }
    </style>

    <div class="dash-bg">

    {{-- ── KPI globaux ── --}}
    <div class="kpi-row">
        <div class="kpi-card">
            <div class="kpi-icon" style="background:#1a6b3a;"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="kpi-num">{{ $totalGlobal }}</div>
                <div class="kpi-label">Candidats au total</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon" style="background:#c0281e;"><i class="bi bi-bus-front-fill"></i></div>
            <div>
                <div class="kpi-num">{{ $totalD }}</div>
                <div class="kpi-label">Candidats Permis D</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon" style="background:#d4a017;"><i class="bi bi-truck-front-fill"></i></div>
            <div>
                <div class="kpi-num">{{ $totalE }}</div>
                <div class="kpi-label">Candidats Permis E</div>
            </div>
        </div>
    </div>

    {{-- ── Permis D ── --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-title"><i class="bi bi-bus-front"></i> Répartition par étape — Permis D</div>
            <div class="panel-total">Total : <strong>{{ $totalD }}</strong> candidats</div>
        </div>
        <div class="panel-body">
            <div class="donut-wrap">
                <div class="donut" style="background: {{ $gradD }};">
                    <div class="donut-center">
                        <div class="num">{{ $totalD }}</div>
                        <div class="lbl">Candidats</div>
                    </div>
                </div>
            </div>
            <div>
                <div class="stage-grid">
                    <div class="stage-tile tile-inscrits"><div class="stage-label">Inscrits</div><div class="stage-num">{{ $permisD['inscrits'] }}</div></div>
                    <div class="stage-tile tile-code"><div class="stage-label">Code</div><div class="stage-num">{{ $permisD['code'] }}</div></div>
                    <div class="stage-tile tile-creneau"><div class="stage-label">Créneau</div><div class="stage-num">{{ $permisD['creneau'] }}</div></div>
                    <div class="stage-tile tile-conduite"><div class="stage-label">Conduite en ville</div><div class="stage-num">{{ $permisD['conduite'] }}</div></div>
                    <div class="stage-tile tile-admis"><div class="stage-label">Admis</div><div class="stage-num">{{ $permisD['admis'] }}</div></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Permis E ── --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-title"><i class="bi bi-truck-front"></i> Répartition par étape — Permis E</div>
            <div class="panel-total">Total : <strong>{{ $totalE }}</strong> candidats</div>
        </div>
        <div class="panel-body">
            <div class="donut-wrap">
                <div class="donut" style="background: {{ $gradE }};">
                    <div class="donut-center">
                        <div class="num">{{ $totalE }}</div>
                        <div class="lbl">Candidats</div>
                    </div>
                </div>
            </div>
            <div>
                <div class="stage-grid">
                    <div class="stage-tile tile-inscrits"><div class="stage-label">Inscrits</div><div class="stage-num">{{ $permisE['inscrits'] }}</div></div>
                    <div class="stage-tile tile-code"><div class="stage-label">Code</div><div class="stage-num">{{ $permisE['code'] }}</div></div>
                    <div class="stage-tile tile-creneau"><div class="stage-label">Créneau</div><div class="stage-num">{{ $permisE['creneau'] }}</div></div>
                    <div class="stage-tile tile-conduite"><div class="stage-label">Conduite en ville</div><div class="stage-num">{{ $permisE['conduite'] }}</div></div>
                    <div class="stage-tile tile-admis"><div class="stage-label">Admis</div><div class="stage-num">{{ $permisE['admis'] }}</div></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Statistiques globales ── --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-title"><i class="bi bi-bar-chart-line"></i> Statistiques globales — Répartition par catégorie de permis</div>
        </div>
        <div class="global-body">
            <div class="donut-wrap">
                <div class="donut" style="background: {{ $gradGlobal }};">
                    <div class="donut-center">
                        <div class="num">{{ $totalGlobal }}</div>
                        <div class="lbl">Total</div>
                    </div>
                </div>
            </div>
            <div>
                <div class="global-total">Total candidats : <strong>{{ $totalGlobal }}</strong></div>
                <div class="legend">
                    <div class="legend-item"><span class="legend-dot" style="background:#1a6b3a;"></span> Permis D <span class="legend-val">{{ $totalD }}</span></div>
                    <div class="legend-item"><span class="legend-dot" style="background:#d4a017;"></span> Permis E <span class="legend-val">{{ $totalE }}</span></div>
                </div>
            </div>
        </div>
    </div>

    </div>{{-- /.dash-bg --}}

</x-layouts::app.sidebar>