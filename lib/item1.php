<?
#□■□■□■□■□■□■□■□■□■□■□
#■ 	  -    BR ITEM SCRIPT    -  	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ ITEMGET		-	아이템 취득		 ■
#□ ITEMNEWXCG	-	아이템 교환		 □
#■ ITEMDELNEW	-	아이템을 버린다	 ■
#□ ITEMGETNEW	-	아이템을 줍는다		 □
#■ ITEMDEL		-	아이템 투기		 ■
#■ ITEM		-	아이템 사용		 ■
#□ omikuji1	-	제비 랜덤		 □
#■ omikuji2	-	제비 랜덤		 ■
#□ WEPDEL		-	장비 무기를 벗는 처리	 □
#■ WEPDEL2		-	장비 무기 투기		 ■
#□ BOUDELH		-	두 방어구를 벗는 처리	 □
#■ BOUDELB		-	체 방어구를 벗는 처리	 ■
#□ BOUDELA		-	팔방어구를 벗는 처리	 □
#■ BOUDELF		-	다리 방어구를 벗는 처리	 ■
#□ BOUDEL		-	장식품을 제외하는 처리	 □
#■□■□■□■□■□■□■□■□■□■□■
#=================#
# ■ 아이템 취득 #
#=================#
function ITEMGET(){
global $in,$pref;

global $chksts,$pls,$item,$eff,$itai,$log,$item_get,$eff_get,$itai_get;
$i = 0;
$chkflg = 0;
$function = '';

$filename = $pref['LOG_DIR'].'/'.$pls.$pref['item_file'];

$itemlist = @file($filename);
if(count($itemlist) <= 0){
	$in['Command'] = 'MAIN';
	$log = ($log . "이제(벌써), 이 에리어에는 아무것도 없는 것인지…?<BR>");
	$chksts = 'OK';
	return;
}else{
	$work = rand(0,count($itemlist)-1);#취득 아이템 랜덤
	list($getitem,$geteff,$gettai) = explode(",",$itemlist[$work]);#취득 아이템 정보 취득
	list($itname,$itkind) = explode("<>",$getitem);#취득 아이템 분할
	$delitem = array_splice($itemlist,$work,1);#취득 아이템 삭제
	$handle = @fopen($filename,'w') or ERROR("unable to open filename","","ITEM1",__FUNCTION__,__LINE__);
	@fwrite($handle,implode('',$itemlist));#){ERROR("unable to write filename","","ITEM1",__FUNCTION__,__LINE__);}
	fclose($handle);

	if(preg_match("/<>TO/",$getitem)){#함정
		global $hit,$f_name,$l_name,$cl,$sex,$no;
		$result = round(rand(0,$geteff/2)+($geteff/2));
		$log = ($log . "함정이다!설치되고 있던 {$itname} 로 상처를 두어<BR>　<font color=\"red\"><b>{$result}의 데미지</b></font>를 받았다!.<BR>");
		$hit-=$result;
		if($hit <= 0){#사망 로그
			$hit = 0;
			$log = ($log . "<font color=\"red\"><b>{$f_name} {$l_name}({$cl} {$sex}{$no}차례)는 사망했다.</b></font><br>");
			LOGSAVE("DEATH");
			$mem--;
			if($mem == 1){LOGSAVE("END");}
		}
		return;
	}#↓아이템 취득 코멘트 Log
	elseif(preg_match("/<>HH|<>HD/",$getitem))	{$function = "입에 대면 체력을 회복 할 수 있을 것 같다.";}
	elseif(preg_match("/<>SH|<>SD/",$getitem))	{$function = "입에 대면 스태미너를 회복 할 수 있을 것 같다.";}
	elseif(preg_match("/<>W/",$getitem))		{$function = "이 녀석은 무기가 될 것 같다.";}#무기
	elseif(preg_match("/<>D/",$getitem))		{$function = "이 녀석은 방어구에 할 수 있을 것 같다.";}#방어구
	elseif(preg_match("/<>A/",$getitem))		{$function = "이 녀석은 몸에 걸칠 수 있을 것 같다.";}#장식
	elseif(preg_match("/<>TN/",$getitem))		{$function = "이것으로 함정을 걸 수가 있을 것 같다.";}#함정
	else										{$function = "반드시 무언가에 사용할 수 있을 것이다.";}

	list($itname,$kind) = explode("<>",$getitem);
	if(preg_match("/HH|HD/",$kind)){$itemtype = "【체력 회복】";}
	elseif(preg_match("/SH|SD/",$kind)){$itemtype = "【스태미너 회복】";}
	elseif($kind == "TN")		{$itemtype = "【함정】";}
	elseif(preg_match("/W/",$kind))	{$itemtype = "【무기：";
		if(preg_match("/G/",$kind))	{$itemtype = ($itemtype . "총");}
		if(preg_match("/K/",$kind))	{$itemtype = ($itemtype . "참");}
		if(preg_match("/C/",$kind))	{$itemtype = ($itemtype . "투");}
		if(preg_match("/B/",$kind))	{$itemtype = ($itemtype . "구");}
		if(preg_match("/D/",$kind))	{$itemtype = ($itemtype . "폭");}
		$itemtype = ($itemtype . "】");}
	elseif(preg_match("/D/",$kind))	{$itemtype = "【방어구：";
		if(preg_match("/B/",$kind))	{$itemtype = ($itemtype . "몸");}
		if(preg_match("/H/",$kind))	{$itemtype = ($itemtype . "머리");}
		if(preg_match("/F/",$kind))	{$itemtype = ($itemtype . "다리");}
		if(preg_match("/A/",$kind))	{$itemtype = ($itemtype . "팔");}
		$itemtype = ($itemtype . "】");}
	elseif(($kind == "R1")||($kind == "R2")){$itemtype = "【레이더-】";}
	elseif($kind == "Y"){
		if(($itname == "가짜 프로그램 해제 키")||($itname == "프로그램 해제 키")){$itemtype = "【해제 키】";}
		elseif($itname == "탄환"){$itemtype = "【탄】";}
		else{$itemtype = "【도구】";}}
	elseif($kind == "A"){$itemtype = "【장식품】";}
	else{$itemtype = "【불명】";}

	$log = ($log . "{$itname}(효과:{$geteff}수:{$gettai})<font color=\"00ffff\">{$itemtype}</font>를 발견했다.<br>$function<BR>");

	$chkflg = 0;
	for ($i=0;$i<5;$i++){#동일 아이템 판단
		if($item[$i] == $getitem){
			if(preg_match("/탄환/",$item[$i])){
				$eff[$i] += $geteff;
				$chkflg = 1;
				break;
			}elseif(preg_match("/제비|숫돌|못\<|해독제|재봉 도구|배터리/",$item[$i])){#효과 1수 X
				$itai[$i] *= $eff[$i];
				$gettai *= $geteff;
				$eff[$i] = 1;
				$itai[$i] += $gettai;
				$chkflg = 1;
				break;
			#}elseif(preg_match("/<>WC|<>WD|<>TN|제비|숫돌|못|해독제|재봉 도구|배터리/",$item[$i])){
			#	$chkflg = 0;
			#	break;
			}elseif($eff[$i] == $geteff && preg_match("/물|빵/",$item[$i])){
				$in['Command2'] = "SAME_ITEM";
				break;
			}
		}
	}

	if(!$chkflg){
		$in['Command'] = "ITMAIN";
		$in['Command3'] = "GET";
		$item_get = $getitem;$eff_get = $geteff;$itai_get = $gettai;
	}
}
SAVE();
$chksts="OK";
}
#=================#
# ■ 아이템 교환 #
#=================#
function ITEMNEWXCG(){
global $in,$pref;

global $item,$eff,$itai,$item_get,$eff_get,$itai_get,$log,$pls;
$wk = $in['Command'];
$wk = str_replace ('ITEMNEWXCG_','',$wk);

if(($item[$wk] == "없음")||($item_get == "없음") ){ERROR("부정한 액세스입니다.","","ITEM1",__FUNCTION__,__LINE__);}
list($itn, $ik) = explode("<>",$item_get);
list($itn2, $ik2) = explode("<>",$item[$wk]);

$log = ($log . "{$itn}를 주워,{$itn2}를 버렸다.<br>");

$filename = $pref['LOG_DIR'].'/'.$pls.$pref['item_file'];

$itemlist = @file($filename);
array_push($itemlist,"$item[$wk],$eff[$wk],$itai[$wk],\n");
$handle = @fopen($filename,'w') or ERROR("unable to open filename","","ITEM1",__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$itemlist))){ERROR("unable to write filename","","ITEM1",__FUNCTION__,__LINE__);}
fclose($handle);

