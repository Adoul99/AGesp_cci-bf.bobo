Décline un **principe TRIZ** en actions concrètes (cascade How-How) et
écris/mets à jour `.solo/idee/how-how/<principe>.md` (un fichier = un principe).
Étape 4 de la chaîne d'idéation.

Objectif : partir d'un principe et répondre « comment concrètement ? » sur
plusieurs niveaux, jusqu'à des **actions exécutables** (une commande, un fichier,
une PR). Ces actions retenues deviendront des tâches.

Front-matter OBLIGATOIRE (identifie l'idéation) :
```yaml
---
ideation: <slug-idéation>
date: AAAA-MM-JJ
---
```
Nom de fichier et `code` internes **préfixés par l'idéation** (unicité globale).

Structure :
- `::: titre` puis `::: analyse`.
- **Un bloc `::: swimlane`** (EXACTEMENT comme l'onglet Test) : couloirs
  `[Principe, Comment, Action, Résultat]`, la cascade en étapes. Chaque étape :
  `- { couloir: …, nom: "…", type: action, detail: "…", description: "…" }`.
  - `nom` = libellé court (pas `titre`) ; `type` ∈ `debut`/`action`/`decision`/`fin` ;
    **pas de champ `ordre`** (l'ordre = celui de la liste).
  - **`detail`** = une phrase courte affichée sous le nœud.
  - **`description`** = le **détail riche affiché AU CLIC** sur l'étape (comme en
    Test) : objectif, règles métier, cas limites, critères d'acceptation. Écris-le
    en **markdown** dans la valeur (guillemets ; `\n\n` pour les paragraphes,
    `- ` pour des puces). C'est LÀ que va tout le détail destiné à l'humain — pas
    dans un bloc séparé.
- **Un bloc `::: action`** par feuille actionnable — sert la **priorisation et le
  graphe**, pas la description longue : props `{ code: <slug>, retenu: true,
  titre, impact: 0..5, effort: 0..5, priorite }`. `retenu: true` = actionnable ;
  `impact`/`effort`/`priorite` alimentent la matrice. Le `titre` doit **matcher le
  `nom`** de l'étape correspondante du swimlane. Corps = résumé bref (le détail
  complet vit dans la `description` de l'étape).
- **Un bloc `::: relations`** : dépendances entre actions `{ de: <code>, type:
  depend_de, vers: <code> }` (l'action `de` dépend de l'action `vers`).

**Règle** (à toi de trancher) : descends jusqu'à une action **exécutable en une
tâche** ; marque `retenu: true` sur les feuilles réalisables et arrête-toi là.
Décide **toi** impact / effort / priorité (Solo ne calcule aucun score).

Ne touche qu'à `.solo/idee/how-how/`. Alimente les onglets **How-How**,
**Sitemap**, **Priorités** et **Tâches**.

Principe (nom du fichier) : $ARGUMENTS
