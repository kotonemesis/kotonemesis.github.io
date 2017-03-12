<?php
########################################
## BATTLE ROYALE ULTIMATE PHP SCRIPT  ##
##  (C) 2008 by 2Y -Yuta Yamashita-   ##
##  E-MAIL: info@b-r-u.net            ##
##  MSN:    yuta@users.sourceforge.jp ##
##  Yahoo:  YutaYama2Y                ##
##  ICQ:    280839763                 ##
##  HP:     http://www.b-r-u.net/     ##
##■ 게임 버젼※변경 엄금※     ##
#$pref['ver'] = 'V01.19';             ##
#$pref['ver2y'] = '4.24';             ##
$pref['ver'] = 'V01.19en';              ##
$pref['ver2y'] = '2.51en';              ##
##################################################
## BATTLE ROYALE CGI                            ##
##   (C) 2000 by Happy Ice.                     ##
##   E-MAIL: webmaster@happy-ice.com            ##
##   HomePage: http://www.happy-ice.com/battle/ ##
#######################################################################################################
##+----[주의 사항]-----------------------------------------------------------------------------------+##
##| 1. 이 스크립트를 사용해 도미 가나손해에 대해서 작자는 일절의 책임을 지지 않습니다.                   |##
##|                                                ~~~~~~~~~~~~~~~~~~~~~~~~~~~~                     |##
##| 2. 표시때의 TAB는 4 스페이스입니다.TeraPad등의 텍스트 편집 프로그램으로 설정해 주세요.      |##
##|              ~~~~~~~~~~~~~~                                                                     |##
##| 3. 설치에 관한 질문·개조에 관한 질문은 서포트 게시판에 부탁드리겠습니다.                       |##
##|      메일에 의한 질문에는 대답할 수 없습니다만, MSN에 의한 질문에도 답할 수 있습니다.                    |##
##|                                              ~~~                                                |##
##| 4. 초보적인 질문에 대해서는, 당홈 페이지에서 간단하게 설명되어 있습니다.                       |##
##|    ~~~~~~~~~~~~                                                                                 |##
##| 5. 버그 보고, 또는 요망등이 있으시면, 홈 페이지의 관리인 게시판에 써 주세요.       |##
##|                                                                                         - 2Y -  |##
##+-------------------------------------------------------------------------------------------------+##
#######################################################################################################

#------- 기본 설정 ---------

#■ 게임 타이틀
$pref['game'] = '■ BATTLE ROYALE ULTIMATE ■ (Ver'.$pref['ver2y'].') ['.$pref['ver'].']';
#■ 톱 페이지
#	연락처(PC,휴대)
$pref['contact'] = array('<font color="red">E-mail</font> - <u>bradmin@tomodachi.rf.gd</u>　　<font color="red">Forum</font> - <u>http://tomodachi-anime.forumotion.com/</u>','<font color="red">E-mail</font> - <u>bradmin@tomodachi.rf.gd</u>');
#	연락 사항
$pref['information'] = 'Now you can pre-register! You can also use your mobile device.';
#	카운터(카운터를 톱 페이지의 상부에 표시하는 경우는 입력)
$pref['counter'] = '';

#------- 관리인 설정 ---------

#■ 관리자 ID＆패스워드
#	유저 로그 붕괴의 원인이 되므로, 「,」(콤마)은 사용하지 마세요.
$pref['a_id'] = 'Kotori';# NPC 사용시의 ID;.
$pref['a_pass'] = 'Unicorn98';
$pref['a_pass_npc'] = 'Unicorn98';#병사의 패스워드
$pref['a_group_id'] = 'Otonokizaka';#병사의 그룹명
$pref['a_group_pass'] = 'Unicorn98';#병사의 그룹 패스워드


#------- 파일 설정 ---------

