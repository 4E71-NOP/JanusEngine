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

/**
 * This class needs a rework asd the model too. It'll wait a little bit for implementing 
 * @author faust
 *
 */
class LayoutContent {
	private $LayoutContent = array ();
	
	//@formatter:off
	private $columns = array(
			'lyoc_id'					=> 0,
			'layout_id'					=> 0,
			'lyoc_line'					=> 0,
			'lyoc_minimum_x'			=> 0,
			'lyoc_minimum_y'			=> 0,
			'lyoc_module_name'			=> 0,
			'lyoc_calculation_type'		=> 0,
			'lyoc_position_x'			=> 0,
			'lyoc_position_y'			=> 0,
			'lyoc_size_x'				=> 0,
			'lyoc_size_y'				=> 0,
			'lyoc_module_anchor_e1a'	=> 0,
			'lyoc_anchor_ex1a'			=> 0,
			'lyoc_anchor_ey1a'			=> 0,
			'lyoc_module_anchor_e1b'	=> 0,
			'lyoc_anchor_ex1b'			=> 0,
			'lyoc_anchor_ey1b'			=> 0,
			'lyoc_module_anchor_e1c'	=> 0,
			'lyoc_anchor_ex1c'			=> 0,
			'lyoc_anchor_ey1c'			=> 0,
			'lyoc_module_anchor_e1d'	=> 0,
			'lyoc_anchor_ex1d'			=> 0,
			'lyoc_anchor_ey1d'			=> 0,
			'lyoc_module_anchor_e1e'	=> 0,
			'lyoc_anchor_ex1e'			=> 0,
			'lyoc_anchor_ey1e'			=> 0,
			'lyoc_module_anchor_e2a'	=> 0,
			'lyoc_anchor_ex2a'			=> 0,
			'lyoc_anchor_ey2a'			=> 0,
			'lyoc_module_anchor_e2b'	=> 0,
			'lyoc_anchor_ex2b'			=> 0,
			'lyoc_anchor_ey2b'			=> 0,
			'lyoc_module_anchor_e2c'	=> 0,
			'lyoc_anchor_ex2c'			=> 0,
			'lyoc_anchor_ey2c'			=> 0,
			'lyoc_module_anchor_e2d'	=> 0,
			'lyoc_anchor_ex2d'			=> 0,
			'lyoc_anchor_ey2d'			=> 0,
			'lyoc_module_anchor_e2e'	=> 0,
			'lyoc_anchor_ex2e'			=> 0,
			'lyoc_anchor_ey2e'			=> 0,
			'lyoc_module_anchor_e3a'	=> 0,
			'lyoc_anchor_ex3a'			=> 0,
			'lyoc_anchor_ey3a'			=> 0,
			'lyoc_module_anchor_e3b'	=> 0,
			'lyoc_anchor_ex3b'			=> 0,
			'lyoc_anchor_ey3b'			=> 0,
			'lyoc_module_anchor_e3c'	=> 0,
			'lyoc_anchor_ex3c'			=> 0,
			'lyoc_anchor_ey3c'			=> 0,
			'lyoc_module_anchor_e3d'	=> 0,
			'lyoc_anchor_ex3d'			=> 0,
			'lyoc_anchor_ey3d'			=> 0,
			'lyoc_module_anchor_e3e'	=> 0,
			'lyoc_anchor_ex3e'			=> 0,
			'lyoc_anchor_ey3e'			=> 0,
			'lyoc_anchor_dx10'			=> 0,
			'lyoc_anchor_dy10'			=> 0,
			'lyoc_anchor_dx20'			=> 0,
			'lyoc_anchor_dy20'			=> 0,
			'lyoc_anchor_dx30'			=> 0,
			'lyoc_anchor_dy30'			=> 0,
			'lyoc_margin_left'			=> 0,
			'lyoc_margin_right'			=> 0,
			'lyoc_margin_top'			=> 0,
			'lyoc_margin_bottom'		=> 0,
			'lyoc_module_zindex'		=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->LayoutContent= $this->getDefaultValues();
	}
	/**
	 * Gets layoutContent data from the database.<br>
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('layout_content') . "
			WHERE lyoc_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for layout_content id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->LayoutDefinition[$A] = $B; }
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for layout_content id=".$id));
		}
	}
	
	
	
	//@formatter:off
	public function getLayoutDefinitionEntry ($data) { return $this->LayoutDefinition[$data]; }
	public function getLayoutDefinition() { return $this->LayoutDefinition; }
	
	public function setLayoutDefinitionEntry ($entry, $data) { 
		if ( isset($this->LayoutDefinition[$entry])) { $this->LayoutDefinition[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setLayoutDefinition($LayoutDefinition) { $this->LayoutDefinition = $LayoutDefinition; }
	//@formatter:off

}


?>