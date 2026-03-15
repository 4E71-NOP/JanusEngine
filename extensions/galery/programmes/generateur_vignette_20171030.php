<?php
/*MWM-licence*/
// --------------------------------------------------------------------------------------------
//
//	JnsEng - Janus Engine
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@multiweb-manager.net
//
// --------------------------------------------------------------------------------------------
/*MWM-licence-fin*/
//	ws_gal_mode			OFF 0	BASE 1(base)	FICHIER 2 (FILE)
// --------------------------------------------------------------------------------------------
//	MDB2 notes : i couldn't make it work properly
//	remember: The page code is in a EVAL()
//	so an Eval code is including the call_galerie that reference the image with this script.
// --------------------------------------------------------------------------------------------
//	Notes MDB2 : Je n'ai pas pu faire fonctionner MDB2 dans ce script
//	Rappel: Le code de la page est exécuté dans un EVAL()
//	Donc on a un code dans un EVAL qui appel le fichier call_galerie qui reference l'image en
//	utilisant ce script.
// --------------------------------------------------------------------------------------------
function microtime_chrono()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
$GAL_['temp_debut'] = microtime_chrono();

$_REQUEST['contexte_d_execution'] = "Extension_installation";
$_REQUEST['sql_initiateur'] = "generateur_vignette.php";
$_REQUEST['debug_option']['SQL_debug_level']		= 0;				// Préparatif_sql.php
$_REQUEST['StatistiqueInsertion'] = 0;
$_REQUEST['localisation'] = "";
$statistiques_ = array();
$statistiques_index = 0;

include("../../../version_actuelle/" . $_REQUEST['fc']);
include("../../../version_actuelle/engine/fonctions_universelles.php");
$SQL_tab = array();
$SQL_tab_abrege = array();
config_variable();
include("../../../version_actuelle/engine/preparatifs_sql.php");

function statistique_checkpoint($routine)
{
	if ($_REQUEST['StatistiqueInsertion'] == 1) {
		global $statistiques_, $statistiques_index;
		$statistiques_index++;
		$i = $statistiques_index;
		$statistiques_[$i]['position'] = $i;
		$statistiques_[$i]['context'] = $_REQUEST['localisation'];
		$statistiques_[$i]['routine'] = $routine;
		$statistiques_[$i]['time'] = microtime_chrono();
		$statistiques_[$i]['memory'] = memory_get_usage();
		$statistiques_[$i]['SQL_err'] = 0;
		$statistiques_[$i]['SQL_queries'] = 0;
	}
}

if (isset($_REQUEST['GAL_debug'])) {
	error_reporting(E_ERROR | E_WARNING | E_PARSE);							// http://fr2.php.net/error_reporting
	ini_set('log_errors', "On");
	ini_set('error_log', "/var/log/apache2/php_err.log");

	$_REQUEST['src'] = "../../../websites-datas/www.rootwave.net/data/document/fra_gallerie_dessin_peinture_p01/001-2.jpg";
	$_REQUEST['m'] = 1;
	$_REQUEST['x'] = 128;
	$_REQUEST['y'] = 128;
	$_REQUEST['l'] = 3;
	$_REQUEST['q'] = 40;
	$_REQUEST['t'] = ".thumb";
	$_REQUEST['fc'] = "site_3_config_mwm.php";
	//$_REQUEST['n'] = "1";
	$_REQUEST['debug'] = 1;
	echo ("
	<html>
	<head>
	</head>
	<body>
	");
}

// --------------------------------------------------------------------------------------------
// Systeme d'attente des processus en parallele.
// Parralel process waiting system

$pv['ticket_valide'] = 0;
$pv['compteur'] = 1;
while ($pv['ticket_valide'] == 0 && $pv['compteur'] < 100) {
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], "SELECT * FROM " . $SQL_tab_abrege['pv'] . " WHERE pv_name = 'galerie_ticket';");
	while ($dbp = fetch_array_sql($dbquery)) {
		$_REQUEST['n_comp'] = $dbp['pv_number'];
	}
	if ($_REQUEST['n_comp'] ==  $_REQUEST['n']) {
		$pv['ticket_valide'] = 1;
	} else {
		usleep(100000);
	}
	$pv['compteur']++;
}
//exit(0);

