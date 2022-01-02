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
				array ( "v" => "slug",					"t" => "arti_slug"),
				array ( "v" => "deadline_id",			"t" => "fk_deadline_id"),
				array ( "v" => "name",					"t" => "arti_name"),
				array ( "v" => "desc",					"t" => "arti_desc"),
				array ( "v" => "title",					"t" => "arti_title"),
				array ( "v" => "subtitle",				"t" => "arti_subtitle"),
				array ( "v" => "page",					"t" => "arti_page"),
				array ( "v" => "layout_generic_name",	"t" => "layout_generic_name"),
				array ( "v" => "config_id",				"t" => "fk_config_id"),
				array ( "v" => "user_id_creator",		"t" => "arti_creator_id"),
				array ( "v" => "creation_date",			"t" => "arti_creation_date"),
				array ( "v" => "user_id_validator",		"t" => "arti_validator_id"),
				array ( "v" => "validation_date",		"t" => "arti_validation_date"),
				array ( "v" => "validation_state",		"t" => "arti_validation_state"),
				array ( "v" => "parution_date",			"t" => "arti_release_date"),
				array ( "v" => "docu_id",				"t" => "fk_docu_id"),
				array ( "v" => "ws_id",					"t" => "fk_ws_id"),
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
				array ( "v" => "user_id",			"t" => "fk_user_id"),
				array ( "v" => "ws_id",				"t" => "fk_ws_id"),
		),
);


self::$PreRequisiteTable['add']['decoration'] = array (
		"convert" => array(
				array("v" => "state",			"s" => "decoration"),
				array("v" => "type",			"s" => "decoration"),
				array("v" => "display_icons",	"s" => "decoration"),
				array("v" => "target_dock",		"s" => "decoration"),
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
				// array ("table" => "decoration",				"column" => "fk_deco_id",			"target" => "id"),
				array ("table" => "decoration",				"column" => "deco_id",				"target" => "id"),
				array ("table" => "deco_10_menu",			"column" => "deco_line_number",		"target" => "10_id"),
				array ("table" => "deco_20_caligraph",		"column" => "deco_line_number",		"target" => "20_id"),
				array ("table" => "deco_30_1_div",			"column" => "deco_line_number",		"target" => "30_id"),
				array ("table" => "deco_40_elegance",		"column" => "deco_line_number",		"target" => "40_id"),
				array ("table" => "deco_50_exquisite",		"column" => "deco_line_number",		"target" => "50_id"),
				array ("table" => "deco_60_elysion",		"column" => "deco_line_number",		"target" => "60_id"),
		),
		"columns" => array(
				array ( "v" => "id",				"t" => "deco_id"),
				array ( "v" => "name",				"t" => "deco_name"),
				array ( "v" => "state",				"t" => "deco_state"),
				array ( "v" => "type",				"t" => "deco_type"),
				// array ( "v" => "id",				"t" => "fk_deco_id"),
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
				array ( "v" => "name",						"t" => "config_name"),
				array ( "v" => "menu_type",					"t" => "config_menu_type"),
				array ( "v" => "menu_style",				"t" => "config_menu_style"),
				array ( "v" => "menu_float_position",		"t" => "config_menu_float_position"),
				array ( "v" => "menu_float_size_x",			"t" => "config_menu_float_size_x"),
				array ( "v" => "menu_float_size_y",			"t" => "config_menu_float_size_y"),
				array ( "v" => "menu_occurence",			"t" => "config_menu_occurence"),
				array ( "v" => "show_info_parution",		"t" => "config_show_release_info"),
				array ( "v" => "show_info_modification",	"t" => "config_show_info_update"),
				array ( "v" => "ws_id",						"t" => "fk_ws_id"),
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
				array ( "v" => "name",				"t" => "docu_name"),
				array ( "v" => "type",				"t" => "docu_type"),
				array ( "v" => "origin",			"t" => "docu_origin"),
				array ( "v" => "creator_user_id",	"t" => "docu_creator"),
				array ( "v" => "creation_date",		"t" => "docu_creation_date"),
				array ( "v" => "validation",		"t" => "docu_examination"),
				array ( "v" => "validator_user_id",	"t" => "docu_examiner"),
				array ( "v" => "validation_date",	"t" => "docu_examination_date"),
				array ( "v" => "content",			"t" => "docu_cont"),
		),
);


