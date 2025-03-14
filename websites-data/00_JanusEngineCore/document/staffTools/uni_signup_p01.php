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
		"origin"		=> "uni_signup_p01",
		"section"		=> "SubscriptionForm",
		"action"		=> "SubscriptionConfirmation",
		"action"		=> "",
	)
);

$bts->RequestDataObj->setRequestData(
	"signUpForm",
	array(
		"progress"					=> "signupForm",
		// "progress"					=> "mailSent",
		// "progress"					=> "confirmationReceived",
		// "progress"					=> "processFaillure",

		"signup_user_login"			=> "myLogin",
		"signup_user_password"		=> "plouf",
		"signup_email"				=> "email@domain.tld",

		"error"						=> true,
		"error_type"				=> "errorEmptyLogin",
		"error_type"				=> "errorEmptyPassword",
		"error_type"				=> "errorEmptyEmail",
		"error_type"				=> "errorLoginAlreadyExists",
		"error_type"				=> "errorEmailAlreadyExists",
		"error_type"				=> "errorInvalidEmail",
		"error_type"				=> "PhpMailfailed",
		"error_type"				=> "errorTokenExpired",
	)
);


$bts->RequestDataObj->setRequestData('scriptFile', 'uni_signup_p01.php');

$ClassLoaderObj = ClassLoader::getInstance();
$ClassLoaderObj->provisionClass('SecurityToken');
$SecurityTokenObj = new SecurityToken();
$SecurityTokenObj->createTokenContent();


// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_singup_p01");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"sslStateOff"	=>	"Le SSL n'est pas actif. La connexion n'est donc <b><u>PAS</u></b> sécurisée.",
			"invite1"		=>	"Remplissez les champs puis validez. Un mail vous sera envoyé pour confirmer la création du compte.",
			"invite2"		=>	"Un mail de confirmation a été envoyé. Cliquez sur le lien dans le mail pour confirmer l'inscription. Si vous ne trouvez pas le mail, vérifier qu'il n'est pas dans les 'indésirables'.",
			"invite3"		=>	"Félicitation le compte à été créé. Vous pouvez revenir à l'acceuil et vous connecter.",
			"invite4"		=>	"Une erreur s'est produite. Contactez un administrateur du site.",
			"invite5"		=>	"Le jeton sollicité a expiré. L'inscription n'aboutira pas. Vous devez recommencer l'inscrition.",
			"invite6"		=>	"Ce site ne permet pas l'inscription",

			"user_login"	=>	"Identifiant",
			"user_password"	=>	"Mot de passe",
			"user_mail"		=>	"Email",
			"buttonSignup"	=>	"Créer le compte",
			"errorEmptyLogin"			=> "Erreur : Identifiant vide",
			"errorEmptyPassword"		=> "Erreur : Mot de passe vide",
			"errorEmptyEmail"			=> "Erreur : Email vide",
			"errorLoginAlreadyExists"	=> "Erreur : L'identifiant existe déjà",
			"errorInvalidEmail"			=> "Erreur : L'Email est invalide",
			"errorEmailAlreadyExists"	=> "Erreur : L'Email est déjà utilisé",
		),
		"eng" => array(
			"sslStateOff"	=>	"SSL is not enabled. This connection is <b><u>NOT</u></b> secured.",
			"invite1"		=>	"Fill the form and submit. A mail will be sent to confirm the account creation.",
			"invite2"		=>	"A mail has been sent. Click on the link inside the mail to confirm the process. Please check you spam folder in case you don't find the mail.",
			"invite3"		=>	"Congratulations, your profile has been created. You can get back to the homepage and connect.",
			"invite4"		=>	"An error occured during the process. Please contact an website admin.",
			"invite5"		=>	"The selected token has expired. This sign up process will not continue. You must retry to sign up.",
			"invite6"		=>	"This website doesn't allow to sign up.",
			"user_login"	=>	"Login",
			"user_password"	=>	"Password",
			"user_mail"		=>	"Email",
			"buttonSignup"	=>	"Sign up",
			"errorEmptyLogin"			=> "Error : Empty login",
			"errorEmptyPassword"		=> "Error : Empty password",
			"errorEmptyEmail"			=> "Error : Empty email",
			"errorLoginAlreadyExists"	=> "Error : Login already exists",
			"errorInvalidEmail"			=> "Error : Invalid email",
			"errorEmailAlreadyExists"	=> "Error : Email is already used",
		)
	)
);


