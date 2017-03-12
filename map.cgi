#!/usr/bin/perl

#require "jcode.pl";
require "br.pl";
require "$lib_file";
require "$lib_file2";
&LOCK;
require "$pref_file";

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);
    open(DB,"$area_file");seek(DB,0,0); @arealist=<DB>;close(DB);
    ($ar,$a) = split(/,/, $arealist[1]);

    ($ar,$hackflg,$a) = split(/,/, $arealist[1]);
    ($ara[0],$ara[1],$ara[2],$ara[3],$ara[4],$ara[5],$ara[6],$ara[7],$ara[8],$ara[9],
        $ara[10],$ara[11],$ara[12],$ara[13],$ara[14],$ara[15],$ara[16],$ara[17],$ara[18],$ara[19],
        $ara[20],$ara[21]) = split(/,/, $arealist[4]);

    for ($j=0; $j<$#area+1; $j++) {
        $mem[$j] = "$place[$j]" ;
    }

    if ($hackflg == 0) {
        for ($j=0; $j<$ar; $j++) {
            $mem[$ara[$j]] = "<FONT color=\"#FF0000\">$place[$ara[$j]]</FONT>";
        }

        $mem[$ara[$j]] = "<FONT color=\"FF7030\">$place[$ara[$j]]</FONT>";
        $mem[$ara[$j+1]] = "<FONT color=\"FF7030\">$place[$ara[$j+1]]</FONT>";
        $mem[$ara[$j+2]] = "<FONT color=\"FF7030\">$place[$ara[$j+2]]</FONT>";
    }

#己 是拭 巴傾戚嬢 是帖 妊獣
&CREAD;
$checkpls = "";
if ($c_id) {
	open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);
	foreach $i (0..$#userlist) {
		($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);
		if ($w_id eq $c_id) {
			$checkpls = 1;
			last;
		}
	}
}
if ($checkpls) {
	$uahere = '<span style="position:relative">
	<span style="position:absolute; color:FF00A0; top:-28; right:25; width=150; text-align:right">
	<b><font style="font-size:12pt">You are Here!</font><br><span style="line-height:70%">��</span></b></span></span>';
	$mem[$w_pls] = ($uahere . $mem[$w_pls]);
}

$tdsize = '<td width=50 height=50';
$tdsize2 = '<td width=50 height=50 bgcolor=00FFFF';
$tdsize3 = '<td width=50 height=50 bgcolor=000000';

    &HEADER ;

print <<"_HERE_";

<P align="center"><B><FONT color="#ff0000" size="+3">壕堂稽鐘 企噺舌 娃戚走亀</FONT></B><BR></P>

<table border=0 cellpadding=0 cellspacing=0 width=560 height=600 align=center><tr><td align=center valign=middle>

<div style="position:relative">
<div id="graphic" style="position:absolute; visibility:visible; top:-300; left:-280">
<table border=0 cellpadding=0 cellspacing=0 style="text-align:center; word-break:break-all;
 color:000000; background-image:url($mapimgurl); background-position:52 50; font-weight:bold">
	<tr>
		$tdsize bgcolor=FFFFFF>　</td>
		$tdsize bgcolor=FFFFFF>01</td>
		$tdsize bgcolor=FFFFFF>02</td>
		$tdsize bgcolor=FFFFFF>03</td>
		$tdsize bgcolor=FFFFFF>04</td>
		$tdsize bgcolor=FFFFFF>05</td>
		$tdsize bgcolor=FFFFFF>06</td>
		$tdsize bgcolor=FFFFFF>07</td>
		$tdsize bgcolor=FFFFFF>08</td>
		$tdsize bgcolor=FFFFFF>09</td>
		$tdsize bgcolor=FFFFFF>10</td>
	</tr>
 	<tr>
		$tdsize bgcolor=FFFFFF>A</td>
		$tdsize>　</td>
		$tdsize>$mem[1]</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
	</tr>
 	<tr>
		$tdsize bgcolor=FFFFFF>B</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>$mem[2]</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
	</tr>
 	<tr>
		$tdsize bgcolor=FFFFFF>C</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>$mem[3]</td>
		$tdsize>$mem[4]</td>
		$tdsize>$mem[5]</td>
		$tdsize>$mem[6]</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
	</tr>
 	<tr>
		$tdsize bgcolor=FFFFFF>D</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>$mem[7]</td>
		$tdsize>　</td>
		$tdsize valign=top>$mem[0]</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
	</tr>
 	<tr>
		$tdsize bgcolor=FFFFFF>E</td>
		$tdsize>　</td>
		$tdsize>$mem[8]</td>
		$tdsize>　</td>
		$tdsize>$mem[9]</td>
		$tdsize>$mem[12]</td>
		$tdsize>$mem[12]</td>
		$tdsize>$mem[10]</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
	</tr>
 	<tr>
		$tdsize bgcolor=FFFFFF>F</td>
		$tdsize>　</td>
		$tdsize>$mem[11]</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>$mem[12]</td>
		$tdsize>$mem[12]</td>
		$tdsize>$mem[12]</td>
		$tdsize>$mem[13]</td>
		$tdsize>　</td>
		$tdsize>　</td>
	</tr>
 	<tr>
		$tdsize bgcolor=FFFFFF>G</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>$mem[14]</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>$mem[15]</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
	</tr>
 	<tr>
		$tdsize bgcolor=FFFFFF>H</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>$mem[16]</td>
		$tdsize>$mem[16]</td>
		$tdsize>$mem[17]</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
	</tr>
 	<tr>
		$tdsize bgcolor=FFFFFF>I</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>$mem[18]</td>
		$tdsize>$mem[19]</td>
		$tdsize>　</td>
		$tdsize>　</td>
		$tdsize>$mem[20]</td>
	</tr>
 	<tr>
		<td width=51 height=52 bgcolor=FFFFFF>J</td>
		<td width=51 height=52>　</td>
		<td width=51 height=52>　</td>
		<td width=51 height=52>　</td>
		<td width=51 height=52>　</td>
		<td width=51 height=52>　</td>
		<td width=51 height=52>$mem[21]</td>
		<td width=51 height=52>　</td>
		<td width=51 height=52>　</td>
		<td width=51 height=52>　</td>
		<td width=51 height=52>　</td>
	</tr>
