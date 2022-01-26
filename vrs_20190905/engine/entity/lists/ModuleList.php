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
	 * Prepare list of modules.
	 */
	public function makeModuleList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$q = "SELECT * FROM "
			.$SqlTableListObj->getSQLTableName('module')." m, "
			.$SqlTableListObj->getSQLTableName('module_website')." wm
			WHERE wm.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
			AND m.module_id = wm.fk_module_id
			AND wm.module_state = '1'
			AND m.fk_perm_id ".$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('clause_in_perm')."
			AND m.module_adm_control = '0'
			ORDER BY module_position
			;";
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : ModuleList query `".$bts->StringFormatObj->formatToLog($q)."`."));
		$dbquery = $bts->SDDMObj->query($q);
		if ( $bts->SDDMObj->num_row_sql($dbquery) > 0 ) {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ( $dbp as $A => $B ) { 
					$this->ModuleList[$dbp['module_name']][$A] = $B; 
				}
				$this->ModuleList[$dbp['module_id']] = &$this->ModuleList[$dbp['module_name']]; 
			}
			// $bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : ModuleList ". $bts->StringFormatObj->arrayToString($this->ModuleList)));
		}
		else { $bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : no SQL rows for module list ")); }		
	}

	/**
	 * Prepare list of installation modules (specific to install ONLY).
	 */
	public function makeInstallModuleList(){

		$this->ModuleList['installtitle'] = array(
			"module_id" => "1",
			"module_deco" => "1",
			"module_deco_nbr" => "1",
			"module_deco_default_text" => "",
			"module_name" => "installtitle",
			"module_classname" => "InstallTitle",
			"module_container_name" => "InstallTitleContainer",
			"module_title" => "",
			"module_directory"   => "modules/initial/InstallTitle/", 
			"module_file"   => "module_install_title.php", 
		);
		$this->ModuleList['installdocument'] = array(
			"module_id" => "2",
			"module_deco" => "1",
			"module_deco_nbr" => "2",
			"module_deco_default_text" => "",
			"module_name" => "installdocument",
			"module_classname" => "InstallDocument",
			"module_container_name" => "InstallDocumentContainer",
			"module_title" => "",
			"module_directory"   => "modules/initial/InstallDocument/", 
			"module_file"   => "module_install_document.php", 
		);
		$this->ModuleList['tooltip'] = array(
			"module_id" => "3",
			"module_deco" => "1",
			"module_deco_nbr" => "20",
			"module_deco_default_text" => "",
			"module_name" => "tooltip",
			"module_classname" => "ModuleTooltip",
			"module_container_name" => "InstallModuleTooltip",
			"module_title" => "",
			"module_directory"   => "modules/initial/Tooltip/", 
			"module_file"   => "module_tooltip.php", 
		);

		$this->ModuleList['installmonitor'] = array(
			"module_id" => "1",
			"module_deco" => "1",
			"module_deco_nbr" => "2",
			"module_deco_default_text" => "",
			"module_name" => "installmonitor",
			"module_classname" => "InstallMonitor",
			"module_container_name" => "InstallMonitorContainer",
			"module_title" => "",
			"module_directory"   => "modules/initial/InstallMonitor/", 
			"module_file"   => "module_install_monitor.php", 
		);
	}

	/**
	 * Prepare list of installation modules (specific to install monitor ONLY).
	 * @deprecated
	 */
	// public function makeMonitorModuleList(){
	// 	$this->ModuleList['installmonitor'] = array(
	// 		"module_id" => "1",
	// 		"module_deco" => "1",
	// 		"module_deco_nbr" => "2",
	// 		"module_deco_default_text" => "",
	// 		"module_name" => "installmonitor",
	// 		"module_classname" => "InstallMonitor",
	// 		"module_container_name" => "InstallMonitorContainer",
	// 		"module_title" => "",
	// 		"module_directory"   => "modules/initial/InstallMonitor/", 
	// 		"module_file"   => "module_install_monitor.php", 
	// 	);
	// }

	//@formatter:off
	public function getModuleList() { return $this->ModuleList; }
	public function getModuleListEntry($data) { return $this->ModuleList[$data]; }
	
	public function setModuleList($data) { $this->ModuleList = $data; }
	public function setModuleListEntry($entry , $data) { $this->ModuleList[$entry] = $data; }
	//@formatter:on


}

?>
	