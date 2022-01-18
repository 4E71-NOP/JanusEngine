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
	private $availableSupport = array( 
		'DAL' => array(),
		'PHP' => array(
			'PHP_cubrid_builtin'		=> array( 'state' => 0,		'f' => 'cubrid_connect',		'name' => 'CUBRID'				),
			'PHP_dbplus_builtin'		=> array( 'state' => 0,		'f' => 'dbplus_open',			'name' => 'DB++'				),
			'PHP_dbase_builtin'			=> array( 'state' => 0,		'f' => 'dbase_open',			'name' => 'DBase'				),
			'PHP_filepro_builtin'		=> array( 'state' => 0,		'f' => 'filepro',				'name' => 'FilePro'				),
			'PHP_ibase_builtin'			=> array( 'state' => 0,		'f' => 'ibase_connect',			'name' => 'Firebird/InterBase'	),
			'PHP_frontbase_builtin'		=> array( 'state' => 0,		'f' => 'fbsql_connect',			'name' => 'FrontBase'			),
			'PHP_db2_builtin'			=> array( 'state' => 0,		'f' => 'db2_connect',			'name' => 'IBM DB2'				),
			'PHP_ifx_builtin'			=> array( 'state' => 0,		'f' => 'ifx_connect',			'name' => 'Informix'			),
			'PHP_ingress_builtin'		=> array( 'state' => 0,		'f' => 'ingres_connect',		'name' => 'Ingress'				),
			'PHP_maxdb_builtin'			=> array( 'state' => 0,		'f' => 'maxdb_connect',			'name' => 'MaxDB'				),
			'PHP_msql_builtin'			=> array( 'state' => 0,		'f' => 'msql_connect',			'name' => 'mSQL'				),
			'PHP_mssql_builtin'			=> array( 'state' => 0,		'f' => 'mssql_connect',			'name' => 'Mssql'				),
			'PHP_mysql_builtin'			=> array( 'state' => 0,		'f' => 'mysql_connect',			'name' => 'MySQL'				),
			'PHP_mysqli_builtin'		=> array( 'state' => 0,		'f' => 'mysqli_connect',		'name' => 'MySQLi'				),
			'PHP_oci_builtin'			=> array( 'state' => 0,		'f' => 'oci_connect',			'name' => 'OCI8'				),
			'PHP_px_builtin'			=> array( 'state' => 0,		'f' => 'px_open_fp',			'name' => 'Paradox'				),
			'PHP_postgresql_builtin'	=> array( 'state' => 0,		'f' => 'pg_connect',			'name' => 'PostgreSQL'			),
			'PHP_sqlite_builtin'		=> array( 'state' => 0,		'f' => 'sqlite_open',			'name' => 'SQLite'				),
			'PHP_sqlsrv_builtin'		=> array( 'state' => 0,		'f' => 'sqlsrv_connect',		'name' => 'SQLSRV'				),
			'PHP_sybase_builtin'		=> array( 'state' => 0,		'f' => 'sybase_connect',		'name' => 'Sybase'				),
		)
	);

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
		$infos['iconGoNoGoOk'] = "<img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ok') .	"' width='24' height='24' border='0'>";
		$infos['iconGoNoGoNok'] = "<img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_notification').	"' width='24' height='24' border='0'>";
		
		$this->T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15, 6);

		$this->serverInfos($infos, 1);
		$this->installationMethod($infos, 2);
		$this->siteSelection($infos, 3);
		$this->databaseAccess($infos, 4);
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
		
		$SessionID = floor ( $bts->TimeObj->microtime_chrono() );
		
		$SB = array();
		$SB['id']				= "bouton_install_p1";
		$SB['type']				= "button";
		$SB['initialStyle']		= $Block."_submit_s2_n";
		$SB['hoverStyle']		= $Block."_submit_s3_h";
		$SB['onclick']			= "CheckFormValues( ListeChamps , '".$CurrentSetObj->getDataEntry ('language')."' , '".$SessionID."')";
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

		$DBsupport = $this->detectionPEARSupport($infos) . $this->detectionADODBSupport($infos) . $this->detectionPDOSupport($infos) . $this->detectionPHPbuiltinSupport($infos);

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
		$T[$t][$l]['1']['cont'] = "<input type='radio' name='form[operating_mode]' onClick='setFormPreconizedSettings()' value='directCnx' checked>".$bts->I18nTransObj->getI18nTransEntry('F2_m1o1').$bubbleBegin.$bts->I18nTransObj->getI18nTransEntry('F2_txt_aide1').$bubbleEnd;
		$T[$t][$l]['2']['cont'] = "<input type='radio' name='form[operating_mode]' onClick='setFormPreconizedSettings()' value='createScript'>".$bts->I18nTransObj->getI18nTransEntry('F2_m1o2').$bubbleBegin.$bts->I18nTransObj->getI18nTransEntry('F2_txt_aide2').$bubbleEnd;

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
				$T[$t][$i]['2']['cont'] = "<input type='checkbox' name='directory_list[".$a."][state]' checked onClick='setFormPreconizedSettings()'>\r";
				
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
		$GeneratedScriptObj->insertString('JavaScript-OnLoad' , "\tsetFormPreconizedSettings();");

		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig(($i-1),3,1);

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
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c3');
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c4');
		$l++;
		
		unset ($tab_);
		$tab_[$bts->CMObj->getConfigurationEntry('dal')] = " selected ";
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<select id='form[dal]' name='form[dal]' onChange=\"SelectMenuBuilder ( 'form[dal]' , 'form[database_type_choix]' , DBvsDALCompatility[this.value] );\">\r";
		
		if ( $this->availableSupport['PHP']['PHP_mysqli_builtin']['state'] == 1 )	{ $T[$t][$l]['3']['cont'] .= "<option value='MYSQLI'	".$tab_['MYSQLI'].">".	$bts->I18nTransObj->getI18nTransEntry('msdal_msqli')."</option>\r"; }
		if ( $this->availableSupport['DAL']['ADOdb']['state'] == 1 )				{ $T[$t][$l]['3']['cont'] .= "<option value='ADODB'		".$tab_['ADODB'].">".	$bts->I18nTransObj->getI18nTransEntry('msdal_adodb')."</option>\r"; }
		if ( $this->availableSupport['DAL']['PDO']['state'] == 1 )					{ $T[$t][$l]['3']['cont'] .= "<option value='PHPPDO'	".$tab_['PDO'].">".		$bts->I18nTransObj->getI18nTransEntry('msdal_phppdo')."</option>\r"; }
		if ( $this->availableSupport['DAL']['pear']['state'] == 1 )					{ $T[$t][$l]['3']['cont'] .= "<option value='PEARDB'	".$tab_['PEARDB'].">".	$bts->I18nTransObj->getI18nTransEntry('msdal_pear')."</option>\r"; }
		
		$T[$t][$l]['3']['cont'] .= "</select>\r";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c4');
		$l++;
		
		// DB Type selection
		unset ($tab_);
		$tab_[$bts->CMObj->getConfigurationEntry('type')] = " selected ";
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<select id='form[database_type_choix]' name='form[database_type_choix]'>\r
		<option value='mysql'	".$tab_['mysql'].">MySQL 3.x/4.x/5.x</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c4');
		$l++;
		
		// Hosting plan
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		
		$T[$t][$l]['3']['cont'] = "<select name='form[database_profil]'>\r
		<option value='absolute'>".$bts->I18nTransObj->getI18nTransEntry('dbp_asolute')."</option>\r
		<option value='hostplan'>".$bts->I18nTransObj->getI18nTransEntry('dbp_hosted')."</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c4');
		$l++;
		
		// DB Server
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<input type='text' name='form[host]' size='20' maxlength='255' value='".$bts->CMObj->getConfigurationEntry('host')."'>";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c4');
		$l++;
		
		// Prefix
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "<input type='text' name='form[db_hosting_prefix]' size='10' maxlength='255' value='".$bts->CMObj->getConfigurationEntry('db_hosting_prefix')."' OnKeyup=\"InsertValue ( this.value , '".$this->FormName."', ['form[db_hosting_prefix_copie_1]', 'form[db_hosting_prefix_copie_2]', 'form[db_hosting_prefix_copie_3]' ] );\">";
		$T[$t][$l]['3']['cont'] = "";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c4');
		$l++;
		
		// DB name
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_1]' size='10' maxlength='255' value=''>";
		$T[$t][$l]['3']['cont'] = "<input type='text' name='form[dbprefix]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('dbprefix')."'>";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c4');
		$l++;
		
		// Login
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_2]' size='10' maxlength='255' value=''>";
		$T[$t][$l]['3']['cont'] = "<input type='text' name='form[db_admin_user]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('admin_user')."'>";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c4');
		$l++;
		
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<input type='password' name='form[db_admin_password]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('admin_password')."'>";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c4');
		$l++;
		
		
		$SB['id']				= "bouton_install_testdb";
		$SB['type']				= "button";
		$SB['initialStyle']		= $Block."_submit_s1_n";
		$SB['hoverStyle']		= $Block."_submit_s1_h";
		$SB['onclick']			= "toggleDiv ('cnxToDB', false ); toggleDiv ('HydrDBAlreadyExist', false ); test_cnx_db(); var tmp_cnx_chaine = document.forms['".$this->FormName."'].elements['form[db_hosting_prefix]'].value + document.forms['".$this->FormName."'].elements['form[db_admin_user]'].value + '@' + document.forms['".$this->FormName."'].elements['form[host]'].value  + ', Database: ' + document.forms['".$this->FormName."'].elements['form[db_hosting_prefix]'].value + document.forms['".$this->FormName."'].elements['form[dbprefix]'].value ; InsertValue ( tmp_cnx_chaine , '".$this->FormName."', [ 'form[chaine_connexion_test]']  );";
		$SB['message']			= "Test DB";
		$SB['mode']				= 1;
		$SB['size'] 			= 128;
		$SB['lastSize']			= 128;
		
		$pv['div_cnx_db'] = "
			<input type='text' readonly disable name='form[chaine_connexion_test]' size='40' maxlength='255' value=''><br>\r";
		
		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = $bts->InteractiveElementsObj->renderSubmitButton($SB);
		$T[$t][$l]['4']['cont'] = $pv['div_cnx_db'] . "
			<div id='cnxToDBok'				style='visibilty: hidden; display : none; position: realtive;'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ok')														. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('t4l10c4aok')."</div>
			<div id='cnxToDBko'				style='visibilty: hidden; display : none; position: realtive;'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_nok')														. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('t4l10c4ako')."</div>
			<div id='HydrDBAlreadyExistok'	style='visibilty: hidden; display : none; position: realtive;' class='".$Block._CLASS_TXT_WARNING_."'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_notification')	. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('t4l10c4bok')."</div>
			<div id='HydrDBAlreadyExistko'	style='visibilty: hidden; display : none; position: realtive;'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_nok')														. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('t4l10c4bko')."</div>
			";
		
		$SrvUri = $_SERVER['REQUEST_URI'];
		$uriCut = strpos( $_SERVER['REQUEST_URI'] , "/Hydr/current/install/install_page_01.php" );
		$SrvUri = substr ( $_SERVER['REQUEST_URI'] , 0 , $uriCut );
		
		$GeneratedScriptObj->insertString('JavaScript-Data' , "var RequestURI = \"". $SrvUri . "\"");
		$GeneratedScriptObj->insertString('JavaScript-Data' , "var FormName = \"".$this->FormName."\"");
		
		$this->T['ContentCfg']['tabs'][$t] = $bts->RenderTablesObj->getDefaultTableConfig($l,4,1);
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
		$T[$t][$l]['2']['cont'] = "<input type='text' name='form[tabprefix]' size='10' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('tabprefix')."' OnKeyup=\"InsertValue ( 'Ex: ' + this.value + 'article_config' , '".$this->FormName."', ['form[db_hosting_tabprefix_copie_1]'] );\">";
		$T[$t][$l]['3']['cont'] = "<input type='text' readonly disable name='form[db_hosting_tabprefix_copie_1]' size='20' maxlength='255' value=''>";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4');
		$GeneratedScriptObj->insertString('JavaScript-Command' , "InsertValue ( 'Ex: ".$bts->CMObj->getConfigurationEntry('tabprefix')."article_config' , '".$this->FormName."', ['form[db_hosting_tabprefix_copie_1]' , 'form[db_hosting_tabprefix_copie_1]' ] );");
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_3]' size='10' maxlength='255' value=''>";
		$T[$t][$l]['3']['cont'] = "<input type='text' name='form[database_user_login]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('db_user_login')."'>";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4');
		$l++;

		$SB['id']				= "bouton_install_radompass";
		$SB['type']				= "button";
		$SB['initialStyle']		= $Block."_submit_s1_n";
		$SB['hoverStyle']		= $Block."_submit_s1_h";
		$SB['onclick']			= "elm.SetFormInputValue ( '".$this->FormName."' , 'form[database_user_password]' , CreateRandomPassword( 20 ) );";
		$SB['message']			= $bts->I18nTransObj->getI18nTransEntry('boutonpass');
		$SB['mode']				= 1;
		$SB['size'] 			= 128;
		$SB['lastSize']			= 128;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<input type='password' id='form[database_user_password]' name='form[database_user_password]' size='20' maxlength='32' value='"
		.$bts->CMObj->getConfigurationEntry('db_user_password')."'>\r<br>\r"
		."<span style='font-size:75%;' onmousedown=\"elm.Gebi('form[database_user_password]').type = 'text';\" onmouseup=\"elm.Gebi('form[database_user_password]').type = 'password';\">"
		.$bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c3')
		."</span>"
		;
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4') . "<br><br>". $bts->InteractiveElementsObj->renderSubmitButton($SB);
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<select name='form[database_user_recreate]'>\r
		<option value='non'>".$bts->I18nTransObj->getI18nTransEntry('dbr_n')."</option>\r
		<option value='oui' selected >".$bts->I18nTransObj->getI18nTransEntry('dbr_o')."</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4');
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<input type='password' name='form[standard_user_password]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('db_user_password')."'>";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4');
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<select name='form[creation_htaccess]'>\r
		<option value='non' selected>".$bts->I18nTransObj->getI18nTransEntry('dbr_n')."</option>\r
		<option value='oui'>".$bts->I18nTransObj->getI18nTransEntry('dbr_o')."</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4');
		$l++;

		$T[$t][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c1');
		$T[$t][$l]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c2');
		$T[$t][$l]['3']['cont'] = "<select name='form[TypeExec]'>\r
		<option value='ModuleApache' selected>".$bts->I18nTransObj->getI18nTransEntry('TypeExec1')."</option>\r
		<option value='CLI'>".$bts->I18nTransObj->getI18nTransEntry('TypeExec2')."</option>\r
		</select>\r
		";
		$T[$t][$l]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$l.'c4');

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
		$Content ="";

		$B = "";
		if ( file_exists ("/usr/bin/pear list") ) {
			if ( function_exists( 'exec' ) ) {
				$pv['exec_state'] = 1;
				exec ( "/usr/bin/pear list" , $PEAR , $pv['exec_state'] );
				if ( $pv['exec_state'] == 0 ) {
					foreach ( $PEAR as $A ) {
						if ( strpos ( $A , "MDB2_Driver_mysql" ) !== FALSE ) { $B .= $A; }
						if ( strpos ( $A , "MDB2_Driver_sqlite" ) !== FALSE  ) { $B .= $A; }
					}
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
		$Content ="";
		if ( file_exists("/usr/share/php/adodb/adodb.inc.php") ) {
			include ("/usr/share/php/adodb/adodb.inc.php");
			$Content .= $infos['iconGoNoGoOk']."<span style='vertical-align:super;'>ADOdb ".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok')."(".$ADODB_vers."). </span><br>\r";
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
		$Content ="";
		if (defined('PDO::MYSQL_ATTR_LOCAL_INFILE')) {
			$Content .= $infos['iconGoNoGoOk'] . "<span style='vertical-align:super;'>PDO/MySQL " . $bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok').". </span><br>\r";
			$this->availableSupport['DAL']['PDO']['state'] = 1;
		}
		else {
			$Content.= $infos['iconGoNoGoNok'] . "<span class='".$Block."_warning' style='vertical-align:super;'>PDO/MySQL".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_nok').". </span><br>\r";
			$this->availableSupport['DAL']['PDO']['state'] = 0;
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
		$Content = $bts->I18nTransObj->getI18nTransEntry('PHP_support_titre');

		foreach ( $this->availableSupport['PHP'] as &$A ) {
			if ( function_exists( $A['f'] ) ) {
				$A['state'] = 1;
				$Content .= $infos['iconGoNoGoOk'] . "<span style='vertical-align:super;'>" . $A['name']  ." ".$bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok').".</span> ";
			}
		}
		return ($Content);
	}

}

?>
