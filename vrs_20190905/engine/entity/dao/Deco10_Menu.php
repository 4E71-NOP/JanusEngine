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
	public function getDeco10_MenuDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('deco_10_menu') . "
			WHERE fk_deco_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for deco_10_menu id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$this->Deco10_Menu[$dbp['deco_variable_name']] = $dbp['deco_value'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for deco_10_menu id=".$id));
			$res = false;
		}
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
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