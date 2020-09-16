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
	public function getDecorationDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->Decoration [$A] = $B; }
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