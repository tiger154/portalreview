<?php
set_time_limit(5000000);
require_once "/www/revu39/engine/_extends/php.simple_html_dom/simple_html_dom.php";
require_once '/usr/local/php5/lib/php/Benchmark/Iterate.php';
require_once '/usr/local/php5/lib/php/Benchmark/Profiler.php';
require_once '/usr/local/php5/lib/php/Benchmark/Timer.php';
require_once "/www/revu39/engine/model/class.crawll.php";

$CLASS_CRAWLL = new Crawll;
$benchTimer = new Benchmark_Timer;
$bench = new Benchmark_Iterate;
$profiler = new Benchmark_Profiler;

$start = microtime(true);


function file_get_data_htmldom_($url) {
			$ch = curl_init();
			//$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
			//$userAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
			$userAgent ="Mozilla/5.0 (Windows NT 5.1) AppleWebkit/537.11 (KHTML, like Gecko) Chrome/23.0.127.64 Safari/537.11";
			curl_setopt($ch,CURLOPT_USERAGENT, $userAgent);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,1); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in seconds
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE); 
			//curl_setopt($ch, CURLOPT_COOKIEFILE, _DIR_TMP.'/cookies.txt');
			//curl_setopt ($ch, CURLOPT_COOKIEJAR, _DIR_TMP.'/cookies.txt');
			curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 		
			curl_setopt($ch, CURLOPT_URL, $url);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
}


function get_links_curl($url) { 
	
    // Create a new DOM Document to hold our webpage structure 
    $xml = new DOMDocument(); 
    $xml->preserveWhiteSpace = false;
    // Load the url's contents into the DOM 
    $returnF = file_get_data_htmldom_($url); 
	@$xml->loadHTML($returnF); 

	$domXpath = new DOMXpath($xml);
    $query_string = "//img|//dl[@class='priceList']/dd";
	//$query_string ="//img|//span[@class='p1']|//span[@class='txtype1']";
	$final_nodes = $domXpath->query($query_string);


    // Empty array to hold all links to return 
//   $links = array(); 
//  
//    //Loop through each <a> tag in the dom and add it to the link array 
    foreach($final_nodes as $link) { 
		//echo $link->tagName."------".$link->getNodePath() ."---------".$link->textContent. "<br>";
        $links[] = $link->getAttribute('src'); 
		//$links[] = array('url' => $link->getAttribute('src'), 'text' => $link->nodeValue); 
    } 
	//print_r($links);
    //Return the links 
    return $links; 
} 

function get_links($url) { 
 
    // Create a new DOM Document to hold our webpage structure 
    $xml = new DOMDocument(); 

    // Load the url's contents into the DOM 
//    $returnF = file_get_data_htmldom($url); 
//	@$xml->loadHTML($returnF); 
	@$xml->loadHTMLFile($url); 
	
    // Empty array to hold all links to return 
    $links = array(); 
  
    //Loop through each <a> tag in the dom and add it to the link array 
    foreach($xml->getElementsByTagName('img') as $link) { 
        $links[] = array('url' => $link->getAttribute('src'), 'text' => $link->nodeValue); 
    } 
  
    //Return the links 
    return $links; 
} 
//$url = "http://www.gsshop.com/prd/prd.gs?prdid=10345013";
//$url = "http://www.wizwid.com/CSW/handler/wizwid/kr/ShopProduct-Start?CategoryID=001154463&AssortID=750941749&ClickCategoryID=001143001";
//$url = "http://www.hyundaihmall.com/front/shItemDetailR.do?ItemCode=2015286489&SkyScraper=RecentviewItem";
//$url = "http://www.revu.co.kr";
$url = "http://www.pinterest.com";
$url = "http://www.pinspire.com/";
//$url = "http://www.lotteimall.com/planmall/etv_tvshow1203/Index.jsp";
//$url = "http://www.lotteimall.com/planmall/want_giftcard/Index.jsp?#category_2";
// Manual mode, so start manually
//$profiler->start();
//get_links($url);
//get_links_curl($url);
//get_links_curl($url);
//get_links($url);

	
//// Manual mode, stop and display results
//$profiler->stop();
//$profiler->display();

//print_r($data);


function parse_data_simpledom($url,$CLASS_CRAWLL){
	$html = file_get_html_curl($url); //CURL 파싱
	//@@ img extract
	if ($html->find('img')) {					

		foreach ( $html->find ("img, dd[class=sellPrice]") as $element ) {
						
			//*@@ By url, parse elements and store to array thing found
			
			$nodes [] = $element->src; // img tag extract						
		
		}
	}else{
		echo "There aren't images";
	}	
	//	print_r($nodes);
	$html->clear();
    unset($html);
}

