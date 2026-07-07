---
commandes:
  - code: composer
    label: Installer dépendances PHP
    check: { cmd: "composer --version", attendu: "Composer" }
    cmd: "composer install"
    auto: true
    ordre: 1
  - code: npm
    label: Installer dépendances Node
    check: { cmd: "npm --version", attendu: "v" }
    cmd: "npm install"
    auto: true
    ordre: 2
  - code: env
    label: Configurer .env
    check: { cmd: "test -f .env", attendu: "exists" }
    cmd: "copy .env.example .env"
    auto: false
    ordre: 3
  - code: key
    label: Générer clé APP_KEY
    check: { cmd: "grep APP_KEY .env | grep -v localhost", attendu: "generated" }
    cmd: "php artisan key:generate"
    auto: true
    ordre: 4
  - code: db
    label: Lancer les migrations
    check: { cmd: "test -f database/database.sqlite", attendu: "exists" }
    cmd: "php artisan migrate --force"
    auto: true
    ordre: 5
  - code: vscode
    label: VS Code
    cmd: "code ."
    auto: true
    ordre: 6
  - code: server
    label: Serveur Laravel (artisan serve)
    check: { cmd: "curl -s http://localhost:8000", attendu: "200" }
    cmd: "php artisan serve"
    auto: true
    ordre: 7
  - code: queue
    label: Queue worker
    check: { cmd: "ps | grep queue:listen", attendu: "running" }
    cmd: "php artisan queue:listen --tries=1"
    auto: true
    ordre: 8
  - code: vite
    label: Vite dev server
    check: { cmd: "curl -s http://localhost:5173", attendu: "200" }
    cmd: "npm run dev"
    auto: true
    ordre: 9
  - code: open
    label: Ouvrir l'app
    cmd: "start http://localhost:8000"
    auto: true
    ordre: 10
---

## Lancement du projet AGesP (développement)

Séquence complète pour démarrer l'application en environnement de développement :
- Installation des dépendances PHP et Node
- Configuration de l'environnement
- Initialisation de la base de données
- Lancement des serveurs (Laravel + Vite + Queue)
