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
/* @var $RenderLayoutObj RenderLayout               */
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

// Specific values for installation form
$bts->CMObj->setConfigurationEntry('admin_user','dbadmin');
$bts->CMObj->setConfigurationEntry('admin_password','nimdabd');
$bts->CMObj->setConfigurationEntry('db_hosting_prefix','');

// include ("current/install/i18n/install_page_01_".$l.".php");
// $bts->I18nTransObj->apply($i18n);
$bts->I18nTransObj->apply(array( "type" => "file", "file" => "current/install/i18n/install_page_01_".$l.".php", "format" => "php" ) );
// unset ($i18n);

// --------------------------------------------------------------------------------------------
//
// Server info
//
// --------------------------------------------------------------------------------------------

// --------------------------------------------------------------------------------------------
$ServerInfosObj = $CurrentSetObj->getInstanceOfServerInfosObj();

$FormName = "install_page_init";
$DocContent .= "<form ACTION='install.php' id='".$FormName."' method='post'>\r";
// --------------------------------------------------------------------------------------------
//
//	Frame 00
//
// --------------------------------------------------------------------------------------------
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
$DocContent .= "<p style='text-align: center;'>\r";
foreach ( $LangageSelector as $A ) {
	$DocContent .= "<a href='install.php?l=".$A['code']."'><img src='media/theme/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$A['file']."' alt='' height='64' width='64' border='0'></a>\r";
}
$DocContent .= "</p><br>\r";
unset ($LangageSelector);

// --------------------------------------------------------------------------------------------
//
//	Frame 01
//
// --------------------------------------------------------------------------------------------
$CurrentFrame = 1;


// --------------------------------------------------------------------------------------------
//	Tab 01
//
//
$T = array();
$CurrentTab = 1;
// --------------------------------------------------------------------------------------------
//	Dectection of installed support.
//	This is only relevant when this program reside on the server
// --------------------------------------------------------------------------------------------
$pv['a'] = "<span class='" . $Block."_warning'>";
$pv['b'] = "</span>";

$pv['iconGoNoGoOk'] = "<img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ok') .	"' width='24' height='24' border='0'>";
$pv['iconGoNoGoNok'] = "<img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_notification').	"' width='24' height='24' border='0'>";

$Support['response'] .= $bts->I18nTransObj->getI18nTransEntry('PHP_support_title');

$Support['DAL']['ADOdb']['state'] = 0;
$Support['DAL']['ADOdb']['file'] = "/usr/share/php/adodb/adodb.inc.php";
$Support['DAL']['ADOdb']['include'] = "/usr/share/php/adodb/adodb.inc.php";
$Support['DAL']['ADOdb']['fonction'] = "DAL_adodb";
$Support['DAL']['ADOdb']['name'] = "ADOdb";

$Support['DAL']['pear']['state'] = 0;
$Support['DAL']['pear']['file'] = "/usr/bin/pear";
$Support['DAL']['pear']['include'] = "MDB2.php";
$Support['DAL']['pear']['fonction'] = "DAL_PEAR";
$Support['DAL']['pear']['name'] = "PEAR";

function DAL_adodb () {
	global $ADODB_vers;
	return ( $ADODB_vers );
}

//  sudo pear list
//  sudo pear install MDB2_Driver_sqlite
//  sudo pear list
//  sudo pear upgrade-all
//
//xxxxx@xxxxx:/usr/share/php$ pear list
//Installed packages, channel pear.php.net:
//=========================================
//Package            Version State
//Archive_Tar        1.3.3   stable
//Console_Getopt     1.2.3   stable
//DB                 1.7.13  stable
//MDB2               2.4.1   stable
//MDB2_Driver_mysql  1.4.1   stable
//MDB2_Driver_sqlite 1.4.1   stable
//PEAR               1.8.1   stable
//Structures_Graph   1.0.2   stable
//XML_Util           1.2.1   stable

// Doctrine = /usr/share/php/Doctrine/lib/Doctrine

function DAL_PEAR () {
	$B = "";
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
	return ( $B );
}

