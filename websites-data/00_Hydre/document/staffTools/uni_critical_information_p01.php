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

// $LOG_TARGET = $LMObj->getInternalLogTarget();
// $LMObj->setInternalLogTarget("both");

/*Hydre-contenu_debut*/
$localisation = " / uni_critical_information_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_critical_information_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_critical_information_p01.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
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
		$bts->I18nTransObj->apply(array(
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

$Content .= $bts->I18nTransObj->getI18nTransEntry('url_bypass') . "

<span class='".$Block."_tb4'><a class='".$Block."_lien' href='
index.php?
&amp;sw=".$WebSiteObj->getWebSiteEntry('ws_id')."
&amp;l=".$UserObj->getUserEntry('lang')."
&amp;arti_ref=fra_admin_authentification
&amp;arti_page=1
'>".$bts->I18nTransObj->getI18nTransEntry('url_bypass_nom')."
</a>
</span>
<br>\r
<br>\r
<hr>\r
";

/*Hydre-contenu_fin*/
?>
