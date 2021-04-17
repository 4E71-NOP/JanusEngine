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
class ThemeDescriptor extends Entity{
	private $ThemeDescriptor = array ();
	
	//@formatter:off
	private $columns = array(
		'theme_id'						=> 0,
		'theme_directory'				=> 0,
		'theme_name'					=> "New theme",
		'theme_title'					=> 0,
		'theme_desc'					=> 0,
		'theme_date'					=> 0,
		'theme_stylesheet_1'			=> 0,
		'theme_stylesheet_2'			=> 0,
		'theme_stylesheet_3'			=> 0,
		'theme_stylesheet_4'			=> 0,
		'theme_stylesheet_5'			=> 0,
		'theme_bg'						=> 0,
		'theme_bg_repeat'				=> 0,
		'theme_bg_color'				=> 0,
		'theme_logo'					=> 0,
		'theme_banner'					=> 0,
		'theme_divinitial_bg'			=> 0,
		'theme_divinitial_repeat'		=> 0,
		'theme_divinitial_dx'			=> 0,
		'theme_divinitial_dy'			=> 0,
		'theme_block_01_name'			=> 0,
		'theme_block_01_text'			=> 0,
		'theme_block_02_name'			=> 0,
		'theme_block_02_text'			=> 0,
		'theme_block_03_name'			=> 0,
		'theme_block_03_text'			=> 0,
		'theme_block_04_name'			=> 0,
		'theme_block_04_text'			=> 0,
		'theme_block_05_name'			=> 0,
		'theme_block_05_text'			=> 0,
		'theme_block_06_name'			=> 0,
		'theme_block_06_text'			=> 0,
		'theme_block_07_name'			=> 0,
		'theme_block_07_text'			=> 0,
		'theme_block_08_name'			=> 0,
		'theme_block_08_text'			=> 0,
		'theme_block_09_name'			=> 0,
		'theme_block_09_text'			=> 0,
		'theme_block_10_name'			=> 0,
		'theme_block_10_text'			=> 0,
		'theme_block_11_name'			=> 0,
		'theme_block_11_text'			=> 0,
		'theme_block_12_name'			=> 0,
		'theme_block_12_text'			=> 0,
		'theme_block_13_name'			=> 0,
		'theme_block_13_text'			=> 0,
		'theme_block_14_name'			=> 0,
		'theme_block_14_text'			=> 0,
		'theme_block_15_name'			=> 0,
		'theme_block_15_text'			=> 0,
		'theme_block_16_name'			=> 0,
		'theme_block_16_text'			=> 0,
		'theme_block_17_name'			=> 0,
		'theme_block_17_text'			=> 0,
		'theme_block_18_name'			=> 0,
		'theme_block_18_text'			=> 0,
		'theme_block_19_name'			=> 0,
		'theme_block_19_text'			=> 0,
		'theme_block_20_name'			=> 0,
		'theme_block_20_text'			=> 0,
		'theme_block_21_name'			=> 0,
		'theme_block_21_text'			=> 0,
		'theme_block_22_name'			=> 0,
		'theme_block_22_text'			=> 0,
		'theme_block_23_name'			=> 0,
		'theme_block_23_text'			=> 0,
		'theme_block_24_name'			=> 0,
		'theme_block_24_text'			=> 0,
		'theme_block_25_name'			=> 0,
		'theme_block_25_text'			=> 0,
		'theme_block_26_name'			=> 0,
		'theme_block_26_text'			=> 0,
		'theme_block_27_name'			=> 0,
		'theme_block_27_text'			=> 0,
		'theme_block_28_name'			=> 0,
		'theme_block_28_text'			=> 0,
		'theme_block_29_name'			=> 0,
		'theme_block_29_text'			=> 0,
		'theme_block_30_name'			=> 0,
		'theme_block_30_text'			=> 0,
		'theme_block_00_menu'			=> 0,
		'theme_block_01_menu'			=> 0,
		'theme_block_02_menu'			=> 0,
		'theme_block_03_menu'			=> 0,
		'theme_block_04_menu'			=> 0,
		'theme_block_05_menu'			=> 0,
		'theme_block_06_menu'			=> 0,
		'theme_block_07_menu'			=> 0,
		'theme_block_08_menu'			=> 0,
		'theme_block_09_menu'			=> 0,
		'theme_admctrl_panel_bg'		=> 0,
		'theme_admctrl_switch_bg'		=> 0,
		'theme_admctrl_width'			=> 0,
		'theme_admctrl_height'			=> 0,
		'theme_admctrl_position'		=> 0,
		'theme_gradient_start_color'	=> 0,
		'theme_gradient_middle_color'	=> 0,
		'theme_gradient_end_color'		=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->ThemeDescriptor= $this->getDefaultValues();
	}
	
