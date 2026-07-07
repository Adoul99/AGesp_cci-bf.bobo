# Contrat `.solo/` — connaissance du projet pour Solo

Ce projet est piloté par **Solo**. Sa connaissance structurée vit dans le dossier
**`.solo/`** à la racine : Solo l'ingère pour afficher, lancer et suivre le projet.
Ta mission (en plus de coder) : **garder `.solo/` à jour** au format ci-dessous.

> `.claude/` = ton contexte de travail ; `.solo/` = la donnée que Solo lit. Ne
> mets **jamais** de secret en clair (token, mot de passe) : ils vont au vault de Solo.

## 1. Où écrire — arborescence `.solo/`

```
.solo/
  fiche.md                 analyse fonctionnelle (sans tâches)
  secrets.md               identifiants → chiffrés au vault à l'ingestion (auto)
  git/        infos.md · branchs.md · request.md · ci-cd.md · graphes.svg
  db/         db.md · migration.md · backup/<date>.md
  script/     lancement.md · build.md · test.md · cli.md
  architecture/  dossier.md · routage.md · serveur.md
  stack/      technologie.md · architecture.md
  activite/   <date>.md     (date AAAA-MM-JJ : sprint, tâches, kanban, gantt)
  audit/      <horodatage>.md  (AAAA-MM-JJ_HHMM : treemaps sécurité/fiabilité…)
  test/       <nom>.md      (scénarios : workflow complet en couloirs / BPMN)
  assets/     icône, captures, svg (référencés, pas du texte)
```

- Le **chemin du fichier porte le sens** (`stack/technologie.md` = la stack).
- Fichiers ingérés : `.md` et `.svg`. Ré-écrire un fichier le **remplace** (pas de doublon).

## 2. Comment écrire — format d'un fichier

- **Front-matter YAML** optionnel en tête (`---…---`) = données du fichier.
- **Corps** = markdown, pouvant contenir des **blocs** :

```md
::: <type>
---
<props YAML>      # optionnel, en 1re position ; toute donnée structurée va ici
---
<corps markdown>  # optionnel
:::
```

## 3. Blocs utiles

> Chaque grande catégorie présente (`stack`, `db`, `architecture`, `script`,
> `git`, `activite`) devient un **onglet** de la fiche projet dans Solo.

| Fichier | À mettre |
|---|---|
| `fiche.md` | front-matter `description`/`etat`/`categorie` (méta projet) + `analyse`, `titre`, `tableau`, `diagramme` (Mermaid), `decision` |
| `secrets.md` | front-matter `secrets: [{cle, libelle, valeur}]` → **chiffrés au vault** à l'ingestion (valeur effacée du fichier) |
| `stack/technologie.md` | front-matter `couches` (graphe à logos) + `tableau` de versions |
| `script/lancement.md` (·`build`·`test`) | `commandes` — **lancer l'app** (séquence + `check`) |
| `script/cli.md` | `commandes` — **créer un projet du même type** (scaffold) |
| `db/db.md` | front-matter connexion (`base`, `host`…) + bloc `dictionnaire` |
| `architecture/dossier.md` | bloc `arborescence` (dossiers **et** fichiers, repliable) |
| `architecture/routage.md` | bloc `sitemap` — plan de navigation (haut→bas) |
| `stack/architecture.md` | bloc `sitemap` `direction: lr` — composants (gauche→droite) |
| `activite/<date>.md` | `titre`, `analyse`, `sprint`, `kanban`, `gantt` |
| `audit/<date>.md` | plusieurs blocs `treemap` (sécurité, fiabilité, fonctionnel…) |
| `test/<nom>.md` | bloc `swimlane` (workflow complet du test, en couloirs/BPMN) |

**Graphe des technologies** (`stack/technologie.md`) :
```yaml
---
couches:
  - nom: Frontend
    couleur: "#6366f1"
    technos:
      - nom: React
        logo: /react.png      # asset de public/ côté Solo
        libs: [Zustand, Tailwind]
---
```

**Scripts** — deux choses **bien distinctes**, toutes deux en `commandes` avec
`check` optionnel (= **pré-check de ressource** : on n'exécute la commande que si
la ressource ne répond **pas déjà**) :

