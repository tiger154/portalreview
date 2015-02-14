// <![CDATA[
$(document).ready( function() {	
	popup.initUploader();
	// 회원이미지	
	$('#file1').bind('change', function () {
		if($(this).val() != "") {
			if(validation.isRunFile($(this).val()) == false) {
				$(this).val(""); 
				$('#dialog').html("업로드 할 수 없는 확장자명입니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "파일업로드"});
			} else {
				$('#dialog-modal').dialog({ autoOpen: true });				
				$('#form1').attr('target', 'frmFile');
				$('#form1').attr('method', 'post');
				$('#form1').attr('action', '/editor/editor.file.upload.proc');					
				$('#form1').submit();
			}
		}
	});
});

var popup = {	
	filemime: '',
	filename: '',
	filename2: '',
	filesize: 0,
	attachurl: '',
	
	previewType: function() {
		$('#dialog-modal').dialog("close");
	},
	initType: function() {
		$('#dialog-modal').dialog("close");
		$('#dialog').html("파일업로드가 실패하였습니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "파일업로드"});
	},
	done: function() {
		if (typeof(execAttach) == 'undefined') { //Virtual Function
	        return;
	    }
		var _mockdata = {
			'filemime': this.filemime,
			'filename': this.filename,
			'filename2': this.filename2,
			'filesize': this.filesize,
			'attachurl': this.attachurl
		};
		execAttach(_mockdata);
		closeWindow();
	},
	initUploader: function() {
		var _opener = PopupUtil.getOpener();
	    if (!_opener) {
	        alert('잘못된 경로로 접근하셨습니다.');
	        return;
	    }
	    
	    var _attacher = getAttacher('file', _opener);
	    registerAction(_attacher);
	}
};
// ]]>