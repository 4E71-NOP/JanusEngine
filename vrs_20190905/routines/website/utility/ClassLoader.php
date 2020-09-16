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
		"AdminFormTool"				=> "routines/website/utility/AdminFormTool.php",
		"AuthenticateUser"			=> "routines/website/utility/AuthenticateUser.php",
		"DetectPEAR"				=> "routines/website/utility/DetectPEAR.php",
		"FileSelector"				=> "routines/website/utility/FileSelector.php",
		"FormToCommandLine"			=> "routines/website/utility/FormToCommandLine.php",
		"I18n"						=> "routines/website/utility/I18n.php",
		"InteractiveElements"		=> "routines/website/utility/InteractiveElements.php",
		"LogManagement"				=> "routines/website/utility/LogManagement.php",
		"Mapper"					=> "routines/website/utility/Mapper.php",
		"MenuSelectTable"			=> "routines/website/utility/MenuSelectTable.php",
		"RenderAdmDashboard"		=> "routines/website/utility/RenderAdmDashboard.php",
		"RenderDeco10Menu"			=> "routines/website/utility/RenderDeco10Menu.php",
		"RenderDeco20Caligraph"		=> "routines/website/utility/RenderDeco20Caligraph.php",
		"RenderDeco301Div"			=> "routines/website/utility/RenderDeco301Div.php",
		"RenderDeco40Elegance"		=> "routines/website/utility/RenderDeco40Elegance.php",
		"RenderDeco50Exquisite"		=> "routines/website/utility/RenderDeco50Exquisite.php",
		"RenderDeco60Elysion"		=> "routines/website/utility/RenderDeco60Elysion.php",
		"RenderModule"				=> "routines/website/utility/RenderModule.php",
		"RenderStylesheet"			=> "routines/website/utility/RenderStylesheet.php",
		"RenderTables"				=> "routines/website/utility/RenderTables.php",
		"RenderTabs"				=> "routines/website/utility/RenderTabs.php",
		"SessionManagement"			=> "routines/website/utility/SessionManagement.php",
		"StringFormat"				=> "routines/website/utility/StringFormat.php",
		"Template"					=> "routines/website/utility/Template.php",
		"Time"						=> "routines/website/utility/Time.php",
		
		"DalFacade"					=> "routines/website/sddm/DalFacade.php",
		"SddmADODB"					=> "routines/website/sddm/SddmADODB.php",
		"SddmMySQLI"				=> "routines/website/sddm/SddmMySQLI.php",
		"SddmPDO"					=> "routines/website/sddm/SddmPDO.php",
		"SddmPEARDB"				=> "routines/website/sddm/SddmPEARDB.php",
		"SddmTools"					=> "routines/website/sddm/SddmTools.php",
		
		"ConfigurationManagement"	=> "routines/website/entity/others/ConfigurationManagement.php",
		"CurrentSet"				=> "routines/website/entity/others/CurrentSet.php",
		"GeneratedJavaScript"		=> "routines/website/entity/others/GeneratedJavaScript.php",
		"RenderLayout"				=> "routines/website/entity/others/RenderLayout.php",
		"RequestData"				=> "routines/website/entity/others/RequestData.php",
		"ServerInfos"				=> "routines/website/entity/others/ServerInfos.php",
		"SqlTableList"				=> "routines/website/entity/others/SqlTableList.php",
		"ThemeData"					=> "routines/website/entity/others/ThemeData.php",
		
		"AddOnConfig"				=> "routines/website/entity/dao/AddOnConfig.php",
		"AddOnDependancies"			=> "routines/website/entity/dao/AddOnDependancies.php",
		"AddOnFiles"				=> "routines/website/entity/dao/AddOnFiles.php",
		"AddOn"						=> "routines/website/entity/dao/AddOn.php",
		"ArticleConfig"				=> "routines/website/entity/dao/ArticleConfig.php",
		"Article"					=> "routines/website/entity/dao/Article.php",
		"ArticleTag"				=> "routines/website/entity/dao/ArticleTag.php",
		"Category"					=> "routines/website/entity/dao/Category.php",
		"DeadLine"					=> "routines/website/entity/dao/DeadLine.php",
		"Deco10_Menu"				=> "routines/website/entity/dao/Deco10_Menu.php",
		"Deco20_Caligraph"			=> "routines/website/entity/dao/Deco20_Caligraph.php",
		"Deco30_1Div"				=> "routines/website/entity/dao/Deco30_1Div.php",
		"Deco40_Elegance"			=> "routines/website/entity/dao/Deco40_Elegance.php",
		"Deco50_Exquisite"			=> "routines/website/entity/dao/Deco50_Exquisite.php",
		"Deco60_Elysion"			=> "routines/website/entity/dao/Deco60_Elysion.php",
		"Decoration"				=> "routines/website/entity/dao/Decoration.php",
		"Document"					=> "routines/website/entity/dao/Document.php",
		"DocumentShare"				=> "routines/website/entity/dao/DocumentShare.php",
		"DocumentStats"				=> "routines/website/entity/dao/DocumentStats.php",
		"Group"						=> "routines/website/entity/dao/Group.php",
		"GroupUser"					=> "routines/website/entity/dao/GroupUser.php",
		"Installation"				=> "routines/website/entity/dao/Installation.php",
		"KeyWord"					=> "routines/website/entity/dao/KeyWord.php",
		"Languages"					=> "routines/website/entity/dao/Languages.php",
		"LayoutDefinition"			=> "routines/website/entity/dao/LayoutDefinition.php",
		"Layout"					=> "routines/website/entity/dao/Layout.php",
		"Logs"						=> "routines/website/entity/dao/Logs.php",
		"Module"					=> "routines/website/entity/dao/Module.php",
		"Notice"					=> "routines/website/entity/dao/Notice.php",
		"SmallVariable"				=> "routines/website/entity/dao/SmallVariable.php",
		"Tag"						=> "routines/website/entity/dao/Tag.php",
		"ThemeDescriptor"			=> "routines/website/entity/dao/ThemeDescriptor.php",
		"User"						=> "routines/website/entity/dao/User.php",
		"WebSite"					=> "routines/website/entity/dao/WebSite.php",
		
		"CommandConsole"			=> "routines/website/cli/CommandConsole.php",
		
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