foreach ( $Support['DAL'] as &$A ) {
	if ( file_exists ($A['file']) ) {
		$A['state'] = 1;
		include ( $A['include']); 		// no include_once because MDB2.php bug (timeout 60sec).
		$F = $A['fonction'];
		$Support['response'] .= $pv['iconGoNoGoOk'] . " " . $A['name']  ." " . $bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok') . "(" . $F() . ")<br>\r";
	}
	else {
		$Support['response'] .= $pv['iconGoNoGoNok'] . " " . $pv['a'] . $A['name']  ." " . $bts->I18nTransObj->getI18nTransEntry('PHP_builtin_nok') . $pv['b'];
	}
}
if (defined('PDO::MYSQL_ATTR_LOCAL_INFILE')) {
	$Support['response'] .= $pv['iconGoNoGoOk'] . " " . "PDO/MySQL" ." " . $bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok');
	$Support['DAL']['PDO']['state'] = 1;
}
else {
	$Support['response'] .= $pv['iconGoNoGoNok'] . " " . $pv['a'] . "PDO/MySQL" ." " . $bts->I18nTransObj->getI18nTransEntry('PHP_builtin_nok') . $pv['b'];
	$Support['DAL']['PDO']['state'] = 0;
}

$Support['PHP']['PHP_cubrid_builtin']['state'] = 0;		$Support['PHP']['PHP_cubrid_builtin']['f'] = "cubrid_connect";		$Support['PHP']['PHP_cubrid_builtin']['name'] = "CUBRID";
$Support['PHP']['PHP_dbplus_builtin']['state'] = 0;		$Support['PHP']['PHP_dbplus_builtin']['f'] = "dbplus_open";			$Support['PHP']['PHP_dbplus_builtin']['name'] = "DB++";
$Support['PHP']['PHP_dbase_builtin']['state'] = 0;		$Support['PHP']['PHP_dbase_builtin']['f'] = "dbase_open";			$Support['PHP']['PHP_dbase_builtin']['name']	 = "DBase";
$Support['PHP']['PHP_filepro_builtin']['state'] = 0;	$Support['PHP']['PHP_filepro_builtin']['f'] = "filepro";			$Support['PHP']['PHP_filepro_builtin']['name'] = "FilePro";
$Support['PHP']['PHP_ibase_builtin']['state'] = 0;		$Support['PHP']['PHP_ibase_builtin']['f'] = "ibase_connect";		$Support['PHP']['PHP_ibase_builtin']['name']	 = "Firebird/InterBase";
$Support['PHP']['PHP_frontbase_builtin']['state'] = 0;	$Support['PHP']['PHP_frontbase_builtin']['f'] = "fbsql_connect";	$Support['PHP']['PHP_frontbase_builtin']['name'] = "FrontBase";
$Support['PHP']['PHP_db2_builtin']['state'] = 0;		$Support['PHP']['PHP_db2_builtin']['f'] = "db2_connect";			$Support['PHP']['PHP_db2_builtin']['name'] = "IBM DB2";
$Support['PHP']['PHP_ifx_builtin']['state'] = 0;		$Support['PHP']['PHP_ifx_builtin']['f'] = "ifx_connect";			$Support['PHP']['PHP_ifx_builtin']['name'] = "Informix";
$Support['PHP']['PHP_ingress_builtin']['state'] = 0;	$Support['PHP']['PHP_ingress_builtin']['f'] = "ingres_connect";		$Support['PHP']['PHP_ingress_builtin']['name'] = "Ingress";
$Support['PHP']['PHP_maxdb_builtin']['state'] = 0;		$Support['PHP']['PHP_maxdb_builtin']['f'] = "maxdb_connect";		$Support['PHP']['PHP_maxdb_builtin']['name'] = "MaxDB";
$Support['PHP']['PHP_msql_builtin']['state'] = 0;		$Support['PHP']['PHP_msql_builtin']['f'] = "msql_connect";			$Support['PHP']['PHP_msql_builtin']['name'] = "mSQL";
$Support['PHP']['PHP_mssql_builtin']['state'] = 0;		$Support['PHP']['PHP_mssql_builtin']['f'] = "mssql_connect";		$Support['PHP']['PHP_mssql_builtin']['name'] = "Mssql";
$Support['PHP']['PHP_mysql_builtin']['state'] = 0;		$Support['PHP']['PHP_mysql_builtin']['f'] = "mysql_connect";		$Support['PHP']['PHP_mysql_builtin']['name'] = "MySQL";
$Support['PHP']['PHP_mysqli_builtin']['state'] = 0;		$Support['PHP']['PHP_mysqli_builtin']['f'] = "mysqli_connect";		$Support['PHP']['PHP_mysqli_builtin']['name'] = "MySQLi";
$Support['PHP']['PHP_oci_builtin']['state'] = 0;		$Support['PHP']['PHP_oci_builtin']['f'] = "oci_connect";			$Support['PHP']['PHP_oci_builtin']['name'] = "OCI8";
$Support['PHP']['PHP_px_builtin']['state'] = 0;			$Support['PHP']['PHP_px_builtin']['f'] = "px_open_fp";				$Support['PHP']['PHP_px_builtin']['name'] = "Paradox";
$Support['PHP']['PHP_postgresql_builtin']['state'] = 0;	$Support['PHP']['PHP_postgresql_builtin']['f'] = "pg_connect";		$Support['PHP']['PHP_postgresql_builtin']['name'] = "PostgreSQL";
$Support['PHP']['PHP_sqlite_builtin']['state'] = 0;		$Support['PHP']['PHP_sqlite_builtin']['f'] = "sqlite_open";			$Support['PHP']['PHP_sqlite_builtin']['name'] = "SQLite";
$Support['PHP']['PHP_sqlsrv_builtin']['state'] = 0;		$Support['PHP']['PHP_sqlsrv_builtin']['f'] = "sqlsrv_connect";		$Support['PHP']['PHP_sqlsrv_builtin']['name'] = "SQLSRV";
$Support['PHP']['PHP_sybase_builtin']['state'] = 0;		$Support['PHP']['PHP_sybase_builtin']['f'] = "sybase_connect";		$Support['PHP']['PHP_sybase_builtin']['name'] = "Sybase";

