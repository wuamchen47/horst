<?php
  //
  // user + password gegen db checken
  // wenn erfolgreich, session variablen setzen
  //
  require_once("../tools/db_conn.php");
  
  $logout = SAFE_GET("logout");
  
  if ($logout == "logout"){
    $zeit = date("Y-m-d H:i:s");
    $current_username = GetSession("s_name");
    $sql = "insert into logs (name, logout( values ('$current_username', '$zeit');";
    mysql_query($sql);
    
    session_start();
    session_unset();
    session_destroy();
    
    echo("loggedOut");
    
  }

?>
