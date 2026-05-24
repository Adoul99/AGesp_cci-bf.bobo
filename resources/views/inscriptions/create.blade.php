<x-layouts::app.sidebar title="Nouvelle Inscription">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-dark: #A00D20; --color-gray-100: #E8E8E8;
            --color-gray-200: #D1D1D1; --color-dark: #1A1A1A; --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --radius-md: 8px; --radius-lg: 12px;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        @if ($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 1.5rem; border-radius: var(--radius-lg); margin-bottom: 2rem; border: 1px solid #f5c6cb;">
                <strong>Oups ! Veuillez corriger les erreurs suivantes :</strong>
                <ul style="margin-top: 0.5rem;">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Nouvelle Inscription
            </h1>
        </div>

        <form method="POST" action="{{ route('inscriptions.store') }}" enctype="multipart/form-data" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
            @csrf
            
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Informations Générales
                </h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; text-transform: uppercase;">Candidat *</label>
                        <select name="candidat_id" style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md);" required>
                            @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; text-transform: uppercase;">Date Inscription *</label>
                        <input type="date" name="dateInscription" style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md);" required>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; text-transform: uppercase;">Date Début Formation</label>
                        <input type="date" name="dataDebut_formation" style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md);">
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-red); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Pièces Jointes
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    @foreach(['cnib' => 'CNIB', 'photo_identite' => 'Photo Identité', 'certificat_medical' => 'Certificat Médical', 'acte_naissance' => 'Acte Naissance', 'recu_paiement' => 'Reçu Paiement', 'permis_c' => 'Copie Permis C'] as $field => $label)
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">{{ $label }}</label>
                            <input type="file" name="{{ $field }}" style="width: 100%; padding: 0.5rem; border: 1px dashed var(--color-gray-200); border-radius: var(--radius-md);">
                        </div>
                    @endforeach
                </div>
            </div>

            <div style="display: flex; gap: 1rem; border-top: 1px solid var(--color-gray-100); padding-top: 2rem;">
                <button type="submit" style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.875rem 2rem; border-radius: var(--radius-md); border: none; font-weight: 600; cursor: pointer;">
                    ✓ Enregistrer l'inscription
                </button>
                <a href="{{ route('inscriptions.index') }}" style="background: var(--color-gray-100); color: var(--color-dark); padding: 0.875rem 2rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600;">
                    ✕ Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>