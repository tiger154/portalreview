<?php
class Authname extends Auth
{
	public function Authname()
	{
	}

	public function getResultText($result)
	{
		$text = "";
		switch($result)
		{
			case "1" : // 일치함
				$text .= "실명인증이 완료 되었습니다.";
				break;	
			case "2" : // 불일치
				$text .= "요청한 주민등록번호와 실명이 잘못되었습니다.";
				break;	
			case "3" : // 없음
				$text .= "실명확인 데이터베이스 미등록입니다.";
				break;	
			case "4" : // 오류
				$text .= "주민등록번호가 잘못되었습니다.";
				break;	
			case "5" : // 에러
				$text .= "SYSTEM 장애가 발생하였습니다.";
				break;	
			case "7" : // 명의도용방지
				$text .= "명의도용방지가 설정되어 있습니다.";
				break;
			case "10" : // 내부에러코드 주민등록번호 업데이트 실패
				$text .= "회원 실명확인이 실패하였습니다.";
				break;
			default :
				$text .= "잘못된 경로입니다.";
				break;
		}
		return $text;
	}

	//해당 주민번호 사용자 있는지 여부 체크 
	public function getCountJumin($db, $jumin) 
	{
		$sql = "
		SELECT count(idx) as count 
		FROM _member
		WHERE jumin='$jumin'
		AND state = '0'
		";
		$row=$db->fetch($sql,true);
		if($row['count'] > 0){
			return false;
		}else{
			return true;
		}
	}
}
?>