# 汎用サブル?チン集

#==================#
# ■ IDチェック?理#
#==================#
sub IDCHK {


    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);


    $mem=0;
    $chksts = "NG";
    for ($i=0; $i<$#userlist+1; $i++) {
        ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);
        if ($w_id eq $id2) {    #ID一致？
            if ($w_password eq $password2) {    #パスワ?ド正常？
                if ($w_hit > 0) {
                    $chksts = "OK";$Index=$i;$mem++;$plsmem[$w_pls]++ ;
                    ($id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf) = split(/,/, $userlist[$i]);

                    &CSAVE;

                    #총성 로그
                    open(DB,"$gun_log_file");seek(DB,0,0); @gunlog=<DB>;close(DB);

                    local($guntime,$gunpls,$wid,$wid2,$a) = split(/,/,$gunlog[0]) ;
                    if (($now < ($guntime+(15)))&& ($wid ne $id) && ($wid2 ne $id)) {   #총 사용한 후 15초 이내?
                        $jyulog = "<font color=\"yellow\"><b>$gunpls 쪽에서\, 총성이 들렸다...</b></font><br>" ;
                    } else { $jyulog = "" ; }
                    local($guntime,$gunpls,$wid,$wid2,$a) = split(/,/,$gunlog[1]) ;
                    if (($now < ($guntime+(30)))&& ($wid ne $id) && ($wid2 ne $id) && ($place[$pls] eq $gunpls)) {  #살해 후 30초 이내?
                        $jyulog2 = "<font color=\"yellow\"><b>근처에서 비명이? 누군가\, 죽은 것인가...?</b></font><br>" ;
                    } else { $jyulog2 = "" ; }
                    local($guntime,$gunpls,$wid,$wid2,$a) = split(/,/,$gunlog[2]) ;
                    if (($now < ($guntime+(30)))) { #스피커 사용 후 30초 이내?
                        $jyulog3 = "<font color=\"yellow\"><b>$gunpls 쪽에서 $wid의 목소리가 들렸다...</b></font><br><font color=\"lime\"><b>『$wid2』</b></font><br>" ;
                    } else { $jyulog3 = "" ; }
                } else {
					($id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf) = split(/,/, $userlist[$i]);
                    &CSAVE;
                    &ERROR("이미 죽어있습니다.<p>사인：$w_death<p><font color=\"lime\"><b>$w_msg</b></font><br>") ;
                }
            } else {
                &ERROR("패스워드가 맞지 않습니다.") ;
            }
        } else {
            if ($w_hit > 0) {
                $plsmem[$w_pls]++ ;
                if ($w_sts ne "NPC0"){ $mem ++ ; }
                }
        }
    }

    if ($chksts eq "NG") {
        &ERROR("아이디를 찾을 수 없습니다.") ;
    }

    local($b_limit) = ($battle_limit * 3) + 1;
    if ((($mem == 1) && ($inf =~ /승/))||(($mem == 1) && ($ar > $b_limit))) {    #우승?
		require "$ending_file";
		open(FLAG,$end_flag_file) || exit; $fl=<FLAG>; close(FLAG);
		unless ( $fl ) { &LOGSAVE("WINEND1"); &SURVIVORSAVE; }
        open(FLAG,">$end_flag_file"); print(FLAG "종료\n"); close(FLAG);
		&ENDING;
    }elsif ($inf =~ /해/){
        require "$ending_file";
        &ENDING;
    }elsif ($fl =~ /해제/){
        require "$ending_file";
        &ENDING;
    } else {
        if ($log ne '') {$wlog = $log ;$log="";&SAVE;$log=$wlog;}
        $bid = "" ;
    }
}

