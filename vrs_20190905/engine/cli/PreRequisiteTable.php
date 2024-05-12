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

self::$PreRequisiteTable['add']['article'] = array(
	"execute" => function (&$a) {
		if (strlen($a['params']['creator'] ?? '') == 0) {
			$a['params']['creator'] = $a['Initiator']['db_login'];
		}
		if (strlen($a['params']['validator'] ?? '') == 0) {
			$a['params']['validator'] = $a['Initiator']['db_login'];
		}
	},

	"convert" => array(
		array("v" => "validation_state",		"s" => "article")
	),
	"nextId" => array(
		array("table" => "article",		"column" => "arti_id",			"target" => "id"),
		array("table" => "group_website",	"column" => "group_website_id",	"target" => "group_website_id")
	),
	"timeCreate" => array(
		"creation_date",
	),
	"columns" => array(
		array("v" => "id",					"t" => "arti_id"),
		array("v" => "ref",					"t" => "arti_ref"),
		array("v" => "slug",					"t" => "arti_slug"),
		array("v" => "deadline_id",			"t" => "fk_deadline_id"),
		array("v" => "name",					"t" => "arti_name"),
		array("v" => "desc",					"t" => "arti_desc"),
		array("v" => "title",					"t" => "arti_title"),
		array("v" => "subtitle",				"t" => "arti_subtitle"),
		array("v" => "page",					"t" => "arti_page"),
		array("v" => "layout_generic_name",	"t" => "layout_generic_name"),
		array("v" => "config_id",				"t" => "fk_config_id"),
		array("v" => "user_id_creator",		"t" => "arti_creator_id"),
		array("v" => "creation_date",			"t" => "arti_creation_date"),
		array("v" => "user_id_validator",		"t" => "arti_validator_id"),
		array("v" => "validation_date",		"t" => "arti_validation_date"),
		array("v" => "validation_state",		"t" => "arti_validation_state"),
		array("v" => "parution_date",			"t" => "arti_release_date"),
		array("v" => "docu_id",				"t" => "fk_docu_id"),
		array("v" => "ws_id",					"t" => "fk_ws_id"),
	),
);

self::$PreRequisiteTable['add']['deadline'] = array(
	"convert" => array(
		array("v" => "state",				"s" => "deadline"),
	),
	"nextId" => array(
		array("table" => "deadline",		"column" => "deadline_id",			"target" => "id"),
	),
	"timeConvert" => array(
		"end_date"
	),
	"columns" => array(
		array("v" => "id",				"t" => "deadline_id"),
		array("v" => "name",				"t" => "deadline_name"),
		array("v" => "title",				"t" => "deadline_title"),
		array("v" => "state",				"t" => "deadline_state"),
		array("v" => "date_creation",		"t" => "deadline_creation_date"),
		array("v" => "end_date",			"t" => "deadline_end_date"),
		array("v" => "ws_id",				"t" => "fk_ws_id"),
	),
);


self::$PreRequisiteTable['add']['decoration'] = array(
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
	"nextId" => array(
		// array ("table" => "decoration",				"column" => "fk_deco_id",			"target" => "id"),
		array("table" => "decoration",				"column" => "deco_id",				"target" => "id"),
		array("table" => "deco_10_menu",			"column" => "deco_line_number",		"target" => "10_id"),
		array("table" => "deco_20_caligraph",		"column" => "deco_line_number",		"target" => "20_id"),
		array("table" => "deco_30_1_div",			"column" => "deco_line_number",		"target" => "30_id"),
		array("table" => "deco_40_elegance",		"column" => "deco_line_number",		"target" => "40_id"),
		array("table" => "deco_50_exquisite",		"column" => "deco_line_number",		"target" => "50_id"),
		array("table" => "deco_60_elysion",		"column" => "deco_line_number",		"target" => "60_id"),
	),
	"columns" => array(
		array("v" => "id",				"t" => "deco_id"),
		array("v" => "name",				"t" => "deco_name"),
		array("v" => "state",				"t" => "deco_state"),
		array("v" => "type",				"t" => "deco_type"),
		// array ( "v" => "id",				"t" => "fk_deco_id"),
	),
);


