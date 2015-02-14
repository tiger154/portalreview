<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>New Graph api & Javascript Base FBConnect Tutorial | Thinkdiff.net</title>
		<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery/jquery.js"></script>
		<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery.ui/jquery-ui-1.8.13.custom.min.js"></script>
    </head>
    <body>


<!DOCTYPE html> 
<html xmlns:fb="https://www.facebook.com/2008/fbml">
    <head> 
    </head> 
<body>

    <div id="fb-root"></div>

    <script>
    window.fbAsyncInit = function() {
        FB.init({ appId: '247917975321171', 
            status: true, 
            cookie: true,
            xfbml: true,
            oauth: true
        });

        function updatePage(response) {

            if (response.authResponse) {
                // user is already logged in and connected
                window.location = "fanAuthorized.php";
            } else {
                // user is not connected or logged out
                FB.login(function(response) {
                    if (response.authResponse) {
                        window.location = "fanAuthorized.php";
                    } else {
                        // user has just cancelled login or denied permission
                        window.location = "fanUnauthorized.php";
                    }
                }, {scope:'user_likes'}); 
            }
        }

        // run once with current status and whenever the status changes
        FB.getLoginStatus(updatePage);
        FB.Event.subscribe('auth.statusChange', updatePage);    
    };

(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/ko_KR/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

    </script>

</body> 
</html>