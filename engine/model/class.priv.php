<?php
class Priv
{
	var $XMLParser;

	public function Priv()
	{		
	}

	public function isPriv($moduleName, $todoName, $session, $xml="")
	{		
		if(empty($xml)) $xml = "priv.module.xml";
		$result = false;
		$_src = _DIR_CONF."/".$xml;
		if(!file_exists($_src)) {
			Module::msg("1001", $xml." 파일을 확인하세요.");
		}
		$userGrade = (is_array($session)) ? $session['grade'] : "0";
		if($session['adminid'] != "") $userGrade = "9";
		if($moduleName != "") {
			$this->XMLParser = &Module::singletonExtends("XMLParser");
			$this->XMLParser = new XMLParser(file_get_contents($_src));
			$this->XMLParser->Parse();
			if(sizeof($this->XMLParser->document->modules[0]->module) > 0) {
				foreach($this->XMLParser->document->modules[0]->module as $module)
				{
					if(sizeof($module->todo) < 1) {
						if($module->tagAttrs['mname'] == $moduleName) {
							$grade = $module->tagAttrs['grade'];
							$msg = $module->tagAttrs['msg'];
							$redirect = $module->tagAttrs['redirect'];
							$param = $module->tagAttrs['param'];
							$popup = $module->tagAttrs['popup'];
							if(intval($userGrade) < intval($grade)) {
								$result = true;
							} else {
							}
							break;
						}
					} else {
						for($i=0;$i<sizeof($module->todo);$i++)
						{
							$todo = $module->todo[$i];
							if(($module->tagAttrs['mname'] == $moduleName) && ($todo->tagAttrs['tname'] == $todoName)) {
								$grade = $todo->tagAttrs['grade'];
								$msg = $todo->tagAttrs['msg'];
								$redirect = $todo->tagAttrs['redirect'];
								$param = $todo->tagAttrs['param'];
								$popup = $todo->tagAttrs['popup'];
								if(intval($userGrade) < intval($grade)) {
									$result = true;
								} else {
								}
								$flag = "1";
								break;
							}
						}
						if($flag != "1") {
							if($module->tagAttrs['mname'] == $moduleName) {
							
								$grade = $module->tagAttrs['grade'];
								$msg = $module->tagAttrs['msg'];
								$redirect = $module->tagAttrs['redirect'];
								$param = $module->tagAttrs['param'];
								$popup = $module->tagAttrs['popup'];
								if(intval($userGrade) < intval($grade)) {
									$result = true;
								} else {
								}
								break;
							}
						}
					}
				}
			}
		}		
		if($result == true) {
			switch($popup)
			{
				case "1" :
					Module::close($msg);
					Module::exitModule();
					break;
				case "0" :
				default :
					Module::alert($msg);
					Module::redirect($redirect);
					break;

			}
		} else {
		}
	}
}
?>