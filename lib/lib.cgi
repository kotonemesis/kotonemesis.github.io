# 汎用サブル?チン集2

#==================#
# ■ ホスト名取得  #
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
# ■ ヘッダ?部    #
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
# ■ フッタ部      #
#==================#
sub FOOTER {
print <<"_HERE_";
</CENTER>
<HR>
<DIV align="right"><B><A href="http://www.happy-ice.com/battle/" target="_blank">Battle Royale $ver</A></B><br>
<a href="http://battleroyale.lil.to/" target="_blank">한글화 및 개조 by 루리아</a></DIV>
</BODY>
</HTML>
_HERE_
}

#==================#
# ■ エラ??理    #
#==================#
sub ERROR{#■エラ??面
if ($lockflag) { &UNLOCK; }
$errmes = @_[0] ;
&HEADER;
print <<"_HERE_";
<B><FONT color="#ff0000" size="+2">에러 발생</FONT></B><BR><BR>
$errmes<BR>
<BR>
_HERE_
&FOOTER;
exit;
}

#====================#
# ■ ログ保存        #
#====================#
sub LOGSAVE {

    local($work) = @_[0] ;
    local($newlog) = "" ;

    if ($work eq "NEWENT") { #新規登?
        $newlog = "$now,$f_name2,$l_name2,$sex2,$cl,$no,,,,,,ENTRY,$host,,,,\n" ;
    } elsif ($work eq "DEATH" ){ #혼자 죽음 (원인：?、?力切れ)
        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,,,,,,DEATH,$dmes,,,,\n" ;
        $death = "쇠약사";$msg=$dmes;
    } elsif ($work eq "DEATH1" ){ #혼자 죽음 (원인 : 독살)
        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,,,,,,DEATH1,$dmes,,,,\n" ;
        $death = "중독사";$msg=$dmes;
    } elsif ($work eq "DEATH2" ){ #自分死亡（要因：敗死）
#        local($w_name,$w_kind) = split(/<>/, $w_wep);
	local($w_name) = $w_wepname;
	local($w_kind) = $zwep2;
        if ($w_kind =~ /N/) {           #斬系
            $d2 = "참살" ;
        } elsif (($w_kind =~ /A/) && ($w_wtai > 0)) {   #矢系
            $d2 = "사살" ;
        } elsif (($w_kind =~ /G/) && ($w_wtai > 0)) {   #銃系
            $d2 = "총살" ;
        } elsif ($w_kind =~ /C/) {  #投系
            $d2 = "살해" ;
        } elsif ($w_kind =~ /D/) {  #爆系
            $d2 = "폭살" ;
        } elsif ($w_kind =~ /S/) {  #刺系
            $d2 = "척살" ;
        } elsif (($w_kind =~ /B/) || (($w_kind =~ /G|A/) && ($w_wtai == 0))) { #棍棒 or ?無し銃 or 矢無し弓
            $d2 = "박살" ;
        } else {
            $d2 = "살해" ;
        }

        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,DEATH2,$dmes,$w_name,$w_kind,$w_wtai,\n" ;
        if ($w_no eq "정부") {
            $deth = "$w_f_name $w_l_name에 의해 $d2";
        } else {
            $deth = "$w_f_name $w_l_name（$w_cl $w_sex$w_no번）에 의해 $d2";
        }
        if ($w_msg ne "") {
            $msg = "$w_f_name $w_l_name『$w_msg』" ;
        } else {
            $msg = "" ;
        }
    } elsif ($work eq "DEATH3" ){ #敵死亡（要因：敗死）
#        local($w_name,$w_kind) = split(/<>/, $wep);
	local($w_name) = $wepname;
	local($w_kind) = $zwep;
        if ($w_kind =~ /N/) {           #斬系
            $d2 = "참살" ;
        } elsif (($w_kind =~ /A/) && ($wtai > 0)) { #矢系
            $d2 = "사살" ;
        } elsif (($w_kind =~ /G/) && ($wtai > 0)) { #銃系
            $d2 = "총살" ;
        } elsif ($w_kind =~ /C/) {  #投系
            $d2 = "살해" ;
        } elsif ($w_kind =~ /D/) {  #爆系
            $d2 = "폭살" ;
        } elsif ($w_kind =~ /S/) {  #刺系
            $d2 = "척살" ;
        } elsif (($w_kind =~ /B/) || (($w_kind =~ /G|A/) && ($wtai == 0))) { #棍棒 or ?無し銃 or 矢無し弓
            $d2 = "박살" ;
        } else {
            $d2 = "살해" ;
        }
        $newlog = "$now,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$f_name,$l_name,$sex,$cl,$no,DEATH3,$w_dmes,$w_name,$w_kind,$wtai,\n" ;
        $deth = "$f_name $l_name（$cl $sex$no번）에 의해 $d2";
        if ($msg ne "") {
            $w_msg = "$f_name $l_name『$msg』" ;
        } else {
            $w_msg = "" ;
        }
        $w_log = "";
    } elsif ($work eq "DEATH4" ){ #政府による殺害
        $newlog = "$now,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,,,,,,DEATH4,$w_dmes,,,,\n" ;
        $deth = "정부에 의해 처형";
        $log ="";
        if ($w_msg ne "") {
            $msg = "정부『$w_msg』" ;
        } else {
            $msg = "" ;
        }
    } elsif ($work eq "DEATH5" ){ #政府による殺害2
        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,,,,,,DEATH4,$dmes,,,,\n" ;
        $deth = "정부에 의해 처형";
        $log ="";
        $msg = "정부『안됐구나, 수상한 행동을 하면 목걸이를 폭파한다고 했잖아』" ;
    } elsif ($work eq "DEATHAREA" ){ #死亡（要因：禁止エリア）
        $newlog = "$now,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,,,,,,DEATHAREA,$w_dmes,,,,\n" ;
        $deth = "금지지역 체재";
        $msg = "" ;$log ="";
    } elsif ($work eq "WINEND1" ){ #優勝決定
        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,,,,,,WINEND,$dmes,,,,\n" ;
    } elsif ($work eq "NOWINNER" ){ #우승자 없음(전원사망)
        $newlog = "$now,,,,,,,,,,,NOWINNER,,,,,\n" ;
    } elsif ($work eq "EX_END" ){ #ハッキングによりプログラムを停止
        $newlog = "$now,$f_name,$l_name,$sex,$cl,$no,,,,,,EX_END,$dmes,,,,\n" ;
    } elsif ($work eq "AREAADD" ){ #禁止エリア追加
        $ar = $ar2 - 3 ;
        $newlog = "$now,$ar2,$ar,,,,,,,,,AREA,,,,,\n" ;
    }

    open(DB,"$log_file") || exit; seek(DB,0,0); @loglist=<DB>; close(DB);
    unshift(@loglist,$newlog);

    open(DB,">$log_file"); seek(DB,0,0); print DB @loglist; close(DB);


}

