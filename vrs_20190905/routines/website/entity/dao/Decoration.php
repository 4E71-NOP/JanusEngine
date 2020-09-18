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
class Decoration {
	private $Decoration = array ();
	public function __construct() {
	}
	public function getDecorationDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		$dbquery = $SDDMObj->query ( "
			SELECT *
			FROM " . $SqlTableListObj->getSQLTableName ('decoration') . "
			WHERE deco_id = '" . $id . "'
			;" );
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : Loading data for <neddle> id=".$id));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Decoration[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : No rows returned for <neddle> id=".$id));
		}
		
	}

	//@formatter:off
	public function getDecorationEntry ($data) { return $this->Decoration[$data]; }
	public function getDecoration() { return $this->Decoration; }
	
	public function setDecorationEntry ($entry, $data) { 
		if ( isset($this->Decoration[$entry])) { $this->Decoration[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDecoration($Decoration) { $this->Decoration = $Decoration; }
	//@formatter:off

}


?>