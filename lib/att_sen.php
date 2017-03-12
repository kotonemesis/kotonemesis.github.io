<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR ATTACK PROGRAM    - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ ATTACK1			-		선제 공격 처리 ■
#□■□■□■□■□■□■□■□■□■□■□
#=================#
# ■ 선제 공격 처리 #
#=================#
function ATTACK1(){
global $in,$pref;

global $mhit,$tactics,$id,$kiri,$log,$w_l_name,$w_no,$wep,$w_pls,$w_club,$watt,$att,$atp,$def,$bou,$bdef,$bdef_h,$bdef_a,$bdef_f,$item,$dfp,$atn,$dfn,$pls;
global $mei2,$wtai,$l_name,$wp,$mei,$weps,$weps2,$l_name,$wk;
global $limit,$level,$jyuku1,$jyuku2,$pnt,$hakaiinf2,$kega2,$hakaiinf3,$kega3;
global $wep_2,$watt_2,$wtai_2,$w_inf_2,$exp,$hour,$min,$sec,$f_name,$l_name,$cl,$sexx,$no,$exp,$hissatsu1,$hissatsu2;
global $btai,$hit,$w_wep_2,$w_watt_2,$w_wtai_2,$inf_2,$w_kind,$w_kind2,$bid,$w_bid,$w_teamID,$teamID;

require $pref['LIB_DIR'].'/lib2.php';
$kega2 = $kega3 = $hakaiinf2 = $hakaiinf3 = '';

$i = 0;
$result = 0;
$result2 = 0;
$dice1 = rand(0,100);
$dice2 = rand(0,100);
if(preg_match('/브라스 밴드부|바둑부|ZION|축구부|라크로스부/',$pref['clb'][$in['club']])){$dice3 = rand(0,110);}
else{$dice3 = rand(0,100);}
list($a,$w_kind,$wid) = explode("_",$in['Command']);

$userlist = @file($pref['user_file']) or ERROR('unable to open file user_file','','ATT_SEN',__FUNCTION__,__LINE__);
global $w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item,$w_eff,$w_itai,$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP;
for($i=0;$i<count($userlist);$i++){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$i]);
	if(IDcrypt($w_id) == $wid){break;}
}
#<---련투
if(preg_match("/&/",$w_bid)){#분할
	list($w_bid1,$w_bid2) = explode("/&/",$w_bid);
}else{
	$w_bid1 = $w_bid;
	$w_bid2 = '';
}
if((($tactics != "련투행동")&&($w_bid1 == $id)&&($w_bid2 == $teamID))||($w_hit <= 0)){ERROR("부정 액세스입니다","rento is not valid","ATT_SEN",__FUNCTION__,__LINE__);}
#련투--->
BB_CK();#브라우저 백 대처
if($kiri){$log = ($log . "전투 개시!<br>");}else{$log = ($log . "{$w_f_name} {$w_l_name}({$w_cl} {$w_sex}{$w_no}차례)와 전투 개시!<br>");}

list($w_name,$a) = explode("<>",$wep);
list($w_name2,$w_kind2) = explode("<>",$w_wep);
TACTGET() ;TACTGET2();#기본 행동

#플레이어
if(((preg_match("/G|A/",$wep))&&($wtai == 0))||((preg_match("/G|A/",$wep))&&($w_kind == "WB"))){$att_p = (($watt/10) + $att) * $atp;}
else{$att_p = ($watt + $att) * $atp;}
$ball = $def + $bdef + $bdef_h + $bdef_a + $bdef_f;
if(preg_match("/AD/",$item[5])){$ball += $eff[5];}#장식이 방어구?
$def_p = $ball * $dfp;
#적
if((preg_match("/G|A/",$w_wep))&&($w_wtai == 0)){$att_n = (($w_watt/10) + $w_att) * $atn;}
else{$att_n = ($w_watt + $w_att) * $atn;}
$ball2 = $w_def + $w_bdef + $w_bdef_h + $w_bdef_a + $w_bdef_f;
if(preg_match("/AD/",$w_item[5])){$ball2 += $w_eff[5];}#장식이 방어구?
$def_n = $ball2 * $dfn;

BLOG_CK();
EN_KAIFUKU();

$in['Command']="BATTLE";

if($w_pls != $pls){
	if($kiri){$log = ($log . "그러나, 도망가 버렸다!<br>") ;SAVE() ;return;}
	else{$log = ($log . "그러나,{$w_f_name} {$w_l_name}({$w_cl} {$w_sex}{$w_no}차례)에게 차여 버렸다!<br>") ;SAVE() ;return;}
}#이미 이동?

