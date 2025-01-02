// --------------------------------------------------------------------------------------------
//
//	JnsEng - Janus Engine
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.com
//
// --------------------------------------------------------------------------------------------

// --------------------------------------------------------------------------------------------
// MWM Colorpicker Vrs 1.00 2010/03 
// 
// Just visit -> http://en.wikipedia.org/wiki/HSL_and_HSV
// --------------------------------------------------------------------------------------------
var dbgColorPicker = 1;


function MWMCPAffiche ( e , ChangeMode ) {
	if ( !ChangeMode ) {
		e 			= e || window.event;
		var Obj 	= e.target || e.srcElement;
		var dimX 	= Obj.offsetWidth;
		var dimY 	= Obj.offsetHeight;
		var sizeX 	= Obj.style.size;

		if ( MWMCP.TypePositionnement == 2 ) {	
			var localisation = elm.SwitchDisplayCenter( Obj.id , 0 ); 
			InputEnCours.CPX = localisation.px;
			InputEnCours.CPY = localisation.py;
		}
		else { 
			var localisation = LocaliseElement ( Obj.id );
			InputEnCours.CPX = ( localisation.px + dimX );
			InputEnCours.CPY = ( localisation.py + dimY );
		}
		InputEnCours.Obj = Obj;
		InputEnCours.id = Obj.id;
	}

	switch ( MWMCP.mode ) {
	case 1:
		MWMCP.MWM_CP_Palette_Rapide.style.visibility	= 'visible';
		MWMCP.MWM_CP_Palette_Rapide.style.left 		= InputEnCours.CPX + 'px';
		MWMCP.MWM_CP_Palette_Rapide.style.top 			= InputEnCours.CPY + 'px';
	break;
	case 2:
		MWMCP.MWM_CP_Palette_complete.style.visibility = 'visible';
		MWMCP.MWM_CP_Palette_complete.style.left 	= InputEnCours.CPX + 'px';
		MWMCP.MWM_CP_Palette_complete.style.top 	= InputEnCours.CPY + 'px';
		MWMCP.MWM_CP_PC_col_12.style.backgroundColor = '#' + InputEnCours.Obj.value;
		var r = String(InputEnCours.Obj.value.substr(0,2));
		var g = String(InputEnCours.Obj.value.substr(2,2));
		var b = String(InputEnCours.Obj.value.substr(4,2));

		MWMCPCouleurSelectionnee ( r , g , b , "h");

		r = h2d ( r );
		g = h2d ( g );
		b = h2d ( b );
		var Curseur = RGBVersHSV ( r , g , b );
		GestionHUECurseur ( 2 , Curseur.Ch , Curseur.Cs , Curseur.Cv );
		if  ( MWMCP.debug == 1 ) {
			DbgRGB.IECstrl = InputEnCours.Obj.value;
			DbgRGB.h = Curseur.Ch;
			DbgRGB.s = Curseur.Cs;
			DbgRGB.v = Curseur.Cv;
		}
	break;
	}
}

function MWMCPEfface ( ) {
	switch ( MWMCP.mode ) {
	case 1: var Obj = MWMCP.MWM_CP_Palette_Rapide;		break;
	case 2: var Obj = MWMCP.MWM_CP_Palette_complete;	break;
	}
	Obj.style.visibility = 'hidden';
}

// --------------------------------------------------------------------------------------------
function MWMCPGestion () {
	if ( MWMCP.MWM_CP_PR_PR.OMOver == 1 && MWMCP.mode == 1 ) { GestionPaletteRapide () }
	if ( MWMCP.MWM_CP_PC_degrade.OMOver == 1 && MWMCP.MWM_CP_PC_degrade.OMClick == 1 && MWMCP.mode == 2 ) { GestionPaletteComplete (); }
	if ( MWMCP.MWM_CP_PC_hue.OMOver == 1 && MWMCP.MWM_CP_PC_hue.OMClick == 1 && MWMCP.mode == 2 ) { GestionHUECurseur ( 1 , 0 , 0 , 0 ); }
}

