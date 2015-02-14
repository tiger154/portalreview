<!--
$(document).ready( function() {	
	myblog.stepInit1();
	$('#blogRegBtn1').bind('click', function() { myblog.step1(); });
	$('#blogRegBtn2').bind('click', function() { myblog.step2(); });
	$('#blogPrevBtn2').bind('click', function() { myblog.stepInit1(); });
	$('#blogRegBtn3').bind('click', function() { common.redirect('/'); });
	$('#reviewRegBtn3').bind('click', function() { common.redirect('/myrevu/review.register'); });
});

var myblog = {
	_msg: '',
	stepInit1: function() {	
		$('#regStep01').css('display', 'block');
		$('#regStep02').css('display', 'none');
		$('#regStep03').css('display', 'none');
		$('#blog_url').val('http://');
		$('#rss_url').val('');
		$('#auth_key').val('');
	},	
	stepInit2: function() {
		$('#regStep01').css('display', 'none');
		$('#regStep02').css('display', 'block');
		$('#regStep03').css('display', 'none');
	},	
	stepInit3: function() {
		$('#regStep01').css('display', 'none');
		$('#regStep02').css('display', 'none');
		$('#regStep03').css('display', 'block');
		$('#blog_url').val('http://');
		$('#rss_url').val('');
		$('#auth_key').val('');
	},	
	step1: function() {		
		var url = $('#blog_url').val();
		url = url.toLowerCase().replace(/http:\/\//gi, '');
		url = url.replace(/\?.*$/, '');		
		if(url.match('naver.com') != null) url = url.replace(/\.do$/,'');
		if(url.match(/.+(naver|paran|daum)\.(com|net)\/.+\/.+/) != null) url = url.match(/.+(naver|paran|daum)\.(com|net)\/[^\/]+/)[0];
		if(url.match(/.+(tistory|textcube|egloos)\.com\/.+/) != null) url = url.match(/.+(tistory|textcube|egloos)\.com/)[0];
		url = url.replace(/\/$/,'');		
		if(url == '') {
            $('#dialog').html("블로그 주소를 입력하세요");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "블로그 등록" });
			return false;
        }
        if(url.split('.').length < 2) {
            $('#dialog').html("정확한 블로그 주소를 입력해주세요");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "블로그 등록" });
			return false;
        }
        var url = "/myrevu/blog.validate.url.proc";
		var data = "&blog_url=" + $('#blog_url').val();
		$.ajax({ type: "POST", url: url, data: data, success: this.stepRequest1 });
		$('#dialog-modal').dialog({ autoOpen: true });
	},	
	stepRequest1: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			myblog.stepInit2();
			$('#auth_key').val(result.authkey);			
			$('#rss_url').val(result.url);
		} else if(result.result == "exist") {
			$('#dialog').html("이미 등록된 블로그 주소입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "블로그 등록" });
		} else if(result.result == "validate") {
			$('#dialog').html("유효하지 않은 블로그 주소입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "블로그 등록" });
		} else {
			$('#dialog').html("유효하지 않은 블로그 주소이거나<br />블로그 헤더 정보가 잘못되었습니다.<br />다시 확인하여 주십시오.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "블로그 등록" });
		}
	},	
	step2: function() {
		var auth_key = $('#auth_key').val();
		if(auth_key == '') {
            $('#dialog').html("인증코드가 없습니다. 다시 블로그 주소를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "블로그 등록" });
			myblog.stepInit1();
			return false;
    	}
    	var url = "/myrevu/blog.auth.key.proc";
		var data = "&blog_url=" + $('#blog_url').val() + "&rss_url=" + $('#rss_url').val() + "&auth_key=" + $('#auth_key').val();
		$.ajax({ type: "POST", url: url, data: data, success: this.stepRequest2 });
		$('#dialog-modal').dialog({ autoOpen: true });
	},	
	stepRequest2: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		switch(result.result) {
			case "wrong" : 
				myblog._msg = "발급받은 인증키와 등록하시려는 인증키가 다릅니다. 인증키를 다시 받으십시오.";
				break;
			case "lifetime" : 
				myblog._msg = "블로그 인증시간이 지났습니다. 다시 인증코드를 받으시길 바랍니다.";
				break;
			case "duplication" : 
				myblog._msg = "이미 등록된 블로그 주소입니다.";
				break;
			case "notauth" :
				myblog._msg = "인증이 실패하였습니다. 블로그에 인증코드를 등록하였는지 확인하십시오."; 
				break;
			case "fail" :
				myblog._msg = "등록이 실패하였습니다.";
				break;
			default :
				break;
		}
		if(result.result == "success") {
			myblog.stepInit3();
		} else {
			$('#dialog').html(myblog._msg);
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "블로그 등록" });	
		}
	},
	modifyBlog: function(blogno) {
		$('#dialog2').html("블로그를 수정하시겠습니까?");
		$('#dialog2').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "블로그수정",		
			buttons: { 
				"블로그수정": function(e) { 
					$(this).dialog("close");
					var url = "/myrevu/blog.modify.proc";
					var data = "&blogno=" + blogno + "&name=" + $('#blogName').val();
					$.ajax({ type: "POST", url: url, data: data, success: myblog.modifyBlogRequest });
					$('#dialog-modal').dialog({ autoOpen: true });
				},
				"닫기": function() { $(this).dialog("close");} 
			}
		});
	},	
	modifyBlogRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var msg = "";
		if(result.result == "success") {
			msg = "블로그가 수정되었습니다.";
		} else if(result.result == "info") {
			msg = "정보가 부족합니다.";
		} else if(result.result == "priv") {
			msg = "수정할 권한이 없습니다.";
		} else {
			msg = "블로그 수정이 실패하였습니다.";
		}
		$('#dialog').html(msg);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "블로그수정" });
	},
	deleteBlog: function(blogno) {
		$('#dialog2').html("블로그를 삭제하시겠습니까?<br />블로그를 삭제해도 리뷰는 삭제 되지않습니다.");
		$('#dialog2').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "블로그삭제",		
			buttons: { 
				"블로그삭제": function(e) { 
					$(this).dialog("close");
					var url = "/myrevu/blog.delete.proc";
					var data = "&blogno=" + blogno;
					$.ajax({ type: "POST", url: url, data: data, success: myblog.deleteBlogRequest });
					$('#dialog-modal').dialog({ autoOpen: true });
				},
				"닫기": function() { $(this).dialog("close");} 
			}
		});
	},	
	deleteBlogRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var msg = "";
		if(result.result == "success") {
			common.redirect("/myrevu/blog");
		} else if(result.result == "info") {
			msg = "정보가 부족합니다.";
		} else if(result.result == "priv") {
			msg = "삭제할 권한이 없습니다.";
		} else {
			msg = "블로그 삭제가 실패하였습니다.";
		}
		$('#dialog').html(msg);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "블로그삭제" });
	}
};
-->