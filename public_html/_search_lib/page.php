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
    <SPAN id=status>  
    <SCRIPT src="http://connect.facebook.net/ko_KR/all.js#xfbml=1">    
    <SCRIPT type=text/javascript> 
        FB.init({       
            appId  : '416936215002292',       
            status : true, // check login status        
            cookie : true, // enable cookies to allow the server to access the session  
            xfbml  : true  // parse XFBML   
        }); 
        // 회원 로그인 상태체크. 
        FB.getLoginStatus(handleSessionResponse);   
         
        // like 이벤트가 발생할때 호출된다. 
        FB.Event.subscribe('edge.create', function(response) {      
            document.getElementById("status").innerHTML = "LIKE!!!!";
        });     
         
        // unlike 이벤트가 발생할때 호출된다.   
        FB.Event.subscribe('edge.remove', function(response) {      
            document.getElementById("status").innerHTML = "UNLIKE!!!!"; 
        });         
         
        function handleSessionResponse(response) {      
            // 로그인하지 않았다면 로그인 유도        
            if (!response.session) {                    
                alert("페북 로그인을 해주세요~!");            
                FB.login(handleSessionResponse);            
                return;     
            }            
             
            //FQL를 사용 page_fan테이블을 조회하여 현재 사용자의 LIKE 명단에 있는지 조회한다. 
            // page_id 는 팬페이지의 고유ID..       
            FB.api (            
                {               
                    method: 'fql.query',                
                    query: "SELECT uid, page_id, type FROM page_fan "+                       
                        "WHERE page_id = 250860138349344 AND uid= "+FB.getSession().uid        
                },  
     
                function(response) {                                
                    //LIKE 한 사용자가 아니라면 response.length 는 "0"을 반환한다.             
                    if( response.length ) {                 
                        document.getElementById("status").innerHTML = "LIKE!!!!";           
                    } else {                    
                        document.getElementById("status").innerHTML = "UNLIKE!!!!";
                    }           
                }       
            );  
        }
	/*
	Using the Graph API /USER_ID/likes/PAGE_ID method

	*/	
		FB.api('/me/likes/250860138349344',function(response) {
		    if( response.data ) {
		        if( !isEmpty(response.data) )
		            alert('You are a fan!');
		        else
		            alert('Not a fan!');
		    } else {
		        alert('ERROR!');
		    }
		});
		 
		// function to check for an empty object
		function isEmpty(obj) {
		    for(var prop in obj) {
		        if(obj.hasOwnProperty(prop))
		            return false;
		    }
		 
		    return true;
		}

	/*
	Using the REST API pages.isFan method
	
	Note below
	 - If the user’s pages are set to less than everyone privacy, you must ask the user for the 'user_likes' extended permission and include 'a valid user access token' in the API call.
	*/
//		FB.api({ method: 'pages.isFan', page_id: '184484190795', uid: 'user_id' }, function(resp) {
//			if (resp == true) {
//			  Log.info('user_id likes the Application.');
//			} else if(resp.error_code) {
//			  Log.error(resp.error_msg);
//			} else {
//			  Log.error("user_id doesn't like the Application.");
//			}
//		});
//
//    /*
//	Using the FQL page_fan table
//	*/
//	   FB.api({
//			method:     'fql.query',
//			query:  'SELECT uid FROM page_fan WHERE uid=user_id AND page_id=page_id'
//		}, function(resp) {
//			if (resp.length) {
//				alert('A fan!')
//			} else {
//				alert('Not a fan!');
//			}
//		}
//	);
    </SCRIPT>
    <fb:like layout="button_count" send="false" href="http://cspark.net"></fb:like>
</body>
</html>
