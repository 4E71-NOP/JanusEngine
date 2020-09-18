<?php 


/*
"execute" => function (&$a),
"convert" => array(),
"nextId" => array(),
"timeCreate" => array(),
"timeConvert" => array(),
"columns" => array(),
*/
//--------------------------------------------------------------------------------
//	Add
//--------------------------------------------------------------------------------

self::$PreRequisiteTable['add']['article'] = array (
		"execute" => function (&$a) {
			if ( strlen($a['params']['creator']) == 0 ) { $a['params']['creator'] = $a['Initiator']['db_login']; }
			if ( strlen($a['params']['validator']) == 0 ) { $a['params']['validator'] = $a['Initiator']['db_login'];}
		},
		
		"convert" => array(
				array("v" => "validation_state",		"s" => "article")
		),
		"nextId" => array (
				array ("table" => "article",		"column" => "arti_id",			"target" => "id"),
				array ("table" => "group_website",	"column" => "group_website_id",	"target" => "group_website_id")
		),
		"timeCreate" => array (
				"creation_date",
		),
		"columns" => array(
				array ( "v" => "id",					"t" => "arti_id"),
				array ( "v" => "ref",					"t" => "arti_ref"),
				array ( "v" => "deadline_id",			"t" => "arti_deadline"),
				array ( "v" => "name",					"t" => "arti_nom"),
				array ( "v" => "desc",					"t" => "arti_desc"),
				array ( "v" => "title",					"t" => "arti_titre"),
				array ( "v" => "subtitle",				"t" => "arti_sous_titre"),
				array ( "v" => "page",					"t" => "arti_page"),
				array ( "v" => "layout_generic_name",	"t" => "pres_nom_generique"),
				array ( "v" => "config_id",				"t" => "config_id"),
				array ( "v" => "user_id_creator",		"t" => "arti_creation_createur"),
				array ( "v" => "creation_date",			"t" => "arti_creation_date"),
				array ( "v" => "user_id_validator",		"t" => "arti_validation_validateur"),
				array ( "v" => "validation_date",		"t" => "arti_validation_date"),
				array ( "v" => "validation_state",		"t" => "arti_validation_etat"),
				array ( "v" => "parution_date",			"t" => "arti_parution_date"),
				array ( "v" => "docu_id",				"t" => "docu_id"),
				array ( "v" => "ws_id",				"t" => "ws_id"),
		),
);

self::$PreRequisiteTable['add']['category'] = array (
		"convert" => array(
				array("v" => "type",		"s" => "category"),
				array("v" => "state",		"s" => "category"),
				array("v" => "role",		"s" => "category"),
				array("v" => "first_doc",	"s" => "category"),
		),
		"nextId" => array (
				array ("table" => "categorie",				"column" => "cate_id",			"target" => "id"),
		),
		"columns" => array(
				array ( "v" => "id",				"t" => "cate_id"),
				array ( "v" => "name",				"t" => "cate_nom"),
				array ( "v" => "title",				"t" => "cate_titre"),
				array ( "v" => "desc",				"t" => "cate_desc"),
				array ( "v" => "type",				"t" => "cate_type"),
				array ( "v" => "ws_id",			"t" => "ws_id"),
				array ( "v" => "lang_id",			"t" => "cate_lang"),
				array ( "v" => "deadline_id",		"t" => "deadline_id"),
				array ( "v" => "state",				"t" => "cate_etat"),
				array ( "v" => "parent_id",			"t" => "cate_parent"),
				array ( "v" => "position",			"t" => "cate_position"),
				array ( "v" => "group_id",			"t" => "group_id"),
				array ( "v" => "last_modif",		"t" => "derniere_modif"),
				array ( "v" => "role",				"t" => "cate_role"),
				array ( "v" => "first_doc",			"t" => "cate_doc_premier"),
				array ( "v" => "article",			"t" => "arti_ref"),
		),
);

self::$PreRequisiteTable['add']['deadline'] = array (
		"convert" => array(
				array("v" => "state",				"s" => "deadline"),
				
		),
		"nextId" => array (
				array ("table" => "deadline",		"column" => "deadline_id",			"target" => "id"),
		),
		"columns" => array(
				array ( "v" => "id",				"t" => "deadline_id"),
				array ( "v" => "name",				"t" => "deadline_name"),
				array ( "v" => "title",				"t" => "deadline_title"),
				array ( "v" => "state",				"t" => "deadline_state"),
				array ( "v" => "date_creation",		"t" => "deadline_creation_date"),
				array ( "v" => "date_expiration",	"t" => "deadline_end_date"),
				array ( "v" => "user_id",			"t" => "user_id"),
				array ( "v" => "ws_id",			"t" => "ws_id"),
		),
);


self::$PreRequisiteTable['add']['decoration'] = array (
		"convert" => array(
				array("v" => "state",			"s" => "decoration"),
				array("v" => "type",			"s" => "decoration"),
				array("v" => "affiche_icones",	"s" => "decoration"),
				array("v" => "dock_cible",		"s" => "decoration"),
				array("v" => "in11_e",			"s" => "decoration"),
				array("v" => "in12_e",			"s" => "decoration"),
				array("v" => "in13_e",			"s" => "decoration"),
				array("v" => "in14_e",			"s" => "decoration"),
				array("v" => "in15_e",			"s" => "decoration"),
				array("v" => "in21_e",			"s" => "decoration"),
				array("v" => "in25_e",			"s" => "decoration"),
				array("v" => "in31_e",			"s" => "decoration"),
				array("v" => "in35_e",			"s" => "decoration"),
				array("v" => "in41_e",			"s" => "decoration"),
				array("v" => "in45_e",			"s" => "decoration"),
				array("v" => "in51_e",			"s" => "decoration"),
				array("v" => "in52_e",			"s" => "decoration"),
				array("v" => "in53_e",			"s" => "decoration"),
				array("v" => "in54_e",			"s" => "decoration"),
				array("v" => "in55_e",			"s" => "decoration"),
		),
		"nextId" => array (
				array ("table" => "decoration",				"column" => "deco_id",			"target" => "id"),
				array ("table" => "decoration",				"column" => "deco_ref_id",		"target" => "deco_ref_id"),
				array ("table" => "deco_10_menu",			"column" => "deco_nligne",		"target" => "10_id"),
				array ("table" => "deco_20_caligraphe",		"column" => "deco_nligne",		"target" => "20_id"),
				array ("table" => "deco_30_1_div",			"column" => "deco_nligne",		"target" => "30_id"),
				array ("table" => "deco_40_elegance",		"column" => "deco_nligne",		"target" => "40_id"),
				array ("table" => "deco_50_exquise",		"column" => "deco_nligne",		"target" => "50_id"),
				array ("table" => "deco_60_elysion",		"column" => "deco_nligne",		"target" => "60_id"),
		),
		"columns" => array(
				array ( "v" => "deco_ref_id",		"t" => "deco_ref_id"),
				array ( "v" => "name",				"t" => "deco_nom"),
				array ( "v" => "state",				"t" => "deco_etat"),
				array ( "v" => "type",				"t" => "deco_type"),
				array ( "v" => "id",				"t" => "deco_id"),
		),
);

