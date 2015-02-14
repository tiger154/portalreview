<!--
$(document).ready( function() {	
	$('#saveBtn').bind('click', function() { myinfo.save(); });
	$('#saveSNSBtn').bind('click', function() { myinfo.saveSNS(); });
});

var mytalk = {	
	deleteTalk: function(tno) {
		if(tno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "토크삭제" });
			return false;
		} 
		$('#dialog2').html("토크를 삭제 하시겠습니까?");
		$('#dialog2').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "토크삭제",		
			buttons: { 
				"토크삭제": function() { 
					$(this).dialog("close");
					var url = "/common/socialbar.talk.delete.proc";	
					var data = "&tno=" + tno;
					$.ajax({ type: "POST", url: url, data: data, success: mytalk.deleteTalkRequest });
					$('#dialog-modal').dialog({ autoOpen: true });
				},
				"닫기": function() { $(this).dialog("close");} 
			}
		});
	}, 	
	deleteTalkRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {			
			common.reload();
		} else if(result.result == "priv") {
			$('#dialog').html("토크를 삭제할 권한이 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "토크삭제" });
			return false;
		} else {
			$('#dialog').html("토크삭제가 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "토크삭제" });
			return false;
		}
	}
};