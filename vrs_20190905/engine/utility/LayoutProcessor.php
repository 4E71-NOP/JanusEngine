<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

class LayoutProcessor
{
	private static $Instance = null;
	private static $LayoutProcessor = null;

	public function __construct() {}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return LayoutProcessor
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new LayoutProcessor();
		}
		return self::$Instance;
	}

	/**
	 * Returns an array containing the content chunks and the "to be rendered module" information
	 * 
	 * WE CONSIDER THE ARTICLE AND THEME ARE LOADED IN $CurrentSetObj
	 * 
	 * It gets the layout information in DB, then loads the file, parse it and return the array for future processing.
	 * We stop before rendering the module in order to seprate things (generally speaking) and to stay closer to the root level. 
	 * @return array
	 */
	public function render()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass('LayoutParser');
		$ClassLoaderObj->provisionClass('FileUtil');
		$ClassLoaderObj->provisionClass('FileContent');
		$ClassLoaderObj->provisionClass('LayoutFile');

		$fileUtilObj = FileUtil::getInstance();
		$layoutParserObj = LayoutParser::getInstance();
		$fileContentObj = FileContent::getInstance();
		$layoutFileObj = new LayoutFile();

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$SqlTableListObj = $CurrentSetObj->SqlTableListObj;

		$sqlQuery = "
		SELECT lfi.layout_file_id, lfi.layout_file_filename, lyt.layout_id, lth.fk_theme_id, tw.fk_ws_id 
		FROM "
			. $SqlTableListObj->getSQLTableName('layout_file') . " lfi, "
			. $SqlTableListObj->getSQLTableName('layout') . " lyt, "
			. $SqlTableListObj->getSQLTableName('layout_theme') . " lth, "
			. $SqlTableListObj->getSQLTableName('theme_website') . " tw 
		WHERE lyt.layout_generic_name = '" . $CurrentSetObj->ArticleObj->getArticleEntry('layout_generic_name') . "'
		AND lyt.fk_layout_file_id = lfi.layout_file_id 
		AND lyt.layout_id = lth.fk_layout_id
		AND lth.fk_theme_id = tw.fk_theme_id
		AND tw.fk_theme_id = '" . $CurrentSetObj->ThemeDescriptorObj->getThemeDescriptorEntry('theme_id') . "'
		AND tw.fk_ws_id = '" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id') . "'
		;";

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " `" . $bts->StringFormatObj->formatToLog($sqlQuery) . "`."));
		$dbquery = $bts->SDDMObj->query($sqlQuery);

		$finalFileName = "";
		if ($bts->SDDMObj->num_row_sql($dbquery) > 0) {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$layout_id = $dbp['layout_file_id'];
			}
			$layoutFileObj->getDataFromDB($layout_id);

			$finalFileName = $layoutFileObj->getLayoutFileEntry('layout_file_filename');
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Associated layout filename `" . $finalFileName . "`"));
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : No result returned for layout generic name '" . $CurrentSetObj->ArticleObj->getArticleEntry('layout_generic_name') . "'"));
		}

		$UserObj = $CurrentSetObj->UserObj;
		if ($UserObj->getUserEntry('user_login') != "anonymous") {
			$finalFileName = str_replace(".lyt.html", "_connected.lyt.html", $finalFileName);
		}

		$targetFilneName = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('current_dir') . "/" . _LAYOUTS_DIRECTORY_ . $finalFileName;
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Processing file :'" . $targetFilneName . "'"));

		$fileContentObj->setFileContent($fileUtilObj->getFileContent($targetFilneName));

		if ($fileContentObj->getFileContent() === false) {
			$targetFilneName = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('current_dir') . "/" . _LAYOUTS_DIRECTORY_ . "default/default.lyt.html";
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " : Layout file not found. Back to default layout filename `" . $targetFilneName . "`"));
			$fileContentObj->setFileContent($fileUtilObj->getFileContent($targetFilneName));
		}

		$map = $layoutParserObj->getFragments($fileContentObj->getFileContent());
		// foreach ( $map as $A ) {
		// 	$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Map[] = ".$A['type']." / `".$A['data']."`") );
		// }
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));

		return ($map);
	}

	/**
	 * Returns an array containing the content chunks and the "to be rendered module" information
	 * This one is specific to the install process
	 * 
	 */

	public function installRender($targetFilneName)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();

		$ClassLoaderObj->provisionClass('LayoutParser');
		$ClassLoaderObj->provisionClass('FileUtil');
		$ClassLoaderObj->provisionClass('FileContent');
		// $ClassLoaderObj->provisionClass('LayoutFile');

		$fileUtilObj = FileUtil::getInstance();
		$layoutParserObj = LayoutParser::getInstance();
		$fileContentObj = FileContent::getInstance();
		//		$layoutFileObj = new LayoutFile();

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : layout filename `" . $targetFilneName . "`"));
		$targetFilneName = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('current_dir') . "/" . _LAYOUTS_DIRECTORY_ . $targetFilneName;
		$fileContentObj->setFileContent($fileUtilObj->getFileContent($targetFilneName));
		$map = $layoutParserObj->getFragments($fileContentObj->getFileContent());
		return ($map);
	}
}
