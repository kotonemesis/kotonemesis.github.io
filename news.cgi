#!/usr/bin/perl

#require "jcode.pl";
require "br.pl";
require "$lib_file";
&LOCK;
require "$pref_file";



    open(DB,"$log_file");seek(DB,0,0); @loglist=<DB>;close(DB);

    ($ar[0],$ar[1],$ar[2],$ar[3],$ar[4],$ar[5],$ar[6],$ar[7],$ar[8],$ar[9],$ar[10],$ar[11],$ar[12],$ar[13],$ar[14],$ar[15],$ar[16],$ar[17],$ar[18],$ar[19],$ar[20],$ar[21],$ar[22]) = split(/,/, $arealist[4]);

    $getmonth=$getday=0;
    foreach $loglist(@loglist) {
        ($gettime,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_f_name2,$w_l_name2,$w_sex2,$w_cl2,$w_no2,$getkind,$host,$w_name,$w_kind,$wtai)= split(/,/, $loglist);
        ($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($gettime);
        $hour = "0$hour" if ($hour < 10);
        $min = "0$min" if ($min < 10);  $month++;
        $year += 1900;
        $week = ('일','월','화','수','목','금','토') [$wday];
        if (($getmonth != $month) || ($getday != $mday)) {
            if ($getmonth !=0) { push (@log,"</LI></UL>\n"); }
            $getmonth=$month;$getday = $mday;
            push (@log,"<P><font color=\"lime\"><B>$month월 $mday일 ($week요일)</B></font><BR>\n");
            push (@log,"<UL>\n");
        }

		if ( $w_name && $w_kind ) {
	        if ($w_kind =~ /N/) {           #베기 계열
	            $d3 = "$w_f_name2 $w_l_name2의 $w_name에 베여 죽었다." ;
	        } elsif (($w_kind =~ /A/) && ($wtai > 0)) { #화살 계열
	            $d3 = "$w_f_name2 $w_l_name2이\(가\) $w_name\(으\)로 쏜 화살에 맞아 죽었다." ;
	        } elsif (($w_kind =~ /G/) && ($wtai > 0)) { #총 계열
	            $d3 = "$w_f_name2 $w_l_name2이\(가\) $w_name\(으\)로 쏜 총알에 맞아 죽었다." ;
	        } elsif ($w_kind =~ /C/) {  #던지기 계열
	            $d3 = "$w_f_name2 $w_l_name2이\(가\) 던진 $w_name에 맞아 죽었다." ;
	        } elsif ($w_kind =~ /D/) {  #폭탄 계열
	            $d3 = "$w_f_name2 $w_l_name2이\(가\) 던진 $w_name이\(가\) 폭발해 죽었다." ;
	        } elsif ($w_kind =~ /S/) {  #찌르기 계열
	            $d3 = "$w_f_name2 $w_l_name2의 $w_name에 찔려 죽었다." ;
	        } elsif (($w_kind =~ /B/) || (($w_kind =~ /G|A/) && ($wtai == 0))) { #곤봉 or 탄 없는 총 or 화살 없는 활
	            $d3 = "$w_f_name2 $w_l_name2의 $w_name에 두들겨 맞아 죽었다." ;
	        } else {
	            $d3 = "$w_f_name2 $w_l_name2의 $w_name에 의해 살해되었다." ;
	        }
	    }
	    else {
	    	$d3 = "$w_f_name2 $w_l_name2에게 살해 되었다.";
	    }

		if ( $host && ($getkind ne "SPEAKER") ) { $host = "\($host\)"; }
        if ($getkind eq "DEATH") {  #사망 (자신이 원인)
            push (@log,"<LI>$hour시$min분 : <font class=\"red\">$w_f_name $w_l_name이\(가\) 사망했다.</font> $host<BR>\n") ;
        } elsif ($getkind eq "DEATH1") { #사망（독살）
            push (@log,"<LI>$hour시$min분 : <font class=\"red\">$w_f_name $w_l_name이\(가\) 독살 당했다.</font> $host<BR>\n") ;
        } elsif ($getkind eq "DEATH2") { #사망（타살）
            push (@log,"<LI>$hour시$min분 : <font class=\"red\">$w_f_name $w_l_name은\(는\) $d3</font> $host<BR>\n") ;
        } elsif ($getkind eq "DEATH3") { #사망（타살）
            push (@log,"<LI>$hour시$min분 : <font class=\"red\">$w_f_name $w_l_name은\(는\) $d3</font> $host<BR>\n") ;
        } elsif ($getkind eq "DEATH4") { #사망（정부）
            push (@log,"<LI>$hour시$min분 : <font class=\"red\">$w_f_name $w_l_name이\(가\) 목걸이가 폭발해 사망했다.</font> $host<BR>\n") ;
        } elsif ($getkind eq "DEATHAREA") { #사망（금지지역）
            push (@log,"<LI>$hour시$min분 : <font class=\"red\">$w_f_name $w_l_name이\(가\) 금지지역에서 목걸이가 폭발해 사망했다.</font> $host<BR>\n") ;
		} elsif ($getkind eq "SPEAKER") {
			push (@log,"<LI>$hour시$min분 : <font class=\"speak\">$w_f_name $w_l_name이\(가\)『$host』라고 확성기로 외쳤다.</font><BR>\n") ;
		} elsif ($getkind =~ /WINEND/) { #우승자 결정
            $log_num = pop @log;
            if ($log_num =~ /게임종료/){
                push (@log,$log_num);
            }else{
                push (@log,$log_num);
                push (@log,"<LI>$hour시$min분 : <font class=12 color=\"lime\"><b>게임종료·이상 본 프로그램 실시본부</B><BR>　　　　우승자 : $w_f_name $w_l_name \($w_cl $w_sex $w_no번\)<br></font>\n") ;
            }
        } elsif ($getkind =~ /NOWINNER/) { #우승자 결정
            $log_num = pop @log;
            if ($log_num =~ /게임종료/){
                push (@log,$log_num);
            }else{
                push (@log,$log_num);
                push (@log,"<LI>$hour시$min분 : <font class=12 color=\"lime\"><b>게임종료(타임아웃)·이상 본 프로그램 실시본부</B><BR></font>\n") ;
	            $allareacheck = "1"; $allareacheck2 = "1";
            }
        } elsif ($getkind eq "EX_END") { #프로그램 정지
            $log_num = pop @log;
            if ($log_num =~ /게임종료/){
                push (@log,$log_num);
            }else{
                push (@log,$log_num);
                push (@log,"<LI>$hour시$min분 : <font class=12 color=\"lime\"><b>게임종료·프로그램 긴급정지</B></font><BR>\n") ;
            }
        } elsif ($getkind eq "AREA") { #금지 구역 추가
            $log_num = pop @log;
            if (($log_num !~ /게임종료/)||($log_num !~ /<UL>/)){
                push (@log,$log_num);
                push (@log,"<LI>$hour시$min분 : <font color=\"lime\"><b>$place[$ar[$w_l_name]], $place[$ar[$w_l_name+1]], $place[$ar[$w_l_name+2]]</b></font> 이(가) 금지지역으로 지정되었다.\n");
                if ( !$allareacheck ) { push (@log,"다음 금지지역은 <font color=\"lime\"><b>$place[$ar[$w_f_name]], $place[$ar[$w_f_name+1]], $place[$ar[$w_f_name+2]]</b></font>.<BR>\n"); }
                $allareacheck="";
            }else{
                push (@log,$log_num);
            }
        } elsif ($getkind eq "ENTRY") { #신규등록
            push (@log,"<LI>$hour시$min분 : <font color=\"A0C0FF\">$w_f_name $w_l_name이(가) 전학해 왔다.</font> $host<BR>\n") ;
        } elsif ($getkind eq "NEWGAME") { #관리자에 의한 데이터 초기화
            push (@log,"<LI>$hour시$min분 : 새로운 프로그램 개시<BR>\n") ;
        }

        $cnt++;
    }

    for ($i=0; $i<$arealist[1]  ; $i++) {
        $ars = ($ars . " $place[$ar[$i]]") ;
    }
    $ars = "<BR><font color=\"lime\"><B>현재의 금지지역</B></FONT><font class=red> $ars</font><BR>\n";
    if ( !$allareacheck2 ) { $ars = $ars . "<font color=\"lime\"><B>다음 금지지역</B></FONT><font color=FFFF00> $place[$ar[$i]] $place[$ar[$i+1]] $place[$ar[$i+2]]</font>\n"; }


    &HEADER ;
    print "</center>\n" ;
    print "<B><FONT color=\"#ff0000\" size=\"+3\">진행상황</FONT></B><BR><BR>\n";
    print "『여러분, 모두 건강하게 잘 지내나.<BR>그럼, 지금까지의 상황입니다.<BR>오늘 하루도 힘내~』<br>\n";
    print "$ars";
    print @log;
    print "<center>\n" ;
    print "<BR>\n";

    &FOOTER;
&UNLOCK;

exit;
