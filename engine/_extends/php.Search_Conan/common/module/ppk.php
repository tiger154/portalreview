<?php

$arrPpk = getPopularKwdAndTag(0,10);
for($k=0;$k<sizeof($arrPpk);$k++){
        $popularKwdList[$k][no] = $k+1;

        if($k+1 < 6){
                $dp = "rnp";
        }else{
                $dp = "rng";
        }

        $tagNum = $arrPpk[$k][1];
        $tagInfo = "";

        if(substr($tagNum,0,1) == "-"){
                $tagInfo = "down state";
                $tagNum = str_replace("-","",$tagNum);
        }else{
                if($tagNum == "0"){
                        $tagInfo = "eq state";
                }else if($tagNum == "new"){
                        $tagInfo = "new state";
                }else{
                        $tagInfo = "up state";
                }
        }

        $popularKwdList[$k][dp] = $dp;
        $popularKwdList[$k][ppk] = iconv('euc-kr','utf-8',$arrPpk[$k][0]);
        $popularKwdList[$k][tagNum] = $tagNum;
        $popularKwdList[$k][tagInfo] = $tagInfo;

}

/************** 현재날짜/시간 **************/
$now_time = date("Y.m.d H:i",time());
/*******************************************/

// 템플릿으로 변수, 배열값 등을 넘길 수 있음
$TPL->setValue(array(
        "popularKwdList"=>$popularKwdList,
        "now_time"=>$now_time,
));

?>