if((strlen($in['Dengon']) > 0)&&(!preg_match("/초필살기술|필살기술/",$in['Dengon']))){
	if($kiri){
		$log = ($log . "<font color=\"lime\"><b>불명 「".$in['Dengon']."」</b></font><br>");
		$w_log = ($w_log . "<font color=\"lime\"><b>{$hour}:{$min}:{$sec} 불명 「".$in['Dengon']."」</b></font><br>");
	}else{
		$log = ($log . "<font color=\"lime\"><b>{$f_name} {$l_name}({$cl} {$sexx}{$no}차례) 「".$in['Dengon']."」</b></font><br>");
		$w_log = ($w_log . "<font color=\"lime\"><b>{$hour}:{$min}:{$sec} {$f_name} {$l_name}({$cl} {$sexx}{$no}차례) 「".$in['Dengon']."」</b></font><br>");
	}
}

WEPTREAT($w_name,$w_kind,$wtai,$l_name,$w_l_name,"공격","PC");
if($dice1 < $mei){#공격 성공
	#공격(공격력*숙련도)
	$result = $att_p * $wk;
	#방송부 특수
	if((strlen($in['Dengon']) > 0)&&($pref['clb'][$in['club']] == "방송부")){$result *= 1.2;}
	#필살기술
	$hissatsu1 = rand(0,100);
	if($limit >= 100){
		$result *= 1.7;
		$log = ($log . "　<font color=\"red\"><b>리밋트 브레이크 발동!</b></font><br>");
		$hissatsu1 = "(리)";
		$limit -= 100;
	}elseif(($level >= 10)&&($jyuku1 >= 200)&&($hissatsu1 < 1)){
		$result *= 1.6;
		$log = ($log . "　<font color=\"red\"><b>비장의 기술 발동!</b></font><br>");
		$hissatsu1 = "(비)";
	}elseif(($jyuku1 >= 100)&&($hit <= 100)&&($in['Dengon'] == "초필살기술")){
		$in['Dengon'] = '';
		if($limit >= 30){
			if((int)($mhit * 0.9) >= 0){
				$result += (int)($mhit * 0.1);
				$mhit = (int)($mhit * 0.9);
				if($hit > $mhit){$hit = $mhit;}
				$limit -= 30;
				$log = ($log . "　<font color=\"red\"><b>초필살기술 발동!</b></font><br>");
				$hissatsu1 = "(초)";
			}else{$log = ($log . "　<font color=\"red\">초필살기술 발동에 필요한 최대 체력이 없습니다</font><br>");}
		}else{$log = ($log . "　<font color=\"red\">초필살기술 발동에 필요한 리밋트가 없습니다</font><br>");}
	}elseif(($jyuku1 >= 40)&&($in['Dengon'] == "필살기술")){
		$in['Dengon'] = '';
		if($limit >= 15){
			if($hit > (int)($mhit * 0.1)){
				$result += (int)($mhit * 0.06);
				$hit -= (int)($mhit * 0.1);
				$limit -= 15;
				$log = ($log . "　<font color=\"red\"><b>필살기술 발동!</b></font><br>");
				$hissatsu1 = "(필)";
			}else{$log = ($log . "　<font color=\"red\">필살기술 발동에 필요한 체력이 없습니다</font><br>");}
		}else{$log = ($log . "　<font color=\"red\">필살기술 발동에 필요한 리밋트가 없습니다</font><br>");}
	}elseif(($level >= 3)&&($jyuku1 >= 20)&&($hissatsu1 < 5)){
		$result *= 1.3;
		$log = ($log . "　<font color=\"red\"><b>위기 히트!</b></font><br>");
		$hissatsu1 = "(쿠)";
	}else{$hissatsu1 = '';}
	#공격(-방어 /2+=rand)
	$result -= $def_n;
	$result /= 2;
	$result += rand(0,$result);

	DEFTREAT($w_kind,"NPC");
	$result = (int)($result * $pnt);

	if($result <= 0){$result = 1;}
	if($pref['clb'][$w_club]=='락부' && $result > $w_hit && 1 == rand(1,10)){$result = $w_hit - 1;}
	$log = ($log . "　　<font color=\"red\"><b>{$result}데미지 {$hakaiinf3} {$kega3}</b></font>!<br>");
	$w_hit -= $result;$w_btai--;
	if($w_btai <= 0){$w_bou = "속옷<>DN";$w_bdef=0;$w_btai="∞";}

	$wep = $wep_2;$watt = $watt_2;$wtai = $wtai_2;$w_inf = $w_inf_2;
	#경험치-자신
	$expup = (int)(($w_level - $level)/3) ;if($expup < 1){$expup = 1;}$exp += $expup;
	#리밋트-상대
	if($pref['clb'][$w_club]=='락부'){$div=2.5;}else{$div=3;}
	$w_limitup = (int)(($level - $w_level) /$div) ;if($w_limitup < 1){$w_limitup = 1;}$w_limit += $w_limitup;
}else{$kega3='';$log = ($log . "　　그러나, 피할 수 있었다!<br>");}

