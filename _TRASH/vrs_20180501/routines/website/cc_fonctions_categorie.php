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
//cate_type		ARTICLE_RACINE:0	ARTICLE:1	MENU_ADMIN_RACINE:2		MENU_ADMIN:3
//cate_etat 		OFFLINE:0	ONLINE:1	SUPPRIME:2


$_REQUEST['liste_colonne']['categorie'] = array (
"cate_id",
"cate_nom",
"cate_titre",
"cate_desc",
"cate_type",
"site_id",
"cate_lang",
"bouclage_id",
"cate_etat",
"cate_parent",
"cate_position",
"groupe_id",
"derniere_modif",
"cate_role",
"cate_doc_premier",
"arti_ref"
);

$_REQUEST['liste_colonne']['categorie_conversion'] = array (
"cate_type",
"cate_etat",
"cate_role",
"cate_doc_premier",
);

$_REQUEST['liste_colonne']['categorie_reference'] = array (
"id",
"nom",
"titre",
"desc",
"type",
"site_id",
"lang",
"bouclage_id",
"etat",
"parent",
"position",
"groupe_id",
"derniere_modif",
"role",
"doc_premier",
"arti_ref"
);

function initialisation_valeurs_categorie () {
	$R = &$_REQUEST['M_CATEGO'];

	$R['id']			= "";
	$R['nom']			= "Nouvelle categorie";
	$R['titre']			= "Nouvelle categorie";
	$R['desc']			= "Nouvelle categorie";
	$R['type']			= "ARTICLE";
	$R['site_id']		= $_REQUEST['site_context']['site_id'];
	$R['lang'] 			= "fra";
	$R['bouclage']		= "";
	$R['etat']			= "OFFLINE";
	$R['parent']		= 0;
	$R['position']		= "";
	$R['groupe']		= 1;
	$R['role']			= "NO";
	$R['doc_premier']	= "NO";
	$R['arti_ref']		= 1;
	$R['filtre']		= "";
	$R['derniere_modif']= time();

	$R['bouclage_id']	= &$R['bouclage'];
	$R['groupe_id']		= &$R['groupe'];

	$R['name']			= &$R['nom'];
	$R['title']			= &$R['titre'];
	$R['deadline']		= &$R['bouclage'];
	$R['state']			= &$R['etat'];
	$R['first_doc']		= &$R['doc_premier'];
	$R['article']		= &$R['arti_ref'];
	$R['filter']		= &$R['filtre'];
	$R['group']			= &$R['groupe'];

	reset ( $_REQUEST['liste_colonne']['categorie_reference'] );
	foreach ( $_REQUEST['liste_colonne']['categorie_reference'] as $A ) { $R['cate_'.$A] = &$R[$A];	}
}

function chargement_valeurs_categorie () {
	global $SQL_tab , $SQL_tab_abrege, $langues, $tab_conv_expr, $Outil_debug;
	$R = &$_REQUEST['M_CATEGO'];

	$tl_['eng']['log_init'] = "Loading category datas";
	$tl_['fra']['log_init'] = "Chargement valeurs de la categorie";
	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT cat.*, grp.groupe_nom, bcl.bouclage_nom 
	FROM ".$SQL_tab_abrege['categorie']." cat, ".$SQL_tab_abrege['groupe']." grp, ".$SQL_tab_abrege['bouclage']." bcl 
	WHERE cat.site_id = '".$_REQUEST['site_context']['site_id']."' 
	AND cate_nom = '".$R['nom']."'
	AND cat.groupe_id = grp.groupe_id
	AND cat.bouclage_id = bcl.bouclage_id
	;");

	if ( num_row_sql($dbquery) == 0 ) {
		$tl_['eng']['err_001'] = "The category named '".$R['nom']."' doesn't exists.";
		$tl_['fra']['err_001'] = "La categorie '".$R['nom']."' n'existe pas.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CVC_001" ,$tl_[$l]['err_001'] ); 
	}
	else {	
		unset ( $A , $B );
		while ($dbp = fetch_array_sql($dbquery)) { 
			foreach ( $dbp as $A => $B ) { $R[$A] = $B; }
		}
		$p = $tab_conv_expr['M_CATEGO']['offline'];				$tab_etat[$p] = "offline";
		$p = $tab_conv_expr['M_CATEGO']['online'];				$tab_etat[$p] = "online";
		$p = $tab_conv_expr['M_CATEGO']['deleted'];				$tab_etat[$p] = "deleted";
		$p = $tab_conv_expr['M_CATEGO']['root_article'];		$tab_type[$p] = "root_article";
		$p = $tab_conv_expr['M_CATEGO']['article'];				$tab_type[$p] = "article";
		$p = $tab_conv_expr['M_CATEGO']['root_admin_menu'];		$tab_type[$p] = "root_admin_menu";
		$p = $tab_conv_expr['M_CATEGO']['admin_menu'];			$tab_type[$p] = "admin_menu";
		$p = $tab_conv_expr['M_CATEGO']['no'];					$tab_yn[$p] = "no";
		$p = $tab_conv_expr['M_CATEGO']['yes'];					$tab_yn[$p] = "yes";
		$p = $tab_conv_expr['M_CATEGO']['no'];					$tab_ca[$p] = 0;
		$p = $tab_conv_expr['M_CATEGO']['correction_article'];	$tab_ca[$p] = "correction_article";

		$R['cate_type']			= $tab_type[$R['cate_type']];
		$R['cate_lang'] 		= $langues[$R['cate_lang']]['langue_639_3'];
		$R['cate_etat']			= $tab_etat[$R['cate_etat']];
		$R['cate_role']			= $tab_ca[$R['cate_role']];
		$R['cate_doc_premier']	= $tab_yn[$R['cate_doc_premier']];

		$R['groupe'] = $R['groupe_nom'];
		$R['bouclage'] = $R['bouclage_nom'];

		$_REQUEST['M_CATEGO_Initial_numerique']['parent'] = $R['parent'];
		if ( isset ($R['form_parent'] ))  { $R['parent'] = $R['form_parent']; }

		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT cate_id,cate_nom 
		FROM ".$SQL_tab_abrege['categorie']."  
		WHERE cate_nom = '".$R['parent']."' 
		;");
		while ($dbp = fetch_array_sql($dbquery)) { $R['parent'] = $dbp['cate_nom']; }

		$_REQUEST['M_CATEGO_Initial_texte']['position']		= $R['cate_position'];			//array copy = reference = *ù$!*ù
		$_REQUEST['M_CATEGO_Initial_texte']['etat']			= $R['cate_etat'];
		$_REQUEST['M_CATEGO_Initial_texte']['parent']		= $R['form_parent'];

//		outil_debug ( $_REQUEST['M_CATEGO'] , $_REQUEST['M_CATEGO'] );
	}


}

?>
