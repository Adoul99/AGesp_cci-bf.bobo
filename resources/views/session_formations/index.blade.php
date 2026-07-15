<x-layouts::app title="Sessions de Formation">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-light: #E85040; --color-red-dark: #A00D20;
    --color-green-light: #00A572; --color-green-dark: #004D3A;
    --color-gold-light: #FFE657; --color-gold-dark: #E5B800;
    --color-dark: #1A1A1A; --color-light: #F8F8F8;
    --color-gray-100: #E8E8E8; --color-gray-200: #D1D1D1; --color-gray-500: #666666;
    --shadow-sm: 0 1px 2px rgba(0,0,0,0.05); --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --shadow-lg: 0 8px 24px rgba(0,0,0,0.15);
    --transition-normal: 300ms ease-in-out; --radius-md: 8px; --radius-lg: 12px;
}
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.6;transform:scale(1.3)} }
@media print {
    .no-print, nav, .sidebar { display: none !important; }
    body { background: white !important; }
}

/* --- Boîte de dialogue custom de confirmation de suppression (identique à examens/index) --- */
.del-modal-overlay {
    display: none; position: fixed; inset: 0; background: rgba(26,26,26,0.6);
    z-index: 1000; align-items: center; justify-content: center; padding: 1rem;
}
.del-modal-overlay.open { display: flex; }
.del-modal-box {
    background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);
    max-width: 420px; width: 100%; padding: 2rem; text-align: center;
    border-top: 5px solid var(--color-red);
}
.del-modal-icon {
    width: 56px; height: 56px; border-radius: 50%; background: rgba(206,17,38,0.1);
    display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;
    font-size: 1.6rem;
}
.del-modal-title { font-size: 1.1rem; font-weight: 800; color: var(--color-dark); margin: 0 0 0.5rem; }
.del-modal-text { font-size: 0.875rem; color: var(--color-gray-500); margin: 0 0 1.5rem; line-height: 1.5; }
.del-modal-actions { display: flex; gap: 0.75rem; justify-content: center; }
.del-modal-btn {
    padding: 0.7rem 1.5rem; border-radius: var(--radius-md); font-weight: 700; font-size: 0.85rem;
    cursor: pointer; border: 2px solid transparent; transition: all var(--transition-normal);
}
.del-modal-btn-cancel { background: var(--color-gray-100); color: var(--color-dark); }
.del-modal-btn-cancel:hover { background: var(--color-gray-200); }
.del-modal-btn-confirm { background: var(--color-red); color: white; border-color: var(--color-red); }
.del-modal-btn-confirm:hover { background: var(--color-red-dark); }
</style>

