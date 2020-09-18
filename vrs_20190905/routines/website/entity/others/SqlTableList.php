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
	
	private $TableList = array (
			'article',				'article_tag',			'auteurs',
			'deadline',				
			'categorie',			
			'document',				'document_share',			'document_partage',
			'decoration',			'deco_10_menu',				'deco_20_caligraphe',	'deco_30_1_div',		'deco_40_elegance',			'deco_50_exquise',			'deco_60_elysion',					
			'group',				'group',					'group_user',			'group_user',
			'historique',			'i18n',						'installation',				
			'language',				'languages',
			'module',				
			'mot_cle',				'note_renvoit',				
			'layout',			'layout_content',		
			'extension',			'extension_config',			'extension_dependency',	'extension_file',
			'pv',					
			'website',				'group_website',				'language_website',			'module_website',			'theme_website',
			'theme_descriptor',		'layout_theme',
			'stored_event',			'stat_navigateur',			'stat_utilisateur',
			'tag',					
			'user',
			'tl_fra',
			
			'stored_event',
			
			'article_config',
			
			
			
			
	);
	
	private $SQLTableName = array();
	private $SQLTableShortName = array();		// Deprecated
	
	private function __construct( $dbprefix , $tabprefix ){
		foreach ( $this->TableList as $A ) { 
			$this->SQLTableName[$A] = $dbprefix . "." .  $tabprefix . $A;
			$this->SQLTableShortName[$A] = $tabprefix . $A;		// Deprecated
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
	public function getSQLTableShortName( $data ) { return $this->SQLTableShortName[$data]; }		// Deprecated
	public function getSQLWholeTableName() { return $this->SQLTableName; }
	public function getSQLWholeTableShortName() { return $this->SQLTableShortName; }
	//@formatter:on
}

?>
