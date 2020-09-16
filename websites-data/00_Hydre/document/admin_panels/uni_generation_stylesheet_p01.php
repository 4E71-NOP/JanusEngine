<?php
/*Hydre-licence-begin*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE work.
/* @var $AdminFormToolObj AdminFormTool             */
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $I18nObj I18n                               */
/* @var $InteractiveElementsObj InteractiveElements */
/* @var $RenderTablesObj RenderTables               */
/* @var $RequestDataObj RequestData                 */
/* @var $SDDMObj DalFacade                          */
/* @var $SqlTableListObj SqlTableList               */
/* @var $StringFormatObj StringFormat               */
/* @var $TimeObj Time                               */

/* @var $CurrentSetObj CurrentSet                   */
/* @var $DocumentDataObj DocumentData               */
/* @var $RenderLayoutObj RenderLayout               */
/* @var $ThemeDataObj ThemeData                     */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */

/* @var $Block String                               */
/* @var $infos array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

$logTarget = $LMObj->getInternalLogTarget();
$LMObj->setInternalLogTarget("both");

// $RequestDataObj->setRequestDataEntry('script_source',"");
$RequestDataObj->setRequestDataEntry('RenderCSS', 
	array(
			'CssSelection' => 2,
			'go' => 1,
	),
);

/*Hydre-contenu_debut*/
$localisation = " / fra_generation_stylesheet_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("fra_generation_stylesheet_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("fra_generation_stylesheet_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=>	"Cette partie va vous permettre de g&eacute;n&eacute;rer un script au format CSS (Cascading StyleSheet) pour un des thèmes de Hydr.<br>\r<br>\r",
		"invite2"		=>	"Générer le stylesheet du theme :",
		"invite3"		=>	"Sélectionnez un theme :",
		"btn1"			=>	"Créer un stylesheet",
		"btn2"			=>	"Selectionner le texte",
		"frame1"		=>	"CSS",
		"frame2"		=>	"Variables mémoire",
		"retour"		=>	"Retour a la liste",
		"state0"	=>	"Hors ligne",
		"state1"	=>	"En ligne",
		"state2"	=>	"Supprimé",
		"instructions"	=>	"Le stylesheet se trouve dans le cadre. Recopiez le texte dans un fichier dont le nom est indiqué que vous placerez dans le repertoire 'stylesheets'.<br>\r
				<br>\r
				Cette m&eacute;thode est utilis&eacute;e pour diverses raisons. La principale est qu'il y a souvent des probl&egrave;mes de droits d'&eacute;criture sur le syst&egrave;me de fichier.<br>\r
				<br>\r",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=>	"This part will allow you to create dedicated Stylesheet (Cascading StyleSheet) for a MWM theme.",
		"invite2"		=>	"Build the stylesheet of the theme : ",
		"invite3"		=>	"Select a theme :",
		"btn1"			=>	"Build the stylesheet",
		"btn2"			=>	"Select the text",
		"frame1"		=>	"CSS",
		"frame2"		=>	"Memory varibles",
		"retour"		=>	"Return to selection",
		"state0"	=>	"Offline",	
		"state1"	=>	"Online",	
		"state2"	=>	"Deleted",	
		"instructions"	=>	"The stylesheet is in the box. Copy the text and save it in a file Place this file in the directory named 'stylesheets'.<br>\r
				<br>\r
				This method is used for several reasons. The most common is about rights on the filesystem.<br>\r
				<br>\r",
		));
		break;
}


// --------------------------------------------------------------------------------------------
$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r
".$I18nObj->getI18nEntry('invite2')."
<br>\r
";

$Content .= "
<form name='generationSS' ACTION='index.php?' method='post'>\r
<table cellpadding='16' cellspacing='0' style='margin-left: auto; margin-right: auto; '>
<tr>\r
<td>\r
".$I18nObj->getI18nEntry('invite3')."<br>\r<br>\r
<select name='CssSelection' class='".$Block."_t3 ".$Block."_form_1'>
";

$dbquery = $SDDMObj->query("
SELECT sd.theme_id,sd.theme_nom,sd.theme_titre,ss.theme_etat
FROM ".$SqlTableListObj->getSQLTableName('theme_descripteur')." sd , ".$SqlTableListObj->getSQLTableName('site_theme')." ss 
WHERE ss.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'  
AND sd.theme_id = ss.theme_id 
;");

$SGEtat = array(
	0 => $I18nObj->getI18nEntry('state0'),
	1 => $I18nObj->getI18nEntry('state1'),
	2 => $I18nObj->getI18nEntry('state2'),
);

while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
	$Content .= "<option value='".$dbp['theme_id']."'>".$dbp['theme_titre']." (".$SGEtat[$dbp['theme_etat']].") </option>\r";
}
$Content .= "</select>\r".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')."
<input type='hidden' name='RenderCSS[go]' value='1'>\r".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_login').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_pass')."
</td>\r
<td>\r
";

