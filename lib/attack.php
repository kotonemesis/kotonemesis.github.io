<?php
#□■□■□■□■□■□■□■□■□■□■□■□
#■ 	-       BR ATTACK PROGRAM      - 	 ■
#□ 									 	 □
#■ 			써브루틴 일람		 	 ■
#□ 									 	 □
#■ WEPTREAT	-	무기 종별 처리		 	 ■
#□ DEATH		-	자신 사망 처리		 	 □
#■ DEATH2		-	적사망 처리			 	 ■
#□ RUNAWAY		-	도망 처리			 	 □
#■ DEFTREAT	-	방어구 종별 처리		 	 ■
#□ LVUPCHK		-	레벨업 처리	 	 □
#■ lvuprand	-	레벨업 랜덤 처리 ■
#□ EN_KAIFUKU	-	적회복 처리			 	 □
#■ BLOG_CK		-	적전투 로그 자동 삭제 처리	 ■
#□ RUN_AWAY	-	자동 이동				 □
#■□■□■□■□■□■□■□■□■□■□■□■
#=================#
# ■ 무기 종별 처리 #
#=================#
#					무기 무기잔수공격자명 방어자명 공격 종별(공격/반격) 공격자(PC/NPC)
function WEPTREAT(	$wname,	$wkind,	$wwtai,	$pn,		$nn,		$ind,				$attman){
global $pref;
global $log,$wk;

if($attman == 'PC'){$nn = '상대';}
elseif($attman == 'NPC'){$pn = '상대';}

$dice3 = rand(0,100);	#상처 1
$dice4 = rand(0,4);	#상처 2
$dice5 = rand(0,100);	#파괴?

$kega = $hakai = 0;
$kegainf = $k_work = '';

if(((preg_match('/B/',$wkind))||((preg_match('/G|A/',$wkind))&&($wwtai == 0)))&&($wname != '맨손')){#곤봉, 총알 없음총, 화살 없음활
	$log .= $pn.'의 '.$ind.'!<BR>　'.$wname.'로 '.$nn.'를 때렸다!<BR>';
	if($attman == 'PC'){
		global $wp;
		$wp++;$wk=$wp;
	}else{
		global $w_wp;
		$w_wp++;$wk=$w_wp;
	}
	$kega = 15;$kegainf = "마리팔";		#상처율, 상처 개소
	$hakai = 2;	#파괴율
}elseif(preg_match("/C/",$wkind)){		#투계
	$log .= $pn.'의 '.$ind.'!<BR>　'.$wname.'를 '.$nn.'에 내던졌다!<BR>';
	if($attman == 'PC'){
		global $wc;
		$wc++;$wk=$wc;
	}else{
		global $w_wc;
		$w_wc++;$wk=$w_wc;
	}
	$kega = 15;$kegainf = "마리팔";		#상처율, 상처 개소
	$hakai = 0;	#파괴율
}elseif(preg_match("/D/",$wkind)){		#폭계
	$log .= $pn.'의 '.$ind.'!<BR>　'.$wname.'를 '.$nn.'에 내던졌다!<BR>';
	if($attman == 'PC'){
		global $wd;
		$wd++;$wk=$wd;
	}else{
		global $w_wd;
		$w_wd++;$wk=$w_wd;
	}
	$kega = 15;$kegainf = "마리완완족";	#상처율, 상처 개소
	$hakai = 0;	#파괴율
}elseif(preg_match("/G/",$wkind)){		#총계
	$log .= $pn.'의 '.$ind.'!<BR>　'.$wname.'를 '.$nn.'목표로 해 발포했다!<BR>';
	if($attman == 'PC'){
		global $wg,$pls;
		$wg++;$wk=$wg;$ps=$pls;
	}else{
		global $w_wg,$w_pls;
		$w_wg++;$wk=$w_wg;$ps=$w_pls;
	}
	$kega = 25;$kegainf = "마리완복족";	#상처율, 상처 개소
	$hakai = 1;	#파괴율
	if(!preg_match("/S/",$wkind)){#발포음 기입
		global $id,$w_id;

		$gunlog = @file($pref['gun_log_file']) or ERROR('unable to open gun_log_file','','ATTACK',__FUNCTION__,__LINE__);
		$gunlog[0] = $pref['now'].','.$pref['place'][$ps].','.$id.','.$w_id.",\n";

		$handle = @fopen($pref['gun_log_file'],'w') or ERROR('unable to open gun_log_file','','ATTACK',__FUNCTION__,__LINE__);
		if(!@fwrite($handle,implode('',$gunlog))){ERROR('unable to write gun_log_file','','ATTACK',__FUNCTION__,__LINE__);}
		fclose($handle);
	}
}elseif(preg_match('/K/',$wkind)){		#참계
	$log .= $pn.'의 '.$ind.'!<BR>　'.$wname.'로 '.$nn.'를 베었다!<BR>';
	if($attman == 'PC'){
		global $wn;
		$wn++;$wk=$wn;
	}else{
		global $w_wn;
		$w_wn++;$wk=$w_wn;
	}
	$kega = 25;$kegainf = "마리완복족";	#상처율, 상처 개소
	$hakai = 1;	#파괴율
}elseif(preg_match("/P/",$wkind)){		#구계
	$log .= $pn.'의 '.$ind.'!<BR>　'.$wname.'로 '.$nn.'를 때렸다!<BR>';
	if($attman == 'PC'){
		global $wp;
		$wp++;$wk=$wp;
	}else{
		global $w_wp;
		$w_wp++;$wk=$w_wp;
	}
	$kega = 0;$kegainf = '';			#상처율, 상처 개소
	$hakai = 0;	#파괴율
}else{						#그 외
	$log .= $pn.'의 '.$ind.'!<BR>　'.$wname.'로 '.$nn.'를 때렸다!<BR>';
	if($attman == 'PC'){
		global $wp;
		$wp++;$wk=$wp;
	}else{
		global $w_wp;
		$w_wp++;$wk=$w_wp;
	}
	$kega = 0;$kegainf = '';			#상처율, 상처 개소
	$hakai = 0;	#파괴율
}

$wk = (int)($wk/$pref['BASE']) ;$wk = ($wk * 0.02) ;$wk = (0.89 + $wk);#숙련도에 의한 공격의 변화율
#상대?자신?
if($attman == 'PC'){
	global $wep,$watt,$wtai,$w_inf,$wep_2,$watt_2,$wtai_2,$w_inf_2;
	$wep_2 = $wep;$watt_2 = $watt;$wtai_2 = $wtai;$w_inf_2 = $w_inf;
}else{
	global $w_wep,$w_watt,$w_wtai,$inf,$w_wep_2,$w_watt_2,$w_wtai_2,$inf_2;
	$w_wep_2 = $w_wep;$w_watt_2 = $w_watt;$w_wtai_2 = $w_wtai;$inf_2 = $inf;
}

# 무기 파괴
global $hakaiinf2,$hakaiinf3;
if($dice5 < $hakai){#파괴?
	if($attman == 'PC'){
		$wep_2 = '맨손<>WP';$watt_2 = 0;$wtai_2 = '∞';$hakaiinf3 = '무기 손상!';#PC
	}else{
		$w_wep_2 = '맨손<>WP';$w_watt_2 = 0;$w_wtai_2 = '∞';$hakaiinf2 = '무기 손상!';
	}
}else{$hakaiinf2 = $hakaiinf3 = '';}

# 상처 처리
if($dice3 < $kega){
	if	  (($dice4 == 0)&&(preg_match('/머리/',$kegainf))){$k_work = '카시라';}#카시라
	elseif(($dice4 == 1)&&(preg_match('/팔/',$kegainf))){$k_work = '팔';}#팔
	elseif(($dice4 == 2)&&(preg_match('/배/',$kegainf))){$k_work = '배';}#배
	elseif(($dice4 == 3)&&(preg_match('/다리/',$kegainf))){$k_work = '다리';}#다리
	else{return;}

	if($attman == 'PC'){#PC
		global $w_item,$w_eff,$w_itai,$w_bou,$w_bou_h,$w_bou_f,$w_bou_a,$kega3,$w_btai,$w_btai_h,$w_btai_f,$w_btai_a,$w_bdef,$w_bdef_h,$w_bdef_f,$w_bdef_a,$w_inf_2;
		if(((preg_match('/AD/',$w_item[5]))||(preg_match('/<>DB/',$w_bou)))&&($k_work == '배')){	#배?
			if(preg_match('/AD/',$w_item[5])){$w_itai[5] --;if($w_itai[5] <= 0){$w_item[5]='없음';$w_eff[5]=$w_itai[5]=0;}}
			else{$w_btai --;if($w_btai <= 0){$w_bou = '속옷<>DN';$w_bdef=0;$w_btai='∞';}}
			return;
		}
		elseif((preg_match('/<>DH/',$w_bou_h))&&($k_work == '머리')){$w_btai_h --;if($w_btai_h <= 0){$w_bou_h='없음';$w_bdef_h=$w_btai_h=0;}return;}#두?
		elseif((preg_match('/<>DF/',$w_bou_f))&&($k_work == '다리')){$w_btai_f --;if($w_btai_f <= 0){$w_bou_f='없음';$w_bdef_f=$w_btai_f=0;}return;}#다리?
		elseif((preg_match('/<>DA/',$w_bou_a))&&($k_work == '팔')){$w_btai_a --;if($w_btai_a <= 0){$w_bou_a='없음';$w_bdef_a=$w_btai_a=0;}return;}#팔?
		else{$w_inf_2 = preg_replace("/$k_work/",'',$w_inf_2) ;$w_inf_2 = ($w_inf_2 . $k_work) ;$kega3 = ($k_work . "부 부상");}
	}else{
		global $item,$eff,$bou,$itai,$bou_h,$bou_f,$bou_a,$kega2,$btai,$btai_h,$btai_f,$btai_a,$bdef,$bdef_h,$bdef_f,$bdef_a,$inf_2;
		if(((preg_match('/AD/',$item[5]))||(preg_match('/<>DB/',$bou)))&&($k_work == '배')){	#배?
			if(preg_match('/AD/',$item[5])){$itai[5] --;if($itai[5] <= 0){$item[5]='없음';$eff[5]=$itai[5]=0;}}
			else{$btai --;if($btai <= 0){$bou = '속옷<>DN';$bdef=0;$btai='∞';}}
			return;
		}
		elseif((preg_match('/<>DH/',$bou_h))&&($k_work == '머리')){$btai_h --;if($btai_h <= 0){$bou_h='없음';$bdef_h=$btai_h=0;}return;}#두?
		elseif((preg_match('/<>DF/',$bou_f))&&($k_work == '다리')){$btai_f --;if($btai_f <= 0){$bou_f='없음';$bdef_f=$btai_f=0;}return;}#다리?
		elseif((preg_match('/<>DA/',$bou_a))&&($k_work == '팔')){$btai_a --;if($btai_a <= 0){$bou_a='없음';$bdef_a=$btai_a=0;}return;}#팔?
		else{$inf_2 = preg_replace("/$k_work/",'',$inf_2) ;$inf_2 = ($inf_2 . $k_work) ;$kega2 = $k_work.'부 부상';}
	}
}
}
#=================#
# ■ 자신 사망 처리 #
#=================#
function DEATH(){
global $pref;
global $hit,$w_kill,$mem,$log,$f_name,$l_name,$cl,$sex,$no,$w_log,$w_f_name,$w_l_name,$w_msg,$hour,$min,$sec,$b_limit,$ar,$w_inf,$gunlog,$pls,$id,$w_id;

$hit = 0;$w_kill++;
$mem--;

$com = rand(0,6);

$log .= '<font color="red"><b>'.$f_name.' '.$l_name.'('.$cl.' '.$sex.$no.'차례)는 사망했다.</b></font><br>';
if($w_msg != ''){$log .= '<font color="lime"><b>'.$w_f_name.' '.$w_l_name.' 「'.$w_msg.'」</b></font><br>';}
$w_log .= '<font color="yellow"><b>'.$hour.':'.$min.':'.$sec.' '.$f_name.' '.$l_name.'('.$cl.' '.$sex.$no.'차례)와 전투를 실시해 살해했다.<BR>　【나머지'.$mem.'사람】</b></font><br>';

$b_limit = ($pref['battle_limit'] * 3) + 1;

if(($mem == 1)&&($w_sts != 'NPC')&&($ar > $b_limit)){$w_inf .= '승';}

$gunlog = @file($pref['gun_log_file']) or ERROR('unable to open gun_log_file','','ATTACK',__FUNCTION__,__LINE__);
$gunlog[1] = $pref['now'].','.$pref['place'][$pls].','.$id.','.$w_id.",\n";
$handle = @fopen($pref['gun_log_file'],'w') or ERROR('unable to open gun_log_file','','ATTACK',__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$gunlog))){ERROR('unable to open gun_log_file','','ATTACK',__FUNCTION__,__LINE__);}
fclose($handle);

