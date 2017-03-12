<?php
require 'pref.php';
HEAD();
?>
<script type="text/javascript">
<!--
offY = 1;
posY = offY;
function floatMenu(){
	sy = document.body.scrollTop;
	document.menu.style.height = posY;
	movY = sy-posY+offY;
	cY = movY/1.5;
	posY += cY+10;
}
setInterval('floatMenu()',100);
// -->
</script>
<div style="position:absolute;z-index:2;">
<div style="float:left;height:100%;padding-left:24px;">
<img src="./img/spacer.gif" height="10" width="1" name="menu" id="menu" />
<center><b><font size="4">Menus</font></b></center><br>
<a href="#■승리 조건">Winning Conditions</a><br>
<a href="#■참가 가능수">Maximum number of players</a><br>
<a href="#■커멘드 설명">Commands</a><br>
<a href="#■스테이터스 설명">Status</a><br>
<a href="#■아이템 설명">Items</a><br>
<a href="#■아이템 합성">Mix Items</a><br>
<a href="#■클럽 설명">Clubs</a><br>
<a href="#■전투 설명">Battles</a><br>
<a href="#■상처, 상태">Wound/Status</a><br>
<a href="#■기본방침">Modes</a><br>
<a href="#■응전 방침">In-Attack Modes</a><br>
<a href="#■숙련도·숙련 레벨">숙련도·숙련 레벨</a><br>
<a href="#■리밋트·필살기술">리밋트·필살기술</a><br>
<a href="#■금지 에리어">Prohibited Areas</a><br>
<a href="#■날씨">Weather</a><br>
<a href="#■무기">Weapon</a><br>
<a href="#■함정·독">Traps·Poison</a><br>
<a href="#■주의 사항">Precautions·Special Thanx</a><br>
<center><B><a href="index.php">HOME</A></B></center>
</div>
</div>

<div align="left" style="padding-left:192px;position:relative;z-index:1;">
<FONT color="#ff0000"><B><a NAME="■승리 조건">■Winning Conditions</a></B></FONT><BR><BR>
　　일주일간의 기간에 다른 참가자 전원을 넘어뜨려, 끝까지 살아 남는다.<BR><BR>
<FONT color="#ff0000"><B><a name="■참가 가능수">■Maximum number of players</a></B></FONT><BR><BR>
　　남자, 여자 모두<?=$pref['manmax']?>이름을 1 클래스로 해, 최대<?=$pref['clas']?>클래스까지 등록 가능.<BR>
　　사망자도 클래스 메이트로서 계산되므로 주의하는 일.<BR>
<BR>
<FONT color="#ff0000"><B><a name="■커멘드 설명">■Commands</a></B></FONT><BR>
<BR>
<table border="0" cellpadding="0" cellspacing="0"><TR><TD width="20">　</TD>
  <TD width="596">
<table border="1" cellpadding="0" cellspacing="0" width="624">
  <tr>
	<td width="169" align="center" colspan="2">「Go to...」</td>
	<td width="540">현재의 에리어를 떠나 다른 에리어로 이동한다.<B><FONT color="#00ff00">(스태미너 10 전후 소비)</B></font></td>
  </tr><tr>
	<td width="169" align="center" colspan="2">「Explore」</td>
	<td width="540">현재의 에리어를 탐색한다.<br>이벤트나, 다른 플레이어와의 전투의 경우 있어.<B><FONT color="#00ff00">(스태미너 20 전후 소비)</FONT></B></td>
  </tr><tr>
	<td width="32" align="center" rowspan="4">아<br>이<br>테<br>무</td>
	<td width="137" align="center">「Use / Equip Items」</td>
	<td width="540">소지 아이템의 사용, 장비를 실시한다.상, 아이템은<font color="#00FF00"><b>5개</b></font>까지 소지할 수 있다.</td>
  </tr><tr>
	<td width="137" align="center">「Throw Item」</td>
	<td width="540">소지 아이템을 버린다.버린 아이템은 그 에리어에 방치된다.</td>
  </tr><tr>
	<td width="137" align="center">「Organize Item」</td>
	<td width="540">같은 아이템을 모을 수 있다.</td>
  </tr><tr>
	<td width="137" align="center">「Mix Items」</td>
	<td width="540">아이템과 아이템을 합성할 수 있다.자세한 것은 아이템 합성의 항목을 참조.</td>
  </tr><tr>
	<td width="32" align="center" rowspan="3">회<br><br>복</td>
	<td width="137" align="center">「Heal」</td>
	<td width="540">상처의 치료를 해, 체력을 회복한다.<br>치료의 취소해, 콘티 뉴시에, 치료 상태가 해제된다.<B><FONT color="#00ff00">(1분에 1포인트 회복)</FONT></B></td>
  </tr><tr>
	<td width="137" align="center">「Sleep」</td>
	<td width="540">수면을 취해, 스태미너를 회복한다.<br>수면의 취소해, 콘티 뉴시에, 수면 상태가 해제된다.<B><FONT color="#00ff00">(30초에 1포인트 회복)</FONT></B></td>
  </tr><tr>
	<td width="137" align="center">「정양」</td>
	<td width="540">정양을 잡아, 체력과 스태미너 양쪽 모두를 회복한다.<br>수면의 취소해, 콘티 뉴시에, 정양 상태가 해제된다.<B><FONT color="#00ff00"><br>(체력-2분에 1포인트 회복 스태미너-30초에 1포인트 회복)</FONT></B></td>
  </tr><tr>
	<td width="32" align="center" rowspan="8">특<br><br><br>수</td>
	<td width="137" align="center">「Mode」</td>
	<td width="540">자신이 행동할 방침을 결정한다.자세한 것은 기본방침의 항목을 참조.</td>
  </tr><tr>
	<td width="137" align="center">「In-Attack Modes」</td>
	<td width="540">응전시의 행동 방침을 결정한다.자세한 것은 응전 방침의 항목을 참조.</td>
  </tr><tr>
	<td width="137" align="center">「말버릇 변경」</td>
	<td width="540">살해시의 코멘트, 유언, 한마디 코멘트를 변경할 수 있다.</td>
  </tr><tr>
	<td width="137" align="center">「First Aid」</td>
	<td width="540">부상 개소를 치료할 수 있다.<B><FONT color="#00ff00">(스태미너<?=$pref['okyu_sta']?>소비)</FONT></B></td>
  </tr><tr>
	<td width="137" align="center">「Groups」</td>
	<td width="540">그룹에 들어가는 것에 의해서, 그룹 멤버와의 전투는 실시할 수 없지만,<br>아이템을 교환이나, 주는 것이 가능하다.<br>그룹의 작성, 가입, 탈퇴의 작업을 실시할 수 있다.최고<?=$pref['team_max']?>사람까지.</td>
  </tr><tr>
	<td width="137" align="center">「Examine for Poision」</td>
	<td width="540">요리부만이 가능한 커멘드로, 회복 아이템에 독물이 혼입되어 있지 않은가를<br>조사할 수 있다.<B><FONT color="#00ff00">(스태미너 30 소비)</FONT></B></td>
  </tr><tr>
	<td width="137" align="center">「Mix Poison」</td>
	<td width="540">회복 아이템에 독물을 혼입할 수 있다.</td>
  </tr><!--tr>
	<td width="137" align="center">「스피커 사용」</td>
	<td width="540">스피커를 사용하는 것에 의해서, 섬전체의 참가자에게 메세지를 전할 수 있다.</td>
  </tr--><tr>
	<td width="137" align="center">「Hack」</td>
	<td width="540">정부의 컴퓨터에 해킹 해, 오작동을 일으켜 금지 에리어를 전부 해제할 수 있다.</td>
  </tr><tr>
	<td width="169" align="center" colspan="2">「Messages」</td>
	<td width="540">현재 로그인중의 멤버수가 표시되고 있어 서로 연락의 쟁탈이 생긴다.</td>
  </tr>
