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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
// 		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
// 		$bareTableClass = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName()."bareTable";
		
		$Content = "
			<table style=' width:".$CurrentSetObj->getInstanceOfThemeDataObj()->getThemeDataEntry('theme_module_largeur_interne')."px; border-spacing: 16px;'>\r
			<tr>\r
			<td>
		";
		
		switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
			case "delete":
			case "edit":	$Content .= "<input type='checkbox' name='formGenericData[modification]'>".$bts->I18nObj->getI18nEntry('updateConfirm');		break;
			case "create":	$Content .= "<input type='checkbox' name='formGenericData[creation]' 	>".$bts->I18nObj->getI18nEntry('createEditConfirm');		break;
		}
		$Content .= "
		</td>\r
		<td align='right'>\r
		";
				
		$btnTxtTab = array(
				"delete"	=>	$bts->I18nObj->getI18nEntry('btnDelete'),
				"edit"		=>	$bts->I18nObj->getI18nEntry('btnUpdate'),
				"create"	=>	$bts->I18nObj->getI18nEntry('btnCreate'),
		);
		
		$SB = array(
				"id"				=> "updateButton",
				"type"				=> "submit",
				"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
				"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
				"onclick"			=> "",
				"message"			=> $btnTxtTab[$bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')],
				"mode"				=> 1,
				"size" 				=> 192,
				"lastSize"			=> 0,
		);
		$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
		
		$Content .= "</td>\r
		</tr>\r"
		."</form>\r
		
		<!-- __________Return button__________ -->\r
		<form ACTION='index.php?' method='post'>\r"
// 		.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_ws')
// 		.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
// 		.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
// 		."<input type='hidden'	name='formGenericData[origin]'				value='AdminDashboard'>\r"
		."<input type='hidden'	name='newRoute[arti_slug]'							value='".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')."'>\r"
		."<input type='hidden'	name='newRoute[arti_page]'							value='1'>\r"
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
				"message"			=> $bts->I18nObj->getI18nEntry('btnReturn'),
				"mode"				=> 1,
				"size" 				=> 0,
		);
		$SB = array_merge($SB, $SB2);		//OverWrites the $SB array with $SB2.
		
		$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
		
		$Content .= "</td>\r
		</tr>\r
		</form>\r
		";
		
		switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
			case "delete":
			case "edit":
				$Content .= "
				<!-- __________Delete button__________ -->\r
				<form ACTION='index.php?' method='post'>\r"
// 				.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_ws')
// 				.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
// 				.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
// 				."<input type='hidden' name='arti_page'								value='2'>\r"
				."<input type='hidden'	name='newRoute[arti_slug]'					value='".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')."'>\r"
				."<input type='hidden'	name='newRoute[arti_page]'					value='1'>\r"
				."<input type='hidden' name='formGenericData[origin]'				value='AdminDashboard'>\r"
				."<input type='hidden' name='formGenericData[mode]'					value='delete'>\r"
				."<input type='hidden' name='".$infos['formName']."[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry($infos['formName'], 'selectionId')."'>\r"
				."
				<tr>\r
				<td>\r
				<input type='checkbox' name='formGenericData[deletion]'>".$bts->I18nObj->getI18nEntry('deleteConfirm')."
				</td>\r
				<td align='right'>\r
				";
				
				
				$SB2 = array(
						"id"				=> "deleteButton",
						"initialStyle"		=> $Block."_t3 ".$Block."_submit_s3_n",
						"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s3_h",
						"message"			=> $bts->I18nObj->getI18nEntry('btnDelete'),
						"mode"				=> 1,
						"size" 				=> 0,
				);
				$SB = array_merge($SB, $SB2);		//OverWrites the $SB array with $SB2.
				
				$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
				
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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		$bareTableClass = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName()."bareTable";
		
		$Content = "
			<table class='".$bareTableClass."' style='padding:16px'>\r
			<tr>\r
			<td>\r
			<form ACTION='' method='post'>\r"
			."<input type='hidden'	name='formSubmitted'						value='1'>\r"
			."<input type='hidden'	name='newRoute[arti_slug]'					value='".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')."'>\r"
			."<input type='hidden'	name='newRoute[arti_page]'					value='2'>\r"
			."<input type='hidden'	name='formGenericData[mode]'				value='create'>\r"
			;
		
		$SB = array(
				"id"				=> "createButton",
				"type"				=> "submit",
				"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
				"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
				"onclick"			=> "",
				"message"			=> $bts->I18nObj->getI18nEntry('btnCreate'),
				"mode"				=> 1,
				"size" 				=> 128,
				"lastSize"			=> 0,
		);
		$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
		
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