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
//	Journaux d'evennement
// --------------------------------------------------------------------------------------------
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 0;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 7;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

$tl_['eng']['o4l11']	= "N";				$tl_['fra']['o4l11']	= "N";
$tl_['eng']['o4l12']	= "Date";			$tl_['fra']['o4l12']	= "Date";
$tl_['eng']['o4l13']	= "Initiator";		$tl_['fra']['o4l13']	= "Initiateur";
$tl_['eng']['o4l14']	= "Action";			$tl_['fra']['o4l14']	= "Action";
$tl_['eng']['o4l15']	= "Signal";			$tl_['fra']['o4l15']	= "Signal";
$tl_['eng']['o4l16']	= "Code";			$tl_['fra']['o4l16']	= "Code";
$tl_['eng']['o4l17']	= "Message";		$tl_['fra']['o4l17']	= "Message";

$AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['o4l11'];	$AD[$pv['onglet']]['1']['1']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['1']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['2']['cont'] = $tl_[$l]['o4l12'];	$AD[$pv['onglet']]['1']['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['2']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['3']['cont'] = $tl_[$l]['o4l13'];	$AD[$pv['onglet']]['1']['3']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";
$AD[$pv['onglet']]['1']['4']['cont'] = $tl_[$l]['o4l14'];	$AD[$pv['onglet']]['1']['4']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['4']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['5']['cont'] = $tl_[$l]['o4l15'];	$AD[$pv['onglet']]['1']['5']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['5']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['6']['cont'] = $tl_[$l]['o4l16'];	$AD[$pv['onglet']]['1']['6']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['6']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['7']['cont'] = $tl_[$l]['o4l17'];	$AD[$pv['onglet']]['1']['7']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";

$pv['tab_signal']['0'] = "<span class='".$theme_tableau.$_REQUEST['bloc']."_erreur'>ERR</span>";	
$pv['tab_signal']['1'] = "<span class='".$theme_tableau.$_REQUEST['bloc']."_ok'>OK</span>";	
$pv['tab_signal']['2'] = "<span class='".$theme_tableau.$_REQUEST['bloc']."_avert'>WARN</span>";	
$pv['tab_signal']['3'] = "<span class='".$theme_tableau.$_REQUEST['bloc']."_ok'>INFO</span>";	
$pv['tab_signal']['4'] = "<span class='".$theme_tableau.$_REQUEST['bloc']."_ok'>AUTRE</span>";
//$signal = $tab[$signal];

$pv['historique_date'] = mktime();
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['historique']." 
WHERE site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
ORDER BY historique_id DESC 
LIMIT 0,15
;");

$pv['i'] = 2;
while ($dbp = fetch_array_sql($dbquery)) {
	$pv['historique_action_longeur'] = strlen($dbp['historique_action']);
	switch (TRUE) {
	case ($pv['historique_action_longeur'] < 128 && $pv['historique_action_longeur'] > 64):	$dbp['historique_action'] = substr ($dbp['historique_action'],0,59) . " [...] ";		break;
	case ($pv['historique_action_longeur'] > 128):									$dbp['historique_action'] = substr ($dbp['historique_action'],0,59) . " [...] " . substr ($dbp['historique_action'],($pv['historique_action_longeur'] - 64) ,$pv['historique_action_longeur'] );		break;
	}
	$AD[$pv['onglet']][$pv['i']]['1']['cont'] = $dbp['historique_id'];								$AD[$pv['onglet']][$pv['i']]['1']['tc'] = 1;	$AD[$pv['onglet']][$pv['i']]['1']['style'] = "text-align: center;";
	$AD[$pv['onglet']][$pv['i']]['2']['cont'] = date ( "Y m d H:i:s" , $dbp['historique_date'] );	$AD[$pv['onglet']][$pv['i']]['2']['tc'] = 1;	$AD[$pv['onglet']][$pv['i']]['2']['style'] = "text-align: center;";
	$AD[$pv['onglet']][$pv['i']]['3']['cont'] = $dbp['historique_initiateur'];						$AD[$pv['onglet']][$pv['i']]['3']['tc'] = 2;
	$AD[$pv['onglet']][$pv['i']]['4']['cont'] = $dbp['historique_action'];							$AD[$pv['onglet']][$pv['i']]['4']['tc'] = 1;	$AD[$pv['onglet']][$pv['i']]['4']['style'] = "text-align: center;";
	$AD[$pv['onglet']][$pv['i']]['5']['cont'] = $pv['tab_signal'][$dbp['historique_signal']];														$AD[$pv['onglet']][$pv['i']]['5']['style'] = "text-align: center;";
	$AD[$pv['onglet']][$pv['i']]['6']['cont'] = $dbp['historique_msgid'];							$AD[$pv['onglet']][$pv['i']]['6']['tc'] = 1;	$AD[$pv['onglet']][$pv['i']]['6']['style'] = "text-align: center;";
	$AD[$pv['onglet']][$pv['i']]['7']['cont'] = $dbp['historique_contenu'];							$AD[$pv['onglet']][$pv['i']]['7']['tc'] = 1;	
	$pv['i']++;
}
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['i'] - 1;

unset ( 
	$A, 
	$dbquery, 
	$dbp
);

?>
