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
//groupe_tag		ANONYME:0	LECTEUR:1	STAFF:2

$_REQUEST['liste_colonne']['groupe'] = array (
"groupe_id",
"groupe_parent",
"groupe_tag",
"groupe_nom",
"groupe_titre",
"groupe_fichier",
"groupe_desc"
);

$_REQUEST['liste_colonne']['groupe_reference'] = array (
"id",
"parent",
"tag",
"nom",
"titre",
"fichier",
"desc"
);


function initialisation_valeurs_groupe () {
	$R = &$_REQUEST['M_GROUPE'];

	$R['id']		= "";
	$R['parent']	= "racine";
	$R['tag']		= 1;
	$R['nom']		= "Nouveau groupe";
	$R['titre']		= "Nouveau groupe";
	$R['fichier']	= "graph/universel/icone_developpeur_001.jpg";
	$R['desc']		= "Nouveau groupe";
	$R['filtre']	= "";

	$R['name']		= &$R['nom'];
	$R['title']		= &$R['titre'];
	$R['file']		= &$R['fichier'];
	$R['filter']	= &$R['filtre'];

	reset ( $_REQUEST['liste_colonne']['groupe_reference'] );
	foreach ( $_REQUEST['liste_colonne']['groupe_reference'] as $A ) { $R['groupe_'.$A] = &$R[$A];	}
}

function chargement_valeurs_groupe () {
	global $SQL_tab , $SQL_tab_abrege, $tab_conv_expr;
	$R = &$_REQUEST['M_GROUPE'];

	$tl_['eng']['log_init'] = "Loading groupe datas";
	$tl_['fra']['log_init'] = "Chargement valeurs du groupe";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT grp.* 
	FROM ".$SQL_tab_abrege['groupe']." grp , ".$SQL_tab_abrege['site_groupe']." sg 
	WHERE grp.groupe_nom = '".$R['nom']."' 
	AND grp.groupe_id = sg.groupe_id 
	AND sg.site_id = '".$_REQUEST['site_context']['site_id']."' 
	;");
	if ( num_row_sql($dbquery) == 0 ) {
		$tl_['eng']['err_001'] = "The group named '".$_REQUEST['M_MODULE']['nom']."' doesn't exists.";
		$tl_['fra']['err_001'] = "Le groupe '".$_REQUEST['M_MODULE']['nom']."' n'existe pas.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CVG_001" ,$tl_[$l]['err_001'] ); 
	}
	else {
		$p = $tab_conv_expr['M_GROUPE']['anonyme'];		$tab_tag[$p] = "anonyme";
		$p = $tab_conv_expr['M_GROUPE']['lecteur'];		$tab_tag[$p] = "lecteur";
		$p = $tab_conv_expr['M_GROUPE']['staff'];		$tab_tag[$p] = "staff";

		while ($dbp = fetch_array_sql($dbquery)) {
			$R['id']		= $dbp['groupe_id'];
			$R['parent']	= $dbp['groupe_parent'];
			$R['tag']		= $tab_tag[$dbp['groupe_tag']];
			$R['nom']		= $dbp['groupe_nom'];
			$R['titre']		= $dbp['groupe_titre'];
			$R['fichier']	= $dbp['groupe_fichier'];
			$R['desc']		= $dbp['groupe_desc'];
		}
	}
}

?>
