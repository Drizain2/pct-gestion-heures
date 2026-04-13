---
# **Plan Détaillé par Sprint — Application de Gestion des Heures Enseignants**
**Durée totale : 23 jours** (8 sprints)

---

## **📌 Informations Générales**
| **Élément**               | **Détails**                                                                 |
|---------------------------|-----------------------------------------------------------------------------|
| **Framework**             | Laravel 10 (PHP 8.2)                                                      |
| **Base de données**       | MySQL 8.0                                                                  |
| **Frontend**              | Blade + Tailwind CSS                                                       |
| **Outils complémentaires**| Laravel Breeze, Spatie Laravel Permission, DomPDF, Laravel Excel, Chart.js |
| **Durée par sprint**      | 2 à 3 jours (selon complexité)                                            |

---

## **🗓️ Calendrier Global**
**Durée totale : 23 jours**

| **Sprint**                          | **Durée (jours)** | **Dates**       | **Écrans Blade** | **Fonctionnalités Clés**                                                                 |
|-------------------------------------|-------------------|-----------------|------------------|-----------------------------------------------------------------------------------------|
| **Sprint 0** — Environnement        | 3                 | J1 à J3         | 3                | Installation Laravel, auth, rôles, Git, wireframes                                       |
| **Sprint 1** — Enseignants          | 3                 | J4 à J6         | 4                | CRUD enseignants, validation, filtres, seeders                                          |
| **Sprint 2** — Cours                | 3                 | J7 à J9         | 4                | CRUD cours, association enseignants, filtres dynamiques                                 |
| **Sprint 3** — Ressources pédagogiques | 3              | J10 à J12       | 3                | CRUD ressources, séquences, types de ressources                                          |
| **Sprint 4** — Activités & Calcul   | 3                 | J13 à J15       | 2                | Logique de calcul, enregistrement activités, récaps heures                               |
| **Sprint 5** — Tableaux de bord     | 3                 | J16 à J18       | 3                | Dashboards (Admin, Secrétaire, Enseignant), graphiques Chart.js                          |
| **Sprint 6** — États et exports     | 3                 | J19 à J21       | 1                | Génération PDF/Excel, exports                                                             |
| **Sprint 7** — Sécurité & Finalisation | 3              | J22 à J24       | 0                | Middleware, sauvegardes, tests unitaires, correction bugs                                |
| **Sprint 8** — Déploiement & Docs  | 2                 | J25 à J26       | 0                | Déploiement, documentation technique/utilisateur                                          |

---

## **🚀 Sprint 0 — Mise en place de l’environnement**
**Dates : J1 à J3**
**Objectif :** Préparer l’infrastructure technique et les outils de collaboration.

### **📋 Tâches détaillées**
| **Tâche**                                 | **Durée** | **Livrables**                                      | **Technologies/Outils**               |
|-------------------------------------------|-----------|----------------------------------------------------|---------------------------------------|
| Installation de Laravel 10                | 0.5 jour  | Projet Laravel initialisé                          | Composer, Laravel Installer          |
| Configuration du fichier `.env`           | 0.5 jour  | Fichier `.env` sécurisé                           | Editeur de texte                     |
| Création de la base de données MySQL      | 0.5 jour  | Base `gestion_heures` créée                       | MySQL Workbench, PHPMyAdmin           |
| Intégration de Laravel Breeze             | 0.5 jour  | Authentification fonctionnelle                   | Laravel Breeze, npm                  |
| Configuration des rôles avec Spatie       | 0.5 jour  | 3 rôles (Admin, Secrétaire, Enseignant)           | Spatie Laravel Permission             |
| Initialisation du dépôt Git               | 0.25 jour | Dépôt Git créé                                    | Git, GitHub/GitLab                    |
| Maquettage des interfaces (wireframes)    | 0.75 jour | 5 wireframes (login, dashboard, etc.)             | Figma, Adobe XD                       |

### **🖥️ Écrans Blade prévus**
1. **Page de login** (`auth/login.blade.php`)
2. **Page d’enregistrement** (`auth/register.blade.php`)
3. **Layout de base** (`layouts/app.blade.php`) : header, footer, sidebar dynamique selon le rôle.

