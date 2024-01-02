<?php
//--------------------------------------------------------------------------------
//	Add
//--------------------------------------------------------------------------------
self::$ActionTable['add']['article']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['article']." (".$a['columns'].") VALUES (".$a['values'].");");};
self::$ActionTable['add']['article_config']		= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['article_config']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['deadline']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['deadline']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['decoration']			= function (&$a) {
	switch ( $a['params']['type']) {
		case 10:	$targetTable = "deco_10_menu";			$idv="10_id";	break;
		case 20:	$targetTable = "deco_20_caligraph";		$idv="20_id";	break;
		case 30:	$targetTable = "deco_30_1_div";			$idv="30_id";	break;
		case 40:	$targetTable = "deco_40_elegance";		$idv="40_id";	break;
		case 50:	$targetTable = "deco_50_exquisite";		$idv="50_id";	break;
		case 60:	$targetTable = "deco_60_elysion";		$idv="60_id";	break;
	}
	
	$vl = &$a['listVars'][$a['params']['type']];
	$a['values2'] = "";
	$l = &$a['params'][$idv];

	foreach ( $vl as $V ) {
// 		if (strlen($a['params'][$V])!=0 || $a['params'][$V]!=0) {
		if (strlen($a['params'][$V])!=0) {
			$a['values2'] .= "('".$l."','".$a['params']['id']."','".$V."','".$a['params'][$V]."'),";
			$l++;
		}
	}
	$a['values2'] = substr($a['values2'], 0 , -1);
	$a['columns2'] = "deco_line_number, fk_deco_id, deco_variable_name, deco_value";
	
	return array (
		"INSERT INTO ".$a['sqlTables']['decoration']." (".$a['columns'].") VALUES (".$a['values'].");",
		"INSERT INTO ".$a['sqlTables'][$targetTable]." (".$a['columns2'].") VALUES ".$a['values2'].";",
	);
};


self::$ActionTable['add']['document']		= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['document']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['group'] = function (&$a) { return array (
		"INSERT INTO ".$a['sqlTables']['group']." (".$a['columns'].") VALUES (".$a['values'].");",
		"INSERT INTO ".$a['sqlTables']['group_website']." VALUES ('".$a['params']['group_webws_id']."', '".$a['Context']['ws_id']."', '".$a['params']['id']."', '1' );"
	);
};

self::$ActionTable['add']['keyword']		= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['keyword']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['layout']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['layout']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['layout_file']		= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['layout_file']." (".$a['columns'].") VALUES (".$a['values'].");");};

// self::$ActionTable['add']['layout_content']	= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['layout_content']." (".$a['columns'].") VALUES (".$a['values'].");");};


self::$ActionTable['add']['log']	= function (&$a) { 
	$bts = BaseToolSet::getInstance();
// 	$LMObj = LogManagement::getInstance();
	$bts->LMObj->msgLog($a);
};


self::$ActionTable['add']['menu']				= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['menu']." (".$a['columns'].") VALUES (".$a['values'].");");};


self::$ActionTable['add']['module'] = function (&$a) { return array (
		"INSERT INTO ".$a['sqlTables']['module']." (".$a['columns'].") VALUES (".$a['values'].");",
		"INSERT INTO ".$a['sqlTables']['module_website']." VALUES ('".$a['params']['module_website_id']."', '".$a['Context']['ws_id']."', '".$a['params']['id']."', '".$a['params']['state']."', '".$a['params']['position']."' );"
	);
};

self::$ActionTable['add']['permission'] = function (&$a) { return array (
	"INSERT INTO ".$a['sqlTables']['permission']." (".$a['columns'].") VALUES (".$a['values'].");",
	);
};


self::$ActionTable['add']['tag']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['tag']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['theme']			= function (&$a) { return array (
		"INSERT INTO ".$a['sqlTables']['theme_descriptor']." (".$a['columns'].") VALUES (".$a['values'].");",
		"INSERT INTO ".$a['sqlTables']['theme_website']." (theme_website_id, fk_ws_id, fk_theme_id, theme_state) VALUES ('".$a['params']['theme_website_id']."','".$a['Context']['ws_id']."','".$a['params']['id']."','".$a['params']['state']."');");
};


