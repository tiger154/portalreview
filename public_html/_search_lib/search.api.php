<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE> New Document </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery/jquery.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery.ui/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/index.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/common.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/layout.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/login.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/validation.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/jquery.init.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/context.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/api.js"></script>
<script type="text/javascript">


	function ajax_sample(){	
		
        var userno; 
		var fuserno; 
 
		userno = 126494; 
		fuserno = 100831;
		
		var url = "/api/search.friend.type.proc";	
		var data = "&userno=" + userno + "&fuserno=" + fuserno;	
		
		$.ajax({ type: "POST", url: url, data: data, success: function(msg) {alert("Data:"+msg);}});
		
	}


$(document).ready( function() {	
	$('#AjaxBtn').bind('click', function() { ajax_sample(); });
	
});

</script>
 </HEAD>


 <BODY>
	<div id="AjaxBtn">1</div>
 </BODY>
</HTML>