</table><p>

<center><a href="#" onClick="graphic.style.visibility='hidden',text.style.visibility='visible'">努什闘 乞球稽 左奄</a></center>
</div>

<div id="text" style="position:absolute; visibility:hidden; top:-300; left:-280">
<table border=1 cellpadding=0 cellspacing=0 style="text-align:center; word-break:break-all; color:FFFFFF; font-weight:bold">
	<tr>
		$tdsize3>　</td>
		$tdsize3>01</td>
		$tdsize3>02</td>
		$tdsize3>03</td>
		$tdsize3>04</td>
		$tdsize3>05</td>
		$tdsize3>06</td>
		$tdsize3>07</td>
		$tdsize3>08</td>
		$tdsize3>09</td>
		$tdsize3>10</td>
	</tr>
 	<tr>
		$tdsize3>A</td>
		$tdsize2>　</td>
		$tdsize3>$mem[1]</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
	</tr>
 	<tr>
		$tdsize3>B</td>
		$tdsize2>　</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize3>$mem[2]</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
	</tr>
 	<tr>
		$tdsize3>C</td>
		$tdsize2>　</td>
		$tdsize3>　</td>
		$tdsize3>$mem[3]</td>
		$tdsize3>$mem[4]</td>
		$tdsize3>$mem[5]</td>
		$tdsize3>$mem[6]</td>
		$tdsize3>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
	</tr>
 	<tr>
		$tdsize3>D</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize3>$mem[7]</td>
		$tdsize3>　</td>
		$tdsize3>$mem[0]</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
	</tr>
 	<tr>
		$tdsize3>E</td>
		$tdsize3>　</td>
		$tdsize3>$mem[8]</td>
		$tdsize3>　</td>
		$tdsize3>$mem[9]</td>
		$tdsize3>$mem[12]</td>
		$tdsize3>$mem[12]</td>
		$tdsize3>$mem[10]</td>
		$tdsize3>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
	</tr>
 	<tr>
		$tdsize3>F</td>
		$tdsize3>　</td>
		$tdsize3>$mem[11]</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize3>$mem[12]</td>
		$tdsize3>$mem[12]</td>
		$tdsize3>$mem[12]</td>
		$tdsize3>$mem[13]</td>
		$tdsize3>　</td>
		$tdsize2>　</td>
	</tr>
 	<tr>
		$tdsize3>G</td>
		$tdsize2>　</td>
		$tdsize3>　</td>
		$tdsize3>$mem[14]</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize3>$mem[15]</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize2>　</td>
	</tr>
 	<tr>
		$tdsize3>H</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize3>　</td>
		$tdsize3>$mem[16]</td>
		$tdsize3>$mem[16]</td>
		$tdsize3>$mem[17]</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize2>　</td>
	</tr>
 	<tr>
		$tdsize3>I</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize2>　</td>
		$tdsize3>　</td>
		$tdsize3>　</td>
		$tdsize3>$mem[18]</td>
		$tdsize3>$mem[19]</td>
		$tdsize2>　</td>
		$tdsize3>　</td>
		$tdsize3>$mem[20]</td>
	</tr>
 	<tr>
		<td width=51 height=52 bgcolor=000000>J</td>
		<td width=51 height=52 bgcolor=00FFFF>　</td>
		<td width=51 height=52 bgcolor=00FFFF>　</td>
		<td width=51 height=52 bgcolor=00FFFF>　</td>
		<td width=51 height=52 bgcolor=00FFFF>　</td>
		<td width=51 height=52 bgcolor=00FFFF>　</td>
		<td width=51 height=52 bgcolor=000000>$mem[21]</td>
		<td width=51 height=52 bgcolor=00FFFF>　</td>
		<td width=51 height=52 bgcolor=00FFFF>　</td>
		<td width=51 height=52 bgcolor=00FFFF>　</td>
		<td width=51 height=52 bgcolor=00FFFF>　</td>
	</tr>
</table><p>

<center><a href="#" onClick="graphic.style.visibility='visible',text.style.visibility='hidden'">益掘波 乞球稽 左奄</a></center>
</div>

</div>
</td></tr></table>
_HERE_

	&FOOTER;

&UNLOCK;

exit;
