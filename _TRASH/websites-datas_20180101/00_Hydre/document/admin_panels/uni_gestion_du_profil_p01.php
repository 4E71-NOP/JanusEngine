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
$_REQUEST['theme_demande'] = "mwm_aqua_01";

// --------------------------------------------------------------------------------------------
//	fra_gestion_du_profil_p01.php debut
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_RESQUEST['sql_initiateur'] = "uni_gestion_du_profil_p01";

if ( $user['login_decode'] == "anonymous" ) { echo ("Partie reserv&eacute;e aux membres enregistr&eacute;s"); }
else {
// --------------------------------------------------------------------------------------------
//	Debut du formulaire
// --------------------------------------------------------------------------------------------
	$tl_['eng']['modif_profil'] = "Update profile";		$tl_['fra']['modif_profil'] = "Modifier le profil";
	$tl_['eng']['upload_avatar'] = "Upload image";		$tl_['fra']['upload_avatar'] = "T&eacute;l&eacute;charger une image";

	echo ("
	<p>
	Cette Partie permet de modifier les donn&eacute;es de votre profil. Modifiez les champs accessibles puis validez.
	<br>\r
	");

	if ( $_REQUEST['M_UTILIS']['upload_avatar_err'] == 1 ) {
		switch ( $_REQUEST['M_UTILIS']['upload_avatar_err_type'] ) {
		case 1:
		$tl_['eng']['upload_avatar_err'] = "The filesize is exeeding server threshold.";
		$tl_['fra']['upload_avatar_err'] = "Le fichier dépasse la limite autorisée par le serveur.";
		break;
		case 2:
		$tl_['eng']['upload_avatar_err'] = "The filesize is exeeding autorized HTML threshold.";
		$tl_['fra']['upload_avatar_err'] = "Le fichier d&eacute;passe la limite autoris&eacute;e dans le formulaire HTML.";
		break;
		case 3:
		$tl_['eng']['upload_avatar_err'] = "The file transfert has been interrupted.";
		$tl_['fra']['upload_avatar_err'] = "L'envoi du fichier a &eacute;t&eacute; interrompu pendant le transfert.";
		break;
		case 4:
		$tl_['eng']['upload_avatar_err'] = "The submitted filesize is equals to zero.";
		$tl_['fra']['upload_avatar_err'] = "Le fichier que vous avez envoy&eacute; a une taille nulle.";
		break;
		case "Extenssion_interdite":
		$tl_['eng']['upload_avatar_err'] = "Forbidden extenssion for avatar images.";
		$tl_['fra']['upload_avatar_err'] = "Extension interdite pour les images d'avatar.";
		break;
		default:
		$tl_['eng']['upload_avatar_err'] = "Unknown error.";
		$tl_['fra']['upload_avatar_err'] = "Erreur inconnue.";
		break;
		}
		echo ("	<p class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>".$tl_[$l]['upload_avatar_err']."</p>\r<br>\r");
	}

	if ( $_REQUEST['M_UTILIS']['confirmation_modification_oubli'] == 1 ) { 
		$tl_['eng']['confirmation_modification_oubli'] = "You forgot to confirm the profil modification.";
		$tl_['fra']['confirmation_modification_oubli'] = "Vous n'avez pas confirm&eacute; la modification du profil.";
		echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur " . $theme_tableau . $_REQUEST['bloc']."_tb3'>".$tl_[$l]['confirmation_modification_oubli']."</p>\r<br>\r"); 
	}

	echo ("
	<br>\r
	<form enctype='multipart/form-data' ACTION='index.php?' method='post' name='formulaire_GDP'>\r
	");

	if ( $user['pref_theme'] == 0 ) { $user['pref_theme'] = $site_web['theme_id']; }
	$dbquery = requete_sql($_RESQUEST['sql_initiateur'],"
	SELECT a.*,b.theme_nom,b.theme_id
	FROM ".$SQL_tab_abrege['user']." a , ".$SQL_tab_abrege['theme_descripteur']." b 
	WHERE a.user_id = '".$user['id']."' 
	AND theme_id = '".$user['pref_theme']."' 
	;");
	while ($dbp = fetch_array_sql($dbquery)) { foreach ( $dbp as $A => $B ) { $PmListTheme[$A] = $B; } }

// --------------------------------------------------------------------------------------------
//	Informations internet
// --------------------------------------------------------------------------------------------
	$pv['i'] = 1;
	$tl_['eng']['o1_l1'] = "Login";		$tl_['fra']['o1_l1'] = "Identifiant";					$pv['i']++;
	$tl_['eng']['o1_l2'] = "Avatar";	$tl_['fra']['o1_l2'] = "Avatar";						$pv['i']++;
	$tl_['eng']['o1_l3'] = "Upload";	$tl_['fra']['o1_l3'] = "T&eacute;l&eacute;chargement";	$pv['i']++;

	$pv['i'] = 1;
	$tl_['eng']['o2_l1'] = "Email";		$tl_['fra']['o2_l1'] = "Email";					$pv['i']++;
	$tl_['eng']['o2_l2'] = "MSN";		$tl_['fra']['o2_l2'] = "MSN";					$pv['i']++;
	$tl_['eng']['o2_l3'] = "AIM";		$tl_['fra']['o2_l3'] = "AIM";					$pv['i']++;
	$tl_['eng']['o2_l4'] = "ICQ";		$tl_['fra']['o2_l4'] = "ICQ";					$pv['i']++;
	$tl_['eng']['o2_l5'] = "YIM";		$tl_['fra']['o2_l5'] = "YIM";					$pv['i']++;
	$tl_['eng']['o2_l6'] = "Website";	$tl_['fra']['o2_l6'] = "Site Web";				$pv['i']++;

	$pv['i'] = 1;
	$tl_['eng']['o3_l1'] = "Name";			$tl_['fra']['o3_l1'] = "Nom";							$pv['i']++;
	$tl_['eng']['o3_l2'] = "Pays";			$tl_['fra']['o3_l2'] = "Pays";							$pv['i']++;
	$tl_['eng']['o3_l3'] = "Town";			$tl_['fra']['o3_l3'] = "Ville";							$pv['i']++;
	$tl_['eng']['o3_l4'] = "Occupation";	$tl_['fra']['o3_l4'] = "Occupation";					$pv['i']++;
	$tl_['eng']['o3_l5'] = "Interest";		$tl_['fra']['o3_l5'] = "Sujets d'int&eacute;r&ecirc;t";	$pv['i']++;

	$pv['i'] = 1;
	$tl_['eng']['o4_l1'] = "Get the newletter";					$tl_['fra']['o4_l1'] = "Recevoir la newsletter";						$pv['i']++;
	$tl_['eng']['o4_l2'] = "Show email to the public";			$tl_['fra']['o4_l2'] = "Montrer l'E-mail au public";					$pv['i']++;
	$tl_['eng']['o4_l3'] = "Show Online status";				$tl_['fra']['o4_l3'] = "Montrer le status 'En ligne'";					$pv['i']++;
	$tl_['eng']['o4_l4'] = "Be notified by the forum";			$tl_['fra']['o4_l4'] = "Recevoir une notification des forums";			$pv['i']++;
	$tl_['eng']['o4_l5'] = "Be notified on private message";	$tl_['fra']['o4_l5'] = "Recevoir une notification de la messagerie priv&eacute;e";	$pv['i']++;
	$tl_['eng']['o4_l6'] = "Allow BBcode";						$tl_['fra']['o4_l6'] = "Autorise le BBcode";					$pv['i']++;
	$tl_['eng']['o4_l7'] = "Allow HTML";						$tl_['fra']['o4_l7'] = "Autorise le HTML";						$pv['i']++;
	$tl_['eng']['o4_l8'] = "Allow smileys";						$tl_['fra']['o4_l8'] = "Autorise les smileys";					$pv['i']++;
	$tl_['eng']['o4_l9'] = "Language";							$tl_['fra']['o4_l9'] = "Langue";								$pv['i']++;

// --------------------------------------------------------------------------------------------

$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_GDP";
$fsi['champs']					= "M_UTILIS[image_avatar]";
$fsi['lsdf_chemin']				= "../websites-datas/".$site_web['sw_repertoire']."/data/images/avatars/public";
$fsi['mode_selection']			= "fichier";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 10;
$fsi['lsdf_indicatif']			= "SDFGDPP1";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 1;
$fsi['lsdf_conserve_chemin']	= "/mnt/Espace_Developpement/Developpement_Web/MWM/Package/mwm/websites-datas/".$site_web['sw_repertoire']."/data/images/avatars/public/";
$fsi['lsdf_coupe_repertoire']	= 0;
$fsi['liste_fichier']			= array();

	$AD['1']['1']['1']['cont'] = $tl_[$l]['o1_l1'];
	$AD['1']['2']['1']['cont'] = $tl_[$l]['o1_l2'];
	$AD['1']['3']['1']['cont'] = $tl_[$l]['o1_l3'];

	$AD['1']['1']['2']['cont'] = "<input type='text' name='M_UTILIS[login]' value='".$PmListTheme['user_login']."' size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'> (ne sera pas modifi&eacute;)";
	
	if ( strlen($PmListTheme['user_image_avatar']) != 1024 ) { $AD['1']['2']['2']['cont'] = "<img src='".$PmListTheme['user_image_avatar']."' width='48' height='48' alt='[Avatar]'>"; }
	else { $AD['1']['2']['2']['cont'] = "N/A"; }
	$AD['1']['2']['2']['cont'] .= generation_icone_selecteur_fichier ( 3 , $fsi['formulaire'] , $fsi['champs'] , 20 , "", "TabSDF_".$fsi['lsdf_indicatif'] );
	$AD['1']['3']['2']['cont'] = "<input type='hidden' name='MAX_FILE_SIZE' value='32768'> 
	<input type='file' name='M_UTILIS_avatar_upload' size='40' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";

// --------------------------------------------------------------------------------------------
	$AD['2']['1']['1']['cont'] = $tl_[$l]['o2_l1'];
	$AD['2']['2']['1']['cont'] = $tl_[$l]['o2_l2'];
	$AD['2']['3']['1']['cont'] = $tl_[$l]['o2_l3'];
	$AD['2']['4']['1']['cont'] = $tl_[$l]['o2_l4'];
	$AD['2']['5']['1']['cont'] = $tl_[$l]['o2_l5'];
	$AD['2']['6']['1']['cont'] = $tl_[$l]['o2_l6'];

	$AD['2']['1']['2']['cont'] = "<input type='text' name='M_UTILIS[user_email]' value='".$PmListTheme['user_email']."' size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
	$AD['2']['2']['2']['cont'] = "<input type='text' name='M_UTILIS[user_msn]' value='".$PmListTheme['user_msn']."' size='30' maxlength='25' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
	$AD['2']['3']['2']['cont'] = "<input type='text' name='M_UTILIS[user_aim]' value='".$PmListTheme['user_aim']."' size='30' maxlength='18' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
	$AD['2']['4']['2']['cont'] = "<input type='text' name='M_UTILIS[user_icq]' value='".$PmListTheme['user_icq']."' size='30' maxlength='15' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
	$AD['2']['5']['2']['cont'] = "<input type='text' name='M_UTILIS[user_yim]' value='".$PmListTheme['user_yim']."' size='30' maxlength='25' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
	$AD['2']['6']['2']['cont'] = "<input type='text' name='M_UTILIS[user_website]' value='".$PmListTheme['user_website']."' size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";


// --------------------------------------------------------------------------------------------
	$AD['3']['1']['1']['cont'] = $tl_[$l]['o3_l1'];
	$AD['3']['2']['1']['cont'] = $tl_[$l]['o3_l2'];
	$AD['3']['3']['1']['cont'] = $tl_[$l]['o3_l3'];
	$AD['3']['4']['1']['cont'] = $tl_[$l]['o3_l4'];
	$AD['3']['5']['1']['cont'] = $tl_[$l]['o3_l5'];

	$AD['3']['1']['2']['cont'] = "<input type='text' name='M_UTILIS[perso_nom]' value='".$PmListTheme['user_perso_nom']."' size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
	$AD['3']['2']['2']['cont'] = "<input type='text' name='M_UTILIS[perso_pays]' value='".$PmListTheme['user_perso_pays']."' size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
	$AD['3']['3']['2']['cont'] = "<input type='text' name='M_UTILIS[perso_ville]' value='".$PmListTheme['user_perso_ville']."' size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
	$AD['3']['4']['2']['cont'] = "<input type='text' name='M_UTILIS[perso_occupation]' value='".$PmListTheme['user_perso_occupation']."' size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
	$AD['3']['5']['2']['cont'] = "<input type='text' name='M_UTILIS[perso_interet]' value='".$PmListTheme['user_perso_interet']."' size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
// --------------------------------------------------------------------------------------------
/*	$tab_select_1['0'] = "";
	$tab_select_1['1'] = " selected ";
*/
	$tab_select_2['0'] = "Non";
	$tab_select_2['1'] = "Oui";


	$AD['4']['1']['1']['cont'] = $tl_[$l]['o4_l1'];
	$AD['4']['2']['1']['cont'] = $tl_[$l]['o4_l2'];
	$AD['4']['3']['1']['cont'] = $tl_[$l]['o4_l3'];
	$AD['4']['4']['1']['cont'] = $tl_[$l]['o4_l4'];
	$AD['4']['5']['1']['cont'] = $tl_[$l]['o4_l5'];
	$AD['4']['6']['1']['cont'] = $tl_[$l]['o4_l6'];
	$AD['4']['7']['1']['cont'] = $tl_[$l]['o4_l7'];
	$AD['4']['8']['1']['cont'] = $tl_[$l]['o4_l8'];
	$AD['4']['9']['1']['cont'] = $tl_[$l]['o4_l9'];

	$pv['TableSelectOptions']['0']['t1'] = "<option value='0' ";
	$pv['TableSelectOptions']['0']['t2'] = ">".$tab_select_2['0']."</option>\r";
	$pv['TableSelectOptions']['1']['t1'] = "<option value='0' ";
	$pv['TableSelectOptions']['1']['t2'] = ">".$tab_select_2['1']."</option>\r";

	$pv['TableSelectOptions']['0']['s'] = $pv['TableSelectOptions']['1']['s'] = "";
	$pv['TableSelectOptions'][$PmListTheme['user_pref_newsletter']]['s'] = "selected";
	$AD['4']['1']['2']['cont'] = "<select name='M_UTILIS[pref_newsletter]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
	".
	$pv['TableSelectOptions']['0']['t1'] . $pv['TableSelectOptions']['0']['s'] . $pv['TableSelectOptions']['0']['t2'] . 
	$pv['TableSelectOptions']['1']['t1'] . $pv['TableSelectOptions']['1']['s'] . $pv['TableSelectOptions']['1']['t2'] .
	"</select>\r";

	$pv['TableSelectOptions']['0']['s'] = $pv['TableSelectOptions']['1']['s'] = "";
	$pv['TableSelectOptions'][$PmListTheme['user_pref_montre_email']]['s'] = "selected";
	$AD['4']['2']['2']['cont'] = "<select name='M_UTILIS[pref_montre_email]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r 
	".
	$pv['TableSelectOptions']['0']['t1'] . $pv['TableSelectOptions']['0']['s'] . $pv['TableSelectOptions']['0']['t2'] . 
	$pv['TableSelectOptions']['1']['t1'] . $pv['TableSelectOptions']['1']['s'] . $pv['TableSelectOptions']['1']['t2'] .
	"</select>\r";

	$pv['TableSelectOptions']['0']['s'] = $pv['TableSelectOptions']['1']['s'] = "";
	$pv['TableSelectOptions'][$PmListTheme['user_pref_montre_status_online']]['s'] = "selected";
	$AD['4']['3']['2']['cont'] = "<select name='M_UTILIS[pref_montre_status_online]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r 
	".
	$pv['TableSelectOptions']['0']['t1'] . $pv['TableSelectOptions']['0']['s'] . $pv['TableSelectOptions']['0']['t2'] . 
	$pv['TableSelectOptions']['1']['t1'] . $pv['TableSelectOptions']['1']['s'] . $pv['TableSelectOptions']['1']['t2'] .
	"</select>\r";

	$pv['TableSelectOptions']['0']['s'] = $pv['TableSelectOptions']['1']['s'] = "";
	$pv['TableSelectOptions'][$PmListTheme['user_pref_notification_reponse_forum']]['s'] = "selected";
	$AD['4']['4']['2']['cont'] = "<select name='M_UTILIS[pref_notification_reponse_forum]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
	".
	$pv['TableSelectOptions']['0']['t1'] . $pv['TableSelectOptions']['0']['s'] . $pv['TableSelectOptions']['0']['t2'] . 
	$pv['TableSelectOptions']['1']['t1'] . $pv['TableSelectOptions']['1']['s'] . $pv['TableSelectOptions']['1']['t2'] .
	"</select>\r";

	$pv['TableSelectOptions']['0']['s'] = $pv['TableSelectOptions']['1']['s'] = "";
	$pv['TableSelectOptions'][$PmListTheme['user_pref_notification_nouveau_pm']]['s'] = "selected";
	$AD['4']['5']['2']['cont'] = "<select name='M_UTILIS[pref_notification_nouveau_pm]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
	".
	$pv['TableSelectOptions']['0']['t1'] . $pv['TableSelectOptions']['0']['s'] . $pv['TableSelectOptions']['0']['t2'] . 
	$pv['TableSelectOptions']['1']['t1'] . $pv['TableSelectOptions']['1']['s'] . $pv['TableSelectOptions']['1']['t2'] .
	"</select>\r";

	$pv['TableSelectOptions']['0']['s'] = $pv['TableSelectOptions']['1']['s'] = "";
	$pv['TableSelectOptions'][$PmListTheme['user_pref_autorise_bbcode']]['s'] = "selected";
	$AD['4']['6']['2']['cont'] = "<select name='M_UTILIS[pref_autorise_bbcode]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r 
	".
	$pv['TableSelectOptions']['0']['t1'] . $pv['TableSelectOptions']['0']['s'] . $pv['TableSelectOptions']['0']['t2'] . 
	$pv['TableSelectOptions']['1']['t1'] . $pv['TableSelectOptions']['1']['s'] . $pv['TableSelectOptions']['1']['t2'] .
	"</select>\r";

	$pv['TableSelectOptions']['0']['s'] = $pv['TableSelectOptions']['1']['s'] = "";
	$pv['TableSelectOptions'][$PmListTheme['user_pref_autorise_html']]['s'] = "selected";
	$AD['4']['7']['2']['cont'] = "<select name='M_UTILIS[pref_autorise_html]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
	".
	$pv['TableSelectOptions']['0']['t1'] . $pv['TableSelectOptions']['0']['s'] . $pv['TableSelectOptions']['0']['t2'] . 
	$pv['TableSelectOptions']['1']['t1'] . $pv['TableSelectOptions']['1']['s'] . $pv['TableSelectOptions']['1']['t2'] .
	"</select>\r";

	$pv['TableSelectOptions']['0']['s'] = $pv['TableSelectOptions']['1']['s'] = "";
	$pv['TableSelectOptions'][$PmListTheme['user_pref_autorise_smilies']]['s'] = "selected";
	$AD['4']['8']['2']['cont'] = "<select name='M_UTILIS[pref_autorise_smilies]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
	".
	$pv['TableSelectOptions']['0']['t1'] . $pv['TableSelectOptions']['0']['s'] . $pv['TableSelectOptions']['0']['t2'] . 
	$pv['TableSelectOptions']['1']['t1'] . $pv['TableSelectOptions']['1']['s'] . $pv['TableSelectOptions']['1']['t2'] .
	"</select>\r";


	$AD['4']['9']['2']['cont'] = "<select name='M_UTILIS[lang]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	$dbqueryL = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT sl.lang_id FROM ".$SQL_tab_abrege['site_langue']." sl , ".$SQL_tab_abrege['site_web']." s 
	WHERE s.sw_id ='".$site_web['sw_id']."' 
	AND sl.site_id = s.sw_id
	;");
	while ($dbpL = fetch_array_sql($dbqueryL)) { $langues[$dbpL['lang_id']]['support'] = 1; }
	if ( $PmListTheme['user_lang'] == 0 ) { $langues[$site_web['sw_lang']]['s'] = " selected "; }
	else { $langues[$PmListTheme['user_lang']]['s'] = " selected "; }
	foreach ( $langues as $A ) { 
		if ( $A['support'] == 1 ) {
			$AD['4']['9']['2']['cont'] .= "<option value='".$A['langue_639_3']."' ".$A['s']."> ".$A['langue_nom_original']." </option>\r"; 
		}
	}
	$AD['4']['9']['2']['cont'] .= "</select>\r";

	$ADC['onglet']['1']['nbr_ligne'] = 3;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;
	$ADC['onglet']['2']['nbr_ligne'] = 6;	$ADC['onglet']['2']['nbr_cellule'] = 2;	$ADC['onglet']['2']['legende'] = 2;
	$ADC['onglet']['3']['nbr_ligne'] = 5;	$ADC['onglet']['3']['nbr_cellule'] = 2;	$ADC['onglet']['3']['legende'] = 2;
	$ADC['onglet']['4']['nbr_ligne'] = 9;	$ADC['onglet']['4']['nbr_cellule'] = 2;	$ADC['onglet']['4']['legende'] = 2;

	$tl_['eng']['onglet_1'] = "Profile";		$tl_['fra']['onglet_1'] = "Compte";	
	$tl_['eng']['onglet_2'] = "Internet";		$tl_['fra']['onglet_2'] = "Internet";	
	$tl_['eng']['onglet_3'] = "Perso";			$tl_['fra']['onglet_3'] = "Perso";	
	$tl_['eng']['onglet_4'] = "Preferences";	$tl_['fra']['onglet_4'] = "Pr&eacute;f&eacute;rences";	

// --------------------------------------------------------------------------------------------
	$tab_infos['AffOnglet']			= 1;
	$tab_infos['NbrOnglet']			= 4;
	$tab_infos['tab_comportement']	= 1;
	$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
	$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
	$tab_infos['doc_height']		= 256;
	$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -16 ;
	$tab_infos['groupe']			= "inst1";
	$tab_infos['cell_id']			= "tab";
	$tab_infos['document']			= "doc";
	$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
	$tab_infos['cell_2_txt']		= $tl_[$l]['onglet_2'];
	$tab_infos['cell_3_txt']		= $tl_[$l]['onglet_3'];
	$tab_infos['cell_4_txt']		= $tl_[$l]['onglet_4'];

	$theme_GP_['tab_interieur'] = ${$theme_tableau}['theme_module_largeur_interne'] - 4;
	include ("routines/website/affichage_donnees.php");


	$tl_['eng']['text_confirm1'] = "I confirm the modifications";
	$tl_['fra']['text_confirm1'] = "Je confirme les modifications";
	echo ("
	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto; '>
	<tr>\r
	<td style='width: ".(${$theme_tableau}['theme_module_largeur_interne'] - 200)."px;'>\r
	<input type='checkbox' name='M_UTILIS[confirmation_modification]' checked> ".$tl_[$l]['text_confirm1']."\r
	</td>\r
	<td style='width: 200px;'>\r
	");

	$_REQUEST['BS']['id']				= "bouton_modification_profil";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['modif_profil'];
	$_REQUEST['BS']['mode']				= 0;
	$_REQUEST['BS']['taille'] 			= 0;
	$_REQUEST['BS']['derniere_taille']	= 0;
	echo generation_bouton ();
	echo ("
	</td>\r
	</tr>\r
	</table>\r
	<br>\r
	<br>\r
	<hr>\r

	<input type='hidden' name='M_UTILIS[login]'						value='".$PmListTheme['user_login']."'>\r
	<input type='hidden' name='UPDATE_action'					value='UPDATE_USER'>\r

	<input type='hidden' name='WM_GP_phase' value='1'>\r".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_arti_ref'].
	$bloc_html['post_hidden_arti_page'].
	$bloc_html['post_hidden_user_login'].
	$bloc_html['post_hidden_user_pass']."
	</form>\r
	");

	if ( !isset($_REQUEST['theme_demande']) ) { $_REQUEST['theme_demande'] = ${$theme_tableau}['theme_nom'] ; }

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['theme_descripteur']." a , ".$SQL_tab_abrege['site_theme']." b 
	WHERE a.theme_nom = '".$_REQUEST['theme_demande']."' 
	AND a.theme_id = b.theme_id 
	;");

	$tl_['eng']['text_choix_theme'] = "Theme browser.";	
	$tl_['fra']['text_choix_theme'] = "Choix du theme.";	
	echo ("<p>".$tl_[$l]['text_choix_theme']."<br>\r</p>\r");

	$_REQUEST['sauve']['site_web_sw_stylesheet'] = $site_web['sw_stylesheet'];
	$site_web['sw_stylesheet'] = 1;

	$theme_tableau = "theme_GP_";
	include ("routines/website/charge_donnees_theme_tableau.php");
	$theme_tableau_a_ecrire = "theme_GP_";
	$stylesheet_entete = "";
	include ("routines/website/charge_donnees_theme_stylesheet.php");
	echo ($stylesheet ."\r");

	$site_web['sw_stylesheet'] = $_REQUEST['sauve']['site_web_sw_stylesheet'];

// --------------------------------------------------------------------------------------------
//	Affichage du theme selectionné
// --------------------------------------------------------------------------------------------
//	$tl_['eng']['onglet_1'] = "Block ";		$tl_['fra']['onglet_1'] = "Bloc ";	

	$tab_infos['AffOnglet']			= 1;
	$tab_infos['NbrOnglet']			= 1;
	$tab_infos['tab_comportement']	= 1;
	$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
	$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
	$tab_infos['doc_height']		= 768;
	$tab_infos['groupe']			= "gp_grp2";
	$tab_infos['cell_id']			= "tab";
	$tab_infos['document']			= "doc";

	$pv['i'] = 1;
	for ( $pv['i'] = 1; $pv['i'] < 31; $pv['i']++ ) {
		$pv['bloc_profil'] = "theme_bloc_" . decoration_nomage_bloc ( "", $pv['i'] , "") . "_nom";
		if ( strlen( $theme_GP_[$pv['bloc_profil']] ) > 0 ) { 
			$pv['TabNTheme'][$theme_GP_[$pv['bloc_profil']]]['nom']  = $theme_GP_[$pv['bloc_profil']];
			$pv['TabNTheme'][$theme_GP_[$pv['bloc_profil']]]['pos'] = $pv['i'];
		}
	}

	$tab_infos['NbrOnglet'] = count( $pv['TabNTheme'] ) + 1;

	for ( $pv['i'] = 1; $pv['i'] < $tab_infos['NbrOnglet']+1; $pv['i']++ ) { $tab_infos['cell_'.$pv['i'].'_txt'] = $pv['i']; }

	$pv['save']['bloc'] = $_REQUEST['bloc'];
	$pv['save']['blocG'] = $_REQUEST['blocG'];
	$pv['save']['blocT'] = $_REQUEST['blocT'];
	$theme_GP_['background_image'] = "../graph/".$theme_GP_['theme_repertoire']."/".$theme_GP_['theme_bg'];
	$theme_GP_['theme_divinitial_bg'] = "../graph/".$theme_GP_['theme_repertoire']."/".$theme_GP_['theme_divinitial_bg'];
	$pv['module_ecart_bordure_x'] = 128;
	$pv['module_ecart_bordure_y'] = 128;

	$pv['liste_icone'] = array ('deco_icone_repertoire','deco_icone_efface','deco_icone_gauche','deco_icone_droite','deco_icone_haut','deco_icone_bas','deco_icone_ok','deco_icone_nok','deco_icone_question','deco_icone_notification');

	$pv['i'] = 1;
	unset ( $A );
	foreach ( $pv['TabNTheme'] as $A ) {

		$_REQUEST['bloc']	= decoration_nomage_bloc ( "B", $A['pos'] , "");
		$_REQUEST['blocG']	= decoration_nomage_bloc ( "B", $A['pos'] , "G");
		$_REQUEST['blocT']	= decoration_nomage_bloc ( "B", $A['pos'] , "T");

		$ADC['onglet'][$pv['i']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['i']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['i']]['legende'] = 0;

		$GP_module_['module_nom'] = "Bloc_GP_0".$pv['i']; 
		$mn = &$GP_module_['module_nom'];
		$GP_pres_[$mn]['px'] = $pv['module_ecart_bordure_x'] / 2 ; 
		$GP_pres_[$mn]['py'] = $pv['module_ecart_bordure_y'] / 2 ; 
		$GP_pres_[$mn]['dx'] = ($tab_infos['doc_width'] - 32 - $pv['module_ecart_bordure_x']); 
		$GP_pres_[$mn]['dy'] = ($tab_infos['doc_height'] - $pv['module_ecart_bordure_y']);

		$AD[$pv['i']]['1']['1']['cont'] .= "
		<div style='
		background-image: url(".$theme_GP_['background_image']."); background-color: ".$theme_GP_['theme_bg_color'].";
		width: ".($tab_infos['doc_width']-32)."px; height: ".($tab_infos['doc_height']-32)."px;
		'>
		<div style='
		position: absolute; background-image: url(".$theme_GP_['theme_divinitial_bg']."); 
		width: ".($tab_infos['doc_width']-32)."px; height: ".($tab_infos['doc_height']-32)."px;
		'>
		";

		switch ( $theme_GP_[$_REQUEST['blocG']]['deco_type'] ) {
		case "30":	case "1_div":		if ( !function_exists("module_deco_20_1_div") )		{ include ("routines/website/module_deco_30_1_div.php"); }		$AD[$pv['i']]['1']['1']['cont'] .= module_deco_30_1_div ("theme_GP_" , "GP_pres_" , "GP_module_", 1 );		break;
		case "40":	case "elegance":	if ( !function_exists("module_deco_40_elegance") )	{ include ("routines/website/module_deco_40_elegance.php"); }	$AD[$pv['i']]['1']['1']['cont'] .= module_deco_40_elegance ("theme_GP_" , "GP_pres_" , "GP_module_", 1 );	break;
		case "50":	case "exquise":		if ( !function_exists("module_deco_50_exquise") )	{ include ("routines/website/module_deco_50_exquise.php"); }	$AD[$pv['i']]['1']['1']['cont'] .= module_deco_50_exquise ("theme_GP_" , "GP_pres_" , "GP_module_", 1 );	break;
		case "60":	case "elysion":		if ( !function_exists("module_deco_60_elysion") )	{ include ("routines/website/module_deco_60_elysion.php"); }	$AD[$pv['i']]['1']['1']['cont'] .= module_deco_60_elysion ("theme_GP_" , "GP_pres_" , "GP_module_", 1 );	break;
		default:	$AD[$pv['i']]['1']['1']['cont'] .= "<div id='".$mn."' class='" . $theme_tableau . $_REQUEST['bloc']."_div_std' style='position:absolute; left:".$pres_[$mn]['px']."px; top:".$pres_[$mn]['py']."px; width:".$pres_[$mn]['dx']."px; height:".$pres_[$mn]['dy']."px; '>\r";		break;
		}

		$theme_GP_[$_REQUEST['blocT']]['ttd'] = "
		<table style='height:".$theme_GP_[$_REQUEST['blocT']]['deco_ft_y']."px;' border='0' cellspacing='0' cellpadding='0'>\r
		<tr>\r
		<td style='width:".$theme_GP_[$_REQUEST['blocT']]['deco_ft1_x']."px;	background-image: url(../graph/".$theme_GP_['theme_repertoire']."/".$theme_GP_[$_REQUEST['blocT']]['deco_ft1'].");'></td>\r
		<td style='background-image: url(../graph/".$theme_GP_['theme_repertoire']."/".$theme_GP_[$_REQUEST['blocT']]['deco_ft2'].");'>\r
		<span class='theme_GP_".$_REQUEST['bloc']."_tb4' style='color:".$theme_GP_[$_REQUEST['blocT']]['deco_txt_titre_col'].";'>\r
		";

		$theme_GP_[$_REQUEST['blocT']]['ttf'] = "
		</span>\r
		</td>\r
		<td style='width:".$theme_GP_[$_REQUEST['blocT']]['deco_ft3_x']."px;	background-image: url(../graph/".$theme_GP_['theme_repertoire']."/".$theme_GP_[$_REQUEST['blocT']]['deco_ft3'].");'></td>\r
		</tr>\r
		</table>\r
		";

		$AD[$pv['i']]['1']['1']['cont'] .= $theme_GP_[$_REQUEST['blocT']]['ttd']."Exemple de titre de document".$theme_GP_[$_REQUEST['blocT']]['ttf']."<br>\r";

		if ( $pv['i'] == 1 ) {
			$AD[$pv['i']]['1']['1']['cont'] .= "
			<form ACTION='index.php?' method='post'>\r
			<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto; '>
			<tr>\r
			<td class='theme_GP_".$_REQUEST['bloc']."_t3'>\r
			Je veux 
			<select name='UPDATE_action' class='theme_GP_".$_REQUEST['bloc']."_t3 theme_GP_".$_REQUEST['bloc']."_form_1'>\r
			<option value='AUCUNE'>Voir</option>\r
			<option value='UPDATE_USER'>Activer</option>\r
			</select>\r
			le th&egrave;me 
			<select name='theme_demande' class='theme_GP_".$_REQUEST['bloc']."_t3 theme_GP_".$_REQUEST['bloc']."_form_1'>\r
			";

			$dbquery = requete_sql($_RESQUEST['sql_initiateur'],"
			SELECT a.theme_id,a.theme_nom,theme_titre 
			FROM ".$SQL_tab_abrege['theme_descripteur']." a , ".$SQL_tab_abrege['site_theme']." b
			WHERE a.theme_id = b.theme_id  
			AND b.site_id = '".$site_web['sw_id']."' 
			;");
			while ($dbp = fetch_array_sql($dbquery)) { 
				if ( $dbp['theme_id'] == $_REQUEST['theme_demande'] ) { $AD[$pv['i']]['1']['1']['cont'] .= "<option value='".$dbp['theme_id']."' selected>".$dbp['theme_titre']."</option>\r"; }
				else { $AD[$pv['i']]['1']['1']['cont'] .= "<option value='".$dbp['theme_nom']."'>".$dbp['theme_titre']."</option>\r"; }
			}

			$AD[$pv['i']]['1']['1']['cont'] .= "
			</select>\r
			</td>\r
			<td>\r
			";

			$tl_['eng']['visualisation_theme'] = "Confirm"; 
			$tl_['fra']['visualisation_theme'] = "Valider"; 

			$_REQUEST['BS']['id']				= "bouton_visualisation_theme_". $pv['i'];
			$_REQUEST['BS']['type']				= "submit";
			$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . "theme_GP_".$_REQUEST['bloc']."_submit_s1_n";
			$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . "theme_GP_".$_REQUEST['bloc']."_submit_s1_h";
			$_REQUEST['BS']['onclick']			= "";
			$_REQUEST['BS']['message']			= $tl_[$l]['visualisation_theme'];
			$_REQUEST['BS']['mode']				= 0;
			$_REQUEST['BS']['taille'] 			= 0;
			$_REQUEST['BS']['derniere_taille']	= 0;

			$AD[$pv['i']]['1']['1']['cont'] .=  generation_bouton ();
			$AD[$pv['i']]['1']['1']['cont'] .= "
			</td>\r
			</tr>\r
			</table>\r".
			$bloc_html['post_hidden_sw'].
			$bloc_html['post_hidden_l'].
			$bloc_html['post_hidden_arti_ref'].
			$bloc_html['post_hidden_arti_page'].
			$bloc_html['post_hidden_user_login'].
			$bloc_html['post_hidden_user_pass']."
			<input type='hidden' name='M_UTILIS[login]'						value='".$user['login_decode']."'>\r
			<input type='hidden' name='M_UTILIS[confirmation_modification]'	value='1'>\r
			</form>\r
			<hr>\r
			";
		}
		$AD[$pv['i']]['1']['1']['cont'] .= "
		<p class='theme_GP_".$_REQUEST['bloc']."_t3'>\r
		Texte de d&eacute;monstation simple #".$pv['i'].". 
		Texte de d&eacute;monstation simple #".$pv['i'].". 
		Texte de d&eacute;monstation simple #".$pv['i'].". 
		Texte de d&eacute;monstation simple #".$pv['i'].". 
		Texte de d&eacute;monstation simple #".$pv['i'].". <br>\r
		<br>\r
		<a class='theme_GP_".$_REQUEST['bloc']."_lien theme_GP_".$_REQUEST['bloc']."_t3'>Exemple de lien simple</a><br>\r
		<br>\r
		<input type='text' name='WM_GP_exemple01' value='Exemple de champ d insertion' size='25' maxlength='255' class='theme_GP_".$_REQUEST['bloc']."_form_1 theme_GP_".$_REQUEST['bloc']."_t3'><br>\r
		<br>\r
		<input type='text' name='WM_GP_exemple02' value='Exemple de champ d insertion' size='25' maxlength='255' class='theme_GP_".$_REQUEST['bloc']."_form_2 theme_GP_".$_REQUEST['bloc']."_t3'><br>\r
		<br>\r
		</p>

		<table style='margin-left:auto; margin-right:auto;'>\r
		<tr>\r
		<td>\r

		<p align='left' class='theme_GP_".$_REQUEST['bloc']."_code'>
		<code class='theme_GP_".$_REQUEST['bloc']."_code theme_GP_".$_REQUEST['bloc']."_t3'>
		/* Exemple de code */<br>\r
		#include &lt;stdio.h&gt;<br>\r
		#include &lt;mylib.h&gt;<br>\r
		#include &lt;hislib.h&gt;<br>\r
		#include &lt;theirlib.h&gt;<br>\r
		main ()<br>\r
		{<br>\r
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;printf (''Exemple de code'');<br>\r
		}<br>\r
		</code>\r
		</p>\r
		</td>\r

		<td>\r
		<table>\r
		<tr>\r
		<td class='theme_GP_".$_REQUEST['bloc']."_fcta theme_GP_".$_REQUEST['bloc']."_t3' colspan='2'>\r Cellule titre a </td>\r
		<td class='theme_GP_".$_REQUEST['bloc']."_fctb theme_GP_".$_REQUEST['bloc']."_t3' colspan='2'>\r Cellule titre b </td>\r
		</tr>\r
		<tr>\r
		<td class='theme_GP_".$_REQUEST['bloc']."_fca theme_GP_".$_REQUEST['bloc']."_t3'>\r Cellule a </td>\r
		<td class='theme_GP_".$_REQUEST['bloc']."_fcb theme_GP_".$_REQUEST['bloc']."_t3'>\r Cellule b </td>\r
		<td class='theme_GP_".$_REQUEST['bloc']."_fcc theme_GP_".$_REQUEST['bloc']."_t3'>\r Cellule c </td>\r
		<td class='theme_GP_".$_REQUEST['bloc']."_fcd theme_GP_".$_REQUEST['bloc']."_t3'>\r Cellule d </td>\r
		</tr>\r
		<tr>\r
		<td class='theme_GP_".$_REQUEST['bloc']."_fca theme_GP_".$_REQUEST['bloc']."_t3' colspan='4'>\r
		<a class='theme_GP_".$_REQUEST['bloc']."_lien theme_GP_".$_REQUEST['bloc']."_t3'>Exemple de lien</a><br>\r
		<br>\r
		<input type='text' name='WM_GP_exemple01' value='Exemple de champ d insertion' size='25' maxlength='255' class='theme_GP_".$_REQUEST['bloc']."_form_1 theme_GP_".$_REQUEST['bloc']."_t3'><br>\r
		<br>\r
		<input type='text' name='WM_GP_exemple02' value='Exemple de champ d insertion' size='25' maxlength='255' class='theme_GP_".$_REQUEST['bloc']."_form_2 theme_GP_".$_REQUEST['bloc']."_t3'><br>\r

		</td>\r
		</tr>\r
		</table>\r
		</td>\r
		</tr>\r
		</table>\r
		";

		$pv['j'] = 0;
		foreach ( $pv['liste_icone'] as $A ) {
			if ( strlen( $theme_GP_[$_REQUEST['blocT']][$A] ) != 0 ) {
				$pv['GP_icone'][$pv['j']] = "background-image: url(../graph/".$theme_GP_[$_REQUEST['blocT']]['deco_repertoire']."/".$theme_GP_[$_REQUEST['blocT']][$A].");";
			}
			$pv['j']++;
		}

		$pv['max_cellule'] = 3;
		$pv['max_ligne'] = 4;
		$pv['cpt_ligne'] = 1;
		$pv['icone_div_taille'] = floor ( $theme_GP_['theme_module_largeur_interne'] / 4 )-8 ;
		if ( $pv['icone_div_taille'] > 128 ) { $pv['icone_div_taille'] = 128; }
		$pv['j'] = 0;
		$AD[$pv['i']]['1']['1']['cont'] .= "<table style='margin-left:auto; margin-right:auto;' border='0' >\r";
		for ( $pv['cpt_ligne'] = 1 ; $pv['cpt_ligne'] <= $pv['max_ligne'] ; $pv['cpt_ligne']++ ) {
			$AD[$pv['i']]['1']['1']['cont'] .= "<tr>";
			for ( $pv['cpt_cellule'] = 1 ; $pv['cpt_cellule'] <= $pv['max_cellule'] ; $pv['cpt_cellule']++ ) {
				$AD[$pv['i']]['1']['1']['cont'] .= "<td style='
				width: 136px; height: 136px; 
				border-style: solid; border-width: 1px; border-color: #000000;'>\r
				<div style='
				width: ".$pv['icone_div_taille']."px; height: ".$pv['icone_div_taille']."px;
				margin:auto; 
				background-repeat: no-repeat; background-position:center; 
				".$pv['GP_icone'][$pv['j']]."'></div>\r
				</td>\r
				";
				$pv['j']++;
			}
			$AD[$pv['i']]['1']['1']['cont'] .= "</tr>";
		}
		$AD[$pv['i']]['1']['1']['cont'] .= "
		</table>\r
		</div>\r
		<!-- Fin de bloc -->\r
		";

	$pv['i']++;

	}



	$GP_module_['module_nom'] = "Bloc_GP_0".$pv['i']; 
	$mn = &$GP_module_['module_nom'];
	$GP_pres_[$mn]['px'] = $pv['module_ecart_bordure_x'] / 2 ; 
	$GP_pres_[$mn]['py'] = $pv['module_ecart_bordure_y'] / 2 ; 
	$GP_pres_[$mn]['dx'] = (${$theme_tableau}['theme_module_largeur_interne'] - $pv['module_ecart_bordure_x']); 
	$GP_pres_[$mn]['dy'] = ($tab_infos['doc_height'] - $pv['module_ecart_bordure_y']);

	$AD[$pv['i']]['1']['1']['cont'] .= "
	<div style='
	background-image: url(".$theme_GP_['background_image']."); background-color: ".$theme_GP_['theme_bg_color'].";
	width: ".($tab_infos['doc_width']-32)."px; height: ".($tab_infos['doc_height']-64)."px;
	'>
	<div style='
	position: absolute; background-image: url(".$theme_GP_['theme_divinitial_bg']."); 
	width: ".($tab_infos['doc_width']-32)."px; height: ".($tab_infos['doc_height']-64)."px;
	'>
	";

// --------------------------------------------------------------------------------------------
	$pv['theme_rep'] = $theme_GP_['B01T']['deco_repertoire'];
	$pv['liste_theme'] = array ('theme_blason', 'theme_banniere');
	$pv['j'] = 0;
	foreach ( $pv['liste_theme'] as $A ) {
		$pv['GP_theme'][$pv['j']] = "background-image: url(../graph/".$pv['theme_rep']."/".$theme_GP_[$A].");";
		$pv['j']++;
	}
	$pv['max_cellule'] = 1;
	$pv['max_ligne'] = 2;
	$pv['cpt_ligne'] = 1;
	$pv['j'] = 0;
	$AD[$pv['i']]['1']['1']['cont'] .= "<table style='margin-left:auto; margin-right:auto;' border='0' >\r";
	for ( $pv['cpt_ligne'] = 1 ; $pv['cpt_ligne'] <= $pv['max_ligne'] ; $pv['cpt_ligne']++ ) {
		$AD[$pv['i']]['1']['1']['cont'] .= "<tr>";
		for ( $pv['cpt_cellule'] = 1 ; $pv['cpt_cellule'] <= $pv['max_cellule'] ; $pv['cpt_cellule']++ ) {
			$AD[$pv['i']]['1']['1']['cont'] .= "
			<td>\r	
			<div style='background-repeat: no-repeat; background-position:center; ".$pv['GP_theme'][$pv['j']]." width: ".($tab_infos['doc_width']-32)."px; height: ".(floor($GP_pres_[$mn]['dy']/$pv['max_ligne']))."px;'></div>\r
			</td>\r";
			$pv['j']++;
		}
		$AD[$pv['i']]['1']['1']['cont'] .= "</tr>";
	}

	$_REQUEST['bloc'] = $pv['save']['bloc'];
	$_REQUEST['blocG'] = $pv['save']['blocG'];
	$_REQUEST['blocT'] = $pv['save']['blocT'];
	$AD[$pv['i']]['1']['1']['cont'] .= "
	</table>\r

	</div>\r
	</div>\r
	<br>\r
	</p>
	";
	$ADC['onglet'][$pv['i']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['i']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['i']]['legende'] = 0;

	$theme_tableau_a_ecrire = "theme_princ_";	//Remet la bonne valeur car la génération du menu utilise cette variable.
	$theme_tableau = "theme_princ_";

	$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -16 ;
	include ("routines/website/affichage_donnees.php");



// --------------------------------------------------------------------------------------------
}
//$theme_tableau_a_ecrire = "theme_princ_";	//Remet la bonne valeur car la génération du menu utilise cette variable.
//$theme_tableau = "theme_princ_";

if ( $site_web['sw_info_debug'] < 10 ) {  }
	unset (
		$dbp , 
		$dbp_WM , 
		$dbquery ,
		$dbquery_WM , 
		$GP_v_t_ , 
		$GP_sp_smt_ , 
		$javascript_expr_tab , 
		$mdn , 
		$mn ,
		$pv , 
		$tab_infos , 
		$tab_select_1 , 
		$table_ , 
		$tl_ , 
		$theme_GP_ , 
		$PmListTheme 
	);

/*Hydre-contenu_fin*/
?>
