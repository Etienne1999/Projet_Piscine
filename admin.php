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

		$sql = "SELECT u.Nom, u.Prenom, u.Pseudo, u.Email, Role.Nom AS Role, COUNT(produit.ID) AS Nb_Vente
		FROM utilisateur AS u
		LEFT JOIN role ON u.Role = Role.ID
		LEFT JOIN produit ON u.ID = produit.Vendeur
		GROUP BY u.Pseudo";

		$result = mysqli_query($db_handle, $sql);	

		return $result;
	}

	//Affiche les utilisateurs et leur données
	function afficher_users($list_users){		
		while ($data = mysqli_fetch_assoc($list_users)) {
			echo '<tr>';
			echo '	<td>' . $data['Pseudo'] . '</td>';
			echo '	<td>' . $data['Role'] . '</td>';
			echo ' 	<td colspan="2"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#Modal_edit"';
			echo ' data-nom="' . $data['Nom'] . '"';
			echo ' data-prenom="' . $data['Prenom'] . '"';
			echo ' data-pseudo="' . $data['Pseudo'] . '"';
			echo ' data-email="' . $data['Email'] . '"';
			echo ' data-vente="' . $data['Nb_Vente'] . '"';
			echo '">Edit</button>';


			//echo ' 	<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Delete</button></td>';
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
	<link rel="stylesheet" type="text/css" href="admin.css">

	<script type="text/javascript">

		$(document).ready(function () {

			//Inspiré de https://getbootstrap.com/docs/4.4/components/modal/
			$('#Modal_edit').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				//Recupere les données de l'utilisateur a editer
				var nom = button.data('nom')
				var prenom = button.data('prenom')
				var pseudo = button.data('pseudo')
				var email = button.data('email')
				var vente = button.data('vente')
				var modal = $(this)
				//Rempli le modal avec les données approprié
				modal.find('.modal-title').text('Utilisateur : ' + pseudo)
				modal.find('.modal-body #nom').val(nom)
				modal.find('.modal-body #prenom').val(prenom)
				modal.find('.modal-body #pseudo').val(pseudo)
				modal.find('.modal-body #email').val(email)
				modal.find('.modal-body #vente').val(vente)
				modal.find('.modal-body #vendu').val(vente)


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
					<div class="tab-pane fade" id="list-profile" role="tabpanel">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
					<div class="tab-pane fade" id="list-messages" role="tabpanel">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="Modal_edit" data-backdrop="static" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">New message</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="nom" class="col-form-label">Nom :</label>
							<input type="text" class="form-control" id="nom" readonly>

							<label for="prenom" class="col-form-label">Prénom :</label>
							<input type="text" class="form-control" id="prenom" readonly>
						</div>
						<div class="form-group">
							<label for="peusdo" class="col-form-label">Pseudo :</label>
							<input type="text" class="form-control" id="pseudo">

							<label for="email" class="col-form-label">Email :</label>
							<input type="text" class="form-control" id="email">

							<label for="role" class="col-form-label">Role :</label>
							<select class="form-control" id="role">
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
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
					<button type="button" class="btn btn-primary">Enregistrer</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>