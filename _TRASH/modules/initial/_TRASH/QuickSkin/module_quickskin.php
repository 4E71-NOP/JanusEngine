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
//	Module : quickskin
// --------------------------------------------------------------------------------------------
$localisation = " / module_quickskin";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("QuickSkin");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("QuickSkin");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("quickskin");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$_REQUEST['sql_initiateur'] = "Module quickskin";
$l = $langues[$WebSiteObj->getWebSiteEntry('sw_lang')]['langue_639_3'];

$tl_['eng']['txt1']		= "Actual theme"; 
$tl_['fra']['txt1']	= "Theme actuel:"; 

echo ("
<p class='" . $theme_tableau . $_REQUEST['bloc']."_p " . $theme_tableau . $_REQUEST['bloc']."_t3' style='text-align: left;'>
<span class='" . $theme_tableau . $_REQUEST['bloc']."_tb2'>QuickSkin<br></span>\r
".$tl_[$l]['txt1']." <span class='" . $theme_tableau . $_REQUEST['bloc']."_t3b'>".${$theme_tableau}['theme_titre']."<br></span>\r
</p>
");

if ( $user['groupe'][$module_['module_groupe_pour_utiliser']] == 1 ) { 
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT a.theme_id,a.theme_nom,a.theme_titre 
	FROM ".$SQL_tab_abrege['theme_descripteur']." a , ".$SQL_tab_abrege['site_theme']." b 
	WHERE b.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'  
	AND a.theme_id = b.theme_id 
	AND b.theme_etat = '1'
	;");

	$pv['1'] = $SQL_requete['nbr'] -1;
	if ( $SQL_requete[$pv['1']]['signal'] == "OK" ) {

		$tl_['eng']['txt2']		= "Change to : "; 
		$tl_['fra']['txt2']	= "Changer pour : "; 

		echo ("
		<form ACTION='index.php?' method='post'>\r
		<p class='" . $theme_tableau . $_REQUEST['bloc']."_p " . $theme_tableau . $_REQUEST['bloc']."_t3' style='text-align: center;'>
		".$tl_[$l]['txt2']."
		<select name='M_UTILIS[pref_theme]' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1 " . $theme_tableau . $_REQUEST['bloc']."_t3'>
		");
		while ($dbp = fetch_array_sql($dbquery)) { 
			if ( $dbp['theme_id'] == ${$theme_tableau}['theme_id'] ) { echo ("<option value='".$dbp['theme_nom']."' selected>".$dbp['theme_titre']."</option>\r"); }
			else { 	echo ("<option value='".$dbp['theme_nom']."'>".$dbp['theme_titre']."</option>\r"); }
		}
		echo ("</select>\r
		<br>\r
		<input type='hidden' name='theme_activation' value='1'>\r".
		$bloc_html['post_hidden_sw'] . 
		$bloc_html['post_hidden_l'] . 
		$bloc_html['post_hidden_user_login'] . 
		$bloc_html['post_hidden_user_pass'] . "
		<input type='hidden' name='arti_ref'	value=''>\r
		<input type='hidden' name='arti_page'	value='1'>
		<input type='hidden' name='M_UTILIS[login]'						value='".$user['login_decode']."'>\r
		<input type='hidden' name='M_UTILIS[confirmation_modification]'	value='1'>\r
		<input type='hidden' name='UPDATE_action'					value='UPDATE_USER'>\r

		</p>\r

		<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
		<tr>\r
		<td>\r
		");
		$tl_['eng']['bouton']		= "Apply";
		$tl_['fra']['bouton']	= "Changer theme";

		$tl_['eng']['txt4']			= "theme catalog"; 
		$tl_['fra']['txt4']		= "Catalogue des 'themes'"; 

		$_REQUEST['BS']['id']				= "bouton_module_quicktheme";
		$_REQUEST['BS']['type']				= "submit";
		$_REQUEST['BS']['style_initial']	= "" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
		$_REQUEST['BS']['style_hover']		= "" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
		$_REQUEST['BS']['onclick']			= "";
		$_REQUEST['BS']['message']			= $tl_[$l]['bouton'];
		$_REQUEST['BS']['mode']				= 0;
		$_REQUEST['BS']['taille'] 			= 0;
		$_REQUEST['BS']['derniere_taille']	= 0;
		echo generation_bouton ();
		echo ("
		</td>\r
		</tr>\r
		</table>\r
		</form>\r
		<br>\r
		<p class='" . $theme_tableau . $_REQUEST['bloc']."_p' style='text-align: left;'>
		<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_t3' href='index.php?arti_ref=fra_gestion_du_profil&amp;arti_page=1".$bloc_html['url_slup']."' onMouseOver = \"window.status = 'Catalogue des themes'; return true;\" onMouseOut=\"window.status = '".$WebSiteObj->getWebSiteEntry('sw_barre_status')."'; return true;\" >".$tl_[$l]['txt4']."</a>
		</p>\r
		");
	}
}

if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { 
	unset (
	$tl_,
	$pv
	);
}

?>