self::$ActionTable['add']['translation']	= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['i18n']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['user']			= function (&$a) { 
	$queries = array();
	$b=1;
	$c=1;
	$queries[] = "INSERT INTO ".$a['sqlTables']['user']." (".$a['columns'].") VALUES (".$a['values'].");";
	if ($a['params']['name'] != "anonymous") {
		$queries[] = "INSERT INTO ".$a['sqlTables']['group_user']." VALUES ('".($a['params']['group_user_id']+$b)."','".$a['params']['reader_id']."','".$a['params']['id']."','1');";
		$b++;
		$c=0;
	}
	$queries[] = "INSERT INTO ".$a['sqlTables']['group_user']." VALUES ('".($a['params']['group_user_id']+$b)."','".$a['params']['anonymous_id']."','".$a['params']['id']."','".$c."');";
	return $queries;
};


self::$ActionTable['add']['website']		= function (&$a) {
	$CurrentSetObj = CurrentSet::getInstance();
	$CurrentSetObj->setDataSubEntry('install', 'websitePostCreation', 1 );
	return array ("INSERT INTO ".$a['sqlTables']['website']." (".$a['columns'].") VALUES (".$a['values'].");");
};

//--------------------------------------------------------------------------------
//	Update
//--------------------------------------------------------------------------------
self::$ActionTable['update']['article']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['article']." SET ".$a['equalities']." WHERE arti_id = '".$a['params']['arti_id']."';"); };
self::$ActionTable['update']['article_config']	= function (&$a) { return array ("UPDATE ".$a['sqlTables']['article_config']." SET ".$a['equalities']." WHERE config_id = '".$a['params']['config_id']."';"); };

self::$ActionTable['update']['deadline']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['deadline']." SET ".$a['equalities']." WHERE deadline_id = '".$a['params']['deadline_id']."';"); };

self::$ActionTable['update']['document']		= function (&$a) {
	if ($a['params']['updateGO'] == 1 ) { 
		$arr = array ("UPDATE ".$a['sqlTables']['document']." SET ".$a['equalities']." WHERE docu_id = '".$a['params']['docu_id']."';");
		if (is_numeric($a['params']['modification']) ) {
			$arr[] = "UPDATE ".$a['sqlTables']['document_share']." SET share_modification='".$a['params']['modification']."' WHERE fk_docu_id = '".$a['params']['docu_id']."' AND fk_ws_id = '".$a['Context']['ws_id']."';";
		}
		return ($arr);
	}
	else { return array ("SELECT 'Nothing to do';"); }
};

self::$ActionTable['update']['group']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['group']			." SET ".$a['equalities']." WHERE group_id = '"			.$a['params']['group_id']."';"); };
self::$ActionTable['update']['keyword']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['keyword']		." SET ".$a['equalities']." WHERE keyword_id = '"		.$a['params']['keyword_id']."';"); };
self::$ActionTable['update']['layout']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['layout']		." SET ".$a['equalities']." WHERE layout_id = '"		.$a['params']['layout_id']."';"); };
self::$ActionTable['update']['layout_file']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['layout_file']	." SET ".$a['equalities']." WHERE layout_file_id = '"	.$a['params']['layout_file_id']."';"); };
self::$ActionTable['update']['menu']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['menu']			." SET ".$a['equalities']." WHERE menu_id = '"			.$a['params']['menu_id']."';"); };
self::$ActionTable['update']['module']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['module']		." SET ".$a['equalities']." WHERE module_id = '"		.$a['params']['module_id']."';"); };
self::$ActionTable['update']['permission']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['permission']	." SET ".$a['equalities']." WHERE permission_id = '"	.$a['params']['permission_id']."';"); };
self::$ActionTable['update']['tag']				= function (&$a) { return array ("UPDATE ".$a['sqlTables']['tag']			." SET ".$a['equalities']." WHERE tag_id = '"			.$a['params']['tag_id']."';"); };
self::$ActionTable['update']['theme']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['theme']			." SET ".$a['equalities']." WHERE theme_id = '"			.$a['params']['theme_id']."';"); };
self::$ActionTable['update']['translation']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['translation']	." SET ".$a['equalities']." WHERE translation_id = '"	.$a['params']['translation_id']."';"); };
self::$ActionTable['update']['user']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['user']			." SET ".$a['equalities']." WHERE user_id = '"			.$a['params']['user_id']."';"); };

