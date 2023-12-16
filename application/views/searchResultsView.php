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
                <h2>Search Post </h2>

                <textarea name="searchTag" id="searchTag" rows="5" cols="40"
                    placeholder="Search post by tag (eg: Manga)"></textarea>

                <div class="clearfix">
                    <button type="submit" id="searchPostBtn" class="button">Search</button>
                </div>

            </div>
            <div class="postData" id="postData">

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

    $('#searchPostBtn').click(function(event) {
        event.preventDefault();

        var tagName = $("#searchTag").val();
        if (tagName.length == 0) {
            alert('Search is empty, enter a tag to search');
        } else {
            $("#searchTag").val('');
            $.ajax({
                type: 'GET',
                url: "<?php echo base_url();?>index.php/PostController/getPostByFilterSearch",
                data: {
                    tagName: tagName
                },
                success: function(response) {
                    if (response) {
                        $('#postData').html('');

                        $('#postData').append('<h3>Searching posts related to ' + tagName +
                            '</h3>');

                        $.each(response, function(index, item) {

                            var dataDiv = $('<div>').addClass('data-item post')
                                .data(
                                    'postID',
                                    item.postID);

                            dataDiv.append('<p>@' + item.username + '</p><p>' + item
                                .postDescription + '</p>');

                            $('#postData').append(dataDiv);

                            $.ajax({
                                url: "<?php echo base_url();?>index.php/LikeController/getLikeStatusForUser",
                                type: "GET",
                                data: {
                                    postID: item.postID
                                },
                                success: function(response) {
                                    var likeStatus = response
                                        .likeStatus;

                                    var baseUrl =
                                        '<?php echo base_url(); ?>';

                                    var likeIconHtml = '<img src="' +
                                        baseUrl +
                                        '/assets/images/heart.png" class="like-icon" data-postid="' +
                                        item.postID +
                                        '" width="16" height="16" data-liked="1" />';

                                    if (likeStatus == 1) {
                                        likeIconHtml = '<img src="' +
                                            baseUrl +
                                            '/assets/images/heart_Red.png" class="like-icon" data-postid="' +
                                            item.postID +
                                            '" width="16" height="16" data-liked="-1" />';
                                    }

                                    dataDiv.append(likeIconHtml);

                                    dataDiv.append(
                                        '<span class="like-count">' +
                                        item.likeCount +
                                        '</span>');

                                    dataDiv.append('<img src="' +
                                        baseUrl +
                                        '/assets/images/comment.png" width="16" height="16" alt="comment" class="comment-image">'
                                    );

                                    dataDiv.append(
                                        '<span class="comment-count">' +
                                        item.commentCount +
                                        '</span>');

                                    dataDiv.click(function() {

                                        var postID = $(this)
                                            .data(
                                                'postID');

                                        $.ajax({
                                            url: "<?php echo base_url();?>index.php/PostController/getPostDetails",
                                            type: 'POST',
                                            data: {
                                                postID: postID
                                            },
                                            success: function(
                                                data
                                            ) {

                                                document
                                                    .location
                                                    .href =
                                                    '<?php echo base_url();?>index.php/PostController/getPostDetails?postID=' +
                                                    postID;
                                            }
                                        });
                                    });

                                }
                            });
                        });
                    } else {
                        alert('Entered tag does not exit');
                    }
                }
            });
        }
    });
});
</script>

</html>