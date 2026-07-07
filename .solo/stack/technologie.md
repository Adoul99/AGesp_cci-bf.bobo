---
couches:
  - nom: Frontend
    couleur: "#3b82f6"
    technos:
      - nom: "Flux"
        logo: "/flux.png"
        libs: ["Livewire"]
      - nom: "Tailwind CSS"
        logo: "/tailwind.png"
        libs: ["Vite"]
      - nom: "Vite"
        logo: "/vite.png"
        libs: []
      - nom: "Choices.js"
        logo: ""
        libs: []
  - nom: Backend
    couleur: "#e11d48"
    technos:
      - nom: "Laravel"
        logo: "/laravel.png"
        libs: ["Livewire", "Fortify", "Tinker"]
      - nom: "Livewire"
        logo: "/livewire.png"
        libs: ["Flux"]
      - nom: "Fortify"
        logo: ""
        libs: []
      - nom: "PHP"
        logo: "/php.png"
        libs: []
  - nom: Base de données
    couleur: "#8b5cf6"
    technos:
      - nom: "SQLite"
        logo: "/sqlite.png"
        libs: []
      - nom: "MySQL"
        logo: "/mysql.png"
        libs: []
  - nom: DevOps & Quality
    couleur: "#10b981"
    technos:
      - nom: "PHPUnit"
        logo: ""
        libs: []
      - nom: "Pint"
        logo: ""
        libs: []
      - nom: "Laravel Sail"
        logo: ""
        libs: []
---

# Stack technique — AGesP

::: tableau
---
code: stack-versions
entetes: ["Technologie", "Rôle", "Version"]
lignes:
  - ["PHP", "Runtime", "^8.3"]
  - ["Laravel", "Framework backend", "^13.7"]
  - ["Livewire", "Framework réactif", "^4.1"]
  - ["Flux", "Composants UI", "^2.13.1"]
  - ["Fortify", "Authentification", "^1.34"]
  - ["Vite", "Build tool", "^8.0.0"]
  - ["Tailwind CSS", "Styling", "^4.0.7"]
  - ["SQLite", "Base de données (dev)", "par défaut"]
  - ["MySQL", "Base de données (prod)", "via env"]
  - ["PHPUnit", "Testing", "^12.5.23"]
  - ["Pint", "Linting / Formatting", "^1.27"]
---
:::

## Architecture technique

**Frontend réactif** : Flux + Livewire pour une expérience interactive sans rechargement complet.
**Backend scalable** : Laravel avec Fortify pour l'authentification sécurisée.
**Build moderne** : Vite pour un développement rapide et des builds optimisés.
**Code quality** : Pint pour la cohérence, PHPUnit pour la couverture de tests.
