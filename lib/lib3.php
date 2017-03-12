<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR LIBRARY PROGRAM    - 	 ■
#□ 									 □
#■ 		써브루틴 일람			 ■
#□ 									 □
#■ BAITEN		-	매점 처리			 ■
#□ POISON		-	독물 혼입 처리		 □
#■ PSCHECK		-	독 봐 처리			 ■
#□ POISONDEAD	-	독물 사망 처리		 □
#■ WINCHG		-	말버릇 변경 처리		 ■
#□ TEAM		-	팀 변경 처리		 □
#■ OUKYU		-	응급 처치 처리		 ■
#□ KOUDOU		-	기본방침 변경		 □
#■ OUSEN		-	응전 방침 변경		 ■
#□ SPEAKER		-	휴대 스피커 사용	 □
#■ HACKGIN		-	해킹 처리		 ■
#□■□■□■□■□■□■□■□■□■□■□
#=============#
# ■ 매점 처리 #
#=============#
function BAITEN(){
global $in,$pref;

global $BN;
$BT = $in['Command'];
$BT = preg_replace("/BAITEN_/","",$BT);
print "어느 종류의 아이템을 구입합니까?<BR><BR>";

$baitenlist = @file($pref['baiten_file']) or ERROR("unable to open baiten_file","","LIB3",__FUNCTION__,__LINE__);
for ($i=0;$i<count($baitenlist);$i++){
	list($b_b,$b_c,$b_i,$b_e,$b_t) = explode(",",$baitenlist[$i]);
	$cost = $b_c * 100;
	if(preg_match("/<>/",$b_i)){list($b_ii,$b_ik) = explode("<>",$b_i);}
	if((($BT == "SPECIAL")||($BT == "BAITEN"))&&($b_b == $b_c)&&($b_e == "")&&($b_t == "")){#아이템 선택 없음→종류 표시
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"BAITEN_$b_b\">$b_i</A><BR>";
	}elseif(($b_b == $b_c)&&($b_e == "")&&($b_t == "")){#종류 번호 취득
		$BN = $b_b;
	}elseif($BT == $BN){#아이템 표시
		if($b_b){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"BAITEN2_{$BT}_{$b_ii}\">{$b_ii} [잔:{$b_b} 치:{$cost}]</A><BR>";}
	}
}
if(($BT != "SPECIAL")&&($BT != "BAITEN")){
	Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"BAITEN\" checked>매점으로 돌아온다</A><BR>";
}#아이템 선택 없음→종류 표시
Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR>";
print "<BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
}
#==============#
# ■ 매점 처리 2 #
#==============#
function BAITEN2(){
global $in,$pref;

global $item,$money,$log;
$BT = $in['Command'];
$BT = preg_replace("/BAITEN2_/","",$BT);
list($itn, $ik) = explode("_",$BT);

$baitenlist = @file($pref['baiten_file']) or ERROR("unable to open baiten_file","","LIB3",__FUNCTION__,__LINE__);
$chkflg = 1;
for ($b=0;$b<count($baitenlist);$b++){
	list($b_b,$b_c,$b_i,$b_e,$b_t) = explode(",",$baitenlist[$b]);
	if(preg_match("/<>/",$b_i)){list($b_ii,$b_ik) = explode("<>",$b_i);}
	if(($b_b == $b_c)&&($b_e == "")&&($b_t == "")){#종류 번호 취득
		$BN = $b_b;
	}elseif(($itn == $BN)&&($ik == $b_ii)&&($b_e != "")&&($b_t != "")){#아이템 일치
		$chkflg=0;break;
	}
}
if($chkflg){ERROR("Internal Server Error","break error","LIB3",__FUNCTION__,__LINE__);}
list($b_ii,$b_ik) = explode("<>",$b_i);
$chkflg = -1;
for ($i=0; $i<5; $i++){if($item[$i] == "없음"){$chkflg = $i;break;}}#빈아이템?
if($b_b <= 0){$log = ($log . "$b_ii는 아무래도 품절같다…<BR>");}
elseif($b_c > $money){$log = ($log . "현금이 부족한 것 같다…<BR>");}
elseif($chkflg == -1){$log = ($log . "그러나, 더 이상가방에 들어가지 않는다.<BR>${b_ii}의 구입을 포기했다….<BR>");}#소지품 오버
else{
	global $eff,$itai;
	$money = $money - $b_c;#지불
	if($item[$chkflg] == "없음"){$item[$chkflg] = $b_i; $eff[$chkflg] = $b_e; $itai[$chkflg] = $b_t;}
	else{ERROR("Internal Server Error","CHKFLG error","LIB3",__FUNCTION__,__LINE__);}
	$log = ($log . "{$b_ii}를 구입했다.");
	$b_b--;#개수 마이너스
	$baitenlist[$b] = "$b_b,$b_c,$b_i,$b_e,$b_t,\n";

	$handle = @fopen($pref['baiten_file'],'w') or ERROR("unable to open baiten_file","","LIB3",__FUNCTION__,__LINE__);
	if(!@fwrite($handle,implode('',$baitenlist))){ERROR("unable to baiten_file","","LIB3",__FUNCTION__,__LINE__);}
	fclose($handle);
}
SAVE();
}
#=================#
# ■ 독물 혼입 처리 #
#=================#
function POISON(){
global $in,$pref;

global $item,$eff,$itai,$id,$log;
for ($i=0; $i<5; $i++){if(preg_match("/독약/",$item[$i])){break;}}
$wk = $in['Command'];
$wk = preg_replace("/POI_/","",$wk);
if((!preg_match("/<>SH|<>HH|<>SD|<>HD/",$item[$wk]))||(!preg_match("/독약/",$item[$i]))){ERROR("부정한 액세스입니다.","","LIB3",__FUNCTION__,__LINE__);}
$itai[$i]--;
if($itai[$i] <= 0){$item[$i] = "없음"; $eff[$i] = $itai[$i] = 0;}
list($itn, $ik) = explode("<>",$item[$wk]);
$log = ($log . "{$itn} 에 독물을 혼입했다.<BR>스스로 입에 대지 않게 조심하자···.<br>");
if	   ($pref['clb'][$itn['club']] == "요리부"){
	if(preg_match("/<>H.*/",$item[$wk])){$item[$wk] = preg_replace("/<>H.*/","<>HD2-$id",$item[$wk]);}
	else{$item[$wk] = preg_replace("/<>S.*/","<>SD2-$id",$item[$wk]);}
}elseif($item[5] == "독물 취급서<>A"){
	if(preg_match("/<>H.*/",$item[$wk])){$item[$wk] = preg_replace("/<>H.*/","<>HD1-$id",$item[$wk]);}
	else{$item[$wk] = preg_replace("/<>S.*/","<>SD1-$id",$item[$wk]);}
}else{
	if(preg_match("/<>H.*/",$item[$wk])){$item[$wk] = preg_replace("/<>H.*/","<>HD-$id",$item[$wk]);}
	else{$item[$wk] = preg_replace("/<>S.*/","<>SD-$id",$item[$wk]); }
}
SAVE();
$in['Command'] = "MAIN";
}
#=============#
# ■ 독 봐 처리 #
#=============#
function PSCHECK(){
global $in,$pref;

global $item,$sta,$log;
$wk = $in['Command'];
$wk = preg_replace("/PSC_/","",$wk);
if((!preg_match("/<>SH|<>HH|<>SD|<>HD/",$item[$wk]))||($pref['clb'][$in['club']] != "요리부")){ERROR("부정한 액세스입니다","Not in such club","LIB3",__FUNCTION__,__LINE__);}
elseif($sta <= $pref['dokumi_sta']){$log = ($log . "스태미너가 부족하기 때문에 독 봐가 할 수 없는데…") ;return;}
list($itn, $ik) = explode("<>",$item[$wk]);
if(preg_match("/SH|HH/",$ik)){$log = ($log . "응? {$itn} 는 입에 대어도 안전한 것 같다….<br>");}
else{$log = ($log . "응? {$itn} 에는 독물이 혼입되어 있을 것 같다….<br>");}
$sta -= $pref['dokumi_sta'];

SAVE();
$in['Command'] = "MAIN";
}
#=================#
# ■ 독물 사망 처리 #
#=================#
function POISONDEAD(){
global $pref;

global $hit,$mem,$poisondeadchk,$wb,$poison;
if($hit <= 0){

$hit = 0;
$mem--;

$com = rand(0,6);
$poisonid="2Y0";

if($poisondeadchk){list($tp,$poisonid) = explode("-",$poisoni);}
else{$poisonid = $wb;}

$userlist = @file($pref['user_file']) or ERROR("unable to open user_file","","LIB3",__FUNCTION__,__LINE__);

#체크
for ($i=0; $i<count($userlist); $i++){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$i]);
	if($poisonid == $w_id){#동일ID
		#경험지-적
		$expup = round(($level - $w_level)/5);if($expup <1){$expup = 1;}if($hit < 1){$expup += 1;}$w_exp += $expup;
		$w_log = ($w_log . "<font color=\"yellow\"><b>$hour:$min:$sec $f_name $l_name($cl $sex$no 차례)가 자신의 독에 의해 사망했다.【나머지$mem인】</b></font><br>");
		$w_kill++;$w_bid = $id;SAVE2;break;
	}
}

