<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR COMMAND DISPLAY    - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ COMMAND			-	커멘드부	 	 ■
#□ BR_MES			-	BR메신저 □
#■ definition		-	정의부		 	 ■
#□■□■□■□■□■□■□■□■□■□■□

#===============#
# ■ 커멘드부 #
#===============#
function COMMAND(){
global $in,$pref;

global $id,$password,$f_name,$l_name,$sex,$cl,$no,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item,$eff,$itai,$com,$dmes,$bid,$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,$expires;
global $log,$jyulog,$jyulog2,$jyulog3,$hackflg,$ar,$kinlist,$MESSENGER;

$i= 0;
if(preg_match("/수면|치료|정양|우승/",$sts)){
	$MESSENGER = "1";
	if($sts == "치료"){
		if($in['Command'] == "HEAL"){$log =($log . "상처의 치료를 하자<BR>");}else{$log =($log . "치료중…<BR>");}
		$sts = "치료";print "치료중…<BR><BR>";
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"HEAL2\" checked>치료</A><BR><BR>";
	}elseif($sts == "수면"){
		if($in['Command'] == "INN"){$log =($log . "조금 자 둘까<BR>");}else{$log =($log . "수면중…<BR>");}
		$sts = "수면";print "수면중…<BR><BR>";
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"INN2\" checked>수면</A><BR><BR>";
	}elseif($sts == "정양"){
		if($in['Command'] == "INNHEAL"){$log =($log . "정양해 푹 쉬어 둘까<BR>");}else{$log =($log . "정양중…<BR>");}
		$sts = "정양";print "정양중…<BR><BR>";
		Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"INNHEAL2\" checked>정양</A><BR><BR>";
	}elseif($sts == "우승"){
		global $WINNUM,$win_ver;
		print "<center><BR>${WINNUM}우승자<BR>살해자수-${kill}<BR><BR><BR><INPUT type=\"submit\" name=\"Enter\" value=\"돌아온다\"></center>";
		$MESSENGER = "0";return;
	}
	Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\">돌아온다</A><BR><BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
	return;
}

if((($in['Command'] == '')||($in['Command'] == "MAIN"))||(($in['Command'] == "MOVE")&&($in['Command2'] == "MAIN"))||(($in['Command'] == "ITMAIN")&&($in['Command3'] == "MAIN"))||(($in['Command'] == "SPECIAL")&&($in['Command4'] == "MAIN"))||(($in['Command'] == "kaifuku")&&($in['Command5'] == "MAIN"))){  #MAIN
	$MESSENGER = 1;
	$log =($log .$jyulog.$jyulog2.$jyulog3.'자,그럼, 어떻게 하지….<br>');
	print '무엇을 실시합니까?<BR><BR>';
	#■ 이동 ■
	if((((preg_match("/다리/",$inf))&&($sta > 18))||((!preg_match("/다리/",$inf))&&(preg_match("/크로스 카운트 리부|축구부/",$pref['clb'][$in['club']]))&&($sta > 11))||((!preg_match("/다리/",$inf))&&($sta > 13)))){
		echo '<INPUT type="radio" name="Command" value="MOVE">';Auto();
		echo '<select name="Command2"><option value="MAIN" style="color:red">Go to...<BR>';
		$kin_ar = explode(',',$pref['arealist'][2]);#금지 에리어의 리스트를 배열에 넣습니다.
		$kinlist = array();
		for($i=0;$i<$ar;$i++){#현재의 금지 에리어의 수만큼 일람에 추가합니다.
			array_push($kinlist,$kin_ar[$i]);
		}
		for($j=0;$j<count($pref['place']);$j++){#금지 에리어 처리 부분＆현재 위치
			if(!in_array($pref['place'][$j],$kinlist)){
				if($pref['place'][$j] != $pref['place'][$pls]){
					echo '<option value="MV'.$j.'"';
					if($pref['place'][$j] == $kin_ar[$ar]){
						echo ' style="color:red;"';
					}elseif($pref['place'][$j] == $kin_ar[$ar+1]){
						echo ' style="color:yellow;"';
					}
					echo '>'.$pref['place'][$j].'('.$pref['area'][$j].')</option>';
				}elseif($pref['place'][$j] == $pref['place'][$pls]){
					echo '<option value="MAIN"><--현재 위치--></option>';
				}
			}elseif($hackflg || $sts=='NPC'){
				echo '<option value="MV'.$j.'" style="background-color:red;color:black;">'.$pref['place'][$j].'('.$pref['area'][$j].')</option>';
			}
		}
		echo '</select></A><BR>';
	}
	if($pref['place'][$pls] == '분교'){if(($hackflg)||($sts == 'NPC')){$ok = 1;}else{$ok = 0;}}
	else{$ok = 0;if((preg_match('/다리/',$inf))&&($sta > 25)){$ok = 1;}elseif((preg_match('/크로스 카운트 리부|축구부/',$pref['clb'][$in['club']]))&&($sta > 15)){$ok = 1;}elseif($sta > 20){$ok = 1;}}
	#■ 탐색 ■
	if($ok){
		Auto() ;print '<INPUT type="radio" name="Command" value="SEARCH"> Explore&nbsp;</A><BR>';
	}
	#■ 아이템 ■
	print '<INPUT type="radio" name="Command" value="ITMAIN">';Auto();
	print '<select name="Command3"><option value="MAIN" style="color:red">Inventory<BR><option value="ITEM">Use / Equip Items<BR><option value="SEIRI">Organize Items<BR><option value="GOUSEI">Mix Items<BR><option value="DEL">Throw Item<BR>';
	if($wep != '맨손<>WP')	{print '<option value="WEPDEL">장비 무기를 벗는다<BR>';
							 print '<option value="WEPDEL2">장비 무기 투기<BR>';}
	if($bou_h != "없음")	{print '<option value="BOUDELH">Unequip head armor<BR>';}
	if($bou != "속옷<>DN")	{print '<option value="BOUDELB">Unequip body armor<BR>';}
	if($bou_a != "없음")	{print '<option value="BOUDELA">Unequip arm armor<BR>';}
	if($bou_f != "없음")	{print '<option value="BOUDELF">Unequip leg armor<BR>';}
	if($item[5] != "없음")	{print '<option value="BOUDEL">장식품을 제외한다<BR>';}
	print '</select></A><BR><INPUT type="radio" name="Command" value="kaifuku">';Auto();
	#■ 회복 ■
	print '<select name="Command5"><option value="MAIN" style="color:red">Recovery<BR><option value="HEAL">　치료<BR><option value="INN">　수면<BR>';
	if(($pref['place'][$pls] == "진료소")||((preg_match('/수영부/',$pref['clb'][$in['club']]))&&(preg_match('/북쪽의 갑|남의미사키/',$pref['place'][$pls])))){print '<option value="INNHEAL">　정양<BR>';}
	print '</select></A><BR><INPUT type="radio" name="Command" value="SPECIAL">';Auto();
	#■ 특수 ■
	print '<select name="Command4"><option value="MAIN" style="color:red" selected>Special<BR>';
	if($pref['MOBILE']){
		print '<option value="MOB_STS">Status Details<BR>';
		print '<option value="MOB_A-I">Equipment/Inventory<BR>';
	}
	if(preg_match('/분교|폐교/',$pref['place'][$pls]) && !$pref['MOBILE']){print '<option value="BAITEN">　　매점<BR>';}
	print '<option value="KOUDOU">　Mode<BR>';
	print '<option value="OUSEN">　In-Attack Mode<BR>';
	print '<option value="WINCHG">　말버릇 변경<BR>';
	if($sta > 50){print '<option value="OUKYU">　First Aid<BR>';}
	if(!$pref['MOBILE']){print '<option value="TEAM">　Groups<BR>';}
	if(($pref['clb'][$in['club']] == "요리부")&&($sta > 30)){print '<option value="PSCHECK">　Examine for Poison<BR>';}
	for($poi=0;$poi<5;$poi++){if($item[$poi] == "독약<>Y"){print '<option value="POISON">　Mix Poison<BR>';break;}}
	for($spi=0;$spi<5;$spi++){if($item[$spi] == "휴대 스피커<>Y"){print '<option value="SPIICH">　Use Megaphone<BR>';break;}}
	for($paso=0;$paso<5;$paso++){if(($item[$paso] == "모바일 PC<>Y")&&($itai[$paso] >= 1)){print '<option value="HACK">　Hack<BR>';break;}}
	print '</select></A><BR><BR><INPUT type="submit" name="Enter" value="결정">';
}elseif($in['Command'] == "ITMAIN"){	#아이템
	require $pref['LIB_DIR']."/dsp_cmd_itm.php";
}elseif($in['Command'] == "SPECIAL"){	#특수
	require $pref['LIB_DIR']."/dsp_cmd_spc.php";
}elseif(preg_match("/BATTLE0/",$in['Command'])){	#전투 커멘드
	list($a,$wid) = explode("_", $in['Command']);
	$log =($log . "자,그럼, 어떻게 하지…") ;$chk = "checked";
	print "무엇을 합니까?<BR><BR>메세지<BR><INPUT size=\"30\" type=\"text\" name=\"Dengon\" maxlength=\"64\"><BR><BR>";
	list($w_name,$w_kind) = explode("<>", $wep);
	if((preg_match("/G/",$w_kind))&&($wtai > 0)){
		if(preg_match("/S/",$w_kind)){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WGS_$wid\" $chk>공격한다($wg)</A><BR>";$chk="";}
		else{Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WG_$wid\" $chk>공격한다($wg)</A><BR>";$chk="";}
	}
	if(preg_match("/K/",$w_kind)){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WK_$wid\" $chk>벤다　(참)($wn)</A><BR>";$chk='';}
	if(preg_match("/C/",$w_kind)){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WC_$wid\" $chk>던지는(투)($wc)</A><BR>";$chk='';}
	if(preg_match("/D/",$w_kind)){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WD_$wid\" $chk>던지는(폭)($wd)</A><BR>";$chk='';}
	if(preg_match("/P|B/",$w_kind)){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WB_$wid\" $chk>때린다　(구)($wp)</A><BR>";$chk='';}
	if((!preg_match("/K|C|D|P|B/",$w_kind))&&((preg_match("/G|A/",$w_kind))&&($wtai == 0))){Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WB_$wid\" $chk>때린다　($wp)</A><BR>";$chk='';}
	Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"RUNAWAY\">도망</A><BR><BR>";
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
}elseif($in['Command'] == "ITEMJOUTO"){	#아이템 양도
	global $w_cl,$w_no,$w_f_name,$w_l_name,$w_id;
	$log =($log . "아이템 양도 커멘드입니다.<BR>");
	print "{$w_cl}{$w_no}차례 {$w_f_name} {$w_l_name} 에<br>　　　　어느 아이템을 양도합니까?<INPUT type=\"hidden\" name=\"Command\" value=\"SEITO_".IDcrypt($w_id)."\"><BR><BR>";
Auto('','sl2') ;print "<INPUT type=\"radio\" name=\"Command2\" value=\"JO_MAIN\" checked>멈춘다</a><BR><BR>";
	for($i=0;$i<5;$i++){if($item[$i] != "없음"){list($itn, $ik) = explode("<>", $item[$i]) ;Auto('','sl2') ;print "<INPUT type=\"radio\" name=\"Command2\" value=\"JO_$i\">$itn/$eff[$i]/$itai[$i]</a><BR>";}}
	print "<BR>메세지<BR><INPUT size=\"30\" type=\"text\" name=\"Dengon\" maxlength=\"64\"><BR><BR>";

/*	print "<select name=\"Command2\"><option value=\"JO_MAIN\" selected>멈춘다</option>";
	for($i=0;$i<5;$i++){if($item[$i] != "없음"){list($itn, $ik) = explode("<>", $item[$i]) ;print "<option value=\"JO_$i\">$itn/$eff[$i]/$itai[$i]<BR></option>";}}
	print "</select><BR><BR>메세지<BR><INPUT size=\"30\" type=\"text\" name=\"Dengon\" maxlength=\"64\"><BR><BR>";*/
	print "<BR><INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
}elseif($in['Command'] == "DEATHGET" || $in['Command'] == "BATTLE2"){	#아이템 강탈(상대 살해시)
	global $w_id,$w_wep,$w_bou,$w_bou_h,$w_bou_f,$w_bou_a,$w_item,$w_money,$w_watt,$w_wtai,$w_bdef,$w_btai,$w_bdef_h,$w_btai_h,$w_bdef_f,$w_btai_f,$w_bdef_a,$w_btai_a,$w_eff,$w_itai;
	print "무엇을 빼앗습니까?<BR>";
Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR>";
	print "<INPUT TYPE=\"HIDDEN\" NAME=\"WId\" VALUE=\"".IDcrypt($w_id)."\">";
	if(!preg_match("/맨손/",$w_wep))	#무기 소지?
		{list($itn, $ik) = explode("<>",$w_wep) ;Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"GET_6\">$itn/$w_watt/$w_wtai</A><BR>";}
	if(!preg_match("/속옷/",$w_bou))	#방어구 소지?
		{list($itn, $ik) = explode("<>",$w_bou) ;Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"GET_7\">$itn/$w_bdef/$w_btai</A><BR>";}
	if(!preg_match("/없음/",$w_bou_h))	#방어구 소지?
		{list($itn, $ik) = explode("<>",$w_bou_h) ;Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"GET_8\">$itn/$w_bdef_h/$w_btai_h</A><BR>";}
	if(!preg_match("/없음/",$w_bou_f))	#방어구 소지?
		{list($itn, $ik) = explode("<>",$w_bou_f) ;Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"GET_9\">$itn/$w_bdef_f/$w_btai_f</A><BR>";}
	if(!preg_match("/없음/",$w_bou_a))	#방어구 소지?
		{list($itn, $ik) = explode("<>",$w_bou_a) ;Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"GET_10\">$itn/$w_bdef_a/$w_btai_a</A><BR>";}
	for($i=0;$i<6;$i++)	#아이템 소지?
		{if($w_item[$i] != "없음"){list($itn,$ik) = explode("<>",$w_item[$i]) ;Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"GET_$i\">$itn/$w_eff[$i]/$w_itai[$i]</A><BR>";}}
	if($w_money)			#현금 소지?
		{$w_money_disp =($w_money * $pref['money_base']) ;Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"GET_11\">$w_money_disp 엔</A><BR>";}
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
}elseif(preg_match("/BAITEN/",$in['Command'])){	#매점
	if(!preg_match("/BAITEN2/",$in['Command'])){
		require $pref['LIB_DIR']."/lib3.php";
	}
	BAITEN();
}elseif($in['Command'] == "USRSAVE"){							#유저 데이터 보존
	$u_dat= "$id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],,$com,$dmes,$bid,".$in['club'].",$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,".$in['IP'].",\n";
	#open(DB,">$pref['u_save_dir']$id$pref['u_save_file']") ;seek(DB,0,0) ;print DB $u_dat;close(DB);
	$log =($log . "세이브는 정상적으로 종료했습니다.<BR>");
Auto() ;print "<br><INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR><BR>";
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
}else{
	print "무엇을 실시합니까?<BR><BR>";
Auto() ;print "<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아온다</A><BR><BR>";
	print "<INPUT type=\"submit\" name=\"Enter\" value=\"결정\">";
}

}

