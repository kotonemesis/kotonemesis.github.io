<?php
#===============#
# ■ 데이터 변경 #
#===============#
/*function DATACHG(){
#open(DB,$pref['user_file']) ;seek(DB,0,0); @userlist=<DB>;close(DB);
$userlist = @file($pref['user_file']) or ERROR("unable to open user_file");
for ($i=0; $i<count($userlist); $i++){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP) = explode(",",$userlist[$i]);
	if($w_sts != "NPC"){$w_pls = 3;}
	$userlist[$i] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,\n";
}
#open(DB,">$pref['user_file']"); seek(DB,0,0); print DB @userlist; close(DB);
$handle = @fopen($pref['user_file'],'w') or ERROR("unable to open user_file");
if(!@fwrite($handle,implode('',$userlist))){ERROR("unable to write user_file");}
fclose($handle);

HEAD();
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
OK<br>
<br><B><FONT color="#ff0000">>><a href="index.cgi">HOME</a> >><a href="admin.cgi">ADMIN</a></b></FONT>
_HERE_;
FOOTER();
}
*/
#=======#
# ■ 변 #
#=======#
function USERCHG(){
global $pref;

global $DEL,$USERCHG;
HEAD();
$userlist = @file($pref['user_file']) or ERROR("unable to open user_file");
$USERCHG = $DEL[0];
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP) = explode(",",$userlist[$USERCHG]);
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
_HERE_;
	USERCHG2($userlist[$USERCHG]);
print <<<_HERE_
<BR><INPUT type="submit" name="Enter" value="결정" name="submit">
</FORM>
<B><FONT color="#ff0000">>><a href="index.cgi">HOME</a> >><a href="admin.cgi">ADMIN</a></b></FONT>
_HERE_;
	FOOTER();
	exit;