#==================#
# ■ ステ?タス部  #
#==================#
sub STS {

    local($watt_2) = 0 ;

    if (($Command ne "INN2")&&($Command ne "HEAL2")) {
        $up = int(($now - $endtime) / (1*$kaifuku_time));
        if ($w_inf =~ /腹/) { $up = int($up / 2) ; }
        if ($sts eq "수면") {
            $maxp = $maxsta - $sta ;    #최대치까지 얼마
            if ($up > $maxp) { $up = $maxp ; }
            $sta += $up ;
            if ($sta > $maxsta) { $sta = $maxsta ; }
            $log = ($log . "수면 결과\, 스테미너가 $up 회복 되었다.<BR>") ;
            $sts = "정상"; $endtime = 0 ;
            &SAVE ;
        } elsif ($sts eq "치료") {
            if ($kaifuku_rate == 0){$kaifuku_rate = 1;}
            $up = int($up / $kaifuku_rate) ;
            $maxp = $mhit - $hit ;  #최대치까지 얼마
            if ($up > $maxp) { $up = $maxp ; }
            $hit += $up ;
            if ($hit > $mhit) { $hit = $mhit ; }
            $log = ($log . "치료 결과\, 체력이 $up 회복 되었다.<BR>") ;
            $sts = "정상"; $endtime = 0 ;
            &SAVE ;
        }
    }

    ($w_name,$w_kind) = split(/<>/, $wep);
    ($b_name,$b_kind) = split(/<>/, $bou);

    $levelplusone = $level +1;

    $cln = "$cl$sex$no번" ;

    if (($w_kind =~ /G|A/) && ($wtai == 0)) { #棍棒 or ?無し銃 or 矢無し弓
        $watt_2 = int($watt/10) ;
    } else {
        $watt_2 = $watt ;
    }

    $ball = $bdef + $bdef_h + $bdef_a + $bdef_f ;
    if ($item[5] =~ /AD/) {$ball += $eff[5];} #?飾が防具？

    $kega ="" ;
    if ($inf =~ /頭/) {$kega = ($kega . "머리　") ;}
    if ($inf =~ /腕/) {$kega = ($kega . "팔　") ;}
    if ($inf =~ /腹/) {$kega = ($kega . "복부　") ;}
    if ($inf =~ /足/) {$kega = ($kega . "다리　") ;}
    if ($kega eq "") { $kega = "　" ;}

print <<"_HERE_";
<P align="center"><B><FONT color="#ff0000" size="+3">$place[$pls] ($area[$pls])</FONT></B><BR>
</P>

<table border=0 cellpadding=1 cellspacing=1>
<tr><td valign=top>

<table border=1 cellpadding=1 cellspacing=0 width=100%>
    <tr>
        <th colspan=3 width=460><center>스테이터스</center></th>
    </tr>
    <tr>
        <td width=70 height=70><img src="$imgurl$icon_file[$icon]" width="70" height="70" border="0"></td>
        <td width=160 align=center height=70>$f_name $l_name<br>Lv $level<br>(Lv $levelplusone 까지 $exp 남음)</td>
        <td width=220 rowspan=8 valign=top>
_HERE_

        print "<table border=0 cellpadding=1 cellspacing=0 width=100%>";
		@tlist = ("무기", "방어", "머리", "팔", "다리", "장식");
		@tname = ($wep, $bou, $bou_h, $bou_a, $bou_f, $item[5]);
		@tatt = ($watt, $bdef, $bdef_h, $bdef_a, $bdef_f, $eff[5]);
		@ttai = ($wtai, $btai, $btai_h, $btai_a, $btai_f, $itai[5]);
		@tcol = (lwep, lclo, lclo, lclo, lclo, lclo);

		$i=0;
		foreach $i (0..5) {
			if ($tname[$i] ne "없음") {
				($i_name,$i_kind) = split(/<>/, $tname[$i]);
                print "<tr class=$tcol[$i]><td width=38>[$tlist[$i]]</td><td style=\"word-break:break-all\">$i_name/$tatt[$i]/$ttai[$i]</font></td></tr>\n";
            }
            else {print "<tr class=$tcol[$i]><td width=38>[$tlist[$i]]</td><td>-</font></td>\n";}
        }

        print "</table>";

		$mcolor = "normal";
		&COLOR;

print <<"_HERE_";
        </td>
    </tr>
    <tr>
        <td>체력</td>
        <td><font class=hp>$hit/$mhit</font></td>
    </tr>
    <tr>
        <td>스테미너</td>
        <td><font class=sp>$sta/$maxsta</font></td>
    </tr>
    <tr>
        <td>공격력</td>
        <td>$att<font class=wep> + $watt_2</font></td>
    </tr>
    <tr>
        <td>방어력</td>
        <td>$def<font class=clo> + $ball</font></td>
    </tr>
    <tr>
        <td>클럽</td>
        <td>$club</td>
    </tr>
    <tr>
        <td>기본방침</td>
        <td>$tactics</td>
    </tr>
    <tr>
        <td>부상부위</td>
        <td>$kega</td>
    </tr>
    <tr>
        <td colspan=3>
_HERE_

	$p_wa = int($wa/$BASE);
	$p_wb = int($wb/$BASE);
	$p_wc = int($wc/$BASE);
	$p_wd = int($wd/$BASE);
	$p_wg = int($wg/$BASE);
	$p_ws = int($ws/$BASE);
	$p_wn = int($wn/$BASE);
	$p_wp = int($wp/$BASE);
	print "총：$p_wg($wg)　칼：$p_wn($wn)　던지기：$p_wc($wc)　때리기：$p_wp($wp)<br>\n";
	print "활：$p_wa($wa)　곤봉：$p_wb($wb)　폭탄：$p_wd($wd)　찌르기：$p_ws($ws)<br>\n";

print <<"_HERE_";
		</td>
    </tr>
</table><!--스테이터스 테이블 끝//-->

</td><td width=200 height=100% rowspan=2>

<table border=1 cellpadding=1 cellspacing=0 width=100% height=100%>
	<tr>
		<th>커맨드</th>
	</tr>
	<tr>
		<td height=100% valign=top style="word-break:break-all">
		<br>
        <FORM METHOD="POST" action="$battle_file">
        <INPUT TYPE="HIDDEN" NAME="mode" VALUE="command">
        <INPUT TYPE="HIDDEN" NAME="Id" VALUE="$id2">
        <INPUT TYPE="HIDDEN" NAME="Password" VALUE="$password2">
_HERE_

	    ($ar[0],$ar[1],$ar[2],$ar[3],$ar[4],$ar[5],$ar[6],$ar[7],$ar[8],$ar[9],$ar[10],$ar[11],$ar[12],$ar[13],$ar[14],$ar[15],$ar[16],$ar[17],$ar[18],$ar[19],$ar[20],$ar[21],$ar[22]) = split(/,/, $arealist[2]);
	    ($war,$a) = split(/,/, $arealist[1]);

        print "　<select name=\"Command\">\n" ;
        print "<option value=\"MAIN\" selected>($area[$pls])$place[$pls]\n";
        for ($j=0; $j<$#place+1; $j++) {

            if ($place[$j] ne $place[$pls]) {

			    if(($ar[$war] eq $place[$j])||($ar[$war+1] eq $place[$j])||($ar[$war+2] eq $place[$j])) {
	                $temp[$j] = "2";
            	}
			    else {
					$temp[$j] = "1";
			        for ($i=0; $i<$war; $i++) {

			            if ($ar[$i] eq $place[$j]) {   #禁止エリア？
			                if ( $temp[$j] == 1 || $temp eq "") { $temp[$j] = "3"; }
		            	}
		            }
		        }

	        	if ( $temp[$j] == 1) {
	        		print "<option value=\"MV$j\">($area[$j])$place[$j]</option>\n";
	        	}
	        	elsif ( $temp[$j] == 2) {
		       		print "<option value=\"MV$j\" style=\"color:FF8000\">($area[$j])$place[$j]</option>\n";
	        	}
	        	elsif ( $temp[$j] == 3) {
	        		print "<option value=\"MV$j\" style=\"color:FF0000\">($area[$j])$place[$j]</option>\n";
	    	   	}
            }
        }

print <<"_HERE_";
        </select>
        <INPUT type="submit" name="Enter" value="이동">
        </FORM>
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
        <td colspan=3 height=100% valign=top style="word-break:break-all">$log</td>
	</tr>
</table><!--로그 테이블 끝//-->

</td></tr></table><p>

_HERE_
}

