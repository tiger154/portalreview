//=========================================================================
// 에디터 기본설정
//=========================================================================

_editor2_url = "/extends/editor.htmlarea/";
_editor2_lang = "kr";

//=========================================================================
// 에디터 객체 생성 
//=========================================================================


//=========================================================================
// htmlarea.ja 원본내용
//=========================================================================

// 에디터 경로 설정
(function()
{
	if(typeof _editor2_url =="string") {
		_editor2_url=_editor2_url.replace(/\x2f*$/,'/');
	} else {
		alert("경고 : _editor2_url 변수가 설정되지 않았습니다. 이 변수에 경로를 설정하세요. '/htmlarea/' 처럼 절대경로로 설정하세요.");
		_editor2_url='';
	}	
	if(typeof _editor2_lang == "string") {
		_editor2_lang = _editor2_lang.toLowerCase();
	} else {
		_editor2_lang="kr";
	}
	var agt = navigator.userAgent.toLowerCase();	
	HTMLArea2.is_ie = ((agt.indexOf("msie")!=-1) && (agt.indexOf("opera")==-1));
	HTMLArea2.is_opera = window.opera ? true : (agt.indexOf("opera")!=-1);
	HTMLArea2.is_mac = (agt.indexOf("mac")!=-1);
	HTMLArea2.is_mac_ie = (HTMLArea2.is_ie && HTMLArea2.is_mac);
	HTMLArea2.is_win_ie = (HTMLArea2.is_ie&&!HTMLArea2.is_mac);
	HTMLArea2.is_gecko = (navigator.product == "Gecko");
	HTMLArea2.is_midas = HTMLArea2.is_opera||HTMLArea2.is_gecko;
})();

// HTMLArea2객체 생성
function HTMLArea2(textarea,config)
{
	if(HTMLArea2.checkSupportedBrowser()) {
		if(typeof config == "undefined") {
			this.config = new HTMLArea2.Config();
		} else {
			this.config = config;
		}
		this._htmlArea = null;
		this._textArea = textarea;
		this._editMode = "wysiwyg";
		this.plugins = {};
		this._timerToolbar = null;
		this._timerUndo = null;
		this._undoQueue = new Array(this.config.undoSteps);
		this._undoPos = -1;
		this._customUndo = false;
		this._mdoc = document;
		this.doctype = '';
	}
};

HTMLArea2.onload=function() {};
HTMLArea2._scripts = [];
HTMLArea2.loadScript = function(url,plugin) {
	if(plugin) url = HTMLArea2.getPluginDir(plugin) + '/' + url;
	this._scripts.push(url);
};

HTMLArea2.init=function() { 
	var head = document.getElementsByTagName("head")[0];
	var current = 0;
	var savetitle = document.title;
	var evt = HTMLArea2.is_ie ? "onreadystatechange" : "onload";	
	function loadNextScript()
	{
		if(current>0&&HTMLArea2.is_ie&&!/loaded|complete/.test(window.event.srcElement.readyState)) return;
		if(current<HTMLArea2._scripts.length) {
			var url = HTMLArea2._scripts[current++];
			document.title = "[HTMLArea2: 스크립트 로딩 " + current + "/" + HTMLArea2._scripts.length + "]";
			var script = document.createElement("script");
			script.type = "text/javascript";
			script.src = url;
			script[evt] = loadNextScript;
			head.appendChild(script);
		} else {
			document.title = savetitle;
			HTMLArea2.onload();
		}
	};
	loadNextScript();
};

// 설정 스크립트 로드
HTMLArea2.loadScript(_editor2_url+"config/dialog.js");
HTMLArea2.loadScript(_editor2_url+"config/popupwin.js");
HTMLArea2.loadScript(_editor2_url+"config/colors.js");
HTMLArea2.loadScript(_editor2_url+"lang/"+_editor2_lang+".js");
HTMLArea2.RE_tagName = /(<\/|<)\s*([^\t\n>]+)/ig;
HTMLArea2.RE_doctype = /(<!doctype((.|\n)*?)>)\n?/i;HTMLArea2.RE_head=/<head>((.|\n)*?)<\/head>/i;
HTMLArea2.RE_body = /<body>((.|\n)*?)<\/body>/i;

HTMLArea2.Config = function()
{
	this.version = "3.0";
	this.width = "650"; // 에디터 너비
	//this.height = "auto"; // 에디터 높이
	this.height = "250"; // 에디터 높이
	this.statusBar = false; // 스테이터스 바의 생성
	this.htmlareaPaste = false;
	this.undoSteps = 20; // 실행취소의 횟수(queue)
	this.undoTimeout = 100; // 실행취소의 시간간격 500= 1/2 초
	this.sizeIncludesToolbar = true;
	this.fullPage = true; // 에디터영역전체사용(false시 텍스트부분만 포커스됨)
	this.pageStyle = "";
	this.killWordOnPaste = true;
	this.makeLinkShowsTarget = true;
	//this.baseURL = document.baseURI||document.URL; // 에디터의 기본경로
	this.baseURL = "";
	if(this.baseURL&&this.baseURL.match(/(.*)\/([^\/]+)/)) this.baseURL=RegExp.$1+"/";
	this.imgURL = "images/";
	this.popupURL = "popups/";
	this.htmlRemoveTags = null;

	// 에디터에서 사용할 툴바
	// 에디터 초기 설정
	/*
	this.toolbar2 = 
	[	
		["fontname2","space","fontsize","space","formatblock2","space","bold","italic","underline",
		"strikethrough","separator","subscript","superscript","separator","copy","cut","paste",
		"space","undo","redo","space","removeformat","killword"
		],
	
		["justifyleft","justifycenter","justifyright","justifyfull","separator","lefttoright","righttoleft","separator",
		"orderedlist","unorderedlist","outdent","indent","separator","forecolor","hilitecolor","separator",
		"inserthorizontalrule","createlink","insertimage","inserttable","toggletableborders","htmlmode",
		"separator","popupeditor","separator","showhelp","about"
		]
	];
	*/
	// 수정한 설정 [첫번째 라인] , [두번째라인]
	this.toolbar2 = 
	[	
		["undo", "redo", "separator", 
		"inserthorizontalrule", "createlink", "insertimage", "inserttable", "toggletableborders", "separator", 
		"lefttoright", "righttoleft", "separator", 
		"orderedlist", "unorderedlist", "outdent", "indent", "separator", 
		"copy", "cut", "paste", "separator", 
		"justifyleft", "justifycenter", "justifyright", "justifyfull", "separator"		
		],
	
		["fontname2", "space", "fontsize", "space", "formatblock2", "separator", 
		"bold", "italic", "underline", "strikethrough", "subscript", "superscript", "separator", 
		"forecolor", "hilitecolor", "separator", 
		"removeformat", "separator", "htmlmode", "separator"
		]
	];	
	// 폰트정의
	/*
	this.fontname2 = {
		"&mdash; font &mdash;":'',
		"Arial":'arial,helvetica,sans-serif',
		"Courier New":'courier new,courier,monospace',
		"Georgia":'georgia,times new roman,times,serif',
		"Tahoma":'tahoma,verdana,arial,helvetica,sans-serif',
		"Times New Roman":'times new roman,times,serif',
		"Verdana":'verdana,tahoma,arial,helvetica,sans-serif',
		"impact":'impact',
		"WingDings":'wingdings'
	};
	*/
	this.fontname2 = {
		"기본 글꼴" : '굴림,굴림체',
		"굴림" : '굴림',
		"굴림체" : '굴림체',
		"궁서" : '궁서',
		"궁서체" : '궁서체',
		"돋움" : '돋움',
		"돋움체" : '돋움체',
		"바탕" : '바탕',
		"바탕체" : '바탕체'
	};
	// 폰트사이즈정의	
	/*
	this.fontsize = {
		"&mdash; size &mdash;":"",
		"1 (8 pt)":"1",
		"2 (10 pt)":"2",
		"3 (12 pt)":"3",
		"4 (14 pt)":"4",
		"5 (18 pt)":"5",
		"6 (24 pt)":"6",
		"7 (36 pt)":"7"
	};
	*/
	this.fontsize = {
		"보통" : "3",
		"1 (8 pt)" : "1",
		"2 (10 pt)" : "2",
		"3 (12 pt)" : "3",
		"4 (14 pt)" : "4",
		"5 (18 pt)" : "5",
		"6 (24 pt)" : "6",
		"7 (36 pt)" : "7"
	};

	// 폰트형식정의
	/*
	this.formatblock2 = {
		"&mdash; format &mdash;":"",
		"Heading 1":"h1",
		"Heading 2":"h2",
		"Heading 3":"h3",
		"Heading 4":"h4",
		"Heading 5":"h5",
		"Heading 6":"h6",
		"Normal":"p",
		"Address":"address",
		"Formatted":"pre"
	};
	*/
	this.formatblock2 = {
		"보통" : "p",
		"제목 1" : "h1",
		"제목 2" : "h2",
		"제목 3" : "h3",
		"제목 4" : "h4",
		"제목 5" : "h5",
		"제목 6" : "h6",
		"보통" : "p",
		"주소" : "address",
		"형식유지" : "pre"
	};	
	this.customSelects = {};	
	function cut_copy_paste(e,cmd,obj) {
		e.execCommand(cmd);
	};	
	this.debug = false;
	this.btnList = 
	{
		bold:["Bold","ed_format_bold.gif",false,function(e){e.execCommand("bold");}],
		italic:["Italic","ed_format_italic.gif",false,function(e){e.execCommand("italic");}],
		underline:["Underline","ed_format_underline.gif",false,function(e){e.execCommand("underline");}],
		strikethrough:["Strikethrough","ed_format_strike.gif",false,function(e){e.execCommand("strikethrough");}],
		subscript:["Subscript","ed_format_sub.gif",false,function(e){e.execCommand("subscript");}],
		superscript:["Superscript","ed_format_sup.gif",false,function(e){e.execCommand("superscript");}],
		justifyleft:["Justify Left","ed_align_left.gif",false,function(e){e.execCommand("justifyleft");}],
		justifycenter:["Justify Center","ed_align_center.gif",false,function(e){e.execCommand("justifycenter");}],
		justifyright:["Justify Right","ed_align_right.gif",false,function(e){e.execCommand("justifyright");}],
		justifyfull:["Justify Full","ed_align_justify.gif",false,function(e){e.execCommand("justifyfull");}],
		orderedlist:["Ordered List","ed_list_num.gif",false,function(e){e.execCommand("insertorderedlist");}],
		unorderedlist:["Bulleted List","ed_list_bullet.gif",false,function(e){e.execCommand("insertunorderedlist");}],
		outdent:["Decrease Indent","ed_indent_less.gif",false,function(e){e.execCommand("outdent");}],
		indent:["Increase Indent","ed_indent_more.gif",false,function(e){e.execCommand("indent");}],
		forecolor:["Font Color","ed_color_fg.gif",false,function(e){e.execCommand("forecolor");}],
		hilitecolor:["Background Color","ed_color_bg.gif",false,function(e){e.execCommand("hilitecolor");}],
		inserthorizontalrule:["Horizontal Rule","ed_hr.gif",false,function(e){e.execCommand("inserthorizontalrule");}],
		createlink:["Insert Web Link","ed_link.gif",false,function(e){e.execCommand("createlink",true);}],
		insertimage:["Insert/Modify Image","ed_image.gif",false,function(e){e.execCommand("insertimage");}],
		inserttable:["Insert Table","insert_table.gif",false,function(e){e.execCommand("inserttable");}],
		toggletableborders:["Toggle table guidelines","ed_table_borders.gif",false,function(e){e.execCommand("toggletableborders");}],
		htmlmode:["Toggle HTML Source","ed_html.gif",true,function(e){e.execCommand("htmlmode");}],
		popupeditor:["Enlarge Editor","fullscreen_maximize.gif",true,function(e){e.execCommand("popupeditor");}],
		about:["About this editor","ed_about.gif",true,function(e){e.execCommand("about");}],
		showhelp:["Help using editor","ed_help.gif",true,function(e){e.execCommand("showhelp");}],
		undo:["Undoes your last action","ed_undo.gif",false,function(e){e.execCommand("undo");}],
		redo:["Redoes your last action","ed_redo.gif",false,function(e){e.execCommand("redo");}],
		cut:["Cut selection","ed_cut.gif",false,cut_copy_paste],
		copy:["Copy selection","ed_copy.gif",false,cut_copy_paste],
		paste:["Paste from clipboard","ed_paste.gif",false,cut_copy_paste],
		lefttoright:["Direction left to right","ed_left_to_right.gif",false,function(e){e.execCommand("lefttoright");}],
		righttoleft:["Direction right to left","ed_right_to_left.gif",false,function(e){e.execCommand("righttoleft");}],
		removeformat:["Remove formatting","ed_rmformat.gif",false,function(e){e.execCommand("removeformat");}],
		print:["Print document","ed_print.gif",false,function(e){e._iframe.contentWindow.print();}],
		killword:["Clear MSOffice tags","ed_killword.gif",false,function(e){e.execCommand("killword");}]
	};
	
	for(var i in this.btnList)
	{
		var btn = this.btnList[i];
		btn[1] = _editor2_url + this.imgURL + btn[1];		
		if(typeof HTMLArea2.I18N.tooltips[i] != "undefined") {
			if(/^(cut|copy|paste)$/.test(i)&&HTMLArea2.is_gecko&&HTMLArea2.I18N.tooltips[i+'_ff'])i = i +'_ff';
			btn[0] = HTMLArea2.I18N.tooltips[i];
		}
	}
};

