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
//	$_REQUEST[M_PRESNT][defaut		NON:0	OUI:1

$_REQUEST['liste_colonne']['presentation'] = array (
"pres_id",
"pres_nom",
"pres_titre",
"pres_nom_generique",
"pres_desc"
);

$_REQUEST['liste_colonne']['presentation_contenu'] = array (
"pres_cont_id",
"pres_id",
"pres_ligne",
"pres_minimum_x",
"pres_minimum_y",
"pres_module_nom",
"pres_type_calcul",
"pres_position_x",		"pres_position_y",
"pres_dimenssion_x",	"pres_dimenssion_y",	
"pres_module_ancre_e1a",	"pres_ancre_ex1a",	"pres_ancre_ey1a",	
"pres_module_ancre_e1b",	"pres_ancre_ex1b",	"pres_ancre_ey1b",
"pres_module_ancre_e1c",	"pres_ancre_ex1c",	"pres_ancre_ey1c",
"pres_module_ancre_e1d",	"pres_ancre_ex1d",	"pres_ancre_ey1d",
"pres_module_ancre_e1e",	"pres_ancre_ex1e",	"pres_ancre_ey1e",
"pres_module_ancre_e2a",	"pres_ancre_ex2a",	"pres_ancre_ey2a",
"pres_module_ancre_e2b",	"pres_ancre_ex2b",	"pres_ancre_ey2b",
"pres_module_ancre_e2c",	"pres_ancre_ex2c",	"pres_ancre_ey2c",
"pres_module_ancre_e2d",	"pres_ancre_ex2d",	"pres_ancre_ey2d",
"pres_module_ancre_e2e",	"pres_ancre_ex2e",	"pres_ancre_ey2e",
"pres_module_ancre_e3a",	"pres_ancre_ex3a",	"pres_ancre_ey3a",
"pres_module_ancre_e3b",	"pres_ancre_ex3b",	"pres_ancre_ey3b",
"pres_module_ancre_e3c",	"pres_ancre_ex3c",	"pres_ancre_ey3c",
"pres_module_ancre_e3d",	"pres_ancre_ex3d",	"pres_ancre_ey3d",
"pres_module_ancre_e3e",	"pres_ancre_ex3e",	"pres_ancre_ey3e",
"pres_ancre_dx10",	"pres_ancre_dy10",
"pres_ancre_dx20",	"pres_ancre_dy20",
"pres_ancre_dx30",	"pres_ancre_dy30",
"pres_espacement_bord_gauche",
"pres_espacement_bord_droite",
"pres_espacement_bord_haut",
"pres_espacement_bord_bas",
"pres_module_zindex"
);

$_REQUEST['liste_colonne']['presentation_contenu_conversion'] = array ( 
"pres_ancre_ex1a", "pres_ancre_ey1a", 
"pres_ancre_ex1b", "pres_ancre_ey1b", 
"pres_ancre_ex1c", "pres_ancre_ey1c", 
"pres_ancre_ex1d", "pres_ancre_ey1d", 
"pres_ancre_ex1e", "pres_ancre_ey1e", 
"pres_ancre_dx10", "pres_ancre_dy10",
"pres_ancre_ex2a", "pres_ancre_ey2a", 
"pres_ancre_ex2b", "pres_ancre_ey2b", 
"pres_ancre_ex2c", "pres_ancre_ey2c", 
"pres_ancre_ex2d", "pres_ancre_ey2d", 
"pres_ancre_ex2e", "pres_ancre_ey2e", 
"pres_ancre_dx20", "pres_ancre_dy20",
"pres_ancre_ex3a", "pres_ancre_ey3a", 
"pres_ancre_ex3b", "pres_ancre_ey3b", 
"pres_ancre_ex3c", "pres_ancre_ey3c", 
"pres_ancre_ex3d", "pres_ancre_ey3d", 
"pres_ancre_ex3e", "pres_ancre_ey3e", 
"pres_ancre_dx30", "pres_ancre_dy30",
"pres_type_calcul"
);

