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
//	Module : theme
// --------------------------------------------------------------------------------------------
$localisation = " / module_calendrier";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_calendrier");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_calendrier");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_calendrier");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$_REQUEST['sql_initiateur'] = "Module Calendrier";
$l = $langues[$WebSiteObj->getWebSiteEntry('sw_lang')]['langue_639_3'];

$pv['mois']['eng']['1'] = "January";
$pv['mois']['eng']['2'] = "February";
$pv['mois']['eng']['3'] = "March";
$pv['mois']['eng']['4'] = "April";
$pv['mois']['eng']['5'] = "May";
$pv['mois']['eng']['6'] = "June";
$pv['mois']['eng']['7'] = "July";
$pv['mois']['eng']['8'] = "August";
$pv['mois']['eng']['9'] = "September";
$pv['mois']['eng']['10'] = "October";
$pv['mois']['eng']['11'] = "November";
$pv['mois']['eng']['12'] = "December";

$pv['mois']['fra']['1'] = "Janvier";
$pv['mois']['fra']['2'] = "F&eacute;vrier";
$pv['mois']['fra']['3'] = "Mars";
$pv['mois']['fra']['4'] = "Avril";
$pv['mois']['fra']['5'] = "Mai";
$pv['mois']['fra']['6'] = "Juin";
$pv['mois']['fra']['7'] = "Juillet";
$pv['mois']['fra']['8'] = "Aout";
$pv['mois']['fra']['9'] = "Septembre";
$pv['mois']['fra']['10'] = "Octobre";
$pv['mois']['fra']['11'] = "Novembre";
$pv['mois']['fra']['12'] = "D&eacute;cembre";



$pv['jour']['eng']['1'] = "Monday";
$pv['jour']['eng']['2'] = "Tuesday";
$pv['jour']['eng']['3'] = "Wetnesday";
$pv['jour']['eng']['4'] = "Thurday";
$pv['jour']['eng']['5'] = "Friday";
$pv['jour']['eng']['6'] = "Saturday";
$pv['jour']['eng']['7'] = "Sunday";

$pv['jour']['fra']['1'] = "Lundi";
$pv['jour']['fra']['2'] = "Mardi";
$pv['jour']['fra']['3'] = "Mercredi";
$pv['jour']['fra']['4'] = "Jeudi";
$pv['jour']['fra']['5'] = "Vendredi";
$pv['jour']['fra']['6'] = "Samedi";
$pv['jour']['fra']['7'] = "Dimanche";


$date['actuelle'] = mktime(0,0,0,date('m'), date('d'), date('Y'));
$date['jour'] = date('N', $date['actuelle']);
$date['numero'] = date('d', $date['actuelle']);
$date['mois'] = date('n', $date['actuelle']);

$pv['table_hauteur'] = 64 ; 
$pv['table_largeur'] = 72;
$pv['table_margintop'] = floor (( ${$theme_tableau}['theme_module_hauteur_interne'] - $pv['table_hauteur'] ) /2);
$pv['table_marginright'] = floor (( ${$theme_tableau}['theme_module_largeur_interne'] - $pv['table_largeur'] ) /2);

echo ("
<table cellpadding='0' cellspacing='0' style='height: ".$pv['table_hauteur']."px; margin-top: ".$pv['table_margintop']."px; margin-left: auto; margin-right: auto;'>

<tr>\r
<td rowspan='2' style='font-size: ".( $pv['table_hauteur'] - 8 )."px; font-weight: bold; vertical-align: middle;'>\r".$date['numero']."</td>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_t4'>\r".$pv['jour'][$l][$date['jour']]."</td>\r
</tr>\r
<tr>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_tb6'>\r".$pv['mois'][$l][$date['mois']]."</td>\r
</tr>\r
</table>\r
");

if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { 
	unset (
	$date,
	$tl_,
	$pv
	);
}

?>
