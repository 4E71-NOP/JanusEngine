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
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$localisation = " / ModuleSelectLanguage";
		$cs->MapperObj->AddAnotherLevel($localisation );
		$cs->LMObj->logCheckpoint("ModuleSelectLanguage");
		$cs->MapperObj->RemoveThisLevel($localisation );
		$cs->MapperObj->setSqlApplicant("ModuleSelectLanguage");
		
		$language_website_ = array();
		$Content = "";
		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_lang_select') == 1 ) {
			$dbquery = $cs->SDDMObj->query("SELECT * FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language').";");
			$pv['1'] = 1;
			while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) {
				$language_website_[$pv['1']]['lang_id']				= $dbp['lang_id'];
				$language_website_[$pv['1']]['lang_639_3']			= $dbp['lang_639_3'];
				$language_website_[$pv['1']]['lang_image']			= $dbp['lang_image'];
				$language_website_[$pv['1']]['lang_original_name']	= $dbp['lang_original_name'];
				$pv['1']++;
			}
			
			$language_website_support = array();
			$dbquery = $cs->SDDMObj->query("
				SELECT b.lang_id
				FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language_website')." a, ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language')." b
				WHERE a.ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
				AND a.lang_id = b.lang_id
				;");
			
			$Content .= "<table><tr>";
			
			if ( $cs->SDDMObj->num_row_sql($dbquery) > 1 ) {
				while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) {
					$pv['offset'] = $dbp['lang_id'];
					$language_website_support[$pv['offset']] = $pv['offset'];
				}
				foreach ( $language_website_support as $A ) {
					if ( $A == $language_website_[$A]['lang_id'] && $A != $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('lang') ) {
						$pv['1'] = $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_lang');
						$pv['1'] = $language_website_[$pv['offset']][$pv['1']];
						if ( !file_exists ( "../media/theme/". $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeDataEntry('theme_directory')."/".$language_website_[$A]['lang_image'] ) ) { $pv['img_src'] = "../media/img/universal/".$language_website_[$A]['lang_image']; }
						else { $pv['img_src'] = "../media/theme/".$CurrentSetObj->getInstanceOfThemeDataObj()->getThemeDataEntry('theme_directory')."/".$language_website_[$A]['lang_image']; }
						
						$Content .= "<td>
						<a class='".$CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block']."_lien'
						href='index.php?".$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sdup')."&amp;M_UTILIS[login]=".$cs->SMObj->getSessionEntry('LoginDecoded')."&amp;M_UTILIS[lang]=".$language_website_[$A]['lang_639_3']."&amp;UPDATE_action=UPDATE_USER&amp;M_UTILIS[confirmation_modification]=1'
						onMouseOver=\"t.ToolTip('".$language_website_[$A]['lang_original_name']."')\"
						onMouseOut='t.ToolTip()'
						><img src='".$pv['img_src']."' alt='".$language_website_[$A]['lang_639_3']."' height='64' width='64' border='0'>
						</a>\r</td>";
					}
				}
			}
			$Content .= "</tr></table>";
		}
		

		return $Content;
	}
}
?>