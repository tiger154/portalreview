//자동완성 리스트를 받아올 웹서버의 주소
var akc_url = "http://www.revu.co.kr/search/akc.load.proc";

//입력창이 포함된 form의 ID를 명시
var AKCFrmID = "AKCFrm";

//입력창의 ID를 명시
var AKCKwdID = "AKCKwd";

//화면에서 보여질 최대 목록 개수
var akc_maxlen = 5;

//스크롤 내에 보여질 목록 개수
var akc_list_len = 5;

var AKC_Div = null;
var AKC_IDiv = null;
var AKC_Ifrm = null;
var AKC_Arrow = null;

var akc_frm = null;
var akc_kwd = null;

var akc_request = null;
var akc_prv_query = "";
var akc_cur_query = "";
var akc_prvl = null;
var akc_curp = -1;
var akc_enable = 0;
var akc_my_query = new Array("");
var akc_send_query = null;
var akc_keycode = null;
var akc_query = null;

var akc_esrc = 0;
var akc_timeid = null;
var akc_org_query = "";
var akc_array = null;
var akc_hiidx = -1;
var keystate = 0;
var _dom = 3;

//현재 시간으로 부터 1일간 데이터를 저장하기 위해서 
//현재 시간 + 24*60분*60초*1000밀리초*1일 
var expires = new Date();
expires.setTime(expires.getTime() + 3 * 60 * 60 * 1000);
var expiryDate = expires.toGMTString();

/**
* 쿠키 저장
**/
function setCookie(name, value) {
    document.cookie = name + "=" + value + "; path=/;" + " expires=" + expiryDate + ";";
}

function akc_init() {
    var AKCKwd_X = 0;
    var AKCKwd_Y = 0;
    var AKCKwd_W = "";
    var AKCKwd_H = 0;

    try {

        akc_frm = parent.document.getElementById(AKCFrmID);
        akc_kwd = parent.document.getElementById(AKCKwdID);

        akc_query = akc_kwd.defaultValue;

    } catch (e) {
        setTimeout("akc_init()", 100);
        return;
    }

    //입력창이 비어 있으면 focus(), 검색어가 있다면 커서위치 조정
    if (akc_kwd.value == "") {
        akc_kwd.focus();
    } else {
        setCursorToEnd(akc_kwd);
    }

    //key 초기화
    _dom = parent.document.all ? 3 : (parent.document.getElementById ? 1 : (parent.document.layers ? 2 : 0));
    parent.document.onkeydown = keypress;
    parent.document.onmousedown = mousekeydown;

    //onclick 이벤트시 toggle() 함수 호출
    parent.document.getElementById("AKCArrow").onclick = akc_toggle;

    akc_kwd.onkeydown = akc_handle;
    akc_kwd.onkeyup = akc_esc;
    akc_kwd.onclick = akc_toggle;

    parent.document.getElementById("AKCArrow").style.visibility = "visible";

    // 사용 가능 여부 체크 조건 없을 경우 무조건 true;
    if (document.getElementById("akc_chk") != null) {
        akc_enable = akc_getCookie();

        if (!akc_enable || akc_enable == 1) {
            document.getElementById("akc_chk").checked = true;
        }
    }
    else
        akc_enable = 1;


    //2010.04.26
    var onofftextobj = document.getElementById("onoffText");
    if (akc_enable == 1)
        onofftextobj.innerHTML = "기능끄기";
    else
        onofftextobj.innerHTML = "기능켜기";

    parent.document.onclick = layer_blur;

    akc_set_interval();

    AKC_Div = parent.document.getElementById("AKCDiv");
    AKC_IDiv = document.getElementById("AKCIDiv");
    AKC_Ifrm = parent.document.getElementById("AKCIfrm");
    AKC_Arrow = parent.document.getElementById("AKCArrow");

    //자동완성창이 위치를 못잡는 경우 예외처리

    if (AKCKwd_X == 0 && AKCKwd_Y == 0) {

        AKCKwd_X = 310; 	//검색창의 X좌표
        AKCKwd_Y = 40; 	//검색창의 Y좌표
        AKCKwd_W = "391px"; //검색창의 넓이
        AKCKwd_H = 20; 	//검색창의 높이
    }

    AKC_Div.style.top = AKCKwd_Y + AKCKwd_H + 7 + "px";
    AKC_Div.style.left = AKCKwd_X - 68 + "px";
    AKC_Div.style.width = parseInt(AKCKwd_W) - 56 + "px";
}


