---
commandes:
  - code: lint-check
    label: Vérifier style (Pint)
    cmd: "composer lint:check"
    auto: true
    ordre: 1
  - code: phpunit
    label: Tests unitaires (PHPUnit)
    cmd: "php artisan test"
    auto: true
    ordre: 2
  - code: full
    label: Suite complète (Pint + Tests)
    cmd: "composer test"
    auto: true
    ordre: 3
---

## Tests AGesP

Commandes pour valider la qualité et la couverture du code :
- Lint PHP avec Pint
- Tests avec PHPUnit
- Nettoyage du cache de config avant les tests