self::$PreRequisiteTable['add']['document_config'] = array (
		"convert" => array(
				array("v" => "menu_type",				"s" => "document_config"),
				array("v" => "menu_style",				"s" => "document_config"),
				array("v" => "menu_float_position",		"s" => "document_config"),
				array("v" => "menu_occurence",			"s" => "document_config"),
				array("v" => "show_info_parution",		"s" => "document_config"),
				array("v" => "show_info_modification",	"s" => "document_config"),
		),
		"nextId" => array (
				array ("table" => "article_config",		"column" => "config_id",			"target" => "id"),
		),
		"columns" => array(
				array ( "v" => "id",						"t" => "config_id"),
				array ( "v" => "name",						"t" => "config_nom"),
				array ( "v" => "menu_type",					"t" => "config_menu_type"),
				array ( "v" => "menu_style",				"t" => "config_menu_style"),
				array ( "v" => "menu_float_position",		"t" => "config_menu_float_position"),
				array ( "v" => "menu_float_size_x",			"t" => "config_menu_float_taille_x"),
				array ( "v" => "menu_float_size_y",			"t" => "config_menu_float_taille_y"),
				array ( "v" => "menu_occurence",			"t" => "config_menu_occurence"),
				array ( "v" => "show_info_parution",		"t" => "config_montre_info_parution"),
				array ( "v" => "show_info_modification",	"t" => "config_montre_info_modification"),
				array ( "v" => "ws_id",					"t" => "ws_id"),
		),
);

self::$PreRequisiteTable['add']['document'] = array (
		"execute" => function (&$a) {
			if ( strlen($a['params']['creator']) == 0 ) { $a['params']['creator'] = $a['Initiator']['db_login']; }
			if ( strlen($a['params']['validator']) == 0 ) { $a['params']['validator'] = $a['Initiator']['db_login'];}
		},
		"convert" => array(
				array("v" => "type",			"s" => "document"),
				array("v" => "validation",		"s" => "document"),
				array("v" => "modificiation",	"s" => "document"),
		),
		"nextId" => array (
				array ("table" => "document",				"column" => "docu_id",			"target" => "id"),
		),
		"timeCreate" => array (
				"creation_date",
		),
		"columns" => array(
				array ( "v" => "id",				"t" => "docu_id"),
				array ( "v" => "name",				"t" => "docu_nom"),
				array ( "v" => "type",				"t" => "docu_type"),
				array ( "v" => "origin",			"t" => "docu_origine"),
				array ( "v" => "creator_user_id",	"t" => "docu_createur"),
				array ( "v" => "creation_date",		"t" => "docu_creation_date"),
				array ( "v" => "validation",		"t" => "docu_correction"),
				array ( "v" => "validator_user_id",	"t" => "docu_correcteur"),
				array ( "v" => "validation_date",	"t" => "docu_correction_date"),
				array ( "v" => "content",			"t" => "docu_cont"),
		),
);


self::$PreRequisiteTable['add']['group'] = array (
		"convert" => array(
				array("v" => "tag",			"s" => "group"),
		),
		"nextId" => array (
				array ("table" => "groupe",			"column" => "group_id",		"target" => "id"),
				array ("table" => "group_website",	"column" => "group_website_id",	"target" => "group_webws_id"),
		),
		"timeCreate" => array (
				"creation_date",
		),
		"columns" => array(
				array ( "v" => "id",			"t" => "group_id"),
				array ( "v" => "name",			"t" => "groupe_nom"),
				array ( "v" => "groupe_parent",	"t" => "groupe_parent"),
				array ( "v" => "tag",			"t" => "groupe_tag"),
				array ( "v" => "title",			"t" => "groupe_titre"),
				array ( "v" => "file",			"t" => "groupe_fichier"),
				array ( "v" => "desc",			"t" => "groupe_desc"),
		),
);


self::$PreRequisiteTable['add']['keyword'] = array (
		"convert" => array(
				array("v" => "state",			"s" => "keyword"),
				array("v" => "type",			"s" => "keyword"),
		),
		"nextId" => array (
				array ("table" => "mot_cle",			"column" => "mc_id",		"target" => "id"),
		),
		"columns" => array(
				array ( "v" => "id",						"t" => "mc_id"),
				array ( "v" => "name",						"t" => "mc_nom"),
				array ( "v" => "state",						"t" => "mc_etat"),
				array ( "v" => "arti_id",					"t" => "arti_id"),	
				array ( "v" => "site",						"t" => "ws_id"), 	
				array ( "v" => "string",					"t" => "mc_chaine"),
				array ( "v" => "count",						"t" => "mc_compteur"),	
				array ( "v" => "type",						"t" => "mc_type"),	
				array ( "v" => "data", 						"t" => "mc_donnee"),	
		),				
);


