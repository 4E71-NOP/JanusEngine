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

/*Hydre-contenu_debut*/
$localisation = " / uni_informations_utiles_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_informations_utiles_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_informations_utiles_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"url_bypass" => "<p class='".Block."_tb4'>Acc&eacute;der aux panneaux d'administration:</p>\r
			Le moteur fonctionne avec un syst&egrave;me d'authentification. Si votre site n'a pas besoin d'utilisateur, et donc n'a pas besoin d'avoir le module pr&eacute;sent, vous ne pourrez plus vous authentifier de mani&egrave;re classique. Pour contourner ce petit probl&egrave;me, vous pouvez utiliser une URL qui fera en sorte que le moteur vous authentifie.<br>\r
			<br>\r
			Notez bien que si vous changez vos identifiants, une URL de ce type, sauvegard&eacute;e avec les anciens identifiants ne fonctionnera plus.<br>\r
			Avant de mettre le module d'authentification hors ligne vous pouvez enregistrer dans les signets cette URL.<br>\r
			<br>\r",
		"url_bypass_nom" => "Adresse pour me connecter au site",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"url_bypass" => "<p class='".$Block."_tb4'>Accessing Admin panels:</p>\r
			The engine works with a athentification system. If your website do not have the need to register users and by the way do not need to have the authentification module 'online', you will not be able to login either (classical way). To bypass this little problem, you can can use an URL that will make the engine perform the authification.<br>\r
			<br>\r
			Note that if you change you login and password, this URL with previous login and password information will not work anymore.<br>\r
			So before putting the authentification module offline you can bookmark this URL:<br>\r
			<br>\r",
		"url_bypass_nom" => "URL to loggin on this website",
		));
		break;
}

$Content .= $I18nObj->getI18nEntry('url_bypass') . "

<span class='".$Block."_tb4'><a class='".$Block."_lien' href='
index.php?
&amp;sw=".$WebSiteObj->getWebSiteEntry('ws_id')."
&amp;l=".$UserObj->getUserEntry('lang')."
&amp;arti_ref=fra_admin_authentification
&amp;arti_page=1
'>".$I18nObj->getI18nEntry('url_bypass_nom')."
</a>
</span>
<br>\r
<br>\r
<hr>\r
";

/*Hydre-contenu_fin*/
?>
