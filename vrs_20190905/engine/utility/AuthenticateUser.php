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

class AuthenticateUser {
	private static $Instance = null;
	
	private $data = array();
	private $report = array();

	public function __construct(){	}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return AuthenticateUser
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new AuthenticateUser();
		}
		return self::$Instance;
	}

	/**
	 * Checks 
	 * @param User $UserObj
	 * @param String $mode
	 */
	public function checkUserCredential ( User $UserObj, $mode ) {
		$bts = BaseToolSet::getInstance();

		if ( strlen($UserObj->getUserEntry('error_login_not_found') ?? '') == 0 ) {
			$CurrentSetObj = CurrentSet::getInstance();
			$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite
			$CurrentSetObj->setDataSubEntry('autentification', 'mode', $mode);
			
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : mode=".$mode));
			switch ($mode) {
				case "session" :
					if ($UserObj->getUserEntry('user_login') != $_SESSION[$currentWs]['user_login'] ) {
						$this->data['error'] = TRUE;
						$this->data['errorType'] = 2;
						$this->data['errorInternalLog'][] = "UserObj/user_login != \$_SESSION/UserLogin";
					}
// 					2020 09 15 - As no password are stored in the session. No need to do that.
// 					A valid session and a found user in the DB is all we need. 
// 					if ($UserObj->getUserEntry ('user_password') != $_SESSION['user_password'] ) {
// 						$this->data['error'] = TRUE;
// 						$this->data['errorType'] = 1;
// 						$this->data['errorInternalLog'][] = "Wrong password";
// 					}
					$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : session checkUserCredentials :            user_login='".$UserObj->getUserEntry('user_login')."'"));
					$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : session checkUserCredentials :    session user_login='".$_SESSION[$currentWs]['user_login']."'"));
					$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : session checkUserCredentials :         user_password='".$UserObj->getUserEntry('user_password')."'"));
// 					$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : session checkUserCredentials : session user_password='".$_SESSION['user_password']."'");
					$this->report['user_login'] = $_SESSION[$currentWs]['user_login'];
					break;
				case "form" :
					if ( $bts->RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login') != "anonymous") {
						if ($UserObj->getUserEntry ('user_login') != $bts->RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login') ) {
							$this->data['error'] = TRUE;
							$this->data['errorType'] = 2;
							$this->data['errorInternalLog'][] = "UserObj/user_login != authentificationForm/user_login";
						}
						if ($UserObj->getUserEntry ('user_password') != hash("sha512",stripslashes($bts->RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_password'))) )  {
							$this->data['error'] = TRUE;
							$this->data['errorType'] = 1;
							$this->data['errorInternalLog'][] = "Wrong password";
						}
						$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : form checkUserCredentials :         user_login='".$UserObj->getUserEntry ('user_login')."'"));
						$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : form checkUserCredentials :    form user_login='".$bts->RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login')."'"));
						$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : form checkUserCredentials :      user_password='".$UserObj->getUserEntry ('user_password')."'"));
						$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : form checkUserCredentials : form user_password='".hash("sha512",stripslashes($bts->RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_password')))."'"));
						$this->report['user_login'] = $bts->RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login');
						
					}
					else {
						$this->data['error'] = TRUE;
						$this->data['errorType'] = 0;
						$this->data['errorInternalLog'][] = "anonymous is trying to log in... again.";
						$bts->RequestDataObj->setRequestData('connection_attempt', 0);
					}
					
					break;
			}
			
			if ( $this->data['error'] === TRUE ) {
				foreach ( $this->data['errorInternalLog'] as $A ) { $bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Error. " . $A )); } // only for debug purpose
				$bts->SMObj->ResetSession();
// 				$CurrentSetObj = CurrentSet::getInstance();

				$UserObj->resetUser();
				$CurrentSetObj->setDataSubEntry('article', 'arti_ref', 0);	// Auth fails, so the admin panels shouldn't be visible. Back to square one.
			}
			else {
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : The user `".$this->report['user_login']."` has successfuly authenticated"));
				$bts->SMObj->StoreUserCredential();
				
				$bts->SDDMObj->query ( "
				UPDATE " . $CurrentSetObj->SqlTableListObj->getSQLTableName ('user') . " SET
				user_last_ip = '".$_SERVER['REMOTE_ADDR']."',
				user_last_visit = '".$_SERVER['REQUEST_TIME']."'
				WHERE user_id = '".$UserObj->getUserEntry ('user_id')."'
				;" );
			}
		}
	}
	
	//@formatter:off
	
	public function getDataEntry ( $lvl1 ) { return $this->data[$lvl1]; }
	public function getDataSubEntry ( $lvl1, $lvl2 ) { return $this->data[$lvl1][$lvl2]; }
	public function setDataEntry ( $lvl1, $data ) { $this->data[$lvl1] = $data; }
	public function setDataSubEntry ( $lvl1, $lvl2, $data ) { $this->data[$lvl1][$lvl2] = $data; }
	
	//@formatter:on

}


?>