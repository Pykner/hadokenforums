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
                       
                        date_default_timezone_set('Europe/Rome');
                        $date = date('Y/m/d h:i:s a', time());

                        $stmt = $mydb->prepare("INSERT INTO topics(title, date_post, txt, FkCategory, FkAccount) VALUES(?,?,?,?,?)");

                        $stmt->bind_param("sssii", $_POST['topic_subject'], $date, $_POST['post_content'], $mydb->real_escape_string($_GET['id']),  $_SESSION['id']);
                        $stmt->execute();
                    
                    
                    header("Location: ../forums/category.php?id=" .  $mydb->real_escape_string($_GET['id']) . "");
                    exit();
                    ?>