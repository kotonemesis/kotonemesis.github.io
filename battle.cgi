#!/usr/bin/perl

#require "jcode.pl";
require "br.pl";
require "$lib_file";
require "$lib_file2";

&LOCK ;

require "$pref_file";

&DECODE;
    # �ٸ� ����Ʈ������ �＼���� ����
    if ($base_url) {
        $ref_url = $ENV{'HTTP_REFERER'};
        $ref_url =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        if ($ref_url !~ /$base_url/i) {
            &ERROR("���� �＼���Դϴ�.");
        }
    }
    # GET �޼ҵ带 �ź�
    if ($Met_Post && !$p_flag) {
        &ERROR("���� �＼���Դϴ�.");
    }
&IDCHK;

if ($mode eq "main") { &MAIN; }
elsif ($mode eq "command") { &COM; }
else { &ERROR("���� �＼���Դϴ�.") ; }
&UNLOCK;
exit;

#==================#
# �� ���� ó��     #
#==================#
sub MAIN {

    #ȭ�� ǥ�� (���� ����)

    &HEADER;
    &STS();
    &FOOTER;

}
#==================#
# �� Ŀ�ǵ� ó��   #
#==================#
sub COM {

    if($Command =~ /MV/) {          #�̵�
        &MOVE;
    }elsif($Command eq "SEARCH") {  #Ž��
        &SEARCH;
    }elsif($Command =~ /ITEM_/) {   #�����ۻ��
        require "$item_lib_file";
        &ITEM;
    }elsif($Command =~ /DEL_/) {    #������ ������
        require "$item_lib_file";
        &ITEMDEL;
    }elsif(($Command =~ /SEIRI_/)&&($Command2 =~ /SEIRI2_/)) { #������ ����
        require "$itemsei_lib_file";
        &ITEMSEIRI;
    }elsif(($Command =~ /GOUSEI_/)&&($Command2 =~ /GOUSEI2_/)) { #������ �ռ�
        require "$itemgou_lib_file";
        &ITEMGOUSEI;
    }elsif($Command eq "HEAL") {    #ġ��
        &HEAL;
    }elsif($Command eq "INN") {     #����
        &INN;
	}elsif($Command =~ /KOU_/) {	#�⺻��ħ
		&KOUDOU;
    }elsif($Command =~ /POI_/) {    #�� �ֱ�
        require "$poison_file";
        &POISON;
    }elsif($Command =~ /PSC_/) {    #�� ����
        require "$poison_file";
        &PSCHECK;
    }elsif($Command =~ /GET_/) {    #����ǰ
        &WINGET;
    }elsif($Command =~ /OUK_/) {    #����óġ
        &OUKYU;
    }elsif(($msg2 ne "")||($dmes2 ne "")||($com2 ne "")) {          #��� ����
        &WINCHG;
    }elsif($Command eq "WEPDEL") {  #���� ����
        require "$item_lib_file";
        &WEPDEL;
    }elsif($Command eq "WEPDEL2") { #���� ������
        require "$item_lib_file";
        &WEPDEL2;
    }elsif($Command eq "WEPPNT") {  #���õ� Ȯ��
        &WEPPNT;
    }elsif($Command eq "DEFCHK") {  #���Ȯ��
        &DEFCHK;
    }elsif($Command eq "SPEAKER") { #Ȯ���� ���
        require "$speaker_file";
        &SPEAKER;
    }elsif($Command eq "HACK") {   #��ŷ
        require "$hack_file";
        &HACKING;
    }elsif($Command =~ /ATK/) {     #����
        require "$attack_file";
        &ATTACK1;
    }elsif($Command eq "RUNAWAY") { #����
        require "$attack_file";
        &RUNAWAY;
    }elsif($Command eq "BSAVE") {   #��� ����
        require "$admin_file";
        &BACKSAVE;
    }elsif($Command eq "BREAD") {   #��� �б�
        require "$admin_file";
        &BACKREAD;
    }elsif($Command eq "RESET") {   #������ �ʱ�ȭ
        require "$admin_file";
        &DATARESET;
    }

    if(($Command =~ /BATTLE/)||($Command =~ /ATK/)) {   #�������
        &HEADER;
        require "$attack_file";
        &BATTLE;
        &FOOTER;
    } elsif ($mflg ne "ON") {
        &MAIN;
    }
}
#==================#
# �� Ŀ�ǵ� ó��   #
#==================#
sub MOVE {

    local($mv) = $Command;
    $mv =~ s/MV//g ;

    ($ar[0],$ar[1],$ar[2],$ar[3],$ar[4],$ar[5],$ar[6],$ar[7],$ar[8],$ar[9],$ar[10],$ar[11],$ar[12],$ar[13],$ar[14],$ar[15],$ar[16],$ar[17],$ar[18],$ar[19],$ar[20],$ar[21],$ar[22]) = split(/,/, $arealist[2]);
    ($war,$a) = split(/,/, $arealist[1]);
    if(($ar[$war] eq $place[$mv])||($ar[$war+1] eq $place[$mv])||($ar[$war+2] eq $place[$mv])) {
        $log = ($log . "$place[$mv](��)�� �̵��ߴ�. ������ �̰��� ���������� �ǰڱ���.<br>$arinfo[$mv]<br>") ;
    } else {
        $log = ($log . "$place[$mv](��)�� �̵��ߴ�.<BR>$arinfo[$mv]<br>") ;
        for ($i=0; $i<$war; $i++) {
            if (($ar[$i] eq $place[$mv]) && ($hackflg == 0)) {   #���� ����?
                $log = ("$place[$mv]��(��) ����������. �̵��� �� ����...<BR>") ;
                $Command = "MAIN";
                return ;
                $chkflg = 1 ;
            }
        }
    }


    $pls = $mv ;
    $Command = "MAIN";
	$actioncheck = "move";

    if ($inf =~ /��/) {
        $sta -= int(rand(5) + 13) ;
    } elsif ($club eq "�����") {
        $sta -= int(rand(5))+5 ;
    } else {
        $sta -= int(rand(5))+8 ;
    }

    if ($sta <= 0) {    #���׹̳� ����
        &DRAIN("mov");
    }

    &SEARCH2;

    &SAVE;

}
#==================#
# �� Ž�� ó��     #
#==================#
sub SEARCH {

    $log = ($log . "$l_name��(��), ������ Ž���ߴ�...<br>") ;

    if ($inf =~ /��/) {
        $sta -= int(rand(5) + 23) ;
    } elsif ($club eq "�����") {
        $sta -= int(rand(5))+13;
    } else {
        $sta -= int(rand(5))+18 ;
    }

    if ($sta <= 0) {    #���׹̳� ����
        &DRAIN("mov");
    }

    &SEARCH2;

    if ($chksts ne "OK") {
        $log = ($log . "�׷���, �ƹ��͵� ã�� ���ߴ�.<BR>") ;
        $Command = "MAIN" ;
    }


    &SAVE;
}

