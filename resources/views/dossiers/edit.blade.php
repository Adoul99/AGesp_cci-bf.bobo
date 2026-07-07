<x-layouts::app.sidebar title="Modifier le Dossier">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-dark: #A00D20; --color-green-dark: #004D3A; --color-gray-100: #E8E8E8;
            --color-gray-200: #D1D1D1; --color-dark: #1A1A1A; --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --radius-md: 8px; --radius-lg: 12px; --transition-normal: 300ms ease-in-out;
        }

        /* ── Changement de couleur dès qu'on touche les boutons (survol / appui), avant même le clic ── */
        #btnValider:hover            { background: var(--color-red) !important; }
        #btnValider:active           { background: var(--color-red-dark) !important; transform: scale(0.97); }

        #btnRejeter:hover            { background: var(--color-green) !important; }
        #btnRejeter:active           { background: var(--color-green-dark) !important; transform: scale(0.97); }

        #btnConfirmerValidation:hover { background: var(--color-red) !important; }
        #btnConfirmerValidation:active { background: var(--color-red-dark) !important; transform: scale(0.96); }

        #btnConfirmerRejet:hover    { background: var(--color-green) !important; }
        #btnConfirmerRejet:active  { background: var(--color-green-dark) !important; transform: scale(0.96); }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Modifier Dossier : {{ $dossier->nomDossier }}
            </h1>
        </div>

        @if($errors->any())
            <div style="background:#fbeaea; border:1px solid #c0281e; border-radius:8px; padding:1rem 1.5rem; margin-bottom:1.5rem; color:#c0281e;">
                <strong>⚠️ Erreurs de validation :</strong>
                <ul style="margin: 0.5rem 0 0 1.2rem;">
                    @foreach($errors->all() as $error)
                        <li style="font-size:0.85rem;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dossiers.update', $dossier->id) }}" enctype="multipart/form-data" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
            @csrf
            @method('PUT')

            {{-- ── Champs requis par la validation mais non visibles ── --}}
            <input type="hidden" name="dateDepot"    value="{{ $dossier->dateDepot }}">
            <input type="hidden" name="description"  value="{{ $dossier->description }}">

            <!-- Informations Générales -->
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Informations du Dossier
                </h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    <div class="form-group">
                        <label for="candidat_id" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; text-transform: uppercase;">Candidat *</label>
                        <select name="candidat_id" id="candidat_id" style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md);" required>
                            @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}" {{ $dossier->candidat_id == $candidat->id ? 'selected' : '' }}>
                                    {{ $candidat->nom }} {{ $candidat->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nomDossier" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; text-transform: uppercase;">Nom du Dossier *</label>
                        <input type="text" name="nomDossier" id="nomDossier" value="{{ old('nomDossier', $dossier->nomDossier) }}" style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md);" required>
                    </div>
                </div>
            </div>

            <!-- Fichiers -->
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-red); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Gestion des Pièces Jointes
                </h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    @foreach(['cnib' => 'CNIB', 'photo_identite' => 'Photo Identité', 'certificat_medical' => 'Certificat Médical', 'acte_naissance' => 'Acte de Naissance', 'recu_paiement' => 'Reçu de Paiement', 'permis_c' => 'Copie Permis C'] as $field => $label)
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">{{ $label }}</label>
                            @if($dossier->$field)
                                <div style="margin-bottom: 0.5rem; font-size: 0.75rem; color: var(--color-green);">
                                    Actuel: <a href="{{ asset('storage/' . $dossier->$field) }}" target="_blank">Voir fichier</a>
                                </div>
                            @endif
                            <input type="file" name="{{ $field }}" id="{{ $field }}" style="width: 100%; padding: 0.5rem; border: 1px dashed var(--color-gray-200); border-radius: var(--radius-md);">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Décision Administrative -->
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-gold); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Décision Administrative
                </h2>

                <div style="background: rgba(252,209,22,0.06); border: 1px solid rgba(252,209,22,0.4); border-radius: var(--radius-md); padding: 1.25rem 1.5rem;">
                    <p style="font-size: 0.8rem; color: var(--color-dark); margin: 0 0 1.25rem 0;">
                        💬 Le statut et le message ci-dessous sont visibles par le candidat dans son espace personnel.
                    </p>

                    {{-- Statut actuel --}}
                    <div style="margin-bottom: 1.25rem; font-size: 0.85rem;">
                        Statut actuel :
                        @php
                            $statutActuel = old('statutDossier', $dossier->statutDossier);
                            $statutLabels = ['en_attente' => '⏳ En attente', 'valide' => '✅ Validé', 'rejete' => '❌ Rejeté'];
                        @endphp
                        <strong id="statutActuelLabel">{{ $statutLabels[$statutActuel] ?? $statutActuel }}</strong>
                    </div>

                    {{-- Champs cachés soumis avec le formulaire --}}
                    <input type="hidden" name="statutDossier" id="statutDossier" value="{{ $statutActuel }}">
                    <input type="hidden" name="commentaireAdmin" id="commentaireAdmin" value="{{ old('commentaireAdmin', $dossier->commentaireAdmin) }}">

                    {{-- Boutons de décision --}}
                    <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                        <button type="button" id="btnValider" onclick="ouvrirConfirmationValidation()"
                                style="display:flex; align-items:center; gap:0.5rem; background: var(--color-green); color:white; padding:0.75rem 1.5rem; border:none; border-radius: var(--radius-md); font-weight:600; cursor:pointer; font-size:0.9rem; transition: background 0.25s, transform 0.15s;">
                            ✅ Valider le dossier
                        </button>
                        <button type="button" id="btnRejeter" onclick="ouvrirMotifRejet()"
                                style="display:flex; align-items:center; gap:0.5rem; background: var(--color-red); color:white; padding:0.75rem 1.5rem; border:none; border-radius: var(--radius-md); font-weight:600; cursor:pointer; font-size:0.9rem; transition: background 0.25s, transform 0.15s;">
                            ❌ Rejeter le dossier
                        </button>
                    </div>

                    @if($dossier->commentaireAdmin)
                        <div style="margin-top:1.25rem; font-size:0.8rem; color:#555; background:white; border:1px solid var(--color-gray-200); border-radius:var(--radius-md); padding:0.85rem 1rem;">
                            <strong>Dernier message enregistré :</strong>
                            <div id="commentaireAffiche" style="margin-top:0.35rem;">{{ $dossier->commentaireAdmin }}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ── Modale : confirmation de validation ── --}}
            <div id="modaleValidation" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:1000; align-items:center; justify-content:center;">
                <div style="background:white; border-radius:var(--radius-lg); padding:2rem; max-width:420px; width:90%; box-shadow:0 10px 40px rgba(0,0,0,0.25);">
                    <h3 style="margin:0 0 0.75rem; font-size:1.1rem; color:var(--color-dark);">Valider ce dossier ?</h3>
                    <p style="font-size:0.85rem; color:#555; margin:0 0 1.5rem;">
                        Voulez-vous valider le dossier de <strong>{{ $dossier->nomDossier }}</strong> ?
                        Le candidat verra ce statut dans son espace personnel.
                    </p>
                    <div style="display:flex; gap:0.75rem; justify-content:flex-end;">
                        <button type="button" onclick="fermerModales()"
                                style="background: var(--color-gray-100); color: var(--color-dark); padding:0.65rem 1.25rem; border:none; border-radius:var(--radius-md); font-weight:600; cursor:pointer;">
                            Annuler
                        </button>
                        <button type="button" id="btnConfirmerValidation" onclick="confirmerValidation()"
                                style="background: var(--color-green); color:white; padding:0.65rem 1.25rem; border:none; border-radius:var(--radius-md); font-weight:600; cursor:pointer; transition: background 0.25s;">
                            ✓ Oui, valider
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Modale : motif du rejet ── --}}
            <div id="modaleRejet" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:1000; align-items:center; justify-content:center;">
                <div style="background:white; border-radius:var(--radius-lg); padding:2rem; max-width:480px; width:90%; box-shadow:0 10px 40px rgba(0,0,0,0.25);">
                    <h3 style="margin:0 0 0.75rem; font-size:1.1rem; color:var(--color-dark);">Rejeter ce dossier</h3>
                    <p style="font-size:0.85rem; color:#555; margin:0 0 1rem;">
                        Indiquez le motif du rejet pour <strong>{{ $dossier->nomDossier }}</strong>.
                        Ce message sera visible par le candidat.
                    </p>
                    <textarea id="motifRejetTexte" rows="4" maxlength="1000" placeholder="Ex : Votre certificat médical est illisible, merci de le renvoyer."
                              style="width:100%; padding:0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-family:inherit; resize:vertical; margin-bottom:0.5rem;"></textarea>
                    <div id="motifRejetErreur" style="display:none; color:var(--color-red); font-size:0.78rem; margin-bottom:1rem;">
                        Merci d'indiquer un motif avant de confirmer le rejet.
                    </div>
                    <div style="display:flex; gap:0.75rem; justify-content:flex-end; margin-top:1rem;">
                        <button type="button" onclick="fermerModales()"
                                style="background: var(--color-gray-100); color: var(--color-dark); padding:0.65rem 1.25rem; border:none; border-radius:var(--radius-md); font-weight:600; cursor:pointer;">
                            Annuler
                        </button>
                        <button type="button" id="btnConfirmerRejet" onclick="confirmerRejet()"
                                style="background: var(--color-red); color:white; padding:0.65rem 1.25rem; border:none; border-radius:var(--radius-md); font-weight:600; cursor:pointer; transition: background 0.25s;">
                            ✕ Confirmer le rejet
                        </button>
                    </div>
                </div>
            </div>

            <script>
                function ouvrirConfirmationValidation() {
                    // Feedback visuel immédiat sur le bouton cliqué
                    const btn = document.getElementById('btnValider');
                    btn.style.background = '#004D3A';
                    btn.style.transform = 'scale(0.97)';
                    setTimeout(() => { btn.style.transform = 'scale(1)'; }, 150);

                    document.getElementById('modaleValidation').style.display = 'flex';
                }
                function ouvrirMotifRejet() {
                    // Feedback visuel immédiat sur le bouton cliqué
                    const btn = document.getElementById('btnRejeter');
                    btn.style.background = '#A00D20';
                    btn.style.transform = 'scale(0.97)';
                    setTimeout(() => { btn.style.transform = 'scale(1)'; }, 150);

                    document.getElementById('motifRejetTexte').value = '';
                    document.getElementById('motifRejetErreur').style.display = 'none';
                    document.getElementById('modaleRejet').style.display = 'flex';
                }
                function fermerModales() {
                    document.getElementById('modaleValidation').style.display = 'none';
                    document.getElementById('modaleRejet').style.display = 'none';
                    // Remet les boutons principaux à leur couleur d'origine
                    document.getElementById('btnValider').style.background = 'var(--color-green)';
                    document.getElementById('btnRejeter').style.background = 'var(--color-red)';
                }
                function confirmerValidation() {
                    // Le bouton de confirmation change de couleur pour signaler que l'action est prise en compte
                    const btnConfirm = document.getElementById('btnConfirmerValidation');
                    btnConfirm.style.background = '#004D3A';
                    btnConfirm.textContent = '✓ Validation en cours...';
                    btnConfirm.disabled = true;

                    // Le bouton principal "Valider le dossier" reste dans sa couleur active
                    document.getElementById('btnValider').style.background = '#004D3A';

                    document.getElementById('statutDossier').value = 'valide';
                    document.getElementById('commentaireAdmin').value = document.getElementById('commentaireAdmin').value || '';
                    document.querySelector('form[action*="dossiers"]').submit();
                }
                function confirmerRejet() {
                    const motif = document.getElementById('motifRejetTexte').value.trim();
                    if (!motif) {
                        document.getElementById('motifRejetErreur').style.display = 'block';
                        return;
                    }

                    // Le bouton de confirmation change de couleur pour signaler que l'action est prise en compte
                    const btnConfirm = document.getElementById('btnConfirmerRejet');
                    btnConfirm.style.background = '#A00D20';
                    btnConfirm.textContent = '✕ Rejet en cours...';
                    btnConfirm.disabled = true;

                    // Le bouton principal "Rejeter le dossier" reste dans sa couleur active
                    document.getElementById('btnRejeter').style.background = '#A00D20';

                    document.getElementById('statutDossier').value = 'rejete';
                    document.getElementById('commentaireAdmin').value = motif;
                    document.querySelector('form[action*="dossiers"]').submit();
                }
            </script>

        </form>
    </div>
</x-layouts::app.sidebar>