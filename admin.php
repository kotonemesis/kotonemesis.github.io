<?php
$ADMINLOCK = 1;require "pref.php";
#□■□■□■□■□■□■□■□■□■□■□
#■ 	- BR ADMINISTRATOR SCRIPT - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ Cokkie		-	락 해제 확인부	 ■
#□ LOCKOFF		-	커멘드 처리		 □
#■ RESET		-	초기화 MAIN 화면		 ■
#□ MAIN		-	메인 기능			 □
#■ MENU		-	메뉴 화면		 ■
#□ BACKSAVE	-	백업 보존	 □
#■ BACKREAD	-	백업독입	 ■
#■ ADMDECODE	-	디코드 처리		 ■
#□ USERLIST	-	일람표시처리		 □
#□ ENTER		-	입					 □
#■ USERKIL		-	살해 처리			 ■
#■ USERDEL		-	삭제 처리			 ■
#□■□■□■□■□■□■□■□■□■□■□

if(isset($_GET['Command']) && $_GET['Command'] == "LOCKOFF"){#락은 도시
	$admin = @file($pref['admin_file']) or ERROR("unable to open admin_file");
	if($_GET['id'] == $admin){
		LOCKOFF() ;UNLOCK() ;exit;
	}
}

#if(!$p_flag){ERROR("부정 액세스입니다.");}

$pref['a_pass'] = crypt($pref['a_pass'],"2Y");
if(isset($admpas)){$admpass = crypt($admpas,"2Y");}
if($admpass == $pref['a_pass']){
	if	  ($in['Command'] == "MAIN")		{MENU();}											#메뉴
	elseif($in['Command'] == "BSAVE")		{BACKSAVE();}										#백업 보존
	elseif($in['Command'] == "BREAD")		{BACKREAD();}										#백업 읽기
	elseif($in['Command'] == "RESET")		{RESETBR();}										#리셋트
	elseif($in['Command'] == "ITEMLIST")	{require $pref['LIB_DIR'].'/adm_itm.php';ITEMLIST();}	#아이템 리스트
	elseif($in['Command'] == "RESETACC")	{require $pref['LIB_DIR'].'/adm_res.php';DATARESET();}	#데이터 리셋트
	elseif($in['Command'] == "USERLIST")	{USERLIST();}										#유저 리스트 일람
	elseif($in['Command'] == "USERKIL")	{USERKIL();}											#유저 살해
	elseif($in['Command'] == "USERDEL")	{USERDEL();}											#유저 삭제
	elseif($in['Command'] == "USERCHG")	{require $pref['LIB_DIR'].'/adm_chg.php';USERCHG();}	#유저 변경
	elseif($in['Command'] == "USERCHG3")	{require $pref['LIB_DIR'].'/adm_chg.php';USERCHG3();}#유저 변경
	elseif($in['Command'] == "ENTER")		{ENTER();}											#Admin Entrance
	elseif($in['Command'] == "LOGON")		{MAIN();}											#메인
	elseif($in['Command'] == "DATACHG")	{require $pref['LIB_DIR'].'/adm_chg.php';DATACHG();}	#데이터 변경
	elseif($in['Command'] == "Cokkie")	{Cokkie();}												#락 해제 확인부
	elseif($in['Command'] == "LOCKOFF")	{LOCKOFF();}											#락 해제 처리
	else							{MENU();}													#메뉴
}else{MAIN() ;UNLOCK() ;exit;}

UNLOCK();
exit;
#=====================#
# ■ 락 해제 확인부 #
#=====================#
function Cokkie(){
global $pref;

global $admpass;

$admin = @file($pref['admin_file']) or ERROR("unable to open admin_file");
$admin = implode('',$admin);
HEAD();
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
Lock의 해제 키는：$admin<br>
주소는,<A href="./admin.php?Command=LOCKOFF&Id=$admin">./admin.php?Command=LOCKOFF&Id=$admin</A>입니다.

<FORM METHOD="POST" ACTION="admin.php">
<INPUT type="hidden" name="Password" value="<?=$admpass?>">
<INPUT type="hidden" name="Command" value="LOCKOFF">
<INPUT type="submit" name="Enter" value="LOCK(을)를 해제한다">
</FORM>

_HERE_;

@list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$_COOKIE['BR']);

