<!-- resources/views/admin/users/index.blade.php -->
<x-app-layout>
    <x-slot name="title">Gestion des utilisateurs</x-slot>

    <div class="row g-4">

        <!-- Formulaire ajout utilisateur -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-person-plus-fill me-2"></i>Nouvel utilisateur
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name') }}" placeholder="Nom complet">
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email') }}" placeholder="email@uvci.ci">
                            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rôle</label>
                            <select name="role" class="form-select">
                                <option value="">-- Sélectionner --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Minimum 8 caractères">
                            @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmer</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i>Créer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste utilisateurs -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-people-fill me-2"></i>
                    Utilisateurs ({{ $users->total() }})
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Rôle</th>
                                <th>Créé le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:35px; height:35px; border-radius:50%;
                                                    background:linear-gradient(135deg,#2E7D32,#4CAF50);
                                                    display:flex; align-items:center; justify-content:center;
                                                    color:#fff; font-weight:700; font-size:0.85rem;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-500">{{ $user->name }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <!-- Changer le rôle -->
                                    <form method="POST"
                                          action="{{ route('admin.users.role', $user) }}">
                                        @csrf @method('PUT')
                                        <div class="input-group input-group-sm">
                                            <select name="role" class="form-select form-select-sm">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <small>{{ $user->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <!-- Reset mot de passe -->
                                        <button class="btn btn-sm btn-outline-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalPwd{{ $user->id }}"
                                                title="Réinitialiser mot de passe">
                                            <i class="bi bi-key"></i>
                                        </button>

                                        @if($user->id !== auth()->id())
                                        <form method="POST"
                                              action="{{ route('admin.users.destroy', $user) }}"
                                              onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal reset password -->
                            <div class="modal fade" id="modalPwd{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Réinitialiser — {{ $user->name }}
                                            </h5>
                                            <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST"
                                              action="{{ route('admin.users.password', $user) }}">
                                            @csrf @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nouveau mot de passe</label>
                                                    <input type="password" name="password"
                                                           class="form-control" placeholder="Minimum 8 caractères">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Confirmer</label>
                                                    <input type="password" name="password_confirmation"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">
                                                    Enregistrer
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>