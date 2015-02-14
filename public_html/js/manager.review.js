$(document).ready( function() {
	$('#searchReviewBtn').bind('click', function() { mngreview.searchReview('cate1', 'cate2', 'cate3', 'cate4', '', ''); });
	$('#searchReviewBtn2').bind('click', function() { mngreview.searchReview2(); });
	$('#cate1').bind('change', function() { category.change1('cate1','cate2','cate3','cate4'); });
	$('#cate2').bind('change', function() { category.change2('cate1','cate2','cate3','cate4'); });
	$('#cate3').bind('change', function() { category.change3('cate1','cate2','cate3','cate4'); });
	try { category.set('cate1', 'cate2', 'cate3', 'cate4', code); } catch(err) {}
	$('#upKeywordBtn').bind('click', function() { mngreview.upKeyword(); });
	$('#downKeywordBtn').bind('click', function() { mngreview.downKeyword(); });
	$('#regKeywordBtn').bind('click', function() { mngreview.registerKeyword(); });
	$('#removeKeywordBtn').bind('click', function() { mngreview.removeKeyword(); });
	$('#appKeywordBtn').bind('click', function() { mngreview.confirmAppKeyword(); });
	$('#searchKeywordLinkBtn').bind('click', function() { mngreview.searchKeywordLink(); });
	$('#rnoKeywordLinkBtn').bind('click', function() { mngreview.registerKeywordLink($('#reg_rno').val()); });
	$('#file1').bind('change', function () {
		if($(this).val() != "") {
			if(mngreview.checkKeywordImage($(this).val()) == false) {
				$(this).val(""); 
				$('#dialog').html("이미지 파일(jpg)만 가능합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "키워드 이미지 등록"});
			} else {
				if(mngreview._kno == 0) {
					$('#dialog').html("키워드 선택 후 이미지를 등록하세요.");
					$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "키워드 이미지 등록" });
					return false;
				} 
				if(mngreview._rno == 0) {
					$('#dialog').html("키워드 리뷰를 선택 후 이미지를 등록하세요.");
					$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "키워드 이미지 등록" });
					return false;
				} 
				$('#kno').val(mngreview._kno);
				$('#rno').val(mngreview._rno);
				$('#dialog-modal').dialog({ autoOpen: true });
				$('#form1').attr('target', 'frmFile');
				$('#form1').attr('method', 'post');
				$('#form1').attr('action', '/manager/review.keyword.image.upload.proc'); 
				$('#form1').submit();
			}
		}
	});
});

