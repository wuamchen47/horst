<?php
require_once($_SERVER['DOCUMENT_ROOT']."/horst/tools/tools.php");

  $DB_HOST = "localhost";
  $DB_USER = "root";
  $DB_PASS = "";
  $DB_NAME = "horst";
  
  $mysqli = new mysqli($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);    

if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

//mysql_set_charset('utf8', $g_db_conn_ajax); // requires MySQL 5
$mysqli->query("SET NAMES 'utf8'");
$mysqli->query("SET CHARACTER SET utf8");

?>
