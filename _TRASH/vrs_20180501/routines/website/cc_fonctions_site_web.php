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
//sw_lang_select		NON:0	OUI:1
//sw_aide_dynamique		NON:0	OUI:1
//sw_etat				OFFLINE:0	ONLINE:1	SUPPRIME:2	MAINTENANCE:3
//sw_stylesheet			STATIQUE:0	DYNAMIQUE:1
//sm_etat				OFFLINE:0	ONLINE:1	SUPPRIME:2	MAINTENANCE:3 

$_REQUEST['liste_colonne']['site'] = array (
"sw_id",
"sw_nom",
"sw_abrege",
"sw_lang",
"sw_lang_select",
"theme_id",
"sw_titre",
"sw_barre_status",
"sw_home",
"sw_repertoire",
"sw_etat",
"sw_info_debug",
"sw_stylesheet",
"sw_gal_mode",
"sw_gal_fichier_tag",
"sw_gal_qualite",
"sw_gal_x",
"sw_gal_y",
"sw_gal_liserai",
"sw_ma_diff"
);

$_REQUEST['liste_colonne']['site_conversion'] = array (
"sw_lang",
"sw_lang_select",
"sw_etat",
"sw_stylesheet",
"sw_ma_diff"
);


$_REQUEST['liste_colonne']['site_reference'] = array (
"id",
"nom",
"abrege",
"lang",
"lang_select",
"theme_id",
"theme",
"titre",
"barre_status",
"home",
"repertoire",
"info_debug",
"stylesheet",
"etat",
"gal_mode",
"gal_fichier_tag",
"gal_qualite",
"gal_x",
"gal_y",
"gal_liserai",
"ma_diff",
"ajout_lang",
"suppression_lang",
"groupe",
"utilisateur",
"mot_de_passe",

"name",
"short",
"title",
"status_bar",
"directory",
"first_doc",
"state",
"debug_info_level",
"gal_file_tag",
"gal_quality",
"add_lang",
"delete_lang",
"del_lang",
"group",
"user",
"password",
"theme_nom"
);

function initialisation_valeurs_site_web () {
	$R = &$_REQUEST['M_SITWEB'];

	$R['id']				= "";
	$R['nom']				= "Nouveau site";
	$R['abrege']			= "Nouveau site";
	$R['lang']				= "fra";
	$R['lang_select']		= "YES";
	$R['theme_id']			= 1;
	$R['theme']				= "";
	$R['titre']				= "Nouveau site";
	$R['barre_status']		= "Nouveau site";
	$R['home']				= "www.nouveausite.com";
	$R['repertoire']		= "NA";
	$R['info_debug']		= "10";
	$R['stylesheet']		= "DYNAMIC";
	$R['etat']				= "ONLINE";
	$R['gal_mode']			= "BASE";
	$R['gal_fichier_tag']	= ".thumbnail";
	$R['gal_qualite']		= "40";
	$R['gal_x']				= "160";
	$R['gal_y']				= "160";
	$R['gal_liserai']		= "3";
	$R['ma_diff']			= "YES";
	$R['ajout_lang']		= "";
	$R['suppression_lang']	= "";
	$R['groupe']			= "";
	$R['utilisateur']		= "";
	$R['mot_de_passe']		= "";

	$R['name']				= &$R['nom'];
	$R['short']				= &$R['abrege'];
	$R['title']				= &$R['titre'];
	$R['status_bar']		= &$R['barre_status'];
	$R['directory']			= &$R['repertoire'];
	$R['first_doc']			= &$R['doc_premier'];
	$R['state']				= &$R['etat'];
	$R['debug_info_level']	= &$R['info_debug'];
	$R['gal_file_tag']		= &$R['gal_fichier_tag'];
	$R['gal_quality']		= &$R['gal_qualite'];
	$R['add_lang']			= &$R['ajout_lang'];
	$R['delete_lang']		= &$R['suppression_lang'];
	$R['del_lang']			= &$R['suppression_lang'];
	$R['group']				= &$R['groupe'];
	$R['user']				= &$R['utilisateur'];
	$R['password']			= &$R['mot_de_passe'];
	$R['theme_nom']			= &$R['theme'];

	reset ( $_REQUEST['liste_colonne']['site_reference'] );
	foreach ( $_REQUEST['liste_colonne']['site_reference'] as $A ) { $R['sw_'.$A] = &$R[$A];	}
}

function chargement_valeurs_site_web () {
	global $SQL_tab, $SQL_tab_abrege, $db, $tab_conv_expr;
 	$R = &$_REQUEST['M_SITWEB'];

	$tl_['eng']['log_init'] = "Loading website datas";
	$tl_['fra']['log_init'] = "Chargement valeurs du site";
	$tl_['eng']['err_001'] = "The website named '".$R['sw_nom']."' doesn't exists.";
	$tl_['fra']['err_001'] = "Le site '".$R['sw_nom']."' n'existe pas.";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['site_web']." 
	WHERE sw_nom = '".$R['sw_nom']."' 
	;");
	if ( num_row_sql($dbquery) == 0 ) {
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CVSW_0001", $tl_[$l]['err_001'] ); 
	}
	else {
		while ($dbp = fetch_array_sql($dbquery)) { 
			foreach ( $dbp as $A => $B ) { $R[$A] = $B; }
		}
		$p = $tab_conv_expr['M_SITWEB']['no'];		$tab_yn[$p] = "no";
		$p = $tab_conv_expr['M_SITWEB']['yes'];		$tab_yn[$p] = "yes";
		$p = $tab_conv_expr['M_SITWEB']['online'];	$tab_oo[$p] = "online";
		$p = $tab_conv_expr['M_SITWEB']['offline'];	$tab_oo[$p] = "offline";
		$p = $tab_conv_expr['M_SITWEB']['static'];	$tab_css[$p] = "static";
		$p = $tab_conv_expr['M_SITWEB']['dynamic'];	$tab_css[$p] = "dynamic";
		$p = $tab_conv_expr['M_SITWEB']['off'];		$tab_gal[$p] = "off";
		$p = $tab_conv_expr['M_SITWEB']['base'];	$tab_gal[$p] = "base";
		$p = $tab_conv_expr['M_SITWEB']['fichier'];	$tab_gal[$p] = "file";

		$R['sw_lang_select']		= $tab_yn[$R['sw_lang_select']];
		$R['sw_etat']				= $tab_oo[$R['sw_etat']];
		$R['sw_stylesheet']			= $tab_css[$R['sw_stylesheet']];
		$R['sw_gal_mode']			= $tab_gal[$R['sw_gal_mode']];
		$R['sw_ma_diff']			= $tab_yn[$R['sw_ma_diff']];
	}
}

?>
