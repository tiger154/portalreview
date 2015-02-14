<?php
if($srchParam->getKwd() != "") {
	

	// DOCRUZER API를 호출할 경우 키워드를 euc-kr로 변환해서 보내야함
	$kwd = iconv('utf-8','euc-kr',$srchParam->getKwd());

	$arrKre = getRecommendKwd($kwd,0,10);

	for ($k=0; $k<sizeof($arrKre); $k++) {
		// 화면에 표시할 때 euc-kr 상태의 결과값을 utf-8로 재변환함
			$recommendKwdList[$k][kre] = iconv('euc-kr','utf-8',$arrKre[$k]);
	}

	// 템플릿으로 변수, 배열값 등을 넘길 수 있음
	$TPL->setValue(array(
			"recommendKwdList"=>$recommendKwdist,
	));
}

?>
