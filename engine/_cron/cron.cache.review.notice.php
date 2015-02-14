<?php
/***************************************************************************************
 * 주목받는 리뷰리스트
 * 
 * 작성일 : 2011.10.17
 * 작성자 : 이종학
 * 히스토리 :  
 * 
 ***************************************************************************************/ 
/**
 * 시스템 파일 
 */
require_once "/www/revu39/engine/_sys/sys.conf.cron.php";
require_once _DIR_ENGINE."/_sys/sys.module.php";

/**
 * PHP 에러리포트 설정
 * 
 * sys.conf.php 참조
 */
error_reporting(_ERROR_REPORTING);

/**
 * 사이트설정정보
 */
$SITE = Module::loadConf(_INI_SITE);

/**
 * CLASS
 */
$CLASS_BASE = &Module::singleton("Base");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_USER = &Module::singleton("User.User");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
$list = array();
$cate = array("", "11005", "13", "12016", "11010", "12017", "10", "14008");
$day = 1; 
$num = 10;
$limit = "LIMIT 0, ".$num;
$date[0] = date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"), date("m"), date("d")-$day, date("Y")));
$date[1] = date("Y-m-d H:i:s");
$res = array();

for($i=0; $i<sizeof($cate); $i++) {
	$cateArr = $CLASS_CODE->transCate($cate[$i]);	
	//$list[$i] = $CLASS_REVIEW->getReviewList($DB, $limit, $type="", $cateArr, $status="1", $date, $order="point", $desc="DESC");
	$list[$i] = $CLASS_REVIEW->getReviewListByImage($DB, $limit, $cateArr, $date);
	$size = sizeof($list[$i]);
	if($size > 0) {
		$list[$i] = $CLASS_REVIEW->getReviewDataBind($DB, $list[$i]);
		for($j=0; $j<sizeof($list[$i]); $j++) {
			$arr = array();
			$arr[] = $j;
			$arr[] = $list[$i][$j]['rno'];
			$arr[] = $list[$i][$j]['userno'];
			$arr[] = $list[$i][$j]['nickname'];
			$arr[] = $list[$i][$j]['recom_cnt'];
			$arr[] = $list[$i][$j]['talk_cnt'];
			$arr[] = $list[$i][$j]['view_cnt'];
			$arr[] = $list[$i][$j]['point'];
			$arr[] = $cate[$i];
			$arr[] = $list[$i][$j]['title'];
			$arr[] = $list[$i][$j]['content'];
			//$arr[] = $list[$i][$j]['thumbimage_url'];
			$arr[] = $list[$i][$j]['thumbimage110_url'];
			$res[] = $DB->call("p_cache_review_notice_ins", $arr);
			$DB->rConnect();
		}
	}
}

$flist = $CLASS_REVIEW->getReviewList($DB, $limit, $type="F", $cate=array(), $status="1", $date, $order="point", $desc="DESC");
$flist = $CLASS_REVIEW->getReviewDataBind($DB, $flist);
for($k=0; $j<sizeof($flist[$k]); $k++) {
	$arr = array();
	$arr[] = $k;
	$arr[] = $flist[$k]['rno'];
	$arr[] = $flist[$k]['userno'];
	$arr[] = $flist[$k]['nickname'];
	$arr[] = $flist[$k]['recom_cnt'];
	$arr[] = $flist[$k]['talk_cnt'];
	$arr[] = $flist[$k]['view_cnt'];
	$arr[] = $flist[$k]['point'];
	$arr[] = "frontier";
	$arr[] = $flist[$k]['title'];
	$arr[] = $flist[$k]['content'];
	$arr[] = $flist[$k]['thumbimage_url'];
	$res[] = $DB->call("p_cache_review_notice_ins", $arr);
	$DB->rConnect();
}

/**
 * CRON LOG
 */
if(Module::result($res, "err", "-1") == false) {
	$msg = "캐시-주목받는리뷰 입력 실패";	
} else {
	$msg = "캐시-주목받는리뷰 입력 성공";
}		
$CLASS_BASE->insertCronLog($DB_LOG, "캐시-주목받는리뷰", __FILE__, $msg);

/**
 * 종료
 */
Module::exitModule();
?>