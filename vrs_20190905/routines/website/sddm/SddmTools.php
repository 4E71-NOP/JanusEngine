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

class SddmTools {
	private static $Instance = null;
	
	private $i18n_ = array (
		"38" => array (
			"err_no" => "Empty result",
			"requete" => "No result for this query."
		),
		"48" => array (
			"err_no" => "Aucune ligne retourn&eacute;e",
			"requete" => "Aucune ligne retourn&eacute;e pour cette requete."
		)
	);

	public function __construct() {
	}
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new SddmTools();
		}
		return self::$Instance;
	}
	
	public function SLMEmptyResult() {
		global $l, $WebSiteObj;
		
		$LMObj = LogManagement::getInstance();
		
		if (strlen($l) == 0 ) { $l = $WebSiteObj->getWebSiteEntry('sw_lang'); }		// failsafe on language selection. Back to the website default language.
		switch ($_REQUEST ['contexte_d_execution']) {
			case "admin_menu" :
			case "Admin_menu" :
			case "Extension_installation" :
			case "Rendu" :
			default :
				$data = array();
				$data [3] = "WARN";
				$data [5] = $this->i18n_ [$l] ['err_no'];
				$data [6] = $this->i18n_ [$l] ['requete'];
// 				outil_debug( $data, "SddmTools i18n" );
				$LMObj->logSQLMoreDetailsOnLast( $data );
				break;
		}
	}

}
?>

