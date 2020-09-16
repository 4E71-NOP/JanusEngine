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

var dbgGestDeco = 1;

var FSJSDernierRep = "";
function RenderFSJS ( formulaire , champs , ChdimX , ChdimY , repertoire , divFS , CellName , ExecFunc ) {
	if ( repertoire.length > 0 ) {
		var Obj = Gebi( divFS );
		var ExecFuncExpr = "";
		if ( ExecFunc ) { ExecFuncExpr = ExecFunc + '();'; }
		
		if (  FSJSDernierRep != repertoire ) {
			var Cellcount = 1;
			if ( FSJSDernierRep.length > 0 ) {
				for ( var Index in TabFSJS[FSJSDernierRep] ) {
					var CellG = Gebi( CellName + 'G' + Cellcount );
					while ( CellG.childNodes.length >= 1 ){ CellG.removeChild(CellG.firstChild ); }
					var CellT = Gebi( CellName + 'T' + Cellcount );
					while ( CellT.childNodes.length >= 1 ){ CellT.removeChild(CellT.firstChild ); }
					Cellcount++;
				}
			}
			var Cellcount = 1;
			for ( var Index in TabFSJS[repertoire] ) {
				var FileName = TabFSJS[repertoire][Index].nomfichier;
				
				var ScriptLocal = "javascript:document.forms['" + formulaire + "'].elements['" + champs + "'].value = '" + FileName + "'"; 
				if ( ChdimX.length > 0 ) { ScriptLocal += "; document.forms['" + formulaire + "'].elements['" + ChdimX + "'].value = '" + TabFSJS[repertoire][Index].OdimX + "'"; } 
				if ( ChdimY.length > 0 ) { ScriptLocal += "; document.forms['" + formulaire + "'].elements['" + ChdimY + "'].value = '" + TabFSJS[repertoire][Index].OdimY + "'"; }
				ScriptLocal += "; Gebi('" + divFS + "').style.visibility = 'hidden'; " + ExecFuncExpr; 

				var img = new Image();
				img.src = "../graph/"+ repertoire + '/' + FileName;
				img.setAttribute('id', 'img_'+ repertoire + '_' + FileName );
				img.setAttribute('alt', FileName );
				img.setAttribute('height', TabFSJS[repertoire][Index].dimY + 'px');
				img.setAttribute('width', TabFSJS[repertoire][Index].dimX + 'px');
				img.setAttribute('style', 'border-width: 3px; border-color: #123456;');
				img.setAttribute('onclick', ScriptLocal );
				img.setAttribute('z-index', 'inherit');
				var CellG = Gebi( CellName + 'G' + Cellcount );
				while ( CellG.childNodes.length >= 1 ){ CellG.removeChild(CellG.firstChild ); }
				CellG.setAttribute('onclick', ScriptLocal );
				CellG.appendChild(img);

				var CellT = Gebi( CellName + 'T' + Cellcount );
				while ( CellT.childNodes.length >= 1 ){ CellT.removeChild(CellT.firstChild ); }
				var imgNom = document.createElement("text");
				var imgNomT = document.createTextNode( Cellcount + ': ' + FileName );
				imgNom.appendChild( imgNomT );
				CellT.appendChild( imgNomT );
				Cellcount++;
			}
			FSJSDernierRep = repertoire;
		}
		else {
			for ( var Index in TabFSJS[repertoire] ) {
				var FileName = TabFSJS[repertoire][Index].nomfichier;

				var ScriptLocal = "javascript:document.forms['" + formulaire + "'].elements['" + champs + "'].value = '" + FileName + "'"; 
				if ( ChdimX.length > 0 ) { ScriptLocal += "; document.forms['" + formulaire + "'].elements['" + ChdimX + "'].value = '" + TabFSJS[repertoire][Index].OdimX + "'"; } 
				if ( ChdimY.length > 0 ) { ScriptLocal += "; document.forms['" + formulaire + "'].elements['" + ChdimY + "'].value = '" + TabFSJS[repertoire][Index].OdimY + "'"; }
				ScriptLocal += "; Gebi('" + divFS + "').style.visibility = 'hidden'; " + ExecFuncExpr; 

				var imgCellG = Gebi( 'img_'+ repertoire + '_' + FileName );
				imgCellG.setAttribute('onclick', ScriptLocal );
				imgCellG.parentNode.setAttribute('onclick', ScriptLocal );
				Cellcount++;
			}
		}
		Obj.style.zIndex = '99';
		Obj.style.visibility = 'visible';
		Obj.style.display = '';
		Obj.style.left = Math.floor(( cliEnv.document.width - Obj.offsetWidth ) / 2 ) + "px";
		Obj.style.top = Math.floor(( cliEnv.document.height - Obj.offsetHeight ) / 2 ) + "px";
	}
	else {
		alert("Pas de répertoire ??? / No directory ???"); 
	}
}

function SelectOngletDeco ( TForm , TElm , Groupe , FeuiletNom ) {
	var SelectValue = document.forms[TForm].elements[TElm].value;
	var TabNom = new Array( 0, 'menu','caligraphe','1_div','elegance','exquise','elysion');
	for ( var DivN = 1; DivN <= 6; DivN++ ) {
		if ( SelectValue == TabNom[DivN] ) {
			Gebi( Groupe + '_' + FeuiletNom + '_' + TabNom[DivN] ).style.display = '';
			Gebi( Groupe + '_' + FeuiletNom + '_' + TabNom[DivN] ).style.visibility = 'visible';
		}
		else {
			Gebi( Groupe + '_' + FeuiletNom + '_' + TabNom[DivN] ).style.display = 'none';
			Gebi( Groupe + '_' + FeuiletNom + '_' + TabNom[DivN] ).style.visibility = 'hidden';
		}
	}
}

