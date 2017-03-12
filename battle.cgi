#!/usr/bin/perl

#require "jcode.pl";
require "br.pl";
require "$lib_file";
require "$lib_file2";

&LOCK ;

require "$pref_file";

&DECODE;
    # 다른 사이트에서의 억세스를 배제
    if ($base_url) {
        $ref_url = $ENV{'HTTP_REFERER'};
        $ref_url =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        if ($ref_url !~ /$base_url/i) {
            &ERROR("부정 억세스입니다.");
        }
    }
    # GET 메소드를 거부
    if ($Met_Post && !$p_flag) {
        &ERROR("부정 억세스입니다.");
    }
&IDCHK;

if ($mode eq "main") { &MAIN; }
elsif ($mode eq "command") { &COM; }
else { &ERROR("부정 억세스입니다.") ; }
&UNLOCK;
exit;

#==================#
# ■ 메인 처리     #
#==================#
sub MAIN {

    #화면 표시 (시작 지점)

    &HEADER;
    &STS();
    &FOOTER;

}
#==================#
# ■ 커맨드 처리   #
#==================#
sub COM {

    if($Command =~ /MV/) {          #이동
        &MOVE;
    }elsif($Command eq "SEARCH") {  #탐색
        &SEARCH;
    }elsif($Command =~ /ITEM_/) {   #아이템사용
        require "$item_lib_file";
        &ITEM;
    }elsif($Command =~ /DEL_/) {    #아이템 버리기
        require "$item_lib_file";
        &ITEMDEL;
    }elsif(($Command =~ /SEIRI_/)&&($Command2 =~ /SEIRI2_/)) { #아이템 정리
        require "$itemsei_lib_file";
        &ITEMSEIRI;
    }elsif(($Command =~ /GOUSEI_/)&&($Command2 =~ /GOUSEI2_/)) { #아이템 합성
        require "$itemgou_lib_file";
        &ITEMGOUSEI;
    }elsif($Command eq "HEAL") {    #치료
        &HEAL;
    }elsif($Command eq "INN") {     #수면
        &INN;
	}elsif($Command =~ /KOU_/) {	#기본방침
		&KOUDOU;
    }elsif($Command =~ /POI_/) {    #독 넣기
        require "$poison_file";
        &POISON;
    }elsif($Command =~ /PSC_/) {    #독 조사
        require "$poison_file";
        &PSCHECK;
    }elsif($Command =~ /GET_/) {    #전리품
        &WINGET;
    }elsif($Command =~ /OUK_/) {    #응급처치
        &OUKYU;
    }elsif(($msg2 ne "")||($dmes2 ne "")||($com2 ne "")) {          #대사 변경
        &WINCHG;
    }elsif($Command eq "WEPDEL") {  #무기 벗기
        require "$item_lib_file";
        &WEPDEL;
    }elsif($Command eq "WEPDEL2") { #무기 버리기
        require "$item_lib_file";
        &WEPDEL2;
    }elsif($Command eq "WEPPNT") {  #숙련도 확인
        &WEPPNT;
    }elsif($Command eq "DEFCHK") {  #장비확인
        &DEFCHK;
    }elsif($Command eq "SPEAKER") { #확성기 사용
        require "$speaker_file";
        &SPEAKER;
    }elsif($Command eq "HACK") {   #해킹
        require "$hack_file";
        &HACKING;
    }elsif($Command =~ /ATK/) {     #공격
        require "$attack_file";
        &ATTACK1;
    }elsif($Command eq "RUNAWAY") { #도망
        require "$attack_file";
        &RUNAWAY;
    }elsif($Command eq "BSAVE") {   #백업 저장
        require "$admin_file";
        &BACKSAVE;
    }elsif($Command eq "BREAD") {   #백업 읽기
        require "$admin_file";
        &BACKREAD;
    }elsif($Command eq "RESET") {   #데이터 초기화
        require "$admin_file";
        &DATARESET;
    }

    if(($Command =~ /BATTLE/)||($Command =~ /ATK/)) {   #전투결과
        &HEADER;
        require "$attack_file";
        &BATTLE;
        &FOOTER;
    } elsif ($mflg ne "ON") {
        &MAIN;
    }
}
#==================#
# ■ 커맨드 처리   #
#==================#
sub MOVE {

    local($mv) = $Command;
    $mv =~ s/MV//g ;

    ($ar[0],$ar[1],$ar[2],$ar[3],$ar[4],$ar[5],$ar[6],$ar[7],$ar[8],$ar[9],$ar[10],$ar[11],$ar[12],$ar[13],$ar[14],$ar[15],$ar[16],$ar[17],$ar[18],$ar[19],$ar[20],$ar[21],$ar[22]) = split(/,/, $arealist[2]);
    ($war,$a) = split(/,/, $arealist[1]);
    if(($ar[$war] eq $place[$mv])||($ar[$war+1] eq $place[$mv])||($ar[$war+2] eq $place[$mv])) {
        $log = ($log . "$place[$mv](으)로 이동했다. 다음에 이곳은 금지지역이 되겠구나.<br>$arinfo[$mv]<br>") ;
    } else {
        $log = ($log . "$place[$mv](으)로 이동했다.<BR>$arinfo[$mv]<br>") ;
        for ($i=0; $i<$war; $i++) {
            if (($ar[$i] eq $place[$mv]) && ($hackflg == 0)) {   #금지 구역?
                $log = ("$place[$mv]은(는) 금지지역다. 이동할 수 없어...<BR>") ;
                $Command = "MAIN";
                return ;
                $chkflg = 1 ;
            }
        }
    }


    $pls = $mv ;
    $Command = "MAIN";
	$actioncheck = "move";

    if ($inf =~ /足/) {
        $sta -= int(rand(5) + 13) ;
    } elsif ($club eq "육상부") {
        $sta -= int(rand(5))+5 ;
    } else {
        $sta -= int(rand(5))+8 ;
    }

    if ($sta <= 0) {    #스테미너 부족
        &DRAIN("mov");
    }

    &SEARCH2;

    &SAVE;

}
#==================#
# ■ 탐색 처리     #
#==================#
sub SEARCH {

    $log = ($log . "$l_name은(는), 주위를 탐색했다...<br>") ;

    if ($inf =~ /足/) {
        $sta -= int(rand(5) + 23) ;
    } elsif ($club eq "육상부") {
        $sta -= int(rand(5))+13;
    } else {
        $sta -= int(rand(5))+18 ;
    }

    if ($sta <= 0) {    #스테미너 부족
        &DRAIN("mov");
    }

    &SEARCH2;

    if ($chksts ne "OK") {
        $log = ($log . "그러나, 아무것도 찾지 못했다.<BR>") ;
        $Command = "MAIN" ;
    }


    &SAVE;
}

