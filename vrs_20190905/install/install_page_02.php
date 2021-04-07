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
/* $RenderLayoutObj RenderLayout               */

/*Hydre-IDE-end*/

/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $cs BaseToolSet                             */
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

$installationStartTime = time();
include ("current/install/i18n/install_page_02_".$l.".php");
$bts->I18nObj->apply($i18n);
unset ($i18n);

// --------------------------------------------------------------------------------------------
//
//
// Method POST
//
//
// --------------------------------------------------------------------------------------------
$tab_index = 1 ;

if ( $bts->RequestDataObj->getRequestDataEntry('resume_detail_desc') == "on") { $tab_index++; }
if ( $bts->RequestDataObj->getRequestDataEntry('resume_detail_execsql') == "on") { $tab_index += 2; }

$tab_fc['1'] = $block."_fca ".$block."_t1";
$tab_fc['2'] = $block."_fca ".$block."_t1";
$tab_fc['3'] = $block."_fca ".$block."_t1";
$tab_fc['4'] = $block."_fcb ".$block."_t1";
$tab_fc['5'] = $block."_fcc ".$block."_tb2";
$tab_fc['6'] = $block."_fcd ".$block."_tb3";
$tab_fc['7'] = $block."_fcd ".$block."_tb4";

$tab_fc1 = $tab_fc[$tab_index];	$tab_index++;
$tab_fc2 = $tab_fc[$tab_index];	$tab_index++;
$tab_fc3 = $tab_fc[$tab_index];	$tab_index++;
$tab_fc4 = $tab_fc[$tab_index];


$form = $bts->RequestDataObj->getRequestDataEntry('form');
$bts->CMObj->setConfigurationEntry('operating_mode', $form['operating_mode'] );

$bts->CMObj->setConfigurationEntry('db',
	array(
		"type"						=> $form['database_type_choix'],
		"dal"						=> $form['dal'],
		"host"						=> $form['host'],
		"user_login"				=> $form['db_hosting_prefix'].$form['db_admin_user'],
		"user_password"				=> $form['db_admin_password'],
		"hosting_prefix"			=> $form['db_hosting_prefix'],
		"dbprefix"					=> $form['dbprefix'],
		"tabprefix"					=> $form['tabprefix'],
		"database_user_login"		=> $form['db_hosting_prefix'].$form['database_user_login'],
		"database_user_password"	=> $form['database_user_password'],
		"standard_user_password"	=> $form['standard_user_password'],
		"database_profil"			=> $form['database_profil'],
		"database_user_recreate"	=> $form['database_user_recreate'],
	)
);

$bts->CMObj->setConfigurationEntry('type',					$form['database_type_choix']);
$bts->CMObj->setConfigurationEntry('host',					$form['host']);
$bts->CMObj->setConfigurationEntry('dal',					$form['database_type_choix']);
$bts->CMObj->setConfigurationEntry('db_user_login',			$form['db_hosting_prefix'].$form['db_admin_user'] );
$bts->CMObj->setConfigurationEntry('db_user_password',		$form['db_admin_password']);
$bts->CMObj->setConfigurationEntry('dbprefix',				$form['dbprefix']);
$bts->CMObj->setConfigurationEntry('tabprefix',				$form['tabprefix']);

$bts->CMObj->setConfigurationEntry('execution_context',		'installation');


if ( $form['db_detail_log_err'] == "on" )	{ $bts->CMObj->setConfigurationSubEntry('debug_option', 'SQL_debug_level', 1); }
if ( $form['db_detail_log_warn'] == "on" )	{ $bts->CMObj->setConfigurationSubEntry('debug_option', 'SQL_debug_level', 2); }

$CurrentSetObj->setInstanceOfSqlTableListObj( SqlTableList::getInstance( $bts->CMObj->getConfigurationSubEntry('db','dbprefix'), $bts->CMObj->getConfigurationSubEntry('db', 'tabprefix') ));

$bts->CMObj->setConfigurationEntry('dal', $bts->CMObj->getConfigurationSubEntry('db', 'dal') ); //internal copy to prepare for DAL 
$bts->initSddmObj();

