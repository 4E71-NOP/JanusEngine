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

// Pas vraiment le plus beau des javascript du monde mais celui ci est facile a lire.
// Internet exploere N'EST PAS SUPPORTE. Pour le maintien de la flexibilité le cas spécial de MSIE est conservé. Cela permettra au code de pouvoir s'adapter à n'importe lequel des probleme de navigateur
// Ne pas confondre Edge et MSIE!


// Objets / Objects

//		Souris
//			PosX
//			PosY
//			bg
//			bm
//			bd
//			DerniereExec
//			Frequence

//cliEnv
//    os
//    screen
//    browser
//        agent
//        version
//        support
//    document
//        documentElement
//        domConfig
//        inputEncoding
//        implementation
//        URI
//        domain
//        mode
//        width
//        height

//if ( window != top ) { top.location.href = location.href; }


// --------------------------------------------------------------------------------------------
//
//	Fonction de deboggage
//
// --------------------------------------------------------------------------------------------
var JSGeneralDebug = 1;
var dbgStatique = 1;
var dbgSpecifique = 1;

function FJSJournal ( data ) {
	if (window.console && window.console.log) {
		if ( typeof data == "object" ) { console.table(data);}
		console.log(data);
	}
}
function Ignore(){}

var JSJournal = [ Ignore, FJSJournal ];
//JSJournal[](chaine);

// --------------------------------------------------------------------------------------------
//
// Détection du navigateur | Browser detection
//
// --------------------------------------------------------------------------------------------
var NavigateurListe = {
	'Chrome':	{	'chaine':navigator.userAgent,		'motif':'Chrome',	'retour':'Chrome',									'decalage':1,	'longueur':2		},
	'OmniWeb':	{ 	'chaine':navigator.userAgent,		'motif':'OmniWeb',	'retour':'OmniWeb',		motifExtraction:'OmniWeb/',	'decalage':1,	'longueur':2		},
	'Apple':	{	'chaine':navigator.vendor,			'motif':'Apple',	'retour':'Safari',		motifExtraction:'Version',	'decalage':1,	'longueur':2		},
	'Opera':	{	'chaine':window.opera,				'motif':'Opera',	'retour':'Opera',									'decalage':1,	'longueur':2		},
	'iCab':		{	'chaine':navigator.vendor,			'motif':'iCab',		'retour':'iCab',									'decalage':1,	'longueur':2		},
	'KDE':		{	'chaine':navigator.vendor,			'motif':'KDE',		'retour':'Konqueror',								'decalage':1,	'longueur':2		},
	'Firefox':	{	'chaine':navigator.userAgent,		'motif':'Firefox',	'retour':'Firefox',									'decalage':1,	'longueur':2		},
	'Camino':	{	'chaine':navigator.vendor,			'motif':'Camino',	'retour':'Camino',									'decalage':1,	'longueur':2		},
	'Netscape':	{	'chaine':navigator.userAgent,		'motif':'Netscape',	'retour':'Netscape',								'decalage':1,	'longueur':2		},
	'MSIE':		{	'chaine':navigator.userAgent,		'motif':'MSIE',		'retour':'Explorer',								'decalage':1,	'longueur':2		},
	'Gecko':	{	'chaine':navigator.userAgent,		'motif':'Gecko',	'retour':'Mozilla',		motifExtraction:'rv',		'decalage':1,	'longueur':2		},
	'Mozilla':	{ 	'chaine':navigator.userAgent,		'motif':'Mozilla',	'retour':'Netscape',								'decalage':1,	'longueur':2		},
	'Edge':		{ 	'chaine':navigator.userAgent,		'motif':'Edge',		'retour':'Edge',									'decalage':1,	'longueur':2		}
};

var	OSListe = {
	'0':	{	'chaine':navigator.platform,	'motif':'Win',		'retour':'Windows'		},
	'1':	{	'chaine':navigator.platform,	'motif':'Mac',		'retour':'Mac'			},
	'2':	{ 	'chaine':navigator.userAgent,	'motif':'iPhone',	'retour':'iPhone/iPad'	},
	'3':	{	'chaine':navigator.platform,	'motif':'Linux',	'retour':'Linux'		},
	'4':	{	'chaine':navigator.platform,	'motif':'Android',	'retour':'Android'		},
};

