<?php
session_start(); 
?>
<html>
    <head>
        <title>HadokenForums - Resource info</title>
        <link rel = "icon" href = "../img/icon.jpg" type = "image/x-icon">
        <link rel="stylesheet" href="../css/homestyle.css?t=<?php echo round(microtime(true)*1000);?>">
        <link rel="stylesheet" href="../css/resources.css?t=<?php echo round(microtime(true)*1000);?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>

    <?php
			/*instauro la connessione al database */
			include("../scripts/config.php");  //file di config con i parametri di connessione
				$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
				if ($mydb->connect_errno) {
					echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
					exit();  //termina la pagina
				}
				//query per prelevare l'elenco delle nazionalita
				$query1 = "SELECT COUNT(Accountid) AS num_account FROM account";
				//eseguo la query
				$risultato1 = $mydb->query($query1);

                $querypost = "SELECT 
                (SELECT count(Postid) FROM posts ) AS Count1,
                (SELECT count(Topicid) FROM topics ) AS Count2
              FROM posts, topics LIMIT 0,1";

                $risultatopost = $mydb->query($querypost);
			?>



        
    <script src="../js/playsound.js"></script>
    <div class="header">

        <audio id="audio" src="../sound/hadoken.mp3"></audio>   
        <img id="img" src="../img/hadokenlogo.png" value="PLAY"  onclick="play()">

    </div>

    <nav class="navbar">
        <ul>
            <li><a href="../index.php"><i class="fa fa-fw fa-home"></i>Home</a></li>
            <li><a href="../forums/forums.php"><i class="fa fa-commenting-o"></i>Forums</a></li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-trophy" ></i>Tournaments</a>
                <div class="dropdown-content">
                    <a href="../tournaments/majorevents.php">Majors</a>
                    <a href="../tournaments/tournamentlist.php">See tournaments</a>
                    <a href="../tournaments/newtournament.php">Create tournament</a>
       
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-book"></i>Resources</a>
                <div class="dropdown-content">
                    <a href="resourceindex.php">See resources</a>
                    <a href="newresource.php">Submit resource</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-gamepad"></i>Matchmaking</a>
                <div class="dropdown-content">
                    <a href="../matchmaking/findmatch.php">See matchmaking</a>
                    <a href="../matchmaking/newmatch.php">Create matchmaking</a>
   
                </div>
            </li>
            
            <?php

            if(isset($_SESSION["username"])){
                ?><li style="float:right"><a href='../account.php?id=<?php echo $_SESSION["username"]?>'><i class="fa fa-user"></i><?php echo $_SESSION["username"]?></a>
            <?php
            }else{
                ?><li style="float:right"><a onclick="document.getElementById('id01').style.display='block'" style="width:auto;"><i class="fa fa-user"></i>login</a>
                <?php
            }
            ?>
        </ul>
    </nav>

    <div id="id01" class="modal">
  
        <form class="modal-content animate" id="login" name="login" method="post" action="scripts/login.script.php">
 
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>

    <div class="container">
      <label for="usr"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="usr" required>

      <label for="pwd"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="pwd" required>
        
      <input type="submit" name="submit" value="Login">

      <label><input type="checkbox" checked="checked" name="remember"> Remember me </label>
    </div>

    <div class="container" style="background-color:#333">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw">Don't have an account? <a href="../register.php">register</a></span>

      <?php
			//comunico anche l'eventuale tentativo errato di login
			if(isset($_SESSION["errore_login"]) && $_SESSION["errore_login"]==true){
				echo "<p>Invalid username or password! try again!</p>";
				unset($_SESSION["errore_login"]);
			}
		
		?>
    </div>
        </form>
    </div>

    <div class="bodyinner">
        <div class="resource_container">
    <?php
            $query2 = "SELECT game.title AS game_title, resources.Resourceid, resources.title AS resource_title, resources.txt, resources.valid, account.user, resources.link
                       FROM resources INNER JOIN game ON game.Gameid = resources.FkGameid
                       LEFT JOIN account ON account.Accountid = resources.FkAccountid
                       WHERE Resourceid = ". $mydb->real_escape_string($_GET['id']);
            $risultato2 = $mydb->query($query2);

            if(!$risultato2)
            {
                echo 'The resources could not be displayed, please try again later.';
            }
            else
            {
                if(mysqli_num_rows($risultato2) == 0){
                       
                    echo'<p>Resource could not be displayed.</p>';
               
                }else{  
                    
                    while($row = $risultato2->fetch_assoc())
                    {   
                        echo '<div class="resource_title">';
                        echo '<h1>' . $row['resource_title'] . '</h1>';
                        echo '</div>';
                    
                        echo '<div class="resourceinfo">';
                            echo '<h2><a href="../account.php?id=' . $row['user'] .'">' . $row['user'] . '</a></h2>';
                            echo'<p>' .$row['txt'] . '</p>';

                            if($row['link'] != NULL){
                                echo'<h3><a href="'. $row['link'] .'">Resource link</a></h3>';
                            }else{
                                echo'<h3>No resource link provided</h3>';
                            }
                        echo'</div>';
                                        echo'<div class="valid_check">';
                                            echo'<h2>'. $row['game_title'] .'</h2>';
                                            if($row['valid'] == 0){
                                                echo '<h2>Resource not validated yet</h2>';
                                            }else{
                                                echo '<h2>Valid resource</h2>';
                                            }
                                    echo '</div>';

                                echo '<div style="clear:both;"></div>';
                            
                        }
                    }
                }
                
            
            
            
        ?>
        </div>
    </div>

<div class="footer">
    <div class="about">
        <H3>About</H3>
        <a href="">Contact</a><br>
        <a href="">Creator</a>
    </div>

    <div class="stats">
        <H3>Forum stats</H3>
        <?php
            while($row=$risultato1->fetch_assoc()){
                echo '<p>There are '.$row["num_account"].' registered members!</p>';
            }
        ?>
        <?php
            while($row=$risultatopost->fetch_assoc()){
                echo '<p>There are '.$row["Count1"] .' posts and '.$row["Count2"] .' topics!</p>';
            }
        ?>
    </div>
        
    <div class="share">
        <H3>Share this page</H3>
        <div class="icon-bar">
            <a href="https://www.facebook.com" class="facebook"><i class="fa fa-facebook"></i></a> 
            <a href="https://twitter.com" class="twitter"><i class="fa fa-twitter"></i></a> 
            <a href="https://www.youtube.com" class="youtube"><i class="fa fa-youtube"></i></a> 
        </div>
    </div>    
</div>

</body>
</html>