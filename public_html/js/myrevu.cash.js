<!--
$(document).ready( function() {	
	$('#withdrawBtn').bind('click', function() { common.redirect("/myrevu/cash.withdraw"); });
	$('#withdrawBtn2').bind('click', function() { alert("30,000캐시 이상의 경우에만 출금 가능합니다.") });
	$('#saveBtn').bind('click', function() { mycash.withdraw(); });
	$('#cancelBtn').bind('click', function() { common.redirect("/myrevu/cash"); });
	$('#file1').bind('change', function () {
		if($(this).val() != "") {
			if(validation.isImageFile($(this).val()) == false) {
				$(this).val(""); 
				$('#dialog').html("이미지 파일(gif,jpg,png)만 가능합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "신분증사본 이미지 확인"});
			} else {
				$('input:radio[name=attach_type1]').filter('[value=1]').attr('checked', true);
				$('#dialog-modal').dialog({ autoOpen: true });
				$('#withdrawForm').attr('target', 'frmFile');
				$('#withdrawForm').attr('method', 'post');
				$('#withdrawForm').attr('action', '/myrevu/cash.image1.upload.proc');					
				$('#withdrawForm').submit();
			}
		}
	});
	$('#file2').bind('change', function () {
		if($(this).val() != "") {
			if(validation.isImageFile($(this).val()) == false) {
				$(this).val(""); 
				$('#dialog').html("이미지 파일(gif,jpg,png)만 가능합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "계좌사본 이미지 확인"});
			} else {
				$('input:radio[name=attach_type2]').filter('[value=1]').attr('checked', true);
				$('#dialog-modal').dialog({ autoOpen: true });
				$('#withdrawForm').attr('target', 'frmFile');
				$('#withdrawForm').attr('method', 'post');
				$('#withdrawForm').attr('action', '/myrevu/cash.image2.upload.proc');					
				$('#withdrawForm').submit();
			}
		}
	});
});

var mycash = {	
	withdraw: function() {
		if($("#name").val() == "") {
			$('#dialog').html("신청자 이름을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "신청자 이름 확인"});
			return false;
		}
		if(this.valSocialno() == false) {
			return false;
		}
		if($("#account_holder").val() == "") {
			$('#dialog').html("예금주  이름을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "예금주 이름 확인"});
			return false;
		}
		if($("#bankcode").val() == "") {
			$('#dialog').html("은행을 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "은행 선택 확인"});
			return false;
		}
		if($("#account_number").val() == "") {
			$('#dialog').html("계좌번호를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "계좌번호 확인"});
			return false;
		}
		if(validation.isNumber($("#account_number").val()) == false) {
			$('#dialog').html("계좌번호는 숫자로만 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "계좌번호 확인"});
			return false;
		}
		$('#dialog').html("한번 출금 신청을 하신 경우에 취소를 할 수 없습니다. 출금 신청을 하시겠습니까?");
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "출금신청 확인",		
			buttons: { 
				"출금신청": function() { mycash.proc(); },
				"취소": function() { $(this).dialog("close");} 
			}
		});
	}, 	
	valSocialno: function() {
		var socialno1 = $('#socialno1').val();
		var socialno2 = $('#socialno2').val();
		if(socialno1 == "" || socialno2 == "") {
			$('#dialog').html("주민등록번호를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "주민번호 확인"});
		}
		if(validation.isNumber(socialno1) == false || validation.isNumber(socialno2) == false) {
			$('#dialog').html("주민등록번호는 숫자로 입력하셔야합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "주민번호 확인"});				
			return false;
		}
		if(validation.isJumin(socialno1, socialno2) == false) {
			$('#dialog').html("주민번호가 옳바르지 않습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "주민번호확인"});
			return false;
		}
	},	
	previewImage: function(num, filemime, filename, filesize) {
		$('#dialog-modal').dialog("close");
		$('#thumbmime'+num).val(filemime);
		$('#thumbname'+num).val(filename);
		$('#thumbsize'+num).val(filesize);
		$('#thumb_image'+num).attr('width', '80');
		$('#thumb_image'+num).attr('height', '80');
		$('#thumb_image'+num).attr('src', DOMAIN_FILE+'/tmp/' + filename);
	},	
	initImage: function(num) {
		$('#dialog-modal').dialog("close");
		$('#thumbmime'+num).val("");
		$('#thumbname'+num).val("");
		$('#thumbsize'+num).val("");
		$('#thumb_image'+num).attr('width', '93');
		$('#thumb_image'+num).attr('height', '95');
		$('#thumb_image'+num).attr('src', IMAGES+'/common/thum/thum_profile_dummy4.gif');
	},	
	checkImage: function(num) {
		$('#dialog-modal').dialog("close");		
		mycash.initImage(num);
		$('#dialog').html("썸네일 이미지업로드가 실패하였습니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "썸네일 이미지 확인"});
	},	
	proc: function() {
		$('#dialog-modal').dialog({ autoOpen: true });
		$('#withdrawForm').attr('target', '');
		$('#withdrawForm').attr('method', 'post');
		$('#withdrawForm').attr('action', '/myrevu/cash.withdraw.proc');
		$('#withdrawForm').submit();
	}
};
-->