FOOTER();
exit;
}
#===================#
# ■ 락 해제 처리 #
#===================#
function LOCKOFF(){
global $pref;

@list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$_COOKIE['BR']);
setcookie("BR",'',$pref['now'] + $pref['save_limit'] * 86400);

$new = rand($pref['now']);


$admin = @file($pref['admin_file']) or ERROR("unable to open admin_file");
$admin[0] = $new;
$handle = @fopen($pref['admin_file'],'w') or ERROR("unable to open admin_file");
if(!@fwrite($handle,implode("",$admin))){ERROR("unbale to write admin_file");}
fclose($handle);


HEAD();
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
LOCK를 떼었습니다.<br>
<br><B><FONT color="#ff0000">>><a href="index.php">HOME</a> >><a href="admin.php">ADMIN</a></b></FONT>
_HERE_;
FOOTER();
}
#===================#
# ■ 초기화 MAIN 화면 #
#===================#
function RESETBR(){
global $admpass;
HEAD();
?>
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
<FORM name="BR" METHOD="POST" ACTION="admin.php">
<TABLE border="0">
<TR><TD>
<INPUT type="hidden" name="Password" value="<?=$admpass?>">
<INPUT type="hidden" name="Command" value="RESETACC">
<font color="00FFFF"><b><center><font size="+3" color="blue">※경고※</font><br><br>여기는 정보 조작을 하는 CORE 부분입니다.<BR>Administrator로 없는 경우는 즉시 떠나 주세요<br>만약, 마음대로 삭제했을 경우, 그만한 책임을 질 필요가 있습니다.<br></Center><BR>
<br>
프로그램 설정：<br>
프로그램 개시 일시：<input type="text" name="res_y" value="<?=date('Y');?>" size="4" maxlength="4">년<input type="text" name="res_m" value="<?=date('n');?>" size="2" maxlength="2">월<input type="text" name="res_d" value="<?=date('d')+1;?>" size="2" maxlength="2">일<input type="text" name="res_j" value="00" size="2" maxlength="2">시<input type="text" name="res_f" value="00" size="2" maxlength="2">분<br>
<input type=checkbox name=RESET11 value="1" class="b4" checked> 상기의 일자에 개시<br>
<input type=checkbox name=RESET12 value="1" class="b4" checked> 사전 접수<br>
<br>
<input type=checkbox name=RESET0 value="1" class="b4" checked> NPC 초기화<br>
<input type=checkbox name=RESET1 value="1" class="b4" checked> 시간 초기화<br>
<input type=checkbox name=RESET2 value="1" class="b4" checked> 학생 번호 초기화<br>
<input type=checkbox name=RESET3 value="1" class="b4" checked> 금지 에리어 초기화<br>
<input type=checkbox name=RESET4 value="1" class="b4" checked> 로그의 초기화 및 프로그램 개시 로그 추가<br>
<input type=checkbox name=RESET5 value="1" class="b4" checked> 아이템 로그 초기화<br>
<input type=checkbox name=RESET6 value="1" class="b4" checked> 총성 로그 초기화<br>
<input type=checkbox name=RESET7 value="1" class="b4" checked> 유저 보존 데이터 폴더 삭제<br>
<input type=checkbox name=RESET8 value="1" class="b4" checked> Flag 파일 갱신<br>
<input type=checkbox name=RESET10 value="1" class="b4" checked> BR개최 회수 수치 UP<br>
<hr>
<input type=checkbox name=RESET9 value="1" class="b4">경고에 동의 및 삭제 개시<br>
</b></FONT>
</TD></TR>
</TABLE>
<BR><INPUT type="submit" name="Enter" value="결정">
</FORM>
<?
FOOTER();
}
#===============#
# ■ 메인 기능 #
#===============#
function MAIN(){
HEAD();
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
<FORM name="BR" METHOD="POST" ACTION="admin.php">
관리용 패스워드
<INPUT TYPE="HIDDEN" NAME="Command" VALUE="MAIN">
<INPUT size="16" type="password" name="Pass" maxlength="16">
　<INPUT type="submit" name="Enter" value="결정">
</FORM>
_HERE_;
FOOTER();
}

