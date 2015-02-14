<?
/** 파라미터 Value Object.
 * @author KONAN Technology
 * @since 2010.04.01
 * @version 1.0
 */
Class ParameterVO{
    //검색키워드
    var $kwd;
    
    //이전 키워드
    var $preKwds;
    
    //검색 카테고리(탭)
    var $category;

    //추천검색어 정보
    var $recKwd;
    
    //재검색 여부 (boolean)
    var $reSrchFlag;

    //검색대상 (필드)
    var $srchFd;
    
    //사이트명 
    var $siteName;
    
    //유저ID
    var $userId;
    
    //페이지사이즈
    var $pageSize;
    
    //검색결과페이지번호
    var $pageNum;
    
    //정렬 
    var $sort;
    
    //상세검색 여부 플래그
    var $detailSearch;
    
    /** 제외어 */
    var $exclusiveKwd;
  
    /** 날짜선택사항 */
    var $date;
    
    // 날짜검색 - 시작일
    var $startDate;
    
    // 날짜검색 - 종료일
    var $endDate;
    
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
