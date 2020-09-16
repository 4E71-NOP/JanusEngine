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

if ( $WebSiteObj->getWebSiteEntry('sw_etat') != 1 ) {
//include ("routines/website/fonctions_universelles.php");
//	$_REQUEST['bloc'] = decoration_nomage_bloc ( "B" , "1" , "" );
}

if ( $_REQUEST['SQL_fatal_error'] == 1 ) {
	$WebSiteObj->getWebSiteEntry('sw_nom') = "Doh!!!";
	$WebSiteObj->getWebSiteEntry('sw_message') = "Probl&egrave;me de connexion &agrave; la base de donn&eacute;es";
	$site_erreur_commentaire = "Doh!!!";
	$WebSiteObj->getWebSiteEntry('sw_titre') = "Doh!!!";
}

if ( $WebSiteObj->getWebSiteEntry('banner_offline') == 1 ) {
	$WebSiteObj->getWebSiteEntry('sw_message') = "FR : Le site est hors ligne.<br><br>ENG: The website is offline.";
	$site_erreur_commentaire = "Doh!!!";
}

$_REQUEST['bloc'] = "B01";
$_REQUEST['blocG'] = "B01G";
$_REQUEST['blocT'] = "B01T";
include ("../stylesheets/css_admin_install.php");
include ("routines/website/module_deco_40_elegance.php");
$module_z_index['compteur'] = 2;
$affiche_module_mode = "normal";
$WebSiteObj->getWebSiteEntry('sw_etat') = "OFFLINE";
$theme_tableau = "theme_princ_";

echo ("
<!DOCTYPE html>\r

<html>\r
<head>\r
<meta http-equiv='Content-Type' content='text/html'; charset='utf-8'>\r
<title>".$WebSiteObj->getWebSiteEntry('sw_titre')."</title>\r
".$stylesheet."\r
</head>\r
<body text='".$theme_princ_['B01T']['theme_s01_txt_col']."' link='".$theme_princ_['B01T']['theme_s01_txt_l_01_fg_col']."' vlink='".$theme_princ_['B01T']['theme_s01_txt_l_01_fg_visite_col']."' alink='".$theme_princ_['B01T']['theme_s01_txt_l_01_fg_active_col']."' background='../graph/".$theme_princ_['theme_repertoire']."/".$theme_princ_['theme_bg']."'>\r\r
<!-- ".$site_erreur_commentaire." ||  -->
");


$module_['module_nom'] = "Total_fail"; $mn = &$module_['module_nom'];
$pres_[$mn]['px'] = 32; $pres_[$mn]['py'] = 32; $pres_[$mn]['dx'] = 512; $pres_[$mn]['dy'] = 256; $module_['module_deco_nbr'] = 1; 
$module_['module_deco'] = 1;
choix_decoration ( "40" );

echo ("
<span class='".$theme_tableau.$_REQUEST['bloc']."_tb7'>".$WebSiteObj->getWebSiteEntry('sw_nom')."</span>
<hr>\r
<br>\r
<p class='".$theme_tableau.$_REQUEST['bloc']."_t4'>
".$WebSiteObj->getWebSiteEntry('sw_message')."
</p>
</div>\r
</body>\r
</html>\r

");
exit ();

?>
