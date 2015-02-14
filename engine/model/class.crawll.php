<?php

class Crawll
{
  //@Const		
   public $searchTag = "//img"; // default tag[DOMDocument]
   public $searchTag_Simple = "img";  //default tag[SimpleHtml]
  
  /*@@Const Array
  * @ perforse : Define some values of each shopingMalls

  * @ Attribute of array description
         1) name : shoppingMall Name
		 2) view : ViewPageUnique TAG
		 3) tag : Search TAG of price
		 4) domain : DomainName of shoppingmall

  * @ Finished shoppingMalls : 
      1) wizwid | html | td,strong
	  2) gsshop | html | span, span
	  3) lotteimall | html | span, strong
	  4) hmall | html | <trendy>span,span,<default>s,span
  */
   public $shopingMall = array(
										0 => array(
												"name" => "wizwid",
												"view" => "AssortID",
												"tag" =>  "//img|//dl[@class='priceList']/dd",
												"domain" => "wizwid.com"
												),
										1 => array(
												"name" => "gsshop",		
												"view" => "prdid",
												"tag" =>  "//img|//span[@class='p1']|//span[@class='txtype1']",
												"domain" => "gsshop.com"
												),
										 2=> array(													
												"name" => "lotteimall",		
												"view" => "i_code",
												"tag" =>  "//img|//span[@class='oprice']/span| //span[@class='price']/strong",
												"domain" => "lotteimall.com"
												),
										 3=> array(													
												"name" => "hmall",		
												"view" => "ItemCode",
												"tag" =>  "//img|//span[@class='price_after']|//span[@class='moumprice']| //p[@class='view_contents_value_01_1']/strong/s| //p[class=view_contents_value_01_1]/strong/span",
												"domain" => "hyundaihmall.com"
												),
										  4=> array(													
												"name" => "auction",		
												"view" => "ItemNo",
												"tag" =>  "img, div[id=divSellPrice]",
												"domain" => "auction.co.kr"
											)
													
										 );
	
	public function Crawll()
	{

	}
	

	function get_links_curl($url) { 
	
    // Create a new DOM Document to hold our webpage structure 
    $xml = new DOMDocument(); 
  
    // Load the url's contents into the DOM 
    $returnF = file_get_data_htmldom($url); 
	@$xml->loadHTML($returnF); 

	return $xml;

    // Empty array to hold all links to return 
    $links = array(); 
  
    //Loop through each <a> tag in the dom and add it to the link array 
    foreach($xml->getElementsByTagName('img') as $link) { 
        $links[] = array('url' => $link->getAttribute('src'), 'text' => $link->nodeValue); 
    } 
  
    //Return the links 
    return $links; 
} 


	/*
	 @ name : getSearchTxt
	 @ discript : By url, extract tag which will be used for search tag
	 @ version : wizwid(finished)
	*/
	public function getSearchTxt($fullUrl,$domain){   
		
	   for ($i=0; $i< count($this->shopingMall); $i++){			  
			if(preg_match("/".$this->shopingMall[$i]["view"]."/i",$fullUrl) && preg_match("/".$this->shopingMall[$i]["domain"]."/i",$domain) && $this->shopingMall[$i]["view"] != NULL){
				$this->searchTag = $this->shopingMall[$i]["tag"];		
				
			}			
	   }
	
	  return $this->searchTag;
//		if(preg_match("/".$this->wizwidView."/i",$url)){
//			$searchTxt = $this->wizwidSearchTxt; // Type is WIZWIWD 할인가
//		}else{
//			$searchTxt = "img";
//		}		
	}
		