self::$PreRequisiteTable['add']['group'] = array (
		"convert" => array(
				array("v" => "tag",			"s" => "group"),
		),
		"nextId" => array (
				array ("table" => "group",			"column" => "group_id",		"target" => "id"),
				array ("table" => "group_website",	"column" => "group_website_id",	"target" => "group_webws_id"),
		),
		"timeCreate" => array (
				"creation_date",
		),
		"columns" => array(
				array ( "v" => "id",			"t" => "group_id"),
				array ( "v" => "name",			"t" => "group_name"),
				array ( "v" => "group_parent",	"t" => "group_parent"),
				array ( "v" => "tag",			"t" => "group_tag"),
				array ( "v" => "title",			"t" => "group_title"),
				array ( "v" => "file",			"t" => "group_file"),
				array ( "v" => "desc",			"t" => "group_desc"),
		),
);


self::$PreRequisiteTable['add']['keyword'] = array (
		"convert" => array(
				array("v" => "state",			"s" => "keyword"),
				array("v" => "type",			"s" => "keyword"),
		),
		"nextId" => array (
				array ("table" => "keyword",			"column" => "keyword_id",		"target" => "id"),
		),
		"columns" => array(
				array ( "v" => "id",						"t" => "keyword_id"),
				array ( "v" => "name",						"t" => "keyword_name"),
				array ( "v" => "state",						"t" => "keyword_state"),
				array ( "v" => "arti_id",					"t" => "fk_arti_id"),	
				array ( "v" => "site",						"t" => "fk_ws_id"), 	
				array ( "v" => "string",					"t" => "keyword_string"),
				array ( "v" => "count",						"t" => "keyword_count"),	
				array ( "v" => "type",						"t" => "keyword_type"),	
				array ( "v" => "data", 						"t" => "keyword_data"),	
		),				
);


self::$PreRequisiteTable['add']['layout'] = array (
		"convert" => array(),
		"nextId" => array (
				array ("table" => "layout",		"column" => "layout_id",				"target" => "id"),
		),
		"columns" => array(
				array ( "v" => "id",						"t" => "layout_id"),
				array ( "v" => "name",						"t" => "layout_name"),
				array ( "v" => "title",						"t" => "layout_title"),
				array ( "v" => "generic_name",				"t" => "layout_generic_name"),	
				array ( "v" => "desc",						"t" => "layout_desc"), 	
				array ( "v" => "layout_file",				"t" => "fk_layout_file_id"), 	
		),				
);

self::$PreRequisiteTable['add']['layout_file'] = array (
		"convert" => array(),
		"nextId" => array (
				array ("table" => "layout_file",				"column" => "layout_file_id",				"target" => "id"),
		),
		"columns" => array(
				array ( "v" => "id",						"t" => "layout_file_id"),
				array ( "v" => "name",						"t" => "layout_file_name"),
				array ( "v" => "generic_name",				"t" => "layout_file_generic_name"),	
				array ( "v" => "filename",					"t" => "layout_file_filename"),
				array ( "v" => "desc",						"t" => "layout_file_desc"), 	
		),				
);


