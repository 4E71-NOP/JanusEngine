<?php
 // // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end

/**
 * 
 * @author faust
 * This class is responsible for holding document data (and some article data) when processed by the corresponding module. 
 * It is NOT the document entity found in the DAO. 
 * Those two are used differently.
 */
class DocumentData {
	private $DocumentName = "";
	private $DocumentData = array();
	
	public function __construct() {}
	
	public function getDataFromDB (){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$WebSiteObj = $CurrentSetObj->WebSiteObj;
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Start"), false );
		
// 		Checks if we have a requested article 
		if (strlen ( $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref') ) == 0) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " No arti_ref available. Getting first article"), false );
			$dbquery = $bts->SDDMObj->query ("SELECT " 
			. "CONCAT('0x', HEX(menu_id)) AS menu_id, "
			. "menu_name, "
			. "mnu.fk_arti_ref "
			. "FROM " . $SqlTableListObj->getSQLTableName('menu') . " mnu, " 
			. $SqlTableListObj->getSQLTableName('deadline') . " bcl "
			. "WHERE mnu.fk_ws_id = " . $WebSiteObj->getWebSiteEntry ('ws_id'). " "
			. "AND mnu.fk_lang_id = " . $WebSiteObj->getWebSiteEntry ('fk_lang_id'). " "
			. "AND mnu.fk_deadline_id = bcl.deadline_id "
			. "AND bcl.deadline_state = 1 "
			. "AND mnu.menu_type IN (0, 1) "
			. "AND mnu.menu_state = 1 "
			. "AND menu_initial_document = 1 "
			. "ORDER BY mnu.menu_parent,mnu.menu_position"
			. ";" );

			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$CurrentSetObj->setDocumentDataObj(new DocumentData());
				$CurrentSetObj->setDataSubEntry('document', 'arti_ref', $dbp['arti_ref']);
			}
			$CurrentSetObj->setDataSubEntry('document', 'arti_page', 1);
		}

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " arti_ref=`".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')."`; arti_page=`".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_page')."`"), false );
		$dbquery = $bts->SDDMObj->query("SELECT "
			. "CONCAT('0x', HEX(art.arti_id)) AS arti_id, "
			. "art.arti_ref, "
			. "art.arti_slug, "
			. "CONCAT('0x', HEX(art.fk_deadline_id)) AS fk_deadline_id, "
			. "art.arti_name, "
			. "art.arti_desc, "
			. "art.arti_title, "
			. "art.arti_subtitle, "
			. "art.arti_page, "
			. "art.layout_generic_name, "
			. "CONCAT('0x', HEX(art.fk_config_id)) AS fk_config_id, "
			. "CONCAT('0x', HEX(art.arti_creator_id)) AS arti_creator_id, "
			. "art.arti_creation_date, "
			. "CONCAT('0x', HEX(art.arti_validator_id)) AS arti_validator_id, "
			. "art.arti_validation_date, "
			. "art.arti_validation_state, "
			. "art.arti_release_date, "
			. "CONCAT('0x', HEX(art.fk_docu_id)) AS fk_docu_id, "
			. "CONCAT('0x', HEX(art.fk_ws_id)) AS fk_ws_id, "

			. "CONCAT('0x', HEX(doc.docu_id)) AS docu_id, "
			. "doc.docu_name, "
			. "doc.docu_type, "
			. "CONCAT('0x', HEX(doc.docu_origin)) AS docu_origin, "
			. "CONCAT('0x', HEX(doc.docu_creator)) AS docu_creator, "
			. "doc.docu_creation_date, "
			. "doc.docu_validation, "
			. "CONCAT('0x', HEX(doc.docu_validator)) AS docu_validator, "
			. "doc.docu_validation_date, "
			. "doc.docu_cont, "
			. "w.ws_directory "

			. "FROM "
			. $SqlTableListObj->getSQLTableName('article') . " art, "
			. $SqlTableListObj->getSQLTableName('document') . " doc, "
			. $SqlTableListObj->getSQLTableName('deadline') . " bcl, "
			. $SqlTableListObj->getSQLTableName('website') . " w "
			. "WHERE art.arti_ref = '" . $CurrentSetObj->getDataSubEntry('article', 'arti_ref') . "' "
			. "AND art.arti_page = " . $CurrentSetObj->getDataSubEntry('article', 'arti_page') . " "
			. "AND art.fk_docu_id = doc.docu_id "
			. "AND art.fk_ws_id = " . $WebSiteObj->getWebSiteEntry('ws_id') . "  "
			. "AND w.ws_id = doc.docu_origin "
			. "AND art.fk_deadline_id = bcl.deadline_id "
			. "AND bcl.deadline_state = 1 "
			. ";");
			
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " article not found"), false );

			$dbquery = $bts->SDDMObj->query("SELECT "
				. "CONCAT('0x', HEX(doc.docu_id)) AS docu_id, "
				. "doc.docu_name, "
				. "doc.docu_type, "
				. "CONCAT('0x', HEX(doc.docu_origin)) AS docu_origin, "
				. "CONCAT('0x', HEX(doc.docu_creator)) AS docu_creator, "
				. "doc.docu_creation_date, "
				. "doc.docu_validation, "
				. "CONCAT('0x', HEX(doc.docu_validator)) AS docu_validator, "
				. "doc.docu_validation_date, "
				. "doc.docu_cont "
				. "FROM "
				. $SqlTableListObj->getSQLTableName('document') . " doc, "
				. $SqlTableListObj->getSQLTableName('document_share') . " ds "
				. "WHERE doc.docu_name LIKE '%article_not_found%' "
				. "AND ds.fk_docu_id = doc.docu_id "
				. "AND ds.fk_ws_id = " . $WebSiteObj->getWebSiteEntry('ws_id')
				. ";");
		}
		
		while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Loading data"), false );
			foreach ( $dbp as $A => $B ) { $this->DocumentData[$A] = $B; }
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " End"), false );

	}
	
	//@formatter:off
	public function getDocumentName() { return $this->DocumentName;}
	public function getDocumentData() { return $this->DocumentData; }
	public function getDocumentDataEntry ($data) { return $this->DocumentData[$data]; }
	
	public function setDocumentName($DocumentName) { $this->DocumentName = $DocumentName; }
	public function setDocumentData($DocumentData) { $this->DocumentData = $DocumentData; }
	public function setDocumentDataEntry ($entry , $data) { $this->DocumentData[$entry] = $data; }
	//@formatter:on

}
?>