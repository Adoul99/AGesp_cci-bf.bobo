<x-layouts::app.sidebar title="Modifier Groupe">
    <link rel="stylesheet" href="{{ asset('assets/choices.min.css') }}">
    <style>
        :root {
            --color-red: #CE1126;
            --color-green: #007A5E;
            --color-gold: #FCD116;
            --color-red-light: #E85040;
            --color-red-dark: #A00D20;
            --color-green-light: #00A572;
            --color-green-dark: #004D3A;
            --color-gold-light: #FFE657;
            --color-gold-dark: #E5B800;
            --color-dark: #1A1A1A;
            --color-light: #F8F8F8;
            --color-gray-100: #E8E8E8;
            --color-gray-200: #D1D1D1;
            --color-gray-500: #666666;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
            --transition-normal: 300ms ease-in-out;
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        /* ── Champ de sélection multiple (Choices.js) — thème AGesp ── */
        .choices { margin-bottom: 0; }
        .choices__inner {
            border: 2px solid var(--color-gray-200) !important;
            border-radius: var(--radius-md) !important;
            background-color: var(--color-light) !important;
            min-height: 48px;
            padding: 0.55rem 0.75rem !important;
            font-size: 0.875rem;
        }
        .choices.is-open .choices__inner,
        .choices.is-focused .choices__inner {
            border-color: var(--color-green) !important;
            box-shadow: 0 0 0 3px rgba(0, 122, 94, 0.1) !important;
        }
        .choices__list--dropdown,
        .choices__list[aria-expanded] {
            border-color: var(--color-gray-200) !important;
            border-radius: var(--radius-md) !important;
        }
        .choices__list--dropdown { max-height: 280px; }

        /* Cases à cocher dans la liste déroulante */
        .choices_list--dropdown .choices_item {
            display: flex !important;
            align-items: center !important;
            gap: 0.6rem !important;
            padding: 0.6rem 1rem !important;
        }
        .choices_list--dropdown .choices_item::before {
            content: '';
            display: inline-block;
            width: 16px;
            height: 16px;
            min-width: 16px;
            border: 2px solid var(--color-gray-200);
            border-radius: 4px;
            background: white;
            transition: all 0.2s;
        }
        .choices__list--dropdown .choices__item.is-selected::before {
            background-color: var(--color-green);
            border-color: var(--color-green);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 10'%3E%3Cpath fill='white' d='M1 5l3 3 7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 10px;
        }
        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background-color: rgba(0, 122, 94, 0.08) !important;
        }
        .choices__list--dropdown .choices__item--selectable.is-highlighted::before {
            border-color: var(--color-green);
        }
        .choices__list--dropdown .choices__item--choice.is-disabled {
            opacity: 0.55;
            color: var(--color-red) !important;
        }
        .choices__list--dropdown .choices__item--choice.is-disabled::before {
            border-color: var(--color-gray-200);
            background-color: var(--color-gray-100);
        }

        /* Badges des candidats sélectionnés */
        .choices_list--multiple .choices_item {
            background-color: var(--color-green) !important;
            border-color: var(--color-green-dark) !important;
            border-radius: 20px !important;
            font-size: 0.8125rem;
            font-weight: 600;
            padding: 0.3rem 0.7rem;
        }
        .choices__list--multiple .choices__item.is-disabled {
            background-color: var(--color-gray-500) !important;
            border-color: var(--color-gray-500) !important;
        }
        .choices[data-type*="select-multiple"] .choices__button {
            border-left: 1px solid rgba(255, 255, 255, 0.4) !important;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">

        <!-- En-tête -->
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
                            <label for="candidatsSelect" style="display: block; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                                Candidats <span style="color: var(--color-gray-500); font-size: 0.75rem; font-weight: normal;">(cochez pour sélectionner)</span>
                                — <strong id="compteurCandidats" style="color: var(--color-green-dark);">0</strong>
                                <span style="color: var(--color-gray-500); font-size: 0.75rem; font-weight: normal;">sélectionné(s)</span>
                            </label>

                            <label for="filtreSansGroupe" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.8125rem; font-weight: 600; color: var(--color-green-dark); background-color: rgba(0, 122, 94, 0.08); padding: 0.5rem 0.875rem; border-radius: var(--radius-md); border: 1px solid rgba(0, 122, 94, 0.25);">
                                <input type="checkbox" id="filtreSansGroupe" style="width: 1.1rem; height: 1.1rem; accent-color: var(--color-green); cursor: pointer;">
                                🔍 Afficher uniquement les candidats sans groupe
                            </label>
                        </div>

                        <select id="candidatsSelect" name="candidat_ids[]" multiple>
                            @foreach($candidats as $candidat)
                                @php
                                    $groupeExistant = $candidat->groupes->first();
                                    $dejaDansAutreGroupe = $groupeExistant && $groupeExistant->id != $groupe->id;
                                @endphp
                                @if($dejaDansAutreGroupe)
                                    <option value="{{ $candidat->id }}" disabled>
                                        {{ $candidat->nom }} {{ $candidat->prenom }} 🔒 (déjà dans : {{ $groupeExistant->nomGroupe }})
                                    </option>
                                @else
                                    <option value="{{ $candidat->id }}" {{ in_array($candidat->id, $candidatsSelectionnes) ? 'selected' : '' }}>
                                        {{ $candidat->nom }} {{ $candidat->prenom }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <!-- Boutons d'action -->
            <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-gray-100);">
                <button type="submit"
                        style="background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%); color: white; padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-green); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.875rem;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0, 122, 94, 0.3)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✓ Mettre à jour
                </button>

                <a href="{{ route('groupes.index') }}"
                   style="background: linear-gradient(135deg, var(--color-gray-200) 0%, var(--color-gray-100) 100%); color: var(--color-dark); padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-gray-200); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); text-decoration: none; font-size: 0.875rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0, 0, 0, 0.1)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✕ Annuler
                </a>
            </div>
        </form>
    </div>

    <script src="{{ asset('assets/choices.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectEl = document.getElementById('candidatsSelect');
            if (!selectEl) return;

            const candidatsData = Array.from(selectEl.options).map(function (opt) {
                return {
                    value: opt.value,
                    label: opt.textContent.trim(),
                    disabled: opt.disabled,
                    selected: opt.selected,
                };
            });

            const choicesInstance = new Choices(selectEl, {
                removeItemButton: true,
                searchEnabled: true,
                searchResultLimit: 200,
                searchPlaceholderValue: 'Rechercher un candidat par nom…',
                noResultsText: 'Aucun candidat trouvé',
                noChoicesText: 'Aucun candidat disponible',
                placeholderValue: 'Cliquez ou tapez pour sélectionner des candidats…',
                itemSelectText: '',
                shouldSort: false,
                closeDropdownOnSelect: false, // Garde la liste ouverte après chaque sélection
            });

            function majCompteur() {
                const compteur = document.getElementById('compteurCandidats');
                if (compteur) compteur.textContent = choicesInstance.getValue(true).length;
            }
            majCompteur();

            selectEl.addEventListener('addItem', majCompteur);
            selectEl.addEventListener('removeItem', majCompteur);

            const filtre = document.getElementById('filtreSansGroupe');
            if (filtre) {
                filtre.addEventListener('change', function (e) {
                    const idsActuels = new Set(choicesInstance.getValue(true));
                    const filtrerSansGroupe = e.target.checked;

                    const nouveauxChoix = candidatsData
                        .filter(function (c) { return !(filtrerSansGroupe && c.disabled); })
                        .map(function (c) {
                            return {
                                value: c.value,
                                label: c.label,
                                disabled: c.disabled,
                                selected: c.selected || idsActuels.has(c.value),
                            };
                        });

                    choicesInstance.clearStore();
                    choicesInstance.setChoices(nouveauxChoix, 'value', 'label', true);
                    majCompteur();
                });
            }
        });
    </script>

</x-layouts::app.sidebar>