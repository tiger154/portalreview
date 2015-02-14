<?php
class Page
{	
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

	public function Page()
	{
		$this->page = 1;
		$this->pageNum = 10;
		$this->pageRow = 15;		
	}
	
	public function set($name, $val) {
		if($val != '') {
			$this->{$name} = $val;
		}
	}
	
	public function script($module, $page, $param)
	{
		$script = "common.redirect('";
		$url = $module."/".$page."/".$this->pageNum."/".$this->pageRow;
		for($i=0; $i<sizeof($param); $i++) {
			$url .= "/".$param[$i];
		}
		$script .= $url."')";
		return $script;
	}
	
	public function getLimit()
	{
		if($page < 1) {
			$limit = "LIMIT 0, ". $this->pageRow;
		} else {
			$limit = "LIMIT ".($this->page - 1) * $this->pageRow.",".$this->pageRow;
		}		
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

	public function pageLink($module, $param)
	{
		$this->pageLink			= ""; 
		$this->prevPageLink		= ""; 
		$this->nextPageLink		= ""; 
		$this->firstPageLink	= ""; 
		$this->lastPageLink		= ""; 
		$this->backLink			= ""; 
		$this->forwardLink		= ""; 

		$this->imgFirst = "<input type='button' value='<<'>";
		$this->imgPrevList = "<input type='button' value='<'>";
		$this->imgPrev = "<";
		$this->imgNext = ">";
		$this->imgNextList = "<input type='button' value='>'>";
		$this->imgLast = "<input type='button' value='>>'>";
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
			$script = $this->script($module, "1", $param);
			$this->firstPageLink = "<a href=\"javascript:".$script.";\">".$this->imgFirst."</a>";
		}

		if(($pageLink != "1") && ($this->page != $this->lastPage)) {
			$script = $this->script($module, $this->lastPage, $param);
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
			$script = $this->script($module, $targetPage, $param);
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
				$script = $this->script($module, $i, $param);
				$this->pageLink .= "<a href=\"javascript:".$script.";\">".$i."</a></span>";
			}
			$this->pageLink .= "&nbsp;";
		}

		if($endPage < $this->lastPage) {
			$targetPage = $endPage + 1;
			$script = $this->script($module, $targetPage, $param);
			$this->forwardLink = "<a href=\"javascript:".$script.";\">".$this->imgNextList."</a>";
		}
	}
}
?>