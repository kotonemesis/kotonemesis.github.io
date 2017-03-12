#==================#
# ¡á «¤«Ù«ó«È?×â  #
#==================#
sub EVENT {

    local($dice) = int(rand(20)) ;
    local($dice2) = int(rand(5)+5) ;
    $Command = "MAIN";
    if ($dice < 17) {return ; }


    if ($pls == 0) {    #ÝÂÎè

    } elsif ($pls == 1) {   #ÝÁªÎË¢

    } elsif ($pls == 2 || $pls == 12 || $pls == 18) {   #ÌÇà´õ½ñ¬ÓëÊ¶ #øÁ?õ½ñ¬ÓëÊ¶ #Þ¼ô¹õ½ñ¬ÓëÊ¶
        $log = ($log . "¹®µæ, ÇÏ´ÃÀ» º¸ÀÚ, »õ¶¼µéÀÌ´Ù!<BR>") ;
        if ($dice == 18) {
            $log = ($log . "»õ¿¡°Ô ½À°Ý¹Þ¾Æ, ¸Ó¸®¸¦ ´ÙÃÆ´Ù!<BR>") ;
            $inf =~ s/Ôé//g ;
            $inf = ($inf . "Ôé") ;
        } elsif ($dice == 19) {
            $log = ($log . "»õ¿¡°Ô ½À°Ý¹Þ¾Æ, <font color=\"red\"><b>$dice2µ¥¹ÌÁö</b></font> ¸¦ ÀÔ¾ú´Ù!<BR>") ;
            $hit-=$dice2;
            if ($hit <= 0) {
                $hit = $mhit = 0;
                $log = ($log . "<font color=\"red\"><b>$f_name $l_name£¨$cl $sex$no¹ø£©Àº(´Â) »ç¸ÁÇß´Ù.</b></font><br>") ;

                #ÞÝØÌ«í«°
                &LOGSAVE("DEATH") ;

				if ($pls == 12 || $pls == 18) {
					$Command = "EVENT";
				}
            }
        } else {
        $log = ($log . "ÈÄ¿ì, °£½ÅÈ÷ ÂÑ¾Æ³Â´Ù...<BR>") ;
        }
        $chksts="OK";
    } elsif ($pls == 3) {   #ÌÇà´õ½æµíÞ
    } elsif ($pls == 4) {   #éèøµÏÑ
    } elsif ($pls == 5) {   #á¼ÛÁßþ
    } elsif ($pls == 6) {   #?ëåÓÑ
    } elsif ($pls == 7) {   #ÍÔê«ò®
    } elsif ($pls == 8) {   #Î¹ê«ãêÞä
    } elsif ($pls == 9) {   #«Û«Æ«ëîæ
    } elsif ($pls == 10) {  #ß£ä¿ò¢?
        $log = ($log . "ÀÌ·±, Åä»ç°¡ ½ñ¾ÆÁ³´Ù!<BR>") ;
        if ($dice == 18) {
            $log = ($log . "°£½ÅÈ÷ ÇÇÇßÁö¸¸, ³«¼®¿¡ ¹ßÀ» ´ÙÃÆ´Ù!<BR>") ;
            $inf =~ s/ðë//g ;
            $inf = ($inf . "ðë") ;
        } elsif ($dice == 19) {
            $log = ($log . "³«¼®¿¡ ÀÇÇØ, <font color=\"red\"><b>$dice2µ¥¹ÌÁö</b></font> À»(¸¦) ÀÔ¾ú´Ù!<BR>") ;
            $hit-=$dice2;
            if ($hit <= 0) {
                $hit = $mhit = 0;
                $log = ($log . "<font color=\"red\"><b>$f_name $l_name£¨$cl $sex$no¹ø£©Àº(´Â) »ç¸ÁÇß´Ù.</b></font><br>") ;

                #ÞÝØÌ«í«°
                &LOGSAVE("DEATH") ;
                $Command = "EVENT";
            }
        } else {
            $log = ($log . "ÈÄ¿ì, °£½ÅÈ÷ ÇÇÇß´Ù...<BR>") ;
        }
        $chksts="OK";
    } elsif ($pls == 11) {  #«È«ó«Í«ë
    } elsif ($pls == 13) {  #Ùí?ÞÑ
    } elsif ($pls == 14) {  #ÝÂÎèîæ
    } elsif ($pls == 15) {  #ëíå¯ãêÞä
    } elsif ($pls == 16) {  #ßµ×ùò¢?
        $log = ($log . "°©ÀÚ±â, µé°³°¡ ½À°ÝÇØ ¿Ô´Ù!<BR>") ;
        if ($dice == 18) {
            $log = ($log . "ÆÈÀ» ¹°·Á, ÆÈÀ» ´ÙÃÆ´Ù!<BR>") ;
            $inf =~ s/èÓ//g ;
            $inf = ($inf . "èÓ") ;
        } elsif ($dice == 19) {
            $log = ($log . "µé°³¿¡°Ô ½À°Ý¹Þ¾Æ, <font color=\"red\"><b>$dice2µ¥¹ÌÁö</b></font> À»(¸¦) ÀÔ¾ú´Ù!<BR>") ;
            $hit-=$dice2;
            if ($hit <= 0) {
                $hit = $mhit = 0;
                $log = ($log . "<font color=\"red\"><b>$f_name $l_name£¨$cl $sex$no¹ø£©Àº(´Â) »ç¸ÁÇß´Ù.</b></font><br>") ;

                #ÞÝØÌ«í«°
                &LOGSAVE("DEATH") ;
                $Command = "EVENT";
            }
        } else {
            $log = ($log . "ÈÄ¿ì, °£½ÅÈ÷ ÂÑ¾Æ³Â´Ù...<BR>") ;
        }
        $chksts="OK";
    } elsif ($pls == 17) {  #ê¹çé?ò®
        $log = ($log . "ÀÌ·±, ¹ßÀÌ ¹Ì²ø¾îÁø´Ù!<BR>") ;
        if ($dice <= 18) {
            $dice2 += 10;
            $log = ($log . "¿¬¸ø ¾ÈÀ¸·Î ¶³¾îÁ³Áö¸¸, °£½ÅÈ÷ ±â¾î ¿Ã¶ó¿Ô´Ù!<BR>½ºÅ×¹Ì³Ê¸¦ <font color=\"red\"><b>$dice2Æ÷ÀÎÆ®</b></font> ¼ÒºñÇß´Ù!<BR>") ;
            $sta-=$dice2;
            if ($sta <= 0) {    #«¹«¿«ß«Êï·ªì£¿
                &DRAIN("eve");
            }
        } else {
            $log = ($log . "ÈÄ¿ì, °£½ÅÈ÷ ¹Ì²ø¾îÁöÁö ¾Ê¾Ò´Ù...<BR>") ;
        }
        $chksts="OK";
    } elsif ($pls == 19) {  #òàÖûá¶
    } elsif ($pls == 20) {  #?÷»
    } elsif ($pls == 21) {  #ÑõªÎË¢
    }
}

1