#==================#
# �� Ž��ó��2     #
#==================#
sub SEARCH2 {

    local($i) = 0 ;
    srand(time ^ $i) ;

    srand($now);
    local($a) = int(rand(1)) ;  #��, ������ ������� �߰�
    local($dice1) = int(rand(100)) ; #��, ������ ������� �߰�

    &TACTGET ;

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    $chksts="NG";$chksts2="NG";

	$persearch = 60;
	if ($tactics eq "���Ӱ���") { #���Ӱ��ݽ� ����/2+ų��/2��ŭ �� �߰��� ���
		$persearch += int(($level+$kill)/2);
		if ( $persearch > 90 ) {
			$persearch = 90;
		}
	}

    if ($dice1 <= $persearch) {  #�� �߰�?
        for ($i=0; $i<$#userlist+1; $i++) {
            ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);
			#���Ӱ��� ����
			$w_bid2 = $w_bid;
			if ($tactics eq "���Ӱ���") {$w_bid2 = "";}
			push(@plist,$i) if (($w_pls eq $pls) && ($w_id ne $id) && ($w_bid2 ne $id));
		}

	    for ($i=0;$i<@plist+5;$i++){
		    push(@plist,splice(@plist,int(rand @plist+0),1));
	    }

	    foreach $i(@plist){
            local($dice2) = int(rand(10)) ; #��, ������ �߰�
            local($dice3) = int(rand(10)) ; #��������

            ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);

            &TACTGET2 ;

			#����� �� �̸� ����
		    ($wepname,$z1) = split(/<>/, $wep);
		    ($w_wepname,$z2) = split(/<>/, $w_wep);
		    ($bouname,$x1) = split(/<>/, $bou);
		    ($w_bouname,$x2) = split(/<>/, $w_bou);

			#���Ӱ��� ���� (�ѹ� ������ ĳ���͸� �ٽ� ���� ����)
			$w_bid2 = $w_bid;
			if ($tactics eq "���Ӱ���") {
				if ($sen*2 < rand(10)) {$w_bid2 = "";}
			}
			if (($w_pls eq $pls) && ($w_id ne $id) && ($w_bid2 ne $id)) {	#�����ġ, �ٸ� �÷��̾�, ���Ӱ������� üũ.
#            if (($w_pls eq $pls) && ($w_id ne $id) && ($w_bid ne $id)) {    #�����ġ, �ٸ� �÷��̾�, ���Ӱ������� üũ.
                local($chk) = int($dice2 * $sen);

                if ($chk < $chkpnt) {
                    if ($w_hit > 0) {
                        if ($dice3 <= $chkpnt2) {   #��������
                            require "$attack_file";
                            &ATTACK ;$chksts="OK";$chksts2="NG";last;
                        } else {    #���
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
                                if ($w_item[$j] ne "����" && $w_item[$j] ne "") {
                                    $chkflg=1;
                                    last;
                                }
                            }
#)))))))))))))))))))))))))))))
unless ($chkflg){if ($w_wep !~ /�Ǽ�/ || $w_bou !~ /�ӿ�/ || $w_bou_h ne "����" || $w_bou_f ne "����" ||$w_bou_a ne "����")
{$chkflg=1}}
#)))))))))))))))))))))))))))))
                        if ($chkflg == 1) { #��ü �߰�?
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
            $log = ($log . "������ �����ִ� ���� ������ �ִ�. ���ſ�ΰ�?<BR>") ;
        }
    } else {
        $dice2 = int(rand(10)) ;    #��, ������ �߰�
        if (($dice2 < $chkpnt)&&($Command eq "SEARCH")) { #������ �߰� - Ž����
            require "$item_lib_file";
            &ITEMGET;
        }
        #������ �߰� - �̵���
		elsif (($dice2+4 < $chkpnt)&&($actioncheck eq "move")&&($tactics ne "���Ӱ���")) {
            require "$item_lib_file";
            &ITEMGET;
        } else {
            require "$event_file";
            &EVENT ;
        }
    }


}


#==================#
# �� ġ�� ó��     #
#==================#
sub HEAL {

    $sts = "ġ��";
    $endtime = $now ;
    $Command = "HEAL2" ;

    &SAVE
}

#==================#
# �� ���� ó��     #
#==================#
sub INN {

    $sts = "����";
    $endtime = $now ;
    $Command = "INN2" ;
    &SAVE

}
#==================#
# �� ����ǰ ���   #
#==================#
sub WINGET {

    if ($item[$itno2] ne "����" or $itno2>4 or $itno2<0) {
        $log = ($log . "�� �̻� ����ǰ�� ���� �� ����.<br>") ;
        $Command = "MAIN";
        return;
    }
    if ($getid eq $id){
        $log = ($log . "������ �ڱ� ������ ����ô�.<br>�㹫�ϴ�...<br>") ;
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
                $log = ($log . "$w_f_name�� �� ������ ���� �ʹٰ� ������ �ٷ� �ô�.<br>�㹫�ϴ�...<br>") ;
                $Command = "MAIN";
                return;
            }

            if ($wk==6) {
                ($witem,$weff,$witai) = ($w_wep,$w_watt,$w_wtai);
                $w_wep = "�Ǽ�<>WP"; $w_watt = 0; $w_wtai = "��";
            }elsif ($wk==7) {
                ($witem,$weff,$witai) = ($w_bou,$w_bdef,$w_btai);
                $w_bou = "�ӿ�<>DN"; $w_bdef = 0; $w_btai = "��";
            }elsif ($wk==8) {
                ($witem,$weff,$witai) = ($w_bou_h,$w_bdef_h,$w_btai_h);
                $w_bou_h = "����"; $w_bdef_h = $w_btai_h = 0;
            }elsif ($wk==9) {
                ($witem,$weff,$witai) = ($w_bou_f,$w_bdef_f,$w_btai_f);
                $w_bou_f = "����"; $w_bdef_f = $w_btai_f = 0;
            }elsif ($wk==10) {
                ($witem,$weff,$witai) = ($w_bou_a,$w_bdef_a,$w_btai_a);
                $w_bou_a = "����"; $w_bdef_a = $w_btai_a = 0;
            } else {
                ($witem,$weff,$witai) = ($w_item[$wk],$w_eff[$wk],$w_itai[$wk]);
                $w_item[$wk] = "����"; $w_eff[$wk]=$w_itai[$wk] = 0;
            }
            $userlist[$i] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$id,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf,\n" ;
            open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);
            last;
        }
    }

    if ($witem!~/^(����|�Ǽ�|�ӿ�)$/ && $i!=$#userlist+1){
        $item[$itno2] = $witem ;
        $eff[$itno2] = $weff; $itai[$itno2] = $witai ;
        ($witem)=split(/<>/,$witem,2);
        $log = ($log . "$l_name��(��) $witem��(��) �Լ��ߴ�.<BR>") ;
        &SAVE;
    }else{
        $log = ($log . "���Ѵ� ���� �����ߴ�.<BR>") ;
    }


    $Command = "MAIN";
}