self::$PreRequisiteTable['add']['menu'] = array (
	"convert" => array(
			array("v" => "type",		"s" => "menu"),
			array("v" => "state",		"s" => "menu"),
			array("v" => "role",		"s" => "menu"),
			array("v" => "first_doc",	"s" => "menu"),
	),
	"nextId" => array (
			array ("table" => "menu",				"column" => "menu_id",			"target" => "id"),
	),
	"columns" => array(
			array ( "v" => "id",				"t" => "menu_id"),
			array ( "v" => "name",				"t" => "menu_name"),
			array ( "v" => "title",				"t" => "menu_title"),
			array ( "v" => "desc",				"t" => "menu_desc"),
			array ( "v" => "type",				"t" => "menu_type"),
			array ( "v" => "ws_id",				"t" => "fk_ws_id"),
			array ( "v" => "lang_id",			"t" => "fk_lang_id"),
			array ( "v" => "deadline_id",		"t" => "fk_deadline_id"),
			array ( "v" => "state",				"t" => "menu_state"),
			array ( "v" => "parent_id",			"t" => "menu_parent"),
			array ( "v" => "position",			"t" => "menu_position"),
			array ( "v" => "fk_perm_id",		"t" => "fk_perm_id"),
//				array ( "v" => "group_id",			"t" => "fk_group_id"),
			array ( "v" => "last_modif",		"t" => "menu_last_update"),
			array ( "v" => "role",				"t" => "menu_role"),
			array ( "v" => "first_doc",			"t" => "menu_initial_document"),
			array ( "v" => "article",			"t" => "fk_arti_ref"),
			array ( "v" => "slug",				"t" => "fk_arti_slug"),
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
				array ("table" => "module",			"column" => "module_id",			"target" => "id"),
				array ("table" => "module_website",	"column" => "module_website_id",	"target" => "module_website_id"),
		),
		"columns" => array(
				array ( "v" => "id",						"t" => "module_id"),
				array ( "v" => "name",						"t" => "module_name"),
				array ( "v" => "classname",					"t" => "module_classname"),
				array ( "v" => "deco",						"t" => "module_deco"),
				array ( "v" => "deco_nbr",					"t" => "module_deco_nbr"),
				array ( "v" => "deco_txt_default",			"t" => "module_deco_default_text"),
				array ( "v" => "title",						"t" => "module_title"),
				array ( "v" => "directory",					"t" => "module_directory"),
				array ( "v" => "file",						"t" => "module_file"),
				array ( "v" => "desc",						"t" => "module_desc"),
				array ( "v" => "fk_perm_id",				"t" => "fk_perm_id"),
				array ( "v" => "group_allowed_to_see_id",	"t" => "module_group_allowed_to_see"),
				array ( "v" => "group_allowed_to_use_id",	"t" => "module_group_allowed_to_use"),
				array ( "v" => "adm_control",				"t" => "module_adm_control"),
				array ( "v" => "container_name",			"t" => "module_container_name"),
				array ( "v" => "container_style",			"t" => "module_container_style"),
				array ( "v" => "execution",					"t" => "module_execution"),
		),
);


self::$PreRequisiteTable['add']['permission'] = array (
		"convert" => array(
				array("v" => "level",			"s" => "permission"),
				array("v" => "state",			"s" => "permission"),
		),
		"nextId" => array (
				array ("table" => "permission",			"column" => "perm_id",			"target" => "id"),
		),
		"columns" => array(
			array ( "v" => "id",							"t" => "perm_id"),
			array ( "v" => "state",							"t" => "perm_state"),
			array ( "v" => "name",							"t" => "perm_name"),
			array ( "v" => "affinity",						"t" => "perm_affinity"),
			array ( "v" => "object_type",					"t" => "perm_object_type"),
			array ( "v" => "desc",							"t" => "perm_desc"),
			array ( "v" => "level",							"t" => "perm_level"),
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
				array ( "v" => "site",			"t" => "fk_ws_id"),

		),
);


