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
	
	private function __construct(ConfigurationManagement $data){
		$this->session = $_SESSION;
// 		foreach ( $_SESSION as $A => $B ) { $this->session[$A] = $B; }
		$this->session['SessionMaxAge'] = $data->getConfigurationEntry('SessionMaxAge');
		$this->session['err'] = FALSE;
	}

	public static function getInstance($data) {
		if (self::$Instance == null) {
			self::$Instance = new SessionManagement($data);
		}
		return self::$Instance;
	}
	
	/**
	 * Checks if the session (last saved state) is consistant with the actual server data. It does NOT check login and password. 
	 */
	public function CheckSession() {
		$cs = CommonSystem::getInstance();
		
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
		
		// A valid session holds a ws (website) number
		if (!isset($_SESSION['ws']) )	{ 
				$this->session['err'] = TRUE;
				$this->report['errMsg'] = "No site number in \$_SESSION['ws']";
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "SessionManagement-CheckSession : No site number in \$_SESSION['ws']"));
		}
		else { 
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "\$_SESSION['ws']=".$_SESSION['ws']));
			$this->session['ws'] = $_SESSION['ws'];
			$cs->RequestDataObj->setRequestDataEntry('ws', $_SESSION['ws'] );
		}
		
		// Any error leads to reset!
		if ($this->session['err'] === TRUE) { 
			$cs->LMObj = LogManagement::getInstance();
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "CheckSession : Session error"));
			$this->ResetSession();
		}
		else {
		$this->session['sessionMode'] = 1;
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "CheckSession : Session seems ok. ws='" . $this->session['ws']."'"));
		
		}
	}

	/**
	 * Restart the session by cleaning and restarting it.
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
				if ( strlen($_SESSION['user_login']) == 0 ) { $this->ResetSession(); }
				$this->session['user_login']		= $_SESSION['user_login'];
				$this->session['PasswordSha512']	= "";
				$this->session['ws']				= $_SESSION['ws'];
				
				break;
			case "form" :
				// We save directly the data into the session.
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Form content: " . $cs->StringFormatObj->arrayToString($cs->RequestDataObj->getRequestDataEntry('authentificationForm'))));
				$RequestDataObj = RequestData::getInstance();
				$_SESSION['user_login']		=	$this->session['user_login']	=	$RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login');
				$_SESSION['ws']				=	$this->session['ws']			=	$RequestDataObj->getRequestDataEntry('ws');
				// Hash512 Password was saved during development. Is removed as of 2020 09 15.
// 				$_SESSION['user_password']	=	$this->session['PasswordSha512']	=	hash("sha512",stripslashes($RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_password')));
				break;
		}
	}
	
	/**
	 * Reset the session
	 */
	public function ResetSession() {
		$cs = CommonSystem::getInstance();
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "ResetSession() has been called"));
		
		$this->session = array();
		$this->restartSession();

		$_SESSION['user_login']		= "anonymous";
// 		$_SESSION['user_password']	= hash("sha512",stripslashes("anonymous"));
		$_SESSION['ws']				= DEFAULT_SITE_ID;

		$this->session					= $_SESSION;
		$this->session['user_password']	= hash("sha512",stripslashes("anonymous"));
		$this->session['err']			= FALSE;				// in case it come from CheckSession()

	}
	
	//@formatter:off
	
	public function getReport() {return $this->report;}
	public function getReportEntry($data) {return $this->report[$data];}
	
	public function getSession() {return $this->session;}
	public function getSessionEntry($data) {return $this->session[$data];}
	
	public function setSessionEntry($entry, $data) {$this->session[$entry] = $data;}
	
	public function setReport($report) {$this->report = $report;}
	public function setSession($session) {$this->session = $session;}
	
	//@formatter:on
	
}

?>