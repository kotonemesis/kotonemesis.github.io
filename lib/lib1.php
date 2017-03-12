<?php
/*
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR LIBRARY PROGRAM    - 	 ■
#□ 									 □
#■ 		써브루틴 일람			 ■
#□ 									 □
#■ 	-			-	초기화			 ■
#■ ADDKINSHI2		-	금지 에리어 추가	 ■
#■ ADDKINSHI2		-금지 에리어 추가(수정)■
#■ KINSHIDEATH		-금지 에리어 Dead 처리  ■
#■ DECODE			-	디코드 처리	 ■
#□ SAVE			-	유저 정보 보존	 □
#■ SAVE2			-	적정보 보존		 ■
#□ CREAD			-	쿠키독입	 □
#■ CSAVE			-	쿠키 보존	 ■
#□ CDELETE			-	쿠키 삭제	 □
#■ LOGSAVE			-	로그 보존		 ■
#□ GetHostName		-	호스트 나토리 이득	 □
#■ HEADER			-	헤더부		 ■
#□ FOOTER			-	풋터부		 □
#■ ERROR			-	에러 처리		 ■
#□ AS				-	자동 선택		 □
#□ LOCK			-	락			 □
#■ UNLOCK			-	언로크		 ■
#□■□■□■□■□■□■□■□■□■□■□*/
//초기화 여기로부터//
global $ADMINLOCK;

LOCK();#파일 락

# 호스트 판별
global $host,$ref_url;
$host1 = $_SERVER['REMOTE_ADDR'];
$host2 = gethostbyaddr($host1);
if($pref['host_save'] == 1){
	$host = $host1;
}elseif($pref['host_save']){
	if($host1 == $host2 || $host1 == ''){$host = $host2;}
	else{$host = $host1.'-'.$host2;}
}else{
	$host = '';
}

# 모바일 대응 Script
$user_agent = explode('/',$_SERVER{'HTTP_USER_AGENT'});
$pref['MOBILE'] = $pic = false;
if (preg_match("/\.(ezweb|ido) \.ne\.jp$/",$host2)) {# EZweb 용의 처리
	$pref['MOBILE'] = 'Z';
	$pic = '.gif';
}elseif(preg_match("/\.google\.com$/",$host2) && $user_agent[0] == 'Mozilla' && strpos($user_agent[1],'Google Wireless Transcoder')!==false){# EZweb PC사이트용의 처리
	$pref['MOBILE'] = 'Z';
	$pic = '.gif';
#	if ($ENV{'HTTP_USER_AGENT'} =~ /^KDDI/) {# EZweb WAP2.0 단말용의 처리
#	} else {# EZweb 구단말용의 처리
#	}
#} elsif (($hostname eq 'pdxcgw.pdx.ne.jp')&&($user_agent[0] eq 'PDXGW')) {# H" 용의 처리
}elseif((preg_match("/\.docomo\.ne\.jp$/",$host2))&&($user_agent[0] == 'DoCoMo')) {# i-mode 용의 처리
	$pref['MOBILE'] = 'D';
	$pic = '.gif';
}elseif(($user_agent[0] == 'J-PHONE')&&(preg_match("/(jp-[ckqt]|vodafone|softbank) \.ne\.jp$/",$host2))) {# J-SKY 용의 처리
	$pref['MOBILE'] = 'V';
	$pic = '.png';
#} elsif (($user_agent[0] eq 'L-mode')&&($hostname =~ /\.pipopa\.ne\.jp$/)){# L-mode 용의 처리
}elseif(($user_agent[0] == 'Vodafone' || $user_agent[0] == 'SoftBank')&&(preg_match("/(jp-[ckqt]|vodafone|softbank) \.ne\.jp$/",$host2))) {# SoftBank 용의 처리
	$pref['MOBILE'] = 'V';
	$pic = '.gif';
} elseif ($user_agent[0] == 'Mozilla' && preg_match("/\.search\.tnz\.yahoo\.co\.jp$/",$host2)) {# SoftBank 용의 처리
	$pref['MOBILE'] = 'V';
	$pic = '.gif';
}elseif($user_agent[0] == 'DoCoMo') {# DoCoMo 용의 처리
	$pref['MOBILE'] = 'D';
	$pic = '.gif';
}#else{#그 이외
#}