#=================#
# ■ 메뉴 화면 #
#=================#
function MENU(){
global $pref;
global $admpass;
HEAD();
if($pref['MOBILE']){
?>
<center><font color="#FF0000" face="MS P내일 아침" size="6">Administrative Mode</font></center>
<FORM METHOD="POST" name="BR" ACTION="admin.php">
<INPUT type="hidden" name="Password" value="<?=$admpass?>">
<INPUT type="radio" name="Command" value="USERLIST">유저 일람<BR>
<INPUT type="radio" name="Command" value="ITEMLIST">아이템 일람<BR>
<INPUT type="radio" name="Command" value="Cokkie">User Lock<BR>
<INPUT type="radio" name="Command" value="ITEMCHG">ITEM Data Changer<BR>
<FONT COLOR="RED" size="1">
<INPUT type="radio" name="Command" value="SETTIME">다음 번 프로그램 개최 예정일<BR>
<INPUT type="radio" name="Command" value="BSAVE">백업 보존<BR>
<INPUT type="radio" name="Command" value="BREAD">백업독입<BR>
<INPUT type="radio" name="Command" value="RESET">데이터 초기화<BR>
</FONT>
<BR><INPUT type="submit" name="Enter" value="결정">
</FORM>
<?
}else{
?>
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
<FORM METHOD="POST" name="BR" ACTION="admin.php">
<TABLE border="0">
<TR><TD>
<INPUT type="hidden" name="Password" value="<?=$admpass?>">
<?Auto();?><INPUT type="radio" name="Command" value="USERLIST">유저 일람</A><BR>
<?Auto();?><INPUT type="radio" name="Command" value="ITEMLIST">아이템 일람</A><BR>
<?Auto();?><INPUT type="radio" name="Command" value="Cokkie">User Lock</A><BR>
<?Auto();?><INPUT type="radio" name="Command" value="ITEMCHG">ITEM Data Changer</A><BR>
</td><td width="10">　</td><td>
<FONT COLOR="RED" size="1">
<?Auto();?><INPUT type="radio" name="Command" value="SETTIME">다음 번 프로그램 개최 예정일</A><BR>
<?Auto();?><INPUT type="radio" name="Command" value="BSAVE">백업 보존</A><BR>
<?Auto();?><INPUT type="radio" name="Command" value="BREAD">백업독입</A><BR>
<?Auto();?><INPUT type="radio" name="Command" value="RESET">데이터 초기화</A>
</FONT>
</TD></TR>
</TABLE>
<BR><INPUT type="submit" name="Enter" value="결정">
</FORM>
<?
}
FOOTER();
}
/*
#=====================#
# ■ 백업 보존 #
#=====================#
function BACKSAVE(){

	open(DB,"$pref['user_file']") ;seek(DB,0,0); @userlist=<DB>;close(DB);
	open(DB,">$pref['back_file']"); seek(DB,0,0); print DB @userlist; close(DB);

&HEADER;
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
백업을 작성했습니다.<br>
<br><B><FONT color="#ff0000">>><a href="index.php">HOME</a> >><a href="admin.php">ADMIN</a></b></FONT>
_HERE_;
&FOOTER;

}
#=====================#
# ■ 백업독입 #
#=====================#
function BACKREAD{

open(DB,"$pref['back_file']") ;seek(DB,0,0); @userlist=<DB>;close(DB);
open(DB,">$pref['user_file']"); seek(DB,0,0); print DB @userlist; close(DB);

&HEADER;
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
백업을 독입했다.<br>
<br><B><FONT color="#ff0000">>><a href="index.php">HOME</a> >><a href="admin.php">ADMIN</a></b></FONT>
_HERE_;
&FOOTER;
}*/
#=================#
# ■ 디코드 처리 #
#=================#
function ADMDECODE(){
global $in;

$p_flag=0;
//디코드 처리
global $id,$admpass,$admpas;

//command == RESETACC
global $RESET0,$RESET1,$RESET2,$RESET3,$RESET4,$RESET5,$RESET6,$RESET7,$RESET8,$RESET9,$RESET10,$RESET11,$RESET12;
global $res_y,$res_m,$res_d,$res_j,$res_f,$res_b;
//array set
if(isset($_POST['DEL'])){global $DEL;$subDEL = $_POST{'DEL'};$_POST['DEL']=true;}

if($_SERVER['REQUEST_METHOD'] == "POST") {
	if($_SERVER['CONTENT_LENGTH'] > 51200){error("투고량이 너무 큽니다");}
	#$_POST = array_map("DECODE2", $_POST);
	$in = array_map("trim", $_POST);
}else {
	$in = array_map("DECODE2", $_POST);
}
extract($in);

//array set
if(isset($DEL)){$DEL = $subDEL;}

if(isset($Id)){$in['Id'] = $Id;}
if(isset($Password)){$admpass = $Password;}
if(isset($Pass)){$admpas = $Pass;}

if(isset($in['Command']) && $in['Command'] == "USERCHG3"){
	global $w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item0,$w_eff0,$w_itai0,$w_item1,$w_eff1,$w_itai1,$w_item2,$w_eff2,$w_itai2,$w_item3,$w_eff3,$w_itai3,$w_item4,$w_eff4,$w_itai4,$w_item5,$w_eff5,$w_itai5,$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP;
	$w_id = $in{'w_id'};
	$w_password = $in{'w_password'};
	$w_f_name = $in{'w_f_name'};
	$w_l_name = $in{'w_l_name'};
	$w_sex = $in{'w_sex'};
	$w_cl = $in{'w_cl'};
	$w_no = $in{'w_no'};
	$w_endtime = $in{'w_endtime'};
	$w_att = $in{'w_att'};
	$w_def = $in{'w_def'};
	$w_hit = $in{'w_hit'};
	$w_mhit = $in{'w_mhit'};
	$w_level = $in{'w_level'};
	$w_exp = $in{'w_exp'};
	$w_sta = $in{'w_sta'};
	$w_wep = $in{'w_wep'};
	$w_watt = $in{'w_watt'};
	$w_wtai = $in{'w_wtai'};
	$w_bou = $in{'w_bou'};
	$w_bdef = $in{'w_bdef'};
	$w_btai = $in{'w_btai'};
	$w_bou_h = $in{'w_bou_h'};
	$w_bdef_h = $in{'w_bdef_h'};
	$w_btai_h = $in{'w_btai_h'};
	$w_bou_f = $in{'w_bou_f'};
	$w_bdef_f = $in{'w_bdef_f'};
	$w_btai_f = $in{'w_btai_f'};
	$w_bou_a = $in{'w_bou_a'};
	$w_bdef_a = $in{'w_bdef_a'};
	$w_btai_a = $in{'w_btai_a'};
	$w_tactics = $in{'w_tactics'};
	$w_death = $in{'w_death'};
	$w_msg = $in{'w_msg'};
	$w_sts = $in{'w_sts'};
	$w_pls = $in{'w_pls'};
	$w_kill = $in{'w_kill'};
	$w_icon = $in{'w_icon'};
	$w_item0 = $in{'w_item0'};
	$w_eff0 = $in{'w_eff0'};
	$w_itai0 = $in{'w_itai0'};
	$w_item1 = $in{'w_item1'};
	$w_eff1 = $in{'w_eff1'};
	$w_itai1 = $in{'w_itai1'};
	$w_item2 = $in{'w_item2'};
	$w_eff2 = $in{'w_eff2'};
	$w_itai2 = $in{'w_itai2'};
	$w_item3 = $in{'w_item3'};
	$w_eff3 = $in{'w_eff3'};
	$w_itai3 = $in{'w_itai3'};
	$w_item4 = $in{'w_item4'};
	$w_eff4 = $in{'w_eff4'};
	$w_itai4 = $in{'w_itai4'};
	$w_item5 = $in{'w_item5'};
	$w_eff5 = $in{'w_eff5'};
	$w_itai5 = $in{'w_itai5'};
	$w_log = $in{'w_log'};
	$w_com = $in{'w_com'};
	$w_dmes = $in{'w_dmes'};
	$w_bid = $in{'w_bid'};
	$w_club = $in{'w_club'};
	$w_money = $in{'w_money'};
	$w_wp = $in{'w_wp'};
	$w_wg = $in{'w_wg'};
	$w_wn = $in{'w_wn'};
	$w_wc = $in{'w_wc'};
	$w_wd = $in{'w_wd'};
	$w_comm = $in{'w_comm'};
	$w_limit = $in{'w_limit'};
	$w_bb = $in{'w_bb'};
	$w_inf = $in{'w_inf'};
	$w_ousen = $in{'w_ousen'};
	$w_seikaku = $in{'w_seikaku'};
	$w_sinri = $in{'w_sinri'};
	$w_item_get = $in{'w_item_get'};
	$w_eff_get = $in{'w_eff_get'};
	$w_itai_get = $in{'w_itai_get'};
	$w_teamID = $in{'w_teamID'};
	$w_teamPass = $in{'w_teamPass'};
	$w_IP = $in{'w_IP'};
}

}
#=================#
# ■ 일람표시처리 #
#=================#
function USERLIST(){
global $in,$pref;

global $icon_file,$admpass,$DEL;

$col_s1 = '<font color="white">';
$col_s2 = '<font color="red">';
$col_s3 = '<font color="skyblue">';
$col_e = '</font>';

$userlist = @file($pref['user_file']) or ERROR('unable to open user_file');
HEAD();

?>
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">생존자 일람</span></font></center>
<form method="POST" name="BR" ACTION="admin.php">
삭제 메세지：<INPUT size="64" type="text" name="Message" maxlength="64"><BR><BR>
<TABLE border="1" class="b3" cellspacing="0" cellpadding="0">
<tr align="center" class="b1"><td height="1" class="b1">살</td><TD width="50" class="b1" rowspan="2">아이콘</TD><td width="100" class="b1">이름 [출석 번호]</td><td class="b1">스태미너</td><td width="50" class="b1">체력</td><td class="b1">상태</td><td class="b1">기본 행동</td><td class="b1">장소</td><td class="b1">IP</td><td class="b1">T-NAME</td></tr>
<tr class="b3"><td class="b1">변</td><td class="b1">ID-PASS</td><td class="b1">공격</td><td class="b1">방어</td><TD class="b1" colspan="3">무기</TD><TD class="b1">방어구(몸)</TD><td class="b1">T-PASS</td></tr>
<?
$IPlist=array();
foreach ($userlist as $key => $usrlst){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$usrlst);
	if(in_array($w_IP,$IPlist)){
		foreach($IPlist as $key2 => $IP2){
			if($IP2 == $w_IP){
				$IPlist[$key2]='<b>'.$IP2.'</b>';
			}
		}
		$w_IP = '<b>'.$w_IP.'</b>';
	}
	$IPlist[$key]=$w_IP;
}

