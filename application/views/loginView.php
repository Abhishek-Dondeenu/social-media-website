<!DOCTYPE html>
<html lang="en">
<?php
				if($this->session->flashdata('Message')){
					?>
<div class="alert alert-danger text-center" style="margin-top:20px;">
    <?php echo $this->session->flashdata('Message'); ?>
</div>
<?php
				}
			?>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>

<body>


    <div class="container">
        <h1>Login</h1>
        <form name="form" class="form" action="" method="POST">
            <div>
                <label for="emailAddress"><b>Email Address</b></label>
                <span class="spanForm">
                    <input type="text" placeholder="Enter Email Address" id="emailAddress" name="emailAddress"><br>
                </span><br>
            </div>
            <div>
                <label for="password"><b>Password</b></label>
                <span class="spanForm">
                    <input type="password" placeholder="Enter Password" id="password" name="password"><br>
                </span><br>
            </div>
            <div class="clearfix">
                <button type="submit" id="loginBtn" class="button">Log In</button>
            </div><br>
            <p><a href="#" style="color:dodgerblue">Forgot Password?</a>.</p>

            <label> Dont have an account?</label>

            <p><a href="<?php echo base_url()?>index.php/UserController/signUp" style="color:dodgerblue">Sign up.</p>
        </form>
    </div>
    <script type="text/javascript" language="Javascript">

    $('#loginBtn').click(function(event) {
        event.preventDefault();

        var emailAddress = $("#emailAddress").val();
        var password = $("#password").val();

        if (emailAddress.length == 0 || password.length == 0) {
            alert('Please fill the necessary details');
        } else {
            $.ajax({
                type: 'POST',
                cache: false,
                url: "<?php echo base_url();?>index.php/UserController/login",
                data: {
                    emailAddress: emailAddress,
                    password: password
                },
                success: function() {
                    window.location.href = '<?php echo base_url()?>index.php/UserController/home';

                }
            });
        }
    });
    
    </script>
</body>

</html>