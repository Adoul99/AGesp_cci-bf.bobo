<x-layouts::app.sidebar title="Modifier Groupe">
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
            
            /* Transitions & Bordures */
            --transition-normal: 300ms ease-in-out;
            --radius-md: 8px;
            --radius-lg: 12px;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        
        <!-- En-tête avec titre -->
        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Modifier Groupe
            </h1>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('groupes.update', $groupe->id) }}" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            @csrf
            @method('PUT')
            
            <!-- Section: Détails du groupe -->
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Édition des Paramètres
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    
                    <!-- Nom du Groupe -->
                    <div class="form-group">
                        <label for="nomGroupe" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Nom Groupe <span style="color: var(--color-red);">*</span>
                        </label>
                        <input type="text" 
                               id="nomGroupe"
                               name="nomGroupe" 
                               value="{{ old('nomGroupe', $groupe->nomGroupe) }}"
                               style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark);"
                               onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                               onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                               required>
                    </div>

                    <!-- Date Début Formation -->
                    <div class="form-group">
                        <label for="dateDebutFormation" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Date Début Formation <span style="color: var(--color-red);">*</span>
                        </label>
                        <input type="date" 
                               id="dateDebutFormation"
                               name="dateDebutFormation" 
                               value="{{ old('dateDebutFormation', $groupe->dateDebutFormation) }}"
                               style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark);"
                               onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                               onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                               required>
                    </div>

                    <!-- Sélection des candidats -->
                    <div class="form-group" style="grid-column: span 2;">
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <label style="display: block; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                                Candidats <span style="color: var(--color-gray-500); font-size: 0.75rem; font-weight: normal;">(Gérer les affectations)</span>
                            </label>

                            <!-- Filtre : afficher uniquement les candidats sans groupe -->
                            <label for="filtreSansGroupe" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.8125rem; font-weight: 600; color: var(--color-green-dark); background-color: rgba(0, 122, 94, 0.08); padding: 0.5rem 0.875rem; border-radius: var(--radius-md); border: 1px solid rgba(0, 122, 94, 0.25);">
                                <input type="checkbox" id="filtreSansGroupe" onchange="filtrerCandidatsSansGroupe()" style="width: 1.1rem; height: 1.1rem; accent-color: var(--color-green); cursor: pointer;">
                                🔍 Afficher uniquement les candidats sans groupe
                            </label>
                        </div>

                        <div id="listeCandidats" style="border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); padding: 1.25rem; display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; max-height: 250px; overflow-y: auto; background-color: var(--color-light);">
                            @foreach($candidats as $candidat)
                                @php
                                    $groupeExistant = $candidat->groupes->first();
                                    $dejaDansAutreGroupe = $groupeExistant && $groupeExistant->id != $groupe->id;
                                @endphp
                                @if($dejaDansAutreGroupe)
                                    <label class="candidat-item" data-assigned="1" style="display: flex; align-items: center; gap: 0.75rem; cursor: not-allowed; opacity: 0.6; font-size: 0.875rem; color: var(--color-gray-500); background-color: white; padding: 0.5rem 0.75rem; border-radius: var(--radius-md); border: 1px dashed var(--color-gray-200);">
                                        <input type="checkbox" disabled style="width: 1.1rem; height: 1.1rem; accent-color: var(--color-green);">
                                        <span>
                                            <strong>{{ $candidat->nom }} {{ $candidat->prenom }}</strong>
                                            <br>
                                            <span style="color: var(--color-red); font-size: 0.75rem; font-weight: 500;">🔒 Déjà dans : {{ $groupeExistant->nomGroupe }}</span>
                                        </span>
                                    </label>
                                @else
                                    <label class="candidat-item" data-assigned="0" style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; font-size: 0.875rem; background-color: white; padding: 0.5rem 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--color-gray-100); transition: all var(--transition-normal);"
                                           onmouseover="this.style.borderColor='var(--color-green)'; this.style.boxShadow='var(--shadow-sm)'"
                                           onmouseout="this.style.borderColor='var(--color-gray-100)'; this.style.boxShadow='none'">
                                        <input type="checkbox" name="candidat_ids[]" value="{{ $candidat->id }}" 
                                               {{ in_array($candidat->id, $candidatsSelectionnes) ? 'checked' : '' }}
                                               style="width: 1.1rem; height: 1.1rem; accent-color: var(--color-green); cursor: pointer;">
                                        <strong>{{ $candidat->nom }} {{ $candidat->prenom }}</strong>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                        <div id="aucunCandidatDisponible" style="display: none; text-align: center; padding: 1rem; color: var(--color-gray-500); font-size: 0.875rem; font-style: italic;">
                            Aucun candidat sans groupe pour le moment.
                        </div>
                    </div>

                </div>
            </div>

            <!-- Boutons d'action -->
            <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-gray-100);">
                <!-- Bouton Mettre à jour (Vert) -->
                <button type="submit" 
                        style="background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%); color: white; padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-green); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.875rem;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0, 122, 94, 0.3)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✓ Mettre à jour
                </button>

                <!-- Bouton Annuler (Gris) -->
                <a href="{{ route('groupes.index') }}" 
                   style="background: linear-gradient(135deg, var(--color-gray-200) 0%, var(--color-gray-100) 100%); color: var(--color-dark); padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-gray-200); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); text-decoration: none; font-size: 0.875rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0, 0, 0, 0.1)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✕ Annuler
                </a>
            </div>
        </form>
    </div>

    <script>
        function filtrerCandidatsSansGroupe() {
            const filtreActif = document.getElementById('filtreSansGroupe').checked;
            const items = document.querySelectorAll('#listeCandidats .candidat-item');
            let nbVisibles = 0;

            items.forEach(function (item) {
                const estDejaAffecte = item.dataset.assigned === '1';
                if (filtreActif && estDejaAffecte) {
                    item.style.display = 'none';
                } else {
                    item.style.display = 'flex';
                    nbVisibles++;
                }
            });

            document.getElementById('aucunCandidatDisponible').style.display = (nbVisibles === 0) ? 'block' : 'none';
        }
    </script>
</x-layouts::app.sidebar>