self::$PreRequisiteTable['add']['layout'] = array (
		"convert" => array(),
		"nextId" => array (
				array ("table" => "presentation",		"column" => "pres_id",				"target" => "id"),
		),
		"columns" => array(
				array ( "v" => "id",						"t" => "pres_id"),
				array ( "v" => "name",						"t" => "pres_nom"),
				array ( "v" => "title",						"t" => "pres_titre"),
				array ( "v" => "generic_name",				"t" => "pres_nom_generique"),	
				array ( "v" => "desc",						"t" => "pres_desc"), 	
		),				
);


self::$PreRequisiteTable['add']['layout_content'] = array (
		"convert" => array(
				array("v" => "default",				"s" => "layout_content"),
				array("v" => "type",				"s" => "layout_content"),
				array("v" => "calculation_type",	"s" => "layout_content"),
				array("v" => "anchor_ex1a",			"s" => "layout_content"),
				array("v" => "anchor_ey1a",			"s" => "layout_content"),
				array("v" => "anchor_ex1b",			"s" => "layout_content"),
				array("v" => "anchor_ey1b",			"s" => "layout_content"),
				array("v" => "anchor_ex1c",			"s" => "layout_content"),
				array("v" => "anchor_ey1c",			"s" => "layout_content"),
				array("v" => "anchor_ex1d",			"s" => "layout_content"),
				array("v" => "anchor_ey1d",			"s" => "layout_content"),
				array("v" => "anchor_ex1e",			"s" => "layout_content"),
				array("v" => "anchor_ey1e",			"s" => "layout_content"),
				array("v" => "anchor_ex2a",			"s" => "layout_content"),
				array("v" => "anchor_ey2a",			"s" => "layout_content"),
				array("v" => "anchor_ex2b",			"s" => "layout_content"),
				array("v" => "anchor_ey2b",			"s" => "layout_content"),
				array("v" => "anchor_ex2c",			"s" => "layout_content"),
				array("v" => "anchor_ey2c",			"s" => "layout_content"),
				array("v" => "anchor_ex2d",			"s" => "layout_content"),
				array("v" => "anchor_ey2d",			"s" => "layout_content"),
				array("v" => "anchor_ex2e",			"s" => "layout_content"),
				array("v" => "anchor_ey2e",			"s" => "layout_content"),
				array("v" => "anchor_ex3a",			"s" => "layout_content"),
				array("v" => "anchor_ey3a",			"s" => "layout_content"),
				array("v" => "anchor_ex3b",			"s" => "layout_content"),
				array("v" => "anchor_ey3b",			"s" => "layout_content"),
				array("v" => "anchor_ex3c",			"s" => "layout_content"),
				array("v" => "anchor_ey3c",			"s" => "layout_content"),
				array("v" => "anchor_ex3d",			"s" => "layout_content"),
				array("v" => "anchor_ey3d",			"s" => "layout_content"),
				array("v" => "anchor_ex3e",			"s" => "layout_content"),
				array("v" => "anchor_ey3e",			"s" => "layout_content"),
				array("v" => "anchor_dx10",			"s" => "layout_content"),
				array("v" => "anchor_dy10",			"s" => "layout_content"),
				array("v" => "anchor_dx20",			"s" => "layout_content"),
				array("v" => "anchor_dy20",			"s" => "layout_content"),
				array("v" => "anchor_dx30",			"s" => "layout_content"),
				array("v" => "anchor_dy30",			"s" => "layout_content"),
		),
		"nextId" => array (
				array ("table" => "presentation_contenu",	"column" => "pres_cont_id",		"target" => "id"),
		),
		"columns" => array(
				array ( "v" => "id",					"t" => "pres_cont_id"),
				array ( "v" => "layout_id",				"t" => "pres_id"),
				array ( "v" => "line",					"t" => "pres_ligne"),
				array ( "v" => "minimum_x",				"t" => "pres_minimum_x"),
				array ( "v" => "minimum_y",				"t" => "pres_minimum_y"),
				array ( "v" => "module",				"t" => "pres_module_nom"),
				array ( "v" => "calculation_type",		"t" => "pres_type_calcul"),
				array ( "v" => "position_x",			"t" => "pres_position_x"),
				array ( "v" => "position_y",			"t" => "pres_position_y"),
				array ( "v" => "dimenssion_x",			"t" => "pres_dimenssion_x"),
				array ( "v" => "dimenssion_y",			"t" => "pres_dimenssion_y"),
				array ( "v" => "module_anchor_e1a",		"t" => "pres_module_ancre_e1a"),
				array ( "v" => "module_anchor_e1b",		"t" => "pres_module_ancre_e1b"),
				array ( "v" => "module_anchor_e1c",		"t" => "pres_module_ancre_e1c"),
				array ( "v" => "module_anchor_e1d",		"t" => "pres_module_ancre_e1d"),
				array ( "v" => "module_anchor_e1e",		"t" => "pres_module_ancre_e1e"),
				array ( "v" => "module_anchor_e2a",		"t" => "pres_module_ancre_e2a"),
				array ( "v" => "module_anchor_e2b",		"t" => "pres_module_ancre_e2b"),
				array ( "v" => "module_anchor_e2c",		"t" => "pres_module_ancre_e2c"),
				array ( "v" => "module_anchor_e2d",		"t" => "pres_module_ancre_e2d"),
				array ( "v" => "module_anchor_e2e",		"t" => "pres_module_ancre_e2e"),
				array ( "v" => "module_anchor_e3a",		"t" => "pres_module_ancre_e3a"),
				array ( "v" => "module_anchor_e3b",		"t" => "pres_module_ancre_e3b"),
				array ( "v" => "module_anchor_e3c",		"t" => "pres_module_ancre_e3c"),
				array ( "v" => "module_anchor_e3d",		"t" => "pres_module_ancre_e3d"),
				array ( "v" => "module_anchor_e3e",		"t" => "pres_module_ancre_e3e"),
				array ( "v" => "anchor_ex1a",			"t" => "pres_ancre_ex1a"),
				array ( "v" => "anchor_ey1a",			"t" => "pres_ancre_ey1a"),
				array ( "v" => "anchor_ex1b",			"t" => "pres_ancre_ex1b"),
				array ( "v" => "anchor_ey1b",			"t" => "pres_ancre_ey1b"),
				array ( "v" => "anchor_ex1c",			"t" => "pres_ancre_ex1c"),
				array ( "v" => "anchor_ey1c",			"t" => "pres_ancre_ey1c"),
				array ( "v" => "anchor_ex1d",			"t" => "pres_ancre_ex1d"),
				array ( "v" => "anchor_ey1d",			"t" => "pres_ancre_ey1d"),
				array ( "v" => "anchor_ex1e",			"t" => "pres_ancre_ex1e"),
				array ( "v" => "anchor_ey1e",			"t" => "pres_ancre_ey1e"),
				array ( "v" => "anchor_ex2a",			"t" => "pres_ancre_ex2a"),
				array ( "v" => "anchor_ey2a",			"t" => "pres_ancre_ey2a"),
				array ( "v" => "anchor_ex2b",			"t" => "pres_ancre_ex2b"),
				array ( "v" => "anchor_ey2b",			"t" => "pres_ancre_ey2b"),
				array ( "v" => "anchor_ex2c",			"t" => "pres_ancre_ex2c"),
				array ( "v" => "anchor_ey2c",			"t" => "pres_ancre_ey2c"),
				array ( "v" => "anchor_ex2d",			"t" => "pres_ancre_ex2d"),
				array ( "v" => "anchor_ey2d",			"t" => "pres_ancre_ey2d"),
				array ( "v" => "anchor_ex2e",			"t" => "pres_ancre_ex2e"),
				array ( "v" => "anchor_ey2e",			"t" => "pres_ancre_ey2e"),
				array ( "v" => "anchor_ex3a",			"t" => "pres_ancre_ex3a"),
				array ( "v" => "anchor_ey3a",			"t" => "pres_ancre_ey3a"),
				array ( "v" => "anchor_ex3b",			"t" => "pres_ancre_ex3b"),
				array ( "v" => "anchor_ey3b",			"t" => "pres_ancre_ey3b"),
				array ( "v" => "anchor_ex3c",			"t" => "pres_ancre_ex3c"),
				array ( "v" => "anchor_ey3c",			"t" => "pres_ancre_ey3c"),
				array ( "v" => "anchor_ex3d",			"t" => "pres_ancre_ex3d"),
				array ( "v" => "anchor_ey3d",			"t" => "pres_ancre_ey3d"),
				array ( "v" => "anchor_ex3e",			"t" => "pres_ancre_ex3e"),
				array ( "v" => "anchor_ey3e",			"t" => "pres_ancre_ey3e"),
				array ( "v" => "anchor_dx10",			"t" => "pres_ancre_dx10"),
				array ( "v" => "anchor_dy10",			"t" => "pres_ancre_dy10"),
				array ( "v" => "anchor_dx20",			"t" => "pres_ancre_dx20"),
				array ( "v" => "anchor_dy20",			"t" => "pres_ancre_dy20"),
				array ( "v" => "anchor_dx30",			"t" => "pres_ancre_dx30"),
				array ( "v" => "anchor_dy30",			"t" => "pres_ancre_dy30"),
				array ( "v" => "spacing_border_left",	"t" => "pres_espacement_bord_gauche"),
				array ( "v" => "spacing_border_right",	"t" => "pres_espacement_bord_droite"),
				array ( "v" => "spacing_border_top",	"t" => "pres_espacement_bord_haut"),
				array ( "v" => "spacing_border_bottom",	"t" => "pres_espacement_bord_bas"),
				array ( "v" => "module_zindex",			"t" => "pres_module_zindex"),
		),
);


