<?php 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
	include ("database/db_connect.php");

$sql = "SELECT ID, Date_fin_enchere FROM produit ";
$result = mysqli_query($db_handle, $sql);
$date = date_create();
$now = date('Y-m-d H:i:s');
if ($result != NULL)
{	
	$ench_fini = array();
	while ($data = mysqli_fetch_assoc($result))
	{
		if (($now>$data['Date_fin_enchere']) AND ($data['Date_fin_enchere']!=NULL)) {
			echo "Enchere fini : " . $data['ID'] . " " . $data['Date_fin_enchere']. "<br>";
			$ench_fini[] = $data['ID'];
		}
		if (($now<$data['Date_fin_enchere']) AND ²($data['Date_fin_enchere']!=NULL)) {
			echo "Enchere en cours : " . $data['ID'] . " " . $data['Date_fin_enchere']. "<br>"; 
		}
	}

	foreach ($ench_fini as $article) {
		$offset = 0;

		$sql = "SELECT * FROM `enchere` WHERE Objet = '$article' ORDER BY `Prix`  DESC LIMIT 2";
		$res = mysqli_query($db_handle, $sql);

		$data = mysqli_fetch_assoc($res);
		$prix1 = $data['Prix'];
		$id1 = $data ['Acheteur'];
		$data = mysqli_fetch_assoc($res);
		$prix2 = $data['Prix'];
		$id2 = $data ['Acheteur'];

		if (empty($prix2)) {
			$prix_final = (int)$prix1;
			$acheteur = $id1;
		}
		else if ($prix1 >= $prix2){
			$prix_final = (int)$prix2 + 1;
			$acheteur = $id1;
		}
		else{
			$prix_final = (int)$prix1 + 1;
			$acheteur = $id2;
		}

		//On recupere l'adresse principale de l'utilisateur pour l'adresse de livraison
		$sql = "SELECT Adresse, Email FROM utilisateur WHERE ID = '$acheteur'";
		$res = mysqli_query($db_handle, $sql);
		$data = mysqli_fetch_assoc($res);
		$adresse = $data['Adresse'];
		$email = $data['Email'];

		//date actuelle pour la commande
		$date=date_create();
		$date_commande = date_format($date,"Y/m/d H:i:s");

		//Ajoute 5 jours pour la livraison
		date_modify($date,"+5 days");
		$date_livraison = date_format($date,"Y/m/d");

		//Ajoute la commande dans la bdd
		$sql1 = "INSERT INTO `commande`(`Acheteur`, `Adresse_Livraison`, `Montant_total`, `Date_Commande`, `Date_Livraison`) VALUES ('$acheteur', '$adresse', '$prix_final', '$date_commande', '$date_livraison')";
		$res = mysqli_query($db_handle, $sql1);

		//Recupere l'id de la commande
		$sql2 = "SELECT ID FROM commande WHERE Date_Commande = '$date_commande'";
		$res = mysqli_query($db_handle, $sql2);
		$data = mysqli_fetch_assoc($res);
		$id_commande = $data['ID'];

		//Ajoute le detail de la commande
		$sql3 = "INSERT INTO `commande_detail`(`Commande`, `Objet`) VALUES ('$id_commande', '$article')";
		mysqli_query($db_handle, $sql3);
		//Update le statut de produit
		$sql4 = "UPDATE `produit` SET `Vendu`= 1 WHERE ID = '$article'";
		mysqli_query($db_handle, $sql4);

		header('Location: mails.php?commande=' . $id_commande . "&mail=" . $email);
	}
}

?>