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
class Deco30_1Div {
	private $Deco30_1Div = array ();
	public function __construct() {
	}
	public function getDeco30_1DivDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ("SELECT *
			FROM ".$SqlTableListObj->getSQLTableName('deco_30_1_div')."
			WHERE deco_id = '".$data."'
		;");
		
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			$this->Deco30_1Div [$dbp['deco_variable']] = $dbp['deco_valeur'];
		}
		
	}

	//@formatter:off
	public function getDeco30_1DivEntry ($data) { return $this->Deco30_1Div[$data]; }
	public function getDeco30_1Div() { return $this->Deco30_1Div; }
	
	public function setDeco30_1DivEntry ($entry, $data) { 
		if ( isset($this->Deco30_1Div[$entry])) { $this->Deco30_1Div[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeco30_1Div($Deco30_1Div) { $this->Deco30_1Div = $Deco30_1Div; }
	//@formatter:off

}


?>