	/**
	 * Gets theme descriptor data from the database.<br>
	 * @param integer $id
	 */
	//$UserObj, $WebSiteObj
	public function getDataFromDB($ThemeId) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$q ="";
		$Dest = $ThemeId;
		// mt_ as Main Theme
		if ( $Dest == "mt_" ) {
			if ( $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_pref_theme') != 0 ) { 
				$Dest = $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_pref_theme'); 	// By default the user theme is prefered
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Selecting user theme. Id=".$Dest ));
			}
			else { 
				$Dest = $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('theme_id'); // Problem with the prefered user theme
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Selecting website theme. Id=".$Dest ));
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
			$Dest = $bts->RequestDataObj->getRequestDataSubEntry('formParams1', 'pref_theme');
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Selecting theme for profile. Id=".$Dest ));
			$q = "SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')." a , ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_website')." b
			WHERE a.theme_name = '".$Dest."'
			AND a.theme_id = b.theme_id
			AND b.theme_state = '1'
			;";
		}
		
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for theme descriptor id=".$ThemeId .". \$q = `".$q."`"));
		$dbquery = $bts->SDDMObj->query ( $q );
		
		// --------------------------------------------------------------------------------------------
		//	Case when an admin goofs (murphy's law) even though an admin cannot goof.
		//	"Yo dawg i heard you like admin Ungoofing so i put an admin ungoof in yo admin ungoof..."
		// --------------------------------------------------------------------------------------------
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
		}
		else {
			$dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')."
			WHERE theme_id = '2'
			;");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for theme descriptor id=".$ThemeId.".Fallback on generic theme."));
		}
		while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) {
				if (isset($this->columns[$A])) { $this->ThemeDescriptor[$A] = $B; }
			}
		}
		// $this->ThemeDescriptor['theme_date'] = date ("Y M d - H:i:s",$this->ThemeDescriptor['theme_date']);
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
		
		$genericActionArray = array(
			'columns'		=> $this->columns,
			'data'			=> $this->ThemeDescriptor,
			'targetTable'	=> 'theme_descriptor',
			'targetColumn'	=> 'theme_id',
			'entityId'		=> $this->ThemeDescriptor['theme_id'],
			'entityTitle'	=> 'ThemeDescriptor'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $this->genericInsertInDb($genericActionArray); }
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		$this->themeDescriptorExists($this->ThemeDescriptor['theme_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		
		
		return $res;
	}
	
	
	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues () {
		$tab = $this->columns;
		$this->ThemeDescriptor['theme_name'] .= "-".date("d_M_Y_H:i:s", time());
		$this->ThemeDescriptor['theme_date'] = time();
		
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
				0 => array( MenuOptionDb =>	 0,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( MenuOptionDb =>	 1,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( MenuOptionDb =>	 2,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			));
	}
	
	//@formatter:off
	public function getThemeDescriptorEntry ($data) { return $this->ThemeDescriptor[$data]; }
	public function getThemeDescriptor() { return $this->ThemeDescriptor; }
	
	public function setThemeDescriptorEntry ($entry, $data) { 
		if ( isset($this->ThemeDescriptor[$entry])) { $this->ThemeDescriptor[$entry] = $data; }	// DB Entity objects do NOT accept new columns!  
	}

	public function setThemeDescriptor($ThemeDescriptor) { $this->ThemeDescriptor = $ThemeDescriptor; }
	//@formatter:off

}


?>