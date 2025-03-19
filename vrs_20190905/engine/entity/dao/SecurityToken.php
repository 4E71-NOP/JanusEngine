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
class SecurityToken extends Entity
{
	private $SecurityToken = array();
	
	//@formatter:off
	private $columns = array(
		"st_id"			=> 0,
		"st_creation"	=> 0,
		"st_action"		=> "",
		"st_login"		=> "",
		"st_email"		=> "",
		"st_content"	=> "",
	);
	//@formatter:on

	public function __construct()
	{
		$this->SecurityToken = $this->getDefaultValues();
		$this->SecurityToken['st_creation'] = time();
	}

	/**
	 * Gets SecurityToken data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the SecurityToken selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('security_token') . "
			WHERE st_id = '" . $id . "'
			;");
		if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for security_token st_id=" . $id));
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ($dbp as $A => $B) {
					if (isset($this->columns[$A])) {
						$this->SecurityToken[$A] = $B;
					}
				}
			}
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for security_token st_id=" . $id));
			$res = false;
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}


	/**
	 * Gets SecurityToken data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the SecurityToken selection to the website ID only.
	 * @param integer $content
	 */
	public function getDataFromDBbyToken($content)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('security_token') . "
			WHERE st_content = '" . $content . "'
			;");
		if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for security_token st_content=" . $content));
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ($dbp as $A => $B) {
					if (isset($this->columns[$A])) {
						$this->SecurityToken[$A] = $B;
					}
				}
			}
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for security_token st_content=" . $content));
			$res = false;
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
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
	public function sendToDB($mode = OBJECT_SENDTODB_MODE_DEFAULT)
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		$genericActionArray = array(
			'columns'		=> $this->columns,
			'data'			=> $this->SecurityToken,
			'targetTable'	=> 'security_token',
			'targetColumn'	=> 'st_id',
			'entityId'		=> $this->SecurityToken['st_id'],
			'entityTitle'	=> 'security_token'
		);
		if ($this->existsInDB() === true && ($mode == OBJECT_SENDTODB_MODE_UPDATEONLY || $mode == OBJECT_SENDTODB_MODE_DEFAULT)) {
			$res = $this->genericUpdateDb($genericActionArray);
		} elseif ($this->existsInDB() === false && ($mode == OBJECT_SENDTODB_MODE_INSERTONLY || $mode == OBJECT_SENDTODB_MODE_DEFAULT)) {
			$res = $this->genericInsertInDb($genericActionArray);
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}

	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB()
	{
		return $this->entityExistsInDb('security_token', $this->SecurityToken['st_id']);
	}

	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency()
	{
		$res = true;
		if (strlen($this->SecurityToken['st_content'] ?? '') == 0) {
			$res = false;
		}
		return $res;
	}


	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues()
	{
		$tab = $this->columns;
		return $tab;
	}


	/**
	 * Create the token
	 */
	public function createTokenContent()
	{
		$this->SecurityToken['st_content'] = bin2hex(random_bytes(512));
	}


	/**
	 * Check expiration of the token 
	 */
	public function isTokenExpired($delay) {
		return ($this->SecurityToken['st_creation'] < (time() - ($delay * 60)));
	}

	/**
	 * Returns an array containing the list of states for this entity.
	 * Useful for menu select amongst other things.
	 * @return array()
	 */
	public function getMenuOptionArray() {}
	
	//@formatter:off
	public function getSecurityTokenEntry ($data) { return $this->SecurityToken[$data]; }
	public function getSecurityToken() { return $this->SecurityToken; }
	
	public function setSecurityTokenEntry ($entry, $data) { 
		if ( isset($this->SecurityToken[$entry])) { $this->SecurityToken[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}
	public function setSecurityToken($SecurityToken) { $this->SecurityToken = $SecurityToken; }
	//@formatter:off
}
?>