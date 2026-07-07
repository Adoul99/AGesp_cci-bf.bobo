# Travailler avec Solo sur ce projet

Ce dossier `.claude/` est **généré et maintenu par Solo**. La source de vérité de la
connaissance du projet est le dossier **`.solo/`** à la racine.

## Règles

- La connaissance structurée se met à jour dans `.solo/` (un fichier = un type de
  connaissance, cf. l'arborescence `git/`, `db/`, `script/`, `architecture/`, `stack/`,
  `activite/`, `assets/`, et `fiche.md`). Solo ingère ces fichiers. Format complet
  (arborescence + blocs) : `.claude/design/solo-contract.md`.
- **Mise à jour efficiente** : l'ingestion est par fichier (ré-écrire un fichier le
  remplace). Ne touche que le(s) fichier(s) concerné(s) par ton changement, jamais
  tout `.solo/` ; un type = un fichier, pas de doublon (procédure §4 du contrat).
- **Ne redécris pas le réel audité en direct** : état git local et structure réelle
  de la BD sont lus automatiquement ; documente l'intention (dictionnaire, conventions).
- Ne stocke jamais de secret en clair (tokens, mots de passe) : ils vont au vault de Solo.
- Les fichiers `.svg` (graphes, diagrammes) sont référencés/stockés dans leurs dossiers
  respectifs (`architecture/`, `stack/`, `git/`, `assets/`).
