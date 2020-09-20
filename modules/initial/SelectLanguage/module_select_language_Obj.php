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
		$StringFormatObj = StringFormat::getInstance();
		
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

// 		$l = $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('ws_lang'), 'lang_639_3');
// 		$i18n = array();
// 		include ("../modules/initial/Authentification/i18n/".$l.".php");
		$vars = get_defined_vars();
		
		$language_website_ = array();
		$Content = "";
		if ( $WebSiteObj->getWebSiteEntry('ws_lang_select') == 1 ) {
			$dbquery = $SDDMObj->query("SELECT * FROM ".$SqlTableListObj->getSQLTableName('language').";");
			$pv['1'] = 1;
			while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
				$language_website_[$pv['1']]['lang_id']				= $dbp['lang_id'];
				$language_website_[$pv['1']]['lang_639_3']			= $dbp['lang_639_3'];
				$language_website_[$pv['1']]['lang_image']			= $dbp['lang_image'];
				$language_website_[$pv['1']]['lang_original_name']	= $dbp['lang_original_name'];
				$pv['1']++;
			}
			
// 			unset ( $language_website_support );
			$language_website_support = array();
			$dbquery = $SDDMObj->query("
				SELECT b.lang_id
				FROM ".$SqlTableListObj->getSQLTableName('language_website')." a, ".$SqlTableListObj->getSQLTableName('language')." b
				WHERE a.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
				AND a.lang_id = b.lang_id
				;");
			
			$Content .= "<table><tr>";
			
			if ( $SDDMObj->num_row_sql($dbquery) > 1 ) {
				while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
					$pv['offset'] = $dbp['lang_id'];
					$language_website_support[$pv['offset']] = $pv['offset'];
				}
				foreach ( $language_website_support as $A ) {
					if ( $A == $language_website_[$A]['lang_id'] && $A != $UserObj->getUserEntry('lang') ) {
						$pv['1'] = $WebSiteObj->getWebSiteEntry('ws_lang');
						$pv['1'] = $language_website_[$pv['offset']][$pv['1']];
						if ( !file_exists ( "../gfx/". $ThemeDataObj->getThemeDataEntry('theme_directory')."/".$language_website_[$A]['lang_image'] ) ) { $pv['img_src'] = "../gfx/universal/".$language_website_[$A]['lang_image']; }
						else { $pv['img_src'] = "../gfx/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$language_website_[$A]['lang_image']; }
						
						// a.theme_princ_B30_lien
						$Content .= "<td>
						<a class='".$ThemeDataObj->getThemeName().$infos['block']."_lien'
						href='index.php?".$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sdup')."&amp;M_UTILIS[login]=".$SMObj->getSessionEntry('LoginDecoded')."&amp;M_UTILIS[lang]=".$language_website_[$A]['lang_639_3']."&amp;UPDATE_action=UPDATE_USER&amp;M_UTILIS[confirmation_modification]=1'
						onMouseOver=\"t.ToolTip('".$language_website_[$A]['lang_original_name']."')\"
						onMouseOut='t.ToolTip()'
						><img src='".$pv['img_src']."' alt='".$language_website_[$A]['lang_639_3']."' height='64' width='64' border='0'>
						</a>\r</td>";
					}
				}
			}
			$Content .= "</tr></table>";
		}
		
// 		$vars = get_defined_vars();
// 		$vars = array_diff(get_defined_vars(),$vars);
// 		$LMObj->InternalLog(array( 'level' => loglevelError, 'msg' => $StringFormatObj->arrayToString($vars)));
		if ( $WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
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