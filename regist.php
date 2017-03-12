<?php
/*#
□■□■□■□■□■□■□■□■□■□■□
#■ 	-     BR USER REGISTER     - 	 ■
#□ 									 □
#■ 		써브루틴 일람			 ■
#□ 									 □
#■ checker		-	확인				 ■
#□ MAIN		-	메인				 □
#■ REGIST		-	등록 처리			 ■
#□ INFO		-	설명 처리			 □
#■ CLUBMAKE	-	클럽 작성			 ■
#□■□■□■□■□■□■□■□■□■□■□
*/
$regist = 1;
require "pref.php";

CREAD();

if		($in['mode'] == 'regist')	{REGIST();}	#등록 처리
elseif	($in['mode'] == 'info')		{INFO();}	#설명 처리
elseif	($in['mode'] == 'icon')		{ICON();}	#아이콘 일람
else								{MAIN();}	#메인
//UNLOCK();
exit;

#===========#
# ■ 확인	#
#===========#
function checker(){
global $pref;

global $fl,$ar,$c_endtime,$c_id,$host;

if(!isset($pref['plimit']) || $pref['plimit']==0){$pref['plimit'] = 4;}
$t_limit = $pref['plimit'];

if((isset($fl)&& preg_match('/종료/',$fl))||($ar >= $t_limit)){
	ERROR('Currently, no more new registration is offered.<br><br>　Please wait until next session starts.','no more registration','REGIST',__FUNCTION__,__LINE__);
}

list($ar,$hackflg,$a) = explode(',',$pref['arealist'][1]);

list($pre_reg,$res_y,$res_m,$res_d,$res_j,$res_f,$res_b) = explode(',',trim($pref['arealist'][7]));
list($y,$m,$d,$hh,$mm) = explode(',',trim($pref['arealist'][0]));

if(!$ar && (mktime($hh,$mm,0,$m,$d,$y) != mktime($res_j,$res_f,0,$res_m,$res_d,$res_y))){
	ERROR('We are not currently accepting pre-registrations.<br><br>　Please wait until next session.','no more registration','REGIST',__FUNCTION__,__LINE__);
}

$chktim = $c_endtime + (1*60*60*2);	#사망 시간 취득
list($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($chktim);
$year+=1900; $month++;

if($chktim > $pref['now']){#등록시간 에러?
	ERROR('You may not register for 2 hours after death.<br><br>　Time you can register again：'.$year.'/'.$month.'/'.$mday.' '.$hour.':'.$min.':'.$sec,'Cannot Register for 2 hours after death','REGIST',__FUNCTION__,__LINE__);
}

#유저 파일 취득
$userlist = @file($pref['user_file']) or ERROR('unable to open file user_file','','REGIST',__FUNCTION__,__LINE__);

if((count($userlist) - $pref['npc_num']) >= $pref['maxmem']){#최대 인원수 초과?
	ERROR('We are sorry to notify you that, current session is full since there are ('.$pref['maxmem'].'사람) players','Too much player','REGIST',__FUNCTION__,__LINE__);
}

#중복 체크
foreach($userlist as $userlist2){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist2);
	if(($c_id != '')&&($c_id == $w_id)&&($c_password == '')&&($c_password == $w_password)&&($w_sts != '사망')){#동일 ID or 동성 동명?
		ERROR('You may not register more than one user account.HOST ID:'.$in['IPAdd'].'-'.$w_f_name.'-'.$w_l_name,'Lock Matched','REGIST-checker');
	}
	if($w_sts != '사망' && ($w_IP != '' && (strpos($host,$w_IP)!==FALSE || strpos($w_IP,$host)!==FALSE)) && $host != $pref['SubS']){#동일 ID or 동성 동명?
		ERROR('캐릭터의 복수 등록은 금지하고 있습니다.관리인에게 문의해 주세요.COMMENT:USED SAME PC HOST:'.$host,'Host Matched','REGIST-checker');
	}
}
}
#===============#
# ■ 메인		#
#===============#
function MAIN($REG_ERR=''){
global $in,$pref;
$hostchk = 0;

global $host,$icon_name,$icon_check1,$icon_check2,$icon_check3,$icon_check4;

#if(($pref['SubServer'])&&($host == "209.137.141.2")){$hostchk=1;$host = $in['IPAdd'];if($in['IPAdd'] == ""){ERROR("케이오생은 TOP PAGE로부터 액세스 해 주세요","","REGIST",__FUNCTION__,__LINE__);}}
#if($host == "209.137.141.2"){$hostchk=1;}

$REGIST=1;
HEAD();
if($pref['MOBILE']){

	if($pref['mobile_regist']){//휴대 금지
		ERROR('휴대 전화로부터의 등록은 금지하고 있습니다.','registration from mobile phone is forbidden','REGIST',__FUNCTION__,__LINE__);
	}else{
?>
<big>Registration</big><BR>
<BR>
So you are new student here? I am your homeroom teacher, Mr. Appleseed.<BR>Welcome to Otonokizaka.<BR>Here is the home of School Idol Group...<BR><BR>So, Write information about yourself,<BR>and turn this document in!
<?=$REG_ERR?>
<FORM METHOD="get"  ACTION="regist.php" name="Regist">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="regist">
<?/*<!--INPUT TYPE="HIDDEN" NAME="IP" VALUE="$host"-->*/?>
Last Name：<INPUT size="10" type="text" name="F_Name" maxlength="50" value="<?=$in['F_Name']?>"><BR>
First Name：<INPUT size="10" type="text" name="L_Name" maxlength="50" value="<?=$in['L_Name']?>"><BR>
(Maximum length: 50 characters)<BR>
<BR>
Avatar：<SELECT name="Icon">
<?
	}
}else{
	REG_HEAD();
?>
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Transfer Process</span></font></center>
<BR><BR><img border="0" src="<?=$pref['imgurl']?>/i_hayashida.jpg" width="70" height="70"><BR><BR>
So you transferred here in Otonokizaka? I am your homeroom teacher Mr. Appleseed.<BR>Welcome to Otonokizaka.<BR>Here is the home of School Idol Group...<BR><BR>So, Write information about yourself,<BR>and turn this document in!
<?=$REG_ERR?>
<form method="post" action="regist.php" name="Regist">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="regist">
<?/*<!--INPUT TYPE="HIDDEN" NAME="IP" VALUE="$host"-->*/?>
Last Name：<INPUT size="10" type="text" name="F_Name" maxlength="50" value="<?=$in['F_Name']?>"><BR>
First Name：<INPUT size="10" type="text" name="L_Name" maxlength="50" value="<?=$in['L_Name']?>"><BR>
(Maximum length: 50 characters)<BR>
<BR>
<div id="SubMenu" class="SubMenu" height="70"><img src="<?=$pref['imgurl']?>/question.gif" ALIGN=middle alt="Question"></div>
Avatar：<SELECT name="Icon" onchange="Mover()">
<?
}
?>
<OPTION value="NOICON">　-　Avatar　-<BR><OPTION value="NOICON">　　µ's<BR>
<?for($i=1;$i<$icon_check1;$i++){echo '<OPTION value="'.$i.'"';if($i==$in['Icon']){echo ' selected';}echo '>'.$icon_name[$i].'<BR>';}?>
<OPTION value="NOICON">　　Aqours<BR>
<?for($i;$i<$icon_check2;$i++){echo '<OPTION value="'.$i.'"';if($i==$in['Icon']){echo ' selected';}echo '>'.$icon_name[$i].'<BR>';}?>
<OPTION value="NOICON">　　NPC<BR>
<?for($i;$i<$icon_check3;$i++){echo '<OPTION value="'.$i.'"';if($i==$in['Icon']){echo ' selected';}echo '>'.$icon_name[$i].'<BR>';}?>
<OPTION value="NOICON">　　Special<BR>
<?for($i;$i<$icon_check4;$i++){echo '<OPTION value="'.$i.'"';if($i==$in['Icon']){echo ' selected';}echo '>'.$icon_name[$i].'<BR>';}?>
</SELECT><BR>[<a href="regist.php?mode=icon" target="_blank">Available Avatars</a>]<BR><BR>
Club：<SELECT name="club1">
<OPTION value="NOCLB" selected>　　　【1st Wanted】<BR>
<?for($i=0;$i<count($pref['clb'])-2;$i++){echo '<OPTION value="'.$i.'"';if(isset($in['club1']) && $in['club1']!='NOCLB' && $i==$in['club1']){echo ' selected';}echo '>'.$pref['clb'][$i].'<BR>';}?>
</SELECT><BR>
Club：<SELECT name="club2">
<OPTION value="NOCLB" selected>　　　【2nd Wanted】<BR>
<?for($i=0;$i<count($pref['clb'])-2;$i++){echo '<OPTION value="'.$i.'"';if(isset($in['club2']) && $in['club2']!='NOCLB' && $i == $in['club2']){echo ' selected';}echo '>'.$pref['clb'][$i].'<BR>';}?>
</SELECT><BR>
Club：<SELECT name="club3">
<OPTION value="NOCLB" selected>　　　【3rd Wanted】<BR>
<?for($i=0;$i<count($pref['clb'])-2;$i++){echo '<OPTION value="'.$i.'"';if(isset($in['club3']) && $in['club3']!='NOCLB' && $i == $in['club3']){echo ' selected';}echo '>'.$pref['clb'][$i].'<BR>';}?>
</SELECT><BR><BR>
ID：<INPUT size="8" type="text" name="Id" maxlength="20" value="<?=$in['Id']?>">　Password：<INPUT size="8" type="text" name="Password" maxlength="8" value="<?=$in['Password']?>"><BR>
<BR><BR>
<Table border="0" cellspacing="0" cellpadding="0">
<tr><td align="right">Killer Statement：</td><td><INPUT size="24" type="text" name="Message" maxlength="100" value="<?=$in['Message']?>"></td></tr>
<tr><td align="center" colspan="2">(This is how your character will say after killing another character)</td></tr>
<tr><td align="right">Last Statement：</td><td><INPUT size="24" type="text" name="Message2" maxlength="100" value="<?=$in['Message2']?>"></td></tr>
<tr><td align="center" colspan="2">(This is how your character will say at the moment of death)</td>
<tr><td align="right">Status Message：</td><td><INPUT size="32" type="text" name="Comment" maxlength="100" value="<?=$in['Comment']?>"></td></tr>
<tr><td align="center" colspan="2">(Status Message.)<BR></td></tr>
</table><BR>
<FONT color="yellow" size="2"><B><U>
Please refrain from registering character for multiple times.<BR>
In some cases, you may be banned from this game.<BR>
Using names that is not romaji of Japanese name is discouraged,<br>
but the choice is yours and it is up to you to name your character.<BR>
However, making character using names that express hatred towards any person.<BR>
will be deleted.<BR>
</U></B></FONT><BR>

<INPUT type="submit" name="Enter" value="Register"> 　<INPUT type="reset" name="Reset" value="Reset"><BR></FORM></CENTER>
<P align="center"><B><a href="index.php">HOME</A></B></P>
<?
FOOTER();
}
#===============#
# ■ 등록 처리	#
#===============#
function REGIST(){
#$host = $in['IP'];

global $in,$pref;

global $icon_check1,$icon_check2,$icon_check3,$icon_check4,$ar;
global $s_icon_pass;
$REG_ERR = '';
#입력 정보 체크
if($in['F_Name'] == '')			{$REG_ERR .= 'Last name cannot be left empty<BR>';}
if(preg_match("/\x8E[\xA6-\xDF]|\xA5[\xA1-\xF6]|\xA1[\xA6\xBC\xB3\xB4]/",$in['F_Name'])){$REG_ERR .= '성에게 카타카나가 포함되어 있습니다<BR>';}
#if(preg_match("/아|이|우|에|오|카|키|쿠|케|코|사|시|스|세|소|타|치|트|테|트|나|니|누|네|노|하|히|후|헤|호|마|미|무|메|모|야|유|요|라|리|르|레|로|와|오|/",$in['F_Name']))
#								{$REG_ERR .= '성에게 카타카나가 포함되어 있습니다<BR>';}
if(strlen($in['F_Name']) > 50)	{$REG_ERR .= 'Last name exceeds 50 characters<BR>';}

if($in['L_Name'] == '')			{$REG_ERR .= 'First name cannot be left empty<BR>';}

if(strlen($in['L_Name']) > 50)	{$REG_ERR .= 'First name exceeds 50 characters.';}

if($in['Sex'] == "NOSEX")		{$REG_ERR .= '성별이 미선택입니다<BR>';}
if(preg_match("/NOICON/",$in['Icon']))		{$REG_ERR .= 'You did not chose any avatar!<BR>';}
if($in['Icon'] == 0)			{$REG_ERR .= 'You did not chose any avatar!<BR>';}
elseif($in['Icon'] < $icon_check1){$in['Sex'] = "µ's";}#아이콘 자동 선택
elseif($in['Icon'] < $icon_check2){$in['Sex'] = "Aqours";}#아이콘 자동 선택
elseif($in['Icon'] < $icon_check3){
	if($in['SPass'] != $pref['a_pass_npc']){$REG_ERR .= 'You chose administrative icon!<BR>';}#관리용
}elseif($in['Icon'] < $icon_check4){#특수 아이콘
	if(!preg_match("/µ's|Aqours/",$in['Sex'])){$REG_ERR .= 'Please chose right group!<BR>';}
	if(($in['SPass'] != $s_icon_pass[$in['Icon'] - $icon_check3])||($s_icon_pass[$in['Icon'] - $icon_check3] == '')){$REG_ERR .= '특수 아이콘용의 패스워드와 일치하지 않습니다<BR>';}
}else{ERROR('Internal Server Error','Abnormal Icon ID','REGIST',__FUNCTION__,__LINE__);}
if($in['club'] == "NOCLB")		{$REG_ERR .= '아이콘이 미선택입니다<BR>';}
if($in['Id'] == '')				{$REG_ERR .= 'ID가 미입력입니다<BR>';}
if(strlen($in['Id']) < 4)		{$REG_ERR .= 'ID의 문자수가 충분하지 않습니다(반각 4 문자 이상)<BR>';}
if(strlen($in['Id']) > 8)		{$REG_ERR .= 'ID의 문자수가 많습니다(반각 8 문자 이하)<BR>';}
if(preg_match("/[^a-zA-Z0-9]+/",$in['Id'])){$REG_ERR .= 'ID는 반각영수로 입력해 주세요(반각영수 8 문자까지)<BR>';}
if(preg_match("/2YBRU/",$in['Id']))	{$REG_ERR .= 'ID에 사용 금지 문자열이 들어가 있습니다<BR>';}
if($in['Password'] == '')		{$REG_ERR .= '패스워드가 미입력입니다<BR>';}
if(strlen($in['Password']) < 4)	{$REG_ERR .= 'ID의 문자수가 충분하지 않습니다(반각 4 문자 이상)<BR>';}
if(strlen($in['Password']) > 8)	{$REG_ERR .= 'Password의 문자수가 오버하고 있습니다(반각 8 문자까지)<BR>';}
if(preg_match("/[^a-zA-Z0-9]+/",$in['Password'])){$REG_ERR .= 'Password는 반각영수로 입력해 주세요(반각영수 8 문자까지)<BR>';}
if(preg_match("/2YBRU/",$in['Password'])){$REG_ERR .= 'Password에 사용 금지 문자열이 들어가 있습니다<BR>';}
if(preg_match("/$in[Id]/",$in['Password']) ||preg_match("/$in[Password]/",$in['Id'])){$REG_ERR .= 'ID와 같은 문자열은 Password에 사용할 수 없습니다<BR>';}
if(strlen($in['Message']) > 100)	{$REG_ERR .= '말버릇의 문자수가 오버하고 있습니다(전각 12 문자까지)<BR>';}
if(strlen($in['Message2']) > 100){$REG_ERR .= '유언의 문자수가 오버하고 있습니다(전각 12 문자까지)<BR>';}
if(strlen($in['Comment']) > 100)	{$REG_ERR .= '코멘트의 문자수가 오버하고 있습니다(전각 12 문자까지)<BR>';}
if($in['Message'] == '')		{$REG_ERR .= '말버릇을 입력해 주세요(전각 12 문자까지)<BR>';}
if($in['Message2'] == '')		{$REG_ERR .= '유언을 입력해 주세요(전각 12 문자까지)<BR>';}
if($in['Comment'] == '')		{$REG_ERR .= '코멘트를 입력해 주세요(전각 12 문자까지)<BR>';}
#에러 출력
if($REG_ERR != ''){
	MAIN('<br><br><font color="red">'.$REG_ERR.'</font>');
	exit;
}
#유저 파일 취득
$userlist = @file($pref['user_file']) or ERROR('unable to open file user_file','','REGIST',__FUNCTION__,__LINE__);
#동성 동명 동일 ID?
foreach ($userlist as $userlist2){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",", $userlist2);
	if(($in['Id'] == $w_id)||(($in['F_Name'] == $w_f_name)&&($in['L_Name'] == $w_l_name))){ERROR("동일 ID, 혹은, 동성 동명의 캐릭터가 이미 존재합니다.","","REGIST",__FUNCTION__,__LINE__);}#동일 ID or 동성 동명?
}

