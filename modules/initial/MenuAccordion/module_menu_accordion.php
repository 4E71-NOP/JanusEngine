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


//	Module : ModuleMenu
// --------------------------------------------------------------------------------------------

class ModuleMenuAccordion
{
	private $menuData;
	private $localContent = "";
	private $menuLevel = 0;
	private $Block;
	private $offsetLeft = 10;
	private $iconSize = 24;


	public function __construct() {}

	/**
	 * Renders the menu and sets the necessary assets (javascript, etc.)
	 * 
	 * @param array
	 * @return string
	 */
	public function render($infos)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$this->Block = $CurrentSetObj->ThemeDataObj->getThemeName() . $infos['block'];

		$Content = "";


		if ($CurrentSetObj->UserObj->hasPermission('group_default_read_permission') === true) {

			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : path = `" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/" . $infos['module']['module_directory'] . "menuAccordion/i18n/" . "`"));

			$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/" . $infos['module']['module_directory'] . "/i18n/");

			$ClassLoaderObj = ClassLoader::getInstance();
			$ClassLoaderObj->provisionClass('MenuData');

			$MenuDataObj = new MenuData();
			$MenuDataObj->RenderMenuData();

			$this->menuData = $MenuDataObj->getMenuDataRaw();
			// $bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Raw = " . $bts->StringFormatObj->print_r_debug($this->menuData) . ""));

			$rootMenuid = $this->findRootMenu($this->menuData);
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : rootMenuid = `" . $rootMenuid . "`"));
			if ($rootMenuid != 0) {
				$this->localContent = "<!-- Menu rendering -->\r";

				$this->processMenu($rootMenuid);

				$this->localContent .= "<div style='height:64px;'>\r"
					. "</div>\r"
					. "<!-- Menu end -->\r";
				$Content .= $this->localContent;
			}

			$JavaScriptContent = "ma = new MenuAccordion();\r";
			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-File', $infos['module']['module_directory'] . 'javascript/MenuAccordion.js');
			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-Init', $JavaScriptContent);
			$CurrentSetObj->GeneratedScriptObj->insertString('Css-File', $infos['module']['module_directory'] . 'css/MenuAccordion.css');
		}

		if ($CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_info_debug') < 10) {
			unset(
				$i18n,
			);
		}
		return $Content;
	}

	private function hasChildren($id)
	{
		reset($this->menuData);
		foreach ($this->menuData as $A) {
			if ($A['menu_parent'] == $id) {
				return true;
			}
		}
		return false;
	}


	private function findRootMenu($dataSet)
	{
		foreach ($dataSet as $A) {
			if ($A['menu_type'] == 0) {
				return $A['menu_id'];
			}
		}
		return 0;
	}
	private function getChildren($id)
	{
		$children = array();
		reset($this->menuData);
		foreach ($this->menuData as $A) {
			if ($A['menu_parent'] == $id) {
				$children[$A['menu_id']] = $A;
			}
		}
		return $children;
	}

	private function getMenuRaw($id)
	{

		return $this->menuData[$id];
	}

	private function processMenu($id)
	{
		$bts = BaseToolSet::getInstance();

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Processing = `" . $id . "`"));

		if ($this->hasChildren($id) == true) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Menu `" . $id . "` has children"));
			$this->localContent .= "<div class='menuAccordionTitle' "
				. (($this->menuLevel > 0) ? "style='padding-left:" . ($this->menuLevel * $this->offsetLeft) . "px;' " : "")
				. (($this->menuLevel != 0) ? "onClick=\"ma.toggleMenuAccordion('sub" . $id . "')\" " : "") . ">"
				. "<div class='" . $this->Block . "_icon_directory' style='width:" . $this->iconSize . "px; height:" . $this->iconSize . "px; display:inline-block; margin-right:" . $this->offsetLeft . "px;'></div>"
				. $this->menuData[$id]['menu_title'] . "</div>\r";

			$this->localContent .= "<div " . (($this->menuLevel != 0) ? "class='menuGroup menuGroupFold' " : "")
				// . (($this->menuLevel > 0) ? "style='margin-left:" . ($this->menuLevel * $this->offsetLeft) . "px;' " : "")
				. "id='sub" . $id . "'>\r";

			$subMenus = $this->getChildren($id);
			$this->menuLevel++;
			foreach ($subMenus as $A) {
				$this->processMenu($A['menu_id']);
			}
			$this->menuLevel--;
			$this->localContent .= "</div>\r";
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Menu `" . $this->menuData[$id]['menu_title'] . "` has no children"));
			$this->localContent .= "<div class='menuAccordionLink' "
				. (($this->menuLevel > 0) ? "style='padding-left:" . ($this->menuLevel * $this->offsetLeft) . "px;' " : "")
				. ">"
				. "<a href='/" . $this->menuData[$id]['fk_arti_slug'] . "'>"
				. $this->menuData[$id]['menu_title'] . "</a>\r</div>\r";
		}
	}
}
