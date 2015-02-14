// (c) dynarch.com 2003-2004
// Distributed under the same terms as HTMLArea itself.

function PopupWin(editor,title,handler,initFunction) {
	this.editor = editor;
	this.handler = handler;
	var dlg = HTMLArea.tryWindowOpen("","__ha_dialog","toolbar=no,menubar=no,personalbar=no,width=600,height=600,left=20,top=40"+"scrollbars=no,resizable=no");
	
	if(!dlg)
		return false;
	
	this.window = dlg;
	var doc = dlg.document;
	this.doc = doc;
	var self = this;
	var base = document.baseURI||document.URL;

	if(base&&base.match(/(.*)\/([^\/]+)/))
	{
		base=RegExp.$1+"/";
	}
	if(typeof _editor_url!="undefined"&&!/^\x2f/.test(_editor_url)&&!/http:\x2f\x2f/.test(_editor_url))
	{
		base += _editor_url;
	}
	else
	{
		base=_editor_url;
	}
	
	if(!/\/$/.test(base)) {
		base += '/';
	}
	
	this.baseURL = base;doc.open();
	var html = "<html><head><title>"+title + "</title>\n";
	html += "<style type='text/css'>@import url("+base+"htmlarea.css);</style></head>\n";
	html += "<body class='dialog popupwin' id='--HA-body'></body></html>";
	doc.write(html);
	doc.close();

	function init2() {
		var body = doc.body;
		if(!body)
		{
			setTimeout(init2,25);
			return false;
		}
		body.style.visibility = "hidden";
		dlg.title = title;
		doc.documentElement.style.padding = "0px";
		doc.documentElement.style.margin = "0px";
		var content = doc.createElement("div");
		content.className = "content";
		self.content = content;
		body.appendChild(content);
		self.element = body;
		initFunction(self);
		body.style.visibility = "visible";
		dlg.focus();
	};
	init2();
};

PopupWin.prototype.callHandler = function()
{
	var tags = ["input","textarea","select"];
	var params = new Object();
	for(var ti=tags.length;--ti>=0;)
	{
		var tag = tags[ti];
		var els = this.content.getElementsByTagName(tag);
		
		for(var j=0;j<els.length;++j)
		{
			var el = els[j];
			var val = el.value;
			if(el.tagName.toLowerCase()=="input")
			{
				if(el.type=="checkbox")
				{
					val=el.checked;
				}
			}
			params[el.name] = val;
		}
	}
	
	this.handler(this,params);
	return false;
};

PopupWin.prototype.close = function()
{
	this.window.close();
};

PopupWin.prototype.addButtons = function() 
{
	var self = this;
	var div = this.doc.createElement("div");
	this.content.appendChild(div);
	div.className = "buttons";
	
	for(var i=0;i<arguments.length;++i)
	{
		var btn = arguments[i];
		var button = this.doc.createElement("button");
		div.appendChild(button);
		button.innerHTML = HTMLArea.I18N.buttons[btn];
		
		switch(btn)
		{
			case "ok":
				button.onclick = function() {
					self.callHandler();
					self.close();
					return false;
				};
				break;
			
			case "cancel":
				button.onclick = function()
				{
					self.editor.forceRedraw();
					self.editor.focusEditor();
					self.editor.updateToolbar();
					self.close();
					return false;
				};
				break;
		}
	}
};

PopupWin.prototype.showAtElement = function()
{
	var self = this;
	setTimeout(function()
	{
		var el = self.content;
		var w = el.offsetWidth + 4;
		var h = el.offsetHeight + 4;
		var s = el.style;
		s.position = "absolute";
		s.left = (w-el.offsetWidth)/2 + "px";
		s.top = (h-el.offsetHeight)/2 + "px";

		if(HTMLArea.is_gecko)
		{
			self.window.innerWidth = w;
			self.window.innerHeight = h;
			var x = window.screenX + (window.outerWidth - self.window.outerWidth)/2;
			var y = window.screenY + (window.outerHeight - self.window.outerHeight)/2;
			self.window.moveTo(x,y);
		}
		else
		{
			self.window.resizeTo(w,h);
			var ch = self.element.clientHeight;
			var cw = self.element.clientWidth;
			self.window.resizeBy(w-cw,h-ch);
			var W = self.element.offsetWidth;
			var H = 2*h - ch;
			var x = (screen.availWidth-W)/2;
			var y = (screen.availHeight-H)/2;
			self.window.moveTo(x,y);
		}
	},25);
};