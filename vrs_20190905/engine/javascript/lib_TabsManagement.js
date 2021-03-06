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

// --------------------------------------------------------------------------------------------
//	Tabs management
//
// Mode selection 1 hover 0

var dbgOnglet = 0;

function InitOnglets ( Table ) {
	for ( var Tab in Table ) {
//		elm.Gebi(Table[Tab].cibleDoc).style.position = 'relative';
//		elm.Gebi(Table[Tab].cibleDoc).style.display = 'none';

		Table[Tab].down.ida = elm.Gebi( Table[Tab].down.ida )
		Table[Tab].down.idb = elm.Gebi( Table[Tab].down.idb )
		Table[Tab].down.idc = elm.Gebi( Table[Tab].down.idc )

		Table[Tab].up.ida = elm.Gebi( Table[Tab].up.ida )
		Table[Tab].up.idb = elm.Gebi( Table[Tab].up.idb )
		Table[Tab].up.idc = elm.Gebi( Table[Tab].up.idc )

		Table[Tab].hover.ida = elm.Gebi( Table[Tab].hover.ida )
		Table[Tab].hover.idb = elm.Gebi( Table[Tab].hover.idb )
		Table[Tab].hover.idc = elm.Gebi( Table[Tab].hover.idc )

	}
//	elm.Gebi(Table[0].cibleDoc).style.visibility = 'visible';
//	elm.Gebi(Table[0].cibleDoc).style.display = 'block';
}

function GestionOnglets ( Mode , EvType , Table , Groupe , FeuiletNom , OngletChoisi ) {
	l.Log[dbgOnglet](
	'Mode:' + Mode+
	'; EvType:' + EvType+
	'; Groupe:' + Groupe+
	'; FeuiletNom:' + FeuiletNom+
	'; OngletChoisi:' + OngletChoisi +
	'.'
	);
	var cpt = 1;
	for ( var Tab in Table ) {
		var Score = ( Number( Mode ) + ( Number(Table[Tab].EtatHover ) * 2 ) + ( Number(Table[Tab].EtatSelection ) * 4 ) + ( Number(EvType) * 16 ) );
		if ( cpt == OngletChoisi ) { Score = Score + 8;  }
		switch ( Score ) {
		case 2 :
		case 3 :
		case 26 :
			Table[Tab].down.ida.className = Table[Tab].down.Styla ;
			Table[Tab].down.idb.className = Table[Tab].down.Stylb ;
			Table[Tab].down.idc.className = Table[Tab].down.Stylc ;
			Table[Tab].EtatHover = 0;
		break;
		case 5 :
			Table[Tab].down.ida.className = Table[Tab].down.Styla ;
			Table[Tab].down.idb.className = Table[Tab].down.Stylb ;
			Table[Tab].down.idc.className = Table[Tab].down.Stylc ;
			elm.Gebi( Groupe + '_' + FeuiletNom + cpt ).style.visibility = 'hidden';
			elm.Gebi( Groupe + '_' + FeuiletNom + cpt ).style.display = 'none';
			Table[Tab].EtatSelection = 0;
		break;
		case 6 :
		case 7 :
		case 22 :
		case 30 :
			Table[Tab].EtatHover = 0;
		break;
		case 8 :
			Table[Tab].up.ida.className = Table[Tab].hover.Styla ;
			Table[Tab].up.idb.className = Table[Tab].hover.Stylb ;
			Table[Tab].up.idc.className = Table[Tab].hover.Stylc ;
			Table[Tab].EtatHover = 1;
		break;
		case 9 :
		case 11 :
			Table[Tab].up.ida.className = Table[Tab].up.Styla ;
			Table[Tab].up.idb.className = Table[Tab].up.Stylb ;
			Table[Tab].up.idc.className = Table[Tab].up.Stylc ;
			elm.Gebi( Groupe + '_' + FeuiletNom + cpt ).style.visibility = 'visible';
			elm.Gebi( Groupe + '_' + FeuiletNom + cpt ).style.display = 'block';
			Table[Tab].EtatSelection = 1;
		break;
		case 12 :
			Table[Tab].EtatHover = 1;
		break;
		default :
		break;
		}
		cpt++; 
	}
}


