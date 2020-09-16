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

//Fonctions dédiées a la gestion des décorations.

function ManiPresTypCal ( MenuSelect , Ligne ) {
	var MsObj = elm.Gebi( MenuSelect );
	if ( MsObj.options[MsObj.selectedIndex].value == 'STATIC' ) {
		elm.Gebi( 'TabCalStatic_' + Ligne ).style.visibility = 'visible';
		elm.Gebi( 'TabCalStatic_' + Ligne ).style.display = 'block';
		elm.Gebi( 'TabCalDynamic_' + Ligne ).style.visibility = 'hidden';
		elm.Gebi( 'TabCalDynamic_' + Ligne ).style.display = 'none';
	}
	else {
		elm.Gebi( 'TabCalStatic_' + Ligne ).style.visibility = 'hidden';
		elm.Gebi( 'TabCalStatic_' + Ligne ).style.display = 'none';
		elm.Gebi( 'TabCalDynamic_' + Ligne ).style.visibility = 'visible';
		elm.Gebi( 'TabCalDynamic_' + Ligne ).style.display = 'block';
	}
}

