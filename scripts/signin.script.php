<?php
session_start();
$_SESSION["errore_register"]=true; //se il login non viene effettuato correttamente,
								//questo flag permetterà di segnalare l'errore all'utente

if(isset($_POST["submit"])){

	//connessione al database
	require("config.php"); //parametri di connessione
	$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
	if ($mydb->connect_errno) {
		echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
		exit();
	}
	//la connessione è andata a buon fine: eseguo la query
	//questa volta utilizzo le prepared statements
	//per prevenire tentativi di sql injections
	//esempio: 
	//$stringa = "'ciao' OR 1 = 1";
	//$query = "SELECT nome, password FROM utenti WHERE username = ".$stringa;
	//otterrei come query: SELECT nome, password FROM utenti WHERE username = 'ciao' OR 1 = 1
	//get username from form
    $username = $_POST["usr"];
    //prepare the statement
    $stmt = $mydb->prepare("SELECT * FROM account WHERE user=(?)");
    $stmt->bind_param("s", $_POST["usr"]);
    //execute the statement
    $stmt->execute([$username]); 
    //fetch result
    $user = $stmt->fetch();
    if ($user) {
        // username already exists
        $stmt->close();
		header("Location: ../register.php");
		exit();
    } else {
        // username does not exist
        $stmt->close();
        unset($_SESSION["errore_register"]);

        $stmt = $mydb->prepare("INSERT INTO account (user, hash, email, stat, pic) VALUES (?,?,?,'Hello! i am an hadoken forums user.', 'img/profile/profilepic1.jpg')");
	//associo il parametro col tipo (s per stringa)
    $hash = password_hash($_POST["pwd"],PASSWORD_DEFAULT);
       
	$stmt->bind_param("sss", $_POST["usr"],$hash,$_POST["email"]);
	//eseguo la query
	$stmt->execute();
	
	//chiudo statement
	$stmt->close();
	
	//select: prepared statement con segnaposto (?) per parametro
	$stmt = $mydb->prepare("SELECT Accountid, user, hash FROM account WHERE user = (?)");
	//associo il parametro col tipo (s per stringa)
	$stmt->bind_param("s", $_POST["usr"]);
	//eseguo la query
	$stmt->execute();
	//associo i risultati a delle variabili (una variabile per campo)
	$stmt->bind_result($id, $nome, $hash);
	//fetch dei risultati
	while ($stmt->fetch()) { //eseguirà solo una iterazione
		//verifico la password
		//l'hash è stato creato con la funzione md5
		//(nota: ci sono funzioni più sicure di md5, che non è nato per le password! 
		//per esempio le funzioni password_hash e password_verify)
		if(password_verify($_POST["pwd"], $hash)){
			//setto la variabile di sessione che indica che è loggato
			unset($_SESSION["errore_login"]);
			$_SESSION["username"] = $nome;
			$_SESSION["id"] = $id;
		}
	}
	//chiudo statement
	$stmt->close();


    }
}

//ritorna alla pagina invocante	
header("Location: ../index.php");
exit();
?>