$log = ($log . "<font color=\"lime\"><b>$w_f_name $w_l_name 「$w_msg」</b></font><br>");

$b_limit = ($pref['battle_limit'] * 3) + 1;

if(($mem == 1) && ($w_sts != "NPC") && ($ar > $b_limit)){$w_inf = ($w_inf . "승");}

#사망 로그
LOGSAVE("DEATH1");
$death = $deth;

$bid = $w_id;

SAVE();

}else{
#	&ERROR("Internal Server Error","Player is Alive","LIB3-POISONDEAD");
}
}
#=================#
# ■ 말버릇 변경 처리 #
#=================#
function WINCHG(){
global $in;

global $msg,$dmes,$com,$log;
$msg = $in['Message'];
$dmes = $in['Message2'];
$com = $in['Comment'];
$log = ($log . "말버릇을 변경했습니다.<br>");
SAVE();
$in['Command'] = "MAIN";
}
#===================#
# ■ 팀 변경 처리 #
#===================#
function TEAM(){
global $in,$pref;

global $teamID,$teamPass,$log,$teamold,$sta;

$teamold = $teamID;
if(strlen($in['teamID2']) > 24){$log = ($log . "그룹명의 문자수가 오버하고 있습니다.(전각 12 문자까지)<BR>"); return;}
if(strlen($in['teamPass2']) > 24){$log = ($log . "그룹 패스워드의 문자수가 오버하고 있습니다.(전각 12 문자까지)<BR>"); return;}
if(preg_match("/\_|\,|\;|\<|\>|\(|\) |&|\/|\./",$in['teamID2'])){$log = ($log . "그룹명에 사용 금지 문자가 들어가 있습니다<BR>"); return;}
if(preg_match("/\_|\,|\;|\<|\>|\(|\) |&|\/|\./",$in['teamPass2'])){$log = ($log . "그룹 패스워드에 사용 금지 문자가 들어가 있습니다<BR>"); return;}

if((($in['teamID2'] == $teamID))&&(($in['teamPass2'] == "")||($in['teamPass2'] == "변경하지 않는 경우는 이대로"))){$in['Command'] = "MAIN";return;}
elseif((($in['teamID2'] == "없음")&&($in['teamPass2'] == "없음"))||(($in['teamID2'] == "「없음」")&&($in['teamPass2'] == "「없음」"))){
	if($sta <= $pref['team_sta']){
		$log = ($log . "그룹 탈퇴에 필요한 스태미너가 충분하지 않습니다.<br>");
		return;
	}elseif($teamID != "없음"){
		$sta -= $pref['team_sta'];
		$teamID = '없음';
		$teamPass = '없음';
		LOGSAVE("G-DATT");
		$log = ($log . "그룹 {$teamold} 를 탈퇴했습니다.<br>");
	}else{
		$log = ($log . "그룹에 소속하지 않았습니다.<br>");
		return;
	}
}elseif(($in['teamID2'] == "")||($in['teamPass2'] == "")||($in['teamID2'] == "없음")||($in['teamPass2'] == "없음")||($in['teamID2'] == "「없음」")||($in['teamPass2'] == "「없음」")){
	ERROR("그룹을 탈퇴하려면.<BR>그룹명·패스워드 양쪽 모두를 「없음」으로 해 주세요.<br>","No Grop Name Entered","LIB3",__FUNCTION__,__LINE__);
}elseif($teamID != $in['teamID2']){
	if($teamID != "없음"){
		ERROR("그룹을 결성·가입하려면 , 지금 있는 그룹으로부터 탈퇴해 주세요","Need to get out before get in","LIB3",__FUNCTION__,__LINE__);
	}elseif(($in['teamPass2'] == "변경하지 않는 경우는 이대로")||($in['teamPass2'] == "")){
		ERROR("패스워드를 넣어 주세요","No Password has been entered","BATTLE-TEAM");
	}elseif($in['teamPass2'] == $in['teamID2']){
		ERROR("그룹명으로 패스워드는 다른 것으로 해 주세요","Group Name is same as Pass","BATTLE-TEAM");
	}elseif((preg_match("/$in[teamID2]/",$in['teamPass2']))||(preg_match("/teamPass2/",$in['teamID2']))){
		ERROR("그룹명과 패스워드가 유사하고 있습니다","Group Name and Pass is similar","BATTLE-TEAM");
	}
	#get User file
	$userlist = @file($pref['user_file']) or ERROR("unable to open user_file","","LIB3",__FUNCTION__,__LINE__);
	#Same Name and ID check
	$ng = 0;
	foreach ($userlist as $usrlst){
		list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",", $usrlst);
		if(($in['teamID2'] == $w_teamID)&&(($in['teamPass2'] != $w_teamPass)&&($w_sts != "사망"))){
			ERROR("동일 그룹명이 존재하는지, 패스워드가 다릅니다.","Same Group Exists or Pass miss-match","LIB3",__FUNCTION__,__LINE__);
		}elseif(($in['teamID2'] == $w_teamID)&&($in['teamPass2'] == $w_teamPass)){
			$ng++;
		}
	}
	if($ng == 0){
		LOGSAVE("G-JOIN");
		$teamID = $in['teamID2'];
		$teamPass = $in['teamPass2'];
		$log = ($log . "그룹 {$teamID} 를 결성했습니다.<br>");
	}elseif($ng >= $pref['team_max']){
		ERROR("그룹이 최대 인원수의{$pref['team_max']}사람입니다","Max Group Number","BATTLE-TEAM","LIB3",__FUNCTION__,__LINE__);
	}else{
		LOGSAVE("G-KANYU");
		$teamID = $in['teamID2'];
		$teamPass = $in['teamPass2'];
		$log = ($log . "그룹 {$teamID} 에 가입했습니다.<br>");
	}
}

