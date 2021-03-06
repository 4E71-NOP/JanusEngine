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
class DocumentShare {
	private $DocumentShare = array ();
	public function __construct() {
	}
	public function getDocumentShareDataFromDB($id) {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $cs->SDDMObj->query ( "" );
		while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->DocumentShare [$A] = $B; }
		}
		
		$dbquery = $cs->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('document_share') . "
			WHERE share_id = '" . $id . "'
			;" );
		if ( $cs->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for document_share id=".$id));
			while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->DocumentShare[$A] = $B; }
			}
		}
		else {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for document_share id=".$id));
		}
		
	}

	//@formatter:off
	public function getDocumentShareEntry ($data) { return $this->DocumentShare[$data]; }
	public function getDocumentShare() { return $this->DocumentShare; }
	
	public function setDocumentShareEntry ($entry, $data) { 
		if ( isset($this->DocumentShare[$entry])) { $this->DocumentShare[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDocumentShare($DocumentShare) { $this->DocumentShare = $DocumentShare; }
	//@formatter:off

}


?>