<x-layouts::app.sidebar title="Modifier Évaluation">
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

        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Modifier Évaluation
            </h1>
        </div>

        {{-- Carte résultat actuel --}}
        <div style="margin-bottom: 1.5rem; padding: 1rem 1.5rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-100); display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
            <div style="font-size: 0.8rem; color: var(--color-gray-500); text-transform: uppercase; font-weight: 600;">Résultat actuel :</div>
            @if(!is_null($evaluation->note))
                <span style="font-size: 1.4rem; font-weight: 800; color: {{ $evaluation->note >= 25 ? 'var(--color-green)' : 'var(--color-red)' }};">
                    {{ $evaluation->note }}/30
                </span>
                @if($evaluation->note >= 25)
                    <span style="background: rgba(0,122,94,0.15); color: var(--color-green); padding: 0.35rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; border: 1px solid var(--color-green-light);">🟢 ADMIS</span>
                @else
                    <span style="background: rgba(206,17,38,0.1); color: var(--color-red-dark); padding: 0.35rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; border: 1px solid var(--color-red-light);">🔴 AJOURNÉ</span>
                @endif
            @else
                <span style="background: rgba(252,209,22,0.2); color: var(--color-gold-dark); padding: 0.35rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; border: 1px solid var(--color-gold);">⏳ Pas encore noté</span>
            @endif
            <div style="font-size: 0.8rem; color: var(--color-gray-500);">
                Candidat : <strong>{{ $evaluation->candidat->nom ?? 'N/A' }} {{ $evaluation->candidat->prenom ?? '' }}</strong>
            </div>
            @if($evaluation->typeSession)
                <div style="font-size: 0.8rem; color: var(--color-gray-500);">
                    Type :
                    <strong>
                        @switch($evaluation->typeSession->type)
                            @case('code')     📋 Code      @break
                            @case('creneau')  🔧 Créneau   @break
                            @case('conduite') 🚗 Conduite  @break
                            @default          {{ $evaluation->typeSession->type }}
                        @endswitch
                    </strong>
                </div>
            @endif
        </div>

        <form method="POST" action="{{ route('evaluations.update', $evaluation->id) }}" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Informations de l'Évaluation
                </h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">

                    {{-- Candidat --}}
                    <div class="form-group">
                        <label for="candidat_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Candidat <span style="color: var(--color-red);">*</span>
                        </label>
                        <select id="candidat_id" name="candidat_id"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                                required>
                            <option value="">-- Choisir un candidat --</option>
                            @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}" {{ old('candidat_id', $evaluation->candidat_id) == $candidat->id ? 'selected' : '' }}>
                                    {{ $candidat->nom }} {{ $candidat->prenom }}
                                </option>
                            @endforeach
                        </select>
                        @error('candidat_id')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ✅ Type de Session — corrigé --}}
                    <div class="form-group">
                        <label for="typeSession_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Type de Session <span style="color: var(--color-red);">*</span>
                        </label>
                        <select id="typeSession_id" name="typeSession_id"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                                required>
                            <option value="">-- Choisir un type de session --</option>
                            @foreach($typeSessions as $typeSession)
                                <option value="{{ $typeSession->id }}" {{ old('typeSession_id', $evaluation->typeSession_id) == $typeSession->id ? 'selected' : '' }}>
                                    @switch($typeSession->type)
                                        @case('code')     📋 Code      @break
                                        @case('creneau')  🔧 Créneau   @break
                                        @case('conduite') 🚗 Conduite  @break
                                        @default          {{ $typeSession->type }}
                                    @endswitch
                                    @if($typeSession->description) — {{ $typeSession->description }} @endif
                                </option>
                            @endforeach
                        </select>
                        @error('typeSession_id')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Date Évaluation --}}
                    <div class="form-group">
                        <label for="dateEvaluation" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Date Évaluation <span style="color: var(--color-red);">*</span>
                        </label>
                        <input type="date" id="dateEvaluation" name="dateEvaluation"
                               value="{{ old('dateEvaluation', $evaluation->dateEvaluation) }}"
                               style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark);"
                               onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                               onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                               required>
                        @error('dateEvaluation')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Note --}}
                    <div class="form-group">
                        <label for="note" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Note <span style="color: var(--color-gray-500); font-weight: 400; font-size: 0.75rem; text-transform: none;">(sur 30 — seuil : 25)</span>
                        </label>
                        <input type="number" id="note" name="note"
                               value="{{ old('note', $evaluation->note) }}"
                               min="0" max="30" step="0.5"
                               placeholder="Ex : 27"
                               style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark);"
                               onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                               onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                               oninput="updatePreview(this.value)">
                        <div id="note-preview" style="margin-top: 0.6rem; padding: 0.5rem 0.75rem; border-radius: var(--radius-md); font-size: 0.82rem; font-weight: 700; display: none;"></div>
                        @error('note')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Statut --}}
                    <div class="form-group">
                        <label for="statut" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Statut <span style="color: var(--color-red);">*</span>
                        </label>
                        <select id="statut" name="statut"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                                required>
                            <option value="en_attente" {{ old('statut', $evaluation->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="reussi"     {{ old('statut', $evaluation->statut) == 'reussi'     ? 'selected' : '' }}>Réussi</option>
                            <option value="echoue"     {{ old('statut', $evaluation->statut) == 'echoue'     ? 'selected' : '' }}>Échoué</option>
                        </select>
                        @error('statut')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Moniteur --}}
                    <div class="form-group">
                        <label for="moniteur_id" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Moniteur <span style="color: var(--color-gray-500); font-weight: 400; font-size: 0.75rem;">(Facultatif)</span>
                        </label>
                        <select id="moniteur_id" name="moniteur_id"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark); background-color: white;"
                                onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                                onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">
                            <option value="">-- Choisir un moniteur --</option>
                            @foreach($moniteurs as $moniteur)
                                <option value="{{ $moniteur->id }}" {{ old('moniteur_id', $evaluation->moniteur_id) == $moniteur->id ? 'selected' : '' }}>
                                    {{ $moniteur->nom }} {{ $moniteur->prenom }}
                                </option>
                            @endforeach
                        </select>
                        @error('moniteur_id')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Observation --}}
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="observation" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Observation <span style="color: var(--color-gray-500); font-weight: 400; font-size: 0.75rem;">(Facultatif)</span>
                        </label>
                        <textarea id="observation" name="observation" rows="3"
                                  placeholder="Remarques sur l'évaluation..."
                                  style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark); resize: vertical;"
                                  onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                                  onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">{{ old('observation', $evaluation->observation) }}</textarea>
                    </div>

                </div>
            </div>

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

            <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-gray-100);">
                <button type="submit"
                        style="background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%); color: white; padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-green); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.875rem;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0,122,94,0.3)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✓ Mettre à jour
                </button>
                <a href="{{ route('evaluations.index') }}"
                   style="background: linear-gradient(135deg, var(--color-gray-200) 0%, var(--color-gray-100) 100%); color: var(--color-dark); padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-gray-200); font-weight: 600; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); text-decoration: none; font-size: 0.875rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0,0,0,0.1)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✕ Annuler
                </a>
            </div>
        </form>

        <div style="margin-top: 2rem; padding: 1rem; background: rgba(0,122,94,0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-size: 0.875rem;">
            <strong>ℹ️ Information :</strong> Le résultat est recalculé <strong>automatiquement</strong> à chaque modification de la note. Seuil : <strong>25/30</strong>.
        </div>
    </div>

    <script>
        function updatePreview(val) {
            const preview = document.getElementById('note-preview');
            if (val === '' || val === null || val === undefined) { preview.style.display = 'none'; return; }
            const note = parseFloat(val);
            preview.style.display = 'block';
            if (note >= 25) {
                preview.style.background = 'rgba(0,122,94,0.12)';
                preview.style.color      = '#004D3A';
                preview.style.border     = '1px solid #00A572';
                preview.innerHTML = '🟢 Résultat automatique : <strong>ADMIS</strong> (note ≥ 25)';
            } else {
                preview.style.background = 'rgba(206,17,38,0.08)';
                preview.style.color      = '#A00D20';
                preview.style.border     = '1px solid #E85040';
                preview.innerHTML = '🔴 Résultat automatique : <strong>AJOURNÉ</strong> (note < 25)';
            }
        }
        window.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('note');
            if (f && f.value) updatePreview(f.value);
        });
    </script>
</x-layouts::app.sidebar>