	/*
	 @ name : getPrices
	 @ discript : By url and tag role, extract Price which will be used for search tag
	 @ version : wizwid(finished)
	*/
	public function getPrices($element,$url){		
		if(preg_match("/".$this->shopingMall[0]["view"]."/i",$url)){			
			if($element->tagName == "dd" ){ // WIZWID SHOPINGMALL 
				$nodes_price = $element->nodeValue;				
			}
		}else if(preg_match("/".$this->shopingMall[1]["view"]."/i",$url)){
			if($element->tagName == "span"){ // GS SHOP SHOPINGMALL 
				$nodes_price = $element->nodeValue;				
			}		
		}else if(preg_match("/".$this->shopingMall[2]["view"]."/i",$url)){
			if($element->tagName == "span" || $element->tagName == "strong"){ // Lotte SHOPINGMALL 
				$nodes_price = $element->nodeValue;				
			}
		}else if(preg_match("/".$this->shopingMall[3]["view"]."/i",$url)){
			
			if($element->tagName == "span" || $element->tagName == "s"){ // Hmall SHOPINGMALL 			
				$nodes_price = $element->nodeValue;				
			}
		}else if(preg_match("/".$this->shopingMall[4]["view"]."/i",$url)){			
			if($element->tag == "div"){ // Auction SHOPINGMALL		
				
				$nodes_price = $element->nodeValue;				
			}
		}else{
			return false;
		}
		
		return $nodes_price;
	}


	public function startsWith($str, $prefix) {
			$temp = substr ( $str, 0, strlen ( $prefix ) );
			$temp = strtolower ( $temp );
			$prefix = strtolower ( $prefix );
			return ($temp == $prefix);
		}


	public 	function imageDownload($nodes, $maxHeight = 0, $maxWidth = 0) {

			$mh = curl_multi_init (); // Create the multiple cURL handle
			$curl_array = array ();
			foreach ( $nodes as $i => $url ) {
				$curl_array [$i] = curl_init ( $url ); // add cURL resources until end of $nodes
				curl_setopt ( $curl_array [$i], CURLOPT_RETURNTRANSFER, true );
				curl_setopt ( $curl_array [$i], CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 (.NET CLR 3.5.30729)' );
				curl_setopt ( $curl_array [$i], CURLOPT_CONNECTTIMEOUT, 5 );
				curl_setopt ( $curl_array [$i], CURLOPT_TIMEOUT, 15 );
				curl_multi_add_handle ( $mh, $curl_array [$i] ); // add the handles until end of $nodes
			}
			$running = NULL;

			//execute the handles
			do {
				usleep ( 10000 ); // 1/100 second 
				curl_multi_exec ( $mh, $running );
			} while ( $running > 0 );

			$res = array ();
			foreach ( $nodes as $i => $url ) {
				$curlErrorCode = curl_errno ( $curl_array [$i] );

				if ($curlErrorCode === 0) {
					$info = curl_getinfo ( $curl_array [$i] );
					$ext = $this->getExtention ( $info ['content_type'] );
					if ($info ['content_type'] !== null && $ext  !== ".img") {
						$temp = _DIR_CRAWLL ."/". md5 ( mt_rand () ) . $ext;
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
								//unlink ( $temp );
							} else {
								//unlink ( $temp );
							}
							unlink ( $temp );
						}
					}
				}

				curl_multi_remove_handle ( $mh, $curl_array [$i] );
				curl_close ( $curl_array [$i] );

			}

			curl_multi_close ( $mh );

			 reset($res);
			 sort($res); //값 정렬
			return $res;
		}

	public function getExtention($type) {
			$type = strtolower ( $type );
			switch ($type) {
				case "image/gif" :
					return ".gif";
					break;
				case "image/png" :
					return ".png";
					break;

				case "image/jpeg" :
					return ".jpg";
					break;

				default :
					return ".img";
					break;
			}
	}

	function file_get_data($url) {

//			//create array of data to be posted
//				 $post_data['email'] = 'junhwen@naver.com';
//				 $post_data['pass'] = 'lion1403';
////			 //traverse array and prepare data for posting 
//				 foreach ( $post_data as $key => $value) {
//				  $post_items[] = $key . '=' . $value;
//				 }
////			//create the final string to be posted using implode()
//				 $post_string = implode ('&', $post_items);

			$ch = curl_init();
			//$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
			//$userAgent = 'scraper/1 (junhwen@naver.com)';
			$userAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
			curl_setopt($ch,CURLOPT_USERAGENT, $userAgent);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE); 
			curl_setopt($ch, CURLOPT_COOKIEFILE, _DIR_TMP.'/cookies.txt');
			curl_setopt ($ch, CURLOPT_COOKIEJAR, _DIR_TMP.'/cookies.txt');
			curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 	
//			curl_setopt ( $ch, CURLOPT_POST, 1 ); // facebook only 
//			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );// facebook only
//			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
			curl_setopt($ch, CURLOPT_URL, $url);

			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
	}

}
