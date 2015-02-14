<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>New Graph api & Javascript Base FBConnect Tutorial | Thinkdiff.net</title>
		<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery/jquery.js"></script>
		<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery.ui/jquery-ui-1.8.13.custom.min.js"></script>
    </head>


<body>

    <DIV id=fb-root></DIV>
    <SCRIPT type=text/javascript> 



 $(document).ready(function() {
                url = new String(window.location); 
				
				if (url.indexOf("#access_token") > -1)
				{
					ResponsAccessToken = url.substring(url.indexOf("#") + 14, url.indexOf("&"));				
					var userId = ResponsAccessToken.substring(43, 53);
//					alert(ResponsAccessToken);
					// 자신의 정보 가져오기
					$.getJSON("https://graph.facebook.com/me?access_token=" + ResponsAccessToken + "&callback=?", result);
					$.getJSON("https://graph.facebook.com/me/likes?access_token=" + ResponsAccessToken + "&callback=?", likeresult);
					
					//FacebookFqlQuery();
				}
                
});


window.fbAsyncInit = function() {
        FB.init({       
            appId  : '247917975321171',       
            status : true, // check login status        
            cookie : true, // enable cookies to allow the server to access the session  
			oauth  : true, // enable OAuth 2.0
            xfbml  : true  // parse XFBML   
        }); 
        // 회원 로그인 상태체크.     



        // ** like 이벤트가 발생할때 호출된다. 
        FB.Event.subscribe('edge.create', function(response) { 
				
			alert(response);

//				FB.ui(
//				{
//				  method: 'oauth',
//				  display: 'popup',
//				  scope: 'user_likes,friends_likes',
//				  response_type: 'token',
//				  redirect_uri: 'http://www.revu.co.kr/facebook/',
//				  client_id: '247917975321171',
//				},
//				  function() {
//							if (response && response.access_token) {
//								// Post was published
//								alert("access_token success");
//							} else {
//								// Post did get published
//								alert("access_token error");
//							}
//				  
//				  });
//				location.replace("http://www.facebook.com/dialog/oauth?scope=user_likes,friends_likes&client_id=247917975321171&redirect_uri=http://www.revu.co.kr/facebook/&response_type=token");
//				var wnd =window.open('http://www.facebook.com/dialog/oauth?scope=user_likes,friends_likes&client_id=247917975321171&redirect_uri=http://www.revu.co.kr/facebook/popReturn/&response_type=token',false);	
//				wnd.callback = function(value) {
//					alert("window callback");
//				};
        });     
         
        // ** unlike 이벤트가 발생할때 호출된다.   
        FB.Event.subscribe('edge.remove', function(response) {    
			alert("unlike : "+response);
			if (url.indexOf("#access_token") > -1)
				{
					ResponsAccessToken = url.substring(url.indexOf("#") + 14, url.indexOf("&"));				
					var userId = ResponsAccessToken.substring(43, 53);
//					alert(ResponsAccessToken);
					// 자신의 정보 가져오기
					$.getJSON("https://graph.facebook.com/me?access_token=" + ResponsAccessToken + "&callback=?", result);
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

   
		
		function FacebookFqlQuery(){		
			FB.api(            
                {               
                    method: 'fql.query',                
                    //query: "SELECT uid, page_id, type FROM page_fan WHERE page_id = 250860138349344 AND uid= me()",    
					query: "SELECT uid, page_id, type FROM page_fan WHERE page_id = 250860138349344 AND uid= me()",
					access_token : ResponsAccessToken,	
                },  
     
                function(response) {                                
                    //LIKE 한 사용자가 아니라면 response.length 는 "0"을 반환한다.             
                    if( response.length ) {                 
                        alert("like");          
                    } else {                    
                        alert("unlike");
                    }           
                }       
            );  


		}
		
		 function result(data){
				
                userId = data.id; // userID check 
				userName = data.name; // userName check
				userGender = data.gender; //userGender check
				alert(userName+","+userId+","+userGender);
				FacebookFqlQuery();  // like check

//                // 글쓰기 버튼 이벤트 추가
//                $("#btnWrite").click(function(){
//                    var data = $("#taWall").val();
//                    if (data.length <= 0){
//                        alert("글을 입력하세요!");
//                        return;
//                    }
//                    var query = "use 'http://mudchobo.tomeii.com/test/facebook/facebook_wall_table.xml' as htmlpost;" +
//                                    "select * from htmlpost where " +
//                                    "url='https://graph.facebook.com/" + userId + "/feed' " +
//                                    "and postdata='access_token=" + accessToken + "&message=" + encodeURIComponent(data) +"'" +
//                                    "and xpath='//p'";
//                    var url = "http://query.yahooapis.com/v1/public/yql?format=json&callback=?&q=" + 
//                        encodeURIComponent(query) + "&diagnostics=true";
//                    $.getJSON(url, cbResult);
//                });
            }
			 function likeresult(data){
				
//				alert(data.length);
             }
    </SCRIPT>

    <fb:like layout="button_count" send="false" href="http://www.facebook.com/WonJeonHwan" perms="user_likes,email,user_birthday,status_update,publish_stream,user_about_me"></fb:like>
	<fb:like layout="button_count" send="false" href="http://facebook.com/wizwid" ></fb:like>	

</body>	
<?php
phpinfo();
?>
								




   