</table>
</TD></TR></table>
<BR>
<FONT color="#ff0000"><B><a name="■스테이터스 설명">■Status</a></B></FONT><BR>
<BR>
<table border="0" cellpadding="0" cellspacing="0" width="574"><TR><TD width="20">　</TD>
  <TD width="554">
<table border="1" cellpadding="0" cellspacing="0" width="554">
  <tr>
	<td>「클래스」</td>
	<td>소속 클래스</td>
  </tr><tr>
	<td>「Name」</td>
	<td>플레이어명</td>
  </tr><tr>
	<td>「번호」</td>
	<td>성별과 출석 번호</td>
  </tr><tr>
	<td>「Club」</td>
	<td>소속해 있는 클럽.전학시에 자동적으로 배속된다.</td>
  </tr><tr>
	<td>「Level」</td>
	<td>캐릭터의 레벨.상승하면, 최대 체력, 공격력, 방어력이 상승한다.<br>또, 스태미너가<font color="#00FF00"><b>50</b></font>회복한다.</td>
  </tr><tr>
	<td>「EXP」</td>
	<td>캐릭터의 경험치/차레벨에 필요한 경험치.일정치에 이르면, 레벨이 올라간다.<br>타플레이어에의 공격 성공시에 획득할 수 있다.<br>2일째 이후는 일정한 경험치가 있는 상태로부터 시작할 수가 있다.<br>이것은, 2일째 이후의 사람과 생존자를 어느 정도, 평등하게 하기 위한(해)이다.</td>
  </tr><tr>
	<td>「HP」</td>
	<td>플레이어의 체력/최대 체력.0이 되면 캐릭터는 사망한다.</td>
  </tr><tr>
	<td>「Stamina」</td>
	<td>이동, 탐색으로 감소한다.<br>개시시는 최대치<font color="#00FF00"><b>100</font></b>으로, 2일째·3일째에<font color="#00FF00"><b>200</b></font>오름 최대치도 최종적으로는<font color="#00FF00"><b>500</b></font>이 된다.</td>
  </tr><tr>
	<td>「Attack」</td>
	<td>플레이어의 공격력과 무기의 공격력.</td>
  </tr><tr>
	<td>「Weapon」</td>
	<td>현재 장비하고 있는 무기.</td>
  </tr><tr>
	<td>「Defense」</td>
	<td>플레이어의 방어력과 방어구의 방어력.</td>
  </tr><tr>
	<td>「Armor」</td>
	<td>현재 장비하고 있는 방어구와 내구도.<br>데미지를 받을 때마다, 내구도가 줄어 들어, 0이 되면, 방어구가 고장난다.</font></td>
  </tr><tr>
	<td>「Inventory」</td>
	<td>플레이어가 소지하고 있는 소지품 리스트.최대 5까지 소지할 수 있다.</td>
  </tr>
</table>
</TD></TR></table>
<br>
<FONT color="#ff0000"><B><a name="■아이템 설명">■아이템 설명</a></B></FONT><BR><BR>
<table border="0" cellpadding="0" cellspacing="0" width="609"><TR><TD width="20">　</TD>
  <TD width="589">
<table border="1" cellpadding="0" cellspacing="0" width="589">
  <tr>
	<td>Bread</td>
	<td>먹는 일에 의해, 체력을 어느 정도 회복할 수 있다.게임 개시시에, 정부보다 2개 지급된다.</td>
  </tr><tr>
	<td>Water</td>
	<td>마시는 일에 의해, 스태미너를 어느 정도 회복할 수 있다.게임 개시시에, 정부보다 2개 지급된다.</td>
  </tr><tr>
	<td>Mini Radar-</td>
	<td>사용하면, 자신의 에리어에 존재하는 인원수를 알 수 있다.단, 누가 있는지까지는 모른다.</td>
  </tr><tr>
	<td>Radar-</td>
	<td>사용하면, 각 에리어에 존재하는 인원수를 알 수 있다.단, 누가 있는지까지는 모른다.</td>
  </tr><tr>
	<td>Weapons</td>
	<td>게임 개시시에, 랜덤으로 지급된다.타플레이어를 넘어뜨리면, 빼앗을 수가 있다.</td>
  </tr><tr>
	<td>Armors</td>
	<td>장비하는 일에 의해, 몸을 지킬 수가 있다.종류에 의해서, 특정의 무기의 데미지를 반감.<br>단, 골칫거리로 하는 무기도 있어, 그 때는 데미지가 배증한다.</td>
  </tr><tr>
	<td>Others</td>
	<td>이 게임에는, 그 밖에도 다수의 아이템이 존재한다.그 효과 등은 불명하다.</td>
  </tr>