$r = array();
switch ( $bts->CMObj->getConfigurationSubEntry('db','database_profil') ) {
case "hostplan":
	switch ( $bts->CMObj->getConfigurationEntry('dal') ) {
	case "MYSQLI":		break;	//Nothing to do : PHP
	case "PDOMYSQL":	break;	//Nothing to do : PHP
	case "SQLITE":		break;
	case "ADODB":		break;
	case "PEARDB":			
	case "PEARSQLITE":	
		$r[] = "SET SESSION query_cache_type = OFF;";				// forbids cache usage
		$r[] = "USE ".$bts->CMObj->getConfigurationEntry('dbprefix').";";
		unset ( $A );
		$db->loadModule('Manager');
		foreach ( $db->listTables( $bts->CMObj->getConfigurationEntry('dbprefix') ) as $A ) { $r[] = "DROP TABLE ". $A .";"; }
		$r[] = "FLUSH TABLES;";										// clean query_cache
		$db->loadModule('Native');
	break;
	}
break; 
case "absolute":
	$r[] = "DROP DATABASE IF EXISTS ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').";";	// Kill database
	$r[] = "FLUSH TABLES;";										// clean query_cache
	$r[] = "FLUSH PRIVILEGES;";
	$r[] = "CREATE DATABASE ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').";";				// Create DB
	$r[] = "USE ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').";";							// Use it
	$r[] = "SET SESSION query_cache_type = ON;";				// clean query_cache
	$r[] = "SET GLOBAL query_cache_size = 67108864;";			// 16 777 216;
	$r[] = "SET GLOBAL tmp_table_size = 67108864;";				// 16 777 216;
	$r[] = "SET GLOBAL max_heap_table_size = 67108864;";		// 16 777 216;

// 	$monSQLn += 9;
break;
}

switch ( $bts->CMObj->getConfigurationSubEntry('db','database_user_recreate') ) {
case "oui":
	$r[] = "DROP USER IF EXISTS '".$bts->CMObj->getConfigurationSubEntry('db','database_user_login')."'@'%';";
	$r[] = "DROP USER IF EXISTS '".$bts->CMObj->getConfigurationSubEntry('db','database_user_login')."'@'localhost';";
	$r[] = "CREATE USER '".$bts->CMObj->getConfigurationSubEntry('db','database_user_login')."'@'%' IDENTIFIED BY '".$bts->CMObj->getConfigurationSubEntry('db','database_user_password')."';";
	$r[] = "CREATE USER '".$bts->CMObj->getConfigurationSubEntry('db','database_user_login')."'@'localhost' IDENTIFIED BY '".$bts->CMObj->getConfigurationSubEntry('db','database_user_password')."';";
	$r[] = "GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE ON ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').".* TO '".$bts->CMObj->getConfigurationSubEntry('db','database_user_login')."'@'%' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
	$r[] = "GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE ON ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').".* TO '".$bts->CMObj->getConfigurationSubEntry('db','database_user_login')."'@'localhost' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
	$r[] = "FLUSH TABLES;";										// clean query_cache 
	$r[] = "FLUSH PRIVILEGES;";
// 	$monSQLn += 8;
break;
}
$r[] = "COMMIT;";
$r[] = "USE ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').";";


// --------------------------------------------------------------------------------------------
$bts->InitCommandConsole();
$ClassLoaderObj->provisionClass('LibInstallation');
$LibInstallationObj = LibInstallation::getInstance();
$t = time();
$LibInstallationObj->setReport(array(
	"lastReportExecution"=> $t,
	"lastReportExecutionSaved"=> $t,
));


