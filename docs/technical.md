# Documentation technique — PCT Gestion Heures

## 1. Vue d'ensemble

`pct-gestion-heures` est une application Laravel 13 conçue pour gérer les enseignants, les cours, les activités pédagogiques et les exports de rapports de temps / paiements.

- Backend : PHP 8.3, Laravel 13
- Frontend : Blade + Bootstrap 5 + Alpine.js + Chart.js
- Authentification : Laravel Breeze
- Permissions : Spatie Laravel Permission
- Exports : DOMPDF + Maatwebsite Excel

## 2. Architecture générale

### Principales couches

- `app/Models` : définition des entités métiers
- `app/Http/Controllers` : logique métier HTTP
- `app/Http/Requests` : validation de formulaires
- `resources/views` : templates Blade
- `routes/web.php` : routes de l’application
- `database/migrations` : structure de la base de données
- `database/factories` : factories pour les tests et le seeding
- `tests` : suite de tests Pest

## 3. Packages clés

### Composer

- `laravel/framework` v13
- `barryvdh/laravel-dompdf` : génération PDF
- `maatwebsite/excel` : export Excel
- `spatie/laravel-permission` : gestion des rôles et permissions
- `laravel/breeze` : auth scaffolding
- `laravel/pint` : formatage PHP
- `pestphp/pest` + `pestphp/pest-plugin-laravel` : tests

### NPM

- `bootstrap` v5
- `bootstrap-icons`
- `alpinejs`
- `chart.js`
- `vite` + `laravel-vite-plugin`

## 4. Modèles et relations

### `App\Models\User`

- Authentification utilisateur standard
- Relation 1:1 vers `Enseignant`
- Gestion des rôles via Spatie

### `App\Models\Enseignant`

- Attributs métier : `nom`, `prenom`, `grade`, `statut`, `departement`, `email`, `telephone`, `taux_horaire`
- Relations :
  - `user()` : appartient à `User`
  - `cours()` : belongsToMany via `cours_enseignant`
  - `activites()` : hasMany `Activite`
- SoftDeletes activé

### Autres modèles

- `Cours` : cours et structure pédagogique
- `Sequence` : séquences d’un cours
- `Ressource` : ressources pédagogiques attachées à une séquence
- `Activite` : activité pédagogique déclarée
- `AnneeAcademique` : années académiques activables
- `ParametreSysteme` / `ParametreCalcule` : paramètres de configuration et formules

## 5. Logique métier

### `App\Services\CalculHoraireService`

- `calculerHeures()` : calcule les heures selon complexité, type d’action et nombre de séquences
- `getSeuilParGrade()` : seuil par grade d’enseignant
- `volumeHoraireEnseignant()` : calcul global des heures validées d’un enseignant

## 6. Routes principales

### Authentification

- `routes/auth.php` : login, register, reset password, email verification, logout

### Route publique

- `/` : page de connexion
- `/heures` : vue de synthèse publique (?)

### Routes protégées

- `Route::middleware(['auth'])` : toutes les routes protégées par authentification

#### Admin

- `admin/dashboard`
- `admin/users` : gestion des utilisateurs
- `admin/annees` : gestion des années académiques
- `admin/parametres` : paramètres système et calcul

#### Secrétaire

- `secretaire/dashboard`

#### Enseignant

- `enseignant/dashboard`

#### Gestion enseignants / cours (Admin + Secrétaire)

- `enseignants.*` : CRUD enseignants
- `cours.*` : CRUD cours
- `cours.sequences.*` : CRUD séquences
- `cours.sequences.ressources.*` : CRUD ressources
- `activites.*` : activités déclarées, sauf édition/mise à jour
- `activites/{activite}/valider` et `activites/{activite}/rejeter`
- `enseignants/{enseignant}/cours` : récupérer cours d’un enseignant

#### Profil utilisateur

- `GET profile` : formulaire de profil
- `PATCH profile` : mise à jour
- `DELETE profile` : suppression de compte

#### Exports

