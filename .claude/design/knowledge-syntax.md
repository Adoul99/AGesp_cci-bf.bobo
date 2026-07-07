# Syntaxe de connaissance — grammaire de bloc ⇄ `element_connaissance`

Format d'**échange machine** entre Claude (qui écrit) et Solo (qui parse, rend,
exécute). Objectifs : **facile à générer** pour un LLM (markdown + YAML),
**parse déterministe** et fidèle, **mappable à des composants UI** variés.

Ce n'est **pas** de la documentation pour humain : la lisibilité est secondaire,
la fidélité machine est prioritaire.

Ce document décrit la **grammaire de bloc** (front-matter + blocs `:::`). Son
**emplacement** est fixé par le [contrat `.solo/`](solo-contract.md) : la
connaissance d'un projet vit dans le dossier **`.solo/`** à sa racine, où le
**chemin du fichier porte le type** de l'élément racine. Les blocs `:::` décrits
ici restent la grammaire du **corps** de chaque fichier `.solo/` (enfants).

## 1. Emplacement & sessions

La connaissance d'un projet géré vit dans **`.solo/`** à sa racine (cf.
[solo-contract.md](solo-contract.md)) :

```
<projet>/.solo/<dossier>/<nom>.md|svg
```
- Un **fichier `.solo/` = un `element_connaissance` racine** (type dérivé du
  chemin) + ses blocs `:::` en enfants. Ré-ingérer **upserte** sur `(projet, type, cle)`.
- Git (du projet géré) assure le **versioning** de l'arbre `.solo/`.
- La prose libre humaine (`CLAUDE.md`, `.claude/rules/`) vit ailleurs et n'est
  **jamais** touchée par l'ingestion.

> Historique : l'échange passait d'abord par `.claude/solo/sessions/<ts>_<id>/`
> (un fichier = une `ingestion`). Cet emplacement est **remplacé** par l'arbre
> `.solo/` ; le front-matter ci-dessous reste utilisé comme `props` du racine.

## 2. Structure d'un fichier

```md
---
projet: <slug>          # obligatoire — clé du projet (DB = autorité projets)
session: <ts>_<id>      # obligatoire
source: claude          # claude | manuel | scan
version: 1              # version de la syntaxe
---

<blocs…>
```
- Front-matter YAML délimité par `---` en tête → métadonnées d'`ingestion`.
- Corps = une suite de **blocs** (+ texte libre = blocs `narratif` implicites).

## 3. Grammaire d'un bloc (déterministe)

```md
::: <type>
---
<props YAML>      ← optionnel, doit être la 1re chose dans le bloc
---
<corps markdown>  ← optionnel
:::
```

Règles de parsing (en début de ligne, sans indentation) :
- `::: <type>` → **ouverture** d'un bloc. `<type>` ∈ `[a-z0-9_-]+` (code du
  vocabulaire `type_connaissance`).
- `:::` (seul) → **fermeture** du bloc courant.
- **Props** : si la 1re ligne du bloc est `---`, tout jusqu'au `---` suivant est
  du **YAML** (charge utile structurée). Sinon, pas de props. → **Toute donnée
  structurée** (`commandes`, `image`, `valeur`, `code`…) **doit** être en props
  `---…---` ; le corps (hors props) est **toujours** du markdown.
- **Corps** : le reste jusqu'au `:::` fermant = markdown (peut contenir des blocs
  **imbriqués**).
- **Imbrication** : un `::: <type>` rencontré dans un corps ouvre un **enfant**
  (pile open/close). `parent_id` reflète l'imbrication.
- **Texte hors bloc** (niveau racine) : les lignes consécutives non-marqueur sont
  regroupées en un bloc `narratif`.
