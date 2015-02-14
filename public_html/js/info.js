$(document).ready( function(e) {
	$('#powerblogBtn').bind('click', function() { info.powerblog(); });
});
$(window).resize(function() {
	var _left = ($(window).width()/2)-($('#helplayer').width()/2);
	$('#helplayer').css({ "left": _left });
});
var info = {	
	_height: 0,
	_viewFlag : false, 
	load: function(type) {
		width = 787;
		height = 980;
		$('html, body').animate({scrollTop:0}, 'slow');
		var html = "";
		html += "<iframe id='helplayer-iframe' width='"+width+"' height='"+height+"' src='/info/frame/"+type+"' frameborder='0'></iframe>";		
		$('#helplayer').html(html);
		$(document).height(height+300);
		var left = ($(window).width()/2)-($('#helplayer').width()/2);
		$('#helplayer').css({ "left": left }).show();
		$('#helplayer').show();			
		$('#bglayer').css('width', $(document).width());
        $('#bglayer').css('height', $(document).height());
        $('#bglayer').show();
	},	
	close: function(type) {
		//if(type != "") window.location.href = "#"+type;
		$('#helplayer').hide("fast");
		$('#bglayer').hide();
	},
	powerblog: function() {
		//var cnt = $("input[name='cate[]']:checked").length;
		var cnt = checkbox.cnt('cate[]');
		if(cnt < 1) {
			common.dialog("지원분야 확인", "지원분야는 1개 이상 선택하세요.");
			return false;
		}
		if(cnt > 5) {
			common.dialog("지원분야 확인", "지원분야 선택은 최대 5개 입니다.");
			return false;
		}
		$('#dialog-modal').dialog({ autoOpen: true });
		$('#form1').attr('target', '');
		$('#form1').attr('method', 'post');
		$('#form1').attr('action', '/info/powerblog.application.proc');					
		$('#form1').submit();
	}
};