#사망 로그
LOGSAVE('DEATH2');
$death = $deth;
}
#===============#
# ■ 적사망 처리 #
#===============#
function DEATH2(){
global $in,$pref;

global $w_hit,$kill,$w_id,$bb,$w_cl,$mem,$w_com,$log,$w_f_name,$w_l_name,$w_cl,$w_sex,$w_no,$w_dmes,$msg,$w_death;
global $f_name,$l_name,$msg,$pls,$id,$w_id,$deth;

$w_hit = 0;$kill++;
$bb = $w_id;#브라우저 백 대처
if(($w_cl != $pref['BOSS'])||($w_cl != $pref['KANN'])||($w_cl != $pref['ZAKO'])){$mem--;}

$w_com = rand(0,6);
$log .= '<font color="red"><b>'.$w_f_name.' '.$w_l_name.'('.$w_cl.' '.$w_sex.$w_no.'차례)를 살해했다.<BR>　【나머지'.$mem.'사람】</b></font><br>';

if(strlen($w_dmes) > 1){$log .= '<font color="yellow"><b>'.$w_f_name.' '.$w_l_name.' 「'.$w_dmes.'」</b></font><br>';}
if(strlen($msg) > 1){$log .= '<font color="lime"><b>'.$f_name.' '.$l_name.' 「'.$msg.'」</b></font><br>';}

$b_limit = ($pref['battle_limit'] * 3) + 1;
if(($mem == 1)&&($ar > $b_limit)){$inf .= '승';}

$gunlog = @file($pref['gun_log_file']) or ERROR('unable to open gun_log_file','','ATTACK',__FUNCTION__,__LINE__);
$gunlog[1] = $pref['now'].','.$pref['place'][$pls].','.$id.','.$w_id.",\n";
$handle = @fopen($pref['gun_log_file'],'w') or ERROR('unable to open gun_log_file','','ATTACK',__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$gunlog))){ERROR('unable to open gun_log_file','','ATTACK',__FUNCTION__,__LINE__);}
fclose($handle);

