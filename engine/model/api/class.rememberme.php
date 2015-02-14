<?php
class Rememberme
{

//	public $FFFuserID;	

	public function Rememberme()//__Constructor
	{
		Module::includeExtends("rememberme", "src/rememberme");	
		return true;
	}
	
	
}
?>