#지급 무기 파일
$weplist = @file($pref['wep_file']) or ERROR('unable to open file wep_file','','REGIST',__FUNCTION__,__LINE__);

#사유물 파일
$stitemlist = @file($pref['stitem_file']) or ERROR('unable to open file stitem_file','','REGIST',__FUNCTION__,__LINE__);

#학생 번호 파일
$memberlist = @file($pref['class_file']) or ERROR('unable to open file class_file','','REGIST',__FUNCTION__,__LINE__);

list($m,$f,$mc,$fc) = explode(",",$memberlist[0]);

#성별 인원수 체크
global $cl,$no;
if($in['Sex'] == "µ's"){
	if($mc >= count($pref['clas'])){ERROR("Cannot register more µ's members!",'Too much boys','REGIST',__FUNCTION__,__LINE__);}#등록 불가능?
	$m+=1;$no=$m;$cl=$pref['clas'][$mc];
	if($m >= $pref['manmax']){$m=0;$mc+=1;}#클래스 갱신?
}else{
	if($fc >= count($pref['clas'])){ERROR("Cannot register more Aquours members",'Too much girls','REGIST',__FUNCTION__,__LINE__);}#등록 불가능?
	$f+=1;$no=$f;$cl=$pref['clas'][$fc];
	if($f >= $pref['manmax']){$f=0;$fc+=1;}#클래스 갱신?
}

