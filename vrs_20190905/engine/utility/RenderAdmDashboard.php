<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

class RenderAdmDashboard
{
	private static $Instance = null;

	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderAdmDashboard
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new RenderAdmDashboard();
		}
		return self::$Instance;
	}

	public function render()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;

		$bts->mapSegmentLocation(__METHOD__, "ModuleMenu");

		$Content = "";

		$dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('module') . " a, " . $CurrentSetObj->SqlTableListObj->getSQLTableName('module_website') . " b
			WHERE b.fk_ws_id = '" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id') . "'
			AND a.module_id = b.fk_module_id
			AND b.module_state = '1'
			AND a.fk_perm_id " . $CurrentSetObj->UserObj->getUserEntry('clause_in_perm') . "
			AND a.module_adm_control > '0'
			ORDER BY module_position
			;");

		if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
			$module_tab_adm_ = array();
			$i = 1;
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$module_tab_adm_[$i]['module_id']					= $dbp['module_id'];
				$module_tab_adm_[$i]['module_deco']					= $dbp['module_deco'];
				$module_tab_adm_[$i]['module_deco_nbr']				= $dbp['module_deco_nbr'];
				$module_tab_adm_[$i]['module_deco_default_text']	= $dbp['module_deco_default_text'];
				$module_tab_adm_[$i]['module_name']					= $dbp['module_name'];
				$module_tab_adm_[$i]['module_container_name']		= $dbp['module_container_name'];
				$module_tab_adm_[$i]['module_classname']			= $dbp['module_classname'];
				$module_tab_adm_[$i]['module_title']				= $dbp['module_title'];
				$module_tab_adm_[$i]['module_directory']			= $dbp['module_directory'];
				$module_tab_adm_[$i]['module_file']					= $dbp['module_file'];
				$module_tab_adm_[$i]['module_desc']					= $dbp['module_desc'];
				$module_tab_adm_[$i]['fk_perm_id']					= $dbp['fk_perm_id'];
				$module_tab_adm_[$i]['module_adm_control']			= $dbp['module_adm_control'];
				$i++;
			}

			// Default value in case of.
			$infos  = array(
				"mode" => 1,
				"module_display_mode" => "bypass",
				"module_z_index" => 1000,
				"block" => "B01",
				"blockG" => "B01G",
				"blockT" => "B01T",
				"deco_type" => $ThemeDataObj->getThemeBlockEntry("B01G", 'deco_type'),
				"module_deco_default_text" => $ThemeDataObj->getThemeBlockEntry("B01G", 'module_deco_default_text'),
				"admin_control" => array(
					"px" => 0,
					"py" => 0,
					"dx" => 0,
					"dy" => 0,
				),
			);

			$infos['module_z_index'] = 1000;
			$Content .= "
			<div id='AdminControlSwitch'
			class ='" . $ThemeDataObj->getThemeName() . "div_AdminControlSwitch'
			style='visibility:visible; z-index:" . $infos['module_z_index'] . ";'
			onClick=\"gr.switchDisplay('AdminControlBG','AdmDashboard', TabsData_AdmGrcd);\">
			</div>\r
			
			<div id='AdminControlBG'
			class ='" . $ThemeDataObj->getThemeName() . "FileSelectorContainer'
			style='display:none; visibility:hidden; z-index:" . ($infos['module_z_index'] + 1) . "; 
			width:100%; height:100%;
			top:0px; left:0px;' 
			onClick=\"gr.switchDisplay('AdminControlBG','AdmDashboard', TabsData_AdmGrcd);\">
			</div>

			<div id='AdmDashboard'
			class ='" . $ThemeDataObj->getThemeName() . "div_AdminControlPanel'
			style='display:none; visibility:hidden; overflow:hidden; z-index:" . ($infos['module_z_index'] + 2) . ";
			width:80%; height:80%;
			top:0px; left:0px;
			margin:0 auto; padding:10px;
			background-color:#" . $ThemeDataObj->getDefinitionValue('bg_color') . ";' 
			>\r
			";
			$infos['module_z_index'] += 4;

			// Position:
			// 0 	8	4
			// 2	10	6
			// 1	9	5
			$numPos = $ThemeDataObj->getDefinitionValue('admctrl_position');
			// is_numeric() sux
			if (preg_match('/^[0-9]+/i', $numPos) == 1 ) {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " admctrl_position is a number (" . $numPos . ")."));
			} else {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " admctrl_position isn't a number (" . $numPos . ")."));
				$numPos = 0;	// default value
			}

			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-OnLoad', "\telm.SetAdminSwitchLocation ( 'AdminControlSwitch', " . $numPos . ", " . $ThemeDataObj->getDefinitionValue('admctrl_width') . ", " . $ThemeDataObj->getDefinitionValue('admctrl_height') . ");");

			$cellList = array(
				1 => array('width' => '25%', 'height' => '100%', 'forcedWidth' => '100%',	'forcedHeight' => '100%',	'minWidth' => '2cm',	'minHeight' => '10cm'),
				2 => array('width' => '75%', 'height' => '100%', 'forcedWidth' => '100%',	'forcedHeight' => '100%',	'minWidth' => '6cm',	'minHeight' => '10cm'),
			);

			$n = 1;
			$Content .= "<table style='width:100%; height:100%; border-spacing:0px; border-collapse:collapse;'>\r
		<tr style=' padding:0px 0px 5px 0px;'>\r";

			foreach ($module_tab_adm_ as $m) {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT,  'msg' => "+--------------------------------------------------------------------------------+"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT,  'msg' => "| Rendering module '" . $m['module_name'] . "'" . str_repeat(" ", (63 - (strlen($m['module_name']) + 3))) . "|"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => "|                                                                                |"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => "+--------------------------------------------------------------------------------+"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT,  'msg' => __METHOD__ . " " . $bts->StringFormatObj->arrayToString($m)));

				$infos['module_name'] = $mn = &$m['module_name'];
				$Content .= "
			<!-- _______________________________________ Start " . $mn . " _______________________________________ -->\r
			<td style='width:" . $cellList[$n]['width'] . "; height:" . $cellList[$n]['height'] . "; min-width:" . $cellList[$n]['minWidth'] . "; min-height:" . $cellList[$n]['minHeight'] . ";'>
			";

				if ($CurrentSetObj->UserObj->hasPermission("admin_default_write_permission") == true) {
					if ($m['module_deco'] == 1) {
						$infos['block'] = $bts->StringFormatObj->getDecorationBlockName("B", $m['module_deco_nbr'], "");
					} else {
						$infos['block'] = "B01";
					}
					$infos['blockG'] = $infos['block'] . "G";
					$infos['blockT'] = $infos['block'] . "T";
					$infos['module'] = $m;
					$infos['forcedWidth'] = $cellList[$n]['forcedWidth'];
					$infos['forcedHeight'] = $cellList[$n]['forcedHeight'];

					$ModuleRendererName = $m['module_classname'];
					if (!class_exists($ModuleRendererName)) {
						$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " module file is : " . $m['module_directory'] . $m['module_file']));
						include($m['module_directory'] . $m['module_file']);
					} else {
						$Content .= "!! !! !! !!";
					}

					if (class_exists($ModuleRendererName)) {
						$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " module class name is : " . $ModuleRendererName));
						$ModuleRenderer = new $ModuleRendererName();
					} else {
						$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " Module classname doesn't exist. Something went wrong"));
						$infos['ModuleRendererName'] = $m['module_classname'];
						$ModuleRenderer = new ModuleNotFound();
					}

					// No need to execute before decoration or after. Render is inside !
					$Content .= $bts->RenderModuleObj->selectDecoration($infos);
					$Content .= $ModuleRenderer->render($infos);

					$Content .= "
				</div>\r
				</div>\r
				<!-- _______________________________________ Fin du module " . $mn . " _______________________________________ -->\r
				\r\r";

					$n++;
				}
				$Content .= "</td>\r";
			}
			$Content .= "
		</tr>\r
		</table>\r
		</div>\r";


			$bts->segmentEnding(__METHOD__);
			return $Content;
		}
	}
}