#■ 디렉토리(최후는/으로 닫지 않습니다)
#	데이터 들여다 봐 방지를 위해 반드시 변경해 주세요.
$pref['LOG_DIR'] = './log';
$pref['DAT_DIR'] = './dat';
$pref['LIB_DIR'] = './lib';
#■ 링크 앞( 각 CGI에의 링크·추가 가능)
#	스테이터스 화면상부에 표시되는 링크입니다.
$pref['links'] = '<A href="index.php">>>Home</A><A href="rule.php" target="_blank">>>Guide</A><A href="rank.php" target="_blank">>>Survivor</A><A href="map.php" target="_blank">>>Map</A><A href="news.php" target="_blank">>>Progress</A><A href="../patio/" target="_blank">>>Message Board (Not functional)</A><A href="../yybbs/" target="_blank">>>Message Board (Not functional)</A><A href="../patio/?mode=view&no=28" target="_blank">>><u>Report Bugs</u></A><A href="winner.php">>>Winner Record</A><A href="admin.php">>>Admin</A>';
#■ 개별 백업(미사용)
#$pref['u_save_dir'] = $pref['LOG_DIR'].'/users/'; #유저 개별 백업 디렉토리
#$pref['u_save_file'] = '_back.log'; #ID에 부가하는 문자열
#■ 유저 파일
#	데이터 들여다 봐 방지를 위해 $pref['LOG_DIR']/ 이하는 반드시 변경해 주세요.
$pref['user_file'] = $pref['LOG_DIR'].'/userdatfile.log';
$pref['back_file'] = $pref['LOG_DIR'].'/userbackfile.log';
#■ 관리용 파일
$pref['admin_file'] = $pref['LOG_DIR'].'/admin.log';
#■ 우승자 보존 파일
$pref['win_file'] = $pref['LOG_DIR'].'/win.log';
#■ 로그 파일
$pref['log_file'] = $pref['LOG_DIR'].'/newsfile.log';
#■ 락 파일명
$pref['lockf'] = './lock/dummy.txt';
#■ 파일 락 형식(미사용)
#	→ 0=no 1=symlink 함수 2=mkdir 함수 3=Tripod용
#	로컬 테스트시에는 mkdir 함수를, 서버에 올라갈 때는 사용 가능하면
#	symlink 함수를 사용하도록(듯이) 합니다.
#$pref['lkey'] = 1;
#■ 클래스 파일
$pref['class_file'] = $pref['LOG_DIR'].'/classfile.log';
#■ 금지 에리어 파일
$pref['area_file'] = $pref['LOG_DIR'].'/areafile.log';
#■ 지급 무기 파일
$pref['wep_file'] = $pref['DAT_DIR'].'/wepfile.dat';
#■ 사유물 아이템 파일
$pref['stitem_file'] = $pref['DAT_DIR'].'/stitemfile.dat';
#■ 매점 아이템 파일
$pref['baiten_file'] = $pref['LOG_DIR'].'/baiten.log';
#■ 취득 아이템 파일
$pref['item_file'] = 'itemfile.log';
#■ 시간관리 파일
$pref['time_file'] = $pref['LOG_DIR'].'/timefile.log';
#■ 총성 로그 파일
$pref['gun_log_file'] = $pref['LOG_DIR'].'/gunlog.log';
#■ 종료 플래그
$pref['end_flag_file'] = $pref['LOG_DIR'].'/e_flag.log';


#------- 기본 배열 설정 ---------

#■ 이용 가능 언어
$pref['language'] = array('ja','en','kr');
#■ 날씨
$pref['weather'] = array('Very Clear','Clear','Cloudy','Rain','Heavy Rain','Storm','Thunderstorm','Snow','Fog','Heavy Fog');
#■ 클럽
$pref['clb'] = array('Karate Club','검도부','Judo CLub','Cooking Club','Art Club','다도부','Rock Music Club','Orchestra Club','자원봉사부','브라스 밴드부','Fishing Club','코러스부','장기부','School Idol Research Club','서도부','바둑부','서양 보드부','ZION',
		'Basketball Club','Soccer Club','Baseball Club','Tennis Club','Swimming Club','Rugby Club','라크로스부','발레부','크로스 카운트 리부','방송부','Computer Help Desk','Computer Task Force','NPC');
