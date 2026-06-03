<x-layouts::app.sidebar title="Nouvelle Session de Formation">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-light: #E85040; --color-red-dark: #A00D20;
            --color-green-light: #00A572; --color-green-dark: #004D3A;
            --color-gold-light: #FFE657; --color-gold-dark: #E5B800;
            --color-dark: #1A1A1A; --color-light: #F8F8F8;
            --color-gray-100: #E8E8E8; --color-gray-200: #D1D1D1; --color-gray-500: #666666;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05); --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --transition-normal: 300ms ease-in-out; --radius-md: 8px; --radius-lg: 12px;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">

        {{-- Message succès --}}
        @if(session('success'))
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(0,122,94,0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-weight: 600;">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- En-tête --}}
        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Nouvelle Session de Formation
            </h1>
        </div>

        <form method="POST" action="{{ route('session_formations.store') }}" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            @csrf

            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Configuration de la Session
                </h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">

                    {{-- Date Début --}}
                    <div class="form-group">
                        <label for="dateDebut" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Date Début <span style="color: var(--color-red);">*</span>
                        </label>
                        <input type="date" id="dateDebut" name="dateDebut"
                               value="{{ old('dateDebut') }}"
                               style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark);"
                               onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                               onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                               required>
                        @error('dateDebut')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Statut --}}
                    <div class="form-group">
                        <label for="statutSession" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Statut <span style="color: var(--color-red);">*</span>
                        </label>
                        <select id="statutSession" name="statutSession"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                                required>
                            <option value="ouvert"  {{ old('statutSession') == 'ouvert'  ? 'selected' : '' }}>🟢 Ouvert</option>
                            <option value="ferme"   {{ old('statutSession') == 'ferme'   ? 'selected' : '' }}>🔴 Fermé</option>
                            <option value="annule"  {{ old('statutSession') == 'annule'  ? 'selected' : '' }}>⚪ Annulé</option>
                        </select>
                        @error('statutSession')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ✅ Type de Session — corrigé --}}
                    <div class="form-group">
                        <label for="typeSession_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Type de Session <span style="color: var(--color-red);">*</span>
                        </label>
                        <select id="typeSession_id" name="typeSession_id"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                                required>
                            <option value="">-- Choisir un type de session --</option>
                            @foreach($typesSessions as $type)
                                <option value="{{ $type->id }}" {{ old('typeSession_id') == $type->id ? 'selected' : '' }}>
                                    @switch($type->type)
                                        @case('code')     📋 Code      @break
                                        @case('creneau')  🔧 Créneau   @break
                                        @case('conduite') 🚗 Conduite  @break
                                        @default          {{ $type->type }}
                                    @endswitch
                                    @if($type->description)
                                        — {{ $type->description }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('typeSession_id')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Véhicule --}}
                    <div class="form-group">
                        <label for="vehicule_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Véhicule <span style="color: var(--color-gray-500); font-weight: 400; font-size: 0.75rem;">(Facultatif)</span>
                        </label>
                        <select id="vehicule_id" name="vehicule_id"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">
                            <option value="">-- Choisir un véhicule --</option>
                            @foreach($vehicules as $vehicule)
                                <option value="{{ $vehicule->id }}" {{ old('vehicule_id') == $vehicule->id ? 'selected' : '' }}>
                                    🚗 {{ $vehicule->nomVehicule }}
                                </option>
                            @endforeach
                        </select>
                        @error('vehicule_id')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Groupe --}}
                    <div class="form-group">
                        <label for="groupe_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Groupe <span style="color: var(--color-gray-500); font-weight: 400; font-size: 0.75rem;">(Facultatif)</span>
                        </label>
                        <select id="groupe_id" name="groupe_id"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">
                            <option value="">-- Choisir un groupe --</option>
                            @foreach($groupes as $groupe)
                                <option value="{{ $groupe->id }}" {{ old('groupe_id') == $groupe->id ? 'selected' : '' }}>
                                    👥 {{ $groupe->nomGroupe }}
                                </option>
                            @endforeach
                        </select>
                        @error('groupe_id')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Évaluation --}}
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="evaluation_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Évaluation <span style="color: var(--color-gray-500); font-weight: 400; font-size: 0.75rem;">(Facultatif)</span>
                        </label>
                        <select id="evaluation_id" name="evaluation_id"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">
                            <option value="">-- Choisir une évaluation --</option>
                            @foreach($evaluations as $evaluation)
                                <option value="{{ $evaluation->id }}" {{ old('evaluation_id') == $evaluation->id ? 'selected' : '' }}>
                                    {{-- ✅ Affiche le candidat + note + date --}}
                                    {{ $evaluation->candidat->nom ?? 'N/A' }} {{ $evaluation->candidat->prenom ?? '' }}
                                    @if(!is_null($evaluation->note))
                                        — Note : {{ $evaluation->note }}/30
                                        ({{ $evaluation->note >= 25 ? '✅ Admis' : '❌ Ajourné' }})
                                    @else
                                        — En attente
                                    @endif
                                    — {{ \Carbon\Carbon::parse($evaluation->dateEvaluation)->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('evaluation_id')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Erreurs globales --}}
            @if ($errors->any())
                <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(206,17,38,0.1); border-left: 4px solid var(--color-red); border-radius: var(--radius-md); color: var(--color-red-dark);">
                    <strong>⚠️ Erreurs de validation :</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li style="margin: 0.25rem 0;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Boutons --}}
            <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-gray-100);">
                <button type="submit"
                        style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-red); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.875rem;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(206,17,38,0.3)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✓ Enregistrer
                </button>
                <a href="{{ route('session_formations.index') }}"
                   style="background: linear-gradient(135deg, var(--color-gray-200) 0%, var(--color-gray-100) 100%); color: var(--color-dark); padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-gray-200); font-weight: 600; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); text-decoration: none; font-size: 0.875rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0,0,0,0.1)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✕ Annuler
                </a>
            </div>
        </form>

        {{-- Info --}}
        <div style="margin-top: 2rem; padding: 1rem; background: rgba(0,122,94,0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-size: 0.875rem;">
            <strong>ℹ️ Information :</strong> Les champs marqués avec <span style="color: var(--color-red); font-weight: bold;">*</span> sont obligatoires. Le véhicule, le groupe et l'évaluation sont facultatifs.
        </div>
    </div>
</x-layouts::app.sidebar>