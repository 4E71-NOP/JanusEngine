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

class SqlTableList {
	private static $Instance = null;

	private $SQLTableName = array();
	
	private $TableList = array (
			'article',			'article_tag',			'article_config',
			'deadline',			
			'decoration',		'deco_10_menu',			'deco_20_caligraph',		'deco_30_1_div',		'deco_40_elegance',			'deco_50_exquisite',			'deco_60_elysion',					
			'definition',
			'document',			'document_share',		'document_partage',
			'extension',		'extension_config',		'extension_dependency',		'extension_file',
			'group',			'group_permission',		'group_user',			
			'i18n',				
			'installation',		
			'keyword',			'note',			
			'language',			'language_website',		
			'log',
			'menu',				'module',				'module_website',		
			'layout',			'layout_theme',			'layout_file',
			'permission',		'pv',				
			'stored_event',		
			'tag',				
			'theme_descriptor',	'theme_website',
			'user',				'user_permission',
			'website',			'group_website',		'theme_website',
	);

	// 'layout_content',		

	private function __construct( $dbprefix , $tabprefix ){
		foreach ( $this->TableList as $A ) { 
			$this->SQLTableName[$A] = $dbprefix . "." .  $tabprefix . $A;
			// $this->SQLTableShortName[$A] = $tabprefix . $A;		// Deprecated
		}
	}
	
	public static function getInstance($dbprefix , $tabprefix) {
		if (self::$Instance == null) {
			self::$Instance = new SqlTableList($dbprefix , $tabprefix);
		}
		return self::$Instance;
	}
	
	//@formatter:off
	public function getSQLTableName( $data ) { return $this->SQLTableName[$data]; }
	public function getSQLWholeTableName() { return $this->SQLTableName; }
	public function getTableList() { return $this->TableList; }
	// public function getSQLTableShortName( $data ) { return $this->SQLTableShortName[$data]; }		// Deprecated
	// public function getSQLWholeTableShortName() { return $this->SQLTableShortName; }
	//@formatter:on
}

?>
