<!--
$(document).ready( function() {
	$('#searchWithdrawBtn').bind('click', function() { mngcash.searchWithdraw(); });
	$('#searchCashLogBtn').bind('click', function() { mngcash.searchCashLog(); });	
	$('#searchCashSumBtn').bind('click', function() { mngcash.searchCashSum(); });
	$('#downWidthdrawBtn').bind('click', function() { mngcash.downloadWithdraw(); });	
	
	try { $('#sdate').datepick({dateFormat: 'yyyymmdd'}); $('#edate').datepick({dateFormat: 'yyyymmdd'}); } catch(err) {}
});

var mngcash = {	
	searchWithdraw: function() {
		var sdate = $('#sdate').val();
		var edate = $('#edate').val();
		if(Number(sdate) > Number(edate)) {
			$('#dialog').html("검색기간이 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색일 확인"});
			return false;
		}
		if(sdate != "" && edate == "") {
			$('#dialog').html("검색일을 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색일 확인"});
			return false;
		}
		common.redirect("/manager/cash.withdraw/1/"+sdate+"/"+edate);
	}, 
	confirmWithdraw: function(wno) {
		if(wno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "현금지급 처리"});
			return false;
		}
		html = "";
		html += "지급 또는 반려를 선택한 후 처리하세요.<br />";
		html += "현금지급 : ";
		html += "<select id='flag_pay'>";
		html += "<option value=''>처리여부선택</option>";
		html += "<option value='1'>지급</option>";
		html += "<option value='2'>반려</option>";
		html += "</select>";
		$('#dialog').html(html);
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "현금지급",		
			buttons: { "처리": function(e) { mngcash.procWithdraw(wno); }, "닫기": function() { $(this).dialog("close");} }
		});
	},
	procWithdraw: function(wno) {
		var flag_pay = $('#flag_pay').val();
		if(flag_pay == "") {
			$('#dialog2').html("처리여부를 선택하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "현금지급 처리"});
			return false;
		}
		var url = "/manager/cash.withdraw.proc";
		var data = "&wno=" + wno + "&flag_pay=" + flag_pay;
		$.ajax({ type: "POST", url: url, data: data, success: this.procWithdrawRequest });
	},
	procWithdrawRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#dialog').html("처리되었습니다.");
			common.reload();
		} else {
			$('#dialog').html("처리가 실패하였습니다.");			
		}
	},
	searchCashLog: function() {
		var flag = radio.getValue('flag');
		var opt = $('#opt').val(); 
		var keyword = $('#keyword').val();
		if(opt != "" && keyword == "") {
			$('#dialog').html("검색어를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색어 확인"});
			return false;
		}
		common.redirect("/manager/cash.stats/1/"+flag+"/"+opt+"/"+keyword);
	},
	searchCashSum: function() {
		var sdate = $('#sdate').val();
		var edate = $('#edate').val();
		if(Number(sdate) > Number(edate)) {
			$('#dialog').html("검색기간이 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색일 확인"});
			return false;
		}
		if(sdate != "" && edate == "") {
			$('#dialog').html("검색일을 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색일 확인"});
			return false;
		}
		common.redirect("/manager/cash.list/1/"+sdate+"/"+edate);
	},
	downloadWithdraw: function() {
		var sdate = $('#sdate').val();
		var edate = $('#edate').val();
		if(Number(sdate) > Number(edate)) {
			$('#dialog').html("검색기간이 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색일 확인"});
			return false;
		}
		if(sdate != "" && edate == "") {
			$('#dialog').html("검색일을 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색일 확인"});
			return false;
		}
		common.redirect("/manager/cash.withdraw.down/1/"+sdate+"/"+edate);
	}
};
-->