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
			<table style='width:100%; border-spacing: 16px;'>\r
			<tr>\r
			<td>
			<div style='display:block; width:100%; height:100%' 
				onmouseover=\"this.parentNode.style.backgroundColor='#00000020';\" 
				onmouseout=\"this.parentNode.style.backgroundColor='transparent';\" 
				onclick=\"elm.Gebi('confirmCheckboxEdit').checked ^= 1;\">\r
			";
		
		switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
			case "delete":
			case "edit":	$Content .= "<input type='checkbox' id='confirmCheckboxEdit' name='formGenericData[modification]'>".$bts->I18nTransObj->getI18nTransEntry('updateConfirm');		break;
			case "create":	$Content .= "<input type='checkbox' id='confirmCheckboxEdit' name='formGenericData[creation]'>".$bts->I18nTransObj->getI18nTransEntry('createEditConfirm');		break;
		}
		$Content .= "
		</div>\r
		</td>\r
		<td align='right'>\r
		";
				
		$btnTxtTab = array(
				"delete"	=>	$bts->I18nTransObj->getI18nTransEntry('btnDelete'),
				"edit"		=>	$bts->I18nTransObj->getI18nTransEntry('btnUpdate'),
				"create"	=>	$bts->I18nTransObj->getI18nTransEntry('btnCreate'),
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
		."<input type='hidden'	name='newRoute[arti_slug]'		value='".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')."'>\r"
		."<input type='hidden'	name='newRoute[arti_page]'		value='1'>\r"
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
				"message"			=> $bts->I18nTransObj->getI18nTransEntry('btnReturn'),
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
				."<input type='hidden'	name='newRoute[arti_slug]'					value='".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')."'>\r"
				."<input type='hidden'	name='newRoute[arti_page]'					value='1'>\r"
				."<input type='hidden' name='formGenericData[origin]'				value='AdminDashboard'>\r"
				."<input type='hidden' name='formGenericData[mode]'					value='delete'>\r"
				."<input type='hidden' name='".$infos['formName']."[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry($infos['formName'], 'selectionId')."'>\r"
				."
				<tr>\r
				<td>\r
				<div style='display:block; width:100%; height:100%' 
				onmouseover=\"this.parentNode.style.backgroundColor='#00000020';\" 
				onmouseout=\"this.parentNode.style.backgroundColor='transparent';\" 
				onclick=\"elm.Gebi('confirmCheckboxDelete').checked ^= 1;\">\r
				<input type='checkbox' id='confirmCheckboxDelete' name='formGenericData[deletion]'>".$bts->I18nTransObj->getI18nTransEntry('deleteConfirm')."
				</div>\r
				</td>\r
				<td align='right'>\r
				";
				
				
				$SB2 = array(
						"id"				=> "deleteButton",
						"initialStyle"		=> $Block."_t3 ".$Block."_submit_s3_n",
						"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s3_h",
						"message"			=> $bts->I18nTransObj->getI18nTransEntry('btnDelete'),
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
				"message"			=> $bts->I18nTransObj->getI18nTransEntry('btnCreate'),
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