$item[$wk] = $item_get;
$eff[$wk] = $eff_get;
$itai[$wk] = $itai_get;

$item_get = "없음";$eff_get = 0;$itai_get = 0;
$in['Command'] = "MAIN";

SAVE();
}
#=================#
# ■ 아이템 정리 #
#=================#
function ITEMSEINEW(){
global $in;

global $log,$item,$eff,$itai,$item_get,$eff_get,$itai_get;

$wk = $in['Command'];
$wk = str_replace ('ITEMSEINEW_','',$wk);

list($itn, $ik) = explode("<>",$item[$wk]);

list($itn2,$ik2) = explode("<>",$item_get);
$ik3 = '';

if(($item[$wk] == "없음")||($item_get == "없음") ){
	ERROR("부정한 액세스입니다.","","ITEM1",__FUNCTION__,__LINE__);
}

$log = ($log . "아이템을 정리합니다.<br>");

if(($itn == $itn2)&&($eff[$wk] == $eff_get)&&(preg_match("/HH|HD/",$ik))&&(preg_match("/HH|HD/",$ik2))){#체력 회복 아이템 정리
	$itai[$wk] = $itai[$wk] + $itai_get;
	if		(($ik == "HD2")||($ik2 == "HD2"))	{$ik3 = "HD2";}
	elseif	(($ik == "HD1")||($ik2 == "HD1"))	{$ik3 = "HD1";}
	elseif	(($ik == "HH")||($ik2 == "HH"))		{$ik3 = "HH";}
	$item[$wk] = "$itn<>$ik3";
	$item_get = "없음";$eff_get = 0;$itai_get = 0;
	$log = ($log . "{$itn}를 모았습니다.<br>");
}elseif(($itn == $itn2)&&($eff[$wk] == $eff_get)&&(preg_match("/SH|SD/",$ik))&&(preg_match("/SH|SD/",$ik2))){#스태미너 회복 아이템 정리
		$itai[$wk] = $itai[$wk] + $itai_get;
	if		(($ik == "SD2")||($ik2 == "SD2"))	{$ik3 = "SD2";}
	elseif	(($ik == "SD1")||($ik2 == "SD1"))	{$ik3 = "SD1";}
	elseif	(($ik == "SH")||($ik2 == "SH"))		{$ik3 = "SH";}
	$item[$wk] = "$itn<>$ik3";
	$item_get = "없음";$eff_get = 0;$itai_get = 0;
	$log = ($log . "{$itn}를 모았습니다.<br>");
}else{#다른 아이템·모을 수 없는 것선택
	ERROR("부정한 액세스입니다.","","ITEM1",__FUNCTION__,__LINE__);
}

$in['Command'] = "MAIN";
$in['Command2'] = "";

SAVE();

}
#=====================#
# ■ 아이템을 버린다 #
#=====================#
function ITEMDELNEW(){
global $in,$pref;

global $item_get,$eff_get,$itai_get,$log,$pls;
if(($item_get == "없음")||($item_get == "")){$log = ($log . "줍는 것을 포기했다.<br>");
}elseif(($eff_get != 0)||($itai_get != 0)){
	list($itn, $ik) = explode("<>",$item_get);
	if($ik != ""){
		if($itn['Command'] == "ITEMDELNEW"){$log = ($log . "{$itn}를 줍는 것을 포기했다.<br>");}#아이템의 서두
		$filename = $pref['LOG_DIR'].'/'.$pls.$pref['item_file'];
		$itemlist = @file($filename);
		if($itemlist == ''){$itemlist = array();}
		array_push($itemlist,"$item_get,$eff_get,$itai_get,\n");
		$handle = @fopen($filename,'w') or ERROR("unable to open filename","","ITEM1",__FUNCTION__,__LINE__);
		if(!@fwrite($handle,implode('',$itemlist))){ERROR("unable to write filename","","ITEM1",__FUNCTION__,__LINE__);}
		fclose($handle);
	}
}
$item_get = "없음";$eff_get = 0;$itai_get = 0;
$in['Command'] = "MAIN";

SAVE();
}
#===================#
# ■ 아이템을 줍는다 #
#===================#
function ITEMGETNEW(){
global $in;

global $item_get,$item,$log,$itname,$eff_get,$itai_get,$eff,$itai,$sub;
if($item_get == "없음"){ERROR("부정한 액세스입니다.","NO NEW TITEM","ITEM1",__FUNCTION__,__LINE__);}
$chkflg = -1;
for ($i=0;$i<5;$i++){if($item[$i] == "없음"){$chkflg = $i;break;}}#빈아이템?
if($chkflg == -1){$log = ($log . "그러나, 더 이상가방에 들어가지 않는다.<BR>{$itname}를 포기했다….<BR>");}#소지품 오버
else{
	if($item[$chkflg] == "없음"){$item[$chkflg] = $item_get;$eff[$chkflg] = $eff_get;$itai[$chkflg] = $itai_get;}
	list($itname,$kind) = explode("<>",$item_get);
	$log = ($log . "{$itname}를 주웠다.$sub<BR>");
}

$item_get = "없음";$eff_get = 0;$itai_get = 0;
$in['Command'] = "MAIN";

SAVE();

}
#=================#
# ■ 아이템 투기 #
#=================#
function ITEMDEL(){
global $in,$pref;

global $item,$log,$pls,$eff,$itai;

$wk = $in['Command'];
//$wk =~ s/DEL_//g;
$wk = str_replace('DEL_','',$wk);

if($item[$wk] == "없음"){ERROR("부정한 액세스입니다.","","ITEM1",__FUNCTION__,__LINE__);}

list($itn, $ik) = explode("<>",$item[$wk]);

$log = ($log . "{$itn}를 버렸다.<br>");

$filename = $pref['LOG_DIR'].'/'.$pls.$pref['item_file'];
$itemlist = @file($filename);
array_push($itemlist,"$item[$wk],$eff[$wk],$itai[$wk],\n");
$handle = @fopen($filename,'w') or ERROR("unable to open filename","","ITEM1",__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$itemlist))){ERROR("unable to write filename","","ITEM1",__FUNCTION__,__LINE__);}
fclose($handle);

