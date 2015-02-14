$(document).ready( function() {
	$(document).mousemove(function(e) {
		_pageX = e.pageX;
		_pageY = e.pageY;
	});
	common.setLayer("loginlayer");
});

var nowPageURL = window.location;
nowPageURL = String(nowPageURL);

if (nowPageURL.indexOf("/search") > 0)
{
	
}else{
	$(window).resize(function() {
	$('#bglayer').css('width', $(document).width());
	$('#bglayer').css('height', $(document).height());
	});
}


	



var _pageX = 0;
var _pageY = 0;	
var common = {
	dialog: function(title, content) {
		$('#dialog').html(content);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: title });
	},
	socialbar: function(rno, type) {
		if(rno == "") {
			$('#dialog').html("리뷰정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰보기"});
			return false;
		} else {
			if(type == "" || typeof(type) == "undefined") {
				common.redirectOpen(DOMAIN+"/"+rno, "windowSocialbar");
				/*
				socialbar._height = $(document).height();
				$('#socialbar').css({ "top": 0, "left": 0, "position": "absolute"}).show();
				$('#socialbar-frame').css({ "top": 0, "left": 0, "height": socialbar._height, "position": "absolute"}).show();
				var url = "/common/socialbar.view";
				var data = "&rno=" + rno;
				//$.ajax({ type: "POST", url: url, data: data, success: socialbar.socialbarRequest });
				$.ajax({ type: "POST", url: url, data: data, success: socialbar.loadRequest2 });
				*/
			} else {
				common.redirectOpen(DOMAIN+"/"+rno, "windowSocialbar");
			}
		}
	}, 
	socialbarRecom: function(rno) {
		$('#dialog2').html("소셜바에서 추천가능합니다.<br />리뷰를 보시겠습니까?");
		$('#dialog2').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "리뷰추천",		
			buttons: { 
				"리뷰보기": function(e) { 
					common.redirectOpen(DOMAIN+"/"+rno, "windowSocialbar");
					$(this).dialog("close");
				},
				"닫기": function() { $(this).dialog("close");} 
			}
		});
	},
	redirect: function(page) {
		var page;
		document.location = page;
	},
	reload: function() {
		document.location.reload();
	},
	submitModule: function(formID, moduleName, method) {
		var modulePage;
		var formID = document.getElementById(formID);	
		modulePage = "/?_module=" + moduleName;
		formID.action = modulePage;
		formID.method = method;
		formID.submit();
	},
	redirectOpen: function(url, pageId) {
		window.open(url, pageId);
	}, 
	redirectSelect: function(object, target, pageId) {
		var selbox = document.getElementById(object);
		var url = selbox.value;
		if(target == "new") {
			window.open(url, PageId);
		} else {
			document.location = url;
		}
	}, 
	openerRedirect: function(page) {	
		window.opener.document.location = page;
		self.close();
	}, 
	openerReload: function() {
		window.opener.document.location.reload();
	},
	redirectParentIframe: function(url) {
		parent.location.href = url;
	},
	redirectIframe: function(iframeObj, url) {
		iframe = document.getElementById(iframeObj);
		iframe.contentWindow.location.href = url;
	},
	reloadIframe: function(iframeObj) {
		iframe = document.getElementById(iframeObj);
		iframe.contentWindow.location.reload();
	},
	historyGo: function(num) {
		history.go(num);
	},
	openerExist: function() {
		try { 
			if(window.opener.location.href) return true;
		} catch(e) { 
			return false;
		}
	},
	getModuleUrl: function(moduleName) {
		/*
		var moduleSrc = "";
		var _moduleName = "";
		var _todoName = "";
		var moduleArr = moduleName.split(".");
		var num1 = moduleName.lastIndexOf(".") + 1;
		var num2 = moduleName.length - moduleName.lastIndexOf(".");
		var length = moduleArr.length;
		if(length > 0) {
			for(var i=0; i<length; i++)
			{
				if(i == 0) {
					_moduleName = moduleArr[i].toLowerCase();
				} else {
					_todoName += "." + moduleArr[i].toLowerCase();
				}
	
			}
		} else {
			_moduleName = moduleName;
		}
	
		moduleSrc = "/module/" + _moduleName + "/" + _moduleName + _todoName + ".php";	
		return moduleSrc;
		*/
		var moduleSrc = "/?_module=" + moduleName;
		return moduleSrc;
	},
	getModuleName: function() {
		var moduleName;
		var param = new Array();
		var url = decodeURIComponent(location.href);
		url = decodeURIComponent(url);
		var params;
		params = url.substring( url.indexOf('?')+1, url.length );
		params = params.split("&");
		var size = params.length;
		var key, value;
		for(var i=0 ; i < size ; i++) {
			key = params[i].split("=")[0];
			value = params[i].split("=")[1];
			if(key == "_module") {
				moduleName = value;
				break;
			} else {
				moduleName = "";
			}
		}
		return moduleName;
	},
	popup: function(popID, module, width, height, top, left, scrollbars, resizable, status) {
		if(!width || width == "") {
			module += "/resize";
		}
		if(!top || top == "") var top = ((screen.width - width)/2);
		if(!left || left == "") var left = ((screen.height - height)/2)-50;		
		var option =  'scrollbars=' + scrollbars + ', resizable=' + resizable + ', status=' + status;
		window.open(module, popID, "width="+ width + ", height =" + height + ", top=" + top + ", left="+ left + "," + option);
	},
	popupClose: function() {
		self.close();
	},
	popupResize: function(id) {
		/*
		if(navigator.userAgent.indexOf("MSIE 6") > 0) {
			mwidth = 10; mheight = 78;
		} else if(navigator.userAgent.indexOf("MSIE 7") > 0) {
			mwidth = 10; mheight = 80;
		} else if(navigator.userAgent.indexOf("Firefox") > 0) {
			mwidth = 10; mheight = 73;
		} else if(navigator.userAgent.indexOf("Chrome") > 0) {
			mwidth = 60; mheight = 110;
		} else if(navigator.userAgent.indexOf("Opera") > 0) {
			mwidth = 10; mheight = 30;
		} else if(navigator.userAgent.indexOf("Netscape") > 0) {
			mwidth = 10; mheight = -2;
		} else {
			mwidth = 10; mheight = 78;
		} 		
		var width = screen.width - 50;
		var height = screen.height - 50;	
		//var iwidth = (id == null || id == undefined || id == -1) ? $(document).width() : $('#'+id).width();
		//var iheight = (id == null || id == undefined || id == -1) ? $(document).height() : $('#'+id).height();
		var iwidth = $(document).width();
		var iheight = $(document).height();	
		if(iwidth > width) {
			//window.document.body.scroll = "yes";
			iwidth = width;
		}
		if(iheight > height) {
			//window.document.body.scroll = "yes";
			iheight = height;
		}
		var x = (width/2) - (iwidth/2);
		var y = (height/2) - (iheight/2);
		window.resizeTo(iwidth + mwidth, iheight + mheight);
		window.moveTo(x, y);
		*/
		if(navigator.userAgent.indexOf("MSIE 6") > 0) {
			mwidth = 40; mheight = 80;
		} else if(navigator.userAgent.indexOf("MSIE 7") > 0) {
			mwidth = 40; mheight = 110;
		} else if(navigator.userAgent.indexOf("Firefox") > 0) {
			mwidth = 38; mheight = 101;
		} else if(navigator.userAgent.indexOf("Chrome") > 0) {
			mwidth = 40; mheight = 88;
		} else if(navigator.userAgent.indexOf("Safari") > 0) {
			mwidth = 40; mheight = 88;
		} else if(navigator.userAgent.indexOf("Opera") > 0) {
			mwidth = 10; mheight = 30;
		} else if(navigator.userAgent.indexOf("Netscape") > 0) {
			mwidth = 10; mheight = -2;
		} else {
			mwidth = 40; mheight = 100;
		}
		var width = (id == null || id == undefined || id == -1) ? $(document).width() : $('#'+id).width();
		var height = (id == null || id == undefined || id == -1) ? $(document).height() : $('#'+id).height();
		var x = ((screen.width - 50)/2) - (width/2);
		var y = ((screen.height - 50)/2) - (height/2);
		$("html, body").css("overflow", "hidden");
		if(id == null || id == undefined || id == -1) {
			window.resizeTo(width, height);
		} else {
			window.resizeTo(width + mwidth, height + mheight);
		}
		window.moveTo(x, y);
	},
	setLayer: function(id) {
		$('#'+id).css({ "position": "absolute", "display": "none" });
	},
	openLayer: function(id, width, height, top, left, zindex) {
		width = (width == null || width == undefined || width == -1) ? $('#'+id).width() : width;
		height = (height == null || height == undefined || height == -1) ? $('#'+id).height() : height;
		top = (top == null || top == undefined || top == -1) ? _pageY : top;
		left = (left == null || left == undefined || left == -1) ? _pageX : left;
		zindex = (zindex == null || zindex == undefined || zindex == -1) ? 10 : zindex;
		$('#bglayer').css('width', $(document).width());
        $('#bglayer').css('height', $(document).height());
        $('#bglayer').show();
		$('#'+id).css({ "width": width, "height": height, "top": top, "left": left, "z-index": zindex }).show();
	},	
	openCenterLayer: function(id, width, height, zindex) {
		width = (width == null || width == undefined || width == -1) ? $('#'+id).width() : width;
		height = (height == null || height == undefined || height == -1) ? $('#'+id).height() : height;
		zindex = (zindex == null || zindex == undefined || zindex == -1) ? 10 : zindex;
		var top = $(window).scrollTop() + ($(window).height()/2 - height/2);
		var left = ($(window).width()/2)-(width/2);
		$('#bglayer').css('width', $(document).width());
		$('#bglayer').css('height', $(document).height());
		$('#bglayer').show();
		$('#'+id).css({ "width": width, "height": height, "top": top, "left": left, "z-index": zindex }).show();
	},	
	openLayervalue: function(id, width, height, top, left, zindex, param) {
		width = (width == null || width == undefined) ? $('#'+id).width() : width;
		height = (width == null || height == undefined) ? $('#'+id).height() : height;
		top = (width == null || top == -1) ? _pageY : top;
		left = (width == null || left == undefined) ? _pageX : left;
		//zindex = (width == null || zindex == undefined) ? 8 : zindex;
		$('#'+id).css({ "width": width, "height": height, "top": top, "left": left, "z-index": zindex }).show();
	},
	closeLayer: function(id) {
		$('#'+id).hide("slow");
		$('#bglayer').hide();
	},
	openPopupLayer: function(id, content, width, height, top, left, zindex) {
		width = (width == null || width == undefined || width == -1) ? $('#'+id).width() : width;
		height = (height == null || height == undefined || height == -1) ? $('#'+id).height() : height;
		top = (top == null || top == undefined || top == -1) ? _pageY : top;
		left = (left == null || left == undefined || left == -1) ? _pageX : left;
		zindex = (zindex == null || zindex == undefined || zindex == -1) ? 10 : zindex;
		$("#"+id).html(content);		
		$('#'+id).css({ "width": width, "height": height, "top": top, "left": left, "z-index": zindex }).show();
	}, 	
	closePopupLayer: function(id) {
		$('#'+id).hide("fast");
	},
	popupCookieSet: function(name, value, expire) {
		var todayDate = new Date();
		todayDate.setDate(todayDate.getDate() + expire);
		document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";";
	},
	popupCookieClose: function(name) {
		// chkToday 값은 고정
		if(document.form1.chkToday.checked) {		
			setCookie(name, "done", 1);
		}
		self.close();
	},
	popupCookieGet: function(name) {
		var nameOfCookie = name + "=";
		var x = 0;
		while(x <= document.cookie.length) {
			var y = (x+nameOfCookie.length);
			if(document.cookie.substring(x,y) == nameOfCookie) {
				if((endOfCookie=document.cookie.indexOf(";",y)) == -1)
					endOfCookie = document.cookie.length;
				return unescape(document.cookie.substring(y, endOfCookie));
			}
			x = document.cookie.indexOf(" ", x) + 1;
			if(x == 0)
				break;
		}
		return;
	},
	popupCookieWindow: function(name) {
		if(popupCookieGet(name) != "done") {		
			popupModule(name,'popup.view');
		}
	},
	swf: function(src,w,h) {
		html = '';
		html += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab" id="param" width="'+w+'" height="'+h+'">';
		//html += '<object type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="param" width="'+w+'" height="'+h+'">';
		html += '<param name="movie" value="'+src+'">';
		html += '<param name="quality" value="high">';
		html += '<param name="bgcolor" value="#ffffff">';
		html += '<param name="menu" value="false">';
		html += '<param name="wmode" value="transparent">';
		html += '<param name="swliveconnect" value="true">';
		html += '<param name="allowScriptAccess" value="always">';
		html += '<embed src="'+src+'" id="param" name="param" wmode="transparent" quality=high menu="false" width="'+w+'" height="'+h+'" swliveconnect="true" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>';
		//html += '<embed src="'+src+'" id="param" name="param" wmode="transparent" quality=high menu="false" width="'+w+'" height="'+h+'" swliveconnect="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>';
		html += '</object>';
		document.write(html);
	},
	swfvar: function(src,w,h,fvar,fvalue) {
		html = '';
		html += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab" id="param" width="'+w+'" height="'+h+'">';
		//html += '<object type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="param" width="'+w+'" height="'+h+'">';
		html += '<param name="movie" value="'+src+'?'+fvar+'='+fvalue+'">';
		html += '<param name="quality" value="high">';
		html += '<param name="bgcolor" value="#ffffff">';
		html += '<param name="menu" value="false">';
		html += '<param name="wmode" value="transparent">';
		html += '<param name="swliveconnect" value="true">';
		html += '<param name="allowScriptAccess" value="always">';
		html += '<embed src="'+src+'?'+fvar+'='+fvalue+'" id="param" name="param" wmode="transparent" quality=high menu="false" width="'+w+'" height="'+h+'" swliveconnect="true" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>';
		html += '</object>';
		document.write(html);
	},
	resizeFrame: function(iframeObj) {
		var browserType = checkBrowser();
	
		if(browserType == "FF" || browserType == "NS") 	{
			// FireFox | Netscape
			frm = document.getElementById(iframeObj);
			frm.style.height = "auto";
			contentHeight = frm.contentWindow.document.documentElement.scrollHeight;
			frm.style.height = contentHeight + "px";
		} else if(browserType == "OP") {
			// Opera
			frm = document.getElementById(iframeObj);
			frm.style.height = "100px";
			window.setTimeout(function () {
				contentHeight = frm.contentWindow.document.documentElement.scrollHeight;
				//frm.style.height = contentHeight + 4 + "px";
				frm.style.height = contentHeight + "px";
			}, 1);
		} else {
			// IE
			//var width = document.getElementById(iframeObj).contentWindow.document.body.scrollWidth;
			//document.getElementById(iframeObj).width=width;
			var height = document.getElementById(iframeObj).contentWindow.document.body.scrollHeight;	
			document.getElementById(iframeObj).height=height;
		}
	},
	checkBrowser: function() {
		var clientAgent = navigator.userAgent;
		var clientName = navigator.appName;
		var browserType = null;
	
		if(clientName.indexOf("MSIE 6") != -1) {
			browserType = "IE6";
		} else if(clientName.indexOf("MSIE 7") != -1) {
			browserType = "IE7";
		} else if(clientName.indexOf("MSIE 8") != -1) {
			browserType = "IE8";
		} else if(clientName.indexOf("Netscape") != -1) {
			if(clientAgent.indexOf("Navigator") != -1) {
				browserType = "NS";
			} else {
				browserType = "FF";
			}
		} else if(clientName.indexOf("Opera") != -1) {
			browserType = "OP";
		} else if(clientName.indexOf("Safari") != -1) {
			browserType = "SP";
		} else {
			browserType = "IE";
		}
		return browserType;
	},
	getBrowserSize: function(calType) {
		var browserType = this.checkBrowser();
		browserType = browserType.substring(0,2);
		var browserSize = new Array();
		switch(calType)
		{
			case "body" :
				var scrollbarWidth = 16;
				browserSize[0] = (browserType == "IE") ? document.body.clientWidth : window.innerWidth - scrollbarWidth;
				browserSize[1] = (browserType == "IE") ? document.body.clientHeight : window.innerHeight;
				break;
			case "scroll" :			
				browserSize[0] = (browserType == "IE") ? document.body.scrollWidth : document.documentElement.scrollWidth;
				browserSize[1] = (browserType == "IE") ? document.body.scrollHeight : document.documentElement.scrollHeight;
				//browserSize[0] = (browserType == "IE") ? document.documentElement.scrollWidth : document.documentElement.scrollWidth;
				//browserSize[1] = (browserType == "IE") ? document.documentElement.scrollHeight : document.documentElement.scrollHeight;
				break;
			case "scrollOffset" :
				var standardBody = (document.compatMode=="CSS1Compat")? document.documentElement : document.body
				browserSize[0] = (browserType == "IE") ? standardBody.scrollLeft : standardBody.scrollLeft;
				browserSize[1] = (browserType == "IE") ? standardBody.scrollTop : standardBody.scrollTop;
				break;
		}	
		return browserSize;
	},
	copyClip: function(content, msg) {
		if(window.clipboardData) {
			window.clipboardData.setData("Text", content);
		} else if(window.netscape) {
			netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
			var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
			if (!clip) return;
			var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
			if (!trans) return;
			trans.addDataFlavor('text/unicode');
			var str = new Object();
			var len = new Object();
			var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
			var copytext=content;
			str.data=copytext;
			trans.setTransferData("text/unicode",str,copytext.length*2);
			var clipid=Components.interfaces.nsIClipboard;
			if(!clip) return false;
			clip.setData(trans,null,clipid.kGlobalClipboard);
		}
		if(msg) {
			alert(msg);
		} else {
			alert("클립보드에 " + content + " (이)가 복사되었습니다.");
		}
	},
	pasteClip: function() {
		var chec=document.board_write;
		var clip_data;
		if (window.clipboardData) {
			clip_data = window.clipboardData.getData("Text"); // 클립보드 복사
		} else if(window.netscape) {
			netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
			var clip = Components.classes["@mozilla.org/widget/clipboard;1"].createInstance(Components.interfaces.nsIClipboard);
			if (!clip) return;
			var trans = Components.classes["@mozilla.org/widget/transferable;1"].createInstance(Components.interfaces.nsITransferable);
			if (!trans) return;
			trans.addDataFlavor("text/unicode");
			clip.getData(trans, clip.kGlobalClipboard);
			var str = new Object();
			var strLength = new Object();
			trans.getTransferData("text/unicode", str, strLength);
			if(str) str = str.value.QueryInterface(Components.interfaces.nsISupportsString);
			else return;
			if(str) clip_data = str.data.substring(0, strLength.value / 2);
		}
		return clip_data;
	},
	trim: function(str) {
		var count = str.length;	
		var len = count;
		var st = 0;
		while ((st < len) && (str.charAt(st) <= ' '))  st++;
		while ((st < len) && (str.charAt(len - 1) <= ' ')) len--;
		return ((st > 0) || (len < count)) ? str.substring(st, len) : str;
	},
	numberFormat: function(num, cipher) {
		if(!cipher) cipher = 3;
		var i = 0;
		var str = "";
		var len = num.length;
		var arr = new Array(len);
		while(i <len)
		{
			arr[i]=num.charAt(len-i-1);
			str=arr[i]+str;
			i++;
			if(i%cipher==0 && i!=len)
			{
				str=','+str;
			}
		}
		return str;
	},
	stripTags: function(str, allowed_tags) {
		// Strips HTML and PHP tags from a string  
	    // 
	    // version: 909.322
	    // discuss at: http://phpjs.org/functions/strip_tags
	    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   improved by: Luke Godfrey
	    // +      input by: Pul
	    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   bugfixed by: Onno Marsman
	    // +      input by: Alex
	    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +      input by: Marc Palau
	    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +      input by: Brett Zamir (http://brett-zamir.me)
	    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   bugfixed by: Eric Nagel
	    // +      input by: Bobby Drake
	    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   bugfixed by: Tomasz Wesolowski
	    // *     example 1: strip_tags('<p>Kevin</p> <b>van</b> <i>Zonneveld</i>', '<i><b>');
	    // *     returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
	    // *     example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>');
	    // *     returns 2: '<p>Kevin van Zonneveld</p>'
	    // *     example 3: strip_tags("<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>", "<a>");
	    // *     returns 3: '<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>'
	    // *     example 4: strip_tags('1 < 5 5 > 1');
	    // *     returns 4: '1 < 5 5 > 1'
	    var key = '', allowed = false;
	    var matches = [];
	    var allowed_array = [];
	    var allowed_tag = '';
	    var i = 0;
	    var k = '';
	    var html = '';	 
	    var replacer = function (search, replace, str) {
	        return str.split(search).join(replace);
	    };	 
	    // Build allowes tags associative array
	    if (allowed_tags) {
	        allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
	    }	 
	    str += '';	 
	    // Match tags
	    matches = str.match(/(<\/?[\S][^>]*>)/gi);	 
	    // Go through all HTML tags
	    for (key in matches) {
	        if (isNaN(key)) {
	            // IE7 Hack
	            continue;
	        }	 
	        // Save HTML tag
	        html = matches[key].toString();	 
	        // Is tag not in allowed list? Remove from str!
	        allowed = false;	 
	        // Go through all allowed tags
	        for (k in allowed_array) {
	            // Init
	            allowed_tag = allowed_array[k];
	            i = -1;	 
	            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+'>');}
	            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+' ');}
	            if (i != 0) { i = html.toLowerCase().indexOf('</'+allowed_tag)   ;}	 
	            // Determine
	            if (i == 0) {
	                allowed = true;
	                break;
	            }
	        }	 
	        if (!allowed) {
	            str = replacer(html, "", str); // Custom replace. No regexing
	        }
	    }	 
	    return str;
	},
	getByte: function(str) {
		var strLen = str.length;
		var i = 0;
		var textByte = 0;
		var oneChar = "";
	
		for(i=0; i< strLen; i++)
		{
			// 한글자추출
			oneChar = str.charAt(i);		
			if (escape(oneChar).length > 4) {
				// 한글이면 2를 더한다.
				textByte = textByte + 2;
			} else {
				// 그외의 경우는 1을 더한다.
				textByte++;
			}
		}
		return textByte;
	}, 
	setHomePage: function(url) {
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage(url);
	}, 
	getCookie: function(cookieName) {
		var search = cookieName + "=";
		var cookie = document.cookie;
		if(cookie.length > 0) {
			startIndex = cookie.indexOf(cookieName);
			// 만약 존재한다면
			if( startIndex != -1 ) {
				startIndex += cookieName.length;
				endIndex = cookie.indexOf( ";", startIndex );
				if( endIndex == -1) endIndex = cookie.length;
				return unescape( cookie.substring( startIndex + 1, endIndex ) );
			} else {
				return false;
			}
		} else {
			return false;
		}
	},
	setCookie: function(cookieName, cookieValue, expireDate) {
		var today = new Date();
		today.setDate( today.getDate() + parseInt( expireDate ) );
		document.cookie = cookieName + "=" + escape( cookieValue ) + "; path=/; expires=" + today.toGMTString() + ";";
	}, 
	deleteCookie: function(cookieName, expireDate) {
		var expireDate = new Date();
		//어제 날짜를 쿠키 소멸 날짜로 설정한다.
		expireDate.setDate(expireDate.getDate() - parseInt( expireDate ));
		document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString() + "; path=/";
	},
	download: function(filename1, filename2, dir) {
		var url = "/common/download";
		var data = "&filename1=" + filename1 + "&filename2=" + filename2 + "&dir=" + dir;
		$.ajax({ type: "POST", url: url, data: data, success: this.downloadRequest });
		//alert(data);
	},
	downloadRequest: function(data) { 
		alert('다운로드됨');
	},
	setTextLimit: function(id1, id2, maxByte) {
		//var textArea = $('#'+id1);
		//var textBox = $('#'+id2);		
		var str	= $('#'+id1).val();
		var strLen = str.length;
		var i = 0;				
		var textByte = 0;		
		var subLen = 0;			
		var oneChar = "";		
		var str2 = "";			   	
		for(i=0; i< strLen; i++)
		{		
			oneChar = str.charAt(i);	
			if (escape(oneChar).length > 4) {				
				textByte = textByte + 2;
			} else {				
				textByte++;
			}			
			if(textByte <= maxByte) {
				subLen = i + 1;
			}
		}
		//$('#'+id2).val(textByte);
		$('#'+id2).html(textByte);
		if(textByte > maxByte) {
			alert( maxByte + "바이트 이상 입력할 수 없습니다.\n추가로 입력된 내용은 자동으로 삭제됩니다.");
			str2 = str.substr(0, subLen);
			$('#'+id1).val(str2);
			//$('#'+id2).val(maxByte);
			$('#'+id2).html(maxByte);
		}
		$('#'+id1).focus();
	}, 
	initTextLimit: function(id1, id2, maxByte) {
		$('#'+id1).val("");
		$('#'+id2).html("0");
	},
	getTextByte: function(id) {
		var str = $('#'+id).val();
		var strLen = str.length;	
		var i = 0;					
		var textByte = 0;			
		var oneChar = "";		
		for(i=0; i< strLen; i++)
		{
			oneChar = str.charAt(i);		
			if (escape(oneChar).length > 4) {
				textByte = textByte + 2;
			} else {
				textByte++;
			}
		}
		return textByte;
	},
	noEnter: function() {
		if(event.keyCode == 13) event.returnValue=false;
	},
	weekBestChange: function(wno) {
		if(wno == null || wno == undefined || wno == "" ) {
            $('#dialog').html("정보가 잘못되었습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "주간베스트" });
			return false;
        }
        var url = "/review/best.week.data.proc";
		var data = "&wno=" + wno;
		$.ajax({ type: "POST", url: url, data: data, success: this.weekBestChangeRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	}, 
	weekBestChangeRequest: function(data) {		
		
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var list = result.list;
		//alert(result.result);
		if(result.result == "success") {
			var html = "";		
			html += "<h3><img src='/images/search/best_revu_tit.gif' alt='주간 베스트리뷰'></h3>";
			html += "<ul>"; 
			for(var i=0; i<list.list.length; i++) {
				if (i<=2)
				{
					html += "<li class='rnp'><a href='javascript:common.socialbar("+list.list[i].rno+")'><em>"+(i+1)+"</em>"+list.list[i].title+"</a></li>";	
				}else{
					html += "<li class='rng'><a href='javascript:common.socialbar("+list.list[i].rno+")'><em>"+(i+1)+"</em>"+list.list[i].title+"</a></li>";					
				}
			}
			html += "</ul>";				
			html += "<p class='rank_date'><button class='prev_week' onclick='javascript:common.weekBestChange("+list.prev_wno+")'><span class='hiding'>이전 주 보기<span></button>";
			html += "<em>"+list.date.sdate+" - "+list.date.edate+"</em><button class='next_week' onclick='javascript:common.weekBestChange("+list.next_wno+")'><span class='hiding'>다음주 보기<span></button></p>";
		
			$('#bestrank').html(html);

		} else {
			$('#dialog').html("주간 베스트리뷰 정보가 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "주간 베스트리뷰 보기" });
		}
	}
};