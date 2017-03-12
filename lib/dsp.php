<?php
#□■□■□■□■□■□■□■□■□■□■□■□■□■□
#■ 		   -  Winner & Rader Display  -   		 ■
#□ 												 □
#■ 				써브루틴 일람				 ■
#□ 												 □
#■ ENDING		-	우승 처리						 ■
#□ END_FOOT	-	엔딩 화면 footer			 □
#■ ENDING2		-	통상 엔딩				 ■
#□ EX_ENDING	-	프로그램 해제 엔딩		 □
#■ EX_ENDING2	-	해제 키 사용자 전용 엔딩	 ■
#□ READER		-	레이더-표시부					 □
#■□■□■□■□■□■□■□■□■□■□■□■□■□■
#=============#
# ■ 우승 처리 #
#=============#
function ENDING(){
global $pref;

global $inf,$mem;
$fl = @file($pref['end_flag_file']) or ERROR("unable to open file end_flag_file","","DSP",__FUNCTION__,__LINE__);

if		(preg_match("/승/",$inf))					{ENDING2();}	#우승자
elseif	(preg_match("/해/",$inf))					{EX_ENDING2();}	#해제자
elseif	(preg_match("/해제/",$fl[0]))					{EX_ENDING();}	#해제시
elseif	(($mem == 1)&&(preg_match("/종료/",$fl[0])))	{ENDING2();}	#우승자
else{ERROR("부정 액세스입니다","no hit","DSP",__FUNCTION__,__LINE__);}

}
#===========================#
# ■ 엔딩 화면 footer #
#===========================#
function END_FOOT(){
?>
<CENTER>
<p>
<U><B>CGI-PHP판 제작 총지휘</B></U>
</p><p>
2Y -Yuta Yamashita-(<a href="http://www.b-r-u.net/">B-R-U.NET</A>)
</p><p>
<U><B>CGI-PERL판 제작 총지휘</B></U>
</p><p>
원작자 :tanatos
</p><p>
Special Thanks
</p><p>
카미야 에이와씨(<a href="http://www.geocities.co.jp/Bookend/5696/index.html">읽기 전의 바트로와</a>)
</p><p>
미노와씨(<a href="http://www01.u-page.so-net.ne.jp/zb3/t-c/TC.html">마음의 문</a>)
</p><p>
해파리＆씨(<a href="http://homepage1.nifty.com/kurage-ya/">해파리가게</a>)
</p><p>
</p>
<p><A href="index.php"><B><FONT color="#ff0000" size="+2">메인으로 돌아온다</FONT></B></A></P>
</CENTER>
<?
FOOTER();
UNLOCK();
exit;
}

