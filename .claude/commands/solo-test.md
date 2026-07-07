Transforme le **dernier scénario de test / workflow** discuté (test E2E, parcours
fonctionnel, intégration…) en connaissance Solo : écris/mets à jour
`.solo/test/<nom-scenario>.md` (un fichier = un scénario), au format de
`.claude/design/solo-contract.md`.

Structure du fichier :
- `::: titre` (nom du scénario) puis `::: analyse` (objectif, pré-requis, oracle).
- **Un bloc `::: swimlane`** décrivant le **workflow complet** en couloirs (BPMN) :
  - `couloirs` : les acteurs/systèmes (ex : Utilisateur, Frontend, API, BD…),
  - `etapes` : la **suite ordonnée** ; chaque étape `{couloir, nom, type, …}` :
    - `type` ∈ `debut` / `action` / `decision` / `test` (assertion) / `erreur` / `fin`,
    - `statut` : `ok` (passé) ou `echec` (échoué) → marquage clair sur l'étape,
    - `detail` (court, sous le nœud), `description` (markdown, au clic),
    - `attendu` / `obtenu` (pour une assertion), `trace` (traceback/logs au clic).
    **Détaille au maximum** au clic (cas d'échec : mets le `trace`).

Sois concret : décris le vrai parcours (entrées, validations, assertions, cas
d'erreur). Base-toi sur les tests réels du dépôt si présents ; n'invente pas de
comportement. Ne touche qu'à `.solo/test/`. Visible dans Solo après synchro de
l'onglet Tests.

Scénario / périmètre (optionnel) : $ARGUMENTS