</table>
</TD></TR></table>
　　 ※아이템을 최대수소지시, 아이템을 발견해도, 손에 넣는 일은 할 수 없다.<BR>
<BR>
<FONT color="#ff0000"><B><a name="■아이템 합성">■아이템 합성</a></B></FONT><BR>
<BR>
　　아이템을 합성하는 것에 의해서, 각각을 따로 따로 사용하는 것보다 강한 효력이 있는 아이템을 작성할 수 있다.<br>
　　합성할 수 있는 아이템의 일람은 이하와 같다.<BR>
<BR>
<table border="0" cellpadding="0" cellspacing="0"><TR><TD width="20">　</TD><TD>
<table border="1" cellpadding="0" cellspacing="0" width="274" height="136">
  <tr>
	<td bgcolor="#FFFF00"><b><font color="#000000">합성 소재</font></b></td>
	<td bgcolor="#FFFF00">　</td>
	<td bgcolor="#FFFF00"><b><font size="2" color="#000000">합성 결과</font></b></td>
  </tr><tr>
	<td>경유 + 비료</td>
	<td>→</td>
	<td>화약</td>
  </tr><tr>
	<td>가솔린 &nbsp; 빈병</td>
	<td>→</td>
	<td>☆화염병☆</td>
  </tr><tr>
	<td>신관 + 화약</td>
	<td>→</td>
	<td>☆폭탄☆</td>
  </tr><tr>
	<td>화약 + 도화선</td>
	<td>→</td>
	<td>★다이너마이트★</td>
  </tr><tr>
	<td>스프레이캔 + 라이터</td>
	<td>→</td>
	<td>★간이 화염 방사기★</td>
  </tr><tr>
	<td>휴대 전화 + 파워 북</td>
	<td>→</td>
	<td>모바일 PC</td>
  </tr><tr>
	<td>죽 + 송이버섯</td>
	<td>→</td>
	<td>송이버섯 밥</td>
  </tr><tr>
	<td>카레 + 빵</td>
	<td>→</td>
	<td>카레 빵</td>
  </tr><tr>
	<td>팥소 + 빵</td>
	<td>→</td>
	<td>응</td>
  </tr>
</table>
</TD></TR></table>
　　 (독에서도 무리하게 중화 합니다.)<br>
<BR>
<FONT color="#ff0000"><B><a name="■클럽 설명">■클럽 설명</a></B></FONT><BR>
<BR>
　　각 플레이어는 뭔가의 클럽에 입부하고 있어, 소속해 있는 클럽에 의해서,<BR>
　　게임 개시시에 스테이터스 변동이 일어난다.등록시에 희망하고 싶은 동아리를 선택한다.<br>
　　다만, 반드시 희망한 동아리에 입부할 수 있는 것은 아니지만,<BR>
　　특수, 시즌, 풀·시즌과 입부 확률이 올라 간다<BR>
　　확률은 1할·3할·6할의 순서이다.구<BR>
　　동아리명, 스테이터스 변화·특징, 종류는, 이하와 같다.<br>
<BR>
<table border="0" cellpadding="0" cellspacing="0"><TR><TD width="20">　</TD><TD>
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
	<td align="center" bgcolor="#CCCCCC"><font size="3" color="#000000">동아리명</font></td>
	<td align="center" bgcolor="#CCCCCC"><font size="3" color="#000000">스테이터스 변화</font></td>
	<td align="center" bgcolor="#CCCCCC"><font size="3" color="#000000">특징</font></td>
	<td align="center" bgcolor="#CCCCCC"><font size="3" color="#000000">종류</font></td>
  </tr><tr>
	<td bgcolor="#333333" align="center">가라테부</td>
	<td bgcolor="#333333">구의 숙련도가 20</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">검도부</td>
	<td bgcolor="#333333">검의 숙련도가 20</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">유도부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">공격받았을 때, 반격의 확률이 조금 오른다</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">요리부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">독 봐가 가능 또, 독물 혼입시의 효과가  2배가 된다.</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">아트부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">발견율 향상·선제 공격 향상</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">다도부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">해독제 불요 다만 스태미너를  50필요로 한다</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">락부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">일정한 확률로 사망하지 않고 체력이 1으로 머무는·리밋트가 약간 모임 쉽다</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">오케스트라부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">발견율 향상·방어율 향상</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">자원봉사부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">양도시에 체력·스태미너가 10 회복한다</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">브라스 밴드부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">만남율·회피 향상</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">낚시부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">(식료의 발견율이 향상)</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">코러스부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">동일 에리어의 그룹과의 접촉율 향상</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">장기부</td>
	<td bgcolor="#333333">투의 숙련도가 20</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">후쿠자와유키치 연구회</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">분교·폐교에 있을 때, 방어·공격력 향상</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">서도부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">명중율·방어력 향상</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">바둑부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">선제 공격시의 방어·회피 향상</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">서양 보드부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">발견율 향상</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">ZION</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">회피율 향상</td>
	<td bgcolor="#333333" align="center">풀·시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">농구부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">그룹에 소속시 공격력 상승</td>
	<td bgcolor="#333333" align="center">시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">축구부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">이동·탐색 스태미너 저하·회피율·명중력 UP</td>
	<td bgcolor="#333333" align="center">시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">야구부</td>
	<td bgcolor="#333333">투·구의 숙련도가 10</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333" align="center">시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">테니스부</td>
	<td bgcolor="#333333">총의 숙련도가 20</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333" align="center">시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">수영부</td>
	<td bgcolor="#333333">투의 숙련도가 20</td>
	<td bgcolor="#333333">북쪽의 미사키·미나미의 미사키-정양 가능 분교·폐교시-방어력 저하</td>
	<td bgcolor="#333333" align="center">시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">럭비부</td>
	<td bgcolor="#333333">구의 숙련도가 20</td>
	<td bgcolor="#333333">공격력 향상</td>
	<td bgcolor="#333333" align="center">시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">라크로스부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">(민첩함)·회피율 향상</td>
	<td bgcolor="#333333" align="center">시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">발레부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">진료소에서의 만남율 저하</td>
	<td bgcolor="#333333" align="center">시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">크로스 카운트 리부</td>
	<td bgcolor="#333333">　</td>
	<td bgcolor="#333333">이동 스태미너 저하·방어력 저하</td>
	<td bgcolor="#333333" align="center">시즌</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">방송부</td>
	<td bgcolor="#333333">전숙련도 10</td>
	<td bgcolor="#333333">공격시에 상대에게 말하면 공격율배향상(최고로20% 증가)</td>
	<td bgcolor="#333333" align="center">특수</td>
  </tr><tr>
	<td bgcolor="#333333" align="center">Computer Help Desk</td>
	<td bgcolor="#333333">전숙련도 20</td>
	<td bgcolor="#333333">해킹의 확률 향상</td>
	<td bgcolor="#333333" align="center">특수</td>
  </tr>
