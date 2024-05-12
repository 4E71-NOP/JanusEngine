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
/* $CMObj ConfigurationManagement              */
/* $LMObj LogManagement                        */
/* $MapperObj Mapper                           */
/* $InteractiveElementsObj InteractiveElements */
/* $RenderTablesObj RenderTables               */
/* $RequestDataObj RequestData                 */
/* $SDDMObj DalFacade                          */
/* $StringFormatObj StringFormat               */

/*Hydre-IDE-end*/

/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $bts BaseToolSet                            */
/* @var $CurrentSetObj CurrentSet                   */
/* @var $ClassLoaderObj ClassLoader                 */

/* @var $SqlTableListObj SqlTableList               */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */

/* @var $Content String                             */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

// --------------------------------------------------------------------------------------------
//		Installation page 02
// --------------------------------------------------------------------------------------------
class InstallPage03 {
	private static $Instance = null;
	private $T = array();
	private $form = array();
	private $createScript= array();
	private $errorRaised = false;
	private $installationStartTime = 0;
	private $tabConfigFile = array();

	public function __construct() {
		$this->installationStartTime = time();
	}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return InstallPage03
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new InstallPage03 ();
		}
		return self::$Instance;
	}

	/**
	 * Renders the page 02 content
	 */
	public function render($infos) {
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		$Content = "";

		$langFile = $infos['module']['module_directory']."i18n/".$CurrentSetObj->getDataEntry ('language').".php";
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $langFile , "format" => "php" ));

		$this->initSDDM();

		$ClassLoaderObj = ClassLoader::getInstance ();
		$ClassLoaderObj->provisionClass('LibInstallation');
		$LibInstallationObj = LibInstallation::getInstance();
		$t = time();
		$LibInstallationObj->setReport(array(
			"lastReportExecution"=> $t,
			"lastReportExecutionSaved"=> $t,
		));
		
		// --------------------------------------------------------------------------------------------
		if ( $this->checkInstallToken() == true ) {
			$CurrentTab = 1;
			$lt = 1;
			$ClassLoaderObj->provisionClass('LibInstallationReport');
			$LibInstallationReportObj = LibInstallationReport::getInstance();
	
			$style1 = array (
				"block" => $Block,
				"titles" => array(
					$bts->I18nTransObj->getI18nTransEntry('t1c1'),	
					$bts->I18nTransObj->getI18nTransEntry('t1c2'),	
					$bts->I18nTransObj->getI18nTransEntry('t1c3'),
					$bts->I18nTransObj->getI18nTransEntry('t1c4'),
					$bts->I18nTransObj->getI18nTransEntry('t1c5'),
					$bts->I18nTransObj->getI18nTransEntry('t1c6'),
					$bts->I18nTransObj->getI18nTransEntry('t1c7'),
				),
				"cols" => array( 'file', 'OK', 'WARN', 'ERR'),
			);
			$style2 = array (
				"block" => $Block,
				"tc"=>1,
				"titles" => array($bts->I18nTransObj->getI18nTransEntry('t9c1'),	$bts->I18nTransObj->getI18nTransEntry('t9c2'),	$bts->I18nTransObj->getI18nTransEntry('t9c3'),	$bts->I18nTransObj->getI18nTransEntry('t9c4'),	$bts->I18nTransObj->getI18nTransEntry('t9c5'),	),
				"cols" => array('temps_debut', 'nbr', 'nom', 'signal', 'err_no', 'err_msg', 'temps_fin'),
			);
			
			// --------------------------------------------------------------------------------------------
			$this->T['ContentCfg']['tabs'] = array();
			
			// --------------------------------------------------------------------------------------------
			$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($LibInstallationReportObj->getInstallSectionLineCount('tables_creation')+2,7,1);
			$this->T['Content'][$CurrentTab] = $LibInstallationReportObj->renderReport( 'tables_creation'		, $style1 );
			$CurrentTab++;
			
			// --------------------------------------------------------------------------------------------
			$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($LibInstallationReportObj->getInstallSectionLineCount('tables_data')+2,7,1);
			$this->T['Content'][$CurrentTab] = $LibInstallationReportObj->renderReport( 'tables_data'			, $style1 );
			$CurrentTab++;
			
			// --------------------------------------------------------------------------------------------
			$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($LibInstallationReportObj->getInstallSectionLineCount('script')+2,7,1);
			$this->T['Content'][$CurrentTab] = $LibInstallationReportObj->renderReport( 'script'				, $style1 );
			$CurrentTab++;
			
			// --------------------------------------------------------------------------------------------
			$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($LibInstallationReportObj->getInstallSectionLineCount('tables_post_install')+2,7,1);
			$this->T['Content'][$CurrentTab] = $LibInstallationReportObj->renderReport( 'tables_post_install'	, $style1 );
			$CurrentTab++;
			
			// --------------------------------------------------------------------------------------------
			$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($LibInstallationReportObj->getInstallSectionLineCount('raw_sql')+2,7,1);
			$this->T['Content'][$CurrentTab] = $LibInstallationReportObj->renderReport( 'raw_sql'				, $style1 );
			$CurrentTab++;
			
			// --------------------------------------------------------------------------------------------
			$tmp = $LibInstallationReportObj->renderPerfomanceReport($infos);
			$this->T['Content'][$CurrentTab] = $tmp['content'];
			$this->T['ContentCfg']['tabs'] [$CurrentTab]= $tmp['config'];
			unset ($tmp);
			
			$CurrentTab++;
	
			$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
				$infos , 'button', 
				$bts->I18nTransObj->getI18nTransEntry('BtnSelect'), 128, 
				'SelectBtn', 
				1, 2, 
				""
			);
	
			$this->processFileRenderConfigFile();
			$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig(count($this->tabConfigFile)+1 ,4,6);
			$this->T['Content'][$CurrentTab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5c1');
			$Cl = 2;
			foreach ($this->tabConfigFile as $A ) {
				$SB['id']		=	"SelectBtn".$A['name'];
				$SB['onclick']	=	"elm.Gebi('txtConfig_".$A['name']."').select()";
				$this->T['Content'][$CurrentTab][$Cl]['1']['cont'] = 
						"
						<table style=' width:100%; border-spacing: 4px;'>\r
						<tr>\r
						<td colspan='2'>\rcurrent/config/current/site_".$A['name']."_config.php (for ".$A['name'].")</td>\r
						</tr>\r
			
						<tr>\r
						<td colspan='2'>\r
						<textarea id='txtConfig_".$A['name']."' cols='100' rows='10'>".$A['cont']."</textarea>
						</td>\r
						</tr>\r
			
						<tr>\r
						<td style='width:80%'>&nbsp;</td>\r
						<td>\r".$bts->InteractiveElementsObj->renderSubmitButton($SB)."</td>\r
						</tr>\r
						</table>\r
						"
						;
				$Cl++;
			}
			$ADC['tabs'][$CurrentTab]['NbrOfLines'] = $Cl-1;
			$CurrentTab++;
			
			
			// --------------------------------------------------------------------------------------------
			//
			//	Display
			//
			//
			// --------------------------------------------------------------------------------------------
			// $fontSizeRange = $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'txt_fonte_size_max') - $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'txt_fonte_size_min');
			
			$infos = array(
					"mode" => 1,
					"module_display_mode" => "normal",
					"module_z_index" => 2,
					"block" => "B02",
					"blockG" => "B02G",
					"blockT" => "B02T",
					"deco_type" => 50,
					"fontSizeMin" => 10,
					"fontCoef" => 2,
					"module" => Array (
							"module_id" => 11,
							"module_deco" => 1,
							"module_deco_nbr" => 2,
							"module_deco_default_text" => 3,
							"module_name" => "Admin_install_B1",
							"module_classname" => "",
							"module_title" => "",
							"module_file" => "",
							"module_desc" => "",
							"module_container_name" => "",
							"module_adm_control" => 0,
							"module_execution" => 0,
							"module_website_id" => 11,
							"ws_id" => 2,
							"module_state" => 1,
							"module_position" => 2,
							)
			);
			
			$this->T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 25, $CurrentTab-1);
			$this->T['ContentInfos']['tabTxt1']			= $bts->I18nTransObj->getI18nTransEntry('tab_1');
			$this->T['ContentInfos']['tabTxt2']			= $bts->I18nTransObj->getI18nTransEntry('tab_2');
			$this->T['ContentInfos']['tabTxt3']			= $bts->I18nTransObj->getI18nTransEntry('tab_3');
			$this->T['ContentInfos']['tabTxt4']			= $bts->I18nTransObj->getI18nTransEntry('tab_4');
			$this->T['ContentInfos']['tabTxt5']			= $bts->I18nTransObj->getI18nTransEntry('tab_5');
			$this->T['ContentInfos']['tabTxt6']			= $bts->I18nTransObj->getI18nTransEntry('tab_6');
			$this->T['ContentInfos']['tabTxt7']			= $bts->I18nTransObj->getI18nTransEntry('tab_7');
			$this->T['ContentInfos']['tabTxt8']			= $bts->I18nTransObj->getI18nTransEntry('tab_8');
			
			$Content .= $bts->RenderTablesObj->render($infos, $this->T);
		}
		else { 
			$Content .= $bts->I18nTransObj->getI18nTransEntry('REPORT_badToken')
			// ."<br>\r"
			// .$bts->StringFormatObj->print_r_html($_REQUEST)
			;
		}

		return ($Content);
	}


	/**
	 * Initialization SDDM
	 */
	private function initSDDM() {
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$CurrentSetObj = CurrentSet::getInstance();
		
		$this->form = $bts->RequestDataObj->getRequestDataEntry('form');
		$bts->CMObj->setConfigurationEntry('operatingMode', $this->form['operatingMode'] );

		// ***quality*** Revoir ce bout de tableau... n'a pas l'air de servir 
		$bts->CMObj->setConfigurationEntry('db',
			array(
				"dal"						=> $this->form['dal'],
				"dbprefix"					=> $this->form['dbprefix'],
				"dataBaseHostingProfile"	=> $this->form['dataBaseHostingProfile'],
				"dataBaseUserLogin"			=> $this->form['dataBaseHostingPrefix'].$this->form['dataBaseUserLogin'],
				"dataBaseUserPassword"		=> $this->form['dataBaseUserPassword'],
				"dataBaseUserRecreate"		=> $this->form['dataBaseUserRecreate'],
				"host"						=> $this->form['host'],
				"hosting_prefix"			=> $this->form['dataBaseHostingPrefix'],
				"tabprefix"					=> $this->form['tabprefix'],
				"type"						=> $this->form['selectedDataBaseType'],
				"user_login"				=> $this->form['dataBaseHostingPrefix'].$this->form['dataBaseAdminUser'],
				"user_password"				=> $this->form['dataBaseAdminPassword'],
				"websiteUserPassword"		=> $this->form['websiteUserPassword'],
			)
		);

		$bts->CMObj->setConfigurationEntry('type',					$this->form['selectedDataBaseType']);
		$bts->CMObj->setConfigurationEntry('host',					$this->form['host']);
		$bts->CMObj->setConfigurationEntry('dal',					$this->form['dal']);
		$bts->CMObj->setConfigurationEntry('db_user_login',			$this->form['dataBaseHostingPrefix'].$this->form['dataBaseAdminUser'] );
		$bts->CMObj->setConfigurationEntry('db_user_password',		$this->form['dataBaseAdminPassword']);
		$bts->CMObj->setConfigurationEntry('dbprefix',				$this->form['dbprefix']);
		$bts->CMObj->setConfigurationEntry('tabprefix',				$this->form['tabprefix']);

		$bts->CMObj->setConfigurationEntry('execution_context',		'installation');


		if ( $this->form['dataBaseLogErr'] == "on" )	{ $bts->CMObj->setConfigurationSubEntry('debug_option', 'SQL_debug_level', 1); }
		if ( $this->form['dataBaseLogError'] == "on" )	{ $bts->CMObj->setConfigurationSubEntry('debug_option', 'SQL_debug_level', 2); }

		$CurrentSetObj->setSqlTableListObj( SqlTableList::getInstance( $bts->CMObj->getConfigurationSubEntry('db','dbprefix'), $bts->CMObj->getConfigurationSubEntry('db', 'tabprefix') ));

		$bts->CMObj->setConfigurationEntry('dal', $bts->CMObj->getConfigurationSubEntry('db', 'dal') ); //internal copy to prepare for DAL 
		$CurrentSetObj->SqlTableListObj->makeSqlTableList($this->form['dbprefix'], $this->form['tabprefix']);
		$bts->initSddmObj();

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * processFileRenderConfigFile
	 */
	private function processFileRenderConfigFile(){
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : renderConfigFile"));
		$LibInstallationReportObj = LibInstallationReport::getInstance();
		// --------------------------------------------------------------------------------------------
		$this->tabConfigFile = array();
		$i=0;

		$shortNames = array();
		$dbquery = $bts->SDDMObj->query("SELECT ws_directory,ws_short FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('website').";");
		while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
			$shortNames[$dbp['ws_directory']] = $dbp['ws_short'];
		}

		$dl = $bts->RequestDataObj->getRequestDataEntry('directory_list');
		foreach ( $dl as $A ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Processing " . $A));

			// $infos = array ( "n" => $i, );
			$infos = array ( "n" => $shortNames[$A], );
			$this->tabConfigFile[$i]['n'] = $i;
			$this->tabConfigFile[$i]['name'] = $shortNames[$A];
			$this->tabConfigFile[$i]['cont'] = $LibInstallationReportObj->renderConfigFile($infos);
			$i++;
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}
	
	/**
	 * checkInstallToken
	 */
	private function checkInstallToken () {
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();

		$tokenValidation = false;
		$formVal = $bts->RequestDataObj->getRequestDataEntry('installToken');

		$dbquery = $bts->SDDMObj->query("SELECT inst_nbr FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('installation')
		." WHERE inst_name = 'installToken'"
		." LIMIT 1"
		.";"
		);

		$dbVal = 0;
		while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) { 
			$dbVal = $dbp['inst_nbr']; 
		}
		if ( $formVal == $dbVal ) { $tokenValidation = true; }
		return ($tokenValidation);
	}

}
?>
