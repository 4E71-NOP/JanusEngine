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

var dbgPopMenu = 0;
var TypeAction = 1;			//1 Mouseover 2 Click
var NbrAnimParSec = 40;

// --------------------------------------------------------------------------------------------
//FT Fondu Transparent
//TH Taille Horizontale (100 vers 0% , 1 vers 100%)
//TV Taille verticale (100 vers 0% , 1 vers 100%)
//GV[S;C] Glissement Vertical [Sinus; Cosinus]
//GH[S;C] Glissement Horizontal [Sinus; Cosinus]
//DLS[S;C] Dilatation Letter Space [Sinus; Cosinus]
//DLH[S;C] Dilatation Line-Height [Sinus; Cosinus]
//SC Simple commutation
//BANNER - banner
//BANNERFT - banner avec fondu transparent
// --------------------------------------------------------------------------------------------

var ChoixAnimation = {};
ChoixAnimation.ftgvs =  				new CreationAnimation ( 'FT GVS',						'0 50',					'0 1',					128 , 125 , 250 , 125 );
ChoixAnimation.ftgvc =					new CreationAnimation ( 'FT GVC',						'0 50',					'0 1',					128 , 125 , 250 , 125 );
						
ChoixAnimation.ftghsdlssth =			new CreationAnimation ( 'FT GHS DLSS TH',				'0 100 15 1',			'0 2 0 2',				128 , 125 , 250 , 500 );
ChoixAnimation.ftgvsdlhstv =			new CreationAnimation ( 'FT GVS DLHS TV',				'0 100 20 1',			'0 2 0 2',				128 , 125 , 250 , 500 );
						
