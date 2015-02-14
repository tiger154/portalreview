var page = {
	pageLink: function(cPageNum, cPage, cPageRow, cTotalRowCount, methodName) {
		var prevPage = 0;
		var nextPage = 0;
		var lastPage = 0;
	
		var firstPageLink = "";
		var prevPageLink = "";
		var backLink = "";
		var pageLink = "";
		var forwardLink = "";
		var nextPageLink = "";
		var lastPageLink = "";	
		var cPage = Number(cPage);	
		var link = new Array();
		if((cTotalRowCount % cPageRow) > 0) {
			lastPage = parseInt(cTotalRowCount/cPageRow) + 1;
		} else {
			lastPage = parseInt(cTotalRowCount/cPageRow);
		}
		if(cPage > 1) {
			prevPage = cPage - 1;
			prevPageLink = "<a href=javascript:"+methodName+"("+prevPage+");>이전</a>&nbsp;";
		} else {
			prevPageLink = "이전&nbsp;";
		}
		if(cPage < lastPage) {
			nextPage = cPage + 1;
			nextPageLink = "<a href=javascript:"+methodName+"("+nextPage+");>다음</a>&nbsp;";
		} else {
			nextPageLink = "다음";
		}
		if(cPage != 1) {
			firstPageLink = "<a href=javascript:"+methodName+"(1);>처음페이지</a>&nbsp;";
		} else {
			firstPageLink = "";
		}
		if((pageLink != 1) && (cPage != lastPage)) {
			lastPageLink = "<a href=javascript:"+methodName+"("+lastPage+");>마지막페이지</a>";
		} else {
			lastPageLink = "";
		}		
		var mok = parseInt(cPage / cPageNum);
		var namuzi = parseInt(cPage % cPageNum);
		if(namuzi == 0 && mok > 0) {
			mok--;
		}
		var startPage = mok * cPageNum + 1;
		var endPage = (mok + 1) * cPageNum;
		if(mok > 0) {
			var targetPage = startPage - 1;
			backLink = "<a href=javascript:"+methodName+"("+targetPage+");>이전목록</a>";
		} else {
			backLink = "";
		}
		for(var i=startPage; i<=endPage; i++)
		{
			if(i > lastPage) { break; }		
			if(i == cPage) {
				pageLink += "<strong>"+i+"</strong>";
			} else {
				pageLink += "<a href=javascript:"+methodName+"("+i+");><u>"+i+"</u></a>";
			}
			pageLink += "&nbsp;";
		}
		if(endPage < lastPage) {
			targetPage = endPage + 1;
			forwardLink = "<a href=javascript:"+methodName+"("+targetPage+");>다음목록</a>";
		} else {
			forwardLink = "";
		}
		
		//alert(pageLink);
		//alert(firstPageLink+prevPageLink+backLink+pageLink+forwardLink+nextPageLink+lastPageLink);
		link['firstPageLink'] = firstPageLink;
		link['prevPageLink'] = prevPageLink;
		link['backLink'] = backLink;
		link['pageLink'] = pageLink;
		link['forwardLink'] = forwardLink;
		link['nextPageLink'] = nextPageLink;
		link['lastPageLink'] = lastPageLink;
		return link;
	
		//pageObj.innerHTML("페이지정보");
		//obj.innerHTML(firstPageLink+prevPageLink+backLink+pageLink+forwardLink+nextPageLink+lastPageLink);
		/*
		document.write(firstPageLink);	
		document.write(prevPageLink);
		document.write(backLink);
		document.write(pageLink);
		document.write(forwardLink);
		document.write(nextPageLink);	
		document.write(lastPageLink);
		*/
	}
};