$tl_['fra']['PHP_support_titre'] = "<hr>Fonctions PHP (le support...):<br>\r";
$tl_['eng']['PHP_support_titre'] = "<hr>PHP functions:<br>\r";
$Support['response'] .= $bts->I18nTransObj->getI18nTransEntry('PHP_support_titre');

foreach ( $Support['PHP'] as &$A ) {
	if ( function_exists( $A['f'] ) ) {
		$A['state'] = 1;
		$Support['response'] .= $pv['iconGoNoGoOk'] . " " . $A['name']  ." " . $bts->I18nTransObj->getI18nTransEntry('PHP_builtin_ok');
	}
}
$Support['PHP_version'] = "PHP vrs " . phpversion();

// --------------------------------------------------------------------------------------------

$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 21, 6);
// --------------------------------------------------------------------------------------------

$CellTab['t1l1c2']	= $ServerInfosObj->getServerInfosEntry('srv_hostname');
$CellTab['t1l2c2']	= $Support['PHP_version'];
$CellTab['t1l3c2']	= $ServerInfosObj->getServerInfosEntry('include_path');
$CellTab['t1l4c2']	= $ServerInfosObj->getServerInfosEntry('currentDirectory');
$CellTab['t1l5c2']	= $ServerInfosObj->getServerInfosEntry('display_errors')." / ".$bts->I18nTransObj->getI18nTransEntry($ServerInfosObj->getServerInfosEntry('register_globals'))." / ".$ServerInfosObj->getServerInfosEntry('post_max_size');
$CellTab['t1l6c2']	= $ServerInfosObj->getServerInfosEntry('memory_limit');
$CellTab['t1l7c2']	= $ServerInfosObj->getServerInfosEntry('max_execution_time') ."s";
$CellTab['t1l8c2']	= $Support['response'];
$CellTab['t1l9c2']	= "<input type='text' size='2' name='form[memory_limit]'	value=''>M";
$CellTab['t1l10c2']	= "<input type='text' size='2' name='form[time_limit]'		value=''>s";

if ( intval(str_replace( "M", "", $ServerInfosObj->getServerInfosEntry('memory_limit') )) < 128 ) { $CellTab['t1l6c2'] .= " (<span class='".$Block."_warning'>".$bts->I18nTransObj->getI18nTransEntry('test_nok')."</span>)"; }
else { $CellTab['t1l6c2'] .= $bts->I18nTransObj->getI18nTransEntry('test_ok'); }

