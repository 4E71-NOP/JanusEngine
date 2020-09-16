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
class AddOn {
	private $AddOn = array ();
	public function __construct() {
	}
	public function getAddOnDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->AddOn [$A] = $B; }
		}
		
	}

	//@formatter:off
	public function getAddOnEntry ($data) { return $this->AddOn[$data]; }
	public function getAddOn() { return $this->AddOn; }
	
	public function setAddOnEntry ($entry, $data) { 
		if ( isset($this->AddOn[$entry])) { $this->AddOn[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setAddOn($AddOn) { $this->AddOn = $AddOn; }
	//@formatter:off

}


?>