self::$PreRequisiteTable['add']['definition'] = array(
	"nextId" => array(
		array("table" => "definition",				"column" => "def_id",			"target" => "id"),
	),
	"columns" => array(
		array("v" => "id",				"t" => "def_id"),
		array("v" => "name",				"t" => "def_name"),
		array("v" => "number",			"t" => "def_number"),
		array("v" => "text",				"t" => "def_text"),
	),
);


self::$PreRequisiteTable['add']['article_config'] = array(
	"convert" => array(
		array("v" => "menu_type",				"s" => "article_config"),
		array("v" => "menu_style",				"s" => "article_config"),
		array("v" => "menu_float_position",		"s" => "article_config"),
		array("v" => "menu_occurence",			"s" => "article_config"),
		array("v" => "show_info_parution",		"s" => "article_config"),
		array("v" => "show_info_modification",	"s" => "article_config"),
	),
	"nextId" => array(
		array("table" => "article_config",		"column" => "config_id",			"target" => "id"),
	),
	"columns" => array(
		array("v" => "id",						"t" => "config_id"),
		array("v" => "name",						"t" => "config_name"),
		array("v" => "menu_type",					"t" => "config_menu_type"),
		array("v" => "menu_style",				"t" => "config_menu_style"),
		array("v" => "menu_float_position",		"t" => "config_menu_float_position"),
		array("v" => "menu_float_size_x",			"t" => "config_menu_float_size_x"),
		array("v" => "menu_float_size_y",			"t" => "config_menu_float_size_y"),
		array("v" => "menu_occurence",			"t" => "config_menu_occurence"),
		array("v" => "show_info_parution",		"t" => "config_show_release_info"),
		array("v" => "show_info_modification",	"t" => "config_show_info_update"),
		array("v" => "ws_id",						"t" => "fk_ws_id"),
	),
);

self::$PreRequisiteTable['add']['document'] = array(
	"execute" => function (&$a) {
		if (strlen($a['params']['creator'] ?? '') == 0) {
			$a['params']['creator'] = $a['Initiator']['db_login'];
		}
		if (strlen($a['params']['validator'] ?? '') == 0) {
			$a['params']['validator'] = $a['Initiator']['db_login'];
		}
	},
	"convert" => array(
		array("v" => "type",			"s" => "document"),
		array("v" => "validation",		"s" => "document"),
		array("v" => "modification",	"s" => "document"),
	),
	"nextId" => array(
		array("table" => "document",				"column" => "docu_id",			"target" => "id"),
	),
	"timeCreate" => array(
		"creation_date",
	),
	"columns" => array(
		array("v" => "id",				"t" => "docu_id"),
		array("v" => "name",				"t" => "docu_name"),
		array("v" => "type",				"t" => "docu_type"),
		array("v" => "origin",			"t" => "docu_origin"),
		array("v" => "creator_user_id",	"t" => "docu_creator"),
		array("v" => "creation_date",		"t" => "docu_creation_date"),
		array("v" => "validation",		"t" => "docu_validation"),
		array("v" => "validator_user_id",	"t" => "docu_validator"),
		array("v" => "validation_date",	"t" => "docu_validation_date"),
		array("v" => "content",			"t" => "docu_cont"),
	),
);


self::$PreRequisiteTable['add']['group'] = array(
	"convert" => array(
		array("v" => "tag",			"s" => "group"),
	),
	"nextId" => array(
		array("table" => "group",			"column" => "group_id",		"target" => "id"),
		array("table" => "group_website",	"column" => "group_website_id",	"target" => "group_webws_id"),
	),
	"timeCreate" => array(
		"creation_date",
	),
	"columns" => array(
		array("v" => "id",			"t" => "group_id"),
		array("v" => "name",			"t" => "group_name"),
		array("v" => "group_parent",	"t" => "group_parent"),
		array("v" => "tag",			"t" => "group_tag"),
		array("v" => "title",			"t" => "group_title"),
		array("v" => "file",			"t" => "group_file"),
		array("v" => "desc",			"t" => "group_desc"),
	),
);