#==================#
# ■ 탐색처리2     #
#==================#
sub SEARCH2 {

    local($i) = 0 ;
    srand(time ^ $i) ;

    srand($now);
    local($a) = int(rand(1)) ;  #적, 아이템 어느쪽을 발견
    local($dice1) = int(rand(100)) ; #적, 아이템 어느쪽을 발견

    &TACTGET ;

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    $chksts="NG";$chksts2="NG";

	$persearch = 60;
	if ($tactics eq "연속공격") { #연속공격시 레벨/2+킬수/2만큼 적 발견율 상승
		$persearch += int(($level+$kill)/2);
		if ( $persearch > 90 ) {
			$persearch = 90;
		}
	}

    if ($dice1 <= $persearch) {  #적 발견?
        for ($i=0; $i<$#userlist+1; $i++) {
            ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);
			#연속공격 관련
			$w_bid2 = $w_bid;
			if ($tactics eq "연속공격") {$w_bid2 = "";}
			push(@plist,$i) if (($w_pls eq $pls) && ($w_id ne $id) && ($w_bid2 ne $id));
		}

	    for ($i=0;$i<@plist+5;$i++){
		    push(@plist,splice(@plist,int(rand @plist+0),1));
	    }

	    foreach $i(@plist){
            local($dice2) = int(rand(10)) ; #적, 아이템 발견
            local($dice3) = int(rand(10)) ; #선제공격

            ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);

            &TACTGET2 ;

			#무기와 방어구 이름 저장
		    ($wepname,$z1) = split(/<>/, $wep);
		    ($w_wepname,$z2) = split(/<>/, $w_wep);
		    ($bouname,$x1) = split(/<>/, $bou);
		    ($w_bouname,$x2) = split(/<>/, $w_bou);

			#연속공격 관련 (한번 공격한 캐릭터를 다시 공격 가능)
			$w_bid2 = $w_bid;
			if ($tactics eq "연속공격") {
				if ($sen*2 < rand(10)) {$w_bid2 = "";}
			}
			if (($w_pls eq $pls) && ($w_id ne $id) && ($w_bid2 ne $id)) {	#장소일치, 다른 플레이어, 연속공격인지 체크.
#            if (($w_pls eq $pls) && ($w_id ne $id) && ($w_bid ne $id)) {    #장소일치, 다른 플레이어, 연속공격인지 체크.
                local($chk) = int($dice2 * $sen);

                if ($chk < $chkpnt) {
                    if ($w_hit > 0) {
                        if ($dice3 <= $chkpnt2) {   #선제공격
                            require "$attack_file";
                            &ATTACK ;$chksts="OK";$chksts2="NG";last;
                        } else {    #기습
                            $Index2 = $i;
                            $w_bid = $id ;
                            $bid = $w_id ;
                            require "$attack_file";
                            &ATTACK2 ;$chksts="OK";$chksts2="NG";last;
                        }
                    } else {
                        local($chkflg) = 0 ;
                        local($dice4) = int(rand(10));
                        if ($dice4 > 8){
                            for ($j=0; $j<6; $j++) {
                                if ($w_item[$j] ne "없음" && $w_item[$j] ne "") {
                                    $chkflg=1;
                                    last;
                                }
                            }
#)))))))))))))))))))))))))))))
unless ($chkflg){if ($w_wep !~ /맨손/ || $w_bou !~ /속옷/ || $w_bou_h ne "없음" || $w_bou_f ne "없음" ||$w_bou_a ne "없음")
{$chkflg=1}}
#)))))))))))))))))))))))))))))
                        if ($chkflg == 1) { #시체 발견?
#>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$userlist[$i] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,-1,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$id,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf,\n" ;
open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);
#<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                            &DEATHGET ;last;
                        }
                    }}
                }else{ $chksts2="OK";}
            }
        }
        if ($chksts2 eq "OK") {
            $log = ($log . "누군가 숨어있는 듯한 느낌이 있다. 기분탓인가?<BR>") ;
        }
    } else {
        $dice2 = int(rand(10)) ;    #적, 아이템 발견
        if (($dice2 < $chkpnt)&&($Command eq "SEARCH")) { #아이템 발견 - 탐색시
            require "$item_lib_file";
            &ITEMGET;
        }
        #아이템 발견 - 이동시
		elsif (($dice2+4 < $chkpnt)&&($actioncheck eq "move")&&($tactics ne "연속공격")) {
            require "$item_lib_file";
            &ITEMGET;
        } else {
            require "$event_file";
            &EVENT ;
        }
    }


}


