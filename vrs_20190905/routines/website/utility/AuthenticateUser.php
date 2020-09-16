<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

class AuthenticateUser {
	private static $Instance = null;
	
	private $data = array();
	private $report = array();
	
	//deprecated begin
// 	private $AuthenticateUserError = FALSE;
// 	private $AuthenticateUserErrorInternalLog = array();
	//deprecated end

	public function __construct(){	}

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
		$LMObj = LogManagement::getInstance();

		if ( strlen($UserObj->getUserEntry('error_login_not_found')) == 0 ) {
// 			$CMobj = ConfigurationManagement::getInstance ();
			$RequestDataObj = RequestData::getInstance ();
			$SMObj = SessionManagement::getInstance ( null );
			$CurrentSetObj = CurrentSet::getInstance();
			$CurrentSetObj->setDataSubEntry('autentification', 'mode', $mode);
			
			$LMObj->InternalLog("checkUserCredential mode:".$mode);
			switch ($mode) {
				case "session" :
					if ($UserObj->getUserEntry('user_login') != $_SESSION['user_login'] ) {
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
					$LMObj->InternalLog("session checkUserCredentials :            user_login='".$UserObj->getUserEntry ('user_login')."'");
					$LMObj->InternalLog("session checkUserCredentials :    session user_login='".$_SESSION['user_login']."'");
					$LMObj->InternalLog("session checkUserCredentials :         user_password='".$UserObj->getUserEntry ('user_password')."'");
// 					$LMObj->InternalLog("session checkUserCredentials : session user_password='".$_SESSION['user_password']."'");
					$this->report['user_login'] = $_SESSION['user_login'];
					break;
				case "form" :
					if ( $RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login') != "anonymous") {
						if ($UserObj->getUserEntry ('user_login') != $RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login') ) {
							$this->data['error'] = TRUE;
							$this->data['errorType'] = 2;
							$this->data['errorInternalLog'][] = "UserObj/user_login != authentificationForm/user_login";
						}
						if ($UserObj->getUserEntry ('user_password') != hash("sha512",stripslashes($RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_password'))) )  {
							$this->data['error'] = TRUE;
							$this->data['errorType'] = 1;
							$this->data['errorInternalLog'][] = "Wrong password";
						}
						$LMObj->InternalLog("form checkUserCredentials :         user_login='".$UserObj->getUserEntry ('user_login')."'");
						$LMObj->InternalLog("form checkUserCredentials :    form user_login='".$RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login')."'");
						$LMObj->InternalLog("form checkUserCredentials :      user_password='".$UserObj->getUserEntry ('user_password')."'");
						$LMObj->InternalLog("form checkUserCredentials : form user_password='".hash("sha512",stripslashes($RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_password')))."'");
						$this->report['user_login'] = $RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login');
						
					}
					else {
						$this->data['error'] = TRUE;
						$this->data['errorType'] = 0;
						$this->data['errorInternalLog'][] = "anonymous is trying to log in... again.";
						$RequestDataObj->setRequestData('connection_attempt', 0);
					}
					
					break;
			}
			
			if ( $this->data['error'] === TRUE ) {
				foreach ( $this->data['errorInternalLog'] as $A ) { $LMObj->InternalLog("Athentification Error : " . $A ); } // only for debug purpose
				$SMObj->ResetSession();
				$CurrentSetObj = CurrentSet::getInstance();

				$UserObj->resetUser();
				$CurrentSetObj->setDataSubEntry('article', 'arti_ref', 0);	// Auth fails, so the admin panels shouldn't be visible. Back to square one.
			}
			else {
				$LMObj->InternalLog("checkUserCredential = The user `".$this->report['user_login']."` has successfuly authenticated");
				$SMObj->StoreUserCredential();
				$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
				$SqlTableListObj = SqlTableList::getInstance ( null, null );
				
				$SDDMObj->query ( "
				UPDATE " . $SqlTableListObj->getSQLTableName ('user') . " SET
				user_derniere_ip = '".$_SERVER['REMOTE_ADDR']."',
				user_derniere_visite = '".$_SERVER['REQUEST_TIME']."'
				WHERE user_id = '".$UserObj->getUserEntry ('user_id')."'
				;" );
// 				$SDDMObj->query ( "
// 				UPDATE " . $SqlTableListObj->getSQLTableName ('user') . " SET
// 				user_derniere_ip = '".$_SESSION['last_REMOTE_ADDR']."',
// 				user_derniere_visite = '".$_SESSION['last_REQUEST_TIME']."'
// 				WHERE user_id = '".$UserObj->getUserEntry ('user_id')."'
// 				;" );
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