#=====================#
# ■ 통상 엔딩 #
#=====================#
function ENDING2(){
global $sex,$no,$f_name,$l_name;
HEAD();

?>
<font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">우승자 결정</span></font>
<p>
	돌연 싸이 렌이 울어, 그리고 국가가 흘렀다.<BR>
	그리고, (들)물어 될 수 있던 목소리가 들려 왔다.
</p><p>
「찬미해와-.너가 우승 입니다.선생님, 정말로 네가 우승해 기뻐.<BR>
지금부터 맞이하러 가기 때문에 기다려라―」
</p><p>
지금, 눈앞에서 숨을 거둔 인간이 마지막 한 명이었는가?<BR>
-로 한 머릿속에서 신담임의 방송을 (듣)묻고 있었다.<BR>
정말로 그런가?<BR>
혹시 아직 생존이 있고, 지금의 방송은 신담임의 책략 아닌 것인지?<BR>
확실히, 이 프로그램은 정부의 요인의 토토카르쵸의 대상이 되어 있는 것 같고.<BR>
그러나, 이 방송을 (들)물어 프튼과 긴장의 실이 끊어졌다.<BR>
의식이 몽롱해져 온다...<BR>
확실히, 여기 몇일 전혀 자지 않았다...<BR>
…<BR>
…<BR>
…<BR>
눈앞에는 목만의 친구가 있었다.<BR>
「너는 역시 의지였던 거예요, 사람을 살인 싶었다?」<BR>
뒤에서는 몸반이 없는 급우가 있었다.<BR>
「믿자고, 모두 살아 남자고 한 것은 당신이 아니다!」<BR>
오른손의 어둠중에서 소리가 났다.<BR>
「배반자!」
</p><p>
있어도 끊고 있을 수 없게 되어, 간신히 소리를 냈다.<BR>
「의지가 아니었고, 모두 친구다!　하지만,이지만…살고 싶었다」<BR>
…<BR>
…<BR>
…<BR>
몸의 흔들림을 느껴 깨어났다.<BR>
오른손을 보면 전제군의 병사가 있었다.호송차안에 있는 것 같다.<BR>
무릎 위에는 색종이가 놓여져 있었다.<BR>
지렁이가 붙인 것 같은 글자로 「우승, 축하합니다!By 공화국 총통」이라고 써 있었다.
</p><p>
갑자기, 눈부심으로 일순간눈이 안보이게 되었다.<BR>
보도의 아나운서가 호송차의 주위에서 셔터를 누르고 있다.<BR>
호송차에 달려 오는 사람이 있었다.손에는 마이크를 가지고 있다.<BR>
「……의 제……회…로………무는,………………이………………로….인……를…이라고 보았다…와 생각….<BR>
우선,…승 해……구상은?」
</p><p>
무엇인가 알아 들을 수 없지만 이쪽에 인터뷰를 하고 있는 것 같다.<BR>
그런가, 이 게임에 우승했다.오늘의 밤에라도 뉴스로 흐르겠지.<BR>
다음의 플래시를 모여들 수 있었던 순간.왜일까 엄지를 쑥 내밀고 있던 자신이 있었다.<BR>
그리고, 덧붙였다.
</p><p>
<font color="red">「<?=$sex.$no?>차례 <?=$f_name.$l_name?>」</font>
</p><p>
이름을 말하면서, 엄지를 꽂으면서, 이렇게 생각하고 있는 자신이 있었다.<BR>
「모두의 분까지 산다.절대…절대…」<BR>
게다가…웃는 얼굴로.<BR>
그것을 자신이 생기는 클래스 메이트에 대한 답례라고 느꼈기 때문에.<BR>
어딘지 모르게.<BR>
구석에서 보면 죄어 들고 있는 웃는 얼굴일지도 모르지만.
</p><p>
그리고, 제일 마지막 클래스 메이트를 말한 후에,<BR>
좌이의 그롬하트의 피아스를 잡아 물러갔다.<BR>
「통」<BR>
무심결에 소리가 났다.<BR>
그리고, 좌이에서는 피가 흘러 떨어졌다.
</p><p>
　「모두와 여기에 함께 남아」
</p><p>
그렇게심에 중얼거린 다음의 순간,<BR>
외곬의 피와<BR>
외곬의 눈물과<BR>
피아스는 하늘을 춤추고 있었다.<BR>
…<BR>
…<BR>
…<BR>
…<BR>
…<BR>
그 날의 저녁, 신쥬쿠의 와르타전의 광장에는 여느 때처럼 사람이 모여 있었다.<BR>
목적이 없게 짬을 주체 못한 사람들.<BR>
휴대 전화에 열심히 이야기하기 시작하고 있는 사람들.<BR>
실제, 클로즈업의 와르타비젼을 보고 있는 것은 적었다.
</p><p>
「요전날이 행해지고 있던 프로그램의 우승자가 정해졌습니다!<BR>
그럼, 현장으로부터의 중계입니다」<BR>
중계처로부터의 영상에는, 우승자의 영상이 있었다.
</p><p>
「이번 우승자는 이 녀석인가.소라고나가.　!, 살인자째」<BR>
휴대 전화로 열심히 메일을 쓰고 있던 젊은이가 얼굴을 올려 말했다.<BR>
목을 드는에 따라, 좌이의 은빛의 피아스가 흔들렸다.<BR>
그에게는 우승자의 피눈물같은 건 보이지는 않았다.<BR>
물론, 작게 흥얼거리고 있던 클래스 메이트의 이름도 들리지 않았다.
</p><p>
그러나, 그의 관심은 다른 면에 곧 향했다.<BR>
「!좋은 여자!」<BR>
바닥에 야무지지 못하게 앉아 있던 그는, 무거운 움직임으로 허리를 들어<BR>
한명의 여성에게 달려 와 갔다.
</p><p>
</p><p>
　하나의 그롬하트의 피아스는 네온을 찍어,<BR>
　또 하나의 그롬하트의 피아스는…
</p><p>
</p><p>
<DIV align="right">
Now,"1 student remaining".<BR>
Surely 1 is lonly.<BR>
But there is hope there.
</DIV>
</p><p>
<HR>
</p>
<?
END_FOOT();

}

