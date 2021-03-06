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

class ConfigurationManagement {
	private static $Instance = null;
	/**
	 * 
	 * @return multitype:
	 * The $Configuration array contains:
	 * 'type', 'host', 'dal', 'db_user_login', 'db_user_password', 'dbprefix', 'tabprefix',
	 * 'maid_stats_nombre_de_couleurs', 'SessionMaxAge', 'pde_img_aff', 'pde_img_h', 'pde_img_l', 
	 * 'DebugLevel_SQL', 'DebugLevel_CC', 'DebugLevel_PHP', 'DebugLevel_JS', 'LogTarget'
	 * 'execution_context', 'mode_operatoire', 'InsertStatistics', 'installMonitor'
	 *  
	 **/
	private $Configuration = array();
	private $LanguageList = array();

	private function __construct(){ }

	/**
	 * 
	 * @return ConfigurationManagement
	 * There is only ONE configuration for ONE execution. Singleton it is!
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new ConfigurationManagement();
		}
		return self::$Instance;
	}

	public function InitBasicSettings () {
		$this->Configuration['SessionMaxAge'] = 60*60*48;
	}
	
	/**
	 * 
	 * Load a config file that contains a class/function. This last one will return an array.
	 * 
	 */
	public function LoadConfigFile() {
		$cs = CommonSystem::getInstance();
// 		$CurrentSetObj = CurrentSet::getInstance();
		
		$configFile = "config/current/site_" . $cs->SMObj->getSessionEntry('ws') . "_config.php";
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "ConfigurationManagement-LoadConfigFile : config file =`".$configFile."`."));
		$pv['ObjectMode'] = 1; //during migration avoid re-delcaring the same function.
		if ( file_exists($configFile)) { include ($configFile); }
		else {
			$cs->SMObj->ResetSession();
			$configFile = "config/current/site_" . $cs->SMObj->getSessionEntry('ws') . "_config.php";
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "ConfigurationManagement-LoadConfigFile : config file =`".$configFile."`."));
			include ($configFile);
		}
		$CurrentConfig = returnConfig();
		foreach ( $CurrentConfig as $A => $B ) { $this->Configuration[$A] = $B; }
	}
	
	/**
	 * Returns the $this->Configuration variable.
	 * @return array
	 */
	public function ConfigDump () { return $this->Configuration; }
	
	
	/**
	 * 
	 * Create a table with the supported languages informations we need to support I18N on this site.
	 */
	public function PopulateLanguageList () {
		
		switch ( $this->Configuration['execution_context'] ) {
			case "installation":
				// No DB data available for a short time; so we create it.
				$this->LanguageList = array (
					38 => array (
					"lang_id" => 38,
					"lang_639_3" => "eng",
					"lang_original_name" => "English",
					"lang_639_2" => "eng",
					"lang_639_1" => "en",
					"lang_image" => "tl_eng.png",
					),
					"eng" => array ( "lang_id" => 38),
					48 => array 
					(
					"lang_id" => 48,
					"lang_639_3" => "fra",
					"lang_original_name" => "Français ; langue française",
					"lang_639_2" => "fre/fra",
					"lang_639_1" => "fr",
					"lang_image" => "tl_fra.png",
					),
					"fra" => array ("lang_id" => 48)
				);
				break;
			case "render":
			default:
				$cs = CommonSystem::getInstance();
				$CurrentSetObj = CurrentSet::getInstance();
				$this->LanguageList = array ();
// 				$SqlTableListObj = SqlTableList::getInstance(null, null);
				
				$TabLangueAdmises = array();
				$dbquery = $cs->SDDMObj->query("SELECT * FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language_website')." WHERE ws_id = '".$cs->SMObj->getSessionEntry('ws')."';");
				while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) { $TabLangueAdmises[] = $dbp['lang_id']; }
				sort ( $TabLangueAdmises );
				
				$dbquery = $cs->SDDMObj->query("SELECT * FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language').";");
				while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) {
					$idx = $dbp['lang_id'];
					$TableRendu = 0;
					reset ( $TabLangueAdmises );
					foreach ( $TabLangueAdmises as $B ) { if ( $B == $dbp['lang_id'] ) { $TableRendu = 1; } }
					if ( $TableRendu == 1 ) {
						foreach ( $dbp as $A => $B ) { $this->LanguageList[$idx][$A] = $B; }
						$this->LanguageList[$dbp['lang_639_3']] = &$this->LanguageList[$idx];
					}
				}
				break;
		}
	}
	
	public function setLangSupport () {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $cs->SDDMObj->query("
			SELECT sl.lang_id
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language_website')." sl , ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')." s
			WHERE s.ws_id ='".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
			AND sl.ws_id = s.ws_id
			;");
		while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) { $this->LanguageList[$dbp['lang_id']]['support'] = 1; }
		
	}
	
	//@formatter:off
	public function getConfigurationEntry ($data) { return $this->Configuration[$data];}
	public function getConfigurationSubEntry ($lvl1, $lvl2) { return $this->Configuration[$lvl1][$lvl2];}
	public function getConfiguration() { return $this->Configuration; }
	public function getExecutionContext () { return $this->Configuration['execution_context']; }
	public function getLanguageList() { return $this->LanguageList; }
	public function getLanguageListEntry($data) { return $this->LanguageList[$data]; }
	public function getLanguageListSubEntry($Lvl1 , $lvl2) { return $this->LanguageList[$Lvl1][$lvl2]; }

	public function setConfigurationEntry ($entry, $data) { $this->Configuration[$entry] = $data;}
	public function setConfigurationSubEntry ($lvl1, $lvl2, $data) { $this->Configuration[$lvl1][$lvl2] = $data;}
	public function setConfiguration($Configuration) { $this->Configuration = $Configuration; }
	public function setExecutionContext ($data) { $this->Configuration['execution_context'] = $data; }
	public function setLanguageList($LanguageList) { $this->LanguageList = $LanguageList; }

	public function toStringConfiguration() {
		$str = "Configuration : ";
		foreach ( $this->Configuration as $A => $B ) { $str .= $A."=".$B."; "; }
		return $str;
	}
	//@formatter:on

}

?>