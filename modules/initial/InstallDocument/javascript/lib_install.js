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
		this.dbgInstFonction = 1;
		this.testDbFieldList = [ 
			"form[host]", 
			"form[dataBaseHostingPrefix]", 
			"form[dataBaseAdminUser]", 
			"form[dataBaseAdminPassword]", 
			"form[dbprefix]", 
			"form[tabprefix]" 
		];
		this.installFieldList = [ 
			"form[consoleLogWarning]",
			"form[consoleLogError]",
			"form[creationHtaccess]",
			"form[execTimeLimit]",
			"form[dal]",
			"form[dbprefix]", 
			"form[dataBaseAdminUser]", 
			"form[dataBaseAdminPassword]", 
			"form[dataBaseHostingPrefix]", 
			"form[dataBaseHostingProfile]",
			"form[dataBaseLogError]",
			"form[dataBaseUserLogin]",
			"form[dataBaseUserPassword]",
			"form[dataBaseUserRecreate]",
			"form[host]", 
			"form[memoryLimit]",
			"form[operantingMode]",
			"form[selectedDataBaseType]",
			"form[tabprefix]",
			"form[TypeExec]",
			"form[websiteUserPassword]",
			"PageInstall",
			"l",
			"InstallToken"
		];

		if ( window.XMLHttpRequest ) { 
			l.Log[this.dbgInstFonction]( "LibInstall : Modern browser! => window.XMLHttpRequest");
			this.xmlhttp = new XMLHttpRequest(); 
		}		// IE7+, Firefox, Chrome, Opera, Safari
		else { 
			l.Log[this.dbgInstFonction]( "LibInstall : Crappy browser! => window.XMLHttpRequest");
			this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
		}		// IE6, IE5

		// The anonymous function scope will **NOT** be from this class. It's a standalone.
		this.xmlhttp.onreadystatechange = function () {
			if ( tdb.xmlhttp.readyState == 4 && tdb.xmlhttp.status == 200 ) {
				alert("we got to the end of the install!","for real??")
				// var res = JSON.parse(tdb.xmlhttp.response);
			}
			// l.Log[1]( "LibTestDB :  response = " + xmlhttp.responseText );
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
		
		var method = document.forms['install_page_init'].elements['form[operantingMode]'].value;
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
		
		for ( var ptr in enabledDirectoryList ) {
			l.Log[this.dbgInstFonction]( 'enabledDirectoryList['+ptr+']=' + document.forms['install_page_init'].elements[enabledDirectoryList[ptr]].checked );
			addMemory += (document.forms['install_page_init'].elements[enabledDirectoryList[ptr]].checked == true) ? 16: 0;
			addTime += (document.forms['install_page_init'].elements[enabledDirectoryList[ptr]].checked == true) ? 25: 0;
		}
		
		document.forms['install_page_init'].elements['form[memoryLimit]'].value = (memory + addMemory);
		document.forms['install_page_init'].elements['form[execTimeLimit]'].value = (time + addTime);
	}
	
	/**
	 * 
	 * @param {*} Tab 
	 * @param {*} Lang 
	 * @param {*} SessionID 
	 */
	checkFormAndPost ( Tab , Lang , SessionID ) {
	//	var FormName = 'install_page_init';
		var stop = 0;
		for ( var i in Tab ) { Tab[i].err = 0; }
		for ( var i in Tab ) {
			var test = document.forms[FormName].elements[Tab[i].id].value;
			if ( test.length == 0 ) { stop = 1; Tab[i].err = 1;	}
		}
	
		if ( stop == 0 ) { 
			var DBTypeElm = elm.Gebi("form[selectedDataBaseType]"); 
			var DBType = DBTypeElm.options[DBTypeElm.selectedIndex].value;
			var DBTypeElm = elm.Gebi("form[dal]"); 
			var DBDAL = DBTypeElm.options[DBTypeElm.selectedIndex].value;
			var URLamp = "&";

			// Monitor
			var MonitorURL = "http://" + document.domain + RequestURI + "/install_monitor.php?PageInstall=monitor&form[selectedDataBaseType]=" + DBType + "&form[database_dal_choix]=" + DBDAL;
			for ( var ptr in this.testDbFieldList ) {
				MonitorURL += URLamp + this.testDbFieldList[ptr] + "=" + document.forms[FormName].elements[this.testDbFieldList[ptr]].value;
			}
			MonitorURL += URLamp + 'l=' + Lang + URLamp + 'SessionID=' + SessionID;
			l.Log[this.dbgInstFonction]( 'Monitor URL=: `' +MonitorURL+"`" );
			// window.open( MonitorURL, '_blank');
			
			let ajaxPost = false;
			ajaxPost = !ajaxPost;
			if ( ajaxPost == true) {
				// Post
				var installFormData = "";
				URLamp = "";
				var InstallURL = "http://" + document.domain + RequestURI + "/install.php";
				for ( let ptr in this.installFieldList ) {
					l.Log[this.dbgInstFonction]( "Processing field `document.forms["+FormName+"].elements["+this.installFieldList[ptr]+"].value`");
					installFormData += URLamp + this.installFieldList[ptr] + "=" + document.forms[FormName].elements[this.installFieldList[ptr]].value;
					URLamp = "&";
				}

				installFormData += URLamp+"directory_list[00_Hydre][name]=00_Hydre";
				installFormData += URLamp+"directory_list[00_Hydre][state]=on";
				installFormData += URLamp+"directory_list[00_Hydre][code_verification]=on";

				for ( let ptr in enabledDirectoryList ) {
					// l.Log[this.dbgInstFonction]( 'enabledDirectoryList['+ptr+']=' + document.forms['install_page_init'].elements[enabledDirectoryList[ptr]].checked );
					installFormData += URLamp+enabledDirectoryList[ptr]+"="+document.forms['install_page_init'].elements[enabledDirectoryList[ptr]].value;
				}

				for ( let ptr in DirectoryNameList ) {
					// l.Log[this.dbgInstFonction]( 'DirectoryNameList['+ptr+']=' + DirectoryNameList[ptr] );
					installFormData += URLamp+"directory_list["+DirectoryNameList[ptr]+"][name]="+DirectoryNameList[ptr];
				}
	
				l.Log[this.dbgInstFonction]( 'Install URL=: `' +InstallURL+"?"+installFormData+"`" );
				// this.xmlhttp.setOption(2) = 13056			//should ignore certificate errors
				this.xmlhttp.open( "POST" , InstallURL , true );
				this.xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				this.xmlhttp.send(installFormData);
			}
			else { document.forms['install_page_init'].submit(); }
		}
		else { 
			var ErrorDesc = '';
			for ( var j in Tab ) {
				if ( Tab[j].err == 1 ) { ErrorDesc += "-> "+ Tab[j].name + '\n'; }
			}
			window.alert ( AlertCheckFormValues + ErrorDesc ); 
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
}