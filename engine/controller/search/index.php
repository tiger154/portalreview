<?php
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $DESIGN;


$CLASS_SEARCH = &Module::singleton("Api.Search");	
$CLASS_SITE = &Module::singleton("Site.Site"); 

$DB = &Module::loadDb("revu");


require_once(_DIR_EXTENDS."/php.Search_Conan/lib/util/DCConfig.php");
require_once(_DIR_EXTENDS."/php.Search_Conan/lib/DOCRUZER.php");

/****** 설정파일로부터 값 읽어오기 ******/
$xml = new DCConfig;
$serverInfo = $xml->xmlOpen(_DIR_EXTENDS.'/php.Search_Conan/conf/search_config.xml','searchInfo');
/****************************************/

require(_DIR_EXTENDS."/php.Search_Conan/lib/data/ParameterVO.php");
require(_DIR_EXTENDS."/php.Search_Conan/lib/data/ResultVO.php");
require(_DIR_EXTENDS."/php.Search_Conan/lib/util/CommonUtil.php");
require(_DIR_EXTENDS."/php.Search_Conan/lib/util/DCUtil.php");
require(_DIR_EXTENDS."/php.Search_Conan/lib/module/SearchModule.php");

//ResultVO 선언
$rsbReview = new ResultVO();
$rsbStyle = new ResultVO();
$rsbFrontier = new ResultVO();
$rsbBlogger = new ResultVO();
$rsbBlog = new ResultVO();

//ParameterVO 선언
$srchParam = new ParameterVO();

/******* 파라미터 값을 가져옴 **********/
include(_DIR_EXTENDS."/php.Search_Conan/common/setParameter.php");
/***************************************/

/************** 오타 교정 *************/
/*
$rc_crx = crx_connect($hd_crx, "121.189.18.89:7577", "konan", "konan", "");

if ($rc_crx<0) {
	echo "error : ".crx_get_error_message($hd_crx)."\n";
	crx_disconnect($hd_crx);
	exit;
} else {
	$request_name = "SPELL_CHECK";
	$request_family = "SPC";

	$rc_crx = crx_clear_request($hd_crx);
	$rc_crx = crx_put_request_name($hd_crx, $request_name);

	$strKwd =	$srchParam->getKwd();
	//$strKwd = iconv('euc-kr','utf-8',$srchParam->getKwd());

	//echo "@@@".$strKwd."<br>";

	crx_put_request_family($hd_crx, $request_family);
   crx_put_request_param($hd_crx, "INPUT_WORD", "CHAR", strlen($strKwd), $strKwd);
	 crx_put_request_param($hd_crx, "LANGUAGE", "INT32", 1, 1);
	crx_put_request_param($hd_crx, "CHARSET", "INT32", 1, 4);

	//	crx_put_request_param($hd, "DOMAIN_NO", "INT32", 1, 0);
	//crx_put_request_param($hd, "MAX_RESULT_COUNT", "INT32", 1, 10);
	//crx_put_request_param($hd, "LANGUAGE", "INT32", 1, 1);
	//crx_put_request_param($hd, "CHARSET", "INT32", 1, 4);


	$rc_crx = crx_submit_request($hd_crx);
	

	//$rc_crx = crx_receive_response($hd_crx);

//	crx_disconnect($hd_crx);

	//echo "count:".$crx_param_count."<br>";
}

*/
if($srchParam->getKwd() != "Ehkg") {
	$euckr_kwd = iconv('utf-8','euc-kr',$srchParam->getKwd());
	$arrCorrectedKwd = iconv('euc-kr','utf-8',getCorrectedKwd($euckr_kwd));	


	//getCorrectedKwd_CRX("Ehkg");
}

/**************************************/

if($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "review"){
	include(_DIR_EXTENDS."/php.Search_Conan/common/query/review.query.php");
}
/*
if($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "style"){
	include(_DIR_EXTENDS."/php.Search_Conan/common/query/style.query.php");
}
*/
if($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "frontier"){
	include(_DIR_EXTENDS."/php.Search_Conan/common/query/frontier.query.php");
}
if($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "blogger"){
	include(_DIR_EXTENDS."/php.Search_Conan/common/query/blogger.query.php");
}
if($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "blog"){
	include(_DIR_EXTENDS."/php.Search_Conan/common/query/blog.query.php");
}

$TOTAL_ALL = $rsbReview->getTotal() + $rsbStyle->getTotal() + $rsbFrontier->getTotal() + $rsbBlogger->getTotal() + $rsbBlog->getTotal();


/************** 인기검색어 *************/
include(_DIR_EXTENDS."/php.Search_Conan/common/module/ppk.php");
/**************************************/