self::$ActionTable['update']['website']		= function (&$a) {
	$queries = array();
	if ($a['params']['updateGO'] == 1 ) { 
		$queries[] = "UPDATE ".$a['sqlTables']['website']." SET ".$a['equalities']." WHERE ws_id = '".$a['params']['ws_id']."';";
	}
	return $queries;
};


//--------------------------------------------------------------------------------
//	Disable state=>0 (it's NOT delete)
//--------------------------------------------------------------------------------
self::$ActionTable['disable']['article']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['article']		." SET article_state=0		WHERE article_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['disable']['article_config']	= function (&$a) { return array ("UPDATE ".$a['sqlTables']['article_config']." SET config_state=0		WHERE config_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['disable']['deadline']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['deadline']		." SET deadline_state=0 	WHERE deadline_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['disable']['document']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['document']		." SET docu_state=0			WHERE docu_id = '"			.$a['params']['id']."';"); };
self::$ActionTable['disable']['group']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['group']			." SET group_state=0		WHERE group_id = '"			.$a['params']['id']."';"); };
self::$ActionTable['disable']['keyword']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['keyword']		." SET keyword_state=0		WHERE keyword_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['disable']['layout']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['layout']		." SET layout_state=0		WHERE layout_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['disable']['layout_file']	= function (&$a) { return array ("UPDATE ".$a['sqlTables']['layout_file']	." SET layout_file_state=0	WHERE layout_file_id = '"	.$a['params']['id']."';"); };
self::$ActionTable['disable']['menu']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['menu']			." SET menu_state=0			WHERE menu_id = '"			.$a['params']['id']."';"); };
//self::$ActionTable['disable']['module']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['module']		." SET module_state=0		WHERE module_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['disable']['permission']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['permission']	." SET permission_state=0	WHERE permission_id = '"	.$a['params']['id']."';"); };
self::$ActionTable['disable']['tag']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['tag']			." SET tag_state=0			WHERE tag_id = '"			.$a['params']['id']."';"); };
self::$ActionTable['disable']['theme']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['theme']			." SET theme_state=0		WHERE theme_id = '"			.$a['params']['id']."';"); };
self::$ActionTable['disable']['translation']	= function (&$a) { return array ("UPDATE ".$a['sqlTables']['translation']	." SET translation_state=0	WHERE translation_id = '"	.$a['params']['id']."';"); };
self::$ActionTable['disable']['user']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['user']			." SET user_state=0			WHERE user_id = '"			.$a['params']['id']."';"); };
self::$ActionTable['disable']['website']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['website']		." SET ws_state=0			WHERE ws_id = '"			.$a['params']['id']."';"); };


//--------------------------------------------------------------------------------
//	Delete state=>2
//--------------------------------------------------------------------------------
self::$ActionTable['delete']['article']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['article']		." SET article_state=2		WHERE article_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['delete']['article_config']	= function (&$a) { return array ("UPDATE ".$a['sqlTables']['article_config']." SET config_state=2		WHERE config_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['delete']['deadline']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['deadline']		." SET deadline_state=2 	WHERE deadline_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['delete']['document']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['document']		." SET docu_state=2			WHERE docu_id = '"			.$a['params']['id']."';"); };
self::$ActionTable['delete']['group']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['group']			." SET group_state=2		WHERE group_id = '"			.$a['params']['id']."';"); };
self::$ActionTable['delete']['keyword']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['keyword']		." SET keyword_state=2		WHERE keyword_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['delete']['layout']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['layout']		." SET layout_state=2		WHERE layout_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['delete']['layout_file']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['layout_file']	." SET layout_file_state=2	WHERE layout_file_id = '"	.$a['params']['id']."';"); };
self::$ActionTable['delete']['menu']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['menu']			." SET menu_state=2			WHERE menu_id = '"			.$a['params']['id']."';"); };
//self::$ActionTable['delete']['module']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['module']		." SET module_state=2		WHERE module_id = '"		.$a['params']['id']."';"); };
self::$ActionTable['delete']['permission']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['permission']	." SET permission_state=2	WHERE permission_id = '"	.$a['params']['id']."';"); };
self::$ActionTable['delete']['tag']				= function (&$a) { return array ("UPDATE ".$a['sqlTables']['tag']			." SET tag_state=2			WHERE tag_id = '"			.$a['params']['id']."';"); };
self::$ActionTable['delete']['theme']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['theme']			." SET theme_state=2		WHERE theme_id = '"			.$a['params']['id']."';"); };
self::$ActionTable['delete']['translation']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['translation']	." SET translation_state=2	WHERE translation_id = '"	.$a['params']['id']."';"); };
self::$ActionTable['delete']['user']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['user']			." SET user_state=2			WHERE user_id = '"			.$a['params']['id']."';"); };
self::$ActionTable['delete']['website']			= function (&$a) { return array ("UPDATE ".$a['sqlTables']['website']		." SET ws_state=2			WHERE ws_id = '"			.$a['params']['id']."';"); };


