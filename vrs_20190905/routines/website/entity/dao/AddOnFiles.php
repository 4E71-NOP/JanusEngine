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
class AddOnFiles {
	private $AddOnFiles = array ();
	public function __construct() {
	}
	public function getAddOnFilesDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->AddOnFiles [$A] = $B; }
		}
		
	}

	//@formatter:off
	public function getAddOnFilesEntry ($data) { return $this->AddOnFiles[$data]; }
	public function getAddOnFiles() { return $this->AddOnFiles; }
	
	public function setAddOnFilesEntry ($entry, $data) { 
		if ( isset($this->AddOnFiles[$entry])) { $this->AddOnFiles[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setAddOnFiles($AddOnFiles) { $this->AddOnFiles = $AddOnFiles; }
	//@formatter:off

}


?>