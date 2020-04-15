<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include ("database/db_connect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Acheter</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="achat.css">

</head>

<body>
	
	<!-- Navbar -->
	<?php include("nav.php") ?>

	<!-- Conteneur -->
	<div class="container-fluid">
		
			<!-- Premier affichage -->
			<h1> ECE EBAY </h1>
		<div class="row">
		  <div class="col-md-3">
		  <div class="left_col_achat">
				<h2> Filtrer </h2>
				<div class="rechercheVendeur">
					<form action="achat.php" method="post">
						<p><input type="text" id="rechercheVendeur "name="rechercheVendeur" placeholder="Chercher un vendeur "></p>
						<div >
							<input type="submit" value="La loupe" id="button" />
						</div>
					</form>
				</div>
				<div class="check_checkbox">
					<form action="achat.php" method="post">
						<p><label> Ferraille ou Trésor: </label><input type="checkbox" name="Check_Ferraille" id="Check_Ferraille"></p>
						<p><label> Bon pour le musée : </label><input type="checkbox" name="Check_Musée" id="Check_Musée" ></p>
						<p><label> Accessoire VIP : </label><input type="checkbox" name="Check_VIP" id="Check_VIP"></p>
						<p><label> Enchere : </label><input type="checkbox" name="Check_enchere" id="Check_enchere"></p>
						<p><label> Meilleure Offre : </label><input type="checkbox" name="Check_meilleur_offre" id="Check_meilleur_offre"></p>
						<p><label> Achat immédiat : </label><input type="checkbox" name="Check_achat_im" id="Check_achat_im"></p>
						<input type="submit" value="Valider les choix" id="button" />
					</form>
				</div>
		  </div>
		  </div>





		  <div class="col-md-9">
			<!-- FILTRAGE -->
			

			<!-- Affichage selon le filtre -->
			<div class="achat_objet_listening">
				<?php
				
				$check_vendeur = isset($_POST["rechercheVendeur"])? $_POST["rechercheVendeur"] : "";
	
				if ($db_found) 
					{	
						// TESTER La recherche
						if ($check_vendeur != '') {
							$sql ="SELECT DISTINCT p.* FROM produit AS p, utilisateur WHERE utilisateur.ID = p.Vendeur AND utilisateur.Pseudo LIKE '%$check_vendeur%'";
							$result = mysqli_query($db_handle, $sql);

							if ($result != NULL) {					
								while ($data = mysqli_fetch_assoc($result)) {
									
									echo "ID: " . $data['ID'] . '<br>';
									echo "Nom:" . $data['Nom'] .'<br>';
									echo "prix: " . $data['Prix_Achat'] . '<br>';	
								}							
							}
						}
						
						// Tester les checkbox
						else{
							$sql = "SELECT * FROM produit WHERE ID != 0 AND";
							$test = 0;

							//CHOIX FERRAILLE
							if (isset($_POST["Check_Ferraille"])) 
							{
  								if ($test ==1)
  								{
  									$sql .= "OR ";
  									$test = 0;
  								}
  								$sql .= " Categorie = 1 ";
  								$test ++;
  							}

  							//CHOIX MUSEE
							if (isset($_POST["Check_Musée"])) 
							{
  								if ($test ==1)
  								{
  									$sql .= "OR ";
  									$test = 0;
  								}
  								$sql .= " Categorie = 2 ";
  								$test ++;
  							}

  							//CHOIX VIP
							if (isset($_POST["Check_VIP"])) 
							{
  								if ($test ==1)
  								{
  									$sql .= "OR ";
  									$test = 0;
  								}
  								$sql .= " Categorie = 3 ";
  								$test ++;
  							}


  							$result = mysqli_query($db_handle, $sql);
  							if ($result != NULL) {	
							while ($data = mysqli_fetch_assoc($result)) {
								echo "ID: " . $data['ID'] . '<br>';
								echo "Nom:" . $data['Nom'] .'<br>';
								echo "prix: " . $data['Prix_Achat'] . '<br>';
							}
							}
						}
					}//end if

				?>

			</div>
		  </div>
		</div>	<!-- Tableau deroulant --> 




			<br><br><br><br>
		
	</div>

	<!-- Footer : contact -->	
	<?php include("footer.php") ?>
</body>
</html>