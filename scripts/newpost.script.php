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

                        $stmt = $mydb->prepare("INSERT INTO posts(txt, date_post, FkTopicid, FkAccountid) VALUES(?,?,?,?)");

                        $stmt->bind_param("ssii", $_POST['post_content'], $date, $mydb->real_escape_string($_GET['id']),  $_SESSION['id']);
                        $stmt->execute();
                    
                    
                    header("Location: ../forums/topic.php?id=" .  $mydb->real_escape_string($_GET['id']) . "");
                    exit();
                    ?>