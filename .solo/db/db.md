---
base: agesp
host: 127.0.0.1
port: 3306
driver: sqlite
---

# Base de données — AGesP

Configuration par défaut : **SQLite** (`database/database.sqlite`) en développement.
Production : **MySQL** via variables d'environnement (`DB_HOST`, `DB_USER`, `DB_PASSWORD`).

::: dictionnaire
---
colonnes:
  # Users & Auth
  - { table: users, colonne: id, type: "bigint", cle: PRI }
  - { table: users, colonne: name, type: "varchar(255)", cle: "" }
  - { table: users, colonne: prenom, type: "varchar(100)", cle: "" }
  - { table: users, colonne: email, type: "varchar(255)", cle: UNI }
  - { table: users, colonne: telephone, type: "varchar(20)", cle: UNI }
  - { table: users, colonne: password, type: "varchar(255)", cle: "" }
  - { table: users, colonne: role, type: "varchar(30)", cle: "" }
  
  # Candidats
  - { table: candidats, colonne: id, type: "bigint", cle: PRI }
  - { table: candidats, colonne: nom, type: "varchar(255)", cle: "" }
  - { table: candidats, colonne: prenom, type: "varchar(255)", cle: "" }
  - { table: candidats, colonne: dateNaissance, type: "date", cle: "" }
  - { table: candidats, colonne: lieuNaissance, type: "varchar(255)", cle: "" }
  - { table: candidats, colonne: numeroPermisC, type: "varchar(255)", cle: "" }
  - { table: candidats, colonne: statut, type: "varchar(255)", cle: "" }
  
  # Dossiers
  - { table: dossiers, colonne: id, type: "bigint", cle: PRI }
  - { table: dossiers, colonne: nomDossier, type: "varchar(255)", cle: "" }
  - { table: dossiers, colonne: description, type: "text", cle: "" }
  - { table: dossiers, colonne: dateDepot, type: "date", cle: "" }
  - { table: dossiers, colonne: statutDossier, type: "enum", cle: "" }
  - { table: dossiers, colonne: candidat_id, type: "bigint", cle: FK }
  
  # Inscriptions
  - { table: inscriptions, colonne: id, type: "bigint", cle: PRI }
  - { table: inscriptions, colonne: dateInscription, type: "date", cle: "" }
  - { table: inscriptions, colonne: statut, type: "varchar(255)", cle: "" }
  - { table: inscriptions, colonne: candidat_id, type: "bigint", cle: FK }
  - { table: inscriptions, colonne: categorie_permis_id, type: "bigint", cle: FK }
  
  # Formations
  - { table: formations, colonne: id, type: "bigint", cle: PRI }
  - { table: formations, colonne: nom, type: "varchar(255)", cle: "" }
  - { table: formations, colonne: description, type: "text", cle: "" }
  - { table: formations, colonne: duree, type: "int", cle: "" }
  
  # Évaluations & Examens
  - { table: evaluations, colonne: id, type: "bigint", cle: PRI }
  - { table: evaluations, colonne: note, type: "decimal(5,2)", cle: "" }
  - { table: evaluations, colonne: statut, type: "enum", cle: "" }
  - { table: evaluations, colonne: candidat_id, type: "bigint", cle: FK }
  
  - { table: examens, colonne: id, type: "bigint", cle: PRI }
  - { table: examens, colonne: nom, type: "varchar(255)", cle: "" }
  - { table: examens, colonne: dateExamen, type: "date", cle: "" }
  - { table: examens, colonne: statut, type: "enum", cle: "" }
  
  # Ressources
  - { table: moniteurs, colonne: id, type: "bigint", cle: PRI }
  - { table: moniteurs, colonne: nom, type: "varchar(255)", cle: "" }
  - { table: moniteurs, colonne: email, type: "varchar(255)", cle: UNI }
  - { table: moniteurs, colonne: user_id, type: "bigint", cle: FK }
  
  - { table: vehicules, colonne: id, type: "bigint", cle: PRI }
  - { table: vehicules, colonne: marque, type: "varchar(255)", cle: "" }
  - { table: vehicules, colonne: immatriculation, type: "varchar(255)", cle: UNI }
  
  # Finances
  - { table: paiements, colonne: id, type: "bigint", cle: PRI }
  - { table: paiements, colonne: montant, type: "decimal(10,2)", cle: "" }
  - { table: paiements, colonne: statut, type: "varchar(255)", cle: "" }
  - { table: paiements, colonne: candidat_id, type: "bigint", cle: FK }
  
  - { table: recuses, colonne: id, type: "bigint", cle: PRI }
  - { table: recuses, colonne: numero, type: "varchar(255)", cle: UNI }
  - { table: recuses, colonne: paiement_id, type: "bigint", cle: FK }
---
:::

## Migrations

Total de **48 migrations** organisant :
- **Authentification** : users, password_reset_tokens, sessions, two-factor
- **Candidatures** : candidats, dossiers, inscriptions, groupes
- **Formations** : formations, session_formations, lieu_formations, type_sessions, programmations
- **Évaluation** : evaluations, examens, notes_evaluation, candidat_examen
- **Ressources** : moniteurs, vehicules, categorie_permis
- **Finances** : paiements, recuses
- **Divers** : attestations, jobs, cache