#사망 로그
LOGSAVE('DEATH3');

$in['Command'] = 'BATTLE2';
$w_death = $deth;
#$w_bid = '';

}
#=============#
# ■ 도망 처리 #
#=============#
function RUNAWAY(){
global $in;

global $log,$l_name;
$log .= $l_name.'는 전속력으로 도망갔다….<BR>';
$in['Command'] = 'MAIN';
}
#=================#
# ■ 방어구 종별 처리 #
#=================#
#					무기 종별 방어측(PC/NPC)
function DEFTREAT(	$wkind,		$defman){
global $pnt;

$p_up = 1.1;
$p_down = 0.9;

if($defman == 'PC'){#PC?
	global $bou,$bou_h,$bou_f,$bou_a,$item;
	@list($b_name,$b_kind)     = explode('<>',$bou);
	@list($b_name_h,$b_kind_h) = explode('<>',$bou_h);
	@list($b_name_f,$b_kind_f) = explode('<>',$bou_f);
	@list($b_name_a,$b_kind_a) = explode('<>',$bou_a);
	@list($b_name_i,$b_kind_i) = explode('<>',$item[5]);
}else{
	global $w_bou,$w_bou_h,$w_bou_f,$w_bou_a,$w_item;
	@list($b_name,$b_kind)     = explode('<>',$w_bou);
	@list($b_name_h,$b_kind_h) = explode('<>',$w_bou_h);
	@list($b_name_f,$b_kind_f) = explode('<>',$w_bou_f);
	@list($b_name_a,$b_kind_a) = explode('<>',$w_bou_a);
	@list($b_name_i,$b_kind_i) = explode('<>',$w_item[5]);
}

if	 (($wkind == 'WG')&&($b_kind_i == 'ADB'))	{$pnt = $p_down;}	#총→방탄
elseif(($wkind == 'WG')&&($b_kind_h == 'DH'))	{$pnt = $p_up;}		#총→두
elseif(($wkind == 'WK')&&($b_kind == 'DBK'))	{$pnt = $p_down;}	#참→쇄
elseif(($wkind == 'WN')&&($b_kind_i == 'ADB'))	{$pnt = $p_up;}		#참→방탄
elseif((($wkind == 'WB')||($wkind == 'WGB')||($wkind == 'WAB'))&&($b_kind_h == 'DH')){$pnt = $p_down;}#구→두
elseif((($wkind == 'WB')||($wkind == 'WGB')||($wkind == 'WAB'))&&(preg_match('/DBA/',$b_kind))){$pnt = $p_up;}	 #구→요로이
else{$pnt = 1.0;}
}
#=====================#
# ■ 레벨업 처리 #
#=====================#
function LVUPCHK(){
global $pref;
global $exp,$level,$hit,$w_exp,$w_level,$w_hit;
if(($exp >= (int)($level*$pref['baseexp']+(($level-1) *$pref['baseexp'])))&&($hit > 0)){#레벨업
	global $log,$mhit,$att,$def,$level,$sta;
	list($lvuphit,$lvupatt,$lvupdef) = lvuprand();
	$log .= '레벨이 올랐다.<font color="#00FFFF">【몸】+'.$lvuphit.' 【공】+'.$lvupatt.' 【방】+'.$lvupdef.'</font><br>';
	$hit += $lvuphit;$mhit += $lvuphit;$att += $lvupatt;$def += $lvupdef;$level++;$sta += 50;if($pref['maxsta'] < $sta){$sta = $pref['maxsta'];};
}
if(($w_exp >= (int)($w_level*$pref['baseexp']+(($w_level-1) *$pref['baseexp'])))&&($w_hit > 0)){#레벨업
	global $w_log,$w_mhit,$w_att,$w_def,$w_level,$w_sta;
	list($lvuphit,$lvupatt,$lvupdef) = lvuprand();
	$w_log .= '레벨이 올랐다.<font color="#00FFFF">【몸】+'.$lvuphit.' 【공】+'.$lvupdef.' 【방】+'.$lvupatt.'</font><br>';
	$w_hit += $lvuphit;$w_mhit += $lvuphit;$w_att += $lvupdef;$w_def += $lvupatt;$w_level++;$w_sta += 50;if($pref['maxsta'] < $w_sta){$w_sta = $pref['maxsta'];};
}
}
#=============================#
# ■ 레벨업 랜덤 처리 #
#=============================#
function lvuprand(){$lvuphit = rand(4,6) ;$lvupatt = rand(2,4) ;$lvupdef = rand(2,3) ;return array($lvuphit,$lvupatt,$lvupdef);}
#===============#
# ■ 적회복 처리 #
#===============#
function EN_KAIFUKU(){#적회복 처리
global $pref;

global $w_endtime,$w_inf,$w_ousen,$w_sts,$w_sta,$w_mhit,$w_hit;
$up = (int)(($pref['now'] - $w_endtime) / (1 * $pref['kaifuku_time']));
$w_endtime = $pref['now'];
if((preg_match('/배/',$w_inf))&&($w_ousen != '치료 전념')){$up = (int)($up / 2);}
if((!preg_match('/배/',$w_inf))&&($w_ousen == '치료 전념')){$up = (int)($up * 2);}
if($w_sts == '수면'){
	$w_sta += $up;
	if($w_sta > $pref['maxsta']){$w_sta = $pref['maxsta'];}
}elseif($w_sts == '치료'){
	if($pref['kaifuku_rate'] == 0){$pref['kaifuku_rate'] = 1;}
	$up = (int)($up / $pref['kaifuku_rate']);
	$w_hit += $up;
	if($w_hit > $w_mhit){$w_hit = $w_mhit;}
}elseif($w_sts == '정양'){
	$w_sta += $up;
	if($w_sta > $pref['maxsta']){$w_sta = $pref['maxsta'];}
	if($pref['kaifuku_rate'] == 0){$pref['kaifuku_rate'] = 1;}
	$up = (int)($up / $pref['kaifuku_rate']);
	$w_hit += $up;
	if($w_hit > $w_mhit){$w_hit = $w_mhit;}
}
}
#===========================#
# ■ 적전투 로그 자동 삭제 처리 #
#===========================#
function BLOG_CK(){
global $w_log,$w_sts,$hour,$min,$sec;
$log_len = strlen($w_log);
if(($w_sts == 'NPC')&&($log_len > 100)){$w_log = '<font color="yellow"><b>자동 삭제</b></font><br>';}
elseif($log_len > 1000){$w_log = '<font color="yellow"><b>'.$hour.':'.$min.':'.$sec.'전투 로그는 자동 삭제되었습니다.</b></font><br>';}
}
#=============#
# ■ 자동 이동 #
#=============#
function RUN_AWAY($pls,$i=1){
global $pref;
global $ar;
list($ara[0],$ara[1],$ara[2],$ara[3],$ara[4],$ara[5],$ara[6],$ara[7],$ara[8],$ara[9],$ara[10],$ara[11],$ara[12],$ara[13],$ara[14],$ara[15],$ara[16],$ara[17],$ara[18],$ara[19],$ara[20],$ara[21]) = explode(',',$pref['arealist'][4]);

$return = $ar + rand(0,(count($ara) - $ar - 1));

if(isset($ara[$return])){return $ara[$return];}//이동
elseif(($i)&&($ara[$return] == $pls)){RUN_AWAY($pls,0);}//다시 한번 검색
else{return $pls;}//현상 유지

}
?>