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
/**
 * this class is base on the model in the database. Made to recover some information in the database.
 * @author faust
 *
 */
class Installation extends Entity{
	private $Installation = array ();

	private $columns = array(
		'inst_id'		=> 0,
		'inst_display'	=> 1,
		'inst_name'		=> "new theme definition",
		'inst_nbr'		=> 0,
		'inst_txt'		=> "new theme definition",
	);
	public function __construct() {
	}

	/**
	 * Gets group data from the database.<br>
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName ('installation') . "
			WHERE inst_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for installation id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Installation[$A] = $B; }
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for installation id=".$id));
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
			'data'			=> $this->Installation,
			'targetTable'	=> 'installation',
			'targetColumn'	=> 'inst_id',
			'entityId'		=> $this->Installation['inst_id'],
			'entityTitle'	=> 'installation'
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
		return $this->entityExistsInDb('installation', $this->Installation['inst_id']);
	}

	//@formatter:off
	public function getInstallationEntry ($data) { return $this->Installation[$data]; }
	public function getInstallation() { return $this->Installation; }
	
	public function setInstallationEntry ($entry, $data) { 
		if ( isset($this->Installation[$entry])) { $this->Installation[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setInstallation($Installation) { $this->Installation = $Installation; }
	//@formatter:off

}


?>