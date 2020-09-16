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
//
//user_status 			SUPPRIME:0	ACTIF:1
//user_droit_tribune	OFF:0		ON:1
//user_droit_forum		OFF:0		ON:1
//groupe_premier		NON:0		OUI:1

$_REQUEST['liste_colonne']['user'] = array (
"user_id",					"user_nom",			"user_login",			"user_password",
"user_date_inscription",	"user_status",		"user_role_fonction",
"user_droit_forum",			"user_email",
"user_msn",					"user_aim",
"user_icq",					"user_yim",
"user_website",				"user_perso_nom",
"user_perso_pays",			"user_perso_ville",
"user_perso_occupation",	"user_perso_interet",
"user_derniere_visite",		"user_derniere_ip",
"user_timezone",			"user_lang",
"user_pref_theme",					"user_pref_newsletter",					"user_pref_montre_email",			
"user_pref_montre_status_online",	"user_pref_notification_reponse_forum",	"user_pref_notification_nouveau_pm",

"user_pref_autorise_bbcode",		"user_pref_autorise_html",				"user_pref_autorise_smilies",
"user_image_avatar",				"user_admin_commentaire"
);

$_REQUEST['liste_colonne']['user_conversion'] = array ( 
"status", "role_fonction", "droit_forum", "lang",
"pref_newsletter", "pref_montre_email", "pref_montre_status_online", "pref_notification_reponse_forum", 
"pref_notification_nouveau_pm", "pref_autorise_bbcode", "pref_autorise_html", "pref_autorise_smilies", 
"groupe_premier"
);

$_REQUEST['liste_colonne']['user_reference'] = array ( 
"id",					"nom",			"login",			"password",
"date_inscription",		"status",		"role_fonction",
"droit_forum",			"email",
"msn",					"aim",
"icq",					"yim",
"website",				"perso_nom",
"perso_pays",			"perso_ville",
"perso_occupation",		"perso_interet",
"derniere_visite",		"derniere_ip",
"timezone",				"lang",
"pref_theme",					"pref_newsletter",					"pref_montre_email",			
"pref_montre_status_online",	"pref_notification_reponse_forum",	"pref_notification_nouveau_pm",

"pref_autorise_bbcode",		"pref_autorise_html",				"pref_autorise_smilies",
"image_avatar",				"admin_commentaire",
"groupe_premier"
);

function initialisation_valeurs_utilisateur () {
	$R = &$_REQUEST['M_UTILIS'];

	$R['id']					= "";
	$R['nom']					= "NA";
	$R['login']					= "NA";
	$R['password']				= "NA";
	$R['date_inscription']		= time ();
	$R['status']				= "ACTIVE";
	$R['role_fonction']			= "PUBLIC";
	$R['droit_forum']			= "ON";

	$R['email']					= "NA";
	$R['msn']					= "NA";
	$R['aim']					= "NA";
	$R['icq']					= "NA";
	$R['yim']					= "NA";
	$R['website']				= "NA";

	$R['perso_nom']				= "NA";
	$R['perso_pays']			= "NA";
	$R['perso_ville']			= "NA";
	$R['perso_occupation']		= "NA";
	$R['perso_interet']			= "NA";

	$R['derniere_visite']		= "NA";
	$R['derniere_ip']			= "0.0.0.0";
	$R['timezone']				= 1;
	$R['lang']					= "fra";

	$R['pref_theme']						= "";
	$R['pref_newsletter']					= "yes";
	$R['pref_montre_email']					= "no";
	$R['pref_montre_status_online']			= "no";
	$R['pref_notification_reponse_forum']	= "yes";
	$R['pref_notification_nouveau_pm']		= "yes";
	$R['pref_autorise_bbcode']				= "yes";
	$R['pref_autorise_html']				= "yes";
	$R['pref_autorise_smilies']				= "yes";
	$R['image_avatar']						= "";
	$R['admin_commentaire']					= "";
	$R['filtre']							= "";

	$R['join_group'] 			= 0;
	$R['groupe_premier']		= 0;

	//$R['password']			= &$R['passwd'];

	$R['role_function']		= &$R['role_fonction'];
	$R['forum_access']		= &$R['droit_forum'];

	$R['perso_name']		= &$R['nom'];
	$R['perso_nom']			= &$R['nom'];
	$R['perso_country']		= &$R['perso_pays'];
	$R['perso_town']		= &$R['perso_ville'];
	$R['perso_interest']	= &$R['perso_interet'];

	$R['pref_show_email']					= &$R['pref_montre_email'];
	$R['pref_show_online_status']			= &$R['pref_montre_status_online'];
	$R['pref_notification_forum_answer']	= &$R['pref_notification_reponse_forum'];
	$R['pref_notification_new_pm']			= &$R['pref_notification_nouveau_pm'];
	$R['pref_allow_bbcode']					= &$R['pref_autorise_bbcode'];
	$R['pref_allow_html']					= &$R['pref_autorise_html'];
	$R['pref_allow_smilies']				= &$R['pref_autorise_smilies'];
	$R['admin_comment']						= &$R['admin_commentaire'];
	$R['avatar']							= &$R['image_avatar'];

	$R['rejoint_le_groupe']		= &$R['join_group'];
	$R['primary_group']			= &$R['groupe_premier'];
	$R['filter']				= &$R['filtre'];

//	$Cles = array_keys ( $_REQUEST['M_UTILIS'] );
	reset ( $_REQUEST['liste_colonne']['user_reference'] );
	foreach ( $_REQUEST['liste_colonne']['user_reference'] as $A ) { $R['user_'.$A] = &$R[$A];	}
}

