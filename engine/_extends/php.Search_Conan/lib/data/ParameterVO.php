<?php
/** 
 * @author KONAN Technology
 * @since 2010.04.01
 * @version 1.0
 */

class ParameterVO{
    
	var $kwd;
	
    	var $preKwds;
    
    	var $category;

    	var $recKwd;
    
    	var $reSrchFlag;

    	var $srchFd;
    
    	var $siteName;
    
    	var $userId;
    
    	var $pageSize;

		var $reviewPageSize;

		var $frontierPageSize;

		var $bloggerPageSize;

		var $blogPageSize;
    
    	var $pageNum;
    
    	var $sort;
    
    	var $detailSearch;
    
    	var $exclusiveKwd;
  
    	var $date;
    
    	var $startDate;
    
    	var $endDate;

		var $hilightTxt;
    
	function setKwd( $p_kwd ){
		$this->kwd = $p_kwd;
	}

	function getKwd(){
		return $this->kwd;
	}
	
	function setPreKwds($p_preKwd){
		$this->preKwds = $p_preKwd;
	}

	function getPreKwds(){
		return $this->preKwds;
	}
	
	function setHilight( $p_hilight ){
		$this->hilight = $p_hilight;
	}

	function getHilight(){
		return $this->hilight;
	}
	
	function setCategory( $p_cate ){
		$this->category = $p_cate;
	}

	function getCategory(){
		return $this->category;
	}

	function setRecKwd( $p_recKwd ){
		$this->recKwd = $p_recKwd;
	}

	function getRecKwd(){
		return $this->recKwd;
	}

	function setReSrchFlag( $p_reSrchFlag ){
		$this->reSrchFlag = $p_reSrchFlag;
	}

	function getReSrchFlag(){
		return $this->reSrchFlag;
	}
	
	function setSrchFd( $p_srchFd ){
		$this->srchFd = $p_srchFd;
	}

	function getSrchFd(){
		return $this->srchFd;
	}
	
	function setSiteName( $p_siteName ){
		$this->siteName = $p_siteName;
	}

	function getSiteName(){
		return $this->siteName;
	}
	
	function setUserId( $p_userId ){
		$this->userId = $p_userId;
	}

	function getUserId(){
		return $this->userId;
	}
	
	function setPageNum($p_pageNum){
		$this->pageNum = $p_pageNum;
	}

	function getPageNum(){
		return $this->pageNum;
	}

	function setPageSize($p_pageSize){
		$this->pageSize = $p_pageSize;
	}

	function getPageSize(){
		return $this->pageSize;
	}

	function setReviewPageSize($reviewPageSize){
		$this->reviewPageSize = $reviewPageSize;
	}

	function getReviewPageSize(){
		return $this->reviewPageSize;
	}

	function setFrontierPageSize($frontierPageSize){
		$this->frontierPageSize = $frontierPageSize;
	}

	function getFrontierPageSize(){
		return $this->frontierPageSize;
	}

	function setBloggerPageSize($bloggerPageSize){
		$this->bloggerPageSize = $bloggerPageSize;
	}

	function getBloggerPageSize(){
		return $this->bloggerPageSize;
	}
	
	function setBlogPageSize($blogPageSize){
		$this->blogPageSize = $blogPageSize;
	}

	function getBlogPageSize(){
		return $this->blogPageSize;
	}

	function setHilightText($hilightTxt){
		$this->hilightTxt = $hilightTxt;
	}

	function getHilightText(){
		return $this->hilightTxt;
	}

	function setSort($p_sort){
		$this->sort = $p_sort;
	}

	function getSort(){
		return $this->sort;
	}
	
	function setDetailSearch($p_detailSearch){
		$this->detailSearch = $p_detailSearch;
	}

	function getDetailSearch(){
		return $this->detailSearch;
	}
	
	function setExclusiveKwd($p_exclusiveKwd){
		$this->exclusiveKwd = $p_exclusiveKwd;
	}

	function getExclusiveKwd(){
		return $this->exclusiveKwd;
	}
	
	function setDate($p_date){
		$this->date = $p_date;
	}

	function getDate(){
		return $this->date;
	}
	
	function setStartDate($p_startDate){
		$this->startDate = $p_startDate;
	}

	function getStartDate(){
		return $this->startDate;
	}
	
	function setEndDate($p_endDate){
		$this->endDate = $p_endDate;
	}

	function getEndDate(){
		return $this->endDate;
	}	
}
?>
