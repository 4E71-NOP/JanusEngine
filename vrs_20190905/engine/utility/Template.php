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
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));

		$btnTxtTab = array(
			"delete"	=>	$bts->I18nTransObj->getI18nTransEntry('btnDelete'),
			"edit"		=>	$bts->I18nTransObj->getI18nTransEntry('btnUpdate'),
			"create"	=>	$bts->I18nTransObj->getI18nTransEntry('btnCreate'),
		);

		$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
			$infos, 
			'submit', 
			$btnTxtTab[$bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')], 
			192, 
			'updateButton', 
			2, 
			2, 
			" ",
			1,
			true
		);

		$Content = "
			<table style='width:100%; border-spacing: 16px;'>\r
			<tr>\r
			<td>
			<div style='display:block; width:100%; height:100%' 
				onmouseover=\"this.parentNode.style.backgroundColor='#00000020';\" 
				onmouseout=\"this.parentNode.style.backgroundColor='transparent';\" 
				onclick=\"elm.Gebi('confirmCheckboxEdit').checked ^= 1;
				if (elm.Gebi('confirmCheckboxEdit').checked == 1) { elm.Gebi('".$SB['id']."02').disabled = false; }
				else { elm.Gebi('".$SB['id']."02').disabled = true; }
				\">\r
			";
		
		switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
			case "delete":
			case "edit":	$Content .= "<input type='checkbox' id='confirmCheckboxEdit' name='formGenericData[modification]'>".$bts->I18nTransObj->getI18nTransEntry('updateConfirm');		break;
			case "create":	$Content .= "<input type='checkbox' id='confirmCheckboxEdit' name='formGenericData[creation]'>"
				.$bts->I18nTransObj->getI18nTransEntry('createEditConfirm')
				."<input type='hidden' name='formGenericData[modification]'		value='on'>\r"
				;
			break;
		}
		$Content .= "
		</div>\r
		</td>\r
		<td align='right'>\r
		";
				
		$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
		
		$Content .= "</td>\r
		</tr>\r"
		."</form>\r
		
		<!-- __________Return button__________ -->\r
		<form ACTION='index.php?' method='post'>\r"
		.$bts->RenderFormObj->renderHiddenInput(	"formSubmitted"				,	"1")
		.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard")
		.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"		,	"routing" )
		.$bts->RenderFormObj->renderHiddenInput(	"newRoute[arti_slug]"		,	$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug') )
		.$bts->RenderFormObj->renderHiddenInput(	"newRoute[arti_page]"		,	1 )
		."
		<tr>\r
		<td>\r
		</td>\r
		<td align='right'>\r
		";
		
		$SB = array_merge($SB, $SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
			$infos , 
			'submit', 
			$bts->I18nTransObj->getI18nTransEntry('btnReturn'), 
			0, 
			'returnButton', 
			1, 
			1,
			"",
			1,
			false)
		);
		$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
		
		$Content .= "</td>\r
		</tr>\r
		</form>\r
		";
		
		switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
			case "delete":
			case "edit":
			 $SB = array_merge($SB, $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
					$infos , 
					'submit', 
					$bts->I18nTransObj->getI18nTransEntry('btnDelete'), 
					0, 
					'deleteButton', 
					3, 
					3, 
					"",
					1,
					true)
				);

				$Content .= "
				<!-- __________Delete button__________ -->\r
				<form ACTION='index.php?' method='post'>\r"
				.$bts->RenderFormObj->renderHiddenInput(	"formSubmitted"						,	"1")
				.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"			,	"AdminDashboard")
				.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"						,	"DELETE" )
				.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"						,	"menu" )
				.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"				,	"routing" )
				.$bts->RenderFormObj->renderHiddenInput(	"newRoute[arti_slug]"				,	$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug') )
				.$bts->RenderFormObj->renderHiddenInput(	"newRoute[arti_page]"				,	1 )
				.$bts->RenderFormObj->renderHiddenInput(	$infos['formName']."[selectionId]"	,	$bts->RequestDataObj->getRequestDataSubEntry($infos['formName'], 'selectionId') )
				."
				<tr>\r
				<td>\r
				<div style='display:block; width:100%; height:100%' 
				onmouseover=\"this.parentNode.style.backgroundColor='#00000020';\" 
				onmouseout=\"this.parentNode.style.backgroundColor='transparent';\" 
				onclick=\"elm.Gebi('confirmCheckboxDelete').checked ^= 1;
				if (elm.Gebi('confirmCheckboxDelete').checked == 1) { elm.Gebi('".$SB['id']."02').disabled = false; }
				else { elm.Gebi('".$SB['id']."02').disabled = true; }
				\">\r
				<input type='checkbox' id='confirmCheckboxDelete' name='formGenericData[deletion]'>".$bts->I18nTransObj->getI18nTransEntry('deleteConfirm')."
				</div>\r
				</td>\r
				<td align='right'>\r
				";

				$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
				
				$Content .= "
				</td>\r
				</tr>\r
				</form>\r
				";
				break;
		}
		
		
		$Content .= "</table>\r";
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
		return $Content;
		
	}
	
	/**
	 * renderAdminCreateButton
	 * @param array $infos
	 * @return string
	 * 
	 */
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
		

		$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
			$infos , 'submit', 
			$bts->I18nTransObj->getI18nTransEntry('btnCreate'), 128, 
			'createButton', 
			2, 2, 
			"",1
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

	/**
	 * Renders a page selector
	 * @param array $data
	 * @return string
	 */
	public function renderPageSelector ($data) {
		$bts = BaseToolSet::getInstance();

		$Content = "<div style='text-align:center; item-align:center; margin:0 auto;'>\r";
		if ( strlen($data['selectionOffset']) == 0 ) { $data['selectionOffset'] = 0 ;}
		if ( $data['nbrPerPage'] != 0 ) {
			$data['PageNbr'] = $data['ItemsCount'] / $data['nbrPerPage'] ;
			$data['remainder'] = $data['ItemsCount'] % $data['nbrPerPage'];
			if ( $data['remainder'] > 0 ) { $data['PageNbr']++;}
			$data['pageCounter'] = 0;
			for ( $i = 1 ; $i <= $data['PageNbr'] ; $i++) {
				if ( $data['selectionOffset'] != $data['pageCounter'] ) {
					$Content .= "<a style='display:inline;' href='"
					."index.php?filterForm[selectionOffset]=".$data['pageCounter']
					.$data['link']
					."'>"
					.$data['elmIn']
					.$i
					.$data['elmOut']
					."</a>\r"
					;
				}
				else { $Content .= $data['elmInHighlight'].$i.$data['elmOut']."\r"; }
				$data['pageCounter']++;
			}
		}
		$Content .= "</div>\r";
		return $Content;
	}


	/**
	 * renderFilterForm
	 * @return string
	 */
	public function renderFilterForm ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
			$infos , 'submit', 
			$bts->I18nTransObj->getI18nTransEntry('pageSelectorBtnFilter'), 128, 
			'refreshButton', 
			1, 1, 
			"" 
		);
		$tdStyle = " style='margin:0.1cm;'";
		$Content = "</form>\r"
		. $bts->RenderFormObj->renderformHeader("FilterForm")
		// ."<form ACTION='index.php?' method='post'>\r"
		."<table class='".$CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName()."defaultTable' style='width:50%; margin-left:auto; margin-right:0px;'>\r"
		."<tr>\r"
		."<td ".$tdStyle.">".$bts->I18nTransObj->getI18nTransEntry('pageSelectorQueryLike')."</td>\r"
		."<td ".$tdStyle.">"
		. $bts->RenderFormObj->renderInputText("filterForm[query_like]", $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like'), "", 15)
		."</td>\r"
		."</tr>\r"

		."<tr>\r"
		."<td ".$tdStyle.">".$bts->I18nTransObj->getI18nTransEntry('pageSelectorDisplay')."</td>\r"
		."<td ".$tdStyle.">"
		. $bts->RenderFormObj->renderInputText("filterForm[nbrPerPage]",	$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage'), "" , 2)
		.$bts->I18nTransObj->getI18nTransEntry('pageSelectorNbrPerPage')
		."</td>\r"
		."</tr>\r"
		.$infos['insertLines']
		
		."<tr>\r"
		."<td ".$tdStyle."></td>\r"
		."<td ".$tdStyle.">\r<br>\r"
		.$bts->InteractiveElementsObj->renderSubmitButton($SB)
		."</td>\r"
		."</tr>\r"
		
		."</table>\r"
		."</form>\r"
		;
		
		return $Content;
	}


}