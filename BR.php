<?php
require 'pref.php';
#□■□■□■□■□■□■□■□■□■□■□
#■ 	-     BR MAIN PROGRAM     - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ MAIN	-	메인 처리				 ■
#□ COM		-	커멘드 처리			 □
#■ HEAL	-	치료 처리				 ■
#□ INN		-	수면 처리				 □
#■ INNHEAL	-	정양 처리				 ■
#□ BB_CK	-	브라우저 백 부정 방지	 □
#■□■□■□■□■□■□■□■□■□■□■
CREAD();
IDCHK();

if($in['mode']=='main'){MAIN();}
elseif($in['mode']=='command'){COMM();}
else{ERROR('Invalid Access','No Command selected','BATTLE',__FUNCTION__,__LINE__);}
UNLOCK();
exit;
#===============#
# ■ 메인 처리 #
#===============#
function MAIN(){
global $pref;

HEAD();
require $pref['LIB_DIR'].'/dsp_sts.php';
require $pref['LIB_DIR'].'/dsp_cmd.php';
STS();
FOOTER();
}
#=================#
# ■ 커멘드 처리 #
#=================#
function COMM(){
global $in,$pref;

global $mflg;
#★ Messener
if($in['Command']=='MESS')											{require $pref['LIB_DIR'].'/lib4.php';MESS();}	#송신
elseif($in['Command']=='MSG_DEL')									{require $pref['LIB_DIR'].'/lib4.php';MSG_DEL();}#삭제
#★ 이동·검색·승리시
elseif($in['Command']=='MOVE' && strpos($in['Command2'],'MV')===0)	{require $pref['LIB_DIR'].'/lib2.php';MOVE();}	#이동
elseif($in['Command']=='SEARCH')									{require $pref['LIB_DIR'].'/lib2.php';SEARCH();}#탐색
#★ 회복 처리부
elseif($in['Command']=='kaifuku'){
	if($in['Command5']=='HEAL')			{HEAL();}	#치료
	elseif($in['Command5']=='INN')		{INN();}	#수면
	elseif($in['Command5']=='INNHEAL')	{INNHEAL();}#정양
}
elseif($in['Command']=='HEAL')		{HEAL();}		#치료
elseif($in['Command']=='INN')		{INN();}		#수면
elseif($in['Command']=='INNHEAL')	{INNHEAL();}	#정양
#★ ITEM1
elseif(strpos($in['Command'],'ITEM_')===0)		{require $pref['LIB_DIR'].'/item1.php';ITEM();}			#아이템 사용
elseif(strpos($in['Command'],'DEL_')===0)			{require $pref['LIB_DIR'].'/item1.php';ITEMDEL();}		#아이템 투기
elseif($in['Command']=='ITEMDELNEW')				{require $pref['LIB_DIR'].'/item1.php';ITEMDELNEW();}	#아이템 버린다
elseif($in['Command']=='ITEMGETNEW')				{require $pref['LIB_DIR'].'/item1.php';ITEMGETNEW();}	#아이템 줍는다
elseif(strpos($in['Command'],'ITEMNEWXCG_')===0)	{require $pref['LIB_DIR'].'/item1.php';ITEMNEWXCG();}	#아이템 교환
elseif(strpos($in['Command'],'ITEMSEINEW_')===0)	{require $pref['LIB_DIR'].'/item1.php';ITEMSEINEW();}	#아이템 정리
elseif($in['Command']=='ITMAIN'){
	require $pref['LIB_DIR'].'/item1.php';
	if($in['Command3']=='WEPDEL')		{WEPDEL();}	#무기 벗는다
	elseif($in['Command3']=='WEPDEL2')	{WEPDEL2();}#무기 버린다
	elseif($in['Command3']=='BOUDELH')	{BOUDELH();}#두 방어구를 벗는다
	elseif($in['Command3']=='BOUDELB')	{BOUDELB();}#체 방어구를 벗는다
	elseif($in['Command3']=='BOUDELA')	{BOUDELA();}#팔방어구를 벗는다
	elseif($in['Command3']=='BOUDELF')	{BOUDELF();}#다리 방어구를 벗는다
	elseif($in['Command3']=='BOUDEL')	{BOUDEL();}	#장식품을 제외한다
}
#★ ATTACK
elseif(strpos($in['Command'],'ATK')===0)	{require $pref['LIB_DIR'].'/attack.php';require $pref['LIB_DIR'].'/att_sen.php';ATTACK1();}	#공격
elseif($in['Command']=='RUNAWAY')			{require $pref['LIB_DIR'].'/attack.php';RUNAWAY();}									#도망
elseif(strpos($in['Command'],'GET_')===0)	{require $pref['LIB_DIR'].'/att_etc.php';WINGET();}									#전리품
#★ LIB3
elseif(strpos($in['Command'],'OUK_')===0)								{require $pref['LIB_DIR'].'/lib3.php';OUKYU();}	#응급 처치
elseif((isset($in['Message']) &&$in['Message']!='')||(isset($in['Message2']) && $in['Message2'] != '')||(isset($in['Comment']) && $in['Comment'] != ''))
																		{require $pref['LIB_DIR'].'/lib3.php';WINCHG();}	#말버릇 변경
elseif((isset($in['teamID2']) && $in['teamID2'] != '')||(isset($in['teamPass2']) && $in['teamPass2'] != ''))
																		{require $pref['LIB_DIR'].'/lib3.php';TEAM();}	#그룹 조작
elseif($in['Command']=='SPEAKER')										{require $pref['LIB_DIR'].'/lib3.php';SPEAKER();}#휴대 스피커 사용
elseif($in['Command']=='SPECIAL'&&$in['Command4']=='HACK')			{require $pref['LIB_DIR'].'/lib3.php';HACKING();}#해킹
elseif(strpos($in['Command'],'KOU_')===0)								{require $pref['LIB_DIR'].'/lib3.php';KOUDOU();}	#기본방침
elseif(strpos($in['Command'],'OUS_')===0)								{require $pref['LIB_DIR'].'/lib3.php';OUSEN();}	#응전 방침
elseif(strpos($in['Command'],'POI_')===0)								{require $pref['LIB_DIR'].'/lib3.php';POISON();}	#독물 혼입
elseif(strpos($in['Command'],'PSC_')===0)								{require $pref['LIB_DIR'].'/lib3.php';PSCHECK();}#독 봐
elseif(strpos($in['Command'],'BAITEN2_')===0)							{require $pref['LIB_DIR'].'/lib3.php';BAITEN2();}#매점 2
#★ ITEM2
elseif(strpos($in['Command'],'SEIRI_')===0 && strpos($in['Command2'],'SEIRI2_')===0)	{require $pref['LIB_DIR'].'/item2.php';ITEMSEIRI();}	#아이템 정리
elseif(strpos($in['Command'],'GOUSEI1_')===0 && strpos($in['Command2'],'GOUSEI2_')===0 && strpos($in['Command3'],'GOUSEI3_')===0)		#아이템 합성
																						{require $pref['LIB_DIR'].'/item2.php';ITEMGOUSEI();}
elseif(strpos($in['Command'],'SEITO_')===0 && strpos($in['Command2'],'JO_')===0)		{require $pref['LIB_DIR'].'/item2.php';ITEMJOUTO();}		#아이템 양도

#★ 전투
if(strpos($in['Command'],'BATTLE')===0 || strpos($in['Command'],'ATK')===0)
		{HEAD() ;require $pref['LIB_DIR'].'/dsp_att.php';require$pref['LIB_DIR'].'/dsp_cmd.php';BATTLE() ;FOOTER();}#전투 결과
elseif($in['Command']=='ITEMJOUTO')
		{HEAD() ;require $pref['LIB_DIR'].'/dsp_att.php';require$pref['LIB_DIR'].'/dsp_cmd.php';BATTLE() ;FOOTER();}#아이템 양도
#★ ADMIN
elseif($in['Command']=='DEATHGET')	{HEAD() ;require $pref['LIB_DIR'].'/dsp_att.php';require$pref['LIB_DIR'].'/dsp_cmd.php';BATTLE() ;FOOTER();}#시체 발견
elseif($mflg!='ON'){MAIN();}
else{ERROR('커멘드가 인식되지 않았습니다','Command not found','BR',__FUNCTION__,__LINE__);}
}
#===================#
# ■ ID체크 처리 #
#===================#
function IDCHK(){
global $in,$pref;

global $mem,$chksts,$Index,$host,$fl,$ar,$mem;
global $id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item,$eff,$itai,$com,$log,$dmes,$bid,$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass;
$userlist = @file($pref['user_file']) or ERROR('unable to open file user_file user_file','유저 파일 읽기 실패','BR',__FUNCTION__,__LINE__);
$jyulog = $jyulog2 = $jyulog3 = '';#총성 로그
$mem=0;
$chksts = 'NG';

list($ka,$hf) = explode(',',trim($pref['arealist'][1]));
if(!$ka){
	ERROR('Please wait until a session open!');
}
for($i=0;$i<count($userlist);$i++){
	list($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,) = explode(",", $userlist[$i]);
	if($w_id == $in['Id']){	#ID일치?
		if($w_password == $in['Password']){	#패스워드 정상?
			if($w_hit > 0){	#생존?
				$chksts = 'OK';$Index=$i;$mem++;
				list($id,$password,$f_name,$l_name,$sex,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg,$sts,$pls,$kill,$icon,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$com,$dmes,$bid,$in['club'],$money,$wp,$wg,$wn,$wc,$wd,$comm,$limit,$bb,$inf,$ousen,$seikaku,$sinri,$item_get,$eff_get,$itai_get,$teamID,$teamPass,$in['IP'],) = explode(",", $userlist[$i]);
				if(($item_get!='없음')&&(!preg_match('/ITEM|GET/',$in['Command']))){require $pref['LIB_DIR'].'/item1.php';ITEMDELNEW();}/*신규 아이템 소지?*/
				if($host != $in['IP']){
					if(!$pref['MOBILE']){
						debug($pref['now'].','.$id.','.$host."\n");
					}else{
						//debug($pref['now'].','.$id.','.$pref['MOBILE']."\n");
					}
				}
				if($host == $pref['SubS']){
					if($in['IPAdd'] != ''){$in['IP'] = $in['IPAdd'];}
				}elseif(!$pref['MOBILE']){
					$in['IP'] = $host;
				}
				CSAVE();
				$gunlog = @file($pref['gun_log_file']) or ERROR('unable to open file gun_log_file','','BR',__FUNCTION__,__LINE__);
				global $jyulog,$jyulog2,$jyulog3;
				list($guntime,$gunpls,$wid,$wid2,$a) = explode(',',$gunlog[0]);
				if(($pref['now'] < ($guntime+(30)))&& ($wid != $id)&&($wid2 != $id)){$jyulog = '<font color="yellow"><b>'.$gunpls.'의 분으로, 총성이 들렸다….</b></font><br>';}/*총사용으로부터 30초 이내?*/
				list($guntime,$gunpls,$wid,$wid2,$a) = explode(',',$gunlog[1]);
				if(($pref['now'] < ($guntime+(30)))&& ($wid != $id)&&($wid2 != $id)&&($pref['place'][$pls] == $gunpls)){$jyulog2 = '<font color="yellow"><b>근처에서 비명이?누군가, 살해당했는지…?</b></font><br>';}/*살해로부터 30초 이내?*/
				list($guntime,$gunpls,$wid,$wid2,$a) = explode(',',$gunlog[2]);
				if(($pref['now'] < ($guntime+(60)))){$jyulog3 = '<font color="yellow"><b>'.$gunpls.'로부터'.$wid.'의 목소리가 들린다…</b></font><br><font color="lime"><b>「'.$wid2.'」</b></font><br>';}/*스피커 사용으로부터 1분 이내?*/
			}else{#사망
				global $c_id;
				if($c_id != '2YBRU'){CDELETE();}
				ERROR('이미 사망해 있습니다.<BR><BR>사인：'.$w_death.'<BR><BR><font color="lime"><b>'.$w_msg.'</b></font><br><br><script language="JavaScript">SWF_DSP("./'.$pref['imgurl'].'/bar.swf?color=5",200,70);</script>','You died','BR',__FUNCTION__,__LINE__);}
		}else{
			if(preg_match('/2YBRU/',$w_password)){ERROR('관리인에 의해 락을 걸칠 수 있고 있습니다.시급히 관리자에게 연락해 주세요','Your userdata is been locked. Please contact with Administrator','BR',__FUNCTION__,__LINE__);}
			else{ERROR('패스워드가 일치하지 않습니다','Password does not match','BATTLE-IDCHK','BR',__FUNCTION__,__LINE__);}}
	}else{#외 PC생존자?
		if($w_hit>0 && $w_sts!='NPC'){$mem++;}
	}
}
if($chksts=='NG'){ERROR('ID가 발견되지 않습니다','ID Not Found','BR',__FUNCTION__,__LINE__);}
$b_limit = ($pref['battle_limit'] * 3) + 1;

if((($mem == 1)&&(preg_match('/승/',$inf))&&($ar > $b_limit))||(($mem == 1)&&($ar > $b_limit))){
	if(!preg_match('/종료/',$fl)){/*우승?*/
		$handle = @fopen($pref['end_flag_file'], 'w');
		if(!@fwrite($handle,"종료 \n")){ERROR('unable to write end_flag_file','','BR',__FUNCTION__,__LINE__);}
		fclose($handle);
		LOGSAVE('END');
	}
	if(!preg_match('/종/',$inf)){/*우승?*/
		$inf .= '종';
		LOGSAVE('WINNER');
	}
	require $pref['LIB_DIR'].'/dsp.php';ENDING();
}elseif(preg_match('/해/',$inf)){
	require $pref['LIB_DIR'].'/dsp.php';ENDING();
}elseif(@preg_match('/해제/',$fl)){
	require $pref['LIB_DIR'].'/dsp.php';ENDING();
}else{
	if($log != ''){$wlog = $log;$log='';$log=$wlog;}
	$bid = '';
}

SAVE();
}
#=========================#
# ■ 치료·수면·정양 처리 #
#=========================#
function HEAL()		{
global $pref;
global $sts,$endtime;
$sts = '치료';
$endtime = $pref['now'];
SAVE();
}
function INN(){
global $pref;
global $sts,$endtime;
$sts = '수면';
$endtime = $pref['now'];
SAVE();
}
function INNHEAL(){
global $pref;
global $sts,$endtime,$pls,$id,$hour,$min,$sec,$in;
if(!(($pref['place'][$pls] == "진료소")||((preg_match('/수영부/',$pref['clb'][$in['club']]))&&(preg_match('/북쪽의 갑|남의미사키/',$pref['place'][$pls]))))){
	debug($hour.':'.$min.':'.$sec.','.$id.',INNHEAL'."\n");
	ERROR('부정 액세스입니다','INNHEAL bug fix','BR',__FUNCTION__,__LINE__);
}
$sts = '정양';
$endtime = $pref['now'];
SAVE();
}
#===========================#
# ■ 브라우저 백 부정 방지 #
#===========================#
function BB_CK(){
global $bb,$w_id;
if($bb == $w_id){$bb = '';}else{ERROR('부정 액세스입니다','Used Browser Back Command','BR',__FUNCTION__,__LINE__);}
}
?>