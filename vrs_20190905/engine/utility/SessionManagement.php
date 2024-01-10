<?php
/*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
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
		if ( !empty($_SESSION)) {
			$this->session = array_merge($this->session, $_SESSION);
		}
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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite
		if ( strlen($currentWs ?? '') == 0 ) {
			$currentWs = DEFAULT_SITE_ID;
		}

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : InitializeSession has been called"));
		
		$sessionArray = &$this->session[$currentWs];
		
		$sessionArray['ws']						= DEFAULT_SITE_ID;
		$sessionArray['SessionMaxAge']			= $bts->CMObj->getConfigurationEntry('SessionMaxAge');
		$sessionArray['user_login']				= "anonymous";
		$sessionArray['err']					= false;
		$sessionArray['last_REMOTE_ADDR']		= $_SERVER['REMOTE_ADDR'];
		$sessionArray['last_REMOTE_PORT']		= $_SERVER['REMOTE_PORT'];
		$sessionArray['last_HTTP_USER_AGENT']	= $_SERVER['HTTP_USER_AGENT'];
		$sessionArray['last_REQUEST_TIME']		= $_SERVER['REQUEST_TIME'];
		$sessionArray['currentRoute']			= array("target" => "home", "page" => 1);
		$sessionArray['previousRoute']			= array("target" => "home", "page" => 1);
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
	 * Checks if the session (last saved state) is consistant with the actual server data. It does NOT check login and password. 
	 */
	public function CheckSession() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : \$_SESSION = " . $bts->StringFormatObj->arrayToString($_SESSION)));
		
		if ( isset($_SESSION[$currentWs]['last_REMOTE_ADDR']) )	{ 
			if ($_SESSION[$currentWs]['last_REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR']) { 
				$this->session[$currentWs]['err'] = TRUE; $this->report['errMsg'] = "Not the same remote IP address";
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Not the same remote IP address"));
			} 
		}
		else { $_SESSION[$currentWs]['last_REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];}
		
		$_SESSION[$currentWs]['last_REMOTE_PORT'] = $_SERVER['REMOTE_PORT'];
		
		if ( isset($_SESSION[$currentWs]['last_HTTP_USER_AGENT'])) { 
			if ($_SESSION[$currentWs]['last_HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) { 
				$this->session[$currentWs]['err'] = TRUE;
				$this->report['errMsg'] = "Not the same HTTP user agent";
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Not the same HTTP user agent"));
			}
		}
		else {$_SESSION[$currentWs]['last_HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];}
		
		if (isset($_SESSION[$currentWs]['last_REQUEST_TIME']))	{ 
			$this->session[$currentWs]['SessionAge'] = ($_SERVER['REQUEST_TIME'] - $_SESSION[$currentWs]['last_REQUEST_TIME']);
			if ($this->session[$currentWs]['SessionAge'] > $this->session[$currentWs]['SessionMaxAge']) { 
				$this->session[$currentWs]['err'] = TRUE;
				$this->report['errMsg'] = "Session too old";
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Session is too old. SessionAge=".$this->session['SessionAge']." > SessionMaxAge=".$this->session['SessionMaxAge']));
			} 
		}
		else {$_SESSION[$currentWs]['last_REQUEST_TIME'] = $_SERVER['REQUEST_TIME'];}
		
		// Any error leads to reset!
		if ($this->session[$currentWs]['err'] === TRUE) { 
			$bts->LMObj = LogManagement::getInstance();
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Session error"));
			$this->ResetSession();
			$this->syncSuperGlobalSession();
		}
		else {
		$this->session[$currentWs]['sessionMode'] = 1;
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Session seems ok. ws='" . $this->session[$currentWs]['ws']."'"));
		
		}
	}

	/**
	 * Restart the session by cleaning up and restarting it.
	 */
	private function restartSession() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite

		// session_unset();
		// session_destroy();
		// session_write_close();
		// session_name($CurrentSetObj->getDataEntry('sessionName'));
		// setcookie(session_name(),'',0,'/');
		// session_start();
		// session_regenerate_id(true);

		// light cleaning
		$this->session[$currentWs] = array();
		$this->syncSuperGlobalSession();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => $bts->SMObj->getInfoSessionState()));

	}

	/**
	 * Reset the session
	 */
	public function ResetSession() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : ResetSession() has been called"));
		$this->restartSession();
		// $this->session[$currentWs]['user_login'] = "anonymous";
		$this->InitializeSession();
	}
	
	
	/**
	 * Depending on the selected mode, stores the user information in an array or the session
	 */
	public function StoreUserCredential() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite
		$mode = $CurrentSetObj->getDataSubEntry('autentification', 'mode');
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "StoreUserCredential mode=".$mode. ". Saving user into the session"));
		switch ($mode) {
			case "session" :
// 				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "StoreUserCredentials : \$_SESSION['user_login']='" . $_SESSION['user_login']. "'")); 
// 				$this->session['user_login']		= $_SESSION['user_login'];
// 				$this->session['PasswordSha512']	= "";
// 				$this->session['ws']				= $_SESSION['ws'];
				
				$this->syncClassSession();
				break;
			case "form" :
				// We save directly the data into the session.
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "Form content: " . $bts->StringFormatObj->arrayToString($bts->RequestDataObj->getRequestDataEntry('authentificationForm'))));
				$this->InitializeSession();
				$this->session[$currentWs]['user_login']	=	$bts->RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login');
// 				$this->session['ws']			=	$bts->RequestDataObj->getRequestDataEntry('ws');
				$this->syncSuperGlobalSession();
				break;
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : \$_SESSION is now : ". $bts->StringFormatObj->arrayToString($_SESSION)));
		
	}
	
	/**
	 * Backup the current route information. 
	 * We assume we have a superglobal $_SESSION enabled and valid
	 */
	public function backupRoute () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Backing up the last route"));
		$this->session[$currentWs]['previousRoute'] = $this->session[$currentWs]['currentRoute'];
		$this->session[$currentWs]['currentRoute'] = array();
		$this->syncSuperGlobalSession();
	}
	
	/**
	 * Sync data from $_SESSION to local class attribute
	 */
	public function syncClassSession () {
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Syncing local attribute data using \$_SESSION"));
		$this->session = array_merge($this->session, $_SESSION);
	}
	
	/**
	 * Updates the superglobal array $_SESSION with the class attribute data.
	 */
	public function syncSuperGlobalSession(){
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Syncing \$_SESSION using local attribute data"));
		$_SESSION = array_merge($_SESSION,$this->session);
	}
	
	//@formatter:off
	
	public function getReport() {return $this->report;}
	public function getReportEntry($data) {return $this->report[$data];}
	
	public function getSession() {return $this->session;}
	public function getSessionEntry($data) {return $this->session[$data];}
	public function getSessionSubEntry($lvl1, $lvl2) { return $this->session[$lvl1][$lvl2]; }
	public function getSession3rdLvlEntry($lvl1, $lvl2, $lvl3) { return $this->session[$lvl1][$lvl2][$lvl3]; }
	
	public function setSessionEntry($entry, $data) {$this->session[$entry] = $data;}
	public function setSessionSubEntry($lvl1, $lvl2, $data) { $this->session[$lvl1][$lvl2] = $data; }
	public function setSession3rdLvlEntry($lvl1, $lvl2, $lvl3, $data) { $this->session[$lvl1][$lvl2][$lvl3] = $data; }
	
	public function setReport($report) {$this->report = $report;}
	public function setSession($session) {$this->session = $session;}
	
	//@formatter:on
	
}

?>