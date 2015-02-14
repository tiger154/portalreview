<!--
$(document).ready( function() {	
	$('#saveBtn').bind('click', function() { myinfo.save(); });
	$('#checkNickBtn').bind('click', function() { myinfo.checkNick(); });
	$('#file1').bind('change', function () {
		if($(this).val() != "") {
			if(validation.isImageFile($(this).val()) == false) {
				$(this).val("");
				$('#dialog').html("이미지 파일(gif,jpg,png)만 가능합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "프로필 이미지 확인"});
			} else {
				$('#form1').attr('target', 'frmFile');
				$('#form1').attr('method', 'post');
				$('#form1').attr('action', '/myrevu/info.image.upload.proc');					
				$('#form1').submit();
			}
		}
	});
	$('#areaBcodeCBox1').bind('change', function () {
		var bcode = $("#areaBcodeCBox1 option:selected").val();
		zipcode.searchMcode(bcode, "areaMcodeCBox1", "areaScodeCBox1");
	});
	$('#areaMcodeCBox1').bind('change', function () {
		var bcode = $("#areaBcodeCBox1 option:selected").val();
		var mcode = $("#areaMcodeCBox1 option:selected").val();
		//zipcode.searchScode(bcode, mcode, "areaScodeCBox1");
	});	
	$('#areaBcodeCBox2').bind('change', function () {
		var bcode = $("#areaBcodeCBox2 option:selected").val();
		zipcode.searchMcode(bcode, "areaMcodeCBox2", "areaScodeCBox2");
	});
	$('#areaMcodeCBox2').bind('change', function () {
		var bcode = $("#areaBcodeCBox2 option:selected").val();
		var mcode = $("#areaMcodeCBox2 option:selected").val();
		//zipcode.searchScode(bcode, mcode, "areaScodeCBox2");
	});
	try { zipcode.set('areaBcodeCBox1', 'areaMcodeCBox1', 'areaScodeCBox1', area1); } 
	catch(err) {}
	try { zipcode.set('areaBcodeCBox2', 'areaMcodeCBox2', 'areaScodeCBox2', area2); } 
	catch(err) {} 
	common.setLayer("zipcodelayer");
	$('#zipcodeBtn').bind('click', function() { common.openLayer('zipcodelayer'); /*zipcode.setForm('zipcode', 'addr1');*/ });
	$('#addrzip').bind('focus', function() { common.openLayer('zipcodelayer'); /*zipcode.setForm('zipcode', 'addr1');*/ }); 
	$('#addr1').bind('focus', function() { common.openLayer('zipcodelayer'); /*zipcode.setForm('zipcode', 'addr1');*/ });
	$('#tmpimage').val("");
});
var secureDomain = "https://www.revu.co.kr";
var myinfo = {	
	// _chkID : false,
	_tmpID : '',
	// _chkNick : false,
	_tmpNick : '',		
	save: function() {
		if(type == "R") {
			if(this.valPasswd() == false) {
				return false;
			}
		}
		if(this.valNick() == false) {
			return false;
		}		
		if($('#tmpnickname').val() != $('#nickname').val()) {
			if(this._tmpNick != $('#nickname').val()) {
				$('#dialog').html("닉네임이 변경되었습니다.<br />닉네임 중복체크를 하셔야 합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 중복 체크"});
				return false;
			}
		}
		if(validation.isEmail($('#email').val()) == false) {
			$('#dialog').html("이메일 형식이 틀립니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "이메일 확인"});
			return false;
		}
		if($('#cell2').val() != "") {
			if(validation.isNumber($('#cell2').val()) == false) {
				$('#cell2').focus();
				$('#dialog').html("휴대폰번호는 숫자로 입력하셔야합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "휴대폰번호 확인"});				
				return false;
			}
		}
		if($('#cell3').val() != "") {
			if(validation.isNumber($('#cell3').val()) == false) {
				$('#cell3').focus();
				$('#dialog').html("휴대폰번호는 숫자로 입력하셔야합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "휴대폰번호 확인"});				
				return false;
			}
		}
		if($('#tel1').val() != "") {
			if(validation.isNumber($('#tel1').val()) == false) {
				$('#tel1').focus();
				$('#dialog').html("전화번호는 숫자로 입력하셔야합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "전화번호 확인"});				
				return false;
			}
		}
		if($('#tel2').val() != "") {
			if(validation.isNumber($('#tel2').val()) == false) {
				$('#tel2').focus();
				$('#dialog').html("전화번호는 숫자로 입력하셔야합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "전화번호 확인"});				
				return false;
			}
		}
		if($('#tel3').val() != "") {
			if(validation.isNumber($('#tel3').val()) == false) {
				$('#tel3').focus();
				$('#dialog').html("전화번호는 숫자로 입력하셔야합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "전화번호 확인"});				
				return false;
			}
		}		
		if(this.valCate() == false) {
			return false;
		}
		var actionurl = secureDomain+"/myrevu/info.modify.proc";
		$('#form1').attr('method', 'post');
		$('#form1').attr('action', actionurl);	
		$('#form1').attr('target', '');	
		$('#form1').submit();
	},		
	valNick: function() {
		var nickname = $('#nickname').val();		
		if(nickname == "") {
			$('#dialog').html("닉네임을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 확인"});
			return false;
		}			
		if(validation.isSpecail(nickname) == false) {
			$('#dialog').html("닉네임은 한글/영문/숫자로 되어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 확인"});
			return false;
		}
		if(validation.isSpace(nickname) == true) {
			$('#dialog').html("닉네임은 공백이 없어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 확인"});
			return false;
		}
		if(validation.isLength(nickname, 2, 12) == false) {
			$('#dialog').html("닉네임은 2~12자리로 되어 있어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 확인"});
			return false;
		}
		return true;
	},
	valPasswd: function() {
		var passwd = $('#passwd').val();
		if($('#passwd').val() == "") {
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
		if($('#passwd_confirm').val() == "") {
			$('#dialog').html("비밀번호를 확인을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "비밀번호 확인"});
			return false;
		}
		if($('#passwd').val() != $('#passwd_confirm').val()) {
			$('#dialog').html("비밀번호를 일치하지 않습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "비밀번호 확인"});
			return false;
		}
		return true;
	},
	valCate: function() {
		//var cnt = $("input[name='cate[]']:checked").length;
		var cnt = checkbox.cnt('cate[]');
		if(cnt > 2) {
			$('#dialog').html("관심분야 선택은 최대 2개 입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "관심분야 확인"});
			return false;			
		}
	},
	checkNick: function() {
		if(this.valNick() == true) {
			var url = "/join/check.nick.proc";
			var data = "&nickname=" + $('#nickname').val();
			$.ajax({ type: "POST", url: url, data: data, success: this.checkNickRequest });
			$('#dialog-modal').dialog({ autoOpen: true });
		}
	},
	checkNickRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			myinfo._tmpNick = result.nickname;
			$('#dialog').html(result.nickname + "는 사용할 수 있는 닉네임입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 중복 체크"});	
		} else {
			myinfo._tmpNick = "";
			$('#dialog').html(result.nickname + "는 이미 사용중인 닉네임 입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 중복 체크"});
		}
	},
	previewUserImage: function(filename) {
		$('#tmpimage').val(filename);
		$('#profile_image').attr('width', '80');
		$('#profile_image').attr('height', '80');
		$('#profile_image').attr('src', DOMAIN_FILE+'/tmp/' + filename);
	},
	initUserImage: function() {
		$('#tmpimage').val("");
		$('#profile_image').attr('width', '80');
		$('#profile_image').attr('height', '80');
		$('#profile_image').attr('src', IMAGES+'/common/profile_blank.gif');
		$('#dialog').html("프로필 이미지업로드가 실패하였습니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "프로필 이미지 확인"});
	}
};
-->