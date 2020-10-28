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

class I18n {
	private static $Instance = null;
	
	private $i18n = array();
	
	private function __construct(){}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return I18n
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new I18n();
		}
		return self::$Instance;
	}
	
	/**
	 * Gets the i18n data from the database and store it. The default package is 'initial' 
	 * @param string $package
	 */
	public function getI18nFromDB ($package = 'initial' ) {
		$cs = CommonSystem::getInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $cs->SDDMObj->query ("
		SELECT i18n_name, i18n_text FROM ".$SqlTableListObj->getSQLTableName('i18n')."
		WHERE i18n_package = '".$package."'
		AND lang_id = '".$CurrentSetObj->getDataEntry('language_id')."' 
		");
		$tab0 = $this->i18n;
		$tab1 = array();
		while ( $dbp = $cs->SDDMObj->fetch_array_sql($dbquery) ) { $tab1[$dbp['i18n_name']] = $dbp['i18n_text']; }
		$this->i18n = array_merge ($tab0, $tab1);
	}
	
	/**
	 * Merge the incoming array with the i18n array.
	 * @param array $data
	 */
	public function apply($data) { 
		$tab0 = $this->i18n;
		$this->i18n = array_merge ($tab0, $data);
	}
	
	
	//@formatter:off
	public function getI18n() { return $this->i18n; }
	public function getI18nEntry($entry) { return $this->i18n[$entry]; }
	public function setI18n($i18n) { $this->i18n = $i18n; }
	public function setI18nEntry($entry, $data) { $this->i18n[$entry] = $data; }
	//@formatter:on
	
}

?>