#==================#
# ■ 치료 처리     #
#==================#
sub HEAL {

    $sts = "치료";
    $endtime = $now ;
    $Command = "HEAL2" ;

    &SAVE
}

#==================#
# ■ 수면 처리     #
#==================#
sub INN {

    $sts = "수면";
    $endtime = $now ;
    $Command = "INN2" ;
    &SAVE

}
#==================#
# ■ 전리품 취득   #
#==================#
sub WINGET {

    if ($item[$itno2] ne "없음" or $itno2>4 or $itno2<0) {
        $log = ($log . "더 이상 소지품을 가질 수 없다.<br>") ;
        $Command = "MAIN";
        return;
    }
    if ($getid eq $id){
        $log = ($log . "스스로 자기 물건을 뺏어봤다.<br>허무하다...<br>") ;
        $Command = "MAIN";
        return;
    }

    local($wk) = $Command;
    $wk =~ s/GET_//g;
    $wk+=0;
    $wk=int($wk);
    local($witem,$weff,$witai);

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    for ($i=0; $i<$#userlist+1; $i++) {
        ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);
        if ($w_id eq $getid) {

            if ($w_hit>0 || ($id eq $w_bid && $w_sta>-1)){
                $log = ($log . "$w_f_name의 저 물건이 갖고 싶다고 간절히 바래 봤다.<br>허무하다...<br>") ;
                $Command = "MAIN";
                return;
            }

            if ($wk==6) {
                ($witem,$weff,$witai) = ($w_wep,$w_watt,$w_wtai);
                $w_wep = "맨손<>WP"; $w_watt = 0; $w_wtai = "∞";
            }elsif ($wk==7) {
                ($witem,$weff,$witai) = ($w_bou,$w_bdef,$w_btai);
                $w_bou = "속옷<>DN"; $w_bdef = 0; $w_btai = "∞";
            }elsif ($wk==8) {
                ($witem,$weff,$witai) = ($w_bou_h,$w_bdef_h,$w_btai_h);
                $w_bou_h = "없음"; $w_bdef_h = $w_btai_h = 0;
            }elsif ($wk==9) {
                ($witem,$weff,$witai) = ($w_bou_f,$w_bdef_f,$w_btai_f);
                $w_bou_f = "없음"; $w_bdef_f = $w_btai_f = 0;
            }elsif ($wk==10) {
                ($witem,$weff,$witai) = ($w_bou_a,$w_bdef_a,$w_btai_a);
                $w_bou_a = "없음"; $w_bdef_a = $w_btai_a = 0;
            } else {
                ($witem,$weff,$witai) = ($w_item[$wk],$w_eff[$wk],$w_itai[$wk]);
                $w_item[$wk] = "없음"; $w_eff[$wk]=$w_itai[$wk] = 0;
            }
            $userlist[$i] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$id,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf,\n" ;
            open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);
            last;
        }
    }

    if ($witem!~/^(없음|맨손|속옷)$/ && $i!=$#userlist+1){
        $item[$itno2] = $witem ;
        $eff[$itno2] = $weff; $itai[$itno2] = $witai ;
        ($witem)=split(/<>/,$witem,2);
        $log = ($log . "$l_name은(는) $witem을(를) 입수했다.<BR>") ;
        &SAVE;
    }else{
        $log = ($log . "빼앗는 것을 포기했다.<BR>") ;
    }


    $Command = "MAIN";
}

