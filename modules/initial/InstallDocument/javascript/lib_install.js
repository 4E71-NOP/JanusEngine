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

class LibInstall {
	
	constructor () { 
		this.dbgInstFonction = 0;
		this.ListeChampsTstDB = [ "form[host]", "form[db_hosting_prefix]", "form[db_admin_user]", "form[db_admin_password]", "form[dbprefix]", "form[tabprefix]" ];

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
			l.Log[dbgTstDb]( "install_test_db :  response = " + xmlhttp.responseText );
		}
	}

	/**
	 * 
	 * @param {*} MSObj2 
	 * @param {*} Table 
	 */
	selectMenuBuilder ( MSObj2 , Table ) {
		// MSObj1 = elm.Gebi ( MSObj1 );
		MSObj2 = elm.Gebi ( MSObj2 );
		// var MSObj1Sidx1 = MSObj1.options[MSObj1.selectedIndex].value;
	
		var ObjOption;
		while ( MSObj2.options.length ) {
			MSObj2.options[MSObj2.selectedIndex] = null;
		}
	
		for ( let o in Table ) {
			ObjOption = null;
			ObjOption = document.createElement('option');
			ObjOption.text = Table[o]['t'];
			ObjOption.value = Table[o]['v'];
			MSObj2.options.add(ObjOption);
		}
	}

	/**
	 * 
	 */
	setFormPreconizedSettings() {
		var memory = 16;
		var addMemory = 0; 
		var time = 15;
		var addTime = 0; 
		
		var method = document.forms['install_page_init'].elements['form[operating_mode]'].value;
		switch (method) {
		case 'directCnx':
			l.Log[this.dbgInstFonction]( 'method=: ' + method );
			break;
		case 'createScript':
			l.Log[this.dbgInstFonction]( 'method=: ' + method );
			addMemory += 32;
			addTime += 20;
			break;
		}
		
		for ( var ptr in ListCheckbox ) {
			l.Log[this.dbgInstFonction]( 'ListCheckbox['+ptr+']=' + document.forms['install_page_init'].elements[ListCheckbox[ptr]].checked );
			addMemory += (document.forms['install_page_init'].elements[ListCheckbox[ptr]].checked == true) ? 16: 0;
			addTime += (document.forms['install_page_init'].elements[ListCheckbox[ptr]].checked == true) ? 25: 0;
		}
		
		document.forms['install_page_init'].elements['form[memory_limit]'].value = (memory + addMemory);
		document.forms['install_page_init'].elements['form[time_limit]'].value = (time + addTime);
	}
	
	/**
	 * 
	 * @param {*} Tab 
	 * @param {*} Lang 
	 * @param {*} SessionID 
	 */
	checkFormValues ( Tab , Lang , SessionID ) {
		//	var FormName = 'install_page_init';
			var stop = 0;
			for ( var i in Tab ) { Tab[i].err = 0; }
			for ( var i in Tab ) {
				var test = document.forms[FormName].elements[Tab[i].id].value;
				if ( test.length == 0 ) { stop = 1; Tab[i].err = 1;	}
			}
		
			if ( stop == 0 ) { 
				var DBTypeElm = elm.Gebi("form[database_type_choix]"); 
				var DBType = DBTypeElm.options[DBTypeElm.selectedIndex].value;
				var DBTypeElm = elm.Gebi("form[dal]"); 
				var DBDAL = DBTypeElm.options[DBTypeElm.selectedIndex].value;
				var URLamp = "&";
				var URLvar = "http://" + document.domain + RequestURI + "/install_monitor.php?PageInstall=monitor&form[database_type_choix]=" + DBType + "&form[database_dal_choix]=" + DBDAL;
				for ( var ptr in this.ListeChampsTstDB ) {
					URLvar += URLamp + this.ListeChampsTstDB[ptr] + "=" + document.forms[FormName].elements[this.ListeChampsTstDB[ptr]].value;
				}
				URLvar += URLamp + 'l=' + Lang + URLamp + 'SessionID=' + SessionID;
		
				window.open( URLvar, '_blank');
				document.forms['install_page_init'].submit(); 
			}
			else { 
				var ErrorDesc = '';
				for ( var j in Tab ) {
					if ( Tab[j].err == 1 ) { ErrorDesc += Tab[j].name + '\n'; }
				}
				window.alert ( AlertCheckFormValues + '\n' + ErrorDesc ); 
			}
	}

	/**
	 * 
	 * @param {*} Len 
	 * @returns 
	 */
	createRandomPassword( Len ) {
		var Table = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz';
		var RandomString = '';
		for (var i=0; i < Len; i++) {
			var Nombre = Math.floor(Math.random() * Table.length);
			RandomString += Table.substring(Nombre,Nombre+1);
		}
		return RandomString;
	}
	
	/**
	 * 
	 * @param {*} val 
	 * @param {*} form 
	 * @param {*} list 
	 */
	insertValue ( val , form , list ) {
		for ( var ptr in list ) {
			l.Log[this.dbgInstFonction]( 'InsertValue: ' + val + ' -> ' + form + '/' + list[ptr] );
			elm.SetFormInputValue ( form , list[ptr] , val );
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
		l.Log[dbgTstDb]("install_test_db : ListeChampsTstDB = " + "DBType="+DBType+"; DBDAL="+DBDAL );
		
		for ( var ptr in ListeChampsTstDB ) {
	//		l.Log[dbgTstDb]("install_test_db : ListeChampsTstDB = document.forms["+FormName+"].elements["+ListeChampsTstDB[ptr]+"].value" );
			URLvar += URLamp + ListeChampsTstDB[ptr] + "=" + document.forms[FormName].elements[ListeChampsTstDB[ptr]].value;
		}
		l.Log[dbgTstDb]("install_test_db :  URLvar = " + URLvar)
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
		l.Log[dbgTstDb]( "DivOK=" + DivOK + "; DivKO=" + DivKO);
		elm.Gebi(DivOK).style.visibility = (toggle==true) ? 'visible':'hidden';	elm.Gebi(DivOK).style.display = (toggle==true) ? 'block':'none';
	}
	

}