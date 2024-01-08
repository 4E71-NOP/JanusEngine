<?php
/*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
//	Module : ModuleSearch
// --------------------------------------------------------------------------------------------

class ModuleSearch
{
	public function __construct()
	{
	}

	public function render($infos)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$Content = "";
		if ($CurrentSetObj->getInstanceOfUserObj()->hasPermission('connected_group_read_permission') === true) {
			$localisation = " / ModuleSearch";
			$bts->MapperObj->AddAnotherLevel($localisation);
			$bts->LMObj->logCheckpoint("ModuleSearch");
			$bts->MapperObj->RemoveThisLevel($localisation);
			$bts->MapperObj->setSqlApplicant("ModuleSearch");

			$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();

			$l = $CurrentSetObj->getDataEntry('language');
			$bts->I18nTransObj->apply(array("type" => "file", "file" => $infos['module']['module_directory'] . "/i18n/" . $l . ".php", "format" => "php"));
			$Block = $ThemeDataObj->getThemeName() . $infos['block'];

			$Content = "";
			if ($CurrentSetObj->getInstanceOfUserObj()->hasPermission("connected_group_read_permission") == true) {
				$Content .= "<span>" . $bts->I18nTransObj->getI18nTransEntry('txt1') . "</span>"
					. $bts->RenderFormObj->renderformHeader("ModuleSearchForm")
					. $bts->RenderFormObj->renderHiddenInput("formGenericData[origin]",	"ModuleSearch")
					. $bts->RenderFormObj->renderHiddenInput("formSubmitted",			"1")
					. $bts->RenderFormObj->renderHiddenInput("arti_ref",				$l . "_recherche")
					. $bts->RenderFormObj->renderHiddenInput("arti_page",				"1")

					. "<table style='width:100%; margin-right:auto; margin-left:auto' >
				<tr>\r
				<td>\r"
					. $bts->RenderFormObj->renderRadioSelection("searchForm[searchType]", "T", $bts->I18nTransObj->getI18nTransEntry('radio1'), true)
					. "</td>\r
				</tr>\r
				
				<tr>\r
				<td>\r"
					. $bts->RenderFormObj->renderRadioSelection("searchForm[searchType]", "A", $bts->I18nTransObj->getI18nTransEntry('radio2'))
					. "</td>\r
				</tr>\r
					
				<tr>\r
				<td colspan=2 style='text-align: center;'>\r"
					. $bts->RenderFormObj->renderInputText("searchForm[search]", "", $bts->I18nTransObj->getI18nTransEntry('placeholder'), 10)
					. "</td>\r
				</tr>\r
				<tr>\r
				<td  colspan=2 style='text-align: center;'>\r
				";

				// 			$SB as Submit Button
				$SB = array(
					"id"				=> "bouton_module_recherche",
					"type"				=> "submit",
					"initialStyle"		=> $Block . "_submit_s1_n",
					"hoverStyle"		=> $Block . "_submit_s1_h",
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
			} else {
				$Content .= $bts->I18nTransObj->getI18nTransEntry('txt10');
			}
		}

		if ($CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10) {
			unset(
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
