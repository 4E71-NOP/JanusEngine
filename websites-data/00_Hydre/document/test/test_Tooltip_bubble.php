<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
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
/*Hydre-IDE-end*/


/*Hydr-Content-Begin*/
$SB = array(
		"id"				=> "bouton_suppression_log1",
		"type"				=> "button",
		"initialStyle"		=> $Block."_submit_s1_n",
		"hoverStyle"		=> $Block."_submit_s1_h",
		"onclick"			=> "dm.dbgCalcDeco=1; TooltipConfig.test01={ 'State':1, 'X':'128', 'Y':'256' };",
		"message"			=> "128x256",
		"mode"				=> 1,
		"size" 				=> 96,
		"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);

$Content .=  ("<br>\r");

$SB = array(
		"id"				=> "bouton_suppression_log2",
		"type"				=> "button",
		"initialStyle"		=> $Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_submit_s2_h",
		"onclick"			=> "dm.dbgCalcDeco=1; TooltipConfig.test01={ 'State':1, 'X':'256', 'Y':'96' };",
		"message"			=> "256x96",
		"mode"				=> 1,
		"size" 				=> 96,
		"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
$Content .=  ("<br>\r<br>\r<br>\r
<div style='display:block; text-align:center;'>
<span
		style= 'margin:1cm; padding:0.5cm; background-color:#FF800080; border-radius: 0.5cm;'
		onMouseOver=\"t.ToolTip('Testing...', 'test01');\"
		onMouseOut=\"t.ToolTip('', 'test01');\">
Hover on me and test the tooltip!</span>\r
</div>\r
<br>\r
<br>\r
");
/*Hydr-Content-End*/

?>
