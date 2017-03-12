<?php
$HEADERINDEX=true;
require 'pref.php';

$pref['arealist'][6] = trim($pref['arealist'][6]," \n");
#이동자＆생존자
$ok = 0;$idou = 0;$no = 0;

$userlist = file($pref['user_file']);
foreach ($userlist as $userlist) {
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",", $userlist);
	if (($w_hit > 0) && (!preg_match("/NPC/",$w_sts))) {$ok++;}
	if (($w_sts == "Normal")&&($w_hit > 0)){$idou++;}
	if ($w_hit <= 0){$no++;}
}
HEAD();
list($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($pref['now']);
if($hour < 10){$hour = "0$hour";}
if($min < 10){$min = "0$min";}
$month++;$year += 1900;
$weekday_array=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
$week = $weekday_array[$wday];

list($pre_reg,$res_y,$res_m,$res_d,$res_j,$res_f,$res_b) = explode(',',trim($pref['arealist'][7]));

$start_yea_rem = $res_y - $year;
$start_mon_rem = $res_m - $month;
$start_day_rem = $res_d - $mday;
$start_hour_rem = $res_j - $hour;
$start_min_rem = $res_f - $min;
$start_sec_rem = $res_b - $sec;

if($pref['MOBILE']){
?>
<font color="yellow"><B>Contace</B></font>：<?=$pref['contact'][1]?><br>
<font color="yellow"><B>Current Time</B></font>：<?=$week?><?=$month?> <?=$mday?>  <?=$hour?>:<?=$min?><br>
<font color="yellow"><B>Information</B></font>：<B><U>제<?=$pref['arealist'][6]?>회개최중</U></B><br>
<font color="yellow"><B>Notice</B></font>：<?=$pref['information']?><br><BR>
<?
	if(mktime(date('G'),date('i'),0,date('m'),date('d'),date('Y')) <= mktime($res_j,$res_f,0,$res_m,$res_d,$res_y)){
		if($start_min_rem<0){
			$start_hour_rem--;
			$start_min_rem+=60;
		}
		if($start_hour_rem<0){
			$start_day_rem--;
			$start_hour_rem+=24;
		}
		if($start_min_rem<10){
			$start_min_rem='0'.$start_min_rem;
		}
		if($start_hour_rem<10){
			$start_hour_rem='0'.$start_hour_rem;
		}
		if($start_day_rem>0){
			$start_day_rem.='Days';
		}else{
			$start_day_rem='';
		}
		if($start_min_rem>0){
			$start_min_rem.='Minutes';
		}else{
			$start_min_rem='';
		}
		if($start_hour_rem>0){
			$start_hour_rem.='Hours';
		}else{
			$start_hour_rem='';
		}
		
?>
To next game,<?=$start_day_rem?><?=$start_hour_rem?><?=$start_min_rem?><br><br>
<?
	}

?>
<font color="lime">【Survivors：<?=$ok?> People】<br>【Currently Active：<?=$idou?> People】<br>【Dead：<?=$no?> People】</font>
<BR><BR>
<FORM METHOD="POST" ACTION="BR.php">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="main">
<INPUT TYPE="HIDDEN" NAME="IPAdd" VALUE="<?=$host?>">
<FONT color="#ff0000"><B>Sign In!</B></FONT><br>
ID:<br>
<INPUT type="text" size="10" name="Id" maxlength="10"><br>
Password:<br>
<INPUT type="password" size="10" name="Password" maxlength="10"><br>
<INPUT type="submit" name="Enter" value="Sign In!">
</FORM>
<a title="Guide" href="rule.php">Guide</a><BR>
<a title="Register" href="regist.php">Register</a><BR>
<a title="Survivors" href="rank.php">Survivors</a><BR>
<a title="Map" href="map.php">Map</a><BR>
<a title="Current Progress" href="news.php">Current Progress</a><BR>
<a title="Admin" href="admin.php">Admin</a><BR>
<a title="Message Board" href="../patio/">Message board</a><BR>
<a title="Winners" href="winner.php">Winners</a><BR>
<BR>
<a title="Homepage" href="../../">【HOME】</a><BR>
<?

}else{
?>
<?=$pref['counter']?>
<font color="#FF0000" face="MS PTomorrow Morning" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">BATTLE ROYALE ULTIMATE EN</span></font><br>
<table border="0" align="center">
<tr><td><font color="yellow"><B>Contact</B></font></td><td>：</td><td><?=$pref['contact'][0]?></td></tr>
<tr><td><font color="yellow"><B>Current time</B></font></td><td>：</td><td><?=$week?>, <?=$month?>/ <?=$mday?>  <?=$hour?>:<?=$min?></td></tr>
<tr><td><font color="yellow"><B>Current Progress</B></font></td><td>：</td><td><font size="+1" color="red"><B><U>Game<?=$pref['arealist'][6]?>is Currently in progress</U></B></font><br></td></tr>
<tr><td><font color="yellow"><B>Notice</B></font></td><td>：</td><td><?=$pref['information']?></td></tr>
</table>
<?
	if(mktime(date('G'),date('i'),0,date('m'),date('d'),date('Y')) <= mktime($res_j,$res_f,0,$res_m,$res_d,$res_y)){
?>
<div id='time'>&nbsp;</div>
<SCRIPT language=JavaScript>
<!--
var timerId;var x = 0;
function secCountDown(){
	timerId = setTimeout("secCountDown()",1000)
	t=<?=$start_mon_rem?>;
	d=<?=$start_day_rem?>;
	h=<?=$start_hour_rem?>;
	m=<?=$start_min_rem?>;
	s=<?=$start_sec_rem?>;
	x++;s-=x;
	if(s<0){u=Math.floor(s/60) ;m+=u;s-=u*60;}
	if(m<0){u=Math.floor(m/60) ;h+=u;m-=u*60;}
	if(h<0){u=Math.floor(h/24) ;d+=u;h-=u*24;}
	if((d <= 0)&&(h <= 0)&&(m <= 0)&&(s <= 0)||(d < 0)){
		txt = "Resetting...";
		clearTimeout( setTimeout );
	}else{
		if(d==0){d="";}else{d=d+"일";}
		if(d==0 && h==0){h="";}else if(h<10){h="0"+h+"Hours";}else{h=h+"Hours";}
		if(d==0 && h==0 && m==0){m="";}else if(m<10){m="0"+m+"Minutes";}else{m=m+"Minutes";}
		if(d==0 && h==0 && m==0 && s==0){s="";}else if(s<10){s="0"+s+"Seconds";}else{s=s+"Seconds";}

		txt = "Time until new game,"+d+h+m+s;
	}
	if(document.getElementById || document.all){
		document.all["time"].innerHTML=txt
	}else if(document.layers){
		document.layers["time"].document.open() ;time.document.layers["time"].write(txt) ;document.layers["time"].document.close()
	}else if(document.all){
		document.all["time"].innerHTML=txt
	}
}
secCountDown();
// -->
</SCRIPT>
<?
	}
?>
<SCRIPT language=JavaScript>
<!--
var aryTMP=new Array();var chkRun=0;var chkKill=0;var msgBak="";var objBak="";var classBak="";var msgClm="";var maxRow=0;var msgDsp="";var msgScr="";
function typeMain(obj,cls,msg,max){
	msgBak=msg;objBak=obj;classBak=cls;maxRow=0;maxRow=max-1;
	if(chkRun==1){chkKill=1;return}
	var cntMsgX=0;var cntMsgY=0;var cntLen=0;
	msgDsp="";msgScr="";msgClm="";
	funcNum=aryTMP.length;
	for(i=0;i<funcNum;i++){aryTMP[i]=""}
	prtLay(obj,"");
	while(msg.indexOf('%20')>=0){msg=msg.replace(/%20/," ")}
	aryTMP=msg.split("$$");
	typeWrite(obj,cls,cntMsgX,cntMsgY,cntLen)
}
function typeWrite(obj,cls,cntMsgX,cntMsgY,cntLen){
	chkRun=1;msgDsp=aryTMP[cntMsgY];
	if(chkKill==1){chkKill=0;chkRun=0;clearTimeout(writeID) ;typeMain(objBak,classBak,msgBak,maxRow+1)}
	else{
		if(cntMsgX>msgDsp.length){cntMsgX=0;cntMsgY++;msgClm="";if(cntMsgY<=maxRow){for(i=0;i<cntMsgY;i++){msgClm+=aryTMP[i]+"<BR>"}}else{for(i=(cntMsgY-maxRow) ;i<cntMsgY;i++){msgClm+=aryTMP[i]+"<BR>"}}while(msgClm.indexOf(' ')>=0){msgClm=msgClm.replace(/ /,"&nbsp;")}msgScr="";if(cntMsgY<aryTMP.length){msgDsp=aryTMP[cntMsgY];writeID=setTimeout("typeWrite('"+obj+"','"+cls+"','"+cntMsgX+"','"+cntMsgY+"','"+cntLen+"')",50)}else{chkRun=0;chkKill=0;clearTimeout(writeID)}
		}else{if(cntLen&1){msgScr=msgDsp.substring(0,cntMsgX)+"<B style='"+cls+"'>_</B>"}else{msgScr=msgDsp.substring(0,cntMsgX)}while(msgScr.indexOf(' ')>=0){msgScr=msgScr.replace(/ /,"&nbsp;")}if(cntMsgX==msgDsp.length){csr=""}prtLay(obj,("<DIV style='"+cls+"'>"+msgClm+" "+msgScr+"</DIV>")) ;cntLen++;if(cntLen&1){cntMsgX++}writeID=setTimeout("typeWrite('"+obj+"','"+cls+"','"+cntMsgX+"','"+cntMsgY+"','"+cntLen+"')",50)}
	}
}
function prtLay(obj,html){obj=getLay(obj) ;if(document.getElementById||document.all){obj.innerHTML=html}else if(document.layers){obj.document.open() ;obj.document.write(html) ;obj.document.close()}else if(document.all){obj.innerHTML=html}}
function getLay(obj){if(document.getElementById){return document.getElementById(obj)}else if(document.layers){return document.layers[obj]}else if(document.all){return document.all(obj)}}
// -->

</SCRIPT>
<table border="0" height="144"><tr><td align="center"><div id='tw'>&nbsp;</div></td></tr></table>
<font size="+1" color="lime">【Survivors：<?=$ok?> People】　【Currently moving：<?=$idou?> People】　【Dead：<?=$no?> People】</font>
<BR>
<?
//if (($pref['SubServer'] == 0)||($host != "209.137.141.2")){
?>
<CENTER>
<FORM METHOD="POST" ACTION="BR.php">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="main">
<INPUT TYPE="HIDDEN" NAME="IPAdd" VALUE="<?=$host?>">
<CENTER><FONT color="#ff0000" size="4" face="MS P고딕"><B>Sign In</B></FONT></CENTER>
<font size="2" face="MS P고딕">ID:</font>
<font face="MS P고딕"><INPUT type="text" size="10" name="Id" maxlength="10">&nbsp;&nbsp;&nbsp; </font>
<font size="2" face="MS P고딕">Password:</font><font face="MS P고딕"><INPUT type="password" size="10" name="Password" maxlength="10"></font>&nbsp;&nbsp;&nbsp; <font face="MS P고딕"><INPUT type="submit" name="Enter" value="Sign in!"></font></FORM>
<Script TYPE="text/javascript">
<!--
if(navigator.appVersion.charAt(0)>=3){
	pic_name=new Array();
	pic_name[0]="./img/rule";
	pic_name[1]="./img/regist";
	pic_name[2]="./img/dist";
	pic_name[3]="./img/rank";
	pic_name[4]="./img/map";
	pic_name[5]="./img/news";
	pic_name[6]="./img/admin";
	pic_name[7]="./img/win";

	pic1=new Array();
	pic2=new Array();
	pic3=new Array();

	for(i=0; i<pic_name.length; i++){
		pic1[i]=new Image(); pic1[i].src=pic_name[i]+"1.gif";
		pic2[i]=new Image(); pic2[i].src=pic_name[i]+"2.gif";
		pic3[i]=new Image(); pic3[i].src="./img/BR.gif";
	}
}

function dispImage(status){
	if(navigator.appVersion.charAt(0)>=3){document.images["image"+status].src=pic1[status].src;}
}

function overImage(status){
	if(navigator.appVersion.charAt(0)>=3){document.images["image"+status].src=pic2[status].src;}
}

function clickImage(status){
	if(navigator.appVersion.charAt(0)>=3){document.images["image"+status].src=pic3[status].src;}
}
//-->
</SCRIPT>
<p><a title="Guide" href="rule.php" OnMouseOut="dispImage(0)" onMouseOver="overImage(0)" onClick="clickImage(0)"><img name="image0" border="0" src="./img/rule1.gif" width="128" height="53" loop="0"></a><a title="Register" href="regist.php" OnMouseOut="dispImage(1)" onMouseOver="overImage(1)" onClick="clickImage(1)"><img name="image1" border="0" src="./img/regist1.gif" width="128" height="53"></a><a title="Release" href="http://tomodachi-anime.forumotion.com" OnMouseOut="dispImage(2)" onMouseOver="overImage(2)" onClick="clickImage(2)"><img name="image2" border="0" src="./img/dist1.gif" width="128" height="53"></a></p>
<p><a title="Survivors" href="rank.php" OnMouseOut="dispImage(3)" onMouseOver="overImage(3)" onClick="clickImage(3)"><img name="image3" border="0" src="./img/rank1.gif" width="128" height="53"></a><a title="Map" href="map.php" OnMouseOut="dispImage(4)" onMouseOver="overImage(4)" onClick="clickImage(4)"><img name="image4" border="0" src="./img/map1.gif" width="128" height="53"></a><a title="Game Progress" href="news.php" OnMouseOut="dispImage(5)" onMouseOver="overImage(5)" onClick="clickImage(5)"><img name="image5" border="0" src="./img/news1.gif" width="128" height="53"></a></p>
<p><a title="Admin Panel" href="admin.php" OnMouseOut="dispImage(6)" onMouseOver="overImage(6)" onClick="clickImage(6)"><img name="image6" border="0" src="./img/admin1.gif" width="128" height="53"></a><a title="Winners" href="winner.php" OnMouseOut="dispImage(8)" onMouseOver="overImage(7)" onClick="clickImage(7)"><img name="image8" border="0" src="./img/win1.gif" width="128" height="53"></a></p>
<a title="Main Menu" href="../../">【HOME】</a><BR />
<a href="https://www.facebook.com/tbreng/">※ Please leave feedback on our Facebook page. ※</a><BR />
<?
//} else {print "<br><iframe name=\"LOCAL\" Frameborder=\"0\" width=\"400\" height=\"200\" src=\"http://192.168.4.170/cgi-dir/BR/BRU.php\">Your browser does not support inline frames or is currently configured not to display inline frames.  Please contact with Administrator if you have questions.</iframe>";}
}
FOOTER();
?>