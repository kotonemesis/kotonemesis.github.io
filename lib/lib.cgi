# ���ī��֫�?�����2

#==================#
# �� �۫���٣����  #
#==================#
sub GetHostName {
    my($ip_address) = @_;
    my(@addr) = split(/\./, $ip_address);
    my($packed_addr) = pack("C4", $addr[0], $addr[1], $addr[2], $addr[3]);
    my($name, $aliases, $addrtype, $length, @addrs);
    ($name, $aliases, $addrtype, $length, @addrs) = gethostbyaddr($packed_addr, 2);
    return $name;
}
#==================#
# �� �ثë�?ݻ    #
#==================#
sub HEADER {
print "Cache-Control: no-cache\n";
print "Pragma: no-cache\n";
print "Content-type: text/html\n\n";
print <<"_HERE_";
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=euc-kr">
<title>$game</title>
<link rel="stylesheet" type="text/css" href="br.css">
</HEAD>
<BODY>
<CENTER>
_HERE_
}
#==================#
# �� �իë�ݻ      #
#==================#
sub FOOTER {
print <<"_HERE_";
</CENTER>
<HR>
<DIV align="right"><B><A href="http://www.happy-ice.com/battle/" target="_blank">Battle Royale $ver</A></B><br>
<a href="http://battleroyale.lil.to/" target="_blank">�ѱ�ȭ �� ���� by �縮��</a></DIV>
</BODY>
</HTML>
_HERE_
}

#==================#
# �� ����??��    #
#==================#
sub ERROR{#�᫨��??��
if ($lockflag) { &UNLOCK; }
$errmes = @_[0] ;
&HEADER;
print <<"_HERE_";
<B><FONT color="#ff0000" size="+2">���� �߻�</FONT></B><BR><BR>
$errmes<BR>
<BR>
_HERE_
&FOOTER;
exit;
}

