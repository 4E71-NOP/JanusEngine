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
$_REQUEST['M_UTILIS']['fiche'] = 31;
$_REQUEST['uni_gestion_des_utilisateurs_p'] = 3;

// --------------------------------------------------------------------------------------------
//	uni_gestion_des_utilisateurs_p02.php
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "fra_gestion_des_utilisateurs_p02";

// --------------------------------------------------------------------------------------------
// Preparation des tables
switch ( $_REQUEST['uni_gestion_des_utilisateurs_p'] ) {
case 2:
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['user']." 
	WHERE user_id='".$_REQUEST['M_UTILIS']['fiche']."';
	");

	while ($dbp = fetch_array_sql($dbquery)) { 
		foreach ( $dbp as $A => $B ) { $MU_fiche[$A] = $B; }
		$MU_fiche['user_date_inscription']				= date ("Y M d - H:i:s",$dbp['user_date_inscription']);
		$MU_fiche['user_derniere_visite']				= date ("Y M d - H:i:s",$dbp['user_derniere_visite']);
	}

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT gu.groupe_id,gu.groupe_premier,grp.groupe_nom 
	FROM ".$SQL_tab_abrege['groupe_user']." gu, ".$SQL_tab_abrege['groupe']." grp, ".$SQL_tab_abrege['site_groupe']." sg 
	WHERE gu.user_id = '".$MU_fiche['user_id']."' 
	AND gu.groupe_id = grp.groupe_id 
	AND grp.groupe_id = sg.groupe_id 
	AND sg.site_id = '".$site_web['sw_id']."' 
	ORDER BY groupe_premier;
	");
	$offset = 1;
	while ($dbp = fetch_array_sql($dbquery)) {
		$WM_MU_fiche_groupes[$offset]['id'] = $dbp['groupe_id'];
		$WM_MU_fiche_groupes[$offset]['nom'] = $dbp['groupe_nom'];
		$offset++;
	}
break;
case 3:
	$MU_fiche = array (
	"id" => "*",
	"user_login" => "Nouvel_utilisateur",
	"user_password" => "password!",
	"user_status" => 1,
	"user_role_fonction" => 1,
	"user_droit_forum" => 1,
	"user_pref_newsletter" => 1,
	"user_pref_montre_email" => 0,
	"user_pref_montre_status_online" => 0,
	"user_pref_notification_reponse_forum" => 1,
	"user_pref_notification_nouveau_pm" => 1,
	"user_pref_autorise_bbcode" => 1,
	"user_pref_autorise_html" => 1,
	"user_pref_autorise_smilies" => 1
	);

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT grp.groupe_id,grp.groupe_nom,grp.groupe_tag  
	FROM ".$SQL_tab_abrege['groupe']." grp, ".$SQL_tab_abrege['site_groupe']." sg 
	WHERE grp.groupe_id = sg.groupe_id 
	AND sg.site_id = '".$site_web['sw_id']."' 
	ORDER BY groupe_nom;
	");
	$offset = 0;
	while ($dbp = fetch_array_sql($dbquery)) {
		if ( $dbp['groupe_tag'] != 0 ) {
			$WM_MU_fiche_groupes[$offset]['db'] = $dbp['groupe_id'];
			$WM_MU_fiche_groupes[$offset]['t'] = $dbp['groupe_nom'];
			$WM_MU_fiche_groupes[$offset]['s'] = $dbp['groupe_tag'];
			$offset++;
		}
	}
break;
}

$gu_timezone['0'] = "0 - England, Ireland, Portugal";
$gu_timezone['1'] = "+1 - Europe: France, Spain, Germany, Poland, etc.";
$gu_timezone['2'] = "+2 - Central Europe: Turkey, Greece, Finland, etc.";
$gu_timezone['3'] = "+3 - Moscow, Saudi Arabia";
$gu_timezone['4'] = "+4 - Oman";
$gu_timezone['5'] = "+5 - Pakistan";
$gu_timezone['6'] = "+6 - India";
$gu_timezone['7'] = "+7 - Indonesia";
$gu_timezone['8'] = "+8 - China, Phillipines, Malaysia, West Australia";
$gu_timezone['9'] = "+9 - Japan";
$gu_timezone['10'] = "+10 - East Australia";
$gu_timezone['11'] = "+11 - Solomon islands, Micronesia";
$gu_timezone['12'] = "+12 - Marshall Islands, Fiji";
$gu_timezone['13'] = "-11 - Samoa, Midway";
$gu_timezone['14'] = "-10 - Hawaii, French Polynesia, Cook island";
$gu_timezone['15'] = "-9 - Alaska";
$gu_timezone['16'] = "-8 - US Pacific";
$gu_timezone['17'] = "-7 - US Mountain";
$gu_timezone['18'] = "-6 - US Central";
$gu_timezone['19'] = "-5 - US Eastern";
$gu_timezone['20'] = "-4 - New Foundland, Venezuela, Chile";
$gu_timezone['21'] = "-3 - Brazil, Argentina, Greenland";
$gu_timezone['22'] = "-2 - Mid-Atlantic";
$gu_timezone['23'] = "-1 - Azores, Cape Verda Is.";