if(isset($_SERVER['HTTP_CACHE_CONTROL']) || isset($_SERVER['HTTP_FORWARDED']) || isset($_SERVER['HTTP_PROXY_CONNECTION']) || isset($_SERVER['HTTP_VIA']) || isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
	$pref['PROXY']=true;
}else{
	$pref['PROXY']=false;
}

if($ADMINLOCK){ADMDECODE();}else{DECODE();}

# 배제 기능
$KICKOUT = 1;
if(isset($_SERVER['HTTP_REFERER'])){$ref_url = $_SERVER['HTTP_REFERER'];}
if(isset($base_list)){if(preg_match("/$base_list/i",$ref_url)) {$KICKOUT = 0;}}#last;}

if(!$KICKOUT || !$pref['base_url'] || ($pref['MOBILE'] && $pref['base_url'] == 2)){;}
elseif($in['Command']=='BRU' && $HEADERINDEX){;}
else{require $pref['LIB_DIR'].'/lib4.php';KICKOUT();}

# 액세스 금지
if($pref['acc_for']){
	#OK리스트 확인
	$okflg = 0;
	foreach ($pref['oklist'] as $oklist2){
		if($host2 == $oklist2){
			$okflg = 1;
		}
	}
	#액세스 금지 체크
	if($okflg == 0){
		foreach ($pref['kick'] as $kick2){
			if(strpos($host1,$kick2)!==false || strpos($host2,$kick2)!==false){
				ERROR('액세스 금지 리스트에 등록되어 있습니다<BR>Your access has been forbidden.','HOST-'.$host,'PREF',__FUNCTION__,__LINE__);
			}
		}
	}
}

# 금지 에리어 파일 읽기
$areafile=$pref['area_file'];
$pref['arealist'] = @file($pref['area_file']);

$fl = @file($pref['end_flag_file']);# or ERROR("unable to open end_flag_file");
$fl = implode('',$fl);
list($y,$m,$d,$hh,$mm) = explode(',',trim($pref['arealist'][0]));
list($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($pref['now']);
$month++;$year += 1900;
global $hackflg;

if(!preg_match("/종료/",$fl)){#종료전
	#CONF
	$pgsplit = 8;
	$fixmax = 4;
	$tgttime  = mktime($hh,$mm,0,$m,$d,$y);#다음 번 금지 에리어 추가 예정 시간
	if($pref['now'] >= $tgttime){#다음 번 금지 에리어 후
		if($pref['now'] < ($tgttime + ($pgsplit * 60 * 60))){#차례차례 회전
			ADDKINSHI();
		}elseif($pref['now'] > ($tgttime + ($fixmax * 60 * 60))){#불가능
		#금지 에리어 일정 시각의 경우는 수복되지 않습니다.
			if(isset($ADMINLOCK)){
				if($ADMINLOCK != 1){
					ERROR('일정 방치 시각이 지났습니다<BR>Please contact with Administrator','금지 에리어 추가 에러','pref');
				}
			}else{
				ERROR('일정 방치 시각이 지났습니다<BR>Please contact with Administrator','금지 에리어 추가 에러','pref');
			}
		}else{#수정 가능
			for($i=1;$pref['now'] >= $tgttime;$i++){
				if($pref['now'] < $tgttime + ($i * $pgsplit * 60 * 60)){
					ADDKINSHI();
					break;
				}
				ADDKINSHI2();
				$tgttime  = mktime($hh,$mm,0,$m,$d,$y);#다음 번 금지 에리어 추가 예정 시간
			}
		}
	}
}

#금지 에리어 취득
list($ar,$hackflg,$a) = explode(',',$pref['arealist'][1]);
#Re-get time
list($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($pref['now']);
if($hour < 10){$hour = '0'.$hour;}
if($min < 10){$min = '0'.$min;}
if($sec < 10){$sec = '0'.$sec;}
$month++;$year += 1900;

if(isset($ar)){
	# Stamina Max
	if($ar >= 7){$pref['maxsta'] = 500;}
	elseif($ar >= 4){$pref['maxsta'] = 400;}
	else{$pref['maxsta'] = 300;}
}
//초기화 여기까지//
#===================#
# ■ 금지 에리어 추가 #
#===================#
function ADDKINSHI(){
global $pref;

global $weth,$areafile,$ar,$ar2,$hackflg,$hh,$hour,$hackflg;
#CONF

$pgsplit = 8;

list($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($pref['now']+(60*60*$pgsplit));
$month++;$year += 1900;

$hour = $pgsplit * round($hour / $pgsplit);
if($hour >= 24){$hour-=24;$mday++;}

$weth = rand(0,9);
if(($weth < 0)&&($weth > 9)){$weth = '0';}
$pref['arealist'][0] = $year.','.$month.','.$mday.','.$hour.",0\n";	#에리어 추가 시각
list($ar,$hackflg,$a) = explode(',',$pref['arealist'][1]);
$ar2 = $ar + 1;
if($hackflg){$hackflg--;}
$pref['arealist'][1] = $ar2.','.$hackflg.",\n";#금지 에리어수
$pref['arealist'][5] = $weth."\n";

$handle = @fopen($areafile,'w') or ERROR('unable to open areafile','','PREF',__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$pref['arealist']))){ERROR('unable to write areafile','','PREF',__FUNCTION__,__LINE__);}
fclose($handle);

#금지 에리어 추가 로그
if($hackflg){LOGSAVE('HKARAD');}
else{LOGSAVE('AREAADD');}

$userlist = @file($pref['user_file']) or ERROR('unable to open user_file','','PREF',__FUNCTION__,__LINE__);

#금지 에리어자 Dead 처리
$userlist = KINSHIDEATH($userlist);

$handle = @fopen($pref['user_file'],'w') or ERROR('unable to open user_file','','PREF',__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$userlist))){ERROR('unable to write user_file','','PREF',__FUNCTION__,__LINE__);}
fclose($handle);

