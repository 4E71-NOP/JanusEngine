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
class ClassLoader {
	private static $Instance = null;

	private $classTab = array(
		"AdminFormTool"				=> "engine/utility/AdminFormTool.php",
		"AuthenticateUser"			=> "engine/utility/AuthenticateUser.php",
		"CommonSystem"				=> "engine/utility/CommonSystem.php",
		"DetectPEAR"				=> "engine/utility/DetectPEAR.php",
		"FileSelector"				=> "engine/utility/FileSelector.php",
		"FormToCommandLine"			=> "engine/utility/FormToCommandLine.php",
		"I18n"						=> "engine/utility/I18n.php",
		"InteractiveElements"		=> "engine/utility/InteractiveElements.php",
		"LogManagement"				=> "engine/utility/LogManagement.php",
		"Mapper"					=> "engine/utility/Mapper.php",
		"MenuSelectTable"			=> "engine/utility/MenuSelectTable.php",
		"RenderAdmDashboard"		=> "engine/utility/RenderAdmDashboard.php",
		"RenderDeco10Menu"			=> "engine/utility/RenderDeco10Menu.php",
		"RenderDeco20Caligraph"		=> "engine/utility/RenderDeco20Caligraph.php",
		"RenderDeco301Div"			=> "engine/utility/RenderDeco301Div.php",
		"RenderDeco40Elegance"		=> "engine/utility/RenderDeco40Elegance.php",
		"RenderDeco50Exquisite"		=> "engine/utility/RenderDeco50Exquisite.php",
		"RenderDeco60Elysion"		=> "engine/utility/RenderDeco60Elysion.php",
		"RenderModule"				=> "engine/utility/RenderModule.php",
		"RenderStylesheet"			=> "engine/utility/RenderStylesheet.php",
		"RenderTables"				=> "engine/utility/RenderTables.php",
		"RenderTabs"				=> "engine/utility/RenderTabs.php",
		"SessionManagement"			=> "engine/utility/SessionManagement.php",
		"StringFormat"				=> "engine/utility/StringFormat.php",
		"Template"					=> "engine/utility/Template.php",
		"Time"						=> "engine/utility/Time.php",
		
		"DalFacade"					=> "engine/sddm/DalFacade.php",
		"SddmADODB"					=> "engine/sddm/SddmADODB.php",
		"SddmMySQLI"				=> "engine/sddm/SddmMySQLI.php",
		"SddmPDO"					=> "engine/sddm/SddmPDO.php",
		"SddmPEARDB"				=> "engine/sddm/SddmPEARDB.php",
		"SddmTools"					=> "engine/sddm/SddmTools.php",
		
		"ConfigurationManagement"	=> "engine/entity/others/ConfigurationManagement.php",
		"CurrentSet"				=> "engine/entity/others/CurrentSet.php",
		"GeneratedJavaScript"		=> "engine/entity/others/GeneratedJavaScript.php",
		"RenderLayout"				=> "engine/entity/others/RenderLayout.php",
		"RequestData"				=> "engine/entity/others/RequestData.php",
		"ServerInfos"				=> "engine/entity/others/ServerInfos.php",
		"SqlTableList"				=> "engine/entity/others/SqlTableList.php",
		"ThemeData"					=> "engine/entity/others/ThemeData.php",
		
		"AddOnConfig"				=> "engine/entity/dao/AddOnConfig.php",
		"AddOnDependancies"			=> "engine/entity/dao/AddOnDependancies.php",
		"AddOnFiles"				=> "engine/entity/dao/AddOnFiles.php",
		"AddOn"						=> "engine/entity/dao/AddOn.php",
		"ArticleConfig"				=> "engine/entity/dao/ArticleConfig.php",
		"Article"					=> "engine/entity/dao/Article.php",
		"ArticleTag"				=> "engine/entity/dao/ArticleTag.php",
		"Category"					=> "engine/entity/dao/Category.php",
		"DeadLine"					=> "engine/entity/dao/DeadLine.php",
		"Deco10_Menu"				=> "engine/entity/dao/Deco10_Menu.php",
		"Deco20_Caligraph"			=> "engine/entity/dao/Deco20_Caligraph.php",
		"Deco30_1Div"				=> "engine/entity/dao/Deco30_1Div.php",
		"Deco40_Elegance"			=> "engine/entity/dao/Deco40_Elegance.php",
		"Deco50_Exquisite"			=> "engine/entity/dao/Deco50_Exquisite.php",
		"Deco60_Elysion"			=> "engine/entity/dao/Deco60_Elysion.php",
		"Decoration"				=> "engine/entity/dao/Decoration.php",
		"Document"					=> "engine/entity/dao/Document.php",
		"DocumentShare"				=> "engine/entity/dao/DocumentShare.php",
		"DocumentStats"				=> "engine/entity/dao/DocumentStats.php",
		"Group"						=> "engine/entity/dao/Group.php",
		"GroupUser"					=> "engine/entity/dao/GroupUser.php",
		"Installation"				=> "engine/entity/dao/Installation.php",
		"KeyWord"					=> "engine/entity/dao/KeyWord.php",
		"Languages"					=> "engine/entity/dao/Languages.php",
		"LayoutDefinition"			=> "engine/entity/dao/LayoutDefinition.php",
		"Layout"					=> "engine/entity/dao/Layout.php",
		"Logs"						=> "engine/entity/dao/Logs.php",
		"Module"					=> "engine/entity/dao/Module.php",
		"Notice"					=> "engine/entity/dao/Notice.php",
		"SmallVariable"				=> "engine/entity/dao/SmallVariable.php",
		"Tag"						=> "engine/entity/dao/Tag.php",
		"ThemeDescriptor"			=> "engine/entity/dao/ThemeDescriptor.php",
		"User"						=> "engine/entity/dao/User.php",
		"WebSite"					=> "engine/entity/dao/WebSite.php",
		
		"CommandConsole"			=> "engine/cli/CommandConsole.php",
		
		"LibInstallation"			=> "install/install_routines/LibInstallation.php",
		"LibInstallationReport"		=> "install/install_routines/LibInstallationReport.php",
		);
	
	public function __construct() {}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new ClassLoader ();
		}
		return self::$Instance;
	}
	
	/**
	 * Will load automatically a class if the name is in the list. It will return an "ERR" if it couldn't load anything.
	 * 
	 * @param String $ClassName
	 */
	public function provisionClass($ClassName) {
		$ret="OK";
		if  ( isset ( $this->classTab[$ClassName])) {
			if ( !class_exists($ClassName) ) { include ($this->classTab[$ClassName]); }
		}
		else { $ret = "ERR"; }
		return $ret;
	}
	
}
