<!--
$(document).ready( function() {	
	$('#secedeBtn').bind('click', function() { mysecede.confirm(); });
	$('#secedeCancelBtn').bind('click', function() { common.redirect("/myrevu"); });
});

var mysecede = {	
	confirm: function() {
		if(type == "R") {
			if(this.valPasswd() == false) {
				return false;
			}
		}
		if(combobox.getValue('secede_type') == "") {
			$('#dialog').html("탈퇴사유를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "회원탈퇴"});
			return false;
		}
		if(combobox.getValue('secede_type') == "") {
			$('#dialog').html("탈퇴사유를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "회원탈퇴"});
			return false;
		}
		if($('#content').val() == "") {
			$('#dialog').html("기타사유 및 레뷰에게 바라는점을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "회원탈퇴"});
			return false;
		}
		$('#dialog').html("정말 탈퇴를 하시겠습니까?");
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "회원탈퇴 확인",		
			buttons: { 
				"탈퇴하기": function() { mysecede.proc(); },
				"취소": function() { $(this).dialog("close");} 
			}
		});
	}, 	
	valPasswd: function(passwd) {
		var passwd = $('#passwd').val();
		if(passwd == "") {
			$('#dialog').html("비밀번호를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "입력값 확인"});
			return false;
		}
		if(validation.isLength(passwd, 4, 20) == false) {
			$('#dialog').html("비밀번호는 4~20자리로 되어 있어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "비밀번호 확인"});
			return false;
		}
		if(validation.isSpace(passwd) == true) {
			$('#dialog').html("비밀번호는 공백이 없어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "비밀번호 확인"});
			return false;
		}
		if(passwd == "") {
			$('#dialog').html("비밀번호를 확인을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "비밀번호 확인"});
			return false;
		}
		return true;
	},	
	proc: function() {
		$('#dialog-modal').dialog({ autoOpen: true });
		//$('#form1').attr('target', 'frm');
		$('#form1').attr('method', 'post');
		$('#form1').attr('action', '/myrevu/secede.proc');
		$('#form1').submit();
	}
};
-->