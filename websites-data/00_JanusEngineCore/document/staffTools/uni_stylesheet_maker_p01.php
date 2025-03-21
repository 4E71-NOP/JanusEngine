<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

/*JanusEngine-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $bts BaseToolSet                            */
/* @var $CurrentSetObj CurrentSet                   */
/* @var $ClassLoaderObj ClassLoader                 */

/* @var $SqlTableListObj SqlTableList               */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */

/* @var $Content String                             */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*JanusEngine-IDE-end*/

$bts->RequestDataObj->setRequestDataSubEntry('stylesheetMaker', 'selectedTheme', 9086995248375251520	);

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_stylesheet_maker_p01");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"Cette partie va vous permettre de g&eacute;n&eacute;rer un script au format CSS (Cascading StyleSheet) pour un des thèmes de Janus Engine.<br>\r<br>\r",
			"invite2"		=>	"Générer le stylesheet du theme :",
			"invite3"		=>	"Sélectionnez un theme :",
			"btn1"			=>	"Créer un stylesheet",
			"btn2"			=>	"Selectionner le texte",
			"frame1"		=>	"CSS",
			"frame2"		=>	"Variables mémoire",
			"retour"		=>	"Retour a la liste",
			"state0"		=>	"Hors ligne",
			"state1"		=>	"En ligne",
			"state2"		=>	"Supprimé",
			"instructions"	=>	"Le stylesheet se trouve dans le cadre. Recopiez le texte dans un fichier dont le nom est indiqué que vous placerez dans le repertoire 'stylesheets'.<br>\r
					<br>\r
					Cette m&eacute;thode est utilis&eacute;e pour diverses raisons. La principale est qu'il y a souvent des probl&egrave;mes de droits d'&eacute;criture sur le syst&egrave;me de fichier.<br>\r
					<br>\r",
		),
		"eng" => array(
			"invite1"		=>	"This part will allow you to create dedicated Stylesheet (Cascading StyleSheet) for a MWM theme.",
			"invite2"		=>	"Build the stylesheet of the theme : ",
			"invite3"		=>	"Select a theme :",
			"btn1"			=>	"Build the stylesheet",
			"btn2"			=>	"Select the text",
			"frame1"		=>	"CSS",
			"frame2"		=>	"Memory varibles",
			"retour"		=>	"Return to selection",
			"state0"		=>	"Offline",	
			"state1"		=>	"Online",	
			"state2"		=>	"Deleted",	
			"instructions"	=>	"The stylesheet is in the box. Copy the text and save it in a file Place this file in the directory named 'stylesheets'.<br>\r
					<br>\r
					This method is used for several reasons. The most common is about rights on the filesystem.<br>\r
					<br>\r",
		)
	)
);

// --------------------------------------------------------------------------------------------
$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r
".$bts->I18nTransObj->getI18nTransEntry('invite2')."
<br>\r
";

$Content .= "
<form name='generationCSS' ACTION='index.php?' method='post'>\r
<table cellpadding='16' cellspacing='0' style='margin-left: auto; margin-right: auto; '>
<tr>\r
<td>\r
".$bts->I18nTransObj->getI18nTransEntry('invite3')."<br>\r<br>\r
<select name='stylesheetMaker[selectedTheme]'>
";

$dbquery = $bts->SDDMObj->query("
	SELECT td.theme_id,td.theme_name,td.theme_title,tw.theme_state
	FROM ".$SqlTableListObj->getSQLTableName('theme_descriptor')." td, "
	.$SqlTableListObj->getSQLTableName('theme_website')." tw 
	WHERE tw.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'  
	AND td.theme_id = tw.fk_theme_id 
	ORDER BY td.theme_title
	;");

$SGEtat = array(
	0 => $bts->I18nTransObj->getI18nTransEntry('state0'),
	1 => $bts->I18nTransObj->getI18nTransEntry('state1'),
	2 => $bts->I18nTransObj->getI18nTransEntry('state2'),
);

while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
	$Content .= "<option value='".$dbp['theme_id']."'>".$dbp['theme_title']." (".$SGEtat[$dbp['theme_state']].") </option>\r";
}
$Content .= "</select>\r
<input type='hidden' name='formSubmitted'				value='1'>
<input type='hidden' name='formGenericData[origin]'		value='stylesheetMaker'>
<input type='hidden' name='formGenericData[action]' 	value='render'>\r
</td>\r
<td>\r
";

