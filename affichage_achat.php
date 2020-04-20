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

	//Redirige vers mon panier apres ajout d'un objet dans le panier
    if (isset($_GET['ajout']) && $_GET['ajout'] == 'ok'){
    	header("Location: mon_panier.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Acheter</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="icon" href='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22> <text y=".9em" font-size="90">💩</text></svg>'>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/achat.css">
	<link rel="stylesheet" type="text/css" href="css/bs.css">

</head>
<body>
	<!-- Navbar -->
	<?php include("nav.php") ?>
	
	<div class="container">
		<br>
		<div>
			<?php 	
			if ($db_found) 
				{
				$id = $_GET['id'];
				$data2 = $data3 = $data4 = 0;	
				$sql = "SELECT  produit.* , utilisateur.Pseudo FROM produit JOIN utilisateur on utilisateur.ID = produit.Vendeur WHERE produit.ID like '$id'  ";
				
				$result = mysqli_query($db_handle, $sql);
				if ($result != NULL) {	
					while ($data = mysqli_fetch_assoc($result))
					 {     	?>
							<div class="container"  >
								<br>
								<div class="carousel slide" data-ride="carousel" id="carousel-affich" style="">
								    <div class="carousel-inner" role="listbox">
								        <div class="carousel-item active"><img class="w-100 d-block" src="img/monachat.jpg" alt="Slide Image" style="height: 600px;"/></div>
								        <?php
								        $test_video = 0;
								    	$sql_ = "SELECT produit.*, img_produit.URL FROM produit JOIN img_produit on img_produit.Produit= produit.ID WHERE  produit.ID ='$id'";
								    	$result_ = mysqli_query($db_handle, $sql_);
										if ($result_ != NULL)
										{	
											while ($data_ = mysqli_fetch_assoc($result_))
											{			    ?>
								    
								        <div class="carousel-item"><img class="w-100 d-block" src="<?php echo $data_['URL']?>" alt="Slide Image" style="height: 600px;" /></div>
								        <?php 
								        if (($test_video==0 )AND (isset($data_['Video']))) { ?> <div class="carousel-item"><video class="w-100 d-block" src="<?php echo $data_['Video']?>" alt="Slide Image" style="height: 600px;" /></div>
								        <?php $test_video++;}
								    	}} 


								        ?>
								    </div>

								    <ol class="carousel-indicators">
								        <li data-target="#carousel-affich" data-slide-to="0" class="active"></li>
								        
								        <?php
								        $test_video2 = 0;
								    	$sql2 = "SELECT * FROM produit WHERE Produit.ID = '$id'";
								    	$result2 = mysqli_query($db_handle, $sql2);
								    	$increment = 1;
										if ($result2 != NULL) 
										{	
											while ($data_ = mysqli_fetch_assoc($result2))
											{		    ?>
								    
								        	<li data-target="#carousel-affich" data-slide-to="<?php echo $increment ?>"></li>
								        	<?php  $increment ++;
								        	if (($test_video==0 )AND (isset($data_['Video']))) { ?> 
								        		<li data-target="#carousel-affich" data-slide-to="<?php echo $increment ?>"></li>
								        	<?php $test_video++;   $increment ++;}
								    	}} 
								        ?>
								        
								    </ol>
								</div>
							</div>
						<h4 class="card-title"><?php echo "<br>" . $data['ID'] . ". ". $data['Nom']; $produit = $data['ID'];?></h4>
						<h6> 	<?php 	echo "Disponible :";
								    					if ($data2 = $data['Prix_Achat'] > 0){ echo " -  à l'achat immediat  <br>";}
														if ($data3 = $data['Prix_Enchere'] > 0){ echo " -  à l'enchere  <br>";}
														if ($data4 =$data['Prix_min'] > 0){ echo " -  à l'achat par meilleur offre  ";}	 ?> </h6>
								    	<p class="card-text"> <?php echo $data['Description'] . " au prix de ". $data['Prix_Achat'] . ". Cet article est proposé par : ". $data['Pseudo'] ; ?> </p>
					</div>			    	
				<?php }}
			}
			?>
		</div>	





		<?php if(isset($_SESSION['user_ID'])){ ?>
		<div class="col-md-6" style="margin : 0 auto; margin-bottom: 100px; margin-top: 50px;">

			<div >
				<?php if ($data2 > 0)
				{ ?>
					 					
				<?php
				if (!isset($_SESSION['panier']) || !in_array($produit, $_SESSION['panier']))
				{
					?><br><a href="affichage_achat.php?id=<?php echo $produit ?>&amp;ajout=ok" class="btn btn-primary btn-block is-invalid"><H3> Ajouter au panier </H3> </a>	
					<?php if (isset($_GET['ajout']) AND $_GET['ajout']== "ok") {$_SESSION['panier'][] = $produit;}
				}
				else 
				{ 
					?><br><a href="#" class="btn btn-warning btn-block is-invalid"><H3> Deja dans le panier </H3> </a>	
				<?php }
				}
				?>			
			</div>
			<div >
				<?php if ($data3 > 0)
				{ ?>
					<br><a href="enchere.php?id=<?php echo $produit ?>" class="btn btn-primary btn-block is-invalid"><H3> Procéder à l'enchere </H3> </a> 

				<?php	}
				?>			
			</div>
			<div >
				<?php if ($data4 > 0)
				{ ?>
					<br><a href="meilleure_offre.php?id=<?php echo $produit ?>" class="btn btn-primary btn-block is-invalid"><H3> Accéder à la meilleure offre </H3> </a> 

				<?php	}
				?>
			</div>
		</div>
		<?php } else {?>
		<div class="col-md-6" style="margin : 0 auto; margin-bottom: 100px; margin-top: 50px;">
			
				<br><a href="login.php" class="btn btn-primary btn-block is-invalid"><H3> Me connecter </H3> </a> 	
		</div> <?php } ?> 

		<br>
	</div>


	<?php include("footer.php") ?>
</body>
</html>
