<?php
//--------------------------------------------------------------------------------
//	Add
//--------------------------------------------------------------------------------
self::$ActionTable['add']['article']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['article']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['category']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['categorie']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['deadline']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['bouclage']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['decoration']			= function (&$a) {
	switch ( $a['params']['type']) {
		case 10:	$targetTable = "deco_10_menu";			$idv="10_id";	break;
		case 20:	$targetTable = "deco_20_caligraphe";	$idv="20_id";	break;
		case 30:	$targetTable = "deco_30_1_div";			$idv="30_id";	break;
		case 40:	$targetTable = "deco_40_elegance";		$idv="40_id";	break;
		case 50:	$targetTable = "deco_50_exquise";		$idv="50_id";	break;
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
	$a['columns2'] = "deco_nligne, deco_id, deco_variable, deco_valeur";
	
	return array (
		"INSERT INTO ".$a['sqlTables']['decoration']." (".$a['columns'].") VALUES (".$a['values'].");",
		"INSERT INTO ".$a['sqlTables'][$targetTable]." (".$a['columns2'].") VALUES ".$a['values2'].";",
	);
};

self::$ActionTable['add']['document_config']	= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['article_config']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['document']		= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['document']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['group'] = function (&$a) { return array (
		"INSERT INTO ".$a['sqlTables']['groupe']." (".$a['columns'].") VALUES (".$a['values'].");",
		"INSERT INTO ".$a['sqlTables']['site_groupe']." VALUES ('".$a['params']['group_webws_id']."', '".$a['Context']['ws_id']."', '".$a['params']['id']."', '1' );"
	);
};

self::$ActionTable['add']['keyword']		= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['mot_cle']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['layout']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['presentation']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['layout_content']	= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['presentation_contenu']." (".$a['columns'].") VALUES (".$a['values'].");");};


self::$ActionTable['add']['log']	= function (&$a) { 
	$LMObj = LogManagement::getInstance();
	$LMObj->log($a);
};




self::$ActionTable['add']['module'] = function (&$a) { return array (
		"INSERT INTO ".$a['sqlTables']['module']." (".$a['columns'].") VALUES (".$a['values'].");",
		"INSERT INTO ".$a['sqlTables']['module_website']." VALUES ('".$a['params']['module_website_id']."', '".$a['Context']['ws_id']."', '".$a['params']['id']."', '".$a['params']['state']."', '".$a['params']['position']."' );"
	);
};

self::$ActionTable['add']['tag']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['tag']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['theme']			= function (&$a) { return array (
		"INSERT INTO ".$a['sqlTables']['theme_descriptor']." (".$a['columns'].") VALUES (".$a['values'].");",
		"INSERT INTO ".$a['sqlTables']['theme_website']." (theme_website_id, ws_id, theme_id, theme_state) VALUES ('".$a['params']['theme_website_id']."','".$a['Context']['ws_id']."','".$a['params']['id']."','".$a['params']['state']."');");
};


self::$ActionTable['add']['translation']	= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['i18n']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['add']['user']			= function (&$a) { 
	$queries = array();
	$b=1;
	$c=1;
	$queries[] = "INSERT INTO ".$a['sqlTables']['user']." (".$a['columns'].") VALUES (".$a['values'].");";
	if ($a['params']['name'] != "anonymous") {
		$queries[] = "INSERT INTO ".$a['sqlTables']['groupe_user']." VALUES ('".($a['params']['groupe_user_id']+$b)."','".$a['params']['reader_id']."','".$a['params']['id']."','1');";
		$b++;
		$c=0;
	}
	$queries[] = "INSERT INTO ".$a['sqlTables']['groupe_user']." VALUES ('".($a['params']['groupe_user_id']+$b)."','".$a['params']['anonymous_id']."','".$a['params']['id']."','".$c."');";
	return $queries;
};


self::$ActionTable['add']['website']		= function (&$a) {
	$CurrentSetObj = CurrentSet::getInstance();
	$CurrentSetObj->setDataSubEntry('install', 'websitePostCreation', 1 );
	return array ("INSERT INTO ".$a['sqlTables']['website']." (".$a['columns'].") VALUES (".$a['values'].");");
};

//--------------------------------------------------------------------------------
//	Assign
//--------------------------------------------------------------------------------
self::$ActionTable['assign']['document']		= function (&$a) {
	return array ("UPDATE ".$a['sqlTables']['article']." SET docu_id = '".$a['params']['docu_id']."' WHERE arti_id = '".$a['params']['arti_id']."';");
};

self::$ActionTable['assign']['language']		= function (&$a) {
	return array ("INSERT INTO ".$a['sqlTables']['language_website']." VALUES ('".$a['params']['lang_website_id']."', '".$a['params']['ws_id']."', '".$a['params']['lang_id']."');");
};

	
self::$ActionTable['assign']['layout']		= function (&$a) {
	$queries = array();
	if ( $a['params']['default'] == 1 ) {
		$queries[] = "UPDATE ".$a['sqlTables']['theme_presentation']." SET pres_defaut = '0' WHERE theme_id = '".$a['params']['theme_id']."';";
	}
	$queries[] = "INSERT INTO ".$a['sqlTables']['theme_presentation']." VALUES ('".$a['params']['theme_pres_id']."','".$a['params']['theme_id']."','".$a['params']['pres_id']."','".$a['params']['default']."');";
	return $queries;
};

