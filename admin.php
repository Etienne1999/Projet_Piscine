<?php 
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include ("database/db_connect.php");

	//Blindage acces de la page admin si on est pas connecté en tant qu'admin
	if (empty($_SESSION['user_Role']) || $_SESSION['user_Role'] != '1') {
		header('Location: index.php');
	}	

	//Recupere les utilisateurs
	function recup_users($db_handle) {

		$sql = "SELECT u.ID, u.Nom, u.Prenom, u.Pseudo, u.Email, Role.Nom AS Role, COUNT(produit.ID) AS Nb_Vente, COUNT(commande_detail.Objet) AS Nb_Vendu
		FROM utilisateur AS u
		LEFT JOIN role ON u.Role = Role.ID
		LEFT JOIN produit ON u.ID = produit.Vendeur
		LEFT JOIN commande_detail ON produit.ID = commande_detail.Objet
		GROUP BY u.Pseudo, produit.ID";

		$result = mysqli_query($db_handle, $sql);	

		return $result;
	}

	//Affiche les utilisateurs et leur données
	function afficher_users($list_users){		
		while ($data = mysqli_fetch_assoc($list_users)) {
			echo '<tr>';
			echo '	<td>' . $data['Pseudo'] . '</td>';
			echo '	<td>' . $data['Role'] . '</td>';
			//Bouton edition + info de l'utilisateur de cette ligne
			echo ' 	<td colspan="2"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#Modal_edit_user"';
			echo ' data-id="' . $data['ID'] . '"';
			echo ' data-nom="' . $data['Nom'] . '"';
			echo ' data-prenom="' . $data['Prenom'] . '"';
			echo ' data-pseudo="' . $data['Pseudo'] . '"';
			echo ' data-email="' . $data['Email'] . '"';
			echo ' data-vente="' . $data['Nb_Vente'] . '"';
			echo ' data-vendu="' . $data['Nb_Vendu'] . '"';
			echo '">Editer</button>';

			//Button suppression + info de l'utilisateur de cette ligne
			echo ' 	<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Modal_suppr_user"';
			echo ' data-pseudo="' . $data['Pseudo'] . '"';
			echo ' data-id="' . $data['ID'] . '"';
			echo '>Supprimer</button></td>';
			echo '</tr>';
		}
	}

	//Option de selection de role dynamique
	function set_role_options($db_handle) {
		$sql = "SELECT ID, Nom
				FROM role";

		$result = mysqli_query($db_handle, $sql);

		while ($data = mysqli_fetch_assoc($result)) {
			echo '<option value="' . $data['ID'] . '">' . $data['Nom'] . '</option><br>';
		}
	}

	//Recupere et affiche les cheque cadeau
	function tab_cheque_cadeau($db_handle) {

		$sql = "SELECT *
				FROM cheque_cadeau";

		$result = mysqli_query($db_handle, $sql);	

		while ($data = mysqli_fetch_assoc($result)) {
			echo '<tr>';
			echo '	<td>' . $data['Numero_Carte'] . '</td>';
			echo '	<td>' . $data['Montant'] . '</td>';
			//Bouton edition + info du cheque cadeau de cette ligne
			echo ' 	<td colspan="2"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#Modal_edit_cadeau"';
			echo ' data-num_carte="' . $data['Numero_Carte'] . '"';
			echo ' data-montant="' . $data['Montant'] . '"';
			echo '">Editer</button>';

			//Button suppression + info du cheque cadeau de cette ligne
			echo ' 	<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Modal_suppr_cadeau"';
			echo ' data-num_carte="' . $data['Numero_Carte'] . '"';
			echo '>Supprimer</button></td>';
			echo '</tr>';
		}
	}

	//Edition user
	if (isset($_POST['btn_edit_user'])){

		$id = isset($_POST["id"])? $_POST["id"] : "";
		$nom = isset($_POST["nom"])? $_POST["nom"] : "";
		$prenom = isset($_POST["prenom"])? $_POST["prenom"] : "";
		$pseudo = isset($_POST["pseudo"])? $_POST["pseudo"] : "";
		$email = isset($_POST["email"])? $_POST["email"] : "";
		$role = isset($_POST["role"])? $_POST["role"] : "";

		if (!(empty($id) || empty($nom) || empty($prenom) || empty($pseudo) || empty($email) || empty($role))) {
			
			$sql_update_user = "UPDATE utilisateur 
						   SET Nom = '$nom',
						   Prenom = '$prenom',
						   Pseudo = '$pseudo',
						   Email = '$email',
						   Role = '$role'
						   WHERE ID = '$id'";

			$res = mysqli_query($db_handle, $sql_update_user);

			//var_dump($res);
		}
	}

	//Suppression user
	if (isset($_POST['btn_suppr_user'])){

		$id = isset($_POST["id"])? $_POST["id"] : "";
		$pseudo = isset($_POST["pseudo"])? $_POST["pseudo"] : "";

		if (!(empty($id) || empty($pseudo))) {
			
			$sql_delete_user = "DELETE FROM utilisateur WHERE ID = '$id'";
			$res = mysqli_query($db_handle, $sql_delete_user);
			//var_dump($res);
		}
	}

	//Ajout de carte cadeau
	if (isset($_POST['btn_add_cadeau'])) {
		$num_carte = isset($_POST["num_carte"])? $_POST["num_carte"] : "";
		$montant = isset($_POST["montant"])? $_POST["montant"] : "";
		
		if (!(empty($num_carte) || empty($montant))) {
			$sql_check_doublon = "SELECT Numero_Carte FROM cheque_cadeau WHERE Numero_Carte = '$num_carte'";
			$result = mysqli_query($db_handle, $sql_check_doublon);

			if (mysqli_num_rows($result) == 0) {
				$sql_add_cadeau = "INSERT INTO cheque_cadeau (Numero_Carte, Montant) VALUES ('$num_carte', '$montant')";
				$res = mysqli_query($db_handle, $sql_add_cadeau);
				//var_dump($res);	
			}
		}
	}

	//Edition de carte cadeau
	if (isset($_POST['btn_edit_cadeau'])) {
		$num_carte = isset($_POST["num_carte"])? $_POST["num_carte"] : "";
		$montant = isset($_POST["montant"])? $_POST["montant"] : "";
		
		if (!(empty($num_carte) || empty($montant))) {
			
			$sql_update_cadeau = "UPDATE cheque_cadeau SET Montant = '$montant' WHERE Numero_Carte = '$num_carte'";
			$res = mysqli_query($db_handle, $sql_update_cadeau);
			//var_dump($res);
		}
	}

	//Suppression de carte cadeau
	if (isset($_POST['btn_suppr_cadeau'])) {
		$num_carte = isset($_POST["num_carte"])? $_POST["num_carte"] : "";

		if (!empty($num_carte)) {
			$sql_add_cadeau = "DELETE FROM Cheque_Cadeau WHERE Numero_Carte = '$num_carte'";
			$res = mysqli_query($db_handle, $sql_add_cadeau);
			//var_dump($res);
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Mon Compte</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="style.css">

	<script type="text/javascript">

		$(document).ready(function () {

			//Inspiré de https://getbootstrap.com/docs/4.4/components/modal/
			//Ouvre le modal d'edition d'utilisateur
			$('#Modal_edit_user').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				//Recupere les données de l'utilisateur a editer
				var id = button.data('id')
				var nom = button.data('nom')
				var prenom = button.data('prenom')
				var pseudo = button.data('pseudo')
				var email = button.data('email')
				var vente = button.data('vente')
				var vendu = button.data('vendu')
				var modal = $(this)
				//Rempli le modal avec les données approprié
				modal.find('.modal-title').text('Utilisateur : ' + pseudo)
				modal.find('.modal-body #id').val(id)
				modal.find('.modal-body #nom').val(nom)
				modal.find('.modal-body #prenom').val(prenom)
				modal.find('.modal-body #pseudo').val(pseudo)
				modal.find('.modal-body #email').val(email)
				modal.find('.modal-body #vente').val(vente)
				modal.find('.modal-body #vendu').val(vendu)

			});
			//Ouvre le modal de confirmation de suppression d'utilisateur
			$('#Modal_suppr_user').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				//Recupere les données de l'utilisateur a editer
				var id = button.data('id')
				var pseudo = button.data('pseudo')
				var modal = $(this)
				//Rempli le modal avec les données approprié
				modal.find('.modal-title').text('Utilisateur : ' + pseudo)
				modal.find('.modal-body #id').val(id)
				modal.find('.modal-body #pseudo').val(pseudo)
			});

			//Genere nombre aléatoire entre min inclus et max exclu
			function getRandomArbitrary(min, max) {
				return parseInt(Math.random() * (max - min) + min);
			};

			//Genere un numéro de carte a 16 chiffres pour la creation de carte cadeau
			$("#btn_rand").click(function() {
				$('#num_carte_rand').val(getRandomArbitrary(1000000000000000, 10000000000000000));
			});

			//Ouvre le modal d'edition de carte cadeau'
			$('#Modal_edit_cadeau').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				//Recupere les données de la carte cadeau a editer
				var num_carte = button.data('num_carte')
				var montant = button.data('montant')
				var modal = $(this)
				//Rempli le modal avec les données approprié
				modal.find('.modal-body #num_carte').val(num_carte)
				modal.find('.modal-body #montant').val(montant)
			});

			//Ouvre le modal de confirmation de suppression de carte cadeau
			$('#Modal_suppr_cadeau').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				//recupere l'id de la carte cadeau a suppr
				var num_carte = button.data('num_carte')
				var modal = $(this)
				//Rempli le modal avec les données approprié
				modal.find('.modal-body #num_carte').val(num_carte)
			});
		});

	</script>

