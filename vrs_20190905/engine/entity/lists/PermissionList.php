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

/**
 * This class is considered as an entity as it is responsible for hosting the necessary data for the layout
 * @author faust
 *
 */
class PermissionList {
    private static $Instance = null;
	private $PermissionList = array();
	
	public function __construct() {}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new PermissionList();
		}
		return self::$Instance;
	}
	/**
	 * Prepare list of permission.
	 */
	public function makePermissionList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$q = "SELECT * FROM "
			.$SqlTableListObj->getSQLTableName('permission')
            ." ORDER BY perm_name;";
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : PermissionList query `".$bts->StringFormatObj->formatToLog($q)."`."));
		$dbquery = $bts->SDDMObj->query($q);
		if ( $bts->SDDMObj->num_row_sql($dbquery) > 0 ) {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ( $dbp as $A => $B ) { $this->PermissionList[$dbp['perm_id']][$A] = $B; }
			}
			// $bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : PermissionList ". $bts->StringFormatObj->arrayToString($this->PermissionList)));
		}
		else { $bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : no SQL rows for permission list ")); }		
	}


    //@formatter:off
	public function getPermissionList() { return $this->PermissionList; }
	public function getPermissionListEntry($data) { return $this->PermissionList[$data]; }
	
	public function setPermissionList($data) { $this->PermissionList = $data; }
	public function setPermissionListEntry($entry , $data) { $this->PermissionList[$entry] = $data; }
	//@formatter:on


}
