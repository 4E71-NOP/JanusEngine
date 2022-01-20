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

class InstallPage01 {
	private static $Instance = null;
	private $T = array();
	private $FormName = "install_page_init";

	private $pearSupportEnabled = false;
	private $pearJavascriptObj = array();
	
	private $adoSupportEnabled = false;
	private $adoJavascriptObj = array();
	
	private $pdoSupportEnabled = false;
	private $pdoJavascriptObj = array();
	
	private $phpSupportEnabled = false;
	private $phpJavascriptObj = array();

	public function __construct() {}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return InstallPage01
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new InstallPage01 ();
		}
		return self::$Instance;
	}

	/**
	 * Renders the page 01 content
	 */
	public function render($infos) {
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();
		$GeneratedScriptObj = $CurrentSetObj->getInstanceOfGeneratedScriptObj ();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];

		// --------------------------------------------------------------------------------------------
		// Specific values for installation form
		$bts->CMObj->setConfigurationEntry('admin_user','dbadmin');
		$bts->CMObj->setConfigurationEntry('admin_password','nimdabd');
		$bts->CMObj->setConfigurationEntry('db_hosting_prefix','');

		$langFile = $infos['module']['module_directory']."i18n/".$CurrentSetObj->getDataEntry ('language').".php";
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $langFile , "format" => "php" ));

		// --------------------------------------------------------------------------------------------
		//	Language selector
		
		$Content = "<form ACTION='install.php' id='".$this->FormName."' method='post'>\r";
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
		foreach ( $LangageSelector as $A ) {
			$Content .= "<a href='install.php?l=".$A['code']."'><img src='media/theme/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$A['file']."' alt='' height='64' width='64' border='0'></a>\r";
		}
		$Content .= "</p><br>\r";
		unset ($LangageSelector);


		// --------------------------------------------------------------------------------------------
		$infos['iconGoNoGoOk'] = "<img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ok') .	"' width='18' height='18' border='0'>";
		$infos['iconGoNoGoNok'] = "<img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_notification').	"' width='18' height='18' border='0'>";
		
		$this->T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 18, 6);

		$this->serverInfos($infos, 1);
		$this->databaseAccess($infos, 2);
		$this->installationMethod($infos, 3);
		$this->siteSelection($infos, 4);
		$this->personalization($infos, 5);
		$this->logConfig($infos, 6);

		// echo ($bts->StringFormatObj->print_r_html($this->T) );
		$Content .= $bts->RenderTablesObj->render($infos, $this->T);

		// --------------------------------------------------------------------------------------------
		$pv['ListeChamps']['0']['id'] = 'form[host]';					$pv['ListeChamps']['0']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls0');	$pv['ListeChamps']['0']['err'] = 0;
		$pv['ListeChamps']['1']['id'] = 'form[db_admin_user]';			$pv['ListeChamps']['1']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls1');	$pv['ListeChamps']['1']['err'] = 0;
		$pv['ListeChamps']['2']['id'] = 'form[db_admin_password]';		$pv['ListeChamps']['2']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls2');	$pv['ListeChamps']['2']['err'] = 0;
		$pv['ListeChamps']['3']['id'] = 'form[dbprefix]';				$pv['ListeChamps']['3']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls3');	$pv['ListeChamps']['3']['err'] = 0;
		$pv['ListeChamps']['4']['id'] = 'form[database_user_login]';	$pv['ListeChamps']['4']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls4');	$pv['ListeChamps']['4']['err'] = 0;
		$pv['ListeChamps']['5']['id'] = 'form[database_user_password]';	$pv['ListeChamps']['5']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls5');	$pv['ListeChamps']['5']['err'] = 0;
		$pv['ListeChamps']['6']['id'] = 'form[standard_user_password]';	$pv['ListeChamps']['6']['name'] = $bts->I18nTransObj->getI18nTransEntry('ls6');	$pv['ListeChamps']['6']['err'] = 0;
		
		$pv['JSONListeChamps'] = "var ListeChamps = { \r";
		$i = 0;
		foreach ( $pv['ListeChamps'] as $A ) {
			$pv['JSONListeChamps'] .= "'".$i."' : { 'id':'".$A['id']."', 'name':'".$A['name']."', 'err':'0' },\r";
			$i++;
		}
		$pv['JSONListeChamps'] = substr ( $pv['JSONListeChamps'] , 0 , -2 ) . "}; ";
		$GeneratedScriptObj->insertString('JavaScript-Data' , $pv['JSONListeChamps']);
		$GeneratedScriptObj->insertString('JavaScript-Data' , " var AlertCheckFormValues = '". $bts->I18nTransObj->getI18nTransEntry('avcf') ."'");

		// --------------------------------------------------------------------------------------------
		$SessionID = floor ( $bts->TimeObj->getMicrotime() );
		
		$SB = array();
		$SB['id']				= "bouton_install_p1";
		$SB['type']				= "button";
		$SB['initialStyle']		= $Block."_submit_s2_n";
		$SB['hoverStyle']		= $Block."_submit_s3_h";
		$SB['onclick']			= "li.checkFormValues( ListeChamps , '".$CurrentSetObj->getDataEntry ('language')."' , '".$SessionID."')";
		$SB['message']			= $bts->I18nTransObj->getI18nTransEntry('bouton');
		$SB['mode']				= 1;
		$SB['size'] 			= 256;
		$SB['lastSize']			= 256;
		
		$Content .= "
		<br>\r
		<br>\r
		<div style='position: absolute; text-align: center; width: 100%;'>\r
		<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
		<tr>\r
		<td>\r
		".
		$bts->InteractiveElementsObj->renderSubmitButton($SB).
		"
		</td>\r
		</tr>\r
		</table>\r
		</div>
		<input type='hidden' name='PageInstall' value='2'>\r
		<input type='hidden' name='SessionID' value='".$SessionID."'>\r
		<input type='hidden' name='l' value='".$CurrentSetObj->getDataEntry ('language')."'>\r
				
		</form>\r
		<br>\r<br>\r<br>\r<br>\r<br>\r
		";

		$listOfSupport = "var listOfDBSupport = {\r";
		$listOfSupport .= ($this->pearSupportEnabled == true) ? $this->pearJavascriptObj	: "";
		$listOfSupport .= ($this->adoSupportEnabled == true) ? $this->adoJavascriptObj	: "";
		$listOfSupport .= ($this->pdoSupportEnabled == true) ? $this->pdoJavascriptObj	: "";
		$listOfSupport .= ($this->phpSupportEnabled == true) ? $this->phpJavascriptObj	: "";
		$listOfSupport .= "};\r";
		$GeneratedScriptObj->insertString('JavaScript-Data' , $listOfSupport);

		return ($Content);

	}
	
	/**
	 * Fill the table with the server information
	 */
	private function serverInfos($infos, $t) {
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		$ServerInfosObj = $CurrentSetObj->getInstanceOfServerInfosObj();

		$DBsupport = $this->detectionPHPbuiltinSupport($infos).$this->detectionPDOSupport($infos).$this->detectionADODBSupport($infos).$this->detectionPEARSupport($infos);

		$T = &$this->T['Content'];

		$l=1;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('srv_hostname');

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "PHP vrs " . phpversion();


		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('include_path');

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('repertoire_courant');

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('display_errors')." / ".$bts->I18nTransObj->getI18nTransEntry($ServerInfosObj->getServerInfosEntry('register_globals'))." / ".$ServerInfosObj->getServerInfosEntry('post_max_size');

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('memory_limit');
		if ( intval(str_replace( "M", "", $ServerInfosObj->getServerInfosEntry('memory_limit') )) < 128 ) { $T[$t][$l]['2']['cont'] .= " (<span class='".$Block."_warning'>".$bts->I18nTransObj->getI18nTransEntry('test_nok')."</span>)"; }
		else { $T[$t][$l]['2']['cont'] .= " ".$bts->I18nTransObj->getI18nTransEntry('test_ok'); }

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $ServerInfosObj->getServerInfosEntry('max_execution_time') ."s";
		if ( $ServerInfosObj->getServerInfosEntry('max_execution_time') >= 60 ) { $T[$t][$l]['2']['cont'] .= " (<span class='".$Block."_warning'>".$bts->I18nTransObj->getI18nTransEntry('test_nok')."</span>)"; }
		else { $T[$t][$l]['2']['cont'] .= " ".$bts->I18nTransObj->getI18nTransEntry('test_ok'); }

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $DBsupport;

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "<input type='text' size='2' name='form[memory_limit]'	value=''>M";

		$l++;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "<input type='text' size='2' name='form[time_limit]'		value=''>s";

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig(10,2,2);		
	}

	/**
	 * databaseAccess
	 */
	private function databaseAccess($infos, $t){
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		$GeneratedScriptObj = $CurrentSetObj->getInstanceOfGeneratedScriptObj ();
		$Content ="";

		$T = &$this->T['Content'];
		$lang = $CurrentSetObj->getDataEntry ('language');
		
		$l = 1;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_Titlec1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_Titlec2');
		$T[$t][$l]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_Titlec3');
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_Titlec4');
		$l++;
		
		unset ($tab_);
		$tab_[$bts->CMObj->getConfigurationEntry('dal')] = " selected ";
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_dal');
		// $T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<select id='form[dal]' name='form[dal]' onChange=\"li.selectMenuBuilder ( 'form[database_type_choix]' , listOfDBSupport[this.value] );\">\r";
		if ( $this->phpSupportEnabled == true )		{ $T[$t][$l]['3']['cont'] .= "<option value='PHP'		".$tab_['PHP'].">".		$bts->I18nTransObj->getI18nTransEntry('msdal_php')."</option>\r"; }
		if ( $this->pdoSupportEnabled == true )		{ $T[$t][$l]['3']['cont'] .= "<option value='PDO'		".$tab_['PDO'].">".		$bts->I18nTransObj->getI18nTransEntry('msdal_pdo')."</option>\r"; }
		if ( $this->adoSupportEnabled == true )		{ $T[$t][$l]['3']['cont'] .= "<option value='ADODB'		".$tab_['ADODB'].">".	$bts->I18nTransObj->getI18nTransEntry('msdal_adodb')."</option>\r"; }
		if ( $this->pearSupportEnabled == true )	{ $T[$t][$l]['3']['cont'] .= "<option value='PEAR'		".$tab_['PEARDB'].">".	$bts->I18nTransObj->getI18nTransEntry('msdal_pear')."</option>\r"; }
		
		$T[$t][$l]['3']['cont'] .= "</select>\r";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('DB_dalInf')."</span>";
		$l++;
		
		// DB Type selection
		unset ($tab_);
		$tab_[$bts->CMObj->getConfigurationEntry('type')] = " selected ";
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_type');
		// $T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<select id='form[database_type_choix]' name='form[database_type_choix]'>\r
		</select>\r
		";
		// <option value='mysql'	".$tab_['mysql'].">MySQL 3.x/4.x/5.x</option>\r
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('DB_typeInf')."</span>";
		$l++;
		
		// Hosting plan
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_hosting');
		// $T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		
		$T[$t][$l]['3']['cont'] = "<select name='form[database_profil]'>\r
		<option value='absolute'>".$bts->I18nTransObj->getI18nTransEntry('dbp_asolute')."</option>\r
		<option value='hostplan'>".$bts->I18nTransObj->getI18nTransEntry('dbp_hosted')."</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('DB_hostingInf')."</span>";
		$l++;
		
		// DB Server
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_server');
		// $T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_serverInf');
		$T[$t][$l]['3']['cont'] = "<input type='text' name='form[host]' size='20' maxlength='255' value='".$bts->CMObj->getConfigurationEntry('host')."'>";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('DB_serverInf')."</span>";
		$l++;
		
		// Prefix
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Db_prefix');
		$T[$t][$l]['2']['cont'] = "<input type='text' name='form[db_hosting_prefix]' size='10' maxlength='255' value='".$bts->CMObj->getConfigurationEntry('db_hosting_prefix')."' OnKeyup=\"li.insertValue ( this.value , '".$this->FormName."', ['form[db_hosting_prefix_copie_1]', 'form[db_hosting_prefix_copie_2]', 'form[db_hosting_prefix_copie_3]' ] );\">";
		$T[$t][$l]['3']['cont'] = "";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('Db_prefixInf')."</span>";
		$l++;
		
		// DB name
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_name');
		$T[$t][$l]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_1]' size='10' maxlength='255' value=''>";
		$T[$t][$l]['3']['cont'] = "<input type='text' name='form[dbprefix]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('dbprefix')."'>";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('DB_nameInf')."</span>";
		$l++;
		
		// Login
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_Admlogin');
		$T[$t][$l]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_2]' size='10' maxlength='255' value=''>";
		$T[$t][$l]['3']['cont'] = "<input type='text' name='form[db_admin_user]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('admin_user')."'>";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('DB_AdmloginInf')."</span>";
		$l++;
		
		// Password
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_password');
		// $T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<input type='password' name='form[db_admin_password]' id='form[db_admin_password]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('admin_password')."'><br>"
		."<span style='font-size:75%;' onmousedown=\"elm.Gebi('form[db_admin_password]').type = 'text';\" onmouseup=\"elm.Gebi('form[db_admin_password]').type = 'password';\">"
		.$bts->I18nTransObj->getI18nTransEntry('unveilPassword')
		."</span>";
		// $T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c4')."</span>";
		$l++;
		
		
		$SB['id']				= "bouton_install_testdb";
		$SB['type']				= "button";
		$SB['initialStyle']		= $Block."_submit_s1_n";
		$SB['hoverStyle']		= $Block."_submit_s1_h";
		$SB['onclick']			= "li.toggleDbResultDivs ('cnxToDB', false ); toggleDiv ('HydrDBAlreadyExist', false ); tdb.testDbCnx(); var tmp_cnx_chaine = document.forms['".$this->FormName."'].elements['form[db_hosting_prefix]'].value + document.forms['".$this->FormName."'].elements['form[db_admin_user]'].value + '@' + document.forms['".$this->FormName."'].elements['form[host]'].value  + ', Database: ' + document.forms['".$this->FormName."'].elements['form[db_hosting_prefix]'].value + document.forms['".$this->FormName."'].elements['form[dbprefix]'].value ; li.insertValue ( tmp_cnx_chaine , '".$this->FormName."', [ 'form[chaine_connexion_test]']  );";
		$SB['message']			= "Test DB";
		$SB['mode']				= 1;
		$SB['size'] 			= 128;
		$SB['lastSize']			= 128;
		
		$pv['div_cnx_db'] = "
			<input type='text' readonly disable name='form[chaine_connexion_test]' size='40' maxlength='255' value=''><br>\r";
		
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('DB_tstcnx');
		// $T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = $bts->InteractiveElementsObj->renderSubmitButton($SB);
		$T[$t][$l]['4']['cont'] = $pv['div_cnx_db'] . "
			<div id='cnxToDBok'				style='font-size:80%; visibilty:hidden; display:none; position:realtive;'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ok')													. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('DB_tstcnxAok')."</div>
			<div id='cnxToDBko'				style='font-size:80%; visibilty:hidden; display:none; position:realtive;'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_nok')													. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('DB_tstcnxAko')."</div>
			<div id='HydrDBAlreadyExistok'	style='font-size:80%; visibilty:hidden; display:none; position:realtive;' class='".$Block._CLASS_TXT_WARNING_."'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_notification')	. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('DB_tstcnxBok')."</div>
			<div id='HydrDBAlreadyExistko'	style='font-size:80%; visibilty:hidden; display:none; position:realtive;'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_nok')													. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('DB_tstcnxBko')."</div>
			";
		
		$SrvUri = $_SERVER['REQUEST_URI'];
		$uriCut = strpos( $_SERVER['REQUEST_URI'] , "/Hydr/current/install/install_page_01.php" );
		$SrvUri = substr ( $_SERVER['REQUEST_URI'] , 0 , $uriCut );
		
		$GeneratedScriptObj->insertString('JavaScript-Data' , "var RequestURI = \"". $SrvUri . "\"");
		$GeneratedScriptObj->insertString('JavaScript-Data' , "var FormName = \"".$this->FormName."\"");
		$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\tli.selectMenuBuilder ( 'form[database_type_choix]' , listOfDBSupport['PHP'] );" );

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig($l,4,1);
	}

	/**
	 * installationMethod
	 */
	private function installationMethod($infos, $t) {
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();

		$T = &$this->T['Content'];

		$bubbleBegin = "<img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_question') . "' width='24' height='24' border='0' onMouseOver=\"t.ToolTip('";
		$bubbleEnd = "', 'install')\" onMouseOut=\"t.ToolTip('','install')\">";
		$l=1;
		$T[$t]['caption']['cont'] = $bts->I18nTransObj->getI18nTransEntry('F2_intro');
		$T[$t][$l]['1']['cont'] = "<input type='radio' name='form[operating_mode]' onClick='li.setFormPreconizedSettings()' value='directCnx' checked>".$bts->I18nTransObj->getI18nTransEntry('F2_m1o1').$bubbleBegin.$bts->I18nTransObj->getI18nTransEntry('F2_txt_aide1').$bubbleEnd;
		$T[$t][$l]['2']['cont'] = "<input type='radio' name='form[operating_mode]' onClick='li.setFormPreconizedSettings()' value='createScript'>".$bts->I18nTransObj->getI18nTransEntry('F2_m1o2').$bubbleBegin.$bts->I18nTransObj->getI18nTransEntry('F2_txt_aide2').$bubbleEnd;

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig($l,2,0);

	}

	/**
	 * siteSelection
	 */
	private function siteSelection($infos, $t) {
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		$GeneratedScriptObj = $CurrentSetObj->getInstanceOfGeneratedScriptObj ();
		$Content ="";

		$T = &$this->T['Content'];
		
		$l = 1;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l'.$l.'c3');

		$i = 0;
		$directory_list = array();
		$handle = opendir("websites-data/");
		while (false !== ($file = readdir($handle))) {
			if ( $file != "." && $file != ".." && !is_file("../websites-data/".$file)  ) { $directory_list[$i] = $file; }
			$i++;
		}
		$i = 2;
		closedir($handle);
		sort ($directory_list);
		reset ($directory_list);

		$listDirectoriCheckbox = array();
		foreach ( $directory_list as $a ) {
			if ( $a == "00_Hydre" ) {
				$T[$t][$i]['1']['cont'] = "<span style='font-style:italic'>".$a."</span>\r";
				$T[$t][$i]['2']['cont'] = "<input type='checkbox' name='directory_list[".$a."][plouf]' disabled checked >";
				$T[$t][$i]['3']['cont'] = "<input type='checkbox' name='directory_list[".$a."][plouf2]' disabled checked >\r
				<input type='hidden' name='directory_list[".$a."][name]' value='".$a."'>\r
				<input type='hidden' name='directory_list[".$a."][state]' value='on'>\r";
			}
			else {
				$T[$t][$i]['1']['cont'] = $a." <input type='hidden' name='directory_list[".$a."][name]' value='".$a."'>\r";
				$T[$t][$i]['2']['cont'] = "<input type='checkbox' name='directory_list[".$a."][state]' checked onClick='li.setFormPreconizedSettings()'>\r";
				
				$listDirectoriCheckbox[] = "directory_list[".$a."][state]";
				
				$T[$t][$i]['3']['cont'] = "<input type='checkbox' name='directory_list[".$a."][code_verification]' checked>\r";
			}
			$i++;
		}
		$T['ContentCfg']['tabs'][$t]['NbrOfLines'] = ( $i - 1 );

		$str = "var ListCheckbox = [\r";
		foreach ( $listDirectoriCheckbox as $A ) { $str .= "\"".$A."\", \r"; }
		$str = substr($str, 0,-3) . "\r];\r";
		$GeneratedScriptObj->insertString('JavaScript-Data' , $str);
		$GeneratedScriptObj->insertString('JavaScript-OnLoad' , "\tli.setFormPreconizedSettings();");

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig(($i-1),3,1);

	}

	/**
	 * personalization
	 */
	private function personalization($infos, $t){
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		$GeneratedScriptObj = $CurrentSetObj->getInstanceOfGeneratedScriptObj ();
		$Content ="";
		
		$T = &$this->T['Content'];
		$lang = $CurrentSetObj->getDataEntry ('language');

        $l=1;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c3');
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4');
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "<input type='text' name='form[tabprefix]' size='10' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('tabprefix')."' OnKeyup=\"li.insertValue ( 'Ex: ' + this.value + 'article_config' , '".$this->FormName."', ['form[db_hosting_tabprefix_copie_1]'] );\">";
		$T[$t][$l]['3']['cont'] = "<input type='text' readonly disable name='form[db_hosting_tabprefix_copie_1]' size='20' maxlength='255' value=''>";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4')."</span>";
		$GeneratedScriptObj->insertString('JavaScript-Onload' , "li.insertValue ( 'Ex: ".$bts->CMObj->getConfigurationEntry('tabprefix')."article_config' , '".$this->FormName."', ['form[db_hosting_tabprefix_copie_1]' , 'form[db_hosting_tabprefix_copie_1]' ] );");
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_3]' size='10' maxlength='255' value=''>";
		$T[$t][$l]['3']['cont'] = "<input type='text' name='form[database_user_login]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('db_user_login')."'>";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4')."</span>";
		$l++;

		$SB['id']				= "bouton_install_radompass";
		$SB['type']				= "button";
		$SB['initialStyle']		= $Block."_submit_s1_n";
		$SB['hoverStyle']		= $Block."_submit_s1_h";
		$SB['onclick']			= "elm.SetFormInputValue ( '".$this->FormName."' , 'form[database_user_password]' , li.createRandomPassword( 20 ) );";
		$SB['message']			= $bts->I18nTransObj->getI18nTransEntry('boutonpass');
		$SB['mode']				= 1;
		$SB['size'] 			= 128;
		$SB['lastSize']			= 128;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<input type='password' id='form[database_user_password]' name='form[database_user_password]' size='20' maxlength='32' value='"
		.$bts->CMObj->getConfigurationEntry('db_user_password')."'>\r<br>\r"
		."<span style='font-size:75%;' onmousedown=\"elm.Gebi('form[database_user_password]').type = 'text';\" onmouseup=\"elm.Gebi('form[database_user_password]').type = 'password';\">"
		.$bts->I18nTransObj->getI18nTransEntry('unveilPassword')
		."</span>";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4')."</span>\r<br>\r<br>\r". $bts->InteractiveElementsObj->renderSubmitButton($SB);
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<select name='form[database_user_recreate]'>\r
		<option value='non'>".$bts->I18nTransObj->getI18nTransEntry('dbr_n')."</option>\r
		<option value='oui' selected >".$bts->I18nTransObj->getI18nTransEntry('dbr_o')."</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4')."</span>";
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<input type='password' name='form[standard_user_password]' id='form[standard_user_password]'size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('db_user_password')."'><br>"
		."<span style='font-size:75%;' onmousedown=\"elm.Gebi('form[standard_user_password]').type = 'text';\" onmouseup=\"elm.Gebi('form[standard_user_password]').type = 'password';\">"
		.$bts->I18nTransObj->getI18nTransEntry('unveilPassword')
		."</span>";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4')."</span>";
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<select name='form[creation_htaccess]'>\r
		<option value='non' selected>".$bts->I18nTransObj->getI18nTransEntry('dbr_n')."</option>\r
		<option value='oui'>".$bts->I18nTransObj->getI18nTransEntry('dbr_o')."</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4')."</span>";
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<select name='form[TypeExec]'>\r
		<option value='ModuleApache' selected>".$bts->I18nTransObj->getI18nTransEntry('TypeExec1')."</option>\r
		<option value='CLI'>".$bts->I18nTransObj->getI18nTransEntry('TypeExec2')."</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = "<span style='font-size:80%;'>".$bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4')."</span>";

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig($l,4,1);
	}

	/**
	 * logConfig
	 */
	private function logConfig($infos, $t){
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();

		$T = &$this->T['Content'];

		$l=1;
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l'.$l.'c3');
		$l++;
		
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "<input type='checkbox' name='form[db_detail_log_warn]'>" . $bts->I18nTransObj->getI18nTransEntry('t6l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<input type='checkbox' name='form[db_detail_log_err]' checked>" . $bts->I18nTransObj->getI18nTransEntry('t6l'.$l.'c3');
		$l++;
		
		
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "<input type='checkbox' name='form[console_detail_log_warn]' checked>" . $bts->I18nTransObj->getI18nTransEntry('t6l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<input type='checkbox' name='form[console_detail_log_err]' checked>" . $bts->I18nTransObj->getI18nTransEntry('t6l'.$l.'c3');
		
		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig($l,3,1);

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
	private function detectionPEARSupport ($infos) {
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		$Content ="<b>".$bts->I18nTransObj->getI18nTransEntry('PHP_pear_support')."</b><br>";

		$pearSupportedDB = array(
			'mysql' =>			array('name' => 'mysql',			'section' => 'ADO_MYSQL',	'title' => 'mysql'),
			'sqlite' =>			array('name' => 'sqlite',			'section' => 'ADO_SQLITE',	'title' => 'SQLite'),
		);
		
		$B = "";
		if ( file_exists ("/usr/bin/pear list") ) {
			if ( function_exists( 'exec' ) ) {
				$pv['exec_state'] = 1;
				exec ( "/usr/bin/pear list" , $PEAR , $pv['exec_state'] );
				if ( $pv['exec_state'] == 0 ) {
					foreach ( $PEAR as $A ) {
						if ( strpos ( $A , "MDB2_Driver_mysql" ) !== FALSE ) { $B .= $A;	$pearSupportedDB['mysql']['enabled'] = true;	$this->pearSupportEnabled = true;}
						if ( strpos ( $A , "MDB2_Driver_sqlite" ) !== FALSE  ) { $B .= $A; 	$pearSupportedDB['sqlite']['enabled'] = true;	$this->pearSupportEnabled = true;}
					}
				}
				if ( $this->pearSupportEnabled == true ) {
					$this->pearJavascriptObj = "\t'PEAR' :  {\r";
					foreach ( $pearSupportedDB as $A ) {
						if ( $A['enabled'] == true ) {
							$this->pearJavascriptObj .= "\t\t'".$A['name']."' : { v:'".$A['name']."',	't':'".$A['title']."'}, \r";
						}
					}
					$this->pearJavascriptObj .= substr ( $this->pearJavascriptObj , 0 , -2 ) ."\r\t},\r";
				}
			}
			$Content .= $infos['iconGoNoGoOk']."<span style='vertical-align:super;'>PEAR ".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok').". </span><br>\r";
		}
		else {
			$Content .= $infos['iconGoNoGoNok']."<span class='".$Block."_warning' style='vertical-align:super;'>PEAR ".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_nok').". </span><br>\r";
		}
		return $Content;
	}

	/**
	 * detectionADODBSupport
	 */
	private function detectionADODBSupport ($infos) {
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];


		$Content ="<b>".$bts->I18nTransObj->getI18nTransEntry('PHP_adodb_support')."</b><br>";
		if ( file_exists("/usr/share/php/adodb/adodb.inc.php") ) {
			include ("/usr/share/php/adodb/adodb.inc.php");
			$Content .= $infos['iconGoNoGoOk']."<span style='vertical-align:super;'>ADOdb ".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok')."(".$ADODB_vers."). </span><br>\r";

			$adoSupportedDB = array(
				'db2' =>			array('enabled' => true,	'name' => 'db2',			'section' => 'ADO_DB2',		'title' => 'IBM DB2'),
				'mssqlnative' =>	array('enabled' => true,	'name' => 'mssqlnative',	'section' => 'ADO_MSSQL',	'title' => 'Microsoft SQL server'),
				'mysql' =>			array('enabled' => true,	'name' => 'mysql',			'section' => 'ADO_MYSQL',	'title' => 'mysql'),
				'oci8' =>			array('enabled' => true,	'name' => 'oci8',			'section' => 'ADO_OCI8',	'title' => 'Oracle'),
				'pgsql' =>			array('enabled' => true,	'name' => 'pqsql',			'section' => 'ADO_PGSQL',	'title' => 'PostgreSQL'),
				'sqlite' =>			array('enabled' => true,	'name' => 'sqlite',			'section' => 'ADO_SQLITE',	'title' => 'SQLite'),
			);
			$this->adoJavascriptObj = "\t'ADODB' :  {\r";
			foreach ( $adoSupportedDB as $A ) {
				if ( $A['enabled'] == true ) {
					$this->adoJavascriptObj .= "\t\t'".$A['name']."' : { v:'".$A['name']."',	't':'".$A['title']."'}, \r";
				}
			}
			$this->adoJavascriptObj = substr ( $this->adoJavascriptObj , 0 , -3 ) ."\r\t},\r";
			$this->adoSupportEnabled = true;
		}
		else {
			$Content .= $infos['iconGoNoGoNok']."<span class='".$Block."_warning' style='vertical-align:super;'>ADOdb ".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_nok').". </span><br>\r";
		}
		return ($Content);
	}

	/**
	 * detectionPDOSupport
	 */
	private function detectionPDOSupport($infos){
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		$Content ="<b>".$bts->I18nTransObj->getI18nTransEntry('PHP_pdo_support')."</b><br>";


		if ( extension_loaded('pdo') == true ) {
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
			foreach ( $pdoAvailableDrivers as $A ) { $pdoSupportedDB[$A]['enabled'] = true; }
	
			$strStartOk = $infos['iconGoNoGoOk'] . "<span style='vertical-align:super;'>";
			$strEndOk = " ".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok').". </span><br>\r";
	
			foreach ($pdoSupportedDB as $A ) {
				if ($A['enabled'] == 1 ) {	
					$Content .= $strStartOk.$A['title'].$strEndOk;
					$this->pdoSupportEnabled = true;
					$this->availableSupport['DAL']['PDO']['state'] = 1;
					$this->availableSupport['DAL'][$A['section']]['state'] = 1;
				}
			}
			if ( $this->pdoSupportEnabled == true ) {
				$this->pdoJavascriptObj = "\t'PDO' :  {\r";
				foreach ( $pdoSupportedDB as $A ) {
					if ( $A['enabled'] == true ) {
						$this->pdoJavascriptObj .= "\t\t'".$A['name']."' : { v:'".$A['name']."',	't':'".$A['title']."'}, \r";
					}
				}
				$this->pdoJavascriptObj = substr ( $this->pdoJavascriptObj , 0 , -3 ) ."\r\t},\r";
			}
		}	
		return ($Content);
	}

	/**
	 * detectionPHPbuiltinSupport
	 */
	private function detectionPHPbuiltinSupport ($infos) {
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		$Content ="<b>".$bts->I18nTransObj->getI18nTransEntry('PHP_db_builtin_functions')."</b><br>";

		// https://www.php.net/manual/fr/refs.database.php

		$phpSupportedDB = array( 
			'PHP_cubrid_builtin'		=> array( 'name' => 'cubrid',			'f' => 'cubrid_connect',		'title' => 'Cubrid'				),
			'PHP_dbase_builtin'			=> array( 'name' => 'dbase',			'f' => 'dbase_open',			'title' => 'DBase'				),
			'PHP_ibase_builtin'			=> array( 'name' => 'firebird',			'f' => 'ibase_connect',			'title' => 'Firebird/InterBase'	),
			'PHP_db2_builtin'			=> array( 'name' => 'db2',				'f' => 'db2_connect',			'title' => 'IBM DB2'			),
			'PHP_mysqli_builtin'		=> array( 'name' => 'mysqli',			'f' => 'mysqli_connect',		'title' => 'MySQLi'				),
			'PHP_oci_builtin'			=> array( 'name' => 'oci8',				'f' => 'oci_connect',			'title' => 'OCI8'				),
			'PHP_postgresql_builtin'	=> array( 'name' => 'pgsql',			'f' => 'pg_connect',			'title' => 'PostgreSQL'			),
			'PHP_sqlite_builtin'		=> array( 'name' => 'sqlite',			'f' => 'sqlite_open',			'title' => 'SQLite'				),
			'PHP_sqlsrv_builtin'		=> array( 'name' => 'sqlsrv',			'f' => 'sqlsrv_connect',		'title' => 'SQLSRV'				),
		);

		foreach ( $phpSupportedDB as &$A ) {
			if ( function_exists($A['f']) == true ) {
				$A['enabled'] = 1;
				$this->phpSupportEnabled = true;
				$Content .= $infos['iconGoNoGoOk'] . "<span style='vertical-align:super;'>" . $A['name']  ." ".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok').".</span> ";
			}
		}
		$Content .="<br>\r";

		if ( $this->phpSupportEnabled == true ) {
			$this->phpJavascriptObj = "\t'PHP' :  {\r";
			foreach ( $phpSupportedDB as $A ) {
				if ( $A['enabled'] == true ) {
					$this->phpJavascriptObj .= "\t\t'".$A['name']."' : { v:'".$A['name']."',	't':'".$A['title']."'}, \r";
				}
			}
			$this->phpJavascriptObj = substr ( $this->phpJavascriptObj , 0 , -3 ) ."\r\t},\r";
		}
	
		return ($Content);
	}
}

?>
