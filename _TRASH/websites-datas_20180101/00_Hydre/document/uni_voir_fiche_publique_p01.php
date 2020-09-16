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
//$_REQUEST['theme_demande'] = 3;
$_REQUEST['fiche_id'] = 1;
/*Hydre-contenu_debut*/
$_RESQUEST['sql_initiateur'] = "uni_voir_fiche_publique_p01";

if ( $user['login_decode'] == "anonymous" ) { echo ("Partie reserv&eacute;e aux membres enregistr&eacute;s"); }
else {
	if ( !function_exists("genere_onglet_html") ) { 
		$JavaScriptFichier['']    = "routines/website/javascript_onglet.js";	
		include ("routines/website/decoration_onglet.php");
	}

/* -------------------------------------------------------------------------------------------- */
	$tl_['eng']['modif_profil'] = "Update profile";
	$tl_['fra']['modif_profil'] = "Modifier le profil";

	echo ("
	<p class='".$theme_tableau.$_REQUEST['bloc']."_t3'>
	<br>\r
	");

	if ( $user['pref_theme'] == 0 ) { $user['pref_theme'] = $site_web['theme_id']; }
	$dbquery = requete_sql($_RESQUEST['sql_initiateur'],"
	SELECT *
	FROM ".$SQL_tab_abrege['user']." 
	WHERE user_id = '".$_REQUEST['fiche_id']."' 
	;");
	while ($dbp = fetch_array_sql($dbquery)) { 
		foreach ( $dbp as $A => $B ) { $PmListTheme['$A'] = $B; }
		$PmListTheme['user_date_inscription']	= strftime ("%a %d %b %y - %H:%M", $dbp['user_date_inscription'] );
		$PmListTheme['user_derniere_visite']	= strftime ("%a %d %b %y - %H:%M", $dbp['user_derniere_visite'] );
	}

/* -------------------------------------------------------------------------------------------- */
	$tl_['eng']['avatar'] = "Avatar";	$tl_['eng']['login'] = "Login";	$tl_['eng']['inscription'] = "Inscription";	$tl_['eng']['msg'] = "Send message";
	$tl_['fra']['avatar'] = "Avatar";	$tl_['fra']['login'] = "Login";	$tl_['fra']['inscription'] = "Inscription";	$tl_['fra']['msg'] = "Envoyer un message";

	echo ("
	<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r

	<tr>\r
	<td class='".$theme_tableau.$_REQUEST['bloc']."_fcta ".$theme_tableau.$_REQUEST['bloc']."_t3'>".$tl_['$l']['avatar']."</td>\r
	<td class='".$theme_tableau.$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t3'><img src='".$user['user_image_avatar']."' width='48' height='48' alt='Avatar'></td>\r
	</tr>\r

	<tr>\r
	<td class='".$theme_tableau.$_REQUEST['bloc']."_fcta ".$theme_tableau.$_REQUEST['bloc']."_t3'>".$tl_['$l']['login']."</td>\r
	<td class='".$theme_tableau.$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t3'>".$PmListTheme['user_login']."</td>\r
	</tr>\r

	<tr>\r
	<td class='".$theme_tableau.$_REQUEST['bloc']."_fcta ".$theme_tableau.$_REQUEST['bloc']."_t3'>".$tl_['$l']['inscription']."</td>\r
	<td class='".$theme_tableau.$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t3'>".$PmListTheme['user_date_inscription']."</td>\r
	</tr>\r

	</table>\r
	<br>\r
	<br>\r

	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
	<tr>\r
	<td>\r
	<form ACTION='index.php?' method='post'>\r".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_arti_ref']."
	<input type='hidden' name='arti_page'	value='3'>\r".
	$bloc_html['post_hidden_user_login'].
	$bloc_html['post_hidden_user_pass']
	);
	$_REQUEST['BS']['id']				= "bouton_msg_user";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= "theme_princ_".$_REQUEST['bloc']."_t3 ".$theme_tableau.$_REQUEST['bloc']."_submit_s2_n";
	$_REQUEST['BS']['style_hover']		= "theme_princ_".$_REQUEST['bloc']."_t3 ".$theme_tableau.$_REQUEST['bloc']."_submit_s2_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_['$l']['msg'];
	$_REQUEST['BS']['mode']				= 0;
	$_REQUEST['BS']['taille'] 			= 0;
	$_REQUEST['BS']['derniere_taille']	= 0;
	echo generation_bouton ();
	echo ("<br>\r&nbsp;
	</form>\r
	</td>\r
	</tr>\r
	</table>\r
	");

/* -------------------------------------------------------------------------------------------- */
}

if ( $site_web['sw_info_debug'] < 10 ) {  }
	unset (
		$dbp , 
		$dbquery ,
		$tl_ , 
		$PmListTheme 
	);

/*Hydre-contenu_fin*/
?>
