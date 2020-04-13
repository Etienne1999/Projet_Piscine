<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">	
		<title> Accueil_ECE_Ebay</title>
		<link rel="stylesheet" href="style.css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 

	</head>
		
	<body>
		<div class="container-fluid">
		<div id="fond_accueil">
			<br>
			
			<!-- Tableau deroulant --> 
			<?php include("nav.php") ?>
			
				<h1> ECE EBAY </h1>

			<div id="myCarousel" class="carousel_slide" data-ride="carousel">
  				<!-- Indicators -->
			  	<ol class="carousel-indicators">
				    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				    <li data-target="#myCarousel" data-slide-to="1"></li>
				    <li data-target="#myCarousel" data-slide-to="2"></li>
			  	</ol>

			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
				    <div class="item active">
				      <img src="img/france7.jpg" alt="Los Angeles">
				    </div>

				    <div class="item">
				      <img src="img/france2.jpg" alt="Chicago">
				    </div>

				    <div class="item">
				      <img src="img/france1.jpg" alt="New York">
				    </div>
				  </div>	
			</div>
			<!-- Premier affichage -->				
			<br><br><br><br>
			<!-- Footer : contact -->	
			<?php include("footer.php") ?>
		</div>
	</div>
	</body>
</html>