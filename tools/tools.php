<?php


//////////////////////////////////////////////////////////////////////////////
// Server and AJAX handling
//////////////////////////////////////////////////////////////////////////////
function IsAjax()
{
  return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
}

function IsLive()
{
  return ($_SERVER["SERVER_ADDR"] == "87.106.160.139");
}

//////////////////////////////////////////////////////////////////////////////
// User and Login handling
//////////////////////////////////////////////////////////////////////////////
function IsLoggedIn()
{
  return (GetSession("s_login") == 1);
}

function GetUserId()
{
  return GetSession("s_user", 0);
}

function GetUserName()
{ 
	return GetSession("s_name");
}

function HasLoginCookie()
{
  return (GetCookie("keks_id") != "");
}

function SetLoginCookie()
{
  $expire = time()+(3600*24*180); //180 tage
  setcookie("keks_id",   GetUserId(),         $expire, '/', false); // hostname=false needed to work on local webserver
  setcookie("keks_pass", $_SESSION["s_pass"], $expire, '/', false);
}

function StartSession()
{
  if (!(isset($_SESSION) && $_SESSION["S47"]))
  {
    session_start();
    $_SESSION["S47"] = TRUE;
  }
}

function IsPapaRauh()
{
  return (GetUserId() == 50);
}

function IsDeveloper()
{
	$userId = GetUserId();
	return ($userId == 1 || $userId == 9 || $userId == 12); // mouke hansi wuam
}

function IsWuam()
{
	$userId = GetUserId();
	return ($userId == 12); 
}
function IsHansi()
{
  return (GetUserId() == 9);
}
function IsIPhone()
{
  $browser = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    if ($browser == true){
      return true;
    }
		else {
			return false;
		}
}


//////////////////////////////////////////////////////////////////////////////
// General
//////////////////////////////////////////////////////////////////////////////

function GetSession($wert, $default="")
{
  if (isset($_SESSION[$wert]))
    return $_SESSION[$wert];
  
  return $default;
}

function GetCookie($wert, $default="")
{
  if (isset($_COOKIE[$wert]))
    return $_COOKIE[$wert];
  
  return $default;
}

function GetGet($wert, $default="")
{
  if (isset($_GET[$wert]))
    return $_GET[$wert];
  
  return $default;
}

function GetPost($wert, $default="")
{
  if (isset($_POST[$wert]))
    return $_POST[$wert];
  
  return $default;
}


//////////////////////////////////////////////////////////////////////////////
// Input handling
//////////////////////////////////////////////////////////////////////////////

function SAFE_GET($wert, $default="")
{  
  // get validated POST or GET variable
  if (isset($_POST[$wert]))
  {
    return ValidateInput($_POST[$wert]);
  }
  else if (isset($_GET[$wert]))
  {
    return ValidateInput($_GET[$wert]);
  }
  else return $default;
}

function SAFE_COOKIE($name)
{
  // get validated cookie value
  return ValidateInput(GetCookie($name));
}

function SAFE_FILENAME($filename)
{
	return ValidateInput($filename);
}


function ValidateInput($input)
{
  // entfernt unerlaubte zeichen und tags aus $input
  /*
  $mysqli->real_escape_string(
    (get_magic_quotes_gpc() == 1 ? stripslashes($input) : $input)
  );*/
  // bestimte Tags zulassen
  $input =  strip_tags($input, '<b><img><font><center>'); 
  return $input;
}

//////////////////////////////////////////////////////////////////////////////
// Encryption
//////////////////////////////////////////////////////////////////////////////

function HorstHash($text)
{
  return md5($text);
}

function HorstEncrypt($text)
{
  // todo
  return $text;
}

//////////////////////////////////////////////////////////////////////////////
// Image handling
//////////////////////////////////////////////////////////////////////////////

$arrValidImage = array( 
                      "jpg"  => TRUE, 
                      "jpeg" => TRUE, 
                      "gif"  => FALSE, 
                      "png"  => TRUE
                      );

function isSupportedImageExtension($ext)
{
    // prüft dateiendung   
    global $arrValidImage; 
    if (isset($arrValidImage[strtolower($ext)]) && $arrValidImage[strtolower($ext)] == TRUE){
        return true;
    }    
    return false;
}

function isSupportedImage($file)
{
    // prüft dateiendung     
    return isSupportedImageExtension( substr(strrchr($file, '.'), 1) ); 
}


function createImageFromXXX($extension, $fullPath)
{  
    $srcImg = 0;  
    switch ($extension) {
        case "jpg":
            $srcImg = imagecreatefromjpeg($fullPath);
            break;
        case "jpeg":
            $srcImg = imagecreatefromjpeg($fullPath);
            break;
        case "png":
            $srcImg = imagecreatefrompng($fullPath);
            break;
        case "gif":
            $srcImg = imagecreatefromgif($fullPath);
            break;
    }				
    return $srcImg;
}

function writeImageXXX($extension, $destImg, $destFile, $quality=25)
{
    $boolResult = FALSE;
    switch ($extension) {
        case "jpg":
            $boolResult = imagejpeg($destImg, $destFile, $quality);
            break;
        case "jpeg":
            $boolResult = imagejpeg($destImg, $destFile, $quality);
            break;
        case "png":
            $boolResult = imagepng($destImg, $destFile);
            break;
        case "gif":
            $boolResult = imagejpeg($destImg, $destFile, $quality);
            break;
    }				   
    return $boolResult; 
}

