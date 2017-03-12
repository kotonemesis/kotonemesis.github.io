<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-    BR ATTACK PROGRAM    - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ ATTJYO		-		양도 처리		 ■
#□ ATTACK		-		선제 공격 표시	 □
#□■□■□■□■□■□■□■□■□■□■□
#=============#
# ■ 양도 처리 #
#=============#
function ATTJYO(){
global $in;

global $teamID,$w_teamID,$teamPass,$w_teamPass,$log,$w_f_name,$w_l_name,$w_cl,$w_sex,$w_no;
if(($teamID != '없음')&&($teamID != '')&&($teamID == $w_teamID)&&($teamPass == $w_teamPass)){
	$log .= $w_f_name.' '.$w_l_name.'('.$w_cl.' '.$w_sex.$w_no.'차례)를 발견했다!<br>';
	$log .= $w_l_name.'에 무엇을 양도할까….<br>';
	$in['Command']='ITEMJOUTO';
}else{ERROR('부정 액세스입니다','teamID and teamPass missmatch','ATT_ETC',__FUNCTION__,__LINE__);}
}
#=================#
# ■ 선제 공격 표시 #
#=================#
function ATTACK(){
global $in;

global $kiri,$log,$w_f_name,$w_l_name,$w_cl,$w_sex,$w_no,$w_id,$wether;
if($kiri){
	$log .= '사람의 그림자를 발견했다!<br>';
	$log .= '그러나,'.$wether.'태워 있어로 누군지 모른다.<br>';
	$log .= '상대는 이쪽에는 눈치채지 않은 것 같다….<br>';
	$in['Command']=('BATTLE0_'.IDcrypt($w_id));
}else{
	$log .= $w_f_name.' '.$w_l_name.'('.$w_cl.' '.$w_sex.$w_no.'차례)를 발견했다!<br>';
	$log .= $w_f_name.' '.$w_l_name.'는 이쪽에는 눈치채지 않았어….<br>';
	$in['Command']=('BATTLE0_'.IDcrypt($w_id));
}
}
#===============#
# ■ 전리품 취득 #
#===============#
function WINGET(){
global $in,$pref;

global $item,$id,$log,$eff,$itai,$l_name;
$money_get = 0;

$itno = -1;
for ($i=0;$i<5;$i++){if($item[$i] == '없음'){$itno = $i;}}

if($in['WId'] == IDcrypt($id)){$log .= '스스로 자신의 소지품을 빼앗아 보았다.<br>허무하다….<br>';$in['Command'] = 'MAIN';return;}

$wk = $in['Command'];
$wk = preg_replace('/GET_/','',$wk);
$wk += 0;
$wk = (int)($wk);

$userlist = @file($pref['user_file']) or ERROR('unable to open file user_file','','ATT_ETC',__FUNCTION__,__LINE__);
$wingetchk=1;

global $w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item,$w_eff,$w_itai,$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP;
for ($i=0;$i<count($userlist);$i++){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$i]);
	if($in['WId'] == IDcrypt($w_id)){
		list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",",$userlist[$i]);
		BB_CK();#브라우저 백 대처
		if		($w_hit>0)	{$log .= $w_f_name.'의 그 소지품을 갖고 싶으면 강하게 빌어 보았다.<br>허무하다….<br>';$in['Command'] = 'MAIN';return;}
		elseif	($wk == 6)	{list($witem,$weff,$witai) = array($w_wep,$w_watt,$w_wtai) ;$w_wep = '맨손<>WP';$w_watt = 0;$w_wtai = '∞';}
		elseif	($wk == 7)	{list($witem,$weff,$witai) = array($w_bou,$w_bdef,$w_btai) ;$w_bou = '속옷<>DN';$w_bdef = 0;$w_btai = '∞';}
		elseif	($wk == 8)	{list($witem,$weff,$witai) = array($w_bou_h,$w_bdef_h,$w_btai_h) ;$w_bou_h = '없음';$w_bdef_h = $w_btai_h = 0;}
		elseif	($wk == 9)	{list($witem,$weff,$witai) = array($w_bou_f,$w_bdef_f,$w_btai_f) ;$w_bou_f = '없음';$w_bdef_f = $w_btai_f = 0;}
		elseif	($wk == 10)	{list($witem,$weff,$witai) = array($w_bou_a,$w_bdef_a,$w_btai_a) ;$w_bou_a = '없음';$w_bdef_a = $w_btai_a = 0;}
		elseif	($wk == 11)	{$money_get = 1;}
		else				{list($witem,$weff,$witai) = array($w_item[$wk],$w_eff[$wk],$w_itai[$wk]) ;$w_item[$wk] = '없음';$w_eff[$wk] = $w_itai[$wk] = 0;}
		$wingetchk=0;break;
	}
}

