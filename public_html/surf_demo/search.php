<?
///////////////////////////////////////////////////
// 프로그램명 : search.php                      
// 설명             : 통합검색 페이지     
// 작성일           : 2012.05.16          
///////////////////////////////////////////////////
?>

<?php
	$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . "/search_demo"; 
	/**************$DOCUMENT_ROOT**************/
	//echo "root : " . $DOCUMENT_ROOT;
	/******************************************/
	
	require_once("$DOCUMENT_ROOT/lib/util/DCConfig.php");
	require_once("$DOCUMENT_ROOT/lib/DOCRUZER.php");

	/**** ip:port를 설정파일에서 불러오기 위한 코드 ****/ 
    	$xml = new DCConfig; 
    	$serverInfo = $xml->xmlOpen('./conf/search_config.xml','searchInfo'); 
    	/**********************************************/
    
	/********** 설정파일로부터 값 읽어오기 ***********/
	//echo $serverInfo['ip'][0]['value'].'<br>';
	//echo $serverInfo['port'][0]['value'].'<br>';
	//echo $serverInfo['pageSize'][0]['value'].'<br>';
	/**********************************************/
    
    	require("$DOCUMENT_ROOT/lib/data/ParameterVO.php");
	require("$DOCUMENT_ROOT/lib/data/ResultVO.php");
	 
	require("$DOCUMENT_ROOT/lib/util/CommonUtil.php");
	require("$DOCUMENT_ROOT/lib/util/DCUtil.php");
    	require("$DOCUMENT_ROOT/lib/module/SearchModule.php");
	
	//ResultVO 
	$rsbCATEGORY1 = new ResultVO();
	$rsbCATEGORY2 = new ResultVO();
	$rsbCATEGORY3 = new ResultVO();
	$rsbCATEGORY4 = new ResultVO();
	$rsbCATEGORY5 = new ResultVO();
	$rsbCATEGORY6 = new ResultVO();
	
	//ParameterVO 선언
	$srchParam = new ParameterVO;

	/**************************************************/
	include("$DOCUMENT_ROOT/common/setParameter.php");
	/**************************************************/
	if ($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "CATEGORY1") {
		include("$DOCUMENT_ROOT/common/query/CATEGORY1.php");
	}
	if ($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "CATEGORY2") { 
		include("$DOCUMENT_ROOT/common/query/CATEGORY2.php");
	}
	if ($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "CATEGORY3") {
		include("$DOCUMENT_ROOT/common/query/CATEGORY3.php");
	}
	if ($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "CATEGORY4") {		
		include("$DOCUMENT_ROOT/common/query/CATEGORY4.php");
	}
	if ($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "CATEGORY5") {
		include("$DOCUMENT_ROOT/common/query/CATEGORY5.php");
	}
	if ($srchParam->getCategory() == "TOTAL" or $srchParam->getCategory() == "CATEGORY6") {
		include("$DOCUMENT_ROOT/common/query/CATEGORY6.php");
	}
	$TOTAL_ALL = $rsbCATEGORY1->getTotal() + $rsbCATEGORY2->getTotal() + $rsbCATEGORY3->getTotal() 
				+ $rsbCATEGORY4->getTotal() + $rsbCATEGORY5->getTotal() + $rsbCATEGORY6->getTotal();
	/**************************************************/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <title>KonanTechnology ::: PHP SAMPLE</title>
	<link href="css/global.css" rel="stylesheet" type="text/css" />
    <script language="javascript" src="./js/search.js"></script>
	<script language="javascript" src="./js/pagenav.js"></script>
	<script language="javascript" src="./js/calendar.js"></script> 
	<!--<script language="javascript" src="./js/akc.js"></script> -->
</head>
<body>
<?// [코난] History Form : 시작 --?>
<? include("$DOCUMENT_ROOT/common/historyForm.php"); ?>

<div id="fix_wrap">
	<div id="fix_conts">
		<div id="header">
		  	<ul id="textgnb">
			    <li><a href="#"> 로그아웃</a><span>|</span></li>
			    <li><a href="#">홈</a><span>|</span></li>
			    <li><a href="#">사이트맵</a><span>|</span></li>
			    <li><a href="#">도움말</a></li>
		  	</ul>
			<?// [코난] GNB Search Form ?>
			<? include("$DOCUMENT_ROOT/common/searchForm.php"); ?>
			
		  	<?// [코난] Category 선택 ?>
		  	<? include("$DOCUMENT_ROOT/common/categoryNavigator.php"); ?>
		  			  	
		  	<?// [코난] Detail Search Form ?>
		  	<? include("$DOCUMENT_ROOT/common/detailSearchForm.php"); ?>
		</div>
		<?// header ?>
		
		<div id="container">
			<div id="content">
				<div class="content_inner"> 
					<div class="content_inner_line"></div>
					<?// [코난] 검색결과 : 시작 ?>
					<? 
						if ($TOTAL_ALL > 0 ) {
							// 카테고리 : xxx 
							if ($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="CATEGORY1") {
								include("$DOCUMENT_ROOT/result/CATEGORY1.php");
							}
							
							// 카테고리 : xxx 
			            	if ($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="CATEGORY2") {
								include("$DOCUMENT_ROOT/result/CATEGORY2.php");
			            	}
							
			            	// 카테고리 : xxx 
			            	if ($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="CATEGORY3") {
								include("$DOCUMENT_ROOT/result/CATEGORY3.php");
			            	}
							
			            	// 카테고리 : xxx
			            	if ($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="CATEGORY4") {
								include("$DOCUMENT_ROOT/result/CATEGORY4.php");
			            	}
							
			            	// 카테고리 : xxx
			            	if ($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="CATEGORY5") {
								include("$DOCUMENT_ROOT/result/CATEGORY5.php");
			            	}
			            	
							// 카테고리 : xxx
			            	if ($srchParam->getCategory()=="TOTAL" or $srchParam->getCategory()=="CATEGORY6") {
								include("$DOCUMENT_ROOT/result/CATEGORY6.php");
			            	}
							
						} else {
							include("$DOCUMENT_ROOT/result/noResult.php");
						}
					?>
					<?// [코난] 검색결과 : 끝 ?>
				</div>
		    </div>
		    <?// //content ?>
		    
		    <div id="aside">
		    	<?// 인기검색어시작 ?>
				<? include("$DOCUMENT_ROOT/common/module/ppk.php"); ?>
		        
		        <?// 추천검색어시작 ?>
				<? include("$DOCUMENT_ROOT/common/module/kre.php"); ?>	
		    </div>
		    <?// aside ?>
		</div>
		<?// container ?>
	</div>
	<?// fix_conts ?>
</div>
<?// fix_wrap ?>
</body>
</html>