</table>
</TD></TR></table>
<br>
<FONT color="#ff0000"><B><a name="■전투 설명">■전투 설명</a></B></FONT><BR>
<BR>
　　에리어 이동시, 또는, 에리어 탐색시에 다른 플레이어에 조우했을 경우, 전투가 된다.<BR>
　　이쪽이 먼저 발견했을 경우, 선제 공격이 가능.<BR>
　　반대로, 상대에게 발견되었을 경우는, 상대의 선제 공격이 된다.<BR>
<BR>
　　전투로 상대를 죽였을 경우, 상대가 가지고 있던 소지품, 무기, 방어구의 몇개의 하나를 빼앗을 수가 있다.<BR>
　　단, 휴식중 등에 습격당하고, 안고지는 일로 했을 경우는, 소지품을 빼앗는 것은 할 수 없다.<br>
<br>
　　전투는, 상대를 발견한 사람의 선제 공격이 된다.자신이 행동하고, 상대를 발견했을 때, 「공격」 「도망친다」 「메세지」를 선택 가능.<BR>
　　또, 「전투」는, 장비하고 있는 무기에 의해, 때리는, 찌르는 등, 무기로 선택 가능한 커멘드가 된다.<BR>
<BR>
<table border="0" cellpadding="0" cellspacing="0"><TR><TD width="20">　</TD><TD>
<table border="1" cellpadding="0" cellspacing="0" width="504">
  <tr>
	<td align="center">「전투」</td>
	<td>상대를 공격한다.반격을 받을 가능성도 있다.<br>우물쭈물 하고 있을 때에, 상대가 도망쳐 버리면, 공격은 불가능이 된다.</td>
  </tr><tr>
	<td align="center">「도망」</td>
	<td>공격하지 않고, 도망한다.경험치, 숙련도를 취득하는 일은 할 수 없다.</td>
  </tr><tr>
	<td align="center">「메세지」</td>
	<td>공격시에, 상대에게 메세지를 보낸다.도망시는 메세지를 보내는 것은 할 수 없다.</td>
  </tr>
</table>
</TD></TR></table>
<br>
<FONT color="#ff0000"><B><a name="■상처, 상태">■상처, 상태</a></B></FONT><BR>
<BR>
　　전투중에, 일정한 확률로 부상을 하는 것이 있다.부상 개소에 의해, 이하의 제한을 받는다.<BR>
　　또, 무기에 의해서 부상 당하는 확률, 장소가 다르다.<BR>
　　특정의 방어구에 따라서는, 상처를 막는 것도 가능하다.<BR>
　　상처를 막는 때 마다, 방어구의 내구도가 저하해, 파손한다.<BR>
<BR>
<table border="0" cellpadding="0" cellspacing="0"><TR><TD width="20">　</TD><TD>
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
	<td>「머리」</td>
	<td>공격의 명중율이 저하.</td>
  </tr><tr>
	<td>「팔」</td>
	<td>공격력이 저하.</td>
  </tr><tr>
	<td>「배」</td>
	<td>수면, 치료시의 회복력이 저하.</td>
  </tr><tr>
	<td>「다리」</td>
	<td>이동, 탐색시의 스태미너 소비 증가.</td>
  </tr><tr>
	<td>「독」</td>
	<td>이동, 검색시의 체력 저하.</td>
  </tr>
</table>
</TD></TR></table>
<br>
　　상처는, 특수 커멘드의 「응급 처치」로 치료할 수가 있다.(한 개소만)<BR>
　　응급 처치에는, 스태미너<?=$pref['okyu_sta']?>(을)를 필요로 한다.<br>
　　단, 독은 중화제가 필요하다.(독의 상세한 것에 대하여는 이하를 참조)<BR>
<BR>
<FONT color="#ff0000"><B><a name="■기본방침">■기본방침</a></B></FONT><BR>
<BR>
<table border="0" cellpadding="0" cellspacing="0" width="663"><TR><TD width="20">　</TD>
  <TD width="643">