$SB = array(
		"id"				=> "chooseButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "",
		"message"			=> $I18nObj->getI18nEntry('btn1'),
		"mode"				=> 0,
		"size" 				=> 128,
		"lastSize"			=> 0,
);
$Content .= $InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "
</td>\r
</tr>\r
</table>\r
</form>\r
<br>\r
";

if ( $RequestDataObj->getRequestDataSubEntry('RenderCSS', 'go')) {
	$dbquery = $SDDMObj->query("
	SELECT * 
	FROM ".$SqlTableListObj->getSQLTableName('theme_descripteur')." a , ".$SqlTableListObj->getSQLTableName('site_theme')." b 
	WHERE a.theme_id = '".$RequestDataObj->getRequestDataSubEntry('RenderCSS', 'CssSelection')."' 
	AND a.theme_id = b.theme_id 
	;");
	
	$RenderStylesheetObj = RenderStylesheet::getInstance();
	$WorkingThemeData = new ThemeData();
	$WorkingThemeData->setThemeName('renderCSS_');				// will use the $RequestDataObj->getRequestDataSubEntry('RenderCSS', 'CssSelection') as the theme ID
	$WorkingThemeDescriptorObj = new ThemeDescriptor();
	$WorkingThemeDescriptorObj->getThemeDescriptorDataFromDB($ThemeDataObj->getThemeName(), $UserObj, $WebSiteObj);
	$WorkingThemeData->setThemeName('mt_');				// Change the to the Maint Theme acronym "mt_" for rendering
	$WorkingThemeData->setThemeData($WorkingThemeDescriptorObj->getThemeDescriptor()); //Better to give an array than the object itself.
	$WorkingThemeData->setDecorationListFromDB();
	$WorkingThemeData->renderBlockData();
	
	$theme_vars = "\$" . $WorkingThemeData->getThemeName()." = array (\n".$StringFormatObj->print_r_code($WorkingThemeData->getThemeData(), "	")."\n);";
	
	$stylesheet = $RenderStylesheetObj->render($WorkingThemeData->getThemeName(), $WorkingThemeData );
	$stylesheet = str_replace("	" , " ", $stylesheet);
	
	$fontSizeMin = $ThemeDataObj->getThemeBlockEntry($infos['block']."T", 'txt_fonte_size_min');
	$fontSizeMax = $ThemeDataObj->getThemeBlockEntry($infos['block']."T", 'txt_fonte_size_max');
	$coef = (($fontSizeMax - $fontSizeMin) / 7);
	$fontSize =$fontSizeMin+($coef*1);
	
	
	$Content .= "
	<hr>\r
	".$I18nObj->getI18nEntry('instructions')."
	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
	
	<tr>\r
	<td>\r
	<br>\r<br>\r
	".$I18nObj->getI18nEntry('frame1')."<br>\r
	<form name='GDS_01' ACTION='' method='post'>\r
	<textarea name='GDS_result' cols='".floor(($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')/$fontSize)*1.5)."' rows='20' class='" . $Block."_t1 " . $Block."_form_1'>\r".$stylesheet."\r</textarea>\r<br>\r
	</td>\r
	</tr>\r

	<tr>\r
	<td>\r
		<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px;'>
		<tr>\r<td>\r&nbsp;</td>\r</tr>\r

		<tr>\r
		<td>\r
	";
	$SB = array(
			"id"				=> "selectButton1",
			"type"				=> "button",
			"initialStyle"		=> $Block."_t3 ".$Block."_submit_s1_n",
			"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s1_h",
			"onclick"			=> "javascript:this.form.GDS_result.focus();this.form.GDS_result.select();",
			"message"			=> $I18nObj->getI18nEntry('btn2'),
			"mode"				=> 0,
			"size" 				=> 0,
			"lastSize"			=> 0,
	);
	$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
	
	$Content .= "
		</form>\r
		</td>\r
		</tr>\r
		</table>
	
	</td>\r
	</tr>\r

	</td>\r
	</tr>\r
	
	<tr>\r
	<td>\r
	<br>\r<br>\r
	".$I18nObj->getI18nEntry('frame2')."<br>\r
	<form name='GDS_02' ACTION='' method='post'>\r
	<textarea name='GDS_result' cols='".floor(($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')/$fontSize)*1.5)."' rows='20' class='" . $Block."_t1 " . $Block."_form_1'>\r".$theme_vars."\r</textarea>\r<br>\r
	
	<tr>\r
	<td>\r
		<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px;'>
		<tr>\r
		<td>\r
	";
	
	$SB = array(
			"id"				=> "selectButton2",
			"type"				=> "button",
			"initialStyle"		=> $Block."_t3 ".$Block."_submit_s1_n",
			"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s1_h",
			"onclick"			=> "javascript:this.form.GDS_result.focus();this.form.GDS_result.select();",
			"message"			=> $I18nObj->getI18nEntry('btn2'),
			"mode"				=> 0,
			"size" 				=> 0,
			"lastSize"			=> 0,
	);
	$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
	
	$Content .= "
		</form>\r
		</td>\r
		</tr>\r
		</table>\r
	
	</td>\r
	</tr>\r
	</table>\r
	
	";
}


/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
