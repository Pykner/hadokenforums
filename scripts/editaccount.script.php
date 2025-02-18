<?php
    session_start();
//start the transaction
require("config.php"); //parametri di connessione
	$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
	if ($mydb->connect_errno) {
		echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
		exit();
	}

                
                        //the form has been posted, so save it
                        //insert the topic into the topics table first, then we'll save the post into the posts table
                       
                        $stmt = $mydb->prepare("UPDATE account SET stat = (?), pic = (?) WHERE account.Accountid = ".$_SESSION['id']);

                        $stmt->bind_param("ss", $_POST['status_edit'], $_POST['prfcheck'] );
                        $stmt->execute();
                    
                    
                    header("Location: ../account.php?id=" . $_SESSION['username'] . "");
                    exit();
                    ?>