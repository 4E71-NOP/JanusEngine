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
class AddOnDependancies {
	private $AddOnDependancies = array ();
	public function __construct() {
	}
	public function getAddOnDependanciesDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->AddOnDependancies [$A] = $B; }
		}
		
	}

	//@formatter:off
	public function getAddOnDependanciesEntry ($data) { return $this->AddOnDependancies[$data]; }
	public function getAddOnDependancies() { return $this->AddOnDependancies; }
	
	public function setAddOnDependanciesEntry ($entry, $data) { 
		if ( isset($this->AddOnDependancies[$entry])) { $this->AddOnDependancies[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setAddOnDependancies($AddOnDependancies) { $this->AddOnDependancies = $AddOnDependancies; }
	//@formatter:off

}


?>