### **🔧 Fonctionnalités attendues**
- Authentification sécurisée (login, enregistrement, mot de passe oublié).
- Gestion des rôles et permissions.
- Structure Git initialisée.

---

## **🏗️ Sprint 1 — Gestion des enseignants**
**Dates : J4 à J6**
**Objectif :** Créer un module CRUD complet pour les enseignants.

### **📋 Tâches détaillées**
| **Tâche**                                 | **Durée** | **Livrables**                                      | **Technologies/Outils**               |
|-------------------------------------------|-----------|----------------------------------------------------|---------------------------------------|
| Migration `enseignants`                   | 0.5 jour  | Table avec 10 champs                              | Artisan CLI                          |
| Model, Controller, Resource               | 0.5 jour  | CRUD fonctionnel                                  | Eloquent, Resource Controller         |
| Interface : Liste des enseignants         | 0.5 jour  | Tableau avec pagination, filtres, recherche       | Blade, Livewire (optionnel)           |
| Interface : Formulaire création/modif     | 0.5 jour  | Validation côté serveur et client                | Form Requests, Alpine.js              |
| Interface : Page de détail                 | 0.25 jour | Affichage complet + bouton de suppression         | Blade, SweetAlert                    |
| Validation des formulaires                | 0.25 jour | Règles de validation                               | Form Requests                        |
| Seeders pour données de test              | 0.5 jour  | 20 enseignants fictifs                            | Faker, Seeder                        |

### **🖥️ Écrans Blade prévus**
1. **Liste des enseignants** (`enseignants/index.blade.php`) :
   - Tableau avec colonnes : Nom, Prénom, Grade, Département, Actions.
   - Filtres : par département, grade.
   - Barre de recherche (nom/prénom/email).
2. **Création d’un enseignant** (`enseignants/create.blade.php`) :
   - Champs : nom, prénom, grade, statut, département, taux horaire, email, téléphone.
3. **Modification d’un enseignant** (`enseignants/edit.blade.php`) :
   - Même formulaire que la création, pré-rempli.
4. **Détail d’un enseignant** (`enseignants/show.blade.php`) :
   - Toutes les informations + bouton "Supprimer" avec confirmation.

### **🔧 Fonctionnalités attendues**
- CRUD complet (Création, Lecture, Mise à jour, Suppression).
- Validation des données (ex : email unique, téléphone valide).
- Filtrage et recherche en temps réel.
- Suppression avec confirmation (modal).

---

## **📚 Sprint 2 — Gestion des cours**
**Dates : J7 à J9**
**Objectif :** Gérer les cours et les associer aux enseignants.

### **📋 Tâches détaillées**
| **Tâche**                                 | **Durée** | **Livrables**                                      | **Technologies/Outils**               |
|-------------------------------------------|-----------|----------------------------------------------------|---------------------------------------|
| Migration `cours`                        | 0.5 jour  | Table avec 7 champs                               | Artisan CLI                          |
| Migration `cours_enseignant` (pivot)      | 0.25 jour | Relation many-to-many                             | Eloquent                            |
| Model, Controller, Resource               | 0.5 jour  | CRUD fonctionnel                                  | Resource Controller                 |
| Interface : Liste des cours               | 0.5 jour  | Tableau avec filtres dynamiques                   | Blade, Livewire                      |
| Interface : Formulaire création/modif     | 0.5 jour  | Sélection multiple des enseignants               | Select2, Alpine.js                   |
| Interface : Vue détail d’un cours         | 0.25 jour | Affichage des enseignants associés                | Blade                               |

### **🖥️ Écrans Blade prévus**
1. **Liste des cours** (`cours/index.blade.php`) :
   - Colonnes : Intitulé, Filière, Niveau, Semestre, Crédits, Actions.
   - Filtres : par niveau, filière, semestre.
2. **Création d’un cours** (`cours/create.blade.php`) :
   - Champs : intitulé, filière, niveau, semestre, nombre d’heures, crédits, enseignants (sélection multiple).
3. **Modification d’un cours** (`cours/edit.blade.php`).
4. **Détail d’un cours** (`cours/show.blade.php`) :
   - Informations du cours + liste des enseignants associés.

### **🔧 Fonctionnalités attendues**
- CRUD complet pour les cours.
- Association many-to-many avec les enseignants.
- Filtres dynamiques (niveau, filière, semestre).

