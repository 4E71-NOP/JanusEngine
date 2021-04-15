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

class WebSite extends Entity{
	private $WebSite = array();
	
	//@formatter:off
	private $columns = array(
		'ws_id'				=> 0,
		'ws_name'			=> "New Website",
		'ws_short'			=> 0,
		'ws_lang'			=> 0,
		'ws_lang_select'	=> 0,
		'theme_id'			=> 0,
		'ws_title'			=> "New Website",
		'ws_home'			=> 0,
		'ws_directory'		=> 0,
		'ws_state'			=> 0,
		'ws_info_debug'		=> 0,
		'ws_stylesheet'		=> 0,
		'ws_gal_mode'		=> 0,
		'ws_gal_file_tag'	=> 0,
		'ws_gal_quality'	=> 0,
		'ws_gal_x'			=> 0,
		'ws_gal_y'			=> 0,
		'ws_gal_border'		=> 0,
		'ws_ma_diff'		=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->WebSite= $this->getDefaultValues();
	}
	
	/**
	 * Gets website data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the website selection to the website ID only.
	 * @param integer $id
	 */
	public function getWebSiteDataFromDB() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		if ( $bts->SMObj->getSessionEntry('ws') > 1 ){
			$dbquery = $bts->SDDMObj->query ( "
				SELECT * 
				FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('website') . " 
				WHERE ws_id = '" . $bts->SMObj->getSessionEntry('ws') . "'
				;" );
			if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for website id=".$bts->SMObj->getSessionEntry('ws')));
				while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
					foreach ( $dbp as $A => $B ) {
						if (isset($this->columns[$A])) { $this->WebSite[$A] = $B; }
					}
				}
			}
			else {
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for website id=".$bts->SMObj->getSessionEntry('ws')));
			}
			$_REQUEST['site_context']['ws_id'] = $this->WebSite['ws_id'] ;		// Dédiée aux routines de manipulation
		}
		else {
			echo ("Error : Website ID is NOT defined in the session.<br>Exiting.");
			exit(1);
		}
	}
	
	/**
	 * Change website context
	 * @param integer $id
	 */
	public function changeWebSiteContext( $id ) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query ( 
			"SELECT * 
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')." 
			WHERE ws_id = '" . $id. "'
			;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for website id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->WebSite[$A] = $B; }
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for website id=".$id));
		}
		
	}
	
	/**
	 * Updates or inserts in DB the local data.
	 * mode ar available: <br>
	 * <br>
	 * 0 = insert or update - Depending on the Id existing in DB or not, it'll be UPDATE or INSERT<br>
	 * 1 = insert only - Supposedly a new ID and not an existing one<br>
	 * 2 = update only - Supposedly an existing ID<br>
	 */
	public function sendToDB($mode = OBJECT_SENDTODB_MODE_DEFAULT){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->WebSite);
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
			
			$bts->SDDMObj->query("
			UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')." ws
			SET ".$QueryColumnDescription['equality']."
			WHERE ws.ws_id ='".$this->WebSite['ws_id']."'
			;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : website already exist in DB. Updating Id=".$this->WebSite['ws_id']));
		}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->WebSite);
			$bts->SDDMObj->query("
				INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')."
				(".$QueryColumnDescription['columns'].")
				VALUES
				(".$QueryColumnDescription['values'].")
				;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : website doesn't exist in DB. Inserting Id=".$this->WebSite['ws_id']));
		}
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = false;
		$dbquery = $bts->SDDMObj->query("
			SELECT ws.ws_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')." ws
			WHERE ws.ws_id ='".$this->WebSite['ws_id']."';
		");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 1 ) { $res = true; }
		return $res;
	}
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		
		$dbquery = $bts->SDDMObj->query("
			SELECT ws_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')."
			WHERE ws_id = ".$this->DocumentShare['ws_id']."
			LIMIT 1;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {$res = false; }
		
		
		return $res;
	}
	
	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$date = time ();
		$tab = $this->columns;
		$this->WebSite['ws_name'] .= "-".date("d_M_Y_H:i:s", time());
		
		return $tab;
	}
	
	/**
	 * Returns an array containing the list of states for this entity.
	 * Useful for menu select amongst other things.
	 * @return array()
	 */
	public function getMenuOptionArray () {
		$bts = BaseToolSet::getInstance();
		return array (
			'state' => array (
				0 => array( MenuOptionDb =>	 0,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('offline')),
				1 => array( MenuOptionDb =>	 1,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('online')),
				2 => array( MenuOptionDb =>	 2,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('disabled')),
			));
	}
	
	
	//@formatter:off
	public function getWebSiteEntry ($data) { return $this->WebSite[$data]; }
	public function getWebSite() { return $this->WebSite; }

	public function setWebSiteEntry ($entry, $data) { 
		if ( isset($this->WebSite[$entry])) { $this->WebSite[$entry] = $data; }	//DB Entity objects do NOT accept new columns!
	}
	public function setWebSite($WebSite) { $this->WebSite = $WebSite; }
	
	public function setInstallationInstance () {
		$this->WebSite = array (
			"ws_id" => "1",
			"ws_title" => "Hydr Installation",
			"ws_lang" => 38,
		);
		// 38 = Eng
	}
	//@formatter:on

}

?>