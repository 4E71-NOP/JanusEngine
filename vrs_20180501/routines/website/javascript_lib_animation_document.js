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

var dbgAnimDoc = 1;

function ADDA_div_init ( Objnom , Bouton , iconep0 , iconep1 , position, frequence , duree , hauteurdiv ) {
	var Obj = Gebi( Objnom );
	var Btn = Gebi( Bouton );
	Obj.MWM_Sens = position;
	Obj.MWM_AnimationEnCoursExpansion = 0;
	Obj.MWM_AnimationEnCoursRetractation = 0;
	Obj.MWM_Progression = position;
	Obj.MWM_AnimEnCours = 0;
	Obj.MWM_frequence = frequence;
	Obj.MWM_duree = duree;
	Obj.MWM_hauteur = hauteurdiv;
	Obj.MWM_BoutonId = Bouton;
	Btn.MWM_p0 = iconep0;
	Btn.MWM_p1 = iconep1;
}

function animation_document_div_accordeon ( Div ) {
	var Obj = Gebi( Div );
	var Btn = Gebi ( Obj.MWM_BoutonId );
	switch ( Obj.MWM_Sens ) {
		case 0 :
			Btn.src = Btn.MWM_p1;
			Obj.MWM_Sens = 1;
			ADDA_animation ( Obj.id );
		break;
		case 1 :
			Btn.src = Btn.MWM_p0;
			Obj.MWM_Sens = 0;
			ADDA_animation ( Obj.id );
		break;
	}
}

function ADDA_animation ( Obj ) {
	Obj = Gebi( Obj );
	var Interval = Math.floor((Obj.MWM_duree*1000)/Obj.MWM_frequence );
	var FacteurProgression = 1/Obj.MWM_frequence;
	switch ( Obj.MWM_Sens ) {
	case 0:
		clearTimeout( Obj.MWM_AnimationEnCoursExpansion );
		if ( Obj.MWM_Progression > 0 ) {
			Obj.MWM_Progression	= Obj.MWM_Progression - FacteurProgression;
			Obj.MWM_AnimationEnCoursRetractation = setTimeout( 'ADDA_animation ( \'' + Obj.id + '\' );',  Interval );
		}
		else {
			clearTimeout( Obj.MWM_AnimationEnCoursRetractation );	
			Obj.MWM_Progression 	= 0;
			Obj.MWM_AnimEnCours 	= 0;
		}
	break;
	case 1:
		clearTimeout( Obj.MWM_AnimationEnCoursRetractation );
		if ( Obj.MWM_Progression < 1 ) {
			Obj.MWM_Progression	= Obj.MWM_Progression + FacteurProgression;
			Obj.MWM_AnimationEnCoursExpansion = setTimeout( 'ADDA_animation ( \'' + Obj.id + '\' );', Interval );
		}
		else {
			clearTimeout( Obj.MWM_AnimationEnCoursExpansion );	
			Obj.MWM_Progression 	= 1;
			Obj.MWM_AnimEnCours 	= 0;
		}
	break;
	}
	if ( Obj.MWM_Sens != 0 || Obj.MWM_Sens != 1 )  {
		var hauteur = Math.floor ( Math.sin ( ( Math.PI / 180 ) * ( 90 * Obj.MWM_Progression ) ) * Obj.MWM_hauteur ) ;
		Obj.style.height = hauteur + 'px';
	}

	var chaine = 'Obj.MWM_Sens = ' + Obj.MWM_Sens + '|' + 
	'Obj.MWM_AnimationEnCoursExpansion = ' + Obj.MWM_AnimationEnCoursExpansion + '|' + 
	'Obj.MWM_AnimationEnCoursRetractation = ' + Obj.MWM_AnimationEnCoursRetractation  + '|' + 
	'Obj.MWM_Progression = ' + Obj.MWM_Progression + '|' + 
	'Obj.MWM_AnimEnCours = ' + Obj.MWM_AnimEnCours + '|' + 
	'hauteur = ' + hauteur + '|' +
	'frequence  = ' + Obj.MWM_frequence +  '|' +
	'duree = ' + Obj.MWM_duree +  '|' +
	'd*1000/f  = ' + Interval +  '|'
	;
	JSJournal[dbgAnimDoc](chaine);
}