#====================#
# �� ������        #
#====================#
sub LOGSAVE {

    local($work) = @_[0] ;
    local($newlog) = "" ;

    if ($work eq "NEWENT") { #��Ю��?
        $newlog = "$now,$f_name2,$l_name2,$sex2,$cl,$no,,,,,,ENTRY,$host,,,,\n" ;
    } elsif ($work eq "DEATH" ){ #ȥ�� ���� (���Σ�?��?��﷪�)
        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,,,,,,DEATH,$dmes,,,,\n" ;
        $death = "����";$msg=$dmes;
    } elsif ($work eq "DEATH1" ){ #ȥ�� ���� (���� : ����)
        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,,,,,,DEATH1,$dmes,,,,\n" ;
        $death = "�ߵ���";$msg=$dmes;
    } elsif ($work eq "DEATH2" ){ #������̣���ף����ݣ�
#        local($w_name,$w_kind) = split(/<>/, $w_wep);
	local($w_name) = $w_wepname;
	local($w_kind) = $zwep2;
        if ($w_kind =~ /N/) {           #��ͧ
            $d2 = "����" ;
        } elsif (($w_kind =~ /A/) && ($w_wtai > 0)) {   #��ͧ
            $d2 = "���" ;
        } elsif (($w_kind =~ /G/) && ($w_wtai > 0)) {   #��ͧ
            $d2 = "�ѻ�" ;
        } elsif ($w_kind =~ /C/) {  #��ͧ
            $d2 = "����" ;
        } elsif ($w_kind =~ /D/) {  #��ͧ
            $d2 = "����" ;
        } elsif ($w_kind =~ /S/) {  #�ͧ
            $d2 = "ô��" ;
        } elsif (($w_kind =~ /B/) || (($w_kind =~ /G|A/) && ($w_wtai == 0))) { #���� or ?���� or ������
            $d2 = "�ڻ�" ;
        } else {
            $d2 = "����" ;
        }

        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,DEATH2,$dmes,$w_name,$w_kind,$w_wtai,\n" ;
        if ($w_no eq "����") {
            $deth = "$w_f_name $w_l_name�� ���� $d2";
        } else {
            $deth = "$w_f_name $w_l_name��$w_cl $w_sex$w_no������ ���� $d2";
        }
        if ($w_msg ne "") {
            $msg = "$w_f_name $w_l_name��$w_msg��" ;
        } else {
            $msg = "" ;
        }
    } elsif ($work eq "DEATH3" ){ #�����̣���ף����ݣ�
#        local($w_name,$w_kind) = split(/<>/, $wep);
	local($w_name) = $wepname;
	local($w_kind) = $zwep;
        if ($w_kind =~ /N/) {           #��ͧ
            $d2 = "����" ;
        } elsif (($w_kind =~ /A/) && ($wtai > 0)) { #��ͧ
            $d2 = "���" ;
        } elsif (($w_kind =~ /G/) && ($wtai > 0)) { #��ͧ
            $d2 = "�ѻ�" ;
        } elsif ($w_kind =~ /C/) {  #��ͧ
            $d2 = "����" ;
        } elsif ($w_kind =~ /D/) {  #��ͧ
            $d2 = "����" ;
        } elsif ($w_kind =~ /S/) {  #�ͧ
            $d2 = "ô��" ;
        } elsif (($w_kind =~ /B/) || (($w_kind =~ /G|A/) && ($wtai == 0))) { #���� or ?���� or ������
            $d2 = "�ڻ�" ;
        } else {
            $d2 = "����" ;
        }
        $newlog = "$now,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$f_name,$l_name,$sex,$cl,$no,DEATH3,$w_dmes,$w_name,$w_kind,$wtai,\n" ;
        $deth = "$f_name $l_name��$cl $sex$no������ ���� $d2";
        if ($msg ne "") {
            $w_msg = "$f_name $l_name��$msg��" ;
        } else {
            $w_msg = "" ;
        }
        $w_log = "";
    } elsif ($work eq "DEATH4" ){ #��ݤ�˪��߯��
        $newlog = "$now,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,,,,,,DEATH4,$w_dmes,,,,\n" ;
        $deth = "���ο� ���� ó��";
        $log ="";
        if ($w_msg ne "") {
            $msg = "���Ρ�$w_msg��" ;
        } else {
            $msg = "" ;
        }
    } elsif ($work eq "DEATH5" ){ #��ݤ�˪��߯��2
        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,,,,,,DEATH4,$dmes,,,,\n" ;
        $deth = "���ο� ���� ó��";
        $log ="";
        $msg = "���Ρ��ȵƱ���, ������ �ൿ�� �ϸ� ����̸� �����Ѵٰ� ���ݾơ�" ;
    } elsif ($work eq "DEATHAREA" ){ #���̣���ף���򭫨�ꫢ��
        $newlog = "$now,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,,,,,,DEATHAREA,$w_dmes,,,,\n" ;
        $deth = "�������� ü��";
        $msg = "" ;$log ="";
    } elsif ($work eq "WINEND1" ){ #���̽��
        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,,,,,,WINEND,$dmes,,,,\n" ;
    } elsif ($work eq "NOWINNER" ){ #����� ����(�������)
        $newlog = "$now,,,,,,,,,,,NOWINNER,,,,,\n" ;
    } elsif ($work eq "EX_END" ){ #�ϫë��󫰪˪��׫��������
        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,,,,,,EX_END,$dmes,,,,\n" ;
    } elsif ($work eq "AREAADD" ){ #��򭫨�ꫢ��ʥ
        $ar = $ar2 - 3 ;
        $newlog = "$now,$ar2,$ar,,,,,,,,,AREA,,,,,\n" ;
    }

    open(DB,"$log_file") || exit; seek(DB,0,0); @loglist=<DB>; close(DB);
    unshift(@loglist,$newlog);

    open(DB,">$log_file"); seek(DB,0,0); print DB @loglist; close(DB);


}

#====================#
# �� LOCK            #
#====================#
sub LOCK {
    local($retry,$mtime);
    # 20�� �̻� ������ ���� �����
    if (-e $lockf) {
        ($mtime) = (stat($lockf))[9];
        if ($mtime < time - 20) { &UNLOCK; }
    }
    # symlink??�ҫ�ë�
    if ($lkey == 1) {
        $retry = 5;
        while (!symlink(".", $lockf)) {
            if (--$retry <= 0) { &ERROR("������ ���� ȥ���մϴ�. ��� ��ٷ� �ּ���."); }
            sleep(1);
        }
    # mkdir??�ҫ�ë�
    } elsif ($lkey == 2) {
        $retry = 5;
        while (!mkdir($lockf, 0755)) {
            if (--$retry <= 0) { &ERROR("������ ���� ȥ���մϴ�. ��� ��ٷ� �ּ���."); }
            sleep(1);
        }
    }
    $lockflag=1;
}