function GestionPaletteRapide () {
	var MCPX = Souris.PosX - InputEnCours.CPX - 64;
	var MCPY = Souris.PosY - InputEnCours.CPY;
	var i = MCPX + ( MCPY * PalRapide.Largeur );
	var Section = Math.floor ( PalRapide.Largeur / PalRapide.NbrSection );
	var C = i % PalRapide.Largeur;
	var R = Math.floor( i / ( Section * PalRapide.NbrSection ) );
	var c = i % Section; 
	var l = Math.floor ( ( 255 / Section ) * c );
	var h = 255 - l;
	var r = 0, g = 0, b = 0;

	var Colonne = Math.floor( MCPX / Section );
	switch ( Colonne ) {
	case 0 : r = 255;	g = l;		b = 0;		break;
	case 1 : r = h;		g = 255;	b = 0;		break;
	case 2 : r = 0;		g = 255;	b = l;		break;
	case 3 : r = 0;		g = h;		b = 255;	break;
	case 4 : r = l;		g = 0;		b = 255;	break;
	case 5 : r = 255;	g = 0;		b = h;		break;
	}

	var base = 0;
	if( R < ( PalRapide.Hauteur / 2 )) {
		base = 255 - ( 255 * 2 / PalRapide.Hauteur ) * R;
		r = Math.floor ( base + ( r * R * 2 / PalRapide.Hauteur ) );
		g = Math.floor ( base + ( g * R * 2 / PalRapide.Hauteur ) );
		b = Math.floor ( base + ( b * R * 2 / PalRapide.Hauteur ) );
	} 
	else if ( R > ( PalRapide.Hauteur / 2 ) ) {
		base = ( PalRapide.Hauteur - R ) / ( PalRapide.Hauteur / 2 );
		r = Math.floor ( r * base );
		g = Math.floor ( g * base );
		b = Math.floor ( b * base );
	}
	MWMCPCouleurSelectionnee ( r , g , b , "d");

	if  ( MWMCP.debug == 1 ) {
		DbgRGB.r = r;			DbgRGB.g = g;				DbgRGB.b = b;
		DbgRGB.i = i;			DbgRGB.Section = Section;
		DbgRGB.C = C;			DbgRGB.R = R;				DbgRGB.c = c;
		DbgRGB.indivX = MCPX;	DbgRGB.indivY = MCPY;
		DbgRGB.l = l;			DbgRGB.h = h;
	}
}

function GestionPaletteComplete () {
	var Tx = Souris.PosX - InputEnCours.CPX - MWMCP.MWM_CP_PC_degrade.Px - MWMCP.DivBorder;
	var Ty = Souris.PosY - InputEnCours.CPY - MWMCP.MWM_CP_PC_degrade.Py - MWMCP.DivBorder;

	if ( Tx < 0 ) { Tx = 1; } if ( Tx > 256 ) { Tx = 256; }
	if ( Ty < 0 ) { Ty = 1; } if ( Ty > 256 ) { Ty = 256; }

	var r = MWMCP.base_r;
	var g = MWMCP.base_g;
	var b = MWMCP.base_b;
	var l = (MWMCP.largeur-Tx );
	var cx = Tx*(1/MWMCP.largeur);
	var cy = (MWMCP.hauteur-Ty)*(1/MWMCP.hauteur);

	r = Math.floor( ((r*cx)*cy)+(l*cy) );
	g = Math.floor( ((g*cx)*cy)+(l*cy) );
	b = Math.floor( ((b*cx)*cy)+(l*cy) );

	MWMCPCouleurSelectionnee ( r , g , b , "d");
	if  ( MWMCP.debug == 1 ) {
		var str = MWMCP.selection_str;
		DbgRGB.r = r;	DbgRGB.g = g;	DbgRGB.b = b;
		DbgRGB.indivX = Tx;	DbgRGB.indivY = Ty;
		DbgRGB.Form_r = r;			
		DbgRGB.Form_g = g;			
		DbgRGB.Form_b = b;			
	}
}

