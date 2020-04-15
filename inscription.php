<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Inscription</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="inscription.css">

</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>


	<!-- Conteneur -->
	<div class="container">
		<div class="row" id="monSignUp">
			<div class="col-12 col-sm-8 offset-sm-2">
			    <form method="post">
			        <h2 class="text-center"><strong>Inscription</strong></h2>
			        <div class="form-group" id="formInfoPerso">
			        	<label for="formInfoPerso"><strong>Vos informations personelles</strong></label>
			        	<div class="row">
				        	<div class="col-12 col-sm form-group">
				        		<input class="form-control" type="prenom" name="prenom" placeholder="Prénom" />	
				        	</div>
				        	<div class="col-12 col-sm form-group">
				        		<input class="form-control" type="nom" name="nom" placeholder="Nom" />	
				        	</div>
				        </div>	
			        </div>

			        <div class="form-group" id="formInfoConnect">
			        	<label for="formInfoConnect"><strong>Vos informations de connexion</strong></label>
			        	<div class="form-group">
				        	<input class="form-control" type="email" name="email" placeholder="Email" />
				        </div>
				        <div class="form-group">
				        	<input type="password" class="form-control" name="password" placeholder="Mot de passe" />
				        </div>
				        <div class="form-group">
				        	<input type="password" class="form-control" name="password-repeat" placeholder="Mot de passe (Confirmer)" />
				        </div>
			        </div>
			        
			        <div class="form-group"></div>
			        <div class="form-group">
			        	<button class="btn btn-primary btn-block" type="submit">S&#39;inscrire</button>
			        </div>
			        <p class="text-center font-weight-lighter text-muted">J'ai déjà un compte. <a class="text-reset" href="login.php">Se connecter</a></p>
			    </form>
			</div>
		</div>
	</div>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>