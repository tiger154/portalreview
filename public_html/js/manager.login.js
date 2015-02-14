<!--
$(document).ready( function() {	
	if($('#login_userid').val() == "") {		
		$('#login_userid').css("background-image", "url("+IMAGES+"/common/bg_login_id.gif)");
		$('#login_userid').css("background-repeat", "no-repeat");
	};
	if($('#login_passwd').val() == "") {		
		$('#login_passwd').css("background-image", "url("+IMAGES+"/common/bg_login_pw.gif)");
		$('#login_passwd').css("background-repeat", "no-repeat");
	};	
	$('#login_userid').bind({ 	
		focusin: function() { $(this).css("background-image", ""); },
		focusout: function(){
			if($(this).val() == "") {
				$(this).css("background-image", "url("+IMAGES+"/common/bg_login_id.gif)");
				$(this).css("background-repeat", "no-repeat");
			}		
		},
		keydown: function(evt) {
			var evCode = (window.netscape) ? evt.which : evt.keyCode;
			if(evCode == 13) result = true;
			else result = false;
			if(result == true) mnglogin.login('login_userid', 'login_passwd', 'login_saveid', '');
		}
	});		
	$('#login_passwd').bind({		
		focusin: function() {
			$(this).css("background-image", "");
		},
		focusout: function(){
			if($(this).val() == "") {
				$(this).css("background-image", "url("+IMAGES+"/common/bg_login_pw.gif)");
				$(this).css("background-repeat", "no-repeat");
			}		
		},
		keydown: function(evt) {
			var evCode = (window.netscape) ? evt.which : evt.keyCode;
			if(evCode == 13) result = true;
			else result = false;
			if(result == true) mnglogin.login('login_userid', 'login_passwd', 'login_saveid', '');
		}
	});
	$('#loginBtn').bind('click', function() { mnglogin.login('login_userid', 'login_passwd', 'saveid', ''); });
	$('#logoutBtn').bind('click', function() { mnglogin.logout(); });	
});

var mnglogin = {
	login: function(userid, passwd, saveid, returl) {
		var userid = encodeURIComponent($('#'+userid).val());
		var passwd = encodeURIComponent($('#'+passwd).val());
		var saveid = ($('input:checkbox[name='+saveid+']').attr('checked') == 'checked') ? $('#'+saveid).val() : "0";
		var returl = encodeURIComponent(returl);
		if(this.valID(userid) == false) {
			return false;
		}
		if(this.valPasswd(passwd) == false) {
			return false;
		}
		var url ="/auth/login.ajax.proc";
		//var data = "&userid=" + $('#login_userid').val() + "&passwd=" + $('#login_passwd').val();
		var data = "&userid=" + userid + "&passwd=" + passwd + "&saveid=" + saveid + "&url=" + returl;
		$.ajax({ type: "POST", url: url, data: data, success: this.loginResult });
	},	
	loginResult: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			common.redirect("/manager");
		} else {
			$('#passwd').val("");
			$('#dialog').html("아이디 또는 비밀번호를 확인하시길 바랍니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "로그인 실패"});
		}
	},
	logout: function() {
		$('#loginForm').attr('method', 'post');
		$('#loginForm').attr('action', '/auth/logout.proc');
		$('#loginForm').submit();
	},	
	valID: function(userid) {
		//var userid = $('#login_userid').val();
		if(userid == "") {
			$('#dialog').html("아이디를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 확인"});
			return false;
		}
		//아이디 하이픈 문제로 블록킹 해제 2011.10.15 박상선
		//if(validation.isEngNum(userid) == false) {
		//	$('#dialog').html("아이디는 영문/숫자로 되어야 합니다.");
		//	$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 확인"});
		//	return false;
		//}
		if(validation.isSpace(userid) == true) {
			$('#dialog').html("아이디는 공백이 없어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 확인"});
			return false;
		}
		if(validation.isLength(userid, 4, 12) == false) {
			$('#dialog').html("아이디는 4~12자리로 되어 있어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 확인"});
			return false;
		}
		return true;
	},
	valPasswd: function(passwd) {
		//var passwd = $('#login_passwd').val();
		if(passwd == "") {
			$('#dialog').html("비밀번호를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "입력값 확인"});
			return false;
		}
		if(validation.isLength(passwd, 4, 25) == false) {
			$('#dialog').html("비밀번호는 4~20자리로 되어 있어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "비밀번호 확인"});
			return false;
		}
		if(validation.isSpace(passwd) == true) {
			$('#dialog').html("비밀번호는 공백이 없어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "비밀번호 확인"});
			return false;
		}
	}
};
-->