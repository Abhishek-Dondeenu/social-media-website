    <?php

    defined('BASEPATH') OR exit('No direct script access allowed');
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
        <title>Sign Up</title>
    </head>

    <body>
        <div class="container">
            <h1>Sign Up</h1>
            <form name="form" class="form" action="" method="POST">

                <div>
                    <label for="fullName"><b>Full Name</b></label>
                    <span class=span>
                        <input type="text" placeholder="Enter Full Name" id="fullName" name="fullName"><br>
                    </span><br>
                </div>

                <div>
                    <label for="userName"><b>User Name</b></label>
                    <span class=span>
                        <input class="spanForm" type="text" placeholder="Enter User Name" id=userName
                            name="userName"><br>
                    </span><br>
                </div>

                <div>
                    <label for="emailAddress"><b>Email Address</b></label>
                    <span class=span>
                        <input class="spanForm" type="text" placeholder="Enter Email Address" id=emailAddress
                            name="emailAddress"><br>
                    </span><br>
                </div>

                <div>
                    <label for="password"><b>Password</b></label>
                    <span class=span>
                        <input class="spanForm" type="password" placeholder="Enter Password" id=password
                            name="password"><br>
                    </span><br>
                </div>

                <div>
                    <label for="cPassword"><b>Confirm Password</b></label>
                    <span class=span>
                        <input class="spanForm" type="password" placeholder="Confirm Password" id=cPassword
                            name="cPassword"><br>
                    </span><br>
                </div>

                <div>
                    <div class="clearfix">
                        <button type="submit" id="signupBtn" class="button">Sign Up</button>
                    </div><br>
                </div>

                <label> Already Have an Account?</label>

                <p><a href="<?php echo base_url()?>index.php/UserController/loginView" style="color:dodgerblue">Log In</a>
                </p>
            </form>

        </div>
        <script type="text/javascript" language="Javascript">
        $(document).ready(function() {
            var User = Backbone.Model.extend({
                defaults: {
                    fullName: "",
                    userName: "",
                    emailAddress: "",
                    password: ""
                },
                urlRoot: '<?php echo base_url()?>index.php/UserController/submitUserData'
            });

            $('#signupBtn').click(function(event) {
                event.preventDefault();
                var fullName = $("#fullName").val();
                var userName = $("#userName").val();
                var emailAddress = $("#emailAddress").val();
                var password = $("#password").val();
                var cPassword = $("#cPassword").val();
                var u = new User();

                var userDetails = {
                    'fullName': fullName,
                    'userName': userName,
                    'emailAddress': emailAddress,
                    'password': password
                };

                if (fullName.length == 0 || userName.length == 0 || emailAddress.length ==
                    0 || password
                    .length == 0 || cPassword.length == 0) {

                    alert('Please fill the necessary details');
                } else if (password.localeCompare(cPassword)) {
                    alert('Please confirm password');
                } else {
                    u.save(userDetails, {
                        async: false,
                        success: function() {
                            alert('Form has been filled');
                        }
                    });
                    alert('Form has been filled');
                    window.location.href =
                        '<?php echo base_url()?>index.php/UserController/loginView';
                }
            });
        });
        </script>

    </body>

    </html>