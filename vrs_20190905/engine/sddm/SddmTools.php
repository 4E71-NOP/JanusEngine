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

class SddmTools {
	private static $Instance = null;

	public function __construct() {}

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
		switch ($bts->CMObj->getConfigurationEntry ( 'execution_context')) {
			case "admin_menu" :
			case "Admin_menu" :
			case "Extension_installation" :
			case "Rendu" :
			case "render" :
			default :
				$data = array();
				$data [3] = "WARN";
				$data [5] = $bts->I18nTransObj->getI18nTransEntry('SqlNoResultReturned1');
				$data [6] = $bts->I18nTransObj->getI18nTransEntry('SqlNoResultReturned2');
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

	/**
	 * makeQueryClause
	 * @param array $data
	 * @return string
	 */
	public function makeQueryClause($data){
		$bts = BaseToolSet::getInstance();
		$Content = "";
		$word = "WHERE";
		foreach( $data as $A ) {
			$Content .= " ".$word." ".$A['left']." ".$A['operator']." ".$A['right'];
			$word = "AND";
		}
		return ($Content);
	}

}
?>

