<?php
/***************************************************************************************
 * 마이레뷰 컨트롤러
 * 
 * 작성일 : 2011.08.01
 * 작성자 :  이종학
 * 히스토리 : 
 * 
 * 2011.XX.XX (작성자)
 * > 수정내용1
 * > 수정내용2 
 * 
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
$CLASS_THUMBNAIL = &Module::singleton("Thumbnail"); 
$CLASS_FTP = &Module::singleton("Ftp");
$CLASS_FILE = &Module::singleton("File");
$CLASS_DIR = &Module::singleton("Dir");
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");
$CLASS_RSSPARSER = &Module::singleton("RSSParser");
$CLASS_SNOOPY = &Module::singletonExtends("Snoopy");
$CLASS_HTTP = &Module::singleton("Http");
$CLASS_CURL = &Module::singleton("Curl");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CASH = &Module::singleton("User.Cash");
$CLASS_POINT = &Module::singleton("User.Point");
$CLASS_GRADE = &Module::singleton("User.Grade");
$CLASS_FRIEND = &Module::singleton("User.Friend");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");
$CLASS_AUTH = &Module::singleton("Auth.Auth");
$CLASS_LOGIN = &Module::singleton("Auth.Login");

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
	/**
	 * 블로그 - URL 체크
	 */
	case "blog.validate.url.proc" :
		$FRAME = "ajax";		
		if($CLASS_BLOG->isBlogByURL($DB, trim($_POST['blog_url'])) == true) {
			$jsonArr['result'] = "exist";
			break;
		} 		
		$CLASS_CURL->init($_POST['blog_url'], "GET");
		$CLASS_CURL->setAutoReferer();
		$result = $CLASS_CURL->execute();
		if($result == false) {
			$jsonArr['result'] = "validate";
			break;
		}
		$rssurl = $CLASS_BLOG->getRSSURL($result->ResposeBody);
		$CLASS_CURL->close();		
		if($rssurl != "") {
			$_SESSION['BLOG_AUTHKEY'] = $CLASS_BLOG->createAuthKey();  
			$_SESSION['BLOG_AUTHKEY_LIFETIME'] = time() + (60 * 5);			
			$jsonArr['result'] = "success";
			$jsonArr['url'] = $rssurl; 
			$jsonArr['authkey'] = $_SESSION['BLOG_AUTHKEY'];
		} else {
			$jsonArr['result'] = "fail";
		} 
		break;
	
	/**
	 * 블로그 - 인증키 체크
	 */
	case "blog.auth.key.proc" :
		$FRAME = "ajax";		
		if($_SESSION['BLOG_AUTHKEY'] != $_POST['auth_key']) {
			$jsonArr['result'] = "wrong";
			break;
		}
		if($_SESSION['BLOG_AUTHKEY_LIFETIME'] < time()) {
			$jsonArr['result'] = "lifetime";
			break;
		}
		$CLASS_CURL->init($_POST['rss_url'], "GET");
		$CLASS_CURL->setAutoReferer();
		$result = $CLASS_CURL->execute();		
		$CLASS_RSSPARSER->parse($result->ResposeBody);
		$channel = $CLASS_RSSPARSER->getChannel();
		preg_match("/".$_POST['auth_key']."/", $result->ResposeBody, $match);	// Rss url 내의 값과, []auth key 값 비교	
		$CLASS_CURL->close();		
		if($match[0] != '' && $match[0] == $_POST['auth_key']) {
			$arr = array();
			$arr[] = $_SESSION['userno'];
			$arr[] = $_POST['blog_url'];
			$arr[] = $channel['title']; 
			$res = array();
			$res[] = $DB->call("p_blog_ins", $arr);
			$orcode = $res[0]['orcode'];
			if($orcode == '1') {				
				$jsonArr['result'] = "success";
				$DB->rConnect();
				$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $_SESSION['userno'], 2);
				$CLASS_LOGIN->addSession($blogInfo);				
				// 포인트지급
				$arr = array();
				$arr[] = $_SESSION['userno'];
				$arr[] = "0";  
				$arr[] = "105";  
				$arr[] = ""; 
				$DB->rConnect();
				$res[] = $DB->call("p_point_ins", $arr);							
			} elseif($orcode == '-1') {
				$jsonArr['result'] = "duplication";
			} else {
				$jsonArr['result'] = "fail";
			}
		} else {
			$jsonArr['result'] = "notauth";
		}
		break;
	
	/**
	 * 블로그 수정
	 */
	case "blog.modify.proc" :
		$FRAME = "ajax";
		$blog = $CLASS_BLOG->getBlog($DB, $_POST['blogno']);
		if($_POST['blogno'] == "") {
			$jsonArr['result'] = "info";
			break;
		} 
		if($blog['userno'] != $_SESSION['userno']) {
			$jsonArr['result'] = "priv";
			break;
		} 
		$arr = array();
		$arr[] = $_POST['blogno'];
		$arr[] = $_POST['name'];
		$res = array();
		$res[] = $DB->call("p_blog_upd", $arr);		
		if(Module::result($res) != false) {
			$jsonArr['result'] = "success";
			$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $_SESSION['userno'], 2);
			$CLASS_LOGIN->addSession($blogInfo);
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 블로그 삭제
	 */
	case "blog.delete.proc" :
		$FRAME = "ajax";		
		$blog = $CLASS_BLOG->getBlog($DB, $_POST['blogno']);
		if($_POST['blogno'] == "") {
			$jsonArr['result'] = "info";
			break;
		} 
		if($blog['userno'] != $_SESSION['userno']) {
			$jsonArr['result'] = "priv";
			break;
		} 
		$arr = array();
		$arr[] = $_POST['blogno'];
		$arr[] = "0";
		$res = array();
		$res[] = $DB->call("p_blog_del", $arr);		
		if(Module::result($res) != false) {
			$jsonArr['result'] = "success";
			$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $_SESSION['userno'], 2);
			$CLASS_LOGIN->addSession($blogInfo);
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 리뷰 - rss url 정보
	  public function init($url, $type="GET", $redirect=true, $cookie=null)
	 */
	case "review.rssurl.load.proc" :
		$FRAME = "ajax"; 	
		$CLASS_CURL->init($_POST['blog_url'], "GET");
		$CLASS_CURL->setAutoReferer(); 
		$result = $CLASS_CURL->execute();
		$rssurl = $CLASS_BLOG->getRSSURL($result->ResposeBody);
		$CLASS_CURL->close();		
		if($rssurl != "") {
			$jsonArr['result'] = "success";
			$jsonArr['url'] = $rssurl;
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 리뷰 - rss 게시물 정보
	 */
	case "review.article.load.proc" :
		$FRAME = "ajax";
		$CLASS_CURL->init($_POST['rss_url'], "GET");
		$CLASS_CURL->setAutoReferer();
		$result = $CLASS_CURL->execute(); // cURL 실행, 헤더쿠키저장, RSS피드 저장(ResposeBody)		
		$CLASS_RSSPARSER->parse($result->ResposeBody); // Rssparser를 통한 값 파싱 리턴값 true
		$CLASS_CURL->close();			
		$jsonArr['channel'] = $CLASS_RSSPARSER->getChannel(); //json이중배열 생성
		if($jsonArr['channel']['link'] != "") { //링크 값이 있다면
			$jsonArr['result'] = "success";	
			$jsonArr['struct'] = $CLASS_RSSPARSER->getStructure(); //쓰고있는지 모르겠음.
			//$jsonArr['image'] = $CLASS_RSSPARSER->getImages();
			//$jsonArr['textinput'] = $CLASS_RSSPARSER->getTextinputs();

			//** 중요 부분 
			$jsonArr['item'] = $CLASS_RSSPARSER->getItems();
			// 발행일형태를 변환, 기존의 리뷰가 등록되어있는지 체크
			$blogInfo = $CLASS_BLOG->getBlogByURL($DB, $_SESSION['userno'], $_POST['blog_url']);
			for($i=0; $i<sizeof($jsonArr['item']); $i++) {
				$jsonArr['item'][$i]['flag_review'] = ($CLASS_REVIEW->isReviewByURL($DB, $blogInfo['blogno'], $_SESSION['userno'], $jsonArr['item'][$i]['guid']) == true) ? "1" : "0";
				//$jsonArr['item'][$i]['flag_review'] = "1";
				$jsonArr['item'][$i]['date'] = $CLASS_BLOG->transdate($jsonArr['item'][$i]['pubdate']);				 
				preg_match('/<img[^>]*src=\"(https?:\/\/[\S\w]+)\"/i', $jsonArr['item'][$i]['description'], $match);
				if($match[1] != "") $jsonArr['item'][$i]['blogimage'] = $match[1];
				else $jsonArr['item'][$i]['blogimage'] = "";
				//else $jsonArr['item'][$i]['blogimage'] = "http://"._DOMAIN._DIR_IMAGES_."/common/thum/thum_profile_dummy4.gif";
				//print_r($match);
			}
		} else {
			$jsonArr['result'] = "fail";
		}
		break;		
	
	/**
	 * 리뷰썸네일이미지 업로드
	 */
	case "review.image.upload.proc" :
		
		if($CLASS_FILE->isRunByMime($_FILES['file1']['tmp_name'], "mime") == true) {
			Module::callScript("parent.reviewManager.checkImage();");
			break;
		}
		if($_FILES['file1']['error'] == "0") {
			$tmp = $_FILES['file1']['tmp_name'];
			$mime = $_FILES['file1']['type'];
			$size = $_FILES['file1']['size'];			
			$file1 = $_FILES['file1']['name'];
			$file2 = uniqid("").".".$CLASS_FILE->getExtname($file1);
			$file2_thumb = $CLASS_REVIEW->getThumbname($file2, "110");
			$res = array();
			$res[] = $CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 300, 300);
			$res[] = $CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2_thumb, 110, 110);			
			if(Module::result($res) != false) {
				$dir = _FTP_TMP;
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir);
				$CLASS_FTP->upload($dir."/".$file2, _DIR_TMP."/".$file2);
				$CLASS_FTP->upload($dir."/".$file2_thumb, _DIR_TMP."/".$file2_thumb);
				$CLASS_FTP->delete($dir."/".$_POST['thumbname']);
				$CLASS_FTP->delete($dir."/".$CLASS_REVIEW->getThumbname($_POST['thumbname'], "110"));
				$CLASS_FTP->close();
				$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				$CLASS_FILE->delete(_DIR_TMP."/".$file2_thumb);
				Module::callScript("parent.reviewManager.previewImage('$mime','$file2','$size');");
				break;
			}
		}
		Module::callScript("parent.reviewManager.initImage();");
		break;
	
	/**
	 * 리뷰등록
	 */
	case "review.register.proc" :
	
		$frno = Module::$param[0];		
		if($_POST['type'] == "B") { 
			// 등록된 블로그 인지 확인 
			$blog = $CLASS_BLOG->getBlogByURL($DB, $_SESSION['userno'], $_POST['blogURL']);
			if($blog['blogno'] == "") {
				Module::callScript("parent.reviewManager.resultForm('wrongblog');");
				exit;				
				break;
			}
			$_POST['pubdate'] = $CLASS_BLOG->transdate($_POST['pubdate']);
		}
		if($_POST['type'] == "U") {
			
			$blog['blogno'] = $CLASS_BLOG->isMyBlog($DB, $_SESSION['userno'], $_POST['feedURL'], true);
			if($blog['blogno'] == "") {
				Module::callScript("parent.reviewManager.resultForm('wrongblog');");
				exit;			
				break;
			}
			$_POST['pubdate'] = date("Y-m-d H:i:s");
		}		
		if($_POST['type'] == "R") {
			$_POST['blogno'] = "0";
			$_POST['pubdate'] = date("Y-m-d H:i:s");
		}
		if($_POST['type'] != "R") {
			// 기존등록된 게시물인지 체크
			//if($CLASS_REVIEW->isReview($DB, $blog['blogno'], $_POST['guid']) == true) {
			//	Module::callScript("parent.reviewManager.resultForm('repeat');");
			//	break;
			//}
			// 기존등록된 게시물인지 체크
			// $blog['blogno']정보는 위의 B/U일 경우 참조함
			if($CLASS_REVIEW->isReviewByURL($DB, $blog['blogno'], $_SESSION['userno'], $_POST['guid']) == true) {
				Module::callScript("parent.reviewManager.resultForm('repeat');");
				exit;
				break;
			}
		}				
		if($blog['blogno'] == "") {
			Module::callScript("parent.reviewManager.resultForm('wrongblog');");
			exit;			
			break;
		}
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$day_dir = $year."/".$month."/".$day;
		$to_dir = _FTP_REVIEWIMAGE."/".$day_dir;
		$from_dir = _FTP_TMP;
		$local_dir = _DIR_TMP;
		$_POST['regdate'] = $year."-".$month."-".$day." ".date("H:i:s");
		
		$img_cnt = sizeof($_POST['tx_attach_image']);
		$file_cnt = sizeof($_POST['tx_attach_file']);
		
		if($_POST['thumbname'] != "" || $img_cnt > 0 || $file_cnt > 0 || $_POST['blogimage'] != "") {
			$dir1 = _FTP_REVIEWIMAGE."/".$year;
			$dir2 = $dir1."/".$month;
			$dir3 = $dir2."/".$day;			
			$CLASS_FTP->connect("file");
			$CLASS_FTP->makeDir(_FTP_REVIEWIMAGE);
			$CLASS_FTP->makeDir($dir1);
			$CLASS_FTP->makeDir($dir2);
			$CLASS_FTP->makeDir($dir3);
			$CLASS_FTP->close();
		}
		
		if($img_cnt > 0 || $file_cnt > 0) {			
			$_textArr1 = array("http://"._DOMAIN_FILE."/"._FTP_TMP);
			$_textArr2 = array("http://"._DOMAIN_FILE."/"._FTP_REVIEWIMAGE."/".$day_dir);
			$_POST['description'] = str_replace($_textArr1, $_textArr2, $_POST['description']);
		}
		
		$arr = array();	
		$arr[] = $blog['blogno'];
		$arr[] = $_SESSION['userno'];
		$arr[] = $_POST['guid'];
		$arr[] = $_POST['type'];
		$arr[] = $_POST['status'];
		$arr[] = $_SERVER['REMOTE_ADDR'];
		$arr[] = $_POST['cate1'];
		$arr[] = $_POST['cate2'];
		$arr[] = $_POST['cate3'];
		$arr[] = $_POST['cate4'];
		$arr[] = $_POST['bcode'];
		$arr[] = $_POST['mcode'];
		$arr[] = $_POST['scode'];
		$arr[] = $_POST['addr'];
		$arr[] = $frno;
		$arr[] = $_POST['pubdate'];
		$arr[] = $_POST['regdate'];
		$arr[] = $_POST['title'];
		$arr[] = $_POST['description'];
		$res = array();
		$res[] = $DB->call("p_review_ins", $arr);
		
		if($res[0]['orcode'] == '1') {
			$rno = $res[0]['orno'];
			if($_POST['thumbname'] == "" && $_POST['blogimage'] != "") {
				$tmpfile = uniqid();
				$CLASS_FILE->uploadImageFile($_POST['blogimage'], $local_dir."/".$tmpfile);
				$file2 = uniqid();
				$tres = array();				
				$tres[] = $CLASS_THUMBNAIL->create($local_dir."/".$tmpfile, $local_dir."/".$file2, 300, 300);
				$tres[] = $CLASS_THUMBNAIL->create($local_dir."/".$tmpfile, $local_dir."/".$CLASS_REVIEW->getThumbname($file2, "110"), 110, 110);								
				$CLASS_FILE->delete($local_dir."/".$tmpfile);				
				if(Module::result($tres) != false) {		
					$file2ext = $CLASS_FILE->getExtnameByFile($local_dir."/".$file2);
					$file1 = $file2.".".$file2ext;
					$_POST['thumbmime'] = $CLASS_FILE->getMimeContentType($local_dir."/".$file2);
					$_POST['thumbname'] = $file1;
					$_POST['thumbname'] = $file1;
					$_POST['thumbsize'] = $CLASS_FILE->getFilesize($local_dir."/".$file2);
					$CLASS_FTP->connect("file");
					$CLASS_FTP->upload($to_dir."/".$file1, $local_dir."/".$file2);
					$CLASS_FTP->upload($to_dir."/".$CLASS_REVIEW->getThumbname($file1, "110"), $local_dir."/".$CLASS_REVIEW->getThumbname($file2, "110"));
					$CLASS_FTP->close();
					$CLASS_FILE->delete($local_dir."/".$file2);
					$arr = array();
					$arr[] = $rno;	
					$arr[] = "T";
					$arr[] = $_POST['thumbmime'];
					$arr[] = $_POST['thumbname'];
					$arr[] = $_POST['thumbname'];
					$arr[] = $_POST['thumbsize'];
					$arr[] = $_POST['regdate'];
					$DB->rConnect();
					$res[] = $DB->call("p_review_file_ins", $arr);
				}
			}			
			if($_POST['thumbname'] != "" && $_POST['blogimage'] == "") {
				$arr = array();
				$arr[] = $rno;	
				$arr[] = "T";
				$arr[] = $_POST['thumbmime'];
				$arr[] = $_POST['thumbname'];
				$arr[] = $_POST['thumbname'];
				$arr[] = $_POST['thumbsize'];
				$arr[] = $_POST['regdate'];
				$DB->rConnect();
				$res[] = $DB->call("p_review_file_ins", $arr);

				$file1 = $_POST['thumbname'];
				$file2 = $_POST['thumbname'];
				$CLASS_FTP->connect("file");
				$CLASS_FTP->move($from_dir."/".$file1, $to_dir."/".$file2);
				$CLASS_FTP->move($from_dir."/".$CLASS_REVIEW->getThumbname($file1, "110"), $to_dir."/".$CLASS_REVIEW->getThumbname($file2, "110"));
				$CLASS_FTP->close();
			}
			
			for($i=0; $i<$img_cnt; $i++) {
				$_imginfo = array();
				$_imginfo = explode("|", $_POST['tx_attach_image'][$i]);

				// 이미지파일정보입력
				$arr = array();
				$arr[] = $rno;
				$arr[] = "I";
				$arr[] = $BASE->getUnescape($_imginfo[0]); // filemime
				$arr[] = $BASE->getUnescape($_imginfo[1]); // filename
				$arr[] = $BASE->getUnescape($_imginfo[2]); // filename2
				$arr[] = $BASE->getUnescape($_imginfo[3]); // filesize
				$arr[] = $_POST['regdate'];
				$DB->rConnect();
				$res[] = $DB->call("p_review_file_ins", $arr);
				
				// 파일이동
				$file1 = $BASE->getUnescape($_imginfo[1]);
				$file2 = $file1;
				$CLASS_FTP->connect("file");
				$CLASS_FTP->move($from_dir."/".$file1, $to_dir."/".$file2);
				$CLASS_FTP->close();
			}
			
			for($i=0; $i<$file_cnt; $i++) {
				$_fileinfo = array();
				$_fileinfo = explode("|", $_POST['tx_attach_file'][$i]);
				$arr = array();
				$arr[] = $rno;
				$arr[] = "F";
				$arr[] = $BASE->getUnescape($_fileinfo[0]);
				$arr[] = $BASE->getUnescape($_fileinfo[1]);
				$arr[] = $BASE->getUnescape($_fileinfo[2]);
				$arr[] = $BASE->getUnescape($_fileinfo[3]);
				$arr[] = $_POST['regdate'];
				$DB->rConnect();
				$res[] = $DB->call("p_review_file_ins", $arr);

				$file1 = $BASE->getUnescape($_fileinfo[1]);
				$file2 = $file1;
				$CLASS_FTP->connect("file");
				$CLASS_FTP->move($from_dir."/".$file2, $to_dir."/".$file1);
				$CLASS_FTP->close();
			}
			
			$arr = array();
			$arr[] = $_SESSION['userno'];
			$arr[] = "0";  
			$arr[] = "300";  
			$arr[] = $rno; 
			$DB->rConnect();
			$res[] = $DB->call("p_point_ins", $arr);			
			//Module::alert("리뷰가 등록되었습니다.");
			//Module::redirectModule("myrevu", "review.register");

			/*
			* Facebook open graph start			
			*/
			$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
			$action_user = $CLASS_USER->getUser($DB, $_SESSION['userno']);
			if($action_user["flag_opengraph"] == "1"){
				try {					
						$CLASS_FACEBOOK->facebook->api("/me/revulove:Register?access_token=".$_SESSION[$field['access_token']], "POST", 
						array("access_token"=>$_SESSION[$field['access_token']], "review" =>"http://www.revu.co.kr/".$rno));
						//$jsonArr['opengraph_result'] = "success";
				} catch (FacebookApiException $e) {
					// Log Exception error
						//$jsonArr['opengraph_result'] = "fail";
				}	
			}else{
						//$jsonArr['opengraph_result'] = "disabled";
			}

			Module::callScript("parent.reviewManager.resultForm('success');");
		} else {
			Module::callScript("parent.reviewManager.resultForm('fail');");
		}
		break;
	
	/**
	 * 리뷰수정을위한 리뷰정보
	 */
	case "review.info.proc" :
		$FRAME = "ajax";
		if($_POST['rno'] == "") {
			$jsonArr['result'] = "info";
			break;
		}				
		$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);
		$fileInfo = $CLASS_REVIEW->getReviewFile($DB, $_POST['rno'], $type="T", $flag_del="0");			
		if($review['userno'] != $_SESSION['userno']) {
			$jsonArr['result'] = "perm";
			break;
		}
		if($review['rno'] != "") {
			$jsonArr['result'] = "success";
			$jsonArr['review'] = $review;
			$jsonArr['cate'] = $review['cate1'].$review['cate2'].$review['cate3'].$review['cate3'];
			$jsonArr['area'] = $review['area1'].$review['area2'].$review['area3'];
			$jsonArr['blogimage'] = $CLASS_REVIEW->getThumbimage($fileInfo[0]['filename'], $review['regdate']);
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 리뷰수정
	 */
	case "review.modify.proc" :
		if($_POST['rno'] == "") {
			Module::callScript("parent.reviewManager.resultForm('info');");
			break;			
		}		
		$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);					
		if($review['userno'] != $_SESSION['userno']) {
			Module::callScript("parent.reviewManager.resultForm('perm');");
			break;
		}
		// p_review_upd 배열
		$arr = array();	
		$arr[] = $_POST['rno'];
		$arr[] = $_POST['cate1'];
		$arr[] = $_POST['cate2'];
		$arr[] = $_POST['cate3'];
		$arr[] = $_POST['cate4'];
		$arr[] = $_POST['bcode'];
		$arr[] = $_POST['mcode'];
		$arr[] = $_POST['scode'];
		$arr[] = $_POST['addr'];
		$arr[] = $_POST['title'];
		$res = array();
		$res[] = $DB->call("p_review_upd", $arr);
		
		if($res[0]['orcode'] == '1') {
			$year = substr($review['regdate'], 0, 4);
			$month = substr($review['regdate'], 5, 2);
			$day = substr($review['regdate'], 8, 2);			
			$day_dir = $year."/".$month."/".$day;
			$to_dir = _FTP_REVIEWIMAGE."/".$day_dir;
			$from_dir = _FTP_TMP;
			if($_POST['thumbname'] != "") {
				$dir1 = _FTP_REVIEWIMAGE."/".$year;
				$dir2 = $dir1."/".$month;
				$dir3 = $dir2."/".$day;	
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir(_FTP_REVIEWIMAGE);
				$CLASS_FTP->makeDir($dir1);
				$CLASS_FTP->makeDir($dir2);
				$CLASS_FTP->makeDir($dir3);
				$CLASS_FTP->close();
			}
			$fileInfo = $CLASS_REVIEW->getReviewFile($DB, $_POST['rno'], $type="T", $flag_del="0");
			if($_POST['thumbname'] != "") {
				if($fileInfo[0]['filename'] != "") {
					$arr = array();
					$arr[] = $_POST['rno'];	
					$arr[] = "T";
					$arr[] = $_POST['thumbmime'];
					$arr[] = $fileInfo[0]['filename'];
					$arr[] = $fileInfo[0]['filename2'];
					$arr[] = $_POST['thumbsize'];
					$DB->rConnect();
					$res[] = $DB->call("p_review_file_upd", $arr);
					$file1 = $_POST['thumbname'];
					$file2 = $fileInfo[0]['filename'];
					$CLASS_FTP->connect("file");
					$CLASS_FTP->move($from_dir."/".$file1, $to_dir."/".$file2);
					$CLASS_FTP->move($from_dir."/".$CLASS_REVIEW->getThumbname($file1, "110"), $to_dir."/".$CLASS_REVIEW->getThumbname($file2, "110"));
					$CLASS_FTP->close();
				} else {
					$arr = array();
					$arr[] = $_POST['rno'];
					$arr[] = "T";
					$arr[] = $_POST['thumbmime'];
					$arr[] = $_POST['thumbname'];
					$arr[] = $_POST['thumbname'];
					$arr[] = $_POST['thumbsize'];
					$arr[] = date("Y-m-d H:i:s");
					$DB->rConnect();
					$res[] = $DB->call("p_review_file_ins", $arr);
					$file1 = $_POST['thumbname'];
					$file2 = $_POST['thumbname'];
					$CLASS_FTP->connect("file");
					$CLASS_FTP->move($from_dir."/".$file1, $to_dir."/".$file2);
					$CLASS_FTP->move($from_dir."/".$CLASS_REVIEW->getThumbname($file1, "110"), $to_dir."/".$CLASS_REVIEW->getThumbname($file2, "110"));
					$CLASS_FTP->close();
				}
			}
			Module::callScript("parent.reviewManager.resultForm('update');");
		} else {
			Module::callScript("parent.reviewManager.resultForm('updatefail');");
		}
		
		if($review['rno'] != "") {
			$jsonArr['result'] = "success";
			$jsonArr['review'] = $review;
			$jsonArr['cate'] = $review['cate1'].$review['cate2'].$review['cate3'].$review['cate3'];
			$jsonArr['area'] = $review['area1'].$review['area2'].$review['area3'];
			$jsonArr['blogimage'] = $CLASS_REVIEW->getThumbimage($file[0]['filename'], $review['regdate']);
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 리뷰삭제 (상태값만 변경)
	 */
	case "review.delete.proc" :
		$FRAME = "ajax";
		if($_POST['rno'] == "") {
			$jsonArr['result'] = "info";
			break;
		}				
		$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);		
		if($review['userno'] != $_SESSION['userno'] || $_SESSION['userno'] == "") {
			$jsonArr['result'] = "perm";
			break;
		} 		
		// 캐시지급받은 리뷰는 삭제 불가능
		/*
		if($review['cash'] > 0) {
			$jsonArr['result'] = "cash";
			break;
		} 
		*/		
		$arr = array();
		$arr[] = $_POST['rno'];
		$arr[] = "2";		
		$res = array();
		$res[] = $DB->call("p_review_status_upd", $arr);
		
		$arr = array();
		$arr[] = $_SESSION['userno'];
		$arr[] = "1";  
		$arr[] = "350";  
		$arr[] = $_POST['rno']; 
		$DB->rConnect();
		$res[] = $DB->call("p_point_ins", $arr);
			
		if($res[0]['orcode'] == '1') {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 리뷰선택삭제 (상태값만 변경)
	 */
	case "review.choose.delete.proc" :
		$FRAME = "ajax";
		if($_POST['checkno'] == "") {
			$jsonArr['result'] = "info";
			break;
		}
		if($_SESSION['userno'] == "") {
			$jsonArr['result'] = "perm";
			break;
		}
		$rno = explode("|", $_POST['checkno']);		
		$res = array();		
		for($i=0; $i<sizeof($rno); $i++) {
			$review = $CLASS_REVIEW->getReview($DB, $rno[$i]);
			if($review['userno'] == $_SESSION['userno']) {				
				$arr = array();
				$arr[] = $rno[$i];
				$arr[] = "2";
				$DB->rConnect();				
				$res[] = $DB->call("p_review_status_upd", $arr);				
				// 포인트삭제
				$arr = array();
				$arr[] = $_SESSION['userno'];
				$arr[] = "1";  
				$arr[] = "350";  
				$arr[] = $rno[$i]; 
				$DB->rConnect();
				$res[] = $DB->call("p_point_ins", $arr);
			} 
		}
		if(Module::result($res, "err", "-1") == false) {
			$jsonArr['result'] = "fail";
		} else {
			$jsonArr['result'] = "success";
		}	
		break;
	
	/**
	 * 프렌즈 그룹(분류 )등록 
	 */
	case "friend.group.reg.proc" :
		$FRAME = "ajax";
		if($CLASS_FRIEND->isFriendGroupDesc($DB, $_SESSION['userno'], $_POST['gdesc']) == true) {
			$jsonArr['result'] = "repeat";
			break;
		} 
		$arr = array();
		$arr[] = $_SESSION['userno'];
		$arr[] = $_POST['gdesc'];		
		$res = array();
		$res[] = $DB->call("p_friend_group_ins", $arr);		
		if($res[0]['orcode'] == '1') {
			$jsonArr['result'] = "success";
			$jsonArr['groupno'] = $res[0]['ogroupno'];	
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 프렌즈 그룹(분류 )삭제
	 */
	case "friend.group.delete.proc" :
		$FRAME = "ajax";
		
		$arr = array();
		$arr[] = $_POST['groupno'];
		
		$res = array();
		$res[] = $DB->call("p_friend_group_del", $arr);
		
		if($res[0]['orcode'] == '1') {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 회원검색
	 */
	case "friend.user.search.proc" :
		$FRAME = "ajax";
		switch($_POST['type']) {
			case "email" : 
				$list = $CLASS_FRIEND->getFriendByEmail($DB, $_POST['keyword']);
				break;
			case "nickname" :
			default : 
				$list = $CLASS_FRIEND->getFriendByNick($DB, $_POST['keyword']);
				break;
		}
		$size = sizeof($list);
		for($i=0; $i<$size; $i++) {
			$extra = $CLASS_USER->getUserExtra($DB, $list[$i]['userno']);
			$list[$i]['userimage'] = $CLASS_USER->getImage($list[$i]['userno'], $extra['userimage']);
		}		
		if($size > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['list'] = $list;
			$jsonArr['size'] = number_format($size);
			$jsonArr['keyword'] = $_POST['keyword'];
		} else {
			$jsonArr['result'] = "fail";
			$jsonArr['keyword'] = $_POST['keyword'];
		}
		break;
	
	/**
	 * 프렌즈 추가
	 */
	case "friend.user.add.proc" :
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
	 * 프렌즈 삭제
	 */
	case "friend.user.delete.proc" :
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
	 * 회원이미지 임시업로드
	 */
	case "info.image.upload.proc" :
		
		if($_FILES['file1']['error'] == "0") {
			$tmp = $_FILES['file1']['tmp_name'];
			$file1 = $_FILES['file1']['name'];
			$file2 = uniqid("");
			
			if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 100, 100) == true) {
				$dir = _FTP_TMP;
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir);
				$CLASS_FTP->upload($dir."/".$file2, _DIR_TMP."/".$file2);
				$CLASS_FTP->delete($dir."/".$_POST['tmpimage']);
				$CLASS_FTP->close();
				$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				Module::callScript("parent.myinfo.previewUserImage('$file2');");
				break;
			}
		} 
		Module::callScript("parent.myinfo.initUserImage();");		
		break;
	
	/**
	 * 회원정보수정
	 */
	case "info.modify.proc" :		
		
		if($_SESSION['infoKey'] == "" || $CLASS_ENCRYPTER->decryptMD5($_SESSION['infoKey'], "info") != $_SERVER['REMOTE_ADDR']) {
			Module::alert("잘못된 경로입니다.");
			Module::redirect("/myrevu");
			break;
		}
				
		if(empty($_SESSION['userno'])) {
			Module::alert("잘못된 경로입니다.");
			Module::redirect("/myrevu");
			break;
		}
		
		if($CLASS_USER->isUserID($DB, $_SESSION['userid'], $_SESSION['type']) == false) {
			Module::alert("회원아이디가 존재하지 않습니다.");
			Module::redirect("/");
			break;
		}		
		
		$_SESSION['infoKey'] = "";		
		
		$acArr = array();
		$acArr[] = $_SESSION['userno'];
		$acArr[] = ($_SESSION['type'] == "R") ? $_POST['passwd'] : $_SESSION['userid'];
		$acArr[] = $_POST['nickname'];
		$acArr[] = $_POST['email'];		
		$acArr[] = ($_POST['flag_email'] == "") ? "1" : "0";
		$res = array();
		$res[] = $DB->call("p_account_upd", $acArr);
		
		if($res[0]['orcode'] == '1') {			
			$res[0]['ouserno'] = $_SESSION['userno'];
			if($_POST['tmpimage'] != "" && $_FILES['file1']['error'] == "0") {
				$idx = ceil($res[0]['ouserno']/10000);
				$dir1 = _FTP_USERIMAGE."/".$idx;
				$dir2 = _FTP_TMP;
				$file1 = $res[0]['ouserno'].".".$CLASS_FILE->getExtname($_FILES['file1']['name']);
				$file2 = $_POST['tmpimage'];
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir1);
				$CLASS_FTP->move($dir2."/".$file2, $dir1."/".$file1);
				$CLASS_FTP->close();
				$_POST['userimage'] = $file1;
			} else {
				$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']);
				$_POST['userimage'] = $extraInfo['userimage'];
			}
			$acArr = array();
			$acArr[] = $res[0]['ouserno'];
			$acArr[] = ($_POST['gender'] == "") ? "A" : $_POST['gender'];
			$acArr[] = (($_POST['birth_year'] != '') && ($_POST['birth_month'] != '') && ($_POST['birth_day'] != '')) ? $_POST['birth_year']."-".$_POST['birth_month']."-".$_POST['birth_day'] : '';
			$acArr[] = $_POST['flag_lunar'];
			$acArr[] = (($_POST['cell1'] != '') && ($_POST['cell2'] != '') && ($_POST['cell3'] != '')) ? $_POST['cell1']."-".$_POST['cell2']."-".$_POST['cell3'] : '';
			$acArr[] = (($_POST['tel1'] != '') && ($_POST['tel2'] != '') && ($_POST['tel3'] != '')) ? $_POST['tel1']."-".$_POST['tel2']."-".$_POST['tel3'] : '';
			$acArr[] = $_POST['addrzip'];
			$acArr[] = $_POST['addr1'];
			$acArr[] = $_POST['addr2'];
			$acArr[] = $_POST['userimage'];
			$DB->rConnect();
			$res[] = $DB->call("p_account_extra_upd", $acArr);
			
			$acArr = array();
			$acArr[] = $res[0]['ouserno'];	
			$DB->rConnect();	
			$res[] = $DB->call("p_account_area_code_del", $acArr);

			$acArr = array();
			$acArr[] = $res[0]['ouserno'];	
			$acArr[] = $_POST['area_bcode1'];
			$acArr[] = $_POST['area_mcode1'];
			$acArr[] = $_POST['area_scode1'];
			$DB->rConnect();	
			$res[] = $DB->call("p_account_area_code_ins", $acArr);
			
			$acArr = array();
			$acArr[] = $res[0]['ouserno'];	
			$acArr[] = $_POST['area_bcode2'];
			$acArr[] = $_POST['area_mcode2'];
			$acArr[] = $_POST['area_scode2'];
			$DB->rConnect();
			$res[] = $DB->call("p_account_area_code_ins", $acArr);
			
			$acArr = array();
			$acArr[] = $res[0]['ouserno'];	
			$DB->rConnect();	
			$res[] = $DB->call("p_account_cate_code_del", $acArr);
			
			for($i=0; $i<sizeof($_POST['cate']); $i++) {
				$acArr = array();
				$acArr[] = $res[0]['ouserno'];	
				$acArr[] = $_POST['cate'][$i];
				$acArr[] = '';
				$acArr[] = '';
				$acArr[] = '';
				$acArr[] = '';
				$acArr[] = '';				
				$DB->rConnect();
				$res[] = $DB->call("p_account_cate_code_ins", $acArr);
			}
			
			if(Module::result($res, "err", "-1") == false) {
				Module::alert("회원정보 수정  처리가 실패하였습니다.");
				Module::redirect("http://"._DOMAIN."/myrevu/info");
			} else {				
				$DB->rConnect();
				$userInfo = $CLASS_USER->getUser($DB, $res[0]['ouserno']);
				$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']);
				$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']);
				$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno'], 2);
				$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2);
				$frontierInfo2 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "B", 2);
				$cashInfo = $CLASS_CASH->getCash($DB, $userInfo['userno']);
				$pointInfo = $CLASS_POINT->getPoint($DB, $userInfo['userno']);
				$userInfo['grade'] = $CLASS_GRADE->getGrade($DB, $userInfo['userno']); 
				$userInfo['cash'] = number_format($cashInfo['cash']);
				$userInfo['point'] = number_format($pointInfo['point']);
				$statsInfo['review_cnt'] = number_format($statsInfo['review_cnt']);
				$statsInfo['recom_cnt'] = number_format($statsInfo['recom_cnt']);
				$statsInfo['talk_cnt'] = number_format($pointInfo['talk_cnt']);
				//$CLASS_LOGIN->initSession();
				$CLASS_LOGIN->setSnsLoginSession($userInfo);
				$CLASS_LOGIN->addSession($extraInfo);
				$CLASS_LOGIN->addSession($statsInfo);
				$CLASS_LOGIN->addSession($blogInfo);
				$CLASS_LOGIN->addSession($frontierInfo1);
				$CLASS_LOGIN->addSession($frontierInfo2);
				$_SESSION['userimage'] = $CLASS_USER->getImage($userInfo['userno'], $extraInfo['userimage']);
				$arr = array();
				$arr[] = $userInfo['userno'];
				$arr[] = $userInfo['grade'];
				$DB->rConnect();
				$res[] = $DB->call("p_account_grade_upd", $arr);
				if($CLASS_LOGIN->isLoginPastTime($DB, $userInfo['userno'], $time=24) == true) {
					$arr = array();
					$arr[] = $userInfo['userno'];
					$arr[] = "0";  
					$arr[] = "101";  
					$arr[] = ""; 
					$DB->rConnect();
					$res[] = $DB->call("p_point_ins", $arr);
				}
				$arr = array();
				$arr[] = $userInfo['userno'];
				$arr[] = "I";  
				$DB->rConnect();
				$res[] = $DB->call("p_account_login_upd", $arr);
				Module::alert("회원정보가 수정되었습니다.");
				Module::redirect("http://"._DOMAIN."/myrevu");
			}
		} else {
			Module::alert("회원정보 수정이 실패하였습니다.");
			Module::redirect("http://"._DOMAIN."/myrevu/info");
		}
		break;
	
	/**
	 * 회원탈퇴처리
	 */
	case "secede.proc" : 
		
		if($_SESSION['secedeKey'] == "" || $CLASS_ENCRYPTER->decryptMD5($_SESSION['secedeKey'], "secede") != $_SERVER['REMOTE_ADDR']) {
			Module::alert("잘못된 경로입니다.");
			Module::redirect("/myrevu");
		}
		$_SESSION['secedeKey'] = "";
		//$_POST['passwd'] = $BASE->stripScpecial($_POST['passwd']);
		$_POST['passwd'] = ($_SESSION['type'] == "R") ? $_POST['passwd'] : $_SESSION['userid'];		
		$_REQUEST['url'] = urldecode($_REQUEST['url']);
		if($CLASS_USER->isUserID($DB, $_SESSION['userid'], $_SESSION['type']) == true) {
			if($CLASS_USER->isUserPass($DB, $_SESSION['userid'], $_POST['passwd'], $_SESSION['type']) == true) {
				$arr = array();		
				$arr[] = $_SESSION['userno'];
				$arr[] = $_POST['secede_type'];
				$arr[] = $_POST['secede_content'];								
				$res = array();
				$res[] = $DB->call("p_account_del", $arr);
			} else {
				$res[]['err'] = "-1";
				$msg = "비밀번호가 일치 하지 않습니다.";
			}
		} else {
			$res[]['err'] = "-1";
			$msg = "존재하지 않는 아이디입니다.";
		}
		
		if(Module::result($res, "err", "-1") == false) {
			if($msg) {
				Module::alert($msg);
				Module::redirect("/myrevu/secede");	
			} else {
				Module::alert("탈퇴 처리가 실패하였습니다.");
				Module::redirect("/myrevu");		
			}
		} else {
			// 세션초기화
			$CLASS_LOGIN->initSession();
			Module::alert("탈퇴 처리되었습니다.");
			Module::redirect("/");
		}		
		break;
	
	/**
	 * 캐시출금이미지 업로드
	 */
	case "cash.image1.upload.proc" :
		
		if($CLASS_FILE->isRunByMime($_FILES['file1']['tmp_name'], "mime") == true) {
			Module::callScript("parent.mycash.checkImage();");
			break;
		}
		if($_FILES['file1']['error'] == "0") {
			$tmp = $_FILES['file1']['tmp_name'];
			$mime = $_FILES['file1']['type'];
			$size = $_FILES['file1']['size'];			
			$file1 = $_FILES['file1']['name'];
			$file2 = uniqid("").".".$CLASS_FILE->getExtname($file1);
			if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 600, 600) == true) {
				$dir = _FTP_TMP;
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir);
				$CLASS_FTP->upload($dir."/".$file2, _DIR_TMP."/".$file2);
				$CLASS_FTP->delete($dir."/".$_POST['thumbname1']);
				$CLASS_FTP->close();
				$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				Module::callScript("parent.mycash.previewImage(1, '$mime','$file2','$size');");
				break;
			}
		}
		Module::callScript("parent.mycash.initImage(1);");
		break;
	
	/**
	 * 캐시출금이미지 업로드
	 */
	case "cash.image2.upload.proc" :	
			
		if($CLASS_FILE->isRunByMime($_FILES['file2']['tmp_name'], "mime") == true) {
			Module::callScript("parent.mycash.checkImage();");
			break;
		}
		if($_FILES['file2']['error'] == "0") {
			$tmp = $_FILES['file2']['tmp_name'];
			$mime = $_FILES['file2']['type'];
			$size = $_FILES['file2']['size'];			
			$file1 = $_FILES['file2']['name'];
			$file2 = uniqid("").".".$CLASS_FILE->getExtname($file1);
			if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 600, 600) == true) {
				$dir = _FTP_TMP;
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir);
				$CLASS_FTP->upload($dir."/".$file2, _DIR_TMP."/".$file2);
				$CLASS_FTP->delete($dir."/".$_POST['thumbname2']);
				$CLASS_FTP->close();
				$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				Module::callScript("parent.mycash.previewImage(2, '$mime','$file2','$size');");
				break;
			}
		}
		Module::callScript("parent.mycash.initImage(2);");
		break;
	
	case "cash.withdraw.proc" :
		
		if($_SESSION['withdrawKey'] == "" || $CLASS_ENCRYPTER->decryptMD5($_SESSION['withdrawKey'], "withdraw") != $_SERVER['REMOTE_ADDR']) {
			Module::alert("잘못된 경로입니다.");
			Module::redirect("/myrevu/cash");
			break;
		}
				
		if(empty($_SESSION['userno'])) {
			Module::alert("잘못된 경로입니다.");
			Module::redirect("/myrevu/cash");
			break;
		}
		
		if($CLASS_USER->isUserID($DB, $_SESSION['userid'],$_SESSION['type']) == false) {
			Module::alert("회원아이디가 존재하지 않습니다.");
			Module::redirect("/");
			break;
		}		
		$_SESSION['withdrawKey'] = "";
		$arr = array();
		$arr[] = $_SESSION['userno'];
		$arr[] = $_POST['cash'];
		$arr[] = $_POST['name'];
		$arr[] = trim($_POST['socialno1']).trim($_POST['socialno2']);
		$arr[] = $_POST['bankcode'];
		$arr[] = $_POST['account_holder'];
		$arr[] = $_POST['account_number'];
		$arr[] = $_POST['attach_type1'];
		$arr[] = $_POST['attach_type2'];		
		$arr[] = $_SERVER['REMOTE_ADDR'];
		$res = array();
		$res[] = $DB->call("p_cash_withdraw_ins", $arr);
		
		if($res[0]['orcode'] == '1') {						
			$wno = $res[0]['owno'];			
			$arr = array();
			$arr[] = $_SESSION['userno'];
			$arr[] = "1"; 
			$arr[] = "100"; 
			$arr[] = $_POST['cash'];
			$arr[] = "";
			$DB->rConnect();
			$res[] = $DB->call("p_cash_ins", $arr);

			$year = date("Y");
			$month = date("m");
			$day = date("d");
			$day_dir = $year."/".$month."/".$day;
			$to_dir = _FTP_WITHDRAWIMAGE."/".$day_dir;
			$from_dir = _FTP_TMP;
			
			if($_POST['thumbname1'] != "" || $_POST['thumbname2'] != "") {
				$dir1 = _FTP_WITHDRAWIMAGE."/".$year;
				$dir2 = $dir1."/".$month;
				$dir3 = $dir2."/".$day;	
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir(_FTP_WITHDRAWIMAGE);
				$CLASS_FTP->makeDir($dir1);
				$CLASS_FTP->makeDir($dir2);
				$CLASS_FTP->makeDir($dir3);
				$CLASS_FTP->close();
			}		
			
			if($_POST['thumbname1'] != "") {
				$arr = array();
				$arr[] = $wno;	
				$arr[] = "I";
				$arr[] = $_POST['thumbmime1'];
				$arr[] = $_POST['thumbname1'];
				$arr[] = $_POST['thumbsize1'];
				$DB->rConnect();
				$res[] = $DB->call("p_cash_withdraw_file_ins", $arr);
								
				$file1 = $_POST['thumbname1'];
				$file2 = $_POST['thumbname1'];
				$CLASS_FTP->connect("file");
				$CLASS_FTP->move($from_dir."/".$file1, $to_dir."/".$file2);
				$CLASS_FTP->close();
			}
			
			if($_POST['thumbname2'] != "") {
				// 썸네일정보 입력
				$arr = array();
				$arr[] = $wno;	
				$arr[] = "A";
				$arr[] = $_POST['thumbmime2'];
				$arr[] = $_POST['thumbname2'];
				$arr[] = $_POST['thumbsize2'];
				$DB->rConnect();
				$res[] = $DB->call("p_cash_withdraw_file_ins", $arr);
				
				$file1 = $_POST['thumbname2'];
				$file2 = $_POST['thumbname2'];
				$CLASS_FTP->connect("file");
				$CLASS_FTP->move($from_dir."/".$file1, $to_dir."/".$file2);
				$CLASS_FTP->close();
			}
		}
		if(Module::result($res, "err", "-1") == false) {
			Module::alert("캐시출금 처리가 실패하였습니다.");
			Module::redirect("/myrevu/cash");
		} else {
			Module::alert("캐시출금이 신청되었습니다.");
			Module::redirect("/myrevu/cash");
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