self::$PreRequisiteTable['add']['module'] = array (
		"convert" => array(
				array("v" => "deco",			"s" => "module"),
				array("v" => "state",			"s" => "module"),
				array("v" => "adm_control",		"s" => "module"),
				array("v" => "execution",		"s" => "module"),
		),
		"nextId" => array (
				array ("table" => "module",			"column" => "module_id",		"target" => "id"),
				array ("table" => "module_website",	"column" => "module_website_id",	"target" => "module_website_id"),
		),
		"columns" => array(
				array ( "v" => "id",						"t" => "module_id"),
				array ( "v" => "name",						"t" => "module_nom"),
				array ( "v" => "classname",					"t" => "module_classname"),
				array ( "v" => "deco",						"t" => "module_deco"),
				array ( "v" => "deco_nbr",					"t" => "module_deco_nbr"),
				array ( "v" => "deco_txt_default",			"t" => "module_deco_txt_defaut"),
				array ( "v" => "title",						"t" => "module_titre"),
				array ( "v" => "directory",					"t" => "module_directory"),
				array ( "v" => "file",						"t" => "module_fichier"),
				array ( "v" => "desc",						"t" => "module_desc"),
				array ( "v" => "group_allowed_to_see_id",	"t" => "module_groupe_pour_voir"),
				array ( "v" => "group_allowed_to_use_id",	"t" => "module_groupe_pour_utiliser"),
				array ( "v" => "adm_control",				"t" => "module_adm_control"),
				array ( "v" => "container_name",			"t" => "module_conteneur_nom"),
				array ( "v" => "execution",					"t" => "module_execution"),
		),
);



self::$PreRequisiteTable['add']['tag'] = array (
		"convert" => array(),
		"nextId" => array (
				array ("table" => "tag",	"column" => "tag_id",		"target" => "id"),
		),
		"columns" => array(
				array ( "v" => "id",			"t" => "tag_id"),
				array ( "v" => "name",			"t" => "tag_name"),
				array ( "v" => "html",			"t" => "tag_html"),
				array ( "v" => "site",			"t" => "ws_id"),

		),
);