function akc_set_location() {

    AKC_Div = parent.document.getElementById("AKCDiv");
    AKC_Div.style.left = getElementX(parent.document.getElementById(AKCKwdID)) + "px";	

    AKC_Arrow = parent.document.getElementById("AKCArrow");
    AKC_Arrow.style.left = getElementX(parent.document.getElementById(AKCKwdID)) + parseInt(parent.document.getElementById(AKCKwdID).style.width) - 22 + "px";
}


function akc_set_interval() {

    if (akc_timeid == null) {
        akc_timeid = window.setInterval("akc_update()", 10);
    }
}


function akc_clear_interval() {

    window.clearInterval(akc_timeid);
    akc_timeid = null;
}


function akc_up() {

    var objAkcList = AKC_IDiv.childNodes[0];
    
    if (akc_curp < 0) {
        akc_hide();
        return;
    }

    if (akc_curp == 0) {
        akc_kwd.value = akc_cur_query;
    }

    akc_prvstyle(objAkcList.childNodes[akc_curp--]);

    if (akc_curp >= 0) {
        akc_show();
        akc_curstyle(objAkcList.childNodes[akc_curp], true);
    }
}



function akc_down() {

    var objAkcList = AKC_IDiv.childNodes[0];

    if (objAkcList == null) return;

    if (akc_curp >= objAkcList.childNodes.length - 1) return;

    if (akc_curp >= 0) {
        akc_show();
        akc_prvstyle(objAkcList.childNodes[akc_curp]);
    }

    akc_curstyle(objAkcList.childNodes[++akc_curp], true);

    if (akc_curp == 0) {
        akc_show();
    }
}



function akc_prvstyle(ob) {
    if (ob) {
        akc_hiidx = -1;
        ob.style.backgroundColor = "";
    }
}


function akc_curstyle(ob, b) {

    if (ob) {
        if (ob.id == "akc_msg") { return; }

        if (akc_curp >= 0 && document.getElementById("akc_0") != null) {
            document.getElementById("akc_" + akc_curp).style.backgroundColor = "";
        }
        ob.style.backgroundColor = "#e9f5e6";
        akc_curp = parseInt(ob.id.substr(4, 2));
        akc_hiidx = akc_curp;

        if (b && b == true && document.getElementById("akc_0") != null) {
            akc_kwd.value = akc_array[akc_curp].KEYWORD;
            if (akc_curp == 0 || akc_curp == (akc_maxlen - akc_list_len - 1)) {
                akc_scroll(0);
            } else if (akc_curp == akc_list_len || akc_curp == (akc_list_len + 1)) {
                akc_scroll(310);
            }
        }
    }
}


function akc_update() {

    if (akc_kwd.value == akc_send_query || akc_query == akc_kwd.value) {
        if (akc_keycode == 8 && (akc_kwd.value).search("[^ ]") == -1) {
            akc_send_query = "";
            akc_cur_query = "";
            akc_prv_query = "";
            akc_keycode = null;

            akc_hide();
            akc_remove();

        }
        return;
    }
    akc_req();
}


function akc_hide() {

    if (AKC_Div.style.display != "none") {
        AKC_Div.style.display = "none";
        akc_chgbtn(0);
    }
}


function akc_remove() {

    AKC_IDiv.innerHTML = "";
}


