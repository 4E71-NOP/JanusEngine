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

class ServerInfos {
	private $ServerInfos = array();
	
	public function __construct(){}
	
	public function getInfosFromServer () {
		$this->ServerInfos['srv_hostname']			= php_uname('s') . " " . php_uname('n') . " ". php_uname('m') . " / " . $this->get_real_ip();
		$this->ServerInfos['repertoire_courant']	= getcwd();
		$this->ServerInfos['include_path']			= get_include_path();
		$this->ServerInfos['uid']					= getmyuid();
		$this->ServerInfos['gid']					= getmygid();
		$this->ServerInfos['pid']					= getmypid();
		$this->ServerInfos['navigateur']			= getenv("HTTP_USER_AGENT");
		$this->ServerInfos['proprietaire']			= get_current_user();
		$this->ServerInfos['memory_limit']			= ini_get('memory_limit');
		$this->ServerInfos['display_errors']		= ini_get('display_errors');
		$this->ServerInfos['register_globals']		= ini_get('register_globals');
		$this->ServerInfos['post_max_size']			= ini_get('post_max_size');
		$this->ServerInfos['max_execution_time']	= ini_get('max_execution_time');
	}
	
	
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