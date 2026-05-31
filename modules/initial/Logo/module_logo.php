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


//	Module : ModuleLogo
// --------------------------------------------------------------------------------------------

class ModuleLogo {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$bts->mapSegmentLocation(__METHOD__, "ModuleLogo");
		
		$l = $CurrentSetObj->getDataEntry('language');
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ) );
		// $i18n = array();
		// include ($infos['module']['module_directory']."/i18n/".$l.".php");
		// $bts->I18nTransObj->apply($i18n);
		// unset ($i18n);

		$listNumber = $bts->CMObj->getConfigurationSubEntry($infos['module_name'], 'listNumber');
		$n = $listNumber[random_int(0,9)];
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Module '".$infos['module_name']."' is greeting you with the Fibonacci number : " . $n));

		$Content = "";

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "Module '" . $infos['module_name'] . "' Link homepage as : '" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "'."));
		$Content .= "
		<div style='text-align: center;'>\r
		<a href='/' onMouseOver=\"t.ToolTip('" . $bts->SDDMObj->escapeString($bts->I18nTransObj->getI18nTransEntry('tooltip')) . "')\" onMouseOut=\"t.ToolTip()\">\r
		<img src='" .
			$CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url')
			. "media/theme/" . $CurrentSetObj->ThemeDataObj->getDefinitionValue('directory')
			. "/" . $CurrentSetObj->ThemeDataObj->getDefinitionValue('logo')
			. "' alt='" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_name') . "' style='border:0px'
		>\r
		</a>\r
		</div>\r
		";

		// Cleaning up
		if ( $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$localisation,
				$CurrentSetObj,
				);
		}
		
		$bts->segmentEnding(__METHOD__);
		return $Content;
		
	}
}
?>