#}
}
#========#
# ■ 변 2 #
#========#
function USERCHG2($chnguserdata){
global $admpass,$USERCHG;
list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP) = explode(",",$chnguserdata);
#로그 정보 수정부
$USERCHG1 = ":</TD><TD><INPUT size=\"58\" type=\"text\" name";
$USERCHG2 = "<INPUT size=\"96\" type=\"text\" name";
print <<<_HERE_
<FORM METHOD="POST">
<INPUT type="hidden" name="Password" value="$admpass">
<INPUT type="hidden" name="Command" value="USERCHG3">
<INPUT type="hidden" name="DEL[]" value="$USERCHG">
<TABLE border="1" class="b1">
<TR><TD>ID(id) $USERCHG1="w_id" value="$w_id"></TD></TR>
<TR><TD>패스워드(password) $USERCHG1="w_password" value="$w_password"></TD></TR>
<TR><TD>성(f_name) $USERCHG1="w_f_name" value="$w_f_name"></TD></TR>
<TR><TD>명(l_name) $USERCHG1="w_l_name" value="$w_l_name"></TD></TR>
<TR><TD>성별(sex) $USERCHG1="w_sex" value="$w_sex"></TD></TR>
<TR><TD>클래스(cl) $USERCHG1="w_cl" value="$w_cl"></TD></TR>
<TR><TD>출석 번호(no) $USERCHG1="w_no" value="$w_no"></TD></TR>
<TR><TD>마지막에 행동한 시간(endtime) $USERCHG1="w_endtime" value="$w_endtime"></TD></TR>
<TR><TD>본인의 공격력(att) $USERCHG1="w_att" value="$w_att"></TD></TR>
<TR><TD>본인의 방어력(def) $USERCHG1="w_def" value="$w_def"></TD></TR>
<TR><TD>체력(hit) $USERCHG1="w_hit" value="$w_hit"></TD></TR>
<TR><TD>최대 체력(mhit) $USERCHG1="w_mhit" value="$w_mhit"></TD></TR>
<TR><TD>레벨(level) $USERCHG1="w_level" value="$w_level"></TD></TR>
<TR><TD>경험치(exp) $USERCHG1="w_exp" value="$w_exp"></TD></TR>
<TR><TD>스태미너(sta) $USERCHG1="w_sta" value="$w_sta"></TD></TR>
<TR><TD>장비 무기명<>종류(wep) $USERCHG1="w_wep" value="$w_wep"></TD></TR>
<TR><TD>장비 무기의 공격력(watt) $USERCHG1="w_watt" value="$w_watt"></TD></TR>
<TR><TD>장비 무기의 수량 또는 사용 회수(wtai) $USERCHG1="w_wtai" value="$w_wtai"></TD></TR>
<TR><TD>장비 방어구명<>종류(bou) $USERCHG1="w_bou" value="$w_bou"></TD></TR>
<TR><TD>장비 방어구의 방어력(bdef) $USERCHG1="w_bdef" value="$w_bdef"></TD></TR>
<TR><TD>장비 방어구의 내구력(btai) $USERCHG1="w_btai" value="$w_btai"></TD></TR>
<TR><TD>장비두 방어구명<>종류(bou_h) $USERCHG1="w_bou_h" value="$w_bou_h"></TD></TR>
<TR><TD>장비두 방어구의 방어력(bdef_h) $USERCHG1="w_bdef_h" value="$w_bdef_h"></TD></TR>
<TR><TD>장비두 방어구의 내구력(btai_h) $USERCHG1="w_btai_h" value="$w_btai_h"></TD></TR>
<TR><TD>장비다리 방어구명<>종류(bou_f) $USERCHG1="w_bou_f" value="$w_bou_f"></TD></TR>
<TR><TD>장비다리 방어구의 방어력(bdef_f) $USERCHG1="w_bdef_f" value="$w_bdef_f"></TD></TR>
<TR><TD>장비다리 방어구의 내구력(btai_f) $USERCHG1="w_btai_f" value="$w_btai_f"></TD></TR>
<TR><TD>장비팔방어구명<>종류(bou_a) $USERCHG1="w_bou_a" value="$w_bou_a"></TD></TR>
<TR><TD>장비팔방어구의 방어력(bdef_a) $USERCHG1="w_bdef_a" value="$w_bdef_a"></TD></TR>
<TR><TD>장비팔방어구의 내구력(btai_a) $USERCHG1="w_btai_a" value="$w_btai_a"></TD></TR>
<TR><TD>행동 방침(tactics) $USERCHG1="w_tactics" value="$w_tactics"></TD></TR>
<TR><TD>자신의 살해자(death) $USERCHG1="w_death" value="$w_death"></TD></TR>
<TR><TD>살해시의 코멘트(msg) $USERCHG1="w_msg" value="$w_msg"></TD></TR>
<TR><TD>현상태(수면·치료·통상)(sts) $USERCHG1="w_sts" value="$w_sts"></TD></TR>
<TR><TD>현재 위치(pls) $USERCHG1="w_pls" value="$w_pls"></TD></TR>
<TR><TD>살해 인원수(kill) $USERCHG1="w_kill" value="$w_kill"></TD></TR>
<TR><TD>아이콘 번호(icon) $USERCHG1="w_icon" value="$w_icon"></TD></TR>
<TR><TD>소지 아이템명<>종류(item0) $USERCHG1="w_item0" value="$w_item[0]"></TD></TR>
<TR><TD>소지 아이템의 효력(탄환·화살의 수)(eff0) $USERCHG1="w_eff0" value="$w_eff[0]"></TD></TR>
<TR><TD>소지 아이템의 수량(itai0) $USERCHG1="w_itai0" value="$w_itai[0]"></TD></TR>
<TR><TD>소지 아이템명<>종류(item1) $USERCHG1="w_item1" value="$w_item[1]"></TD></TR>
<TR><TD>소지 아이템의 효력(탄환·화살의 수)(eff1) $USERCHG1="w_eff1" value="$w_eff[1]"></TD></TR>
<TR><TD>소지 아이템의 수량(itai1) $USERCHG1="w_itai1" value="$w_itai[1]"></TD></TR>
<TR><TD>소지 아이템명<>종류(item2) $USERCHG1="w_item2" value="$w_item[2]"></TD></TR>
<TR><TD>소지 아이템의 효력(탄환·화살의 수)(eff2) $USERCHG1="w_eff2" value="$w_eff[2]"></TD></TR>
<TR><TD>소지 아이템의 수량(itai2) $USERCHG1="w_itai2" value="$w_itai[2]"></TD></TR>
<TR><TD>소지 아이템명<>종류(item3) $USERCHG1="w_item3" value="$w_item[3]"></TD></TR>
<TR><TD>소지 아이템의 효력(탄환·화살의 수)(eff3) $USERCHG1="w_eff3" value="$w_eff[3]"></TD></TR>
<TR><TD>소지 아이템의 수량(itai3) $USERCHG1="w_itai3" value="$w_itai[3]"></TD></TR>
<TR><TD>소지 아이템명<>종류(item4) $USERCHG1="w_item4" value="$w_item[4]"></TD></TR>
<TR><TD>소지 아이템의 효력(탄환·화살의 수)(eff4) $USERCHG1="w_eff4" value="$w_eff[4]"></TD></TR>
<TR><TD>소지 아이템의 수량(itai4) $USERCHG1="w_itai4" value="$w_itai[4]"></TD></TR>
<TR><TD>악세사리명<>종류(item5) $USERCHG1="w_item5" value="$w_item[5]"></TD></TR>
<TR><TD>악세사리의 방어력(eff5) $USERCHG1="w_eff5" value="$w_eff[5]"></TD></TR>
<TR><TD>악세사리의 수량(itai5) $USERCHG1="w_itai5" value="$w_itai[5]"></TD></TR>
<TR><TD colspan="2" width="500">로그　　<input type=radio name=Message value=\"add\" class=\"b2\" checked>추가<input type=radio name=Message value=\"change\" class=\"b2\">바꾼다<BR><hr>$w_log</TD></TR>
<TR><TD colspan="2">$USERCHG2="w_log"></TD></TR>
<TR><TD>코멘트(com) $USERCHG1="w_com" value="$w_com"></TD></TR>
<TR><TD>유언(dmes) $USERCHG1="w_dmes" value="$w_dmes"></TD></TR>
<TR><TD>전 전투자의 ID(bid) $USERCHG1="w_bid" value="$w_bid"></TD></TR>
<TR><TD>클럽(club) $USERCHG1="w_club" value="$w_club"></TD></TR>
<TR><TD>돈(money) $USERCHG1="w_money" value="$w_money"></TD></TR>
<TR><TD>구숙련도(wp) $USERCHG1="w_wp" value="$w_wp"></TD></TR>
<TR><TD>총숙련도(wg) $USERCHG1="w_wg" value="$w_wg"></TD></TR>
<TR><TD>참숙련도(wn) $USERCHG1="w_wn" value="$w_wn"></TD></TR>
<TR><TD>투숙련도(wc) $USERCHG1="w_wc" value="$w_wc"></TD></TR>
<TR><TD>폭숙련도(wd) $USERCHG1="w_wd" value="$w_wd"></TD></TR>
<TR><TD>위원회(comm) $USERCHG1="w_comm" value="$w_comm"></TD></TR>
<TR><TD>리밋트(limit) $USERCHG1="w_limit" value="$w_limit"></TD></TR>
<TR><TD>브라우저 돌아오는(bb) $USERCHG1="w_bb" value="$w_bb"></TD></TR>
<TR><TD>부상 개소(우승시 「승」입력)(inf) $USERCHG1="w_inf" value="$w_inf"></TD></TR>
<TR><TD>응전 행동(ousen) $USERCHG1="w_ousen" value="$w_ousen"></TD></TR>
<TR><TD>성격(seikaku) $USERCHG1="w_seikaku" value="$w_seikaku"></TD></TR>
<TR><TD>심리(sinri) $USERCHG1="w_sinri" value="$w_sinri"></TD></TR>
<TR><TD>신아이템명<>종류(item_get) $USERCHG1="w_item_get" value="$w_item_get"></TD></TR>
<TR><TD>신아이템의 효력(탄환·화살의 수)(eff_get) $USERCHG1="w_eff_get" value="$w_eff_get"></TD></TR>
<TR><TD>신아이템의 수량(itai_get) $USERCHG1="w_itai_get" value="$w_itai_get"></TD></TR>
<TR><TD>그룹 ID(teamID) $USERCHG1="w_teamID" value="$w_teamID"></TD></TR>
<TR><TD>그룹 Pass(teamPass) $USERCHG1="w_teamPass" value="$w_teamPass"></TD></TR>
<TR><TD>IP Address(IP) $USERCHG1="w_IP" value="$w_IP"></TD></TR>
</TABLE>
_HERE_;
}
#========#
# ■ 변 3 #
#========#
function USERCHG3(){
global $in,$pref;

global $DEL;
global $w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item0,$w_eff0,$w_itai0,$w_item1,$w_eff1,$w_itai1,$w_item2,$w_eff2,$w_itai2,$w_item3,$w_eff3,$w_itai3,$w_item4,$w_eff4,$w_itai4,$w_item5,$w_eff5,$w_itai5,$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP;
$userlist = @file($pref['user_file']) or ERROR("unable to open user_file");

list($c_id,$c_password,$c_f_name,$c_l_name,$c_sex,$c_cl,$c_no,$c_endtime,$c_att,$c_def,$c_hit,$c_mhit,$c_level,$c_exp,$c_sta,$c_wep,$c_watt,$c_wtai,$c_bou,$c_bdef,$c_btai,$c_bou_h,$c_bdef_h,$c_btai_h,$c_bou_f,$c_bdef_f,$c_btai_f,$c_bou_a,$c_bdef_a,$c_btai_a,$c_tactics,$c_death,$c_msg,$c_sts,$c_pls,$c_kill,$c_icon,$c_item[0],$c_eff[0],$c_itai[0],$c_item[1],$c_eff[1],$c_itai[1],$c_item[2],$c_eff[2],$c_itai[2],$c_item[3],$c_eff[3],$c_itai[3],$c_item[4],$c_eff[4],$c_itai[4],$c_item[5],$c_eff[5],$c_itai[5],$c_log,$c_com,$c_dmes,$c_bid,$c_club,$c_money,$c_wp,$c_wg,$c_wn,$c_wc,$c_wd,$c_comm,$c_limit,$c_bb,$c_inf,$c_ousen,$c_seikaku,$c_sinri,$c_item_get,$c_eff_get,$c_itai_get,$c_teamID,$c_teamPass,$c_IP) = explode(",",$userlist[$DEL[0]]);
if($in['Mess'] != "change"){$w_log = "$c_log$w_log";}
$userlist[$DEL[0]] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item0,$w_eff0,$w_itai0,$w_item1,$w_eff1,$w_itai1,$w_item2,$w_eff2,$w_itai2,$w_item3,$w_eff3,$w_itai3,$w_item4,$w_eff4,$w_itai4,$w_item5,$w_eff5,$w_itai5,$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,\n";

$handle = @fopen($pref['user_file'],'w') or ERROR("unable to open user_file");
if(!@fwrite($handle,implode('',$userlist))){ERROR("unable to write user_file");}
fclose($handle);

USERLIST();
}
?>