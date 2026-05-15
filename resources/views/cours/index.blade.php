<x-app-layout>
    <x-slot name="title">Gestion des Cours</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0" style="color:#2E7D32;">
                <i class="bi bi-book-fill me-2"></i>Cours
            </h4>
            <small class="text-muted">{{ $cours->total() }} cours enregistré(s)</small>
        </div>
        <a href="{{ route('cours.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Nouveau cours
        </a>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('cours.index') }}" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control"
                        placeholder="Rechercher par intitulé, filière..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="niveau" class="form-select">
                        <option value="">Tous les niveaux</option>
                        @foreach(['L1','L2','L3','M1','M2'] as $n)
                        <option value="{{ $n }}" {{ request('niveau') == $n ? 'selected' : '' }}>
                            {{ $n }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="semestre" class="form-select">
                        <option value="">Tous les semestres</option>
                        @foreach(['S1','S2','S3','S4','S5','S6','S7','S8','S9','S10'] as $s)
                        <option value="{{ $s }}" {{ request('semestre') == $s ? 'selected' : '' }}>
                            {{ $s }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('cours.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau -->
    <div class="card">
        <div class="card-body p-0">
            <div cla="table-responsive">
            <table class="table table-hover align-middle mb-0">
                </div>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Intitulé</th>
                        <th>Filière</th>
                        <th>Niveau</th>
                        <th>Semestre</th>
                        <th>Heures</th>
                        <th>Crédits</th>
                        <th>Enseignants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cours as $c)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td><strong>{{ $c->intitule }}</strong></td>
                        <td>{{ $c->filiere }}</td>
                        <td>
                            <span class="badge me-1 mb-1" style="background: #2e7012;">
                                {{ $c->niveau }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $c->semestre }}</span>
                        </td>
                        <td>{{ $c->nombre_heures }}h</td>
                        <td>{{ $c->nombre_credits }}</td>
                        <td>
                            @forelse($c->enseignants as $enseignant)
                            <span class="badge" style="background:#E65100; font-size:0.75rem;">
                                {{ $enseignant->nom_complet }}
                            </span>
                            @empty
                           <td colspan="9" class="text-center py-5">
    <div class="py-4">
        <i class="bi bi-book" style="font-size: 3.5rem; color: #cbd5e1;"></i>
        <h5 class="mt-3 fw-semibold">Aucun cours enregistré</h5>
        <p class="text-muted mb-3">
            Commence par ajouter ton premier cours pour l’année académique en cours.
        </p>
        <a href="{{ route('cours.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Nouveau cours
        </a>
    </div>
</td>
                            @endforelse
                        </td>
                        <td>
                            <td>
  <div class="d-flex gap-1 flex-wrap">
  <a href="{{ route('cours.show', $c) }}" 
     class="btn btn-sm btn-outline-success" 
     data-bs-toggle="tooltip" title="Voir">
    <i class="bi bi-eye"></i>
  </a>

  <a href="{{ route('cours.edit', $c) }}" 
     class="btn btn-sm btn-outline-warning" 
     data-bs-toggle="tooltip" title="Modifier">
    <i class="bi bi-pencil"></i>
  </a>

  <form method="POST" action="{{ route('cours.destroy', $c) }}" 
        onsubmit="return confirm('Supprimer ce cours ?')">
    @csrf @method('DELETE')
    
    </button>
  </form>
</div>

    

    <form method="POST" 
          action="{{ route('cours.destroy', $c) }}" 
          onsubmit="return confirm('Supprimer ce cours ?')">
      @csrf 
      @method('DELETE')
      <button type="submit" 
              class="btn btn-sm btn-outline-danger" 
              title="Supprimer">
        <i class="bi bi-trash"></i>
      </button>
    </form>
  </div>
</td>
                        </td>
                    </tr>
                    @empty
                    <td colspan="9" class="text-center py-5">
    <div class="py-4">
        <i class="bi bi-book" style="font-size: 3.5rem; color: #cbd5e1;"></i>
        <h5 class="mt-3 fw-semibold">Aucun cours enregistré</h5>
        <p class="text-muted mb-3">
            Commence par ajouter ton premier cours pour l’année académique en cours.
        </p>
        <a href="{{ route('cours.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Nouveau cours
        </a>
    </div>
</td>
                    @endforelse
                </tbody>
            </table>
             </div>
        </div>

        @if($cours->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Affichage de {{ $cours->firstItem() }}
                à {{ $cours->lastItem() }}
                sur {{ $cours->total() }} résultats
            </small>
            {{ $cours->withQueryString()->links() }}
        </div>
        @endif
    </div>
</x-app-layout>