<table border="1" cellpadding="0" cellspacing="0" style="border: .75pt solid black; background-color: white; border-collapse:collapse" width="643" height="279">
  <tr>
	<td class="t1" width="56" height="28">방침</td>
	<td class="t2" width="269" height="28"><font size="2" face="MS P고딕">설명</td>
	<td class="t2" width="72" height="28">&nbsp;&nbsp;&nbsp;공격력 &nbsp;&nbsp;&nbsp;</td>
	<td class="t2" width="72" height="28">&nbsp;&nbsp;&nbsp;방어력 &nbsp;&nbsp;&nbsp;</td>
	<td class="t2" width="72" height="28">&nbsp;&nbsp;&nbsp;발견율 &nbsp;&nbsp;&nbsp;</td>
	<td class="t2" width="98" height="28">&nbsp;선제 공격율 &nbsp;</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" width="56" height="40">통상</td>
	<td class="t4" width="269" height="40" style="text-align:left"><br><font color="#FFFFFF">가능도 없고, 불가도 없다.통상에 행동한다.</font><br>　</td>
	<td class="t4" width="72" height="40"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t4" width="72" height="40"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t4" width="72" height="40"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t4" width="98" height="40"><font color="#FFFFFF"><b>　</b></font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" width="56" height="40">공격 중시</td>
	<td class="t5" width="269" height="40" style="text-align:left"><br><font color="#FFFFFF">공격에 중점을 두어 행동한다.</font><br>　</td>
	<td class="t5" width="72" height="40"><font color="#00ffff"><b>↑↑↑</b></font></td>
	<td class="t5" width="72" height="40"><font color="#ffff00"><b>↓↓↓</b></font></td>
	<td class="t5" width="72" height="40"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t5" width="98" height="40"><font color="#FFFFFF"><b>　</b></font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" width="56" height="40">방어 중시</td>
	<td class="t4" width="269" height="40" style="text-align:left"><br><font color="#FFFFFF">방어에 중점을 두어 행동한다.</font><br>　</td>
	<td class="t4" width="72" height="40"><font color="#ffff00"><b>↓↓↓</b></font></td>
	<td class="t4" width="72" height="40"><font color="#00ffff"><b>↑↑↑</b></font></td>
	<td class="t4" width="72" height="40"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t4" width="98" height="40"><font color="#ffff00"><b>↓↓</b></font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" width="56" height="40">은밀 행동</td>
	<td class="t5" width="269" height="40" style="text-align:left"><br><font color="#FFFFFF">적에게 발견되지 않게 은이면서 행동한다.</font><br>　</td>
	<td class="t5" width="72" height="40"><font color="#ffff00"><b>↓↓↓</b></font></td>
	<td class="t5" width="72" height="40"><font color="#ffff00"><b>↓↓</b></font></td>
	<td class="t5" width="72" height="40"><font color="#ffff00"><b>↓↓</b></font></td>
	<td class="t5" width="98" height="40"><font color="#00ffff"><b>↑↑↑</b></font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" width="56" height="40">탐색 행동</td>
	<td class="t4" width="269" height="40" style="text-align:left"><font color="#FFFFFF"><br>탐색하면서 행동한다.</font><br>　</td>
	<td class="t4" width="72" height="40"><font color="#ffff00"><b>↓</b></font></td>
	<td class="t4" width="72" height="40"><font color="#ffff00"><b>↓</b></font></td>
	<td class="t4" width="72" height="40"><font color="#00ffff"><b>↑↑↑</b></font></td>
	<td class="t4" width="98" height="40"><font color="#00ffff"><b>↑↑</b></font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" width="56" height="37">련투행동</td>
	<td class="t5" width="269" height="37" style="text-align:left"><font color="#FFFFFF">3일째 이후 가능한 행동이며,<br>같은 상대에게1/2의 확률로 연속해 공격할 수 있다.<br>단, 상대도 련투행동의 경우는75%가 된다.</td>
	<td class="t5" width="72" height="37"><font color="#ffff00"><b>↓↓</b></font></td>
	<td class="t5" width="72" height="37"><font color="#ffff00"><b>↓↓</b></font></td>
	<td class="t5" width="72" height="37"><font color="#ffff00"><b>↓</b></font></td>
	<td class="t5" width="98" height="37"><font color="#ffff00"><b>↓</b></font></td>
  </tr>