function InitialisationTJED ( Obj ) {
	for ( var PtrPF in Obj ) {
		Obj[PtrPF].ObjCible = Gebi ( Obj[PtrPF].Cible );
		Obj[PtrPF].ObjSource = Gebi ( Obj[PtrPF].Form );
	}
}


var CDMExec = {
	"ModType":"0",
	"NomModule":"0",
	"FormCible":"0"
};
function CalculeDecoModule ( ModType , NomModule , FormCible ) {
	if ( CDMExec.ModType != 0 ) {
		ModType = CDMExec.ModType;
		NomModule = CDMExec.NomModule;
		FormCible = CDMExec.FormCible;
	}

	switch ( ModType ) {
	case 'elegance':
		var ListeDivsGebi = ['ex11', 'ex12','ex13','ex21', 'ex22','ex23','ex31', 'ex32','ex33'];
		var ListeForms = [
		'ex11_dimx', 'ex11_dimy', 'ex11_bg', 'ex12_dimy', 'ex12_bg', 'ex13_dimx', 'ex13_dimy', 'ex13_bg', 
		'ex21_dimx', 'ex21_bg', 'ex22_bg', 'ex23_dimx', 'ex23_bg', 
		'ex31_dimx', 'ex31_dimy', 'ex31_bg', 'ex32_dimy', 'ex32_bg', 'ex33_dimx', 'ex33_dimy', 'ex33_bg'
		];
		var ListeDivsSetX = ['ex11', 'ex13', 'ex21', 'ex23', 'ex31', 'ex33'];
		var ListeDivsSetY = ['ex11', 'ex12', 'ex13', 'ex31', 'ex32', 'ex33'];
		var ListeDivsSetBG = ['ex11', 'ex12','ex13','ex21', 'ex22','ex23','ex31', 'ex32','ex33'];
	break;

	case 'exquise':
		var ListeDivsGebi = ['ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex22', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55'];
		var ListeForms = [
		'ex11_dimx', 'ex11_dimy', 'ex11_bg', 'ex12_dimx', 'ex12_dimy', 'ex12_bg', 'ex13_dimy', 'ex13_bg', 'ex14_dimx', 'ex14_dimy', 'ex14_bg', 'ex15_dimx', 'ex15_dimy', 'ex15_bg', 
		'ex21_dimx', 'ex21_dimy', 'ex21_bg', 'ex22_bg', 'ex25_dimx', 'ex25_dimy', 'ex25_bg', 
		'ex31_dimx', 'ex31_bg', 'ex35_dimx', 'ex35_bg', 
		'ex41_dimx', 'ex41_dimy', 'ex41_bg', 'ex45_dimx', 'ex45_dimy', 'ex45_bg', 
		'ex51_dimx', 'ex51_dimy', 'ex51_bg', 'ex52_dimx', 'ex52_dimy', 'ex52_bg', 'ex53_dimy', 'ex53_bg', 'ex54_dimx', 'ex54_dimy', 'ex54_bg', 'ex55_dimx', 'ex55_dimy', 'ex55_bg'
 		];
		var ListeDivsSetX = ['ex11', 'ex12', 'ex14', 'ex15', 'ex21', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex54', 'ex55'];
		var ListeDivsSetY = ['ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex25', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55'];
		var ListeDivsSetBG = ['ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex22', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55'];
	break;

	case 'elysion':
		var ListeDivsGebi = [
		'ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex22', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55',
		'in11', 'in12', 'in13', 'in14', 'in15', 'in21', 'in25', 'in31', 'in35', 'in41', 'in45', 'in51', 'in52', 'in53', 'in54', 'in55'
		];
		var ListeForms = [
		'ex11_dimx', 'ex11_dimy', 'ex11_bg', 'ex12_dimx', 'ex12_dimy', 'ex12_bg', 'ex13_dimy', 'ex13_bg', 'ex14_dimx', 'ex14_dimy', 'ex14_bg', 'ex15_dimx', 'ex15_dimy', 'ex15_bg', 
		'ex21_dimx', 'ex21_dimy', 'ex21_bg', 'ex22_bg', 'ex25_dimx', 'ex25_dimy', 'ex25_bg', 
		'ex31_dimx', 'ex31_bg', 'ex35_dimx', 'ex35_bg', 
		'ex41_dimx', 'ex41_dimy', 'ex41_bg', 'ex45_dimx', 'ex45_dimy', 'ex45_bg', 
		'ex51_dimx', 'ex51_dimy', 'ex51_bg', 'ex52_dimx', 'ex52_dimy', 'ex52_bg', 'ex53_dimy', 'ex53_bg', 'ex54_dimx', 'ex54_dimy', 'ex54_bg', 'ex55_dimx', 'ex55_dimy', 'ex55_bg',

		'in11_dimx', 'in11_dimy', 'in11_bg', 'in12_dimx', 'in12_dimy', 'in12_bg', 'in13_dimy', 'in13_bg', 'in14_dimx', 'in14_dimy', 'in14_bg', 'in15_dimx', 'in15_dimy', 'in15_bg', 
		'in21_dimx', 'in21_dimy', 'in21_bg', 'in25_dimx', 'in25_dimy', 'in25_bg', 
		'in31_dimx', 'in31_bg', 'in35_dimx', 'in35_bg', 
		'in41_dimx', 'in41_dimy', 'in41_bg', 'in45_dimx', 'in45_dimy', 'in45_bg', 
		'in51_dimx', 'in51_dimy', 'in51_bg', 'in52_dimx', 'in52_dimy', 'in52_bg', 'in53_dimy', 'in53_bg', 'in54_dimx', 'in54_dimy', 'in54_bg', 'in55_dimx', 'in55_dimy', 'in55_bg'
 		];
		var ListeDivsSetX = [
		'ex11', 'ex12', 'ex14', 'ex15', 'ex21', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex54', 'ex55',
		'in11', 'in12', 'in14', 'in15', 'in21', 'in25', 'in31', 'in35', 'in41', 'in45', 'in51', 'in52', 'in54', 'in55'
		];
		var ListeDivsSetY = [
		'ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex25', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55',
		'in11', 'in12', 'in13', 'in14', 'in15', 'in21', 'in25', 'in41', 'in45', 'in51', 'in52', 'in53', 'in54', 'in55'
		];
		var ListeDivsSetBG = [
		'ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex22', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55',
		'in11', 'in12', 'in13', 'in14', 'in15', 'in21', 'in25', 'in31', 'in35', 'in41', 'in45', 'in51', 'in52', 'in53', 'in54', 'in55'
		];
	break;
	}

	var ModDiv = Array();
	var DataForm = Array();
	var Rep = document.forms[FormCible].elements['M_DECORA[repertoire]'].value ; //'
	for ( var Div in ListeDivsGebi ) { ModDiv[ListeDivsGebi[Div]] = Gebi( NomModule + '_' + ListeDivsGebi[Div]); }
	for ( var Field in ListeForms ) { DataForm[ListeForms[Field]] = document.forms[FormCible].elements['M_DECORA[' + NomModule + '_' + ListeForms[Field] + ']'].value ; }

	var Var_pos_x1_22 = Number(TabValInitiales[NomModule].pos_x1_22);
	var Var_pos_x2_22 = Number(TabValInitiales[NomModule].pos_x2_22);
	var Var_pos_y1_22 = Number(TabValInitiales[NomModule].pos_y1_22);
	var Var_pos_y3_22 = Number(TabValInitiales[NomModule].pos_y3_22);

	switch ( ModType ) {
	case 'elegance':
		ModDiv['ex11'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex11_dimx']) ) + 'px';
		ModDiv['ex11'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex11_dimy']) ) + 'px';
		ModDiv['ex12'].style.left =   Var_pos_x1_22 + 'px';
		ModDiv['ex12'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex12_dimy']) ) + 'px';
		ModDiv['ex13'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex13'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex13_dimy']) ) + 'px';
		ModDiv['ex21'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex21_dimx']) ) + 'px';
		ModDiv['ex21'].style.top  =   Var_pos_y1_22 + 'px';
		ModDiv['ex23'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex23'].style.top  =   Var_pos_y1_22 + 'px';
		ModDiv['ex31'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex31_dimx']) ) + 'px';
		ModDiv['ex31'].style.top  =   Var_pos_y3_22 + 'px';
		ModDiv['ex32'].style.left =   Var_pos_x1_22 + 'px';
		ModDiv['ex32'].style.top  =   Var_pos_y3_22 + 'px';
		ModDiv['ex33'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex33'].style.top  =   Var_pos_y3_22 + 'px';
	break;

	case 'exquise':
		ModDiv['ex11'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex11_dimx']) ) + 'px';
		ModDiv['ex11'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex11_dimy']) ) + 'px';
		ModDiv['ex12'].style.left =   Var_pos_x1_22 + 'px';
		ModDiv['ex12'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex12_dimy']) ) + 'px';
		ModDiv['ex13'].style.left = ( Var_pos_x1_22 + Number(DataForm['ex12_dimx']) ) + 'px';
		ModDiv['ex13'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex13_dimy']) ) + 'px';
		ModDiv['ex14'].style.left = ( Var_pos_x2_22 - Number(DataForm['ex14_dimx']) ) + 'px';
		ModDiv['ex14'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex14_dimy']) ) + 'px';
		ModDiv['ex15'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex15'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex15_dimy']) ) + 'px';

		ModDiv['ex21'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex21_dimx']) ) + 'px';
		ModDiv['ex21'].style.top  =   Var_pos_y1_22 + 'px';
		ModDiv['ex25'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex25'].style.top  =   Var_pos_y1_22 + 'px';

		ModDiv['ex31'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex31_dimx']) ) + 'px';
		ModDiv['ex31'].style.top  = ( Var_pos_y1_22 + Number(DataForm['ex21_dimy']) ) + 'px';
		ModDiv['ex35'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex35'].style.top  = ( Var_pos_y1_22 + Number(DataForm['ex25_dimy']) ) + 'px';

		ModDiv['ex41'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex41_dimx']) ) + 'px';
		ModDiv['ex41'].style.top  = ( Var_pos_y3_22 - Number(DataForm['ex41_dimy']) ) + 'px';
		ModDiv['ex45'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex45'].style.top  = ( Var_pos_y3_22 - Number(DataForm['ex45_dimy']) ) + 'px';

		ModDiv['ex51'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex51_dimx']) ) + 'px';
		ModDiv['ex51'].style.top  =   Var_pos_y3_22 + 'px';
		ModDiv['ex52'].style.left =   Var_pos_x1_22 + 'px';
		ModDiv['ex52'].style.top  =   Var_pos_y3_22 + 'px';
		ModDiv['ex53'].style.left = ( Var_pos_x1_22 + Number(DataForm['ex52_dimx']) ) + 'px';
		ModDiv['ex53'].style.top  =   Var_pos_y3_22 + 'px';
		ModDiv['ex54'].style.left = ( Var_pos_x2_22 - Number(DataForm['ex54_dimx']) ) + 'px';
		ModDiv['ex54'].style.top  =   Var_pos_y3_22 + 'px';
		ModDiv['ex55'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex55'].style.top  =   Var_pos_y3_22 + 'px';

		ModDiv['ex13'].style.width 	= ( Var_pos_x2_22 - Var_pos_x1_22 - Number(DataForm['ex12_dimx']) - Number(DataForm['ex14_dimx']) ) + 'px';
		ModDiv['ex53'].style.width 	= ( Var_pos_x2_22 - Var_pos_x1_22 - Number(DataForm['ex52_dimx']) - Number(DataForm['ex54_dimx']) ) + 'px';
		ModDiv['ex31'].style.height	= ( Var_pos_y3_22 - Var_pos_y1_22 - Number(DataForm['ex21_dimy']) - Number(DataForm['ex41_dimy']) ) + 'px';
		ModDiv['ex35'].style.height	= ( Var_pos_y3_22 - Var_pos_y1_22 - Number(DataForm['ex25_dimy']) - Number(DataForm['ex45_dimy']) ) + 'px';
	break;

	case 'elysion':
		ModDiv['ex11'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex11_dimx']) ) + 'px';
		ModDiv['ex11'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex11_dimy']) ) + 'px';
		ModDiv['ex12'].style.left =   Var_pos_x1_22 + 'px';
		ModDiv['ex12'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex12_dimy']) ) + 'px';
		ModDiv['ex13'].style.left = ( Var_pos_x1_22 + Number(DataForm['ex12_dimx']) ) + 'px';
		ModDiv['ex13'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex13_dimy']) ) + 'px';
		ModDiv['ex14'].style.left = ( Var_pos_x2_22 - Number(DataForm['ex14_dimx']) ) + 'px';
		ModDiv['ex14'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex14_dimy']) ) + 'px';
		ModDiv['ex15'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex15'].style.top  = ( Var_pos_y1_22 - Number(DataForm['ex15_dimy']) ) + 'px';

		ModDiv['ex21'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex21_dimx']) ) + 'px';
		ModDiv['ex21'].style.top  =   Var_pos_y1_22 + 'px';
		ModDiv['ex25'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex25'].style.top  =   Var_pos_y1_22 + 'px';

		ModDiv['ex31'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex31_dimx']) ) + 'px';
		ModDiv['ex31'].style.top  = ( Var_pos_y1_22 + Number(DataForm['ex21_dimy']) ) + 'px';
		ModDiv['ex35'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex35'].style.top  = ( Var_pos_y1_22 + Number(DataForm['ex25_dimy']) ) + 'px';

		ModDiv['ex41'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex41_dimx']) ) + 'px';
		ModDiv['ex41'].style.top  = ( Var_pos_y3_22 - Number(DataForm['ex41_dimy']) ) + 'px';
		ModDiv['ex45'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex45'].style.top  = ( Var_pos_y3_22 - Number(DataForm['ex45_dimy']) ) + 'px';

		ModDiv['ex51'].style.left = ( Var_pos_x1_22 - Number(DataForm['ex51_dimx']) ) + 'px';
		ModDiv['ex51'].style.top  =   Var_pos_y3_22 + 'px';
		ModDiv['ex52'].style.left =   Var_pos_x1_22 + 'px';
		ModDiv['ex52'].style.top  =   Var_pos_y3_22 + 'px';
		ModDiv['ex53'].style.left = ( Var_pos_x1_22 + Number(DataForm['ex52_dimx']) ) + 'px';
		ModDiv['ex53'].style.top  =   Var_pos_y3_22 + 'px';
		ModDiv['ex54'].style.left = ( Var_pos_x2_22 - Number(DataForm['ex54_dimx']) ) + 'px';
		ModDiv['ex54'].style.top  =   Var_pos_y3_22 + 'px';
		ModDiv['ex55'].style.left =   Var_pos_x2_22 + 'px';
		ModDiv['ex55'].style.top  =   Var_pos_y3_22 + 'px';

		ModDiv['ex13'].style.width 	= ( Var_pos_x2_22 - Var_pos_x1_22 - Number(DataForm['ex12_dimx']) - Number(DataForm['ex14_dimx']) ) + 'px';
		ModDiv['ex53'].style.width 	= ( Var_pos_x2_22 - Var_pos_x1_22 - Number(DataForm['ex52_dimx']) - Number(DataForm['ex54_dimx']) ) + 'px';
		ModDiv['ex31'].style.height	= ( Var_pos_y3_22 - Var_pos_y1_22 - Number(DataForm['ex21_dimy']) - Number(DataForm['ex41_dimy']) ) + 'px';
		ModDiv['ex35'].style.height	= ( Var_pos_y3_22 - Var_pos_y1_22 - Number(DataForm['ex25_dimy']) - Number(DataForm['ex45_dimy']) ) + 'px';

		ModDiv['in11'].style.left =   Var_pos_x1_22 + 'px';
		ModDiv['in11'].style.top  =   Var_pos_y1_22 + 'px';
		ModDiv['in12'].style.left = ( Var_pos_x1_22 + Number(DataForm['in11_dimx']) ) + 'px';
		ModDiv['in12'].style.top  =   Var_pos_y1_22 + 'px';
		ModDiv['in13'].style.left = ( Var_pos_x1_22 + Number(DataForm['in11_dimx']) + Number(DataForm['in12_dimx']) ) + 'px';
		ModDiv['in13'].style.top  =   Var_pos_y1_22 + 'px';
		ModDiv['in14'].style.left = ( Var_pos_x2_22 - Number(DataForm['in14_dimx']) - Number(DataForm['in15_dimx']) ) + 'px';
		ModDiv['in14'].style.top  =   Var_pos_y1_22 + 'px';
		ModDiv['in15'].style.left = ( Var_pos_x2_22 - Number(DataForm['in14_dimx']) ) + 'px';
		ModDiv['in15'].style.top  =   Var_pos_y1_22 + 'px';

		//ModDiv['in21'].style.left =   Var_pos_x1_22 + 'px';
		//ModDiv['in21'].style.top  = ( Var_pos_y1_22 + Number(DataForm['in11_dimy']) ) + 'px';
		ModDiv['in25'].style.left = ( Var_pos_x2_22 - Number(DataForm['in25_dimx']) ) + 'px';
		ModDiv['in25'].style.top  = ( Var_pos_y1_22 + Number(DataForm['in15_dimy']) ) + 'px';

		ModDiv['in31'].style.left =   Var_pos_x1_22 + 'px';
		ModDiv['in31'].style.top  = ( Var_pos_y1_22 + Number(DataForm['in11_dimy']) + Number(DataForm['in21_dimy']) ) + 'px';
		ModDiv['in35'].style.left = ( Var_pos_x2_22 - Number(DataForm['in35_dimx']) ) + 'px';
		ModDiv['in35'].style.top  = ( Var_pos_y1_22 + Number(DataForm['in15_dimy']) + Number(DataForm['in25_dimy']) ) + 'px';

		ModDiv['in41'].style.left =   Var_pos_x1_22 + 'px';
		ModDiv['in41'].style.top  = ( Var_pos_y3_22 - Number(DataForm['in41_dimy']) - Number(DataForm['in51_dimy']) ) + 'px';
		ModDiv['in45'].style.left = ( Var_pos_x2_22 - Number(DataForm['in45_dimx']) ) + 'px';
		ModDiv['in45'].style.top  = ( Var_pos_y3_22 - Number(DataForm['in45_dimy']) - Number(DataForm['in55_dimy']) ) + 'px';

		ModDiv['in51'].style.left =   Var_pos_x1_22 + 'px';
		ModDiv['in51'].style.top  = ( Var_pos_y3_22 - Number(DataForm['in51_dimy']) ) + 'px';
		ModDiv['in52'].style.left = ( Var_pos_x1_22 + Number(DataForm['in51_dimx']) ) + 'px';
		ModDiv['in52'].style.top  = ( Var_pos_y3_22 - Number(DataForm['in52_dimy']) ) + 'px';
		ModDiv['in53'].style.left = ( Var_pos_x1_22 + Number(DataForm['in51_dimx']) + Number(DataForm['in52_dimx']) ) + 'px';
		ModDiv['in53'].style.top  = ( Var_pos_y3_22 - Number(DataForm['in53_dimy']) ) + 'px';
		ModDiv['in54'].style.left = ( Var_pos_x2_22 - Number(DataForm['in54_dimx']) - Number(DataForm['in55_dimx']) ) + 'px';
		ModDiv['in54'].style.top  = ( Var_pos_y3_22 - Number(DataForm['in54_dimy']) ) + 'px';
		ModDiv['in55'].style.left = ( Var_pos_x2_22 - Number(DataForm['in55_dimx']) ) + 'px';
		ModDiv['in55'].style.top  = ( Var_pos_y3_22 - Number(DataForm['in55_dimy']) ) + 'px';

		ModDiv['in13'].style.width 	= ( Var_pos_x2_22 - Var_pos_x1_22 - Number(DataForm['in11_dimx']) - Number(DataForm['in12_dimx']) - Number(DataForm['in14_dimx']) - Number(DataForm['in15_dimx']) ) + 'px';
		ModDiv['in53'].style.width 	= ( Var_pos_x2_22 - Var_pos_x1_22 - Number(DataForm['in51_dimx']) - Number(DataForm['in52_dimx']) - Number(DataForm['in54_dimx']) - Number(DataForm['in55_dimx']) ) + 'px';
		ModDiv['in31'].style.height	= ( Var_pos_y3_22 - Var_pos_y1_22 - Number(DataForm['in11_dimy']) - Number(DataForm['in21_dimy']) - Number(DataForm['in41_dimy']) - Number(DataForm['in51_dimy']) ) + 'px';
		ModDiv['in35'].style.height	= ( Var_pos_y3_22 - Var_pos_y1_22 - Number(DataForm['in15_dimy']) - Number(DataForm['in25_dimy']) - Number(DataForm['in45_dimy']) - Number(DataForm['in55_dimy']) ) + 'px';
	break;
	}

	for ( var Div in ListeDivsSetX ) { ModDiv[ListeDivsSetX[Div]].style.width  = DataForm[ListeDivsSetX[Div] + '_dimx'] + 'px'; }
	for ( var Div in ListeDivsSetY ) { ModDiv[ListeDivsSetY[Div]].style.height = DataForm[ListeDivsSetY[Div] + '_dimy'] + 'px';}
	for ( var Div in ListeDivsSetBG ) { ModDiv[ListeDivsSetBG[Div]].style.backgroundImage = 'url(\'../graph/' + Rep + '/' + DataForm[ListeDivsSetBG[Div] + '_bg'] + '\')'; }

	CDMExec.ModType = "";
}

function Calcule_taille_texte () {
	var min = Number(document.forms['formulaire_gdd'].elements['M_DECORA[Bloc_GD_caligraphe_taille_mini]'].value); //'
	var max = Number(document.forms['formulaire_gdd'].elements['M_DECORA[Bloc_GD_caligraphe_taille_maxi]'].value); //'
	var coef = ( max - min ) / 6;
	for (var fnt = 1; fnt <= 7; fnt++ ) {
		Gebi( 'Bloc_GD_caligraphe_t' + fnt ).style.fontSize = Math.floor( min + (( fnt - 1 ) * coef )) + 'px'
	}
}


function GestionDecorationCaligraph ( ) {
	var Diese = '#';
	var RepDeco = document.forms['formulaire_gdd'].elements['M_DECORA[repertoire]'].value; //'
	for ( var Ptr in TabTJEDCaligraph ) { 
		Diese = '#';
		if ( TabTJEDCaligraph[Ptr].ObjSource.value == 'transparent' ) { Diese = ''; }
		switch ( TabTJEDCaligraph[Ptr].Methode ) {
		case 'color' : 				TabTJEDCaligraph[Ptr].ObjCible.style.color = Diese + TabTJEDCaligraph[Ptr].ObjSource.value;				break;
		case 'backgroundColor' :	TabTJEDCaligraph[Ptr].ObjCible.style.backgroundColor = Diese + TabTJEDCaligraph[Ptr].ObjSource.value;	break; 
		case 'backgroundImage' :	TabTJEDCaligraph[Ptr].ObjCible.style.backgroundImage = 'url(\'../graph/' + RepDeco + '/' + TabTJEDCaligraph[Ptr].ObjSource.value + '\')';		break; //'
		case 'backgroundPosition':	TabTJEDCaligraph[Ptr].ObjCible.style.backgroundPosition = TabTJEDCaligraph[Ptr].ObjSource.value;		break;
		case 'width' : 				TabTJEDCaligraph[Ptr].ObjCible.style.width = TabTJEDCaligraph[Ptr].ObjSource.value + 'px';				break;
		case 'height' :				TabTJEDCaligraph[Ptr].ObjCible.style.height = TabTJEDCaligraph[Ptr].ObjSource.value + 'px';				break; 
		case 'borderLeftStyle':		TabTJEDCaligraph[Ptr].ObjCible.style.borderLeftStyle = TabTJEDCaligraph[Ptr].ObjSource.value;			break;
		case 'borderRightStyle':	TabTJEDCaligraph[Ptr].ObjCible.style.borderRightStyle = TabTJEDCaligraph[Ptr].ObjSource.value;			break;
		case 'borderTopStyle':		TabTJEDCaligraph[Ptr].ObjCible.style.borderTopStyle = TabTJEDCaligraph[Ptr].ObjSource.value;			break;
		case 'borderBottomStyle':	TabTJEDCaligraph[Ptr].ObjCible.style.borderBottomStyle = TabTJEDCaligraph[Ptr].ObjSource.value;			break;
		}
	}
}

function GestionDecorationOneDiv ( ) {
	var Diese = '#';
	var RepDeco = document.forms['formulaire_gdd'].elements['M_DECORA[repertoire]'].value; //'
	for ( var Ptr in TabTJEDOneDiv ) { 
		Diese = '#';
		if ( TabTJEDOneDiv[Ptr].ObjSource.value == 'transparent' ) { Diese = ''; }
		switch ( TabTJEDOneDiv[Ptr].Methode ) {
		case 'color' :				TabTJEDOneDiv[Ptr].ObjCible.style.color = Diese + TabTJEDOneDiv[Ptr].ObjSource.value;				break;
		case 'backgroundColor' :	TabTJEDOneDiv[Ptr].ObjCible.style.backgroundColor = Diese + TabTJEDOneDiv[Ptr].ObjSource.value;		break; 
		case 'borderTopColor' :		TabTJEDOneDiv[Ptr].ObjCible.style.borderTopColor = Diese + TabTJEDOneDiv[Ptr].ObjSource.value;		break; 
		case 'borderLeftColor':		TabTJEDOneDiv[Ptr].ObjCible.style.borderLeftColor = Diese + TabTJEDOneDiv[Ptr].ObjSource.value;		break;
		case 'borderRightColor':	TabTJEDOneDiv[Ptr].ObjCible.style.borderRightColor = Diese + TabTJEDOneDiv[Ptr].ObjSource.value;	break;
		case 'borderBottomColor':	TabTJEDOneDiv[Ptr].ObjCible.style.borderBottomColor = Diese + TabTJEDOneDiv[Ptr].ObjSource.value;	break;

		case 'borderTopStyle':		TabTJEDOneDiv[Ptr].ObjCible.style.borderTopStyle = TabTJEDOneDiv[Ptr].ObjSource.value;			break;
		case 'borderLeftStyle':		TabTJEDOneDiv[Ptr].ObjCible.style.borderLeftStyle = TabTJEDOneDiv[Ptr].ObjSource.value;			break;
		case 'borderRightStyle':	TabTJEDOneDiv[Ptr].ObjCible.style.borderRightStyle = TabTJEDOneDiv[Ptr].ObjSource.value;		break;
		case 'borderBottomStyle':	TabTJEDOneDiv[Ptr].ObjCible.style.borderBottomStyle = TabTJEDOneDiv[Ptr].ObjSource.value;		break;

		case 'borderTopWidth':		TabTJEDOneDiv[Ptr].ObjCible.style.borderTopWidth = TabTJEDOneDiv[Ptr].ObjSource.value + 'px';		break;
		case 'borderLeftWidth':		TabTJEDOneDiv[Ptr].ObjCible.style.borderLeftWidth = TabTJEDOneDiv[Ptr].ObjSource.value + 'px';		break;
		case 'borderRightWidth':	TabTJEDOneDiv[Ptr].ObjCible.style.borderRightWidth = TabTJEDOneDiv[Ptr].ObjSource.value + 'px';		break;
		case 'borderBottomWidth':	TabTJEDOneDiv[Ptr].ObjCible.style.borderBottomWidth = TabTJEDOneDiv[Ptr].ObjSource.value + 'px';	break;

		case 'backgroundColor' :	TabTJEDOneDiv[Ptr].ObjCible.style.backgroundColor = Diese + TabTJEDOneDiv[Ptr].ObjSource.value;		break;
		case 'backgroundImage' :	TabTJEDOneDiv[Ptr].ObjCible.style.backgroundImage = 'url(\'../graph/' + RepDeco + '/' + TabTJEDOneDiv[Ptr].ObjSource.value + '\')';		break; //'
		}
	}
}

function GestionDecorationOneDivAllCol ( ) {
	for ( var Rch in TabTJEDOneDiv ) { 
		if ( TabTJEDOneDiv[Rch].Methode == 'borderallColor' ) { var ColorAll = TabTJEDOneDiv[Rch].ObjSource.value; }
	}
	var Diese = '#';
	if ( ColorAll == 'transparent' ) { Diese = ''; }

	modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[Bloc_GD_1_div_blc]' , ColorAll );
	modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[Bloc_GD_1_div_brc]' , ColorAll );
	modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[Bloc_GD_1_div_btc]' , ColorAll );
	modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[Bloc_GD_1_div_bbc]' , ColorAll );

	for ( var Ptr in TabTJEDOneDiv ) { 
		switch ( TabTJEDOneDiv[Ptr].Methode ) {
		case 'borderTopColor' :		TabTJEDOneDiv[Ptr].ObjCible.style.borderTopColor = Diese + ColorAll;	break; 
		case 'borderLeftColor':		TabTJEDOneDiv[Ptr].ObjCible.style.borderLeftColor = Diese + ColorAll;	break;
		case 'borderRightColor':	TabTJEDOneDiv[Ptr].ObjCible.style.borderRightColor = Diese + ColorAll;	break;
		case 'borderBottomColor':	TabTJEDOneDiv[Ptr].ObjCible.style.borderBottomColor = Diese + ColorAll;	break;
		}
	}
	GestionDecorationOneDiv (); 
}


function GestionDecorationMenu ( ) {
	var Diese = '#';
	var RepDeco = document.forms['formulaire_gdd'].elements['M_DECORA[repertoire]'].value; //'

	var ListeElmLienA = ['Bloc_GD_menu_lienA', 'Bloc_GD_menu_lienA02', 'Bloc_GD_menu_lienA03', 'Bloc_GD_menu_lienA04', 'Bloc_GD_menu_lienA05', 'Bloc_GD_menu_lienA06'];
	var ListeElmLienAH = ['Bloc_GD_menu_lienAH', 'Bloc_GD_menu_lienAH02'];
	var ListeElmLienAAH = ['Bloc_GD_menu_lienA', 'Bloc_GD_menu_lienA02', 'Bloc_GD_menu_lienA03', 'Bloc_GD_menu_lienA04', 'Bloc_GD_menu_lienA05', 'Bloc_GD_menu_lienA06', 'Bloc_GD_menu_lienAH', 'Bloc_GD_menu_lienAH02'];
	var ListeElmIcon = [ 'Bloc_GD_menu_rep01', 'Bloc_GD_menu_rep02', 'Bloc_GD_menu_fic01', 'Bloc_GD_menu_fic02', 'Bloc_GD_menu_spe01', 'Bloc_GD_menu_spe02', 'Bloc_GD_menu_fic01AH', 'Bloc_GD_menu_rep01AH'];

	for ( var Ptr in TabTJEDMenu ) { 
		Diese = '#';
		if ( TabTJEDMenu[Ptr].ObjSource.value == 'transparent' ) { Diese = ''; }
		switch ( TabTJEDMenu[Ptr].Methode ) {
		case 'color' :				TabTJEDMenu[Ptr].ObjCible.style.color = Diese + TabTJEDMenu[Ptr].ObjSource.value;				break;
		case 'backgroundColor' :	TabTJEDMenu[Ptr].ObjCible.style.backgroundColor = Diese + TabTJEDMenu[Ptr].ObjSource.value;		break; 
		case 'border' :				TabTJEDMenu[Ptr].ObjCible.style.border = TabTJEDMenu[Ptr].ObjSource.value + 'px';				break; 
		case 'borderStyle' :		TabTJEDMenu[Ptr].ObjCible.style.borderStyle = TabTJEDMenu[Ptr].ObjSource.value;			break; 
		case 'borderColor' :		TabTJEDMenu[Ptr].ObjCible.style.borderColor = Diese + TabTJEDMenu[Ptr].ObjSource.value;	break; 
		case 'backgroundImage' :	TabTJEDMenu[Ptr].ObjCible.style.backgroundImage = 'url(\'../graph/' + RepDeco + '/' + TabTJEDMenu[Ptr].ObjSource.value + '\')';		break; 

		case 'fontFamily' :			TabTJEDMenu[Ptr].ObjCible.style.fontFamily = TabTJEDMenu[Ptr].ObjSource.value;			break; 
		case 'textAlign' :			TabTJEDMenu[Ptr].ObjCible.style.textAlign = TabTJEDMenu[Ptr].ObjSource.value;			break; 
		case 'verticalAlign' :		TabTJEDMenu[Ptr].ObjCible.style.verticalAlign = TabTJEDMenu[Ptr].ObjSource.value;		break; 
		case 'fontWeight' :			TabTJEDMenu[Ptr].ObjCible.style.fontWeight = TabTJEDMenu[Ptr].ObjSource.value;			break; 
		case 'textDecoration' :		TabTJEDMenu[Ptr].ObjCible.style.textDecoration = TabTJEDMenu[Ptr].ObjSource.value;		break; 

		case 'lineHeight' :			for ( var N in ListeElmLienAAH ) {  Gebi ( ListeElmLienAAH[N] ).style.lineHeight  = TabTJEDMenu[Ptr].ObjSource.value + 'px'; }		break; 
		case 'marginTop' :			for ( var N in ListeElmLienAAH ) {  Gebi ( ListeElmLienAAH[N] ).style.marginTop  = TabTJEDMenu[Ptr].ObjSource.value + 'px'; }		break; 
		case 'marginBottom' :		for ( var N in ListeElmLienAAH ) {  Gebi ( ListeElmLienAAH[N] ).style.marginBottom  = TabTJEDMenu[Ptr].ObjSource.value + 'px'; }		break; 
		case 'marginLeft' :			for ( var N in ListeElmLienAAH ) {  Gebi ( ListeElmLienAAH[N] ).style.marginLeft  = TabTJEDMenu[Ptr].ObjSource.value + 'px'; }		break; 
		case 'marginRight' :		for ( var N in ListeElmLienAAH ) {  Gebi ( ListeElmLienAAH[N] ).style.marginRight  = TabTJEDMenu[Ptr].ObjSource.value + 'px'; }		break; 

		case 'colorA' :				for ( var N in ListeElmLienA ) {  Gebi ( ListeElmLienA[N] ).style.color  = Diese + TabTJEDMenu[Ptr].ObjSource.value; }		break;
		case 'backgroundColorA' :	for ( var N in ListeElmLienA ) {  Gebi ( ListeElmLienA[N] ).style.backgroundColor  = Diese + TabTJEDMenu[Ptr].ObjSource.value; }		break; 
		case 'backgroundImageA' :	for ( var N in ListeElmLienA ) {  Gebi ( ListeElmLienA[N] ).style.backgroundImage  = 'url(\'../graph/' + RepDeco + '/' + TabTJEDMenu[Ptr].ObjSource.value + '\')'; }		break; 
		case 'fontSizeA' :			for ( var N in ListeElmLienA ) {  Gebi ( ListeElmLienA[N] ).style.fontSize  = TabTJEDMenu[Ptr].ObjSource.value + 'px'; }		break; 
		case 'fontFamilyA' :		for ( var N in ListeElmLienA ) {  Gebi ( ListeElmLienA[N] ).style.fontFamily  = TabTJEDMenu[Ptr].ObjSource.value; }		break; 
		case 'textAlignA' :			for ( var N in ListeElmLienA ) {  Gebi ( ListeElmLienA[N] ).style.textAlign  = TabTJEDMenu[Ptr].ObjSource.value; }		break; 
		case 'verticalAlignA' :		for ( var N in ListeElmLienA ) {  Gebi ( ListeElmLienA[N] ).style.verticalAlign  = TabTJEDMenu[Ptr].ObjSource.value; }	break; 
		case 'fontWeightA' :		for ( var N in ListeElmLienA ) {  Gebi ( ListeElmLienA[N] ).style.fontWeight  = TabTJEDMenu[Ptr].ObjSource.value; }		break; 
		case 'textDecorationA' :	for ( var N in ListeElmLienA ) {  Gebi ( ListeElmLienA[N] ).style.textDecoration  = TabTJEDMenu[Ptr].ObjSource.value; }	break; 

		case 'colorAH' :			for ( var N in ListeElmLienAH ) {  Gebi ( ListeElmLienAH[N] ).style.color  = Diese + TabTJEDMenu[Ptr].ObjSource.value; }		break;
		case 'backgroundColorAH' :	for ( var N in ListeElmLienAH ) {  Gebi ( ListeElmLienAH[N] ).style.backgroundColor  = Diese + TabTJEDMenu[Ptr].ObjSource.value; }		break; 
		case 'backgroundImageAH' :	for ( var N in ListeElmLienAH ) {  Gebi ( ListeElmLienAH[N] ).style.backgroundImage  = 'url(\'../graph/' + RepDeco + '/' + TabTJEDMenu[Ptr].ObjSource.value + '\')'; }		break; 
		case 'fontSizeAH' :			for ( var N in ListeElmLienAH ) {  Gebi ( ListeElmLienAH[N] ).style.fontSize  = TabTJEDMenu[Ptr].ObjSource.value + 'px'; }		break; 
		case 'fontFamilyAH' :		for ( var N in ListeElmLienAH ) {  Gebi ( ListeElmLienAH[N] ).style.fontFamily  = TabTJEDMenu[Ptr].ObjSource.value; }		break; 
		case 'textAlignAH' :		for ( var N in ListeElmLienAH ) {  Gebi ( ListeElmLienAH[N] ).style.textAlign  = TabTJEDMenu[Ptr].ObjSource.value; }		break; 
		case 'verticalAlignAH' :	for ( var N in ListeElmLienAH ) {  Gebi ( ListeElmLienAH[N] ).style.verticalAlign  = TabTJEDMenu[Ptr].ObjSource.value; }	break; 
		case 'fontWeightAH' :		for ( var N in ListeElmLienAH ) {  Gebi ( ListeElmLienAH[N] ).style.fontWeight  = TabTJEDMenu[Ptr].ObjSource.value; }		break; 
		case 'textDecorationAH' :	for ( var N in ListeElmLienAH ) {  Gebi ( ListeElmLienAH[N] ).style.textDecoration  = TabTJEDMenu[Ptr].ObjSource.value; }	break; 

		case 'iconeWidth' :			for ( var N in ListeElmIcon ) {  Gebi ( ListeElmIcon[N] ).style.width  = TabTJEDMenu[Ptr].ObjSource.value + 'px'; }		break; 
		case 'iconeHeight' :		for ( var N in ListeElmIcon ) {  Gebi ( ListeElmIcon[N] ).style.height  = TabTJEDMenu[Ptr].ObjSource.value + 'px'; }		break; 
		case 'iconeVisibility' :
			var DivVis = 'hidden';
			var DivDis = 'none';
			var menuSelect = TabTJEDMenu[Ptr].ObjSource;
			if ( menuSelect.options[menuSelect.selectedIndex].value == 'YES' ) { DivVis = 'visible'; DivDis = '';}
			for ( var N in ListeElmIcon ) {  
				Gebi ( ListeElmIcon[N] ).style.visibility  = DivVis; 
				Gebi ( ListeElmIcon[N] ).style.display  = DivDis; 
			}		
		break; 
//		case '' :			for ( var N in ListeElmLien ) {  Gebi ( ListeElmLien[N] ).style.  = TabTJEDMenu[Ptr].ObjSource.value + 'px'; }		break; 
		}
	}
}

function GDGestionRepertoire () {
	for ( var Ptr in TabTJLM ) {
		JSJournal[dbgGestDeco](
		TabTJLM[Ptr].Type  + ' / ' 
		+ TabTJLM[Ptr].ModType  + ' / '
		+ TabTJLM[Ptr].NomModule  + ' / '
		+ TabTJLM[Ptr].FormCible  + ' / '
		);

		switch ( TabTJLM[Ptr].Type ) {
		case '1':
			GestionDecorationMenu();
		break;
		case '2':
			GestionDecorationCaligraph();
		break;
		case '3':
			CDMExec.ModType = TabTJLM[Ptr].ModType;
			CDMExec.NomModule = TabTJLM[Ptr].NomModule;
			CDMExec.FormCible = TabTJLM[Ptr].FormCible;
			CalculeDecoModule( 0 , 0 , 0 );
		break;
		}
	}
}