HTMLArea2.Config.prototype.registerButton = function(id,tooltip,image,textMode,action,context)
{
	var the_id;
	if(typeof id=="string") {
		the_id = id;
	} else if(typeof id=="object") {
		the_id = id.id;
	} else {
		alert("에러 [HTMLArea2.Config::registerButton]:\n유효하지 않은 변수[버튼]입니다.");
		return false;
	}	
	if(typeof this.customSelects[the_id] != "undefined"){}	
	if(typeof this.btnList[the_id] != "undefined"){}	
	switch(typeof id)
	{
		case "string": return this.btnList[id] = [tooltip,image,textMode,action,context];
		case "object": return this.btnList[id.id] = [id.tooltip,id.image,id.textMode,id.action,id.context];
	}
};

HTMLArea2.Config.prototype.registerDropdown = function(object)
{
	if(typeof this.customSelects[object.id] != "undefined"){}
	if(typeof this.btnList[object.id] != "undefined"){}	
	this.customSelects[object.id]=object;
};

HTMLArea2.Config.prototype.hideSomeButtons = function(remove)
{
	var toolbar2 = this.toolbar2;
	for(var i=toolbar2.length;--i>=0;)
	{
		var line = toolbar2[i];
		for(var j=line.length;--j>=0;)
		{
			if(remove.indexOf(" "+line[j]+" ")>=0) {
				var len = 1;
				if(/separator|space/.test(line[j+1])) {
					len=2;
				}
				line.splice(j,len);
			}
		}
	}
};

HTMLArea2.replaceAll = function(config)
{
	var tas = document.getElementsByTagName("textarea");
	for(var i=tas.length;i>0;(new HTMLArea2(tas[--i],config)).generate());
};

HTMLArea2.replace = function(id,config) 
{
	var ta = HTMLArea2.getElementById("textarea",id);
	return ta?(new HTMLArea2(ta,config)).generate():null;
};

// 툴바생성
HTMLArea2.prototype._createToolbar = function()
{
	var editor2 = this;
	var toolbar2 = document.createElement("div");
	if(HTMLArea2.is_ie) toolbar2.style.width="650";
	HTMLArea2._addEvents(toolbar2,["mousedown","mouseup"],function(ev){
		var tgt;
		if(HTMLArea2.is_ie){
			ev=window.event;tgt=ev.srcElement;
		}else tgt=ev.target;
		if(tgt===toolbar2||tgt.disabled||tgt.parentNode.disabled){
			editor2.updateToolbar();
			HTMLArea2._stopEvent(ev);
			return false;
		}
	});
	this._toolbar2=toolbar2;
	toolbar2.className="toolbar2";
	toolbar2.unselectable="1";
	var tb_row=null;
	var tb_objects=new Object();
	this._toolbar2Objects=tb_objects;
	function newLine(){
		var table=document.createElement("table");
		table.border="0px";
		table.cellSpacing="0px";
		table.cellPadding="0px";
		toolbar2.appendChild(table);
		var tb_body=document.createElement("tbody");
		table.appendChild(tb_body);
		tb_row=document.createElement("tr");
		tb_body.appendChild(tb_row);
	};
	newLine();
	function setButtonStatus(id,newval){
		var oldval=this[id];
		var el=this.element;
		if(oldval!=newval){
			switch(id){
				case "enabled":
					if(newval){
						HTMLArea2._removeClass(el,"buttonDisabled");el.disabled=false;
					}else{
						HTMLArea2._addClass(el,"buttonDisabled");
						el.disabled=true;
					}
				break;
				case "active":
					if(newval){
						HTMLArea2._addClass(el,"buttonPressed");
					}else{
						HTMLArea2._removeClass(el,"buttonPressed");
					}
					break;
			}
			this[id]=newval;
		}
	};
	function createSelect(txt){
		var options=null;
		var el=null;
		var cmd=null;
		var customSelects=editor2.config.customSelects;
		var context=null;
		var tooltip="";
		switch(txt){
			case "fontsize":
			case "fontname2":
			case "formatblock2":
				options=editor2.config[txt];
				cmd=txt;
				break;
			default:
				cmd=txt;
				var dropdown=customSelects[cmd];
				if(typeof dropdown!="undefined"){
					options=dropdown.options;
					context=dropdown.context;
					if(typeof dropdown.tooltip!="undefined"){
						tooltip=dropdown.tooltip;
					}
				}else{
					alert("ERROR [createSelect]:\nCan't find the requested dropdown definition");
				}
				break;
		}
		if(options){
			el=document.createElement("select");
			el.title=tooltip;
			var obj={name:txt,element:el,enabled:true,text:false,cmd:cmd,state:setButtonStatus,context:context};
			tb_objects[txt]=obj;
			for(var i in options){
				var op=document.createElement("option");
				op.innerHTML=i;
				op.value=options[i];
				el.appendChild(op);
			}
			HTMLArea2._addEvent(el,"change",function(){
				editor2._comboSelected(el,txt);
			});
		}
		return el;
	};
	function createButton(txt){
		var el=null;
		var btn=null;
		switch(txt){
			case "separator":
				el=document.createElement("div");
				el.className="separator";
				break;
			case "space":
				el=document.createElement("div");
				el.className="space";
				break;
			case "linebreak":
				newLine();
				return false;
			case "textindicator":
				el=document.createElement("div");
				el.appendChild(document.createTextNode("A"));
				el.className="indicator";
				el.title=HTMLArea2.I18N.tooltips.textindicator;
				var obj={name:txt,element:el,enabled:true,active:false,text:false,cmd:"textindicator",state:setButtonStatus};
				tb_objects[txt]=obj;
				break;
			default:
				btn=editor2.config.btnList[txt];
		}
		if(!el&&btn){
			el=document.createElement("div");
			el.title=btn[0];
			el.className="button";
			var obj={name:txt,element:el,enabled:true,active:false,text:btn[2],cmd:btn[3],state:setButtonStatus,context:btn[4]||null};
			tb_objects[txt]=obj;
			HTMLArea2._addEvent(el,"mouseover",function(){if(obj.enabled){HTMLArea2._addClass(el,"buttonHover");}});
			HTMLArea2._addEvent(el,"mouseout",function(){if(obj.enabled)with(HTMLArea2){_removeClass(el,"buttonHover");_removeClass(el,"buttonActive");(obj.active)&&_addClass(el,"buttonPressed");}});
			HTMLArea2._addEvent(el,"mousedown",function(ev){if(obj.enabled)with(HTMLArea2){_addClass(el,"buttonActive");_removeClass(el,"buttonPressed");_stopEvent(is_ie?window.event:ev);}});
			HTMLArea2._addEvent(el,"click",function(ev){if(obj.enabled)with(HTMLArea2){_removeClass(el,"buttonActive");_removeClass(el,"buttonHover");obj.cmd(editor2,obj.name,obj);_stopEvent(is_ie?window.event:ev);}});
			var img=document.createElement("img");
			img.src=btn[1];
			img.style.width="18px";
			img.style.height="18px";
			if(HTMLArea2.is_ie)img.ondragstart=HTMLArea2.do_false;el.appendChild(img);
		}else if(!el){
			el=createSelect(txt);
		}
		if(el){
			var tb_cell=document.createElement("td");
			tb_row.appendChild(tb_cell);
			tb_cell.appendChild(el);
		}else{
			alert("FIXME: Unknown toolbar2 item: "+txt);
		}
		return el;
	};
	var first=true;
	for(var i=0;i<this.config.toolbar2.length;++i){
		if(!first){
			createButton("linebreak");
		}else{
			first=false;
		}
		var group=this.config.toolbar2[i];
		for(var j=0;j<group.length;++j){
			var code=group[j];
			if(/^([IT])\[(.*?)\]/.test(code)){
				var l7ed=RegExp.$1=="I";
				var label=RegExp.$2;
				if(l7ed){label=HTMLArea2.I18N.custom[label];}
				var tb_cell=document.createElement("td");
				tb_row.appendChild(tb_cell);
				tb_cell.className="label";
				tb_cell.innerHTML=label;
			}else{
				createButton(code);
			}
		}
	}
	this._htmlArea.appendChild(toolbar2);
};

