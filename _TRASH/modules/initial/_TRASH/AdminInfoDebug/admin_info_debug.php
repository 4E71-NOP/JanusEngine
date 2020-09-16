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
// --------------------------------------------------------------------------------------------
//	Module : Info debug
//	decoration = 1
//	Récupère les informations pour calculer les temps pris par chaque partie du site
//	Affiche les requetes utilisées
// --------------------------------------------------------------------------------------------
$localisation = " / admin_info_debug";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("admin_info_debug");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("admin_info_debug");


$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("admin_info_debug");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$l = $langues[$WebSiteObj->getWebSiteEntry('sw_lang')]['langue_639_3'];
unset ( $AD, $ADC );

// --------------------------------------------------------------------------------------------
$tl_['eng']['defaut'] = "Require higher debug level. Actual debug level is : " . $WebSiteObj->getWebSiteEntry('sw_info_debug');		$tl_['fra']['defaut'] = "Requi&egrave;re un niveau de debug sup&eacute;rieur. Niveau actuel : " . $WebSiteObj->getWebSiteEntry('sw_info_debug');

$pv['onglet'] = 1;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 1 )	{ include ("../modules/initial/AdminInfoDebug/maid_general.php");					}	else { $ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 0; $AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['defaut']; }
$pv['onglet'] = 2;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 2 )	{ include ("../modules/initial/AdminInfoDebug/maid_stats.php");						}	else { $ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 0; $AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['defaut']; }
$pv['onglet'] = 3;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 3 )	{ include ("../modules/initial/AdminInfoDebug/maid_journal_d_evennements.php");		}	else { $ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 0; $AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['defaut']; }
$pv['onglet'] = 4;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 6 )	{ include ("../modules/initial/AdminInfoDebug/maid_requetes.php");					}	else { $ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 0; $AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['defaut']; }
$pv['onglet'] = 5;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 7 )	{ include ("../modules/initial/AdminInfoDebug/maid_commandes.php");					}	else { $ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 0; $AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['defaut']; }
$pv['onglet'] = 6;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 8 )	{ include ("../modules/initial/AdminInfoDebug/maid_memoire.php");					}	else { $ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 0; $AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['defaut']; }
$pv['onglet'] = 7;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 9 )	{ include ("../modules/initial/AdminInfoDebug/maid_journaux_debug.php");			}	else { $ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 0; $AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['defaut']; }
$pv['onglet'] = 8;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 10 )	{	
	include ("../modules/initial/AdminInfoDebug/maid_aff_var.php");	
	affiche_array_table ( $GLOBALS , $pv['onglet'] );
	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;
}
else { $ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 0; $AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['defaut']; }

$tl_['eng']['onglet1'] = "(1)General";			$tl_['fra']['onglet1'] = "(1)G&eacute;n&eacute;ral";
$tl_['eng']['onglet2'] = "(2)Statistics";		$tl_['fra']['onglet2'] = "(2)Statistiques";
$tl_['eng']['onglet3'] = "(3)Logs";				$tl_['fra']['onglet3'] = "(3)Journaux";
$tl_['eng']['onglet4'] = "(6)SQL queries";		$tl_['fra']['onglet4'] = "(6)Requetes SQL";
$tl_['eng']['onglet5'] = "(7)Commands";			$tl_['fra']['onglet5'] = "(7)Commandes";
$tl_['eng']['onglet6'] = "(8)Memory";			$tl_['fra']['onglet6'] = "(8)M&eacute;moire";
$tl_['eng']['onglet7'] = "(9)Debug logs";		$tl_['fra']['onglet7'] = "(9)Deboggage";
$tl_['eng']['onglet8'] = "(10)Variables";		$tl_['fra']['onglet8'] = "(10)Variables";


$pv['tab_debug_onglet'][1] = 1;
$pv['tab_debug_onglet'][2] = 2;
$pv['tab_debug_onglet'][3] = 3;
$pv['tab_debug_onglet'][4] = 4;
$pv['tab_debug_onglet'][5] = 4;
$pv['tab_debug_onglet'][6] = 4;
$pv['tab_debug_onglet'][7] = 5;
$pv['tab_debug_onglet'][8] = 6;
$pv['tab_debug_onglet'][9] = 7;
$pv['tab_debug_onglet'][10] = 8;

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= $pv['tab_debug_onglet'][$WebSiteObj->getWebSiteEntry('sw_info_debug')];
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= $pres_[$mn]['dim_y_ex22'] - ${$theme_tableau}[$_REQUEST['bloc']]['tab_y'] - 92 -320;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "aid";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet1'];
$tab_infos['cell_2_txt']		= $tl_[$l]['onglet2'];
$tab_infos['cell_3_txt']		= $tl_[$l]['onglet3'];
$tab_infos['cell_4_txt']		= $tl_[$l]['onglet4'];
$tab_infos['cell_5_txt']		= $tl_[$l]['onglet5'];
$tab_infos['cell_6_txt']		= $tl_[$l]['onglet6'];
$tab_infos['cell_7_txt']		= $tl_[$l]['onglet7'];
$tab_infos['cell_8_txt']		= $tl_[$l]['onglet8'];
include ("routines/website/affichage_donnees.php");

unset ( 
	$user,
	$presentation_cont
);

?>
