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

// --------------------------------------------------------------------------------------------
$application = 'website';
include ("define.php");

include ("engine/utility/ClassLoader.php");
$ClassLoaderObj = ClassLoader::getInstance();

$ClassLoaderObj->provisionClass('Time');
$ClassLoaderObj->provisionClass('LogManagement');
$ClassLoaderObj->provisionClass('Mapper');
$ClassLoaderObj->provisionClass('RequestData');

// Time and memory measurment (with checkpoints)
$TimeObj = Time::getInstance();
$LMObj = LogManagement::getInstance();
$LMObj->setInternalLogTarget(LOG_TARGET);
$MapperObj = Mapper::getInstance();
$RequestDataObj = RequestData::getInstance();
// --------------------------------------------------------------------------------------------
$Content = "";
// --------------------------------------------------------------------------------------------

error_reporting(E_ALL ^ E_NOTICE);
ini_set('log_errors', "On");
ini_set('error_log' , "/var/log/apache2/error.log");
// --------------------------------------------------------------------------------------------
//
//	CurrentSet
//
//
$ClassLoaderObj->provisionClass('ServerInfos');
$ClassLoaderObj->provisionClass('CurrentSet');
$CurrentSetObj = CurrentSet::getInstance();
$CurrentSetObj->setInstanceOfServerInfosObj(new ServerInfos());
$CurrentSetObj->getInstanceOfServerInfosObj()->getInfosFromServer();
$CurrentSetObj->setDataEntry('fsIdx', 0);								//Useful for FileSelector

// --------------------------------------------------------------------------------------------
//	
//	Session management
//	
//	
$ClassLoaderObj->provisionClass('SessionManagement');
// session_name("Hydr_Ws".$RequestDataObj->getRequestDataEntry('sw'));
$CurrentSetObj->setDataEntry('sessionName', 'HydrWebsiteSessionId');
$ClassLoaderObj->provisionClass('ConfigurationManagement');
$CMObj = ConfigurationManagement::getInstance();
$CMObj->InitBasicSettings();
session_name($CurrentSetObj->getDataEntry('sessionName'));
session_start();
$SMObj = SessionManagement::getInstance($CMObj);
$SMObj->CheckSession(); //Does NOT check login & password. 

// --------------------------------------------------------------------------------------------
//
//	Loading the configuration file associated with this website
//
$CMObj->LoadConfigFile();
$CMObj->setConfigurationEntry('execution_context',		"render");
$LMObj->setDebugLogEcho(0);

// --------------------------------------------------------------------------------------------
//
//	Authentification
//
//

// Is user_login is defined and different from 'anonymous' we consider the user is authenticated
if ( strlen($SMObj->getSessionEntry('user_login')) == 0 && $SMObj->getSessionEntry('user_login') != "anonymous") {
	$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "fs.php : \$_SESSION strlen(user_login)=0"));
	$SMObj->ResetSession();
}

// --------------------------------------------------------------------------------------------
//
//	Content
//
//


// http://www.local-hydr.net/current/fs.php
// ?idx=0
// &mode=file
// &formName=UserProfileForm
// &formTargetId=UserProfileForm[user_avatar_image]
// &displayType=fileList
// &strAdd=../
// &strRemove=
// &path=websites-data/www.hydr.net/data/images/avatars/
// &restrictTo=websites-data/www.hydr.net/data/images/avatars/

$ClassLoaderObj->provisionClass('StringFormat');
$StringFormatObj = StringFormat::getInstance();

$entryPoint = $_SERVER['DOCUMENT_ROOT'];
$pathToExplore	= realpath($entryPoint."/".$RequestDataObj->getRequestDataEntry('path'));
$restrictTo		= realpath($entryPoint."/".$RequestDataObj->getRequestDataEntry('restrictTo'));

$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "fs.php brefore : entryPoint=`".$entryPoint."`, pathToExplore=`".$pathToExplore."`, restrictTo=`".$restrictTo."`."));
if ( strpos($pathToExplore,	$restrictTo) === FALSE )	{ $pathToExplore = $restrictTo; }
if ( strpos($pathToExplore,	$entryPoint) === FALSE )	{ $pathToExplore = $entryPoint; }
$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "fs.php   after : entryPoint=`".$entryPoint."`, pathToExplore=`".$pathToExplore."`, restrictTo=`".$restrictTo."`."));

$TfsIdx			= $RequestDataObj->getRequestDataEntry('idx');
$selectionMode	= $RequestDataObj->getRequestDataEntry('mode');
$formName		= $RequestDataObj->getRequestDataEntry('formName');
$formTargetId	= $RequestDataObj->getRequestDataEntry('formTargetId');
$strRemove		= $RequestDataObj->getRequestDataEntry('strRemove');
$strAdd			= $RequestDataObj->getRequestDataEntry('strAdd');
$displayType	= $RequestDataObj->getRequestDataEntry('displayType');

