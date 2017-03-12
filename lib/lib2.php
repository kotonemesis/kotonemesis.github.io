<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR LIBRARY PROGRAM    - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ MOVE			-		이동		 ■
#□ SEARCH			-		탐색 처리	 □
#■ SEARCH2			-		탐색 처리 2	 ■
#□ TACTGET			-		전략 계산	 □
#■ TACTGET2		-		전략 계산	 ■
#□■□■□■□■□■□■□■□■□■□■□
#=========#
# ■ 이동 #
#=========#
function MOVE(){
global $in,$pref;

global $pls,$log,$inf,$sta,$hackflg,$sts;
$mv = $in['Command2'];
$mv = str_replace('MV','',$mv);

#이동 사전 처리
$in['Command'] = 'MAIN';
$in['Command2'] = '';
if($mv == $pls){$log .= 'Cannot move to same place…';return;}
$ok = 1;
if((preg_match('/다리/',$inf))&&($sta > 18)){
	$ok = 0;
}elseif((preg_match('/크로스 카운트 리부|축구부/',$pref['clb'][$in['club']]))&&($sta > 11)){
	$ok = 0;
}elseif($sta > 13){
	$ok = 0;
}
if($ok){$log .= '스태미너가 부족하기 때문에 이동할 수 없다…';return;}

if(preg_match('/다리/',$inf)){$sta -= rand(13,18);}
elseif(preg_match('/크로스 카운트 리부|축구부/',$pref['clb'][$in['club']])){$sta -= rand(6,11);}
else{$sta -= rand(8,13);}

list($ar[0],$ar[1],$ar[2],$ar[3],$ar[4],$ar[5],$ar[6],$ar[7],$ar[8],$ar[9],$ar[10],$ar[11],$ar[12],$ar[13],$ar[14],$ar[15],$ar[16],$ar[17],$ar[18],$ar[19],$ar[20],$ar[21]) = explode(",",$pref['arealist'][2]);
list($war,$a) = explode(',',$pref['arealist'][1]);
if($ar[$war] == $pref['place'][$mv]){
	$log .= $pref['place'][$mv].'로 이동했다.<br>다음, 여기는 금지 에리어가 되어 버리는군.<br>'.$pref['arinfo'][$mv].'<br>';
}elseif(($ar[$war+1] == $pref['place'][$mv])||($ar[$war+2] == $pref['place'][$mv])){
	$log .= $pref['place'][$mv].'로 이동했다.<br>가까운 시일내에 여기는 금지 에리어가 되어 버리는군.<br>'.$pref['arinfo'][$mv].'<br>';
}else{
	for($i=0; $i<$war; $i++){
		if(($ar[$i] == $pref['place'][$mv])&&($hackflg == 0)&&(!preg_match('/NPC/',$sts))){#금지 에리어?
			$log .= $pref['place'][$mv].'는 금지 에리어다.이동하는 것은 할 수 없는데….<BR>';
			return;
		}
	}
	$log .= $pref['place'][$mv].'로 이동했다.<BR>'.$pref['arinfo'][$mv].'<br>';
}

$pls = $mv;#이동

if(preg_match("/독/",$inf)){
	global $hit;
	$minus = rand(0,8);
	$hit -= $minus;
	$log .= '독에 의해서 체력을<b><font color="red">'.$minus.'</font></b>깎아졌다.<BR>';
	require $pref['LIB_DIR'].'/lib3.php';
	POISONDEAD();
}

SEARCH2();

SAVE();

}
#=============#
# ■ 탐색 처리 #
#=============#
function SEARCH(){
global $in,$pref;

global $inf,$sta,$log,$hit,$l_name,$chksts;

$ok = 1;
if((preg_match('/다리/',$inf))&&($sta > 25)){
	$ok = 0;
}elseif((preg_match('/크로스 카운트 리부|축구부/',$pref['clb'][$in['club']]))&&($sta > 15)){
	$ok = 0;
}elseif($sta > 20){
	$ok = 0;
}
if($ok){$log .= '스태미너가 부족하기 때문에 탐색할 수 없다…';return;}

$log .= $l_name.'는, 근처를 탐색했다….<br>';

if(preg_match('/다리/',$inf)){$sta -= rand(20,25);}
elseif(preg_match('/크로스 카운트 리부|축구부/',$pref['clb'][$in['club']])){$sta -= rand(10,15);}
else{$sta -= rand(15,20);}

if(preg_match('/독/',$inf)){
	$minus = rand(0,8);
	$hit -= $minus;
	$log .= '독에 의해서 체력을<b><font color="red">'.$minus.'</font></b>깎아졌다.<BR>';
	require $pref['LIB_DIR'].'/lib3.php';
	POISONDEAD();
}

SEARCH2();

if($chksts != 'OK'){$log .= '그러나, 아무것도 발견되지 않았다.<BR>';$in['Command'] = 'MAIN';}

SAVE();
}
#==============#
# ■ 탐색 처리 2 #
#==============#
function SEARCH2(){
global $pref;

global $chkpnt2,$kiri,$chkpnt,$tactics,$pls,$id,$chksts,$chksts2,$teamID,$teamPass;
$i = 0;

$dice1 = rand(0,10);	#적, 아이템 어느 쪽을 발견

TACTGET();

$userlist = @file($pref['user_file']) or ERROR('unable to open file user_file user_file','','LIB2',__FUNCTION__,__LINE__);

$chksts='NG';$chksts2='NG';

$plist = array();

if($dice1 <= 5){	#적발견?
	for ($i=0; $i<count($userlist); $i++){
		list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP) = explode(",",$userlist[$i]);
		if(($w_pls == $pls)&&($w_id != $id)){#같은 장소&타인
			$b_bid = $w_bid;
			if($tactics == '련투행동'){
				$w_bid = '';
				$randam_set = 50;#련투율
				if($w_tactics != '련투행동'){$randam_set = 75;}#련투율
				if(rand(0,100) >= $randam_set){$w_bid = $b_bid;}
			}
			if(preg_match("/\&/",$w_bid)){#분할
				list($w_bid1,$w_bid2) = explode('&',$w_bid);
			}else{
				$w_bid1 = $w_bid;
				$w_bid2 = '&';
			}
			if(($w_bid1 != $id)&&($w_bid2 != $teamID)){
				array_push($plist,$i);
			}
		}
	}

	$plist2 = array();
	if(isset($plist[0])){
		for($i=0;$i<count($plist);$i++){
			$r = rand(0,$i+1);
			$plist2[$r] = $plist[$i];
			array_push($plist2,$plist2[$r]);
		}
	}

	//적GLOBAL
	global $w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item,$w_eff,$w_itai,$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP;
	foreach($plist2 as $i){
		$dice2 = rand(0,10);	#적, 아이템 발견
		$dice3 = rand(0,10);	#선제 공격
		$dice6 = rand(0,100);	#시야
		list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP) = explode(",",$userlist[$i]);

		if(($w_pls == $pls)&&($w_id != $id)){	#장소 일치외 플레이어?
			$b_bid = $w_bid;
			if($tactics == '련투행동'){
				$w_bid = '';
			}
			if(preg_match("/\&/",$w_bid)){#분할
				list($w_bid1,$w_bid2) = explode('&',$w_bid);
			}else{
				$w_bid1 = $w_bid;
				$w_bid2 = '&';
				if($teamID == ''){#team 고장 수정
					$teamID = $teamPass = '없음';
				}
			}
			if(($w_bid1 != $id)&&($w_bid2 != $teamID)){
				list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP) = explode(",",$userlist[$i]);

				global $sen,$w_pls,$w_club;
				TACTGET2() ;$chk = (int)($dice2 * $sen);

				if($chk < $chkpnt){#상대 발견
					global $bb;
					if($w_hit > 0){#생존?
						$kiri = 0;#안개 Script
						#list($weth) = $pref['arealist'][5];
						#if(!preg_match("/0|1|2|7/",$weth)){#맑은 하늘·개여·흐림을 제외하다
						#	$kiri = $weth * 3;#최대3*9=27(27%)
						#	if($dice6 < $kiri){$kiri = 1;}else{$kiri = 0;}
						#}
						$bb = $w_id;	#브라우저 백 대처용	↓팀
						if((!$kiri)&&($teamID != '없음')&&($teamID != '')&&($teamID == $w_teamID)&&($teamPass == $w_teamPass)){#양도
							require $pref['LIB_DIR'].'/att_etc.php';
							ATTJYO() ;$chksts='OK';$chksts2='NG';break;
						}elseif($dice3 <= $chkpnt2 || $w_ousen=='치료 전념' || $w_ousen=='도망 몸의 자세'){//상대가 치료 전념/도망 몸의 자세때는 상대는 기습을 할 수 없기 때문에
							require $pref['LIB_DIR'].'/att_etc.php';
							ATTACK() ;$chksts='OK';$chksts2='NG';break;	#선제 공격
						}else{
							$w_bid = $id;
							if(($teamID != '없음')&&($teamID != '')){$w_bid .= '&'.$teamID;}
							$bid = $w_id;
							if(($w_teamID != '없음')&&($w_teamID != "")){$bid .= '&'.$w_teamID;}
							require $pref['LIB_DIR']."/attack.php";
							require $pref['LIB_DIR']."/att_kou.php";
							ATTACK2() ;$chksts='OK';$chksts2="NG";break;	#후공 공격(기습)
						}
					}else{#시체 발견
						$chkflg = 0;
						$dice4 = rand(0,10);
						if($dice4 > 6){
							for($j=0;$j<6;$j++){
								if($w_item[$j] != '없음' && $w_item[$j] != ""){
									$chkflg=1;break;
								}
							}
							if($chkflg){
								if((!preg_match('/맨손/',$w_wep))||(!preg_match('/속옷/',$w_bou))||($w_bou_h != '없음')||($w_bou_f != '없음')||($w_bou_a != '없음')||($w_money > 0)){
									$w_sta = -1;
									$w_bid = $id;
									SAVE2();
									$bb = $w_id;#브라우저 백 대처용
									require $pref['LIB_DIR'].'/att_etc.php';DEATHGET() ;break;
								}
							}
						}
					}
				}
			}else{
				$chksts2='OK';
			}
		}
	}

	if($chksts2 == 'OK'){#아이템 발견·하늘
		global $in,$log;
		$dice5 = rand(0,10);#아이템 발견
		if(($dice5 <= 5)&&($in['Command'] == 'SEARCH')){
			require $pref['LIB_DIR'].'/item1.php';ITEMGET();
		}else{
			$log .= '누군가가 잠복하고 있는 기색이 한다….병사인가?<BR>';
		}
	}
}else{	#이벤트·아이템 발견
	$dice2 = rand(0,10);
	if($dice2 <= $chkpnt){require $pref['LIB_DIR'].'/item1.php';ITEMGET();}#아이템 발견
	else{require $pref['LIB_DIR'].'/event.php';EVENT();}
}

}
#=============#
# ■ 전략 계산 #
#=============#
function TACTGET(){
global $in,$pref;

global $tactics,$jyuku1,$pls,$pls,$inf,$w_kind,$wp,$wg,$wn,$wc,$wd,$chkpnt,$chkpnt2,$weps,$mei;
global $atp,$dfp,$w_wtai;
$chkpnt = 5;	#적, 아이템 발견율
$chkpnt2 = 5;	#선제 공격율
$atp = 1.00;
$dfp = 1.00;#					공격 방어 발견 솔선제 공격율
#기본방침
if	  ($tactics == '공격 중시')	{$atp+=0.2;	$dfp-=0.2;}
elseif($tactics == '방어 중시')	{$atp-=0.2;	$dfp+=0.2;					$chkpnt2-=1;}
elseif($tactics == '은밀 행동')	{$atp-=0.2;	$dfp-=0.1;	$chkpnt-=1;		$chkpnt2+=2;}
elseif($tactics == '탐색 행동')	{$atp-=0.05;$dfp-=0.05;	$chkpnt+=2;		$chkpnt2+=1;}
elseif($tactics == '련투행동')	{$dfp-=0.1;	$dfp-=0.1;	$chkpnt-=0.5;	$chkpnt2-=0.05;}
#날씨
if	  ($pref['arealist'][5] == '0')	{$atp+=0.2;	$dfp+=0.3;	$chkpnt+=2;		$chkpnt2+=2;}	#쾌청
elseif($pref['arealist'][5] == '1')	{$atp+=0.2;	$dfp+=0.1;	$chkpnt+=1;		$chkpnt2+=1;}	#맑음
elseif($pref['arealist'][5] == '2')	{;}														#흐림
elseif($pref['arealist'][5] == '3')	{$atp-=0.02;$dfp-=0.03;	$chkpnt-=0.2;	$chkpnt2-=0.3;}	#우
elseif($pref['arealist'][5] == '4')	{$atp-=0.05;$dfp-=0.03;	$chkpnt-=0.3;	$chkpnt2-=0.5;}	#호우
elseif($pref['arealist'][5] == '5')	{$atp-=0.07;$dfp-=0.05;	$chkpnt-=0.7;	$chkpnt2-=0.5;}	#태풍
elseif($pref['arealist'][5] == '6')	{$atp-=0.07;$dfp-=0.1;	$chkpnt-=1;		$chkpnt2-=0.7;}	#뇌우
elseif($pref['arealist'][5] == '7')	{$atp-=0.1;	$dfp-=0.15;	$chkpnt-=0.5;	$chkpnt2+=1;}	#눈
elseif($pref['arealist'][5] == '8')	{			$dfp-=0.2;	$chkpnt+=1;		$chkpnt2-=1;}	#안개
elseif($pref['arealist'][5] == '9')	{$atp+=0.5;	$dfp-=0.3;					$chkpnt2-=1;}	#농무
#에리어
if	  ($pref['arsts'][$pls] == 'AU')	{$atp+=0.1;}	#공격증
elseif($pref['arsts'][$pls] == 'AD')	{$atp-=0.1;}	#공격감
elseif($pref['arsts'][$pls] == 'DU')	{$dfp+=0.1;}	#방어증
elseif($pref['arsts'][$pls] == 'DD')	{$dfp-=0.1;}	#방어감
elseif($pref['arsts'][$pls] == 'SU')	{$chkpnt+=1;}	#발견증
elseif($pref['arsts'][$pls] == 'SD')	{$chkpnt-=1;}	#발견감
#동아리
if	  ($pref['clb'][$in['club']] == '아트부'){
						$chkpnt+=0.1;		$chkpnt2+=1;
}elseif($pref['clb'][$in['club']] == '오케스트라부'){
				$dfp+=0.1;	$chkpnt+=0.1;
}elseif($pref['clb'][$in['club']] == '브라스 밴드부'){
						$chkpnt+=0.1;
}elseif($pref['clb'][$in['club']] == '후쿠자와유키치 연구회' && preg_match('/분교|폐교/',$pref['place'][$pls])){
	$atp+=0.1;	$dfp+=0.1;
}elseif($pref['clb'][$in['club']] == '서도부'){
				$dfp+=0.1;
}elseif($pref['clb'][$in['club']] == '바둑부'){
				$dfp+=0.1;
}elseif($pref['clb'][$in['club']] == '서양 보드부'){
						$chkpnt+=0.1;
}elseif($pref['clb'][$in['club']] == '농구부' && $teamID != '없음'){
	$atp+=0.1;
}elseif($pref['clb'][$in['club']] == '수영부' && preg_match('/분교|폐교/',$pref['place'][$pls])){
				$dfp-=0.1;
}elseif($pref['clb'][$in['club']] == '럭비부'){
	$atp+=0.1;
}elseif($pref['clb'][$in['club']] == '크로스 카운트 리부'){
				$dfp-=0.1;
}
#부상
if(preg_match('/팔/',$inf)){$atp -= 0.2;}

$kind = $w_kind;
$wmei = 0;
$wweps = '';
$jyuku1 = 0;#필살기술

if((preg_match('/G/',$kind))&&($w_wtai == 0)){$wweps = 'S';$wmei = 80;$wmei += round($wp/$pref['BASE']) ;$jyuku1 = $wp;}#곤봉/탄 없음총
elseif(preg_match('/C/',$kind))	{$wweps = 'M';$wmei = 70;$wmei += round($wc/$pref['BASE']) ;$jyuku1 = $wc;}#투
elseif(preg_match('/D/',$kind))	{$wweps = 'L';$wmei = 50;$wmei += round($wd/$pref['BASE']) ;$jyuku1 = $wd;}#폭
elseif(preg_match('/G/',$kind))	{$wweps = 'M';$wmei = 50;$wmei += round($wg/$pref['BASE']) ;$jyuku1 = $wg;}#총
elseif(preg_match('/K/',$kind))	{$wweps = 'S';$wmei = 80;$wmei += round($wn/$pref['BASE']) ;$jyuku1 = $wn;}#참
else 							{$wweps = 'S';$wmei = 70;$wmei += round($wp/$pref['BASE']) ;$jyuku1 = $wp;}#손

$weps = $wweps;
$mei = $wmei;

if(preg_match('/서도부|축구부/',$pref['clb'][$in['club']])){$mei += 10;}
if(preg_match('/머리/',$inf)){$mei -= 20;}
}
#=============#
# ■ 전략 계산 #
#=============#
function TACTGET2(){
global $pref;

global $atn,$dfn,$sen,$w_ousen,$w_pls,$w_club,$w_club,$w_inf,$w_kind2,$weps2,$mei2,$jyuku2,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd;
global $pls,$w_teamID,$teamID;
global $atn,$dfn,$sen,$w_wtai;

$atn = 1.00;
$dfn = 1.00;
$sen = 1.0;#						공격 방어 만남율 기습(상대의 선제 공격율)
if	  ($w_ousen == '공격 몸의 자세')	{$atn+=0.2;	$dfn-=0.2;	$sen+=0.05;	} 
elseif($w_ousen == '방어 몸의 자세')	{$atn-=0.2;	$dfn+=0.2;	$sen-=0.05;	}
elseif($w_ousen == '은밀 몸의 자세')	{$atn-=0.1;	$dfn-=0.2;	$sen+=0.1;	}
#elseif($w_ousen == '탐색 행동')	{$atn-=0.2;	$dfn-=0.2;	$sen-=0.4;	}
#elseif($w_ousen == '련투행동')	{			$dfn-=0.4;	$sen-=0.3;	}
elseif($w_ousen == '치료 전념')	{			$dfn-=0.4;}
elseif($w_ousen == '도망 몸의 자세')	{			$dfn-=0.2;}
#날씨
if	  ($pref['arealist'][5] == '0')	{$atn+=0.2;	$dfn+=0.3;}	#쾌청
elseif($pref['arealist'][5] == '1')	{$atn+=0.2;	$dfn+=0.1;}	#맑음
elseif($pref['arealist'][5] == '2')	{;}						#흐림
elseif($pref['arealist'][5] == '3')	{$atn-=0.02;$dfn-=0.03;}#우
elseif($pref['arealist'][5] == '4')	{$atn-=0.05;$dfn-=0.03;}#호우
elseif($pref['arealist'][5] == '5')	{$atn-=0.07;$dfn-=0.05;}#태풍
elseif($pref['arealist'][5] == '6')	{$atn-=0.07;$dfn-=0.1;}	#뇌우
elseif($pref['arealist'][5] == '7')	{$atn-=0.1;	$dfn-=0.15;}#설
elseif($pref['arealist'][5] == '8')	{			$dfn-=0.2;}	#무
elseif($pref['arealist'][5] == '9')	{$atn+=0.5;	$dfn-=0.3;}	#농무
#에리어
if	  ($pref['arsts'][$w_pls] == 'AU')	{$atn+=0.1;}#공격증
elseif($pref['arsts'][$w_pls] == 'AD')	{$atn-=0.1;}#공격감
elseif($pref['arsts'][$w_pls] == 'DU')	{$dfn+=0.1;}#방어증
elseif($pref['arsts'][$w_pls] == 'DD')	{$dfn-=0.1;}#방어감
#동아리
if	  ($pref['clb'][$w_club] == '브라스 밴드부'){
	$sen+=0.05;
}elseif(($pref['clb'][$w_club] == '코러스부')&&($w_teamID == $teamID)){
	$sen-=0.2;
}elseif(($pref['clb'][$w_club] == '발레부')&&($pref['place'][$pls] == '진료소')){
	$sen+=0.05;
}elseif($pref['clb'][$w_club] == '수영부' && preg_match('/분교|폐교/',$pref['place'][$pls])){
	$dfn-=0.1;
}elseif($pref['clb'][$w_club] == '크로스 카운트 리부'){
	$dfn-=0.1;
}
#부상
if(preg_match('/팔/',$w_inf)){$atn -= 0.1;}

$kind = $w_kind2;
$wmei = 0;
$wweps = '';
$jyuku2 = 0;#필살기술

if(preg_match('/G/',$kind) && $w_wtai == 0){$wweps = 'S';$wmei = 80;$wmei += round($w_wp/$pref['BASE']) ;$jyuku2 = $w_wp;}#곤봉/탄 없음총
elseif(preg_match('/C/',$kind))	{$wweps = 'M';$wmei = 70;$wmei += round($w_wc/$pref['BASE']) ;$jyuku2 = $w_wc;}#투
elseif(preg_match('/D/',$kind))	{$wweps = 'L';$wmei = 50;$wmei += round($w_wd/$pref['BASE']) ;$jyuku2 = $w_wd;}#폭
elseif(preg_match('/G/',$kind))	{$wweps = 'M';$wmei = 50;$wmei += round($w_wg/$pref['BASE']) ;$jyuku2 = $w_wg;}#총
elseif(preg_match('/K/',$kind))	{$wweps = 'S';$wmei = 80;$wmei += round($w_wn/$pref['BASE']) ;$jyuku2 = $w_wn;}#참
else 							{$wweps = 'S';$wmei = 70;$wmei += round($w_wp/$pref['BASE']) ;$jyuku2 = $w_wp;}#손

$weps2 = $wweps;
$mei2 = $wmei;

if(preg_match('/서도부|축구부/',$pref['clb'][$w_club])){$mei2 += 10;}
if(preg_match('/머리/',$w_inf)){$mei2 -= 20;}
}

?>