#■ 클래스명(여기에 입력되는 클래스명의 수가 클래스수가 됩니다.필요에 따라서 추가·삭제해 주세요.)
$pref['clas'] = array('3년 A조','3년 B조','3년 C조');
#■ 성별마다 최대수
$pref['manmax'] = 9;
#■ 최대 등록수
$pref['maxmem'] = $pref['manmax'] * 2 * count($pref['clas']);
#■ 장소
$pref['place'] = array('분교','북쪽의 미사키','키타무라 주택가','키타무라 동사무소','Post Office','Fire Department','칸논도우','시미즈 연못','Nishimura Shrine','Hotel Ruins','Mountain','Tunnel','니시무라 주택가','Temple','Abandoned School','Minamimura Shrine','Forest','겐지로우 연못','미나미무라 주택가','진료소','등대','남쪽의 미사키');
#	SU=발견증 SD:발견감 DU:방어증 DD:방어감 AU:공격증 AD:공격감
$pref['arsts'] = array('SU','DD','DU','SU','SD','SU','AU','SU','SD','AD','SU','DD','DU','SD','AD','SD','SD','SD','AU','SU','DU','SU');
$pref['area'] = array('D-6','A-2','B-4','C-3','C-4','C-5','C-6','D-4','E-2','E-4','E-5','E-7','F-2','F-9','G-3','G-6','H-4','H-6','I-6','I-7','I-10','J-6');
$pref['arno'] = range(0,21);
$pref['arinfo'] = array(
	'분교다.곧 여기는 금지 에리어가 되어 버리는군.<BR>빨리 이동하지 않으면, 목걸이가 폭발해 버린다….',
	'바다에는 배가 보이지 말아라.<BR>탈주하려고 하는 학생들을 지키고 있는 정부의 배인가….',
	' 이전에는 여기에도 사람이 살고 있었을 것이다.<BR>지금은 폐허화하고 있지 말아라.',
	'여기가 마을의 중심은 (뜻)이유인가.<BR>이제 와서는 아무도 없지만….',
	'여기에는, 두드러 것이 없을 것 같지만….',
	'It is fire station. There are no fire trucks at all.',
	'대소 여러가지 불상이 제사 지내지고 있지 말아라.<BR>밤은 기분 나쁠 것이다.',
	'People are filling up water here.',
	'학문의 신이 제사 지내지고 있어, 분명히.',
	'I heard that in here it is very likely to see a ghost.<BR>Although I do not believe existence of the ghost.',
	'이 섬을 일망할 수 있는 돈대다.<BR>당연, 여기에 서있으면,<BR>다른 무리에게 발견될 가능성도 높다는 (뜻)이유다.',
	'깜깜하다.<BR>이런 곳에서, 협격에 있으면, 아래도 거적 없는데.',
	'여기도, 다른 주택가와 같고,<BR>완전히 폐허화하고 있지 말아라….',
	'완전히 몹시 황폐해져 버리고 있지 말아라.',
	'낮의 학교라고 하는 것은 좋은 걸이지만,<BR>밤의 학교라고 하는 것은 좋은 걸이 아니야.',
	'신사앞 기둥문도 헛되이 죽어 끔찍한 차림을 바래고 있지 말아라.',
	'울창으로 한 나무들이 많은 우거져 있지 말아라.<BR>풀숲으로부터 돌연 덤벼 들어져도 눈치채지 못해….',
	'여기는 연못이라고 하는 것보다도, 늪이다.<BR>완전히 기분 나쁜 장소다….',
	'여기는, 다른 주택가에 비교해 가게의 수가 많은데.<BR>상가나 무엇인가였던 것일 것이다.',
	'쇠퇴해지고는 있지만,<BR>찾으면 아직 시중드는 약이라든지 있을 것이다….',
	'요새로서 세워 바구니, 견뢰한 사이가 될 것 같다.<BR>마루에는 대량이 마른 핏자국이 있지 말아라.무엇이 있었다?',
	'병사의 배와…우승자가 타는 배인가?<BR>수척의 배가 떠올라 있다.',
);


#------- 기본 프로그램 설정 ---------

