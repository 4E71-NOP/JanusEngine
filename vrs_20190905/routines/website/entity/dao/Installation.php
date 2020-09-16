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
class Installation {
	private $Installation = array ();
	public function __construct() {
	}
	public function getInstallationDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->Installation [$A] = $B; }
		}
		
	}

	//@formatter:off
	public function getInstallationEntry ($data) { return $this->Installation[$data]; }
	public function getInstallation() { return $this->Installation; }
	
	public function setInstallationEntry ($entry, $data) { 
		if ( isset($this->Installation[$entry])) { $this->Installation[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setInstallation($Installation) { $this->Installation = $Installation; }
	//@formatter:off

}


?>