#===============================#
# ■ 프로그램 해제 엔딩 #
#===============================#
function EX_ENDING(){

HEAD();

?>
<font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">프로그램 긴급정지</span></font>
<p>
갑자기 싸이 렌의 소리가 귀를 관철했다.<br>
우승자가 정해졌는지…?아니, 확실히 아직 살아 남은 클래스메이트가 있을 것인데….<br>
그렇게 생각하고 있으면, 잘 귀에 익은 클래스메이트의 소리가 근처에 울려 건넜다.<br>
「프로그램은 끝났다!더이상 싸우지 않아도 괜찮다!」
</p><p>
믿을 수 없었다.<br>
이 악마의 프로그램으로부터 빠져 나갈 수 있었다라고.그렇지만, 자신들은 지금부터 어떻게 하면 좋겠지?<br>
클래스메이트와 함께 정부로 향해?<br>
그렇지 않으면 뿔뿔이 흩어지게 도망치고, 각각 힘을 길러?<br>
어쨌든 아무것도 생각하지 않고 집으로 돌아와?<br>
생각하고 있을 틈은 없었다.금지 에리어의 해제는 오늘 밤의 것0:00으로 원래대로 돌아가 버린다.<br>
게다가, 우물쭈물하고 있으면 프로그램 실행 본부의 병사들이, 자신들을 처형하러 올 것이다.<br>
「………」<br>
우선은 자신들을 여기에 계속 연결시키고 있던 목걸이를 벗었다.<br>
무기를 치우고, 크게 심호흡 해……
</p><p>
어쨌든 여기에서 도망가자.<br>
앞으로의 일은 그 후고네라고도 늦지 않다.<br>
자신들은 「희망」이다.이 악마의 게임, 세기의 악법으로 향하는 「희망」<br>
절망중에서 태어난 희망일지도 모르지만…갈 수 있는 곳까지 가고 준다!<br>
넘어질 때까지 계속 달려 준다……!
</p><p>
「프로그램의 긴급정지 후, 회장에서 도망간 소년들은 여전히……」<br>
……가두의 오로라 비전에 비치는 임시 뉴스를, 한 명의 소년이 바라보고 있었다.<br>
입술을 깨물어 닫고 주먹을 잡아, 진지한 표정으로.<br>
「달린다…!갈 수 있는 곳(중)까지 가고 준다!」<br>
다음에 흐른 뉴스를 무시하고, 소년은 인파에 거역해 헤엄치도록(듯이) 달리기 시작했다.
</p><p>
</p><HR><p>
<?

END_FOOT();
}

