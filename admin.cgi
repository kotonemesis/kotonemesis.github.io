#!/usr/bin/perl

#require "jcode.pl";
require "br.pl";
require "$lib_file";
require "$lib_file2";
&LOCK;
require "$pref_file";

    &ADMDECODE ;
    # GET �޼ҵ带 �ź�
    if ($Met_Post && !$p_flag) {
        &ERROR("���� �＼���Դϴ�.");
    }
    if ($admpass ne $a_pass){&MAIN;&UNLOCK;exit;};

    if ($Command eq "MAIN") {
        &MENU ;
    } elsif ($Command eq "BSAVE") {
        &BACKSAVE;
    } elsif ($Command eq "BREAD") {
        &BACKREAD;
    } elsif ($Command eq "RESET") {
        &DATARESET;
    } elsif ($Command eq "USERLIST") {
        &USERLIST;
    } elsif ($Command eq "USERDEL") {
        &USERDEL;
    } elsif ($Command eq "LOGON") {
        &MAIN;
    } else { &MAIN; }
&UNLOCK;

exit;

#==================#
# �� ���� ���     #
#==================#
sub MAIN {

    push(@log,"<B><FONT color=\"#ff0000\" size=\"+3\">�������</FONT></B><BR><BR>\n");
    push(@log,"������ �н�����\n");
    push(@log,"<FORM METHOD=\"POST\">\n");
    push(@log,"<INPUT TYPE=\"HIDDEN\" NAME=\"Command\" VALUE=\"USERLIST\">\n");
    push(@log,"<INPUT size=\"16\" type=\"password\" name=\"Password\" maxlength=\"16\">\n");
    push(@log,"��<INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n");
    push(@log,"</FORM>\n");

    &HEADER ;
    print @log;
    &FOOTER;
}
#==================#
# �� ���� ���     #
#==================#
sub MENU {

    push(@log,"<B><FONT color=\"#ff0000\" size=\"+3\">�������</FONT></B><BR><BR>\n");
    push(@log,"<FORM METHOD=\"POST\">\n");
    push(@log,"<TABLE border=\"0\">\n");
    push(@log,"<TR><TD>\n");
    push(@log,"<INPUT type=\"hidden\" name=\"Password\" value=\"$admpass\">\n");
    push(@log,"<INPUT type=\"radio\" name=\"Command\" value=\"USERLIST\" checked>���� ����Ʈ<BR>\n");
    push(@log,"<INPUT type=\"radio\" name=\"Command\" value=\"BSAVE\">��� ����<BR>\n");
    push(@log,"<INPUT type=\"radio\" name=\"Command\" value=\"BREAD\">��� �б�<BR>\n");
    push(@log,"<INPUT type=\"radio\" name=\"Command\" value=\"RESET\">������ �ʱ�ȭ<BR>\n");
    push(@log,"</TD></TR>\n");
    push(@log,"</TABLE>\n");
    push(@log,"<BR><INPUT type=\"submit\" name=\"Enter\" value=\"Ȯ��\">\n");
    push(@log,"</FORM>\n");

    &HEADER ;
    print @log;
    &FOOTER;
}
#==================#
# �� ��� ����     #
#==================#
sub BACKSAVE {

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);
    open(DB,">$back_file"); seek(DB,0,0); print DB @userlist; close(DB);

    push(@log,"<B><FONT color=\"#ff0000\" size=\"+3\">�������</FONT></B><BR><BR>\n");
    push(@log,"����� �ۼ��߽��ϴ�.<br>\n");

    &HEADER ;
    print @log;
    print "<br>\n";
    &FOOTER;

}
#==================#
# �� ��� �ε�     #
#==================#
sub BACKREAD {

    open(DB,"$back_file");seek(DB,0,0); @userlist=<DB>;close(DB);
    open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);

    push(@log,"<B><FONT color=\"#ff0000\" size=\"+3\">�������</FONT></B><BR><BR>\n");
    push(@log,"����� �о�鿴���ϴ�.<br>\n");
    push(@log,"<br>\n");

    &HEADER ;
    print @log;
    &FOOTER;
}
#==================#
# �� ������ �ʱ�ȭ #
#==================#
sub DATARESET {

    if($npc_mode eq "0"){
        $userlist[0]="";
        open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);
    }else{
        open(DB,"$npc_file");seek(DB,0,0); @baselist=<DB>;close(DB);
        $LEN = @baselist;

        if ($LEN > 0) {
            for ($i=0; $i<$LEN; $i++) {
                ($w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_com,$w_msg,$w_dmes) = split(/,/, $baselist[$i]);

                if (($w_cl eq "$BOSS")||($w_cl eq "$ZAKO")){  #������ NPC
                    $w_att = int(rand(10)) + 40 ;
                    $w_def = int(rand(10)) + 40 ;
                    $w_hit = int(rand(30)) + 120 ;
                    $w_level = 10; $w_exp = $baseexp+$lvinc*$w_level;
                    $w_tactics = "����"; $w_death = "" ;
                    $w_pls = 0;
                    $w_wn=$w_wp=$w_wa=$w_wg=$w_we=$w_wc=$w_wd=$w_wb=$w_wf=$w_ws= $BASE * 5;
                    $w_mhit=$w_hit; $w_sta = $maxsta;
                    $w_sts = "NPC0";
                }else{  #��Ÿ NPC�� ����
                    $w_att = int(rand(5)) + 8 ;
                    $w_def = int(rand(5)) + 8 ;
                    $w_hit = int(rand(20)) + 80 ;
                    $w_level = 1; $w_exp = $baseexp+$lvinc*$w_level;
                    $w_tactics = "����"; $w_death = "" ;
                    $w_pls = int(rand($#area)+1) ;
                    $w_wn=$w_wp=$w_wa=$w_wg=$w_we=$w_wc=$w_wd=$w_wb=$w_wf=$w_ws=0;
                    $w_mhit=$w_hit; $w_sta = $maxsta;
                    $w_sts = "NPC";
                }
                $w_kill = 0 ;
                $w_id = ($a_id . "$i"); $w_password = $a_pass;
                $w_club="����";
                $w_log = "" ; $w_bid = "" ; $w_inf="";

                $userlist[$i] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf,\n" ;
            }
        }
        open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);
    }

    #�ð� ���� ���ΰ�ħ
    $endtime = $now + ($battle_limit*60*60*24);
    $timelist="$now,$endtime,\n" ;
    open(DB,">$time_file"); seek(DB,0,0); print DB $timelist; close(DB);

    #�л� ��ȣ ���� ���ΰ�ħ
    $memberlist="0,0,0,0,\n" ;
    open(DB,">$member_file"); seek(DB,0,0); print DB $memberlist; close(DB);

    #���� ���� ���� ���ΰ�ħ
    ($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($now+(1*60*60*24));
    $year+=1900;
    $min = "0$min" if ($min < 10);  $month++;
    $areadata[0] = ($year . "," . $month . "," . $mday . "," . "0,0\n") ;   #���� �߰� �ð�
    $areadata[1] = "1,0,\n" ; #���� ����, ��ŷ ������

    @work = @place ;
    @work2 = @area ;
    @work3 = @arno ;

    $ar = splice(@work,0,1) ;
    $areadata[2] = "$ar," ;
    $ar2 = splice(@work2,0,1) ;
    $areadata[3] = "$ar2," ;
    $ar3 = splice(@work3,0,1) ;
    $areadata[4] = "$ar3," ;

    for ($i=1; $i<$#place+1; $i++) {
        $chk=$#work;$index = int(rand($chk));
        $ar = splice(@work,$index,1) ;
        $areadata[2] = ($areadata[2] . "$ar,");
        $ar2 = splice(@work2,$index,1) ;
        $areadata[3] = ($areadata[3] . "$ar2,");
        $ar3 = splice(@work3,$index,1) ;
        $areadata[4] = ($areadata[4] . "$ar3,");
    }
    $areadata[2] = ($areadata[2] . "\n");
    $areadata[3] = ($areadata[3] . "\n");
    $areadata[4] = ($areadata[4] . "\n");

    open(DB,">$area_file"); seek(DB,0,0); print DB @areadata; close(DB);

    #�α� ���ΰ�ħ
    $loglist = "$now,,,,,,,,,,,NEWGAME,,\n" ;
    open(DB,">$log_file"); seek(DB,0,0); print DB $loglist; close(DB);


    for ($i=1; $i<$#area+1; $i++) {
        @areaitem = "" ;
        $filename = "$LOG_DIR/$i$item_file";
        open(DB,">$filename"); seek(DB,0,0); print DB @areaitem; close(DB);
    }

    #������ ���� ���ΰ�ħ
    open(DB,"$DAT_DIR/$item_file");seek(DB,0,0); @itemlist=<DB>;close(DB);

    for ($i=0; $i<$#itemlist+1; $i++) {
        ($idx, $w_i,$w_e,$w_t) = split(/,/, $itemlist[$i]);

        if ($idx == 99) { $idx = int(rand($#place)+1) ; }

        $filename = "$LOG_DIR/$idx$item_file";
        open(DB,"$filename");seek(DB,0,0); @areaitem=<DB>;close(DB);
        push(@areaitem,"$w_i,$w_e,$w_t,\n") ;
        open(DB,">$filename"); seek(DB,0,0); print DB @areaitem; close(DB);
    }

    #�Ѽ� �α� ���� ���ΰ�ħ
    local($null_data) = "0,,,,";
    open(DB,">$gun_log_file");
    for ($i=0; $i<6; $i++){
        print DB "$null_data\n";
    }
    close(DB);

    #���� ���� ������ ����
    opendir(DIR, "$u_save_dir");
    foreach $file (readdir(DIR)) {
        unless($file =~ /^\.{1,2}$/){
            if($file =~ /$u_save_file/){
                push (@f_list,"$u_save_dir$file");
            }
        }
    }
    closedir(DIR);
    unlink(@f_list);

    #FLAG ���� ���ΰ�ħ
    open(FLAG,">$end_flag_file"); print FLAG ""; close(FLAG);

    push(@log,"<B><FONT color=\"#ff0000\" size=\"+3\">�������</FONT></B><BR><BR>\n");
    push(@log,"�ʱ�ȭ �߽��ϴ�.<br>\n");
    push(@log,"<br>\n");

    &HEADER ;
    print @log;
    &FOOTER;

}
#==================#
# �� ���ڵ� ó��   #
#==================#
sub ADMDECODE {
    $p_flag=0;
    if ($ENV{'REQUEST_METHOD'} eq "POST") {
        if ($ENV{'CONTENT_LENGTH'} > 51200) { &ERROR("�̻��� �Է��Դϴ�"); }
        read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
        $p_flag=1;
    } else { $buffer = $ENV{'QUERY_STRING'}; }
    @pairs = split(/&/, $buffer);
    foreach (@pairs) {
        ($name,$value) = split(/=/, $_);
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

        # ���� �ڵ带 EUC ��ȯ
        if ($name eq "Del") { push(@DEL,$value);}
# Jcode ���� �ּ�ó�� by �縮��
#        &jcode'convert(*value, "euc", "", "z");
#        &jcode::tr(\$value, '��', ' ');

        $value =~ s/</&lt;/g;
        $value =~ s/>/&gt;/g;
        $value =~ s/&/&amp;/g;
        $value =~ s/"/&quot;/g;
        $value =~ s/ /&nbsp;/g;
        $value =~ s/,/��/g; #������ ���� ����

        $in{$name} = $value;
    }

    $id = $in{'Id'};
    $admpass = $in{'Password'};
    $Command = $in{'Command'};
    $Message = $in{'Message'};
    if($buffer eq ""){$Command = "LOGON"; $p_flag=1;}

}
#==================#
# �� �϶�ǥ�� ó�� #
#==================#
sub USERLIST {

    local($col_s1) = "<font color=white>" ;
    local($col_s2) = "<font color=red>" ;
    local($col_e) = "</font>" ;

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    push(@log,"<P align=\"center\"><B><FONT color=\"#ff0000\" size=\"+3\">������ ����Ʈ</FONT></B><BR></P>");
    push(@log,"<form action=\"admin.cgi\" method=\"POST\">\n");
    push(@log,"<TABLE border=\"1\">\n");
    push(@log,"<tr align=\"center\"><td>����</td><td width=\"100\">�̸�/���̵�/�н�����</td><td>����/����/�⺻��ħ</td><td>IP/Host Name</td><td>����</td></tr>\n");
    foreach (0 .. $#userlist) {
        ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$_]);

		if ( $w_hit <= 0 ) {
			$checkmsg = "$w_dmes";
		}
		else {
			$checkmsg = "$w_msg<br>$w_dmes<br>$w_com";
		}
        if ($w_hit <= 0) { $col_s = $col_s2; } else { $col_s = $col_s1;}
        push(@log,"<tr><td><input type=checkbox name=Del value=\"$_\"></td><td align=\"center\">$col_s$w_f_name $w_l_name<br>$w_id<br>$w_password$col_e</td><td>$col_s$w_sts<br>$w_tactics<br>$place[$w_pls]$col_e</td><td style=word-break:break-all>$w_we<br>$w_wf</td><td>$checkmsg</td></tr>\n");

    }
    push(@log,"</table><BR>\n");
    push(@log,"���� �޽�����<INPUT size=\"64\" type=\"text\" name=\"Message\" maxlength=\"64\"><BR><BR>\n");
    push(@log,"<input type=hidden name=Command value=\"USERDEL\">\n") ;
    push(@log,"<input type=hidden name=Password value=$admpass>\n");
    push(@log,"<input type=submit value=\"�����Ѵ�\"><input type=reset value=\"����\">\n") ;
    push(@log,"</form>\n");
    push(@log,"<form action=\"admin.cgi\" method=\"POST\">\n");
    push(@log,"<input type=hidden name=Command value=\"MAIN\">\n") ;
    push(@log,"<input type=hidden name=Password value=$admpass>\n");
    push(@log,"<input type=submit value=\"���θ޴�\">\n") ;
    push(@log,"</form><BR>\n");

    &HEADER ;
    print @log;
    &FOOTER;

}
#==================#
# �� ���� ó��     #
#==================#
sub USERDEL {

    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    foreach (0 .. $#DEL) {
        ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$DEL[$_]]);
        $w_msg = $Message;
        &LOGSAVE("DEATH4") ;
        $w_hit = 0 ; $w_sts = "���"; $w_death=$deth;
        $userlist[$DEL[$_]] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf,\n" ;
    }

    open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);


    &USERLIST;


}
