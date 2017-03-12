#==================#
# ■ 아이템 합성   #
#==================#
sub ITEMGOUSEI {

    $wk = $Command;
    $wk =~ s/GOUSEI_//g;
    ($in, $ik) = split(/<>/, $item[$wk]);

    $wk2 = $Command2;
    $wk2 =~ s/GOUSEI2_//g;
    ($in2, $ik2) = split(/<>/, $item[$wk2]);

    if (($item[$wk] eq "없음")||($item[$wk2] eq "없음")) {
        &ERROR("부정 억세스입니다.");
    }

    $chk = "NG" ;

    if(($itai[$wk] == 1)||($itai[$wk] eq "∞")){
        $chk = "ON"; $itai[$wk] == 1;$j=$wk;
    }elsif($ik =~ /DB|DH|DF|DA/){
        $chk = "ON"; ;$j=$wk;
    }elsif(($itai[$wk2] == 1)||($itai[$wk2] eq "∞")){
        $chk = "ON"; $itai[$wk2] == 1;$j=$wk2;
    }elsif($ik2 =~ /DB|DH|DF|DA/){
        $chk = "ON"; ;$j=$wk2;
    }else{
        for ($j=0; $j<5; $j++) {
            if ($item[$j] eq "없음") {
                $chk = "ON" ; last;
            }
        }
    }

    if ($chk eq "NG") {
        $log = ($log . "더 이상 배낭에 들어가지 않습니다.<br>") ;
    } else {
        $log = ($log . "아이템을 합성합니다.<br>") ;
        if (($wk == $wk2)||($in eq $in2)) { #同アイテム選?？
            $log = ($log . "$in을(를) 바라봤다.<br>") ;
        }else{
            require "$gousei_file";

			#테이블 작성
			$i = 0;
			foreach $i ( 0..$#tmakeitem ) {
				($g_item1[$i],$g_item2[$i],$g_name[$i],$g_kind[$i],$g_eff[$i],$g_itai[$i]) = split (/<>/, $tmakeitem[$i]);
                $gousei{"$g_item1[$i]"}{"$g_item2[$i]"}{"name"} = "$g_name[$i]";
                $gousei{"$g_item1[$i]"}{"$g_item2[$i]"}{"kind"} = "$g_kind[$i]";
                $gousei{"$g_item1[$i]"}{"$g_item2[$i]"}{"eff"}  = "$g_eff[$i]";
                $gousei{"$g_item1[$i]"}{"$g_item2[$i]"}{"itai"} = "$g_itai[$i]";
			}

            if($gousei{$in}{$in2}{name}){ #合成テ?ブル使用合成
                $log = ($log . "$in와(과) $in2(으)로 $gousei{$in}{$in2}{name}이(가) 나왔다!<BR>");
                $item[$j] = "$gousei{$in}{$in2}{name}<>$gousei{$in}{$in2}{kind}";
                $eff[$j] = $gousei{$in}{$in2}{eff} ;
                $itai[$j] = $gousei{$in}{$in2}{itai} ;
                &ITEMCOUNT;
            }elsif($gousei{$in2}{$in}{name}){ #合成テ?ブル使用合成(逆)
                $log = ($log . "$in와(과) $in2(으)로 $gousei{$in2}{$in}{name}이(가) 나왔다!<BR>");
                $item[$j] = "$gousei{$in2}{$in}{name}<>$gousei{$in2}{$in}{kind}";
                $eff[$j] = $gousei{$in2}{$in}{eff} ;
                $itai[$j] = $gousei{$in2}{$in}{itai} ;
                &ITEMCOUNT;
            }else { #違うアイテム?合成できない物選?
                $log = ($log . "$in와(과) $in2은(는) 조합되지 않는구나.<br>") ;
            }
        }
    }

    $Command = "MAIN";
    $Command2 = "";

    &SAVE;

}

sub ITEMCOUNT{
    if($wk == $j){
        if($ik2 =~ /DB|DH|DF|DA/){
            $item[$wk2] = "없음"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;
        }else{
            $itai[$wk2] -= 1;
            if ($itai[$wk2] <= 0) {$item[$wk2] = "없음"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;}
        }
    }elsif($wk2 == $j){
        if($ik =~ /DB|DH|DF|DA/){
            $item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }else{
            $itai[$wk] -= 1;
            if ($itai[$wk] <= 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
        }
    }else{
        if($ik =~ /DB|DH|DF|DA/){
            $item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }else{
            $itai[$wk] -= 1;
            if ($itai[$wk] <= 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
        }
        if($ik2 =~ /DB|DH|DF|DA/){
            $item[$wk2] = "없음"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;
        }else{
            $itai[$wk2] -= 1;
            if ($itai[$wk2] <= 0) {$item[$wk2] = "없음"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;}
        }
    }
}

1
