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
class LayoutContent extends Entity {
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
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for layout_content id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->LayoutContent[$A] = $B; }
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for layout_content id=".$id));
		}
	}
	
	
	/**
	 * Updates or inserts in DB the local data.
	 * mode ar available: <br>
	 * <br>
	 * 0 = insert or update - Depending on the Id existing in DB or not, it'll be UPDATE or INSERT<br>
	 * 1 = insert only - Supposedly a new ID and not an existing one<br>
	 * 2 = update only - Supposedly an existing ID<br>
	 */
	public function sendToDB($mode = OBJECT_SENDTODB_MODE_DEFAULT){
		$genericActionArray = array(
			'columns'		=> $this->columns,
			'data'			=> $this->LayoutContent,
			'targetTable'	=> 'layout_content',
			'targetColumn'	=> 'lyoc_id',
			'entityId'		=> $this->LayoutContent['lyoc_id'],
			'entityTitle'	=> 'layoutContent'
	);
	if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $this->genericUpdateDb($genericActionArray);}
	elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $this->genericInsertInDb($genericActionArray); }
}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->entityExistsInDb('layout_content', $this->LayoutContent['lyoc_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		if ( $this->entityExistsInDb('layout', $this->LayoutContent['layout_id']) == false ) { $res = false; }
		return $res;
	}
	
	
	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$date = time ();
		$tab = $this->columns;
		// $this->LayoutContent['lyoc_name'] .= "-".date("d_M_Y_H:i:s", time());
		
		return $tab;
	}
	
	/**
	 * Returns an array containing the list of states for this entity.
	 * Useful for menu select amongst other things.
	 * @return array()
	 */
	public function getMenuOptionArray () {
		$bts = BaseToolSet::getInstance();
		return array (
			'state' => array (
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			));
	}
	

	
	
	//@formatter:off
	public function getLayoutContentEntry ($data) { return $this->LayoutContent[$data]; }
	public function getLayoutContent() { return $this->LayoutContent; }
	
	public function setLayoutContentEntry ($entry, $data) { 
		if ( isset($this->LayoutContent[$entry])) { $this->LayoutContent[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setLayoutContent($LayoutContent) { $this->LayoutContent = $LayoutContent; }
	//@formatter:off

}


?>