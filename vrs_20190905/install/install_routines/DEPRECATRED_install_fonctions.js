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
// http://www.pjb.com.au/comp/diacritics.html
var dbgInstFonction = 0;

function InsertValue ( val , form , list ) {
	for ( var ptr in list ) {
		l.Log[dbgInstFonction]( 'InsertValue: ' + val + ' -> ' + form + '/' + list[ptr] );
		elm.SetFormInputValue ( form , list[ptr] , val );
	}
}
//var OnKeypress = "InsertValue ( this.value , 'install_p02' );"

function CreateRandomPassword( Longueur ) {
	var Table = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz';
	var RandomString = '';
	for (var i=0; i < Longueur; i++) {
		var Nombre = Math.floor(Math.random() * Table.length);
		RandomString += Table.substring(Nombre,Nombre+1);
	}
	return RandomString;
}

// --------------------------------------------------------------------------------------------
var testDbFieldList = [ "form[host]", "form[dataBaseHostingPrefix]", "form[dataBaseAdminUser]", "form[dataBaseAdminPassword]", "form[dbprefix]", "form[tabprefix]" ];

function CheckFormValues ( Tab , Langue , SessionID ) {
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
		var URLvar = "http://" + document.domain + RequestURI + "/install_monitor.php?PageInstall=monitor&form[selectedDataBaseType]=" + DBType + "&form[database_dal_choix]=" + DBDAL;
		for ( var ptr in testDbFieldList ) {
			URLvar += URLamp + testDbFieldList[ptr] + "=" + document.forms[FormName].elements[testDbFieldList[ptr]].value;
		}
		URLvar += URLamp + 'l=' + Langue + URLamp + 'SessionID=' + SessionID;

		window.open( URLvar, '_blank');
		document.forms['install_page_init'].submit(); 
	}
	else { 
		var ErreurDesc = '';
		for ( var j in Tab ) {
			if ( Tab[j].err == 1 ) { ErreurDesc += Tab[j].name + '\n'; }
		}
		window.alert ( AlertCheckFormValues + '\n' + ErreurDesc ); 
	}
}

function setFormPreconizedSettings() {
	var memory = 16;
	var addMemory = 0; 
	var time = 15;
	var addTime = 0; 
	
	var method = document.forms['install_page_init'].elements['form[operantingMode]'].value;
	switch (method) {
	case 'directCnx':
		l.Log[dbgInstFonction]( 'method=: ' + method );
		break;
	case 'createScript':
		l.Log[dbgInstFonction]( 'method=: ' + method );
		addMemory += 32;
		addTime += 20;
		break;
	}
	
	for ( var ptr in enabledDirectoryList ) {
		l.Log[dbgInstFonction]( 'enabledDirectoryList['+ptr+']=' + document.forms['install_page_init'].elements[enabledDirectoryList[ptr]].checked );
		addMemory += (document.forms['install_page_init'].elements[enabledDirectoryList[ptr]].checked == true) ? 16: 0;
		addTime += (document.forms['install_page_init'].elements[enabledDirectoryList[ptr]].checked == true) ? 25: 0;
	}
	
	document.forms['install_page_init'].elements['form[memoryLimit]'].value = (memory + addMemory);
	document.forms['install_page_init'].elements['form[execTimeLimit]'].value = (time + addTime);
	
}




