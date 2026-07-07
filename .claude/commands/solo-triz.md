Formule la **contradiction TRIZ** d'une cause (issue de l'Ishikawa) et ses
principes inventifs. Écris/mets à jour `.solo/idee/triz/<cause>.md` (un fichier =
une cause). Étape 3 de la chaîne d'idéation.

Objectif : pour une cause donnée, exprimer la contradiction (deux paramètres
opposés : améliorer X dégrade Y) et lister les **principes inventifs** qui la
résolvent. Chaque principe reliera une solution How-How.

Front-matter OBLIGATOIRE (identifie l'idéation) :
```yaml
---
ideation: <slug-idéation>
date: AAAA-MM-JJ
---
```
Nom de fichier et `code` internes **préfixés par l'idéation** (unicité globale).

Structure :
- `::: titre` puis `::: analyse` (la contradiction en clair).
- **Pas de `::: tableau` par défaut.** N'en ajoute un (paramètre à améliorer |
  paramètre dégradé) que si la contradiction croise **plusieurs** paramètres et
  qu'un tableau clarifie vraiment — sinon exprime-la en prose dans `::: analyse`.
- **Un bloc `::: swimlane`** (même design que l'onglet Test). **Champs exacts** :
  chaque étape porte `couloir`, **`nom`** (le libellé — ce champ s'appelle `nom`,
  **pas** `titre`), et `type` ∈ `debut`/`action`/`decision`/`fin`. **Pas de champ
  `ordre`** : l'ordre est celui de la liste. Explication courte → `detail: "…"`.
  Exemple à recopier tel quel (adapte les libellés) :
  ```
  ::: swimlane
  ---
  titre: "Contradiction → principes → résolution"
  couloirs: [Besoin, Contradiction, Principe TRIZ, Résolution]
  etapes:
    - { couloir: Besoin, nom: "…", type: debut }
    - { couloir: Contradiction, nom: "…", type: decision, detail: "améliorer X dégrade Y" }
    - { couloir: Principe TRIZ, nom: "Segmentation", type: action, detail: "…" }
    - { couloir: Résolution, nom: "…", type: fin, detail: "contradiction levée" }
  ---
  :::
  ```
- **Un bloc `::: principe`** par principe inventif, en props :
  `{ code: triz-<slug>, titre }` + corps (application concrète). Le `code`
  **doit** commencer par `triz-` (l'Ishikawa augmenté en dépend).
- **Un bloc `::: relations`** : `liens: [{ de: triz-<slug>, type: resout,
  vers: <code-action-how-how> }]` — chaque principe `resout` une ou plusieurs
  actions du How-How (par leur `code`).

**Règle** (à toi de trancher) : liste **tous** les principes pertinents ; retiens
ceux qui **lèvent réellement** la contradiction dans le contexte (pas juste en
théorie) via la relation `resout`.

Ne touche qu'à `.solo/idee/triz/`. Visible dans l'onglet **TRIZ** ; les principes
alimentent l'onglet **Ishikawa augmenté**.

Cause (nom du fichier) : $ARGUMENTS
