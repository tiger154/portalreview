<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>revu facebook</title>
		<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery/jquery.js"></script>
		<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery.ui/jquery-ui-1.8.13.custom.min.js"></script>
		<!--When viewing on a phone, all of the content is zoomed out is hard to tap To fix that problem below cide-->
		<meta name="viewport" content="initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    </head>


<body>

<DIV id=fb-root></DIV>
<SCRIPT type=text/javascript> 

/*****************************
  FB init start 
******************************/

window.fbAsyncInit = function() {
        FB.init({       
            appId  : '247917975321171',       
            status : true, // check login status        
            cookie : true, // enable cookies to allow the server to access the session  
			oauth  : true, // enable OAuth 2.0
            xfbml  : true  // parse XFBML   
        });

		FB.getLoginStatus(function(response) {
		  if (response.status === 'connected') {
			// the user is logged in and connected to your
			// app, and response.authResponse supplies
			// the user’s ID, a valid access token, a signed request, and the time the access token 
			// and signed request each expire
			var back_uid = response.authResponse.userID;
			var accessToken = response.authResponse.accessToken;
			var back_signedRequest = response.authResponse.signedRequest;	
			
			//** Check Fan or not[This speed is very slow]
				usePage_Fan2(back_uid);
			
			//*** Ajax go and return Json data
				var pr_signed_request = back_signedRequest;
				var pr_secret = 247917975321171;
				var url = "/facebook/parse_signedRequest.php";
				var data = "&pr_signed_request=" + pr_signed_request;
					$.ajax({ type: "POST", url: url, data: data, success: signedRequestCallback });
					
				alert('You already logined');
		  } else if (response.status === 'not_authorized') {
			// the user is logged in to Facebook, 
			//but not connected to the app
			alert('You need auth to the app');
		  } else {
			// the user isn't even logged in to Facebook.
			alert('You need to login');
		  }
		});

};
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ko_KR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


/******************************
 Function def area
*******************************/


/* 
	Case1 : visit without login
	Case2 : visit with login
	Case3 : visit with login, but not accept app
*/
function Applogin(){
	FB.login(function(response) {
		  if (response.authResponse) {
			alert('Welcome!  Fetching your information.... ');
			var accessToken = response.authResponse.accessToken;
			FB.api('/me', function(response) {
			 alert('Good to see you, ' + response.name + '.');				  
			});
		  } else {
			alert('User cancelled login or did not fully authorize.');
		  }
		}, {scope: 'user_about_me, email, user_likes, friends_likes, read_stream'});	
}

/*
 @ signedRequestCallback Function 
   - In case, you need parse signedRequest
*/

function signedRequestCallback(data){	
//		alert(data['code']);
		var result = $.parseJSON(data);
//		alert('Code value : '+result.code);
//		alert('algorithm value : '+result.algorithm);
//		alert('issued_at value : '+result.issued_at);
//		alert('user_id value : '+result.user_id);
//		alert('user value : '+result.user); //		
//		alert('oauth_token value : '+result.oauth_token); //
//		alert('expires value : '+result.expires); //
//		alert('app_data value : '+result.app_data);//	
//		alert('page value : '+result.page);//	

}

/*

Report : it's very slow to use so i depreacate this function
           I will use FB.api method instead of that
1. Use FQL > page_Fan

    @ table : page_fan 
	@ param uid : The user ID who has liked the Page being queried. 
	@ param page_id : The ID of the Page being queried.
	@ param type : The type of Page being queried.
	@ param profile_section : The profile section the Page is in on the user's profile..
	@ param created_time : The unix time when the user liked this Page

	rool : SELECT [fields] FROM [table] WHERE [conditions]
	example : SELECT name FROM user WHERE uid = me()
*/

function usePage_Fan(){
		
		 FB.api(   // FB API 를 이용한 FQL 쿼리 사용
		   {
		   method: 'fql.query',
		   query: "SELECT target_id FROM connection WHERE source_id = me() AND target_id = 250860138349344"
		   },
		   function(response) {
			   
				if (response.length == 0){
					alert("페이지 팬 해주시길 바래염!!");   
				}else{
					 alert("당신은 현재 팬이네영~");	
				}			
		   }
		 );  

		
	}

function usePage_Fan2(back_uid){
	FB.api(
		{ 
		method: 'pages.isFan', 
		page_id: '250860138349344',uid:back_uid 
		},
		function(response){
			 if (response == true) {
				  alert('user_id likes the Application.');
				} else if(response.error_code) {
				  alert(response.error_msg);
				} else {
				  alert("user_id doesn't like the Application.");
				}
		}
		); 
}

/***************************************************
	Facebook recommand use via stream.publish or stream.share and FB.ui
	 1. Use FB.ui feed method 
	    
	     -> Response :post_id	, The ID of the posted story, if the user chose to publish
	 2. Use FB.ui with Depreacated REST API method via stream.publish or stream.share
	     -> 사용방법   : FB.ui 활용 
	     ->  Response : This call returns a post_id string containing the ID of the stream item upon success. If the call fails, it returns an error code instead.
	 3. Use  Share Links : 
	     -> 사용방법 : 1) Use social plug-in
	     -> 사용방법 : 2) var sharer = "https://www.facebook.com/sharer/sharer.php?u="; 
	                             window.open(sharer + location.href, 'sharer', 'width=626,height=436');       
	     ->       단점 : 클릭체크 불가, 리턴값 체크 불가 
	   > 당신의 사이트에 방문자가 너의 콘텐츠를 공유하기 더 나은 방법은 Like 버튼을 이용하게 하는것입니다. 
	   > 이것은 클릭률을 높여줍니다. 한번의 클릭으로 연결이 가능하고 어떤 친구들이 이미 연결됬는지 확인할수있습니다. 
	   > 당신의 사이트에 javascript가 인클루드 되어있거나, 버튼스타일의 많은 조절을 원한다면 당신은 이기능을 사용할수있습니다. 
	   > 이기능은 지금은 지원되지 않는  Share Button 에 의해 사용됩니다. 
****************************************************/
function fb_share_custom(){

	  // calling the API ...
        var obj = {
          method: 'feed',
          link: 'http://www.facebook.com/dietlook/app_233968836714259',
          picture: 'http://www.dietlook.co.kr/dietlook/look/popup/images/LookPopup_01.jpg',
          name: '다이어트 룩',
          caption: '다이어트 룩 캡션!',
          description: '다이어트 룩 설명!!!.',
		  properties: 
			[
				{ 
					text: 'Link Test 1', href: 'http://www.naver.com'
				},
				{ 
					text: 'Link Test 2', href: 'http://www.daum.net'
				},
			],	
		  actions : [{name : '다른 피드', link : 'http://www.revu.co.kr'}]
        };

//        function callback(response) {        
//		  alert(response['post_id']);
//        }
		 function callback(response) {  
				if (response && response.post_id) {
					 alert("Post was published");
				} else {
					 alert("Post did get published");
				}
		}	
        FB.ui(obj, callback);

}




</SCRIPT>

<a href="javascript:Applogin()">1. Auth for use app</a> <br/>
<a href="javascript:usePage_Fan2()">2. Check fan </a><br/>
<a href="javascript:fb_share_custom()">3. Share content</a><br/>

<!--
<a name="fb_share" type="icon_link" share_url="http://www.revu.co.kr">Compartir en Facebook</a> 
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
-->

</body>	
					




   


