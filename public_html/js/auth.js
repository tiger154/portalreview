<!--
$(document).ready( function() {	
	$('#searchIDBtn').bind('click', function() { auth.searchID(); });
	$('#searchPasswdBtn').bind('click', function() { auth.searchPasswd(); });
});

var auth = {	
	searchID: function() {		
		if(validation.isEmail($('#search_email').val()) == false) {
			$('#dialog').html("이메일 형식이 틀립니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "이메일 확인"});
			return false;
		}
		var url = "/auth/search.id.proc";
		var data = "&email=" + $('#search_email').val();
		$.ajax({ type: "POST", url: url, data: data, success: this.searchIDRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},
	searchIDRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var msg = "";
		if(result.result == "success") {
			$('#search_email').val("");
			msg = "가입하실 때 기재하셨던 이메일 주소로<br />메일이 발송 되었습니다.";	
		} else if(result.result == "sendfail") {
			msg = "메일 발송이 실패하였습니다.";
		} else {
			msg = "메일 발송처리가 실패하였습니다.";
		}
		$('#dialog').html(msg);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 찾기"});
	},
	searchPasswd: function() {
		if(this.valID() == false) {
			return false;
		}
		if(validation.isEmail($('#search_email2').val()) == false) {
			$('#dialog').html("이메일 형식이 틀립니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "이메일 확인"});
			return false;
		}
		var url = "/auth/search.passwd.proc";
		var data = "&userid=" + $('#search_id').val() + "&email=" + $('#search_email2').val();
		$.ajax({ type: "POST", url: url, data: data, success: this.searchPasswdRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},	
	searchPasswdRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var msg = "";
		if(result.result == "success") {
			msg = "가입하실 때 기재하셨던 이메일 주소로 메일이 발송 되었습니다.";	
		} else if(result.result == "user") {
			msg = "존재 하지 않는 회원입니다.";
		} else if(result.result == "email") {
			msg = "이메일 정보가 일치 하지 않습니다.";
		} else if(result.result == "sendfail") {
			msg = "메일 발송이 실패하였습니다.";
		} else {
			msg = "메일 발송처리가 실패하였습니다.";
		}
		$('#dialog').html(msg);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "비밀번호 찾기"});
	},
	valID: function() {
		var userid = $('#search_id').val();
		if(userid == "") {
			$('#dialog').html("아이디를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 확인"});
			return false;
		}
		if(validation.isEngNum2(userid) == false) {
			$('#dialog').html("아이디는 영문/숫자와 하이픈(-), 언더바(_)로 되어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 확인"});
			return false;
		}
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
	}
};
-->