#==================#
# ■ デコ?ド?理  #
#==================#
sub DECODE {
    $p_flag=0;
        if ($ENV{'REQUEST_METHOD'} eq "POST") {
            $p_flag=1;
            if ($ENV{'CONTENT_LENGTH'} > 51200) {
                &ERROR("이상한 입력입니다"); }
            read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
        } else { $buffer = $ENV{'QUERY_STRING'}; }
    @pairs = split(/&/, $buffer);
    foreach (@pairs) {
        ($name,$value) = split(/=/, $_);
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

# Jcode 주석처리 by 루리아
#        &jcode::convert(*value, "euc", "", "z");
#        &jcode::tr(\$value, '　', ' ');

        $value =~ s/&amp;/&/g;
        $value =~ s/&lt;/</g;
        $value =~ s/&gt;/>/g;
        $value =~ s/&quot;/"/g;
        $value =~ s/&nbsp;/ /g;

        $value =~ s/&/&amp;/g;
        $value =~ s/</&lt;/g;
        $value =~ s/>/&gt;/g;
        $value =~ s/"/&quot;/g;
        $value =~ s/ /&nbsp;/g;
        $value =~ s/,/，/g; #デ?タ破損?策

        $in{$name} = $value;
    }

	$first = $in{'first'};
    $mode = $in{'mode'};
    $id2 = $in{'Id'};
    $password2 = $in{'Password'};

    $Command = $in{'Command'};
    $Command2 = $in{'Command2'};

    $l_name2 = $in{'L_Name'} ;
    $f_name2 = $in{'F_Name'} ;
    $msg2 = $in{'Message'} ;
    $dmes2 = $in{'Message2'} ;
    $dengon = $in{'Dengon'} ;
    $com2 = $in{'Comment'} ;
    $sex2 = $in{'Sex'};
    $icon2 = $in{'Icon'};
    $itno2 = $in{'Itno'};
    $getid = $in{'WId'};
    $speech = $in{'speech'};

    srand;

}