</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>


	<!-- Header -->
	<header>
		
	</header>
	<!-- Conteneur -->
	<div class="container">
		<div class="row">
			<div class="col">
				<h2>Page administrateur</h2>
			</div>
		</div>	

		<div class="row">
			<div class="col-md-3">
				<div class="list-group" id="list-tab" role="tablist">
					<a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab">Utilisateurs</a>
					<a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab">Bons de réductions</a>
					<a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab">Chèques cadeau</a>
				</div>
			</div>
			<div class="col-md-9">
				<div class="tab-content" id="nav-tabContent">
					<!-- Contenu onglet utilisateurs -->
					<div class="tab-pane fade show active" id="list-home" role="tabpanel">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-dark">
								<thead>
									<tr>
										<th>Pseudo</th>
										<th>Role</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$tmp = recup_users($db_handle);
									afficher_users($tmp);
									?>
								</tbody>
							</table>							
						</div>
					</div>
					<!-- Contenu onglet bon de reductions -->
					<div class="tab-pane fade" id="list-profile" role="tabpanel">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
					<!-- Contenu onglet cheques cadeau -->
					<div class="tab-pane fade" id="list-messages" role="tabpanel">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-dark">
								<thead>
									<tr>
										<th>Numero Carte</th>
										<th>Montant Restant</th>
										<th><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal_add_cadeau">Ajouter</button></td></th>
									</tr>
								</thead>
								<tbody>
									<?php 
										tab_cheque_cadeau($db_handle);
									?>
								</tbody>
							</table>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- Modal Edition utilisateur -->	
	<div class="modal fade" id="Modal_edit_user" data-backdrop="static" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edition</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<input type="text" class="form-control" id="id" name="id" readonly hidden="true">
							<label for="nom" class="col-form-label">Nom :</label>
							<input type="text" class="form-control" id="nom" name="nom">

							<label for="prenom" class="col-form-label">Prénom :</label>
							<input type="text" class="form-control" id="prenom" name="prenom">
						</div>
						<div class="form-group">
							<label for="peusdo" class="col-form-label">Pseudo :</label>
							<input type="text" class="form-control" id="pseudo" name="pseudo">

							<label for="email" class="col-form-label">Email :</label>
							<input type="text" class="form-control" id="email" name="email">

							<label for="role" class="col-form-label">Role :</label>
							<select class="form-control" id="role" name="role">
								<?php 
									set_role_options($db_handle);
								 ?>
							</select>
						</div>
						<div class="form-group">
							<label for="vente" class="col-form-label">Produits en vente:</label>
							<input type="text" class="form-control" id="vente" readonly>

							<label for="vendu" class="col-form-label">Produits vendu:</label>
							<input type="text" class="form-control" id="vendu" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						<button type="submit" class="btn btn-primary" name="btn_edit_user">Enregistrer</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- Fin Modal Edition utilisateur -->	

