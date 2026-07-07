Définis l'**architecture logicielle finale** de l'idée, les **choix
technologiques** et les **dépendances**. Écris/mets à jour
`.solo/idee/techno/<ideation>.md` (un fichier par idéation). Dernière étape de la
chaîne d'idéation.

Objectif : figer la solution technique retenue — l'archi (couches/composants),
la stack par couche, et les dépendances clés avec leur rôle. C'est le pont entre
l'idéation et la création réelle du projet (`script/cli.md` s'en inspirera).

Front-matter OBLIGATOIRE (identifie l'idéation) :
```yaml
---
ideation: <slug-idéation>
date: AAAA-MM-JJ
---
```

Structure du fichier :
- `::: titre` puis `::: analyse` (le raisonnement : pourquoi cette archi/stack).
- **Architecture finale** — un bloc `::: diagramme` (Mermaid `flowchart`). Les
  liens sont rendus **droits** par Solo (pas de courbes). Pour des tuiles claires :
  **une couleur par couche** via `classDef` + `class`. (Mermaid ne peut pas
  afficher d'images — les vrais logos vont dans « Choix technologiques ».)
  Squelette :
  ```
  ::: diagramme
  flowchart LR
    UI["UI"]:::front
    API["API"]:::back
    DB[("BD")]:::data
    UI --> API --> DB
    classDef front fill:#6366f1,stroke:#4f46e5,color:#fff;
    classDef back  fill:#0ea5e9,stroke:#0284c7,color:#fff;
    classDef data  fill:#14b8a6,stroke:#0d9488,color:#fff;
  :::
  ```
  (Un bloc `::: sitemap` `direction: lr` en cards reste possible si un org-chart
  est plus parlant qu'un flux.)
- **Choix technologiques** — un bloc **`::: technos`** portant `couches` en props
  (par couche : les technos retenues et leurs libs). Pour le logo, **écris juste le
  nom de la techno** (`nom: React`) : **Solo résout** l'image réelle depuis le nom
  et met une **icône de repli** si elle n'existe pas — tu n'as pas à connaître les
  fichiers ni à écrire de chemin.
- **Dépendances** — un bloc `::: tableau` : `{ dépendance | rôle | version | couche }`,
  chaque ligne justifiée (pourquoi cette dépendance).

Exemple (choix technologiques — Solo résout les logos par le nom) :
```
::: technos
---
couches:
  - nom: Frontend
    couleur: "#6366f1"
    technos:
      - { nom: React, libs: [Zustand, Tailwind] }
      - { nom: Vite }
  - nom: Backend
    couleur: "#0ea5e9"
    technos:
      - { nom: Laravel, libs: [Filament] }
      - { nom: PostgreSQL }
---
:::
```

Base-toi sur les décisions réelles de l'idéation (domaines, contraintes vues en
Ishikawa/TRIZ). N'invente pas une stack hors-sujet. Ne touche qu'à
`.solo/idee/techno/`. Visible dans l'onglet **Technologie**.

Périmètre (optionnel) : $ARGUMENTS
