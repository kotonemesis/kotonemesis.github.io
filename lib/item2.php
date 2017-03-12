<?php
#=================#
# ■ 아이템 양도 #
#=================#
function ITEMJOUTO(){
global $in,$pref;

global $log,$bid,$id,$cl,$sex,$no,$f_name,$l_name,$hour,$min,$sec,$teamID;
$userlist = @file($pref['user_file']) or ERROR("unable to open user_file","","ITEM2",__FUNCTION__,__LINE__);
$sitei = $in['Command'];
$sitei = preg_replace("/SEITO_/","",$sitei);

$wk2 = $in['Command2'];
$wk2 = preg_replace("/JO_/","",$wk2);
$chk = "1";
//적GLOBAL
global $w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item,$w_eff,$w_itai,$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP;
for ($i=0;$i<count($userlist);$i++){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$i]);
	if($w_id == $sitei){$chk = "0";break;}
}
if($chk){ERROR("부정한 액세스입니다","No such item exist","ITEM2",__FUNCTION__,__LINE__);}
BB_CK();
if(preg_match("/MAIN/",$wk2)){#전언
	if(strlen($in['Dengon']) > 0){
		$log = ($log . "<font color=\"lime\"><b>{$f_name} {$l_name}({$cl} {$sex}{$no}차례) 「".$in['Dengon']."」</b></font><br>");
		$w_log = ($w_log . "<font color=\"lime\"><b>{$hour}:{$min}:{$sec} {$f_name} {$l_name}({$cl} {$sex}{$no}차례) 「".$in['Dengon']."」</b></font><br>");
	}
	$log = ($log . "{$w_cl} {$w_sex}{$w_no}차례 {$w_f_name} {$w_l_name}에의 양도를 단념했다.<br>");
}else{
	global $item,$eff,$itai;
	list($itn2,$ik2) = explode("<>",$item[$wk2]);
	if($item[$wk2] == "없음"){ERROR("부정한 액세스입니다","Item does not exist","ITEM2",__FUNCTION__,__LINE__);}
	for ($j=0;$j<5;$j++){if($w_item[$j] == "없음"){$chk = "OK";break;}}
	if($chk == "0"){$log = ($log . "상대의 데이팩이 가득합니다.<br>\n");}
	elseif($chk == "OK"){
		global $item_j;
		$item_j = $w_item[$j] = $item[$wk2];$w_eff[$j] = $eff[$wk2];$w_itai[$j] = $itai[$wk2];
		$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;
		$log = ($log . "{$w_cl} {$w_sex}{$w_no}차례 {$w_f_name} {$w_l_name}에{$itn2}를 양도했습니다.<br>\n");
		$w_log = ($w_log . "<font color=\"lime\"><b>{$cl} {$sex}{$no}차례 {$f_name} {$l_name}로부터{$itn2}를 받았습니다.</b></font><br>");
		if(strlen($in['Dengon']) > 0){
			$log = ($log . "<font color=\"lime\"><b>{$f_name} {$l_name}({$cl} {$sex}{$no}차례) 「".$in['Dengon']."」</b></font><br>");
			$w_log = ($w_log . "<font color=\"lime\"><b>{$hour}:{$min}:{$sec} {$f_name} {$l_name}({$cl} {$sex}{$no}차례) 「".$in['Dengon']."」</b></font><br>");
		}
		LOGSAVE("ITEM_J");
		if($pref['clb'][$in['club']] == "자원봉사부"){$sta += 10;$hit += 10;if($sta > $pref['maxsta']){$sta = $pref['maxsta'];}if($hit > $mhit){$hit = $mhit;}}
	}
	else{ERROR("내부 에러입니다.관리인에게 보고해 주세요.","Internal Server Error","ITEM2",__FUNCTION__,__LINE__);}
}

$in['Command'] = "MAIN";
$in['Command2'] = "DEBUG";

$w_bid = $id;
if(($teamID != "없음")&&($teamID != "")){$w_bid .= "&" . $teamID;}
$bid = $w_id;
if(($w_teamID != "없음")&&($w_teamID != "")){$bid .= "&" . $w_teamID;}