#=====================#
# ■ BR메신저 #
#=====================#
function BR_MES(){
global $pref,$in;
global $id,$teamID,$m_mem,$full_name;

$mes_i = 0;
$userlist = @file($pref['user_file']) or ERROR('unable to open file user_file','','DSP_CMD',__FUNCTION__,__LINE__);
$messagelist = @file($pref['mes_file']);# or ERROR("unable to open file messagelist");
foreach($messagelist as $messagelisttemp){
	list($mes_time,$from_id,$w_f_name,$w_l_name,$to_id,$from_message) = explode(',',$messagelisttemp);
	$w_full_name=$w_f_name.' '.$w_l_name;
	list($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($mes_time);
	if($hour < 10){$hour = '0'.$hour;}
	if($min < 10){$min = '0'.$min;}
	$dsp_mes_time =$hour.'때'.$min.'분';

	if(strlen($from_message)>$pref['mes_break']){#문자 컷
		if(preg_match_all("/[a-zA-Z0-9]|\_|\,|\;|\<|\>|\(|\) |&|\/|\.|\~/",substr($from_message,0,$pref['mes_break']),$matches)){
			if(count($matches[0])>=27){
				$mes_break = 30;
			}else{
				$mes_break = $pref['mes_break']-(count($matches[0])*0.32);
			}
		}else{
			$mes_break = $pref['mes_break'];
		}
		if(function_exists('mb_strimwidth')){
			$from_message = '<a onmouseover="status=\''.$from_message.'\';return true;" onmouseout="status=\'\';return true;" href="javascript:void(0)" title="'.$from_message.'" style="text-decoration: none"><font color="white">'.mb_strimwidth($from_message,0,(int) $mes_break,'...','EUC-JP').'</font></a>';
		}else{
			$from_message = '<a onmouseover="status=\''.$from_message.'\';return true;" onmouseout="status=\'\';return true;" href="javascript:void(0)" title="'.$from_message.'" style="text-decoration: none"><font color="white">'.substr($from_message,0,(int) $mes_break).'...</font></a>';
		}
	}
	if($to_id == 'DEL'){#삭제
	}elseif($id == $from_id){#송신
?>			<form method="GET" name="MSG_DEL<?=$mes_time?>" style="MARGIN: 0px">
			<input type="hidden" name="mode" value="command">
			<input type="hidden" name="Command" value="MSG_DEL">
			<input type="hidden" name="Command2" value="<?=$mes_time?>">
			<INPUT TYPE="HIDDEN" NAME="Id" VALUE="<?=$in['Id']?>">
			<INPUT TYPE="HIDDEN" NAME="Password" VALUE="<?=$in['Password']?>">
<?		if($teamID == $to_id){#그룹내
			echo '☆'.$dsp_mes_time.'('.$to_id.')[<a href="#" onclick="document.MSG_DEL'.$mes_time.'.submit();return false;">삭제</a>]<BR><SPAN STYLE="background:'.$pref['col_from'].'">&nbsp;'.$from_message.'</SPAN><BR>';
		}else{
			echo '☆'.$dsp_mes_time.'(전원)[<a href="#" onclick="document.MSG_DEL'.$mes_time.'.submit();return false;">삭제</a>]<BR><SPAN STYLE="background:'.$pref['col_from'].'">&nbsp;'.$from_message.'</SPAN><BR>';
		}
		echo '</form>';
		$mes_i++;
		if($pref['mesmax'] <= $mes_i){break;}
	}elseif($teamID == $to_id){#수신
		echo '□'.$dsp_mes_time.'('.$w_full_name.')<BR><SPAN STYLE="background:'.$pref['col_to'].'">&nbsp;'.$from_message.'</SPAN><BR>';
		$mes_i++;
		if($pref['mesmax'] <= $mes_i){break;}
	}elseif($to_id == 'ALL'){#All
		echo '○'.$dsp_mes_time.'('.$w_full_name.')<BR><SPAN STYLE="background:'.$pref['col_all'].'">&nbsp;'.$from_message.'</SPAN><BR>';
		$mes_i++;
		if($pref['mesmax'] <= $mes_i){break;}
	}
}
if($mes_i==0) {echo '메세지는 없습니다<br>';}

$new_memberlist=array() ;$m_mem=0;$chk=1;
$memberlist=@file($pref['member_file']);

if($memberlist){
	foreach ($memberlist as $memberlisttemp) {
		list($get_time,$mem_id,$mem_name) = explode(',',$memberlisttemp);
		if($mem_id == $id) {#자신?
			array_unshift($new_memberlist,$pref['now'].",$mem_id,$full_name,\n") ;$m_mem++;$chk=0;
		}elseif($pref['now']-$pref['mem_time'] <= $get_time){#Player
			array_unshift($new_memberlist,"$get_time,$mem_id,$mem_name,\n") ;$m_mem++;
		}
	}
}
if($chk){array_unshift($new_memberlist,$pref['now'].",$id,$full_name,\n") ;$m_mem++;}#자신이 없었으면 Data 추가
$handle = @fopen($pref['member_file'], 'w') or ERROR('unable to open memberfile','','DSP_CMD',__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$new_memberlist))){ERROR('unable to memberfile','','DSP_CMD',__FUNCTION__,__LINE__);}
fclose($handle);

}
#===========#
# ■ 정의부 #
#===========#
function definition(){
global $in,$pref;

global $cln,$yellow,$red,$pink,$yellow,$gold,$blue,$green;
global $id,$password,$f_name,$l_name,$sex,$cl,$no,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item,$eff,$itai,$com,$dmes,$bid,$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,$expires;
global $up,$levuprem,$full_name,$condi,$CONDITION,$w_name,$w_kind,$b_name,$b_kind,$b_name_h,$b_kind_h,$b_name_f,$b_kind_f,$b_name_a,$b_kind_a,$b_name_i,$b_kind_i,$watt_2,$ball,$bar_exp,$bar_sta,$bar_hit,$bar_lim,$money_disp,$kega;
global $hour,$min,$week,$month,$year;
$up = round(($level*$pref['baseexp'])+(($level-1) *$pref['baseexp']));
$levuprem = $up-$exp;
#Name Def & class
$full_name =$f_name.' '.$l_name;$cln = $cl.' '.$sex.$no.'차례';
#부상 개소
$kega = '';$condi = '<BR><BR>Fine';
$head = $arm = $body = $foot = 0;
$condition = '';
if(($sta <= 50)||($hit <= 50)){$condition='C';$condi = '<BR><BR>주의';}
if(preg_match('/머리/',$inf)){$head = 1;$kega .= 'Head ';}
if(preg_match('/팔/',$inf)){$arm = 1;$kega .= 'Arms ';}
if(preg_match('/배/',$inf)){$body = 1;$kega .= 'Abdomen ';}
if(preg_match('/다리/',$inf)){$foot = 1;$kega .= 'Legs ';}
if($head || $arm || $body || $foot){$condi = '<BR><BR>Injury';$condition='C';}
if(preg_match('/독/',$inf)){$condi = '<BR><BR>Poison';$condition='P';}
if($kega == ''){$kega = 'None';}
if(($sta <= 25)&&($hit <= 50)){$condition='D';$condi = '<BR><BR>Warning';}

#Condition
if	 ($condition == 'C'){$CONDITION = '2';}
elseif($condition == 'D'){$CONDITION = '3';}
elseif($condition == 'P'){$CONDITION = '4';}
else{$CONDITION = '1';}

$CONDITION = '<script language="JavaScript">SWF_DSP("./'.$pref['imgurl'].'/bar.swf?color='.$CONDITION.'&head='.$head.'&arm='.$arm.'&body='.$body.'&foot='.$foot.'",200,70);</script>';

#get time
list($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($pref['now']);
if($hour < 10){$hour = '0'.$hour;}
if($min < 10){$min = '0'.$min;}
if($sec < 10){$sec = '0'.$sec;}
$month++;$year += 1900;
$wk = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
$week = $wk[$wday];
#장비 Def
@list($w_name,$w_kind) = explode('<>',$wep);
@list($b_name,$b_kind) = explode('<>',$bou);
@list($b_name_h,$b_kind_h) = explode('<>',$bou_h);
@list($b_name_f,$b_kind_f) = explode('<>', $bou_f);
@list($b_name_a,$b_kind_a) = explode('<>',$bou_a);
@list($b_name_i,$b_kind_i) = explode('<>', $item[5]);
if((preg_match("/G|A/",$w_kind))&&($wtai == 0)){$watt_2 = round($watt/10);}else{$watt_2 = $watt;}#곤봉 or 탄 없음총 or 화살 없음활
$ball = $bdef + $bdef_h + $bdef_a + $bdef_f;
if(preg_match("/AD/",$item[5])){$ball += $eff[5];}#장식이 방어구?
#Bar Def
//% 계산
$exp_bar1 = $exp / $up;
$sta_bar1 = round($sta / $pref['maxsta'] * 100);
$hit_bar1 = round($hit / $mhit * 100);

//폭 74
//경험지 78
if($exp_bar1 >= 1){$exp_bar1 = 78;}
elseif($exp_bar1 <= 0){$exp_bar1 = 0;}
else{$exp_bar1 = round(78 * $exp_bar1);}

if($sta_bar1 > 100){$sta_bar1 = 100;}
if($hit_bar1 > 100){$hit_bar1 = 100;}
if($hit_bar1 > 100){$hit_bar1 = 100;}
//리밋트 74
if($limit >= 100){$lim_bar1 = 74;}
elseif($limit <= 0){$lim_bar1 = 0;}
else{$lim_bar1 = round(74 * $limit / 100);}

$exp_bar2 = 78 - $exp_bar1;
$sta_bar2 = 99.9 - $sta_bar1;
$hit_bar2 = 99.9 - $hit_bar1;
$lim_bar2 = 74 - $lim_bar1;
$bar_exp1 = '<IMG src="'.$yellow.'" width="'.$exp_bar2.'" height="5" border="0" align="middle">';
$bar_sta1 = '<IMG src="'.$red.'" width="'.$sta_bar2.'%" height="10" border="0" align="middle">';
$bar_hit1 = '<IMG src="'.$pink.'" width="'.$hit_bar2.'%" height="10" border="0" align="middle">';
$bar_lim1 = '<IMG src="'.$yellow.'" width="'.$lim_bar2.'" height="10" border="0" align="middle">';
$bar_exp2 = '<IMG src="'.$gold.'" width="'.$exp_bar1.'" height="5" border="0" align="middle">';
$bar_sta2 = '<IMG src="'.$blue.'" width="'.$sta_bar1.'%" height="10" border="0" align="middle">';
$bar_hit2 = '<IMG src="'.$green.'" width="'.$hit_bar1.'%" height="10" border="0" align="middle">';
$bar_lim2 = '<IMG src="'.$gold.'" width="'.$lim_bar1.'" height="10" border="0" align="middle">';
//비율이 0이라면 역을 지운다
if($exp_bar2 <= 0){$bar_exp1 = '';}
if($sta_bar2 <= 0){$bar_sta1 = '';}
if($hit_bar1 <= 0){$bar_hit2 = '';}
if($lim_bar1 <= 0){$bar_lim2 = '';}
if($exp_bar1 <= 0){$bar_exp2 = '';}
if($sta_bar1 <= 0){$bar_sta2 = '';}
if($hit_bar2 <= 0){$bar_hit1 = '';}
if($lim_bar2 <= 0){$bar_lim1 = '';}
$bar_exp = $bar_exp2.$bar_exp1;$bar_sta = $bar_sta2.$bar_sta1;$bar_hit = $bar_hit2.$bar_hit1;$bar_lim = $bar_lim2.$bar_lim1;

if($money){$money_disp =($money * $pref['money_base']);}else{$money_disp = 0;}
}

?>