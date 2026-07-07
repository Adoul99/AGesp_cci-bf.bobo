---
---

# Arborescence — AGesP

::: arborescence
---
racine:
  nom: "AGesP/"
  enfants:
    - nom: "app/"
      enfants:
        - nom: "Http/"
          enfants:
            - nom: "Controllers/"
              enfants:
                - { nom: "Auth/" }
                - { nom: "CandidatController.php" }
                - { nom: "DossierController.php" }
                - { nom: "InscriptionController.php" }
                - { nom: "FormationController.php" }
                - { nom: "ExamenController.php" }
                - { nom: "EvaluationController.php" }
                - { nom: "ProgrammationController.php" }
                - { nom: "PaiementController.php" }
                - { nom: "MoniteurController.php" }
                - { nom: "VehiculeController.php" }
            - nom: "Middleware/"
            - nom: "Responses/"
        - nom: "Livewire/"
          enfants:
            - { nom: "Actions/" }
        - nom: "Models/"
          enfants:
            - { nom: "Candidat.php" }
            - { nom: "Dossier.php" }
            - { nom: "Inscription.php" }
            - { nom: "Formation.php" }
            - { nom: "SessionFormation.php" }
            - { nom: "Examen.php" }
            - { nom: "Evaluation.php" }
            - { nom: "NoteEvaluation.php" }
            - { nom: "Programmation.php" }
            - { nom: "Moniteur.php" }
            - { nom: "Vehicule.php" }
            - { nom: "CategoriePermis.php" }
            - { nom: "Paiement.php" }
            - { nom: "Recus.php" }
            - { nom: "User.php" }
        - nom: "Providers/"
          enfants:
            - { nom: "AppServiceProvider.php" }
            - { nom: "FortifyServiceProvider.php" }
    - nom: "bootstrap/"
      enfants:
        - { nom: "app.php" }
        - { nom: "providers.php" }
    - nom: "config/"
      enfants:
        - { nom: "app.php" }
        - { nom: "database.php" }
        - { nom: "fortify.php" }
        - { nom: "auth.php" }
    - nom: "database/"
      enfants:
        - nom: "migrations/"
          enfants:
            - { nom: "(48 migrations)" }
        - nom: "seeders/"
        - nom: "factories/"
    - nom: "resources/"
      enfants:
        - nom: "css/"
          enfants:
            - { nom: "app.css" }
        - nom: "js/"
          enfants:
            - { nom: "app.js" }
        - nom: "views/"
          enfants:
            - { nom: "layout/" }
            - { nom: "components/" }
            - { nom: "...livewire/" }
    - nom: "routes/"
      enfants:
        - { nom: "web.php" }
        - { nom: "api.php" }
    - nom: "storage/"
    - nom: "tests/"
    - nom: "vendor/"
    - nom: "public/"
    - { nom: "artisan" }
    - { nom: "composer.json" }
    - { nom: "package.json" }
    - { nom: "vite.config.js" }
    - { nom: ".env.example" }
---
:::
