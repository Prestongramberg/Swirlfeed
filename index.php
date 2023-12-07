<?php

global $con, $userLoggedIn;
include("includes/header.php");
if (isset($_POST['post'])) {
    $post = new Post($con, $userLoggedIn);
    $post->submitPost($_POST['post_text'], 'none');
    header("Location: index.php");
}
?>
    <div class="user_details column">
        <a href="<?php
        echo $userLoggedIn; ?>"><img src="<?php
            echo $user['profile_pic']; ?>"></a>
        <div class="user_details_left_right">
            <a href="<?php
            echo $userLoggedIn; ?>">
                <?php
                echo $user['first_name'] . " " . $user['last_name']; ?>
            </a>
            <br>
            <?php
            echo "Posts: " . $user['num_posts'] . "<br>";
            echo "Likes: " . $user['num_likes']; ?>
        </div>
    </div>
    <div class="main_column column">
        <form class="post_form" action="index.php" method="POST">
            <textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
            <input type="submit" name="post" id="post_button" value="Post">
            <hr>
        </form>
        <div class="posts_area"></div>
        <img id="loading" src="assets/images/icons/loading.gif">
    </div>
    <script>
        var userLoggedIn = '<?php echo $userLoggedIn; ?>';

        $(document).ready(function () {
            $('#loading').show();

            // Original ajax request for loading first posts
            $.ajax({
                url: "includes/handlers/ajax_load_posts.php",
                type: "POST",
                data: "page=1&userLoggedIn=" + userLoggedIn,
                cache: false,

                success: function (data) {
                    $('#loading').hide();
                    $('.posts_area').html(data);
                }
            });

            var isLoading = false;

            $(window).scroll(function () {
                var height = $('.posts_area').height(); // Div containing posts
                var scroll_top = $(this).scrollTop();
                var noMorePosts = $('.posts_area').find('.noMorePosts').val();
                if ((document.body.scrollHeight === document.documentElement.scrollTop + window.innerHeight) && noMorePosts === 'false') {
                    if (!isLoading) {
                        $('#loading').show();
                        isLoading = true;
                        var page = $('.posts_area').find('.nextPage').val();

                        var ajaxReq = $.ajax({
                            url: "includes/handlers/ajax_load_posts.php",
                            type: "POST",
                            data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                            cache: false,

                            success: function (response) {
                                $('.posts_area').find('.nextPage').remove(); // Removes current .nextpage
                                $('.posts_area').find('.noMorePosts').remove();
                                isLoading = false;
                                $('#loading').hide();
                                $('.posts_area').append(response);
                            }
                        });
                    }


                } // End if
                return false;
            }); // End $(window).scroll(function()
        });
    </script>
<?php
include("includes/footer.php"); ?>