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

var dbgAideDyn = 0;

var AiDyn = {
'EcartX' : 16, 'EcartY' : 4,
'CalqueEncadrement' : '', 
'CalqueContenu' : '',
'CalqueTailleX' : 0, 'CalqueTailleY' : 0,
'PremiereFois' : 1, 'AdynCalqueEtat' : 0,
'PositionX' : 0, 'PositionY' : 0,
'Debug' : 0
};

var ACE = 0;

function initAdyn( CalqueExt , CalqueCont , cdX , cdY ) {
	AiDyn.CalqueContenu = CalqueCont;
	AiDyn.CalqueEncadrement = Gebi( CalqueExt );
	AiDyn.CalqueTailleX = cdX;
	AiDyn.CalqueTailleY = cdY;
	ACE = Gebi( CalqueExt );
	ACE.MWM_Progression = 0;
	ACE.MWM_AnimEnCours = 0;
	ACE.MWM_AnimationEnCoursOUT = 0;
	ACE.MWM_AnimationEnCoursIN =0;
	ACE.style.visibility = 'visible';
	ACE.style.display = 'none';
	ACE.style.zIndex = 99;

	if ( typeof AideDynamiqueDerogation != 'undefined' ) {
		TabInfoModule.AideDynamique.DimConteneurX = AideDynamiqueDerogation.X;
		TabInfoModule.AideDynamique.DimConteneurY = AideDynamiqueDerogation.Y;
		AiDyn.CalqueTailleX = AideDynamiqueDerogation.X
		AiDyn.CalqueTailleY = AideDynamiqueDerogation.Y;
		CalculeDecoModule ( TabInfoModule , 'AideDynamique' );
	}
}

// --------------------------------------------------------------------------------------------
//
//	Gestion de l'aide dynamique
//
// --------------------------------------------------------------------------------------------
function Bulle( msg ) {
	var Obj = Gebi( AiDyn.CalqueContenu );
	if ( AiDyn.PremiereFois == 1 ) {
		switch ( cliEnv.browser.agent ) {
			case 'Firefox':			while ( Obj.childNodes.length >= 1 ){ Obj.removeChild(Obj.firstChild ); }		break;
		}
		AiDyn.PremiereFois = 0;
	}

	if ( arguments.length < 1 ) {
		AiDyn.AdynCalqueEtat = 0;
		ACE.MWM_Sens = 0;
		if ( ACE.MWM_AnimEnCours == 0 ) {
			ACE.MWM_AnimEnCours	= 1;
			ADGestionAnimation ( ACE.id );
		}
	}
	else {
		if ( AiDyn.AdynCalqueEtat == 0 ) { 
			AiDyn.AdynCalqueEtat = 1;
			switch ( cliEnv.browser.support ) {
			case 'MSIE7': if (!e) { var e = window.event; }		Obj.innerHTML = msg;	break;
			case 'DOM': Obj.innerHTML = msg; 											break;
			}

			ACE.MWM_Sens = 1;
			if ( ACE.MWM_AnimEnCours == 0 ) {
				ACE.MWM_AnimEnCours	= 1;
				ADGestionAnimation ( ACE.id );
			}
		}
	}
}

function PositioneCalque(e) {
	if ( AiDyn.AdynCalqueEtat == 1 ) { 
		AiDyn.PositionX = Souris.PosX;
		AiDyn.PositionY = Souris.PosY;

		var FenetreX = cliEnv.document.width;
		var FenetreY = cliEnv.document.height;

		if ( ( AiDyn.PositionX + AiDyn.EcartX ) > ( FenetreX - AiDyn.CalqueTailleX ) ) { AiDyn.PositionX = AiDyn.PositionX - AiDyn.CalqueTailleX - AiDyn.EcartX - DivInitial.px; }
		else { AiDyn.PositionX = AiDyn.PositionX + AiDyn.EcartX - DivInitial.px; }
		if ( ( AiDyn.PositionY + AiDyn.EcartY ) > ( FenetreY - AiDyn.CalqueTailleY ) ) { AiDyn.PositionY = AiDyn.PositionY - AiDyn.CalqueTailleY - AiDyn.EcartY; }
		else { AiDyn.PositionY = AiDyn.PositionY + AiDyn.EcartY }

		AiDyn.CalqueEncadrement.style.left = AiDyn.PositionX + 'px';
		AiDyn.CalqueEncadrement.style.top  = AiDyn.PositionY + 'px';
	}
}

