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
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT DISTINCT arti_ref 
			FROM ".$SqlTableListObj->getSQLTableName('article')." 
			WHERE arti_validation_state = '1'
			AND ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
			ORDER BY arti_ref
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getArtiRefList() : Loading data"));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['arti_ref']]['t']	=	$tab[$dbp['arti_ref']]['db']	= $dbp['arti_ref'];
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getArtiRefList() : No rows returned"));
		}
		
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of categorys in the current website context.
	 * @return array
	 */
	public function getCategoryList(){
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT * 
			FROM ".$SqlTableListObj->getSQLTableName('category')."
			WHERE ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
			ORDER BY cate_name
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getCategoryList() : Loading data"));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['cate_id']]['t']	=	$tab[$dbp['cate_id']]['db']	= $dbp['cate_name'];
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getCategoryList() : No rows returned"));
		}
		
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of deadlines in the current website context.
	 * @return array
	 */
	public function getDeadlineList(){
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT *
			FROM ".$SqlTableListObj->getSQLTableName('deadline')."
			WHERE ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
			ORDER BY deadline_name
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getDeadlineList() : Loading data"));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['deadline_id']]['t']	=	$tab[$dbp['deadline_id']]['db']	= $dbp['deadline_name'];
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getDeadlineList() : No rows returned"));
		}
		
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of documents in the current website context.
	 * @return array
	 */
	public function getDocumentList(){
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT doc.*
			FROM ".$SqlTableListObj->getSQLTableName('document')." doc, ".$SqlTableListObj->getSQLTableName('document_share')." dp
			WHERE doc.docu_id = dp.docu_id
			AND dp.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
			ORDER BY doc.docu_name
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getDocumentList() : Loading data"));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['docu_id']]['t']	=	$tab[$dbp['docu_id']]['db']	= $dbp['docu_name'];
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getDocumentList() : No rows returned"));
		}
		
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of groups in the current website context.
	 * @return array
	 */
	public function getGroupList(){
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT grp.* 
			FROM ".$SqlTableListObj->getSQLTableName('group')." grp , ".$SqlTableListObj->getSQLTableName('group_website')." sg
			WHERE grp.group_id = sg.group_id
			AND sg.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getGroupList() : Loading data"));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['group_id']]['t']	=	$tab[$dbp['group_id']]['db']	= $dbp['group_name'];
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getGroupList() : No rows returned"));
		}
		
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of layout in the current website context.
	 * @return array
	 */
	public function getLayoutList(){
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT p.*
			FROM ".$SqlTableListObj->getSQLTableName('layout')." p, ".$SqlTableListObj->getSQLTableName('layout_theme')." tp, ".$SqlTableListObj->getSQLTableName('theme_website')." wt
			WHERE p.layout_id = tp.layout_id
			AND tp.theme_id = wt.theme_id
			AND wt.theme_state = '1'
			AND wt.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
			ORDER BY p.layout_name
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getLayoutList() : Loading data"));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['layout_generic_name']]['t']	=	$tab[$dbp['layout_generic_name']]['db']	= $dbp['layout_generic_name'];
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getLayoutList() : No rows returned"));
		}
		
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of languages in the current website context.
	 * @return array
	 */
	public function getLanguageList(){
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT l.* 
			FROM ".$SqlTableListObj->getSQLTableName('language')." l, ".$SqlTableListObj->getSQLTableName('language_website')." sl 
			WHERE l.lang_id = sl.lang_id
			AND sl.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getLanguageList() : Loading data"));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['lang_id']]['t']	=	$tab[$dbp['lang_id']]['db']	= $dbp['lang_original_name'];
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getLanguageList() : No rows returned"));
		}
		
		return $tab;
	}
	
	/**
	 * Returns an array for HTML "menu select" containing the list of languages in the current website context.
	 * @return array
	 */
	public function getThemeList(){
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT t.* 
			FROM ".$SqlTableListObj->getSQLTableName('theme_descriptor')." t, ".$SqlTableListObj->getSQLTableName('theme_website')." st 
			WHERE t.theme_id = st.theme_id
			AND st.theme_state = '1' 
			AND st.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getThemeList() : Loading data"));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['theme_id']]['t']	=	$tab[$dbp['theme_id']]['db']	= $dbp['theme_name'];
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getThemeList() : No rows returned"));
		}
		
		return $tab;
	}
	
	/**
	 * Returns an array for HTML "menu select" containing the list of users in the current website context.
	 * @return array
	 */
	public function getUserList(){
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT usr.*, g.group_id, g.group_name, gu.group_user_initial_group, g.group_tag
			FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('group_user')." gu, " . $SqlTableListObj->getSQLTableName ( 'group_website' ) . " sg , " . $SqlTableListObj->getSQLTableName ( 'group' ) . " g
			WHERE usr.user_id = gu.user_id
			AND gu.group_user_initial_group = '1'
			AND g.group_tag IN (2,3)
			AND gu.group_id = g.group_id
			AND gu.group_id = sg.group_id
			AND sg.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
			ORDER BY usr.user_name
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getUserList() : Loading data"));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['user_id']]['t']	=	$tab[$dbp['user_id']]['db']	= $dbp['user_name'];
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "MenuSelectTable/getUserList() : No rows returned"));
		}
		
		return $tab;	
	}
	
	
	
}

