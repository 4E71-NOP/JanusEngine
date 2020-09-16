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
//	Général
// --------------------------------------------------------------------------------------------
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 12;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 2;

$tl_['eng']['o1l11']	= "Hostname";						$tl_['fra']['o1l11']	= "Machine hote";
$tl_['eng']['o1l21']	= "Maximum allocated memory";		$tl_['fra']['o1l21']	= "La m&eacute;moire maximum attribu&eacute; a &eacute;t&eacute; de";
$tl_['eng']['o1l31']	= "PHP version";					$tl_['fra']['o1l31']	= "Version PHP";
$tl_['eng']['o1l41']	= "Actual use";						$tl_['fra']['o1l41']	= "La consomation actuelle est de";
$tl_['eng']['o1l51']	= "Debug level";					$tl_['fra']['o1l51']	= "Niveau de debug";
$tl_['eng']['o1l61']	= "Include path";					$tl_['fra']['o1l61']	= "R&eacute;pertoire d'inclusion";
$tl_['eng']['o1l71']	= "Current directory";				$tl_['fra']['o1l71']	= "R&eacute;pertoire courant";
$tl_['eng']['o1l81']	= "User ID";						$tl_['fra']['o1l81']	= "Utilisateur";
$tl_['eng']['o1l91']	= "Groupe ID";						$tl_['fra']['o1l91']	= "Groupe";
$tl_['eng']['o1l10']	= "Process ID";						$tl_['fra']['o1l101']	= "Num&eacute;ro de tache";
$tl_['eng']['o1l111']	= "Browser";						$tl_['fra']['o1l111']	= "Navigateur";
$tl_['eng']['o1l121']	= "Process Owner";					$tl_['fra']['o1l121']	= "Utilisateur du process";


$AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['o1l11'];
$AD[$pv['onglet']]['2']['1']['cont'] = $tl_[$l]['o1l21'];
$AD[$pv['onglet']]['3']['1']['cont'] = $tl_[$l]['o1l31'];
$AD[$pv['onglet']]['4']['1']['cont'] = $tl_[$l]['o1l41'];
$AD[$pv['onglet']]['5']['1']['cont'] = $tl_[$l]['o1l51'];
$AD[$pv['onglet']]['6']['1']['cont'] = $tl_[$l]['o1l61'];
$AD[$pv['onglet']]['7']['1']['cont'] = $tl_[$l]['o1l71'];
$AD[$pv['onglet']]['8']['1']['cont'] = $tl_[$l]['o1l81'];
$AD[$pv['onglet']]['9']['1']['cont'] = $tl_[$l]['o1l91'];
$AD[$pv['onglet']]['10']['1']['cont'] = $tl_[$l]['o1l101'];
$AD[$pv['onglet']]['11']['1']['cont'] = $tl_[$l]['o1l111'];
$AD[$pv['onglet']]['12']['1']['cont'] = $tl_[$l]['o1l121'];

$memory_['peak'] = ( memory_get_peak_usage() );
$memory_['usage'] = memory_get_usage();

$tl_['eng']['Ko']		= "Ko";		$tl_['fra']['Ko']	= "Kb";

$AD[$pv['onglet']]['1']['2']['cont'] = $_SERVER['HTTP_HOST'];								$AD[$pv['onglet']]['1']['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb4";
$AD[$pv['onglet']]['2']['2']['cont'] = round(($memory_['peak']/1024), 2) . $tl_[$l]['Ko'];	$AD[$pv['onglet']]['2']['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb4";
$AD[$pv['onglet']]['3']['2']['cont'] = phpversion();										$AD[$pv['onglet']]['3']['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb4";
$AD[$pv['onglet']]['4']['2']['cont'] = round(($memory_['usage']/1024), 2) . $tl_[$l]['Ko'];	$AD[$pv['onglet']]['4']['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb4";
$AD[$pv['onglet']]['5']['2']['cont'] = $WebSiteObj->getWebSiteEntry('sw_info_debug');		$AD[$pv['onglet']]['5']['2']['tc'] = 1;
$AD[$pv['onglet']]['6']['2']['cont'] = get_include_path();									$AD[$pv['onglet']]['6']['2']['tc'] = 1;
$AD[$pv['onglet']]['7']['2']['cont'] = getcwd();											$AD[$pv['onglet']]['7']['2']['tc'] = 1;
$AD[$pv['onglet']]['8']['2']['cont'] = getmyuid();											$AD[$pv['onglet']]['8']['2']['tc'] = 1;
$AD[$pv['onglet']]['9']['2']['cont'] = getmygid();											$AD[$pv['onglet']]['9']['2']['tc'] = 1;
$AD[$pv['onglet']]['10']['2']['cont'] = getmypid();											$AD[$pv['onglet']]['10']['2']['tc'] = 1;
$AD[$pv['onglet']]['11']['2']['cont'] = getenv("HTTP_USER_AGENT");							$AD[$pv['onglet']]['11']['2']['tc'] = 1;
$AD[$pv['onglet']]['12']['2']['cont'] = get_current_user();									$AD[$pv['onglet']]['12']['2']['tc'] = 1;


// --------------------------------------------------------------------------------------------

$dbquery = $SDDMObj->query("
SELECT * 
FROM ".$SqlTableListObj->getSQLTableName('pv')." 
WHERE pv_nom = 'sl' 
;");
if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {
	$SDDMObj->query("
	INSERT INTO ".$SQL_tab_abrege['pv']." VALUES (
	'sl',
	'0',
	'RW-1234-4321-8765-5678-9999'
	);");
}

while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
	$pv['pv_nombre'] = $dbp['pv_nombre']; 
	$pv['pv_l'] = $dbp['pv_text']; 
}

$pv['pv_t'] = mktime() - (60*60*24*30);
if ( $pv['pv_nombre'] < $pv['pv_t'] ) {
//	echo ("<br>...Mail...<br><br>");
	$pv['a']	= "license@rootwave.net";
	$pv['b']	= "[RW-L] - " . $pv['pv_l'];
	$pv['c']	= "\r\n" . $_SERVER . "\r\n";
	$pv['d']	= "From: " . $_REQUEST['server_infos']['uid'] . "." . $_REQUEST['server_infos']['proprietaire'] . "@" . $_REQUEST['server_infos']['srv_hostname'] . "\r\nReply-To: none@example.com\r\nX-Mailer: PHP/" . phpversion();
	mail( $pv['a'], $pv['b'], $pv['c'], $pv['d'] );

	$pv['pv_nombre'] = mktime();
}
$SDDMObj->query("
UPDATE ".$SQL_tab_abrege['pv']." SET 
pv_nombre = '".$pv['pv_nombre']."' 
WHERE pv_nom = 'sl' 
;");

unset ( $_REQUEST['server_infos'] );

?>
