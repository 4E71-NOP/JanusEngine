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

class LayoutProcessor {
	private static $Instance = null;
	private static $LayoutProcessor = null;

	public function __construct() {}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return LayoutProcessor
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new LayoutProcessor ();
		}
		return self::$Instance;
	}
	
	/**
	 * Returns an array containing the content chunks and the "to be rendered module" information
	 * 
	 * It gets the layout information in DB, then loads the file, parse it and return the array for future processing.
	 * We stop before rendering the module in order to seprate things (generally speaking) and to stay closer to the root level. 
	 * @return array
	 */
	public function render(){
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

		$layoutFileObj->getDataFromDB(1); // first one
		$targetFilneName = $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('current_dir')."/"._LAYOUTS_DIRECTORY_ . $layoutFileObj->getLayoutFileEntry('layoutfile_filename');
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : layout filename `".$targetFilneName."`") );

		$fileContentObj->setFileContent( $fileUtilObj->getFileContent($targetFilneName));
		$map = $layoutParserObj->getFragments($fileContentObj->getFileContent());
		// foreach ( $map as $A ) {
		// 	$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Map[] = ".$A['type']." / `".$A['data']."`") );
		// }
		return ($map);
	}
}
?>