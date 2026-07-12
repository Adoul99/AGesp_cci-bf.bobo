<x-layouts::app title="Liste des Attestations">
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
            
            /* Transitions */
            --transition-normal: 300ms ease-in-out;
            
            /* Bordures */
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        /* --- CONFIGURATION POUR L'EXPORTATION PDF (IMPRESSION) --- */
        @media print {
            /* Masquer les boutons, les menus de navigation et la colonne actions à l'export */
            .no-print,
            .header-section div:last-child,
            table th:last-child,
            table td:last-child,
            nav, .sidebar {
                display: none !important;
            }
            
            /* Forcer la mise en page propre pour le PDF */
            body { 
                background: white !important; 
                color: black !important; 
            }
            .content-wrapper { 
                padding: 0 !important; 
                margin: 0 !important; 
            }
            .header-section {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                margin-bottom: 2rem !important;
                border-left: 4px solid var(--color-red) !important;
            }
            table { 
                border-collapse: collapse !important; 
                border: 1px solid #000 !important; 
            }
            th { 
                background: #f2f2f2 !important; 
                color: black !important; 
                border: 1px solid #000 !important; 
            }
            td { 
                border: 1px solid #ccc !important; 
            }
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        @if(session('success'))
        <div style="margin-bottom: 1.5rem; padding: 1rem 1.5rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-weight: 600;">
            {{ session('success') }}
        </div>
        @endif
        <!-- En-tête avec titre et bouton -->
        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <div>
                <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                    <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                    Liste des Attestations
                </h1>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('attestations.create') }}" 
                   style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; border: 2px solid var(--color-red); cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.8rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(206, 17, 38, 0.3)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    + Nouvelle Attestation
                </a>
                
                <!-- BOUTON EXPORTER (Fonctionnel avec window.print()) -->
                <button onclick="window.print()"
                    style="background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%); color: var(--color-dark); padding: 0.75rem 1.5rem; border-radius: var(--radius-md); border: 2px solid var(--color-gold); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.8rem;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(252, 209, 22, 0.3)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ⬇️ Exporter en PDF
                </button>
            </div>
        </div>

        <!-- Table container -->
        <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(90deg, var(--color-green) 0%, var(--color-green-light) 100%); color: white; font-weight: 600; text-transform: uppercase; font-size: 0.875rem; letter-spacing: 0.5px;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Numéro</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Candidat</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Date Délivrance</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Examen</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attestations as $attestation)
                    <tr style="border-bottom: 1px solid var(--color-gray-100); transition: all var(--transition-normal);"
                        onmouseover="this.style.backgroundColor='rgba(0, 122, 94, 0.04)'"
                        onmouseout="this.style.backgroundColor='transparent'">
                        
                        <!-- Numéro d'attestation -->
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem; font-weight: 600;">{{ $attestation->numeroAttestation }}</td>
                        
                        <!-- Nom et Prénom du Candidat -->
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">{{ $attestation->candidat->nom }} {{ $attestation->candidat->prenom }}</td>
                        
                        <!-- Date délivrance -->
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">
                            <span style="background: rgba(0, 122, 94, 0.15); color: var(--color-green); padding: 0.25rem 0.75rem; border-radius: var(--radius-md); font-size: 0.8rem; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($attestation->dateDelivrance)->format('d/m/Y') }}
                            </span>
                        </td>
                        
                        <!-- Examen concerné -->
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">
                            @if($attestation->examen)
                                <span style="background: rgba(252, 209, 22, 0.2); color: var(--color-gold-dark); padding: 0.25rem 0.75rem; border-radius: var(--radius-md); font-size: 0.8rem; font-weight: 500;">
                                    {{ $attestation->examen->libelle }}
                                </span>
                            @else
                                <span style="color: var(--color-gray-500); font-style: italic;">N/A</span>
                            @endif
                        </td>
                        
                        <!-- Colonne d'actions (sera masquée à l'export PDF) -->
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <!-- Bouton Voir / Imprimer -->
                                <a href="{{ route('attestations.show', $attestation->id) }}"
                                   style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: rgba(252,209,22,0.15); color: var(--color-gold-dark); border: none; cursor: pointer; transition: all var(--transition-normal); font-weight: bold; text-decoration: none; font-size: 1.1rem;"
                                   onmouseover="this.style.backgroundColor='var(--color-gold)'; this.style.color='var(--color-dark)'; this.style.transform='scale(1.1)'"
                                   onmouseout="this.style.backgroundColor='rgba(252,209,22,0.15)'; this.style.color='var(--color-gold-dark)'; this.style.transform='scale(1)'"
                                   title="Voir / Imprimer">
                                    👁️
                                </a>

                                <!-- Bouton Éditer -->
                                <a href="{{ route('attestations.edit', $attestation->id) }}" 
                                   style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: var(--color-green); border: none; cursor: pointer; transition: all var(--transition-normal); font-weight: bold; text-decoration: none; font-size: 1.2rem;"
                                   onmouseover="this.style.backgroundColor='var(--color-green)'; this.style.color='white'; this.style.transform='scale(1.1)'"
                                   onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='var(--color-green)'; this.style.transform='scale(1)'"
                                   title="Éditer">
                                    ✎
                                </a>
                                
                                <!-- Bouton Supprimer -->
                                <form method="POST" action="{{ route('attestations.destroy', $attestation->id) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette attestation ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: #D32F2F; border: none; cursor: pointer; transition: all var(--transition-normal); font-weight: bold; font-size: 1.2rem; padding: 0;"
                                            onmouseover="this.style.backgroundColor='#D32F2F'; this.style.color='white'; this.style.transform='scale(1.1)'"
                                            onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='#D32F2F'; this.style.transform='scale(1)'"
                                            title="Supprimer">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 3rem; text-align: center; color: var(--color-gray-500);">
                            <p style="margin: 0; font-size: 1rem;">📭 Aucune attestation trouvée</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Message de résumé -->
        @if($attestations->count() > 0)
        <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark);">
            <strong>Total :</strong> {{ $attestations->count() }} attestation(s) délivrée(s)
        </div>
        @endif
    </div>
</x-layouts::app>