self::$PreRequisiteTable['add']['keyword'] = array(
	"convert" => array(
		array("v" => "state",			"s" => "keyword"),
		array("v" => "type",			"s" => "keyword"),
	),
	"nextId" => array(
		array("table" => "keyword",			"column" => "keyword_id",		"target" => "id"),
	),
	"columns" => array(
		array("v" => "id",						"t" => "keyword_id"),
		array("v" => "name",						"t" => "keyword_name"),
		array("v" => "state",						"t" => "keyword_state"),
		array("v" => "arti_id",					"t" => "fk_arti_id"),
		array("v" => "site",						"t" => "fk_ws_id"),
		array("v" => "string",					"t" => "keyword_string"),
		array("v" => "count",						"t" => "keyword_count"),
		array("v" => "type",						"t" => "keyword_type"),
		array("v" => "data", 						"t" => "keyword_data"),
	),
);


self::$PreRequisiteTable['add']['layout'] = array(
	"convert" => array(),
	"nextId" => array(
		array("table" => "layout",		"column" => "layout_id",				"target" => "id"),
	),
	"columns" => array(
		array("v" => "id",						"t" => "layout_id"),
		array("v" => "name",						"t" => "layout_name"),
		array("v" => "title",						"t" => "layout_title"),
		array("v" => "generic_name",				"t" => "layout_generic_name"),
		array("v" => "desc",						"t" => "layout_desc"),
		array("v" => "layout_file",				"t" => "fk_layout_file_id"),
	),
);

self::$PreRequisiteTable['add']['layout_file'] = array(
	"convert" => array(),
	"nextId" => array(
		array("table" => "layout_file",				"column" => "layout_file_id",				"target" => "id"),
	),
	"columns" => array(
		array("v" => "id",						"t" => "layout_file_id"),
		array("v" => "name",						"t" => "layout_file_name"),
		array("v" => "generic_name",				"t" => "layout_file_generic_name"),
		array("v" => "filename",					"t" => "layout_file_filename"),
		array("v" => "desc",						"t" => "layout_file_desc"),
	),
);


self::$PreRequisiteTable['add']['menu'] = array(
	"convert" => array(
		array("v" => "type",		"s" => "menu"),
		array("v" => "state",		"s" => "menu"),
		array("v" => "role",		"s" => "menu"),
		array("v" => "first_doc",	"s" => "menu"),
	),
	"nextId" => array(
		array("table" => "menu",				"column" => "menu_id",			"target" => "id"),
	),
	"columns" => array(
		array("v" => "id",				"t" => "menu_id"),
		array("v" => "name",				"t" => "menu_name"),
		array("v" => "title",				"t" => "menu_title"),
		array("v" => "desc",				"t" => "menu_desc"),
		array("v" => "type",				"t" => "menu_type"),
		array("v" => "ws_id",				"t" => "fk_ws_id"),
		array("v" => "lang_id",			"t" => "fk_lang_id"),
		array("v" => "deadline_id",		"t" => "fk_deadline_id"),
		array("v" => "state",				"t" => "menu_state"),
		array("v" => "parent_id",			"t" => "menu_parent"),
		array("v" => "position",			"t" => "menu_position"),
		array("v" => "fk_perm_id",		"t" => "fk_perm_id"),
		//				array ( "v" => "group_id",			"t" => "fk_group_id"),
		array("v" => "last_modif",		"t" => "menu_last_update"),
		array("v" => "role",				"t" => "menu_role"),
		array("v" => "first_doc",			"t" => "menu_initial_document"),
		array("v" => "article",			"t" => "fk_arti_ref"),
		array("v" => "slug",				"t" => "fk_arti_slug"),
	),
);

