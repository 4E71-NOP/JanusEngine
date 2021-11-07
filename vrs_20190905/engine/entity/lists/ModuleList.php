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
 * This class is considered as an entity as it is responsible for hosting the necessary data for the layout
 * @author faust
 *
 */
class ModuleList {
	private static $Instance = null;
	private $ModuleList = array();
	
	public function __construct() {}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new ModuleList();
		}
		return self::$Instance;
	}
	/**
	 * Renders the layout that will be used for rendering the modules.
	 */
	public function makeModuleList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$dbquery = $bts->SDDMObj->query("
			SELECT * FROM "
			.$SqlTableListObj->getSQLTableName('module')." m, "
			.$SqlTableListObj->getSQLTableName('module_website')." wm
			WHERE wm.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
			AND m.module_id = wm.fk_module_id
			AND wm.module_state = '1'
			AND m.module_group_allowed_to_see ".$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('clause_in_group')."
			AND m.module_adm_control = '0'
			ORDER BY module_position
			;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) > 0 ) {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ( $dbp as $A => $B ) { $this->ModuleList[$dbp['module_name']][$A] = $B; }
			}
			// $bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : ModuleList ". $bts->StringFormatObj->arrayToString($this->ModuleList)));
		}
		else { $bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : no SQL rows for module list ")); }
				
	}

	//@formatter:off
	public function getModuleList() { return $this->ModuleList; }
	public function getModuleListEntry($data) { return $this->ModuleList[$data]; }
	
	public function setModuleList($Layout) { $this->ModuleList = $Layout; }
	public function setModuleListEntry($entry , $data) { $this->ModuleList[$entry] = $data; }
	//@formatter:on

}

?>
	