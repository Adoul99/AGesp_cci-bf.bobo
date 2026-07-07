---
projet: agesp
source: claude
version: 1
categorie: laravel
etat: en-cours
description: Système de gestion d'examens et formations (AGesP - Agence pour la Gestion des Examens et Permis)
---

# Analyse fonctionnelle — AGesP

Application de gestion complète pour l'examen et la formation des permis de conduire, construite avec Laravel 13, Livewire 4 et Flux.

## Objectifs
- Gérer les candidats, les formations et les sessions de formation
- Suivre les évaluations, examens et paiements
- Administrer les moniteurs, véhicules et lieux de formation
- Générer des attestations et reçus
- Fournir une interface de gestion d'authentification (Fortify)

## Domaines métier
- **Candidatures** : Candidat, Dossier, Inscription, Groupe
- **Formations** : SessionFormation, Formation, LieuFormation, TypeSession, Programmation
- **Évaluation** : Examen, Evaluation, NoteEvaluation
- **Ressources** : Moniteur, Vehicule, CategoriePermis
- **Finances** : Paiement, Recus
- **Authentification** : User, Attestation, CodeVerification

## Technologies clés
- Backend : Laravel 13, Livewire 4, Fortify
- Frontend : Flux 2, Tailwind 4, Vite 8
- Base de données : SQLite (dev) / MySQL (prod)
- Test : PHPUnit 12, Faker
- Code Quality : Pint
