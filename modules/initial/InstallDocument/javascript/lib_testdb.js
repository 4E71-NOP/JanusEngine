/*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

// http://www.w3schools.com/php/php_ajax_xml.asp

class LibTestDB {

	constructor() {
		this.dbgTstDb = 0;
		this.resultTest = {
			'cnxToDB': false,
			'HydrDBAlreadyExists': false,
			'installationLocked': false,
			'HydrUserAlreadyExists':false,
		};

		this.testDbFieldList = [
			"form[host]",
			"form[port]",
			"form[dal]",
			"form[dataBaseHostingPrefix]",
			"form[dataBaseAdminUser]",
			"form[dataBaseAdminPassword]",
			"form[dataBaseUserLogin]",
			"form[dbprefix]",
			"form[selectedDataBaseType]",
			"form[tabprefix]",
		];

		this.xmlhttp;
		if (window.XMLHttpRequest) {
			// IE7+, Firefox, Chrome, Opera, Safari
			l.Log[this.dbgTstDb]("LibTestDB : Modern browser! => window.XMLHttpRequest");
			this.xmlhttp = new XMLHttpRequest();
		}
		else {
			// IE6, IE5
			l.Log[this.dbgTstDb]("LibTestDB : Crappy browser! => window.XMLHttpRequest");
			this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		// This will trigger on a state change of xmlhttp
		// The anonymous function scope will **NOT** be from this class. It's a standalone.
		this.xmlhttp.onreadystatechange = function () {
			if (tdb.xmlhttp.readyState == 4 && tdb.xmlhttp.status == 200) {
				var res = JSON.parse(tdb.xmlhttp.response);
				tdb.resultTest = res;
				l.Log[tdb.dbgTstDb](res);

				tdb.toggleDbResultDivsVisibilty('cnxToDB', false);
				tdb.toggleDbResultDivsVisibilty('HydrDBAlreadyExists', false);
				tdb.toggleDbResultDivsVisibilty('HydrUserAlreadyExists', false);
				tdb.toggleDbResultDivsVisibilty('installationLocked', false);


				tdb.toggleDbResultDivs('cnxToDB', res.cnxToDB);
				if (res.cnxToDB) {
					tdb.toggleDbResultDivs('HydrDBAlreadyExists', res.HydrDBAlreadyExists);
					tdb.toggleDbResultDivs('HydrUserAlreadyExists', res.HydrUserAlreadyExists);
					tdb.toggleDbResultDivs('installationLocked', res.installationLocked);
				}
			}
		}
	}

	/**
	 * Call the URL. This URL is built with the form data. 
	 */
	testDbCnx() {
		var FormName = 'install_page_init';
		var URLvar = "http://" + location.hostname + RequestURI + "/current/install/install_routines/install_test_db.php";

		var URLamp = "?";

		// var prt = document.forms[FormName].elements['port'];
		// if ( prt.value.length == 0 ) 
		for (var ptr in this.testDbFieldList) {
			var tmpFormData = document.forms[FormName].elements[this.testDbFieldList[ptr]].value;
			if (tmpFormData.length > 0) {
				URLvar += URLamp + this.testDbFieldList[ptr] + "=" + tmpFormData;
				URLamp = "&";
			}
		}
		l.Log[this.dbgTstDb]("LibTestDB :  URLvar = " + URLvar)
		this.xmlhttp.open("GET", URLvar, true);
		this.xmlhttp.send();
	}

	/**
	 * Toggle the display and visibility of a set of div (ok & ko).
	 * @param {*} id 
	 * @param {*} toggle 
	 */
	toggleDbResultDivs(id, toggle) {
		var DivTrue = id + 'True';
		var DivFalse = id + 'False';
		l.Log[this.dbgTstDb]("DivTrue=" + DivTrue + "; DivFalse=" + DivFalse);
		elm.Gebi(DivTrue).style.visibility = (toggle == true) ? 'visible' : 'hidden';
		elm.Gebi(DivTrue).style.display = (toggle == true) ? 'block' : 'none';

		elm.Gebi(DivFalse).style.visibility = (toggle == false) ? 'visible' : 'hidden';
		elm.Gebi(DivFalse).style.display = (toggle == false) ? 'block' : 'none';
	}


	/**
	 * Toggle the display and visibility of a set of div (ok & ko).
	 * @param {*} id 
	 * @param {*} toggle 
	 */
	toggleDbResultDivsVisibilty(id, toggle) {
		var DivTrue = id + 'True';
		var DivFalse = id + 'False';
		l.Log[this.dbgTstDb]("DivTrue=" + DivTrue + "; DivFalse=" + DivFalse);
		elm.Gebi(DivTrue).style.visibility = (toggle == true) ? 'visible' : 'hidden';
		elm.Gebi(DivFalse).style.visibility = (toggle == false) ? 'visible' : 'hidden';
	}



}
