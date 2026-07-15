<x-layouts::app title="Liste des Examens">
    <style>
        :root {
            /* Couleurs principales */
            --color-red: #CE1126;
            --color-green: #007A5E;
            --color-gold: #FCD116;
            
            /* Nuances */
            --color-red-light: #E85040;
            --color-red-dark: #A00D20;
            --color-green-light: #00A572;
            --color-green-dark: #004D3A;
            --color-gold-light: #FFE657;
            --color-gold-dark: #E5B800;
            
            /* Neutres */
            --color-dark: #1A1A1A;
            --color-light: #F8F8F8;
            --color-gray-100: #E8E8E8;
            --color-gray-200: #D1D1D1;
            --color-gray-500: #666666;
            
            /* Ombres */
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
            
            /* Transitions */
            --transition-normal: 300ms ease-in-out;
            
            /* Bordures */
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        /* --- CONFIGURATION POUR L'EXPORTATION PDF (IMPRESSION) --- */
        @media print {
            .header-section div:last-child, 
            table th:last-child, 
            table td:last-child,
            nav, .sidebar { 
                display: none !important; 
            }
            body { background: white !important; color: black !important; }
            .content-wrapper { padding: 0 !important; margin: 0 !important; }
            .header-section { 
                box-shadow: none !important; 
                border: 1px solid #ccc !important;
                margin-bottom: 2rem !important;
            }
            table { border-collapse: collapse !important; border: 1px solid #000 !important; }
            th { background: #f2f2f2 !important; color: black !important; border: 1px solid #000 !important; }
            td { border: 1px solid #ccc !important; }
        }

        /* --- Boîte de dialogue custom de confirmation de suppression --- */
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
        <!-- En-tête avec titre et bouton -->
        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <div>
                <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                    <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                    Liste des Examens
                </h1>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('examens.create') }}" 
                    style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; border: 2px solid var(--color-red); cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(206, 17, 38, 0.3)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    + Nouvel Examen
                </a>

                <!-- BOUTON EXPORTER (Fonctionnel) -->
                <button onclick="window.print()"
                    style="background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%); color: var(--color-dark); padding: 0.75rem 1.5rem; border-radius: var(--radius-md); border: 2px solid var(--color-gold); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(252, 209, 22, 0.3)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ⬇️ Exporter en PDF
                </button>
            </div>
        </div>

        @if(session('success'))
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-weight: 600;">
                {!! session('success') !!}
            </div>
        @endif

        <!-- Table container -->
        <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(90deg, var(--color-green) 0%, var(--color-green-light) 100%); color: white; font-weight: 600; text-transform: uppercase; font-size: 0.875rem; letter-spacing: 0.5px;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Libellé</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Phase</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Date Début</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Statut</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Moniteur</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Lieu de l'examen</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($examens as $examen)
                    <tr style="border-bottom: 1px solid var(--color-gray-100); transition: all var(--transition-normal);"
                        onmouseover="this.style.backgroundColor='rgba(0, 122, 94, 0.04)'"
                        onmouseout="this.style.backgroundColor='transparent'">
                        
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem; font-weight: 600;">
                            {{ $examen->libelle }}
                        </td>

                        {{-- Colonne Phase : distingue clairement Code / Créneau / Conduite,
                             pour éviter toute confusion avec un doublon visuel quand les
                             mêmes candidats apparaissent sur plusieurs examens de phases
                             différentes. --}}
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            @php
                                $typePhase = $examen->typeSession->type ?? null;
                                $phases = [
                                    'code'     => ['📘 Code', '#c0281e', 'rgba(192,40,30,0.1)'],
                                    'creneau'  => ['🅿️ Créneau', '#a87c10', 'rgba(168,124,16,0.1)'],
                                    'conduite' => ['🚗 Conduite', '#0e4525', 'rgba(14,69,37,0.1)'],
                                ];
                                [$phaseLabel, $phaseColor, $phaseBg] = $phases[$typePhase] ?? ['—', '#666', '#eee'];
                            @endphp
                            <span style="background:{{ $phaseBg }}; color:{{ $phaseColor }}; padding:0.3rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:800; text-transform:uppercase; letter-spacing:0.03em;">
                                {{ $phaseLabel }}
                            </span>
                        </td>
                        
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">
                            <span style="background: rgba(0, 122, 94, 0.1); color: var(--color-green); padding: 0.25rem 0.75rem; border-radius: var(--radius-md); font-size: 0.8rem; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($examen->dateDebut)->format('d/m/Y') }}
                            </span>
                        </td>
                        
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            @if($examen->statutExamen == 'en_attente')
                                <span style="background: rgba(252, 209, 22, 0.2); color: var(--color-gold-dark); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border: 1px solid var(--color-gold);">
                                    ⏳ En attente
                                </span>
                            @elseif($examen->statutExamen == 'admis')
                                <span style="background: rgba(0, 122, 94, 0.15); color: var(--color-green); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border: 1px solid var(--color-green-light);">
                                    🟢 Admis
                                </span>
                            @elseif($examen->statutExamen == 'ajourne')
                                <span style="background: rgba(206, 17, 38, 0.1); color: var(--color-red-dark); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border: 1px solid var(--color-red-light);">
                                    🔴 Ajourné
                                </span>
                            @elseif($examen->statutExamen == 'abandon')
                                <span style="background: var(--color-gray-100); color: var(--color-gray-500); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border: 1px solid var(--color-gray-200);">
                                    ⚪ Abandon
                                </span>
                            @else
                                <span style="background: var(--color-light); color: var(--color-dark); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                                    {{ $examen->statutExamen }}
                                </span>
                            @endif
                        </td>
                        
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">
                            @if($examen->moniteur)
                                <span style="font-weight: 500;">{{ $examen->moniteur->nom }} {{ $examen->moniteur->prenom }}</span>
                            @else
                                <span style="color: var(--color-gray-500); font-style: italic;">N/A</span>
                            @endif
                        </td>

                        {{-- Lieu de l'examen : colonne simple, alimentée par la colonne "lieu"
                             de la table examens (voir migration add_lieu_to_examens_table). --}}
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">
                            @if(!empty($examen->lieu))
                                <span style="display:inline-flex; align-items:center; gap:0.35rem; font-weight:500;">
                                    📍 {{ $examen->lieu }}
                                </span>
                            @else
                                <span style="color: var(--color-gray-500); font-style: italic;">N/A</span>
                            @endif
                        </td>
                        
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <!-- Bouton Voir -->
                                <a href="{{ route('examens.show', $examen->id) }}"
                                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: rgba(252,209,22,0.15); color: var(--color-gold-dark); border: none; cursor: pointer; transition: all var(--transition-normal); font-weight: bold; text-decoration: none; font-size: 1.1rem;"
                                    onmouseover="this.style.backgroundColor='var(--color-gold)'; this.style.color='var(--color-dark)'; this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.backgroundColor='rgba(252,209,22,0.15)'; this.style.color='var(--color-gold-dark)'; this.style.transform='scale(1)'"
                                    title="Voir détail">
                                    👁️
                                </a>

                                <!-- Bouton Éditer -->
                                <a href="{{ route('examens.edit', $examen->id) }}" 
                                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: var(--color-green); border: none; cursor: pointer; transition: all var(--transition-normal); font-weight: bold; text-decoration: none; font-size: 1.2rem;"
                                    onmouseover="this.style.backgroundColor='var(--color-green)'; this.style.color='white'; this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='var(--color-green)'; this.style.transform='scale(1)'"
                                    title="Éditer">
                                    ✎
                                </a>
                                
                                <!-- Bouton Supprimer : ouvre la boîte de dialogue custom au lieu du confirm() natif -->
                                <form id="delete-form-{{ $examen->id }}" method="POST" action="{{ route('examens.destroy', $examen->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button"
                                        onclick="openDeleteModal('delete-form-{{ $examen->id }}', '{{ addslashes($examen->libelle) }}')"
                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: #D32F2F; border: none; cursor: pointer; transition: all var(--transition-normal); font-weight: bold; font-size: 1.2rem; padding: 0;"
                                        onmouseover="this.style.backgroundColor='#D32F2F'; this.style.color='white'; this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='#D32F2F'; this.style.transform='scale(1)'"
                                        title="Supprimer">
                                    ✕
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding: 3rem; text-align: center; color: var(--color-gray-500);">
                            <p style="margin: 0; font-size: 1rem;">📭 Aucun examen trouvé</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Message de résumé -->
        @if($examens->count() > 0)
        <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark);">
            <strong>Total :</strong> {{ $examens->count() }} examen(s) répertorié(s)
        </div>
        @endif
    </div>

    <!-- Boîte de dialogue de confirmation de suppression -->
    <div id="deleteModalOverlay" class="del-modal-overlay">
        <div class="del-modal-box">
            <div class="del-modal-icon">🗑️</div>
            <h3 class="del-modal-title">Supprimer cet examen ?</h3>
            <p class="del-modal-text">
                Vous êtes sur le point de supprimer <strong id="deleteModalExamName">cet examen</strong>.
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
            document.getElementById('deleteModalExamName').textContent = libelle;
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