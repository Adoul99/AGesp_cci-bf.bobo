<x-layouts::app.sidebar title="Nouvelle Session de Formation">
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
                Nouvelle Session de Formation
            </h1>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('session_formations.store') }}" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            @csrf
            
            <!-- Section: Paramètres de la session -->
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Configuration de la Session
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    
                    <!-- Date Début -->
                    <div class="form-group">
                        <label for="dateDebut" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Date Début <span style="color: var(--color-red);">*</span>
                        </label>
                        <input type="date" 
                               id="dateDebut"
                               name="dateDebut" 
                               value="{{ old('dateDebut') }}"
                               style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark);"
                               onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                               onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                               required>
                    </div>

                    <!-- Statut -->
                    <div class="form-group">
                        <label for="statutSession" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Statut <span style="color: var(--color-red);">*</span>
                        </label>
                        <select id="statutSession"
                                name="statutSession" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                                required>
                            <option value="ouvert">Ouvert</option>
                            <option value="ferme">Fermé</option>
                            <option value="annule">Annulé</option>
                        </select>
                    </div>

                    <!-- Type de Session -->
                    <div class="form-group">
                        <label for="typeSession_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Type de Session <span style="color: var(--color-red);">*</span>
                        </label>
                        <select id="typeSession_id"
                                name="typeSession_id" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                                required>
                            <option value="">-- Choisir un type de session --</option>
                            @foreach($typesSessions as $type)
                                <option value="{{ $type->id }}" {{ old('typeSession_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->nomTypeSession ?? $type->code }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Véhicule -->
                    <div class="form-group">
                        <label for="vehicule_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Véhicule
                        </label>
                        <select id="vehicule_id"
                                name="vehicule_id" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">
                            <option value="">-- Choisir un véhicule --</option>
                            @foreach($vehicules as $vehicule)
                                <option value="{{ $vehicule->id }}">{{ $vehicule->nomVehicule }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Groupe -->
                    <div class="form-group">
                        <label for="groupe_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Groupe
                        </label>
                        <select id="groupe_id"
                                name="groupe_id" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">
                            <option value="">-- Choisir un groupe --</option>
                            @foreach($groupes as $groupe)
                                <option value="{{ $groupe->id }}">{{ $groupe->nomGroupe }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Évaluation -->
                    <div class="form-group" style="grid-column: span 2;">
                        <label for="evaluation_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Évaluation
                        </label>
                        <select id="evaluation_id"
                                name="evaluation_id" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">
                            <option value="">-- Choisir une évaluation --</option>
                            @foreach($evaluations as $evaluation)
                                <option value="{{ $evaluation->id }}">{{ $evaluation->resultat }} - ({{ \Carbon\Carbon::parse($evaluation->dateEvaluation)->format('d/m/Y') }})</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <!-- Boutons d'action -->
            <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-gray-100);">
                <!-- Enregistrer -->
                <button type="submit" 
                        style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-red); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.875rem;"
                        onmouseover="this.style.transform='translateY(-2px)';"
                        onmouseout="this.style.transform='translateY(0)';"
                >
                    ✓ Enregistrer
                </button>

                <!-- Annuler -->
                <a href="{{ route('session_formations.index') }}" 
                   style="background: linear-gradient(135deg, var(--color-gray-200) 0%, var(--color-gray-100) 100%); color: var(--color-dark); padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-gray-200); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); text-decoration: none; font-size: 0.875rem;"
                   onmouseover="this.style.transform='translateY(-2px)';"
                   onmouseout="this.style.transform='translateY(0)';"
                >
                    ✕ Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>