<?php
/*MWM-licence*/
// --------------------------------------------------------------------------------------------
//
//	MWM - Multi Web Manager
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@multiweb-manager.net
//
// --------------------------------------------------------------------------------------------
/*MWM-licence-fin*/
// --------------------------------------------------------------------------------------------
/*	2005 07 23 : 00010000020001_p02 debut														*/
/*	Recoit plusieur parametre																	*/
/*		Le repertoire ou il doit chercher les images											*/
/*		Les nombre de thumbnail par page a afficher												*/
/*		La taille max du thumbnail (permettant de calculer l'aspect ratio						*/
// --------------------------------------------------------------------------------------------
/*	Doit etre appellé par un <img src='script.php'>												*/
// --------------------------------------------------------------------------------------------
/*	autre methode pour ancienne version de PHP < 4.0.3											*/
// --------------------------------------------------------------------------------------------
/* $GAL_thumbnail = imagecreate($GAL_dest_X, $GAL_dest_Y); 										*/
/* imagecopyresized($GAL_thumbnail, $src_image,0, 0, 0, 0,$GAL_dest_X,							*/
/*	 $GAL_dest_Y,$GAL_src_X, $GAL_src_Y);			Redimenssione l'image						*/
// --------------------------------------------------------------------------------------------

// --------------------------------------------------------------------------------------------
/* Quand le script stream de la donnée il est dans son environement propre.						*/
/* Il faut lui reapprendre quelque variables.													*/
// --------------------------------------------------------------------------------------------
if ( $teste_moi != 1 ) {
	include ("../../config_web_machine.php");
	mysql_connect($host,$database_user,$database_password);
}

// --------------------------------------------------------------------------------------------
/*	On sait que le fichier existe mais on ne connait pas son type.								*/
// --------------------------------------------------------------------------------------------
/* GIF XPM XBM TGA non supporté par defaut dans le package php-gd-4.3.8-2mdk					*/
/*case ".gif":																					*/
/*	$src_image = imagecreatefromgif("$_REQUEST[src]");	break;									*/
/*	case ".xpm":																				*/
/*		$src_image = imagecreatefromxpm("$_REQUEST[src]"); break;								*/
/*	case ".xbm":																				*/
/*		$src_image = imagecreatefromxbm("$_REQUEST[src]"); break;								*/
/*	case ".tga":																				*/
/*		$src_image = imagecreatefromtga("$_REQUEST[src]"); break;								*/
// --------------------------------------------------------------------------------------------
$GAL_fichier_extenssion = substr ( $_REQUEST[src] , strlen($_REQUEST[src])-4 , 4) ;
switch ($GAL_fichier_extenssion) {
case ".jpg":
	$src_image = imagecreatefromjpeg("$_REQUEST[src]"); break;
case "jpeg":
	$src_image = imagecreatefromjpeg("$_REQUEST[src]"); break;
case ".png":
	$src_image = imagecreatefrompng("$_REQUEST[src]"); break;
default:
	$GAL_thumbnail = imagecreatetruecolor(32, 32);							/* rien de bien bon, on cree un vignette generique.	*/
	$bg = imagecolorallocate($GAL_thumbnail, 255, 255, 255);				/* Un gris pour le fond.							*/
	imagefilledrectangle ($GAL_thumbnail, 0, 0, 32, 32, $bg);
	$textcolor = imagecolorallocate($GAL_thumbnail, 0, 0, 0);				/* Un rouge le texte.								*/
	imagestring($GAL_thumbnail, 5, 16-4 , 7+1 , "?", $textcolor);			/* Un gros point d'interrogation.					*/
	$textcolor = imagecolorallocate($GAL_thumbnail, 255, 0, 0);				/* Un rouge le texte.								*/
	imagestring($GAL_thumbnail, 5, 16-5 , 7 , "?", $textcolor);				/* Un gros point d'interrogation.					*/
	imageJPEG($GAL_thumbnail,'',100);										/* Sortie en JPEG									*/
	mysql_close();															/* Ferme la connexion MySQL pour etre propre.		*/
	exit(0);																/* On a plus rien a faire on se barre vite fait.	*/
}

// --------------------------------------------------------------------------------------------
/*	Determine la taille de la vignette															*/
// --------------------------------------------------------------------------------------------
$GAL_src_X = imagesx($src_image);									/* Trouve la largeur originale du fichier	*/
$GAL_src_Y = imagesy($src_image); 									/* et sa hauteur							*/
$GAL_dest_X = $GAL_X_par_defaut;									/* Valeur defaut si ca foire au calcul		*/
if ( isset($_REQUEST[x])) { $GAL_dest_X = $_REQUEST[x]; }			/* Determine la largeur de la vignette		*/
$GAL_dest_Y = $GAL_X_par_defaut;									/* Valeur defaut si ca foire au calcul		*/
$GAL_dest_Y = $GAL_src_Y / ($GAL_src_X / $GAL_dest_X);

