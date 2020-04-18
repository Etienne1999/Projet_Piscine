<?php 
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include ("database/db_connect.php");	

	//Redirection vers login si pas d'utilisateur connecté
	if (!isset($_SESSION['user_ID'])) {
		header("Location: login.php");
	}

	//Deconnexion
	if (isset($_POST['btn'])) {
		echo "test";
		session_destroy();
		header("Location: index.php");
	}

	//Maj adresse principale utilisateur
	if (isset($_GET['main_adresse'])) {
		$id_adresse = $_GET['main_adresse'];

		//Verification que l'adresse appartient bien a l'utilisateur actuel
		$sql_check = "SELECT ID_User FROM adresse WHERE ID = '$id_adresse'";
		$check = mysqli_query($db_handle, $sql_check);

		if (mysqli_num_rows($check) == 1){
				//Si oui on met a jour l'adresse de l'utilisateur dans la table utilisateur
			$id_user = $_SESSION['user_ID'];
			$sql_update_main_adresse = "UPDATE `utilisateur` SET `Adresse` = '$id_adresse'  WHERE ID = '$id_user'";

			$res = mysqli_query($db_handle, $sql_update_main_adresse);
				//var_dump($res);
		}
	}

	if (isset($_GET['main_carte'])) {
		$hash_carte = $_GET['main_carte'];
		$id = $_SESSION['user_ID'];
		$sql_check = "SELECT Numero_Carte FROM carte_bancaire WHERE ID_User = '$id'";
		$check = mysqli_query($db_handle, $sql_check);

		$num_carte;
		while ($num = mysqli_fetch_assoc($check)) {
			//Teste toutes les carte de l'utilisateur jusqu'a trouver la bonne
			if (md5($num['Numero_Carte']) == $hash_carte)	
				$num_carte = $num['Numero_Carte'];
		}

		//Si on a trouver une carte, on update l'utilisateur
		if (!empty($num_carte)) {
			$sql_update_main_carte = "UPDATE `utilisateur` SET `Carte_Paiement` = '$num_carte'  WHERE ID = '$id'";

			$res = mysqli_query($db_handle, $sql_update_main_carte);
			//var_dump($res);
		}
	}

	//Ajout d'adresse
	if (isset($_POST['btn_add_adresse'])) {
		$id = $_SESSION['user_ID'];
		$ligne_1 = isset($_POST["ligne_1"])? $_POST["ligne_1"] : "";
		$ligne_2 = isset($_POST["ligne_2"])? $_POST["ligne_2"] : "";
		$ville = isset($_POST["ville"])? $_POST["ville"] : "";
		$code_postal = isset($_POST["code_postal"])? $_POST["code_postal"] : "";
		$pays = isset($_POST["pays"])? $_POST["pays"] : "";
		$telephone = isset($_POST["telephone"])? $_POST["telephone"] : "";

		if (!(empty($ligne_1) || empty($ville) || empty($code_postal) || empty($pays) || empty($telephone))) {

			$sql_add_adresse = "INSERT INTO `adresse`(`ID`, `Ligne_1`, `Ligne_2`, `Ville`, `Code_Postal`, `Pays`, `Telephone`, `ID_User`) VALUES (NULL, '$ligne_1', ";

				//Si pas de date d'expiration on envoi NULL
			if (empty($ligne_2))
				$sql_add_adresse .= 'NULL, ';
			else
				$sql_add_adresse .= '$ligne_2, ';

			$sql_add_adresse .= "'$ville', '$code_postal', '$pays', '$telephone', '$id')";

			$res = mysqli_query($db_handle, $sql_add_adresse);
				//var_dump($res);
		}
	}

	//Modification Adresse
	if (isset($_POST['btn_edit_adresse'])) {
		$id = isset($_POST["id"])? $_POST["id"] : "";
		$ligne_1 = isset($_POST["ligne_1"])? $_POST["ligne_1"] : "";
		$ligne_2 = isset($_POST["ligne_2"])? $_POST["ligne_2"] : "";
		$ville = isset($_POST["ville"])? $_POST["ville"] : "";
		$code_postal = isset($_POST["code_postal"])? $_POST["code_postal"] : "";
		$pays = isset($_POST["pays"])? $_POST["pays"] : "";
		$telephone = isset($_POST["telephone"])? $_POST["telephone"] : "";

		if (!(empty($id) || empty($ligne_1) || empty($ville) || empty($code_postal) || empty($pays) || empty($telephone))) {

			$sql_update_adresse = "UPDATE adresse SET Ligne_1 = '$ligne_1', ";
			if (!empty($ligne_2))
				$sql_update_adresse .= "Ligne_2 = '$ligne_2', ";
			else
				$sql_update_adresse .= "Ligne_2 = NULL, ";	
			$sql_update_adresse .= "Ville = '$ville', Code_Postal = '$code_postal', Pays = '$pays', Telephone = '$telephone' WHERE ID = '$id'";

			//echo $sql_update_adresse;
			$res = mysqli_query($db_handle, $sql_update_adresse);

			//var_dump($res);
		}
	}

	//Suppression Adresse
	if (isset($_POST['btn_suppr_adresse'])) {
		$id = isset($_POST["id"])? $_POST["id"] : "";

		$sql_delete_adresse = "DELETE FROM adresse WHERE ID = '$id'";
		$res = mysqli_query($db_handle, $sql_delete_adresse);
		//var_dump($res);
	}

	if (isset($_POST['btn_add_carte'])) {
		$id = $_SESSION['user_ID'];
		$num_carte = isset($_POST["num_carte"])? $_POST["num_carte"] : "";
		$proprietaire = isset($_POST["proprietaire"])? $_POST["proprietaire"] : "";
		$exp_MM = isset($_POST["exp_MM"])? $_POST["exp_MM"] : "";
		$exp_YY = isset($_POST["exp_YY"])? $_POST["exp_YY"] : "";
		$cvv = isset($_POST["cvv"])? $_POST["cvv"] : "";
		$plafond = isset($_POST["plafond"])? $_POST["plafond"] : "";
		$type = isset($_POST["type"])? $_POST["type"] : "";
		$adresse_factu = isset($_POST["adresse_factu"])? $_POST["adresse_factu"] : "";

		//formate la date
		$date_exp = $exp_YY . "-" . $exp_MM . '-01';

		$sql = "INSERT INTO `carte_bancaire` (`Numero_Carte`, `Nom_Proprietaire`, `Date_exp`, `CVV`, `Plafond`, `ID_User`, `Type`, `Adresse_Facturation`) VALUES ('$num_carte', '$proprietaire', '$date_exp', '$cvv', ";
		if (!empty($plafond))
			$sql .= "'$plafond', ";
		else
			$sql .= "NULL, ";
		$sql .= "'$id', '$type', '$adresse_factu')";

		$res = mysqli_query($db_handle, $sql);
		//var_dump($res);
	}

	//Suppression Carte
	if (isset($_POST['btn_suppr_carte'])) {
		$id = isset($_POST["id"])? $_POST["id"] : "";

		$sql_delete_carte = "DELETE FROM carte_bancaire WHERE Numero_Carte = '$id'";
		$res = mysqli_query($db_handle, $sql_delete_carte);
		//var_dump($res);
	}

	if (isset($_POST['info_save_edit'])) {
		$id = $_SESSION['user_ID'];
		$info_nom = isset($_POST["info_nom"])? $_POST["info_nom"] : "";
		$info_prenom = isset($_POST["info_prenom"])? $_POST["info_prenom"] : "";
		$info_password = isset($_POST["info_password"])? $_POST["info_password"] : "";
		$info_email = isset($_POST["info_email"])? $_POST["info_email"] : "";

		if (!(empty($info_nom) || empty($info_prenom) || empty($info_email) || empty($info_password))) {
			//Verifie que l'adresse mail n'est pas deja utilisé par un autre utilisateur
			$sql_check_doublon_mail = "SELECT * FROM utilisateur WHERE Email = '$info_email' AND ID != '$id'";
			$check_result = mysqli_query($db_handle, $sql_check_doublon_mail);

			//Met a jour l'utilisateur
			if (mysqli_num_rows($check_result) == 0){
				$sql_edit_info = "UPDATE `utilisateur` SET `Nom`= '$info_nom',`Prenom`= '$info_prenom',`Password`= '$info_password',`Email`= '$info_email' WHERE id = '$id'";
				$res = mysqli_query($db_handle, $sql_edit_info);
				//var_dump($res);
			}
		}
	}

	function get_info($db_handle) {
		$id = $_SESSION['user_ID'];
		 $sql = "SELECT Nom, Prenom, Pseudo, Email FROM utilisateur WHERE id = '$id'";

		 $result = mysqli_query($db_handle, $sql);

		 while ($data = mysqli_fetch_assoc($result)) {

			echo '<label for="info_pseudo" class="col-form-label">Pseudo :</label>';;
			echo '<input type="text" class="form-control" id="info_pseudo" name="info_pseudo" value="' . $data['Pseudo'] . '" readonly>';
			echo '<label for="info_nom" class="col-form-label">Nom :</label>';
			echo '<input type="text" class="form-control" id="info_nom" name="info_nom" value="' . $data['Nom'] . '" readonly>';
			echo '<label for="info_prenom" class="col-form-label">Prenom :</label>';
			echo '<input type="text" class="form-control" id="info_prenom" name="info_prenom" value="' . $data['Prenom'] . '" readonly>';
			echo '<label for="info_email" class="col-form-label">Email :</label>';
			echo '<input type="email" class="form-control" id="info_email" name="info_email" value="' . $data['Email'] . '" readonly>';
			echo '<label for="info_password" class="col-form-label">Mot de passe :</label>';
			echo '<input type="password" class="form-control" id="info_password" name="info_password" readonly>';
		 }
	}

	function get_adresses($db_handle) {

		$id = $_SESSION['user_ID'];
			//$sql = "SELECT * FROM adresse WHERE ID_User = $id";
		$sql = "SELECT a.*, utilisateur.Adresse FROM adresse AS a, utilisateur WHERE a.ID_User = '$id' AND utilisateur.ID = '$id'";
		$result = mysqli_query($db_handle, $sql);

			//$sql_check_default_adress = "SELECT Adresse FROM utilisateur WHERE ID = '$id'";
			//$default_adress = mysqli_query($db_handle, $sql_check_default_adress);


		while ($data = mysqli_fetch_assoc($result)) {
			echo '<div class="box-adresse mx-2 px-1 border">';
			echo $data['Ligne_1'] . "<br>";
				//Affihce la ligne 2 si elle n'est pas vide
			if (!empty($data['Ligne_2'])) 
				echo $data['Ligne_2'] . "<br>";

			echo $data['Ville'] . "<br>";
			echo $data['Code_Postal'] . "<br>";
			echo $data['Pays'] . "<br>";
			echo $data['Telephone'] . "<br>";
				//Ajoute un saut de ligne si pas de ligne 2 (pour garder les boutons a la 7eme ligne)
			if (empty($data['Ligne_2'])) 
				echo "<br>";
			echo "<span>";
				//Bouton modifier
			echo "<a data-target='#Modal_edit_adresse' data-toggle='modal'";
			echo ' data-id="' . $data['ID'] . '"';
			echo ' data-ligne_1="' . $data['Ligne_1'] . '"';
			echo ' data-ligne_2="' . $data['Ligne_2'] . '"';
			echo ' data-ville="' . $data['Ville'] . '"';
			echo ' data-code_postal="' . $data['Code_Postal'] . '"';
			echo ' data-pays="' . $data['Pays'] . '"';
			echo ' data-telephone="' . $data['Telephone'] . '"';
			echo " href='#''>Modifier</a>";
				//bouton suppr
			echo " | <a data-target='#Modal_suppr_adresse' data-toggle='modal'";
			echo ' data-id="' . $data['ID'] . '"';
			echo ' data-ligne_1="' . $data['Ligne_1'] . '"';
			echo ' data-ligne_2="' . $data['Ligne_2'] . '"';
			echo ' data-ville="' . $data['Ville'] . '"';
			echo ' data-code_postal="' . $data['Code_Postal'] . '"';
			echo ' data-pays="' . $data['Pays'] . '"';
			echo ' data-telephone="' . $data['Telephone'] . '"';
			echo "  href='#''>Effacer</a>";
				//Affiche bouton set default si pas deja default
			if ($data['Adresse'] != $data['ID'])
				echo " | <a href='?main_adresse=" . $data['ID'] . "'>Définir par défaut</a>";
			echo "</span><br>";
			echo '</div>';
		}
	}

	function get_credit_card ($db_handle) {
		$id = $_SESSION['user_ID'];
		$sql = "SELECT c.*, utilisateur.Carte_Paiement, type_carte.Nom, a.* FROM carte_bancaire AS c, utilisateur, type_carte, adresse AS a WHERE type_carte.ID = c.Type AND c.Adresse_Facturation = a.ID AND c.ID_User = '$id' AND utilisateur.ID = '$id'";
		$result = mysqli_query($db_handle, $sql);

		while ($data = mysqli_fetch_assoc($result)) {

			$num_carte_confidentiel = substr_replace($data['Numero_Carte'], '***-', 0, -4);
			if ($data['Numero_Carte'] != $data['Carte_Paiement']){
				echo '<div class="card mb-1 mr-1"><div class="card-header"><h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#cc' . $data['Numero_Carte'] . '">';
				echo $data['Nom'] . " : " . $num_carte_confidentiel;
				echo '</button></h5></div><div id="cc' . $data['Numero_Carte'] . '" class="collapse"><div class="card-body">';
				echo 'Proprietaire : ' . $data['Nom_Proprietaire'] . '<br>';
				echo 'Expire le : ' . $data['Date_exp'] . '<br>';
				if (empty($data['Plafond']))
					echo 'Plafond maximum de : Pas de plafond<br>';
				else
					echo 'Plafond maximum de : ' . $data['Plafond'] . '<br>';
				echo '<br><u>Adresse de facturation</u> : <br>';
				echo $data['Ligne_1'] . '<br>';
				if (!empty($data['Ligne_2']))
					echo $data['Ligne_2'] . '<br>';
				echo $data['Ville'] . ', ' . $data['Code_Postal'] . '<br>';
				echo $data['Pays'] . '<br>';
				echo $data['Telephone'] . '<br><br>';
	
				echo "<span>";
				//bouton suppr
				echo "<a data-target='#Modal_suppr_carte' data-toggle='modal'";
				echo ' data-id="' . $data['Numero_Carte'] . '"';
				echo ' data-num_cache="' . $num_carte_confidentiel . '"';
				echo ' data-type="' . $data['Nom'] . '"';
				echo "  href='#''>Effacer</a>";
				//Bouton modifier
				/*
				echo " | <a data-target='#Modal_edit_carte' data-toggle='modal'";
				echo ' data-id="' . $data['Numero_Carte'] . '"';
				echo ' data-num_cache="' . $num_carte_confidentiel . '"';
				echo ' data-proprietaire="' . $data['Nom_Proprietaire'] . '"';
				echo ' data-date_exp="' . $data['Date_exp'] . '"';
				echo " href='#''>Modifier</a>";
				*/
				echo " | <a href='?main_carte=" .md5($data['Numero_Carte']) . "'>Définir par défaut</a>";
				echo "</span>";
	
				echo '</div></div></div>';
			}
		}
	}

	function get_default_card ($db_handle) {
		$id = $_SESSION['user_ID'];

		$sql = "SELECT c.*, type_carte.Nom, a.* FROM carte_bancaire AS c, utilisateur, type_carte, adresse AS a WHERE type_carte.ID = c.Type AND c.Adresse_Facturation = a.ID AND utilisateur.ID = '$id' AND c.Numero_Carte = utilisateur.Carte_Paiement";
		$result = mysqli_query($db_handle, $sql);

		if (mysqli_num_rows($result)) {
			
			while ($data = mysqli_fetch_assoc($result)) {

				$num_carte_confidentiel = substr_replace($data['Numero_Carte'], '***-', 0, -4);

				echo '<div class="card mb-1 mr-1"><div class="card-header"><h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#default_card">';
				echo $data['Nom'] . " : " . $num_carte_confidentiel . '</button><span>-----</span><a data-target="#Modal_add_carte" data-toggle="modal" href="#" class="font-weight-light add_carte">Ajouter nouvelle Carte</a></h5></div><div id="default_card" class="collapse"><div class="card-body">';
			echo 'Proprietaire : ' . $data['Nom_Proprietaire'] . '<br>';
			echo 'Expire le : ' . $data['Date_exp'] . '<br>';
			if (empty($data['Plafond']))
				echo 'Plafond maximum de : Pas de plafond<br>';
			else
				echo 'Plafond maximum de : ' . $data['Plafond'] . '<br>';
			echo '<br><u>Adresse de facturation</u> : <br>';
			echo $data['Ligne_1'] . '<br>';
			if (!empty($data['Ligne_2']))
				echo $data['Ligne_2'] . '<br>';
			echo $data['Ville'] . ', ' . $data['Code_Postal'] . '<br>';
			echo $data['Pays'] . '<br>';
			echo $data['Telephone'] . '<br><br>';

			echo "<span>";
			//bouton suppr
			echo "<a data-target='#Modal_suppr_carte' data-toggle='modal'";
			echo ' data-id="' . $data['Numero_Carte'] . '"';
			echo ' data-num_cache="' . $num_carte_confidentiel . '"';
			echo ' data-type="' . $data['Nom'] . '"';
			echo "  href='#''>Effacer</a>";
			echo "</span><br>";
			echo '</div></div></div>';
			}
		}
		else {
		echo '<div class="card mb-1 mr-1">
				<div class="card-header">
					<h5 class="mb-0">
						<button class="btn btn-link" data-toggle="collapse" data-target="#default_card"></button>
						<span>-----</span>
						<a data-target="#Modal_add_carte" data-toggle="modal" href="#" class="font-weight-light add_carte">Ajouter nouvelle Carte de paiement</a>
					</h5>
				</div>
				<div id="default_card" class="collapse">
					<div class="card-body">
						Pas de carte
					</div>
				</div>
			</div>';
		}


	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Mon Compte</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script type="text/javascript" src="mon_compte.js"></script>

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="mon_compte.css">

</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>


	<!-- Header -->
	<header>
		
	</header>
	<!-- Conteneur -->

	<?php include("modal/modal_adresse.php") ?>
	<?php include("modal/modal_carte_credit.php") ?>

	<div class="container-fluid">
		<div class="row no-gutters">
			<div class="col-md-4" style="background-color: red">
				<span>d</span>
			</div>
			<div class="col-md-8" style="background-color: blue">
				<span>d</span>
			</div>
		</div>
	</div>
	<div class="container">
		<h3>Mes informations</h3>
		<div class="row d-flex justify-content-center">
			<div class="col-md-5 border shadow m-2 cat">
				<h4>Mes adresses</h4>
				<div class="container_adresses my-1 py-1">
					<div class="box-adresse mx-2 px-1 border">
						<span hidden>Ligne_1</span><br>
						<span hidden>Ligne_2</span><br>
						<span hidden>Ville</span><br>
						<span><a data-target="#Modal_add_adresse" data-toggle="modal" href="#">Ajouter nouvelle adresse</a></span><br>
						<span hidden>Pays</span><br>
						<span hidden>Telephone</span><br>
						<span hidden>Actions</span><br>
					</div>
					<?php get_adresses($db_handle); ?>
				</div>

			</div>
			<div class="col-md-5 border shadow m-2 cat">
				<h4>Moyen de paiement</h4>
				<div id="accordeon_paiement">
					
					<?php get_default_card($db_handle); ?>
					<?php get_credit_card($db_handle); ?>
				</div>
			</div>
		</div>

		<div class="row d-flex justify-content-center">
			<div class="col-md-5 border shadow m-2 cat">
				<h4>Info perso</h4>
				<div>
					<form method="post">
						<?php get_info($db_handle); ?>
						<div class="my-3">
							<button type="button" class="btn btn-success" id="info_edit">Modifier</button>
							<button type="submit" class="btn btn-primary" id="info_save_edit" name="info_save_edit" hidden>Enregistrer</button>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-5 border shadow m-2 cat">
				<h4>Mes commandes</h4>
				<span>d</span>
			</div>
		</div>

		<div class="row d-flex justify-content-center">
			<div class="col-md-5 border shadow m-2 cat">
				<h4>Mes Enchères</h4>
				<span>d</span>
			</div>
			<div class="col-md-5 border shadow m-2 cat">
				<h4>Mes Offres d'achat</h4>
				<span>d</span>
			</div>
		</div>

		<div class="row d-flex justify-content-center">
			<div class="col-md-5 border shadow m-2 cat">
				<h4>Offrir cheque cadeau</h4>
				<span>d</span>
			</div>
			<div class="col-md-5 border shadow m-2 cat">
				<h4> ??? </h4>
				<span>d</span>
			</div>
		</div>
	</div>

	<form method="post">
		<button class="btn btn-primary btn-block" type="submit" name="btn">Se déconnecter</button>
	</form>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>