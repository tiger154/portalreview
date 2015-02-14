function getHistoryForm()
{
	return document.forms["historyForm"];
}


/** 검색어 체크
* @ param frm - form Object
*
* @ return true / false - 키워드 있음(true), 없음(false)
**/
function searchKwd(frm)
{
	var kwd = CommonUtil.getValue(frm,"kwd");
	
	if(kwd == "")
	{
		alert("검색어를 입력해 주세요");
		frm.kwd.focus();	
		return false;
	}
	else
		return true;

}

function reSearchKwd(frm)
{
	var frmReSrch = document.forms["searchForm"];
	var frmHistory = getHistoryForm();

	if (frmHistory.kwd.value != "")
	{
		if (frmReSrch.reSrchFlag.checked)
		{
			frmReSrch.kwd.value = "";
			frmReSrch.kwd.focus();
		}	
	}
}

function goCategory(str)
{
	var frm = getHistoryForm();
	
	CommonUtil.setValue(frm,"pageNum","1");
	CommonUtil.setValue(frm,"category",str);
	if(str == "frontier"){
		CommonUtil.setValue(frm,"pageSize","10");
	}else{	
		CommonUtil.setValue(frm,"pageSize","20");
	}	

	frm.submit();
}

function goKwd(str)
{
	var frm = getHistoryForm();

	CommonUtil.setValue(frm,"kwd",str);
	CommonUtil.setValue(frm,"pageNum","1");
	CommonUtil.setValue(frm,"reSrchFlag",false);

	frm.submit();
}

function goSort(str)
{
	var frm = getHistoryForm();

	CommonUtil.setValue(frm,"pageNum","1");
	CommonUtil.setValue(frm,"sort",str);
	
	frm.submit();

}

