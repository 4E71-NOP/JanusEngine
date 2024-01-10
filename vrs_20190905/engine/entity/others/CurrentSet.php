<?php
/*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
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
	
	/* @var $ServerInfosObj ServerInfos */
	public $ServerInfosObj = null;

	/* @var $SqlTableListObj SqlTableList */
	public $SqlTableListObj = null;
	
	/* @var $WebSiteObj WebSite */
	public $WebSiteObj = null;

	/* @var $WebSiteContextObj WebSiteContext */
	public $WebSiteContextObj = null;
	
	/* @var $UserObj User */
	public $UserObj = null;
	
	/* @var $ThemeDescriptorObj ThemeDescriptor */
	public $ThemeDescriptorObj = null;

	/* @var $ThemeDataObj ThemeData */
	public $ThemeDataObj = null;

	/* @var $ThemeDataObjBackup ThemeData */
	public $ThemeDataObjBackup  = null;
	
	/* @var $GeneratedScriptObj GeneratedScript */
	public $GeneratedScriptObj = null;

	/* @var $DocumentDataObj DocumentData */
	public $DocumentDataObj = null;

	/* @var $ModuleListObj ModuleList */
	public $ModuleListObj = null;

	/* @var $LayoutObj Layout */
	public $LayoutObj = null;

	/* @var $ArticleObj Article */
	public $ArticleObj = null;

	/* @var $data array */
	private $data = array();
	
	private function __construct(){}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new CurrentSet();
		}
		return self::$Instance;
	}
	
	//@formatter:off
	public function getDataEntry ($lvl1) { return $this->data[$lvl1]; }
	public function setDataEntry ($lvl1, $data) { $this->data[$lvl1] = $data; }
	public function getDataSubEntry ($lvl1, $lvl2) { return $this->data[$lvl1][$lvl2]; }
	public function setDataSubEntry ($lvl1, $lvl2, $data) { $this->data[$lvl1][$lvl2] = $data; }
	
	public function backupInstanceOfThemeDataObj(){ $this->ThemeDataObjBackup = $this->ThemeDataObj; }
	public function restoreInstanceOfThemeDataObj(){ $this->ThemeDataObj = $this->ThemeDataObjBackup; }
	
	// public function getServerInfosObj()			{ return $this->ServerInfosObj;}
	// public function getSqlTableListObj()		{ return $this->SqlTableListObj; }
	// public function getWebSiteObj()				{ return $this->WebSiteObj; }
	// public function getWebSiteContextObj()		{ return $this->WebSiteContextObj; }
	// public function getUserObj()				{ return $this->UserObj; }
	// public function getThemeDescriptorObj()		{ return $this->ThemeDescriptorObj; }
	// public function getThemeDataObj()			{ return $this->ThemeDataObj; }
	// public function getGeneratedScriptObj()		{ return $this->GeneratedScriptObj; }
	// public function getDocumentDataObj()		{ return $this->DocumentDataObj; }
	// public function getLayoutObj()				{ return $this->LayoutObj; }
	// public function getModuleListObj()			{ return $this->ModuleListObj; }
	// public function getArticleObj()				{ return $this->ArticleObj; }
	public function getData()					{ return $this->data; }
	
	public function setServerInfosObj($ServerInfos) 			{ $this->ServerInfosObj		= $ServerInfos; }
	public function setSqlTableListObj($SqlTableList)			{ $this->SqlTableListObj	= $SqlTableList; }
	public function setWebSiteObj($WebSiteObj)					{ $this->WebSiteObj			= $WebSiteObj; }
	public function setWebSiteContextObj($WebSiteContextObj)	{ $this->WebSiteContextObj	= $WebSiteContextObj; }
	public function setUserObj($UserObj)						{ $this->UserObj			= $UserObj; }
	public function setThemeDescriptorObj($ThemeDescriptorObj)	{ $this->ThemeDescriptorObj	= $ThemeDescriptorObj; }
	public function setThemeDataObj($ThemeDataObj)				{ $this->ThemeDataObj		= $ThemeDataObj; }
	public function setGeneratedScriptObj($GeneratedScriptObj)	{ $this->GeneratedScriptObj	= $GeneratedScriptObj; }
	public function setDocumentDataObj($DocumentDataObj)		{ $this->DocumentDataObj	= $DocumentDataObj; }
	public function setLayoutObj($LayoutObj)					{ $this->LayoutObj			= $LayoutObj; }
	public function setModuleListObj($ModuleListObj)			{ $this->ModuleListObj		= $ModuleListObj; }
	public function setArticleObj($ArticleObj)					{ $this->ArticleObj			= $ArticleObj; }
	//@formatter:on
	
}