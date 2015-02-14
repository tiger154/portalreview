<?php
/***************************************************************************************
 * 공용처리 컨트롤러
 * 
 * 작성일 : 2011.07.04
 * 작성자 : 이종학
 * 히스토리 :
 ***************************************************************************************/ 

/**
 * GLOBAL CLASS / VAR
 */
GLOBAL $TPL;
GLOBAL $BASE;
// var
GLOBAL $SITE;
GLOBAL $FRAME;
 
/**
 * CLASS
 */
$CLASS_COOKIE = &Module::singleton("Cookie");
$CLASS_ZIPCODE = &Module::singleton("Zipcode");
$CLASS_FILE = &Module::singleton("File");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CASH = &Module::singleton("User.Cash");
$CLASS_FRIEND = &Module::singleton("User.Friend");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWBEST = &Module::singleton("Review.ReviewBest");
$CLASS_REVIEWTALK = &Module::singleton("Review.ReviewTalk");
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$jsonArr = array();

/**
 * TODO
 */
switch(Module::$todo)
{
	case "download" :
		$FRAME = "popup";
		$CLASS_FILE->download($_POST['filename1'], $_POST['$filename2'], $_POST['$dir']);
		break;
	
	/**
	 * 파일다운로드-테스트
	 */
	case "download.test" :
		$filename1 = "http://"._DOMAIN_FILE."/frontier/rel_file/2011/73.pdf";
		$filename2 = "http://"._DOMAIN_FILE."/frontier/rel_file/2011/73.pdf";
		//$dir = "";
		$CLASS_FILE->download($filename1, $filename2, $dir);
		break;
	
	/**
	 * 1~4차 지역정보 리스트
	 */	
	case "search.area.set" :		
		$FRAME = "ajax";
		// 지역정보가 없을경우	
		if($_POST['area'] == "") {
			$jsonArr['aaaa'] = "faiaaal";
			$jsonArr['result'] = "success";
			$jsonArr['area'] = array();
			$jsonArr['bcode'] = $_POST['bcode'];
			$jsonArr['mcode'] = $_POST['mcode'];
			$jsonArr['scode'] = $_POST['scode'];
			$jsonArr['bcode_list'] = $CLASS_CODE->getBcodeList($DB);
		} else {
			$area = $CLASS_CODE->transArea($_POST['area']);
			if($CLASS_CODE->isArea($DB, $area) == true) {
				$jsonArr['result'] = "success";
				$jsonArr['area'] = $area;
				$jsonArr['bcode'] = $_POST['bcode'];
				$jsonArr['mcode'] = $_POST['mcode'];
				$jsonArr['scode'] = $_POST['scode'];
				$jsonArr['bcode_list'] = $CLASS_CODE->getBcodeList($DB);
				if($area[0] != "") $jsonArr['mcode_list'] = $CLASS_CODE->getMcodeList($DB, $area[0]);
				if($area[1] != "") $jsonArr['scode_list'] = $CLASS_CODE->getScodeList($DB, $area[0], $area[1]);			
			} else {
				$jsonArr['result'] = "fail";
			}	
		}
		break;
		
	/**
	 * 구군코드 리스트
	 */	
	case "search.mcode" :
		$FRAME = "ajax";		
		$mcode_list = $CLASS_ZIPCODE->getMcodeList($DB, $_POST['bcode']);
		if(is_array($mcode_list) && sizeof($mcode_list) > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['mid'] = $_POST['mid'];
			$jsonArr['sid'] = $_POST['sid'];
			$jsonArr['mcode_list'] = $mcode_list;			
		} else {
			$jsonArr['result'] = "fail";
			$jsonArr['mid'] = $_POST['mid'];
			$jsonArr['sid'] = $_POST['sid'];
		}
		break;
	
	/**
	 * 읍면동코드 리스트
	 */	
	case "search.scode" :
		$FRAME = "ajax";
		$scode_list = $CLASS_ZIPCODE->getScodeList($DB, $_POST['bcode'], $_POST['mcode']);
		if(is_array($scode_list) && sizeof($scode_list) > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['sid'] = $_POST['sid'];
			$jsonArr['scode_list'] = $scode_list;
		} else {
			$jsonArr['result'] = "fail";
			$jsonArr['sid'] = $_POST['sid'];
		}
		break;
	
	/**
	 * 주소검색
	 */	
	case "search.zipcode" :
		$FRAME = "ajax";
		$list = $CLASS_ZIPCODE->getZipcode($DB, $_POST['type'], $_POST['keyword']);
		if(is_array($list) && sizeof($list) > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['list'] = $list;
			$jsonArr['length'] = sizeof($list);
			$jsonArr['zipcode'] = $_POST['zipcode'];
			$jsonArr['addr1'] = $_POST['addr1'];
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 1~4차 분류 리스트
	 */	
	case "search.cate.set" :
		$FRAME = "ajax";
		$cate = $CLASS_CODE->transCate($_POST['cate']);
		if($CLASS_CODE->isCate($DB, $cate) == true || sizeof($cate) == 0) {
			$jsonArr['result'] = "success";
			$jsonArr['cate'] = $cate;
			$jsonArr['cate1'] = $_POST['cate1'];
			$jsonArr['cate2'] = $_POST['cate2'];
			$jsonArr['cate3'] = $_POST['cate3'];
			$jsonArr['cate4'] = $_POST['cate4'];
			$jsonArr['cate1_list'] = $CLASS_CODE->getCate1List($DB);
			if($cate[0] != "") $jsonArr['cate2_list'] = $CLASS_CODE->getCate2List($DB, $cate[0]);
			if($cate[1] != "") $jsonArr['cate3_list'] = $CLASS_CODE->getCate3List($DB, $cate[0], $cate[1]);
			if($cate[2] != "") $jsonArr['cate4_list'] = $CLASS_CODE->getCate4List($DB, $cate[0], $cate[1], $cate[2]);			
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 2차 분류 리스트
	 */	
	case "search.cate2" :
		$FRAME = "ajax";
		$cate2_list = $CLASS_CODE->getCate2List($DB, $_POST['cate1']);
		if(is_array($cate2_list) && sizeof($cate2_list) > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['cate2'] = $_POST['cate2'];
			$jsonArr['cate3'] = $_POST['cate3'];
			$jsonArr['cate4'] = $_POST['cate4'];
			$jsonArr['cate2_list'] = $cate2_list;
		} else {
			$jsonArr['result'] = "fail";
			$jsonArr['cate2'] = $_POST['cate2'];
			$jsonArr['cate3'] = $_POST['cate3'];
			$jsonArr['cate4'] = $_POST['cate4'];

		}
		break;

	/**
	 * 3차 분류 리스트
	 */	
	case "search.cate3" :
		$FRAME = "ajax";
		$cate3_list = $CLASS_CODE->getCate3List($DB, $_POST['cate1'], $_POST['cate2']);
		if(is_array($cate3_list) && sizeof($cate3_list) > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['cate3'] = $_POST['cate3'];
			$jsonArr['cate4'] = $_POST['cate4'];
			$jsonArr['cate3_list'] = $cate3_list;
		} else {
			$jsonArr['result'] = "fail";
			$jsonArr['cate3'] = $_POST['cate3'];
			$jsonArr['cate4'] = $_POST['cate4'];

		}
		break;
	
	/**
	 * 4차 분류 리스트
	 */	
	case "search.cate4" :
		$FRAME = "ajax";
		$cate4_list = $CLASS_CODE->getCate4List($DB, $_POST['cate1'], $_POST['cate2'], $_POST['cate3']);
		if(is_array($cate4_list) && sizeof($cate4_list) > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['cate4'] = $_POST['cate4'];
			$jsonArr['cate4_list'] = $cate4_list;
		} else {
			$jsonArr['result'] = "fail";
			$jsonArr['cate4'] = $_POST['cate4'];

		}
		break;	
	
	/*
	 * 회원정보 컨텍스트메뉴
	 */ 
	case "context.user" :
		$FRAME = "ajax";			
		$user = $CLASS_USER->getUser($DB, $_POST['userno']);
		$extra = $CLASS_USER->getUserExtra($DB, $_POST['userno']);
		//$bloglist = $CLASS_BLOG->getBlogList($DB, $_POST['userno']);
		if(is_array($user) && $user['userno'] != "" && is_array($extra) && $extra['userno'] != "") {
			$jsonArr['result'] = "success";			
			$jsonArr['nickname'] = $user['nickname'];
			$jsonArr['userno'] = $user['userno'];
			$jsonArr['userimage'] = $CLASS_USER->getImage($user['userno'], $extra['userimage']);
			if($_SESSION['userno'] != "" && $_SESSION['userno'] != $_POST['userno']) {
				$jsonArr['type'] = $CLASS_FRIEND->getFriendType($DB, $_SESSION['userno'], $_POST['userno']);
				$jsonArr['grouplist'] = $CLASS_FRIEND->getFriendGroupList($DB, $_SESSION['userno']);
				//$jsonArr['login'] = ($_SESSION['userno'] == "") ? "N" : "Y";
				$jsonArr['flag_friend'] = "1";
			} else {
				$jsonArr['flag_friend'] = "0";
			}			
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 컨텍스트 친구추가
	 */
	case "context.friend.add.proc" :
		$FRAME = "ajax";		
		if($_SESSION['userno'] == $_POST['userno']) {
			$jsonArr['result'] = "self";
			break;
		}		
		if($_SESSION['userno'] == "") {
			$jsonArr['result'] = "login";
			break;
		}		
		$arr = array();
		$arr[] = $_SESSION['userno'];
		$arr[] = $_POST['userno'];
		$arr[] = $_POST['groupno'];		
		$res = array();
		$res[] = $DB->call("p_friend_ins", $arr);		
		if($res[0]['orcode'] == '1') {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 컨텍스트 친구 삭제
	 */
	case "context.friend.delete.proc" :
		$FRAME = "ajax";
		
		if($_SESSION['userno'] == $_POST['userno']) {
			$jsonArr['result'] = "self";
			break;
		}		
		if($_SESSION['userno'] == "") {
			$jsonArr['result'] = "login";
			break;
		}		
		$arr = array();
		$arr[] = $_SESSION['userno'];
		$arr[] = $_POST['userno'];		
		$res = array();
		$res[] = $DB->call("p_friend_del", $arr);		
		if($res[0]['orcode'] == '1') {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 소셜바  전체 로그아웃 처리
	 */
	case "socialbar.logout.proc" :
		$FRAME = "ajax";
		$CLASS_LOGIN = &Module::singleton("Auth.Login");
		$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
		$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");		
		$res = array();		
		$res[] = $CLASS_LOGIN->initSession();
		$res[] = $CLASS_TWITTER->initSession();
		$res[] = $CLASS_FACEBOOK->initSession();
		if(Module::result($res) != false) {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/*
	 * 소셜바-보기
	 */ 
	case "socialbar.view" :
		$FRAME = "ajax";		
		$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);
		if(is_array($review) && $review['rno'] != "") {
			$jsonArr['result'] = "null";
		}
		$user = $CLASS_USER->getUser($DB, $review['userno']);
		$cate = $CLASS_CODE->transCateArray($review['cate1'],$review['cate2'],$review['cate3'],$review['cate4']);
		$list[$i]['cate_desc'] = $CLASS_CODE->getCateDesc($DB, $cate);						
		if(is_array($review) && $review['rno'] != "") {
			$arr = array();
			$arr[] = $review['rno'];
			$arr[] = $_SESSION['userno'];
			$res[] = $DB->call("p_review_view_cnt_upd", $arr);
			$DB->rConnect();
			
			if($_SESSION['userno'] != "") {
				$arr = array();
				$arr[] = $_SESSION['userno'];
				$arr[] = "0";  
				$arr[] = "306";  
				$arr[] = $review['rno']; 
				$res[] = $DB->call("p_point_ins", $arr);
				$DB->rConnect();
			}		
			$wno_now = $CLASS_REVIEWBEST->getBestWeekWno($DB, date("Y-m-d"));
			$wno = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno_now);
			$flag_cand = $CLASS_REVIEWBEST->isBestCandReview($DB, $wno, $_POST['rno']);
			if($flag_cand == true) {
				$cand = $CLASS_REVIEWBEST->getBestCandReview($DB, $wno, $_POST['rno']);
				$review['recom_cnt'] = $cand['recom_cnt'];
			}
			if($review['type'] == "R") {
				$review['url'] = "http://"._DOMAIN."/review/frame/".$review['rno'];
			}
			$jsonArr['result'] = "success";
			$jsonArr['review'] = $review;
			$jsonArr['review']['title'] = $BASE->strLimitUTF(strip_tags($review['title']), 30, false, '...');
			$jsonArr['userno'] = $user['userno'];			
			$jsonArr['nickname'] = $user['nickname'];
			$jsonArr['ico_powerblog'] = ($user['flag_powerblog'] == "1") ? "<img src='"._DIR_IMAGES_."/myrevu/ico_power.gif' />" : "";
			$jsonArr['cate_desc'] = $CLASS_CODE->getCateDesc($DB, $cate);
			$jsonArr['flag_login'] = ($_SESSION['userno'] == "") ? "0" : "1";
			$jsonArr['wno'] = ($flag_cand == false) ? "" : $wno;
			$jsonArr['flag_cand'] = ($flag_cand == false) ? "0" : "1"; 
			$jsonArr['referer'] = $_SERVER['HTTP_REFERER'];
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/*
	 * 소셜바-베스트후보추천
	 */ 
	case "socialbar.cand.recom" :
		$FRAME = "ajax";
		if(empty($_SESSION['userno']) || $_SESSION['userno'] == "") {
			$jsonArr['result'] = "nouser";
			break;
		}
		if($CLASS_REVIEWBEST->isBestCandReview($DB, $_POST['wno'], $_POST['rno']) == false) {
			$jsonArr['result'] = "nocand";
			break;
		}			
		$review = $CLASS_REVIEWBEST->getBestCandReview($DB, $_POST['wno'], $_POST['rno']);
		if($review['userno'] == $_SESSION['userno']) {
			$jsonArr['result'] = "recomme";
			break; 
		}		
		if($CLASS_REVIEWBEST->isBestRecomUser($DB, $_POST['wno'], $_POST['rno'], $_SESSION['userno']) == true) {
			$jsonArr['result'] = "repeat";
			break; 
		}
		if($CLASS_REVIEWBEST->isBestRecomIP($DB, $_POST['wno'], $review['cate1'], $_SERVER['REMOTE_ADDR']) == true) {
			$jsonArr['result'] = "sameip";
			break; 
		} 		
		$arr = array();
		$arr[] = $_POST['wno'];
		$arr[] = $_POST['rno'];
		$arr[] = $_SESSION['userno'];
		$arr[] = $review['cate1'];
		$arr[] = $_SERVER['REMOTE_ADDR'];
		$res = array();
		$res[] = $DB->call("p_review_best_recom_ins", $arr);
		if(Module::result($res, "err", "-1") == true) {
			$jsonArr['result'] = "success";
			$jsonArr['recom_cnt'] = $review['recom_cnt']+1;
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/*
	 * 소셜바-추천
	 */ 
	case "socialbar.recom" :		
		$FRAME = "ajax";		
		if(empty($_POST['rno'])) {
			$jsonArr['result'] = "info";
			break;
		}		
		if(!empty($_SESSION['userno']) && $_SESSION['userno'] != "") {			
			$cash = 0;
			$res = array();
			$cres = array();			
			$policy = Module::loadConf(_DIR_CONF."/site.cash.ini", true);	
			$stats = $CLASS_USER->getUserStats($DB, $_SESSION['userno']);
			$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);
			$user = $CLASS_USER->getUser($DB, $review['userno']);
			$grade = strval($CLASS_USER->getGrade($DB, $review['userno']));			
			if($review['userno'] == $_SESSION['userno']) {
				$jsonArr['result'] = "recomme"; 
				break;
			}
			if($CLASS_REVIEW->isRecomUser($DB, $_SESSION['userno'], $review['userno'], 1, 1) == true) {
				$jsonArr['result'] = "oneuser";				
				break;
			}
			if($CLASS_REVIEW->isRecomIP($DB, $_POST['rno'], $_SERVER['REMOTE_ADDR']) == true) {
				$jsonArr['result'] = "sameip"; 
				break;
			}
			if($CLASS_REVIEW->isRecomDay($DB, $_POST['rno'], $_SESSION['userno']) == true) {
				$jsonArr['result'] = "repeat"; 
				break;
			}				
			$jsonArr['condition'] = array();				
			if($stats['review_cnt'] < 1) {
				$cres[] = false;				
				$jsonArr['condition'][] = "1";
				//$jsonArr['result'] = "1"; break;	
			}	
			if($review['ip'] == $_SERVER['REMOTE_ADDR']) {
				$cres[] = false;				
				$jsonArr['condition'][] = "2";
				//$jsonArr['result'] = "2"; break;
			}		
			if($CLASS_REVIEW->isRecomTime($review['regdate'], 1) == true) {
				$cres[] = false;				
				$jsonArr['condition'][] = "3";
				//$jsonArr['result'] = "3"; break;
			}			
			if(Module::result($cres) == true) {
				$cash += $policy['CASH_GRADE'][$grade];				
				$_cash = 0;
				foreach($policy['CASH_REVIEW_CNT'] as $key => $val) {
					if($stats['review_cnt'] >= $key) {
						$_cash = $val;
					} else {
						break;
					}
				}	
				$cash += $_cash;
				if($user['flag_powerblog'] == "1") {
					$cash += $policy['CASH_POWERBLOGER']['0'];
				}
			}			
			$arr = array();		
			$arr[] = $_POST['rno'];
			$arr[] = $_SESSION['userno'];
			$arr[] = $user['userno'];
			$arr[] = $_SERVER['REMOTE_ADDR'];
			$arr[] = $cash;
			$res[] = $DB->call("p_review_recom_ins", $arr);			
			$cash = 0;
			$cash_val = "";
			$flag = false;
			$code = "";						
			foreach($policy['CASH_RECOM_CNT'] as $key => $val) 
			{
				if($review['recom_cnt']+1 == $key) {
					$_cash = $val;
					$cash_val = $val;
					$flag = true;
				} else {
					break;
				}
			}			
			if($flag == true) {				
				switch($cash_val) 
				{
					case 50 : $code = "330"; break; 
					case 100 : $code = "331"; break;
					case 150 : $code = "332"; break;
					case 200 : $code = "333"; break;
					case 250 : $code = "334"; break;
					//case 300 : $code = "335"; break;
					//case 350 : $code = "336"; break;
					//case 400 : $code = "337"; break;
					//case 450 : $code = "338"; break;
					//case 500 : $code = "339"; break;
				}				
				$cash += $_cash;							
				if($cash > 0) {	
					$arr = array();
					$arr[] = $user['userno'];
					$arr[] = '0';
					$arr[] = $code;
					$arr[] = $cash;
					$arr[] = $_POST['rno'];
					
					$DB->rConnect();
					$res[] = $DB->call("p_cash_ins", $arr);
				}
			}			
			$arr = array();
			$arr[] = $_SESSION['userno'];
			$arr[] = "0"; 
			$arr[] = "304"; 
			$arr[] = $_POST['rno'];
			$DB->rConnect();
			$res[] = $DB->call("p_point_ins", $arr);			

			// Check ActionGraph status which is active or not
			// If its active DO Recommend action
			// or not  review : 'http://www.revu.co.kr/1304795'
			$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
			$action_user = $CLASS_USER->getUser($DB, $_SESSION['userno']);
			
			if($action_user["flag_opengraph"] == "1"){
				try {					
						$CLASS_FACEBOOK->facebook->api("/me/revulove:Recommend?access_token=".$_SESSION[$field['access_token']], "POST", 
						array("access_token"=>$_SESSION[$field['access_token']], "review" =>"http://www.revu.co.kr/".$_POST['rno']));
						$jsonArr['opengraph_result'] = "success";
				} catch (FacebookApiException $e) {
					// Log Exception error
						$jsonArr['opengraph_result'] = "fail";
				}	
			}else{
						$jsonArr['opengraph_result'] = "disabled";
			}		

		} else {
			if($CLASS_REVIEW->isRecomIP($DB, $_POST['rno'], $_SERVER['REMOTE_ADDR']) == true) {
				$jsonArr['result'] = "sameip"; 
				break;
			}
			$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);
			$arr = array();		
			$arr[] = $_POST['rno'];
			$arr[] = 0; //$_SESSION['userno'];
			$arr[] = $review['userno'];
			$arr[] = $_SERVER['REMOTE_ADDR'];
			$arr[] = 0;				
			$DB->rConnect();
			$res[] = $DB->call("p_review_recom_ins", $arr);
		}		
		if(Module::result($res, "err", "-1") == true) {
			$jsonArr['result'] = "success";
			$jsonArr['recom_cnt'] = $review['recom_cnt']+1;
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/*
	 * 소셜바-인기글
	 */ 
	case "socialbar.popular" :		
		$FRAME = "ajax";		
		$cateArr = array("", "10", "11", "12", "13", "14");
		$_length = sizeof($cateArr);
		$_POST['cate'] = ($_POST['cate'] != "") ? $_POST['cate'] : $cateArr[0];	
		$limit = "LIMIT 0, 10";
		// 카테고리가 있을경우 체크
		if(!empty($_POST['cate'])) {	
			$cate = $CLASS_CODE->transCate($_POST['cate']);		
			if($CLASS_CODE->isCate($DB, $cate) == false) {
				$jsonArr['result'] == "null";
			}
			$jsonArr['desc'] = $CLASS_CODE->getCateDesc($DB, $cate);
		} else {
			$jsonArr['desc'] = "전체";
		}
		$list = $CLASS_REVIEW->getReviewList($DB, $limit, $type="", $cate, "1", "point", "desc");
		if(true) {
			for($i=0; $i<sizeof($list); $i++) {
				$_content = $CLASS_REVIEW->getReviewContent($DB, $list[$i]['rno']);
				$list[$i]['num'] = $i+1;
				$list[$i]['title'] = $_content['title'];
			}
			
			foreach($cateArr as $key => $val) {
				if($val == $_POST['cate']) {	
					$num = $key;
					break;
				}
			}
			$jsonArr['prev'] = ($num - 1 < 0) ? $cateArr[$_length-1] : $cateArr[$num-1];
			$jsonArr['next'] = ($num + 1 >= $_length) ? $cateArr[0] : $cateArr[$num+1];
			//$jsonArr['prev'] = $cateArr[$num-1];		
			//$jsonArr['next'] = $cateArr[$num+1];					
			$jsonArr['result'] = "success";
			$jsonArr['list'] = $list;
			$jsonArr['num'] = $num;
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/*
	 * 소셜바-진행중인 프론티어
	 */ 
	case "socialbar.frontier" :		
		$FRAME = "ajax";		
		$list = $CLASS_FRONTIER->frbannerList($DB);
		if(sizeof($list) < 1) {
			$jsonArr['result'] = "null";
		} else {
			for($i=0; $i<sizeof($list); $i++) {
				$list[$i]['titleimg'] = $CLASS_FRONTIER->frbannerimgSelect($DB, $list[$i]['frno']);
				$list[$i]['img'] = $CLASS_FRONTIER->getBannerImage($list[$i]['frid'], $list[$i]['titleimg']);
			}
		}
		if(is_array($list) && $list[0]['frno'] != "") {					
			$jsonArr['result'] = "success";
			$jsonArr['list'] = $list;			
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/*
	 * 소셜바-작성자의 다른리뷰
	 */ 
	case "socialbar.review" :		
		$FRAME = "ajax";		
		$list = $CLASS_REVIEW->getMyReviewList($DB, "LIMIT 0, 10", $_POST['userno'], $blogno="");
		if(is_array($list) && $list[0]['rno'] != "") {					
			$jsonArr['result'] = "success";
			$jsonArr['list'] = $list;			
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/*
	 * 소셜바-신규리뷰
	 */ 
	case "socialbar.review.new" :		
		$FRAME = "ajax";
		$list = $CLASS_REVIEW->getReviewList($DB, "LIMIT 0, 20", $type="", $cate=array(), $status="1");
		if(is_array($list) && $list[0]['rno'] != "") {
			for($i=0; $i<sizeof($list); $i++) {
				$_review = $CLASS_REVIEW->getReview($DB, $list[$i]['rno']);
				$list[$i]['title'] = $BASE->strLimitUTF(strip_tags($_review['title']), 400, false, '...');
			}
			$jsonArr['result'] = "success";
			$jsonArr['list'] = $list;			
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 소셜바 트위터 토크등록
	 */
	case "socialbar.twitter.talk.proc" :
		$FRAME = "ajax";
		$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
		if($_SESSION['access_token']['user_id'] == "") {
			$jsonArr['result'] = "session";
			break;
		}		
		if($CLASS_TWITTER->isUser($DB, $_SESSION['access_token']['user_id']) == false){
			$jsonArr['result'] = "nouser";
			break;
		} 
		$connection = $CLASS_TWITTER->getConnection($DB, $_SESSION['access_token']['user_id']);
		$connection->post('statuses/update', array('status' => urldecode($_POST['msg'])." ".$_POST['url']));		
		$jsonArr['rno'] = $_POST['rno'];
		if($connection->http_code == 200) {	
			//$CLASS_TWITTER->initSession();
			$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);			
			
			$content_object = $connection->get('account/verify_credentials');
			$content = get_object_vars($content_object);
			$userid = $content['id'];  
			$name = $content['name']; 
			$arr = array();
			$arr[] = $_POST['rno'];		
			$arr[] = $review['blogno'];
			$arr[] = $review['userno'];
			$arr[] = ($_SESSION['userno'] != "") ? $_SESSION['userno'] : 0;
			$arr[] = $userid;
			$arr[] = $name;
			$arr[] = "T";
			$arr[] = $_SERVER['REMOTE_ADDR'];
			$arr[] = nl2br(htmlspecialchars(urldecode($_POST['msg'])));	
			$res = array();
			$res[] = $DB->call("p_review_talk_ins", $arr);
			if($res[0]['orcode'] == '-1') {
				$jsonArr['result'] = "limit";
			} else if($res[0]['orcode'] == '1') {
				$jsonArr['result'] = "success";
				$jsonArr['talk_cnt'] = $review['talk_cnt'] + 1;
				$jsonArr['talk'] = $CLASS_REVIEWTALK->getTalk($DB, $res[0]['otno']);
			} else {
				$jsonArr['result'] = "fail";
			}
		} else {
			$jsonArr['result'] = "fail";
		}
		break; 
	
	/**
	 * 페이스북 소셜바 토크등록
	 */
	case "socialbar.facebook.talk.proc" :
		$FRAME = "ajax";
		$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
		$user = $CLASS_FACEBOOK->facebook->getUser();
		if($user == "") {
			$jsonArr['result'] = "nouser";
			break;
		}
		$field = $CLASS_FACEBOOK->getSessionField();		
		if($CLASS_FACEBOOK->isLogin($DB, $_SESSION[$field['user_id']]) == false){
			$jsonArr['result'] = "session";
			break;
		} 
		try {
			$CLASS_FACEBOOK->facebook->api("/".$user."/feed?access_token=".$_SESSION[$field['access_token']], "POST", 
			array("access_token"=>$_SESSION[$field['access_token']], "message" =>urldecode($_POST['msg'])." ".$_POST['url']));			
			//$CLASS_FACEBOOK->initSession();
			$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);
			$profile = $CLASS_FACEBOOK->facebook->api('/me');	
			$userid = $profile['id'];  
			$name = $profile['name']; 
			$arr = array();
			$arr[] = $_POST['rno'];		
			$arr[] = $review['blogno'];
			$arr[] = $review['userno'];
			$arr[] = ($_SESSION['userno'] != "") ? $_SESSION['userno'] : 0;
			$arr[] = $userid;
			$arr[] = $name;
			$arr[] = "F";
			$arr[] = $_SERVER['REMOTE_ADDR'];
			$arr[] = nl2br(htmlspecialchars(urldecode($_POST['msg'])));	
			$res = array();
			$res[] = $DB->call("p_review_talk_ins", $arr);
			if($res[0]['orcode'] == '-1') {
				$jsonArr['result'] = "limit";
			} else if($res[0]['orcode'] == '1') {
				$jsonArr['result'] = "success";
				$jsonArr['talk_cnt'] = $review['talk_cnt'] + 1;
				$jsonArr['talk'] = $CLASS_REVIEWTALK->getTalk($DB, $res[0]['otno']);
			} else {
				$jsonArr['result'] = "fail";
			}
		} catch (FacebookApiException $e) {
			$jsonArr['result'] = "fail";
		}
		break; 
	
	/**
	 * 레뷰 소셜바 토크등록
	 */
	case "socialbar.talk.bak.proc" :
		$FRAME = "ajax";
		$CLASS_USER = &Module::singleton("User.User");		
		if($_SESSION['userno'] == ""){
			$jsonArr['result'] = "session";
			break;
		}
		if($CLASS_USER->isUser($DB, $_SESSION['userno']) == false) {
			$jsonArr['result'] = "nouser";
			break;
		}		
		$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);
		$arr = array();
		$arr[] = $_POST['rno'];		
		$arr[] = $review['blogno'];
		$arr[] = $review['userno'];
		$arr[] = $_SESSION['userno'];
		$arr[] = $_SESSION['userid'];
		$arr[] = $_SESSION['nickname'];
		$arr[] = $_SESSION['type'];
		$arr[] = $_SERVER['REMOTE_ADDR'];
		$arr[] = nl2br(htmlspecialchars(urldecode($_POST['msg'])));		
		$res = array();
		$res[] = $DB->call("p_review_talk_ins", $arr);
		if($res[0]['orcode'] == '-1') {
			$jsonArr['result'] = "limit";
		} else if($res[0]['orcode'] == '1') {
			$jsonArr['result'] = "success";
			$jsonArr['talk_cnt'] = $review['talk_cnt'] + 1;
			$jsonArr['talk'] = $CLASS_REVIEWTALK->getTalk($DB, $res[0]['otno']);			
		} else {
			$jsonArr['result'] = "fail";
		}
		break; 
	
	/**
	 * 레뷰 소셜바 토크등록
	 */
	case "socialbar.talk.proc" :
		$FRAME = "ajax";
		$CLASS_USER = &Module::singleton("User.User");
		$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
		$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");			
		$typeArr = array("R", "T", "F");		
		if(!in_array($_POST['type'], $typeArr)) {
			$jsonArr['result'] = "type";
			break;
		}
		$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);				
		if($_POST['type'] == "R") {
			
			if($_SESSION['userno'] == ""){
				$jsonArr['result'] = "session";
				break;
			}
			if($CLASS_USER->isUser($DB, $_SESSION['userno']) == false) {
				$jsonArr['result'] = "nouser";
				break;
			}			
			$arr = array();
			$arr[] = $_POST['rno'];		
			$arr[] = $review['blogno'];
			$arr[] = $review['userno'];
			$arr[] = $_SESSION['userno'];
			$arr[] = $_SESSION['userid'];
			$arr[] = $_SESSION['nickname'];
			$arr[] = $_POST['type'];
			$arr[] = $_SERVER['REMOTE_ADDR'];
			$arr[] = nl2br(htmlspecialchars(urldecode($_POST['msg'])));
			
		} else if($_POST['type'] == "T") {
			
			if($_SESSION['access_token']['user_id'] == "") {
				$jsonArr['result'] = "session";
				break;
			}
			$connection = $CLASS_TWITTER->getConnection($DB, $_SESSION['access_token']['user_id']);
			//if($connection->http_code == 200) {	
				//$CLASS_TWITTER->initSession();				
				$content_object = $connection->get('account/verify_credentials');
				$content = get_object_vars($content_object);
				$userid = $content['id'];  
				$name = $content['name']; 
				$arr = array();
				$arr[] = $_POST['rno'];		
				$arr[] = $review['blogno'];
				$arr[] = $review['userno'];
				$arr[] = ($_SESSION['userno'] != "") ? $_SESSION['userno'] : 0;
				$arr[] = $userid;
				$arr[] = $name;
				$arr[] = $_POST['type'];
				$arr[] = $_SERVER['REMOTE_ADDR'];
				$arr[] = nl2br(htmlspecialchars(urldecode($_POST['msg'])));	
			//} else {
			//	$jsonArr['result'] = "nouser";
			//	break;
			//}
		
		} else if($_POST['type'] == "F") {
			
			$user = $CLASS_FACEBOOK->facebook->getUser();
			if($user == "") {
				$jsonArr['result'] = "nouser";
				break;
			}
			$field = $CLASS_FACEBOOK->getSessionField();		
			if($CLASS_FACEBOOK->isLogin($DB, $_SESSION[$field['user_id']]) == false){
				$jsonArr['result'] = "session";
				break;
			} 
			$profile = $CLASS_FACEBOOK->facebook->api('/me');	
			$userid = $profile['id'];  
			$name = $profile['name']; 
			$arr = array();
			$arr[] = $_POST['rno'];		
			$arr[] = $review['blogno'];
			$arr[] = $review['userno'];
			$arr[] = ($_SESSION['userno'] != "") ? $_SESSION['userno'] : 0;
			$arr[] = $userid;
			$arr[] = $name;
			$arr[] = $_POST['type'];
			$arr[] = $_SERVER['REMOTE_ADDR'];
			$arr[] = nl2br(htmlspecialchars(urldecode($_POST['msg'])));	
		} else {
			$jsonArr['result'] = "fail";
			break;
		}		
		$res = array();
		$res[] = $DB->call("p_review_talk_ins", $arr);		
		if($res[0]['orcode'] == '-1') {
			$jsonArr['result'] = "limit";
		} else if($res[0]['orcode'] == '1') {
			$jsonArr['result'] = "success";
			$jsonArr['rno'] = $_POST['rno'];
			$jsonArr['talk_cnt'] = $review['talk_cnt'] + 1;
			$jsonArr['talk'] = $CLASS_REVIEWTALK->getTalk($DB, $res[0]['otno']);			
			if($_SESSION['access_token']['user_id'] != "") {
				$connection = $CLASS_TWITTER->getConnection($DB, $_SESSION['access_token']['user_id']);	
				//$connection->post('statuses/update', array('status' => urldecode($_POST['msg'])." ".$_POST['url']));
				$connection->post('statuses/update', array('status' => urldecode($_POST['msg'])));	
			}	
			$user = $CLASS_FACEBOOK->facebook->getUser();
			$field = $CLASS_FACEBOOK->getSessionField();
			if($user != "" && $user != "0" && $CLASS_FACEBOOK->isLogin($DB, $_SESSION[$field['user_id']]) == true){
				try {
					//$CLASS_FACEBOOK->facebook->api("/".$user."/feed?access_token=".$_SESSION[$field['access_token']], "POST", 
					//array("access_token"=>$_SESSION[$field['access_token']], "message" =>urldecode($_POST['msg'])." ".$_POST['url']));			
					//$CLASS_FACEBOOK->initSession();
					$CLASS_FACEBOOK->facebook->api("/".$user."/feed?access_token=".$_SESSION[$field['access_token']], "POST", 
					array("access_token"=>$_SESSION[$field['access_token']], "message" =>urldecode($_POST['msg'])));
				} catch (FacebookApiException $e) {}	
			}			
			
		} else {
			$jsonArr['result'] = "fail";
		}
		break; 
	
	/**
	 * 레뷰 소셜바 토크삭제
	 */
	case "socialbar.talk.delete.proc" :
		$FRAME = "ajax";
		$talk = $CLASS_REVIEWTALK->getTalk($DB, $_POST['tno']);
		$review = $CLASS_REVIEW->getReview($DB, $talk['rno']);
		if($talk['type'] == "T") {			
			if($_SESSION['access_token']['user_id'] == $talk['userid']) {
				$res = true;
			}
		} elseif($talk['type'] == "F") {
			$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
			$field = $CLASS_FACEBOOK->getSessionField();
			if($_SESSION[$field['user_id']] == $talk['userid']) {
				$res = true;
			}
		} else {
			if($_SESSION['userno'] == $talk['userno'] || $_SESSION['userno'] == $talk['ruserno']) {
				$res = true;
			}
		}
		if($res == true) {
			$arr = array();
			$arr[] = $_POST['tno'];		
			$arr[] = "1";
			$res = array();
			$res[] = $DB->call("p_review_talk_upd", $arr);
			if($res[0]['orcode'] == '1') {
				$jsonArr['result'] = "success";	
				$jsonArr['tno'] = $_POST['tno'];
				$jsonArr['talk_cnt'] = $review['talk_cnt']-1;
			} else {
				$jsonArr['result'] = "fail";
			}
		} else {
			$jsonArr['result'] = "priv";
		}
		break; 
	
	/**
	 * 소셜바 마지막토크
	 */
	case "socialbar.talk.last.proc" :
		$FRAME = "ajax";
		$talk = $CLASS_REVIEWTALK->getTalkLast($DB, $_POST['rno']);
		if(strlen($talk['talk']) > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['talk'] = $talk;
		} else {
			$jsonArr['talk'] = $talk['talk'] = "등록된 토크가 없습니다.";
			$jsonArr['result'] = "fail";
		}
		break; 
	
	/**
	 * 소셜바 토크더보기
	 */
	case "socialbar.talk.more.proc" : 
		$FRAME = "ajax";
		if($_POST['tno'] == ""){
			$jsonArr['result'] = "info";
			break;
		}
		$talk = $CLASS_REVIEWTALK->getTalkList($DB, $_POST['rno'], $num=15, $flag_del="0", $_POST['tno']);		
		$ntno = $CLASS_REVIEWTALK->getTalkNextTno($DB, $_POST['rno'], $flag_del="0", $talk[sizeof($talk)-1]['tno']);
		for($i=0; $i<sizeof($talk); $i++) {
			$talk[$i]['ref'] =  $CLASS_REVIEWTALK->transRef($talk[$i]['type'], $talk[$i]['nickname']);
			$talk[$i]['icon'] =  $CLASS_REVIEWTALK->transIcon($talk[$i]['type']);
		}
		if(sizeof($talk) > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['talk'] = $talk;
			$jsonArr['tno'] = $talk[sizeof($talk)-1]['tno'];
			$jsonArr['ntno'] = $ntno;
		} else {
			$jsonArr['result'] = "fail";
		}
		break;

	/**
	 * 디폴트
	 */ 
	default :
		Module::alert("잘못된 경로입니다.");
		//Module::redirectModule("index", $param="");
		break;

}

/**
 * AJAX OUTPUT 
 */
if($FRAME == "ajax") {
	$output = json_encode($jsonArr);
	print($output);
}
/**
 * MODULE & DB CONNECT CLOSE 
 */
Module::exitModule();
?>