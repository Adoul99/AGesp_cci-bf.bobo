Orchestre la **chaîne d'idéation complète** pour une idée : de l'exploration des
features jusqu'aux tâches priorisées, dans `.solo/idee/`. Étape par étape, avec
**validation humaine entre chaque** (ne pas tout enchaîner en silence).

L'argument `$ARGUMENTS` est le **nom de l'idéation** (slug court et stable, ex.
`fasogame-mvp`). **Plusieurs idéations indépendantes** coexistent dans un projet ;
chacune est nommée et datée pour l'historisation / le rollback.

Règles d'idéation (à propager à CHAQUE sous-étape) :
- **Front-matter obligatoire** sur tout fichier `.solo/idee/…` : `ideation: <nom>`
  (l'argument) + `date: <AAAA-MM-JJ du jour>`. C'est ce qui regroupe/filtre les
  éléments dans Solo (les fichiers restent à plat, jamais de sous-dossier daté).
- **Codes/`cle` préfixés par l'idéation** (ex. `fasogame-…`) → uniques dans le
  projet (la dédup et la résolution de relations sont globales au projet).
- **Contextualise** l'analyse avec le titre + la description du projet (déjà dans
  `CLAUDE.md`) et, si fourni, le **système de référence** à analyser.

La chaîne (chaque étape a sa skill dédiée que tu peux aussi lancer seule) :

1. **Mind map** (`/solo-mindmap`) — explore les features (feature/existant/outil)
   dans `mindmap/<sujet>.md` (**plusieurs mindmaps** possibles : general/technique/
   fonctionnel/design). Trie : retenir / abandonner / **problématique** → Ishikawa.
2. **Ishikawa** (`/solo-ishikawa`) — pour chaque feature problématique, décompose
   les causes (branches → causes → sous-causes). Causes à fort impact +
   contradiction → TRIZ.
3. **TRIZ** (`/solo-triz`) — contradiction + principes inventifs (`code: triz-…`).
   Relations `resout` vers les actions How-How.
4. **How-How** (`/solo-howhow`) — cascade « comment ? » → actions `retenu: true`.
   Relations `depend_de` entre actions.
5. **Domaines** (`/solo-domaines`) — découpe en **thèmes/sous-thèmes métier (DDD,
   MECE)** dans `domaines/<ideation>.md` (WBS).
6. **Priorisation** — matrice **Impact × Effort des TÂCHES** (quick wins d'abord) ;
   `impact`/`effort` sont sur les `::: action` (`/solo-howhow`). Pas de commande
   dédiée ; l'onglet affiche les tâches et **filtre par thème**. Décidé, pas calculé.
7. **Workflow** (`/solo-workflow`) — un **swimlane d'exécution par thème**
   (`workflow/<theme>.md`), sélectionnable dans l'en-tête de l'onglet.
8. **Technologie** (`/solo-techno`) — archi logicielle finale + choix
   technologiques + dépendances dans `techno/<ideation>.md`. Pont vers la création.

Principes non négociables :
- **Tu génères et décides tout** (tri, causes, principes retenus, priorités,
  dépendances). **Solo ne déduit rien** : il ingère, relie et affiche.
- Respecte le format `.claude/design/knowledge-syntax.md` et les `code` stables
  (les relations les référencent).
- **Confirme entre chaque étape** avant de passer à la suivante (validation
  humaine). N'invente pas : base-toi sur l'idée réelle.

Ne touche qu'à `.solo/idee/`. Les onglets de la fenêtre Idée s'alimentent au
fur et à mesure (après « Synchroniser »).

Nom de l'idéation (+ idée / système de référence à explorer) : $ARGUMENTS