// --------------------------------------------------------------------------------------------
// Preparation des elements
$tl_['eng']['o1l11'] = "ID";				$tl_['fra']['o1l11'] = "ID";
$tl_['eng']['o1l21'] = "Login";				$tl_['fra']['o1l21'] = "Identifiant";
$tl_['eng']['o1l31'] = "Avatar";			$tl_['fra']['o1l31'] = "Avatar";
$tl_['eng']['o1l41'] = "Password";			$tl_['fra']['o1l41'] = "Mot de passe";
$tl_['eng']['o1l51'] = "Subscription date";	$tl_['fra']['o1l51'] = "Date d'inscription";
$tl_['eng']['o1l61'] = "Admin notes";		$tl_['fra']['o1l61'] = "Commentaire admin";

$tl_['eng']['o2l11'] = "Group(s)";		$tl_['fra']['o2l11'] = "Groupe(s)";
$tl_['eng']['o2l21'] = "Status";		$tl_['fra']['o2l21'] = "Status";
$tl_['eng']['o2l31'] = "Function";		$tl_['fra']['o2l31'] = "Fonction";
$tl_['eng']['o2l41'] = "Forum access";	$tl_['fra']['o2l41'] = "Droit de forum";

$tl_['eng']['o2s1o0'] = "Disabled";	$tl_['fra']['o2s1o0'] = "Inactif";
$tl_['eng']['o2s1o1'] = "Active";	$tl_['fra']['o2s1o1'] = "Actif";
$tl_['eng']['o2s1o2'] = "Deleted";	$tl_['fra']['o2s1o2'] = "Supprim&eacute;";

$tl_['eng']['o2s2o0'] = "Public";	$tl_['fra']['o2s2o0'] = "Publique";
$tl_['eng']['o2s2o1'] = "Private";	$tl_['fra']['o2s2o1'] = "Priv&eacute;e";

$tl_['eng']['o2s4o0'] = "Forum access not granted";	$tl_['fra']['o2s4o0'] = "Forum inaccessible";
$tl_['eng']['o2s4o1'] = "Forum access granted";		$tl_['fra']['o2s4o1'] = "Forum accessible";


switch ( $_REQUEST['uni_gestion_des_utilisateurs_p'] ) {
case 2:
	$pv['o2l12'] = "<p style='text-align: justify;'>";
	foreach ($WM_MU_fiche_groupes as $A ) { $pv['o2l12'] .= $A['nom']." - "; }
	$pv['o2l12'] .= "</p>";

	$tl_['eng']['o5l21'] = "Last visit";	$tl_['fra']['o5l21'] = "Derni&egrave;re visite";
	$tl_['eng']['o5l31'] = "Last IP";		$tl_['fra']['o5l31'] = "Derni&egrave;re IP";
	$tl_['eng']['o5l41'] = "Timezone";		$tl_['fra']['o5l41'] = "Zone";
	$ADC['onglet']['5']['nbr_ligne'] = 4;

break;
case 3:
	$MU_fiche['user_password'] = "<input type='password' name='M_UTILIS[password]' value='' size='15' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";

	unset ( $A );
	foreach ( $WM_MU_fiche_groupes as &$A ) { 
		if ( $A['s'] != 1 ) { unset ( $A['s'] ); } 
		else { $A['s'] = "selected"; }
	}
	unset ( $A );
	$pv['o2l12'] = "<select name='M_UTILIS[groupe]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	foreach ( $WM_MU_fiche_groupes as $A ) { $pv['o2l12'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
	$pv['o2l12'] .= "</select>\r";
	$ADC['onglet']['5']['nbr_ligne'] = 1;
break;
}

