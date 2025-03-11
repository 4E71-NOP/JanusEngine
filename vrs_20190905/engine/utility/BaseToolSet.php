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

/**
 * Regroupment of multiple internal tools.
 * @author faust
 *
 */
class BaseToolSet
{
	public $AUObj;
	public $CMObj;
	public $CommandConsole;
	public $I18nTransObj;
	public $InteractiveElementsObj;
	public $LMObj;
	public $MapperObj;
	public $RenderFormObj;
	public $RenderModuleObj;
	public $RenderTablesObj;
	public $RenderTabsObj;
	public $RequestDataObj;
	public $Router;
	public $SDDMObj;
	public $SddmToolsObj;
	public $SMObj;
	public $StringFormatObj;
	public $TimeObj;
	public $SQLlogEntry;
	public $MiscTools;
	// public $SqlTableListObj;

	private static $Instance = null;

	private function __construct()
	{
		include_once("current/engine/utility/ClassLoader.php");			// Make sure we got this loaded.
		$ClassLoaderObj = ClassLoader::getInstance();
		//error_log("BREAKPOINT");
		$ClassLoaderObj->provisionClass('LogManagement');
		$ClassLoaderObj->provisionClass('Time');
		$ClassLoaderObj->provisionClass('Mapper');
		$ClassLoaderObj->provisionClass('RequestData');
		$ClassLoaderObj->provisionClass('StringFormat');
		// $ClassLoaderObj->provisionClass('SqlTableList');					// Need configuration to be loaded first
		$ClassLoaderObj->provisionClass('ConfigurationManagement');
		$ClassLoaderObj->provisionClass('SessionManagement');
		$ClassLoaderObj->provisionClass('AuthenticateUser');
		$ClassLoaderObj->provisionClass('I18nTrans');
		$ClassLoaderObj->provisionClass('SddmCore');
		$ClassLoaderObj->provisionClass('SddmTools');
		$ClassLoaderObj->provisionClass('DalFacade');
		$ClassLoaderObj->provisionClass('InteractiveElements');
		$ClassLoaderObj->provisionClass('RenderForm');
		$ClassLoaderObj->provisionClass('RenderModule');
		$ClassLoaderObj->provisionClass('RenderTables');
		$ClassLoaderObj->provisionClass('RenderTabs');
		$ClassLoaderObj->provisionClass('Router');

		// Every entity extends 'Entity', so...
		$ClassLoaderObj->provisionClass('Entity');

		$this->TimeObj					= Time::getInstance();
		$this->LMObj					= LogManagement::getInstance();
		$this->MapperObj				= Mapper::getInstance();
		$this->RequestDataObj			= RequestData::getInstance();
		$this->StringFormatObj			= StringFormat::getInstance();
		// $this->SqlTableListObj			= SqlTableList::getInstance();			// Need configuration to be fully operationnal
		$this->CMObj					= ConfigurationManagement::getInstance();
		$this->CMObj->InitBasicSettings();
		$this->AUObj					= AuthenticateUser::getInstance();
		$this->I18nTransObj				= I18nTrans::getInstance();
		$this->SddmToolsObj				= SddmTools::getInstance();
		$this->InteractiveElementsObj	= InteractiveElements::getInstance();
		$this->RenderFormObj			= RenderForm::getInstance();
		$this->RenderModuleObj			= RenderModule::getInstance();
		$this->RenderTablesObj			= RenderTables::getInstance();
		$this->RenderTabsObj			= RenderTabs::getInstance();
		$this->Router					= Router::getInstance();
	}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return BaseToolSet
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new BaseToolSet();
		}
		return self::$Instance;
	}


	/**
	 * Loads and prepare the given class
	 */
	public function InitClass($className)
	{
		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass($className);

		switch ($className){
			case "MiscTools":
				$this->MiscTools		= MiscTools::getInstance();
				break;
			case "CommandConsole":
				$this->CommandConsole	= CommandConsole::getInstance();
				break;
			case "SessionManagement":
				$this->SMObj			= SessionManagement::getInstance();
				break;
		}
	}


	/**
	 * Loads and prepare the command console class. 
	 * @DEPRECATED
	 */
	public function InitCommandConsole()
	{
		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass('CommandConsole');
	}

	/**
	 * Sets the session management instance.
	 * It is done this ways because the session isn't initialized right away at the start or when this class is loaded.
	 * @DEPRECATED
	 */
	public function initSmObj()
	{
		$this->SMObj					= SessionManagement::getInstance();
	}

	/**
	 * Sets the DAL instance.
	 * This require a valid configuration to be loaded. In most cases the configuration isn't ready when this class is loaded.
	 */
	public function initSddmObj()
	{
		$DALFacade = DalFacade::getInstance();
		$DALFacade->createDALInstance();			//It connects too.
		$this->SDDMObj = $DALFacade->getDALInstance();
	}

	/**
	 * Make all that is needed fort location and logs in one single method.
	 */
	public function mapSegmentLocation($method, $location)
	{
		$this->MapperObj->AddAnotherLevel(" / " . $location);
		$this->LMObj->logCheckpoint($location);
		$this->MapperObj->RemoveThisLevel(" / " . $location);
		$this->MapperObj->setSqlApplicant($location);
		$this->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => "+--------------------------------------------------------------------------------+"));
		$this->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "| " . $method . " started"));
	}

	/**
	 * 
	 */
	public function segmentEnding($method)
	{
		$this->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => "| " . $method . " ended --------------------"));
		$this->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => "+--------------------------------------------------------------------------------+"));
	}
}
