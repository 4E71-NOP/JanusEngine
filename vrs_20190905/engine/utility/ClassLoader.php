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
class ClassLoader {
	private static $Instance = null;

	private $classTab = array(
		"AdminFormTool"				=> _UTILITY_DIRECTORY_."AdminFormTool.php",
		"AuthenticateUser"			=> _UTILITY_DIRECTORY_."AuthenticateUser.php",
		"BaseToolSet"				=> _UTILITY_DIRECTORY_."BaseToolSet.php",
		"DetectPEAR"				=> _UTILITY_DIRECTORY_."DetectPEAR.php",
		"FileSelector"				=> _UTILITY_DIRECTORY_."FileSelector.php",
		"FileUtil"					=> _UTILITY_DIRECTORY_."FileUtil.php",
		"FormToCommandLine"			=> _UTILITY_DIRECTORY_."FormToCommandLine.php",
		"I18nTrans"					=> _UTILITY_DIRECTORY_."I18nTrans.php",
		"InteractiveElements"		=> _UTILITY_DIRECTORY_."InteractiveElements.php",
		"LayoutProcessor"			=> _UTILITY_DIRECTORY_."LayoutProcessor.php",
		"LayoutParser"				=> _UTILITY_DIRECTORY_."LayoutParser.php",
		"LogManagement"				=> _UTILITY_DIRECTORY_."LogManagement.php",
		"Mapper"					=> _UTILITY_DIRECTORY_."Mapper.php",
		"MenuSelectTable"			=> _UTILITY_DIRECTORY_."MenuSelectTable.php",
		"RenderAdmDashboard"		=> _UTILITY_DIRECTORY_."RenderAdmDashboard.php",
		"RenderForm"				=> _UTILITY_DIRECTORY_."RenderForm.php",
		"RenderDeco10Menu"			=> _UTILITY_DIRECTORY_."RenderDeco10Menu.php",
		"RenderDeco20Caligraph"		=> _UTILITY_DIRECTORY_."RenderDeco20Caligraph.php",
		"RenderDeco301Div"			=> _UTILITY_DIRECTORY_."RenderDeco301Div.php",
		"RenderDeco40Elegance"		=> _UTILITY_DIRECTORY_."RenderDeco40Elegance.php",
		"RenderDeco50Exquisite"		=> _UTILITY_DIRECTORY_."RenderDeco50Exquisite.php",
		"RenderDeco60Elysion"		=> _UTILITY_DIRECTORY_."RenderDeco60Elysion.php",
		"RenderModule"				=> _UTILITY_DIRECTORY_."RenderModule.php",
		"RenderStylesheet"			=> _UTILITY_DIRECTORY_."RenderStylesheet.php",
		"RenderTables"				=> _UTILITY_DIRECTORY_."RenderTables.php",
		"RenderTabs"				=> _UTILITY_DIRECTORY_."RenderTabs.php",
		"Router"					=> _UTILITY_DIRECTORY_."Router.php",
		"SessionManagement"			=> _UTILITY_DIRECTORY_."SessionManagement.php",
		"ScriptFormatting"			=> _UTILITY_DIRECTORY_."ScriptFormatting.php",
		"StringFormat"				=> _UTILITY_DIRECTORY_."StringFormat.php",
		"Template"					=> _UTILITY_DIRECTORY_."Template.php",
		"Time"						=> _UTILITY_DIRECTORY_."Time.php",
		
		"DalFacade"					=> _SDDM_DIRECTORY_."DalFacade.php",
		"SddmADODB"					=> _SDDM_DIRECTORY_."SddmADODB.php",
		"SddmMySQLI"				=> _SDDM_DIRECTORY_."SddmMySQLI.php",
		"SddmPgsql"					=> _SDDM_DIRECTORY_."SddmPgsql.php",
		"SddmPDO"					=> _SDDM_DIRECTORY_."SddmPDO.php",
		"SddmPEARDB"				=> _SDDM_DIRECTORY_."SddmPEARDB.php",
		"SddmTools"					=> _SDDM_DIRECTORY_."SddmTools.php",
		
		"ConfigurationManagement"	=> _ENTITY_DIRECTORY_."others/ConfigurationManagement.php",
		"CurrentSet"				=> _ENTITY_DIRECTORY_."others/CurrentSet.php",
		"FileContent"				=> _ENTITY_DIRECTORY_."others/FileContent.php",
		"FormBuilder"				=> _ENTITY_DIRECTORY_."others/FormBuilder.php",
		"GeneratedScript"			=> _ENTITY_DIRECTORY_."others/GeneratedScript.php",
		"MenuData"					=> _ENTITY_DIRECTORY_."others/MenuData.php",
		"RequestData"				=> _ENTITY_DIRECTORY_."others/RequestData.php",
		"ServerInfos"				=> _ENTITY_DIRECTORY_."others/ServerInfos.php",
		"SqlTableList"				=> _ENTITY_DIRECTORY_."others/SqlTableList.php",
		"ThemeData"					=> _ENTITY_DIRECTORY_."others/ThemeData.php",
		
		"ModuleList"				=> _ENTITY_DIRECTORY_."lists/ModuleList.php",
		"PermissionList"			=> _ENTITY_DIRECTORY_."lists/PermissionList.php",
		
		"AddOnConfig"				=> _ENTITY_DIRECTORY_."dao/AddOnConfig.php",
		"AddOnDependancies"			=> _ENTITY_DIRECTORY_."dao/AddOnDependancies.php",
		"AddOnFiles"				=> _ENTITY_DIRECTORY_."dao/AddOnFiles.php",
		"AddOn"						=> _ENTITY_DIRECTORY_."dao/AddOn.php",
		"ArticleConfig"				=> _ENTITY_DIRECTORY_."dao/ArticleConfig.php",
		"Article"					=> _ENTITY_DIRECTORY_."dao/Article.php",
		"ArticleTag"				=> _ENTITY_DIRECTORY_."dao/ArticleTag.php",
		"DeadLine"					=> _ENTITY_DIRECTORY_."dao/DeadLine.php",
		"Deco10_Menu"				=> _ENTITY_DIRECTORY_."dao/Deco10_Menu.php",
		"Deco20_Caligraph"			=> _ENTITY_DIRECTORY_."dao/Deco20_Caligraph.php",
		"Deco30_1Div"				=> _ENTITY_DIRECTORY_."dao/Deco30_1Div.php",
		"Deco40_Elegance"			=> _ENTITY_DIRECTORY_."dao/Deco40_Elegance.php",
		"Deco50_Exquisite"			=> _ENTITY_DIRECTORY_."dao/Deco50_Exquisite.php",
		"Deco60_Elysion"			=> _ENTITY_DIRECTORY_."dao/Deco60_Elysion.php",
		"Decoration"				=> _ENTITY_DIRECTORY_."dao/Decoration.php",
		"Definition"				=> _ENTITY_DIRECTORY_."dao/Definition.php",
		"Document"					=> _ENTITY_DIRECTORY_."dao/Document.php",
		"DocumentShare"				=> _ENTITY_DIRECTORY_."dao/DocumentShare.php",
		"DocumentStats"				=> _ENTITY_DIRECTORY_."dao/DocumentStats.php",
		"Entity"					=> _ENTITY_DIRECTORY_."dao/Entity.php",
		"Extension"					=> _ENTITY_DIRECTORY_."dao/Extension.php",
		"ExtensionConfig"			=> _ENTITY_DIRECTORY_."dao/ExtensionConfig.php",
		"ExtensionDependency"		=> _ENTITY_DIRECTORY_."dao/ExtensionDependency.php",
		"ExtensionFile"				=> _ENTITY_DIRECTORY_."dao/ExtensionFile.php",
		"Group"						=> _ENTITY_DIRECTORY_."dao/Group.php",
		"GroupUser"					=> _ENTITY_DIRECTORY_."dao/GroupUser.php",
		"GroupWebsite"				=> _ENTITY_DIRECTORY_."dao/GroupWebsite.php",
		"I18n"						=> _ENTITY_DIRECTORY_."dao/I18n.php",
		"Installation"				=> _ENTITY_DIRECTORY_."dao/Installation.php",
		"KeyWord"					=> _ENTITY_DIRECTORY_."dao/KeyWord.php",
		"Language"					=> _ENTITY_DIRECTORY_."dao/Language.php",
		"LanguageWebsite"			=> _ENTITY_DIRECTORY_."dao/LanguageWebsite.php",
		"LayoutContent"				=> _ENTITY_DIRECTORY_."dao/LayoutContent.php",
		"Layout"					=> _ENTITY_DIRECTORY_."dao/Layout.php",
		"LayoutFile"				=> _ENTITY_DIRECTORY_."dao/LayoutFile.php",
		"Logs"						=> _ENTITY_DIRECTORY_."dao/Logs.php",
		"Menu"						=> _ENTITY_DIRECTORY_."dao/Menu.php",
		"Module"					=> _ENTITY_DIRECTORY_."dao/Module.php",
		"ModuleWebsite"				=> _ENTITY_DIRECTORY_."dao/ModuleWebsite.php",
		"Note"						=> _ENTITY_DIRECTORY_."dao/Note.php",
		"SmallVariable"				=> _ENTITY_DIRECTORY_."dao/SmallVariable.php",
		"Tag"						=> _ENTITY_DIRECTORY_."dao/Tag.php",
		"ThemeDefinition"			=> _ENTITY_DIRECTORY_."dao/ThemeDefinition.php",
		"ThemeDescriptor"			=> _ENTITY_DIRECTORY_."dao/ThemeDescriptor.php",
		"ThemeWebsite"				=> _ENTITY_DIRECTORY_."dao/ThemeWebsite.php",
		"User"						=> _ENTITY_DIRECTORY_."dao/User.php",
		"WebSite"					=> _ENTITY_DIRECTORY_."dao/WebSite.php",
		
		"CommandConsole"			=> "current/engine/cli/CommandConsole.php",
		
		"LibInstallation"			=> _UTILITY_DIRECTORY_."LibInstallation.php",
		"LibInstallationReport"		=> _UTILITY_DIRECTORY_."LibInstallationReport.php",
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
		if ( isset ( $this->classTab[$ClassName])) {
			if ( !class_exists($ClassName) ) { 
				if ( file_exists($this->classTab[$ClassName])) { 
 					// error_log("ClassLoader::provisionClass : including " . $this->classTab[$ClassName]);
					include ($this->classTab[$ClassName]); 
				}
				else { 
					error_log("ClassLoader::provisionClass : File " . $this->classTab[$ClassName] ." doesn't exist."); 
				}
			}
		}
		else { 
			// error_log("ClassLoader::provisionClass : " . $ClassName ." doesn't exist.");
			$ret = "ERR"; }
		return $ret;
	}
}
