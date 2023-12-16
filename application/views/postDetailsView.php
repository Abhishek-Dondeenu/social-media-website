<!doctype html>
<html>
<?php

defined('BASEPATH') OR exit('No direct script access allowed');
?>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>

<body>
    <div class="parent">
        <div id="default" class="child">
            <div class="create">
                <h2 class="homeRedirect">Comic-INN</h2>
                <div class="button-div">
                    <button class="button" id="createPostBtn">Create Post</button><br>
                    <button class="button" id="logOutBtn" class="logOutBtn">Logout</button>
                </div>
            </div>
        </div>
        <div class="home">
            <h2>Post Details</h2>
            <div class="post-home" id="post-home">
                <?php foreach ($postData as $data) :?>
                <div class="post" id="post">
                    <div class="clickable">
                        <input class="invisible-input" id="postID" value="<?php echo $data['postID']; ?>">
                        <p>@<?php echo $data['username'];?></p>
                        <p><?php echo $data['postDescription'];?></p>
                    </div>
                    <div id="likeStatus" class="likeStatus">
                        <?php
                        $likeStatus = $this->LikeModel->getLikeStatusForUser($data['postID']);
                        $imgSrc = ($likeStatus == 1) ? base_url('assets/images/heart_Red.png') : base_url('assets/images/heart.png');
                        $liked = ($likeStatus == 1) ? -1 : 1;
                        ?>
                        <img src="<?php echo $imgSrc; ?>" id="like-icon" class="like-icon"
                            data-postid="<?php echo $data['postID']; ?>" width="16" height="16"
                            data-liked="<?php echo $liked; ?>" />
                        <span class="like-count">
                            <?php echo $data['likeCount']; ?>
                        </span>
                        <img src="<?php echo base_url('assets/images/comment.png'); ?>" width="16" height="16"
                            alt="comment" class="comment-image">
                        <span class="comment-count">
                            <?php echo $data['commentCount']; ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <h3>Comments</h3>
            <form action="" method="POST">
                <textarea name="commentDescription" id="commentDescription" rows="5" cols="40"
                    placeholder="Comment Something"></textarea>
                <div class="clearfix">
                    <button type="submit" id="createCommentBtn" class="button">Comment</button>
                </div>
            </form>
            <div>
                <?php foreach ($commentData as $data) :?>
                <p>@<?php echo $data['username'];?></p>
                <p><?php echo $data['commentDescription'];?></p>
                <hr>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="search" class="child">
            <div class="">
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
        window.location.href = '<?php echo base_url()?>index.php/PostController/SearchResultsView';
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

    $('#like-icon').click(function(event) {
        event.preventDefault();
        var postID = $(this).data('postid');
        var liked = $(this).attr('data-liked');
        var likeCountSpan = $(this).siblings('.like-count');

        if (liked == 1) {
            $(this).attr('src',
                '<?php echo base_url()?>assets/images/heart_Red.png');
            $(this).attr('data-liked', -1);
        } else {
            $(this).attr('src', '<?php echo base_url()?>assets/images/heart.png');
            $(this).attr('data-liked', 1);
        }

        $.ajax({
            url: "<?php echo base_url();?>index.php/LikeController/likePost",
            type: 'POST',
            data: {
                postID: postID,
                liked: liked
            },
            success: function(response) {
                var likeCount = response.likeCount;
                likeCountSpan.text(response.likeCount);
            }
        });
    });

    $('#createCommentBtn').click(function(event) {
        event.preventDefault();
        var commentDescription = $("#commentDescription").val();
        var postID = $("#postID").val();
        if (commentDescription.length == 0) {
            alert('Comment is empty, please type something');
        }else{
            $.ajax({
            type: 'POST',
            cache: false,
            url: "<?php echo base_url();?>index.php/CommentController/createComment",
            data: {
                commentDescription: commentDescription,
                postID: postID
            },
            success: function() {
                location.reload();
            }
        });
        }
    });
});
</script>

</html>