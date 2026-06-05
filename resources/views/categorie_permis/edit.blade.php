<x-layouts::app.sidebar title="Modifier Catégorie de Permis">
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
    </style>

    <div class="content-wrapper" style="padding: 2rem;">

        <!-- En-tête -->
        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Modifier Catégorie de Permis
            </h1>
        </div>

        <!-- Formulaire -->
        {{-- ✅ CORRECTION 1 : bon paramètre de route + balise fermante style= ajoutée --}}
        <form method="POST" action="{{ route('categorie_permis.update', ['categoriePermis' => $categoriePermis->id]) }}" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            @csrf
            @method('PUT')

            <!-- Section : Informations de la catégorie -->
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Informations de la Catégorie
                </h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">

                    <!-- Nom Catégorie -->
                    <div class="form-group">
                        <label for="nomCategorie" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Nom de la Catégorie <span style="color: var(--color-red);">*</span>
                        </label>
                        {{-- ✅ CORRECTION 2 : $categorie -> $categoriePermis --}}
                        <input type="text"
                               id="nomCategorie"
                               name="nomCategorie"
                               value="{{ old('nomCategorie', $categoriePermis->nomCategorie) }}"
                               style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark);"
                               onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                               onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                               placeholder="Ex: Catégorie B, Catégorie C..."
                               required>
                        @error('nomCategorie')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Description <span style="color: var(--color-gray-500); font-weight: 400; font-size: 0.75rem;">(Facultatif)</span>
                        </label>
                        {{-- ✅ CORRECTION 3 : $categorie -> $categoriePermis --}}
                        <input type="text"
                               id="description"
                               name="description"
                               value="{{ old('description', $categoriePermis->description) }}"
                               style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-family: inherit; transition: all var(--transition-normal); color: var(--color-dark);"
                               onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                               onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'"
                               placeholder="Ex: Véhicules légers, Poids lourds...">
                        @error('description')
                            <span style="color: var(--color-red); font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Erreurs générales -->
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

            <!-- Boutons d'action -->
            <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-gray-100);">
                <button type="submit"
                        style="background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%); color: white; padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-green); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.875rem;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0, 122, 94, 0.3)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✓ Mettre à jour
                </button>

                <a href="{{ route('categorie_permis.index') }}"
                   style="background: linear-gradient(135deg, var(--color-gray-200) 0%, var(--color-gray-100) 100%); color: var(--color-dark); padding: 0.875rem 2rem; border-radius: var(--radius-md); border: 2px solid var(--color-gray-200); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); text-decoration: none; font-size: 0.875rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0, 0, 0, 0.1)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ✕ Annuler
                </a>
            </div>
        </form>

        <!-- Info contextuelle -->
        <div style="margin-top: 2rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-size: 0.875rem;">
            <strong>ℹ️ Information :</strong> Les champs marqués avec un <span style="color: var(--color-red); font-weight: bold;">*</span> sont obligatoires.
        </div>
    </div>
</x-layouts::app.sidebar>