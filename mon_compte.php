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

	if (isset($_POST['btn_suppr_adresse'])) {
		$id = isset($_POST["id"])? $_POST["id"] : "";

		$sql_delete_adresse = "DELETE FROM adresse WHERE ID = '$id'";
		$res = mysqli_query($db_handle, $sql_delete_adresse);
		//var_dump($res);
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
				<span>d</span>
			</div>
		</div>

		<div class="row d-flex justify-content-center">
			<div class="col-md-5 border shadow m-2 cat">
				<h4>Info perso</h4>
				<span>d</span>
			</div>
			<div class="col-md-5 border shadow m-2 cat">
				<h4>Offrir cheque cadeau</h4>
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
				<h4>Mes commandes</h4>
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