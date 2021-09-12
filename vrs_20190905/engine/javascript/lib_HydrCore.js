/*jshint globals: true*/
// --------------------------------------------------------------------------------------------
//
//	MWM - Multi Web Manager
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.com
//
// --------------------------------------------------------------------------------------------

// Clearly not the best javascript in the world but this is readable to me.
// Internet explorer IS NOT SUPPORTED. But for the sake of flexibility the special case of MSIE is handled. It will enable the code to be adaptable to any future issue with browsers.
// Do not mix up MS Edge and MSIE!

// --------------------------------------------------------------------------------------------
//
//	Deboggaging function
//
// --------------------------------------------------------------------------------------------
class HydrGlobalConfig {
	constructor () {
		this.GeneralDebug = 1;
		this.CoreDbg = 1;
	}
}

class Log {
	constructor () {
		this.Log = [ this.Ignore, this.LogToConsole ];
	}
	
	LogToConsole (data) {
		if (window.console && window.console.log) {
			if ( typeof data == "object" ) { console.table(data);}
			console.log(data);
		}
	}
	Ignore(){}
}

// --------------------------------------------------------------------------------------------
//
// Browser detection
//
// --------------------------------------------------------------------------------------------
class DetectionEnvironment {
	constructor () {
		
		this.userAgentDataImplemented = false;
		this.GeoLocationCurrentPosition = false;
		
		this.NavUsrAgent = navigator.userAgent;
		this.NavPlatform = navigator.platform;
		
		this.BrowserList = {
			'Chrome':	{	'string':this.NavUsrAgent,		'pattern':'Chrome',		'response':'Chrome',										'offset':1,	'length':2		},
			'OmniWeb':	{ 	'string':this.NavUsrAgent,		'pattern':'OmniWeb',	'response':'OmniWeb',		patternExtraction:'OmniWeb/',	'offset':1,	'length':2		},
			'Apple':	{	'string':navigator.vendor,			'pattern':'Apple',		'response':'Safari',		patternExtraction:'Version',	'offset':1,	'length':2		},
			'Opera':	{	'string':window.opera,				'pattern':'Opera',		'response':'Opera',											'offset':1,	'length':2		},
			'iCab':		{	'string':navigator.vendor,			'pattern':'iCab',		'response':'iCab',											'offset':1,	'length':2		},
			'KDE':		{	'string':navigator.vendor,			'pattern':'KDE',		'response':'Konqueror',										'offset':1,	'length':2		},
			'Firefox':	{	'string':this.NavUsrAgent,		'pattern':'Firefox',	'response':'Firefox',										'offset':1,	'length':2		},
			'Camino':	{	'string':navigator.vendor,			'pattern':'Camino',		'response':'Camino',										'offset':1,	'length':2		},
			'Netscape':	{	'string':this.NavUsrAgent,		'pattern':'Netscape',	'response':'Netscape',										'offset':1,	'length':2		},
			'MSIE':		{	'string':this.NavUsrAgent,		'pattern':'MSIE',		'response':'Explorer',										'offset':1,	'length':2		},
			'Gecko':	{	'string':this.NavUsrAgent,		'pattern':'Gecko',		'response':'Mozilla',		patternExtraction:'rv',			'offset':1,	'length':2		},
			'Mozilla':	{ 	'string':this.NavUsrAgent,		'pattern':'Mozilla',	'response':'Netscape',										'offset':1,	'length':2		},
			'Edge':		{ 	'string':this.NavUsrAgent,		'pattern':'Edge',		'response':'Edge',											'offset':1,	'length':2		}
		};
		
		this.OSList = {
			'0':	{	'string':this.NavPlatform,	'pattern':'Win',		'response':'Windows'		},
			'1':	{	'string':this.NavPlatform,	'pattern':'Mac',		'response':'Mac'			},
			'2':	{ 	'string':this.NavUsrAgent,	'pattern':'iPhone',		'response':'iPhone/iPad'	},
			'3':	{	'string':this.NavPlatform,	'pattern':'Linux',		'response':'Linux'			},
			'4':	{	'string':this.NavPlatform,	'pattern':'Android',	'response':'Android'		},
		};

		this.BrowserSupportList = {
			'Chrome':		{},
			'Explorer':		{},
			'Firefox':		{},
			'Konqueror':	{	'1':'--',		'2':'--' },
			'Netscape':		{	'4':'--' },
			'Opera':		{},
			'Safari':		{	'1':'--',		'2':'--' },
			'inconnu':		{}
		};

		var browserSection = this.BrowserSupportList.Chrome;
		for (let i=60 ; i<=100 ; i++ ) { browserSection[i] = "DOM"; }
		
		browserSection = this.BrowserSupportList.Explorer;
		for (let i=5 ; i<=15 ; i++ ) { browserSection[i] = "MSIE"+i; }

		var browserSection = this.BrowserSupportList.Firefox;
		for (let i=60 ; i<=200 ; i++ ) { browserSection[i] = "DOM"; }

		var browserSection = this.BrowserSupportList.Konqueror;
		for (let i=3 ; i<=200 ; i++ ) { browserSection[i] = "DOM"; }
		
		var browserSection = this.BrowserSupportList.Opera;
		for (let i=5 ; i<=200; i++ ) { browserSection[i] = "DOM"; }

		var browserSection = this.BrowserSupportList.Safari;
		for (let i=3 ; i<=200; i++ ) { browserSection[i] = "DOM"; }

		var browserSection = this.BrowserSupportList.inconnu;
		for (let i=1 ; i<=200; i++ ) { browserSection[i] = "DOM"; }
		
		
		
		if (navigator.userAgentData) { this.userAgentDataImplemented = true; }
		
		if ("geolocation" in navigator) { navigator.geolocation.getCurrentPosition(
			this.geoSuccess, 
			this.geoFailure, {
				enableHighAccuracy: true,
				timeout: 5000,
				maximumAge: 0
				} 
			);
		}		
		
		
		this.cliEnv = {
			'featureDetection' : {
				'geolocationCurrentPosition':this.GeoLocationCurrentPosition,
				'userAgentDataImplemented':this.userAgentDataImplemented,
			},
			'os':{ 'platform':this.SearchString(this.OSList, 0 )},
			'screen':{ 'width':window.screen.width, 'height':window.screen.height },
			'browser':{
				'agent':this.SearchString(this.BrowserList, 0 ), 
				'version':this.SearchString(this.BrowserList, 1 ), 
			},
			'document':{ 
				'documentElement':document.documentElement,
				'domConfig':document.domConfig,
				'inputEncoding':document.inputEncoding,
				'implementation':document.implementation,
				'URI':document.documentURI,
				'domain':document.domain,
				'mode':document.documentMode
			}
		};
		
		this.cliEnv.browser.support = this.BrowserSupportList[this.cliEnv.browser.agent][this.cliEnv.browser.version];
		this.cliEnv.browser.CompleteName = this.BrowserList[this.cliEnv.browser.agent].string;
	
	}
	
