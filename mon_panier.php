<?php 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include ("database/db_connect.php");

//Redirection vers login si pas d'utilisateur connecté
    if (!isset($_SESSION['user_ID'])) 
    {
        header("Location: login.php");
    }

    //Refresh la page apres avoir vider le panier
    if (isset($_GET['suppri']) && $_GET['suppri'] == 'boom'){
    	unset($_SESSION['panier']); 
		$_SESSION['panier'] = array();	
    	header("Location: mon_panier.php");
    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Panier</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bs.css">
	<script type="text/javascript">
		
	</script>
</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>


	<!-- Header -->
	<header>
		
	</header>
	<!-- Conteneur -->

	<div class="container" style="margin-bottom: 50px" >
		<?php
			$id = $_SESSION['user_ID'];
    $sql = "SELECT Adresse, Carte_Paiement FROM utilisateur WHERE ID = '$id'";
    $res = mysqli_query($db_handle, $sql);
    $data = mysqli_fetch_assoc($res);
    if ($data['Adresse'] == NULL) {
    	echo '<div class="card" style="margin-top: 20px; border: 2px solid;">
			<div class="card-body">Vous devez ajouter une adresse de livraison par defaut sur la page <a href="mon_compte.php">mon compte</a><br>
		</div></div>';
    }
    if ($data['Carte_Paiement'] == NULL) {
    	echo '<div class="card" style="margin-top: 20px; border: 2px solid;">
			<div class="card-body">Vous devez ajouter un moyen de paiement par defaut sur la page <a href="mon_compte.php">mon compte</a><br></div></div>';
    } 
		if(isset($_SESSION['user_ID']) && !empty($_SESSION['panier'])){
			foreach ($_SESSION['panier']as $pine) {
				$sql = "SELECT DISTINCT produit.* , utilisateur.Pseudo FROM produit JOIN utilisateur on utilisateur.ID = produit.Vendeur WHERE produit.ID like '$pine'  ";
				$result = mysqli_query($db_handle, $sql);
				if ($result != NULL) 
				{	
					while ($data = mysqli_fetch_assoc($result))
					{     	?> 
						<div class="card" style="margin-top: 20px; border: 2px solid;">
							<div class="card-header"><?php echo  $data['ID'] . ". ". $data['Nom']; $produit = $data['ID'];?></div>
							<div class="card-body"><?php echo $data['Description'] . " au prix de ". $data['Prix_Achat'] . " euros.<br> Cet article est proposé par : ". $data['Pseudo'] ; ?> </div>

							
						</div>


						<?php 
					}
						
						

				}
			}
				?>	<br><a class="btn btn-danger btn-block is-invalid" href="mon_panier.php?suppri=boom" style="margin-bottom : 10px" onclick="" > Vider le panier</a>
				<a class="btn btn-success btn-block is-invalid" style="margin: 0 auto" href="commande.php" > Acceder au paiement </a></div>
				<?php

		} else  { ?> <div class="card-header" style="margin-bottom: 15px; margin-top: 15px; border: 2px solid; border-radius: 5px;"><?php echo  "Vous n'avez pas d'article " ?></div> <?php } ?>
	</div>		

		<!-- Footer -->	
		<?php include("footer.php") ?>
	</body>
	</html>