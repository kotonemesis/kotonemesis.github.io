# ���ī��֫�?�����

#==================#
# �� ID�����ë�?��#
#==================#
sub IDCHK {


    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);


    $mem=0;
    $chksts = "NG";
    for ($i=0; $i<$#userlist+1; $i++) {
        ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);
        if ($w_id eq $id2) {    #ID���ȣ�
            if ($w_password eq $password2) {    #�ѫ���?�����ȣ�
                if ($w_hit > 0) {
                    $chksts = "OK";$Index=$i;$mem++;$plsmem[$w_pls]++ ;
                    ($id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf) = split(/,/, $userlist[$i]);

                    &CSAVE;

                    #�Ѽ� �α�
                    open(DB,"$gun_log_file");seek(DB,0,0); @gunlog=<DB>;close(DB);

                    local($guntime,$gunpls,$wid,$wid2,$a) = split(/,/,$gunlog[0]) ;
                    if (($now < ($guntime+(15)))&& ($wid ne $id) && ($wid2 ne $id)) {   #�� ����� �� 15�� �̳�?
                        $jyulog = "<font color=\"yellow\"><b>$gunpls �ʿ���\, �Ѽ��� ��ȴ�...</b></font><br>" ;
                    } else { $jyulog = "" ; }
                    local($guntime,$gunpls,$wid,$wid2,$a) = split(/,/,$gunlog[1]) ;
                    if (($now < ($guntime+(30)))&& ($wid ne $id) && ($wid2 ne $id) && ($place[$pls] eq $gunpls)) {  #���� �� 30�� �̳�?
                        $jyulog2 = "<font color=\"yellow\"><b>��ó���� �����? ������\, ���� ���ΰ�...?</b></font><br>" ;
                    } else { $jyulog2 = "" ; }
                    local($guntime,$gunpls,$wid,$wid2,$a) = split(/,/,$gunlog[2]) ;
                    if (($now < ($guntime+(30)))) { #����Ŀ ��� �� 30�� �̳�?
                        $jyulog3 = "<font color=\"yellow\"><b>$gunpls �ʿ��� $wid�� ��Ҹ��� ��ȴ�...</b></font><br><font color=\"lime\"><b>��$wid2��</b></font><br>" ;
                    } else { $jyulog3 = "" ; }
                } else {
					($id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf) = split(/,/, $userlist[$i]);
                    &CSAVE;
                    &ERROR("�̹� �׾��ֽ��ϴ�.<p>���Σ�$w_death<p><font color=\"lime\"><b>$w_msg</b></font><br>") ;
                }
            } else {
                &ERROR("�н����尡 ���� �ʽ��ϴ�.") ;
            }
        } else {
            if ($w_hit > 0) {
                $plsmem[$w_pls]++ ;
                if ($w_sts ne "NPC0"){ $mem ++ ; }
                }
        }
    }

    if ($chksts eq "NG") {
        &ERROR("���̵� ã�� �� �����ϴ�.") ;
    }

    local($b_limit) = ($battle_limit * 3) + 1;
    if ((($mem == 1) && ($inf =~ /��/))||(($mem == 1) && ($ar > $b_limit))) {    #���?
		require "$ending_file";
		open(FLAG,$end_flag_file) || exit; $fl=<FLAG>; close(FLAG);
		unless ( $fl ) { &LOGSAVE("WINEND1"); &SURVIVORSAVE; }
        open(FLAG,">$end_flag_file"); print(FLAG "����\n"); close(FLAG);
		&ENDING;
    }elsif ($inf =~ /��/){
        require "$ending_file";
        &ENDING;
    }elsif ($fl =~ /����/){
        require "$ending_file";
        &ENDING;
    } else {
        if ($log ne '') {$wlog = $log ;$log="";&SAVE;$log=$wlog;}
        $bid = "" ;
    }
}

