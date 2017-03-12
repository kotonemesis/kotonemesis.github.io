function sl(x) {document.BR.Command[x].checked = true;}
function sl2(x) {document.BR.Command2[x].checked = true;}
function sl_msg(x) {document.MSG.M_Id[x].checked = true;}
function chk(x) {if (document.f1.Del[x].checked == true) {document.f1.Del[x].checked = false ;}else {document.f1.Del[x].checked = true ;}}
function showform(){login.style.visibility='visible';}
function hideform(){login.style.visibility='hidden';}
function quake_init(){setTimeout('quake_update()', 120);}
function quake_update(){var m = 15;while (m > 0){parent.moveBy(m, 0);parent.moveBy(0, m);parent.moveBy(-m, 0);parent.moveBy(0, -m);m -= 3;}}
function SWF_DSP(file,w,h){
	document.write('<OBJ');
	document.write('ECT classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'+ w +'" height="'+ h +'"><PARAM NAME="wmode" VALUE="transparent"><param name="allowScriptAccess" value="sameDomain" /><PARAM NAME=movie VALUE="'+ file +'"><PARAM NAME=menu VALUE=false><PARAM NAME=loop VALUE=true><param name="quality" value="high" /><EM');
	document.write('BED name="altfla" src="'+ file +'" width="'+ w +'" height="'+ h +'" loop="true" quality="high" wmode="transparent" menu=false TYPE="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
	document.write('</EMBED></OBJECT>');
}
