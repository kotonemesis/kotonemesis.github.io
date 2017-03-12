<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR ATTACK PROGRAM    - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ ATTACK2			-		후공 공격 처리 ■
#□■□■□■□■□■□■□■□■□■□■□
#==================#
# ■ 후공 공격 처리  #
#==================#
function ATTACK2(){
global $in,$pref;

global $w_sts,$w_club,$wep,$w_wep,$watt,$att,$atp,$def,$bou,$bdef,$bdef_h,$bdef_a,$bdef_a,$bdef_f,$item,$dfp,$w_wtai,$w_watt,$w_att,$atn,$w_def,$w_bou,$w_btai,$w_bdef,$w_bdef_h,$w_bdef_a,$w_bdef_f,$w_item,$dfn;
global $w_hit,$log,$w_f_name,$w_l_name,$w_cl,$w_sex,$w_no,$l_name;
global $mei2,$hit,$w_teamID;
global $wk,$w_limit,$w_level,$pnt,$inf,$w_inf;
global $jyuku2,$limit,$btai,$w_wep_2,$w_watt_2,$w_wtai_2,$inf_2,$level,$w_exp,$weps,$weps2,$wtai,$mei,$w_log,$hour,$min,$sec,$f_name,$l_name,$cl,$sexx,$no;
global $jyuku1,$wep_2,$watt_2,$wtai_2,$w_inf_2,$exp;
global $hissatsu1,$hissatsu2,$w_ousen,$kega2,$kega3,$hakaiinf2,$hakaiinf3,$w_kind,$w_kind2;
if($w_hit <= 0){ERROR('부정 액세스입니다','no hit','ATT_KOU',__FUNCTION__,__LINE__);}

$kega2 = $kega3 = $hakaiinf2 = $hakaiinf3 = '';

$result = 0;
$result2 = 0;
$i = 0;
$dice1 = rand(0,100);
if(preg_match('/브라스 밴드부|바둑부|ZION|축구부|라크로스부/',$pref['clb'][$w_club])){$dice2 = rand(0,110);}
else{$dice2 = rand(0,100);}
if($pref['clb'][$w_club] == '유도부'){$dice3 = rand(0,90);}
else{$dice3 = rand(0,100);}
list($w_name,$w_kind) = explode("<>",$wep);
list($w_name2,$w_kind2) = explode("<>",$w_wep);

TACTGET() ;TACTGET2();	#기본 행동

#플레이어
if((preg_match("/G|A/",$wep)) && ($wtai == 0)){$att_p = (($watt/10) + $att) * $atp;}
else{$att_p = ($watt + $att) * $atp;}
$ball = $def + $bdef + $bdef_h + $bdef_a + $bdef_f;
if(preg_match("/AD/",$item[5])){$ball += $eff[5];}#장식이 방어구?
$def_p = $ball * $dfp;

#적
if((preg_match('/G|A/',$w_wep)) && ($w_wtai == 0)){$att_n = (($w_watt/10) + $w_att) * $atn;}
else{$att_n = ($w_watt + $w_att) * $atn;}
$ball2 = $w_def + $w_bdef + $w_bdef_h + $w_bdef_a + $w_bdef_f;
if(preg_match('/AD/',$w_item[5])){$ball += $w_eff[5];}#장식이 방어구?
$def_n = $ball2 * $dfn;

BLOG_CK();
EN_KAIFUKU();

$in['Command']='BATTLE';

$log .= $w_f_name.' '.$w_l_name.'('.$w_cl.' '.$w_sex.$w_no.'차례)가<BR>　　　　　　　　　　　　　　　갑자기 덤벼 들어 왔다!<br>';

WEPTREAT($w_name2,$w_kind2,$w_wtai,$w_l_name,$l_name,'공격','NPC');
if($dice2 < $mei2){	#공격 성공
	#공격(공격력*숙련도)
	$result = $att_n*$wk;
	#필살기술
	$hissatsu1 = rand(0,100);
	if($w_limit >= 100){
		$result *= 1.5;
		$log .= '　<font color="red"><b>리밋트 브레이크 발동!</b></font><br>';
		$hissatsu1 = '(리)';
		$w_limit -= 100;
	}elseif(($level >= 10)&&($jyuku1 >= 200)&&($hissatsu1 < 1)){
		$result *= 1.4;
		$log .= '　<font color="red"><b>비장의 기술 발동!</b></font><br>';
		$hissatsu1 = "(비)";
	}elseif(($level >= 3)&&($jyuku1 >= 20)&&($hissatsu1 < 4)){
		$result *= 1.1;
		$log .= '　<font color="red"><b>위기 히트!</b></font><br>';
		$hissatsu1 = '(쿠)';
	}else{$hissatsu1 = '';}

	#공격(-방어 /2+=rand)
	$result -= $def_p;
	$result /= 2;
	$result += rand(0,$result);
	$result = (int)($result);

	DEFTREAT($w_kind2,'PC');
	$result = (int)($result * $pnt);

	if($result <= 0){$result = 1;}
	if($pref['clb'][$club]=='락부' && $result > $hit && 1 == rand(1,10)){$result = $hit - 1;}
	$log .= '　　<font color="red"><b>'.$result.'데미지 '.$kega2.'</b>!</font><br>';

	$hit -= $result;$btai--;

	if($btai <= 0){$bou = '속옷<>DN';$bdef=0;$btai='∞';}
	$w_wep = $w_wep_2;$w_watt = $w_watt_2;$w_wtai = $w_wtai_2;$inf = $inf_2;
	list($w_name2,$w_kind2) = explode("<>",$w_wep);
#경험치-적
	$expup = (int)(($level - $w_level)/3) ;if($expup <1){$expup = 1;}$w_exp += $expup;
#리밋트-자신
	if($pref['clb'][$club]=='락부'){$div=2.5;}else{$div=3;}
	$limitup = (int)(($w_level - $level) /$div) ;if($limitup < 1){$limitup = 1;}$limit += $limitup;
}else{
	$log .= '그러나, 절박함 피했다!<br>';
}

if($hit <= 0){DEATH();}#사망?
elseif($dice3 < 50){#반격

	if($weps == $weps2 || $weps == 'M'){#거리 함께?

		WEPTREAT($w_name, $w_kind,  $wtai, $l_name, $w_l_name, '반격','PC');

		if($dice1 < $mei){	#공격 성공
			#공격(공격력*숙련도)
			$result2 = $att_p*$wk;
			#필살기술
			$hissatsu2 = rand(0,100);
			if($limit >= 100){
				$result2 *= 1.7;
				$log .= '　<font color="red"><b>리밋트 브레이크 발동!</b></font><br>';
				$hissatsu2 = "(리)";
				$limit -= 100;
			}elseif(($w_level >= 10)&&($jyuku2 >= 200)&&($hissatsu2 < 1)){
				$result2 *= 1.6;
				$log .= '　<font color="red"><b>비장의 기술 발동!</b></font><br>';
				$hissatsu2 = '(비)';
			}elseif(($w_level >= 3)&&($jyuku2 >= 20)&&($hissatsu2 < 5)){
				$result2 *= 1.3;
				$log .= '　<font color="red"><b>위기 히트!</b></font><br>';
				$hissatsu2 = "(쿠)";
			}else{$hissatsu2 = "";}
			#공격(-방어 /2+=rand)
			$result2 -= $def_n;
			$result2 /= 2;
			$result2 += rand(0,$result2);
			$result2 = (int)($result2);

			DEFTREAT($w_kind,'NPC');
			$result2 = (int)($result2 * $pnt);

			if($result2 <= 0){$result2 = 1;}
			if($pref['clb'][$w_club]=='락부' && $result2 > $w_hit && 1 == rand(1,10)){$result2 = $w_hit - 1;}
			$log .= '　　<font color="red"><b>'.$result2.'데미지 '.$hakaiinf3.' '.$kega3.'</b>!</font><br>';

			$w_hit -= $result2;$w_btai--;

			if($w_btai <= 0){$w_bou = '속옷<>DN';$w_bdef=0;$w_btai='∞';}

			if($w_hit <=0){#사망?
				DEATH2();
			}else{#도망
				$log .= '　'.$l_name.'는 잘 도망쳤다….<br>';
			}

			$w_log .= '<font color="yellow"><b>'.$hour.':'.$min.':'.$sec.'전투：'.$f_name.' '.$l_name.'('.$cl.' '.$sexx.$no.'번) 공'.$hissatsu2.':'.$result.'피'.$hissatsu1.':'.$result2.' '.$hakaiinf2.' '.$kega3.'</b></font><br>';
			$wep = $wep_2;$watt = $watt_2;$wtai = $wtai_2;$w_inf = $w_inf_2;
			list($w_name,$w_kind) = explode('<>',$wep);
		#경험치-자신
			$expup = (int)(($w_level - $level)/3) ;if($expup <1){$expup = 1;}$exp += $expup;
		#리밋트-상대
			if($pref['clb'][$w_club]=='락부'){$div=2.5;}else{$div=3;}
			$w_limitup = (int)(($level -$w_level) /$div) ;if($w_limitup < 1){$w_limitup = 1;}$w_limit += $w_limitup;
		}else{
			$w_log .= '<font color="yellow"><b>'.$hour.':'.$min.':'.$sec.'전투：'.$f_name.' '.$l_name.'('.$cl.' '.$sexx.$no.'번) 공'.$hissatsu2.':'.$result.' '.$hakaiinf2.'</b></font><br>';
			$log .= '그러나, 피할 수 있었다!<br>';
		}
		#무기 소모
		if((preg_match('/G|A/',$w_kind)) && ($wtai > 0)){$wtai--;if($wtai <= 0){$wtai = 0;}}#총·쏘아 맞혀?
		elseif(preg_match('/C|D/',$w_kind)){$wtai--;if($wtai <= 0){$wep ='맨손<>WP';$watt=0;$wtai='∞';}}
		elseif((preg_match('/K/',$w_kind)) && (rand(0,5) == 0)){$watt -= rand(1,3) ;if($watt <= 0){$wep ='맨손<>WP';$watt=0;$wtai='∞';}}
	}else{
		$log .= $l_name.'는 반격 할 수 없다!<br>　'.$l_name.'는 잘 도망쳤다….<br>';
		$w_log .= '<font color="yellow"><b>'.$hour.':'.$min.':'.$sec.'전투：'.$f_name.' '.$l_name.'('.$cl.' '.$sexx.$no.'번) 공'.$hissatsu2.':'.$result.' '.$hakaiinf2.' '.$kega3.'</b></font><br>';
	}
}else{	#도망
	$log .= $w_l_name.'는 잘 도망쳤다….<br>';
	$w_log .= '<font color="yellow"><b>'.$hour.':'.$min.':'.$sec.'전투：'.$f_name.' '.$l_name.'('.$cl.' '.$sexx.$no.'번) 피'.$hissatsu1.':'.$result.' '.$hakaiinf2.' '.$kega3.'</b></font><br>';
	if($w_ousen == '도망 몸의 자세'){#도망 몸의 자세 자동 회피
		global $w_pls;
		$w_pls = RUN_AWAY($w_pls);
		$w_log .= '<font color="lime"><b>'.$pref['place'][$w_pls].'에 이동했다.</b></font><br>';
	}
}
if(($w_sts == 'NPC')&&(preg_match('/병사/',$w_f_name))){#도망 몸의 자세 자동 회피
	global $w_pls;
	$w_pls = RUN_AWAY($w_pls);
	$w_log .= '<font color="lime"><b>'.$pref['place'][$w_pls].'에 이동</b></font><br>';
}
#무기 소모
if((preg_match('/G|A/',$w_kind2)) && ($w_wtai > 0)){$w_wtai--;if($w_wtai <= 0){$w_wtai = 0;}}#총·쏘아 맞혀?
elseif(preg_match('/C|D/',$w_kind2)){$w_wtai--;if($w_wtai <= 0){$w_wep = '맨손<>WP';$w_watt=0;$w_wtai='∞';}}
elseif((preg_match('/K/',$w_kind2)) && (rand(0,5) == 0)){$w_watt -= rand(1,3) ;if($w_watt <= 0){$w_wep ='맨손<>WP';$w_watt=0;$w_wtai='∞';}}
LVUPCHK();

SAVE();
SAVE2();

}
?>