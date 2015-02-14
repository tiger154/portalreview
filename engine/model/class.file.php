<?php
class File
{
	public function File()
	{
	}

	public function upload($file, $filename, $dir)
	{
		$_fileName = $file['name'];
		$_fileSize = $file['size'];
		$_fileType = $file['type'];
		$_fileTemp = $file['tmp_name'];
		$_uploadDir = $dir."/".$filename;
		$_result = true;
		$_maxSize = $this->getUploadMaxSize();

		if($_fileName) {
			if(!$_fileSize) {
				//print("파일이 없거나 파일 크기가 0KB입니다.");
				Module::alert("파일이 없거나 파일 크기가 0KB입니다.");
				return false;
			}
			if($_fileSize > $_maxSize) {
				//print($_maxSize."byte 이상의 파일(".$_fileName.")은 올릴 수 없습니다.");
				Module::alert($_maxSize."byte 이상의 파일(".$_fileName.")은 올릴 수 없습니다.");
				return false;
			}
			if($this->isRun($_fileName) == true) {
				//print("첨부한 파일의 확장자로 첨부할 수 없습니다.");
				Module::alert("첨부한 파일(".$_fileName.")의 확장자로 첨부할 수 없습니다.");
				return false;
			}
			if(!move_uploaded_file($_fileTemp, "$_uploadDir")) {
				//print("업로드가 실패하였습니다.");
				Module::alert("업로드가 실패하였습니다.");
				return false;
			} else {
				//@chmod($_uploadDir, 0777);
			}
		}
		return true;
	}

