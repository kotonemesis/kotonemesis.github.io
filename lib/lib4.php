<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR LIBRARY PROGRAM    - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ MESS		-		메세지 등록	 ■
#■ MSG_DEL		-		메세지 삭제	 ■
#□ LOGSAVE2	-			로그 보존	 □
#■ KICKOUT		-			불법 침입	 ■
#□ news		-			뉴스	 □
#■□■□■□■□■□■□■□■□■□■□■
#=======================#
# ■ 메세지 등록 처리 #
#=======================#
function MESS(){
global $in,$pref;

global $log,$id,$f_name,$l_name;
$in['Command']='MAIN';
$in['mode']='main';
# 입력 정보 체크
if($in['Mess']==''){$log .= '메세지가 입력되고 있지 않습니다.<br>';return;}
# 전언 정보 보존 Command2
$messagelist = @file($pref['mes_file']);# or ERROR("unable to open mes_file");

array_unshift($messagelist,$pref['now'].','.$id.','.$f_name.','.$l_name.','.$in['M_Id'].','.$in['Mess'].",\n");
if(count($messagelist) >= $pref['listmax']){array_pop($messagelist);}
$handle = @fopen($pref['mes_file'],'w') or ERROR('unable to open mes_file','','LIB3',__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$messagelist))){ERROR('unable to write mes_file','','LIB3',__FUNCTION__,__LINE__);}
fclose($handle);
}
#=======================#
# ■ 메세지 삭제 처리 #
#=======================#
function MSG_DEL(){
global $in,$pref;

global $log,$id,$f_name,$l_name;
$in['Command']='MAIN';
$in['mode']='main';
# 입력 정보 체크
if(!ctype_digit($in['Command2'])){$log .= '메세지가 입력되고 있지 않습니다.<br>';return;}
# 전언 정보 보존 Command2
$messagelist = @file($pref['mes_file']);# or ERROR("unable to open mes_file");
foreach($messagelist as $key => $message){
	list($mes_time,$from_id,$w_f_name,$w_l_name,$to_id,$from_message) = explode(',',$message);
	if($from_id==$id && $mes_time==$in['Command2']){
		$messagelist[$key]=$mes_time.','.$from_id.','.$w_f_name.','.$w_l_name.',DEL,'.$from_message.",\n";
		break;
	}
}

$handle = @fopen($pref['mes_file'],'w') or ERROR('unable to open mes_file','','LIB3',__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$messagelist))){ERROR('unable to write mes_file','','LIB3',__FUNCTION__,__LINE__);}
fclose($handle);
}
#=============#
# ■ 로그 보존 #
#=============#
function LOGSAVE2($work){
global $in,$pref;

global $deth;

$newlog = '';

if($work == "NEWENT"){		#신규 등록
	global $cl,$no,$host2,$host;
	$newlog = $pref['now'].",".$in['F_Name'].",".$in['L_Name'].",".$in['Sex'].",$cl,$no,,,,,$host2,ENTRY,$host,\n";
}elseif($work == "G-DATT"){	#그룹 탈퇴
	global $f_name,$l_name,$sex,$cl,$no,$teamold;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,,,,,,G-DATT,$teamold,\n";
}elseif($work == "G-JOIN"){	#그룹 결성
	global $f_name,$l_name,$sex,$cl,$no;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,,,,,,G-JOIN,".$in['teamID2'].",\n";
}elseif($work == "G-KANYU"){	#그룹 가입
	global $f_name,$l_name,$sex,$cl,$no;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,,,,,,G-KANYU,".$in['teamID2'].",\n";
}elseif($work == "ITEM_J"){	#그룹 가입
	global $f_name,$l_name,$sex,$cl,$no,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$item_j;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,ITEM_J,$item_j,\n";
}elseif($work == "DEATH"){	#자신 사망(요인:함정)
	global $f_name,$l_name,$sex,$cl,$no,$dmes,$msg;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,,,,,,DEATH0,$dmes,\n";
	$death = "쇠약사";$msg=$dmes;
}elseif($work == "DEATH1"){	#자신 사망(요인:독살)
	global $f_name,$l_name,$sex,$cl,$no,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$dmes,$msg;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,DEATH1,$dmes,\n";
	$death = "독물 섭취";$msg=$dmes;
}elseif($work == "DEATH2"){	#자신 사망(요인：전쟁에 패해서 죽는 것)
	global $w_wep,$f_name,$l_name,$sex,$cl,$no,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$dmes,$d2,$w_msg,$msg;
	list($w_name,$w_kind) = explode("<>", $w_wep);
	if (preg_match("/K/",$w_kind)){$d2 = "참살";}#참계
	elseif((preg_match("/G/",$w_kind))&&($w_wtai > 0)){$d2 = "총살";}#총계
	elseif(preg_match("/C/",$w_kind)){$d2 = "살해";}#투계
	elseif(preg_match("/D/",$w_kind)){$d2 = "폭살";}#폭계	↓곤봉 or 탄 없음총 or 화살 없음활
	elseif((preg_match("/B/",$w_kind))||((preg_match("/G|A/",$w_kind))&&($w_wtai == 0))){$d2 = "박살";}
	else {$d2 = "살해";}
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,DEATH2,$dmes,\n";
	if ($w_no == "정부"){$deth = "$w_f_name $w_l_name 에 의해 $d2";}
	else {$deth = "$w_f_name $w_l_name($w_cl $w_sex$w_no 차례)에 의해 $d2";}
	if ($w_msg != ""){$msg = "$w_f_name $w_l_name 「$w_msg」";}
	else {$msg = "";}
}elseif($work == "DEATH3"){#적사망(요인:전쟁에 패해서 죽는 것)
	global $wep,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$f_name,$l_name,$sex,$cl,$no,$w_dmes,$d2,$w_msg,$msg;
	list($w_name,$w_kind) = explode("<>", $wep);
	if (preg_match("/K/",$w_kind)){$d2 = "참살";}#참계
	elseif((preg_match("/G/",$w_kind))&&($wtai > 0)){$d2 = "총살";}#총계
	elseif(preg_match("/C/",$w_kind)){$d2 = "살해";}#투계
	elseif(preg_match("/D/",$w_kind)){$d2 = "폭살";}#폭계	↓곤봉 or 탄 없음총 or 화살 없음활
	elseif((preg_match("/B/",$w_kind))||((preg_match("/G|A/",$w_kind))&&($wtai == 0))){$d2 = "박살";}
	else {$d2 = "살해" ;}
	$newlog = $pref['now'].",$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$f_name,$l_name,$sex,$cl,$no,DEATH3,$w_dmes,\n";
	$deth = "{$f_name} {$l_name}({$cl} {$sex}{$no}차례)에 의해{$d2}";
	if ($msg != '') {$w_msg = "{$f_name} {$l_name}「{$msg}」";}
	else {$w_msg = '' ;}
	$w_log = "";
}elseif($work == "DEATH4"){	#정부에 의한 살해
	global $w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_dmes,$log,$w_msg;
	$newlog = $pref['now'].",$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,,,,,,DEATH4,$w_dmes,\n";
	$deth = "정부에 의한 처형";
	$log ="";
	if($w_msg != "") {$msg = "정부 「$w_msg」";}
	else{$msg = "" ;}
}elseif($work == "DEATH5"){	#정부에 의한 살해 2
	global $f_name,$l_name,$sex,$cl,$no,$dmes,$log,$msg;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,,,,,,DEATH4,$dmes,\n";
	$deth = "정부에 의한 처형";
	$log ="";
	$msg = "정부 「안된다 , 의심스러운 행동을 취하면 목걸이를 폭파한다고 한 것 같아」";
}elseif($work == "DEATHAREA"){	#사망(요인：금지 에리어)
	global $w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_dmes,$log,$msg;
	$newlog = $pref['now'].",$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,,,,,,DEATHAREA,$w_dmes,\n";
	$deth = "금지 에리어 체재";
	$msg = "" ;$log ="";
}elseif($work == "END"){	#종료
	global $f_name,$l_name,$sex,$cl,$no,$dmes;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,,,,,,END,$dmes,\n";
	$handle = @fopen ($pref['end_flag_file'], 'w');# or ERROR("unable to open file end_flag_file","","LIB4",__FUNCTION__,__LINE__);
	if(!@fwrite($handle,"종료 \n")){ERROR("cannot write to end_flag_file","","LIB4",__FUNCTION__,__LINE__);}
	fclose($handle);
}elseif($work == "WINNER"){	#우승 결정
	global $f_name,$l_name,$sex,$cl,$no,$dmes;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,,,,,,WINNER,$dmes,\n";
}elseif($work == "HACK"){	#해킹 성공
	global $f_name,$l_name,$sex,$cl,$no,$dmes;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,,,,,,HACK,$dmes,\n";
}elseif($work == "EX_END"){	#해킹에 의해 프로그램을 정지
	global $f_name,$l_name,$sex,$cl,$no,$dmes;
	$newlog = $pref['now'].",$f_name,$l_name,$sex,$cl,$no,,,,,,EX_END,$dmes,\n";
}elseif($work == "AREAADD"){	#금지 에리어 추가
	global $ar,$ar2,$hh,$weth;
	$ar = $ar2 - 1 ;
	$newlog = $pref['now'].",$ar2,$ar,$hh,$weth,,,,,,,AREA,,\n";
} elseif ($work == "HKARAD"){	#해킹시 금지 에리어 추가
	global $ar2,$hh,$weth,$hackflg;
	$newlog = $pref['now'].",$ar2,$hackflg,$hh,$weth,,,,,,,HKARAD,,\n";
}

$loglist = @file($pref['log_file']) or ERROR("unable to open log_file","","LIB4",__FUNCTION__,__LINE__);
$loglist = implode('',$loglist);
$newlog .= $loglist;

$handle = @fopen($pref['log_file'],'w') or ERROR("unable to open file log_file","","LIB4",__FUNCTION__,__LINE__);
if(!@fwrite($handle,$newlog)){ERROR("cannot write to log_file","","LIB4",__FUNCTION__,__LINE__);}
fclose($handle);

}
#=============#
# ■ 불법 침입 #
#=============#
function KICKOUT(){#■에러 화면
global $in,$pref;

global $lockflag,$host,$ref_url,$HEADERINDEX,$ver,$ver2y;
if($lockflag){UNLOCK();}
if($ref_url == ""){$ref_url = "N/A";}
$Server_Name = $_SERVER{'SERVER_NAME'};

@header("Content-type: text/html;charset=EUC-JP\n\n");
@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// 항상 수정되고 있다
@header("Last-Modified: " . gmdate("D, d M Y H:i:s,$time") . " GMT");
// HTTP/1.1
@header("Cache-Control: no-store, no-cache, must-revalidate");
@header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
@header("Pragma: no-cache");

print <<<_HERE_
<HTML><HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=x-euc-jp">
<META http-equiv=refresh content=3;url=http://www.b-r-u.net>
<TITLE>{$pref['game']}</TITLE>
<LINK REL="stylesheet" TYPE="text/css" HREF="BRU.CSS">
</HEAD>
<BODY contextmenu="false" bottommargin="0" rightmargin="0" topmargin="0" leftmargin="0" bgcolor="#000000" text="#ffffff" link="#ff0000" vlink="#ff0000" aLink="#ff0000"

_HERE_;

print "onload=\"BRU.scrollIntoView(true)\"><CENTER><DIV ID=\"BRU\">";
print "<SCRIPT language=JavaScript src=\"BRU.JS\"></SCRIPT>";
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">불법 침입자 발견</span></font></center><BR>
<P><FONT size="3">올바른 입구로부터 들어가 주세요</p></FONT>
약 3초 후로 납니다.<br>
날지 않는 경우는,<a href="http://www.b-r-u.net">여기<a>를 클릭<br>
<table border=0>
<tr><td>CODE-A : $ref_url</td></tr>
<tr><td>CODE-B : $host</td></tr>
<tr><td>CODE-C : $Server_Name</td></tr>
<tr><td>CODE-D : $in[Command]-$HEADERINDEX</td></tr>
</table>
<BR><B><FONT color="#ff0000"><U>HOME</U></B></Font>
</CENTER>
</DIV>
<div width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan="2">
<HR>
</tr></td>
<tr><td>
<p style="text-align: right">
<b><font face="Viner Hand ITC" color="#ff0000" style="font-size: 9pt">
<a href="http://www.happy-ice.com/battle/">BATTLE ROYALE $ver</a><br>
<a href="mailto:2Y\@mindspring.com">BRU (Battle Royale Ultimate) Ver. $ver2y</a></font></b>
</p></tr></td>
</table>
</div>
</BODY>
</HTML>
_HERE_;
exit;
}
#=============#
# ■ 뉴스 #
#=============#
function news($log_file,$ar){
global $pref;

$kinshiarea = '';

$loglist = @file($log_file) or ERROR("unable to open log_file","","LIB4",__FUNCTION__,__LINE__);

$getmonth=$getday=$cnt=0;
$log = array();
foreach ($loglist as $loglisttmp){
	list($gettime,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_f_name2,$w_l_name2,$w_sex2,$w_cl2,$w_no2,$getkind,$host)= explode(",",$loglisttmp);
	list($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($gettime);
	if($hour < 10){$hour = "0$hour";}
	if ($min < 10){$min = "0$min";}
	$month++;
	$year += 1900;
	$weekday_array=array("일","월","화","수","목","금","흙");
	$week = $weekday_array[$wday];
	if (($getmonth != $month)||($getday != $mday)){
		if ($getmonth !=0){array_push($log,"</LI></UL>");}
		$getmonth=$month;$getday = $mday;
		array_push($log,"<P><font color=\"lime\"><B>{$month}월{$mday}일 ({$week}요일)</B></font><BR><UL>");
	}

	$wethe = "";
	$w_name = "{$w_f_name} {$w_l_name}({$w_cl} {$w_sex}{$w_no}차례)";
	$w_name2 = "{$w_f_name2} {$w_l_name2}({$w_cl2} {$w_sex2}{$w_no2}차례)";
	if	 (preg_match("/DEATH/",$getkind)){	#사망
		if	  ($getkind == "DEATH0"){	#사망(함정)
			array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"red\"><b>{$w_name}</b></font> 가 <font color=\"red\">함정</font> 에 의해 사망했다.<font color=\"red\"><b>{$host}</b></font><BR>");
		}elseif($getkind == "DEATH1"){	#사망(독살)
			array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"red\"><b>{$w_name}</b></font> 가 <font color=\"red\">독</font> 에 의해 사망했다.<font color=\"red\"><b>{$host}</b></font><BR>");
		}elseif($getkind == "DEATH2"){	#사망(타살)
			array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"red\"><b>{$w_name}</b></font> 가 <font color=\"red\">$w_name2</font> 에 의해 사망했다.<font color=\"red\"><b>{$host}</b></font><BR>");
		}elseif($getkind == "DEATH3"){	#사망(타살)
			array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"red\"><b>{$w_name}</b></font> 가 <font color=\"red\">$w_name2</font> 에 의해 사망했다.<font color=\"red\"><b>{$host}</b></font><BR>");
		}elseif($getkind == "DEATH4"){	#사망(정부)
			array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"red\"><b>{$w_name}</b></font> 가 <font color=\"red\">정부</font> 에 의해 사망했다.<font color=\"red\"><b>{$host}</b></font><BR>");
		}elseif($getkind == "DEATHAREA"){#사망(금지 에리어)
			array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"red\"><b>{$w_name}</b></font> 가 <font color=\"red\">금지 에리어</font> 이기 때문에, 사망했다.<font color=\"red\"><b>{$host}</b></font><BR>");
		}
	}elseif(preg_match("/G-/",$getkind)){	#그룹
		if	  ($getkind == "G-DATT"){	#그룹 탈퇴
			array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"skyblue\"><b>{$w_name}</b></font> 가 그룹 <font color=\"skyblue\"><b>【{$host}】</b></font> 를 탈퇴했다.<BR>");
		}elseif($getkind == "G-JOIN"){	#그룹 결성
			array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"skyblue\"><b>{$w_name}</b></font> 가 그룹 <font color=\"skyblue\"><b>【{$host}】</b></font> 를 결성했다.<BR>");
		}elseif($getkind == "G-KANYU"){	#그룹 가입
			array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"skyblue\"><b>{$w_name}</b></font> 가 그룹 <font color=\"skyblue\"><b>【{$host}】</b></font> 에 가입했다.<BR>");
		}
	}elseif($getkind == "ITEM_J"){		#ITEM 양도
		@list($i_name,$i_kind) = explode("<>",$host);
		if	(preg_match("/HH|HD/",$i_kind))	{$itemtype = "【회복：체력】";}
		elseif	(preg_match("/SH|SD/",$i_kind))	{$itemtype = "【회복：스태미너】";}
		elseif	($i_kind == "TN")	{$itemtype = "【함정】";}
		elseif	(preg_match("/W/",$i_kind))	{$itemtype = "【무기：";
			if	(preg_match("/G/",$i_kind))	{$itemtype = ($itemtype . "총");
				if	(preg_match("/S/",$i_kind))	{$itemtype = ($itemtype . "-소음");}
				$itemtype = ($itemtype . ")");}
			if	(preg_match("/K/",$i_kind))	{$itemtype = ($itemtype . "참");}
			if	(preg_match("/C/",$i_kind))	{$itemtype = ($itemtype . "투");}
			if	(preg_match("/B/",$i_kind))	{$itemtype = ($itemtype . "구");}
			if	(preg_match("/D/",$i_kind))	{$itemtype = ($itemtype . "폭");}
			$itemtype = ($itemtype . "】");}
		elseif	(preg_match("/D/",$i_kind))	{$itemtype = "【방어구：";
			if	(preg_match("/B/",$i_kind))	{$itemtype = ($itemtype . "몸");}
			if	(preg_match("/H/",$i_kind))	{$itemtype = ($itemtype . "머리");}
			if	(preg_match("/F/",$i_kind))	{$itemtype = ($itemtype . "다리");}
			if	(preg_match("/A/",$i_kind))	{$itemtype = ($itemtype . "팔");}
				if	(preg_match("/K/",$i_kind))	{$itemtype = ($itemtype . "-대：참");}
			$itemtype = ($itemtype . "】");}
		elseif(($i_kind == "R1")||($i_kind == "R2")) {$itemtype = "【레이더-】";}
		elseif($i_kind == "Y") {
			if(($i_name == "가짜 프로그램 해제 키")||($i_name == "프로그램 해제 키")) {$itemtype = "【해제 키】";}
			elseif($i_name == "탄환") {$itemtype = "【탄】";}
			else {$itemtype = "【도구】";}}
		elseif($i_kind == "A") {$itemtype = "【장식품】";}
		else {$itemtype = "【불명】";}
		array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"#00ffff\"><b>{$w_name}</b></font> 가 <font color=\"#00ffff\">$w_name2</font> 에 <font color=\"#00ffff\"><b>아이템 $itemtype</b></font> 를 양도했다.<BR>");
	}elseif($getkind == "HACK"){		#HACK 성공
		array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"#CA9DE1\"><b>{$w_name}</b></font> 가 <font color=\"red\">해킹</font> 에 성공했다.<font color=\"red\"><b>{$host}</b></font><BR>");
	}elseif($getkind == "WINNER"){	#종료
		$log_num = array_pop($log);
		if (preg_match("/우승자/",$log_num)){array_push($log,$log_num);}
		else{array_push($log,$log_num) ;array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"lime\"><b>우승자·{$w_name}</B></font> <BR>");}
	}elseif($getkind == "END"){	#종료
		$log_num = array_pop($log);
		if (preg_match("/게임 종료/",$log_num)){array_push($log,$log_num);}
		else{array_push($log,$log_num) ;array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"lime\"><b>게임 종료·이상본프로그램 실시 본부 선수 확인 모니터보다</B></font> <BR>");}
	}elseif ($getkind == "EX_END"){	#프로그램 정지
		$log_num = array_pop($log);
		if (preg_match("/게임 종료/",$log_num)){array_push($log,$log_num);}
		else{
			array_push($log,$log_num);
			array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"lime\"><b>게임 종료·프로그램 긴급정지</B></font> <BR>") ;
		}
	}elseif(($getkind == "AREA")&&($ar != '')){	#금지 에리어 추가
		$log_num = array_pop($log);
		if ($w_cl != ""){$wethe = "<font color=\"orange\">【날씨:".$pref['weather'][$w_cl]."】</font>";}
		if ((!preg_match("/게임 종료/",$log_num))||(!preg_match("/<UL>/",$log_num))){
			array_push($log,$log_num);

			#CONF
			$pgsplit = 8;
			
			$kinshi0 = $w_sex;
			$kinshi1 = $w_sex + $pgsplit;
			$kinshi2 = $w_sex + $pgsplit + $pgsplit;
			$kinshi3 = $w_sex + $pgsplit + $pgsplit + $pgsplit;
			
			if($kinshi0 < 10){$kinshi0 = '0'.$kinshi0;}
			if($kinshi1 >= 24){$kinshi1 -= 24;}
			if($kinshi2 >= 24){$kinshi2 -= 24;}
			if($kinshi3 >= 24){$kinshi3 -= 24;}
			if($kinshi1 < 10){$kinshi1 = '0'.$kinshi1;}
			if($kinshi2 < 10){$kinshi2 = '0'.$kinshi2;}
			if($kinshi3 < 10){$kinshi3 = '0'.$kinshi3;}
			
			$kinshi = array($kinshi0,$kinshi1,$kinshi2,$kinshi3);


			if(isset($pref['place'][$ar[$w_f_name]])){
				$add = "다음 번 금지 에리어는 <font color=\"lime\">{$kinshi[1]}시에 <b>".$pref['place'][$ar[$w_f_name]];
				if(isset($pref['place'][$ar[$w_f_name+1]])){
					$add .= ",</b>{$kinshi[2]}시에 <b>".$pref['place'][$ar[$w_f_name+1]];
					if(isset($pref['place'][$ar[$w_f_name+2]])){
						$add .= ",</b>".$kinshi[3]."시간에 <b>".$pref['place'][$ar[$w_f_name+2]]."</b></font>.";
					}else{
						$add .= "</b></font>.";
					}
				}else{
					$add .= "</b></font>.";
				}
			}

			array_push($log,"<LI>{$kinshi[0]}시 00분 ,<font color=\"lime\"><b>".$pref['place'][$ar[$w_l_name]]."</b></font> 하지만 금지 에리어로 지정되었다.{$add}{$wethe}<BR>") ;

			if ($kinshiarea == 0){$kinshiarea = $w_sex;}
		}else{array_push($log,$log_num);}
	} elseif ($getkind == "HKARAD"){	#핵시 금지 에리어 추가
		$log_num = array_pop($log);
		if ($w_cl != ""){$wethe = "<font color=\"orange\">【날씨:".$pref['weather'][$w_cl]."】</font>";}
		if ((!preg_match("/게임 종료/",$log_num))||(!preg_match("/<UL>/",$log_num))){
			array_push($log,$log_num) ;$hkrem = $w_l_name*8;

			#CONF
			$pgsplit = 8;

			$kinshi0 = $w_sex;
			$kinshi1 = $w_sex + $pgsplit;
			$kinshi2 = $w_sex + $pgsplit + $pgsplit;
			$kinshi3 = $w_sex + $pgsplit + $pgsplit + $pgsplit;
			
			if($kinshi0 < 10){$kinshi0 = '0'.$kinshi0;}
			if($kinshi1 >= 24){$kinshi1 -= 24;}
			if($kinshi2 >= 24){$kinshi2 -= 24;}
			if($kinshi3 >= 24){$kinshi3 -= 24;}
			if($kinshi1 < 10){$kinshi1 = '0'.$kinshi1;}
			if($kinshi2 < 10){$kinshi2 = '0'.$kinshi2;}
			if($kinshi3 < 10){$kinshi3 = '0'.$kinshi3;}
			
			$kinshi = array($kinshi0,$kinshi1,$kinshi2,$kinshi3);

			if(isset($pref['place'][$ar[$w_f_name]])){
				$add = "다음 번 금지 에리어는 <font color=\"lime\">{$kinshi[1]}시에 <b>".$pref['place'][$ar[$w_f_name]];
				if(isset($pref['place'][$ar[$w_f_name+1]])){
					$add .= ",</b>{$kinshi[2]}시에 <b>".$pref['place'][$ar[$w_f_name+1]];
					if(isset($pref['place'][$ar[$w_f_name+2]])){
						$add .= ",</b>{$kinshi[3]}시에 <b>".$pref['place'][$ar[$w_f_name+2]]."</b></font>.";
					}else{
						$add .= "</b></font>.";
					}
				}else{
					$add .= "</b></font>.";
				}
			}

			array_push($log,"<LI>{$kinshi[0]}시 00분 , 관리 시스템 재개까지 남아<font color=\"lime\"><b>{$hkrem}</b></font> 시간.{$add}{$wethe}<BR>") ;

			if ($kinshiarea == 0){$kinshiarea = $w_sex;}
		}else{array_push($log,$log_num);}
	} elseif ($getkind == "ENTRY"){	#신규 등록
		if (($host != "")&&($pref['host_view'])) {$host = "($host)"; }
		array_push($log,"<LI>{$hour}시{$min}분 ,<font color=\"yellow\"><b>{$w_name}</b></font> 가 전학가 왔다.<font color=\"black\">$host</font><BR>") ;
	} elseif ($getkind == "NEWGAME"){#관리인에 의한 데이터 초기화
		if (isset($pref['weather'][$w_f_name])){$wethe = "<font color=\"orange\">【날씨:".$pref['weather'][$w_f_name]."】</font>";}
		array_push($log,"<LI>{$hour}시{$min}분 , 신규 프로그램 개시.{$wethe}<BR>") ;
	}
	$cnt++;
}
$log = implode("",$log);
return $log;
}
?>