---

## **🎓 Sprint 3 — Gestion des ressources pédagogiques**
**Dates : J10 à J12**
**Objectif :** Gérer les ressources numériques liées aux cours.

### **📋 Tâches détaillées**
| **Tâche**                                 | **Durée** | **Livrables**                                      | **Technologies/Outils**               |
|-------------------------------------------|-----------|----------------------------------------------------|---------------------------------------|
| Migration `ressources`                    | 0.5 jour  | Table avec 6 champs                               | Artisan CLI                          |
| Migration `sequences_pedagogiques`        | 0.25 jour | Table avec 3 champs                                | Artisan CLI                          |
| Model, Controller, Resource               | 0.5 jour  | CRUD fonctionnel                                  | Eloquent                            |
| Interface : Vue des séquences             | 0.5 jour  | Liste ordonnée des ressources                     | Blade, Sortable.js                   |
| Interface : Ajout/modif de ressources     | 0.75 jour | Formulaire dynamique selon le type               | Alpine.js, Dropzone (pour uploads)   |

### **🖥️ Écrans Blade prévus**
1. **Liste des séquences d’un cours** (`cours/sequences.blade.php`) :
   - Affichage des séquences sous forme de liste ordonnable.
2. **Création/modification d’une ressource** (`ressources/form.blade.php`) :
   - Champs dynamiques selon le type (vidéo, document, quiz, etc.).
3. **Détail d’une séquence** (`sequences/show.blade.php`) :
   - Titre de la séquence + liste des ressources associées.

### **🔧 Fonctionnalités attendues**
- CRUD pour les ressources et séquences.
- Upload de fichiers (PDF, vidéo, etc.).
- Association des ressources aux séquences.

---

## **⏱️ Sprint 4 — Gestion des activités & Calcul des heures**
**Dates : J13 à J15**
**Objectif :** Enregistrer les activités et calculer automatiquement les heures.

### **📋 Tâches détaillées**
| **Tâche**                                 | **Durée** | **Livrables**                                      | **Technologies/Outils**               |
|-------------------------------------------|-----------|----------------------------------------------------|---------------------------------------|
| Migration `activites`                     | 0.5 jour  | Table avec 5 champs                                | Artisan CLI                          |
| Migration `parametres_calcul`             | 0.25 jour | Table avec 4 champs                                | Artisan CLI                          |
| Service `CalculHoraireService`            | 1 jour    | Logique de calcul des heures                       | Service Laravel                      |
| Interface : Saisie d’une activité         | 0.5 jour  | Formulaire pour enregistrer une activité          | Blade, Flatpickr (pour les dates)    |
| Interface : Récapitulatif des heures      | 0.75 jour | Tableau synthétique avec heures normales/complémentaires | Blade, Chart.js |

### **🖥️ Écrans Blade prévus**
1. **Saisie d’une activité** (`activites/create.blade.php`) :
   - Champs : enseignant, ressource, type d’action, date, heures calculées (auto).
2. **Récapitulatif des heures** (`enseignants/heures.blade.php`) :
   - Tableau : Enseignant, Heures normales, Heures complémentaires, Total.

### **🔧 Fonctionnalités attendues**
- Calcul automatique des heures selon le type de ressource et sa complexité.
- Détection des heures complémentaires.
- Historique des activités par enseignant.

---

## **📊 Sprint 5 — Tableaux de bord**
**Dates : J16 à J18**
**Objectif :** Créer des dashboards pour chaque profil utilisateur.

### **📋 Tâches détaillées**
| **Tâche**                                 | **Durée** | **Livrables**                                      | **Technologies/Outils**               |
|-------------------------------------------|-----------|----------------------------------------------------|---------------------------------------|
| Dashboard Administrateur                  | 1 jour    | 4 widgets (heures/enseignant, heures/département, etc.) | Chart.js, Blade                     |
| Dashboard Secrétaire                      | 0.5 jour  | 2 widgets (activités récentes, validations)         | Blade                               |
| Dashboard Enseignant                      | 0.5 jour  | 3 widgets (mes heures, mes ressources, etc.)       | Blade                               |
| Intégration de Chart.js                   | 1 jour    | Graphiques interactifs                            | Chart.js                            |

