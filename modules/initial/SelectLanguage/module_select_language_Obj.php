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
//	Module : ModuleSelectLanguage
// --------------------------------------------------------------------------------------------

class ModuleSelectLanguage {
	public function __construct(){}
	
	public function render ($infos) {
		$MapperObj = Mapper::getInstance();
		$LMObj = LogManagement::getInstance();
		$CMObj = ConfigurationManagement::getInstance();
		$SMObj = SessionManagement::getInstance(null);
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		
		$localisation = " / ModuleSelectLanguage";
		$MapperObj->AddAnotherLevel($localisation );
		$LMObj->logCheckpoint("ModuleSelectLanguage");
		$MapperObj->RemoveThisLevel($localisation );
		$MapperObj->setSqlApplicant("ModuleSelectLanguage");
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$SqlTableListObj = $CurrentSetObj->getInstanceOfSqlTableListObj();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();

// 		$l = $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('sw_lang'), 'langue_639_3');
// 		$i18n = array();
// 		include ("../modules/initial/Authentification/i18n/".$l.".php");

		$site_lang_ = array();
		$Content = "";
		if ( $WebSiteObj->getWebSiteEntry('sw_lang_select') == 1 ) {
			$dbquery = $SDDMObj->query("SELECT * FROM ".$SqlTableListObj->getSQLTableName('langues').";");
			$pv['1'] = 1;
			while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
				$site_lang_[$pv['1']]['langue_id']				= $dbp['langue_id'];
				$site_lang_[$pv['1']]['langue_639_3']			= $dbp['langue_639_3'];
				$site_lang_[$pv['1']]['langue_image']			= $dbp['langue_image'];
				$site_lang_[$pv['1']]['langue_nom_original']	= $dbp['langue_nom_original'];
				$pv['1']++;
			}
			
// 			unset ( $site_lang_support );
			$site_lang_support = array();
			$dbquery = $SDDMObj->query("
				SELECT b.langue_id
				FROM ".$SqlTableListObj->getSQLTableName('site_langue')." a, ".$SqlTableListObj->getSQLTableName('langues')." b
				WHERE a.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
				AND a.lang_id = b.langue_id
				;");
			
			$Content .= "<table><tr>";
			
			if ( $SDDMObj->num_row_sql($dbquery) > 1 ) {
				while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
					$pv['offset'] = $dbp['langue_id'];
					$site_lang_support[$pv['offset']] = $pv['offset'];
				}
				foreach ( $site_lang_support as $A ) {
					if ( $A == $site_lang_[$A]['langue_id'] && $A != $UserObj->getUserEntry('lang') ) {
						$pv['1'] = $WebSiteObj->getWebSiteEntry('sw_lang');
						$pv['1'] = $site_lang_[$pv['offset']][$pv['1']];
						if ( !file_exists ( "../graph/". $ThemeDataObj->getThemeDataEntry('theme_repertoire')."/".$site_lang_[$A]['langue_image'] ) ) { $pv['img_src'] = "../graph/universal/".$site_lang_[$A]['langue_image']; }
						else { $pv['img_src'] = "../graph/".$ThemeDataObj->getThemeDataEntry('theme_repertoire')."/".$site_lang_[$A]['langue_image']; }
						
						// a.theme_princ_B30_lien
						$Content .= "<td>
						<a class='".$ThemeDataObj->getThemeName().$infos['block']."_lien'
						href='index.php?".$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sdup')."&amp;M_UTILIS[login]=".$SMObj->getSessionEntry('LoginDecoded')."&amp;M_UTILIS[lang]=".$site_lang_[$A]['langue_639_3']."&amp;UPDATE_action=UPDATE_USER&amp;M_UTILIS[confirmation_modification]=1'
						onMouseOver=\"t.ToolTip('".$site_lang_[$A]['langue_nom_original']."')\"
						onMouseOut='t.ToolTip()'
						><img src='".$pv['img_src']."' alt='".$site_lang_[$A]['langue_639_3']."' height='64' width='64' border='0'>
						</a>\r</td>";
					}
				}
			}
			$Content .= "</tr></table>";
		}
		if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
			unset (
				$localisation,
				$MapperObj,
				$LMObj,
				$MapperObj,
				$CurrentSetObj,
				$WebSiteObj,
				$ThemeDataObj,
				$SqlTableListObj,
				$UserObj,
				$CMObj,
				$pv
				);
		}
		return $Content;
	}
}
?>