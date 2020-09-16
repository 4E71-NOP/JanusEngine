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
class Deco20_Caligraph {
	private $Deco20_Caligraph = array ();
	public function __construct() {
	}
	public function getDeco20_CaligraphDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "
			SELECT * 
			FROM ".$SqlTableListObj->getSQLTableName('deco_20_caligraphe')." 
			WHERE deco_id = '".$data."' 
			;" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			$this->Deco20_Caligraph [$dbp['deco_variable']] = $dbp['deco_valeur'];
		}
		
	}

	//@formatter:off
	public function getDeco20_CaligraphEntry ($data) { return $this->Deco20_Caligraph[$data]; }
	public function getDeco20_Caligraph() { return $this->Deco20_Caligraph; }
	
	public function setDeco20_CaligraphEntry ($entry, $data) { 
		if ( isset($this->Deco20_Caligraph[$entry])) { $this->Deco20_Caligraph[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeco20_Caligraph($Deco20_Caligraph) { $this->Deco20_Caligraph = $Deco20_Caligraph; }
	//@formatter:off

}


?>