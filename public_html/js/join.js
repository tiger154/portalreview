<!--
$(document).ready( function() {	
	$('#agreeBtn').bind('click', function() { join.agree(); });
	$('#agreeCancelBtn').bind('click', function() { common.redirect("/"); });
	$('#joinBtn').bind('click', function() { join.join(); });
	$('#joinCancelBtn').bind('click', function() { common.redirect("/join"); });
	$('#joinSNSBtn').bind('click', function() { join.joinSNS(); });
	$('#joinSNSCancelBtn').bind('click', function() { common.redirect("/"); });
	$('#checkIDBtn').bind('click', function() { join.checkID(); });
	$('#checkNickBtn').bind('click', function() { join.checkNick(); });
	$('#joinConfirmBtn').bind('click', function() { common.redirect("/"); });
	$('#checkRecomIDBtn').bind('click', function() { join.checkRecomID(); });	
	$('#file1').bind('change', function () {
		if($(this).val() != "") {
			if(validation.isImageFile($(this).val()) == false) {
				$(this).val(""); 
				$('#dialog').html("이미지 파일(gif,jpg,png)만 가능합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "프로필 이미지 확인"});
			} else {
				$('#dialog-modal').dialog({ autoOpen: true });
				$('#form1').attr('target', 'frmFile');
				$('#form1').attr('method', 'post');
				$('#form1').attr('action', '/join/image.upload.proc');					
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
	try { zipcode.set('areaBcodeCBox1', 'areaMcodeCBox1', 'areaScodeCBox1', ''); } 
	catch(err) {}
	try { zipcode.set('areaBcodeCBox2', 'areaMcodeCBox2', 'areaScodeCBox2', ''); } 
	catch(err) {}
	common.setLayer("zipcodelayer");
	$('#zipcodeBtn').bind('click', function() { common.openLayer('zipcodelayer'); /*zipcode.setForm('zipcode', 'addr1');*/ });
	$('#addrzip').bind('focus', function() { common.openLayer('zipcodelayer'); /*zipcode.setForm('zipcode', 'addr1');*/ }); 
	$('#addr1').bind('focus', function() { common.openLayer('zipcodelayer'); /*zipcode.setForm('zipcode', 'addr1');*/ });
});

var join = {	
	// _chkID : false,
	_tmpID : '',
	// _chkNick : false,
	_tmpNick : '',		
	agree: function() {		
		if(radio.getValue('agree_confirm') == "0") {
			$('#dialog').html("이용약관에 동의하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "약관동의" });
			return false;
		}
		if(radio.getValue('policy_confirm1') == "0") {
			$('#dialog').html("1. 개인정보의 수집 및 이용 목적에 동의하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "개인정보의 수집 및 이용 목적 동의" });
			return false;
		}
		if(radio.getValue('policy_confirm2') == "0") {
			$('#dialog').html("2. 수집하는 개인정보 항목에 동의하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "수집하는 개인정보 항목 동의" });
			return false;
		}
		if(radio.getValue('policy_confirm3') == "0") {
			$('#dialog').html("3. 개인정보의 보유 및 이용기간에 동의하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "개인정보의 보유 및 이용기간 동의" });
			return false;
		}
		if(radio.getValue('policy_confirm4') == "0") {
			$('#dialog').html("4. 개인정보의제공 및 취급 위탁에 동의하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "개인정보의제공 및 취급 위탁 동의" });
			return false;
		}
		$('#form1').attr('method', 'post');
		$('#form1').attr('action', '/join/step1');
		$('#form1').submit();
	},	
	join: function() {		
		if(this.valUsername() == false) {
			return false;
		}
		if(this.valID() == false) {
			return false;
		}
		if(this._tmpID != $('#userid').val()) {
			$('#dialog').html("아이디 중복체크를 하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 중복 체크"});
			return false;
		}		
		if(this.valPasswd() == false) {
			return false;
		}
		if(this.valNick() == false) {
			return false;
		}
		if(this._tmpNick != $('#nickname').val()) {
			$('#dialog').html("닉네임 중복체크를 하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 중복 체크"});
			return false;
		}
		if(validation.isEmail($('#email').val()) == false) {
			$('#dialog').html("이메일 형식이 틀립니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "이메일 확인"});
			return false;
		}		
		/*
		if($('#recomid').val() != "") {
			if(this.valRecomID() ==  false) {
				return false;
			}
		}
		*/		
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
		$('#dialog-modal').dialog({ autoOpen: true });
		$('#form1').attr('method', 'post');
		$('#form1').attr('action', '/join/step1.proc');	
		$('#form1').attr('target', '');	
		$('#form1').submit();
	},	
	joinSNS: function() {		
		if(this.valUsername() == false) {
			return false;
		}
		if(this.valNick() == false) {
			return false;
		}
		if(this._tmpNick != $('#nickname').val()) {
			$('#dialog').html("닉네임 중복체크를 하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 중복 체크"});
			return false;
		}
		if(validation.isEmail($('#email').val()) == false) {
			$('#dialog').html("이메일 형식이 틀립니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "이메일 확인"});
			return false;
		}
		$('#dialog-modal').dialog({ autoOpen: true });
		$('#form1').attr('method', 'post');
		$('#form1').attr('action', '/join/sns.proc');	
		$('#form1').attr('target', '');	
		$('#form1').submit();
	},
	valID: function() {
		var userid = $('#userid').val();
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
	valRecomID: function() {
		var recomid = $('#recomid').val();
		if($('#recomid').val() == "") {
			$('#dialog').html("추천아이디를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "추천아이디 확인"});
			return false;
		}
		//추천인 아이디 특수문자 블록킹 해제 2011.10.25. 박상선
		//if(validation.isEngNum(recomid) == false) {
		//	$('#dialog').html("추천아이디는 영문/숫자로 되어야 합니다.");
		//	$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "추천아이디 확인"});
		//	return false;
		//}
		if(validation.isSpace(recomid) == true) {
			$('#dialog').html("추천아이디는 공백이 없어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "추천아이디 확인"});
			return false;
		}
		if(validation.isLength(recomid, 4, 12) == false) {
			$('#dialog').html("추천아이디는 4~12자리로 되어 있어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "추천아이디 확인"});
			return false;
		}
		return true;
	},
	valUsername: function() {		
		var username = $('#username').val();
		if(username == "") {
			$('#dialog').html("이름을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "이름 확인"});
			return false;
		}
		if(validation.isEngKor(username) == false) {
			$('#dialog').html("이름은 한글/영어로 되어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "이름 확인"});
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
	checkID: function() {
		if(this.valID() == true) {
			var url = "/join/check.id.proc";
			var data = "&userid=" + $('#userid').val();
			$.ajax({ type: "POST", url: url, data: data, success: this.checkIDRequest });
			$('#dialog-modal').dialog({ autoOpen: true });
			
		}
	},	
	checkIDRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			join._tmpID = result.userid;
			$('#dialog').html(result.userid + "는 사용할 수 있는 아이디입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 중복 체크"});	
		} else {
			join._tmpID = "";
			$('#dialog').html(result.userid + "는 이미 사용중인 아이디 입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 중복 체크"});
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
			join._tmpNick = result.nickname;
			$('#dialog').html(result.nickname + "는 사용할 수 있는 닉네임입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 중복 체크"});	
		} else {
			join._tmpNick = "";
			$('#dialog').html(result.nickname + "는 이미 사용중인 닉네임 입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "닉네임 중복 체크"});
		}
	},
	checkRecomID: function() {
		if(this.valRecomID() == true) {
			var url = "/join/check.recomid.proc";
			var data = "&recomid=" + $('#recomid').val();
			$.ajax({ type: "POST", url: url, data: data, success: this.checkRecomIDRequest });
			$('#dialog-modal').dialog({ autoOpen: true });
		}
	},
	checkRecomIDRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			join._tmpRecomID = result.recomid;
			$('#dialog').html(result.recomid + "는 추천할 수 있는 아이디입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "추천아이디 체크"});	
		} else {
			join._tmpRecomID = "";
			$('#dialog').html(result.recomid + "는 존재하지 않는 아이디입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "추천아이디 체크"});
		}
	},
	previewUserImage: function(filename) {
		$('#dialog-modal').dialog("close");
		$('#tmpimage').val(filename);
		$('#profile_image').attr('width', '93');
		$('#profile_image').attr('height', '95');
		$('#profile_image').attr('src', DOMAIN_FILE+'/tmp/' + filename);
	},
	initUserImage: function() {
		$('#dialog-modal').dialog("close");
		$('#tmpimage').val("");
		$('#profile_image').attr('width', '93');
		$('#profile_image').attr('height', '95');
		$('#profile_image').attr('src', IMAGES+'/common/profile_blank.gif');
		$('#dialog').html("프로필 이미지업로드가 실패하였습니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "프로필 이미지 확인"});
	}
};
-->