- Pour un `:::` **littéral** dans du contenu : le mettre dans un bloc de code
  markdown (``` ``` ```).

## 4. Vocabulaire de types (`type_connaissance`, extensible sans migration)

Le **type = le composant de rendu**. Exemples (la liste grandit) :

| type | corps/props | rendu |
|---|---|---|
| `analyse`, `doc`, `note` | markdown | texte/markdown |
| `titre` | corps | titre de section |
| `carte-stat` | props `{valeur, label, couleur, icone}` | StatCard |
| `tableau` | corps (table markdown) | tableau |
| `decision` | corps + props `{code}` | carte décision |
| `ecart` | props `{attendu, reel, gravite}` | diff théorie/réel |
| `lancement` | props `{commandes:[…]}` | séquence + bouton « Lancer » |
| `apparence` | props `{image, loader, couleur}` | identité visuelle du projet |

## 5. Mapping → `element_connaissance`

| Syntaxe | Colonne |
|---|---|
| front-matter | `ingestion` (projet, source, `charge_brute`=fichier brut, `recue_le`) |
| `::: <type>` | `type_id` → `type_connaissance.code` (créé si nouveau) |
| `code:` (dans props) | `cle` |
| props + corps | `valeur` = JSON `{ "props": {…}, "corps": "…" }` |
| position entre frères | `ordre` |
| bloc imbriqué | `parent_id` |
| (fichier) | `ingestion_id` |

## 6. Dédup (règle stricte)

- Identité d'un élément = **(`projet`, `type`, `cle`)** quand `cle` ≠ null.
  Ré-ingérer le même triplet → **upsert** (remplace), jamais de doublon.
- Idem pour les **commandes** d'un bloc `lancement` : chaque `code` est **unique
  dans le projet** (pas de doublon de code de lancement).

## 7. Blocs sémantiques interprétés

### `lancement` — séquence de **commandes terminal**
```md
::: lancement
---
commandes:
  - code: laragon-start
    cmd: "C:/laragon/laragon.exe start"
    auto: true
    ordre: 1
    role: serveur          # métadonnée optionnelle (icône)
  - code: vscode
    cmd: "code ."
    auto: true
    ordre: 2
  - code: artisan-serve
    cmd: "php artisan serve"
    cwd: "."
    auto: true
    ordre: 3
  - code: open-app
    cmd: "start http://localhost:8000"
    auto: true
    ordre: 4
  - code: claude
    cmd: "claude"
    auto: false
---
:::
```
- **« Lancer »** = exécuter les commandes `auto: true` **dans l'ordre**, via le
  runner (`executer`/`lancer_detache`). Tout est une commande shell — pas de
  distinction app/cli/url à l'exécution.
- **Pré-check de ressource** (optionnel par commande) : `check: {cmd, attendu}`.
  Avant de lancer la commande, Solo exécute `check.cmd` ; si elle réussit et que
  sa sortie contient `attendu`, la **ressource est déjà active** et la commande
  d'activation est **sautée** (ex : ne pas relancer Laragon s'il répond déjà au
  `ping`). Sinon, la commande est exécutée. `label` et `role` sont des
  métadonnées d'affichage (titre lisible, icône).
- **Plusieurs scripts** : `script/lancement.md`, `script/build.md`,
  `script/test.md`… → types `script-lancement`, `script-build`, `script-test`.
  Chacun est une **card** dans la fiche (séquence + bouton « Lancer », et un
  bouton par commande clé). `script/cli.md` (init à la création) en est exclu.

### `stack-technologie` — graphe des technologies (front-matter `couches`)
Le fichier `stack/technologie.md` peut porter, dans son **front-matter**, un
graphe en couches rendu avec les logos (assets `public/`) :
```yaml
couches:
  - nom: Frontend
    couleur: "#6366f1"
    technos:
      - nom: React 19
        logo: /js.png          # asset de public/ (servi à la racine)
        libs: [Zustand, Tailwind]
  - nom: Données
    couleur: "#10b981"
    technos:
      - nom: MySQL
        libs: [InnoDB]
```
→ rendu en couches (logo + nom + librairies), une flèche entre couches. À défaut
de `logo`, repli sur les initiales. Sans `couches`, on retombe sur les blocs
`:::` du corps (`diagramme` Mermaid, `tableau`…).

### `apparence` — identité visuelle
```md
::: apparence
---
image: "./.solo/assets/logo.png"   # ou URL
loader: "barre"            # barre | spinner | logo-pulse
couleur: "#0ea5e9"
---
:::
```
→ `image` reflétée sur `projet` (rendu rapide des tuiles) ; `loader` pilote
l'overlay pendant le « Lancer ».

## 8. Round-trip (génération)

Régénérer un fichier = sérialiser les `element_connaissance` (par `ordre` et
imbrication) en blocs `::: type / props / corps / :::`. Test attendu :
`parse(génère(x)) == x`. `ingestion.charge_brute` conserve le brut pour exactitude.

## 9. Exemple complet

```md
---
projet: laravel-shop
session: 2026-06-22T18-00_42
source: claude
version: 1
---

::: titre
État du projet
:::

::: carte-stat
---
valeur: 12
label: Tâches ouvertes
couleur: emerald
---
:::

::: lancement
---
commandes:
  - code: vscode
    cmd: "code ."
    auto: true
    ordre: 1
---
:::

::: analyse
Projet **Laravel 11** monorepo. Connecté à MySQL.
:::
```

## 10. Blocs d'idéation (phase pré-projet, `.solo/idee/`)

La chaîne d'idéation (mind map → Ishikawa → TRIZ → How-How → priorisation →
tâches) utilise ces blocs. **Emplacement** : `.solo/idee/` — cf.
[module-ideation.md](module-ideation.md). Un `code` stable identifie chaque
élément ; les **relations** (`resout`, `regroupe`, `depend_de`) le référencent.

> ⚠️ **Règle YAML critique** : toute valeur contenant `: ` (deux-points +
> espace), `#`, `[`, `{`, `:` en fin, ou commençant par `-`/`?` **doit être
> quotée** (`"…"`). Un seul `: ` non quoté fait **échouer tout le bloc**
> silencieusement (il n'apparaît pas). Ex : `description: "L'IA : un canal."`.

### `mindmap` — exploration des features (radial)
```md
::: mindmap
---
centre: Mon produit
branches:
  - nom: Feature A
    type: feature            # feature | existant | outil
    code: feat-a
    icone: "🎯"              # emoji (optionnel)
    logo: /tauri.svg         # image public/ (optionnel, prioritaire sur icone)
    description: "Texte (quoter si ':' présent)."
    capacites: [Cap 1, Cap 2]   # listes → détail au clic
    interets: [Intérêt 1]
    blocages: ["Question ?"]
    enfants:
      - nom: Sous-feature
        type: outil
        code: outil-x
relations:                   # liens « implique » transverses (par code)
  - de: feat-a
    vers: outil-x
---
:::
```

### `fishbone` — Ishikawa (causes)
```md
::: fishbone
---
probleme: Mon problème
branches:
  - nom: Méthode              # catégorie de causes
    causes:
      - nom: Cause 1
        enfants:             # sous-causes (optionnel)
          - nom: Sous-cause
---
:::
```

### `principe` — un principe TRIZ (dans `triz/<cause>.md`)
```md
::: principe
---
code: triz-segmentation      # DOIT commencer par `triz-`
titre: Segmentation
---
Application concrète du principe.
:::
```

### `action` — une action How-How (dans `how-how/<principe>.md`)
```md
::: action
---
code: mon-action
retenu: true                 # feuille actionnable → devient une tâche
titre: Faire X
impact: 4                    # 0..5 — décidé par Claude
effort: 2                    # 0..5
priorite: 5                  # décidée par Claude (jamais calculée par Solo)
---
Description de l'action.
:::
```

### `relations` — arêtes transverses (par `code`)
```md
::: relations
---
liens:
  - de: triz-segmentation
    type: resout             # resout | regroupe | depend_de
    vers: mon-action
  - de: action-b
    type: depend_de          # action-b dépend de mon-action
    vers: mon-action
---
:::
```

- `resout` : un principe TRIZ résout une action (→ Ishikawa augmenté, Sitemap).
- `depend_de` : une action dépend d'une autre (→ graphe + ordre d'exécution).
- `regroupe` : un cluster regroupe des actions.

**Dérivations Solo** (déterministes, aucun jugement) : Ishikawa augmenté (TRIZ en
arêtes, How-How reliés en sous-branches), Sitemap (thèmes), matrice Impact×Effort,
graphe de tâches + tri topologique. Solo **ne décide rien** : il ingère, relie,
affiche, ordonne.
