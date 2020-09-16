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
//	Module : ModuleOffLineMessage
// --------------------------------------------------------------------------------------------

class ModuleOffLineMessage {
	public function __construct(){}
	
	public function render ($infos) {
		$ClassLoaderObj = ClassLoader::getInstance();
		
		$MapperObj = Mapper::getInstance();
		$LMObj = LogManagement::getInstance();
		$CMObj = ConfigurationManagement::getInstance();
		
		$localisation = " / ModuleOffLineMessage";
		$MapperObj->AddAnotherLevel($localisation );
		$LMObj->logCheckpoint("ModuleOffLineMessage");
		$MapperObj->RemoveThisLevel($localisation );
		$MapperObj->setSqlApplicant("ModuleOffLineMessage");
		
		$CurrentSet = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSet->getInstanceOfWebSiteObj();
		$ThemeDataObj = $CurrentSet->getInstanceOfThemeDataObj();
		$l = $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('sw_lang'), 'langue_639_3');
		
// 		$i18n = array();
// 		include ("../modules/initial/MessageHorsLigne/i18n/".$l.".php");
		
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
// 		include ("routines/website/module_deco_40_elegance.php");
		$infos['$module_z_index'] = 2;
		$affiche_module_mode = "normal";
		$WebSiteObj->getWebSiteEntry('sw_etat') = "OFFLINE";
		$ThemeDataObj->setThemeName("theme_princ_");
		
		echo ("
		<!DOCTYPE html>\r
						
		<html>\r
		<head>\r
		<meta http-equiv='Content-Type' content='text/html'; charset='utf-8'>\r
		<title>".$WebSiteObj->getWebSiteEntry('sw_titre')."</title>\r
		".$stylesheet."\r
		</head>\r
		<body text='".$ThemeDataObj->getThemeName().['B01T']['theme_s01_txt_col']."' link='".$ThemeDataObj->getThemeName().['B01T']['theme_s01_txt_l_01_fg_col']."' vlink='".$ThemeDataObj->getThemeName().['B01T']['theme_s01_txt_l_01_fg_visite_col']."' alink='".$ThemeDataObj->getThemeName().['B01T']['theme_s01_txt_l_01_fg_active_col']."' background='../graph/".$ThemeDataObj->getThemeName().['theme_repertoire']."/".$ThemeDataObj->getThemeName().['theme_bg']."'>\r\r
		<!-- ".$site_erreur_commentaire." ||  -->
		");
				
		$infos['module']['module_nom'] = "Total_fail"; 
		$mn = &$infos['module']['module_nom'];
		$pres_[$mn]['px'] = 32; 
		$pres_[$mn]['py'] = 32; 
		$pres_[$mn]['dx'] = 512; 
		$pres_[$mn]['dy'] = 256;
		
		$module_['module_deco_nbr'] = 1;
		$module_['module_deco'] = 1;
		$ClassLoaderObj->provisionClass('RenderDeco40Elegance');
		$RenderDeco = RenderDeco40Elegance::getInstance();
		$RenderDeco->render($ThemeDataObj, $RenderLayoutObj, $GeneratedJavaScriptObj, $infos);
				
		echo ("
		<span class='".$ThemeDataObj->getThemeName().$infos['block']."_tb7'>".$WebSiteObj->getWebSiteEntry('sw_nom')."</span>
		<hr>\r
		<br>\r
		<p class='".$ThemeDataObj->getThemeName().$infos['block']."_t4'>
		".$WebSiteObj->getWebSiteEntry('sw_message')."
		</p>
		</div>\r
		</body>\r
		</html>\r
						
		");
		exit ();
	
	}
}
?>