if ( $ServerInfosObj->getServerInfosEntry('max_execution_time') >= 60 ) { $CellTab['t1l7c2'] .= " (<span class='".$Block."_warning'>".$bts->I18nTransObj->getI18nTransEntry('test_nok')."</span>)"; }
else { $CellTab['t1l7c2'] .= $bts->I18nTransObj->getI18nTransEntry('test_ok'); }

for ( $i = 1 ; $i <= 10 ; $i++ ) {
	$T['Content'][$CurrentTab][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l'.$i.'c1');
	$T['Content'][$CurrentTab][$i]['2']['cont'] = $CellTab['t1l'.$i.'c2'];
}

$T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig(10,2,2);
$CurrentTab++;

// --------------------------------------------------------------------------------------------
//	Tab 02
//
//
$lt = 1;

$bubbleBegin = "<img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_question') . "' width='24' height='24' border='0' onMouseOver=\"t.ToolTip('";
$bubbleEnd = "')\" onMouseOut=\"t.ToolTip()\">";

$T['Content'][$CurrentTab]['caption']['cont'] = $bts->I18nTransObj->getI18nTransEntry('F2_intro');
$T['Content'][$CurrentTab][$lt]['1']['cont'] = "<input type='radio' name='form[operating_mode]' onClick='setFormPreconizedSettings()' value='directCnx' checked>".$bts->I18nTransObj->getI18nTransEntry('F2_m1o1').$bubbleBegin.$bts->I18nTransObj->getI18nTransEntry('F2_txt_aide1').$bubbleEnd;
$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<input type='radio' name='form[operating_mode]' onClick='setFormPreconizedSettings()' value='createScript'>".$bts->I18nTransObj->getI18nTransEntry('F2_m1o2').$bubbleBegin.$bts->I18nTransObj->getI18nTransEntry('F2_txt_aide2').$bubbleEnd;

$T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($lt,2,0);
$CurrentTab++;

// --------------------------------------------------------------------------------------------
//	Tab 03
//
//
$lt = 1;

$T['ContentCfg']['tabs'][$CurrentTab]['NbrOfLines'] = 0;	$T['ContentCfg']['tabs'][$CurrentTab]['NbrOfCells'] = 3;	$T['ContentCfg']['tabs'][$CurrentTab]['TableCaptionPos'] = 1;

$T['Content'][$CurrentTab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l1c1');
$T['Content'][$CurrentTab]['1']['1']['tc'] = 4;

$T['Content'][$CurrentTab]['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l1c2');
$T['Content'][$CurrentTab]['1']['2']['tc'] = 4;

$T['Content'][$CurrentTab]['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l1c3');
$T['Content'][$CurrentTab]['1']['3']['tc'] = 4;

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
		$T['Content'][$CurrentTab][$i]['1']['cont'] = "<span style='font-style:italic'>".$a."</span>\r";
		$T['Content'][$CurrentTab][$i]['2']['cont'] = "<input type='checkbox' name='directory_list[".$a."][plouf]' disabled checked >";
		$T['Content'][$CurrentTab][$i]['3']['cont'] = "<input type='checkbox' name='directory_list[".$a."][plouf2]' disabled checked >\r
		<input type='hidden' name='directory_list[".$a."][name]' value='".$a."'>\r
		<input type='hidden' name='directory_list[".$a."][state]' value='on'>\r";
	}
	else {
		$T['Content'][$CurrentTab][$i]['1']['cont'] = $a." <input type='hidden' name='directory_list[".$a."][name]' value='".$a."'>\r";
		$T['Content'][$CurrentTab][$i]['2']['cont'] = "<input type='checkbox' name='directory_list[".$a."][state]' checked onClick='setFormPreconizedSettings()'>\r";
		
		$listDirectoriCheckbox[] = "directory_list[".$a."][state]";
		
		$T['Content'][$CurrentTab][$i]['3']['cont'] = "<input type='checkbox' name='directory_list[".$a."][code_verification]' checked>\r";
	}
	$i++;
}
$T['ContentCfg']['tabs'][$CurrentTab]['NbrOfLines'] = ( $i - 1 );

$str = "var ListCheckbox = [\r";
foreach ( $listDirectoriCheckbox as $A ) { $str .= "\"".$A."\", \r"; }
$str = substr($str, 0,-3) . "\r];\r";
$GeneratedScriptObj->insertString('JavaScript-Data' , $str);
$GeneratedScriptObj->insertString('JavaScript-Onload' , "\tsetFormPreconizedSettings();");