#■ 플레이어의 세이브 데이터 유효기간.날짜에 기입합니다.디폴트로 1주간.
$pref['save_limit'] = 7;
#■ 레벨업 베이스 경험치
$pref['baseexp'] = 9;
#■ 숙련도 베이스
$pref['BASE'] = 20;
#■ 현금 베이스
$pref['money_base'] = 100;
#■ 프로그램 최저 개최 날짜
#	이벤트·함정등에서 마지막 한 명이 결정해도, 이 날짜 이하라면 게임이 속행합니다.
#	0 으로 하면 1일.
$pref['battle_limit'] = 2;
#■ 프로그램 접수 마감일수(금지 에리어수)
#   ※ 구조가 바뀌었습니다.(2는 초기화하고 나서 8시간, 3은 초기화하고 나서 16시간, 4는 초기화하고 나서 24시간…)
$pref['plimit'] = 5;
#■ 휴대폰에 의한 등록을 금지 (1=금지 0=허가)
$pref['mobile_regist']=0;
#■ 스태미너 최대수
$pref['maxsta'] = 100;
#■ 응급 처치 커멘드의 소비 스태미너
$pref['okyu_sta'] = 50;
#■ 그룹 탈퇴 유지의 소비 스태미너
$pref['team_sta'] = 100;
#■ 독 봐 커멘드의 소비 스태미너
$pref['dokumi_sta'] = 30;
#■ 회복량의 설정
#	스태미너 회복 시간(초)：30초에 1포인트 회복
$pref['kaifuku_time'] = 30;
#	체력 회복 레이트：스태미너의 2분의 1(0으로 하지 않는 것)
$pref['kaifuku_rate'] = 2;
#■ 팀의 최대 인원수
$pref['team_max'] = 5;
#■ 과거 우승자 표시 ON=1 OFF=0
$pref['oldwinner'] = 0;


#------- 메신저 설정 ---------

#■ 메세지의 보존되는 파일명
$pref['mes_file'] = $pref['LOG_DIR'].'/mes.log';
#■ 보존되는 메세지의 수
$pref['listmax'] = 1000;
#■ 표시되는 메세지의 수
$pref['mesmax'] = 7;
#■ 표시 문자수(bytes)
$pref['mes_break'] = 44;
#■ 멤버수보존 파일
$pref['member_file'] = $pref['LOG_DIR'].'/member.log';
#■ 멤버가 카운트 계속 되는 시간(sec)
$pref['mem_time'] = 60;
#■ 메세지의 색
$pref['col_to'] = 'red';
#■ 보내진 메세지의 색
$pref['col_from'] = 'blue';
#■ 전원에게 전송 된 메세지의 색
$pref['col_all'] = 'green';


#------- 시큐러티 관련 설정 ---------

#■ 다른 사이트로부터 투고 배제시(다른 사이트의 링크 또는 마음에 드는 것으로부터 직접 액세스 되고 싶지 않은 경우)로 지정
$pref['base_url'] = 0;#배제 기능을 사용하는 경우 1을 설정
#				배제 기능을 유효하고 휴대 전화로부터의 배제 기능을 OFF로 하는 경우는 2를 입력.
#				유효하게 하는 경우는$base_list에 사이트의 주소의 입력이 필수.
#■ 시각(해외 서버때는, $now=time - (09 * 60 * 60); 등 해 주세요.예：13시간차이)
#	@base_list에는 입력을 받아들이는 주소를 설정(http://로부터 쓴다)·복수 설정가능
if		(!$pref['base_url'])							{$pref['now'] = time();}
elseif	($_SERVER['SERVER_NAME'] == 'Tomodachi')		{$pref['now'] = time() ;$pref['base_list'] = 'http://tomodachi.rf.gd';}
else	{require $pref['LIB_DIR'].'/lib4.php';KICKOUT();}
#■ 액세스 금지에 대해
#	호스트명을 취득 할 수 없는 경우는 배제하고 있습니다.
#	배제하고 싶지 않은 경우는, 액세스 승낙 호스트에게 IP주소를 넣어 주세요.
#	예：$pref['oklist'] = array("127.0.0");
#	이렇게 하면, 127.0.0.*** 의 IP주소는 거부되지 않습니다.
#	액세스 금지 기능 (0=OFF 1=ON)
$pref['acc_for'] = 1;
#	액세스 금지 호스트
$pref['kick'] = array(/*허깨비*/'221.82.75.16','jig.jp','xrea.com',/*mobaxy*/'210.131.5.205','coreserver.jp','sakura.ne.jp','124.97.123.183','yamaguchi.yamaguchi.ocn.ne.jp','arena.ne.jp','maido3.com','125.170.238.85','218.224.97.211','125.170.242.254','221.191.241.101','125.170.240.221','58.90.118.236','222.149.152.51','222.146.239.69','222.149.107.24','222.149.154.11','222.227.75.41','203.191.235.65','203.187.111.10','202.172.28.31','203.104.106.247','125.53.25.40','211.14.226.94','210.171.91.25','219.163.5.181','61.89.99.98','64.233.178.136','124.97.108.56','220.109.65.139','123.224.43.208','softbank220061037253.bbtec.net','220.20.206.161','219.179.126.37','221.47.148.10','221.186.126.115-gate.nafco.jp','router.hinet.net','dynamic.hinet.net','fks.ed.jp','221.189.59.128','ebix.net.tw','softbank219193012031.bbtec.net','58.156.158.60','219.162.114.79');
#	액세스 승낙 호스트
$pref['oklist'] = array('2Y1');
#	method=POST 한정 (0=no 1=yes) → 시큐러티 대책
$pref['Met_Post'] = 1;
#■ 프록시 서버-의 체크(0=no 1=yes(no registration) 2=yes(no access))
#	0에서는 아무것도 제한하지 않습니다.
#	1으로 하면 프록시 서버-를 사용한 등록을 할 수 없습니다.
#	2로 하면 프록시 서버를 사용한 액세스를 할 수 없습니다.
$pref['proxy_check'] = 0;
#■ 유저 데이터의 IP정보를 표시하는(0=no 1=yes(IP) 2=yes(HOST-IP))
#	0에서는 아무것도 표시되지 않습니다.
#	1으로 하면 유저 데이터에 IP주소와 호스트명이 표시되어 2에서는 IP주소만이 표시됩니다.
#	2에서는 데이터의 파손이 발생하기 쉬워지기 때문에 추천하지 않습니다.
$pref['host_save'] = 1;
#■ 진행 상황에 호스트 정보를 표시하는(0=no 1=yes(IP) 2=yes(HOST-IP))
#	0에서는 아무것도 표시되지 않습니다.
#	2로 하면 신규 등록시에 IP주소와 호스트명이 표시되어 1에서는 IP주소만이 표시됩니다.
$pref['host_view'] = 2;
#■ Sub-Server(미사용)
$pref['SubServer'] = 0;
$pref['SubS'] = 'SUB-SERVER-IP';#IP


