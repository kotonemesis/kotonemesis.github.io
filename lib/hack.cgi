### �ϫë���?�� by kelp###

sub HACKING{
    if ($Command ne "HACK") {
    &ERROR("���� �＼���Դϴ�.");
    }

    for ($paso=0; $paso<5; $paso++){
        if ($item[$paso] eq "�����PC<>Y"){ last; }
    }

	if ( $itai[$paso] <= 0 ) {
		$log = ($log . "�����PC�� ������ ������ �ʴ´�. ���͸��� ���°ɱ�...<BR>");
		return;
	}

    local($bonus) = 0;  #����������(0����10%)
    local($dice1) = int(rand(10)) ;
    local($dice2) = int(rand(10)) ;

    if ($club =~ /��ǻ�ͺ�/){ #�ѫ�����ݻ������������
        $bonus = 5;
    }


    local($kekka) = $bonus;
    if ($dice1 <= $kekka){     #�ϫë�����������
        open(DB,"$area_file");seek(DB,0,0); my(@wk_arealist)=<DB>;close(DB);
        my($wk_ar,$wk_hack,$wk_a) = split(/,/, $wk_arealist[1]);  #�ϫë��󫰫ի髰����
        $wk_hack = 1;
        $wk_arealist[1] = "$wk_ar,$wk_hack,\n";
        open(DB,">$area_file"); seek(DB,0,0); print DB @wk_arealist; close(DB);
        $log = ($log . "��ŷ ����! ��� ���������� �����Ǿ���!!<BR>") ;
    }else{
        $log = ($log . "��ŷ�� �����ߴ�...<BR>") ;
    }

    if ($dice1 >= 9){   #�Ыëƫ���ģ��ի���֫���Ѧ���?
        $item[$paso] = "����"; $eff[$paso] = $itai[$paso] = 0 ;
        $log = ($log . "���̷���! ��ġ�� �μ����� ���Ҵ�.<BR>") ;
        if ($dice2 >= 9){  #��?(���ի���֫�)����ݤ�˪����������
            $hit = 0 ; $sts = "���"; $death = $deth = "���ο� ���� ó��";$mem--;
            if ($mem == 1) {
                open(FLAG,">$end_flag_file"); print(FLAG "����\n"); close(FLAG);
            }
            &LOGSAVE("DEATH5") ;
            open(DB,"$gun_log_file");seek(DB,0,0); @gunlog=<DB>;close(DB);
            $gunlog[1] = "$now,$place[$pls],$id,,\n";
            open(DB,">$gun_log_file"); seek(DB,0,0); print DB @gunlog; close(DB);
            $log = ($log . "���̷���! ��ġ�� �μ����� ���Ҵ�.<BR><br>...����?...����̿��� �������\.\.\.\!\?<BR><BR><font color=\"red\">...!!...<br><br><b>$f_name $l_name \($cl $sex$no��\)��\(��\) ����ߴ�.</b></font><br>") ;
        }
    }else{
        $itai[$paso] --;
        if ($itai[$paso] == 0) {
            $log = ($log . "�����PC�� ���͸��� �� ����ȴ�.<BR>") ;
        }
    }

    &SAVE;
}
1
