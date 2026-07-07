Analyse un **problème** (une feature problématique repérée en mind map) et
écris/mets à jour `.solo/idee/ishikawa/<probleme>.md` (un fichier = un problème).
Étape 2 de la chaîne d'idéation.

Objectif : décomposer les **causes** du problème par catégories (méthode
Ishikawa / arête de poisson), jusqu'aux sous-causes.

Front-matter OBLIGATOIRE (identifie l'idéation) :
```yaml
---
ideation: <slug-idéation>
date: AAAA-MM-JJ
---
```
Nom de fichier et `code` internes **préfixés par l'idéation** (unicité globale).

Structure :
- `::: titre` puis `::: analyse` (le problème creusé, d'où il vient).
- **Un bloc `::: fishbone`** avec, en props YAML :
  - `probleme` : la tête du poisson (le problème).
  - `branches` : `[{ nom, causes: [{ nom, enfants?: [{ nom }] }] }]`
    - `branches` = catégories de causes (ex : Méthode, Outils, Données, Humain),
    - `causes` = causes de chaque catégorie,
    - `enfants` = sous-causes (une arête plus fine).

**Règle** (à toi de trancher) : on passe en **TRIZ** les causes à **fort impact**
qui cachent une **contradiction** (améliorer X dégrade Y). Le nom de la cause qui
part en TRIZ doit correspondre au nom du fichier `triz/<cause>.md`.

Ne touche qu'à `.solo/idee/ishikawa/`. Visible dans l'onglet **Ishikawa**.

Problème (nom du fichier) : $ARGUMENTS
