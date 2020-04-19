<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include ("fonction_fin_enchere.php");
 ?>

<nav class="navbar sticky-top navbar-dark bg-dark navbar-expand-md navigation-clean-button">
    <div class="container">
        <a class="navbar-brand" href="index.php" style="color: orange;">Ebay ECE<br /></a>
        <button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler collapsed">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navcol-1" >
            <ul class="nav navbar-nav mr-auto" >
                <li class="nav-item dropdown" >
                    <a data-toggle="dropdown" class="dropdown-toggle nav-link" href="achat.php" style="color: orange; font-size :19px;">Catégories </a>
                    <div role="menu" class="dropdown-menu">
                        <a class="dropdown-item" href="achat.php?Check=Fer" >Feraille ou Trésor</a>
                        <a class="dropdown-item" href="achat.php?Check=Musee">Bon pour le Musée</a>
                        <a class="dropdown-item" href="achat.php?Check=Vip">Accessoire VIP</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle nav-link" href="achat.php" style="color: orange; font-size :19px;">Achat</a>
                    <div role="menu" class="dropdown-menu">
                        <a class="dropdown-item" href="achat.php?Check=Encheres">Enchères</a>
                        <a class="dropdown-item" href="achat.php?Check=Achat_immediat">Achat immédiat</a>
                        <a class="dropdown-item" href="achat.php?Check=Meilleure_offre">Meilleure offre</a>
                    </div>
                </li >
                 <?php  if (!empty($_SESSION['user_Role'])) 
                        { 
                            if ($_SESSION['user_Role'] == 3 || $_SESSION['user_Role'] == 1)
                                { echo '<li class="nav-item"><a class="nav-link" href="vente.php" style="color: orange; font-size :19px;">Vente</a></li>'; }
                            else
                                {  echo'<li class="nav-item"><a class="nav-link" href="devenir_vendeur.php" style="color: orange; font-size :19px;">Devenir vendeur</a></li>';} 
                        }?>
            </ul>
            <ul class="nav navbar-nav ml-md-auto">
                <!-- Affiche le lien vers la page d'admin si on a le role admin -->
                <?php if (!empty($_SESSION['user_Role'])) { if ($_SESSION['user_Role'] == '1') {echo '<li class="nav-item"><a class="nav-link" href="admin.php" style="color: orange; margin-top:10px;font-size :19px;">Administration</a></li>'; }}?>
                <li class="nav-item"><a class="nav-link" href="mon_panier.php"> <img src="img/panier.png" style="height: 45px; width: 45px;margin-left: 10px; margin-right: 10px;"> <?php if(isset($_SESSION['panier'][0])) {echo " (" . count($_SESSION['panier']). ") " ;}   ?></a></li>
                <!-- Affichage et lien dynamique en fonction du statut de connection -->
                <?php if (!empty($_SESSION['user_ID'])){ echo '<li class="nav-item"><a class="nav-link" href="mon_compte.php" style="color: orange; margin-top:10px; font-size :19px;">' . $_SESSION["user_Pseudo"] . '</a></li>'; }else{ echo '<li class="nav-item"><a class="nav-link" href="login.php" style="color: orange; font-size :19px;">Se connecter</a></li>';} ?>
            </ul>
        </div>
    </div>
</nav>