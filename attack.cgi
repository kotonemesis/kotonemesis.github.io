#==================#
# ■ 선제공격처리  #
#==================#
sub ATTACK {

    $log = ($log . "$w_f_name $w_l_name\($w_cl $w_sex$w_no번\)을\(를\) 발견했다\!<br>") ;
    $log = ($log . "$w_f_name $w_l_name은\(는\) 이쪽을 눈치채지 못한 것 같아\.\.\.<br>") ;

    $Command=("BATTLE0" . "_" . $w_id);

}
#==================#
# ■ 선제공격처리  #
#==================#
sub ATTACK1 {
    $kega2 = "" ; $kega3 = "" ;
    $hakaiinf2 = ""; $hakaiinf3 = "";

    local($i) = 0 ;
    local($result) = 0 ;
    local($result2) = 0 ;
    local($dice1) = int(rand(100)) ;
    local($dice2) = int(rand(100)) ;

    local($a,$w_kind,$wid) = split(/_/, $Command);

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);
    for ($i=0; $i<$#userlist+1; $i++) {
        ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);
        if ($w_id eq $wid) {
            $Index2=$i ; last;
        }
    }

	#연속공격 관련
	$w_bid2 = $w_bid;
	if ($tactics eq "연속공격") {$w_bid2 = "";}

	if (($w_bid2 eq $id)||($w_hit <= 0)) {
		&ERROR("부정 억세스입니다") ;
	}

    $log = ($log . "$w_f_name $w_l_name\($w_cl $w_sex$w_no번\)와\(과\) 전투개시\!<br>") ;

    ($w_name,$a) = split(/<>/, $wep);
    ($w_name2,$w_kind2) = split(/<>/, $w_wep);

	#무기와 방어구 이름 저장
    ($wepname,$zwep) = split(/<>/, $wep);
    ($w_wepname,$zwep2) = split(/<>/, $w_wep);
    ($bouname,$xbou) = split(/<>/, $bou);
    ($w_bouname,$xbou2) = split(/<>/, $w_bou);

    &TACTGET; &TACTGET2;    #기본행동

    #플레이어
    if ((($wep =~ /G|A/) && ($wtai == 0)) || (($wep =~ /G|A/) && ($w_kind eq "WB"))) {
        $att_p = (($watt/10) + $att) * $atp ;
    } else {
        $att_p = ($watt + $att) * $atp ;
    }
    local($ball) = $def + $bdef + $bdef_h + $bdef_a + $bdef_f ;
    if ($item[5] =~ /AD/) {$ball += $eff[5];} #악세사리가 방어구?
    $def_p = $ball * $dfp ;

    #적
    if (($w_wep =~ /G|A/) && ($w_wtai == 0)) {
        $att_n = (($w_watt/10) + $w_att) * $atn ;
    } else {
        $att_n = ($w_watt + $w_att) * $atn ;
    }
    local($ball2) = $w_def + $w_bdef + $w_bdef_h + $w_bdef_a + $w_bdef_f ;
    if ($w_item[5] =~ /AD/) {$ball2 += $w_eff[5];} #악세사리가 방어구?
    $def_n = $ball2 * $dfn ;
    $w_bid = $id ;
    $bid = $w_id ;

    &BLOG_CK;
    &EN_KAIFUKU;

    $Command="BATTLE";

    if ($w_pls ne $pls) {   #이미 이동?
        $log = ($log . "그러나\, $w_f_name $w_l_name\($w_cl $w_sex$w_no번\)은\(는\) 도망쳐 버렸다\!<br>") ;
        &SAVE;
        return ;
    }

    if (length($dengon) > 0) {
        $log = ($log . "<font color=\"lime\"><b>$f_name $l_name\($cl $sex$no번\)「$dengon」</b></font><br>") ;
        $w_log = ($w_log . "<font color=\"lime\"><b>$hour:$min:$sec $f_name $l_name\($cl $sex$no번\)「$dengon」</b></font><br>") ;
    }

    &WEPTREAT($w_name, $w_kind, $wtai, $l_name, $w_l_name, "공격", "PC") ;
    if ($dice1 < $mei) {    #공격성공
        $result = ($att_p*$wk) - $def_n;
#        $result = $att_p*$wk; #랜덤 방어력 관련 아래 주석 포함
        $result /= 2 ;
        $result += rand($result);

        &DEFTREAT($w_kind, "NPC") ;
        $result = int($result * $pnt) ;

#		$def_n /= 2; $def_n += rand($def_n);
#		$result -= int($def_n);
        if ($result <= 0) {$result = 1} ;
        $log = ($log . "<font color=\"red\"><b>$result데미지 $hakaiinf3 $kega3</b></font>\!<br>") ;

        $w_hit -= $result;
        if (int(rand(5)) == 0) { $w_btai--; }
        if ($w_btai <= 0) { $w_bou = "속옷<>DN"; $w_bdef=0; $w_btai="∞"; }

        $wep = $wep_2; $watt = $watt_2; $wtai = $wtai_2; $w_inf = $w_inf_2 ;

		#레벨차이에 따른 경험치 보정
		$levelchai = $w_level - $level;
		if ( $levelchai < 0 ) { $levelchai=0; }
		$exp -= int($levelchai/2) + 2;

    } else {
        $log = ($log . "그러나\, 피했다\! $hakaiinf3<br>") ;
    }

    if ($w_hit <= 0) {  #적사망?
        &DEATH2;
    } elsif (rand(10) < 5) {    #반격

        if ($weps eq $weps2) {  #거리

            &WEPTREAT($w_name2, $w_kind2, $w_wtai, $w_l_name, $l_name, "반격", "NPC") ;

            if ($dice2 < $mei2) {   #공격성공
                $result2 = ($att_n*$wk) - $def_p;
#                $result2 = $att_n*$wk; #랜덤 방어력 관련 아래 주석 포함
                $result2 /= 2 ;
                $result2 += rand($result2);

                &DEFTREAT($w_kind2, "PC") ;
                $result2 = int($result2 * $pnt) ;

#				$def_p /= 2; $def_p += rand($def_p);
#				$result2 -= int($def_p);
                if ($result2 <= 0) {$result2 = 1 ;}
                $log = ($log . "<font color=\"red\"><b>$result2데미지 $kega2</b></font>\!<br>") ;

                $hit -= $result2;
                if (int(rand(5)) == 0) { $btai--; }

                if ($btai <= 0) { $bou = "속옷<>DN"; $bdef=0; $btai="∞"; }

                if ($hit <=0) { #사망?
                    &DEATH;
                } else {    #도망
                    $log = ($log . "$w_l_name은\(는\) 도망갔다\.\.\.<br>") ;
                }
                $w_log = ($w_log . "<font color=\"yellow\"><b>$hour:$min:$sec 전투：$f_name $l_name\($cl $sex$no번\) 공격:$result2 피해:$result $hakaiinf2 $kega3 </b></font><br>") ;
                $w_wep = $w_wep_2; $w_watt = $w_watt_2; $w_wtai = $w_wtai_2; $inf = $inf_2 ;

				#레벨차이에 따른 경험치 보정
				$levelchai = $level - $w_level;
				if ( $levelchai < 0 ) { $levelchai=0; }
				$w_exp -= int($levelchai/2) + 1;

            } else {
                $w_log = ($w_log . "<font color=\"yellow\"><b>$hour:$min:$sec 전투：$f_name $l_name\($cl $sex$no번\) 피해:$result $hakaiinf2 $kega3 </b></font><br>") ;
                $log = ($log . "그러나\, 간발의 차이로 피했다\!<br>") ;
            }

            if (($w_kind2 =~ /G|A/) && ($w_wtai > 0)) { #탄 소모
                $w_wtai--; if ($w_wtai <= 0) {$w_wtai = 0 ;}
            } elsif ($w_kind2 =~ /C|D/) {
                $w_wtai--; if ($w_wtai <= 0) { $w_wep ="맨손<>WP"; $w_watt=0; $w_wtai="∞"; }
            } elsif (($w_kind2 =~ /N/) && (int(rand(5)) == 0)) {
                $w_watt -= int(rand(1)+1) ; if ($w_watt <= 0) { $w_wep ="맨손<>WP"; $w_watt=0; $w_wtai="∞"; }
            }

        } else {
            $log = ($log . "$w_l_name은\(는\) 반격할 수 없다\!<br>") ;
            $log = ($log . "$w_l_name은\(는\) 도망쳤다\.\.\.<br>") ;
            $w_log = ($w_log . "<font color=\"yellow\"><b>$hour:$min:$sec 전투：$f_name $l_name\($cl $sex$no번\) 피해:$result $hakaiinf2 $kega3 </b></font><br>") ;
        }
    } else {    #逃亡
        $log = ($log . "$w_l_name은\(는\) 도망쳤다\.\.\.<br>") ;
        $w_log = ($w_log . "<font color=\"yellow\"><b>$hour:$min:$sec 전투：$f_name $l_name\($cl $sex$no번\) 피해:$result $hakaiinf2 $kega3 </b></font><br>") ;
    }

    if (($w_kind =~ /G|A/) && ($wtai > 0)) {    #탄 소모
        $wtai--; if ($wtai <= 0) { $wtai = 0 ; }
    } elsif ($w_kind =~ /C|D/) {
        $wtai--; if ($wtai <= 0) { $wep ="맨손<>WP"; $watt=0; $wtai="∞"; }
    } elsif (($w_kind =~ /N/) && (int(rand(5)) == 0)) {
        $watt -= int(rand(1)+1) ; if ($watt <= 0) { $wep ="맨손<>WP"; $watt=0; $wtai="∞"; }
    }

    &LVUPCHK() ;


    &SAVE;
    &SAVE2;

}
#==================#
# ■ 후공공격처리  #
#==================#
sub ATTACK2 {
    $kega2 = "" ; $kega3 = "" ;
    $hakaiinf2 = ""; $hakaiinf3 = "";

    if ($w_hit <= 0) {
        &ERROR("부정 억세스입니다") ;
    }

    local($result) = 0 ;
    local($result2) = 0 ;
    local($i) = 0 ;
    local($dice1) = int(rand(100)) ;
    local($dice2) = int(rand(100)) ;
    ($w_name,$w_kind) = split(/<>/, $wep);
    ($w_name2,$w_kind2) = split(/<>/, $w_wep);

    &TACTGET; &TACTGET2;    #기본행동

    #플레이어
    if (($wep =~ /G|A/) && ($wtai == 0)) {
        $att_p = (($watt/10) + $att) * $atp ;
    } else {
        $att_p = ($watt + $att) * $atp ;
    }
    local($ball) = $def + $bdef + $bdef_h + $bdef_a + $bdef_f ;
    if ($item[5] =~ /AD/) {$ball += $eff[5];} #악세사리가 방어구?
    $def_p = $ball * $dfp ;

    #적
    if (($w_wep =~ /G|A/) && ($w_wtai == 0)) {
        $att_n = (($w_watt/10) + $w_att) * $atn ;
    } else {
        $att_n = ($w_watt + $w_att) * $atn ;
    }
    local($ball2) = $w_def + $w_bdef + $w_bdef_h + $w_bdef_a + $w_bdef_f ;
    if ($w_item[5] =~ /AD/) {$ball += $w_eff[5];} #악세사리가 방어구?
    $def_n = $ball2 * $dfn ;

    &BLOG_CK;
    &EN_KAIFUKU;

    $Command="BATTLE";

    $log = ($log . "$w_f_name $w_l_name\($w_cl $w_sex$w_no번\)이\(가\) 갑자기 습격해 왔다\!<br>") ;

    &WEPTREAT($w_name2, $w_kind2, $w_wtai, $w_l_name, $l_name, "공격", "NPC") ;
    if ($dice1 < $mei) {    #공격성공
        $result = ($att_n*$wk) - $def_p;
#        $result = $att_n*$wk;
        $result /= 2 ;
        $result += rand($result);

        &DEFTREAT($w_kind2, "PC") ;
        $result = int($result * $pnt) ;

#		$def_p /= 2; $def_p += rand($def_p);
#		$result -= int($def_p);
        if ($result <= 0) {$result = 1 ;}
        $log = ($log . "<font color=\"red\"><b>$result데미지 $kega2</b></font>\!<br>") ;

        $hit -= $result;
        if (int(rand(5)) == 0) { $btai--; }

        if ($btai <= 0) { $bou = "속옷<>DN"; $bdef=0; $btai="∞"; }
        $w_wep = $w_wep_2; $w_watt = $w_watt_2; $w_wtai = $w_wtai_2; $inf = $inf_2 ;
        ($w_name2,$w_kind2) = split(/<>/, $w_wep);

		#레벨차이에 따른 경험치 보정
		$levelchai = $level - $w_level;
		if ( $levelchai < 0 ) { $levelchai=0; }
		$w_exp -= int($levelchai/2) + 1;

    } else {
        $log = ($log . "그러나\, 간발의 차이로 피했다\!<br>") ;
    }

    if ($hit <= 0) {    #사망?
        &DEATH;
    } elsif (rand(10) <= 7) { #반격

        if ($weps eq $weps2) {

            &WEPTREAT($w_name, $w_kind, $wtai, $l_name, $w_l_name, "반격", "PC") ;
            if ($dice1 < $mei) {    #공격성공
                $result2 = ($att_p*$wk) - $def_n;
#                $result2 = $att_p*$wk;
                $result2 /= 2 ;
                $result2 += rand($result2);

                &DEFTREAT($w_kind, "NPC") ;
                $result2 = int($result2 * $pnt) ;

#				$def_n /= 2; $def_n += rand($def_n);
#				$result2 -= int($def_n);
                if ($result2 <= 0) {$result2 = 1 ;}
                $log = ($log . "<font color=\"red\"><b>$result2데미지 $hakaiinf3 $kega2</b></font>\!<br>") ;

                $w_hit -= $result2;
                if (int(rand(5)) == 0) { $w_btai--; }

                if ($w_btai <= 0) { $w_bou = "속옷<>DN"; $w_bdef=0; $w_btai="∞"; }

                if ($w_hit <=0) {   #사망?
                    &DEATH2;
                } else {    #도망
                    $log = ($log . "$l_name은\(는\) 도망쳤다\.\.\.<br>") ;
                }
                $w_log = ($w_log . "<font color=\"yellow\"><b>$hour:$min:$sec 전투：$f_name $l_name\($cl $sex$no번\) 공격:$result 피해:$result2 $hakaiinf2 $kega3 </b></font><br>") ;
                $wep = $wep_2; $watt = $watt_2; $wtai = $wtai_2; $w_inf = $w_inf_2 ;
                ($w_name,$w_kind) = split(/<>/, $wep);

				#레벨차이에 따른 경험치 보정
				$levelchai = $w_level - $level;
				if ( $levelchai < 0 ) { $levelchai=0; }
				$exp -= int($levelchai/2) + 2;

            } else {
                $w_log = ($w_log . "<font color=\"yellow\"><b>$hour:$min:$sec 전투：$f_name $l_name\($cl $sex$no번\) 공격:$result $hakaiinf2 $kega3 </b></font><br>") ;
                $log = ($log . "그러나\, 피했다\! <br>") ;
            }

            if (($w_kind =~ /G|A/) && ($wtai > 0)) {    #탄 소모
                $wtai--; if ($wtai <= 0) { $wtai = 0 ; }
            } elsif ($w_kind =~ /C|D/) {
                $wtai--; if ($wtai <= 0) { $wep ="맨손<>WP"; $watt=0; $wtai="∞"; }
            } elsif (($w_kind =~ /N/) && (int(rand(5)) == 0)) {
                $watt -= int(rand(1)+1) ; if ($watt <= 0) { $wep ="맨손<>WP"; $watt=0; $wtai="∞"; }
            }
        } else {
            $log = ($log . "$l_name은\(는\) 반격할 수 없다\!<br>") ;
            $log = ($log . "$l_name은\(는\) 도망쳤다\.\.\.<br>") ;
            $w_log = ($w_log . "<font color=\"yellow\"><b>$hour:$min:$sec 전투：$f_name $l_name\($cl $sex$no번\) 공격:$result $hakaiinf2 $kega3 </b></font><br>") ;
        }
    } else {    #도망
        $log = ($log . "$l_name은\(는\) 도망쳤다\.\.\.<br>") ;
        $w_log = ($w_log . "<font color=\"yellow\"><b>$hour:$min:$sec 전투：$f_name $l_name\($cl $sex$no번\) 공격:$result $hakaiinf2 $kega3 </b></font><br>") ;
    }

    if (($w_kind2 =~ /G|A/) && ($w_wtai > 0)) { #탄 소모
        $w_wtai--; if ($w_wtai <= 0) {$w_wtai = 0 ;}
    } elsif ($w_kind2 =~ /C|D/) {
        $w_wtai--; if ($w_wtai <= 0) { $w_wep ="맨손<>WP"; $w_watt=0; $w_wtai="∞"; }
    } elsif (($w_kind2 =~ /N/) && (int(rand(5)) == 0)) {
        $w_watt -= int(rand(1)+1) ; if ($w_watt <= 0) { $w_wep ="맨손<>WP"; $w_watt=0; $w_wtai="∞"; }
    }

    &LVUPCHK();


    &SAVE;
    &SAVE2;
}
#====================#
# ■ 무기종류별 처리 #
#====================#
sub WEPTREAT {

    local($wname)   = @_[0] ;   #무기
    local($wkind)   = @_[1] ;   #무기
    local($wwtai)   = @_[2] ;   #탄 수/사용가능횟수
    local($pn)      = @_[3] ;   #공격자 이름
    local($nn)      = @_[4] ;   #방어자 이름
    local($ind)     = @_[5] ;   #공격종별 (공격/반격)
    local($attman)  = @_[6] ;   #공격자 (PC/NPC)

    local($dice3) = int(rand(100)) ;
    local($dice4) = int(rand(4)) ;
    local($dice5) = int(rand(100)) ;
    local($dice6) = int(rand(100)) ;

    local($kega)    = 0 ;
    local($kegainf) = "" ;
    local($k_work) = "" ;
    local($hakai) =  0 ;

    if ((($wkind =~ /B/) || (($wkind =~ /G|A/) && ($wwtai == 0))) && ($w_name ne "맨손")) { #곤봉 or 탄 없는 총 or 화살 없는 활
		$log = ($log . "$pn의 $ind\! $wname(으)로 $nn을\(를\) 때렸다\!<br>") ;
        if ($attman eq "PC") {$wb++;$wk=$wb;} else {$w_wb++;$wk=$w_wb;}
        $kega = 5 ;$kegainf = "頭腕" ; #부상률, 부상부위
        $hakai = 3 ;    #파괴율
    } elsif ($wkind =~ /A/) {   #활
		$log = ($log . "$pn의 $ind\! $wname(으)로 $nn을\(를\) 겨냥해 쐈다\!<br>") ;
        if ($attman eq "PC") {$wa++;$wk=$wa;} else {$w_wa++;$wk=$w_wa;}
        $kega = 10 ; $kegainf = "頭腕腹足" ;    #부상률, 부상부위
        $hakai = 3 ;    #파괴율
    } elsif ($wkind =~ /C/) { #던지기
		$log = ($log . "$pn의 $ind\! $wname을\(를\) $nn에게 던졌다\!<br>") ;
        if ($attman eq "PC") {$wc++;$wk=$wc;} else {$w_wc++;$wk=$w_wc;}
        $kega = 7 ;$kegainf = "頭腕" ; #부상률, 부상부위
        $hakai = 0 ;    #파괴율
    } elsif ($wkind =~ /D/) { #폭탄
		$log = ($log . "$pn의 $ind\! $wname을\(를\) $nn에게 던졌다\!<br>") ;
        if ($attman eq "PC") {$wd++;$wk=$wd;} else {$w_wd++;$wk=$w_wd;}
        $kega = 15 ;$kegainf = "頭腕腹足" ; #부상률, 부상부위
        $hakai = 0 ;    #파괴율
    } elsif ($wkind =~ /G/) { #총
		$log = ($log . "$pn의 $ind\! $wname(으)로 $nn을\(를\) 겨냥해 발포했다\!<br>") ;
        if ($attman eq "PC") {$wg++;$wk=$wg;$ps=$pls;} else {$w_wg++;$wk=$w_wg;$ps=$w_pls;}
        $kega = 12 ; $kegainf = "頭腕腹足" ;    #부상률, 부상부위
        $hakai = 3 ;    #파괴율
        open(DB,"$gun_log_file");seek(DB,0,0); @gunlog=<DB>;close(DB);
        $gunlog[0] = "$now,$place[$ps],$id,$w_id,\n";
        open(DB,">$gun_log_file"); seek(DB,0,0); print DB @gunlog; close(DB);
    } elsif ($wkind =~ /S/) { #찌르기
		$log = ($log . "$pn의 $ind\! $wname(으)로 $nn을\(를\) 찔렀다\!<br>") ;
        if ($attman eq "PC") {$ws++;$wk=$ws;} else {$w_ws++;$wk=$w_ws;}
        $kega = 10 ; $kegainf = "頭腕腹足" ;    #부상률, 부상부위
        $hakai = 3 ;    #파괴율
    } elsif ($wkind =~ /N/) { #베기
		$log = ($log . "$pn의 $ind\! $wname(으)로 $nn을\(를\) 베었다\!<br>") ;
        if ($attman eq "PC") {$wn++;$wk=$wn;} else {$w_wn++;$wk=$w_wn;}
        $kega = 10 ; $kegainf = "頭腕腹足" ;    #부상률, 부상부위
        $hakai = 3 ;    #파괴율
    } elsif (($wkind =~ /P/) && ($w_name ne "맨손")) { #맨손
		$log = ($log . "$pn의 $ind\! $wname(으)로 $nn을\(를\) 때렸다\!<br>") ;
        if ($attman eq "PC") {$wp++;$wk=$wp;} else {$w_wp++;$wk=$w_wp;}
        $kega = 5 ; $kegainf = "頭" ; #부상률, 부상부위
        $hakai = 3 ;    #파괴율
    } else { #기타
		$log = ($log . "$pn의 $ind\! $wname(으)로 $nn을\(를\) 때렸다\!<br>") ;
        if ($attman eq "PC") {$wp++;$wk=$wp;} else {$w_wp++;$wk=$w_wp;}
        $kega = 3 ; $kegainf = "頭" ; #부상률, 부상부위
        $hakai = 0 ;    #파괴율
    }

    $wk = int($wk/$BASE) ;

	#맨손으로 때릴 경우에는 숙련레벨에 따른 데미지 증가를 20까지
	if ($w_name eq "맨손") {
		if ($wk == 0) { $wk = 0.9; }
		elsif ($wk == 1) { $wk = 0.95; }
		elsif ($wk == 2) { $wk = 1.0; }
		elsif ($wk == 3) { $wk = 1.05; }
		elsif ($wk == 4) { $wk = 1.1; }
		elsif ($wk == 5) { $wk = 1.15; }
		elsif ($wk == 6) { $wk = 1.18; }
		elsif ($wk == 7) { $wk = 1.21; }
		elsif ($wk == 8) { $wk = 1.24; }
		elsif ($wk == 9) { $wk = 1.27; }
		elsif ($wk == 10) { $wk = 1.3; }
		elsif ($wk == 11) { $wk = 1.33; }
		elsif ($wk == 12) { $wk = 1.36; }
		elsif ($wk == 13) { $wk = 1.39; }
		elsif ($wk == 14) { $wk = 1.42; }
		elsif ($wk == 15) { $wk = 1.45; }
		elsif ($wk == 16) { $wk = 1.48; }
		elsif ($wk == 17) { $wk = 1.51; }
		elsif ($wk == 18) { $wk = 1.54; }
		elsif ($wk == 19) { $wk = 1.57; }
		else { $wk = 1.6; }
	}
	else {
		if ($wk == 0) { $wk = 0.9; }
		elsif ($wk == 1) { $wk = 0.95; }
		elsif ($wk == 2) { $wk = 1.0; }
		elsif ($wk == 3) { $wk = 1.05; }
		elsif ($wk == 4) { $wk = 1.1; }
		elsif ($wk == 5) { $wk = 1.15; }
		elsif ($wk == 6) { $wk = 1.17; }
		elsif ($wk == 7) { $wk = 1.19; }
		elsif ($wk == 8) { $wk = 1.21; }
		elsif ($wk == 9) { $wk = 1.23; }
		elsif ($wk == 10) { $wk = 1.25; }
		elsif ($wk == 11) { $wk = 1.27; }
		elsif ($wk == 12) { $wk = 1.29; }
		elsif ($wk == 13) { $wk = 1.31; }
		elsif ($wk == 14) { $wk = 1.33; }
		elsif ($wk == 15) { $wk = 1.35; }
		elsif ($wk == 16) { $wk = 1.37; }
		elsif ($wk == 17) { $wk = 1.39; }
		elsif ($wk == 18) { $wk = 1.41; }
		elsif ($wk == 19) { $wk = 1.43; }
		else { $wk = 1.45; }
	}

    if ($attman eq "PC") {  #PC
        $wep_2 = $wep; $watt_2 = $watt; $wtai_2 = $wtai ;$w_inf_2 = $w_inf ;
    } else {
        $w_wep_2 = $w_wep; $w_watt_2 = $w_watt; $w_wtai_2 = $w_wtai ;$inf_2 = $inf ;
    }

    # 무기파괴
    if ($dice5 < $hakai) {  #파괴?
        if ($attman eq "PC") {  #PC
            $wep_2 = "맨손<>WP"; $watt_2 = 0 ; $wtai_2 = "∞" ;
            $hakaiinf3 = "무기손상\!" ;
        } else {
            $w_wep_2 = "맨손<>WP"; $w_watt_2 = 0 ; $w_wtai_2 = "∞" ;
            $hakaiinf2 = "무기손상\!" ;
        }
    }

    # 부상처리 & 크리티컬
    if ($dice3 < $kega) {
        if (($dice4 == 0) && ($kegainf =~ /頭/)) {  #머리
            $k_work = "頭";
        } elsif (($dice4 == 1) && ($kegainf =~ /腕/)) { #팔
            $k_work = "腕";
        } elsif (($dice4 == 2) && ($kegainf =~ /腹/)) { #배
            $k_work = "腹";
        } elsif (($dice4 == 3) && ($kegainf =~ /足/)) { #다리
            $k_work = "足";
        } else {
            return ;
        }

        if ($attman eq "PC") {  #PC
            if ((($w_item[5] =~ /<>ADB/)||($w_bou =~ /<>DBB/)) && ($k_work eq "腹")) {    #배?
                $w_itai[5]--; if ($w_itai[5] <= 0) {$w_item[5]="없음"; $w_eff[5]=$w_itai[5]=0;}
                return ;
            } elsif (($w_bou_h =~ /<>DH/) && ($k_work eq "頭")) {   #머리?
                $w_btai_h--; if ($w_btai_h <= 0) {$w_bou_h="없음"; $w_bdef_h=$w_btai_h=0;}
                return ;
            } elsif (($w_bou_f =~ /<>DF/) && ($k_work eq "足")) {   #다리?
                $w_btai_f--; if ($w_btai_f <= 0) {$w_bou_f="없음"; $w_bdef_f=$w_btai_f=0;}
                return ;
            } elsif (($w_bou_a =~ /<>DA/) && ($k_work eq "腕")) {   #팔?
                $w_btai_a--; if ($w_btai_a <= 0) {$w_bou_a="없음"; $w_bdef_a=$w_btai_a=0;}
                return ;
            } else {
            	if ($k_work eq "頭") {
            		if ( $dice6 < 30 ) { $kega3 = "머리 부상"; }
            		else { $k_work = ""; $wk += "0.1"; $kega3 = "크리티컬"; }
            	}
            	elsif ($k_work eq "腕") {
            		if ( $dice6 < 80 ) { $kega3 = "팔 부상"; }
            		else { $k_work = ""; $wk += "0.1"; $kega3 = "크리티컬"; }
            	}
            	elsif ($k_work eq "腹") {
            		if ( $dice6 < 20 ) { $kega3 = "복부 부상"; }
            		else { $k_work = ""; $wk += "0.1"; $kega3 = "크리티컬"; }
            	}
            	elsif ($k_work eq "足") {
            		if ( $dice6 < 50 ) { $kega3 = "다리 부상"; }
            		else { $k_work = ""; $wk += "0.1"; $kega3 = "크리티컬"; }
            	}
                $w_inf_2 =~ s/$k_work//g ;
                $w_inf_2 = ($w_inf_2 . $k_work) ;
            }
        } else {
            if ((($item[5] =~ /<>ADB/)||($bou =~ /<>DBB/)) && ($k_work eq "腹")) {    #배?
                $itai[5]--; if ($itai[5] <= 0) {$item[5]="없음"; $eff[5]=$itai[5]=0;}
                return ;
            } elsif (($bou_h =~ /<>DH/) && ($k_work eq "頭")) { #머리?
                $btai_h--; if ($btai_h <= 0) {$bou_h="없음"; $bdef_h=$btai_h=0;}
                return ;
            } elsif (($bou_f =~ /<>DF/) && ($k_work eq "足")) { #다리?
                $btai_f--; if ($btai_f <= 0) {$bou_f="없음"; $bdef_f=$btai_f=0;}
                return ;
            } elsif (($bou_a =~ /<>DA/) && ($k_work eq "腕")) { #팔?
                $btai_a--; if ($btai_a <= 0) {$bou_a="없음"; $bdef_a=$btai_a=0;}
                return ;
            } else {
            	if ($k_work eq "頭") {
            		if ( $dice6 < 30 ) { $kega2 = "머리 부상"; }
            		else { $k_work = ""; $wk += "0.1"; $kega2 = "크리티컬"; }
            	}
            	elsif ($k_work eq "腕") {
            		if ( $dice6 < 80 ) { $kega2 = "팔 부상"; }
            		else { $k_work = ""; $wk += "0.1"; $kega2 = "크리티컬"; }
            	}
            	elsif ($k_work eq "腹") {
            		if ( $dice6 < 20 ) { $kega2 = "복부 부상"; }
            		else { $k_work = ""; $wk += "0.1"; $kega2 = "크리티컬"; }
            	}
            	elsif ($k_work eq "足") {
            		if ( $dice6 < 50 ) { $kega2 = "다리 부상"; }
            		else { $k_work = ""; $wk += "0.1"; $kega2 = "크리티컬"; }
            	}
                $inf_2 =~ s/$k_work//g ;
                $inf_2 = ($inf_2 . $k_work) ;
            }
        }
    }

}
#==================#
# ■ 자신 사망처리 #
#==================#
sub DEATH {

    $hit = 0;$w_kill++;
    $mem--;

    $com = int(rand(7)) ;

    $log = ($log . "<font color=\"red\"><b>$f_name $l_name\($cl $sex$no번\)은\(는\) 사망했다\.</b></font><br>") ;
    if ($w_msg ne "") {
        $log = ($log . "<font color=\"lime\"><b>$w_f_name $w_l_name『$w_msg』</b></font><br>") ;
    }
    $w_log = ($w_log . "<font color=\"yellow\"><b>$hour:$min:$sec $f_name $l_name\($cl $sex$no번\)와\(과\) 전투를 해서 살해했다\.【남은 인원 $mem명】</b></font><br>") ;

    if (($mem == 1) && ($w_sts ne "NPC0")){$w_inf = ($w_inf . "승") ;}

    open(DB,"$gun_log_file");seek(DB,0,0); @gunlog=<DB>;close(DB);
    $gunlog[1] = "$now,$place[$pls],$id,$w_id,\n";
    open(DB,">$gun_log_file"); seek(DB,0,0); print DB @gunlog; close(DB);

    #사망기록
    &LOGSAVE("DEATH2") ;
    $death = $deth ;
}
#================#
# ■ 적 사망처리 #
#================#
sub DEATH2 {

    $w_hit = 0;$kill++;
    if (($w_cl ne "$BOSS")&&($w_cl ne "$ZAKO")){ $mem--; }

    $w_com = int(rand(7)) ;
    $log = ($log . "<font color=\"red\"><b>$w_f_name $w_l_name\($w_cl $w_sex$w_no번\)을\(를\) 살해했다\.【남은 인원 $mem명】</b></font><br>") ;

    if (length($w_dmes) > 1) {
        $log = ($log . "<font color=\"yellow\"><b>$w_f_name $w_l_name『$w_dmes』</b></font><br>") ;
    }
    if (length($msg) > 1) {
        $log = ($log . "<font color=\"lime\"><b>$f_name $l_name『$msg』</b></font><br>") ;
    }

    if ($mem == 1) {$inf = ($inf . "승") ;}

    open(DB,"$gun_log_file");seek(DB,0,0); @gunlog=<DB>;close(DB);
    $gunlog[1] = "$now,$place[$pls],$id,$w_id,\n";
    open(DB,">$gun_log_file"); seek(DB,0,0); print DB @gunlog; close(DB);

    #사망기록
    &LOGSAVE("DEATH3") ;

    $Command = "BATTLE2" ;
    $w_death = $deth ;
    $w_bid = "";

}
#=================#
# ■ 전투결과처리 #
#=================#
sub BATTLE {

    $cln = "$w_cl \($w_sex$w_no번\)" ;

	#현재 체력과 최대 체력의 퍼센티지로 상태를 나타냄
	$hitper = $w_hit * 100 / $w_mhit;
#100%가 넘을 때
#	if ( $hitper > 100) {
#        &ERROR("부정 억세스입니다") ;
#	}
	if ( $hitper > 60) {
		$stsmsg = "<font color=00FF00>정상</font>";
	}
	elsif ( $hitper > 30) {
		$stsmsg = "<font color=FFFF00>경상</font>";
	}
	elsif ( $hitper > 10) {
		$stsmsg = "<font color=FF9000>중상</font>";
	}
	elsif ( $hitper > 0) {
		$stsmsg = "<font color=FF3000>빈사</font>";
	}
	elsif ( $hitper <= 0 ) {
		$stsmsg = "<font color=FF0000>사망</font>";
	}

print <<"_HERE_";
<P align="center"><B><FONT color="#ff0000" size="+3">$place[$pls] \($area[$pls]\)</FONT></B><BR>
</P>

<table border=0 cellpadding=1 cellspacing=1>
<tr><td valign=middle align=center width=350>

<table border=1 cellpadding=0 cellspacing=0 width=100% height=260>
<tr>
<td valign=top>

<table border=0 cellpadding=0 cellspacing=0 align=center width=300>
    <tr>
        <td align=center colspan=3>
        	<br><font class=red>전투 발생</font><p></td>
        </td>
    </tr>
    <tr>
        <td width=130 height=70><img src=\"$imgurl$icon_file[$icon]\" width=\"70\" height=\"70\" border=\"0\"></td>
		<th width=40 rowspan=7>ＶＳ</th>
        <td width=130 height=70><img src=\"$imgurl$icon_file[$w_icon]\" width=\"70\" height=\"70\" border=\"0\"></td>
    </tr>
    <tr>
    	<td>$f_name $l_name</td>
    	<td>$w_f_name $w_l_name</td>
    </tr>
    <tr>
    	<td>$cl ($sex$no번)</td>
    	<td>$cln</td>
    </tr>
    <tr>
    	<td>체력 : $hit/$mhit</td>
    	<td>상태 : $stsmsg</td>
    </tr>
    <tr>
    	<td>무기 : $wepname</td>
    	<td>무기 : $w_wepname</td>
    </tr>
    <tr>
    	<td>방어 : $bouname</td>
    	<td>방어 : $w_bouname</td>
    </tr>
    <tr>
    	<td>살해수 : $kill명</td>
    	<td>살해수 : $w_kill명</td>
    </tr>
</table><!--전투 메인 테이블 끝//-->

</td>
</tr></table>

</td><td width=200 height=100% rowspan=2>

<table border=1 cellpadding=1 cellspacing=0 width=100% height=100%>
	<tr>
		<th>커맨드</th>
	</tr>
	<tr>
		<td height=100% valign=top style="word-break:break-all">
		<br>
        <FORM METHOD="POST">
        <INPUT TYPE="HIDDEN" NAME="mode" VALUE="command">
        <INPUT TYPE="HIDDEN" NAME="Id" VALUE="$id2">
        <INPUT TYPE="HIDDEN" NAME="Password" VALUE="$password2">
_HERE_

        &COMMAND;

print <<"_HERE_";
		</td>
        </FORM>
	</tr>
</table><!--커맨드 테이블 끝//-->

</td></tr>
<tr><td height=150 width=350 valign=top>

<table border=1 cellpadding=5 cellspacing=0 width=100% height=100%>
    <tr>
        <td colspan=3 height=100% valign=top style="word-break:break-all">$log</td>
	</tr>
</table><!--로그 테이블 끝//-->

</td></tr></table><p>

_HERE_

$mflg="ON"; #스테이터스 비표시
}
#==================#
# ■ 사망처리      #
#==================#
sub RUNAWAY {

    $log = ($log . "$l_name 은\(는\) 전속력으로 도망쳤다\.\.\.<BR>") ;

    $Command = "MAIN";

}

