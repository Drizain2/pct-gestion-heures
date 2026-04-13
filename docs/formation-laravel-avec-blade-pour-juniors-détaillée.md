# Formation Laravel avec Blade pour Juniors – Détaillée

---

## 1. Introduction à Laravel et Installation

### Objectif
Comprendre ce qu’est Laravel, son architecture MVC, et comment l’installer.

### Explications
- **Laravel** est un framework PHP moderne qui suit le modèle MVC (Modèle-Vue-Contrôleur).
- **Installation** : Utilisez Composer pour créer un nouveau projet Laravel :
  ```bash
  composer create-project laravel/laravel nom-du-projet
  ```
- **Structure des dossiers** :
  - `app/` : Contient les modèles, contrôleurs, middleware, etc.
  - `resources/views/` : Contient les vues Blade.
  - `routes/` : Contient les définitions de routes.
  - `database/migrations/` : Contient les fichiers de migration.
  - `public/` : Contient les assets (CSS, JS, images).

---

## 2. Architecture MVC dans Laravel

### Objectif
Comprendre comment Laravel organise le code selon le modèle MVC.

### Explications et Exemples

#### Modèle (Model)
- Représente les données et la logique métier.
- Utilise **Eloquent ORM** pour interagir avec la base de données.
- Exemple : Création d’un modèle `Post` :
  ```bash
  php artisan make:model Post -m
  ```
  Cela crée un modèle et une migration associée.

#### Vue (View)
- Gère l’affichage des données.
- Utilise le moteur de template **Blade**.
- Exemple de vue (`resources/views/welcome.blade.php`) :
  ```html
  <!DOCTYPE html>
  <html>
  <head>
      <title>Bienvenue</title>
  </head>
  <body>
      <h1>Bonjour, {{ $nom }} !</h1>
  </body>
  </html>
  ```

#### Contrôleur (Controller)
- Gère la logique applicative.
- Exemple : Création d’un contrôleur `PostController` :
  ```bash
  php artisan make:controller PostController --resource
  ```
  Cela génère un contrôleur avec les méthodes CRUD de base.

---

## 3. Routing et Contrôleurs

### Objectif
Apprendre à définir des routes et à les lier à des contrôleurs.

### Explications et Exemples
- **Définition des routes** dans `routes/web.php` :
  ```php
  Route::get('/', function () {
      return view('welcome');
  });

  Route::get('/posts', [PostController::class, 'index']);
  ```
- **Passage de données** d’un contrôleur à une vue :
  ```php
  public function index()
  {
      $posts = Post::all();
      return view('posts.index', compact('posts'));
  }
  ```

---

## 4. Migrations et Bases de Données

### Objectif
Savoir créer et gérer la structure de la base de données avec les migrations.

### Explications et Exemples
- **Création d’une migration** :
  ```bash
  php artisan make:migration create_posts_table
  ```
- **Exemple de migration** (`database/migrations/..._create_posts_table.php`) :
  ```php
  public function up()
  {
      Schema::create('posts', function (Blueprint $table) {
          $table->id();
          $table->string('title');
          $table->text('content');
          $table->timestamps();
      });
  }
  ```
- **Exécution des migrations** :
  ```bash
  php artisan migrate
  ```

---

## 5. Blade : Moteur de Templates

### Objectif
Maîtriser la syntaxe Blade pour créer des vues dynamiques et réutilisables.

### Explications et Exemples
- **Syntaxe de base** :
  - Affichage de variables : `{{ $variable }}`
  - Directives de contrôle : `@if`, `@foreach`, `@include`, `@extends`, `@section`
- **Exemple de layout** (`resources/views/layouts/app.blade.php`) :
  ```html
  <!DOCTYPE html>
  <html>
  <head>
      <title>@yield('title')</title>
  </head>
  <body>
      @section('content')
      @show
  </body>
  </html>
  ```
- **Exemple de vue étendant un layout** (`resources/views/posts/index.blade.php`) :
  ```html
  @extends('layouts.app')

  @section('title', 'Liste des posts')

  @section('content')
      <h1>Liste des posts</h1>
      @foreach($posts as $post)
          <h2>{{ $post->title }}</h2>
          <p>{{ $post->content }}</p>
      @endforeach
  @endsection
  ```

---

## 6. Gestion des Assets (CSS, JS, Images)

### Objectif
Savoir intégrer des styles, scripts et images dans une application Laravel.

### Explications et Exemples
- **Utilisation de la fonction `asset()`** pour lier des fichiers statiques :
  ```html
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <script src="{{ asset('js/app.js') }}"></script>
  <img src="{{ asset('images/logo.png') }}" alt="Logo">
  ```
- **Organisation des assets** :
  - Placez vos fichiers CSS/JS dans `public/css/` et `public/js/`.
  - Placez vos images dans `public/images/`.

---

## 7. Projet Pratique : Mini-Application CRUD

### Objectif
Mettre en pratique tous les concepts avec un projet concret.

### Étapes
1. **Créer un modèle et une migration** pour une entité (ex : `Post`).
2. **Définir les routes** pour afficher, créer, modifier et supprimer des posts.
3. **Créer un contrôleur** pour gérer la logique CRUD.
4. **Créer des vues Blade** pour afficher les posts et les formulaires.
5. **Ajouter des styles** avec Bootstrap ou un autre framework CSS.

---

## Captures d’Écran et Ressources Visuelles

### Exemple de vue Blade
![Exemple de vue Blade](https://8020coding.com/wp-content/uploads/2021/07/laravel-blade-template-example.png)

### Exemple de structure MVC
![Architecture MVC Laravel](https://cdn.shopaccino.com/igmguru/images/mvc-architecture-overview-2877088697925306.jpg)

---

## Ressources Complémentaires
- [Documentation officielle Laravel](https://laravel.com/docs)
- [Tutoriels vidéo Laravel 12](https://www.apprendre-laravel-12.net/)
- [Formation Laravel – Human Coders](https://www.humancoders.com/formations/laravel)

---

## Conclusion
Cette formation te permet de maîtriser les bases de Laravel et Blade, et de développer des applications web modernes et maintenables. À la fin, tu seras capable de créer une application complète en utilisant les bonnes pratiques du framework.

---