	public function download($filename1, $filename2, $dir)
	{
		$file = $dir."/".$filename2;
		if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0|MSIE 7.0|MSIE 8.0)", $_SERVER['HTTP_USER_AGENT'])) {
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.5")) {
				header("Content-Type: doesn/matter");
				header("Content-disposition: filename=$filename1");
				header("Content-Transfer-Encoding: binary");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.0")) {
				Header("Content-type: file/unknown");
				header("Content-Disposition: attachment; filename=$filename1");
				Header("Content-Description: PHP5 Generated Data");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.1")) {
				Header("Content-type: file/unknown");
				header("Content-Disposition: attachment; filename=$filename1");
				Header("Content-Description: PHP5 Generated Data");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0")) {
				Header("Content-type: application/x-msdownload");
				Header("Content-Length: ".(string)(filesize("$file")));
				Header("Content-Disposition: attachment; filename=$filename1");
				Header("Content-Description: PHP5 Generated Data");
				Header("Content-Transfer-Encoding: binary");
				Header("Pragma: no-cache");
				Header("Expires: 0");
			}
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0")) {
				Header("Content-type: application/x-msdownload");
				Header("Content-Length: ".(string)(filesize("$file")));
				Header("Content-Disposition: attachment; filename=$filename1");
				Header("Content-Description: PHP5 Generated Data");
				Header("Content-Transfer-Encoding: binary");
				Header("Pragma: no-cache");
				Header("Expires: 0");
			}

			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 8.0")) {
				Header("Content-type: application/x-msdownload");
				Header("Content-Length: ".(string)(filesize("$file")));
				Header("Content-Disposition: attachment; filename=$filename1");
				Header("Content-Description: PHP5 Generated Data");
				Header("Content-Transfer-Encoding: binary");
				Header("Pragma: no-cache");
				Header("Expires: 0");
			}
		} else {
			Header("Content-type: file/unknown");
			Header("Content-Length: ".(string)(filesize("$file")));
			Header("Content-Disposition: attachment; filename=$filename1");
			Header("Content-Description: PHP5 Generated Data");
			Header("Pragma: no-cache");
			Header("Expires: 0");
		}

		if(is_file("$file")) {
			$fp = fopen("$file", "rb");
			if (!fpassthru($fp)) {
				fclose($fp);
			}
			return true;
		} else {
			return false;
		}
	}

	public function download2($filename1, $filename2, $dir)
	{
		$file = $dir."/".$filename2;

		//echo "file:$file<br>";exit;
		if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0|MSIE 7.0|MSIE 8.0)", $_SERVER['HTTP_USER_AGENT'])) {
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.5")) {
				header("Content-Type: doesn/matter");
				header("Content-disposition: filename=$filename1");
				header("Content-Transfer-Encoding: binary");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.0")) {
				Header("Content-type: file/unknown");
				header("Content-Disposition: attachment; filename=$filename1");
				Header("Content-Description: PHP5 Generated Data");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.1")) {
				Header("Content-type: file/unknown");
				header("Content-Disposition: attachment; filename=$filename1");
				Header("Content-Description: PHP5 Generated Data");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0")) {
				Header("Content-type: application/x-msdownload");
				Header("Content-Length: ".(string)(filesize("$file")));
				Header("Content-Disposition: attachment; filename=$filename1");
				Header("Content-Description: PHP5 Generated Data");
				Header("Content-Transfer-Encoding: binary");
				Header("Pragma: no-cache");
				Header("Expires: 0");
			}
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0")) {
				Header("Content-type: application/x-msdownload");
				Header("Content-Length: ".(string)(filesize("$file")));
				Header("Content-Disposition: attachment; filename=$filename1");
				Header("Content-Description: PHP5 Generated Data");
				Header("Content-Transfer-Encoding: binary");
				Header("Pragma: no-cache");
				Header("Expires: 0");
			}

			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 8.0")) {
				Header("Content-type: application/x-msdownload");
				Header("Content-Length: ".(string)(filesize("$file")));
				Header("Content-Disposition: attachment; filename=$filename1");
				Header("Content-Description: PHP5 Generated Data");
				Header("Content-Transfer-Encoding: binary");
				Header("Pragma: no-cache");
				Header("Expires: 0");
			}
		} else {
			Header("Content-type: file/unknown");
			Header("Content-Length: ".(string)(filesize("$file")));
			Header("Content-Disposition: attachment; filename=$filename1");
			Header("Content-Description: PHP5 Generated Data");
			Header("Pragma: no-cache");
			Header("Expires: 0");
		}

		if(is_file("$file")) {
			$fp = fopen("$file", "rb");
			if (!fpassthru($fp)) {
				fclose($fp);
			}
			return true;
		} else {
			return false;
		}
	}

	public function getUploadMaxSize($type="upload_max_filesize")
	{
		$max = ini_get($type);
		$unit = array("KB", "M");
		$bsize = array("*1024", "*1024*1024");
		$str = str_replace($unit, $bsize, $max);
		$val = explode("*", $str);
		$size = 0;
		for($i=0; $i<sizeof($val); $i++) {
			$size = ($i == 0) ? 1*$val[$i] : $size*$val[$i];
		}
		return $size;
	} 

	public function delete($file)
	{
		if($this->isFile($file) == true) {
			@unlink($file);
			return true;
		} else {
			return false;
		}
	}

	public function changeFilename($filename1,$filename2)
	{
		$_extname = substr(strrchr($filename1,"."),1);
		$filename = $filename2.".".$_extname;
		return $filename;
	}

	public function changeExtname($filename1,$extname)
	{
		$_filename = substr($filename1, 0, strrchr($filename1,"."));
		$filename = $_filename.".".$extname;
		return $filename;
	}

	public function getFilename($filename1)
	{
		$filename = substr($filename1,0,strrpos($filename1,"."));
		return $filename;
	}

	public function getExtname($filename)
	{
		$extname = substr(strrchr($filename,"."),1);
		return $extname;
	}

	public function getExtnameByFile($file)
	{
		$_filemime = $this->getMimeContentType($file, $opt="mime");
		$extname = explode("/", "$_filemime");
		if($extname[1] == "jpeg") {
			$extname[1] = "jpg";
		}
		return $extname[1];
	}

	public function getThumbname($filename, $thumbname="_thumb")
	{
		$thumbname = $this->getFilename($filename).$thumbname.".".$this->getExtname($filename);
		return $thumbname;
	}

	public function getFilesize($file)
	{
		if($this->isFile($file) == true) {
			return filesize($file);
		} else {
			return 0;
		}
	}

	public function isFile($file)
	{
		if($file == "") {
			return false;
		} else {
			if(file_exists($file)) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function isImage($filename)
	{
		$_extname = $this->getExtname($filename);
		$_extname = strtolower($_extname);
		//$_extArr = array("jpg", "jpeg", "gif", "png", "pcx", "bmp");
		$_extArr = array("jpg", "jpeg", "gif", "png");
		if(in_array($_extname, $_extArr) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function isSWF($filename)
	{
		$_extname = $this->getExtname($filename);
		$_extname = strtolower($_extname);
		$_extArr = array("swf","flv","wmv");
		if(in_array($_extname, $_extArr) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function isIcon($filename)
	{
		$_extname = $this->getExtname($filename);
		$_extname = strtolower($_extname);
		$_extArr = array("ico");
		if(in_array($_extname, $_extArr) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function isRun($filename)
	{
		$_extname = $this->getExtname($filename);
		$_extname = strtolower($_extname);
		$_extArr = array("html", "htm", "php", "php3", "php4", "php5", "inc", "lib", "revu", "asp", "aspx", "jsp");
		if(in_array($_extname, $_extArr) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function isRunByMime($file, $opt="")
	{
		$mime = $this->getMimeContentType($file, "mime");
		$arr = array("text/x-c++");
		if(in_array($mime, $arr)) {
			return true;
		} else {
			return false;
		}
	}

	public function move($file1, $file2)
	{
		if($this->isFile($file1) == true && $this->isFile($file2) == false ) {
			exec("mv $file1 $file2");
			return true;
		} else {
			return false;
		}
	}

	public function copy($file1, $file2)
	{
		if($this->isFile($file1) == true) {
			exec("cp $file1 $file2");
			return true;
		} else {
			return false;
		}
	}

	public function read($file)
	{
		if($this->isFile($file) == true) {
			$fp = fopen($file, "r");
			$fileSize = filesize($file);
			if($fileSize > 0) $content = fread($fp,$fileSize);
			fclose($fp);
		} else {
			$content = "";
		}
		return $content;
	}

	public function write($file, $content)
	{
		$fp = fopen($file,"w");
		if(fwrite($fp, $content) == false) {
			return false;
		} else {
			fclose($fp);
			return true;
		}
	}

	public function readWrite($file, $content)
	{
		if($this->isFile($file) == true) {
			$fp = fopen($file,"w");
			if(fwrite($fp, $content) == false) {
				return false;
			}
			fclose($fp);
		}
		return true;
	}

	public function chmod($file, $perm)
	{
		@exec("chmod -R ".$perm." ".$file);
	}

	public function uploadImageFile($url, $savePath)
	{
		$file = fopen($url, "rb");
		if (!$file) {
			//echo "파일정보는 XX";
			return false;
		}else {
			//echo "파일정보는 있음";
			$filename = basename($url);
			$dest = fopen($savePath, "wb");
			while (!feof ($file)) {
				$line = fread ($file, 1028);
				fwrite($dest,$line);
			}
			fclose($dest);
			return true;
		}
	}

	// if (!function_exists('mime_content_type')) { 
	public function getMimeContentType($file, $opt="") {
		$file = escapeshellarg($file); 		
		$mInfo = trim(`file -bi $file`);
		$_mInfo = explode(";", $mInfo);
		switch($opt) {
			case "mime" :
				return $text = $_mInfo[0];
				break;
			case "charset" :
				return $text = trim($_mInfo[1]);
				break;
			default :
				return $text = $mInfo;
				break;
		}
		return $text;
	}

	public function filesize($file) {
		if($this->isFile($file) == true) {
			$size = filesize($file);
			return $size;
		} else {
			return false;
		}
	}
	
	
}
?>