#=====================#
# ■ 방어구 종별 처리 #
#=====================#
sub DEFTREAT {

    local($wkind)   = @_[0] ;   #무기종별
    local($defman)   = @_[1] ;  #방어측 (PC/NPC)

    local($p_up) = 1.5 ;
    local($p_down) = 0.5 ;

    if ($defman eq "PC") {  #PC?
        local($b_name,$b_kind) = split(/<>/, $bou);
        local($b_name_h,$b_kind_h) = split(/<>/, $bou_h);
        local($b_name_f,$b_kind_f) = split(/<>/, $bou_f);
        local($b_name_a,$b_kind_a) = split(/<>/, $bou_a);
        local($b_name_i,$b_kind_i) = split(/<>/, $item[5]);
    } else {
        local($b_name,$b_kind) = split(/<>/, $w_bou);
        local($b_name_h,$b_kind_h) = split(/<>/, $w_bou_h);
        local($b_name_f,$b_kind_f) = split(/<>/, $w_bou_f);
        local($b_name_a,$b_kind_a) = split(/<>/, $w_bou_a);
        local($b_name_i,$b_kind_i) = split(/<>/, $w_item[5]);
    }

    if (($wkind eq "WG") && ($b_kind_i eq "ADB")) { #총→방어구
        $pnt = $p_down ;
    } elsif (($wkind eq "WG") && ($b_kind_h eq "DH")) { #총→머리
        $pnt = $p_up ;
    } elsif (($wkind eq "WN") && ($b_kind eq "DBK")) { #베기→사슬
        $pnt = $p_down ;
    } elsif (($wkind eq "WN") && ($b_kind_i eq "ADB")) { #베기→방어구
        $pnt = $p_up ;
    } elsif ((($wkind eq "WB")||($wkind eq "WGB")||($wkind eq "WAB")) && ($b_kind_h eq "DH")) { #곤봉→머리
        $pnt = $p_down ;
    } elsif ((($wkind eq "WB")||($wkind eq "WGB")||($wkind eq "WAB")) && ($b_kind_b =~ /DBA/)) { #곤봉→갑옷
        $pnt = $p_up ;
    } elsif (($wkind eq "WS") && ($b_kind_b =~ /DBA/)) { #찌르기→갑옷
        $pnt = $p_down ;
    } elsif (($wkind eq "WS") && ($b_kind_b =~ /DBK/)) { #찌르기→사슬
        $pnt = $p_up ;
    } else {
        $pnt = 1.0 ;
    }

}
#======================#
# ■ 레벨 업 처리      #
#======================#
sub LVUPCHK {

    if (($exp <= 0)&&($hit > 0)) { #레벨업
        $log = ($log . "레벨이 올랐다\.<br>") ;
        $mhit += int(rand(3)+7) ; $att += int(rand(3)+2); $def += int(rand(3)+2); $level++;
        $exp = $baseexp+$lvinc*$level;
    }
    if (($w_exp <= 0)&&($w_hit > 0)) { #레벨업
        $w_log = ($w_log . "레벨이 올랐다\.<br>") ;
        $w_mhit += int(rand(3)+7) ; $w_att += int(rand(3)+2); $w_def += int(rand(3)+2); $w_level++;
        $w_exp = $baseexp+$lvinc*$w_level;
    }

}

#======================#
# ■ 적 회복 처리      #
#======================#
sub EN_KAIFUKU{ #적 회복 처리
    $up = int(($now - $w_endtime) / (1*$kaifuku_time));
    if ($w_inf =~ /腹/) { $up = int($up / 2); }
    if ($w_sts eq "수면") {
        $w_sta += $up;
        if ($w_sta > $maxsta) { $w_sta = $maxsta; }
        $w_endtime = $now;
    } elsif ($w_sts eq "치료") {
		if ($kaifuku_rate == 0){$kaifuku_rate = 1;}
        $up = int($up / $kaifuku_rate);
        $w_hit += $up;
        if ($w_hit > $w_mhit) { $w_hit = $w_mhit; }
        $w_endtime = $now;
    }
}

#================================#
# ■ 적 전투 로그 자동 삭제 처리 #
#================================#
sub BLOG_CK{
    $log_len = length($w_log);
    if($log_len > 2000) {
        $w_log = "<font color=\"yellow\"><b>$hour:$min:$sec 전투로그는 자동삭제 되었습니다\.</b></font><br>";
    }
}

1;
