<x-app-layout>
    <x-slot name="title">Nouveau Cours</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-plus-circle-fill me-2"></i>Ajouter un cours
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('cours.store') }}">
                        @csrf
                        @include('cours._form')
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('cours.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg me-1"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">

        <!-- Titre -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h2 class="fw-bold mb-3 align-items-center fs-5" style="color:var(---blue);">
                    <i class="bi bi-book-fill me-2"></i>
                    Gestion des ressources pédagogiques
                </h2>

                <p class="text-muted mb-0">
                    Ajoutez des vidéos, PDF, contenus textuels et documents pédagogiques
                    pour chaque cours.
                </p>
            </div>
        </div>

        <!-- FORMULAIRE COMPLET -->
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header">
                <i class="bi bi-book me-2"></i>Informations du cours &amp; Ressources pédagogiques
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <!-- Informations du cours -->

                    <div class="col-md-6">
                        <label class="form-label">Nom du cours</label>
                        <input type="text" class="form-control" placeholder="Ex : Développement Web">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nom du professeur</label>
                        <input type="text" class="form-control" placeholder="Ex : M. Koffi Jean">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Filière</label>
                        <select class="form-select">
                            <option>Choisir une filière</option>
                            <option>Developpement d'Applications</option>
                            <option>Marketing Digital</option>
                            <option>Base de Données</option>
                            <option>Data Science</option>
                            <option>Cybersécurité</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Niveau</label>
                        <select class="form-select">
                            <option>L1</option>
                            <option>L2</option>
                            <option>L3</option>
                            <option>M1</option>
                            <option>M2</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">semestre</label>
                        <select class="form-select">
                            <option>S1</option>
                            <option>S2</option>
                            <option>S3</option>
                            <option>S4</option>
                            <option>S5</option>
                            <option>S6</option>
                            <option>S7</option>
                            <option>S8</option>
                            <option>S9</option>
                            <option>S10</option>
                        </select>
                    </div>


                    <div class="col-md-4">
                        <label class="form-label">Séquence pédagogique</label>
                        <input type="text" class="form-control" placeholder="Ex : Séquence 1">
                    </div>

                    <!-- Ressources pédagogiques -->

                    <div class="col-md-4">
                        <label class="form-label">Type de ressource</label>
                        <select class="form-select">
                            <option>Vidéo pédagogique</option>
                            <option>PDF</option>
                            <option>Contenu textuel</option>
                            <option>Document pédagogique</option>
                            <option>Quiz</option>
                            <option>Évaluation</option>
                            <option>Activité interactive</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Titre de la ressource</label>
                        <input type="text" class="form-control" placeholder="Ex : Introduction à Laravel">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="4"
                            placeholder="Décrivez la ressource pédagogique..."></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ajouter une vidéo</label>
                        <input type="file" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ajouter un PDF / document</label>
                        <input type="file" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Contenu textuel</label>
                        <textarea class="form-control" rows="5"
                            placeholder="Saisissez le contenu pédagogique ici..."></textarea>
                    </div>

                    <!-- Bouton -->

                    <div class="col-md-12 text-end mt-3">
                        <button class="btn btn-primary px-4">
                            <i class="bi bi-plus-circle me-2"></i>
                            Enregistrer la ressource
                        </button>
                    </div>

                </div>

            </div>
        </div>

        <!-- Tableau des ressources -->

        <div class="card shadow-sm border-0">

            <div class="card-header">
                <i class="bi bi-table me-2"></i>Liste des ressources pédagogiques
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Titre</th>
                                <th>Professeur</th>
                                <th>Filière</th>
                                <th>Fichier</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>
                                    <span class="badge badge-red">
                                        Vidéo
                                    </span>
                                </td>
                                <td>Introduction HTML</td>
                                <td>M. Koffi Jean</td>
                                <td>Génie Logiciel</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        Voir
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning">
                                        Modifier
                                    </button>

                                    <button class="btn btn-sm btn-danger">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>
                                    <span class="badge badge-gray">
                                        PDF
                                    </span>
                                </td>
                                <td>Guide Bootstrap</td>
                                <td>Mme Konan</td>
                                <td>Data Science</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-success">
                                        Télécharger
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning">
                                        Modifier
                                    </button>

                                    <button class="btn btn-sm btn-danger">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </div>
</x-app-layout>