#==================#
# ■ メニュ?部    #
#==================#
sub COMMAND {

    local($i) = 0 ;

    if (($Command eq "INN2") || ($Command eq "HEAL2") || ($Command eq "KEIKAI2")) {
        if ($Command eq "HEAL2") {
            $log = ($log . "상처를 치료하자.<BR>") ;
            $sts = "치료" ;
            print "　치료중...<br>\n";
            &CLOCK;
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"HEAL2\" checked>치료<p>\n";
        } else {
            $log = ($log . "조금 자둘까.<BR>") ;
            $sts = "수면" ;
            print "　수면중...<br>\n";
            &CLOCK;
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"INN2\" checked>수면<p>\n";
        }
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\">돌아간다<p>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
        return ;
    }

    if (($Command eq '')||($Command eq "MAIN")) {   #MAIN
        $log = ($log . "$jyulog$jyulog2$jyulog3자\, 어떻게하지...<br>") ;
        print "　무엇을 합니까?<p>\n";
        if ($place[$pls] eq "분교") {
            if ($hackflg == 1) {
                print "　<INPUT type=\"radio\" name=\"Command\" value=\"SEARCH\" checked>탐색<BR>\n";
            }

			$mcolor = ITEMandDEL;
			&COLOR;

            print "　<INPUT type=\"radio\" name=\"Command\" value=\"ITMAIN\">아이템 정리/합성/장비<BR>\n";
	        print "　<input type=radio name=\"Command\" value=\"OUKYU\">응급처치<BR>\n";
			print "　<INPUT type=\"radio\" name=\"Command\" value=\"SPECIAL\">특수 커맨드<BR>\n";
		} else {
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"SEARCH\" checked>탐색<BR>\n";

			$mcolor = ITEMandDEL;
			&COLOR;

            print "　<INPUT type=\"radio\" name=\"Command\" value=\"ITMAIN\">아이템 정리/합성/장비<BR>\n";
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"HEAL\"><font class=hp>치료</font><BR>\n";
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"INN\"><font class=sp>수면</font><BR>\n";
	        print "　<input type=radio name=\"Command\" value=\"OUKYU\">응급처치<BR>\n";
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"SPECIAL\">특수 커맨드<BR>\n";
        }
        print "<BR>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
	}
	elsif ($Command eq "SEIRI") { #アイテム整理
        $log = ($log . "배낭 안을 정리할까...<BR>") ;
        print "　무엇과 무엇을 모읍니까?<p>\n";
        print "　<select name=\"Command\">\n" ;
        print "　<option value=\"MAIN\" selected>그만둔다</option>\n";
        for ($i=0; $i<5; $i++) {
            if ($item[$i] ne "없음") {
                ($in, $ik) = split(/<>/, $item[$i]);
                print "　<option value=\"SEIRI_$i\">\[$i\]$in/$eff[$i]/$itai[$i]</option>\n";
            }
        }
        print "</select><BR>\n" ;
        print "<BR>\n";
        print "　<select name=\"Command2\">\n" ;
        print "　<option value=\"MAIN\" selected>그만둔다</option>\n";
        for ($i2=0; $i2<5; $i2++) {
            if ($item[$i2] ne "없음") {
                ($in2, $ik2) = split(/<>/, $item[$i2]);
                print "　<option value=\"SEIRI2_$i2\">\[$i2\]$in2/$eff[$i2]/$itai[$i2]</option>\n";
            }
        }
        print "</select><BR>\n" ;
        print "<BR>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "GOUSEI") { #アイテム合成
        $log = ($log . "지금 가지고 있는 것을 조합해서\, 뭔가 만들 수 없을까?<BR>") ;
        print "　무엇과 무엇을 합성합니까?<p>\n";
        print "　<select name=\"Command\">\n" ;
        print "　<option value=\"MAIN\" selected>그만둔다</option>\n";
        for ($i=0; $i<5; $i++) {
            if ($item[$i] ne "없음") {
                ($in, $ik) = split(/<>/, $item[$i]);
                print "　<option value=\"GOUSEI_$i\">$in/$eff[$i]/$itai[$i]</option>\n";
            }
        }
        print "</select><BR>\n" ;
        print "<BR>\n";
        print "　<select name=\"Command2\">\n" ;
        print "　<option value=\"MAIN\" selected>그만둔다</option>\n";
        for ($i2=0; $i2<5; $i2++) {
            if ($item[$i2] ne "없음") {
                ($in2, $ik2) = split(/<>/, $item[$i2]);
                print "　<option value=\"GOUSEI2_$i2\">$in2/$eff[$i2]/$itai[$i2]</option>\n";
            }
        }
        print "</select><BR>\n" ;
        print "<BR>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "OUKYU") { #?急?置
        $log = ($log . "상처를 치료 할까...<BR>") ;

        print "어디를 치료합니까?<p>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아간다<p>\n";

        if ($inf =~ /頭/) { print "　<INPUT type=\"radio\" name=\"Command\" value=\"OUK_0\">머리<BR>\n"; }
        if ($inf =~ /腕/) { print "　<INPUT type=\"radio\" name=\"Command\" value=\"OUK_1\">팔<BR>\n"; }
        if ($inf =~ /腹/) { print "　<INPUT type=\"radio\" name=\"Command\" value=\"OUK_2\">복부<BR>\n"; }
        if ($inf =~ /足/) { print "　<INPUT type=\"radio\" name=\"Command\" value=\"OUK_3\">다리<BR>\n"; }

        print "<BR>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
	} elsif ($Command =~ /BATTLE0/) {   #??コマンド
        local($a,$wid) = split(/_/, $Command);
        $log = ($log . "자\, 어떻게하지...") ;
        print "　무엇을 합니까?<p>\n";
        print "　메시지<BR>\n";
        print "　<INPUT size=\"30\" type=\"text\" name=\"Dengon\" maxlength=\"64\"><p>\n";
        $chk = "checked" ;
        ($w_name,$w_kind) = split(/<>/, $wep);
        if ($w_kind =~ /B/) {print "　<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WB_$wid\" $chk>때린다($wb)<BR>\n"; $chk="" ;}
        if ($w_kind =~ /P/) {print "　<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WP_$wid\" $chk>때린다($wp)<BR>\n"; $chk="" ;}
        if (($w_kind =~ /G/) && ($wtai > 0)) {print "　<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WG_$wid\" $chk>쏜다($wg)<BR>\n"; $chk="" ;}
        if (($w_kind =~ /A/) && ($wtai > 0)) {print "　<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WA_$wid\" $chk>쏜다($wa)<BR>\n"; $chk="" ;}
        if ($w_kind =~ /N/) {print "　<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WN_$wid\" $chk>벤다($wn)<BR>\n"; $chk="" ;}
        if ($w_kind =~ /S/) {print "　<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WS_$wid\" $chk>찌른다($ws)<BR>\n"; $chk="" ;}
        if ($w_kind =~ /C/) {print "　<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WC_$wid\" $chk>던진다($wc)<BR>\n"; $chk="" ;}
        if ($w_kind =~ /D/) {print "　<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WD_$wid\" $chk>던진다($wd)<BR>\n"; $chk="" ;}
        if (($w_kind !~ /S|N|C|P|D|B/)&&(($w_kind =~ /G|A/) && ($wtai == 0))) {print "　<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WB_$wid\" $chk>때린다($wb)<BR>\n"; $chk="" ;}
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"RUNAWAY\">도망<BR>\n";
        print "<BR>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "BATTLE2") {   #アイテム?奪
        local($itno) = -1;
        for ($i=0; $i<5; $i++) {
            if ($item[$i] eq "없음") {
                $itno = $i ;
            }
        }
        print "　무엇을 뺏습니까?<p>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아간다<p>\n";
        print "<INPUT TYPE=\"HIDDEN\" NAME=\"Itno\" VALUE=\"$itno\">\n";
        print "<INPUT TYPE=\"HIDDEN\" NAME=\"WId\" VALUE=\"$w_id\">\n";

        if ($w_wep !~ /맨손/) { #武器所持？
            local($in, $ik) = split(/<>/, $w_wep);
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_6\"><font class=wep>$in/$w_watt/$w_wtai</font><BR>\n";
        }
        if ($w_bou !~ /속옷/) { #防具所持？
            local($in, $ik) = split(/<>/, $w_bou);
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_7\"><font class=clo>$in/$w_bdef/$w_btai</font><BR>\n";
        }
        if ($w_bou_h !~ /없음/) { #防具所持？
            local($in, $ik) = split(/<>/, $w_bou_h);
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_8\"><font class=clo>$in/$w_bdef_h/$w_btai_h</font><BR>\n";
        }
        if ($w_bou_f !~ /없음/) { #防具所持？
            local($in, $ik) = split(/<>/, $w_bou_f);
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_9\"><font class=clo>$in/$w_bdef_f/$w_btai_f</font><BR>\n";
        }
        if ($w_bou_a !~ /없음/) { #防具所持？
            local($in, $ik) = split(/<>/, $w_bou_a);
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_10\"><font class=clo>$in/$w_bdef_a/$w_btai_a</font><BR>\n";
        }

		$mcolor = GET;
		&COLOR;

        print "<BR>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "DEATHGET") {  #死?アイテム?奪
        local($itno) = -1;
        for ($i=0; $i<5; $i++) {
            if ($item[$i] eq "없음") {
                $itno = $i ;
            }
        }
        print "　무엇을 뺏습니까?<p>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아간다<p>\n";
        print "<INPUT TYPE=\"HIDDEN\" NAME=\"Itno\" VALUE=\"$itno\">\n";
        print "<INPUT TYPE=\"HIDDEN\" NAME=\"WId\" VALUE=\"$w_id\">\n";

        if ($w_wep !~ /맨손/) { #武器所持？
            local($in, $ik) = split(/<>/, $w_wep);
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_6\"><font class=wep>$in/$w_watt/$w_wtai</font><BR>\n";
        }
        if ($w_bou !~ /속옷/) { #防具所持？
            local($in, $ik) = split(/<>/, $w_bou);
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_7\"><font class=clo>$in/$w_bdef/$w_btai</font><BR>\n";
        }
        if ($w_bou_h !~ /없음/) { #防具所持？
            local($in, $ik) = split(/<>/, $w_bou_h);
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_8\"><font class=clo>$in/$w_bdef_h/$w_btai_h</font><BR>\n";
        }
        if ($w_bou_f !~ /없음/) { #防具所持？
            local($in, $ik) = split(/<>/, $w_bou_f);
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_9\"><font class=clo>$in/$w_bdef_f/$w_btai_f</font><BR>\n";
        }
        if ($w_bou_a !~ /없음/) { #防具所持？
            local($in, $ik) = split(/<>/, $w_bou_a);
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_10\"><font class=clo>$in/$w_bdef_a/$w_btai_a</font><BR>\n";
        }

		$mcolor = GET;
		&COLOR;

        print "<BR>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "POISON") {    #毒物混入
        $log = ($log . "이 $doku을(를) 섞으면... 후후후.<BR>") ;
        print "무엇에 $doku2을(를) 섞습니까?<p>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아간다<p>\n";
        for ($i=0; $i<5; $i++) {
            if ($item[$i] =~ /<>SH|<>HH|<>SD|<>HD/) {
                local($in, $ik) = split(/<>/, $item[$i]);
                print "　<INPUT type=\"radio\" name=\"Command\" value=\"POI_$i\">$in/$eff[$i]/$itai[$i]<BR>\n";
            }
        }
        print "<BR>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "PSCHECK") {   #毒見
        $log = ($log . "뭔가가 섞여있지 않은지 조사해보자...<BR>") ;
        print "　무엇을 조사합니까?<p>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아간다<p>\n";
        for ($i=0; $i<5; $i++) {
            if ($item[$i] =~ /<>SH|<>HH|<>SD|<>HD/) {
                local($in, $ik) = split(/<>/, $item[$i]);
                print "　<INPUT type=\"radio\" name=\"Command\" value=\"PSC_$i\">$in/$eff[$i]/$itai[$i]<BR>\n";
            }
        }
        print "<BR>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "SPIICH") { #携?スピ?カ使用
        $log = ($log . "확성기를 써서\, 모두에게 메시지를 전한다.<BR>") ;
        print "　이것을 사용하면\, 모두에게 들리겠지...<BR>\n";
        print "　(한글 20자까지)<p>\n";
        print "　<INPUT size=\"30\" type=\"text\" name=\"speech\"maxlength=\"50\"><p>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"SPEAKER\" checked>전한다<BR>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\">그만둔다<p>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "WINCHG") {    #口癖?更
        $log = ($log . "살해시\, 사망시의 대사를 변경합니다.<BR>") ;
        print "　대사를 입력해 주세요.<BR>\n";
        print "　(한글 32자까지)<p>\n";
        print "　살해시 :<BR>\n";
        print "　<INPUT size=\"24\" type=\"text\" name=\"Message\" maxlength=\"64\" value=\"$msg\"><p>\n";
        print "　유언 :<BR>\n";
        print "　<INPUT size=\"24\" type=\"text\" name=\"Message2\" maxlength=\"64\" value=\"$dmes\"><p>\n";
        print "　한마디 코멘트 :<BR>\n";
        print "　<INPUT size=\"24\" type=\"text\" name=\"Comment\" maxlength=\"64\" value=\"$com\"><p>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "ITMAIN") {    #아이템
        $log = ($log . "배낭 안에는\, 뭐가 들어 있을까...<BR>") ;
        print "　무엇을 합니까?<p>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아간다<p>\n";
#        print "　<INPUT type=\"radio\" name=\"Command\" value=\"ITEM\">아이템 사용·장비<BR>\n";
#        print "　<INPUT type=\"radio\" name=\"Command\" value=\"DEL\">아이템 버리기<BR>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"SEIRI\">아이템 정리<BR>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"GOUSEI\">아이템 합성<BR>\n";
        if ($wep ne "맨손<>WP") {
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"WEPDEL\">장비무기를 벗는다<BR>\n";
            print "　<INPUT type=\"radio\" name=\"Command\" value=\"WEPDEL2\">장비무기를 버린다<BR>\n";
        }
        print "<BR>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "SPECIAL") {   #특수
        $log = ($log . "특수 커맨드입니다.<BR>") ;
        print "　무엇을 합니까?<p>\n";
        print "　<input type=radio name=\"Command\" value=\"MAIN\" checked>돌아간다<p>\n";
#        print "　<input type=radio name=\"Command\" value=\"DEFCHK\">장비확인<BR>\n";
#        print "　<input type=radio name=\"Command\" value=\"WEPPNT\">숙련레벨확인<BR>\n";
		print "　기본방침 변경<BR>\n";
		print "　<INPUT type=\"radio\" name=\"Command\" value=\"KOU_0\">보통<BR>\n";
		print "　<INPUT type=\"radio\" name=\"Command\" value=\"KOU_1\">공격중시<BR>\n";
		print "　<INPUT type=\"radio\" name=\"Command\" value=\"KOU_2\">방어중시<BR>\n";
		print "　<INPUT type=\"radio\" name=\"Command\" value=\"KOU_3\">은밀행동<BR>\n";
		print "　<INPUT type=\"radio\" name=\"Command\" value=\"KOU_4\">탐색행동<BR>\n";
		print "　<INPUT type=\"radio\" name=\"Command\" value=\"KOU_5\">연속공격<p>\n";
#		print "　<input type=radio name=\"Command\" value=\"KOUDOU\">기본방침 변경<BR>\n";
        print "　<input type=radio name=\"Command\" value=\"WINCHG\">대사 변경<BR>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"USRSAVE\">세이브<BR>\n";
        if ($club eq "요리부" ) { print "　<INPUT type=\"radio\" name=\"Command\" value=\"PSCHECK\">독 조사<BR>\n"; }
        for ($poi=0; $poi<5; $poi++){
            if ($item[$poi] eq "독약<>Y") {
                print "　<input type=radio name=\"Command\" value=\"POISON\">독 섞기<BR>\n";
                last;
            }
        }
#        for ($spi=0; $spi<5; $spi++){
#            if ($item[$spi] eq "확성기<>Y") {
#                print "　<input type=radio name=\"Command\" value=\"SPIICH\">확성기 사용<BR>\n";
#                last;
#            }
#        }
        for ($paso=0; $paso<5; $paso++){
            if ($item[$paso] eq "모바일PC<>Y") {
                print "　<input type=radio name=\"Command\" value=\"HACK\">해킹<BR>\n";
                last;
            }
        }

        print "<p>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    } elsif ($Command eq "USRSAVE") {   #ユ?ザデ?タ保存
        &u_save;
    } else {
        print "　무엇을 합니까?<p>\n";
        print "　<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아간다<p>\n";
        print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    }


}
#====================#
# ■ ユ?ザ情報保存  #
#====================#
sub SAVE {

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    $chksts = "NG";
    for ($i=0; $i<$#userlist+1; $i++) {
        ($w_i,$w_p,$a) = split(/,/, $userlist[$i]);
        if (($id2 eq $w_i) && ($password2 eq $w_p)) {   #ID一致？
            $chksts = "OK";$Index=$i;last;
        }
    }

	#IP 저장
	local($we) = $ENV{'REMOTE_ADDR'};

	#사망 체크
	if ($hit <=0) {
		$sts = "사망";
	}

    if ($chksts eq "OK") {
        if ($hit <= 0) {
            $userlist[$Index] = "$id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf,\n" ;
        } else {
            $userlist[$Index] = "$id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf,\n" ;
        }
        open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);
    }


}
#====================#
# ■ 敵情報保存      #
#====================#
sub SAVE2 {


    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    if ($w_hit <= 0) { $w_sts = "사망"; }
    $userlist[$Index2] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf,\n" ;

    open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);


}