self::$PreRequisiteTable['add']['theme'] = array (
		"convert" => array(
				array("v" => "state",				"s" => "theme"),
				array("v" => "admctrl_position",	"s" => "theme"),
		),
		"nextId" => array (
				array ("table" => "theme_descriptor",		"column" => "theme_id",			"target" => "id"),
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
				array ( "v" => "width",						"t" => "theme_width"),
				array ( "v" => "height",					"t" => "theme_height"),
				array ( "v" => "max_width",					"t" => "theme_max_width"),
				array ( "v" => "max_height",				"t" => "theme_max_height"),
				array ( "v" => "min_width",					"t" => "theme_min_width"),
				array ( "v" => "min_height",				"t" => "theme_min_height"),
				array ( "v" => "bg",						"t" => "theme_bg"),
				array ( "v" => "bg_position",				"t" => "theme_bg_position"),
				array ( "v" => "bg_repeat", 				"t" => "theme_bg_repeat"),
				array ( "v" => "bg_color", 					"t" => "theme_bg_color"),
				array ( "v" => "logo",						"t" => "theme_logo"),
				array ( "v" => "divinitial_bg",				"t" => "theme_divinitial_bg"),
				array ( "v" => "divinitial_repeat",			"t" => "theme_divinitial_repeat"),
				array ( "v" => "divinitial_dx",				"t" => "theme_divinitial_dx"),
				array ( "v" => "divinitial_dy",				"t" => "theme_divinitial_dy"),
				array ( "v" => "admctrl_panel_bg",			"t" => "theme_admctrl_panel_bg"),
				array ( "v" => "admctrl_switch_bg",			"t" => "theme_admctrl_switch_bg"),
				array ( "v" => "admctrl_width",				"t" => "theme_admctrl_width"),
				array ( "v" => "admctrl_height",			"t" => "theme_admctrl_height"),
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
				array("v" => "lang_id",								"t"	=>	"fk_lang_id"),
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
				$bts = BaseToolSet::getInstance();
				$a['params']['password'] = hash("sha512",stripslashes($bts->CMObj->getConfigurationSubEntry('db', 'standard_user_password'))); 
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
				array ("table" => "user",		"column" => "user_id",				"target" => "id"),
				array ("table" => "group_user",	"column" => "group_user_id",		"target" => "group_user_id"),
		),
		"columns" => array(
				array("v" => "id",									"t"	=>	"user_id"),
				array("v" => "name",								"t"	=>	"user_name"),
				array("v" => "login",								"t"	=>	"user_login"),
				array("v" => "password",							"t"	=>	"user_password"),
				array("v" => "date_inscription",					"t"	=>	"user_subscription_date"),
				array("v" => "status",								"t"	=>	"user_status"),
				array("v" => "role_function",						"t"	=>	"user_role_function"),
				array("v" => "forum_access",						"t"	=>	"user_forum_access"),
				array("v" => "email",								"t"	=>	"user_email"),
				array("v" => "msn",									"t"	=>	"user_msn"),
				array("v" => "aim",									"t"	=>	"user_aim"),
				array("v" => "icq",									"t"	=>	"user_icq"),
				array("v" => "yim",									"t"	=>	"user_yim"),
				array("v" => "website",								"t"	=>	"user_website"),
				array("v" => "perso_name",							"t"	=>	"user_perso_name"),
				array("v" => "perso_copuntry",						"t"	=>	"user_perso_country"),
				array("v" => "perso_town",							"t"	=>	"user_perso_town"),
				array("v" => "perso_occupation",					"t"	=>	"user_perso_occupation"),
				array("v" => "perso_interest",						"t"	=>	"user_perso_interest"),
				array("v" => "last_visit",							"t"	=>	"user_last_visit"),
				array("v" => "last_ip",								"t"	=>	"user_last_ip"),
				array("v" => "timezone",							"t"	=>	"user_timezone"),
				array("v" => "lang",								"t"	=>	"user_lang"),
				array("v" => "pref_theme_id",						"t"	=>	"user_pref_theme"),
				array("v" => "pref_newsletter",						"t"	=>	"user_pref_newsletter"),
				array("v" => "pref_show_email",						"t"	=>	"user_pref_show_email"),
				array("v" => "pref_show_status_online",				"t"	=>	"user_pref_show_online_status"),
				array("v" => "pref_notification_reponse_forum",		"t"	=>	"user_pref_forum_notification"),
				array("v" => "pref_notification_new_pm",			"t"	=>	"user_pref_forum_pm"),
				array("v" => "pref_allow_bbcode",					"t"	=>	"user_pref_allow_bbcode"),
				array("v" => "pref_allow_html",						"t"	=>	"user_pref_allow_html"),
				array("v" => "pref_allow_smilies",					"t"	=>	"user_pref_autorise_smilies"),
				array("v" => "image_avatar",						"t"	=>	"user_avatar_image"),
				array("v" => "admin_comment",						"t"	=>	"user_admin_comment"),
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
				array ( "v" => "lang_id",		"t" => "fk_lang_id"),
				array ( "v" => "lang_select",	"t" => "ws_lang_select"),
				array ( "v" => "theme_id",		"t" => "fk_theme_id"),
				array ( "v" => "title",			"t" => "ws_title"),
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
				array ( "v" => "ws_id",						"t" => "fk_ws_id"),
				array ( "v" => "lang_id",					"t" => "fk_lang_id"),
		),
);


self::$PreRequisiteTable['assign']['layout'] = array (
		"convert" => array(
				array("v" => "default",						"s" => "layout"),
		),
		"nextId" => array (
				array ("table" => "layout_theme",	"column" => "layout_theme_id",	"target" => "layout_theme_id", ),
		),
		"columns" => array(
				array ( "v" => "layout_theme_id",			"t" => "layout_theme_id"),
				array ( "v" => "theme_id",					"t" => "fk_theme_id"),
				array ( "v" => "layout_id",					"t" => "fk_layout_id"),
				array ( "v" => "default",					"t" => "default"),
		),
);


