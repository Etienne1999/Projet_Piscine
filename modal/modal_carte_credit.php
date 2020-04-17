<?php 
	include ("database/db_connect.php");

	function list_adresse_option($db_handle) {
		$id = $_SESSION['user_ID'];
		$sql = "SELECT * FROM adresse WHERE adresse.ID_User = '$id'";
		$result = mysqli_query($db_handle, $sql);

		while ($data = mysqli_fetch_assoc($result)) {
			echo '<option value="' . $data['ID'] . '">' . $data['Ligne_1'] . ", " . $data['Ville'] . ", " . $data['Code_Postal'] . ", " . $data['Pays'] . '</option><br>';
		}
	}



	function list_type_carte($db_handle) {
		$sql = "SELECT * FROM type_carte";
		$result = mysqli_query($db_handle, $sql);

		while ($data = mysqli_fetch_assoc($result)) {
			echo '<option value="' . $data['ID'] . '">' . $data['Nom'] .  '</option><br>';
		}
	}
?>

<!-- Modal ajout Carte -->	
	<div class="modal fade" id="Modal_add_carte" data-backdrop="static" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Nouvelle Carte</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<label for="num_carte" class="col-form-label">Numero carte :</label>
							<input type="number" class="form-control" id="num_carte" name="num_carte" min="1000000000000000" max="9999999999999999" required="true">
							<label for="proprietaire" class="col-form-label">Nom du proprietaire de la carte :</label>
							<input type="text" class="form-control" id="proprietaire" name="proprietaire" required="true">
							<label for="date_exp" class="col-form-label">Date d'expiration :</label>
							<select class="form-control" id="exp_MM" name="exp_MM" required="true">
								<option value="01">01 - Janvier</option>
								<option value="02">02 - Fevrier</option>
								<option value="03">03 - Mars</option>
								<option value="04">04 - Avril</option>
								<option value="05">05 - Mai</option>
								<option value="06">06 - Juin</option>
								<option value="07">07 - Juillet</option>
								<option value="08">08 - Aout</option>
								<option value="09">09 - Septembre</option>
								<option value="10">10 - Octobre</option>
								<option value="11">11 - Novembre</option>
								<option value="12">12 - Decembre</option>
							</select>
							<br>
							<select class="form-control" id="exp_YY" name="exp_YY" required="true">
								<option value="2020">2020</option>
								<option value="2021">2021</option>
								<option value="2022">2022</option>
								<option value="2023">2023</option>
								<option value="2024">2024</option>
								<option value="2025">2025</option>
								<option value="2026">2026</option>
								<option value="2027">2027</option>
								<option value="2028">2028</option>
								<option value="2029">2029</option>
								<option value="2030">2030</option>
								<option value="2031">2031</option>
								<option value="2032">2032</option>
								<option value="2033">2033</option>
								<option value="2034">2034</option>
								<option value="2035">2035</option>
							</select>
							<label for="cvv" class="col-form-label">CVV :</label>
							<input type="number" class="form-control" id="cvv" name="cvv" min="100" max="999" required="true">
							<label for="plafond" class="col-form-label">Plafond :</label>
							<input type="text" class="form-control" id="plafond" name="plafond">
							<label for="type" class="col-form-label">Type de carte :</label>
							<select class="form-control" id="type" name="type"  required="true">
								<?php list_type_carte($db_handle); ?>
							</select>
							<label for="adresse_factu" class="col-form-label">Adresse de facturation :</label>
							<select class="form-control" id="adresse_factu" name="adresse_factu"  required="true">
								<?php list_adresse_option($db_handle); ?>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" name="btn_add_carte">Ajouter</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- Fin Modal ajout Carte -->

<!-- Modal modif Carte -->	
	<div class="modal fade" id="Modal_edit_carte" data-backdrop="static" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Modifier Carte</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<input type="text" class="form-control" id="id" name="id" readonly hidden>
							<label for="num_cache" class="col-form-label">Numero carte :</label>
							<input type="text" class="form-control" id="num_cache" name="num_cache" readonly>
							<label for="proprietaire" class="col-form-label">Nom du proprietaire de la carte :</label>
							<input type="text" class="form-control" id="proprietaire" name="proprietaire">
							<label for="date_exp" class="col-form-label">Date d'expiration :</label>
							<input type="text" class="form-control" id="date_exp" name="date_exp">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
						<button type="submit" class="btn btn-success" name="btn_edit_carte">Modifier</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- Fin Modal modif Carte -->

<!-- Modal suppression Carte -->	
	<div class="modal fade" id="Modal_suppr_carte" data-backdrop="static" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Supprimer Carte</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<input type="text" class="form-control" id="id" name="id" readonly hidden>
							<label for="num_cache" class="col-form-label">Numero carte :</label>
							<input type="text" class="form-control" id="num_cache" name="num_cache" readonly>
							<label for="type" class="col-form-label">Type de carte :</label>
							<input type="text" class="form-control" id="type" name="type" readonly>
							<p>Voulez vous vraiment supprimer cette Carte ?</p>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
						<button type="submit" class="btn btn-danger" name="btn_suppr_carte">Oui</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- Fin Modal suppression Carte -->