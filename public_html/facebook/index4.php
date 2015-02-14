<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>New Graph api & Javascript Base FBConnect Tutorial | Thinkdiff.net</title>
		<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery/jquery.js"></script>
		<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery.ui/jquery-ui-1.8.13.custom.min.js"></script>
    </head>


<fb:login-button scope="user_likes">
   Likes
</fb:login-button>

<button onclick="checkDoesLike()">Check if user Likes the Page</button>

<h1>Like this Application's Page</h1>
<fb:like-box profile-id="247917975321171"></fb:like-box>

<script>
window.checkDoesLike = function() {
  FB.api({ method: 'pages.isFan', page_id: '247917975321171' }, function(resp) {
    if (resp) {
      Log.info('You like the Application.');
    } else {
      Log.error("You don't like the Application.");
    }
  });
};
</script>