SAVE();
SAVE2();

}
#=================#
# ■ 아이템 정리 #
#=================#
function ITEMSEIRI(){
global $in;

global $item,$eff,$itai,$log;

$wk = $in['Command'];
$wk = preg_replace("/SEIRI_/","",$wk);
list($itn,$ik) = explode("<>",$item[$wk]);

$wk2 = $in['Command2'];
$wk2 = preg_replace("/SEIRI2_/","",$wk2);
list($itn2,$ik2) = explode("<>",$item[$wk2]);
#락없어?＆TEMP
$ik3 = '';

if(($item[$wk] == "없음")||($item[$wk2] == "없음") ){
	ERROR("부정한 액세스입니다","item not found","ITEM2",__FUNCTION__,__LINE__);
}

$log = ($log . "아이템을 정리합니다.<br>");

if($wk == $wk2){ #동아이템 선택?
	$log = ($log . "{$itn} 를 다시 넣었습니다.<br>");
}elseif($itn == $itn2){#이름 동일
	#회복 아이템 정리(체력·스태미너)
	if($eff[$wk] == $eff[$wk2] && ((preg_match("/HH|HD/",$ik) && preg_match("/HH|HD/",$ik2))||(preg_match("/SH|SD/",$ik) && preg_match("/SH|SD/",$ik2)))){
		$itai[$wk] = $itai[$wk] + $itai[$wk2];
		if		($ik == "HD2"|| $ik2 == "HD2")	{$ik3 = "HD2";}
		elseif	($ik == "HD1"|| $ik2 == "HD1")	{$ik3 = "HD1";}
		elseif	($ik == "HD" || $ik2 == "HD")	{$ik3 = "HD";}
		elseif	($ik == "HH" && $ik2 == "HH")	{$ik3 = "HH";}
		elseif	($ik == "SD2"|| $ik2 == "SD2")	{$ik3 = "SD2";}
		elseif	($ik == "SD1"|| $ik2 == "SD1")	{$ik3 = "SD1";}
		elseif	($ik == "SD" || $ik2 == "SD")	{$ik3 = "SD";}
		elseif	($ik == "SH" && $ik2 == "SH")	{$ik3 = "SH";}
		else	{ERROR("내부 에러 관리자에게 연락해 주세요","SEIRI ERROR","ITEM2",__FUNCTION__,__LINE__);}
		$item[$wk] = "$itn<>$ik3";$ik3 = '';
		$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;
	}elseif($ik == $ik2){#타입 동일
		if($ik == "Y" && preg_match("/탄환/",$itn)){#탄환
			$eff[$wk] = $eff[$wk] + $eff[$wk2];
			$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;
		}elseif(preg_match("/<>WC|<>WD|<>TN|제비|숫돌|못|해독제|재봉도구|배터리/",$item[$wk])){#모으는 요소
			if($eff[$wk] == $eff[$wk2]){#효과 동일
				$itai[$wk] = $itai[$wk] + $itai[$wk2];
				$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;
			}elseif(!preg_match("/<>WC|<>WD|<>TN/",$item[$wk])){#불일치
				$itai[$wk] *= $eff[$wk];
				$itai[$wk2] *= $eff[$wk2];
				$eff[$wk] = 1;
				$itai[$wk] += $itai[$wk2];
				$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;
			}else{
				$ik3 = 1;
			}
		}else{
			$ik3 = 1;
		}
	}else{
		$ik3 = 1;
	}
}else{
	$ik3 = 1;
}

if($ik3){ #다른 아이템·모을 수 없는 것선택
	$log = ($log . "{$itn} 와 {$itn2} 는 모을 수 없는데.<br>");
}else{
	$log = ($log . "{$itn} 를 모았습니다.<br>");
}

$in['Command'] = "MAIN";
$in['Command2'] = "";

SAVE();

}
#=================#
# ■ 아이템 합성 #
#=================#
function ITEMGOUSEI(){
global $in;

global $item,$itai,$log,$wk1,$wk2,$wk3,$itn1,$itn2,$itn3,$ik1,$ik2,$ik3,$j,$gousei;
$gousei=1;
$wk1 = $in['Command'];
if($wk1 == "GOUSEI1_N"){
	$wk1 = "없음";$gousei--;
}else{
	$wk1 = preg_replace("/GOUSEI1_/","",$wk1);
	list($itn1, $ik1) = explode("<>",$item[$wk1]);
}
$wk2 = $in['Command2'];
if($wk2 == "GOUSEI2_N"){
	$wk2 = "없음";$gousei--;
}else{
	$wk2 = preg_replace("/GOUSEI2_/","",$wk2);
	list($itn2, $ik2) = explode("<>",$item[$wk2]);
}
$wk3 = $in['Command3'];
if($wk3 == "GOUSEI3_N"){
	$wk3 = "없음";$gousei--;
}else{
	$wk3 = preg_replace("/GOUSEI3_/","",$wk3);
	list($itn3, $ik3) = explode("<>",$item[$wk3]);
}

if($gousei == 0){
	if($wk1 == "없음"){
		$wk1 = $wk3;
		$wk3 = "없음";
		$itn1 = $itn3;
		$itn3 = "";
		$ik1 = $ik3;
		$ik3 = "";
	}elseif($wk2 == "없음"){
		$wk2 = $wk3;
		$wk3 = "없음";
		$itn2 = $itn3;
		$itn3 = "";
		$ik2 = $ik3;
		$ik3 = "";
	}
	if($wk3 != "없음"){
		ERROR("Internal Server ERROR","","ITEM2",__FUNCTION__,__LINE__);
	}
}

if($gousei < 0){$log = ($log . "아이템이 올바르게 선택되고 있지 않습니다.<br>");}
else{
	$chk = "NG";
	if (($itai[$wk1] == 1)||($itai[$wk1] == "∞")){
		$chk = "ON";$itai[$wk1] == 1;$j=$wk1;
	}elseif(preg_match("/DB|DH|DF|DA/",$ik1)){
		$chk = "ON";$j=$wk1;
	}elseif(($itai[$wk2] == 1)||($itai[$wk2] == "∞")){
		$chk = "ON";$itai[$wk2] == 1;$j=$wk2;
	}elseif(preg_match("/DB|DH|DF|DA/",$ik2)){
		$chk = "ON";$j=$wk2;
	}elseif(($gousei == 1)&&(($itai[$wk3] == 1)||($itai[$wk3] == "∞"))){
		$chk = "ON";$itai[$wk3] == 1;$j=$wk3;
	}elseif(($gousei == 1)&&(preg_match("/DB|DH|DF|DA/",$ik3))){
		$chk = "ON";$j=$wk3;
	}else{
		for ($j=0;$j<5;$j++){
			if($item[$j] == "없음"){
				$chk = "ON";
				break;
			}
		}
	}

	if($chk == "NG"){$log = ($log . "그 이상 데이팩에 들어가지 않습니다.<br>");}
	else{#아이템 합성 배분 2개·3개·ERROR
		if($gousei == 0){ITEMGOUTWO();}
		elseif($gousei == 1){ITEMGOUTHREE();}
		else{ERROR("Internal Server ERROR","","ITEM2",__FUNCTION__,__LINE__);}
	}
}
$in['Command'] = "MAIN";
$in['Command2'] = "";

SAVE();

}
#==================#
# ■ 아이템 합성 2 #
#==================#
function ITEMGOUTWO(){
global $log,$wk1,$wk2,$itn1,$itn2,$j,$item,$eff,$itai;
$log = ($log . "아이템을 합성합니다.<br>");
if(($wk1 == $wk2)||($itn1 == $itn2)){$log = ($log . "{$itn1}를 바라보았다.<br>");}#동아이템 선택?
else{
	global $g_item1,$g_item2,$g_item3,$g_name,$g_kind,$g_eff,$g_itai;
	ITEMTABLE();
	#테이블 작성
	$k = 0;
	$l = count($g_item1);
	for ($k=0;$k<$l;$k++){
		$gousei{"$g_item1[$k]"}{"$g_item2[$k]"}{"name"} = "$g_name[$k]";
		$gousei{"$g_item1[$k]"}{"$g_item2[$k]"}{"kind"} = "$g_kind[$k]";
		$gousei{"$g_item1[$k]"}{"$g_item2[$k]"}{"eff"}  = "$g_eff[$k]";
		$gousei{"$g_item1[$k]"}{"$g_item2[$k]"}{"itai"} = "$g_itai[$k]";
	}
	if($gousei{$itn1}{$itn2}{"name"}){ #합성 테이블 사용 합성
		$log = ($log . "{$itn1}와{$itn2}로" . $gousei{$itn1}{$itn2}{"name"} . "(을)를 할 수 있었다!<BR>");
		$item[$j] = $gousei{$itn1}{$itn2}{"name"} . "<>" . $gousei{$itn1}{$itn2}{"kind"};
		$eff[$j] = $gousei{$itn1}{$itn2}{"eff"};
		$itai[$j] = $gousei{$itn1}{$itn2}{"itai"};
		ITEMCOUNT();
	}elseif($gousei{$itn2}{$itn1}{"name"}){ #합성 테이블 사용 합성(역)
		$log = ($log . "{$itn1}와{$itn2}로" . $gousei{$itn2}{$itn1}{"name"} . "(을)를 할 수 있었다!<BR>");
		$item[$j] = $gousei{$itn2}{$itn1}{"name"} . "<>" . $gousei{$itn2}{$itn1}{"kind"};
		$eff[$j] = $gousei{$itn2}{$itn1}{"eff"};
		$itai[$j] = $gousei{$itn2}{$itn1}{"itai"};
		ITEMCOUNT();
	}else{$log = ($log . "{$itn1}와{$itn2}는 조합할 수 없는데.<br>");}#다른 아이템·합성할 수 없는 것선택
}
}
#==================#
# ■ 아이템 합성 3 #
#==================#
function ITEMGOUTHREE(){
global $log,$wk1,$wk2,$wk3,$itn1,$itn2,$itn3,$j,$item,$eff,$itai;
$log = ($log . "아이템을 합성합니다.<br>");
if((($wk1 == $wk2)||($itn1 == $itn2))||(($wk1 == $wk3)||($itn1 == $itn3))){$log = ($log . "{$itn1}를 바라보았다.<br>");}#동아이템 선택?
elseif(($wk2 == $wk3)||($itn2 == $itn3)){$log = ($log . "{$itn2}를 바라보았다.<br>");}
else{
	global $g_item1,$g_item2,$g_item3,$g_name,$g_kind,$g_eff,$g_itai;
	ITEMTABLE();
	#테이블 작성
	$k = 0;
	$l = count($g_item1);
	for ($k=0;$k<$l;$k++){
		$gousei{"$g_item1[$k]"}{"$g_item2[$k]"}{"$g_item3[$k]"}{"name"} = "$g_name[$k]";
		$gousei{"$g_item1[$k]"}{"$g_item2[$k]"}{"$g_item3[$k]"}{"kind"} = "$g_kind[$k]";
		$gousei{"$g_item1[$k]"}{"$g_item2[$k]"}{"$g_item3[$k]"}{"eff"}  = "$g_eff[$k]";
		$gousei{"$g_item1[$k]"}{"$g_item2[$k]"}{"$g_item3[$k]"}{"itai"} = "$g_itai[$k]";
	}
	if($gousei{$itn1}{$itn2}{$itn3}{"name"}){ #합성 테이블 사용 합성 1
		$log = ($log . "{$itn1}와{$itn2}와{$itn3}로" . $gousei{$itn1}{$itn2}{$itn3}{"name"} . "(을)를 할 수 있었다!<BR>");
		$item[$j] = $gousei{$itn1}{$itn2}{$itn3}{"name"} . "<>" . $gousei{$itn1}{$itn2}{$itn3}{"kind"};
		$eff[$j] = $gousei{$itn1}{$itn2}{$itn3}{"eff"};
		$itai[$j] = $gousei{$itn1}{$itn2}{$itn3}{"itai"};
		ITEMCOUNT();
	}elseif($gousei{$itn1}{$itn3}{$itn2}{"name"}){#합성 테이블 사용 합성 2
		$log = ($log . "{$itn1}와{$itn2}와{$itn3}로" . $gousei{$itn1}{$itn3}{$itn2}{"name"} . "(을)를 할 수 있었다!<BR>");
		$item[$j] = $gousei{$itn1}{$itn3}{$itn2}{"name"} . "<>" . $gousei{$itn1}{$itn3}{$itn2}{"kind"};
		$eff[$j] = $gousei{$itn1}{$itn3}{$itn2}{"eff"};
		$itai[$j] = $gousei{$itn1}{$itn3}{$itn2}{"itai"};
		ITEMCOUNT();
	}elseif($gousei{$itn2}{$itn1}{$itn3}{name}){#합성 테이블 사용 합성 3
		$log = ($log . "{$itn1}와{$itn2}와{$itn3}로" . $gousei{$itn2}{$itn1}{$itn3}{"name"} . "(을)를 할 수 있었다!<BR>");
		$item[$j] = $gousei{$itn2}{$itn1}{$itn3}{"name"} . "<>" . $gousei{$itn2}{$itn1}{$itn3}{"kind"};
		$eff[$j] = $gousei{$itn2}{$itn1}{$itn3}{"eff"};
		$itai[$j] = $gousei{$itn2}{$itn1}{$itn3}{"itai"};
		ITEMCOUNT();
	}elseif($gousei{$itn2}{$itn3}{$itn1}{"name"}){#합성 테이블 사용 합성 4
		$log = ($log . "{$itn1}와{$itn2}와{$itn3}로" . $gousei{$itn2}{$itn3}{$itn1}{"name"} . "(을)를 할 수 있었다!<BR>");
		$item[$j] = $gousei{$itn2}{$itn3}{$itn1}{"name"} . "<>" . $gousei{$itn2}{$itn3}{$itn1}{"kind"};
		$eff[$j] = $gousei{$itn2}{$itn3}{$itn1}{"eff"};
		$itai[$j] = $gousei{$itn2}{$itn3}{$itn1}{"itai"};
		ITEMCOUNT();
	}elseif($gousei{$itn3}{$itn2}{$itn1}{"name"}){#합성 테이블 사용 합성 5
		$log = ($log . "{$itn1}와{$itn2}와{$itn3}로" . $gousei{$itn3}{$itn2}{$itn1}{"name"} . "(을)를 할 수 있었다!<BR>");
		$item[$j] = $gousei{$itn2}{$itn3}{$itn1}{"name"} . "<>" . $gousei{$itn3}{$itn2}{$itn1}{"kind"};
		$eff[$j] = $gousei{$itn3}{$itn2}{$itn1}{"eff"};
		$itai[$j] = $gousei{$itn3}{$itn2}{$itn1}{"itai"};
		ITEMCOUNT();
	}elseif($gousei{$itn3}{$itn1}{$itn2}{"name"}){#합성 테이블 사용 합성 6
		$log = ($log . "{$itn1}와{$itn2}와{$itn3}로" . $gousei{$itn3}{$itn1}{$itn2}{"name"} . "(을)를 할 수 있었다!<BR>");
		$item[$j] = $gousei{$itn3}{$itn1}{$itn2}{"name"} . "<>" . $gousei{$itn3}{$itn1}{$itn2}{"kind"};
		$eff[$j] = $gousei{$itn3}{$itn1}{$itn2}{"eff"};
		$itai[$j] = $gousei{$itn3}{$itn1}{$itn2}{"itai"};
		ITEMCOUNT();
	}else{$log = ($log . "{$itn1}와{$itn2}와{$itn3}는 조합할 수 없는데.<br>");}#다른 아이템·합성할 수 없는 것선택
}
}
#=====================#
# ■ 아이템 카운트 #
#=====================#
function ITEMCOUNT(){
global $j,$wk1,$wk2,$wk3,$ik1,$ik2,$ik3,$item,$eff,$itai,$gousei;
if($wk1 == $j){
	if(preg_match("/DB|DH|DF|DA/",$ik2)){$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;}
	else{$itai[$wk2] -= 1;if($itai[$wk2] <= 0){$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;}}
	if($gousei == 1){
		if(preg_match("/DB|DH|DF|DA/",$ik3)){$item[$wk3] = "없음";$eff[$wk3] = 0;$itai[$wk3] = 0;}
		else{$itai[$wk3] -= 1;if($itai[$wk3] <= 0){$item[$wk3] = "없음";$eff[$wk3] = 0;$itai[$wk3] = 0;}}
	}
}elseif($wk2 == $j){
	if(preg_match("/DB|DH|DF|DA/",$ik1)){$item[$wk1] = "없음";$eff[$wk1] = 0;$itai[$wk1] = 0;}
	else{$itai[$wk1] -= 1;if($itai[$wk1] <= 0){$item[$wk1] = "없음";$eff[$wk1] = 0;$itai[$wk1] = 0;}}
	if($gousei == 1){
		if(preg_match("/DB|DH|DF|DA/",$ik3)){$item[$wk3] = "없음";$eff[$wk3] = 0;$itai[$wk3] = 0;}
		else{$itai[$wk3] -= 1;if($itai[$wk3] <= 0){$item[$wk3] = "없음";$eff[$wk3] = 0;$itai[$wk3] = 0;}}
	}
}elseif(($gousei == 1)&&($wk3 == $j)){
	if(preg_match("/DB|DH|DF|DA/",$ik1)){$item[$wk1] = "없음";$eff[$wk1] = 0;$itai[$wk1] = 0;}
	else{$itai[$wk1] -= 1;if($itai[$wk1] <= 0){$item[$wk1] = "없음";$eff[$wk1] = 0;$itai[$wk1] = 0;}}
	if(preg_match("/DB|DH|DF|DA/",$ik2)){$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;}
	else{$itai[$wk2] -= 1;if($itai[$wk2] <= 0){$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;}}
}else{
	if(preg_match("/DB|DH|DF|DA/",$ik1)){
		$item[$wk1] = "없음";$eff[$wk1] = 0;$itai[$wk1] = 0;
	}else{
		$itai[$wk1] -= 1;
		if($itai[$wk1] <= 0){
			$item[$wk1] = "없음";$eff[$wk1] = 0;$itai[$wk1] = 0;
		}
	}
	if(preg_match("/DB|DH|DF|DA/",$ik2)){
		$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;
	}else{
		$itai[$wk2] -= 1;
		if($itai[$wk2] <= 0){
			$item[$wk2] = "없음";$eff[$wk2] = 0;$itai[$wk2] = 0;
		}
	}
	if($gousei == 1){
		if(preg_match("/DB|DH|DF|DA/",$ik3)){
			$item[$wk3] = "없음";$eff[$wk3] = 0;$itai[$wk3] = 0;
		}else{
			$itai[$wk3] -= 1;
			if($itai[$wk3] <= 0){
				$item[$wk3] = "없음";$eff[$wk3] = 0;$itai[$wk3] = 0;
			}
		}
	}
}
}
#=====================#
# ■ 아이템 테이블 #
#=====================#
function ITEMTABLE(){
global $g_item1,$g_item2,$g_item3,$g_name,$g_kind,$g_eff,$g_itai;
#아이템 합성용 테이블 데이터
#합성 소재 1
$g_item1 = array(	"경유",	"가솔린",		"신관",		"화약",				"스프레이캔",			"휴대 전화",		"죽",		"빵",		"팥소");
#합성 소재 2
$g_item2 = array(	"비료",	"빈병",		"화약",		"도화선",			"라이터",				"파워 북",	"송이버섯",		"카레",	"빵");
#합성 소재 3
$g_item3 = array(	"없음",	"없음",			"없음",		"없음",				"없음",					"없음",			"없음",		"없음",		"없음");
#합성 아이템 명칭
$g_name = array(	"화약",	"☆화염병☆",	"☆폭탄☆",	"★다이너마이트★",	"★간이 화염 방사기★",	"모바일 PC",	"송이버섯 밥",	"카레 빵","응");
#합성 아이템 종류
$g_kind = array(	"Y",	"WD",			"WD",		"WD",				"WG",					"Y",			"SH",		"HH",		"SH");
#합성 아이템 효과치
$g_eff = array(		"1",	"40",			"50",		"75",				"80",					"1",			"100",		"100",		"200");
#합성 아이템 내구도
$g_itai = array(	"1",	"1",			"1",		"6",				"8",					"0",			"2",		"2",		"1");
}
?>