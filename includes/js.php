<script type="text/javascript" charset="utf-8">
    
    $( document ).ready(function() {
        $("#showloglane" ).click(function() {
            $( "#loglane" ).load( "includes/loginform.php" );
            $( "#loglane" ).addClass( "transp07" );
            
        });
        <?php
            if (IsLoggedIn()){
        ?>
                $("#comment_button" ).click(function() {
                    $( "#postlane" ).load( "includes/post.php" );
                });
        <?php
            }
        ?>
        
        $('#logoutForm_button').click(function(e){
            e.preventDefault();
            var logout = "logout";
            $.ajax({
                type: "POST",
                timeout: 7000,
                data: {logout: logout},
                url: "tools/logout.php",
                success: function(result) {
                    if(result != "loggedOut") {
                        alert("logout fehlgeschlagen");
                    }
                    else {
                        location.reload();
                    }
                }
            })
        }); 
        
    });
    
    

</script>