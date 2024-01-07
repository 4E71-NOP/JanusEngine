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
	private $ThemeDefinition = array ();
	private $CssPrefix = "";
	
	//@formatter:off
	private $columns = array(
		'theme_id'						=> 0,
		'theme_name'					=> "New theme",
		'theme_title'					=> 0,
		'theme_desc'					=> 0,
		'theme_date'					=> 0,
		);

	private $themeDefinitionList = array(
		'directory'				=> 0,
		'stylesheet_1'			=> 0,
		'stylesheet_2'			=> 0,
		'stylesheet_3'			=> 0,
		'stylesheet_4'			=> 0,
		'stylesheet_5'			=> 0,
		'width'					=> 0,
		'height'					=> 0,
		'max_width'				=> 0,
		'max_height'				=> 0,
		'min_width'				=> 0,
		'min_height'				=> 0,
		'bg'						=> 0,
		'bg_position'				=> 0,
		'bg_repeat'				=> 0,
		'bg_color'				=> 0,
		'logo'					=> 0,
		'divinitial_bg'			=> 0,
		'divinitial_repeat'		=> 0,
		'divinitial_dx'			=> 0,
		'divinitial_dy'			=> 0,
		'block_01_name'			=> 0,
		'block_01_text'			=> 0,
		'block_02_name'			=> 0,
		'block_02_text'			=> 0,
		'block_03_name'			=> 0,
		'block_03_text'			=> 0,
		'block_04_name'			=> 0,
		'block_04_text'			=> 0,
		'block_05_name'			=> 0,
		'block_05_text'			=> 0,
		'block_06_name'			=> 0,
		'block_06_text'			=> 0,
		'block_07_name'			=> 0,
		'block_07_text'			=> 0,
		'block_08_name'			=> 0,
		'block_08_text'			=> 0,
		'block_09_name'			=> 0,
		'block_09_text'			=> 0,
		'block_10_name'			=> 0,
		'block_10_text'			=> 0,
		'block_11_name'			=> 0,
		'block_11_text'			=> 0,
		'block_12_name'			=> 0,
		'block_12_text'			=> 0,
		'block_13_name'			=> 0,
		'block_13_text'			=> 0,
		'block_14_name'			=> 0,
		'block_14_text'			=> 0,
		'block_15_name'			=> 0,
		'block_15_text'			=> 0,
		'block_16_name'			=> 0,
		'block_16_text'			=> 0,
		'block_17_name'			=> 0,
		'block_17_text'			=> 0,
		'block_18_name'			=> 0,
		'block_18_text'			=> 0,
		'block_19_name'			=> 0,
		'block_19_text'			=> 0,
		'block_20_name'			=> 0,
		'block_20_text'			=> 0,
		'block_21_name'			=> 0,
		'block_21_text'			=> 0,
		'block_22_name'			=> 0,
		'block_22_text'			=> 0,
		'block_23_name'			=> 0,
		'block_23_text'			=> 0,
		'block_24_name'			=> 0,
		'block_24_text'			=> 0,
		'block_25_name'			=> 0,
		'block_25_text'			=> 0,
		'block_26_name'			=> 0,
		'block_26_text'			=> 0,
		'block_27_name'			=> 0,
		'block_27_text'			=> 0,
		'block_28_name'			=> 0,
		'block_28_text'			=> 0,
		'block_29_name'			=> 0,
		'block_29_text'			=> 0,
		'block_30_name'			=> 0,
		'block_30_text'			=> 0,
		'block_00_menu'			=> 0,
		'block_01_menu'			=> 0,
		'block_02_menu'			=> 0,
		'block_03_menu'			=> 0,
		'block_04_menu'			=> 0,
		'block_05_menu'			=> 0,
		'block_06_menu'			=> 0,
		'block_07_menu'			=> 0,
		'block_08_menu'			=> 0,
		'block_09_menu'			=> 0,
		'admctrl_panel_bg'		=> 0,
		'admctrl_switch_bg'		=> 0,
		'admctrl_width'			=> 0,
		'admctrl_height'			=> 0,
		'admctrl_position'		=> 0,
		'gradient_start_color'	=> 0,
		'gradient_middle_color'	=> 0,
		'gradient_end_color'		=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->ThemeDescriptor= $this->getDefaultValues();
	}
	
	/**
	 * Gets theme descriptor data from the database.<br>
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$q = "
		SELECT * FROM " 
		.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')." td , "
		.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_website')." tw
		WHERE td.theme_id = '".$id."'
		AND td.theme_id = tw.fk_theme_id
		AND tw.theme_state = '1'
		;";

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading header for theme ".$id .". \$q = `".$bts->StringFormatObj->formatToLog($q)."`"));
		$dbquery = $bts->SDDMObj->query ( $q );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) {
				if (isset($this->columns[$A])) { $this->ThemeDescriptor[$A] = $B; }
				}
			}
			$this->loadThemeData($id);
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for theme descriptor id=".$id));
			$res = false;
		}

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	/**
	 * Gets theme data from the database.<br>
	 * 
	 */
	private function loadThemeData($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$q = "
		SELECT * FROM " 
		.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_definition')." td "
		."WHERE td.fk_theme_id = '".$id . "' "
		."ORDER BY td.def_name;";

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Loading data for theme ".$id .". \$q = `".$bts->StringFormatObj->formatToLog($q)."`"));
		$dbquery = $bts->SDDMObj->query ( $q );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$ClassLoaderObj = ClassLoader::getInstance();
			$ClassLoaderObj->provisionClass('ThemeData');

			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tmpTab = array();
				foreach ( $dbp as $A => $B ) { $tmpTab[$A] = $B; }
				$this->ThemeDefinition[$tmpTab['def_name']] = $tmpTab;
			}
		}
	}

	/**
	 * Gets theme descriptor data from the database using the priority system.<br>
	 * 
	 */
	public function getDataFromDBByPriority() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$q ="";
		$Dest = $this->CssPrefix;
		// mt_ as Main Theme
		if ( $Dest == "mt_" ) {
			if ( $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_pref_theme') != 0 ) { 
				$Dest = $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_pref_theme'); 	// By default the user theme is prefered
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Selecting user theme. id=".$Dest ));
			}
			else { 
				$Dest = $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('fk_theme_id'); // Problem with the prefered user theme
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Selecting website theme. id=".$Dest ));
			}
			// By default we use ID
			$q = "
			SELECT * FROM " 
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')." td , "
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_website')." tw
			WHERE td.theme_id = '".$Dest."'
			AND td.theme_id = tw.fk_theme_id
			AND tw.theme_state = '1'
			;";
		}
		else { 
			// Case for displaying another theme to the user (browsing and choosing).
			// in this case we use names as this was eventually sent to a command line which only uses names. 
			$Dest = $bts->RequestDataObj->getRequestDataSubEntry('formParams1', 'pref_theme');
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Selecting theme for profile. id=".$Dest ));
			$q = "
			SELECT * FROM " 
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')." td , "
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_website')." tw
			WHERE td.theme_name = '".$Dest."'
			AND td.theme_id = tw.fk_theme_id
			AND tw.theme_state = '1'
			;";
		}
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for theme descriptor ".$Dest .". \$q = `".$bts->StringFormatObj->formatToLog($q)."`"));
		$dbquery = $bts->SDDMObj->query ( $q );
		
		// --------------------------------------------------------------------------------------------
		//	Case when an admin goofs (murphy's law) even though an admin cannot goof.
		//	"Yo dawg i heard you like admin Ungoofing so i put an admin ungoof in yo admin ungoof..."
		// --------------------------------------------------------------------------------------------
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
			$dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')."
			LIMIT 1
			;");
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for 1st theme descriptor.Fallback on generic theme."));
		}

		// --------------------------------------------------------------------------------------------
		while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) {
				if (isset($this->columns[$A])) { $this->ThemeDescriptor[$A] = $B; }
			}
			$this->loadThemeData($this->ThemeDescriptor['theme_id']);
		}
		return true;
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
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$genericActionArray = array(
			'columns'		=> $this->columns,
			'data'			=> $this->ThemeDescriptor,
			'targetTable'	=> 'theme_descriptor',
			'targetColumn'	=> 'theme_id',
			'entityId'		=> $this->ThemeDescriptor['theme_id'],
			'entityTitle'	=> 'ThemeDescriptor'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $res = $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $res = $this->genericInsertInDb($genericActionArray); }

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		$this->entityExistsInDb('theme_descriptor', $this->ThemeDescriptor['theme_id']);
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
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			));
	}
	
	//@formatter:off
	public function getThemeDescriptor() { return $this->ThemeDescriptor; }
	public function getCssPrefix() { return $this->CssPrefix; }
	public function getThemeDescriptorEntry ($data) { return $this->ThemeDescriptor[$data]; }
	
	public function setThemeDescriptor($ThemeDescriptor) { $this->ThemeDescriptor = $ThemeDescriptor; }
	public function setCssPrefix($data) { $this->CssPrefix = $data; }
	public function setThemeDescriptorEntry ($entry, $data) { 
		if ( isset($this->ThemeDescriptor[$entry])) { $this->ThemeDescriptor[$entry] = $data; }	// DB Entity objects do NOT accept new columns!  
	}

	// --------------------------------------------------------------------------------------------
	public function getThemeDefinition(){ return $this->ThemeDefinition; }
	public function getThemeDefinitionEntry ($data) { return $this->ThemeDefinition[$data]; }
	public function getThemeDefinitionSubEntry ($lvl1, $lvl2) { return $this->ThemeDefinition[$lvl1][$lvl2]; }

	public function setThemeDefinition($data){ $this->ThemeDefinition = $data; }
	public function setThemeDefinitionEntry ($entry, $data) { $this->ThemeDefinition[$entry] = $data; }
	public function setThemeDefinitionSubEntry ($lvl1, $lvl2, $data) { $this->ThemeDefinition[$lvl1][$lvl2] = $data; }

	//@formatter:off

}

?>