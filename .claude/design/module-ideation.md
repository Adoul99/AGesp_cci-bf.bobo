# Module Idéation — design

Outille la phase **pré-projet** : avant qu'une idée devienne un projet, elle
traverse une chaîne méthodologique (mind map → Ishikawa → TRIZ → How-How →
clustering → priorisation) qui la structure jusqu'à des **tâches concrètes**.

## Principe (non négociable) : Claude génère, Solo lit

**Solo n'embarque pas d'IA et ne déduit rien** (cf. CLAUDE.md, décisions #9/#11).
Tout le contenu intelligent — les causes de l'Ishikawa, les principes TRIZ, les
actions du How-How, **quelles actions retenir, quelles tâches en dériver et leurs
dépendances** — est produit par **Claude Code**, dans le projet, écrit en
fichiers `.solo/idee/`.

Solo ne fait que : **ingérer** (pipeline existant `.solo/ → element_connaissance`,
cf. [knowledge-syntax.md](knowledge-syntax.md) et [solo-contract.md](solo-contract.md)),
**stocker**, **résoudre les relations transverses**, **afficher** (vues filtrées
par `type_code`). Aucune dérivation, aucun calcul de score, aucune décision.

```
Claude Code (dans le projet)              Solo (moteur déterministe)
────────────────────────────             ──────────────────────────
explore : mindmap → ishikawa             ingère .solo/idee/*  (pipeline existant)
→ triz → how-how → clusters         ───► element_connaissance (types idee-*)
DÉCIDE les tâches + dépendances          résout les relations (code → id)
écrit .solo/idee/*.md                    affiche (vues filtrées par type)
                                         ← RIEN à déduire/calculer/dériver
```

## Un seul type de donnée : l'élément typé en arbre

Un "diagramme" (mind map, fishbone…) n'est **jamais stocké tel quel** : c'est une
**vue filtrée** sur `element_connaissance`, reconstruite à l'affichage à partir du
`type_code` et des liens (`parent_id` + `element_relation`). Pas de table
`mindmap`/`ishikawa` : les 6 types sont du vocabulaire `type_connaissance`, créés
sans migration (`upsert_type`).

## Contrat `.solo/idee/` — chemins → types

Le chemin porte le type (règle `type_depuis_chemin`). Les fichiers dont le nom est
une donnée variable sont des **collections** (à ajouter à `COLLECTIONS` dans
`service/connaissance.rs`) : le nom de fichier devient la `cle`.

| Chemin `.solo/idee/` | `type_code` | collection ? |
|---|---|---|
| `mindmap/<sujet>.md` | `idee-mindmap` | **oui** (cle = `<sujet>`) |
| `ishikawa/<probleme>.md` | `idee-ishikawa` | **oui** (cle = `<probleme>`) |
| `triz/<cause>.md` | `idee-triz` | **oui** (cle = `<cause>`) |
| `how-how/<principe>.md` | `idee-how-how` | **oui** (cle = `<principe>`) |
| `domaines/<ideation>.md` | `idee-domaines` | **oui** (cle = `<ideation>`) |
| `workflow/<theme>.md` | `idee-workflow` | **oui** (cle = `<theme>`) |
| `techno/<ideation>.md` | `idee-techno` | **oui** (cle = `<ideation>`) |

## Idéations nommées et datées

Un projet peut mener **plusieurs idéations indépendantes**, chacune parcourant
toute la chaîne. Le rattachement d'un fichier à son idéation se fait par
**front-matter** (`ideation: <nom>` + `date: AAAA-MM-JJ`), **pas** par le chemin :
les fichiers restent à plat sous les dossiers de collection ci-dessus (la
dérivation de type par chemin est plate sur un niveau, un sous-dossier daté la
casserait). Solo dérive la liste des idéations des props `ideation`/`date` des
racines `idee-*`, propose une **modal** de sélection (filtrable par date) et
**filtre tous les onglets** sur l'idéation choisie (défaut = la plus récente).
Une même idéation peut porter **plusieurs mindmaps** (`mindmap/general.md`,
`technique.md`…), listés par le sélecteur d'en-tête. Les `code`/`cle` sont
**préfixés par l'idéation** (unicité globale : la dédup et la résolution de
relations sont globales au projet). Les fichiers sans `ideation` restent visibles
quand aucune idéation n'est filtrée.

## Les étapes (imbrication = `parent_id`)

1. **Mind map** — une piste par nœud, pour cerner *quel* problème creuser.
2. **Ishikawa** — problème → branches (catégories) → causes.
3. **TRIZ** — pour une cause : une contradiction (2 paramètres opposés) → un ou
   plusieurs principes inventifs.
