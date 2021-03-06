<?php
  error_reporting (E_ALL);
  require_once($_SERVER['DOCUMENT_ROOT']."/horst/tools/db_conn.php");
	StartSession();	
if (!IsLoggedIn() && SAFE_GET("logout") != 1)
    	TryCookieLogin($mysqli);	

?>	

<!DOCTYPE html>
<html>

<head>
    <!-- META -->
    <title>Mobile Horst</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Unser Horst" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/kickstart.css" media="all" />
    <link rel="stylesheet" type="text/css" href="style.css" media="all" />
    <link rel="stylesheet" type="text/css" href="css/jquery.emojiarea.css" media="all" />
    
    <!-- JS -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/kickstart.js"></script>
    <script type="text/javascript" src="js/jquery.emojiarea.min.js"></script>
    <script type="text/javascript" src="js/packs/basic/emojis.js"></script>
    
</head>

<body>
    
    <div class="grid">
        <div id="main">
            <div class="col_8">
            <div id="horstlogo" onclick="window.location.reload(true);" class="col_6"><?php include 'includes/horstlogo.php'; ?></div>
            <div class="col_6">
                    <?php
                       if (IsLoggedIn()){
                          $current_username = GetUserName();
                    ?>
                        <div class="col_12">
                            <button class="medium green" style="cursor:auto;">
                    <?php
						echo  ("Hallo $current_username!<br/>Du bist eingeloggt");
                    ?>
                            </button>
                            <button id="comment_button" class="large orange"><i class="icon-comments"></i></button>
                            <button id="logoutForm_button" class="large red"><i class="icon-signout"></i></button>
                            
                        </div>
                    <?php
                            
                        } else {
                    ?>
                    <div id="loglane" class="col_12">
                        <a id="showloglane" class="button orange" href="#"><i class="icon-signin"></i> Login</a>
                    </div>
                    
                    <?php
                        }
                    ?>
                
            </div>
            </div>
            <div id="postlane" class="col_8">
            </div>
            
            <div id="content" class="col_8">
                <?php include 'includes/newslist.php'; ?>
            </div>

        </div>
    </div>
    <!-- END GRID-->
    
    <?php include 'includes/js.php'; ?>
    
    

</body>

</html>

<?php
    // close sql
    $mysqli->close();
?>