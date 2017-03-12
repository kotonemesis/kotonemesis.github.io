<?
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR STATUS DISPLAY    - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ STS			-		스테이터스부	 ■
#□■□■□■□■□■□■□■□■□■□■□
#=================#
# ■ 스테이터스부 #
#=================#
function STS(){
global $in,$pref;

global $endtime,$watt_2;
global $month,$mday,$week,$hour,$min,$levuprem,$up,$bar_exp,$icon_file,$full_name,$condi,$CONDITION,$cln,$kega,$bar_sta,$ball,$bar_hit,$w_name,$b_name,$bar_lim,$money_disp,$b_name_h,$b_name_a,$b_name_f,$b_name_i;
global $log,$MESSENGER,$m_mem;
global $id,$password,$f_name,$l_name,$sex,$cl,$no,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item,$eff,$itai,$com,$dmes,$bid,$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,$expires;

if((preg_match('/수면|치료|정양/',$sts))&&($in['Command'] == 'MAIN')&&($in['mode'] != 'main')) {
	$up = (int)(($pref['now'] - $endtime) / ($pref['kaifuku_time']));
	if(preg_match('/배/',$inf)){$up = (int)($up / 2);}
	if($ousen == '치료 전념'){$up = (int)($up * 2);}
	if($sts == '수면'){
		$sta += $up;
		if($sta > $pref['maxsta']){$sta = $pref['maxsta'];}#최대치까지 몇 개
		$log .= '수면의 결과, 스태미너가 '.$up.'회복했다.<BR>';
		$sts = '정상';$endtime = 0;SAVE();
	}elseif($sts == '치료'){
		if($pref['kaifuku_rate'] == 0){$pref['kaifuku_rate'] = 1;}
		$up = (int)($up / $pref['kaifuku_rate']);
		$hit += $up;
		if($hit > $mhit){$hit = $mhit;}#최대치까지 몇 개
		$log .= '치료의 결과, 체력이 '.$up.'회복했다.<BR>';
		$sts = '정상';$endtime = 0;SAVE();
	}elseif($sts == '정양'){
		if($pref['kaifuku_rate'] == 0){$pref['kaifuku_rate'] = 1;}
		$ups = $up;
		$up = (int)($up / $pref['kaifuku_rate']);
		$hit += $up;
		if($hit > $mhit){$hit = $mhit;}#최대치까지 몇 개
		$sta += $ups;
		if($sta > $pref['maxsta']){$sta = $pref['maxsta'];}#최대치까지 몇 개
		$log .= '정양의 결과, 체력이 '.$up.', 스태미너가 '.$ups.'회복했다.<BR>';
		$sts = '정상';$endtime = 0;SAVE();
	}
}

#정의(LIB)
definition();
$b_limit = ($pref['battle_limit'] * 3) + 1;
$arealisttemp = rtrim($pref['arealist'][5]);
if($pref['MOBILE']){
?><big><font color="red"><b><?=$pref['place'][$pls]?> (<?=$pref['area'][$pls]?>)</b></font></big><br>
<?=$month?>/ <?=$mday?> <?=$week?> <?=$hour?>:<?=$min?>분<br>
EXP(EXP left to next Level<?=$levuprem?>)：<?=$exp?>/<?=$up?><br>
Weather：<?=$pref['weather'][$arealisttemp]?><br>
Name：<?=$full_name?><br>
Status：<?=preg_replace('/<BR>/','',$condi)?><br>
Injuries：<?=$kega?><br>
Attack：<?=$att?>+<?=$watt_2?><br>
Stamina：<?=$sta?>/<?=$pref['maxsta']?><br>
Defense：<?=$def?>+<?=$ball?><br>
HP：<?=$hit?>/<?=$mhit?><br>
Weapon：<?=$w_name?>/<?=$watt?>/<?=$wtai?><br>
Armor：<?=$b_name?>/<?=$bdef?>/<?=$btai?><br>
Mode：<?=$tactics?><br>
Limit：<?=$limit?>/100<br>
<?
}else{
?>
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold);font-weight:700;text-decoration:underline"><?=$pref['place'][$pls]?> (<?=$pref['area'][$pls]?>)</span></font></center>
<TABLE align="center">
	<TR><TD colspan="2"><B><FONT color="#ff0000"><?=$pref['links']?></FONT></B></TD></TR>
	<TR>
		<TD valign="top" height="1">
		<TABLE border="1" width="550" height="292" cellspacing="0" cellpadding="0">
			<TR valign="middle"><TD width="70" colspan="1" class="b1"><B>LEV. <?=$level?></B></TD>
				<TD colspan="3" class="b1"><B><?=$month?>달 <?=$mday?>일 <?=$week?>요일 <?=$hour?>때<?=$min?>분</B></TD>
				<TD class="b1" width="47"><B>EXP</B></TD>
				<TD class="b3" width="78"><a onmouseover="status='다음의 레벨까지 나머지<?=$levuprem?>';return true;" onmouseout="status='';return true;" href="javascript:void(0)" title="다음의 레벨까지<?=$levuprem?>" style="text-decoration: none"><font color="white"><?=$exp?> / <?=$up?></font><BR><?=$bar_exp?></a></TD>
				<TD class="b1" width="47"><B>Weather</B></TD>
				<TD class="b3" width="79"><?=$pref['weather'][$arealisttemp]?></TD></TR>
			<TR><TD ROWSPAN="4" height="70" class="b3"><IMG src="<?=$pref['imgurl']?>/<?=$icon_file[$icon]?>" border="0" align="middle"></TD>
				<TD width="70" class="b2"><B>Name</B></TD>
				<TD width="145" colspan="2" class="b3"><?=$full_name?></TD>
				<TD ROWSPAN="4" height="70" class="b2"><B>상태</B><?=$condi?></TD>
				<TD ROWSPAN="4" colspan="4" class="b3" height="70"><?=$CONDITION?></TD></TR>
			<TR><TD ROWSPAN="1" class="b2"><B>Number</B></TD>
				<TD ROWSPAN="1" colspan="2" class="b3"><?=$cln?></TD></TR>
			<TR><TD class="b2"><B>Group</B></TD>
				<TD colspan="2" class="b3"><?=$teamID?></TD></TR>
			<TR><TD class="b2"><B>Injuries</B></TD>
				<TD colspan="2" class="b3"><?=$kega?></TD></TR>
			<TR><TD class="b2"><B>Attack</B></TD>
				<TD class="b3"><?=$att?>+<?=$watt_2?></TD>
				<TD class="b2" width="70"><B>Stamina</B></TD>
				<TD class="b3" width="74"><?=$sta?> / <?=$pref['maxsta']?></TD>
				<TD colspan="4" class="b3"><?=$bar_sta?></TD></TR>
			<TR><TD class="b2"><B>Defense</B></TD>
				<TD class="b3"><?=$def?>+<?=$ball?></TD>
				<TD class="b2"><B>HP</B></TD>
				<TD class="b3"><?=$hit?> / <?=$mhit?></TD>
				<TD colspan="4" class="b3"><?=$bar_hit?></TD></TR>
			<TR><TD class="b2"><B>Weapon</B></TD>
				<TD colspan="3" class="b3"><?=$w_name?></TD>
				<TD colspan="2" class="b3"><?=$watt?></TD>
				<TD colspan="2" class="b3"><?=$wtai?></TD></TR>
			<TR><TD class="b2"><B>Armor</B></TD>
				<TD colspan="3" class="b3"><?=$b_name?></TD>
				<TD colspan="2" class="b3"><?=$bdef?></TD>
				<TD colspan="2" class="b3"><?=$btai?></TD></TR>
			<TR><TD class="b2"><B>Mode</B></TD>
				<TD class="b3"><?=$tactics?></TD>
				<TD class="b2"><B>Limit</B></TD>
				<TD class="b3"><?=$bar_lim?></TD>
				<TD class="b2"><B>숙련치</B></TD>
				<TD colspan="3" class="b3">구:<?=$wp?> Gun:<?=$wg?> 참:<?=$wn?> 투:<?=$wc?> 폭:<?=$wd?></TD></TR>
			<TR><TD class="b2"><B>In-Attack Mode</B></TD>
				<TD class="b3"><?=$ousen?></TD>
				<TD class="b2"><B>Club</B></TD>
				<TD class="b3" colspan="2"><?=$pref['clb'][$in['club']]?></TD>
				<!--TD class="b2"><B>위원회</B></TD>
				<TD class="b3">준비중<?=$comm?></TD-->
				<TD class="b2"><B>Money</B></TD>
				<TD class="b3" colspan="2"><?=number_format($money_disp)?> Yen</TD></TR>
			<TR><TD class="b3" colspan="8" height="1"><div align="center">
<TABLE border="0" cellspacing="0" cellpadding="0"><TR><TD>
<TABLE border="1" cellspacing="0" cellpadding="0">
  <TR><TD class="b1" colspan="4">Equipment</TD></TR>
  <TR><TD class="b2">Type</TD><TD class="b2">Name</TD><TD class="b2">Effect</TD><TD class="b2">Durability</TD></TR>
  <TR><TD class="b3">Head</TD><TD class="b3"><?=$b_name_h?></TD><TD class="b3"><?=$bdef_h?></TD><TD class="b3"><?=$btai_h?></TD></TR>
  <TR><TD class="b3">Arms</TD><TD class="b3"><?=$b_name_a?></TD><TD class="b3"><?=$bdef_a?></TD><TD class="b3"><?=$btai_a?></TD></TR>
  <TR><TD class="b3">Legs</TD><TD class="b3"><?=$b_name_f?></TD><TD class="b3"><?=$bdef_f?></TD><TD class="b3"><?=$btai_f?></TD></TR>
  <TR><TD class="b3">식</TD><TD class="b3"><?=$b_name_i?></TD><TD class="b3"><?=$eff[5]?></TD><TD class="b3"><?=$itai[5]?></TD></TR>
</TABLE>
  </TD><TD width="20"></TD><TD>
<TABLE border="1" cellspacing="0" cellpadding="0">
  <TR><TD class="b1" colspan="4">Items</TD></TR>
  <TR><TD class="b2">Name</TD><TD class="b2">Effect</TD><TD class="b2">Amount</TD><TD class="b2">Type</TD></TR>
<?
for($i=0;$i<5;$i++){
	$itemtype = '';
	@list($i_name,$i_kind) = explode('<>',$item[$i]);
	if(preg_match('/HH|HD/',$i_kind)){
		$itemtype = '【회복：체력】';
	}elseif(preg_match("/SH|SD/",$i_kind)){
		$itemtype = '【회복：스태미너】';
	}elseif($i_kind == 'TN'){
		$itemtype = '【함정】';
	}elseif(preg_match('/W/',$i_kind)){
		$itemtype = '【무기：';
		if(preg_match('/G/',$i_kind))	{
			$itemtype .= '총';
			if(preg_match('/S/',$i_kind))	{$itemtype .= '-소음';}
		}
		if(preg_match('/K/',$i_kind)){$itemtype .= '참';}
		if(preg_match('/C/',$i_kind)){$itemtype .= '투';}
		if(preg_match('/B/',$i_kind)){$itemtype .= '구';}
		if(preg_match('/D/',$i_kind)){$itemtype .= '폭';}
		$itemtype .= '】';
	}elseif(preg_match('/D/',$i_kind)){
		$itemtype = '【방어구：';
		if(preg_match('/B/',$i_kind)){$itemtype .= '몸';}
		if(preg_match('/H/',$i_kind)){$itemtype .= '머리';}
		if(preg_match('/F/',$i_kind)){$itemtype .= '다리';}
		if(preg_match('/A/',$i_kind)){$itemtype .= '팔';}
		if(preg_match('/K/',$i_kind)){$itemtype .= '-대：참';}
		$itemtype .= '】';
	}elseif($i_kind == 'R1' || $i_kind == 'R2'){
		$itemtype = '【레이더-】';
	}elseif($i_kind == 'Y'){
		if($i_name == '가짜 프로그램 해제 키' || $i_name == '프로그램 해제 키') {
			$itemtype = '【해제 키】';
		}elseif($i_name == '탄환'){
			$itemtype = '【총알】';
		}else {
			$itemtype = '【도구】';
		}
	}elseif($i_kind == 'A'){
		$itemtype = '【장식품】';
	}elseif($item[$i] == '없음'){
		$itemtype = '【없음】';
	}else{
		$itemtype = '【불명】';
	}
	if($pref['MOBILE']){
		if($item[$i]!='없음'){
			echo $i_name.'/'.$eff[$i].'/'.$itai[$i].'/'.$itemtype.'<br>';
		}
	}else{
		echo '<TR><TD class="b3">'.$i_name.'</TD><TD class="b3">'.$eff[$i].'</TD><TD class="b3">'.$itai[$i].'</TD><TD class="b3"><font color="00ffff">'.$itemtype.'</font></TD></TR>';
	}
}
?>
</TABLE>
</TD></TR></TABLE></div>
			</TD>
		  </TR>
	  </TABLE>
	  </TD>
	  <TD valign="top">
	  <TABLE border="1" width="200" height="100%" cellspacing="0" cellpadding="0">
		<TR height="1"><TD height="20" width="200" class="b1"><B>Commands</B></TD></TR>
		<TR>
		<TD align="left" valign="top" width="200" class="b3">
		<FORM METHOD="POST" name="BR" style="MARGIN: 0px;text-align: left;" action="BR.php">
		<INPUT TYPE="HIDDEN" NAME="mode" VALUE="command">
		<INPUT TYPE="HIDDEN" NAME="Id" VALUE="<?=$in['Id']?>">
		<INPUT TYPE="HIDDEN" NAME="Password" VALUE="<?=$in['Password']?>">
<?
		COMMAND();
?>
		</FORM>
		</TD>
		</TR>
	  </TABLE>
	  </TD>
	</TR>
<?
}
if($sts=='우승'){
}elseif($pref['MOBILE']){
	echo '<FORM METHOD="POST" name="BR" action="BR.php"><INPUT TYPE="HIDDEN" NAME="mode" VALUE="command"><INPUT TYPE="HIDDEN" NAME="Id" VALUE="'.$in['Id'].'"><INPUT TYPE="HIDDEN" NAME="Password" VALUE="'.$in['Password'].'">';
	COMMAND();
	if($log){
		echo '<br><br>로그<br>'.$log.'<br>';
	}
	echo '</FORM>';
}else{
?>
	<TR>
	  <TD valign="top">
		<TABLE border="1" width="550" height="201" cellspacing="0" cellpadding="0">
		  <TR height="1">
			<TD height="1" width="287" class="b1"><B>Record</B></TD>
			<TD height="1" width="257" class="b1"><B>Messages</B></TD></TR>
		  <TR>
			<TD valign="top" class="b3" style="text-align:left;"><?=$log?>&nbsp;</TD>
			<TD valign="top" class="b3" style="text-align:left;">
<?
		BR_MES();
?>
			</TD>
		  </TR>
		</TABLE>
	  </TD><TD valign="top" height="201">
		<TABLE border="1" cellspacing="0" width="200" height="100%" cellpadding="0">
		  <TR height="1"><TD height="1" class="b1"><B>Messenger</B></TD></TR>
		  <TR><TD valign="top" class="b3">
			<form method="POST" name="MSG" style="MARGIN: 0px" action="BR.php">
<?
if($MESSENGER != 1){echo '<INPUT type="hidden" name="Mess">';}else{
?>
			<INPUT size="36" type="text" name="Mess" maxlength="64" ><BR>
			<input type="hidden" name="mode" value="command">
			<input type="hidden" name="Command" value="MESS">
			<INPUT TYPE="HIDDEN" NAME="Id" VALUE="<?=$in['Id']?>">
			<INPUT TYPE="HIDDEN" NAME="Password" VALUE="<?=$in['Password']?>">
			<input type="submit" value="전언 발신/갱신"><input type="reset" value="리셋트"><BR>
<?
	if(!preg_match('/없음/',$teamID)){
		if(isset($in['M_Id']) && $in['M_Id'] != 'ALL'){$checked = '';}else{$checked = ' checked';}
		echo '대상：<A onclick="sl_msg(0);" href="javascript:void(0);"><INPUT type="radio" name="M_Id" value="ALL"'.$checked.'>전원</A>';
		if($checked == ''){$checked = ' checked';}else{$checked = '';}
		echo '<A onclick="sl_msg(1);" href="javascript:void(0);"><INPUT type="radio" name="M_Id" value="'.$teamID.'"'.$checked.'>그룹</A><BR>';
	}else{
		echo '<INPUT type="hidden" name="M_Id" value="ALL">';
	}
}
?>
			Players：<?=$m_mem?>People<BR>
			</TD></form>
		  </TR>
<?/*<!--		  <TR height="1"><TD height="1" width="200" class="b1"><B>메신저</B></TD></TR>
		  <TR><TD valign="top" class="b3">　</TD></TR>-->*/?>
		</TABLE>
		</TD>
	</TR>
</TABLE>
<?
}
}

?>