<?php
/*Hydre-licence-begin*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE work.
/* @var $bts BaseToolSet                            */
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $InteractiveElementsObj InteractiveElements */
/* @var $RenderTablesObj RenderTables               */
/* @var $RequestDataObj RequestData                 */
/* @var $SDDMObj DalFacade                          */
/* @var $SqlTableListObj SqlTableList               */
/* @var $StringFormatObj StringFormat               */

/* @var $CurrentSetObj CurrentSet                   */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */

/* @var $Block String                               */
/* @var $infos array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

// --------------------------------------------------------------------------------------------
//		Installation page 01
// --------------------------------------------------------------------------------------------

class InstallPage01
{
	private static $Instance = null;
	private $T = array();
	private $FormName = "install_page_init";

	// private $pearSupportEnabled = false;
	// private $pearJavascriptObj = array();

	// private $adoSupportEnabled = false;
	// private $adoJavascriptObj = array();

	private $pdoSupportEnabled = false;
	private $pdoJavascriptObj = array();

	private $phpSupportEnabled = false;
	private $phpJavascriptObj = array();

	private $availableSupport = array();
	public function __construct()
	{
	}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return InstallPage01
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new InstallPage01();
		}
		return self::$Instance;
	}

	/**
	 * Renders the page 01 content
	 */
	public function render($infos)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;
		$Block = $ThemeDataObj->getThemeName() . $infos['block'];

		// --------------------------------------------------------------------------------------------
		// Specific values for installation form
		$bts->CMObj->setConfigurationEntry('admin_user', 'dbadmin');
		$bts->CMObj->setConfigurationEntry('admin_password', 'nimdabd');
		$bts->CMObj->setConfigurationEntry('dataBaseHostingPrefix', '');

		$langFile = $infos['module']['module_directory'] . "i18n/" . $CurrentSetObj->getDataEntry('language') . ".php";
		$bts->I18nTransObj->apply(array("type" => "file", "file" => $langFile, "format" => "php"));

		// --------------------------------------------------------------------------------------------
		//	Language selector

		$Content = "<form ACTION='install.php' id='" . $this->FormName . "' method='post'>\r";
		$LangageSelector = array(
			"1" => array(
				"code" => "eng",
				"file" => "tl_eng.png"
			),
			"2" => array(
				"code" => "fra",
				"file" => "tl_fra.png"
			)
		);
		$Content .= "<p style='text-align: center;'>\r";
		foreach ($LangageSelector as $A) {
			$Content .= "<a href='install.php?l=" . $A['code'] . "'><img src='media/theme/" . $ThemeDataObj->getDefinitionValue('directory') . "/" . $A['file'] . "' alt='' height='64' width='64' border='0'></a>\r";
		}
		$Content .= "</p>\r";
		unset($LangageSelector);


		// --------------------------------------------------------------------------------------------
		$infos['iconGoNoGoOk'] = "<img src='media/theme/" . $ThemeDataObj->getDefinitionValue('directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ok') .	"' width='18' height='18' border='0'>";
		$infos['iconGoNoGoNok'] = "<img src='media/theme/" . $ThemeDataObj->getDefinitionValue('directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_notification') .	"' width='18' height='18' border='0'>";

		$this->T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 20, 6);

		$this->serverInfos($infos, 1);
		$this->databaseAccess($infos, 2);
		$this->installationMethod($infos, 3);
		$this->siteSelection($infos, 4);
		$this->personalization($infos, 5);
		$this->logConfig($infos, 6);

		$Content .= $bts->RenderTablesObj->render($infos, $this->T);

		// --------------------------------------------------------------------------------------------
		$pv['checkFieldList']['0']['id'] = 'form[host]';
		$pv['checkFieldList']['0']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls0');
		$pv['checkFieldList']['0']['err'] = 0;
		$pv['checkFieldList']['1']['id'] = 'form[dataBaseAdminUser]';
		$pv['checkFieldList']['1']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls1');
		$pv['checkFieldList']['1']['err'] = 0;
		$pv['checkFieldList']['2']['id'] = 'form[dataBaseAdminPassword]';
		$pv['checkFieldList']['2']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls2');
		$pv['checkFieldList']['2']['err'] = 0;
		$pv['checkFieldList']['3']['id'] = 'form[dbprefix]';
		$pv['checkFieldList']['3']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls3');
		$pv['checkFieldList']['3']['err'] = 0;
		$pv['checkFieldList']['4']['id'] = 'form[dataBaseUserLogin]';
		$pv['checkFieldList']['4']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls4');
		$pv['checkFieldList']['4']['err'] = 0;
		$pv['checkFieldList']['5']['id'] = 'form[dataBaseUserPassword]';
		$pv['checkFieldList']['5']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls5');
		$pv['checkFieldList']['5']['err'] = 0;
		$pv['checkFieldList']['6']['id'] = 'form[websiteUserPassword]';
		$pv['checkFieldList']['6']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls6');
		$pv['checkFieldList']['6']['err'] = 0;

		$pv['JSONcheckFieldList'] = "var checkFieldList = { \r";
		$i = 0;
		foreach ($pv['checkFieldList'] as $A) {
			$pv['JSONcheckFieldList'] .= "\t'" . $i . "' : { 'id':'" . $A['id'] . "', 'name':'" . $A['name'] . "', 'err':false },\r";
			$i++;
		}
		$pv['JSONcheckFieldList'] = substr($pv['JSONcheckFieldList'], 0, -2) . "\r}; ";
		$GeneratedScriptObj->insertString('JavaScript-Data', $pv['JSONcheckFieldList']);
		$GeneratedScriptObj->insertString('JavaScript-Data', "var AlertCheckFormValues = '" . $bts->I18nTransObj->getI18nTransEntry('avcf') . "';\r");
		$GeneratedScriptObj->insertString('JavaScript-Data', "var JavaScriptI18nDbCnxAlert = \"" . $bts->I18nTransObj->getI18nTransEntry('JavaScriptI18nDbCnxAlert') . "\";\r");

		// --------------------------------------------------------------------------------------------
		$installToken = floor($bts->TimeObj->getMicrotime());

		$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
			$infos,
			'button',
			$bts->I18nTransObj->getI18nTransEntry('bouton'),
			256,
			'bouton_install_p1',
			2,
			3,
			"li.checkFormAndPost( checkFieldList )"
		);

		$Content .= "
		<br>\r
		<br>\r
		<div style='position: absolute; text-align: center; width: 100%;'>\r
		<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
		<tr>\r
		<td>\r
		" .
			$bts->InteractiveElementsObj->renderSubmitButton($SB) .
			"
		</td>\r
		</tr>\r
		</table>\r
		</div>\r
		<input type='hidden' name='PageInstall' value='2'>\r
		<input type='hidden' name='installToken' value='" . $installToken . "'>\r
		<input type='hidden' name='l' value='" . $CurrentSetObj->getDataEntry('language') . "'>\r
				
		</form>\r
		<br>\r<br>\r<br>\r<br>\r<br>\r
		";

		$listOfSupport = "var listOfDBSupport = {\r";
		// $listOfSupport .= ($this->pearSupportEnabled == true) ? $this->pearJavascriptObj	: "";
		// $listOfSupport .= ($this->adoSupportEnabled == true) ? $this->adoJavascriptObj	: "";
		$listOfSupport .= ($this->pdoSupportEnabled == true) ? $this->pdoJavascriptObj	: "";
		$listOfSupport .= ($this->phpSupportEnabled == true) ? $this->phpJavascriptObj	: "";
		$listOfSupport .= "};\r";
		$GeneratedScriptObj->insertString('JavaScript-Data', $listOfSupport);

		return ($Content);
	}

	/**
	 * Fill the table with the server information
	 */
	private function serverInfos($infos, $t)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		$Block = $ThemeDataObj->getThemeName() . $infos['block'];
		$ServerInfosObj = $CurrentSetObj->ServerInfosObj;

		$DBsupport = $this->detectionPHPbuiltinSupport($infos) . $this->detectionPDOSupport($infos); //. $this->detectionADODBSupport($infos) . $this->detectionPEARSupport($infos);

		$T = &$this->T['Content'];

		$l = 1;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SRV_ip');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('srv_hostname');

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SRV_phpVrs');
		$T[$t][$l]['2']['cont'] = "PHP vrs " . phpversion();


		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SRV_incPth');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('include_path');

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SRV_CurDir');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('currentDirectory');

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SRV_DisErr');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('display_errors') . " / " . $bts->I18nTransObj->getI18nTransEntry($ServerInfosObj->getServerInfosEntry('register_globals')) . " / " . $ServerInfosObj->getServerInfosEntry('post_max_size');

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SRV_MemLim');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('memoryLimit');
		if (intval(str_replace("M", "", $ServerInfosObj->getServerInfosEntry('memoryLimit'))) < 128) {
			$T[$t][$l]['2']['cont'] .= " (<span class='" . $Block . "_warning'>" . $bts->I18nTransObj->getI18nTransEntry('test_nok') . "</span>)";
		} else {
			$T[$t][$l]['2']['cont'] .= " (" . $bts->I18nTransObj->getI18nTransEntry('test_ok') . ")";
		}

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SRV_MaxTim');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('max_execution_time') . "s";
		if ($ServerInfosObj->getServerInfosEntry('max_execution_time') >= 60) {
			$T[$t][$l]['2']['cont'] .= " (<span class='" . $Block . "_warning'>" . $bts->I18nTransObj->getI18nTransEntry('test_nok') . "</span>)";
		} else {
			$T[$t][$l]['2']['cont'] .= " " . $bts->I18nTransObj->getI18nTransEntry('test_ok');
		}

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SRV_DbSrvc');
		$T[$t][$l]['2']['cont'] = $DBsupport;

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SRV_PrcRam');
		$T[$t][$l]['2']['cont'] = $bts->RenderFormObj->renderInputText("form[memoryLimit]", "", "", 2) . "M";

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SRV_PrcTim');
		$T[$t][$l]['2']['cont'] = $bts->RenderFormObj->renderInputText("form[execTimeLimit]", "", "", 2) . "s";

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig($l, 2, 2);
	}

	/**
	 * databaseAccess
	 */
	private function databaseAccess($infos, $t)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		$Block = $ThemeDataObj->getThemeName() . $infos['block'];
		$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;
		$Content = "";

		$T = &$this->T['Content'];
		$lang = $CurrentSetObj->getDataEntry('language');

		$l = 1;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_Titlec1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_Titlec2');
		$T[$t][$l]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_Titlec3');
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_Titlec4');
		$l++;

		unset($tab_);
		$tab_[$bts->CMObj->getConfigurationEntry('dal')] = " selected ";
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_dal');
		// TODO check if using RenderForm does some good
		$T[$t][$l]['3']['cont'] = "<select id='form[dal]' name='form[dal]' onChange=\"li.selectMenuBuilder ( 'form[selectedDataBaseType]' , listOfDBSupport[this.value] );\">\r";
		if ($this->phpSupportEnabled == true) {
			$T[$t][$l]['3']['cont'] .= "<option value='PHP'		" . $tab_['PHP'] . ">" .		$bts->I18nTransObj->getI18nTransEntry('msdal_php') . "</option>\r";
		}
		if ($this->pdoSupportEnabled == true) {
			$T[$t][$l]['3']['cont'] .= "<option value='PDO'		" . $tab_['PDO'] . ">" .		$bts->I18nTransObj->getI18nTransEntry('msdal_pdo') . "</option>\r";
		}
		// if ( $this->adoSupportEnabled == true )		{ $T[$t][$l]['3']['cont'] .= "<option value='ADODB'		".$tab_['ADODB'].">".	$bts->I18nTransObj->getI18nTransEntry('msdal_adodb')."</option>\r"; }
		// if ( $this->pearSupportEnabled == true )	{ $T[$t][$l]['3']['cont'] .= "<option value='PEAR'		".$tab_['PEARDB'].">".	$bts->I18nTransObj->getI18nTransEntry('msdal_pear')."</option>\r"; }

		$T[$t][$l]['3']['cont'] .= "</select>\r";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('DB_dalInf') . "</span>";
		$l++;

		// DB Type selection
		unset($tab_);
		$tab_[$bts->CMObj->getConfigurationEntry('type')] = " selected ";
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_type');
		$T[$t][$l]['3']['cont'] = "<select id='form[selectedDataBaseType]' name='form[selectedDataBaseType]'>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('DB_typeInf') . "</span>";
		$l++;

		// Hosting plan
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_hosting');

		$T[$t][$l]['3']['cont'] = "<select name='form[dataBaseHostingProfile]'>\r
		<option value='absolute'>" . $bts->I18nTransObj->getI18nTransEntry('dbp_asolute') . "</option>\r
		<option value='hostplan'>" . $bts->I18nTransObj->getI18nTransEntry('dbp_hosted') . "</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('DB_hostingInf') . "</span>";
		$l++;

		// DB Server
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_server');
		$T[$t][$l]['3']['cont'] = $bts->RenderFormObj->renderInputText("form[host]", $bts->CMObj->getConfigurationEntry('host'), "", 20);
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('DB_serverInf') . "</span>";
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_server_port');
		$T[$t][$l]['3']['cont'] = $bts->RenderFormObj->renderInputText("form[port]", $bts->CMObj->getConfigurationEntry('port'), "", 20);
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('DB_server_portInf') . "</span>";
		$l++;


		// Prefix
		$arrInputText1 = array(
			"id" => "form[dataBaseHostingPrefix]",
			"name" => "form[dataBaseHostingPrefix]",
			"size" => 10,
			"value" => $bts->CMObj->getConfigurationEntry('dataBaseHostingPrefix'),
			"onkeyup" => "li.insertValue ( this.value , '" . $this->FormName . "', ['form[dbHostingPrefixCopy_1]', 'form[dbHostingPrefixCopy_2]', 'form[dbHostingPrefixCopy_3]' ] );"
		);

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Db_prefix');
		$T[$t][$l]['2']['cont'] = $bts->RenderFormObj->renderInputTextEnhanced($arrInputText1);
		$T[$t][$l]['3']['cont'] = "";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('Db_prefixInf') . "</span>";
		$l++;

		// DB name
		$arrInputText1['id'] = "form[dbHostingPrefixCopy_1]";
		$arrInputText1['name'] = "form[dbHostingPrefixCopy_1]";
		$arrInputText1['value'] = "";
		$arrInputText1['readonly'] = true;
		$arrInputText1['disable'] = true;
		$arrInputText1['opkeyup'] = "";

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_name');
		$T[$t][$l]['2']['cont'] = $bts->RenderFormObj->renderInputTextEnhanced($arrInputText1);
		$T[$t][$l]['3']['cont'] = $bts->RenderFormObj->renderInputText("form[dbprefix]", $bts->CMObj->getConfigurationEntry('dbprefix'), "", 20, 32);
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('DB_nameInf') . "</span>";
		$l++;

		// Login
		$arrInputText1['id'] = "form[dbHostingPrefixCopy_2]";
		$arrInputText1['name'] = "form[dbHostingPrefixCopy_2]";
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_Admlogin');
		$T[$t][$l]['2']['cont'] = $bts->RenderFormObj->renderInputTextEnhanced($arrInputText1);
		$T[$t][$l]['3']['cont'] = $bts->RenderFormObj->renderInputText("form[dataBaseAdminUser]", $bts->CMObj->getConfigurationEntry('admin_user'), "", 20, 32);
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('DB_AdmloginInf') . "</span>";
		$l++;

		// Password
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_password');
		$T[$t][$l]['3']['cont'] = $bts->RenderFormObj->renderInputPassword("form[dataBaseAdminPassword]", $bts->CMObj->getConfigurationEntry('admin_password'), "", 20, 32) . "\r<br>\r"
			. "<span style='font-size:75%;' onmousedown=\"elm.Gebi('form[dataBaseAdminPassword]').type = 'text';\" onmouseup=\"elm.Gebi('form[dataBaseAdminPassword]').type = 'password';\">"
			. $bts->I18nTransObj->getI18nTransEntry('unveilPassword')
			. "</span>";
		$l++;


		$SB['id']				= "bouton_install_testdb";
		$SB['type']				= "button";
		$SB['initialStyle']		= $Block . "_submit_s1_n";
		$SB['hoverStyle']		= $Block . "_submit_s1_h";
		$SB['onclick']			= "tdb.toggleDbResultDivs ('cnxToDB', false ); tdb.toggleDbResultDivs ('HydrDBAlreadyExist', false ); tdb.testDbCnx(); var tmp_cnx_chaine = document.forms['" . $this->FormName . "'].elements['form[dataBaseHostingPrefix]'].value + document.forms['" . $this->FormName . "'].elements['form[dataBaseAdminUser]'].value + '@' + document.forms['" . $this->FormName . "'].elements['form[host]'].value  + ', Database: ' + document.forms['" . $this->FormName . "'].elements['form[dataBaseHostingPrefix]'].value + document.forms['" . $this->FormName . "'].elements['form[dbprefix]'].value ; li.insertValue ( tmp_cnx_chaine , '" . $this->FormName . "', [ 'form[TestCnxString]']  );";
		$SB['message']			= "Test DB";
		$SB['mode']				= 1;
		$SB['size'] 			= 128;
		$SB['lastSize']			= 128;

		$arrInputText1['id'] = "form[TestCnxString]";
		$arrInputText1['name'] = "form[TestCnxString]";
		$arrInputText1['size'] = 40;
		$pv['div_cnx_db'] = $bts->RenderFormObj->renderInputTextEnhanced($arrInputText1) . "\r<br>\r";

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_tstcnx');
		$T[$t][$l]['3']['cont'] = $bts->InteractiveElementsObj->renderSubmitButton($SB);
		$divImgSrc = "<div style='width:18px; height:18px; background-size:contain; display:inline-block; vertical-align:middle;' class='" . $Block;

		$T[$t][$l]['4']['cont'] = $pv['div_cnx_db']
			. "<div id='cnxToDBok'				style='font-size:80%; visibilty:hidden; display:none; position:realtive;'>											" . $divImgSrc . "_icon_ok"				. "'></div> " . $bts->I18nTransObj->getI18nTransEntry('DB_cnxToDBok') . "</div>"
			. "<div id='cnxToDBko'				style='font-size:80%; visibilty:hidden; display:none; position:realtive;' class='" . $Block . _CLASS_TXT_ERROR_ . "'>		" . $divImgSrc . "_icon_nok"			. "'></div> " . $bts->I18nTransObj->getI18nTransEntry('DB_cnxToDBko') . "</div>"
			. "<div id='HydrDBAlreadyExistok'	style='font-size:80%; visibilty:hidden; display:none; position:realtive;' class='" . $Block . _CLASS_TXT_WARNING_ . "'>	" . $divImgSrc . "_icon_notification"	. "'></div> " . $bts->I18nTransObj->getI18nTransEntry('DB_HydrDBAlreadyExistok') . "</div>"
			. "<div id='HydrDBAlreadyExistko'	style='font-size:80%; visibilty:hidden; display:none; position:realtive;'>											" . $divImgSrc . "_icon_ok"				. "'></div> " . $bts->I18nTransObj->getI18nTransEntry('DB_HydrDBAlreadyExistko') . "</div>"
			. "<div id='installationLockedok'	style='font-size:80%; visibilty:hidden; display:none; position:realtive;'  class='" . $Block . _CLASS_TXT_ERROR_ . "'>	" . $divImgSrc . "_icon_nok"			. "'></div> " . $bts->I18nTransObj->getI18nTransEntry('DB_installationLockedko') . "</div>"
			. "<div id='installationLockedko'	style='font-size:80%; visibilty:hidden; display:none; position:realtive;'>											" . $divImgSrc . "_icon_ok"				. "'></div> " . $bts->I18nTransObj->getI18nTransEntry('DB_installationLockedok') . "</div>";

		$SrvUri = $_SERVER['REQUEST_URI'];
		$uriCut = strpos($_SERVER['REQUEST_URI'], "/Hydr/current/install/install_page_01.php");
		$SrvUri = substr($_SERVER['REQUEST_URI'], 0, $uriCut);

		$GeneratedScriptObj->insertString('JavaScript-Data', "var RequestURI = \"" . $SrvUri . "\"");
		$GeneratedScriptObj->insertString('JavaScript-Data', "var FormName = \"" . $this->FormName . "\"");
		$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\tli.selectMenuBuilder ( 'form[selectedDataBaseType]' , listOfDBSupport['PHP'] );");

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig($l, 4, 1);
	}

	/**
	 * installationMethod
	 */
	private function installationMethod($infos, $t)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;

		$T = &$this->T['Content'];

		$bubbleBegin = "<img src='media/theme/" . $ThemeDataObj->getDefinitionValue('directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_question') . "' width='24' height='24' border='0' onMouseOver=\"t.ToolTip('";
		$bubbleEnd = "', 'install')\" onMouseOut=\"t.ToolTip('','install')\">";
		$l = 1;
		$T[$t]['caption']['cont'] = $bts->I18nTransObj->getI18nTransEntry('MTH_intro');
		$T[$t][$l]['1']['cont'] = "<input type='radio' name='form[operantingMode]' onClick='li.setFormPreconizedSettings()' value='directCnx' checked>" . $bts->I18nTransObj->getI18nTransEntry('MTH_opt1') . $bubbleBegin . $bts->I18nTransObj->getI18nTransEntry('MTH_opt1Help') . $bubbleEnd;
		$T[$t][$l]['2']['cont'] = "<input type='radio' name='form[operantingMode]' onClick='li.setFormPreconizedSettings()' value='createScript'>" . $bts->I18nTransObj->getI18nTransEntry('MTH_opt2') . $bubbleBegin . $bts->I18nTransObj->getI18nTransEntry('MTH_opt2Help') . $bubbleEnd;

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig($l, 2, 0);
	}

	/**
	 * siteSelection
	 */
	private function siteSelection($infos, $t)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		$Block = $ThemeDataObj->getThemeName() . $infos['block'];
		$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;
		$Content = "";

		$T = &$this->T['Content'];

		$l = 1;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SIT_Titlec1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SIT_Titlec2');
		$T[$t][$l]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SIT_Titlec3');

		$i = 0;
		$directory_list = array();
		$handle = opendir("websites-data/");
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && !is_file("../websites-data/" . $file)) {
				$directory_list[$i] = $file;
			}
			$i++;
		}
		$i = 2;
		closedir($handle);
		sort($directory_list);
		reset($directory_list);

		$DirectoryStateList = array();
		$FormDirectoryNameList = array();
		foreach ($directory_list as $a) {
			if ($a == "00_Hydre") {
				$T[$t][$i]['1']['cont'] = "<span style='font-style:italic'>" . $a . "</span>\r";
				$T[$t][$i]['2']['cont'] = "<input type='checkbox' name='directory_list[" . $a . "][plouf]' disabled checked >";
				$T[$t][$i]['3']['cont'] = "<input type='checkbox' name='directory_list[" . $a . "][plouf2]' disabled checked >\r
				<input type='hidden' name='directory_list[" . $a . "][name]' value='" . $a . "'>\r
				<input type='hidden' name='directory_list[" . $a . "][state]' value='on'>\r";
			} else {
				$T[$t][$i]['1']['cont'] = $a . " <input type='hidden' name='directory_list[" . $a . "][name]' value='" . $a . "'>\r";
				$T[$t][$i]['2']['cont'] = "<input type='checkbox' name='directory_list[" . $a . "][state]' checked onClick='li.setFormPreconizedSettings()'>\r";
				$T[$t][$i]['3']['cont'] = "<input type='checkbox' name='directory_list[" . $a . "][code_verification]' checked>\r";
				$DirectoryStateList[] = "directory_list[" . $a . "][state]";
				$FormDirectoryNameList[] = $a;
			}
			$i++;
		}
		$T['ContentCfg']['tabs'][$t]['NbrOfLines'] = ($i - 1);

		$str = "var enabledDirectoryList = [\r";
		foreach ($DirectoryStateList as $A) {
			$str .= "\"" . $A . "\", \r";
		}
		$str = substr($str, 0, -3) . "\r];\r";

		$str .= "var DirectoryNameList = [\r";
		foreach ($FormDirectoryNameList as $B) {
			$str .= "\"" . $B . "\", \r";
		}
		$str = substr($str, 0, -3) . "\r];\r";

		$GeneratedScriptObj->insertString('JavaScript-Data', $str);
		$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\tli.setFormPreconizedSettings();");

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig(($i - 1), 3, 1);
	}

	/**
	 * personalization
	 */
	private function personalization($infos, $t)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		$Block = $ThemeDataObj->getThemeName() . $infos['block'];
		$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;
		$Content = "";

		$T = &$this->T['Content'];
		$lang = $CurrentSetObj->getDataEntry('language');

		$l = 1;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_Titlec1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_Titlec2');
		$T[$t][$l]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_Titlec3');
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_Titlec4');
		$l++;


		$arrInputText1 = array(
			"id" => "form[tabprefix]",
			"name" => "form[tabprefix]",
			"size" => 10,
			"maxlength" => 32,
			"value" => $bts->CMObj->getConfigurationEntry('tabprefix'),
			"onkeyup" => "li.insertValue ( 'Ex: ' + this.value + 'article_config' , '" . $this->FormName . "', ['form[ExamplePrefix]'] );"
		);

		$arrInputText2 = array(
			"id" => "form[ExamplePrefix]",
			"name" => "form[ExamplePrefix]",
			"size" => 20,
			"value" => "",
			"readonly" => true,
			"disable" => true,
		);

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_TbPrfx');
		$T[$t][$l]['2']['cont'] = $bts->RenderFormObj->renderInputTextEnhanced($arrInputText1);
		$T[$t][$l]['3']['cont'] = $bts->RenderFormObj->renderInputTextEnhanced($arrInputText2);
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('PER_TbPrfxInf') . "</span>";
		$GeneratedScriptObj->insertString('JavaScript-Onload', "li.insertValue ( 'Ex: " . $bts->CMObj->getConfigurationEntry('tabprefix') . "article_config' , '" . $this->FormName . "', ['form[dbHostingPrefixCopy_1]' , 'form[dbHostingPrefixCopy_1]' ] );");
		$l++;

		$arrInputText2['id'] = "form[dbHostingPrefixCopy_3]";
		$arrInputText2['name'] = "form[dbHostingPrefixCopy_3]";
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_DbUsrN');
		$T[$t][$l]['2']['cont'] = $bts->RenderFormObj->renderInputTextEnhanced($arrInputText2);
		$T[$t][$l]['3']['cont'] = $bts->RenderFormObj->renderInputText("form[dataBaseUserLogin]", $bts->CMObj->getConfigurationEntry('db_user_login'), "", 20, 32);
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('PER_DbUsrNInf') . "</span>";
		$l++;

		$SB['id']				= "bouton_install_radompass";
		$SB['type']				= "button";
		$SB['initialStyle']		= $Block . "_submit_s1_n";
		$SB['hoverStyle']		= $Block . "_submit_s1_h";
		$SB['onclick']			= "elm.SetFormInputValue ( '" . $this->FormName . "' , 'form[dataBaseUserPassword]' , li.createRandomPassword( 20 ) );";
		$SB['message']			= $bts->I18nTransObj->getI18nTransEntry('boutonpass');
		$SB['mode']				= 1;
		$SB['size'] 			= 128;
		$SB['lastSize']			= 128;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_DbUsrP');
		$T[$t][$l]['3']['cont'] = $bts->RenderFormObj->renderInputPassword("form[dataBaseUserPassword]", $bts->CMObj->getConfigurationEntry('db_user_password'), "", 20, 32) . "\r<br>\r"
			. "<span style='font-size:75%;' onmousedown=\"elm.Gebi('form[dataBaseUserPassword]').type = 'text';\" onmouseup=\"elm.Gebi('form[dataBaseUserPassword]').type = 'password';\">"
			. $bts->I18nTransObj->getI18nTransEntry('unveilPassword')
			. "</span>";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('PER_DbUsrPInf') . "</span>\r<br>\r<br>\r" . $bts->InteractiveElementsObj->renderSubmitButton($SB);
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_UsrRec');
		$T[$t][$l]['3']['cont'] = "<select name='form[dataBaseUserRecreate]'>\r
		<option value='no'>" . $bts->I18nTransObj->getI18nTransEntry('dbr_n') . "</option>\r
		<option value='yes' selected >" . $bts->I18nTransObj->getI18nTransEntry('dbr_o') . "</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('PER_UsrRecInf') . "</span>";
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_WbUsrP');
		$T[$t][$l]['3']['cont'] = $bts->RenderFormObj->renderInputPassword("form[websiteUserPassword]", $bts->CMObj->getConfigurationEntry('db_user_password'), "", 20, 32) . "\r<br>\r"
			. "<span style='font-size:75%;' onmousedown=\"elm.Gebi('form[websiteUserPassword]').type = 'text';\" onmouseup=\"elm.Gebi('form[websiteUserPassword]').type = 'password';\">"
			. $bts->I18nTransObj->getI18nTransEntry('unveilPassword')
			. "</span>";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('PER_WbUsrPInf') . "</span>";
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_MkHtacs');
		$T[$t][$l]['3']['cont'] = "<select name='form[creationHtaccess]'>\r
		<option value='no' selected>" . $bts->I18nTransObj->getI18nTransEntry('dbr_n') . "</option>\r
		<option value='yes'>" . $bts->I18nTransObj->getI18nTransEntry('dbr_o') . "</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('PER_MkHtacsInf') . "</span>";
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('PER_Typexe');
		$T[$t][$l]['3']['cont'] = "<select name='form[TypeExec]'>\r
		<option value='ModuleApache' selected>" . $bts->I18nTransObj->getI18nTransEntry('TypeExec1') . "</option>\r
		<option value='CLI'>" . $bts->I18nTransObj->getI18nTransEntry('TypeExec2') . "</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>" . $bts->I18nTransObj->getI18nTransEntry('PER_TypexeInf') . "</span>";

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig($l, 4, 1);
	}

	/**
	 * logConfig
	 */
	private function logConfig($infos, $t)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$T = &$this->T['Content'];

		$l = 1;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('REP_Titlec1');
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('REP_db');
		$T[$t][$l]['2']['cont'] = "<input type='checkbox' name='form[dataBaseLogWarning]'>" . $bts->I18nTransObj->getI18nTransEntry('REP_wrnMsg');
		$T[$t][$l]['3']['cont'] = "<input type='checkbox' name='form[dataBaseLogError]' checked>" . $bts->I18nTransObj->getI18nTransEntry('REP_errMsg');
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('REP_consol');
		$T[$t][$l]['2']['cont'] = "<input type='checkbox' name='form[consoleLogWarning]' checked>" . $bts->I18nTransObj->getI18nTransEntry('REP_wrnMsg');
		$T[$t][$l]['3']['cont'] = "<input type='checkbox' name='form[consoleLogError]' checked>" . $bts->I18nTransObj->getI18nTransEntry('REP_errMsg');

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig($l, 3, 1);
	}



	/**
	 *  Detects PEAR support. 
	 * 	PEAR can be used for Mysql Connection. But with no WARRANTY.
	 *  mysqli MDB2 driver 1.5.0b4 (beta) was released on 2012-10-23 by danielc (Changelog)
	 * 
	 * 
	 * Example:
	 *	sudo pear list
	 *	sudo pear install MDB2_Driver_sqlite
	 *	sudo pear list
	 *	sudo pear upgrade-all
	 *
	 *	xxxxx@xxxxx:/usr/share/php$ pear list
	 *	Installed packages, channel pear.php.net:
	 *	=========================================
	 *	Package            Version State
	 *	Archive_Tar        1.3.3   stable
	 *	Console_Getopt     1.2.3   stable
	 *	DB                 1.7.13  stable
	 *	MDB2               2.4.1   stable
	 *	MDB2_Driver_mysql  1.4.1   stable
	 *	MDB2_Driver_sqlite 1.4.1   stable
	 *	PEAR               1.8.1   stable
	 *	Structures_Graph   1.0.2   stable
	 *	XML_Util           1.2.1   stable
	 */
	private function detectionPEARSupport($infos)
	{
		// $bts = BaseToolSet::getInstance(); 
		// $CurrentSetObj = CurrentSet::getInstance();
		// $Block = $CurrentSetObj->ThemeDataObj->getThemeName().$infos['block'];
		// $Content ="<b>".$bts->I18nTransObj->getI18nTransEntry('PHP_pear_support')."</b><br>";

		// $pearSupportedDB = array(
		// 	'mysql' =>			array('name' => 'mysql',			'section' => 'ADO_MYSQL',	'title' => 'mysql'),
		// 	'sqlite' =>			array('name' => 'sqlite',			'section' => 'ADO_SQLITE',	'title' => 'SQLite'),
		// );

		// $B = "";
		// if ( file_exists ("/usr/bin/pear list") ) {
		// 	if ( function_exists( 'exec' ) ) {
		// 		$pv['exec_state'] = 1;
		// 		exec ( "/usr/bin/pear list" , $PEAR , $pv['exec_state'] );
		// 		if ( $pv['exec_state'] == 0 ) {
		// 			foreach ( $PEAR as $A ) {
		// 				if ( strpos ( $A , "MDB2_Driver_mysql" ) !== FALSE ) { $B .= $A;	$pearSupportedDB['mysql']['enabled'] = true;	$this->pearSupportEnabled = true;}
		// 				if ( strpos ( $A , "MDB2_Driver_sqlite" ) !== FALSE  ) { $B .= $A; 	$pearSupportedDB['sqlite']['enabled'] = true;	$this->pearSupportEnabled = true;}
		// 			}
		// 		}
		// 		if ( $this->pearSupportEnabled == true ) {
		// 			$this->pearJavascriptObj = "\t'PEAR' :  {\r";
		// 			foreach ( $pearSupportedDB as $A ) {
		// 				if ( $A['enabled'] == true ) {
		// 					$this->pearJavascriptObj .= "\t\t'".$A['name']."' : { v:'".$A['name']."',	't':'".$A['title']."'}, \r";
		// 				}
		// 			}
		// 			$this->pearJavascriptObj .= substr ( $this->pearJavascriptObj , 0 , -2 ) ."\r\t},\r";
		// 		}
		// 	}
		// 	$Content .= $infos['iconGoNoGoOk']."<span style='vertical-align:super;'>PEAR ".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok').". </span><br>\r";
		// }
		// else {
		// 	$Content .= $infos['iconGoNoGoNok']."<span class='".$Block."_warning' style='vertical-align:super;'>PEAR ".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_nok').". </span><br>\r";
		// }
		// return $Content;
	}

	/**
	 * detectionADODBSupport
	 */
	private function detectionADODBSupport($infos)
	{
	// 	$bts = BaseToolSet::getInstance();
	// 	$CurrentSetObj = CurrentSet::getInstance();
	// 	$Block = $CurrentSetObj->ThemeDataObj->getThemeName() . $infos['block'];


	// 	$Content = "<b>" . $bts->I18nTransObj->getI18nTransEntry('PHP_adodb_support') . "</b><br>";
	// 	if (file_exists("/usr/share/php/adodb/adodb.inc.php")) {
	// 		include("/usr/share/php/adodb/adodb.inc.php");
	// 		$Content .= $infos['iconGoNoGoOk'] . "<span style='vertical-align:super;'>ADOdb " . $bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok') . "(" . $ADODB_vers . "). </span><br>\r";

	// 		$adoSupportedDB = array(
	// 			'db2' =>			array('enabled' => true,	'name' => 'db2',			'section' => 'ADO_DB2',		'title' => 'IBM DB2'),
	// 			'mssqlnative' =>	array('enabled' => true,	'name' => 'mssqlnative',	'section' => 'ADO_MSSQL',	'title' => 'Microsoft SQL server'),
	// 			'mysql' =>			array('enabled' => true,	'name' => 'mysql',			'section' => 'ADO_MYSQL',	'title' => 'mysql'),
	// 			'oci8' =>			array('enabled' => true,	'name' => 'oci8',			'section' => 'ADO_OCI8',	'title' => 'Oracle'),
	// 			'pgsql' =>			array('enabled' => true,	'name' => 'pqsql',			'section' => 'ADO_PGSQL',	'title' => 'PostgreSQL'),
	// 			'sqlite' =>			array('enabled' => true,	'name' => 'sqlite',			'section' => 'ADO_SQLITE',	'title' => 'SQLite'),
	// 		);
	// 		$this->adoJavascriptObj = "\t'ADODB' :  {\r";
	// 		foreach ($adoSupportedDB as $A) {
	// 			if ($A['enabled'] == true) {
	// 				$this->adoJavascriptObj .= "\t\t'" . $A['name'] . "' : { v:'" . $A['name'] . "',	't':'" . $A['title'] . "'}, \r";
	// 			}
	// 		}
	// 		$this->adoJavascriptObj = substr($this->adoJavascriptObj, 0, -3) . "\r\t},\r";
	// 		$this->adoSupportEnabled = true;
	// 	} else {
	// 		$Content .= $infos['iconGoNoGoNok'] . "<span class='" . $Block . "_warning' style='vertical-align:super;'>ADOdb " . $bts->I18nTransObj->getI18nTransEntry('PHP_builtin_nok') . ". </span><br>\r";
	// 	}
	// 	return ($Content);
	}

	/**
	 * detectionPDOSupport
	 */
	private function detectionPDOSupport($infos)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$Block = $CurrentSetObj->ThemeDataObj->getThemeName() . $infos['block'];
		$Content = "<b>" . $bts->I18nTransObj->getI18nTransEntry('PHP_pdo_support') . "</b><br>";


		if (extension_loaded('pdo') == true) {
			$pdoSupportedDB = array(
				'mysql' =>		array('name' => 'mysql',		'section' => 'PDO_MYSQL',		'title' => 'MySQL'),
				'sqlite' =>		array('name' => 'sqlite',		'section' => 'PDO_SQLITE',		'title' => 'SQlite'),
				'pgsql' =>		array('name' => 'pgsql',		'section' => 'PDO_PGSQL',		'title' => 'PostGreSQL'),
				'cubrid' =>		array('name' => 'cubrid',		'section' => 'PDO_CUBRID',		'title' => 'Cubrid'),
				'dblib' =>		array('name' => 'dblib',		'section' => 'PDO_DBLIB',		'title' => 'FreeTDS / Microsoft SQL Server / Sybase'),
				'firebird' =>	array('name' => 'firebird',		'section' => 'PDO_FIREBIRD',	'title' => 'Firebird'),
				'ibm' =>		array('name' => 'ibm',			'section' => 'PDO_IBM',			'title' => 'IBM DB2'),
				'informix' =>	array('name' => 'informix',		'section' => 'PDO_INFORMIX',	'title' => 'IBM Informix Dynamic Server'),
				'oci' =>		array('name' => 'oci',			'section' => 'PDO_OCI',			'title' => 'Oracle Call Interface'),
				'odbc' =>		array('name' => 'odbc',			'section' => 'PDO_ODBC',		'title' => 'ODBC v3'),
				'sqlsrv' =>		array('name' => 'sqlsrv',		'section' => 'PDO_SQLSRV',		'title' => 'Microsoft SQL Server / SQL Azure'),
			);

			$pdoAvailableDrivers = PDO::getAvailableDrivers();
			foreach ($pdoAvailableDrivers as $A) {
				$pdoSupportedDB[$A]['enabled'] = true;
			}

			$strStartOk = $infos['iconGoNoGoOk'] . "<span style='vertical-align:super;'>";
			$strEndOk = " " . $bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok') . ". </span><br>\r";

			foreach ($pdoSupportedDB as $A) {
				if ($A['enabled'] == 1) {
					$Content .= $strStartOk . $A['title'] . $strEndOk;
					$this->pdoSupportEnabled = true;
					$this->availableSupport['DAL']['PDO']['state'] = 1;
					$this->availableSupport['DAL'][$A['section']]['state'] = 1;
				}
			}
			if ($this->pdoSupportEnabled == true) {
				$this->pdoJavascriptObj = "\t'PDO' :  {\r";
				foreach ($pdoSupportedDB as $A) {
					if ($A['enabled'] == true) {
						$this->pdoJavascriptObj .= "\t\t'" . $A['name'] . "' : { v:'" . $A['name'] . "',	't':'" . $A['title'] . "'}, \r";
					}
				}
				$this->pdoJavascriptObj = substr($this->pdoJavascriptObj, 0, -3) . "\r\t},\r";
			}
		}
		return ($Content);
	}

	/**
	 * detectionPHPbuiltinSupport
	 */
	private function detectionPHPbuiltinSupport($infos)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$Block = $CurrentSetObj->ThemeDataObj->getThemeName() . $infos['block'];
		$Content = "<b>" . $bts->I18nTransObj->getI18nTransEntry('PHP_db_builtin_functions') . "</b><br>";

		// https://www.php.net/manual/fr/refs.database.php

		$phpSupportedDB = array(
			'PHP_cubrid_builtin'		=> array('name' => 'cubrid',		'f' => 'cubrid_connect',		'title' => 'Cubrid'),
			'PHP_dbase_builtin'			=> array('name' => 'dbase',			'f' => 'dbase_open',			'title' => 'DBase'),
			'PHP_ibase_builtin'			=> array('name' => 'firebird',		'f' => 'ibase_connect',			'title' => 'Firebird/InterBase'),
			'PHP_db2_builtin'			=> array('name' => 'db2',			'f' => 'db2_connect',			'title' => 'IBM DB2'),
			'PHP_mysqli_builtin'		=> array('name' => 'mysql',			'f' => 'mysqli_connect',		'title' => 'MySQLi'),
			'PHP_oci_builtin'			=> array('name' => 'oci8',			'f' => 'oci_connect',			'title' => 'OCI8'),
			'PHP_postgresql_builtin'	=> array('name' => 'pgsql',			'f' => 'pg_connect',			'title' => 'PostgreSQL'),
			'PHP_sqlite_builtin'		=> array('name' => 'sqlite',		'f' => 'sqlite_open',			'title' => 'SQLite'),
			'PHP_sqlsrv_builtin'		=> array('name' => 'sqlsrv',		'f' => 'sqlsrv_connect',		'title' => 'SQLSRV'),
		);

		foreach ($phpSupportedDB as &$A) {
			if (function_exists($A['f']) == true) {
				$A['enabled'] = 1;
				$this->phpSupportEnabled = true;
				$Content .= $infos['iconGoNoGoOk'] . "<span style='vertical-align:super;'>" . $A['name']  . " " . $bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok') . ".</span> ";
			}
		}
		$Content .= "<br>\r";

		if ($this->phpSupportEnabled == true) {
			$this->phpJavascriptObj = "\t'PHP' :  {\r";
			foreach ($phpSupportedDB as $A) {
				if ($A['enabled'] == true) {
					$this->phpJavascriptObj .= "\t\t'" . $A['name'] . "' : { v:'" . $A['name'] . "',	't':'" . $A['title'] . "'}, \r";
				}
			}
			$this->phpJavascriptObj = substr($this->phpJavascriptObj, 0, -3) . "\r\t},\r";
		}

		return ($Content);
	}
}
