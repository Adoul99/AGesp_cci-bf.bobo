<x-layouts::app.sidebar title="Nouvelle Évaluation">
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
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        <!-- En-tête de la page -->
        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Nouvelle Évaluation
            </h1>
        </div>

        <!-- Formulaire de saisie -->
        <form method="POST" action="{{ route('evaluations.store') }}" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            @csrf
            
            <!-- Section 1: Informations de l'évaluation -->
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Informations de l'Évaluation
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    
                    <!-- Date Évaluation -->
                    <div class="form-group">
                        <label for="dateEvaluation" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Date Évaluation <span style="color: var(--color-red);">*</span>
                        </label>
                        <input type="date" 
                               id="dateEvaluation"
                               name="dateEvaluation" 
                               value="{{ old('dateEvaluation') }}"
                               style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark);"
                               onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                               onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                               required>
                        @error('dateEvaluation')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Résultat -->
                    <div class="form-group">
                        <label for="resultat" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Résultat <span style="color: var(--color-red);">*</span>
                        </label>
                        <select id="resultat"
                                name="resultat" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                                required>
                            <option value="">-- Choisir un résultat --</option>
                            <option value="Admis" {{ old('resultat') == 'Admis' ? 'selected' : '' }}>Admis</option>
                            <option value="Ajourné" {{ old('resultat') == 'Ajourné' ? 'selected' : '' }}>Ajourné</option>
                            <option value="Absent" {{ old('resultat') == 'Absent' ? 'selected' : '' }}>Absent</option>
                            <option value="Eliminé" {{ old('resultat') == 'Eliminé' ? 'selected' : '' }}>Éliminé</option>
                        </select>
                        @error('resultat')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="form-group">
                        <label for="statut" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Statut <span style="color: var(--color-red);">*</span>
                        </label>
                        <select id="statut"
                                name="statut" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                                required>
                            <option value="en_attente" {{ old('statut', 'en_attente') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="reussi" {{ old('statut') == 'reussi' ? 'selected' : '' }}>Réussi</option>
                            <option value="echoue" {{ old('statut') == 'echoue' ? 'selected' : '' }}>Échoué</option>
                        </select>
                        @error('statut')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Moniteur -->
                    <div class="form-group">
                        <label for="moniteur_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Moniteur <span style="color: var(--color-gray-500); font-weight: 400; font-size: 0.75rem;">(Facultatif)</span>
                        </label>
                        <select id="moniteur_id"
                                name="moniteur_id" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">
                            <option value="">-- Choisir un moniteur --</option>
                            @foreach($moniteurs as $moniteur)
                                <option value="{{ $moniteur->id }}" {{ old('moniteur_id') == $moniteur->id ? 'selected' : '' }}>
                                    {{ $moniteur->nom }} {{ $moniteur->prenom }}
                                </option>
                            @endforeach
                        </select>
                        @error('moniteur_id')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Messages d'erreur de validation généraux -->
            @if ($errors->any())
                <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(206, 17, 38, 0.1); border-left: 4px solid var(--color-red); border-radius: var(--radius-md); color: var(--color-red-dark);">
                    <strong>⚠️ Erreurs de validation :</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li style="margin: 0.25rem 0;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-gray-100);">
                <!-- Bouton Enregistrer (Rouge) -->
                <button type="submit" 
                        style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-red); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.875rem;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(206, 17, 38, 0.3)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✓ Enregistrer
                </button>

                <!-- Bouton Annuler (Gris) -->
                <a href="{{ route('evaluations.index') }}" 
                   style="background: linear-gradient(135deg, var(--color-gray-200) 0%, var(--color-gray-100) 100%); color: var(--color-dark); padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-gray-200); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); text-decoration: none; font-size: 0.875rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0, 0, 0, 0.1)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✕ Annuler
                </a>
            </div>
        </form>

        <!-- Note informative en bas -->
        <div style="margin-top: 2rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-size: 0.875rem;">
            <strong>ℹ️ Information :</strong> Les champs marqués avec un <span style="color: var(--color-red); font-weight: bold;">*</span> sont obligatoires. Veillez à attribuer le bon moniteur si nécessaire.
        </div>
    </div>
</x-layouts::app.sidebar>