#!/usr/bin/perl

#require "jcode.pl";
require "br.pl";
require "$lib_file";
require "$lib_file2";
&LOCK;
require "$pref_file";

&DECODE;

if ($mode eq "regist") { &REGIST; }
elsif ($mode eq "info") { &INFO; }
elsif ($mode eq "info2") { &INFO2; }
else { &MAIN; }
&UNLOCK;
exit;

#===============#
# �� ����       #
#===============#
sub MAIN {
    if(($limit == "")||($limit == 0)){ $limit = 7; }
    local($t_limit) = ($limit * 3) + 1;

    if (($fl =~ /����/)||($ar >= $t_limit)){
        &ERROR("���α׷��� ������ ����Ǿ����ϴ�.<p>���� ���α׷� ������ ��ٷ��ּ���.") ;
    }

	#��������Ʈ �ε�
    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    if ($npc_mode){
        if (($userlist - $npc_num) >= $maxmem) {    #�ִ��ο� �ʰ�?
            &ERROR("�˼��մϴٸ�, ����($maxmem��) �����Դϴ�.") ;
        }
    }else{
        if ($#userlist >= $maxmem) {    #�ִ��ο� �ʰ�?
            &ERROR("�˼��մϴٸ�, ����($maxmem��) �����Դϴ�.") ;
        }
    }

	#��Ű �ε� (���̵�, �н�����, �̸�, IP), �÷��̾� ���� IP �ε�
	&CREAD;
	$host = $ENV{'REMOTE_ADDR'};

	#��Ű IP, ���� IP�� ���� ����Ʈ�� �� ���� IP�� ������� �ʾҴٸ� �ߺ�.
	#����ߴٸ�, ���� ���Ͽ��� �̸����� �˻� -> ����ð� ��� �� 2�ð� �������� üũ.
	$i=0;
	foreach $i (0..$#userlist) {
		($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);
		if (($w_we eq $c_host) || ($w_we eq $host) || (($w_f_name eq $c_f_name) && ($w_l_name eq $c_l_name))) {
			if ( $w_sts ne "���" ) {
				unless ( ($c_id =~ /$a_id/) && ($a_pass eq $c_password) ) {
					&ERROR("ĳ������ �ߺ������ �����Ǿ� �ֽ��ϴ�. �����ڿ��� �����ϼ���.");
				}
			}
			else {
				$de_f_name = $w_f_name;
				$de_l_name = $w_l_name;
			}
		}
    }
	if ($de_f_name && $de_l_name) {
		open(DB,"$log_file") || exit; seek(DB,0,0); @loglist=<DB>; close(DB);
		$i=0;
		foreach $i (0..$#loglist) {
			($gettime,$l_f_name,$l_l_name,$a,$a,$a,$a,$a,$a,$a,$a,$getkind,$l_host)= split(/,/, $loglist[$i]);
			if (($l_f_name eq $de_f_name) && ($l_l_name eq $de_l_name) && ($getkind =~ /DEATH/)) {
				$chktim = $gettime + (1*60*60*2);
				last;
			}
		}
		($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($chktim);
		$year+=1900; $month++;

		if ($chktim > $now) {   # ����� 2�ð� ����ߴ��� üũ
			&ERROR("ĳ���Ͱ� ����� ��, 2�ð��� ������ ������ �� �ֽ��ϴ�.<p>��ϰ��ɽð���$year/$month/$mday $hour:$min:$sec");
		}
	}


print "Cache-Control: no-cache\n";
print "Pragma: no-cache\n";
print "Content-type: text/html\n\n";
print <<"_HERE_";
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=euc-kr">
<title>$game</title>
<link rel="stylesheet" type="text/css" href="br.css">
<script language="JavaScript">
	function ch()
	{	
		if (document.wrt.Icon.value!="")
			document.im.src="$imgurl"+document.wrt.Icon.value+".jpg";
		else
			document.im.src="$imgurl"+"noname.gif";
	}
</script>
</HEAD>
<BODY onLoad="ch(); document.wrt.F_Name.focus()">
<CENTER>

<P align="center"><B><FONT color=\"#ff0000\" size=\"+3\">���м���</FONT></B><BR><BR>
<BR>
���װ� ���л�����? ���� �����Դϴ�.<BR>
�л������״�,�����ڸ������ �Ҹ��� �ְ�.<BR>
��, �������� �̾߱� �߱�.<BR>
<BR>
��¶��, ���⿡ �̸���, ������ �Ἥ,<BR>
������ �ٷ�?</P>
<br>

<CENTER>

<table cellpadding=10 cellspacing=0 bgcolor=E0E0E0 border=1>
<tr><td style="color:000000">

<center><font size=4>���� ��û��</font></center><p>

<table cellpadding=2 cellspacing=0 border=1 width=310 align=center>
<tr>
<FORM METHOD="POST" ACTION="$regist_file" name="wrt">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="regist">

<td style="color:000000" width=60>��(��)</td>
<td><INPUT size="16" type="text" name="F_Name" maxlength="16"></td>

<td rowspan=3 align=center width=100><img src="" name="im" width="70" height="70"><br>

_HERE_
    print "<SELECT onchange=ch()\; name=\"Icon\">\n";
    print "<OPTION value=\"\" selected>- �� �� -</OPTION>\n";
    for ($i=0;$i<$#icon_file + 1;$i++){
	    print "<OPTION value=\"$i\">$icon_name[$i]</OPTION>\n";
    }
    print "</SELECT>\n";
print <<"_HERE_";

</td>
</tr>

<tr><td style="color:000000">�� ��</td>
<td><INPUT size="16" type="text" name="L_Name" maxlength="16"></td></tr>

<tr><td style="color:000000">����</td>
<td><SELECT name="Sex">
<OPTION value="NOSEX" selected>- ���� -</OPTION>
<OPTION value="����">����</OPTION>
<OPTION value="����">����</OPTION>
</SELECT>
</td></tr>
</table>

<table width=310><tr><td style="color:000000">
<font class=9>���̸��� �ѱ��̳� �Ϻ� �̸�����, ���� �Ǵ� �ѱ۷� �� �ּ���. ���ݽ� ���ó���մϴ�.</font><br>
_HERE_
	print "<a href=# onclick=\"window.open(\'$iprefile\',\'Icon\',\'resizable=yes width=550 height=550\')\;return false\">��ü ������ ����</a>";
print <<"_HERE_";
</td></tr></table><br>

<table cellpadding=2 cellspacing=0 border=1 width=310 align=center>
<tr><td style="color:000000" width=60>���̵�</td><td><INPUT size="8" type="text" name="Id" maxlength="8"></td>
<td style="color:000000" width=60>�н�����</td><td><INPUT size="8" type="text" name="Password" maxlength="8"></td></tr>
</table>

<table width=310><tr><td style="color:000000">
<font class=9>�����ӽÿ� ����ϴ� ���̵�� �н������Դϴ�.</font>
</td></tr></table><br>

<table cellpadding=2 cellspacing=0 border=1 width=310 align=center>
<tr><td style="color:000000" width=60>���</td><td colspan=3><INPUT size="32" type="text" name="Message" maxlength="64"></td></tr>
<tr><td style="color:000000" width=60>����</td><td colspan=3><INPUT size="32" type="text" name="Message2" maxlength="64"></td></tr>
<tr><td style="color:000000" width=60>�ڱ����</td><td colspan=3><INPUT size="32" type="text" name="Comment" maxlength="64"></td></tr>
</table>

<table width=310><tr><td style="color:000000">
<font class=9>�ش�� : ���ؽ��� ���, ���� : ����� ���,<br>�ڱ���� : ������ ����Ʈ�� ������ �ڸ�Ʈ.</font>
</td></tr></table><br>

<center><INPUT type="submit" name="Enter" value="������">��<INPUT type="reset" name="Reset" value="���� ����"></center><BR>

</td></FORM></tr></table><p>

</center>

_HERE_

&FOOTER;

}
#==================#
# �� ��� ó��     #
#==================#
sub REGIST {
	#�Է����� üũ
	if ($f_name2 eq '') { &ERROR("���� �Է��� �ּ���.") ; }
	elsif (length($f_name2) > 8) { &ERROR("���� ���ڼ��� ������ �Ѿ����ϴ�. (4���ڱ���)") ; }
	elsif ((grep /[a-z]|[A-Z]|[0-9]/, $f_name2) == 1) { &ERROR("�̸��� ������ ����� �� �����ϴ�. (�ѱ� 4���ڱ���)") ; }
	elsif ($f_name2 =~ /\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\=|\\|\_|\+|\||\[|\]|\{|\}|\;|\:|\'|\"|\,|\.|\<|\>|\/|\?/) { &ERROR("���� ���������ڰ� ����ֽ��ϴ�.") ; }
	elsif ($l_name2 eq '') { &ERROR("�̸��� �Է��� �ּ���.") ; }
	elsif (length($l_name2) > 8) { &ERROR("�̸��� ���ڼ��� ������ �Ѿ����ϴ�. (4���ڱ���)") ; }
	elsif ((grep /[a-z]|[A-Z]|[0-9]/, $l_name2) == 1) { &ERROR("�̸��� ������ ����� �� �����ϴ�. (�ѱ� 4���ڱ���)") ; }
	elsif ($l_name2 =~ /\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\=|\\|\_|\+|\||\[|\]|\{|\}|\;|\:|\'|\"|\,|\.|\<|\>|\/|\?/) { &ERROR("�̸��� ���������ڰ� ����ֽ��ϴ�.") ; }
	elsif ($sex2 eq "NOSEX") { &ERROR("������ ������ �ּ���.") ; }
	elsif ($icon2 eq "") { &ERROR("�������� ������ �ּ���.") ; }
	elsif (length($id2) > 8) { &ERROR("ID�� ���ڼ��� ������ �Ѿ����ϴ�. (������ 8���ڱ���)") ; }
	elsif ($id2 eq '') { &ERROR("ID�� �Էµ��� �ʾҽ��ϴ�.") ; }
	elsif ((grep /[a-z]|[A-Z]|[0-9]/, $id2) == 0) { &ERROR("ID�� ������ ���ڸ� ����� �ּ���. (������ 8���ڱ���)") ; }
	elsif ($id2 =~ /\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\=|\\|\_|\+|\||\[|\]|\{|\}|\;|\:|\'|\"|\,|\.|\<|\>|\/|\?/) { &ERROR("ID�� ���������ڰ� ����ֽ��ϴ�.") ; }
	elsif ($password2 eq '') { &ERROR("�н����尡 �Էµ��� �ʾҽ��ϴ�.") ; }
	elsif (length($password2) > 8) { &ERROR("�н������� ���ڼ��� ������ �Ѿ����ϴ�. (������ 8���ڱ���)") ; }
	elsif ((grep /[a-z]|[A-Z]|[0-9]/, $password2) == 0) { &ERROR("�н������ ������ ���ڸ� ����� �ּ���. (������ 8���ڱ���)") ; }
    elsif ($password2 =~ /\_|\,|\;|\<|\>|\(|\)|&|\/|\./) { &ERROR("�н����忡 ���������ڰ� ����ֽ��ϴ�.") ; }
    elsif ($id2 eq $password2) { &ERROR("ID�� ���� ���ڿ��� �н������ ����� �� �����ϴ�.") ; }
	elsif (length($msg2) > 64) { &ERROR("����� ���ڼ��� ������ �Ѿ����ϴ�. (�ѱ� 32���ڱ���)") ; }
	elsif (length($dmes2) > 64) { &ERROR("������ ���ڼ��� ������ �Ѿ����ϴ�. (�ѱ� 32���ڱ���)") ; }
	elsif (length($com2) > 64) { &ERROR("�ڱ������ ���ڼ��� ������ �Ѿ����ϴ�. (�ѱ� 32���ڱ���)") ; }
    elsif ($icon_check){
        if(($sex2 =~ /����/)&&($icon2 >= $icon_check )) { &ERROR("������ �ٸ� �������� �����߽��ϴ�.") ; }
        elsif(($sex2 =~ /����/)&&($icon2 < $icon_check )){ &ERROR("������ �ٸ� �������� �����߽��ϴ�.") ; }
    }

    #���� ���� ���
    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    #��������, ���� ���̵� üũ
    foreach $userlist(@userlist) {
        ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist);
		if ($id2 eq $w_id) { #���� ���̵�
			&ERROR("���� ���̵��� ĳ���Ͱ� �̹� �����մϴ�.");
		}
		elsif (($f_name2 eq $w_f_name)&&($l_name2 eq $w_l_name)) { #����
			&ERROR("���� �̸��� ĳ���Ͱ� �̹� �����մϴ�.");
		}
    }

    #���޹��� ����
    open(DB,"$wep_file") || exit; seek(DB,0,0); @weplist=<DB>; close(DB);

    #���ι�ǰ ����
    open(DB,"$stitem_file") || exit; seek(DB,0,0); @stitemlist=<DB>; close(DB);

    #�л� ��ȣ ����
    open(DB,"$member_file") || exit; seek(DB,0,0); $memberlist=<DB>; close(DB);
    ($m,$f,$mc,$fc) = split(/,/, $memberlist);

    #���� �ο� üũ
    if ($sex2 eq "����") {
        if ($mc >= $clmax) { #��� �Ұ���?
            &ERROR("���л��� �� �̻� ����� �� �����ϴ�.") ;
        }
        $m+=1;$no=$m;$cl=$clas[$mc];
        if ($m >= $manmax) {    #Ŭ���� ���ΰ�ħ
            $m=0;$mc+=1;
        }
    } else {
        if ($fc >= $clmax) { #��� �Ұ���?
            &ERROR("���л��� �� �̻� ����� �� �����ϴ�.") ;
        }
        $f+=1;$no=$f;$cl=$clas[$fc];
        if ($f >= $manmax) {    #Ŭ���� ���ΰ�ħ
            $f=0;$fc+=1;
        }
    }

    #�л� ��ȣ ���� ���ΰ�ħ
    $memberlist="$m,$f,$mc,$fc,\n" ;
    open(DB,">$member_file"); seek(DB,0,0); print DB $memberlist; close(DB);

    #�ʱ�������� ����Ʈ ���
    $index = int(rand($#weplist));
    ($w_wep,$w_att,$w_tai) = split(/,/, $weplist[$index]);

    #���� ��ǰ ������ ����Ʈ ���
    $index = int(rand($#stitemlist));
    local($st_item,$st_eff,$st_tai) = split(/,/, $stitemlist[$index]);

    #����ǰ �ʱ�ȭ
    for ($i=0; $i<6; $i++) {
        $item[$i] = "����"; $eff[$i]=$itai[$i]=0;
    }

    #�ʱ�ɷ�
    $att = int(rand(5)) + 8 ;
    $def = int(rand(5)) + 8 ;
    $hit = int(rand(20)) + 90 ;
    $mhit = $hit ;
    $kill=0;
    $sta = $maxsta ;
    $level=1; $exp = $baseexp+$lvinc*$level;
    $death = $msg = "";
    $sts = "����"; $pls=0;
    $tactics = "����" ;
    $endtime = 0 ;
    $log = "";
    $dmes = "" ; $bid = "" ; $inf = "" ;

    #�ʱ� ������&�ʱ��������
    $item[0] = "��<>SH"; $eff[0] = 20; $itai[0] = 2;
    $item[1] = "��<>HH"; $eff[1] = 20; $itai[1] = 2;
    $item[2] = $w_wep; $eff[2] = $w_att; $itai[2] = $w_tai;

    $wep = "�Ǽ�<>WP";
    $watt = 0;
    $wtai = "��" ;

    if ($sex2 eq "����" ) {
        $bou = "����<>DBN";
    } else {
        $bou = "����<>DBN";
    }
    $bdef = 5;
    $btai = 30;

    $bou_h = $bou_f = $bou_a = "����" ;
    $bdef_h = $bdef_f = $bdef_a = 0;
    $btai_h = $btai_f = $btai_a = 0 ;

    #ź �Ǵ� ȭ�� ����
    if ($w_wep =~ /<>WG/) { #?
        $item[3] = "źȯ<>Y"; $eff[3] = 24; $itai[3] = 1;
        $item[4] = $st_item; $eff[4] = $st_eff; $itai[4] = $st_tai;
    } elsif ($w_wep =~ /<>WA/) {    #��
        $item[3] = "ȭ��<>Y"; $eff[3] = 24; $itai[3] = 1;
        $item[4] = $st_item; $eff[4] = $st_eff; $itai[4] = $st_tai;
    } else {
        $item[3] = $st_item; $eff[3] = $st_eff; $itai[3] = $st_tai;
    }

    &CLUBMAKE ; #�� �ۼ�

	# IP Address & Host name ���
	local($we) = $ENV{'REMOTE_ADDR'};
	local($wf) = &GetHostName($ENV{'REMOTE_ADDR'});

    #���� ����
    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    $newuser = "$id2,$password2,$f_name2,$l_name2,$sex2,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg2,$sts,$pls,$kill,$icon2,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$dmes2,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com2,$inf,\n" ;

    #�ű� ���� ���� ���
    push(@userlist,$newuser);
    open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);

    #�ű��߰� �α�
    &LOGSAVE("NEWENT") ;


    $id=$id2; $password=$password2;

    &CSAVE ;    #��Ű ����

&HEADER;

print <<"_HERE_";
<P align="center"><B><FONT color="#ff0000" size="+3">���м��� ����</FONT></B><BR></P>
<TABLE border="1" width="280" cellspacing="0">
  <TBODY>
    <TR>
      <TD width="60">Ŭ����</TD>
      <TD colspan="3" width="113">$cl</TD>
    </TR>
    <TR>
      <TD>��ȣ</TD>
      <TD colspan="3">$sex2$no��</TD>
    </TR>
    <TR>
      <TD>�̸�</TD>
      <TD colspan="3">$f_name2 $l_name2</TD>
    </TR>
    <TR>
      <TD>Ŭ��</TD>
      <TD colspan="3">$club</TD>
    </TR>
    <TR>
      <TD>ü��</TD>
      <TD>$hit/$mhit</TD>
      <TD>���׹̳�</TD>
      <TD>$sta</TD>
    </TR>
    <TR>
      <TD>���ݷ�</TD>
      <TD>$att</TD>
      <TD>����</TD>
      <TD>$def</TD>
    </TR>
  </TBODY>
</TABLE>
<P align="center"><BR>
_HERE_

    if ($sex2 eq "����") {
        print "$f_name2 $l_name2���̱���<BR>\n" ;
    } else {
        print "$f_name2 $l_name2���̱���<BR>\n" ;
    }

print <<"_HERE_";

���� �� ����������, ������ ���п����̾�.<BR>
<BR>
�ð��� ���缭, ���� ���� ��~!<BR><BR>
<A href="$regist_file?mode=info&Id=$id2&Password=$password2"><B><FONT color="#ff0000" size="+2">���п��� ���</FONT></B></A><BR>
</P>
_HERE_
&FOOTER;
}

#==================#
# �� ?٥?��      #
#==================#
sub INFO {

&HEADER;

print <<"_HERE_";
<P align="center"><B><FONT color=\"#ff0000\" size=\"+3\">�������</FONT></B><BR><BR>
���� ����, ���� ���� ���� �־���. �и� ���п��࿡ ���µ�...?<BR>
���¾�, ���п��� ���� ���� �ȿ��� ���ڱ� ������ �ͼ�...��<BR>
������ �ѷ�����, �ٸ� �л��鵵 �ִ� �� ����. �ڼ��� ����, ��� ������ ����̰� ä���� �ִ� ���� ���޾Ҵ�.<BR>
�ڽ��� ���� ������, ������ �ݼ��� ������ ������ �Դ�.<BR>
��ο� ����, �� ���� ����̰� ä���� �־���.<BR>
<BR>
���ڱ�, �տ� ������ �ѻ���� ���ڰ� ���Դ�...<BR><BR>
<BR>
���׷�, �����ϰڽ��ϴ�. ��� ���⿡ ���ԵȰ��� �ٸ��� �ƴ϶�...<BR>
����, �����п��� ���� ���̰� �ϱ� ���ؼ��Դϴ�.<BR>
<BR>
�����ϰų�, �� ����̸� ����ų�, Ż���Ϸ��� �õ��� ���� �� �ڸ����� �״´ٰ� �����Ͻʽÿ�.<BR>
<BR>
��������, ������ "���α׷�" ��� Ŭ������ ���õǾ����ϴ�.<BR>
<BR>
��Ģ�� �����մϴ�. ����, �׿��ָ� �Ǵ°̴ϴ�.<BR>
��Ģ�� �����ϴ�.<BR><BR>
�ƾ�, ���� �ؾ����ϴٸ�, �̰��� ���Դϴ�.<BR>
<BR>
�˰ڽ��ϱ�? ����� �� ���� �б��Դϴ�.<BR>
����, ���⿡�� ��� �����״ϱ�. ��� ��������, ���Ѻ����״ϱ�.<BR>
<BR>
��, ����. ���� ������ ���� ���� ��������ϴ�.<BR>
�׷�����, ���� 0�ÿ�, �� ��ü�� ����� �մϴ�. �Ϸ� �ѹ��̿�.<BR>
<BR>
�ű⼭, �������� ������ �ִ� ������ ����, ��ú��� �� ������ �����ϴ�,<BR>
��� �˷��ݴϴ�.<BR>
������ �� ����, ��ħ�ݰ� ������ ������,<BR>
�ż��� �� ������ ���� �ּ���.<BR>
<BR>
��°���İ� �Ѵٸ�, �� ����̰� �����ϱ� �����Դϴ�.<BR>
<BR>
�˰ڽ��ϱ�. �׷��ϱ�, �ǹ� �ȿ� �־ �ȵǿ�.<BR>
�� �ӿ��� ���� �־ ���Ĵ� ����ϴ�.<BR>
��, �׷��׷�, ������ �迡. �ǹ� �ȿ� ���°��� �����Դϴ�.<BR>
<BR>
��, �׸��� �� �ϳ�. �ð������� �ֽ��ϴ�.<BR>
�˰ڽ��ϱ�, �ð������Դϴ�.<BR>
<BR>
���α׷�������, ���� ����� �׽��ϴٸ�, 3�� ���� ���� ����� �ƹ��� ���ٸ�,<BR>
�װ����� ���Դϴ�. �� ��� ���� �־, ��ǻ�Ͱ� �۵��ؼ�, <BR>
�����ִ� ��� ������ ����̰� �����մϴ�. ����ڴ� �����ϴ�.<BR>
<BR>
��, �׷� �Ѹ�, �� �賶�� ������ ������ ��������.��<BR>
<BR>
<FORM METHOD="POST"  ACTION="$battle_file">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="main">
<INPUT TYPE="HIDDEN" NAME="Id" VALUE="$id2">
<INPUT TYPE="HIDDEN" NAME="Password" VALUE="$password2">
<center>
<INPUT type="submit" name="Enter" value="������ ������">
</center>
</FORM>
_HERE_

&FOOTER;

}

#==================#
# �� ���������    #
#==================#
sub CLUBMAKE {

    $wa=$wg=$wb=$wc=$wd=$ws=$wn=$wp=0 ;

    local($dice) = int(rand(14)) ;

	if ($dice == 0) {
		$club = "�õ���";
		$wa = $BASE*2;
		$wg = $BASE/2;
	}
	elsif ($dice == 1) {
		$club = "��ݺ�";
		$wg = $BASE*2;
		$wa = $BASE/2;
	}
	elsif ($dice == 2) {
		$club = "�˵���";
		$wn = $BASE*2;
		$ws = $BASE/2;
		$wb = $BASE/4;
	}
	elsif ($dice == 3) {
		$club = "��̺�";
		$ws = $BASE*2;
	}
	elsif ($dice == 4) {
		$club = "�±ǵ���";
		$wp = $BASE*2;
	}
	elsif ($dice == 5) {
		$club = "���̺�";
		$wp = $BASE*2;
	}
	elsif ($dice == 6) {
		$club = "�󱸺�";
		$wc = $BASE*2;
		$wd = $BASE/4;
	}
	elsif ($dice == 7) {
		$club = "�豸��";
		$wc = $BASE*2;
		$wd = $BASE/4;
	}
	elsif ($dice == 8) {
		$club = "�߱���";
		$wb = $BASE*2;
		$wc = $BASE/2;
		$wd = $BASE/4;
	}
	elsif ($dice == 9) {
		$club = "ȭ�к�";
		$wd = $BASE*2;
	}
	elsif ($dice == 10) {
		$club = "�����";
	}
	elsif ($dice == 11) {
		$club = "���غ�";
		local($sel) = int(rand(8));
		@randsel = (0,0,0,0,0,0,0,0);
		$randsel[$sel] = $BASE*2;
		($wa,$wg,$wn,$wb,$ws,$wp,$wc,$wd) = @randsel;
	}
	elsif ($dice == 12) {
		$club = "��ǻ�ͺ�";
	}
	elsif ($dice == 13) {
		$club = "�丮��";
		$wn = $BASE/2;
	}

}
1