if($w_hit <= 0){DEATH2();}#적사망?
elseif(($dice3 < 50)&&(!preg_match("/치료 전념|도망 몸의 자세/",$w_ousen))){#반격

	if($weps == $weps2 || $weps2 == 'M'){#거리 함께?

		WEPTREAT($w_name2,$w_kind2, $w_wtai,$w_l_name,$l_name,"반격","NPC");

		if($dice2 < $mei2){#공격 성공
			#공격(공격력*숙련도)
			$result2 = $att_n*$wk;
		#필살기술
			$hissatsu2 = rand(0,100);
			if($w_limit >= 100){
				$result2 *= 1.5;
				$w_log = ($w_log . "　<font color=\"red\"><b>리밋트 브레이크 발동!</b></font><br>");
				$hissatsu2 = "(리)";
				$w_limit -= 100;
			}elseif(($w_level >= 10)&&($jyuku2 >= 200)&&($hissatsu2 < 1)){
				$result2 *= 1.4;
				$w_log = ($w_log . "　<font color=\"red\"><b>비장의 기술 발동!</b></font><br>");
				$hissatsu2 = "(비)";
			}elseif(($w_level >= 3)&&($jyuku2 >= 20)&&($hissatsu2 < 4)){
				$result2 *= 1.1;
				$w_log = ($w_log . "　<font color=\"red\"><b>위기 히트!</b></font><br>");
				$hissatsu2 = "(쿠)";
			}else{$hissatsu2 = '';}
			#공격(-방어 /2+=rand)
			$result2 -= $def_p;
			$result2 /= 2;
			$result2 += rand(0,$result2);
			$result2 = (int)($result2);

			DEFTREAT($w_kind2,"PC");
			$result2 = (int)($result2 * $pnt);

			if($result2 <= 0){$result2 = 1;}
			if($pref['clb'][$club]=='락부' && $result2 > $hit && 1 == rand(1,10)){$result2 = $hit - 1;}
			$log = ($log . "　　<font color=\"red\"><b>{$result2}데미지 {$kega2}</b></font>!<br>");

			$btai--;$hit -= $result2;

			if($btai <= 0){$bou = "속옷<>DN";$bdef=0;$btai="∞";}

			if($hit <=0){DEATH();}#사망?
			else{#도망
				if($kiri){$log = ($log . "상대는 잘 도망쳤다….<br>");}
				else{$log = ($log . "$w_l_name 는 잘 도망쳤다….<br>");}
			}
			if($kiri){$w_log = ($w_log . "<font color=\"yellow\"><b>{$hour}:{$min}:{$sec} 전투：불명공{$hissatsu2}:{$result2} 피{$hissatsu1}:{$result} {$hakaiinf2} {$kega3}</b></font><br>");}
			else{$w_log = ($w_log . "<font color=\"yellow\"><b>{$hour}:{$min}:{$sec} 전투：{$f_name} {$l_name}({$cl} {$sexx}{$no}번) 공{$hissatsu2}:{$result2} 피{$hissatsu1}:{$result} {$hakaiinf2} {$kega3}</b></font><br>");}
			$w_wep = $w_wep_2;$w_watt = $w_watt_2;$w_wtai = $w_wtai_2;$inf = $inf_2;
		#경험치-상대
			$expup = (int)(($level - $w_level)/3) ;if($expup < 1){$expup = 1;}$w_exp += $expup;
		#리밋트-자신
			if($pref['clb'][$club]=='락부'){$div=2.5;}else{$div=3;}
			$limitup = (int)(($w_level - $level) /$div) ;if($limitup < 1){$limitup = 1;}$limit += $limitup;
		}else{
			if($kiri){$w_log = ($w_log . "<font color=\"yellow\"><b>{$hour}:{$min}:{$sec} 전투：불명피{$hissatsu1}:{$result} {$kega3}</b></font><br>");}
			else{$w_log = ($w_log . "<font color=\"yellow\"><b>{$hour}:{$min}:{$sec} 전투：{$f_name} {$l_name}({$cl} {$sexx}{$no}번) 피{$hissatsu1}:{$result} {$kega3}</b></font><br>");}
			$log = ($log . "　　그러나, 절박함 피했다!<br>");
		}
		#무기 소모
		if((preg_match("/G|A/",$w_kind2))&&($w_wtai > 0)){$w_wtai--;if($w_wtai <= 0){$w_wtai = 0;}}#총·쏘아 맞혀?
		elseif(preg_match("/C|D/",$w_kind2)){$w_wtai--;if($w_wtai <= 0){$w_wep ="맨손<>WP";$w_watt=0;$w_wtai="∞";}}
		elseif((preg_match("/K/",$w_kind2))&&(rand(0,5) == 0)){$w_watt -= rand(1,3) ;if($w_watt <= 0){$w_wep ="맨손<>WP";$w_watt=0;$w_wtai="∞";}}

	}else{
		if($kiri){
			$log = ($log . "상대는 반격 할 수 없다!<br>　상대는 잘 도망쳤다….<br>");
			$w_log = ($w_log . "<font color=\"yellow\"><b>{$hour}:{$min}:{$sec} 전투：불명피{$hissatsu1}:{$result} {$hakaiinf2} {$kega3}</b></font><br>");
		}else{
			$log = ($log . "{$w_l_name} 는 반격 할 수 없다!<br>　{$w_l_name} 는 잘 도망쳤다….<br>");
			$w_log = ($w_log . "<font color=\"yellow\"><b>{$hour}:{$min}:{$sec} 전투：{$f_name} {$l_name}({$cl} {$sexx}{$no}번) 피{$hissatsu1}:{$result} {$hakaiinf2} {$kega3}</b></font><br>");
		}
	}
}else{	#도망
	if($kiri){
		$log = ($log . "상대는 잘 도망쳤다….<br>");
		$w_log = ($w_log . "<font color=\"yellow\"><b>{$hour}:{$min}:{$sec} 전투：불명피{$hissatsu1}:{$result} {$hakaiinf2} {$kega3}</b></font><br>");
	}else{
		$log = ($log . "$w_l_name 는 잘 도망쳤다….<br>");
		$w_log = ($w_log . "<font color=\"yellow\"><b>{$hour}:{$min}:{$sec} 전투：{$f_name} {$l_name}({$cl} {$sexx}{$no}번) 피{$hissatsu1}:{$result} {$hakaiinf2} {$kega3}</b></font><br>");
	}
	if($w_ousen == '도망 몸의 자세'){#도망 몸의 자세 자동 회피
		$w_pls = RUN_AWAY($w_pls);
		$w_log = ($w_log . "<font color=\"lime\"><b>".$pref['place'][$w_pls]."에 이동했다.</b></font><br>");
	}
}
#NPC 자동 이동
if(($w_sts == "NPC")&&(preg_match("/병사/",$w_f_name))){#도망 몸의 자세 자동 회피
	$w_pls = RUN_AWAY($w_pls);
	$w_log = ($w_log . "<font color=\"lime\"><b>".$pref['place'][$w_pls]."에 이동</b></font><br>");
}
#무기 소모
if	 ((preg_match("/G|A/",$w_kind))&&($wtai > 0)){$wtai--;if($wtai <= 0){$wtai = 0;}}#총·쏘아 맞혀?
elseif(preg_match("/C|D/",$w_kind)){$wtai--;if($wtai <= 0){$wep ="맨손<>WP";$watt=0;$wtai="∞";}}
elseif((preg_match("/K/",$w_kind))&&(rand(0,5) == 0)){$watt -= rand(1,3) ;if($watt <= 0){$wep ="맨손<>WP";$watt=0;$wtai="∞";}}

LVUPCHK();

$w_bid = $id;
if(($teamID != '없음')&&($teamID != '')){$w_bid .= '&'.$teamID;}
$bid = $w_id;
if(($w_teamID != '없음')&&($w_teamID != '')){$bid .= '&'.$w_teamID;}

SAVE();
SAVE2();
}
?>