<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR COMMAND DISPLAY    - 	 ■
#□ 			 -  ITEM  - 			 □
#■□■□■□■□■□■□■□■□■□■□■
global $in;

global $item;
$i = 0;
if ($in['Command3'] == "GET"){	#아이템
	$chkflg = -1;
	for ($i=0; $i<5; $i++) {if ($item[$i] == "없음") {$chkflg = $i;break;}}#빈아이템?
	if ($chkflg == "-1"){
		$log = ($log . "아이템이 더 이상가방에 들어가지 않는다.<br>어떤 것을 버릴까…<BR>");
		print "어떤 것을 버립니까?<BR><BR>";
		list($itn,$ik) = explode("<>",$item_get) ;Auto();
		print "<INPUT type=\"radio\" name=\"Command\" value=\"ITEMDELNEW\" checked>$itn/$eff_get/$itai_get</A><BR><BR>";
		for ($i=0;$i<5;$i++) {if($item[$i] != "없음"){list($itn, $ik) = explode("<>",$item[$i]) ;Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"ITEMNEWXCG_$i\">$itn/$eff[$i]/$itai[$i]</A><BR>";}}
	}else{
		print "아이템을 어떻게 합니까?<BR><BR>";Auto();
		print "<INPUT type=\"radio\" name=\"Command\" value=\"ITEMDELNEW\" checked>버린다</A><BR><BR>";Auto();
		print "<INPUT type=\"radio\" name=\"Command\" value=\"ITEMGETNEW\">줍는다</A><BR>";
	}
	if($in['Command2'] == "SAME_ITEM"){
		print "<BR>이하의 아이템과 모은다<BR>";
		for($i=0; $i<5; $i++){#동일 아이템 판단
			if(($item[$i] == $item_get)&&($eff[$i] == $eff_get)&&(preg_match("/물|빵/",$item_get))){
				list($itn,$ik) = explode("<>",$item[$i]);
				Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"ITEMSEINEW_$i\">$itn/$eff[$i]/$itai[$i]</A><BR>";
			}
		}
	}
	print "<BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif ($in['Command3'] == "ITEM"){	#아이템
	$log = ($log . "데이팩안에는, 무엇이 들어가 있었는지….<BR>") ;
	print "무엇을 사용합니까?<BR><BR>";Auto();
	print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR><BR>";
	for ($i=0; $i<5; $i++){if($item[$i] != "없음") {list($itn, $ik) = explode("<>",$item[$i]) ;Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"ITEM_$i\">$itn/$eff[$i]/$itai[$i]</A><BR>";}}
	print "<BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif ($in['Command3'] == "DEL"){	#아이템 투기
	$log = ($log . "데이팩안을 정리할까….<BR>");
	print "무엇을 버립니까?<BR><BR>";Auto();
	print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR><BR>";
	for ($i=0; $i<5; $i++) {if ($item[$i] != "없음") {list($itn, $ik) = explode("<>",$item[$i]) ;Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"DEL_$i\">$itn/$eff[$i]/$itai[$i]</A><BR>";}}
	print "<BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif ($in['Command3'] == "SEIRI"){	#아이템 정리
	$log = ($log . "데이팩안을 정리할까….<BR>");
	print "뭐라고 무엇을 모읍니까?<BR><BR>";
	print "<select name=\"Command\">";
	print "<option value=\"MAIN\" selected>멈춘다</option>";
	for ($i=0; $i<5; $i++) {if ($item[$i] != "없음") {list($itn, $ik) = explode("<>",$item[$i]) ;print "<option value=\"SEIRI_$i\">$itn/$eff[$i]/$itai[$i]</option>";}}
	print "</select><BR><BR><select name=\"Command2\"><option value=\"MAIN\" selected>멈춘다</option>";
	for ($i2=0; $i2<5; $i2++) {if ($item[$i2] != "없음") {list($itn2, $ik2) = explode("<>",$item[$i2]) ;print "<option value=\"SEIRI2_$i2\">$itn2/$eff[$i2]/$itai[$i2]</option>";}}
	print "</select><BR><BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} elseif ($in['Command3'] == "GOUSEI"){	#아이템 합성
	$log = ($log . "지금 가지고 있는 것을 조합하고, 무엇인가 만들 수 없을까?<BR>") ;
	print "뭐라고 무엇을 합성합니까?<BR><BR>";
	print "<select name=\"Command\"><option value=\"GOUSEI1_N\" selected>합성 1</option>" ;
	for ($i=0; $i<5; $i++) {if ($item[$i] != "없음") {list($itn, $ik) = explode("<>",$item[$i]) ;print "<option value=\"GOUSEI1_$i\">$itn/$eff[$i]/$itai[$i]</option>";}}
	print "</select><BR><BR><select name=\"Command2\"><option value=\"GOUSEI2_N\" selected>합성 2</option>" ;
	for ($i2=0; $i2<5; $i2++) {if ($item[$i2] != "없음") {list($itn2, $ik2) = explode("<>",$item[$i2]) ;print "<option value=\"GOUSEI2_$i2\">$itn2/$eff[$i2]/$itai[$i2]</option>";}}
	print "</select><BR><BR><select name=\"Command3\"><option value=\"GOUSEI3_N\" selected>합성 3</option>";
	for ($i3=0; $i3<5; $i3++) {if ($item[$i3] != "없음") {list($itn3, $ik3) = explode("<>",$item[$i3]) ;print "<option value=\"GOUSEI3_$i3\">$itn3/$eff[$i3]/$itai[$i3]</option>";}}
	print "</select><BR><BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
} else {
	print "무엇을 실시합니까?<BR><BR>";
Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR><BR>";
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
}
?>