$in['Command'] = 'MAIN';
if($wingetchk){
	ERROR('내부 에러 관리인에게 보고해 주세요','WINGET INTERNAL ERROR','ATT_ETC',__FUNCTION__,__LINE__);
}elseif($money_get){#현금 취득
	global $money;
	$money_disp =($w_money * $pref['money_base']);
	$money+=$w_money;$w_money=0;
	$log .= $l_name.'는 '.$money_disp.'엔 손에 넣었다.<BR>';
}elseif($itno == -1){#소지품 비어 없음
	global $item_get,$eff_get,$itai_get;
	$item_get = $witem;$eff_get = $weff;$itai_get = $witai;
	$in['Command3'] = 'GET';$in['Command'] = 'ITMAIN';
}elseif((!preg_match('/^(없음|맨손|속옷)$/',$witem))&&($i != count($userlist))){#아이템 취득
	$item[$itno] = $witem;
	$eff[$itno] = $weff;$itai[$itno] = $witai;
	list($witem) = explode('<>',$witem,2);
	$log .= $l_name.'는 '.$witem.'를 손에 넣었다.<BR>';
}else{$log .= '빼앗는 것을 단념했다.<BR>';}
SAVE();
SAVE2();
}
#=================#
# ■ 시체 발견 처리 #
#=================#
function DEATHGET(){
global $in;

global $log,$w_f_name,$w_l_name,$w_id,$w_death,$chksts;

$log .= $w_f_name.' '.$w_l_name.'의 시체를 발견했다.<br>';
$item_get = $w_id;#브라우저 백 대처

if(preg_match('/참살/',$w_death)){
	if	 ($w_com == 0)	{$log .= '머리 부분이 목의 가죽 한 장으로 연결되어있는 상태다….목을 문 잘 수 있던 것 같다.<br>';}
	elseif($w_com == 1)	{$log .= '복부가 예리한 칼날과 같은 것으로 찢어지고, 내장이 초과하고 있다….<br>';}
	elseif($w_com == 2)	{$log .= '어깻죽지로부터 가슴에 걸친 가사절다.보기 좋게 찢어져지고 있다….<br>';}
	elseif($w_com == 3)	{$log .= '수·동·양팔·양 다리가 분단 되고 있다.이런 일이 제정신의 인간에게 할 수 있는 것일까….<br>';}
	elseif($w_com == 4)	{$log .= '얼굴을 집중적으로 잘게 잘려지고 있다.생전의 모습등 전혀 없다….<br>';}
	elseif($w_com == 5)	{$log .= '복부를 찢어져지고 있지만, 잘 보면 손목에도 베인 상처가 많이 있다….<BR>상대에게 잘린 후에 자살을 하려고 한 것일까?<br>';}
	else				{$log .= '머리로부터 가슴에 걸쳐 끔찍하게 찢어져지고 있다….<br>';}
}elseif(preg_match('/총살/',$w_death)){
	if	 ($w_com == 0)	{$log .= '가슴에…3발, 액수에 1발의 탄흔이 있다….액의 일발이 치명상에 걸린 것 같다….<br>';}
	elseif($w_com == 1)	{$log .= '복부에 수발의 탄흔이 있어, 피가 흐르기 시작하고 있다.그러나, 그 피도 이미 마르고 있다.<br>';}
	elseif($w_com == 2)	{$log .= '머리가 원형을 세우지 않은 정도 날아가고 있다….명찰로부터 가까스로 이름을 알 수 있던 정도다.<br>';}
	elseif($w_com == 3)	{$log .= '가슴에 수발.그리고, 뇌 골수가 날아가고 있다.죽인 후, 입에 총을 돌진해 공격했을 것이다.장난친 것을 하고 있다….<br>';}
	elseif($w_com == 4)	{$log .= '복부에 뻥 구멍이 있어, 저쪽 편이 보인다.이래서야 절대 살아 넣지 않는데….<br>';}
	elseif($w_com == 5)	{$log .= '얼굴에 몇 발의 탄흔이 있다….원한이라도 있던 것일까.<br>';}
	else				{$log .= ' 오른쪽 머리 부분이 격렬하게 손상해, 뇌가 흐르기 시작하고 있다….<br>';}
}elseif(preg_match('/폭살/',$w_death)){
	if	 ($w_com == 0)	{$log .= '그 정도로, 몸의 파트가 분산하고 있다.화려하게 당한 것 같다….<br>';}
	elseif($w_com == 1)	{$log .= '양 다리가 날려 버려지고 있다.팔만으로 겨 도망치려고 했는가….<br>';}
	elseif($w_com == 2)	{$log .= '폭탄이라도 공격받은 것일까, 머리와 오른 팔 밖에 남지 않았다….<br>';}
	elseif($w_com == 3)	{$log .= '폭탄에 날려 버려진 것일까, 머리가 반 빠지고 내용이 들여다 보고 있다….<br>';}
	elseif($w_com == 4)	{$log .= '폭풍으로 날려 버려진 한쪽 팔이, 5 m 정도 먼저 구르고 있다….<br>';}
	elseif($w_com == 5)	{$log .= '시체라고 하는 것보다, 고기의 덩어리다….<br>';}
	else				{$log .= '목과 손이 눈에 띄지 않는데….폭풍으로 날려 버려졌을 것이다인가….<br>';}
}elseif(preg_match('/박살/',$w_death)){
	if	 ($w_com == 0)	{$log .= '배를 억제한 체제로, 웅크리고 있지만…아무래도, 그대로 숨 끊어진 것 같다….<br>';}
	elseif($w_com == 1)	{$log .= '상당히 화려하게 맞은 것 같다….얼굴이 보라색에 부어 오르고 있다….<br>';}
	elseif($w_com == 2)	{$log .= '목의 뼈가 부러뜨려져 목으로부터 뼈가 뚫고 나오고 있다….<br>';}
	elseif($w_com == 3)	{$log .= '지면에 얼굴을 묻어 대량의 피를 안면으로부터 흘리고 있다….넘어진 곳, 후두부가 구타된 것 같다.<br>';}
	elseif($w_com == 4)	{$log .= '뒤에서 둔기와 같은 것으로 맞는 것일까?머리를 움켜 쥔 채로 넘어져 있다….<br>';}
	elseif($w_com == 5)	{$log .= '이마가 다쳐 피와 뇌장이 흐르고 있다.바로 정면으로부터 격렬하게 맞은 것 같다….<br>';}
	else				{$log .= '목이 보기 좋게 옆에 향하고 있다.어떻게 봐도, 목이 탈골하고 있지 말아라….<br>';}
}elseif(preg_match('/독/',$w_death)){
	if	 ($w_com == 0)	{$log .= '독물을 먹었던가…?구토한 형적도 있다….<br>';}
	elseif($w_com == 1)	{$log .= '입으로부터 외곬의 피가 흐르고 있다.쫙 봐는, 자고 있도록(듯이) 밖에 보이지 않는데….<br>';}
	elseif($w_com == 2)	{$log .= '시체에게 얼굴을 접근하면 특유의 아몬드취가 있다.독살되었는가….<br>';}
	elseif($w_com == 3)	{$log .= '독살되었는가.입으로부터 대량의 피가 섞인 당황하고 있다….<br>';}
	elseif($w_com == 4)	{$log .= '독을 먹어 괴로워했을 것이다인가.목을 스스로 격렬하게 조로 써 잡아 채고 있다….<br>';}
	elseif($w_com == 5)	{$log .= '누군가에게 독약에서도 걸칠 수 있었는지?피부가 격렬하게 변색하고 있다….<br>';}
	else				{$log .= '피부가 거무칙칙한 색에 변색하고, 입에서는 대량의 피를 토하고 있다….<br>';}
} else					{$log .= '끔찍하게도 위로 향해 널려 있다….<br>';}
$log .= '데이팩의 내용을 물색시켜 줄까….<br>';
$in['Command'] = 'DEATHGET';

$chksts='OK';

}
?>