SAVE();

$in['Command'] = "MAIN";
}
#=================#
# ■ 응급 처치 처리 #
#=================#
function OUKYU(){
global $in,$pref;

global $sta,$log,$inf;
if($sta <= $pref['okyu_sta']){$log = ($log . "스태미너가 부족하기 때문에 응급 처치를 할 수 없는데…") ;return;}

$wk = $in['Command'];
$wk = preg_replace("/OUK_/","",$wk);

if	 ($wk == 0){$inf = preg_replace("/머리/","",$inf);}#머리
elseif($wk == 1){$inf = preg_replace("/팔/","",$inf);}#팔
elseif($wk == 2){$inf = preg_replace("/배/","",$inf);}#복부
elseif($wk == 3){$inf = preg_replace("/다리/","",$inf);}#다리
elseif(($wk == 4)&&($pref['clb'][$in['club']] == "다도부")){$inf = preg_replace("/독/","",$inf) ;$sta += $pref['okyu_sta'];}#독
else{$log = ($log . "응급 처치의 필요가 없어") ;return;}

$log = ($log . "응급 처치를 했다.<BR>");
$sta -= $pref['okyu_sta'];
SAVE();
$in['Command'] = "MAIN";
}
#=================#
# ■ 기본방침 변경 #
#=================#
function KOUDOU(){
global $in;

global $tactics,$log;

$wk = $in['Command'];
$wk = preg_replace('/KOU_/','',$wk);
$old_tactics = $tactics;

if	  ($wk == 1){$tactics = '공격 중시';}
elseif($wk == 2){$tactics = '방어 중시';}
elseif($wk == 3){$tactics = '은밀 행동';}
elseif($wk == 4){$tactics = '탐색 행동';}
elseif($wk == 5){$tactics = '련투행동';}
else			{$tactics = '통상';}

$log .= '기본방침을 <b>'.$old_tactics.'</b> 로부터 <b>'.$tactics.'</b> 로 변경했다.<BR>';

SAVE();

$in['Command'] = "MAIN";
}
#=================#
# ■ 응전 방침 변경 #
#=================#
function OUSEN(){
global $in;

global $ousen,$log;

$wk = $in['Command'];
$wk = preg_replace("/OUS_/","",$wk);
$old_ousen = $ousen;

if	  ($wk == 1){$ousen = '공격 몸의 자세';}
elseif($wk == 2){$ousen = '방어 몸의 자세';}
elseif($wk == 3){$ousen = '은밀 몸의 자세';}
#elseif($wk == 4){$ousen = '탐색 행동';}
#elseif($wk == 5){$ousen = '련투행동';}
elseif($wk == 6){$ousen = '치료 전념';}
elseif($wk == 7){$ousen = '도망 몸의 자세';}
else			{$ousen = '통상';}

$log .= '응전 방침을 <b>'.$old_ousen.'</b> 로부터 <b>'.$ousen.'</b> 로 변경했다.<BR>';

SAVE();

$in['Command'] = "MAIN";
}
#=====================#
# ■ 휴대 스피커 사용 #
#=====================#
function SPEAKER(){
global $in,$pref;

for($i=0;$i<5;$i++){
	if(preg_match("/휴대 스피커/",$item[$i])){
		break;
	}
}

if(!preg_match("/휴대 스피커/",$item[$i])){ERROR("부정한 액세스입니다.","","LIB3",__FUNCTION__,__LINE__);}

$log .= ' '.$in['speech'].'<BR>';
$log .= '제대로 전해졌는지?<BR>';

$gunlog = @file($pref['gun_log_file']) or ERROR("unable to open gun_log_file","","LIB3",__FUNCTION__,__LINE__);
$namae = "$f_name $l_name";
$gunlog[2] = $pref['now'].",".$pref['place'][$pls].",".$namae.",".$in['speech'].",\n";

$handle = @fopen($pref['gun_log_file'],'w') or ERROR("unable to open gun_log_file","","LIB3",__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$gunlog))){ERROR("unable to gun_log_file","","LIB3",__FUNCTION__,__LINE__);}
fclose($handle);