self::$PreRequisiteTable['add']['module'] = array(
	"convert" => array(
		array("v" => "deco",			"s" => "module"),
		array("v" => "state",			"s" => "module"),
		array("v" => "adm_control",		"s" => "module"),
		array("v" => "execution",		"s" => "module"),
	),
	"nextId" => array(
		array("table" => "module",			"column" => "module_id",			"target" => "id"),
		array("table" => "module_website",	"column" => "module_website_id",	"target" => "module_website_id"),
	),
	"columns" => array(
		array("v" => "id",						"t" => "module_id"),
		array("v" => "name",						"t" => "module_name"),
		array("v" => "classname",					"t" => "module_classname"),
		array("v" => "deco",						"t" => "module_deco"),
		array("v" => "deco_nbr",					"t" => "module_deco_nbr"),
		array("v" => "deco_txt_default",			"t" => "module_deco_default_text"),
		array("v" => "title",						"t" => "module_title"),
		array("v" => "directory",					"t" => "module_directory"),
		array("v" => "file",						"t" => "module_file"),
		array("v" => "desc",						"t" => "module_desc"),
		array("v" => "fk_perm_id",				"t" => "fk_perm_id"),
		array("v" => "group_allowed_to_see_id",	"t" => "module_group_allowed_to_see"),
		array("v" => "group_allowed_to_use_id",	"t" => "module_group_allowed_to_use"),
		array("v" => "adm_control",				"t" => "module_adm_control"),
		array("v" => "container_name",			"t" => "module_container_name"),
		array("v" => "container_style",			"t" => "module_container_style"),
		array("v" => "execution",					"t" => "module_execution"),
	),
);


self::$PreRequisiteTable['add']['permission'] = array(
	"convert" => array(
		array("v" => "level",			"s" => "permission"),
		array("v" => "state",			"s" => "permission"),
	),
	"nextId" => array(
		array("table" => "permission",			"column" => "perm_id",			"target" => "id"),
	),
	"columns" => array(
		array("v" => "id",							"t" => "perm_id"),
		array("v" => "state",						"t" => "perm_state"),
		array("v" => "name",						"t" => "perm_name"),
		array("v" => "affinity",					"t" => "perm_affinity"),
		array("v" => "object_type",					"t" => "perm_object_type"),
		array("v" => "desc",						"t" => "perm_desc"),
		array("v" => "level",						"t" => "perm_level"),
	),
);


self::$PreRequisiteTable['add']['tag'] = array(
	"execute" => function (&$a) {
		$a['params']['name'] = strtolower($a['params']['name']);
	},
	"convert" => array(),
	"nextId" => array(
		array("table" => "tag",	"column" => "tag_id",		"target" => "id"),
	),
	"columns" => array(
		array("v" => "id",			"t" => "tag_id"),
		array("v" => "name",			"t" => "tag_name"),
		array("v" => "html",			"t" => "tag_html"),
		array("v" => "site",			"t" => "fk_ws_id"),

	),
);


self::$PreRequisiteTable['add']['theme'] = array(
	"convert" => array(
		array("v" => "state",				"s" => "theme"),
	),
	"nextId" => array(
		array("table" => "theme_descriptor",		"column" => "theme_id",			"target" => "id"),
		array("table" => "theme_website",			"column" => "theme_website_id",	"target" => "theme_website_id"),
	),
	"columns" => array(
		array("v" => "id",						"t" => "theme_id"),
		array("v" => "name",						"t" => "theme_name"),
		array("v" => "title",						"t" => "theme_title"),
		array("v" => "desc",						"t" => "theme_desc"),
		array("v" => "date",						"t" => "theme_date"),
	),
);


self::$PreRequisiteTable['add']['theme_definition'] = array(
	"convert" => array(
		array("v" => "type",	"s" => "theme_definition"),
	),
	"convertIntoTarget" => array(
		array("n" => "admctrl_position",	"v" => "string",	"s" => "theme_definition",	"t" => "number"),
	),
	"nextId" => array(
		array("table" => "theme_definition",		"column" => "def_id",			"target" => "id"),
	),
	"columns" => array(
		array("v" => "id",			"t" => "def_id"),
		array("v" => "name",			"t" => "def_name"),
		array("v" => "fk_theme_id",	"t" => "fk_theme_id"),
		array("v" => "type",			"t" => "def_type"),
		array("v" => "number",		"t" => "def_number"),
		array("v" => "string",		"t" => "def_string"),
	),
);


self::$PreRequisiteTable['add']['translation'] = array(
	"nextId" => array(
		array("table" => "i18n",			"column" => "i18n_id",				"target" => "id"),
	),
	"columns" => array(
		array("v" => "id",									"t"	=>	"i18n_id"),
		array("v" => "lang_id",								"t"	=>	"fk_lang_id"),
		array("v" => "package",								"t"	=>	"i18n_package"),
		array("v" => "name",								"t"	=>	"i18n_name"),
		array("v" => "text",								"t"	=>	"i18n_text"),
	),
);

