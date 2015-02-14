<?php
class Crawll
{
	public function Crawll()
	{
		
		
	}
		
	public function startsWith($str, $prefix) {
			$temp = substr ( $str, 0, strlen ( $prefix ) );
			$temp = strtolower ( $temp );
			$prefix = strtolower ( $prefix );
			return ($temp == $prefix);
		}


	public 	function imageDownload($nodes, $maxHeight = 0, $maxWidth = 0) {
			$loofLimit = 0;
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
			$ch = curl_init();
			$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
			curl_setopt($ch,CURLOPT_USERAGENT, $userAgent);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE); 
			curl_setopt($ch, CURLOPT_COOKIEFILE, _DIR_TMP.'/cookies.txt');
			curl_setopt ($ch, CURLOPT_COOKIEJAR, _DIR_TMP.'/cookies.txt');
			curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 		
			curl_setopt($ch, CURLOPT_URL, $url);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
	}

}