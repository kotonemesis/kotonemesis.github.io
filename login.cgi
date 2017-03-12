#!/usr/bin/perl

require "br.pl";
require "$lib_file2";

&CREAD;

print "Cache-Control: no-cache\n";
print "Pragma: no-cache\n";
print "Content-type: text/html\n\n";

print <<"_HERE_";
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=euc-kr">
<title>Battle Royale</title>
<link rel="stylesheet" type="text/css" href="br.css">

</head>

<body onLoad="document.login.Id.focus()">
<center>

<table border=0 style="text-align:center"><tr><td>
<br>
<br>이 나라에는 어떤『프로그램』이 있다.
<br>
<br><font class=red>『공화국 전투실험 제 육십팔번 프로그램』</font>
<br>
<br>전국의 중학교 3학년 반에서 무작위로 한반을 선별.
<br>클래스 메이트가<font class=red>『최후의 한명』</font>이 될때까지 싸운다.
<br>최후에 살아남는 학생만이 집으로 돌아갈수 있다는<font class=red>『살인게임』</font>이었다...
<br>.
<br>.
<br>.
<br>.
<br>.
<br>
<br><font size=7 class=red>Battle Royale</font>
<br>
<br>

<table>
<tr><form method="post" action="battle.cgi" name="login">
<input type="hidden" name="mode" value="main">
<td class=11>아이디</td>
<td>: <input size="10" type="text" name="Id" maxlength="10" value="$c_id"></td>
</tr>

<tr><td class=11>패스워드</td>
<td>: <input size="10" type="password" name="Password" maxlength="10" value="$c_password"></td></tr>
<tr><td colspan=2><center><input type="submit" name="Enter" value="확인"></center></td></form></tr>
</table>

</td></tr></table>

</center>

</body>
</html>
_HERE_

