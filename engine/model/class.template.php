<?php
class Template extends Template_
{
	var $compile_check		= _TPL_COMPILE_CHECK;
	var $compile_dir		= _TPL_COMPILE_DIR;
	var $compile_ext		= _TPL_COMPILE_EXT;
	var $skin				= _TPL_SKIN;
	var $template_dir		= _TPL_TEMPLATE_DIR;
	var $prefilter			= _TPL_PREFILTER;
	var $argArr				= array();

	public function Template()
	{
		Template_::setVar("compile_check", $this->compile_check);
		Template_::setVar("compile_dir", $this->compile_dir);
		Template_::setVar("compile_ext", $this->compile_ext);
		Template_::setVar("skin", $this->skin);
		Template_::setVar("template_dir", $this->template_dir);
		Template_::setVar("prefilter", $this->prefilter);
	}

	public function defineTemplate($tplID="frame", $src, $fileName="_frame.htm")
	{
		//Template_::define($tplID, $src."/".$fileName);
		$this->define($tplID, $src."/".$fileName);
	}

	public function setValue($value)
	{
		//print_r($value);
		$tmpArr = array_merge($this->argArr, $value);
		unset($this->argArr);
		$this->argArr = $tmpArr;
	}

	public function assignValue()
	{
		Template_::assign($this->argArr);
	}
}
?>