//--------------------------------------------------------------------------------
//	Assign
//--------------------------------------------------------------------------------
self::$ActionTable['assign']['document']		= function (&$a) {
	return array ("UPDATE ".$a['sqlTables']['article']." SET fk_docu_id = '".$a['params']['docu_id']."' WHERE arti_id = '".$a['params']['arti_id']."';");
};

self::$ActionTable['assign']['language']		= function (&$a) {
	return array ("INSERT INTO ".$a['sqlTables']['language_website']." VALUES ('".$a['params']['lang_website_id']."', '".$a['params']['ws_id']."', '".$a['params']['lang_id']."');");
};

	
self::$ActionTable['assign']['layout']		= function (&$a) {
	$queries = array();
	if ( $a['params']['default'] == 1 ) {
		$queries[] = "UPDATE ".$a['sqlTables']['layout_theme']." SET default_layout_content = '0' WHERE fk_theme_id = '".$a['params']['theme_id']."';";
	}
	$queries[] = "INSERT INTO ".$a['sqlTables']['layout_theme']." VALUES ('".$a['params']['layout_theme_id']."','".$a['params']['theme_id']."','".$a['params']['layout_id']."','".$a['params']['default']."');";
	return $queries;
};

self::$ActionTable['assign']['group_permission']		= function (&$a) { 
	if ( strtolower($a['params']['to_all_groups']) == "yes" ){
		$queries = array();
		foreach ( $a['params']['allIds'] as $B) {
			$queries[] = "INSERT INTO ".$a['sqlTables']['group_permission']." (".$a['columns'].") VALUES (".$B['uid'].", ".$a['params']['perm_id'].", ".$B['group_id']." );";
		}
		return $queries;
	}
	else { return array ("INSERT INTO ".$a['sqlTables']['group_permission']." (".$a['columns'].") VALUES (".$a['values'].");");}
};

self::$ActionTable['assign']['user_permission']		= function (&$a) { 
	if ( strtolower($a['params']['to_all_users']) == "yes" ){
		$queries = array();
		foreach ( $a['params']['allIds'] as $B) {
			$queries[] = "INSERT INTO ".$a['sqlTables']['user_permission']." (".$a['columns'].") VALUES (".$B['uid'].", ".$a['params']['perm_id'].", ".$B['user_id']." );";
		}
		return $queries;
	}
	else { return array ("INSERT INTO ".$a['sqlTables']['user_permission']." (".$a['columns'].") VALUES (".$a['values'].");");}
};

self::$ActionTable['assign']['tag']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['article_tag']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['assign']['theme']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['website']." SET fk_theme_id = '".$a['params']['theme_id']."' WHERE ws_id = '".$a['params']['ws_id']."';");};

self::$ActionTable['assign']['user']		= function (&$a) {
	$queries = array();
	if ( $a['params']['primary_group'] == 1 ) {
		$queries[] = "UPDATE ".$a['sqlTables']['group_user']." SET group_user_initial_group = '0' WHERE fk_user_id = '".$a['params']['user_id']."';";
	}
	$queries[] = "INSERT INTO ".$a['sqlTables']['group_user']." VALUES ('".$a['params']['group_user_id']."','".$a['params']['group_id']."','".$a['params']['user_id']."','".$a['params']['primary_group']."');";
	return $queries;
};


