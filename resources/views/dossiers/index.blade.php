<x-layouts::app.sidebar title="Liste des Dossiers">
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
            
            /* Ombres et Bordures */
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --radius-lg: 12px;
            --radius-md: 8px;
            --transition-normal: 300ms ease-in-out;
        }

        /* --- CONFIGURATION POUR L'EXPORTATION PDF --- */
        @media print {
            .no-print, 
            .header-section div:last-child, 
            table th:last-child, 
            table td:last-child {
                display: none !important;
            }
            body { background: white !important; }
            .content-wrapper { padding: 0 !important; }
            .header-section { border: 1px solid #eee !important; box-shadow: none !important; }
            table { border: 1px solid #000 !important; }
            th { background: #f2f2f2 !important; color: black !important; }
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        <!-- En-tête -->
        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <div>
                <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                    <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                    Liste des Dossiers
                </h1>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <!-- Bouton Nouveau -->
                <a href="{{ route('dossiers.create') }}" 
                   style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; border: 2px solid var(--color-red); cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.8rem;"
                   onmouseover="this.style.transform='translateY(-2px)';"
                   onmouseout="this.style.transform='translateY(0)';"
                >
                    + Nouveau Dossier
                </a>

                <!-- BOUTON EXPORTER (PDF) -->
                <button onclick="window.print()"
                   style="background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%); color: var(--color-dark); padding: 0.75rem 1.5rem; border-radius: var(--radius-md); border: 2px solid var(--color-gold); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.8rem;"
                   onmouseover="this.style.transform='translateY(-2px)';"
                   onmouseout="this.style.transform='translateY(0)';"
                >
                    ⬇️ Exporter en PDF
                </button>
            </div>
        </div>

        <!-- Alert Success -->
        @if(session('success'))
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-weight: 600;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Table container -->
        <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(90deg, var(--color-green) 0%, var(--color-green-light) 100%); color: white; font-weight: 600; text-transform: uppercase; font-size: 0.875rem; letter-spacing: 0.5px;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Nom du Dossier</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Candidat associé</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Pièces Jointes</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dossiers as $dossier)
                    <tr style="border-bottom: 1px solid var(--color-gray-100); transition: all var(--transition-normal);"
                        onmouseover="this.style.backgroundColor='rgba(0, 122, 94, 0.04)'"
                        onmouseout="this.style.backgroundColor='transparent'">
                        
                        <!-- Nom Dossier -->
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem; font-weight: 600;">
                            {{ $dossier->nomDossier }}
                        </td>

                        <!-- Candidat avec photo -->
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">
                            <div style="display:flex; align-items:center; gap:0.75rem;">
                                @if($dossier->photo_identite)
                                    <img src="{{ asset('storage/' . $dossier->photo_identite) }}"
                                         alt="Photo"
                                         style="width:42px; height:42px; border-radius:50%; object-fit:cover; border:2px solid var(--color-green); flex-shrink:0;">
                                @else
                                    <div style="width:42px; height:42px; border-radius:50%; background:var(--color-gray-100); border:2px solid var(--color-gray-200); display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1.1rem;">
                                        👤
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight:700; color:var(--color-dark);">
                                        {{ $dossier->candidat->nom ?? 'N/A' }} {{ $dossier->candidat->prenom ?? '' }}
                                    </div>
                                    @if($dossier->candidat)
                                    <div style="font-size:0.72rem; color:var(--color-gray-500); margin-top:0.1rem;">
                                        {{ $dossier->candidat->telephone ?? '' }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Pièces (Badges) -->
                        <td style="padding: 1rem 1.5rem;">
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                @php
                                    $files = [
                                        'cnib' => 'CNIB',
                                        'photo_identite' => 'Photo',
                                        'certificat_medical' => 'Médical',
                                        'acte_naissance' => 'Naissance',
                                        'recu_paiement' => 'Reçu',
                                        'permis_c' => 'Permis C'
                                    ];
                                @endphp
                                @foreach($files as $key => $label)
                                    @if($dossier->$key)
                                        <a href="{{ asset('storage/' . $dossier->$key) }}" target="_blank" 
                                           style="font-size: 0.7rem; background: rgba(0, 122, 94, 0.1); color: var(--color-green-dark); padding: 4px 10px; border-radius: 50px; text-decoration: none; font-weight: 700; border: 1px solid var(--color-green-light); transition: 200ms;"
                                           onmouseover="this.style.background='var(--color-green)'; this.style.color='white';"
                                           onmouseout="this.style.background='rgba(0, 122, 94, 0.1)'; this.style.color='var(--color-green-dark)';"
                                        >
                                            {{ $label }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </td>

                        <!-- Actions -->
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <!-- Éditer -->
                                <a href="{{ route('dossiers.edit', $dossier->id) }}" 
                                   style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: var(--color-green); text-decoration: none; transition: all var(--transition-normal); font-size: 1.2rem;"
                                   onmouseover="this.style.backgroundColor='var(--color-green)'; this.style.color='white';"
                                   onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='var(--color-green)';"
                                   title="Modifier">
                                    ✎
                                </a>

                                <!-- Supprimer -->
                                <form action="{{ route('dossiers.destroy', $dossier->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer ce dossier ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: #D32F2F; border: none; cursor: pointer; transition: all var(--transition-normal); font-size: 1.2rem;"
                                            onmouseover="this.style.backgroundColor='#D32F2F'; this.style.color='white';"
                                            onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='#D32F2F';"
                                            title="Supprimer">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 3rem; text-align: center; color: var(--color-gray-500);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">📁</div>
                            <p style="margin: 0; font-size: 1rem;">Aucun dossier trouvé dans la base de données.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Résumé en bas -->
        @if($dossiers->count() > 0)
        <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-size: 0.875rem;">
            <strong>Statistiques :</strong> {{ $dossiers->count() }} dossier(s) archivé(s).
        </div>
        @endif
    </div>
</x-layouts::app.sidebar>