function parse_data_domdocument($url){
	 $links__ = get_links_curl($url);
	return $links__;
}
function get_server_cpu_usage(){
 
	$load = sys_getloadavg();
	return $load[0];
 
}
function echo_memory_usage() { 
	$mem_usage = memory_get_usage(true);         
        if ($mem_usage < 1024) 
            return $mem_usage." bytes"; 
        elseif ($mem_usage < 1048576) 
            return round($mem_usage/1024,2)." kilobytes"; 
        else 
            return round($mem_usage/1048576,2)." megabytes";        
    } 
function imageDownloadCustom($nodes, $maxHeight = 0, $maxWidth = 0,$CLASS_CRAWLL) {
			echo "<b>imageDownloadCustom start ,1 Call Memory Usage: ".echo_memory_usage()."</b><br>";	
			global $benchTimer;
			$benchTimer->start();
			$benchTimer->setMarker('Marker 1 : imageDownloadCustom start');
			$mh = curl_multi_init (); // Create the multiple cURL handle
			$curl_array = array ();
			
			foreach ( $nodes as $i => $url ) {
			
				$curl_array [$i] = curl_init ( $url ); // add cURL resources until end of $nodes
				curl_setopt ( $curl_array [$i], CURLOPT_RETURNTRANSFER, true );
				curl_setopt ( $curl_array [$i], CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 (.NET CLR 3.5.30729)' );
				curl_setopt ( $curl_array [$i], CURLOPT_CONNECTTIMEOUT, 1 ); //5::: It's depend on a destination's staute(overload, crach...),1sec
				curl_setopt ( $curl_array [$i], CURLOPT_TIMEOUT, 2 ); //15::: Huge file, slow connection speeds or slow rendering witin 15sec
				curl_multi_add_handle ( $mh, $curl_array [$i] ); // add the handles until end of $nodes
			}
			$running = NULL;
			$benchTimer->setMarker('Marker 2 : curl_multi_add_handle');
			echo "<b>curl_multi_add_handle Marker 2, Call Memory Usage: ".echo_memory_usage()."-------".get_server_cpu_usage()."</b><br>";	
			//execute the handles
			do {
				//usleep (100); // 1/10000 second 
				curl_multi_exec ( $mh, $running );
				$benchTimer->setMarker('Marker special : curl_multi_exec');
			} while ( $running > 0 );			
			$benchTimer->setMarker('Marker 3 : curl_multi_exec');
			echo "<b>curl_multi_exec Marker 3, Call Memory Usage: ".echo_memory_usage()."-------".get_server_cpu_usage()."</b><br>";	
			$res = array ();
			foreach ( $nodes as $i => $url ) {
				$curlErrorCode = curl_errno ( $curl_array [$i] );

				if ($curlErrorCode === 0) {
					$info = curl_getinfo ( $curl_array [$i] );
					$ext = $CLASS_CRAWLL->getExtention ( $info ['content_type'] );
					if ($info ['content_type'] !== null && $ext  !== ".img") {
						$temp = "/www/revu39/public_html/images/crawll" ."/". md5 ( mt_rand () ) . $ext;
						touch ( $temp );
						$imageContent = curl_multi_getcontent ( $curl_array [$i] );
					
						if(!file_put_contents ( $temp, $imageContent )){
							echo "Error occured. Unable to generate a temporary folder on the local server - ".$temp;
						}

						if ($maxHeight == 0 || $maxWidth == 0) {
							$res [] = $temp;
						} else {
							$size = getimagesize ( $temp );
							if ($size [0] >= $maxHeight && $size [1] >= $maxWidth) {								
								$res [$i][] = $url;	
								$res [$i][] = $size [0];
								$res [$i][] = $size [1];	
								echo "URL : ".$url."Height : ".$size [0]."--- Width : ".$size[1]."<br>";	
								//unlink ( $temp );
							} else {
								//unlink ( $temp );
							}
							unlink ( $temp );
						}
					}
				}
				echo "<b>-->Before LOOP Before Remove curl_multi_getcontent Marker SPECIAL".$i.", Call Memory Usage: ".echo_memory_usage()."-------".get_server_cpu_usage()."</b><br>";	
				curl_multi_remove_handle ( $mh, $curl_array [$i] );
				curl_close ( $curl_array [$i] );
				echo "<b>-->After LOOP  Remove curl_multi_getcontent Marker SPECIAL".$i.", Call Memory Usage: ".echo_memory_usage()."-------".get_server_cpu_usage()."</b><br>";	
			}

			curl_multi_close ( $mh );
			$benchTimer->setMarker('Marker 4 : file_put_contents');
			echo "<b>curl_multi_exec Marker 4, Call Memory Usage: ".echo_memory_usage()."-------".get_server_cpu_usage()."</b><br>";	
			 reset($res);
			 sort($res); //값 정렬
			 echo "<b>END Marker 5, Call Memory Usage: ".echo_memory_usage()."-------".get_server_cpu_usage()."</b><br>";	
			 $benchTimer->stop();
			$benchTimer->display();
			return $res;
		}

function getCustomImgSize($nodes,$maxHeight = 0, $maxWidth = 0){
	$res = array ();
	foreach ( $nodes as $i => $url ) {
		
		list($width, $height) = @getimagesize($url); 
		if ($height >= $maxHeight && $width >= $maxWidth && extractFormat($url)) {		
			$res [$i][] = $url;	
			$res [$i][] = $width;
			$res [$i][] = $height;	
			echo "URL : ".$url."Width : ".$res[$i][1]."--- Height : ".$res[$i][2]."<br>";	;			
		}
	}
}

function extractFormat($userfile){
	$filename = substr($userfile,-5); // 뒤에서 5개 문자 뽑아옵니다.
	$fn = explode(".",$filename); // .(dot)으로 구분합니다.
	$file_name_ext = $fn[1]; // .(dot)으로 구분하여 뒤에 확장자를 뽑아옵니다.
	
	$type = strtolower ( $file_name_ext );

	if($type == "gif" || $type == "png" || $type == "jpg"|| $type == "img" ){
		return true;
	}else{
		return false;
	}

			
}


//$filedownUrl = array();
//$filedownUrl[0] = "http://img.wizwid.com/Wizwid/main/img/121126_Main_A_01.jpg";
$filedownUrl = Array ( 
0 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
1 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
2 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
3 => "http://img.wizwid.com/Wizwid/main/img/144_gnb_bsa31.jpg",
4 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_1.jpg",
5 => "http://img.wizwid.com/Wizwid/main/img/144_gnb_banner_men.jpg",
6 => "http://img.wizwid.com/Wizwid/main/img/121126_GNB_03.jpg", 
7 => "http://img.wizwid.com/Wizwid/main/img/121126_gnb_banner01.jpg",
8 =>"http://img.wizwid.com/Wizwid/main/img/121119_gnb_banner021.jpg", 
9 => "http://img.wizwid.com/Wizwid/main/img/categoryLayer_304_1211211.jpg", 
10 => "http://img.wizwid.com/Wizwid/main/img/121126_GNB_01.jpg",
11 => "http://img.wizwid.com/Wizwid/main/img/121126_GNB_02.jpg",
12 => "http://img.wizwid.com/Wizwid/@publish/@expression/img/@dummy/img_seasonal01.jpg", 
13 => "http://img.wizwid.com/Wizwid/@publish/@expression/img/@dummy/img_seasonal02.jpg", 
14 => "http://img.wizwid.com/Wizwid/@publish/@expression/img/@dummy/img_seasonal03.jpg", 
15 => "http://img.wizwid.com/Wizwid/main/img/@dummy-happyweek.jpg",
16 => "http://img.wizwid.com/Wizwid/main/img/card_sky_201211251.jpg", 
17 => "http://img.wizwid.com/PImg/701449/bsc/701449776i.jpg",
18 => "http://img.wizwid.com/Wizwid/2012/img/view/tit_prd_detailview.gif",
19 => "http://img.wizwid.com/Wizwid/2012/img/view/btn_close.gif",
20 => "http://www.wizwid.com//assets.pinterest.com/images/PinExt.png",
21 => "http://img.wizwid.com/Wizwid/2011/images/common/btn/20120716_tweet-button-original.jpg",
22 => "http://www.wizwid.com/", 
23 => "http://www.wizwid.com/",
24 => "http://www.wizwid.com/", 
25 => "http://img.wizwid.com/Wizwid/shop/img/aaa3.jpg",
26 => "http://img.wizwid.com/Wizwid/shop/img/dum-banner-credit-2112.jpg",
27 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_detailinfo_on.gif",
28 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodoption.gif", 
29 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodqna.gif", 
30 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodetc.gif", 
31 => "http://fandg.cafe24.com/NINA/nina_h.jpg",
32 => "http://fandg.cafe24.com/NINA/scarf/2FS135_D.jpg",
33 => "http://fandg.cafe24.com/NINA/배송안내.jpg",
34 => "http://img.wizwid.com/PImg/701435/bsc/701435415h.jpg",
35 => "http://img.wizwid.com/PImg/701437/bsc/701437962h.jpg",
36 => "http://img.wizwid.com/PImg/701448/bsc/701448859h.jpg",
37 => "http://img.wizwid.com/PImg/701445/bsc/701445577h.jpg",
38 => "http://img.wizwid.com/PImg/701445/bsc/701445560h.jpg", 
39 => "http://img.wizwid.com/Wizwid/2012/img/common/title-productGeneral.gif", 
40 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_detailinfo.gif", 
41 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodoption_on.gif",
42 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodqna.gif", 
43 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodetc.gif", 
44 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_prod_write_para2.gif",
45 => "http://img.wizwid.com/Wizwid/2009/images/common/btn/btn_write1.gif",
46 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_detailinfo.gif", 
47 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodoption.gif",
48 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodqna_on.gif", 
49 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodetc.gif",
50 => "http://img.wizwid.com/Wizwid/2009/images/common/btn/btn_request1.gif",
51 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_detailinfo.gif",
52 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodoption.gif",
53 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodqna.gif", 
54 => "http://img.wizwid.com/Wizwid/2009/images/shop/img_tab_prodetc_on.gif", 
55 => "http://img.wizwid.com/Wizwid/2012/img/footer/tit_mall01.gif", 
56 => "http://img.wizwid.com/Wizwid/2012/img/footer/tit_mall05.gif", 
57 => "http://img.wizwid.com/Wizwid/2012/img/footer/tit_mall03.gif",
58 => "http://img.wizwid.com/Wizwid/2012/img/footer/tit_mall02.gif", 
59 => "http://img.wizwid.com/Wizwid/2012/img/footer/tit_mall04.gif",
60 => "http://gtc2.acecounter.com:8080/?uid=AS2A37329850961&je=n&",
61 => "http://www.googleadservices.com/pagead/conversion/1003799185/?label=Z1PzCJfItwMQkYXT3gM&guid=ON&script=0",
62 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
63 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
64 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
65 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
66 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
67 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
68 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
69 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
70 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
71 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
72 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
73 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
74 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
75 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
76 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
77 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
78 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
79 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
80 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
81 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
82 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
83 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
84 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
84 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
86 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
87 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
88 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
89 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
90 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
91 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
92 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
93 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
94 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
95 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
96 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
97 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
98 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
99 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
100 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
101 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
102 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
103 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg",
104 => "http://img.wizwid.com/Wizwid/main/img/121125_144_bar_03-2.jpg",
105 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_2_03.jpg",
106 => "http://img.wizwid.com/Wizwid/main/img/121122_144bn_31.jpg"

); 
//1. get file on your server using file_get_contents or curl for temporary purpose. 2. get dimension getimagesize 3. delete the file alternative else you can also find some api 
//list($width, $height) = getimagesize("http://image.gsshop.com/image/10/34/10345013_N1.jpg"); 
//echo "$width x $height (px)"; 

$filedownNode = parse_data_domdocument($url);
// ->parse_data_simpledom 
// -> parse_data_domdocument 128
	$bench->run(1, 'imageDownloadCustom',$filedownNode,90,90,$CLASS_CRAWLL);
//	$bench->run(10, 'getCustomImgSize',$filedownUrl,90,90);
    /* Get the results */
    $result = $bench->get();
 
    /* Display the mean time the function 'someFunction'
       takes to execute */
    print_r($result);


echo "<h1>", microtime(true) - $start, "</h1>";
//
//	$content = file_get_data_htmldom($url);		
//
//    $dom = new DOMDocument;   	
//	$dom->loadHTML($content);
//    foreach ($dom->getElementsByTagName('img') as $node)
//    {
//        //$node->setAttribute('href', 'http://mysite.ru/' . $node->getAttribute('href'));
//		echo $node->getAttribute('href')."<br>";
//    }
//    $dom->formatOutput = true;
//
//    echo preg_replace('#^<!DOCTYPE.+?>#', '', str_replace( array('<html>', '</html>', '<body>', '</body>', "\n\n", '&lt;', '&gt;'), array('', '', '', '', '', '<', '>',), $dom->saveHTML()));
?>