// <![CDATA[
$(document).ready( function() {	
	popup.initUploader();
	// 회원이미지
	$('#file1').bind('change', function () {
		if($(this).val() != "") {
			if(validation.isImageFile($(this).val()) == false) {
				$(this).val(""); 
				$('#dialog').html("이미지 파일(gif,jpg,png)만 가능합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "프로필 이미지 확인"});
			} else {
				$('#dialog-modal').dialog({ autoOpen: true });				
				$('#form1').attr('target', 'frmFile');
				$('#form1').attr('method', 'post');
				$('#form1').attr('action', '/editor/editor.image.upload.proc');					
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
	imagealign: '', // C: 센터
	imageurl: '',
	originalurl: '',
	thumburl: '',
	
	previewImage: function() {
		$('#dialog-modal').dialog("close");
		$('#pimg').attr('width', '200');
		$('#pimg').attr('height', '200');
		$('#pimg').attr('src', this.imageurl);
	},
	initImage: function() {
		$('#dialog-modal').dialog("close");
		$('#pimg').attr('width', '93');
		$('#pimg').attr('height', '95');
		$('#pimg').attr('src', IMAGES+'/common/profile_blank.gif');
		$('#dialog').html("이미지업로드가 실패하였습니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "이미지업로드"});
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
			'imagealign': this.imagealign,
			'imageurl': this.imageurl,
			'originalurl': this.originalurl,
			'thumburl': this.thumburl
		};
		execAttach(_mockdata);
		closeWindow();
	},
	initUploader: function() {
		//var _opener = PopupUtil.getOpener();
		var _opener = window.opener;
	    if (!_opener) {
	        alert('잘못된 경로로 접근하셨습니다.');
	        return;
	    }	    
	    var _attacher = getAttacher('image', _opener);
	    registerAction(_attacher);
	}
};
// ]]>