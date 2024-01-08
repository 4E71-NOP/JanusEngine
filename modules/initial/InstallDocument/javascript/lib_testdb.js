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
	
	constructor () { 
		this.dbgTstDb = 0;
		this.resultTest = {
			'cnxToDB':false,
			'HydrDBAlreadyExist':false,
			'installationLocked':true,
		};

		this.testDbFieldList = [ 
			"form[host]", 
			"form[dal]",
			"form[dataBaseHostingPrefix]", 
			"form[dataBaseAdminUser]", 
			"form[dataBaseAdminPassword]", 
			"form[dbprefix]", 
			"form[selectedDataBaseType]",
			"form[tabprefix]",
		];

		this.xmlhttp;
		if ( window.XMLHttpRequest ) { 
			// IE7+, Firefox, Chrome, Opera, Safari
			l.Log[this.dbgTstDb]( "LibTestDB : Modern browser! => window.XMLHttpRequest");
			this.xmlhttp = new XMLHttpRequest(); 
		}
		else { 
			// IE6, IE5
			l.Log[this.dbgTstDb]( "LibTestDB : Crappy browser! => window.XMLHttpRequest");
			this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
		}
	
		// This will trigger on a state change of xmlhttp
		// The anonymous function scope will **NOT** be from this class. It's a standalone.
		this.xmlhttp.onreadystatechange = function () {
			if ( tdb.xmlhttp.readyState == 4 && tdb.xmlhttp.status == 200 ) {
				var res = JSON.parse(tdb.xmlhttp.response);
				tdb.resultTest = res;
				l.Log[tdb.dbgTstDb](res);
				tdb.toggleDbResultDivs ('cnxToDB', res.cnxToDB);
				tdb.toggleDbResultDivs ('HydrDBAlreadyExist', res.HydrDBAlreadyExist);
				tdb.toggleDbResultDivs ('installationLocked', res.installationLocked);
			}
		}
	}

	/**
	 * Call the URL. This URL is built with the form data. 
	 */
	testDbCnx() {
		var FormName = 'install_page_init';
		// var URLvar = "http://"+document.domain+RequestURI+"/current/install/install_routines/install_test_db.php";
		var URLvar = "http://" + location.hostname + RequestURI+"/current/install/install_routines/install_test_db.php";

		var URLamp = "?";
		for ( var ptr in this.testDbFieldList ) {
			URLvar += URLamp + this.testDbFieldList[ptr] + "=" + document.forms[FormName].elements[this.testDbFieldList[ptr]].value;
			URLamp = "&";
		}
		l.Log[this.dbgTstDb]("LibTestDB :  URLvar = " + URLvar)
		this.xmlhttp.open( "GET" , URLvar , true );
		this.xmlhttp.send();
	}
	
	/**
	 * Toggle the display and visibility of a set of div (ok & ko).
	 * @param {*} id 
	 * @param {*} toggle 
	 */
	toggleDbResultDivs ( id , toggle ) {
		var DivOK = id + 'ok';
		var DivKO = id + 'ko';
		l.Log[this.dbgTstDb]( "DivOK=" + DivOK + "; DivKO=" + DivKO);
		elm.Gebi(DivOK).style.visibility = (toggle==true) ? 'visible':'hidden';	
		elm.Gebi(DivOK).style.display = (toggle==true) ? 'block':'none';

		elm.Gebi(DivKO).style.visibility = (toggle==false) ? 'visible':'hidden';	
		elm.Gebi(DivKO).style.display = (toggle==false) ? 'block':'none';
	}

}
