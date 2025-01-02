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

class I18nTrans
{
	private static $Instance = null;

	private $I18nTrans = array();

	private function __construct()
	{
	}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return I18nTrans
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new I18nTrans();
		}
		return self::$Instance;
	}

	/**
	 * Gets the I18nTrans data from the database and store it. The default package is 'initial' 
	 * @param string $package
	 */
	public function getI18nTransFromDB($package = 'initial')
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : CurrentSet Language_id=" . $CurrentSetObj->getDataEntry('language_id')));

		$dbquery = $bts->SDDMObj->query("
			SELECT i18n_name, i18n_text 
			FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('i18n') . "
			WHERE i18n_package = '" . $package . "'
			AND fk_lang_id = '" . $CurrentSetObj->getDataEntry('language_id') . "' 
			");
		$tab0 = $this->I18nTrans;
		$tab1 = array();
		while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
			$tab1[$dbp['i18n_name']] = $dbp['i18n_text'];
		}
		$this->I18nTrans = array_merge($tab0, $tab1);
	}

	/**
	 * Merge the incoming array with the I18nTrans array.
	 * @param array $data
	 */
	public function apply($data)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		if (!empty($CurrentSetObj->getDataEntry('language'))) {
			if (is_array($data)) {
				$tab0 = $this->I18nTrans;
				switch ($data['type']) {
					case "array":
						if (is_array($data[$CurrentSetObj->getDataEntry('language')])) {
							$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Merging "));
							$this->I18nTrans = array_merge($tab0, $data[$CurrentSetObj->getDataEntry('language')]);
						} else {
							$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : Couldn't merge data. It's not an array."));
						}
						break;
					case "file":
						switch ($data['format']) {
							case 'php':
								$i18n = array();
								$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : loading " . $data['file']));
								if (file_exists($data['file'])) {
									include($data['file']); // will create $i18n
									$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Merging "));
									$this->I18nTrans = array_merge($tab0, $i18n);
									$bts->LMObj->msgLog(array('level' => LOGLEVEL_INFORMATION, 'msg' => __METHOD__ . " : I18n file loaded (" . $data['file'] . ") "));
								} else {
									$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : I18n file not found (" . $data['file'] . ") "));
								}
								break;
							case 'lang':
								// Some day...
								break;
						}
						break;
				}
			}
			if (is_array($file)) {
			}
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : CurrentSetObj->language is empty. I don't know where to put the data."));
		}
	}

	//@formatter:off
	public function getI18nTrans()
	{
		return $this->I18nTrans;
	}
	public function getI18nTransEntry($entry)
	{
		return $this->I18nTrans[$entry];
	}
	public function setI18nTrans($I18nTrans)
	{
		$this->I18nTrans = $I18nTrans;
	}
	public function setI18nTransEntry($entry, $data)
	{
		$this->I18nTrans[$entry] = $data;
	}
	//@formatter:on

}