function ADGestionAnimation ( Obj ) {
	Obj = Gebi( Obj );
	switch ( Obj.MWM_Sens ) {
	case 0 :
		clearTimeout( Obj.MWM_AnimationEnCoursIN );
		if ( Obj.MWM_Progression > 0 ) {
			Obj.MWM_Progression	= Obj.MWM_Progression - ( 1 / 30 ); 
			Obj.MWM_AnimationEnCoursOUT = setTimeout( 'ADGestionAnimation ( \'' + Obj.id + '\' );', ( 15 ) );
			AiDyn.AdynCalqueEtat = 1;
		}
		else {
			clearTimeout( Obj.MWM_AnimationEnCoursOUT );	
			Obj.style.visibility	= 'hidden';
			Obj.style.display		= 'none';
			Obj.MWM_Progression 	= 0;
			Obj.MWM_AnimEnCours 	= 0;
			AiDyn.AdynCalqueEtat 	= 0;
			Obj.style.zIndex		= 0;

		}
	break;
	case 1 :
		clearTimeout( Obj.MWM_AnimationEnCoursOUT );	
		if ( Obj.MWM_Progression < 1 ) { 
			Obj.MWM_Progression	= Obj.MWM_Progression + ( 1 / 30 ); 
			Obj.MWM_AnimationEnCoursIN = setTimeout( 'ADGestionAnimation ( \'' + Obj.id + '\' );', ( 15 ) ); 
			AiDyn.AdynCalqueEtat 	= 1;
			Obj.style.zIndex		= 99;
		}		
		else {
			clearTimeout( Obj.MWM_AnimationEnCoursIN );
			Obj.style.visibility	= 'visible';
			Obj.style.display		= 'block';
			Obj.MWM_Progression 	= 1;
			Obj.MWM_AnimEnCours 	= 0;
			AiDyn.AdynCalqueEtat 	= 1;
		}
	break;
	}
	if ( Obj.MWM_Sens != 0 || Obj.MWM_Sens != 1 )  {
		ADFonduTransparent ( Obj.id );
		PositioneCalque();

		var chaine = 'AiDyn :\nEcartX=' + AiDyn.EcartX + ', EcartY=' + AiDyn.EcartY +
		'\n CalqueTailleX=' + AiDyn.CalqueTailleX + ', CalqueTailleY=' + AiDyn.CalqueTailleY +
		'\n PremiereFois=' + AiDyn.PremiereFois + ', AdynCalqueEtat=' + AiDyn.AdynCalqueEtat +
		'\n Souris : Mouse X=' + Souris.PosX + ', Mouse Y=' + Souris.PosY +
		'\n PositionX=' + AiDyn.PositionX + ', PositionY=' + AiDyn.PositionY +
		'\n cliEnv.document.width=' + cliEnv.document.width + ', cliEnv.document.height=' + cliEnv.document.height +
		'\n initial_div px=' + DivInitial.px + ' py=' + DivInitial.py + ' dx=' + DivInitial.dx + ' dy=' + DivInitial.dy + ' cx=' + DivInitial.cx + ' cy=' + DivInitial.cy + 
		'\n Sens=' + ACE.MWM_Sens + ', Progression=' +  ACE.MWM_Progression + 
		'\n fin';
		JSJournal[dbgAideDyn](chaine);
	}
}

function ADFonduTransparent ( Obj ) {
	Obj = Gebi( Obj );
	var ProgressionSin = Math.sin(Math.PI * Obj.MWM_Progression / 2 );
	var a = ( Obj.MWM_Sens * 2 );
	if ( cliEnv.browser.support == 'MSIE7' ) { a = a + 1 }
	switch ( a ) {
	case 0 :	Obj.style.opacity =  Obj.style.MozOpacity = ProgressionSin;					break;
	case 1 :	Obj.style.filter = 'alpha(opacity=' + (ProgressionSin * 100) + ')';			break;
	case 2 :	Obj.style.opacity =  Obj.style.MozOpacity = ProgressionSin;					break;
	case 3 :	Obj.style.filter = 'alpha(opacity=' + ( ProgressionSin * 100 ) + ')';		break;
	}
	Obj.style.visibility 	= 'visible';		
	Obj.style.display 		= 'block';
}

// --------------------------------------------------------------------------------------------
//
//	Mise en file de l'objet dans la gestion des évennements souris
//
// --------------------------------------------------------------------------------------------
SourisListe.Adyn = 'PositioneCalque';





