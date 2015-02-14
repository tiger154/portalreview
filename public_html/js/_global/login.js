<!--
$(document).ready( function() {	
	if($('#login_userid').val() == "") {		
		$('#login_userid').css("background-image", "url("+IMAGES+"/common/bg_login_id.gif)");
		$('#login_userid').css("background-repeat", "no-repeat");
	};
	if($('#login_passwd').val() == "") {		
		$('#login_passwd').css("background-image", "url("+IMAGES+"/common/bg_login_pw.gif)");
		$('#login_passwd').css("background-repeat", "no-repeat");
	};	
	$('#login_userid').bind({ 	
		focusin: function() { $(this).css("background-image", ""); },
		focusout: function(){
			if($(this).val() == "") {
				$(this).css("background-image", "url("+IMAGES+"/common/bg_login_id.gif)");
				$(this).css("background-repeat", "no-repeat");
			}		
		},
		keydown: function(evt) {
			var evCode = (window.netscape) ? evt.which : evt.keyCode;
			if(evCode == 13) result = true;
			else result = false;
			if(result == true) login.login('login_userid', 'login_passwd', 'login_saveid', REQUEST_URI);
		}
	});		
	$('#login_passwd').bind({		
		focusin: function() {
			$(this).css("background-image", "");
		},
		focusout: function(){
			if($(this).val() == "") {
				$(this).css("background-image", "url("+IMAGES+"/common/bg_login_pw.gif)");
				$(this).css("background-repeat", "no-repeat");
			}		
		},
		keydown: function(evt) {
			var evCode = (window.netscape) ? evt.which : evt.keyCode;
			if(evCode == 13) result = true;
			else result = false;
			if(result == true) login.login('login_userid', 'login_passwd', 'login_saveid', REQUEST_URI);
		}
	});
	if($('#login_userid2').val() == "") {		
		$('#login_userid2').css("background-image", "url("+IMAGES+"/common/bg_login_id.gif)");
		$('#login_userid2').css("background-repeat", "no-repeat");
	}
	if($('#login_passwd2').val() == "") {		
		$('#login_passwd2').css("background-image", "url("+IMAGES+"/common/bg_login_pw.gif)");
		$('#login_passwd2').css("background-repeat", "no-repeat");
	};
	$('#login_userid2').bind({ 	
		focusin: function() { $(this).css("background-image", ""); },
		focusout: function(){
			if($(this).val() == "") {
				$(this).css("background-image", "url("+IMAGES+"/common/bg_login_id.gif)");
				$(this).css("background-repeat", "no-repeat");
			}		
		},
		keydown: function(evt) {
			var evCode = (window.netscape) ? evt.which : evt.keyCode;
			if(evCode == 13) result = true;
			else result = false;
			if(result == true) login.login('login_userid2', 'login_passwd2', 'login_save2', REQUEST_URI);
		}
	});
	$('#login_passwd2').bind({
		focusin: function() {
			$(this).css("background-image", "");
		},
		focusout: function(){
			if($(this).val() == "") {
				$(this).css("background-image", "url("+IMAGES+"/common/bg_login_pw.gif)");
				$(this).css("background-repeat", "no-repeat");
			}		
		},
		keydown: function(evt) {
			var evCode = (window.netscape) ? evt.which : evt.keyCode;
			if(evCode == 13) result = true;
			else result = false;
			if(result == true) login.login('login_userid2', 'login_passwd2', 'login_save2', REQUEST_URI);	
		}
	});
	if($('#login_userid3').val() == "") {		
		$('#login_userid3').css("background-image", "url("+IMAGES+"/common/bg_login_id.gif)");
		$('#login_userid3').css("background-repeat", "no-repeat");
	}
	if($('#login_passwd3').val() == "") {		
		$('#login_passwd3').css("background-image", "url("+IMAGES+"/common/bg_login_pw.gif)");
		$('#login_passwd3').css("background-repeat", "no-repeat");
	};
	$('#login_userid3').bind({ 	
		focusin: function() { $(this).css("background-image", ""); },
		focusout: function(){
			if($(this).val() == "") {
				$(this).css("background-image", "url("+IMAGES+"/common/bg_login_id.gif)");
				$(this).css("background-repeat", "no-repeat");
			}		
		},
		keydown: function(evt) {
			var evCode = (window.netscape) ? evt.which : evt.keyCode;
			if(evCode == 13) result = true;
			else result = false;
			if(result == true) login.slogin('login_userid3', 'login_passwd3', 'login_save2', REQUEST_URI);
		}
	});
	$('#login_passwd3').bind({
		focusin: function() {
			$(this).css("background-image", "");
		},
		focusout: function(){
			if($(this).val() == "") {
				$(this).css("background-image", "url("+IMAGES+"/common/bg_login_pw.gif)");
				$(this).css("background-repeat", "no-repeat");
			}		
		},
		keydown: function(evt) {
			var evCode = (window.netscape) ? evt.which : evt.keyCode;
			if(evCode == 13) result = true;
			else result = false;
			if(result == true) login.slogin('login_userid3', 'login_passwd3', 'login_save3', REQUEST_URI);	
		}
	});
	//$('#loginBtn').bind('click', function() { login.login('login_userid', 'login_passwd', 'login_saveid', REQUEST_URI); });
	$('#loginBtn').bind('click', function() { login.customlogin('login_userid', 'login_passwd', 'login_saveid', REQUEST_URI); }); //2012.09.21 SSL Login proc
	$('#logoutBtn').bind('click', function() { login.logout(); });	
	$('#twitterBtn').bind('click', function() {
		//$('#dialog').html("준비중입니다.");
		//$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "소셜로그인-트위터"});
		twitter.todo("login", "1"); 
	});	
	$('#twitterBtn2').bind('click', function() { twitter.todo("login", "1"); });
	$('#twitterBtn3').bind('click', function() { twitter.todo("login"); });
	$('#facebookBtn').bind('click', function() { 
		//$('#dialog').html("준비중입니다.");
		//$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "소셜로그인-페이스북"});
		facebook.todo("login", "1");
	});
	$('#facebookBtn2').bind('click', function() { facebook.todo("login", "1"); });
	$('#facebookBtn3').bind('click', function() { facebook.todo("login"); });
	$('#joinSiteBtn').bind('click', function() { login.join(); });
	$('#searchInfoBtn').bind('click', function() { login.searchInfo(); });
	//$('#snsInfoBtn').bind('click', function() { login.snsInfo(); });
	$('#blogAddBtn').bind('click', function() { common.redirect('/myrevu/blog.register'); });
	//$('#blogDelBtn').bind('click', function() { alert('블로그 정보삭제할꺼!'); });
	$('#reviewRegBtn').bind('click', function() { common.redirect('/myrevu/review.register'); });
	$('.loginTabBtn1').bind('click', function() { login.showTab(1); });
	$('.loginTabBtn2').bind('click', function() { login.showTab(2); });
	$('.loginTabBtn3').bind('click', function() { login.showTab(3); });
	$('.loginFrontierBtn1').bind('click', function() { login.showFrontierTab(1); });
	$('.loginFrontierBtn2').bind('click', function() { login.showFrontierTab(2); });
	$('#moreBtn1').bind('click', function() { common.redirect('/myrevu/blog'); });
	$('#moreBtn2').bind('click', function() { common.redirect('/myrevu/frontier'); });
	$('#moreBtn3').bind('click', function() { common.redirect('/myrevu/cash'); });
	$('#refreshBtn1').bind('click', function() { login.refreshTab(); });
	$('#refreshBtn2').bind('click', function() { login.refreshTab(); });
	$('#refreshBtn3').bind('click', function() { login.refreshTab(); });
	login.showTab(common.getCookie('cookieLoginTab'));
});
var secureDomain = "https://www.revu.co.kr";
var login = {
	login: function(userid, passwd, saveid, returl) {
		var userid = encodeURIComponent($('#'+userid).val());
		var passwd = encodeURIComponent($('#'+passwd).val());
		var saveid = ($('input:checkbox[name='+saveid+']').attr('checked') == 'checked') ? $('#'+saveid).val() : "0";
		var returl = encodeURIComponent(returl);
		if(this.valID(userid) == false) {
			return false;
		}
		if(this.valPasswd(passwd) == false) {
			return false;
		}
		//var url = secureDomain+"/auth/login.ajax.proc";
		var url ="/auth/login.ajax.proc";
		//var data = "&userid=" + $('#login_userid').val() + "&passwd=" + $('#login_passwd').val();
		var data = "&userid=" + userid + "&passwd=" + passwd + "&saveid=" + saveid + "&url=" + returl;
		$.ajax({ type: "POST", url: url, data: data, success: this.loginResult });
	},	
	loginResult: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			common.redirect(result.url);
		} else {
			$('#passwd').val("");
			$('#dialog').html("아이디 또는 비밀번호를 확인하시길 바랍니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "로그인 실패"});
		}
	},
    	customlogin: function(userid, passwd, saveid, returl) {
		
		var userid = encodeURIComponent($('#'+userid).val());
		var passwd = encodeURIComponent($('#'+passwd).val());

		var saveid = ($('input:checkbox[name='+saveid+']').attr('checked') == 'checked') ? $('#'+saveid).val() : "0";
		var returl = encodeURIComponent(returl);
		if(this.valID(userid) == false) {
			return false;
		}
		if(this.valPasswd(passwd) == false) {
			return false;
		}	
//		var actionurl ="http://www.revu.co.kr/auth/login.ajax.proc";
		var actionurl = secureDomain+"/auth/customlogin.ajax.proc";
		$('#loginForm').attr('method', 'post');
		$('#loginForm').attr('action', actionurl);	
		$('#loginForm').append("<input type='hidden' name='userid' id='userid' />");	
		$('#loginForm').append("<input type='hidden' name='passwd' id='passwd' />");	
		$('#userid').val(userid);
		$('#passwd').val(passwd);		
		$('#loginForm').submit();


//		//var data = "&userid=" + $('#login_userid').val() + "&passwd=" + $('#login_passwd').val();
//		var data = "&userid=" + userid + "&passwd=" + passwd + "&saveid=" + saveid + "&url=" + returl;
//		$.ajax({ type: "POST", url: url, data: data, success: this.customloginResult });
	},	
	customloginResult: function(data) {		
		var result = $.parseJSON(data);
		if(result.result == "success") {
			common.redirect(result.url);
		} else {
			$('#passwd').val("");
			$('#dialog').html("아이디 또는 비밀번호를 확인하시길 바랍니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "로그인 실패"});
		}
	},
	logout: function() {
		$('#loginForm').attr('method', 'post');
		$('#loginForm').attr('action', '/auth/logout.proc');	
		$('#loginForm').submit();
	},
	slogin: function(userid, passwd, saveid, returl) {
		var userid = encodeURIComponent($('#'+userid).val());
		var passwd = encodeURIComponent($('#'+passwd).val());
		var saveid = ($('input:checkbox[name='+saveid+']').attr('checked') == 'checked') ? $('#'+saveid).val() : "0";
		var returl = encodeURIComponent(returl);
		if(this.valID(userid) == false) {
			return false;
		}
		if(this.valPasswd(passwd) == false) {
			return false;
		}		
		
//		var actionurl = secureDomain+"/auth/customlogin.ajax.proc";
//		$('#loginlayer').append("<form name='layerLoginForm' id='layerLoginForm'/>");
//		$('#layerLoginForm').attr('method', 'post');
//		$('#layerLoginForm').attr('action', actionurl);	
//		$('#layerLoginForm').append("<input type='hidden' name='userid' id='userid' />");	
//		$('#layerLoginForm').append("<input type='hidden' name='passwd' id='passwd' />");	
//		$('#userid').val(userid);
//		$('#passwd').val(passwd);		
//		$('#layerLoginForm').submit();


		var url ="/auth/login.ajax.proc";
		//var data = "&userid=" + $('#login_userid').val() + "&passwd=" + $('#login_passwd').val();
		var data = "&userid=" + userid + "&passwd=" + passwd + "&saveid=" + saveid + "&url=" + returl;
		$.ajax({ type: "POST", url: url, data: data, success: this.sloginResult });
		$('#dialog-modal').dialog({ autoOpen: true });
	},
	sloginResult: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			loginFlag['R'] = '1';
			socialbar.turnIcon('R', 'on');
			socialbar.setIcon();
			common.closeLayer('loginlayer');
			$('#login_userid3').val("");
			$('#login_passwd3').val("");
		} else {
			$('#passwd').val("");
			$('#dialog').html("아이디 또는 비밀번호를 확인하시길 바랍니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "로그인 실패"});
		}
	},
	valID: function(userid) {
		//var userid = $('#login_userid').val();
		if(userid == "") {
			$('#dialog').html("아이디를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 확인"});
			return false;
		}
		//아이디 하이픈 문제로 블록킹 해제 2011.10.15 박상선
		//if(validation.isEngNum(userid) == false) {
		//	$('#dialog').html("아이디는 영문/숫자로 되어야 합니다.");
		//	$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 확인"});
		//	return false;
		//}
		if(validation.isSpace(userid) == true) {
			$('#dialog').html("아이디는 공백이 없어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 확인"});
			return false;
		}
		if(validation.isLength(userid, 4, 12) == false) {
			$('#dialog').html("아이디는 4~12자리로 되어 있어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "아이디 확인"});
			return false;
		}
		return true;
	},
	valPasswd: function(passwd) {
		//var passwd = $('#login_passwd').val();
		if(passwd == "") {
			$('#dialog').html("비밀번호를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "입력값 확인"});
			return false;
		}
		if(validation.isLength(passwd, 4, 25) == false) {
			$('#dialog').html("비밀번호는 4~20자리로 되어 있어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "비밀번호 확인"});
			return false;
		}
		if(validation.isSpace(passwd) == true) {
			$('#dialog').html("비밀번호는 공백이 없어야 합니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "비밀번호 확인"});
			return false;
		}
	},
	twitter: function() {
		common.popup('twitterLoginPopup', '/auth/twitter/', 700, 750);
	},
	facebook: function() {
		common.popup('twitterLoginPopup', '/auth/facebook/', 1000, 600);
	},
	join: function() {
		common.redirect("/join");
	},
	searchInfo: function() {
		common.redirect("/auth/idpw");
	},
	snsInfo: function() {
		$('#dialog').html("현재 준비중입니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "소셜로그인 안내"});
	},
	showTab: function(num) {
		
		switch(parseInt(num)) {
			case 2 :
				$('#login-tab1').hide(); $('#login-tab2').show(); $('#login-tab3').hide();
				$('#login-btn1').hide(); $('#login-btn2').show(); $('#login-btn3').hide();
				common.setCookie('cookieLoginTab','2',1);
				break;
			case 3 :
				$('#login-tab1').hide(); $('#login-tab2').hide(); $('#login-tab3').show();
				$('#login-btn1').hide(); $('#login-btn2').hide(); $('#login-btn3').show();
				common.setCookie('cookieLoginTab','3',1);
				break;
			case 1 :
			default : 
				$('#login-tab1').show(); $('#login-tab2').hide(); $('#login-tab3').hide();
				$('#login-btn1').show(); $('#login-btn2').hide(); $('#login-btn3').hide();
				common.setCookie('cookieLoginTab','1',1);
		}
	},
	showFrontierTab: function(num) {
		switch(num) {
			case 2 :
				$('#login-frontier1').hide();
				$('#login-frontier2').show();
				break;
			case 1 :
			default : 
				$('#login-frontier1').show();
				$('#login-frontier2').hide();
		}
	},
	refreshTab: function() {
		var url = "/auth/login.refresh.proc";
		var data = "";
		$.ajax({ type: "POST", url: url, data: data, success: this.refreshTabResult });
		$('#dialog-modal').dialog({ autoOpen: true });
	},
	refreshTabResult: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			var blog = result.blog.blog_list;			
			for(var i=0; i<blog.length; i++) {
				$('#login-tab-blog'+i).html("");
				var html = "";
				html += "<a href='"+blog[i].url+"' target='_blank'><span class='common11_text'>"+blog[i].name+"</span></a>";
				html += "&nbsp;&nbsp;";
				html += "<span class='red11_text'>("+blog[i].review_cnt+")</span>";
				$('#login-tab-blog'+i).html(html);
			}
			
			var frontier1 = result.frontier1;			
			var html = "";
			html += "<ul>";
			html += "	<li style='height:13px;'>";
			html += "		<img src='/images/join/title_myfrontier_on1.gif' alt='당첨된프론티어' title='당첨된프론티어' class='loginFrontierBtn1 btn' /><img src='/images/join/title_myfrontier_off2.gif' alt='응모중인프론티어' title='응모중인프론티어' class='loginFrontierBtn2 btn' />";
			html += "	</li>";
			if(frontier1.frontier_cnt1 > 0) {
			html += "	<li class='pb15'></li>";
				for(var i=0; i<frontier1.frontier_cnt1; i++) {
				html += "<li class='pb09'>";
				html += "	<a href='/frontier/detailview//"+frontier1.frontier_list1[i].frno+"//' target='_top'><span class='common11_text'><font color='#336633'>"+frontier1.frontier_list1[i].title+"</font></span></a>&nbsp;"
				html += "</li>";
				}
			} else {
			html += "	<li class='pb25'></li>";
			html += "	<li class='common11_text'><center>당첨된 프론티어가 없습니다.</center></li>";	
			}
			html += "</ul>";
			$('#login-frontier1').html(html);
			
			var frontier2 = result.frontier2;			
			var html = "";
			html += "<ul>";
			html += "	<li style='height:13px;'>";
			html += "		<img src='/images/join/title_myfrontier_off1.gif' alt='응모중인프론티어' title='응모중인프론티어' class='loginFrontierBtn1 btn' /><img src='/images/join/title_myfrontier_on2.gif' alt='응모중인프론티어' title='응모중인프론티어' class='loginFrontierBtn2 btn' />";
			html += "	</li>";
			if(frontier2.frontier_cnt2 > 0) {
			html += "	<li class='pb15'></li>";
				for(var i=0; i<frontier2.frontier_cnt2; i++) {
				html += "<li class='pb09'>";
				html += "	<a href='/frontier/detailview//"+frontier2.frontier_list2[i].frno+"//' target='_top'><span class='common11_text'><font color='#336633'>"+frontier2.frontier_list2[i].title+"</font></span></a>&nbsp;"
				html += "</li>";
				}
			} else {
			html += "	<li class='pb25'></li>";
			html += "	<li class='common11_text'><center>응모중인 프론티어가 없습니다.</center></li>";	
			}
			html += "</ul>";
			$('#login-frontier2').html(html);			
			
			$('#login-tab-cash').html(result.user.cash);
			$('#login-tab-point').html(result.user.point);
			$('#login-tab-recom-cnt').html(result.stats.recom_cnt);
			$('#login-tab-talk-cnt').html(result.stats.talk_cnt);
		} else {
			$('#passwd').val("");
			$('#dialog').html("아이디 또는 비밀번호를 확인하시길 바랍니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "로그인 실패"});
		}
	}
};
-->