#==================#
# �� ����?����ݻ  #
#==================#
sub STS {

    local($watt_2) = 0 ;

    if (($Command ne "INN2")&&($Command ne "HEAL2")) {
        $up = int(($now - $endtime) / (1*$kaifuku_time));
        if ($w_inf =~ /��/) { $up = int($up / 2) ; }
        if ($sts eq "����") {
            $maxp = $maxsta - $sta ;    #�ִ�ġ���� ��
            if ($up > $maxp) { $up = $maxp ; }
            $sta += $up ;
            if ($sta > $maxsta) { $sta = $maxsta ; }
            $log = ($log . "���� ���\, ���׹̳ʰ� $up ȸ�� �Ǿ���.<BR>") ;
            $sts = "����"; $endtime = 0 ;
            &SAVE ;
        } elsif ($sts eq "ġ��") {
            if ($kaifuku_rate == 0){$kaifuku_rate = 1;}
            $up = int($up / $kaifuku_rate) ;
            $maxp = $mhit - $hit ;  #�ִ�ġ���� ��
            if ($up > $maxp) { $up = $maxp ; }
            $hit += $up ;
            if ($hit > $mhit) { $hit = $mhit ; }
            $log = ($log . "ġ�� ���\, ü���� $up ȸ�� �Ǿ���.<BR>") ;
            $sts = "����"; $endtime = 0 ;
            &SAVE ;
        }
    }

    ($w_name,$w_kind) = split(/<>/, $wep);
    ($b_name,$b_kind) = split(/<>/, $bou);

    $levelplusone = $level +1;

    $cln = "$cl$sex$no��" ;

    if (($w_kind =~ /G|A/) && ($wtai == 0)) { #���� or ?���� or ������
        $watt_2 = int($watt/10) ;
    } else {
        $watt_2 = $watt ;
    }

    $ball = $bdef + $bdef_h + $bdef_a + $bdef_f ;
    if ($item[5] =~ /AD/) {$ball += $eff[5];} #?�ު�������

    $kega ="" ;
    if ($inf =~ /��/) {$kega = ($kega . "�Ӹ���") ;}
    if ($inf =~ /��/) {$kega = ($kega . "�ȡ�") ;}
    if ($inf =~ /��/) {$kega = ($kega . "���Ρ�") ;}
    if ($inf =~ /��/) {$kega = ($kega . "�ٸ���") ;}
    if ($kega eq "") { $kega = "��" ;}

print <<"_HERE_";
<P align="center"><B><FONT color="#ff0000" size="+3">$place[$pls] ($area[$pls])</FONT></B><BR>
</P>

<table border=0 cellpadding=1 cellspacing=1>
<tr><td valign=top>

<table border=1 cellpadding=1 cellspacing=0 width=100%>
    <tr>
        <th colspan=3 width=460><center>�������ͽ�</center></th>
    </tr>
    <tr>
        <td width=70 height=70><img src="$imgurl$icon_file[$icon]" width="70" height="70" border="0"></td>
        <td width=160 align=center height=70>$f_name $l_name<br>Lv $level<br>(Lv $levelplusone ���� $exp ����)</td>
        <td width=220 rowspan=8 valign=top>
_HERE_

        print "<table border=0 cellpadding=1 cellspacing=0 width=100%>";
		@tlist = ("����", "���", "�Ӹ�", "��", "�ٸ�", "���");
		@tname = ($wep, $bou, $bou_h, $bou_a, $bou_f, $item[5]);
		@tatt = ($watt, $bdef, $bdef_h, $bdef_a, $bdef_f, $eff[5]);
		@ttai = ($wtai, $btai, $btai_h, $btai_a, $btai_f, $itai[5]);
		@tcol = (lwep, lclo, lclo, lclo, lclo, lclo);

		$i=0;
		foreach $i (0..5) {
			if ($tname[$i] ne "����") {
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
        <td>ü��</td>
        <td><font class=hp>$hit/$mhit</font></td>
    </tr>
    <tr>
        <td>���׹̳�</td>
        <td><font class=sp>$sta/$maxsta</font></td>
    </tr>
    <tr>
        <td>���ݷ�</td>
        <td>$att<font class=wep> + $watt_2</font></td>
    </tr>
    <tr>
        <td>����</td>
        <td>$def<font class=clo> + $ball</font></td>
    </tr>
    <tr>
        <td>Ŭ��</td>
        <td>$club</td>
    </tr>
    <tr>
        <td>�⺻��ħ</td>
        <td>$tactics</td>
    </tr>
    <tr>
        <td>�λ����</td>
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
	print "�ѣ�$p_wg($wg)��Į��$p_wn($wn)�������⣺$p_wc($wc)�������⣺$p_wp($wp)<br>\n";
	print "Ȱ��$p_wa($wa)�������$p_wb($wb)����ź��$p_wd($wd)����⣺$p_ws($ws)<br>\n";

print <<"_HERE_";
		</td>
    </tr>
</table><!--�������ͽ� ���̺� ��//-->

</td><td width=200 height=100% rowspan=2>

<table border=1 cellpadding=1 cellspacing=0 width=100% height=100%>
	<tr>
		<th>Ŀ�ǵ�</th>
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

        print "��<select name=\"Command\">\n" ;
        print "<option value=\"MAIN\" selected>($area[$pls])$place[$pls]\n";
        for ($j=0; $j<$#place+1; $j++) {

            if ($place[$j] ne $place[$pls]) {

			    if(($ar[$war] eq $place[$j])||($ar[$war+1] eq $place[$j])||($ar[$war+2] eq $place[$j])) {
	                $temp[$j] = "2";
            	}
			    else {
					$temp[$j] = "1";
			        for ($i=0; $i<$war; $i++) {

			            if ($ar[$i] eq $place[$j]) {   #��򭫨�ꫢ��
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
        <INPUT type="submit" name="Enter" value="�̵�">
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
</table><!--Ŀ�ǵ� ���̺� ��//-->

</td></tr>
<tr><td height=150 width=350 valign=top>

<table border=1 cellpadding=5 cellspacing=0 width=100% height=100%>
    <tr>
        <td colspan=3 height=100% valign=top style="word-break:break-all">$log</td>
	</tr>
</table><!--�α� ���̺� ��//-->

</td></tr></table><p>

_HERE_
}

#==================#
# �� �ǫ�?��?��  #
#==================#
sub DECODE {
    $p_flag=0;
        if ($ENV{'REQUEST_METHOD'} eq "POST") {
            $p_flag=1;
            if ($ENV{'CONTENT_LENGTH'} > 51200) {
                &ERROR("�̻��� �Է��Դϴ�"); }
            read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
        } else { $buffer = $ENV{'QUERY_STRING'}; }
    @pairs = split(/&/, $buffer);
    foreach (@pairs) {
        ($name,$value) = split(/=/, $_);
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

# Jcode �ּ�ó�� by �縮��
#        &jcode::convert(*value, "euc", "", "z");
#        &jcode::tr(\$value, '��', ' ');

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
        $value =~ s/,/��/g; #��?������?��

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
# �� ��˫�?ݻ    #
#==================#
sub COMMAND {

    local($i) = 0 ;

    if (($Command eq "INN2") || ($Command eq "HEAL2") || ($Command eq "KEIKAI2")) {
        if ($Command eq "HEAL2") {
            $log = ($log . "��ó�� ġ������.<BR>") ;
            $sts = "ġ��" ;
            print "��ġ����...<br>\n";
            &CLOCK;
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"HEAL2\" checked>ġ��<p>\n";
        } else {
            $log = ($log . "���� �ڵѱ�.<BR>") ;
            $sts = "����" ;
            print "��������...<br>\n";
            &CLOCK;
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"INN2\" checked>����<p>\n";
        }
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\">���ư���<p>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
        return ;
    }

    if (($Command eq '')||($Command eq "MAIN")) {   #MAIN
        $log = ($log . "$jyulog$jyulog2$jyulog3��\, �������...<br>") ;
        print "�������� �մϱ�?<p>\n";
        if ($place[$pls] eq "�б�") {
            if ($hackflg == 1) {
                print "��<INPUT type=\"radio\" name=\"Command\" value=\"SEARCH\" checked>Ž��<BR>\n";
            }

			$mcolor = ITEMandDEL;
			&COLOR;

            print "��<INPUT type=\"radio\" name=\"Command\" value=\"ITMAIN\">������ ����/�ռ�/���<BR>\n";
	        print "��<input type=radio name=\"Command\" value=\"OUKYU\">����óġ<BR>\n";
			print "��<INPUT type=\"radio\" name=\"Command\" value=\"SPECIAL\">Ư�� Ŀ�ǵ�<BR>\n";
		} else {
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"SEARCH\" checked>Ž��<BR>\n";

			$mcolor = ITEMandDEL;
			&COLOR;

            print "��<INPUT type=\"radio\" name=\"Command\" value=\"ITMAIN\">������ ����/�ռ�/���<BR>\n";
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"HEAL\"><font class=hp>ġ��</font><BR>\n";
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"INN\"><font class=sp>����</font><BR>\n";
	        print "��<input type=radio name=\"Command\" value=\"OUKYU\">����óġ<BR>\n";
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"SPECIAL\">Ư�� Ŀ�ǵ�<BR>\n";
        }
        print "<BR>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
	}
	elsif ($Command eq "SEIRI") { #�����ƫ�����
        $log = ($log . "�賶 ���� �����ұ�...<BR>") ;
        print "�������� ������ �����ϱ�?<p>\n";
        print "��<select name=\"Command\">\n" ;
        print "��<option value=\"MAIN\" selected>�׸��д�</option>\n";
        for ($i=0; $i<5; $i++) {
            if ($item[$i] ne "����") {
                ($in, $ik) = split(/<>/, $item[$i]);
                print "��<option value=\"SEIRI_$i\">\[$i\]$in/$eff[$i]/$itai[$i]</option>\n";
            }
        }
        print "</select><BR>\n" ;
        print "<BR>\n";
        print "��<select name=\"Command2\">\n" ;
        print "��<option value=\"MAIN\" selected>�׸��д�</option>\n";
        for ($i2=0; $i2<5; $i2++) {
            if ($item[$i2] ne "����") {
                ($in2, $ik2) = split(/<>/, $item[$i2]);
                print "��<option value=\"SEIRI2_$i2\">\[$i2\]$in2/$eff[$i2]/$itai[$i2]</option>\n";
            }
        }
        print "</select><BR>\n" ;
        print "<BR>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "GOUSEI") { #�����ƫ�����
        $log = ($log . "���� ������ �ִ� ���� �����ؼ�\, ���� ���� �� ������?<BR>") ;
        print "�������� ������ �ռ��մϱ�?<p>\n";
        print "��<select name=\"Command\">\n" ;
        print "��<option value=\"MAIN\" selected>�׸��д�</option>\n";
        for ($i=0; $i<5; $i++) {
            if ($item[$i] ne "����") {
                ($in, $ik) = split(/<>/, $item[$i]);
                print "��<option value=\"GOUSEI_$i\">$in/$eff[$i]/$itai[$i]</option>\n";
            }
        }
        print "</select><BR>\n" ;
        print "<BR>\n";
        print "��<select name=\"Command2\">\n" ;
        print "��<option value=\"MAIN\" selected>�׸��д�</option>\n";
        for ($i2=0; $i2<5; $i2++) {
            if ($item[$i2] ne "����") {
                ($in2, $ik2) = split(/<>/, $item[$i2]);
                print "��<option value=\"GOUSEI2_$i2\">$in2/$eff[$i2]/$itai[$i2]</option>\n";
            }
        }
        print "</select><BR>\n" ;
        print "<BR>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "OUKYU") { #?��?��
        $log = ($log . "��ó�� ġ�� �ұ�...<BR>") ;

        print "��� ġ���մϱ�?<p>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>���ư���<p>\n";

        if ($inf =~ /��/) { print "��<INPUT type=\"radio\" name=\"Command\" value=\"OUK_0\">�Ӹ�<BR>\n"; }
        if ($inf =~ /��/) { print "��<INPUT type=\"radio\" name=\"Command\" value=\"OUK_1\">��<BR>\n"; }
        if ($inf =~ /��/) { print "��<INPUT type=\"radio\" name=\"Command\" value=\"OUK_2\">����<BR>\n"; }
        if ($inf =~ /��/) { print "��<INPUT type=\"radio\" name=\"Command\" value=\"OUK_3\">�ٸ�<BR>\n"; }

        print "<BR>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
	} elsif ($Command =~ /BATTLE0/) {   #??���ޫ��
        local($a,$wid) = split(/_/, $Command);
        $log = ($log . "��\, �������...") ;
        print "�������� �մϱ�?<p>\n";
        print "���޽���<BR>\n";
        print "��<INPUT size=\"30\" type=\"text\" name=\"Dengon\" maxlength=\"64\"><p>\n";
        $chk = "checked" ;
        ($w_name,$w_kind) = split(/<>/, $wep);
        if ($w_kind =~ /B/) {print "��<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WB_$wid\" $chk>������($wb)<BR>\n"; $chk="" ;}
        if ($w_kind =~ /P/) {print "��<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WP_$wid\" $chk>������($wp)<BR>\n"; $chk="" ;}
        if (($w_kind =~ /G/) && ($wtai > 0)) {print "��<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WG_$wid\" $chk>���($wg)<BR>\n"; $chk="" ;}
        if (($w_kind =~ /A/) && ($wtai > 0)) {print "��<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WA_$wid\" $chk>���($wa)<BR>\n"; $chk="" ;}
        if ($w_kind =~ /N/) {print "��<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WN_$wid\" $chk>����($wn)<BR>\n"; $chk="" ;}
        if ($w_kind =~ /S/) {print "��<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WS_$wid\" $chk>���($ws)<BR>\n"; $chk="" ;}
        if ($w_kind =~ /C/) {print "��<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WC_$wid\" $chk>������($wc)<BR>\n"; $chk="" ;}
        if ($w_kind =~ /D/) {print "��<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WD_$wid\" $chk>������($wd)<BR>\n"; $chk="" ;}
        if (($w_kind !~ /S|N|C|P|D|B/)&&(($w_kind =~ /G|A/) && ($wtai == 0))) {print "��<INPUT type=\"radio\" name=\"Command\" value=\"ATK_WB_$wid\" $chk>������($wb)<BR>\n"; $chk="" ;}
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"RUNAWAY\">����<BR>\n";
        print "<BR>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "BATTLE2") {   #�����ƫ�?��
        local($itno) = -1;
        for ($i=0; $i<5; $i++) {
            if ($item[$i] eq "����") {
                $itno = $i ;
            }
        }
        print "�������� �����ϱ�?<p>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>���ư���<p>\n";
        print "<INPUT TYPE=\"HIDDEN\" NAME=\"Itno\" VALUE=\"$itno\">\n";
        print "<INPUT TYPE=\"HIDDEN\" NAME=\"WId\" VALUE=\"$w_id\">\n";

        if ($w_wep !~ /�Ǽ�/) { #�����򥣿
            local($in, $ik) = split(/<>/, $w_wep);
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_6\"><font class=wep>$in/$w_watt/$w_wtai</font><BR>\n";
        }
        if ($w_bou !~ /�ӿ�/) { #�����򥣿
            local($in, $ik) = split(/<>/, $w_bou);
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_7\"><font class=clo>$in/$w_bdef/$w_btai</font><BR>\n";
        }
        if ($w_bou_h !~ /����/) { #�����򥣿
            local($in, $ik) = split(/<>/, $w_bou_h);
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_8\"><font class=clo>$in/$w_bdef_h/$w_btai_h</font><BR>\n";
        }
        if ($w_bou_f !~ /����/) { #�����򥣿
            local($in, $ik) = split(/<>/, $w_bou_f);
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_9\"><font class=clo>$in/$w_bdef_f/$w_btai_f</font><BR>\n";
        }
        if ($w_bou_a !~ /����/) { #�����򥣿
            local($in, $ik) = split(/<>/, $w_bou_a);
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_10\"><font class=clo>$in/$w_bdef_a/$w_btai_a</font><BR>\n";
        }

		$mcolor = GET;
		&COLOR;

        print "<BR>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "DEATHGET") {  #��?�����ƫ�?��
        local($itno) = -1;
        for ($i=0; $i<5; $i++) {
            if ($item[$i] eq "����") {
                $itno = $i ;
            }
        }
        print "�������� �����ϱ�?<p>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>���ư���<p>\n";
        print "<INPUT TYPE=\"HIDDEN\" NAME=\"Itno\" VALUE=\"$itno\">\n";
        print "<INPUT TYPE=\"HIDDEN\" NAME=\"WId\" VALUE=\"$w_id\">\n";

        if ($w_wep !~ /�Ǽ�/) { #�����򥣿
            local($in, $ik) = split(/<>/, $w_wep);
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_6\"><font class=wep>$in/$w_watt/$w_wtai</font><BR>\n";
        }
        if ($w_bou !~ /�ӿ�/) { #�����򥣿
            local($in, $ik) = split(/<>/, $w_bou);
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_7\"><font class=clo>$in/$w_bdef/$w_btai</font><BR>\n";
        }
        if ($w_bou_h !~ /����/) { #�����򥣿
            local($in, $ik) = split(/<>/, $w_bou_h);
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_8\"><font class=clo>$in/$w_bdef_h/$w_btai_h</font><BR>\n";
        }
        if ($w_bou_f !~ /����/) { #�����򥣿
            local($in, $ik) = split(/<>/, $w_bou_f);
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_9\"><font class=clo>$in/$w_bdef_f/$w_btai_f</font><BR>\n";
        }
        if ($w_bou_a !~ /����/) { #�����򥣿
            local($in, $ik) = split(/<>/, $w_bou_a);
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_10\"><font class=clo>$in/$w_bdef_a/$w_btai_a</font><BR>\n";
        }

		$mcolor = GET;
		&COLOR;

        print "<BR>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "POISON") {    #Ըڪ����
        $log = ($log . "�� $doku��(��) ������... ������.<BR>") ;
        print "������ $doku2��(��) �����ϱ�?<p>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>���ư���<p>\n";
        for ($i=0; $i<5; $i++) {
            if ($item[$i] =~ /<>SH|<>HH|<>SD|<>HD/) {
                local($in, $ik) = split(/<>/, $item[$i]);
                print "��<INPUT type=\"radio\" name=\"Command\" value=\"POI_$i\">$in/$eff[$i]/$itai[$i]<BR>\n";
            }
        }
        print "<BR>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "PSCHECK") {   #Ը̸
        $log = ($log . "������ �������� ������ �����غ���...<BR>") ;
        print "�������� �����մϱ�?<p>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>���ư���<p>\n";
        for ($i=0; $i<5; $i++) {
            if ($item[$i] =~ /<>SH|<>HH|<>SD|<>HD/) {
                local($in, $ik) = split(/<>/, $item[$i]);
                print "��<INPUT type=\"radio\" name=\"Command\" value=\"PSC_$i\">$in/$eff[$i]/$itai[$i]<BR>\n";
            }
        }
        print "<BR>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "SPIICH") { #��?����?������
        $log = ($log . "Ȯ���⸦ �Ἥ\, ��ο��� �޽����� ���Ѵ�.<BR>") ;
        print "���̰��� ����ϸ�\, ��ο��� �鸮����...<BR>\n";
        print "��(�ѱ� 20�ڱ���)<p>\n";
        print "��<INPUT size=\"30\" type=\"text\" name=\"speech\"maxlength=\"50\"><p>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"SPEAKER\" checked>���Ѵ�<BR>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\">�׸��д�<p>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "WINCHG") {    #Ϣ��?��
        $log = ($log . "���ؽ�\, ������� ��縦 �����մϴ�.<BR>") ;
        print "����縦 �Է��� �ּ���.<BR>\n";
        print "��(�ѱ� 32�ڱ���)<p>\n";
        print "�����ؽ� :<BR>\n";
        print "��<INPUT size=\"24\" type=\"text\" name=\"Message\" maxlength=\"64\" value=\"$msg\"><p>\n";
        print "������ :<BR>\n";
        print "��<INPUT size=\"24\" type=\"text\" name=\"Message2\" maxlength=\"64\" value=\"$dmes\"><p>\n";
        print "���Ѹ��� �ڸ�Ʈ :<BR>\n";
        print "��<INPUT size=\"24\" type=\"text\" name=\"Comment\" maxlength=\"64\" value=\"$com\"><p>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "ITMAIN") {    #������
        $log = ($log . "�賶 �ȿ���\, ���� ��� ������...<BR>") ;
        print "�������� �մϱ�?<p>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>���ư���<p>\n";
#        print "��<INPUT type=\"radio\" name=\"Command\" value=\"ITEM\">������ ��롤���<BR>\n";
#        print "��<INPUT type=\"radio\" name=\"Command\" value=\"DEL\">������ ������<BR>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"SEIRI\">������ ����<BR>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"GOUSEI\">������ �ռ�<BR>\n";
        if ($wep ne "�Ǽ�<>WP") {
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"WEPDEL\">��񹫱⸦ ���´�<BR>\n";
            print "��<INPUT type=\"radio\" name=\"Command\" value=\"WEPDEL2\">��񹫱⸦ ������<BR>\n";
        }
        print "<BR>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "SPECIAL") {   #Ư��
        $log = ($log . "Ư�� Ŀ�ǵ��Դϴ�.<BR>") ;
        print "�������� �մϱ�?<p>\n";
        print "��<input type=radio name=\"Command\" value=\"MAIN\" checked>���ư���<p>\n";
#        print "��<input type=radio name=\"Command\" value=\"DEFCHK\">���Ȯ��<BR>\n";
#        print "��<input type=radio name=\"Command\" value=\"WEPPNT\">���÷���Ȯ��<BR>\n";
		print "���⺻��ħ ����<BR>\n";
		print "��<INPUT type=\"radio\" name=\"Command\" value=\"KOU_0\">����<BR>\n";
		print "��<INPUT type=\"radio\" name=\"Command\" value=\"KOU_1\">�����߽�<BR>\n";
		print "��<INPUT type=\"radio\" name=\"Command\" value=\"KOU_2\">����߽�<BR>\n";
		print "��<INPUT type=\"radio\" name=\"Command\" value=\"KOU_3\">�����ൿ<BR>\n";
		print "��<INPUT type=\"radio\" name=\"Command\" value=\"KOU_4\">Ž���ൿ<BR>\n";
		print "��<INPUT type=\"radio\" name=\"Command\" value=\"KOU_5\">���Ӱ���<p>\n";
#		print "��<input type=radio name=\"Command\" value=\"KOUDOU\">�⺻��ħ ����<BR>\n";
        print "��<input type=radio name=\"Command\" value=\"WINCHG\">��� ����<BR>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"USRSAVE\">���̺�<BR>\n";
        if ($club eq "�丮��" ) { print "��<INPUT type=\"radio\" name=\"Command\" value=\"PSCHECK\">�� ����<BR>\n"; }
        for ($poi=0; $poi<5; $poi++){
            if ($item[$poi] eq "����<>Y") {
                print "��<input type=radio name=\"Command\" value=\"POISON\">�� ����<BR>\n";
                last;
            }
        }
#        for ($spi=0; $spi<5; $spi++){
#            if ($item[$spi] eq "Ȯ����<>Y") {
#                print "��<input type=radio name=\"Command\" value=\"SPIICH\">Ȯ���� ���<BR>\n";
#                last;
#            }
#        }
        for ($paso=0; $paso<5; $paso++){
            if ($item[$paso] eq "�����PC<>Y") {
                print "��<input type=radio name=\"Command\" value=\"HACK\">��ŷ<BR>\n";
                last;
            }
        }

        print "<p>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    } elsif ($Command eq "USRSAVE") {   #��?����?������
        &u_save;
    } else {
        print "�������� �մϱ�?<p>\n";
        print "��<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>���ư���<p>\n";
        print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    }


}
#====================#
# �� ��?����������  #
#====================#
sub SAVE {

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    $chksts = "NG";
    for ($i=0; $i<$#userlist+1; $i++) {
        ($w_i,$w_p,$a) = split(/,/, $userlist[$i]);
        if (($id2 eq $w_i) && ($password2 eq $w_p)) {   #ID���ȣ�
            $chksts = "OK";$Index=$i;last;
        }
    }

	#IP ����
	local($we) = $ENV{'REMOTE_ADDR'};

	#��� üũ
	if ($hit <=0) {
		$sts = "���";
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
# �� ����������      #
#====================#
sub SAVE2 {


    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    if ($w_hit <= 0) { $w_sts = "���"; }
    $userlist[$Index2] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf,\n" ;

    open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);


}

#====================#
# �� ��Ű �ε�    #
#====================#
sub CREAD {
    $cooks = $ENV{'HTTP_COOKIE'};
    $cooks =~ s/BattleRoyale=//;
    $cooks =~ s/([0-9A-Fa-f][0-9A-Fa-f])/pack("C", hex($1))/eg;
	($c_id,$c_password,$c_f_name,$c_l_name,$c_sex,$c_cl,$c_no,$c_endtime,$c_att,$c_def,$c_hit,$c_mhit,$c_level,$c_exp,$c_sta,$c_wep,$c_watt,$c_wtai,$c_bou,$c_bdef,$c_btai,$c_bou_h,$c_bdef_h,$c_btai_h,$c_bou_f,$c_bdef_f,$c_btai_f,$c_bou_a,$c_bdef_a,$c_btai_a,$c_tactics,$c_death,$c_msg,$c_sts,$c_pls,$c_kill,$c_icon,$c_item[0],$c_eff[0],$c_itai[0],$c_item[1],$c_eff[1],$c_itai[1],$c_item[2],$c_eff[2],$c_itai[2],$c_item[3],$c_eff[3],$c_itai[3],$c_item[4],$c_eff[4],$c_itai[4],$c_item[5],$c_eff[5],$c_itai[5],$c_log,$c_dmes,$c_bid,$c_club,$c_wn,$c_wp,$c_wa,$c_wg,$c_host,$c_wc,$c_wd,$c_wb,$c_wf,$c_ws,$c_com,$c_inf) = split(/,/, $cooks);
}

#====================#
# �� ��Ű ����    #
#====================#
sub CSAVE {
    $cook = "$id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf,";
    $cook =~ s/(.)/sprintf("%02X", unpack("C", $1))/eg;
    print "Set-Cookie: BattleRoyale=$cook; expires=$expires\n";
}

#====================#
# �� ?��ͪߩ        #
#====================#
sub TACTGET {

    $chkpnt = 5 ;   #��, ������ �߰���
    $chkpnt2 = 7 ;  #����������
    $atp = 1.00 ;
    $dfp = 1.00 ;

	#�⺻��ħ ���� ����
	if ($tactics eq "�����߽�") {
			$atp+=0.4 ;
			$dfp-=0.4 ;
			} 
	elsif ($tactics eq "����߽�") {
			$atp-=0.4 ;
			$dfp+=0.4 ;
			$chkpnt2-=4 ;
			} 
	elsif ($tactics eq "�����ൿ") {
			$chkpnt2+=4 ;
			$atp-=0.4 ;
			$dfp-=0.4 ;
			$chkpnt-=4 ;
			} 
	elsif ($tactics eq "Ž���ൿ") {
			$chkpnt2+=4 ;
			$atp-=0.4 ;
			$dfp-=0.4 ;
			$chkpnt+=4 ;
			} 
	elsif ($tactics eq "���Ӱ���") {
			$dfp-=0.4 ;
			$chkpnt+=6 ;
			}

    if ($arsts[$pls] eq "WU") { #��������
        $atp+=0.1 ;
    } elsif ($arsts[$pls] eq "WD") {    #���ݰ���
        $atp-=0.1 ;
    } elsif ($arsts[$pls] eq "DU") {    #�������
        $dfp+=0.1 ;
    } elsif ($arsts[$pls] eq "DD") {    #����
        $dfp-=0.1 ;
    } elsif ($arsts[$pls] eq "SU") {    #�߰�����
        $chkpnt+=1 ;
    } elsif ($arsts[$pls] eq "SD") {    #�߰߰���
        $chkpnt-=1 ;
    }

    if ($inf =~ /��/) { $atp -= 0.2; }

    local($kind) = $w_kind ;
    local($wmei) = 0;
    local($wweps) = "" ;

    if (($kind =~ /B/) || (($kind =~ /G|A/) && ($wtai == 0))) { #���� or ?���� or ������
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($wb/$BASE);
    } elsif ($kind =~ /A/) {        #��
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wa/$BASE*2);
    }elsif ($kind =~ /C/) { #��
        $wweps = "L" ;
        $wmei = 70 ;
        $wmei += int($wc/$BASE*1.5);
    }elsif ($kind =~ /D/) { #��
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wd/$BASE*2);
    }elsif ($kind =~ /G/) { #��
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wg/$BASE*2);
    }elsif ($kind =~ /N/) { #��
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($wn/$BASE);
    }elsif ($kind  =~ /S/) {    #�
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($ws/$BASE);
    } else {    #�
        $wweps = "S" ;
        $wmei = 70 ;
        $wmei += int($wp/$BASE*1.5);
    }

    $weps = $wweps ;
    $mei = $wmei ;

	if ( $wmei > 95 ) { $wmei = 95; }
    if ($inf =~ /��/) { $mei -= 20; }
}
#====================#
# �� ?��ͪߩ        #
#====================#
sub TACTGET2 {

    $atn = 1.00 ;
    $dfn = 1.00 ;
    $sen = 1.0 ; #�߰ߴ��� Ȯ��? (�������� �߰ߵ��� ����)

	if ($w_sts eq "ġ��") {
		$sen-=0.3;
	}

	#�⺻ ��ħ ���� ����
	if ($w_tactics eq "�����߽�") {
			$atn+=0.4 ;
			$dfn-=0.4 ;
			} 
	elsif ($w_tactics eq "����߽�") {
			$atn-=0.4 ;
			$dfn+=0.4 ;
			$sen-=0.2 ;
			} 
	elsif ($w_tactics eq "�����ൿ") {
			$atn-=0.4 ;
			$dfn-=0.6 ;
			$sen+=0.4 ;
			} 
	elsif ($w_tactics eq "Ž���ൿ") {
			$atn-=0.4 ;
			$dfn-=0.4 ;
			$sen-=0.4 ;
			} 
	elsif ($w_tactics eq "���Ӱ���") {
			$dfn-=0.6 ;
			$sen-=0.3 ;
			}

    if ($arsts[$w_pls] eq "WU") {   #��������
        $atn+=0.1 ;
    } elsif ($arsts[$w_pls] eq "WD") {  #���ݰ���
        $atn-=0.1 ;
    } elsif ($arsts[$w_pls] eq "DU") {  #�������
        $dfn+=0.1 ;
    } elsif ($arsts[$w_pls] eq "DD") {  #����
        $dfn-=0.1 ;
    }

    if ($w_inf =~ /��/) { $atn -= 0.2; }

    local($kind) = $w_kind2 ;
    local($wmei) = 0;
    local($wweps) = "" ;

    if (($kind =~ /B/) || (($kind =~ /G|A/) && ($w_wtai == 0))) { #���� or ?���� or ������
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($wb/$BASE);
    } elsif ($kind =~ /A/) {        #��
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wa/$BASE*2);
    }elsif ($kind =~ /C/) { #��
        $wweps = "L" ;
        $wmei = 70 ;
        $wmei += int($wc/$BASE*1.5);
    }elsif ($kind =~ /D/) { #��
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wd/$BASE*2);
    }elsif ($kind =~ /G/) { #��
        $wweps = "L" ;
        $wmei = 60 ;
        $wmei += int($wg/$BASE*2);
    }elsif ($kind =~ /N/) { #��
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($wn/$BASE);
    }elsif ($kind  =~ /S/) {    #�
        $wweps = "S" ;
        $wmei = 80 ;
        $wmei += int($ws/$BASE);
    } else {    #�
        $wweps = "S" ;
        $wmei = 70 ;
        $wmei += int($wp/$BASE*1.5);
    }

    $weps2 = $wweps ;
    $mei2 = $wmei ;

	if ( $wmei > 95 ) { $wmei = 95; }
    if ($w_inf =~ /��/) { $mei2 -= 20; }
}

#====================#
# �� �����߫�﷪�    #
#====================#
sub DRAIN{
    local($d_mode) = $_[0];
    $log = ($log . "$l_name��(��)\, ���׹̳ʰ� �ٴڳ���... �ִ� HP�� �����ߴ�.<BR>") ;
    $sta = int(rand($maxsta/10)+($maxsta/4));
	local($dhit) = int(rand($mhit/10)+($mhit/10));
    if ($dhit < 10) { $dhit = 10 ;}
    $mhit -= $dhit;
    if ($mhit <= 0) {
        $hit = $mhit = 0;
        $log = ($log . "<font color=\"red\"><b>$f_name $l_name��$cl $sex$no������(��) ����ߴ�.</b></font><br>") ;
            &LOGSAVE("DEATH") ; #���̫�
            $mem--; if ($mem == 1) {&LOGSAVE("WINEND1") ;}
        if($d_mode eq "mov"){
            &SAVE;return;
        }elsif($d_mode eq "eve"){
            $Command = "EVENT";
        }
    } elsif ($hit > $mhit) { $hit = $mhit ; }
}

#=============================#
# �� ��?��?�ȪΫ�?����?�� #
#=============================#
sub u_save{
    local($u_dat) = "$id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf,\n" ;

    open(DB,">$u_save_dir$id$u_save_file"); seek(DB,0,0); print DB $u_dat; close(DB);

    $log = ($log . "���̺�� ���������� ����Ǿ����ϴ�.<BR>") ;
    print "<br>��<INPUT type=\"radio\" name=\"Command\" value=\"MAIN\" checked>���ư���<p>\n";
    print "��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n";
    return ;

}

1