self::$PreRequisiteTable['add']['theme'] = array (
		"convert" => array(
				array("v" => "state",				"s" => "theme"),
				array("v" => "admctrl_position",	"s" => "theme"),
		),
		"nextId" => array (
				array ("table" => "theme_descriptor",	"column" => "theme_id",			"target" => "id"),
				array ("table" => "theme_website",			"column" => "theme_website_id",	"target" => "theme_website_id"),
		),
		"columns" => array(
				array ( "v" => "id",						"t" => "theme_id"),
				array ( "v" => "name",						"t" => "theme_name"),
				array ( "v" => "directory",					"t" => "theme_directory"),
				array ( "v" => "title",						"t" => "theme_title"),
				array ( "v" => "desc",						"t" => "theme_desc"),
				array ( "v" => "date",						"t" => "theme_date"),
				array ( "v" => "stylesheet_1",				"t" => "theme_stylesheet_1"),
				array ( "v" => "stylesheet_2",				"t" => "theme_stylesheet_2"),
				array ( "v" => "stylesheet_3",				"t" => "theme_stylesheet_3"),
				array ( "v" => "stylesheet_4",				"t" => "theme_stylesheet_4"),
				array ( "v" => "stylesheet_5",				"t" => "theme_stylesheet_5"),
				array ( "v" => "bg",						"t" => "theme_bg"),
				array ( "v" => "bg_repeat", 				"t" => "theme_bg_repeat"),
				array ( "v" => "bg_color", 					"t" => "theme_bg_color"),
				array ( "v" => "logo",						"t" => "theme_logo"),
				array ( "v" => "banner",					"t" => "theme_banner"),
				array ( "v" => "divinitial_bg",				"t" => "theme_divinitial_bg"),
				array ( "v" => "divinitial_repeat",			"t" => "theme_divinitial_repeat"),
				array ( "v" => "divinitial_dx",				"t" => "theme_divinitial_dx"),
				array ( "v" => "divinitial_dy",				"t" => "theme_divinitial_dy"),
				array ( "v" => "admctrl_panel_bg",			"t" => "theme_admctrl_panel_bg"),
				array ( "v" => "admctrl_switch_bg",			"t" => "theme_admctrl_switch_bg"),
				array ( "v" => "admctrl_size_x",			"t" => "theme_admctrl_size_x"),
				array ( "v" => "admctrl_size_y",			"t" => "theme_admctrl_size_y"),
				array ( "v" => "admctrl_position",			"t" => "theme_admctrl_position"),
				array ( "v" => "color_gradient_start",		"t" => "theme_gradient_start_color"),
				array ( "v" => "color_gradient_middle",		"t" => "theme_gradient_middle_color"),
				array ( "v" => "color_gradient_end",		"t" => "theme_gradient_end_color"),

				array ( "v" => "block_01_name",		"t" => "theme_block_01_name"),
				array ( "v" => "block_02_name",		"t" => "theme_block_02_name"),
				array ( "v" => "block_03_name",		"t" => "theme_block_03_name"),
				array ( "v" => "block_04_name",		"t" => "theme_block_04_name"),
				array ( "v" => "block_05_name",		"t" => "theme_block_05_name"),
				array ( "v" => "block_06_name",		"t" => "theme_block_06_name"),
				array ( "v" => "block_07_name",		"t" => "theme_block_07_name"),
				array ( "v" => "block_08_name",		"t" => "theme_block_08_name"),
				array ( "v" => "block_09_name",		"t" => "theme_block_09_name"),
				array ( "v" => "block_10_name",		"t" => "theme_block_10_name"),
				array ( "v" => "block_11_name",		"t" => "theme_block_11_name"),
				array ( "v" => "block_12_name",		"t" => "theme_block_12_name"),
				array ( "v" => "block_13_name",		"t" => "theme_block_13_name"),
				array ( "v" => "block_14_name",		"t" => "theme_block_14_name"),
				array ( "v" => "block_15_name",		"t" => "theme_block_15_name"),
				array ( "v" => "block_16_name",		"t" => "theme_block_16_name"),
				array ( "v" => "block_17_name",		"t" => "theme_block_17_name"),
				array ( "v" => "block_18_name",		"t" => "theme_block_18_name"),
				array ( "v" => "block_19_name",		"t" => "theme_block_19_name"),
				array ( "v" => "block_20_name",		"t" => "theme_block_20_name"),
				array ( "v" => "block_21_name",		"t" => "theme_block_21_name"),
				array ( "v" => "block_22_name",		"t" => "theme_block_22_name"),
				array ( "v" => "block_23_name",		"t" => "theme_block_23_name"),
				array ( "v" => "block_24_name",		"t" => "theme_block_24_name"),
				array ( "v" => "block_25_name",		"t" => "theme_block_25_name"),
				array ( "v" => "block_26_name",		"t" => "theme_block_26_name"),
				array ( "v" => "block_27_name",		"t" => "theme_block_27_name"),
				array ( "v" => "block_28_name",		"t" => "theme_block_28_name"),
				array ( "v" => "block_29_name",		"t" => "theme_block_29_name"),
				array ( "v" => "block_30_name",		"t" => "theme_block_30_name"),
		
				array ( "v" => "block_01_text",		"t" => "theme_block_01_text"),
				array ( "v" => "block_02_text",		"t" => "theme_block_02_text"),
				array ( "v" => "block_03_text",		"t" => "theme_block_03_text"),
				array ( "v" => "block_04_text",		"t" => "theme_block_04_text"),
				array ( "v" => "block_05_text",		"t" => "theme_block_05_text"),
				array ( "v" => "block_06_text",		"t" => "theme_block_06_text"),
				array ( "v" => "block_07_text",		"t" => "theme_block_07_text"),
				array ( "v" => "block_08_text",		"t" => "theme_block_08_text"),
				array ( "v" => "block_09_text",		"t" => "theme_block_09_text"),
				array ( "v" => "block_10_text",		"t" => "theme_block_10_text"),
				array ( "v" => "block_11_text",		"t" => "theme_block_11_text"),
				array ( "v" => "block_12_text",		"t" => "theme_block_12_text"),
				array ( "v" => "block_13_text",		"t" => "theme_block_13_text"),
				array ( "v" => "block_14_text",		"t" => "theme_block_14_text"),
				array ( "v" => "block_15_text",		"t" => "theme_block_15_text"),
				array ( "v" => "block_16_text",		"t" => "theme_block_16_text"),
				array ( "v" => "block_17_text",		"t" => "theme_block_17_text"),
				array ( "v" => "block_18_text",		"t" => "theme_block_18_text"),
				array ( "v" => "block_19_text",		"t" => "theme_block_19_text"),
				array ( "v" => "block_20_text",		"t" => "theme_block_20_text"),
				array ( "v" => "block_21_text",		"t" => "theme_block_21_text"),
				array ( "v" => "block_22_text",		"t" => "theme_block_22_text"),
				array ( "v" => "block_23_text",		"t" => "theme_block_23_text"),
				array ( "v" => "block_24_text",		"t" => "theme_block_24_text"),
				array ( "v" => "block_25_text",		"t" => "theme_block_25_text"),
				array ( "v" => "block_26_text",		"t" => "theme_block_26_text"),
				array ( "v" => "block_27_text",		"t" => "theme_block_27_text"),
				array ( "v" => "block_28_text",		"t" => "theme_block_28_text"),
				array ( "v" => "block_29_text",		"t" => "theme_block_29_text"),
				array ( "v" => "block_30_text",		"t" => "theme_block_30_text"),
		
				array ( "v" => "block_00_menu",		"t" => "theme_block_00_menu"),
				array ( "v" => "block_01_menu",		"t" => "theme_block_01_menu"),
				array ( "v" => "block_02_menu",		"t" => "theme_block_02_menu"),
				array ( "v" => "block_03_menu",		"t" => "theme_block_03_menu"),
				array ( "v" => "block_04_menu",		"t" => "theme_block_04_menu"),
				array ( "v" => "block_05_menu",		"t" => "theme_block_05_menu"),
				array ( "v" => "block_06_menu",		"t" => "theme_block_06_menu"),
				array ( "v" => "block_07_menu",		"t" => "theme_block_07_menu"),
				array ( "v" => "block_08_menu",		"t" => "theme_block_08_menu"),
				array ( "v" => "block_09_menu",		"t" => "theme_block_09_menu"),

		),
);