// --------------------------------------------------------------------------------------------
/*	Recherche de vignette deja sauvegardées														*/
// --------------------------------------------------------------------------------------------
if ( $GAL_Dynamique == "OFF" ) {
	if ( $GAL_mode_static_mode == "FICHIER" ) {												/* Methode fichier							*/
		$fichier_vignette = "$_REQUEST[src]" . "$GAL_fichier_tag";							/* Confection du nom de fichier				*/
		if (file_exists($fichier_vignette)) { readfile($fichier_vignette); }				/* Ca renvoi vers STDout ca tombe bien		*/
		else { $GAL_Dynamique = "ON"; $GAL_sauvegarde = 1; }								/* On prepare une sortie en douceur			*/
	}
	else {																					/* Regarde si la vignette demandée n'a pas deja été referencé dans la base		*/
		$table_actuelle_GAL = "$dbprefix.$dbprefix" . "_gallerie";							/* Settings pour la base					*/
		$dbquery_GAL = mysql_query("SELECT * FROM $table_actuelle_GAL WHERE gall_fichier = '$_REQUEST[src]';") or die(mysql_error());
		if(mysql_num_rows($dbquery_GAL) == 0) { $GAL_Dynamique = "ON"; $GAL_insert = 1; }	/* Pas trouvé; On doit faire la vignette	*/
		while ($dbp_GAL = fetch_array_sql($dbquery_GAL)) { 								/* On a, donc on chope tout					*/
			$vignette_id = $dbp_GAL[gall_id];
			$vignette_fichier = $dbp_GAL[gall_fichier];
			$vignette_taille = $dbp_GAL[gall_taille];
			$vignette_date = $dbp_GAL[gall_date];
			$binaryThumbnail = $dbp_GAL[gall_data];
			if ( "$dbp_GAL[gall_taille]" != "$GAL_dest_X" . "x" . "$GAL_dest_Y" ) { $GAL_Dynamique = "ON"; $GAL_insert = 1; }	/* Pas bon; On doit faire la vignette quand meme*/
		}
	}
}

// --------------------------------------------------------------------------------------------
/*	Genere la vignette de l'image																*/
// --------------------------------------------------------------------------------------------
if ( $GAL_Dynamique == "ON" ) {
	$GAL_qualite = $GAL_qualite_par_defaut;								/* Valeur defaut si ca foire au calcul		*/
	if ( isset($_REQUEST[q])) { $GAL_qualite = $_REQUEST[q]; }			/* Détermine la qualité						*/
	$GAL_thumbnail = imagecreatetruecolor($GAL_dest_X, $GAL_dest_Y);	/* Creation de la vignette.					*/
	imagecopyresampled($GAL_thumbnail, $src_image,0, 0, 0, 0,$GAL_dest_X, $GAL_dest_Y,$GAL_src_X, $GAL_src_Y);
	ob_start();															/* Capture de la sortie standart			*/
	imageJPEG($GAL_thumbnail,'',$GAL_qualite);							/* Sortie en JPEG							*/
	$binaryThumbnail = ob_get_contents(); 								/* Capture du buffer STDOUT. L'image		*/
	ob_end_clean();														/* On vire STDOUT							*/
}
echo $binaryThumbnail;													/* On renvoi les données					*/

// --------------------------------------------------------------------------------------------
/* Insertion en base du resultat si la permiere partie n'a pas pus le detecter					*/
// --------------------------------------------------------------------------------------------
if ( $GAL_insert == 1 ) {
	$binaryThumbnail = addslashes($binaryThumbnail);
	$vignette_fichier = $_REQUEST[src];
	$vignette_taille = "$GAL_dest_X" . "x" . "$GAL_dest_Y" ;
	$vignette_date = date("Y-m-d");
	mysql_query("INSERT INTO $table_actuelle_GAL VALUES ('','$vignette_fichier','$vignette_taille','$vignette_date','$binaryThumbnail');");
}

// --------------------------------------------------------------------------------------------
/* Sauvegarde du fichier 																		*/
// --------------------------------------------------------------------------------------------
if ( $GAL_sauvegarde == 1 ) {
	imageJPEG($GAL_thumbnail,$fichier_vignette,$GAL_qualite);
}

mysql_close();
// --------------------------------------------------------------------------------------------
/*	2005 07 23 : 00010000020001_p02 fin															*/
// --------------------------------------------------------------------------------------------

?>