### **🖥️ Écrans Blade prévus**
1. **Dashboard Admin** (`dashboards/admin.blade.php`) :
   - Widgets : Volume total d’heures, heures par département, enseignants en dépassement, statistiques mensuelles.
2. **Dashboard Enseignant** (`dashboards/enseignant.blade.php`) :
   - Widgets : Mes heures du mois, mes ressources, heures complémentaires.

### **🔧 Fonctionnalités attendues**
- Visualisation des données clés par profil.
- Graphiques interactifs (Chart.js).
- Données mises à jour en temps réel.

---

## **📄 Sprint 6 — États, rapports et exports**
**Dates : J19 à J21**
**Objectif :** Générer des rapports PDF/Excel et exporter les données.

### **📋 Tâches détaillées**
| **Tâche**                                 | **Durée** | **Livrables**                                      | **Technologies/Outils**               |
|-------------------------------------------|-----------|----------------------------------------------------|---------------------------------------|
| Génération PDF (DomPDF)                   | 1 jour    | Fiche enseignant, état global des heures           | DomPDF, Blade                        |
| Export Excel (Laravel Excel)               | 0.5 jour  | Export des heures et statistiques                 | Maatwebsite Excel                    |
| Boutons d’export dans les listes          | 0.5 jour  | Intégration dans les interfaces existantes        | Blade, JavaScript                    |

### **🖥️ Écran Blade prévu**
1. **Boutons d’export** dans les listes (enseignants, cours, activités) :
   - Options : PDF, Excel.

### **🔧 Fonctionnalités attendues**
- Génération de fichiers PDF/Excel.
- Export des données filtrées.

---

## **🔐 Sprint 7 — Sécurité, paramétrage & finalisation**
**Dates : J22 à J24**
**Objectif :** Sécuriser l’application et finaliser les paramètres.

### **📋 Tâches détaillées**
| **Tâche**                                 | **Durée** | **Livrables**                                      | **Technologies/Outils**               |
|-------------------------------------------|-----------|----------------------------------------------------|---------------------------------------|
| Gestion des années académiques            | 0.5 jour  | Table `annees_academiques`                         | Artisan CLI                          |
| Paramétrage des taux horaires             | 0.25 jour | Interface admin pour configurer les taux          | Blade, Form Requests                 |
| Middleware de vérification des rôles      | 0.5 jour  | Sécurité renforcée sur toutes les routes          | Middleware Laravel                   |
| Sauvegarde automatique                    | 0.25 jour | Commande Artisan schedulée                        | Laravel Scheduler                   |
| Tests unitaires (PHPUnit)                 | 0.5 jour  | Couverture des fonctionnalités principales        | PHPUnit                             |
| Correction des bugs                      | 1 jour    | Liste des bugs corrigés                           | Debugbar, Logs                      |

### **🔧 Fonctionnalités attendues**
- Sécurité renforcée (middleware, sauvegardes).
- Configuration des paramètres par l’admin.
- Tests unitaires pour les fonctionnalités critiques.

---

## **📦 Sprint 8 — Déploiement & Documentation**
**Dates : J25 à J26**
**Objectif :** Déployer l’application et rédiger la documentation.

### **📋 Tâches détaillées**
| **Tâche**                                 | **Durée** | **Livrables**                                      | **Technologies/Outils**               |
|-------------------------------------------|-----------|----------------------------------------------------|---------------------------------------|
| Configuration du serveur                  | 0.5 jour  | Serveur prêt (Apache/Nginx + MySQL)                 | SSH, Forge Laravel                    |
| Déploiement de l’application             | 0.5 jour  | Application accessible en ligne                    | Envoyer, Deployer                    |
| Documentation technique                   | 0.5 jour  | Guide d’installation et configuration              | Markdown, Word                       |
| Guide utilisateur                        | 0.5 jour  | Manuel avec captures d’écran                       | Word, Snaggy                         |

### **🔧 Fonctionnalités attendues**
- Application déployée et accessible.
- Documentation complète (technique et utilisateur).

---

## **📌 Résumé des Livrables Finaux**
- **25+ écrans Blade** (interfaces utilisateur complètes).
- **8 modules fonctionnels** (enseignants, cours, ressources, activités, etc.).
- **Documentation technique et utilisateur**.
- **Application déployée, sécurisée et testée**.

---