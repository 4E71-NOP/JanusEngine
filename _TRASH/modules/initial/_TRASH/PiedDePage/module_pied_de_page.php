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
//	Module pied de page
// --------------------------------------------------------------------------------------------
$localisation = " / module_pied_de_page";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_pied_de_page");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_pied_de_page");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_pied_de_page");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$_REQUEST['sql_initiateur'] = "Module pied de page";
$l = $langues[$WebSiteObj->getWebSiteEntry('sw_lang')]['langue_639_3'];

$tl_['eng']['contenu'] = "
<table style='margin-left: auto; margin-right: auto;'>\r
<tr>\r
<td class='".$theme_tableau.$_REQUEST['bloc']."_t1' style='text-align: right;'>Powered by <a class='".$theme_tableau.$_REQUEST['bloc']."_lien' href='http://".$WebSiteObj->getWebSiteEntry('sw_home')."' target='_new'>MultiWeb-Manager</a><br>Author : FMA - 2005 - ∞<br>License : Creative commons <span style='font-weight: bold;'>CC-by-nc-sa</span></td>\r
<td class='".$theme_tableau.$_REQUEST['bloc']."_t1' style='text-align: left;'><a rel='license' href='http://creativecommons.org/licenses/by-nc-sa/4.0/'><img alt='Licence Creative Commons' style='border-width:0' src='https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png'/></a></td>\r
</tr>\r
</table>\r
";

$tl_['fra']['contenu'] = "
<table style='margin-left: auto; margin-right: auto;'>\r
<tr>\r
<td class='".$theme_tableau.$_REQUEST['bloc']."_t1' style='text-align: right;'>Mu par <a class='".$theme_tableau.$_REQUEST['bloc']."_lien' href='http://".$WebSiteObj->getWebSiteEntry('sw_home')."' target='_new'>MultiWeb-Manager</a><br>Auteur : FMA - 2005 - ∞<br>Sous license : Creative commons <span style='font-weight: bold;'>CC-by-nc-sa</span></td>\r
<td class='".$theme_tableau.$_REQUEST['bloc']."_t1' style='text-align: left;'><a rel='license' href='http://creativecommons.org/licenses/by-nc-sa/4.0/'><img alt='Licence Creative Commons' style='border-width:0' src='https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png'/></a></td>\r
</tr>\r
</table>\r
";
echo  $tl_[$l]['contenu'];


/*
<a href='http://www.creativecommons.org/' target='_new'><img src='../graph/universel/by-nc-sa.eu.png' height='48' width='137' border='0' alt='www.creativecommons.org'></a>


*/
?>
