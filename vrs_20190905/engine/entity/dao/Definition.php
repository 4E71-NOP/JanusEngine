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

/**
 * Not yet implemented in the model. 
 * 
 * @author faust
 *
 */
class Definition extends Entity {
	private $Definition = array ();
	public function __construct() {
	}
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('definition') . "
			WHERE def_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for definition id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Definition[$A] = $B; }
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for definition id=".$id));
		}
	}

	//@formatter:off
	public function getDefinitionEntry ($data) { return $this->Definition[$data]; }
	public function getDefinition() { return $this->Definition; }
	
	public function setDefinitionEntry ($entry, $data) { 
		if ( isset($this->Definition[$entry])) { $this->Definition[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDefinition($Definition) { $this->Definition = $Definition; }
	//@formatter:off

}


?>