<div class="content-wrapper" style="padding: 2rem;">

    {{-- ALERTES --}}
    @if(session('success'))
        <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(0,122,94,0.1); border-left:4px solid var(--color-green); border-radius:var(--radius-md); color:var(--color-green-dark); font-weight:600;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark); font-weight:600;">
            {{ session('error') }}
        </div>
    @endif

    {{-- EN-TÊTE --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Sessions de Formation
        </h1>
        <div style="display:flex; gap:1rem; align-items:center;" class="no-print">

            {{-- Bouton création : bloqué seulement si les 3 types sont ouverts --}}
            @if(!$creationBloquee)
                <a href="{{ route('session_formations.create') }}"
                   style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:0.75rem 1.5rem; border-radius:var(--radius-md); text-decoration:none; font-weight:600; border:2px solid var(--color-red); display:inline-flex; align-items:center; gap:0.5rem; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px;"
                   onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    + Nouvelle Session
                </a>
            @else
                <span style="background:rgba(206,17,38,0.08); color:var(--color-red-dark); padding:0.75rem 1.5rem; border-radius:var(--radius-md); font-weight:600; border:2px solid var(--color-red-light); font-size:0.8rem; display:inline-flex; align-items:center; gap:0.5rem;"
                      title="Tous les types de sessions sont ouverts. Clôturez-en une d'abord.">
                    🔒 Tous types ouverts — création bloquée
                </span>
            @endif

            <button onclick="window.print()"
                style="background:linear-gradient(135deg,var(--color-gold) 0%,var(--color-gold-dark) 100%); color:var(--color-dark); padding:0.75rem 1.5rem; border-radius:var(--radius-md); border:2px solid var(--color-gold); font-weight:600; cursor:pointer; font-size:0.8rem; text-transform:uppercase;">
                ⬇️ Exporter PDF
            </button>
        </div>
    </div>

    {{-- BANDEAUX SESSIONS EN COURS (une par session ouverte) --}}
    @foreach($sessionsOuvertes as $sessionEnCours)
    <div style="margin-bottom:1.5rem; background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:2px solid var(--color-green); overflow:hidden;">
        <div style="background:linear-gradient(135deg,var(--color-green) 0%,var(--color-green-dark) 100%); padding:1rem 1.5rem; display:flex; align-items:center; justify-content:space-between;">
            <div style="color:white; font-weight:700; font-size:1rem; display:flex; align-items:center; gap:0.75rem;">
                <span style="width:12px; height:12px; background:var(--color-gold); border-radius:50%; display:inline-block; animation:pulse 1.5s infinite;"></span>
                🟢 SESSION EN COURS —
                @switch($sessionEnCours->typeSession?->type)
                    @case('code')     📋 CODE @break
                    @case('creneau')  🔧 CRÉNEAU @break
                    @case('conduite') 🚗 CONDUITE @break
                    @default {{ strtoupper($sessionEnCours->typeSession?->type ?? '—') }}
                @endswitch
            </div>
            <div style="color:rgba(255,255,255,0.85); font-size:0.8rem;">
                Depuis le {{ \Carbon\Carbon::parse($sessionEnCours->dateDebut)->format('d/m/Y') }}
            </div>
        </div>
        <div style="padding:1.25rem 1.5rem; display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:1rem; align-items:center;">
            <div>
                <div style="font-size:0.7rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700; letter-spacing:0.5px;">Groupe</div>
                <div style="font-weight:600; color:var(--color-dark); margin-top:0.25rem;">
                    {{ $sessionEnCours->groupe->nomGroupe ?? '—' }}
                </div>
            </div>
            <div>
                <div style="font-size:0.7rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700; letter-spacing:0.5px;">Moniteur</div>
                <div style="font-weight:600; color:var(--color-dark); margin-top:0.25rem;">
                    {{ $sessionEnCours->moniteur ? $sessionEnCours->moniteur->nom.' '.$sessionEnCours->moniteur->prenom : '—' }}
                </div>
            </div>
            <div>
                <div style="font-size:0.7rem; text-transform:uppercase; color:var(--color-gray-500); font-weight:700; letter-spacing:0.5px;">Candidats</div>
                <div style="font-weight:600; color:var(--color-dark); margin-top:0.25rem;">
                    {{ $sessionEnCours->candidats->count() }} inscrit(s)
                </div>
            </div>
            <div style="display:flex; gap:0.75rem; justify-content:flex-end;" class="no-print">
                <a href="{{ route('session_formations.edit', $sessionEnCours->id) }}"
                   style="padding:0.6rem 1.25rem; background:rgba(0,122,94,0.1); color:var(--color-green-dark); border:2px solid var(--color-green); border-radius:var(--radius-md); font-weight:600; text-decoration:none; font-size:0.8rem;">
                    ✎ Modifier
                </a>
                <a href="{{ route('session_formations.cloture', $sessionEnCours->id) }}"
                   style="padding:0.6rem 1.25rem; background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; border:2px solid var(--color-red); border-radius:var(--radius-md); font-weight:600; text-decoration:none; font-size:0.8rem;">
                    🔒 Clôturer
                </a>
            </div>
        </div>
    </div>
    @endforeach

    {{-- TABLEAU HISTORIQUE --}}
    <div style="background:white; border-radius:var(--radius-lg); overflow:hidden; box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100);">
        <div style="padding:1rem 1.5rem; border-bottom:2px solid var(--color-gold); background:rgba(252,209,22,0.05);">
            <h2 style="margin:0; font-size:1rem; font-weight:700; color:var(--color-dark);">📋 Historique des sessions</h2>
        </div>
        <table style="width:100%; border-collapse:collapse;">
            <thead style="background:linear-gradient(90deg,var(--color-green) 0%,var(--color-green-light) 100%); color:white; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px;">
                <tr>
                    <th style="padding:1rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Date</th>
                    <th style="padding:1rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Type de Session</th>
                    <th style="padding:1rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Statut</th>
                    <th style="padding:1rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Groupe</th>
                    <th style="padding:1rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Moniteur</th>
                    <th style="padding:1rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Candidats</th>
                    <th style="padding:1rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);" class="no-print">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sessions as $session)
                <tr style="border-bottom:1px solid var(--color-gray-100); {{ $session->est_ouverte ? 'background:rgba(0,122,94,0.03);' : '' }}"
                    onmouseover="this.style.backgroundColor='rgba(0,122,94,0.06)'"
                    onmouseout="this.style.backgroundColor='{{ $session->est_ouverte ? 'rgba(0,122,94,0.03)' : 'transparent' }}'">
                    <td style="padding:0.875rem 1.25rem; font-weight:600; font-size:0.875rem; color:var(--color-dark);">
                        📅 {{ \Carbon\Carbon::parse($session->dateDebut)->format('d/m/Y') }}
                    </td>
                    <td style="padding:0.875rem 1.25rem; font-size:0.875rem; color:var(--color-dark);">
                        @if($session->typeSession)
                            @switch($session->typeSession->type)
                                @case('code')     📋 Code @break
                                @case('creneau')  🔧 Créneau @break
                                @case('conduite') 🚗 Conduite @break
                                @default {{ $session->typeSession->type }}
                            @endswitch
                        @else <span style="color:var(--color-gray-500); font-style:italic;">—</span> @endif
                    </td>
                    <td style="padding:0.875rem 1.25rem; text-align:center;">
                        @if($session->statutSession == 'ouvert')
                            <span style="background:rgba(0,122,94,0.15); color:var(--color-green); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:700; text-transform:uppercase; border:1px solid var(--color-green-light);">🟢 Ouvert</span>
                        @elseif($session->statutSession == 'ferme')
                            <span style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:700; text-transform:uppercase; border:1px solid var(--color-red-light);">🔴 Fermé</span>
                        @else
                            <span style="background:var(--color-gray-100); color:var(--color-gray-500); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:700; text-transform:uppercase;">⚪ Annulé</span>
                        @endif
                    </td>
                    <td style="padding:0.875rem 1.25rem; font-size:0.875rem; color:var(--color-dark);">
                        {{ $session->groupe->nomGroupe ?? '—' }}
                    </td>
                    <td style="padding:0.875rem 1.25rem; font-size:0.875rem; color:var(--color-dark);">
                        {{ $session->moniteur ? $session->moniteur->nom.' '.$session->moniteur->prenom : '—' }}
                    </td>
                    <td style="padding:0.875rem 1.25rem; text-align:center; font-size:0.875rem; font-weight:600; color:var(--color-dark);">
                        {{ $session->candidats->count() }}
                    </td>
                    <td style="padding:0.875rem 1.25rem; text-align:center;" class="no-print">
                        <div style="display:flex; gap:0.4rem; justify-content:center;">
                            @if($session->est_ouverte)
                                <a href="{{ route('session_formations.edit', $session->id) }}"
                                   style="padding:0.4rem 0.85rem; background:rgba(0,122,94,0.1); color:var(--color-green); border:1.5px solid var(--color-green); border-radius:var(--radius-md); font-size:0.75rem; font-weight:600; text-decoration:none;" title="Modifier">✎</a>
                                <a href="{{ route('session_formations.cloture', $session->id) }}"
                                   style="padding:0.4rem 0.85rem; background:rgba(206,17,38,0.1); color:var(--color-red); border:1.5px solid var(--color-red); border-radius:var(--radius-md); font-size:0.75rem; font-weight:600; text-decoration:none;" title="Clôturer">🔒</a>
                            @else
                                <span style="color:var(--color-gray-500); font-size:0.75rem; font-style:italic;">Archivée</span>
                            @endif

                            {{-- Bouton Supprimer : ouvre la boîte de dialogue custom au lieu du confirm() natif --}}
                            <form id="delete-session-form-{{ $session->id }}" method="POST" action="{{ route('session_formations.destroy', $session->id) }}" style="display:inline;">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button"
                                    onclick="openDeleteModal('delete-session-form-{{ $session->id }}', '{{ addslashes(($session->typeSession->type ?? 'session') . ' du ' . \Carbon\Carbon::parse($session->dateDebut)->format('d/m/Y')) }}')"
                                    style="padding:0.4rem 0.7rem; background:rgba(206,17,38,0.08); color:#D32F2F; border:1.5px solid #D32F2F; border-radius:var(--radius-md); cursor:pointer; font-size:0.75rem;" title="Supprimer">✕</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:3rem; text-align:center; color:var(--color-gray-500);">
                        📭 Aucune session enregistrée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($sessions->count() > 0)
    <div style="margin-top:1.5rem; padding:1rem; background:rgba(0,122,94,0.08); border-left:4px solid var(--color-green); border-radius:var(--radius-md); color:var(--color-green-dark); font-size:0.875rem;">
        <strong>Total :</strong> {{ $sessions->count() }} session(s) —
        {{ $sessions->where('statutSession','ouvert')->count() }} ouverte(s),
        {{ $sessions->where('statutSession','ferme')->count() }} clôturée(s)
    </div>
    @endif

</div>

{{-- Boîte de dialogue de confirmation de suppression --}}
<div id="deleteModalOverlay" class="del-modal-overlay">
    <div class="del-modal-box">
        <div class="del-modal-icon">🗑️</div>
        <h3 class="del-modal-title">Supprimer cette session ?</h3>
        <p class="del-modal-text">
            Vous êtes sur le point de supprimer <strong id="deleteModalSessionName">cette session</strong>.
            Cette action est <strong>irréversible</strong>.
        </p>
        <div class="del-modal-actions">
            <button type="button" class="del-modal-btn del-modal-btn-cancel" onclick="closeDeleteModal()">Annuler</button>
            <button type="button" class="del-modal-btn del-modal-btn-confirm" id="deleteModalConfirmBtn">✕ Supprimer</button>
        </div>
    </div>
</div>

<script>
    var formIdASupprimer = null;

    function openDeleteModal(formId, libelle) {
        formIdASupprimer = formId;
        document.getElementById('deleteModalSessionName').textContent = libelle;
        document.getElementById('deleteModalOverlay').classList.add('open');
    }

    function closeDeleteModal() {
        formIdASupprimer = null;
        document.getElementById('deleteModalOverlay').classList.remove('open');
    }

    document.getElementById('deleteModalConfirmBtn').addEventListener('click', function() {
        if (formIdASupprimer) {
            document.getElementById(formIdASupprimer).submit();
        }
    });

    document.getElementById('deleteModalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
</x-layouts::app>