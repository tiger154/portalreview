<?php
/***************************************************************************************
 * 이벤트 컨트롤러
 ***************************************************************************************/ 



/**
 * TODO
 */
switch(Module::$todo)
{	
	/**
	 * 실시간 리뷰카운트
	 */
	case "akc.load.proc" :	
		
			//require(_DIR_EXTENDS."/php.Search_Conan/DOCRUZER.php");
			require(_DIR_EXTENDS."/php.Search_Conan/akc.php");

				
		break;

	/**
	 * 디폴트
	 */
	default :
		Module::alert("잘못된 경로입니다.");
		//Module::redirectModule("index", $param="");
		break;

}


Module::exitModule();
?>
