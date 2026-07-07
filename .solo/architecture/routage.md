---
---

# Routage — AGesP

::: sitemap
---
racine:
  nom: Home
  icone: "🏠"
  description: "Page d'accueil publique"
  enfants:
    - nom: "/s-inscrire"
      icone: "📝"
      description: "Inscription publique candidat"
    - nom: "Auth"
      icone: "🔐"
      description: "Authentification (Fortify)"
      enfants:
        - { nom: "login", icone: "🔑" }
        - { nom: "register", icone: "📋" }
        - { nom: "forgot-password", icone: "🔄" }
    - nom: "Candidat"
      icone: "👤"
      description: "Espace candidat (middleware auth + candidat.only)"
      enfants:
        - { nom: "/mon-espace", icone: "📊" }
        - { nom: "/mon-espace/attestations", icone: "📄" }
        - { nom: "Formation", icone: "📚" }
        - { nom: "Examination", icone: "✏️" }
    - nom: "Moniteur"
      icone: "👨‍🏫"
      description: "Espace moniteur"
      enfants:
        - { nom: "/moniteur/espace", icone: "📊" }
        - { nom: "Formations", icone: "📚" }
        - { nom: "Évaluations", icone: "📝" }
    - nom: "Admin"
      icone: "⚙️"
      description: "Gestion système (superadmin + admin)"
      enfants:
        - { nom: "/dashboard", icone: "📊" }
        - nom: "Gestion"
          icone: "📋"
          enfants:
            - { nom: "Candidats" }
            - { nom: "Moniteurs" }
            - { nom: "Formations" }
            - { nom: "Sessions" }
            - { nom: "Véhicules" }
            - { nom: "Catégories Permis" }
            - { nom: "Utilisateurs" }
        - nom: "Finance"
          icone: "💰"
          enfants:
            - { nom: "Paiements" }
            - { nom: "Reçus" }
        - nom: "Évaluation"
          icone: "📊"
          enfants:
            - { nom: "Évaluations" }
            - { nom: "Examens" }
            - { nom: "Notes" }
---
:::
