<?php
require 'pref.php';
DECODE();
HEAD();
if		(isset($in['mode']) && $in['mode']=='TOP')		{TOP();}
elseif	(isset($in['mode']) && $in['mode']=='history')	{DISP();}
else													{TOP();}
FOOTER();
UNLOCK();
exit;
#===========#
# ■ 표시부 #
#===========#
function DISP(){
global $in,$pref;

if($in['Command']=='WINNER' && $pref['oldwinner']){
	require 'winner_old.php';
}else{
	$userlist = @file($pref['win_file']) or ERROR("unable to open win_file");
	global $WINNUM,$win_log,$win_ver,$id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item,$eff,$itai,$log,$com,$dmes,$bid,$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass;
	list($WINNUM,$win_log,$win_ver,$id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$com,$dmes,$bid,$in['club'],$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,$in['IP'],) = explode(",",$userlist[$in['Command']]);
	if(is_file($pref['LOG_DIR'].'/win/'.$win_log.'userdatfile.log')){
		$userlist2 = @file($pref['LOG_DIR'].'/win/'.$win_log.'userdatfile.log') or ERROR('unable to open user_file','','LIB1',__FUNCTION__,__LINE__);
		for($i=0;$i<count($userlist2);$i++){#ID일치?
			list($w_i,$w_p,$a) = explode(',',$userlist2[$i]);
			if(($id == $w_i)&&($password == $w_p)){
				$Index=$i;
				break;
			}
		}
		if($Index){
			list($id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$com,$dmes,$bid,$in['club'],$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,$in['IP'],) = explode(",",$userlist2[$Index]);
		}
	}
	require $pref['LIB_DIR'].'/dsp_sts.php';
	require $pref['LIB_DIR'].'/dsp_cmd.php';

	$in['Command'] = "열람";
	$sts = "우승";
	STS();
	global $win_log;
	require_once $pref['LIB_DIR'].'/lib4.php';
	echo '</TABLE>';
	
	if($win_log != ''){
		if(is_file($pref['LOG_DIR'].'/win/'.$win_log.'areafile.log')){
			$pref['arealist'] = @file($pref['LOG_DIR'].'/win/'.$win_log.'areafile.log');
			$ar = explode(',',$pref['arealist'][4]);
		}else{
			$ar = '';
		}
		if(is_file($pref['LOG_DIR'].'/win/'.$win_log.'newsfile.log')){
			$log = news($pref['LOG_DIR'].'/win/'.$win_log.'newsfile.log',$ar);
			echo '</center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">진행 상황</span></font></center>';
			echo '<TABLE border="0" cellspacing="0" cellpadding="0"><TR><TD><img border="0" src="'.$pref['imgurl'].'/i_sakamochi.jpg" width="70" height="70"></TD><TD>「모두―, 건강하게 하고 있어 아.<BR>그러면, 지금까지의 상황 입니다.<BR>오늘도 하루 힘내자-―.」</TD></TR></TABLE>';
			echo $log;
			echo '</UL><center><B><a href="index.php">HOME</A></B><BR>';
		}
	}
}
}
#===============#
# ■ 메인 처리 #
#===============#
function TOP(){
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">우승자 이력</span></font></center>
<FORM METHOD="POST" name="BR">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="history">
<TABLE border="1" cellspacing="0" cellpadding="0">
<TR height="20"><TD class="b1">&nbsp;</TD><TD class="b1">회</TD><TD class="b1">우승자명</TD><TD class="b1">Version</A></TD></TR>
_HERE_;
fnclist();
print '</TABLE><BR><INPUT type="submit" name="Enter" value="열람"></FORM>';
}
#===============#
# ■ 리스트 프로세싱 #
#===============#
function fnclist(){
global $pref;

$userlist = @file($pref['win_file']) or ERROR("unable to open win_file");
for ($i=0; $i < count($userlist); $i++) {
	@list($WINNUM,$pref['log_file'],$win_ver,$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$i]);
	if($w_id != "NOWINNER"){
		echo '<TR height="20">';
		Auto();
		echo "<TD class=\"b2\"><INPUT type=\"radio\" name=\"Command\" value=\"$i\"></TD><TD class=\"b2\">$WINNUM</TD><TD class=\"b2\">-$w_f_name $w_l_name-</TD><TD class=\"b2\">$win_ver</TD></TR></A>";
	}else{
		echo "<TR height=\"20\"><TD class=\"b3\">&nbsp;</TD><TD class=\"b3\">$WINNUM</TD><TD class=\"b3\">없음</TD><TD class=\"b3\">$win_ver</A></TD></TR>";
	}
}
print "<TR><TD colspan=\"4\" class=\"b3\"></TD></TR>";
if ($pref['oldwinner']) {print "<TR height=\"20\">";Auto() ;print "<TD class=\"b2\"><INPUT type=\"radio\" name=\"Command\" value=\"WINNER\"></TD><TD colspan=\"3\" class=\"b2\">&nbsp;□■□■□■과거 우승자■□■□■□</TD></TR></A>";}
}
?>