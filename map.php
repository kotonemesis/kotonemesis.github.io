<?php
require "pref.php";

$userlist = @file($pref['user_file']) or ERROR("unable to open user_file","","MAP",__FUNCTION__,__LINE__);
$pref['arealist'] = @file($pref['area_file']) or ERROR("unable to open area_file","","MAP",__FUNCTION__,__LINE__);
list($ar,$a) = explode(",",$pref['arealist'][1]);

list($ar,$hackflg,$a) = explode(",",$pref['arealist'][1]);
list($ara[0],$ara[1],$ara[2],$ara[3],$ara[4],$ara[5],$ara[6],$ara[7],$ara[8],$ara[9],$ara[10],$ara[11],$ara[12],$ara[13],$ara[14],$ara[15],$ara[16],$ara[17],$ara[18],$ara[19],$ara[20],$ara[21]) = explode(",",$pref['arealist'][4]);

for ($j=0; $j<count($pref['area']); $j++) {$mem[$j] = "<A onmouseover=\"status='".$pref['place'][$j]." [".$pref['area'][$j]."]';return true;\" href=\"javascript:void(0)\"><IMG src=\"$map/blank.gif\" width=\"46\" height=\"46\" border=0></A></TD>" ;}

if ($hackflg == 0) {
	for ($j=0; $j<$ar; $j++) {$mem[$ara[$j]] = "<A onmouseover=\"status='".$pref['place'][$ara[$j]]." [".$pref['area'][$ara[$j]]."] (금지 에리어)';return true;\" href=\"javascript:void(0)\"><IMG src=\"$map/danger.gif\" width=\"48\" height=\"48\" border=0></A></TD>";}
	$mem[$ara[$j]] = "<A onmouseover=\"status='".$pref['place'][$ara[$j]]." [".$pref['area'][$ara[$j]]."] (다음 번 금지 에리어)';return true;\" href=\"javascript:void(0)\"><IMG src=\"$map/caution.gif\" width=\"48\" height=\"48\" border=0></A></TD>";
}
#DEF MAP
$FLOW = "<TD width=\"49\" height=\"49\" class=b1 align=middle>";
$ETD = "</TD>";
$OCEAN = "<TD width=\"49\" height=\"49\" class=b3 align=middle background=$map/ocean.gif><A onmouseover=\"status='해';return true;\" href=\"javascript:void(0)\"><IMG src=\"$map/blank.gif\" width=\"46\" height=\"46\" border=0></A></TD>";
$OCEAN2 = "<A onmouseover=\"status='해안';return true;\" href=\"javascript:void(0)\"><IMG src=\"$map/blank.gif\" width=\"46\" height=\"46\" border=0></A></TD>";
$OCEAN3 = "<A onmouseover=\"status='해';return true;\" href=\"javascript:void(0)\"><IMG src=\"$map/blank.gif\" width=\"46\" height=\"46\" border=0></A></TD>";
$GLASS = "<TD width=\"49\" height=\"49\" class=b3 align=middle background=$map/40.gif><A onmouseover=\"status='평야';return true;\" href=\"javascript:void(0)\"><IMG src=\"$map/blank.gif\" width=\"46\" height=\"46\" border=0></A></TD>";
$GLASS2 = "<A onmouseover=\"status='해안';return true;\" href=\"javascript:void(0)\"><IMG src=\"$map/blank.gif\" width=\"46\" height=\"46\" border=0></A></TD>";
$MAPTD = "<TD width=\"49\" height=\"49\" class=b3 align=middle background=$map";

HEAD();

