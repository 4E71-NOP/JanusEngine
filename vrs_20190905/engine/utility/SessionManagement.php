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

/*
session_start();
session_unset();
session_destroy();
session_write_close();
setcookie(session_name(),'',0,'/');
session_regenerate_id(true);
*/


class SessionManagement {
	private static $Instance = null;
	
	private $session = array();
	private $report = array();
	
	private function __construct(){
		$this->InitializeSession();
		$this->session = array_merge($this->session, $_SESSION);
	}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return SessionManagement
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new SessionManagement();
		}
		return self::$Instance;
	}
	
	/**
	 * Initialize the session array with default values
	 */
	public function InitializeSession(){
		$cs = CommonSystem::getInstance();
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : InitializeSession has been called"));
		
		$this->session['SessionMaxAge']			= $cs->CMObj->getConfigurationEntry('SessionMaxAge');
		$this->session['user_login']			= "anonymous";
		$this->session['ws']					= DEFAULT_SITE_ID;
		$this->session['err']					= FALSE;
		$this->session['last_REMOTE_ADDR']		= $_SERVER['REMOTE_ADDR'];
		$this->session['last_REMOTE_PORT']		= $_SERVER['REMOTE_PORT'];
		$this->session['last_HTTP_USER_AGENT']	= $_SERVER['HTTP_USER_AGENT'];
		$this->session['last_REQUEST_TIME']		= $_SERVER['REQUEST_TIME'];
	}
	
	/**
	 * Returns the state of the session plus the session ID
	 * @return string
	 */
	public function getInfoSessionState(){
		$str =  __METHOD__ . ": Status=";
		//@formatter:off
		switch (session_status()) {
			case 0:		$str .= "`Disabled`. ";			break;
			case 1:		$str .= "`None`. ";				break;
			case 2:		$str .= "`Active`. ";			break;
		}
		//@formatter:on
		if ( !empty(session_id())) { $str .= "Id=`".session_id()."`. "; }
		
		return $str;
	}
	
	/**
	 * Updates the superglobal array $_SESSION with the attribute data.
	 */
	public function UpdatePhpSession(){
		$_SESSION = array_merge($_SESSION,$this->session);
	}
	
	/**
	 * Checks if the session (last saved state) is consistant with the actual server data. It does NOT check login and password. 
	 */
	public function CheckSession() {
		$cs = CommonSystem::getInstance();

		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "SessionManagement-CheckSession. \$_SESSION = " . $cs->StringFormatObj->arrayToString($_SESSION)));
		
		if ( isset($_SESSION['last_REMOTE_ADDR']) )	{ 
			if ($_SESSION['last_REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR']) { 
				$this->session['err'] = TRUE; $this->report['errMsg'] = "Not the same remote IP address";
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "SessionManagement-CheckSession : Not the same remote IP address"));
			} 
		}
		else { $_SESSION['last_REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];}
		
		$_SESSION['last_REMOTE_PORT'] = $_SERVER['REMOTE_PORT'];
		
		if ( isset($_SESSION['last_HTTP_USER_AGENT'])) { 
			if ($_SESSION['last_HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) { 
				$this->session['err'] = TRUE;
				$this->report['errMsg'] = "Not the same HTTP user agent";
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "SessionManagement-CheckSession : Not the same HTTP user agent"));
			}
		}
		else {$_SESSION['last_HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];}
		
		if (isset($_SESSION['last_REQUEST_TIME']))	{ 
			$this->session['SessionAge'] = ($_SERVER['REQUEST_TIME'] - $_SESSION['last_REQUEST_TIME']);
			if ($this->session['SessionAge'] > $this->session['SessionMaxAge']) { 
				$this->session['err'] = TRUE;
				$this->report['errMsg'] = "Session too old";
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "SessionManagement-CheckSession : Session is too old. SessionAge=".$this->session['SessionAge']." > SessionMaxAge=".$this->session['SessionMaxAge']));
			} 
		}
		else {$_SESSION['last_REQUEST_TIME'] = $_SERVER['REQUEST_TIME'];}
		
		// Any error leads to reset!
		if ($this->session['err'] === TRUE) { 
			$cs->LMObj = LogManagement::getInstance();
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "CheckSession : Session error"));
			$this->ResetSession();
			$this->UpdatePhpSession();
		}
		else {
		$this->session['sessionMode'] = 1;
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "CheckSession : Session seems ok. ws='" . $this->session['ws']."'"));
		
		}
	}

	/**
	 * Restart the session by cleaning up and restarting it.
	 */
	private function restartSession() {
		$CurrentSetObj = CurrentSet::getInstance();
		session_unset();
		session_destroy();
		session_write_close();
		session_name($CurrentSetObj->getDataEntry('sessionName'));
		setcookie(session_name(),'',0,'/');
		session_start();
		session_regenerate_id(true);
	}

	/**
	 * Reset the session
	 */
	public function ResetSession() {
		$cs = CommonSystem::getInstance();
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : ResetSession() has been called"));
		$this->restartSession();
		$this->session['user_login'] = "anonymous";
		$this->InitializeSession();
	}
	
	
	/**
	 * Depending on the selected mode, stores the user information in an array or the session
	 */
	public function StoreUserCredential() {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$mode = $CurrentSetObj->getDataSubEntry('autentification', 'mode');
		
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "StoreUserCredential mode=".$mode. ". Saving user into the session"));
		switch ($mode) {
			case "session" :
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "StoreUserCredentials : \$_SESSION['user_login']='" . $_SESSION['user_login']. "'")); 
				$this->session['user_login']		= $_SESSION['user_login'];
				$this->session['PasswordSha512']	= "";
				$this->session['ws']				= $_SESSION['ws'];
				
				break;
			case "form" :
				// We save directly the data into the session.
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Form content: " . $cs->StringFormatObj->arrayToString($cs->RequestDataObj->getRequestDataEntry('authentificationForm'))));
				$this->InitializeSession();
				$this->session['user_login']	=	$cs->RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login');
				$this->session['ws']			=	$cs->RequestDataObj->getRequestDataEntry('ws');
				$this->UpdatePhpSession();
				break;
		}
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "\$_SESSION is now : ". $cs->StringFormatObj->arrayToString($_SESSION)));
		
	}
	
	//@formatter:off
	
	public function getReport() {return $this->report;}
	public function getReportEntry($data) {return $this->report[$data];}
	
	public function getSession() {return $this->session;}
	public function getSessionEntry($data) {return $this->session[$data];}
	
	public function setSessionEntry($entry, $data) {
		$this->session[$entry] = $data;}
	
	public function setReport($report) {$this->report = $report;}
	public function setSession($session) {$this->session = $session;}
	
	//@formatter:on
	
}

?>