</table>
</TD></TR></table>
<br>
<B><a name="■응전 방침"><font size="2" face="MS P고딕" color="#ff0000">■응전 방침</FONT></a></B><BR>
<BR>
<table border="0" cellpadding="0" cellspacing="0"><TR><TD width="20">　</TD><TD>
<table border="1" cellpadding="0" cellspacing="0" id="AutoNumber8" style="border: .75pt solid black; background-color: white" width="643" height="229">
  <tr>
	<td class="t1" width="56" height="28">방침</td>
	<td class="t2" width="269" height="28">설명</td>
	<td class="t2" width="72" height="28">&nbsp;&nbsp;&nbsp;공격력 &nbsp;&nbsp;&nbsp;</td>
	<td class="t2" width="72" height="28">&nbsp;&nbsp;&nbsp;방어력 &nbsp;&nbsp;&nbsp;</td>
	<td class="t2" width="80" height="28">&nbsp;&nbsp;&nbsp;만남율 &nbsp;&nbsp;&nbsp;</td>
	<td class="t2" width="90" height="28">&nbsp;&nbsp;&nbsp;회피율 &nbsp;&nbsp;&nbsp;</td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" width="56" height="27">통상</td>
	<td class="t4" width="269" height="27" style="text-align:left"><font color="#FFFFFF"><br>가능도 없고, 불가도 없다.통상에 전투.<br>　</font></td>
	<td class="t4" width="72" height="27"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t4" width="72" height="27"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t4" width="90" height="27"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t4" width="80" height="27"><font color="#FFFFFF"><b>　</b></font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" width="56" height="27">공격 몸의 자세</td>
	<td class="t5" width="269" height="27" style="text-align:left"><font color="#FFFFFF"><br>상대를 안고지는 일로 한다.<br>　</font></td>
	<td class="t5" width="72" height="27"><font color="#00ffff"><b>↑↑↑</b></font></td>
	<td class="t5" width="72" height="27"><font color="#ffff00"><b>↓↓↓</b></font></td>
	<td class="t5" width="80" height="27"><font color="#ffff00"><b>↓</b></font></td>
	<td class="t5" width="90" height="27"><font color="#FFFFFF"><b>　</b></font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" width="56" height="27">방어 몸의 자세</td>
	<td class="t4" width="269" height="27" style="text-align:left"><font color="#FFFFFF"><br>방어에 철저하다.<br>　</font></td>
	<td class="t4" width="72" height="27"><font color="#ffff00"><b>↓↓↓</b></font></td>
	<td class="t4" width="72" height="27"><font color="#00ffff"><b>↑↑↑</b></font></td>
	<td class="t4" width="80" height="27"><font color="#00ffff"><b>↑</b></font></td>
	<td class="t4" width="90" height="27"><font color="#FFFFFF"><b>　</b></font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" width="56" height="27">은밀 몸의 자세</td>
	<td class="t5" width="269" height="27" style="text-align:left"><font color="#FFFFFF"><br>적에게 발견되지 않게 은이면서 행동한다.<br>　</font></td>
	<td class="t5" width="72" height="27"><font color="#ffff00"><b>↓↓</b></font></td>
	<td class="t5" width="72" height="27"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t5" width="80" height="27"><font color="#ffff00"><b>↓↓</b></font></td>
	<td class="t5" width="90" height="27"><font color="#FFFFFF"><b>　</b></font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" width="56" height="42">치료 전념</font></td>
	<td class="t4" width="269" height="42" style="text-align:left"><font color="#FFFFFF">어쨌든 상처를 달래기에 전념한다.<br>기습, 반격 불가능.치료에 필요로 하는 시간이 반에.</font></td>
	<td class="t4" width="72" height="42"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t4" width="72" height="42"><font color="#ffff00"><b>↓↓↓</b></font></td>
	<td class="t4" width="80" height="42"><font color="#00ffff"><b>↑</b></font></td>
	<td class="t4" width="90" height="42"><font color="#ffff00"><b>↓↓↓</b></font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" width="56" height="37">도망 몸의 자세</td>
	<td class="t5" width="269" height="37" style="text-align:left"><font color="#FFFFFF">공격받으면 즉시 그 자리로부터 떠난다.<br>또, 그 자리가 금지 에리어가 되어도 떠납니다.<br>기습, 반격 불가능하므로 주의!<br>(련투행동 및 금지 에리어 사망 대처입니다.)</font></td>
	<td class="t5" width="72" height="37"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t5" width="72" height="37"><font color="#ffff00"><b>↓↓</b></font></td>
	<td class="t5" width="80" height="37"><font color="#FFFFFF"><b>　</b></font></td>
	<td class="t5" width="90" height="37"><font color="#ffff00"><b>↓</b></font></td>
  </tr>
</table>
</TD></TR></table>
<font size="2" color="#FF0000">　　※발견율이란, 다른 Player에 발견되는 의미의 일입니다</font><B><font size="2"><br>
<br><FONT color="#ff0000"><a name="■숙련도·숙련 레벨">■숙련도·숙련 레벨</a></font></B><BR>
<BR>
　　사용하는 무기 종별마다 숙련도가 있어, 그 무기로 적을 공격할 때마다 숙련도가 올라 간다.<BR>
　　숙련도는, 공격이 빗나가도, 상승한다.(공격을 하지 않고 도주했을 때는 숙련치를 얻을 수 없다)<BR>
　　숙련도가 일정치에 이르면, 숙련 레벨이 오른다.
<br>
　　숙련 하고 있지 않는 종류의 무기로 전투를 하면, 그 무기의 힘을100% 발휘할 수가 없다.<BR>
　　숙련 한 것이, 무기를 사용하면, 무기가 가지는 힘을 웃도는 효과를 발휘할 것이다.<BR>
<BR>
<B><FONT color="#ff0000"><a name="■리밋트·필살기술">■리밋트</a></font></B><BR>
<BR>
　　공격을 받을 때마다 리밋트치가 올라 간다<BR>
　　100이 된 다음의 전투에서 리밋트 브레이크가 발동한다<BR>
　　자세한 것은 아래의 필살기술을 참조<BR>
<BR>
<FONT color="#ff0000"><B>■필살기술</B></FONT><BR>
<BR>
　　발동 방법은, 전투시의 상대에게 남기는 메세지에 각각 「필살기술」또는, 「초필살기술」이라고 넣는 일로 가능<BR>
　　공격력이 높은 것이 우선된다<BR>
<BR>
<table border="0" cellpadding="0" cellspacing="0"><TR><TD width="20">　</TD><TD>
<table border="1" cellpadding="0" cellspacing="0" style="border: .75pt solid black; background-color: white" height="158">
  <tr>
	<td class="t1" height="28">필살기술의 종류</td>
	<td class="t2" height="28">발동 형식</td>
	<td class="t2" height="28">조건</td>
	<td class="t2" height="28">효과</td>
	<td class="t2" height="28">공격력</td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" height="1"><br>위기 히트<br>　</td>
	<td class="t4" height="1"><font color="#FFFF00">자동</font></td>
	<td class="t4" height="1"><font color="#FFFFFF">레벨<B><font color="#00ff00">3</font></B>이상<br>숙련도가<B><font color="#00ff00">20</font></B>이상</font></td>
	<td class="t4" height="1"><font color="#FFFFFF">선공·후공때에 일정한 확률로 자동적으로 발동</font></td>
	<td class="t4" height="1"><font color="#0000FF">★☆☆☆☆</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" height="1"><br>필살기술<br>　</td>
	<td class="t5" height="1"><font color="#00FFFF">임의</font></td>
	<td class="t5" height="1"><font color="#FFFFFF">숙련도가<B><font color="#00ff00">40</font></B>이상</font></td>
	<td class="t5" height="1"><font color="#FFFFFF">리밋트<B><font color="#00ff00">15</font></b>사용<br>및, 최대 체력의<B><font color="#00ff00">10%</font></B>정도의 체력을 소비해 최대 체력의6% 정도를 공격력에 추가</font></td>
	<td class="t5" height="1"><font color="#0000FF">★★☆☆☆</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" height="1"><br>초필살기술<br>　</td>
	<td class="t4" height="1"><font color="#00FFFF">임의</font></td>
	<td class="t4" height="1"><font color="#FFFFFF">숙련도가<B><font color="#00ff00">100</font></B>이상<br>체력이<B><font color="#00ff00">100</font></B>이하</font></td>
	<td class="t4" height="1"><font color="#FFFFFF">리밋트<B><font color="#00ff00">30</font></b>사용<br>및, 최대 체력을<B><font color="#00ff00">10%</font></B>정도 소비해 최대 체력의10% 정도를 공격력에 추가</font></td>
	<td class="t4" height="1"><font color="#0000FF">★★★☆☆</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" height="1"><br>비장의 기술<br>　</td>
	<td class="t5" height="1"><font color="#FFFF00">자동</font></td>
	<td class="t5" height="1"><font color="#FFFFFF">레벨<B><font color="#00ff00">10</font></B>이상<br>숙련도가<B><font color="#00ff00">200</font></B>이상</font></td>
	<td class="t5" height="1"><font color="#FFFFFF">선공·후공때에 일정한 확률로 자동적으로 발동</font></td>
	<td class="t5" height="1"><font color="#0000FF">★★★★☆</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" height="1"><br>리밋트 브레이크<br>　</td>
	<td class="t4" height="1"><font color="#FFFF00">자동</font></td>
	<td class="t4" height="1"><font color="#FFFFFF">리밋트가<B><font color="#00ff00">100</font></B>이상만</font></td>
	<td class="t4" height="1"><font color="#FFFFFF">리밋트가<B><font color="#00ff00">100</font></B>이상의 경우만 발동<BR>선공·후공때에 자동적으로 발동</font></td>
	<td class="t4" height="1"><font color="#0000FF">★★★★★</font></td>
  </tr>
  </table>
