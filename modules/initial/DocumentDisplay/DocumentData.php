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
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Start"), false );
		
// 		Checks if we have a requested article 
// 		if ( !isset($_REQUEST['arti_ref']) || strlen($_REQUEST['arti_ref']) == 0 ) {
// 		if ( strlen($bts->RequestDataObj->getRequestDataEntry('arti_ref')) == 0 ) {
		if (strlen ( $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref') ) == 0) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " No arti_ref available. Getting first article"), false );
			$dbquery = $bts->SDDMObj->query ( "
			SELECT mnu.menu_id, mnu.menu_name, mnu.fk_arti_ref
			FROM " . $SqlTableListObj->getSQLTableName('menu') . " mnu, " 
			. $SqlTableListObj->getSQLTableName('deadline') . " bcl
			WHERE mnu.fk_ws_id = '" . $WebSiteObj->getWebSiteEntry ('ws_id'). "'
			AND mnu.fk_lang_id = '" . $WebSiteObj->getWebSiteEntry ('ws_lang'). "'
			AND mnu.fk_deadline_id = bcl.deadline_id
			AND bcl.deadline_state = '1'
			AND mnu.menu_type IN ('0','1')
			AND mnu.fk_group_id " . $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('clause_in_group')."
			AND mnu.menu_state = '1'
			AND menu_initial_document = '1'
			ORDER BY mnu.menu_parent,mnu.menu_position
			;" );
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$CurrentSetObj->setInstanceOfDocumentDataObj(new DocumentData());
				$CurrentSetObj->setDataSubEntry('document', 'arti_ref', $dbp['arti_ref']);
			}
			$CurrentSetObj->setDataSubEntry('document', 'arti_page', 1);
		}

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " arti_ref=`".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')."`; arti_page=`".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_page')."`"), false );
		$dbquery = $bts->SDDMObj->query("
		SELECT art.*, doc.docu_id, doc.docu_name, doc.docu_type,
		doc.docu_creator, doc.docu_creation_date,
		doc.docu_validator, doc.docu_validation_date,
		doc.docu_origin, doc.docu_cont, w.ws_directory
		FROM "
		.$SqlTableListObj->getSQLTableName('article')." art, "
		.$SqlTableListObj->getSQLTableName('document')." doc, "
		.$SqlTableListObj->getSQLTableName('deadline')." bcl, "
		.$SqlTableListObj->getSQLTableName('website')." w
		WHERE art.arti_ref = '".$CurrentSetObj->getDataSubEntry('article', 'arti_ref')."'
		AND art.arti_page = '".$CurrentSetObj->getDataSubEntry('article', 'arti_page')."'
		AND art.fk_docu_id = doc.docu_id
		AND art.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		AND w.ws_id = doc.docu_origin
		AND art.fk_deadline_id = bcl.deadline_id
		AND bcl.deadline_state = '1'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " article not found"), false );
			
			$dbquery = $bts->SDDMObj->query("
			SELECT doc.*
			FROM ".$SqlTableListObj->getSQLTableName('document')." doc, "
			.$SqlTableListObj->getSQLTableName('document_share')." ds
			WHERE doc.docu_name LIKE '%article_inexistant%'
			AND ds.fk_docu_id = doc.docu_id
			AND ds.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
			;");
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