function akc_req() {

    if (akc_keycode == 9 || akc_keycode == 16 || akc_keycode == 27 || akc_keycode == 37 || akc_keycode == 38 || akc_keycode == 40 || akc_keycode == 18) {
        return;
    }

    if (akc_enable == 0) {
        return;
    }

    akc_cur_query = akc_trim(akc_kwd.value);

    if (akc_prv_query == akc_cur_query) {
        return
    }

    if ((akc_kwd.value).search("[^ ]") != -1) {
        akc_esrc = 0;
        akc_op();
        akc_prv_query = akc_cur_query;
    } else {
        akc_prv_query = null;
        akc_hide();
        akc_remove();
    }

    akc_query = "";
}


function akc_op(m, c) {

    var d = 2;

    if (akc_enable == 0)
        return;

    akc_org_query = akc_trim(akc_kwd.value);

    if (typeof m == "undefined") {
        d = 2;
    } else if (m == "r") {
        d = 1;
    } else if (m == "l") {
        d = 0;
    }

    //	q = escape(akc_org_query);
    q = akc_org_query;
    
    akc_chgimg(d);
    akc_rmbackimg();

    if (akc_request && akc_request.readyState != 0) {
        akc_request.abort()
    }

    akc_request = akc_get_object();

    if (akc_request) {

		q = encodeURIComponent(q); 

		//alert(q);

        //GET Method
	akc_request.open("GET", akc_url + "?q=" + q + "&s=" + d, true);
	akc_request.onreadystatechange = akc_recieve;
        akc_request.send(null);
        akc_send_query = akc_org_query;
        
	//POST Method
        /*akc_request.open("POST", akc_url);
        akc_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        akc_request.onreadystatechange=akc_recieve;
        akc_request.send("q=" + q + "&s=" + d);
        akc_send_query = akc_org_query;
        */
    }
}

//request.readyState = 1 : 요청 시작
//request.readyState = 2 : 요청 처리중
//request.readyState = 3 : 요청 처리중
//request.readyState = 4 : 완료
//request.status == 200 : 요청처리하고 아무 문제가 없으면 상태 코드는 200이 된다.
function akc_recieve() {

	//alert('recieve:'+akc_request.readyState);
    
	if (akc_request.readyState == 4 && akc_request.status == 200 && akc_request.responseText) {
        if (typeof XMLHttpRequest != "undefined") { //FireFox 
            parent.AKCIfrm.akc_resize(5);
        } else {         //IE
            parent.document.AKCIfrm.akc_resize(5);
        }
	//alert(	akc_request.responseText);
	eval(akc_request.responseText);
        akc_done(myJSONObject.LIST, akc_kwd.value, eQuery)
    }
}

function akc_get_object() {

    var lo_xmlhttp;

    lo_xmlhttp = null;

    try {
        lo_xmlhttp = new ActiveXObject("Msxml2.XMLHTTP")
    } catch (e) {
        try {
            //lo_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            if (window.XMLHttpRequest) {
                // FF 로 객체선언
                lo_xmlhttp = new XMLHttpRequest();
            } else {
                // IE 경우 객체선언
                lo_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } catch (sc) {
            lo_xmlhttp = null;
        }
    }

    if (!lo_xmlhttp && typeof XMLHttpRequest != "undefined") {
        lo_xmlhttp = new XMLHttpRequest();
    }

    return lo_xmlhttp;
}


function akc_chgimg(d) {

    var akc_leftimg;
    var akc_rightimg;

    if (document.getElementById("AKCLeftImg") == null)
        return;

    akc_leftimg = document.getElementById("AKCLeftImg");
    akc_rightimg = document.getElementById("AKCRightImg");

    if (d == 0) {
        akc_leftimg.src = "img/btn_left_on.gif";
        akc_rightimg.src = "img/btn_right_off.gif";
    } else if (d == 1) {
        akc_leftimg.src = "img/btn_left_off.gif";
        akc_rightimg.src = "img/btn_right_on.gif";
    } else if (d == 2) {
        akc_leftimg.src = "img/btn_left_off.gif";
        akc_rightimg.src = "img/btn_right_off.gif";
    }
}


