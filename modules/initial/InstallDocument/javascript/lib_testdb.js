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

// http://www.w3schools.com/php/php_ajax_xml.asp

class LibTestDB {
	
	constructor () { 
		this.xmlhttp;
		this.dbgTstDb = 0;
		if ( window.XMLHttpRequest ) { 
			l.Log[this.dbgTstDb]( "LibTestDB : Modern browser! => window.XMLHttpRequest");
			this.xmlhttp = new XMLHttpRequest(); 
		}		// IE7+, Firefox, Chrome, Opera, Safari
		else { 
			l.Log[this.dbgTstDb]( "LibTestDB : Crappy browser! => window.XMLHttpRequest");
			this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
		}		// IE6, IE5
	
		// This will trigger on a state change of xmlhttp
		// The anonymous function scope will **NOT** be from this class. It's a standalone.
		this.xmlhttp.onreadystatechange = function () {
			if ( tdb.xmlhttp.readyState == 4 && tdb.xmlhttp.status == 200 ) {
				var res = JSON.parse(tdb.xmlhttp.response);
				tdb.toggleDbResultDivs ( 'cnxToDB', res.cnxToDB);
				tdb.toggleDbResultDivs ( 'HydrDBAlreadyExist', res.HydrDBAlreadyExist);
			}
			// l.Log[1]( "LibTestDB :  response = " + xmlhttp.responseText );
		}
	}

	/**
	 * Call the URL. This URL is build with the form data. 
	 */
	testDbCnx() {
		var DBTypeElm = elm.Gebi("form[selectedDataBaseType]"); 
		var DBType = DBTypeElm.options[DBTypeElm.selectedIndex].value;
		var DBTypeElm = elm.Gebi("form[dal]"); 
		var DBDAL = DBTypeElm.options[DBTypeElm.selectedIndex].value;
		var URLvar = "http://"+document.domain+RequestURI
		+"/current/install/install_routines/install_test_db.php?"
		+"form[dal]="+DBDAL
		+"&form[selectedDataBaseType]="+DBType
		;
		l.Log[this.dbgTstDb]("LibTestDB / testDbFieldList : " + "DBType="+DBType+"; DBDAL="+DBDAL );
		
		var URLamp = "&";
		for ( var ptr in li.testDbFieldList ) {
	//		l.Log[this.dbgTstDb]("LibTestDB : li.testDbFieldList = document.forms["+FormName+"].elements["+li.testDbFieldList[ptr]+"].value" );
			URLvar += URLamp + li.testDbFieldList[ptr] + "=" + document.forms[FormName].elements[li.testDbFieldList[ptr]].value;
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
		elm.Gebi(DivOK).style.visibility = (toggle==true) ? 'visible':'hidden';	elm.Gebi(DivOK).style.display = (toggle==true) ? 'block':'none';
	}

}
