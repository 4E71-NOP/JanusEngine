// @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end

// "RequestURI" is defined in the main website script : index.php

// 
// 
// Create a XMLHttpRequest to create list of file and simulate a file selector.
// 
// 
class FileSelector {
	constructor(target) {
		this.dbgFS = 1;
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
			if (this.readyState == 4 && this.status == 200) {
				let targetDiv = elm.Gebi(this.targetDivId);
				targetDiv.innerHTML = this.responseText;
			}
		}

		this.xmlHttp.targetDivId = target;
		l.Log[this.dbgFS](this.xmlHttp);
		l.Log[this.dbgFS]("FileSelector : targetDivId=" + this.xmlHttp.targetDivId);
	}

	//	getDirectoryContent (buttonId, data, path, update) {
	getDirectoryContent(data, path, update) {
		let d = data;
		if (update == 1) { d.lastPath = path; }
		if (!d.lastPath) { d.lastPath = path; }
		path = d.lastPath;

		elm.Gebi('FileSelectorCaption').style.visibility = (d.displayType == 'fileList') ? 'visible' : 'hidden';
		elm.Gebi('FileSelectorCaption').style.display = (d.displayType == 'fileList') ? 'block' : 'none';

		//		l.Log[this.dbgFS](data);
		let URLvar = "http://" + location.hostname
			+ "/fs.php?idx=" + d.idx
			+ "&mode=" + d.selectionMode
			+ "&formName=" + d.formName
			+ "&formTargetId=" + d.formTargetId
			+ "&displayType=" + d.displayType
			+ "&strAdd=" + d.strAdd
			+ "&strRemove=" + d.strRemove
			+ "&path=" + path
			+ "&restrictTo=" + d.restrictTo
			;
		l.Log[this.dbgFS]("FileSelector : URLvar=" + URLvar);
		this.xmlHttp.open("GET", URLvar, true);
		this.xmlHttp.send();
	}


}
