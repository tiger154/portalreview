<?php
class Thumbnail
{
	public function Thumbnail()
	{
	}

	public function checkFile($file)
	{
		$img = getimagesize($file);
		if($img[2] == 1 || $img[2] == 2 || $img[2] == 3) {
			return true;
		} else {
			return false;
		}
	}

	public function create($file, $thumb, $width, $height)
	{
		$GD = gd_info();
		$version = substr(preg_replace("/[^0-9]/", "", $GD['GD Version']), 0, 1);
		if(!$version) {
			//return "GD가 설치 되어있지 않거나 버젼이 1 미만입니다.";
			return false;
		}

		$img = getimagesize($file);

		//if($img[2] != 1 && $img[2] != 2 && $img$thumb && $img[2] != 6) {
		if($img[2] != 1 && $img[2] != 2 && $img[2] != 3) {
			//return "확장자가 jp(e)g/png/gif 가 아닙니다.";
			return false;
		} else {
			if($img[2] == 1) {
				$cFile = imagecreatefromgif($file);
			} elseif($img[2] == 2) {
				$cFile = imagecreatefromjpeg($file);
			} elseif($img[2] == 3) {
				$cFile = imagecreatefrompng($file);
			} elseif($img[2] == 6) {
				$cFile = imagecreatefromwbmp($file);
			} else {
				$cFile = imagecreatefromgif($file);
			}
			if($version == 2) {
				$dest = imagecreatetruecolor($width, $height);
				imagecopyresampled($dest, $cFile, 0, 0, 0, 0, $width, $height, $img[0], $img[1]);
			} else {
				$dest = imagecreate($width, $height);
				imagecopyresized($dest, $cFile, 0, 0, 0, 0, $width, $height, $img[0], $img[1]);
			}
			if($img[2] == 1) {
				imagegif($dest, $thumb, 90);
			} elseif($img[2] == 2) {
				 imagejpeg($dest, $thumb, 90);
			} elseif($img[2] == 3) {
				imagepng($dest, $thumb, 9);
			} elseif($img[2] == 6) {
				image2wbmp($dest, $thumb, 90);
			} else {
				imagegif($dest, $thumb, 90);
			}
			imagedestroy($dest);
			return true;
		}
	}

	public function getThumbname($filename)
	{
		$_filename = substr($filename,0,strrpos($filename,"."));
		$_extname = substr(strrchr($filename,"."),1);
		if($_extname == "bmp") {
			$_extname = "gif";
		}
		$thumbname = $_filename."_thumb.".$_extname;
		return $thumbname;
	}
}
?>