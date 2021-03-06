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
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $cs CommonSystem                            */
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

// $RequestDataObj->setRequestDataEntry('script_source',"");
$cs->RequestDataObj->setRequestDataEntry('RenderCSS',
	array(
		'CssSelection' => 2,
		'go' => 1,
	),
);

/*Hydre-contenu_debut*/
$localisation = " / uni_admin_authentification_p01";

$cs->MapperObj->AddAnotherLevel($localisation );
$cs->LMObj->logCheckpoint("uni_admin_authentification_p01.php");
$cs->MapperObj->RemoveThisLevel($localisation );
$cs->MapperObj->setSqlApplicant("uni_admin_authentification_p01.php");

switch ($l) {
	case "fra":
		$i18nDoc = array(
		"invite1"		=>	"Cette partie va vous permettre de g&eacute;n&eacute;rer un script au format CSS (Cascading StyleSheet) pour un des thèmes de Hydr.<br>\r<br>\r",
		);
		break;
	case "eng":
		$i18nDoc = array(
		"invite1"		=>	"This part will allow you to create dedicated Stylesheet (Cascading StyleSheet) for a MWM theme.",
		);
		break;
}

if ( !class_exists('ModuleAuthentification')) {
	include ("../../modules/Authentification/module_authentification_Obj.php");
}
$obj = new ModuleAuthentification();
$Content .= $obj->render($infos);



/*Hydre-contenu_fin*/
?>
