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
	
	public function getDocumentDataFromDB (){
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$RequestDataObj = RequestData::getInstance();
		$LMObj = LogManagement::getInstance();
		
		$LOG_TARGET = $LMObj->getInternalLogTarget();
		$LMObj->setInternalLogTarget("both");
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();

		$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Start"), false );

// 		Checks if we have a requested article 
// 		if ( !isset($_REQUEST['arti_ref']) || strlen($_REQUEST['arti_ref']) == 0 ) {
		if ( strlen($RequestDataObj->getRequestDataEntry('arti_ref')) == 0 ) {
			$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " No arti_ref available. Getting first article"), false );
			$dbquery = $SDDMObj->query ( "
			SELECT cat.cate_id, cat.cate_name, cat.arti_ref
			FROM " . $SqlTableListObj->getSQLTableName('category') . " cat, " . $SqlTableListObj->getSQLTableName('deadline') . " bcl
			WHERE cat.ws_id = '" . $WebSiteObj->getWebSiteEntry ('ws_id'). "'
			AND cat.cate_lang = '" . $WebSiteObj->getWebSiteEntry ('ws_lang'). "'
			AND cat.deadline_id = bcl.deadline_id
			AND bcl.deadline_state = '1'
			AND cat.cate_type IN ('0','1')
			AND cat.group_id " . $UserObj->getUserEntry('clause_in_group')."
			AND cat.cate_state = '1'
			AND cate_initial_document = '1'
			ORDER BY cat.cate_parent,cat.cate_position
			;" );
			while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
				$CurrentSetObj->setInstanceOfDocumentDataObj(new DocumentData());
				$CurrentSetObj->setDataSubEntry('document', 'arti_ref', $dbp['arti_ref']);
			}
			$CurrentSetObj->setDataSubEntry('document', 'arti_page', 1);
		}
		else {
			$CurrentSetObj->setDataSubEntry('document', 'arti_ref', $RequestDataObj->getRequestDataEntry('arti_ref'));
			$CurrentSetObj->setDataSubEntry('document', 'arti_page', $RequestDataObj->getRequestDataEntry('arti_page'));
		}
		
// 		We have an article to display whatever its ID is requested or forged
		$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " arti_ref=`".$CurrentSetObj->getDataSubEntry('document', 'arti_ref')."`; arti_page=`".$CurrentSetObj->getDataSubEntry('document', 'arti_page')."`"), false );
		$dbquery = $SDDMObj->query("
		SELECT art.*, doc.docu_id, doc.docu_name, doc.docu_type,
		doc.docu_creator, doc.docu_creation_date,
		doc.docu_examiner, doc.docu_examination_date,
		doc.docu_origin, doc.docu_cont, sit.ws_directory
		FROM ".$SqlTableListObj->getSQLTableName('article')." art, ".$SqlTableListObj->getSQLTableName('document')." doc, ".$SqlTableListObj->getSQLTableName('deadline')." bcl, ".$SqlTableListObj->getSQLTableName('website')." sit
		WHERE art.arti_ref = '".$CurrentSetObj->getDataSubEntry('document', 'arti_ref')."'
		AND art.arti_page = '".$CurrentSetObj->getDataSubEntry('document', 'arti_page')."'
		AND art.docu_id = doc.docu_id
		AND art.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		AND sit.ws_id = doc.docu_origin
		AND art.deadline_id = bcl.deadline_id
		AND bcl.deadline_state = '1'
		;");
		
		if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {
			$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " article not found"), false );
			
			$dbquery = $SDDMObj->query("
			SELECT doc.*
			FROM ".$SqlTableListObj->getSQLTableName('document')." doc, ".$SqlTableListObj->getSQLTableName('document_share')." ds
			WHERE doc.docu_name LIKE '%article_inexistant%'
			AND ds.docu_id = doc.docu_id
			AND ds.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
			;");
		}
		
		while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
			$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Loading data"), false );
			foreach ( $dbp as $A => $B ) { $this->DocumentData[$A] = $B; }
		}
		$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " End"), false );

		$LMObj->setInternalLogTarget($LOG_TARGET);
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