#==================#
# �� Ըڪ����?��  #
#==================#
sub POISON {

    for ($i=0; $i<5; $i++) {
        if ($item[$i] =~ /����/) {
            last ;
        }
    }
    local($wk) = $Command;
    $wk =~ s/POI_//g;
    if (($item[$wk] !~ /<>SH|<>HH|<>SD|<>HD/) || ($item[$i] !~ /����/)) {
        &ERROR("���� �＼���Դϴ�.");
    }
    $itai[$i]--;
    if ($itai[$i] <= 0) {
        $item[$i] = "����"; $eff[$i] = $itai[$i] = 0 ;
    }
    local($in, $ik) = split(/<>/, $item[$wk]);
    $log = ($log . "$in�� ���� �������ϴ�. ������ ���� �ʵ��� ��������...<br>") ;
    if ($club eq "�丮��") {
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
# �� Ը̸?��      #
#==================#
sub PSCHECK {

    local($wk) = $Command;
    $wk =~ s/PSC_//g;
    if ($item[$wk] !~ /<>SH|<>HH|<>SD|<>HD/) {
        &ERROR("���� �＼���Դϴ�.");
    }
    local($in, $ik) = split(/<>/, $item[$wk]);
    if ($ik =~ /SH|HH/) {
        $log = ($log . "����... $in��(��) �Ծ ������ �� ����...<br>") ;
    } else {
        $log = ($log . "����... $in��(��) ���� ���� �ִµ� �ϴ�...<br>") ;
    }
    $sta -= $dokumi_sta ;
    if ($sta <= 0) {    #�����߫�﷪죿
        &DRAIN("com");
    }
    &SAVE ;
    $Command = "MAIN" ;
}

1
