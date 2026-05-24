<x-layouts::app.sidebar title="Modifier le Dossier">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-dark: #A00D20; --color-green-dark: #004D3A; --color-gray-100: #E8E8E8;
            --color-gray-200: #D1D1D1; --color-dark: #1A1A1A; --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --radius-md: 8px; --radius-lg: 12px; --transition-normal: 300ms ease-in-out;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Modifier Dossier : {{ $dossier->nomDossier }}
            </h1>
        </div>

        <form method="POST" action="{{ route('dossiers.update', $dossier->id) }}" enctype="multipart/form-data" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
            @csrf
            @method('PUT')
            
            <!-- Informations Générales -->
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Informations du Dossier
                </h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    <div class="form-group">
                        <label for="candidat_id" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; text-transform: uppercase;">Candidat *</label>
                        <select name="candidat_id" id="candidat_id" style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md);" required>
                            @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}" {{ $dossier->candidat_id == $candidat->id ? 'selected' : '' }}>
                                    {{ $candidat->nom }} {{ $candidat->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nomDossier" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; text-transform: uppercase;">Nom du Dossier *</label>
                        <input type="text" name="nomDossier" id="nomDossier" value="{{ old('nomDossier', $dossier->nomDossier) }}" style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md);" required>
                    </div>
                </div>
            </div>

            <!-- Fichiers -->
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                    <span style="width: 4px; height: 20px; background: var(--color-red); margin-right: 0.75rem; border-radius: 2px;"></span>
                    Gestion des Pièces Jointes
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    @foreach(['cnib' => 'CNIB', 'photo_identite' => 'Photo Identité', 'certificat_medical' => 'Certificat Médical', 'acte_naissance' => 'Acte de Naissance', 'recu_paiement' => 'Reçu de Paiement', 'permis_c' => 'Copie Permis C'] as $field => $label)
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">{{ $label }}</label>
                            @if($dossier->$field)
                                <div style="margin-bottom: 0.5rem; font-size: 0.75rem; color: var(--color-green);">
                                    Actuel: <a href="{{ asset('storage/' . $dossier->$field) }}" target="_blank">Voir fichier</a>
                                </div>
                            @endif
                            <input type="file" name="{{ $field }}" id="{{ $field }}" style="width: 100%; padding: 0.5rem; border: 1px dashed var(--color-gray-200); border-radius: var(--radius-md);">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Boutons -->
            <div style="display: flex; gap: 1rem; border-top: 1px solid var(--color-gray-100); padding-top: 2rem;">
                <button type="submit" style="background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%); color: white; padding: 0.875rem 2rem; border-radius: var(--radius-md); border: none; font-weight: 600; cursor: pointer;">
                    ✓ Mettre à jour
                </button>
                <a href="{{ route('dossiers.index') }}" style="background: var(--color-gray-100); color: var(--color-dark); padding: 0.875rem 2rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600;">
                    ✕ Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>