<?php
/*
 * Created on 2009. 09. 07
 *
 * 서버와 crx로 통신하기 위한 클라이언트 API
 *
 * @version 1.1.0
 * @author 신동호, 박용기
 */

// helpers
// write data to ByteArrayOutputStream

function BA_writeByte(&$out, $num)
{
	$b = " ";
	$b = substr_replace($b, chr($num&0x000000ff), 0, 1);
	$out = $out . $b;
}
function BA_writeShort(&$out, $num)
{
	$b = " ";
	short2bytes( $num, $b, 0 );
	$out = $out . $b;
}
function BA_writeInteger(&$out, $num)
{
	$b = " ";
	int2bytes( $num, $b, 0 );
	$out = $out . $b;
}
function BA_writeLong(&$out, $num)
{
	$b = " ";
	long2bytes( $num, $b, 0 );
	$out = $out . $b;
}
function BA_writeString(&$out, $s)
{
	$out = $out . $s;
	$out = $out . "\0";
}
function BA_writeNString(&$out, $s, $len)
{
	//$out = $out . $s;
	$str = substr($s, 0, $len);
	$str_len = strlen($str);

	if ($str_len < $len) {
		for($i=$str_len; $i<$len; $i++) {
			$str = $str . "\0";
		}
	}
	$out = $out . $str;
}
function BA_writeNull(&$out)
{
	$out[strlen($out)] = NULL;
}
function BA_writeAlignSize( &$out )
{
	$offset = strlen($out);
	
	//return (($offset-1) & 0xfffffff8) + 8 - $offset;
	$tmp0 = (($offset-1)>>24) & 0xff;
	$tmp1 = (($offset-1)>>16) & 0xff;
	$tmp2 = (($offset-1)>>8) & 0xff;
	$tmp3 = ($offset-1) & 0xf8;
	
	$align_size =  (($tmp0<<24) | ($tmp1<<16) | ($tmp2<<8) | $tmp3) + 8 - $offset;
	
	for($i=0; $i < $align_size; $i++){
		BA_writeNull($out);
	}
}


function short2bytes( $num, &$b, $offset )
{
	//printf("num:%d(%d,%d,%d,%d)", $num, $num>>24, $num>>16, $num>>8, $num);
	$tmp0 = $num>>8;
	$tmp1 = $num;
	$b = substr_replace($b, chr($tmp0&0x000000ff), $offset+0, 1);
	$b = substr_replace($b, chr($tmp1&0x000000ff), $offset+1, 1);
	//printf("(%d,%d,%d,%d)\n", $tmp0&0x000000ff, $tmp1&0x000000ff, $tmp2&0x000000ff, $tmp3&0x000000ff);
}
function int2bytes( $num, &$b, $offset )
{
	//printf("num:%d(%d,%d,%d,%d)", $num, $num>>24, $num>>16, $num>>8, $num);
	$tmp0 = $num>>24;
	$tmp1 = $num>>16;
	$tmp2 = $num>>8;
	$tmp3 = $num;
	$b = substr_replace($b, chr($tmp0&0x000000ff), $offset+0, 1);
	$b = substr_replace($b, chr($tmp1&0x000000ff), $offset+1, 1);
	$b = substr_replace($b, chr($tmp2&0x000000ff), $offset+2, 1);
	$b = substr_replace($b, chr($tmp3&0x000000ff), $offset+3, 1);
	//printf("(%d,%d,%d,%d)\n", $tmp0&0x000000ff, $tmp1&0x000000ff, $tmp2&0x000000ff, $tmp3&0x000000ff);
}
function long2bytes( $num, &$b, $offset )
{
	//printf("num:%d(%d,%d,%d,%d)", $num, $num>>24, $num>>16, $num>>8, $num);
	$tmp0 = $num>>24;
	$tmp1 = $num>>16;
	$tmp2 = $num>>8;
	$tmp3 = $num;
	$b = substr_replace($b, chr(0), $offset+0, 1);
	$b = substr_replace($b, chr(0), $offset+1, 1);
	$b = substr_replace($b, chr(0), $offset+2, 1);
	$b = substr_replace($b, chr(0), $offset+3, 1);
	$b = substr_replace($b, chr($tmp0&0x000000ff), $offset+4, 1);
	$b = substr_replace($b, chr($tmp1&0x000000ff), $offset+5, 1);
	$b = substr_replace($b, chr($tmp2&0x000000ff), $offset+6, 1);
	$b = substr_replace($b, chr($tmp3&0x000000ff), $offset+7, 1);
	//printf("(%d,%d,%d,%d)\n", $tmp0&0x000000ff, $tmp1&0x000000ff, $tmp2&0x000000ff, $tmp3&0x000000ff);
}


