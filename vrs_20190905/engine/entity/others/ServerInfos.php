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

class ServerInfos {
	private $ServerInfos = array();
	
	public function __construct(){}
	
	public function getInfosFromServer () {
		$this->ServerInfos['srv_hostname']			= php_uname('s') . " " . php_uname('n') . " ". php_uname('m') . " / " . $this->get_real_ip();
		$this->ServerInfos['currentDirectory']		= getcwd();
		$this->ServerInfos['DOCUMENT_ROOT']			= $_SERVER['DOCUMENT_ROOT'];
		$this->ServerInfos['include_path']			= get_include_path();
		$this->ServerInfos['uid']					= getmyuid();
		$this->ServerInfos['gid']					= getmygid();
		$this->ServerInfos['pid']					= getmypid();
		$this->ServerInfos['browser']				= getenv("HTTP_USER_AGENT");
		$this->ServerInfos['serverOwner']			= get_current_user();
		$this->ServerInfos['memoryLimit']			= ini_get('memory_limit');
		$this->ServerInfos['display_errors']		= ini_get('display_errors');
		$this->ServerInfos['register_globals']		= ini_get('register_globals');
		$this->ServerInfos['post_max_size']			= ini_get('post_max_size');
		$this->ServerInfos['max_execution_time']	= ini_get('max_execution_time');

		$this->ServerInfos['current_dir']			= getcwd();
		$this->ServerInfos['owner']					= get_current_user();
		// $this->ServerInfos['browser']				= getenv("HTTP_USER_AGENT");
		$this->ServerInfos['srv_host']				= $_SERVER['HTTP_HOST'];
		$this->ServerInfos['sslState']				= 0;
		
		if ( isset($_SERVER['HTTPS']) ) {
			if ( isset($_SERVER['SERVER_PORT'] ) && ( $_SERVER['SERVER_PORT'] == '443' ) ) { $this->ServerInfos['sslState'] = 1; }
		}
		$this->ServerInfos['request_uri']			= "http".((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"s":"")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$this->ServerInfos['base_url']				= "http".(($this->ServerInfos['sslState']== 1 ) ? "s" : "")."://".$this->ServerInfos['srv_host']."/";
		
	
	}
	 /**
	  * Gets the server IP
	  */
	private function get_real_ip() {
		if (isset($_SERVER['HTTP_CLIENT_IP']))				{ return $_SERVER['HTTP_CLIENT_IP']; }
		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))	{ return $_SERVER['HTTP_X_FORWARDED_FOR']; }
		elseif (isset($_SERVER['HTTP_X_FORWARDED']))		{ return $_SERVER['HTTP_X_FORWARDED']; }
		elseif (isset($_SERVER['HTTP_FORWARDED_FOR']))		{ return $_SERVER['HTTP_FORWARDED_FOR']; }
		elseif (isset($_SERVER['HTTP_FORWARDED']))			{ return $_SERVER['HTTP_FORWARDED']; }
		else { return $_SERVER['REMOTE_ADDR']; }
	}
	
	//@formatter:off
	public function getServerInfos() { return $this->ServerInfos; }
	public function getServerInfosEntry($data) { return $this->ServerInfos[$data]; }

	public function setServerInfos($ServerInfos) { $this->ServerInfos = $ServerInfos; }
// 	public function setServerInfosEntry($entry , $data) { $this->ServerInfos[$entry] = $data; }
	//@formatter:on
	
	
}
?>