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
//	Module : ModuleSearch
// --------------------------------------------------------------------------------------------

class ModuleSearch {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$localisation = " / ModuleSearch";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("ModuleSearch");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("ModuleSearch");
		
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();

		$l = $CurrentSetObj->getDataEntry ('language');
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ) );
		$Block = $ThemeDataObj->getThemeName().$infos['block'];

		$Content = "";
		if ( $CurrentSetObj->getInstanceOfUserObj()->getUserGroupEntry('group', $infos['module']['module_group_allowed_to_use']) == 1 ) {
			$Content .= "<span>" . $bts->I18nTransObj->getI18nTransEntry('txt1') . "</span>
			<form ACTION='index.php?' method='post'>\r".
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_login').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_pass').
			"
			<input type='hidden' name='formSubmitted'	value='1'>
			<input type='hidden' name='origin'			value='ModuleSearch'>
			<input type='hidden' name='arti_ref'		value='".$l."_recherche'>\r
			<input type='hidden' name='arti_page'		value='1'>\r
			
			<table style='width:".($ThemeDataObj->getThemeDataEntry('theme_module_internal_width')-16)."px; margin-right:auto; margin-left:auto' >
			<tr>\r
			<td>\r
			<input type='radio' name='searchForm[searchType]'	value='T'>".$bts->I18nTransObj->getI18nTransEntry('radio1')."\r
			</td>\r
			</tr>\r
			
			<tr>\r
			<td>\r
			<input type='radio' name='searchForm[searchType]'	value='A' checked>".$bts->I18nTransObj->getI18nTransEntry('radio2')."\r
			</td>\r
			</tr>\r
				
			<tr>\r
			<td colspan=2 style='text-align: center;'>\r
			<input type='text' name='searchForm[search]' size='10' maxlength='64' value=''>
			</td>\r
			</tr>\r
			<tr>\r
			<td  colspan=2 style='text-align: center;'>\r
			";
			
			// 			$SB as Submit Button
			$SB = array(
				"id"				=> "bouton_module_recherche",
				"type"				=> "submit",
				"initialStyle"		=> $Block."_submit_s1_n",
				"hoverStyle"		=> $Block."_submit_s1_h",
				"onclick"			=> "",
				"message"			=> $bts->I18nTransObj->getI18nTransEntry('txt2'),
				"mode"				=> 0,
				"size" 				=> 0,
				"lastSize"			=> 0,
			);
			$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
			$Content .= "
			</td>\r
			</tr>\r
			</table>\r
			</form>\r
			";
		}
		
		else {
			$Content .= $bts->I18nTransObj->getI18nTransEntry('txt10');
		}
		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$localisation,
				$CurrentSetObj,
				$WebSiteObj,
				$ThemeDataObj,
				$SB
				);
		}
		return $Content;
	}
	
}
?>