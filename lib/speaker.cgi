#=====================#
# ■ 携?スピ?カ使用 #
#=====================#
sub SPEAKER {

$log = ($log . " $speech<BR>");
$log = ($log . " 확실히 전해졌을까?<BR>");
open(DB,"$gun_log_file");seek(DB,0,0); @gunlog=<DB>;close(DB);
$namae = "$f_name $l_name" ;
$gunlog[2] = "$now,$place[$pls],$namae,$speech,\n";
open(DB,">$gun_log_file"); seek(DB,0,0); print DB @gunlog; close(DB);

#뉴스 파일에 저장
$newlog = "$now,$f_name,$l_name,,,,,,,,,SPEAKER,$speech,,,,\n";
open(DB,"$log_file") || exit; seek(DB,0,0); @loglist=<DB>; close(DB);
unshift(@loglist,$newlog);
open(DB,">$log_file"); seek(DB,0,0); print DB @loglist; close(DB);

$Command = "MAIN" ;

}
1
