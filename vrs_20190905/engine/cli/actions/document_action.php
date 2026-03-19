<?php
//--------------------------------------------------------------------------------
//	Document
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['document']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['document'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };

self::$ActionTable['update']['document']		= function (&$a) {
	if ($a['params']['updateGO'] == 1) {
		$arr = array("UPDATE " . $a['sqlTables']['document'] . " SET " . $a['equalities'] . " WHERE docu_id = '" . $a['params']['docu_id'] . "';");
		if (is_numeric($a['params']['modification'])) {
			$arr[] = "UPDATE " . $a['sqlTables']['document_share'] . " SET share_modification='" . $a['params']['modification'] . "' WHERE fk_docu_id = '" . $a['params']['docu_id'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';";
		}
		return ($arr);
	} else {
		return array("SELECT 'Nothing to do';");
	} 
};
self::$ActionTable['disable']['document']				= function (&$a) { return array("UPDATE " . $a['sqlTables']['document']				. " SET docu_state=0		WHERE docu_id = '"			. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['document']				= function (&$a) { return array("UPDATE " . $a['sqlTables']['document']				. " SET docu_state=2		WHERE docu_id = '"			. $a['params']['id'] . "';"); };

self::$ActionTable['assign']['document']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['article'] . " SET fk_docu_id = '" . $a['params']['docu_id'] . "' WHERE arti_id = '" . $a['params']['arti_id'] . "';"); };

//--------------------------------------------------------------------------------
//	Insert
//--------------------------------------------------------------------------------
self::$ActionTable['insert']['content']		= function (&$a, &$sddmObj) {
	$bts = BaseToolSet::getInstance();
	// $bts->LMObj->setVectorSystemLogLevel(LOGLEVEL_STATEMENT);
	// 	$CMObj = ConfigurationManagement::getInstance();
	switch ($bts->CMObj->getConfigurationEntry("execution_context")) {
		case "render":
			break;
		case "installation":
			$a['params']['file'] = "websites-data/" . $a['Context']['ws_directory'] . "/document/" . $a['params']['file'];
			break;
		// case "extension_installation":
		// 	$a['params']['file'] = "extensions/" . $a['Context']['ws_directory'] . "/_installation/document/" . $a['params']['file'];
		// 	break;
	}

	if (file_exists($a['params']['file'])) {
		$fileContent = file($a['params']['file']);
		$content = "";
		foreach ($fileContent as $line) {
			$content .= $line;
		}

		$startPtr = stripos($content, DOCUMENT_TAG_BEGIN, 0) + DOCUMENT_TAG_BEGIN_OFFSET;
		$endPtr = stripos($content, DOCUMENT_TAG_END, 0);
		if ($startPtr > $endPtr) {
			$a['errFlag'] = 1;
			$a['errMsg'][] = "End tag found before StartTag";
		}

		$startTagCount = substr_count($content, DOCUMENT_TAG_BEGIN);
		$endTagCount = substr_count($content, DOCUMENT_TAG_END);
		if ($startTagCount != 1 || $endTagCount != 1) {
			$a['errFlag'] = 1;
			$a['errMsg'][] = "Incorrect tag count in file '" . $a['fichier_cible'] . "' ( D: " . $startTagCount . " ; F: " . $startTagCount . " ).";
		}

		if (strlen($content ?? '') > 65536) {
			$sizeDocument = (strlen($content ?? '') / 1024);
			$a['errFlag'] = 1;
			$a['errMsg'][] = "The content is larger than 64Kb (" . $sizeDocument . " Kb). Some Databases are limited to 64Kb by default on BLOB.";
		}
		$content = substr($content, $startPtr, ($endPtr - $startPtr));

		$content = $bts->SDDMObj->escapeString($content);
	}

	return array("UPDATE " . $a['sqlTables']['document'] . " SET docu_validation = '1', docu_validator = '" . $a['params']['validator_id'] . "', docu_cont = '" . $content . "' WHERE docu_id = '" . $a['params']['docu_id'] . "';"); 
};


self::$ActionTable['show']['documents']	= function (&$a) { return array(
		"SELECT "
			. "doc.docu_name AS 'Name', "
			. "doc.docu_type AS 'Type', "
			. "ws.ws_name AS 'Origin', "
			. "shr.share_modification 'Modifiable', "
			. "(SELECT u1.user_name FROM Ht_user u1 WHERE u1.user_id = doc.docu_creator) AS 'Creator', "
			. "(SELECT u2.user_name FROM Ht_user u2 WHERE u2.user_id = doc.docu_validator) AS 'Validator' "
			. "FROM "
			. $a['sqlTables']['document'] . " doc, "
			. $a['sqlTables']['document_share'] . " shr, "
			. $a['sqlTables']['website'] . " ws "
			. "WHERE shr.fk_ws_id = '" . $a['Context']['ws_id'] . "' "
			. "AND ws.ws_id = '" . $a['Context']['ws_id'] . "' "
			. "AND shr.fk_docu_id = doc.docu_id "
			. "AND doc.docu_origin = '" . $a['Context']['ws_id'] . "' "
			. "ORDER BY doc.docu_name"
	); 
};

self::$ActionTable['share']['document']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['document_share'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };

?>