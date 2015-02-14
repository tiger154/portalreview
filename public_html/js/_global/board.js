// 파일다운로드

var board = {
	/*
	 * 파일다운로드
	 */
	download: function(code, idx) {
		var module = "board.file.download";
		var param = "&code=" + code + "&idx=" + idx;
		common.popupModule('downloadFile', module, param);
	},
	
	/*
	 * 파일삭제처리
	 */
	deleteFile: function(code, idx) {
		$("#code").val(code);
		$("#file_idx").val(idx);
		common.submitModule("form1", "board.file.delete.proc", "POST");
	},
	
	/*
	 * 검색
	 */
	search: function(page, module) {
		module = module + ".list";	
		var param = "&page=" + page;
		param += "&page_row=" + $("#page_row").val();
		if( $("#code").size()) param += "&code=" + $("#code").val();
		if( $("#btitle").size()) param += "&btitle=" + $("btitle").val();
		if( $("#clubidx").size()) param += "&clubidx=" + $("clubidx").val();
		if( $("#sch_opt").size()) param += "&sch_opt=" + $("#sch_opt").val();
		if( $("#sch_con").size()) param += "&sch_con=" + $("#sch_con").val();
		/*
		var param = "&code=" + $("#code").val();
		param += "&btitle=" + $("#btitle").val();
		param += "&page=" + page;
		param += "&page_row=" + $("#page_row").val();
		param += "&sch_opt=" + $("#sch_opt").val();
		param += "&sch_con=" + $("#sch_con").val();
		*/
		common.redirectModule(module, param);
	},
	
	/*
	 * 검색 및 초기화
	 */
	searchInit: function(module) {
		module = module + ".list";
		var param = "&page=" + "1";
		param += "&page_row=" + $("#page_row").val();
		if( $("#code").size()) param += "&code=" + $("#code").val();
		if( $("#btitle").size()) param += "&btitle=" + $("btitle").val();
		if( $("#clubidx").size()) param += "&clubidx=" + $("clubidx").val();
		if( $("#sch_opt").size()) param += "&sch_opt=" + $("#sch_opt").val();
		if( $("#sch_con").size()) param += "&sch_con=" + $("#sch_con").val();
		/*	
		var param = "&code=" + $("#code").val();
		param += "&btitle=" + $("#btitle").val();
		param += "&page=" + "1";
		param += "&page_row=" + $("#page_row").val();
		param += "&sch_opt=" + $("#sch_opt").val();
		param += "&sch_con=" + $("#sch_con").val();
		*/
		common.redirectModule(module, param);
	},
	
	/*
	 * 검색시 엔터
	 */
	searchEnter: function(evt, module) {
		var result = "";
		var evCode = (window.netscape) ? evt.which : event.keyCode;
		if(evCode == 13)  result = true;
		else result = false;
		if(result == true) this.searchInit(module);	
	},
	
	/*
	 * 등록폼이동
	 */
	writeForm: function(module) {
		module = module + ".write";	
		var param = "&page=" + $("#page").val();
		param += "&page_row=" + $("#page_row").val();
		if( $("#code").size()) param += "&code=" + $("#code").val();
		if( $("#btitle").size()) param += "&btitle=" + $("btitle").val();
		if( $("#clubidx").size()) param += "&clubidx=" + $("clubidx").val();
		if( $("#sch_opt").size()) param += "&sch_opt=" + $("#sch_opt").val();
		if( $("#sch_con").size()) param += "&sch_con=" + $("#sch_con").val();
		/*
		var param = "&code=" + $("#code").val();
		param += "&btitle=" + $("#btitle").val();
		param += "&page=" + $("#page").val();
		param += "&page_row=" + $("#page_row").val();
		param += "&sch_opt=" + $("#sch_opt").val();
		param += "&sch_con=" + $("#sch_con").val();
		*/
		common.redirectModule(module, param);
	},
	
	/*
	 * 게시물등록
	 */
	register: function() {
		var module = "board.register.proc";
		if(!$("#title").val() || $("#title").val() == "" )
		{
			msg.showMsg(350, 150, true, "제목을 입력하세요.", "", "$('#title').focus();");
			return;
		}
		/*
		if($("#btitle").val() == "")
		{
			msg.showMsg(350, 150, true, "유형을 선택하세요.", "", "$('#btitle').focus();");
			return;
		}
		*/
		msg.showMsg(350, 150, false, "게시물을 등록하는 중입니다.");
		document.forms['form1'].onsubmit();
		document.forms['form1'].submit();
		submitModule("form1", module, "POST");
	},
	
	/*
	 * 게시물수정
	 */
	modifyRegister: function() {
		var module = "board.modify.proc";
		if(!$("#title").val() || $("#title").val() == "" )
		{
			msg.showMsg(350, 150, true, "제목을 입력하세요.", "", "$('#title').focus();");
			return;
		}
		/*
		if($("#btitle").val() == "")
		{
			msg.showMsg(350, 150, true, "유형을 선택하세요.", "", "$('#btitle').focus();");
			return;
		}
		*/
		msg.showMsg(350, 150, false, "게시물을 등록하는 중입니다.");
		document.forms['form1'].onsubmit();
		document.forms['form1'].submit();
		common.submitModule("form1", module, "POST");
	},
	
	/*
	 * 답글등록
	 */
	replyRegister: function() {
		var module = "board.reply.proc";
		if(!$("#title").val() || $("#title").val() == "" )
		{
			msg.showMsg(350, 150, true, "제목을 입력하세요.", "", "$('#title').focus();");
			return;
		}
		/*
		if($("#btitle").val() == "")
		{
			msg.showMsg(350, 150, true, "유형을 선택하세요.", "", "$('#btitle').focus();");
			return;
		}
		*/
		msg.showMsg(350, 150, false, "게시물을 등록하는 중입니다.");
		document.forms['form1'].onsubmit();
		document.forms['form1'].submit();
		common.submitModule("form1", module, "POST");
	},
	
	/*
	 * 글보기
	 */
	view: function(idx, module) {
		module = module + ".view";
		/*
		var param = "&code=" + $("#code").val();
		param += "&btitle=" + $("#btitle").val();
		param += "&page=" + $("#page").val();
		param += "&page_row=" + $("#page_row").val();
		param += "&sch_opt=" + $("#sch_opt").val();
		param += "&sch_con=" + $("#sch_con").val();
		param += "&idx=" + idx;
		*/
		var param = "&page=" + $("#page").val();
		param += "&page_row=" + $("#page_row").val();
		if( $("#code").size()) param += "&code=" + $("#code").val();
		if( $("#btitle").size()) param += "&btitle=" + $("btitle").val();
		if( $("#clubidx").size()) param += "&clubidx=" + $("clubidx").val();
		if( $("#sch_opt").size()) param += "&sch_opt=" + $("#sch_opt").val();
		if( $("#sch_con").size()) param += "&sch_con=" + $("#sch_con").val();
		param += "&idx=" + idx;
		redirectModule(module, param);
	},
	
	/*
	 * 글수정
	 */
	modify: function(idx, module) {
		module = module + ".modify";
		/*
		var param = "&code=" + $("#code").val();
		param += "&btitle=" + $("#btitle").val();
		param += "&page=" + $("#page").val();
		param += "&page_row=" + $("#page_row").val();
		param += "&sch_opt=" + $("#sch_opt").val();
		param += "&sch_con=" + $("#sch_con").val();
		param += "&idx=" + idx;
		*/
		var param = "&page=" + $("#page").val();
		param += "&page_row=" + $("#page_row").val();
		if( $("#code").size()) param += "&code=" + $("#code").val();
		if( $("#btitle").size()) param += "&btitle=" + $("btitle").val();
		if( $("#clubidx").size()) param += "&clubidx=" + $("clubidx").val();
		if( $("#sch_opt").size()) param += "&sch_opt=" + $("#sch_opt").val();
		if( $("#sch_con").size()) param += "&sch_con=" + $("#sch_con").val();
	
		param += "&idx=" + idx;
		redirectModule(module, param);
	},
	
	/*
	 * 글삭제 확인
	 */
	confirmDelete: function(idx, module) {
		//msg.showMsg(350, 150, true, "게시물을 삭제하시겠습니까?", "deleteProc('"+idx+"','"+module+"');", "");	
	},
	
	/*
	 * 글삭제
	 */
	deleteProc: function(idx) {
		//msg.showMsg(350, 150, false, "처리중입니다.\n잠시만 기다려주시길 바랍니다.");
		common.submitModule("form1", "board.delete.proc", "POST");
	}
};