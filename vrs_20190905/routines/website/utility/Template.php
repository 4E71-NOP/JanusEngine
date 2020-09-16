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
		$RequestDataObj = RequestData::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$InteractiveElementsObj = InteractiveElements::getInstance();
		$I18nObj = I18n::getInstance();
		
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		
		$Content = "
			<table style=' width:".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."px; border-spacing: 16px;'>\r
			<tr>\r
			<td>
		";
		
		switch ( $RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
			case "delete":
			case "edit":	$Content .= "<input type='checkbox' name='formGenericData[modification]'>".$I18nObj->getI18nEntry('updateConfirm');		break;
			case "create":	$Content .= "<input type='checkbox' name='formGenericData[creation]' 	>".$I18nObj->getI18nEntry('createEditConfirm');		break;
		}
		$Content .= "
		</td>\r
		<td align='right'>\r
		";
				
		$btnTxtTab = array(
				"delete"	=>	$I18nObj->getI18nEntry('btnDelete'),
				"edit"		=>	$I18nObj->getI18nEntry('btnUpdate'),
				"create"	=>	$I18nObj->getI18nEntry('btnCreate'),
		);
		
		$SB = array(
				"id"				=> "updateButton",
				"type"				=> "submit",
				"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
				"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
				"onclick"			=> "",
				"message"			=> $btnTxtTab[$RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')],
				"mode"				=> 1,
				"size" 				=> 192,
				"lastSize"			=> 0,
		);
		$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
		
		$Content .= "</td>\r
		</tr>\r"
		."</form>\r
		
		<!-- __________Return button__________ -->\r
		<form ACTION='index.php?' method='post'>\r"
		.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_ws')
		.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
		.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
		."<input type='hidden'	name='arti_page' value='1'>"
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
				"message"			=> $I18nObj->getI18nEntry('btnReturn'),
				"mode"				=> 1,
				"size" 				=> 0,
		);
		$SB = array_merge($SB, $SB2);		//OverWrites the $SB array with $SB2.
		
		$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
		
		$Content .= "</td>\r
		</tr>\r
		</form>\r
		";
		
		switch ( $RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
			case "delete":
			case "edit":
				$Content .= "
				<!-- __________Delete button__________ -->\r
				<form ACTION='index.php?' method='post'>\r"
				.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_ws')
				.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
				.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
				."<input type='hidden' name='arti_page'								value='2'>\r"
				."<input type='hidden' name='formGenericData[origin]'				value='AdminDashboard'>\r"
				."<input type='hidden' name='formGenericData[mode]'					value='delete'>\r"
				."<input type='hidden' name='".$infos['formName']."[selectionId]'	value='".$RequestDataObj->getRequestDataSubEntry($infos['formName'], 'selectionId')."'>\r"
				."
				<tr>\r
				<td>\r
				<input type='checkbox' name='formGenericData[deletion]'>".$I18nObj->getI18nEntry('deleteConfirm')."
				</td>\r
				<td align='right'>\r
				";
				
				
				$SB2 = array(
						"id"				=> "deleteButton",
						"initialStyle"		=> $Block."_t3 ".$Block."_submit_s3_n",
						"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s3_h",
						"message"			=> $I18nObj->getI18nEntry('btnDelete'),
						"mode"				=> 1,
						"size" 				=> 0,
				);
				$SB = array_merge($SB, $SB2);		//OverWrites the $SB array with $SB2.
				
				$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
				
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
		$CurrentSetObj = CurrentSet::getInstance();
		$InteractiveElementsObj = InteractiveElements::getInstance();
		$I18nObj = I18n::getInstance();
		
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		
		$Content = "
			<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; padding:16px'>
			<tr>\r
			<td>\r
			<form ACTION='index.php?' method='post'>\r".
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_ws').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
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
				"message"			=> $I18nObj->getI18nEntry('btnCreate'),
				"mode"				=> 1,
				"size" 				=> 128,
				"lastSize"			=> 0,
		);
		$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
		
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