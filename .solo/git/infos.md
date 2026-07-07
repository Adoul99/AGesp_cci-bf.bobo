---
---

# Git — Infos

## Projet AGesP

- **Type** : Laravel 13 avec Livewire 4
- **Chemin local** : `C:\laragon\www\AGesP`
- **URL repo** : (à configurer)
- **Branch principale** : `main`

## Configuration

| Élément | Valeur |
|---------|--------|
| PHP | 8.3+ |
| Composer | ^2.0 |
| Node.js | 16+ |
| npm | 9+ |
| Laravel | 13.7+ |
| Livewire | 4.1+ |

## Startup

```bash
# Installation
composer install
npm install

# Configuration
copy .env.example .env
php artisan key:generate

# Migration & Seed
php artisan migrate
php artisan db:seed

# Dev
composer run dev
```

## Conventions

- **Commits** : Format conventionnel (feat, fix, docs, etc.)
- **Code style** : Pint + Laravel PSR standards
- **Tests** : PHPUnit pour les tests unitaires
- **Documentation** : Utilise `.solo/` pour la connaissance structurée
