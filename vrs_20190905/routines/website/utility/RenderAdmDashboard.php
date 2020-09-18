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
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderAdmDashboard ();
		}
		return self::$Instance;
	}
	
	public function render(){
		$CurrentSetObj = CurrentSet::getInstance();
		$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
		$LMObj = LogManagement::getInstance();
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$StringFormatObj = StringFormat::getInstance();
		
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$RenderLayoutObj = RenderLayout::getInstance();
		
		$MapperObj = Mapper::getInstance();
		
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$CMObj = ConfigurationManagement::getInstance();
		
		$localisation = " / ModuleMenu";
		$MapperObj->AddAnotherLevel($localisation );
		$LMObj->logCheckpoint("ModuleMenu");
		$MapperObj->RemoveThisLevel($localisation );
		$MapperObj->setSqlApplicant("ModuleMenu");
		
		
		$ModuleTable = $RenderLayoutObj->getModuleList();
		$Content = "";
		
		$dbquery = $SDDMObj->query("
			SELECT *
			FROM ".$SqlTableListObj->getSQLTableName('module')." a, ".$SqlTableListObj->getSQLTableName('module_website')." b
			WHERE b.ws_id = '".$WebSiteObj->getWebSiteEntry ('ws_id')."'
			AND a.module_id = b.module_id
			AND b.module_state = '1'
			AND a.module_groupe_pour_voir ". $UserObj->getUserEntry('clause_in_groupe')."
			AND a.module_adm_control > '0'
			ORDER BY module_position
			;");
		
// 		$Content .= "<!--\r
// 			RenderAdmDashboard:Render 
// 			SELECT *
// 			FROM ".$SqlTableListObj->getSQLTableName('module')." a, ".$SqlTableListObj->getSQLTableName('module_website')." b
// 			WHERE b.ws_id = '".$WebSiteObj->getWebSiteEntry ('ws_id')."'
// 			AND a.module_id = b.module_id
// 			AND b.module_state = '1'
// 			AND a.module_groupe_pour_voir ". $UserObj->getUserEntry('clause_in_groupe')."
// 			AND a.module_adm_control > '0'
// 			ORDER BY module_position
// 			;
// 			-->";

		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$module_tab_adm_ = array();
			$i = 1;
			while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
				$module_tab_adm_[$i]['module_id']					= $dbp['module_id'];
				$module_tab_adm_[$i]['module_deco']					= $dbp['module_deco'];
				$module_tab_adm_[$i]['module_deco_nbr']				= $dbp['module_deco_nbr'];
				$module_tab_adm_[$i]['module_deco_txt_defaut']		= $dbp['module_deco_txt_defaut'];
				$module_tab_adm_[$i]['module_nom']					= $dbp['module_nom'];
				$module_tab_adm_[$i]['module_nom']					= str_replace ( $WebSiteObj->getWebSiteEntry('ws_short') , "" , $module_tab_adm_[$i]['module_nom'] ); // trouver pourquoi enlever le tag MWM (ou RW) du nom)
				$module_tab_adm_[$i]['module_classname']			= $dbp['module_classname'];
				$module_tab_adm_[$i]['module_titre']				= $dbp['module_titre'];
				$module_tab_adm_[$i]['module_directory']			= $dbp['module_directory'];
				$module_tab_adm_[$i]['module_fichier']				= $dbp['module_fichier'];
				$module_tab_adm_[$i]['module_desc']					= $dbp['module_desc'];
				$module_tab_adm_[$i]['module_groupe_pour_voir']		= $dbp['module_groupe_pour_voir'];
				$module_tab_adm_[$i]['module_groupe_pour_utiliser']	= $dbp['module_groupe_pour_utiliser'];
				$module_tab_adm_[$i]['module_adm_control']			= $dbp['module_adm_control'];
				$i++;
			}
		
		// Default value in case of.
		$infos  = array (
			"mode" => 1,
			"affiche_module_mode" => "bypass",
			"module_z_index" => 1000,
			"block" => "B01",
			"blockG" => "B01G",
			"blockT" => "B01T",
			"deco_type" => $ThemeDataObj->getThemeBlockEntry("B01G", 'deco_type'),
			"module_deco_txt_defaut" => $ThemeDataObj->getThemeBlockEntry("B01G", 'module_deco_txt_defaut'),
			"admin_control" => array(
				"px" => 0,
				"py" => 0,
				"dx" => 0,
				"dy" => 0,
				),
		);

		//find the width of the main admin div
// 		$Content .= "<!-- RenderAdmDashboard:render()  -->";
		foreach ( $module_tab_adm_ as $m ) {
// 			$Content .= "<!-- ".$m['module_nom'] ." dx = ".$RenderLayoutObj->getLayoutModuleEntry($m['module_nom'], 'dx')." -->\r".
			$dimAdmModules += $RenderLayoutObj->getLayoutModuleEntry($m['module_nom'], 'dx');
		}
		
// 		$module_z_index['compteur'] = 1000;			//Contourne les Z-index venant de la présentation
		$Content .= "
			<div id='AdminControlSwitch'
			class ='".$ThemeDataObj->getThemeName()."div_AdminControlSwitch'
			style='visibility:visible; z-index:".$infos['module_z_index'].";'
			onClick=\"elm.SwitchDisplayCenter('AdmDashboard'); elm.FillScreenDiv ('AdminControlBG',1);\">
			</div>\r
							
			<div id='AdminControlBG'
			class ='".$ThemeDataObj->getThemeName()."div_SelecteurDeFichierConteneur'
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
		//if ( !isset ( ${$theme_tableau}['theme_admctrl_position'] ) ) {}
		
		$GeneratedJavaScriptObj->insertJavaScript('Onload', "\telm.SetAdminSwitchLocation ( 'AdminControlSwitch', ".$ThemeDataObj->getThemeDataEntry('theme_admctrl_position').", ".$ThemeDataObj->getThemeDataEntry('theme_admctrl_size_x').", ".$ThemeDataObj->getThemeDataEntry('theme_admctrl_size_y').");");
		
		$n = 1;
		$RenderModuleObj = RenderModule::getInstance();
		foreach ( $module_tab_adm_ as $m ) {
			
			$infos['module_nom'] = $mn = &$m['module_nom'];
			$Content .= "<!-- _______________________________________ Debut du module ".$mn." _______________________________________ -->\r";
			
			if ( $UserObj->getUserGroupEntry('groupe', $m['module_groupe_pour_voir'] ) == 1 ) {
				if ( $m['module_deco'] == 1 ) { 
					$infos['block'] = $StringFormatObj->getDecorationBlockName( "B", $m['module_deco_nbr'] , ""); 
				}
				else { $infos['block'] = "B01"; }
				$infos['blockG'] = $infos['block']."G"; 
				$infos['blockT'] = $infos['block']."T"; 
// 				$infos['module_deco_txt_defaut'] = $m['module_deco_txt_defaut'];
				
				$infos['module'] = $m;
				
				$ModuleRendererName = $m['module_classname'];
				if (!class_exists($ModuleRendererName)) {
					include ( $m['module_directory'].str_replace(".php", "_Obj.php",$m['module_fichier'] ) ); //	str_replace used during migration so we can use both files.
				} else { $Content .= "!! !! !! !!"; }
				if (class_exists($ModuleRendererName)) { $ModuleRenderer = new $ModuleRendererName(); }
				else { $ModuleRenderer = new ModuleNotFound(); }
				
				// No need to execute before decoration or after. Render inside !
				$Content .= $RenderModuleObj->selectDecoration($infos);
				$Content .= $ModuleRenderer->render($infos);
				
				// $infos['affiche_module_mode'] = $infos['affiche_module_mode_backup'];
				$Content .= "</div>\r<!-- _______________________________________ Fin du module ".$mn." _______________________________________ -->\r\r\r\r\r";
				$n++;
				
			}
			$infos['admin_control']['px'] += $RenderLayoutObj->getLayoutModuleEntry($mn, 'dx');
			$infos['admin_control']['dx'] += $RenderLayoutObj->getLayoutModuleEntry($mn, 'dx');
			$infos['module_z_index']+=2;
			if ( $RenderLayoutObj->getLayoutModuleEntry($mn, 'dy') > $infos['admin_control']['dy']) {  $infos['admin_control']['dy'] = $RenderLayoutObj->getLayoutModuleEntry($mn, 'dy'); }
		}
		
		$Content .= "</div>\r";
		$GeneratedJavaScriptObj->insertJavaScript('Command', "elm.ResizeDiv ( 'AdmDashboard' , ".$infos['admin_control']['dx']." , ".$infos['admin_control']['dy']." );");

		return $Content;
		}
	
	}
	
}
?>