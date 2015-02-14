<!--
var category = {
	set: function(cate1, cate2, cate3, cate4, cate) {
		//if(cate != "") {
			var url ="/common/search.cate.set";
			var data = "&cate1=" + cate1 + "&cate2=" + cate2 + "&cate3=" + cate3 + "&cate4=" + cate4 + "&cate=" + cate;
			$.ajax({ type: "POST", url: url, data: data, success: this.setRequest });
		//}
	},
	setRequest: function(data) {
		var result = $.parseJSON(data);
		var cate = result.cate;
		if(result.result == "success") {
			category.init(result.cate1, '1차분류선택');
			category.init(result.cate2, '2차분류선택');
			category.init(result.cate3, '3차분류선택');
			category.init(result.cate4, '4차분류선택');
			var cate1_list = result.cate1_list;				
			if(cate1_list) {
				var length = cate1_list.length;
				for(var i=0; i<length ; i++) {
					$("#" + result.cate1).append('<option value="'+cate1_list[i].cate1+'">'+cate1_list[i].cate_desc+'</option>');			
					if(cate[0] == cate1_list[i].cate1) $("#"+result.cate1+" option:eq("+Number(i+1)+")").attr("selected", "selected");
				}							
			}
			var cate2_list = result.cate2_list;			
			if(cate2_list) {
				var length = cate2_list.length;
				for(var i=0; i<length ; i++) {
					$("#" + result.cate2).append('<option value="'+cate2_list[i].cate2+'">'+cate2_list[i].cate_desc+'</option>');
					if(cate[1] == cate2_list[i].cate2) $("#"+result.cate2+" option:eq("+Number(i+1)+")").attr("selected", "selected");
				}
			}
			var cate3_list = result.cate3_list;			
			if(cate3_list) {
				var length = cate3_list.length;
				for(var i=0; i<length ; i++) {
					$("#" + result.cate3).append('<option value="'+cate3_list[i].cate2+'">'+cate3_list[i].cate_desc+'</option>');
					if(cate[2] == cate3_list[i].cate3) $("#"+result.cate3+" option:eq("+Number(i+1)+")").attr("selected", "selected");
				}
			}
			var cate4_list = result.cate4_list;			
			if(cate4_list) {
				var length = cate4_list.length;
				for(var i=0; i<length ; i++) {
					$("#" + result.cate4).append('<option value="'+cate4_list[i].cate2+'">'+cate4_list[i].cate_desc+'</option>');
					if(cate[3] == cate4_list[i].cate4) $("#"+result.cate4+" option:eq("+Number(i+1)+")").attr("selected", "selected");
				}
			}
		} else {
			//$('#dialog').html("하위 분류 정보가 없습니다.");
			//$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "2차분류검색"});
		}
	},
	init: function(id, text) {
		$("#"+id+" option").remove();
		$("#" + id).append('<option value="">'+text+'</option>');
		
	},
	change1: function(cate1, cate2, cate3, cate4) {
		var _cate1 = $("#"+cate1+" option:selected").val();
		this.search2(_cate1, cate2, cate3, cate4);
	},
	search2: function(cate1, cate2, cate3, cate4) {
		if(cate1 != "" && cate2 != "") {
			this.init(cate2, "2차분류선택");
			this.init(cate3, "3차분류선택");
			this.init(cate4, "4차분류선택");
			var url ="/common/search.cate2";
			var data = "&cate1=" + cate1 + "&cate2=" + cate2 + "&cate3=" + cate3 + "&cate4=" + cate4;
			$.ajax({ type: "POST", url: url, data: data, success: this.searchRequest2 });
		} else {
			this.init(cate2, "2차분류선택");
			this.init(cate3, "3차분류선택");
			this.init(cate4, "4차분류선택");
		}
	}, 
	searchRequest2: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			category.init(result.cate2, "2차분류선택");
			category.init(result.cate3, "3차분류선택");
			category.init(result.cate4, "4차분류선택");
			var cate2_list = result.cate2_list;
			var length = cate2_list.length;
			for(var i=0; i<length ; i++) {
				$("#" + result.cate2).append('<option value="'+cate2_list[i].cate2+'">'+cate2_list[i].cate_desc+'</option>');
			}
		} else {
			$('#dialog').html("하위 분류 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "2차분류검색"});
		}
	},
	change2: function(cate1, cate2, cate3, cate4) {
		var _cate1 = $("#"+cate1+" option:selected").val();
		var _cate2 = $("#"+cate2+" option:selected").val();
		this.search3(_cate1, _cate2, cate3, cate4);		
	},
	search3: function(cate1, cate2, cate3, cate4) {			
		if(cate1 != "" && cate2 != "") {
			this.init(cate3, "3차분류선택");
			this.init(cate4, "4차분류선택");
			var url ="/common/search.cate3";
			var data = "&cate1=" + cate1 + "&cate2=" + cate2 + "&cate3=" + cate3 + "&cate4=" + cate4;
			$.ajax({ type: "POST", url: url, data: data, success: this.searchRequest3 });
		} else {
			this.init(cate3, "3차분류선택");
			this.init(cate4, "4차분류선택");
		}
	},
	searchRequest3: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			category.init(result.cate3, "3차분류선택");
			category.init(result.cate4, "4차분류선택");
			var cate3_list = result.cate3_list;
			var length = cate3_list.length;
			for(var i=0; i<length; i++) {
				$("#" + result.cate3).append('<option value="'+cate3_list[i].cate3+'">'+cate3_list[i].cate_desc+'</option>');
			}
		} else {
			$('#dialog').html("하위 분류 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "3차분류검색"});
		}
	},
	change3: function(cate1, cate2, cate3, cate4) {
		var _cate1 = $("#"+cate1+" option:selected").val();
		var _cate2 = $("#"+cate2+" option:selected").val();
		var _cate3 = $("#"+cate3+" option:selected").val();

		this.search4(_cate1, _cate2, _cate3, cate4);		
	},	
	search4: function(cate1, cate2, cate3, cate4) {			
		if(cate1 != "" && cate2 != "" && cate3 != "") {
			this.init(cate4, "4차분류선택");
			var url ="/common/search.cate4";
			var data = "&cate1=" + cate1 + "&cate2=" + cate2 + "&cate3=" + cate3 + "&cate4=" + cate4;
			$.ajax({ type: "POST", url: url, data: data, success: this.searchRequest4 });
		} else {
			this.init(cate4, "4차분류선택");
		}
	},
	searchRequest4: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			category.init(result.cate4, "4차분류선택");
			var cate4_list = result.cate4_list;
			var length = cate4_list.length;	
			for(var i=0; i<length; i++) {				
				$("#" + result.cate4).append('<option value="'+cate4_list[i].cate4+'">'+cate4_list[i].cate_desc+'</option>');
			}
		} else {
			$('#dialog').html("하위 분류 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "4차분류검색"});
		}
	}
};
-->