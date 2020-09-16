<?php 

// d=Directive
// f=Function
// c=Column
// v=Variable (destination)
// m=Message Code -> CLI_<entity>_<operation>xxx.
// p=parameter name (for error message)
//
// return -1 means "non applicable".
// Always returns an array to support multiple operations.
//


// Article
self::$CheckTable['add']['article']['0']['d']	= 3;
self::$CheckTable['add']['article']['0']['f']	= function ($a) { return array ("SELECT arti_id,arti_nom FROM ".$a['sqlTables']['article']." WHERE arti_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['article']['0']['m']	= "CLI_Article_C001";
self::$CheckTable['add']['article']['1']['d']	= 2;
self::$CheckTable['add']['article']['1']['f']	= function ($a) { return array ("SELECT bouclage_id FROM ".$a['sqlTables']['bouclage']." WHERE bouclage_nom = '".$a['params']['deadline']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['article']['1']['c']	= "bouclage_id";
self::$CheckTable['add']['article']['1']['v']	= "deadline_id";
self::$CheckTable['add']['article']['1']['m']	= "CLI_Article_C002";
self::$CheckTable['add']['article']['1']['p']	= "deadline";
self::$CheckTable['add']['article']['2']['d']	= 2;
self::$CheckTable['add']['article']['2']['f']	= function ($a) { return array ("SELECT config_id FROM ".$a['sqlTables']['article_config']." WHERE config_nom = '".$a['params']['config']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['article']['2']['c']	= "config_id";
self::$CheckTable['add']['article']['2']['v']	= "config_id";
self::$CheckTable['add']['article']['2']['m']	= "CLI_Article_C003";
self::$CheckTable['add']['article']['2']['p']	= "config";
self::$CheckTable['add']['article']['3']['d']	= 2;
self::$CheckTable['add']['article']['3']['f']	= function ($a) { if ( strlen($a['params']['creator']) == 0 ) { $a['params']['creator'] = $a['curent_user']; } return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['groupe_user']." gu, ".$a['sqlTables']['site_groupe']." sg WHERE user_login = '".$a['params']['creator']."' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['article']['3']['c']	= "user_id";
self::$CheckTable['add']['article']['3']['v']	= "user_id_creator";
self::$CheckTable['add']['article']['3']['m']	= "CLI_Article_C004";
self::$CheckTable['add']['article']['3']['p']	= "user";
self::$CheckTable['add']['article']['4']['d']	= 2;
self::$CheckTable['add']['article']['4']['f']	= function ($a) { if ( strlen($a['params']['validator']) == 0 ) { $a['params']['validator'] = $a['current_user']; } return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['groupe_user']." gu, ".$a['sqlTables']['site_groupe']." sg WHERE user_login = '".$a['params']['validator']."' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['article']['4']['c']	= "user_id";
self::$CheckTable['add']['article']['4']['v']	= "user_id_validator";
self::$CheckTable['add']['article']['4']['m']	= "CLI_Article_C005";
self::$CheckTable['add']['article']['4']['p']	= "user";
self::$CheckTable['add']['article']['5']['d']	= 2;
self::$CheckTable['add']['article']['5']['f']	= function ($a) { return array ("SELECT p.pres_id AS pres_id, p.pres_nom_generique AS pres_nom_generique FROM ".$a['sqlTables']['presentation']." p , ".$a['sqlTables']['theme_presentation']." lt WHERE p.pres_nom_generique = '".$a['params']['layout_generic_name']."' AND p.pres_id = lt.pres_id AND lt.theme_id = '".$a['Context']['theme_id']."';");};
self::$CheckTable['add']['article']['5']['c']	= "pres_nom_generique";
self::$CheckTable['add']['article']['5']['v']	= "pres_nom_generique";
self::$CheckTable['add']['article']['5']['m']	= "CLI_Article_C006";
self::$CheckTable['add']['article']['5']['p']	= "Presentation";

self::$CheckTable['update']['article']['0']['d']	= 2;
self::$CheckTable['update']['article']['0']['f']	= function ($a) { return array ("SELECT arti_id,arti_nom FROM ".$a['sqlTables']['article']." WHERE arti_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['article']['0']['c']	= "arti_id";
self::$CheckTable['update']['article']['0']['v']	= "arti_id";
self::$CheckTable['update']['article']['0']['m']	= "CLI_Article_U001";
self::$CheckTable['update']['article']['0']['p']	= "article";
self::$CheckTable['update']['article']['1']['d']	= 2;
self::$CheckTable['update']['article']['1']['f']	= function ($a) { return array ("SELECT bouclage_id FROM ".$a['sqlTables']['bouclage']." WHERE bouclage_nom = '".$a['params']['bouclage']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['article']['1']['c']	= "bouclage_id";
self::$CheckTable['update']['article']['1']['v']	= "bouclage_id";
self::$CheckTable['update']['article']['1']['m']	= "CLI_Article_U002";
self::$CheckTable['update']['article']['1']['p']	= "bouclage";
self::$CheckTable['update']['article']['2']['d']	= 2;
self::$CheckTable['update']['article']['2']['f']	= function ($a) { return array ("SELECT config_id FROM ".$a['sqlTables']['article_config']." WHERE config_nom = '".$a['params']['config']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['article']['2']['c']	= "config_id";
self::$CheckTable['update']['article']['2']['v']	= "config_id";
self::$CheckTable['update']['article']['2']['m']	= "CLI_Article_C003";
self::$CheckTable['update']['article']['2']['p']	= "config";
self::$CheckTable['update']['article']['3']['d']	= 2;
self::$CheckTable['update']['article']['3']['f']	= function ($a) { return array ("SELECT usr.pres_id AS pres_id, usr.pres_nom_generique AS pres_nom_generique FROM ".$a['sqlTables']['presentation']." usr , ".$a['sqlTables']['theme_presentation']." sp WHERE pres_nom_generique = '<A1>' AND usr.pres_id = sp.pres_id AND sp.theme_id = '<A2>';");};
self::$CheckTable['update']['article']['3']['c']	= "pres_nom_generique";
self::$CheckTable['update']['article']['3']['v']	= "pres_nom_generique";
self::$CheckTable['update']['article']['3']['m']	= "CLI_Article_C004";
self::$CheckTable['update']['article']['3']['p']	= "Presentation";

self::$CheckTable['delete']['article']['0']['d']	= 2;
self::$CheckTable['delete']['article']['0']['f']	= function ($a) { return array ("SELECT arti_id,arti_nom FROM ".$a['sqlTables']['article']." WHERE arti_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['delete']['article']['0']['c']	= "arti_id";
self::$CheckTable['delete']['article']['0']['v']	= "arti_id";
self::$CheckTable['delete']['article']['0']['m']	= "CLI_Article_D001";
self::$CheckTable['delete']['article']['0']['p']	= "article";

self::$CheckTable['link']['article']['0']['d']	= 2;
self::$CheckTable['link']['article']['0']['f']	= function ($a) { return array ("SELECT arti_id,arti_nom FROM ".$a['sqlTables']['article']." WHERE arti_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['link']['article']['0']['c']	= "arti_id";
self::$CheckTable['link']['article']['0']['v']	= "arti_id";
self::$CheckTable['link']['article']['0']['m']	= "CLI_Article_L001";
self::$CheckTable['link']['article']['0']['p']	= "article";
self::$CheckTable['link']['article']['1']['d']	= 2;
self::$CheckTable['link']['article']['1']['f']	= function ($a) { return array ("SELECT doc.docu_id AS docu_id, doc.docu_nom AS docu_nom FROM ".$a['sqlTables']['document']." doc , ".$a['sqlTables']['document_partage']." dp WHERE doc.docu_nom = '".$a['document']."' AND dp.docu_id = doc.docu_id AND dp.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['link']['article']['1']['c']	= "docu_id";
self::$CheckTable['link']['article']['1']['v']	= "docu_id";
self::$CheckTable['link']['article']['1']['m']	= "CLI_Article_L002";
self::$CheckTable['link']['article']['1']['p']	= "document";



//Category
self::$CheckTable['add']['category']['0']['d']	= 3;
self::$CheckTable['add']['category']['0']['f']	= function ($a) { return array ("SELECT cate_id FROM ".$a['sqlTables']['categorie']." WHERE site_id = '".$a['Context']['sw_id']."' AND cate_nom = '".$a['params']['name']."';");};
self::$CheckTable['add']['category']['0']['m']	= "CLI_Category_C001";
self::$CheckTable['add']['category']['1']['d']	= 1;
self::$CheckTable['add']['category']['1']['f']	= function ($a) { return array ("SELECT cate_id FROM ".$a['sqlTables']['categorie']." WHERE site_id = '".$a['Context']['sw_id']."' AND cate_nom = '".$a['params']['parent']."';");};
self::$CheckTable['add']['category']['1']['c']	= "cate_id";
self::$CheckTable['add']['category']['1']['v']	= "parent_id";
self::$CheckTable['add']['category']['1']['m']	= "CLI_Category_C002";
self::$CheckTable['add']['category']['1']['p']	= "parent category";
self::$CheckTable['add']['category']['2']['d']	= 2;
self::$CheckTable['add']['category']['2']['f']	= function ($a) { return array ("SELECT bouclage_id FROM ".$a['sqlTables']['bouclage']." WHERE bouclage_nom = '".$a['params']['deadline']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['category']['2']['c']	= "bouclage_id";
self::$CheckTable['add']['category']['2']['v']	= "deadline_id";
self::$CheckTable['add']['category']['2']['m']	= "CLI_Category_C003";
self::$CheckTable['add']['category']['2']['p']	= "deadline";
self::$CheckTable['add']['category']['3']['d']	= 2;
self::$CheckTable['add']['category']['3']['f']	= function ($a) { return array ("SELECT grp.groupe_nom, grp.groupe_id FROM ".$a['sqlTables']['groupe']." grp , ".$a['sqlTables']['site_groupe']." sg  WHERE sg.site_id = '".$a['Context']['sw_id']."' AND grp.groupe_nom = '".$a['params']['group_name']."' AND grp.groupe_id = sg.groupe_id;");};
self::$CheckTable['add']['category']['3']['c']	= "groupe_id";
self::$CheckTable['add']['category']['3']['v']	= "group_id";
self::$CheckTable['add']['category']['3']['m']	= "CLI_Category_C004";
self::$CheckTable['add']['category']['3']['p']	= "group";
self::$CheckTable['add']['category']['4']['d']	= 2;
self::$CheckTable['add']['category']['4']['f']	= function ($a) { return array ("SELECT langue_id FROM ".$a['sqlTables']['langues']." WHERE langue_639_3 = '".$a['params']['lang']."';");};
self::$CheckTable['add']['category']['4']['c']	= "langue_id";
self::$CheckTable['add']['category']['4']['v']	= "lang_id";
self::$CheckTable['add']['category']['4']['m']	= "CLI_Category_C005";
self::$CheckTable['add']['category']['4']['p']	= "language";


self::$CheckTable['update']['category']['0']['d']	= 2;
self::$CheckTable['update']['category']['0']['f']	= function ($a) { return array ("SELECT cate_id FROM ".$a['sqlTables']['categorie']." WHERE site_id = '".$a['Context']['sw_id']."' AND cate_nom = '".$a['params']['name']."';");};
self::$CheckTable['update']['category']['0']['c']	= "cate_id";
self::$CheckTable['update']['category']['0']['v']	= "cate_id";
self::$CheckTable['update']['category']['0']['m']	= "CLI_Category_C001";
self::$CheckTable['update']['category']['0']['p']	= "category";


// Checkpoint
self::$CheckTable['set']['checkpoint']['0']['d']	= 4;
self::$CheckTable['set']['checkpoint']['0']['f']	= function ($a) {
	$ret = 0;
	if (strlen($a['params']['name']) > 0 ) { $ret = 1; }
	return $ret;
};
self::$CheckTable['set']['checkpoint']['0']['m']	= "CLI_SetCheckpoint_S001";



// Content (for document)
self::$CheckTable['insert']['content']['0']['d']	= 2;
self::$CheckTable['insert']['content']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_nom FROM ".$a['sqlTables']['document']." WHERE docu_nom = '".$a['params']['into']."';");};
self::$CheckTable['insert']['content']['0']['c']	= "docu_id";
self::$CheckTable['insert']['content']['0']['v']	= "docu_id";
self::$CheckTable['insert']['content']['0']['m']	= "CLI_InsertContent_I001";
self::$CheckTable['insert']['content']['0']['p']	= "content";
self::$CheckTable['insert']['content']['1']['d']	= 2;
self::$CheckTable['insert']['content']['1']['f']	= function ($a) { return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['groupe_user']." gu, ".$a['sqlTables']['site_groupe']." sg WHERE usr.user_login = '".$a['params']['creator']."' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['insert']['content']['1']['c']	= "user_id";
self::$CheckTable['insert']['content']['1']['v']	= "creator_id";
self::$CheckTable['insert']['content']['1']['m']	= "CLI_InsertContent_I002";
self::$CheckTable['insert']['content']['1']['p']	= "user";
self::$CheckTable['insert']['content']['2']['d']	= 2;
self::$CheckTable['insert']['content']['2']['f']	= function ($a) { return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['groupe_user']." gu, ".$a['sqlTables']['site_groupe']." sg WHERE usr.user_login = '".$a['params']['validator']."' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['insert']['content']['2']['c']	= "user_id";
self::$CheckTable['insert']['content']['2']['v']	= "validator_id";
self::$CheckTable['insert']['content']['2']['m']	= "CLI_InsertContent_I002";
self::$CheckTable['insert']['content']['2']['p']	= "user";


// DeadLine
self::$CheckTable['add']['deadline']['0']['d']	= 3;
self::$CheckTable['add']['deadline']['0']['f']	= function ($a) { return array ("SELECT bouclage_id FROM ".$a['sqlTables']['bouclage']." WHERE bouclage_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['deadline']['0']['m']	= "CLI_Bouclage_C001";
self::$CheckTable['update']['deadline']['0']['d']	= 2;
self::$CheckTable['update']['deadline']['0']['f']	= function ($a) { return array ("SELECT bouclage_id FROM ".$a['sqlTables']['bouclage']." WHERE bouclage_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['deadline']['0']['c']	= "bouclage_id";
self::$CheckTable['update']['deadline']['0']['v']	= "bouclage_id";
self::$CheckTable['update']['deadline']['0']['m']	= "CLI_Bouclage_U001";
self::$CheckTable['update']['deadline']['0']['p']	= "bouclage";
self::$CheckTable['delete']['deadline']['0']['d']	= 2;
self::$CheckTable['delete']['deadline']['0']['f']	= function ($a) { return array ("SELECT bouclage_id FROM ".$a['sqlTables']['bouclage']." WHERE bouclage_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['delete']['deadline']['0']['c']	= "bouclage_id";
self::$CheckTable['delete']['deadline']['0']['v']	= "bouclage_id";
self::$CheckTable['delete']['deadline']['0']['m']	= "CLI_Bouclage_U001";
self::$CheckTable['delete']['deadline']['0']['p']	= "bouclage";


//Décoration
self::$CheckTable['add']['decoration']['0']['d']	= 3;
self::$CheckTable['add']['decoration']['0']['f']	= function ($a) { return array ("SELECT deco_nom FROM ".$a['sqlTables']['decoration']." WHERE deco_nom = '".$a['params']['name']."';");};
self::$CheckTable['add']['decoration']['0']['m']	= "CLI_Decoration_C001";


// Article_config
self::$CheckTable['add']['document_config']['0']['d']	= 3;
self::$CheckTable['add']['document_config']['0']['f']	= function ($a) { return array ("SELECT config_id FROM ".$a['sqlTables']['article_config']." WHERE config_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['document_config']['0']['m']	= "CLI_ArticleConfig_C001";


// Document
self::$CheckTable['add']['document']['0']['d']	= 3;
self::$CheckTable['add']['document']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_nom FROM ".$a['sqlTables']['document']." WHERE docu_nom = '".$a['params']['name']."';");};
self::$CheckTable['add']['document']['0']['m']	= "CLI_Document_C001";
self::$CheckTable['add']['document']['1']['d']	= 2;
self::$CheckTable['add']['document']['1']['f']	= function ($a) { return array ("SELECT usr.user_login,usr.user_id  FROM ".$a['sqlTables']['user']." usr , ".$a['sqlTables']['groupe_user']." gu , ".$a['sqlTables']['site_groupe']." sg WHERE usr.user_login = '".$a['params']['creator']."' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['document']['1']['c']	= "user_id";
self::$CheckTable['add']['document']['1']['v']	= "creator_user_id";
self::$CheckTable['add']['document']['1']['m']	= "CLI_Document_C002";
self::$CheckTable['add']['document']['1']['p']	= "user";
self::$CheckTable['add']['document']['2']['d']	= 2;
self::$CheckTable['add']['document']['2']['f']	= function ($a) { return array ("SELECT usr.user_login,usr.user_id  FROM ".$a['sqlTables']['user']." usr , ".$a['sqlTables']['groupe_user']." gu , ".$a['sqlTables']['site_groupe']." sg WHERE usr.user_login = '".$a['params']['validator']."' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['document']['2']['c']	= "user_id";
self::$CheckTable['add']['document']['2']['v']	= "validator_user_id";
self::$CheckTable['add']['document']['2']['m']	= "CLI_Document_C003";
self::$CheckTable['add']['document']['2']['p']	= "user";


self::$CheckTable['update']['document']['0']['d']	= 2;
self::$CheckTable['update']['document']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_nom FROM ".$a['sqlTables']['document']." WHERE docu_nom = '".$a['params']['name']."';");};
self::$CheckTable['update']['document']['0']['c'] = "docu_id";
self::$CheckTable['update']['document']['0']['v'] = "docu_id";
self::$CheckTable['update']['document']['0']['m'] = "CLI_Document_U001";
self::$CheckTable['update']['document']['0']['p'] = "document";
self::$CheckTable['update']['document']['1']['d']	= 2;
self::$CheckTable['update']['document']['1']['f']	= function ($a) { return array ("SELECT usr.user_login,usr.user_id  FROM ".$a['sqlTables']['user']." usr , ".$a['sqlTables']['groupe_user']." gu , ".$a['sqlTables']['site_groupe']." sg WHERE usr.user_login = '".$a['params']['validator']."' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['document']['1']['c']	= "validator_user_id";
self::$CheckTable['update']['document']['1']['v']	= "validator_user_id";
self::$CheckTable['update']['document']['1']['m']	= "CLI_Document_U003";
self::$CheckTable['update']['document']['1']['p']	= "user";


self::$CheckTable['delete']['document']['0']['d']	= 2;
self::$CheckTable['delete']['document']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_nom FROM ".$a['sqlTables']['document']." WHERE docu_nom = '".$a['params']['name']."';");};
self::$CheckTable['delete']['document']['0']['c'] = "groupe_id";
self::$CheckTable['delete']['document']['0']['v'] = "groupe_id";
self::$CheckTable['delete']['document']['0']['m'] = "CLI_Document_U001";
self::$CheckTable['delete']['document']['0']['p'] = "document";


self::$CheckTable['share']['document']['0']['d']	= 2;
self::$CheckTable['share']['document']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_nom FROM ".$a['sqlTables']['document']." WHERE docu_nom = '".$a['params']['name']."';");};
self::$CheckTable['share']['document']['0']['c'] 	= "docu_id";
self::$CheckTable['share']['document']['0']['v'] 	= "docu_id";
self::$CheckTable['share']['document']['0']['m'] 	= "CLI_ShareDocument_S001";
self::$CheckTable['share']['document']['0']['p'] 	= "document";
self::$CheckTable['share']['document']['1']['d']	= 2;
self::$CheckTable['share']['document']['1']['f']	= function ($a) { return array ("SELECT sw_id,sw_nom FROM ".$a['sqlTables']['site_web']." WHERE sw_nom = '".$a['params']['with_website']."';");};
self::$CheckTable['share']['document']['1']['c'] 	= "sw_id";
self::$CheckTable['share']['document']['1']['v'] 	= "site_id";
self::$CheckTable['share']['document']['1']['m'] 	= "CLI_ShareDocument_S002";
self::$CheckTable['share']['document']['1']['p'] 	= "website";
self::$CheckTable['share']['document']['2']['d'] 	= 3;
self::$CheckTable['share']['document']['2']['f'] 	= function ($a) { return array ("SELECT part_id FROM ".$a['sqlTables']['document_partage']." WHERE site_id = '".$a['params']['site_id']."' AND docu_id = '".$a['params']['docu_id']."';" ); };
self::$CheckTable['share']['document']['2']['m'] 	= "CLI_ShareDocument_S003";


self::$CheckTable['assign']['document']['0']['d']	= 2;
self::$CheckTable['assign']['document']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_nom FROM ".$a['sqlTables']['document']." WHERE docu_nom = '".$a['params']['name']."';");};
self::$CheckTable['assign']['document']['0']['c'] 	= "docu_id";
self::$CheckTable['assign']['document']['0']['v'] 	= "docu_id";
self::$CheckTable['assign']['document']['0']['m'] 	= "CLI_AssignDocument_A001";
self::$CheckTable['assign']['document']['0']['p'] 	= "document";
self::$CheckTable['assign']['document']['1']['d']	= 2;
self::$CheckTable['assign']['document']['1']['f']	= function ($a) { return array ("SELECT arti_id,arti_nom FROM ".$a['sqlTables']['article']." WHERE arti_nom = '".$a['params']['to_article']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['assign']['document']['1']['c']	= "arti_id";
self::$CheckTable['assign']['document']['1']['v']	= "arti_id";
self::$CheckTable['assign']['document']['1']['m']	= "CLI_AssignDocument_A002";
self::$CheckTable['assign']['document']['1']['p']	= "article";


// Group
self::$CheckTable['add']['group']['0']['d'] = 3;
self::$CheckTable['add']['group']['0']['f'] = function ($a) { return array ( "SELECT grp.groupe_id FROM ".$a['sqlTables']['groupe']." grp , ".$a['sqlTables']['site_groupe']." sg , ".$a['sqlTables']['site_web']." sw WHERE grp.groupe_nom = '".$a['params']['name']."' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$a['Context']['sw_id']."';" ); };
self::$CheckTable['add']['group']['0']['m'] = "CLI_group_C001";

self::$CheckTable['add']['group']['1']['d'] = 2;
self::$CheckTable['add']['group']['1']['f'] = function ($a) { if ($a['params']['parent'] != 'origin' ) { return array ( "SELECT grp.groupe_id FROM ".$a['sqlTables']['groupe']." grp , ".$a['sqlTables']['site_groupe']." sg , ".$a['sqlTables']['site_web']." sw WHERE grp.groupe_nom = '".$a['params']['parent']."' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$a['Context']['sw_id']."';" );} else { return -1; }};
self::$CheckTable['add']['group']['1']['c'] = "groupe_id";
self::$CheckTable['add']['group']['1']['v'] = "groupe_parent";
self::$CheckTable['add']['group']['1']['m'] = "CLI_group_C002";
self::$CheckTable['add']['group']['1']['p'] = "parent";

self::$CheckTable['update']['group']['0']['d'] = 2;
self::$CheckTable['update']['group']['0']['f'] = function ($a) { return array ( "SELECT grp.groupe_id FROM ".$a['sqlTables']['groupe']." grp , ".$a['sqlTables']['site_groupe']." sg , ".$a['sqlTables']['site_web']." sw WHERE grp.groupe_nom = '".$a['params']['name']."' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$a['Context']['sw_id']."';" ); };
self::$CheckTable['update']['group']['0']['c'] = "groupe_id";
self::$CheckTable['update']['group']['0']['v'] = "groupe_id";
self::$CheckTable['update']['group']['0']['m'] = "CLI_group_U001";
self::$CheckTable['update']['group']['1']['p'] = "group";

self::$CheckTable['update']['group']['1']['d'] = 2;
self::$CheckTable['update']['group']['1']['f'] = function ($a) { return array ( "SELECT grp.groupe_id FROM ".$a['sqlTables']['groupe']." grp , ".$a['sqlTables']['site_groupe']." sg , ".$a['sqlTables']['site_web']." sw WHERE grp.groupe_nom = '".$a['params']['name']."' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$a['Context']['sw_id']."';" ); };
self::$CheckTable['update']['group']['1']['c'] = "groupe_id";
self::$CheckTable['update']['group']['1']['v'] = "groupe_id_Parent";
self::$CheckTable['update']['group']['1']['m'] = "CLI_group_U002";

self::$CheckTable['delete']['group']['0']['d'] = 2;
self::$CheckTable['delete']['group']['0']['f'] = function ($a) { return array ( "SELECT grp.groupe_id FROM ".$a['sqlTables']['groupe']." grp , ".$a['sqlTables']['site_groupe']." sg , ".$a['sqlTables']['site_web']." sw WHERE grp.groupe_nom = '".$a['params']['name']."' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$a['Context']['sw_id']."';" ); };
self::$CheckTable['delete']['group']['0']['c'] = "groupe_id";
self::$CheckTable['delete']['group']['0']['v'] = "groupe_id";
self::$CheckTable['delete']['group']['0']['m'] = "CLI_group_D001";
self::$CheckTable['delete']['group']['1']['p'] = "group";


// KeyWord
self::$CheckTable['add']['keyword']['0']['d']	= 3;
self::$CheckTable['add']['keyword']['0']['f']	= function ($a) { return array ("SELECT mc_id FROM ".$a['sqlTables']['mot_cle']." WHERE mc_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['keyword']['0']['m']	= "CLI_KeyWord_C001";
self::$CheckTable['add']['keyword']['1']['d']	= 2;
self::$CheckTable['add']['keyword']['1']['f']	= function ($a) { return array ("SELECT arti_id,arti_nom FROM ".$a['sqlTables']['article']." WHERE arti_nom = '".$a['params']['article']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['keyword']['1']['c']	= "arti_id";
self::$CheckTable['add']['keyword']['1']['v']	= "arti_id";
self::$CheckTable['add']['keyword']['1']['m']	= "CLI_KeyWord_C002";
self::$CheckTable['add']['keyword']['1']['p']	= "article";


self::$CheckTable['update']['keyword']['0']['d']	= 2;
self::$CheckTable['update']['keyword']['0']['f']	= function ($a) { return array ("SELECT mc_id FROM ".$a['sqlTables']['mot_cle']." WHERE mc_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['keyword']['0']['c']	= "mc_id";
self::$CheckTable['update']['keyword']['0']['v']	= "mc_id";
self::$CheckTable['update']['keyword']['0']['m']	= "CLI_KeyWord_U002";
self::$CheckTable['update']['keyword']['0']['p']	= "keyword";
self::$CheckTable['update']['keyword']['1']['d']	= 2;
self::$CheckTable['update']['keyword']['1']['f']	= function ($a) { return array ("SELECT arti_id,arti_nom FROM ".$a['sqlTables']['article']." WHERE arti_nom = '".$a['params']['article']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['keyword']['1']['c']	= "arti_id";
self::$CheckTable['update']['keyword']['1']['v']	= "arti_id";
self::$CheckTable['update']['keyword']['1']['m']	= "CLI_KeyWord_U002";
self::$CheckTable['update']['keyword']['1']['p']	= "article";

self::$CheckTable['delete']['keyword']['0']['d']	= 2;
self::$CheckTable['delete']['keyword']['0']['f']	= function ($a) { return array ("SELECT mc_id FROM ".$a['sqlTables']['mot_cle']." WHERE mc_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['delete']['keyword']['0']['c']	= "mc_id";
self::$CheckTable['delete']['keyword']['0']['v']	= "mc_id";
self::$CheckTable['delete']['keyword']['0']['m']	= "CLI_KeyWord_D002";
self::$CheckTable['delete']['keyword']['0']['p']	= "keyword";


// Language (is not a entity in itself) 
self::$CheckTable['assign']['language']['0']['d']	= 2;
self::$CheckTable['assign']['language']['0']['f']	= function ($a) { return array ("SELECT sw_id,sw_nom FROM ".$a['sqlTables']['site_web']." WHERE sw_nom = '".$a['params']['to_website']."';");};
self::$CheckTable['assign']['language']['0']['c']	= "sw_id";
self::$CheckTable['assign']['language']['0']['v']	= "sw_id";
self::$CheckTable['assign']['language']['0']['m']	= "CLI_AddLang_A001";
self::$CheckTable['assign']['language']['0']['p']	= "site";
self::$CheckTable['assign']['language']['1']['d']	= 2;
self::$CheckTable['assign']['language']['1']['f']	= function ($a) { return array ( "SELECT langue_id FROM ".$a['sqlTables']['langues']." WHERE langue_639_3 = '".$a['params']['name']."'"); };
self::$CheckTable['assign']['language']['1']['c']	= "langue_id";
self::$CheckTable['assign']['language']['1']['v']	= "lang_id";
self::$CheckTable['assign']['language']['1']['m']	= "CLI_AddLang_A002";
self::$CheckTable['assign']['language']['1']['p']	= "language";

// Log
self::$CheckTable['add']['log']['0']['d']	= 4;
self::$CheckTable['add']['log']['0']['f']	= function ($a) { 
	$ret = 0;
	if (strlen($a['params']['s']) > 0 ) { $ret = 1; } // Signal is the minimum required.
	return $ret;
};
self::$CheckTable['add']['log']['0']['m']	= "CLI_AddLog_A001";


// Layout
self::$CheckTable['add']['layout']['0']['d']	= 3;
self::$CheckTable['add']['layout']['0']['f']	= function ($a) { return array ("SELECT pres_id,pres_nom FROM ".$a['sqlTables']['presentation']." WHERE pres_nom = '".$a['params']['name']."';");};
self::$CheckTable['add']['layout']['0']['m']	= "CLI_Layout_D001";

self::$CheckTable['update']['layout']['0']['d']	= 2;
self::$CheckTable['update']['layout']['0']['f']	= function ($a) { return array ("SELECT pres_id,pres_nom FROM ".$a['sqlTables']['presentation']." WHERE pres_nom = '".$a['params']['name']."';");};
self::$CheckTable['update']['layout']['0']['c']	= "pres_id";
self::$CheckTable['update']['layout']['0']['v']	= "pres_id";
self::$CheckTable['update']['layout']['0']['m']	= "CLI_Layout_U001";
self::$CheckTable['update']['layout']['0']['p']	= "layout";

self::$CheckTable['delete']['layout']['0']['d']	= 2;
self::$CheckTable['delete']['layout']['0']['f']	= function ($a) { return array ("SELECT pres_id,pres_nom FROM ".$a['sqlTables']['presentation']." WHERE pres_nom = '".$a['params']['name']."';");};
self::$CheckTable['delete']['layout']['0']['c']	= "pres_id";
self::$CheckTable['delete']['layout']['0']['v']	= "pres_id";
self::$CheckTable['delete']['layout']['0']['m']	= "CLI_Layout_D001";
self::$CheckTable['delete']['layout']['0']['p']	= "layout";

self::$CheckTable['assign']['layout']['0']['d']	= 2;
self::$CheckTable['assign']['layout']['0']['f']	= function ($a) { return array ("SELECT pres_id,pres_nom FROM ".$a['sqlTables']['presentation']." WHERE pres_nom = '".$a['params']['name']."';");};
self::$CheckTable['assign']['layout']['0']['c']	= "pres_id";
self::$CheckTable['assign']['layout']['0']['v']	= "pres_id";
self::$CheckTable['assign']['layout']['0']['m']	= "CLI_Layout_A001";
self::$CheckTable['assign']['layout']['0']['p']	= "layout";
self::$CheckTable['assign']['layout']['1']['d']	= 2;
self::$CheckTable['assign']['layout']['1']['f']	= function ($a) { return array ("SELECT sd.theme_id AS theme_id, sd.theme_nom AS theme_nom FROM ".$a['sqlTables']['theme_descripteur']." sd, ".$a['sqlTables']['site_theme']." ss WHERE sd.theme_nom = '".$a['params']['to_theme']."' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['assign']['layout']['1']['c']	= "theme_id";
self::$CheckTable['assign']['layout']['1']['v']	= "theme_id";
self::$CheckTable['assign']['layout']['1']['m']	= "CLI_Layout_A002";
self::$CheckTable['assign']['layout']['1']['p']	= "layout";


self::$CheckTable['add']['layout_content']['0']['d']	= 2;
self::$CheckTable['add']['layout_content']['0']['f']	= function ($a) { return array ("SELECT pres_id,pres_nom FROM ".$a['sqlTables']['presentation']." WHERE pres_nom = '".$a['params']['to_layout']."';");};
self::$CheckTable['add']['layout_content']['0']['c']	= "pres_id";
self::$CheckTable['add']['layout_content']['0']['v']	= "layout_id";
self::$CheckTable['add']['layout_content']['0']['m']	= "CLI_LayoutContent_C001";
self::$CheckTable['add']['layout_content']['0']['p']	= "layout";
// self::$CheckTable['add']['layout_content']['1']['d']	= 2;
// self::$CheckTable['add']['layout_content']['1']['f']	= function ($a) { return array ("SELECT mdl.module_id FROM ".$a['sqlTables']['module']." mdl , ".$a['sqlTables']['site_module']." sm WHERE mdl.module_nom = '".$a['params']['module']."' AND mdl.module_id = sm.module_id AND sm.site_id = '".$a['Context']['sw_id']."';");};
// self::$CheckTable['add']['layout_content']['1']['c']	= "module_id";
// self::$CheckTable['add']['layout_content']['1']['v']	= "module_id";
// self::$CheckTable['add']['layout_content']['1']['m']	= "CLI_LayoutContent_C002";
// self::$CheckTable['add']['layout_content']['1']['p']	= "layout";


// Module
self::$CheckTable['add']['module']['0']['d']	= 3;
self::$CheckTable['add']['module']['0']['f']	= function ($a) { return array ("SELECT mdl.module_id FROM ".$a['sqlTables']['module']." mdl , ".$a['sqlTables']['site_module']." sm WHERE mdl.module_nom = '".$a['params']['name']."' AND mdl.module_id = sm.module_id AND sm.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['module']['0']['m']	= "CLI_Module_C001";
self::$CheckTable['add']['module']['1']['d']	= 2;
self::$CheckTable['add']['module']['1']['f']	= function ($a) { return array ("SELECT grp.groupe_id AS groupe_id, grp.groupe_nom AS groupe_nom FROM ".$a['sqlTables']['groupe']." grp, ".$a['sqlTables']['site_groupe']." sg WHERE grp.groupe_nom = '".$a['params']['group_who_can_see']."' AND grp.groupe_id = sg.groupe_id AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['module']['1']['c']	= "groupe_id";
self::$CheckTable['add']['module']['1']['v']	= "group_allowed_to_see_id";
self::$CheckTable['add']['module']['1']['m']	= "CLI_Module_C002";
self::$CheckTable['add']['module']['1']['p']	= "user";
self::$CheckTable['add']['module']['2']['d']	= 2;
self::$CheckTable['add']['module']['2']['f']	= function ($a) { return array ("SELECT grp.groupe_id AS groupe_id, grp.groupe_nom AS groupe_nom FROM ".$a['sqlTables']['groupe']." grp, ".$a['sqlTables']['site_groupe']." sg WHERE grp.groupe_nom = '".$a['params']['group_who_can_use']."' AND grp.groupe_id = sg.groupe_id AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['module']['2']['c']	= "groupe_id";
self::$CheckTable['add']['module']['2']['v']	= "group_allowed_to_use_id";
self::$CheckTable['add']['module']['2']['m']	= "CLI_Module_C003";
self::$CheckTable['add']['module']['2']['p']	= "user";

self::$CheckTable['update']['module']['0']['d']	= 3;
self::$CheckTable['update']['module']['0']['f']	= function ($a) { return array ("SELECT mdl.module_id FROM ".$a['sqlTables']['module']." mdl , ".$a['sqlTables']['site_module']." sm WHERE mdl.module_nom = '".$a['params']['name']."' AND mdl.module_id = sm.module_id AND sm.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['module']['0']['m']	= "CLI_Module_U001";
self::$CheckTable['update']['module']['1']['d']	= 2;
self::$CheckTable['update']['module']['1']['f']	= function ($a) { return array ("SELECT grp.groupe_id AS groupe_id, grp.groupe_nom AS groupe_nom FROM ".$a['sqlTables']['groupe']." grp, ".$a['sqlTables']['site_groupe']." sg WHERE grp.groupe_nom = '".$a['params']['group_who_can_see']."' AND grp.groupe_id = sg.groupe_id AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['module']['1']['c']	= "groupe_id";
self::$CheckTable['update']['module']['1']['v']	= "group_allowed_to_see_id";
self::$CheckTable['update']['module']['1']['m']	= "CLI_Module_U002";
self::$CheckTable['update']['module']['1']['p']	= "user";
self::$CheckTable['update']['module']['2']['d']	= 2;
self::$CheckTable['update']['module']['2']['f']	= function ($a) { return array ("SELECT grp.groupe_id AS groupe_id, grp.groupe_nom AS groupe_nom FROM ".$a['sqlTables']['groupe']." grp, ".$a['sqlTables']['site_groupe']." sg WHERE grp.groupe_nom = '".$a['params']['group_who_can_use']."' AND grp.groupe_id = sg.groupe_id AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['module']['2']['c']	= "groupe_id";
self::$CheckTable['update']['module']['2']['v']	= "group_allowed_to_use_id";
self::$CheckTable['update']['module']['2']['m']	= "CLI_Module_U003";
self::$CheckTable['update']['module']['2']['p']	= "user";

self::$CheckTable['delete']['module']['0']['d']	= 2;
self::$CheckTable['delete']['module']['0']['f']	= function ($a) { return array ("SELECT mdl.module_id FROM ".$a['sqlTables']['module']." mdl , ".$a['sqlTables']['site_module']." sm WHERE mdl.module_nom = '".$a['params']['name']."' AND mdl.module_id = sm.module_id AND sm.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['delete']['module']['0']['c']	= "module_id";
self::$CheckTable['delete']['module']['0']['v']	= "module_id";
self::$CheckTable['delete']['module']['0']['m']	= "CLI_Module_D001";
self::$CheckTable['delete']['module']['0']['p']	= "module";


// Tag
// Usage de BINARY à cause de la collation : utf8mb4_general_ci
// https://stackoverflow.com/questions/5629111/how-can-i-make-sql-case-sensitive-string-comparison-on-mysql
// http://mysqlserverteam.com/new-collations-in-mysql-8-0-0/
self::$CheckTable['add']['tag']['0']['d']	= 3;
self::$CheckTable['add']['tag']['0']['f']	= function ($a) { return array ("SELECT tag_id,tag_nom FROM ".$a['sqlTables']['tag']." WHERE BINARY tag_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['tag']['0']['m']	= "CLI_Tag_C001";

self::$CheckTable['assign']['tag']['0']['d']	= 2;
self::$CheckTable['assign']['tag']['0']['f']	= function ($a) { return array ("SELECT tag_id,tag_nom FROM ".$a['sqlTables']['tag']." WHERE BINARY tag_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['assign']['tag']['0']['c']	= "tag_id";
self::$CheckTable['assign']['tag']['0']['v']	= "tag_id";
self::$CheckTable['assign']['tag']['0']['m']	= "CLI_Tag_A001";
self::$CheckTable['assign']['tag']['0']['p']	= "tag";
self::$CheckTable['assign']['tag']['1']['d']	= 2;
self::$CheckTable['assign']['tag']['1']['f']	= function ($a) { return array ("SELECT arti_id,arti_nom FROM ".$a['sqlTables']['article']." WHERE arti_nom = '".$a['params']['article']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['assign']['tag']['1']['c']	= "arti_id";
self::$CheckTable['assign']['tag']['1']['v']	= "arti_id";
self::$CheckTable['assign']['tag']['1']['m']	= "CLI_Tag_A002";
self::$CheckTable['assign']['tag']['1']['p']	= "article";
self::$CheckTable['assign']['tag']['2']['d']	= 3;
self::$CheckTable['assign']['tag']['2']['f']	= function ($a) { return array ("SELECT tag_id FROM ".$a['sqlTables']['article_tag']." WHERE tag_id = '".$a['params']['tag_id']."' AND arti_id = '".$a['params']['arti_id']."';");};
self::$CheckTable['assign']['tag']['2']['m']	= "CLI_Tag_A003";
self::$CheckTable['assign']['tag']['2']['p']	= "link";

self::$CheckTable['delete']['tag']['0']['d']	= 2;
self::$CheckTable['delete']['tag']['0']['f']	= function ($a) { return array ("SELECT tag_id,tag_nom FROM ".$a['sqlTables']['tag']." WHERE BINARY tag_nom = '".$a['params']['name']."' AND site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['delete']['tag']['0']['c']	= "tag_id";
self::$CheckTable['delete']['tag']['0']['v']	= "tag_id";
self::$CheckTable['delete']['tag']['0']['m']	= "CLI_Tag_U001";
self::$CheckTable['delete']['tag']['0']['p']	= "tag";


// Theme
self::$CheckTable['add']['theme']['0']['d']	= 3;
self::$CheckTable['add']['theme']['0']['f']	= function ($a) { return array ("SELECT sd.theme_id, sd.theme_nom FROM ".$a['sqlTables']['theme_descripteur']." sd, ".$a['sqlTables']['site_theme']." ss WHERE sd.theme_nom = '".$a['params']['name']."' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['theme']['0']['m']	= "CLI_Theme_C001";

self::$CheckTable['update']['theme']['0']['d']	= 2;
self::$CheckTable['update']['theme']['0']['f']	= function ($a) { return array ("SELECT sd.theme_id, sd.theme_nom FROM ".$a['sqlTables']['theme_descripteur']." sd, ".$a['sqlTables']['site_theme']." ss WHERE sd.theme_nom = '".$a['params']['name']."' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['theme']['0']['c']	= "theme_id";
self::$CheckTable['update']['theme']['0']['v']	= "theme_id";
self::$CheckTable['update']['theme']['0']['m']	= "CLI_Theme_U001";
self::$CheckTable['update']['theme']['0']['p']	= "theme";
self::$CheckTable['delete']['theme']['0']['d']	= 2;
self::$CheckTable['delete']['theme']['0']['f']	= function ($a) { return array ("SELECT sd.theme_id, sd.theme_nom FROM ".$a['sqlTables']['theme_descripteur']." sd, ".$a['sqlTables']['site_theme']." ss WHERE sd.theme_nom = '".$a['params']['name']."' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['delete']['theme']['0']['c']	= "theme_id";
self::$CheckTable['delete']['theme']['0']['v']	= "theme_id";
self::$CheckTable['delete']['theme']['0']['m']	= "CLI_Theme_D001";
self::$CheckTable['delete']['theme']['0']['p']	= "theme";


self::$CheckTable['assign']['theme']['0']['d']	= 2;
self::$CheckTable['assign']['theme']['0']['f']	= function ($a) { return array ("SELECT sd.theme_id, sd.theme_nom FROM ".$a['sqlTables']['theme_descripteur']." sd, ".$a['sqlTables']['site_theme']." ss WHERE sd.theme_nom = '".$a['params']['name']."' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['assign']['theme']['0']['c']	= "theme_id";
self::$CheckTable['assign']['theme']['0']['v']	= "theme_id";
self::$CheckTable['assign']['theme']['0']['m']	= "CLI_AssignTheme_A001";
self::$CheckTable['assign']['theme']['0']['p']	= "theme";
self::$CheckTable['assign']['theme']['1']['d']	= 2;
self::$CheckTable['assign']['theme']['1']['f']	= function ($a) { return array ("SELECT * FROM ".$a['sqlTables']["site_web"]." WHERE sw_nom = '".$a['params']['to_website']."' ;");};
self::$CheckTable['assign']['theme']['1']['c']	= "sw_id";
self::$CheckTable['assign']['theme']['1']['v']	= "sw_id";
self::$CheckTable['assign']['theme']['1']['m']	= "CLI_AssignTheme_A002";
self::$CheckTable['assign']['theme']['1']['p']	= "site";


// Translation
self::$CheckTable['add']['translation']['0']['d']	= 2;
self::$CheckTable['add']['translation']['0']['f']	= function ($a) { return array ( "SELECT langue_id FROM ".$a['sqlTables']['langues']." WHERE langue_639_3 = '".$a['params']['lang']."'"); };
self::$CheckTable['add']['translation']['0']['c']	= "langue_id";
self::$CheckTable['add']['translation']['0']['v']	= "lang_id";
self::$CheckTable['add']['translation']['0']['m']	= "CLI_Translation_C001";
self::$CheckTable['add']['translation']['0']['p']	= "language";
self::$CheckTable['add']['translation']['1']['d']	= 3;
self::$CheckTable['add']['translation']['1']['f']	= function ($a) { return array ("SELECT * FROM ".$a['sqlTables']['i18n']." WHERE lang_id = '".$a['params']['lang_id']."' AND i18n_package = '".$a['params']['package']."' AND i18n_name = '".$a['params']['name']."';");};
self::$CheckTable['add']['translation']['1']['m']	= "CLI_Translation_C002";


// User
self::$CheckTable['add']['user']['0']['d']	= 3;
self::$CheckTable['add']['user']['0']['f']	= function ($a) { return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['groupe_user']." gu, ".$a['sqlTables']['site_groupe']." sg WHERE usr.user_login = '".$a['params']['name']."' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['add']['user']['0']['m']	= "CLI_User_C001";
self::$CheckTable['add']['user']['1']['d']	= 2;
self::$CheckTable['add']['user']['1']['f']	= function ($a) { return array ( "SELECT grp.groupe_id FROM ".$a['sqlTables']['groupe']." grp , ".$a['sqlTables']['site_groupe']." sg , ".$a['sqlTables']['site_web']." sw WHERE grp.groupe_nom = 'reader' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$a['Context']['sw_id']."';" ); };
self::$CheckTable['add']['user']['1']['c']	= "groupe_id";
self::$CheckTable['add']['user']['1']['v']	= "reader_id";
self::$CheckTable['add']['user']['1']['m']	= "CLI_User_C002";
self::$CheckTable['add']['user']['1']['p']	= "group";
self::$CheckTable['add']['user']['2']['d']	= 2;
self::$CheckTable['add']['user']['2']['f']	= function ($a) { return array ( "SELECT grp.groupe_id FROM ".$a['sqlTables']['groupe']." grp , ".$a['sqlTables']['site_groupe']." sg , ".$a['sqlTables']['site_web']." sw WHERE grp.groupe_nom = 'anonymous' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$a['Context']['sw_id']."';" ); };
self::$CheckTable['add']['user']['2']['c']	= "groupe_id";
self::$CheckTable['add']['user']['2']['v']	= "anonymous_id";
self::$CheckTable['add']['user']['2']['m']	= "CLI_User_C003";
self::$CheckTable['add']['user']['2']['p']	= "group";


self::$CheckTable['update']['user']				= self::$CheckTable['add']['user'];		// It's a copy not a reference!
self::$CheckTable['update']['user']['0']['d']	= 2;
self::$CheckTable['update']['user']['0']['c']	= "user_id";
self::$CheckTable['update']['user']['0']['v']	= "id";
self::$CheckTable['update']['user']['0']['m']	= "CLI_User_U001";
self::$CheckTable['update']['user']['2']['p']	= "user";


self::$CheckTable['update']['user']['1']['m']	= "CLI_User_U002";
self::$CheckTable['update']['user']['2']['m']	= "CLI_User_U003";

self::$CheckTable['update']['user']['3']['d']	= 2;
self::$CheckTable['update']['user']['3']['f']	= function ($a) { return array ("SELECT t.theme_id, t.theme_nom FROM ".$a['sqlTables']['theme_descripteur']." t, ".$a['sqlTables']['site_theme']." st WHERE t.theme_nom = '".$a['params']['pref_theme']."' AND t.theme_id = st.theme_id AND st.theme_etat = '1' AND st.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['update']['user']['3']['c']	= "theme_id";
self::$CheckTable['update']['user']['3']['v']	= "pref_theme_id";
self::$CheckTable['update']['user']['3']['m']	= "CLI_User_U004";
self::$CheckTable['update']['user']['3']['p']	= "theme";


self::$CheckTable['assign']['user']['0']['d']	= 2;
self::$CheckTable['assign']['user']['0']['f']	= function ($a) { return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['groupe_user']." gu, ".$a['sqlTables']['site_groupe']." sg WHERE usr.user_login = '".$a['params']['name']."' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$a['Context']['sw_id']."';");};
self::$CheckTable['assign']['user']['0']['c']	= "user_id";
self::$CheckTable['assign']['user']['0']['v']	= "user_id";
self::$CheckTable['assign']['user']['0']['m']	= "CLI_User_A001";
self::$CheckTable['assign']['user']['0']['p']	= "user";
self::$CheckTable['assign']['user']['1']['d']	= 2;
self::$CheckTable['assign']['user']['1']['f']	= function ($a) { return array ( "SELECT grp.groupe_id FROM ".$a['sqlTables']['groupe']." grp , ".$a['sqlTables']['site_groupe']." sg , ".$a['sqlTables']['site_web']." sw WHERE grp.groupe_nom = '".$a['params']['to_group']."' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$a['Context']['sw_id']."';" ); };
self::$CheckTable['assign']['user']['1']['c']	= "groupe_id";
self::$CheckTable['assign']['user']['1']['v']	= "groupe_id";
self::$CheckTable['assign']['user']['1']['m']	= "CLI_User_A002";
self::$CheckTable['assign']['user']['1']['p']	= "group";
self::$CheckTable['assign']['user']['2']['d']	= 3;
self::$CheckTable['assign']['user']['2']['f']	= function ($a) { return array ( "SELECT groupe_user_id, groupe_id, user_id, groupe_premier FROM ".$a['sqlTables']['groupe_user']." WHERE groupe_id = '".$a['group_id']."' AND user_id = '".$a['user_id']."';" ); };
self::$CheckTable['assign']['user']['2']['c']	= "groupe_user_id";
self::$CheckTable['assign']['user']['2']['v']	= "groupe_user_id";
self::$CheckTable['assign']['user']['2']['m']	= "CLI_User_A003";
self::$CheckTable['assign']['user']['2']['p']	= "link";


// ?? Var ??
// self::$CheckTable['set']['variable']['0']['d']	= 2;
// self::$CheckTable['set']['variable']['0']['f']	= function ($a) { return array ("");};
// self::$CheckTable['set']['variable']['0']['c']	= "_id";
// self::$CheckTable['set']['variable']['0']['v']	= "_id";
// self::$CheckTable['set']['variable']['0']['m']	= "CLI_Variable_S001";
// self::$CheckTable['set']['variable']['0']['p']	= "";


// WebSite
self::$CheckTable['add']['website']['0']['d']	= 3;
self::$CheckTable['add']['website']['0']['f']	= function ($a) { return array ("SELECT sw_id,sw_nom FROM ".$a['sqlTables']['site_web']." WHERE sw_nom = '".$a['params']['name']."';");};
self::$CheckTable['add']['website']['0']['m']	= "CLI_Website_C001";
self::$CheckTable['add']['website']['1']['d']	= 2;
self::$CheckTable['add']['website']['1']['f']	= function ($a) { return array ( "SELECT langue_id FROM ".$a['sqlTables']['langues']." WHERE langue_639_3 = '".$a['params']['lang']."'"); };
self::$CheckTable['add']['website']['1']['c']	= "langue_id";
self::$CheckTable['add']['website']['1']['v']	= "lang_id";
self::$CheckTable['add']['website']['1']['m']	= "CLI_Website_C002";
self::$CheckTable['add']['website']['1']['p']	= "language";

self::$CheckTable['update']['website']['0']['d']	= 2;
self::$CheckTable['update']['website']['0']['f']	= function ($a) { return array ("SELECT sw_id,sw_nom FROM ".$a['sqlTables']['site_web']." WHERE sw_nom = '".$a['params']['name']."';");};
self::$CheckTable['update']['website']['0']['c']	= "sw_id";
self::$CheckTable['update']['website']['0']['v']	= "sw_id";
self::$CheckTable['update']['website']['0']['m']	= "CLI_Website_U001";
self::$CheckTable['update']['website']['0']['p']	= "site";
self::$CheckTable['update']['website']['2']['d']	= 1;
self::$CheckTable['update']['website']['2']['f']	= function ($a) { return array ( "SELECT langue_id FROM ".$a['sqlTables']['langues']." WHERE langue_639_3 = '".$a['params']['lang']."';"); };
self::$CheckTable['update']['website']['2']['c']	= "langue_id";
self::$CheckTable['update']['website']['2']['v']	= "lang_id";
self::$CheckTable['update']['website']['2']['m']	= "CLI_Website_U002";
self::$CheckTable['update']['website']['2']['p']	= "language";

// Variable
self::$CheckTable['set']['variable']['0']['d']	= 4;
self::$CheckTable['set']['variable']['0']['f']	= function ($a) {
		$ret = 0;
		$tab = array("installMonitor","DebugLevel_SQL","DebugLevel_CC","DebugLevel_PHP","DebugLevel_JS","LogTarget");
		foreach ( $tab as $var ) {
			if ( $var == $a['params']['name'] ) { $ret = 1; }
		}
		return $ret;
};
self::$CheckTable['set']['variable']['0']['m']	= "CLI_SetVariable_S001";


// Site Context
self::$CheckTable['website']['context']['0']['d']	= 2;
self::$CheckTable['website']['context']['0']['f']	= function ($a) { return array ("SELECT * FROM ".$a['sqlTables']["site_web"]." WHERE sw_nom = '".$a['params']['name']."' ;");};
self::$CheckTable['website']['context']['0']['c']	= "sw_id";
self::$CheckTable['website']['context']['0']['v']	= "sw_id";
self::$CheckTable['website']['context']['0']['m']	= "CLI_Context_001";
self::$CheckTable['website']['context']['0']['p']	= "site";


// self::$CheckTable['']['']['0']['d']	= 2;
// self::$CheckTable['']['']['0']['f']	= function ($a) { return array ("");};
// self::$CheckTable['']['']['0']['c']	= "_id";
// self::$CheckTable['']['']['0']['v']	= "_id";
// self::$CheckTable['']['']['0']['m']	= "CLI__001";
// self::$CheckTable['']['']['0']['p']	= "";



?>