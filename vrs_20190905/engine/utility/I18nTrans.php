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

class I18nTrans {
	private static $Instance = null;
	
	private $I18nTrans = array();
	
	private function __construct(){}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return I18nTrans
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new I18nTrans();
		}
		return self::$Instance;
	}
	
	/**
	 * Gets the I18nTrans data from the database and store it. The default package is 'initial' 
	 * @param string $package
	 */
	public function getI18nTransFromDB ($package = 'initial' ) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
// 		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : CurrentSet Language_id=".$CurrentSetObj->getDataEntry('language_id')) );
		
		$dbquery = $bts->SDDMObj->query ("
		SELECT i18n_name, i18n_text 
		FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('I18n')."
		WHERE i18n_package = '".$package."'
		AND lang_id = '". $CurrentSetObj->getDataEntry('language_id')."' 
		");
		$tab0 = $this->I18nTrans;
		$tab1 = array();
		while ( $dbp = $bts->SDDMObj->fetch_array_sql($dbquery) ) { $tab1[$dbp['i18n_name']] = $dbp['i18n_text']; }
		$this->I18nTrans = array_merge ($tab0, $tab1);
	}
	
	/**
	 * Merge the incoming array with the I18nTrans array.
	 * @param array $data
	 */
	public function apply($data) { 
		$tab0 = $this->I18nTrans;
		$this->I18nTrans = array_merge ($tab0, $data);
	}
	
	
	//@formatter:off
	public function getI18nTrans() { return $this->I18nTrans; }
	public function getI18nTransEntry($entry) { return $this->I18nTrans[$entry]; }
	public function setI18nTrans($I18nTrans) { $this->I18nTrans = $I18nTrans; }
	public function setI18nTransEntry($entry, $data) { $this->I18nTrans[$entry] = $data; }
	//@formatter:on
	
}

?>