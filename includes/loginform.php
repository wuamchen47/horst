
    <div class='col_12'>
    <form id="loginForm" action="#">
        <input type="text" name="loginForm_name" id="loginForm_name" placeholder="Horst">
        <input type="password" name="loginForm_pass" id="loginForm_pass" placeholder="Passwort ">
    </form>
    <button id="submitform" class="small green">Ok</button>
    <button id="hideloglane" class="medium small red pull-right">X</button>
    <div id="loginMessage"></div><div id="cnt" class="versteckt">0</div>
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
                var request = $.ajax({
                    type: "POST",
                    timeout: 7000,
                    data: {username: u, password: p, remember: true, logintype: 'form'},
                    url: "tools/login.php",
                    success: function(result) {
                        if(result != "0") {
                            if (result == "1"){
                                      $("#loginMessage").append('Error!');
                                    }
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
    
