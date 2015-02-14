<?php

class Dir
{
	public function Dir()
	{
	}

	public function isDir($dir)
	{
		if(is_dir($dir)) {
			return true;
		} else {
			return false;
		}
	}

	public function makeDir($dir, $mod=0777)
	{
		if($this->isDir($dir)==false)
		{
			if(!@mkdir($dir,$mod)) {
				Module::msg("5001", "디렉토리 생성 실패[권한 $mod]=>$dir");
				return false;
			}
			// 디렉토리 권한변경
			@chmod($dir,$mod);
			return true;
		} else {
			//Module::alert(" $dir 디렉토리가 존재합니다.");
			return false;
		}
	}

	public function removeDir($dir)
	{
		if($this->isDir($dir)==true) {
			if($this->isExistFile($dir)==true) {
				//Module::alert("$dir 디렉토리에 파일이 존재하여 삭제를 할 수 없습니다.");
				return false;
			} else {
				if(!rmdir($dir)) {
					//Module::alert("$dir 이미지 디렉토리 삭제에 실패하였습니다.");
					return false;
				}
			}
		} else {
			//Module::alert("$dir 디렉토리가 존재하지 않습니다.");
			return false;
		}
		return true;
	}

	public function isExistFile($dir)
	{
		$dirCnt = 0;
		if($this->isDir($dir)==true) 	{
			if($dh=opendir($dir)) {
				while(($file = readdir($dh)) !== false)
				{
					if($file != '.' && $file != '..') {
						$dirCnt = $dirCnt + 1;
					}
				}
				closedir($dh);
			}
		}
		if($dirCnt>0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteExistFile($dir)
	{
		if($this->isDir($dir)==true) 	{
			if($dh=opendir($dir)) {
				while(($file = readdir($dh)) !== false)
				{
					if($file != '.' && $file != '..') {
						unlink($dir."/".$file);
					}
				}
				closedir($dh);
				return true;
			}
		}
	}

	public function viewFile($dir)
	{
		print "<p>디렉토리</p>";
		if($this->isDir($dir)==true) 	{
			if($dh=opendir($dir)) {
				while(($file = readdir($dh)) !== false)
				{
					if($file != '.' && $file != '..') {
						print "$file";
						print "<br />";
					}
				}
				closedir($dh);
			}
		}
    }

	public function getFile($dir)
	{
		$filearray = array();
		if($this->isDir($dir)==true) 	{
			if($dh=opendir($dir)) {
				while(($file = readdir($dh)) !== false)
				{
					if($file != '.' && $file != '..') {
						$filearray[] = $file;
					}
				}
				closedir($dh);
				return $filearray;
			}
		}
    }

	public function moveDir($dir1, $dir2)
	{
		if($this->isDir($dir1) == true && $this->isDir($dir2) == false) {
			exec("mv $dir1 $dir2");
			return true;
		} else {
			return false;
		}
    }

	public function copyDir($dir1, $dir2)
	{
		if($this->isDir($dir1) == true && $this->isDir($dir2) == false) {
			exec("cp -rp $dir1 $dir2");
			return true;
		} else {
			return false;
		}
	}
}
?>