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
class AddOnConfig {
	private $AddOnConfig = array ();
	public function __construct() {
	}
	public function getAddOnConfigDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->AddOnConfig [$A] = $B; }
		}
		
	}

	//@formatter:off
	public function getAddOnConfigEntry ($data) { return $this->AddOnConfig[$data]; }
	public function getAddOnConfig() { return $this->AddOnConfig; }
	
	public function setAddOnConfigEntry ($entry, $data) { 
		if ( isset($this->AddOnConfig[$entry])) { $this->AddOnConfig[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setAddOnConfig($AddOnConfig) { $this->AddOnConfig = $AddOnConfig; }
	//@formatter:off

}


?>