#!/usr/bin/perl

#require "jcode.pl";
require "br.pl";
require "$lib_file";
require "$lib_file2";
&LOCK;
require "$pref_file";

&DECODE;

if ($mode eq "regist") { &REGIST; }
elsif ($mode eq "info") { &INFO; }
elsif ($mode eq "info2") { &INFO2; }
else { &MAIN; }
&UNLOCK;
exit;

#===============#
# ■ 메인       #
#===============#
sub MAIN {
    if(($limit == "")||($limit == 0)){ $limit = 7; }
    local($t_limit) = ($limit * 3) + 1;

    if (($fl =~ /종료/)||($ar >= $t_limit)){
        &ERROR("프로그램의 접수는 종료되었습니다.<p>다음 프로그램 시작을 기다려주세요.") ;
    }

	#유저리스트 로드
    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    if ($npc_mode){
        if (($userlist - $npc_num) >= $maxmem) {    #최대인원 초과?
            &ERROR("죄송합니다만, 정원($maxmem명) 오버입니다.") ;
        }
    }else{
        if ($#userlist >= $maxmem) {    #최대인원 초과?
            &ERROR("죄송합니다만, 정원($maxmem명) 오버입니다.") ;
        }
    }

	#쿠키 로드 (아이디, 패스워드, 이름, IP), 플레이어 현재 IP 로드
	&CREAD;
	$host = $ENV{'REMOTE_ADDR'};

	#쿠키 IP, 현재 IP와 유저 리스트를 비교 같은 IP가 사망하지 않았다면 중복.
	#사망했다면, 뉴스 파일에서 이름으로 검색 -> 사망시간 취득 후 2시간 지났는지 체크.
	$i=0;
	foreach $i (0..$#userlist) {
		($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist[$i]);
		if (($w_we eq $c_host) || ($w_we eq $host) || (($w_f_name eq $c_f_name) && ($w_l_name eq $c_l_name))) {
			if ( $w_sts ne "사망" ) {
				unless ( ($c_id =~ /$a_id/) && ($a_pass eq $c_password) ) {
					&ERROR("캐릭터의 중복등록은 금지되어 있습니다. 관리자에게 문의하세요.");
				}
			}
			else {
				$de_f_name = $w_f_name;
				$de_l_name = $w_l_name;
			}
		}
    }
	if ($de_f_name && $de_l_name) {
		open(DB,"$log_file") || exit; seek(DB,0,0); @loglist=<DB>; close(DB);
		$i=0;
		foreach $i (0..$#loglist) {
			($gettime,$l_f_name,$l_l_name,$a,$a,$a,$a,$a,$a,$a,$a,$getkind,$l_host)= split(/,/, $loglist[$i]);
			if (($l_f_name eq $de_f_name) && ($l_l_name eq $de_l_name) && ($getkind =~ /DEATH/)) {
				$chktim = $gettime + (1*60*60*2);
				last;
			}
		}
		($sec,$min,$hour,$mday,$month,$year,$wday,$yday,$isdst) = localtime($chktim);
		$year+=1900; $month++;

		if ($chktim > $now) {   # 사망후 2시간 경과했는지 체크
			&ERROR("캐릭터가 사망한 후, 2시간이 지나야 재등록할 수 있습니다.<p>등록가능시간：$year/$month/$mday $hour:$min:$sec");
		}
	}


print "Cache-Control: no-cache\n";
print "Pragma: no-cache\n";
print "Content-type: text/html\n\n";
print <<"_HERE_";
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=euc-kr">
<title>$game</title>
<link rel="stylesheet" type="text/css" href="br.css">
<script language="JavaScript">
	function ch()
	{	
		if (document.wrt.Icon.value!="")
			document.im.src="$imgurl"+document.wrt.Icon.value+".jpg";
		else
			document.im.src="$imgurl"+"noname.gif";
	}
</script>
</HEAD>
<BODY onLoad="ch(); document.wrt.F_Name.focus()">
<CENTER>

<P align="center"><B><FONT color=\"#ff0000\" size=\"+3\">전학수속</FONT></B><BR><BR>
<BR>
『네가 전학생이지? 제가 담임입니다.<BR>
학생들한테는,「잠자리」라고 불리고 있고.<BR>
아, 쓸데없는 이야길 했군.<BR>
<BR>
어쨋든, 여기에 이름과, 성별을 써서,<BR>
제출해 줄래?</P>
<br>

<CENTER>

<table cellpadding=10 cellspacing=0 bgcolor=E0E0E0 border=1>
<tr><td style="color:000000">

<center><font size=4>전학 신청서</font></center><p>

<table cellpadding=2 cellspacing=0 border=1 width=310 align=center>
<tr>
<FORM METHOD="POST" ACTION="$regist_file" name="wrt">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="regist">

<td style="color:000000" width=60>성(姓)</td>
<td><INPUT size="16" type="text" name="F_Name" maxlength="16"></td>

<td rowspan=3 align=center width=100><img src="" name="im" width="70" height="70"><br>

_HERE_
    print "<SELECT onchange=ch()\; name=\"Icon\">\n";
    print "<OPTION value=\"\" selected>- 얼 굴 -</OPTION>\n";
    for ($i=0;$i<$#icon_file + 1;$i++){
	    print "<OPTION value=\"$i\">$icon_name[$i]</OPTION>\n";
    }
    print "</SELECT>\n";
print <<"_HERE_";

</td>
</tr>

<tr><td style="color:000000">이 름</td>
<td><INPUT size="16" type="text" name="L_Name" maxlength="16"></td></tr>

<tr><td style="color:000000">성별</td>
<td><SELECT name="Sex">
<OPTION value="NOSEX" selected>- 성별 -</OPTION>
<OPTION value="남자">남자</OPTION>
<OPTION value="여자">여자</OPTION>
</SELECT>
</td></tr>
</table>

<table width=310><tr><td style="color:000000">
<font class=9>※이름은 한국이나 일본 이름으로, 한자 또는 한글로 써 주세요. 위반시 사망처리합니다.</font><br>
_HERE_
	print "<a href=# onclick=\"window.open(\'$iprefile\',\'Icon\',\'resizable=yes width=550 height=550\')\;return false\">전체 아이콘 보기</a>";
print <<"_HERE_";
</td></tr></table><br>

<table cellpadding=2 cellspacing=0 border=1 width=310 align=center>
<tr><td style="color:000000" width=60>아이디</td><td><INPUT size="8" type="text" name="Id" maxlength="8"></td>
<td style="color:000000" width=60>패스워드</td><td><INPUT size="8" type="text" name="Password" maxlength="8"></td></tr>
</table>

<table width=310><tr><td style="color:000000">
<font class=9>※접속시에 사용하는 아이디와 패스워드입니다.</font>
</td></tr></table><br>

<table cellpadding=2 cellspacing=0 border=1 width=310 align=center>
<tr><td style="color:000000" width=60>대사</td><td colspan=3><INPUT size="32" type="text" name="Message" maxlength="64"></td></tr>
<tr><td style="color:000000" width=60>유언</td><td colspan=3><INPUT size="32" type="text" name="Message2" maxlength="64"></td></tr>
<tr><td style="color:000000" width=60>자기어필</td><td colspan=3><INPUT size="32" type="text" name="Comment" maxlength="64"></td></tr>
</table>

<table width=310><tr><td style="color:000000">
<font class=9>※대사 : 살해시의 대사, 유언 : 사망시 대사,<br>자기어필 : 생존자 리스트에 나오는 코멘트.</font>
</td></tr></table><br>

<center><INPUT type="submit" name="Enter" value="제　출">　<INPUT type="reset" name="Reset" value="새로 쓴다"></center><BR>

</td></FORM></tr></table><p>

</center>

_HERE_

&FOOTER;

}
#==================#
# ■ 등록 처리     #
#==================#
sub REGIST {
	#입력정보 체크
	if ($f_name2 eq '') { &ERROR("성을 입력해 주세요.") ; }
	elsif (length($f_name2) > 8) { &ERROR("성의 글자수가 제한을 넘었습니다. (4글자까지)") ; }
	elsif ((grep /[a-z]|[A-Z]|[0-9]/, $f_name2) == 1) { &ERROR("이름에 영문은 사용할 수 없습니다. (한글 4글자까지)") ; }
	elsif ($f_name2 =~ /\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\=|\\|\_|\+|\||\[|\]|\{|\}|\;|\:|\'|\"|\,|\.|\<|\>|\/|\?/) { &ERROR("성에 사용금지문자가 들어있습니다.") ; }
	elsif ($l_name2 eq '') { &ERROR("이름을 입력해 주세요.") ; }
	elsif (length($l_name2) > 8) { &ERROR("이름의 글자수가 제한을 넘었습니다. (4글자까지)") ; }
	elsif ((grep /[a-z]|[A-Z]|[0-9]/, $l_name2) == 1) { &ERROR("이름에 영문은 사용할 수 없습니다. (한글 4글자까지)") ; }
	elsif ($l_name2 =~ /\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\=|\\|\_|\+|\||\[|\]|\{|\}|\;|\:|\'|\"|\,|\.|\<|\>|\/|\?/) { &ERROR("이름에 사용금지문자가 들어있습니다.") ; }
	elsif ($sex2 eq "NOSEX") { &ERROR("성별을 선택해 주세요.") ; }
	elsif ($icon2 eq "") { &ERROR("아이콘을 선택해 주세요.") ; }
	elsif (length($id2) > 8) { &ERROR("ID의 글자수가 제한을 넘었습니다. (영숫자 8글자까지)") ; }
	elsif ($id2 eq '') { &ERROR("ID가 입력되지 않았습니다.") ; }
	elsif ((grep /[a-z]|[A-Z]|[0-9]/, $id2) == 0) { &ERROR("ID는 영문과 숫자를 사용해 주세요. (영숫자 8글자까지)") ; }
	elsif ($id2 =~ /\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\=|\\|\_|\+|\||\[|\]|\{|\}|\;|\:|\'|\"|\,|\.|\<|\>|\/|\?/) { &ERROR("ID에 사용금지문자가 들어있습니다.") ; }
	elsif ($password2 eq '') { &ERROR("패스워드가 입력되지 않았습니다.") ; }
	elsif (length($password2) > 8) { &ERROR("패스워드의 글자수가 제한을 넘었습니다. (영숫자 8글자까지)") ; }
	elsif ((grep /[a-z]|[A-Z]|[0-9]/, $password2) == 0) { &ERROR("패스워드는 영문과 숫자를 사용해 주세요. (영숫자 8글자까지)") ; }
    elsif ($password2 =~ /\_|\,|\;|\<|\>|\(|\)|&|\/|\./) { &ERROR("패스워드에 사용금지문자가 들어있습니다.") ; }
    elsif ($id2 eq $password2) { &ERROR("ID와 같은 문자열은 패스워드로 사용할 수 없습니다.") ; }
	elsif (length($msg2) > 64) { &ERROR("대사의 글자수가 제한을 넘었습니다. (한글 32글자까지)") ; }
	elsif (length($dmes2) > 64) { &ERROR("유언의 글자수가 제한을 넘었습니다. (한글 32글자까지)") ; }
	elsif (length($com2) > 64) { &ERROR("자기어필의 글자수가 제한을 넘었습니다. (한글 32글자까지)") ; }
    elsif ($icon_check){
        if(($sex2 =~ /남자/)&&($icon2 >= $icon_check )) { &ERROR("성별과 다른 아이콘을 선택했습니다.") ; }
        elsif(($sex2 =~ /여자/)&&($icon2 < $icon_check )){ &ERROR("성별과 다른 아이콘을 선택했습니다.") ; }
    }

    #유저 파일 취득
    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    #동명이인, 동일 아이디 체크
    foreach $userlist(@userlist) {
        ($w_id,$w_password,$w_f_name,$w_l_name,$w_sex,$w_cl,$w_no,$w_endtime,$w_att,$w_def,$w_hit,$w_mhit,$w_level,$w_exp,$w_sta,$w_wep,$w_watt,$w_wtai,$w_bou,$w_bdef,$w_btai,$w_bou_h,$w_bdef_h,$w_btai_h,$w_bou_f,$w_bdef_f,$w_btai_f,$w_bou_a,$w_bdef_a,$w_btai_a,$w_tactics,$w_death,$w_msg,$w_sts,$w_pls,$w_kill,$w_icon,$w_item[0],$w_eff[0],$w_itai[0],$w_item[1],$w_eff[1],$w_itai[1],$w_item[2],$w_eff[2],$w_itai[2],$w_item[3],$w_eff[3],$w_itai[3],$w_item[4],$w_eff[4],$w_itai[4],$w_item[5],$w_eff[5],$w_itai[5],$w_log,$w_dmes,$w_bid,$w_club,$w_wn,$w_wp,$w_wa,$w_wg,$w_we,$w_wc,$w_wd,$w_wb,$w_wf,$w_ws,$w_com,$w_inf) = split(/,/, $userlist);
		if ($id2 eq $w_id) { #동일 아이디
			&ERROR("같은 아이디의 캐릭터가 이미 존재합니다.");
		}
		elsif (($f_name2 eq $w_f_name)&&($l_name2 eq $w_l_name)) { #동명
			&ERROR("같은 이름의 캐릭터가 이미 존재합니다.");
		}
    }

    #지급무기 파일
    open(DB,"$wep_file") || exit; seek(DB,0,0); @weplist=<DB>; close(DB);

    #개인물품 파일
    open(DB,"$stitem_file") || exit; seek(DB,0,0); @stitemlist=<DB>; close(DB);

    #학생 번호 파일
    open(DB,"$member_file") || exit; seek(DB,0,0); $memberlist=<DB>; close(DB);
    ($m,$f,$mc,$fc) = split(/,/, $memberlist);

    #성별 인원 체크
    if ($sex2 eq "남자") {
        if ($mc >= $clmax) { #등록 불가능?
            &ERROR("남학생은 더 이상 등록할 수 없습니다.") ;
        }
        $m+=1;$no=$m;$cl=$clas[$mc];
        if ($m >= $manmax) {    #클래스 새로고침
            $m=0;$mc+=1;
        }
    } else {
        if ($fc >= $clmax) { #등록 불가능?
            &ERROR("여학생은 더 이상 등록할 수 없습니다.") ;
        }
        $f+=1;$no=$f;$cl=$clas[$fc];
        if ($f >= $manmax) {    #클래스 새로고침
            $f=0;$fc+=1;
        }
    }

    #학생 번호 파일 새로고침
    $memberlist="$m,$f,$mc,$fc,\n" ;
    open(DB,">$member_file"); seek(DB,0,0); print DB $memberlist; close(DB);

    #초기배포무기 리스트 취득
    $index = int(rand($#weplist));
    ($w_wep,$w_att,$w_tai) = split(/,/, $weplist[$index]);

    #개인 물품 아이템 리스트 취득
    $index = int(rand($#stitemlist));
    local($st_item,$st_eff,$st_tai) = split(/,/, $stitemlist[$index]);

    #소지품 초기화
    for ($i=0; $i<6; $i++) {
        $item[$i] = "없음"; $eff[$i]=$itai[$i]=0;
    }

    #초기능력
    $att = int(rand(5)) + 8 ;
    $def = int(rand(5)) + 8 ;
    $hit = int(rand(20)) + 90 ;
    $mhit = $hit ;
    $kill=0;
    $sta = $maxsta ;
    $level=1; $exp = $baseexp+$lvinc*$level;
    $death = $msg = "";
    $sts = "정상"; $pls=0;
    $tactics = "보통" ;
    $endtime = 0 ;
    $log = "";
    $dmes = "" ; $bid = "" ; $inf = "" ;

    #초기 아이템&초기배포무기
    $item[0] = "빵<>SH"; $eff[0] = 20; $itai[0] = 2;
    $item[1] = "물<>HH"; $eff[1] = 20; $itai[1] = 2;
    $item[2] = $w_wep; $eff[2] = $w_att; $itai[2] = $w_tai;

    $wep = "맨손<>WP";
    $watt = 0;
    $wtai = "∞" ;

    if ($sex2 eq "남자" ) {
        $bou = "교복<>DBN";
    } else {
        $bou = "세라복<>DBN";
    }
    $bdef = 5;
    $btai = 30;

    $bou_h = $bou_f = $bou_a = "없음" ;
    $bdef_h = $bdef_f = $bdef_a = 0;
    $btai_h = $btai_f = $btai_a = 0 ;

    #탄 또는 화살 지급
    if ($w_wep =~ /<>WG/) { #?
        $item[3] = "탄환<>Y"; $eff[3] = 24; $itai[3] = 1;
        $item[4] = $st_item; $eff[4] = $st_eff; $itai[4] = $st_tai;
    } elsif ($w_wep =~ /<>WA/) {    #矢
        $item[3] = "화살<>Y"; $eff[3] = 24; $itai[3] = 1;
        $item[4] = $st_item; $eff[4] = $st_eff; $itai[4] = $st_tai;
    } else {
        $item[3] = $st_item; $eff[3] = $st_eff; $itai[3] = $st_tai;
    }

    &CLUBMAKE ; #반 작성

	# IP Address & Host name 기록
	local($we) = $ENV{'REMOTE_ADDR'};
	local($wf) = &GetHostName($ENV{'REMOTE_ADDR'});

    #유저 파일
    open(DB,"$user_file");seek(DB,0,0); @userlist=<DB>;close(DB);

    $newuser = "$id2,$password2,$f_name2,$l_name2,$sex2,$cl,$no,$endtime,$att,$def,$hit,$mhit,$level,$exp,$sta,$wep,$watt,$wtai,$bou,$bdef,$btai,$bou_h,$bdef_h,$btai_h,$bou_f,$bdef_f,$btai_f,$bou_a,$bdef_a,$btai_a,$tactics,$death,$msg2,$sts,$pls,$kill,$icon2,$item[0],$eff[0],$itai[0],$item[1],$eff[1],$itai[1],$item[2],$eff[2],$itai[2],$item[3],$eff[3],$itai[3],$item[4],$eff[4],$itai[4],$item[5],$eff[5],$itai[5],$log,$dmes2,$bid,$club,$wn,$wp,$wa,$wg,$we,$wc,$wd,$wb,$wf,$ws,$com2,$inf,\n" ;

    #신규 유저 정보 기록
    push(@userlist,$newuser);
    open(DB,">$user_file"); seek(DB,0,0); print DB @userlist; close(DB);

    #신규추가 로그
    &LOGSAVE("NEWENT") ;


    $id=$id2; $password=$password2;

    &CSAVE ;    #쿠키 저장

&HEADER;

print <<"_HERE_";
<P align="center"><B><FONT color="#ff0000" size="+3">전학수속 종료</FONT></B><BR></P>
<TABLE border="1" width="280" cellspacing="0">
  <TBODY>
    <TR>
      <TD width="60">클래스</TD>
      <TD colspan="3" width="113">$cl</TD>
    </TR>
    <TR>
      <TD>번호</TD>
      <TD colspan="3">$sex2$no번</TD>
    </TR>
    <TR>
      <TD>이름</TD>
      <TD colspan="3">$f_name2 $l_name2</TD>
    </TR>
    <TR>
      <TD>클럽</TD>
      <TD colspan="3">$club</TD>
    </TR>
    <TR>
      <TD>체력</TD>
      <TD>$hit/$mhit</TD>
      <TD>스테미너</TD>
      <TD>$sta</TD>
    </TR>
    <TR>
      <TD>공격력</TD>
      <TD>$att</TD>
      <TD>방어력</TD>
      <TD>$def</TD>
    </TR>
  </TBODY>
</TABLE>
<P align="center"><BR>
_HERE_

    if ($sex2 eq "남자") {
        print "$f_name2 $l_name2군이구나<BR>\n" ;
    } else {
        print "$f_name2 $l_name2양이구나<BR>\n" ;
    }

print <<"_HERE_";

이제 막 전학했지만, 내일은 수학여행이야.<BR>
<BR>
시간에 맞춰서, 늦지 말고 와~!<BR><BR>
<A href="$regist_file?mode=info&Id=$id2&Password=$password2"><B><FONT color="#ff0000" size="+2">수학여행 출발</FONT></B></A><BR>
</P>
_HERE_
&FOOTER;
}

#==================#
# ■ ?明?理      #
#==================#
sub INFO {

&HEADER;

print <<"_HERE_";
<P align="center"><B><FONT color=\"#ff0000\" size=\"+3\">등록종료</FONT></B><BR><BR>
눈을 뜨자, 교실 같은 곳에 있었다. 분명 수학여행에 갔는데...?<BR>
「맞아, 수학여행 가는 버스 안에서 갑자기 졸음이 와서...」<BR>
주위를 둘러보자, 다른 학생들도 있는 것 같다. 자세히 보자, 모두 은색의 목걸이가 채워져 있는 것을 깨달았다.<BR>
자신의 목을 만지자, 차가운 금속의 느낌이 전해져 왔다.<BR>
모두와 같은, 저 은색 목걸이가 채워져 있었다.<BR>
<BR>
갑자기, 앞에 문에서 한사람의 남자가 들어왔다...<BR><BR>
<BR>
『그럼, 설명하겠습니다. 모두 여기에 오게된것은 다름이 아니라...<BR>
오늘, 여러분에게 서로 죽이게 하기 위해서입니다.<BR>
<BR>
반항하거나, 그 목걸이를 벗기거나, 탈출하려고 시도한 경우는 그 자리에서 죽는다고 생각하십시오.<BR>
<BR>
여러분은, 올해의 "프로그램" 대상 클래스로 선택되었습니다.<BR>
<BR>
규칙은 간단합니다. 서로, 죽여주면 되는겁니다.<BR>
반칙은 없습니다.<BR><BR>
아아, 제가 잊었습니다만, 이곳은 섬입니다.<BR>
<BR>
알겠습니까? 여기는 이 섬의 분교입니다.<BR>
저는, 여기에서 계속 있을테니까. 모두 힘내세요, 지켜봐줄테니까.<BR>
<BR>
자, 됐죠. 여길 나가면 어디로 가도 상관없습니다.<BR>
그렇지만, 매일 0시에, 섬 전체에 방송을 합니다. 하루 한번이요.<BR>
<BR>
거기서, 여러분이 가지고 있는 지도에 따라, 몇시부터 이 지역은 위험하다,<BR>
라고 알려줍니다.<BR>
지도를 잘 보고, 나침반과 지형을 참조해,<BR>
신속히 그 지역을 나와 주세요.<BR>
<BR>
어째서냐고 한다면, 그 목걸이가 폭발하기 때문입니다.<BR>
<BR>
알겠습니까. 그러니까, 건물 안에 있어도 안되요.<BR>
굴 속에서 숨어 있어도 전파는 닿습니다.<BR>
아, 그래그래, 생각난 김에. 건물 안에 숨는것은 자유입니다.<BR>
<BR>
아, 그리고 또 하나. 시간제한이 있습니다.<BR>
알겠습니까, 시간제한입니다.<BR>
<BR>
프로그램에서는, 점점 사람이 죽습니다만, 3일 동안 죽은 사람이 아무도 없다면,<BR>
그것으로 끝입니다. 또 몇명 남아 있어도, 컴퓨터가 작동해서, <BR>
남아있는 사람 전원의 목걸이가 폭발합니다. 우승자는 없습니다.<BR>
<BR>
자, 그럼 한명씩, 이 배낭을 가지고 교실을 나가세요.』<BR>
<BR>
<FORM METHOD="POST"  ACTION="$battle_file">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="main">
<INPUT TYPE="HIDDEN" NAME="Id" VALUE="$id2">
<INPUT TYPE="HIDDEN" NAME="Password" VALUE="$password2">
<center>
<INPUT type="submit" name="Enter" value="교실을 나간다">
</center>
</FORM>
_HERE_

&FOOTER;

}

#==================#
# ■ クラブ作成    #
#==================#
sub CLUBMAKE {

    $wa=$wg=$wb=$wc=$wd=$ws=$wn=$wp=0 ;

    local($dice) = int(rand(14)) ;

	if ($dice == 0) {
		$club = "궁도부";
		$wa = $BASE*2;
		$wg = $BASE/2;
	}
	elsif ($dice == 1) {
		$club = "사격부";
		$wg = $BASE*2;
		$wa = $BASE/2;
	}
	elsif ($dice == 2) {
		$club = "검도부";
		$wn = $BASE*2;
		$ws = $BASE/2;
		$wb = $BASE/4;
	}
	elsif ($dice == 3) {
		$club = "펜싱부";
		$ws = $BASE*2;
	}
	elsif ($dice == 4) {
		$club = "태권도부";
		$wp = $BASE*2;
	}
	elsif ($dice == 5) {
		$club = "복싱부";
		$wp = $BASE*2;
	}
	elsif ($dice == 6) {
		$club = "농구부";
		$wc = $BASE*2;
		$wd = $BASE/4;
	}
	elsif ($dice == 7) {
		$club = "배구부";
		$wc = $BASE*2;
		$wd = $BASE/4;
	}
	elsif ($dice == 8) {
		$club = "야구부";
		$wb = $BASE*2;
		$wc = $BASE/2;
		$wd = $BASE/4;
	}
	elsif ($dice == 9) {
		$club = "화학부";
		$wd = $BASE*2;
	}
	elsif ($dice == 10) {
		$club = "육상부";
	}
	elsif ($dice == 11) {
		$club = "연극부";
		local($sel) = int(rand(8));
		@randsel = (0,0,0,0,0,0,0,0);
		$randsel[$sel] = $BASE*2;
		($wa,$wg,$wn,$wb,$ws,$wp,$wc,$wd) = @randsel;
	}
	elsif ($dice == 12) {
		$club = "컴퓨터부";
	}
	elsif ($dice == 13) {
		$club = "요리부";
		$wn = $BASE/2;
	}

}
1
