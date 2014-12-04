<?php
	          


$start_read=0;
$npp=47;
// anzahl der news auslesen
//$sql = "SELECT COUNT(id) AS 'anzahl' FROM news;";
//$rs_anzahl = $mysqli->query($sql);	  
//$anzahl_news = mysql_fetch_array($rs_anzahl);
    
//jetzt erst die entsprechenden news lesen      
$sql =  "SELECT n.id, n.user, DATE_FORMAT(n.time, '%d.%m.%Y') as fulldate, DATE_FORMAT(n.time, '%d %m') as entry_day_month, YEAR(n.time) as entry_year, DATE_FORMAT(n.time, '%T') as entry_day, n.text, n.linkurl, n.private ";
$sql .= "FROM news n ";
if (!(IsLoggedIn() && !IsPapaRauh())){
  $sql .= "WHERE n.private = 0 ";
}
$sql .= "ORDER BY n.id DESC LIMIT $start_read,$npp;";
      
//echo $sql;
    $rs_news = $mysqli->query($sql);
  
    $avatar_width = 47;
    $avatar_height = $avatar_width * 6/5;      
	$show_avatars = true;
    $currentDay = '';
 
      // und hinmalen      
  while ($news=$rs_news->fetch_array(MYSQLI_BOTH))
  { 
      $has_avatar = false;
      $newsid = $news["id"];
      		
      if ($news["user"] != 0)
      {
        //immer den user zum eintrag holen
        $sql2 = "SELECT name,gast,avatar FROM user WHERE id=" .$news["user"]. ";";                
            $rs_user = $mysqli->query($sql2);
            $user = $rs_user->fetch_array(MYSQLI_BOTH);
  
            $has_avatar = $show_avatars && strlen($user["avatar"]) > 0;
      }
		
      //<!-- Begin Element
      echo "<div class='col_12 transp07'>";
     
      echo "<div class='col_12'>";
      		if ($has_avatar){
				echo "<img class='align-left rund' width='{$avatar_width}' src='../horst/user/avatars/{$user['avatar']}' alt=''/>";             		}
      echo "    <h5>";
      if ($news["user"] != 0){
            	echo $user["name"];
            }  else {
            	$gastname = "Gast.".$news["name"];
                if ( strlen($gastname) > 18 ){
                	echo substr($gastname, 0, 18)."..";
                } else{
                	echo $gastname;
                }
            }
      if (IsLoggedIn() == 1){
           		if ($news["private"] == 1){
               		echo " <i class='icon-lock icon-large'></i>"; 
           		}
        	}
      // edid kommt später ... echo "<button class='medium small green pull-right'><i class='icon-pencil icon-large'></i></button>";
        if ($news["linkurl"] != "none" && $news["linkurl"] != ""){
            echo "<a href='" .$news["linkurl"]. "' class='externalLink'><button class='medium small blue pull-right'><i class='icon-globe icon-large'></i></button></a>";
        }
     echo "</h5><span>";
      echo          $news['fulldate']." | ".$news['entry_day'];
 echo "    </span>";
    echo "</div>";
    echo "<div class='col_12'><blockquote class='small'>";
    echo insertImages($news["text"]);
    echo "</blockquote></div>";
    echo "</div>";
  }
?>