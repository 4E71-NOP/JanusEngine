<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */
class Document {
	private $Document = array ();
	
	public function __construct() {}
	
	/**
	 * Gets document data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the document selection to the website ID only.
	 * @param integer $id
	 */
	public function getDocumentDataFromDB($id) {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $dbquery = $cs->SDDMObj->query("
			SELECT doc.*, part.part_modification 
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document')." doc, ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document_share')." shr 
			WHERE shr.ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."' 
			AND doc.docu_id = '".$id."' 
			AND shr.docu_id = doc.docu_id 
			AND doc.docu_origin = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."' 
		;");
		
		if ( $cs->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for document id=".$id));
			while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Document[$A] = $B; }
			}
		}
		else {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for document id=".$id));
		}
		
	}
	
	//@formatter:off
	public function getDocumentEntry ($data) { return $this->Document[$data]; }
	public function getDocument() { return $this->Document; }
	
	public function setDocumentEntry ($entry, $data) { 
		if ( isset($this->Document[$entry])) { $this->Document[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}
	
	public function setDocument($Document) { $this->Document = $Document; }
	//@formatter:off

}


?>