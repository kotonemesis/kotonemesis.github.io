#!/usr/bin/perl

require "br.pl";
require "$lib_file";
&LOCK;
require "$pref_file";

if (-e $survivordatfile) {
	open ( SURVIVOR, "<$survivordatfile");
	@SURVIVOR = <SURVIVOR>;
	close (SURVIVOR);
}
else { &ERROR ("����ڰ� ���� �����ϴ�");}

&HEADER ;

print "<P align=\"center\"><B><FONT color=\"#ff0000\" size=\"+3\">���� ������ ����Ʈ</FONT></B><BR></P>\n";

$i = 0;
$j = $#SURVIVOR +1;
foreach $i (0..$#SURVIVOR) {

	($starttime,$endtime,$id,$password,$f_name,$l_name,$sex,$cl,$no,$deadtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf) = split(/,/, $SURVIVOR[$i]);

	($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($starttime);
	$hour = "0$hour" if ($hour < 10);
	$min = "0$min" if ($min < 10);  $month++;
	$year += 1900;
	$week = ('��','��','ȭ','��','��','��','��') [$wday];

	($sec2,$min2,$hour2,$mday2,$month2,$year2,$wday2,$yday2,$isdst2) = localtime($endtime);
	$hour2 = "0$hour2" if ($hour2 < 10);
	$min2 = "0$min2" if ($min2 < 10);  $month2++;
	$year2 += 1900;
	$week2 = ('��','��','ȭ','��','��','��','��') [$wday2];

#����ڰ� ���� ���
if ($id ne "����ھ���") {

	#�������ͽ� ���
    ($w_name,$w_kind) = split(/<>/, $wep);
    ($b_name,$b_kind) = split(/<>/, $bou);

    $cln = "$cl $sex$no��" ;

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

	if ( $inf eq "��" ) {
		$surtitle = "�� $jȸ ���α׷� ��������";
	}
	else {
		$surtitle = "�� $jȸ ���α׷� �����";
	}

#�������ͽ� ���̺�
print <<"_HERE_";
<table border=1 cellpadding=1 cellspacing=0 width=400>
    <tr>
        <th colspan=3 width=400><center><font class=12 color=yellow>$surtitle</font></center></th>
    </tr>
    <tr>
        <td colspan=3 width=400>���α׷� �����Ͻ� : $year�� $month�� $mday�� $week���� $hour�� $min��</td>
    </tr>
    <tr>
        <td colspan=3 width=400>���α׷� �����Ͻ� : $year2�� $month2�� $mday2�� $week2���� $hour2�� $min2��</td>
    </tr>
    <tr>
        <td width=70 height=70><img src="$imgurl$icon_file[$icon]" width="70" height="70" border="0"></td>
        <td width=160 align=center height=70>$f_name $l_name<br>$cln<br>Lv $level</td>
        <td width=220 rowspan=9 valign=top>
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
        <td>���ؼ�</td>
        <td>$kill��</td>
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
</table><p>
_HERE_

#����ڰ� ���� ��� if�� ����
}

#����ڰ� ���� ���
else {
print <<"_HERE_";
<table border=1 cellpadding=1 cellspacing=0 width=400>
    <tr>
        <th colspan=3 width=400><center><font class=12 color=yellow>�� $jȸ ���α׷� ����� ���� ($password)</font></center></th>
    </tr>
    <tr>
        <td colspan=3 width=400>���α׷� �����Ͻ� : $year�� $month�� $mday�� $week���� $hour�� $min��</td>
    </tr>
    <tr>
        <td colspan=3 width=400>���α׷� �����Ͻ� : $year2�� $month2�� $mday2�� $week2���� $hour2�� $min2��</td>
    </tr>
</table><p>
_HERE_

#����ڰ� ���� ��� else�� ����
}

	$j--;
}

&FOOTER;
&UNLOCK;

exit;

