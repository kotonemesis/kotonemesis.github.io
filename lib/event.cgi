#==================#
# �� ���٫��?��  #
#==================#
sub EVENT {

    local($dice) = int(rand(20)) ;
    local($dice2) = int(rand(5)+5) ;
    $Command = "MAIN";
    if ($dice < 17) {return ; }


    if ($pls == 0) {    #����

    } elsif ($pls == 1) {   #����ˢ

    } elsif ($pls == 2 || $pls == 12 || $pls == 18) {   #��������ʶ #��?�����ʶ #޼�������ʶ
        $log = ($log . "����, �ϴ��� ����, �������̴�!<BR>") ;
        if ($dice == 18) {
            $log = ($log . "������ ���ݹ޾�, �Ӹ��� ���ƴ�!<BR>") ;
            $inf =~ s/��//g ;
            $inf = ($inf . "��") ;
        } elsif ($dice == 19) {
            $log = ($log . "������ ���ݹ޾�, <font color=\"red\"><b>$dice2������</b></font> �� �Ծ���!<BR>") ;
            $hit-=$dice2;
            if ($hit <= 0) {
                $hit = $mhit = 0;
                $log = ($log . "<font color=\"red\"><b>$f_name $l_name��$cl $sex$no������(��) ����ߴ�.</b></font><br>") ;

                #���̫�
                &LOGSAVE("DEATH") ;

				if ($pls == 12 || $pls == 18) {
					$Command = "EVENT";
				}
            }
        } else {
        $log = ($log . "�Ŀ�, ������ �ѾƳ´�...<BR>") ;
        }
        $chksts="OK";
    } elsif ($pls == 3) {   #��������
    } elsif ($pls == 4) {   #������
    } elsif ($pls == 5) {   #�����
    } elsif ($pls == 6) {   #?����
    } elsif ($pls == 7) {   #����
    } elsif ($pls == 8) {   #ι�����
    } elsif ($pls == 9) {   #�۫ƫ���
    } elsif ($pls == 10) {  #ߣ��?
        $log = ($log . "�̷�, ��簡 �������!<BR>") ;
        if ($dice == 18) {
            $log = ($log . "������ ��������, ������ ���� ���ƴ�!<BR>") ;
            $inf =~ s/��//g ;
            $inf = ($inf . "��") ;
        } elsif ($dice == 19) {
            $log = ($log . "������ ����, <font color=\"red\"><b>$dice2������</b></font> ��(��) �Ծ���!<BR>") ;
            $hit-=$dice2;
            if ($hit <= 0) {
                $hit = $mhit = 0;
                $log = ($log . "<font color=\"red\"><b>$f_name $l_name��$cl $sex$no������(��) ����ߴ�.</b></font><br>") ;

                #���̫�
                &LOGSAVE("DEATH") ;
                $Command = "EVENT";
            }
        } else {
            $log = ($log . "�Ŀ�, ������ ���ߴ�...<BR>") ;
        }
        $chksts="OK";
    } elsif ($pls == 11) {  #�ȫ�ͫ�
    } elsif ($pls == 13) {  #��?��
    } elsif ($pls == 14) {  #������
    } elsif ($pls == 15) {  #�������
    } elsif ($pls == 16) {  #ߵ���?
        $log = ($log . "���ڱ�, �鰳�� ������ �Դ�!<BR>") ;
        if ($dice == 18) {
            $log = ($log . "���� ����, ���� ���ƴ�!<BR>") ;
            $inf =~ s/��//g ;
            $inf = ($inf . "��") ;
        } elsif ($dice == 19) {
            $log = ($log . "�鰳���� ���ݹ޾�, <font color=\"red\"><b>$dice2������</b></font> ��(��) �Ծ���!<BR>") ;
            $hit-=$dice2;
            if ($hit <= 0) {
                $hit = $mhit = 0;
                $log = ($log . "<font color=\"red\"><b>$f_name $l_name��$cl $sex$no������(��) ����ߴ�.</b></font><br>") ;

                #���̫�
                &LOGSAVE("DEATH") ;
                $Command = "EVENT";
            }
        } else {
            $log = ($log . "�Ŀ�, ������ �ѾƳ´�...<BR>") ;
        }
        $chksts="OK";
    } elsif ($pls == 17) {  #���?�
        $log = ($log . "�̷�, ���� �̲�������!<BR>") ;
        if ($dice <= 18) {
            $dice2 += 10;
            $log = ($log . "���� ������ ����������, ������ ��� �ö�Դ�!<BR>���׹̳ʸ� <font color=\"red\"><b>$dice2����Ʈ</b></font> �Һ��ߴ�!<BR>") ;
            $sta-=$dice2;
            if ($sta <= 0) {    #�����߫�﷪죿
                &DRAIN("eve");
            }
        } else {
            $log = ($log . "�Ŀ�, ������ �̲������� �ʾҴ�...<BR>") ;
        }
        $chksts="OK";
    } elsif ($pls == 19) {  #�����
    } elsif ($pls == 20) {  #?��
    } elsif ($pls == 21) {  #����ˢ
    }
}

1
