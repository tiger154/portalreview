$(document).ready( function(e) {
	socialbar.resize();
	socialbar.setIcon();
	socialbar.setTalkLast();
	setTimeout(function(){ socialbar._viewFlag = true; }, 1000*5);	
	$('#recom_btn').bind({ 
		mouseover: function(){
			$(this).css("background", "url("+IMAGES+"/socialbar/socialbar_but_over.gif)");
			$(this).css("background-repeat", "no-repeat");
		}, 
		mouseout: function(){
			$(this).css("background", "url("+IMAGES+"/socialbar/socialbar_but_on.gif)");
			$(this).css("background-repeat", "no-repeat"); 
		} 
	});
});

$(window).resize(function() {
	socialbar.resize();
});

var socialbar = {	
	_typeArr : new Array("R", "T", "F"),
	_barHeight: 61,
	_viewFlag : false,
	_talkFlag : false,
	_reviewFlag : false, 
	_icon : "",
	_rno : "", 
	_tno : "",	
	resize: function() {
		try {
			var height = $(window).height() - socialbar._barHeight;
			var offset = $("#talk-location").offset();
			$('#socialbar-frame').css({ "height": height });
			$("#socialbar-talk").css("top", 61);
			$("#socialbar-talk").css("left", offset.left);
		} catch(e) {
			
		}
	},
	close: function(url) {
		if(url != "") window.location.href = url;
		else window.location.href = DOMAIN;
	}, 	
	logout: function() {
		var url = "/common/socialbar.logout.proc";
		var data = "";
		$.ajax({ type: "POST", url: url, data: data, success: this.logoutRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	}, 		
	logoutRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result != "success") {
			$('#dialog').html("로그아웃 처리가 실패하였습니다. 다시 시도하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "전체로그아웃" });
		} else {
			loginFlag['R'] = "";
			loginFlag['T'] = "";
			loginFlag['F'] = "";
			for(var i=0; i<socialbar._typeArr.length; i++) {
				var src = IMAGES + "/common/ico/ico_" + socialbar._typeArr[i] + "2.gif"; 
				$("#icon"+socialbar._typeArr[i]).attr("src", src);
			} 
		}
	},	
	load: function(rno) {
		if(rno == "") {
			$('#dialog').html("리뷰정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰보기"});
			return false;
		} else {
			common.redirectOpen(DOMAIN+"/"+rno, "windowSocialbar");
		}
	},	
	reload: function(rno) {
		if(rno == "") {
			$('#dialog').html("리뷰정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰보기"});
			return false;
		} else {
			common.redirect(DOMAIN+"/"+rno);
		}
	},	
	recomView: function(rno) {
		$('#dialog2').html("리뷰보기 페이지에서 추천가능합니다.<br />리뷰를 보시겠습니까?");
		$('#dialog2').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "리뷰추천",		
			buttons: { 
				"리뷰보기": function(e) { 
					$(this).dialog("close");
					common.redirectOpen(DOMAIN+"/"+rno);
				},
				"닫기": function() { $(this).dialog("close");} 
			}
		});
	},	
	recom: function(rno) {
		if(rno == "") {
			$('#dialog').html("리뷰정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰추천"});
			return false;
		}
		if(this._viewFlag == false) {
			$('#dialog').html("리뷰를 충분히 읽어보신고 추천해 주세요! *^^*");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰추천"});
			return false;
		}
		var url = "/common/socialbar.recom";
		var data = "&rno=" + rno;
		$.ajax({ type: "POST", url: url, data: data, success: this.recomRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	}, 
	recomRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var msg = "";
		if(result.result == "success") {
			msg = "리뷰가 추천되었습니다.";
			$('#recom_cnt').html(result.recom_cnt);
		} else if(result.result == "info") {
			msg = "정보가 잘못되었습니다.";
		} else if(result.result == "recomme") {
			msg = "자신의 리뷰에는 추천할 수 없습니다.";
		} else if(result.result == "oneuser") {
			msg = "하루에 한 회원에게만 추천할 수 있습니다.";
		} else if(result.result == "sameip") {
			msg = "이미 추천한 아이피입니다.";
		} else if(result.result == "repeat") {
			msg = "이미 추천한 리뷰입니다.";
		} else {
			msg = "리뷰추천이 실패하였습니다.";
		}
		$('#dialog').html(msg);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰보기" });
	},	
	candRecom: function(wno, rno) {
		if(wno == "" || rno == "") {
			$('#dialog').html("리뷰정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰추천"});
			return false;
		}
		if(this._viewFlag == false) {
			$('#dialog').html("리뷰를 충분히 읽어보신고 추천해 주세요! *^^*");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰추천"});
			return false;
		}
		var url = "/common/socialbar.cand.recom";
		var data = "&wno=" + wno + "&rno=" + rno;
		$.ajax({ type: "POST", url: url, data: data, success: this.candRecomRequest });
	},	
	candRecomRequest: function(data) {
		var result = $.parseJSON(data);
		var msg = "";
		if(result.result == "success") {
			msg = "리뷰가 추천되었습니다.";
			$('#recom_cnt').html(result.recom_cnt);
		} else if(result.result == "info") {
			msg = "정보가 잘못되었습니다.";
		} else if(result.result == "nouser") {
			msg = "로그인 후 추천할 수 있습니다.";
		} else if(result.result == "recomme") {
			msg = "자신의 리뷰에는 추천할 수 없습니다.";
		} else if(result.result == "nocand") {
			msg = "베스트후보 리뷰가 아닙니다.";
		} else if(result.result == "sameip") {
			msg = "이미 추천한 아이피입니다.";
		} else if(result.result == "repeat") {
			msg = "이미 추천한 리뷰입니다.";
		} else {
			msg = "리뷰추천이 실패하였습니다.";
		}
		$('#dialog').html(msg);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰보기" });
	},	
	popular: function(cate) {
		var url = "/common/socialbar.popular";
		var data = "&cate=" + cate;
		$.ajax({ type: "POST", url: url, data: data, success: this.popularRequest });
	}, 	
	popularRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {	
			var length = result.list.length;
			var html = "";
			html += "<input type='button' value='<' onClick='socialbar.popular(\""+result.prev+"\")' />";
			html += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+result.desc+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			html += "<input type='button' value='>' onClick='socialbar.popular(\""+result.next+"\")' />";
			html += "<input type='button' value='X' onClick='common.closePopupLayer(\"popuplayer\")';";
			html += "<br /><br />";
			html += "<ul>"		
			for(var i=0; i<length; i++) {
				html += "<li><a href='javascript:socialbar.load("+result.list[i].rno+");'>"+result.list[i].title+"</li>";
			}
			html += "</ul>";
			common.openPopupLayer(html, 10, 640);
		} else {
			$('#dialog').html("인기글 정보를 불러오는데 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "인기글" });
		}
	},	
	review: function(userno) {
		if(this._reviewFlag == true) {
			this.closeReview();
		} else {
			//var url = "/common/socialbar.review";
			var url = "/common/socialbar.review.new";
			var data = "&userno=" + userno;		
			$.ajax({ type: "POST", url: url, data: data, success: this.reviewRequest });
		}
	},	
	reviewRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {	
			var length = result.list.length;
			var html = "";
			html += "<div class='socialbar-review-layer'>"
			html += "	<div class='line1 pr17'>";
			html += "		<img src='/images/myrevu/but_g_xclose3.gif' alt='닫기' title='닫기' onClick='common.closePopupLayer(\"popuplayer\");' class='btn' />";
			html += "	</div>";
			html += "	<div class='line2'>";
			for(var i=0; i<length; i++) {
			html += "		<div class='dot_list370 common_org_text'>";
			html += "			<a href='javascript:socialbar.reload("+result.list[i].rno+");'>"+result.list[i].title+"</a>";
			html += "		</div>";
			}
			html += "	</div>";
			html += "</div>";
			//common.openPopupLayer("popuplayer", html, 460, 279, 120, -1);
			var socialbar = $("#review-position");
			var position = socialbar.position();
			common.openPopupLayer("popuplayer", html, 460, 279, position.top+61, position.left+100);
		} else {
			$('#dialog').html("최근 작성된 리뷰를 불러오는데 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "최근 작성된 리뷰보기" });
		}
	}, 	
	closeReview: function() {
		common.closePopupLayer("popuplayer");
	},
	turnIcon: function(type, todo) {
		var id = "icon"+type;
		var src = "";
		if(todo == "on") src = IMAGES + "/common/ico/ico_" + type + ".gif";
		else src = IMAGES + "/common/ico/ico_" + type + "2.gif";
		$("#"+id).attr("src", src);
	}, 	
	todoIcon: function(type) {
		var iconType = common.getCookie('cookieSocialIcon');
		if(loginFlag[type] != "1") {
			switch(type) {
				case "T" : twitter.todo('slogin'); break;
				case "F" : facebook.todo('slogin'); break;
				case "R" : common.openLayer('loginlayer'); break;
			}
		} else {			 
			common.setCookie('cookieSocialIcon',type,30);			
			for(var i=0; i<socialbar._typeArr.length; i++) {
				if(socialbar._typeArr[i] == type) {
					//$("#icon"+type).addClass("on"); 
					$("#check"+type).show();
					common.setCookie('cookieSocialIcon',type,30);
				} else {
					//$("#icon"+socialbar._typeArr[i]).removeClass("on");
					$("#check"+socialbar._typeArr[i]).hide();
				}
			}
		} 
	},	
	setIcon: function() {
		var iconType = common.getCookie('cookieSocialIcon');
		for(var i=0; i<socialbar._typeArr.length; i++) {
			if(socialbar._typeArr[i] == iconType) {
				if(loginFlag[iconType] == "1") socialbar.turnIcon(iconType, "on");
				//$("#icon"+iconType).addClass("on"); 
				$("#check"+iconType).show();
				common.setCookie('cookieSocialIcon',iconType,30);
			} else {
				//$("#icon"+socialbar._typeArr[i]).removeClass("on");
				$("#check"+socialbar._typeArr[i]).hide();
			} 
		} 
	}, 
	talk : function() {	
		var iconType = common.getCookie('cookieSocialIcon');
		if(loginFlag[iconType] != "1") {
			$('#dialog').html("토크  아이콘이 로그인 되어있지 않습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰토크" });
			return false;
		}
		if(iconType == "") {
			$('#dialog').html("토크  아이콘을 1개 선택해주세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰토크" });
			return false;
		}
		var msg = $("#msg").val();
		if(msg == "") {
			$('#dialog').html("토크내용이 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰토크" });
			return false;
		}
		var url = "/common/socialbar.talk.proc";
		msg = encodeURIComponent(msg);
		var data = "&type=" + iconType + "&rno=" + this._rno + "&msg=" + msg + "&url=" + shortUrl;
		$.ajax({ type: "POST", url: url, data: data, success: this.talkRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	}, 
	talkRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var msg = "";
		var html = "";
		if(result.result == "success") {
			common.initTextLimit("msg","msgnum");
			$("#talk_cnt").html(result.talk_cnt);
			html += "<tr id='talk"+result.talk.tno+"'>";
			//html += "<tr>";
			html += " 	<td align='center' class='line'>";
			html += " 		<img src='"+result.talk.icon+"' />";
			html += "	</td>";
			html += "	<td class='line'>";
			html += "		<div class='gray11_l_text text_overlay17'>"
			html += "		"+result.talk.ref;
			html += "		<img src='"+IMAGES+"/common/ico/ico_del.gif' onClick='socialbar.deleteTalk("+result.talk.tno+");' class='btn' align='absmiddle' />";	
			html += "		</div>";
			html += "		<div class='common11_text'><strong>"+result.talk.talk+"</strong></div>";
			html += "	</td>";
			html += "</tr>";
			$('#talk-list tr').eq(0).before(html);
			//$('#talk-last').html(result.talk.talk);
			socialbar.setTalkLast();
			msg = "리뷰에 토크를 달았습니다.";
		} else if(result.result == "nouser") {
			msg = "회원정보가 없습니다.";
		} else if(result.result == "session") {
			msg = "로그인이 필요합니다.";
		} else if(result.result == "limit") {
			msg = "토크 도배방지입니다.<br />10초 후에 토크를 입력할 수 있습니다.";
		} else {
			msg = "리뷰에 토크달기가 실패하였습니다.";
		}
		$('#dialog').html(msg);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰토크" });
	},	
	viewTalk: function() {
		if(this._talkFlag == true) {
			this.closeTalk();
		} else {
			var offset = $("#talk-location").offset();
			this._talkFlag = true;
			$('#socialbar-talk').show("fast");
			$("#socialbar-talk").css("top", 61);
			$("#socialbar-talk").css("left", offset.left);
		}
	},	
	closeTalk: function() {
		this._talkFlag = false;
		$('#socialbar-talk').hide("fast");
	}, 	
	moreTalk: function() {
		if(this._rno == "" || this._tno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "토크 더보기" });
			return false;
		}
		var url = "/common/socialbar.talk.more.proc";	
		var data = "&rno=" + this._rno + "&tno=" + this._tno;
		$.ajax({ type: "POST", url: url, data: data, success: this.moreTalkRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},	
	moreTalkRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var msg = "";
		var html = "";
		if(result.result == "success") {			
			if(result.ntno == "" || result.ntno == null) {
				$("#talk-more").hide();
			} else {
				socialbar._tno = result.tno;
				$("#talk-more").show();
			}
			for(var i=0; i<result.talk.length; i++) {
				html = "";
				html += "<tr id='talk"+result.talk[i].tno+"'>";
				html += " 	<td align='center' class='line'>";
				html += " 		<img src='"+result.talk[i].icon+"' />";
				html += "	</td>";
				html += "	<td class='line'>";
				html += "		<div class='gray11_l_text text_overlay17'>"
				html += "		"+result.talk[i].ref;
				html += "		<img src='"+IMAGES+"/common/ico/ico_del.gif' onClick='socialbar.deleteTalk("+result.talk[i].tno+");' class='btn' align='absmiddle' />";	
				html += "		</div>";
				html += "		<div class='common11_text'><strong>"+result.talk[i].talk+"</strong></div>";
				html += "	</td>";
				html += "</tr>";
				$('#talk-list > tbody:last').append(html);
			}
		} else {
			$('#dialog').html("토크 더보기가 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "토크 더보기" });
			return false;
		}
	}, 	
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
					$.ajax({ type: "POST", url: url, data: data, success: socialbar.deleteTalkRequest });
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
			$("#talk"+result.tno).hide("fast");
			$("#talk_cnt").html(result.talk_cnt);
			socialbar.setTalkLast();
			$('#dialog').html("토크가 삭제되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "토크삭제" });
			return false;
		} else if(result.result == "priv") {
			$('#dialog').html("토크를 삭제할 권한이 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "토크삭제" });
			return false;
		} else {
			$('#dialog').html("토크삭제가 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "토크삭제" });
			return false;
		}
	},
	setTalk: function(type) {
		this._talkFlag = false;
		common.setCookie('cookieSocialIcon',type,30);
		socialbar.todoIcon(type);
		$('#msg').val(reviewTitle+" "+shortUrl);
		//$('#msg').val(reviewTitle);
		common.setTextLimit('msg', 'msgnum', 150);		
		this.viewTalk();
	}, 	
	setTalkLast: function() {
		var url = "/common/socialbar.talk.last.proc";	
		var data = "&rno=" + this._rno;
		$.ajax({ type: "POST", url: url, data: data, success: this.setTalkLastRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	}, 	
	setTalkLastRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$("#talk-last").html(result.talk.talk);	
			if(loginFlag['T'] != "") _gaq.push(['_trackSocial', 'twitter', 'tweet', shortUrl]);
			if(loginFlag['F'] != "") _gaq.push(['_trackSocial', 'facebook', 'send', shortUrl]);
		} else {
			$("#talk-last").html(result.talk);
		}
	} 
	
};