#=====================#
# �� ������ ���� ó�� #
#=====================#
sub WINCHG {

	if (length($msg2) > 64) { $log = ($log . "���ؽ� ����� ���ڼ��� ������ �Ѿ����ϴ�. \(�ѱ� 32���ڱ���\)<br>���ؽ� ���� ������� �ʾҽ��ϴ�.<br>"); }
	else { $msg = $msg2; $checkwinchg = 1; }
	if (length($dmes2) > 64) { $log = ($log . "������ ���ڼ��� ������ �Ѿ����ϴ�. \(�ѱ� 32���ڱ���\)<br>������ ������� �ʾҽ��ϴ�.<br>"); }
	else { $dmes = $dmes2; $checkwinchg = 1; }
	if (length($com2) > 64) { $log = ($log . "�ڸ�Ʈ�� ���ڼ��� ������ �Ѿ����ϴ�. \(�ѱ� 32���ڱ���\)<br>�ڸ�Ʈ�� ������� �ʾҽ��ϴ�.<br>"); }
	else { $com = $com2; $checkwinchg = 1; }
	if ($checkwinchg) {
		$log = ($log . "��縦 �����߽��ϴ�.<br>") ;
		&SAVE ;
	}

    $Command = "MAIN" ;

}

#==================#
# �� �⺻��ħ ���� #
#==================#
sub KOUDOU {

	local($wk) = $Command;
	$wk =~ s/KOU_//g;

	if ($wk == 0) {	#����
		$tactics = "����";
	}elsif ($wk == 1) {	#�����߽�
		$tactics = "�����߽�";
	}elsif ($wk == 2) {	#����߽�
		$tactics = "����߽�";
	}elsif ($wk == 3) {	#�����ൿ
		$tactics = "�����ൿ";
	}elsif ($wk == 4) {	#Ž���ൿ
		$tactics = "Ž���ൿ";
	}elsif ($wk == 5) {	#���Ӱ���
		$tactics = "���Ӱ���";
	}

	$log = ($log . "�⺻��ħ�� $tactics�� �����ߴ�.<BR>\n") ;
	
	&SAVE ;
	
	$Command = "MAIN" ;
}

