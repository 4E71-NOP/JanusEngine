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
 * @author Faust
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

	/* @var $InstanceOfWebSiteContextObj WebSiteContext */
	private $InstanceOfWebSiteContextObj = null;
	
	/* @var $InstanceOfUserObj User */
	private $InstanceOfUserObj = null;
	
	/* @var $InstanceOfThemeDescriptorObj ThemeDescriptor */
	private $InstanceOfThemeDescriptorObj = null;

	/* @var $InstanceOfThemeDataObj ThemeData */
	private $InstanceOfThemeDataObj = null;

	/* @var $InstanceOfThemeDataObjBackup ThemeData */
	private $InstanceOfThemeDataObjBackup  = null;
	
	/* @var $InstanceOfGeneratedScriptObj GeneratedScript */
	private $InstanceOfGeneratedScriptObj = null;

	/* @var $InstanceOfDocumentDataObj DocumentData */
	private $InstanceOfDocumentDataObj = null;

	/* @var $InstanceOfModuleListObj ModuleList */
	private $InstanceOfModuleListObj = null;

	/* @var $InstanceOfLayoutObj Layout */
	private $InstanceOfLayoutObj = null;

	/* @var $InstanceOfArticleObj Article */
	private $InstanceOfArticleObj = null;

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
	public function getInstanceOfServerInfosObj()			{ return $this->InstanceOfServerInfosObj;}
	public function getInstanceOfSqlTableListObj()			{ return $this->InstanceOfSqlTableListObj; }
	public function getInstanceOfWebSiteObj()				{ return $this->InstanceOfWebSiteObj; }
	public function getInstanceOfWebSiteContextObj()		{ return $this->InstanceOfWebSiteContextObj; }
	public function getInstanceOfUserObj()					{ return $this->InstanceOfUserObj; }
	public function getInstanceOfThemeDescriptorObj()		{ return $this->InstanceOfThemeDescriptorObj; }
	public function getInstanceOfThemeDataObj()				{ return $this->InstanceOfThemeDataObj; }
	public function getInstanceOfGeneratedScriptObj()		{ return $this->InstanceOfGeneratedScriptObj; }
	public function getInstanceOfDocumentDataObj()			{ return $this->InstanceOfDocumentDataObj; }
	public function getInstanceOfLayoutObj()				{ return $this->InstanceOfLayoutObj; }
	public function getInstanceOfModuleListObj()			{ return $this->InstanceOfModuleListObj; }
	public function getInstanceOfArticleObj()				{ return $this->InstanceOfArticleObj; }
	public function getData()								{ return $this->data; }
	
	public function setInstanceOfServerInfosObj($InstanceOfServerInfos) 					{ $this->InstanceOfServerInfosObj = $InstanceOfServerInfos; }
	public function setInstanceOfSqlTableListObj($InstanceOfSqlTableList)					{ $this->InstanceOfSqlTableListObj = $InstanceOfSqlTableList; }
	public function setInstanceOfWebSiteObj($InstanceOfWebSiteObj)							{ $this->InstanceOfWebSiteObj = $InstanceOfWebSiteObj; }
	public function setInstanceOfWebSiteContextObj($InstanceOfWebSiteContextObj)			{ $this->InstanceOfWebSiteContextObj = $InstanceOfWebSiteContextObj; }
	public function setInstanceOfUserObj($InstanceOfUserObj)								{ $this->InstanceOfUserObj = $InstanceOfUserObj; }
	public function setInstanceOfThemeDescriptorObj($InstanceOfThemeDescriptorObj)			{ $this->InstanceOfThemeDescriptorObj = $InstanceOfThemeDescriptorObj; }
	public function setInstanceOfThemeDataObj($InstanceOfThemeDataObj)						{ $this->InstanceOfThemeDataObj = $InstanceOfThemeDataObj; }
	public function setInstanceOfGeneratedScriptObj($InstanceOfGeneratedScriptObj)			{ $this->InstanceOfGeneratedScriptObj = $InstanceOfGeneratedScriptObj; }
	public function setInstanceOfDocumentDataObj($InstanceOfDocumentDataObj)				{ $this->InstanceOfDocumentDataObj = $InstanceOfDocumentDataObj; }
	public function setInstanceOfLayoutObj($InstanceOfLayoutObj)							{ $this->InstanceOfLayoutObj = $InstanceOfLayoutObj; }
	public function setInstanceOfModuleListObj($InstanceOfModuleListObj)					{ $this->InstanceOfModuleListObj = $InstanceOfModuleListObj; }
	public function setInstanceOfArticleObj($InstanceOfArticleObj)							{ $this->InstanceOfArticleObj = $InstanceOfArticleObj; }
	//@formatter:on
	
}