// --------------------------------------------------------------------------------------------
//	Debut du formulaire
// --------------------------------------------------------------------------------------------
if ($bts->CMObj->getConfigurationSubEntry('functions', 'user_sign_up') == 'enabled') {
	// If no form data -> step one
	if (strlen($bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'progress') ?? '') == 0) {
		$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'progress', 'signupForm');
		$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'signup_user_login', '');
		$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'signup_user_password', '');
		$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'signup_email', '');
	}
	
	if ($CurrentSetObj->ServerInfosObj->getServerInfosEntry('sslState') == 0) {
		$Content .= "<div style='background-color:#FF800080; margin:15px; padding:15px; border-radius:5px; box-shadow: 3px 5px 10px #00000040;'>"
			. "<div style='display:inline-block; width:40px;height:16px; background-size:contain; background-image: url(" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "/media/img/universal/ssl_ko.png)'></div>"
			. " " . $bts->I18nTransObj->getI18nTransEntry('sslStateOff')
			. "</div>\r"
			. "<br>\r";
	}
	
	switch ($bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'progress')) {
		case "signupForm":
			$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite1') . "</p>\r";
	
			// Test of token
			// $Content .= "<p>***|" . $SecurityTokenObj->getSecurityTokenEntry('st_content') . "|***</p>\r";
	
			if ($bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'error')) {
	
				$error_string = "";
				switch ($bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'error_type')) {
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
				}
	
				$Block = $CurrentSetObj->ThemeDataObj->getThemeName() . $infos['block'];
				$Content .= "<p class='" . $Block . "_error' style='font-weight:bold;'>" . $error_string . "</p>\r";
			}
	
			$Content .=
				$bts->RenderFormObj->renderformHeader('signup')
				. "<table style='margin-right: auto; margin-left: auto'>\r"
				. "<tr>\r<td style='text-align:right; padding:15px;'>" . $bts->I18nTransObj->getI18nTransEntry('user_login') . "</td>\r"
				. "<td style='text-align:center; padding-bottom:8px;'>"
				. $bts->RenderFormObj->renderInputText('signUpForm[signup_user_login]', $bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'signup_user_login'), "Login", 32)
				. "</td>\r</tr>\r"
				. "<tr>\r<td style='text-align:right; padding:15px;'>" . $bts->I18nTransObj->getI18nTransEntry('user_password') . "</td>\r"
				. " <td style='text-align:center; padding-bottom:8px;'>"
				. $bts->RenderFormObj->renderInputPassword('signUpForm[signup_user_password]', $bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'signup_user_password'), "Password", 32)
				. "</td>\r</tr>\r"
				. "<tr>\r<td style='text-align:right; padding:15px;'>" . $bts->I18nTransObj->getI18nTransEntry('user_mail') . "</td>\r"
				. "<td style='text-align:center; padding-bottom:8px;'>"
				. $bts->RenderFormObj->renderInputText('signUpForm[signup_email]', $bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'signup_email'), "email", 32)
				. "</td>\r</tr>\r"
				. "</table>\r
			<br>\r"
				. $bts->RenderFormObj->renderHiddenInput('formGenericData[origin]',		"uni_signup_p01")
				. $bts->RenderFormObj->renderHiddenInput('formGenericData[section]',	"SubscriptionForm")
				. $bts->RenderFormObj->renderHiddenInput('formGenericData[action]',		"SubmitSubsciption")
				. $bts->RenderFormObj->renderHiddenInput('formSubmitted',				"1");
	
			$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
				$infos,
				'submit',
				$bts->I18nTransObj->getI18nTransEntry('buttonSignup'),
				'',
				'signupButton',
				1,
				1,
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
	
		case "confirmationReceived":
			$Content .= "<table style='margin-right: auto; margin-left: auto'>\r"
				. "<tr>\r<td style='padding:15px;'>"
				. "<img width='64' heigth='64' src='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_ok') . "'>"
				. "</td>\r"
				. "<td style='padding:15px;'>"
				. $bts->I18nTransObj->getI18nTransEntry('invite3')
				. "</td>\r</tr>\r"
				. "</table>\r";
	
			break;
	
		case "processFaillure":
			switch ($bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'error_type')) {
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

} else {
	$Content .= "<table style='margin-right: auto; margin-left: auto'>\r"
	. "<tr>\r<td style='padding:15px;'>"
	. "<img width='64' heigth='64' src='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_nok') . "'>"
	. "</td>\r"
	. "<td style='padding:15px;'>"
	. $bts->I18nTransObj->getI18nTransEntry('invite6')
	. "</td>\r</tr>\r"
	. "</table>\r";
}	

// --------------------------------------------------------------------------------------------
$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