$in['Command'] = "MAIN";

}
#===================#
# ■ 해킹 처리 #
#===================#
function HACKING(){
global $in,$pref;

global $log,$item,$eff,$itai;
global $hit,$sts,$desh,$mem,$f_name,$l_name,$cl,$sex,$no;

$junbi=0;
for ($paso=0; $paso<5; $paso++){
	if(($item[$paso] == '모바일 PC<>Y')&&($itai[$paso] >= 1)){
		$junbi = 1;
		break;
	}
}

if($in['Command'] != 'SPECIAL' || $in['Command4'] != 'HACK' || !$junbi){ERROR('부정한 액세스입니다.','','LIB3',__FUNCTION__,__LINE__);}

$dice1 = rand(0,99);
$dice2 = rand(0,10);

if(preg_match("/Computer Help Desk/",$pref['clb'][$in['club']]))	{#PC부의 기본 성공율
	$bonus = 15;
}elseif(preg_match("/Computer Task Force/",$pref['clb'][$in['club']])){#PC부의 기본 성공율
	$bonus = 20;
}else{
	$bonus = 10;
}

$kekka = $bonus;

$log .= '해킹을 시도한…';

if($dice1 <= $kekka){	 #해킹 성공 여부 판정
	$wk_arealist = @file($pref['area_file']) or ERROR("unable to open area_file","","LIB3",__FUNCTION__,__LINE__);
	list($wk_ar,$wk_hack,$wk_a) = explode(",",$wk_arealist[1]);  #해킹 플래그 취득
	$wk_hack = 2;
	$wk_arealist[1] = "$wk_ar,$wk_hack,\n";

	$handle = @fopen($pref['area_file'],'w') or ERROR("unable to open area_file","","LIB3",__FUNCTION__,__LINE__);
	if(!@fwrite($handle,implode('',$wk_arealist))){ERROR("unable to area_file","","LIB3",__FUNCTION__,__LINE__);}
	fclose($handle);
	$log .= '해킹 성공!모든 금지 에리어가 해제되었다!<BR>';
	LOGSAVE('HACK');
}else{
	$log .= '그러나, 해킹은 실패했다…<BR>';
}

for($paso=0;$paso<5;$paso++){
	if(($item[$paso] == '모바일 PC<>Y')&&($itai[$paso] >= 1)){
		break;
	}
}

if($dice1 >= 95){   #배터리 소모＆펌블 시기재 파괴
	$item[$paso] = '없음'; $eff[$paso] = $itai[$paso] = 0;
	$log .= '는!기재가 망가져 버렸다.<BR>';
	if($dice2 >= 9){  #신(%펌블) 시 정부에 의해 목걸이 폭파!
		$hit = 0; $sts = "사망"; $death = $deth = "정부에 의한 처형";$mem--;
		if($mem == 1){
			$handle = @fopen($pref['end_flag_file'],'w');# or ERROR("unable to open end_flag_file","","LIB3",__FUNCTION__,__LINE__);
			if(!@fwrite($handle,"종료 \n")){ERROR("unable to end_flag_file","","LIB3",__FUNCTION__,__LINE__);}
			fclose($handle);
		}
		LOGSAVE('DEATH5');

		$gunlog = @file($pref['gun_log_file']) or ERROR('unable to open gun_log_file','','LIB3',__FUNCTION__,__LINE__);
		$gunlog[1] = $pref['now'].','.$pref['place'][$pls].','.$id.",,\n";

		$handle = @fopen($pref['gun_log_file'],'w') or ERROR('unable to open gun_log_file','','LIB3',__FUNCTION__,__LINE__);
		if(!@fwrite($handle,implode('',$gunlog))){ERROR('unable to gun_log_file','','LIB3',__FUNCTION__,__LINE__);}
		fclose($handle);
		$log .= '는!기재가 망가져 버렸다.<br><br>…무엇이야?…목걸이로부터 경고음이…!<BR><BR><font color="red">···！！···<br><br><b>'.$f_name.' '.$l_name.'('.$cl.' '.$sex.$no.'차례)는 사망했다.</b></font><br>';
	}
}else{
	$itai[$paso] --;if($itai[$paso] == 0){
		$log .= '모바일 PC 의 배터리의 전력을 다 써 버렸다.<BR>';
	}
}

if($eff[$paso] <= 0){
	$item[$paso] = '없음';
	$eff[$paso] = 0;
	$itai[$paso] = 0;
}
SAVE();
}
?>