#===================#
# �� ��ü �߰� ó�� #
#===================#
sub DEATHGET {

	$log = ($log . "$w_f_name $w_l_name�� ��ü�� �߰��ߴ�.<br>\n") ;

	if ($w_death =~ /����/) {
		if ($w_com == 0) {$log = ($log . "�Ӹ��κ��� �� �ִ� �Ǻ� �ϳ��� �̾��� �ִ� ���´�... ���� �߸����ϴ�.<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "���ΰ� ������ ���� ���� ������ ������, ������ Ƣ����ִ�...<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "����������� ������ ���� �񽺵��� ������. ������ ������ �ִ�...<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "��, ��, ����, ��ٸ��� ��� �߷��� �ִ�. �̷� ���� �������� �ΰ��� �� �� �ִ� ���ϱ�...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "�Ӹ��� ���������� �߰� ����� �ִ�. ������� ���� ������� ���� �������� �ʴ�...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "���ΰ� ������ ������, �� ���� �ո񿡵� Į�ڱ��� ���� �ִ�...<BR>��뿡�� ���� �Ŀ� �ڻ��� �Ϸ��� �ߴ� ���ϱ�?<br>\n") ;}
		else {$log = ($log . "�Ӹ����� ������ ���� ������ �߷� �ִ�...<br>\n") ;}
	}elsif ($w_death =~ /���/) {
		if ($w_com == 0) {$log = ($log . "�̸��� �ѹ��� ȭ���� �����ִ�...<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "� ����̳� �Ǵ� ȭ���� �����ִ�. ����ġ���� ���� ��, ��ڿ��� �������ϴ�.<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "���忡 �ѹ� ��Ȯ�ϰ� ȭ���� ���� �ִ�. ����� �Ƿ��� �����ڰ���...<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "�ٸ��� �Ӹ��� ȭ���� ���� �ִ�. �ٸ��� ���, ����ĥ �� ���� ���� �Ŀ� �޼Ҹ� ��� ����...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "���� ȭ��� ���� �����Ǿ��ִ�... ���� ������� ó���� ���� ���� �ڼ���...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "�ʼ����� ȭ���� ����, ����ġó�� �Ǿ� �ִ�...<br>\n") ;}
		else {$log = ($log . "�� ��� ȭ���� ���� �ִ�... �ѹ��� �� �Ʒ��� ���� �ִ�...<br>\n") ;}
	}elsif ($w_death =~ /�ѻ�/) {
		if ($w_com == 0) {$log = ($log . "������ 3��, �̸��� 1���� ź���� �ִ�... �̸��� �ѹ��� ġ����� �� ���ϴ�...<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "���ο� ����� ź���� �ְ�, �ǰ� �귯 ������ �ִ�. �׷���, �� �ǵ� �̹� ���� �ִ�.<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "�Ӹ��� ������ �������� ���� ������ ���ư� �ִ�... ������ ���� ������ �̸��� �˾��� ������.<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "������ ���. �׸���, ������ ��ѷ��� �ִ�. ���� ��, �Կ� ���� �ȾƳְ� �� ���̰���. �������� ���� �ߴ�...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "���ο� ������ �� �Է��־�, �ݴ����� ���δ�. �̷��� ���� ��� ���� �� ���ڱ���...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "�󱼿� ����̳� ź���� �ִ�... �����̶� �־��� ���ϱ�.<br>\n") ;}
		else {$log = ($log . "������ �Ӹ��κ��� ���ϰ� �ջ�Ǿ�, ���� �귯�����ִ�...<br>\n") ;}
	}elsif ($w_death =~ /����/) {
		if ($w_com == 0) {$log = ($log . "������ ���� �������ϱ�... �Կ����� ���� ���买�� �긮�� �ִ�.<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "������� ��ü�ΰ�... ���Ѽ��� �ü����� ������ ���� �ִ�.<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "������ ���� ���ȱ� �����ϱ�. ���� ���а�, ���� ���ư� ������ ����ϴ�.<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "���������� ���� ���� ���� �� ����. ������ ���� ������ �ִ�...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "���� ������ ���ϰ� ������ ���ϱ�. ���鿡 �� ���� ���� ���� �ִ�...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "���� �Ŵ� ��ü��... ���� ��, �Ŵ� ������ �ۿ� �� �� ����...<br>\n") ;}
		else {$log = ($log . "����̿�, ������ �������� ���ֻ� ������ �ִ�...<br>\n") ;}
	}elsif ($w_death =~ /����/) {
		if ($w_com == 0) {$log = ($log . "��ó�� ���� �� �κ��� �л�Ǿ� �ִ�. ȭ���ϰ� ���ѵ� ���δ�...<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "����� ���ư� �ִ�. �ȸ����� ��� ���������� �� ���ΰ�...<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "��ź���� ���ݴ��� ���ϱ�, �Ӹ��� ������ �ȸ� �����ִ�...<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "��ź�� ���ư� ���ϱ�, �Ӹ��� ������ ����� ���� �鿩�� ���δ�...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "��ǳ���� ���ư� ���� ���� 5m���� �տ� �߱��� �ִ�...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "��ü��⺸��, �쵢�����...<br>\n") ;}
		else {$log = ($log . "��� ���� �������ʳ�... ��ǳ���� ���ư� ���ϱ�...<br>\n") ;}
	}elsif ($w_death =~ /�ڻ�/) {
		if ($w_com == 0) {$log = ($log . "�踦 ������ �ڼ���, ��ũ���� �ִ�... �ƹ�����, �״�� ���� ������ϴ�...<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "��뿡�� ��û���� ������ ���δ�... �Ӹ��� ���ֻ����� ��Ǯ�� �ö��ִ�...<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "����� �η���, �񿡼� ���� Ƣ��� �ִ�...<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "���� ���� ���, ���� �Ǹ� ���ʿ��� �긮�� �ִ�... ���� ����, �ĵκθ� ���� ���ϴ�.<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "�ڿ��� �б�� ���� ������ ���� ���ϱ�? �Ӹ��� ����ä �׾� �ִ�...<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "�̸��� �ɰ���, �ǿ� ������ �帣�� �ִ�. ���鿡�� ���� �������ϱ���...<br>\n") ;}
		else {$log = ($log . "���� ��Ȯ�� ���� ���� �ִ�. �ƹ��� ����, ����� �η��� �ִ�...<br>\n") ;}
	}elsif ($w_death =~ /ô��/) {
		if ($w_com == 0) {$log = ($log . "�¸���, ���� ������ ���� �� ��ó��, ���� �ִ�... ��ü�� �ֺ���, �ǹٴٴ�...<br>\n") ;}
		elsif ($w_com == 1) {$log = ($log . "��밡 �ö�Ÿ��, ����ؼ� ����� ��ó�� �ִ�...<br>\n") ;}
		elsif ($w_com == 2) {$log = ($log . "������ �ѹ� ���, ���� ��ó���� �ǰ� �ھ� ������ �ִ�... ���� ���� �ٷ����� ���ϴ�.<br>\n") ;}
		elsif ($w_com == 3) {$log = ($log . "���� ��� �ִ�... ���� �������� �巯���� �ִ�...<br>\n") ;}
		elsif ($w_com == 4) {$log = ($log . "�ڿ��� ���θ� ��� �׾� �ִ�. ������ ���� ���ϱ�...?<br>\n") ;}
		elsif ($w_com == 5) {$log = ($log . "���� ���ΰ� ���ϰ� �ջ�Ǿ� �ִ�. �� ��, ������ ���� ���Ͱ� �ִ�...<br>\n") ;}
		else {$log = ($log . "���� ����, ������ ��� �ִ�... ��ġ �Ǵ����� �긮�� �ִ� �� ����...<br>\n") ;}
    }elsif ($w_death =~ /��/) {
        if ($w_com == 0) {$log = ($log . "���� ���� ���ϱ�...? ������ ������ �ִ�...<br>\n") ;}
        elsif ($w_com == 1) {$log = ($log . "�Կ��� �Ѱ��� �ǰ� �귯 �ִ�. ���ͺ���, �ڰ� �ִ� �ɷ� ���̴±���...<br>\n") ;}
        elsif ($w_com == 2) {$log = ($log . "��ü�� ���� ������ ���� Ư���� �Ƹ�� ������ ����. ����� ���ΰ�...<br>\n") ;}
        elsif ($w_com == 3) {$log = ($log . "����� ���ΰ�. �Կ��� �ǰ� ���� ���� ��ǰ�� ���� �ִ�...<br>\n") ;}
        elsif ($w_com == 4) {$log = ($log . "���� �԰� ���ο� �ߴ� ���ϱ�. ������ ���� ���ϰ� �������� ������ ����...<br>\n") ;}
        elsif ($w_com == 5) {$log = ($log . "���������� ���̶� ���Ѱǰ�? �Ǻΰ� ���ϰ� �����Ǿ� �ִ�.<br>\n") ;}
        else {$log = ($log . "�Ǻΰ� ����İ� ���� �ְ�, �Կ����� ���� �Ǹ� ���� ���� ���δ�...<br>\n") ;}
	} else {
		$log = ($log . "�����ϰ� ���� ���ư� �ִ�...<br>\n") ;
	}
	$log = ($log . "�賶 ���� ��������...<br>\n") ;
	$Command = "DEATHGET";

    $chksts="OK";

}
#=====================#
# �� ���õ� Ȯ�� ó�� #
#=====================#
sub WEPPNT {

    $log = ("������ ���� ������...<br>") ;

    local($p_wa) = int($wa/$BASE);
    local($p_wb) = int($wb/$BASE);
    local($p_wc) = int($wc/$BASE);
    local($p_wd) = int($wd/$BASE);
    local($p_wg) = int($wg/$BASE);
    local($p_ws) = int($ws/$BASE);
    local($p_wn) = int($wn/$BASE);
    local($p_wp) = int($wp/$BASE);

    $log = ($log . "<BR>�Ҽ� Ŭ����$club<br><br>") ;
    $log = ($log . "��Ȱ��$p_wa($wa)�������$p_wb($wb)�������⣺$p_wc($wc)����ź��$p_wd($wd)<br>") ;
    $log = ($log . "���ѣ�$p_wg($wg)����⣺$p_ws($ws)��Į��$p_wn($wn)�������⣺$p_wp($wp)<br>") ;

}
#===================#
# �� ��� Ȯ�� ó�� #
#===================#
sub DEFCHK {

    local($w_name,$w_kind) = split(/<>/, $wep);
    local($b_name,$b_kind) = split(/<>/, $bou);
    local($b_name_h,$b_kind_h) = split(/<>/, $bou_h);
    local($b_name_f,$b_kind_f) = split(/<>/, $bou_f);
    local($b_name_a,$b_kind_a) = split(/<>/, $bou_a);
    local($b_name_i,$b_kind_i) = split(/<>/, $item[5]);

    $log = ("���� ����ϰ� �ִ� ������...<br><br>") ;

    $log = ($log . "�����⡡����$w_name/$watt/$wtai<br>") ;
    $log = ($log . "����������$b_name/$bdef/$btai<br>") ;
    $log = ($log . "���Ӹ�������$b_name_h/$bdef_h/$btai_h<br>") ;
    $log = ($log . "���ȡ�����$b_name_a/$bdef_a/$btai_a<br>") ;
    $log = ($log . "���ٸ�������$b_name_f/$bdef_f/$btai_f<br>") ;
    $log = ($log . "����ġ�����$b_name_i/$eff[5]/$itai[5]<br>") ;

}
#==================#
# �� ����óġ ó�� #
#==================#
sub OUKYU {

    local($wk) = $Command;
    $wk =~ s/OUK_//g;

    if ($wk == 0) { #�Ӹ�
        $inf =~ s/��//g ;
    }elsif ($wk == 1) { #��
        $inf =~ s/��//g ;
    }elsif ($wk == 2) { #����
        $inf =~ s/��//g ;
    }elsif ($wk == 3) { #�ٸ�
        $inf =~ s/��//g ;
    }

    $log = ($log . "����óġ�� �ߴ�.<BR>") ;

    $sta -= $okyu_sta ;

    if ($sta <= 0) {    #���׹̳� ����?
        &DRAIN("com");
    }

    &SAVE ;

    $Command = "MAIN" ;
}
1
