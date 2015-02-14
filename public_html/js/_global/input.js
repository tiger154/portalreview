var combobox = {
	init: function(id) {		
		$('#'+id).find('option').remove().end();
	},	
	addOption: function(id, value, text) {
		$('#'+id).append("<option value='"+value+"'>"+text+"</option>");
	},
	addOptionFirst: function(id, value, text) {
		$('#'+id).prepend("<option value='"+value+"'>"+text+"</option>");
	},	
	deleteOption: function(id, value) {
		switch(value) {
			case "first" : 
				$('#'+id+' option:first').remove();
				break;
			case "last" :
				$('#'+id+' option:last').remove();
				break;
			default :
				$('#'+id+' option:eq('+value+')').remove();
				break;
		}
	}, 
	upOption: function(id) {
		$('#'+id+' option:selected').each(function(){
			$(this).insertBefore($(this).prev());
		});
	},
	downOption: function(id) {
		$('#'+id+' option:selected').each(function(){
			$(this).insertAfter($(this).next());
		});
	}, 
	moveOption: function(id, id2) {
		
	},
	resultOption: function(id, id2) {
		var cnt = 0;			
		res = new Array();	
		$('#'+id+' option').each(function(){
			res[cnt] = $(this).val();
			cnt++;
		});		
		res = res.join("|");
		$('#'+id2).val(res);
	},
	getText: function(id) {
		var val = $('#'+id+' option:selected').text();
		return val;		
	},
	getValue: function(id) {
		var val = $('#'+id+' option:selected').val();
		return val;		
	},
	getIndex: function(id) {
		var val = $('#'+id+' option').index($('#'+id+' option:selected'));
		return val;		
	}	
};

var checkbox = {
	cnt: function(name) {
		//var cnt = $('input:checkbox[name='+name+']:checked').length;
		var cnt = $("input[name='"+name+"']:checked").length;
		return cnt;
	},
	check: function(name, type) {		
		switch(type) {
			case "2" :
				$('input:checkbox[name='+name+']').attr('checked', false);
				break;
			case "3" : 
				$('input:checkbox[name='+name+']').each(function() {
					if($(this).is(':checked')) {
						$(this).attr('checked', false);
					} else {
						$(this).attr('checked', true);
					}
				});
				break;
			case "1" :				
			default : 
				$('input[name='+name+']').attr('checked', true);
				//$("input:checkbox[name='"+name+"']").attr("checked", true);
				
				break;
		}
	},
	getCheckValue: function(name) {
		var val = "";
		var i = 0;
		$('input:checkbox[name='+name+']').each(function() {
			if($(this).is(':checked')) {
				if(val == "") {
					val += $(this).val();
				} else {
					val += "|" + $(this).val();
				}
			}
			i++;
		});
		return val;
	}
};

var radio = {
	getValue: function(name) {
		var val = $('input:radio[name='+name+']:checked').val();
		return val;
	}
};
