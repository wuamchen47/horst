
    <div class='col_12'>
	    <div class='col_10'>
			<form id="loginForm" action="#">
		        <input type="text" name="loginForm_name" id="loginForm_name" placeholder="Horst">
		        <input type="password" name="loginForm_pass" id="loginForm_pass" placeholder="Passwort ">
				<input type="checkbox" name="loginForm_remember" id="loginForm_remember" value="true" checked="checked"> Merk mich!
		    </form>
		</div>
		<div class='col_2'>
			<button id="submitform" class="small green pull-right">Ok</button>
		</div>
	    <div class='col_12'>
	    	<div id="loginMessage"></div><div id="cnt" class="versteckt">0</div>
		</div>
    </div>
    <script type="text/javascript">
        <!--
        $( document ).ready(function() {
            $("#hideloglane" ).click(function() {
                location.reload();
            });

            $("#submitform" ).click(function() {
                var logcnt = $("#cnt").html();
                if (logcnt <= 3) {
                    $( "#loginForm" ).submit();
                    logcnt++;
                    $("#cnt").html(logcnt);
                } else {
                    $("#loglane" ).remove()
                }
            });
                
            var request;
            $("#loginForm").submit(function(event) {
                if (request) {
                    request.abort();
                }
                var u = $("#loginForm_name").val();
                var p = $("#loginForm_pass").val();
				var r = $("#loginForm_remember").val();
				var request = $.ajax({
                    type: "POST",
                    timeout: 7000,
                    data: {username: u, password: p, remember: r, logintype: 'form'},
                    url: "tools/login.php",
                    success: function(result) {
                        if(result != "0") {
                                $("#loginMessage").html("<b>"+result+"</b> (Pw-Fehler->3, Locked->2, Notfound->1 .. nach 4x error verschwindet die loginbox)");
                                 }
                        else {
                           location.reload();
                       }
                    }

                });
             event.preventDefault();
            });

        });
        -->
    </script>
    
