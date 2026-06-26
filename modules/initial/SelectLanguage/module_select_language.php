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


//	Module : ModuleSelectLanguage
// --------------------------------------------------------------------------------------------

class ModuleSelectLanguage
{
	public function __construct()
	{
	}

	public function render($infos)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$Content = "";
		if ($CurrentSetObj->UserObj->hasPermission('connected_group_read_permission') === true) {
			$bts->mapSegmentLocation(__METHOD__, "ModuleSelectLanguage");

			$language_website_ = array();
			if ($CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_lang_select') == 1) {
				$dbquery = $bts->SDDMObj->query("SELECT "
					. "CONCAT('0x', HEX(lang_id)) AS lang_id, "
					. "lang_639_3, "
					. "lang_original_name, "
					. "lang_639_2, "
					. "lang_639_1, "
					. "lang_image "
					. "FROM " 
					. $CurrentSetObj->SqlTableListObj->getSQLTableName('language')
					. ";");
				while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
					$lid = $dbp['lang_id'];
					$language_website_[$lid]['lang_id']				= $dbp['lang_id'];
					$language_website_[$lid]['lang_639_3']			= $dbp['lang_639_3'];
					$language_website_[$lid]['lang_image']			= $dbp['lang_image'];
					$language_website_[$lid]['lang_original_name']	= $dbp['lang_original_name'];
				}

				$language_website_support = array();
				$dbquery = $bts->SDDMObj->query("SELECT " 
					. "CONCAT('0x', HEX(l.lang_id)) AS lang_id "
					. "FROM "
					. $CurrentSetObj->SqlTableListObj->getSQLTableName('language_website') . " lw, "
					. $CurrentSetObj->SqlTableListObj->getSQLTableName('language') . " l "
					. "WHERE lw.fk_ws_id = " . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id') . " "
					. "AND lw.fk_lang_id = l.lang_id "
					. ";");

				$Content .= "
				<table>\r
				<tbody>\r
				<tr>\r
				";

				if ($bts->SDDMObj->num_row_sql($dbquery) > 1) {
					while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
						$pv['offset'] = $dbp['lang_id'];
						$language_website_support[$pv['offset']] = $pv['offset'];
					}
					foreach ($language_website_support as $A) {
						if ($A == $language_website_[$A]['lang_id'] && $A != $CurrentSetObj->UserObj->getUserEntry('lang')) {
							$pv['1'] = $CurrentSetObj->WebSiteObj->getWebSiteEntry('fk_lang_id');
							$pv['1'] = $language_website_[$pv['offset']][$pv['1']];
							$baseUrl = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('baseUrl');
							if (!file_exists("media/theme/" . $CurrentSetObj->ThemeDataObj->getDefinitionValue('directory') . "/" . $language_website_[$A]['lang_image'])) {
								$pv['img_src'] = $baseUrl . "media/img/universal/" . $language_website_[$A]['lang_image'];
							} else {
								$pv['img_src'] = $baseUrl . "media/theme/" . $CurrentSetObj->ThemeDataObj->getDefinitionValue('directory') . "/" . $language_website_[$A]['lang_image'];
							}

							$Content .= "
							<td>\r"
								. $bts->RenderFormObj->renderformHeader("FormSelect_" . $language_website_[$A]['lang_639_3'])
								. $bts->RenderFormObj->renderHiddenInput("formGenericData[origin]",			"ModuleSelectLanguage")
								. $bts->RenderFormObj->renderHiddenInput("formGenericData[modification]",	"on")
								. $bts->RenderFormObj->renderHiddenInput("formSubmitted",					"1")
								. $bts->RenderFormObj->renderHiddenInput("userForm[user_lang]",				$language_website_[$A]['lang_639_3'])
								. "<button style='background-color:#FF00FF00; border-width:0px; background-image: url(" . $pv['img_src'] . "); height:64px; width:64px; background-size: cover;'\r
								onMouseOver=\"t.ToolTip('" . $language_website_[$A]['lang_original_name'] . "')\" onMouseOut='t.ToolTip()'>\r
								</button>\r
							</form>\r
							</td>";
						}
					}
				}
				$Content .= "
				</tr>\r
				</tbody>\r
				</table>\r";
			}

			$bts->segmentEnding(__METHOD__);
		}
		return $Content;
	}
}
