<!--
$(function(){	
	$('#dialog').dialog({ 
		modal: true, 
		autoOpen: false, 
		zindex: 100,
		draggable: false,
		buttons: { "닫기": function() { $(this).dialog("close");}}
	});	
	$('#dialog2').dialog({ 
		modal: true, 
		autoOpen: false,
		zindex: 110, 
		draggable: false, 
		buttons: { "닫기": function() { $(this).dialog("close");}}
	});
	$('#dialog-modal').dialog({ 
		modal: true, 
		autoOpen: false,
		zindex: 120,
		draggable: false, 
		closeOnEscape: false,
		title: "처리중",
		width: 300,
		height: 150
	});
	$('#dialog-modal').html("처리중입니다. 잠시만 기다려 주시길 바랍니다.")
	//$("button, input:submit, input:button, a", "#middle").button();
	$("button, input:submit, input:button", "#middle").button();
	$("button, input:submit, input:button", "#contents").button();
	$("#progressbar").progressbar("disable");
	$('#tabs').tabs();
});
-->