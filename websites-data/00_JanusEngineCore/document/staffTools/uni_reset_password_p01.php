<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

/*JanusEngine-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $bts BaseToolSet                            */
/* @var $CurrentSetObj CurrentSet                   */
/* @var $ClassLoaderObj ClassLoader                 *x/

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

// --------------------------------------------------------------------------------------------
$bts->RequestDataObj->setRequestData(
	"formGenericData",
	array(
		"origin"		=> "uni_reset_password_p01",
		"section"		=> "ResetPassword",
		"action"		=> "ResetPassword",
	)
);

$bts->RequestDataObj->setRequestData(
	"resetProcessForm",
	array(
		"progress"					=> "processFaillure",
		"progress"					=> "resetPasswordNewPassword",
		"progress"					=> "resetPasswordForm",
		"progress"					=> "ResetPasswordConfirmation",

		"reset_user"				=> $CurrentSetObj->UserObj->getUserEntry('user_login'),
		"reset_email"				=> "email@domain.tld",

		"error"						=> true,
		"error_type"				=> "errorEmptyEmail",
		"error_type"				=> "errorInvalidEmail",
		"error_type"				=> "errorEmailNotFound",
		"error_type"				=> "PhpMailfailed",
	)
);


$bts->RequestDataObj->setRequestData('scriptFile', 'uni_reset_password_p01.php');

$ClassLoaderObj = ClassLoader::getInstance();
$ClassLoaderObj->provisionClass('SecurityToken');
$SecurityTokenObj = new SecurityToken();
$SecurityTokenObj->createTokenContent();


// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_reset_password_p01");

$bts->I18nTransObj->getI18nTransFromDB("uni_reset_password");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_reset_password_p01_");

// --------------------------------------------------------------------------------------------
//	Debut du formulaire
// --------------------------------------------------------------------------------------------

// If no form data -> step one
if (strlen($bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'progress') ?? '') == 0) {
	$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'progress', 'resetPasswordForm');
}

if ($CurrentSetObj->ServerInfosObj->getServerInfosEntry('sslState') == 0) {
	$Content .= "<div style='background-color:#FF800080; margin:15px; padding:15px; border-radius:5px; box-shadow: 3px 5px 10px #00000040;'>"
		. "<div style='display:inline-block; width:40px;height:16px; background-size:contain; background-image: url(" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "/media/img/universal/ssl_ko.png)'></div>"
		. " " . $bts->I18nTransObj->getI18nTransEntry('sslStateOff')
		. "</div>\r"
		. "<br>\r";
}

switch ($bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'progress')) {
	case "resetPasswordForm":
		$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite1') . "</p>\r";

		// Test of token
		// $Content .= "<p>***|" . $SecurityTokenObj->getSecurityTokenEntry('st_content') . "|***</p>\r";

		if ($bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'error')) {

			$error_string = "";
			switch ($bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'error_type')) {
				case "errorEmptyLogin":
					$error_string = $bts->I18nTransObj->getI18nTransEntry('errorEmptyLogin');
					break;
				case "errorEmptyPassword":
					$error_string = $bts->I18nTransObj->getI18nTransEntry('errorEmptyPassword');
					break;
				case "errorEmptyEmail":
					$error_string = $bts->I18nTransObj->getI18nTransEntry('errorEmptyEmail');
					break;
				case "errorLoginAlreadyExists":
					$error_string = $bts->I18nTransObj->getI18nTransEntry('errorLoginAlreadyExists');
					break;
				case "errorInvalidEmail":
					$error_string = $bts->I18nTransObj->getI18nTransEntry('errorInvalidEmail');
					break;
				case "errorEmailAlreadyExists":
					$error_string = $bts->I18nTransObj->getI18nTransEntry('errorEmailAlreadyExists');
					break;
				case "errorWrongLogin":
					$error_string = $bts->I18nTransObj->getI18nTransEntry('errorEmailAlreadyExists');
					break;
			}

			$Block = $CurrentSetObj->ThemeDataObj->getThemeName() . $infos['block'];
			$Content .= "<p class='" . $Block . "_error' style='font-weight:bold;'>" . $error_string . "</p>\r";
		}

		$Content .=
			$bts->RenderFormObj->renderformHeader('resetPasswordStep1')
			. "<table style='margin-right: auto; margin-left: auto'>\r"
			. "<tr>\r<td style='text-align:right; padding:15px;'>" . $bts->I18nTransObj->getI18nTransEntry('user_mail') . "</td>\r"
			. "<td style='text-align:center; padding-bottom:8px;'>"
			. $bts->RenderFormObj->renderInputText('resetProcessForm[reset_email]', $bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'reset_email'), "email", 32)
			. "</td>\r</tr>\r"
			. "</table>\r"
			. "<br>\r"
			. $bts->RenderFormObj->renderHiddenInput('resetProcessForm[reset_user]',	$CurrentSetObj->UserObj->getUserEntry('user_login'))
			. $bts->RenderFormObj->renderHiddenInput('formGenericData[origin]',			"uni_reset_password_p01")
			. $bts->RenderFormObj->renderHiddenInput('formGenericData[section]',		"ResetPasswordForm")
			. $bts->RenderFormObj->renderHiddenInput('formGenericData[action]',			"submitResetPassword")
			. $bts->RenderFormObj->renderHiddenInput('formSubmitted',					"1");

		$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
			$infos,
			'submit',
			$bts->I18nTransObj->getI18nTransEntry('buttonResetPw'),
			'',
			'resetButton',
			3,
			3,
			""
		);

		$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB)
			. "</td>\r</tr>\r
				</table>\r";
		break;

	case "mailSent":

		$Content .= "<table style='margin-right: auto; margin-left: auto'>\r"
			. "<tr>\r<td style='padding:15px;'>"
			. "<img width='64' heigth='64' src='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ok') . "'>"
			. "</td>\r"
			. "<td style='padding:15px;'>"
			. $bts->I18nTransObj->getI18nTransEntry('invite2')
			. "</td>\r</tr>\r"
			. "</table>\r";

		break;

	case "ResetPasswordConfirmation":

		$arrInputPw1 = array(
			"id" => "resetProcessForm[reset_pw1]",
			"name" => "resetProcessForm[reset_pw1]",
			"size" => 32,
			"onkeyup" => "if (this.value != elm.Gebi('resetProcessForm[reset_pw2]').value ) { this.style.backgroundColor = '#FF000040'; elm.Gebi('resetProcessForm[reset_pw2]').style.backgroundColor = '#FF000040';} else {this.style.backgroundColor = ''; elm.Gebi('resetProcessForm[reset_pw2]').style.backgroundColor = ''}",
			"placeholder" => $bts->I18nTransObj->getI18nTransEntry('user_password')
		);

		$arrInputPw2 = array(
			"id" => "resetProcessForm[reset_pw2]",
			"name" => "resetProcessForm[reset_pw2]",
			"size" => 32,
			"onkeyup" => "if (this.value != elm.Gebi('resetProcessForm[reset_pw1]').value ) { this.style.backgroundColor = '#FF000040'; elm.Gebi('resetProcessForm[reset_pw1]').style.backgroundColor = '#FF000040';} else {this.style.backgroundColor = ''; elm.Gebi('resetProcessForm[reset_pw1]').style.backgroundColor = ''}",
			"placeholder" => $bts->I18nTransObj->getI18nTransEntry('user_password')
		);

		$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('enter_new_password') . "</p>\r"
			. $bts->RenderFormObj->renderformHeader('resetPasswordStep2')
			. "<table style='margin-right: auto; margin-left: auto'>\r"
			. "<tr>\r"
			. "<td style='text-align:right; padding:15px;'>" . $bts->I18nTransObj->getI18nTransEntry('user_password') . "</td>\r"
			. "<td style='text-align:center; padding-bottom:8px;'>" . $bts->RenderFormObj->renderInputPasswordEnhanced($arrInputPw1) . "</td>\r"
			. "<td><img src='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_question') . "' 
				width='32' height='32' 
				onclick=\"elm.ToggleInputType('resetProcessForm[reset_pw1]')\"></td>\r"
			. "</tr>\r"

			. "<tr>\r"
			. "<td style='text-align:right; padding:15px;'>" . $bts->I18nTransObj->getI18nTransEntry('user_password') . "</td>\r"
			. "<td style='text-align:center; padding-bottom:8px;'>" . $bts->RenderFormObj->renderInputPasswordEnhanced($arrInputPw2) . "</td>\r"
			. "<td><img src='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_question') . "' 
				width='32' height='32' 
				onclick=\"elm.ToggleInputType('resetProcessForm[reset_pw2]');\"></td>\r"
			. "</tr>\r"

			. "</table>\r"
			. "<br>\r"
			. $bts->RenderFormObj->renderHiddenInput('resetProcessForm[reset_user]',	$CurrentSetObj->UserObj->getUserEntry('user_login'))
			. $bts->RenderFormObj->renderHiddenInput('resetProcessForm[token]',			$bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'token'))
			. $bts->RenderFormObj->renderHiddenInput('formGenericData[origin]',			"uni_reset_password_p01")
			. $bts->RenderFormObj->renderHiddenInput('formGenericData[section]',		"ResetPasswordForm")
			. $bts->RenderFormObj->renderHiddenInput('formGenericData[action]',			"ResetPasswordFinalization")
			. $bts->RenderFormObj->renderHiddenInput('formSubmitted',					"1");

		$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
			$infos,
			'submit',
			$bts->I18nTransObj->getI18nTransEntry('buttonNewPw'),
			'',
			'resetButton',
			3,
			3,
			""
		);

		$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB)
			. "</td>\r</tr>\r
				</table>\r";
		break;

	case "processFaillure":
		switch ($bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'error_type')) {
			case "PhpMailfailed":
				$Content .= "<table style='margin-right: auto; margin-left: auto'>\r"
					. "<tr>\r<td style='padding:15px;'>"
					. "<img width='64' heigth='64' src='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_nok') . "'>"
					. "</td>\r"
					. "<td style='padding:15px;'>"
					. $bts->I18nTransObj->getI18nTransEntry('invite4')
					. "</td>\r</tr>\r"
					. "</table>\r";
				break;

			case "errorTokenExpired":
				$Content .= "<table style='margin-right: auto; margin-left: auto'>\r"
					. "<tr>\r<td style='padding:15px;'>"
					. "<img width='64' heigth='64' src='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_nok') . "'>"
					. "</td>\r"
					. "<td style='padding:15px;'>"
					. $bts->I18nTransObj->getI18nTransEntry('invite5')
					. "</td>\r</tr>\r"
					. "</table>\r";
				break;
		}
		break;
}

$Content .= "<br>\r
			<br>\r
			<br>\r
			<br>\r
			<br>\r
";


// --------------------------------------------------------------------------------------------

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