#===================================#
# ■ 해제 키 사용자 전용 엔딩 #
#===================================#
function EX_ENDING2(){
HEAD();
?>
<font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">프로그램 긴급정지</span></font>

<CENTER>
<p>
「후~…후~……」<br>
눈앞에는 자신들을 프로그램에 내보낸 남…판지금발의 시체가 널려 있었다.<br>
이 녀석이…이 녀석 태워 있어로 자신들은 프로그램에 밀려 나왔다.<br>
거기에 자신들의 의사는 없고, 꽉 눌릴 만한 부조리인 폭력으로.<br>
옷을 찾으면, 전자 키와 같은 물건이 손에 닿았다.<br>
이것을 사용하면…자신도, 살아 남은 모두도 이런 게임으로부터 해방된다….<br>
「………」<br>
하지만, 미혹이 나왔다.<br>
이것으로 정말로 좋은 것인지?정부로부터 도망가는지?<br>
아니…그런 일은 나중에 생각하면 된다.<br>
어쨌든, 클래스메이트와 서로 죽이는 바보스러운 상태로부터 개방된다면….
</p><p>
키를 통하면 게임 종료의 전자음이 울어, 목걸이가 카튼과 높은 소리를 내 마루에 떨어졌다.<br>
그리고, 지금까지 몇 사람이나의 클래스메이트의 사망 보고를 고하고 있었다고 생각되는 마이크를 손에 들어, 심호흡 한다.<br>
「프로그램은 끝났다!더이상 싸우지 않아도 괜찮다!」
</p><p>
자신이 할 수 있는 것은 했다.<br>
다음은 살아 남은 모두가 각각 생각하면 되는 일.<br>
이런 곳에서 우물쭈물하고 있을 틈은 없다.<br>
지금부터 프로그램보다 어려운 현실이 자신들을 기다리고 있을 것이니까….<br>
앞으로의 일은 스스로 결정할 수 밖에 없는 것이다….
</p><p>
「프로그램의 긴급정지 용의자의 학생은 여전히……」<br>
……가두의 오로라 비전에 비치는 임시 뉴스를, 한 명의 소년이 바라보고 있었다.<br>
입가에 미소를 띄워 포켓에 손을 돌입한 채로의 겁없는 표정으로.<br>
「힘내라…아무도 도우면 주지 않기 때문에…」<br>
다음에 흐른 뉴스를 무시하고, 소년은 사람 무디어져 익으면서 도망치도록(듯이) 떠나 갔다.
</p><p>
</p><HR><p>
<?
END_FOOT();
}
#===================#
# ■ 레이더-표시부 #
#===================#
function READER(){
global $in,$pref;
global $item,$wk,$pls,$log;

if(!preg_match("/R/",$item[$wk])){ERROR("부정한 액세스입니다.","","DSP",__FUNCTION__,__LINE__);}

$userlist = @file($pref['user_file']) or ERROR("unable to open file user_file","","DSP",__FUNCTION__,__LINE__);
$pref['arealist'] = @file($pref['area_file']) or ERROR("unable to open file area_file","","DSP",__FUNCTION__,__LINE__);

list($ar,$hackflg,$a) = explode(",",$pref['arealist'][1]);
$ara = explode(",",$pref['arealist'][4]);

$mem = array();
for ($i=0;$i<count($userlist);$i++){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$i]);
	for ($j=0;$j<count($pref['area']);$j++){
		if(($w_pls == $j)&&($w_hit > 0)){
			if(!isset($mem[$j])){$mem[$j] = 1;}
			else{$mem[$j] += 1;}
		}
	}
}

if(preg_match("/<>R2/",$item[$wk])){
	for ($j=0;$j<count($pref['area']);$j++){
		if($j == $pls){$mem[$j] = "<FONT color=\"#ff0000\"><b>" . $mem[$j] . "<b></FONT>";}
		elseif(!isset($mem[$j])){$mem[$j] = "0";}
	}
}else{
	for($j=0;$j<count($pref['area']);$j++){
		if($j == $pls){$wk = $mem[$j];$mem[$j] = "<FONT color=\"#ff0000\"><b>$wk<b></FONT>";}
		else{$mem[$j] = "　";}
	}
}

if($hackflg == 0){for ($j=0;$j<$ar;$j++){$mem[$ara[$j]] = "<FONT color=\"#ff0000\"><b>×<b></FONT>";}}


print <<<_HERE_
<!--/TD></TR><TR><TD height="20%"-->
	<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold);font-weight:700;text-decoration:underline">{$pref['place'][$pls]} ({$pref['area'][$pls]})</span></font></center>
