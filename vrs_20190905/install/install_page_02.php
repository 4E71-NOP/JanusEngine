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
/* @var $RenderLayoutObj RenderLayout               */
/* @var $ThemeDataObj ThemeData                     */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */

/* @var $Block String                               */
/* @var $infos array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

// --------------------------------------------------------------------------------------------
//		Installation page 02
// --------------------------------------------------------------------------------------------

$installationStartTime = time();
include ("install/i18n/install_page_02_".$l.".php");

// --------------------------------------------------------------------------------------------
//
//
// Mode Web (URL)
//
//
// --------------------------------------------------------------------------------------------
$tab_index = 1 ;

if ( $RequestDataObj->getRequestDataEntry('resume_detail_desc') == "on") { $tab_index++; }
if ( $RequestDataObj->getRequestDataEntry('resume_detail_execsql') == "on") { $tab_index += 2; }

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


$form = $RequestDataObj->getRequestDataEntry('form');
$CMObj->setConfigurationEntry('operating_mode', $form['operating_mode'] );

$CMObj->setConfigurationEntry('db',
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

$CMObj->setConfigurationEntry('type',					$form['database_type_choix']);
$CMObj->setConfigurationEntry('host',					$form['host']);
$CMObj->setConfigurationEntry('dal',					$form['database_type_choix']);
$CMObj->setConfigurationEntry('db_user_login',			$form['db_hosting_prefix'].$form['db_admin_user'] );
$CMObj->setConfigurationEntry('db_user_password',		$form['db_admin_password']);
$CMObj->setConfigurationEntry('dbprefix',				$form['dbprefix']);
$CMObj->setConfigurationEntry('tabprefix',				$form['tabprefix']);

$CMObj->setConfigurationEntry('execution_context',		'installation');


if ( $form['db_detail_log_err'] == "on" )	{ $CMObj->setConfigurationSubEntry('debug_option', 'SQL_debug_level', 1); }
if ( $form['db_detail_log_warn'] == "on" )	{ $CMObj->setConfigurationSubEntry('debug_option', 'SQL_debug_level', 2); }

$CurrentSetObj->setInstanceOfSqlTableListObj( SqlTableList::getInstance( $CMObj->getConfigurationSubEntry('db','dbprefix'), $CMObj->getConfigurationSubEntry('db', 'tabprefix') ));

$CMObj->setConfigurationEntry('dal', $CMObj->getConfigurationSubEntry('db', 'dal') ); //internal copy to prepare for DAL 
$DALFacade = DalFacade::getInstance();
$DALFacade->createDALInstance();		// It connects too.


$r = array();
switch ( $CMObj->getConfigurationSubEntry('db','database_profil') ) {
case "hostplan":
	switch ( $CMObj->getConfigurationEntry('dal') ) {
	case "MYSQLI":		break;	//Rien a faire : PHP
	case "PDOMYSQL":	break;	//Rien a faire : PHP
	case "SQLITE":		break;
	case "ADODB":		break;
	case "PEARDB":			
	case "PEARSQLITE":	
		$r[] = "SET SESSION query_cache_type = OFF;";				// Sensé inhiber l'utilisation du cache
		$r[] = "USE ".$CMObj->getConfigurationEntry('dbprefix').";";
		unset ( $A );
		$db->loadModule('Manager');
		foreach ( $db->listTables( $CMObj->getConfigurationEntry('dbprefix') ) as $A ) { $r[] = "DROP TABLE ". $A .";"; }
		$r[] = "FLUSH TABLES;";										// Sensé remettre a zero les query_cache
		$db->loadModule('Native');
	break;
	}
break; 
case "absolute":
	$r[] = "DROP DATABASE IF EXISTS ".$CMObj->getConfigurationSubEntry('db','dbprefix').";";	// Détruit la base
	$r[] = "FLUSH TABLES;";										// Sensé remettre a zero les query_cache
	$r[] = "FLUSH PRIVILEGES;";
	$r[] = "CREATE DATABASE ".$CMObj->getConfigurationSubEntry('db','dbprefix').";";				// Création de la base
	$r[] = "USE ".$CMObj->getConfigurationSubEntry('db','dbprefix').";";							// Et on utilise
	$r[] = "SET SESSION query_cache_type = ON;";				// Sensé initier l'utilisation du query_cache
	$r[] = "SET GLOBAL query_cache_size = 67108864;";			// 16 777 216;
	$r[] = "SET GLOBAL tmp_table_size = 67108864;";				// 16 777 216;
	$r[] = "SET GLOBAL max_heap_table_size = 67108864;";		// 16 777 216;

	$monSQLn += 9;
break;
}

switch ( $CMObj->getConfigurationSubEntry('db','database_user_recreate') ) {
case "oui":
	$r[] = "DROP USER IF EXISTS '".$CMObj->getConfigurationSubEntry('db','database_user_login')."'@'%';";
	$r[] = "DROP USER IF EXISTS '".$CMObj->getConfigurationSubEntry('db','database_user_login')."'@'localhost';";
	$r[] = "CREATE USER '".$CMObj->getConfigurationSubEntry('db','database_user_login')."'@'%' IDENTIFIED BY '".$CMObj->getConfigurationSubEntry('db','database_user_password')."';";
	$r[] = "CREATE USER '".$CMObj->getConfigurationSubEntry('db','database_user_login')."'@'localhost' IDENTIFIED BY '".$CMObj->getConfigurationSubEntry('db','database_user_password')."';";
	$r[] = "GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE ON ".$CMObj->getConfigurationSubEntry('db','dbprefix').".* TO '".$CMObj->getConfigurationSubEntry('db','database_user_login')."'@'%' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
	$r[] = "GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE ON ".$CMObj->getConfigurationSubEntry('db','dbprefix').".* TO '".$CMObj->getConfigurationSubEntry('db','database_user_login')."'@'localhost' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
	$r[] = "FLUSH TABLES;";										// Sensé remettre a zero les query_cache
	$r[] = "FLUSH PRIVILEGES;";
	$monSQLn += 8;
break;
}
$r[] = "COMMIT;";
$r[] = "USE ".$CMObj->getConfigurationSubEntry('db','dbprefix').";";


// --------------------------------------------------------------------------------------------

$SDDMObj = DalFacade::getInstance()->getDALInstance();
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
		$SDDMObj->query($q); 
		error_log($q);
	}
	unset ($r);
	
	// --------------------------------------------------------------------------------------------
	$ClassLoaderObj->provisionClass('CommandConsole');
	$CommandConsole = CommandConsole::getInstance();

	// --------------------------------------------------------------------------------------------
	//
	//		Lancement des scripts.
	//
	// --------------------------------------------------------------------------------------------
	$infos = array (
			"path" => "../websites-data/",
			"method" =>  "filename",
			"section" => "tables_creation",
			"directory_list" => $RequestDataObj->getRequestDataEntry('directory_list')
	);
	
	$LibInstallationObj->scanDirectories($infos);
	foreach ( $infos['directory_list'] as $A ) {
		if ( isset ($A['filesFound'] ) ) {
			$LibInstallationObj->executeContent($infos, $A);
		}
	}
	
	
	// --------------------------------------------------------------------------------------------
	$infos = array (
			"path" => "../websites-data/",
			"method" =>  "filename",
			"section" => "tables_data",
			"directory_list" => $RequestDataObj->getRequestDataEntry('directory_list')
	);
	
	$LibInstallationObj->scanDirectories($infos);
	foreach ( $infos['directory_list'] as $A ) {
		if ( isset ($A['filesFound'] ) ) {
			$LibInstallationObj->executeContent($infos, $A);
		}
	}
	
	// --------------------------------------------------------------------------------------------
	$SqlTableListObj = $CurrentSetObj->getInstanceOfSqlTableListObj();
	$r = array(
			"COMMIT;",
			"FLUSH TABLES;",
			"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".$installationStartTime."' WHERE inst_name = 'start_date';",
			"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".time()."' WHERE inst_name = 'derniere_activite';",
			"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".$RequestDataObj->getRequestDataEntry('SessionID')."' WHERE inst_name = 'SessionID';",
			"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '1' WHERE inst_name = 'affichage';",
			"COMMIT;",
	);
	foreach ( $r as $q ){
		$SDDMObj->query($q);
// 		error_log($q);
	}
	unset ($r);
	
	// --------------------------------------------------------------------------------------------
	$infos = array (
			"path" => "../websites-data/",
			"method" =>  "commandConsole",
			"section" => "script",
			"directory_list" => $RequestDataObj->getRequestDataEntry('directory_list')
	);
	error_log($StringFormatObj->arrayToString($infos));
	$LibInstallationObj->scanDirectories($infos);
	foreach ( $infos['directory_list'] as $A ) {
		if ( isset ($A['filesFound'] ) ) {
			$LibInstallationObj->executeContent($infos, $A);
		}
	}
	
	// --------------------------------------------------------------------------------------------
	$infos = array (
			"path" => "../websites-data/",
			"method" =>  "filename",
			"section" => "tables_post_install",
			"directory_list" => $RequestDataObj->getRequestDataEntry('directory_list')
	);
	$LibInstallationObj->scanDirectories($infos);
	error_log($StringFormatObj->arrayToString($infos));
	foreach ( $infos['directory_list'] as $A ) {
		if ( isset ($A['filesFound'] ) ) {
			$LibInstallationObj->executeContent($infos, $A);
		}
	}
	
	// --------------------------------------------------------------------------------------------
	$tabConfigFile = array();
	$i=0;
	error_log($StringFormatObj->arrayToString($infos));
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
$SDDMObj->query("UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".time()."' WHERE inst_name = 'end_date';");
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
	"titles" => array($i18n['t1c1'],	$i18n['t1c2'],	$i18n['t1c3'],	$i18n['t1c4'],	),
	"cols" => array( 'file', 'OK', 'WARN', 'ERR'),
);
$style2 = array (
	"block" => $block,
	"tc"=>1,
	"titles" => array($i18n['t9c1'],	$i18n['t9c2'],	$i18n['t9c3'],	$i18n['t9c4'],	$i18n['t9c5'],	),
	"cols" => array('temps_debut', 'nbr', 'nom', 'signal', 'err_no', 'err_msg', 'temps_fin'),
);

// --------------------------------------------------------------------------------------------
$T['AD'][$CurrentTab] = $LibInstallationReportObj->renderReport( $installationReport['tables_creation']		, $style1 );
$CurrentTab++;

// --------------------------------------------------------------------------------------------
$T['AD'][$CurrentTab] = $LibInstallationReportObj->renderReport( $installationReport['tables_data']			, $style1 );
$CurrentTab++;

// --------------------------------------------------------------------------------------------
$T['AD'][$CurrentTab] = $LibInstallationReportObj->renderReport( $installationReport['script']				, $style1 );
$CurrentTab++;

// --------------------------------------------------------------------------------------------
$T['AD'][$CurrentTab] = $LibInstallationReportObj->renderReport( $installationReport['tables_post_install']	, $style1 );
$CurrentTab++;

// --------------------------------------------------------------------------------------------
$SB = array();
$SB['id']				= "SelectBtn";
$SB['type']				= "button";
$SB['initialStyle']		= $block."_tb3 ".$block."_submit_s1_n";
$SB['hoverStyle']		= $block."_tb3 ".$block."_submit_s2_h";
$SB['onclick']			= "";
$SB['message']			= $i18n['t5Btn'];
$SB['mode']				= 1;
$SB['size'] 			= 92;
$SB['lastSize']			= 92;

$T['AD'][$CurrentTab]['1']['1']['cont'] = $i18n['t5c1'];
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
			<td>\r".$InteractiveElementsObj->renderSubmitButton($SB)."</td>\r
			</tr>\r
			</table>\r
			"
			;
	$Cl++;
}
// $CurrentTab++;


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$fontSizeRange = $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'txt_fonte_size_max') - $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'txt_fonte_size_min');

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
				"module_deco_txt_defaut" => 3,
				"module_nom" => "Admin_install_B1",
				"module_classname" => "",
				"module_titre" => "",
				"module_fichier" => "",
				"module_desc" => "",
				"module_conteneur_nom" => "",
				"module_groupe_pour_voir" => 31,
				"module_groupe_pour_utiliser" => 31,
				"module_adm_control" => 0,
				"module_execution" => 0,
				"site_module_id" => 11,
				"site_id" => 2,
				"module_etat" => 1,
				"module_position" => 2,
				)
);


$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 30, 5);
$T['tab_infos']['tabTxt1']			= $i18n['tab_1'];
$T['tab_infos']['tabTxt2']			= $i18n['tab_2'];
$T['tab_infos']['tabTxt3']			= $i18n['tab_3'];
$T['tab_infos']['tabTxt4']			= $i18n['tab_4'];
$T['tab_infos']['tabTxt5']			= $i18n['tab_5'];
$T['tab_infos']['tabTxt6']			= $i18n['tab_6'];
$T['tab_infos']['tabTxt7']			= $i18n['tab_7'];


$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig(count($installationReport['tables_creation'])+2		,4,6),
		2	=>	$RenderTablesObj->getDefaultTableConfig(count($installationReport['tables_data'])+2			,4,6),
		3	=>	$RenderTablesObj->getDefaultTableConfig(count($installationReport['script'])+2				,4,6),
		4	=>	$RenderTablesObj->getDefaultTableConfig(count($installationReport['tables_post_install'])+2	,4,6),
		5	=>	$RenderTablesObj->getDefaultTableConfig(count($tabConfigFile)+1								,4,6),
);

$DocContent .= $RenderTablesObj->render($infos, $T);

?>