/************** 추천검색어 **************/
include(_DIR_EXTENDS."/php.Search_Conan/common/module/kre.php");
/**************************************/

// 검색결과 처리
if($TOTAL_ALL > 0){
	if($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="review"){
	include(_DIR_EXTENDS."/php.Search_Conan/result/review.result.php");
}
/*
	if($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="style"){
	include(_DIR_EXTENDS."/php.Search_Conan/result/style.result.php");
}
*/
	if($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="frontier"){
	include(_DIR_EXTENDS."/php.Search_Conan/result/frontier.result.php");
}
	if($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="blogger"){
	include(_DIR_EXTENDS."/php.Search_Conan/result/blogger.result.php");
	}
	if($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="blog"){
	include(_DIR_EXTENDS."/php.Search_Conan/result/blog.result.php");
}
}else{
	include(_DIR_EXTENDS."/php.Search_Conan/result/noResult.php");
}

$preKwdValues = makeHtmlForPreKwd($srchParam);
//echo $preKwdValues;

//재검색 체크값 부여
if($srchParam->getReSrchFlag() == "true" or $srchParam->getReSrchFlag() == "on"){
	$reSrchChkValue = "checked";	
}


$noticeReview['list'] = $CLASS_SITE->getNoticeReview($DB, "");



/*
 @SearchFrendType Function
 @return type : TEXT
   - 0:each other friend,1:Friend i add,2:Friend they add ,3 : nothing    
 @[require]param <userno>  : Login user seqno
 @[require]param <fuserno> : Target friend seqno
*/

if ($_SESSION['userno'] != ""){	
	$userno =  $_SESSION['userno']; // It possible to change logined user Session Seqno -> $_SESSION['userno'] , ex) 126494; 
	$fuserno = $_POST['fuserno']; //100831;
	//$userno = 126494; 
	//$fuserno = 100831;
	$ftype = $CLASS_SEARCH->SearchFrendType($DB, $userno, $fuserno);
}else{
	$ftype = null;
}

/*
if($srchParam->getReSrchFlag() == "true"){
	$query = makePreQuery($srchFdNm, $kwd, $srchParam->getPreKwds(), count($srchParam->getPreKwds()), $srchMthd);

	for($k=count($preKwds);$k>=0;$k--){
		$hilightTxt = $hilightTxt." ".$preKwds[$k];
	}

	$hilightTxt = $hilightTxt." ".$kwd;

}else{
	$hilightTxt = $kwd;
}
*/

//하이라이팅
$hilightTxt_s = "";
$firstKwd = "";
$endKwd = "";

if($srchParam->getReSrchFlag() == "true"){
	$preKwds = $srchParam->getPreKwds();

	for($kk=count($preKwds)-1;$kk>=0;$kk--){
		//echo "hilightTxt_s:".$hilightTxt_s."   preKwds:".$preKwds[$kk]."<br>";

		if($hilightTxt_s == "") {
			$hilightTxt_s = $preKwds[$kk];
		}else {
			$hilightTxt_s = $hilightTxt_s.",".$preKwds[$kk];
		}		
	}

	if(eregi($srchParam->getKwd(), $hilightTxt_s) == 0) {
		if($hilightTxt_s == "") {
			$hilightTxt_s = $srchParam->getKwd();	
		}else{
			$hilightTxt_s = $hilightTxt_s.",".$srchParam->getKwd();
		}
	}

	// 첫 키워드와 결과내 재검색 키워드 분리
	$firstKwd = strstr($hilightTxt_s, ',',true);
	$endKwd = strstr($hilightTxt_s, ',',false);
	$endKwd = substr($endKwd,1);
	
}else{
	$hilightTxt_s = $srchParam->getKwd();	
}

// You can submit both var of template or array  
$TPL->setValue(array(
	"categoryInfo"=>$srchParam->getCategory(),
	"keyword"=>$srchParam->getKwd(),
	"arrCorrectedKwd"=>$arrCorrectedKwd,
	"recommendKwdList"=>$recommendKwdList,
	"TOTAL_ALL"=>$TOTAL_ALL,
	"pageNum"=>$srchParam->getPageNum(),
	"pageSize"=>$srchParam->getPageSize(),
	"sort"=>$srchParam->getSort(),
	"reSrchFlag"=>$srchParam->getReSrchFlag(),
	"reSrchChkValue"=>$reSrchChkValue,
	"preKwdValues"=>$preKwdValues,
	"ftype"=>$ftype,
	"noticeReview"=>$noticeReview,
	"hilightTxt_s"=>$hilightTxt_s,
	"firstKwd"=>$firstKwd,
	"endKwd"=>$endKwd,
));

?>
