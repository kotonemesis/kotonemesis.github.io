#==================#
# ■ アイテム取得  #
#==================#
sub ITEMGET {

    local($i) = 0 ;
    local($chkflg) = -1;
    local($sub) = "";

    local($filename) = "$LOG_DIR/$pls$item_file";


    open(DB,"$filename");seek(DB,0,0); @itemlist=<DB>;close(DB);

    if ($#itemlist < 0) {
        $log = ($log . "이제, 이 지역에는 아무것도 없는건가...?<BR>") ;
        $chksts="OK";
        return ;
    } else {
        local($work) = int(rand($#itemlist)) ;
        local($getitem,$geteff,$gettai) = split(/,/, $itemlist[$work]) ;
        local($itname,$itkind) = split(/<>/, $getitem);
        local($delitem) = splice(@itemlist,$work,1) ;
        for ($i=0; $i<5; $i++) {
            if (($item[$i] eq "없음") || (($item[$i] eq $getitem) && ($getitem =~ /<>WC|<>TN|<>NR|탄환|화살/))) {
                $chkflg = $i;last;
            }
        }

        if ($getitem =~ /<>TO/) { #?
            open(DB,">$filename"); seek(DB,0,0); print DB @itemlist; close(DB);

            $result = int(rand($geteff/2)+($geteff/2));
            $log = ($log . "덫이다! 설치되어 있던 $itname에 상처를 입어\, <font color=\"red\"><b>$result의 데미지</b></font>를 입었다!<BR>") ;
            $hit-=$result;
            if ($hit <= 0) {
                $hit = 0;
                $log = ($log . "<font color=\"red\"><b>$f_name $l_name \($cl $sex$no번\)은\(는\) 사망했다.</b></font><br>") ;
                #死亡ログ
                &LOGSAVE("DEATH") ;
                $mem--;
                if ($mem == 1) {&LOGSAVE("WINEND1") ;}
            }
            return ;
        }

        if ($chkflg == -1) { #所持品オ?バ?
            $log = ($log . "$itname을\(를\) 발견했다. 그러나\, 더 이상 가방에 들어가지 않는다.<BR>$itname을\(를\) 포기했다...<BR>") ;
            $Command = "MAIN";
        } else {
            open(DB,">$filename"); seek(DB,0,0); print DB @itemlist; close(DB);

            if(($getitem =~ /<>HH/)||($getitem =~ /<>HD/)) {
                $sub = "먹으면 체력이 회복될것 같아.";
            } elsif(($getitem =~ /<>SH/)||($getitem =~ /<>SD/)) {
                $sub = "먹으면 스테미너가 회복될것 같아.";
            } elsif ($getitem =~ /<>W/) { #武器？
                $sub = "이건 무기가 될듯해.";
            } elsif($getitem =~ /<>D/) { #防具
                $sub = "이건 방어구가 될듯해.";
            } elsif($getitem =~ /<>A/) { #?飾
                $sub = "이건 몸에 달수 있을것 같아.";
            } elsif($getitem =~ /<>TN/) { #?
                $sub = "이것으로 덫을 설치할 수 있을것 같아.";
            } else {
                $sub = "분명 뭔가에 쓸 수 있겠지.";
            }

            ($itname,$kind) = split(/<>/, $getitem) ;
            $log = ($log . "$itname을(를) 발견했다. $sub<BR>") ;

            if ($item[$chkflg] eq "없음") {
                $item[$chkflg] = $getitem; $eff[$chkflg] = $geteff; $itai[$chkflg] = $gettai;
            }elsif ($item[$chkflg] =~ /탄환|화살/) {
                $eff[$chkflg] += $geteff;
            } else {
                $itai[$chkflg] += $gettai ;
            }
        }
    }
    $chksts="OK";

}
#==================#
# ■ アイテム使用  #
#==================#
sub ITEM {

    local($result) = 0;
    local($wep2) = "" ;
    local($watt2) = 0;
    local($wtai2) = 0 ;
    local($up) = 0 ;

    local($wk) = $Command;
    $wk =~ s/ITEM_//g;

    if ($item[$wk] eq "없음") {
        &ERROR("부정 억세스입니다.");
    }

    local($in, $ik) = split(/<>/, $item[$wk]);
    local($w_name,$w_kind) = split(/<>/, $wep);
    local($d_name,$d_kind) = split(/<>/, $bou);

    if ($item[$wk] =~ /<>SH/) { #スタミナ回復
        $log = ($log . "$in을(를) 사용했다.<BR>스테미너가 회복됐다.<BR>");
        $sta += $eff[$wk] ;
        if ($sta > $maxsta) {$sta = $maxsta;}
        $itai[$wk] --;
        if ($itai[$wk] == 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ; }
    } elsif($item[$wk] =~ /<>HH/) { #?力回復
        $log = ($log . "$in을(를) 사용했다.<BR>체력이 회복됐다.<BR>");
        $hit += $eff[$wk] ;
        if ($hit > $mhit) {$hit = $mhit;}
        $itai[$wk] --;
        if ($itai[$wk] == 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ; }
    } elsif($item[$wk] =~ /<>SD|<>HD/) {    #毒入り
        if ($item[$wk] =~ /<>SD2|<>HD2/) {  #料理?究部特製？
            $result = int($eff[$wk]*1.5) ;
        } else { $result = $eff[$wk] ; }
        $hit -= $result ;
        $log = ($log . "윽\, 큰일났다! 아무래도 독이 들어가 있었던 것 같다!<br><font color=\"red\"><b>$result데미지</b></font>!<BR>\n") ;
        $itai[$wk] --;
        if ($itai[$wk] == 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ; }
        if ($hit <= 0) {
            $log = ($log . "<font color=\"red\"><b>$f_name $l_name \($cl $sex$no번\)은\(는\) 사망했다.</b></font><br>\n") ;
            $com = int(rand(6)) ;
            #死亡ログ
            &LOGSAVE("DEATH1") ;
            $mem--;
            if ($mem == 1) { &LOGSAVE("WINEND1"); }
            &SAVE;return;
        }
    } elsif(($item[$wk] =~ /<>W/) && ($item[$wk] !~ /<>WF/)) {  #武器?備
        $log = ($log . "$in을(를) 장비했다.<BR>") ;
        $wep2 = $wep; $watt2 = $watt; $wtai2 = $wtai ;
        $wep = $item[$wk]; $watt = $eff[$wk]; $wtai = $itai[$wk] ;
        if ($wep2 !~ /맨손/) {
            $item[$wk] = $wep2; $eff[$wk] = $watt2; $itai[$wk] = $wtai2 ;
        } else {
            $item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>DB/) { #防具?備（?）
        $log = ($log . "$in을(를) 몸에 장비했다.<BR>");
        $bou2 = $bou; $bdef2 = $bdef; $btai2 = $btai ;
        $bou = $item[$wk]; $bdef = $eff[$wk]; $btai = $itai[$wk] ;
        if ($bou2 !~ /속옷/) {
            $item[$wk] = $bou2; $eff[$wk] = $bdef2; $itai[$wk] = $btai2 ;
        } else {
            $item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>DH/) { #防具?備（頭）
        $log = ($log . "$in을(를) 머리에 장비했다.<BR>");
        $bou2 = $bou_h; $bdef2 = $bdef_h; $btai2 = $btai_h ;
        $bou_h = $item[$wk]; $bdef_h = $eff[$wk]; $btai_h = $itai[$wk] ;
        if ($bou2 !~ /없음/) {
            $item[$wk] = $bou2; $eff[$wk] = $bdef2; $itai[$wk] = $btai2 ;
        } else {
            $item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>DF/) { #防具?備（足）
        $log = ($log . "$in을(를) 다리에 장비했다.<BR>");
        $bou2 = $bou_f; $bdef2 = $bdef_f; $btai2 = $btai_f ;
        $bou_f = $item[$wk]; $bdef_f = $eff[$wk]; $btai_f = $itai[$wk] ;
        if ($bou2 !~ /없음/) {
            $item[$wk] = $bou2; $eff[$wk] = $bdef2; $itai[$wk] = $btai2 ;
        } else {
            $item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>DA/) { #防具?備（腕）
        $log = ($log . "$in을(를) 팔에 장비했다.<BR>");
        $bou2 = $bou_a; $bdef2 = $bdef_a; $btai2 = $btai_a ;
        $bou_a = $item[$wk]; $bdef_a = $eff[$wk]; $btai_a = $itai[$wk] ;
        if ($bou2 !~ /없음/) {
            $item[$wk] = $bou2; $eff[$wk] = $bdef2; $itai[$wk] = $btai2 ;
        } else {
            $item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>A/) {  #アクセサリ?備
        $log = ($log . "$in을(를) 몸에 달았다.<BR>");
        $bou2 = $item[5]; $bdef2 = $eff[5]; $btai2 = $itai[5] ;
        $item[5] = $item[$wk]; $eff[5] = $eff[$wk]; $itai[5] = $itai[$wk] ;
        if ($bou2 !~ /없음/) {
            $item[$wk] = $bou2; $eff[$wk] = $bdef2; $itai[$wk] = $btai2 ;
        } else {
            $item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;
        }
    } elsif($item[$wk] =~ /<>R/) {  #レ?ダ?
        &HEADER;
        require "$reader_file";
        &READER;
        &FOOTER;
    } elsif($item[$wk] =~ /<>TN/) { #?
        $log = ($log . "$in을(를) 덫으로 설치했다. 스스로도 조심하지 않으면...<BR>");

        $item[$wk] =~ s/TN/TO/g ;

        $filename = "$LOG_DIR/$pls$item_file";

        open(DB,"$filename");seek(DB,0,0); @itemlist=<DB>;close(DB);
        push(@itemlist,"$item[$wk],$eff[$wk],$itai[$wk],\n") ;
        open(DB,">$filename"); seek(DB,0,0); print DB @itemlist; close(DB);
        $itai[$wk] -- ;
        $item[$wk] =~ s/TO/TN/g ;
        if ($itai[$wk] <= 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
    } elsif((($in eq "숫돌")||($in eq "옷감")) && ($wep =~ /<>WN/)) { #숫돌 사용&나이프계 장비?
        $watt += $eff[$wk]; if ($watt > 30) { $watt = 30 ; }
        $log = ($log . "$in을(를) 사용했다.$w_name의 공격력이 $watt 이(가) 되었다.<BR>");
        $itai[$wk] -- ;
        if ($itai[$wk] <= 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
    } elsif(($in eq "바느질도구") && ($d_kind eq "DBN") && ($d_name ne "속옷")) { #바느질도구&옷계열 장비?
        $btai += $eff[$wk]; if ($btai > 30) { $btai = 30 ; }
        $log = ($log . "$in을(를) 사용했다.$d_name의 내구력이 $btai 이(가) 되었다.<BR>");
        $itai[$wk] -- ;
        if ($itai[$wk] <= 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
    } elsif(($in eq "탄환") && ($wep =~ /<>WG/)) {  #탄환 사용&총 계열 장비?
        $up = $eff[$wk] + $wtai;if ($up > 6) { $up = 6 - $wtai ; } else { $up = $eff[$wk]; }
        $wtai += $up ; $eff[$wk] -= $up ;
        if ($eff[$wk] <= 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
        if ($wep =~ /<>WGB/) { $wep =~ s/<>WGB/<>WG/g ; }
        $log = ($log . "$in을(를) $w_name에 장전했다.<BR>$w_name의 사용횟수가 $up 올랐다.<BR>");
    } elsif(($in =~ /화살/) && ($wep =~ /<>WA/)) {    #화살 사용&활 계열 장비?
        $up = $eff[$wk] + $wtai;if ($up > 6) { $up = 6 - $wtai ; }else { $up = $eff[$wk]; }
        $wtai += $up ; $eff[$wk] -= $up ;
        if ($eff[$wk] <= 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
        if ($wep =~ /<>WAB/) { $wep =~ s/<>WAB/<>WA/g ; }
        $log = ($log . "$in을(를) 사용해서, $w_name을(를) 보충했다.<BR>$w_name의 사용횟수가 $up 올랐다.<BR>");
    } elsif($in =~ /확성기/){
    	$Command = "SPIICH";
    	return;
    } elsif($in =~ /배터리/){
        my($pc_ck) = 0;
        for ($paso=0; $paso<5; $paso++){
            if (($item[$paso] eq "모바일PC<>Y")&&($itai[$paso] < 5)){
                $itai[$paso] += $eff[$wk];
                if($itai[$paso] > 5){ $itai[$paso] = 5; }
                $itai[$wk] -- ;
                if ($itai[$wk] <= 0) {$item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;}
                $log = ($log . "$in로 모바일PC를 충전했다. 모바일PC의 사용횟수가 $itai[$paso]이(가) 되었다.<BR>");
                $pc_ck = 1;
                last;
            }
        }
        if ($pc_ck == 0){
            $log = ($log . "이건 어디에 쓰는 것일까...<BR>");$Command="MAIN";
        }
    } elsif($in eq "프로그램해제키") {
        if ($pls == 0){
            $inf = ($inf . "해");
            open(FLAG,">$end_flag_file"); print(FLAG "해제종료\n"); close(FLAG);
            $log = ($log . "해제키를 써서 프로그램을 정지시켰다.<br>목걸이를 벗었다!<BR>");$Command="MAIN";
            &SAVE; &LOGSAVE("EX_END");
	        require "$ending_file";
			&SURVIVORSAVE; &ENDING;
        }else{
            $log = ($log . "여기에서 써도 의미가 없다...<BR>");$Command="MAIN";
        }
    } else {
        $log = ($log . "이건 어디에 쓰는 것일까...<BR>");$Command="MAIN";
    }

    $Command = "MAIN";

    &SAVE;

}

#==================#
# ■ アイテム投棄  #
#==================#
sub ITEMDEL {

    local($wk) = $Command;
    $wk =~ s/DEL_//g;

    if ($item[$wk] eq "없음") {
        &ERROR("부정 억세스입니다.");
    }

    local($in, $ik) = split(/<>/, $item[$wk]);

    $log = ($log . "$in을(를) 버렸다.<br>") ;

    local($filename) = "$LOG_DIR/$pls$item_file";
    open(DB,"$filename");seek(DB,0,0); @itemlist=<DB>;close(DB);
    push(@itemlist,"$item[$wk],$eff[$wk],$itai[$wk],\n") ;
    open(DB,">$filename"); seek(DB,0,0); print DB @itemlist; close(DB);

    $item[$wk] = "없음"; $eff[$wk] = 0; $itai[$wk] = 0 ;
    $Command = "MAIN";

    &SAVE;

}
#==================#
# ■ ?備武器外す?理  #
#==================#
sub WEPDEL {

    local($j) = 0 ;

    if ($wep =~ /맨손/) {
        $log = ($log . "$l_name은(는) 무기를 장비하고 있지 않습니다.<br>") ;
        $Command = "MAIN" ;
        return ;
    }

    ($w_name,$w_kind) = split(/<>/, $wep);

    local($chk) = "NG" ;
    for ($j=0; $j<5; $j++) {
        if ($item[$j] eq "없음") {
            $chk = "ON" ; last;
        }
    }

    if ($chk eq "NG") {
        $log = ($log . "더 이상 배낭에 들어가지 않습니다.<br>") ;
    } else {
        $log = ($log . "$w_name을(를) 배낭에 넣었습니다.<br>") ;
        $item[$j] = $wep; $eff[$j] = $watt; $itai[$j] = $wtai ;
        $wep = "맨손<>WP"; $watt = 0; $wtai = "∞" ;
        &SAVE ;
    }

    $Command = "MAIN" ;

}
#==================#
# ■ ?備武器投棄  #
#==================#
sub WEPDEL2 {

    if ($wep =~ /맨손/) {
        $log = ($log . "$l_name은(는) 무기를 장비하고 있지 않습니다.<br>") ;
        $Command = "MAIN" ;
        return ;
    }

    local($in, $ik) = split(/<>/, $wep);

    $log = ($log . "$in을(를) 버렸다.<br>") ;

    local($filename) = "$LOG_DIR/$pls$item_file";
    open(DB,"$filename");seek(DB,0,0); @itemlist=<DB>;close(DB);
    push(@itemlist,"$wep,$watt,$wtai,\n") ;
    open(DB,">$filename"); seek(DB,0,0); print DB @itemlist; close(DB);

    $wep = "맨손<>WP"; $watt = 0; $wtai = "∞" ;
    $Command = "MAIN";

    &SAVE;

}
1
