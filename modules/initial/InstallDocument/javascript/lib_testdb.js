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
//var FormName, RequestURI sont définis dans install_page_01.php

var dbgTstDb = 1;

//var ListeChampsTstDB = [ "form[host]", "form[db_hosting_prefix]", "form[db_admin_user]", "form[db_admin_password]", "form[dbprefix]" ];

var xmlhttp;
if ( window.XMLHttpRequest ) { xmlhttp = new XMLHttpRequest(); }		// IE7+, Firefox, Chrome, Opera, Safari
else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }				// IE6, IE5



// This will trigger on a state change of xmlhttp
xmlhttp.onreadystatechange = function () {
	if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
		res = JSON.parse(xmlhttp.response);
		toggleDiv ( 'cnxToDB', res.cnxToDB);
		toggleDiv ( 'HydrDBAlreadyExist', res.HydrDBAlreadyExist);
	}
	l.Log[dbgTstDb]( "install_test_db :  response = " + xmlhttp.responseText );
}

// Call the URL. This URL is build with the form data. 
function test_cnx_db () {
	var debug = "";
	var DBTypeElm = elm.Gebi("form[database_type_choix]"); 
	var DBType = DBTypeElm.options[DBTypeElm.selectedIndex].value;
	var DBTypeElm = elm.Gebi("form[dal]"); 
	var DBDAL = DBTypeElm.options[DBTypeElm.selectedIndex].value;
	var URLamp = "&";
	var URLvar = "http://" + document.domain + RequestURI + "/current/install/install_routines/install_test_db.php?form[database_type_choix]=" + DBType + "&form[dal]=" + DBDAL;
	l.Log[dbgTstDb]("install_test_db : ListeChampsTstDB = " + "DBType="+DBType+"; DBDAL="+DBDAL );
			

	for ( var ptr in ListeChampsTstDB ) {
//		l.Log[dbgTstDb]("install_test_db : ListeChampsTstDB = document.forms["+FormName+"].elements["+ListeChampsTstDB[ptr]+"].value" );
		URLvar += URLamp + ListeChampsTstDB[ptr] + "=" + document.forms[FormName].elements[ListeChampsTstDB[ptr]].value;
	}
	l.Log[dbgTstDb]("install_test_db :  URLvar = " + URLvar)
	xmlhttp.open( "GET" , URLvar , true );
	xmlhttp.send();
}

// Toggle the display and visibility of a set of div (ok & ko).
function toggleDiv ( id , toggle ) {
	var DivOK = id + 'ok';
	var DivKO = id + 'ko';
	l.Log[dbgTstDb]( "DivOK=" + DivOK + "; DivKO=" + DivKO);
	elm.Gebi(DivOK).style.visibility = (toggle==true) ? 'visible':'hidden';	elm.Gebi(DivOK).style.display = (toggle==true) ? 'block':'none';
}




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

class LibTestDB {
	
	constructor () { 
		this.dbgTstDb = 1;
		this.xmlhttp;
		if ( window.XMLHttpRequest ) { this.xmlhttp = new XMLHttpRequest(); }		// IE7+, Firefox, Chrome, Opera, Safari
		else { this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }				// IE6, IE5
	
		// This will trigger on a state change of xmlhttp
		this.xmlhttp.onreadystatechange = function () {
			if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
				res = JSON.parse(xmlhttp.response);
				this.toggleDbResultDivs ( 'cnxToDB', res.cnxToDB);
				this.toggleDbResultDivs ( 'HydrDBAlreadyExist', res.HydrDBAlreadyExist);
			}
			l.Log[this.this.dbgTstDb]( "install_test_db :  response = " + xmlhttp.responseText );
		}
	}

	/**
	 * Call the URL. This URL is build with the form data. 
	 */
	testDbCnx() {
		var debug = "";
		var DBTypeElm = elm.Gebi("form[database_type_choix]"); 
		var DBType = DBTypeElm.options[DBTypeElm.selectedIndex].value;
		var DBTypeElm = elm.Gebi("form[dal]"); 
		var DBDAL = DBTypeElm.options[DBTypeElm.selectedIndex].value;
		var URLamp = "&";
		var URLvar = "http://" + document.domain + RequestURI + "/current/install/install_routines/install_test_db.php?form[database_type_choix]=" + DBType + "&form[dal]=" + DBDAL;
		l.Log[this.dbgTstDb]("install_test_db : ListeChampsTstDB = " + "DBType="+DBType+"; DBDAL="+DBDAL );
		
		for ( var ptr in li.ListeChampsTstDB ) {
	//		l.Log[this.dbgTstDb]("install_test_db : li.ListeChampsTstDB = document.forms["+FormName+"].elements["+li.ListeChampsTstDB[ptr]+"].value" );
			URLvar += URLamp + li.ListeChampsTstDB[ptr] + "=" + document.forms[FormName].elements[li.ListeChampsTstDB[ptr]].value;
		}
		l.Log[this.dbgTstDb]("install_test_db :  URLvar = " + URLvar)
		xmlhttp.open( "GET" , URLvar , true );
		xmlhttp.send();
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