$_REQUEST['liste_colonne']['presentation_contenu_reference'] = array ( 
"id",	
"nom",	
"titre",	
"nom_generique",	
"desc",	
"defaut",	
"assignee_a",	
"filtre",	
	
"name",	
"title",	
"generic_name",	
"description",	
"default",	
"assigned_to_theme",	
"filter",	
	
"cont_id",	
"ligne",	
"minimum_x",	
"minimum_y",	
"module_nom",	
"type_calcul",	
"position_x",	
"position_y",	
"dimenssion_x",	
"dimenssion_y",	
	
"ancre_dx10",	"ancre_dy10",		
"ancre_dx20",	"ancre_dy20",		
"ancre_dx30",	"ancre_dy30",		
	
"module_ancre_e1a",		"ancre_ex1a",	"ancre_ey1a",
"module_ancre_e1b",		"ancre_ex1b",	"ancre_ey1b",
"module_ancre_e1c",		"ancre_ex1c",	"ancre_ey1c",
"module_ancre_e1d",		"ancre_ex1d",	"ancre_ey1d",
"module_ancre_e1e",		"ancre_ex1e",	"ancre_ey1e",
	
"module_ancre_e2a",		"ancre_ex2a",	"ancre_ey2a",
"module_ancre_e2b",		"ancre_ex2b",	"ancre_ey2b",
"module_ancre_e2c",		"ancre_ex2c",	"ancre_ey2c",
"module_ancre_e2d",		"ancre_ex2d",	"ancre_ey2d",
"module_ancre_e2e",		"ancre_ex2e",	"ancre_ey2e",
	
"module_ancre_e3a",		"ancre_ex3a",	"ancre_ey3a",
"module_ancre_e3b",		"ancre_ex3b",	"ancre_ey3b",
"module_ancre_e3c",		"ancre_ex3c",	"ancre_ey3c",
"module_ancre_e3d",		"ancre_ex3d",	"ancre_ey3d",
"module_ancre_e3e",		"ancre_ex3e",	"ancre_ey3e",
	
"espacement_bord_gauche",	
"espacement_bord_droite",	
"espacement_bord_haut",	
"espacement_bord_bas",	
"module_zindex",
	
"line",	
"module_name",	
"calculus_type",	
	
"module_anchor_e1a",	"anchor_ex1a",	"anchor_ey1a",	
"module_anchor_e1b",	"anchor_ex1b",	"anchor_ey1b",	
"module_anchor_e1c",	"anchor_ex1c",	"anchor_ey1c",	
"module_anchor_e1d",	"anchor_ex1d",	"anchor_ey1d",	
"module_anchor_e1e",	"anchor_ex1e",	"anchor_ey1e",	
	
"module_anchor_e2a",	"anchor_ex2a",	"anchor_ey2a",	
"module_anchor_e2b",	"anchor_ex2b",	"anchor_ey2b",	
"module_anchor_e2c",	"anchor_ex2c",	"anchor_ey2c",	
"module_anchor_e2d",	"anchor_ex2d",	"anchor_ey2d",	
"module_anchor_e2e",	"anchor_ex2e",	"anchor_ey2e",	
	
"module_anchor_e3a",	"anchor_ex3a",	"anchor_ey3a",	
"module_anchor_e3b",	"anchor_ex3b",	"anchor_ey3b",	
"module_anchor_e3c",	"anchor_ex3c",	"anchor_ey3c",	
"module_anchor_e3d",	"anchor_ex3d",	"anchor_ey3d",	
"module_anchor_e3e",	"anchor_ex3e",	"anchor_ey3e",	
	
"anchor_dx10",	"anchor_dy10",	
"anchor_dx20",	"anchor_dy20",	
"anchor_dx30",	"anchor_dy30",	
	
"spacing_border_left",	
"spacing_border_right",	
"spacing_border_top",	
"spacing_border_bottom",	
	
"dans_la_presentation",	
"to_layout"
);