self::$PreRequisiteTable['assign']['group_permission'] = array (
	"execute" => function (&$a) {
		if ( strtolower($a['params']['to_all_groups']) == "yes" ){
			$bts = BaseToolSet::getInstance();
			$dbquery = $bts->SDDMObj->query ("
			SELECT grp.group_id 
			FROM ".$a['sqlTables']['group']." grp , ".$a['sqlTables']['group_website']." gw , ".$a['sqlTables']['website']." ws 
			WHERE grp.group_id = gw.fk_group_id 
			AND gw.fk_ws_id = ws.ws_id 
			AND ws.ws_id = '".$a['Context']['ws_id']."';
			");
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ($dbquery) ) { 
				$a['params']['allIds'][] = array('uid' => $bts->SDDMObj->createUniqueId(), 'group_id' => $dbp['group_id']);
			}
			$a['params']['group_id'] = "unlocking mecanism";
		}
	},
	"convert" => array(),
	"nextId" => array (
		array ("table" => "group_permission",	"column" => "group_perm_id",		"target" => "group_perm_id"),
	),
	"columns" => array(
			array ( "v" => "group_perm_id",			"t" => "group_perm_id"),
			array ( "v" => "perm_id",				"t" => "fk_perm_id"),
			array ( "v" => "group_id",				"t" => "fk_group_id"),
	),
);

self::$PreRequisiteTable['assign']['user_permission'] = array (
	"execute" => function (&$a) {
		if ( strtolower($a['params']['to_all_users']) == "yes" ){
			$bts = BaseToolSet::getInstance();
			$dbquery = $bts->SDDMObj->query ("
			SELECT usr.user_id 
			FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['group_user']." gu, ".$a['sqlTables']['group_website']." gw 
			WHERE usr.user_id = gu.fk_user_id 
			AND gu.fk_group_id = gw.fk_group_id 
			AND gu.group_user_initial_group = '1' 
			AND gw.fk_ws_id = '".$a['Context']['ws_id']."';
			");
			while ( $dbp = $bts->SDDMObj->fetch_array_sql($dbquery) ) { 
				$a['params']['allIds'][] = array('uid' => $bts->SDDMObj->createUniqueId(), 'user_id' => $dbp['user_id']);
			}
			$a['params']['user_id'] = "unlocking mecanism";
		}
	},
	"convert" => array(),
	"nextId" => array (
		array ("table" => "user_permission",	"column" => "user_perm_id",		"target" => "user_perm_id"),
	),
	"columns" => array(
			array ( "v" => "user_perm_id",			"t" => "user_perm_id"),
			array ( "v" => "perm_id",				"t" => "fk_perm_id"),
			array ( "v" => "user_id",				"t" => "fk_user_id"),
	),
);

self::$PreRequisiteTable['assign']['tag'] = array (
		"convert" => array(),
		"nextId" => array (
				array ("table" => "article_tag",	"column" => "article_tag_id",		"target" => "article_tag_id"),
		),
		"columns" => array(
				array ( "v" => "article_tag_id",	"t" => "article_tag_id"),
				array ( "v" => "arti_id",			"t" => "fk_arti_id"),
				array ( "v" => "tag_id",			"t" => "fk_tag_id"),
				
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
				array ("table" => "group_user",	"column" => "group_user_id",		"target" => "group_user_id"),
		),
		"columns" => array(
				array("v" => "group_user_id",						"t"	=>	"group_user_id"),
				array("v" => "group_id",							"t"	=>	"fk_group_id"),
				array("v" => "user_id",								"t"	=>	"fk_user_id"),
				array("v" => "primary_group",						"t"	=>	"group_user_initial_group"),
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
				array ( "v" => "docu_id",				"t" => "fk_docu_id"),
				array ( "v" => "ws_id",					"t" => "fk_ws_id"),
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
		array ( "v" => "lang_id",		"t" => "fk_lang_id"),
		array ( "v" => "lang_select",	"t" => "ws_lang_select"),
		array ( "v" => "theme_id",		"t" => "fk_theme_id"),
		array ( "v" => "title",			"t" => "ws_title"),
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