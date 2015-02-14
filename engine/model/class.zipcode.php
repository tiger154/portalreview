<?php
class Zipcode
{
	public function Zipcode()
	{
	}
		
	public function getBcodeList($db)
	{
		$sql = "
		SELECT			bcode, ko_desc, en_desc, ch_desc 
		FROM			Rf_area_bcode
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getMcodeList($db, $bcode)
	{
		$sql = "
		SELECT			bcode, mcode, ko_desc, en_desc, ch_desc 
		FROM			Rf_area_mcode
		WHERE			bcode = '".$bcode."'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getScodeList($db, $bcode, $mcode)
	{
		$sql = "
		SELECT			bcode, mcode, scode, ko_desc, en_desc, ch_desc 
		FROM			Rf_area_scode
		WHERE			bcode = '".$bcode."'
		AND				mcode = '".$mcode."'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getZipcode($db, $type, $keyword) 
	{
		$sql = "
		SELECT			zipcode, addr 
		FROM			Rf_zipcode
		WHERE			".$type." LIKE '".$keyword."%'
		ORDER BY		zipcode
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;		
	}
}