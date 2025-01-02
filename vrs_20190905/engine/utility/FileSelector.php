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
//	Module : FileSelector
// --------------------------------------------------------------------------------------------

class FileSelector {
	private static $Instance = null;
	
	public function __construct(){}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new FileSelector();
		}
		return self::$Instance;
	}

	/**
	 * Returns the fileSelector content
	 * @param array $infos
	 * @return string
	 */
	public function render (&$infos) {
		$bts = BaseToolSet::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;		// we use it this way for syntaxic ease. instead of $CurrentSetObj->ThemeDataObj->xxxx()
		$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;
		
		$Content = "";
		$zIndex = 500;
		
		
// 		switch ($CurrentSetObj->getDataEntry('language_id')) {
// 			case 38:
// 				$bts->I18nTransObj->setI18nEntry('FileSelector', 
// 					array(
// 					"title"	=> "File selector",
// 					"c1"	=> "Name",
// 					"c2"	=> "Size",
// 					"c3"	=> "Date",
// 					)
// 				);
// 				break;
// 			case 48:
// 				$bts->I18nTransObj->setI18nEntry('FileSelector',
// 					array(
// 						"title"	=> "Sélecteur de fichier",
// 						"c1"	=> "Nom",
// 						"c2"	=> "Taille",
// 						"c3"	=> "Date",
// 					)
// 				);
				
// 				break;
// 		}
		
		$Content.= "
			<div id='FileSelectorDarkFade'
			class ='".$ThemeDataObj->getThemeName()."FileSelectorContainer'
			style='display:none; visibility:hidden; z-index:".$zIndex.";'
			OnClick=\"elm.wpsa[0][de.cliEnv.browser.support](); elm.Hide( this.id ); elm.Hide('FileSelectorFrame');\">\r
			</div>\r
			
			<div id='FileSelectorFrame'
			class ='".$ThemeDataObj->getThemeName()."FileSelector'
			style='left:10px;		top:10px;
			width:75%;	height:50%;
			display:none; visibility:hidden; z-index:".($zIndex+1).";
			line-height:normal; overflow:auto;
			background-color:#000000C0;'>\r
			
			<div id='FileSelectorCaption'>
			
			<table class='".$infos['block']._CLASS_TABLE01_." ".$infos['block']._CLASS_TBL_LGND_TOP_."' style='width='100%;'>\r
			<caption>".$bts->I18nTransObj->getI18nTransEntry('fileSelectorTitle')."</caption>\r
			</tr>\r
			<tr>\r
			<td width='65%'>".$bts->I18nTransObj->getI18nTransEntry('fileSelectorC1')."</td>\r
			<td width='10%'>".$bts->I18nTransObj->getI18nTransEntry('fileSelectorC2')."</td>\r
			<td width='25%'>".$bts->I18nTransObj->getI18nTransEntry('fileSelectorC3')."</td>\r
			</tr>\r
			</table>\r
			
			</div>\r
			<div id='FileSelectorLines'>
			</div>\r
			
			</div>\r
		";
		
		$Uri = $_SERVER['REQUEST_URI'];
		$RootUri = strpos( $_SERVER['REQUEST_URI'] , "/index.php" );
		$Uri = substr ( $_SERVER['REQUEST_URI'] , 0 , $RootUri );
		
		$GeneratedScriptObj->insertString('JavaScript-File' , "current/engine/javascript/FileSelector.js");
		$GeneratedScriptObj->insertString('JavaScript-Data' , "var RequestURI = \"".$Uri. "\";");
		$GeneratedScriptObj->insertString('JavaScript-Init' , "var fs = new FileSelector('FileSelectorLines');");
		
		unset ( $ThemeDataObj , $GeneratedScriptObj );
		return $Content;
	}
}

?>