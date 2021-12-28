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
//	Module : Authentification
// --------------------------------------------------------------------------------------------

class ModuleAuthentification {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$Content = "";
		if ( $CurrentSetObj->getInstanceOfUserObj()->hasPermission('group_default_read_permission') === true ) {
			$localisation = " / ModuleAuthentification";
			$bts->MapperObj->AddAnotherLevel($localisation );
			$bts->LMObj->logCheckpoint("ModuleAuthentification");
			$bts->MapperObj->RemoveThisLevel($localisation );
			$bts->MapperObj->setSqlApplicant("ModuleAuthentification");
	
			$bts->LMObj->setInternalLogTarget(LOG_TARGET);
			$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : start"));
			$Block = $ThemeDataObj->getThemeName().$infos['block'];
	
			$cnxResult = $bts->AUObj->getDataEntry('errorType');
			$l = $CurrentSetObj->getDataEntry ('language');
			$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ) );
			
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : user_login=".$bts->SMObj->getSessionEntry('user_login')));
			
			if ( $bts->SMObj->getSessionEntry('user_login') == "anonymous") {
				if ( $bts->RequestDataObj->getRequestDataEntry('formSubmitted') == 1 && 
						$bts->RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login') != "anonymous" &&
						$bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'action') != "disconnection"
						) {
					$Content .= "<span class='" . $Block."_warning' style='text-align: center;'>". $bts->I18nTransObj->getI18nTransEntry('cnxResult'.$cnxResult) ."</span>"; 
				}
	
				$Content .= "
				<form ACTION='/' method='post'>\r
			
				<table style='width:100%; margin-right: auto; margin-left: auto'>\r
				<tr>\r<td style='text-align:center;'>".$bts->I18nTransObj->getI18nTransEntry('id')."</td>\r</tr>\r
				<tr>\r<td style='text-align:center; padding-bottom:8px;'><input type='text' name='authentificationForm[user_login]' size='16' maxlength='64' value='anonymous'></td>\r</tr>\r
				<tr>\r<td style='text-align:center;'>".$bts->I18nTransObj->getI18nTransEntry('ps')."</td>\r</tr>\r
				<tr>\r<td style='text-align:center; padding-bottom:8px;'><input type='password' name='authentificationForm[user_password]' size='16' maxlength='64' value='anonymous'></td>\r</tr>\r
				</table>\r
				<input type='hidden' name='formSubmitted'				value='1'>
				<input type='hidden' name='formGenericData[origin]'		value='ModuleAuthentification'>
				<input type='hidden' name='formGenericData[action]' 	value='connectionAttempt'>\r
	
	
				<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
				<tr>\r
				<td>\r
				";
			
				$SB = array(
					"id"				=> "bouton_authentif",
					"type"				=> "submit",
					"initialStyle"		=> $Block."_submit_s2_n",
					"hoverStyle"		=> $Block."_submit_s2_h",
					"onclick"			=> "",
					"message"			=> $bts->I18nTransObj->getI18nTransEntry('login'),
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
				$SB = array(
					"id"				=> "bouton_deconexion",
					"type"				=> "submit",
					"initialStyle"		=> $Block."_submit_s2_n",
					"hoverStyle"		=> $Block."_submit_s2_h",
					"onclick"			=> "",
					"message"			=> $bts->I18nTransObj->getI18nTransEntry('disconnect'),
					"mode"				=> 0,
					"size" 				=> 0,
					"lastSize"			=> 0,
				);
			
				$pv['SSL_etat'] = "<span class='" . $Block."_fade'>\r".$bts->I18nTransObj->getI18nTransEntry('via80')."</span>\r"; 
				if ( isset($_SERVER['HTTPS']) ) {
					if ( isset($_SERVER['SERVER_PORT'] ) && ( $_SERVER['SERVER_PORT'] == '443' ) ) { 
						$pv['SSL_etat'] = "<span class='" . $Block."_fade'>\r".$bts->I18nTransObj->getI18nTransEntry('viassl')."</span>\r"; 
					}
				}
			
				$pv['table_hauteur'] = 128;
			
				$Content .= "
				<form ACTION='/' method='post'>\r
				<input type='hidden' name='user_login' value='anonymous'>\r
				<input type='hidden' name='user_pass' value=''>\r
				<input type='hidden' name='formSubmitted'				value='1'>
				<input type='hidden' name='formGenericData[origin]'		value='ModuleAuthentification'>
				<input type='hidden' name='formGenericData[action]' 	value='disconnection'>\r
			
				<table class='mt_bareTable' style='height: ".$pv['table_hauteur']."px; margin-left: auto; margin-right: auto; '>
			
				<tr>\r
				<td style='text-align: center;'>\r".
				$bts->I18nTransObj->getI18nTransEntry('txt1').
				"<span style='font-weight:bold;'>".$bts->SMObj->getSessionEntry('user_login')."</span>\r
				</td>\r
				</tr>\r
				
				<tr>\r
				<td style='text-align: center;'>\r
				<div style='text-align: center;'>\r
				" .
				$bts->InteractiveElementsObj->renderSubmitButton($SB).
				"
				</div>\r
				</td>\r
				</tr>\r
			
				<tr>\r
				<td style='text-align: center;'>\r".
				$pv['SSL_etat']	.
				"</td>\r
				</tr>\r
				</table>\r
			
				</form>\r
				";
			}
		}
		
		// Cleaning up
		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10 ) { 
			unset (
			$i18n,
			$localisation,
			$CurrentSetObj,
			$ThemeDataObj,
			$SB
			);
		}
		return $Content;
	}

}

?>
