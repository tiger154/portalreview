$(document).ready( function() {
	/*
	$('#cate1').bind('change', function () {
		//alert("a");
		var cate1 = $("#cate1 option:selected").val();
		category.cate2select(cate1, "cate2", "cate3", "cate4");
	});

	$('#cate2').bind('change', function () {
		//alert("a");
		var cate1 = $("#cate1 option:selected").val();
		var cate2 = $("#cate2 option:selected").val();
		category.cate3select(cate1, cate2,  "cate3", "cate4");
	});
	*/
	$('#areaBcodeCBox1').bind('change', function () {
		var bcode = $("#areaBcodeCBox1 option:selected").val();
		zipcode.searchMcode(bcode, "areaMcodeCBox1", "areaScodeCBox1");
	});
	$('#areaMcodeCBox1').bind('change', function () {
		var bcode = $("#areaBcodeCBox1 option:selected").val();
		var mcode = $("#areaMcodeCBox1 option:selected").val();
		zipcode.searchScode(bcode, mcode, "areaScodeCBox1");
	});
	common.setLayer("zipcodelayer");
	$('#zipcodeBtn').bind('click', function() { common.openLayer('zipcodelayer', 400,400,200,200); /*zipcode.setForm('zipcode', 'addr1');*/ });
	//$('#zipcodeBtn').bind('click', function() { zipcode.setForm('zipcode', 'addr1'); });
	$('#addrzip').bind('focus', function() { common.openLayer('zipcodelayer', 400,400,200,200); }); 
	$('#addr1').bind('focus', function() { common.openLayer('zipcodelayer', 400,400,200,200); });
	$('#registCheck').bind('click', function() { frontierRegist(); });
	$('#search').bind('click', function() { frontierListsearch(); });
	$('#allianceCheck').bind('click', function() { allianceRegist(); });
	$('#mtype1').bind('click', function() { replytoggle(talknum); });
	$('#blogList').bind('change', function() { reviewManager.loadRSSURL(); });
	$('#blogLoadBtn').bind('click', function() { reviewManager.loadArticle2(); });
	$( "#tabs" ).tabs({ select: function(event, ui) { showTab(ui.index); }});
	$("#reload").bind('click' , function() { reload(); }); 
});

function reload() {            
	location.reload();               
}

function showTab(num) {
	//alert(num);
	//showTab(common.getCookie('cookieTab'));
	no = parseInt(num);
	if(no == 0){
		common.setCookie('cookieTab','0',1);
		//$( "#tabs" ).tabs({ selected: 0 });
	}else{
		common.setCookie('cookieTab','1',1);
		//$( "#tabs" ).tabs({ selected: 1 });
	}
	//alert(common.getCookie('cookieTab'));
}


function replycheck(num) {
	
	var checknum;
	checknum = num/2;

	//alert(checknum);

	if(checknum < 1) {
		$('#typeview').show();
	}else{
		if(checknum = 1){
			$('#typeview').show();
		}else{
			$('#typeview').hide();
		}
	}

	var num = num++;
}

function replytoggle(talknum) { 


	$("#typeview"+talknum).toggle("fast"); 


} 

function replytoggle2(talknum) { 

	$("#typeview3"+talknum).toggle("fast"); 
	$("#typeview2"+talknum).toggle("fast"); 

} 

function replytoggle3(talknum) { 

	//alert('here');
	$("#typeview5"+talknum).toggle("fast"); 
	$("#typeview4"+talknum).toggle("fast"); 

} 

