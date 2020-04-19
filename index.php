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
	<title> Accueil ECE Ebay</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bs.css">

</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>


	<!-- Header -->
	<header>
		
	</header>
	<!-- Conteneur -->
	<div class="container-fluid" id="imgac"> 
		<div class="container" id="accueil" style="background-color: white;">
		<div class="container"> <br> <h5 style="text-align: justify;"> Bienvenue sur notre site EBAY ECE ! Notre objectif est de faciliter les échanges d'antiquités et de biens familliaux entre particuliers. Nos utilisateurs vous proposent ainsi leurs antiquités au prix qu'ils estiment être juste (bien-sure, nous vérifions !). Plusieurs moyens sont disponibles pour se procurer les antiquités. Premièrement, l'achat immédiat : simple et efficace, vous achetez l'objet au prix indiqué sur l'annonce. Deuxièmement, les enchères : un prix minimal est fixé, vous avez jusqu'à la date limite pour faire une offre. Ce sont des enchères à l'aveugle, c'est-à-dire que vous ne voyez pas l'offre la plus haute actuellement (cela ajoute du piment, n'est-ce pas ?). Troisièmement, l'achat par meilleure offre : vous avez cinq tentatives pour vous mettre d'accord avec le vendeur sur un prix. Au-dela de cinq tentatives, vous n'avez plus possibilité de négocier ! <br> <br> Amusez-vous bien ! </h5> </div>


		<div class="container"  >
			<br>
			<div class="carousel slide" data-ride="carousel" id="carousel-1" style="">
			    <div class="carousel-inner" role="listbox">
			        <div class="carousel-item active"><img class="w-100 d-block" src="img/mesencheres.jpg" alt="Slide Image" /></div>
			        <?php
			    	$sql = "SELECT produit.*, img_produit.URL FROM produit JOIN img_produit on img_produit.Produit= produit.ID WHERE  Prix_Enchere > 0 AND Vendu = 0";
			    	$result = mysqli_query($db_handle, $sql);
					if ($result != NULL)
					{	
						while ($data = mysqli_fetch_assoc($result))
						{			    ?>
			    
			        <div class="carousel-item"><img class="w-100 d-block" src="<?php echo $data['URL']?>" alt="Slide Image" /></div>
			        <?php }} ?>
			    </div>

			    <ol class="carousel-indicators">
			        <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
			        
			        <?php
			    	$sql2 = "SELECT * FROM produit WHERE Prix_Enchere > 0 AND Vendu = 0";
			    	$result2 = mysqli_query($db_handle, $sql2);
			    	$increment = 1;
					if ($result2 != NULL) 
					{	
						while ($data = mysqli_fetch_assoc($result2))
						{		    ?>
			    
			        	<li data-target="#carousel-1" data-slide-to="<?php echo $increment ?>"></li>
			        	<?php  $increment ++;}} ?>
			        
			    </ol>
			</div>
		</div>

		<div class="container" style="margin-bottom: 60px;" >
			<p><br>
				Voici la liste de nos articles en vente en enchère : pour plus d'informations <a href="achat.php"> rendez-vous sur la page achat </a>
			<br></p>
		</div>




		<!-- OFFRE ACHAT IMMEDIAT -->
		<div class="container"   >
			<br>
			<div class="carousel slide" data-ride="carousel" id="carousel-4" style="">
			    <div class="carousel-inner" role="listbox">
			        <div class="carousel-item active"><img class="w-100 d-block" src="img/achat_immediat.jpg" alt="Slide Image" style="height: 500px;" /></div>
			        <?php
			    	$sql = " SELECT produit.*, img_produit.URL FROM produit JOIN img_produit on img_produit.Produit= produit.ID WHERE  Prix_Achat > 0 AND Vendu = 0";
			    	$result = mysqli_query($db_handle, $sql);
					if ($result != NULL)
					{	echo "test1";
						while ($data = mysqli_fetch_assoc($result))
						{echo "test2";			    ?>
			    
			        <div class="carousel-item"><img class="w-100 d-block" src="<?php echo $data['URL']?>" alt="Slide Image" style="height: 500px " /></div>
			        <?php }} ?>
			    </div>

			    <ol class="carousel-indicators">
			        <li data-target="#carousel-4" data-slide-to="0" class="active"></li>
			        
			        <?php
			    	$sql2 = "SELECT * FROM produit WHERE Prix_Achat > 0 AND Vendu = 0";
			    	$result2 = mysqli_query($db_handle, $sql2);
			    	$increment = 1;
					if ($result2 != NULL) 
					{	
						while ($data = mysqli_fetch_assoc($result2))
						{		    ?>
			    
			        	<li data-target="#carousel-4" data-slide-to="<?php echo $increment ?>"></li>
			        	<?php  $increment ++;}} ?>
			        
			    </ol>
			</div>
		</div>

		<div class="container" style="margin-bottom: 60px;">
			<p><br>
				Voici la liste de nos articles en vente en achat immédiat : pour plus d'informations <a href="achat.php"> rendez-vous sur la page achat </a>
			<br></p>
		</div>

				<!-- OFFRE Meilleur offre -->
		<div class="container"  >
			<br>
			<div class="carousel slide" data-ride="carousel" id="carousel-3" style="">
			    <div class="carousel-inner" role="listbox">
			        <div class="carousel-item active"><img class="w-100 d-block" src="img/bestoffre.jpg" alt="Slide Image "style="height: 500px;"  /></div>
			        <?php
			    	$sql = "SELECT produit.*, img_produit.URL FROM produit JOIN img_produit on img_produit.Produit= produit.ID WHERE Prix_min > 0 AND Vendu = 0";
			    	$result = mysqli_query($db_handle, $sql);
					if ($result != NULL)
					{	echo "test1";
						while ($data = mysqli_fetch_assoc($result))
						{echo "test2";			    ?>
			    
			        <div class="carousel-item"><img class="w-100 d-block" src="<?php echo $data['URL']?>" alt="Slide Image" style="height: 500px;"/></div>
			        <?php }} ?>
			    </div>

			    <ol class="carousel-indicators">
			        <li data-target="#carousel-3" data-slide-to="0" class="active"></li>
			        
			        <?php
			    	$sql2 = "SELECT * FROM produit WHERE Prix_min > 0 AND Vendu = 0";
			    	$result2 = mysqli_query($db_handle, $sql2);
			    	$increment = 1;
					if ($result2 != NULL) 
					{	
						while ($data = mysqli_fetch_assoc($result2))
						{		    ?>
			    
			        	<li data-target="#carousel-3" data-slide-to="<?php echo $increment ?>"></li>
			        	<?php  $increment ++;}} ?>
			        
			    </ol>
			</div>
		</div>

		<div class="container" style="margin-bottom: 60px;">
			<p><br>
				Voici la liste de nos articles en vente en meilleure offre : pour plus d'informations <a href="achat.php"> rendez-vous sur la page achat </a>
			<br></p>
		</div><br><br>

	</div>
	</div>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>