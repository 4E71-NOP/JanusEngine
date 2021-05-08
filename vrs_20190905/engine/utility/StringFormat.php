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

class StringFormat {
	private static $Instance = null;

	private static $ConvertTable = array();
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return StringFormat
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new StringFormat ();
		
			self::makeConvertTable();
		}
		return self::$Instance;
	}

	/**
	 * Feed a table with the expression that will be used to convert expressions.
	 */
	private static function makeConvertTable () {
		self::$ConvertTable['universal']['no']					= "0";
		self::$ConvertTable['universal']['yes']					= 1;
		self::$ConvertTable['universal']['offline']				= "0";
		self::$ConvertTable['universal']['online']				= 1;
		self::$ConvertTable['universal']['off']					= "0";
		self::$ConvertTable['universal']['on']					= 1;
		self::$ConvertTable['universal']['disabled']			= 2;
		
		self::$ConvertTable['article']['show_info_on']			= 1;
		self::$ConvertTable['article']['not_valid']				= 0;
		self::$ConvertTable['article']['valid']					= 1;
		self::$ConvertTable['article']['not_examined']			= 0;
		self::$ConvertTable['article']['examined']				= 1;
		self::$ConvertTable['article']['show_info_off']			= 0;
		self::$ConvertTable['article']['show_info_on']			= 1;
		
		self::$ConvertTable['category']['no']					= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['category']['yes']					= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['category']['offline']				= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['category']['online']				= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['category']['article_racine']		= 0;
		self::$ConvertTable['category']['article']				= 1;
		self::$ConvertTable['category']['menu_admin_racine']	= 2;
		self::$ConvertTable['category']['menu_admin']			= 3;
		self::$ConvertTable['category']['correction_article']	= 1;
		self::$ConvertTable['category']['article_examination']	= &self::$ConvertTable['category']['correction_article'];
		self::$ConvertTable['category']['admin_conf_extension']	= 2;

		
		self::$ConvertTable['deadline']['no']					= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['deadline']['yes']					= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['deadline']['offline']				= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['deadline']['online']				= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['deadline']['disabled']				= &self::$ConvertTable['universal']['disabled'];
		
		
		self::$ConvertTable['decoration']['no']					= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['decoration']['yes']				= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['decoration']['offline']			= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['decoration']['online']				= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['decoration']['top-left']			= 0;
		self::$ConvertTable['decoration']['bottom-left']		= 1;
		self::$ConvertTable['decoration']['center-left']		= 2;
		self::$ConvertTable['decoration']['top-right']			= 4;
		self::$ConvertTable['decoration']['bottom-right']		= 5;
		self::$ConvertTable['decoration']['center-right']		= 6;
		self::$ConvertTable['decoration']['top-center']			= 8;
		self::$ConvertTable['decoration']['bottom-center']		= 9;
		self::$ConvertTable['decoration']['center-center']		= 10;
		self::$ConvertTable['decoration']['bottom-banner']		= 10;

		self::$ConvertTable['decoration']['menu']				= 10;
		self::$ConvertTable['decoration']['caligraph']			= 20;
		self::$ConvertTable['decoration']['1_div']				= 30;
		self::$ConvertTable['decoration']['elegance']			= 40;
		self::$ConvertTable['decoration']['exquisite']			= 50;
		self::$ConvertTable['decoration']['elysion']			= 60;
		
		self::$ConvertTable['document_config']['no']				= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['document_config']['yes']				= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['document_config']['offline']			= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['document_config']['online']			= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['document_config']['table']				= 1;
		self::$ConvertTable['document_config']['menu_select']		= 2;
		self::$ConvertTable['document_config']['normal']			= 1;
		self::$ConvertTable['document_config']['float']				= 2;
		self::$ConvertTable['document_config']['none']				= 0;
		self::$ConvertTable['document_config']['left']				= 1;
		self::$ConvertTable['document_config']['right']				= 2;
		self::$ConvertTable['document_config']['no_menu']			= 0;
		self::$ConvertTable['document_config']['top']				= 1;
		self::$ConvertTable['document_config']['bottom']			= 2;
		self::$ConvertTable['document_config']['both']				= 3;
		self::$ConvertTable['document_config']['store']				= 4;
		
		
		self::$ConvertTable['document']['no']					= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['document']['yes']					= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['document']['html']					= 0;
		self::$ConvertTable['document']['php']					= 1;
		self::$ConvertTable['document']['mixed']				= 2;
		
		self::$ConvertTable['group']['anonymous']				= 0;
		self::$ConvertTable['group']['reader']					= 1;
		self::$ConvertTable['group']['staff']					= 2;
		self::$ConvertTable['group']['senior_staff']			= 3;
		
		self::$ConvertTable['module']['no']						= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['module']['yes']					= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['module']['off']					= &self::$ConvertTable['universal']['off'];
		self::$ConvertTable['module']['on']						= &self::$ConvertTable['universal']['on'];
		self::$ConvertTable['module']['offline']				= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['module']['online']					= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['module']['before']					= 1;
		self::$ConvertTable['module']['after']					= 2;
		self::$ConvertTable['module']['during']					= 0;
		
		self::$ConvertTable['keyword']['offline']				= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['keyword']['online']				= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['keyword']['to_category']			= 1;
		self::$ConvertTable['keyword']['to_url']				= 2;
		self::$ConvertTable['keyword']['tooltip']				= 3;
		
		self::$ConvertTable['layout']['no']						= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['layout']['yes']					= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['layout']['offline']				= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['layout']['online']					= &self::$ConvertTable['universal']['online'];
		
		self::$ConvertTable['layout_content']['static']			= 0;
		self::$ConvertTable['layout_content']['dynamic']		= 1;
		self::$ConvertTable['layout_content']['top']			= 1;
		self::$ConvertTable['layout_content']['bottom']			= 2;
		self::$ConvertTable['layout_content']['left']			= 1;
		self::$ConvertTable['layout_content']['right']			= 2;
		self::$ConvertTable['layout_content']['null']			= 0;
		self::$ConvertTable['layout_content']['haut']			= &self::$ConvertTable['layout_content']['top'];
		self::$ConvertTable['layout_content']['bas']			= &self::$ConvertTable['layout_content']['bottom'];
		self::$ConvertTable['layout_content']['gauche']			= &self::$ConvertTable['layout_content']['left'];
		self::$ConvertTable['layout_content']['droite']			= &self::$ConvertTable['layout_content']['right'];
		
		//Theme
		self::$ConvertTable['theme']['offline']					= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['theme']['online']					= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['theme']['top-left']				= 0;
		self::$ConvertTable['theme']['bottom-left']				= 1;
		self::$ConvertTable['theme']['center-left']				= 2;
		self::$ConvertTable['theme']['top-right']				= 4;
		self::$ConvertTable['theme']['bottom-right']			= 5;
		self::$ConvertTable['theme']['center-right']			= 6;
		self::$ConvertTable['theme']['top-center']				= 8;
		self::$ConvertTable['theme']['bottom-center']			= 9;
		self::$ConvertTable['theme']['center-center']			= 10;

		// User
		self::$ConvertTable['user']['no']						= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['user']['yes']						= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['user']['private']					= 1;
		self::$ConvertTable['user']['public']					= 2;
		self::$ConvertTable['user']['disabled']					= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['user']['active']					= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['user']['off']						= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['user']['on']						= &self::$ConvertTable['universal']['yes'];
		

		// Website
		self::$ConvertTable['website']['no']					= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['website']['yes']					= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['website']['offline']				= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['website']['online']				= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['website']['static']				= 0;
		self::$ConvertTable['website']['dynamic']				= 1;
		self::$ConvertTable['website']['base']					= 0;
		
					
		self::$ConvertTable['M_SITWEB']['base']					= 1;
		self::$ConvertTable['M_SITWEB']['fichier']				= 2;
		self::$ConvertTable['M_SITWEB']['database']				= &self::$ConvertTable['M_SITWEB']['base'];
		self::$ConvertTable['M_SITWEB']['file']					= &self::$ConvertTable['M_SITWEB']['fichier'];
		self::$ConvertTable['M_UTILIS']['publique']				= 2;
		self::$ConvertTable['M_UTILIS']['prive']				= 1;
		self::$ConvertTable['M_UTILIS']['privee']				= &self::$ConvertTable['M_UTILIS']['prive'];
		self::$ConvertTable['M_UTILIS']['public']				= &self::$ConvertTable['M_UTILIS']['publique'];
		self::$ConvertTable['M_UTILIS']['private']				= &self::$ConvertTable['M_UTILIS']['prive'];
		self::$ConvertTable['M_TAG']['top-left']				= 0;
		self::$ConvertTable['M_TAG']['bottom-left']				= 1;
		self::$ConvertTable['M_TAG']['center-left']				= 2;
		self::$ConvertTable['M_TAG']['top-right']				= 4;
		self::$ConvertTable['M_TAG']['bottom-right']			= 5;
		self::$ConvertTable['M_TAG']['center-right']			= 6;
		self::$ConvertTable['M_TAG']['top-center']				= 8;
		self::$ConvertTable['M_TAG']['bottom-center']			= 9;
		self::$ConvertTable['M_TAG']['center-center']			= 10;
		self::$ConvertTable['M_TAG']['haut-gauche']				= &self::$ConvertTable['M_TAG']['top-left'];
		self::$ConvertTable['M_TAG']['bas-gauche']				= &self::$ConvertTable['M_TAG']['bottom-left'];
		self::$ConvertTable['M_TAG']['centre-gauche']			= &self::$ConvertTable['M_TAG']['center-left'];
		self::$ConvertTable['M_TAG']['haut-droite']				= &self::$ConvertTable['M_TAG']['top-right'];
		self::$ConvertTable['M_TAG']['bas-droite']				= &self::$ConvertTable['M_TAG']['bottom-right'];
		self::$ConvertTable['M_TAG']['centre-droite']			= &self::$ConvertTable['M_TAG']['center-right'];
		self::$ConvertTable['M_TAG']['haut-centre']				= &self::$ConvertTable['M_TAG']['top-center'];
		self::$ConvertTable['M_TAG']['bas-centre']				= &self::$ConvertTable['M_TAG']['bottom-center'];
		self::$ConvertTable['M_TAG']['centre-centre']			= &self::$ConvertTable['M_TAG']['center-center'];
		self::$ConvertTable['M_THEME']['top-left']				= 0;
		self::$ConvertTable['M_THEME']['bottom-left']			= 1;
		self::$ConvertTable['M_THEME']['center-left']			= 2;
		self::$ConvertTable['M_THEME']['top-right']				= 4;
		self::$ConvertTable['M_THEME']['bottom-right']			= 5;
		self::$ConvertTable['M_THEME']['center-right']			= 6;
		self::$ConvertTable['M_THEME']['top-center']			= 8;
		self::$ConvertTable['M_THEME']['bottom-center']			= 9;
		self::$ConvertTable['M_THEME']['center-center']			= 10;
		self::$ConvertTable['M_THEME']['haut-gauche']			= &self::$ConvertTable['M_THEME']['top-left'];
		self::$ConvertTable['M_THEME']['bas-gauche']			= &self::$ConvertTable['M_THEME']['bottom-left'];
		self::$ConvertTable['M_THEME']['centre-gauche']			= &self::$ConvertTable['M_THEME']['center-left'];
		self::$ConvertTable['M_THEME']['haut-droite']			= &self::$ConvertTable['M_THEME']['top-right'];
		self::$ConvertTable['M_THEME']['bas-droite']			= &self::$ConvertTable['M_THEME']['bottom-right'];
		self::$ConvertTable['M_THEME']['centre-droite']			= &self::$ConvertTable['M_THEME']['center-right'];
		self::$ConvertTable['M_THEME']['haut-centre']			= &self::$ConvertTable['M_THEME']['top-center'];
		self::$ConvertTable['M_THEME']['bas-centre']			= &self::$ConvertTable['M_THEME']['bottom-center'];
		self::$ConvertTable['M_THEME']['centre-centre']			= &self::$ConvertTable['M_THEME']['center-center'];
	}
	
	/**
	 * Return a string strip of caracters that would clutter the logs and make it unreadable.
	 * @param string $data
	 * @return string
	 * 
	 */
	public function formatToLog ( $data ) {
		$tab_rch = array ("\n",	"\t",		"    ",	"   ",	"  ",	);
		$tab_rpl = array (" ",	" ",		" ",	" ",	" ",	);
		return str_replace ($tab_rch,$tab_rpl,$data);
	}


	/**
	 * Return a HTML string to diplay an array in a readable fashion.
	 * @param array $data
	 * @param boolean $return_data
	 * @return mixed
	 */
	public function print_r_html ($data, $return_data=true) {
		$data = print_r($data,true);
		$tab_rch = array ("&",		"<",		">",	" ",		"\r\n",		"\r",		"\n");
		$tab_rpl = array ("&amp;",	"&lt;",		"&gt;",	"&nbsp;",	"<br>\r",	"<br>\r",	"<br>\r");
		$data = str_replace ($tab_rch,$tab_rpl,$data);
		if ( !$return_data ) { echo $data; }
		else { return $data; }
	}

	/**
	 * Return a text string to diplay an array in a readable fashion.
	 * @param array $data
	 * @param boolean $return_data
	 * @return mixed
	 */
	public function print_r_debug($data,$return_data=true) {
		$data = print_r($data,true);
		$tab_rch = array ("\r\n",		"\r");
		$tab_rpl = array ("\n",			"\n");
		$data = str_replace ($tab_rch,$tab_rpl,$data);
		if (!$return_data) { echo $data; }
		else { return $data; }
	}
	
	/**
	 * Return a PHP script to create an array .
	 * 
	 * @param array $data
	 * @param string $tab
	 * @return string
	 */
	public function print_r_code($data, $tab) {
		$str = "";
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$j = $tab."\t";
				$currentBranch = $this->print_r_code($value, $j);
				$str .= $tab."\"".$key."\" => array (\n ".$currentBranch."\n".$tab."),\n";
			}
			else { $str .= $tab."\"".$key."\" => \"".$value."\",\n";}
		}
		$str = substr( $str , 0 , -2 );
		return $str;
	}
	
	/**
	 * Return a string describing an array in canonical form.
	 * @param array $data
	 */
	public function arrayToString ($data) {
		$str = "array(";
		foreach ($data as $A => $B) { 
			if ( is_array($B)) { $str .= "[".$A."]=" . $this->arrayToString ($B); }
			elseif ( is_object($B)) { $str .= "[".$A."] is an object named `".get_class($B)."`, "; }
			else { $str .= "[".$A."]=`".$B."`, "; }
		}
		$str = substr ( $str, 0 , -2 ) . "), ";
		return $str;
	}
	
	
	/**
	 * Return a string with the $nbr on 2 digits (ex B,1,G => B01G)
	 * @param string $start
	 * @param number $nbr
	 * @param string $end
	 * @return string
	 */
	public function getDecorationBlockName ( $start , $nbr , $end ) {
		$a = $start . sprintf("%02u",$nbr) . $end;
		return $a;
	}

	/**
	 * 
	 * @param array $data
	 * @param boolean $return_data
	 * @return mixed
	 */
	public function print_r_hexa( $data , $return_data=true ) {
		foreach ( $data as &$a ) {
			$str = $a;
			$b = strlen($a);
			$a .= " : ";
			for ($c = 0; $c <= $b; $c++) { $a .= dechex(ord($str[$c])) . " "; }
		}
		$data = $this->print_r_html($data);
		if (!$return_data) { echo $data; }
		else { return $data; }
	}
	
	/**
	 * Returns the value selected in a table with $section and $val
	 * @param string $val
	 * @param string $section
	 * @return mixed
	 */
	public function conversion_expression ( $val, $section ) {
		return self::$ConvertTable[$section][strtolower($val)];
	}
	
	/**
	 * Returns a HTML string 
	 * @param string $expr
	 * @return string
	 */
	public function ConvertToHtml($expr) { return htmlentities($expr); }
	
	
	/**
	 * Returns a shorter expression
	 * @param string $expr
	 * @param float $l0
	 * @return string
	 */
	public function shorteningExpression ( $expr , $l0 ) {
		$ls = strlen( $expr );
		$l1 = floor( $l0 / 2 );
		$l2 = $l1 - 4;
		switch (TRUE) {
			case ($ls < $l1 ):					$R = $expr;																	break;
			case ($ls < $l0 && $ls > $l2 ):		$R = substr ($expr,0,$l2) . " [...] ";										break;
			case ($ls > $l0 || $ls == $l0 ):	$R = substr ($expr,0,$l2) . " [...] " . substr ($expr,($ls - $l2) ,$ls );	break;
		}
		return $R;
	}
	
	/**
	 * Convert a size in a human readdable fashion
	 * @param array $infos
	 * @param float $size
	 * @return string
	 */
	public function makeSizeHumanFriendly( $infos, $size ) {
		$CurrentSetObj = CurrentSet::getInstance();
		
		$block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		$TabUnits = array(
				"<span class='" . $block."_ok'>b</span>",
				"<span class='" . $block."_warning'>Kb</span>",
				"<span class='" . $block."_erreur " . $block."_tb3'>MB</span>",
				"<span class='" . $block."_erreur " . $block."_tb4'>GB</span>"
		);
		if ($size == 0 ) {
			return "0<span class='" . $block."_erreur " . $block."_tb3'>Kb</span>";
		}
		else {
			if ( $size < 0 ) { return "-".round(abs($size)/pow(1024,($i=floor(log(abs($size),1024)))),2)." ".$TabUnits[$i]; }
			else { return round(abs($size)/pow(1024,($i=floor(log(abs($size),1024)))),2).' '.$TabUnits[$i]; }
		}
	}
	
}
	
?>