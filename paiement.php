<?php 

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include("database/db_connect.php");
	
	if (isset($_POST['payer'])) {
		var_dump($_POST);

	}
	else {
		header("Location: index.php");
	}

 ?>