$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "fs.php strAdd=`".$strAdd."`;strRemove=`".$strRemove."`; preg_replace=`".$strAdd.preg_replace($strRemove, '','../../dir/dir/file.php')));

$pos = strrpos ($pathToExplore, "/");
$pathToExploreUp = substr ( $pathToExplore, 0 , $pos); 
$fileList = array();
$fileList[0] = array();
$fileList[1]['.']	= array ("name"	=> ".",		"target"	=> str_replace ($entryPoint, "", $pathToExplore),);
$fileList[1]['..']	= array ("name"	=> "..",	"target"	=> str_replace ($entryPoint, "", $pathToExploreUp),);
// exit();
$handle = opendir($pathToExplore);
$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "exploring : " . $pathToExplore) );
while (false !== ( $f = readdir($handle))) {
	if ( $f != "." && $f != ".." ) {
		$currentFile = $pathToExplore."/".$f;
		if (is_dir($currentFile)) { 
			$fileList[1][$f]['name']	= $f; 
			$fileList[1][$f]['target']	= str_replace ($entryPoint, "" , $currentFile); 
		}
		else {
			if (is_link($currentFile))	{
				$fileList[0][$f]['name'] = $f;
				if (linkinfo($currentFile) != -1 ) {
					$fileList[0][$f]['type']	= 1;
					$fileList[0][$f]['target']	= str_replace ($entryPoint, "" , readlink($currentFile));
				}
				else {
					$fileList[0][$f]['type']	= 2;
					$fileList[0][$f]['target']	= -1;
				}
			}
			else {
				$fileList[0][$f]['name']	= $f;
				$fileList[0][$f]['type']	= 0;
				$fStat = stat($currentFile);
				$fileList[0][$f]['size']	= $fStat['size'];
				$fileList[0][$f]['time']	= strftime ("%a %d %b %y - %H:%M", $fStat['mtime'] );
				$fileList[0][$f]['target']	= str_replace ($entryPoint, "" , $currentFile);
			}
		}
	}
}

sort($fileList[0]);
sort($fileList[1]);
reset($fileList);

$Block = "mt_B01_";

$cell = array(0=>"a",1=>"b");
$i = 0;

// --------------------------------------------------------------------------------------------

// --------------------------------------------------------------------------------------------
unset ($A);

$cellWidth		= 128;
$cellHeight		= 128;
$cellContent	= "";
$ImagePerLine	= 4;

