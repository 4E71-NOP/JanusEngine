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
	
	/**
	 * 
	 */
	public function SLMEmptyResult() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance ();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		
		$l = $WebSiteObj->getWebSiteEntry('ws_lang'); 
		
// 		if (strlen($l) == 0 ) { }		// failsafe on language selection. Back to the website default language.
		switch ($_REQUEST ['execution_context']) {
			case "admin_menu" :
			case "Admin_menu" :
			case "Extension_installation" :
			case "Rendu" :
			case "render" :
			default :
				$data = array();
				$data [3] = "WARN";
				$data [5] = $this->i18n_ [$l] ['err_no'];
				$data [6] = $this->i18n_ [$l] ['requete'];
// 				outil_debug( $data, "SddmTools i18n" );
				$bts->LMObj->logSQLMoreDetailsOnLast( $data );
				break;
		}
	}
	
	/**
	 * Returns 3 strings in an array that can be used in SET & UPDATE SQL queries. 
	 * Only the columns stated in the argument array will be processed.
	 * @param array $columns
	 * @param array $values
	 * @return array
	 */
	public function makeQueryColumnDescription ($columns, $values) {
		$tab = array(
			'equality' => '',
			'columns' => '',
			'values' => '',
		);
		foreach ($columns as $k => $v) {
// 			error_log($k .": (".strlen($values[$k]).") `".$values[$k]."`");
			if ( strlen($values[$k]) > 0 ) {
				$tab['equality'] .= $k. "='".$values[$k]."', ";
				$tab['columns'] .= $k. ", ";
				$tab['values'] .= "'".$values[$k]. "', ";
			}
		}
		$tab['equality'] = substr ($tab['equality'], 0,-2);
		$tab['columns'] = substr ($tab['columns'], 0,-2);
		$tab['values'] = substr ($tab['values'], 0,-2);
		return $tab;
	}
}
?>

