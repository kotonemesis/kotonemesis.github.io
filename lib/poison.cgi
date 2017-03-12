#==================#
# ■ 毒物混入?理  #
#==================#
sub POISON {

    for ($i=0; $i<5; $i++) {
        if ($item[$i] =~ /독약/) {
            last ;
        }
    }
    local($wk) = $Command;
    $wk =~ s/POI_//g;
    if (($item[$wk] !~ /<>SH|<>HH|<>SD|<>HD/) || ($item[$i] !~ /독약/)) {
        &ERROR("부정 억세스입니다.");
    }
    $itai[$i]--;
    if ($itai[$i] <= 0) {
        $item[$i] = "없음"; $eff[$i] = $itai[$i] = 0 ;
    }
    local($in, $ik) = split(/<>/, $item[$wk]);
    $log = ($log . "$in에 독을 섞었습니다. 스스로 먹지 않도록 조심하자...<br>") ;
    if ($club eq "요리부") {
        if($item[$wk] =~ /<>H.*/){
            $item[$wk] =~ s/<>H.*/<>HD2/g;
        }else{ $item[$wk] =~ s/<>S.*/<>SD2/g; }
    } else {
        if($item[$wk] =~ /<>HH/){
            $item[$wk] =~ s/<>HH/<>HD/g;
        }else{ $item[$wk] =~ s/<>SH/<>SD/g; }
    }
    &SAVE ;
    $Command = "MAIN" ;
}
#==================#
# ■ 毒見?理      #
#==================#
sub PSCHECK {

    local($wk) = $Command;
    $wk =~ s/PSC_//g;
    if ($item[$wk] !~ /<>SH|<>HH|<>SD|<>HD/) {
        &ERROR("부정 억세스입니다.");
    }
    local($in, $ik) = split(/<>/, $item[$wk]);
    if ($ik =~ /SH|HH/) {
        $log = ($log . "으음... $in은(는) 먹어도 안전한 것 같다...<br>") ;
    } else {
        $log = ($log . "으음... $in은(는) 독이 섞여 있는듯 하다...<br>") ;
    }
    $sta -= $dokumi_sta ;
    if ($sta <= 0) {    #スタミナ切れ？
        &DRAIN("com");
    }
    &SAVE ;
    $Command = "MAIN" ;
}

1
