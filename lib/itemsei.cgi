#==================#
# �� �����ƫ����� #
#==================#
sub ITEMSEIRI {

local($wk) = $Command;
$wk =~ s/SEIRI_//g;
local($in, $ik) = split(/<>/, $item[$wk]);

local($wk2) = $Command2;
$wk2 =~ s/SEIRI2_//g;
local($in2, $ik2) = split(/<>/, $item[$wk2]);

if (($item[$wk] eq "����")||($item[$wk2] eq "����")) {
&ERROR("���� �＼���Դϴ�.");
}

$log = ($log . "�������� �����մϴ�.<br>") ;

if ($wk == $wk2) { #�ҫ����ƫ���?��
    $log = ($log . "$in��(��) ���ĳ־����ϴ�.<br>") ;
}elsif (($in eq $in2)&&($eff[$wk] eq $eff[$wk2])&&($ik =~ /HH|HD/)&&($ik2 =~ /HH|HD/)) { #?�����֫����ƫ�����
    $itai[$wk] = $itai[$wk] + $itai[$wk2];
    if (($ik eq "HD")||($ik2 eq "HD")) {
        $item[$wk] = "$in<>HD";
    }
    if(($ik eq "HD2")||($ik2 eq "HD2")) {
        $item[$wk] = "$in<>HD2";
    }
    $item[$wk2] = "����"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;
    $log = ($log . "$in��(��) ��Ҵ�.<br>") ;
}elsif (($in eq $in2)&&($eff[$wk] eq $eff[$wk2])&&($ik =~ /SH|SD/)&&($ik2 =~ /SH|SD/)) { #�����߫����֫����ƫ�����
        $itai[$wk] = $itai[$wk] + $itai[$wk2];
    if (($ik eq "SD")||($ik2 eq "SD")) {
        $item[$wk] = "$in<>SD";
    }
    if(($ik eq "SD2")||($ik2 eq "SD2")) {
        $item[$wk] = "$in<>SD2";
    }
    $item[$wk2] = "����"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;
    $log = ($log . "$in��(��) ��Ҵ�.<br>") ;
}elsif (($in eq $in2)&&($ik eq $ik2)&&(($ik =~ /WC|WD/)||($in =~ /����/))) { #��??������?Ը?����
    $itai[$wk] = $itai[$wk] + $itai[$wk2];
    $item[$wk2] = "����"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;
    $log = ($log . "$in��(��) ��Ҵ�.<br>") ;
}elsif ((($in eq $in2)&&($ik eq $ik2)&&($ik eq "Y"))&&($in =~ /ź|ȭ��/)) { #?��?��
    $eff[$wk] = $eff[$wk] + $eff[$wk2];
    $item[$wk2] = "����"; $eff[$wk2] = 0; $itai[$wk2] = 0 ;
    $log = ($log . "$in��(��) ��Ҵ�.<br>") ;
}else { #�ު������ƫ�?﫪���ʪ�ڪ��?
$log = ($log . "$in��(��) $in2��(��) ������� �ʴ±���.<br>") ;
}

$Command = "MAIN";
$Command2 = "";

&SAVE;

}

1
