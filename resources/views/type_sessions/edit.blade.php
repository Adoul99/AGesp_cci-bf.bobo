<x-layouts::app.sidebar title="Modifier Type de Session">
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

        {{-- En-tête --}}
        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Modifier Type de Session
            </h1>
        </div>

        <form method="POST" action="{{ route('type_sessions.update', $typeSession->id) }}" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Modifier le Type de Session
                </h2>

                {{-- Sélection visuelle --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">

                    <label for="type_code" style="cursor: pointer;">
                        <input type="radio" id="type_code" name="type" value="code"
                               {{ old('type', $typeSession->type) == 'code' ? 'checked' : '' }}
                               style="display: none;" onchange="updateCard()">
                        <div id="card_code"
                             style="border: 2px solid var(--color-gray-200); border-radius: var(--radius-lg); padding: 1.5rem; text-align: center; transition: all var(--transition-normal); cursor: pointer;">
                            <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">📋</div>
                            <div style="font-size: 1rem; font-weight: 700; color: var(--color-dark); text-transform: uppercase; letter-spacing: 0.5px;">Code</div>
                            <div style="font-size: 0.8rem; color: var(--color-gray-500); margin-top: 0.5rem;">Examen théorique du code de la route</div>
                        </div>
                    </label>

                    <label for="type_creneau" style="cursor: pointer;">
                        <input type="radio" id="type_creneau" name="type" value="creneau"
                               {{ old('type', $typeSession->type) == 'creneau' ? 'checked' : '' }}
                               style="display: none;" onchange="updateCard()">
                        <div id="card_creneau"
                             style="border: 2px solid var(--color-gray-200); border-radius: var(--radius-lg); padding: 1.5rem; text-align: center; transition: all var(--transition-normal); cursor: pointer;">
                            <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🔧</div>
                            <div style="font-size: 1rem; font-weight: 700; color: var(--color-dark); text-transform: uppercase; letter-spacing: 0.5px;">Créneau</div>
                            <div style="font-size: 0.8rem; color: var(--color-gray-500); margin-top: 0.5rem;">Exercice de manœuvre en espace délimité</div>
                        </div>
                    </label>

                    <label for="type_conduite" style="cursor: pointer;">
                        <input type="radio" id="type_conduite" name="type" value="conduite"
                               {{ old('type', $typeSession->type) == 'conduite' ? 'checked' : '' }}
                               style="display: none;" onchange="updateCard()">
                        <div id="card_conduite"
                             style="border: 2px solid var(--color-gray-200); border-radius: var(--radius-lg); padding: 1.5rem; text-align: center; transition: all var(--transition-normal); cursor: pointer;">
                            <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🚗</div>
                            <div style="font-size: 1rem; font-weight: 700; color: var(--color-dark); text-transform: uppercase; letter-spacing: 0.5px;">Conduite</div>
                            <div style="font-size: 0.8rem; color: var(--color-gray-500); margin-top: 0.5rem;">Conduite en circulation réelle</div>
                        </div>
                    </label>

                </div>

                @error('type')
                    <div style="padding: 0.75rem 1rem; background: rgba(206,17,38,0.1); border-left: 4px solid var(--color-red); border-radius: var(--radius-md); color: var(--color-red-dark); font-size: 0.875rem; margin-bottom: 1.5rem;">
                        ⚠️ {{ $message }}
                    </div>
                @enderror

                {{-- Description --}}
                <div class="form-group">
                    <label for="description" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        Description <span style="color: var(--color-gray-500); font-weight: 400; font-size: 0.75rem;">(Facultatif)</span>
                    </label>
                    <textarea id="description" name="description" rows="3"
                              placeholder="Description complémentaire..."
                              style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark); resize: vertical;"
                              onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0,122,94,0.1)'"
                              onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">{{ old('description', $typeSession->description) }}</textarea>
                </div>
            </div>

            @if ($errors->any())
                <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(206,17,38,0.1); border-left: 4px solid var(--color-red); border-radius: var(--radius-md); color: var(--color-red-dark);">
                    <strong>⚠️ Erreurs :</strong>
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
                <a href="{{ route('type_sessions.index') }}"
                   style="background: linear-gradient(135deg, var(--color-gray-200) 0%, var(--color-gray-100) 100%); color: var(--color-dark); padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-gray-200); font-weight: 600; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); text-decoration: none; font-size: 0.875rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0,0,0,0.1)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✕ Annuler
                </a>
            </div>
        </form>

        <div style="margin-top: 2rem; padding: 1rem; background: rgba(0,122,94,0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-size: 0.875rem;">
            <strong>ℹ️ Information :</strong> La modification du type affectera toutes les sessions de formation associées.
        </div>
    </div>

    <script>
        const colors = {
            code:     { border: '#007A5E', shadow: 'rgba(0,122,94,0.15)',   bg: 'rgba(0,122,94,0.05)'   },
            creneau:  { border: '#E5B800', shadow: 'rgba(252,209,22,0.2)',  bg: 'rgba(252,209,22,0.05)' },
            conduite: { border: '#CE1126', shadow: 'rgba(206,17,38,0.15)',  bg: 'rgba(206,17,38,0.05)'  },
        };

        function updateCard() {
            ['code', 'creneau', 'conduite'].forEach(type => {
                const radio = document.getElementById('type_' + type);
                const card  = document.getElementById('card_' + type);
                if (radio && radio.checked) {
                    card.style.border     = '2px solid ' + colors[type].border;
                    card.style.boxShadow  = '0 0 0 3px ' + colors[type].shadow;
                    card.style.background = colors[type].bg;
                } else {
                    card.style.border     = '2px solid #D1D1D1';
                    card.style.boxShadow  = 'none';
                    card.style.background = 'white';
                }
            });
        }

        window.addEventListener('DOMContentLoaded', updateCard);

        ['code', 'creneau', 'conduite'].forEach(type => {
            document.getElementById('card_' + type)?.addEventListener('click', () => {
                document.getElementById('type_' + type).checked = true;
                updateCard();
            });
        });
    </script>
</x-layouts::app.sidebar>