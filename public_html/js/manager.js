$(document).ready( function() {
	$('#cate1').bind('change', function () { category.change1('cate1','cate2','cate3','cate4'); });
	$('#cate2').bind('change', function () { category.change2('cate1','cate2','cate3','cate4'); });
	$('#cate3').bind('change', function () { category.change3('cate1','cate2','cate3','cate4'); });
	$('#areaBcodeCBox1').bind('change', function () {
		var bcode = $("#areaBcodeCBox1 option:selected").val();
		zipcode.searchMcode(bcode, "areaMcodeCBox1", "areaScodeCBox1");
	});
	$('#areaMcodeCBox1').bind('change', function () {
		var bcode = $("#areaBcodeCBox1 option:selected").val();
		var mcode = $("#areaMcodeCBox1 option:selected").val();
		zipcode.searchScode(bcode, mcode, "areaScodeCBox1");
	});
	$('#naverMapBtn').bind('click', function () {
		$('#dialog').html("<iframe id='map' src='http://map.naver.com' width='1400' height='680'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "1024", height:"650", title: "약도찾아보기"});
	});
	$('#daumMapBtn').bind('click', function () {
		$('#dialog').html("<iframe id='map' src='http://map.daum.net' width='1400' height='680'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "1024", height:"650", title: "약도찾아보기"});
	});
	$('#catemodify').bind('click', function () {
		var frno = $('#frno').val();
		$('#dialog').html("<iframe id='map' src='/manager/frontier.modify.cate/1/10/15/"+frno+"/CA' width='400' height='180' frameborder='0'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "430", height:"270", title: "카테고리수정"});
	});
	$('#addrmodify').bind('click', function () {
		var frno = $('#frno').val();
		$('#dialog').html("<iframe id='map' src='/manager/frontier.modify.addr/1/10/15/"+frno+"/CA' width='400' height='180' frameborder='0'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "430", height:"270", title: "주소수정"});
	});
	$('#optionmodify').bind('click', function () {
		var frno = $('#frno').val();
		$('#dialog').html("<iframe id='map' src='/manager/frontier.modify.option/1/10/15/"+frno+"/CA' width='400' height='180' frameborder='0'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "430", height:"270", title: "옵션수정"});
	});
	$('#telrmodify').bind('click', function () {
		var frno = $('#frno').val();
		$('#dialog').html("<iframe id='map' src='/manager/frontier.modify.tel/1/10/15/"+frno+"/CA' width='400' height='180' frameborder='0'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "430", height:"270", title: "전화번호수정"});
	});
	$('#jdatemodify').bind('click', function () {
		var frno = $('#frno').val();
		$('#dialog').html("<iframe id='map' src='/manager/frontier.modify.jdate/1/10/15/"+frno+"/JD' width='560' height='180' frameborder='0'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "560", height:"270", title: "모집기간수정"});
	});
	$('#rdatemodify').bind('click', function () {
		var frno = $('#frno').val();
		$('#dialog').html("<iframe id='map' src='/manager/frontier.modify.rdate/1/10/15/"+frno+"/JD' width='560' height='180' frameborder='0'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "560", height:"270", title: "리뷰등록기간수정"});
	});
	$('#ndatemodify').bind('click', function () {
		var frno = $('#frno').val();
		$('#dialog').html("<iframe id='map' src='/manager/frontier.modify.ndate/1/10/15/"+frno+"/JD' width='560' height='180' frameborder='0'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "560", height:"270", title: "발표일수정"});
	});
	$('#bestdatemodify').bind('click', function () {
		var frno = $('#frno').val();
		$('#dialog').html("<iframe id='map' src='/manager/frontier.modify.bestdate/1/10/15/"+frno+"/BD' width='560' height='180' frameborder='0'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "560", height:"270", title: "발표일수정"});
	});

	$('#homepageBtn').bind('click', function () {
		$('#dialog').html("<iframe id='map' src='http://www.naver.com' width='1400' height='680'></iframe>");
		$('#dialog').dialog({ autoOpen: true, width: "1024", height:"650", title: "홈페이지찾기"});
	});
	$('#registCheck').bind('click', function() { frontierRegist(); });
	$('#search').bind('click', function() { frontierListsearch(); });
	$('#search2').bind('click', function() { frontierListsearch2(); });
	$('#entrysearch').bind('click', function() { frontierEntryList(1); });
	$('#entrysearch2').bind('click', function() { frontierEntryList(2); });
	$('#frontierdel').bind('click', function() { frontierdel(); });
	$('#cashpay').bind('click', function() { frontiercashpay(); });
	$('#paycash').bind('click', function() { paycash(); });
	$('#modifyCheck_cate').bind('click', function() { modifyCheck_cate(); });
	$('#modifyCheck_addr').bind('click', function() { modifyCheck_addr(); });
	$('#modifyCheck_tel').bind('click', function() { modifyCheck_tel(); });
	$('#modifyCheck_option').bind('click', function() { modifyCheck_option(); });
	$('#modifyCheck_type').bind('click', function() { modifyCheck_type(); });
	$('#modifyCheck_ctype').bind('click', function() { modifyCheck_ctype(); });
	$('#modifyCheck_style').bind('click', function() { modifyCheck_style(); });
	$('#modifyCheck_subject').bind('click', function() { modifyCheck_subject(); });
	$('#modifyCheck_product').bind('click', function() { modifyCheck_product(); });
	$('#modifyCheck_map').bind('click', function() { modifyCheck_map(); });
	$('#modifyCheck_site').bind('click', function() { modifyCheck_site(); });
	$('#modifyCheck_cash').bind('click', function() { modifyCheck_cash(); });
	$('#modifyCheck_message').bind('click', function() { modifyCheck_message(); });
	$('#modifyCheck_prise').bind('click', function() { modifyCheck_prise(); });
	$('#modifyCheck_mission').bind('click', function() { modifyCheck_mission(); });
	$('#modifyCheck_keyword').bind('click', function() { modifyCheck_keyword(); });
	$('#modifyCheck_tagword').bind('click', function() { modifyCheck_tagword(); });
	$('#modifyCheck_tip').bind('click', function() { modifyCheck_tip(); });
	$('#modifyCheck_topimage').bind('click', function() { modifyCheck_topimage(); });
	$('#modifyCheck_listimage').bind('click', function() { modifyCheck_listimage(); });
	$('#modifyCheck_bannerimage').bind('click', function() { modifyCheck_bannerimage(); });
	$('#modifyCheck_relfile').bind('click', function() { modifyCheck_relfile(); });

	$('#modifyCheck_bannercode').bind('click', function() { modifyCheck_bannercode(); });
	$('#modifyCheck_price').bind('click', function() { modifyCheck_price(); });
	$('#modifyCheck_jdate').bind('click', function() { modifyCheck_jdate(); });
	$('#modifyCheck_ndate').bind('click', function() { modifyCheck_ndate(); });
	$('#modifyCheck_bestdate').bind('click', function() { modifyCheck_bestdate(); });

	$('#modifyCheck_people').bind('click', function() { modifyCheck_people(); });
	$('#modifyCheck_bestreviewer').bind('click', function() { modifyCheck_bestreviewer(); });

	$('#modifyCheck_rdate').bind('click', function() { modifyCheck_rdate(); });
	$('#mtype1').bind('click', function() { mailcheck(1); });
	$('#mtype2').bind('click', function() { mailcheck(2); });
	$('#mtype3').bind('click', function() { mailcheck(3); }); 
	$('#sending1').bind('click', function() { reservetime(1); });	
	$('#sending2').bind('click', function() { reservetime(2); });
	$('#sendmail').bind('click', function() { mailRegist(); });
	$('#registCheckbanner').bind('click', function() { frontierRegistbanner(); });
	$('#frontier_reviewdel').bind('click', function() { frontier_reviewdel(); });
	$('#frontier_reviewmodify').bind('click', function() { frontier_reviewmodify(); });
	$('#bannersearch').bind('click', function() { bannerListsearch(); });
	$('#afileregist').bind('click', function() { Afileregist(); });
	$('#afilCheck').bind('click', function() { AfileRegist(); });
	$('#afiledel').bind('click', function() { AfileDel(); });
});

var manager = {
	user: function(userno) {
		var width = 800;
		var height = 750;
		var left = ((screen.width - 50)/2) - (width/2);
		var top = ((screen.height - 50)/2) - (height/2);
		common.popup('popupUserInfo','/manager/user.info/'+userno, width, height, top, left, 1, 0, 0);
	}, 
	viewReview: function(url) {
		common.popup('popupReview',url);
	}
};

function mailcheck(num) {
	if(num == 1) {
		$('#typeview').show();
		$('#typeview2').hide();
		$('#typeview3').hide();
	}
	if(num == 2) {
		$('#typeview').hide();
		$('#typeview2').show();
		$('#typeview3').hide();
	}
	if(num == 3) {
		$('#typeview').hide();
		$('#typeview2').hide();
		$('#typeview3').show();
	}
}

function reservetime(num) {
	if(num == 1) {
		$('#reserved').hide();
	}
	if(num == 2) {
		$('#reserved').show();
	}
}

function adminCheck(){
	if($('#adminid').val() == "") {
		$('#dialog').html("아이디를 입력하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "관리자 계정 확인"});
		return false;
	}	
	if($('#password').val() == "") {
		$('#dialog').html("비밀번호를 입력하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "관리자 비밀번호 확인"});
		return false;
	}
	$('#Revuform').attr('method', 'post');
	$('#Revuform').attr('action', '/manager/login.proc');	
	$('#Revuform').submit();
}


function frontierRegist(){	
	if($("input[name='etype']:checked").val() == undefined){
		$('#dialog').html("프론티어 타입을 선택하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("input[name='ctype']:checked").val() == undefined){
		$('#dialog').html("출처를 선택하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#cate1 > option:selected").val() == ""){
		$('#dialog').html("등록할 프론티어의 1차 카테고리를 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#cate2 > option:selected").val() == ""){
		$('#dialog').html("등록할 프론티어의 2차 카테고리를 선택하세요!");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($('#subject').val() == "") {
		$('#dialog').html("프론티어 제목을 입력하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}
	if($("#startyear > option:selected").val() == ""){
		$('#dialog').html("등록할 프론티어의 모집 시작 년도를 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#startmonth > option:selected").val() == ""){
		$('#dialog').html("등록할 프론티어의 모집 시작 월을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#startday > option:selected").val() == ""){
		$('#dialog').html("등록할 프론티어의 모집 시작 일을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#starttime > option:selected").val() == ""){
		$('#dialog').html("등록할 프론티어의 모집 시작 시간을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#endyear > option:selected").val() == ""){
		$('#dialog').html("등록할 프론티어의 모집 종료 년도를 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#endmonth > option:selected").val() == ""){
		$('#dialog').html("등록할 프론티어의 모집 종료 월을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#endday > option:selected").val() == ""){
		$('#dialog').html("등록할 프론티어의 모집 종료 일을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#endtime > option:selected").val() == ""){
		$('#dialog').html("등록할 프론티어의 모집 종료 시간을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($('#mcount').val() == "") {
		$('#dialog').html("프론티어 모집인원을 입력하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}
	if($("#jstartyear > option:selected").val() == ""){
		$('#dialog').html("체험단 발표년도를 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#jstartmonth > option:selected").val() == ""){
		$('#dialog').html("체험단 발표월을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#jstartday > option:selected").val() == ""){
		$('#dialog').html("체험단 발표일을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#rstartyear > option:selected").val() == ""){
		$('#dialog').html("리뷰작성 기간 시작년도를 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#rstartmonth > option:selected").val() == ""){
		$('#dialog').html("리뷰작성 기간 시작월을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#rstartday > option:selected").val() == ""){
		$('#dialog').html("리뷰작성 기간 시작일을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#rendyear > option:selected").val() == ""){
		$('#dialog').html("리뷰작성 기간 종료년도를 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($("#rendmonth > option:selected").val() == ""){
		$('#dialog').html("리뷰작성 기간 종료월을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}	
	if($("#rendday > option:selected").val() == ""){
		$('#dialog').html("리뷰작성 기간 종료일을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}
	if($('#rproduct').val() == "") {
		$('#dialog').html("프론티어 체험상품을 입력하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}	
	if($('#editorContent2').val() == "") {
		$('#dialog').html("프론티어 리뷰미션을 입력하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}	
	if($('#file1').val() == "") {
		$('#dialog').html("상단이미지를 등록 하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 등록사항 확인"});
		return false;
	}	
	if($('#file2').val() == "") {
		$('#dialog').html("썸네일이미지를 등록 하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 등록사항 확인"});
		return false;
	}	
	if($('#file3').val() == "") {
		$('#dialog').html("배너이미지를 등록 하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 등록사항 확인"});
		return false;
	}	
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.regist.proc');	
	$('#RevUform').submit();
}

function modifyCheck_cate(){
	var flag;
	flag = "CA";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag);	
	$('#RevUform').submit();
}

function modifyCheck_addr(){
	var flag;
	flag = "AD";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag);	
	$('#RevUform').submit();
}

function modifyCheck_tel(){
	var flag;
	flag = "TL";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag);	
	$('#RevUform').submit();
}

function modifyCheck_option(){
	var flag;
	flag = "OP";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag);	
	$('#RevUform').submit();
}

function modifyCheck_jdate(){
	var flag;
	flag = "JD";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag);	
	$('#RevUform').submit();
}

function modifyCheck_rdate(){
	var flag;
	flag = "RD";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag);	
	$('#RevUform').submit();
}

function modifyCheck_ndate(){
	var flag;
	flag = "ND";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag);	
	$('#RevUform').submit();
}


function modifyCheck_bestdate(){
	var flag;
	flag = "BD";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag);	
	$('#RevUform').submit();
}


function modifyCheck_type(){
	var flag;
	var frno = $('#frno').val();
	flag = "TY";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_ctype(){
	var flag;
	var frno = $('#frno').val();
	flag = "CT";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_style(){
	var flag;
	var frno = $('#frno').val();
	flag = "ST";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_subject(){
	var flag;
	var frno = $('#frno').val();
	flag = "SJ";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}


function modifyCheck_product(){
	var flag;
	var frno = $('#frno').val();
	flag = "PD";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_map(){
	var flag;
	var frno = $('#frno').val();
	flag = "MP";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_site(){
	var flag;
	var frno = $('#frno').val();
	flag = "WE";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_cash(){
	var flag;
	var frno = $('#frno').val();
	flag = "CP";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_message(){
	var flag;
	var frno = $('#frno').val();
	flag = "ME";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_prise(){
	var flag;
	var frno = $('#frno').val();
	flag = "MS";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_mission(){
	var flag;
	var frno = $('#frno').val();
	flag = "SS";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_keyword(){
	var flag;
	var frno = $('#frno').val();
	flag = "KW";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_tagword(){
	var flag;
	var frno = $('#frno').val();
	flag = "TW";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_tip(){
	var flag;
	var frno = $('#frno').val();
	flag = "TP";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_topimage(){
	var flag;
	var frno = $('#frno').val();
	flag = "IM1";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}


function modifyCheck_listimage(){
	var flag;
	var frno = $('#frno').val();
	flag = "IM2";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_bannerimage(){
	var flag;
	var frno = $('#frno').val();
	flag = "IM3";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_relfile(){
	var flag;
	var frno = $('#frno').val();
	flag = "IM4";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}


function modifyCheck_bannercode(){
	var flag;
	var frno = $('#frno').val();
	flag = "BN";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}



function modifyCheck_price(){
	var flag;
	var frno = $('#frno').val();
	flag = "PE";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function modifyCheck_people(){
	var flag;
	var frno = $('#frno').val();
	flag = "PL";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}


function modifyCheck_bestreviewer(){
	var flag;
	var frno = $('#frno').val();
	flag = "BC";
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.modify1.proc/'+flag+"/"+frno);	
	$('#RevUform').submit();
}

function frontierListsearch(){
	var val;
	var cate1 = $('#cate1').val();
	var cate2 = $('#cate2').val();
	var cate3 = $('#cate3').val();
	var cate4 = $('#cate4').val();
	var stat = $('#stat').val();
	var frname = $('#frname').val();
	common.redirect("/manager/frontier.list/1/10/15/"+cate1+"/"+cate2+"/"+cate3+"/"+cate4+"/"+stat+"/"+frname);
}

function frontierListsearch2(){
	var val;
	var cate1 = $('#cate1').val();
	var cate2 = $('#cate2').val();
	var cate3 = $('#cate3').val();
	var cate4 = $('#cate4').val();
	var stat = $('#stat').val();
	var frname = $('#frname').val();
	common.redirect("/manager/frontier.cashpay/1/10/15/"+cate1+"/"+cate2+"/"+cate3+"/"+cate4+"/"+stat+"/"+frname);
}

function Afileregist(){
	var val;
	common.redirect("/manager/cp.file.regist/1/10/15/");
}

function bannerListsearch(){
	var val;
	var stat = $('#stat').val();
	var campaign = $('#campaign').val();
	common.redirect("/manager/list.banner/1/10/15/"+stat+"/"+campaign);
}

/* 응모자 상세보기 팝업 */
function entrypopup(event_no,count)
{
	$('#dialog').html("<iframe id='map' src='/manager/frontier.entrylist/1/10/15/"+event_no+"/"+count+"' width='950' height='750' frameborder='0'></iframe>");
	$('#dialog').dialog({ autoOpen: true, width: "990", height:"850", title: "응모자 리스트"});
}

/* 당첨자 상세보기 팝업 */
function cashpaypopup(event_no,count)
{
	$('#dialog').html("<iframe id='map' src='/manager/frontier.winlist/1/10/15/"+event_no+"/"+count+"' width='950' height='750' frameborder='0'></iframe>");
	$('#dialog').dialog({ autoOpen: true, width: "990", height:"850", title: "당첨자 리스트"});
}

/* 블로그 */
function blogpopup(userno)
{
	$('#dialog').html("<iframe id='map' src='/manager/frontier.entrybloglist/1/10/15/"+userno+"' width='300' height='270' scrollbars=no></iframe>");
	$('#dialog').dialog({ autoOpen: true, width: "350", height:"290", title: "응모자 블로그 리스트"});
}

/* 블로그 */
function blogpopup2(userno)
{
	$('#dialog').html("<iframe id='map' src='/manager/frontier.entrybloglist/1/10/15/"+userno+"' width='300' height='270' scrollbars=no></iframe>");
	$('#dialog').dialog({ autoOpen: true, width: "350", height:"290", title: "당첨자 블로그 리스트"});
}

/* 리뷰 */
function reviewpopup(userno,event_no,entry_count)
{
	$('#dialog').html("<iframe id='map' src='/manager/frontier.winreviewlist/1/10/15/"+userno+"/"+event_no+"/"+entry_count+"' width='570' height='270' scrollbars=no></iframe>");
	$('#dialog').dialog({ autoOpen: true, width: "600", height:"390", title: "당첨자 리뷰정보"});
}

function frontierEntryWin(event_no,count,subject,userno,type,page){
	if(type == 'c'){
		if (confirm ("당첨을 취소 하시겠습니까?")) 
		{		
			common.redirect("/manager/frontier.entrylist/"+page+"/10/15/"+event_no+"/"+count+"/"+subject+"/"+userno+"/"+type);
		}
	}else if(type == "s"){
			common.redirect("/manager/frontier.entrylist/"+page+"/10/15/"+event_no+"/"+count+"/"+subject+"/"+userno+"/"+type);
	}else{
			common.redirect("/manager/frontier.entrylist/"+page+"/10/15/"+event_no+"/"+count+"/"+subject+"/"+userno+"/"+type);
	}
}

function frontierReviewReg(event_no,enurl,userno){
	if (confirm ("본 프론티어의 리뷰로 등록하시겠습니까?")) {		
		var flag; 
		flag = "C";
		page = "1";
		common.redirect("/manager/frontier.winreviewlist/"+page+"/10/15/"+userno+"/"+event_no+"/"+enurl+"/"+userno+"/"+flag);
	}
}

function paycash(event_no,userno){
	var val;	
	var cash = $('#cash'+userno).val();
	if(cash == "") {
		alert ("지급할 캐시를 입력하시기 바랍니다!!!");
	}else{
		if (confirm ("입력하신 캐시를 회원에게 지급하시겠습니까?")) {		
			var flag; 
			flag = "P";
			page = "1";
			common.redirect("/manager/frontier.winlist/"+page+"/10/15/"+event_no+"/"+userno+"/"+flag+"/"+cash);
		}
	}
}

function frontierMaindisplay(frno,flag){
	if(flag == '1'){
		if (confirm ("선택하신 프론티어를 메인롤링 Area에 적용하시겠습니까?")) 
		{		
			common.redirect("/manager/frontier.display/1/10/15/"+frno+"/"+flag);
		}
	}else{
		if (confirm ("선택하신 프론티어를 메인롤링 Area에서 빼시겠습니까?")) 
		{		
			common.redirect("/manager/frontier.display/1/10/15/"+frno+"/"+flag);
		}
	}
}

function frontierEntryList(flag){
	var val;
	var event_no = $('#event_no').val();
	var count = '';
	var subject = $('#subject').val();
	var stat = $('#stat').val();
	var frname = $('#frname').val();
    var type = '';
	var list = 's';
	var userid = '';
	var row = $('#rowNumPerPage').val();
	var winflag = flag;
	if(winflag == '2'){
		if (confirm ("당첨대기인 회원을 당첨확정처리 하시겠습니까?")) 
		{		
			var winflag = 'W';
			common.redirect("/manager/frontier.entrylist/1/10/"+row+"/"+event_no+"/"+count+"/"+frname+"/"+userid+"/"+type+"/"+list+"/"+stat+"/"+winflag);
		}
	}else{
		var winflag = '';	
		common.redirect("/manager/frontier.entrylist/1/10/"+row+"/"+event_no+"/"+count+"/"+frname+"/"+userid+"/"+type+"/"+list+"/"+stat+"/"+winflag);	
	}
}


function frontierdel(){

	var val;
	var frno = $('#frno').val();

	if (confirm ("프론티어를 삭제처리 하시겠습니까?")) {		
		$('#RevUform').attr('method', 'post');
		$('#RevUform').attr('action', '/manager/frontier.frontierdel.proc/'+frno);	
		$('#RevUform').submit();
	}else{
		//mon.redirect("/manager/frontier.entrylist/1/10/"+row+"/"+event_no+"/"+count+"/"+frname+"/"+userid+"/"+type+"/"+list+"/"+stat+"/"+winflag);	
	}
}



function frontiercashpay(){
	var val;
	var event_no = $('#event_no').val();
	var count = '';
	var subject = $('#subject').val();
	var stat = $('#stat').val();
	var cash = $('#cash').val();
    var type = 'P';
	var list = 's';
	var userid = '';
	common.redirect("/manager/frontier.winlist/1/10/15/"+event_no+"/"+count+"/"+cash+"/"+userid+"/"+type+"/"+list+"/"+stat);
}

function mailRegist(){
	var mtype = radio.getValue("mtype");
	var sending = radio.getValue("sending");
	if($('#subject').val() == "") {
		$('#dialog').html("메일 제목을 입력하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "메일 입력사항 확인"});
		return false;
	}
	if($('#sendname').val() == "") {
		$('#dialog').html("발신자 표시명을 입력하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "메일 입력사항 확인"});
		return false;
	}
	if(mtype == "E") {
		if($('#recipient').val() == "") {
			$('#dialog').html("개별 발송시 수신자를 입력하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, title: "메일 입력사항 확인"});
			return false;
		}
	}
	if($('#editor').val() == "") {
		$('#dialog').html("메일 내용을 입력하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "메일 입력사항 확인"});
		return false;
	}
	if(sending  == "R") {
		if($('#reyear').val() == "") {
			$('#dialog').html("예약 발송시 년도를 선택하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, title: "메일 입력사항 확인"});
			return false;
		}
		if($('#remonth').val() == "") {
			$('#dialog').html("예약 발송시 월을 선택하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, title: "메일 입력사항 확인"});
			return false;
		}
		if($('#redate').val() == "") {
			$('#dialog').html("예약 발송 날짜를 선택하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, title: "메일 입력사항 확인"});
			return false;
		}
		if($('#retime').val() == "") {
			$('#dialog').html("예약 발송 시간을 선택하셔야 합니다.");
			$('#dialog').dialog({ autoOpen: true, title: "메일 입력사항 확인"});
			return false;
		}
	}
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/mail.sending.proc');	
	$('#RevUform').submit();
}

function frontierRegistbanner(){
	if($('#subject').val() == "") {
		$('#dialog').html("캠페인명을 입력하시오.");
		$('#dialog').dialog({ autoOpen: true, title: "배너등록 입력사항 확인"});
		return false;
	}
	if($('#spon').val() == "") {
		$('#dialog').html("광고주명을 입력하시오.");
		$('#dialog').dialog({ autoOpen: true, title: "배너등록 입력사항 확인"});
		return false;
	}
	if($('#homepage').val() == "") {
		$('#dialog').html("링크주소를 입력하시오.");
		$('#dialog').dialog({ autoOpen: true, title: "배너등록 입력사항 확인"});
		return false;
	}
	if($('#file1').val() == "") {
		$('#dialog').html("배너 이미지를 등록 하세요.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 등록사항 확인"});
		return false;
	}	
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.registbanner.proc');	
	$('#RevUform').submit();
}

function AfileRegist(){
	if($('#subject').val() == "") {
		$('#dialog').html("관련 제목을 입력하시오");
		$('#dialog').dialog({ autoOpen: true, title: "입력사항 확인"});
		return false;
	}
	if($('#file4').val() == "") {
		$('#dialog').html("관련 파일을 등록하시오");
		$('#dialog').dialog({ autoOpen: true, title: "첨부 확인"});
		return false;
	}	
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/frontier.cpfile.proc');	
	$('#RevUform').submit();
}

function AfileDel(file,no){
	$('#dialog2').html("삭제 하시겠습니까?");
	$('#dialog2').dialog({ 
		autoOpen: true, width: "300", height:"160", title: "파일삭제",		
		buttons: { 
			"삭제": function() { deletefile(file,no); },
			"닫기": function() { $(this).dialog("close");} 
		}
	});
}

function deletefile(file,no) {
	var val; 
	var file = file;
	var no = no;
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/manager/manager.cpfiledel.proc/1/10/15/'+file+"/"+no);	
	$('#RevUform').submit();
}

function bannerdel(no,type){
	if(type == 'D'){
		if (confirm ("배너를 삭제하시렵니까?")) 
		{		
			common.redirect("/manager/list.banner//10/15////"+no+"/"+type);
		}
	}else{
			common.redirect("/manager/list.banner//10/15////"+no+"/"+type);
	}
}


function frontier_reviewdel(){

	var rno = $('#rno').val();
	var frno = $('#frno').val();

	var type;
	if(rno != ""){
		type = "D";
	}


	if(type == 'D'){
		if (confirm ("입력하신 리뷰를 프론티어 리뷰리스트에서만 삭제됩니다. 삭제하시겠습니까?")) 
		{		
			common.redirect("/manager/frontier.reviewdel/"+type+"/"+rno+"/"+frno);
		}
	}else{
			common.redirect("/manager/frontier.reviewdel");
	}
}

function frontier_reviewmodify(){

	var rno = $('#rno').val();
	var frno = $('#frno').val();
	var ofrno = $('#ofrno').val();

	var type;
	if(rno != ""){
		type = "M";
	}


	if(type == 'M'){
		if (confirm ("본 리뷰를 입력한 프론티어의 리뷰로 수정하시겠습니까?")) 
		{		
			common.redirect("/manager/frontier.reviewmodify/"+type+"/"+rno+"/"+frno+"/"+ofrno);
		}
	}else{
			common.redirect("/manager/frontier.reviewmodify");
	}
}



function partnermemo(no)
{
	$('#dialog').html("<iframe id='map' src='/manager/frontier.partnermemo/1/10/15/"+no+"' width='300' height='270' scrollbars=no></iframe>");
	$('#dialog').dialog({ autoOpen: true, width: "350", height:"290", title: "제휴문의 내용 상세보기"});
}