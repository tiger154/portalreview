<?php

if($rsbReview->getTotal() > 0){
		
	for($i=0;$i<$rsbReview->getRows();$i++){
        
		$fData = $rsbReview->getFData();
		
		/*** 리뷰 시나리오 정보 
		field[0]    =   thumbimg_url
    		field[1]    =   title          (, "<b>", "</b>")
    		field[2]    =   contents       (400, "<b>", "</b>")
    		field[3]    =   category
    		field[4]    =   type
    		field[5]    =   blog_type
    		field[6]    =   regdate
    		field[7]    =   blog_url 
    		field[8]    =   bloggerno 
    		field[9]    =   nickname 
    		field[10]   =   review_url
		*****************************/

        	$reTitle = str_replace('"','\"',$fData[$i][1]);			

			$thum = "";
			if($fData[$i][0] == '' || $fData[$i][0] == 'http://file.revu.co.kr/frontier/thum_empty.gif') {
				$thum = "";
			}else{
				$thum = $fData[$i][0];
			}

        	$reviewList[$i]['thumbimg_url'] = $thum;
        	$reviewList[$i]['title'] = $fData[$i][1];
			$reviewList[$i]['showtitle'] = $fData[$i][1];
        	$reviewList[$i]['contents'] = $fData[$i][2];

		// 카테고리 3단계까지
		$category_org = $fData[$i][3];
      		
		$categoryInfo = explode(">",$category_org);
		$review_category = $categoryInfo[0];
		if($categoryInfo[1] != null){
			$review_category = $review_category." > ".$categoryInfo[1];	
		} 
		if($categoryInfo[2] != null){
			$review_category = $review_category." > ".$categoryInfo[2];	
		} 

		/* 블로그 타입 이미지 경로 
        	daum - http://www.revu.co.kr/images/common/ico/ico_daum.gif
        	naver - http://www.revu.co.kr/images/common/ico/ico_naver.gif
        	tistory - http://www.revu.co.kr/images/common/ico/ico_tistory.gif
        	etc - http://www.revu.co.kr/images/common/ico/ico_etc.gif                       */ 

		$img_base_url = "http://www.revu.co.kr/images/common/ico/"; 
		$img_nm = "ico_".strtolower($fData[$i][5]).".gif"; 
		
		$blog_img_url = $img_base_url.$img_nm;

		// 날짜 
		$yy = substr($fData[$i][6],0,4);
		$mm = substr($fData[$i][6],4,2);
		$dd = substr($fData[$i][6],6,2);

		// 친구관계 체크
                if($_SESSION['userno'] != null)
                {
                        $cur_userno = $_SESSION['userno'];

                        $ftype = $CLASS_SEARCH->SearchFrendType($DB, $cur_userno, $fData[$i][8]);
                }

        	$reviewList[$i]['category'] = $review_category;
		$reviewList[$i]['blog_img_url'] = $blog_img_url;
		$reviewList[$i]['blog_type'] = strtoupper($fData[$i][5]);
		$reviewList[$i]['regdate'] = $yy.".".$mm.".".$dd;
        	$reviewList[$i]['blog_url'] = $fData[$i][7];
        	$reviewList[$i]['bloggerno'] = $fData[$i][8];
        	$reviewList[$i]['nickname'] = $fData[$i][9];
        	$reviewList[$i]['review_url'] = $fData[$i][10];
        	$reviewList[$i]['ftype'] = $ftype;

	}//for

}//if

// 페이지 범위
$reviewPageSize = $srchParam->getReviewPageSize();
$reviewFirstPage = (($pageNum-1) * $reviewPageSize) +1;
$reviewLastPage = $pageNum * $reviewPageSize;

if($reviewLastPage > $rsbReview->getTotal()){
	$reviewLastPage = $rsbReview->getTotal();
}

$TPL->setValue(array(
	"reviewList"=>$reviewList,
	"reviewResultCnt"=>$rsbReview->getTotal(),
	"reviewResultFormatCnt"=>formatMoney($rsbReview->getTotal()),
	"reviewFirstPage"=>$reviewFirstPage,
	"reviewLastPage"=>$reviewLastPage,
	"reviewPageSize"=>$reviewPageSize,
));

?>