#학생 번호 파일 갱신
$memberlist="$m,$f,$mc,$fc,\n";
$handle = @fopen($pref['class_file'],'w') or ERROR('unable to open file class_file','','REGIST',__FUNCTION__,__LINE__);
if(!@fwrite($handle,$memberlist)){ERROR('cannot write to class_file','','REGIST',__FUNCTION__,__LINE__);}
fclose($handle);

#초기 배포 무기 리스트 취득
$index = rand(0,count($weplist)-1);
list($w_wep,$w_att,$w_tai) = explode(',',$weplist[$index]);

#사유물 아이템 리스트 취득
$index = rand(0,count($stitemlist)-1);
list($st_item,$st_eff,$st_tai) = explode(',',$stitemlist[$index]);
$index = rand(0,count($stitemlist)-1);
list($st_item2,$st_eff2,$st_tai2) = explode(',',$stitemlist[$index]);

#소지품 초기화
for ($i=0; $i<6; $i++){$item[$i] = '없음'; $eff[$i]=$itai[$i]=0;}

#초기 능력
$rand = rand(0,15);
$att = 95 + $rand;
$def = 105 - $rand;#155
$hit = 500;
$mhit = $hit;$kill=0;$sta = $pref['maxsta'];$level = 1;
#경험치
$exp=0;
$reg_exp = $ar;
if ($reg_exp >= 4){$reg_exp -= 4;$exp = ($ar * 10);}

