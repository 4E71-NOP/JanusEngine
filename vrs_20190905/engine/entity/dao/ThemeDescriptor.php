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
class ThemeDescriptor {
	private $ThemeDescriptor = array ();
	
	public function __construct() {}
	
	/**
	 * Gets theme descriptor data from the database.<br>
	 * @param integer $id
	 */
	//$UserObj, $WebSiteObj
	public function getThemeDescriptorDataFromDB($ThemeId) {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$q ="";
		$Dest = $ThemeId;
		if ( $Dest == "mt_" ) {
			if ( $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_pref_theme') != 0 ) { 
				$Dest = $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_pref_theme'); 	// By default the user theme is prefered
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Selecting user theme. Id=".$Dest ));
			}
			else { 
				$Dest = $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('theme_id'); // Problem with the prefered user theme
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Selecting website theme. Id=".$Dest ));
			}											
			// By default we use ID
			$q = "SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')." a , ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_website')." b
			WHERE a.theme_id = '".$Dest."'
			AND a.theme_id = b.theme_id
			AND b.theme_state = '1'
			;";
			
		}
		else { 
			// Case for displaying another theme to the user (browsing and choosing).
			// in this case we use names as this was eventually sent to a command line which only uses names. 
			$Dest = $cs->RequestDataObj->getRequestDataSubEntry('formParams1', 'pref_theme');
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Selecting theme for profile. Id=".$Dest ));
			$q = "SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')." a , ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_website')." b
			WHERE a.theme_name = '".$Dest."'
			AND a.theme_id = b.theme_id
			AND b.theme_state = '1'
			;";
		}
		
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for theme descriptor id=".$ThemeId .". \$q = `".$q."`"));
		$dbquery = $cs->SDDMObj->query ( $q );
		
		// --------------------------------------------------------------------------------------------
		//	Case when an admin goofs (murphy's law) even though an admin cannot goof.
		//	"Yo dawg i heard you like admin Ungoofing so i put an admin ungoof in yo admin ungoof..."
		// --------------------------------------------------------------------------------------------
		if ( $cs->SDDMObj->num_row_sql($dbquery) != 0 ) {
		}
		else {
			$dbquery = $cs->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')."
			WHERE theme_id = '2'
			;");
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for theme descriptor id=".$ThemeId.".Fallback on generic theme."));
		}
		while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->ThemeDescriptor [$A] = $B; }
		}
		$this->ThemeDescriptor['theme_date'] = date ("Y M d - H:i:s",$this->ThemeDescriptor['theme_date']);
	
		
	}

	//@formatter:off
	public function getThemeDescriptorEntry ($data) { return $this->ThemeDescriptor[$data]; }
	public function getThemeDescriptor() { return $this->ThemeDescriptor; }
	
	public function setThemeDescriptorEntry ($entry, $data) { 
		if ( isset($this->ThemeDescriptor[$entry])) { $this->ThemeDescriptor[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setThemeDescriptor($ThemeDescriptor) { $this->ThemeDescriptor = $ThemeDescriptor; }
	//@formatter:off

}


?>