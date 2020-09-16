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
//config_menu_type				1=table 2=menu_select
//config_menu_style				1=normal 2=float
//config_menu_float_position	0=none 1=left 2=right
//config_menu_float_taille_x	0=auto
//config_menu_float_taille_y	0=auto
//config_menu_occurence			0=no_menu 1=top 2=bottom 3=both 4=store

$_REQUEST['liste_colonne']['config'] = array (
"config_id",
"config_nom",
"config_menu_type",
"config_menu_style",
"config_menu_float_position",
"config_menu_float_taille_x",
"config_menu_float_taille_y",
"config_menu_occurence",
"config_montre_info_parution",
"config_montre_info_modification",
"site_id"
);

$_REQUEST['liste_colonne']['config_conversion'] = array (
"config_menu_type",
"config_menu_style",
"config_menu_float_position",
"config_menu_occurence",
"config_montre_info_parution",
"config_montre_info_modification"
);


$_REQUEST['liste_colonne']['config_reference'] = array (
"id",
"nom",
"menu_type",
"menu_style",
"menu_float_position",
"menu_float_taille_x",
"menu_float_taille_y",
"menu_occurence",
"montre_info_parution",
"montre_info_modification",
"site_id",

"name",
"menu_float_size_x",
"menu_float_size_y",
"show_info_parution",
"show_info_modification",
"show_info_update"
);

function initialisation_valeurs_article_config () {
	$R = &$_REQUEST['M_ARTCFG'];

	$R['id']						= "";
	$R['nom']						= "";
	$R['menu_type']					= "MENU_SELECT";
	$R['menu_style']				= "FLOAT";
	$R['menu_float_position']		= "RIGHT";
	$R['menu_float_taille_x']		= "0";
	$R['menu_float_taille_y']		= "0";
	$R['menu_occurence']			= "TOP";
	$R['montre_info_parution']		= "ON";
	$R['montre_info_modification']	= "ON";
	$R['site_id']					= $_REQUEST['site_context']['site_id'];

	$R['name']						= &$R['nom'];
	$R['menu_float_size_x']			= &$R['menu_float_taille_x'];
	$R['menu_float_size_y']			= &$R['menu_float_taille_y'];
	$R['show_info_parution']		= &$R['montre_info_parution'];
	$R['show_info_modification']	= &$R['montre_info_modification'];
	$R['show_info_update']			= &$R['montre_info_modification'];

	reset ( $_REQUEST['liste_colonne']['config_reference'] );
	foreach ( $_REQUEST['liste_colonne']['config_reference'] as $A ) { $R['config_'.$A] = &$R[$A];	}
}

function chargement_valeurs_article_config () {
	global $SQL_tab , $SQL_tab_abrege, $tab_conv_expr;
	$R = &$_REQUEST['M_ARTCFG'];

	$tl_['eng']['log_init'] = "Loading article config datas";
	$tl_['fra']['log_init'] = "Chargement valeurs de la configuration d'article";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$_REQUEST['sru_ERR']  = &$R['ERR'];
	systeme_requete_unifiee ( 2 , "M_ARTCFG_rdac" , $R['nom'] , 0 , "CVAC_0001" , $R['id'] );

	if ( $R['ERR'] != 1 ) {
		$p = $tab_conv_expr['M_ARTCFG']['table'];		$tab_type[$p] = "table";
		$p = $tab_conv_expr['M_ARTCFG']['menu_select'];	$tab_type[$p] = "menu_select";
		$p = $tab_conv_expr['M_ARTCFG']['normal'];		$tab_style[$p] = "normal";
		$p = $tab_conv_expr['M_ARTCFG']['float'];		$tab_style[$p] = "float";
		$p = $tab_conv_expr['M_ARTCFG']['none'];		$tab_position[$p] = "none";
		$p = $tab_conv_expr['M_ARTCFG']['left'];		$tab_position[$p] = "left";
		$p = $tab_conv_expr['M_ARTCFG']['right'];		$tab_position[$p] = "right";
		$p = $tab_conv_expr['M_ARTCFG']['no_menu'];		$tab_occurence[$p] = "no_menu";
		$p = $tab_conv_expr['M_ARTCFG']['top'];			$tab_occurence[$p] = "top";
		$p = $tab_conv_expr['M_ARTCFG']['bottom'];		$tab_occurence[$p] = "bottom";
		$p = $tab_conv_expr['M_ARTCFG']['both'];		$tab_occurence[$p] = "both";
		$p = $tab_conv_expr['M_ARTCFG']['store'];		$tab_occurence[$p] = "store";
		$p = $tab_conv_expr['M_ARTICL']['no'];				$tab_yn[$p] = "no";
		$p = $tab_conv_expr['M_ARTICL']['yes'];				$tab_yn[$p] = "yes";

		$dbquery = requete_sql($_REQUEST['sql_initiateur'] ,"
		SELECT * 
		FROM ".$SQL_tab_abrege['article_config']." 
		WHERE config_id = '".$R['id']."' 
		AND site_id = '".$_REQUEST['site_context']['site_id']."' 
		;");
		while ($dbp = fetch_array_sql($dbquery)) { 
			$R['nom']						= $dbp['config_nom'];
			$R['menu_type']					= $tab_type[$dbp['config_menu_type']];
			$R['menu_style']				= $tab_style[$dbp['config_menu_style']];
			$R['menu_float_position']		= $tab_position[$dbp['config_menu_float_position']];
			$R['menu_float_taille_x']		= $dbp['config_menu_float_taille_x'];
			$R['menu_float_taille_y']		= $dbp['config_menu_float_taille_y'];
			$R['menu_occurence']			= $tab_occurence[$dbp['config_menu_occurence']];
			$R['montre_info_parution']		= $tab_yn[$dbp['config_montre_info_parution']];
			$R['montre_info_modification']	= $tab_yn[$dbp['config_montre_info_modification']];
		}
	}
}

?>
