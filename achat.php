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
	<link rel="icon" href='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22> <text y=".9em" font-size="90">💩</text></svg>'>

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/achat.css">
	<link rel="stylesheet" type="text/css" href="css/bs.css">

</head>
<body>
	<!-- Navbar -->
	<?php include("nav.php") ?>

	<!-- Conteneur -->
	<div class="container">		
		<!-- Premier affichage -->
		<h1> ECE EBAY </h1>
		<div class="row">
		  <div class="col-md-3">
		  <div class="left_col_achat" style="border-radius: 3% 3%;">
				<h4 class="container"> Filtrez selon : </h4>
				<div class="rechercheVendeur" style="border-radius: 2% 2%;">
					<form action="achat.php" method="post">
						<p><input type="text" id="rechercheVendeur "name="rechercheVendeur" placeholder="Chercher un vendeur "></p>
						<div >
							<input type="submit" value="La loupe" id="button" />
						</div>
					</form>
				</div>
				<div class="container check_checkbox" style="border-radius: 1% 1%; margin-right: 10px;">
					<form action="achat.php" method="post">
						<!-- SELECTEUR EN FONCTION DE L'URL -->
						<?php 
							// Selecteur categorie / Ferraille ou Trésor
							if (isset($_GET['Check']) AND $_GET['Check']== "Fer")	 
							{echo <<<Case
							<p><label> Ferraille ou Trésor: </label><input type="checkbox" name="Check_Ferraille" id="Check_Ferraille" checked></p> 
							Case;}
							else {
								echo <<<Case
								<p><label> Ferraille ou Trésor: </label><input type="checkbox" name="Check_Ferraille" id="Check_Ferraille" ></p> 
							Case;}


							// Selecteur categorie / Bon pour le musee
							if (isset($_GET['Check']) AND $_GET['Check']== "Musee")	 
							{echo <<<Case
							<p><label> Bon pour le musée : </label><input type="checkbox" name="Check_Musée" id="Check_Musée" checked></p>
							Case;}
							else {
								echo <<<Case
								<p><label> Bon pour le musée : </label><input type="checkbox" name="Check_Musée" id="Check_Musée" ></p>  
								Case;}
							

							// Selecteur categorie / Accessoire VIP
							if (isset($_GET['Check']) AND $_GET['Check']== "Vip")	 
							{echo <<<Case
								<p><label> Accessoire VIP : </label><input type="checkbox" name="Check_VIP" id="Check_VIP" checked></p>

							Case;}
							else {
								echo <<<Case
								<p><label> Accessoire VIP : </label><input type="checkbox" name="Check_VIP" id="Check_VIP" ></p> 
								Case;}

							
							// Selecteur type d'achat / Enchere
							if (isset($_GET['Check']) AND $_GET['Check']== "Encheres")	 
							{echo <<<Case
								<p><label> Enchere : </label><input type="checkbox" name="Check_enchere" id="Check_enchere" checked></p>

							Case;}
							else {
								echo <<<Case
								<p><label> Enchere : </label><input type="checkbox" name="Check_enchere" id="Check_enchere"></p> 
								Case;}


								// Selecteur type d'achat / Meilleur_offre
							if (isset($_GET['Check']) AND $_GET['Check']== "Meilleure_offre")	 
							{echo <<<Case
								<p><label> Meilleure Offre : </label><input type="checkbox" name="Check_meilleur_offre" id="Check_meilleur_offre" checked></p>

							Case;}
							else {
								echo <<<Case
								<p><label> Meilleure Offre : </label><input type="checkbox" name="Check_meilleur_offre" id="Check_meilleur_offre"></p> 
								Case;}
							

								// Selecteur type d'achat / Achat immediat
							if (isset($_GET['Check']) AND $_GET['Check']== "Achat_immediat")	 
							{echo <<<Case
								<p><label> Achat immédiat : </label><input type="checkbox" name="Check_achat_im" id="Check_achat_im" checked></p>

							Case;}
							else {
								echo <<<Case
								<p><label> Achat immédiat : </label><input type="checkbox" name="Check_achat_im" id="Check_achat_im"></p>
								Case;}
							?>
					
						<input type="submit" value="Valider les choix" id="button" /><br>
					</form>
				</div>
		  </div>
		  </div>





		  <div class="col-md-9">
			<!-- FILTRAGE -->
			

			<!-- Affichage selon le filtre -->
			<div class="achat_objet_listening container"> <div class="card card-title col-md-8 container" style=" border: 2px solid;"> Liste des objets en Vente : </div> 
				<?php
				
				$check_vendeur = isset($_POST["rechercheVendeur"])? $_POST["rechercheVendeur"] : "";
	
				if ($db_found) 
					{	
						// TESTER La recherche
						if ($check_vendeur != '') {
							$sql =" SELECT produit.* , utilisateur.Pseudo, img_produit.URL FROM produit 
							LEFT JOIN utilisateur on utilisateur.ID = produit.Vendeur 
							LEFT JOIN img_produit on img_produit.Produit=produit.ID  
							WHERE utilisateur.ID = produit.Vendeur AND utilisateur.Pseudo LIKE '%$check_vendeur%' AND Vendu = 0 AND img_produit.URL LIKE './img/0%'";
							
							$result = mysqli_query($db_handle, $sql);
							if ($result != NULL) {					
								while ($data = mysqli_fetch_assoc($result)) {
									?>
									<div class="container" id="affichage">
							  	<div class="card container" style="margin-top: 20px; max-width: 600px; padding-top: 10px;  ">
								  	<img class="card-img-top" src="<?php echo $data['URL']?>" alt="Card image"   height="450">
								  	<div class="card-body">
								    	<h4 class="card-title"><?php echo $data['ID'] . ". ". $data['Nom'];?></h4>
								    	<h6> 	<?php 	echo "Disponible :";
								    					if ($data['Prix_Achat'] > 0){ echo " -  à l'achat immediat  <br>";}
														if ($data['Prix_Enchere'] > 0){ echo " -  à l'enchere  <br>";}
														if ($data['Prix_min'] > 0){ echo " -  à l'achat par meilleur offre  ";}	 ?> </h6>
								    	<p class="card-text"> <?php echo $data['Description'] . " au prix de ". $data['Prix_Achat'] . ". Cet article est proposé par : ". $data['Pseudo'] ; ?> </p>
								    	<a href="affichage_achat.php?id=<?php echo $data['ID'] ?>" class="btn btn-primary"> Achetez-le </a>
								  </div>
								</div>
							</div> <?php	
								}							
							}
						}
						
						// Tester les checkbox
						else{
							$sql = " SELECT produit.* , utilisateur.Pseudo, img_produit.URL FROM produit 
							LEFT JOIN utilisateur on utilisateur.ID = produit.Vendeur 
							LEFT JOIN img_produit on img_produit.Produit=produit.ID  WHERE produit.ID != 0  AND Vendu = 0 AND img_produit.URL LIKE './img/0%'";
							$test = 0;
							$test2 = 0;

							if ((isset($_POST["Check_Ferraille"])) OR (isset($_POST["Check_Musée"])) OR (isset($_POST["Check_VIP"])) OR (isset($_POST["Check_enchere"])) OR (isset($_POST["Check_achat_im"])) OR (isset($_POST["Check_meilleur_offre"])))
							{
								$sql .= " AND ";
							}

							//CHOIX FERRAILLE
							if (isset($_POST["Check_Ferraille"])) 
							{
  								if ($test ==1)
  								{
  									$sql .= "OR ";
  									$test = 0;
  								}
  								$sql .= " produit.Categorie = 1 ";
  								$test ++;
  								$test2 =1;
  							}

  							//CHOIX MUSEE
							if (isset($_POST["Check_Musée"])) 
							{
  								if ($test ==1)
  								{
  									$sql .= "OR ";
  									$test = 0;
  								}
  								$sql .= " produit.Categorie = 2 ";
  								$test ++;
  								$test2 =1;
  							}

  							//CHOIX VIP
							if (isset($_POST["Check_VIP"])) 
							{
  								if ($test ==1)
  								{
  									$sql .= "OR ";
  									$test = 0;
  								}
  								$sql .= " produit.Categorie = 3 ";
  								$test ++;
  								$test2 =1;
  							}
  							
  							//CHOIX Enchere
							if (isset($_POST["Check_enchere"])) 
							{
								if ($test2 ==1)
								{
									$sql .= " AND ( ";
									$test2 = 2;
								}

  								if (($test ==1) AND ($test2 != 2))
  								{
  									$sql .= "OR ";
  									$test = 0;
  								}
  								$sql .= " produit.Prix_Enchere > 0 ";
  								$test ++;
  								if ($test2 ==2)
								{
									$test2 = 3;
									$test =1;
								}
  								
  							}

  							//CHOIX Enchere
							if (isset($_POST["Check_achat_im"])) 
							{
								if ($test2 ==1)
								{
									$sql .= " AND ( ";
									$test2 = 2;
								}

  								if (($test ==1) AND ($test2 != 2))
  								{
  									$sql .= "OR ";
  									$test = 0;
  								}
  								$sql .= " produit.Prix_Achat > 0 ";
  								$test ++;
  								if ($test2 ==2)
								{
									$test2 = 3;
								}
  								
  							}


  							//CHOIX Enchere
							if (isset($_POST["Check_meilleur_offre"])) 
							{
								if ($test2 ==1)
								{
									$sql .= " AND ( ";
									$test2 = 2;
								}

  								if (($test ==1) AND ($test2 != 2))
  								{
  									$sql .= "OR ";
  									$test = 0;
  								}
  								$sql .= " produit.Prix_min > 0 ";
  								$test ++;
  								if ($test2 ==2)
								{
									$test2 = 3;
								}
  								
  							}


  							if ($test2 == 3) { 	//TEST POUR FINIR LA REQUETE SQL 
  								$sql .= " ) ";}
  							
  							
  							$result = mysqli_query($db_handle, $sql);  						
						}
					}//end if

					if ($result != NULL) {	
						while ($data = mysqli_fetch_assoc($result))
						 {
						 ?>								
							<div class="container" id="affichage">
							  	<div class="card container" style="margin-top: 20px; max-width: 600px; padding-top: 10px;  ">
								  	<img class="card-img-top" src="<?php echo $data['URL']?>" alt="Card image"   height="450">
								  	<div class="card-body">
								    	<h4 class="card-title"><?php echo $data['ID'] . ". ". $data['Nom'];?></h4>
								    	<h6> 	<?php 	echo "Disponible :";
								    					if ($data['Prix_Achat'] > 0){ echo " -  à l'achat immediat  <br>";}
														if ($data['Prix_Enchere'] > 0){ echo " -  à l'enchere  <br>";}
														if ($data['Prix_min'] > 0){ echo " -  à l'achat par meilleur offre  ";}	 ?> </h6>
								    	<p class="card-text"> <?php echo $data['Description'] . " au prix de ". $data['Prix_Achat'] . ". Cet article est proposé par : ". $data['Pseudo'] ; ?> </p>
								    	<a href="affichage_achat.php?id=<?php echo $data['ID'] ?>" class="btn btn-primary"> Achetez-le </a>
								  </div>
								</div>
							</div>
							
						<?php	
						}
					}	
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