$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;
$in['Command'] = "MAIN";

SAVE();

}
#=================#
# ■ 아이템 사용 #
#=================#
function ITEM(){
global $in,$pref;

global $item,$wep,$bou,$log,$eff,$itai,$inf,$wk;
$result = 0;$wep2 = '';$watt2 = 0;$wtai2 = 0;$up = 0;

$wk = $in['Command'];
$wk = str_replace ('ITEM_','',$wk);

if($item[$wk] == "없음"){ERROR("부정한 액세스입니다.","","ITEM1",__FUNCTION__,__LINE__);}

list($itn,$ik) = explode("<>",$item[$wk]);
list($w_name,$w_kind) = explode("<>",$wep);
list($d_name,$d_kind) = explode("<>",$bou);

if(preg_match("/<>SH/",$item[$wk])){#스태미너 회복
	global $sta;
	if(($pref['maxsta'] - $sta) > 0){
		$old_sta = $sta;
		$sta += $eff[$wk];
		if($sta > $pref['maxsta']){$sta = $pref['maxsta'];}
		$work = $sta - $old_sta;
		$log = ($log . "{$itn}를 사용했다.<BR>스태미너가 {$work} 회복했다<BR>");
		$itai[$wk] --;
		if($itai[$wk] == 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
	}else{
		$log = ($log . "{$itn}를 사용해도 의미가 없다<BR>");
	}
}elseif(preg_match("/<>HH/",$item[$wk])){#체력 회복
	global $hit,$mhit;
	if(($mhit - $hit) > 0){
		$old_hit = $hit;
		$hit += $eff[$wk];
		if($hit > $mhit){$hit = $mhit;}
		$work = $hit - $old_hit;
		$log = ($log . "{$itn}를 사용했다.<BR>체력이 {$work} 회복했다<BR>");
		$itai[$wk] --;
		if($itai[$wk] == 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
	}else{
		$log = ($log . "{$itn}를 사용해도 의미가 없다<BR>");
	}
}elseif($itn == "독약"){#해독
	$in['Command'] = "SPECIAL";
	$in['Command4'] = "POISON";
	return;
}elseif($itn == "해독제"){#해독
	if(preg_match("/독/",$inf)){$log = ($log . "{$itn}를 사용했다.<BR>독이 나았다<BR>");
		$inf = str_replace ('독','',$inf);
		$itai[$wk] --;
		if($itai[$wk] == 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
	}else{$log = ($log . "{$itn}를 사용해도 의미가 없다<BR>");}
}elseif(preg_match("/<>SD|<>HD/",$item[$wk])){	#독들이
	global $hit;
	if	 (preg_match("/<>SD2|<>HD2/",$item[$wk])){$result = round($eff[$wk]*2);}#요리 연구부 특제?
	elseif(preg_match("/<>SD1|<>HD1/",$item[$wk])){$result = round($eff[$wk]*1.5);}#능력자
	else{$result = $eff[$wk];}
	$inf = str_replace ('독','',$inf);
	$inf = ($inf . "독");
	$hit -= $result;
	$log = ($log . "…끝냈다!<BR>아무래도, 독물이 혼입되어서 손상되고 싶은이다!<BR><font color=\"red\"><b>{$result}데미지</b></font>!<BR>\n");
	$itai[$wk]--;
	if(preg_match('/-/',$item[$wk])){
		list($tp,$poisonid) = explode('-', $item[$wk]);
		$wb = $poisonid;
	}
	$poisoni = $item[$wk];
	if($itai[$wk] == 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
	$poisondeadchk = 1;
	if($hit <= 0){require $pref['LIB_DIR']."/lib3.php";POISONDEAD();}
}elseif((preg_match("/<>W/",$item[$wk]))&&(!preg_match("/<>WF/",$item[$wk]))){ #무기 장비
	global $watt,$wtai;
	$log = ($log . "{$itn}를 장비했다.<BR>");
	$wep2 = $wep;$watt2 = $watt;$wtai2 = $wtai;
	$wep = $item[$wk];$watt = $eff[$wk];$wtai = $itai[$wk];
	if(!preg_match("/맨손/",$wep2)){$item[$wk] = $wep2;$eff[$wk] = $watt2;$itai[$wk] = $wtai2;}
	else{$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif(preg_match("/<>DB/",$item[$wk])){#방어구 장비(몸)
	global $bou,$bdef,$btai;
	$log = ($log . "{$itn}를 몸에 장비했다.<BR>");
	$bou2 = $bou;$bdef2 = $bdef;$btai2 = $btai;
	$bou = $item[$wk];$bdef = $eff[$wk];$btai = $itai[$wk];
	if(!preg_match("/속옷/",$bou2)){$item[$wk] = $bou2;$eff[$wk] = $bdef2;$itai[$wk] = $btai2;}
	else{$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif(preg_match("/<>DH/",$item[$wk])){#방어구 장비(머리)
	global $bou_h,$bdef_h,$btai_h;
	$log = ($log . "{$itn}를 머리에 장비했다.<BR>");
	$bou2 = $bou_h;$bdef2 = $bdef_h;$btai2 = $btai_h;
	$bou_h = $item[$wk];$bdef_h = $eff[$wk];$btai_h = $itai[$wk];
	if(!preg_match("/없음/",$bou2)){$item[$wk] = $bou2;$eff[$wk] = $bdef2;$itai[$wk] = $btai2;}
	else{$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif(preg_match("/<>DF/",$item[$wk])){#방어구 장비(다리)
	global $bou_f,$bdef_f,$btai_f;
	$log = ($log . "{$itn}를 다리에 장비했다.<BR>");
	$bou2 = $bou_f;$bdef2 = $bdef_f;$btai2 = $btai_f;
	$bou_f = $item[$wk];$bdef_f = $eff[$wk];$btai_f = $itai[$wk];
	if(!preg_match("/없음/",$bou2)){$item[$wk] = $bou2;$eff[$wk] = $bdef2;$itai[$wk] = $btai2;}
	else{$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif(preg_match("/<>DA/",$item[$wk])){#방어구 장비(팔)
	global $bou_a,$bdef_a,$btai_a;
	$log = ($log . "{$itn}를 팔에 장비했다.<BR>");
	$bou2 = $bou_a;$bdef2 = $bdef_a;$btai2 = $btai_a;
	$bou_a = $item[$wk];$bdef_a = $eff[$wk];$btai_a = $itai[$wk];
	if(!preg_match("/없음/",$bou2)){$item[$wk] = $bou2;$eff[$wk] = $bdef2;$itai[$wk] = $btai2;}
	else{$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif(preg_match("/<>A/",$item[$wk])){ #악세사리 장비
	$log = ($log . "$itn를 몸에 걸쳤다.<BR>");
	$bou2 = $item[5];$bdef2 = $eff[5];$btai2 = $itai[5];
	$item[5] = $item[$wk];$eff[5] = $eff[$wk];$itai[5] = $itai[$wk];
	if(!preg_match("/없음/",$bou2)){$item[$wk] = $bou2;$eff[$wk] = $bdef2;$itai[$wk] = $btai2;}
	else{$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif(preg_match("/<>R/",$item[$wk])){ #레이더-
	HEAD() ;require $pref['LIB_DIR']."/dsp.php";READER() ;FOOTER() ;exit();
}elseif(preg_match("/<>TN/",$item[$wk])){#함정
	global $pls;
	$log = ($log . "{$itn}를 함정으로서 걸었다.<BR>자신도 주의하지 않으면….<BR>");
	$item[$wk] = preg_replace("/TN/","TO",$item[$wk]);
	$filename = $pref['LOG_DIR'].'/'.$pls.$pref['item_file'];
	$itemlist = @file($filename);
	array_push($itemlist,"$item[$wk],$eff[$wk],$itai[$wk],\n");
	$handle = @fopen($filename,'w') or ERROR("unable to open filename","","ITEM1",__FUNCTION__,__LINE__);
	if(!@fwrite($handle,implode('',$itemlist))){ERROR("unable to write filename","","ITEM1",__FUNCTION__,__LINE__);}
	fclose($handle);
	$itai[$wk] --;
	$item[$wk] = preg_replace("/TN/","TO",$item[$wk]);
	if($itai[$wk] <= 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif(($itn == "숫돌")&&(preg_match("/<>WK/",$wep))){#숫돌 사용＆나이프계 장비?
	global $watt;
	$watt += (rand(0,2) + $eff[$wk]);
	$log = ($log . "{$itn}를 사용했다.<BR>{$w_name}의 공격력이 {$watt} 가 되었다.<BR>");
	$itai[$wk] --;
	if($itai[$wk] <= 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif(($itn == "못")&&(preg_match("/버트<>WB/",$wep))){#버트 사용시
	global $watt;
	$watt += (rand(0,2) + $eff[$wk]);
	$wep = "못버트<>WB";
	$log = ($log . "{$itn}를 사용했다.<BR>{$w_name}의 공격력이 {$watt} 가 되었다.<BR>");
	$itai[$wk] --;
	if($itai[$wk] <= 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif(($itn == "재봉 도구")&&($d_kind == "DB")&&($d_name != "속옷")){#재봉 도구＆옷계 장비?
	global $btai;
	$btai += (rand(0,2) + $eff[$wk]);
	$log = ($log . "{$itn}를 사용했다.<BR>{$d_name}의 내구력이 {$btai} 가 되었다.<BR>");
	$itai[$wk] --;
	if($itai[$wk] <= 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif((preg_match("/탄환/",$itn))&&(preg_match("/<>WG/",$wep))){ #탄환 사용＆총계 장비?
	global $wtai;

	$up = $eff[$wk] + $wtai;if($up > 6){$up = 6 - $wtai;}else{$up = $eff[$wk];}
	$wtai += $up;$eff[$wk] -= $up;

	if($eff[$wk] <= 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
	if(preg_match("/<>WGB/",$wep)){$wep = str_replace ('<>WGB','<>WG',$wep);}
	if($up == 0){
		$log = ($log . "더 이상{$itn}를,{$w_name} 에 장전 할 수 없다.<BR>");
	}else{
		$log = ($log . "{$itn}를,{$w_name} 에 장전 했다.<BR>{$w_name}의 사용 회수가 {$up} 향상했다.<BR>");
	}
}elseif(($itn == "사이렌서")&&(preg_match("/<>WG/",$wep))&&(!preg_match("/S/",$wep))){	#사이렌서
	$wep = ($w_name . "<>" . $w_kind . "S");
	$log = ($log . "{$itn}를 사용했다.<BR>{$w_name}에 사이렌서를 달았다.<BR>");
	$itai[$wk] --;
	if($itai[$wk] <= 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}elseif(preg_match("/배터리/",$itn)){
	$pc_ck = 0;
	for ($paso=0;$paso<5;$paso++){
		if(($item[$paso] == "모바일 PC<>Y")&&($itai[$paso] < 5)){
			$itai[$paso] += $eff[$wk];
			if($itai[$paso] > 5){$itai[$paso] = 5;}
			$itai[$wk] --;
			if($itai[$wk] <= 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
			$log = ($log . "{$itn} 로 모바일 PC 를 충전했다.<BR>모바일 PC 의 사용 회수가 {$itai[$paso]} 가 되었다.<BR>");
			$pc_ck = 1;
			break;
		}
	}
	if($pc_ck == 0){$log = ($log . "이 녀석은 무엇에 사용하겠지….<BR>") ;$in['Command']="MAIN";}
}elseif($itn == "모바일 PC"){
	$in['Command'] = "SPECIAL";
	$in['Command4'] = "HACK";
	require $pref['LIB_DIR']."/lib3.php";
	HACKING();
}elseif($itn == "프로그램 해제 키"){
	if($pls == 0){
		$inf = ($inf . "해");
		$handle = @fopen($pref['end_flag_file'],'w') or ERROR("unable to open end_flag_file","","ITEM1",__FUNCTION__,__LINE__);
		if(!@fwrite($handle,"해제 종료 \n")){ERROR("unable to write end_flag_file","","ITEM1",__FUNCTION__,__LINE__);}
		fclose($handle);
		LOGSAVE("EX_END");
		$log = ($log . "해제 키를 사용해 프로그램을 정지했다.<br>목걸이가 떨어졌다!<BR>") ;$in['Command']="MAIN";
		SAVE();
	}else{
		$log = ($log . "여기서 사용해도 의미가 없다….<BR>") ;$in['Command']="MAIN";
	}
}elseif($itn == "제비"){#제비 사용
	$log = ($log . "제비인가…열어 보자.<BR>\n");
	$omi = rand(0,100);
	if	 ($omi < 20){$omi="3";list($lvuphit,$lvupatt,$lvupdef) = omikuji1($omi) ;$log = ($log . "대길이다!무엇인가 좋은 것이 있을 것이다!<BR><font color=\"00FFFF\">【몸】+$lvuphit 【공】+$lvupatt 【방】+$lvupdef</font><BR>");}
	elseif($omi < 40){$omi="2";list($lvuphit,$lvupatt,$lvupdef) = omikuji1($omi) ;$log = ($log . "중길인가.그런대로라는 곳이다!<BR><font color=\"00FFFF\">【몸】+$lvuphit 【공】+$lvupatt 【방】+$lvupdef</font><BR>");}
	elseif($omi < 60){$omi="1";list($lvuphit,$lvupatt,$lvupdef) = omikuji1($omi) ;$log = ($log . "소길인가.가능도 없고, 불가도 없고인가…<BR><font color=\"00FFFF\">【몸】+$lvuphit 【공】+$lvupatt 【방】+$lvupdef</font><BR>");}
	elseif($omi < 80){$omi="1";list($lvuphit,$lvupatt,$lvupdef) = omikuji2($omi) ;$log = ($log . "흉인가….정말, 불길하다…<BR><font color=\"00FFFF\">【몸】-$lvuphit 【공】-$lvupatt 【방】-$lvupdef</font><BR>");}
	else			{$omi="2";list($lvuphit,$lvupatt,$lvupdef) = omikuji2($omi) ;$log = ($log . "대흉?어쩐지, 싫은 예감이 하지 말아라…<BR><font color=\"00FFFF\">【몸】-$lvuphit 【공】-$lvupatt 【방】-$lvupdef</font><BR>");}
	$itai[$wk] --;
	if($itai[$wk] <= 0){$item[$wk] = "없음";$eff[$wk] = 0;$itai[$wk] = 0;}
}else{
	$log = ($log . "이 녀석은 무엇에 사용하겠지….<BR>") ;$in['Command']="MAIN";
}

$in['Command'] = "MAIN";

SAVE();

}
#===================#
# ■ 제비 랜덤 #
#===================#
function omikuji1($omi){
	global $hit,$mhit,$att,$att,$def;
	$lvuphit = rand(0,$omi) ;$lvupatt = rand(0,$omi) ;$lvupdef = rand(0,$omi);
	$hit += $lvuphit;$mhit += $lvuphit;$att += $lvupatt;$def += $lvupdef;
	return array($lvuphit,$lvupatt,$lvupdef);
}
function omikuji2($omi){
	global $hit,$mhit,$att,$att,$def;
	$lvuphit = rand(0,$omi) ;$lvupatt = rand(0,$omi) ;$lvupdef = rand(0,$omi);
	$hit -= $lvuphit;$mhit -= $lvuphit;$att -= $lvupatt;$def -= $lvupdef;
	return array($lvuphit,$lvupatt,$lvupdef);
}
#=======================#
# ■ 장비 무기를 벗는 처리 #
#=======================#
function WEPDEL(){
global $in;

global $wep,$log,$l_name,$item,$eff,$watt,$itai,$wtai;

$j = 0;
if(preg_match("/맨손/",$wep)){$log = ($log . "{$l_name}는 무기를 장비하고 있지 않습니다.<br>") ;$in['Command'] = "MAIN";return;}
list($w_name,$w_kind) = explode("<>",$wep);
#소지품 빈 공간 확인
$chk = "NG";
for ($j=0;$j<5;$j++){if($item[$j] == "없음"){$chk = "ON";break;}}
if($chk == "NG"){$log = ($log . "그 이상 데이팩에 들어가지 않습니다.<br>");
}else{
	$log = ($log . "{$w_name}를 데이팩에 끝냈습니다.<br>");
	$item[$j] = $wep;$eff[$j] = $watt;$itai[$j] = $wtai;
	$wep = "맨손<>WP";$watt = 0;$wtai = "∞";
	SAVE();
}
$in['Command'] = "MAIN";
}
#=================#
# ■ 장비 무기 투기 #
#=================#
function WEPDEL2(){
global $in,$pref;

global $wep,$log,$l_name,$pls,$watt,$wtai;

if(preg_match("/맨손/",$wep)){$log = ($log . "{$l_name}는 무기를 장비하고 있지 않습니다.<br>") ;$in['Command'] = "MAIN";return;}
list($itn, $ik) = explode("<>",$wep);
$log = ($log . "{$itn}를 버렸다.<br>");
#무기 투기
$filename = $pref['LOG_DIR'].'/'.$pls.$pref['item_file'];
$itemlist = @file($filename);
array_push($itemlist,"$wep,$watt,$wtai,\n");
$handle = @fopen($filename,'w') or ERROR("unable to open filename","","ITEM1",__FUNCTION__,__LINE__);
if(!@fwrite($handle,implode('',$itemlist))){ERROR("unable to write filename","","ITEM1",__FUNCTION__,__LINE__);}
fclose($handle);
$wep = "맨손<>WP";$watt = 0;$wtai = "∞";
$in['Command'] = "MAIN";
SAVE();
}
#=====================#
# ■ 머리 방어구를 벗는 처리 #
#=====================#
function BOUDELH(){
global $in;

global $bou_h,$log,$l_name,$item,$eff,$itai,$bdef_h,$btai_h;

$j = 0;
if(preg_match("/없음/",$bou_h)){$log = ($log . "{$l_name}는 머리 방어구를 장비하고 있지 않습니다.<br>") ;$in['Command'] = "MAIN";return;}
list($w_name,$w_kind) = explode("<>",$bou_h);
#소지품 빈 공간 확인
$chk = "NG";
for ($j=0;$j<5;$j++){if($item[$j] == "없음"){$chk = "ON";break;}}
if($chk == "NG"){$log = ($log . "그 이상 데이팩에 들어가지 않습니다.<br>");
}else{
	$log = ($log . "{$w_name}를 데이팩에 끝냈습니다.<br>");
	$item[$j] = $bou_h;$eff[$j] = $bdef_h;$itai[$j] = $btai_h;
	$bou_h = "없음";$bdef_h = $btai_h = 0;
	SAVE();
}
$in['Command'] = "MAIN";
}
#=====================#
# ■ 몸방어구를 벗는 처리 #
#=====================#
function BOUDELB(){
global $in;

global $bou,$log,$l_name,$item,$eff,$itai,$bdef,$btai;
$j = 0;
if(preg_match("/속옷/",$bou)){$log = ($log . "$l_name는 몸방어구를 장비하고 있지 않습니다.<br>") ;$in['Command'] = "MAIN";return;}
list($w_name,$w_kind) = explode("<>",$bou);
#소지품 빈 공간 확인
$chk = "NG";
for ($j=0;$j<5;$j++){if($item[$j] == "없음"){$chk = "ON";break;}}
if($chk == "NG"){$log = ($log . "그 이상 데이팩에 들어가지 않습니다.<br>");
}else{
	$log = ($log . "$w_name를 데이팩에 끝냈습니다.<br>");
	$item[$j] = $bou;$eff[$j] = $bdef;$itai[$j] = $btai;
	$bou = "속옷<>DN";$bdef = 0;$btai = 0;
	SAVE();
}
$in['Command'] = "MAIN";
}
#=====================#
# ■ 팔방어구를 벗는 처리 #
#=====================#
function BOUDELA(){
global $in;

global $bou_a,$log,$l_name,$item,$eff,$itai,$bdef_a,$btai_a;
$j = 0;
if(preg_match("/없음/",$bou_a)){$log = ($log . "$l_name는 팔방어구를 장비하고 있지 않습니다.<br>") ;$in['Command'] = "MAIN";return;}
list($w_name,$w_kind) = explode("<>",$bou_a);
#소지품 빈 공간 확인
$chk = "NG";
for ($j=0;$j<5;$j++){if($item[$j] == "없음"){$chk = "ON";break;}}
if($chk == "NG"){$log = ($log . "그 이상 데이팩에 들어가지 않습니다.<br>");
}else{
	$log = ($log . "$w_name를 데이팩에 끝냈습니다.<br>");
	$item[$j] = $bou_a;$eff[$j] = $bdef_a;$itai[$j] = $btai_a;
	$bou_a = "없음";$bdef_a = 0;$btai_a = 0;
	SAVE();
}
$in['Command'] = "MAIN";
}
#=====================#
# ■ 다리 방어구를 벗는 처리 #
#=====================#
function BOUDELF(){
global $in;

global $bou_f,$log,$l_name,$item,$eff,$itai,$bdef_f,$btai_f;
$j = 0;
if(preg_match("/없음/",$bou_f)){$log = ($log . "$l_name는 다리 방어구를 장비하고 있지 않습니다.<br>") ;$in['Command'] = "MAIN";return;}
list($w_name,$w_kind) = explode("<>",$bou_f);
#소지품 빈 공간 확인
$chk = "NG";
for ($j=0;$j<5;$j++){if($item[$j] == "없음"){$chk = "ON";break;}}
if($chk == "NG"){$log = ($log . "그 이상 데이팩에 들어가지 않습니다.<br>");
}else{
	$log = ($log . "$w_name를 데이팩에 끝냈습니다.<br>");
	$item[$j] = $bou_f;$eff[$j] = $bdef_f;$itai[$j] = $btai_f;
	$bou_f = "없음";$bdef_f = 0;$btai_f = "∞";
	SAVE();
}
$in['Command'] = "MAIN";
}
#=====================#
# ■ 장식품을 제외하는 처리 #
#=====================#
function BOUDEL(){
global $in;

global $log,$l_name,$item,$eff,$itai;
$j = 0;
if(preg_match("/없음/",$item[5])){$log = ($log . "$l_name는 장식품을 장비하고 있지 않습니다.<br>") ;$in['Command'] = "MAIN";return;}
list($w_name,$w_kind) = explode("<>",$item[5]);
#소지품 빈 공간 확인
$chk = 'NG';
for ($j=0;$j<5;$j++){if($item[$j] == "없음"){$chk = "ON";break;}}
if($chk == "NG"){$log = ($log . "그 이상 데이팩에 들어가지 않습니다.<br>");
}else{
	$log = ($log . "$w_name를 데이팩에 끝냈습니다.<br>");
	$item[$j] = $item[5];$eff[$j] = $eff[5];$itai[$j] = $itai[5];
	$item[5] = "없음";$eff[5] = 0;$itai[5] = "0";
	SAVE();
}
$in['Command'] = 'MAIN';
}