foreach ($userlist as $key => $usrlst){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$usrlst);
	$col_s = $col_s1;
	if(preg_match('/병사|감사계|판지/',$w_f_name)){$col_s = $col_s3;$w_password = 'N/A';$w_teamPass = 'N/A';}
	if($w_hit <= 0){$col_s = $col_s2; $w_sts = '사망';}
	print '<tr><td><input type="checkbox" name="DEL[]" value="'.$key.'" class="b2"></td><TD rowspan="2" class="b3"><IMG src="'.$pref['imgurl'].'/'.$icon_file[$w_icon].'" width="50" height="50" border="0" align="middle"></TD><td align="center" class="b3">'.$col_s.$w_f_name.' '.$w_l_name.' ['.$w_cl.']'.$col_e.'</td><td class="b3">'.$col_s.$w_sta.$col_e.'</td><td class="b3">'.$col_s.$w_hit.'/'.$w_mhit.$col_e.'</td><td class="b3">'.$col_s.$w_sts.$col_e.'</td><td class="b3">'.$col_s.$w_tactics.$col_e.'</td><td class="b3">'.$col_s.$pref['place'][$w_pls].$col_e.'</td><td class="b3">'.$col_s.$IPlist[$key].$col_e.'</td><td class="b3">'.$col_s.$w_teamID.$col_e.'</td></tr>
		   <tr><td class="b3">　</td><td class="b3"><font color="#444444">'.$w_id.' - '.$w_password.'</font></td><TD class="b3">'.$col_s.$w_att.$col_e.'</TD><TD class="b3">'.$col_s.$w_def.$col_e.'</TD><TD class="b3" colspan="3">'.$col_s.$w_wep.' / '.$w_watt.' / '.$w_wtai.$col_e.'</TD><TD class="b3">'.$col_s.$w_bou.' / '.$w_bdef.' / '.$w_btai.$col_e.'</TD><td class="b3">'.$col_s.$w_teamPass.$col_e.'</td></tr>';
}
?>
</table><BR>
<table border="2" class="b1"><TR class="b2"><TD class="b2"><b><font size="+1"><?Auto();?><input type=radio name="Command" value="USERKIL" class="b2"><font color=red>　살　　</a></font><?Auto();?><input type=radio name="Command" value="USERDEL" class="b2"><font color=yellow>　소　　</a></font><?Auto();?><input type=radio name="Command" value="USERCHG" class="b2"><font color=yellow>　변　　</a></font><?Auto();?><input type=radio name="Command" value="ENTER" class="b2"><font color=skyblue>　입</a></font></font><b></TD></TR></table><BR>
<input type=hidden name=Password value=<?=$admpass?>><input type=submit value="실행"><input type=reset value="리셋트"></form>COMMAND:
<?
if(isset($deluser)){print $deluser;}
if(isset($DEL) && $DEL != ''){$DEL = implode(',',$DEL) ;print '|'.$DEL;}
print '|'.$Command;
FOOTER();

}
#=======#
# ■ 입 #
#=======#
function ENTER(){
global $pref;

global $DEL;
$userlist = @file($pref['user_file']) or ERROR('unable to open user_file');

foreach ($DEL as $delete){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$delete]);
}
HEAD();
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
<B><FONT color="#ff0000" size="+1">-전송 합니다―</FONT></B><BR>
<FORM METHOD="POST" name="BR" ACTION="BR.php">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="main">
<INPUT TYPE="HIDDEN" NAME="Id" VALUE="$w_id">
<INPUT TYPE="HIDDEN" NAME="Password" VALUE="$w_password">
<h2>${w_f_name} ${w_l_name}(${w_cl} ${w_sex}${w_no}차례)</h2>
<h5><font color="Yellow">관리자 권한이 있는 사람 의외는 다른 유저의 데이터에 들어가는 것은 금지되고 있습니다.</font></h5>
<INPUT type="submit" name="Enter" value="개시">
</FORM>
_HERE_;
FOOTER();
exit;
}
#=============#
# ■ 살해 처리 #
#=============#
function USERKIL(){
global $in,$pref;

global $DEL;
$userlist = @file($pref['user_file']) or ERROR("unable to open user_file");

require_once $pref['LIB_DIR']."/lib4.php";

foreach($DEL as $delete){
	global $w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item0,$w_eff0,$w_itai0,$w_item1,$w_eff1,$w_itai1,$w_item2,$w_eff2,$w_itai2,$w_item3,$w_eff3,$w_itai3,$w_item4,$w_eff4,$w_itai4,$w_item5,$w_eff5,$w_itai5,$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP;
	global $deth;
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$delete]);
	$w_msg = $in['Message'];
	LOGSAVE2("DEATH4");
	$w_hit = 0;$w_sts = "사망"; $w_death=$deth;
	$userlist[$delete] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,\n";
}

$handle = @fopen($pref['user_file'],'w') or ERROR("unable to open user_file");
if(!@fwrite($handle,implode('',$userlist))){ERROR("unable to write user_file");}
fclose($handle);

USERLIST();
}
#=============#
# ■ 삭제 처리 #
#=============#
function USERDEL(){
global $pref,$DEL;

$userlist = @file($pref['user_file']) or ERROR("unable to open user_file");

foreach($DEL as $delete){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$delete]);
#	local($deluser) = splice(@userlist,$userlist[$DEL[$_]],1);#취득 아이템 삭제
	$userlist[$delete] = "";
}

$handle = @fopen($pref['user_file'],'w') or ERROR("unable to open user_file");
if(!@fwrite($handle,implode('',$userlist))){ERROR("unable to write user_file");}
fclose($handle);

USERLIST();
}