function GestionHUECurseur ( mode , hue , sat , val ) {
	var h = 252;
	var r = 0, g = 0, b = 0;

	switch ( mode ) {
	case 1 :	var Ty = ( Souris.PosY - InputEnCours.CPY - MWMCP.MWM_CP_PC_hue.Py + MWMCP.DivBorder - 3 );	break;
	case 2 :	var Ty = Math.floor ( ( h / 6 ) * hue );													break;
	}

	if ( Ty < 0 ) { Ty = 0; }
	if ( Ty > ( h - 1 ) ) { Ty = ( h - 1 ) ; }

	var n = Math.floor( h / 6 ); 
	var C = Ty;
	var c = C % n;
	var prc = Math.floor ( ( 256 / n ) * c );
	var Colonne = Math.floor( Ty / n );
	switch ( Colonne ) {
	case 0:	r = 255;		g = prc;		b = 0;			break;
	case 1:	r = 255-prc;	g = 255; 		b = 0;			break;
	case 2:	r = 0;			g = 255;		b = prc;		break;
	case 3:	r = 0;			g = 255-prc;	b = 255;		break;
	case 4:	r = prc;		g = 0; 		b = 255;		break;
	case 5:	r = 255;		g = 0;			b = 255-prc;	break;
	}

	MWMCP.MWM_CP_PC_hue_curseur.style.top = ( Ty + MWMCP.MWM_CP_PC_hue.Py + MWMCP.DivBorder - 3 ) + 'px';
	MWMCP.MWM_CP_PC_degrade.style.backgroundColor = '#' + d2h( r ) + d2h( g ) + d2h( b );
	MWMCP.base_r = r;
	MWMCP.base_g = g;
	MWMCP.base_b = b;

	switch ( mode ) {
	case 1 :  MWMCPCouleurSelectionnee ( r , g , b , "h" );																break;
	case 2 :  var rgb = HSVVersRGB ( hue , sat , val );	MWMCPCouleurSelectionnee ( rgb.Cr , rgb.Cg , rgb.Cb, "h" );		break;
	}

	if  ( MWMCP.debug == 1 ) {	DbgRGB.indivY = Ty;	}
}
// --------------------------------------------------------------------------------------------
// Fast color palette : Col1
function MWMCP_PR_C1_OnMouseDown ()	{	MWMCP.MWM_CP_PR_col_1.OMClick = 1;	return false; }
function MWMCP_PR_C1_OnMouseUp ()	{	MWMCPOnMouseUpReset ();	return false; }
function MWMCP_PR_C1_OnMouseOver ()	{	return false; }
function MWMCP_PR_C1_OnMouseOut ()	{	return false; }

// Fast color palette : gradient
function MWMCP_PR_PR_OnMouseOver ()	{	SourisCurseurCrosshair(); MWMCP.MWM_CP_PR_PR.OMOver = 1; }
function MWMCP_PR_PR_OnMouseOut ()	{	SourisCurseurDefault(); MWMCP.MWM_CP_PR_PR.OMOver = 0; }
function MWMCP_PR_PR_OnMouseDown () {
	MWMCP.MWM_CP_PR_PR.OMClick = 1;
	MWMCP.CPMouseDown = true;
	MWMCP.CPMouseUp = false;
	return false;
}
function MWMCP_PR_PR_OnMouseUp () {
	if ( MWMCP.MWM_CP_PR_PR.OMClick == 1 ) {
		MWMCP.CPMouseUp = true;
		MWMCP.CPMouseDown = false;	
		MWMCPValideLaCouleur();
		MWMCPEfface ();
		InputEnCours.Obj.MWMPCExecution();
	}
	MWMCPOnMouseUpReset ();
}

// Icon "mode" in Fast color palette
function MWMCP_PR_IM_OnMouseOver ()		{	SourisCurseurPointer(); }
function MWMCP_PR_IM_OnMouseOut ()		{	SourisCurseurDefault(); }
function MWMCP_PR_IM_OnMouseDown () 	{	MWMCP.MWM_CP_PR_icone_mode.OMClick = 1;	return false; }
function MWMCP_PR_IM_OnMouseUp ( e ) {	
	if ( MWMCP.MWM_CP_PR_icone_mode.OMClick == 1 ) {
		MWMCP.CPMouseDown = false;
		MWMCP.CPMouseUp = true;
		SourisCurseurDefault ();
		MWMCPEfface ();
		MWMCP.MWM_CP_PR_icone_mode.OMOver = 0;
		MWMCP.mode = 2;
		MWMCPAffiche ( e , 1 );
	}
	MWMCPOnMouseUpReset ();
	return false;
}