$pv['o2l22'] = "<select name='M_UTILIS[status]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$gu_status['0']['t'] = $tl_[$l]['o2s1o0'];	$gu_status['0']['s'] = "";		$gu_status['0']['db'] = "DEACTIVATED";
$gu_status['1']['t'] = $tl_[$l]['o2s1o1'];	$gu_status['1']['s'] = "";		$gu_status['1']['db'] = "ACTIVE";
$gu_status['2']['t'] = $tl_[$l]['o2s1o2'];	$gu_status['2']['s'] = "";		$gu_status['2']['db'] = "DELETED";
$gu_status[$MU_fiche['user_status']]['s'] = " selected ";
foreach ( $gu_status as $A ) { $pv['o2l22'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
unset ($gu_status);
$pv['o2l22'] .= "</select>\r";


$pv['o2l32'] = "<select name='M_UTILIS[role_fonction]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$gu_fonction['1']['t'] = $tl_[$l]['o2s2o0'];	$gu_fonction['1']['s'] = "";		$gu_fonction['1']['db'] = "PUBLIC";
$gu_fonction['2']['t'] = $tl_[$l]['o2s2o1'];	$gu_fonction['2']['s'] = "";		$gu_fonction['2']['db'] = "PRIVE";
$gu_fonction[$MU_fiche['user_role_fonction']]['s'] = " selected ";
foreach ( $gu_fonction as $A ) { $pv['o2l32'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
unset ($gu_fonction);
$pv['o2l32'] .= "</select>\r";


$pv['o2l42'] = "<select name='M_UTILIS[droit_forum]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$gu_forum['0']['t'] = $tl_[$l]['o2s4o0'];	$gu_forum['0']['s'] = "";		$gu_forum['0']['db'] = "OFF";
$gu_forum['1']['t'] = $tl_[$l]['o2s4o1'];	$gu_forum['1']['s'] = "";		$gu_forum['1']['db'] = "ON";
$gu_forum[$MU_fiche['user_droit_forum']]['s'] = " selected ";
foreach ( $gu_forum as $A ) { $pv['o2l42'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
unset ($gu_forum);
$pv['o2l42'] .= "</select>\r";

$tl_['eng']['o3l11'] = "Email";				$tl_['fra']['o3l11'] = "Courriel";
$tl_['eng']['o3l21'] = "MSN";				$tl_['fra']['o3l21'] = "MSN";
$tl_['eng']['o3l31'] = "AIM";				$tl_['fra']['o3l31'] = "AIM";
$tl_['eng']['o3l41'] = "ICQ";				$tl_['fra']['o3l41'] = "ICQ";
$tl_['eng']['o3l51'] = "YIM";				$tl_['fra']['o3l51'] = "YIM";
$tl_['eng']['o3l61'] = "Personal website";	$tl_['fra']['o3l61'] = "Site personnel";

$tl_['eng']['o4l11'] = "Name";		$tl_['fra']['o4l11'] = "Nom";
$tl_['eng']['o4l21'] = "State";		$tl_['fra']['o4l21'] = "Pays";
$tl_['eng']['o4l31'] = "Town";		$tl_['fra']['o4l31'] = "Ville";
$tl_['eng']['o4l41'] = "Hobbies";	$tl_['fra']['o4l41'] = "Occupations";
$tl_['eng']['o4l51'] = "Interest";	$tl_['fra']['o4l51'] = "Sujet d'int&eacute;r&egrave;t";


$tl_['eng']['o5l11'] = "Language";		$tl_['fra']['o5l11'] = "Langue";
$pv['o5l12'] = "<select name='M_UTILIS[lang]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";

unset ( $A );
foreach ( $langues as $A ) { 
	$pv['selected'] = "";
	if ( isset($A['langue_639_3']) ) { 
		if ( $MU_fiche['user_lang'] == $A['langue_id'] ) { $pv['selected'] = " selected"; }
		$pv['o5l12'] .= "<option value='".$A['langue_639_3']."' ".$pv['selected'].">".$A['langue_nom_original']."</option>\r"; 
	} 
}
$pv['o5l12'] .= "</select>\r";

$tl_['eng']['o6l11'] = "theme";					$tl_['fra']['o6l11'] = "Th&egrave;me";	
$tl_['eng']['o6l21'] = "Newsletter";			$tl_['fra']['o6l21'] = "Newsletter";	
$tl_['eng']['o6l31'] = "Show email adress";		$tl_['fra']['o6l31'] = "Montre l'adresse mail";	
$tl_['eng']['o6l41'] = "Show use as connected";	$tl_['fra']['o6l41'] = "Montre le status 'connect&eacute;'";

$tl_['eng']['o6l51'] = "Is notified when an answer is posted on the forums?";	$tl_['fra']['o6l51'] = "Recoit une notification des r&eacute;ponses au forums";
$tl_['eng']['o6l61'] = "Is notified when he recieve a Personal Message";		$tl_['fra']['o6l61'] = "Recoit une notification pour un nouveau message priv&eacute;";
$tl_['eng']['o6l71'] = "Allow BBCode";											$tl_['fra']['o6l71'] = "Autorise le BBcode";
$tl_['eng']['o6l81'] = "Allow HTML";											$tl_['fra']['o6l81'] = "Autorise le HTML";
$tl_['eng']['o6l91'] = "Allows simleys";										$tl_['fra']['o6l91'] = "Autorise les smileys";

$pv['o6l12'] = "<select name='M_UTILIS[pref_theme]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT a.theme_id,a.theme_nom,a.theme_titre 
FROM ".$SQL_tab_abrege['theme_descripteur']." a , ".$SQL_tab_abrege['site_theme']." b
WHERE b.site_id = '".$site_web['sw_id']."'
AND a.theme_id = b.theme_id
AND a.theme_id != '1';
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	if ( $dbp['theme_id'] == $MU_fiche['user_pref_theme'] ) { $pv['o6l12'] .= "<option value='".$dbp['theme_nom']."' selected>".$dbp['theme_titre']."</option>\r"; }
	else { $pv['o6l12'] .= "<option value='".$dbp['theme_nom']."'>".$dbp['theme_titre']."</option>\r"; }
}
$pv['o6l12'] .= "</select>\r";


$pv['o6l22'] = "<select name='M_UTILIS[pref_newsletter]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$gu_option['0']['t'] = "Non";		$gu_option['0']['s'] = "";		$gu_option['0']['db'] = "NO";
$gu_option['1']['t'] = "Oui";		$gu_option['1']['s'] = "";		$gu_option['1']['db'] = "YES";
$B = $MU_fiche['user_pref_newsletter'];
$gu_option[$B]['s'] = " selected ";
foreach ( $gu_option as $A ) { $pv['o6l22'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$gu_option[$B]['s'] = " ";
$pv['o6l22'] .= "</select>\r";


$pv['o6l32'] = "<select name='M_UTILIS[pref_montre_email]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$B = $MU_fiche['user_pref_montre_email'];
$gu_option[$B]['s'] = " selected ";
foreach ( $gu_option as $A ) { $pv['o6l32'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$gu_option[$B]['s'] = " ";
$pv['o6l32'] .= "</select>\r";


$pv['o6l42'] = "<select name='M_UTILIS[pref_montre_status_online]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$B = $MU_fiche['user_pref_montre_status_online'];
$gu_option[$B]['s'] = " selected ";
foreach ( $gu_option as $A ) { $pv['o6l42'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$gu_option[$B]['s'] = " ";
$pv['o6l42'] .= "</select>\r";


$pv['o6l52'] = "<select name='M_UTILIS[pref_notification_reponse_forum]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$B = $MU_fiche['user_pref_notification_reponse_forum'];
$gu_option[$B]['s'] = " selected ";
foreach ( $gu_option as $A ) { $pv['o6l52'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$gu_option[$B]['s'] = " ";
$pv['o6l52'] .= "</select>\r";


$pv['o6l62'] = "<select name='M_UTILIS[pref_notification_nouveau_pm]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$B = $MU_fiche['user_pref_notification_nouveau_pm'];
$gu_option[$B]['s'] = " selected ";
foreach ( $gu_option as $A ) { $pv['o6l62'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$gu_option[$B]['s'] = " ";
$pv['o6l62'] .= "</select>\r";


$pv['o6l72'] = "<select name='M_UTILIS[pref_autorise_bbcode]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$B = $MU_fiche['user_pref_autorise_bbcode'];
$gu_option[$B]['s'] = " selected ";
foreach ( $gu_option as $A ) { $pv['o6l72'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$gu_option[$B]['s'] = " ";
$pv['o6l72'] .= "</select>\r";


$pv['o6l82'] = "<select name='M_UTILIS[pref_autorise_html]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$B = $MU_fiche['user_pref_autorise_html'];
$gu_option[$B]['s'] = " selected ";
foreach ( $gu_option as $A ) { $pv['o6l82'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$gu_option[$B]['s'] = " ";
$pv['o6l82'] .= "</select>\r";


$pv['o6l92'] = "<select name='M_UTILIS[pref_autorise_smilies]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$B = $MU_fiche['user_pref_autorise_smilies'];
$gu_option[$B]['s'] = " selected ";
foreach ( $gu_option as $A ) { $pv['o6l92'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$gu_option[$B]['s'] = " ";
unset ($gu_option);
$pv['o6l92'] .= "</select>\r";


// --------------------------------------------------------------------------------------------
//	Affichage
$tl_['eng']['text_invite_1'] = "This part allows you to modify user datas. Modify the accessible fields and validate.";
$tl_['fra']['text_invite_1'] = "Cette Partie permet de modifier les donn&eacute;es d'un utilisateur. Modifiez les champs accessibles puis validez.";

echo ("
<p>\r
".$tl_[$l]['text_invite_1']."
</p>\r
");

if ( $_REQUEST['M_UTILIS']['confirmation_suppression_oubli'] == 1 ) {
	$tl_['eng']['err_suppr1'] = "You didn't confirm the deletion.";
	$tl_['fra']['err_suppr1'] = "Vous n'avez pas confirm&eacute; la suppression.";
	echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur " . $theme_tableau . $_REQUEST['bloc']."_tb3'><span style='text-weight: bold;'>".$tl_[$l]['err_suppr1']."</span><br>\r<br>\r");
}
if ( $_REQUEST['M_UTILIS']['confirmation_modification_oubli'] == 1 ) {
	$tl_['eng']['err_modif1'] = "You didn't confirm the modification.";
	$tl_['fra']['err_modif1'] = "Vous n'avez pas confirm&eacute; la modification.";
	echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur " . $theme_tableau . $_REQUEST['bloc']."_tb3'><span style='text-weight: bold;'>".$tl_[$l]['err_modif1']."</span><br>\r<br>\r");
}

if ( $_REQUEST['uni_gestion_des_utilisateurs_p'] == 2 ) {
	if ( !isset($_REQUEST['M_UTILIS']['fiche'])) {
		$tl_['eng']['err_fich1'] = "No user reference!";
		$tl_['fra']['err_fich1'] = "Pas de fiche transmise!";
		echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur " . $theme_tableau . $_REQUEST['bloc']."_tb3'><span style='text-weight: bold;'>".$tl_[$l]['err_fich1']."</span>\r<br>\r<br>\r");
	}
}
echo ("
<form ACTION='index.php?' id='formulaire_gu' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']
);

// ."<input type='hidden' name='M_UTILIS[fiche]' value='".$_REQUEST['M_UTILIS_user_fiche']."'>\r
// <input type='hidden' name='M_UTILIS[action]' value='2'>\r

$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_gu";
$fsi['champs']					= "M_UTILIS[image_avatar]";
$fsi['lsdf_chemin']				= "../websites-datas/".$site_web['sw_repertoire']."/data/images/avatars/";
$fsi['mode_selection']			= "fichier";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 5;
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 1;
$fsi['lsdf_conserve_chemin']	= "../websites-datas/".$site_web['sw_repertoire']."/data/images/avatars/";
$fsi['lsdf_coupe_repertoire']	= 0;
$fsi['liste_fichier']			= array();


$AD['1']['1']['1']['cont'] = $tl_[$l]['o1l11'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['o1l21'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['o1l31'] . " :<br><img src='".$MU_fiche['user_image_avatar']."' width='48' height='48' alt=''>";
$AD['1']['4']['1']['cont'] = $tl_[$l]['o1l41'];
$AD['1']['5']['1']['cont'] = $tl_[$l]['o1l51'];
$AD['1']['6']['1']['cont'] = $tl_[$l]['o1l61'];
$AD['1']['1']['2']['cont'] = $MU_fiche['user_id'];
$AD['1']['2']['2']['cont'] = "<input type='text' name='M_UTILIS[login]' value=\"". stripslashes ( $MU_fiche['user_login'] ) ."\" size='15' maxlength='32' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
$AD['1']['3']['2']['cont'] = generation_icone_selecteur_fichier ( 3 , $fsi['formulaire'] , $fsi['champs'] , 40 , $MU_fiche['user_image_avatar'] , "TabSDF_".$fsi['lsdf_indicatif'] );

$AD['1']['4']['2']['cont'] = $MU_fiche['user_password'];
$AD['1']['5']['2']['cont'] = $MU_fiche['user_date_inscription'];
$AD['1']['6']['2']['cont'] = "<textarea name='M_UTILIS[admin_commentaire]' rows ='4' cols='32' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>".$MU_fiche['user_admin_commentaire']."</textarea>\r";

$AD['2']['1']['1']['cont'] = $tl_[$l]['o2l11'];
$AD['2']['2']['1']['cont'] = $tl_[$l]['o2l21'];
$AD['2']['3']['1']['cont'] = $tl_[$l]['o2l31'];
$AD['2']['4']['1']['cont'] = $tl_[$l]['o2l41'];
$AD['2']['1']['2']['cont'] = $pv['o2l12'];
$AD['2']['2']['2']['cont'] = $pv['o2l22'];
$AD['2']['3']['2']['cont'] = $pv['o2l32'];
$AD['2']['4']['2']['cont'] = $pv['o2l42'];

$AD['3']['1']['1']['cont'] = $tl_[$l]['o3l11'];
$AD['3']['2']['1']['cont'] = $tl_[$l]['o3l21'];
$AD['3']['3']['1']['cont'] = $tl_[$l]['o3l31'];
$AD['3']['4']['1']['cont'] = $tl_[$l]['o3l41'];
$AD['3']['5']['1']['cont'] = $tl_[$l]['o3l51'];
$AD['3']['6']['1']['cont'] = $tl_[$l]['o3l61'];
$AD['3']['1']['2']['cont'] = "<input type='text' name='M_UTILIS[user_email]' value=\"".$MU_fiche['user_email']."\" size='15' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
$AD['3']['2']['2']['cont'] = "<input type='text' name='M_UTILIS[user_msn]' value=\"".$MU_fiche['user_msn']."\" size='15' maxlength='25' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
$AD['3']['3']['2']['cont'] = "<input type='text' name='M_UTILIS[user_aim]' value=\"".$MU_fiche['user_aim']."\" size='10' maxlength='18' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
$AD['3']['4']['2']['cont'] = "<input type='text' name='M_UTILIS[user_icq]' value=\"".$MU_fiche['user_icq']."\" size='10' maxlength='15' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
$AD['3']['5']['2']['cont'] = "<input type='text' name='M_UTILIS[user_yim]' value=\"".$MU_fiche['user_yim']."\" size='10' maxlength='25' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
$AD['3']['6']['2']['cont'] = "<input type='text' name='M_UTILIS[user_website]' value=\"".$MU_fiche['user_website']."\" size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";

$AD['4']['1']['1']['cont'] = $tl_[$l]['o4l11'];
$AD['4']['2']['1']['cont'] = $tl_[$l]['o4l21'];
$AD['4']['3']['1']['cont'] = $tl_[$l]['o4l31'];
$AD['4']['4']['1']['cont'] = $tl_[$l]['o4l41'];
$AD['4']['5']['1']['cont'] = $tl_[$l]['o4l51'];
$AD['4']['1']['2']['cont'] = "<input type='text' name='M_UTILIS[perso_nom]' value=\"".$MU_fiche['user_perso_nom']."\" size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
$AD['4']['2']['2']['cont'] = "<input type='text' name='M_UTILIS[perso_pays]' value=\"".$MU_fiche['user_perso_pays']."\" size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
$AD['4']['3']['2']['cont'] = "<input type='text' name='M_UTILIS[perso_ville]' value=\"".$MU_fiche['user_perso_ville']."\" size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
$AD['4']['4']['2']['cont'] = "<input type='text' name='M_UTILIS[perso_occupation]' value=\"".$MU_fiche['user_perso_occupation']."\" size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";
$AD['4']['5']['2']['cont'] = "<input type='text' name='M_UTILIS[perso_interet]' value=\"".$MU_fiche['user_perso_interet']."\" size='30' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>";


$AD['5']['1']['1']['cont'] = $tl_[$l]['o5l11'];
$AD['5']['2']['1']['cont'] = $tl_[$l]['o5l21'];
$AD['5']['3']['1']['cont'] = $tl_[$l]['o5l31'];
$AD['5']['4']['1']['cont'] = $tl_[$l]['o5l41'];
$AD['5']['1']['2']['cont'] = $pv['o5l12'];
$AD['5']['2']['2']['cont'] = $MU_fiche['user_derniere_visite'];
$AD['5']['3']['2']['cont'] = $MU_fiche['user_derniere_ip'];
$AD['5']['4']['2']['cont'] = $gu_timezone[$MU_fiche['user_timezone']];


$AD['6']['1']['1']['cont'] = $tl_[$l]['o6l11'];
$AD['6']['2']['1']['cont'] = $tl_[$l]['o6l21'];
$AD['6']['3']['1']['cont'] = $tl_[$l]['o6l31'];
$AD['6']['4']['1']['cont'] = $tl_[$l]['o6l41'];
$AD['6']['5']['1']['cont'] = $tl_[$l]['o6l51'];
$AD['6']['6']['1']['cont'] = $tl_[$l]['o6l61'];
$AD['6']['7']['1']['cont'] = $tl_[$l]['o6l71'];
$AD['6']['8']['1']['cont'] = $tl_[$l]['o6l81'];
$AD['6']['9']['1']['cont'] = $tl_[$l]['o6l91'];
$AD['6']['1']['2']['cont'] = $pv['o6l12'];
$AD['6']['2']['2']['cont'] = $pv['o6l22'];
$AD['6']['3']['2']['cont'] = $pv['o6l32'];
$AD['6']['4']['2']['cont'] = $pv['o6l42'];
$AD['6']['5']['2']['cont'] = $pv['o6l52'];
$AD['6']['6']['2']['cont'] = $pv['o6l62'];
$AD['6']['7']['2']['cont'] = $pv['o6l72'];
$AD['6']['8']['2']['cont'] = $pv['o6l82'];
$AD['6']['9']['2']['cont'] = $pv['o6l92'];


$ADC['onglet']['1']['nbr_ligne'] = 6;		$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;
$ADC['onglet']['2']['nbr_ligne'] = 4;		$ADC['onglet']['2']['nbr_cellule'] = 2;	$ADC['onglet']['2']['legende'] = 2;		
$ADC['onglet']['3']['nbr_ligne'] = 6;		$ADC['onglet']['3']['nbr_cellule'] = 2;	$ADC['onglet']['3']['legende'] = 2;
$ADC['onglet']['4']['nbr_ligne'] = 5;		$ADC['onglet']['4']['nbr_cellule'] = 2;	$ADC['onglet']['4']['legende'] = 2;
											$ADC['onglet']['5']['nbr_cellule'] = 2;	$ADC['onglet']['5']['legende'] = 2;
$ADC['onglet']['6']['nbr_ligne'] = 9;		$ADC['onglet']['6']['nbr_cellule'] = 2;	$ADC['onglet']['6']['legende'] = 2;


$tl_['eng']['onglet_1'] = "User";			$tl_['fra']['onglet_1'] = "Utilisateur";
$tl_['eng']['onglet_2'] = "Access";			$tl_['fra']['onglet_2'] = "Acces";
$tl_['eng']['onglet_3'] = "Internet";		$tl_['fra']['onglet_3'] = "Internet";
$tl_['eng']['onglet_4'] = "Personal";		$tl_['fra']['onglet_4'] = "Personnel";
$tl_['eng']['onglet_5'] = "Last seen";		$tl_['fra']['onglet_5'] = "Fr&eacute;quentation";
$tl_['eng']['onglet_6'] = "Preferences";	$tl_['fra']['onglet_6'] = "Pr&eacute;f&eacute;rences";


$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 6;
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 320;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "gu_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
$tab_infos['cell_2_txt']		= $tl_[$l]['onglet_2'];
$tab_infos['cell_3_txt']		= $tl_[$l]['onglet_3'];
$tab_infos['cell_4_txt']		= $tl_[$l]['onglet_4'];
$tab_infos['cell_5_txt']		= $tl_[$l]['onglet_5'];
$tab_infos['cell_6_txt']		= $tl_[$l]['onglet_6'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------

$tl_['eng']['submit2'] = "Back to the list";	$tl_['fra']['submit2'] = "Retour &agrave; la liste";

switch ( $_REQUEST['uni_gestion_des_utilisateurs_p'] ) {
case 2:
	$tl_['eng']['submit1'] = "Modify";				$tl_['fra']['submit1'] = "Modifier";
	$tl_['eng']['submit3'] = "Delete user";			$tl_['fra']['submit3'] = "Suppression utilisateur";
	$tl_['eng']['validation_mod'] = "Confirmation of user modification";	$tl_['fra']['validation_mod'] = "Validation de la modification de l'utilisateur.";
	$tl_['eng']['validation_sup'] = "Confirmation of user deletion";		$tl_['fra']['validation_sup'] = "Validation de la suppression de l'utilisateur.";
	$tl_['eng']['avertissement_sup'] = "This part allows to delete a user. Confirm with the checkbox and click on delete. <span class='" . $theme_tableau . $_REQUEST['bloc']."_avert " . $theme_tableau . $_REQUEST['bloc']."_tb3'>ATTENTION</span> The user  <span style='font-weight: bold;'>WON'T</span> be removed form the database. Only his status is modified.</span>";
	$tl_['fra']['avertissement_sup'] = "Cette partie permet de supprimer un utilisateur. Confirmez avec le checkbox et cliquez sur supprimer. <span class='" . $theme_tableau . $_REQUEST['bloc']."_avert " . $theme_tableau . $_REQUEST['bloc']."_tb3'>ATTENTION</span> L'utilisateur n'est <span style='font-weight: bold;'>PAS</span> supprim&eacute; des bases. Seul son &eacute;tat change.</span>";
	$pv['groupe_UPDATE_action'] = "UPDATE_USER";

	$pv['tablecommande_l1c1'] = "
	<input type='hidden' name='M_UTILIS[profil]'		value='".$MU_fiche['user_login']."'>\r
	<input type='hidden' name='M_UTILIS[fiche]'			value='".$MU_fiche['user_id']."'>\r
	<input type='hidden' name='uni_gestion_des_utilisateurs_p' value='2'>\r";
break;
case 3:
	$tl_['eng']['submit1'] = "Create";				$tl_['fra']['submit1'] = "Cr&eacute;er";
	$pv['groupe_UPDATE_action'] = "ADD_USER";
	$pv['tablecommande_l1c1'] = "
	<input type='hidden' name='uni_gestion_des_utilisateurs_p' value='2'>\r";
break;
}

echo ("
<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r".
$pv['tablecommande_l1c1']."
<input type='hidden' name='UPDATE_action'	value='".$pv['groupe_UPDATE_action']."'>\r
<tr>\r
<td>");

$_REQUEST['BS']['id']				= "bouton_modification_site";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['submit1'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 160;
$_REQUEST['BS']['derniere_taille']	= 0;

switch ( $_REQUEST['uni_gestion_des_utilisateurs_p'] ) {
case 2:
	echo ("<input type='checkbox' name='M_UTILIS[confirmation_modification]' value='1'>".$tl_[$l]['validation_mod']."</td>\r");
break;
}

echo ("
</td>\r
<td style='width: 192px;'>\r");
echo generation_bouton ();
echo ("<br>&nbsp;\r</td>\r
</form>\r
</tr>

<tr>\r
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page' value='1'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
<td></td>\r
<td style='width: 192px;'>\r");
$_REQUEST['BS']['id']				= "bouton_retour_liste";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['submit2'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 0;
echo generation_bouton ();
echo ("<br>&nbsp;\r</td>\r
</tr>\r
</form>\r
");

switch ( $_REQUEST['uni_gestion_des_utilisateurs_p'] ) {
case 2:
	echo ("
	<tr>\r
	<form ACTION='index.php?' method='post'>\r".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_arti_ref'].
	$bloc_html['post_hidden_arti_page'].
	$bloc_html['post_hidden_user_login'].
	$bloc_html['post_hidden_user_pass']."
	<input type='hidden' name='M_UTILIS[login]'		value='".$MU_fiche['user_login']."'>\r
	<input type='hidden' name='M_UTILIS[fiche]'		value='".$MU_fiche['user_id']."'>\r
	<input type='hidden' name='UPDATE_action'	value='DELETE_USER'>\r
	<input type='hidden' name='uni_gestion_des_utilisateurs_p' value='2'>\r
	<td>
	".$tl_[$l]['avertissement_sup']."<br>\r<input type='checkbox' name='M_UTILIS[confirmation_suppression]' value='1'>".$tl_[$l]['validation_sup']."</td>\r
	<td style='width: 192px;'>\r");
	$_REQUEST['BS']['id']				= "bouton_suppression";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['submit3'];
	$_REQUEST['BS']['mode']				= 1;
	$_REQUEST['BS']['taille'] 			= 0;
	echo generation_bouton ();
	echo ("<br>&nbsp;</td>\r
	</tr>\r
	</form>\r
	");
}

echo ("
</table>\r
<br>\r<br>\r<br>\r
");


if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$A,
		$B , 
		$gu_timezone , 
		$dbquery , 
		$dbquery_WM , 
		$dbp , 
		$dbp_WM , 
		$gu_fonction , 
		$gu_option , 
		$MU_fiche , 
		$AD,
		$ADC,
		$pv,
		$theme_SW_ , 
		$tab_infos , 
		$tl_ , 
		$WM_MU_fiche_groupes , 
		$WM_MU_fiche
	);
}
/*Hydre-contenu_fin*/
?>
