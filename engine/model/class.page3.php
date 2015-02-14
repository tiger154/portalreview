<?php
class Page3
{
	var $paramNum;
	var $page;	
	var $pageNum;
	var $pageRow;
	
	var $totalRowCount;
	var $prevPageLink;
	var $nextPageLink;
	var $firstPageLink;
	var $lastPageLink;
	var $pageLink;
	var $lastPage;
	var $backLink;
	var $forwardLink;

	var $imgFirtst;
	var $imgPrevList;
	var $imgPrev;
	var $imgNext;
	var $imgNextList;
	var $imgLast;
	
	public function Page3($paramNum=0, $page=1, $pageNum=10, $pageRow=15)
	{
		$this->paramNum = (empty($paramNum)) ? 0 : $paramNum; 
		$this->page = (empty($page)) ? 1 : $page;		
		$this->pageNum = (empty($pageNum)) ? 10 : $pageNum;	
		$this->pageRow = (empty($pageRow)) ? 15 : $pageRow;	
	}
	
	public function set($name, $val) {
		//echo "val:$val";
		if($val != '') {
			$this->{$name} = $val;
		}
	}

	
	public function script($module, $page, $param, $omit)
	{	
		$script = "common.redirect('";
		$url = $module;
		$length = (sizeof($param) > $this->paramNum) ? sizeof($param) : $this->paramNum+1;
		for($i=0; $i<$length; $i++) {
			$url .= "/";
			if($omit == true && $i == 0) $url .= "@";
			if($i == $this->paramNum) $url .= $page;
			else $url .= $param[$i];
		}
		$script .= $url."')";
		return $script;
	}
	
	public function getLimit()
	{
		$limit = "LIMIT ".($this->page - 1) * $this->pageRow.",".$this->pageRow;
		//echo $limit;	
		return $limit;
	}
	
	public function getLink()
	{
		if($this->totalRowCount > 0) {
			$link = $this->firstPageLink."&nbsp;";
			$link .= $this->backLink."&nbsp;";
			$link .= $this->prevPageLink."&nbsp;";
			$link .= $this->pageLink."&nbsp;";
			$link .= $this->nextPageLink."&nbsp;";
			$link .= $this->forwardLink."&nbsp;";
			$link .= $this->lastPageLink;		
			return $link;
		} else {
			return "";
		}
	}

	public function getLinkFrontier()
	{
		if($this->totalRowCount > 0) {
			//$link = $this->firstPageLink."&nbsp;";
			$link .= $this->backLink."&nbsp;";
			$link .= $this->prevPageLink."&nbsp;";
			$link .= $this->pageLink."&nbsp;";
			$link .= $this->nextPageLink."&nbsp;";
			$link .= $this->forwardLink."&nbsp;";
			//$link .= $this->lastPageLink;
			return $link;
		} else {
			return "";
		}
	}

	public function pageLink($module, $param, $omit=false)
	{
		$this->pageLink			= ""; // 페이지링크
		$this->prevPageLink		= ""; // 이전 목록 링크
		$this->nextPageLink		= ""; // 다음 목록 링크
		$this->firstPageLink	= ""; // 처음 페이지 링크
		$this->lastPageLink		= ""; // 마지막 페이지 링크
		$this->backLink			= ""; // 이전 페이지
		$this->forwardLink		= ""; // 다음 페이지
		$this->imgFirst = "<img src='"._DIR_IMAGES_."/common/ico/text_pre.gif' alt='처음목록' />";
		$this->imgPrevList = "<img src='"._DIR_IMAGES_."/common/ico/text_pre.gif' alt='이전목록' />";
		$this->imgPrev = "<img src='"._DIR_IMAGES_."/common/ico/text_pre.gif' alt='이전페이지' />";
		$this->imgPrev = "<img src='"._DIR_IMAGES_."/common/ico/text_next.gif' alt='다음페이지' />";
		$this->imgNextList = "<img src='"._DIR_IMAGES_."/common/ico/text_next.gif' alt='다음목록' />";
		$this->imgLast = "<img src='"._DIR_IMAGES_."/common/ico/text_next.gif' alt='마지막목록' />";
		$page = $this->page;

		if(($this->totalRowCount % $this->pageRow) > 0) {
			$this->lastPage = (int)($this->totalRowCount/$this->pageRow) + 1;
		} else {
			$this->lastPage = (int)($this->totalRowCount/$this->pageRow);
		}

		if($this->page > 1) {
			$prevPage = $page - 1;
			//$this->prevPageLink = "<a href=\"javascript:".$search."(".$prevPage.");\">".$this->imgPrev."</a>&nbsp;";
		} else {
			//$this->prevPageLink = $this->imgPrev."&nbsp;";
		}

		if($this->page < $this->lastPage) {
			$nextPage = $page + 1;
			//$this->nextPageLink = "<a href=\"javascript:".$search."(".$nextPage.");\">".$this->imgNext."</a>&nbsp;";
		} else {
			//$this->nextPageLink = $this->imgNext;
		}

		if($this->page != "1") {			
			//$this->firstPageLink = "<a href=\"javascript:".$search."(1,'".$module."');\">".$this->imgFirst."</a>";
			$script = $this->script($module, "1", $param, $omit);
			$this->firstPageLink = "<a href=\"javascript:".$script.";\">".$this->imgFirst."</a>";
		}

		if(($pageLink != "1") && ($this->page != $this->lastPage)) {
			$script = $this->script($module, $this->lastPage, $param, $omit);
			$this->lastPageLink = "<a href=\"javascript:".$script."\");\>".$this->imgLast."</a>";
		}

		$mok = (int)($this->page / $this->pageNum);
		$namuzi = (int)($this->page % $this->pageNum);
		if($namuzi == 0 && $mok > 0) {
			$mok--;
		}
		$startPage = $mok * $this->pageNum + 1;
		$endPage = ($mok + 1) * $this->pageNum;

		if($mok > 0) {
			$targetPage = $startPage - 1;
			$script = $this->script($module, $targetPage, $param, $omit);
			$this->backLink = "<a href=\"javascript:".$script.";\">".$this->imgPrevList."</a>";
		}

		for($i=$startPage; $i<=$endPage; $i++)
		{
			if($i > $this->lastPage) { break; }
			if($i == $this->page) {
				//$this->pageLink .= "&nbsp;<strong>$i</strong>&nbsp;";
				$this->pageLink .= "<span class=\"myboard_num\"><strong>".$i."</strong></span>";
			} else {
				//$this->pageLink .= "&nbsp;<a href=\"javascript:search($i);\"><u>$i</u></a>&nbsp;";
				$script = $this->script($module, $i, $param, $omit);
				$this->pageLink .= "<a href=\"javascript:".$script.";\">".$i."</a></span>";
			}
			$this->pageLink .= "&nbsp;";
		}
		if($endPage < $this->lastPage) {
			$targetPage = $endPage + 1;
			$script = $this->script($module, $targetPage, $param, $omit);
			$this->forwardLink = "<a href=\"javascript:".$script.";\">".$this->imgNextList."</a>";
		}
	}
}
?>