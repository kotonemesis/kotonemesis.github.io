### ハッキング?理 by kelp###

sub HACKING{
    if ($Command ne "HACK") {
    &ERROR("부정 억세스입니다.");
    }

    for ($paso=0; $paso<5; $paso++){
        if ($item[$paso] eq "모바일PC<>Y"){ last; }
    }

	if ( $itai[$paso] <= 0 ) {
		$log = ($log . "모바일PC에 전원이 들어오지 않는다. 배터리가 없는걸까...<BR>");
		return;
	}

    local($bonus) = 0;  #基本成功率(0の時10%)
    local($dice1) = int(rand(10)) ;
    local($dice2) = int(rand(10)) ;

    if ($club =~ /컴퓨터부/){ #パソコン部の基本成功率
        $bonus = 5;
    }


    local($kekka) = $bonus;
    if ($dice1 <= $kekka){     #ハッキング成否判定
        open(DB,"$area_file");seek(DB,0,0); my(@wk_arealist)=<DB>;close(DB);
        my($wk_ar,$wk_hack,$wk_a) = split(/,/, $wk_arealist[1]);  #ハッキングフラグ取得
        $wk_hack = 1;
        $wk_arealist[1] = "$wk_ar,$wk_hack,\n";
        open(DB,">$area_file"); seek(DB,0,0); print DB @wk_arealist; close(DB);
        $log = ($log . "해킹 성공! 모든 금지지역이 해제되었다!!<BR>") ;
    }else{
        $log = ($log . "해킹은 실패했다...<BR>") ;
    }

    if ($dice1 >= 9){   #バッテリ消耗＆ファンブル時機材破?
        $item[$paso] = "없음"; $eff[$paso] = $itai[$paso] = 0 ;
        $log = ($log . "왜이러지! 장치가 부서지고 말았다.<BR>") ;
        if ($dice2 >= 9){  #神?(％ファンブル)時政府により首輪爆破！
            $hit = 0 ; $sts = "사망"; $death = $deth = "정부에 의해 처형";$mem--;
            if ($mem == 1) {
                open(FLAG,">$end_flag_file"); print(FLAG "종료\n"); close(FLAG);
            }
            &LOGSAVE("DEATH5") ;
            open(DB,"$gun_log_file");seek(DB,0,0); @gunlog=<DB>;close(DB);
            $gunlog[1] = "$now,$place[$pls],$id,,\n";
            open(DB,">$gun_log_file"); seek(DB,0,0); print DB @gunlog; close(DB);
            $log = ($log . "왜이러지! 장치가 부서지고 말았다.<BR><br>...뭐지?...목걸이에서 경고음이\.\.\.\!\?<BR><BR><font color=\"red\">...!!...<br><br><b>$f_name $l_name \($cl $sex$no번\)은\(는\) 사망했다.</b></font><br>") ;
        }
    }else{
        $itai[$paso] --;
        if ($itai[$paso] == 0) {
            $log = ($log . "모바일PC의 배터리를 다 써버렸다.<BR>") ;
        }
    }

    &SAVE;
}
1
