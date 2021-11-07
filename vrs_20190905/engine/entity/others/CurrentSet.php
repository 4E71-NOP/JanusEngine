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
 * This object will store any volatile data.
 * It will provide access to any script or class that require to use/access the current XX (User, ThemeData etc).
 * Also it stores some variables in an array ($data)
 * @author faust
 * 
 */
class CurrentSet {
	private static $Instance = null;
	
	/* @var $InstanceOfServerInfosObj ServerInfos */
	private $InstanceOfServerInfosObj = null;

	/* @var $InstanceOfSqlTableListObj SqlTableList */
	private $InstanceOfSqlTableListObj = null;
	
	/* @var $InstanceOfWebSiteObj WebSite */
	private $InstanceOfWebSiteObj = null;

	/* @var $InstanceOfWebSiteContextObj WebSite */
	private $InstanceOfWebSiteContextObj = null;
	
	/* @var $InstanceOfUserObj User */
	private $InstanceOfUserObj = null;
	
	/* @var $InstanceOfThemeDescriptorObj ThemeDescriptor */
	private $InstanceOfThemeDescriptorObj = null;

	/* @var $InstanceOfThemeDataObj ThemeData */
	private $InstanceOfThemeDataObj = null;

	/* @var $InstanceOfThemeDataObjBackup ThemeData */
	private $InstanceOfThemeDataObjBackup  = null;
	
	/* @var $InstanceOfGeneratedJavaScriptObj GeneratedJavaScript */
	private $InstanceOfGeneratedJavaScriptObj = null;

	/* @var $InstanceOfDocumentDataObj DocumentData */
	private $InstanceOfDocumentDataObj = null;

	/* @var $InstanceOfModuleListObj DocumentData */
	private $InstanceOfModuleListObj = null;



	/* @var $data array */
	private $data = array();
	
	private function __construct(){}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new CurrentSet();
		}
		return self::$Instance;
	}
	
	public function getDataEntry ($lvl1) { return $this->data[$lvl1]; }
	public function setDataEntry ($lvl1, $data) { $this->data[$lvl1] = $data; }
	public function getDataSubEntry ($lvl1, $lvl2) { return $this->data[$lvl1][$lvl2]; }
	public function setDataSubEntry ($lvl1, $lvl2, $data) { $this->data[$lvl1][$lvl2] = $data; }
	
	public function backupInstanceOfThemeDataObj(){ $this->InstanceOfThemeDataObjBackup = $this->InstanceOfThemeDataObj; }
	public function restoreInstanceOfThemeDataObj(){ $this->InstanceOfThemeDataObj = $this->InstanceOfThemeDataObjBackup; }
	
	//@formatter:off
	public function getInstanceOfServerInfosObj() { return $this->InstanceOfServerInfos; }
	public function getInstanceOfSqlTableListObj() { return $this->InstanceOfSqlTableList; }
	public function getInstanceOfWebSiteObj() { return $this->InstanceOfWebSiteObj; }
	public function getInstanceOfWebSiteContextObj() { return $this->InstanceOfWebSiteContextObj; }
	public function getInstanceOfUserObj() { return $this->InstanceOfUserObj; }
	public function getInstanceOfThemeDescriptorObj() { return $this->InstanceOfThemeDescriptorObj; }
	public function getInstanceOfThemeDataObj() { return $this->InstanceOfThemeDataObj; }
	public function getInstanceOfGeneratedJavaScriptObj() { return $this->InstanceOfGeneratedJavaScriptObj; }
	public function getInstanceOfDocumentDataObj() { return $this->InstanceOfDocumentDataObj; }
	public function getInstanceOfModuleLisObj() { return $this->InstanceOfModuleLisObj; }
	public function getData() { return $this->data; }
	
	public function setInstanceOfServerInfosObj($InstanceOfServerInfos) { $this->InstanceOfServerInfos = $InstanceOfServerInfos; }
	public function setInstanceOfSqlTableListObj($InstanceOfSqlTableList) { $this->InstanceOfSqlTableList = $InstanceOfSqlTableList; }
	public function setInstanceOfWebSiteObj($InstanceOfWebSiteObj) { $this->InstanceOfWebSiteObj = $InstanceOfWebSiteObj; }
	public function setInstanceOfWebSiteContextObj($InstanceOfWebSiteContextObj) { $this->InstanceOfWebSiteContextObj = $InstanceOfWebSiteContextObj; }
	public function setInstanceOfUserObj($InstanceOfUserObj) { $this->InstanceOfUserObj = $InstanceOfUserObj; }
	public function setInstanceOfThemeDescriptorObj($InstanceOfThemeDescriptorObj) { $this->InstanceOfThemeDescriptorObj = $InstanceOfThemeDescriptorObj; }
	public function setInstanceOfThemeDataObj($InstanceOfThemeDataObj) { $this->InstanceOfThemeDataObj = $InstanceOfThemeDataObj; }
	public function setInstanceOfGeneratedJavaScriptObj($InstanceOfGeneratedJavaScriptObj) { $this->InstanceOfGeneratedJavaScriptObj = $InstanceOfGeneratedJavaScriptObj; }
	public function setInstanceOfDocumentDataObj($InstanceOfDocumentDataObj) { $this->InstanceOfDocumentDataObj = $InstanceOfDocumentDataObj; }
	public function setInstanceOfModuleLisObj($InstanceOfModuleLisObj) { $this->InstanceOfModuleLisObj = $InstanceOfModuleLisObj; }
	//@formatter:on



	
}