</TD></TR></table>
<br>
<FONT color="#ff0000"><B><a name="■금지 에리어">■금지 에리어</a></B></FONT>
<BR><BR>
　　Every 8 hours,<i>(00:00, 8:00, 16:00)</i>, a new prohibited area is added.<br>
　　When a player stay at prohibited area, collar will explode according to the rule.<BR>
<BR>
<FONT color="#ff0000"><B><a name="■날씨">■날씨</a></B></FONT><BR>
<BR>
　　Upon announcement of new prohibited area, weather condition will change.<br>
　　According to the weather condition, changes in many attributes will occur.<br>
　　기본적으로 미미한 변화이기 위해 최대2할 정도의 변화가 기후에 의해서 영향을 받는다.<br>
　　기후가 안개때, 일정한 확률로 상대가 확인할 수 없는 경우가 있다.<br>
　　이 경우, 같은 그룹 멤버라도 공격이 가능하게 되므로, 조심할 필요가 있다.<br>
<br>
</font>
<table border="0" cellpadding="0" cellspacing="0"><TR><TD width="20">　</TD><TD>
<table border="1" cellpadding="0" cellspacing="0" style="border: .75pt solid black; background-color: white; border-collapse:collapse">
  <tr>
	<td class="t1" height="22" width="70">날씨</td>
	<td class="t2">&nbsp;공격력 &nbsp;</td>
	<td class="t2">&nbsp;방어력 &nbsp;</td>
	<td class="t2">&nbsp;회피율 &nbsp;</td>
	<td class="t2">&nbsp;발견율 &nbsp;</td>
	<td class="t2">&nbsp;시야 &nbsp;</td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" height="22" width="70">「쾌청」</td>
	<td class="t4"><font color="#0000FF">격강</font></td>
	<td class="t4"><font color="#0000FF">격강</font></td>
	<td class="t4"><font color="#0000FF">격강</font></td>
	<td class="t4"><font color="#0000FF">격강</font></td>
	<td class="t4"><font color="#0000FF">고</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" height="22" width="70">「개여」</td>
	<td class="t5"> <font color="#00FFFF">강</font></td>
	<td class="t5"> <font color="#00FFFF">강</font></td>
	<td class="t5"><font color="#00FFFF">강</font></td>
	<td class="t5"><font color="#00FFFF">강</font></td>
	<td class="t5"><font color="#0000FF" >고</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" height="22" width="70">「흐림」</td>
	<td class="t4"><font color="#FFFFFF">무</font></td>
	<td class="t4"><font color="#FFFFFF">무</font></td>
	<td class="t4"><font color="#FFFFFF">무</font></td>
	<td class="t4"><font color="#FFFFFF">무</font></td>
	<td class="t4"><font color="#0000FF" >고</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" height="23" width="70">「비」</td>
	<td class="t5"> <font color="#00FF00">미약</font></td>
	<td class="t5"> <font color="#00FF00">미약</font></td>
	<td class="t5"><font color="#00FF00">미약</font></td>
	<td class="t5"><font color="#00FF00">미약</font></td>
	<td class="t5"><font color="#00FF00">미저</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" height="23" width="70">「호우」</td>
	<td class="t4"><font color="#00FF00">미약</font></td>
	<td class="t4"><font color="#00FF00">미약</font></td>
	<td class="t4"><font color="#00FF00">미약</font></td>
	<td class="t4"><font color="#00FF00">미약</font></td>
	<td class="t4"><font color="#FFFF00" >저</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" height="23" width="70">「태풍」</td>
	<td class="t5"><font color="#00FF00">미약</font></td>
	<td class="t5"><font color="#00FF00">미약</font></td>
	<td class="t5"><font color="#00FF00">미약</font></td>
	<td class="t5"><font color="#00FF00">미약</font></td>
	<td class="t5"><font color="#FFFF00" >저</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" height="23" width="70">「뇌우」</td>
	<td class="t4"><font color="#00FF00">미약</font></td>
	<td class="t4"><font color="#FFFF00">약</font></td>
	<td class="t4"><font color="#FFFF00">약</font></td>
	<td class="t4"><font color="#00FF00">미약</font></td>
	<td class="t4"><font color="#FFFF00" >저</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" height="23" width="70">「눈」</td>
	<td class="t5"><font color="#FFFF00">약</font></td>
	<td class="t5"><font color="#FFFF00">약</font></td>
	<td class="t5"><font color="#00FF00">미약</font></td>
	<td class="t5"><font color="#FFFF00">약</font></td>
	<td class="t5"><font color="#00FF00" >미저</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#CCCCCC" height="23" width="70">「안개」</td>
	<td class="t4"><font color="#FFFFFF">무</font></td>
	<td class="t4"><font color="#00FF00">격약</font></td>
	<td class="t4"><font color="#FF00FF">미강</font></td>
	<td class="t4"><font color="#FFFF00">약</font></td>
	<td class="t4"><font color="#FF00FF" >격저</font></td>
  </tr><tr>
	<td class="t3" bgcolor="#999999" height="23" width="70">「농무」</td>
	<td class="t5"><font color="#FF00FF">미강</font></td>
	<td class="t5"><font color="#00FF00">격약</font></td>
	<td class="t5"><font color="#FFFFFF">무</font></td>
	<td class="t5"><font color="#FFFF00">약</font></td>
	<td class="t5"><font color="#FF0000">초저</font></td>
  </tr>
  </table>
