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
class Tag {
	private $Tag = array ();
	public function __construct() {
	}
	public function getTagDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->Tag [$A] = $B; }
		}
		
	}

	//@formatter:off
	public function getTagEntry ($data) { return $this->Tag[$data]; }
	public function getTag() { return $this->Tag; }
	
	public function setTagEntry ($entry, $data) { 
		if ( isset($this->Tag[$entry])) { $this->Tag[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setTag($Tag) { $this->Tag = $Tag; }
	//@formatter:off

}


?>