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
class Layout {
	private $Layout = array ();
	public function __construct() {
	}
	public function getLayoutDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		$dbquery = $SDDMObj->query ( "
			SELECT *
			FROM " . $SqlTableListObj->getSQLTableName ('layout') . "
			WHERE layout_id = '" . $id . "'
			;" );
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : Loading data for layout id=".$id));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Layout[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : No rows returned for layout id=".$id));
		}
	}

	//@formatter:off
	public function getLayoutEntry ($data) { return $this->Layout[$data]; }
	public function getLayout() { return $this->Layout; }
	
	public function setLayoutEntry ($entry, $data) { 
		if ( isset($this->Layout[$entry])) { $this->Layout[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setLayout($Layout) { $this->Layout = $Layout; }
	//@formatter:off

}


?>