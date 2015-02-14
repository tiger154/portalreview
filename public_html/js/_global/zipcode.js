<!--
$(document).ready( function() {
	common.setLayer("zipcodelayer");
	$('#zipcodeList').css({ "overflow": "auto", "width": 365, "height": 200, "border": "1px solid #CCC" });
});
var zipcode = {	
	_zipcodeid: '',
	_addrid: '',
	init: function(id) {		
		$("#"+id).find("option").remove().end().append("<option value=''>지역선택</option>");
	},
	set: function(bcode, mcode, scode, area) {
		//if(area != "") {
			var url ="/common/search.area.set";
			var data = "&bcode=" + bcode + "&mcode=" + mcode + "&scode=" + scode + "&area=" + area;
			$.ajax({ type: "POST", url: url, data: data, success: this.setRequest });
		//}
	}, 
	setRequest: function(data) {
		var result = $.parseJSON(data);
		var area = result.area;
		if(result.result == "success") {
			zipcode.init(result.bcode);
			zipcode.init(result.mcode);
			zipcode.init(result.scode);
			var bcode_list = result.bcode_list;
			if(bcode_list) {
				var length = bcode_list.length;
				for(var i=0; i<length ; i++) {
					$("#" + result.bcode).append('<option value="'+bcode_list[i].bcode+'">'+bcode_list[i].ko_desc+'</option>');
					if(area[0] == bcode_list[i].bcode) $("#"+result.bcode+" option:eq("+Number(i+1)+")").attr("selected", "selected");
				}
			}
			var mcode_list = result.mcode_list;
			if(mcode_list) {
				var length = mcode_list.length;
				for(var i=0; i<length ; i++) {
					$("#" + result.mcode).append('<option value="'+mcode_list[i].mcode+'">'+mcode_list[i].ko_desc+'</option>');
					if(area[1] == mcode_list[i].mcode) $("#"+result.mcode+" option:eq("+Number(i+1)+")").attr("selected", "selected");
				}
			}
			if(scode_list) {
				var scode_list = result.scode_list;
				var length = scode_list.length;
				for(var i=0; i<length ; i++) {
					$("#" + result.scode).append('<option value="'+scode_list[i].scode+'">'+scode_list[i].ko_desc+'</option>');
					if(area[2] == scode_list[i].scode) $("#"+result.scode+" option:eq("+Number(i+1)+")").attr("selected", "selected");
				}
			}
		} else {
			//$('#dialog').html("하위 분류 정보가 없습니다.");
			//$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "2차분류검색"});
		}
	},
	searchMcode: function(bcode, mid, sid) {			
		if(bcode != "" && mid != "") {
			this.init(mid);
			this.init(sid);
			var url ="/common/search.mcode";
			var data = "&bcode=" + bcode + "&mid=" + mid + "&sid=" + sid;
			$.ajax({ type: "POST", url: url, data: data, success: this.searchMcodeRequest });
		} else {
			this.init(mid);
			this.init(sid);
		}
	},
	searchMcodeRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			zipcode.init(result.mid);
			zipcode.init(result.sid);
			var mcode_list = result.mcode_list;
			var length = mcode_list.length;
			for(var i=0; i<length; i++) {
				combobox.addOption(result.mid, mcode_list[i].mcode, mcode_list[i].ko_desc);
			}
		} else {
			$('#dialog').html("정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "지역코드 검색"});
		}
	},
	searchScode: function(bcode, mcode, sid) {
		if(bcode != "" && mcode != "" && sid != "") {
			this.init(sid);
			var url = "/common/search.scode";
			var data = "&bcode=" + bcode + "&mcode=" + mcode + "&sid=" + sid;
			$.ajax({ type: "POST", url: url, data: data, success: this.searchScodeRequest });
		} else {
			this.init(sid);
		}
	},
	searchScodeRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			zipcode.init(result.sid);
			var scode_list = result.scode_list;			
			var length = scode_list.length;
			for(var i=0; i<length ; i++) {
				combobox.addOption(result.sid, scode_list[i].scode, scode_list[i].ko_desc);
			}
		} else {
			$('#dialog').html("정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, title: "지역코드 검색"});
		}
	},
	getForm : function() {
		var html = "";
		html += "<p>현재 거주하고있는 읍/면/동을 입력하여 주세요.</p>";
		html += "<select id='type'>";
		html += "<option value='dong'>읍/면/동 검색</option>";
		html += "<option value='abname'>아파트/건물명 검색</option>";
		html += "</select>";
		html += "<input type='text' name='keyword' id='keyword' />";
		html += "<input type='button' id='searchBtn' value='검색' onClick='zipcode.searchZipcode();' />";
		html += "<p>검색결과</p>";
		html += "<select id='zipcodeList' multiple='multiple' style='width:400px;height:100px;'>";
		html += "</select>";
		return html;
	}, 
	setForm: function(zipcodeid, addrid) {
		var html = this.getForm();
		this._zipcodeid = zipcodeid;
		this._addrid = addrid;
		$('#dialog').html(html);
		$('#dialog').dialog({ autoOpen: true, width: "500", height: "300", title: "우편번호 검색" });
	},
	valForm: function(keyword) {
		if(keyword == "") {
			$('#dialog2').html("검색어를 입력하세요.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "우편번호 검색"});
			return false;
		}			
		if(validation.isSpecail(keyword) == false) {
			$('#dialog2').html("검색어는 한글/영문/숫자로 되어야 합니다.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "우편번호 검색"});
			return false;
		}
		if(validation.isSpace(keyword) == true) {
			$('#dialog2').html("검색어는 공백이 없어야 합니다.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "우편번호 검색"});
			return false;
		}
		if(validation.isLength(keyword, 2, 10) == false) {
			$('#dialog2').html("검색어는 2~10자리로 되어 있어야 합니다.");
			$('#dialog2').dialog({ autoOpen: true, width: "300", height:"150", title: "우편번호 검색"});
			return false;
		}
		return true;
	},
	search: function(zipcode, addr1) {
		var type = $('#zipcodeType').val();
		var keyword = $('#zipcodeKeyword').val();		
		if(this.valForm(keyword) == true) {
			var url = "/common/search.zipcode";
			var data = "&type=" + type + "&keyword=" + common.trim(keyword) + "&zipcode=" + zipcode + "&addr1=" + addr1;
			$.ajax({ type: "POST", url: url, data: data, success: this.searchRequest });
		}
	},
	searchRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			html = "";
			$('#zipcodeList').html(html);
			var list = result.list;
			var length = list.length;
			for(var i=0; i<length ; i++) {				
				html += "<div class='pa05'>";
				html += "<a href=\"javascript:zipcode.apply('"+result.zipcode+"','"+result.addr1+"','"+list[i].zipcode+"','"+list[i].addr+"');\"><strong>"+list[i].zipcode+"</strong> | "+list[i].addr+"</a>";
				html += "</div>";
			}
			$('#zipcodeList').html(html);
		} else {
			$('#dialog').html("정보가 없습니다. 다른 검색어로 검색하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "우편번호 검색"});
		}
	},
	apply: function(zipcode, addr1, val1, val2) {
		$('#'+zipcode).val(val1);
		$('#'+addr1).val(val2);
		$('#dialog').dialog("close");
		common.closeLayer('zipcodelayer');
	}
};
-->