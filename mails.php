<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	//SOURCE PHPMailer : https://github.com/PHPMailer/PHPMailer

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	/* Exception class. */
	require 'PHPMailer\src\Exception.php';

	/* The main PHPMailer class. */
	require 'PHPMailer\src\PHPMailer.php';

	/* SMTP class, needed if you want to use SMTP. */
	require 'PHPMailer\src\SMTP.php';

	include ("database/db_connect.php");

	if (isset($_GET['signup'])) {
		
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->SMTPAuth = true;
		$mail->Username = 'piscine.ece.2020@gmail.com';
		$mail->Password = 'Magic-System123';
		$mail->setFrom('piscine.ece.2020@gmail.com', 'Ece Ebay');
		$mail->addAddress($_SESSION['user_Email']);
		$mail->Subject = "Bienvenue sur ECE Ebay";
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
		$mail->Body = "Bonjour " . $_SESSION['user_Prenom'] . " " . $_SESSION['user_Nom'] . ",<br>Nous vous souhaitons la bienvenue sur ECE Ebay.<br>Vous pouvez vous connecter en saisissant votre nom d'utilisateur ou votre email ainsi que votre mot de passe.<br>Nom d'utilisateur : " . $_SESSION['user_Pseudo'] . "<br>N'oubliez pas de d'ajouter une adresse et un moyen de paiement sur la page http://piscine/mon_compte.php <br>A bientot sur ECE Ebay !";
		//Replace the plain text body with one created manually
		$mail->AltBody = "Bonjour " . $_SESSION['user_Prenom'] . " " . $_SESSION['user_Nom'] . ",<br>Nous vous souhaitons la bienvenue sur ECE Ebay.<br>Vous pouvez vous connecter en saisissant votre nom d'utilisateur ou votre email ainsi que votre mot de passe.<br>Nom d'utilisateur : " . $_SESSION['user_Pseudo'] . "<br>N'oubliez pas de d'ajouter une adresse et un moyen de paiement sur la page http://piscine/mon_compte.php <br>A bientot sur ECE Ebay !";

		if (!$mail->send()) {
		    echo 'Mailer Error: '. $mail->ErrorInfo;
		} else {
		    echo 'Message sent!';
		    header("Location: index.php");
		}
	}
	else if (isset($_POST['btn_add_cadeau'])) {

		$num_carte = isset($_POST["num_carte"])? $_POST["num_carte"] : "";
		$montant = isset($_POST["montant"])? $_POST["montant"] : "";
		$email = isset($_POST["email"])? $_POST["email"] : "";
		$pseudo = $_SESSION['user_Pseudo'];
		
		if (!(empty($num_carte) || empty($montant))) {
			$sql_check_doublon = "SELECT Numero_Carte FROM cheque_cadeau WHERE Numero_Carte = '$num_carte'";
			$result = mysqli_query($db_handle, $sql_check_doublon);

			if (mysqli_num_rows($result) == 0) {
				$sql_add_cadeau = "INSERT INTO cheque_cadeau (Numero_Carte, Montant) VALUES ('$num_carte', '$montant')";
				$res = mysqli_query($db_handle, $sql_add_cadeau);

				// Instantiation and passing `true` enables exceptions
				$mail = new PHPMailer;

				//Tell PHPMailer to use SMTP
				$mail->isSMTP();

				//Enable SMTP debugging
				// SMTP::DEBUG_OFF = off (for production use)
				// SMTP::DEBUG_CLIENT = client messages
				// SMTP::DEBUG_SERVER = client and server messages
				// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

				//Set the hostname of the mail server
				$mail->Host = 'smtp.gmail.com';
				// use
				// $mail->Host = gethostbyname('smtp.gmail.com');
				// if your network does not support SMTP over IPv6

				//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
				$mail->Port = 587;

				//Set the encryption mechanism to use - STARTTLS or SMTPS
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

				//Whether to use SMTP authentication
				$mail->SMTPAuth = true;

				//Username to use for SMTP authentication - use full email address for gmail
				$mail->Username = 'piscine.ece.2020@gmail.com';

				//Password to use for SMTP authentication
				$mail->Password = 'Magic-System123';

				//Set who the message is to be sent from
				$mail->setFrom('piscine.ece.2020@gmail.com', 'Ece Ebay');

				//Set who the message is to be sent to
				$mail->addAddress($email);

				//Set the subject line
				$mail->Subject = $pseudo . " vous a envoye un cheque cadeau pour ECE ebay";

				//Read an HTML message body from an external file, convert referenced images to embedded,
				//convert HTML into a basic plain-text alternative body
				//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
				$mail->Body = "Vous avez recu un cheque cadeau d'un montant de " . $montant . "EUR.<br> Utilisez le des maintenant : " . $num_carte;
				//Replace the plain text body with one created manually
				$mail->AltBody = "Vous avez recu un cheque cadeau d'un montant de " . $montant . "EUR. Utilisez le des maintenant : " . $num_carte;


				//send the message, check for errors
				if (!$mail->send()) {
				    echo 'Mailer Error: '. $mail->ErrorInfo;
				} else {
				    echo 'Message sent!';
				    header("Location: mon_compte.php");
				}
			}
		}
	}
	else if (isset($_GET['commande'])) {
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->SMTPAuth = true;
		$mail->Username = 'piscine.ece.2020@gmail.com';
		$mail->Password = 'Magic-System123';
		$mail->setFrom('piscine.ece.2020@gmail.com', 'Ece Ebay');
		$mail->addAddress($_SESSION['user_Email']);
		$mail->Subject = "Votre commande ECE Ebay";
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);

		$msg = "<b>Bonjour</b>, <br>Nous vous informons que votre commande a été expédiée. Votre colis est en cours d'acheminement et cette commande ne peut donc plus être modifiée. <br>";

		$id_commande = $_GET['commande'];
		$sql = "SELECT a.Ligne_1, a.Ligne_2, a.Ville, a.Code_Postal, a.Pays, a.Telephone, commande.Date_Livraison, commande.Montant_total, commande.ID, utilisateur.Nom FROM adresse as a, commande, utilisateur WHERE commande.ID = '$id_commande' AND commande.Adresse_Livraison = a.ID AND a.ID_User = utilisateur.ID";
		$res = mysqli_query($db_handle, $sql);
		$data = mysqli_fetch_assoc($res);
		var_dump($data);

		$msg .= "Votre commande sera livrée le " . $data['Date_Livraison'] . "<br>";
		$msg .= "<u>A l'adresse suivante :</u><br><br>";
		$msg .= $data['Nom'] . "<br>";
		$msg .= $data['Ligne_1'] . "<br>";
		if (!empty($data['Ligne_2']))
			$msg .= $data['Ligne_2'] . "<br>";
		$msg .= $data['Ville'] . "<br>";
		$msg .= $data['Code_Postal'] . "<br>";
		$msg .= $data['Pays'] . "<br>";
		$msg .= $data['Telephone'] . "<br><br>";

		$msg .= "<u>Votre commande contient :</u><br><br>";

		$sql = "SELECT produit.Nom, produit.Description FROM commande_detail, produit WHERE commande_detail.Commande = '$id_commande' AND produit.ID = commande_detail.Objet";
		$res = mysqli_query($db_handle, $sql);

		while ($data_detail = mysqli_fetch_assoc($res)) {
			$msg .= "<b>" . $data_detail['Nom'] . "</b>" . " : " . $data_detail['Description'] . '<br><br>';
		}

		$msg .= "Prix total de cette commande :" . $data['Montant_total'] . "EUR<br>";

		//echo $msg;

		$mail->Body = $msg;
		//Replace the plain text body with one created manually
		$mail->AltBody = $msg;

		
		if (!$mail->send()) {
		    echo 'Mailer Error: '. $mail->ErrorInfo;
		} else {
		    echo 'Message sent!';
		    header("Location: index.php");
		}
		
	}
	else {
		header("Location: index.php");
	}


?>