HTMLArea2.prototype._createStatusBar = function()
{
	var statusbar = document.createElement("div");
	statusbar.className = "statusBar";
	this._htmlArea.appendChild(statusbar);
	this._statusBar=statusbar;
	div = document.createElement("span");
	div.className = "statusBarTree";
	div.innerHTML = HTMLArea2.I18N.msg["Path"]+": ";
	this._statusBarTree = div;
	this._statusBar.appendChild(div);
	if(!this.config.statusBar) {
		statusbar.style.display="none";
	}
};

HTMLArea2.prototype.generate = function()
{
	var editor2 = this;
	var textarea = this._textArea;
	if(typeof textarea=="string") {
		this._textArea = textarea = HTMLArea2.getElementById("textarea",textarea);
	}
	this._ta_size={w:textarea.offsetWidth,h:textarea.offsetHeight};
	textarea.style.display = "none";
	var htmlarea = document.createElement("div");
	htmlarea.className = "htmlarea";
	this._htmlArea = htmlarea;
	textarea.parentNode.insertBefore(htmlarea,textarea);
	if(textarea.form) {
		var f = textarea.form;
		if(typeof f.onsubmit == "function") {
			var funcref = f.onsubmit;
			if(typeof f.__msh_prevOnSubmit == "undefined") {
				f.__msh_prevOnSubmit = [];
			}
			f.__msh_prevOnSubmit.push(funcref);
		}
		f.onsubmit = function() {
			editor2._textArea.value = editor2.getHTML();
			var a = this.__msh_prevOnSubmit;
			if(typeof a!="undefined") {
				for(var i=a.length;--i>=0;)
				{
					a[i]();
				}
			}
		};		
		if(typeof f.onreset=="function") {
			var funcref = f.onreset;
			if(typeof f.__msh_prevOnReset == "undefined") {
				f.__msh_prevOnReset = [];
			}
			f.__msh_prevOnReset.push(funcref);
		}
		f.onreset=function()
		{
			editor2.setHTML(editor2._textArea.value);
			editor2.updateToolbar();
			var a = this.__msh_prevOnReset;
			if(typeof a!="undefined") {
				for(var i=a.length;--i>=0;)
				{
					a[i]();
				}
			}
		};
	}
	try { window.onunload=function() { editor2._textArea.value = editor2.getHTML(); }; }
	catch(e) {};	
	this._createToolbar();
	htmlarea.appendChild(textarea);
	var iframe = document.createElement("iframe");
	iframe.src = HTMLArea2.is_ie?"javascript:false;":"about:blank";
	htmlarea.appendChild(iframe);
	this._iframe = iframe;
	this._createStatusBar();	
	if(!HTMLArea2.is_ie) {
		iframe.style.borderWidth = "0";
	}	
	var height = this.config.height, width = this.config.width;
	if(height=="auto") height = this._ta_size.h;
	if(height==parseInt(height,10)) {
		if(this.config.sizeIncludesToolbar) {
			height -= this._toolbar2.offsetHeight;
			height -= this._statusBar.offsetHeight;
		}
		if(height<0) height=0;height+="px";
	}
	if(width == "auto")	width = this._ta_size.w;
	if(width == parseInt(width,10)) width += "px";
	iframe.style.width = width;
	iframe.style.height = height;
	textarea.style.width = width;
	textarea.style.height = height;	
	function initIframe() {
		var doc = editor2._iframe.contentWindow.document;
		if(!doc){
			if(HTMLArea2.is_gecko) {
				setTimeout(initIframe,100);
				return false;
			} else {
				alert("에러: IFRAME을 초기화 할 수 없습니다.");
			}
		}		
		if(HTMLArea2.is_midas) {
			doc.designMode = "on";
		}
		editor2._doc = doc;
		if(!editor2.config.fullPage) {
			doc.open();
			var html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" ' + 
			'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'+"<html>\n";
			html += "<head>\n";
			if(editor2.config.baseURL) html += '<base href="'+editor2.config.baseURL+'" />';
			html += "<link rel='stylesheet' href='"+_editor2_url+"css/iframe.css' />";
			html += "<style type='text/css'>"+editor2.config.pageStyle+" html,body { border: 0px; }</style>\n";
			html += "</head>\n";
			html += "<body class='msh_htmlarea'>\n";
			html += editor2._textArea.value;
			html += "</body>\n";
			html += "</html>";
			doc.write(html);
			doc.close();
		} else {
			var html = editor2._textArea.value;
			if(html.match(HTMLArea2.RE_doctype)) {
				editor2.setDoctype(RegExp.$1);
				html=html.replace(HTMLArea2.RE_doctype,"");
			}
			doc.open();
			doc.write(html);
			doc.close();
		}
		if(HTMLArea2.is_ie) {
			doc.body.contentEditable = true;
		}	
		HTMLArea2._addEvents(doc,["keydown","keypress","mousedown","mouseup","drag"],function(event)
		{
			return editor2._editorEvent(HTMLArea2.is_ie?editor2._iframe.contentWindow.event:event);
		});	
		for(var i in editor2.plugins)
		{
			var plugin = editor2.plugins[i].instance;
			if(typeof plugin.onGenerate == "function")
				plugin.onGenerate();
			if(typeof plugin.onGenerateOnce == "function") {
				plugin.onGenerateOnce();
				plugin.onGenerateOnce = null;
			}
		}	
		var timer = setInterval(function()
		{
			if(editor2._doc.body) {
				if(/\S/.test(editor2._textArea.value)) {
					editor2.convertSemanticTags(true);
					editor2._wordClean();
				} else editor2.execCommand("formatblock2",false,"p");
				editor2.updateToolbar();
				window.focus();
				editor2.focusEditor();
				clearInterval(timer);
			}
		},100);	
		if(typeof editor2.onGenerate == "function") editor2.onGenerate();
	};
	setTimeout(initIframe,100);
};

HTMLArea2.prototype.setMode = function(mode)
{
	if(typeof mode == "undefined") {		
		mode = ((this._editMode=="textmode")?"wysiwyg":"textmode");
	}	
	switch(mode)
	{
		case "textmode":
			this._textArea.value = this.getHTML();
			this._iframe.style.display = "none";
			this._textArea.style.display = "block";
			if(this.config.statusBar) {
				this._statusBar.innerHTML = HTMLArea2.I18N.msg["TEXT_MODE"];
			}
			break;
		case "wysiwyg":
			if(HTMLArea2.is_midas) {
				try	{ this._doc.designMode = "off"; }
				catch(e) {};
			}			
			if(!this.config.fullPage) this._doc.body.innerHTML = this.getHTML();
			else this.setFullHTML(this.getHTML());
			this._iframe.style.display="block";
			this._textArea.style.display="none";
			if(HTMLArea2.is_midas) {
				try { this._doc.designMode="on"; }
				catch(e) {};
			}
			if(this.config.statusBar) {
				this._statusBar.innerHTML = '';
				this._statusBar.appendChild(this._statusBarTree);
			}
			this.convertSemanticTags(true);
			break;
		default:
			alert("Mode <"+mode+"> 가 정의되지 않았습니다.");
			return false;
	}	
	this._editMode = mode;
	this.focusEditor();
	for(var i in this.plugins)
	{
		var plugin = this.plugins[i].instance;
		if(typeof plugin.onMode == "function") plugin.onMode(mode);
	}
};

HTMLArea2.prototype.setFullHTML = function(html)
{
	var save_multiline = RegExp.multiline;
	RegExp.multiline = true;
	if(html.match(HTMLArea2.RE_doctype)) {
		this.setDoctype(RegExp.$1);
		html = html.replace(HTMLArea2.RE_doctype,"");
	}
	RegExp.multiline = save_multiline;
	if(!HTMLArea2.is_ie) {
		if(html.match(HTMLArea2.RE_head))
			this._doc.getElementsByTagName("head")[0].innerHTML = RegExp.$1;
		if(html.match(HTMLArea2.RE_body))
			this._doc.getElementsByTagName("body")[0].innerHTML = RegExp.$1;
	} else {
		var html_re = /<html>((.|\n)*?)<\/html>/i;
		html = html.replace(html_re,"$1");
		this._doc.open();
		this._doc.write(html);
		this._doc.close();
		this._doc.body.contentEditable = true;
		return true;
	}
};

HTMLArea2.prototype.registerPlugin = function()
{
	var plugin = arguments[0];
	var args = [];
	for(var i=1;i<arguments.length;++i)
		args.push(arguments[i]);this.registerPlugin2(plugin,args);
};

HTMLArea2.prototype.registerPlugin2 = function(plugin,args)
{
	if(typeof plugin == "string") plugin = eval(plugin);	
	if(typeof plugin=="undefined") {
		return false;
	}
	var obj = new plugin(this,args);
	if(obj) {
		var clone = {};
		var info = plugin._pluginInfo;		
		for(var i in info) clone[i] = info[i];
		clone.instance = obj;
		clone.args = args;
		this.plugins[plugin._pluginInfo.name] = clone;
	} else alert("플러그인을 등록 할 수 없습니다. >> "+plugin.toString()+".");
};
	
HTMLArea2.getPluginDir = function(pluginName)
{
	return _editor2_url + "plugins/" + pluginName;
};

HTMLArea2.loadPlugin = function(pluginName)
{
	var dir = this.getPluginDir(pluginName);
	var plugin = pluginName.replace(/([a-z])([A-Z])([a-z])/g,function(str,l1,l2,l3)
	{
		return l1+"-"+l2.toLowerCase()+l3;
	}).toLowerCase() + ".js";	
	var plugin_file = dir + "/" + plugin;
	var plugin_lang = dir + "/lang/" + _editor2_lang + ".js";
	this.loadScript(plugin_file);
	this.loadScript(plugin_lang);
};

HTMLArea2.loadStyle = function(style,plugin)
{
	var url = _editor2_url||'';
	if(typeof plugin!="undefined") {
		url += "plugins/" + plugin + "/";
	}
	url += style;	
	if(/^\x2f/.test(style)) url = style;	
	var head = document.getElementsByTagName("head")[0];
	var link = document.createElement("link");
	link.rel = "stylesheet";
	link.href = url;
	head.appendChild(link);
};

HTMLArea2.loadStyle(typeof _editor2_css=="string"?_editor2_css:"css/htmlarea.css");

