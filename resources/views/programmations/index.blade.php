<x-layouts::app.sidebar title="Liste des Programmations">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-dark: #1A1A1A; --color-gray-100: #E8E8E8;
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1); --radius-lg: 12px;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red), var(--color-green), var(--color-gold)); margin-right: 1rem; border-radius: 2px;"></span>
                Programmations
            </h1>
            <a href="{{ route('programmations.create') }}" style="background: var(--color-red); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.8rem;">+ Nouvelle Programmation</a>
        </div>

        <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: var(--color-green); color: white; text-transform: uppercase; font-size: 0.8rem;">
                    <tr>
                        <th style="padding: 1rem; text-align: left;">Dates</th>
                        <th style="padding: 1rem; text-align: left;">Moniteur</th>
                        <th style="padding: 1rem; text-align: left;">Candidats</th>
                        <th style="padding: 1rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programmations as $p)
                    <tr style="border-bottom: 1px solid var(--color-gray-100);">
                        <td style="padding: 1rem;">{{ $p->dateDebut }} au {{ $p->dateFin }}</td>
                        <td style="padding: 1rem; font-weight: 600;">{{ $p->moniteur ? $p->moniteur->nom.' '.$p->moniteur->prenom : 'N/A' }}</td>
                        <td style="padding: 1rem;">
                            @foreach($p->candidats as $c)
                                <span style="display: inline-block; background: #f0fdf4; color: #166534; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; margin-right: 0.3rem;">{{ $c->nom }}</span>
                            @endforeach
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="{{ route('programmations.edit', $p->id) }}" style="color: var(--color-green); text-decoration: none;">✎</a>
                                <form action="{{ route('programmations.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button style="color: var(--color-red); background: none; border: none; cursor: pointer;">✕</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts::app.sidebar>