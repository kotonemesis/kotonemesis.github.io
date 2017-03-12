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
else { &ERROR ("우승자가 아직 없습니다");}

&HEADER ;

print "<P align=\"center\"><B><FONT color=\"#ff0000\" size=\"+3\">역대 생존자 리스트</FONT></B><BR></P>\n";

$i = 0;
$j = $#SURVIVOR +1;
foreach $i (0..$#SURVIVOR) {

	($starttime,$endtime,$id,$password,$f_name,$l_name,$sex,$cl,$no,$deadtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$dmes,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com,$inf) = split(/,/, $SURVIVOR[$i]);

	($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($starttime);
	$hour = "0$hour" if ($hour < 10);
	$min = "0$min" if ($min < 10);  $month++;
	$year += 1900;
	$week = ('일','월','화','수','목','금','토') [$wday];

	($sec2,$min2,$hour2,$mday2,$month2,$year2,$wday2,$yday2,$isdst2) = localtime($endtime);
	$hour2 = "0$hour2" if ($hour2 < 10);
	$min2 = "0$min2" if ($min2 < 10);  $month2++;
	$year2 += 1900;
	$week2 = ('일','월','화','수','목','금','토') [$wday2];

#우승자가 있을 경우
if ($id ne "우승자없음") {

	#스테이터스 계산
    ($w_name,$w_kind) = split(/<>/, $wep);
    ($b_name,$b_kind) = split(/<>/, $bou);

    $cln = "$cl $sex$no번" ;

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

	if ( $inf eq "해" ) {
		$surtitle = "제 $j회 프로그램 강제종료";
	}
	else {
		$surtitle = "제 $j회 프로그램 우승자";
	}

#스테이터스 테이블
print <<"_HERE_";
<table border=1 cellpadding=1 cellspacing=0 width=400>
    <tr>
        <th colspan=3 width=400><center><font class=12 color=yellow>$surtitle</font></center></th>
    </tr>
    <tr>
        <td colspan=3 width=400>프로그램 시작일시 : $year년 $month월 $mday일 $week요일 $hour시 $min분</td>
    </tr>
    <tr>
        <td colspan=3 width=400>프로그램 종료일시 : $year2년 $month2월 $mday2일 $week2요일 $hour2시 $min2분</td>
    </tr>
    <tr>
        <td width=70 height=70><img src="$imgurl$icon_file[$icon]" width="70" height="70" border="0"></td>
        <td width=160 align=center height=70>$f_name $l_name<br>$cln<br>Lv $level</td>
        <td width=220 rowspan=9 valign=top>
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
        <td>살해수</td>
        <td>$kill명</td>
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
</table><p>
_HERE_

#우승자가 있을 경우 if문 닫음
}

#우승자가 없을 경우
else {
print <<"_HERE_";
<table border=1 cellpadding=1 cellspacing=0 width=400>
    <tr>
        <th colspan=3 width=400><center><font class=12 color=yellow>제 $j회 프로그램 우승자 없음 ($password)</font></center></th>
    </tr>
    <tr>
        <td colspan=3 width=400>프로그램 시작일시 : $year년 $month월 $mday일 $week요일 $hour시 $min분</td>
    </tr>
    <tr>
        <td colspan=3 width=400>프로그램 종료일시 : $year2년 $month2월 $mday2일 $week2요일 $hour2시 $min2분</td>
    </tr>
</table><p>
_HERE_

#우승자가 없을 경우 else문 닫음
}

	$j--;
}

&FOOTER;
&UNLOCK;

exit;