HTMLArea2.prototype.debugTree = function()
{
	var ta = document.createElement("textarea");
	ta.style.width = "100%";
	ta.style.height = "20em";
	ta.value = "";	
	function debug(indent,str)
	{
		for(;--indent>=0;) ta.value+=" ";
		ta.value+=str+"\n";
	};	
	function _dt(root,level)
	{
		var tag = root.tagName.toLowerCase(),i;
		var ns = HTMLArea2.is_ie?root.scopeName:root.prefix;debug(level,"- "+tag+" ["+ns+"]");		
		for(i=root.firstChild;i;i=i.nextSibling)
			if(i.nodeType==1)_dt(i,level+2);
	};	
	_dt(this._doc.body,0);
	document.body.appendChild(ta);
};

HTMLArea2.getInnerText = function(el)
{
	var txt = '',i;
	for(i=el.firstChild;i;i=i.nextSibling)
	{
		if(i.nodeType == 3) txt += i.data;
		else if(i.nodeType==1) txt += HTMLArea2.getInnerText(i);
	}
	return txt;
};

HTMLArea2.prototype.collapsed = function()
{
	var sel = this._getSelection(),range=this._createRange(sel);
	if(HTMLArea2.is_ie)
		return range.compareEndPoints("StartToEnd",range)==0;
	else 
		return range.collapsed;
};

HTMLArea2.prototype.flatRange = function()
{
	var df,sel = this._getSelection(),range = this._createRange(sel),tmp;
	if(HTMLArea2.is_ie) {
		if(sel.type == "Control") return false;		
		try {
			tmp = document.createElement("div");
			tmp.innerHTML = range.htmlText;
		} catch(e) {
			return false;
		}
		if(tmp.childNodes.length>1) return false;
	} else  {
		try
		{
			df = range.cloneContents();
			if(range.startContainer.nodeType == 1 && range.endContainer.nodeType == 1) df = df.firstChild;
			if(df) {
				if(/^img$/i.test(df.tagName)&&!df.nextSibling) return false;
				while(df.firstChild) if(df.removeChild(df.firstChild).nodeType==1) return false;
			}
		} catch(e) {};
		return true;
	}
};

HTMLArea2.prototype._wordClean = function(want_stats)
{
	var body = this._doc.body;
	var stats = {
		empty_tags:0,
		mso_class:0,
		mso_style:0,
		mso_xmlel:0,
		orig_len:body.innerHTML.length,
		T:(new Date()).getTime()
	},	
	stats_txt = {
		empty_tags:"Empty tags removed: ",
		mso_class:"MSO class names removed: ",
		mso_style:"MSO inline style removed: ",
		mso_xmlel:"MSO XML elements stripped: "
	};	
	function showStats()
	{
		var txt = "Word cleaner stats: \n\n";
		for(var i in stats)
			if(stats_txt[i]) txt += stats_txt[i] + stats[i] + "\n";
		
		txt += "\nInitial document length: " + stats.orig_len + "\n";
		txt += "Final document length: " + body.innerHTML.length + "\n";
		txt += "Clean-up took " + (((new Date()).getTime()-stats.T)/1000) + " seconds";
		alert(txt);
	};	
	function clearClass(node)
	{
		var newc = node.className.replace(/(^|\s)mso.*?(\s|$)/ig,' ');
		if(newc!=node.className) {
			node.className = newc;
			if(!/\S/.test(node.className)) {
				node.removeAttribute("className");
				++stats.mso_class;
			}
		}
	};	
	function clearStyle(node)
	{
		var declarations = node.style.cssText.split(/\s*;\s*/),line;
		for(var i=declarations.length;--i>=0;)
		{
			line = declarations[i];
			if(/^mso|^tab-stops|^layout-grid/i.test(line)||/^margin\s*:\s*[0-9]+..\s+[0-9]+..\s+[0-9]+../i.test(line)) {
				++stats.mso_style;declarations.splice(i,1);
			} else {
				declarations[i] = line.replace(/windowtext/,'#000');
			}
		}
		node.style.cssText = declarations.join("; ");
	};	
	function stripTag(el)
	{
		if(HTMLArea2.is_ie) el.outerHTML = HTMLArea2.htmlEncode(el.innerText);
		else
		{
			var txt = document.createTextNode(HTMLArea2.getInnerText(el));
			el.parentNode.insertBefore(txt,el);
			el.parentNode.removeChild(el);
		}
		++stats.mso_xmlel;
	};	
	function checkEmpty(el)
	{
		if(/^(a|span|b|strong|i|em|font)$/i.test(el.tagName)&&el.childNodes.length==0) {
			el.parentNode.removeChild(el);
			++stats.empty_tags;
		}
	};	
	function parseTree(root)
	{
		var tag = root.tagName.toLowerCase(),i,next;
		if((HTMLArea2.is_ie&&root.scopeName!='HTML')||(!HTMLArea2.is_ie&&/:/.test(tag))) {
			stripTag(root);
			return false;
		} else {
			clearClass(root);
			clearStyle(root);			
			for(i=root.firstChild;i;i=next)
			{
				next = i.nextSibling;
				if(i.nodeType==1&&parseTree(i))checkEmpty(i);
			}
		}
		return true;
	};
	parseTree(body);
	this.updateToolbar();
};

HTMLArea2.prototype.forceRedraw = function()
{
	this._doc.body.style.visibility = "hidden";
	this._doc.body.style.visibility = "visible";
};

HTMLArea2.prototype.focusEditor = function()
{
	switch(this._editMode)
	{
		case "wysiwyg":
			try { this._iframe.contentWindow.focus() }
			catch(e) {}
			break;			
		case "textmode":
			try { this._textArea.focus() }
			catch(e) {}
			break;
		default:
			alert("에러 : 모드 " + this._editMode + " 가 정의 되지 않았습니다.");
	}
	return this._doc;
};

HTMLArea2.prototype._undoTakeSnapshot = function()
{
	++this._undoPos;
	if(this._undoPos>=this.config.undoSteps) {
		this._undoQueue.shift();
		--this._undoPos;
	}
	var take = true;
	var txt = this.getInnerHTML();
	if(this._undoPos>0) take = (this._undoQueue[this._undoPos-1]!=txt);
	if(take) {
		this._undoQueue[this._undoPos]=txt;
	} else {
		this._undoPos--;
	}
};

HTMLArea2.prototype.undo = function()
{
	if(this._undoPos>0) {
		var txt = this._undoQueue[--this._undoPos];
		if(txt)this.setHTML(txt);
		else++this._undoPos;
	}
};

HTMLArea2.prototype.redo = function()
{
	if(this._undoPos < this._undoQueue.length - 1) {
		var txt = this._undoQueue[++this._undoPos];
		if(txt) this.setHTML(txt);
		else --this._undoPos;
	}
};

HTMLArea2.prototype.resetStatusBar = function(txt)
{
	if(this.config.statusBar) {
		var b = this._statusBarTree;
		while(b.firstChild)b.removeChild(b.lastChild);
		if(!txt)txt = '-';
		b.appendChild(document.createTextNode(txt));
	}
};

HTMLArea2.prototype.updateToolbar = function(noStatus)
{
	var doc = this._doc;
	var text = (this._editMode == "textmode");
	var ancestors = null;
	if(!text) {
		ancestors = this.getAllAncestors();
		if(this.config.statusBar&&!noStatus) {
			this.resetStatusBar(HTMLArea2.I18N.msg["Path"]+": ");
			for(var i=ancestors.length;--i>=0;)
			{
				var el = ancestors[i];
				if(!el) {
					continue;
				}
				var a = document.createElement("a");
				a.href = "#";
				a.el = el;
				a.editor2 = this;
				a.onclick = function() {
					this.blur();
					this.editor2.selectNodeContents(this.el);
					this.editor2.updateToolbar(true);
					return false;
				};
				a.ondblclick = function() {
					this.blur();
					this.editor2.selectNodeContents(this.el,null,true);
					this.editor2.updateToolbar(true);
					return false;
				};
				a.oncontextmenu = function() {
					this.blur();
					var info = "Inline style:\n\n";
					info += this.el.style.cssText.split(/;\s*/).join(";\n");
					alert(info);
					return false;
				};				
				var txt = el.tagName.toLowerCase();
				a.title = el.style.cssText;
				if(el.id) {
					txt += "#" + el.id;
				}
				var tmp = el.className.replace(/\s*_msh_[^\s]+\s*/,' ');
				if(/\S/.test(tmp))txt += "." + tmp;
				a.appendChild(document.createTextNode(txt));
				this._statusBarTree.appendChild(a);
				if(i!=0) {
					this._statusBarTree.appendChild(document.createTextNode(String.fromCharCode(0xbb)));
				}
			}
		}
	}
	
	for(var i in this._toolbar2Objects)
	{
		var btn = this._toolbar2Objects[i];
		var cmd = i;
		var inContext = true;
		if(btn.context&&!text) {
			inContext = false;
			var context = btn.context;
			var attrs = [];
			if(/(.*)\[(.*?)\]/.test(context)) {
				context = RegExp.$1;
				attrs = RegExp.$2.split(",");
			}
			context = context.toLowerCase();
			var match = (context=="*");
			for(var k=0;k<ancestors.length;++k)
			{
				if(!ancestors[k]) {
					continue;
				}
			if(match||(ancestors[k].tagName.toLowerCase()==context)) {
				inContext = true;
				for(var ka=0;ka<attrs.length;++ka)
				{
					if(!eval("ancestors[k]."+attrs[ka])) {
						inContext = false;break;
					}
				}
				if(inContext) {
					break;
				}
			}
		}
	}
	btn.state("enabled",(!text||btn.text)&&inContext);
	if(typeof cmd == "function") {
		continue;
	}
	var dropdown = this.config.customSelects[cmd];
	if((!text||btn.text)&&(typeof dropdown!="undefined")) {
		dropdown.refresh(this);
		continue;
	}	
	switch(cmd)
	{
		case "fontname2":
		case "fontsize":		
		case "formatblock2":
			if(!text) {
				try
				{
					var value = (""+doc.queryCommandValue(cmd)).toLowerCase();
					if(!value) {
						btn.element.selectedIndex = 0;
						break;
					}
					var options = this.config[cmd];
					var k = 0;
					for(var j in options)
					{
						if((j.toLowerCase()==value)||(options[j].substr(0,value.length).toLowerCase()==value)) {
							btn.element.selectedIndex = k;
							throw "ok";
						}
						++k;
					}
					btn.element.selectedIndex = 0;
				} catch(e){};
				break;
			}	
		case "textindicator":
			if(!text) {
				try
				{
					with(btn.element.style) {
						backgroundColor = HTMLArea2._makeColor(doc.queryCommandValue(HTMLArea2.is_ie?"backcolor":"hilitecolor"));
						if(/transparent/i.test(backgroundColor)) {
							backgroundColor = HTMLArea2._makeColor(doc.queryCommandValue("backcolor"));
						}
						color = HTMLArea2._makeColor(doc.queryCommandValue("forecolor"));
						fontFamily = doc.queryCommandValue("fontname2");
						fontWeight = doc.queryCommandState("bold")?"bold":"normal";
						fontStyle = doc.queryCommandState("italic")?"italic":"normal";
					}
				} catch(e){}
			}
			break;
		case "htmlmode":
			btn.state("active",text);
			break;		
		case "lefttoright":		
		case "righttoleft":
			var el = this.getParentElement();
			while(el&&!HTMLArea2.isBlockElement(el)) el = el.parentNode;
			if(el)btn.state("active",(el.style.direction==((cmd=="righttoleft")?"rtl":"ltr")));
			break;		
		case "toggletableborders":
			btn.state("active",this.css_tableBorders&&!this.css_tableBorders.disabled);
			break;		
		default:
			cmd = cmd.replace(/(un)?orderedlist/i,"insert$1orderedlist");
			try { btn.state("active",(!text&&doc.queryCommandState(cmd))); }
			catch(e) {}
		}
	}	
	if(this._customUndo&&!this._timerUndo) {
		this._undoTakeSnapshot();
		var editor2 = this;
		this._timerUndo = setTimeout(function(){editor2._timerUndo = null;},this.config.undoTimeout);
	}	
	for(var i in this.plugins)
	{
		var plugin = this.plugins[i].instance;
		if(typeof plugin.onUpdateToolbar == "function") plugin.onUpdateToolbar();
	}
	if(!HTMLArea2.is_ie) this.forceRedraw();
};

