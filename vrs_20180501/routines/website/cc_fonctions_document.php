<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
//	docu_type					WMCODE:0	NOCODE:1	PHP:2	MIXED:3

$_REQUEST['liste_colonne']['document'] = array (
"docu_id",
"docu_nom",
"docu_type",
"docu_origine",
"docu_createur",
"docu_creation_date",
"docu_correction",
"docu_correcteur",
"docu_correction_date",
"docu_cont"
);

$_REQUEST['liste_colonne']['document_conversion'] = array (
"docu_type",
"docu_correction",
"docu_modification"
);


$_REQUEST['liste_colonne']['document_reference'] = array (
"id",
"nom",
"type",
"origine",

"createur",

"correction",
"correcteur",
"du_site",
"cont",
"avec_site",
"modification",
"filtre",

"creator",
"checked",
"examiner",
"from_site",
"content",
"contenu",
"name",

"fichier",
"file",
"dans",
"to",
"with_site",
"filter"
);


function initialisation_valeurs_document () {
	$R = &$_REQUEST['M_DOCUME'];

	$R['id']			= "";
	$R['nom']			= "";
	$R['type']			= "MIXED";
	$R['origine']		= $_REQUEST['site_context']['site_id'];

	$R['createur']		= $_REQUEST['site_context']['user'];

	$R['correction']	= "NO";
	$R['correcteur']	= "";
	$R['du_site']		= "";
	$R['cont']			= "";
	$R['avec_site']		= "";
	$R['modification']	= "NO";
	$R['filtre']		= "";

	$R['creator']		= &$R['createur'];
	$R['checked']		= &$R['correction'];
	$R['examiner']		= &$R['correcteur'];
	$R['from_site']		= &$R['du_site'];
	$R['content']		= &$R['cont'];
	$R['contenu']		= &$R['cont'];
	$R['name']			= &$R['nom'];

	$R['fichier']		= "test.php";
	$R['file']			= &$R['fichier'];
	$R['dans']			= &$R['nom'];
	$R['to']			= &$R['nom'];
	$R['with_site']		= &$R['avec_site'];
	$R['filter']		= &$R['filtre'];

	reset ( $_REQUEST['liste_colonne']['document_reference'] );
	foreach ( $_REQUEST['liste_colonne']['document_reference'] as $A ) { $R['docu_'.$A] = &$R[$A];	}
}

function chargement_valeurs_document () {
	global $SQL_tab , $SQL_tab_abrege, $tab_conv_expr;
	$R = &$_REQUEST['M_DOCUME'];

	$tl_['eng']['log_init'] = "Loading document datas";
	$tl_['fra']['log_init'] = "Chargement valeurs du document";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$dbquery = requete_sql( $_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['document']." 
	WHERE docu_nom = '".$R['docu_nom']."' 
	;");
	if ( num_row_sql($dbquery) == 0 ) {
		$tl_['eng']['err_001'] = "The document named '".$R['docu_nom']."' doesn't exists.";
		$tl_['fra']['err_001'] = "Le document '".$R['docu_nom']."' n'existe pas.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CVD_001" , $tl_[$l]['err_001'] ); 
	}
	else {
		unset ( $A , $B );
		while ($dbp = fetch_array_sql($dbquery)) { 
			foreach ( $dbp as $A => $B ) { $R[$A] = $B; }
		}

		$p = $tab_conv_expr['M_DOCUME']['mwmcode'];		$tab_type[$p] = "mwmcode";
		$p = $tab_conv_expr['M_DOCUME']['nocode'];		$tab_type[$p] = "nocode";
		$p = $tab_conv_expr['M_DOCUME']['php'];			$tab_type[$p] = "php";
		$p = $tab_conv_expr['M_DOCUME']['mixed'];			$tab_type[$p] = "mixed";
		$p = $tab_conv_expr['M_CATEGO']['no'];		$tab_yn[$p] = "no";
		$p = $tab_conv_expr['M_CATEGO']['yes'];		$tab_yn[$p] = "yes";
		$R['docu_type']			= $tab_type[$R['docu_type']];
		$R['docu_correction']	= $R['docu_correction_comp']	= $tab_yn[$dbp['docu_correction']];

	}
}

?>
