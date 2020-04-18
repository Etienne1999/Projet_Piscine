<!-- Modal ajout Chaque_cadeau -->	
	<div class="modal fade" id="Modal_add_cadeau" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Creer Cheque Cadeau</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<form method="post" action="mails.php">
					<div class="modal-body">
						<div class="form-group">
							<label for="num_carte" class="col-form-label">Numéro Carte :</label>
							<input type="text" class="form-control" name="num_carte" id="num_carte" readonly>
							<label for="montant" class="col-form-label">Montant :</label>
							<input type="text" class="form-control" id="montant" name="montant">
							<label for="email" class="col-form-label">Email Destinataire :</label>
							<input type="text" class="form-control" id="email" name="email">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
						<button type="submit" class="btn btn-primary" name="btn_add_cadeau">Envoyer</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- Fin Modal ajout Cheque_cadeau -->	