HTMLArea2.prototype.insertNodeAtSelection = function(toBeInserted)
{
	if(!HTMLArea2.is_ie) {
		var sel = this._getSelection();
		var range = this._createRange(sel);
		sel.removeAllRanges();
		range.deleteContents();
		range.insertNode(toBeInserted);
		range.selectNodeContents(toBeInserted);
		this.updateToolbar();
	} else {
		return null;
	}
};

HTMLArea2.prototype.getParentElement = function()
{
	var sel = this._getSelection();
	var range = this._createRange(sel);	
	if(HTMLArea2.is_ie) {
		switch(sel.type)
		{
			case "Text":			
			case "None": return range.parentElement();			
			case "Control": return range.item(0);
			default: return this._doc.body;
		}
	} else {
		try
		{
			var p = range.commonAncestorContainer;
			if(!range.collapsed&&range.startContainer == range.endContainer&&range.startOffset-range.endOffset<=1&&range.startContainer.hasChildNodes())
				p = range.startContainer.childNodes[range.startOffset];
			while(p.nodeType==3)
			{
				p = p.parentNode;
			}
			return p;
		}
		catch(e)
		{
			return null;
		}
	}	
};

HTMLArea2.prototype.getAllAncestors = function()
{
	var p = this.getParentElement();
	if(p&&p.nodeType==1) {
		if(HTMLArea2.is_gecko)
			this.convertSemanticTags(true,p);
		p = this.getParentElement();
	}
	var a = [];
	while(p&&(p.nodeType==1)&&(p.tagName.toLowerCase()!='body'))
	{
		a.push(p);
		p = p.parentNode;
	}
	a.push(this._doc.body);
	return a;
};

HTMLArea2.prototype.getAncestorsHash = function()
{
	var p = this.getAllAncestors(),el,i,tn,pnodes={};
	try
	{
		for(i=0;i<p.length;++i)
		{
			el = p[i];
			tn = el.tagName.toLowerCase();
			if(!pnodes[tn])
				pnodes[tn] = el;
		}
	}
	catch(e)
	{
	};
	return pnodes;
};

HTMLArea2.prototype.selectNodeContents = function(node,pos,inclusive)
{
	this.focusEditor();
	this.forceRedraw();
	var range;
	var collapsed = (typeof pos=="boolean");
	if(HTMLArea2.is_ie) {
		range = this._doc.body.createTextRange();
		range.moveToElementText(node);
		(collapsed)&&range.collapse(pos);
		range.select();
	} else {
		var sel = this._getSelection();
		range = this._doc.createRange();
		if(inclusive) range.selectNode(node);
		else  range.selectNodeContents(node);
		(collapsed)&&range.collapse(pos);
		sel.removeAllRanges();
		sel.addRange(range);
	}
};

HTMLArea2.prototype.insertHTML2 = function(html)
{
	var sel = this._getSelection();
	var range = this._createRange(sel);
	if(HTMLArea2.is_ie) {
		range.pasteHTML(html);
	} else {
		var fragment = this._doc.createDocumentFragment();
		var div = this._doc.createElement("div");
		div.innerHTML = html;
		while(div.firstChild)
		{
			fragment.appendChild(div.firstChild);
		}
		var node = this.insertNodeAtSelection(fragment);
	}
};

HTMLArea2.prototype.surroundHTML = function(startTag,endTag)
{
	var html = this.getSelectedHTML();
	this.insertHTML2(startTag+html+endTag);
};

HTMLArea2.prototype.getSelectedHTML = function()
{
	var sel = this._getSelection();
	var range = this._createRange(sel);
	var existing = null;
	if(HTMLArea2.is_ie) {
		existing = range.htmlText;
	} else {
		existing = HTMLArea2.getHTML(range.cloneContents(),false,this);
	}
	return existing;
};

HTMLArea2.prototype.hasSelectedText = function()
{
	return this.getSelectedHTML()!='';
};

HTMLArea2.prototype._makeLink = function(url)
{
	var sel,range;
	this._doc.execCommand("createlink",false,url);
	sel = this._getSelection();
	range = this._createRange(sel);
	if(HTMLArea2.is_ie) {
		if(sel.type == "Text") {
			range.moveEnd("character",-1);
			link = range.parentElement();
		} else link=range.item(0).parentNode;
	} else {
		link = range.startContainer;
		if(!/^a$/i.test(link.tagName)) {
			link = link.nextSibling;
			if(!link) link = range.startContainer.parentNode;
		}
	}
	return link;
};

HTMLArea2.prototype.createAnchor = function(name)
{
	var a = this._makeLink("#");
	if(a&&a.tagName.toLowerCase() == "a") {
		a.removeAttribute("href");
		a.setAttribute("name",name);
		a.setAttribute("id",name);
		a.className="htmlarea-anchor";
	}
};

HTMLArea2.prototype._createLink = function(link)
{
	var editor2 = this;
	var outparam = null;
	if(typeof link=="undefined") link = this.getAncestorsHash().a;
	if(!link) {
		var sel = editor2._getSelection();
		var range = editor2._createRange(sel);
		var compare = 0;
		if(HTMLArea2.is_ie) {
			if(sel.type == "Text") compare = range.compareEndPoints("StartToEnd",range);
			else if(sel.type=="Control") compare=(range.length==1);
		} else {
			compare = range.compareBoundaryPoints(range.START_TO_END,range);
		}
		if(compare==0) {
			alert(HTMLArea2.I18N.msg["Link-Text"]);
			return;
		}
		outparam = {f_href:'',f_title:'',f_target:'',f_usetarget:editor2.config.makeLinkShowsTarget};
	} else  {
		outparam = {
			f_href:HTMLArea2.is_ie?editor2.stripBaseURL(link.href):link.getAttribute("href"),
			f_title:link.title,
			f_target:link.target,
			f_usetarget:editor2.config.makeLinkShowsTarget
		};
	}	
	this._popupDialog("link.html",function(param)
	{
		if(!param) return false;
		var a = link;
		if(!a) a = editor2._makeLink(param.f_href);
		else
		{
			var href = param.f_href.trim();
			editor2.selectNodeContents(a);
			if(href=="") {
				editor2._doc.execCommand("unlink",false,null);
				editor2.updateToolbar();
				return false;
			} else a.href=href;
		}		
		if(!(a&&/^a$/i.test(a.tagName))) return false;		
		a.target = param.f_target.trim();
		a.title=param.f_title.trim();
		editor2.selectNodeContents(a);
		editor2.updateToolbar();
	},outparam);
};

HTMLArea2.prototype._insertImage = function(image)
{
	var editor2 = this;
	var outparam = null;	
	if(typeof image == "undefined") {
		image = this.getParentElement();		
		if(image&&!/^img$/i.test(image.tagName)) image=null;
	}		
	if(image)outparam = {f_base:editor2.config.baseURL,f_url:HTMLArea2.is_ie?editor2.stripBaseURL(image.src):image.getAttribute("src"),f_alt:image.alt,f_border:image.border,f_align:image.align,f_vert:image.vspace,f_horiz:image.hspace};
	this._popupDialog("insert_image.html",function(param)
	{
		if(!param) {
			return false;
		}
		var img = image;		
		if(!img)
		{
			var sel = editor2._getSelection();
			var range = editor2._createRange(sel);
			editor2._doc.execCommand("insertimage",false,param.f_url);			
			if(HTMLArea2.is_ie) {
				img = range.parentElement();				
				if(img.tagName.toLowerCase() != "img") {
					img = img.previousSibling;
				}
			} else {
				img = range.startContainer.previousSibling;
			}
		} else {
			img.src = param.f_url;
		}		
		for(var field in param)
		{
			var value = param[field];			
			switch(field)
			{
				case "f_alt":
					img.alt = value;
					break;					
				case "f_border":
					img.border = parseInt(value||"0");
					break;					
				case "f_align":
					img.align = value;
					break;					
				case "f_vert":
					img.vspace = parseInt(value||"0");
					break;					
				case "f_horiz":
					img.hspace = parseInt(value||"0");
					break;
			}
		}
	},outparam);
};

HTMLArea2.prototype._insertTable = function()
{
	var sel = this._getSelection();
	var range = this._createRange(sel);
	var editor2 = this;
	this._popupDialog("insert_table.html",function(param)
	{
		if(!param) {
			return false;
		}
		var doc = editor2._doc;
		var table = doc.createElement("table");
		table.style.borderCollapse = "collapse";		
		for(var field in param)
		{
			var value = param[field];
			if(!value) {
				continue;
			}			
			switch(field)
			{
				case "f_width":
					table.style.width = value+param["f_unit"];
					break;				
				case "f_align":
					table.align = value;
					break;					
				case "f_border":
					table.style.border = parseInt(value) + "px solid #000";
					break;				
				case "f_spacing":
					table.cellSpacing = parseInt(value);
					break;				
				case "f_padding":
					table.cellPadding = parseInt(value);
					break;
			}
		}		
		var cellwidth = 0;
		if(param.f_fixed) cellwidth = Math.floor(100/parseInt(param.f_cols));
		var tbody = doc.createElement("tbody");
		table.appendChild(tbody);
		for(var i=0;i<param["f_rows"];++i)
		{
			var tr = doc.createElement("tr");
			tbody.appendChild(tr);
			for(var j=0;j<param["f_cols"];++j)
			{
				var td = doc.createElement("td");
				td.style.border =table.style.border;
				if(cellwidth) td.style.width = cellwidth + "%";
				tr.appendChild(td);
				(HTMLArea2.is_midas)&&td.appendChild(doc.createElement("br"));
			}
		}
		if(HTMLArea2.is_ie) {
			range.pasteHTML(table.outerHTML);
		} else {
			editor2.insertNodeAtSelection(table);
		}
		return true;
	},null);
};

