<?php
class Base
{
	public function Base()
	{
	}
	public function cnt($db, $table, $field, $whereField, $whereValue)
	{
		$sql = "
		SELECT		COUNT($field) as cnt
		FROM		$table
		WHERE		$whereField = '$whereValue'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}
	public function row($db, $table, $field="*", $whereField, $whereValue)
	{
		$sql = "
		SELECT		$field
		FROM		$table
		WHERE		$whereField = '$whereValue'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	public function update($db, $table, $field, $fieldValue, $whereField, $whereValue)
	{
		$sql = "
		UPDATE		$table
		SET			$field = '$fieldValue'
		WHERE		$whereField = '$whereValue'
		";
		//echo $sql;
		$db->query($sql);
		return $db->result;
	}
	public function insert($db, $table, $Arr)
	{
		$_sql = "";
		$field = array();
		if(is_array($Arr)) {
			foreach($Arr as $key => $val) {
				if(is_string($val)) {
					$field[] = $key."='".$val."'";
				} else {
					$field[] = $key."=".$val."";
				}
			}
		}
		$_sql .= implode(",", $field);
		$sql = "
		INSERT INTO	$table
		SET			".$_sql."
		";
		//echo $sql;
		$db->query($sql);
		return $db->result;
	}
	public function getMysqlVariables($var)
	{
		$conf = Module::loadConf(_DIR_CONF."/db.mysql.ini", true);
		$master = $conf['MASTER'];
		$db = mysql_connect($master['HOST'], $master['ID'], $master['PASSWD']);
		$connect = mysql_select_db('mysql', $db);
		$res = mysql_query("SHOW variables LIKE '%".$var."%'");
		return mysql_fetch_array($res);
	}
	public function insertCronLog($db, $cron_name, $cron_src, $content)
	{
		$logArr = array();
		$logArr['cron_name'] = strval($cron_name);
		$logArr['cron_src'] = strval($cron_src);
		$logArr['content'] = strval($content);
		$logArr['regtime'] = time();
		$logArr['regdate'] = strval(date("Y-m-d H:i:s"));
		return $this->insert($db, "Rl_cron", $logArr);
	}
	public function strLimit($str, $maxlen, $eStr="...")
	{
		if(strlen($str)<=$maxlen) {
			return $str;
		}
		$effective_max = $maxlen - 3;
		$remained_byte = $effective_max;
		$retStr="";
		$hanStart=0;

		for ($i=0;$i<$effective_max;$i++) {
			$char=substr($str,$i,1);
			if (ord($char)<=127) {
				$retStr .= $char;
				$remained_byte--;
				continue;
			}
			if (!$hanStart&&$remained_byte>1) {
				$hanStart = true;
				$retStr .= $char;
				$remained_byte--;
				continue;
			}
			if ($hanStart) {
				$hanStart = false;
				$retStr .= $char;
				$remained_byte--;
			}
		}
		return $retStr .= $retStr.$eStr;
	}

	// 한글+숫자만 추출
	public function stripScpecial($str) 
	{
		// * Hangul Compatibility Jamo	-> U+3130	U+318F (94)
		// * Hangul Syllables -> U+AC00	U+D7AF (2)
		// * Hangul Jamo ->  U+1100	U+11FF (256)
		$pattern = '/[^\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}0-9a-zA-Z]+/u';
		$_str = preg_replace($pattern, "", $str);
		return $_str;
	}
   //Distributed Management Social Network Service API(DMS-API)
	public function strLimitUTF($str, $maxlen, $checkmb=false, $eStr='...')	
	{		
		preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
		$m    = $match[0];
		$slen = strlen($str);  // length of source string
		$tlen = strlen($eStr); // length of tail string
		$mlen = count($m); // length of matched characters	 
		if ($slen <= $maxlen) return $str;
		if (!$checkmb && $mlen <= $maxlen) return $str;	 
		$ret   = array();
		$count = 0;	 
		for ($i=0; $i < $maxlen; $i++) {
			$count += ($checkmb && strlen($m[$i]) > 1)?2:1;	 
			if ($count + $tlen > $maxlen) break;
			$ret[] = $m[$i];
		}
		return join('', $ret).$eStr;
	}
	
	function utf8_strcut( $str, $size )
	{
			$substr = substr( $str, 0, $size * 2 );
			$multi_size = preg_match_all( '/[\\x80-\\xff]/', $substr, $multi_chars );

			if ( $multi_size > 0 )
				$size = $size + intval( $multi_size / 3 ) - 1;

			if ( strlen( $str ) > $size )
			{
				$str = substr( $str, 0, $size );
				$str = preg_replace( '/(([\\x80-\\xff]{3})*?)([\\x80-\\xff]{0,2})$/', '$1', $str );
				$str .= '...';
			}

			return $str;
	}


	public function isHan($str) {
		if(preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $str)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function transDate($date, $type)
	{		
		$y = substr($date, 0,4);
		$m = substr($date, 5,2);
		$d = substr($date, 8,2);
		$h = substr($date, 11,2);
		$i = substr($date, 14,2);
		$s = substr($date, 17,2);
		$retDate = "";

		switch($type)
		{
			case "A" :
				$retDate = $y."년".$m."월".$d."일 ".$h."시".$i."분".$s."초";
				break;
			case "B" :
				$retDate = $y.".".$m.".".$d." ".$h.":".$i.":".$s;
				break;
			case "C" :
				$retDate = $y."-".$m."-".$d." ".$h.":".$i.":".$s;
				break;
			case "D" :
				$retDate = $y."년".$m."월".$d."일";
				break;
			case "E" :
				$retDate = $y.".".$m.".".$d;
				break;
			case "F" :
				$retDate = $y."-".$m."-".$d;
				break;
			default :
				$retDate = $date;
				break;
		}
		return $retDate;
	}
	
	public function transPrice($price)
	{
		$numArr = array("","일","이","삼","사","오","육","칠","팔","구");
		$unitArr = array("","십","백","천","만","십만","백만","천만","억","십억","백억","천억","조","십조","백조");
		$length = strlen($price);	
		$num = $length;
		$str = array();
		$priceText = "";
		
		for($i=0; $i<=$length; $i++) {
			$str[$i] = substr($price, $i, 1);
		}
		
		for($i=0; $i<=$length; $i++) {
			$num = $num - 1;
			if($numArr[$str[$i]] == "") {
				$unitArr[$num] = "";
			}
			if($code > 4) {
				$two = $i + 1;
				if($numArr[$str[$two]] != "") {
					$unitArr[$num] = substr($unitArr[$num],0,2);
				}
			}
			$priceText = $numArr[$str[$i]].$unitArr[$num];
		}
		return $priceText;
	}
	
	public function getDayByWeek($year="", $weeks="", $sp="-")
	{
		$date = array();
		$year = ($year == "") ? date("Y") : $year;
		$weeks = ($weeks == "") ? date("W") : $weeks;
		$week = strftime("%w", mktime(0, 0, 0, 1, 1, $year));
		// or $week = date("w",mktime(0, 0, 0, 1, 1, $year));	
		$days = ($weeks * 7) + (7 - $week);		
		for($mon=1; $mon<12; $mon++)
		{
			if($days > date("t",mktime(0, 0, 0, $mon, 1, $year))) {
				$days -= date("t",mktime(0, 0, 0, $mon, 1, $year));
			} else {
				break;
			}
		}
		$sd = $days - 6;		
		if( $mon == 1 && $sd < 1 ) $sd = 1;
		if( $mon == 12 && $days > 31 ) $days = 31;	
		$date[] = date("Y".$sp."m".$sp."d", mktime(0, 0, 0, $mon, $sd, $year));
		$date[] = date("Y".$sp."m".$sp."d", mktime(0, 0, 0, $mon, $days, $year));
		return $date;
	}

	public function getImage($fileName, $width="", $height="", $alt="")
	{
		if(!empty($fileName) && $fileName != "") {
			$_width = (!empty($width) && $width != "") ? "width='".$width."'" : "";
			$_height = (!empty($height) && $height != "") ? "height='".$height."'" : "";
			$_alt = (!empty($alt) && $alt != "") ? "alt='".$alt."'" : " ";
			$img = "<img src=\"".$fileName."\" ".$_width." ".$_height." ".$_alt." />";
		}
		return $img;
	}

	public function getGenderBySN($SN)
	{
		$firstNum = "";
		$gender = "";
		if(substr_count($SN, "-") > 0) {
			$_SN = explode("-", $SN);
			$firstNum = substr($_SN[1],0,1);
		} else {
			$firstNum = substr($SN,6,1);
		}
		if($firstNum%2 == 0) {
			$gender = "F";
		} else {
			$gender = "M";
		}
		return $gender;
	}

	public function getUnescape($str) 
	{
		return rawurldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', create_function('$str', 'return iconv(\'UTF-16LE\', \'UTF-8\', chr(hexdec(substr($str[1], 2, 2))).chr(hexdec(substr($str[1], 0, 2))));'), $str));
	}

		/* ROOT URL 만 추출*/
	public function extractURL($url){
		$regExp = "^([a-z://]*[^/?]*)([^$]*)";	
		ereg($regExp,$url,$result);
		return $result;
	}
	
}
?>