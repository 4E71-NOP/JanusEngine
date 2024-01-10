<?php
/*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

class StringFormat
{
	private static $Instance = null;

	private static $ConvertTable = array();

	/**
	 * Singleton : Will return the instance of this class.
	 * @return StringFormat
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new StringFormat();

			self::makeConvertTable();
		}
		return self::$Instance;
	}

	/**
	 * Feed a table with the expression that will be used to convert expressions.
	 */
	private static function makeConvertTable()
	{
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

		self::$ConvertTable['menu']['no']					= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['menu']['yes']					= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['menu']['offline']				= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['menu']['online']				= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['menu']['article_racine']		= 0;
		self::$ConvertTable['menu']['article']				= 1;
		self::$ConvertTable['menu']['menu_admin_racine']	= 2;
		self::$ConvertTable['menu']['menu_admin']			= 3;
		self::$ConvertTable['menu']['correction_article']	= 1;
		self::$ConvertTable['menu']['article_examination']	= &self::$ConvertTable['menu']['correction_article'];
		self::$ConvertTable['menu']['admin_conf_extension']	= 2;


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

		self::$ConvertTable['article_config']['no']				= &self::$ConvertTable['universal']['no'];
		self::$ConvertTable['article_config']['yes']			= &self::$ConvertTable['universal']['yes'];
		self::$ConvertTable['article_config']['offline']		= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['article_config']['online']			= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['article_config']['table']			= 1;
		self::$ConvertTable['article_config']['menu_select']	= 2;
		self::$ConvertTable['article_config']['normal']			= 1;
		self::$ConvertTable['article_config']['float']			= 2;
		self::$ConvertTable['article_config']['none']			= 0;
		self::$ConvertTable['article_config']['left']			= 1;
		self::$ConvertTable['article_config']['right']			= 2;
		self::$ConvertTable['article_config']['no_menu']		= 0;
		self::$ConvertTable['article_config']['top']			= 1;
		self::$ConvertTable['article_config']['bottom']			= 2;
		self::$ConvertTable['article_config']['both']			= 3;
		self::$ConvertTable['article_config']['store']			= 4;


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
		self::$ConvertTable['module']['standart']				= 1;
		self::$ConvertTable['module']['admin']					= 2;
		self::$ConvertTable['module']['install']				= 99;

		self::$ConvertTable['keyword']['offline']				= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['keyword']['online']				= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['keyword']['to_menu']				= 1;
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

		// Permission
		self::$ConvertTable['permission']['disbled']			= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['permission']['enabled']			= &self::$ConvertTable['universal']['online'];
		self::$ConvertTable['permission']['deleted']			= &self::$ConvertTable['universal']['disabled'];
		self::$ConvertTable['permission']['read']				= 1;
		self::$ConvertTable['permission']['write']				= 2;

		// Theme
		self::$ConvertTable['theme']['offline']					= &self::$ConvertTable['universal']['offline'];
		self::$ConvertTable['theme']['online']					= &self::$ConvertTable['universal']['online'];

		// Theme_definition
		self::$ConvertTable['theme_definition']['top-left']			= 0;
		self::$ConvertTable['theme_definition']['bottom-left']		= 1;
		self::$ConvertTable['theme_definition']['center-left']		= 2;
		self::$ConvertTable['theme_definition']['top-right']		= 4;
		self::$ConvertTable['theme_definition']['bottom-right']		= 5;
		self::$ConvertTable['theme_definition']['center-right']		= 6;
		self::$ConvertTable['theme_definition']['top-center']		= 8;
		self::$ConvertTable['theme_definition']['bottom-center']	= 9;
		self::$ConvertTable['theme_definition']['center-center']	= 10;
		self::$ConvertTable['theme_definition']['number']			= 0;
		self::$ConvertTable['theme_definition']['string']			= 1;

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
	}

	/**
	 * Return a string strip of caracters that would clutter the logs and make it unreadable.
	 * @param string $data
	 * @return string
	 * 
	 */
	public function formatToLog($data)
	{
		$tab_rch = array("\n",	"\t",		"    ",	"   ",	"  ",);
		$tab_rpl = array(" ",	" ",		" ",	" ",	" ",);
		return str_replace($tab_rch, $tab_rpl, $data);
	}


	/**
	 * Return a HTML string to diplay an array in a readable fashion.
	 * @param array $data
	 * @param boolean $return_data
	 * @return mixed
	 */
	public function print_r_html($data, $return_data = true)
	{
		$data = print_r($data, true);
		$tab_rch = array("&",		"<",		">",	" ",		"\r\n",		"\r",		"\n");
		$tab_rpl = array("&amp;",	"&lt;",		"&gt;",	"&nbsp;",	"<br>\r",	"<br>\r",	"<br>\r");
		$data = str_replace($tab_rch, $tab_rpl, $data);
		if (!$return_data) {
			echo $data;
		} else {
			return $data;
		}
	}

	/**
	 * Return a text string to diplay an array in a readable fashion.
	 * @param array $data
	 * @param boolean $return_data
	 * @return mixed
	 */
	public function print_r_debug($data, $return_data = true)
	{
		$data = print_r($data, true);
		$tab_rch = array("\r\n",		"\r");
		$tab_rpl = array("\n",			"\n");
		$data = str_replace($tab_rch, $tab_rpl, $data);
		if (!$return_data) {
			echo $data;
		} else {
			return $data;
		}
	}

	/**
	 * Return a PHP script to create an array .
	 * 
	 * @param array $data
	 * @param string $tab
	 * @return string
	 */
	public function print_r_code($data, $tab)
	{
		$str = "Empty";
		if (is_array($data)) {
			$str = "";
			foreach ($data as $key => $value) {
				if (is_array($value)) {
					$j = $tab . "\t";
					$currentBranch = $this->print_r_code($value, $j);
					$str .= $tab . "\"" . $key . "\" => array (\n " . $currentBranch . "\n" . $tab . "),\n";
				} else {
					$str .= $tab . "\"" . $key . "\" => \"" . $value . "\",\n";
				}
			}
			$str = substr($str, 0, -2);
		}
		return $str;
	}

	/**
	 * Return a string describing an array in canonical form.
	 * @param array $data
	 */
	public function arrayToString($data)
	{
		$str = "Empty";
		if (is_array($data)) {
			$str = "array(";
			foreach ($data as $A => $B) {
				if (is_array($B)) {
					$str .= "[" . $A . "]=" . $this->arrayToString($B);
				} elseif (is_object($B)) {
					$str .= "[" . $A . "] is an object named `" . get_class($B) . "`, ";
				} else {
					$str .= "[" . $A . "]=`" . $B . "`, ";
				}
			}
			$str = substr($str, 0, -2) . "), ";
		}
		return $str;
	}

	/**
	 * Returns the HTML code of an array
	 * @param array $data
	 */
	public function arrayToHtmlTable($data, $infos)
	{
		$CurrentSetObj = CurrentSet::getInstance();
		$Block = $CurrentSetObj->ThemeDataObj->getThemeName() . $infos['block'];
		$str = "Empty result";

		// $doHeader = true;
		if (is_array($data)) {
			
			foreach ($data as $resultEntry ) {
				$str = "<table class='" . $Block . _CLASS_TABLE01_ . "' style='width:90%;'>\r";
				// if ($doHeader == true) {
					$tmpCol = reset($resultEntry);
					foreach ($tmpCol as $A => $B ) { $str .= "<td>" . $A . "</td>\r"; }
					$doHeader = false;
				// }
				reset($resultEntry);
				foreach ($resultEntry as $tmpRecord) {
					$str .= "<tr>\r";
					foreach ($tmpRecord as $A => $B) {
						$str .= "<td>" . $B . "</td>\r";
					}
					$str .= "</tr>\r";
				}
				$str .= "</table>\r<br>\r<hr>\r<br>\r";
			}
		}
		return $str;
	}

	/**
	 * Return a string with the $nbr on 2 digits (ex B,1,G => B01G)
	 * @param string $start
	 * @param number $nbr
	 * @param string $end
	 * @return string
	 */
	public function getDecorationBlockName($start, $nbr, $end)
	{
		$a = $start . sprintf("%02u", $nbr) . $end;
		return $a;
	}

	/**
	 * 
	 * @param array $data
	 * @param boolean $return_data
	 * @return mixed
	 */
	public function print_r_hexa($data, $return_data = true)
	{
		foreach ($data as &$a) {
			$str = $a;
			$b = strlen($a);
			$a .= " : ";
			for ($c = 0; $c <= $b; $c++) {
				$a .= dechex(ord($str[$c])) . " ";
			}
		}
		$data = $this->print_r_html($data);
		if (!$return_data) {
			echo $data;
		} else {
			return $data;
		}
	}

	/**
	 * Returns the value selected in a table with $section and $val
	 * @param string $val
	 * @param string $section
	 * @return mixed
	 */
	public function conversionExpression($val, $section)
	{
		return self::$ConvertTable[strtolower($section)][strtolower($val)];
	}


	/**
	 * Converts a value with $section and $val and save into $data[$target]
	 * @param string $val
	 * @param string $section
	 * @return mixed
	 */
	public function conversionExpressionIntoTarget($val, $section, &$data, $target)
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : val=". $val . "; section=" . $section . "; target=" . $target ));
		$data['params'][$target] = self::$ConvertTable[strtolower($section)][strtolower($val)];
	}

	/**
	 * Returns a HTML string 
	 * @param string $expr
	 * @return string
	 */
	public function ConvertToHtml($expr)
	{
		return htmlentities($expr);
	}


	/**
	 * Returns a shorter expression
	 * @param string $expr
	 * @param float $l0
	 * @return string
	 */
	public function shorteningExpression($expr, $l0)
	{
		$ls = strlen($expr);
		$l1 = floor($l0 / 2);
		$l2 = $l1 - 4;
		switch (TRUE) {
			case ($ls < $l1):
				$R = $expr;
				break;
			case ($ls < $l0 && $ls > $l2):
				$R = substr($expr, 0, $l2) . " [...] ";
				break;
			case ($ls > $l0 || $ls == $l0):
				$R = substr($expr, 0, $l2) . " [...] " . substr($expr, ($ls - $l2), $ls);
				break;
		}
		return $R;
	}

	/**
	 * Convert a size in a human readdable fashion
	 * @param array $infos
	 * @param float $size
	 * @return string
	 */
	public function makeSizeHumanFriendly($infos, $size)
	{
		$CurrentSetObj = CurrentSet::getInstance();

		$Block = $CurrentSetObj->ThemeDataObj->getThemeName() . $infos['block'];
		$TabUnits = array(
			"<span class='" . $Block . "_ok'>b</span>",
			"<span class='" . $Block . "_warning'>Kb</span>",
			"<span class='" . $Block . "_erreur " . $Block . "_tb3'>MB</span>",
			"<span class='" . $Block . "_erreur " . $Block . "_tb4'>GB</span>"
		);
		if ($size == 0) {
			return "0<span class='" . $Block . "_erreur " . $Block . "_tb3'>Kb</span>";
		} else {
			if ($size < 0) {
				return "-" . round(abs($size) / pow(1024, ($i = floor(log(abs($size), 1024)))), 2) . " " . $TabUnits[$i];
			} else {
				return round(abs($size) / pow(1024, ($i = floor(log(abs($size), 1024)))), 2) . ' ' . $TabUnits[$i];
			}
		}
	}
}