function bytes2str( $b, $offset, $maxlen )
{
	$pos = strpos($b, "\0", $offset);
	if($pos===false) {
		$pos = $maxlen;
	}

	return $pos-$offset;
}
function bytes2byte( $b, $offset )
{
	return
		(((int)ord($b[$offset]))&0xff);
}
function bytes2short( $b, $offset )
{
	return
		((((int)ord($b[$offset+0]))&0xff)<<8) +
		(((int)ord($b[$offset+1]))&0xff);
}
function bytes2int( $b, $offset )
{
	return
		((((int)ord($b[$offset+0]))&0xff)<<24) +
		((((int)ord($b[$offset+1]))&0xff)<<16) +
		((((int)ord($b[$offset+2]))&0xff)<<8) +
		(((int)ord($b[$offset+3]))&0xff);
}
function bytes2long( $b, $offset )
{
	return
		((((int)ord($b[$offset+0]))&0xff)<<56) +
		((((int)ord($b[$offset+1]))&0xff)<<48) +
		((((int)ord($b[$offset+2]))&0xff)<<40) +
		((((int)ord($b[$offset+3]))&0xff)<<32) +
		((((int)ord($b[$offset+4]))&0xff)<<24) +
		((((int)ord($b[$offset+5]))&0xff)<<16) +
		((((int)ord($b[$offset+6]))&0xff)<<8) +
		(((int)ord($b[$offset+7]))&0xff);
}

function alignWordSize( $offset )
{
	//return (($offset-1) & 0xfffffff8) + 8 - $offset;
	$tmp0 = (($offset-1)>>24) & 0xff;
	$tmp1 = (($offset-1)>>16) & 0xff;
	$tmp2 = (($offset-1)>>8) & 0xff;
	$tmp3 = ($offset-1) & 0xf8;
	return (($tmp0<<24) | ($tmp1<<16) | ($tmp2<<8) | $tmp3) + 8 - $offset;
}
function my_xor( $val )
{
	if($val>=0)
	{
		$tmp0 = (($val & 0xFF000000)>>24) ^ g_xor_key0;
		$tmp1 = (($val & 0x00FF0000)>>16) ^ g_xor_key1;
		$tmp2 = (($val & 0x0000FF00)>>8) ^ g_xor_key2;
		$tmp3 = ($val & 0x000000FF) ^ g_xor_key3;

		return $tmp0<<24 | $tmp1<<16 | $tmp2<<8 | $tmp3;
	}
	else
	{
		$tmp0 = (256+($val>>24)) ^ g_xor_key0;
		$tmp1 = (($val&0x00FF0000)>>16) ^ g_xor_key1;
		$tmp2 = (($val&0x0000FF00)>>8) ^ g_xor_key2;
		$tmp3 = ($val&0x000000FF) ^ g_xor_key3;
		return $tmp0<<24 | $tmp1<<16 | $tmp2<<8 | $tmp3;
	}
}
function my_Parse($serviceAddr, &$saddr, &$port)
{
	$pos = strpos($serviceAddr, ":");
	if($pos===false)
	{
		return FALSE;
	}

	if($pos==0 || $pos+1==strlen($serviceAddr))
	{
		return FALSE;
	}
	$substr1 = substr($serviceAddr, 0, $pos);
	$substr2 = substr($serviceAddr, $pos+1, strlen($serviceAddr));
	$saddr = $substr1;
	$port = $substr2;
	return TRUE;
}
function IS_WHITE_SPACE( $ch )
{
	return ($ch==" "||$ch=="\t"||$ch=="\r"||$ch=="\n");
}

?>
