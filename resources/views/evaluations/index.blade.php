<x-layouts::app.sidebar title="Liste des Évaluations">
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

        /* --- STYLE POUR L'EXPORTATION (IMPRESSION) --- */
        @media print {
            /* Cacher la barre latérale, les boutons et la colonne actions */
            .no-print, 
            .header-section div:last-child, 
            table th:last-child, 
            table td:last-child {
                display: none !important;
            }
            
            /* Ajuster le contenu pour la page */
            body { background: white !important; }
            .content-wrapper { padding: 0 !important; }
            .header-section { 
                box-shadow: none !important; 
                border: 1px solid #eee !important;
                margin-bottom: 1rem !important;
            }
            .slide-container { box-shadow: none !important; }
            table { border: 1px solid #000 !important; }
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        
        <!-- En-tête de la section -->
        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <div>
                <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                    <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                    Liste des Évaluations
                </h1>
            </div>
            
            <!-- Boutons d'action -->
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('evaluations.create') }}" 
                   style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; border: 2px solid var(--color-red); cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm);"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(206, 17, 38, 0.3)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    + Nouvelle Évaluation
                </a>
                
                <!-- BOUTON EXPORTER (Fonctionnel avec window.print) -->
                <button onclick="window.print()"
                   style="background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%); color: var(--color-dark); padding: 0.75rem 1.5rem; border-radius: var(--radius-md); border: 2px solid var(--color-gold); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm);"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(252, 209, 22, 0.3)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ⬇️ Exporter en PDF
                </button>
            </div>
        </div>

        <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(90deg, var(--color-green) 0%, var(--color-green-light) 100%); color: white; font-weight: 600; text-transform: uppercase; font-size: 0.875rem; letter-spacing: 0.5px;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Candidat</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Date Évaluation</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Résultat</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Statut</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluations as $evaluation)
                    <tr style="border-bottom: 1px solid var(--color-gray-100); transition: all var(--transition-normal);"
                        onmouseover="this.style.backgroundColor='rgba(0, 122, 94, 0.04)'"
                        onmouseout="this.style.backgroundColor='transparent'">
                        
                        <!-- Nom du Candidat -->
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem; font-weight: 600;">
                            {{ $evaluation->candidat->nom ?? 'N/A' }} {{ $evaluation->candidat->prenom ?? '' }}
                        </td>
                        
                        <!-- Date -->
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">
                            <span style="background: rgba(0, 122, 94, 0.15); color: var(--color-green); padding: 0.25rem 0.75rem; border-radius: var(--radius-md); font-size: 0.8rem; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($evaluation->dateEvaluation)->format('d/m/Y') }}
                            </span>
                        </td>
                        
                        <!-- Badge Résultat -->
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            @if($evaluation->resultat == 'Admis')
                                <span style="background: rgba(0, 122, 94, 0.15); color: var(--color-green); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border: 1px solid var(--color-green-light);">
                                    🟢 {{ $evaluation->resultat }}
                                </span>
                            @elseif($evaluation->resultat == 'Ajourné')
                                <span style="background: rgba(206, 17, 38, 0.1); color: var(--color-red-dark); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border: 1px solid var(--color-red-light);">
                                    🔴 {{ $evaluation->resultat }}
                                </span>
                            @elseif($evaluation->resultat == 'Absent')
                                <span style="background: var(--color-gray-100); color: var(--color-gray-500); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border: 1px solid var(--color-gray-200);">
                                    ⚪ {{ $evaluation->resultat }}
                                </span>
                            @else
                                <span style="background: rgba(206, 17, 38, 0.2); color: var(--color-red-dark); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border: 2px solid var(--color-red);">
                                    ⚠️ {{ $evaluation->resultat }}
                                </span>
                            @endif
                        </td>
                        
                        <!-- Statut -->
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            @if($evaluation->statut == 'en_attente')
                                <span style="background: rgba(252, 209, 22, 0.2); color: var(--color-gold-dark); padding: 0.25rem 0.75rem; border-radius: var(--radius-md); font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">
                                    En attente
                                </span>
                            @else
                                <span style="background: rgba(0, 122, 94, 0.1); color: var(--color-green); padding: 0.25rem 0.75rem; border-radius: var(--radius-md); font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">
                                    {{ str_replace('_', ' ', $evaluation->statut) }}
                                </span>
                            @endif
                        </td>
                        
                        <!-- Actions -->
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="{{ route('evaluations.edit', $evaluation->id) }}" 
                                   style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: var(--color-green); text-decoration: none; transition: all var(--transition-normal); font-size: 1.2rem;"
                                   onmouseover="this.style.backgroundColor='var(--color-green)'; this.style.color='white';"
                                   onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='var(--color-green)';"
                                   title="Éditer">
                                    ✎
                                </a>
                                
                                <form method="POST" action="{{ route('evaluations.destroy', $evaluation->id) }}" style="display: inline;" onsubmit="return confirm('Supprimer cette évaluation ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: #D32F2F; border: none; cursor: pointer; transition: all var(--transition-normal); font-size: 1.2rem;"
                                            onmouseover="this.style.backgroundColor='#D32F2F'; this.style.color='white';"
                                            onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='#D32F2F';">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 3rem; text-align: center; color: var(--color-gray-500);">
                            📭 Aucune évaluation trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Résumé statistique -->
        @if($evaluations->count() > 0)
        <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark);">
            <strong>Total :</strong> {{ $evaluations->count() }} évaluation(s) enregistrée(s)
        </div>
        @endif
    </div>
</x-layouts::app.sidebar>