$devDebug = 0;
if ( $devDebug != 1 ) {
	foreach ( $r as $q ){ 
		$bts->SDDMObj->query($q); 
		error_log(__METHOD__ . " : " . $q);
	}
	unset ($r);
	
	// --------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------
	//
	//		Launching scripts.
	//
	// --------------------------------------------------------------------------------------------
	$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => "install_page_p02 : tables_creation"));
	$infos = array (
			"path" => "websites-data/",
			"method" =>  "filename",
			"section" => "tables_creation",
			"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
			"updateInsdtallationMonitor" => 0
	);
	
	$LibInstallationObj->scanDirectories($infos);
	foreach ( $infos['directory_list'] as $A ) {
		if ( isset ($A['filesFound'] ) ) {
			$LibInstallationObj->executeContent($infos, $A);
		}
	}
	
	
	// --------------------------------------------------------------------------------------------
	$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => "install_page_p02 : tables_data"));
	$infos = array (
			"path" => "websites-data/",
			"method" =>  "filename",
			"section" => "tables_data",
			"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
			"updateInsdtallationMonitor" => 0
	);
	
	$LibInstallationObj->scanDirectories($infos);
	foreach ( $infos['directory_list'] as $A ) {
		if ( isset ($A['filesFound'] ) ) {
			$LibInstallationObj->executeContent($infos, $A);
		}
	}
	
	// --------------------------------------------------------------------------------------------
	$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => "install_page_p02 : Initialization of table installation"));
	$SqlTableListObj = $CurrentSetObj->getInstanceOfSqlTableListObj();
	$r = array(
			"COMMIT;",
			"FLUSH TABLES;",
			"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".$installationStartTime."' WHERE inst_name = 'start_date';",
			"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".time()."' WHERE inst_name = 'last_activity';",
			"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".$bts->RequestDataObj->getRequestDataEntry('SessionID')."' WHERE inst_name = 'SessionID';",
			"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '1' WHERE inst_name = 'display';",
			"COMMIT;",
	);
	foreach ( $r as $q ){
		$bts->SDDMObj->query($q);
// 		error_log($q);
	}
	unset ($r);
	
	// --------------------------------------------------------------------------------------------
	$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : commandConsole"));
	$infos = array (
			"path" => "websites-data/",
			"method" =>  "commandConsole",
			"section" => "script",
			"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
			"updateInsdtallationMonitor" => 1
	);
	error_log($bts->StringFormatObj->arrayToString($infos));
	$LibInstallationObj->scanDirectories($infos);
	foreach ( $infos['directory_list'] as $A ) {
		if ( isset ($A['filesFound'] ) ) {
			$LibInstallationObj->executeContent($infos, $A);
		}
	}
	
	// --------------------------------------------------------------------------------------------
	$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : tables_post_install"));
	$infos = array (
			"path" => "websites-data/",
			"method" =>  "filename",
			"section" => "tables_post_install",
			"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
			"updateInsdtallationMonitor" => 1
	);
	$LibInstallationObj->scanDirectories($infos);
	error_log($bts->StringFormatObj->arrayToString($infos));
	foreach ( $infos['directory_list'] as $A ) {
		if ( isset ($A['filesFound'] ) ) {
			$LibInstallationObj->executeContent($infos, $A);
		}
	}
	
	// --------------------------------------------------------------------------------------------
	$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : renderConfigFile"));
	$tabConfigFile = array();
	$i=0;
	error_log($bts->StringFormatObj->arrayToString($infos));
	foreach ( $infos['directory_list'] as $k => $v ) {
		if ( isset ($A['filesFound'] ) ) {
			$infos = array ( "n" => $i, );
			$tabConfigFile[$i]['n'] = $i;
			$tabConfigFile[$i]['name'] = $k;
			$tabConfigFile[$i]['cont'] = $LibInstallationObj->renderConfigFile($infos);
		}
		$i++;
	}
	
// --------------------------------------------------------------------------------------------
$bts->SDDMObj->query("UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".time()."' WHERE inst_name = 'end_date';");
}

// --------------------------------------------------------------------------------------------
$CurrentTab = 1;
$lt = 1;
$ClassLoaderObj->provisionClass('LibInstallationReport');
$LibInstallationReportObj = LibInstallationReport::getInstance();
$installationReport = $LibInstallationObj->getReport();

sort ( $installationReport['tables_creation']);
sort ( $installationReport['tables_data']);
sort ( $installationReport['script']);
sort ( $installationReport['tables_post_install']);

$style1 = array (
	"block" => $block,
	"tc"=>1,
	"titles" => array($bts->I18nObj->getI18nEntry('t1c1'),	$bts->I18nObj->getI18nEntry('t1c2'),	$bts->I18nObj->getI18nEntry('t1c3'),	$bts->I18nObj->getI18nEntry('t1c4'),	),
	"cols" => array( 'file', 'OK', 'WARN', 'ERR'),
);
$style2 = array (
	"block" => $block,
	"tc"=>1,
	"titles" => array($bts->I18nObj->getI18nEntry('t9c1'),	$bts->I18nObj->getI18nEntry('t9c2'),	$bts->I18nObj->getI18nEntry('t9c3'),	$bts->I18nObj->getI18nEntry('t9c4'),	$bts->I18nObj->getI18nEntry('t9c5'),	),
	"cols" => array('temps_debut', 'nbr', 'nom', 'signal', 'err_no', 'err_msg', 'temps_fin'),
);

// --------------------------------------------------------------------------------------------
$T['ADC']['onglet'] = array();

