<?php
  //
  // user + password gegen db checken
  // wenn erfolgreich, session variablen setzen
  //
   require_once($_SERVER['DOCUMENT_ROOT']."/horst/tools/db_conn.php");
  
  $logout = SAFE_GET("logout");

  if ($logout == "logout"){
    
	session_start();
	$expire = time()-42000;
  	setcookie("keks_id",  "", $expire, '/', false); // hostname=false needed to work on local webserver
  	setcookie("keks_pass", "", $expire, '/', false);
	session_destroy();
    
    echo("loggedOut");
    
  }

?>
