Décris le **workflow d'exécution** des tâches d'un **thème** (issu des Domaines) :
dans quel ordre et par quels acteurs/systèmes on réalise concrètement les tâches.
Écris/mets à jour `.solo/idee/workflow/<theme>.md` (un fichier par thème). Étape 8
de la chaîne d'idéation.

Objectif : pour un thème donné, un **swimlane (BPMN / couloirs)** montrant le
**parcours réel d'exécution** : préparation, étapes, points de décision,
validation, livraison. C'est la seule vue de l'onglet Workflow.

Front-matter OBLIGATOIRE (identifie l'idéation) :
```yaml
---
ideation: <slug-idéation>
date: AAAA-MM-JJ
---
```
Nom de fichier et `code` internes **préfixés par l'idéation** (unicité globale).

Structure du fichier :
- `::: titre` (le thème) puis `::: analyse` (pré-requis, périmètre).
- **Un bloc `::: swimlane`** (EXACTEMENT comme l'onglet Test) :
  `couloirs` = acteurs/systèmes (ex : Dev, CI, Infra, Revue…) ; `etapes` = suite
  ordonnée. Chaque étape :
  `- { couloir: …, nom: "…", type: …, detail: "…", description: "…" }`.
  - `nom` = libellé court (**pas `titre`**) ; `type` ∈
    `debut`/`action`/`decision`/`fin` ; **pas de champ `ordre`** (ordre = la liste).
  - **`description`** = le détail riche affiché **au clic** (markdown : ce qu'on
    fait, commande, critère de passage). C'est là que va le détail pour l'humain.

Le nom de fichier doit **matcher le `code`/slug du thème** de `domaines.md`
(ex. thème `th-paiement` → `workflow/paiement.md`).

Ne touche qu'à `.solo/idee/workflow/`. Visible dans l'onglet **Workflow** (un
sélecteur de thème dans l'en-tête).

Thème (nom du fichier) : $ARGUMENTS