// --------------------------------------------------------------------------------------------
// http://phplens.com/lens/adodb/docs-adodb.htm#drivers
var DBvsDALCompatility = {
	'MYSQLI': {
		'01': { 'val':'mysql' 	,	't':'MySQL 3.x/4.x/5.x'                        			  }
	},

	'PHPPDO': {
		'01': { 'val':'mysql' 		,	't':'MySQL 3.x/4.x/5.x'                          	},
		'02': { 'val':'pgsql' 		,	't':'PostgreSQL'                                 	},
		'03': { 'val':'sqlite' 		,	't':'SQLite 3 and SQLite 2'                      	},
		'04': { 'val':'oci' 		,	't':'Oracle Call Interface'                      	},
		'05': { 'val':'odbc' 		,	't':'ODBC v3 (IBM DB2, unix/win32 ODBC)' 			},
		'06': { 'val':'cubrid' 		,	't':'Cubrid'                                     	},
		'07': { 'val':'dblib' 		,	't':'FreeTDS/MS SQL Server/Sybase'    				},
		'08': { 'val':'firebird' 	,	't':'Firebird'                                   	},
		'09': { 'val':'ibm' 		,	't':'IBM DB2'                                    	},
		'10': { 'val':'informix' 	,	't':'IBM Informix Dynamic Server'                	},
		'11': { 'val':'sqlsrv' 		,	't':'MS SQL Server/SQL Azure' 			          	},
		'12': { 'val':'4d'			,	't':'4D'                                         	}
	},

	'ADODB': {
		 '1': { 'val':'mysql'			,	't':'MySQL (- transaction support)'				},
		 '2': { 'val':'mysqlt'			,	't':'MySQL (+ transaction support)'				},
		 '3': { 'val':'postgres64'		,	't':'PostgreSQL <=6.4'							},
		 '4': { 'val':'postgres7'		,	't':'PostgreSQL (LIMIT+v7'						},
		 '5': { 'val':'postgres8'		,	't':'PostgreSQL (v8)'							},
		 '6': { 'val':'postgres9'		,	't':'PostgreSQL (v9)'							},
		 '7': { 'val':'oci8'			,	't':'Oracle 8/9'								},
		 '8': { 'val':'oci805'			,	't':'Oracle 8.0.5'								},
		 '9': { 'val':'oci8po'			,	't':'Oracle 8/9 portable driver'				},
		'10': { 'val':'sqlite'			,	't':'SQLite'									},
		'11': { 'val':'access'			,	't':'icrosoft Access/Jet'						},  
		'12': { 'val':'ado'				,	't':'Generic ADO'								},
		'13': { 'val':'ado_access'		,	't':'Microsoft Access/Jet (ADO)'				},
		'14': { 'val':'ado_mssql'		,	't':'Microsoft SQL Server (ADO)'				},
		'15': { 'val':'db2'				,	't':'db2-specific'								},
		'16': { 'val':'db2oci'			,	't':'db2 OCI'									},
		'17': { 'val':'odbc_db2'		,	't':'DB2 (generic ODBC extension)'				},
		'18': { 'val':'vfp'				,	't':'Microsoft Visual FoxPro'					},
		'19': { 'val':'fbsql'			,	't':'FrontBase'									},
		'20': { 'val':'ibase'			,	't':'Interbase 6'								},
		'21': { 'val':'firebird'		,	't':'Firebird'									},
		'22': { 'val':'borland_ibase'	,	't':'Interbase 6.5 (Borland)'					},
		'23': { 'val':'informix'		,	't':'Generic informix (<v6.5)'					},
		'24': { 'val':'informix72'		,	't':'Informix databases (> 7.3)'				},
		'25': { 'val':'ldap'			,	't':'LDAP'										},
		'26': { 'val':'mssql'			,	't':'Microsoft SQL Server 7+'					},
		'27': { 'val':'mssqlpo'			,	't':'Portable mssql driver'						},
		'28': { 'val':'mssqlnative'		,	't':'Native mssql (M soft)'						},
		'29': { 'val':'odbc'			,	't':'Generic ODBC'								},
		'30': { 'val':'odbc_mssql'		,	't':'ODBC -> MSSQL'								},
		'31': { 'val':'odbc_oracle'		,	't':'ODBC  -> Oracle'							},
		'32': { 'val':'odbtp'			,	't':'Generic odbtp driver'						},
		'33': { 'val':'odbtp_unicode'	,	't':'Odtbp with unicode support'				},
		'34': { 'val':'oracle'			,	't':'Oracle 7 client API'						},
		'35': { 'val':'netezza'			,	't':'Netezza driver'							},
		'36': { 'val':'pdo'				,	't':'Generic PDO (PHP5)'						},
		'37': { 'val':'postgres'		,	't':'Generic PostgreSQL'						},
		'38': { 'val':'sapdb'			,	't':'SAP DB'									},
		'39': { 'val':'sqlanywhere'		,	't':'Sybase SQL Anywhere'						},
		'40': { 'val':'sqlitepo'		,	't':'Portable SQLite driver'					},
		'41': { 'val':'sybase'			,	't':'Sybase'									},
		'42': { 'val':'sybase_ase'		,	't':'Sybase ASE'								}
	},

	'PEARDB': {
		'01':  { 'val':'mysql'	 	,	't':'MySQL'												},
		'02':  { 'val':'sqlite' 	,	't':'SQlite'											}
	}
};

function SelectMenuBuilder ( MSObj1 , MSObj2 , Table ) {
	MSObj1 = elm.Gebi ( MSObj1 );
	MSObj2 = elm.Gebi ( MSObj2 );
	var MSObj1Sidx1 = MSObj1.options[MSObj1.selectedIndex].value;

	var ObjOption;
	while ( MSObj2.options.length ) {
		MSObj2.options[MSObj2.selectedIndex] = null;
	}

	for ( var Entree in Table ) {
		ObjOption = null;
		ObjOption = document.createElement('option');
		ObjOption.text = Table[Entree]['t'];
		ObjOption.value = Table[Entree]['val'];
		MSObj2.options.add(ObjOption);
	}

}
