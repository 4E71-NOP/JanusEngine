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
class DocumentStats {
	private $DocumentStats = array ();
	public function __construct() {
	}
	public function getDocumentStatsDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->DocumentStats [$A] = $B; }
		}
		
	}

	//@formatter:off
	public function getDocumentStatsEntry ($data) { return $this->DocumentStats[$data]; }
	public function getDocumentStats() { return $this->DocumentStats; }
	
	public function setDocumentStatsEntry ($entry, $data) { 
		if ( isset($this->DocumentStats[$entry])) { $this->DocumentStats[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDocumentStats($DocumentStats) { $this->DocumentStats = $DocumentStats; }
	//@formatter:off

}


?>