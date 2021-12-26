<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/**
 * This object is the common data to help manage menus. Modules should use it more than local SQL queries.
 */
class MenuData {
	private $MenuDataRaw = array();
	private $MenuDataTree = array();
	private $EntryPoint = array();

	private $Iteration = 0;
	private $maxIteration = 5;

	public function __construct(){}

	public function RenderMenuData () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$localisation = " / MenuData";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("MenuData");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("MenuData");
		
		$query = "
		SELECT mnu.* FROM "
		.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('menu')." mnu, "
		.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('deadline')." bcl
		WHERE mnu.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		AND mnu.fk_lang_id = '".$CurrentSetObj->getDataEntry ( 'language_id')."'
		AND mnu.fk_deadline_id = bcl.deadline_id
		AND bcl.deadline_state = '1'
		AND mnu.menu_type IN ('0','1')
		AND mnu.fk_group_id ".$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('clause_in_group')."
		AND mnu.menu_state = '1'
		ORDER BY mnu.menu_parent,mnu.menu_position
		;";
		// $bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : Query :" . $query ));
		
		$dbquery = $bts->SDDMObj->query($query);
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0) { 
			$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ ." : No rows for menu query."));
		}
		else {
			$this->MenuDataRaw = array();
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$menu_id_index = $dbp['menu_id'];
				$this->MenuDataRaw[$menu_id_index] = array (
					"menu_id"			=> $dbp['menu_id'],
					"menu_type"			=> $dbp['menu_type'],
					"menu_title"		=> $dbp['menu_title'],
					"menu_desc"			=> $dbp['menu_desc'],
					"menu_parent"		=> $dbp['menu_parent'],
					"menu_position"		=> $dbp['menu_position'],
					"fk_group_id" 		=> $dbp['fk_group_id'],
					"fk_arti_ref"		=> $dbp['fk_arti_ref'],
					"fk_arti_slug"		=> $dbp['fk_arti_slug'],
				);
				if ( $dbp['menu_type'] == 0 ) { $this->EntryPoint = $dbp['menu_id']; }
			}
			$this->MenuDataTree[$this->EntryPoint] = $this->MenuDataRaw[$this->EntryPoint];
			$this->buildTree($this->MenuDataTree);
			$this->MenuDataTree['theme_name'] = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName();
		}
	}

	/**
	 * Check if a menu has at least one child.
	 * @param integer $parent
	 * @return boolean
	 */
	public function hasChild($parent) {
		foreach ($this->MenuDataRaw as $A ) {
			if ($A['menu_parent'] == $parent) { return true; }
		}
		return false;
	}

	/**
	 * Build an array containing the MenuData for one parent
	 * @param integer $parent
	 * @return array
	 * 
	 */
	private function buildBranch($parent) {
		$bts = BaseToolSet::getInstance();
		$arr = array();
		foreach ($this->MenuDataRaw as $A ) {
			if ($A['menu_parent'] == $parent) { 
				$arr[$A['menu_position']] = $A;
			}
		}
		asort($arr);
		return ($arr);
	}

	/**
	 * Builds an array in the form of a tree
	 * @param array $treePos
	 * 
	 */
	private function buildTree( &$treePos ){
		$bts = BaseToolSet::getInstance();
		foreach ( $treePos as &$A ) {
			// $bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : A['menu_id']=".$A['menu_id']));

			if ( $this->hasChild($A['menu_id']) === true ) {
				$A['children'] = $this->buildBranch($A['menu_id']);
				
				if ( $this->Iteration < $this->maxIteration ) {
					$this->buildTree($A['children']);
					$this->Iteration++;
				}
			}
		}
	}

	//@formatter:off
	public function getMenuDataRaw () { return $this->MenuDataRaw; }
	public function getMenuDataRawEntry ($data) { return $this->MenuDataRaw[$data]; }
	public function getMenuDataTree () { return $this->MenuDataTree; }
	public function getMenuDataTreeEntry ($data) { return $this->MenuDataTree[$data]; }
	public function getEntryPoint() { return $this->EntryPoint; }
	//@formatter:on

}