---
commandes:
  - code: model
    label: Générer un modèle
    cmd: "php artisan make:model {nom} --migration"
    auto: false
    ordre: 1
  - code: controller
    label: Générer un contrôleur
    cmd: "php artisan make:controller {nom}"
    auto: false
    ordre: 2
  - code: livewire
    label: Générer un composant Livewire
    cmd: "php artisan livewire:make {nom}"
    auto: false
    ordre: 3
  - code: migration
    label: Créer une migration
    cmd: "php artisan make:migration {nom}"
    auto: false
    ordre: 4
  - code: seeder
    label: Générer un seeder
    cmd: "php artisan make:seeder {nom}"
    auto: false
    ordre: 5
---

## CLI — Scaffolding AGesP

Commandes pour générer rapidement du code Laravel (modèles, contrôleurs, composants, etc.)

