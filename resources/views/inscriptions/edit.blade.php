<x-layouts::app title="Modifier Inscription">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-dark: #A00D20; --color-green-dark: #004D3A; --color-gray-100: #E8E8E8;
            --color-gray-200: #D1D1D1; --color-dark: #1A1A1A; --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --radius-md: 8px; --radius-lg: 12px;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">

        {{-- En-tête --}}
        <div style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-green);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Modifier Inscription : {{ $inscription->reference ?? 'GESP-'.$inscription->id }}
            </h1>
        </div>

        {{-- Erreurs --}}
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

        <form method="POST" action="{{ route('inscriptions.update', $inscription->id) }}"
              style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
            @csrf
            @method('PUT')

            {{-- ── Section : Informations générales ── --}}
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Informations de l'Inscription
                </h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">

                    {{-- Candidat --}}
                    <div>
                        <label for="candidat_id" style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.875rem; text-transform:uppercase; color:var(--color-dark);">
                            Candidat *
                        </label>
                        <select name="candidat_id" id="candidat_id" required
                                style="width:100%; padding:0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.9rem; background:white;">
                            @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}" {{ $inscription->candidat_id == $candidat->id ? 'selected' : '' }}>
                                    {{ $candidat->nom }} {{ $candidat->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date Inscription --}}
                    <div>
                        <label for="dateInscription" style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.875rem; text-transform:uppercase; color:var(--color-dark);">
                            Date d'Inscription *
                        </label>
                        <input type="date" name="dateInscription" id="dateInscription"
                               value="{{ old('dateInscription', $inscription->dateInscription) }}" required
                               style="width:100%; padding:0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.9rem;">
                    </div>

                    {{-- Catégorie de permis --}}
                    <div>
                        <label for="categoriePermis_id" style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.875rem; text-transform:uppercase; color:var(--color-dark);">
                            Catégorie de Permis
                        </label>
                        <select name="categoriePermis_id" id="categoriePermis_id"
                                style="width:100%; padding:0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.9rem; background:white;">
                            <option value="">-- Non précisée --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $inscription->categoriePermis_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nomCategorie ?? 'Catégorie '.$cat->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date Début Formation --}}
                    <div>
                        <label for="dataDebut_formation" style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.875rem; text-transform:uppercase; color:var(--color-dark);">
                            Date Début Formation
                        </label>
                        <input type="date" name="dataDebut_formation" id="dataDebut_formation"
                               value="{{ old('dataDebut_formation', $inscription->dataDebut_formation) }}"
                               style="width:100%; padding:0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.9rem;">
                    </div>

                </div>
            </div>

            {{-- ── Section : Statut ── --}}
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-gold); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Statut de l'Inscription
                </h2>

                <div style="background: rgba(252,209,22,0.06); border: 1px solid rgba(252,209,22,0.4); border-radius: var(--radius-md); padding: 1.25rem 1.5rem;">
                    <p style="font-size:0.8rem; color:var(--color-dark); margin:0 0 1rem 0;">
                        💬 Le statut ci-dessous est visible par le candidat dans son espace personnel.
                    </p>
                    <div style="max-width: 400px;">
                        <label for="statutInscription" style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.875rem; text-transform:uppercase; color:var(--color-dark);">
                            Statut
                        </label>
                        <select name="statutInscription" id="statutInscription"
                                style="width:100%; padding:0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.9rem; font-weight:600; background:white;">
                            <option value="en_attente" {{ old('statutInscription', $inscription->statutInscription) == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                            <option value="actif"      {{ old('statutInscription', $inscription->statutInscription) == 'actif'      ? 'selected' : '' }}>✅ Actif</option>
                            <option value="abandon"    {{ old('statutInscription', $inscription->statutInscription) == 'abandon'    ? 'selected' : '' }}>🚫 Abandon</option>
                            <option value="ajourne"    {{ old('statutInscription', $inscription->statutInscription) == 'ajourne'    ? 'selected' : '' }}>🔄 Ajourné</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ── Boutons ── --}}
            <div style="display:flex; gap:1rem; border-top:1px solid var(--color-gray-100); padding-top:2rem;">
                <button type="submit"
                        style="background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:none; font-weight:600; font-size:1rem; cursor:pointer;">
                    ✓ Mettre à jour
                </button>
                <a href="{{ route('inscriptions.index') }}"
                   style="background:var(--color-gray-100); color:var(--color-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); text-decoration:none; font-weight:600;">
                    ✕ Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app>