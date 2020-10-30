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
//	Module : ModuleQuickSkin
// --------------------------------------------------------------------------------------------

class ModuleQuickSkin {
	public function __construct(){}
	
	public function render ($infos) {
		$cs = CommonSystem::getInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		
		$localisation = " / ModuleQuickSkin";
		$cs->MapperObj->AddAnotherLevel($localisation );
		$cs->LMObj->logCheckpoint("ModuleQuickSkin");
		$cs->MapperObj->RemoveThisLevel($localisation );
		$cs->MapperObj->setSqlApplicant("ModuleQuickSkin");
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$DocumentDataObj = $CurrentSetObj->getInstanceOfDocumentDataObj();
		
		$l = $cs->CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('ws_lang'), 'lang_639_3');
		
		$I18nObj = I18n::getInstance();
		$i18n = array();
		include ($infos['module']['module_directory']."/i18n/".$l.".php");
		$I18nObj->apply($i18n);
		
		$LOG_TARGET = $cs->LMObj->getInternalLogTarget();
		$cs->LMObj->setInternalLogTarget("none");
		
		$Content = "
		<table class='".$ThemeDataObj->getThemeName().$infos['block'].CLASS_TableStd."'>\r
		<tr>\r<td>\r
		".$I18nObj->getI18nEntry('txt1')." <span class='" . $ThemeDataObj->getThemeName().$infos['block']."_t3b'>".$ThemeDataObj->getThemeDataEntry('theme_title')."<br></span>\r
		</td>\r</tr>\r
		";
		$grp = $UserObj->getUserGroupEntry('group', $infos['module']['module_group_allowed_to_use']);
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' =>  "QuickSkin module_group_allowed_to_use=" . $grp. "UserObj = " .$cs->StringFormatObj->arrayToString($UserObj->getUser()) ));
		if ( $grp == "1" ) {
			$dbquery = $cs->SDDMObj->query("
			SELECT a.theme_id,a.theme_name,a.theme_title
			FROM ".$SqlTableListObj->getSQLTableName('theme_descriptor')." a , ".$SqlTableListObj->getSQLTableName('theme_website')." b
			WHERE b.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
			AND a.theme_id = b.theme_id
			AND b.theme_state = '1'
			;");
			
			if ( $cs->SDDMObj->num_row_sql($dbquery) > 0 ) {
				$Content .= "
				<form ACTION='index.php?' method='post'>\r
				<tr>\r<td>\r&nbsp;</td>\r</tr>\r
				<tr>\r<td>\r
				".$I18nObj->getI18nEntry('txt2')."
				</td>\r</tr>\r
				<tr>\r<td>\r
				<select name='userForm[user_pref_theme]' class='" . $ThemeDataObj->getThemeName().$infos['block']."_form_1 " . $ThemeDataObj->getThemeName().$infos['block']."_t3'>
				";
				while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) {
					if ( $dbp['theme_id'] == $ThemeDataObj->getThemeDataEntry('theme_id') ) { $Content .= "<option value='".$dbp['theme_name']."' selected>".$dbp['theme_title']."</option>\r"; }
					else { 	$Content .= "<option value='".$dbp['theme_name']."'>".$dbp['theme_title']."</option>\r"; }
				}
				$Content .= "</select>\r
				</td>\r</tr>\r
				
				<input type='hidden' name='theme_activation' value='1'>\r".
				$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_ws').
				$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
				"
				<tr>\r<td>\r&nbsp;</td>\r</tr>\r
				<tr>\r<td>\r
				<center>
				";
				
// 				$SB as Submit Button
				$SB = array(
					"id"				=> "bouton_module_quicktheme",
					"type"				=> "submit",
					"initialStyle"		=> $ThemeDataObj->getThemeName().$infos['block']."_submit_s2_n",
					"hoverStyle"		=> $ThemeDataObj->getThemeName().$infos['block']."_submit_s2_h",
					"onclick"			=> "",
					"message"			=> $I18nObj->getI18nEntry('bouton'),
					"mode"				=> 0,
					"size" 				=> 0,
					"lastSize"			=> 0,
				);
				$Content .= $cs->InteractiveElementsObj->renderSubmitButton($SB);
				$Content .= "
				</center>
				</td>\r</tr>\r
				<input type='hidden' name='arti_ref'						value='".$DocumentDataObj->getDocumentDataEntry('arti_ref')."'>\r
				<input type='hidden' name='arti_page'						value='".$DocumentDataObj->getDocumentDataEntry('arti_page')."'>
				<input type='hidden' name='formSubmitted'					value='1'>
				<input type='hidden' name='formGenericData[origin]'			value='ModuleQuickSkin'>
				<input type='hidden' name='formGenericData[modification]'	value='on'>

				</form>\r
				<tr>\r<td>\r&nbsp;</td>\r</tr>\r

				<tr>\r<td>\r
				<a href='index.php?arti_ref=fra_gestion_du_profil&amp;arti_page=1".$CurrentSetObj->getDataSubEntry('block_HTML','url_slup')."'>".$I18nObj->getI18nEntry('txt4')."</a>
				</td>\r</tr>\r
				</table>\r
				";
			}
		}
		
		if ( $WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
					$i18n,
					$localisation,
					$CurrentSetObj,
					$WebSiteObj,
					$ThemeDataObj,
					$SB
					);
		}
		
		$cs->LMObj->setInternalLogTarget($LOG_TARGET);
		return $Content;
	
	}
}
?>