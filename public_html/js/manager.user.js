<!--
$(document).ready( function() {
	$('#searchBtn').bind('click', function() { mnguser.search(); });
	$('#searcSecedehBtn').bind('click', function() { mnguser.searchSecede(); });
});

var mnguser = {
	search: function() {
		var flag = radio.getValue('flag');
		var opt = $('#opt').val(); 
		var keyword = $('#keyword').val();
		if(opt != "" && keyword == "") {
			$('#dialog').html("검색어를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색어 확인"});
			return false;
		}
		common.redirect("/manager/user/1/"+flag+"/"+opt+"/"+keyword);
	},
	searchSecede: function() {
		var flag = radio.getValue('flag');
		var opt = $('#opt').val(); 
		var keyword = $('#keyword').val();
		if(opt != "" && keyword == "") {
			$('#dialog').html("검색어를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색어 확인"});
			return false;
		}
		common.redirect("/manager/user.secede/1/"+flag+"/"+opt+"/"+keyword);
	},
	confirmSendMail: function(email) {
		html = "";
		html += "발송할 정보를 입력하신 후 발송버튼을 누르세요.<br />";
		html += "<table>";
		html += "	<tr>";
		html += "		<th>제 목</th>";
		html += "		<td><input type='text' name='subject' id='subject' size='100' /></td>";
		html += "	</tr>";
		html += "	<tr>";
		html += "		<th>발신자</th>";
		html += "		<td><input type='text' name='sender' id='sender' size='100' value='레뷰' /></td>";
		html += "	</tr>";
		html += "	<tr>";
		html += "		<th>수신자</th>";
		html += "		<td><input type='text' name='email' id='email' size='100' value='"+email+"'/></td>";
		html += "	</tr>";
		html += "	<tr>";
		html += "		<th>내 용</th>";
		html += "		<td><textarea name='content' id='content' cols='100' rows='5'></textarea></td>";
		html += "	</tr>";
		html += "</table>";
		$('#dialog').html(html);
		$('#dialog').dialog({ 
			autoOpen: true, width: "650", height:"350", title: "개별메일발송",		
			buttons: { "발송": function(e) { mnguser.sendMail(); }, "닫기": function() { $(this).dialog("close");} }
		});
	},	
	sendMail: function() {
		var subject = $("#subject").val();
		var sender = $("#sender").val();
		var email = $("#email").val();
		var content = $("#content").val();
		if(subject == "") {
			$('#dialog2').html("제목을 입력하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "메일발송 정보 확인"});
			return false;
		}
		if(sender == "") {
			$('#dialog2').html("발신자를 입력하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "메일발송 정보 확인"});
			return false;
		}
		if(content == "") {
			$('#dialog2').html("내용을 입력하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "메일발송 정보 확인"});
			return false;
		}
		var url = "/manager/user.email.send.proc";
		var data = "&subject=" + subject + "&sender=" + sender + "&email=" + email + "&content=" + content;
		$.ajax({ type: "POST", url: url, data: data, success: this.sendMailRequest });
	},
	sendMailRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#dialog').html("메일이 발송 되었습니다.");
		} else {
			$('#dialog').html("처리가 실패하였습니다.");			
		}		
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "개별메일 발송 처리 결과",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});
	},
	confirmReceiveEmail: function(userno) {
		if(userno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "이메일 수신여부 변경"});
			return false;
		}
		html = "";
		html += "이메일 수신여부 : ";
		html += "<select id='flag_email'>";
		html += "<option value=''>==선택==</option>";		
		html += "<option value='0'>수신거부</option>";
		html += "<option value='1'>수신</option>";
		html += "</select>";
		$('#dialog').html(html);
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "이메일 수신여부 변경",		
			buttons: { "변경": function(e) { mnguser.receiveEmail(userno); }, "닫기": function() { $(this).dialog("close");} }
		});
	}, 
	receiveEmail: function(userno)
	{
		var flag_email = $("#flag_email").val();
		if(flag_email == "") {
			$('#dialog2').html("이메일 수신여부를  선택하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "이메일 수신여부 변경"});
			return false;
		}
		var url = "/manager/user.flag.email.proc";
		var data = "&userno=" + userno + "&flag_email=" + flag_email;
		$.ajax({ type: "POST", url: url, data: data, success: this.receiveEmailRequest });
	},
	receiveEmailRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			if(result.flag_email == "0") {
				$('#dialog').html("메일 수신거부로 변경되었습니다.");
			} else if(result.flag_email == "1") {
				$('#dialog').html("메일수신으로 변경되었습니다.");
			} 
		} else {
			$('#dialog').html("처리가 실패하였습니다.");			
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "이메일 수신여부 변경",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});
	},
	confirmBlackList: function(userno) {
		if(userno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "블랙리스트 변경"});
			return false;
		}
		html = "";
		html += "블랙리스트 : ";
		html += "<select id='flag_black'>";
		html += "<option value=''>==선택==</option>";		
		html += "<option value='0'>일반회원</option>";
		html += "<option value='1'>블랙리스트회원</option>";
		html += "</select>";
		$('#dialog').html(html);
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "블랙리스트",		
			buttons: { "변경": function(e) { mnguser.blackList(userno); }, "닫기": function() { $(this).dialog("close");} }
		});
	}, 
	blackList: function(userno)
	{
		var flag_black = $("#flag_black").val();
		if(flag_black == "") {
			$('#dialog2').html("블랙리스트 여부를  선택하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "블랙리스트 변경"});
			return false;
		}
		var url = "/manager/user.flag.black.proc";
		var data = "&userno=" + userno + "&flag_black=" + flag_black;
		$.ajax({ type: "POST", url: url, data: data, success: this.blackListRequest });
	},
	blackListRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			if(result.flag_black == "0") {
				$('#dialog').html("일반회원으로 변경되었습니다.");
			} else if(result.flag_black == "1") {
				$('#dialog').html("블랙리스트로 변경되었습니다.");
			} 		
		} else {
			$('#dialog').html("처리가 실패하였습니다.");			
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "블랙리스트",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});
	},
	confirmSecede: function(userno) {
		if(userno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "탈퇴처리"});
			return false;
		}		
		html = "";
		html += "탈퇴사유와 기타사유 및 레뷰에게 바라는점을 선택/입력후 탈퇴를 클릭하세요."
		html += "<table width='100%'>";
		html += "	<tr>";
		html += "		<th width='150'>탈퇴사유</th>";
		html += "		<td>";
		html += "			<select id='secede_type'>";
		html += "				<option value=''>==선택==</option>";		
		html += "				<option value='4'>개인정보 유출 우려</option>";
		html += "				<option value='3'>다른 ID로 재가입</option>";
		html += "				<option value='2'>불량 이용자 존재</option>";
		html += "				<option value='1'>속도 및 서비스 불만족</option>";
		html += "				<option value='0'>기타</option>";
		html += "			</select>";		
		html += "		</td>";
		html += "	</tr>";
		html += "	<tr>";
		html += "		<th>기타사유 및<br />레뷰에게 바라는점</th>";
		html += "		<td><textarea name='content' id='content' cols='60' rows='5'></textarea></td>";
		html += "	</tr>";
		html += "</table>";
		$('#dialog').html(html);
		$('#dialog').dialog({ 
			autoOpen: true, width: "500", height:"250", title: "탈퇴처리",		
			buttons: { "탈퇴": function(e) { mnguser.secede(userno); }, "닫기": function() { $(this).dialog("close");} }
		});
	}, 
	secede: function(userno)
	{
		var secede_type = $("#secede_type").val();
		var content = $("#content").val();
		if(secede_type == "") {
			$('#dialog2').html("탈퇴사유를 선택하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "탈퇴처리"});
			return false;
		}
		if(content == "") {
			$('#dialog2').html("기타사유 및 레뷰에게 바라는점을 입력하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "탈퇴처리"});
			return false;
		}
		var url = "/manager/user.secede.proc";
		var data = "&userno=" + userno + "&secede_type=" + secede_type + "&content=" + content;
		$.ajax({ type: "POST", url: url, data: data, success: this.secedeRequest });
	},
	secedeRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#dialog').html("탈퇴처리되었습니다.");
		} else {
			$('#dialog').html("처리가 실패하였습니다.");			
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "탈퇴처리",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});
	},
	confirmCash: function(userno) {
		if(userno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "캐시 지급/차감"});
			return false;
		}		
		html = "";
		html += "<table width='100%'>";
		html += "	<tr>";
		html += "		<th width='100'>지급/차감</th>";
		html += "		<td>";
		html += "			<select id='flag_sign'>";
		html += "				<option value=''>==선택==</option>";		
		html += "				<option value='0'>지급</option>";
		html += "				<option value='1'>차감</option>";
		html += "			</select>";		
		html += "		</td>";
		html += "	</tr>";
		html += "	<tr>";
		html += "		<th>캐시타입</th>";
		html += "		<td>";
		html += "			<select id='cash_type'>";
		html += "				<option value=''>==선택==</option>";	
		html += "				<option value='100'>캐시출금(-)</option>";
		html += "				<option value='300'>레뷰리뷰(+)</option>";
		html += "				<option value='301'>블로그리뷰(+)</option>";
		html += "				<option value='305'>파워블로거 캠페인(+)</option>";
		html += "				<option value='302'>베스트리뷰(+)</option>";
		html += "				<option value='303'>베스트 추천회원(+)</option>";
		html += "				<option value='304'>리뷰추천(+)</option>";
		html += "				<option value='330'>50 추천 인센티브(+)</option>";
		html += "				<option value='331'>100 추천 인센티브(+)</option>";
		html += "				<option value='332'>150 추천 인센티브(+)</option>";
		html += "				<option value='333'>200 추천 인센티브(+)</option>";
		html += "				<option value='334'>250 추천 인센티브(+)</option>";
		html += "				<option value='335'>300 추천 인센티브(+)</option>";
		html += "				<option value='336'>350 추천 인센티브(+)</option>";		
		html += "				<option value='337'>400 추천 인센티브(+)</option>";
		html += "				<option value='338'>450 추천 인센티브(+)</option>";
		html += "				<option value='339'>500 추천 인센티브(+)</option>";
		html += "				<option value='350'>리뷰삭제(-)</option>";		
		html += "				<option value='800'>이벤트(+)</option>";
		html += "				<option value='900'>관리자(+/-)</option>";
		html += "			</select>";
		html += "		</td>";
		html += "	</tr>";
		html += "	<tr>";
		html += "		<th>캐시</th>";
		html += "		<td>";
		html += "			<input type='text' id='cash' />";
		html += "		</td>";
		html += "	</tr>";
		html += "	<tr>";
		html += "		<th>리뷰일련번호</th>";
		html += "		<td>";
		html += "			<input type='text' id='rno' />";
		html += "		</td>";
		html += "	</tr>";
		html += "</table>";
		$('#dialog').html(html);
		$('#dialog').dialog({ 
			autoOpen: true, width: "550", height:"300", title: "캐시 지급/차감",		
			buttons: { "캐시 지급/차감": function(e) { mnguser.cash(userno); }, "닫기": function() { $(this).dialog("close");} }
		});
	},	
	cash: function(userno)
	{
		var flag_sign = $("#flag_sign").val();
		var cash_type = $("#cash_type").val();
		var cash = $("#cash").val();
		var rno = $("#rno").val();
		if(flag_sign == "") {
			$('#dialog2').html("지급/차감을 선택하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "캐시 지급/차감"});
			return false;
		}
		if(cash_type == "") {
			$('#dialog2').html("캐시타입을 선택하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "캐시 지급/차감"});
			return false;
		}
		if(cash == "") {
			$('#dialog2').html("캐시를 입력하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "캐시 지급/차감"});
			return false;
		}
		var url = "/manager/user.cash.proc";
		var data = "&userno=" + userno + "&flag_sign=" + flag_sign + "&cash_type=" + cash_type + "&cash=" + cash + "&rno=" + rno;
		$.ajax({ type: "POST", url: url, data: data, success: this.cashRequest });
	},
	cashRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			if(result.flag_sign == "0") {
				$('#dialog').html("<strong>" + result.cash + "</strong> 캐시가 지급되었습니다.");
			} else if(result.flag_sign == "1") {
				$('#dialog').html("<strong>" + result.cash + "</strong> 캐시가 차감되었습니다.");
			}
		} else {
			$('#dialog').html("처리가 실패하였습니다.");			
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "캐시 지급/차감",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});
	},
	confirmPowerblog: function(userno) {
		if(userno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "파워블로거 변경"});
			return false;
		}
		html = "";
		html += "파워블로거 : ";
		html += "<select id='flag_power'>";
		html += "<option value=''>==선택==</option>";		
		html += "<option value='0'>일반회원</option>";
		html += "<option value='1'>파워블로거</option>";
		html += "</select>";
		$('#dialog').html(html);
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "파워블로거",		
			buttons: { "변경": function(e) { mnguser.powerblog(userno); }, "닫기": function() { $(this).dialog("close");} }
		});
	}, 
	powerblog: function(userno)
	{
		var flag_powerblog = $("#flag_power").val();
		if(flag_powerblog == "") {
			$('#dialog2').html("파워블로거 여부를  선택하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "파워블로거 변경"});
			return false;
		}
		var url = "/manager/user.flag.powerblog.proc";
		var data = "&userno=" + userno + "&flag_powerblog=" + flag_powerblog;
		$.ajax({ type: "POST", url: url, data: data, success: this.powerblogRequest });
	},
	powerblogRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			if(result.flag_powerblog == "0") {
				$('#dialog').html("일반회원으로 변경되었습니다.");
			} else if(result.flag_powerblog == "1") {
				$('#dialog').html("파워블로거로 변경되었습니다.");
			} 		
		} else {
			$('#dialog').html("처리가 실패하였습니다.");			
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "파워블로거",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});
	},
	confirmMemo: function(userno) {
		if(userno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "메모"});
			return false;
		}		
		html = "";
		html += "남기실 메모를 입력하세요."
		html += "<table width='100%'>";
		html += "	<tr>";
		html += "		<th width='100'>메모</th>";
		html += "		<td><textarea name='content' id='content' cols='60' rows='5'></textarea></td>";
		html += "	</tr>";
		html += "</table>";
		$('#dialog').html(html);
		$('#dialog').dialog({ 
			autoOpen: true, width: "550", height:"300", title: "메모",		
			buttons: { "메모": function(e) { mnguser.memo(userno); }, "닫기": function() { $(this).dialog("close");} }
		});
	},	
	memo: function(userno)
	{
		var content = $("#content").val();
		if(content == "") {
			$('#dialog2').html("메모를 입력하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "메모"});
			return false;
		}
		var url = "/manager/user.memo.proc";
		var data = "&userno=" + userno + "&content=" + content;
		$.ajax({ type: "POST", url: url, data: data, success: this.memoRequest });
	},
	memoRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#dialog').html("메모가 입력되었습니다.");
		} else {
			$('#dialog').html("처리가 실패하였습니다.");			
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "메모",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});
	},	
	registAdmin: function() {
		var userno = $("#userno").val();
		var grade = $("#grade").val();
		var admin_desc = $("#admin_desc").val();
		if(userno == "") {
			$('#dialog').html("회원번호를 입력하세요. 회원번호를 모르면 회원관리를 조회하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "관리자 계정등록"});
			return false;
		}
		if(grade == "") {
			$('#dialog').html("회원등급을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "관리자 계정등록"});
			return false;
		}
		if(admin_desc == "") {
			$('#dialog').html("관리자 계정의 설명을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "관리자 계정등록"});
			return false;
		}
		var url = "/manager/user.admin.regist.proc";
		var data = "&userno=" + userno + "&grade=" + grade + "&admin_desc=" + admin_desc;
		$.ajax({ type: "POST", url: url, data: data, success: this.registAdminRequest });
	},
	registAdminRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			common.redirect("/manager/user.admin");
		} else if(result.result == "exist") {
			$('#dialog').html("존재하지 않는 회원입니다.");			
		} else {
			$('#dialog').html("등록이 실패하였습니다.");			
		}		
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "관리자 계정등록",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});
	},
	confirmDeleteAdmin: function(userno) {
		if(userno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "관리자 계정삭제"});
			return false;
		}
		$('#dialog').html("관리자 계정을 삭제하시겠습니까?");
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "관리자 계정삭제",		
			buttons: { "삭제": function(e) { mnguser.deleteAdmin(userno); }, "닫기": function() { $(this).dialog("close");} }
		});
	}, 
	deleteAdmin: function(userno) {
		var url = "/manager/user.admin.delete.proc";
		var data = "&userno=" + userno;
		$.ajax({ type: "POST", url: url, data: data, success: this.deleteAdminRequest });
	},
	deleteAdminRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			//$('#dialog').html("삭제되었습니다.");
			common.redirect("/manager/user.admin");
		} else {
			$('#dialog').html("삭제가 실패하였습니다.");			
		}				
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "관리자 계정삭제",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});
	}
};
-->