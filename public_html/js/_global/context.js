$(document).ready( function(e) {
	$('#context-user').bind({
		mouseenter: function() { $(this).mouseleave(function() {$(this).hide();} ); },
		mouseout: function() {}
	});	
});

var context = {
	_userno: "",
	_nickname: "",
	_grouplist: "",		
	init: function() {
		this._userno = "";
		this._nickname = "";
		this._grouplist = "";
	},
	load: function(userno) {
		this.init();
		if(userno == "") {
			$('#dialog').html("회원정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "회원추가"});
			return false;
		} else {
			var _top = _pageY - 20; 
			var _left = _pageX - 20;
			$('#context-user').html("<center style='margin-top:45px;'>로딩중</center>");
			$('#context-user').css({ "top": _top, "left": _left, "position": "absolute"}).show();
		}
		var url = "/common/context.user";
		var data = "&userno=" + userno;
		$.ajax({ type: "POST", url: url, data: data, success: this.loadRequest });
	},	
	loadRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			var html = "";
			html += "<div class='box'>";
			html += "	<div class='thumbox'>";
			html += "		<div class='thum'><img src='"+result.userimage+"' width='80' height='80' /></div>";
			html += "		<div class='text gray_db_text'>"+result.nickname+"</div>";
			html += "		<div class='line'>";
			html += "			<img src='"+IMAGES+"/myrevu/but_tx_review.gif' class='btn' onClick='context.home(\""+result.nickname+"\")'>";
			html += "		</div>";
			html += "		<div class='line'><img src='"+IMAGES+"/myrevu/but_tx_blog.gif' onClick='context.blog(\""+result.nickname+"\")' class='btn'></div>";
			html += "		<div class='line'>";
			if(result.flag_friend == "1") html += context.getBtn(result.type); context._userno = result.userno; context._nickname = result.nickname; context._grouplist = result.grouplist; 
			html += "		</div>";
			html += "	</div>";
			html += "</div>";
			html += "<br />";
			//html += "<div id='context-bloglist'>";
			//for(var i=0; i<result.blogcnt; i++) {
			//	html += "<a href='"+result.bloglist[i]['url']+"' target='_blank'>"+result.bloglist[i]['name']+"</a><br />";
			//}
			html += "</div>";
			$('#context-user').html(html);
			$('#context-user').show("fast");
		} else {
			$('#context-user').hide("fast");
			$('#dialog').html("회원정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "회원정보" });
		}
	},	
	getBtn: function(type) {
		var btn;
		switch(type) {
			//case "MY" : case "ME" : case "EO" : btn = "<img src='"+IMAGES+"/common/but/but_del_friend.gif' class='btn' onClick='context.confirmFriend(\""+type+"\", "+userno+", "+groupno+", \""+nickname+"\");' />"; break;
			//default : btn = "<img src='"+IMAGES+"/common/but/but_make_friend.gif' class='btn' onClick='context.confirmFriend(\""+type+"\", "+userno+", "+groupno+", \""+nickname+"\");' />"; break;
			case "MY" : case "EO" : btn = "<img src='"+IMAGES+"/myrevu/but_tx_friend_out.gif' class='btn' onClick='context.confirmFriend(\""+type+"\");' />"; break;
			case "ME" : default : btn = "<img src='"+IMAGES+"/myrevu/but_tx_friend.gif' class='btn' onClick='context.confirmFriend(\""+type+"\");' />"; break;			
		}
		return btn;
	},
	confirmFriend: function(type) {
		var html = "";
		switch(type) {			
			case "MY" :
			case "EO" : 
				$('#dialog').html("<u><strong>"+context._nickname+"</strong></u> 님과 친구사이를 끊으시겠습니까?<br /><br />");
				$('#dialog').dialog({ 
					autoOpen: true, width: "300", height:"150", title: "친구삭제",		
					buttons: { "친구삭제": function(e) { context.deleteFriend(); }, "닫기": function() { $(this).dialog("close");} }
				});
				break;
			case "ME" : 
			default :
				html += "<u><strong>"+context._nickname+"</strong></u> 님과 새로운 친구로 맺으시겠습니까?<br /><br />";
				html += "친구분류 : ";
				html += "<select id='grouplist' style='width:140px'>";
				html += "<option value=''>전체</option>";
				for(var i=0; i<context._grouplist.length; i++) {
					html += "<option value='"+context._grouplist[i].groupno+"'>"+context._grouplist[i].gdesc+"</option>";
				}
				html += "</select>";
				$('#dialog').html(html);
				$('#dialog').dialog({ 
					autoOpen: true, width: "300", height:"150", title: "친구추가",		
					buttons: { "친구추가": function(e) { context.addFriend($('#grouplist').val()); }, "닫기": function() { $(this).dialog("close");} }
				});
				break;
		}
	},
	addFriend: function(groupno) {
		if(this._userno == "") {
			$('#dialog').html("회원정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "친구추가"});
			return false;
		}
		var url = "/common/context.friend.add.proc";
		var data = "&userno=" + this._userno + "&groupno=" + groupno;
		$.ajax({ type: "POST", url: url, data: data, success: this.addFriendRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},
	addFriendRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#dialog').html("친구추가 되었습니다.");
		} else if(result.result == "self") {
			$('#dialog').html("자기 자신은 추가 할 수 없습니다.");			
		} else if(result.result == "login") {
			$('#dialog').html("로그인을 하셔야 친구를 추가 할 수 있습니다.");			
		} else {
			$('#dialog').html("이미 등록된 회원이거나 회원추가가 실패하였습니다.");			
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"160", title: "친구추가",
			buttons: { "닫기": function() { $(this).dialog("close");} }  
		});
	},
	deleteFriend: function() {
		if(context._userno == "") {
			$('#dialog').html("회원정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "친구삭제"});
			return false;
		}
		var url = "/common/context.friend.delete.proc";
		var data = "&userno=" + context._userno;
		$.ajax({ type: "POST", url: url, data: data, success: this.deleteFriendRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},
	deleteFriendRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#dialog').html("더 이상 친구 사이가 아닙니다.");
		} else if(result.result == "self") {
			$('#dialog').html("자기 자신은 삭제 할 수 없습니다.");			
		} else if(result.result == "login") {
			$('#dialog').html("로그인을 하셔야 친구를 삭제 할 수 있습니다.");			
		} else {
			$('#dialog').html("친구삭제가 실패하였습니다.");			
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"160", title: "친구삭제", 
			buttons: { "닫기": function() { $(this).dialog("close");} } 
		});
	},
	home: function(nickname) {
		if((nickname == null) || (nickname == undefined)) {
			$('#dialog').html("블로그 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "블로그홈" });
		} else {
			common.redirect('/blog/@'+nickname);
		}
	}, 
	blog: function(nickname) {
		if((nickname == null) || (nickname == undefined)) {
			$('#dialog').html("블로그 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "블로그홈" });
		} else {
			common.redirect('/blog/info/'+nickname);
		}
	}
};