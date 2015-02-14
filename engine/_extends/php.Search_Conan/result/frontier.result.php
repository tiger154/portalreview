<?php

if($rsbFrontier->getTotal() > 0){
		
	for($i=0;$i<$rsbFrontier->getRows();$i++){
        
		$fData = $rsbFrontier->getFData();

		/*** 프론티어 시나리오 정보
		field[0]    =   thumbimg_url
    		field[1]    =   subject                (200, "<b>", "</b>")
    		field[2]    =   ing_state
    		field[3]    =   frontier_url
    		field[4]    =   start_date
    		field[5]    =   end_date
    		field[6]    =   notice_date
    		field[7]    =   due_sdate
    		field[8]    =   due_edate
    		field[9]    =   category
    		field[10]    =   frproduct
    		field[11]    =   tel
    		field[12]    =   peoplelimit
    		field[13]    =   category1 
		*****************************/

        	$frontierList[$i]['img_url'] 	= $fData[$i][0];
        	$frontierList[$i]['subject'] 	= $fData[$i][1];
        	$frontierList[$i]['ing_cd'] 	= $fData[$i][2];
        	$frontierList[$i]['frontier_url'] = $fData[$i][3];
        	
		// start_date
		$s_date_yy = substr($fData[$i][4],0,4);
		$s_date_mm = substr($fData[$i][4],4,2);
		$s_date_dd = substr($fData[$i][4],6,2);
		
		$start_date = $s_date_yy."년".$s_date_mm."월".$s_date_dd."일";	
		
		$frontierList[$i]['start_date'] = $start_date;
        	
		// end_date
		$e_date_yy = substr($fData[$i][5],0,4);
                $e_date_mm = substr($fData[$i][5],4,2);
                $e_date_dd = substr($fData[$i][5],6,2);

		$end_date = $e_date_yy."년".$e_date_mm."월".$e_date_dd."일";

                $frontierList[$i]['end_date'] = $end_date;

		// notice_date
		$n_date_yy = substr($fData[$i][6],0,4);
                $n_date_mm = substr($fData[$i][6],4,2);
                $n_date_dd = substr($fData[$i][6],6,2);

                $notice_date = $n_date_yy."년".$n_date_mm."월".$n_date_dd."일";

                $frontierList[$i]['notice_date'] = $notice_date;

        	// due_sdate
		$d_sdate_yy = substr($fData[$i][7],0,4);
                $d_sdate_mm = substr($fData[$i][7],4,2);
                $d_sdate_dd = substr($fData[$i][7],6,2);

		if($d_sdate_yy != "0000"){
                	$due_sdate = $d_sdate_yy."년".$d_sdate_mm."월".$d_sdate_dd."일";
		}else{
			$due_sdate = '';
		}
                
		$frontierList[$i]['due_sdate'] = $due_sdate;

		// due_edate
		$d_edate_yy = substr($fData[$i][8],0,4);
                $d_edate_mm = substr($fData[$i][8],4,2);
                $d_edate_dd = substr($fData[$i][8],6,2);

                $due_edate = $d_edate_yy."년".$d_edate_mm."월".$d_edate_dd."일";

                $frontierList[$i]['due_edate'] = $due_edate;
        	
		$frontierList[$i]['category'] 	= $fData[$i][9];
        	$frontierList[$i]['frproduct'] 	= $fData[$i][10];
        	$frontierList[$i]['tel'] 	= $fData[$i][11];
        	$frontierList[$i]['limit'] 	= $fData[$i][12];
        	$frontierList[$i]['limit'] 	= $fData[$i][12];
        	$frontierList[$i]['category1'] 	= $fData[$i][13];
	
	}//for

}//if

// 페이지 범위
$frontierPageSize = $srchParam->getFrontierPageSize();
$frontierFirstPage = (($pageNum-1) * $frontierPageSize) +1;
$frontierLastPage = $pageNum * $frontierPageSize;
if($frontierLastPage > $rsbFrontier->getTotal()){
        $frontierLastPage = $rsbFrontier->getTotal();
}

$TPL->setValue(array(
	"frontierList"=>$frontierList,
	"frontierResultCnt"=>$rsbFrontier->getTotal(),
	"frontierResultFormatCnt"=>formatMoney($rsbFrontier->getTotal()),
	"frontierFirstPage"=>$frontierFirstPage,
	"frontierLastPage"=>$frontierLastPage,
	"frontierPageSize"=>$frontierPageSize,
));
?>




