<!doctype html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>


<body>


    <?php

defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="parent">
        <div id="default" class="child">
            <div class="create">
                <h2 class="homeRedirect">Comic-INN</h2>
                <div class="button-div">
                    <button class="button" id="createPostBtn">Create Post</button><br>
                    <button class="button" id="logOutBtn">Logout</button>
                </div>
            </div>
        </div>
        <div class="home">
            <div class="create">
                <h2>Create Post </h2>
                <form action="" method="post">
                    <textarea name="postDescription" id="postDescription" rows="5" cols="40"
                        placeholder="Type Something"></textarea><br>
                    <button id="createPost" class="button">Create Post</button>
                </form>
            </div>
        </div>
        <div id="search" class="child">
            <div class="create">
                <br><button id="searchBtn" class="searchBtn">Search</button>
                <h2>Tags</h2>
                <?php foreach ($tagData as $data) :?>
                <p class="circular-border"><?php echo $data->tagName;?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" language="Javascript">
$(document).ready(function() {
    
    $('#searchBtn').click(function() {
        window.location.href = '<?php echo base_url()?>index.php/PostController/searchResultsView';
    });

    $('#createPostBtn').click(function() {
        window.location.href = '<?php echo base_url()?>index.php/PostController';
    });

    $('#logOutBtn').click(function() {
        window.location.href = '<?php echo base_url()?>index.php/UserController/logout';
    });

    $('.homeRedirect').click(function() {
        window.location.href = '<?php echo base_url()?>index.php/UserController/home';
    });

    $('#createPost').click(function(event) {
        event.preventDefault();

        var postDescription = $("#postDescription").val();

        if (postDescription.length == 0) {
            alert('Post Content is empty, please type something');
        }else{
            $.ajax({
            type: 'POST',
            cache: false,
            url: "<?php echo base_url();?>index.php/PostController/createPost",
            data: {
                postDescription: postDescription
            },
            success: function() {
                alert('Post Created');
                location.reload();
            }
        });
        }
    });
});
</script>

</html>