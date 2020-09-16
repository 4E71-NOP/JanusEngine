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
class Deco60_Elysion {
	private $Deco60_Elysion = array ();
	public function __construct() {
	}
	public function getDeco60_ElysionDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "
			SELECT *
			FROM ".$SqlTableListObj->getSQLTableName('deco_60_elysion')."
			WHERE deco_id = '".$data."'
			;" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			$this->Deco60_Elysion[$dbp['deco_variable']] = $dbp['deco_valeur'];
		}
		
	}

	//@formatter:off
	public function getDeco60_ElysionEntry ($data) { return $this->Deco60_Elysion[$data]; }
	public function getDeco60_Elysion() { return $this->Deco60_Elysion; }
	
	public function setDeco60_ElysionEntry ($entry, $data) { 
		if ( isset($this->Deco60_Elysion[$entry])) { $this->Deco60_Elysion[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeco60_Elysion($Deco60_Elysion) { $this->Deco60_Elysion = $Deco60_Elysion; }
	//@formatter:off

}


?>