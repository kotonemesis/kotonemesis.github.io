#==================#
# �� �����ƫ�����  #
#==================#
sub ITEMGET {

    local($i) = 0 ;
    local($chkflg) = -1;
    local($sub) = "";

    local($filename) = "$LOG_DIR/$pls$item_file";


    open(DB,"$filename");seek(DB,0,0); @itemlist=<DB>;close(DB);

    if ($#itemlist < 0) {
        $log = ($log . "����, �� �������� �ƹ��͵� ���°ǰ�...?<BR>") ;
        $chksts="OK";
        return ;
    } else {
        local($work) = int(rand($#itemlist)) ;
        local($getitem,$geteff,$gettai) = split(/,/, $itemlist[$work]) ;
        local($itname,$itkind) = split(/<>/, $getitem);
        local($delitem) = splice(@itemlist,$work,1) ;
        for ($i=0; $i<5; $i++) {
            if (($item[$i] eq "����") || (($item[$i] eq $getitem) && ($getitem =~ /<>WC|<>TN|<>NR|źȯ|ȭ��/))) {
                $chkflg = $i;last;
            }
        }

        if ($getitem =~ /<>TO/) { #?
            open(DB,">$filename"); seek(DB,0,0); print DB @itemlist; close(DB);

            $result = int(rand($geteff/2)+($geteff/2));
            $log = ($log . "���̴�! ��ġ�Ǿ� �ִ� $itname�� ��ó�� �Ծ�\, <font color=\"red\"><b>$result�� ������</b></font>�� �Ծ���!<BR>") ;
            $hit-=$result;
            if ($hit <= 0) {
                $hit = 0;
                $log = ($log . "<font color=\"red\"><b>$f_name $l_name \($cl $sex$no��\)��\(��\) ����ߴ�.</b></font><br>") ;
                #���̫�
                &LOGSAVE("DEATH") ;
                $mem--;
                if ($mem == 1) {&LOGSAVE("WINEND1") ;}
            }
            return ;
        }

        if ($chkflg == -1) { #������?��?
            $log = ($log . "$itname��\(��\) �߰��ߴ�. �׷���\, �� �̻� ���濡 ���� �ʴ´�.<BR>$itname��\(��\) �����ߴ�...<BR>") ;
            $Command = "MAIN";
        } else {
            open(DB,">$filename"); seek(DB,0,0); print DB @itemlist; close(DB);

            if(($getitem =~ /<>HH/)||($getitem =~ /<>HD/)) {
                $sub = "������ ü���� ȸ���ɰ� ����.";
            } elsif(($getitem =~ /<>SH/)||($getitem =~ /<>SD/)) {
                $sub = "������ ���׹̳ʰ� ȸ���ɰ� ����.";
            } elsif ($getitem =~ /<>W/) { #���
                $sub = "�̰� ���Ⱑ �ɵ���.";
            } elsif($getitem =~ /<>D/) { #����
                $sub = "�̰� ���� �ɵ���.";
            } elsif($getitem =~ /<>A/) { #?��
                $sub = "�̰� ���� �޼� ������ ����.";
            } elsif($getitem =~ /<>TN/) { #?
                $sub = "�̰����� ���� ��ġ�� �� ������ ����.";
            } else {
                $sub = "�и� ������ �� �� �ְ���.";
            }

            ($itname,$kind) = split(/<>/, $getitem) ;
            $log = ($log . "$itname��(��) �߰��ߴ�. $sub<BR>") ;

            if ($item[$chkflg] eq "����") {
                $item[$chkflg] = $getitem; $eff[$chkflg] = $geteff; $itai[$chkflg] = $gettai;
            }elsif ($item[$chkflg] =~ /źȯ|ȭ��/) {
                $eff[$chkflg] += $geteff;
            } else {
                $itai[$chkflg] += $gettai ;
            }
        }
    }
    $chksts="OK";

}
#==================#
# �� �����ƫ�����  #
#==================#
sub ITEM {

    local($result) = 0;
    local($wep2) = "" ;
    local($watt2) = 0;
    local($wtai2) = 0 ;
    local($up) = 0 ;

    local($wk) = $Command;
    $wk =~ s/ITEM_//g;

    if ($item[$wk] eq "����") {
        &ERROR("���� �＼���Դϴ�.");
    }

    local($in, $ik) = split(/<>/, $item[$wk]);
    local($w_name,$w_kind) = split(/<>/, $wep);
    local($d_name,$d_kind) = split(/<>/, $bou);

    if ($item[$wk] =~ /<>SH/) { #�����߫�����
        $log = ($log . "$in��(��) ����ߴ�.<BR>���׹̳ʰ� ȸ���ƴ�.<BR>");
        $sta += $eff[$wk] ;
        if ($sta > $maxsta) {$sta = $maxsta;}
        $itai[$wk] --;
        if ($itai[$wk] == 0) {$item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ; }
    } elsif($item[$wk] =~ /<>HH/) { #?������
        $log = ($log . "$in��(��) ����ߴ�.<BR>ü���� ȸ���ƴ�.<BR>");
        $hit += $eff[$wk] ;
        if ($hit > $mhit) {$hit = $mhit;}
        $itai[$wk] --;
        if ($itai[$wk] == 0) {$item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ; }
    } elsif($item[$wk] =~ /<>SD|<>HD/) {    #Ը����
        if ($item[$wk] =~ /<>SD2|<>HD2/) {  #����?ϼݻ��𲣿
            $result = int($eff[$wk]*1.5) ;
        } else { $result = $eff[$wk] ; }
        $hit -= $result ;
        $log = ($log . "��\, ū�ϳ���! �ƹ����� ���� �� �־��� �� ����!<br><font color=\"red\"><b>$result������</b></font>!<BR>\n") ;
        $itai[$wk] --;
        if ($itai[$wk] == 0) {$item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ; }
        if ($hit <= 0) {
            $log = ($log . "<font color=\"red\"><b>$f_name $l_name \($cl $sex$no��\)��\(��\) ����ߴ�.</b></font><br>\n") ;
            $com = int(rand(6)) ;
            #���̫�
            &LOGSAVE("DEATH1") ;
            $mem--;
            if ($mem == 1) { &LOGSAVE("WINEND1"); }
            &SAVE;return;
        }
    } elsif(($item[$wk] =~ /<>W/) && ($item[$wk] !~ /<>WF/)) {  #����?��
        $log = ($log . "$in��(��) ����ߴ�.<BR>") ;
        $wep2 = $wep; $watt2 = $watt; $wtai2 = $wtai ;
        $wep = $item[$wk]; $watt = $eff[$wk]; $wtai = $itai[$wk] ;
        if ($wep2 !~ /�Ǽ�/) {
            $item[$wk] = $wep2; $eff[$wk] = $watt2; $itai[$wk] = $wtai2 ;
        } else {
            $item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>DB/) { #����?�ᣨ?��
        $log = ($log . "$in��(��) ���� ����ߴ�.<BR>");
        $bou2 = $bou; $bdef2 = $bdef; $btai2 = $btai ;
        $bou = $item[$wk]; $bdef = $eff[$wk]; $btai = $itai[$wk] ;
        if ($bou2 !~ /�ӿ�/) {
            $item[$wk] = $bou2; $eff[$wk] = $bdef2; $itai[$wk] = $btai2 ;
        } else {
            $item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>DH/) { #����?�ᣨ�飩
        $log = ($log . "$in��(��) �Ӹ��� ����ߴ�.<BR>");
        $bou2 = $bou_h; $bdef2 = $bdef_h; $btai2 = $btai_h ;
        $bou_h = $item[$wk]; $bdef_h = $eff[$wk]; $btai_h = $itai[$wk] ;
        if ($bou2 !~ /����/) {
            $item[$wk] = $bou2; $eff[$wk] = $bdef2; $itai[$wk] = $btai2 ;
        } else {
            $item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>DF/) { #����?�ᣨ�룩
        $log = ($log . "$in��(��) �ٸ��� ����ߴ�.<BR>");
        $bou2 = $bou_f; $bdef2 = $bdef_f; $btai2 = $btai_f ;
        $bou_f = $item[$wk]; $bdef_f = $eff[$wk]; $btai_f = $itai[$wk] ;
        if ($bou2 !~ /����/) {
            $item[$wk] = $bou2; $eff[$wk] = $bdef2; $itai[$wk] = $btai2 ;
        } else {
            $item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>DA/) { #����?�ᣨ�ӣ�
        $log = ($log . "$in��(��) �ȿ� ����ߴ�.<BR>");
        $bou2 = $bou_a; $bdef2 = $bdef_a; $btai2 = $btai_a ;
        $bou_a = $item[$wk]; $bdef_a = $eff[$wk]; $btai_a = $itai[$wk] ;
        if ($bou2 !~ /����/) {
            $item[$wk] = $bou2; $eff[$wk] = $bdef2; $itai[$wk] = $btai2 ;
        } else {
            $item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>A/) {  #����������?��
        $log = ($log . "$in��(��) ���� �޾Ҵ�.<BR>");
        $bou2 = $item[5]; $bdef2 = $eff[5]; $btai2 = $itai[5] ;
        $item[5] = $item[$wk]; $eff[5] = $eff[$wk]; $itai[5] = $itai[$wk] ;
        if ($bou2 !~ /����/) {
            $item[$wk] = $bou2; $eff[$wk] = $bdef2; $itai[$wk] = $btai2 ;
        } else {
            $item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>R/) {  #��?��?
        &HEADER;
        require "$reader_file";
        &READER;
        &FOOTER;
    } elsif($item[$wk] =~ /<>TN/) { #?
        $log = ($log . "$in��(��) ������ ��ġ�ߴ�. �����ε� �������� ������...<BR>");

        $item[$wk] =~ s/TN/TO/g ;

        $filename = "$LOG_DIR/$pls$item_file";

        open(DB,"$filename");seek(DB,0,0); @itemlist=<DB>;close(DB);
        push(@itemlist,"$item[$wk],$eff[$wk],$itai[$wk],\n") ;
        open(DB,">$filename"); seek(DB,0,0); print DB @itemlist; close(DB);
        $itai[$wk] -- ;
        $item[$wk] =~ s/TO/TN/g ;
        if ($itai[$wk] <= 0) {$item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
    } elsif((($in eq "����")||($in eq "�ʰ�")) && ($wep =~ /<>WN/)) { #���� ���&�������� ���?
        $watt += $eff[$wk]; if ($watt > 30) { $watt = 30 ; }
        $log = ($log . "$in��(��) ����ߴ�.$w_name�� ���ݷ��� $watt ��(��) �Ǿ���.<BR>");
        $itai[$wk] -- ;
        if ($itai[$wk] <= 0) {$item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
    } elsif(($in eq "�ٴ�������") && ($d_kind eq "DBN") && ($d_name ne "�ӿ�")) { #�ٴ�������&�ʰ迭 ���?
        $btai += $eff[$wk]; if ($btai > 30) { $btai = 30 ; }
        $log = ($log . "$in��(��) ����ߴ�.$d_name�� �������� $btai ��(��) �Ǿ���.<BR>");
        $itai[$wk] -- ;
        if ($itai[$wk] <= 0) {$item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
    } elsif(($in eq "źȯ") && ($wep =~ /<>WG/)) {  #źȯ ���&�� �迭 ���?
        $up = $eff[$wk] + $wtai;if ($up > 6) { $up = 6 - $wtai ; } else { $up = $eff[$wk]; }
        $wtai += $up ; $eff[$wk] -= $up ;
        if ($eff[$wk] <= 0) {$item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
        if ($wep =~ /<>WGB/) { $wep =~ s/<>WGB/<>WG/g ; }
        $log = ($log . "$in��(��) $w_name�� �����ߴ�.<BR>$w_name�� ���Ƚ���� $up �ö���.<BR>");
    } elsif(($in =~ /ȭ��/) && ($wep =~ /<>WA/)) {    #ȭ�� ���&Ȱ �迭 ���?
        $up = $eff[$wk] + $wtai;if ($up > 6) { $up = 6 - $wtai ; }else { $up = $eff[$wk]; }
        $wtai += $up ; $eff[$wk] -= $up ;
        if ($eff[$wk] <= 0) {$item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
        if ($wep =~ /<>WAB/) { $wep =~ s/<>WAB/<>WA/g ; }
        $log = ($log . "$in��(��) ����ؼ�, $w_name��(��) �����ߴ�.<BR>$w_name�� ���Ƚ���� $up �ö���.<BR>");
    } elsif($in =~ /Ȯ����/){
    	$Command = "SPIICH";
    	return;
    } elsif($in =~ /���͸�/){
        my($pc_ck) = 0;
        for ($paso=0; $paso<5; $paso++){
            if (($item[$paso] eq "�����PC<>Y")&&($itai[$paso] < 5)){
                $itai[$paso] += $eff[$wk];
                if($itai[$paso] > 5){ $itai[$paso] = 5; }
                $itai[$wk] -- ;
                if ($itai[$wk] <= 0) {$item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
                $log = ($log . "$in�� �����PC�� �����ߴ�. �����PC�� ���Ƚ���� $itai[$paso]��(��) �Ǿ���.<BR>");
                $pc_ck = 1;
                last;
            }
        }
        if ($pc_ck == 0){
            $log = ($log . "�̰� ��� ���� ���ϱ�...<BR>");$Command="MAIN";
        }
    } elsif($in eq "���α׷�����Ű") {
        if ($pls == 0){
            $inf = ($inf . "��");
            open(FLAG,">$end_flag_file"); print(FLAG "��������\n"); close(FLAG);
            $log = ($log . "����Ű�� �Ἥ ���α׷��� �������״�.<br>����̸� ������!<BR>");$Command="MAIN";
            &SAVE; &LOGSAVE("EX_END");
	        require "$ending_file";
			&SURVIVORSAVE; &ENDING;
        }else{
            $log = ($log . "���⿡�� �ᵵ �ǹ̰� ����...<BR>");$Command="MAIN";
        }
    } else {
        $log = ($log . "�̰� ��� ���� ���ϱ�...<BR>");$Command="MAIN";
    }

    $Command = "MAIN";

    &SAVE;

}

#==================#
# �� �����ƫ���ѥ  #
#==================#
sub ITEMDEL {

    local($wk) = $Command;
    $wk =~ s/DEL_//g;

    if ($item[$wk] eq "����") {
        &ERROR("���� �＼���Դϴ�.");
    }

    local($in, $ik) = split(/<>/, $item[$wk]);

    $log = ($log . "$in��(��) ���ȴ�.<br>") ;

    local($filename) = "$LOG_DIR/$pls$item_file";
    open(DB,"$filename");seek(DB,0,0); @itemlist=<DB>;close(DB);
    push(@itemlist,"$item[$wk],$eff[$wk],$itai[$wk],\n") ;
    open(DB,">$filename"); seek(DB,0,0); print DB @itemlist; close(DB);

    $item[$wk] = "����"; $eff[$wk] = 0; $itai[$wk] = 0 ;
    $Command = "MAIN";

    &SAVE;

}
#==================#
# �� ?�������⪹?��  #
#==================#
sub WEPDEL {

    local($j) = 0 ;

    if ($wep =~ /�Ǽ�/) {
        $log = ($log . "$l_name��(��) ���⸦ ����ϰ� ���� �ʽ��ϴ�.<br>") ;
        $Command = "MAIN" ;
        return ;
    }

    ($w_name,$w_kind) = split(/<>/, $wep);

    local($chk) = "NG" ;
    for ($j=0; $j<5; $j++) {
        if ($item[$j] eq "����") {
            $chk = "ON" ; last;
        }
    }

    if ($chk eq "NG") {
        $log = ($log . "�� �̻� �賶�� ���� �ʽ��ϴ�.<br>") ;
    } else {
        $log = ($log . "$w_name��(��) �賶�� �־����ϴ�.<br>") ;
        $item[$j] = $wep; $eff[$j] = $watt; $itai[$j] = $wtai ;
        $wep = "�Ǽ�<>WP"; $watt = 0; $wtai = "��" ;
        &SAVE ;
    }

    $Command = "MAIN" ;

}
#==================#
# �� ?��������ѥ  #
#==================#
sub WEPDEL2 {

    if ($wep =~ /�Ǽ�/) {
        $log = ($log . "$l_name��(��) ���⸦ ����ϰ� ���� �ʽ��ϴ�.<br>") ;
        $Command = "MAIN" ;
        return ;
    }

    local($in, $ik) = split(/<>/, $wep);

    $log = ($log . "$in��(��) ���ȴ�.<br>") ;

    local($filename) = "$LOG_DIR/$pls$item_file";
    open(DB,"$filename");seek(DB,0,0); @itemlist=<DB>;close(DB);
    push(@itemlist,"$wep,$watt,$wtai,\n") ;
    open(DB,">$filename"); seek(DB,0,0); print DB @itemlist; close(DB);

    $wep = "�Ǽ�<>WP"; $watt = 0; $wtai = "��" ;
    $Command = "MAIN";

    &SAVE;

}
1
