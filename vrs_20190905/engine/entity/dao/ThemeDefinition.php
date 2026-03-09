<?php
/* JanusEngine-license-start */
// --------------------------------------------------------------------------------------------
//
// Janus Engine - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* JanusEngine-license-end */
class ThemeDefinition extends Entity{
	private $ThemeDefinition = array ();

	//@formatter:off
	private $columns = array(
		'def_id'		=> 0,
		'fk_theme_id'	=> "",
		'def_type'		=> 1,
		'def_name'		=> "bg",
		'def_number'	=> 0,
		'def_string'	=> "bg.png",
	);
	//@formatter:on
	
	// public function __construct() {
	// 	$this->ThemeDefinition = $this->getDefaultValues();
	// }
		
	public function __construct($id, $type, $name, $number, $string) {
		$this->ThemeDefinition['fk_theme_id'] .= $id;
		$this->ThemeDefinition['def_type'] .= $type;
		$this->ThemeDefinition['def_name'] .= $name;
		$this->ThemeDefinition['def_number'] = $number;
		$this->ThemeDefinition['def_string'] = $string;
	}

	/**
	 * Gets article data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the article selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
		
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('theme_definition')."
			WHERE def_id = '".$id."'
			;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for article arti_id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { 
					if (isset($this->columns[$A])) { $this->ThemeDefinition[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for article arti_id=".$id));
			$res = false;
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	/**
	 * Updates or inserts in DB the local data.
	 * mode are available: <br>
	 * <br>
	 * 0 = insert or update - Depending on the Id existing in DB or not, it'll be UPDATE or INSERT<br>
	 * 1 = insert only - Supposedly a new ID and not an existing one<br>
	 * 2 = update only - Supposedly an existing ID<br>
	 */
	public function sendToDB($mode = OBJECT_SENDTODB_MODE_DEFAULT){
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		$genericActionArray = array(
			'columns'		=> $this->columns,
			'data'			=> $this->ThemeDefinition,
			'targetTable'	=> 'theme_definition',
			'targetColumn'	=> 'def_id',
			'entityId'		=> $this->ThemeDefinition['def_id'],
			'entityTitle'	=> 'theme_definition'
		);
		if ($this->existsInDB() === true && ($mode == OBJECT_SENDTODB_MODE_UPDATEONLY || $mode == OBJECT_SENDTODB_MODE_DEFAULT)) {
			$res = $this->genericUpdateDb($genericActionArray);
		} elseif ($this->existsInDB() === false && ($mode == OBJECT_SENDTODB_MODE_INSERTONLY || $mode == OBJECT_SENDTODB_MODE_DEFAULT)) {
			$res = $this->genericInsertInDb($genericActionArray);
		}

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->entityExistsInDb('theme_definition', $this->ThemeDefinition['def_id']);
	}

	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues () {
		$tab = $this->columns;
		$tab['def_type'] .= 0;
		$tab['def_number'] = 0;
		$tab['def_string'] = "N/A";
		return $tab;
	}

	//@formatter:off
	public function getDefType () { return $this->ThemeDefinition['def_type'];}
	public function getDefName () { return $this->ThemeDefinition['def_name'];}
	public function getDefNumber () { return $this->ThemeDefinition['def_number'];}
	public function getDefString () { return $this->ThemeDefinition['def_string'];}
	
	public function getThemeDefinition ($data) { return $this->ThemeDefinition[$data]; }
	public function setThemeDefinition ($entry, $data) { $this->ThemeDefinition[$entry] = $data; }
	//@formatter:on

	public function getValue() {
		switch ($this->ThemeDefinition['def_type']) {
			case 0:
				return $this->ThemeDefinition['def_number'];
				break;
			case 1:
				return $this->ThemeDefinition['def_string'];
				break;
			default:
				return false;
				break;
		}
	}

}