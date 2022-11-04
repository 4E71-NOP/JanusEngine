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

class InteractiveElements {
	private static $Instance = null;

	public function __construct() {}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return InteractiveElements
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new InteractiveElements ();
		}
		return self::$Instance;
	}
	

	/**
	 * Returns an array with default values for InteractiveElements->renderSubmitButton()
	 * @param array $infos
	 * @param string $type
	 * @param string $message
	 * @param number $size
	 * @param string $id
	 * @param number $initialStyle
	 * @param number $hoverStyle 1 2 3 green blue red
	 * @param string $onclick javascript for OnClick
	 * @param number $mode 1 = keep track by saving the last used size. '0' = reuse the last size
	 * @param bool   $disabled
	 * @return array
	 * 
	 */
	public function getDefaultSubmitButtonConfig (
			$infos , 
			$type='submit', 
			$message='', 
			$size=128, 
			$id='defaultButton', 
			$initialStyle=1, 
			$hoverStyle=1, 
			$onclick='', 
			$mode=1 , 
			$disabled=false 
		) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];

		$tab = array(
			"id"				=> $id,
			"type"				=> $type,
			"initialStyle"		=> $Block."_submit_s".$initialStyle."_n",
			"hoverStyle"		=> $Block."_submit_s".$hoverStyle."_h",
			"onclick"			=> $onclick,
			"message"			=> $message,
			"mode"				=> $mode,
			"size" 				=> $size,
			"disabled"			=> $disabled,
//			"lastSize"			=> 0,
		);
		return ($tab);
	}

	/**
	 * Returns the HTML code of a button controled with an array/object.
	 * The array should contain:
	 * id				Defines the button's name
	 * type				Defines the command (ex Submit) of the button.
	 * initialStyle		Defines initial behavior.
	 * hoverStyle		Defines onmouseover behavior. Changing style.
	 * onclick			If not empty define the javascript used when clicking on the button.
	 * message			Defines the button text
	 * mode				1 set the size (if!=0) and save it into 'lastSize'. 0 will clear 'lastSize' and no button size will be set.
	 * size				Defines the button size.
	 * lastSize			is here as a variable passed along for the next button.
	 * 
	 * @param array $infos
	 * @return string
	 * 
	 */
	public function renderSubmitButton (&$infos) {
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		if ( strlen($infos['hoverStyle']) > 0 ) { 
			$animation = " onmouseover=\"elm.ButtonHover('".$infos['id']."', '".$infos['hoverStyle']."');\" onmouseout=\"elm.ButtonHover('".$infos['id']."', '".$infos['initialStyle']."');\" ";
		}
		$bareTableClass = $ThemeDataObj->getThemeName()."bareTable";
		$Content = "
		<table class='".$bareTableClass."'>\r 
		<tr>\r
		<td			id='".$infos['id']."01' class='".$infos['initialStyle']."01' ".$animation."></td>\r
		<td><input	id='".$infos['id']."02' class='".$infos['initialStyle']."02' ".$animation." 
		type='".$infos['type']."' value=\"".$infos['message']."\" ";
		if ( strlen($infos['onclick']) > 0 ) { $Content .= " onclick=\"".$infos['onclick']."\" "; }
		$Content .= " style='";
		switch ($infos['mode'] == 1) {
			case TRUE:
				switch ($infos['size'] != 0) {
				case TRUE:	$Content .= "width: ".$infos['size']."px; "; $infos['lastSize'] = $infos['size'];	break;
				case FALSE:	$Content .= "width: ".$infos['lastSize']."px; ";									break;
			}
			break;
			case FALSE:	$infos['lastSize'] = 0 ;	break;
		}

		$bts = BaseToolSet::getInstance();
		$bts->LMObj->saveVectorSystemLogLevel();
		$bts->LMObj->setVectorSystemLogLevel(LOGLEVEL_BREAKPOINT);
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : '".$infos['message']."' , infos['disabled']=".$infos['disabled']));
		$bts->LMObj->restoreVectorSystemLogLevel();

		$Content .= "border:0px; padding:0px; margin:0px'"
		.(($infos['disabled'] == true) ? " disabled='disabled'" : " ")
		."></td>\r
		<td id='".$infos['id']."03' class='".$infos['initialStyle']."03' ".$animation."></td>\r
		</tr>\r
		</table>\r
		";
		unset ( $ThemeDataObj);
		return $Content;
	}

	// --------------------------------------------------------------------------------------------
	/**
	 * Returns an array with default values for InteractiveElements->renderIconSelectFile()
	 * @param string $formName
	 * @param string $targetId
	 * @param number $inputSize
	 * @param string $inputVal
	 * @param string $buttonId
	 * @return array
	 */
	public function getDefaultIconSelectFileConfig(
		$formName='thisForm', 
		$targetId='param[button]', 
		$inputSize=25, 
		$inputVal,
		$path="/media/",
		$restrictTo="/media/",
		$buttonId,
	) {
		$CurrentSetObj = CurrentSet::getInstance();

		return ( array (
				"width"				=> 80,
				"height"			=> 50,
				"formName"			=> $formName,
				"formTargetId"		=> $targetId,
				"formInputSize"		=> $inputSize,
				"formInputVal"		=> $inputVal,
				"path"				=> $path,
				"restrictTo"		=> $restrictTo,
				"strRemove"			=> "/\.*\w*\//",
				"strAdd"			=> "",
				"selectionMode"		=> "file",
				"displayType"		=> "fileList",
				"buttonId"			=> $buttonId,
				"case"				=> 3,
				"update"			=> 1,
				"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
			)
		);
	}


	/**
	 * Render the button that will open the fileSelector (fs.php)<br>
	 * case 1 : renders the fileSelector button<br>
	 * case 2 : renders the erase button<br>
	 * case 3 : renders both the fileSelector & the erase button<br>
	 * 
	 * @param array $infos
	 * @return string
	 */
	public function renderIconSelectFile ($infos){
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$i = &$infos['IconSelectFile'];
		
		$X = $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_width');
		$Y = $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_height');
		
		// 			<span class='".$Block."_lien ".$Block."_t3' Onclick=\"SDFTabRepCourant ( ".$i['table']." , ".$i['table']." , 'selecteur_de_fichier_dynamique' ); elm.FillScreenDiv('selecteur_de_fichier_FondNoir', 1 ); elm.SwitchDisplayCenter('selecteur_de_fichier_cadre')\">\r
		if ( !isset($i['update']) ) { $i['update'] = 0;} //default
		
		$contenu_A = "
			<input type='text' readonly name='".$i['formTargetId']."' id='".$i['formTargetId']."' size='".$i['formInputSize']."' maxlength='255' value='".$i['formInputVal']."' style='text-align:right;' >\r
			<span Onclick=\"fs.getDirectoryContent(".$i['array'].", '".$i['path']."', 0); elm.FillScreenDiv('FileSelectorDarkFade', 1 ); elm.SwitchDisplayCenter('FileSelectorFrame')\">\r
			<img src='".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icon_directory') . "' width='".$X."' height='".$Y."' border='0'>
			</span>
			";
		
		$contenu_B = "
			<span Onclick=\"document.forms['".$i['formName']."'].elements['".$i['formTargetId']."'].value = '';\">
			<img src='".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icon_erase') . "' width='".$X."' height='".$Y."' border='0'>
			</span>\r
			";
		
		$contenu_R = "";
		switch ( $i['case'] ) {
			case 1 :	$contenu_R = $contenu_A; 				break;
			case 2 :	$contenu_R = $contenu_B; 				break;
			case 3 :	$contenu_R = $contenu_A . $contenu_B;	break;
		}
		unset($ThemeDataObj);
		return $contenu_R;
	}
	
	// --------------------------------------------------------------------------------------------
	/**
	 * 
	 * MUST UPDATE !!!! 
	 * 2020 10 23 : Task / Check with a image selector as validation
	 * 
	 * @param String $cas
	 * @param String $FormNom
	 * @param String $ForgeFormElement
	 * @param String $ForgeFormElementX
	 * @param String $ForgeFormElementY
	 * @param String $FormRepertoire
	 * @param String $InputVal
	 * @param String $DivCible
	 * @param String $JavascriptRoutine
	 * @param String $ModType
	 * @param String $infos
	 * @return string
	 */
	public function renderIconSelectImage ( $cas , $FormNom , $ForgeFormElement, $ForgeFormElementX, $ForgeFormElementY, $FormRepertoire , $InputVal , $DivCible , $JavascriptRoutine , $ModType , $infos) {
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();

		$X = $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icon_width');
		$Y = $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icon_height');
		
		$CurrentSetObj = CurrentSet::getInstance();
		$contenu_A = "
	<input type='text' name='".$ForgeFormElement."' id='".$ForgeFormElement."' size='20' maxlength='255' value='".$InputVal."' 
	onChange=\"
	var NewU = 'url(\'".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/' + document.forms['".$FormNom."'].elements['".$FormRepertoire."'].value + '/'+ this.value + '\')';
	elm.Gebi('".$DivCible."').style.backgroundImage = NewU;\r
	\">\r
			
	<span 
	Onclick=\"
	CDMExec.ModType = '".$ModType."';
	CDMExec.NomModule = '".$DivCible."';
	CDMExec.FormCible = '".$FormNom."';
	RenderFSJS('".$FormNom."','".$ForgeFormElement."', '".$ForgeFormElementX."', '".$ForgeFormElementY."', document.forms['".$FormNom."'].elements['".$FormRepertoire."'].value , 'FSJavaScript' , 'FSJS_C_' , '".$JavascriptRoutine."' )\">
	<img src='".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icon_directory') . "' width='".$X."' height='".$Y."' border='0'></span>\r
	";
		
		$contenu_B = "
	<span Onclick=\"document.forms['".$FormNom."'].elements['".$ForgeFormElement."'].value = '';
	CDMExec.ModType = '".$ModType."';
	CDMExec.NomModule = '".$DivCible."';
	CDMExec.FormCible = '".$FormNom."';
	".$JavascriptRoutine."();\">\r
	<img src='".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icon_erase') . "' width='".$X."' height='".$Y."' border='0' alt=''></span>\r
	";
		
		$contenu_R = "";
		switch ( $cas ) {
			case 1 :	$contenu_R = $contenu_A; 				break;
			case 2 :	$contenu_R = $contenu_B; 				break;
			case 3 :	$contenu_R = $contenu_A . $contenu_B;	break;
		}
		return $contenu_R;
	}
}