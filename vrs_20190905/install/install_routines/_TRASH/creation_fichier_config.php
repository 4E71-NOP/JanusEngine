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
/*
switch ( $_REQUEST['install_options']['mdp_dans_fichier_de_conf'] ) {
case 1 :	$pv['database_user_password'] = $db_['database_user_password'];	break;
default :	$pv['database_user_password'] = "***PASSWORD***";				break;
}
*/
$pv['configuration'] = "<?php
// --------------------------------------------------------------------------------------------
//
//	MWM - Multi Web Manager
//	Sous licence Creative common
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)2005-∞ Faust MARIA DE AREVALO faust@multiweb-manager.net
//
// --------------------------------------------------------------------------------------------
//	Le nom du site utilisé pour la base de données
//	The name used for the database
//	Gen : ".date("Y-m-d")."
//	===nom du site===

// Vous serrez peut etre obligé de rajouter le préfix de votre compte chez l'hébergeur.
// You may need to insert the 'account prefix' depending on web hosters.
// ex DB = <user>_yourdatabase

\$db_['type']			= \"".$db_['type']."\";
\$db_['host']			= \"".$db_['host']."\";
\$db_['dal']			= \"".$db_['dal']."\";
\$db_['user_login']		= \"".$db_['database_user_login']."\";
\$db_['user_password']	= \"".$db_['database_user_password']."\";
\$db_['dbprefix']		= \"".$db_['dbprefix']."\";
\$db_['tabprefix']		= \"".$db_['tabprefix']."\";

//--------------------------------------------------------------------------------------------
//	Admin_info_debug
\$maid_stats_nombre_de_couleurs = 5;

//--------------------------------------------------------------------------------------------
//	Session maximum time
\$MWM_session_max_time = (60*60*24);

//--------------------------------------------------------------------------------------------
//	websites-datas/00_Hydre/document/fra_presentation_de_l_equipe_p01.php
\$pde_img_aff = 1;
\$pde_img_h = 32;																	//height
\$pde_img_l = 32;																	//width

?>
";


//--------------------------------------------------------------------------------------------
$pv['i'] = 1;
unset ( $A );
reset ( $_REQUEST['liste_repertoire_a_scanner'] );
foreach ( $_REQUEST['liste_repertoire_a_scanner'] as $A ) {
	//$AD[$pv['onglet']][$lt]['3']['cont'] = "aa*" . print_r_html ( $_REQUEST['liste_repertoire_a_scanner'] );
//	if ( $A['nom_repertoire']  != "00_Hydre" && $A['etat'] == "on" ) {
	if ( $A['etat'] == "on" ) {
		$pv['nom_fichier_config'] = $_REQUEST['server_infos']['repertoire_courant'] . "config/actuelle/site_".$pv['i']."_config_mwm.php";
		$pv['htaccess_files'][] = "site_".$pv['i']."_config_mwm.php";
		$pv['configuration_encours'] = str_replace ( "===nom du site===" , $A['nom_repertoire'] , $pv['configuration'] );

		if ( file_exists ( $pv['nom_fichier_config'] ) ) {
			$pv['datation'] = date ( 'Ymd-His' );
			chmod  ( $pv['nom_fichier_config'] , 0777 );
			rename ( $pv['nom_fichier_config'] , "backup_". $pv['datation'] . "_site_".$pv['i']."_config_mwm.php" );
			chmod  ( $pv['nom_fichier_config'] , 0700 );
		}

		$pv['handle'] = fopen( $pv['nom_fichier_config'] , "w" );
		if ( $pv['handle'] != FALSE ) {
			fwrite( $pv['handle'] , $pv['configuration_encours'] );
			fclose( $pv['handle'] );
			chmod  ( $pv['nom_fichier_config'] , 0644 );
			$tl_['eng']['o2l'.$lt.'c1'] = "File : ";			$tl_['fra']['o2l'.$lt.'c1'] = "Le fichier : ";
			$tl_['eng']['o2l'.$lt.'c2'] = "has been saved";		$tl_['fra']['o2l'.$lt.'c2'] = "a &eacute;t&eacute; sauvegard&eacute;.";
			$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'] . $pv['nom_fichier_config'];
			$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
		}
		else {
			$tl_['eng']['o2l'.$lt.'c1'] = "Failed to open / write ";			$tl_['fra']['o2l'.$lt.'c1'] = "Echec a l'ouverture/&eacute;criture de ";
			$tl_['eng']['o2l'.$lt.'c2'] = "You can do it manually by copy/paste the text below in a file named ".$pv['nom_fichier_config']." and upload it on server.<br><br>";
			$tl_['fra']['o2l'.$lt.'c2'] = "Vous pouvez le faire manuellement en recopiant le text ci-dessous dans un fichier nom&eacute; ".$pv['nom_fichier_config']." et de le t&eacute;l&eacute;charger sur le serveur.<br><br>";
			$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'] . $pv['nom_fichier_config'];
			$pv['configuration_encours'] = string_utf8_to_html ( $pv['configuration_encours'] );

//			$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'] . str_replace ( "\n\n" , "<br>" , $pv['configuration_encours'] );
			$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'] . 
			"<textarea cols='70' rows='10' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1 " . $theme_tableau . $_REQUEST['bloc']."_t2'>\r" . 
			$pv['configuration_encours'] . 
			"</textarea>";
		}
		$AD[$pv['onglet']][$lt]['2']['tc'] = 1;
		$ADC['onglet'][$pv['onglet']]['nbr_ligne']++;
		$lt++;
	}
	$pv['i']++;
}

