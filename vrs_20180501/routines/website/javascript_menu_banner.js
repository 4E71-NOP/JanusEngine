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
var dbgMenuBanner = 1;

var PremierBanner = 0;

function InitMenuBanner ( Tab ) {
	for ( var ptr in Tab ) {
		var ObjP = Gebi ( String( Tab[ptr].pere ) );
		Tab[ptr].pere = ObjP; 

		ObjP.onmouseover 	= menuBannerPereIn;
		ObjP.onmouseout 	= menuBannerPereOut;
		ObjP.MWMClassA 		= String( Tab[ptr].cssa ) ;
		ObjP.MWMClassB 		= String( Tab[ptr].cssb ) ;
		ObjP.MWMDockCible 	= Number( Tab[ptr].dock ) ;
		ObjP.MWMTable 		= Tab;

		var alignDiv = LocaliseElement ( ObjP.id );
		if ( PremierBanner == 0 ) {
			var initialDiv = LocaliseElement ( 'initial_div' ); // compensate first div relative position
			var PremierADLeft = alignDiv.px - initialDiv.px;
			PremierBanner = 1;	
		}

		if ( Tab[ptr].Nfils == 1 ) {
			var ObjF = Gebi ( String( Tab[ptr].fils ) );
			Tab[ptr].fils 		= ObjF; 
			ObjP.MWMFils 		= ObjF;
			ObjP.MWMNFils 		= 1;
			ObjF.onmouseover 	= menuBannerFilsIn;
			ObjF.onmouseout 	= menuBannerFilsOut;
			ObjF.MWMPere 		= ObjP;
			ObjF.MWMAnimation 	= "";

			var ObjFCenter = Math.floor( ObjF.offsetWidth / 2 );
			var ObjFMiddle = Math.floor( ObjF.offsetHeight / 2 );

			var ADTop 		= alignDiv.py;
			var ADMiddle 	= ( alignDiv.cy - ObjFMiddle );
			var ADBottom 	= ( alignDiv.py + alignDiv.dy );
			var ADLeft 		= alignDiv.px;
			var ADRight 	= ( alignDiv.px + alignDiv.dx );
			var ADCenter 	= ( alignDiv.cx - ObjFCenter );

			switch ( ObjP.MWMDockCible ) {
			case 0 :	ObjF.style.top = ADTop + 'px';		ObjF.style.left = ADLeft + 'px';		break;
			case 1 :	ObjF.style.top = ADBottom + 'px';	ObjF.style.left = ADLeft + 'px';		break;
			case 4 :	ObjF.style.top = ADTop + 'px';		ObjF.style.left = ADRight + 'px';		break;
			case 5 :	ObjF.style.top = ADBottom + 'px';	ObjF.style.left = ADRight + 'px';		break;
			case 8 :	ObjF.style.top = ADTop + 'px';		ObjF.style.left = ADCenter + 'px';		break;
			case 9 :	ObjF.style.top = ADBottom + 'px';	ObjF.style.left = ADCenter + 'px';		break;
			case 10 :	ObjF.style.top = ADBottom + 'px';	ObjF.style.left = PremierADLeft + 'px';	break;
			}
		}
	}

	JSJournal[dbgMenuBanner](
	'Id=' + ObjP.id + 
	'alignDiv.px=' + alignDiv.px + 
	'alignDiv.py=' + alignDiv.py + 
	'alignDiv.dx=' + alignDiv.dx + 
	'alignDiv.dy=' + alignDiv.dy + 
	'alignDiv.cx=' + alignDiv.cx + 
	'alignDiv.cy=' + alignDiv.cy + 
	'ADTop=' + ADTop + 
	'ADMiddle=' + ADMiddle + 
	'ADBottom=' + ADBottom + 
	'ADLeft=' + ADLeft + 
	'ADRight=' + ADRight + 
	'ADCenter=' + ADCenter + 
	'Tab[ptr].fils=' + String( Tab[ptr].fils ) + 
	'ObjP.MWMDockCible=' + ObjP.MWMDockCible + 
	'PremierBanner=' + PremierBanner + 
	'PremierADLeft=' + PremierADLeft
	);
}

/*
['top-left']		= 0;
['bottom-left']		= 1;
['top-right']		= 4;
['bottom-right']	= 5;
['top-center']		= 8;
['bottom-center']	= 9;
Pure banner			= 10
*/

function menuBannerPereIn () {
	var Tab = this.MWMTable;
	for ( var ptr in Tab ) { 
		if ( Tab[ptr].Nfils == 1 ) { Tab[ptr].fils.style.visibility = 'hidden'; }
		Tab[ptr].pere.className = Tab[ptr].pere.MWMClassA;
	}
	if ( this.MWMNFils == 1 ) {
		clearTimeout( this.MWMFils.MWMAnimation );
		this.MWMFils.style.visibility = 'visible';
	}
	this.className = this.MWMClassB;
}

function menuBannerFilsIn () {
	clearTimeout( this.MWMAnimation );
	this.MWMPere.className = this.MWMPere.MWMClassB;
}


function menuBannerPereOut () { 
	if ( this.MWMNFils == 1 ) {
		this.MWMFils.MWMAnimation 	= setTimeout( 'menuBannerOutExec( \'' + this.MWMFils.id + '\' )' , 500 );
	}
	else { this.className = this.MWMClassA; }
}
function menuBannerFilsOut () { this.MWMAnimation 			= setTimeout( 'menuBannerOutExec( \'' + this.id + '\' )' , 500 ); }

function menuBannerOutExec ( Obj ) {
	Obj = Gebi ( Obj );
	Obj.style.visibility = 'hidden';
	Obj.MWMPere.className = Obj.MWMPere.MWMClassA;
}