print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">회장 간이 지도</span></font></center>
<TABLE border="1" width="539" height="539" cellspacing="0" cellpadding="0">
	<TR bgcolor="#cccccc">$FLOW<B><a href="index.php">HOME</A><IMG src="$map/blank.gif" height="1%"></B>$ETD$FLOW<B>1</B>$ETD$FLOW<B>2</B>$ETD$FLOW<B>3</B>$ETD$FLOW<B>4</B>$ETD$FLOW<B>5</B>$ETD$FLOW<B>6</B>$ETD$FLOW<B>7</B>$ETD$FLOW<B>8</B>$ETD$FLOW<B>9</B>$ETD$FLOW<B>10</B>$ETD</TR>
	<TR>
	$FLOW<B>A</B>$ETD
	$OCEAN
	$MAPTD/01.gif>$mem[1]
	$OCEAN
	$OCEAN
	$OCEAN
	$OCEAN
	$OCEAN
	$MAPTD/41.gif>$OCEAN3
	$MAPTD/42.gif>$OCEAN3
	$MAPTD/43.gif>$OCEAN3
	</TR>
  <TR align=middle>
	$FLOW<B>B</B>$ETD
	$OCEAN
	$MAPTD/02.gif>$GLASS2
	$MAPTD/03.gif>$GLASS2
	$MAPTD/04.gif>$mem[2]
	$MAPTD/05.gif>$GLASS2
	$OCEAN
	$MAPTD/44.gif>$OCEAN3
	$MAPTD/45.gif>$OCEAN3
	$MAPTD/46.gif>$OCEAN3
	$MAPTD/47.gif>$OCEAN3
  <TR align=middle>
	$FLOW<B>C</B>$ETD
	$MAPTD/06.gif>$OCEAN2
	$MAPTD/07.gif>$OCEAN2
	$MAPTD/yakuba.gif>$mem[3]
	$MAPTD/po.gif>$mem[4]
	$MAPTD/fd.gif>$mem[5]
	$MAPTD/09.gif>$mem[6]
	$MAPTD/10.gif>$GLASS2
	$MAPTD/48.gif>$OCEAN3
	$MAPTD/49.gif>$OCEAN3
	$OCEAN
  <TR align=middle>
	$FLOW<B>D</B>$ETD
	$MAPTD/11.gif>$GLASS2
	$MAPTD/40.gif>$GLASS2
	$GLASS
	$MAPTD/pond.gif>$mem[7]
	$GLASS
	$MAPTD/kousya.gif>$mem[0]
	$MAPTD/12.gif>$GLASS2
	$MAPTD/13.gif>$GLASS2
	$OCEAN
	$OCEAN
  <TR align=middle>
	$FLOW<B>E</B>$ETD
	$MAPTD/14.gif>$GLASS2
	$MAPTD/40.gif>$mem[8]
	$GLASS
	$MAPTD/40.gif>$mem[9]
	$MAPTD/mtn1.gif>$mem[10]
	$MAPTD/mtn2.gif>$mem[10]
	$MAPTD/mtn3.gif>$mem[10]
	$MAPTD/15.gif>$mem[11]
	$MAPTD/16.gif>$OCEAN2
	$OCEAN
  <TR align=middle>
	$FLOW<B>F</B>$ETD
	$MAPTD/17.gif>$GLASS2
	$GLASS
	$MAPTD/jyu-taku.gif>$mem[12]
	$GLASS
	$MAPTD/mtn4.gif>$mem[10]
	$MAPTD/mtn5.gif>$mem[10]
	$MAPTD/mtn6.gif>$mem[10]
	$GLASS
	$MAPTD/18.gif>$mem[13]
	$OCEAN
  <TR align=middle>
	$FLOW<B>G</B>$ETD
	$MAPTD/19.gif>$OCEAN2
	$MAPTD/20.gif>$GLASS2
	$MAPTD/kousya.gif>$mem[14]
	$GLASS
	$MAPTD/mtn7.gif>$mem[10]
	$MAPTD/mtn8.gif>$mem[15]
	$MAPTD/mtn9.gif>$mem[10]
	$GLASS
	$MAPTD/21.gif>$GLASS2
	$OCEAN
  <TR align=middle>
	$FLOW<B>H</B>$ETD
	$MAPTD/22.gif>$OCEAN2
	$MAPTD/23.gif>$OCEAN2
	$MAPTD/24.gif>$GLASS2
	$MAPTD/40.gif>$mem[16]
	$MAPTD/40.gif>$mem[16]
	$MAPTD/pond.gif>$mem[17]
	$MAPTD/40.gif>$GLASS2
	$MAPTD/40.gif>$GLASS2
	$MAPTD/25.gif>$GLASS2
	$MAPTD/26.gif>$OCEAN2
  <TR align=middle>
	$FLOW<B>I</B>$ETD
	$OCEAN
	$MAPTD/27.gif>$OCEAN2
	$MAPTD/28.gif>$OCEAN2
	$MAPTD/29.gif>$GLASS2
	$MAPTD/30.gif>$GLASS2
	$MAPTD/31.gif>$mem[18]
	$MAPTD/32.gif>$mem[19]
	$MAPTD/33.gif>$OCEAN2
	$MAPTD/34.gif>$GLASS2
	$MAPTD/35.gif>$mem[20]
  <TR align=middle>
	$FLOW<B>J</B>$ETD
	$OCEAN
	$OCEAN
	$OCEAN
	$OCEAN
	$MAPTD/36.gif>$OCEAN2
	$MAPTD/37.gif>$mem[21]
	$MAPTD/38.gif>$OCEAN2
	$OCEAN
	$OCEAN
	$OCEAN
</TABLE>
</CENTER>
_HERE_;

FOOTER();
UNLOCK();

exit;