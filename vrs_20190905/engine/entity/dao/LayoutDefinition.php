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
class LayoutDefinition {
	private $LayoutDefinition = array ();
	public function __construct() {
	}
	public function getLayoutDefinitionDataFromDB($id) {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $cs->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('layout_defnition') . "
			WHERE layout_defnition_id = '" . $id . "'
			;" );
		if ( $cs->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for layout_defnition id=".$id));
			while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->LayoutDefinition[$A] = $B; }
			}
		}
		else {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for layout_defnition id=".$id));
		}
	}

	//@formatter:off
	public function getLayoutDefinitionEntry ($data) { return $this->LayoutDefinition[$data]; }
	public function getLayoutDefinition() { return $this->LayoutDefinition; }
	
	public function setLayoutDefinitionEntry ($entry, $data) { 
		if ( isset($this->LayoutDefinition[$entry])) { $this->LayoutDefinition[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setLayoutDefinition($LayoutDefinition) { $this->LayoutDefinition = $LayoutDefinition; }
	//@formatter:off

}


?>