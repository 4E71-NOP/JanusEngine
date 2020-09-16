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
class Deco40_Elegance {
	private $Deco40_Elegance = array ();
	public function __construct() {
	}
	public function getDeco40_EleganceDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "
			SELECT *
			FROM ".$SqlTableListObj->getSQLTableName('deco_40_elegance')."
			WHERE deco_id = '".$data."'
			;" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			$this->Deco40_Elegance [$dbp['deco_variable']] = $dbp['deco_valeur'];
		}
		
	}

	//@formatter:off
	public function getDeco40_EleganceEntry ($data) { return $this->Deco40_Elegance[$data]; }
	public function getDeco40_Elegance() { return $this->Deco40_Elegance; }
	
	public function setDeco40_EleganceEntry ($entry, $data) { 
		if ( isset($this->Deco40_Elegance[$entry])) { $this->Deco40_Elegance[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeco40_Elegance($Deco40_Elegance) { $this->Deco40_Elegance = $Deco40_Elegance; }
	//@formatter:off

}


?>