//--------------------------------------------------------------------------------------------
if ( $_REQUEST['form']['creation_htaccess'] == "oui" ) {
	$pv['htaccess_main'] = "
	<files .htaccess>
	order allow,deny
	deny from all
	</files>

	#--------------------- Modules
	<ifModule mod_expires.c>
	ExpiresActive On
	ExpiresDefault A3600
	# 1 année
	<filesMatch \"\.(flv|ico|pdf|avi|mov|ppt|doc|mp3|wmv|wav)$\">
	ExpiresDefault A31536000
	</filesMatch>
	# 8 heures
	<filesMatch \"\.(jpg|jpeg|png|gif|swf)$\">
	ExpiresDefault A28800
	</filesMatch>
	# 1 heure
	<filesMatch \"\.(txt|xml|js|css)$\">
	ExpiresDefault A3600
	</filesMatch>
	</ifModule>

	<ifModule mod_headers.c>
	# 1 année
	<filesMatch \"\.(flv|ico|pdf|avi|mov|ppt|doc|mp3|wmv|wav)$\">
	Header set Cache-Control \"max-age=31536000, public\"
	</filesMatch>
	# 8 heures
	<filesMatch \"\.(jpg|jpeg|png|gif|swf)$\">
	Header set Cache-Control \"max-age=28800, public\"
	</filesMatch>
	# 1 heure
	<filesMatch \"\.(txt|xml|js|css)$\">
	Header set Cache-Control \"max-age=3600\"
	</filesMatch>
	# Pas de cache
	<filesMatch \"\.(html|htm|php|cgi|pl)$\">
	Header set Cache-Control \"max-age=0, private, no-store, no-cache, must-revalidate\"
	</filesMatch>
	</ifModule>

	#--------------------- MWM config
	";

	/*
	ExpiresActive On
	ExpiresDefault \"access plus 2 hours\"

	ExpiresByType image/gif \"access plus 6 hours\"
	ExpiresByType image/jpg \"access plus 6 hours\"
	ExpiresByType image/jpeg \"access plus 6 hours\"
	ExpiresByType image/png \"access plus 6 hours\"
	ExpiresByType text/html \"access plus 5 minutes\"
	ExpiresByType text/javascript \"access plus 5 minutes\"

	<IfModule mod_suphp.c>
		suPHP_ConfigPath /home/texmex/public_html/photo.rootwave.net/wp/php.ini
		<Files php.ini>
			order allow,deny
			deny from all
		</Files>
	</IfModule>
	*/

	unset ( $A );
	foreach ( $pv['htaccess_files'] as $A ) {
		$pv['htaccess_main'] .= "<filesMatch \"".$A."\">
	order allow,deny
	deny from all
	</files>
	";
	}

	$pv['nom_fichier_config'] = $_REQUEST['server_infos']['repertoire_courant'] . "/.htaccess";
	if ( file_exists ( $pv['nom_fichier_config'] ) ) {
		$pv['datation'] = date ( 'Ymd-His' );
		rename ( $pv['nom_fichier_config'] , "backup_". $pv['datation'] . "_htaccess" );
	}

	$pv['handle'] = fopen( $pv['nom_fichier_config'] , "w" );
	if ( $pv['handle'] != FALSE ) {
		fwrite( $pv['handle'] , $pv['htaccess_main'] );
		fclose( $pv['handle'] );
		chmod  ( $pv['nom_fichier_config'] , 0644 );
		$tl_['eng']['o2l'.$lt.'c1'] = "File : ";			$tl_['fra']['o2l'.$lt.'c1'] = "Le fichier : ";
		$tl_['eng']['o2l'.$lt.'c2'] = "has been saved";		$tl_['fra']['o2l'.$lt.'c2'] = "a &eacute;t&eacute; sauvegard&eacute;.";
		$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'] . $pv['nom_fichier_config'];
		$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
	}
	else {
		$tl_['eng']['o2l'.$lt.'c1'] = "Failed to open / write ";			$tl_['fra']['o2l'.$lt.'c1'] = "Echec a l'ouverture /&eacute;criture de ";
		$tl_['eng']['o2l'.$lt.'c2'] = "You can do it manually by copy/paste the text below in a file named the same and upload it on server.<br><br>";
		$tl_['fra']['o2l'.$lt.'c2'] = "Vous pouvez le faire manuellement en recopiant le text ci-dessous dans un fichier nom&eacute; pareil et de le t&eacute;l&eacute;charger sur le serveur.<br><br>";
		$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'] . $pv['nom_fichier_config'];
		$pv['configuration_encours'] = string_utf8_to_html ( $pv['htaccess_main'] );
		$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'] . str_replace ( "\n\n" , "<br>" , $pv['htaccess_main'] );
	}
}


$AD[$pv['onglet']][$lt]['2']['tc'] = 1;
$ADC['onglet'][$pv['onglet']]['nbr_ligne']++;

?>
