<?php 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include ("database/db_connect.php");

?>


<?php

$sql = "SELECT Date_fin_enchere FROM produit ";
$result = mysqli_query($db_handle, $sql);
$date=date_create();
$now = date('Y-m-d H:i:s');
if ($result != NULL)
{	
	while ($data = mysqli_fetch_assoc($result))
	{
	if (($now>$data['Date_fin_enchere'])AND($data['Date_fin_enchere']!=NULL))
		{ 	echo "Enchere fini : " . $data['Date_fin_enchere']. "<br>"; }
	if (($now<$data['Date_fin_enchere'])AND($data['Date_fin_enchere']!=NULL))
		{ 	echo "Enchere en cours : " . $data['Date_fin_enchere']. "<br>"; }
	}
	
}

?>