// I18N constants

// LANG: "en", ENCODING: UTF-8 | ISO-8859-1
// Author: Mihai Bazon, http://dynarch.com/mishoo

// FOR TRANSLATORS:
//
//   1. PLEASE PUT YOUR CONTACT INFO IN THE ABOVE LINE
//      (at least a valid email address)
//
//   2. PLEASE TRY TO USE UTF-8 FOR ENCODING;
//      (if this is not possible, please include a comment
//       that states what encoding is necessary.)

HTMLArea.I18N = {

	// the following should be the filename without .js extension
	// it will be used for automatically load plugin language.
	lang: "kr",

	tooltips: {
		bold							: "진하게",
		italic							: "기울임",
		underline						: "밑줄",
		strikethrough				: "취소선",
		subscript						: "아랫첨자",
		superscript					: "윗첨자",
		justifyleft						: "왼쪽 정렬",
		justifycenter				: "가운데 정렬",
		justifyright					: "오른쪽 정렬",
		justifyfull						: "양쪽 정렬",
		orderedlist					: "숫자 목록",
		unorderedlist				: "기호 목록",
		outdent						: "내어 쓰기",
		indent							: "들여 쓰기",
		forecolor						: "글꼴 색",
		hilitecolor						: "강조(배경)색",
		inserthorizontalrule			: "수평선 넣기",
		createlink					: "링크 걸기",
		insertimage					: "그림 삽입",
		inserttable					: "테이블 삽입",
		toggletableborders			: "테이블 가이드라인",
		htmlmode					: "HTML모드",
		popupeditor					: "에디터 확대",
		about							: "에디터 설명",
		showhelp						: "에디터 사용방법",
		textindicator					: "현재 스타일",
		undo							: "되돌리기",
		redo							: "다시 실행",
		cut							: "잘라내기",
		cut_ff							: "잘라내기(Mozilla/FireFox)",
		copy							: "복사",
		copy_ff						: "복사(Mozilla/FireFox)",
		paste							: "붙여넣기",
		paste_ff						: "붙여넣기(Mozilla/FireFox)",
		lefttoright					: "글쓰기방향(왼쪽에서 오른쪽)",
		righttoleft					: "글쓰기방향(오른쪽에서 왼쪽)",
		removeformat				: "모든 글자 속성 지우기",
		print							: "Print document",
		killword						: "Clear MSOffice tags"
	},

	buttons: {
		"ok"							: "OK",
		"cancel"						: "Cancel"
	},

	msg: {
		"Path"						: "경로",
		"TEXT_MODE"				: "현재 텍스트모드입니다.  에디터모드로 전환 하시려면 [<>] 버튼을 클릭하세요.",

		"IE-sucks-full-screen" :
		// translate here
		"전체화면모드는 익스플로러에서 문제가 있습니다., " +
		"현재 시스템이 windows 9x 이면 문제가 발생할 수 있습니다.",

		"Moz-Clipboard" :
		"보안상의 이유로 잘라내기/복사/붙여넣기가 허용되지 않을 수도 있습니다." +
		"보기를 클릭하여 mozilla.org 사이트의 기술노트를 참고 하시길 바랍니다.",

		"Link-Text" :
		"링크를 걸기전에 선택하세요."
	},

	dialogs: {
		// Common
		"OK"																	: "확인",
		"Cancel"																: "취소",

		"Alignment:"														: "정렬:",
		"Not set"															: "설정안함",
		"Left"																	: "Left",
		"Right"																: "Right",
		"Texttop"															: "Texttop",
		"Absmiddle"															: "Absmiddle",
		"Baseline"															: "Baseline",
		"Absbottom"														: "Absbottom",
		"Bottom"															: "Bottom",
		"Middle"																: "Middle",
		"Top"																	: "Top",

		"Layout"																: "레이아웃",
		"Spacing"															: "여백",
		"Horizontal:"														: "수평:",
		"Horizontal padding"												: "수평 여백",
		"Vertical:"															: "수직:",
		"Vertical padding"													: "수직 여백",
		"Border thickness:"												: "테두리 두께:",
		"Leave empty for no border"									: "공백이 없어야 합니다.",

		// Insert Link
		"Insert/Modify Link"												: "링크 걸기/수정",
		"None (use implicit)"												: "없음",
		"New window (_blank)"											: "새창 (_blank)",
		"Same frame (_self)"											: "현재창 (_self)",
		"Top frame (_top)"												: "상위창 (_top)",
		"Other"																: "기타",
		"Target:"															: "대상:",
		"Title (tooltip):"														: "설명-툴팁:",
		"URL:": "URL:",
		"You must enter the URL where this link points to"		: "URL주소를 입력하세요.",
		// Insert Table
		"Insert Table"														: "테이블 삽입",
		"Rows:"																: "행:",
		"Number of rows"													: "행수",
		"Cols:"																: "열:",
		"Number of columns"											: "열수",
		"Width:"																: "너비",
		"Width of the table"												: "테이블 너비",
		"Percent	"															: "퍼센트",
		"Pixels"																: "픽셀",
		"Em"																	: "Em",
		"Width unit"															: "너비 단위",
		"Positioning of this table"											: "테이블 위치",
		"Cell spacing:"														: "셀 여백:",
		"Space between adjacent cells"								: "인접한 셀 사이의 공간",
		"Cell padding:"														: "셀 패딩:",
		"Space between content and border in cell"				: "셀과 내용 사이의 공간",
		// Insert Image
		"Insert Image"														: "이미지 삽입",
		"Image URL:"														: "이미지 경로(URL):",
		"Enter the image URL here"									: "이미지 경로(URL)을 입력하세요.",
		"Preview"															: "미리보기",
		"Preview the image in a new window"						: "새창으로 이미지 미리보기",
		"Alternate text:"													: "이미지 설명:",
		"For browsers that don't support images"					: "현재 브라우져가 이미지를 지원하지 않습니다.",
		"Positioning of this image"										: "이미지 위치",
		"Image Preview:"													: "이미지 미리보기:"
	}
};
