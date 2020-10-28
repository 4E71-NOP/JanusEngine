<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */
class CommandForge {
	private static $Instance = null;
	
	private function __construct(){}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new CommandForge();
		}
		return self::$Instance;
	}
	
	public function forge($data) {
		$cs = CommonSystem::getInstance();
		$error = FALSE;
		if (strlen ( $data ['command'] ) == 0) { $error = TRUE; }
		if (strlen ( $data ['type'] ) == 0) { $error = TRUE; }
		if (strlen ( $data ['name'] ) == 0) { $error = TRUE; }

		if ($error == FALSE) {
			$RenderingCommandLine = $data ['command'] . " " . $data ['type'] . "name \"" . $data ['name'] . "\" ";
			foreach ( $data ['arguments'] as $A => $B ) {
				if (strlen ( $B ) > 0) {
					$RenderingCommandLine .= $A . " \"" . $B . "\" ";
				}
			}
			return $RenderingCommandLine;
		} else {
			$cs->LMObj = LogManagement::getInstance();
			//Logging 
		}
	}
}

?>