<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	- BR ADMINISTRATOR SCRIPT - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ ITEMLIST	-	아이템 일람		 □
#■□■□■□■□■□■□■□■□■□■□■
#=================#
# ■ 아이템 일람 #
#=================#
function ITEMLIST(){
global $pref;
HEAD();
?>
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
<TABLE border="1" class="b3">
<?
#Display Area Item
for ($j=0; $j<count($pref['area']); $j++){
	$filename = $pref['LOG_DIR'].'/'.$j.$pref['item_file'];
	$itemlist = @file($filename);
	echo '<TR><TD colspan="12" class="b1"><font size="+2" color="yellow">'.$pref['place'][$j].'</font></TD></TR><TR><TD class="b2">아이템명<>종류</TD><TD class="b2">종류</TD><TD class="b2">효과</TD><TD class="b2">수량</TD><TD class="b2">아이템명<>종류</TD><TD class="b2">종류</TD><TD class="b2">효과</TD><TD class="b2">수량</TD><TD class="b2">아이템명<>종류</TD><TD class="b2">종류</TD><TD class="b2">효과</TD><TD class="b2">수량</TD></TR>';
	for ($i=0;$i<count($itemlist);$i+=3){
		itemtype($itemlist[$i],1,$i);
		if(isset($itemlist[$i+1])){itemtype($itemlist[$i+1],2,$i);}
		if(isset($itemlist[$i+2])){itemtype($itemlist[$i+2],3,$i);}
	}
}
?>
</TABLE>
<BR>
<?
FOOTER();
}
#=================#
# ■ 아이템 종류 #
#=================#
function itemtype($itemlist,$table){
global $item,$i;
list($w_i,$w_e,$w_t) = explode(',',$itemlist);
list($i_name,$i_kind) = split('<>',$w_i);
if(preg_match("/HH|HD/",$i_kind)){$itemtype = "【체력 회복】";}
elseif(preg_match("/SH|SD/",$i_kind)){$itemtype = "【스태미너 회복】";}
elseif($i_kind == "TN"){$itemtype = "【함정】";}
elseif(preg_match("/W/",$i_kind)){$itemtype = "【무기";
	if(preg_match("/G/",$i_kind))	{$itemtype = ($itemtype . "(총)");}
	if(preg_match("/S/",$i_kind))	{$itemtype = ($itemtype . "(소음)");}
	if(preg_match("/K/",$i_kind))	{$itemtype = ($itemtype . "(참)");}
	if(preg_match("/C/",$i_kind))	{$itemtype = ($itemtype . "(투)");}
	if(preg_match("/B/",$i_kind))	{$itemtype = ($itemtype . "(구)");}
	if(preg_match("/D/",$i_kind))	{$itemtype = ($itemtype . "(폭)");}
	$itemtype = ($itemtype . "】");}
elseif(preg_match("/D/",$i_kind))	{$itemtype = "【방어구";
	if(preg_match("/B/",$i_kind))	{$itemtype = ($itemtype . "(몸)");}
	if(preg_match("/H/",$i_kind))	{$itemtype = ($itemtype . "(머리)");}
	if(preg_match("/F/",$i_kind))	{$itemtype = ($itemtype . "(다리)");}
	if(preg_match("/A/",$i_kind))	{$itemtype = ($itemtype . "(팔)");}
	$itemtype = ($itemtype . "】");}
elseif(($i_kind == 'R1')||($i_kind == 'R2')){$itemtype = "【레이더-】";}
elseif($i_kind == 'Y'){
	if(($i_name == "가짜 프로그램 해제 키")||($i_name == "프로그램 해제 키")){$itemtype = "【해제 키】";}
	elseif($i_name == "【탄환】"){$itemtype = "【탄】";}
	else{$itemtype = "【도구】";}}
elseif($i_kind == 'A'){$itemtype = "【장식품】";}
elseif($item[$i] == "없음"){$itemtype = "【없음】";}
else{$itemtype = "【불명】";}
if($table == 1){
	print "<TR><TD class=\"b3\">$w_i</TD><TD><font color=\"00ffff\">$itemtype</font></TD><TD class=\"b3\">$w_e</TD><TD class=\"b3\">$w_t</TD>";
}elseif($table == 2){
	print "<TD class=\"b3\">$w_i</TD><TD><font color=\"00ffff\">$itemtype</font></TD><TD class=\"b3\">$w_e</TD><TD class=\"b3\">$w_t</TD>";
}elseif($table == 3){
	print "<TD class=\"b3\">$w_i</TD><TD><font color=\"00ffff\">$itemtype</font></TD><TD class=\"b3\">$w_e</TD><TD class=\"b3\">$w_t</TD></TR>";
}

}
?>