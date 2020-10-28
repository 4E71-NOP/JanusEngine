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
		"AdminFormTool"				=> UtilityDirectory."AdminFormTool.php",
		"AuthenticateUser"			=> UtilityDirectory."AuthenticateUser.php",
		"CommonSystem"				=> UtilityDirectory."CommonSystem.php",
		"DetectPEAR"				=> UtilityDirectory."DetectPEAR.php",
		"FileSelector"				=> UtilityDirectory."FileSelector.php",
		"FormToCommandLine"			=> UtilityDirectory."FormToCommandLine.php",
		"I18n"						=> UtilityDirectory."I18n.php",
		"InteractiveElements"		=> UtilityDirectory."InteractiveElements.php",
		"LogManagement"				=> UtilityDirectory."LogManagement.php",
		"Mapper"					=> UtilityDirectory."Mapper.php",
		"MenuSelectTable"			=> UtilityDirectory."MenuSelectTable.php",
		"RenderAdmDashboard"		=> UtilityDirectory."RenderAdmDashboard.php",
		"RenderDeco10Menu"			=> UtilityDirectory."RenderDeco10Menu.php",
		"RenderDeco20Caligraph"		=> UtilityDirectory."RenderDeco20Caligraph.php",
		"RenderDeco301Div"			=> UtilityDirectory."RenderDeco301Div.php",
		"RenderDeco40Elegance"		=> UtilityDirectory."RenderDeco40Elegance.php",
		"RenderDeco50Exquisite"		=> UtilityDirectory."RenderDeco50Exquisite.php",
		"RenderDeco60Elysion"		=> UtilityDirectory."RenderDeco60Elysion.php",
		"RenderModule"				=> UtilityDirectory."RenderModule.php",
		"RenderStylesheet"			=> UtilityDirectory."RenderStylesheet.php",
		"RenderTables"				=> UtilityDirectory."RenderTables.php",
		"RenderTabs"				=> UtilityDirectory."RenderTabs.php",
		"SessionManagement"			=> UtilityDirectory."SessionManagement.php",
		"StringFormat"				=> UtilityDirectory."StringFormat.php",
		"Template"					=> UtilityDirectory."Template.php",
		"Time"						=> UtilityDirectory."Time.php",
		
		"DalFacade"					=> SddmDirectory."DalFacade.php",
		"SddmADODB"					=> SddmDirectory."SddmADODB.php",
		"SddmMySQLI"				=> SddmDirectory."SddmMySQLI.php",
		"SddmPDO"					=> SddmDirectory."SddmPDO.php",
		"SddmPEARDB"				=> SddmDirectory."SddmPEARDB.php",
		"SddmTools"					=> SddmDirectory."SddmTools.php",
		
		"ConfigurationManagement"	=> EntityDirectory."others/ConfigurationManagement.php",
		"CurrentSet"				=> EntityDirectory."others/CurrentSet.php",
		"GeneratedJavaScript"		=> EntityDirectory."others/GeneratedJavaScript.php",
		"RenderLayout"				=> EntityDirectory."others/RenderLayout.php",
		"RequestData"				=> EntityDirectory."others/RequestData.php",
		"ServerInfos"				=> EntityDirectory."others/ServerInfos.php",
		"SqlTableList"				=> EntityDirectory."others/SqlTableList.php",
		"ThemeData"					=> EntityDirectory."others/ThemeData.php",
		
		"AddOnConfig"				=> EntityDirectory."dao/AddOnConfig.php",
		"AddOnDependancies"			=> EntityDirectory."dao/AddOnDependancies.php",
		"AddOnFiles"				=> EntityDirectory."dao/AddOnFiles.php",
		"AddOn"						=> EntityDirectory."dao/AddOn.php",
		"ArticleConfig"				=> EntityDirectory."dao/ArticleConfig.php",
		"Article"					=> EntityDirectory."dao/Article.php",
		"ArticleTag"				=> EntityDirectory."dao/ArticleTag.php",
		"Category"					=> EntityDirectory."dao/Category.php",
		"DeadLine"					=> EntityDirectory."dao/DeadLine.php",
		"Deco10_Menu"				=> EntityDirectory."dao/Deco10_Menu.php",
		"Deco20_Caligraph"			=> EntityDirectory."dao/Deco20_Caligraph.php",
		"Deco30_1Div"				=> EntityDirectory."dao/Deco30_1Div.php",
		"Deco40_Elegance"			=> EntityDirectory."dao/Deco40_Elegance.php",
		"Deco50_Exquisite"			=> EntityDirectory."dao/Deco50_Exquisite.php",
		"Deco60_Elysion"			=> EntityDirectory."dao/Deco60_Elysion.php",
		"Decoration"				=> EntityDirectory."dao/Decoration.php",
		"Document"					=> EntityDirectory."dao/Document.php",
		"DocumentShare"				=> EntityDirectory."dao/DocumentShare.php",
		"DocumentStats"				=> EntityDirectory."dao/DocumentStats.php",
		"Group"						=> EntityDirectory."dao/Group.php",
		"GroupUser"					=> EntityDirectory."dao/GroupUser.php",
		"Installation"				=> EntityDirectory."dao/Installation.php",
		"KeyWord"					=> EntityDirectory."dao/KeyWord.php",
		"Languages"					=> EntityDirectory."dao/Languages.php",
		"LayoutDefinition"			=> EntityDirectory."dao/LayoutDefinition.php",
		"Layout"					=> EntityDirectory."dao/Layout.php",
		"Logs"						=> EntityDirectory."dao/Logs.php",
		"Module"					=> EntityDirectory."dao/Module.php",
		"Notice"					=> EntityDirectory."dao/Notice.php",
		"SmallVariable"				=> EntityDirectory."dao/SmallVariable.php",
		"Tag"						=> EntityDirectory."dao/Tag.php",
		"ThemeDescriptor"			=> EntityDirectory."dao/ThemeDescriptor.php",
		"User"						=> EntityDirectory."dao/User.php",
		"WebSite"					=> EntityDirectory."dao/WebSite.php",
		
		"CommandConsole"			=> "engine/cli/CommandConsole.php",
		
		"LibInstallation"			=> "install/install_routines/LibInstallation.php",
		"LibInstallationReport"		=> "install/install_routines/LibInstallationReport.php",
		);
	
	public function __construct() {}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return ClassLoader
	 */
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
