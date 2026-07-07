Renseigne les **identifiants du projet** dans `.solo/secrets.md` (front-matter
`secrets: [{cle, libelle, valeur}]`).

- Détecte les secrets réellement nécessaires : connexion **BD** (mot de passe),
  **token git** distant, clés d'API/services externes… (inspecte `.env`, la
  config, la connaissance `.solo/db/` et `.solo/git/`).
- Mets une `cle` en MAJUSCULES (ex : `DB_PASSWORD`) + un `libelle` lisible.
- Ne mets une `valeur` que si tu la connais **de source sûre** (jamais inventée) ;
  sinon laisse `valeur: ""` (l'utilisateur la remplira dans le Coffre-fort).

À l'ingestion, Solo **chiffre** chaque valeur non vide dans son **vault** (keyring
OS + AES-256-GCM) puis **efface** la valeur du fichier — donc tu peux y écrire les
vraies valeurs sans qu'elles restent en clair. Ne mets **pas** ces mêmes secrets
dans d'autres fichiers `.solo/` (ils y resteraient en clair).

$ARGUMENTS