ChoixAnimation.ftgvsghs =				new CreationAnimation ( 'FT GVS GHS',					'0 100 50',				'0 2 2',				128 , 125 , 250 , 500 );
ChoixAnimation.ftgvsghc =				new CreationAnimation ( 'FT GVS GHC',					'0 100 50',				'0 2 2',				128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghs =				new CreationAnimation ( 'FT GVC GHS',					'0 100 50',				'0 2 2',				128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghc =				new CreationAnimation ( 'FT GVC GHC',					'0 100 50',				'0 2 2',				128 , 125 , 250 , 500 );
						
ChoixAnimation.ftgvsghstv =				new CreationAnimation ( 'FT GVS GHS TV',				'0 100 50 1',			'0 2 2 2',				128 , 125 , 250 , 500 );
ChoixAnimation.ftgvsghctv =				new CreationAnimation ( 'FT GVS GHC TV',				'0 100 50 1',			'0 2 2 2',				128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghstv =				new CreationAnimation ( 'FT GVC GHS TV',				'0 100 50 1',			'0 2 2 2',				128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghctv =				new CreationAnimation ( 'FT GVC GHC TV',				'0 100 50 1',			'0 2 2 2',				128 , 125 , 250 , 500 );
						
ChoixAnimation.ftgvsghsth =				new CreationAnimation ( 'FT GVS GHS TH',				'0 100 50 1',			'0 2 2 2',				128 , 125 , 250 , 500 );
ChoixAnimation.ftgvsghcth =				new CreationAnimation ( 'FT GVS GHC TH',				'0 100 50 1',			'0 2 2 2',				128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghsth =				new CreationAnimation ( 'FT GVC GHS TH',				'0 100 50 1',			'0 2 2 2',				128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghcth =				new CreationAnimation ( 'FT GVC GHC TH',				'0 100 50 1',			'0 2 2 2',				128 , 125 , 250 , 500 );
						
ChoixAnimation.ftgvsghstvdlhs =			new CreationAnimation ( 'FT GVS GHS TV DLHS',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvsghctvdlhs =			new CreationAnimation ( 'FT GVS GHC TV DLHS',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghstvdlhs =			new CreationAnimation ( 'FT GVC GHS TV DLHS',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghctvdlhs =			new CreationAnimation ( 'FT GVC GHC TV DLHS',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
						
ChoixAnimation.ftgvsghsthdlss =			new CreationAnimation ( 'FT GVS GHS TH DLSS',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvsghcthdlss =			new CreationAnimation ( 'FT GVS GHC TH DLSS',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghsthdlss =			new CreationAnimation ( 'FT GVC GHS TH DLSS',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghcthdlss =			new CreationAnimation ( 'FT GVC GHC TH DLSS',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
						
ChoixAnimation.ftgvsghstvdlhc =			new CreationAnimation ( 'FT GVS GHS TV DLHC',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvsghctvdlhc =			new CreationAnimation ( 'FT GVS GHC TV DLHC',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghstvdlhc =			new CreationAnimation ( 'FT GVC GHS TV DLHC',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghctvdlhc =			new CreationAnimation ( 'FT GVC GHC TV DLHC',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
						
ChoixAnimation.ftgvsghsthdlsc =			new CreationAnimation ( 'FT GVS GHS TH DLSC',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvsghcthdlsc =			new CreationAnimation ( 'FT GVS GHC TH DLSC',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghsthdlsc =			new CreationAnimation ( 'FT GVC GHS TH DLSC',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
ChoixAnimation.ftgvcghcthdlsc =			new CreationAnimation ( 'FT GVC GHC TH DLSC',			'0 100 50 1 20',		'0 2 2 2 0',			128 , 125 , 250 , 500 );
						
ChoixAnimation.ftth =					new CreationAnimation ( 'FT TH',						'0 1',					'0 2',					128 , 125 , 250 , 500 );
ChoixAnimation.fttv =					new CreationAnimation ( 'FT TV',						'0 1',					'0 2',					128 , 125 , 250 , 500 );
						
ChoixAnimation.sc =						new CreationAnimation ( 'SC',							'0',					'0',					0 , 0 , 0 , 0 );
						
ChoixAnimation.banner =					new CreationAnimation ( 'BANNER',						'0 0',					'0 0',					0 , 0 , 0 , 0 );
ChoixAnimation.bannerft =				new CreationAnimation ( 'BANNERFT',						'0 0',					'0 0',					0 , 0 , 50 , 0 );

ChoixAnimation.ftgvsghcthtvdlscdlhc =	new CreationAnimation ( 'FT GVS GHC TH TV DLSC DLHC',	'0 100 100 1 1 5 50',	'0 2 2 2 2 0 0',		128 , 125 , 250 , 500 );

// --------------------------------------------------------------------------------------------
// Lfa = liste fonction
// LTb = liste animation
// LTA/B = Argument A/B 
// e(ntree)c(ompteur)a(ttente)/d(urée)
// s(ortie)c(ompteur)a(ttente)/d(urée)
// eca/d Entree Compteur Attente/Delais
// sca/d Sortie Compteur Attente/Delais
function CreationAnimation ( Liste , ArgsA , ArgsB , ECA , ECD , SCA , SCD ) {
	this.Lfa = Liste;
	this.LTb = Liste.split(' ');
	this.LTA = ArgsA.split(' ');
	this.LTB = ArgsB.split(' ');

	this.eca = ECA;
	this.ecd = ECD;
	this.sca = SCA;
	this.scd = SCD;
}

// ----------------------------------------------------------------------------------------------------------------------------
function InitMenuDiv ( Tab , ModuleInfo ) {
	var menuX = 0 , menuY = 0;

// Trouve la position du premier menu qui servira de base.
	for ( var Rcn in Tab ) {
		switch ( Tab[Rcn].typ ) {
		case 'div':	
			if ( Tab[Rcn].p == 'root' ) { var PositionRacine = elm.LocateElement ( Tab[Rcn].id ); }
		}
	}

	for ( var ptr in Tab ) {
		var Obj = elm.Gebi ( String(Tab[ptr].id ) );

		Obj.HdrBackupStyle_marginTop		= Obj.style.marginTop;
		Obj.HdrBackupStyle_opacticy			= Obj.style.opacity;
		Obj.HdrBackupStyle_MozOpacity		= Obj.style.MozOpacity;
		Obj.HdrBackupStyle_filter			= Obj.style.filter;
		Obj.HdrBackupStyle_zIndex			= Obj.style.zIndex;
		Obj.HdrBackupStyle_letterSpacing	= Obj.style.letterSpacing;
		Obj.HdrBackupStyle_lineHeight		= Obj.style.lineHeight;
		Obj.HdrBackupStyle_lineHeightN		= Number(Obj.style.lineHeight.replace( RegExp ('px', 'g') , '' ));
		Obj.HdrBackupStyle_width			= Number (Tab[ptr].width);
		Obj.HdrBackupStyle_height			= Obj.clientHeight;

		Obj.Hdr_Root				= 1;
		Obj.Hdr_Type				= Tab[ptr].typ;
		Obj.Hdr_Directory			= Number ( Tab[ptr].dos );
		Obj.Hdr_State				= 1;
		Obj.Hdr_PlannedAnimation	= 0;
		Obj.Hdr_Progression			= 0;
		Obj.Hdr_Direction			= 0;
		Obj.Hdr_Level				= Number ( Tab[ptr].niv );
		Obj.Hdr_Deco				= Number ( Tab[ptr].deco );
		Obj.Hdr_Animation			= Tab[ptr].anim;
		Obj.Hdr_Parent				= elm.Gebi ( Tab[ptr].p );
		Obj.Hdr_StopPropagation		= 1;

// Ajoute des sentinelles d'évennement au lieu de remplacer (Obj.onmouseover='xxx') pour laisser les animations déjà en place.
		if( Obj.addEventListener ) { 
			Obj.addEventListener('mouseover' , CustomEventMouseOver,false); 
			Obj.addEventListener('mouseout' , CustomEventMouseOut,false); 
			Obj.addEventListener('click' , CustomEventMouseClick,false); 
		} 
		else if( Obj.attachEvent ) { 
			Obj.attachEvent('mouseover' , CustomEventMouseOver); 
			Obj.attachEvent('mouseout' , CustomEventMouseOut); 
			Obj.attachEvent('click' , CustomEventMouseClick); 
		}

		switch ( Tab[ptr].typ ) {
		case 'div':
			if ( Tab[ptr].p != 'root' && Tab[ptr].niv != 0) {

				var DivHauteurAjuste = Number ( (Tab[ptr].le * Tab[ptr].nbent ) + 48) ;
				if ( DivHauteurAjuste > Tab[ptr].min_height ) { ModuleInfo[Tab[ptr].id]['DimConteneurY'] = DivHauteurAjuste; }
				else { ModuleInfo[Tab[ptr].id]['DimConteneurY'] = Tab[ptr].min_height; }

				Obj.Hdr_State = 0;
				Obj.Hdr_Root = 0;
				//if ( Tab[ptr].niv == 0 ) { Obj.style.visibility = 'visible'; } else { Obj.style.visibility = 'hidden'; }
				Obj.style.display = 'block';
				Obj.MWM_AnimationEnCoursOUT = 0;
				Obj.MWM_AnimationEnCoursIN = 0;

				var CotesDuParent = elm.LocateElement ( Tab[ptr].p );
				var initialDiv = elm.LocateElement ( 'initial_div' ); // compensate first div relative position

				switch ( Number(Tab[ptr].cible) ) {
				case 0 :	var NewDivPx = ( CotesDuParent.px - initialDiv.px );						var NewDivPy = ( CotesDuParent.py - initialDiv.py ); 	break;	// cible
				case 1 :	var NewDivPx = ( CotesDuParent.px - initialDiv.px );						var NewDivPy = ( CotesDuParent.py + CotesDuParent.dy );	break;	// 0  8  4
				case 2 :	var NewDivPx = ( CotesDuParent.px - initialDiv.px );						var NewDivPy = ( CotesDuParent.cy - initialDiv.py ); 	break;	// 2  10 6
				case 4 :	var NewDivPx = ( CotesDuParent.px + CotesDuParent.dx - initialDiv.px );		var NewDivPy = ( CotesDuParent.py - initialDiv.py ); 	break;	// 1  9  5
				case 5 :	var NewDivPx = ( CotesDuParent.px + CotesDuParent.dx - initialDiv.px );		var NewDivPy = ( CotesDuParent.py + CotesDuParent.dy) ;	break;
				case 6 :	var NewDivPx = ( CotesDuParent.px + CotesDuParent.dx - initialDiv.px );		var NewDivPy = ( CotesDuParent.cy - initialDiv.py ); 	break;
				case 8 :	var NewDivPx = ( CotesDuParent.cx - initialDiv.px );						var NewDivPy = ( CotesDuParent.py - initialDiv.py ); 	break;
				case 9 :	var NewDivPx = ( CotesDuParent.cx - initialDiv.px );						var NewDivPy = ( CotesDuParent.py + CotesDuParent.dy );	break;
				case 10 :	
					CotesDuParent = elm.LocateElement ( Tab[ptr].AlignRef );
					var NewDivPx = ( CotesDuParent.px - initialDiv.px );						var NewDivPy = ( CotesDuParent.py + CotesDuParent.dy - initialDiv.py ); 	
				break;
				}
				Obj.style.left = ( Number(NewDivPx) + Number(Tab[ptr].decal_x) ) + 'px';
				Obj.style.top = ( Number(NewDivPy) + Number(Tab[ptr].decal_y) ) + 'px';

				Obj.HdrBackupStyle_top				= Obj.style.top;
				Obj.HdrBackupStyle_left			= Obj.style.left;

				var DivDecoList = Obj.childNodes;
				for ( var IdxDeco = 0 ; IdxDeco < Obj.childNodes.length ; IdxDeco++ ) {
					if ( DivDecoList[IdxDeco].nodeName == "DIV" ) {
						DivDecoList[IdxDeco].onmouseover = CustomEventMouseOver;
						DivDecoList[IdxDeco].onmouseout = CustomEventMouseOut;
						DivDecoList[IdxDeco].onmousedown = CustomEventMouseClick;
					}
				}
			dm.UpdateDecoModule ( TabInfoModule , Tab[ptr].id );
			}
		break;
		case 'a':
			if ( Obj.Hdr_Directory == 1 ) { 
				Obj.MWM_Fils = Tab[ptr].f.a1;
				var ObjF = elm.Gebi ( Obj.MWM_Fils );
				var ObjP = Obj.parentNode.style;
				
				l.Log[dbgPopMenu]('ObjP.left=' + ObjP.left + 
				', ObjP.width=' + ObjP.width + 
				', Tab[ptr].ent=' + Tab[ptr].ent + 
				', ObjP.top=' + ObjP.top + 
				', Obj.style.marginTop=' + Obj.style.marginTop + 
				', Obj.style.marginBottom=' + Obj.style.marginBottom);
			}
		break;
		}
		if ( Tab[ptr].p != 'root' ) { 
			Obj.Hdr_State = 0;
			Obj.Hdr_Root = 0;
		}

		l.Log[dbgPopMenu](
		'Id='				+ Tab[ptr].id +
		', p='				+ Tab[ptr].p +
		', niv='			+ Tab[ptr].niv +
		', dos='			+ Tab[ptr].dos +
		', typ='			+ Tab[ptr].typ +
		', EtatMenu='		+ Tab[ptr].EtatMenu +
		', AnimPrevue='		+ Tab[ptr].AnimPrevue +
		', Progression='	+ Tab[ptr].Progression +
		', Sens='			+ Tab[ptr].Sens +
		', f='				+ Tab[ptr].f);
	}
}



function CustomEventMouseOver ( e ) {
	if ( !e ) { e = window.event; }
	switch ( TypeAction ) {
	case 1:
		switch ( de.cliEnv.browser.support ) {
		case 'MSIE7':	
			e.cancelBubble = true;	
			e.returnValue = false;	
			if ( e.srcElement.Hdr_StopPropagation ) { var CibleFinale = e.srcElement; }
			else { var CibleFinale = e.srcElement.parentNode; }	
		break;
		default:		
			e.stopPropagation();	
			e.preventDefault();
			if ( e.target.Hdr_StopPropagation ) { var CibleFinale = e.target; }
			else { var CibleFinale = e.target.parentNode; }	
		break;
		}
		GestionMenu ( CibleFinale , 1 );
	break;
	}
}

function CustomEventMouseOut ( e ) {
	if ( !e ) { e = window.event; }
	switch ( de.cliEnv.browser.support ) {
	case 'MSIE7':
		e.cancelBubble = true;	
		e.returnValue = false;	
		if ( e.srcElement.Hdr_StopPropagation ) { var CibleFinale = e.srcElement; }
		else { var CibleFinale = e.srcElement.parentNode; }	
	break;
	default:		
		e.stopPropagation();	
		e.preventDefault();
		if ( e.target.Hdr_StopPropagation ) { var CibleFinale = e.target; }
		else { var CibleFinale = e.target.parentNode; }	
	break;
	}
	GestionMenu ( CibleFinale , 0 );
}


function CustomEventMouseClick ( e ) { 
	switch ( TypeAction ) {
	case 2:
		var CibleEvennement , CibleFinale , ElementActuel , Origine;
		if ( !e ) { e = window.event; }
		switch ( de.cliEnv.browser.support ) {
		case 'MSIE7':
			e.cancelBubble = true;	
			e.returnValue = false;	
			if ( e.srcElement.Hdr_StopPropagation ) { var CibleFinale = e.srcElement; }
			else { var CibleFinale = e.srcElement.parentNode; }	
		break;
		default:		
			e.stopPropagation();	
			e.preventDefault();
			if ( e.target.Hdr_StopPropagation ) { var CibleFinale = e.target; }
			else { var CibleFinale = e.target.parentNode; }	
		break;
		}
		GestionMenu ( CibleFinale , 1 );
	break;
	}
}

// ----------------------------------------------------------------------------------------------------------------------------
//Tab = window[Tab];
//Np Nettoyage parent
//AParents Action sur parent 0 ferme / 1 ouvre
//NPoB pose timer pour animation / 0 out , 1 in
function GestionMenu ( Obj , TypeEve ) {
	var a = 0, b = '', c = '', Np = 0, AParents = 0, AFils = 0, Secu = 0;

	if ( TypeEve == 1 ) { a = a + 32; b += '32_'; }
	switch ( Obj.Hdr_Type ) {
	case 'a':		
		a = a + 16; b += '16_';
		if ( Obj.Hdr_Directory == 1 ) {
			a = a + 8; b += '8_';
			var ObjF = elm.Gebi ( Obj.MWM_Fils );
			if ( ObjF.Hdr_State != 0 )	{ a = a + 4; b += '4_'; }
			if ( ObjF.Hdr_PlannedAnimation == 1 )	{ a = a + 2; b += '2_'; }
			if ( ObjF.Hdr_Progression > 0 )	{ a = a + 1; b += '1_'; }
		}
	break;
	case 'div':
		if ( Obj.Hdr_State != 0 )	{ a = a + 4; b += '4_'; }
		if ( Obj.Hdr_PlannedAnimation == 1 )	{ a = a + 2; b += '2_'; }
		if ( Obj.Hdr_Progression > 0 )	{ a = a + 1; b += '1_'; }
	break;
	}

	switch ( a ) {
	case 4 :	Np = 1;	AParents = 10;	AFils = 99;		break;
	case 6 :	
	case 7 :	Np = 1;	AParents = 20;	AFils = 99;		break;
	case 28 :	Np = 1;	AParents = 99;	AFils = 10;		break;
	case 26 :
	case 30 :
	case 31 :	Np = 1;	AParents = 99;	AFils = 20;		break;
	case 36 :	
	case 38 :	
	case 39 :	
	case 48 :	Np = 1;	AParents = 21;	AFils = 99;		break;
	case 56 :	Np = 1;	AParents = 21;	AFils = 11;		break;
	case 58 :	
	case 59 :	
	case 62 :	
	case 63 :	Np = 1;	AParents = 21;	AFils = 21;		break;
	default:	break;
	}
	var MTime = (new Date()).getTime();

	var Ptr = 0;
	if ( Np == 1 ) {
		if ( Obj.Hdr_Type == 'a' ) {
			ObjF = elm.Gebi ( Obj.MWM_Fils );
			switch ( AFils ) {
			case 10 :
				ObjF.Hdr_Direction = 0;	ObjF.Hdr_PlannedAnimation = 1;	Ptr = ObjF.Hdr_Animation;
				ObjF.MWM_AnimationEnCoursOUT = setTimeout( 'CacheSousMenuExplorateur ( \'' + ObjF.id + '\' );' , ChoixAnimation[Ptr].sca );
			break;
			case 11 :
				ObjF.Hdr_Direction = 1;	ObjF.Hdr_PlannedAnimation = 1;	Ptr = ObjF.Hdr_Animation;
				ObjF.MWM_AnimationEnCoursIN = setTimeout( 'AfficheSousMenuExplorateur ( \'' + ObjF.id + '\' );' , ChoixAnimation[Ptr].eca );
			break;
			case 20 :	NettoyageTimers ( ObjF , 0 );		break;
			case 21 :	NettoyageTimers ( ObjF , 1 );		break;
			}
		}

		while ( Np == 1 ) {
			if ( Obj.Hdr_Root == 1 || Obj.Hdr_Level == 0 ) { Np = 0; }
			if ( Obj.Hdr_Type == 'div' && Np == 1 ) {
				switch ( AParents ) {
				case 10 :
					NettoyageTimers ( Obj , 0 );
					Obj.Hdr_Direction = 0;	Obj.Hdr_PlannedAnimation = 1;	Ptr = Obj.Hdr_Animation;
					Obj.MWM_AnimationEnCoursOUT = setTimeout( 'CacheSousMenuExplorateur ( \'' + Obj.id + '\' );' , ChoixAnimation[Ptr].sca );
				break;
				case 11 :
					NettoyageTimers ( Obj , 1 );
					Obj.Hdr_Direction = 1;	Obj.Hdr_PlannedAnimation = 1;	Ptr = Obj.Hdr_Animation;
					Obj.MWM_AnimationEnCoursIN = setTimeout( 'AfficheSousMenuExplorateur ( \'' + Obj.id + '\' );' , ChoixAnimation[Ptr].eca );
				break;
				case 20 :	NettoyageTimers ( Obj , 0 );	break;
				case 21 :	NettoyageTimers ( Obj , 1 );	break;
				}
			}
			Obj = Obj.Hdr_Parent;
		}
	}
}

function AfficheSousMenuExplorateur ( ObjId ) {
	var Obj = elm.Gebi( ObjId ), Ptr = Obj.Hdr_Animation;
	Obj.MWM_AnimationEnCoursIN = setTimeout( 'GestionnaireAnimation ( \'' + ObjId + '\' );', ( ChoixAnimation[Ptr].ecd / 10 ) );
}
 
function CacheSousMenuExplorateur ( ObjId ) {
	var Obj = elm.Gebi( ObjId ), Ptr = Obj.Hdr_Animation;
	Obj.MWM_AnimationEnCoursOUT = setTimeout( 'GestionnaireAnimation ( \'' + ObjId + '\' );', ( ChoixAnimation[Ptr].scd / 10 ) );
}


function NettoyageTimers ( Obj , Sens ) {
	var a = ( Sens * 2 );
	if ( Obj.Hdr_Progression > 0 ) { a = a + 1; }
	switch ( a ) {
	case 0 :	clearTimeout( Obj.MWM_AnimationEnCoursIN );		Obj.Hdr_Direction = 0;	Obj.Hdr_PlannedAnimation = 0;	break;
	case 1 :													Obj.Hdr_Direction = 0;									break;
	case 2 :	clearTimeout( Obj.MWM_AnimationEnCoursOUT );	Obj.Hdr_Direction = 1;	Obj.Hdr_PlannedAnimation = 0;	break;
	case 3 :													Obj.Hdr_Direction = 1;									break;
	}
}

// ----------------------------------------------------------------------------------------------------------------------------
function GestionnaireAnimation ( ObjId ) {
	var Obj = elm.Gebi( ObjId );

	if ( Obj.Hdr_Progression < 1 ) {
		Obj.Hdr_State = 2;
		var NombreDePas = ( 1000 / NbrAnimParSec );
		var Ptr = Obj.Hdr_Animation;
		for ( var Elm in ChoixAnimation[Ptr].LTb ) {
			switch ( ChoixAnimation[Ptr].LTb[Elm] ) {
			case 'FT':			FonduTransparent			( Obj , ChoixAnimation[Ptr].LTA[Elm] );	break
			case 'TH':			TailleHorizontale			( Obj , ChoixAnimation[Ptr].LTA[Elm] , ChoixAnimation[Ptr].LTB[Elm] );	break
			case 'TV':			TailleVerticale				( Obj , ChoixAnimation[Ptr].LTA[Elm] , ChoixAnimation[Ptr].LTB[Elm] );	break
			case 'GVS':			GlissementVerticalSin		( Obj , ChoixAnimation[Ptr].LTA[Elm] , ChoixAnimation[Ptr].LTB[Elm] );	break
			case 'GVC':			GlissementVerticalCos		( Obj , ChoixAnimation[Ptr].LTA[Elm] , ChoixAnimation[Ptr].LTB[Elm] );	break
			case 'GHS':			GlissementHorizontalSin		( Obj , ChoixAnimation[Ptr].LTA[Elm] , ChoixAnimation[Ptr].LTB[Elm] );	break
			case 'GHC':			GlissementHorizontalCos		( Obj , ChoixAnimation[Ptr].LTA[Elm] , ChoixAnimation[Ptr].LTB[Elm] );	break
			case 'DLSS':		DilatationLetterSpacingSin	( Obj , ChoixAnimation[Ptr].LTA[Elm] );	break
			case 'DLSC':		DilatationLetterSpacingCos	( Obj , ChoixAnimation[Ptr].LTA[Elm] );	break
			case 'DLHS':		DilatationLineHeightSin		( Obj , ChoixAnimation[Ptr].LTA[Elm] );	break
			case 'DLHC':		DilatationLineHeightCos		( Obj , ChoixAnimation[Ptr].LTA[Elm] );	break
			case 'BANNER':		SimpleCommutation			( Obj , ChoixAnimation[Ptr].LTA[Elm] );	break
			case 'BANNERFT':	FonduTransparent			( Obj , ChoixAnimation[Ptr].LTA[Elm] );	break
			case 'SC':			SimpleCommutation			( Obj , ChoixAnimation[Ptr].LTA[Elm] );	break
			}
		}
		switch ( Obj.Hdr_Direction ) {
		case 0 :	clearTimeout( Obj.MWM_AnimationEnCoursIN );		Obj.MWM_AnimationEnCoursOUT =	setTimeout( 'GestionnaireAnimation ( \'' + Obj.id + '\' );', ( ChoixAnimation[Ptr].scd / NombreDePas ) );	Obj.style.zIndex = Obj.HdrBackupStyle_zIndex - 1; break;
		case 1 :	clearTimeout( Obj.MWM_AnimationEnCoursOUT );	Obj.MWM_AnimationEnCoursIN =	setTimeout( 'GestionnaireAnimation ( \'' + Obj.id + '\' );', ( ChoixAnimation[Ptr].ecd / NombreDePas ) );	Obj.style.zIndex = Obj.HdrBackupStyle_zIndex + 1; break;
		}
		Obj.Hdr_Progression = Obj.Hdr_Progression + ( 1 / NombreDePas );
	}
	else {
		switch ( Obj.Hdr_Direction ) {
		case 0 :
			clearTimeout( Obj.MWM_AnimationEnCoursOUT );
			Obj.style.visibility 		= 'hidden';
			Obj.style.display 			= 'none';
			Obj.Hdr_State 				= 0;
		break;
		case 1 :
			clearTimeout( Obj.MWM_AnimationEnCoursIN );
			Obj.style.visibility 		= 'visible';
			Obj.style.display 			= 'block';
			Obj.Hdr_State 				= 1;
		break;
		}
		Obj.Hdr_Progression 		= 0;
		Obj.Hdr_PlannedAnimation 	= 0;

		Obj.style.top 			= Obj.HdrBackupStyle_top;
		Obj.style.left 			= Obj.HdrBackupStyle_left;
		Obj.style.width 		= Obj.HdrBackupStyle_width +'px';
		Obj.style.height 		= Obj.HdrBackupStyle_height +'px';
		Obj.style.marginTop 	= Obj.HdrBackupStyle_marginTop;
		Obj.style.opacity 	 	= Obj.HdrBackupStyle_opacticy;
		Obj.style.MozOpacity 	= Obj.HdrBackupStyle_MozOpacity;
		Obj.style.filter 		= Obj.HdrBackupStyle_filter;
		Obj.style.zIndex 		= Obj.HdrBackupStyle_zIndex;
		Obj.style.letterSpacing = Obj.HdrBackupStyle_letterSpacing;
	}
}

// ----------------------------------------------------------------------------------------------------------------------------
function SimpleCommutation ( Obj ) {
	switch ( Obj.Hdr_Direction ) {
	case 0 :	Obj.style.visibility = 'hidden';	Obj.style.display = 'none';		break;
	case 1 :	Obj.style.visibility = 'visible';	Obj.style.display = 'block';	break;
	}
	Obj.Hdr_Progression = 2;
}


function FonduTransparent ( Obj ) {
	var ProgressionSin = Math.sin(Math.PI * Obj.Hdr_Progression / 2);
	var a = ( Obj.Hdr_Direction * 2 );
	if ( de.cliEnv.browser.support == 'MSIE7' ) { a = a + 1 }
	switch ( a ) {
	case 0 :	Obj.style.opacity =  Obj.style.MozOpacity = 1 - ProgressionSin;					break;
	case 1 :	Obj.style.filter = 'alpha(opacity=' + (100 - (ProgressionSin * 100)) + ')';		break;
	case 2 :	Obj.style.opacity =  Obj.style.MozOpacity = ProgressionSin;						break;
	case 3 :	Obj.style.filter = 'alpha(opacity=' + ( ProgressionSin * 100 ) + ')';			break;
	}
	Obj.style.visibility 	= 'visible';		
	Obj.style.display 		= '';
}


function GlissementVerticalSin ( Obj , da , db ) { 
	switch ( Obj.Hdr_Direction ) {
	case 0 :	var ProgressionSin = Math.sin(( Math.PI / 2 ) * ( 1 - Obj.Hdr_Progression ));	break;
	case 1 :	var ProgressionSin = Math.sin(( Math.PI / 2 ) * Obj.Hdr_Progression );			break;
	}
	switch ( Number( db ) ) {
	case 1 :	Obj.style.marginTop = ( Math.floor(( 0 - da ) + ( ProgressionSin * da ))) + 'px';	break;
	case 2 :	Obj.style.marginTop = ( Math.floor( da - ( ProgressionSin * da ))) + 'px';			break;
	}
}

function GlissementVerticalCos ( Obj , da , db ) { 
	switch ( Obj.Hdr_Direction ) {
	case 0 :	var ProgressionSin = Math.cos(( Math.PI / 2 ) * ( 1 - Obj.Hdr_Progression ));	break;
	case 1 :	var ProgressionSin = Math.cos(( Math.PI / 2 ) * Obj.Hdr_Progression );			break;
	}
	switch ( Number( db ) ) {
	case 1 :	Obj.style.marginTop = ( Math.floor( 0 - ( ProgressionSin * da ))) + 'px';	break;
	case 2 :	Obj.style.marginTop = ( Math.floor( ProgressionSin * da )) + 'px';			break;
	}
}

function GlissementHorizontalSin ( Obj , da , db ) { 
	switch ( Obj.Hdr_Direction ) {
	case 0 :	var ProgressionSin = Math.sin(( Math.PI / 2 ) * ( 1 - Obj.Hdr_Progression ));	break;
	case 1 :	var ProgressionSin = Math.sin(( Math.PI / 2 ) * Obj.Hdr_Progression );			break;
	}
	switch ( Number( db ) ) {
	case 1 :	Obj.style.marginLeft = ( Math.floor(( 0 - da ) + ( ProgressionSin * da ))) + 'px';	break;
	case 2 :	Obj.style.marginLeft = ( Math.floor( da - ( ProgressionSin * da ))) + 'px';			break;
	}
}

function GlissementHorizontalCos ( Obj , da , db ) { 
	switch ( Obj.Hdr_Direction ) {
	case 0 :	var ProgressionSin = Math.cos(( Math.PI / 2 ) * ( 1 - Obj.Hdr_Progression ));	break;
	case 1 :	var ProgressionSin = Math.cos(( Math.PI / 2 ) * Obj.Hdr_Progression );			break;
	}
	switch ( Number( db ) ) {
	case 1 :	Obj.style.marginLeft = ( Math.floor( 0 - ( ProgressionSin * da ))) + 'px';	break;
	case 2 :	Obj.style.marginLeft = ( Math.floor( ProgressionSin * da )) + 'px';			break;
	}
}

function TailleHorizontale ( Obj , da , db ) { 
	var TRef = Obj.HdrBackupStyle_width;
	var Action = Obj.Hdr_Direction + ( da * 2 );

	switch ( Action ) {
	case 0 :	var ProgressionSin = Math.sin(Math.PI * Obj.Hdr_Progression / 2);			TabInfoModule[Obj.id]['DimConteneurX'] = Math.floor( TRef - ( ProgressionSin * TRef * db ) );	break;
	case 1 :	var ProgressionSin = Math.sin(Math.PI * ( 1 - Obj.Hdr_Progression ) / 2);	TabInfoModule[Obj.id]['DimConteneurX'] = Math.floor( TRef - ( ProgressionSin * TRef * db ) );	break;
	case 2 :	var ProgressionSin = Math.sin(Math.PI * Obj.Hdr_Progression / 2);			TabInfoModule[Obj.id]['DimConteneurX'] = Math.floor( TRef + ( ProgressionSin * TRef * db ) );	break;
	case 3 :	var ProgressionSin = Math.sin(Math.PI * ( 1 - Obj.Hdr_Progression ) / 2);	TabInfoModule[Obj.id]['DimConteneurX'] = Math.floor( TRef + ( ProgressionSin * TRef * db ) );	break;
	}
	dm.UpdateDecoModule ( TabInfoModule , Obj.id );

	str = 'Obj.id:' + Obj.id + '; ModuleNom:' + TabInfoModule[Obj.id]['module_name'] +'; DimConteneurX:' + TabInfoModule[Obj.id]['DimConteneurX'];
	l.Log[dbgPopMenu](str);

}

function TailleVerticale ( Obj , da , db ) {
	var TRef = Obj.HdrBackupStyle_height;
	var Action = Obj.Hdr_Direction + ( da * 2 );
	switch ( Action ) {
	case 0 :	var ProgressionSin = Math.sin(Math.PI * Obj.Hdr_Progression / 2);			TabInfoModule[Obj.id]['DimConteneurY'] = Math.floor( TRef - ( ProgressionSin * TRef * db ) );	break;
	case 1 :	var ProgressionSin = Math.sin(Math.PI * ( 1 - Obj.Hdr_Progression ) / 2);	TabInfoModule[Obj.id]['DimConteneurY'] = Math.floor( TRef - ( ProgressionSin * TRef * db ) );	break;
	case 2 :	var ProgressionSin = Math.sin(Math.PI * Obj.Hdr_Progression / 2);			TabInfoModule[Obj.id]['DimConteneurY'] = Math.floor( TRef + ( ProgressionSin * TRef * db ) );	break;
	case 3 :	var ProgressionSin = Math.sin(Math.PI * ( 1 - Obj.Hdr_Progression ) / 2);	TabInfoModule[Obj.id]['DimConteneurY'] = Math.floor( TRef + ( ProgressionSin * TRef * db ) );	break;
	}
	dm.UpdateDecoModule ( TabInfoModule , Obj.id );

}

function DilatationLetterSpacingSin ( Obj , da ) { 
	switch ( Obj.Hdr_Direction ) {
	case 0 :	var ProgressionSin = Math.sin(Math.PI * Obj.Hdr_Progression / 2);			break;
	case 1 :	var ProgressionSin = Math.sin(Math.PI * ( 1 - Obj.Hdr_Progression ) / 2);	break;
	}
	Obj.style.letterSpacing = '+' + ( Math.floor( ProgressionSin * Number( da ) )) + 'px';
}

function DilatationLetterSpacingCos ( Obj , da ) { 
	switch ( Obj.Hdr_Direction ) {
	case 0 :	var ProgressionSin = Math.cos(Math.PI * Obj.Hdr_Progression / 2);			break;
	case 1 :	var ProgressionSin = Math.cos(Math.PI * ( 1 - Obj.Hdr_Progression ) / 2);	break;
	}
	Obj.style.letterSpacing = '+' + ( Math.floor( ProgressionSin * Number( da ) )) + 'px';
}

function DilatationLineHeightSin ( Obj , da ) { 
	switch ( Obj.Hdr_Direction ) {
	case 0 :	var ProgressionSin = Math.sin(Math.PI * Obj.Hdr_Progression / 2);				break;
	case 1 :	var ProgressionSin = Math.sin(Math.PI * ( 1 - Obj.Hdr_Progression ) / 2);		break;
	}
	Obj.style.lineHeight = ( Math.floor( Obj.HdrBackupStyle_lineHeightN + ( ProgressionSin * Number( da ) ) ) ) + 'px';	//Haaaaaaaaaaaaaaaaaaaaaaaa!!!!!!!!!!!!!!!!!
	var Objex22 = elm.Gebi ( Obj.id + '_ex22' );
	Objex22.style.lineHeight = Obj.style.lineHeight
}

function DilatationLineHeightCos ( Obj , da ) { 
	switch ( Obj.Hdr_Direction ) {
	case 0 :	var ProgressionSin = Math.cos(Math.PI * Obj.Hdr_Progression / 2);			break;
	case 1 :	var ProgressionSin = Math.cos(Math.PI * ( 1 - Obj.Hdr_Progression ) / 2);	break;
	}
	Obj.style.lineHeight = ( Math.floor( Obj.HdrBackupStyle_lineHeightN + ( ProgressionSin * Number( da ) ))) + 'px';
	var Objex22 = elm.Gebi ( Obj.id + '_ex22' );
	Objex22.style.lineHeight = Obj.style.lineHeight
}
