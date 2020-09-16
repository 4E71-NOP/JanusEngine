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
	var MsObj = Gebi( MenuSelect );
	if ( MsObj.options[MsObj.selectedIndex].value == 'STATIC' ) {
		Gebi( 'TabCalStatic_' + Ligne ).style.visibility = 'visible';
		Gebi( 'TabCalStatic_' + Ligne ).style.display = 'block';
		Gebi( 'TabCalDynamic_' + Ligne ).style.visibility = 'hidden';
		Gebi( 'TabCalDynamic_' + Ligne ).style.display = 'none';
	}
	else {
		Gebi( 'TabCalStatic_' + Ligne ).style.visibility = 'hidden';
		Gebi( 'TabCalStatic_' + Ligne ).style.display = 'none';
		Gebi( 'TabCalDynamic_' + Ligne ).style.visibility = 'visible';
		Gebi( 'TabCalDynamic_' + Ligne ).style.display = 'block';
	}
}