// complete gradient palette
function MWMCP_PC_D_OnMouseOver ()	{	SourisCurseurCrosshair();  MWMCP.MWM_CP_PC_degrade.OMOver = 1;	}
function MWMCP_PC_D_OnMouseOut ()	{	SourisCurseurDefault();  MWMCP.MWM_CP_PC_degrade.OMOver = 0;	}
function MWMCP_PC_D_OnMouseDown ()	{	MWMCP.MWM_CP_PC_degrade.OMClick = 1;	GestionPaletteComplete ();	return false;	}
function MWMCP_PC_D_OnMouseUp ()	{	GestionPaletteComplete ();	MWMCPOnMouseUpReset ();	return false;	}

// complete color palette hue
function MWMCP_PC_H_OnMouseOver ()	{	SourisCurseurPointer();  MWMCP.MWM_CP_PC_hue.OMOver = 1;	}
function MWMCP_PC_H_OnMouseOut ()	{	SourisCurseurDefault();  MWMCP.MWM_CP_PC_hue.OMOver = 0;	}
function MWMCP_PC_H_OnMouseDown ()	{	MWMCP.MWM_CP_PC_hue.OMClick = 1;	GestionHUECurseur ( 1 , 0 , 0 , 0 );	return false;	}
function MWMCP_PC_H_OnMouseUp ()	{	GestionHUECurseur ( 1 , 0 , 0 , 0 );	MWMCPOnMouseUpReset ();	return false;	}

// Icon "mode" in Fast color palette
function MWMCP_PC_IM_OnMouseOver ()		{	SourisCurseurPointer(); }
function MWMCP_PC_IM_OnMouseOut ()		{	SourisCurseurDefault(); }
function MWMCP_PC_IM_OnMouseDown () 	{	MWMCP.MWM_CP_PC_icone_mode.OMClick = 1;	return false; }
function MWMCP_PC_IM_OnMouseUp ( e ) {
	if ( MWMCP.MWM_CP_PC_icone_mode.OMClick == 1 ) {
		MWMCP.CPMouseDown = false;
		MWMCP.CPMouseUp = true;
		SourisCurseurDefault();
		MWMCPEfface ();
		MWMCP.MWM_CP_PC_icone_mode.OMOver = 0;
		MWMCP.mode = 1;
		MWMCPAffiche ( e , 1 );
	}
	MWMCPOnMouseUpReset ();
	return false;
}

function MWMCP_PC_BTR_OnMouseUp () {
	InputEnCours.Obj.value = 'transparent';
	MWMCPEfface ();
	InputEnCours.Obj.MWMPCExecution();
}

function MWMCP_PC_BOK_OnMouseUp () {
	MWMCPValideLaCouleur();
	MWMCPEfface ();
	InputEnCours.Obj.MWMPCExecution();
}

function MWMCP_PC_BAN_OnMouseUp () {
	MWMCPEfface ();
}

// --------------------------------------------------------------------------------------------
// Common functions 
function MWMCPOnMouseUpReset () {
	MWMCP.MWM_CP_PR_col_1.OMClick = 0;
	MWMCP.MWM_CP_PR_PR.OMClick = 0;
	MWMCP.MWM_CP_PR_icone_mode.OMClick = 0;
	MWMCP.MWM_CP_PC_degrade.OMClick = 0;
	MWMCP.MWM_CP_PC_hue.OMClick = 0;
}

function MWMCPRien () {	return false;	}

function MWMCPAttacheSurElement ( Obj , Execution ) {
	Obj = Gebi( Obj );
	Obj.onfocus = MWMCPAffiche;
	Obj.onclick = MWMCPAffiche;
	Obj.onblur  = MWMCPEfface;
	Obj.MWMPCExecution = Execution;
}

