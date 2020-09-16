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
$ligne++;
$tampon_commande_buffer[$ligne] = "
update user	login \"".$_REQUEST['M_UTILIS']['login']."\"	";	

$_REQUEST['M_UTILIS']['upload_avatar_err'] = 0;
$pv['au'] = "MU_avatar_upload";
if ( is_uploaded_file($_FILES[$pv['au']]['tmp_name']) ) {
	if ( $_FILES[$pv['au']]['error'] ) {
		switch ($_FILES[$pv['au']]['error']){
		case 1: // UPLOAD_ERR_INI_SIZE
		case 2: // UPLOAD_ERR_FORM_SIZE
		case 3: // UPLOAD_ERR_PARTIAL
		case 4: // UPLOAD_ERR_NO_FILE
		$_REQUEST['M_UTILIS']['upload_avatar_err'] = 1;
		$_REQUEST['M_UTILIS']['upload_avatar_err_type'] = $_FILES[$pv['au']]['error'];
		break;
		}
	}
	else {
		$pv['au_extension_autorisees'] = array('jpeg', 'jpg', 'gif' , 'png');
		$pv['au_fichier_original'] = $_FILES[$pv['au']]['name'];
		$pv['au_chemin'] = pathinfo( $pv['au_fichier_original'] );
		$pv['au_extension'] = $pv['au_chemin']['extension'];
		if (!(in_array( $pv['au_extension'] , $pv['au_extension_autorisees'] ) ) ) { 
			$_REQUEST['M_UTILIS']['upload_avatar_err'] = 1; 
			$_REQUEST['M_UTILIS']['upload_avatar_err_type'] = "Extenssion_interdite";
		}

		else {
			$pv['au_nom_dest'] = $_REQUEST['M_UTILIS']['login']. '_avatar_'.date("YmdHis"). "." .$pv['au_extension'];
			$pv['au_rep_dest'] = dirname( "../websites-datas/".$WebSiteObj->getWebSiteEntry('sw_repertoire')."/data/images/avatars/uploaded/." ). "/";
			move_uploaded_file($_FILES[$pv['au']]['tmp_name'], $pv['au_rep_dest'].$pv['au_nom_dest'] );
			$tampon_commande_buffer[$ligne] .= "	image_avatar \"".$pv['au_rep_dest'].$pv['au_nom_dest']."\"\n"; 

			$repertoire_liste_fichier = array();
			$handle = opendir("../websites-datas/".$WebSiteObj->getWebSiteEntry('sw_repertoire')."/data/images/avatars/uploaded/");
			while (false !== ($file = readdir($handle))) {
				if ( $file != "." && $file != ".." && strpos($file, $_REQUEST['M_UTILIS']['login'] ) !== false ) { $repertoire_liste_fichier[] = $file; }
			}
			closedir($handle);
			rsort ($repertoire_liste_fichier);
			reset ($repertoire_liste_fichier);
			$pv['au_count'] = 1;
			foreach ( $repertoire_liste_fichier as $A ) {
				$pv['au_count']++;
				if ( $pv['au_count'] > 3 ) { unlink ("../websites-datas/".$WebSiteObj->getWebSiteEntry('sw_repertoire')."/data/images/avatars/uploaded/".$A); }
			}
			unset (
			$handle,
			$repertoire_liste_fichier,
			$file,
			$A
			);
		}
	}
}
else {
	if ( strlen($_REQUEST['M_UTILIS']['image_avatar']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "	image_avatar				\"".$_REQUEST['M_UTILIS']['image_avatar']."\"\n"; }
}


if ( isset($_REQUEST['M_UTILIS']['status']) )							{ $tampon_commande_buffer[$ligne] .= "status							\"".$_REQUEST['M_UTILIS']['status'].							"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['role_fonction']) )					{ $tampon_commande_buffer[$ligne] .= "role_function						\"".$_REQUEST['M_UTILIS']['role_fonction'].						"\"	\n";}
//if ( isset($_REQUEST['M_UTILIS']['droit_tribune']) )					{ $tampon_commande_buffer[$ligne] .= "tribune_access					\"".$_REQUEST['M_UTILIS']['droit_tribune'].						"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['droit_forum']) )						{ $tampon_commande_buffer[$ligne] .= "forum_access						\"".$_REQUEST['M_UTILIS']['droit_forum'].						"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['lang']) )								{ $tampon_commande_buffer[$ligne] .= "lang								\"".$_REQUEST['M_UTILIS']['lang'].								"\"	\n";}

if ( isset($_REQUEST['theme_demande']) )								{ $_REQUEST['M_UTILIS']['pref_theme'] = $_REQUEST['theme_demande']; }
if ( isset($_REQUEST['M_UTILIS']['pref_theme']) )						{ $tampon_commande_buffer[$ligne] .= "pref_theme						\"".$_REQUEST['M_UTILIS']['pref_theme'].						"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_newsletter']) )					{ $tampon_commande_buffer[$ligne] .= "pref_newsletter					\"".$_REQUEST['M_UTILIS']['pref_newsletter'].					"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_montre_email']) )				{ $tampon_commande_buffer[$ligne] .= "pref_show_email					\"".$_REQUEST['M_UTILIS']['pref_montre_email'].					"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_montre_status_online']) )		{ $tampon_commande_buffer[$ligne] .= "pref_show_online_status			\"".$_REQUEST['M_UTILIS']['pref_montre_status_online'].			"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_notification_reponse_forum']))	{ $tampon_commande_buffer[$ligne] .= "pref_notification_forum_answer	\"".$_REQUEST['M_UTILIS']['pref_notification_reponse_forum'].	"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_notification_nouveau_pm']) )		{ $tampon_commande_buffer[$ligne] .= "pref_notification_new_pm			\"".$_REQUEST['M_UTILIS']['pref_notification_nouveau_pm'].		"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_autorise_bbcode']) )				{ $tampon_commande_buffer[$ligne] .= "pref_allow_bbcode					\"".$_REQUEST['M_UTILIS']['pref_autorise_bbcode'].				"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_autorise_html']) )				{ $tampon_commande_buffer[$ligne] .= "pref_allow_html					\"".$_REQUEST['M_UTILIS']['pref_autorise_html'].				"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_autorise_smilies']) )			{ $tampon_commande_buffer[$ligne] .= "pref_allow_smilies				\"".$_REQUEST['M_UTILIS']['pref_autorise_smilies'].				"\"	\n";}

if ( strlen($_REQUEST['M_UTILIS']['user_email']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	email				\"".$_REQUEST['M_UTILIS']['user_email']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['user_msn']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	msn					\"".$_REQUEST['M_UTILIS']['user_msn']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['user_aim']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	aim					\"".$_REQUEST['M_UTILIS']['user_aim']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['user_icq']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	icq					\"".$_REQUEST['M_UTILIS']['user_icq']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['user_yim']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	yim					\"".$_REQUEST['M_UTILIS']['user_yim']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['user_website']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "	website				\"".$_REQUEST['M_UTILIS']['user_website']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['perso_nom']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	perso_name			\"".$_REQUEST['M_UTILIS']['perso_nom']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['perso_pays']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	perso_country		\"".$_REQUEST['M_UTILIS']['perso_pays']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['perso_ville']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	perso_town			\"".$_REQUEST['M_UTILIS']['perso_ville']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['perso_occupation']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "	perso_occupation	\"".$_REQUEST['M_UTILIS']['perso_occupation']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['perso_interet']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "	perso_interest		\"".$_REQUEST['M_UTILIS']['perso_interet']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['admin_commentaire']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "	admin_comment		\"".$_REQUEST['M_UTILIS']['admin_commentaire']."\"\n"; }
?>
