<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

class ConfigurationManagement
{
	private static $Instance = null;
	/**
	 * 
	 * The $Configuration array contains:
	 * 'type', 'host', 'dal', 'db_user_login', 'db_user_password', 'dbprefix', 'tabprefix',
	 * 'SessionMaxAge', 'pde_img_aff', 'pde_img_h', 'pde_img_l', 
	 * 'DebugLevel_SQL', 'DebugLevel_CC', 'DebugLevel_PHP', 'DebugLevel_JS', 'LogTarget'
	 * 'execution_context', 'InsertStatistics', 'installMonitor'
	 *  
	 **/
	private $Configuration = array();
	private $LanguageList = array();

	private function __construct()
	{
	}

	/**
	 * 
	 * @return ConfigurationManagement
	 * There is only ONE configuration for ONE execution. Singleton it is!
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new ConfigurationManagement();
		}
		return self::$Instance;
	}

	public function InitBasicSettings()
	{
		$this->Configuration['SessionMaxAge'] = 60 * 60 * 48;
	}

	/**
	 * 
	 * Load a config file that contains a class/function. This last one will return an array.
	 * 
	 */
	public function LoadConfigFile()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite

		$configFile = "current/config/current/site_" . $currentWs . "_config.php";
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : config file =`" . $configFile . "`."));
		if (file_exists($configFile)) {
			include($configFile);
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : config file `" . $configFile . "` doesn't exists -> reset session."));
			$bts->SMObj->ResetSession();
			$configFile = "current/config/current/site_" . $currentWs . "_config.php";
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : config file =`" . $configFile . "`."));
			include($configFile);
		}
		//$CurrentConfig = returnConfig();
		// $fileContent is assign in the config file
		foreach ($fileContent as $A => $B) {
			$this->Configuration[$A] = $B;
		}
		return true;
	}

	/**
	 * Returns the $this->Configuration variable.
	 * @return array
	 */
	public function ConfigDump()
	{
		return array("Configuration" => $this->Configuration, "LanguageList" => $this->LanguageList);
	}

	/**
	 * 
	 * Create a table with the supported languages informations we need to support I18N on this site.
	 */
	public function PopulateLanguageList()
	{
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite

		switch ($this->Configuration['execution_context']) {
			case "installation":
				// No DB data available for a short time; so we create it.
				$this->LanguageList = array(
					38 => array(
						"lang_id" => 38,
						"lang_639_3" => "eng",
						"lang_original_name" => "English",
						"lang_639_2" => "eng",
						"lang_639_1" => "en",
						"lang_image" => "tl_eng.png",
					),
					"eng" => array("lang_id" => 38),
					48 => array(
						"lang_id" => 48,
						"lang_639_3" => "fra",
						"lang_original_name" => "Français ; langue française",
						"lang_639_2" => "fre/fra",
						"lang_639_1" => "fr",
						"lang_image" => "tl_fra.png",
					),
					"fra" => array("lang_id" => 48)
				);
				break;
			case "render":
			default:
				$bts = BaseToolSet::getInstance();
				$CurrentSetObj = CurrentSet::getInstance();
				$this->LanguageList = array();

				$TabLangueAdmises = array();
				$q = "SELECT ws.ws_short, lw.fk_lang_id 
					FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('language_website') . " lw,
					" . $CurrentSetObj->SqlTableListObj->getSQLTableName('website') . " ws 
					WHERE ws.ws_id = lw.fk_ws_id 
					AND ws.ws_short = '" . $currentWs . "'
					;";
				$dbquery = $bts->SDDMObj->query($q);

				if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
					while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
						$TabLangueAdmises[] = $dbp['fk_lang_id'];
					}
					sort($TabLangueAdmises);

					$q = "SELECT * FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('language') . ";";
					$dbquery = $bts->SDDMObj->query($q);
					if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
						while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
							$idx = $dbp['lang_id'];
							$TableRendu = 0;
							reset($TabLangueAdmises);
							foreach ($TabLangueAdmises as $B) {
								if ($B == $dbp['lang_id']) {
									$TableRendu = 1;
								}
							}
							if ($TableRendu == 1) {
								foreach ($dbp as $A => $B) {
									$this->LanguageList[$idx][$A] = $B;
								}
								$this->LanguageList[$dbp['lang_639_3']] = &$this->LanguageList[$idx];
							}
						}
					} else {
						$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . "  : No rows returned for q=`" . $q . "`"));
					}
				} else {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . "  : No rows returned for q=`" . $q . "`"));
				}
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "  : Render mode. LanguageList=" . $bts->StringFormatObj->arrayToString($this->LanguageList)));
				break;
		}
		return true;
	}

	public function setLangSupport()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$q = "SELECT lw.fk_lang_id FROM "
			. $CurrentSetObj->SqlTableListObj->getSQLTableName('language_website') . " lw , "
			. $CurrentSetObj->SqlTableListObj->getSQLTableName('website') . " w
			WHERE w.ws_id ='" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id') . "'
			AND lw.fk_ws_id = w.ws_id
			;";

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : q =" . $q));
		$dbquery = $bts->SDDMObj->query($q);

		while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
			$this->LanguageList[$dbp['fk_lang_id']]['support'] = 1;
		}
	}

	//@formatter:off
	public function getConfigurationEntry($data)
	{
		return $this->Configuration[$data];
	}
	public function getConfigurationSubEntry($lvl1, $lvl2)
	{
		return $this->Configuration[$lvl1][$lvl2];
	}
	public function getConfiguration()
	{
		return $this->Configuration;
	}
	public function getExecutionContext()
	{
		return $this->Configuration['execution_context'];
	}
	public function getLanguageList()
	{
		return $this->LanguageList;
	}
	public function getLanguageListEntry($data)
	{
		return $this->LanguageList[$data];
	}
	public function getLanguageListSubEntry($Lvl1, $lvl2)
	{
		return $this->LanguageList[$Lvl1][$lvl2];
	}

	public function setConfigurationEntry($entry, $data)
	{
		$this->Configuration[$entry] = $data;
	}
	public function setConfigurationSubEntry($lvl1, $lvl2, $data)
	{
		$this->Configuration[$lvl1][$lvl2] = $data;
	}
	public function setConfiguration($Configuration)
	{
		$this->Configuration = $Configuration;
	}
	public function setExecutionContext($data)
	{
		$this->Configuration['execution_context'] = $data;
	}
	public function setLanguageList($LanguageList)
	{
		$this->LanguageList = $LanguageList;
	}

	public function toStringConfiguration()
	{
		$str = "Configuration : ";
		foreach ($this->Configuration as $A => $B) {
			$str .= $A . "=" . $B . "; ";
		}
		return $str;
	}
	//@formatter:on

}