self::$PreRequisiteTable['add']['user'] = array(
	"execute" => function (&$a) {
		if ($a['params']['name'] == "*user_install*") {
			$a['params']['name'] = $a['params']['login'] = $a['params']['perso_name'] = $a['Initiator']['db_login'];
		}
		if ($a['params']['password'] == "*user_install*") {
			$a['params']['password'] = hash("sha512", stripslashes($a['Initiator']['db_pass']));
		}
		if ($a['params']['password'] == "anonymous") {
			$a['params']['password'] = hash("sha512", stripslashes($a['params']['password']));
		}
		if ($a['params']['password'] == "*websiteUserPassword*") {
			$bts = BaseToolSet::getInstance();
			$a['params']['password'] = hash("sha512", stripslashes($bts->CMObj->getConfigurationSubEntry('db', 'websiteUserPassword')));
		}
		if (strlen($a['params']['login'] ?? '') == 0) {
			$a['params']['login'] = $a['params']['name'];
		}
		// 			$a['params']['password'] = hash("sha512",stripslashes($a['params']['password']));
	},
	"convert" => array(
		array("v" => "status",							"s" => "user"),
		array("v" => "role_function",					"s" => "user"),
		array("v" => "forum_access",					"s" => "user"),
		array("v" => "pref_theme",						"s" => "user"),
		array("v" => "pref_newsletter",					"s" => "user"),
		array("v" => "pref_show_email",					"s" => "user"),
		array("v" => "pref_show_status_online",			"s" => "user"),
		array("v" => "pref_notification_reponse_forum",	"s" => "user"),
		array("v" => "pref_notification_new_pm",		"s" => "user"),
		array("v" => "pref_allow_bbcode",				"s" => "user"),
		array("v" => "pref_allow_html",					"s" => "user"),
		array("v" => "pref_allow_smilies",				"s" => "user"),
	),
	"nextId" => array(
		array("table" => "user",		"column" => "user_id",				"target" => "id"),
		array("table" => "group_user",	"column" => "group_user_id",		"target" => "group_user_id"),
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


self::$PreRequisiteTable['add']['website'] = array(
	"execute" => function (&$a) {
		if ($a['params']['user'] == "*user_install*") {
			$a['params']['user'] = $a['Initiator']['db_login'];
		}
		if ($a['params']['password'] == "*user_install*") {
			$a['params']['password'] = $a['Initiator']['db_pass'];
		}
		$a['params']['password'] = hash("sha512", stripslashes($a['params']['password']));
	},
	"convert" => array(
		array("v" => "lang_select",			"s" => "website"),
		array("v" => "stylesheet",			"s" => "website"),
		array("v" => "state",				"s" => "website"),
		array("v" => "gal_mode",			"s" => "website"),
		array("v" => "ma_diff",				"s" => "website"),
		array("v" => "gal_mode",			"s" => "website"),
	),
	"nextId" => array(
		array("table" => "website",	"column" => "ws_id",		"target" => "ws_id"),
	),
	"columns" => array(
		array("v" => "ws_id",			"t" => "ws_id"),
		array("v" => "name",			"t" => "ws_name"),
		array("v" => "short",			"t" => "ws_short"),
		array("v" => "lang_id",		"t" => "fk_lang_id"),
		array("v" => "lang_select",	"t" => "ws_lang_select"),
		array("v" => "theme_id",		"t" => "fk_theme_id"),
		array("v" => "title",			"t" => "ws_title"),
		array("v" => "home",			"t" => "ws_home"),
		array("v" => "directory",		"t" => "ws_directory"),
		array("v" => "state",			"t" => "ws_state"),
		array("v" => "info_debug",	"t" => "ws_info_debug"),
		array("v" => "stylesheet",	"t" => "ws_stylesheet"),
		array("v" => "gal_mode",		"t" => "ws_gal_mode"),
		array("v" => "gal_file_tag",	"t" => "ws_gal_file_tag"),
		array("v" => "gal_quality",	"t" => "ws_gal_quality"),
		array("v" => "gal_x",			"t" => "ws_gal_x"),
		array("v" => "gal_y",			"t" => "ws_gal_y"),
		array("v" => "gal_border",	"t" => "ws_gal_border"),
		array("v" => "ma_diff",		"t" => "ws_ma_diff"),
	),
);


//--------------------------------------------------------------------------------
//	Assign
//--------------------------------------------------------------------------------
self::$PreRequisiteTable['assign']['document'] = array(
	"columns" => array(
		array("v" => "arti_id",					"t" => "arti_id"),
		array("v" => "docu_id",					"t" => "docu_id"),
	),
);

self::$PreRequisiteTable['assign']['language'] = array(
	"nextId" => array(
		array("table" => "language_website",		"column" => "lang_website_id",				"target" => "lang_website_id"),
	),
	"columns" => array(
		array("v" => "lang_website_id",			"t" => "lang_website_id"),
		array("v" => "ws_id",						"t" => "fk_ws_id"),
		array("v" => "lang_id",					"t" => "fk_lang_id"),
	),
);


self::$PreRequisiteTable['assign']['layout'] = array(
	"convert" => array(
		array("v" => "default",						"s" => "layout"),
	),
	"nextId" => array(
		array("table" => "layout_theme",	"column" => "layout_theme_id",	"target" => "layout_theme_id",),
	),
	"columns" => array(
		array("v" => "layout_theme_id",			"t" => "layout_theme_id"),
		array("v" => "theme_id",					"t" => "fk_theme_id"),
		array("v" => "layout_id",					"t" => "fk_layout_id"),
		array("v" => "default",					"t" => "default"),
	),
);


self::$PreRequisiteTable['assign']['group_permission'] = array(
	"execute" => function (&$a) {
		if (strtolower($a['params']['to_all_groups']) == "yes") {
			$bts = BaseToolSet::getInstance();
			$dbquery = $bts->SDDMObj->query("
			SELECT grp.group_id 
			FROM " . $a['sqlTables']['group'] . " grp , " . $a['sqlTables']['group_website'] . " gw , " . $a['sqlTables']['website'] . " ws 
			WHERE grp.group_id = gw.fk_group_id 
			AND gw.fk_ws_id = ws.ws_id 
			AND ws.ws_id = '" . $a['Context']['ws_id'] . "';
			");
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$a['params']['allIds'][] = array('uid' => $bts->SDDMObj->createUniqueId(), 'group_id' => $dbp['group_id']);
			}
			$a['params']['group_id'] = "unlocking mecanism";
		}
	},
	"convert" => array(),
	"nextId" => array(
		array("table" => "group_permission",	"column" => "group_perm_id",		"target" => "group_perm_id"),
	),
	"columns" => array(
		array("v" => "group_perm_id",			"t" => "group_perm_id"),
		array("v" => "perm_id",				"t" => "fk_perm_id"),
		array("v" => "group_id",				"t" => "fk_group_id"),
	),
);

self::$PreRequisiteTable['assign']['user_permission'] = array(
	"execute" => function (&$a) {
		if (strtolower($a['params']['to_all_users']) == "yes") {
			$bts = BaseToolSet::getInstance();
			$dbquery = $bts->SDDMObj->query("
			SELECT usr.user_id 
			FROM " . $a['sqlTables']['user'] . " usr, " . $a['sqlTables']['group_user'] . " gu, " . $a['sqlTables']['group_website'] . " gw 
			WHERE usr.user_id = gu.fk_user_id 
			AND gu.fk_group_id = gw.fk_group_id 
			AND gu.group_user_initial_group = '1' 
			AND gw.fk_ws_id = '" . $a['Context']['ws_id'] . "';
			");
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$a['params']['allIds'][] = array('uid' => $bts->SDDMObj->createUniqueId(), 'user_id' => $dbp['user_id']);
			}
			$a['params']['user_id'] = "unlocking mecanism";
		}
	},
	"convert" => array(),
	"nextId" => array(
		array("table" => "user_permission",	"column" => "user_perm_id",		"target" => "user_perm_id"),
	),
	"columns" => array(
		array("v" => "user_perm_id",			"t" => "user_perm_id"),
		array("v" => "perm_id",				"t" => "fk_perm_id"),
		array("v" => "user_id",				"t" => "fk_user_id"),
	),
);

self::$PreRequisiteTable['assign']['tag'] = array(
	"execute" => function (&$a) {
		$a['params']['name'] = strtolower($a['params']['name']);
	},
	"convert" => array(),
	"nextId" => array(
		array("table" => "article_tag",	"column" => "article_tag_id",		"target" => "article_tag_id"),
	),
	"columns" => array(
		array("v" => "article_tag_id",	"t" => "article_tag_id"),
		array("v" => "arti_id",			"t" => "fk_arti_id"),
		array("v" => "tag_id",			"t" => "fk_tag_id"),

	),
);

self::$PreRequisiteTable['assign']['theme'] = array();



self::$PreRequisiteTable['assign']['user'] = array(
	"execute" => function (&$a) {
		if ($a['params']['name'] == "*user_install*") {
			$a['params']['name'] = $a['Initiator']['db_login'];
		}
	},
	"convert" => array(
		array("v" => "primary_group",					"s" => "user"),
	),
	"nextId" => array(
		array("table" => "group_user",	"column" => "group_user_id",		"target" => "group_user_id"),
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
self::$PreRequisiteTable['insert']['content'] = array(
	"execute" => function (&$a) {
		if (strlen($a['params']['creator'] ?? '') == 0) {
			$a['params']['creator'] = $a['Initiator']['db_login'];
		}
		if (strlen($a['params']['validator'] ?? '') == 0) {
			$a['params']['validator'] = $a['Initiator']['db_login'];
		}
	},
	"columns" => array(
		array("v" => "docu_id",				"t" => "docu_id"),
		array("v" => "content",				"t" => "docu_cont"),
	),
);

//--------------------------------------------------------------------------------
//	Set
//--------------------------------------------------------------------------------
self::$PreRequisiteTable['set']['variable'] = array();
self::$PreRequisiteTable['set']['checkpoint'] = array();



//--------------------------------------------------------------------------------
//	Share
//--------------------------------------------------------------------------------
self::$PreRequisiteTable['share']['document'] = array(
	"convert" => array(
		array("v" => "modification",					"s" => "document"),
	),
	"nextId" => array(
		array("table" => "document_share",	"column" => "share_id",		"target" => "share_id"),
	),
	"columns" => array(
		array("v" => "share_id",				"t" => "share_id"),
		array("v" => "docu_id",				"t" => "fk_docu_id"),
		array("v" => "ws_id",					"t" => "fk_ws_id"),
		array("v" => "modification",			"t" => "share_modification"),
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
self::$PreRequisiteTable['update']['deadline']['columns']		= &self::$PreRequisiteTable['add']['deadline']['columns'];
self::$PreRequisiteTable['update']['deadline']['timeConvert']	= &self::$PreRequisiteTable['add']['deadline']['timeConvert'];


self::$PreRequisiteTable['update']['document']['convert']		= &self::$PreRequisiteTable['add']['document']['convert'];
self::$PreRequisiteTable['update']['document']['columns']		= &self::$PreRequisiteTable['add']['document']['columns'];
self::$PreRequisiteTable['update']['document']['execute']		= function (&$a) {
	if ($a['params']['creator'] == "*user_install*") {
		$a['params']['creator'] = $a['Initiator']['db_login'];
	}
	if ($a['params']['validator'] == "*user_install*") {
		$a['params']['validator'] = $a['Initiator']['db_login'];
	}
};


self::$PreRequisiteTable['update']['layout']['convert']		= &self::$PreRequisiteTable['add']['layout']['convert'];
self::$PreRequisiteTable['update']['layout']['nextId']		= &self::$PreRequisiteTable['add']['layout']['nextId'];
self::$PreRequisiteTable['update']['layout']['columns']		= &self::$PreRequisiteTable['add']['layout']['columns'];


self::$PreRequisiteTable['update']['group']['convert']		= &self::$PreRequisiteTable['add']['group']['convert'];
self::$PreRequisiteTable['update']['group']['nextId']		= &self::$PreRequisiteTable['add']['group']['nextId'];
self::$PreRequisiteTable['update']['group']['columns']		= &self::$PreRequisiteTable['add']['group']['columns'];
self::$PreRequisiteTable['update']['group']['timeCreate']	= &self::$PreRequisiteTable['add']['group']['timeCreate'];

self::$PreRequisiteTable['update']['keyword']['convert']	= &self::$PreRequisiteTable['add']['keyword']['convert'];
self::$PreRequisiteTable['update']['keyword']['columns']	= &self::$PreRequisiteTable['add']['keyword']['columns'];

self::$PreRequisiteTable['update']['module']['convert']		= &self::$PreRequisiteTable['add']['module']['convert'];
self::$PreRequisiteTable['update']['module']['nextId']		= &self::$PreRequisiteTable['add']['module']['nextId'];
self::$PreRequisiteTable['update']['module']['columns']		= &self::$PreRequisiteTable['add']['module']['columns'];


self::$PreRequisiteTable['update']['user']['convert']		= &self::$PreRequisiteTable['add']['user']['convert'];
self::$PreRequisiteTable['update']['user']['columns']		= &self::$PreRequisiteTable['add']['user']['columns'];


self::$PreRequisiteTable['website']['context'] = array(
	"execute" => function (&$a) {
		if ($a['params']['user'] == "*user_install*") {
			$a['params']['user'] = $a['Initiator']['db_login'];
		}
		if ($a['params']['password'] == "*user_install*") {
			$a['params']['password'] = $a['Initiator']['db_pass'];
		}
		$a['params']['password'] = hash("sha512", stripslashes($a['params']['password']));
	},
);


self::$PreRequisiteTable['update']['website']['convert']			= &self::$PreRequisiteTable['add']['website']['convert'];
self::$PreRequisiteTable['update']['website']['timeCreate']			= &self::$PreRequisiteTable['add']['website']['timeCreate'];
self::$PreRequisiteTable['update']['website']['nextId']				= 0;
self::$PreRequisiteTable['update']['website']['langConvert']		= 0;
self::$PreRequisiteTable['update']['website']['columns']			= array(
	array("v" => "name",			"t" => "ws_name"),
	array("v" => "short",			"t" => "ws_short"),
	array("v" => "lang_id",		"t" => "fk_lang_id"),
	array("v" => "lang_select",	"t" => "ws_lang_select"),
	array("v" => "theme_id",		"t" => "fk_theme_id"),
	array("v" => "title",			"t" => "ws_title"),
	array("v" => "home",			"t" => "ws_home"),
	array("v" => "directory",		"t" => "ws_directory"),
	array("v" => "state",			"t" => "ws_state"),
	array("v" => "info_debug",	"t" => "ws_info_debug"),
	array("v" => "stylesheet",	"t" => "ws_stylesheet"),
	array("v" => "gal_mode",		"t" => "ws_gal_mode"),
	array("v" => "gal_file_tag",	"t" => "ws_gal_file_tag"),
	array("v" => "gal_quality",	"t" => "ws_gal_quality"),
	array("v" => "gal_x",			"t" => "ws_gal_x"),
	array("v" => "gal_y",			"t" => "ws_gal_y"),
	array("v" => "gal_border",	"t" => "ws_gal_border"),
	array("v" => "ma_diff",		"t" => "ws_ma_diff"),
);

//--------------------------------------------------------------------------------
//	Update
//--------------------------------------------------------------------------------
self::$PreRequisiteTable['show']['articles']	= &self::$PreRequisiteTable['add']['article'];		// Empty array for 'show' commands
self::$PreRequisiteTable['show']['deadlines']	= &self::$PreRequisiteTable['add']['deadline'];
self::$PreRequisiteTable['show']['decorations']	= &self::$PreRequisiteTable['add']['decoration'];
self::$PreRequisiteTable['show']['documents']	= &self::$PreRequisiteTable['add']['document'];
self::$PreRequisiteTable['show']['groups']		= &self::$PreRequisiteTable['add']['group'];
self::$PreRequisiteTable['show']['keywords']	= &self::$PreRequisiteTable['add']['keyword'];
self::$PreRequisiteTable['show']['menus']		= &self::$PreRequisiteTable['add']['menu'];
self::$PreRequisiteTable['show']['modules']		= &self::$PreRequisiteTable['add']['module'];
self::$PreRequisiteTable['show']['users']		= &self::$PreRequisiteTable['add']['user'];
self::$PreRequisiteTable['show']['websites']	= &self::$PreRequisiteTable['add']['website'];