#====================#
# ■ LOCK            #
#====================#
sub LOCK {
    local($retry,$mtime);
    # 20초 이상 오래된 락은 지운다
    if (-e $lockf) {
        ($mtime) = (stat($lockf))[9];
        if ($mtime < time - 20) { &UNLOCK; }
    }
    # symlink??式ロック
    if ($lkey == 1) {
        $retry = 5;
        while (!symlink(".", $lockf)) {
            if (--$retry <= 0) { &ERROR("지금은 몹시 혼잡합니다. 잠시 기다려 주세요."); }
            sleep(1);
        }
    # mkdir??式ロック
    } elsif ($lkey == 2) {
        $retry = 5;
        while (!mkdir($lockf, 0755)) {
            if (--$retry <= 0) { &ERROR("지금은 몹시 혼잡합니다. 잠시 기다려 주세요."); }
            sleep(1);
        }
    }
    $lockflag=1;
}

#====================#
# ■ UNLOCK          #
#====================#
sub UNLOCK {
    if ($lkey == 1) { unlink($lockf); }
    elsif ($lkey == 2) { rmdir($lockf); }
    $lockflag=0;
}

#====================#
# ■ itemcolor       #
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
			$comfront = "　<INPUT type=\"radio\" name=\"Command\" value=\"ITEM_$i\">";
			$comback = " (버림<INPUT type=\"radio\" name=\"Command\" value=\"DEL_$i\">)\n";
		}
		elsif ( $mcolor eq "GET" ) {
			$comfront = "　<INPUT type=\"radio\" name=\"Command\" value=\"GET_$i\">";
			$comback = "";
			@item = @w_item;
			@eff = @w_eff;
			@itai = @w_itai;
		}

		if ($item[$i] ne "없음") {
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
# 체력/스테미너 시계 #
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

if ( $sts eq "치료" ) {
	print 'digclock = "　<font class=hp>회복될 체력 "+hppoint+" 포인트</font><br>　경과시간 "+hours+"시간 "+minutes+"분 "+seconds2+"초";';
}
elsif ( $sts eq "수면" ) {
	print 'digclock = "　<font class=sp>회복될 스테미너 "+sppoint+" 포인트</font><br>　경과시간 "+hours+"시간 "+minutes+"분 "+seconds2+"초";';
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