#====================#
# ■ 쿠키 로드    #
#====================#
sub CREAD {
    $cooks = $ENV{'HTTP_COOKIE'};
    $cooks =~ s/BattleRoyale=//;
    $cooks =~ s/([0-9A-Fa-f][0-9A-Fa-f])/pack("C", hex($1))/eg;
	($c_id,$c_password,$c_f_name,$c_l_name,$c_sex,$c_cl,$c_no,$c_endtime,$c_att,$c_def,$c_hit,$c_mhit,$c_level,$c_exp,$c_sta,$c_wep,$c_watt,$c_wtai,$c_bou,$c_bdef,$c_btai,$c_bou_h,$c_bdef_h,$c_btai_h,$c_bou_f,$c_bdef_f,$c_btai_f,$c_bou_a,$c_bdef_a,$c_btai_a,$c_tactics,$c_death,$c_msg,$c_sts,$c_pls,$c_kill,$c_icon,$c_item[0],$c_eff[0],$c_itai[0],$c_item[1],$c_eff[1],$c_itai[1],$c_item[2],$c_eff[2],$c_itai[2],$c_item[3],$c_eff[3],$c_itai[3],$c_item[4],$c_eff[4],$c_itai[4],$c_item[5],$c_eff[5],$c_itai[5],$c_log,$c_dmes,$c_bid,$c_club,$c_wn,$c_wp,$c_wa,$c_wg,$c_host,$c_wc,$c_wd,$c_wb,$c_wf,$c_ws,$c_com,$c_inf) = split(/,/, $cooks);
}

