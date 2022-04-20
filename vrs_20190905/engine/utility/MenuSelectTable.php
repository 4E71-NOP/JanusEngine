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

class MenuSelectTable {
	private static $Instance = null;
	
	private function __construct(){}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return MenuSelectTable
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new MenuSelectTable();
		}
		return self::$Instance;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of arti_ref(s) in the current website context.
	 * @return array
	 */
	public function getArtiRefList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT arti_ref, arti_slug  
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('article')." 
			WHERE arti_validation_state = '1'
			AND fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."' 
			AND arti_page = 1 
			ORDER BY arti_slug
		;");
		$tab = array();
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data"));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['arti_ref']]['t']	=	$tab[$dbp['arti_ref']]['db']	= $dbp['arti_slug'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned"));
		}
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of menu in the current website context.
	 * @return array
	 */
	public function getMenuList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT * 
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('menu')."
			WHERE fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."' 
			ORDER BY menu_name
		;");
		$tab = array();
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data"));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['menu_id']]['t']	=	$tab[$dbp['menu_id']]['db']	= $dbp['menu_name'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned"));
		}
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of deadlines in the current website context.
	 * @return array
	 */
	public function getDeadlineList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('deadline')."
			WHERE fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."' 
			ORDER BY deadline_name
		;");
		$tab = array();
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data"));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['deadline_id']]['t']	= $dbp['deadline_title'];
				$tab[$dbp['deadline_id']]['db']	= $dbp['deadline_name'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned"));
		}
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of documents in the current website context.
	 * @return array
	 */
	public function getDocumentList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT doc.*
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document')." doc, ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document_share')." ds
			WHERE doc.docu_id = ds.fk_docu_id
			AND ds.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
			ORDER BY doc.docu_name
		;");
		$tab = array();
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data"));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['docu_name']]['t'] = $tab[$dbp['docu_name']]['db'] = $dbp['docu_name'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned"));
		}
		
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of groups in the current website context.
	 * @return array
	 */
	public function getGroupList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT grp.* 
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group')." grp , "
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group_website')." sg
			WHERE grp.group_id = sg.fk_group_id
			AND sg.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		;");
		$tab = array();
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data"));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['group_id']]['t']	=	$tab[$dbp['group_id']]['db']	= $dbp['group_name'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned"));
		}
		
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of layout in the current website context.
	 * @return array
	 */
	public function getLayoutList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT p.*
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('layout')." p, "
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('layout_theme')." lt, "
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_website')." wt
			WHERE p.layout_id = lt.fk_layout_id
			AND lt.fk_theme_id = wt.fk_theme_id
			AND wt.theme_state = '1'
			AND wt.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."' 
			ORDER BY p.layout_name
		;");
		$tab = array();
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data"));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['layout_generic_name']]['t']	= $dbp['layout_generic_name'];
				$tab[$dbp['layout_generic_name']]['db']	= $dbp['layout_generic_name'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned"));
		}
		
		return $tab;
	}

		/**
	 * Returns an array for HTML "menu select" containing the list of layoutFile in the current website context.
	 * @return array
	 */
	public function getLayoutFileList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT lf.*
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('layout')." p, "
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('layout_theme')." lt, "
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('layout_file')." lf, "
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_website')." wt
			WHERE lf.layout_file_id = p.fk_layout_file_id 
			AND p.layout_id = lt.fk_layout_id
			AND lt.fk_theme_id = wt.fk_theme_id
			AND wt.theme_state = '1'
			AND wt.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."' 
			ORDER BY p.layout_name
		;");
		$tab = array();
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data"));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['layout_file_name']]['t']		= $dbp['layout_file_name']." / ".$dbp['layout_file_generic_name'];
				$tab[$dbp['layout_file_name']]['db']	= $dbp['layout_file_name'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned"));
		}
		
		return $tab;
	}

	
	/**
	 * Returns an array for HTML "menu select" containing the list of languages in the current website context.
	 * @return array
	 */
	public function getLanguageList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT l.* 
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language')." l, ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language_website')." lw 
			WHERE l.lang_id = lw.fk_lang_id
			AND lw.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		;");
		$tab = array();
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data"));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['lang_id']]['t']	=	$tab[$dbp['lang_id']]['db']	= $dbp['lang_original_name'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned"));
		}
		
		return $tab;
	}
	
	/**
	 * Returns an array for HTML "menu select" containing the list of languages in the current website context.
	 * @return array
	 */
	public function getThemeList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT t.* 
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')." t, ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_website')." st 
			WHERE t.theme_id = st.theme_id
			AND st.theme_state = '1' 
			AND st.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		;");
		$tab = array();
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data"));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['theme_id']]['t']	=	$tab[$dbp['theme_id']]['db']	= $dbp['theme_name'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned"));
		}
		
		return $tab;
	}
	
	/**
	 * Returns an array for HTML "menu select" containing the list of users in the current website context.
	 * @return array
	 */
	public function getUserList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT usr.*, g.group_id, g.group_name, gu.group_user_initial_group, g.group_tag
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('user')." usr, ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group_user')." gu, " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ( 'group_website' ) . " sg , " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ( 'group' ) . " g
			WHERE usr.user_id = gu.fk_user_id
			AND gu.group_user_initial_group = '1'
			AND g.group_tag IN (2,3)
			AND gu.fk_group_id = g.group_id
			AND gu.fk_group_id = sg.fk_group_id
			AND sg.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
			ORDER BY usr.user_name
		;");
		$tab = array();
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data"));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['user_id']]['t']	=	$tab[$dbp['user_id']]['db']	= $dbp['user_name'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned"));
		}
		return $tab;	
	}
	
		/**
	 * Returns an array for HTML "menu select" containing the list of decoration in the current website context.
	 * @return array
	 */
	public function getDecorationList(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();

		// Data is already in RAM so we just have to get it.
		$tabDecoNbr = array();
		for ( $i =1; $i<=30; $i++ ) {
			$tabDecoNbr[$i] = array(
				_MENU_OPTION_TXT_		=>	$i." - ".$ThemeDataObj->getThemeDataEntry($bts->StringFormatObj->getDecorationBlockName('theme_block_', $i, '_name')),
				_MENU_OPTION_DB_		=>	$ThemeDataObj->getThemeDataEntry($bts->StringFormatObj->getDecorationBlockName('theme_block_', $i, '_name')),
				_MENU_OPTION_SELECTED_	=> '',
			);
		}
		return ($tabDecoNbr) ;
	}



}

