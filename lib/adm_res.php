<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	- BR ADMINISTRATOR SCRIPT - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#□ DATARESET	-	데이터 초기화		 □
#□■□■□■□■□■□■□■□■□■□■□
#=================#
# ■ 데이터 초기화 #
#=================#
function DATARESET(){
global $pref;
global $RESET0,$RESET1,$RESET2,$RESET3,$RESET4,$RESET5,$RESET6,$RESET7,$RESET8,$RESET9,$RESET10,$RESET11,$RESET12;
global $res_j,$res_f,$res_m,$res_d,$res_y;
if(!$RESET9){ERROR('동의 해 주세요');}#동의
if($RESET11){#일시 지정
	if(mktime(date('G'),date('i'),0,date('n'),date('j'),date('Y')) >= mktime($res_j,$res_f,0,$res_m,$res_d,$res_y)){
		ERROR('지금보다 늦은 시간에 설정해 주세요.단지 지금의 시각'.date('Y').'해'.date('m').'달'.date('d').'일'.date('H').'때'.date('i').'분');
	}else{
		if($RESET12){
			$pre_reg = 1;
		}else{
			$pre_reg = 0;
		}
	}
	$ka = 0;
}else{
	if($RESET12){
		ERROR('초기화를 금방 하는 경우, 사전 등록은 할 수 없습니다.');
	}else{
		$res_y = date('Y');
		$res_m = date('n');
		$res_d = date('j');
		$res_j = date('G');
		$res_f = date('i');
		$pre_reg = 0;
		#금지 에리어 파일 갱신
		$pgsplit = 8;
		$res_j = $pgsplit * (round($res_j / $pgsplit)+1);
		if($res_j >= 24){$res_j-=24;$res_d++;}
		$ka = 1;
	}
}


if($RESET0){#NPC 초기화
	$baselist = @file($pref['npc_file']) or ERROR("unable to open file npc_file");
	$basyo = 1;
	if(count($baselist) && $pref['npc_mode']){
		for ($i=0; $i<count($baselist); $i++){
			list($w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,) = explode(",",$baselist[$i]);
			if($w_cl == $pref['BOSS']){	#정부측의NPC
				$w_wep = "수소 입자 물총<>WG";$w_watt = "100";$w_wtai = "200";
				$w_bou = "아오야마의 슈트<>DB";$w_bdef = "50";$w_btai = "100";
				$w_bou_h = "겐지의 두<>DH";$w_bdef_h = "50";$w_btai_h = "100";
				$w_bou_f = "Nike의 Air Force1<>DF";$w_bdef_f = "50";$w_btai_f = "100";
				$w_bou_a = "믹키의 장갑<>DA";$w_bdef_a = "50";$w_btai_a = "100";
				if($w_l_name == "금발"){$w_icon = "85";}elseif($w_l_name == "타하라"){$w_icon = "86";}elseif($w_l_name == "콘도"){$w_icon = "87";}elseif($w_l_name == "노무라"){$w_icon = "88";}elseif($w_l_name == "카토"){$w_icon = "89";}
				$w_item[0] = "프로그램 해제 키<>Y";$w_eff[0] = "1";$w_itai[0] = "1";
				$w_item[1] = "없음";$w_eff[1] = "0";$w_itai[1] = "0";
				$w_item[2] = "없음";$w_eff[2] = "0";$w_itai[2] = "0";
				$w_item[3] = "없음";$w_eff[3] = "0";$w_itai[3] = "0";
				$w_item[4] = "없음";$w_eff[4] = "0";$w_itai[4] = "0";
				$w_item[5] = "교사 증명서<>A";$w_eff[5] = "1";$w_itai[5] = "1";
				$w_dmes = "이것만은, 기억해 통 「인생은 게임입니다.」";$w_com = "안되겠지 , 선생님을 화나게 해 버렸다들";$w_msg = "아?보여 버렸다";
				$w_att = 300;$w_def = 500;$w_hit = 3000;
				$w_level = 30; $w_exp = (int)($w_level*$pref['baseexp']+(($w_level-1) *$pref['baseexp'])) - 17;
				$w_tactics = "없음"; $w_death = "";
				$w_pls = 0;
				$w_wp=$w_wg=$w_wn=$w_wc=$w_wd=100;
				$w_mhit=$w_hit; $w_sta = $pref['maxsta'];
				$w_sts = "NPC";
				$w_money = "100";
			}elseif($w_cl == $pref['KANN']){	#정부측의 NPC
				$w_wep = "아사르트라이훌α<>WG";$w_watt = "75";$w_wtai = "200";
				$w_bou = "군복α<>DB";$w_bdef = "40";$w_btai = "100";
				$w_bou_h = "군모α<>DH";$w_bdef_h = "40";$w_btai_h = "100";
				$w_bou_f = "군화α<>DF";$w_bdef_f = "40";$w_btai_f = "100";
				$w_bou_a = "군복α<>DA";$w_bdef_a = "40";$w_btai_a = "100";
				if($w_l_name == "금발"){$w_icon = "85";}elseif($w_l_name == "타하라"){$w_icon = "86";}elseif($w_l_name == "콘도"){$w_icon = "87";}elseif($w_l_name == "노무라"){$w_icon = "88";}elseif($w_l_name == "카토"){$w_icon = "89";}
				$w_item[0] = "없음";$w_eff[0] = "0";$w_itai[0] = "0";
				$w_item[1] = "없음";$w_eff[1] = "0";$w_itai[1] = "0";
				$w_item[2] = "없음";$w_eff[2] = "0";$w_itai[2] = "0";
				$w_item[3] = "없음";$w_eff[3] = "0";$w_itai[3] = "0";
				$w_item[4] = "없음";$w_eff[4] = "0";$w_itai[4] = "0";
				$w_item[5] = "교사 증명서<>A";$w_eff[5] = "1";$w_itai[5] = "1";
				$w_dmes = "";$w_com = "";$w_msg = "";
				$w_att = 200;$w_def = 400;$w_hit = 2000;
				$w_level = 20; $w_exp = (int)($w_level*$pref['baseexp']+(($w_level-1) *$pref['baseexp'])) - 17;
				$w_tactics = "없음"; $w_death = "";
				$w_pls = 0;
				$w_wp=$w_wg=$w_wn=$w_wc=$w_wd=100;
				$w_mhit=$w_hit; $w_sta = $pref['maxsta'];
				$w_sts = "NPC";
				$w_money = "100";
			}elseif($w_cl == $pref['ZAKO']){	#정부측의 NPC
				$w_wep = "아사르트라이훌β<>WG";$w_watt = "50";$w_wtai = "200";
				$w_bou = "군복β<>DB";$w_bdef = "30";$w_btai = "100";
				$w_bou_h = "군모β<>DH";$w_bdef_h = "30";$w_btai_h = "100";
				$w_bou_f = "군화β<>DF";$w_bdef_f = "30";$w_btai_f = "100";
				$w_bou_a = "군복β<>DA";$w_bdef_a = "30";$w_btai_a = "100";
				if($w_l_name == "금발"){$w_icon = "85";}
				elseif($w_l_name == "타하라"){$w_icon = "86";}
				elseif($w_l_name == "콘도"){$w_icon = "87";}
				elseif($w_l_name == "노무라"){$w_icon = "88";}
				elseif($w_l_name == "카토"){$w_icon = "89";}
				$w_item[0] = "없음";$w_eff[0] = "0";$w_itai[0] = "0";
				$w_item[1] = "없음";$w_eff[1] = "0";$w_itai[1] = "0";
				$w_item[2] = "없음";$w_eff[2] = "0";$w_itai[2] = "0";
				$w_item[3] = "없음";$w_eff[3] = "0";$w_itai[3] = "0";
				$w_item[4] = "없음";$w_eff[4] = "0";$w_itai[4] = "0";
				$w_item[5] = "병사 증명서<>A";$w_eff[5] = "1";$w_itai[5] = "1";
				$w_dmes = "";$w_com = "";$w_msg = "";
				$w_att = 100;$w_def = 300;$w_hit = 1000;
				$w_level = 10; $w_exp = (int)($w_level*$pref['baseexp']+(($w_level-1) *$pref['baseexp'])) - 17;
				$w_tactics = "없음"; $w_death = "";
				$w_pls = $basyo;$basyo++;if($basyo >= 22){$basyo = 1;};
				$w_wp=$w_wg=$w_wn=$w_wc=$w_wd=20;
				$w_mhit=$w_hit; $w_sta = $pref['maxsta'];
				$w_sts = "NPC";
				$w_money = "100";
			}else{;}#그 외의 NPC는 여기
			$w_comm = "NPC";
			$w_limit = $w_kill = $w_endtime = 0;
			$w_id = ($pref['a_id'] . "$i");
			$w_log = $w_bid = $w_bb = $w_inf = $w_IP = "";
			$w_seikaku = "없음";	#성격 미완성
			$w_sinri = "없음";		#심리 미완성
			$w_teamID = $pref['a_group_id'];	#팀 ID미완성
			$w_teamPass = $pref['a_group_pass'];	#팀 패스
			$w_tactics = $w_ousen = "통상";
			$w_club = 20;
			$w_password = $pref['a_pass_npc'];
			$w_item_get = "없음";
			$w_eff_get = "0";
			$w_itai_get = "0";
			$userlist[$i] = "$w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_com,$w_dmes,$w_bid,$w_club,$w_money,$w_wp,$w_wg,$w_wn,$w_wc,$w_wd,$w_comm,$w_limit,$w_bb,$w_inf,$w_ousen,$w_seikaku,$w_sinri,$w_item_get,$w_eff_get,$w_itai_get,$w_teamID,$w_teamPass,$w_IP,\n";
		}
	}
	$handle = @fopen($pref['user_file'],'w') or ERROR("unable to open user_file");
	if(!@fwrite($handle,implode('',$userlist))){ERROR("unbale to write user_file");}
	fclose($handle);
}if($RESET1){#시간 초기화
	#시간 파일 갱신
	$endtime = $pref['now'] + ($pref['battle_limit']*60*60*24);
	$timelist=$pref['now'].','.$endtime.",\n";
	$handle = @fopen($pref['time_file'],'w') or ERROR("unable to open time_file");
	if(!@fwrite($handle,$timelist)){ERROR("unbale to write time_file");}
	fclose($handle);
}if($RESET2){#학생 번호 초기화
	#학생 번호 파일 갱신
	$memberlist="0,0,0,0,\n";
	$handle = @fopen($pref['class_file'],'w') or ERROR("unable to open ".$pref['class_file']);
	if(!@fwrite($handle,$memberlist)){ERROR("unbale to write class_file");}
	fclose($handle);
}if($RESET3){#금지 에리어 초기화
	global $areadata;
	#금지 에리어 파일 갱신
	#초기화 설정

	$areadata[0] = $res_y.','.$res_m.','.$res_d.','.(int) $res_j.",0\n";#에리어 추가 시각
	$areadata[1] = $ka.",0,\n";#금지 에리어수, 해킹 플래그

	$work = $pref['place'];
	$work2 = $pref['area'];
	$work3 = $pref['arno'];

	$ar = implode('',array_splice($work,0,1));
	$areadata[2] = $ar.',';
	$ar2 = implode('',array_splice($work2,0,1));
	$areadata[3] = $ar2.',';
	$ar3 = implode('',array_splice($work3,0,1));
	$areadata[4] = $ar3.',';
	$temp='';
	for ($i=1; $i<count($pref['place']); $i++){
		$chk = count($work) - 1;$index = rand(0,$chk);
		$ar  = implode('',array_splice($work,$index,1));$areadata[2] = ($areadata[2].$ar.',');
		$ar2 = implode('',array_splice($work2,$index,1));$areadata[3] = ($areadata[3].$ar2.',');
		$ar3 = implode('',array_splice($work3,$index,1));$areadata[4] = ($areadata[4].$ar3.',');
	}

	if(!$RESET12){#지금 초기화
		$res_y = date('Y');
		$res_m = date('n');
		$res_d = date('j');
		$res_j = date('G');
		$res_f = date('i');
		$pre_reg = 0;
	}

	#날씨
	$weth = rand(0,9);
	$areadata[2] = ($areadata[2] . "\n");
	$areadata[3] = ($areadata[3] . "\n");
	$areadata[4] = ($areadata[4] . "\n");
	$areadata[5] = $weth."\n";
	#BR개최 회수UP?
	$BRNUM = rtrim($pref['arealist'][6]);
	if($RESET10){$BRNUM++;}
	$areadata[6] = $BRNUM . "\n";
	$areadata[7] = $pre_reg.','.$res_y.','.$res_m.','.$res_d.','.$res_j.','.(int) $res_f.',0,';

	$handle = @fopen($pref['area_file'],'w') or ERROR('unable to open area_file');
	if(!@fwrite($handle,implode('',$areadata))){ERROR('unbale to write area_file');}
	fclose($handle);
}if($RESET4){#로그의 초기화 및 프로그램 개시 로그 추가
	#Newgame Log
	$loglist = $pref['now'].','.$weth.",,,,,,,,,,NEWGAME,,\n";
	$handle = @fopen($pref['log_file'],'w') or ERROR('unable to open log_file');
	if(!@fwrite($handle,$loglist)){ERROR('unbale to write log_file');}
	fclose($handle);
}if($RESET5){#아이템 로그 초기화
	global $filename;
	$areaitems = array();
	#Del Area Item
	for ($i=0; $i<count($pref['area']); $i++){
		$areaitems[$i]='';
		$filename = $pref['LOG_DIR'].'/'.$i.$pref['item_file'];
		$handle = @fopen($filename,'w') or ERROR("unable to open $filename","퍼미션 에러","adm_res",__FUNCTION__,__LINE__);
		fclose($handle);
	}

	#Put Area Item
	$itemlist = @file($pref['DAT_DIR']."/itemfile.dat") or ERROR("unable to open itemfile");

	for ($i=0;$i<count($itemlist);$i++){
		list($idx,$count,$w_i,$w_e,$w_t,$br) = explode(",",$itemlist[$i]);
		if($idx == 99){
			for ($a=$count; $a>0;$a--){
				$areaitems[rand(0,count($pref['area'])-1)] .= "$w_i,$w_e,$w_t,\n";
			}
		}else{
			$areaitems[$idx] .= str_repeat("$w_i,$w_e,$w_t,\n",$count);
		}
	}

	foreach($areaitems as $area => $items){
		$filename = $pref['LOG_DIR'].'/'.$area.$pref['item_file'];
		$handle = @fopen($filename,'w') or ERROR("unable to open $filename","퍼미션 에러","adm_res",__FUNCTION__,__LINE__);
		if(!@fwrite($handle,$items)){ERROR("unbale to write $filename");}
		fclose($handle);
	}

	//print_r($areaitems);

}if($RESET5){#매점 아이템 초기화
	#매점 파일 갱신
	$baitendata = @file($pref['DAT_DIR']."/item_baiten.dat") or ERROR("unable to open item_baiten");
	$handle = @fopen($pref['baiten_file'],'w') or ERROR("unable to open baiten_file");
	if(!@fwrite($handle,implode('',$baitendata))){ERROR("unbale to write baiten_file");}
	fclose($handle);
}if($RESET6){#총성 로그 초기화
	#총성 로그 파일 갱신
	$null_data[0] = "0,,,,\n";
	$null_data[1] = "0,,,,\n";
	$null_data[2] = "0,,,,\n";
	$null_data[3] = "0,,,,\n";
	$null_data[4] = "0,,,,\n";
	$null_data[5] = "0,,,,\n";
	$handle = @fopen($pref['gun_log_file'],'w') or ERROR("unable to open gun_log_file");
	if(!@fwrite($handle,implode('',$null_data))){ERROR("unbale to write gun_log_file");}
	fclose($handle);
}if($RESET7){#유저 보존 데이터 폴더 삭제
	#global ;
	#유저 보존 데이터 삭제
}if($RESET8){#Flag 파일 갱신
	#FLAG 파일 갱신
	$handle = @fopen($pref['end_flag_file'],'w') or ERROR("unable to open end_flag_file");
	fclose($handle);
}if($RESET9){#Messenger 갱신
	$handle = @fopen($pref['mes_file'],'w') or ERROR("unable to open mes_file");
	fclose($handle);
	$handle = @fopen($pref['member_file'],'w') or ERROR("unable to open memberfile","퍼미션 에러","adm_res",__FUNCTION__,__LINE__);
	fclose($handle);
	$handle = @fopen($pref['end_flag_file'],'w') or ERROR("unable to open end_flag_file");
	fclose($handle);
}
HEAD();
print <<<_HERE_
<center><font color="#FF0000" face="MS P내일 아침" size="6"><span id="BR" style="width:100%;filter:blur(add=1,direction=135,strength=9):glow(strength=5,color=gold); font-weight:700; text-decoration:underline">Administrative Mode</span></font></center>
초기화했습니다.<br>
<br><B><FONT color="#ff0000">>><a href="index.php">HOME</a> >><a href="admin.php">ADMIN</a></b></FONT>
_HERE_;
FOOTER();
}
?>