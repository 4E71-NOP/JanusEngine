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
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new InteractiveElements ();
		}
		return self::$Instance;
	}
	
	/**
	 * Return the HTML code of a button.<br>
	 * <u>The array should contain:</u>
	 * <table style='border: solid 1px #00000040;'>
	 * <tr><td style='background-color: #FFFFFF60;'><b>id			</b></td>	<td style='background-color: #FFFFFF60;'>Defines the button's name</td></tr>
	 * <tr><td style='background-color: #FFFFFF60;'><b>type			</b></td>	<td style='background-color: #FFFFFF60;'>Defines the command (ex Submit) of the button.</td></tr>
	 * <tr><td style='background-color: #FFFFFF60;'><b>initialStyle	</b></td>	<td style='background-color: #FFFFFF60;'>Defines if initial behavior.</td></tr>
	 * <tr><td style='background-color: #FFFFFF60;'><b>hoverStyle	</b></td>	<td style='background-color: #FFFFFF60;'>Defines if onmouseover behavior. Changing style.</td></tr>
	 * <tr><td style='background-color: #FFFFFF60;'><b>onclick		</b></td>	<td style='background-color: #FFFFFF60;'>If not empty define the javascript used when clicking on the button.</td></tr>
	 * <tr><td style='background-color: #FFFFFF60;'><b>message		</b></td>	<td style='background-color: #FFFFFF60;'>Defines the button text</td></tr>
	 * <tr><td style='background-color: #FFFFFF60;'><b>mode			</b></td>	<td style='background-color: #FFFFFF60;'>1 set the size (if!=0) and save it into 'lastSize'. 0 will clear 'lastSize' and no button size will be set.</td></tr>
	 * <tr><td style='background-color: #FFFFFF60;'><b>size			</b></td>	<td style='background-color: #FFFFFF60;'>Defines the button size.</td></tr>
	 * <tr><td style='background-color: #FFFFFF60;'><b>lastSize		</b></td>	<td style='background-color: #FFFFFF60;'>is here as a variable passed along for the next button.</td></tr>
	 * </table>
	 * @param array $infos
	 * @return string
	 * 
	 */
	public function renderSubmitButton (&$infos) {
		if ( strlen($infos['hoverStyle']) > 0 ) { 
			$animation = " onmouseover=\"elm.ButtonHover('".$infos['id']."', '".$infos['hoverStyle']."');\" onmouseout=\"elm.ButtonHover('".$infos['id']."', '".$infos['initialStyle']."');\" ";
		}
		$Content = "
		<table cellpadding='0' cellspacing='0'  
		style='
		border-width: 0px 0px 0px 0px; 
		border-spacing: 0px; 
		border-style: none none none none;
		'>\r 
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
	
		$Content .= "border: 0px; padding: 0px; margin: 0px'></td>\r
		<td id='".$infos['id']."03' class='".$infos['initialStyle']."03' ".$animation."></td>\r
		</tr>\r
		</table>\r
		";
		return $Content;
	}

	// --------------------------------------------------------------------------------------------
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
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		
		$X = $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icone_dim_x');
		$Y = $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icone_dim_y');
		
		// 			<span class='".$Block."_lien ".$Block."_t3' Onclick=\"SDFTabRepCourant ( ".$i['table']." , ".$i['table']." , 'selecteur_de_fichier_dynamique' ); elm.FillScreenDiv('selecteur_de_fichier_FondNoir', 1 ); elm.SwitchDisplayCenter('selecteur_de_fichier_cadre')\">\r
		if ( !isset($i['update']) ) { $i['update'] = 0;} //default
		
		$contenu_A = "
			<input type='text' readonly name='".$i['formTargetId']."' id='".$i['formTargetId']."' size='".$i['formInputSize']."' maxlength='255' value='".$i['formInputVal']."' class='".$Block."_t3 " . $Block."_form_1' style='text-align:right;' >\r
			<span class='".$Block."_lien ".$Block."_t3' Onclick=\"fs.getDirectoryContent(".$i['array'].", '".$i['path']."', 0); elm.FillScreenDiv('FileSelectorDarkFade', 1 ); elm.SwitchDisplayCenter('FileSelectorFrame')\">\r
			<img src='../graph/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . "/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icone_repertoire') . "' width='".$X."' height='".$Y."' border='0'>
			</span>
			";
		
		$contenu_B = "
			<span class='".$Block."_lien ".$Block."_t3' Onclick=\"document.forms['".$i['formName']."'].elements['".$i['formTargetId']."'].value = '';\">
			<img src='../graph/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icone_efface') . "' width='".$X."' height='".$Y."' border='0'>
			</span>\r
			";
		
		$contenu_R = "";
		switch ( $i['case'] ) {
			case 1 :	$contenu_R = $contenu_A; 				break;
			case 2 :	$contenu_R = $contenu_B; 				break;
			case 3 :	$contenu_R = $contenu_A . $contenu_B;	break;
		}
		return $contenu_R;
	}
	
	// --------------------------------------------------------------------------------------------
	public function renderIconSelectImage ( $cas , $FormNom , $ForgeFormElement, $ForgeFormElementX, $ForgeFormElementY, $FormRepertoire , $InputVal , $DivCible , $JavascriptRoutine , $ModType ) {
		global $theme_tableau, ${$theme_tableau};
		$X = ${$theme_tableau}[$_REQUEST['blocT']]['icone_dim_x'];
		$Y = ${$theme_tableau}[$_REQUEST['blocT']]['icone_dim_y'];
		
		$contenu_A = "
	<input type='text' name='".$ForgeFormElement."' id='".$ForgeFormElement."' size='20' maxlength='255' value='".$InputVal."' class='".$theme_tableau.$_REQUEST['bloc']."_form_1'
	onChange=\"
	var NewU = 'url(\'../graph/' + document.forms['".$FormNom."'].elements['".$FormRepertoire."'].value + '/'+ this.value + '\')';
	elm.Gebi('".$DivCible."').style.backgroundImage = NewU;\r
	\">\r
			
	<span class='".$theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_t3'
	Onclick=\"
	CDMExec.ModType = '".$ModType."';
	CDMExec.NomModule = '".$DivCible."';
	CDMExec.FormCible = '".$FormNom."';
	RenderFSJS('".$FormNom."','".$ForgeFormElement."', '".$ForgeFormElementX."', '".$ForgeFormElementY."', document.forms['".$FormNom."'].elements['".$FormRepertoire."'].value , 'FSJavaScript' , 'FSJS_C_' , '".$JavascriptRoutine."' )\">
	<img src='../graph/" . ${$theme_tableau}['theme_directory'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['icone_repertoire'] . "' width='".$X."' height='".$Y."' border='0'></span>\r
	";
		
		$contenu_B = "
	<span class='".$theme_tableau.$_REQUEST['bloc']."_lien' Onclick=\"document.forms['".$FormNom."'].elements['".$ForgeFormElement."'].value = '';
	CDMExec.ModType = '".$ModType."';
	CDMExec.NomModule = '".$DivCible."';
	CDMExec.FormCible = '".$FormNom."';
	".$JavascriptRoutine."();\">\r
	<img src='../graph/" . ${$theme_tableau}['theme_directory'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['icone_efface'] . "' width='".$X."' height='".$Y."' border='0' alt=''></span>\r
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