#------- 시큐러티 관련 설정·선택 기능 ---------

#■ 동일 호스트로부터의 등록 금지((0=no 1=yes)
#	이 기능을 사용하면, 케이블 테레비등의 환경으로부터의 등록을 할 수 없게 되는 경우가
#	있기 때문에, 설정때는 주의해 주세요.
#$IP_deny = 0;
#■ 호스트명을 사용(0=no 1=yes IP로부터 호스트명의 역인 나무를 할 수 없는 경우, 0으로 한다)
#	0으로 하면 IP주소로의 표시가 됩니다.
#$IP_host = 0;
#■ 동일 호스트로부터의 등록을 허가하는 호스트 orIP 주소
#	생략 하면 주소나 호스트명의 범위 지정을 할 수 있습니다.
#	예 1) hogehoge.ne.jp 로 하면 *.hogehoge.ne.jp 의 호스트가 허가됩니다.
#	예 2) 192.168.0 으로 하면 192.168.0.* 의 주소가 허가됩니다.
#	주의：이 설정을 비우면 모든 호스트(주소)가 허가 대상이 됩니다.
#$IP_ok = array('2Y','dummy');


#------- NPC 설정 ---------

#■ NPC 설치 유무 (0=no 1=yes)
#	설치하는 경우는 base.dat의 NPC 데이터가 사용됩니다.
$pref['npc_mode'] = 1;
$pref['npc_num'] = 9;	# Number of NPC
$pref['npc_file'] = $pref['DAT_DIR']."/base.dat"; #NPC DATA FILE
$pref['BOSS'] = 'Teacher';$pref['KANN'] = 'Observer';$pref['ZAKO'] = 'Soldier';


#------- ICON 설정 ---------

