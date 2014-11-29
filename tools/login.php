<?php
  //
  // user + password gegen db checken
  // wenn erfolgreich, session variablen setzen
  //
  require_once($_SERVER['DOCUMENT_ROOT']."/horst/tools/db_conn.php");
  
  function SetLoginSessions($arrUser)
  {
    StartSession();
    $_SESSION["s_login"] = 1;
    $_SESSION["s_user"]  = $arrUser["id"];
    $_SESSION["s_name"]  = $arrUser["name"];
    $_SESSION["s_email"] = $arrUser["email"];
    $_SESSION["s_pass"]  = $arrUser["pass"];
  } 

  function TryCookieLogin()
  {
    if (IsLoggedIn())
      return;
    
    // check if login cookie available
    // if yes, attempt login
    $cookId = SAFE_COOKIE("keks_id");
    $cookPass = SAFE_COOKIE("keks_pass");
    if ($cookId != "" && $cookPass != "")
    {
      $result = $mysqli->query("SELECT * FROM user WHERE id = ".$cookId.";");

      if ($result->num_rows != 0)
      {
        $user = $result->fetch_array(MYSQLI_BOTH);
        if ($user["gesperrt"] != 1 && $user["pass"] == $cookPass)
        {
          StartSession();
          SetLoginSessions($user);
        }
      }
    }    
  }
  
  $loginType = SAFE_GET("logintype");
  
  if ($loginType == "form")
  {
    $LOGIN_SUCCESS = 0;
    $LOGIN_USER_NOT_FOUND = 1;
    $LOGIN_USER_LOCKED_OUT = 2;
    $LOGIN_WRONG_PASSWORD = 3;
    $error = $LOGIN_SUCCESS;  
    
    $pname = SAFE_GET("username");
    $ppass = SAFE_GET("password");

    $sql = "SELECT * FROM user WHERE name='".$pname."';";  
    $rs_pass = $mysqli->query($sql);
    
    if ($rs_pass->num_rows == 0)
    {
      $error = $LOGIN_USER_NOT_FOUND;
    }
    else
    {
      $user = $rs_pass->fetch_array(MYSQLI_BOTH);

      if ($user["gesperrt"] == 1)
      {
        $error = $LOGIN_USER_LOCKED_OUT;
      }
      elseif ($user["pass"] != HorstHash($ppass))
      {
        $error = $LOGIN_WRONG_PASSWORD;
      }
      else
      {
        $error = $LOGIN_SUCCESS;
        SetLoginSessions($user);
        
        if (SAFE_GET("remember") == "true")
        {
          SetLoginCookie();
        }

      }
    }  
    echo($error);  
  }
  
?>