#====================#
# �� UNLOCK          #
#====================#
sub UNLOCK {
    if ($lkey == 1) { unlink($lockf); }
    elsif ($lkey == 2) { rmdir($lockf); }
    $lockflag=0;
}

#====================#
# �� itemcolor       #
#====================#
sub COLOR {

	$comfront = "";
	$comback = "";
	$num = 4;

	if ( $mcolor eq "GET" ) {
		$num = 5;
	}

	$i = 0;
	foreach $i (0..$num) {

		if ( $mcolor eq "ITEMandDEL" ) {
			$comfront = "��<INPUT type=\"radio\" name=\"Command\" value=\"ITEM_$i\">";
			$comback = " (����<INPUT type=\"radio\" name=\"Command\" value=\"DEL_$i\">)\n";
		}
		elsif ( $mcolor eq "GET" ) {
			$comfront = "��<INPUT type=\"radio\" name=\"Command\" value=\"GET_$i\">";
			$comback = "";
			@item = @w_item;
			@eff = @w_eff;
			@itai = @w_itai;
		}

		if ($item[$i] ne "����") {
			($in, $ik) = split(/<>/, $item[$i]);
			if ($ik =~ /^H/) {
				print "$comfront<font class=\"hp\">$in/$eff[$i]/$itai[$i]</font>$comback<BR>\n";
			}
			elsif ($ik =~ /^S/) {
				print "$comfront<font class=\"sp\">$in/$eff[$i]/$itai[$i]</font>$comback<BR>\n";
			}
			elsif ($ik =~ /^W/) {
				print "$comfront<font class=\"wep\">$in/$eff[$i]/$itai[$i]</font>$comback<BR>\n";
			}
			elsif ($ik =~ /^D/) {
				print "$comfront<font class=\"clo\">$in/$eff[$i]/$itai[$i]</font>$comback<BR>\n";
			}
			elsif ($ik =~ /^ADB/) {
				print "$comfront<font class=\"clo\">$in/$eff[$i]/$itai[$i]</font>$comback<BR>\n";
			}
			else {
				print "$comfront$in/$eff[$i]/$itai[$i]$comback<BR>\n";
			}
		}
	}
}
#====================#
# ü��/���׹̳� �ð� #
#====================#
sub CLOCK {

$hpkaifukutime = int($kaifuku_rate*$kaifuku_time);

print <<"_HERE_";
<script language="JavaScript">
<!--
var entered = new Date();
function DigitalTime() {
	if (!document.layers && !document.all) return
	var now = new Date();
	var seconds = Math.floor((now.getTime() - entered.getTime()) / 1000)
	var minutes = Math.floor(seconds /60)
	var hours = Math.floor(seconds /3600)
	var seconds2 = seconds % 60
	var minutes = minutes % 60
	var hppoint = Math.floor(seconds /$hpkaifukutime)
	var sppoint = Math.floor(seconds /$kaifuku_time)

	if (minutes <= 9)	minutes = "0" + minutes;
	if (seconds2 <= 9)	seconds2 = "0" + seconds2;
_HERE_

if ( $sts eq "ġ��" ) {
	print 'digclock = "��<font class=hp>ȸ���� ü�� "+hppoint+" ����Ʈ</font><br>������ð� "+hours+"�ð� "+minutes+"�� "+seconds2+"��";';
}
elsif ( $sts eq "����" ) {
	print 'digclock = "��<font class=sp>ȸ���� ���׹̳� "+sppoint+" ����Ʈ</font><br>������ð� "+hours+"�ð� "+minutes+"�� "+seconds2+"��";';
}

print <<"_HERE_";
	if (document.layers) {
		document.layers.liveclock.document.write(digclock);
		document.layers.liveclock.document.close();
	}
	else if (document.all) liveclock.innerHTML = digclock;

	setTimeout("DigitalTime()",1000)
}
window.onload = DigitalTime;
//-->
</script>
<span id="liveclock"></span><p>
_HERE_
}
1