//검색어 입력 창의 Back-Ground 이미지를 지운다.
function akc_rmbackimg() {

    if (akc_kwd.style.backgroundImage != "") {
        akc_kwd.style.backgroundImage = "";
    }
}


function akc_trim(str) {

    str = str.replace(/^ +/g, "");
    str = str.replace(/ +$/g, " ");
    str = str.replace(/ +/g, " ");

    return str;
}


//화살표 이미지 toggling (bool 값에 따라 이미지 전환)
function akc_chgbtn(bool) {

    if (akc_enable == 1) {
        if (bool) {
            AKC_Arrow.src = "images/search/btn_atcmp_off.gif";
        } else {
            AKC_Arrow.src = "images/search/btn_atcmp_on.gif";
        }
    } else {
        if (bool) {
            AKC_Arrow.src = "images/search/btn_atcmp_off.gif";
        } else {
            AKC_Arrow.src = "images/search/btn_atcmp_on.gif";
        }
    }
}


//키입력에 따른 이벤트 처리 (keyup, keydown 등)
function akc_handle(e) {

    if (akc_enable == 0) { akc_rmbackimg(); return; }

    if (!e && parent.window.event) { e = parent.window.event; }

    if (e) {
        akc_keycode = e.keyCode;

        if (akc_hiidx == -1) {
            akc_curp = -1;
        }

        switch (akc_keycode) {
            case 9:
                if (akc_kwd.value != "" && AKC_Div.style.display != "none") {
                    e.returnValue = false;
                    if (e.shiftKey) {
                        akc_up();
                    } else {
                        akc_down();
                    }

                    setTimeout("akc_kwd.focus()", 1); // for ff
                }
                break;

            case 13:
                akc_clear_interval();
                akc_hide();
                break;

            case 38:
                akc_up();
                break;

            case 40:
                akc_down();
                break;

            default:
                akc_rmbackimg();
        }
    }
}


function akc_esc(e) {

    if (!e && parent.window.event) { e = parent.window.event; }

    if (e) {
        akc_keycode = e.keyCode;

        switch (akc_keycode) {
            case 27:
                akc_remove();
                akc_hide();

                akc_cur_query = akc_kwd.defaultValue;
                akc_prv_query = akc_send_query = akc_cur_query;
                akc_kwd.value = akc_cur_query;

            default:
                // do nothing
        }
    }
}


//화살표 클릭시 이벤트 처리
function akc_toggle(e) {

    var akc_view;
    var akc_enable;
    var akc_objtype;

    if (!AKC_Div) {
        return;
    }

    if (AKC_Div.style.display == "none") {

        akc_view = parent.AKCIfrm.document.getElementById("AKCIDiv");
        akc_enable = parent.AKCIfrm.akc_getacgo();
        akc_objtype = null;

        if (!e && parent.window.event) { e = parent.window.event; }

        if (e.srcElement && e.srcElement.type) {

            akc_objtype = e.srcElement.type;
        } else if (e.target && e.target.type) {

            akc_objtype = e.target.type;
        }

        if ((akc_kwd.value).search("[^ ]") != -1 && akc_enable == 1) {
            parent.AKCIfrm.akc_setesrc(1);
            parent.AKCIfrm.akc_op();
        } else {
            if (akc_objtype != "text") {
                akc_chklist(akc_enable);
                parent.AKCIfrm.akc_show();
            }
        }
    } else if (AKC_Div.style.display != "none") {
        parent.AKCIfrm.akc_hide();
    }
}


