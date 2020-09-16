<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') == 1 ) {
	echo ("
	<SCRIPT type='text/javascript'>\r
	<!--//--><![CDATA[//><!--\r
	if (window != top) top.location.href = location.href;


	function disableRightClick(e) {
		var message = 'Click click???  \\n hmmmm....';
		if(!document.rightClickDisabled) {
			if(document.layers) { 
				document.captureEvents(Event.MOUSEDOWN);
				document.onmousedown = disableRightClick; 
			}
			else { document.oncontextmenu = disableRightClick; }
			return document.rightClickDisabled = true;
		}
		if(document.layers || (document.getElementById && !document.all)) {
			if(e.which==2||e.which==3) { alert(message); return false; }
		}
		else { alert(message); return false; }
	}
	disableRightClick();
	//--><!]]>\r
	</SCRIPT>\r 
	");
}


?>