#Back Up
$pref['back_file'] = $pref['LOG_DIR'].'/BUF_'.$hour.'.log';
$handle = @fopen($pref['back_file'],'w') or ERROR('unable to open back_file',$hour,'PREF',__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$userlist))){ERROR('unable to write back_file',$hour,'PREF',__FUNCTION__,__LINE__);}
fclose($handle);
}
#=========================#
# ■ 금지 에리어 추가(수정) #
#=========================#
function ADDKINSHI2(){
global $pref;

global $year,$month,$mday,$weth,$userlist,$areafile,$ar,$ar2,$hh,$hackflg;
#CONF

$pgsplit = 1;

$hour = $hh + $pgsplit;
if($hour > 24){$hour-=24;}

$pref['arealist'][0] = $year.','.$month.','.$mday.','.$hour.',0';	#에리어 추가 시각
list($ar,$hackflg,$a) = explode(',',$pref['arealist'][1]);
$ar2 = $ar + 1;
if($hackflg){$hackflg--;}
$pref['arealist'][1] = $ar2.','.$hackflg.",\n";#금지 에리어수, 해킹

#금지 에리어 추가 로그
if($hackflg){LOGSAVE('HKARAD');}
else{LOGSAVE('AREAADD');}

#금지 에리어자 Dead 처리
$userlist = KINSHIDEATH($userlist);

$hh = $hour;
}
#=======================#
# ■ 금지 에리어 Dead 처리 #
#=======================#
function KINSHIDEATH($userlist){
global $pref;
global $ar,$ar2,$cnt,$hackflg,$deth,$fl;
global $w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item,$w_eff,$w_itai,$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP;

list($ka,$hf) = explode(',',trim($pref['arealist'][1]));
if($ka==1){
	return $userlist;
}


list($ara[0],$ara[1],$ara[2],$ara[3],$ara[4],$ara[5],$ara[6],$ara[7],$ara[8],$ara[9],$ara[10],$ara[11],$ara[12],$ara[13],$ara[14],$ara[15],$ara[16],$ara[17],$ara[18],$ara[19],$ara[20],$ara[21]) = explode(',',$pref['arealist'][4]);
$mem = 0;#생존자수
$chg = false;#변경?
require_once $pref['LIB_DIR'].'/attack.php';
for ($i=0; $i<count($userlist); $i++){#유저 루프
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$i]);
	for ($cnt=0; $cnt<$ar2; $cnt++){#금지 에리어 루프
		if($pref['place'][$w_pls] == $pref['place'][$ara[$cnt]] && $w_hit > 0 && strstr($fl,'종료') ===false){#생존?&!종료?&금지 에리어?
			if($w_sts == 'NPC'){#NPC?
				if($w_f_name == '병사' && $ar2 < count($pref['place'])){#병사?
					$w_pls = RUN_AWAY($w_pls);#도망 응전 자동 회피(병사?)
					$chg = true;
				}#else{}판지&감사역?
			}else{#PC?
				if($w_ousen == '도망 몸의 자세' && $ar2 < count($pref['place'])){#자동 회피
					$w_pls = RUN_AWAY($w_pls);#도망 응전 자동 회피(도망?)
					$chg = true;
				}elseif(!$hackflg){	#해킹시 이외는 Dead
					LOGSAVE('DEATHAREA');
					$w_hit=0;$w_death=$deth;$w_sts='Dead';
					$chg=true;
				}
			}
		}
	}
	if($w_hit > 0){
		if($w_sts != 'NPC'){$mem++;}
		if($ar2 == 4){$w_sta += 100;$chg = true;}#생존자의 최대 스태미너 UP
		elseif($ar2 == 7){$w_sta += 100;$chg = true;}#생존자의 최대 스태미너 UP
		elseif($ar2 == 18){$w_teamID=$w_teamPass='없음';$chg = true;}#팀 해제
	}
	if($chg){#변경
		$userlist[$i] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,\n";
	}
}
$b_limit = ($pref['battle_limit'] * 3) + 1;
if(strstr($fl,'종료') ===false && (($mem == 0 && $ar > $b_limit)||($ar2 == count($pref['place'])))){#종료&생존자 0 or 에리어 최후
	$handle = @fopen($pref['end_flag_file'], 'w');# or ERROR("unable to open end_flag_file","","BR",__FUNCTION__,__LINE__);
	if(!@fwrite($handle, "종료 \n")){ERROR('unable to write end_flag_file','','BR',__FUNCTION__,__LINE__);}
	fclose($handle);
	LOGSAVE('END');
}
return $userlist;
}
#=================#
# ■ 디코드 처리 #
#=================#
function DECODE(){
global $in,$pref;

$p_flag=0;
//디코드 처리
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if($_SERVER['CONTENT_LENGTH'] > 51200){
		ERROR('투고량이 너무 큽니다','','LIB1',__FUNCTION__,__LINE__);
	}
	$in = array_map('DECODE2',$_POST);
}else{ 
	$in = array_map('DECODE2',$_GET);
}
extract($in);
if(!isset($in['Command'])){$in['Command']='';}
//list($usec, $sec) = explode(' ', microtime());
//return (float) $sec + ((float) $usec * 100000);
//PHP 4.2.0 미만은 아래의 코멘트를 빗나가게 한다
//srand(make_seed());
}
#==================#
# ■ 디코드 처리 2 #
#==================#
function DECODE2($string){
global $pref;
if(isset($pref['MOBILE']) && $pref['MOBILE']){
	//SJIS로부터 EUC-JP에 변환
	#$string = mb_convert_encoding(urldecode($string),"EUC-JP","SJIS");
	$string = urldecode($string);
	$string = mb_convert_encoding($string,'EUC-JP','SJIS');
}

//태그 해제 처리
$string = str_replace ('&amp;','&',$string );
$string = str_replace ('&#039;','\\\'',$string );
$string = str_replace ('"','\"',$string );
$string = str_replace ('<','<',$string );
$string = str_replace ('>','>',$string );	
$string = str_replace ('&nbsp;',' ',$string );

$string = str_replace ('&','&amp;',$string );
$string = str_replace ('\\\'','&#039;',$string );
$string = str_replace ('\"','"',$string );
$string = str_replace ('<','<',$string );
$string = str_replace ('>','>',$string );
$string = str_replace (' ','&nbsp;',$string );

$string = str_replace (',',',',$string );
$string = ereg_replace ("\n",'',$string );

return trim($string);
}
#===================#
# ■ 유저 정보 보존 #
#===================#
function SAVE(){
global $in,$pref;

global $id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item,$eff,$itai,$com,$dmes,$bid,$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass;

$userlist = @file($pref['user_file']) or ERROR('unable to open user_file','','LIB1',__FUNCTION__,__LINE__);

$chksts = 0;
for($i=0;$i<count($userlist);$i++){
	list($w_i,$w_p,$a) = explode(',',$userlist[$i]);
	if(($in['Id'] == $w_i)&&($in['Password'] == $w_p)){#ID일치?
		$chksts = 1;$Index=$i;break;
	}
}
if($chksts){
	if($hit <= 0){$sts = "Dead";$inf = $pref['now'];}
	$user1 = "$id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],,$com,$dmes,$bid,".$in['club'].",$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,".$in['IP'].",";
	$user1 = ereg_replace("\x0D?\x0A?$","",$user1);/*개행 코드의 삭제*/
	$userlist[$Index] = "$user1\n";

	$handle = @fopen ($pref['user_file'],'w') or ERROR('unable to open user_file','','LIB1',__FUNCTION__,__LINE__);
	if(!@fwrite($handle,implode('',$userlist))){ERROR('unable to write areafile','','LIB1',__FUNCTION__,__LINE__);}
	fclose($handle);
}else{
	ERROR('Internal Server Error','에러가 발생했습니다.관리인에게 연락해 주세요 CODE:'.$in['Id'],'LIB1',__FUNCTION__,__LINE__);
}
}
#===============#
# ■ 적정보 보존 #
#===============#
function SAVE2(){
global $pref;

global $w_id,$w_pass,$chksts;

global $w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item,$w_eff,$w_itai,$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP;
$userlist = @file($pref['user_file']) or ERROR('unable to open user_file','','LIB1',__FUNCTION__,__LINE__);

if($w_hit <= 0){
	$w_sts = "Dead";
	$w_inf = $pref['now'];
}
$user2 = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,";
$user2 = ereg_replace("\x0D?\x0A?$",'',$user2);/*개행 코드의 삭제*/

for($i=0;$i<count($userlist);$i++){#ID일치?
	list($w_i,$w_p,$a) = explode(',',$userlist[$i]);
	if(($w_id == $w_i)&&($w_password == $w_p)){
		$chksts = 1;
		$Index=$i;
		break;
	}
}
if($chksts){
	$userlist[$Index] = $user2."\n";

	$handle = @fopen($pref['user_file'],'w') or ERROR('unable to open user_file','','LIB1',__FUNCTION__,__LINE__);
	if(!@fwrite($handle,implode('',$userlist))){ERROR('unbale to write areafile','','LIB1',__FUNCTION__,__LINE__);}
	fclose($handle);
}else{
	ERROR('Internal Server Error','에러가 발생했습니다.관리인에게 연락해 주세요 CODE:'.$w_id,'LIB1',__FUNCTION__,__LINE__);
}
}
#=================#
# ■ 쿠키독입 #
#=================#
function CREAD(){
@list($c_id,$c_password,$c_f_name,$c_l_name,$c_sex,$c_cl,$c_no,$c_endtime,$c_att,$c_def,$c_hit,$c_mhit,$c_level,$c_exp,$c_sta,$c_wep,$c_watt,$c_wtai,$c_bou,$c_bdef,$c_btai,$c_bou_h,$c_bdef_h,$c_btai_h,$c_bou_f,$c_bdef_f,$c_btai_f,$c_bou_a,$c_bdef_a,$c_btai_a,$c_tactics,$c_death,$c_msg,$c_sts,$c_pls,$c_kill,$c_icon,$c_item[0],$c_eff[0],$c_itai[0],$c_item[1],$c_eff[1],$c_itai[1],$c_item[2],$c_eff[2],$c_itai[2],$c_item[3],$c_eff[3],$c_itai[3],$c_item[4],$c_eff[4],$c_itai[4],$c_item[5],$c_eff[5],$c_itai[5],$c_log,$c_com,$c_dmes,$c_bid,$c_club,$c_money,$c_wp,$c_wg,$c_wn,$c_wc,$c_wd,$c_comm,$c_limit,$c_bb,$c_inf,$c_ousen,$c_seikaku,$c_sinri,$c_item_get,$c_eff_get,$c_itai_get,$c_teamID,$c_teamPass,$c_IP,) = explode(",",$_COOKIE['BR']);
}
#=================#
# ■ 쿠키 보존 #
#=================#
function CSAVE(){
global $in,$pref;

global $id,$password,$f_name,$l_name,$sex,$cl,$no,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item,$eff,$itai,$com,$dmes,$bid,$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,$expires;

$cook = "$id,$password,$f_name,$l_name,$sex,$cl,$no,0,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],,$com,$dmes,$bid,".$in['club'].",$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,".$in['IP'].",";
setcookie('BR',$cook,$pref['now'] + $pref['save_limit'] * 86400);
}
#=================#
# ■ 쿠키 삭제 #
#=================#
function CDELETE(){
global $pref,$expires;

$cook = '2YBRU,,,,,,,'.$pref['now'].',,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,';
setcookie('BR',$cook,$pref['now'] + $pref['save_limit'] * 86400);
}
#=============#
# ■ 로그 보존 #
#=============#
function LOGSAVE($work){
global $pref;

require_once $pref['LIB_DIR'].'/lib4.php';
LOGSAVE2($work);
}
#===============#
# ■ 버퍼 #
#===============#
function bru($buffer){
return(ereg_replace("\n",'',ereg_replace("\"",'',$buffer)));
}
#===============#
# ■ 헤더부 #
#===============#
function HEAD(){
global $in,$pref;

global $REGIST,$HEADERINDEX,$sts,$user_agent;
if($pref['MOBILE']){
	ini_set('output_buffering','on');#출력 버퍼링을 유효 
	ini_set('output_handler','mb_output_handler');#출력의 변환을 유효하게 하기 위해서 mb_output_handler를 지정 
	ini_set('mbstring.http_input','auto');#HTTP 입력 문자 인코딩의 디폴트치 
	ini_set('mbstring.internal_encoding','EUC-JP');#내부 문자 인코딩의 디폴트치 
	ini_set('mbstring.http_output','SJIS');#HTTP 출력 문자 인코딩의 디폴트치 
	mb_internal_encoding('EUC-JP');
	mb_http_output('SJIS');#HTTP 출력 문자 인코딩의 디폴트치 
	ob_start('mb_output_handler');
?>
<HTML><HEAD><meta http-equiv="content-type" content="text/html;charset=Shift_JIS"><TITLE><?=$pref['game']?></TITLE><HEAD><BODY text="#ffffff" link="#ff0000" vlink="#ff0000" aLink="#ff0000" bgcolor="#000000"><center>
<?
}else{
	@header("Content-type: text/html;charset=EUC-JP\n\n");
	@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	// 항상 수정되고 있다
	@header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	// HTTP/1.1
	@header("Cache-Control: no-store, no-cache, must-revalidate");
	@header("Cache-Control: post-check=0, pre-check=0", false);
	// HTTP/1.0
	@header("Pragma: no-cache");
	
	print '<HTML><HEAD><meta http-equiv="Content-Type" content="text/html; charset=EUC-JP"><META HTTP-EQUIV="Pragma" CONTENT="no-cache"><META HTTP-EQUIV="Expires" CONTENT="-1"><TITLE>'.$pref['game'].'</TITLE><LINK REL="stylesheet" TYPE="text/css" HREF="BRU.CSS">';
	print '</HEAD><BODY rightmargin="0" topmargin="0" leftmargin="0" bgcolor="#000000" text="#ffffff" link="#ff0000" vlink="#ff0000" aLink="#ff0000"';
	if($HEADERINDEX){
		print ' onload=\'typeMain("tw","color=#black","신세기의 초, 하나의 나라가 망가졌다.$$완전 실업률 15%돌파,$$실업자 천만인$$불등교 학생 80만명$$자신을 잃은 어른들은 아이를 무서워해 이윽고, 하나의 법안이 가결되었다.$$신세기 교육개혁법【통칭 BR법】$$전국의 중학 3년의 50 클래스를 선발.$$그리고 클래스 메이트가 「마지막 한 명」이 될 때까지 싸운다.$$마지막에 살아 남은 학생만이 집으로 돌아올 수 있다고 하는 「살인 게임」이었다···.",9) \'>';
	#}elseif(preg_match("/BATTLE|ATK/",$in['Command'])){print "onload=\"quake_init() \"><SCRIPT language=JavaScript src=\"BRU.JS\"></SCRIPT>";
	}else{
		if(preg_match("/수면|치료|정양/",$sts)||(isset($in['Command']) && (($in['Command'] == "MOVE" && $in['Command2'] == "MAIN")||($in['Command'] == "ITMAIN" && $in['Command3'] == "MAIN")||($in['Command'] == "SPECIAL" && $in['Command4'] == "MAIN")||($in['Command'] == "kaifuku" && $in['Command5'] == "MAIN")))){
			print ' onload="document.MSG.Mess.focus()"><SCRIPT language=JavaScript src="BRU.JS"></SCRIPT>';
		}else{
			print '><SCRIPT language=JavaScript src="BRU.JS"></SCRIPT>';
		}
	}
	print '<center><DIV ID="BRU">';//<!--{$user_agent[0]}TABLE ID=\"BRU\" border=\"0\" height=\"100%\" width=\"100%\" cellspacing=\"0\" collspacing=\"0\"><TR><TD-->";
}
}
#=============#
# ■ footer부 #
#=============#
function FOOTER(){
global $pref;
if($pref['MOBILE']){
?>
<br>
<small>
<a href="http://www.happy-ice.com/battle/">BATTLE ROYALE <?=$pref['ver']?></a><br>
<a href="http://www.b-r-u.net/">BRU (Battle Royale Ultimate) Ver. <?=$pref['ver2y']?></a></font></b>
</small>
</center>
</BODY>
</HTML>
<?
	@ob_end_flush();
}else{
?>
</CENTER>
<!--/TD></TR><TR><TD height="20%"-->
<div width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan="2">
<HR>
</tr></td>
<tr><td>
<font color="yellow">Use of VPN/Proxy for the purpose circumventing ban is prohibited, but you may use VPN/proxy if your Internet environment censor this website with any filtering systems. (School/Work)<br><a href="../patio/?mode=view&no=28">※ Feel free to inform bug via email above or suggestions to facebook page! ※</a></font>
</td><td>
<p style="text-align: right">
<b><font face="Viner Hand ITC" color="#ff0000" style="font-size: 9pt">
BATTLE ROYALE <?=$pref['ver']?><br>
<a href="http://tomodachi-anime.forumotion.com">BRU EN Ver. <?=$pref['ver2y']?></a></font></b>
</p></tr></td>
</table>
</TD></TR>
</table>
</BODY>
</HTML>
<?
}
}
#===============#
# ■ 에러 처리 #
#===============#
function debug($str){#■에러 화면
global $pref;

#New User Save
$handle = @fopen($pref['LOG_DIR'].'/debug.log', 'a') or ERROR('unable to open file user_file','','REGIST',__FUNCTION__,__LINE__);
if(!@fwrite($handle,$str)){ERROR('cannot write to user_file','','REGIST',__FUNCTION__,__LINE__);}
fclose($handle);

}
#===============#
# ■ 에러 처리 #
#===============#
function ERROR($errmes0='불명한 에러',$errmes1='N/A',$errmes2='N/A',$errmes3='N/A',$errmes4='N/A'){#■에러 화면
global $in,$pref;

if($pref['lockf']){UNLOCK();}
HEAD();
?>
<B><FONT color="#ff0000" size="+3" face="MS 내일 아침">에러 발생</FONT></B><BR><BR>
<FONT size="2"><?=$errmes0?><BR><BR>
Comment:<?=$errmes1?><BR><BR>
ERROR ID:<?=$errmes2?> - <?=$errmes3?> - <?=$errmes4?><BR><BR>
COMMAND: -1- <?=$in['Command']?> -2- <?=$in['Command2']?> -3- <?=$in['Command3']?> -4- <?=$in['Command4']?> -5- <?=$in['Command5']?><BR><BR>
<BR><B><FONT color="#ff0000"><A href="index.php">HOME</A></B></Font>
<?
FOOTER();
exit;
}
#=============#
# ■ 자동 선택 #
#=============#
function Auto($AS_MES = '',$CMD = "sl"){#AS => Auto
global $ASN,$pref;
if($ASN == ''){$ASN = 0;}
if($AS_MES){
	print '<a title="'.$AS_MES.'"';
}else{
	$AS_MES = ' ';
	print '<a';
}
if($pref['MOBILE']){
	print '>';
}else{
	print ' onclick='.$CMD.'('.$ASN.'); onmouseover="status=\''.$AS_MES.'\';return true;">';
}
$ASN++;
}
#===============#
# ■ ID의 암호화 #
#===============#
function IDcrypt($chk_id){
	#return substr(crypt($chk_id,"br"),2);
	return $chk_id;
}
#===========#
# ■ 락 #
#===========#
function LOCK(){
global $pref,$fp;
$fp = fopen($pref['lockf'],'w+');
flock($fp,LOCK_EX);
$lockflag=1;
}
#===============#
# ■ 언로크 #
#===============#
function UNLOCK(){
global $fp;
flock($fp,LOCK_UN);
}
?>