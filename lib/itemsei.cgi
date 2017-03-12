#==================#
# ■ アイテム整理 #
#==================#
sub ITEMSEIRI {

local($wk) = $Command;
$wk =~ s/SEIRI_//g;
local($in, $ik) = split(/<>/, $item[$wk]);

local($wk2) = $Command2;
$wk2 =~ s/SEIRI2_//g;
local($in2, $ik2) = split(/<>/, $item[$wk2]);

if (($item[$wk] eq "없음")||($item[$wk2] eq "없음")) {
&ERROR("부정 억세스입니다.");
}

$log = ($log . "아이템을 정리합니다.<br>") ;

if ($wk == $wk2) { #同アイテム選?？
    $log = ($log . "$in을(를) 고쳐넣었습니다.<br>") ;
}elsif (($in eq $in2)&&($eff[$wk] eq $eff[$wk2])&&($ik =~ /HH|HD/)&&($ik2 =~ /HH|HD/)) { #?力回復アイテム整理
    $itai[$wk] = $itai[$wk] + $itai[$wk2];
    if (($ik eq "HD")||($ik2 eq "HD")) {
        $item[$wk] = "$in<>HD";
    }
    if(($ik eq "HD2")||($ik2 eq "HD2")) {
        $item[$wk] = "$in<>HD2";
    }
    $item[$wk2] = "없음"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;
    $log = ($log . "$in을(를) 모았다.<br>") ;
}elsif (($in eq $in2)&&($eff[$wk] eq $eff[$wk2])&&($ik =~ /SH|SD/)&&($ik2 =~ /SH|SD/)) { #スタミナ回復アイテム整理
        $itai[$wk] = $itai[$wk] + $itai[$wk2];
    if (($ik eq "SD")||($ik2 eq "SD")) {
        $item[$wk] = "$in<>SD";
    }
    if(($ik eq "SD2")||($ik2 eq "SD2")) {
        $item[$wk] = "$in<>SD2";
    }
    $item[$wk2] = "없음"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;
    $log = ($log . "$in을(를) 모았다.<br>") ;
}elsif (($in eq $in2)&&($ik eq $ik2)&&(($ik =~ /WC|WD/)||($in =~ /독약/))) { #爆??投武器?毒?整理
    $itai[$wk] = $itai[$wk] + $itai[$wk2];
    $item[$wk2] = "없음"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;
    $log = ($log . "$in을(를) 모았다.<br>") ;
}elsif ((($in eq $in2)&&($ik eq $ik2)&&($ik eq "Y"))&&($in =~ /탄|화살/)) { #?丸?矢
    $eff[$wk] = $eff[$wk] + $eff[$wk2];
    $item[$wk2] = "없음"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;
    $log = ($log . "$in을(를) 모았다.<br>") ;
}else { #違うアイテム?纏められない物選?
$log = ($log . "$in와(과) $in2은(는) 모아지지 않는구나.<br>") ;
}

$Command = "MAIN";
$Command2 = "";

&SAVE;

}

1
