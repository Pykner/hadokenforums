<?php
session_start(); 
?>
<html>
    <head>
        <title>HadokenForums - Posts</title>
        <link rel = "icon" href = "../img/icon.jpg" type = "image/x-icon">
        <link rel="stylesheet" href="../css/homestyle.css?t=<?php echo round(microtime(true)*1000);?>">
        <link rel="stylesheet" href="../css/forums.css?t=<?php echo round(microtime(true)*1000);?>">
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

                $query2 = "SELECT account.user AS topic_user, topics.Topicid, topics.title, topics.txt, topics.date_post, topics.likes 
                
                FROM topics LEFT JOIN account ON account.Accountid = topics.FkAccount
                
                WHERE Topicid = ". $mydb->real_escape_string($_GET['id']);

                $risultato2 = $mydb->query($query2);

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
            <li><a href="forums.php"><i class="fa fa-commenting-o"></i>Forums</a></li>

            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-trophy" ></i>Tournaments</a>
                <div class="dropdown-content">
                    <a href="../tournaments/majorevents.php">Majors</a>
                    <a href="../tournaments/tournamentlist.php">See tournaments</a>
                    <a href="../tournaments/newtournament.php">Create tournament</a>
                    <a href="#">Manage tournaments</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-book"></i>Resources</a>
                <div class="dropdown-content">
                    <a href="../resources/resourceindex.php">See resources</a>
                    <a href="../resources/newresource.php">Submit resource</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-gamepad"></i>Matchmaking</a>
                <div class="dropdown-content">
                <a href="../matchmaking/findmatch.php">See matchmaking</a>
                    <a href="../matchmaking/newmatch.php">Create matchmaking</a>
                    <a href="../matchmaking/modifymatch.php">Manage matchmaking</a>
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
  
        <form class="modal-content animate" id="login" name="login" method="post" action="../scripts/login.script.php">
 
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
        <?php 
        if(!$risultato2)
            {
                echo 'The category could not be displayed, please try again later.' . mysql_error();
            }
            else
            {
                
                    //display topic data
                    while($row = $risultato2->fetch_assoc())
                    {   
                        echo '<div class="forum_title">';
                        echo '<h2>Posts in ′' . $row['title'] . '′ </h2>';
                        echo '</div>';

                        echo '<div class="forumposts">';

                        echo '<table border="1" id="forumposts">
                                <tr>
                                    <th>Parent post</th>
                                    <th>Created</th>
                                </tr>';
                                
                                echo '<tr>';
                                    echo '<td class="leftpart">';
                                        echo '<h2>' . $row['title'] . '</h2>';
                                        echo '<p>' . $row['txt'] . '</p>';
                                    echo '</td>';
                                    echo '<td class="rightpart">';
                                        echo '<h3><a href="../account.php?id=' . $row['topic_user'] . '">' . $row['topic_user'] . '</a></h3>';
                                        echo date('d-m-Y', strtotime($row['date_post']));
                                    echo '</td>';
                                echo '</tr>';
                    }
                
                    //do a query for the topics

                    $query3 = "SELECT  
                                account.user,
                                posts.txt,
                                posts.date_post

                            FROM
                                posts
                                LEFT JOIN account ON posts.FkAccountid = account.Accountid

                            WHERE
                                FkTopicid = " . $mydb->real_escape_string($_GET['id']);
                    
                    $risultato3 = $mydb->query($query3);
                    
                    if(!$risultato3)
                    {
                        echo 'The posts could not be displayed, please try again later.';
                    }
                    else
                    {
                       
                            //prepare the table
                            echo '
                                <tr>
                                    <th>Post</th>
                                    <th>Created</th>
                                </tr>';

                                if(isset($_SESSION["username"])){
                                    echo '<tr>
                                        <td class="leftpart"><h3><a href="newpost.php?id=' . $mydb->real_escape_string($_GET['id']) . '">Create a reply</a></h3></td>
                                        <td class="rightpart"></td>
                                    </tr> '; 
                                }
                                
                            while($row = $risultato3->fetch_assoc())
                            {               
                                            
                                echo '<tr>';
                                    echo '<td class="leftpart">';      
                                    echo '<h3><a href="../account.php?id=' . $row['user'] . '">' . $row['user'] . '</a></h3>';
                                        echo '<p>' . $row['txt'] . '</p>';
                                    echo '</td>';
                                    echo '<td class="rightpart">';
                                        echo date('d-m-Y', strtotime($row['date_post']));
                                    echo '</td>';
                                echo '</tr>';
                            }
                        }
                    }
                
            
            echo '</table>';
            echo '</div">';
?>
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