<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>New Graph api & Javascript Base FBConnect Tutorial | Thinkdiff.net</title>
		<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery/jquery.js"></script>
		<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery.ui/jquery-ui-1.8.13.custom.min.js"></script>
    </head>
    <body>
        <div id="fb-root"></div>
        <script type="text/javascript">
			// _getPositionInfo /engine/_conf/db.[이름].ini 출력 
			// > 해당 파일 하나 추가 해서 디비 접속 가능하게 만들수 있음~! 

            window.fbAsyncInit = function() {
                FB.init({appId: '416936215002292', status: true, cookie: true, xfbml: true});
 
                /* All the events registered */
                FB.Event.subscribe('auth.login', function(response) {
                    // do something with response		
					/*
					{
						  status: "",         // Current status of the session 
						  authResponse: {          // Information about the current session
							userID: ""          // String representing the current user's ID 
							signedRequest: "",  // String with the current signedRequest
							expiresIn: "",      // UNIX time when the session expires  , 5976
							accessToken: "",    // Access token of the user  , 인증 토큰
						  }
					}
					
					*/
//					alert(response.status);
//					alert(response.authResponse.userID);
//					alert(response.authResponse.signedRequest);
//					alert(response.authResponse.expiresIn);
//					alert(response.authResponse.accessToken);
                    login();
                });
                FB.Event.subscribe('auth.logout', function(response) {
                    // do something with response
                    logout();
					
                });
 
                FB.getLoginStatus(function(response) {
                    if (response.session) {
                        // logged in and connected user, someone you know
                        login();
                    }
                });
            };
            (function() {
                var e = document.createElement('script');
                e.type = 'text/javascript';
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
            }());

			function feedsample(){	
					FB.ui(
					{
							method: 'feed',
							message: 'NULL',
							name: 'Its name',
							caption: 'caption here',
							description: 'description here',
							picture: 'http://www.revu.co.kr/images/include/gnb/gnb_logo.gif',
							link: 'http://www.revu.co.kr'
							//actions : [{name : 'action name', link : 'action link'}]
						},
						function(response) {
							if (response && response.post_id) {
								// Post was published
								alert("success");
							} else {
								// Post did get published
								alert("error");
							}

					});
			}

			function ajax_sample(){	
				//alert(1);
				//* 변수 선언 
					var userno; // 로그인 된 유저 UniqueNo
				var fuserno; // 관계확인 유저 UniqueNo 
				
				//* 변수 임의 셋팅[테스팅 목적] 
				userno = 126494; 
				fuserno = 100830;
				
				var url = "/api/search.friend.type.proc";	
				var data = "&userno=" + userno + "&fuserno=" + fuserno;	

				$.ajax({ type: "POST", url: url, data: data, success: function(msg) {alert("Data:"+msg);}});
				
			}
            function login(){
                FB.api('/me', function(response) {
                    document.getElementById('login').style.display = "block";
                    document.getElementById('login').innerHTML = response.name + " succsessfully logged in!";					
					ajax_sample();
                });
            }
            function logout(){
                document.getElementById('login').style.display = "none";
            }
 
            //stream publish method
            function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){
                FB.ui(
                {
                    method: 'stream.publish',
                    message: '',
                    attachment: {
                        name: name,
                        caption: '',
                        description: (description),
                        href: hrefLink
                    },
                    action_links: [
                        { text: hrefTitle, href: hrefLink }
                    ],
                    user_prompt_message: userPrompt
                },
                function(response) {
 
                });
 
            }
            function showStream(){
                FB.api('/me', function(response) {
                    //console.log(response.id);
                    streamPublish(response.name, 'Thinkdiff.net contains geeky stuff', 'hrefTitle', 'http://thinkdiff.net', "Share thinkdiff.net");
                });
            }
 
            function share(){
                var share = {
                    method: 'stream.share',
                    u: 'http://www.revu.co.kr/',
					t: "title"
                };
				
                FB.ui(share, function(response) { 
							if (response && response.post_id){
								
								alert("sucsses");
							}else{ 		
								
								alert("error!!");					
							}
						

						});
			}
//FB.ui(
//  {
//   method: 'feed',
//   message: 'getting educated about Facebook Connect',
//   name: 'Connect',
//   caption: 'The Facebook Connect JavaScript SDK',
//      description: (
//      'A small JavaScript library that allows you to harness ' +
//      'the power of Facebook, bringing the user\'s identity, ' +
//      'social graph and distribution power to your site.'
//   ),
//   link: 'http://www.fbrell.com/',
//   picture: 'http://www.fbrell.com/f8.jpg',
//   actions: [
//        { name: 'fbrell', link: 'http://www.fbrell.com/' }
//   ],
//  user_message_prompt: 'Share your thoughts about RELL'
//  },
//  function(response) {
//    if (response && response.post_id) {
//      alert('Post was published.');
//    } else {
//      alert('Post was not published.');
//    }
//  }
//);


			function getUsername(){
			
				FB.api('/me', function(response) {
				  alert(response.name);
				});
			}

 
            function graphStreamPublish(){
                var body = 'Reading New Graph api & Javascript Base FBConnect Tutorial from Thinkdiff.net';
                FB.api('/me/feed', 'post', { message: body }, function(response) {
                    if (!response || response.error) {
                        alert('Error occured');
                    } else {
                        alert('Post ID: ' + response.id);
                    }
                });
            }
 
            function fqlQuery(){
                FB.api('/me', function(response) {
                     var query = FB.Data.query('select name, hometown_location, sex, pic_square from user where uid={0}', response.id);
                     query.wait(function(rows) {
                       
                       document.getElementById('name').innerHTML =
                         'Your name: ' + rows[0].name + "<br />" +
                         '<img src="' + rows[0].pic_square + '" alt="" />' + "<br />";
                     });
                });
            }
 
            function setStatus(){
                status1 = document.getElementById('status').value;
                FB.api(
                  {
                    method: 'status.set',
                    status: status1
                  },
                  function(response) {
                    if (response == 0){
                        alert('Your facebook status not updated. Give Status Update Permission.');
                    }
                    else{
                        alert('Your facebook status updated');
                    }
                  }
                );
            }
        </script>
 
        <h3>New Graph api & Javascript Base FBConnect Tutorial | Thinkdiff.net</h3>
        <p><fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream,user_about_me"></fb:login-button></p>
 
        <p>
            <a href="#" onclick="showStream(); return false;">Publish Wall Post</a> |
            <a href="#" onclick="share(); return false;">Share With Your Friends</a> |
            <a href="#" onclick="graphStreamPublish(); return false;">Publish Stream Using Graph API</a> |
            <a href="#" onclick="fqlQuery(); return false;">FQL Query Example</a>
			<a href="#" onclick="getUsername();"> GetuserName</a> | 
			<a href="#" onclick="feedsample();"> feedsample</a>
			
        </p>
 
        <textarea id="status" cols="50" rows="5">Write your status here and click 'Status Set Using Legacy Api Call'</textarea>
        <br />
        <a href="#" onclick="setStatus(); return false;">Status Set Using Legacy Api Call</a><br/>
		<a href="/search_lib/ftest.php" >A</a>
 
        <br /><br /><br />
        <div id="login" style ="display:none"></div>
        <div id="name"></div>
 
    </body>
</html>