function MWMCPCouleurSelectionnee ( r , g , b , mode ) {
	switch (mode) {
		case "d":
			var hr = d2h( r );
			var hg = d2h( g );
			var hb = d2h( b );
		break;
		case "h":
			var hr = r;
			var hg = g;
			var hb = b;
		break;
	}

	MWMCP.MWM_CP_PC_col_r_input.value = MWMCP.selection_r = String(hr.toUpperCase());
	MWMCP.MWM_CP_PC_col_g_input.value = MWMCP.selection_g = String(hg.toUpperCase());
	MWMCP.MWM_CP_PC_col_b_input.value = MWMCP.selection_b = String(hb.toUpperCase());
	MWMCP.selection_str = hr + hg + hb;

	if  ( MWMCP.debug == 1 ) {	
		DbgRGB.PCinputR = MWMCP.MWM_CP_PC_col_r_input.value;
		DbgRGB.PCinputG = MWMCP.MWM_CP_PC_col_g_input.value;
		DbgRGB.PCinputB = MWMCP.MWM_CP_PC_col_b_input.value;
	}

	MWMCP.MWM_CP_PC_col_11.style.backgroundColor = '#' + MWMCP.selection_str.toUpperCase();
	MWMCP.MWM_CP_PR_col_1.style.backgroundColor = '#' + MWMCP.selection_str.toUpperCase();
}

function MWMCPValideLaCouleur () {	InputEnCours.Obj.value = MWMCP.selection_str.toUpperCase();	}

function RGBVersHSV ( r , g , b ) {
	var n = Math.min( Math.min( r , g ) , b );
	var v = Math.max( Math.max( r , g ) , b );
	var m = v - n;
	if ( m === 0 ) { return { Ch : null, Cs : 0, Cv : v }; }
	var h = r===n ? 3 + ( b - g ) / m : ( g===n ? 5 + ( r - b ) / m : 1 + ( g - r ) / m );
	return { Ch : h===6 ? 0 : h , Cs : m / v , Cv : v };
}

function HSVVersRGB ( h , s , v ) {
	var Da = 0 , Db = 0 , Dc = 0;
	if ( h === null ) { return { Cr : v , Cv : v , Cb : v }; }
	var i = Math.floor( h );
	var f = i % 2 ? h - i : 1 - ( h - i );
	var m = v * ( 1 - s );
	var n = v * ( 1 - s * f );
	switch ( i ) {
	case 6:
	case 0: Da = v;	Db = n;	Dc = m;	break;
	case 1: Da = n;	Db = v;	Dc = m;	break;
	case 2: Da = m;	Db = v;	Dc = n;	break;
	case 3: Da = m;	Db = n;	Dc = v;	break;
	case 4: Da = n;	Db = m;	Dc = v;	break;
	case 5: Da = v;	Db = m;	Dc = n;	break;
	}
	return { Cr : Da , Cg : Db , Cb : Dc };
}


// --------------------------------------------------------------------------------------------

var PalRapide = { 'NbrSection':6,	'Largeur':(50*6),	'Hauteur':64};
var InputEnCours = { 'id':'',	'Obj':0,	'CPX':0,	'CPY':0,	'str':''	};

var MWMCP_elements = [
'MWM_CP_Palette_Rapide', 
'MWM_CP_PR_col_1', 
'MWM_CP_PR_PR', 
'MWM_CP_PR_icone_mode', 
'MWM_CP_Palette_complete', 
'MWM_CP_PC_degrade', 
'MWM_CP_PC_hue_curseur', 
'MWM_CP_PC_hue', 
'MWM_CP_PC_col_10', 
'MWM_CP_PC_col_11', 
'MWM_CP_PC_col_12', 
'MWM_CP_PC_col_r', 
'MWM_CP_PC_col_r_input', 
'MWM_CP_PC_col_g', 
'MWM_CP_PC_col_g_input', 
'MWM_CP_PC_col_b', 
'MWM_CP_PC_col_b_input', 
'MWM_CP_PC_btr', 
'MWM_CP_PC_bok', 
'MWM_CP_PC_ban',
'MWM_CP_PC_icone_mode'
];