<!--/TD></TR><TR><TD height="0%"-->
<TABLE align="center">
 <TR><TD colspan="2"><B><FONT color="#ff0000">{$pref['links']}</FONT></B></TD></TR>
 <TR>
	<TD valign="top">
	  <TABLE border="1" width="550" height="293" cellspacing="0" cellpadding="0">
		<TR><TD class="b1">　</TD>
			<TD class="b1">01</TD>
			<TD class="b1">02</TD>
			<TD class="b1">03</TD>
			<TD class="b1">04</TD>
			<TD class="b1">05</TD>
			<TD class="b1">06</TD>
			<TD class="b1">07</TD>
			<TD class="b1">08</TD>
			<TD class="b1">09</TD>
			<TD class="b1">10</TD></TR>
		<TR><TD class="b1">A</TD>
			<TD class="b2">　</TD>
			<TD class="b3">$mem[1]</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD></TR>
		<TR><TD class="b1">B</TD>
			<TD class="b2">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[2]</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD></TR>
		<TR><TD class="b1">C</TD>
			<TD class="b2">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[3]</TD>
			<TD class="b3">$mem[4]</TD>
			<TD class="b3">$mem[5]</TD>
			<TD class="b3">$mem[6]</TD>
			<TD class="b3">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD></TR>
		<TR><TD class="b1">D</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[7]</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[0]</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD></TR>
		<TR><TD class="b1">E</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[8]</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[9]</TD>
			<TD class="b3">$mem[10]</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[11]</TD>
			<TD class="b3">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD></TR>
		<TR><TD class="b1">F</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[12]</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[13]</TD>
			<TD class="b2">　</TD></TR>
		<TR><TD class="b1">G</TD>
			<TD class="b2">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[14]</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[15]</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b2">　</TD></TR>
		<TR><TD class="b1">H</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[16]</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[17]</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b2">　</TD></TR>
		<TR><TD class="b1">I</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[18]</TD>
			<TD class="b3">$mem[19]</TD>
			<TD class="b2">　</TD>
			<TD class="b3">　</TD>
			<TD class="b3">$mem[20]</TD></TR>
		<TR><TD class="b1">J</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b3">$mem[21]</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD>
			<TD class="b2">　</TD></TR>
	  </TABLE>
	  </TD>
	  <TD valign="top">
	  <TABLE border="1" width="200" height="293" cellspacing="0" cellpadding="0">
		<TR height="1"><TD height="20" width="200" class="b1"><B>커멘드</B></TD></TR>
		<TR>
		<TD align="left" valign="top" width="200" class="b3">
		<FORM METHOD="POST" name="BR" style="MARGIN: 0px">
		<INPUT TYPE="HIDDEN" NAME="mode" VALUE="command">
		<INPUT TYPE="HIDDEN" NAME="Id" VALUE="$in[Id]">
		<INPUT TYPE="HIDDEN" NAME="Password" VALUE="$in[Password]">
		<p style="text-align: left">
_HERE_;
require $pref['LIB_DIR']."/dsp_cmd.php";
		COMMAND();
print <<<_HERE_
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
			<TD height="1" width="287" class="b1"><B>로그</B></TD>
			<TD height="1" width="257" class="b1"><B>메세지</B></TD></TR>
		  <TR>
			<TD valign="top" class="b3"><p style="text-align: left">레이더-를 사용했다.<BR><BR>숫자：에리어에 있는 인원수<BR>빨강 숫자：자신이 있는 에리어의 인원수<br>{$log}</p></TD>
			<TD valign="top" class="b3"><p style="text-align: left">
_HERE_;
		BR_MES();
print <<<_HERE_
			</p>
			</TD>
		  </TR>
		</TABLE>
	  </TD><TD valign="top" height="201">
		<TABLE border="1" cellspacing="0" width="200" height="201" cellpadding="0">
		  <TR height="1"><TD height="1" class="b1"><B>메신저</B></TD></TR>
		  <TR>
		  	<TD valign="top" class="b3">　</TD>
		  </TR>
		</TABLE>
</TD></TR></TABLE>
_HERE_;
$mflg="ON";#스테이터스비표시

}
?>