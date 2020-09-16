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
class Deco10_Menu {
	private $Deco10_Menu = array ();
	public function __construct() {
	}
	public function getDeco10_MenuDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			$this->Deco10_Menu [$dbp['deco_variable']] = $dbp['deco_valeur'];
		}
		
	}

	//@formatter:off
	public function getDeco10_MenuEntry ($data) { return $this->Deco10_Menu[$data]; }
	public function getDeco10_Menu() { return $this->Deco10_Menu; }
	
	public function setDeco10_MenuEntry ($entry, $data) { 
		if ( isset($this->Deco10_Menu[$entry])) { $this->Deco10_Menu[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeco10_Menu($Deco10_Menu) { $this->Deco10_Menu = $Deco10_Menu; }
	//@formatter:off

}


?>