$death=$msg = '';
$sts = '정상';
$pls = 0;
$tactics = '통상';
$endtime = 0;
$log=$dmes=$bid=$inf = '';

#초기 아이템＆초기 배포 무기
$item[0] = '빵<>HH'; $eff[0] = 25; $itai[0] = 4;
$item[1] = '물<>SH'; $eff[1] = 25; $itai[1] = 4;
$item[2] = $w_wep; $eff[2] = $w_att; $itai[2] = $w_tai;

$wep = '맨손<>WP';
$watt = 0;
$wtai = '∞';

if ($in['Sex'] == "µ's"){$bou = 'Otonokizaka Uniform<>DBN';}
else {$bou = 'Uranohoshi Uniform<>DBN';}

list($b_name,$b_namea) = explode('<>',$bou);

list($w_name,$w_kind) = explode('<>',$w_wep);


$bdef = 20;
$btai = 30;

$bou_f = '가죽신<>DF';
$bdef_f = 10;
$btai_f = 15;

$bou_h = $bou_a = '없음';
$bdef_h = $bdef_a = 0;
$btai_h = $btai_a = 0;

#총알 또는 화살 지급
if(preg_match('/<>WG/',$w_wep)){$item[3] = '탄환<>Y'; $eff[3] = 10; $itai[3] = 1;$item[4] = $st_item; $eff[4] = $st_eff; $itai[4] = $st_tai;}#탄
elseif(preg_match('/<>WA/',$w_wep)){$item[3] = '화살<>Y'; $eff[3] = 12; $itai[3] = 1;$item[4] = $st_item; $eff[4] = $st_eff; $itai[4] = $st_tai;}#화살
else{$item[3] = $st_item; $eff[3] = $st_eff; $itai[3] = $st_tai;$item[4] = $st_item2; $eff[4] = $st_eff2; $itai[4] = $st_tai2;}

