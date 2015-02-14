<!--
$(document).ready( function() {
	$('#searchCashLogBtn').bind('click', function() { mnglog.searchCashLog(); });
	$('#searchPointLogBtn').bind('click', function() { mnglog.searchPointLog(); });
	$('#searchTransactionLogBtn').bind('click', function() { mnglog.searchTransactionLog(); });
	$('#searchCronLogBtn').bind('click', function() { mnglog.searchCronLog(); });
	$('#searchCountLogBtn').bind('click', function() { mnglog.searchCountLog(); });
	try { $('#sdate').datepick({dateFormat: 'yyyymmdd'}); $('#edate').datepick({dateFormat: 'yyyymmdd'}); } catch(err) {}
});

var mnglog = {	
	searchCashLog: function() {
		var flag = radio.getValue('flag');
		var opt = $('#opt').val(); 
		var keyword = $('#keyword').val();
		if(opt != "" && keyword == "") {
			$('#dialog').html("검색어를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색어 확인"});
			return false;
		}
		common.redirect("/manager/log.cash/1/"+flag+"/"+opt+"/"+keyword);
	},	
	searchPointLog: function() {
		var flag = radio.getValue('flag');
		var opt = $('#opt').val(); 
		var keyword = $('#keyword').val();
		if(opt != "" && keyword == "") {
			$('#dialog').html("검색어를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색어 확인"});
			return false;
		}
		common.redirect("/manager/log.point/1/"+flag+"/"+opt+"/"+keyword);
	},	
	searchTransactionLog: function() {
		var flag = radio.getValue('flag');
		var opt = $('#opt').val(); 
		var keyword = $('#keyword').val();
		if(opt != "" && keyword == "") {
			$('#dialog').html("검색어를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색어 확인"});
			return false;
		}
		common.redirect("/manager/log.transaction/1/"+flag+"/"+opt+"/"+keyword);
	},	
	searchCronLog: function() {
		var flag = radio.getValue('flag');
		var opt = $('#opt').val(); 
		var keyword = $('#keyword').val();
		if(opt != "" && keyword == "") {
			$('#dialog').html("검색어를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "검색어 확인"});
			return false;
		}
		common.redirect("/manager/log.cron/1/"+flag+"/"+opt+"/"+keyword);
	},
	searchCountLog: function() {
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
		common.redirect("/manager/log.count/1/"+sdate+"/"+edate);
	}	
};
-->