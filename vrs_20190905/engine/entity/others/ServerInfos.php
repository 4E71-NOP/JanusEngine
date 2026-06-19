<?php
// // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end

class ServerInfos
{
	private $ServerInfos = array();

	public function __construct() {}

	public function getInfosFromServer()
	{
		$hideInfo = _HIDE_SENSITIVE_SERVER_INFO_;

		$this->getIpAndMac();

		$this->ServerInfos['srvHostname']			= php_uname('s') . " " . php_uname('n') . " " . php_uname('m') . " / " . $this->getRealIp();
		$this->ServerInfos['srvIp']					= $this->getRealIp();

		$this->ServerInfos['currentDirectory']		= getcwd(); // Do not hide.
		$this->ServerInfos['DOCUMENT_ROOT']			= $_SERVER['DOCUMENT_ROOT'];
		$this->ServerInfos['includePath']			= get_include_path();
		$this->ServerInfos['uid']					= getmyuid();
		$this->ServerInfos['gid']					= getmygid();
		$this->ServerInfos['pid']					= getmypid();
		$this->ServerInfos['browser']				= getenv("HTTP_USER_AGENT");
		$this->ServerInfos['serverOwner']			= get_current_user();
		$this->ServerInfos['memoryLimit']			= ini_get('memory_limit');
		$this->ServerInfos['displayErrors']			= ini_get('display_errors');
		$this->ServerInfos['registerGlobals']		= ini_get('register_globals');
		$this->ServerInfos['postMaxSize']			= ini_get('post_max_size');
		$this->ServerInfos['maxExecutionTime']		= ini_get('max_execution_time');
		$this->ServerInfos['phpVersion']			= phpversion();;

		$this->ServerInfos['owner']					= get_current_user();
		$this->ServerInfos['browser']				= getenv("HTTP_USER_AGENT");
		$this->ServerInfos['srvHost']				= $_SERVER['HTTP_HOST'];
		$this->ServerInfos['sslState']				= 0;

		if (isset($_SERVER['HTTPS'])) {
			if (isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] == '443')) {
				$this->ServerInfos['sslState'] = 1;
			}
		}
		$this->ServerInfos['requestUri']			= "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$this->ServerInfos['baseUrl']				= "http" . (($this->ServerInfos['sslState'] == 1) ? "s" : "") . "://" . $this->ServerInfos['srvHost'] . "/";
	}
	/**
	 * Gets the server IP
	 */
	private function getRealIp()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
			return $_SERVER['HTTP_X_FORWARDED'];
		} elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_FORWARDED'])) {
			return $_SERVER['HTTP_FORWARDED'];
		} else {
			return $_SERVER['REMOTE_ADDR'];
		}
	}

	private function getIpAndMac()
	{
		$bts = BaseToolSet::getInstance();
		if (@exec('echo EXEC') == 'EXEC') {
			$str = strtolower(PHP_OS);
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "PHP_OS =" . $str));
			$cmd = array();

			//@formatter:off
			if (strpos($str, 'win') !== false) { 
				$cmd[] = "getmac -v"; 
				$cmd[] = "ipconfig"; 
			}
			if (strpos($str, 'linux') !== false ) { 
				$cmd[] = "echo 'IPs'; awk '/\|--/ && !/\.0$|\.255$/ {print $2}' /proc/net/fib_trie;"; 
				$cmd[] = "echo 'MACs'; cat /sys/class/net/*/address;";
				$cmd[] = "echo 'Hostname'; hostname -A; hostname -I;"; 
			}
			if (strpos($str, 'freebsd') !== false ) { 
				$cmd[] = "echo 'IPs'; awk '/\|--/ && !/\.0$|\.255$/ {print $2}' /proc/net/fib_trie;"; 
				$cmd[] = "echo 'MACs'; cat /sys/class/net/*/address;";
				$cmd[] = "echo 'Hostname'; hostname -A; hostname -I;"; 
			}
			if (strpos($str, 'mac') !== false ) { 
				$cmd[] = "networksetup -listallhardwareports"; 
			}
			//@formatter:on

			// $bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "cmd =" . $cmd));
			if (!empty($cmd)) {
				$this->ServerInfos['execIfInfos'] = array();
				foreach ($cmd as $A) {
					$output = null;
					$result_code = null;
					exec($A, $output, $result_code);
					$this->ServerInfos['execIfInfos'] = array_merge($this->ServerInfos['execIfInfos'], $output);
				}
				// $bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "output =" . $bts->StringFormatObj->print_r_debug($output)));
			} else {
				$this->ServerInfos['execIfInfos'] = "***FAIL***";
			}
		} else {
			$this->ServerInfos['execIfInfos'] = "exec() not available";
		}
	}

	//@formatter:off
	public function getServerInfos() { return $this->ServerInfos; }
	public function getServerInfosEntry($data) { return $this->ServerInfos[$data]; }

	public function setServerInfos($ServerInfos) { $this->ServerInfos = $ServerInfos; }
	// 	public function setServerInfosEntry($entry , $data) { $this->ServerInfos[$entry] = $data; }
	//@formatter:on


}
