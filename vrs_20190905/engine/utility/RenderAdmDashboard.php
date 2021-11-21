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

class RenderAdmDashboard {
	private static $Instance = null;
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderAdmDashboard
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderAdmDashboard ();
		}
		return self::$Instance;
	}
	
	public function render(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$RenderLayoutObj = RenderLayout::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$localisation = " / ModuleMenu";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("ModuleMenu");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("ModuleMenu");
		
		$Content = "";
		
		$dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module')." a, ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module_website')." b
			WHERE b.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry ('ws_id')."'
			AND a.module_id = b.fk_module_id
			AND b.module_state = '1'
			AND a.module_group_allowed_to_see ". $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('clause_in_group')."
			AND a.module_adm_control > '0'
			ORDER BY module_position
			;");
		
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$module_tab_adm_ = array();
			$i = 1;
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$module_tab_adm_[$i]['module_id']					= $dbp['module_id'];
				$module_tab_adm_[$i]['module_deco']					= $dbp['module_deco'];
				$module_tab_adm_[$i]['module_deco_nbr']				= $dbp['module_deco_nbr'];
				$module_tab_adm_[$i]['module_deco_default_text']	= $dbp['module_deco_default_text'];
				$module_tab_adm_[$i]['module_name']					= $dbp['module_name'];
				$module_tab_adm_[$i]['module_name']					= str_replace ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_short') , "" , $module_tab_adm_[$i]['module_name'] ); // trouver pourquoi enlever le tag MWM (ou RW) du nom)
				$module_tab_adm_[$i]['module_classname']			= $dbp['module_classname'];
				$module_tab_adm_[$i]['module_title']				= $dbp['module_title'];
				$module_tab_adm_[$i]['module_directory']			= $dbp['module_directory'];
				$module_tab_adm_[$i]['module_file']					= $dbp['module_file'];
				$module_tab_adm_[$i]['module_desc']					= $dbp['module_desc'];
				$module_tab_adm_[$i]['module_group_allowed_to_see']	= $dbp['module_group_allowed_to_see'];
				$module_tab_adm_[$i]['module_group_allowed_to_use']	= $dbp['module_group_allowed_to_use'];
				$module_tab_adm_[$i]['module_adm_control']			= $dbp['module_adm_control'];
				$i++;
			}
		
		// Default value in case of.
		$infos  = array (
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

		foreach ( $module_tab_adm_ as $m ) {
			$dimAdmModules += $RenderLayoutObj->getLayoutModuleEntry($m['module_name'], 'dx');
		}
		
		$Content .= "
			<div id='AdminControlSwitch'
			class ='".$ThemeDataObj->getThemeName()."div_AdminControlSwitch'
			style='visibility:visible; z-index:".$infos['module_z_index'].";'
			onClick=\"elm.SwitchDisplayCenter('AdmDashboard'); elm.FillScreenDiv ('AdminControlBG',1);\">
			</div>\r
							
			<div id='AdminControlBG'
			class ='".$ThemeDataObj->getThemeName()."FileSelectorContainer'
			style='display:none; visibility:hidden; z-index:".($infos['module_z_index']+1).";'
			OnClick=\"elm.SwitchDisplay('AdmDashboard'); elm.FillScreenDiv('AdminControlBG',0);\">\r
			</div>\r
							
			<div id='AdmDashboard'
			class ='".$ThemeDataObj->getThemeName()."div_AdminControlPanel'
			style='display:none; visibility:hidden; overflow:hidden; width:".($dimAdmModules+16)."px; background-color:#".$ThemeDataObj->getThemeDataEntry('theme_bg_color').";  z-index:".($infos['module_z_index']+2)."; padding:5px'
			>\r
			";
		$infos['module_z_index'] += 4;

		// Position:
		// 0 	8	4
		// 2	10	6
		// 1	9	5
		
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript('OnLoad', "\telm.SetAdminSwitchLocation ( 'AdminControlSwitch', ".$ThemeDataObj->getThemeDataEntry('theme_admctrl_position').", ".$ThemeDataObj->getThemeDataEntry('theme_admctrl_width').", ".$ThemeDataObj->getThemeDataEntry('theme_admctrl_height').");");
		
		$n = 1;
		foreach ( $module_tab_adm_ as $m ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "+--------------------------------------------------------------------------------+"));
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "| Rendering module '".$m['module_name']. "'" . str_repeat(" ",(63 - (strlen($m['module_name'])+3))) . "|" ));
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "|                                                                                |"));
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "+--------------------------------------------------------------------------------+"));
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." " . $bts->StringFormatObj->arrayToString($m)));
			
			$infos['module_name'] = $mn = &$m['module_name'];
			$Content .= "<!-- _______________________________________ Start ".$mn." _______________________________________ -->\r";
			
			if ( $CurrentSetObj->getInstanceOfUserObj()->getUserGroupEntry('group', $m['module_group_allowed_to_see'] ) == 1 ) {
				if ( $m['module_deco'] == 1 ) { 
					$infos['block'] = $bts->StringFormatObj->getDecorationBlockName( "B", $m['module_deco_nbr'] , ""); 
				}
				else { $infos['block'] = "B01"; }
				$infos['blockG'] = $infos['block']."G"; 
				$infos['blockT'] = $infos['block']."T"; 
				$infos['module'] = $m;
				
				$ModuleRendererName = $m['module_classname'];
				if (!class_exists($ModuleRendererName)) {
					$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "module file is : " . $m['module_directory'].$m['module_file']));
					include ($m['module_directory'].$m['module_file']);
				} else { $Content .= "!! !! !! !!"; }
				
				if (class_exists($ModuleRendererName)) { 
					$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "module class name is : ". $ModuleRendererName));
					$ModuleRenderer = new $ModuleRendererName(); 
				}
				else { 
					$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_WARNING , 'msg' => "Module classname doesn't exist. Something went wrong"));
					$infos['ModuleRendererName'] = $m['module_classname'];
					$ModuleRenderer = new ModuleNotFound(); 
				}
				
				// No need to execute before decoration or after. Render is inside !
				$Content .= $bts->RenderModuleObj->selectDecoration($infos);
				$Content .= $ModuleRenderer->render($infos);
				
				$Content .= "</div>\r</div>\r<!-- _______________________________________ Fin du module ".$mn." _______________________________________ -->\r\r\r\r\r";
				$n++;
				
			}
			$infos['admin_control']['px'] += $RenderLayoutObj->getLayoutModuleEntry($mn, 'dx');
			$infos['admin_control']['dx'] += $RenderLayoutObj->getLayoutModuleEntry($mn, 'dx');
			$infos['module_z_index']+=2;
			if ( $RenderLayoutObj->getLayoutModuleEntry($mn, 'dy') > $infos['admin_control']['dy']) {  $infos['admin_control']['dy'] = $RenderLayoutObj->getLayoutModuleEntry($mn, 'dy'); }
		}
		
		$Content .= "</div>\r";
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript('Command', "elm.ResizeDiv ( 'AdmDashboard' , ".$infos['admin_control']['dx']." , ".$infos['admin_control']['dy']." );");

		return $Content;
		}
	
	}
	
}
?>