// --------------------------------------------------------------------------------------------
// GO
if ($pv['echec'] < 100) {

	$GAL_['X_par_defaut'] = $_REQUEST['x'] = 128;
	$GAL_['Y_par_defaut'] = $_REQUEST['y'] = 128;

	/*
	Charger depuis l URL pour peupler $GAL. Revoir les nom de variable. X_par_defaut hein?
	[extension_config] => Array
	(
	[mode] => 1
	[x] => 128
	[y] => 128
	[liserai] => 5
	[qualite] => 40
	[table_colonnes] => 3
	[table_lignes] => 3
	[fichier_tag] => thumb_
	)*/






	$GAL_['fichier_extenssion'] = substr($_REQUEST['src'], strlen($_REQUEST['src']) - 4, 4);
	switch ($GAL_['fichier_extenssion']) {
		case ".jpg":
			$GAL_['src_image'] = imagecreatefromjpeg($_REQUEST['src']);
			break;
		case ".gif":
			$GAL_['src_image'] = imagecreatefromgif($_REQUEST['src']);
			break;
		case ".bmp":
			$GAL_['src_image'] = imagecreatefromwbmp($_REQUEST['src']);
			break;
		case "jpeg":
			$GAL_['src_image'] = imagecreatefromjpeg($_REQUEST['src']);
			break;
		case ".png":
			$GAL_['src_image'] = imagecreatefrompng($_REQUEST['src']);
			break;
		default:
			$GAL_['thumbnail_temp'] = imagecreatetruecolor($GAL_['X_par_defaut'], $GAL_['Y_par_defaut']);
			$GAL_['bg'] = imagecolorallocate($GAL_['thumbnail_temp'], 255, 255, 255);
			imagefilledrectangle($GAL_['thumbnail_temp'], 0, 0, $GAL_['X_par_defaut'], $GAL_['Y_par_defaut'], $GAL_['bg']);
			$GAL_['textcolor'] = imagecolorallocate($GAL_['thumbnail_temp'], 0, 0, 0);
			imagestring($GAL_['thumbnail_temp'], 5, ($GAL_['X_par_defaut'] / 2) - 4, ($GAL_['Y_par_defaut'] / 2) - 4, "?", $GAL_['textcolor']);
			$GAL_['textcolor'] = imagecolorallocate($GAL_['thumbnail_temp'], 255, 0, 0);
			imagestring($GAL_['thumbnail_temp'], 5, ($GAL_['X_par_defaut'] / 2) - 5, ($GAL_['Y_par_defaut'] / 2) - 5, "?", $GAL_['textcolor']);
			imageJPEG($GAL_['thumbnail_temp'], '', 100);
			exit(0);
	}

	$GAL_['src_X'] = imagesx($GAL_['src_image']);
	$GAL_['src_Y'] = imagesy($GAL_['src_image']);

	/*
	$GAL_['dest_X'] = $GAL_['X_par_defaut'] - ($_REQUEST['l'] * 2);
	if ( isset($_REQUEST['x'])) { $GAL_['dest_X'] = $_REQUEST['x'] - ($_REQUEST['l'] * 2); }
	$GAL_['taille_totale_vignette_X'] = $_REQUEST['x']; 
	$GAL_['taille_totale_vignette_Y'] = floor ( $GAL_['src_Y'] / ($GAL_['src_X'] / $GAL_['dest_X']) );
	$GAL_['dest_Y'] = $GAL_['taille_totale_vignette_Y'] - ($_REQUEST['l'] * 2);
	*/

	$GAL_['SrcCoef'] = ($GAL_['src_X'] / $GAL_['src_Y']);
	$GAL_['MaxCoef'] = ($_REQUEST['x'] / $_REQUEST['y']);
	if ($GAL_['MaxCoef'] <= $GAL_['SrcCoef']) {
		$GAL_['taille_totale_vignette_X'] = $_REQUEST['x'];
		$GAL_['dest_X'] = $GAL_['taille_totale_vignette_X'] - ($_REQUEST['l'] * 2);
		$GAL_['taille_totale_vignette_Y'] = floor($_REQUEST['x'] * ($GAL_['src_Y'] / $GAL_['src_X']));
		$GAL_['dest_Y'] = $GAL_['taille_totale_vignette_Y'] - ($_REQUEST['l'] * 2);
	} else {
		$GAL_['taille_totale_vignette_X'] = floor($_REQUEST['y'] * ($GAL_['src_X'] / $GAL_['src_Y']));
		$GAL_['dest_X'] = $GAL_['taille_totale_vignette_X'] - ($_REQUEST['l'] * 2);
		$GAL_['taille_totale_vignette_Y'] = $_REQUEST['y'];
		$GAL_['dest_Y'] = $GAL_['taille_totale_vignette_Y'] - ($_REQUEST['l'] * 2);
	}

	// --------------------------------------------------------------------------------------------
	//	cherche si un cache existe et l'affiche. si aucun n'est trouvé reprend le mode dynamique
	// --------------------------------------------------------------------------------------------
	if ($_REQUEST['m'] != 0) {
		switch ($_REQUEST['m']) {
			case "2":
				$GAL_['fichier_vignette'] = $_REQUEST['src'] . $_REQUEST['t'];
				if (file_exists($GAL_['fichier_vignette'])) {
					readfile($GAL_['fichier_vignette']);
				} else {
					$_REQUEST['m'] = 0;
					$GAL_['action'] = "SAUVEGARDE_FICHIER";
				}
				break;

				// --------------------------------------------------------------------------------------------
			case "1":
				$SQL_tab_abrege['galerie'] = $db_['tabprefix'] . "galerie";
				$GAL_['taille_vignette_cible'] = $GAL_['dest_X'] . "x" . $GAL_['dest_Y'];													// Constitue l'expression scripturale de la taille
				$dbquery = requete_sql($_REQUEST['sql_initiateur'], "SELECT * FROM " . $SQL_tab_abrege['galerie'] . " WHERE gal_fichier = '" . $_REQUEST['src'] . "';");
				$debug_info[] = "taille_vignette_cible = " . $GAL_['taille_vignette_cible'];
				if (num_row_sql($dbquery) != 0) {																							// Controle qu'il y a bien un contenu
					while ($dbp = fetch_array_sql($dbquery)) {																				// Demarre la lecture des données
						if ($dbp['gal_taille'] != $GAL_['taille_vignette_cible']) {														// on regarde sur le thumbnail est a la bonne taille
							requete_sql($_REQUEST['sql_initiateur'], "DELETE FROM " . $SQL_tab_abrege['galerie'] . " WHERE gal_id = '" . $dbp['gal_id'] . "';");
							$debug_info[] = "DELETE FROM " . $SQL_tab_abrege['galerie'] . " WHERE gal_id = '" . $dbp['gal_id'] . "';";
							$_REQUEST['m'] = 0;
							$GAL_['action'] = "DB_INSERT";																// reprise du mode dynamique pour remplacement
						} else {
							$GAL_['binaryThumbnail'] = $dbp['gal_data'];																	// Nom de fichier et taille ok; affichage
							$debug_info[] = "Chargement image effectue";
						}
					}
				} else {
					$_REQUEST['m'] = 0;
					$GAL_['action'] = "DB_INSERT";
				}																	// Pas de contenu on passe en mode dynamique et stockage
				break;
		}
	}

	if ($_REQUEST['m'] == 0) {
		$GAL_['qualite'] = "40";
		if (isset($_REQUEST['q'])) {
			$GAL_['qualite'] = $_REQUEST['q'];
		}
		$GAL_['thumbnail_temp'] = imagecreatetruecolor($GAL_['taille_totale_vignette_X'], $GAL_['taille_totale_vignette_Y']);
		$GAL_['bg'] = imagecolorallocate($GAL_['thumbnail_temp'], 255, 255, 255);
		imagefilledrectangle($GAL_['thumbnail_temp'], 0, 0, $GAL_['taille_totale_vignette_X'], $GAL_['taille_totale_vignette_Y'], $GAL_['bg']);
		imagecopyresampled($GAL_['thumbnail_temp'], $GAL_['src_image'], $_REQUEST['l'], $_REQUEST['l'], 0, 0, $GAL_['dest_X'], $GAL_['dest_Y'], $GAL_['src_X'], $GAL_['src_Y']);
		ob_start();
		imageJPEG($GAL_['thumbnail_temp'], '', $GAL_['qualite']);
		$GAL_['binaryThumbnail'] = ob_get_contents();
		ob_end_clean();
	}

	// --------------------------------------------------------------------------------------------
	//	Affichage
	// --------------------------------------------------------------------------------------------
	header("Content-Type: image/jpeg");
	if ($_REQUEST['debug'] == 1) {
		error_reporting(E_ERROR | E_WARNING | E_PARSE);							// http://fr2.php.net/error_reporting
		ini_set('log_errors', "On");
		ini_set('error_log', "/var/log/apache2/php_err.log");

		$GAL_['Debug_x'] = 1024;
		$GAL_['Debug_y'] = 128;
		$debug_info[] = "GAL_action = " . $GAL_['action'];
		$debug_info[] = "x =" . $_REQUEST['x'] . "y =" . $_REQUEST['y'] . " - l =" . $_REQUEST['l'] . " - q =" . $_REQUEST['q'] . " - t =" . $_REQUEST['t'] . " - fc =" . $_REQUEST['fc'];

		$GAL_['DEBUG_thumbnail'] = imagecreatetruecolor($GAL_['Debug_x'], $GAL_['Debug_y']);
		$GAL_['bg'] = imagecolorallocate($GAL_['DEBUG_thumbnail'], 255, 255, 255);
		imagefilledrectangle($GAL_['DEBUG_thumbnail'], 0, 0, $GAL_['Debug_x'], $GAL_['Debug_y'], $GAL_['bg']);
		$GAL_['textcolor'] = imagecolorallocate($GAL_['DEBUG_thumbnail'], 0, 0, 0);

		$debug_info[] = "SELECT gal_id FROM " . $SQL_tab_abrege['galerie'] . " ORDER BY gal_id DESC LIMIT 1;";
		$dbquery = requete_sql($_REQUEST['sql_initiateur'], "SELECT gal_id FROM " . $SQL_tab_abrege['galerie'] . " ORDER BY gal_id DESC LIMIT 1;");
		while ($dbp = fetch_array_sql($dbquery)) {
			$debug_info[] = "Gal_id =" . $dbp['gal_id'] + 1;
		}
		$GAL_['vignette_taille'] = $GAL_['dest_X'] . "x" . $GAL_['dest_Y'];
		$gal_debug_line = 0;
		foreach ($debug_info as $A) {
			imagestring($GAL_['DEBUG_thumbnail'], 1, 2, 2 + (12 * $gal_debug_line), $A, $GAL_['textcolor']);
			$gal_debug_line++;
		}
		imageJPEG($GAL_['DEBUG_thumbnail'], '', 100);
		echo $GAL_['DEBUG_thumbnail'];
	} else {
		if ($_REQUEST['GAL_debug'] == 1) {
			echo addslashes($GAL_['binaryThumbnail']) . "</body></html>";
		} else {
			echo $GAL_['binaryThumbnail'];
		}
	}

	// --------------------------------------------------------------------------------------------
	//	Action post affichage
	// --------------------------------------------------------------------------------------------
	switch ($GAL_['action']) {
		case "DB_INSERT":
			$GAL_['id_count'] = 1;
			$dbquery = requete_sql($_REQUEST['sql_initiateur'], "SELECT gal_id FROM " . $SQL_tab_abrege['galerie'] . " ORDER BY gal_id DESC LIMIT 1;");
			while ($dbp = fetch_array_sql($dbquery)) {
				$GAL_['id_count'] = $dbp['gal_id'] + 1;
			}
			$GAL_['db_Thumbnail'] = addslashes($GAL_['binaryThumbnail']);
			$GAL_['vignette_taille'] = $GAL_['dest_X'] . "x" . $GAL_['dest_Y'];
			$GAL_['temp_rendu'] = microtime_chrono() - $GAL_['temp_debut'];
			$dbquery = requete_sql($_REQUEST['sql_initiateur'], "INSERT INTO " . $SQL_tab_abrege['galerie'] . " VALUES ('" . $GAL_['id_count'] . "','" . $_REQUEST['src'] . "','" . $GAL_['vignette_taille'] . "','" . mktime() . "','" . $GAL_['temp_rendu'] . "','" . $GAL_['db_Thumbnail'] . "');");
			$dbquery = requete_sql($_REQUEST['sql_initiateur'], "FLUSH TABLES;");
			break;
		case "SAUVEGARDE_FICHIER":
			imageJPEG($GAL_['thumbnail_temp'], $GAL_['fichier_vignette'], $GAL_['qualite']);
			break;
	}
}

$_REQUEST['n']++;
$dbquery = requete_sql($_REQUEST['sql_initiateur'], "UPDATE " . $SQL_tab['pv'] . " SET pv_number = '" . $_REQUEST['n'] . "' WHERE pv_name = 'galerie_ticket';");
$db->close();

unset(
	$dbquery,
	$dbp,
	$debug_info,
	$GAL_
);