#■ 아이콘 화상이 있는 「디렉토리」
#	→ URL라면 http:// 로부터 기술한다
#	→ 최후는 / 으로 닫지 않는다
$pref['imgurl'] = 'img';
#■ 맵의 화상이 있는 「디렉토리」
#	→ URL라면 http:// 로부터 기술한다
#	→ 최후는 / 으로 닫지 않는다
$map = 'map';#	~~~~~~~~~~
#■ 미터의 화상 파일
$blue = $pref['imgurl'].'/blue.PNG';$gold = $pref['imgurl'].'/gold.PNG';$green = $pref['imgurl'].'/green.PNG';$pink = $pref['imgurl'].'/pink.PNG';$red = $pref['imgurl'].'/red.PNG';$yellow = $pref['imgurl'].'/yellow.PNG';
#■ 아이콘을 정의(상하는 반드시 페어로.남자 아이콘을 앞, 여자 아이콘을 뒤로 해 주세요)
$icon_file = array('question.gif');
#	남자 학생 아이콘 1(파일명)
array_push ($icon_file,'i_akamatsu.jpg','i_keita.jpg','i_ooki.jpg','i_oda.jpg','i_kawada.jpg','i_kiriyama.jpg','i_kuninobu.jpg','i_kuramoto.jpg','i_kuronaga.jpg');
#	남자 학생 아이콘 2(파일명)
array_push ($icon_file,'f_01.jpg','f_02.jpg','f_03.jpg','f_04.jpg','f_05.jpg','f_06.jpg','f_07.jpg','f_08.jpg','f_09.jpg');
#	여자 학생 아이콘 1(파일명)

#	NPC용 아이콘(파일명)
array_push ($icon_file,'i_sakamochi.jpg','i_tahara.jpg','i_kondou.jpg','i_nomura.jpg','i_kato.jpg','i_hayashida.jpg','i_ocha.jpg','i_bus.jpg');
#	특수 아이콘(파일명)
array_push ($icon_file,'328.jpg','i_junya.jpg','ww.jpg','i_anno.jpg','daichi.jpg','shinya_o.jpg','misaki.jpg','ws.jpg','kakashi.gif','shima.jpg','tuki.jpg','toudou.jpg');
#if($regist){#등록시?
	$icon_name = array('불명');
# 뮤즈 학생 아이콘 1(이름)
	array_push ($icon_name,'1. Kosaka Honoka','2. Minami Kotori','3. Sonoda Umi','4. Koizumi Hanayo','5. Hoshizora Rin','6. Nishikino Maki','7. Toujou Nozomi','8. Ayase Eri','9. Yazawa Nico');

	$icon_check1 = count($icon_name);
array_push ($icon_name,'1. Chika Takami','2. Sakurauchi Riko','3. Watanabe You','4. Kurosawa Ruby','5. Hanamaru Kunikida','6. Tsushima Yoshiko','7. Kurosawa Dia','8. Ohara Mari','9. Matsuura Kanan');
	$icon_check2 = count($icon_name);
	#	NPC용 아이콘(이름)
	array_push ($icon_name,'Howard Appleseed','병사 타하라','병사 콘도','병사 노무라','병사 카토','하야시다창 아키라 선생님','운전기사','그 사람');
	$icon_check3 = count($icon_name);
	#	특수 아이콘(이름, 패스워드)
	array_push ($icon_name,'타키가와용개전용','무라타 연꽃 타로 전용','인난치 전용','궁총풍전용','카이야 대지 전용','오노데라 신야 전용','화미사키 전용','미우라 요시오 전용','허수아비 사스케 전용','오취전용','월소늠전용','토도 린 전용');
	#패스워드
	$s_icon_pass = array('','','','','','','','','','','','');
	$icon_check4 = count($icon_name);
	#'아나운서','키타가와 야스나','야스노 요시코','미무라욱미','켄자키순시','아라타니 카즈미','오오누키 케이코','미무라 숙부',
	#'i_ana.jpg','i_anna.jpg','i_anno.jpg','i_ikumi.jpg','i_junya.jpg','i_kazumi.jpg','i_keiko.jpg','i_uncle.jpg',
	#	아이콘 정의(이름)【변경·삭제하지 말아 주세요】
#	$icon_name = array('불명',$m_icon_name,$f_icon_name,$n_icon_name,$s_icon_name);
#}

#	아이콘 정의(파일명)【변경·삭제하지 말아 주세요】
#$icon_file = array('question.gif',$m_icon_file,$f_icon_file,$n_icon_file,$s_icon_file);
#------- 설정 종료 ---------


#------- 데이터 초기화 ---------
require $pref['LIB_DIR'].'/lib1.php';#LIB 파일 로드

#아래의 것은 지우지 않는 것!
?>