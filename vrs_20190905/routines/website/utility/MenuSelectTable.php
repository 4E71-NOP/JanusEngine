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
			WHERE arti_validation_etat = '1'
			AND site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
			ORDER BY arti_ref
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("MenuSelectTable/getArtiRefList() : Loading data");
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['arti_ref']]['t']	=	$tab[$dbp['arti_ref']]['db']	= $dbp['arti_ref'];
			}
		}
		else {
			$LMObj->InternalLog("MenuSelectTable/getArtiRefList() : No rows returned");
		}
		
		return $tab;
	}
	
	
	/**
	 * Returns an array for HTML "menu select" containing the list of categories in the current website context.
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
			FROM ".$SqlTableListObj->getSQLTableName('categorie')."
			WHERE site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
			ORDER BY cate_nom
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("MenuSelectTable/getCategoryList() : Loading data");
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['cate_id']]['t']	=	$tab[$dbp['cate_id']]['db']	= $dbp['cate_nom'];
			}
		}
		else {
			$LMObj->InternalLog("MenuSelectTable/getCategoryList() : No rows returned");
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
			FROM ".$SqlTableListObj->getSQLTableName('bouclage')."
			WHERE site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
			ORDER BY bouclage_nom
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("MenuSelectTable/getDeadlineList() : Loading data");
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['bouclage_id']]['t']	=	$tab[$dbp['bouclage_id']]['db']	= $dbp['bouclage_nom'];
			}
		}
		else {
			$LMObj->InternalLog("MenuSelectTable/getDeadlineList() : No rows returned");
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
			AND dp.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
			ORDER BY doc.docu_nom
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("MenuSelectTable/getDocumentList() : Loading data");
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['docu_id']]['t']	=	$tab[$dbp['docu_id']]['db']	= $dbp['docu_nom'];
			}
		}
		else {
			$LMObj->InternalLog("MenuSelectTable/getDocumentList() : No rows returned");
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
			FROM ".$SqlTableListObj->getSQLTableName('groupe')." grp , ".$SqlTableListObj->getSQLTableName('site_groupe')." sg
			WHERE grp.groupe_id = sg.groupe_id
			AND sg.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("MenuSelectTable/getGroupList() : Loading data");
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['groupe_id']]['t']	=	$tab[$dbp['groupe_id']]['db']	= $dbp['groupe_nom'];
			}
		}
		else {
			$LMObj->InternalLog("MenuSelectTable/getGroupList() : No rows returned");
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
			FROM ".$SqlTableListObj->getSQLTableName('presentation')." p, ".$SqlTableListObj->getSQLTableName('theme_presentation')." tp, ".$SqlTableListObj->getSQLTableName('site_theme')." wt
			WHERE p.pres_id = tp.pres_id
			AND tp.theme_id = wt.theme_id
			AND wt.theme_etat = '1'
			AND wt.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
			ORDER BY p.pres_nom
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("MenuSelectTable/getLayoutList() : Loading data");
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['pres_nom_generique']]['t']	=	$tab[$dbp['pres_nom_generique']]['db']	= $dbp['pres_nom_generique'];
			}
		}
		else {
			$LMObj->InternalLog("MenuSelectTable/getLayoutList() : No rows returned");
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
			FROM ".$SqlTableListObj->getSQLTableName('langues')." l, ".$SqlTableListObj->getSQLTableName('site_langue')." sl 
			WHERE l.langue_id = sl.lang_id
			AND sl.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("MenuSelectTable/getLanguageList() : Loading data");
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['langue_id']]['t']	=	$tab[$dbp['langue_id']]['db']	= $dbp['langue_nom_original'];
			}
		}
		else {
			$LMObj->InternalLog("MenuSelectTable/getLanguageList() : No rows returned");
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
			FROM ".$SqlTableListObj->getSQLTableName('theme_descripteur')." t, ".$SqlTableListObj->getSQLTableName('site_theme')." st 
			WHERE t.theme_id = st.theme_id
			AND st.theme_etat = '1' 
			AND st.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("MenuSelectTable/getThemeList() : Loading data");
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['theme_id']]['t']	=	$tab[$dbp['theme_id']]['db']	= $dbp['theme_nom'];
			}
		}
		else {
			$LMObj->InternalLog("MenuSelectTable/getThemeList() : No rows returned");
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
			SELECT usr.*, g.groupe_id, g.groupe_nom, gu.groupe_premier, g.groupe_tag
			FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('groupe_user')." gu, " . $SqlTableListObj->getSQLTableName ( 'site_groupe' ) . " sg , " . $SqlTableListObj->getSQLTableName ( 'groupe' ) . " g
			WHERE usr.user_id = gu.user_id
			AND gu.groupe_premier = '1'
			AND g.groupe_tag IN (2,3)
			AND gu.groupe_id = g.groupe_id
			AND gu.groupe_id = sg.groupe_id
			AND sg.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
			ORDER BY usr.user_nom
		;");
		$tab = array();
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("MenuSelectTable/getUserList() : Loading data");
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$tab[$dbp['user_id']]['t']	=	$tab[$dbp['user_id']]['db']	= $dbp['user_nom'];
			}
		}
		else {
			$LMObj->InternalLog("MenuSelectTable/getUserList() : No rows returned");
		}
		
		return $tab;	
	}
	
	
	
}

