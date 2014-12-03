<?php
  //
  // user + password gegen db checken
  // wenn erfolgreich, session variablen setzen
  //
  require_once($_SERVER['DOCUMENT_ROOT']."/horst/tools/db_conn.php");
   
  $loginType = SAFE_GET("logintype");
  
  if ($loginType == "form")
  {
    $LOGIN_SUCCESS = 0;
    $LOGIN_USER_NOT_FOUND = 1;
    $LOGIN_USER_LOCKED_OUT = 2;
    $LOGIN_WRONG_PASSWORD = 3;
    $error = 42;  
    
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
		
		if ($user["gesperrt"] != 1)
        {		

			if ($user["pass"] == HorstHash($ppass))
		    {
				$error = $LOGIN_SUCCESS;
		        SetLoginSessions($user);
		        
		        if (SAFE_GET("remember"))
		        {
		          SetLoginCookie();
		        }
		  }
	      else
	      {
			$error = $LOGIN_WRONG_PASSWORD;
	      }
		}
		else
		{
			$error = $LOGIN_USER_LOCKED_OUT;
		}
    }

    echo($error);  
  }
  
?>