<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR COMMAND DISPLAY    - 	 ■
#□ 			-  SPECIAL  -			 □
#■□■□■□■□■□■□■□■□■□■□■
$i = 0;
if($in['Command4'] == "OUKYU"){	#응급 처치
	global $inf;
	$log .=  "상처의 치료를 할까….<BR>";
	print "어디를 치료합니까?<BR><BR>";Auto();
	print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR><BR>";
	if(preg_match("/머리/",$inf)){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUK_0\">두</A><BR>";}
	if(preg_match("/팔/",$inf)){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUK_1\">팔</A><BR>";}
	if(preg_match("/배/",$inf)){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUK_2\">복부</A><BR>";}
	if(preg_match("/다리/",$inf)){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUK_3\">다리</A><BR>";}
	if((preg_match("/독/",$inf))&&($pref['clb'][$in['club']] == "다도부")){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUK_4\">독</A><BR>";}
	print "<BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif($in['Command4'] == "KOUDOU"){	#기본방침
	$log .=  "Do you want to change a mode?.<BR>";
	print "Please set a mode.<BR><BR>";
	Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>{$tactics}</A><BR><BR>";
	if($tactics != '통상'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"KOU_0\">Normal</A><BR>";
	}if($tactics != '공격 중시'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"KOU_1\">Prioritize Attack</A><BR>";
	}if($tactics != '방어 중시'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"KOU_2\">Prioritize Defense</A><BR>";
	}if($tactics != '은밀 행동'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"KOU_3\">Prioritize Hiding</A><BR>";
	}if($tactics != '탐색 행동'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"KOU_4\">Explorer Mode</A><BR>";
	}
	if($ar >= 7){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"KOU_5\">련투행동</A><BR>";}
	print "<BR><INPUT type=\"submit\" name=\"Enter\" value=\"Set\">";
} elseif($in['Command4'] == "OUSEN"){	#응전 방침
	$log .=  "Want to change in-attack mode?….<BR>";
	print "Please set in-attack mode.<BR><BR>";
	Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>{$ousen}</A><BR><BR>";
	if($ousen != '통상'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUS_0\">Normal</A><BR>";
	}if($ousen != '공격 몸의 자세'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUS_1\">Attack Mode</A><BR>";
	}if($ousen != '방어 몸의 자세'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUS_2\">Defense Mode</A><BR>";
	}if($ousen != '은밀 몸의 자세'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUS_3\">Hiding Mode</A><BR>";
	}if($ousen != '탐색 행동'){
		#Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUS_4\">탐색 행동</A><BR>";
	}if($ousen != '련투행동'){
		#Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUS_5\">련투행동</A><BR>";
	}if($ousen != '치료 전념'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUS_6\">Prioritize Healing</A><BR>";
	}if($ousen != '도망 몸의 자세'){
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"OUS_7\">Escape Mode</A><BR>";
	}
	print "<BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif($in['Command4'] == "BAITEN"){	#매점
	require $pref['LIB_DIR']."/lib3.php";BAITEN();
} elseif($in['Command4'] == "POISON"){	#독물 혼입
	$log .=  "이 독약을 혼합하면…후후후.<BR>";
	print "무엇에 독물 혼입합니까?<BR><BR>";
Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR><BR>";
	for ($i=0; $i<5; $i++){
		if(preg_match("/<>SH|<>HH|<>SD|<>HD/",$item[$i])){
			list($itn, $ik) = explode("<>",$item[$i]);
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"POI_$i\">$itn/$eff[$i]/$itai[$i]</A><BR>";
		}
	}
	print "<BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif($in['Command4'] == "PSCHECK"){	#독 봐
	$log .=  "Examining for suspicious substances….<BR>";
Auto() ;print "무슨독 봐를 합니까?<BR><BR><INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR><BR>";
	for ($i=0; $i<5; $i++){
		if(preg_match("/<>SH|<>HH|<>SD|<>HD/",$item[$i])){
			list($itn, $ik) = explode("<>",$item[$i]);
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"PSC_$i\">$itn/$eff[$i]/$itai[$i]</A><BR>";
		}
	}
	print "<BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif($in['Command4'] == "SPIICH"){ #휴대 스피커 사용
	$log .=  "이것을 사용하면, 모두로 들릴리다…<BR><BR>";
	print "휴대 스피커를 사용하고, 전원에게 전언을 전합니다.";
	print "(전각 20 문자까지)<BR><BR>";
	print "<INPUT size=\"30\" type=\"text\" name=\"speech\"maxlength=\"50\"><BR><BR>";
Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"SPEAKER\">전한다</A><BR>";
Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>멈춘다</A><BR><BR>";
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">\n";
} elseif($in['Command4'] == "WINCHG"){	#말버릇 변경
	$log .=  "살해시, 사망시의 말버릇을 변경합니다.<BR>";
	print "말버릇을 입력해 주세요<BR>(전각 32 문자까지)<BR><BR>";
	print "살해시：<BR><INPUT size=\"30\" type=\"text\" name=\"Message\" maxlength=\"64\" value=\"$msg\"><BR><BR>";
	print "유언：<BR><INPUT size=\"30\" type=\"text\" name=\"Message2\" maxlength=\"64\" value=\"$dmes\"><BR><BR>";
	print "한마디 코멘트：<BR><INPUT size=\"30\" type=\"text\" name=\"Comment\" maxlength=\"64\" value=\"$com\"><BR><BR>";
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif($in['Command4'] == "TEAM"){	#팀
	$log .=  "그룹의 결성·가입·탈퇴<BR>";
	print "그룹명을 입력해 주세요<BR>　　 상, 탈퇴하는 경우는<br>　　　　  양쪽 모두 「없음」으로 해 주세요.<BR>";
	print "(전각 12 문자까지)<BR><BR>";
	print "<INPUT size=\"30\" type=\"text\" name=\"teamID2\" maxlength=\"24\" value=\"$teamID\"><BR><BR><BR>";
	print "패스워드를 입력해 주세요：<BR>(전각 12 문자까지)<BR><BR>";
	if(($teamID != '')||($teamID != '없음')){$in['teamPass2'] = "변경하지 않는 경우는 이대로";}else{$in['teamPass2'] = "";}
	print "<INPUT size=\"30\" type=\"text\" name=\"teamPass2\" maxlength=\"24\" value=\"$in[teamPass2]\"><BR><BR>";
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif($in['Command4'] == "MOB_STS"){	#상세 스테이터스
	global $cln,$money_disp;
	$log .=  "상세 스테이터스<BR>";
?>
출석 번호：<?=$cln?><br>
Group：<?=$teamID?><br>
Experience Level：구:<?=$wp?>Gun:<?=$wg?>참:<?=$wn?>투:<?=$wc?>Explosive:<?=$wd?><br>
In-Attack Mode：<?=$ousen?><br>
Club：<?=$pref['clb'][$in['club']]?><br>
Money：<?=$money_disp?> Yen<br>
<?
Auto() ;print "<br><INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR><BR>";
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif($in['Command4'] == "MOB_A-I"){	#장비·소지품
	global $b_name_h,$b_name_a,$b_name_f,$b_name_i,$item;
	$log .=  "장비·소지품<BR>";
?>
Equipment<br>
<br>
Type/Name/Effect/Durability<br>
Head/<?=$b_name_h?>/<?=$bdef_h?>/<?=$btai_h?><br>
Arms/<?=$b_name_a?>/<?=$bdef_a?>/<?=$btai_a?><br>
Legs/<?=$b_name_f?>/<?=$bdef_f?>/<?=$btai_f?><br>
Feet/<?=$b_name_i?>/<?=$eff[5]?>/<?=$itai[5]?><br>
<br>
Items<br>
Name/Effect/Amount/Type<br>
<?
	for ($i=0;$i<5;$i++) {$itemtype = "";
		@list($i_name,$i_kind) = explode("<>",$item[$i]);
		if	(preg_match("/HH|HD/",$i_kind))	{$itemtype = "【회복：체력】";}
		elseif	(preg_match("/SH|SD/",$i_kind))	{$itemtype = "【회복：스태미너】";}
		elseif	($i_kind == "TN")	{$itemtype = "【함정】";}
		elseif	(preg_match("/W/",$i_kind))	{$itemtype = "【무기：";
			if	(preg_match("/G/",$i_kind))	{$itemtype = ($itemtype . "총");
				if	(preg_match("/S/",$i_kind))	{$itemtype = ($itemtype . "-소음");}
				$itemtype = ($itemtype . ")");}
			if	(preg_match("/K/",$i_kind))	{$itemtype = ($itemtype . "참");}
			if	(preg_match("/C/",$i_kind))	{$itemtype = ($itemtype . "투");}
			if	(preg_match("/B/",$i_kind))	{$itemtype = ($itemtype . "구");}
			if	(preg_match("/D/",$i_kind))	{$itemtype = ($itemtype . "폭");}
			$itemtype = ($itemtype . "】");}
		elseif	(preg_match("/D/",$i_kind))	{$itemtype = "【방어구：";
			if	(preg_match("/B/",$i_kind))	{$itemtype = ($itemtype . "몸");}
			if	(preg_match("/H/",$i_kind))	{$itemtype = ($itemtype . "머리");}
			if	(preg_match("/F/",$i_kind))	{$itemtype = ($itemtype . "다리");}
			if	(preg_match("/A/",$i_kind))	{$itemtype = ($itemtype . "팔");}
				if	(preg_match("/K/",$i_kind))	{$itemtype = ($itemtype . "-대：참");}
			$itemtype = ($itemtype . "】");}
		elseif(($i_kind == "R1")||($i_kind == "R2")) {$itemtype = "【레이더-】";}
		elseif($i_kind == "Y") {
			if(($i_name == "가짜 프로그램 해제 키")||($i_name == "프로그램 해제 키")) {$itemtype = "【해제 키】";}
			elseif($i_name == "탄환") {$itemtype = "【탄】";}
			else {$itemtype = "【도구】";}}
		elseif($i_kind == "A") {$itemtype = "【장식품】";}
		elseif($item[$i] == "없음") {$itemtype = "【없음】";}
		else {$itemtype = "【불명】";}
		if($item[$i]!="없음"){
			print "$i_name/$eff[$i]/$itai[$i]/$itemtype<br>";
		}
	}

Auto() ;print "<br><INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>Return</A><BR><BR>";
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} else{
	print "무엇을 실시합니까?<BR><BR>";
Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR><BR>";
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
}
?>