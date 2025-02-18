<?php
	session_start();
	
	//elimina la variabile di sessione
	unset($_SESSION["id"]);
	unset($_SESSION["username"]);
	
	//ritorna alla pagina invocante	
	header("Location: ../index.php");
	exit();
?>
