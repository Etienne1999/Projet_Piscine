<?php 

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include("database/db_connect.php");
	
	if (isset($_POST['payer'])) {
		//var_dump($_POST);
		$erreur = array();

		$id = $_SESSION['user_ID'];
		if ((int)$_POST['payer'] > 0) {
			$num_carte = $_POST['num_carte'];
			$annee = $_POST['annee'];
			$mois = $_POST['mois'];

			$sql = "SELECT DATEDIFF(Date_exp, NOW()) as diff, CVV, Plafond FROM carte_bancaire WHERE Numero_Carte = '$num_carte' AND YEAR(Date_exp) = '$annee' AND MONTH(Date_exp) = '$mois' AND ID_User = '$id'";
			$res = mysqli_query($db_handle, $sql);
			//Check si la carte existe pour cet utilisateur
			if (mysqli_num_rows($res) == 1) {
				$data = mysqli_fetch_assoc($res);
				//var_dump($data);
				//Check date d'expiration de la carte
				if ((int)$data['diff'] < 0) {
					$erreur[] = "Erreur : Carte de paiement expirée !";
				}
				//Check le plafon de la carte
				if ($data['Plafond'] != NULL && (int)$_POST['payer'] > (int)$data['Plafond']) {
					$erreur[] = "Erreur : Le plafond a été atteint. Impossible de proceder au paiement !";	
				}
				//Check le cryptogramme
				if ((int)$_POST['cvv'] != (int)$data['CVV']) {
					$erreur[] = "Erreur : Le cryptogramme de sécurité ne correspond pas !";	
				}
			}
			else {
				$erreur[] = "Erreur : Carte de paiement introuvable !";
			}
		}
		if (empty($erreur)) {
			//date actuelle pour la commande
			$date=date_create();
			$date_commande = date_format($date,"Y/m/d H:i:s");

			//Ajoute 5 jours pour la livraison
			date_modify($date,"+5 days");
			$date_livraison = date_format($date,"Y/m/d");
			$montant = $_POST['payer'];

			//On recupere l'adresse principale de l'utilisateur pour l'adresse de livraison
			$sql = "SELECT Adresse FROM utilisateur WHERE ID = '$id'";
			$res = mysqli_query($db_handle, $sql);
			$data = mysqli_fetch_assoc($res);
			$adresse = $data['Adresse'];

			//Ajoute la commande dans la bdd
			$sql = "INSERT INTO `commande`(`Acheteur`, `Adresse_Livraison`, `Montant_total`, `Date_Commande`, `Date_Livraison`) VALUES ('$id', '$adresse', '$montant', '$date_commande', '$date_livraison')";
			mysqli_query($db_handle, $sql);

			//Recupere l'id de la commande qui vient d'etre crée
			$sql = "SELECT ID FROM commande WHERE Date_Commande = '$date_commande'";
			$res = mysqli_query($db_handle, $sql);
			$data = mysqli_fetch_assoc($res);
			$id_commande = $data['ID'];

			foreach ($_SESSION['panier'] as $article) {
				//Ajoute les detail de commande
				$sql1 = "INSERT INTO `commande_detail`(`Commande`, `Objet`) VALUES ('$id_commande', '$article')";
				mysqli_query($db_handle, $sql1);
				//Update le statut de produit
				$sql2 = "UPDATE `produit` SET `Vendu`= 1 WHERE ID = '$article'";
				mysqli_query($db_handle, $sql2);
			}
			unset($_SESSION['panier']);

			//MAJ cheque cadeau utilise
			if ((int)$_POST['code_cadeau'] != 0){
				$num_carte = $_POST['code_cadeau'];
				$montant_restant =  $_POST['cadeau_restant'];
				$sql = "UPDATE `cheque_cadeau` SET `Montant` = '$montant_restant' WHERE Numero_Carte = '$num_carte'";
				mysqli_query($db_handle, $sql);
			}

			//MAJ Utilisation code de reduction utilisé
			if ((int)$_POST['reduc_restant'] != -1){
				$code = $_POST['code_reduc'];
				$util =  $_POST['reduc_restant'];
				$sql = "UPDATE `coupon_reduc` SET `Utilisations` = '$util' WHERE Code = '$code'";
				mysqli_query($db_handle, $sql);
			}
			header('Location: mails.php?commande=' . $id_commande);

		}
		else {
			foreach ($erreur as $tmp) {
				echo $tmp . '<br>';
			}
			header('Refresh: 10; URL=commande.php');
			//sleep(15);
			//header("Location: commande.php");
		}
	}
	else {
		header("Location: index.php");
	}

 ?>