#!/usr/local/php5/bin/php -q

<?php
exit;
//#!/usr/local/php5/bin/php -q
/***************************************************************************************
* Module Name			:	관리자 - 뉴스 레터 발송
* Created Date			:	2011.09.07
* Created by				:	RevU 박상선 
* Modify History			:   2011.10.10 - 그룹, 프론티어 당첨 그룹메일 추가
                                    2012.06.19 - 센드메일 상태 체크 로직 추가(발송중일시 _cron/mail/XXX.txt 파일 생성, 발송 완료시 파일제거, 크론시작시 파일 존재시 exit 미존재시 정상진행)



****************************************************************************************/
//===============================================================
//클론설정
//===============================================================
//error_reporting(0);


include "/www/revu39/engine/_sys/sys.conf.cron.php";
include "/www/revu39/engine/_sys/sys.module.php";


//===============================================================
//CLASS
//===============================================================
$CLASS_BASIC = &Module::singleton("Mail.Mailcla");
$CLASS_BASE = &Module::singleton("Base");		

//===============================================================
//DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

//===============================================================
//VARS
//===============================================================

$nowyear			= date("Y");
$nowmonth		= date("m");
$nowday			= date("d");

$startyear			= array();
$startmonth		= array();
$startday			= array();
$startnowtime	= array();

$endyear			= array();
$endmonth		= array();
$endday			= array();
$endnowtime		= array();


for($i=$nowyear; $i<=2020; $i++) {
	$startyear[]		= $i;
	$endyear[]		= $i;
}

for($i=1; $i<=12; $i++) {
	$startmonth[]	= $i;
	$endmonth[]		= $i;
}

for($i=1; $i<=31; $i++) {
	$startday[]		= $i;
	$endday[]			= $i;
}

for($i=1; $i<=24; $i++) {
	$starttime[]		= $i;
	$endtime[]		= $i;
}


$limitCnt							= 100;					// 발송 단위수
$dmailStepNext					= 10000;				// 다음 발송 단위수
$breakNum						= 5;					// DB커넥션이 끊어졌거나 DB정보가 없을때 카운트 하여 break
$breakCnt							= 200;					// break 카운트수


//$sendingCheckFile = "/www/revu39/engine/_cron/mail/sendingCheck.txt";
$sendingCheckFile = "/www/revu39/public_html/facebook/sendingCheck.txt";

if (is_file($sendingCheckFile)){
	echo "[sending status : busy.] ";
}else{
	echo "[sending status : free.] ";
}

				//sending Check File ADD
					mailSendingFileAdd($sendingCheckFile);
				echo "echo ▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒ RevU ReserveNewsLetter Sending Start ▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒<br>";

					
				//그룹코드별로 상세데이타 셀렉팅(Ru_account, Ru_account_extra 테이블)
				$groupcode = "A";
				$sendCnt = 0;
				$mailgroup_selecting = $CLASS_BASIC->MailGroupSelectAll_distinct($DB, $groupcode, $sendCnt, $limitCnt);
				/*Email Cnt Check*/
				//$mailgroup_selecting = $CLASS_BASIC->MailGroupSelectAll_distinct_cnt($DB, $groupcode, $sendCnt, $limitCnt);

				//echo sizeof($mailgroup_selecting);
				
				for($i=0;$i<5;$i++) {
					
					echo "its out_Area value =".$i."<br/>";

						for($k=0;$k<3;$k++) {
							echo "its inArea value =".$k."<br/>";
						}
//						if($i > 0){
//							$DB->rConnect();
//						}
						/* Email echo*/
//						$email = $mailgroup_selecting[$k]['email'];
//						echo $email."<br/>";
					echo "its out_Area value END !!!!!!! =".$i."<br/>";	
				}
				
//				echo $i;

				//Sending Check File Del
					mailSendingFileDel($sendingCheckFile);

//		global $CONNECT;		 
//		if(count($CONNECT) > 0) {
//			foreach($CONNECT as $key => $val) {
//				var_dump($CONNECT[$key])."<br/><br/>";
//			}
//		}


function test($objectr)
    {
        if( is_object($objectr) )
        {
         // do something for instance method
            echo 'this is an instance call <br />' . "\n";
        }else
        {
         // do something different for procedural method
            echo 'this is a procedure call <br />' . "\n";
        }
    }

//test($DB);

		$intervalo = date_diff(date_create(), date_create('2012-06-12 10:30:00'));
        $out = $intervalo->format("Years:%Y,Months:%M,Days:%d,Hours:%H,Minutes:%i,Seconds:%s");
		$a_out = array();
        array_walk(explode(',',$out),
        function($val,$key) use(&$a_out){
            $v=explode(':',$val);
            $a_out[$v[0]] = $v[1];
        });
//		echo $a_out['Years']."년<br/>";
//		echo $a_out['Months']."월<br/>";
//		echo $a_out['Days']."일<br/>";
//		echo $a_out['Hours']."시<br/>";
//		echo $a_out['Minutes']."분<br/>";
//		echo $a_out['Seconds']."초<br/>";

function otherDiffDate($end='2012-06-12 10:30:00', $out_in_array=false){
        $intervalo = date_diff(date_create(), date_create($end));
        $out = $intervalo->format("Years:%Y,Months:%M,Days:%d,Hours:%H,Minutes:%i,Seconds:%s");
        if(!$out_in_array)
            return $out;
        $a_out = array();
        array_walk(explode(',',$out),
        function($val,$key) use(&$a_out){
            $v=explode(':',$val);
            $a_out[$v[0]] = $v[1];
        });
        return $a_out;
}
//
//
//echo otherDiffDate();

function mailSendingFileAdd($filename){
	$fp = fopen($filename,"w+");
	fwrite($fp,"Y");
	$returnfile = fgets($fp, 1024);
	fclose($fp);
}

function mailSendingFileDel($filename){
	unlink($filename);
}




Module::exitModule();
		


?>
