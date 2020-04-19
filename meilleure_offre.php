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
	<title>Meilleure offre</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
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
		<div class="container" style="margin-bottom: 50px">
		<?php
		
					if ($db_found) 
				{
				$id = $_GET['id'];
				$data2 = $data3 = $data4 = 0;

				$sql = "SELECT  produit.* , utilisateur.Pseudo FROM produit JOIN utilisateur on utilisateur.ID = produit.Vendeur WHERE produit.ID like '$id'  ";
				
				$result = mysqli_query($db_handle, $sql);
				if ($result != NULL) {	
					while ($data = mysqli_fetch_assoc($result))
					 { //Affichage   	?>
					<div class="container card">
						<h3 class="card-title" style="margin : 0 auto;margin-top: 10px; margin-bottom: 10px;"> ACHAT PAR MEILLEURE OFFRE :</h3>
						<div class="carousel slide" data-ride="carousel" id="carousel-1">
					    <div class="carousel-inner" role="listbox">
					        <div class="carousel-item active"><img class="w-100 d-block" src="img/france1.jpg" alt="Slide Image" /></div>
					        <div class="carousel-item"><img class="w-100 d-block" src="img/france2.jpg" alt="Slide Image" /></div>
					        <div class="carousel-item"><img class="w-100 d-block" src="img/france4.jpg" alt="Slide Image" /></div>
					        <div class="carousel-item"><img class="w-100 d-block" src="img/france5.jpg" alt="Slide Image" /></div>
					        <div class="carousel-item"><img class="w-100 d-block" src="img/france6.jpg" alt="Slide Image" /></div>
					        <div class="carousel-item"><img class="w-100 d-block" src="img/france7.jpg" alt="Slide Image" /></div>
					    </div>
					    <ol class="carousel-indicators">
					        <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
					        <li data-target="#carousel-1" data-slide-to="1"></li>
					        <li data-target="#carousel-1" data-slide-to="2"></li>
					        <li data-target="#carousel-1" data-slide-to="3"></li>
					        <li data-target="#carousel-1" data-slide-to="4"></li>
					        <li data-target="#carousel-1" data-slide-to="5"></li>
					    </ol>
						</div>
						<div class="card" style="margin-top: 10px; margin-bottom: 10px; padding: 10px">
								<h4 class="card-title"><?php echo " Achat à l'enchère de : " . $data['Nom']; $produit = $data['ID'];?></h4>
								<p class="card-text"> <?php echo $data['Description'] . " au prix de ". $data['Prix_min'] ." euros". ". Cet article est proposé par : ". $data['Pseudo']; ?> </p>
								

								<?php // Test si l'article est en enchere uniquement ou en achat immédiat egalement : differe l'affichage 
								if ($data['Prix_Achat']>0)
								{
									$prix_max =$data['Prix_Achat'];
									?><p class="card-text"> <?php echo "Le prix minimun pour cet article est de " . $data['Prix_min'] ." euros". ". Au dela de ". $prix_max . " euros : Veuillez achetez cet article en achat immédiat.	" ?> </p> <?php
								}
								else
								{
									$prix_max = 100000000000;
								}
								
								
								?>
								<form action="meilleure_offre.php?id=<?php echo $data['ID'] ?>" method="post">
									<p> Voulez vous emmetre une offre : <input type="number" min="<?php echo $data['Prix_min'] ?>" max ="<?php echo $prix_max ?>" name="nombre" id="nombre" /></p>
									<p><label>Notez bien que si vous faites une offre sur un article, vous êtes sous contrat légal pour l'acheter si le vendeur accepte l'offre. :  </label><input type="checkbox" name="devenir" id="devenir" required=""></p>
									<input type="submit" class="btn btn-info btn-block is-invalid" value="Valider l'offre" id="button" /><br>
								</form>
								<?php 


								if (isset($_POST["nombre"])) // Envoie de l'offre
								{ 
									$Nb = $_POST["nombre"];
									$id_ses = $_SESSION['user_ID'];
									$id_obj = $data['ID'];
									$compt = 0;
									$sql_offre = "SELECT * FROM offre_achat WHERE Acheteur = $id_ses AND Produit = $id_obj ";
									$resultOffre = mysqli_query($db_handle, $sql_offre);
									
									if ($resultOffre!= NULL)
									{	
										while ($data_offre = mysqli_fetch_assoc($resultOffre))
										{ ?> <button class="btn btn-danger btn-block is-invalid" > Vous avez déjà fait une offre : allez voir dans votre compte.</button> <?php $compt ++;}
									}
									if ($compt ==0)
									{
										if (($Nb >=$data['Prix_min'])AND($Nb <= $prix_max))
										 {
											$sql_creat="INSERT INTO offre_achat(Produit, Acheteur, Offre, Contre_Offre, Statut, Tentative) VALUES('$produit', '$id_ses', '$Nb','0','0','1')";
											mysqli_query($db_handle,$sql_creat);
											?> <button class="btn btn-success btn-block is-invalid" > Votre offre a bien été prise en compte.</button> <?php
										}
										else
										{
											?> <button class="btn btn-danger btn-block is-invalid" > Selectionner un montant valable.</button> <?php
										}
										
									}

								/*	
									$Nb=$_POST["nombre"];
									$Id_util =$_SESSION['user_ID'];
									$sql1 = "INSERT INTO enchere(Objet, Acheteur, Prix) VALUES('$produit', '$Id_util', '$Nb')";
									mysqli_query($db_handle,$sql1);
								*/	
								}
									?>
						</div>
					</div>			    	
				<?php }}
			}
			?>

		 
		</div>
		<!-- Footer -->	
		<?php include("footer.php") ?>
	</body>
	</html>