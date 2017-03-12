<?php
#□■□■□■□■□■□■□■□■□■□■□
#■ 	 -    BR EVENT DISPLAY    - 	 ■
#□ 									 □
#■ 		  써브루틴 일람  		 ■
#□ 									 □
#■ EVENT		-		이벤트 처리	 ■
#■□■□■□■□■□■□■□■□■□■□■
#=================#
# ■ 이벤트 처리 #
#=================#
function EVENT(){
global $pref,$in;

global $hit,$sta,$sts,$pls,$log,$inf,$limit,$chksts,$money,$level;
$old_hit = $hit;
$dice = rand(1,5);//확립
$dice2 = rand(5,(8+round($level/5)));//데미지
$in['Command'] = 'MAIN';
if(rand(1,5) > 1){return;}

if($pls == 0){#분교

}elseif($pls == 1){#북의 미사키
	$log .= '문득, 하늘을 올려보면, 까마귀의 무리다!<BR>';
	if($dice == 2){
		$log .= '까마귀에 습격당해 머리를 부상했다!<BR>';
		$inf = str_replace('머리','',$inf);
		$inf .= '머리';
	}elseif($dice == 3){
		$log .= '까마귀에 습격당해<font color="red"><b>'.$dice2.'데미지</b></font> 를 받았다!<BR>';
		$hit-=$dice2;
	}else{
		$log .= ', 어떻게든 격퇴했다…<BR>';
	}
	$chksts='OK';
}elseif($pls == 2){#키타무라 주택가
}elseif($pls == 3){#키타무라 동사무소
}elseif($pls == 4){#우체국
}elseif($pls == 5){#소방서
}elseif($pls == 6){#칸논도우
	$log .= '새전상자다!적셔 째, 안에 무엇인가 들어 있을까?<BR>';
	if($dice == 2){
		$log .= '통!녹슨 못이 팔에 박혀, 팔을 부상했다!<BR>';
		$inf = str_replace('팔','',$inf);
		$inf .= '팔';
	}elseif($dice == 3){
		$log .= '통!녹슨 못이 팔에 박혀,<font color="red"><b>'.$dice2.'데미지</b></font> 를 받았다!<BR>';
		$hit-=$dice2;
	}elseif($dice == 4 && $dice2 == 5){
		$money_found=round(1,20);//100엔 2000엔
		$log .= '럭키!'.($money_found*$pref['money_base']).'엔 찾아냈다.<br>';
		$money += $money_found;
	}else{
		$log .= '아무것도 들어 있지 않았다….<BR>';
	}
	$chksts='OK';
}elseif($pls == 7){#시미즈 연못
	$log .= '끝낸, 발이 미끄러졌다!<BR>';
	if($dice <= 3){
		$dice2 += 10;
		if($sta <= $dice2){
			$dice2 = $sta;$dice2--;
		}
		$sta-=$dice2;
		$log .= '연못안에 낙하했지만, 어떻게든 겼다!<BR>스태미너를 <font color="red"><b>'.$dice2.'</b></font> 소비했다!<BR>';
	}else{
		$log .= ', 어떻게든 떨어지지 않고 끝났다….<BR>';
	}
	$chksts='OK';
}elseif($pls == 8){#니시무라 신사
}elseif($pls == 9){#호텔자취
}elseif($pls == 10){#산악 지대
	$log .= '끝낸, 토사 붕괴다!<BR>';
	if($dice == 2){
		$log .= '어떻게든 주고 받았지만, 낙석으로 다리를 부상했다!<BR>';
		$inf = str_replace('다리','',$inf);
		$inf .= '다리';
	}elseif($dice == 3){
		$log .= '낙석에 의해,<font color="red"><b>'.$dice2.'데미지</b></font> 를 받았다!<BR>';
		$hit-=$dice2;
	}else{
		$log .= ', 어떻게든 주고 받았다….<BR>';
	}
	$chksts='OK';
}elseif($pls == 11){#터널
	$log .= '문득, 약점을 이용하면, 녹슨 못이 떨어지고 있었다!<BR>';
	if($dice == 2){
		$log .= '녹슨 못이 다리에 박혀, 다리를 부상했다!<BR>';
		$inf = str_replace('다리','',$inf);
		$inf .= '다리';
	}elseif($dice == 3){
		$log .= '녹슨 못이 다리에 박혀,<font color="red"><b>'.$dice2.'데미지</b></font> 를 받았다!<BR>';
		$hit-=$dice2;
	}else{
		$log .= ', 조심해 걷지 않으면….<BR>';
	}
	$chksts='OK';
}elseif($pls == 12){#니시무라 주택가
	$log .= '문득, 하늘을 올려보면, 까마귀의 무리다!<BR>';
	if($dice == 2){
		$log .= '까마귀에 습격당해 머리를 부상했다!<BR>';
		$inf = str_replace('머리','',$inf);
		$inf .= '머리';
	}elseif($dice == 3){
		$log .= '까마귀에 습격당해<font color="red"><b>'.$dice2.'데미지</b></font> 를 받았다!<BR>';
		$hit-=$dice2;
	}else{
		$log .= ', 어떻게든 격퇴했다….<BR>';
	}
	$chksts='OK';
}elseif($pls == 13){#절
	$log .= '새전상자다!적셔 째, 안에 무엇인가 들어 있을까?<BR>';
	if($dice == 2){
		$log .= '통!녹슨 못이 팔에 박혀, 팔을 부상했다!<BR>';
		$inf = str_replace('팔','',$inf);
		$inf .= '팔';
	}elseif($dice == 3){
		$log .= '통!녹슨 못이 팔에 박혀,<font color="red"><b>'.$dice2.'데미지</b></font> 를 받았다!<BR>';
		$hit-=$dice2;
	}elseif($dice == 4 && $dice2 == 5){
		$money_found=round(1,20);//100엔 2000엔
		$log .= '럭키!'.($money_found*$pref['money_base']).'엔 찾아냈다.<br>';
		$money += $money_found;
	}else{
		$log .= '아무것도 들어 있지 않았다….<BR>';
	}
	$chksts='OK';
}elseif($pls == 14){#폐교
}elseif($pls == 15){#미나미무라 신사
}elseif($pls == 16){#삼림 지대
	$log .= '갑자기, 들개가 덤벼 들어 왔다!<BR>';
	if($dice == 2){
		$log .= '팔을 물려 팔을 부상했다!<BR>';
		$inf = str_replace('팔','',$inf);
		$inf .= '팔';
	}elseif($dice == 3){
		$log .= '들개에 습격당해<font color="red"><b>'.$dice2.'데미지</b></font> 를 받았다!<BR>';
		$hit-=$dice2;
	}else{
		$log .= ', 어떻게든 격퇴했다….<BR>';
	}
	$chksts='OK';
}elseif($pls == 17){#겐지로우 연못
	$log .= '끝낸, 발이 미끄러졌다!<BR>';
	if($dice <= 3){
		$dice2 += 10;
		if($sta <= $dice2){
			$dice2 = $sta;$dice2--;
		}
		$sta-=$dice2;
		$log .= '연못안에 낙하했지만, 어떻게든 겼다!<BR>스태미너를 <font color="red"><b>'.$dice2.'</b></font> 소비했다!<BR>';
	}else{
		$log .= ', 어떻게든 떨어지지 않고 끝났다….<BR>';
	}
	$chksts='OK';
}elseif($pls == 18){#미나미무라 주택가
	$log .= '문득, 하늘을 올려보면, 까마귀의 무리다!<BR>';
	if($dice == 2){
		$log .= '까마귀에 습격당해 머리를 부상했다!<BR>';
		$inf = str_replace('머리','',$inf);
		$inf .= '머리';
	}elseif($dice == 3){
		$log .= '까마귀에 습격당해<font color="red"><b>'.$dice2.'데미지</b></font> 를 받았다!<BR>';
		$hit-=$dice2;
	}else{
		$log .= ', 어떻게든 격퇴했다….<BR>';
	}
	$chksts='OK';
}elseif($pls == 19){#진료소
	$log .= '통!주사바늘이다…<BR>';
	if($dice == 2){
		$log .= '팔을 부상했다!<BR>';
		$inf = str_replace('팔','',$inf);
		$inf .= '팔';
	}elseif($dice == 3){
		$log .= '　<font color="red"><b>'.$dice2.'데미지</b></font> 를 받았다!<BR>';
		$hit-=$dice2;
	}else{
		$log .= '상처는 대단한 것도 아닌데….<BR>';
	}
	$chksts='OK';
}elseif($pls == 20){#등대
}elseif($pls == 21){#남의미사키
}

#사망 처리
if($hit <= 0){
	global $f_name,$l_name,$cl,$sex,$no;
	$hit = $mhit = 0;
	$log .= '<font color="red"><b>'.$f_name.' '.$l_name.'('.$cl.' '.$sex.$no.'차례)는 사망했다.</b></font><br>';

	#사망 로그
	LOGSAVE('DEATH');
	$in['Command'] = 'EVENT';
}

if($old_hit != $hit){$limit++;}
}
?>