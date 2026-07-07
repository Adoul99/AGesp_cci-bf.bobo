Transforme le **dernier audit** que tu as produit dans cette conversation (revue
de sécurité, fiabilité, fonctionnelle, code-review, perf…) en connaissance Solo :
écris un **nouveau** fichier `.solo/audit/<AAAA-MM-JJ_HHMM>.md` (**horodaté** :
date **+ heure**, que des chiffres — ex. `2026-06-29_1430.md`) pour ne **pas
écraser** un autre audit du même jour, au format de `.claude/design/solo-contract.md`.

Structure du fichier :
- `::: titre` (date/thème) puis `::: analyse` (synthèse courte).
- **Un bloc `::: treemap` par dimension** auditée (Sécurité, Fiabilité,
  Fonctionnel…). Plusieurs dimensions = plusieurs treemaps.

Pour CHAQUE tuile (`noeuds`), sois précis ET lisible d'un coup d'œil :
- `nom`, `valeur` (gravité/effort → la **surface** de la tuile),
- `severite` : `critique` / `eleve` / `moyen` / `faible` / `info` (→ couleur),
- `icone` : un emoji simple (évite les emojis exotiques mal rendus sous Windows),
- `resume` : **le problème en une phrase courte** (s'affiche sur la tuile),
- `description` (markdown — **détaille au maximum** ; tu peux mettre des blocs de
  code ```` ``` ```` : traceback, extrait fautif, données utilisées),
- `items` (findings, markdown — listes OK),
- `recommandation` (markdown — explication + correctif, code possible),
- `trace` (optionnel) : traceback / logs / sortie brute, rendu en bloc de code.

Règles : base-toi sur les **vraies conclusions** de l'audit (n'invente rien) ;
ne touche qu'à `.solo/audit/` ; aucun secret en clair.

Focus / périmètre (optionnel) : $ARGUMENTS
