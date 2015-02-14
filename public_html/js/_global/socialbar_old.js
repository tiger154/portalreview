$(document).ready( function(e) {
	
});

$(window).scroll(function() {
	if($(window).scrollTop() >= $(document).height() - $(window).height()) {
		socialbar._viewFlag = true;
	}
});

$(window).resize(function() {
	/*
	$('#socialbar').css('width', $(document).width());
	$('#socialbar').css('height', $(document).height());
	$('#socialbar-frame').css('width', $(document).width());
	$('#socialbar-frame').css('height', $(document).height());
	*/
	var _left = ($(window).width()/2)-($('#socialbar').width()/2);
	$('#socialbar').css({ "left": _left });
	$('#socialbar-frame').css({ "left": _left });
});

var socialbar = {	
	_height: 0,
	_viewFlag : false, 	
	load: function(rno) {
		if(rno == "") {
			$('#dialog').html("리뷰정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰보기"});
			return false;
		} else {
			this._height = $(document).height();
			$('#socialbar').css({ "top": 0, "left": 0, "position": "absolute"}).show();
			$('#socialbar-frame').css({ "top": 0, "left": 0, "height": this._height, "position": "absolute"}).show();
		}
		var url = "/common/socialbar.view";
		var data = "&rno=" + rno;
		$.ajax({ type: "POST", url: url, data: data, success: this.loadRequest });
		
	},	
	loadRequest: function(data) {
		//alert(data);
		var result = $.parseJSON(data);
		var nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		if(result.result == "success") {
			socialbar._viewFlag =  false;
			setTimeout(function(){ socialbar._viewFlag = true; }, 1000*5);
			$('html, body').animate({scrollTop:0}, 'slow');
			var html = "";
			var html2 = "";
			var height = socialbar._height;
			if(result.review.flag_best == "1") 
			html += "<div class='best'>";
			else 
			html += "<div class='common'>";
			if(result.flag_cand == "1")
			html += "	<div class='recom' onClick='socialbar.candRecom("+result.wno+","+result.review.rno+");'>"; 
			else 
			html += "	<div class='recom' onClick='socialbar.recom("+result.review.rno+");'>";
			html += "		<span class='white_title' id='recom_cnt'>"+result.review.recom_cnt+"</span>";
			html += "	</div>";
			html += "</div>";
			html += "	<img src='/images/myrevu/bg_bar_space.gif' class='fl' />";
			html += "<div class='space'></div>";
			html += "<div class='content'>";
			html += "	<div class='url'><a href='"+result.review.url+"' target='_blank'>"+result.review.url+"</a>&nbsp;</div>";
			html += "	<ul>";
			html += "		<li>"+result.ico_powerblog+"</li>";
			html += "		<li class='text white_text'><a href='javascript:context.load(\""+result.userno+"\");'>"+result.nickname+"</a></li>";
			html += "		<li class='space'></li>";
			html += "		<li><img src='/images/myrevu/bar_arrow.gif' alt='상세보기' title='상세보기' onClick='context.load("+result.userno+");' class='btn' /></li>";
			html += "		<li class='tab'></li>";
			html += "		<li><img src='/images/myrevu/bar_space.gif' /></li>";
			html += "		<li class='space'></li>";
			html += "		<li class='text'><span class='gray_l_text'>"+result.cate_desc+"</span></li>";
			html += "		<li class='space'></li>";
			html += "		<li id='review-position'><img src='/images/myrevu/bar_space.gif' /></li>";
			html += "		<li class='space'></li>";
			html += "		<li class='text white_text'><a href='javascript:socialbar.review("+result.userno+");'>"+result.review.title+"</a></li>";
			html += "		<li class='space'></li>";
			html += "		<li><img src='/images/myrevu/bar_arrow.gif' alt='상세보기' title='상세보기' onClick='socialbar.review("+result.userno+");' class='btn' /></li>";
			html += "		<li class='tab'></li>";
			html += "		<li><img src='/images/myrevu/bar_space.gif' /></li>";
			html += "		<li class='space'></li>";
			if(result.flag_login == "1")
			html += "		<li class='text'><a href='javascript:login.logout();'><span class='white_text'>로그아웃</span></a></li>";
			else 
			html += "		<li class='text'><a href='javascript:common.openLayer(\"loginlayer\");'><span class='white_text'>로그인</span></a></li>";
			html += "		<li class='close'><img src='/images/myrevu/but_xclose_bar.gif' alt='닫기' title='닫기' class='btn' onClick='socialbar.close("+result.review.rno+")' /></li>";
			html += "	</ul>";			
			html += "</div>";
			$('#socialbar').html(html);
			html2 += "<iframe id='social-iframe' width='100%' height='"+height+"' src='"+result.review.url+"'></iframe>";
			$('#socialbar-frame').html(html2);
			var left = ($(window).width()/2)-($('#socialbar').width()/2);
			$('#socialbar').css({ "left": left }).show();
			$('#socialbar-frame').css({ "left": left }).show();
			$('#socialbar').show();	
			$('#socialbar-frame').show();
			$('#bglayer').css('width', $(document).width());
	        $('#bglayer').css('height', $(document).height());
	        $('#bglayer').show();
		} else {
			$('#socialbar').hide("fast");
			$('#dialog').html("리뷰정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰보기" });
		}
	}, 	
	loadRequest2: function(data) {
		var result = $.parseJSON(data);
		var nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		if(result.result == "success") {
			socialbar._viewFlag =  false;
			setTimeout(function(){ socialbar._viewFlag = true; }, 1000*5);
			$('html, body').animate({scrollTop:0}, 'slow');
			var html = "";
			var html2 = "";
			var height = socialbar._height;
			if(result.review.flag_best == "1") 
			html += "<div class='best'>";
			else 
			html += "<div class='common'>";
			if(result.flag_cand == "1")
			html += "	<div class='recom' onClick='socialbar.candRecom("+result.wno+","+result.review.rno+");'>"; 
			else 
			html += "	<div class='recom' onClick='socialbar.recom("+result.review.rno+");'>";
			html += "		<span class='white_title' id='recom_cnt'>"+result.review.recom_cnt+"</span>";
			html += "	</div>";
			html += "</div>";
			html += "	<img src='/images/myrevu/bg_bar_space.gif' class='fl' />";
			html += "<div class='space'></div>";
			html += "<div class='content'>";
			html += "	<div class='url'><a href='"+result.review.url+"' target='_blank'>"+result.review.url+"</a>&nbsp;</div>";
			html += "	<ul>";
			html += "		<li>"+result.ico_powerblog+"</li>";
			html += "		<li class='text white_text'><a href='javascript:context.load(\""+result.userno+"\");'>"+result.nickname+"</a></li>";
			html += "		<li class='space'></li>";
			html += "		<li><img src='/images/myrevu/bar_arrow.gif' alt='상세보기' title='상세보기' onClick='context.load("+result.userno+");' class='btn' /></li>";
			html += "		<li class='tab'></li>";
			html += "		<li><img src='/images/myrevu/bar_space.gif' /></li>";
			html += "		<li class='space'></li>";
			html += "		<li class='text'><span class='gray_l_text'>"+result.cate_desc+"</span></li>";
			html += "		<li class='space'></li>";
			html += "		<li id='review-position'><img src='/images/myrevu/bar_space.gif' /></li>";
			html += "		<li class='space'></li>";
			html += "		<li class='text white_text'><a href='javascript:socialbar.review("+result.userno+");'>"+result.review.title+"</a></li>";
			html += "		<li class='space'></li>";
			html += "		<li><img src='/images/myrevu/bar_arrow.gif' alt='상세보기' title='상세보기' onClick='socialbar.review("+result.userno+");' class='btn' /></li>";
			html += "		<li class='tab'></li>";
			html += "		<li><img src='/images/myrevu/bar_space.gif' /></li>";
			html += "		<li class='space'></li>";
			if(result.flag_login == "1")
			html += "		<li class='text'><a href='javascript:login.logout();'><span class='white_text'>로그아웃</span></a></li>";
			else 
			html += "		<li class='text'><a href='javascript:common.openLayer(\"loginlayer\");'><span class='white_text'>로그인</span></a></li>";
			html += "		<li class='close'><img src='/images/myrevu/but_xclose_bar.gif' alt='닫기' title='닫기' class='btn' onClick='socialbar.close("+result.review.rno+")' /></li>";
			html += "	</ul>";
			html += "</div>";
			$('#socialbar').html(html);
			html2 += "<iframe id='social-iframe' width='100%' height='"+height+"' src='"+result.review.url+"'></iframe>";
			$('#socialbar-frame').html(html2);
			var left = ($(window).width()/2)-($('#socialbar').width()/2);
			$('#socialbar').css({ "left": left }).show();
			$('#socialbar-frame').css({ "left": left }).show();
			$('#socialbar').show();	
			$('#socialbar-frame').show();
			$('#bglayer').css('width', $(document).width());
	        $('#bglayer').css('height', $(document).height());
	        $('#bglayer').show();
		} else {
			$('#socialbar').hide("fast");
			$('#dialog').html("리뷰정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰보기" });
		}
	}, 	
	recomView: function(rno) {
		$('#dialog2').html("리뷰를 보기페이지에서 추천가능합니다.<br />리뷰를 보시겠습니까?");
		$('#dialog2').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "리뷰추천",		
			buttons: { 
				"리뷰보기": function(e) { 
					$(this).dialog("close");
					socialbar._height = $(document).height();
					//alert($(window).height()); 
					$('#socialbar').css({ "top": 0, "left": 0, "position": "absolute"}).show();
					$('#socialbar-frame').css({ "top": 0, "left": 0, "height": socialbar._height, "position": "absolute"}).show();
					socialbar.load(rno); 
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
	},	
	recomRequest: function(data) {
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
		//alert(data);
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
		//alert(data);
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
		//var url = "/common/socialbar.review";
		var url = "/common/socialbar.review.new";
		var data = "&userno=" + userno;		
		$.ajax({ type: "POST", url: url, data: data, success: this.reviewRequest });
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
			html += "			<a href='javascript:socialbar.load("+result.list[i].rno+");'>"+result.list[i].title+"</a>";
			html += "		</div>";
			}
			html += "	</div>";
			html += "</div>";
			//common.openPopupLayer("popuplayer", html, 460, 279, 120, -1);
			var socialbar = $("#review-position");
			var position = socialbar.position();
			common.openPopupLayer("popuplayer", html, 460, 279, position.top+145, position.left+155);
		} else {
			$('#dialog').html("최근 작성된 리뷰를 불러오는데 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "최근 작성된 리뷰보기" });
		}
	},	
	frontier: function() {
		var url = "/common/socialbar.frontier";
		var data = "";
		$.ajax({ type: "POST", url: url, data: data, success: this.frontierRequest });
	}, 	
	frontierRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {	
			var length = result.list.length;
			var html = "";
			html += "진행중인 프론티어";
			html += "<input type='button' value='X' onClick='common.closePopupLayer(\"popuplayer\");'";
			html += "<br /><br />";
			html += "<ul>"		
			for(var i=0; i<length; i++) {
				html += "<li><a href='javascript:common.redirect(\"/frontier/detailview/"+result.list[i].frno+"\");'>"+result.list[i].img+"</li>";
			}
			html += "</ul>";
			common.openPopupLayer(html, 30, 760);
		} else {
			$('#dialog').html("진행중인 프론티어 정보를 불러오는데 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "진행중인 프론티어" });
		}
	},	
	close: function(rno) {
		if(rno != "") window.location.href = "#"+rno;
		$('#socialbar').hide("fast");		
		$('#socialbar-frame').hide("fast");
		$('#popuplayer').hide("fast");
		$('#bglayer').hide();
	} 
};