//--------------------------------------------------------------------------------
//	Insert
//--------------------------------------------------------------------------------
self::$ActionTable['insert']['content']		= function (&$a) {
	$bts = BaseToolSet::getInstance();
// 	$CMObj = ConfigurationManagement::getInstance();
	switch ( $bts->CMObj->getConfigurationEntry("execution_context") ) {
		case "render" :																																			break;
		case "installation" :			$a['params']['file'] = "websites-data/".$a['Context']['ws_directory']."/document/".$a['params']['file'];				break;
		case "extension_installation":	$a['params']['file'] = "extensions/".$a['Context']['ws_directory']."/_installation/document/".$a['params']['file'];		break;
	}
	
	if ( file_exists($a['params']['file']) ) {
		$fileContent = file( $a['params']['file'] );
		$content = "";
		foreach ( $fileContent as $line ) { $content .= $line; }
		
		$startPtr = stripos( $content , "/*Hydr-Content-Begin*/" , 0) + 23 ;
		$endPtr = stripos( $content , "/*Hydr-Content-End*/" , 0);
		if ( $startPtr > $endPtr ) {
			$a['errFlag'] = 1;
			$a['errMsg'][] = "End tag found before StartTag";
		}
		
		$startTagCount = substr_count( $content , "/*Hydr-Content-Begin*/");
		$endTagCount = substr_count( $content , "/*Hydr-Content-End*/");
		if ( $startTagCount != 1 || $endTagCount != 1 ) {
			$a['errMsg'][] = "Incorrect tag count in file '".$a['fichier_cible']."' ( D: ".$startTagCount." ; F: ".$startTagCount." ).";
		}
		
		if ( strlen($content) > 65536 ) {
			$sizeDocument = (strlen($content) / 1024 ) ;
			$a['errMsg'][] = "The content is larger than 64Kb (".$sizeDocument." Kb). Some Databases are limited to 64Kb by default on BLOB.";
		}
		$content = substr ( $content ,$startPtr , ($endPtr - $startPtr) );
		$content = addslashes ($content);
	}
	return array ("UPDATE ".$a['sqlTables']['document']." SET docu_validation = '1', docu_validator = '".$a['params']['validator_id']."', docu_cont = '".$content."' WHERE docu_id = '".$a['params']['docu_id']."';");
	
};
	
//--------------------------------------------------------------------------------
//	Set
//--------------------------------------------------------------------------------

// Directive 4
self::$ActionTable['set']['checkpoint']		= function (&$a) { 
	$bts = BaseToolSet::getInstance();
	$bts->MapperObj->setWhereWeAreAt($a['params']['name']);
	$bts->LMObj->logCheckpoint($a['params']['name']);
// 	error_log("--------------------------------------------------------------> chekpoint : " . $a['params']['name']);
};

// Directive 4
self::$ActionTable['set']['variable']		= function (&$a) { 
	$bts = BaseToolSet::getInstance();
	$bts->CMObj->setConfigurationEntry($a['params']['name'], $a['params']['value']);
};

//--------------------------------------------------------------------------------
//	Show
//--------------------------------------------------------------------------------
self::$ActionTable['show']['articles']	= function (&$a) {
	return array (
		"SELECT art.arti_ref, art.arti_id, art.arti_name, art.arti_title, art.arti_page, mnu.fk_lang_id, dl.deadline_name, dl.deadline_title, dl.deadline_state FROM"
		.$a['sqlTables']['article'] . " art,"
		.$a['sqlTables']['menu'] . " mnu,"
		.$a['sqlTables']['deadline'] . " dl"
		."WHERE mnu.fk_ws_id = '".$a['Context']['ws_id']. "' "
		."AND art.arti_ref = mnu.fk_arti_ref "
		."AND art.fk_deadline_id = dl.deadline_id "
		."AND art.fk_ws_id = dl.fk_ws_id "
		."AND dl.fk_ws_id = mnu.fk_ws_id "
		."AND arti_page = 1 "
		."AND mnu.menu_state = '1' "
		."AND mnu.menu_type IN ('1', '0') "
		."ORDER BY art.arti_ref, art.arti_page;"
	);
 };


 self::$ActionTable['show']['deadlines']	= function (&$a) {
	return array (
		"SELECT dl.* FROM"
		.$a['sqlTables']['article'] . " dl "
		."WHERE dl.fk_ws_id = '".$a['Context']['ws_id']. "' "
		."ORDER BY dl.deadline_name;"
	);
};

