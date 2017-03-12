<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR ATTACK DISPLAY    - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ BATTLE			-		전투 결과 처리 ■
#□■□■□■□■□■□■□■□■□■□■□
#================#
# ■ 전투 결과 처리#
#================#
function BATTLE(){
global $in,$pref;

global $w_hit,$w_mhit,$w_wep,$pls,$pls,$teamID,$w_teamID,$teamPass,$w_teamPass,$icon,$icon_file;
global $f_name,$l_name,$w_f_name,$w_l_name,$bar_hit,$w_name;
global $kiri,$w_icon,$cl,$sex,$no,$w_cl,$w_sex,$w_no,$log;
#정의(LIB)
definition();
#적의 정의
$w_phit = $w_hit / $w_mhit;
$att_filter='';
if	  ($w_phit <= 0) {$w_phit = '<font color="red">Dead</font>';$att_filter=' style="filter:Xray();"';}
elseif($w_phit < 0.1){$w_phit = '<font color="red">Danger</font>';}
elseif($w_phit < 0.5){$w_phit = '<font color="yellow">Caution</font>';}
else				 {$w_phit = '<font color="#00FFFF">Normal</font>';}
list($w_w_name,$w_w_kind) = explode('<>',$w_wep);
if(preg_match('/☆/',$w_w_name)){$w_w_name = '<font color="yellow">Slightly Strong Weapon</font>';}
elseif(preg_match('/★|β|α/',$w_w_name)){$w_w_name = '<font color="lime">Strong Weapon</font>';}
elseif(preg_match('/■/',$w_w_name)){$w_w_name = '<font color="red">Strongest Weapon</font>';}
else{$w_w_name = '<font color="#00FFFF">Normal Weapon</font>';}


if($pref['MOBILE']){
?>
<big><font color="red"><b><?=$pref['place'][$pls]?> (<?=$pref['area'][$pls]?>)</b></font></big><br>
<font color="red"><?
if($teamID != '없음' && $teamID == $w_teamID && $teamPass == $w_teamPass){echo '양도';}
else{echo '전투 발생';}
global $hit,$mhit;
?></font><br>
<br>
이름：<?=$f_name?> <?=$l_name?><br>
상태：<?=$condi?><br>
체력：<?=$hit?>/<?=$mhit?><br>
무기：<?=$w_name?><br>
<br>
<big><font color="red">VS</font></big><br>
<br>
이름：<?=$w_f_name?> <?=$w_l_name?><br>
체력：<?=$w_phit?><br>
무기：<?=$w_w_name?><br>
<br>
<?
	print '<FORM METHOD="POST" name="BR" action="BR.php"><INPUT TYPE="HIDDEN" NAME="mode" VALUE="command"><INPUT TYPE="HIDDEN" NAME="Id" VALUE="'.$in['Id'].'"><INPUT TYPE="HIDDEN" NAME="Password" VALUE="'.$in['Password'].'">';
	COMMAND();
	if($log){
		print '<br><br>Record<br>'.preg_replace('/　/','',$log).'<br>';
	}
	print '</FORM>';
}else{


?>
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold);font-weight:700;text-decoration:underline"><?=$pref['place'][$pls]?> (<?=$pref['area'][$pls]?>)</span></font></center>
<TABLE align="center">
	<TR>
		<TD colspan="2"><B><FONT color="#ff0000"><?=$pref['links']?></FONT></B></TD>
	</TR>
	<TR>
		<TD valign="top">
			<TABLE border="1" width="550" height="292" cellspacing="0" cellpadding="0">
				<TR align="center">
					<TD valign="top" class="b3">
						<TABLE border="0">
							<TR align="center">
								<TD colspan="3"><B><FONT color="#ff0000" size="5" face="MS 내일 아침">
<?
if($teamID != '없음' && $teamID == $w_teamID && $teamPass == $w_teamPass){echo '양도';}
else{echo '전투 발생';}
?>
								</FONT></B></TD>
							<TR>
							<TR align="center">
								<TD width="100"><IMG src="<?=$pref['imgurl']?>/<?=$icon_file[$icon]?>" width="70" height="70" border="0" align="middle"></TD>
								<TD></TD>
								<TD width="100"><IMG src="<?
if($kiri){
	print $pref['imgurl'].'/question.gif';
}else{
	print $pref['imgurl'].'/'.$icon_file[$w_icon];
}
?>" width="70" height="70" border="0" align="middle"<?=$att_filter?>></TD>
							</TR>
							<TR align="center">
								<TD><?=$cl?>(<?=$sex.$no?>차례)</TD>
								<TD width="50" align="center">
<?
if($teamID == '없음' || $teamID == '출석 번호'){echo 'VS';}
?>
								</TD>
								<TD><?=$w_cl?>(<?=$w_sex.$w_no?>차례)</TD>
							</TR>
							<TR align="center"><TD><?=$f_name?> <?=$l_name?></TD><TD><B>Name</B></TD><TD><?=$w_f_name?> <?=$w_l_name?></TD></TR>
							<TR align="center"><TD><?=$bar_hit?></TD><TD><B>HP</B></TD><TD><?=$w_phit?></TD></TR>
							<TR align="center"><TD><?=$w_name?></TD><TD><B>Weapon</B></TD><TD><?=$w_w_name?></TD></TR>
						</TABLE>
					</TD>
				</TR>
			</TABLE>
		</TD>
		<TD valign="top" width="200">
			<TABLE border="1" width="200" height="293" cellspacing="0" cellpadding="0">
				<TR height="1"><TD height="20" width="200" class="b1"><B>커멘드</B></TD></TR>
				<TR>
					<TD align="left" valign="top" width="200" class="b3">
						<FORM METHOD="POST" name="BR" style="MARGIN: 0px">
						<INPUT TYPE="HIDDEN" NAME="mode" VALUE="command">
						<INPUT TYPE="HIDDEN" NAME="Id" VALUE="<?=$in['Id']?>">
						<INPUT TYPE="HIDDEN" NAME="Password" VALUE="<?=$in['Password']?>">
						<p style="text-align: left">
<?
			COMMAND();
?>
						</p>
						</FORM>
					</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
	<TR>
		<TD valign="top">
			<TABLE border="1" width="550" height="201" cellspacing="0" cellpadding="0">
				<TR height="1">
					<TD height="1" width="287" class="b1"><B>Record</B></TD>
					<TD height="1" width="257" class="b1"><B>Messages</B></TD>
				</TR>
				<TR>
					<TD valign="top" class="b3"><p style="text-align: left"><?=$log?>&nbsp;</p></TD>
					<TD valign="top" class="b3"><p style="text-align: left">
<?
			BR_MES();
?>
					</TD>
				</TR>
			</TABLE>
		</TD>
		<TD valign="top" height="201">
			<TABLE border="1" cellspacing="0" width="200" height="201" cellpadding="0">
				<TR height="1"><TD height="1" class="b1"><B>Messenger</B></TD></TR>
				<TR>
					<TD valign="top" class="b3">　</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
</TABLE>
<?
}

$mflg='ON';#스테이터스비표시
}
?>