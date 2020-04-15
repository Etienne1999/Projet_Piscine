<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

 ?>

<nav class="navbar sticky-top navbar-light navbar-expand-md navigation-clean-button">
    <div class="container">
    	<a class="navbar-brand" href="index.php">Ebay ECE<br /></a>
    	<button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler">
    		<span class="navbar-toggler-icon"></span>
    	</button>
        <div class="collapse navbar-collapse show" id="navcol-1">
            <ul class="nav navbar-nav mr-auto">
                <li class="nav-item dropdown">
                	<a data-toggle="dropdown" class="dropdown-toggle nav-link" href="achat.php">Catégories </a>
                    <div role="menu" class="dropdown-menu">
                    	<a class="dropdown-item" href="achat.php?Check=Fer">Feraille ou Trésor</a>
                    	<a class="dropdown-item" href="achat.php?Check=Musee">Bon pour le Musée</a>
                    	<a class="dropdown-item" href="achat.php?Check=Vip">Accessoire VIP</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                	<a data-toggle="dropdown" class="dropdown-toggle nav-link" href="achat.php">Achat</a>
                    <div role="menu" class="dropdown-menu">
                    	<a class="dropdown-item" href="achat.php?Check=Encheres">Enchères</a>
                    	<a class="dropdown-item" href="achat.php?Check=Achat_immediat">Achat immédiat</a>
                    	<a class="dropdown-item" href="achat.php?Check=Meilleure_offre">Meilleure offre</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="vente.php">Vente</a></li>
            </ul>
            <ul class="nav navbar-nav ml-md-auto">
                <li class="nav-item"><a class="nav-link" href="mon_panier.php">Panier</a></li>
                <?php if (!empty($_SESSION['user_ID'])){ echo '<li class="nav-item"><a class="nav-link" href="mon_compte.php">' . $_SESSION["user_Pseudo"] . '</a></li>'; }else{ echo '<li class="nav-item"><a class="nav-link" href="login.php">Se connecter</a></li>';} ?>

            </ul>
        </div>
    </div>

    
</nav>