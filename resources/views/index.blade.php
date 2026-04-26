<x-app-layout>
    <div class="page-wrapper p-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Liste des enseignants</h1>
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Ajouter un enseignant
                </a>
            </div>

            <!-- Tableau des enseignants -->
            <div class="card shadow-sm mt-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Grade</th>
                                    <th>Statut</th>
                                    <th>Département</th>
                                    <th>Taux horaire</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyEnseignants">
                                @php
                                    $enseignantsFake = [
                                        (object)['id'=>1, 'nom'=>'Koffi', 'prenom'=>'Jean', 'email'=>'koffi@test.com', 'grade'=>'Professeur', 'statut'=>'permanent', 'departement'=>'Informatique', 'taux_horaire'=>5000],
                                        (object)['id'=>2, 'nom'=>'Koné', 'prenom'=>'Fatou', 'email'=>'kone@test.com', 'grade'=>'Assistant', 'statut'=>'vacataire', 'departement'=>'Maths', 'taux_horaire'=>3500]
                                    ];
                                    $liste = (isset($enseignants) && count($enseignants) > 0) ? $enseignants : $enseignantsFake;
                                @endphp

                                @foreach($liste as $enseignant)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $enseignant->nom }}</td>
                                        <td>{{ $enseignant->prenom }}</td>
                                        <td>{{ $enseignant->email }}</td>
                                        <td>{{ $enseignant->grade }}</td>
                                        <td>
                                            <span class="badge {{ strtolower($enseignant->statut) == 'permanent' ? 'bg-success' : 'bg-info' }}"> {{ ucfirst($enseignant->statut) }}
                                               
                                            </span>
                                        </td>
                                        <td>{{ $enseignant->departement }}</td>
                                        <td>{{ number_format($enseignant->taux_horaire, 0, ',', ' ') }} FCFA</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                    <a href="#" class="btn btn-sm btn-outline-primary" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour activer les boutons de test -->
    <script>
        document.getElementById('tbodyEnseignants').addEventListener('click', function(e) {
            if(e.target.closest('.btn-delete')) {
                if(confirm('Supprimer cet enseignant ?')) {
                    e.target.closest('tr').remove();
                }
            }
            if(e.target.closest('.btn-edit')) {
                alert('Mode modification activé pour le front');
            }
            if(e.target.closest('.btn-view')) {
                alert('Affichage des détails simulé');
            }
        });
    </script> 
</x-app-layout>
