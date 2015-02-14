<?php /* Template_ 2.2.4 2011/10/21 17:02:41 /www/revu39/engine/view/V3.9/index/index.editor.htm 000004372 */ ?>
<link rel="stylesheet" href="<?php echo $TPL_VAR["EXTENDS"]?>/editor.daum/css/editor.css" type="text/css"  charset="utf-8"/>
<script src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.daum/js/editor.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.daum/js/editor_sample.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/editor.js"></script>

<?php $this->print_("editor",$TPL_SCP,1);?>


<center>
	<input type="button" value="등 록 합 시 다" onClick="revuEditor.saveContent();" />
	<input type="button" value="내용불러오기" onClick="revuEditor.loadContent(); return false;" />	
</center>

<!--
	저장된 컨텐츠를 불러오기 위한 예제
	내용을 문자열로 입력하거나, 이미 주어진 필드(textarea)가 있을 경우 엘리먼트를 넘겨준다. 
-->
<textarea id="tx_load_content" cols="80" rows="10">불러오기내용</textarea>


<script type="text/javascript">
// <![CDATA[
/*-------- 에디터 로드 시작 ----------*/
new Editor({
	txHost: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) http://xxx.xxx.com */
	txPath: '<?php echo $TPL_VAR["EXTENDS"]?>/editor.daum/', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) /xxx/xxx/ */
	txVersion: '5.4.0', /* 수정필요없음. */
	txService: 'sample', /* 수정필요없음. */
	txProject: 'sample', /* 수정필요없음. 프로젝트가 여러개일 경우만 수정한다. */
	initializedId: "", /* 대부분의 경우에 빈문자열 */
	wrapper: "tx_trex_container"+"", /* 에디터를 둘러싸고 있는 레이어 이름(에디터 컨테이너) */
	form: 'tx_editor_form'+"", /* 등록하기 위한 Form 이름 */
	txIconPath: "<?php echo $TPL_VAR["EXTENDS"]?>/editor.daum/images/icon/", /*에디터에 사용되는 이미지 디렉터리, 필요에 따라 수정한다. */
	txDecoPath: "<?php echo $TPL_VAR["EXTENDS"]?>/editor.daum/images/deco/", /*본문에 사용되는 이미지 디렉터리, 서비스에서 사용할 때는 완성된 컨텐츠로 배포되기 위해 절대경로로 수정한다. */
	canvas: {
		styles: {
			color: "#000000", /* 기본 글자색 */
			fontFamily: "돋움", /* 기본 글자체 */
			fontSize: "10pt", /* 기본 글자크기 */
			backgroundColor: "#fff", /*기본 배경색 */
			lineHeight: "1.5", /*기본 줄간격 */
			padding: "8px" /* 위지윅 영역의 여백 */
		}
	},
	sidebar: {
		attacher: {
			image: {
			},
			file: {
			}
		}
	},
	size: {
		/*contentWidth: 650*/ /* 지정된 본문영역의 넓이가 있을 경우에 설정 */
	}
})
//}).focusOnForm("tx_article_title");
/*-------- 에디터 로드 끝 ----------*/

/*-------- 컨텐츠 불러오기 시작 ----------*/
/* 예제용 함수 */
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
/**/
// ]]>
</script>