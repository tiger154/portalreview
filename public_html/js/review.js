<!--
$(document).ready( function() {	
	$('#cate1').bind('change', function() { category.change1('cate1','cate2','cate3','cate4'); });
	$('#cate2').bind('change', function() { category.change2('cate1','cate2','cate3','cate4'); });
	$('#cate3').bind('change', function() { category.change3('cate1','cate2','cate3','cate4'); });
	$('#searchBtn').bind('click', function() { review.search('cate1', 'cate2', 'cate3', 'cate4', '', ''); });	
	$('#pointSearchBtn').bind({
		/*
		'mouseover' : function() { $(this).attr('src', IMAGES+'/common/ico/ico_hitlist_on.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/common/ico/ico_hitlist_off.gif'); },
		*/
		'click' : function() { review.search('cate1', 'cate2', 'cate3', 'cate4', 'point', 'desc'); }
	});
	$('#recentSearchBtn').bind({
		/*
		'mouseover' : function() { $(this).attr('src', IMAGES+'/common/ico/ico_newlist_on.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/common/ico/ico_newlist_on.gif'); },
		*/
		'click' : function() { review.search('cate1', 'cate2', 'cate3', 'cate4', '', ''); }
	});
	$('#rcate1').bind({
		'mouseover' : function() { $(this).attr('src', IMAGES+'/review/tab_review_on1.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/review/tab_review_off1.gif'); },
		'click' : function() { common.redirect('/review/list'); }
	});
	$('#rcate2').bind({
		'mouseover' : function() { $(this).attr('src', IMAGES+'/review/tab_review_on2.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/review/tab_review_off2.gif'); },
		'click' : function() { common.redirect('/review/list/1/11005'); }
	});	
	$('#rcate3').bind({
		'mouseover' : function() { $(this).attr('src', IMAGES+'/review/tab_review_on3.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/review/tab_review_off3.gif'); },
		'click' : function() { common.redirect('/review/list/1/13'); }
	});
	$('#rcate4').bind({
		'mouseover' : function() { $(this).attr('src', IMAGES+'/review/tab_review_on4.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/review/tab_review_off4.gif'); },
		'click' : function() { common.redirect('/review/list/1/12016'); }
	});
	$('#rcate5').bind({
		'mouseover' : function() { $(this).attr('src', IMAGES+'/review/tab_review_on5.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/review/tab_review_off5.gif'); },
		'click' : function() { common.redirect('/review/list/1/11010'); }
	});
	$('#rcate6').bind({
		'mouseover' : function() { $(this).attr('src', IMAGES+'/review/tab_review_on6.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/review/tab_review_off6.gif'); },
		'click' : function() { common.redirect('/review/list/1/12017'); }
	});
	$('#rcate7').bind({
		'mouseover' : function() { $(this).attr('src', IMAGES+'/review/tab_review_on7.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/review/tab_review_off7.gif'); },
		'click' : function() { common.redirect('/review/list/1/10'); }
	});
	$('#rcate8').bind({
		'mouseover' : function() { $(this).attr('src', IMAGES+'/review/tab_review_on8.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/review/tab_review_off8.gif'); },
		'click' : function() { common.redirect('/review/list/1/14008'); }
	});
	$('#rcate9').bind({
		'mouseover' : function() { $(this).attr('src', IMAGES+'/review/tab_review_on9.gif'); },
		'mouseout' : function() { $(this).attr('src', IMAGES+'/review/tab_review_off9.gif'); },
		'click' : function() { common.redirect('/review/frontier'); }
	});
	try { category.set('cate1', 'cate2', 'cate3', 'cate4', code); } catch(err) {}
	$('#popupBestVoteBtn').bind('click', function() { common.openCenterLayer('popupBestVoteLayer', 406, 457, 100); });
	$('#popupBestVoteClose').bind('click', function() { common.closeLayer('popupBestVoteLayer'); });
	$('#popupBestRecomClose').bind('click', function() { common.closeLayer('popupBestRecomLayer'); });		
});

var review = {	
	goReview: function(page, wno) {		
		common.redirect('/review/@'+page+'/'+wno);
	},
	goBest: function(wno) {		
		common.redirect('/review/best/'+wno);
	},
	search: function(cate1, cate2, cate3, cate4, order, desc) {		
		var _cate1 = $("#"+cate1).val();
		var _cate2 = $("#"+cate2).val();
		var _cate3 = $("#"+cate3).val();
		var _cate4 = $("#"+cate4).val();
		var url = '/review/list';
		url += "/1/"+_cate1;
		url += (_cate2 == "") ? "" : _cate2;
		url += (_cate3 == "") ? "" : _cate3;
		url += (_cate4 == "") ? "" : _cate4;
		url += (order == "") ? "" : "/"+order;
		url += (desc == "") ? "" : "/"+desc;
		common.redirect(url);
	},
	recomUser: function(wno, rno) {
		if(wno == null || wno == undefined || wno == "" || rno == null || rno == undefined || rno == "" ) {
            $('#dialog').html("정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "추천리스트" });
			return false;
        }
        var url = "/review/cand.recom.user.proc";
		var data = "&wno=" + wno + "&rno=" + rno;
		$.ajax({ type: "POST", url: url, data: data, success: this.recomUserRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	}, 
	recomUserRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var list = result.list;
		if(result.result == "success") {
			var html = "";
			for(var i=0; i<result.cnt; i++) {
				html += "<div class='pop_bestbloger_list'>";
				html += "	<div class='s_profile_thum fl'>";
				html += "		<img src='"+list[i].userimage+"' width='45px;' height='45px;'/>";
				html += "	</div>";
				html += "	<div class='bestbloger_text1 fl'>";
				html += "		<span class='common11_text'>";
				html += "		<a href='javascript:context.load("+list[i].userno+");'>"+list[i].nickname+"</a>";
				html += "		</span>";
				html += "	</div>"
				html += "	<div class='bestbloger_text2 fl'>";
				html += "		<span class='gray11_l_text'>"+list[i].regdate+"</span>";
				html += "	</div>";
				html += "</div>"; 
				if(i%2 == 0) {
				html += "<div class='fl' style='width:17px; height:45px; padding-bottom:10px;'></div>";
				} else {
				html += "<div class='clear'></div>";	
				}
			}
			$('#bestRecomUser').html(html);
			//openLayer('popupBestRecomLayer', 400, 400, -1, -1, 100);
			$('#recomCnt').html(result.recomCnt);			
			common.openLayer('popupBestRecomLayer', 407, 400, -1, -1, 5);
		} else {
			$('#dialog').html("추천회원 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "추천회원 보기" });
		}
	}
};