HTMLArea2.prototype._comboSelected = function(el,txt)
{
	this.focusEditor();
	var value = el.options[el.selectedIndex].value,tmp;
	switch(txt)
	{
		case "fontname2":		
		case "fontsize":		
		case "formatblock2":
			this.execCommand(txt,false,value);
			break;		
		default:
			var dropdown = this.config.customSelects[txt];		
			if(typeof dropdown!="undefined") {
				dropdown.action(this);
			} else {
				alert("FIXME : 코보박스 "+txt+" 를 수행할 수 없습니다.");
			}
	}
};

HTMLArea2.prototype.toggleTableBorders = function()
{
	var doc = this._doc,
	head = doc.getElementsByTagName("head")[0],
	css = this.css_tableBorders;	
	if(!css)
	{
		this.css_tableBorders = css = doc.createElement("link");
		css.type = "text/css";
		css.media = "all";
		css.rel = "stylesheet";
		css.href = _editor2_url + 'css/table-borders.css';
		head.appendChild(css);
	} else css.disabled=!css.disabled;
};

HTMLArea2.prototype.execCommand = function(cmdID,UI,param)
{
	var editor2 = this;
	this.focusEditor();
	cmdID = cmdID.toLowerCase();
	var styleCmd = /^(justify.*|lefttoright|righttoleft|.*color)$/.test(cmdID);	
	if(HTMLArea2.is_gecko) {}
	try { this._doc.execCommand('useCSS',false,!styleCmd);}
	catch(e){};	
	switch(cmdID)
	{
		case "toggletableborders":
			this.toggleTableBorders();
			break;		
		case "htmlmode":
			this.setMode();
			break;		
		case "hilitecolor":
			(HTMLArea2.is_ie)&&(cmdID="backcolor");		
		case "forecolor":
			this._popupDialog("select_color.html",function(color) {
				if(color) {
					editor2._doc.execCommand(cmdID,false,"#"+color);
				}
			},HTMLArea2._colorToRgb(this._doc.queryCommandValue(cmdID)));
			break;		
		case "createlink":
			this._createLink();
			break;		
		case "popupeditor":
			HTMLArea2._object = this;
			if(HTMLArea2.is_ie) {
				{window.open(this.popupURL("fullscreen.html"),"ha_fullscreen","toolbar2=no,location=no,directories=no,status=no,menubar=no,"+"scrollbars=no,resizable=yes,width=640,height=480");}
			} else {
				window.open(this.popupURL("fullscreen.html"),"ha_fullscreen","toolbar2=no,menubar=no,personalbar=no,width=640,height=480,"+"scrollbars=no,resizable=yes");
			}
			break;		
		case "undo":		
		case "redo":
			try
			{
				if(this._customUndo) this[cmdID]();
				else this._doc.execCommand(cmdID,UI,param);
			} catch(e) {};
			break;		
		case "inserttable":
			this._insertTable();
			break;		
		case "insertimage":
			this._insertImage();
			break;		
		case "about":
			this._popupDialog("about.html",null,this);
			break;		
		case "showhelp":
			window.open(_editor2_url+"reference.html","ha_help");
			break;		
		case "killword":
			this._wordClean(true);
			break;		
		case "formatblock2":
			if(HTMLArea2.is_ie)
				param = "<"+param+">";
			this._doc.execCommand(cmdID,UI,param);
			break;		
		case "cut":		
		case "copy":		
		case "paste":
			try
			{
				this._doc.execCommand(cmdID,UI,param);
				if(this.config.killWordOnPaste)
					this._wordClean();
			}
			catch(e)
			{
				if(HTMLArea2.is_gecko) {
					if(typeof HTMLArea2.I18N.msg["Moz-Clipboard"]=="undefined") {
						HTMLArea2.I18N.msg["Moz-Clipboard"] = 
						"보안문제로 인하여 잘라내기/복사/붙여넣기에 대한 스크립트 권한이 없습니다.\n" + 
						"mozilla.org의 기술노트를 참고 하시길 바랍니다.\n";
					}					
					if(confirm(HTMLArea2.I18N.msg["Moz-Clipboard"])) window.open("http://mozilla.org/editor/midasdemo/securityprefs.html");
				}
			}
			break;
		
		case "lefttoright":		
		case "righttoleft":
			var dir = (cmdID=="righttoleft")?"rtl":"ltr";
			var el = this.getParentElement();
			while(el&&!HTMLArea2.isBlockElement(el))el=el.parentNode;
			if(el) {
				if(el.style.direction==dir) el.style.direction="";
				else el.style.direction=dir;
			}
			break;		
		default:
			try { this._doc.execCommand(cmdID,UI,param); }
			catch(e) 
			{
				if(this.config.debug) {
					alert(e+"\n\nby execCommand("+cmdID+");");
				}
			}
	}
	this.updateToolbar();
	return false;
};

HTMLArea2.prototype._editorEvent = function(ev)
{
	var editor2 = this;
	var keyEvent = (HTMLArea2.is_ie&&ev.type=="keydown")||(!HTMLArea2.is_ie&&ev.type=="keypress");
	if(keyEvent)for(var i in editor2.plugins) {
		var plugin = editor2.plugins[i].instance;
		if(typeof plugin.onKeyPress=="function") if(plugin.onKeyPress(ev))return false;
	}	
	if(keyEvent&&ev.ctrlKey&&!ev.altKey) {
		var sel = null;
		var range = null;
		var key = String.fromCharCode(HTMLArea2.is_ie?ev.keyCode:ev.charCode).toLowerCase();
		var cmd = null;
		var value = null;
		switch(key)
		{
			case 'a':
				if(!HTMLArea2.is_ie) {
					sel = this._getSelection();
					sel.removeAllRanges();
					range = this._createRange();
					range.selectNodeContents(this._doc.body);
					sel.addRange(range);
					HTMLArea2._stopEvent(ev);
				}
				break;			
			case 'b': cmd="bold"; break;			
			case 'i': cmd="italic"; break;			
			case 'u': cmd="underline"; break;			
			case 's': cmd="strikethrough"; break;			
			case 'l': cmd="justifyleft"; break;			
			case 'e': cmd="justifycenter"; break;			
			case 'r': cmd="justifyright"; break;			
			case 'j': cmd="justifyfull"; break;			
			case 'z': cmd="undo"; break;			
			case 'y': cmd="redo"; break;			
			case 'v': if(HTMLArea2.is_ie||editor2.config.htmlareaPaste) cmd="paste"; break;			
			case 'n': cmd="formatblock2"; value="p"; break;
			case '0': cmd="killword"; break;			
			case '1':
			case '2':
			case '3':
			case '4':
			case '5':
			case '6': cmd="formatblock2"; value="h"+key; break;
		}		
		if(cmd) {
			this.execCommand(cmd,false,value);			
			HTMLArea2._stopEvent(ev);
		}
	}
	else if(keyEvent)
	{
		switch(ev.keyCode)
		{
			case 13:
				if(HTMLArea2.is_gecko&&!ev.shiftKey)
					if(this.dom_checkInsertP(true)) HTMLArea2._stopEvent(ev);
				break;			
			case 8:
			case 46:
				if(HTMLArea2.is_gecko&&!ev.shiftKey) {
					if(this.dom_checkBackspace())HTMLArea2._stopEvent(ev);
				} else if(HTMLArea2.is_ie) {
					if(this.ie_checkBackspace())HTMLArea2._stopEvent(ev);
				}
				break;			
			case 9:
				if(HTMLArea2.is_ie) {
					if(editor2.ie_tabPressed(ev.shiftKey))HTMLArea2._stopEvent(ev);
				} else {
					if(editor2.moz_tabPressed(ev.shiftKey))HTMLArea2._stopEvent(ev);
				}
				break;
		}
	}	
	if(editor2._timerToolbar) {
		clearTimeout(editor2._timerToolbar);
	}	
	editor2._timerToolbar=setTimeout(function(){editor2.updateToolbar();editor2._timerToolbar=null;},50);
};

HTMLArea2.prototype.ie_tabPressed = function(shift)
{
	var parents = this.getAncestorsHash();
	if(parents.table&&parents.td) {
		var range = this._createRange(this._getSelection());
		range.moveToElementText(parents.td);
		if(shift)range.moveStart("character",-1);
		else range.moveEnd("character",1);
		range.collapse(shift);
		range.select();
		parents = this.getAncestorsHash();
		if(parents.table&&parents.td)
			this.selectNodeContents(parents.td);
	} else this.execCommand(shift?"outdent":"indent",false,null);return true;
};

HTMLArea2.prototype.moz_tabPressed = function(shift)
{
	var editor2 = this;
	setTimeout(function() {
		var parents = editor2.getAncestorsHash();
		if(parents.table&&parents.td) editor2.selectNodeContents(parents.td);
	},20);
	return false;
};

HTMLArea2.prototype.scrollToCaret = function()
{
	var e = this.getParentElement(),	
	w = this._iframe.contentWindow,
	h = w.innerHeight||w.height,
	d = this._doc,
	t = d.documentElement.scrollTop||d.body.scrollTop;	
	if(typeof h=="undefined") return false;	
	if(e.offsetTop>h+t) w.scrollTo(e.offsetLeft,e.offsetTop-h+e.offsetHeight);
};

HTMLArea2.prototype.convertNode = function(el,newTagName)
{
	var newel = newTagName?this._doc.createElement(newTagName):this._doc.createDocumentFragment(),	 p = el.parentNode;
	while(el.firstChild) newel.appendChild(el.firstChild);
	p.insertBefore(newel,el);
	p.removeChild(el);
	p.normalize();
	return newel;
};

HTMLArea2.prototype.ie_checkBackspace = function()
{
	var i,a,r2,sel = this._getSelection(), range = this._createRange(sel);
	if(/^(text|none)$/i.test(sel.type)) {
		r2 = range.duplicate();
		r2.moveStart("character",-1);
		a = r2.parentElement();		
		if(a!=range.parentElement()&&/^a$/i.test(a.tagName)) {
			r2.collapse(true);
			r2.moveEnd("character",1);
			r2.pasteHTML('');
			r2.select();
			return true;
		}
	} else  {
		for(var i=range.length;--i>=0;a=range.item(i),a.parentNode.removeChild(a));
		return false;
	}
};