</TD></TR></table>
<BR>
<FONT color="#ff0000"><B><a name="■무기">■무기</a></B></FONT><BR>
<BR>
　　총계의 무기는, 탄환을 장전 하지 않으면, 둔기로서 밖에 이용 할 수 없다.<BR>
　　탄환은, 6발까지 장전 가능.<BR>
　　무기는, 일정한 확률로 망가지는 것이 있다.<BR>
　　망가진 무기는 두 번 다시 쓸모가 있지 않고, 맨손으로 싸우지 않으면 안 된다.<BR>
　　던져 공격하는 타입의 무기는, 내던진 후, 망가져 버리므로, 소모품이 된다.<BR>
<BR>
　　「검」계 무기는, 일정한 확률로 칼날 넘쳐 흐름을 부흥, 공격력이 저하되어 간다.<BR>
　　특정의 아이템으로 손질을 하는 일에 의해 공격력은 증가한다.<BR>
<BR>
<FONT color="#ff0000"><B><a name="■함정·독">■함정·독</a></B></FONT><BR>
<BR>
　　어느 아이템을 사용하는 것으로, 에리어에 함정을 걸 수 있다.<BR>
　　또, 회복계의 아이템에는 독이 포함되어 있는 경우가 있다.<BR>
　　함정·독에 의해 데미지는 가변으로, 스스로 건 함정·독에, 자신이 걸릴 가능성도 있으므로,<BR>
　　함정·독의 설치에는, 주의가 필요하다.<br>
<BR>
　　상, 독은 응급 처치에서는 회복할 수 없기 때문에 「해독제」라고 하는 아이템을 찾아내는 필요성이 있다.<br>
<BR>
<FONT color="#ff0000"><B><a name="■주의 사항">■주의 사항</a></B></FONT><BR>
<BR>
　　개시 후, 분교에 대기하고 있으면, 금지 에리어 추가시에 목걸이가 폭발해, 사망하므로, 분교에서의 대기는 생명 위기가 된다.<BR>
<BR>
　　한 번 공격한 상대에게는, 그 상대가 커멘드를 실행할 때까지, 혹은,<BR>
　　상대가 다른 플레이어에 공격을 받을 때까지는, 재차 공격할 수가 없다.<BR>
<br>
　　이틀눈 이후는 일정한 경험치가 있는 상태로부터 시작할 수가 있다.<br>
　　이것은, 이틀눈 이후의 사람과 생존자를 어느 정도, 평등하게 하기 위한(해)이다.<br>
<BR>
<FONT color="#ff0000"><B><a name="■Special Thanx">■Special Thanx</a></B></FONT><BR>
<BR>
　　이 BRU를 만드는에 있던 지 얼마 안되는 협력해 주신 작자 및 Web 사이트<BR>
<br>
<table border="0" cellpadding="0" cellspacing="0"><TR><TD width="20">　</TD><TD>
<TABLE border="0" cellspacing="0" cellpadding="0">
<TR>
  <TD><B><U>Site Name</U></B></TD>
  <TD align="center">　</TD>
  <TD>　<B><U>Name</U></B></TD>
  <TD>　<B><U>Thanx for</U></B></TD>
</TR><TR>
  <TD><b><font color="#FFFF00">Battle Royale 본가</font></b></TD>
  <TD align="center">―</TD>
  <TD><font color="#00FF00">　바커스님</font></TD>
  <TD><font color="#00FFFF">　BR의 스크립트의 배포를 받았습니다.<BR>　이전에는 BR의 본가가 운영되고 있었습니다.</font></TD>
</TR><TR>
  <TD><b><a href="http://www.hoops.ne.jp/~kurisutof/"><font color="#FFFF00">투명한 왕국</font></a></b></TD>
  <TD align="center"><font size="2" face="MS P고딕">―</font></TD>
  <TD><font color="#00FF00">　크리스토프님</font></TD>
  <TD><font color="#00FFFF">　개조때 참고가 된 사이트입니다.<br>　또, 메신저의 기본 기능도 여기를 참고로 했습니다.</font></TD>
</TR>
<TR>
  <TD>　</TD>
  <TD width="47" align="center">　</TD>
  <TD>　</TD>
  <TD>　</TD></TR>
</TABLE>
</TD></TR></table>
</div>
<?
FOOTER();
?>