// --------------------------------------------------------------------------------------------
$T['ADC']['onglet'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig(count($installationReport['tables_creation'])+2 ,4,6);
$T['AD'][$CurrentTab] = $LibInstallationReportObj->renderReport( $installationReport['tables_creation']		, $style1 );
$CurrentTab++;

// --------------------------------------------------------------------------------------------
$T['ADC']['onglet'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig(count($installationReport['tables_data'])+2 ,4,6);
$T['AD'][$CurrentTab] = $LibInstallationReportObj->renderReport( $installationReport['tables_data']			, $style1 );
$CurrentTab++;

// --------------------------------------------------------------------------------------------
$T['ADC']['onglet'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig(count($installationReport['script'])+2 ,4,6);
$T['AD'][$CurrentTab] = $LibInstallationReportObj->renderReport( $installationReport['script']				, $style1 );
$CurrentTab++;

// --------------------------------------------------------------------------------------------
$T['ADC']['onglet'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig(count($installationReport['tables_post_install'])+2 ,4,6);
$T['AD'][$CurrentTab] = $LibInstallationReportObj->renderReport( $installationReport['tables_post_install']	, $style1 );
$CurrentTab++;

// --------------------------------------------------------------------------------------------
$tmp = $LibInstallationReportObj->renderPerfomanceReport();
$T['AD'][$CurrentTab] = $tmp['content'];
$T['ADC']['onglet'] [$CurrentTab]= $tmp['config'];
unset ($tmp);

// error_log ("adcTab06: " . $bts->StringFormatObj->arrayToString($adcTab06));
// error_log ("\$T['AD'][\$CurrentTab]: " . $bts->StringFormatObj->arrayToString($T['AD'][$CurrentTab]));
$CurrentTab++;
// --------------------------------------------------------------------------------------------
$SB = array();
$SB['id']				= "SelectBtn";
$SB['type']				= "button";
$SB['initialStyle']		= $block."_tb3 ".$block."_submit_s1_n";
$SB['hoverStyle']		= $block."_tb3 ".$block."_submit_s2_h";
$SB['onclick']			= "";
$SB['message']			= $bts->I18nObj->getI18nEntry('t5Btn');
$SB['mode']				= 1;
$SB['size'] 			= 92;
$SB['lastSize']			= 92;

$T['ADC']['onglet'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig(count($tabConfigFile)+1 ,4,6);
$T['AD'][$CurrentTab]['1']['1']['cont'] = $bts->I18nObj->getI18nEntry('t5c1');
$Cl = 2;
foreach ($tabConfigFile as $A ) {
	$SB['id']		=	"SelectBtn".$A['name'];
	$SB['onclick']	=	"elm.Gebi('txtConfig_".$A['name']."').select()";
	$T['AD'][$CurrentTab][$Cl]['1']['cont'] = 
			"
			<table style=' width:".($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')-32)."px; border-spacing: 4px;'>\r
			<tr>\r
			<td colspan='2'>\rcurrent/config/current/site_".$A['n']."_config.php (for ".$A['name'].")</td>\r
			</tr>\r

			<tr>\r
			<td colspan='2'>\r
			<textarea id='txtConfig_".$A['name']."' cols='100' rows='10'>".$A['cont']."</textarea>
			</td>\r
			</tr>\r

			<tr>\r
			<td style='width:".($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')-256)."px;'>&nbsp;</td>\r
			<td>\r".$bts->InteractiveElementsObj->renderSubmitButton($SB)."</td>\r
			</tr>\r
			</table>\r
			"
			;
	$Cl++;
}

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
		"affiche_module_mode" => "normal",
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
				"module_group_allowed_to_see" => 31,
				"module_group_allowed_to_use" => 31,
				"module_adm_control" => 0,
				"module_execution" => 0,
				"module_website_id" => 11,
				"ws_id" => 2,
				"module_state" => 1,
				"module_position" => 2,
				)
);


$T['tab_infos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 30, 6);
$T['tab_infos']['tabTxt1']			= $bts->I18nObj->getI18nEntry('tab_1');
$T['tab_infos']['tabTxt2']			= $bts->I18nObj->getI18nEntry('tab_2');
$T['tab_infos']['tabTxt3']			= $bts->I18nObj->getI18nEntry('tab_3');
$T['tab_infos']['tabTxt4']			= $bts->I18nObj->getI18nEntry('tab_4');
$T['tab_infos']['tabTxt5']			= $bts->I18nObj->getI18nEntry('tab_5');
$T['tab_infos']['tabTxt6']			= $bts->I18nObj->getI18nEntry('tab_6');
$T['tab_infos']['tabTxt7']			= $bts->I18nObj->getI18nEntry('tab_7');


// $T['ADC']['onglet'] = array(
// 		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(count($installationReport['tables_creation'])+2		,4,6),
// 		2	=>	$bts->RenderTablesObj->getDefaultTableConfig(count($installationReport['tables_data'])+2			,4,6),
// 		3	=>	$bts->RenderTablesObj->getDefaultTableConfig(count($installationReport['script'])+2				,4,6),
// 		4	=>	$bts->RenderTablesObj->getDefaultTableConfig(count($installationReport['tables_post_install'])+2	,4,6),
// 		5	=>	$adcTab06,
// 		6	=>	$bts->RenderTablesObj->getDefaultTableConfig(count($tabConfigFile)+1								,4,6),
// );

$DocContent .= $bts->RenderTablesObj->render($infos, $T);

?>
