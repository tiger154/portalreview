<?php
/*
실서버 크롤링 속도 테스트
*/
//phpinfo();
exit;

//ini_set("memory_limit","512M");
require_once "/www/revu39/engine/_sys/sys.conf.php";
require_once "/www/revu39/public_html/facebook/simple_html_dom.php";
require_once "/www/revu39/public_html/facebook/class.crawll.php";
require_once "/www/revu39/engine/model/class.base.php";

//1307288 
//134217728 
//dev : 79780740
$CLASS_CRAWLL= new Crawll();
$BASE = new Base();

$url = "http://www.hyundaihmall.com/front/plPlanSaleL.do;NEW_JSESSIONID=1648QYhMVR7zq1G249WCFGLLN273FmgccygJfdPQTxGLnrbM9Qg1!-214034143?SectID=181589&PlanSaleSectID=231465";
//$url = "http://www.naver.com";
$urlArr = $BASE->extractURL($url); // Root URL extract 


$start_microtime = microtime(true);
//echo "Before Call Memory Usage: ".memory_get_usage()."\n";
$html = file_get_html_curl($url); //CURL 파싱


// echo "After Call Memory Usage: ".memory_get_usage()."\n";

 if(!empty($html)){

		if ($html->find('img')) {
			foreach ( $html->find ('img') as $element ) {
//				sleep(1);
//				ob_flush(); //add
//				flush(); //add
				// 상대경로 이미지 체크
				if ($CLASS_CRAWLL->startsWith($element->src, "/")) {					
					$element->src = $urlArr[1] . $element->src;
				}
				// http 프로토콜이아닌 것들 
				if (! $CLASS_CRAWLL->startsWith($element->src, "http")) {	
					$element->src = $urlArr[1] . "/" . $element->src;	
				}

				$nodes [] = $element->src;

			}
		}else{
			echo "There aren't images";
		}	
		//**@ Management memory 
			$html->clear();
			unset($html);
		//**@ EXTRACT OF UNIQUE
					$nodes=array_unique($nodes);
					$nodes = implode("|",$nodes);
					$nodes = explode("|",$nodes);
// echo "After Call Memory Usage: ".memory_get_usage()."\n";					
//exit;
					 $parsedImgArr = $CLASS_CRAWLL->imageDownload( $nodes, 90, 90 );
					 print_r($parsedImgArr);
 }else{
	echo "Page size is overed or unknown error occured!!" ;
 }
 echo "<h1>", microtime(true) - $start_microtime, "</h1>";
//curl -i -H Accept:application/json				 "http://localhost:8080/kadjoukor/geolocations?findByPostcodeFirstChars%26postcodeFirstChars=7500"
//curl -i -X GET -H Accept:application/json "http://localhost:8080/kadjoukor/geolocations?findByPostcodeFirstChars&postcodeFirstChars=7500"
?>