function initialisation_valeurs_presentation () {
	$R = &$_REQUEST['M_PRESNT'];

	$R['id']				= "";
	$R['nom']				= "Nouvelle_presentation";
	$R['titre']				= "Nouvelle presentation";
	$R['nom_generique']		= "Nouvelle presentation";
	$R['desc']				= "";
	$R['defaut']			= "NO";
	$R['assignee_a']		= 0;
	$R['filtre']			= "";

	$R['name']				= &$R['nom'];
	$R['title']				= &$R['titre'];
	$R['generic_name']		= &$R['nom_generique'];
	$R['description']		= &$R['desc'];
	$R['default']			= &$R['defaut'];
	$R['assigned_to_theme']	= &$R['assignee_a'];
	$R['filter']			= &$R['filtre'];

	$R['cont_id']				= "";
	$R['ligne']					= "";
	$R['minimum_x']				= 128;
	$R['minimum_y']				= 128;
	$R['module_nom']				= "";
	$R['type_calcul']				= "STATIC";
	$R['position_x']				= 0;
	$R['position_y']				= 0;
	$R['dimenssion_x']				= 0;
	$R['dimenssion_y']				= 0;

	$R['ancre_dx10'] = "null";		$R['ancre_dy10'] = "null";
	$R['ancre_dx20'] = "null";		$R['ancre_dy20'] = "null";
	$R['ancre_dx30'] = "null";		$R['ancre_dy30'] = "null";

	$R['module_ancre_e1a']			= "";	$R['ancre_ex1a'] = "null";		$R['ancre_ey1a'] = "null";
	$R['module_ancre_e1b']			= "";	$R['ancre_ex1b'] = "null";		$R['ancre_ey1b'] = "null";
	$R['module_ancre_e1c']			= "";	$R['ancre_ex1c'] = "null";		$R['ancre_ey1c'] = "null";
	$R['module_ancre_e1d']			= "";	$R['ancre_ex1d'] = "null";		$R['ancre_ey1d'] = "null";
	$R['module_ancre_e1e']			= "";	$R['ancre_ex1e'] = "null";		$R['ancre_ey1e'] = "null";

	$R['module_ancre_e2a']			= "";	$R['ancre_ex2a'] = "null";		$R['ancre_ey2a'] = "null";
	$R['module_ancre_e2b']			= "";	$R['ancre_ex2b'] = "null";		$R['ancre_ey2b'] = "null";
	$R['module_ancre_e2c']			= "";	$R['ancre_ex2c'] = "null";		$R['ancre_ey2c'] = "null";
	$R['module_ancre_e2d']			= "";	$R['ancre_ex2d'] = "null";		$R['ancre_ey2d'] = "null";
	$R['module_ancre_e2e']			= "";	$R['ancre_ex2e'] = "null";		$R['ancre_ey2e'] = "null";

	$R['module_ancre_e3a']			= "";	$R['ancre_ex3a'] = "null";		$R['ancre_ey3a'] = "null";
	$R['module_ancre_e3b']			= "";	$R['ancre_ex3b'] = "null";		$R['ancre_ey3b'] = "null";
	$R['module_ancre_e3c']			= "";	$R['ancre_ex3c'] = "null";		$R['ancre_ey3c'] = "null";
	$R['module_ancre_e3d']			= "";	$R['ancre_ex3d'] = "null";		$R['ancre_ey3d'] = "null";
	$R['module_ancre_e3e']			= "";	$R['ancre_ex3e'] = "null";		$R['ancre_ey3e'] = "null";

	$R['espacement_bord_gauche']	= 8;
	$R['espacement_bord_droite']	= 8;
	$R['espacement_bord_haut']		= 8;
	$R['espacement_bord_bas']		= 8;
	$R['module_zindex']				= 0;

	$R['line']						= &$R['ligne'];
	$R['module_name']				= &$R['module_nom'];
	$R['calculus_type']				= &$R['type_calcul'];

	$R['module_anchor_e1a']			= &$R['module_ancre_e1a'];
	$R['anchor_ex1a']				= &$R['ancre_ex1a'];
	$R['anchor_ey1a']				= &$R['ancre_ey1a'];
	$R['module_anchor_e1b']			= &$R['module_ancre_e1b'];
	$R['anchor_ex1b']				= &$R['ancre_ex1b'];
	$R['anchor_ey1b']				= &$R['ancre_ey1b'];
	$R['module_anchor_e1c']			= &$R['module_ancre_e1c'];
	$R['anchor_ex1c']				= &$R['ancre_ex1c'];
	$R['anchor_ey1c']				= &$R['ancre_ey1c'];
	$R['module_anchor_e1d']			= &$R['module_ancre_e1d'];
	$R['anchor_ex1d']				= &$R['ancre_ex1d'];
	$R['anchor_ey1d']				= &$R['ancre_ey1d'];
	$R['module_anchor_e1e']			= &$R['module_ancre_e1e'];
	$R['anchor_ex1e']				= &$R['ancre_ex1e'];
	$R['anchor_ey1e']				= &$R['ancre_ey1e'];

	$R['module_anchor_e2a']			= &$R['module_ancre_e2a'];
	$R['anchor_ex2a']				= &$R['ancre_ex2a'];
	$R['anchor_ey2a']				= &$R['ancre_ey2a'];
	$R['module_anchor_e2b']			= &$R['module_ancre_e2b'];
	$R['anchor_ex2b']				= &$R['ancre_ex2b'];
	$R['anchor_ey2b']				= &$R['ancre_ey2b'];
	$R['module_anchor_e2c']			= &$R['module_ancre_e2c'];
	$R['anchor_ex2c']				= &$R['ancre_ex2c'];
	$R['anchor_ey2c']				= &$R['ancre_ey2c'];
	$R['module_anchor_e2d']			= &$R['module_ancre_e2d'];
	$R['anchor_ex2d']				= &$R['ancre_ex2d'];
	$R['anchor_ey2d']				= &$R['ancre_ey2d'];
	$R['module_anchor_e2e']			= &$R['module_ancre_e2e'];
	$R['anchor_ex2e']				= &$R['ancre_ex2e'];
	$R['anchor_ey2e']				= &$R['ancre_ey2e'];

	$R['module_anchor_e3a']			= &$R['module_ancre_e3a'];
	$R['anchor_ex3a']				= &$R['ancre_ex3a'];
	$R['anchor_ey3a']				= &$R['ancre_ey3a'];
	$R['module_anchor_e3b']			= &$R['module_ancre_e3b'];
	$R['anchor_ex3b']				= &$R['ancre_ex3b'];
	$R['anchor_ey3b']				= &$R['ancre_ey3b'];
	$R['module_anchor_e3c']			= &$R['module_ancre_e3c'];
	$R['anchor_ex3c']				= &$R['ancre_ex3c'];
	$R['anchor_ey3c']				= &$R['ancre_ey3c'];
	$R['module_anchor_e3d']			= &$R['module_ancre_e3d'];
	$R['anchor_ex3d']				= &$R['ancre_ex3d'];
	$R['anchor_ey3d']				= &$R['ancre_ey3d'];
	$R['module_anchor_e3e']			= &$R['module_ancre_e3e'];
	$R['anchor_ex3e']				= &$R['ancre_ex3e'];
	$R['anchor_ey3e']				= &$R['ancre_ey3e'];

	$R['anchor_dx10']				= &$R['ancre_dx10'];
	$R['anchor_dy10']				= &$R['ancre_dy10'];
	$R['anchor_dx20']				= &$R['ancre_dx20'];
	$R['anchor_dy20']				= &$R['ancre_dy20'];
	$R['anchor_dx30']				= &$R['ancre_dx30'];
	$R['anchor_dy30']				= &$R['ancre_dy30'];

	$R['spacing_border_left']		= &$R['espacement_bord_gauche'];
	$R['spacing_border_right']		= &$R['espacement_bord_droite'];
	$R['spacing_border_top']		= &$R['espacement_bord_haut'];
	$R['spacing_border_bottom']		= &$R['espacement_bord_bas'];

	$R['dans_la_presentation']		= &$R['nom'];
	$R['to_layout']					= &$R['nom'];

	reset ( $_REQUEST['liste_colonne']['presentation_contenu_reference'] );
	foreach ( $_REQUEST['liste_colonne']['presentation_contenu_reference'] as $A ) { $R['pres_'.$A] = &$R[$A];	}
}

function chargement_valeurs_presentation () {
	global $SQL_tab , $SQL_tab_abrege;
	$R = &$_REQUEST['M_PRESNT'];

	$tl_['eng']['log_init'] = "Loading dysplay datas";
	$tl_['fra']['log_init'] = "Chargement valeurs de la presentation";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$_REQUEST['sru_ERR']  = &$R['ERR'];
	systeme_requete_unifiee ( 2 , "MD_rdp" , $R['nom'] , 0 , "CVP_0001" , $R['id'] );

	if ( $R['ERR'] != 1 ) {
		$dbquery = requete_sql($_REQUEST['sql_initiateur'] ,"
		SELECT * 
		FROM ".$SQL_tab_abrege['presentation']." 
		WHERE pres_id = '".$R['id']."' 
		;");
		while ($dbp = fetch_array_sql($dbquery)) { 
			$R['id']				= $dbp['pres_id'];
			$R['nom']				= $dbp['pres_nom'];
			$R['titre']				= $dbp['pres_titre'];
			$R['nom_generique']		= $dbp['pres_nom_generique'];
			$R['desc']				= $dbp['pres_desc'];
		}
	}
}

?>
