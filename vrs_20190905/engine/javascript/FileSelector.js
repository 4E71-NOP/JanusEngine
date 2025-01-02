 /*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

// "RequestURI" is defined in the main website script : index.php

// 
// 
// Create a XMLHttpRequest to create list of file and simulate a file selector.
// 
// 
class FileSelector {
	constructor(target) {
		this.dbgFS = 0;
		if (window.XMLHttpRequest) { 
			this.xmlHttp = new XMLHttpRequest();		// IE7+, Firefox, Chrome, Opera, Safari
			l.Log[this.dbgFS]("FileSelector : DOM"); 
		}
		else { 
			this.xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");				// IE6, IE5
			JSJournal[this.dbgFS]("FileSelector : Shity browser");
		}
		
		this.xmlHttp.onreadystatechange = function () {
//			console.log ("FileSelector : this.readyState="+this.readyState+" ; this.status="+this.status+"; this.targetDivId="+this.targetDivId);
			if ( this.readyState == 4 && this.status == 200 ) {
				let targetDiv = elm.Gebi(this.targetDivId);
				targetDiv.innerHTML = this.responseText;
			}
		}
		
		this.xmlHttp.targetDivId = target;
		l.Log[this.dbgFS](this.xmlHttp);
		l.Log[this.dbgFS]("FileSelector : targetDivId=" + this.xmlHttp.targetDivId);
	}
	
//	getDirectoryContent (buttonId, data, path, update) {
	getDirectoryContent (data, path, update) {
		let d = data;
		if ( update == 1 ) { d.lastPath = path; }
		if ( !d.lastPath ) { d.lastPath = path; }
		path = d.lastPath;
		
		elm.Gebi('FileSelectorCaption').style.visibility = (d.displayType == 'fileList') ? 'visible':'hidden'; 
		elm.Gebi('FileSelectorCaption').style.display = (d.displayType == 'fileList') ? 'block':'none'; 
		
//		l.Log[this.dbgFS](data);
		let URLvar = "http://" + location.hostname
		+"/fs.php?idx="+d.idx
		+"&mode="+d.selectionMode
		+"&formName="+d.formName
		+"&formTargetId="+d.formTargetId
		+"&displayType="+d.displayType
		+"&strAdd="+d.strAdd
		+"&strRemove="+d.strRemove
		+"&path="+path
		+"&restrictTo="+d.restrictTo
		;
		l.Log[this.dbgFS]("FileSelector : URLvar=" + URLvar);
		this.xmlHttp.open( "GET" , URLvar , true );
		this.xmlHttp.send();
	}
	
	
}