var PxPy = 0;
var MWMCP = {};
for (var ptr in MWMCP_elements ) {
	MWMCP[MWMCP_elements[ptr]] = Gebi ( MWMCP_elements[ptr] );
	PxPy = LocaliseElement ( MWMCP_elements[ptr] );
	MWMCP[MWMCP_elements[ptr]].Px = PxPy.px;
	MWMCP[MWMCP_elements[ptr]].Py = PxPy.py; 
	MWMCP[MWMCP_elements[ptr]].OMOver = 0; 
	MWMCP[MWMCP_elements[ptr]].OMClick = 0; 
}

MWMCP.MWM_CP_PR_col_1.onmousedown 	= MWMCP_PR_C1_OnMouseDown;
MWMCP.MWM_CP_PR_col_1.onmouseup 	= MWMCP_PR_C1_OnMouseUp;
MWMCP.MWM_CP_PR_col_1.onmouseover 	= MWMCP_PR_C1_OnMouseOver;
MWMCP.MWM_CP_PR_col_1.onmouseout 	= MWMCP_PR_C1_OnMouseOut;

MWMCP.MWM_CP_PR_PR.onmousedown 	= MWMCP_PR_PR_OnMouseDown;
MWMCP.MWM_CP_PR_PR.onmouseup 	= MWMCP_PR_PR_OnMouseUp;
MWMCP.MWM_CP_PR_PR.onmouseover 	= MWMCP_PR_PR_OnMouseOver;
MWMCP.MWM_CP_PR_PR.onmouseout 	= MWMCP_PR_PR_OnMouseOut;

MWMCP.MWM_CP_PR_icone_mode.onmousedown 	= MWMCP_PR_IM_OnMouseDown;
MWMCP.MWM_CP_PR_icone_mode.onmouseup 	= MWMCP_PR_IM_OnMouseUp;
MWMCP.MWM_CP_PR_icone_mode.onmouseover 	= MWMCP_PR_IM_OnMouseOver;
MWMCP.MWM_CP_PR_icone_mode.onmouseout 	= MWMCP_PR_IM_OnMouseOut;


MWMCP.MWM_CP_Palette_complete.onmousedown 	= MWMCPRien;
MWMCP.MWM_CP_Palette_complete.onmouseup 	= MWMCPOnMouseUpReset;
MWMCP.MWM_CP_Palette_complete.onmouseover 	= MWMCPRien;
MWMCP.MWM_CP_Palette_complete.onmouseout 	= MWMCPRien;

MWMCP.MWM_CP_PC_degrade.onmousedown = MWMCP_PC_D_OnMouseDown;
MWMCP.MWM_CP_PC_degrade.onmouseup 	= MWMCP_PC_D_OnMouseUp;
MWMCP.MWM_CP_PC_degrade.onmouseover = MWMCP_PC_D_OnMouseOver;
MWMCP.MWM_CP_PC_degrade.onmouseout 	= MWMCP_PC_D_OnMouseOut;

MWMCP.MWM_CP_PC_hue.onmousedown = MWMCP_PC_H_OnMouseDown;
MWMCP.MWM_CP_PC_hue.onmouseup 	= MWMCP_PC_H_OnMouseUp;
MWMCP.MWM_CP_PC_hue.onmouseover = MWMCP_PC_H_OnMouseOver;
MWMCP.MWM_CP_PC_hue.onmouseout 	= MWMCP_PC_H_OnMouseOut;

MWMCP.MWM_CP_PC_icone_mode.onmousedown	= MWMCP_PC_IM_OnMouseDown;
MWMCP.MWM_CP_PC_icone_mode.onmouseup	= MWMCP_PC_IM_OnMouseUp;
MWMCP.MWM_CP_PC_icone_mode.onmouseover	= MWMCP_PC_IM_OnMouseOver;
MWMCP.MWM_CP_PC_icone_mode.onmouseout	= MWMCP_PC_IM_OnMouseOut;

