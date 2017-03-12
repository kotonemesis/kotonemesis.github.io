<?php
require 'pref.php';
require_once $pref['LIB_DIR'].'/lib4.php';

$ar = explode(',',$pref['arealist'][4]);

$ars = '<BR><font color="lime"><B>Current Danger Zones:</B></FONT>';
for($i=0; $i<$pref['arealist'][1];$i++){$ars .= '&nbsp;'.$pref['place'][$ar[$i]];}

#CONF
$pgsplit = 8;

$kinshi0 = $hh;
$kinshi1 = $hh + $pgsplit;
$kinshi2 = $hh + $pgsplit + $pgsplit;

if($kinshi0 < 10){$kinshi0 = '0'.$kinshi0;}
if($kinshi1 >= 24){$kinshi1 -= 24;}
if($kinshi2 >= 24){$kinshi2 -= 24;}
if($kinshi1 < 10){$kinshi1 = '0'.$kinshi1;}
if($kinshi2 < 10){$kinshi2 = '0'.$kinshi2;}

$kinshi = array($kinshi0,$kinshi1,$kinshi2);

if(isset($pref['place'][$ar[$i]])){
	$ars .= '<BR><font color="lime"><B>Next Danger Zones</B></FONT> <B>'.$kinshi[0].':00</B> '.$pref['place'][$ar[$i]];
	if(isset($pref['place'][$ar[$i+1]])){
		$ars .= ' <B>'.$kinshi[1].':00</B> '.$pref['place'][$ar[$i+1]];
		if(isset($pref['place'][$ar[$i+2]])){
			$ars .= ' <B>'.$kinshi[2].':00</B> '.$pref['place'][$ar[$i+2]];
		}
	}else{
		$ars .= '</b></font>.';
	}
}

$log = news($pref['log_file'],$ar);

HEAD();
print '</center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9);font-weight:700;text-decoration:underline;">Progress</span></font></center>';
print '<TABLE border="0" cellspacing="0" cellpadding="0"><TR><TD><img border="0" src="'.$pref['imgurl'].'/i_sakamochi.jpg" width="70" height="70"></TD><TD>「Everyone is fine now, so... <BR>This is current statistics.<BR>Keep up your great job!-―.」</TD></TR></TABLE>';
print $ars;
print $log;
print '</UL><center><B><a href="index.php">HOME</A></B><BR>';

FOOTER();
UNLOCK();

exit;
?>