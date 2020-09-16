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
		$MapperObj = Mapper::getInstance();
		$LMObj = LogManagement::getInstance();
		$CMObj = ConfigurationManagement::getInstance();
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$StringFormatObj = StringFormat::getInstance();
// 		$SMObj = SessionManagement::getInstance(null);
		
		$localisation = " / ModuleQuickSkin";
		$MapperObj->AddAnotherLevel($localisation );
		$LMObj->logCheckpoint("ModuleQuickSkin");
		$MapperObj->RemoveThisLevel($localisation );
		$MapperObj->setSqlApplicant("ModuleQuickSkin");
		
		$InteractiveElementsObj = InteractiveElements::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$DocumentDataObj = $CurrentSetObj->getInstanceOfDocumentDataObj();
		
		$l = $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('sw_lang'), 'langue_639_3');
		
		$i18n = array();
		include ($infos['module']['module_directory']."/i18n/".$l.".php");

		$logTarget = $LMObj->getInternalLogTarget();
		$LMObj->setInternalLogTarget("none");
		
		$Content = "
		<p class='" . $ThemeDataObj->getThemeName().$infos['block']."_p " . $ThemeDataObj->getThemeName().$infos['block']."_t3' style='text-align: left;'>
		<span class='" . $ThemeDataObj->getThemeName().$infos['block']."_tb2'>QuickSkin<br></span>\r
		".$i18n['txt1']." <span class='" . $ThemeDataObj->getThemeName().$infos['block']."_t3b'>".$ThemeDataObj->getThemeDataEntry('theme_titre')."<br></span>\r
		</p>
		";
		$grp = $UserObj->getUserGroupEntry('groupe', $infos['module']['module_groupe_pour_utiliser']);
		$LMObj->InternalLog( "QuickSkin module_groupe_pour_utiliser=" . $grp. "UserObj = " .$StringFormatObj->arrayToString($UserObj->getUser()) );
		if ( $grp == "1" ) {
			$dbquery = $SDDMObj->query("
			SELECT a.theme_id,a.theme_nom,a.theme_titre
			FROM ".$SqlTableListObj->getSQLTableName('theme_descripteur')." a , ".$SqlTableListObj->getSQLTableName('site_theme')." b
			WHERE b.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
			AND a.theme_id = b.theme_id
			AND b.theme_etat = '1'
			;");
			
			if ( $SDDMObj->num_row_sql($dbquery) > 0 ) {
				$Content .= "
				<form ACTION='index.php?' method='post'>\r
				<p class='" . $ThemeDataObj->getThemeName().$infos['block']."_p " . $ThemeDataObj->getThemeName().$infos['block']."_t3' style='text-align: center;'>
				".$i18n['txt2']."
				<select name='userForm[user_pref_theme]' class='" . $ThemeDataObj->getThemeName().$infos['block']."_form_1 " . $ThemeDataObj->getThemeName().$infos['block']."_t3'>
				";
				while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
					if ( $dbp['theme_id'] == $ThemeDataObj->getThemeDataEntry('theme_id') ) { $Content .= "<option value='".$dbp['theme_nom']."' selected>".$dbp['theme_titre']."</option>\r"; }
					else { 	$Content .= "<option value='".$dbp['theme_nom']."'>".$dbp['theme_titre']."</option>\r"; }
				}
				$Content .= "</select>\r
				<br>\r
				<input type='hidden' name='theme_activation' value='1'>\r".
				$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_ws').
				$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
				"
				<input type='hidden' name='arti_ref'						value='".$DocumentDataObj->getDocumentDataEntry('arti_ref')."'>\r
				<input type='hidden' name='arti_page'						value='".$DocumentDataObj->getDocumentDataEntry('arti_page')."'>
				<input type='hidden' name='formSubmitted'					value='1'>
				<input type='hidden' name='formGenericData[origin]'			value='ModuleQuickSkin'>
				<input type='hidden' name='formGenericData[modification]'	value='on'>

				</p>\r
								
				<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
				<tr>\r
				<td>\r
				";
				
// 				$SB as Submit Button
				$SB = array(
					"id"				=> "bouton_module_quicktheme",
					"type"				=> "submit",
					"initialStyle"		=> "" . $ThemeDataObj->getThemeName().$infos['block']."_t3 " . $ThemeDataObj->getThemeName().$infos['block']."_submit_s2_n",
					"hoverStyle"		=> "" . $ThemeDataObj->getThemeName().$infos['block']."_t3 " . $ThemeDataObj->getThemeName().$infos['block']."_submit_s2_h",
					"onclick"			=> "",
					"message"			=> $i18n['bouton'],
					"mode"				=> 0,
					"size" 				=> 0,
					"lastSize"			=> 0,
				);
				$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
				$Content .= "
				</td>\r
				</tr>\r
				</table>\r
				</form>\r
				<br>\r
				<p class='" . $ThemeDataObj->getThemeName().$infos['block']."_p' style='text-align: left;'>
				<a class='" . $ThemeDataObj->getThemeName().$infos['block']."_lien " . $ThemeDataObj->getThemeName().$infos['block']."_t3' href='index.php?arti_ref=fra_gestion_du_profil&amp;arti_page=1".$CurrentSetObj->getDataSubEntry('block_HTML','url_slup')."'>".$i18n['txt4']."</a>
				</p>\r
				";
			}
		}
		
		if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
			unset (
					$i18n,
					$localisation,
					$MapperObj,
					$LMObj,
					$MapperObj,
					$InteractiveElementsObj,
					$CurrentSetObj,
					$WebSiteObj,
					$ThemeDataObj,
					$CMObj,
					$SB
					);
		}
		
		$LMObj->setInternalLogTarget($logTarget);
		return $Content;
	
	}
}
?>