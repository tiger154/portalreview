<!--
$(document).ready( function() {
	$('#keywordBox1').bind({ 'click' : function() { index.showKeywordReview(1); } });
	$('#keywordBox2').bind({ 'click' : function() { index.showKeywordReview(2); } });	
	$('#keywordBox3').bind({ 'click' : function() { index.showKeywordReview(3); } });
	$('#keywordBox4').bind({ 'click' : function() { index.showKeywordReview(4); } });
	$('#keywordBox5').bind({ 'click' : function() { index.showKeywordReview(5); } });
	$('#keywordBox1').css("border-left", "#999 solid 1px");
	index.showKeywordReview(1);
	for(var i=1; i<=5; i++) {
		if(i != 1) $('#keywordReview'+i).css("display", "none");
	}
	$('#noticeCate1').bind({ 'click' : function() { index.showNoticeReview(1); } });
	$('#noticeCate2').bind({ 'click' : function() { index.showNoticeReview(2); } });	
	$('#noticeCate3').bind({ 'click' : function() { index.showNoticeReview(3); } });
	$('#noticeCate4').bind({ 'click' : function() { index.showNoticeReview(4); } });
	$('#noticeCate5').bind({ 'click' : function() { index.showNoticeReview(5); } });
	$('#noticeCate6').bind({ 'click' : function() { index.showNoticeReview(6); } });
	$('#noticeCate7').bind({ 'click' : function() { index.showNoticeReview(7); } });
	$('#noticeCate8').bind({ 'click' : function() { index.showNoticeReview(8); } });
	$('#noticeCate9').bind({ 'click' : function() { index.showNoticeReview(9); } });
	$('#noticeReviewMoreBtn').bind('click', function() { common.redirect("/review"); });
	for(var i=2; i<=9; i++) {
		$('#noticeReview'+i).css("display", "none");
	}
	$('#bestReviewMoreBtn').bind('click', function() { common.redirect("/review/best"); });
	$('#refreshReviewCountBtn').bind({ 'click' : function() { index.updateRealTimeCount(); } });
	$('#realtimeTalk').css("display", "none");	
	$('#realtimeReviewBtn').bind('click', function() {
		$('#realtimeReviewBtn').attr("src", IMAGES+"/main/title_reviewtime_on.gif");
		$('#realtimeTalkBtn').attr("src", IMAGES+"/main/title_talktime_off.gif");
		$('#realtimeReview').show();
		$('#realtimeTalk').hide(); 
	});
	$('#realtimeTalkBtn').bind('click', function() {
		$('#realtimeReviewBtn').attr("src", IMAGES+"/main/title_reviewtime_off.gif");
		$('#realtimeTalkBtn').attr("src", IMAGES+"/main/title_talktime_on.gif");
		$('#realtimeReview').hide();
		$('#realtimeTalk').show(); 
	});		
	$('#realtimeCate1').bind({ 'click' : function() { index.showRealtimeReview(1); } });
	$('#realtimeCate2').bind({ 'click' : function() { index.showRealtimeReview(2); } });	
	$('#realtimeCate3').bind({ 'click' : function() { index.showRealtimeReview(3); } });
	$('#realtimeCate4').bind({ 'click' : function() { index.showRealtimeReview(4); } });
	$('#realtimeCate5').bind({ 'click' : function() { index.showRealtimeReview(5); } });
	$('#realtimeCate6').bind({ 'click' : function() { index.showRealtimeReview(6); } });
	$('#realtimeCate7').bind({ 'click' : function() { index.showRealtimeReview(7); } });
	$('#realtimeCate8').bind({ 'click' : function() { index.showRealtimeReview(8); } });
	$('#realtimeCate9').bind({ 'click' : function() { index.showRealtimeReview(9); } });
	for(var i=2; i<=9; i++) {
		$('#realtimeReview'+i).css("display", "none");
	}
	$('#chartRecomList2').hide();
	$('#chartRecomTab1').bind('click', function() {
		$('#chartRecomTab1').attr("src", IMAGES+"/include/side/tab_manyhiton.gif");
		$('#chartRecomTab2').attr("src", IMAGES+"/include/side/tab_newhitoff.gif");
		$('#chartRecomList1').show();
		$('#chartRecomList2').hide();
	});
	$('#chartRecomTab2').bind('click', function() {
		$('#chartRecomTab1').attr("src", IMAGES+"/include/side/tab_manyhitoff.gif");
		$('#chartRecomTab2').attr("src", IMAGES+"/include/side/tab_newhiton.gif");
		$('#chartRecomList1').hide();
		$('#chartRecomList2').show(); 
	});
});

var index = {
	_keywordSize : 5, 
	_noticeSize : 9, 
	_realtimeSize : 9, 	
	showKeywordReview: function(num) {
		for(var i=1; i<=this._keywordSize; i++) {
			if(num == i) {
				$('#keywordReview'+i).show();
				$('#keywordBox'+i).removeClass();
				$('#keywordBox'+i).addClass("m_keyword_line_on btn");					
				$('#keywordText'+i).removeClass();
				$('#keywordText'+i).addClass("white_text");
			} else {
				$('#keywordReview'+i).hide();
				$('#keywordBox'+i).removeClass();
				$('#keywordBox'+i).addClass("m_keyword_line_off btn");
				$('#keywordText'+i).removeClass();
				$('#keywordText'+i).addClass("gray_d_text");
			} 
		}
	},
	showNoticeReview: function(num) {
		for(var i=1; i<=this._noticeSize; i++) {
			if(num == i) {
				$('#noticeReview'+i).show();
				$('#noticeCate'+i).attr('src', IMAGES+'/review/tab_review_on'+i+'.gif');
			} else {
				$('#noticeReview'+i).hide();
				$('#noticeCate'+i).attr('src', IMAGES+'/review/tab_review_off'+i+'.gif');
			} 
		}
	},
	showRealtimeReview: function(num) {
		for(var i=1; i<=this._realtimeSize; i++) {
			if(num == i) {
				$('#realtimeReview'+i).show();
				$('#realtimeCate'+i).attr('src', IMAGES+'/review/tab_review_on'+i+'.gif');
			} else {
				$('#realtimeReview'+i).hide();
				$('#realtimeCate'+i).attr('src', IMAGES+'/review/tab_review_off'+i+'.gif');
			} 
		}
	},
	updateRealTimeCount: function() {
		var url = "/index/realtime.review.count.proc";
		var data = "";
		$.ajax({ type: "POST", url: url, data: data, success: this.updateRealTimeCountRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},
	updateRealTimeCountRequest: function(data) {		
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			$('#reviewCount').html(result.count);
		} else {
			$('#dialog').html("추천회원 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "추천회원 보기" });
		}
	}
};
-->