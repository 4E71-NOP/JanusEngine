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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class FormManagement
{
	private static $Instance = null;

	public function __construct() {}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return FormManagement
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new FormManagement();
		}
		return self::$Instance;
	}

	public function processForm()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$UserObj = $CurrentSetObj->UserObj;
		$WebSiteObj = $CurrentSetObj->WebSiteObj;

		$bts->mapSegmentLocation(__METHOD__, "formManagement");

		$bts->LMObj->saveVectorSystemLogLevel();
		$bts->LMObj->setVectorSystemLogLevel(LOGLEVEL_BREAKPOINT);

		$ClassLoaderObj->provisionClass('CommandConsole');
		$CurrentSetObj->setWebSiteContextObj($WebSiteObj); // Set an initial website context.
		// $CommandConsoleObj = CommandConsole::getInstance();

		$bts->LMObj->msgLog(array(
			'level' => LOGLEVEL_STATEMENT,
			'msg' => __METHOD__ . " : Form array = "
				. $bts->StringFormatObj->print_r_debug($bts->RequestDataObj->getRequestData())
		));

		$tmpFormRequest = $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'section');
		switch ($tmpFormRequest) {
			case "CommandConsole";
				if ($bts->CMObj->getConfigurationSubEntry('functions', 'commandLineEngine') == 'enabled') {
					// TODO must check a security token to make sure this was submitted by a form and not a forged post
					$token = $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'token');
					switch ($this->checkSecurityToken($token, _TOKEN_COMMAND_EXPIRATION_TIME_)) {
						case "notFound":
							$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - Token not found : " . $token));
							break;
			
						case "expired":
							// Token too old. Re-route to page "token expired"
							$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - Token expired : " . $token));
							// TODO remove commented lines below
							// $bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'progress', "processFaillure");
							// $bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error', true);
							// $bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error_type', 'errorTokenExpired');
							break;
			
						case "ok":
							$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Command console - CLiContent"));
							$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : CLiContent='" . $bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContent') . "'"));
							// We consider we have a script to execute as it's from AdminDashboard
							
							// TODO remove commented lines below
							// $bts->CMObj->setConfigurationSubEntry('functions', 'commandLineEngine', 'enabled');		// enabled/disabled
		
							$ClassLoaderObj->provisionClass('ScriptFormatting');
							$ScriptFormattingObj = ScriptFormatting::getInstance();
		
							$CLiContent['currentFileContent'] = $bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContent');
							$ScriptFormattingObj->createMap($CLiContent);
							$ScriptFormattingObj->commandFormatting($CLiContent);
		
							unset($A);
							foreach ($CLiContent['FormattedCommand'] as $A) {
								$Script[] = $A['cont'];
							}
							$this->runCommandScript($Script);
							break;
					}
				} else {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : Somebody tried to use commandLine while it is disabled."));
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : Script submitted = `" . $bts->RequestDataObj->getRequestDataEntry('formConsole', 'CLiContent') . "`."));
				}

				break;

			case "SubscriptionForm";
				if ($bts->CMObj->getConfigurationSubEntry('functions', 'user_sign_up') == 'enabled') {
					switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'action')) {
						case "SubmitSubsciption":
							$this->processSubscriptionForm();
							// send mail if all is ok
							break;
						case "SubscriptionConfirmation":
							$this->processSubscriptionConfirmation();
							// user confirmed email address
							// Enable user
							break;
					}
				} else {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : Somebody tried to use SubscriptionForm while it is disabled."));
				}

				break;

			case "ResetPasswordForm";
				switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'action')) {
					case "submitResetPassword":
						$this->processResetPassword();
						break;
					case "ResetPasswordConfirmation";
						// check token validity
						$this->ResetPasswordConfirmation();
						break;
					case "ResetPasswordFinalization":
						$this->processNewPassword();
						break;
				}
				break;

			default;
			// Create script from submitted form
				$ClassLoaderObj->provisionClass('FormToCommandLine');
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Command console - FormToCommandLine"));
				$FormToCommandLineObj = FormToCommandLine::getInstance();
				$FormToCommandLineObj->analysis();

				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : FormToCommandLineObj->getCommandLineNbr() =" . $FormToCommandLineObj->getCommandLineNbr()));

				if ($FormToCommandLineObj->getCommandLineNbr() > 0) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : A script is on the bench :"));

					// Make sure it's enabled for form processing
					$bts->CMObj->setConfigurationSubEntry('functions', 'commandLineEngine', 'enabled'); // enabled/disabled
					$Script = $FormToCommandLineObj->getCommandLineScript();
				}
				$this->runCommandScript($Script);
				break;
		}

		$bts->LMObj->restoreVectorSystemLogLevel();

		switch ($bts->RequestDataObj->getRequestDataSubEntry(
			'formGenericData',
			'origin'
		) . $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'section')) {
			case "AdminDashboardUserProfileForm":
			case "ModuleQuickSkin":
			case "ModuleSelectLanguage":
				$UserObj->getDataFromDBUsingLogin($UserObj->getUserEntry('user_login'), $WebSiteObj); // We need to reload the user data in order to update the current user_pref_theme variable.
				break;
			case "AdminDashboardWebsiteManagementP01":
				// refresh with updated data
				$id = $WebSiteObj->getWebSiteEntry('ws_id');
				$WebSiteObj->getDataFromDB($id);
				break;
		}

		$bts->segmentEnding(__METHOD__);



		return (true);
	}


	/**
	 * Run command after form processing
	 */
	private function runCommandScript($Script)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$UserObj = $CurrentSetObj->UserObj;
		$WebSiteObj = $CurrentSetObj->WebSiteObj;
		$CommandConsoleObj = CommandConsole::getInstance();

		switch ($bts->CMObj->getConfigurationSubEntry('functions', 'commandLineEngine')) {
			case "enabled":
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "+--------------------------------------------------------------------------------+"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "| Commande console                                                               |"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "+--------------------------------------------------------------------------------+"));
				foreach ($Script as $A) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : before CommandConsole->ExecuteCommand (`" . $A . "`)"));
					$CommandConsoleObj->executeCommand($A);

					// We have to reload website and user in case of one of them was updated.
					$WebSiteObj->getDataFromDBUsingShort();
					$UserObj->getDataFromDBUsingLogin($bts->SMObj->getSessionSubEntry($CurrentSetObj->getDataEntry('ws'), 'user_login'), $WebSiteObj);

					$ClassLoaderObj->provisionClass('CommonWebsiteTools');
					$CommonWebsiteToolsObj = CommonWebsiteTools::getInstance();
					$CommonWebsiteToolsObj->languageSelection();
				}
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "+--------------------------------------------------------------------------------+"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "| Fin Commande console                                                           |"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "+--------------------------------------------------------------------------------+"));
				break;
			case "disabled":
			default:
				foreach ($Script as $A) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Logging Command"));
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . $A));
				}
				break;
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End of command execution - " . $A));
	}


	private function processSubscriptionForm()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$WebSiteObj = $CurrentSetObj->WebSiteObj;
		// A new user is subscribing. By default it'll be a "Reader"
		// Check form strings (login, valid email address, non empty password)
		// If all is ok	-> Send mail and set 'progress'
		// else			-> back to signup page
		$formArr = array(
			"l" => str_replace('"', "'", $bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'signup_user_login')),
			"p" => $bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'signup_user_password'),
			"e" => $bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'signup_email'),
		);

		$processError = false;

		if (strlen($formArr['l'] ?? '') == 0) {
			$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error_type', 'errorEmptyLogin');
		} else {
			$signUpAttenptUserObj = new User();
			if ($signUpAttenptUserObj->getDataFromDBUsingLogin($formArr['l']) == true) {
				$processError = true;
				$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error_type', 'errorLoginAlreadyExists');
			};
		}
		if (strlen($formArr['p'] ?? '') == 0 && !$processError) {
			$processError = true;
			$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error_type', 'errorEmptyPassword');
		}
		if (strlen($formArr['e'] ?? '') == 0 && !$processError) {
			$processError = true;
			$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error_type', 'errorEmptyEmail');
		} else {
			if (filter_var($formArr['e'], FILTER_VALIDATE_EMAIL) == false) {
				$processError = true;
				$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error_type', 'errorInvalidEmail');
			} else {
				// Check if mail exists in user table
				$q = "SELECT user_id FROM "
					. $SqlTableListObj->getSQLTableName('user') . "  "
					. "WHERE user_email = '" . $formArr['e'] . "'";
				$dbquery = $bts->SDDMObj->query($q);
				if ($bts->SDDMObj->num_row_sql($dbquery) > 0) {
					$processError = true;
					$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error_type', 'errorEmailAlreadyExists');
				}
			}
		}


		if (!$processError) {
			$script = array(
				"website context name " . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_name'),
				"add user "
					. "name \"" . $formArr['l'] . "\" "
					. "login	\"" . $formArr['l'] . "\" "
					. "password \"" . hash('sha512', $formArr['p']) . "\" "
					. "email \"" . $formArr['e'] . "\" "
					. "status SIGNINGUP "
					. "image_avatar \"../websites-data/00_JanusEngineCore/data/images/avatars/public/mask_001.png\" "
					. ";",
				"assign user_permission name default_user_permission  to_user \"" . $formArr['l']  . "\";"
			);
			$this->runCommandScript($script);

			// send mail
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - Form looks ok - Sending email"));

			$ClassLoaderObj->provisionClass('SecurityToken');
			$SecurityTokenObj = new SecurityToken();
			$SecurityTokenObj->createTokenContent();
			$SecurityTokenObj->setSecurityTokenEntry('st_id', $bts->SDDMObj->createUniqueId());
			$SecurityTokenObj->setSecurityTokenEntry('st_action', 'subscribe');
			$SecurityTokenObj->setSecurityTokenEntry('st_login', $formArr['l']);
			$SecurityTokenObj->setSecurityTokenEntry('st_email', $formArr['e']);

			$SecurityTokenObj->sendToDB();

			// insert security log management.
			include("current/engine/extlib/phpmailer/current/src/PHPMailer.php");
			include("current/engine/extlib/phpmailer/current/src/SMTP.php");
			include("current/engine/extlib/phpmailer/current/src/Exception.php");
			$PHPMailerObj = new PHPMailer(true);

			try {
				$baseUrl  = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url');
				// Recipients
				// $PHPMailerObj->SMTPDebug = SMTP::DEBUG_SERVER;												//Enable verbose debug output
				$PHPMailerObj->CharSet = "UTF-8";
				$PHPMailerObj->Encoding = "base64";
				$PHPMailerObj->isSMTP();																	//Send using SMTP
				$PHPMailerObj->Host			= $bts->CMObj->getConfigurationSubEntry('mail', 'host');		//Set the SMTP server to send through
				$PHPMailerObj->SMTPAuth		= true;															//Enable SMTP authentication
				$PHPMailerObj->Username		= $bts->CMObj->getConfigurationSubEntry('mail', 'username');	//SMTP username
				$PHPMailerObj->Password		= $bts->CMObj->getConfigurationSubEntry('mail', 'password');	//SMTP password
				$PHPMailerObj->SMTPSecure	= PHPMailer::ENCRYPTION_SMTPS;									//Enable implicit TLS encryption
				$PHPMailerObj->Port			= 465;															//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
				$PHPMailerObj->setFrom('sign-up@local-janus-engine.com', $WebSiteObj->getWebSiteEntry('ws_name'));
				$PHPMailerObj->addAddress($formArr['e']);	 												//Add a recipient
				$PHPMailerObj->isHTML(true);																//Set email format to HTML
				$PHPMailerObj->Subject		= $WebSiteObj->getWebSiteEntry('ws_name') . " - Signing up";

				$lang639_3 = $this->getWebsiteLanguage();
				$targetFile = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('currentDirectory')
					. "/current/content/mails/mail_signup_"
					. $lang639_3
					. ".html";
				$mailContent = file_get_contents($targetFile);
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - Mail target file : '" . $targetFile . "'"));

				$mailContentSearchList = array("{{logo}}", "{{link}}", "{{websiteName}}", "{{baseUrl}}");
				$mailContentReplaceList = array(
					"<img src='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url')
						. "media/theme/" . $CurrentSetObj->ThemeDataObj->getDefinitionValue('directory')
						. "/" . $CurrentSetObj->ThemeDataObj->getDefinitionValue('logo')
						. "' alt='" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_name') . "' style='border:0px'>",

					$baseUrl . "sign-up"
						. "?formSubmitted=1"
						. "&formGenericData[origin]=uni_signup_p01"
						. "&formGenericData[section]=SubscriptionForm"
						. "&formGenericData[action]=SubscriptionConfirmation"
						. "&signUpForm[progress]=confirmationReceived"
						. "&signUpForm[token]="
						. $SecurityTokenObj->getSecurityTokenEntry('st_content'),

					$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_name'),
					$CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url')
				);
				$mailContent = str_replace($mailContentSearchList, $mailContentReplaceList, $mailContent);
				// $bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - Mail content : '" . $mailContent . "'"));

				$PHPMailerObj->Body			= $mailContent;
				$PHPMailerObj->send();

				$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'progress', 'mailSent');
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - email sent. We're done here."));
			} catch (Exception $e) {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " : SingUp - PhpMailer failed. -> " . $e->getMessage()));
				$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'progress', 'processFaillure');
				$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error', true);
				$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error_type', 'PhpMailfailed');
			}
		} else {
			$bts->RequestDataObj->setRequestDataSubEntry(
				'signUpForm',
				'progress',
				'signupForm'
			);
			$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error', true);
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : SingUp - Form error : " . $bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'error_type')));
		}
	}

	private function processSubscriptionConfirmation()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();

		$formArr = array(
			"t" => $bts->RequestDataObj->getRequestDataSubEntry('signUpForm', 'token'),
		);

		$ClassLoaderObj->provisionClass('SecurityToken');

		switch ($this->checkSecurityToken($formArr['t'], _TOKEN_SUBSCRIPTION_EXPIRATION_TIME_)) {
			case "notFound":
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - Token not found : " . $formArr['t']));
				break;

			case "expired":
				// Token too old. Re-route to page "token expired"
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - Token expired : " . $formArr['t']));
				$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'progress', "processFaillure");
				$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error', true);
				$bts->RequestDataObj->setRequestDataSubEntry('signUpForm', 'error_type', 'errorTokenExpired');
				break;

			case "ok":
				$SecurityTokenObj = new SecurityToken();
				$SecurityTokenObj->getDataFromDBbyToken($formArr['t']);
				$script = array(
					"website context name " . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_name'),
					"update user "
						. "name \"" . $SecurityTokenObj->getSecurityTokenEntry('st_login') . "\" "
						. "status ACTIVE "
						. ";",
				);

				$this->runCommandScript($script);
				break;
		}
	}

	private function processResetPassword()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$WebSiteObj = $CurrentSetObj->WebSiteObj;
		// A  user is reseting his password.
		// Check form strings (email address)
		// If all is ok	-> Send mail and set 'progress'
		// else			-> back to reset page page
		$formArr = array(
			"l" => $bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'reset_user'),
			"e" => $bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'reset_email'),
		);
		$processError = false;

		if (strlen($formArr['e'] ?? '') == 0) {
			$processError = true;
			$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error_type', 'errorEmptyEmail');
		} else {
			if (filter_var($formArr['e'], FILTER_VALIDATE_EMAIL) == false) {
				$processError = true;
				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error_type', 'errorInvalidEmail');
			} else {
				$resetAttenptUserObj = new User();
				$usrRes = $resetAttenptUserObj->getDataFromDBUsingEmail($formArr['e']);
				if ($usrRes == false) {
					$processError = true;
					$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error_type', 'errorEmailNotFound');
				} else {
					if ($resetAttenptUserObj->getUserEntry('user_login') != $formArr['l']) {
						$processError = true;
						$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error_type', 'errorWrongLogin');
					}
				};
			}
		}

		if (!$processError) {
			// send mail
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : ResetPassword - Form looks ok - Sending email"));

			$ClassLoaderObj->provisionClass('SecurityToken');
			$SecurityTokenObj = new SecurityToken();
			$SecurityTokenObj->createTokenContent();
			$SecurityTokenObj->setSecurityTokenEntry('st_id', $bts->SDDMObj->createUniqueId());
			$SecurityTokenObj->setSecurityTokenEntry('st_action', 'resetPassword');
			$SecurityTokenObj->setSecurityTokenEntry('st_email', $formArr['e']);

			$SecurityTokenObj->sendToDB();

			// insert security log management.
			include("current/engine/extlib/phpmailer/current/src/PHPMailer.php");
			include("current/engine/extlib/phpmailer/current/src/SMTP.php");
			include("current/engine/extlib/phpmailer/current/src/Exception.php");
			$PHPMailerObj = new PHPMailer(true);

			try {
				$baseUrl  = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url');
				// Recipients
				// $PHPMailerObj->SMTPDebug = SMTP::DEBUG_SERVER;												//Enable verbose debug output
				$PHPMailerObj->CharSet = "UTF-8";
				$PHPMailerObj->Encoding = "base64";
				$PHPMailerObj->isSMTP();																	//Send using SMTP
				$PHPMailerObj->Host			= $bts->CMObj->getConfigurationSubEntry('mail', 'host');		//Set the SMTP server to send through
				$PHPMailerObj->SMTPAuth		= true;															//Enable SMTP authentication
				$PHPMailerObj->Username		= $bts->CMObj->getConfigurationSubEntry('mail', 'username');	//SMTP username
				$PHPMailerObj->Password		= $bts->CMObj->getConfigurationSubEntry('mail', 'password');	//SMTP password
				$PHPMailerObj->SMTPSecure	= PHPMailer::ENCRYPTION_SMTPS;									//Enable implicit TLS encryption
				$PHPMailerObj->Port			= 465;															//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
				$PHPMailerObj->setFrom('sign-up@local-janus-engine.com', $WebSiteObj->getWebSiteEntry('ws_name'));
				$PHPMailerObj->addAddress($formArr['e']);	 												//Add a recipient
				$PHPMailerObj->isHTML(true);																//Set email format to HTML
				$PHPMailerObj->Subject		= $WebSiteObj->getWebSiteEntry('ws_name') . " - Password management";

				$lang639_3 = $this->getWebsiteLanguage();
				$targetFile = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('currentDirectory')
					. "/current/content/mails/mail_resetPassword_"
					. $lang639_3
					. ".html";
				$mailContent = file_get_contents($targetFile);
				// $bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - Mail target file : '" . $targetFile . "'"));

				$mailContentSearchList = array("{{logo}}", "{{link}}", "{{websiteName}}", "{{baseUrl}}");
				$mailContentReplaceList = array(
					"<img src='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url')
						. "media/theme/" . $CurrentSetObj->ThemeDataObj->getDefinitionValue('directory')
						. "/" . $CurrentSetObj->ThemeDataObj->getDefinitionValue('logo')
						. "' alt='" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_name') . "' style='border:0px'>",

					$baseUrl . $baseUrl . "reset-password"
						. "?formSubmitted=1"
						. "&formGenericData[origin]=uni_reset_password_p01"
						. "&formGenericData[section]=ResetPasswordForm"
						. "&formGenericData[action]=ResetPasswordConfirmation"
						. "&resetProcessForm[progress]=ResetPasswordConfirmation"
						. "&resetProcessForm[token]="
						. $SecurityTokenObj->getSecurityTokenEntry('st_content'),

					$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_name'),
					$CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url')
				);
				$mailContent = str_replace($mailContentSearchList, $mailContentReplaceList, $mailContent);
				// $bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - Mail content : '" . $mailContent . "'"));

				$PHPMailerObj->Body			= $mailContent;
				$PHPMailerObj->send();

				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'progress', 'mailSent');
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : SingUp - email sent. We're done here."));
			} catch (Exception $e) {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " : SingUp - PhpMailer failed. -> " . $e->getMessage()));
				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'progress', 'processFaillure');
				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error', true);
				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error_type', 'PhpMailfailed');
			}
		} else {
			$bts->RequestDataObj->setRequestDataSubEntry(
				'resetProcessForm',
				'progress',
				'resetPasswordForm'
			);
			$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error', true);
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : SingUp - Form error : " . $bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'error_type')));
		}
	}


	/**
	 * Saves the new password for the user
	 */
	private function ResetPasswordConfirmation()
	{
		$bts = BaseToolSet::getInstance();

		$formArr = array(
			"t" => $bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'token'),
		);

		switch ($this->checkSecurityToken($formArr['t'], _TOKEN_SUBSCRIPTION_EXPIRATION_TIME_)) {
			case "notFound":
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : resetProcessForm - Token not found : " . $formArr['t']));
				break;

			case "expired":
				// Token too old. Re-route to page "token expired"
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : resetProcessForm - Token expired : " . $formArr['t']));
				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'progress', 'processFaillure');
				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error', true);
				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error_type', 'errorTokenExpired');
				break;

			case "ok":
				break;
		}
	}

	/**
	 * Saves the new password for the user
	 */
	private function processNewPassword()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$formArr = array(
			"l" => str_replace('"', "'", $bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'reset_user')),
			"p" => $bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'reset_pw1'),
			"t" => $bts->RequestDataObj->getRequestDataSubEntry('resetProcessForm', 'token'),
		);

		switch ($this->checkSecurityToken($formArr['t'], _TOKEN_SUBSCRIPTION_EXPIRATION_TIME_)) {
			case "notFound":
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : resetProcessForm - Token not found : " . $formArr['t']));
				break;

			case "expired":
				// Token too old. Re-route to page "token expired"
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : resetProcessForm - Token expired : " . $formArr['t']));
				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'progress', 'processFaillure');
				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error', true);
				$bts->RequestDataObj->setRequestDataSubEntry('resetProcessForm', 'error_type', 'errorTokenExpired');
				break;

			case "ok":
				$script = array(
					"website context name " . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_name'),
					"update user "
						. "name \"" . $formArr['l'] . "\" "
						. "password \"" . hash('sha512', $formArr['p']) . "\" "
						. ";",
				);
				$this->runCommandScript($script);

				$bts->SMObj->InitializeSession();
				$CurrentSetObj->UserObj->resetUser();
				$CurrentSetObj->UserObj->getDataFromDBUsingLogin(ANONYMOUS_USER_NAME);

				break;
		}
	}


	/**
	 * 
	 */
	private function getWebsiteLanguage()
	{
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();

		// We take the website language to select the file
		// 639_3 norm is used
		$ClassLoaderObj->provisionClass('Language');
		$lang639_3 = new Language();

		$lang639_3->getDataFromDB($CurrentSetObj->WebSiteObj->getWebSiteEntry('fk_lang_id'));
		return $lang639_3->getLanguageEntry('lang_639_3');
	}


	private function checkSecurityToken($token, $delay)
	{
		$bts = BaseToolSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();

		$retResp = "ok";

		$ClassLoaderObj->provisionClass('SecurityToken');
		$SecurityTokenObj = new SecurityToken();

		if ($SecurityTokenObj->getDataFromDBbyToken($token)) {
			if ($SecurityTokenObj->isTokenExpired($delay)) {
				$retResp = "expired";
			}
		} else {
			$retResp = "notFound";
		}

		return $retResp;
	}
}