var NavSupportList = {
	'Chrome':		{
		'60':'DOM',		'61':'DOM',		'62':'DOM',		'63':'DOM',		'64':'DOM',		'65':'DOM',		'66':'DOM',		'67':'DOM',		'68':'DOM',		'69':'DOM',	
		'70':'DOM',		'71':'DOM',		'72':'DOM',		'73':'DOM',		'74':'DOM',		'75':'DOM',		'76':'DOM',		'77':'DOM',		'78':'DOM',		'79':'DOM',	
		'80':'DOM'
	},
	'Explorer':		{	'5':'MSIE5',	'6':'MSIE6',	'7':'MSIE7',	'8':'MSIE8',	'9':'MSIE9',
						'10':'MSIE10',	'11':'MSIE11'},
	'Firefox':		{
		'50':'DOM',		'51':'DOM',		'52':'DOM',		'53':'DOM',		'54':'DOM',		'55':'DOM',		'56':'DOM',		'57':'DOM',		'58':'DOM',		'59':'DOM',	
		'60':'DOM',		'61':'DOM',		'62':'DOM',		'63':'DOM',		'64':'DOM',		'65':'DOM',		'66':'DOM',		'67':'DOM',		'68':'DOM',		'69':'DOM',	
		'70':'DOM',		'71':'DOM',		'72':'DOM',		'73':'DOM',		'74':'DOM',		'75':'DOM',		'76':'DOM',		'77':'DOM',		'78':'DOM',		'79':'DOM',	
		'80':'DOM'
	},
	'Konqueror':	{	'1':'--',		'2':'--',	 	'3':'DOM',	 	'4':'DOM',		'5':'DOM',	
						'6':'DOM',		'7':'DOM',		'8':'DOM',		'9':'DOM',		'10':'DOM' },
	'Netscape':		{	'4':'--'													},
	'Opera':		{	'5':'DOM',		'6':'DOM',		'7':'DOM',		'7.55':'DOM',	'8':'DOM',
						'9':'DOM',		'10':'DOM',		'11':'DOM',		'12':'DOM',		'13':'DOM',
						'14':'DOM',		'15':'DOM'	},
	'Safari':		{	'1':'--',		'2':'--',	 	'3':'DOM',	 	'4':'DOM',		'5':'DOM',	
						'6':'DOM',		'7':'DOM',		'8':'DOM',		'9':'DOM',		'10':'DOM' },
	'inconnu':		{	'1':'DOM',		'2':'DOM',	 	'3':'DOM',	 	'4':'DOM'	}
};


function rchString ( data , extraction ) {
    var i, chaine, motif, retour, idx;
	for ( i in data ) {
		chaine = data[i].chaine;
		motif = data[i].motif;
		if ( chaine && chaine.indexOf( motif ) != -1 ) { 
			if ( extraction == 1 ) {
				if ( data[i].motifExtraction ) { motif = data[i].motifExtraction; }
				idx = chaine.indexOf( motif ) + motif.length + Number( data[i].decalage );		//ex 'Firefox/3.0' -> "Firefox".length + 1 = "3"
				retour = chaine.substring(idx , (idx + data[i].longueur) );
			}
			else { retour = data[i].retour; }
			return retour; 
		}
	}
}