self::$PreRequisiteTable['add']['translation'] = array (
		"nextId" => array (
				array ("table" => "i18n",			"column" => "i18n_id",				"target" => "id"),
		),
		"columns" => array(
				array("v" => "id",									"t"	=>	"i18n_id"),
				array("v" => "lang_id",								"t"	=>	"lang_id"),
				array("v" => "package",								"t"	=>	"i18n_package"),
				array("v" => "name",								"t"	=>	"i18n_name"),
				array("v" => "text",								"t"	=>	"i18n_text"),
		),
);

self::$PreRequisiteTable['add']['user'] = array (
		"execute" => function (&$a) {
			if ( $a['params']['name'] == "*user_install*" ) { $a['params']['name'] = $a['params']['login'] = $a['params']['perso_name'] = $a['Initiator']['db_login']; }
			if ( $a['params']['password'] == "*user_install*" ) { $a['params']['password'] = hash("sha512",stripslashes($a['Initiator']['db_pass']));}
			if ( $a['params']['password'] == "anonymous" ) { $a['params']['password'] = hash("sha512",stripslashes($a['params']['password']));}
			if ( $a['params']['password'] == "*standard_user_password*" ) { 
				$CMObj = ConfigurationManagement::getInstance();
				$a['params']['password'] = hash("sha512",stripslashes($CMObj->getConfigurationSubEntry('db', 'standard_user_password'))); 
			}
			if ( strlen($a['params']['login'] == 0 )){ $a['params']['login'] = $a['params']['name'];}
// 			$a['params']['password'] = hash("sha512",stripslashes($a['params']['password']));
		},
		"convert" => array(
				array("v" => "status",							"s" => "user"),
				array("v" => "role_function",					"s" => "user"),
				array("v" => "forum_access",					"s" => "user"),
				array("v" => "pref_theme",						"s" => "user"),
				array("v" => "pref_newsletter"	,				"s" => "user"),
				array("v" => "pref_show_email"	,				"s" => "user"),
				array("v" => "pref_show_status_online",			"s" => "user"),
				array("v" => "pref_notification_reponse_forum",	"s" => "user"),
				array("v" => "pref_notification_new_pm",		"s" => "user"),
				array("v" => "pref_allow_bbcode",				"s" => "user"),
				array("v" => "pref_allow_html",					"s" => "user"),
				array("v" => "pref_allow_smilies",				"s" => "user"),
		),
		"nextId" => array (
				array ("table" => "user",			"column" => "user_id",				"target" => "id"),
				array ("table" => "groupe_user",	"column" => "groupe_user_id",		"target" => "groupe_user_id"),
		),
		"columns" => array(
				array("v" => "id",									"t"	=>	"user_id"),
				array("v" => "name",								"t"	=>	"user_nom"),
				array("v" => "login",								"t"	=>	"user_login"),
				array("v" => "password",							"t"	=>	"user_password"),
				array("v" => "date_inscription",					"t"	=>	"user_date_inscription"),
				array("v" => "status",								"t"	=>	"user_status"),
				array("v" => "role_function",						"t"	=>	"user_role_fonction"),
				array("v" => "forum_access",						"t"	=>	"user_droit_forum"),
				array("v" => "email",								"t"	=>	"user_email"),
				array("v" => "msn",									"t"	=>	"user_msn"),
				array("v" => "aim",									"t"	=>	"user_aim"),
				array("v" => "icq",									"t"	=>	"user_icq"),
				array("v" => "yim",									"t"	=>	"user_yim"),
				array("v" => "website",								"t"	=>	"user_website"),
				array("v" => "perso_name",							"t"	=>	"user_perso_nom"),
				array("v" => "perso_copuntry",						"t"	=>	"user_perso_pays"),
				array("v" => "perso_town",							"t"	=>	"user_perso_ville"),
				array("v" => "perso_occupation",					"t"	=>	"user_perso_occupation"),
				array("v" => "perso_interest",						"t"	=>	"user_perso_interet"),
				array("v" => "last_visit",							"t"	=>	"user_derniere_visite"),
				array("v" => "last_ip",								"t"	=>	"user_derniere_ip"),
				array("v" => "timezone",							"t"	=>	"user_timezone"),
				array("v" => "lang",								"t"	=>	"user_lang"),
				array("v" => "pref_theme_id",						"t"	=>	"user_pref_theme"),
				array("v" => "pref_newsletter",						"t"	=>	"user_pref_newsletter"),
				array("v" => "pref_show_email",						"t"	=>	"user_pref_montre_email"),
				array("v" => "pref_show_status_online",				"t"	=>	"user_pref_montre_status_online"),
				array("v" => "pref_notification_reponse_forum",		"t"	=>	"user_pref_notification_reponse_forum"),
				array("v" => "pref_notification_new_pm",			"t"	=>	"user_pref_notification_nouveau_pm"),
				array("v" => "pref_allow_bbcode",					"t"	=>	"user_pref_autorise_bbcode"),
				array("v" => "pref_allow_html",						"t"	=>	"user_pref_autorise_html"),
				array("v" => "pref_allow_smilies",					"t"	=>	"user_pref_autorise_smilies"),
				array("v" => "image_avatar",						"t"	=>	"user_image_avatar"),
				array("v" => "admin_comment",						"t"	=>	"user_admin_commentaire"),
		),
);


