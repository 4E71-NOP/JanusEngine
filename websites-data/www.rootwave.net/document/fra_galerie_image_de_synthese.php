<?php
// // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


/*JanusEngine-Content-Begin*/
/* -------------------------------------------------------------------------------------------- */
/*	Galerie Image de synthèse																	*/
/* -------------------------------------------------------------------------------------------- */
$GAL_nom = "Image de synth&egrave;se";

if (!isset($_REQUEST['GAL_page_selection'])) {
	$_REQUEST['GAL_page_selection'] = 1;
}

$pv['requete'] = "UPDATE " . $SQL_tab_abrege['pv'] . " SET pv_number = 1 WHERE pv_name = 'galerie_ticket';";
manipulation_traitement_requete($pv['requete']);
$pv['i'] = 1;

$PA = Extension_Appel("MWM_Galerie");
$PLC = &$PA['extension_config'];
$PLF = &$PA['extension_fichiers'];
$GAL_table_colones = &$PA['extension_config']['table_colonnes'];
$GAL_table_lignes = &$PA['extension_config']['table_lignes'];
$GAL_taille_nom = 24;
$GAL_nom = "Example";
$GAL_dir = "../websites-datas/" . $website['ws_directory'] . "/data/document/" . ${$document_tableau}['arti_ref'] . "_p0" . ${$document_tableau}['arti_page'];
if (!isset($_REQUEST['GAL_page_selection'])) {
	$_REQUEST['GAL_page_selection'] = 1;
}
$pv['galerie_album'] = "../extensions/" . $PA['extension_directory'] . "/programmes/" . $PLF['Galerie']['fichier_nom'];
include($pv['galerie_album']);


/*JanusEngine-Content-End*/
