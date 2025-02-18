<?php
session_start(); 
?>
<html>
    <head>
        <title>HadokenForums - ProfilePage</title>
        <link rel = "icon" href = "img/icon.jpg" type = "image/x-icon">
        <link rel="stylesheet" href="css/homestyle.css?t=<?php echo round(microtime(true)*1000);?>">
        <link rel="stylesheet" href="css/profile.css?t=<?php echo round(microtime(true)*1000);?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>

    <?php
			/*instauro la connessione al database */
			include("scripts/config.php");  //file di config con i parametri di connessione
				$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
				if ($mydb->connect_errno) {
					echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
					exit();  //termina la pagina
				}
				
				$query1 = "SELECT COUNT(Accountid) AS num_account FROM account";
				//eseguo la query
				$risultato1 = $mydb->query($query1);

                $query2 = "SELECT Accountid, user, email, stat , pic FROM account WHERE user = '". $mydb->real_escape_string($_GET['id']) ."'";

				//eseguo la query
				$risultato2 = $mydb->query($query2);
                
                $querypost = "SELECT 
                (SELECT count(Postid) FROM posts ) AS Count1,
                (SELECT count(Topicid) FROM topics ) AS Count2
              FROM posts, topics LIMIT 0,1";

                $risultatopost = $mydb->query($querypost);
			?>

        
    <script src="js/playsound.js"></script>
    <div class="header">

        <audio id="audio" src="sound/hadoken.mp3"></audio>   
        <img id="img" src="img/hadokenlogo.png" value="PLAY"  onclick="play()">

    </div>

    <nav class="navbar">
        <ul>
            <li><a href="index.php"><i class="fa fa-fw fa-home"></i>Home</a></li>
            <li><a href="forums/forums.php"><i class="fa fa-commenting-o"></i>Forums</a></li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-trophy" ></i>Tournaments</a>
                <div class="dropdown-content">
                    <a href="tournaments/majorevents.php">Majors</a>
                    <a href="tournaments/tournamentlist.php">See tournaments</a>
                    <a href="tournaments/newtournament.php">Create tournament</a>

                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-book"></i>Resources</a>
                <div class="dropdown-content">
                    <a href="resources/resourceindex.php">See resources</a>
                    <a href="resources/newresource.php">Submit resource</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-gamepad"></i>Matchmaking</a>
                <div class="dropdown-content">
                    <a href="matchmaking/findmatch.php">See matchmaking</a>
                    <a href="matchmaking/newmatch.php">Create matchmaking</a>
      
                </div>
            </li>
            
            <?php

            if(isset($_SESSION["username"])){
                ?><li style="float:right"><a href='account.php?id=<?php echo $_SESSION["username"]?>'><i class="fa fa-user"></i><?php echo $_SESSION["username"]?></a>
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
      <span class="psw">Don't have an account? <a href="register.php">register</a></span>

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
    <?php if(isset($_SESSION["id"])){ ?>

        <div class="accountdetails">
            <div class="profilepic">
            <?php
				while($row=$risultato2->fetch_assoc()){
			?>
                <img id="prf" src="<?php echo ($row['pic']); ?>">
            </div>
            
            <div class="viewing">
            
            <h1>Viewing <?php echo ($row['user']);  ?></h1>

            <div class="status">
                <p><?php echo ($row['stat']); ?></p>
            </div>

            </div>
            <div style="clear:both;"></div>

            <h1>Latest from this user:</h1>

            <div class="tabs">
                <button class="tablink" onclick="openTab('posts', this, '#F8B552')" id="defaultOpen">Topics</button>
                <button class="tablink" onclick="openTab('resources', this, '#F8B552')">Resources</button>
                <button class="tablink" onclick="openTab('tournaments', this, '#F8B552')">Tournaments</button>
                <button class="tablink" onclick="openTab('matchmaking', this, '#F8B552')">Matchmaking</button>
            </div>

                <div id="posts" class="tabcontent">
                    <?php
                        $querytopic = "SELECT  
                            topics.Topicid,
                            topics.title AS topic_title,
                            topics.txt,
                            topics.date_post,
                            account.user
                        FROM
                            topics
                        LEFT JOIN
                            account ON account.AccountId = topics.FkAccount 
                        WHERE 
                            account.user ='" . $mydb->real_escape_string($_GET['id']) . "'
                        ORDER BY Topicid DESC
                        LIMIT 0,3"
                          ;
            
                $risultatotopic = $mydb->query($querytopic);
                        if(!$risultatotopic)
                        {
                            echo 'The topics could not be displayed, please try again later.';
                        }
                        else
                        {       
                            if(mysqli_num_rows($risultatotopic) == 0){
                       
                                echo'<p>This user has not created any topics yet</p>';
                           
                        }else{    
                                while($row = $risultatotopic->fetch_assoc())
                                {               
                                    echo '<div class="tabheader_content">';
                                        echo '<h1><a href="forums/topic.php?id=' . $row['Topicid'] . '">' . $row['topic_title'] . '</a></h1>';
                                        echo '<p>'. $row['txt'] .'</p>';
                                    echo '</div>';

                                    echo '<div class="tabheader_leftinfo">';
                                        echo '<h2>';
                                            echo date('d-m-Y', strtotime($row['date_post']));
                                        echo '</h2>';
                                    echo '</div>';
                                    echo'<div style="clear:both;"></div>';
                                       
                                }
                            }
                        }
                        
                    ?>
                </div>

                <div id="resources" class="tabcontent">
                    <?php
                        $queryresources = "SELECT  
                            resources.Resourceid,
                            resources.title AS resource_title,
                            account.user,
                            resources.valid,
                            game.title
                        FROM
                            resources
                        INNER JOIN
                            account ON account.AccountId = resources.FkAccountid
                        LEFT JOIN
                            game ON game.Gameid = resources.Fkgameid
                        WHERE 
                            account.user ='" . $mydb->real_escape_string($_GET['id']) . "'
                        ORDER BY Resourceid DESC
                        LIMIT 0,3"
                        ;
        
                $risultatoresources = $mydb->query($queryresources);
                if(!$risultatoresources)
                {
                    echo 'The resources could not be displayed, please try again later.';
                }
                else
                {        
                     if(mysqli_num_rows($risultatoresources) == 0){
                       echo'<p>This user has not posted any resources yet</p>';
                    }else{  
                        while($row = $risultatoresources->fetch_assoc())
                        {               
                            echo '<div class="tabheader_content">';
                                echo '<h1><a href="resource/resource.php?id=' . $row['Resourceid'] . '">' . $row['resource_title'] . '</a></h1>';                             
                            echo '</div>';

                            echo '<div class="tabheader_leftinfo">';
                                echo '<h2>';
                                    echo  $row['title'];
                                echo '</h2>';

                                echo '<h2>';
                                    if($row['valid'] == 0){
                                        echo 'Resource not validated yet';
                                    }else{
                                        echo 'Valid resource';
                                    }
                                echo '</h2>';
                            echo '</div>';
                            echo'<div style="clear:both;"></div>';
                           
                        }
                    }
                }

                    ?>
                </div>

                <div id="tournaments" class="tabcontent">
                    <?php
                        $querytourneys = "SELECT  
                        tournament.id,
                        tournament.title AS tournament_title,
                        tournament.link,
                        tournament.txt,
                        tournament.data_inizio,
                        tournament.data_fine,
                        tournament.online,
                        account.user
                    FROM
                        tournament
                    LEFT JOIN
                        account ON account.AccountId = tournament.FkAccountid
                    WHERE 
                        account.user ='" . $mydb->real_escape_string($_GET['id']) . "'
                    ORDER BY id DESC
                    LIMIT 0,3" 
                    ;
    
                $risultatotourneys = $mydb->query($querytourneys);
                
                if(!$risultatotourneys)
                {
                    echo 'The resources could not be displayed, please try again later.';
                }
                else
                {      
                    if(mysqli_num_rows($risultatotourneys) == 0){
                       
                            echo'<p>This user has not created a tournament yet</p>';
                       
                    }else{     
                        while($row = $risultatotourneys->fetch_assoc())
                        {               
                            echo '<div class="tabheader_content">';
                                echo '<h1><a href="tournaments/tournament.php?id=' . $row['id'] . '">' . $row['tournament_title'] . '</a></h1>';
                                echo '<p><a href="' . $row['link'] . '">Tournament Link</a><p>';                             
                            echo '</div>';

                            echo '<div class="tabheader_leftinfo">';
                                echo'<h2>Start date:</h2>';
                                echo '<p>';
                                    echo  $row['data_inizio'];
                                echo '</p>';

                                if($row['online'] == 1){
                                    echo'<h2>Online Tournament</h2>';
                                }
                            echo '</div>';
                            echo'<div style="clear:both;"></div>';
                            
                               
                        }
                        }
                    }
                    ?>
                </div>

                <div id="matchmaking" class="tabcontent">
                    <?php
                        $querymatchmaking = "SELECT  
                        matchmaking.Matchmakingid, 
                        matchmaking.skill_level, 
                        matchmaking.active, 
                        game.title, 
                        matchmaking.sys,
                        matchmaking.play_hour, 
                        matchmaking.communication, 
                        matchmaking.txt, 
                        matchmaking.region, 
                        account.user
                    FROM matchmaking 
                    INNER JOIN account ON account.Accountid = matchmaking.FkAccountid 
                    LEFT JOIN game ON game.Gameid = matchmaking.FkGameid
                    
                    WHERE 
                        account.user ='" . $mydb->real_escape_string($_GET['id']) . "'";
    
                $risultatomatchmaking = $mydb->query($querymatchmaking);
                
                if(!$risultatomatchmaking)
                {
                    echo 'The resources could not be displayed, please try again later.';
                }
                else
                {      
                    if(mysqli_num_rows($risultatomatchmaking) == 0){
                       
                            echo'<p>This user has not created a match post yet</p>';
                       
                    }else{     
                        while($row = $risultatomatchmaking->fetch_assoc())
                        {               
                            echo '<div class="tabheader_content">';
                                echo '<h1>Game: ' . $row['title'] . '</h1>';
                                echo '<h2>' . $row['sys'] . ': '.$row['communication'].'</h2>';
                                echo '<p>' . $row['txt'] . '</p>';                             
                            echo '</div>';

                            echo '<div class="tabheader_leftinfo">';
                                echo'<h2>Skill level:</h2>';
                                echo '<p>';
                                    echo  $row['skill_level'];
                                echo '</p>';

                                echo'<h2>Hours played:</h2>';
                                echo '<p>';
                                    echo  $row['play_hour'];
                                echo '</p>';

                                echo'<h2>region:</h2>';
                                echo '<p>';
                                    echo  $row['region'];
                                echo '</p>';

                                if($row['active'] == 1){
                                    echo'<h1>Available</h1>';
                                }else{
                                    echo'<h1>Unavailable</h1>';
                                }



                                
                            echo '</div>';
                            echo'<div style="clear:both;"></div>';
                            
                               
                        }
                        }
                    }
                    ?>
                </div>

                <script src="js/tabheader.js"></script>
            
                <?php
                    if($_SESSION['username'] == $mydb->real_escape_string($_GET['id'])){
                ?>
            <button class="btnform"> <a id="out" href="editaccount.php">Edit account</a></button>
            <button class="btn"> <a id="out" href="scripts/logout.script.php">Log out</a></button>
                <?php
                    }
                ?>
        </div>

        <?php }}
        else{
            echo'<p style="color:white;">You must be logged in to view accounts</p>';
        }?>
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