	geoSuccess(pos) { this.GeoLocationCurrentPosition = pos; }
	geoFailure(err) { console.log('navigator.geolocation.getCurrentPosition not available'); }
	
	SearchString (data, extraction) {
		let str, ptrn, res, idx;
		for (let i in data) {
			str = data[i].string;
			ptrn = data[i].pattern;
			if (str && str.indexOf(ptrn) != -1) { 
				if (extraction == 1) {
					if (data[i].patternExtraction) {ptrn = data[i].patternExtraction;}
					idx = str.indexOf(ptrn) + ptrn.length + Number(data[i].offset);		// ex
																						// 'Firefox/3.0'
																						// ->
																						// "Firefox".length
																						// + 1
																						// =
																						// "3"
					res = str.substring(idx , (idx + data[i].length) );
				}
				else { res = data[i].response; }
				return res; 
			}
		}
	}
	
}


// --------------------------------------------------------------------------------------------
//
// Element handling.
// getElement, hide/show, ressize etc.
//
// --------------------------------------------------------------------------------------------
// At this point instead of creating new object
// 'cfg'(as HydrGlobalConfig type).
// 'de' (as DetectionEnvironment type).
// 'l' (as Log type).

class ElementHandling {
	constructor(){
		this.DivInitial = {}; 
		
		this.wpsa = {
				'0':{
					'DOM':function (){ 
						document.body.style.overflow = '';
						document.body.scrollTop = '';
					},
					'MSIE7':function(){
						document.body.scroll = 'yes';
						document.body.style.overflow = 'scroll';
					}
				},
				'1':{
					'DOM':function (){ 
						document.body.style.overflow = 'hidden';		},
					'MSIE7':function(){
						document.body.scroll = 'no';
						document.body.style.overflow = 'hidden';
					}
				}
			};
		
		// 0 8 4
		// 2 10 6
		// 1 9 5
		this.AdminSwitchLocationTab = {
			'aspX': { 
				 '0':function (){		return 0; },
				 '1':function (){		return 0; },
				 '2':function (){		return 0; },
				 '4':function (dimX){	return (de.cliEnv.document.width - dimX); },
				 '5':function (){		return 0; },
				 '6':function (dimX){	return (de.cliEnv.document.width - dimX) },
				 '8':function (dimX){	return (Math.floor ( (de.cliEnv.document.width/2) - (dimX/2) ) ); },
				 '9':function (dimX){	return (Math.floor ( (de.cliEnv.document.width/2) - (dimX/2) ) ); },
				'10':function (dimX){	return (Math.floor ( (de.cliEnv.document.width/2) - (dimX/2) ) ); }
			},
			'aspY': { 
				 '0':function (){		return 0; },
				 '1':function (dimY){	return (de.cliEnv.document.height - dimY); },
				 '2':function (dimY){	return (Math.floor ( (de.cliEnv.document.height/2) - (dimY/2) ) ); },
				 '4':function (){		return 0; },
				 '5':function (dimY){	return (de.cliEnv.document.height - dimY); },
				 '6':function (dimY){	return (Math.floor ( (de.cliEnv.document.height/2) - (dimY/2) ) ); },
				 '8':function (){		return 0; },
				 '9':function (dimY){	return (de.cliEnv.document.height - dimY); },
				'10':function (dimY){	return (Math.floor ( (de.cliEnv.document.height/2) - (dimY/2) ) ); }
			}
		};
		
	}
	
