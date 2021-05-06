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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$localisation = " / ModuleSelectLanguage";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("ModuleSelectLanguage");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("ModuleSelectLanguage");
		
		$language_website_ = array();
		$Content = "";
		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_lang_select') == 1 ) {
			$dbquery = $bts->SDDMObj->query("SELECT * FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language').";");
			$pv['1'] = 1;
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$language_website_[$pv['1']]['lang_id']				= $dbp['lang_id'];
				$language_website_[$pv['1']]['lang_639_3']			= $dbp['lang_639_3'];
				$language_website_[$pv['1']]['lang_image']			= $dbp['lang_image'];
				$language_website_[$pv['1']]['lang_original_name']	= $dbp['lang_original_name'];
				$pv['1']++;
			}
			
			$language_website_support = array();
			$dbquery = $bts->SDDMObj->query("
				SELECT l.lang_id
				FROM "
				.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language_website')." lw, "
				.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language')." l
				WHERE lw.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
				AND lw.fk_lang_id = l.lang_id
				;");
			
			$Content .= "<table><tr>";
			
			if ( $bts->SDDMObj->num_row_sql($dbquery) > 1 ) {
				while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
					$pv['offset'] = $dbp['lang_id'];
					$language_website_support[$pv['offset']] = $pv['offset'];
				}
				foreach ( $language_website_support as $A ) {
					if ( $A == $language_website_[$A]['lang_id'] && $A != $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('lang') ) {
						$pv['1'] = $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_lang');
						$pv['1'] = $language_website_[$pv['offset']][$pv['1']];
						$baseUrl = $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url');
						if ( !file_exists ( "media/theme/". $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeDataEntry('theme_directory')."/".$language_website_[$A]['lang_image'] ) ) { $pv['img_src'] = $baseUrl."media/img/universal/".$language_website_[$A]['lang_image']; }
						else { $pv['img_src'] = $baseUrl."media/theme/".$CurrentSetObj->getInstanceOfThemeDataObj()->getThemeDataEntry('theme_directory')."/".$language_website_[$A]['lang_image']; }
						
						$Content .= "<td>
						<form ACTION='/' method='post'>\r
						<input type='hidden' name='formSubmitted'					value='1'>
						<input type='hidden' name='formGenericData[origin]'			value='ModuleSelectLanguage'>
						<input type='hidden' name='formGenericData[modification]'	value='on'>
						<input type='hidden' name='userForm[user_lang]'				value='".$language_website_[$A]['lang_639_3']."'>
						<button 
							style='background-color:#FF00FF00; border-width:0px; background-image: url(".$pv['img_src'].");height:64px; width:64px; background-size: cover;'
							onMouseOver=\"t.ToolTip('".$language_website_[$A]['lang_original_name']."')\"
							onMouseOut='t.ToolTip()'
						>
						</form>\r
						</td>";
					}
				}
			}
			$Content .= "</tr></table>";
		}
		return $Content;
	}
}
?>