HTMLArea2.prototype.dom_checkBackspace = function()
{
	var self = this;
	if(HTMLArea2._backspaceTimeout) clearTimeout(HTMLArea2._backspaceTimeout);
	HTMLArea2._backspaceTimeout = setTimeout(function()
	{
		try
		{
			var sel = self._getSelection();
			var r = self._createRange(sel);
			var SC = r.startContainer;
			var SO = r.startOffset;
			var EC = r.endContainer;
			var EO = r.endOffset;
			var newr = SC.nextSibling;			
			if(SC.nodeType==3) SC = SC.parentNode;			
			if(SC.nodeType==1&&!/\S/.test(SC.tagName)) {
				var p = document.createElement("p");
				while(SC.firstChild) p.appendChild(SC.firstChild);
				SC.parentNode.insertBefore(p,SC);
				SC.parentNode.removeChild(SC);
				r=r.cloneRange();
				r.setStartBefore(newr);
				r.setEndAfter(newr);
				r.extractContents();
				sel.removeAllRanges();
				sel.addRange(r);
			} else if(SC.nodeType==1&&/^br$/i.test(SC.childNodes[SO-1].tagName)) {
				newr = SC.childNodes[SO-1];
				if(!newr.nextSibling) {
					r = r.cloneRange();
					r.setStartBefore(newr);
					r.collapse(true);
					sel.removeAllRanges();
					sel.addRange(r);
				}
			}
		} catch(e) {}
	HTMLArea2._backspaceTimeout=0;
	},10);
};

HTMLArea2._formatTags = {
	b:"bold",
	strong:"bold",
	i:"italic",
	em:"italic",
	strike:"strikethrough",
	u:"underline"
};

HTMLArea2._otherSaveCMDS = [
	"justifyleft",
	"justifycenter",
	"justifyright",
	"justifyfull",
	"fontname2",
	"fontsize"
];

HTMLArea2.prototype.dom_checkInsertP = function(step2)
{
	var i,df,tmp,p = this.getAllAncestors(),
	block=null,
	pnodes={},
	stts=[],
	doc=this._doc,self=this;	
	for(i=0;i<p.length;++i)
	{
		df = p[i];
		tmp = df.tagName.toLowerCase();
		if(!block&&HTMLArea2.isBlockElement(df)&&!/^(body|html)$/.test(tmp)) block = df;
		if(!pnodes[tmp]) pnodes[tmp] = df;
	}
	if(step2) {
		for(i=p.length;--i>=0;)
		{
			SC = HTMLArea2._formatTags[p[i].tagName.toLowerCase()];
			if(SC)stts.push(SC);
		}
		for(i=HTMLArea2._otherSaveCMDS.length;--i>=0;)
		{
			try
			{
				df = HTMLArea2._otherSaveCMDS[i];
				if(/justify/.test(df)&&!block.align&&!block.style.textAlign||/font/.test(df)&&!pnodes.font)
					continue;
				tmp = /justify/.test(df)?doc.queryCommandState(df):doc.queryCommandValue(df);
				if(tmp)stts.push({cmd:df,value:tmp});
			} catch(e) {};
		}
	}	
	function make_p_later()
	{
		setTimeout(function()
		{
			self.execCommand("formatblock2",false,"p");
			var i, tmp;
			for(i=stts.length;--i>=0;)
			{
				tmp = stts[i];
				if(typeof tmp == "string") self.execCommand(tmp);
				else self.execCommand(tmp.cmd,false,tmp.value);
			}
			self.forceRedraw();
		},10);
	};	
	var btn = block&&block.tagName.toLowerCase();
	if(!block||(btn=="blockquote")) {
		this.execCommand("formatblock2",false,"p");
	} else if(/^(pre|tr|td|table|tbody|thead|th|caption|div|li)$/.test(btn)) {
		if(btn=="li"&&!/\S/.test(HTMLArea2.getInnerText(block))) make_p_later();
		return false;
	}	
	if(step2) {
		if(block&&(/^h[1-6]$/.test(btn)||(pnodes.li&&pnodes.p&&/\S/.test(HTMLArea2.getInnerText(pnodes.p))))) {
			var tmp,sel=this._getSelection(),r=this._createRange(sel),p=this._doc.createElement("p");
			if(block.lastChild.nodeType==3) tmp = r.comparePoint(block.lastChild,block.lastChild.data.length) == 0;
			else tmp = r.compareNode(block.lastChild) == 1;
			if(tmp) {
				p.appendChild(this._doc.createElement("br"));
				sel.removeAllRanges();
				r.setEndAfter(block);
				r.collapse(false);
				r.insertNode(p);r.selectNodeContents(p);
				r.collapse(true);
				sel.addRange(r);
				this.scrollToCaret();
				return true;
			} else {
				return false;
			}
		} else {
			make_p_later();
			return false;
		}
	}
	return true;
};

HTMLArea2.prototype.getHTML = function()
{
	switch(this._editMode)
	{
		case "wysiwyg":
			this._wordClean();
			if(!this.config.fullPage) {
				return HTMLArea2.getHTML(this._doc.body,false,this);
			} else return this.doctype+"\n"+HTMLArea2.getHTML(this._doc.documentElement,true,this);		
		case "textmode": return this._textArea.value;		
		default: alert("모드 <"+mode+"> 가 정의되지 않았습니다.");
	}
	return false;
};

HTMLArea2.prototype.getInnerHTML = function()
{
	switch(this._editMode)
	{
		case "wysiwyg":
			if(!this.config.fullPage) return this._doc.body.innerHTML;
			else return this.doctype + "\n" + this._doc.documentElement.innerHTML;
		case "textmode": return this._textArea.value;		
		default: alert("모드 <"+mode+"> 가 정의되지 않았습니다.");
	}
	return false;
};

HTMLArea2.prototype.setHTML = function(html)
{
	switch(this._editMode)
	{
		case "wysiwyg":
			if(!this.config.fullPage) this._doc.body.innerHTML = html;
			else this._doc.body.innerHTML = html;
			this.convertSemanticTags(true);
			this._wordClean();
			break;		
		case "textmode":
			this._textArea.value = html;
			break;		
		default:
			alert("모드 <"+mode+"> 가 정의되지 않았습니다.");
	}
	return false;
};

HTMLArea2.prototype.setDoctype = function(doctype)
{
	this.doctype = doctype;
};

HTMLArea2._object = null;

HTMLArea2.cloneObject = function(obj)
{
	if(!obj) return null;
	var newObj = new Object;
	if(obj.constructor.toString().indexOf("function Array(") == 1) {
		newObj = obj.constructor();
	}
	if(obj.constructor.toString().indexOf("function Function(") == 1) {
		newObj = obj;
	} else  {
		for(var n in obj)
		{
			var node = obj[n];
			if(typeof node == 'object') {
				newObj[n] = HTMLArea2.cloneObject(node);
			} else {
				newObj[n] = node;
			}
		}
		return newObj;
	}
};	

HTMLArea2.checkSupportedBrowser = function()
{
	if(HTMLArea2.is_gecko) {
		if(navigator.productSub<20021201) {
			alert("버젼이 최소한 Mozilla-1.3 Alpha. 이상이어야 합니다.\n"+"죄송합니다. Gecko서비스가 지원되지 않습니다.");
			return false;
		}		
		if(navigator.productSub<20030210) {
			alert("Mozilla 1.3 Beta 이하 버젼은 지원되지 않습니다.\n");
		}
	}
	return HTMLArea2.is_midas||HTMLArea2.is_ie;
};

HTMLArea2.prototype._getSelection = function()
{
	if(HTMLArea2.is_ie) {
		return this._doc.selection;
	} else {
		return this._iframe.contentWindow.getSelection();
	}
};

HTMLArea2.normalizeRange = function(r)
{
	try
	{
		var tmp =null,
		SC = r.startContainer,
		SO = r.startOffset,
		EC = r.endContainer,
		EO = r.endOffset;		
		if(SC.nodeType == 3 && EC.nodeType == 3) return;
		if(SC.nodeType==1) {
			while(!tmp&&SO>=0)
			{
				tmp = SC.childNodes[SO--];
			}
			while(tmp&&tmp.nodeType!=3) tmp = tmp.firstChild;			
			if(tmp) r.setStart(tmp,tmp.data.length);
		}
		tmp=null;
		if(EC.nodeType==1) {
			while(!tmp&&EO>=0)
			{
				tmp = EC.childNodes[EO--];
			}
			while(tmp&&tmp.nodeType != 3) tmp = tmp.lastChild;			
			if(tmp) r.setEnd(tmp,tmp.data.length);
		}
	} catch(e) {};
};

HTMLArea2.prototype._createRange = function(sel)
{
	if(HTMLArea2.is_ie) {
		if(sel) return sel.createRange();
		else return this._doc.body.createTextRange();
	} else {
		if(typeof sel != "undefined") {
			try { return sel.getRangeAt(0); }
			catch(e) { return this._doc.createRange(); }
		} else {
			return this._doc.createRange();
		}
	}
};

HTMLArea2._addEvent = function(el,evname,func)
{
	if(HTMLArea2.is_ie) {
		el.attachEvent("on"+evname,func);
	} else {
		el.addEventListener(evname,func,true);
	}
};

HTMLArea2._addEvents = function(el,evs,func)
{
	for(var i=evs.length;--i>=0;)
	{
		HTMLArea2._addEvent(el,evs[i],func);
	}
};

HTMLArea2._removeEvent = function(el,evname,func)
{
	if(HTMLArea2.is_ie) {
		el.detachEvent("on"+evname,func);
	} else {
		el.removeEventListener(evname,func,true);
	}
};

HTMLArea2._removeEvents = function(el,evs,func)
{
	for(var i=evs.length;--i>=0;)
	{
		HTMLArea2._removeEvent(el,evs[i],func);
	}
};

HTMLArea2._stopEvent = function(ev)
{
	if(HTMLArea2.is_ie) {
		ev.cancelBubble = true;
		ev.returnValue = false;
	} else {
		ev.preventDefault();
		ev.stopPropagation();
	}
};

HTMLArea2._removeClass = function(el,className)
{
	if(!(el&&el.className)) {
		return;
	}
	var cls = el.className.split(" ");
	var ar = new Array();	
	for(var i=cls.length;i>0;)
	{
		if(cls[--i] != className) {
			ar[ar.length] = cls[i];
		}
	}
	el.className = ar.join(" ");
};

HTMLArea2._addClass = function(el,className)
{
	HTMLArea2._removeClass(el,className);
	el.className += " " + className;
};

HTMLArea2._hasClass = function(el,className)
{
	if(!(el&&el.className)) {
		return false;
	}
	var cls = el.className.split(" ");	
	for(var i=cls.length;i>0;)
	{
		if(cls[--i]==className) {
			return true;
		}
	}
	return false;
};

