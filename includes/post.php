
<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/horst/tools/db_conn.php");
  StartSession();
if (IsLoggedIn()){
    
  
  $action = SAFE_GET("action");   
  $newsedit = SAFE_GET("newsedit");
  $newsid = SAFE_GET("newsid", 0);
  
  if ($action == "check_eintrag")
  {
    // eintrag checken und eintragen wenn i.O.
    $post_link = SAFE_GET("linkurl");
    $post_text = SAFE_GET("text");    
    $private = (SAFE_GET("privat") == "true") ? 1 : 0;
    
    if (strlen($post_text) > 1 && strlen($post_text) < 3000)
    {
    if ($post_link == "http://") 
        $post_link = "";
      
      $datum = date("Y-m-d H:i:s");

      if ($newsedit != "1"){
        $sql = "INSERT INTO news (user,time,text,linkurl,private) VALUES (".GetUserId().",'$datum','$post_text','$post_link',$private)";
      }
      else {
        $sql = "UPDATE news SET time='$datum', text='$post_text', linkurl='$post_link', private=$private WHERE id=".$newsid." AND user=".GetUserId().";";
      }
      $mysqli->query($sql);
      
      return;
    }    
  } else {
    // wenn edit, eintrag auslesen
    if ($newsedit == "1" && $newsid > 0)
    {
      $rs_news = $mysqli->query("SELECT * from news WHERE id=$newsid AND user='".GetUserId()."';");
      $r_news = $rs_news->fetch_array(MYSQLI_BOTH);
      if (! $r_news) $newsedit = 0;
    }  

?>

<div class='col_12 transp07'>
<div id="toggle">
    <form action="<?php echo $_SERVER["PHP_SELF"]?>?action=check_eintrag&newsedit=<?php echo $newsedit ?>&newsid=<?php echo $newsid ?>" method="POST" name="formNews" id="formNews" class="vertical">
        <div class="col_12">
            <input type="checkbox" name="formNews_private" id="formNews_private" <?php if (isset($r_news) && $r_news["private"] == 1) echo "checked=\"checked\""; ?>/>
            <label for="formNews_private" class="inline">
                Nur für Horsts!
                <i class="icon-lock icon-large"></i>
            </label>
            <textarea class="emojis-plain" name="formNews_text" id="formNews_text" cols="60" rows="4"><?php if ($newsedit == "1") echo $r_news["text"]; ?></textarea> <div class="newsContainer" id="newsContainer">
            
        </div>

        <div class="col_12">
            <input type="textbox" class="textInput" name="formNews_linkurl" id="formNews_linkurl" size="47" maxlength="500" value="<?php if ($newsedit == '1') echo $r_news['linkurl']; else echo 'http://'; ?>"/>
        </div>

        <div class="col_12">
            <button id="submit_button" class="large orange">Sag's</button>
        </div>
    </form>
    <script language="JavaScript1.2">
      <!--		
          
        $('.emojis-plain').emojiarea({wysiwyg: false});
		
		var $wysiwyg = $('.emojis-wysiwyg').emojiarea({wysiwyg: true});
		var $wysiwyg_value = $('#emojis-wysiwyg-value');
		
		$wysiwyg.on('change', function() {
			$wysiwyg_value.text($(this).val());
		});
		$wysiwyg.trigger('change');
        
      $(document).ready(function(){
          
        $('#submit_button').click(function(e){
          e.preventDefault();
          var checkOk = true;
          var action = "check_eintrag";
          var newsedit47 = "<?php echo $newsedit; ?>";
          var newsid47 = "<?php echo $newsid; ?>";
          var text = $("#formNews_text").val();
          var linkurl = $("#formNews_linkurl").val();
          var privat = $("#formNews_private").prop('checked');
          if (text.length == 0) 
          { 
            $("#newsMessage").html("Ganz leer is aber auch Scheiße..");
            checkOk = false;
          }  
          else if (text.length > 3000)
          {
            $("#newsMessage").html("Du versuchst mehr als 3000 Zeichen einzutragen. Bitte fasse Dich kurz.");
            checkOk = false;
          }        
        
            if (checkOk){
            $.ajax({
              type: "POST",
              timeout: 7000,
              data: {action: action, text: text, linkurl: linkurl, privat: privat, newsedit: newsedit47, newsid: newsid47},
              url: "includes/post.php",
              success: function(result) {
                if(result != 0) {
                  $("#newsMessage").html('<div id="ajax_error">Eintrag fehlgeschlagen!</div>');
                }
                else {
                  location.reload();
                }
              }
            })
          }
            
            
        });  
  		 
       }); 
      
  		-->
      </script>
    
</div>
</div>
        <?php
        }
}
?>