//response된 값을 받아 화면에 출력하기 위한 처리
function akc_done(obj, combq, combconvq) {
	var hilightq = "";
    var str = "";
    var akc_my_querystyle = "";
    var i = 0;

    hilightq = akc_org_query;

    if (combq && combq != "") {
        akc_kwd.focus();
        akc_send_query = akc_cur_query = hilightq = combq;
        akc_set_interval();
    }

    if (!obj || obj.length == 0 || akc_kwd.value == "") {
        akc_prvl = 0;
        akc_resize(1);
        AKC_IDiv.innerHTML = "<div style='padding-top:3px; padding-left:5px; line-height:180%;font-face:굴림;font-size: 9pt'>일치하는 검색어가 없습니다.</div>";
        if (akc_esrc == 1) {
            akc_show();
        } else {
            akc_hide();
        }

        return;
    }

    akc_array = obj;

    akc_show();
    akc_curp = -1;

    akc_prvl = akc_array.length;
    akc_remove();

    str += "<ul>";
    for (i = 0; i < akc_array.length && i < akc_maxlen; i++) {
        akc_orgstr = new String(akc_array[i].KEYWORD);

        cut_str = cutStr(akc_orgstr, 60);

        //akc_view = akc_orgstr.replace(hilightq, "<span class='akc_highlight'>" + hilightq + "</span>");
        akc_view = cut_str.replace(hilightq, "<span class='akc_highlight'>" + hilightq + "</span>");
        akc_view = akc_view.replace(combconvq, "<span class='akc_highlight'>" + combconvq + "</span>");
        akc_schq = akc_orgstr.replace(/\'/g, "\\\'");
        akc_schq = akc_schq.replace(/\"/g, "&quot;");

        str += "<li id=\"akc_" + i + "\"><a href=\"javascript:akc_search_url('" + akc_schq + "')\">" + akc_view + "</a></li>";
        akc_my_querystyle = "";
    }
    str += "</ul>";
    if (akc_array.length < akc_list_len) {
        akc_resize(akc_array.length);
    } else {
        akc_resize(akc_list_len);
    }

    AKC_IDiv.innerHTML = str;
    AKC_IDiv.style.zIndex = 10;
    akc_scroll(0);
}

function cutStr(str, limit) {
    var tmpStr = str;
    var byte_count = 0;
    var len = str.length;
    var dot = "";

    for (i = 0; i < len; i++) {
        byte_count += chr_byte(str.charAt(i));
        if (byte_count == limit - 1) {
            if (chr_byte(str.charAt(i + 1)) == 2) {
                tmpStr = str.substring(0, i + 1);
                dot = "...";
            } else {
                if (i + 2 != len) dot = "...";
                tmpStr = str.substring(0, i + 2);
            }
            break;
        } else if (byte_count == limit) {
            if (i + 1 != len) dot = "...";
            tmpStr = str.substring(0, i + 1);
            break;
        }
    }
    //document.writeln(tmpStr + dot);a
    //return true;

    return (tmpStr + dot);
}

function chr_byte(chr) {
    if (escape(chr).length > 4)
        return 2;
    else
        return 1;
}

//검색어 자동완성 목록 스크롤바 위치 조정
function akc_scroll(toppos) {

    AKC_IDiv.scrollTop = toppos;
}


//검색어 자동완성창 크기 조정
function akc_resize(len) {

    var i = 0;

    i = len * 24;

    //AKC_IDiv.style.height = i;
    if (typeof XMLHttpRequest != "undefined") { //FireFox 
        AKC_Ifrm.style.height = (i + 27) + "px";
    } else {         //IE
        AKC_Ifrm.style.height = i + 27;
    }

    AKC_Div.style.height = i + 39;

}


function akc_setesrc(i) {

    akc_esrc = i;
}


//검색어 자동완성창 보여주기 (화살표 이미지처리)
function akc_show() {

    if (AKC_Div.style.display == "none") {
        AKC_Div.style.display = "";
        akc_chgbtn(1);
    }

}


function akc_getacgo() {

    return akc_enable;
}


//검색어 자동완성 사용여부에 따른 메세지 출력
function akc_chklist(i) {

    var akc_msg = "";

    parent.AKCIfrm.akc_resize(1);

    if (i == 1) {
        akc_msg = "<div style='padding-top:3px; padding-left:5px; line-height:180%;font-face:굴림;font-size:11px;color:#444444;'><font color='#0001cc'>검색어 자동완성 기능</font>이 켜져 있습니다.</div>";
    } else {
        akc_msg = "<div style='padding-top:3px;padding-left:5px; line-height:180%;font-face:굴림;font-size:11px;color:#444444;'><font color='#0001cc'>검색어 자동완성 기능</font>이 꺼져 있습니다.</div>";
    }

    parent.AKCIfrm.document.getElementById("AKCIDiv").innerHTML = akc_msg;
}


//검색어 자동완성 사용여부를 쿠키에서 받아온다.
function akc_getCookie() {

    var bool = false;
    var allcookies;
    var pos;
    var start;
    var end;
    var akc_cookie;

    allcookies = document.cookie;
    pos = allcookies.indexOf("KonanAKC=");

    if (pos == -1) return 1;

    start = pos + 9;
    end = allcookies.indexOf(";", start);

    if (end == -1) end = allcookies.length;

    akc_cookie = allcookies.substring(start, end);

    akc_cookie = unescape(akc_cookie);

    if (akc_cookie == 0) {
        document.getElementById("akc_chk").checked = false;
        bool = false;
    }
    else {
        document.getElementById("akc_chk").checked = true;
        bool = true;
    }

    //On, Off 이미지 Toggling
    akc_chgturnimg(bool);

    return akc_cookie;
}


//검색어 자동완성 사용여부를 쿠키에 굽는다.
function akc_setCookie(bool) {

    var akc_cookie = 0;
    var todayDate;

    var onofftextobj = document.getElementById("onoffText");

    //좌, 우절단 버튼 이미지 초기화
    akc_chgimg(2);

    //기능 On, Off가 이미지 모드일 경우
    if (typeof bool == "undefined") {
        if (akc_enable == 1)
            bool = false;
        else if (akc_enable == 0)
            bool = true;
        //On, Off 이미지 Toggling
        akc_chgturnimg(bool);


    }

    if (bool) {
        if (onofftextobj != null) {
            onofftextobj.innerHTML = "기능끄기";
        }

        akc_cookie = 1;
        akc_enable = 1;
        akc_cur_query = akc_kwd.value;
        akc_esrc = 1;

        if ((akc_kwd.value).search("[^ ]") != -1) {
            akc_op();
        } else {
            akc_chklist(akc_enable);
            //parent.akc_chklist(akc_enable);
        }
        akc_kwd.focus();
    } else {

        if (onofftextobj != null) {
            onofftextobj.innerHTML = "기능켜기";
        }
        akc_remove();
        akc_hide();

        akc_enable = 0;
        akc_kwd.focus();

    }

    todayDate = new Date();
    todayDate.setDate(todayDate.getDate() + 3650);

    document.cookie = "KonanAKC=" + escape(akc_cookie) + "; path=/; expires=" + todayDate.toGMTString();
}


//검색어 자동완성 사용여부에 따른 아이콘 이미지 전환
function akc_chgturnimg(bool) {

    var akc_imgchk;

    akc_imgchk = document.getElementById("akc_chk");

    if (bool) {
        akc_imgchk.src = "img/btn_turn_off.gif";
    } else {
        akc_imgchk.src = "img/btn_turn_on.gif";
    }
}


function akc_layer_blur(clickX, clickY) {

    areaTop = AKC_Div.style.pixelTop;
    areaBottom = areaTop + AKC_Div.clientHeight;
    areaLeft = AKC_Div.style.pixelLeft;
    areaRight = areaLeft + AKC_Div.clientWidth;

    if (clickX < areaLeft || clickX > areaRight || clickY < areaTop || clickY > areaBottom) {
        akc_hide();
    }
}


//검색시 검색처리
function akc_search_url(url) {

    akc_clear_interval();
    akc_hide();
    akc_frm.reset();
    akc_kwd.value = url;
    akc_frm.submit();
}


//도움말 처리 함수
function akc_help() {

    alert("도움말은 준비중입니다.");
}


function layer_blur(e) {

    var sub_menu;

    if (!e && parent.window.event) {
        e = parent.window.event;
    }

    if (e) {
        clickX = e.clientX;
        clickY = e.clientY;
    }

    if (e.srcElement) {
        akc_evtsrcid = e.srcElement.id;
        akc_evtsrcname = e.srcElement.name;
    } else if (e.target) {
        akc_evtsrcid = e.target.id;
        akc_evtsrcname = e.target.name;
    }

    if (AKC_Div && AKC_Div.style.display != "none" && akc_evtsrcid != "AKCArrow" && akc_evtsrcname != "q") {
        akc_layer_blur(clickX, clickY);
    }

    sub_menu = parent.document.getElementById("sub_menu");

    if (sub_menu && parent.recm_layer_blur && sub_menu.style.display != "none") {
        parent.recm_layer_blur(clickX, clickY);
    }
}


//////////////////////////
// 디버그용
//////////////////////////
//
//	return 을 제거하고 화면단에서 아래 객체를 넣어 테스트 해야함
//	EX.)
//	<TEXTAREA NAME="msgArea" ROWS="10" COLS="100"></TEXTAREA>
//
//////////////////////////
var count = 0;
function log(msg) {
    return;
    var msgArea = parent.document.getElementById('msgArea');

    msgArea.value = msgArea.value + count + ":" + msg + '\n';
    count++;
}


function getNavigatorType() {
    if (navigator.appName == "Microsoft Internet Explorer")
        return 1;
    else if (navigator.appName == "Netscape")
        return 2;
    else
        return 0;
}


function setCursorToEnd(elem) {

    var rng;

    if (elem && getNavigatorType() == 1) {
        if (elem.type && (elem.type == "text" || elem.type == "textarea")) {
            rng = elem.createTextRange();
            rng.move("textedit");
            rng.select();
        }
    }
}


function mousekeydown(ev) {

    keystate = 1;
}


function keypress(ev) {

    var box;
    var sm = new Array(0, 0, 1, 2, 3, 4, 5, 6, 11, 12, 13);
    var ev;
    var el;
    var tg;

    if (akc_frm && akc_kwd && _dom != 2) {
        box = akc_kwd;
    } else {
        return 1;
    }

    if (parent.document.all)
        ev = parent.window.event;
    if (_dom == 3) {
        el = ev.srcElement;
        tg = el.tagName;
    }
    if (_dom == 1) {
        el = ev.target;
        tg = el.nodeName;
    }
    if (_dom == 3) {
        if (ev.keyCode > 0) {
            kc = ev.keyCode;
        }
    } else {
        kc = (ev.keyCode);
        if (ev.charCode > 0) {
            kc = ev.charCode;
        }
    }

    if (!(tg == 'INPUT' || tg == 'SELECT' || (ev.ctrlKey && kc != 86))) {
        if (kc == 8 || (kc > 32 && kc < 41) || (kc != 21 && kc < 32) || ev.altKey) {
        } else if (kc == 32) {
            if (ev.shiftKey) {
                box.focus();
                box.style.imeMode = 'active';
                box.select();
                ev.returnValue = false;
            }
        } else if (kc == 21) {
            scrollTo(0, 0);
            box.focus();
            box.style.imeMode = 'active';
            box.select();
            ev.returnValue = false;
        } else if (el != box) {
            if (keystate) {
                scrollTo(0, 0);
                box.style.imeMode = "inactive";
                setCursorToEnd(box);
                box.select();
                keystate = 0;
            }
        }
    }
    return;
}


function getElementY(element) {
    var targetTop = 0;

    if (element.offsetParent) {
        while (element.offsetParent) {
            targetTop += element.offsetTop;
            element = element.offsetParent;
        }
    }
    else if (element.y) {
        targetTop += element.y;
    }

    return targetTop;
}


function getElementX(element) {
    var targetTop = 0;

    if (element.offsetParent) {
        while (element.offsetParent) {
            targetTop += element.offsetLeft;
            element = element.offsetParent;
        }
    }
    else if (element.x) {
        targetTop += element.x;
    }

    return targetTop;
}

