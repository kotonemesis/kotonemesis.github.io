
 --------------------------------------
 Battle Royale Ver 1.15 Edited by Ruria
 --------------------------------------

 Mail : ruria@hanmir.com
 Battle Royale HP : http://battleroyale.lil.to/

 ※이 스크립트를 설치/사용하는 것은 저작권 관련부분을 삭제하지
 않겠다는 것에 동의하는 것으로 간주합니다.

 Battle Royale Ver 1.15 Edited by Ruria - 2003년 5월 18일
 ---------------------------------------------------------------------

 이 스크립트는 http://www.happy-ice.com/battle/ 에서 배포했었던
 배틀로얄 게임을 한글로 번역하고 상당부분 개조한 것입니다.

 #설치순서
 1. br.pl 파일을 열어 게임 관련 설정을 적당히 바꾼다. (관리자 비밀번호는 꼭 변경할 것!)
 2. 루트 디렉토리에 cgi들을 열어 perl 경로를 서버에 맞게 수정한다.
 3. 계정에 업로드 후, 파일 퍼미션을 설정한다.
 4. 관리자 모드로 접속 후, 메인 메뉴에서 게임을 초기화 시킨다.

 #퍼미션 설정
 /dat          drw-r--r-- (644)
 /dat/*.cgi    -rw-r--r-- (644)

 /lib          drw-r--r-- (644)
 /lib/*.cgi    -rw-r--r-- (644)

 /lock         drwxrwxrwx (777)

 /log          drw-rw-rw- (666)
 /log/users    drw-rw-rw- (666)
 /log/*.cgi    -rw-rw-rw- (666)

 /*.cgi        drwxrwxrwx (777) or drwxrw-rw- (755)
 /*.htm        -rw-r--r-- (644)
 /br.pl        -rw-r--r-- (644)
 /br.css       -rw-r--r-- (644)
 /e_flag.txt   -rw-rw-rw- (666)

 ---End of Text-------------------------------------------------------