CLUBMAKE();	#클럽 작성
global $wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$host;

#User File
$money = '10';
$seikaku = '없음';#seikaku
$sinri = '없음';#sinri
$teamID = '없음';#TeamID
$teamPass = '없음';#TeamPass
$ousen = '통상';#Ousen
$item_get = '없음';
$eff_get = 0;
$itai_get = 0;

$in['IP'] = $host;

$newuser = $in['Id'].','.$in['Password'].','.$in['F_Name'].','.$in['L_Name'].','.$in['Sex'].",$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,".$in['Message'].",$sts,$pls,$kill,".$in['Icon'].",$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,".$in['Comment'].",".$in['Message2'].",$bid,".$in['club'].",$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,".$in['IP'].",\n";

#New User Save
$handle = @fopen($pref['user_file'], 'a') or ERROR('unable to open file user_file','','REGIST',__FUNCTION__,__LINE__);
if(!@fwrite($handle,$newuser)){ERROR('cannot write to user_file','','REGIST',__FUNCTION__,__LINE__);}
fclose($handle);


# 호스트 판별
$host1 = $_SERVER['REMOTE_ADDR'];
if($pref['host_view'] == 1){
	$host = $host1;
}elseif($pref['host_view'] == 2){
	$host2 = gethostbyaddr($host1);
	if(($host1 == $host2)||($host1 == '')){$host = $host2;}
	else{$host = $host1.'-'.$host2;}
}else{
	$host = '';
}

#New User Log
LOGSAVE('NEWENT');

$id=$in['Id'];$password=$in['Password'];

CSAVE();	#Cokie Save

HEAD();

?>
<center><B><FONT color="#ff0000" size="+3" face="MS 내일 아침">Registration Complete.</FONT></B><BR><BR></center>
<TABLE border="1" cellspacing="0">
  <TBODY>
	<TR><TD class="b1">클래스</TD><TD colspan="3" class="b3"><?=$cl?></TD></TR>
	<TR><TD class="b1">Name</TD><TD colspan="3" class="b3"><?=$in['F_Name'].' '.$in['L_Name']?></TD></TR>
	<TR><TD class="b1">번호</TD><TD colspan="3" class="b3"><?=$in['Sex'].$no?>번</TD></TR>
	<TR><TD class="b1">클럽</TD><TD colspan="3" class="b3"><?=$pref['clb'][$in['club']]?></TD></TR>
	<TR><TD class="b1">HP</TD><TD class="b3"><?=$hit.'/'.$mhit?></TD><TD width="39" class="b1">Stamina</TD><TD class="b3"><?=$sta?></TD></TR>
	<TR><TD class="b1">Attack</TD><TD class="b3"><?=$att?></TD><TD class="b1">Weapon</TD><TD class="b3"><?=$w_name?></TD></TR>
	<TR><TD class="b1">Defense</TD><TD class="b3"><?=$def?></TD><TD class="b1">Armor</TD><TD class="b3"><?=$b_name?></TD></TR>
  </TBODY>