	/**
	 * Get element by Id
	 */
	Gebi (id) { return document.getElementById(id); }
	
	/**
	 * Get element by name
	 */
	Gebn (name) { return document.getElementsByTagName(name); }
	
	/**
	 * Updates windows size (o returns information depending on 'mode')
	 */
	UpdateWindowSize (mode) {
		var x,y;
		switch (de.cliEnv.browser.support) {
		case 'MSIE7':
			x = document.body.offsetWidth;
			y = document.body.offsetHeight;
		break;
		default:
			x = window.innerWidth;
			y = window.innerHeight;
		break;
		}
		this.DivInitial = this.LocateElement ('initial_div'); 
	
		switch ( mode ) {
			case 'x':	return x;	break;
			case 'y':	return y;	break;
			default: 
				if (de.cliEnv) {
					de.cliEnv.document.width = x;
					de.cliEnv.document.height = y;
				}
// var str = 'UpdateWindowSize : x=' + x + '; y=' + y +"; Client: width=" +
// de.cliEnv.document.width + ", height=" + de.cliEnv.document.height;
// l.Log[cfg.CoreDbg](str);
			break;
		}
	}
	
	/**
	 * Locate an element and returns an array containing all position
	 * information. 0 screen absolute 1 relative to parent
	 */
	LocateElement (ObjId) {
		var Obj = this.Gebi (ObjId);
		var ObjOrig = Obj;
		var Tx = 0, Ty = 0, Ocl = 0, Oct = 0, Osl = 0, Ost = 0;
		if (Obj.offsetParent) {
			do {
				Osl = ( Obj.scrollLeft != null ? Obj.scrollLeft : 0); 
				Ost = ( Obj.scrollTop != null ? Obj.scrollTop : 0); 
				Ocl = ( Obj.clientLeft != null ? Obj.clientLeft : 0); 
				Oct = ( Obj.clientTop != null ? Obj.clientTop : 0);
				Tx += ( Obj.offsetLeft + Ocl - Osl );
				Ty += ( Obj.offsetTop + Oct - Ost );
			} while ( !!( Obj = Obj.offsetParent ) );
		}
		var Dx = Number ( ObjOrig.offsetWidth );
		var Dy = Number ( ObjOrig.offsetHeight );
		var Cx = Tx + Math.floor ( Dx / 2 );
		var Cy = Ty + Math.floor ( Dy / 2 );
		return { 'ObjId' : ObjId , 'px': Tx , 'py': Ty , 'dx': Dx , 'dy': Dy , 'cx': Cx , 'cy': Cy };
	}
	
	/**
	 * 
	 */
	SwitchDisplay (DivID) {
		var obj = this.Gebi(DivID).style;
		(obj.visibility == 'visible') ? obj.visibility = 'hidden' : obj.visibility = 'visible';
		(obj.display != 'none') ? obj.display = 'none' : obj.display = 'block';
	}
	
