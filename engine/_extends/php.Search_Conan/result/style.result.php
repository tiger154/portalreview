<?php

if($rsbStyle->getTotal() > 0){
		
	for($i=0;$i<$rsbStyle->getRows();$i++){
        
		$fData = $rsbStyle->getFData();

		/*** 스타일 시나리오 정보
        	field    =   
        	field    =  
        	field    =   
		*****************************/
        	
		$styleList[$i][''] = $fData[$i][0];
        	$styleList[$i][''] = $fData[$i][1];
        	$styleList[$i][''] = $fData[$i][2];
	
	}//for

}//if

// 페이지 범위
$styleFirstPage = (($pageNum-1) * $pageSize) +1;
$styleLastPage = $pageNum * $pageSize;

if($styleLastPage > $rsbStyle->getTotal()){
        $styleLastPage = $rsbStyle->getTotal();
}

$TPL->setValue(array(
	"styleList"=>$styleList,
	"styleResultCnt"=>$rsbStyle->getTotal(),
	"styleResultFormatCnt"=>formatMoney($rsbStyle->getTotal()),
	"styleFirstPage"=>$styleFirstPage,
	"styleLastPage"=>$styleLastPage,
));
?>