self::$ActionTable['assign']['tag']			= function (&$a) { return array ("INSERT INTO ".$a['sqlTables']['article_tag']." (".$a['columns'].") VALUES (".$a['values'].");");};

self::$ActionTable['assign']['theme']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['website']." SET theme_id = '".$a['params']['theme_id']."' WHERE ws_id = '".$a['params']['ws_id']."';");};

self::$ActionTable['assign']['user']		= function (&$a) {
	$queries = array();
	if ( $a['params']['primary_group'] == 1 ) {
		$queries[] = "UPDATE ".$a['sqlTables']['groupe_user']." SET groupe_premier = '0' WHERE user_id = '".$a['params']['user_id']."';";
	}
	$queries[] = "INSERT INTO ".$a['sqlTables']['groupe_user']." VALUES ('".$a['params']['groupe_user_id']."','".$a['params']['groupe_id']."','".$a['params']['user_id']."','".$a['params']['primary_group']."');";
	return $queries;
};


//--------------------------------------------------------------------------------
//	Update
//--------------------------------------------------------------------------------
self::$ActionTable['update']['document']		= function (&$a) {
	if ($a['params']['updateGO'] == 1 ) { return array ("UPDATE ".$a['sqlTables']['document']." SET ".$a['equalities']." WHERE docu_id = '".$a['params']['docu_id']."';"); }
	else { return array ("SELECT 'Nothing to do';"); }
};

self::$ActionTable['update']['website']		= function (&$a) {
	$queries = array();
	if ($a['params']['updateGO'] == 1 ) { 
		$queries[] = "UPDATE ".$a['sqlTables']['website']." SET ".$a['equalities']." WHERE ws_id = '".$a['params']['ws_id']."';";
	}
	return $queries;
};


self::$ActionTable['update']['user']		= function (&$a) { return array ("UPDATE ".$a['sqlTables']['user']." SET ".$a['equalities']." WHERE user_id = '".$a['params']['id']."';"); };





//--------------------------------------------------------------------------------
//	Insert
//--------------------------------------------------------------------------------
self::$ActionTable['insert']['content']		= function (&$a) {
	$CMObj = ConfigurationManagement::getInstance();
	switch ( $CMObj->getConfigurationEntry("execution_context") ) {
		case "render" :																																				break;
		case "installation" :			$a['params']['file'] = "../websites-data/".$a['Context']['ws_directory']."/document/".$a['params']['file'];				break;
		case "extension_installation":	$a['params']['file'] = "../extensions/".$a['Context']['ws_directory']."/_installation/document/".$a['params']['file'];		break;
	}
	
	if ( file_exists($a['params']['file']) ) {
		$fileContent = file( $a['params']['file'] );
		foreach ( $fileContent as $line ) { $content .= $line; }
		
		$startPtr = stripos( $content , "/*Hydre-contenu_debut*/" , 0) + 23 ;
		$endPtr = stripos( $content , "/*Hydre-contenu_fin*/" , 0);
		if ( $startPtr > $endPtr ) {
			$a['errFlag'] = 1;
			$a['errMsg'][] = "End tag found before StartTag";
		}
		
		$startTagCount = substr_count( $content , "/*Hydre-contenu_debut*/");
		$endTagCount = substr_count( $content , "/*Hydre-contenu_fin*/");
		if ( $startTagCount != 1 || $endTagCount != 1 ) {
			$a['errMsg'][] = "Incorrect tag count in file '".$R['fichier_cible']."' ( D: ".$startTagCount." ; F: ".$startTagCount." ).";
		}
		
		if ( strlen($content) > 65536 ) {
			$sizeDocument = (strlen($content) / 1024 ) ;
			$a['errMsg'][] = "The content is larger than 64Kb (".$sizeDocument." Kb). Some Databases are limited to 64Kb by default on BLOB.";
		}
		$content = substr ( $content ,$startPtr , ($endPtr - $startPtr) );
		$content = addslashes ($content);
	}
	return array ("UPDATE ".$a['sqlTables']['document']." SET docu_correction = '1', docu_correcteur = '".$a['params']['validator_id']."', docu_cont = '".$content."' WHERE docu_id = '".$a['params']['docu_id']."';");
	
};
	
//--------------------------------------------------------------------------------
//	Set
//--------------------------------------------------------------------------------

// Directive 4
self::$ActionTable['set']['checkpoint']		= function (&$a) { 
	$LMObj = LogManagement::getInstance();
	$LMObj->logCheckpoint($a['params']['name']);
};

// Directive 4
self::$ActionTable['set']['variable']		= function (&$a) { 
	$CMObj = ConfigurationManagement::getInstance();
	$CMObj->setConfigurationEntry($a['params']['name'], $a['params']['value']);
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