4. **How-How** — pour un principe : cascade « comment concrètement ? » sur
   plusieurs niveaux ; seules les **feuilles marquées `retenu: true`** sont des
   actions actionnables.
5. **Domaines** — découpage en **thèmes / sous-thèmes métier (DDD / bounded
   contexts)**, en **arbre** (WBS), **MECE au niveau des feuilles** (chaque tâche
   dans une seule feuille ; toutes les tâches retenues rangées ; un thème à
   sous-thèmes ne porte pas de tâches directes). Décidé par Claude dans
   `idee/domaines/<ideation>.md` : des blocs `::: theme { code, titre, parent?, taches?:
   [...] }` (hiérarchie via `parent`, `taches` sur les feuilles) + corps =
   description. Solo reconstruit l'arbre, le **représente en WBS hiérarchique**,
   affiche les tâches **au clic**, et vérifie MECE/structure. Remplace l'ancien
   « Cluster » (`regroupe`).
6. **Priorité** — matrice **Impact × Effort des TÂCHES** : les props `impact`/
   `effort` (0..5, décidées par Claude) sont sur les blocs `::: action` retenus.
   L'onglet **filtre par thème** (via l'appartenance tâche→thème de `domaines.md` ;
   un thème parent agrège les tâches de ses sous-thèmes). Solo place, ne calcule pas.
7. **Workflow** — un **swimlane d'exécution par thème** (`workflow/<theme>.md`,
   collection). Décrit *comment* on exécute les tâches du thème (acteurs, ordre,
   décisions). Seule vue de l'onglet (sélecteur de thème dans l'en-tête).
8. **Technologie** — `techno/<ideation>.md` : architecture logicielle finale (bloc `sitemap`/
   `diagramme`), choix technologiques (`couches` à logos) et dépendances
   (`tableau`). Pont vers la création réelle du projet.

Exemple (`how-how/perf-lente.md`) :

```md
---
principe: mise-en-cache
---

::: niveau
---
code: cache
---
Mettre en cache les requêtes lourdes

::: niveau
---
code: cache-redis
retenu: true
priorite: 4          # décidé par Claude, jamais calculé par Solo
---
Installer Redis et cacher les requêtes DB
:::
:::
```

## Relations transverses — `element_relation` (migration 0006)

L'arbre `parent_id` ne peut pas exprimer un lien entre deux branches. Les
relations **transverses** vivent dans `element_relation(source_id, cible_id,
type)` avec `type ∈ {resout, regroupe, depend_de}` :
- `resout` : un principe TRIZ → une cause qu'il adresse (n-n).
- `regroupe` : un cluster → une action qu'il contient (n-n).
- `depend_de` : une action/tâche → une autre dont elle dépend (inter-branches).

Claude écrit ces liens **par `code`** (bloc `relations`), Solo les résout
(`code → id`) à l'ingestion via `resoudre_relations`. Solo ne crée aucune
relation de lui-même.

```md
::: relations
---
liens:
  - de: cache-redis          # element_connaissance.cle (source)
    type: depend_de
    vers: install-docker     # element_connaissance.cle (cible)
  - de: principe-segmentation
    type: resout
    vers: perf-lente
---
:::
```

## Les tâches : de la connaissance, pas une table à part

Les **tâches sont les actions retenues** du How-How (blocs `::: action`,
`retenu: true`, avec `impact`/`effort`). Pas de fichier `taches.md` séparé, pas de
table `tache` remplie par ce module, pas de `deriver_taches` : Solo ingère ces
`::: action` en `element_connaissance` comme le reste. Elles apparaissent dans
l'onglet **Priorités** (matrice Impact × Effort, filtrable par thème) ; leur
regroupement en thèmes vit dans `domaines.md` (relation d'appartenance via
`taches: [...]`).

## Ce que ce module ne fait pas (côté Solo)

- ❌ Pas de génération de contenu (causes, principes, actions) — c'est Claude.
- ❌ Pas de dérivation actions → tâches — c'est Claude qui décide et écrit.
- ❌ Pas de calcul de priorité/score — Claude écrit la valeur finale.
- ❌ Pas de relation déduite — Solo résout uniquement celles écrites par Claude.

## Périmètre d'implémentation (côté Solo)

| Pièce | Nature |
|---|---|
| Migration `0006_element_relation.sql` | ✅ fait |
| +3 collections (`idee-ishikawa`/`triz`/`how-how`) dans `COLLECTIONS` | 1 ligne |
| `resoudre_relations` (bloc `relations` : code → id, remplit `element_relation`) | Rust |
| Rendu des 6 vues (piloté par `type_code`) | React |
