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
<br>�� ���󿡴� ������α׷����� �ִ�.
<br>
<br><font class=red>����ȭ�� �������� �� �����ȹ� ���α׷���</font>
<br>
<br>������ ���б� 3�г� �ݿ��� �������� �ѹ��� ����.
<br>Ŭ���� ����Ʈ��<font class=red>�������� �Ѹ�</font>�� �ɶ����� �ο��.
<br>���Ŀ� ��Ƴ��� �л����� ������ ���ư��� �ִٴ�<font class=red>�����ΰ��ӡ�</font>�̾���...
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
<td class=11>���̵�</td>
<td>: <input size="10" type="text" name="Id" maxlength="10" value="$c_id"></td>
</tr>

<tr><td class=11>�н�����</td>
<td>: <input size="10" type="password" name="Password" maxlength="10" value="$c_password"></td></tr>
<tr><td colspan=2><center><input type="submit" name="Enter" value="Ȯ��"></center></td></form></tr>
</table>

</td></tr></table>

</center>

</body>
</html>
_HERE_

