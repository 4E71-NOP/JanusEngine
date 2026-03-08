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

class MiscTools {
	private static $Instance = null;
	
	private function __construct(){}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return MiscTools
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new MiscTools();
		}
		return self::$Instance;
	}


	/**
	 * Returns the list of enabled infos_config. It will be used for user modification, form and commands.
	 */
	public function makeInfosConfigList($section, $prefix, $sufix)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));

		$q = "SELECT * "
			. "FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('infos_config') . " "
			. "WHERE infcfg_enabled = 1 "
			. "AND infcfg_section = '" . $section . "' "
			. "AND fk_ws_id = '" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id') . "' "
			. "ORDER BY infcfg_order;";
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "q=`" . $q . "`"));

		$tabRet = array();
		$dbquery = $bts->SDDMObj->query($q);
		if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for infos_config."));
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ($dbp as $A => $B) {
					$tabRet[$dbp['infcfg_id']] = array(
						"infcfg_id"				=>		$dbp['infcfg_id'],
						"fk_ws_id"				=>		$dbp['fk_ws_id'],
						"infcfg_section"		=>		$dbp['infcfg_section'],
						"infcfg_formName"		=>		$prefix . $dbp['infcfg_field'] . $sufix,
						"infcfg_field"			=>		$dbp['infcfg_field'],
						"infcfg_label_ref"		=>		$dbp['infcfg_label_ref'],
						"infcfg_enabled"		=>		$dbp['infcfg_enabled'],
						"infcfg_type"			=>		$dbp['infcfg_type'],
						"infcfg_order"			=>		$dbp['infcfg_order'],
					);
				}
			}
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for infos_config."));
			return false;
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $tabRet;
	}



}