var mngreview = {	
	_wno : 0,
	_wno_prev : 0,
	_kno : 0, 
	_rno : 0, 
	searchReview: function(cate1, cate2, cate3, cate4, order, desc) {		
		var _cate1 = $("#"+cate1).val();
		var _cate2 = $("#"+cate2).val();
		var _cate3 = $("#"+cate3).val();
		var _cate4 = $("#"+cate4).val();
		var url = '/manager/review';
		url += "/1/"+_cate1;
		url += (_cate2 == "") ? "" : _cate2;
		url += (_cate3 == "") ? "" : _cate3;
		url += (_cate4 == "") ? "" : _cate4;
		url += (order == "") ? "" : "/"+order;
		url += (desc == "") ? "" : "/"+desc;
		common.redirect(url);
	}, 	
	searchReview2: function() {		
		var opt = $("#opt").val();
		var keyword = $("#keyword").val();
		var url = '/manager/review2/1';
		url += (opt == "") ? "" : "/"+opt;		
		url += (keyword == "") ? "" : "/"+keyword;
		common.redirect(url);
	}, 
	confirmStatus: function(rno) {
		if(rno == "") {
			$('#dialog').html("잘못된 정보입니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰 상태값 변경"});
			return false;
		}
		html = "";
		html += "상태값 : ";
		html += "<select id='status'>";
		html += "<option value=''>==선택==</option>";		
		html += "<option value='0'>비공개(대기)</option>";
		html += "<option value='1'>공개(등록중)</option>";
		html += "<option value='2'>삭제</option>";
		html += "</select>";
		$('#dialog').html(html);
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "리뷰 상태값 변경",		
			buttons: { "변경": function(e) { mngreview.procStatus(rno); }, "닫기": function() { $(this).dialog("close");} }
		});
	}, 
	procStatus: function(rno) {
		var status = $("#status").val();
		if(status == "") {
			$('#dialog2').html("상태값을  선택하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰 상태값 변경"});
			return false;
		}
		var url = "/manager/review.status.proc";
		var data = "&rno=" + rno + "&status=" + status;
		$.ajax({ type: "POST", url: url, data: data, success: this.procStatusRequest });
	},
	procStatusRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			if(result.status == "0") {
				$('#dialog').html("비공개 되었습니다.");
			} else if(result.status == "1") {
				$('#dialog').html("공개 되었습니다.");
			} else if(result.status == "2") {
				$('#dialog').html("삭제 되었습니다.");
			} 
		} else {
			$('#dialog').html("처리가 실패하였습니다.");			
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "리뷰 상태값 변경",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});
	},	
	list: function(wno, type) {	
		$('#reviewList').html("");
		$('#dialog-modal').dialog({ autoOpen: true });
		
		switch(type) {
			case "candlist" : 
				var url = "/manager/review.best.candlist.proc";
				var data = "&wno=" + wno;
				$.ajax({ type: "POST", url: url, data: data, success: this.bestCandListRequest });
				break;
			case "votelist" : 
				var url = "/manager/review.best.votelist.proc";
				var data = "&wno=" + wno;
				$.ajax({ type: "POST", url: url, data: data, success: this.bestVoteListRequest });
				break;
			case "list" : 
			default : 
				var url = "/manager/review.best.list.proc";
				var data = "&wno=" + wno;
				$.ajax({ type: "POST", url: url, data: data, success: this.bestListRequest });
				break;
		}
	},	
	list2: function(wno) {	
		this._wno = wno_now;
		this._wno_prev = wno_prev; 
		$('#reviewList').html("");
		$('#dialog-modal').dialog({ autoOpen: true });
		
		if(this._wno <= wno) {
			var url = "/manager/review.best.candlist.proc";
			var data = "&wno=" + wno;
			$.ajax({ type: "POST", url: url, data: data, success: this.bestCandListRequest });
		} else if(this._wno_prev == wno) {
			var url = "/manager/review.best.votelist.proc";
			var data = "&wno=" + wno;
			$.ajax({ type: "POST", url: url, data: data, success: this.bestVoteListRequest });
		} else {
			var url = "/manager/review.best.list.proc";
			var data = "&wno=" + wno;
			$.ajax({ type: "POST", url: url, data: data, success: this.bestListRequest });
		}
	},
	bestListRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var list = result.list;
		if(result.result == "success") {
			var html = "";
			html += "<ol>";	
			for(var i=0; i<list.length; i++) {				
				html += "<li>";
				html += "<div style='padding: 10px; border:1px solid #CCC;'>";
				html += "<b>"+list[i].rank+" 위</b>&nbsp;&nbsp;&nbsp;";
				//html += "<a href='javascript:common.socialbar("+list[i].rno+")' name='"+list[i].rno+"'>"+list[i].title+"</a>";
				//html += "<a href='"+list[i].url+"' target='_blank'>"+list[i].title+"</a>";
				html += "<a href='javascript:common.socialbar("+list[i].rno+", \"t\")' name='"+list[i].rno+"'>"+list[i].title+"</a>";
				html += "<br />";					
				html += "인기도:"+list[i].point;
				html += " / 추천수"+list[i].recom_cnt;
				html += " / 토크수:"+list[i].talk_cnt;
				html += " / 조회수:"+list[i].view_cnt;
				html += " / 등록일 : "+list[i].regdate;
				html += "<br /><hr />";
				html += "<a href='javascript:manager.user("+list[i].userno+")'>"+list[i].nickname+"("+list[i].userid+")</a>";
				html += " / 캐시:"+list[i].cash;
				html += " / 포인트:"+list[i].point;
				html += "<hr />";
				if(list[i].user) {
				html += "<ul>";
				for(var j=0; j<list[i].user.length; j++) {
				html += "<li>"+list[i].user[j].nickname+" <input type='button' value='캐시지급' onClick='mngreview.bestRecomPaycash("+list[i].user[j].userno+")' /></li>";
				}
				html += "</ul>";
				}
				html += "</div><br />";
				html += "</li>";
				
			}
			html += "</ol>";
			$('#reviewList').html(html);
		} else {
			$('#dialog').html("리뷰 베스트 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰베스트" });
		}
	},	
	bestRecomPaycash: function(userno) {
		if(userno == "") {
			$('#dialog').html("회원 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "회원 정보" });
			return false;
		}
		var url = "/manager/review.best.paycash.proc";
		var data = "&userno=" + userno;
		$.ajax({ type: "POST", url: url, data: data, success: this.bestRecomPaycashRequest });
	},
	bestRecomPaycashRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var list = result.list;
		if(result.result == "success") {
			$('#dialog').html("캐시가 지급되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "베스트리뷰추천회원 캐시지급" });
		} else {
			$('#dialog').html("캐시지급이 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "베스트리뷰추천회원 캐시지급" });
		}
	},	
	bestCandListRequest: function(data) {
		//alert(data);
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var list = result.list;
		if(result.result == "success") {
			var html = "";
			html += "<div id='tabs'>";
			html += "<ul>";	
			for(var i=0; i<list.length; i++) {
				html += "<li><a href='#tabs-"+i+"'>"+list[i].cate_desc+"</a></li>";
			}
			html += "</ul>";			
			for(var i=0; i<list.length; i++) {
				//html += "<h4>"+list[i].cate_desc+"</h4>";
				html += "<div id='tabs-"+i+"'>";
				html += "<ol>";
				for(var j=0; j<list[i].list.length; j++) {
					var clist = list[i].list[j];
					html += "<li>";
					html += "<div style='padding: 10px; border:1px solid #CCC;'>";
					html += "<font color='red'><span id='besttext"+clist.rno+"'>"+clist.flag_best_text+"</span></font>&nbsp;";
					//html += "<a href='javascript:common.socialbar("+clist.rno+")'><b><font color='black'>"+clist.title+"</font></b></a>";
					//html += "<a href='"+clist.url+"' target='_blank'><b><font color='black'>"+clist.title+"</font></b></a>";			
					html += "<a href='javascript:common.socialbar("+clist.rno+", \"t\")'><b><font color='black'>"+clist.title+"</font></b></a>";		
					html += "<input type='button' value='선정' id='choose"+clist.rno+"' onClick='mngreview.choose("+list[i].wno+", "+clist.rno+", "+clist.userno+");' />";
					html += "<br />";					
					html += "인기도:"+clist.point;
					html += " / 추천수"+clist.recom_cnt;
					html += " / 토크수:"+clist.talk_cnt;
					html += " / 조회수:"+clist.view_cnt;
					html += " / 등록일 : "+clist.regdate;
					html += "<br /><hr />";
					html += "<span>"+clist.flag_user_text+"</span>&nbsp;";
					html += "<a href='javascript:manager.user("+clist.userno+")'>"+clist.nickname+"("+clist.userid+")</a>";
					html += " / 캐시:"+clist.cash;
					html += " / 포인트:"+clist.point;
					html += "</div><br />";
					html += "</li>";
				}
				html += "</ol>";
				html += "</div>";
				//html += "<hr />";
			}
			html += "</div>";	
			$('#reviewList').html(html);
			$('#tabs').tabs();

		} else {
			$('#dialog').html("리뷰후보 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰후보" });
		}
	},
	bestVoteListRequest: function(data) {
		//alert(data);
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var list = result.list;
		if(result.result == "success") {
			var html = "";
			html += "<div id='tabs'>";
			html += "<ul>";	
			for(var i=0; i<list.length; i++) {
				html += "<li><a href='#tabs-"+i+"'>"+list[i].cate_desc+"</a></li>";
			}
			html += "</ul>";			
			for(var i=0; i<list.length; i++) {
				//html += "<h4>"+list[i].cate_desc+"</h4>";
				html += "<div id='tabs-"+i+"'>";
				html += "<ol>";
				for(var j=0; j<list[i].list.length; j++) {
					var clist = list[i].list[j];
					html += "<li>";
					html += "<div style='padding: 10px; border:1px solid #CCC;'>";
					//html += "<a href='javascript:common.socialbar("+clist.rno+")'><b><font color='black'>"+clist.title+"</font></b></a>";
					//html += "<a href='"+clist.url+"' target='_blank'><b><font color='black'>"+clist.title+"</font></b></a>";
					html += "<a href='javascript:common.socialbar("+clist.rno+", \"t\")'><b><font color='black'>"+clist.title+"</font></b></a>";
					html += "<br />";
					html += "<b>베스트리뷰추천수 : <font color='red'>"+clist.best_recom_cnt+"</font></b>";
					html += "<br />";
					html += "인기도:"+clist.point;
					html += " / 추천수"+clist.recom_cnt;
					html += " / 토크수:"+clist.talk_cnt;
					html += " / 조회수:"+clist.view_cnt;
					html += " / 등록일 : "+clist.regdate;					
					html += "<br /><hr />";
					html += "<a href='javascript:manager.user("+clist.userno+")'>"+clist.nickname+"("+clist.userid+")</a>";
					html += " / 캐시:"+clist.cash;
					html += " / 포인트:"+clist.point;
					html += "</div><br />";
					html += "</li>";
				}
				html += "</ol>";
				html += "</div>";
				//html += "<hr />";
			}
			html += "</div>";	
			$('#reviewList').html(html);
			$('#tabs').tabs();

		} else {
			$('#dialog').html("리뷰후보 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰후보" });
		}
	},
	choose: function(wno, rno, userno) {
		$('#dialog-modal').dialog({ autoOpen: true });
		var url = "/manager/review.choose.proc";
		var data = "&wno=" + wno + "&rno=" + rno + "&userno=" + userno;
		$.ajax({ type: "POST", url: url, data: data, success: this.chooseRequest });
	},
	
	chooseRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var text = "";
		var msg = "";		
		if(result.result == "success") {
			if(result.type == "insert") text = "<b>선정</b>";
			else text = "";
			$('#besttext'+result.rno).html(text);
		} else if(result.result == "repeat"){
			$('#dialog').html("현재 리뷰후보 회원입니다.<br />현재리뷰를 후보로 등록하시려면 이회원의 선정된 리뷰후보를선정취소를 하세요.");			
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰후보" });
		} else {
			if(result.type == "insert") msg = "후보선정이 실패하였습니다.";
			else msg = "후보선정 취소가  실패하였습니다.";
			$('#dialog').html(msg);			
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰후보" });
		}
	},
	upKeyword: function() {
		combobox.upOption('seq');
		combobox.resultOption('seq','kno');
	},
	downKeyword: function() {
		combobox.downOption('seq');
		combobox.resultOption('seq','kno');
	},	
	removeKeyword: function() {		
		combobox.deleteOption('seq', combobox.getIndex('seq'));
		combobox.resultOption('seq','kno');
	},	
	confirmAppKeyword: function() {
		var html = "";
		html += "현재 순서대로 키워드를 적용하시겠습니까?";
		$('#dialog').html(html);
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "키워드 적용",		
			buttons: { "적용": function(e) { mngreview.appKeyword(); }, "닫기": function() { $(this).dialog("close");} }
		});
	},	
	appKeyword: function() {
		var kno = $('#kno').val();
		var length = $('#seq option').length;
		if(length < 1) {
			$('#dialog').html("현재 노출 키워드가 없습니다. 적용할 수 없습니다.");
			$('#dialog').dialog({ 
				autoOpen: true, width: "300", height:"150", title: "키워드 적용",		
				buttons: { "닫기": function() { $(this).dialog("close");} }
			});		
			return false;
		}
		var url = "/manager/review.keyword.app.proc";
		var data = "&kno=" + kno;
		$.ajax({ type: "POST", url: url, data: data, success: this.appKeywordRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},	
	appKeywordRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#dialog').html("키워드가 적용 되었습니다.");
		} else {
			$('#dialog').html("처리가 실패하였습니다.");
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "키워드 입력",		
			buttons: { "닫기": function() { $(this).dialog("close");} }
		});		
	},
	registerKeyword: function() {
		var keyword = $('#keyword').val();
		if(keyword == "") {
			$('#dialog').html("키워드를 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "키워드 입력" });
			return false;
		}
		var url = "/manager/review.keyword.register.proc";
		var data = "&keyword=" + keyword;
		$.ajax({ type: "POST", url: url, data: data, success: this.registerKeywordRequest });
	}, 
	registerKeywordRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#dialog').html("등록 되었습니다.");
		} else {
			$('#dialog').html("처리가 실패하였습니다.");
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "키워드 입력",		
			buttons: { "닫기": function() { common.redirect('/manager/review.keyword.link'); } }
		});		
	},
	confirmDeleteKeyword: function(kno) {
		$('#dialog').html("선택한 키워드를 삭제 하시겠습니까?<br />삭제하면 관련 키워드리뷰 및 키워드노출도 같이 삭제됩니다.");
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "키워드 삭제",		
			buttons: { "삭제": function(e) { mngreview.deleteKeyword(kno); }, "닫기": function() { $(this).dialog("close");} }
		});
	}, 
	deleteKeyword: function(kno) {
		if(kno == "") {
			$('#dialog').html("정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "키워드삭제" });
			return false;
		}
		var url = "/manager/review.keyword.delete.proc";
		var data = "&kno=" + kno;
		$.ajax({ type: "POST", url: url, data: data, success: this.deleteKeywordRequest });
	}, 
	deleteKeywordRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#dialog').html("키워드가 삭제되었습니다.");
			$('#dialog').dialog({ 
				autoOpen: true, width: "300", height:"150", title: "키워드 삭제",		
				buttons: { "확인": function(e) { common.reload(); } }
			});
		} else {
			$('#dialog').html("키워드 삭제가 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "키워드삭제" });
		}	
	},
	initKeywordLink: function() {
		this._kno = 0;
		this._rno = 0;
		$('#reviewList tr:gt(0)').remove();
		$('#rno-title').html("선택한 리뷰없음");
	},
	getKeywordLinkSimple: function(kno) {
		var url = "/manager/review.keyword.link.proc";
		var data = "&kno=" + kno;
		$.ajax({ type: "POST", url: url, data: data, success: this.getKeywordLinkSimpleRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},
	getKeywordLinkSimpleRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		mngreview.initKeywordLink();
		mngreview._kno = result.kno;
		if(result.result == "success") {			
			$('#keyword-title').html(result.keyword);
			var table = $('#reviewList');
			var content = "";
			var item = result.list;
			for(var i=0; i<item.length; i++)
			{
				content += "<tr align='center'>";
				content += "	<td>"+item[i].rno+"</td>";				
				content += "	<td>";	
				content += "		<img src='"+item[i].image+"' width='60' height='60' class='btn' onClick='mngreview.setKeywordLinkRno("+item[i].rno+");' />";		
				content += "	</td>";
				content += "	<td>";		
				content += "		<a href='javascript:common.socialbar(\""+item[i].rno+"\", \"t\")'>"+item[i].title+"</a>";
				content += "	</td>";
				content += "	<td>"+item[i].regdate+"</td>";
				content += "</tr>";
			}
			table.append(content);			
		} else {
			$('#keyword-title').html(result.keyword);
			//$('#dialog').html("키워드 관련리뷰가 없습니다.");
			//$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "키워드 관련리뷰 정보" });
		}
	}, 
	getKeywordLink: function(kno) {
		var url = "/manager/review.keyword.link.proc";
		var data = "&kno=" + kno;
		$.ajax({ type: "POST", url: url, data: data, success: this.getKeywordLinkRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},
	getKeywordLinkRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		mngreview.initKeywordLink();
		mngreview._kno = result.kno;
		if(result.result == "success") {			
			$('#keyword-title').html(result.keyword);
			var table = $('#reviewList');
			var content = "";
			var item = result.list;
			for(var i=0; i<item.length; i++)
			{
				content += "<tr align='center'>";
				content += "	<td>"+item[i].rno+"</td>";				
				content += "	<td>";	
				content += "		<img src='"+item[i].image+"' width='60' height='60' class='btn' onClick='mngreview.setKeywordLinkRno("+item[i].rno+");' />";		
				content += "	</td>";
				content += "	<td>";		
				content += "		<a href='javascript:common.socialbar(\""+item[i].rno+"\", \"t\")'>"+item[i].title+"</a>";
				content += "	</td>";
				content += "	<td>"+item[i].regdate+"</td>";
				content += "	<td>";
				content += "		<input type='button' value='삭제' onClick='mngreview.confirmDeleteKeywordLink("+item[i].rno+");' />";
				content += " 	</td>";
				content += "</tr>";
			}
			table.append(content);			
		} else {
			$('#keyword-title').html(result.keyword);
			//$('#dialog').html("키워드 관련리뷰가 없습니다.");
			//$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "키워드 관련리뷰 정보" });
		}
	}, 	
	initSearchKeywordLink: function() {
		$('#reviewList2 tr:gt(0)').remove();
	},
	searchKeywordLink: function() {
		var title = $('#title').val();
		var url = "/manager/review.keyword.link.search.proc";
		var data = "&title=" + title;
		$.ajax({ type: "POST", url: url, data: data, success: this.searchKeywordLinkRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},	
	searchKeywordLinkRequest: function(data) {
		$('#dialog-modal').dialog("close");
		mngreview.initSearchKeywordLink();
		var result = $.parseJSON(data);		
		if(result.result == "success") {
			var table = $('#reviewList2');
			var content = "";
			var item = result.list;
			for(var i=0; i<item.length; i++)
			{
				content += "<tr align='center'>";
				content += "	<td>"+item[i].rno+"</td>";
				content += "	<td>";
				content += "		<a href='javascript:common.socialbar(\""+item[i].rno+"\", \"t\")'>"+item[i].title+"</a>";
				content += "	</td>";
				content += "	<td>"+item[i].regdate+"</td>";
				content += "	<td><input type='button' value='등록' onClick='mngreview.registerKeywordLink(\""+item[i].rno+"\");' /></td>";
				content += "</tr>";
			}
			table.append(content);
		} else {
			$('#dialog').html("검색된 리뷰가 없습니다.");	
			$('#dialog').dialog({ 
				autoOpen: true, width: "300", height:"150", title: "리뷰검색",		
				buttons: { "닫기": function() { $(this).dialog("close"); } }
			});	
		}
	},
	registerKeywordLink: function(rno) {		
		if(this._kno == 0) {
			$('#dialog').html("키워드 선택 후 등록하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "키워드 리뷰등록" });
			return false;
		}
		if(rno == "") {
			$('#dialog').html("리뷰일련번호가 없습니다. 다시 검색하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "키워드 리뷰등록" });
			return false;
		}
		var url = "/manager/review.keyword.link.register.proc";
		var data = "&kno=" + this._kno + "&rno="+rno;
		$.ajax({ type: "POST", url: url, data: data, success: this.registerKeywordLinkRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},
	registerKeywordLinkRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);		
		if(result.result == "success") {
			var table = $('#reviewList');
			var content = "";
			var item = result.review;			
			content += "<tr align='center'>";
			content += "	<td>"+item.rno+"</td>";
			content += "	<td>";
			content += "		<img src='/images/common/noimage.gif' width='60' height='60' class='btn' onClick='mngreview.setKeywordLinkRno("+item.rno+");' />";
			content += "	</td>";
			content += "	<td>";
			content += "		<a href='javascript:common.socialbar(\""+item.rno+"\", \"t\")'>"+item.title+"</a>";
			content += "	</td>";
			content += "	<td>"+item.regdate+"</td>";
			content += "	<td>";
			content += "		<input type='button' value='삭제' onClick='mngreview.confirmDeleteKeywordLink("+item.rno+");' />";
			content += " 	</td>";
			content += "</tr>";
			//table.append(content);
			mngreview.getKeywordLink(result.kno);
			$('#dialog').html("등록되었습니다.");
		} else if(result.result == "not") {
			$('#dialog').html("리뷰정보가 없습니다.");			
		} else if(result.result == "repeat") {
			$('#dialog').html("현재 키워드에 이미 등록된 리뷰입니다.");
		} else {
			$('#dialog').html("등록이 실패하였습니다.");	
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "키워드 리뷰등록",		
			buttons: { "닫기": function() { $(this).dialog("close"); } }
		});	
	}, 
	confirmDeleteKeywordLink: function(rno) {
		$('#dialog').html("선택한 키워드리뷰를 삭제 하시겠습니까?");
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "키워드리뷰 삭제",		
			buttons: { "삭제": function(e) { mngreview.deleteKeywordLink(rno); }, "닫기": function() { $(this).dialog("close");} }
		});
	}, 
	deleteKeywordLink: function(rno) {
		if(this._kno == 0) {
			$('#dialog').html("키워드 선택 후 삭제하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "키워드 리뷰삭제" });
			return false;
		}
		var url = "/manager/review.keyword.link.delete.proc";
		var data = "&kno=" + this._kno + "&rno=" + rno;
		$.ajax({ type: "POST", url: url, data: data, success: this.deleteKeywordLinkRequest });
	},
	deleteKeywordLinkRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			mngreview.getKeywordLink(result.kno);
			$('#dialog').html("삭제되었습니다.");
		} else {
			$('#dialog').html("삭제가 실패하였습니다.");	
		}
		$('#dialog').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "키워드리뷰 삭제",		
			buttons: { "닫기": function() { 	$('#dialog-modal').dialog("close"); $(this).dialog("close"); } }
		});
	},
	setKeywordLinkRno: function(rno) {
		this._rno = rno;
		$('#rno').val(rno);
		$('#rno-title').html(rno);
	},
	checkKeywordImage: function(filename) {
		if(!/(\.jpg)$/i.test(filename)) {
			return false;
		}
		return true;
	}		
};