var cliEnv = { 
	'os':{ 'platform':rchString( OSListe, 0 )},
	'screen':{ 'width':window.screen.width, 'height':window.screen.height },
	'browser':{
		'agent':rchString( NavigateurListe, 0 ), 
		'version':rchString( NavigateurListe, 1 ), 
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
}

cliEnv.browser.support = NavSupportList[cliEnv.browser.agent][cliEnv.browser.version];
cliEnv.browser.chaineComplete = NavigateurListe[cliEnv.browser.agent].chaine;

// --------------------------------------------------------------------------------------------
//
// Dimenssion de la fenetre du navigateur
//
// --------------------------------------------------------------------------------------------
var DivInitial = LocaliseElement ( 'initial_div' ); 

function ActualiseTailleFenetre ( mode ) {
	var x,y;
	switch ( cliEnv.browser.support ) {
	case 'MSIE7':
		x = document.body.offsetWidth;
		y = document.body.offsetHeight;
	break;
	default:
		x = window.innerWidth;
		y = window.innerHeight;
	break;
	}
	DivInitial = LocaliseElement ( 'initial_div' ); 

	switch ( mode ) {
		case 'x':	return x;	break;
		case 'y':	return y;	break;
		default: 
			if ( cliEnv ) {
				cliEnv.document.width = x;
				cliEnv.document.height = y;
			}
			var chaine = 'ActualiseTailleFenetre : x=' + x + '; y=' + y +"; Client: width=" + cliEnv.document.width + ", height=" + cliEnv.document.height;
			JSJournal[dbgStatique](chaine);
		break;
	}
}

ActualiseTailleFenetre ();
if ( !window.onresize ) { 
	window.onresize = function () { ActualiseTailleFenetre() };
}

cliEnv.document.width = ActualiseTailleFenetre('x');
cliEnv.document.height = ActualiseTailleFenetre('y');

JSJournal[dbgStatique](cliEnv);

// --------------------------------------------------------------------------------------------
//
// Get functions
//
// --------------------------------------------------------------------------------------------
function Gebi ( id ) { return document.getElementById( id ); }
function Gebn ( name ) { return document.getElementsByTagName( name ); }

// --------------------------------------------------------------------------------------------
//
//	Convertion de nombre
//
// --------------------------------------------------------------------------------------------
function d2h ( d ) {
	var dc = Number(d).toString(16); // buggy all the way long!
	if ( Number(d) < 16 ) { dc  = '0' + dc ; }
	return dc.substr(0,2);
}
function h2d ( h ) { return parseInt( String(h) , 16 ); } 


// --------------------------------------------------------------------------------------------
//
// Dedicated for button / Dédié aux boutons
//
// --------------------------------------------------------------------------------------------
function buttonHover ( Nom , Style ) { 
	Gebi( Nom + '01').className = Style +'01';
	Gebi( Nom + '02').className = Style +'02';
	Gebi( Nom + '03').className = Style +'03';
}

// --------------------------------------------------------------------------------------------
//
// Display DIV or not / Affichage de DIV ou pas
//
// --------------------------------------------------------------------------------------------
function CommuteAffichage ( DivID ) {
	var obj = Gebi( DivID ).style;
	(obj.visibility == 'visible') ? obj.visibility = 'hidden' : obj.visibility = 'visible';
	(obj.display != 'none') ? obj.display = 'none' : obj.display = 'block';
}

function CommuteAffichageCentre ( DivID ) {
	var obj = Gebi( DivID );
	if (obj.style.visibility == 'visible') {
		obj.style.visibility = 'hidden';
		obj.style.display = 'none';
	}
	if (obj.style.visibility == 'hidden') {
		switch ( cliEnv.browser.support ) {
		case 'DOM':		var ScrollY = window.pageYOffset;		break;
		case 'MSIE7':	var ScrollY = document.body.scrollTop;	break;
		}
		obj.style.visibility = 'visible';
		obj.style.display = 'block';

		// Il faut d'abord afficher pour que offsetWidth soit different de 0. Donc garder cet ordre des commandes.
		obj.style.left = Math.floor(( cliEnv.document.width - obj.offsetWidth ) / 2 ) + "px";
		obj.style.top = Math.floor((( cliEnv.document.height - obj.offsetHeight ) / 2) + ScrollY ) + "px";
	}
}

function RedimenssioneDiv ( DivID , DivX , DivY ) {
	Gebi( DivID ).style.width = DivX + 'px';
	Gebi( DivID ).style.height = DivY + 'px';
}

function AffichageElement ( DivID ) { Gebi( DivID ).style.visibility = 'visible'; 	Gebi( DivID ).style.display = 'block'; }
function DisparitionElement ( DivID ) { Gebi( DivID ).style.visibility = 'none';	Gebi( DivID ).style.display = 'none'; }



// --------------------------------------------------------------------------------------------
// Window Page Scroll Aptitude
var wpsa = {
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


function DivRemplissageEcran ( Div , action ) {
	switch ( action ) {
	case 0:
		wpsa[0][cliEnv.browser.support]();
		DisparitionElement ( Div );
	break;
	case 1:
		wpsa[1][cliEnv.browser.support]();
		switch ( cliEnv.browser.support ) {
		case 'DOM':		var ScrollY = window.pageYOffset;		break;
		case 'MSIE7':	var ScrollY = document.body.scrollTop;	break;
		}
		var Obj = Gebi(Div);
		Obj.style.top = ScrollY + 'px';
		Obj.style.left = 0 + 'px';

		Obj.style.width = Number(cliEnv.document.width) + 'px';
		Obj.style.height = Number(cliEnv.document.height) + 'px';
		AffichageElement ( Div );
	break;
	}
}

// --------------------------------------------------------------------------------------------
//
// Localise un element dans la page précisement | locate precisely an element in the document. 
//
// --------------------------------------------------------------------------------------------
// 0 screen absolut
// 1 par rapport au parent en relatif

function LocaliseElement ( ObjId ) {
	var Obj = Gebi ( ObjId );
	var ObjOrig = Obj;
	var Tx = 0, Ty = 0, Ocl = 0, Oct = 0, Osl = 0, Ost = 0;
	if ( Obj.offsetParent ) {
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

// --------------------------------------------------------------------------------------------
//
// Admin Switch position
//
// --------------------------------------------------------------------------------------------
// 0 	8	4
// 2	10	6
// 1	9	5

var AdminSwitchPositionTab = {
	'aspX': { 
		'0':function (){		return 0; },
		'1':function (){		return 0; },
		'2':function (){		return 0; },
		'4':function (dimX){	return (cliEnv.document.width - dimX); },
		'5':function (){		return 0; },
		'6':function (dimX){	return (cliEnv.document.width - dimX) },
		'8':function (dimX){	return (Math.floor ( (cliEnv.document.width/2) - (dimX/2) ) ); },
		'9':function (dimX){	return (Math.floor ( (cliEnv.document.width/2) - (dimX/2) ) ); },
		'10':function (dimX){	return (Math.floor ( (cliEnv.document.width/2) - (dimX/2) ) ); }
	},
	'aspY': { 
		'0':function (){		return 0; },
		'1':function (dimY){	return (cliEnv.document.height - dimY); },
		'2':function (dimY){	return (Math.floor ( (cliEnv.document.height/2) - (dimY/2) ) ); },
		'4':function (){		return 0; },
		'5':function (dimY){	return (cliEnv.document.height - dimY); },
		'6':function (dimY){	return (Math.floor ( (cliEnv.document.height/2) - (dimY/2) ) ); },
		'8':function (){		return 0; },
		'9':function (dimY){	return (cliEnv.document.height - dimY); },
		'10':function (dimY){	return (Math.floor ( (cliEnv.document.height/2) - (dimY/2) ) ); }
	}
};


function AdminSwitchPosition ( Div , Position , dimX , dimY ) {
	var aspX = AdminSwitchPositionTab['aspX'][Position](dimX);
	var aspY = AdminSwitchPositionTab['aspY'][Position](dimY);
	var Obj = Gebi ( Div );
	Obj.style.left = aspX + 'px';
	Obj.style.top = aspY + 'px';
	Obj.style.width = dimX + 'px';
	Obj.style.height = dimY + 'px';
}

// --------------------------------------------------------------------------------------------
//
//	Creation de la table de gestion des décorations des modules.
//
// --------------------------------------------------------------------------------------------

//Dans affiche_module.php : var TabInfoModule = new Array();
function JavaScriptTabInfoModule ( ModuleNom, DecoType ) {
	TabInfoModule[ModuleNom] = { 'module_nom':ModuleNom, 'deco_type':DecoType, 'DimConteneurX':'', 'DimConteneurY':'' };
	TabInfoModule[ModuleNom]['ex11'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex12'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex13'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex14'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex15'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex21'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex22'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex23'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex25'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex31'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex32'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex33'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex35'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex41'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex45'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex51'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex52'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex53'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex54'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['ex55'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in11'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in12'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in13'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in14'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in15'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in21'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in25'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in31'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in35'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in41'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in45'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in51'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in52'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in53'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in54'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
	TabInfoModule[ModuleNom]['in55'] = {	'Etat':1,	'DimX':0,	'DimY':0,	'PosX':0,	'PosY':0,	'DivObj':0	};
}


// --------------------------------------------------------------------------------------------
//
//	Modification d'element du DOM
//
// --------------------------------------------------------------------------------------------
function modifie_INPUT ( FormCible , InputCible , ValeurCible ) {
	var chaine = 'modifie_INPUT: ' + ValeurCible + ' -> ' + FormCible + '/' + InputCible;
	JSJournal[dbgStatique](chaine);
	document.forms[FormCible].elements[InputCible].value = ValeurCible;
}

function modifie_CSS_Element ( ElementCible , Propriete , ValeurCible ) {
	Gebi( ElementCible ).style.Propriete = 'ValeurCible';
}

// --------------------------------------------------------------------------------------------
function stopRKey (evt) {
	evt  = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) { return false; }
	else { return true; }
}
document.onkeypress = stopRKey;

// --------------------------------------------------------------------------------------------
//
// Fonction dédiée a la gestion de la souris | Dedicated functions for mouse management
//
// --------------------------------------------------------------------------------------------
var Souris = { 'PosX':0,	'PosY':0,	
'bg':0,	'bm':0,	'bd':0,
'DerniereExec':0,	'Frequence':(1000/200)
}; 
var SourisListe = {};

function SourisPosition ( e ) {
	switch ( cliEnv.browser.support ) {
	case 'DOM':
		Souris.PosX = e.pageX;
		Souris.PosY = e.pageY;
	break;
	case 'MSIE7':
		Souris.PosX = window.event.x + document.body.scrollLeft;
		Souris.PosY = window.event.y + document.body.scrollTop;
	break;
	}

	var MTime = (new Date()).getTime() 
	var Maintenant = MTime - Souris.DerniereExec;
	if ( Maintenant > Souris.Frequence ) {
		for ( var i in SourisListe ) { window[SourisListe[i]](); }
		Souris.DerniereExec = MTime;
	}
}

function SourisCurseurDefault ()	{ document.body.style.cursor = 'default'; }
function SourisCurseurCrosshair ()	{ document.body.style.cursor = 'crosshair'; }
function SourisCurseurPointer ()	{ document.body.style.cursor = 'pointer'; }
function SourisCurseurWait ()		{ document.body.style.cursor = 'wait'; }

document.onmousemove = SourisPosition;
// --------------------------------------------------------------------------------------------
// Ain't none tha f*** with
function DoNothing(){}

