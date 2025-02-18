<?php
    session_start();
//start the transaction
require("config.php"); //parametri di connessione
	$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
	if ($mydb->connect_errno) {
		echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
		exit();
	}
                    
                        $stmt = $mydb->prepare("INSERT INTO tournament(title, txt, FkGameid, FkAccountid, major, online, region, address, data_inizio, data_fine, link) VALUES(?,?,?,?,0,?,?,?,?,?,?)");
                
                        $stmt->bind_param("ssiiisssss", $_POST['tournament_title'], $_POST['tournament_description'], $_POST['game'], $_SESSION['id'], $_POST['online'], $_POST['region'], $_POST['address'], $_POST['start_date'], $_POST['end_date'], $_POST['link']);
                        $stmt->execute();
                    
                    
                    header("Location: ../tournaments/tournamentlist.php");
                    exit();
                    ?>