- `exports.index` : page de sélection des exports
- `enseignants/{enseignant}/pdf` : fiche enseignant PDF
- `enseignants/{enseignant}/excel` : heures enseignant Excel
- `paiements/pdf` : état paiments PDF
- `heures/excel` : état global heures Excel
- `paiements/excel` : paiements Excel
- `statistiques/excel` : statistiques Excel
- `enseignants/{enseignant}/recapitulatif/pdf` : récapitulatif PDF enseignant

## 7. Contrôleurs principaux

### `EnseignantController`

- gestion complète des enseignants
- création d’un utilisateur `User` associé lors de la création
- mise à jour de l’email / du nom sur le `User`
- suppression cascade du compte utilisateur lié

### `CoursController`

- CRUD des cours
- association des séquences et ressources

### `ActiviteController`

- suivi des activités pédagogiques
- création, validation et rejet
- récapitulatif enseignant

### `ExportController`

- génération de PDF et fichiers Excel
- utilise `Pdf::loadView()` et `Excel::download()`

### `ProfileController`

- page de profil utilisateur
- mise à jour du nom et de l’email
- suppression du compte

### `admin` controllers

- `UserController` : création et mise à jour des utilisateurs
- `AnneeAcademiqueController` : activation des années académiques
- `ParametreController` : paramètres système et paramètres de calcul

## 8. Frontend

### Templates

- `resources/views/layouts/app.blade.php` : layout principal
- `resources/views/profile/edit.blade.php` : écran profil
- `resources/views/enseignants/_form.blade.php` : formulaire enseignant
- `resources/views/dashboard/*` : dashboards par rôle

### Assets

- `resources/css` : styles personnalisés
- `resources/js` : scripts frontend
- Vite compile l’ensemble via `npm run dev` ou `npm run build`

## 9. Base de données

### Fichiers de migration importants

- `database/migrations/2026_04_16_162016_create_enseignants_table.php`
- `database/migrations/2026_04_19_060310_create_annee_academiques_table.php`
- `database/migrations/2026_04_19_073402_create_cours_enseignant.php`
- `database/migrations/2026_05_22_105538_replace_annee_academique_string_with_fk_in_cours_enseignant.php`

### Remarques structurelles

- `enseignants` conserve un champ relationnel `user_id`
- `cours_enseignant` sert de table pivot pour liaisons cours/enseignants
- `activites` liste les activités pédagogiques et contient un champ `statut` pour validation
- `ParametreSysteme` et `ParametreCalcule` sont utilisés pour des réglages dynamiques

## 10. Tests

### Outils

- Pest PHP + `pest-plugin-laravel`
- RefreshDatabase instancié via `tests/Pest.php`

### Organisation

- fichiers de test dans `tests/Feature`
- `tests/Feature/EnseignantTest.php` vérifie des cas de création et de réutilisation de `User`
- `tests/Feature/Auth` contient les tests d’authentification standard

## 11. Installation et exécution

### Commandes principales

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev
```

### Commandes utiles

- `composer run setup` : installe le projet et génère l’environnement
- `composer run dev` : lance le serveur et Vite en mode développement
- `composer run test` : exécute la suite de tests

## 12. Notes opérationnelles

- Si la page ne trouve pas les assets Vite, vérifier `npm run dev` ou `npm run build`
- Le profil utilisateur est géré dans `ProfileController` et la vue `resources/views/profile/edit.blade.php`
- Le menu latéral est calculé dans `resources/views/layouts/app.blade.php`

## 13. Fichiers importants

- `app/Services/CalculHoraireService.php`
- `app/Models/Enseignant.php`
- `app/Models/Cours.php`
- `app/Models/Activite.php`
- `routes/web.php`
- `routes/auth.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/profile/edit.blade.php`

---

Cette documentation est un aperçu technique du noyau de l’application. Pour étendre ou modifier le projet, commencez par les contrôleurs métier et les modèles cités ci-dessus, puis testez avec `composer run test`.