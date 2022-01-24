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
			"installToken"
		];
		this.saveConfig = {};

		if ( window.XMLHttpRequest ) { 
			l.Log[this.dbgInstFonction]( "LibInstall : Modern browser! => window.XMLHttpRequest");
			this.xmlhttp = new XMLHttpRequest(); 
		}		// IE7+, Firefox, Chrome, Opera, Safari
		else { 
			l.Log[this.dbgInstFonction]( "LibInstall : Crappy browser! => window.XMLHttpRequest");
			this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
		}		// IE6, IE5

		// The anonymous function scope will **NOT** be from this class. It's a standalone.
		// this.xmlhttp.onreadystatechange = function () {
		// 	if ( tdb.xmlhttp.readyState == 4 && tdb.xmlhttp.status == 200 ) {
		// 		alert("we got to the end of the install!","for real??")
		// 		// var res = JSON.parse(tdb.xmlhttp.response);
		// 	}
		// 	// l.Log[1]( "LibTestDB :  response = " + xmlhttp.responseText );
		// }
		
	}

	/**
	 * selectMenuBuilder
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
	 * setFormPreconizedSettings
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
	 * checkFormAndPost
	 * @param {*} Tab 
	 * @param {*} Lang 
	 * @param {*} installToken 
	 */
	checkFormAndPost ( Tab , Lang , installToken ) {
		var FormName = 'install_page_init';
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

			let ajaxPost = false;
			ajaxPost = !ajaxPost;
			if ( ajaxPost == true) {
				// Post
				var installFormData = "";
				URLamp = "";
				var InstallURL = "http://" + document.domain + RequestURI + "/install.php";
				for ( let ptr in this.installFieldList ) {
					// l.Log[this.dbgInstFonction]( "Processing field `document.forms["+FormName+"].elements["+this.installFieldList[ptr]+"].value`");
					installFormData += URLamp + this.installFieldList[ptr] + "=" + document.forms[FormName].elements[this.installFieldList[ptr]].value;
					this.saveConfig[this.installFieldList[ptr]] = document.forms[FormName].elements[this.installFieldList[ptr]].value;
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
	
				// l.Log[this.dbgInstFonction]( 'Install URL=: `' +InstallURL+"?"+installFormData+"`" );
				this.xmlhttp.open( "POST" , InstallURL , true );
				this.xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				this.xmlhttp.send(installFormData);

				// Monitoring
				mi.monitorToggleDisplay();
				this.monitorURL = "http://" + document.domain + RequestURI + "/install_monitor.php"; 
				URLamp = "?";
				for (let ptr in this.saveConfig ) {
					this.monitorURL += URLamp+ptr+"="+this.saveConfig[ptr];
					URLamp = "&";
				}
				mi.setUrl(this.monitorURL);
				mi.startInterval();
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
	 * makeFormInstallReport
	 */
	makeFormInstallReport () {
		let f = document.forms['formInstallReport'];
		let FormName = 'install_page_init';
		var inputElm;
		for ( let ptr in this.installFieldList ) {
			inputElm = document.createElement("input");
			inputElm.setAttribute('type', 'hidden');
			if (this.installFieldList[ptr] == 'PageInstall') {
				inputElm.setAttribute('name', 'PageInstall');
				inputElm.setAttribute('value', '3');
			}
			else {
				inputElm.setAttribute('name', this.installFieldList[ptr]);
				inputElm.setAttribute('value', document.forms[FormName].elements[this.installFieldList[ptr]].value);
			}
			f.appendChild(inputElm);
		}

		// Adding directory list
		let i = 1 ;
		inputElm = document.createElement("input");
		inputElm.setAttribute('type', 'hidden');
		inputElm.setAttribute('name', 'directory_list['+i+']');
		inputElm.setAttribute('value', '00_Hydre');
		f.appendChild(inputElm);
		i++;
		for ( let ptr in DirectoryNameList ) {
			inputElm = document.createElement("input");
			inputElm.setAttribute('type', 'hidden');
			inputElm.setAttribute('name', 'directory_list['+i+']');
			inputElm.setAttribute('value', DirectoryNameList[ptr]);
			f.appendChild(inputElm);
			i++;
		}
		document.forms['formInstallReport'].submit();
	}

	/**
	 * createRandomPassword
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
	 * insertValue
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