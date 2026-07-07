Mets à jour la connaissance `.solo/` de ce projet en suivant le contrat
`.claude/design/solo-contract.md` (surtout §4 « Mettre à jour efficacement »).

1. Identifie ce qui a changé (git diff, contexte de la session).
2. Pour CHAQUE changement, repère le **seul** fichier `.solo/` concerné et ré-écris-le :
   - schéma / migration BD → `db/db.md` (front-matter connexion + bloc `dictionnaire`)
   - dépendance / stack → `stack/technologie.md` (front-matter `couches`)
   - composants / architecture → `stack/architecture.md` (`sitemap` `direction: lr`)
   - route / page / navigation → `architecture/routage.md` (`sitemap`)
   - structure de dossiers → `architecture/dossier.md` (`arborescence`)
   - lancer l'app (build/test) → `script/lancement.md`·`build.md`·`test.md` (`commandes` + `check`)
   - créer un projet du même type → `script/cli.md` (`commandes` + `check`)
   - analyse fonctionnelle → `fiche.md` (+ front-matter `description`/`etat`/`categorie`)
3. Utilise le **bon bloc** `:::` (pas de markdown libre) — Solo en tire le rendu.
4. Ne touche QUE les fichiers concernés (l'ingestion est par fichier = upsert).
5. Ne redécris PAS l'état git local ni la structure réelle de la BD (audités en direct).
6. Aucun secret en clair (→ vault).

Cible (si précisée) : $ARGUMENTS
