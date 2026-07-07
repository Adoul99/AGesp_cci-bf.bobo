---
---

# Architecture (composants) — AGesP

::: sitemap
---
direction: lr
racine:
  nom: AGesP App
  icone: "🧩"
  enfants:
    - nom: Frontend
      icone: "🖥️"
      description: "Flux + Livewire"
      enfants:
        - nom: Candidat
          icone: "👤"
          description: "Espace candidat"
        - nom: Admin
          icone: "⚙️"
          description: "Gestion système"
        - nom: Moniteur
          icone: "👨‍🏫"
          description: "Gestion formations"
    - nom: Backend
      icone: "⚙️"
      description: "Laravel + Livewire"
      enfants:
        - nom: Controllers
          icone: "📋"
          description: "Logique métier"
        - nom: Models
          icone: "📦"
          description: "Entités métier"
        - nom: Middleware
          icone: "🔐"
          description: "Authentification"
    - nom: Database
      icone: "🗄️"
      description: "SQLite / MySQL"
      enfants:
        - nom: Candidatures
          icone: "📄"
        - nom: Formations
          icone: "📚"
        - nom: Évaluation
          icone: "📊"
        - nom: Ressources
          icone: "🚗"
        - nom: Finances
          icone: "💰"
---
:::