**1. Séquence de lancement** (`script/lancement.md`, `build.md`, `test.md`…) —
enchaîne le **démarrage de l'app existante** : vérifie chaque ressource, l'active
si besoin, puis ouvre les outils/URL. Solo affiche **une card par fichier** avec
« Lancer la séquence » (exécute les `auto: true` dans l'ordre) + un bouton par
commande clé. Exemple (Angular + Spring Boot) :
```yaml
---
commandes:
  - code: laragon
    label: Serveur (Laragon)
    check: { cmd: "...ping", attendu: "alive" }   # déjà actif ? on saute
    cmd: "C:/laragon/laragon.exe start"
    auto: true
    ordre: 1
  - { code: vscode, label: VS Code, cmd: "code .", auto: true, ordre: 2 }
  - { code: front, label: Angular (dev), cmd: "npm run start", auto: true, ordre: 3 }
  - code: api
    label: API Spring
    check: { cmd: "curl -s localhost:8080/actuator/health", attendu: "UP" }
    cmd: "..."                # démarre l'API seulement si le health est KO
    auto: true
    ordre: 4
  - { code: open, label: Ouvrir l'app, cmd: "start http://localhost:4200", auto: true, ordre: 5 }
---
```

**2. Séquence CLI** (`script/cli.md`) — les **commandes + vérifications pour CRÉER
un nouveau projet du même type** (≠ lancer l'app existante !). Pré-checks des
prérequis (toolchain), puis création / install / premier lancement. Sert la
**création de projet** ; **exclue** des cards de lancement (c'est du *scaffold*,
pas du *run*).
```yaml
---
commandes:
  - code: outil
    label: Toolchain présent
    check: { cmd: "node --version", attendu: "v" }
    cmd: "echo installe l'outil requis…"   # lancé seulement si le check est KO
    ordre: 1
  - { code: creer, label: Créer le projet, cmd: "npx create-... mon-app", ordre: 2 }
  - { code: install, label: Dépendances, cmd: "npm install", cwd: "mon-app", ordre: 3 }
---
```

**Base de données** (`db/db.md`) — Solo affiche 2 colonnes : la connaissance (à
gauche) et un **audit temps réel** de la base (à droite, lecture seule, non
persisté). Renseigne la **connexion** en front-matter et le **dictionnaire
documenté** ; Solo marque les différences (colonnes en plus/en moins/modifiées) :
```yaml
---
base: ma_base              # requis pour l'audit ; host/port/user/password si distant
host: 127.0.0.1
---
```
```md
::: dictionnaire
---
colonnes:
  - { table: users, colonne: id, type: bigint, cle: PRI }
  - { table: users, colonne: email, type: "varchar(255)" }
---
:::
```
> ⚠️ Pas de secret en clair à terme : les identifiants iront au **vault** de Solo.

**Activité** (`activite/<date>.md`) : `analyse` (ce qui a été fait + pourquoi),
`sprint` (`{nom, statut, capacite, engages, completes, progression, joursRestants}`),
`kanban` (`{colonnes:[{titre, couleur, cartes:[{titre, description, points}]}]}`),
`gantt` (`{taches:[{nom, debut, fin, couleur}]}`, dates `AAAA-MM-JJ`).

**Diagrammes hiérarchiques** — bloc `sitemap`, en **vraies cards** (icône emoji +
titre + description). `direction: lr` (gauche→droite) pour l'architecture, défaut
`tb` (haut→bas) pour le routage :
```yaml
::: sitemap
---
direction: lr            # tb (défaut) | lr
racine:
  nom: App
  icone: "🧩"
  enfants:
    - { nom: UI, icone: "🖥️", description: "React" }
---
:::
```

**Arborescence** (`architecture/dossier.md`) — bloc `arborescence`, dossiers
**repliables** + fichiers (icône selon l'extension). Représente le réel pour
**comprendre l'existant** :
```yaml
::: arborescence
---
racine:
  nom: "src/"
  enfants:
    - { nom: "main.ts" }
    - nom: "lib/"
      enfants: [ { nom: "util.ts" } ]
---
:::
```

**Audit** (`audit/<date>.md`, horodaté comme l'activité) — un fichier par audit,
contenant **plusieurs** blocs `treemap`, un par dimension (sécurité, fiabilité,
fonctionnel…). Surface ∝ `valeur` ; couleur via `severite` (`critique`/`eleve`/
`moyen`/`faible`/`info`) ou `couleur`. **Chaque tuile dit clairement le problème** :
mets un `resume` (phrase courte affichée **sur la tuile**, lisible d'un coup d'œil).
Au clic, un panneau de détail s'ouvre → **détaille au maximum** : `icone`,
`description` (markdown, **blocs de code/traceback OK**), `items` (findings),
`recommandation` (markdown), `trace` (traceback/logs/données brutes → bloc de code).
Hiérarchie via `enfants`.
```yaml
::: treemap
---
titre: Sécurité
noeuds:
  - nom: "Dépendances vulnérables"
    valeur: 12
    icone: "🔑"
    severite: critique
    resume: "3 CVE critiques dans les libs directes"
    description: "**3 CVE** critiques dans les dépendances directes."
    items: ["lib-x < 2.1 (RCE)", "lib-y (XSS)"]
    recommandation: "Mettre à jour et re-scanner."
  - { nom: "Auth", valeur: 5, icone: "🔒", severite: moyen, description: "MFA absent." }
  - nom: "Config"
    icone: "⚙️"
    enfants:
      - { nom: "TLS", valeur: 2, severite: faible }
      - { nom: "CORS", valeur: 1, severite: faible }
---
:::
```

**Tests** (`test/<nom>.md`, un scénario par fichier) — décris le **workflow
complet** du test en couloirs (swimlane / BPMN) : `couloirs` = acteurs/systèmes,
`etapes` = suite ordonnée `{couloir, nom, type, …}`. `type` ∈ `debut` / `action` /
`decision` / `test` (assertion) / `erreur` / `fin`. Par étape : `statut` (`ok` /
`echec`, marquage clair), `detail` (court), et au clic `description` (markdown),
`attendu` / `obtenu`, `trace` (traceback/logs en bloc de code).
```yaml
::: swimlane
---
titre: "Inscription (E2E)"
couloirs: [Utilisateur, Frontend, API, BD]
etapes:
  - { couloir: Utilisateur, nom: "Saisit le formulaire", type: debut }
  - { couloir: Frontend, nom: "Validation champs", type: action }
  - { couloir: API, nom: "Email déjà pris ?", type: decision }
  - { couloir: BD, nom: "INSERT user", type: action }
  - { couloir: API, nom: "201 + token", type: test, detail: "assert status 201" }
  - { couloir: Utilisateur, nom: "Redirigé /accueil", type: fin }
---
:::
```

**État réel git** : la page Git lit le **dépôt local** (branche, status, commits,
branches, tags) directement — pas besoin de le décrire dans `.solo/git/`. Mets-y
plutôt les infos qui n'existent pas en local (compte/URL distante, conventions).

## 4. Mettre à jour efficacement

L'ingestion est **par fichier** : ré-écrire un fichier `.solo/` **remplace**
exactement cet élément (dédup par chemin). Tu n'as donc jamais à tout régénérer.

- **Touche seulement le(s) fichier(s) concerné(s)** par ton changement, pas tout
  `.solo/` : migration/schéma → `db/db.md` · nouvelle route/page → `architecture/routage.md`
  · stack modifiée → `stack/technologie.md` · dépendance/commande → `script/*.md`
  · travail du jour → `activite/<AAAA-MM-JJ>.md` (un fichier par jour).
- **Un type = un fichier** : mets l'info à sa place unique, ne duplique pas.
- **Méta projet** (`description`/`etat`/`categorie`) → front-matter de `fiche.md`.
- **Réutilise le bon bloc** (table §3) plutôt que du markdown libre : Solo en tire
  un rendu riche (graphe, dictionnaire, kanban, gantt, sitemap, arborescence…).
- **Ne redécris pas ce que Solo audite en direct** : l'état git local et la
  structure réelle de la BD sont lus automatiquement — documente seulement
  l'**intention** (dictionnaire attendu, conventions, compte distant).
- Après écriture, l'utilisateur **synchronise** la catégorie dans Solo
  (ré-ingestion ciblée de `.solo/<catégorie>/`), donc garde chaque fichier
  cohérent et autonome.
