<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Heures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-3">Gestion des heures</h2>
        
        
        <button class="btn btn-primary mb-3" data-bs-toggle="modal"
         data-bs-target="#addModal">+ Ajouter</button>
         <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Heure début</th>
                    <th>Heure fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbodyHeures">
                <tr>
                    <td>17/04/2026</td>
                    <td>08:00</td>
                    <td>12:00</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Modifier</button>
                        <button class="btn btn-sm btn-danger">Supprimer</button>
                    </td>
                </tr>
            </tbody>
        </table>
        </table>

<div class="modal fade" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter une heure</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="date" class="form-control mb-2">
        <input type="time" class="form-control mb-2">
        <input type="time" class="form-control">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button class="btn btn-primary" id="btnSaveHeure">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

</div>
    </div>
    

<script>

    document.getElementById('btnSaveHeure').onclick = function() {
        alert('le bouton marche');
       let inputs = document.querySelectorAll('#addModal .modal-body input');
        let date = inputs[0].value;
        let debut = inputs[1].value;
        let fin = inputs[2].value;

        if(!date ||!debut ||!fin) {
            alert('Remplis Date, Heure début et Heure fin');
            return;
        }

        document.getElementById('tbodyHeures').insertAdjacentHTML('beforeend', `
            <tr>
                <td>${date}</td>
                <td>${debut}</td>
                <td>${fin}</td>
                <td>
                    <button class="btn btn-sm btn-warning">Modifier</button>
                    <button class="btn btn-sm btn-danger">Supprimer</button>
                </td>
            </tr>
        `);

        bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
        inputs.forEach(i => i.value = '');
    };

</script>

</body>
</html>