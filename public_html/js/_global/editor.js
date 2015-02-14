// <![CDATA[
// 글등록
function saveContent() {
	Editor.save(); /* 이 함수를 호출하여 글을 등록하면 된다. */
}

/**
 * Editor.save()를 호출한 경우 데이터가 유효한지 검사하기 위해 부르는 콜백함수로 
 * 상황에 맞게 수정하여 사용한다.
 * 모든 데이터가 유효할 경우에 true를 리턴한다. 
 * @function
 * @param {Object} editor - 에디터에서 넘겨주는 editor 객체
 * @returns {Boolean} 모든 데이터가 유효할 경우에 true
 */
function validForm(editor) { 
	
	/* 제목 필드가 따로 존재할 경우 'tx_article_title'를 해당 아이디로 교체하여 사용. */
	
	/*
	if($tx('tx_article_title').value == ""){
		alert('제목을 입력하세요');
		return false;
	}
	*/
		
	/* 본문 내용이 입력되었는지 검사하는 부분 */
	var _validator = new Trex.Validator();
	var _content = editor.getContent();
	if(!_validator.exists(_content)) {
		alert('내용을 입력하세요');
		return false;
	}		
	return true;
}

/**
 * Editor.save()를 호출한 경우 데이터가 유효하면
 * Form Summit을 위해 필드를 생성, 변경하기 위해 부르는 콜백함수로 
 * 상황에 맞게 수정하여 사용한다.
 * 정상적인 경우에 true를 리턴한다. 
 * @function
 * @param {Object} editor - 에디터에서 넘겨주는 editor 객체
 * @returns {Boolean} 정상적인 경우에 true
 */
function setForm(editor) {
	var _formGen = editor.getForm();		
	var _content = editor.getContent();
	_formGen.createField(
		tx.textarea({ 
			/* 본문 내용을 필드를 생성하여 값을 할당하는 부분 */
			'name': "tx_content", 
			'style': { 'display': "none" } 
		}, 
		_content)
	);

	/* 아래의 코드는 첨부된 데이터를 필드를 생성하여 값을 할당하는 부분으로 상황에 맞게 수정하여 사용한다.
	첨부된 데이터 중에 주어진 종류(image,file..)에 해당하는 것만 배열로 넘겨준다. */  
	var _attachments = editor.getAttachments('image');
	for(var i=0,len=_attachments.length;i<len;i++) {
		/* existStage는 현재 본문에 존재하는지 여부 */ 
		if (_attachments[i].existStage) {
			/* data는 팝업에서 execAttach 등을 통해 넘긴 데이터 */
			//alert(_attachments[i].data);
			_formGen.createField(
				tx.input({ 
					'type': "hidden", 
					'name': 'tx_attach_image[]', 
					'value': escape(_attachments[i].data.filemime) + "|" + escape(_attachments[i].data.filename) + "|" + escape(_attachments[i].data.filename2) + "|" + _attachments[i].data.filesize + "|" + _attachments[i].data.imagealign + "|" + escape(_attachments[i].data.imageurl) + "|" + escape(_attachments[i].data.originalurl) + "|" + escape(_attachments[i].data.thumburl),
				})
			);
		}
	}

	var _attachments = editor.getAttachments('file');
	for(var i=0,len=_attachments.length;i<len;i++) {
		/* existStage는 현재 본문에 존재하는지 여부 */ 
		if (_attachments[i].existStage) {
			/* data는 팝업에서 execAttach 등을 통해 넘긴 데이터 */
			//alert(_attachments[i].data);
			_formGen.createField(
				tx.input({ 
					'type': "hidden", 
					'name': 'tx_attach_file[]', 
					'value': escape(_attachments[i].data.filemime) + "|" + escape(_attachments[i].data.filename) + "|" + escape(_attachments[i].data.filename2) + "|" + _attachments[i].data.filesize + "|" + escape(_attachments[i].data.attachurl), 
				})
			);
		}
	}
	return true;
}

// 컨텐츠 불러오기
function loadContent() {
	var attachments = {};
	
	attachments['image'] = [];
	attachments['image'].push( { 
		'attacher': 'image', 
		'data': { 
			'imageurl': 'http://cfile284.uf.daum.net/image/116E89154AA4F4E2838948',
			'filename': 'editor_bi.gif',
			'filesize': 640,
			'originalurl': 'http://cfile284.uf.daum.net/original/116E89154AA4F4E2838948',
			'thumburl': 'http://cfile284.uf.daum.net/P150x100/116E89154AA4F4E2838948'
		}
	});

	attachments['file'] = [];
	attachments['file'].push({
		'attacher': 'file', 
		'data': {
			'attachurl': 'http://cfile297.uf.daum.net/attach/207C8C1B4AA4F5DC01A644',
			'filemime': 'image/gif',
			'filename': 'editor_bi.gif',
			'filesize': 640
		}
	});
	
	/* 저장된 컨텐츠를 불러오기 위한 함수 호출 */
	Editor.modify({
		"attachments": function() { /* 저장된 첨부가 있을 경우 배열로 넘김, 위의 부분을 수정하고 아래 부분은 수정없이 사용 */
			var allattachments = [];
			for(var i in attachments) {
				allattachments = allattachments.concat(attachments[i]);
			}
			return allattachments;
		}(),
		"content": $tx("tx_load_content") /* 내용 문자열, 주어진 필드(textarea) 엘리먼트 */ 
	});
}
// ]]>