#=====================#
# ■ 말버릇 변경 처리 #
#=====================#
sub WINCHG {

	if (length($msg2) > 64) { $log = ($log . "살해시 대사의 글자수가 제한을 넘었습니다. \(한글 32글자까지\)<br>살해시 대사는 변경되지 않았습니다.<br>"); }
	else { $msg = $msg2; $checkwinchg = 1; }
	if (length($dmes2) > 64) { $log = ($log . "유언의 글자수가 제한을 넘었습니다. \(한글 32글자까지\)<br>유언은 변경되지 않았습니다.<br>"); }
	else { $dmes = $dmes2; $checkwinchg = 1; }
	if (length($com2) > 64) { $log = ($log . "코멘트의 글자수가 제한을 넘었습니다. \(한글 32글자까지\)<br>코멘트는 변경되지 않았습니다.<br>"); }
	else { $com = $com2; $checkwinchg = 1; }
	if ($checkwinchg) {
		$log = ($log . "대사를 변경했습니다.<br>") ;
		&SAVE ;
	}

    $Command = "MAIN" ;

}

#==================#
# ■ 기본방침 변경 #
#==================#
sub KOUDOU {

	local($wk) = $Command;
	$wk =~ s/KOU_//g;

	if ($wk == 0) {	#보통
		$tactics = "보통";
	}elsif ($wk == 1) {	#공격중시
		$tactics = "공격중시";
	}elsif ($wk == 2) {	#방어중시
		$tactics = "방어중시";
	}elsif ($wk == 3) {	#은밀행동
		$tactics = "은밀행동";
	}elsif ($wk == 4) {	#탐색행동
		$tactics = "탐색행동";
	}elsif ($wk == 5) {	#연속공격
		$tactics = "연속공격";
	}

	$log = ($log . "기본방침을 $tactics로 변경했다.<BR>\n") ;
	
	&SAVE ;
	
	$Command = "MAIN" ;
}

