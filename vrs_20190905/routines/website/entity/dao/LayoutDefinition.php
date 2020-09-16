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
	public function getLayoutDefinitionDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
// 		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->LayoutDefinition [$A] = $B; }
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