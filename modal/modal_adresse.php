<!-- Modal ajout adresse -->	
	<div class="modal fade" id="Modal_add_adresse" data-backdrop="static" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Nouvelle adresse</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<label for="ligne_1" class="col-form-label">Ligne 1 :</label>
							<input type="text" class="form-control" id="ligne_1" name="ligne_1">
							<label for="ligne_2" class="col-form-label">Ligne2 :</label>
							<input type="text" class="form-control" id="ligne_2" name="ligne_2">
							<label for="ville" class="col-form-label">Ville :</label>
							<input type="text" class="form-control" id="ville" name="ville">
							<label for="code_postal" class="col-form-label">Code Postal :</label>
							<input type="text" class="form-control" id="code_postal" name="code_postal">
							<label for="pays" class="col-form-label">Pays :</label>
							<input type="text" class="form-control" id="pays" name="pays">
							<label for="telephone" class="col-form-label">Telephone :</label>
							<input type="text" class="form-control" id="telephone" name="telephone">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" name="btn_add_adresse">Ajouter</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- Fin Modal ajout adresse -->