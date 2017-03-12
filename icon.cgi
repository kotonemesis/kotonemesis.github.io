#!/usr/bin/perl

require "br.pl";

print "Content-type: text/html\n\n";
print <<"_HERE_";
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=euc-kr">
<title>Icon Preview</title>
<link rel="stylesheet" type="text/css" href="br.css">
<style>
<!--
body {margin:0 0 0 0}
//-->
</style>
</HEAD>
<BODY>
<CENTER>
<table cellspacing=0 cellpadding=2 border=1>
<tr>
_HERE_

foreach $i (0..$#icon_file) {
	if ( int($i+1) % 7 ) {
		print "<td align=center><img src=$imgurl$icon_file[$i]><br>$icon_name[$i]</td>\n";
	}
	else {
		unless ( $i == 41) {
			print "<td align=center><img src=$imgurl$icon_file[$i]><br>$icon_name[$i]</td>\n</tr>\n<tr>\n";
		}
		else {
			print "<td align=center><img src=$imgurl$icon_file[$i]><br>$icon_name[$i]</td>\n</tr>\n";
		}
	}
	
}

print <<"_HERE_";
</center>
</body>
</html>
_HERE_