<!-- Modal suppression utilisateur -->	
	<div class="modal fade" id="Modal_suppr_user" data-backdrop="static" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Suppression (Confirmation)</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<input type="text" class="form-control" id="id" name="id" readonly hidden="true">
							<p>Voulez vous vraiment supprimer cet utilisateur ?</p>
							<label for="peusdo" class="col-form-label">Pseudo :</label>
							<input type="text" class="form-control" id="pseudo" name="pseudo" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
						<button type="submit" class="btn btn-danger" name="btn_suppr_user">Oui</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- Fin Modal suppression utilisateur -->	

<!-- Modal ajout Chaque_cadeau -->	
	<div class="modal fade" id="Modal_add_cadeau" data-backdrop="static" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Creer Cheque Cadeau</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="Numéro Carte" name="num_carte" id="num_carte_rand" readonly>
								<div class="input-group-append">
									<button class="btn btn-outline-secondary" type="button" id="btn_rand">Button</button>
							  	</div>
							</div>
							<label for="montant" class="col-form-label">Montant :</label>
							<input type="text" class="form-control" id="montant" name="montant">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
						<button type="submit" class="btn btn-primary" name="btn_add_cadeau">Créer</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- Fin Modal ajout Cheque_cadeau -->	

<!-- Modal edition Cheque_cadeau -->	
	<div class="modal fade" id="Modal_edit_cadeau" data-backdrop="static" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Modifier Cheque Cadeau</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<label for="num_carte" class="col-form-label">Numéro Carte :</label>
							<input type="text" class="form-control" id="num_carte" name="num_carte" readonly>

							<label for="montant" class="col-form-label">Montant :</label>
							<input type="text" class="form-control" id="montant" name="montant">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
						<button type="submit" class="btn btn-success" name="btn_edit_cadeau">Modifier</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- Fin Modal edition Cheque_cadeau -->	

<!-- Modal suppression utilisateur -->	
	<div class="modal fade" id="Modal_suppr_cadeau" data-backdrop="static" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Supprimer Cheque Cadeau</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<label for="num_carte" class="col-form-label">Numéro Carte :</label>
							<input type="text" class="form-control" id="num_carte" name="num_carte" readonly>
							<p>Voulez vous vraiment supprimer cette Carte Cadeau ?</p>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
						<button type="submit" class="btn btn-danger" name="btn_suppr_cadeau">Oui</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- Fin Modal suppression utilisateur -->	

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>