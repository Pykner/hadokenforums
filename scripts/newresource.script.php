<?php
    session_start();
//start the transaction
require("config.php"); //parametri di connessione
	$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
	if ($mydb->connect_errno) {
		echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
		exit();
	}
    
                        $stmt = $mydb->prepare("INSERT INTO resources(title, txt, FkGameid, FkAccountid, valid, link) VALUES(?,?,?,?,0,?)");

                        $stmt->bind_param("ssiis", $_POST['resource_title'], $_POST['resource_content'], $_POST['game'], $_SESSION['id'], $_POST['link']);
                        $stmt->execute();
                    
                    
                    header("Location: ../resources/gameresources.php?id=" . $_POST['game'] . "");
                    exit();
                    ?>