$T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig(($i-1),3,1);
$CurrentTab++;

// --------------------------------------------------------------------------------------------
//	Tab 04
//
//
$lt = 1;

$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');	$T['Content'][$CurrentTab][$lt]['1']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['1']['sc'] = 1;
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c2');	$T['Content'][$CurrentTab][$lt]['2']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['2']['sc'] = 1;
$T['Content'][$CurrentTab][$lt]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c3');	$T['Content'][$CurrentTab][$lt]['3']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['3']['sc'] = 1;
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c4');	$T['Content'][$CurrentTab][$lt]['4']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['4']['sc'] = 1;
$lt++;

unset ($tab_);
$tab_[$bts->CMObj->getConfigurationEntry('dal')] = " selected ";
$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<select id='form[dal]' name='form[dal]' onChange=\"SelectMenuBuilder ( 'form[dal]' , 'form[selected_database_type]' , DBvsDALCompatility[this.value] );\">\r";

if ( $Support['PHP']['PHP_mysqli_builtin']['state'] == 1 )	{ $T['Content'][$CurrentTab][$lt]['3']['cont'] .= "<option value='MYSQLI'	".$tab_['MYSQLI'].">".	$bts->I18nTransObj->getI18nTransEntry('msdal_msqli')."</option>\r"; }
if ( $Support['DAL']['ADOdb']['state'] == 1 )				{ $T['Content'][$CurrentTab][$lt]['3']['cont'] .= "<option value='ADODB'		".$tab_['ADODB'].">".	$bts->I18nTransObj->getI18nTransEntry('msdal_adodb')."</option>\r"; }
if ( $Support['DAL']['PDO']['state'] == 1 )					{ $T['Content'][$CurrentTab][$lt]['3']['cont'] .= "<option value='PHPPDO'	".$tab_['PDO'].">".		$bts->I18nTransObj->getI18nTransEntry('msdal_phppdo')."</option>\r"; }
if ( $Support['DAL']['pear']['state'] == 1 )				{ $T['Content'][$CurrentTab][$lt]['3']['cont'] .= "<option value='PEARDB'	".$tab_['PEARDB'].">".	$bts->I18nTransObj->getI18nTransEntry('msdal_pear')."</option>\r"; }

$T['Content'][$CurrentTab][$lt]['3']['cont'] .= "</select>\r";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

// DB Type selection
unset ($tab_);
$tab_[$bts->CMObj->getConfigurationEntry('type')] = " selected ";
$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<select id='form[selected_database_type]' name='form[selected_database_type]'>\r
<option value='mysql'	".$tab_['mysql'].">MySQL 3.x/4.x/5.x</option>\r
</select>\r
";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

// Hosting plan
$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c2');

$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<select name='form[database_profil]'>\r
<option value='absolute'>".$bts->I18nTransObj->getI18nTransEntry('dbp_asolute')."</option>\r
<option value='hostplan'>".$bts->I18nTransObj->getI18nTransEntry('dbp_hosted')."</option>\r
</select>\r
";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

// DB Server
$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<input type='text' name='form[host]' size='20' maxlength='255' value='".$bts->CMObj->getConfigurationEntry('host')."'>";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

// Prefix
$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<input type='text' name='form[db_hosting_prefix]' size='10' maxlength='255' value='".$bts->CMObj->getConfigurationEntry('db_hosting_prefix')."' OnKeyup=\"InsertValue ( this.value , '".$FormName."', ['form[db_hosting_prefix_copie_1]', 'form[db_hosting_prefix_copie_2]', 'form[db_hosting_prefix_copie_3]' ] );\">";
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

// DB name
$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_1]' size='10' maxlength='255' value=''>";
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<input type='text' name='form[dbprefix]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('dbprefix')."'>";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

// Login
$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_2]' size='10' maxlength='255' value=''>";
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<input type='text' name='form[db_admin_user]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('admin_user')."'>";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<input type='password' name='form[db_admin_password]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('admin_password')."'>";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c4');
$lt++;


