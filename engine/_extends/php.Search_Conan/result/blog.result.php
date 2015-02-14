<?php

if($rsbBlog->getTotal() > 0){
		
	for($i=0;$i<$rsbBlog->getRows();$i++){
        
		$fData = $rsbBlog->getFData();

		/*** 블로그 시나리오 정보
        	field    =   blog_name  (,"<b>", "</b>")
        	field    =   blog_url
        	field    =   nickname   (,"<b>", "</b>")
		*****************************/
        	
		$blogList[$i]['blog_nm'] = $fData[$i][0];
        	$blogList[$i]['blog_url'] = $fData[$i][1];
        	$blogList[$i]['nickname'] = $fData[$i][2];
	
	}//for

}//if

// 페이지 범위
$blogPageSize = $srchParam->getBlogPageSize();
$blogFirstPage = (($pageNum-1) * $blogPageSize) +1;
$blogLastPage = $pageNum * $blogPageSize;

if($blogLastPage > $rsbBlog->getTotal()){
        $blogLastPage = $rsbBlog->getTotal();
}

$TPL->setValue(array(
	"blogList"=>$blogList,
	"blogResultCnt"=>$rsbBlog->getTotal(),
	"blogResultFormatCnt"=>formatMoney($rsbBlog->getTotal()),
	"blogFirstPage"=>$blogFirstPage,
	"blogLastPage"=>$blogLastPage,
	"blogPageSize"=>$srchParam->getBlogPageSize(),
));
?>