self::$PreRequisiteTable['add']['website'] = array (
		"execute" => function (&$a) {
		if ( $a['params']['user'] == "*user_install*" ) { $a['params']['user'] = $a['Initiator']['db_login']; }
		if ( $a['params']['password'] == "*user_install*" ) { $a['params']['password'] = $a['Initiator']['db_pass'];}
		$a['params']['password'] = hash("sha512",stripslashes($a['params']['password']));
		},
		"convert" => array(
				array("v" => "lang_select",			"s" => "website"),
				array("v" => "stylesheet",			"s" => "website"),
				array("v" => "state",				"s" => "website"),
				array("v" => "gal_mode",			"s" => "website"),
				array("v" => "ma_diff",				"s" => "website"),
				array("v" => "gal_mode",			"s" => "website"),
		),
		"nextId" => array (
				array ("table" => "website",	"column" => "ws_id",		"target" => "ws_id"),
		),
		"columns" => array(
				array ( "v" => "ws_id",			"t" => "ws_id"),
				array ( "v" => "name",			"t" => "ws_name"),
				array ( "v" => "short",			"t" => "ws_short"),
				array ( "v" => "lang_id",		"t" => "ws_lang"),
				array ( "v" => "lang_select",	"t" => "ws_lang_select"),
				array ( "v" => "theme_id",		"t" => "theme_id"),
				array ( "v" => "title",			"t" => "ws_title"),
				array ( "v" => "status_bar",	"t" => "ws_status_bar"),
				array ( "v" => "home",			"t" => "ws_home"),
				array ( "v" => "directory",		"t" => "ws_directory"),
				array ( "v" => "state",			"t" => "ws_state"),
				array ( "v" => "info_debug",	"t" => "ws_info_debug"),
				array ( "v" => "stylesheet",	"t" => "ws_stylesheet"),
				array ( "v" => "gal_mode",		"t" => "ws_gal_mode"),
				array ( "v" => "gal_file_tag",	"t" => "ws_gal_file_tag"),
				array ( "v" => "gal_quality",	"t" => "ws_gal_quality"),
				array ( "v" => "gal_x",			"t" => "ws_gal_x"),
				array ( "v" => "gal_y",			"t" => "ws_gal_y"),
				array ( "v" => "gal_border",	"t" => "ws_gal_border"),
				array ( "v" => "ma_diff",		"t" => "ws_ma_diff"),
		),
);


//--------------------------------------------------------------------------------
//	Assign
//--------------------------------------------------------------------------------
self::$PreRequisiteTable['assign']['document'] = array (
		"columns" => array(
				array ( "v" => "arti_id",					"t" => "arti_id"),
				array ( "v" => "docu_id",					"t" => "docu_id"),
		),
);

self::$PreRequisiteTable['assign']['language'] = array (
		"nextId" => array (
				array ("table" => "language_website",		"column" => "lang_website_id",				"target" => "lang_website_id"),
		),
		"columns" => array(
				array ( "v" => "lang_website_id",			"t" => "lang_website_id"),
				array ( "v" => "ws_id",					"t" => "ws_id"),
				array ( "v" => "lang_id",				"t" => "lang_id"),
		),
);


self::$PreRequisiteTable['assign']['layout'] = array (
		"convert" => array(
				array("v" => "default",						"s" => "layout"),
		),
		"nextId" => array (
				array ("table" => "theme_presentation",	"column" => "theme_pres_id",	"target" => "theme_pres_id", ),
		),
		"columns" => array(
				array ( "v" => "theme_pres_id",				"t" => "theme_pres_id"),
				array ( "v" => "theme_id",					"t" => "theme_id"),
				array ( "v" => "pres_id",					"t" => "pres_id"),
				array ( "v" => "default",					"t" => "default"),
		),
);


self::$PreRequisiteTable['assign']['tag'] = array (
		"convert" => array(),
		"nextId" => array (
				array ("table" => "article_tag",	"column" => "article_tag_id",		"target" => "article_tag_id"),
		),
		"columns" => array(
				array ( "v" => "article_tag_id",	"t" => "article_tag_id"),
				array ( "v" => "arti_id",			"t" => "arti_id"),
				array ( "v" => "tag_id",			"t" => "tag_id"),
				
		),
);

self::$PreRequisiteTable['assign']['theme'] = array ();



