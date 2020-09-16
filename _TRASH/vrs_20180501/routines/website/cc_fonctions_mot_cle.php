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

$_REQUEST['liste_colonne']['motcle'] = array (
"mc_id",
"mc_etat",
"mc_nom",
"arti_id",
"site_id",
"mc_chaine",
"mc_compteur",
"mc_type",
"mc_donnee"
);

$_REQUEST['liste_colonne']['motcle_conversion'] = array (
"mc_etat",
"mc_type"
);

$_REQUEST['liste_colonne']['motcle_reference'] = array (
"id",
"etat",
"nom",
"article",
"site",
"chaine",
"compteur",
"type",
"donnee"
);

function initialisation_valeurs_mot_cle () {
	$R = &$_REQUEST['M_MOTCLE'];

	$R['id']		= "";
	$R['etat']		= "ONLINE";
	$R['nom']		= "nouveau_mot_cle";
	$R['article']	= "";
	$R['site']	 	= $_REQUEST['site_context']['site_id'];
	$R['chaine']	= "";
	$R['nombre']	= 1;
	$R['type']		= "";
	$R['donnee'] 	= "";
	$R['filtre'] 	= "";

	$R['site_id']	= &$R['site'];
	$R['arti_id']	= &$R['article'];

	$R['name']		= &$R['nom'];
	$R['state']		= &$R['etat'];
	$R['string']	= &$R['chaine'];
	$R['count']		= &$R['compteur'];
	$R['data']		= &$R['donnee'];
	$R['filter'] 	= &$R['filtre'];

	reset ( $_REQUEST['liste_colonne']['motcle_reference'] );
	foreach ( $_REQUEST['liste_colonne']['motcle_reference'] as $A ) { $R['mc_'.$A] = &$R[$A];	}
}

function chargement_valeurs_mot_cle () {
	global $SQL_tab , $SQL_tab_abrege, $tab_conv_expr;
	$R = &$_REQUEST['M_MOTCLE'];

	$tl_['eng']['log_init'] = "Loading keyword datas";
	$tl_['fra']['log_init'] = "Chargement valeurs du mot cle";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT *  
	FROM ".$SQL_tab_abrege['mot_cle']." 
	WHERE mc_nom = '".$R['nom']."' 
	AND site_id = '".$_REQUEST['site_context']['site_id']."' 
	;");

	if ( num_row_sql($dbquery) == 0 ) {
		$tl_['eng']['err_001'] = "The keyword named '".$R['nom']."' doesn't exists.";
		$tl_['fra']['err_001'] = "La mot cle '".$R['nom']."' n'existe pas.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CVC_001" ,$tl_[$l]['err_001'] ); 
	}
	else {
		$p = $tab_conv_expr['M_MOTCLE']['offline'];				$tab_etat[$p] = "offline";
		$p = $tab_conv_expr['M_MOTCLE']['online'];				$tab_etat[$p] = "online";
		$p = $tab_conv_expr['M_MOTCLE']['deleted'];				$tab_etat[$p] = "deleted";
		$p = $tab_conv_expr['M_MOTCLE']['vers_categorie'];		$tab_type[$p] = "vers_categorie";
		$p = $tab_conv_expr['M_MOTCLE']['vers_url'];				$tab_type[$p] = "vers_url";
		$p = $tab_conv_expr['M_MOTCLE']['vers_aide_dynamique'];	$tab_type[$p] = "vers_aide_dynamique";
		while ($dbp = fetch_array_sql($dbquery)) {
			$R['id']			= $dbp['mc_id'];
			$R['nom']			= $dbp['mc_name'];
			$R['etat']			= $tab_etat[$dbp['mc_etat']];
			$R['article']		= $dbp['arti_id'];
			$R['site_id']		= $dbp['site_id'];
			$R['chaine']		= $dbp['mc_chaine'];
			$R['compteur']		= $dbp['mc_compteur'];
			$R['type']			= $tab_type[$dbp['mc_type']];
			$R['donnee'] 		= $dbp['mc_donnee'];
		}
	}
}

?>
