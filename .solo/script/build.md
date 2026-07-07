---
commandes:
  - code: vite-build
    label: Build Vite (assets frontend)
    cmd: "npm run build"
    auto: true
    ordre: 1
  - code: collect-assets
    label: Publier les assets Laravel
    cmd: "php artisan vendor:publish --tag=laravel-assets --force"
    auto: true
    ordre: 2
---

## Build AGesP

Commandes pour construire l'application pour la production :
- Compilation des assets Vite (CSS, JS)
- Publication des assets publics Laravel