self::$PreRequisiteTable['assign']['user'] = array (
		"execute" => function (&$a) {
		if ( $a['params']['name'] == "*user_install*" ) { $a['params']['name'] = $a['Initiator']['db_login']; }
		},
		"convert" => array(
				array("v" => "primary_group",					"s" => "user"),
		),
		"nextId" => array (
				array ("table" => "groupe_user",	"column" => "groupe_user_id",		"target" => "groupe_user_id"),
		),
		"columns" => array(
				array("v" => "groupe_user_id",						"t"	=>	"groupe_user_id"),
				array("v" => "group_id",							"t"	=>	"group_id"),
				array("v" => "user_id",								"t"	=>	"user_id"),
				array("v" => "primary_group",						"t"	=>	"groupe_premier"),
		),
		);



//--------------------------------------------------------------------------------
//	Insert
//--------------------------------------------------------------------------------
self::$PreRequisiteTable['insert']['content'] = array (
		"execute" => function (&$a) {
			if ( strlen($a['params']['creator']) == 0 ) { $a['params']['creator'] = $a['Initiator']['db_login']; }
			if ( strlen($a['params']['validator']) == 0 ) { $a['params']['validator'] = $a['Initiator']['db_login'];}
		},
		"columns" => array(
				array ( "v" => "docu_id",				"t" => "docu_id"),
				array ( "v" => "content",				"t" => "docu_cont"),
		),
);

//--------------------------------------------------------------------------------
//	Set
//--------------------------------------------------------------------------------
self::$PreRequisiteTable['set']['variable'] = array ();
self::$PreRequisiteTable['set']['checkpoint'] = array ();



//--------------------------------------------------------------------------------
//	Share
//--------------------------------------------------------------------------------
self::$PreRequisiteTable['share']['document'] = array (
		"convert" => array(
				array("v" => "modification",					"s" => "document"),
		),
		"nextId" => array (
				array ("table" => "document_share",	"column" => "share_id",		"target" => "share_id"),
		),
		"columns" => array(
				array ( "v" => "share_id",				"t" => "share_id"),
				array ( "v" => "docu_id",				"t" => "docu_id"),
				array ( "v" => "ws_id",				"t" => "ws_id"),
				array ( "v" => "modification",			"t" => "share_modification"),
		),
);

//--------------------------------------------------------------------------------
//	Update
//--------------------------------------------------------------------------------
self::$PreRequisiteTable['update']['article']['convert']		= &self::$PreRequisiteTable['add']['article']['convert'];
self::$PreRequisiteTable['update']['article']['nextId']			= &self::$PreRequisiteTable['add']['article']['nextId'];
self::$PreRequisiteTable['update']['article']['timeCreate']		= &self::$PreRequisiteTable['add']['article']['timeCreate'];
self::$PreRequisiteTable['update']['article']['columns']		= &self::$PreRequisiteTable['add']['article']['columns'];

self::$PreRequisiteTable['update']['deadline']['convert']		= &self::$PreRequisiteTable['add']['deadline']['convert'];
self::$PreRequisiteTable['update']['deadline']['nextId']		= &self::$PreRequisiteTable['add']['deadline']['nextId'];
self::$PreRequisiteTable['update']['deadline']['columns']		= &self::$PreRequisiteTable['add']['deadline']['columns'];

self::$PreRequisiteTable['update']['document']					= self::$PreRequisiteTable['add']['document'];		// It's a copy not a reference!
self::$PreRequisiteTable['update']['document']['execute']		= function (&$a) {
	if ( $a['params']['creator'] == "*user_install*" ) {$a['params']['creator'] = $a['Initiator']['db_login'];}
	if ( $a['params']['validator'] == "*user_install*" ) {$a['params']['validator'] = $a['Initiator']['db_login'];}
};
self::$PreRequisiteTable['update']['document']['nextId']		= 0;

self::$PreRequisiteTable['update']['user']						= self::$PreRequisiteTable['add']['user'];		// It's a copy not a reference!
self::$PreRequisiteTable['update']['user']['nextId']			= array();


self::$PreRequisiteTable['website']['context'] = array (
		"execute" => function (&$a) {	
		if ( $a['params']['user'] == "*user_install*" ) { $a['params']['user'] = $a['Initiator']['db_login']; }
		if ( $a['params']['password'] == "*user_install*" ) { $a['params']['password'] = $a['Initiator']['db_pass'];}
		$a['params']['password'] = hash("sha512",stripslashes($a['params']['password']));
		},
);


self::$PreRequisiteTable['update']['website']['convert']			= &self::$PreRequisiteTable['add']['website']['convert'];
self::$PreRequisiteTable['update']['website']['timeCreate']			= &self::$PreRequisiteTable['add']['website']['timeCreate'];
self::$PreRequisiteTable['update']['website']['nextId']				= 0; 
self::$PreRequisiteTable['update']['website']['langConvert']		= 0;
self::$PreRequisiteTable['update']['website']['columns']			= array(
		array ( "v" => "name",			"t" => "ws_name"),
		array ( "v" => "short",			"t" => "ws_short"),
		array ( "v" => "lang_id",		"t" => "ws_lang"),
		array ( "v" => "lang_select",	"t" => "ws_lang_select"),
		array ( "v" => "theme_id",		"t" => "theme_id"),
		array ( "v" => "title",			"t" => "ws_title"),
		array ( "v" => "status_bar",	"t" => "ws_status_bar"),
		array ( "v" => "home",			"t" => "ws_home"),
		array ( "v" => "directory",		"t" => "ws_directory"),
		array ( "v" => "state",			"t" => "ws_state"),
		array ( "v" => "info_debug",	"t" => "ws_info_debug"),
		array ( "v" => "stylesheet",	"t" => "ws_stylesheet"),
		array ( "v" => "gal_mode",		"t" => "ws_gal_mode"),
		array ( "v" => "gal_file_tag",	"t" => "ws_gal_file_tag"),
		array ( "v" => "gal_quality",	"t" => "ws_gal_quality"),
		array ( "v" => "gal_x",			"t" => "ws_gal_x"),
		array ( "v" => "gal_y",			"t" => "ws_gal_y"),
		array ( "v" => "gal_border",	"t" => "ws_gal_border"),
		array ( "v" => "ma_diff",		"t" => "ws_ma_diff"),
);



?>