$SB['id']				= "bouton_install_testdb";
$SB['type']				= "button";
$SB['initialStyle']		= $Block."_submit_s1_n";
$SB['hoverStyle']		= $Block."_submit_s1_h";
$SB['onclick']			= "toggleDiv ('cnxToDB', false ); toggleDiv ('HydrDBAlreadyExist', false ); test_cnx_db(); var tmp_cnx_chaine = document.forms['".$FormName."'].elements['form[db_hosting_prefix]'].value + document.forms['".$FormName."'].elements['form[db_admin_user]'].value + '@' + document.forms['".$FormName."'].elements['form[host]'].value  + ', Database: ' + document.forms['".$FormName."'].elements['form[db_hosting_prefix]'].value + document.forms['".$FormName."'].elements['form[dbprefix]'].value ; InsertValue ( tmp_cnx_chaine , '".$FormName."', [ 'form[chaine_connexion_test]']  );";
$SB['message']			= "Test DB";
$SB['mode']				= 1;
$SB['size'] 			= 128;
$SB['lastSize']			= 128;

$pv['div_cnx_db'] = "
	<input type='text' readonly disable name='form[chaine_connexion_test]' size='40' maxlength='255' value=''><br>\r";

$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');	$T['Content'][$CurrentTab][$lt]['1']['tc'] = 2;
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c2');	$T['Content'][$CurrentTab][$lt]['2']['tc'] = 2;
$T['Content'][$CurrentTab][$lt]['3']['cont'] = $bts->InteractiveElementsObj->renderSubmitButton($SB);	$T['Content'][$CurrentTab][$lt]['3']['tc'] = 2;
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $pv['div_cnx_db'] . "
	<div id='cnxToDBok'				style='visibilty: hidden; display : none; position: realtive;'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ok')														. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('t4l10c4aok')."</div>
	<div id='cnxToDBko'				style='visibilty: hidden; display : none; position: realtive;'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ko')														. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('t4l10c4ako')."</div>
	<div id='HydrDBAlreadyExistok'	style='visibilty: hidden; display : none; position: realtive;' class='".$Block._CLASS_TXT_WARNING_."'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_notification')	. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('t4l10c4bok')."</div>
	<div id='HydrDBAlreadyExistko'	style='visibilty: hidden; display : none; position: realtive;'><img src='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ko')														. "' width='24' height='24' border='0'>".	$bts->I18nTransObj->getI18nTransEntry('t4l10c4bko')."</div>
	";

$T['Content'][$CurrentTab][$lt]['4']['tc'] = 2;

$SrvUri = $_SERVER['REQUEST_URI'];
$uriCut = strpos( $_SERVER['REQUEST_URI'] , "/Hydr/current/install/install_page_01.php" );
$SrvUri = substr ( $_SERVER['REQUEST_URI'] , 0 , $uriCut );

$GeneratedScriptObj->insertString('JavaScript-Data' , "var RequestURI = \"". $SrvUri . "\"");
$GeneratedScriptObj->insertString('JavaScript-Data' , "var FormName = \"".$FormName."\"");


$T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($lt,4,1);
$CurrentTab++;

// --------------------------------------------------------------------------------------------
//	Tab 05
//
//
$lt=1;
$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c1');	$T['Content'][$CurrentTab][$lt]['1']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['1']['sc'] = 1;
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c2');	$T['Content'][$CurrentTab][$lt]['2']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['2']['sc'] = 1;
$T['Content'][$CurrentTab][$lt]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c3');	$T['Content'][$CurrentTab][$lt]['3']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['3']['sc'] = 1;
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c4');	$T['Content'][$CurrentTab][$lt]['4']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['4']['sc'] = 1;
$lt++;

$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<input type='text' name='form[tabprefix]' size='10' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('tabprefix')."' OnKeyup=\"InsertValue ( 'Ex: ' + this.value + 'article_config' , '".$FormName."', ['form[db_hosting_tabprefix_copie_1]'] );\">";
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<input type='text' readonly disable name='form[db_hosting_tabprefix_copie_1]' size='20' maxlength='255' value=''>";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$GeneratedScriptObj->insertString('JavaScript-Command' , "InsertValue ( 'Ex: ".$bts->CMObj->getConfigurationEntry('tabprefix')."article_config' , '".$FormName."', ['form[db_hosting_tabprefix_copie_1]' , 'form[db_hosting_tabprefix_copie_1]' ] );");

$lt++;


$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_3]' size='10' maxlength='255' value=''>";
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<input type='text' name='form[database_user_login]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('db_user_login')."'>";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;