var CommonUtil = {
	
	/**
	* URL을 받아서 해당 결과를 String으로 리턴해줌
	* @ param   url		- 읽어올 페이지의 주소
	* 
	* @ return   str		-  url에서 보여지는 페이지 결과의 string
	*
	**/
	UtltoHtml : function (url) {
		var str = "";

		var xmlhttp = null;

		if(window.XMLHttpRequest) {
		   // FF 로 객체선언
		   xmlhttp = new XMLHttpRequest();
		} else {
		   // IE 경우 객체선언
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		if ( xmlhttp ) 
		{//비동기로 전송
			xmlhttp.open('GET', url, false);
			xmlhttp.send(null);
			str = xmlhttp.responseText;
		}
		return str;
	},
	
	/**
	* form 의 특정 name에 값을 세팅해줌 (라디오버튼, input,hidden, 셀렉트 박스) 알아서 처리해줌
	* @ param   frmobj		- 폼오브젝트
	* @ param	name			- 해당 데이터의 name
	* @ param	value			- 세팅될 값
	*
	* @ return   void
	* 
	* 주의사항
	* name이 복수개일경우 첫번째에 값을 세팅해줌
	**/
	setValue : function (frmobj, name, value) {
		if ( typeof(frmobj) == "object" && typeof(frmobj.length) == "number");
		{
			for (var i=0; i< frmobj.length; i++)
			{
				if (frmobj[i].name == name)
				{
					if (frmobj[i].type=="text" || frmobj[i].type=="hidden" )
					{// hidden , text
						frmobj[i].value = value;
						break;
					}//--end: hidden, text
					else if (frmobj[i].type=="radio" && frmobj[i].value == value )
					{// radio 버튼
						 frmobj[i].checked = true;
						 break;
					}//--end:radio
					else if (frmobj[i].type=="checkbox")
					{//checkbox박스
						if (value == true)
							frmobj[i].checked = true;
						else
							frmobj[i].checked = false;
						
						break;
					}//--end:checkbox
					else if (frmobj[i].type=="select-one" && typeof(frmobj[i].options) == "object" && typeof(frmobj[i].length) == "number")
					{//select박스
						var selectidx = 0;
						for(var j=0; j<frmobj[i].length; j++)
						{
							if (value == frmobj[i].options[j].value)
							{
								selectidx = j;
								break;
							}
						}
						frmobj[i].selectedIndex = selectidx;
					}//--end:select
					
				}
				
			}
		}
	},
	
	/**
	* form 의 특정 name에 값을 가져옴 (라디오버튼, input,hidden, 셀렉트 박스 알아서 처리됨  )
	* @ param   frmobj		- 폼오브젝트
	* @ param	name			- 해당 데이터의 name
	*
	* @ return   해당 frmobj의 특정 name에 있는 값(value)
	* 
	* 주의사항
	* name이 복수개일경우 첫번째에 값을 리턴
	**/
	getValue : function (frmobj, name)	{
		var result = null;

		if ( typeof(frmobj) == "object" && typeof(frmobj.length) == "number");
		{
			for (var i=0; i< frmobj.length; i++)
			{
				if (frmobj[i].name == name)
				{
					if (frmobj[i].type=="text" || frmobj[i].type=="hidden" )
					{// hidden , text
						result = frmobj[i].value;
						break;
					}//--end: hidden, text
					else if (frmobj[i].type=="radio" && frmobj[i].checked == true)
					{// radio 버튼
						 result = frmobj[i].value;
						 break;
					}//--end:radio
					else if (frmobj[i].type=="checkbox")
					{//checkbox박스
						result = frmobj[i].checked;
						break;
					}//--end:checkbox
					else if (frmobj[i].type=="select-one" && typeof(frmobj[i].options) == "object" && typeof(frmobj[i].length) == "number")
					{//select박스
						var idx = frmobj[i].selectedIndex;
						result = frmobj[idx].value;
						break;
					}
				}
			}
		}
		return result;
	},
	
	/**
	* form 의 특정 name에 값을 가져옴(라디오버튼, input,hidden, 셀렉트 박스 알아서 처리됨  )
	*
	* @ param   frmobj		- 폼오브젝트
	* @ param	name			- 해당 데이터의 name
	*
	* @ return   해당 frmobj의 특정 name에 있는 값(value)
	* 
	* 주의사항
	* name이 복수개일경우 공백(space)을 넣어 나열된 값을 리턴
	**/
	getValues : function (frmobj, name)	{
		var result = "";

		if ( typeof(frmobj) == "object" && typeof(frmobj.length) == "number");
		{
			for (var i=0; i< frmobj.length; i++)
			{
				if (frmobj[i].name == name)
				{
					if (frmobj[i].type=="text" || frmobj[i].type=="hidden" )
					{// hidden , text
						result += frmobj[i].value;
					}//--end: hidden, text
					else if (frmobj[i].type=="radio" && frmobj[i].checked == true)
					{// radio 버튼
						 result += frmobj[i].value;
					}//--end:radio
					else if (frmobj[i].type=="checkbox")
					{//checkbox박스
						result += frmobj[i].checked;
					}//--end:checkbox
					else if (frmobj[i].type=="select-one" && typeof(frmobj[i].options) == "object" && typeof(frmobj[i].length) == "number")
					{//select박스
						var idx = frmobj[i].selectedIndex;
						result += frmobj[idx].value;
					}
					
					result += " ";
				}
			}
		}
		return result;
	},
	
	/**
	* YYYYMMDD를 DATE() 형으로 변환
	*
	* @ param   str			- YYYYMMDD형 스트링 형태의 날짜값
	*
	* @ return   			- Date() 형 날짜값
	**/
	string2date : function (str)
	{
		var year = "";
        var month = "";
        var day = "";

        if (typeof (str) == "string") {
            if (str.length < 8)
			{
				alert("[error - search.js] : string2date() 8자리 날짜가 아닙니다");
                return null;
			}
            year = parseInt(str.substring(0, 4));
            month = parseInt(str.substring(4, 6));
            day = parseInt(str.substring(6, 8));

            return Date(year, month - 1, day);

        }
	},
	
	/**
	* DATE() 형을 YYYYMMDD String형으로 리턴
	*
	* @ param   date			- Date()형 값
	*
	* @ return   			- "YYYYMMDD" string형 날짜데이터
	**/	
	date2string : function (date)
	{
		var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();

        if (month < 10)
            month = "0" + month;
        if (day < 10)
            day = "0" + day;

        return year + "" + month + "" + day;
	},
	
	/**
	* 오늘 날짜 리턴 
	*
	* @ param   
	*
	* @ return   			- YYYYMMDD 오늘날짜
	**/	
	getToday : function () {
			if (typeof(this.todaystr) == "undefined")
			{
				this.todaystr = this.date2string(new Date());
				
			}
			return this.todaystr;
	},
	
	/**
	* 날짜계산 (일단위)
	*
	* @ param   p_strdate		- YYYYMMDD 
	* @ param   p_agoday		- 0 : 오늘 ,    음수 : 과거 ,   양수: 미래       (일(Day)단위)
	*
	* @ return   			- YYYYMMDD 에서 p_agoday일 전후 
	**/	
	calcDateDay : function (p_strdate, p_agoday) {
		var result = "";
		var year,month,day;
		var tmp_strdate = ""+p_strdate;	//string형으로 변환
		
        if (typeof (tmp_strdate) == "string") {
            if (tmp_strdate.length == 8)
			{
				year = parseInt(tmp_strdate.substring(0, 4));
				month = parseInt(tmp_strdate.substring(4, 6));
				day = parseInt(tmp_strdate.substring(6, 8));
				
				result = new Date(year, month-1, day + p_agoday);
			}	
		}
		return this.date2string(result);
	},
	
	/**
	* 날짜계산 (주단위)
	*
	* @ param   p_strdate		- YYYYMMDD 
	* @ param   p_agoweek		- 0 : 오늘 ,    음수 : 과거 ,   양수: 미래       (주(Week)단위)
	*
	* @ return   			- YYYYMMDD 에서 p_agoweek 주 전후 
	**/	
	calcDateWeek : function (p_strdate, p_agoweek) {
		var agoDay = p_agoweek * 7;
		
		return this.calcDateDay(p_strdate, agoDay );
	},
	
	/**
	* 날짜계산 (월단위)
	*
	* @ param   p_strdate		- YYYYMMDD 
	* @ param   agoMonth		- 0 : 오늘 ,    음수 : 과거 ,   양수: 미래       (월(Month)단위)
	*
	* @ return   			- YYYYMMDD 에서 agoMonth 월 전후 
	**/	
	calcDateMonth : function (p_strdate, agoMonth) {
		var result = "";
		var year,month,day;
		var tmp_strdate = ""+p_strdate;	//string형으로 변환
		
        if (typeof (tmp_strdate) == "string") {
            if (tmp_strdate.length == 8)
			{
				year = parseInt(tmp_strdate.substring(0, 4));
				month = parseInt(tmp_strdate.substring(4, 6));
				day = parseInt(tmp_strdate.substring(6, 8));
				
				result = new Date(year, month-1+agoMonth, day);
			}	
		}
		return this.date2string(result);
	},
	
	/**
	* 날짜계산 (년단위)
	*
	* @ param   p_strdate		- YYYYMMDD 
	* @ param   agoYear		- 0 : 오늘 ,    음수 : 과거 ,   양수: 미래       (년(Year)단위)
	*
	* @ return   			- YYYYMMDD 에서 agoYear 년 전후 
	**/	
	calcDateYear : function (p_strdate, agoYear) {
		var result = "";
		var agoMonth = (agoYear + 0) * 12
		var tmp_strdate = ""+p_strdate;	//string형으로 변환
		
        result = this.calcDateMonth(p_strdate,agoMonth);
		
		return result;
	},
	
	/**
	* 문자열 치환
	*
	* @ param   target		- 원본 text
	* @ param   oldstr		- 변경 대상 string
	* @ param   newstr	- 변경될 string
	*
	* @ return   		- 치환된 text
	**/	
	replaceAll : function (target, oldstr, newstr)
	{
		var result = target;
		if (target != null)
		{
			result = target.split(oldstr).join(newstr);
		}
		return result;
	},
	
	/**
	* white Space제거
	*
	* @ param   str		- 문자열
	*
	* @ return   		- 제거된 문자열
	**/	
	trim : function (str)
	{
		var result = str;
		if (str != null)
		{
			result = result.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
		}
		return result;
	},
	
	//엘레먼트의 절대값 y픽셀을 구함
	getElementY : function(element)
	{
		var targetTop = 0;

		if (element.offsetParent)
		{
			while (element.offsetParent)
			{
				targetTop += element.offsetTop;
	            element = element.offsetParent;
			}
		}
		else if(element.y)
		{
			targetTop += element.y;
	    }

		return targetTop;
	},
	//엘레먼트의 절대값 x픽셀을 구함
	getElementX : function(element)
	{
		var targetTop = 0;

		if (element.offsetParent)
		{
			while (element.offsetParent)
			{
				targetTop += element.offsetLeft;
	            element = element.offsetParent;
			}
		}
		else if(element.x)
		{
			targetTop += element.x;
		}

		return targetTop;
	}
}

function gotoPage(pageNum)
{
	var frm = getHistoryForm();

	CommonUtil.setValue(frm,"pageNum",pageNum);
	
	frm.submit();
}

function navAnchor( funcName, pageNo, anchorText )
{
	var font_class = "   <a href=\"javascript:{" + funcName + "(" + pageNo + ")}\">" + anchorText + "</a>   ";
	return font_class;
}

function pageNav( funcName, pageNum, pageSize, total )
{
	if( total < 1 )
		return "";

	var ret = "";
	var PAGEBLOCK=10;
	var totalPages = Math.floor((total-1)/pageSize) + 1;

	var firstPage = Math.floor((pageNum-1)/PAGEBLOCK) * PAGEBLOCK + 1;
	if( firstPage <= 0 ) // ?
		firstPage = 1;

	var lastPage = firstPage-1 + PAGEBLOCK;
	if( lastPage > totalPages )
		lastPage = totalPages;

	if( firstPage > PAGEBLOCK )
	{
        ret += navAnchor(funcName, 1, "<img src='./images/search/prev_arrow.gif' border='0' align='absmiddle'>");
		ret += navAnchor(funcName, firstPage-1, "<img src='./images/search/prev_arrow_01.gif' border='0' align='absmiddle'>") ;
	}

	for( i=firstPage; i<=lastPage; i++ )
	{
		if( pageNum == i )
			ret += "<strong>" + i + "</strong>";
		else
			ret += "  " + navAnchor(funcName, i, i) + "  ";
	}

	if( lastPage < totalPages )
	{
		ret += navAnchor(funcName, lastPage+1, "<img src='./images/search/next_arrow_01.gif' border='0'>") + "";
		ret += "" + navAnchor(funcName, totalPages, "<img src='./images/search/next_arrow.gif' border='0'>") + "\n";
	}

	return ret;
}

