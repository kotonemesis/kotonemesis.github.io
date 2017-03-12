<?php
require "pref.php";

$ok = $ng = $idou = 0;

$userlist = @file($pref['user_file']) or ERROR("unable to open user_file","","RANK",__FUNCTION__,__LINE__);

usort($userlist,"fcomp1");
#usort($userlist,"fcomp2");

$log = "<center><font color=\"#FF0000\" face=\"MS P내일 아침\" size=\"6\"><span id=\"BR\" style=\"width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline\">Survivor List</span></font></center>";
$log .= "<TABLE border=\"1\"><tr align=\"center\" class=\"b1\"><td class=\"b1\">Name<br>Class Number</td><td width=\"70\" class=\"b1\">Avatar</td><td class=\"b1\">Lv</td><td class=\"b1\">Kills</td><td class=\"b1\"Group</td><td width=\"300\" class=\"b1\">Comment</td></tr>\n";
foreach ($userlist as $usrlst) {list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$usrlst);
	if($hackflg == 0){if(($w_hit > 0)&&(!preg_match("/NPC/",$w_sts))){DISPLAY() ;$rnk2++;$ok++;}else{ $ng++;}}
	else {if($w_hit > 0){DISPLAY() ;$rnk2++;$ok++;}else{$ng++;}}
	if(($w_sts == "정상")&&($w_hit > 0)){$idou++;}
}
$log .= "</table><BR>\n";
$log .= "【Survivors：{$ok} People】　【Currently Moving：{$idou} People】</table><BR><BR>\n";
$log .= "<B><a href=\"index.php\">HOME</A></B><BR>\n";

HEAD();
print $log;
FOOTER();
UNLOCK();
exit;

// 소트 조건의 작성
function fcomp1($x,$y){
	$a = explode(",",$x);
	$b = explode(",",$y);
	if($b["13"] > $a["13"]){return 1;}
	elseif($b["13"] < $a["13"]){return -1;}
	else{return 0;}
}
function fcomp2($x,$y){
	$a = explode(",",$x);
	$b = explode(",",$y);
	if($b["35"] > $a["35"]){return 1;}
	elseif($b["35"] < $a["35"]){return -1;}
	else{return 0;}
}

#=============#
# ■ 표시부   #
#=============#
function DISPLAY(){
global $pref;
global $w_f_name,$w_l_name,$w_cl,$w_sex,$w_no,$w_icon,$w_level,$w_kill,$w_teamID,$w_com,$icon_file,$log,$rnk2;
$log .= '<tr class="b3"><td align="center" class="b3">'.$w_f_name.' '.$w_l_name.'<br>'.$w_cl.' '.$w_sex.$w_no.'차례</td><td align="center" class="b3"><IMG src="'.$pref['imgurl'].'/'.$icon_file[$w_icon].'" width="70" height="70" border="0" align="absmiddle"></td><td class="b3">'.$w_level.'</td><td class="b3">'.$w_kill.'</td><td class="b3">'.$w_teamID.'</td><td class="b3">'.$w_com.'</td></tr>';
}
?>