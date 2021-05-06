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

// $RequestDataObj->setRequestDataEntry('script_source',"");
$bts->RequestDataObj->setRequestDataEntry('RenderCSS',
	array(
		'CssSelection' => 2,
		'go' => 1,
	),
);
$bts->SMObj->setSessionEntry('user_login', 'anonymous');

/*Hydr-Content-Begin*/
$localisation = " / uni_admin_authentification_p01";

$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_admin_authentification_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_admin_authentification_p01.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
			"invite"		=>	"Module d'authentification<br>\r<br>\r",)
		);
		break;
	case "eng":
		$bts->I18nTransObj->apply(array(
			"invite"		=>	"Authentification module.",)
		);
		break;
}

if ( !class_exists('ModuleAuthentification')) {
	include("modules/Authentification/module_authentification_Obj.php");
}

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite');
$obj = new ModuleAuthentification();
$Content .= $obj->render($infos);

/*Hydr-Content-End*/
?>