#====================#
# ■ 쿠키 저장    #
#====================#
sub CSAVE {
    $cook = "$id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf,";
    $cook =~ s/(.)/sprintf("%02X", unpack("C", $1))/eg;
    print "Set-Cookie: BattleRoyale=$cook; expires=$expires\n";
}

#====================#
# ■ ?略計算        #
#====================#
sub TACTGET {

    $chkpnt = 5 ;   #적, 아이템 발견율
    $chkpnt2 = 7 ;  #선제공격율
    $atp = 1.00 ;
    $dfp = 1.00 ;

	#기본방침 관련 설정
	if ($tactics eq "공격중시") {
			$atp+=0.4 ;
			$dfp-=0.4 ;
			} 
	elsif ($tactics eq "방어중시") {
			$atp-=0.4 ;
			$dfp+=0.4 ;
			$chkpnt2-=4 ;
			} 
	elsif ($tactics eq "은밀행동") {
			$chkpnt2+=4 ;
			$atp-=0.4 ;
			$dfp-=0.4 ;
			$chkpnt-=4 ;
			} 
	elsif ($tactics eq "탐색행동") {
			$chkpnt2+=4 ;
			$atp-=0.4 ;
			$dfp-=0.4 ;
			$chkpnt+=4 ;
			} 
	elsif ($tactics eq "연속공격") {
			$dfp-=0.4 ;
			$chkpnt+=6 ;
			}

    if ($arsts[$pls] eq "WU") { #공격증가
        $atp+=0.1 ;
    } elsif ($arsts[$pls] eq "WD") {    #공격감소
        $atp-=0.1 ;
    } elsif ($arsts[$pls] eq "DU") {    #방어증가
        $dfp+=0.1 ;
    } elsif ($arsts[$pls] eq "DD") {    #방어감소
        $dfp-=0.1 ;
    } elsif ($arsts[$pls] eq "SU") {    #발견증가
        $chkpnt+=1 ;
    } elsif ($arsts[$pls] eq "SD") {    #발견감소
        $chkpnt-=1 ;
    }

    if ($inf =~ /腕/) { $atp -= 0.2; }

    local($kind) = $w_kind ;
    local($wmei) = 0;
    local($wweps) = "" ;

    if (($kind =~ /B/) || (($kind =~ /G|A/) && ($wtai == 0))) { #棍棒 or ?無し銃 or 矢無し弓
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($wb/$BASE);
    } elsif ($kind =~ /A/) {        #射
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wa/$BASE*2);
    }elsif ($kind =~ /C/) { #投
        $wweps = "L" ;
        $wmei = 70 ;
        $wmei += int($wc/$BASE*1.5);
    }elsif ($kind =~ /D/) { #爆
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wd/$BASE*2);
    }elsif ($kind =~ /G/) { #銃
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wg/$BASE*2);
    }elsif ($kind =~ /N/) { #斬
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($wn/$BASE);
    }elsif ($kind  =~ /S/) {    #刺
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($ws/$BASE);
    } else {    #手
        $wweps = "S" ;
        $wmei = 70 ;
        $wmei += int($wp/$BASE*1.5);
    }

    $weps = $wweps ;
    $mei = $wmei ;

	if ( $wmei > 95 ) { $wmei = 95; }
    if ($inf =~ /頭/) { $mei -= 20; }
}
#====================#
# ■ ?略計算        #
#====================#
sub TACTGET2 {

    $atn = 1.00 ;
    $dfn = 1.00 ;
    $sen = 1.0 ; #발견당할 확율? (높을수록 발견되지 않음)

	if ($w_sts eq "치료") {
		$sen-=0.3;
	}

	#기본 방침 관련 설정
	if ($w_tactics eq "공격중시") {
			$atn+=0.4 ;
			$dfn-=0.4 ;
			} 
	elsif ($w_tactics eq "방어중시") {
			$atn-=0.4 ;
			$dfn+=0.4 ;
			$sen-=0.2 ;
			} 
	elsif ($w_tactics eq "은밀행동") {
			$atn-=0.4 ;
			$dfn-=0.6 ;
			$sen+=0.4 ;
			} 
	elsif ($w_tactics eq "탐색행동") {
			$atn-=0.4 ;
			$dfn-=0.4 ;
			$sen-=0.4 ;
			} 
	elsif ($w_tactics eq "연속공격") {
			$dfn-=0.6 ;
			$sen-=0.3 ;
			}

    if ($arsts[$w_pls] eq "WU") {   #공격증가
        $atn+=0.1 ;
    } elsif ($arsts[$w_pls] eq "WD") {  #공격감소
        $atn-=0.1 ;
    } elsif ($arsts[$w_pls] eq "DU") {  #방어증가
        $dfn+=0.1 ;
    } elsif ($arsts[$w_pls] eq "DD") {  #방어감소
        $dfn-=0.1 ;
    }

    if ($w_inf =~ /腕/) { $atn -= 0.2; }

    local($kind) = $w_kind2 ;
    local($wmei) = 0;
    local($wweps) = "" ;

    if (($kind =~ /B/) || (($kind =~ /G|A/) && ($w_wtai == 0))) { #棍棒 or ?無し銃 or 矢無し弓
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($wb/$BASE);
    } elsif ($kind =~ /A/) {        #射
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wa/$BASE*2);
    }elsif ($kind =~ /C/) { #投
        $wweps = "L" ;
        $wmei = 70 ;
        $wmei += int($wc/$BASE*1.5);
    }elsif ($kind =~ /D/) { #爆
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wd/$BASE*2);
    }elsif ($kind =~ /G/) { #銃
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wg/$BASE*2);
    }elsif ($kind =~ /N/) { #斬
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($wn/$BASE);
    }elsif ($kind  =~ /S/) {    #刺
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($ws/$BASE);
    } else {    #手
        $wweps = "S" ;
        $wmei = 70 ;
        $wmei += int($wp/$BASE*1.5);
    }

    $weps2 = $wweps ;
    $mei2 = $wmei ;

	if ( $wmei > 95 ) { $wmei = 95; }
    if ($w_inf =~ /頭/) { $mei2 -= 20; }
}