//////////////////////////////////////////////////////////////////////////////
// Smilie Converter + Insert Linebreak
//////////////////////////////////////////////////////////////////////////////


function insertImages($text)
	{		
		// text parsen und alle smilies durch links ersetzen
		
		$result = "";
		$path = "/horst/js/packs/basic";
        $text = str_replace("\n","<br/>",$text);
    
		$argl = explode(":!", $text);		
		
        for ($i=0; $i < count($argl); $i++) 
		{			
			// erstes vorkommen von ':' suchen
			// wenn die 4 zeichen davor die gewünswchte dateiendung sind, treffer
			// => string durch link ersetzen, rest normal anhängen
			// wenn kein ':' vorkommt oder keine gesuchte datei drin ist, den teilstring 
			// komplett an $result hängen
			
			$pos = strpos($argl[$i], ":");			
			
			if ($pos !== false)
			{
				$file = substr($argl[$i], 0, $pos);
				
				if (substr($file, -4) == ".gif" or substr($file, -4) == ".png")
				{
					$result .= "<img src='$path/$file' alt='' />";
					$result .= substr($argl[$i], $pos+1);
				}
				else $result .= $argl[$i];
			}
			else
			{		
				$result .= $argl[$i];
			}							
			
		}		
		
		return $result;
		
		//return $text;
	}


//////////////////////////////////////////////////////////////////////////////
// Calulate Mongo Score
//////////////////////////////////////////////////////////////////////////////
   
  
  $dayfield = array(31,28,31,30,31,30,31,31,30,31,30,31);
	if (date("Y")%4 == 0) $dayfield[1] = 29;
	
  $monthfield = array("Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");

  function GetTextDate($M, $Y)
	{		
	  //setzt $textdatum z.b. als "Oktober 2001" zusammen.
		global $dayfield, $monthfield;
    //$month = str_replace("0", "", $M);
		return ($monthfield[$M-1]. " " .$Y);
	}

  function GetYear($sqlDate)
  {
    return (int)substr($sqlDate, 0, 4);
  }
  
  function GetMonth($sqlDate)
  {
    return (int)substr($sqlDate, 5, 2);
  }
		
/*	
	//achtung: erwartet $MMYY im format "MM_YY"!	
	function GetStartRead($MMYY)
	{		
		// berechnet z.b. aus 10_01 $startread als 2001-10-01
		$year = "20". substr($MMYY,3,2);
		$month = substr($MMYY,0,2);
		$firstday = "01";
    global $dayfield;
		$lastday = $dayfield[$month-1];
		
		return ($year. "-" .$month. "-" . $firstday);		
	}
	
	function GetEndRead($MMYY)
	{		
	  // berechnet z.b. aus 10_01 $endread als 2001-10-31s
		$year = "20". substr($MMYY,3,2);
		$month = substr($MMYY,0,2);		
    global $dayfield;
		$lastday = $dayfield[$month-1];
		
		return ($year. "-" .$month. "-" . $lastday);		
	}
	
	function GetScore($votes, $startdate, $aktueller_monat)
  {
    // Score = (Anzahl Stimmen / Tage nominiert) * Tage des Monats
    $day = substr($startdate,8,2);
    $month = substr($startdate,5,2);      
    global $dayfield;
    $daysInMonth = $dayfield[$month-1];
    $lastDay = $daysInMonth;
    if ($aktueller_monat) {
      $lastDay = date("d");
    }
    
    $daysNominee = $lastDay - $day + 1;
    $score = ($votes/$daysNominee) * $daysInMonth;
    return $score;
  }

*/
//////////////////////////////////////////////////////////////////////////////
// File handling
//////////////////////////////////////////////////////////////////////////////

// definiert Icons für Filetypen (z.b. für event/download area etc.)
function getIconByFile($file)
{
    $ext = strtolower(substr(strrchr($file, '.'), 1)); 
    if ($ext == "avi" || $ext == "mpg" || $ext == "mpeg" || $ext == "mov"){
        //return "gfx/icon_avi4.gif";
        //return "gfx/winamp.gif";
        return "gfx/horst_movie_sm.jpg";
    }
    return "";
}

// hängt ein Suffix an einen Dateinamen an und lässt die Dateiendung intakt
// foo.jpg -> foo_bar.jpg
function addSuffix($file, $suffix)
{  
  $pieces = explode(".", $file);
  $count = count($pieces);    
  if ($count > 1){
    $pieces[$count-2] .= $suffix;
    $file = implode(".", $pieces);
  }  
  return $file;
}

//////////////////////////////////////////////////////////////////////////////
// Misc
//////////////////////////////////////////////////////////////////////////////

function brecho($strTxt)
{
	echo $strTxt."<br/>";
}

/**
* Simple helper to debug to the console
* 
* @param  Array, String $data
* @return String
*/
	function debug_to_console( $data ) {

		if ( is_array( $data ) )
			$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
		else
			$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

		echo $output;
	}





?>
