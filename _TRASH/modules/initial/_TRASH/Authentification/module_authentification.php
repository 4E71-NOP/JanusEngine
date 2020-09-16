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
//	Module : Authentification
// --------------------------------------------------------------------------------------------
$localisation = " / module_authentification";

$MapperObj = Mapper::getInstance();
$LMObj = LogManagement::getInstance();

$CurrentSet = CurrentSet::getInstance();
$WebSiteObj = $CurrentSet->getInstanceOfWebSiteObj();

$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_authentification");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_authentification");




$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_authentification");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$mod_auth_demande_connexion_resultat_test = "Connexion R&eacute;ussie";
$l = $langues[$WebSiteObj->getWebSiteEntry('sw_lang')]['langue_639_3'];

if ( $user['login_decode'] == "anonymous") {
	if ( $mod_auth_demande_connexion_resultat != 0 ) {
		$tl_['fra']['1'] = "Mauvais mot de passe"; 
		$tl_['eng']['1'] = "Wrong password"; 

		$tl_['fra']['2'] = "Login inexistant"; 
		$tl_['eng']['2'] = "Login doesn't exist"; 

		echo ("<span class='" . $theme_tableau . $_REQUEST['bloc']."_t3' style='text-align: center;'>". $tl_[$l][$mod_auth_demande_connexion_resultat] ."</span>"); 
	}		

	$tl_['fra']['id'] = "Identifiant";		$tl_['eng']['id'] = "Login";
	$tl_['fra']['ps'] = "Mot de passe";		$tl_['eng']['ps'] = "Password";

	echo ("
	<form ACTION='index.php?' method='post'>\r

	<table style='width:".(${$theme_tableau}['theme_module_largeur_interne']-16)."px; margin-right: auto; margin-left: auto'>\r
	<tr>\r
	<td class='".$theme_tableau.$_REQUEST['bloc']."_t3' style='text-align:center;'>".$tl_[$l]['id']."</td>\r</tr>\r
	<td class='".$theme_tableau.$_REQUEST['bloc']."_t3' style='text-align:center; padding-bottom:8px;'><input class='".$theme_tableau.$_REQUEST['bloc']."_form_1' type='text' name='da_user_login' size='16' maxlength='64' value='anonymous' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1 " . $theme_tableau . $_REQUEST['bloc']."_t3'></td>\r
	</tr>\r
	<tr>\r
	<td class='".$theme_tableau.$_REQUEST['bloc']."_t3' style='text-align:center;'>".$tl_[$l]['ps']."</td>\r</tr>\r
	<td class='".$theme_tableau.$_REQUEST['bloc']."_t3' style='text-align:center; padding-bottom:8px;'><input class='".$theme_tableau.$_REQUEST['bloc']."_form_1' type='password' name='da_user_pass' size='16' maxlength='64' value='anonymous' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1 " . $theme_tableau . $_REQUEST['bloc']."_t3'></td>\r
	</tr>\r
	</table>\r".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_arti_ref'].
	$bloc_html['post_hidden_arti_page']."
	<input type='hidden' name='mod_auth_demande_connexion' value='1'>\r

	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
	<tr>\r
	<td>\r
	");
	$tl_['eng']['login'] = "Log in";
	$tl_['fra']['login'] = "Se connecter";

	$_REQUEST['BS']['id']				= "bouton_authentif";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['login'];
	$_REQUEST['BS']['mode']				= 0;
	$_REQUEST['BS']['taille'] 			= 0;
	echo generation_bouton ();
	echo ("
	</td>\r
	</tr>\r
	</table>\r
	</form>\r
	");
}
else {
	$tl_['fra']['txt1'] = "Bienvenue : ";	$tl_['eng']['txt1'] = "Welcome : ";
	$tl_['fra']['deconnexion'] = "D&eacute;connexion";	$tl_['eng']['deconnexion'] = "Log off";
	$tl_['fra']['viassl'] = "(SSL actif)";				$tl_['eng']['viassl'] = "(SLL is on)";
	$tl_['fra']['via80'] = "(SSL inactif)";				$tl_['eng']['via80'] = "(SLL is off)";

	$_REQUEST['BS']['id']				= "bouton_deconexion";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= "" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
	$_REQUEST['BS']['style_hover']		= "" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['deconnexion'];
	$_REQUEST['BS']['mode']				= 0;
	$_REQUEST['BS']['taille'] 			= 0;
	$_REQUEST['BS']['derniere_taille']	= 0;

	$pv['SSL_etat'] = "<span class='" . $theme_tableau . $_REQUEST['bloc']."_fade'>\r".$tl_[$l]['via80']."</span>\r"; 
	if ( isset($_SERVER['HTTPS']) ) {
		if ( isset($_SERVER['SERVER_PORT'] ) && ( $_SERVER['SERVER_PORT'] == '443' ) ) { 
			$pv['SSL_etat'] = "<span class='" . $theme_tableau . $_REQUEST['bloc']."_fade'>\r".$tl_[$l]['viassl']."</span>\r"; 
		}
	}

	$pv['table_hauteur'] = 128;

	echo ("
	<form ACTION='index.php?' method='post'>\r
	<input type='hidden' name='user_login' value='anonymous'>\r
	<input type='hidden' name='user_pass' value=''>\r
	".$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l']."
	<input type='hidden' name='arti_ref' value=''>\r".
	$bloc_html['post_hidden_arti_page']."
	<input type='hidden' name='mod_auth_demande_connexion' value='1'>\r

	<table cellpadding='0' cellspacing='0' style='height: ".$pv['table_hauteur']."px; margin-left: auto; margin-right: auto;'>

	<tr>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_t3' style='text-align: center;'>\r".
	$tl_[$l]['txt1'].
	"<span class='" . $theme_tableau . $_REQUEST['bloc']."_tb3'>".$user['login_decode']."</span>\r
	</td>\r
	</tr>\r

	<tr>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_t3' style='text-align: center;'>\r
	<span style='text-align: center;'>\r
	" .
	generation_bouton () .
	"
	</span>\r
	</td>\r
	</tr>\r

	<tr>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_t1' style='text-align: center;'>\r".
	$pv['SSL_etat']	.
	"</td>\r
	</tr>\r
	</table>\r

	</form>\r
	");

}

if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { 
	unset (
	$tl_
	);
}

?>
