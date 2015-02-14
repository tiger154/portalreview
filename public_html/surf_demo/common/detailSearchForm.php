<?
	//상세검색 후 상세검색 레이어 유지를 위한 코드
	$cName = "hidden";
	if ($srchParam->getDetailSearch()=="true") {
		$cName = "";
	}
?>	
	<!-- 상세검색 -->
  	<div id="advanced_search" class="<?=$cName?>">
  		<form name="detailSearchForm" onsubmit="return detailSeachKwd(this);">
  		
  		<div class="titlebox">상세검색</div>
  		<table border="0" cellspacing="0" cellpadding="0">
  			<caption>상세검색</caption>
   			<tr>
    			<th>키워드 :</th>
   				<td><input type="text" name="kwd" class="type-text" id="textfield" style="width:250px;" value="<?=$srchParam->getKwd()?>"  autocomplete="off"/></td>
   			</tr>
   			<tr>
   				<th>제외어 :</th>
   				<td><input type="text" name="xwd" class="type-text" id="textfield" style="width:250px;" value="<?=$srchParam->getExclusiveKwd()?>" autocomplete="off"/></td>
   			</tr>
   			<tr>
    			<th>카테고리 : </th>
    			<td><span><input type="radio" name="category" id="category" value="TOTAL" <?=makeReturnValue("TOTAL", $srchParam->getCategory(), "checked", "")?>/>전체</span>
    				<span><input type="radio" name="category" id="category" value="CATEGORY1" <?=makeReturnValue("CATEGORY1", $srchParam->getCategory(), "checked", "")?>/>카테고리1</span>
        			<span><input type="radio" name="category" id="category" value="CATEGORY2" <?=makeReturnValue("CATEGORY2", $srchParam->getCategory(), "checked", "")?>/>카테고리2</span>
        			<span><input type="radio" name="category" id="category" value="CATEGORY3" <?=makeReturnValue("CATEGORY3", $srchParam->getCategory(), "checked", "")?>/>카테고리3</span>
        			<span><input type="radio" name="category" id="category" value="CATEGORY4" <?=makeReturnValue("CATEGORY4", $srchParam->getCategory(), "checked", "")?>/>카테고리4</span>
        			<span><input type="radio" name="category" id="category" value="CATEGORY5" <?=makeReturnValue("CATEGORY5", $srchParam->getCategory(), "checked", "")?>/>카테고리5</span>

        		</td>
  			</tr>
  			<tr>
    			<th>범위 : </th>
    			<td><span><input type="radio" name="srchFd" id="srchFd" value="all" <?=makeReturnValue("all", $srchParam->getSrchFd(), "checked", "")?>/>전체</span>
    				<span><input type="radio" name="srchFd" id="srchFd" value="title" <?=makeReturnValue("title", $srchParam->getSrchFd(), "checked", "")?>/>제목</span>
        			<span><input type="radio" name="srchFd" id="srchFd" value="contents" <?=makeReturnValue("contents", $srchParam->getSrchFd(), "checked", "")?>/>본문</span>
        			<span><input type="radio" name="srchFd" id="srchFd" value="writer" <?=makeReturnValue("writer", $srchParam->getSrchFd(), "checked", "")?>/>작성자</span>
        			<span><input type="radio" name="srchFd" id="srchFd" value="file" <?=makeReturnValue("file", $srchParam->getSrchFd(), "checked", "")?>/>첨부파일</span>
        		</td>
        		<!-- 
        		//검색 대상 필드가 다중 선택(checkbox)일 경우
    			//<td><span><input type="checkbox" name="srchFd" id="srchFd" value="all" <?//=setChecked("all", srchParam.getSrchFd())?>/>전체</span>
    			//	<span><input type="checkbox" name="srchFd" id="srchFd" value="title" <?//=setChecked("title", srchParam.getSrchFd())?>/>제목</span>
        		//	<span><input type="checkbox" name="srchFd" id="srchFd" value="content" <?//=setChecked("content", srchParam.getSrchFd())?>/>본문</span>
        		//	<span><input type="checkbox" name="srchFd" id="srchFd" value="writer" <?//=setChecked("writer", srchParam.getSrchFd())?>/>작성자</span>
        		//	<span><input type="checkbox" name="srchFd" id="srchFd" value="file" <?//=setChecked("file", srchParam.getSrchFd())?>/>첨부파일</span>
        		//</td>
        		-->
  			</tr>
  			<tr>
    			<th>기간 :</th>
    			<td><span><input type="radio" onclick="choiceDatebutton('startDate','endDate',this.value);" name="date" id="date" value="0" <?=makeReturnValue("0", $srchParam->getDate(), "checked", "")?>/>전체</span>
    				<span><input type="radio" onclick="choiceDatebutton('startDate','endDate',this.value);" name="date" id="date" value="1" <?=makeReturnValue("1", $srchParam->getDate(), "checked", "")?>/>당일</span>
        			<span><input type="radio" onclick="choiceDatebutton('startDate','endDate',this.value);" name="date" id="date" value="30" <?=makeReturnValue("30", $srchParam->getDate(), "checked", "")?>/>1개월</span>
        			<span><input type="radio" onclick="choiceDatebutton('startDate','endDate',this.value);" name="date" id="date" value="90" <?=makeReturnValue("90", $srchParam->getDate(), "checked", "")?>/>3개월</span>
        			<span><input type="radio" onclick="choiceDatebutton('startDate','endDate',this.value);" name="date" id="date" value="180" <?=makeReturnValue("180", $srchParam->getDate(), "checked", "")?>/>6개월</span>
        			<span><input type="radio" onclick="choiceDatebutton('startDate','endDate',this.value);" name="date" id="date" value="365" <?=makeReturnValue("365", $srchParam->getDate(), "checked", "")?>/>1년</span>
        			<span><input type="radio" onclick="choiceDatebutton('startDate','endDate',this.value);" name="date" id="date" value="1095" <?=makeReturnValue("1095", $srchParam->getDate(), "checked", "")?>/>3년</span>
        			<span><input type="radio" name="date" id="date" value="select" <?=makeReturnValue("select", $srchParam->getDate(), "checked", "")?>/>기간입력
        			<input name="startDate" id="startTxt" value="<?=$srchParam->getStartDate()?>" class="type-text"  style="width:75px;"/>
        			<a href="javascript:showCalendar('date','startTxt','calendar_view',575,185);" class="calendar_box_off" onmouseover="this.className='calendar_box_on';" onmouseout="this.className='calendar_box_off';" ><img src="image/btn_calendar.gif" alt="달력열기"/></a>
        			~
        			<input name="endDate" id="endTxt" value="<?=$srchParam->getEndDate()?>" class="type-text"  style="width:75px;"/>
        			<a href="javascript:showCalendar('date','endTxt','calendar_view',693,185);" class="calendar_box_off" onmouseover="this.className='calendar_box_on';" onmouseout="this.className='calendar_box_off';" ><img src="image/btn_calendar.gif" alt="달력열기"/></a></span>
        		</td>
			</tr>
			<tr>
    			<th>정렬 :</th>
    			<td><select name="sort" id="sort">
     					<option value="r"  <?=makeReturnValue("r", $srchParam->getSort(), "checked", "")?>>정확도순</option>
		     			<option value="d"  <?=makeReturnValue("d", $srchParam->getSort(), "checked", "")?>>최신날짜순</option>
    				</select>		    
    			</td>
 			</tr>
 		</table>
	 	<div class="btn_box">
	 		<input type="image" src="image/btn_search.gif" value="" class="mr5"/><a onclick="" href=""><img src="image/btn_cancel.gif" alt="취소"/></a>
	 		<!-- <a href="javascript:detailSeachKwd(this)"><img src="image/btn_search.gif" alt="검색버튼" class="mr5"/></a> -->
	 	</div>
	 	<input type="hidden" name="detailSearch" value="true"/>
	 	</form>
	 	<!-- 달력이 보여질 레이어 -->
		<div id="calendar_view">
		</div>
		<!--// 달력이 보여질 레이어 -->
	</div>
  	<!-- //상세검색 -->
	<!--  아래 내용은 필요시 사용 
	<tr>
	<th>분류 : </th>
		<td><span><input type="radio" name="radio" id="radio" value="radio" />전체</span>
			<span><input type="radio" name="radio" id="radio" value="radio" />제목</span>
			<span><input type="radio" name="radio" id="radio" value="radio" />본문</span>
			<span><input type="radio" name="radio" id="radio" value="radio" />첨부</span>
			<span><input type="radio" name="radio" id="radio" value="radio" />제목+본문</span>
			<span><input type="radio" name="radio" id="radio" value="radio" />제목+본문+첨부</span>    		</td>
	</tr>
	<tr>
		<th colspan="2" class="dot_line"></th>
	</tr>
	<tr>
		<th>첨부파일 :</th>
		<td><input name="textfield" type="text" class="type-text" id="textfield" style="width:250px;" value="text"/></td>
	</tr>
	<tr>
		<th colspan="2" class="dot_line"></th>
	</tr>
	<tr>
		<th>권한 :</th>
		<td><select name="select3" id="select3">
	     		<option>default</option>
	 			</select></td>
	</tr>
	 -->
