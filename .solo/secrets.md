---
secrets:
  - { cle: DB_PASSWORD, libelle: "Mot de passe base de données", valeur: "" }
  - { cle: GIT_TOKEN, libelle: "Token du dépôt distant", valeur: "" }
---

# Secrets du projet

Déclare ici les **identifiants** du projet. À l'**ingestion**, Solo **chiffre**
chaque `valeur` non vide dans son **vault** (keyring OS + AES-256-GCM), puis
**efface la valeur de ce fichier** — les secrets ne restent jamais en clair.

Renseigne une `valeur`, puis « Rafraîchir / Synchroniser » dans Solo. Les secrets
apparaissent ensuite dans le **Coffre-fort** (onglet Paramètres).
