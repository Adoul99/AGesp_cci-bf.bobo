Explore une **idée** en features et écris/mets à jour
`.solo/idee/mindmap/<sujet>.md` (format `.claude/design/knowledge-syntax.md`).
Étape 1 de la chaîne d'idéation. **Plusieurs mindmaps par idéation** sont
possibles (un général, un technique, un fonctionnel, un design…).

Contexte d'analyse : une idéation part souvent d'un **système de référence**
existant (un concurrent, un produit à reproduire/dépasser). Analyse-le en
profondeur puis **contextualise** avec le titre + la description du projet (déjà
dans `CLAUDE.md`) : quelles fonctionnalités reprendre, lesquelles écarter pour
notre marché/contexte. Sans obligation, il est bon de faire d'abord un mindmap
**général** puis, si utile, des mindmaps ciblés (**technique**, **fonctionnel**,
**design**) selon la volonté de l'utilisateur.

Nom de fichier (`<sujet>`) : un slug parlant du mindmap — `general`, `technique`,
`fonctionnel`, `design`, ou le nom du système de référence analysé.

Front-matter OBLIGATOIRE (identifie l'idéation) :
```yaml
---
ideation: <slug-idéation>   # le nom de l'idéation en cours (argument de /solo-ideation)
date: AAAA-MM-JJ            # date du jour, en front-matter (jamais dans le nom de fichier)
sujet: <general|technique|fonctionnel|design|…>
---
```

Structure du corps :
- `::: titre` (nom du mindmap : « Mind map — <système/aspect> »).
- **`::: analyse`** = la DESCRIPTION riche affichée au-dessus du diagramme (elle
  est repliable dans Solo). Rédige-la comme une vraie synthèse d'analyse :
  - le **périmètre exploré** (le système de référence, ses grands domaines) ;
  - la **règle de tri** appliquée (angle de notre projet) : **retenu** = utile ET
    faisable ; **abandonné** = hors périmètre / coût > valeur ; **problématique** =
    utile mais faisabilité incertaine → part en Ishikawa ;
  - un **regroupement des tâches / fonctionnalités par domaine** (retenus,
    problématiques → Ishikawa, abandonnés), avec la justification ;
  - la **source** de l'analyse et la **prochaine étape** suggérée (`/solo-ishikawa`
    sur la feature problématique phare).
- **Un bloc `::: mindmap`** avec, en props YAML :
  - `centre` : le nom du système/idée cartographié.
  - `branches` : arbre récursif de nœuds `{ nom, type, tri?, code, icone?, logo?,
    description?, capacites?, interets?, blocages?, enfants? }` où :
    - `type` ∈ `feature` | `existant` | `outil` (couleur/forme distinctes),
    - `tri` ∈ `retenu` | `abandonne` | `probleme` — le résultat de ta règle de
      tri. **`probleme` colore la tuile en ROUGE** (feature problématique → part
      en Ishikawa) ; mets-le sur les features à faisabilité incertaine.
    - `code` : identifiant stable **préfixé par l'idéation** (unicité globale dans
      le projet, ex. `fasogame-catalogue`) — référencé par les relations,
    - `logo` : **juste le nom** d'une techno (`logo: laravel`) → Solo résout
      l'image réelle si elle existe (sinon rien) ; `icone` = un emoji de repli,
    - `capacites` / `interets` / `blocages` : listes (détail au clic sur la tuile).
  - `relations` : liens « implique » **transverses** `{ de, vers }` (par `code`).

Ne touche qu'à `.solo/idee/mindmap/`. Visible dans l'onglet **Mind map** (un
sélecteur liste les mindmaps de l'idéation courante).

Idée / système de référence / aspect : $ARGUMENTS