	/**
	 * 
	 */
	SwitchDisplayCenter (DivID) {
		var obj = this.Gebi( DivID );
		if (obj.style.visibility == 'visible') {
			obj.style.visibility = 'hidden';
			obj.style.display = 'none';
		}
		if (obj.style.visibility == 'hidden') {
			switch ( de.cliEnv.browser.support ) {
			case 'DOM':		var ScrollY = window.pageYOffset;		break;
			case 'MSIE7':	var ScrollY = document.body.scrollTop;	break;
			}
			// It must be visible in order for offsetWidth to be processed
			// properly (!=0). Keep the commands order!
			obj.style.visibility = 'visible';
			obj.style.display = 'block';
			obj.style.left = Math.floor(( de.cliEnv.document.width - obj.offsetWidth ) / 2 ) + "px";
			obj.style.top = Math.floor((( de.cliEnv.document.height - obj.offsetHeight ) / 2) + ScrollY ) + "px";
		}
	}
	
	/**
	 * Resize a div with 2 imputs
	 */
	ResizeDiv (DivID, DivX, DivY) {
		this.Gebi( DivID ).style.width = DivX + 'px';
		this.Gebi( DivID ).style.height = DivY + 'px';
	}
	
	/**
	 * Makes an element visible
	 */
	Show (DivID) { this.Gebi( DivID ).style.visibility = 'visible';	this.Gebi( DivID ).style.display = 'block'; }

	/**
	 * Hides an element using visibility
	 */
	Hide (DivID) { this.Gebi( DivID ).style.visibility = 'none';	this.Gebi( DivID ).style.display = 'none'; }
	
	/**
	 * Change the classname upon hiver on the buttons (3 divs button)
	 */
	ButtonHover (Name , Style) { 
		this.Gebi( Name + '01').className = Style +'01';
		this.Gebi( Name + '02').className = Style +'02';
		this.Gebi( Name + '03').className = Style +'03';
	}
	
	/**
	 * Fills the screen by resizing a DIV
	 */
	FillScreenDiv (Div, action) {
		switch (action) {
		case 0:
			this.wpsa[0][de.cliEnv.browser.support]();
			this.Hide (Div);
		break;
		case 1:
			this.wpsa[1][de.cliEnv.browser.support]();
			switch ( de.cliEnv.browser.support ) {
			case 'DOM':		var ScrollY = window.pageYOffset;		break;
			case 'MSIE7':	var ScrollY = document.body.scrollTop;	break;
			}
			var Obj = this.Gebi(Div);
			Obj.style.top = ScrollY + 'px';
			Obj.style.left = 0 + 'px';

			Obj.style.width		= Number(de.cliEnv.document.width) + 'px';
			Obj.style.height	= Number(de.cliEnv.document.height) + 'px';
			this.Show(Div);
		break;
		}
	}
	
	/**
	 * 
	 */
	SetAdminSwitchLocation (Div, Position, dimX, dimY) {
		var aspX = this.AdminSwitchLocationTab['aspX'][Position](dimX);
		var aspY = this.AdminSwitchLocationTab['aspY'][Position](dimY);
		var Obj = this.Gebi (Div);
		Obj.style.left = aspX + 'px';
		Obj.style.top = aspY + 'px';
		Obj.style.width = dimX + 'px';
		Obj.style.height = dimY + 'px';
	}
	
	/**
	 * 
	 */
	SetFormInputValue (formTarget, inputTarget, value) {
		var str = 'SetFormInputValue: ' + value + ' -> ' + formTarget + '/' + inputTarget;
		l.Log[cfg.CoreDbg](str);
		document.forms[formTarget].elements[inputTarget].value = value;
	}

	/**
	 * 
	 */
	 SetElementValue (ElementTarget, Property, value) {
		this.Gebi(ElementTarget).style.Property = 'value';
	}
	
	
	
}



// --------------------------------------------------------------------------------------------
//
// Number conversion
//
// --------------------------------------------------------------------------------------------
class StringFormat {
	constructor(){}
	
	/**
	 * Converts a decimal number to Hexadecimal
	 */
	D2h ( d ) {
		var dc = Number(d).toString(16); // buggy all the way long!
		if ( Number(d) < 16 ) { dc  = '0' + dc ; }
		return dc.substr(0,2);
	}
	
	/**
	 * Converts a Hexadecimal number to decimal
	 */
	H2d ( h ) { return parseInt( String(h) , 16 ); }
}

// --------------------------------------------------------------------------------------------
//
// Keyboard
//
// --------------------------------------------------------------------------------------------
class KeyboardManagement {
	constructor(){}
	
