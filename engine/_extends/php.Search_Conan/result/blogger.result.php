<?php

if($rsbBlogger->getTotal() > 0){
	
	for($i=0;$i<$rsbBlogger->getRows();$i++){
        
		$fData = $rsbBlogger->getFData();

		/*** 블로거 시나리오 정보
        	field[0]    =  userno	 
        	field[1]    =  userimg 
        	field[2]    =  nickname 
		*****************************/
       
		// 친구관계 체크 
		if($_SESSION['userno'] != null)	
		{
			$cur_userno = $_SESSION['userno']; 
			
			$ftype = $CLASS_SEARCH->SearchFrendType($DB, $cur_userno, $fData[$i][0]);
		}

		$dir = ceil($fData[$i][0]/10000);
			
		if($fData[$i][1] != null){
			$bloggerimg = "http://"._DOMAIN_FILE."/"._FTP_USERIMAGE."/".$dir."/".$fData[$i][1];
		}else{
			$bloggerimg = "http://"._DOMAIN._DIR_IMAGES_."/common/noimage.gif";
		}

		if($ftype == '0'){
			$ftext = "서로 친구";
			$fclass = "blg01";
		}else if($ftype == '1'){
			$ftext = "내가 등록한 친구";
			$fclass = "blg02";
		}else if($ftype == '2'){
			$ftext = "나를 등록한 친구";
			$fclass = "blg03";
		}else{
			$ftext = null; 
			$fclass = null;
		} 
		
		$bloggerList[$i]['bloggerno'] = $fData[$i][0];
		$bloggerList[$i]['bloggerimg'] = $bloggerimg;
        	$bloggerList[$i]['nickname'] = $fData[$i][2];
        	$bloggerList[$i]['ftext'] = $ftext;
        	$bloggerList[$i]['fclass'] = $fclass;
	
	}//for

}//if

// 페이지 범위
$bloggerPageSize = $srchParam->getBloggerPageSize();
$bloggerFirstPage = (($pageNum-1) * $bloggerPageSize) +1;
$bloggerLastPage = $pageNum * $bloggerPageSize;

if($bloggerLastPage > $rsbBlogger->getTotal()){
        $bloggerLastPage = $rsbBlogger->getTotal();
}

$TPL->setValue(array(
	"bloggerList"=>$bloggerList,
	"bloggerResultCnt"=>$rsbBlogger->getTotal(),
	"bloggerResultFormatCnt"=>formatMoney($rsbBlogger->getTotal()),
	"bloggerFirstPage"=>$bloggerFirstPage,
	"bloggerLastPage"=>$bloggerLastPage,
	"bloggerPageSize"=>$bloggerPageSize,
));
?>