$SB['id']				= "bouton_install_radompass";
$SB['type']				= "button";
$SB['initialStyle']		= $Block."_tb3 ".$Block."_submit_s1_n";
$SB['hoverStyle']		= $Block."_tb3 ".$Block."_submit_s1_h";
$SB['onclick']			= "elm.SetFormInputValue ( '".$FormName."' , 'form[database_user_password]' , CreateRandomPassword( 20 ) );";
$SB['message']			= $bts->I18nTransObj->getI18nTransEntry('boutonpass');
$SB['mode']				= 1;
$SB['size'] 			= 128;
$SB['lastSize']			= 128;


$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<input type='password' id='form[database_user_password]' name='form[database_user_password]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('db_user_password')."'>";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c4') . "<br><br>". $bts->InteractiveElementsObj->renderSubmitButton($SB);
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<select name='form[database_user_recreate]'>\r
<option value='non'>".$bts->I18nTransObj->getI18nTransEntry('dbr_n')."</option>\r
<option value='oui' selected >".$bts->I18nTransObj->getI18nTransEntry('dbr_o')."</option>\r
</select>\r
";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<input type='password' name='form[standard_user_password]' size='20' maxlength='32' value='".$bts->CMObj->getConfigurationEntry('db_user_password')."'>";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<select name='form[creation_htaccess]'>\r
<option value='non' selected>".$bts->I18nTransObj->getI18nTransEntry('dbr_n')."</option>\r
<option value='oui'>".$bts->I18nTransObj->getI18nTransEntry('dbr_o')."</option>\r
</select>\r
";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;
$lt++;

$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<select name='form[TypeExec]'>\r
<option value='ModuleApache' selected>".$bts->I18nTransObj->getI18nTransEntry('TypeExec1')."</option>\r
<option value='CLI'>".$bts->I18nTransObj->getI18nTransEntry('TypeExec2')."</option>\r
</select>\r
";
$T['Content'][$CurrentTab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l'.$lt.'c4');
$T['Content'][$CurrentTab][$lt]['4']['tc'] = 1;

$T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($lt,4,1);
$CurrentTab++;


// --------------------------------------------------------------------------------------------
//	Tab 06
//
//
$lt=1;

$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l'.$lt.'c1');	$T['Content'][$CurrentTab][$lt]['1']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['1']['sc'] = 1;
$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l'.$lt.'c2');	$T['Content'][$CurrentTab][$lt]['2']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['2']['sc'] = 1;
$T['Content'][$CurrentTab][$lt]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l'.$lt.'c3');	$T['Content'][$CurrentTab][$lt]['3']['tc'] = 4;	$T['Content'][$CurrentTab][$lt]['3']['sc'] = 1;
$lt++;

$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<input type='checkbox' name='form[db_detail_log_warn]'>" . $bts->I18nTransObj->getI18nTransEntry('t6l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<input type='checkbox' name='form[db_detail_log_err]' checked>" . $bts->I18nTransObj->getI18nTransEntry('t6l'.$lt.'c3');
$lt++;


$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l'.$lt.'c1');
$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<input type='checkbox' name='form[console_detail_log_warn]' checked>" . $bts->I18nTransObj->getI18nTransEntry('t6l'.$lt.'c2');
$T['Content'][$CurrentTab][$lt]['3']['cont'] = "<input type='checkbox' name='form[console_detail_log_err]' checked>" . $bts->I18nTransObj->getI18nTransEntry('t6l'.$lt.'c3');

$T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($lt,3,1);
$CurrentTab++;


// --------------------------------------------------------------------------------------------
$DocContent .= $bts->RenderTablesObj->render($infos, $T);

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
$SB['onclick']			= "CheckFormValues( ListeChamps , '".$l."' , '".$SessionID."')";
$SB['message']			= $bts->I18nTransObj->getI18nTransEntry('bouton');
$SB['mode']				= 1;
$SB['size'] 			= 256;
$SB['lastSize']			= 256;

$DocContent .= "
<br>\r
<br>\r
<div style='position: absolute; text-align: center; width: ".$ThemeDataObj->getThemeDataEntry('theme_module_internal_width')."px;'>\r
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
<input type='hidden' name='l' value='".$l."'>\r
		
</form>\r
<br>\r<br>\r<br>\r<br>\r<br>\r
";

// --------------------------------------------------------------------------------------------
?>