</TABLE>
<P align="center">
<?=$in['F_Name'].' '.$in['L_Name']?>
<?

if ($in['Sex'] == '남자') {echo '훈';}
else {echo '씨';}

?>(이)구나?<BR>
전학 조속히이지만, 내일은 수학 여행이다.<BR><BR>
제대로 늦지 않고 감쌌어!<BR><BR>

<FORM METHOD="POST"  ACTION="regist.php" style="MARGIN: 0px">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="info">
<INPUT TYPE="HIDDEN" NAME="Id" VALUE="<?=$in['Id']?>">
<INPUT TYPE="HIDDEN" NAME="Password" VALUE="<?=$in['Password']?>">
<center>
<INPUT type="submit" name="Enter" value="수학 여행에 출발">
</center>
</FORM>

</P>
<?
FOOTER();
}

#===============#
# ■ 설명 처리	#
#===============#
function INFO(){
global $in;

HEAD();

?>
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">등록 완료</span></font></center><BR>
<P align="center">
잠이 깨면, 교실과 같은 곳에 있었다.수학 여행에 갔을 것인데….<BR>
「그렇다, 수학 여행에 가는 버스안에서 갑자기 졸음이 덮쳐 와…」<BR>
주위를 바라보면, 다른 학생도 있는 것 같다.잘 보면, 모두, 은빛의 목걸이를 낄 수 있고 있는 일을 눈치챘다<BR>
자신의 목에 닿으면, 차가운 금속의 감촉이 전해져 왔다.<BR>
모두와 같이, 그 은빛의 목걸이를 낄 수 있고 있었다.<BR><BR>
돌연, 전의 문으로부터, 한 명의 남자와 아사르트라이훌을 장비한 군사 해 들이 들어 왔다….<BR><BR>
<img border="0" src="img/i_sakamochi.jpg" width="70" height="70"><BR><BR>
「여러분 당분간, 일년때 담임이었던 판지금발입니다.이번도 또한 B조를 맡게 되었습니다.잘 부탁해<BR>
좋은가, 이 나라는 이 쿠니노부 보고 싶다 놈 덕분에, 완전히 안되게 되어 버렸습니다.<BR>
그러니까, 훌륭한 사람들은 상담해 이 법률을 만들었습니다.<BR><BR>
<p align="center"><font color="#FF0000" face="MS P내일 아침" size="6">
<span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">
■ BATTLE ROYALE ■</span></font></p><BR>
거기서 오늘은 여러분에게, 조금 살인을 받습니다.<BR>
거역하거나 그 목걸이를 벗거나 탈주하려고 시도했을 경우는 즉석에서 살해당한다고 생각해 주세요.<BR><BR>
마지막 한 명이 될 때까지입니다.<BR>
반칙은 없습니다.<BR><BR>
아, 선생님 말하는 것을  잊었지만, 여기는 섬입니다.<BR><BR>
좋은가―, 여기는 이 섬의 분교입니다.<BR>
선생님, 여기에 쭉 있기 때문―.모두 노력하는 것, 지켜보고 있으니.<BR><BR>
그런데, 좋습니까.여기를 나오면 어디에 가도 상관하지 않습니다.<BR>
매일 8시간 일어나기(0시와 8시와 16시)에, 섬 전체 방송을 합니다.하루 3회인.<BR><BR>
거기서, 모두가 가지고 있는 지도에 따라서, 몇 시부터 이 에리어는 위험해라고 선생님 알립니다.<BR>
지도를 잘 보고, 자석과 지형을 대조하고,<BR>
신속하게 그 에리어를 나와 주세요.<BR><BR>
어째서일까하고 말하면―, 그 목걸이는 역시 폭발합니다.<BR><BR>
좋은가, 그러니까, 건물가운데에 있어도 안되구나.<BR>
구멍 파 숨어도 전파는 계.<BR>
아-그래그래, 무심코로입니다만―, 건물가운데에 숨는 것은 제멋대로입니다.<BR><BR>
아―, 그것과 하나 더.시한이 있습니다.<B><font color="yellow">일주일간</font></B>입니다.<BR><BR>
프로그램에서는, 자꾸자꾸 사람이 죽습니다만, 24시간에 지나 죽은 사람이 아무도가 아니었으면,<BR>
그것이 마감 시간입니다.그리고 몇 사람 남아 있으려고, 컴퓨터가 작동하고,<BR>
남아있는 사람 전원의 목걸이가 폭발 섬-.우승자는<u>키-응</u>.<BR><BR>
무엇으로 이런 일 할까래?<BR>
너등의 탓이야 너등 ,<B>어른스러운 째라고 이겠지</B>　핥는 것은 좋아<BR>
그렇지만이것만은 기억해둬<BR><BR>
<Font size="+1" color="red"><B><i>「인생은 게임입니다.　　　　　　　　　　　　　　　　<font color="black">.</font><BR>모두가 필사적으로 싸워 살아 남는다.<BR>　　　　　　　　　　가치가 있는 어른이 됩시다!」</i></B></Font><BR><BR>
-라고, 그러면 한 명씩, 이 데이팩을 가지고, 교실을 나와 줍니다.<BR><BR>
아, 아버지 엄마에게 말해 있으니까 염려 없게 싸워」<BR><BR>
<FORM METHOD="POST"  ACTION="BR.php" style="MARGIN: 0px">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="main">
<INPUT TYPE="HIDDEN" NAME="Id" VALUE="<?=$in['Id']?>">
<INPUT TYPE="HIDDEN" NAME="Password" VALUE="<?=$in['Password']?>">
<INPUT type="submit" name="Enter" value="교실을 나온다">
</center>
</FORM>
<?
FOOTER();
}
#===================#
# ■ 아이콘 일람	#
#===================#
function ICON(){
global $pref;
global $icon_file,$icon_name;
HEAD();
?>
<center><hr width="75%">
<b><big>Available Avatars</big></b>
<P><small>- There are all available avatars -</small>
<hr width="75%">
<?
if(!$pref['MOBILE']){
	echo '<P><table border="1" cellpadding="0" cellspacing="0"><tr>';
}

foreach($icon_file as $j => $icon_list){
	if($j != 0){
		if($pref['MOBILE']){
			print '<img src="'.$pref['imgurl'].'/'.$icon_list.'"><BR>'.$icon_name[$j].'<br>';
		}else{
			print '<th class="b3" width="70"><img src="'.$pref['imgurl'].'/'.$icon_list.'" ALIGN="middle" alt="'.$icon_name[$j].'" height="70" width="70"><BR>'.preg_replace('/ /','<br>',$icon_name[$j],1).'</th>';
		}
	}
	if($j%10==0 && !$pref['MOBILE']){print '</tr><tr>';}
}

if(!$pref['MOBILE']){
	while($j%10!=0){print '<th class="b3" width="70">&nbsp;</th>';$j++;}
	echo '</tr></table><p><FORM><INPUT TYPE="button" VALUE="  CLOSE  " onClick="top.close();"></FORM>';
}

?>
</center>
</body>
</html>
<?
FOOTER();
exit;
}
#===================#
# ■ 클럽 작성		#
#===================#
function CLUBMAKE(){
global $pref,$in;

global $wp,$wg,$wn,$wc,$wd;
$wp=$wg=$wn=$wc=$wd=0;
#구총검투폭
$dice = rand(0,100);
#풀 시즌	25 50 75%
#시즌		15 30 45%
if($in['club1']==$in['club2']){
	$in['club2']='';
}
if($in['club1']==$in['club3']){
	$in['club3']='';
}
if($in['club2']==$in['club3']){
	$in['club3']='';
}

if($in['club1']==''){
	if($in['club2']!=''){$in['club1'] = $in['club2'];$in['club2']='';}
}
if($in['club2']==''){
	if($in['club3']!=''){$in['club2'] = $in['club3'];$in['club3']='';}
}
if($in['club1']==''){$in['club1'] = rand(0,29);}
if($in['club2']==''){$in['club2'] = rand(0,29);}
if($in['club3']==''){$in['club3'] = rand(0,29);}

if($in['club'] <= 17 && $dice < 25){#풀 시즌
	$in['club']=$in['club1'];
}elseif($in['club'] > 17 && $dice < 15){#시즌
	$in['club']=$in['club1'];
}elseif($in['club'] <= 17 && $dice < 50){
	$in['club']=$in['club2'];
}elseif($in['club'] > 17 && $dice < 30){
	$in['club']=$in['club2'];
}elseif($in['club'] <= 17 && $dice < 75){
	$in['club']=$in['club3'];
}elseif($in['club'] > 17 && $dice < 45){
	$in['club']=$in['club3'];
}else{
	$in['club'] = rand(0,29);
}

if($in['club'] >= 28){$in['club'] = rand(0,29);}

if		($in['club'] == 0)	{$wp = 20;}	#가라테부
elseif	($in['club'] == 1)	{$wn = 20;}	#검도부
elseif	($in['club'] == 2)	{;}	#유도부
elseif	($in['club'] == 3)	{;}	#요리부
elseif	($in['club'] == 4)	{;}	#아트부
elseif	($in['club'] == 5)	{;}	#다도부
elseif	($in['club'] == 6)	{;}	#락부
elseif	($in['club'] == 7)	{;}	#오케스트라부
elseif	($in['club'] == 8)	{;}	#자원봉사부
elseif	($in['club'] == 9)	{;}	#브라스 밴드부
elseif	($in['club'] == 10)	{;}	#낚시부
elseif	($in['club'] == 11)	{;}	#코러스부
elseif	($in['club'] == 12)	{$wc = 20;}	#장기부
elseif	($in['club'] == 13)	{;}	#후쿠자와유키치 연구회
elseif	($in['club'] == 14)	{;}	#서도부
elseif	($in['club'] == 15)	{;}	#바둑부
elseif	($in['club'] == 16)	{;}	#서양 보드부
elseif	($in['club'] == 17)	{;}	#ZION
elseif	($in['club'] == 18)	{;}	#농구부
elseif	($in['club'] == 19)	{;}	#축구부
elseif	($in['club'] == 20)	{$wc=$wp=10;}	#야구부
elseif	($in['club'] == 21)	{$wg = 20;}	#테니스부
elseif	($in['club'] == 22)	{$wc = 20;}	#수영부
elseif	($in['club'] == 23)	{$wp = 20;}	#럭비부
elseif	($in['club'] == 24)	{;}	#라크로스부
elseif	($in['club'] == 25)	{;}	#발레부
elseif	($in['club'] == 26)	{;}	#크로스 카운트 리부
elseif	($in['club'] == 27)	{$wp=$wg=$wn=$wc=$wd=10;}	#방송부
elseif	($in['club'] == 28)	{$wp=$wg=$wn=$wc=$wd=20;}	#Computer Help Desk
elseif	($in['club'] == 29)	{$wp=$wg=$wn=$wc=$wd=30;}	#Computer Task Force
else	{CLUBMAKE();}
}
#===================#
# ■ 등록 헤더부	#
#===================#
function REG_HEAD(){
global $pref;
global $icon_check1,$icon_check2,$icon_check3,$icon_check4,$icon_file,$icon_name;
?>
<script language="javascript" type="text/javascript">
<!--
var brw_v = navigator.appVersion.charAt(0);
var brw_n = navigator.appName.charAt(0);
var iIE4 = false;
var iNN4 = false;
if((brw_v >= 4)&&(brw_n == "M")) iIE4 = true;
if((brw_v >= 4)&&(brw_n == "N")) iNN4 = true;

var comments = new Array();
comments[0] = '<img src="<?=$pref['imgurl']?>/question.gif" ALIGN="middle" alt="Question">';
comments[1] = '<img src="<?=$pref['imgurl']?>/question.gif" ALIGN="middle" alt="Question">';
<?

for ($i=0;$i<$icon_check1;$i++){
	$j=$i+1;
	print 'comments['.$j.'] = \'<img src="'.$pref['imgurl'].'/'.$icon_file[$i].'" ALIGN="middle" alt="'.$icon_name[$i].'">\';';
}
$j++;
print 'comments['.$j.'] = \'<img src="'.$pref['imgurl'].'/question.gif" ALIGN="middle" alt="Question">\';';
for ($i;$i<$icon_check2;$i++){
	$j=$i+2;
	print "comments[$j] = '<img src=\"".$pref['imgurl']."/$icon_file[$i]\" ALIGN=middle alt=\"$icon_name[$i]\">';\n";
}
$j++;print "comments[$j] = '<img src=\"".$pref['imgurl']."/question.gif\" ALIGN=middle alt=\"Question\">';\n";
for ($i;$i<$icon_check3;$i++){$j=$i+3;print "comments[$j] = '<img src=\"".$pref['imgurl']."/$icon_file[$i]\" ALIGN=middle alt=\"$icon_name[$i]\"><BR>성별：<SELECT name=\"Sex\"><OPTION value=\"NOSEX\" selected>- 성별 -<BR><OPTION value=\"남자\">남자<BR><OPTION value=\"여자\">여자<BR></SELECT><BR>특수 아이콘 패스워드：<INPUT size=\"8\" type=\"text\" name=\"SPass\" maxlength=\"16\"> ';\n";}
$j++;print "comments[$j] = '<img src=\"".$pref['imgurl']."/question.gif\" ALIGN=middle alt=\"Question\">';\n";
for ($i;$i<$icon_check4;$i++){$j=$i+4;print "comments[$j] = '<img src=\"".$pref['imgurl']."/$icon_file[$i]\" ALIGN=middle alt=\"$icon_name[$i]\"><BR>성별：<SELECT name=\"Sex\"><OPTION value=\"NOSEX\" selected>- 성별 -<BR><OPTION value=\"남자\">남자<BR><OPTION value=\"여자\">여자<BR></SELECT><BR>특수 아이콘 패스워드：<INPUT size=\"8\" type=\"text\" name=\"SPass\" maxlength=\"16\"> ';\n";}

?>
function Mover(){
	ChkNum(document.Regist.Icon.selectedIndex);
}
function ChkNum(n){
	//var lay = new Array();

	Com = "<div class=Style>" + comments[n] + "<\/div>";

	if(document.all){
		obj1=document.all["SubMenu"];
	}else if(document.layers){
		obj1=document.layers["SubMenu"];
	}else if(document.getElementById){
		obj1=document.getElementById("SubMenu");
	}
	obj1.innerHTML=Com;
}
// -->
</SCRIPT>
<?
}
?>