HTMLArea2._blockTags = " body form textarea fieldset ul ol dl li div blockquote " + 
"p h1 h2 h3 h4 h5 h6 quote pre table thead " + 
"tbody tfoot tr td iframe address ";

HTMLArea2.isBlockElement = function(el)
{
	return el&&el.nodeType==1 && (HTMLArea2._blockTags.indexOf(" "+el.tagName.toLowerCase()+" ")!=-1);
};

HTMLArea2._quickTags = " br hr input link meta img ";

HTMLArea2.needsClosingTag = function(el)
{
	return el&&el.nodeType==1 && HTMLArea2._quickTags.indexOf(" "+el.tagName.toLowerCase()+" ")==-1;
};

HTMLArea2.htmlEncode = function(str)
{
	return str.replace(/&/ig,"&amp;").replace(/</ig,"&lt;").replace(/>/ig,"&gt;").replace(/\x22/ig,"&quot;").replace(/\u00A0/g,"&#xa0;");
};

HTMLArea2.getHTML = function(root,outputRoot,editor2)
{
	try { return HTMLArea2.getHTMLWrapper(root,outputRoot,editor2); }
	catch(e) { alert(e); return editor2._iframe.contentWindow.document.body.innerHTML; }
};

HTMLArea2.getHTML_fixCSS = function(css)
{
	return css;
};

HTMLArea2.getHTMLWrapper = function(root,outputRoot,editor2)
{
	var html = [];
	switch(root.nodeType)
	{
		case 1:
		case 11:
			var closed;
			var i;
			var root_tag = (root.nodeType==1)?root.tagName.toLowerCase():'';
			if(root_tag == 'br' && !root.nextSibling&&root.previousSibling)
			break;
			if(outputRoot)
				outputRoot =! (editor2.config.htmlRemoveTags&&editor2.config.htmlRemoveTags.test(root_tag));
			if(HTMLArea2.is_ie&&root_tag=="head") {
				if(outputRoot)html.push("<head>");
				var save_multiline = RegExp.multiline;
				RegExp.multiline = true;
				var txt = root.innerHTML.replace(HTMLArea2.RE_tagName,function(str,p1,p2)
				{
					return p1 + p2.toLowerCase();
				});
				RegExp.multiline = save_multiline;
				html.push(txt);
				if(outputRoot) html.push("</head>");
				break;
			} else if(outputRoot) {
				root_tag = HTMLArea2.convertTag(root_tag);
				closed = (!(root.hasChildNodes()||HTMLArea2.needsClosingTag(root)));
				html.push("<"+root_tag);
				var attrs = root.attributes;
				for(i=0;i<attrs.length;++i)
				{
					var a = attrs.item(i);
					if(!a.specified) {
						continue;
					}
					var name = a.nodeName.toLowerCase();
					if(/_moz_editor2_bogus_node/.test(name)) {
						html = [];
						break;
					}
					if(/_moz|contenteditable|_msh/.test(name)) {
						continue;
					}
					var value;
					if(name!="style") {
						if(typeof root[a.nodeName] != "undefined" && name != "href" && name != "src" && !/^on/.test(name)) {
							value = root[a.nodeName];
						} else {
							value = a.nodeValue;
							if(HTMLArea2.is_ie && (name=="href"||name=="src")) {
								value = editor2.stripBaseURL(value);
							}
						}
					} else {
						value = HTMLArea2.getHTML_fixCSS(root.style.cssText);
					}					
					if(/(_moz|^$)/.test(value)) {
						continue;
					}
					html.push(" "+name+'="'+value+'"');
				}				
				if(html.length>0) {
					html.push(closed?" />":">");
				}
			}			
			for(i=root.firstChild;i;i=i.nextSibling)
			{
				html.push(HTMLArea2.getHTMLWrapper(i,true,editor2));
			}			
			if(outputRoot&&!closed) {
				html.push("</"+root_tag+">");
			}
			break;
		case 3:
			if(/^(script|style)$/i.test(root.parentNode.tagName)) {
				if(root.data.indexOf("/*<![CDATA[*/") != 0) html=["/*<![CDATA[*/"+root.data+"/*]]>*/"];
				else html = [root.data];
			} else  html = [HTMLArea2.htmlEncode(root.data)];
			break;
		case 4:
			alert("CDATA section encountered");
			html=["<![CDATA["+root.data.replace(/--/g,'?')+"]]>"];
			break;		
		case 8:
			html = ["<!--"+root.data+"-->"];
			break;
	}
	return html.join("");
};

HTMLArea2.prototype.convertSemanticTags = function(use_b,root)
{
	var src1 = new RegExp("^"+(use_b?"strong":"b")+"$","i"),
	dst1 = use_b?"b":"strong",
	src2 = new RegExp("^"+(use_b?"em":"i")+"$","i"),
	dst2 = use_b?"i":"em",
	ed = this;	
	function rec(root)
	{
		if(root) {
			if(src1.test(root.tagName)) root = ed.convertNode(root,dst1);
			else if(src2.test(root.tagName)) root = ed.convertNode(root,dst2);			
			for(var i=root.firstChild;i;i=i.nextSibling)
				if(i.nodeType == 1) i=rec(i);
		} else  root = null;
		return root;
	};	
	rec(root||this._doc.body);
};

HTMLArea2.convertTag = function(tag)
{
	switch(tag)
	{
		case "b": return "strong";		
		case "i": return "em";
	}
	return tag;
};

HTMLArea2.getPrevNode = function(node)
{
	if(!node) return null;	
	if(node.previousSibling) return node.previousSibling;	
	if(node.parentNode) return node.parentNode;
	return null;
};

HTMLArea2.getNextNode = function(node)
{
	if(!node) return null;
	if(node.nextSibling) return node.nextSibling;
	if(node.parentNode) return node.parentNode;
	return null;
};

HTMLArea2.prototype.stripBaseURL = function(string)
{
	var baseurl = this.config.baseURL;
	baseurl = baseurl.replace(/[^\/]+$/,'');
	var basere = new RegExp(baseurl);
	string = string.replace(basere,"");
	baseurl = baseurl.replace(/^(https?:\/\/[^\/]+)(.*)$/,'$1');
	basere = new RegExp(baseurl);
	return string.replace(basere,"");
};

String.prototype.trim = function()
{
	return this.replace(/^\s+/,'').replace(/\s+$/,'');
};

HTMLArea2._makeColor = function(v)
{
	if(typeof v!="number") {
		return v;
	}
	var r = v&0xFF;
	var g = (v>>8)&0xFF;
	var b = (v>>16)&0xFF;
	return "rgb("+r+","+g+","+b+")";
};

HTMLArea2.do_false = function()
{
	return false;
};

HTMLArea2._colorToRgb = function(v)
{
	if(!v) return '';
	function hex(d)
	{
		return(d<16)?("0"+d.toString(16)):d.toString(16);
	};
	if(typeof v == "number") {
		var r = v&0xFF;
		var g = (v>>8)&0xFF;
		var b = (v>>16)&0xFF;
		return "#" + hex(r) + hex(g) + hex(b);
	}	
	if(v.substr(0,3) == "rgb") {
		var re = /rgb\s*\(\s*([0-9]+)\s*,\s*([0-9]+)\s*,\s*([0-9]+)\s*\)/;
		if(v.match(re)) {
			var r = parseInt(RegExp.$1);
			var g = parseInt(RegExp.$2);
			var b = parseInt(RegExp.$3);
			return "#" + hex(r) + hex(g) + hex(b);
		}
		return null;
	}	
	if(v.substr(0,1) == "#") {
		return v;
	}
	if(HTMLArea2._colors&&typeof v == "string") {
		return HTMLArea2._colors[v.toLowerCase()];
	}
	return null;
};

HTMLArea2.prototype._popupDialog = function(url,action,init)
{
	Dialog(this.popupURL(url),action,init);
};

HTMLArea2.prototype.imgURL = function(file,plugin)
{
	if(typeof plugin == "undefined") return _editor2_url + file;
	else return _editor2_url+"plugins/"+plugin+"/img/"+file;
};

HTMLArea2.prototype.popupURL = function(file)
{
	var url="";
	if(file.match(/^plugin:\/\/(.*?)\/(.*)/)) {
		var plugin = RegExp.$1;
		var popup = RegExp.$2;
		if(!/\.html$/.test(popup))
			popup += ".html";
		url =_editor2_url + "plugins/" + plugin + "/popups/" + popup;
	} else  url = _editor2_url + this.config.popupURL + file;
	return url;
};

HTMLArea2.getElementById = function(tag,id)
{
	var el,i,objs = document.getElementsByTagName(tag);
	for(i=objs.length;--i>=0&&(el=objs[i]);) if(el.id==id)return el;
	return null;
};

HTMLArea2._openedWindows = [];

HTMLArea2.tryWindowOpen = function(arg1,arg2,arg3)
{
	try
	{
		var win = window.open(arg1,arg2,arg3);
		if(win) {
			setTimeout(function()
			{
				HTMLArea2._addEvent(win,"unload",function()
				{
					var a = HTMLArea2._openedWindows,i;
					for(i=a.length;--i>=0;)
					{
						if(a[i]===win) a.splice(i,1);
					}
				});
			},100);			
			HTMLArea2._openedWindows.push(win);
			return win;
		}
		throw "blocked";	
	}
	catch(e)
	{
		alert("브라우져가 팝업을 차단하였습니다.\n\n" + "작업을 하기 위해서는 팝업차단 해제를 하시길 바랍니다.\n");
		return null;
	}
};

HTMLArea2._addEvent(window,"unload",function()
{
	var a = HTMLArea2._openedWindows,i;
	for(i=a.length;--i>=0;)
	{
		a[i].close();
		a.splice(i,1);
	}
});

HTMLArea2.centeredWindowOpen = function(url,size,name)
{
	if(!name) name = "_blank";	
	if(!size) size = {w:500,h:350};	
	var args;	
	if(HTMLArea2.is_ie) args = "toolbar2=no,location=no,directories=no,status=no,menubar=no,";
	else args = "toolbar2=no,menubar=no,personalbar=no,status=no,";	
	args += "scrollbars=no,resizable=yes,width=" + size.w+ ",height=" + size.h;
	var left = 0, top = 0;
	if(screen.width) left = (screen.width-size.w)/2;
	if(screen.height) top = (screen.height-size.h)/2;
	if(left) args += ",left=" + left;
	if(top) args += ",top=" + top;
	return HTMLArea2.tryWindowOpen(url,name,args);
};

// unload될때 실행함수
HTMLArea2.onBeforeUnload = function()
{
	return "현재 작성중인 내용은 저장되지 않습니다.";
	//return "";
};
window.onbeforeunload=HTMLArea2.onBeforeUnload;