self::$ActionTable['show']['decorations']	= function (&$a) {
	return array (
		"SELECT d.* FROM "
		.$a['sqlTables']['decoration'] . " d "
		."ORDER BY d.deco_name;"
	);
};

self::$ActionTable['show']['documents']	= function (&$a) {
	return array (
		"SELECT doc.docu_id, doc.docu_name, doc.docu_type, shr.share_modification FROM"
		.$a['sqlTables']['document'] . " doc, "
		.$a['sqlTables']['document_share'] . " shr "
		."WHERE shr.fk_ws_id = '".$a['Context']['ws_id']. "' "
		."AND shr.fk_docu_id = doc.docu_id "
		."AND doc.docu_origin = '".$a['Context']['ws_id']. "' "
		."ORDER BY doc.docu_name;"
	);
};

self::$ActionTable['show']['groups']	= function (&$a) { 
	return array (
		"SELECT grp.group_name FROM "
		.$a['sqlTables']['group'] . " grp,"
		.$a['sqlTables']['group_website']." wg"
		."WHERE wg.fk_ws_id = '".$a['Context']['ws_id']. "' "
		."AND grp.group_id = wg.fk_group_id "
		."AND grp.group_name != 'Server_owner' "
		."ORDER BY grp.group_name;"
	);
};

self::$ActionTable['show']['keywords']	= function (&$a) {
	return array (
		"SELECT kw.* FROM "
		.$a['sqlTables']['keyword'] . " kw "
		."WHERE kw.fk_ws_id = '".$a['Context']['ws_id']. "' "
		."AND kw.keyword_state = '1' "
		."ORDER BY kw.keyword_name;"
	);
};

self::$ActionTable['show']['menus']	= function (&$a) {
	return array (
		"SELECT m.* FROM "
		.$a['sqlTables']['menu'] . " m, "
		.$a['sqlTables']['language_website'] . " lw "
		."WHERE m.menu_type IN (0, 1) "
		."AND m.menu_state = '1' "
		."AND m.fk_lang_id IN (38, 48) "
		."AND m.fk_lang_id = lw.fk_lang_id "
		."AND lw.fk_ws_id = m.fk_ws_id "
		."AND m.fk_ws_id = '".$a['Context']['ws_id']. "' "
		."ORDER BY m.fk_lang_id, m.menu_parent, m.menu_position ;"
	);
};

self::$ActionTable['show']['modules']	= function (&$a) {
	return array (
		"SELECT m.*, p.perm_name FROM "
		.$a['sqlTables']['module'] . " m , "
		.$a['sqlTables']['module_website'] . " mw, "
		.$a['sqlTables']['permission'] . " p "
		."WHERE mw.fk_ws_id = '".$a['Context']['ws_id']. "' "
		."AND m.module_id = mw.fk_module_id "
		."AND m.fk_perm_id = p.perm_id "
		."ORDER BY m.module_name, mw.module_position;"
	);
};


self::$ActionTable['show']['users']		= function (&$a) { 
	return array (
		"SELECT * FROM "
		.$a['sqlTables']['user']." usr," 
		.$a['sqlTables']['group_user']." gu," 
		.$a['sqlTables']['group_website']." gw " 
		."WHERE gw.fk_ws_id = '".$a['Context']['ws_id']. "' "
		."AND gw.fk_group_id = gu.fk_group_id "
		."AND gu.fk_user_id = usr.user_id "
		."GROUP BY usr.user_id "
		.";"
	);
};

self::$ActionTable['show']['websites']	= function (&$a) {
	return array (
		"SELECT ws_id, ws_name, ws_directory FROM "
		.$a['sqlTables']['website']." "
		."ORDER BY ws_id;"
	);
};

//--------------------------------------------------------------------------------
//	Share
//--------------------------------------------------------------------------------
self::$ActionTable['share']['document']		= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['document_share']."  (".$a['columns'].") VALUES (".$a['values'].");"); };

//--------------------------------------------------------------------------------
//	Website
//--------------------------------------------------------------------------------

self::$ActionTable['website']['context'] = function (&$a) {
	$CurrentSetObj = CurrentSet::getInstance();
	$CurrentSetObj->setInstanceOfWebSiteContextObj(new WebSite());
	$CurrentSetObj->getInstanceOfWebSiteContextObj()->changeWebSiteContext($a['params']['ws_id']);
	return 0; 
};

?>