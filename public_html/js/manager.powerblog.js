<!--
$(document).ready( function() {
	$('#searchBtn').bind('click', function() { mngpowerblog.search(); });	
});

var mngpowerblog = {
	search: function() {
		var flag = radio.getValue('flag');		
		var cate = $('#cate').val();
		common.redirect("/manager/user.powerblog/1/"+flag+"/"+cate);
	}, 	
	proc: function(ano, flag, nickname) {
		switch(flag) {
			case "1" : 					
				$('#dialog2').html("<strong>"+nickname+"</strong>님을 파워블로거로 선정하시겠습니까?");
				$('#dialog2').dialog({ 
					autoOpen: true, width: "300", height:"150", title: "파워블로그 선정",		
					buttons: { 
						"파워블로그 선정" : function(e) { 
							$(this).dialog("close");
							var url = "/manager/user.powerblog.proc";
							var data = "&ano=" + ano + "&flag=" + flag;
							$.ajax({ type: "POST", url: url, data: data, success: mngpowerblog.procRequest });
							$('#dialog-modal').dialog({ autoOpen: true });
						},
						"닫기": function() { $(this).dialog("close");} 
					}
				});
				break;
			case "2" :
				$('#dialog2').html("<strong>"+nickname+"</strong>님의 파워블로거 선정을 거절하시겠습니까?");
				$('#dialog2').dialog({ 
					autoOpen: true, width: "300", height:"150", title: "파워블로그 선정",		
					buttons: { 
						"거절" : function(e) { 
							$(this).dialog("close");
							var url = "/manager/user.powerblog.proc";
							var data = "&ano=" + ano + "&flag=" + flag;
							$.ajax({ type: "POST", url: url, data: data, success: mngpowerblog.procRequest });
							$('#dialog-modal').dialog({ autoOpen: true });
						},
						"닫기": function() { $(this).dialog("close");} 
					}
				});
				break;
			default : 
				msg = "값이 잘못되었습니다.";
				break;
		}
	},	
	procRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var msg = "";
		if(result.result == "success") {
			common.reload();
		} else {
			msg = "처리가 실패하였습니다.";
		}
		$('#dialog').html(msg);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "파워블로그 선정" });
	}
	
};
-->