function chargement_valeurs_utilisateur () {
	global $SQL_tab, $SQL_tab_abrege, $db, $tab_conv_expr, $langues;
	$R = &$_REQUEST['M_UTILIS'];

	$tl_['eng']['log_init'] = "Loading user datas";									$tl_['fra']['log_init'] = "Chargement valeurs de l'utilisateur";
	$tl_['eng']['err_001'] = "The user named '".$R['login']."' doesn't exists.";	$tl_['fra']['err_001'] = "L'utilisateur '".$R['login']."' n'existe pas.";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT usr.* 
	FROM ".$SQL_tab_abrege['user']." usr , ".$SQL_tab_abrege['groupe_user']." gu , ".$SQL_tab_abrege['site_groupe']." sg 
	WHERE usr.user_login = '".$R['user_login']."' 
	AND usr.user_id = gu.user_id 
	AND gu.groupe_id = sg.groupe_id 
	AND sg.site_id = '".$_REQUEST['site_context']['site_id']."' 
	;");
	if ( num_row_sql($dbquery) == 0 ) {
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "MU_CVU_0001", $tl_[$l]['err_001'] ); 
	}
	else {
		$p = $tab_conv_expr['M_UTILIS']['inactif'];	$tab_status[$p] = "inactif";
		$p = $tab_conv_expr['M_UTILIS']['actif'];		$tab_status[$p] = "actif";
		$p = $tab_conv_expr['M_UTILIS']['supprime'];	$tab_status[$p] = "supprime";
		$p = $tab_conv_expr['M_UTILIS']['publique'];	$tab_role[$p] = "publique";
		$p = $tab_conv_expr['M_UTILIS']['prive'];		$tab_role[$p] = "prive";
		$p = $tab_conv_expr['M_UTILIS']['no'];		$tab_yn[$p] = "no";
		$p = $tab_conv_expr['M_UTILIS']['yes'];		$tab_yn[$p] = "yes";
		$p = $tab_conv_expr['M_UTILIS']['off'];		$tab_oo[$p] = "off";
		$p = $tab_conv_expr['M_UTILIS']['on'];		$tab_oo[$p] = "on";

		unset ( $A , $B );
		while ($dbp = fetch_array_sql($dbquery)) { 
			foreach ( $dbp as $A => $B ) { $R[$A] = $B; }
		}

		$R['user_status']							= $tab_status[$R['user_status']];
		$R['user_role_fonction']					= $tab_role[$R['user_role_fonction']];
		$R['user_droit_forum']						= $tab_oo[$R['user_droit_forum']];
		$R['user_lang']								= $langues[$R['user_lang']]['langue_639_3'];
		$R['user_pref_newsletter']					= $tab_yn[$R['user_pref_newsletter']];
		$R['user_pref_montre_email']				= $tab_yn[$R['user_pref_montre_email']];
		$R['user_pref_montre_status_online']		= $tab_yn[$R['user_pref_montre_status_online']];
		$R['user_pref_notification_reponse_forum']	= $tab_yn[$R['user_pref_notification_reponse_forum']];
		$R['user_pref_notification_nouveau_pm']		= $tab_yn[$R['user_pref_notification_nouveau_pm']];
		$R['user_pref_autorise_bbcode']				= $tab_yn[$R['user_pref_autorise_bbcode']];
		$R['user_pref_autorise_html']				= $tab_yn[$R['user_pref_autorise_html']];
		$R['user_pref_autorise_smilies']			= $tab_yn[$R['user_pref_autorise_smilies']];
		$R['user_admin_commentaire']				= $tab_yn[$R['user_admin_commentaire']];

		if ( $R['user_pref_theme'] == 0 ) { $R['user_pref_theme'] = $_REQUEST['site_context']['theme_id']; } 

		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT sk.theme_nom, ss.theme_etat  
		FROM ".$SQL_tab_abrege['theme_descripteur']." sk , ".$SQL_tab_abrege['site_theme']." ss 
		WHERE ss.site_id = '".$_REQUEST['site_context']['site_id']."' 
		AND ss.theme_id = sk.theme_id 
		AND sk.theme_id ='".$R['user_pref_theme']."' 
		;");
		while ($dbp = fetch_array_sql($dbquery)) { 
			$R['user_pref_theme'] = $dbp['theme_nom'];
		}
	}
}

?>
