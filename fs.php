<?php
/* JanusEngine-license-start */
// --------------------------------------------------------------------------------------------
//
// Janus Engine - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* JanusEngine-license-end */
class FileSelectorRender
{
	private static $Instance = null;
	private function __construct() {}

	/**
	 * Singleton : Will return the instance of this class.
	 *
	 * @return FileSelectorRender
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new FileSelectorRender();
		}
		return self::$Instance;
	}

	/**
	 * Renders the whole thing.
	 * The choice of making a main class is to help IDEs to process sources.
	 *
	 * @return string
	 */
	public function render()
	{
		session_name("JanusEngineWebsiteSessionId");
		session_start();

		$application = 'FileSelector';
		include("current/define.php");

		include("current/engine/utility/ClassLoader.php");
		$ClassLoaderObj = ClassLoader::getInstance();

		$ClassLoaderObj->provisionClass('BaseToolSet'); // First of them all as it is used by others.
		$bts = BaseToolSet::getInstance();

		$bts->LMObj->setDebugLogEcho(1);
		$bts->LMObj->setVectorInternal(false);
		$bts->LMObj->setVectorSystemLog(true);
		$bts->CMObj->InitBasicSettings();

		// $ClassLoaderObj->provisionClass ( 'SessionManagement' );
		// $bts->initSmObj ();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_DEBUG_LVL0, 'msg' => "*** index.php : \$_SESSION :" . $bts->StringFormatObj->arrayToString($_SESSION) . " *** \$SMObj->getSession() = " . $bts->StringFormatObj->arrayToString($bts->SMObj->getSession()) . " *** EOL"));

		// 		$ClassLoaderObj->provisionClass ( 'WebSite' );

		// --------------------------------------------------------------------------------------------
		$RequestDataObj = RequestData::getInstance();
		$Content = "";
		// --------------------------------------------------------------------------------------------
		error_reporting(E_ALL ^ E_NOTICE);
		ini_set('log_errors', "On");
		ini_set('error_log', "/var/log/apache2/error.log");
		ini_set('display_errors', 0);
		error_log("********** JanusEngine FileSelector Begin **********");

		// --------------------------------------------------------------------------------------------
		//
		// CurrentSet
		//
		//
		$ClassLoaderObj->provisionClass('ServerInfos');
		$ClassLoaderObj->provisionClass('CurrentSet');
		$CurrentSetObj = CurrentSet::getInstance();
		$CurrentSetObj->setServerInfosObj(new ServerInfos());
		$CurrentSetObj->ServerInfosObj->getInfosFromServer();
		$CurrentSetObj->setDataEntry('fsIdx', 0); // Useful for FileSelector
		$CurrentSetObj->setDataEntry('ws', 'JnsEng');

		// --------------------------------------------------------------------------------------------
		//
		// Session management
		//
		//
		$ClassLoaderObj->provisionClass('SessionManagement');
		$CurrentSetObj->setDataEntry('sessionName', 'JanusEngineWebsiteSessionId');
		$ClassLoaderObj->provisionClass('ConfigurationManagement');
		$bts->CMObj->InitBasicSettings();

		$bts->initSmObj();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . $bts->SMObj->getInfoSessionState()));
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_DEBUG_LVL0, 'msg' => __METHOD__ . " : \$_SESSION :" . $bts->StringFormatObj->arrayToString($_SESSION) . " *** \$bts->SMObj->getSession() = " . $bts->StringFormatObj->arrayToString($bts->SMObj->getSession()) . " *** EOL"));

		// --------------------------------------------------------------------------------------------
		//
		// Loading the configuration file associated with this website
		//

		$bts->CMObj->LoadConfigFile();
		// $bts->CMObj->setConfigurationEntry('execution_context', "render");
		$bts->CMObj->setExecutionContext("render");
		$bts->LMObj->setDebugLogEcho(0);

		// --------------------------------------------------------------------------------------------
		//
		// Authentification
		//
		//

		// Is user_login is defined and different from 'anonymous' we consider the user is authenticated
		if (strlen($bts->SMObj->getSessionEntry('user_login') ?? '') == 0 && $bts->SMObj->getSessionEntry('user_login') != "anonymous") {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "fs.php : \$_SESSION strlen(user_login)=0"));
			$bts->SMObj->ResetSession();
		}

		// --------------------------------------------------------------------------------------------
		//
		// Content
		//
		//

		// http://www.local-janus-engine.com/current/fs.php
		// ?idx=0
		// &mode=file
		// &formName=UserProfileForm
		// &formTargetId=UserProfileForm[user_avatar_image]
		// &displayType=fileList
		// &strAdd=../
		// &strRemove=
		// &path=websites-data/www.janus-engine.net/data/images/avatars/
		// &restrictTo=websites-data/www.janus-engine.net/data/images/avatars/

		$ClassLoaderObj->provisionClass('StringFormat');

		$entryPoint = $_SERVER['DOCUMENT_ROOT'];
		$pathToExplore = realpath($entryPoint . "/" . $RequestDataObj->getRequestDataEntry('path'));
		$restrictTo = realpath($entryPoint . "/" . $RequestDataObj->getRequestDataEntry('restrictTo'));

		$bts->LMObj->msgLog(array(
			'level' => LOGLEVEL_STATEMENT,
			'msg' => "fs.php brefore : entryPoint=`" . $entryPoint . "`, pathToExplore=`" . $pathToExplore . "`, restrictTo=`" . $restrictTo . "`."
		));
		if (strpos($pathToExplore, $restrictTo) === FALSE) {
			$pathToExplore = $restrictTo;
		}
		if (strpos($pathToExplore, $entryPoint) === FALSE) {
			$pathToExplore = $entryPoint;
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "fs.php   after : entryPoint=`" . $entryPoint . "`, pathToExplore=`" . $pathToExplore . "`, restrictTo=`" . $restrictTo . "`."));

		$TfsIdx = $RequestDataObj->getRequestDataEntry('idx');
		$selectionMode = $RequestDataObj->getRequestDataEntry('mode');
		$formName = $RequestDataObj->getRequestDataEntry('formName');
		$formTargetId = $RequestDataObj->getRequestDataEntry('formTargetId');
		$strRemove = $RequestDataObj->getRequestDataEntry('strRemove');
		$strAdd = $RequestDataObj->getRequestDataEntry('strAdd');
		$displayType = $RequestDataObj->getRequestDataEntry('displayType');

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "fs.php strAdd=`" . $strAdd . "`;strRemove=`" . $strRemove . "`; preg_replace=`" . $strAdd . preg_replace($strRemove, '', '../../dir/dir/file.php')));

		$pos = strrpos($pathToExplore, "/");
		$pathToExploreUp = substr($pathToExplore, 0, $pos);
		$fileList = array();
		$fileList['0'] = array();
		$fileList['1']['.']		= array("name" => ".",		"target" => str_replace($entryPoint, "", $pathToExplore));
		$fileList['1']['..']		= array("name" => "..",	"target" => str_replace($entryPoint, "", $pathToExploreUp));
		// exit();
		$handle = opendir($pathToExplore);
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " exploring : " . $pathToExplore));
		while (false !== ($f = readdir($handle))) {
			if ($f != "." && $f != "..") {
				$currentFile = $pathToExplore . "/" . $f;
				if (is_dir($currentFile)) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " exploring : " . $currentFile . " is a directory."));
					$fileList['1'][$f]['name'] = $f;
					$fileList['1'][$f]['target'] = str_replace($entryPoint, "", $currentFile);
				} else {
					if (is_link($currentFile)) {
						$fileList['0'][$f]['name'] = $f;
						$linkTargetPath = $pathToExplore . "/" . readlink($currentFile);
						if (file_exists($linkTargetPath)) {
							$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " exploring : " . $currentFile . " is a valid link (" . $linkTargetPath . ")."));
							$fileList['0'][$f]['type'] = 1;
						} else {
							$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " exploring : " . $currentFile . " is a bad link.(" . $linkTargetPath . ")."));
							$fileList['0'][$f]['type'] = 2;
						}
						$fileList['0'][$f]['target'] = str_replace($entryPoint, "", readlink($currentFile));
					} else {
						$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " exploring : " . $currentFile . " is a regular file."));
						$fileList['0'][$f]['name'] = $f;
						$fileList['0'][$f]['type'] = 0;
						$fileList['0'][$f]['target'] = str_replace($entryPoint, "", $currentFile);
					}

					$fStat = stat($currentFile);
					$fileList['0'][$f]['size'] = $fStat['size'];
					$fileList['0'][$f]['time'] = date("Y-m-d H:i:s", $fStat['mtime']);
				}
			}
		}

		sort($fileList['0']);
		sort($fileList['1']);
		reset($fileList);

		$Block = "mt_B01";

		$i = 0;

		// --------------------------------------------------------------------------------------------

		// --------------------------------------------------------------------------------------------
		// 		unset ( $A );

		$cellWidth = 128;
		$cellHeight = 128;
		$cellContent = "";
		$ImagePerLine = 4;

		switch ($displayType) {
			case "imageMosaic":
				$baseURI = "http://" . $_SERVER['HTTP_HOST'] . "/";
				$Content .= "<table class='" . $Block . _CLASS_TABLE01_ . "' style='table-layout: auto; border-spacing: 1px; empty-cells: show; vertical-align: top;'>\r";
				$x = 0;
				foreach ($fileList[1] as $A) {
					if ($x == 0) {
						$Content .= "<tr>\r";
					}
					$Content .= "<td  
				style='
				width:" . $cellWidth . "px; height:" . $cellHeight . "px; 
				vertical-align:middle; text-align:center; 
				border-style:solid; border-width:1px; border-color:#00000080; 
				background-image: url(" . $baseURI . "media/img/universal/uni_directory.png); background-size: cover; 
				' 
				onClick=\"fs.getDirectoryContent ( tableFileSelector[" . $TfsIdx . "], '" . $A['target'] . "', 1)\">
				[" . $A['name'] . "]
				</td>\r";
					$x++;
					if ($x > $ImagePerLine) {
						$Content .= "</tr>\r";
						$x = 0;
					}
				}

				unset($A);
				foreach ($fileList[0] as $A) {
					if ($x == 0) {
						$Content .= "<tr>\r";
					}
					$target = (strlen($strRemove) > 0) ? $strAdd . preg_replace($strRemove, '', $A['target']) : $strAdd . $A['target'];

					if (preg_match('/(\.jpg|\.jpeg|\.png|\.gif)/', $A['target'])) {
						$Content .= "<td 
					style='
					border-style:solid; border-width:1px; border-color:#00000080;
					background-color:#00000040;
					width:" . $cellWidth . "px; height:" . $cellHeight . "px;
					vertical-align:middle; text-align:center;
					' 
					onClick=\"elm.SetFormInputValue ( '" . $formName . "' , '" . $formTargetId . "', '" . $target . "' ); elm.SwitchDisplay('FileSelectorDarkFade'); elm.SwitchDisplay('FileSelectorFrame');\">
					<img style='max-width: " . $cellWidth . "px; max-height:" . $cellHeight . "px' src='" . $baseURI . $A['target'] . "'>
					</td>\r";
					} else {
						$Content .= "<td 
					style='
					border-style:solid; border-width:1px; border-color:#00000080;
					background-color:#00000040;
					width:" . $cellWidth . "px; height:" . $cellHeight . "px;
					vertical-align:middle; text-align:center;
					' 
					onClick=\"elm.SetFormInputValue ( '" . $formName . "' , '" . $formTargetId . "', '" . $target . "' );elm.SwitchDisplay('FileSelectorDarkFade'); elm.SwitchDisplay('FileSelectorFrame');\">
					" . $A['name'] . "
					</td>\r";
					}
					$x++;
					if ($x > $ImagePerLine) {
						$Content .= "</tr>\r";
						$x = 0;
					}
				}
				if ($x < $ImagePerLine) {
					for ($i = $x; $i < $ImagePerLine; $i++) {
						$Content .= "<td></td>\r";
					}
					$Content .= "</tr>\r";
				}

				break;

				// --------------------------------------------------------------------------------------------
			case "fileList":
				$Content .= "<table class='" . $Block . _CLASS_TABLE01_ . "' style='table-layout: auto; border-spacing: 1px; empty-cells: show; vertical-align: top;' width='100%'>\r";
				$scoreMode = ($selectionMode == 'file') ? 0 : 4;
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "fs.php selectionMode=`" . $selectionMode . "`;scoreMode=`" . $scoreMode . "`."));

				foreach ($fileList['1'] as $A) {
					$target = (strlen($strRemove) > 0) ? $strAdd . preg_replace($strRemove, '', $A['target']) : $strAdd . $A['target'];
					switch ($scoreMode) {
						case 0:
							$Content .= "<tr><td style='font-weight:bold;'onClick=\"fs.getDirectoryContent ( tableFileSelector[" . $TfsIdx . "], '" . $A['target'] . "', 1)\">[" . $A['name'] . "]</td><td>&nbsp;</td><td>&nbsp;</td></tr>\r";
							break;
						case 4:
							$Content .= "<tr><td width='65%' onClick=\"elm.SetFormInputValue ( '" . $formName . "' , '" . $formTargetId . "', '" . $target . "' ); elm.SwitchDisplay('FileSelectorDarkFade'); elm.SwitchDisplay('FileSelectorFrame');\">[" . $A['name'] . "]</td><td width='10%'>" . $A['size'] . "</td><td>" . $A['time'] . "</td></tr>\r";
							break;
					}
					$i ^= 1;
				}

				foreach ($fileList['0'] as $A) {
					$target = (strlen($strRemove) > 0) ? $strAdd . preg_replace($strRemove, '', $A['target']) : $strAdd . $A['target'];
					$score = $scoreMode + $A['type'];
					switch ($score) {
							// File section
						case 0:
							$Content .= "<tr><td width='65%' onClick=\"elm.SetFormInputValue ( '" . $formName . "' , '" . $formTargetId . "', '" . $target . "' ); elm.SwitchDisplay('FileSelectorDarkFade'); elm.SwitchDisplay('FileSelectorFrame');\">" . $A['name'] . "</td><td width='10%'>" . $A['size'] . "</td><td>" . $A['time'] . "</td></tr>\r";
							break;
						case 1:
							$Content .= "<tr><td class='" . $Block . _CLASS_TXT_OK_ . "' width='65%'>" . $A['name'] . " -> (<i>" . $A['target'] . "</i>)</td><td width='10%'>" . $A['size'] . "</td><td width='25%'>" . $A['time'] . "</td></tr>\r";
							"<i>" . $A['name'] . "</i>(" . $A['target'] . ")<br>";
							break;
						case 2:
							$Content .= "<tr><td class='" . $Block . _CLASS_TXT_ERROR_ . "' width='65%'>" . $A['name'] . " -> (<i>" . $A['target'] . "</i>)</td><td width='10%'>" . $A['size'] . "</td><td width='25%'>" . $A['time'] . "</td></tr>\r";
							break;

							// Directory section
						case 4:
							$Content .= "<tr><td width='65%'>" . $cellContent . "</td><td width='10%'>" . $A['size'] . "</td><td>" . $A['time'] . "</td></tr>\r";
							break;
						case 5:
							$Content .= "<tr><td class='" . $Block . _CLASS_TXT_OK_ . "' width='65%'>" . $A['name'] . " -> (<i>" . $A['target'] . "</i>)</td><td width='10%'>" . $A['size'] . "</td><td width='25%'>" . $A['time'] . "</td></tr>\r";
							"<i>" . $A['name'] . "</i>(" . $A['target'] . ")<br>";
							break;
						case 6:
							$Content .= "<tr><td class='" . $Block . _CLASS_TXT_ERROR_ . "' width='65%'>" . $A['name'] . " -> (<i>" . $A['target'] . "</i>)</td><td width='10%'>" . $A['size'] . "</td><td width='25%'>" . $A['time'] . "</td></tr>\r";
							break;
					}
					$i ^= 1;
				}
				break;
		}

		$Content .= "</table>\r";

		return ($Content);
	}
}
// --------------------------------------------------------------------------------------------
$fs = FileSelectorRender::getInstance();
echo ($fs->render());

if (session_write_close() === false) {
	$bts = BaseToolSet::getInstance();
	$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => $bts->SMObj->getInfoSessionState()));
	$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => "session_write_close() returned false. Something went wrong."));
}
