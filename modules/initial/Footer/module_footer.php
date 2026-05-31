<?php
// // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


//	Module : ModuleFooter
// --------------------------------------------------------------------------------------------

class ModuleFooter
{
	public function __construct()
	{
	}

	public function render($infos)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$Content = "";
		if ($CurrentSetObj->UserObj->hasPermission('group_default_read_permission') === true) {
			$bts->mapSegmentLocation(__METHOD__, "ModuleFooter");

			$l = $CurrentSetObj->getDataEntry('language');
			$bts->I18nTransObj->apply(array("type" => "file", "file" => $infos['module']['module_directory'] . "/i18n/" . $l . ".php", "format" => "php"));

			// https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png
			$Block = $CurrentSetObj->ThemeDataObj->getThemeName() . $infos['block'];
			$Content = "
			<table style='margin-left: auto; margin-right: auto;'>\r
			<tr>\r
			<td style='text-align: right;'>
			" . $bts->I18nTransObj->getI18nTransEntry('engine') . "<a href='http://" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_home') . "' target='new'>JanusEngine</a><br>" . $bts->I18nTransObj->getI18nTransEntry('author') . "<br>" . $bts->I18nTransObj->getI18nTransEntry('license') . "<span style='font-weight: bold;'>CC-by-nc-sa</span></td>\r
			<td style='text-align: left;'><a rel='license' href='http://creativecommons.org/licenses/by-nc-sa/4.0/'><img alt='Licence Creative Commons' style='border-width:0' src='http://mirrors.creativecommons.org/presskit/buttons/88x31/svg/by-nc-sa.svg'/></a></td>\r
			</tr>\r
			</table>\r
			";

			$bts->segmentEnding(__METHOD__);
		}

		if ($CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_info_debug') < 10) {
			unset(
				$localisation,
			);
		}
		return $Content;
	}
}