$SB = array(
		"id"				=> "chooseButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "",
		"message"			=> $bts->I18nTransObj->getI18nTransEntry('btn1'),
		"mode"				=> 0,
		"size" 				=> 128,
		"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "
</td>\r
</tr>\r
</table>\r
</form>\r
<br>\r
";

if ( $bts->RequestDataObj->getRequestDataSubEntry('stylesheetMaker', 'selectedTheme') != 0 ) {
	
	$ClassLoaderObj->provisionClass ('RenderStylesheet');
	$RenderStylesheetObj = RenderStylesheet::getInstance();
	$WorkingThemeData = new ThemeData();
	$WorkingThemeDescriptorObj = new ThemeDescriptor();
	$WorkingThemeDescriptorObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('stylesheetMaker', 'selectedTheme'));
	$WorkingThemeData->setThemeName('mt_');				// Change the to the Main Theme acronym "mt_" for rendering
	$WorkingThemeData->setThemeData($WorkingThemeDescriptorObj->getThemeDescriptor()); //Better to give an array than the object itself.
	$WorkingThemeData->setThemeDefinition($WorkingThemeDescriptorObj->getThemeDefinition());
	$WorkingThemeData->setDecorationListFromDB();
	$WorkingThemeData->renderBlockData();
	
	$theme_vars = "\$" . $WorkingThemeData->getThemeName()." = array (\n".$bts->StringFormatObj->print_r_code($WorkingThemeData->getThemeData(), "	") . "\n);\n\n"
	."\$ThemeDefinitionInstall = array (\n" . $bts->StringFormatObj->print_r_code($WorkingThemeData->getThemeDefinition(), "	") . "\n);";
	
	$stylesheet = $RenderStylesheetObj->render($WorkingThemeData->getThemeName(), $WorkingThemeData );
	$stylesheet = str_replace("	" , " ", $stylesheet);
	
	$Content .= "
	<hr>\r
	".$bts->I18nTransObj->getI18nTransEntry('instructions')."
	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
	
	<tr>\r
	<td>\r
	<br>\r<br>\r
	".$bts->I18nTransObj->getI18nTransEntry('frame1')."<br>\r
	<form name='CSSMaker' ACTION='' method='post'>\r
	<textarea name='CSSMakerResult' cols='80' rows='20' class='" . $Block."_t1 " . $Block."_form_1'>\r".$stylesheet."\r</textarea>\r<br>\r
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
			"onclick"			=> "javascript:this.form.CSSMakerResult.focus();this.form.CSSMakerResult.select();",
			"message"			=> $bts->I18nTransObj->getI18nTransEntry('btn2'),
			"mode"				=> 0,
			"size" 				=> 0,
			"lastSize"			=> 0,
	);
	$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
	
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
	".$bts->I18nTransObj->getI18nTransEntry('frame2')."<br>\r
	<form name='GDS_02' ACTION='' method='post'>\r
	<textarea name='CSSMakerResult' cols='80' rows='20' class='" . $Block."_t1 " . $Block."_form_1'>\r".$theme_vars."\r</textarea>\r<br>\r
	
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
			"onclick"			=> "javascript:this.form.CSSMakerResult.focus();this.form.CSSMakerResult.select();",
			"message"			=> $bts->I18nTransObj->getI18nTransEntry('btn2'),
			"mode"				=> 0,
			"size" 				=> 0,
			"lastSize"			=> 0,
	);
	$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
	
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

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
?>