function frontierRegist(){
	
	if($('#blogcnt').val() < 1) {
		$('#dialog').html("블로그를 등록하셔야 응모가능합니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}

	if($('#name').val() == "") {
		$('#dialog').html("응모자 이름을 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}
	
	if($("input[name='sex']:checked").val() == undefined){
		$('#dialog').html("응모자 성별을 선택하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}

	if($("#birth_year > option:selected").val() == ""){
		$('#dialog').html("응모자의 생일 년도를 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}


	if($("#birth_month > option:selected").val() == ""){
		$('#dialog').html("응모자의 생일 월을 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}

	if($("#birth_day > option:selected").val() == ""){
		$('#dialog').html("응모자의 생일 선택하세요");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}


	if($('#mobile2').val() == "") {
		$('#dialog').html("응모자 휴대폰번호를 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}

	if(validation.isNumber($('#mobile2').val()) == false) {
		$('#mobile2').focus();
		$('#dialog').html("휴대폰번호는 숫자로 입력하셔야합니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "휴대폰번호 확인"});				
		return false;
	}




	if($('#mobile3').val() == "") {
		$('#dialog').html("응모자 휴대폰번호를 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}



	if(validation.isNumber($('#mobile3').val()) == false) {
		$('#mobile3').focus();
		$('#dialog').html("휴대폰번호는 숫자로 입력하셔야합니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "휴대폰번호 확인"});				
		return false;
	}



	if($('#tel2').val() == "") {
		$('#dialog').html("응모자 전화번호를 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}



	if(validation.isNumber($('#tel2').val()) == false) {
		$('#tel2').focus();
		$('#dialog').html("전화번호는 숫자로 입력하셔야합니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "전화번호 확인"});				
		return false;
	}

	if($('#tel3').val() == "") {
		$('#dialog').html("응모자 전화번호를 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}


	if(validation.isNumber($('#tel3').val()) == false) {
		$('#tel3').focus();
		$('#dialog').html("전화번호는 숫자로 입력하셔야합니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "전화번호 확인"});				
		return false;
	}


	if($('#zipcode').val() == "") {
		$('#dialog').html("응모자 우편번호를 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}


	if($('#addr1').val() == "") {
		$('#dialog').html("응모자 주소를 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}


	if($('#addr2').val() == "") {
		$('#dialog').html("응모자 상세주소를 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}


	if($('#option_count').val() > 0){
		if($("#option1 > option:selected").val() == ""){
			$('#dialog').html("본 프론티어는 옵션이 있습니다. 옵션을 선택하세요!");
			$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
			return false;
		}
	}


	if($('#editor').val() == "") {
		$('#dialog').html("응모시 관련 토크는 필수 입력사항 입니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 입력사항 확인"});
		return false;
	}




	if($("input[name='agree']:checked").val() == undefined){
		$('#dialog').html("프론티어 응모 동의를 하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 선택사항 확인"});
		return false;
	}

	/*
	var name = $('#name').val();
	var sex = $("input[name='sex']:checked").val();
	var birth_year = $("#birth_year option:selected").val();
	var birth_month = $("#birth_month option:selected").val();
	var birth_day = $("#birth_day option:selected").val();
	var mobile1 = $("#phone_number option:selected").val();
	var mobile2 = $('#mobile2').val();
	var mobile3 = $('#mobile3').val();
	var tel1 = $("#tel_number option:selected").val();
	var tel2 = $('#tel2').val();
	var tel3 = $('#tel3').val();
	var zipcode = $('#zipcode').val();
	var addr1 = $('#addr1').val();
	var addr2 = $('#addr2').val();
	var editor = $('#editor').val();
	var option = $("#option1 option:selected").val();
	*/

	

	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/frontier/frontier.entry1.proc');	
	$('#RevUform').submit();
	//document.forms['RevUform'].onsubmit();
	//document.forms['RevUform'].submit();

}




function talkreplyRegist(no){

	var val; 
	var talknum = no;
	var reply = $('#reply'+no).val();


	$('#replyno').val(no);




	if($('#user_num').val() == "") {
		$('#dialog').html("로그인 하신후 댓글을 쓰실 수가 있습니다.");
		$('#dialog').dialog({ autoOpen: true, title: "토크-댓글 로그인체크"});
		return false;
	}
	

	if( reply == "") {
		$('#dialog').html("내용을 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "토크-댓글 입력확인"});
		return false;
	}
	
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/frontier/frontier.talkreply.proc');	
	$('#RevUform').submit();

}


/* 프론티어 상세보기상세보기 팝업 */
function entrypopup(frno)
{
	//w=920;
	//h=680;
	//y=((screen.height-h)/2)-190;
	//x=((screen.width-w)/2);
	//window.open("/manager/frontier.entrylist/"+event_no,"응모자상세보기","width="+w+",height="+h+",top="+y+",left="+x+",scrollbars=yes, resizable=1, status=1");	

	//alert(frno);
	$('#dialog').html("<iframe id='map' src='/frontier/entrywinner.layer/1/10/15/"+frno+"' width='510' height='550' frameborder='0' scrolling='no'></iframe>");
	$('#dialog').dialog({ autoOpen: true, width: "560", height:"650"});

}





function talkreplyedit(no){

	var val; 
	//alert("#reply"+no).val();
	//alert(no).val();
	var talknum = no;

	//alert(no);
	//var frname = ('#frname').val();
	var replyedit = $('#replyedit'+no).val();
	//alert(replyedit);
	$('#replyeditno').val(no);

	

	if( replyedit == "") {
		$('#dialog').html("댓글 내용을 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "토크-댓글 입력확인"});
		return false;
	}
	
	
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/frontier/frontier.replyedit.proc');	
	$('#RevUform').submit();
	//document.forms['RevUform'].onsubmit();
	//document.forms['RevUform'].submit();

}


function talkreplydel(no){

	//var val; 

	//var talknum = no;



	$('#dialog2').html("댓글을 삭제 하시겠습니까?");
	$('#dialog2').dialog({ 
		autoOpen: true, width: "300", height:"160", title: "댓글삭제",		
		buttons: { 
			"삭제": function() { deletereply(no); },
			"닫기": function() { $(this).dialog("close");} 
		}
	});


	//$('#delreplyno').val(talknum);
	
	
	
	//$('#RevUform').attr('method', 'post');
	//$('#RevUform').attr('action', '/frontier/frontier.replydel.proc');	
	//$('#RevUform').submit();
	//document.forms['RevUform'].onsubmit();
	//document.forms['RevUform'].submit();

}


function deletereply(no) {


	var val; 

	var talknum = no;


	$('#delreplyno').val(talknum);
	
	
	
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/frontier/frontier.replydel.proc');	
	$('#RevUform').submit();


}



function talkreplydel2(no){

	//var val; 

	//var talknum = no;



	$('#dialog2').html("<font color=red>토크를 삭제하시면 프론티어 응모까지 취소됩니다.</font>응모를 취소하고 토크도 <b>삭제</b> 하시겠습니까?");
	$('#dialog2').dialog({ 
		autoOpen: true, width: "300", height:"160", title: "토크삭제=응모취소",		
		buttons: { 
			"삭제": function() { deletereply2(no); },
			"닫기": function() { $(this).dialog("close");} 
		}
	});


	//$('#delreplyno').val(talknum);
	
	
	
	//$('#RevUform').attr('method', 'post');
	//$('#RevUform').attr('action', '/frontier/frontier.replydel.proc');	
	//$('#RevUform').submit();
	//document.forms['RevUform'].onsubmit();
	//document.forms['RevUform'].submit();

}

function deletereply2(no) {


	var val; 

	var talknum = no;


	$('#delreplyno').val(talknum);
	
	
	
	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/frontier/frontier.entrydel.proc');	
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

	//$('#RevUform').attr('method', 'post');
	//$('#RevUform').attr('action', '/manager/frontier.list');	
	//$('#RevUform').redirect();

}



function allianceRegist(){



	if($('#company').val() == "") {
		$('#dialog').html("회사명을 입력하셔야 합니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 제휴문의 입력사항 확인"});
		return false;
	}


	if($('#rname').val() == "") {
		$('#dialog').html("담당자명을 입력하시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 제휴문의 입력사항 확인"});
		return false;
	}


	if($('#company_tel').val() == "") {
		$('#dialog').html("연락가능한 전화번호를 꼭 입력하셔야 합니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 제휴문의 입력사항 확인"});
		return false;
	}

	if(validation.isNumber($('#company_tel').val()) == false) {
		$('#company_tel').focus();
		$('#dialog').html("전화번호는 숫자로 입력하셔야합니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "전화번호 확인"});				
		return false;
	}

	if($('#company_mail').val() == "") {
		$('#dialog').html("메일주소를 입력하셔야 담당자가 관련 자료를 보내드립니다.");
		$('#dialog').dialog({ autoOpen: true, title: "제휴문의 메일주소 입력사항 확인"});
		return false;
	}

	if($('#company_say').val() == "") {
		$('#dialog').html("제휴내용을 간단하게라도 꼭 적어주시기 바랍니다.");
		$('#dialog').dialog({ autoOpen: true, title: "프론티어 제휴내용 입력사항 확인"});
		return false;
	}

	
	

	$('#RevUform').attr('method', 'post');
	$('#RevUform').attr('action', '/frontier/frontier.alliance.proc');	
	$('#RevUform').submit();
	//document.forms['RevUform'].onsubmit();
	//document.forms['RevUform'].submit();

}