<!--
$(document).ready( function() {	
	$('#gdescRegBtn').bind('click', function() { myfriend.registGroup(); });
	$('#searchBtn').bind('click', function() { myfriend.searchUser(); });
	$('#friendRegBtn').bind('click', function() { myfriend.searchUser(); });
});

var myfriend = { 	
	_type: '',
	_groupno: '', 	
	initVar: function(type, groupno) {
		this._type = type;
		this._groupno = groupno;
	},	
	goList: function() {		
		common.redirect('/myrevu/friend/1/15/10/'+this._type+'/'+this._groupno);
	},	
	registGroup: function() {
		var gdesc = $('#gdesc').val();
		if(gdesc == "") {
			$('#dialog').html("분류명을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "분류명 체크"});
			return false;
		}
		var url = "/myrevu/friend.group.reg.proc";
		var data = "&gdesc=" + gdesc;
		$.ajax({ type: "POST", url: url, data: data, success: this.registGroupRequest });
		$('#dialog-modal').dialog({ autoOpen: true });		
	},	
	registGroupRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			var groupno = result.groupno;
			common.redirect("/myrevu/friend");
		} else if(result.result == "repeat") {
			$('#dialog').html("이미 등록된 분류명입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "분류등록" });
		} else {
			$('#dialog').html("분류추가가 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "분류등록" });
		}
	},	
	confirmDeleteGroup: function(groupno) {
		$('#dialog2').html("삭제 하시겠습니까?");
		$('#dialog2').dialog({ 
			autoOpen: true, width: "300", height:"160", title: "분류삭제",		
			buttons: { 
				"삭제": function() { myfriend.deleteGroup(groupno); },
				"닫기": function() { $(this).dialog("close");} 
			}
		});
	},	
	deleteGroup: function(groupno) {
		var url = "/myrevu/friend.group.delete.proc";
		var data = "&groupno=" + groupno;
		$.ajax({ type: "POST", url: url, data: data, success: this.deleteGroupRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},	
	deleteGroupRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			common.redirect("/myrevu/friend");
		} else {
			$('#dialog').html("분류삭제가 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "분류삭제" });
		}
	},	
	searchUser: function() {
		var type = $('#searchType').val();
		var keyword = $('#searchKeyword').val();
		if(keyword == "") {
			$('#dialog').html("검색할 내용을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "회원검색"});
			return false;
		}
		if(keyword.length < 2) {
			$('#dialog').html("검색어는 2자 이상이어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "회원검색"});
			return false;
		}
		var url = "/myrevu/friend.user.search.proc";
		var data = "&type=" + type + "&keyword=" + keyword;
		$.ajax({ type: "POST", url: url, data: data, success: this.searchUserRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},	
	searchUserRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var list = result.list;
		var html = "";
		if(result.result == "success") {
			html += "<span class='gray_stitle'>"+result.keyword+"</span>에 대한 검색 "+result.size+"개가 있습니다.<br /><br /><br />";
			for(var i=0; i<list.length; i++) {
				html += "<div class='myfriend_search_box'>";
				html += "	<ul>"
				html += "		<li class='myfriend_thum'><img src='"+list[i].userimage+"' width='80' height='80' /></li>";
				html += "		<li class='myfriend_text'>";
				html += "			<a href='javascript:context.load("+list[i].userno+")'>"+list[i].nickname+"</a>";
				html += "		</li>";
				html += "	</ul>";
				html += "</div>";
				if((i+1)%5 == 0) {
				html += "<div class='my_grayline2'></div>";
				} else {
				html += "<div class='myfriend_space'></div>";
				}
			}
		} else {
			html += "<span class='gray_stitle'>"+result.keyword+"</span>에 대한 검색 결과가 없습니다.";
		}
		$('#resultUser').show();
		$('#resultUser').html(html);
	},	
	addUser: function(userno) {
		if(userno == "") {
			$('#dialog').html("회원정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "친구추가"});
			return false;
		}
		var url = "/myrevu/friend.user.add.proc";
		var data = "&userno=" + userno + "&groupno=" + this._groupno;
		$.ajax({ type: "POST", url: url, data: data, success: this.addUserRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},	
	addUserRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#resultUser').html();
		} else {
			$('#dialog').html("이미 등록된 회원이거나 회원추가가 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "친구추가" });
		}
	}
	
};
-->