#===================#
# ■ 시체 발견 처리 #
#===================#
sub DEATHGET {

	$log = ($log . "$w_f_name $w_l_name의 시체를 발견했다.<br>\n") ;

	if ($w_death =~ /참살/) {
		if ($w_com == 0) {$log = ($log . "머리부분이 목에 있는 피부 하나로 이어져 있는 상태다... 목을 잘린듯하다.<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "복부가 예리한 날과 같은 것으로 가른듯, 내장이 튀어나와있다...<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "어깨죽지부터 가슴에 걸쳐 비스듬히 베였다. 완전히 갈라져 있다...<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "목, 몸, 양팔, 양다리가 모두 잘려져 있다. 이런 일이 제정신인 인간이 할 수 있는 것일까...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "머리가 집중적으로 잘게 썰어져 있다. 살아있을 때의 모습따윈 전혀 남아있지 않다...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "복부가 갈라져 있지만, 잘 보면 손목에도 칼자국이 많이 있다...<BR>상대에게 베인 후에 자살을 하려고 했던 것일까?<br>\n") ;}
		else {$log = ($log . "머리부터 가슴에 걸쳐 무참히 잘려 있다...<br>\n") ;}
	}elsif ($w_death =~ /사살/) {
		if ($w_com == 0) {$log = ($log . "이마에 한발의 화살이 박혀있다...<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "등에 몇발이나 되는 화살이 박혀있다. 도망치려고 했을 때, 등뒤에서 맞은듯하다.<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "심장에 한발 정확하게 화살이 꽂혀 있다. 상당한 실력의 소유자겠지...<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "다리와 머리에 화살이 박혀 있다. 다리를 쏘아, 도망칠 수 없게 만든 후에 급소를 쏜것 같다...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "벽에 화살로 박혀 고정되어있다... 골고다 언덕에서 처형된 성자 같은 자세다...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "십수발의 화살이 박혀, 고슴도치처럼 되어 있다...<br>\n") ;}
		else {$log = ($log . "목에 몇개의 화살이 박혀 있다... 한발은 턱 아래에 꽂혀 있다...<br>\n") ;}
	}elsif ($w_death =~ /총살/) {
		if ($w_com == 0) {$log = ($log . "가슴에 3발, 이마에 1발의 탄흔이 있다... 이마의 한발이 치명상이 된 듯하다...<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "복부에 몇발의 탄흔이 있고, 피가 흘러 나오고 있다. 그러나, 그 피도 이미 말라 있다.<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "머리가 원형이 남아있지 않을 정도로 날아가 있다... 명찰을 보고 간신히 이름을 알았을 정도다.<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "가슴에 몇발. 그리고, 뇌수가 흩뿌려져 있다. 죽인 후, 입에 총을 꽂아넣고 쏜 것이겠지. 쓸데없는 짓을 했다...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "복부에 구멍이 뻥 뚤려있어, 반대쪽이 보인다. 이래선 절대 살아 있을 수 없겠구나...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "얼굴에 몇발이나 탄흔이 있다... 원한이라도 있었던 것일까.<br>\n") ;}
		else {$log = ($log . "오른쪽 머리부분이 심하게 손상되어, 뇌가 흘러나와있다...<br>\n") ;}
	}elsif ($w_death =~ /교살/) {
		if ($w_com == 0) {$log = ($log . "뭔가로 목을 졸린것일까... 입에서는 많은 구토물을 흘리고 있다.<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "교살당한 시체인가... 원한서린 시선으로 이쪽을 보고 있다.<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "뭔가로 목을 졸렸기 때문일까. 혀를 내밀고, 눈이 돌아간 무참한 모습니다.<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "누군가에게 목을 졸려 죽은 것 같다. 오줌을 지린 흔적이 있다...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "목을 졸리면 심하게 반항한 것일까. 손톱에 살 같은 것이 박혀 있다...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "목을 매단 시체다... 죽인 후, 매단 것으로 밖에 볼 수 없다...<br>\n") ;}
		else {$log = ($log . "목덜미에, 뭔가로 졸린듯한 자주색 흔적이 있다...<br>\n") ;}
	}elsif ($w_death =~ /폭살/) {
		if ($w_com == 0) {$log = ($log . "근처에 몸의 각 부분이 분산되어 있다. 화려하게 당한듯 보인다...<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "양발이 날아가 있다. 팔만으로 기어 도망가려고 한 것인가...<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "폭탄에라도 공격당한 것일까, 머리와 오른쪽 팔만 남아있다...<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "폭탄에 날아간 것일까, 머리가 반정도 사라져 안이 들여다 보인다...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "폭풍으로 날아간 한쪽 팔이 5m정도 앞에 뒹굴고 있다...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "시체라기보다, 살덩어리구나...<br>\n") ;}
		else {$log = ($log . "목과 손이 보이지않네... 폭풍으로 날아간 것일까...<br>\n") ;}
	}elsif ($w_death =~ /박살/) {
		if ($w_com == 0) {$log = ($log . "배를 움켜진 자세로, 웅크리고 있다... 아무래도, 그대로 숨이 끊긴듯하다...<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "상대에게 엄청나게 맞은듯 보인다... 머리가 자주색으로 부풀어 올라있다...<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "목뼈가 부러져, 목에서 뼈가 튀어나와 있다...<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "땅에 얼굴을 대고, 많은 피를 얼굴쪽에서 흘리고 있다... 당한 직후, 후두부를 맞은 듯하다.<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "뒤에서 둔기와 같은 것으로 맞은 것일까? 머리를 감싼채 죽어 있다...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "이마가 쪼개져, 피와 뇌수가 흐르고 있다. 정면에서 세게 맞은듯하구나...<br>\n") ;}
		else {$log = ($log . "목이 정확히 옆을 향해 있다. 아무리 봐도, 목뼈가 부러져 있다...<br>\n") ;}
	}elsif ($w_death =~ /척살/) {
		if ($w_com == 0) {$log = ($log . "온몸에, 뭔가 예리한 날로 찔린 상처가, 많이 있다... 시체의 주변은, 피바다다...<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "상대가 올라타서, 계속해서 찌른듯한 상처가 있다...<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "심장을 한번 찔려, 아직 상처에서 피가 솟아 나오고 있다... 죽은 것은 바로전인 듯하다.<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "목을 찔려 있다... 눈은 흰자위를 드러내고 있다...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "뒤에서 복부를 찔려 죽어 있다. 습격을 당한 것일까...?<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "왼쪽 복부가 심하게 손상되어 있다. 찔린 후, 도려낸 듯한 상터가 있다...<br>\n") ;}
		else {$log = ($log . "양쪽 눈이, 뭔가에 찔려 있다... 마치 피눈물을 흘리고 있는 것 같다...<br>\n") ;}
    }elsif ($w_death =~ /독/) {
        if ($w_com == 0) {$log = ($log . "독을 먹은 것일까...? 구토한 흔적이 있다...<br>\n") ;}
        elsif ($w_com == 1) {$log = ($log . "입에서 한가닥 피가 흘러 있다. 얼핏보면, 자고 있는 걸로 보이는구나...<br>\n") ;}
        elsif ($w_com == 2) {$log = ($log . "시체에 얼굴을 가까이 대자 특유의 아몬드 냄새가 난다. 독살된 것인가...<br>\n") ;}
        elsif ($w_com == 3) {$log = ($log . "독살된 것인가. 입에서 피가 많이 섞인 거품을 물고 있다...<br>\n") ;}
        elsif ($w_com == 4) {$log = ($log . "독을 먹고 괴로워 했던 것일까. 스스로 목을 심하게 손톱으로 할퀸것 같다...<br>\n") ;}
        elsif ($w_com == 5) {$log = ($log . "누군가에게 독이라도 당한건가? 피부가 심하게 변색되어 있다.<br>\n") ;}
        else {$log = ($log . "피부가 새까맣게 변해 있고, 입에서는 많은 피를 토한 듯이 보인다...<br>\n") ;}
	} else {
		$log = ($log . "무참하게 목이 돌아가 있다...<br>\n") ;
	}
	$log = ($log . "배낭 속을 뒤져볼까...<br>\n") ;
	$Command = "DEATHGET";

    $chksts="OK";

}
#=====================#
# ■ 숙련도 확인 처리 #
#=====================#
sub WEPPNT {

    $log = ("현재의 숙련 레벨은...<br>") ;

    local($p_wa) = int($wa/$BASE);
    local($p_wb) = int($wb/$BASE);
    local($p_wc) = int($wc/$BASE);
    local($p_wd) = int($wd/$BASE);
    local($p_wg) = int($wg/$BASE);
    local($p_ws) = int($ws/$BASE);
    local($p_wn) = int($wn/$BASE);
    local($p_wp) = int($wp/$BASE);

    $log = ($log . "<BR>소속 클럽：$club<br><br>") ;
    $log = ($log . "　활：$p_wa($wa)　곤봉：$p_wb($wb)　던지기：$p_wc($wc)　폭탄：$p_wd($wd)<br>") ;
    $log = ($log . "　총：$p_wg($wg)　찌르기：$p_ws($ws)　칼：$p_wn($wn)　때리기：$p_wp($wp)<br>") ;

}
#===================#
# ■ 장비 확인 처리 #
#===================#
sub DEFCHK {

    local($w_name,$w_kind) = split(/<>/, $wep);
    local($b_name,$b_kind) = split(/<>/, $bou);
    local($b_name_h,$b_kind_h) = split(/<>/, $bou_h);
    local($b_name_f,$b_kind_f) = split(/<>/, $bou_f);
    local($b_name_a,$b_kind_a) = split(/<>/, $bou_a);
    local($b_name_i,$b_kind_i) = split(/<>/, $item[5]);

    $log = ("현재 장비하고 있는 물건은...<br><br>") ;

    $log = ($log . "　무기　：　$w_name/$watt/$wtai<br>") ;
    $log = ($log . "　몸　：　$b_name/$bdef/$btai<br>") ;
    $log = ($log . "　머리　：　$b_name_h/$bdef_h/$btai_h<br>") ;
    $log = ($log . "　팔　：　$b_name_a/$bdef_a/$btai_a<br>") ;
    $log = ($log . "　다리　：　$b_name_f/$bdef_f/$btai_f<br>") ;
    $log = ($log . "　장식　：　$b_name_i/$eff[5]/$itai[5]<br>") ;

}
#==================#
# ■ 응급처치 처리 #
#==================#
sub OUKYU {

    local($wk) = $Command;
    $wk =~ s/OUK_//g;

    if ($wk == 0) { #머리
        $inf =~ s/頭//g ;
    }elsif ($wk == 1) { #팔
        $inf =~ s/腕//g ;
    }elsif ($wk == 2) { #복부
        $inf =~ s/腹//g ;
    }elsif ($wk == 3) { #다리
        $inf =~ s/足//g ;
    }

    $log = ($log . "응급처치를 했다.<BR>") ;

    $sta -= $okyu_sta ;

    if ($sta <= 0) {    #스테미너 부족?
        &DRAIN("com");
    }

    &SAVE ;

    $Command = "MAIN" ;
}
1
