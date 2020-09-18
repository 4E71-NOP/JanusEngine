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
	public function getThemeDescriptorDataFromDB($ThemeId, $UserObj, $WebSiteObj) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$RequestDataObj = RequestData::getInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		$Dest = $ThemeId;

		$LMObj = LogManagement::getInstance();
		
		if ( $Dest == "mt_" ) {
			if ( $UserObj->getUserEntry('pref_theme') != 0 ) { $Dest = $UserObj->getUserEntry('pref_theme'); }	// By default the user theme is prefered
			else { $Dest = $WebSiteObj->getWebSiteEntry('theme_id'); }											// Problem with the prefered user theme
		}
		else { $Dest = $RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'SelectedThemeId'); }			// Case for displaying another theme to the user (browsing and choosing).
		
		$dbquery = $SDDMObj->query ( "
			SELECT * 
			FROM " . $SqlTableListObj->getSQLTableName('theme_descriptor')." a , ".$SqlTableListObj->getSQLTableName('site_theme')." b
			WHERE a.theme_id = '".$Dest."'
			AND a.theme_id = b.theme_id
			AND b.theme_state = '1'
			;" );
		
		// --------------------------------------------------------------------------------------------
		//	Case when an admin goofs (murphy's law) even though an admin cannot goof.
		//	"Yo dawg i heard you like admin Ungoofing so i put an admin ungoof in yo admin ungoof..."
		// --------------------------------------------------------------------------------------------
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog(__METHOD__ . " : Loading data for theme descriptor id=".$ThemeId);
		}
		else {
			$dbquery = $SDDMObj->query("
			SELECT *
			FROM ".$SqlTableListObj->getSQLTableName('theme_descriptor')."
			WHERE theme_id = 2
			;");
			$LMObj->InternalLog(__METHOD__ . " : No rows returned for theme descriptor id=".$ThemeId.".Fallback on generic theme.");
		}
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
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