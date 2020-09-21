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
/*Hydre-contenu_debut*/
/* -------------------------------------------------------------------------------------------- */
/*	Galerie Image de synthèse																	*/
/* -------------------------------------------------------------------------------------------- */
$GAL_nom = "Image de synth&egrave;se";

if (!isset($_REQUEST['GAL_page_selection'])) { $_REQUEST['GAL_page_selection'] = 1; }

$pv['requete'] = "UPDATE ".$SQL_tab_abrege['pv']." SET pv_number = 1 WHERE pv_name = 'galerie_ticket';";
manipulation_traitement_requete ( $pv['requete'] );
$pv['i'] = 1;

$PA = Extension_Appel ( "MWM_Galerie"  );
$PLC = &$PA['extension_config'];
$PLF = &$PA['extension_fichiers'];
$GAL_table_colones = &$PA['extension_config']['table_colonnes'];
$GAL_table_lignes = &$PA['extension_config']['table_lignes'];
$GAL_taille_nom = 24;
$GAL_nom = "Example";
$GAL_dir = "../websites-datas/".$website['ws_directory']."/data/documents/".${$document_tableau}['arti_ref']."_p0".${$document_tableau}['arti_page'];
if (!isset($_REQUEST['GAL_page_selection'])) { $_REQUEST['GAL_page_selection'] = 1; }
$pv['galerie_album'] = "../extensions/".$PA['extension_directory']."/programmes/".$PLF['Galerie']['fichier_nom'];
include ( $pv['galerie_album'] );


/*Hydre-contenu_fin*/
?>