MWMCP.MWM_CP_PC_btr.onmousedown	= MWMCPRien;
MWMCP.MWM_CP_PC_btr.onmouseup	= MWMCP_PC_BTR_OnMouseUp;
MWMCP.MWM_CP_PC_btr.onmouseover	= MWMCPRien;
MWMCP.MWM_CP_PC_btr.onmouseout	= MWMCPRien;

MWMCP.MWM_CP_PC_bok.onmousedown	= MWMCPRien;
MWMCP.MWM_CP_PC_bok.onmouseup	= MWMCP_PC_BOK_OnMouseUp;
MWMCP.MWM_CP_PC_bok.onmouseover	= MWMCPRien;
MWMCP.MWM_CP_PC_bok.onmouseout	= MWMCPRien;

MWMCP.MWM_CP_PC_ban.onmousedown	= MWMCPRien;
MWMCP.MWM_CP_PC_ban.onmouseup	= MWMCP_PC_BAN_OnMouseUp;
MWMCP.MWM_CP_PC_ban.onmouseover	= MWMCPRien;
MWMCP.MWM_CP_PC_ban.onmouseout	= MWMCPRien;


MWMCP.largeur = 256;
MWMCP.hauteur = 256;
MWMCP.base_r = 255;
MWMCP.base_g = 0;
MWMCP.base_b = 0;
MWMCP.selection_r = 0;
MWMCP.selection_g = 0;
MWMCP.selection_b = 0;
MWMCP.selection_str = '';

MWMCP.DivBorder = 1;
MWMCP.TypePositionnement = 1; // 1 Element , 2 centered

MWMCP.mode = 1;
MWMCP.debug = 1;

if  ( MWMCP.debug == 1 ) {
	var DbgRGB = {	'r':0,	'g':0,	'b':0,	'h':0,	's':0,	'v':0,	'str': 'a', 'IECstrl': 'rien',	
	'i':'0',	'Section':0,	'C':0,	'R':0,	'c':0,	'l':0,	
	'indivX':0,	'indivY':0,	
	'localisation':0
	}
	function MWMCPMousePosition ( ) {
		var MCPX = Souris.PosX - InputEnCours.CPX - 64;
		var MCPY = Souris.PosY - InputEnCours.CPY;

		var chaine1 = 'Mouse X=' + Souris.PosX + ', Mouse Y=' + Souris.PosY + ', ';
		var chaine10 = 'X dans div=' + DbgRGB.indivX + ', Y dans div=' + DbgRGB.indivY + ', ';
		var chaine2 = 'r=' + DbgRGB.r + ', g=' + DbgRGB.g + ', b=' + DbgRGB.b + ', h=' + DbgRGB.h + ', s=' + DbgRGB.s + ', v=' + DbgRGB.v + ', ';
		var chaine3 = 'i=' + DbgRGB.i + ', Section=' + DbgRGB.Section  + ', C=' + DbgRGB.C + ', R=' + DbgRGB.R + ', c=' + DbgRGB.c + ', l=' + DbgRGB.l + ', h=' + DbgRGB.h + ', ';
		var chaine4 = 'Id=' + InputEnCours.id + ', Obj=' + InputEnCours.Obj + ', CPX=' + InputEnCours.CPX + ', CPY=' + InputEnCours.CPY + ', Taille str=' + DbgRGB.IECstrl + ', ';
		var chaine5 = 'InputR=' + DbgRGB.PCinputR + ', InputG=' + DbgRGB.PCinputG + ', InputB=' + DbgRGB.PCinputB + ', ';
		var chaine6 = 'DbgRGB.Form_r=' + DbgRGB.Form_r + ', DbgRGB.Form_g=' + DbgRGB.Form_g + ', DbgRGB.Form_b=' + DbgRGB.Form_b + ', ';

		var chaine = chaine1 + chaine10 + chaine2 + chaine3 + chaine4 + chaine5 + chaine6;
		JSJournal[dbgColorPicker](chaine);
	}
	SourisListe.ColorPickerDbg = 'MWMCPMousePosition';
}

SourisListe.ColorPicker = 'MWMCPGestion';
