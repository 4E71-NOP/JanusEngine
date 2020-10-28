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

class Template {
	private static $Instance = null;

	private static $ConvertTable = array();
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return Template
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new Template ();
		}
		return self::$Instance;
	}
	
	/**
	 * Renders the last part of an admin page.
	 * It's composed of 2 to 3 buttons in several forms that will post common commands. This will end a previously opened form. Don't forget to open it. 
	 * @param array $infos
	 * @param array $i18n
	 * @return string
	 */
	public function renderAdminFormButtons (&$infos) {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		$bareTableClass = $ThemeDataObj->getThemeName()."bareTable";
		
		$Content = "
			<table style=' width:".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."px; border-spacing: 16px;'>\r
			<tr>\r
			<td>
		";
		
		switch ( $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
			case "delete":
			case "edit":	$Content .= "<input type='checkbox' name='formGenericData[modification]'>".$cs->I18nObj->getI18nEntry('updateConfirm');		break;
			case "create":	$Content .= "<input type='checkbox' name='formGenericData[creation]' 	>".$cs->I18nObj->getI18nEntry('createEditConfirm');		break;
		}
		$Content .= "
		</td>\r
		<td align='right'>\r
		";
				
		$btnTxtTab = array(
				"delete"	=>	$cs->I18nObj->getI18nEntry('btnDelete'),
				"edit"		=>	$cs->I18nObj->getI18nEntry('btnUpdate'),
				"create"	=>	$cs->I18nObj->getI18nEntry('btnCreate'),
		);
		
		$SB = array(
				"id"				=> "updateButton",
				"type"				=> "submit",
				"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
				"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
				"onclick"			=> "",
				"message"			=> $btnTxtTab[$cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')],
				"mode"				=> 1,
				"size" 				=> 192,
				"lastSize"			=> 0,
		);
		$Content .= $cs->InteractiveElementsObj->renderSubmitButton($SB);
		
		$Content .= "</td>\r
		</tr>\r"
		."</form>\r
		
		<!-- __________Return button__________ -->\r
		<form ACTION='index.php?' method='post'>\r"
// 		.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_ws')
// 		.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
		.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
		."<input type='hidden'	name='arti_page'							value='1'>"
		."<input type='hidden'	name='formGenericData[origin]'				value='AdminDashboard'>\r"
		."
		<tr>\r
		<td>\r
		</td>\r
		<td align='right'>\r
		";
		
		
		$SB2 = array(
				"id"				=> "returnButton",
				"initialStyle"		=> $Block."_t3 ".$Block."_submit_s1_n",
				"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s1_h",
				"message"			=> $cs->I18nObj->getI18nEntry('btnReturn'),
				"mode"				=> 1,
				"size" 				=> 0,
		);
		$SB = array_merge($SB, $SB2);		//OverWrites the $SB array with $SB2.
		
		$Content .= $cs->InteractiveElementsObj->renderSubmitButton($SB);
		
		$Content .= "</td>\r
		</tr>\r
		</form>\r
		";
		
		switch ( $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
			case "delete":
			case "edit":
				$Content .= "
				<!-- __________Delete button__________ -->\r
				<form ACTION='index.php?' method='post'>\r"
// 				.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_ws')
// 				.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
				.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
				."<input type='hidden' name='arti_page'								value='2'>\r"
				."<input type='hidden' name='formGenericData[origin]'				value='AdminDashboard'>\r"
				."<input type='hidden' name='formGenericData[mode]'					value='delete'>\r"
				."<input type='hidden' name='".$infos['formName']."[selectionId]'	value='".$cs->RequestDataObj->getRequestDataSubEntry($infos['formName'], 'selectionId')."'>\r"
				."
				<tr>\r
				<td>\r
				<input type='checkbox' name='formGenericData[deletion]'>".$cs->I18nObj->getI18nEntry('deleteConfirm')."
				</td>\r
				<td align='right'>\r
				";
				
				
				$SB2 = array(
						"id"				=> "deleteButton",
						"initialStyle"		=> $Block."_t3 ".$Block."_submit_s3_n",
						"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s3_h",
						"message"			=> $cs->I18nObj->getI18nEntry('btnDelete'),
						"mode"				=> 1,
						"size" 				=> 0,
				);
				$SB = array_merge($SB, $SB2);		//OverWrites the $SB array with $SB2.
				
				$Content .= $cs->InteractiveElementsObj->renderSubmitButton($SB);
				
				$Content .= "
				</td>\r
				</tr>\r
				</form>\r
				";
				break;
		}
		
		
		$Content .= "</table>\r";
		return $Content;
		
	}
	
	public function renderAdminCreateButton (&$infos) {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		$bareTableClass = $ThemeDataObj->getThemeName()."bareTable";
		
		$Content = "
			<table class='".$bareTableClass."' style='padding:16px'>
			<tr>\r
			<td>\r
			<form ACTION='index.php?' method='post'>\r".
// 			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_ws').
// 			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
			."<input type='hidden' name='formGenericData[mode]'	value='create'>"
			."<input type='hidden' name='arti_page'	value='2'>\r"
			;
			
		$SB = array(
				"id"				=> "createButton",
				"type"				=> "submit",
				"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
				"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
				"onclick"			=> "",
				"message"			=> $cs->I18nObj->getI18nEntry('btnCreate'),
				"mode"				=> 1,
				"size" 				=> 128,
				"lastSize"			=> 0,
		);
		$Content .= $cs->InteractiveElementsObj->renderSubmitButton($SB);
		
		$Content .= "<br>\r&nbsp;
		</form>\r
		</td>\r
		</tr>\r
		</table>\r
		<br>\r
		";
		return $Content;
	}
		
	
	
}