switch ($displayType){
	case "imageMosaic":
		$baseURI = "http://".$_SERVER['HTTP_HOST']."/Hydr/";
		$Content .= "<table class='mt_B01".CLASS_Table01."' style='table-layout: auto; border-spacing: 1px; empty-cells: show; vertical-align: top;'>\r";
		$x = 0;
		foreach ( $fileList[1] as $A ) {
			if ($x == 0) { $Content .= "<tr>\r"; }
			$Content .= "<td  
				style='
				width:".$cellWidth."px; height:".$cellHeight."px; 
				vertical-align:middle; text-align:center; 
				border-style:solid; border-width:1px; border-color:#00000080; 
				background-image: url(".$baseURI."graph/universal/uni_directory.png); background-size: cover; 
				' 
				onClick=\"fs.getDirectoryContent ( tableFileSelector[".$TfsIdx."], '".$A['target']."', 1)\">
				[".$A['name']."]
				</td>\r";
			$x++;
			if ( $x > $ImagePerLine ) { 
				$Content .= "</tr>\r";
				$x = 0;
			}
		}
		
		unset ($A);
		foreach ( $fileList[0] as $A ) {
			if ($x == 0) { $Content .= "<tr>\r"; }
			$target = (strlen($strRemove) > 0) ? $strAdd.preg_replace($strRemove, '', $A['target']) : $strAdd.$A['target'];
			
			if ( preg_match('/(\.jpg|\.jpeg|\.png|\.gif)/',$A['target'])) {
				$Content .= "<td 
					style='
					border-style:solid; border-width:1px; border-color:#00000080;
					background-color:#00000040;
					width:".$cellWidth."px; height:".$cellHeight."px;
					vertical-align:middle; text-align:center;
					' 
					onClick=\"elm.SetFormInputValue ( '".$formName."' , '".$formTargetId."', '".$target."' ); elm.SwitchDisplay('FileSelectorDarkFade'); elm.SwitchDisplay('FileSelectorFrame');\">
					<img style='max-width: ".$cellWidth."px; max-height:".$cellHeight."px' src='".$baseURI.$A['target']."'>
					</td>\r";
			}
			else {
				$Content .= "<td 
					style='
					border-style:solid; border-width:1px; border-color:#00000080;
					background-color:#00000040;
					width:".$cellWidth."px; height:".$cellHeight."px;
					vertical-align:middle; text-align:center;
					' 
					onClick=\"elm.SetFormInputValue ( '".$formName."' , '".$formTargetId."', '".$target."' );elm.SwitchDisplay('FileSelectorDarkFade'); elm.SwitchDisplay('FileSelectorFrame');\">
					".$A['name']."
					</td>\r";
			}
			$x++;
			if ( $x > $ImagePerLine ) {
				$Content .= "</tr>\r";
				$x = 0;
			}
		}
		if ( $x < $ImagePerLine ) {
			for ($i=$x; $i < $ImagePerLine; $i++ ){ $Content .= "<td></td>\r"; }
			$Content .= "</tr>\r";
		}
		
		break;


// --------------------------------------------------------------------------------------------
	case "fileList":
		$Content .= "<table class='mt_B01".CLASS_Table01."' style='table-layout: auto; border-spacing: 1px; empty-cells: show; vertical-align: top;' width='100%'>\r";
		$scoreMode = ($selectionMode == 'file') ? 0:4;
		$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "fs.php selectionMode=`".$selectionMode."`;scoreMode=`".$scoreMode."`."));
		
		foreach ( $fileList[1] as $A ) {
			$target = (strlen($strRemove) > 0) ? $strAdd.preg_replace($strRemove, '', $A['target']) : $strAdd.$A['target'];
			switch ($scoreMode) {
				case 0:
					$Content .= "<tr><td  onClick=\"fs.getDirectoryContent ( tableFileSelector[".$TfsIdx."], '".$A['target']."', 1)\">[".$A['name']."]</td><td>&nbsp;</td><td>&nbsp;</td></tr>\r";
					break;
				case 4:
					$Content .= "<tr><td width='65%' onClick=\"elm.SetFormInputValue ( '".$formName."' , '".$formTargetId."', '".$target."' ); elm.SwitchDisplay('FileSelectorDarkFade'); elm.SwitchDisplay('FileSelectorFrame');\">[".$A['name']."]</td><td width='10%'>".$A['size']."</td><td>".$A['time']."</td></tr>\r";
					break;
			}
			$i ^= 1;
		}
		
		foreach ( $fileList[0] as $A ) {
			$target = (strlen($strRemove) > 0) ? $strAdd.preg_replace($strRemove, '', $A['target']) : $strAdd.$A['target'];
			$score = $scoreMode + $A['type'];
			switch ($score) {
				//	File section
				case 0:
					$Content .= "<tr><td width='65%' onClick=\"elm.SetFormInputValue ( '".$formName."' , '".$formTargetId."', '".$target."' ); elm.SwitchDisplay('FileSelectorDarkFade'); elm.SwitchDisplay('FileSelectorFrame');\">".$A['name']."</td><td width='10%'>".$A['size']."</td><td>".$A['time']."</td></tr>\r";
					break;
				case 1:
					$Content .= "<tr class='".$Block.CLASS_Txt_Warning."'><td width='65%'>".$A['name']."</td><td width='10%'></td><td width='25%'>".$A['time']."</td></tr>\r";
					"<i>".$A['name']."</i>(".$A['target'].")<br>";
					break;
				case 2:
					$Content .= "<tr class='".$Block.CLASS_Txt_Error."'><td width='65%'>".$A['name']."</td><td width='10%'></td><td width='25%'>".$A['time']."</td></tr>\r";
					break;
					
					//	Directory section
				case 4:
					$Content .= "<tr><td width='65%'>".$cellContent."</td><td width='10%'>".$A['size']."</td><td>".$A['time']."</td></tr>\r";
					break;
				case 5:
					$Content .= "<tr class='".$Block.CLASS_Txt_Warning."'><td width='65%'>".$A['name']."</td><td width='10%'></td><td width='25%'>".$A['time']."</td></tr>\r";
					"<i>".$A['name']."</i>(".$A['target'].")<br>";
					break;
				case 6:
					$Content .= "<tr class='".$Block.CLASS_Txt_Error."'><td width='65%'>".$A['name']."</td><td width='10%'></td><td width='25%'>".$A['time']."</td></tr>\r";
					break;
			}
			$i ^= 1;
		}
		break;
}




$Content .= "</table>\r";

echo ($Content);
?>