	/**
	 * 
	 */
	ListenToKeyPressed(){
			document.onkeypress = function(e) {
			var kCode = (typeof e.which == "number") ? e.which : e.keyCode;
			if (kCode > 0) {
				l.Log[cfg.CoreDbg]("key pressed: code="+kCode + " : " + String.fromCharCode(kCode)); 
			}
		};
	}
	StopListeningToKeyPressed(){
		document.onkeypress = null;
	}
}


// --------------------------------------------------------------------------------------------
//
// Mouse management
//
// --------------------------------------------------------------------------------------------
class MouseManagement {
	constructor(){
		this.mouseData = { 
				'PosX':0,	'PosY':0,	
				'bg':0,	'bm':0,	'bd':0,
				'lastExec':0,	'Frequency':(1000/200)
		}; 
		this.mouseFunctionList = {};
	}
	
	/**
	 * Every object added to the list of 'things to do' MUST have a method
	 * called 'MouseEvent()'.
	 */
	LocateMouse (e) {
		switch (de.cliEnv.browser.support ) {
		case 'DOM':
			this.mouseData.PosX = e.pageX;
			this.mouseData.PosY = e.pageY;
			break;
		case 'MSIE7':
			this.mouseData.PosX = window.event.x + document.body.scrollLeft;
			this.mouseData.PosY = window.event.y + document.body.scrollTop;
			break;
		}
		
		var MTime = (new Date()).getTime() 
		var now = MTime - this.mouseData.lastExec;
		if ( now > this.mouseData.Frequency ) {
			for ( var i in this.mouseFunctionList ) {
// l.Log[cfg.CoreDbg]("LocateMouse : " + this.mouseFunctionList[i].obj+";
// method:"+this.mouseFunctionList[i].method);
				var obj = this.mouseFunctionList[i].obj;
				obj.MouseEvent();
			}
			this.mouseData.lastExec = MTime;
		}
// l.Log[cfg.CoreDbg]("Mouse Location:
// PosX="+this.mouseData.PosX+"PosY="+this.mouseData.PosY);
	}
	
	SetCursorDefault ()		{ document.body.style.cursor = 'default'; }
	SetCursorCrosshair ()	{ document.body.style.cursor = 'crosshair'; }
	SetCursorPointer ()		{ document.body.style.cursor = 'pointer'; }
	SetCursorWait ()		{ document.body.style.cursor = 'wait'; }
}


// --------------------------------------------------------------------------------------------
//
// Decoration managment
//
// --------------------------------------------------------------------------------------------

// In affiche_module.php : var TabInfoModule = new Array();
class ModuleManagement {
	constructor (){}
	
	/**
	 * Add a generic table into the TabInfoModule array
	 */
	AddModule ( ModuleName, DecoType ) {
		TabInfoModule[ModuleName] = { 'module_name':ModuleName, 'deco_type':DecoType, 'DimConteneurX':'', 'DimConteneurY':'' };
		TabInfoModule[ModuleName]['ex11'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex12'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex13'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex14'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex15'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex21'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex22'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex23'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex25'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex31'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex32'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex33'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex35'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex41'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex45'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex51'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex52'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex53'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex54'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['ex55'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in11'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in12'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in13'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in14'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in15'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in21'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in25'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in31'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in35'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in41'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in45'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in51'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in52'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in53'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in54'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
		TabInfoModule[ModuleName]['in55'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	}
}


// --------------------------------------------------------------------------------------------
//	
// Initialization

var cfg	= new HydrGlobalConfig();
var l	= new Log();
var de	= new DetectionEnvironment(); 
var elm	= new ElementHandling ();
var k	= new KeyboardManagement();
var m	= new MouseManagement();
var mod = new ModuleManagement();
var sf	= new StringFormat();

elm.DivInitial = elm.LocateElement ('initial_div'); 

// elm.UpdateWindowSize();
if ( !window.onresize ) {
	window.onresize = function () { elm.UpdateWindowSize(); };
	// An anonymous function calling the class.method() is better than assinging
	// a class.method.
	// in this 2nd case the function will loose the object.method scope.
	// therefore it will not be able to call other methods in the same class
	// using the word 'this' as this function thinks its alone.

}
de.cliEnv.document.width	= elm.UpdateWindowSize('x');
de.cliEnv.document.height	= elm.UpdateWindowSize('y');

l.Log[cfg.CoreDbg]("_______________________Dump Javascript_______________________");
l.Log[cfg.CoreDbg](de.cliEnv);

// document.onkeypress = k.stopRKey;
document.onmousemove = function (e) { m.LocateMouse(e);};

// If you need to get the keycode typed.
//k.ListenToKeyPressed();