#====================#
# ■ スタミナ切れ    #
#====================#
sub DRAIN{
    local($d_mode) = $_[0];
    $log = ($log . "$l_name은(는)\, 스테미너가 바닥났다... 최대 HP가 감소했다.<BR>") ;
    $sta = int(rand($maxsta/10)+($maxsta/4));
	local($dhit) = int(rand($mhit/10)+($mhit/10));
    if ($dhit < 10) { $dhit = 10 ;}
    $mhit -= $dhit;
    if ($mhit <= 0) {
        $hit = $mhit = 0;
        $log = ($log . "<font color=\"red\"><b>$f_name $l_name（$cl $sex$no번）은(는) 사망했다.</b></font><br>") ;
            &LOGSAVE("DEATH") ; #死亡ログ
            $mem--; if ($mem == 1) {&LOGSAVE("WINEND1") ;}
        if($d_mode eq "mov"){
            &SAVE;return;
        }elsif($d_mode eq "eve"){
            $Command = "EVENT";
        }
    } elsif ($hit > $mhit) { $hit = $mhit ; }
}

#=============================#
# ■ ユ?ザ?位のデ?タセ?ブ #
#=============================#
sub u_save{
    local($u_dat) = "$id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf,\n" ;

    open(DB,">$u_save_dir$id$u_save_file"); seek(DB,0,0); print DB $u_dat; close(DB);

    $log = ($log . "세이브는 정상적으로 종료되었습니다.<BR>") ;
    print "<br>　<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>돌아간다<p>\n";
    print "　<INPUT type=\"submit\" name=\"Enter\" value=\"확인\">\n";
    return ;

}

1
