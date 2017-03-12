#해석완료

#==================#
# ■ レ?ダ??理  #
#==================#
sub READER {

    if ($item[$wk] !~ /R/) {&ERROR("부정 억세스입니다.") ;}

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);
    open(DB,"$area_file");seek(DB,0,0); @arealist=<DB>;close(DB);

    ($ar,$hackflg,$a) = split(/,/, $arealist[1]);
    @ara = split(/,/, $arealist[4]);

    for ($i=0; $i<$#userlist+1; $i++) {
        ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);
        for ($j=0; $j<$#area+1; $j++) {
            if (($w_pls eq $j)&&($w_hit > 0)) {
                $mem[$j] += 1;last;
            }
        }
    }


    if ($item[$wk] =~ /<>R2/) {
        for ($j=0; $j<$#area+1; $j++) {
            if ($j == $pls) {
                $wk = $mem[$j];
                $mem[$j] = "<FONT color=\"#ff0000\"><b>$wk<b></FONT>";
            } elsif ($mem[$j] <= 0) {
                $mem[$j] = "　" ;
            }
        }
    } else {
        for ($j=0; $j<$#area+1; $j++) {
            if ($j == $pls) {
                $wk = $mem[$j];
                $mem[$j] = "<FONT color=\"#ff0000\"><b>$wk<b></FONT>";
            } else {
                $mem[$j] = "　" ;
            }
        }
    }
  if ($hackflg == 0) {
    for ($j=0; $j<$ar; $j++) {
        $mem[$ara[$j]] = "<FONT color=\"#ff0000\"><b>×<b></FONT>";
    }
  }

print <<"_HERE_";
<P align="center"><B><FONT color="#ff0000" size="+3">$place[$pls] \($area[$pls]\)</FONT></B><BR></P>

<table border=0 cellpadding=1 cellspacing=1>
<tr><td valign=middle align=center width=350>

<table border=1 cellpadding=0 cellspacing=0 width=100% height=260 style="text-align:center">
	<tr>
		<td>　</td>
		<td>01</td>
		<td>02</td>
		<td>03</td>
		<td>04</td>
		<td>05</td>
		<td>06</td>
		<td>07</td>
		<td>08</td>
		<td>09</td>
		<td>10</td>
	</tr>
 	<tr>
		<td>A</td>
		<td bgcolor="00FFFF">　</td>
		<td>$mem[1]</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
	</tr>
 	<tr>
		<td>B</td>
		<td bgcolor="00FFFF">　</td>
		<td>　</td>
		<td>　</td>
		<td>$mem[2]</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
	</tr>
 	<tr>
		<td>C</td>
		<td bgcolor="00FFFF">　</td>
		<td>　</td>
		<td>$mem[3]</td>
		<td>$mem[4]</td>
		<td>$mem[5]</td>
		<td>$mem[6]</td>
		<td>　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
	</tr>
 	<tr>
		<td>D</td>
		<td>　</td>
		<td>　</td>
		<td>　</td>
		<td>$mem[7]</td>
		<td>　</td>
		<td>$mem[0]</td>
		<td>　</td>
		<td>　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
	</tr>
 	<tr>
		<td>E</td>
		<td>　</td>
		<td>$mem[8]</td>
		<td>　</td>
		<td>$mem[9]</td>
		<td>　</td>
		<td>　</td>
		<td>$mem[10]</td>
		<td>　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
	</tr>
 	<tr>
		<td>F</td>
		<td>　</td>
		<td>$mem[11]</td>
		<td>　</td>
		<td>　</td>
		<td>$mem[12]</td>
		<td>　</td>
		<td>　</td>
		<td>$mem[13]</td>
		<td>　</td>
		<td bgcolor="00FFFF">　</td>
	</tr>
 	<tr>
		<td>G</td>
		<td bgcolor="00FFFF">　</td>
		<td>　</td>
		<td>$mem[14]</td>
		<td>　</td>
		<td>　</td>
		<td>$mem[15]</td>
		<td>　</td>
		<td>　</td>
		<td>　</td>
		<td bgcolor="00FFFF">　</td>
	</tr>
 	<tr>
		<td>H</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td>　</td>
		<td>$mem[16]</td>
		<td>　</td>
		<td>$mem[17]</td>
		<td>　</td>
		<td>　</td>
		<td>　</td>
		<td bgcolor="00FFFF">　</td>
	</tr>
 	<tr>
		<td>I</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td>　</td>
		<td>　</td>
		<td>$mem[18]</td>
		<td>$mem[19]</td>
		<td bgcolor="00FFFF">　</td>
		<td>　</td>
		<td>$mem[20]</td>
	</tr>
 	<tr>
		<td>J</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td>$mem[21]</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
		<td bgcolor="00FFFF">　</td>
	</tr>
</table><!--레이더 메인 테이블 끝//-->

</td><td width=200 height=100% rowspan=2>

<table border=1 cellpadding=1 cellspacing=0 width=100% height=100%>
	<tr>
		<th>커맨드</th>
	</tr>
	<tr>
		<td height=100% valign=top style="word-break:break-all">
		<br>
        <FORM METHOD="POST">
        <INPUT TYPE="HIDDEN" NAME="mode" VALUE="command">
        <INPUT TYPE="HIDDEN" NAME="Id" VALUE="$id2">
        <INPUT TYPE="HIDDEN" NAME="Password" VALUE="$password2">
_HERE_

        &COMMAND;

print <<"_HERE_";
		</td>
        </FORM>
	</tr>
</table><!--커맨드 테이블 끝//-->

</td></tr>
<tr><td height=150 width=350 valign=top>

<table border=1 cellpadding=5 cellspacing=0 width=100% height=100%>
    <tr>
        <td colspan=3 height=100% valign=top style="word-break:break-all">레이더를 사용했다.<p>숫자：지역에 있는 사람수<br>붉은숫자：자신이 있는 지역의 사람수</td>
	</tr>
</table><!--로그 테이블 끝//-->

</td></tr></table><p>

_HERE_

$mflg="ON"; #ステ?タス非表示
}

1;
