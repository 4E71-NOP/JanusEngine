<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

/*JanusEngine-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $bts BaseToolSet                            */
/* @var $CurrentSetObj CurrentSet                   */
/* @var $ClassLoaderObj ClassLoader                 */

/* @var $SqlTableListObj SqlTableList               */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */

/* @var $Content String                             */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*JanusEngine-IDE-end*/

// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_extension_management_p01");

$bts->I18nTransObj->getI18nTransFromDB("uni_extension_management");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_extension_management_p01_");

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : GroupTag=" . $CurrentSetObj->UserObj->getUserEntry('group_tag') ));

// Will be replaced by a proper user permission management.
$permissionOnExtenssion = 0;
$groupList = $CurrentSetObj->UserObj->getGroupList();
// $bts->LMObj->msgLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : GroupList=" . $bts->StringFormatObj->arrayToString($groupList) ));
foreach ($groupList as $A) { if ( $A['group_tag'] == 3) { $permissionOnExtenssion = 1; } }


if ( $permissionOnExtenssion == 1 ) {
	$extensionList = array();
	$extensions_ = array();
	$handle = opendir("extensions/");
	while (false !== ($file = readdir($handle))) {
		if ( $file != "." && $file != ".." && !is_file("extensions/".$file)  ) { $extensionList[] = $file; }
	}

	unset ( $A );
	$i = 0;
	foreach ( $extensionList as $A ) {
		$B = "extensions/".$A."/extension_config.php";
		if ( file_exists ($B) ) { include ($B); }
		else {
			$extensions_['donnees'][$i]['introuvable'] = 1;
			$extensions_['donnees'][$i]['repertoire_vide'] = $A;
		}
		$i++;
	}

	unset ( $A );
	foreach ( $extensions_['donnees'] as &$A ) {
		if ( $A['introuvable'] != 1 ) {
			$dbquery = $bts->SDDMObj->query("
			SELECT ext.* 
			FROM ".$SqlTableListObj->getSQLTableName('extension')." ext 
			WHERE ext.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
			AND ext.extension_name = '".$A['extension_name']."'
			;");
			if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) { $A['extension_etat'] = 1; }
		}
	}

	unset ( $A );
	$i = 1;
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	$T['Content']['1'][$i]['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
	$T['Content']['1'][$i]['5']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_5_txt');
	foreach ( $extensions_['donnees'] as $A ) {
		if ( $A['introuvable'] != 1 ) {
			$i++;
			$T['Content']['1'][$i]['1']['cont'] = $A['extension_name'];
			$T['Content']['1'][$i]['2']['cont'] = $A['extension_version'];
			$T['Content']['1'][$i]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('tab1'.$A['extension_etat']);
			
			$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
				$infos , 'submit', 
				$bts->I18nTransObj->getI18nTransEntry('tab2'.$A['extension_etat']), 64, 
				'installButton', 
				1, 1, 
				"" 
			);
			
			$T['Content']['1'][$i]['4']['style']	= "padding:16px";
			$T['Content']['1'][$i]['4']['cont']		= "
			<form ACTION='index.php?' method='post' name='installForm01'>\r
			<input type='hidden' name='M_EXTENS[extension_name]'		value='".$A['extension_name']."'>\r
			<input type='hidden' name='M_EXTENS[extension_directory]'	value='".$A['extension_directory']."'>\r
			<input type='hidden' name='M_EXTENS[extension_requete]'		value='Installer'>\r
			<input type='hidden' name='uni_gestion_des_extensions_p'	value='".$_REQUEST['uni_gestion_des_modules_p']."'>\r
			". $bts->InteractiveElementsObj->renderSubmitButton($SB).
			"</form>\r";

			$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
				$infos , 'submit', 
				$bts->I18nTransObj->getI18nTransEntry('tab3'.$A['extension_etat']), 64, 
				'deleteButton', 
				2, 2, 
				"" 
			);

			$T['Content']['1'][$i]['5']['style']	= "padding:16px";
			$T['Content']['1'][$i]['5']['cont']		= "<form ACTION='index.php?' method='post' name='Form01'>\r"
			."<input type='hidden' name='formGenericData[origin]'		value='AdminDashboard".$processStep."'>\r"
			."<input type='hidden' name='formGenericData[section]'		value='AdminExtensionManagementP02'>"
			."<input type='hidden' name='formCommand1'					value='".$commandType."'>"
			."<input type='hidden' name='formEntity1'					value='entity'>"
			."<input type='hidden' name='formTarget1[name]'				value='".$A['extension_name']."'>\r"
			."<input type='hidden' name='formGenericData[mode]'			value='".$processTarget."'>\r"
			."<input type='hidden' name='formGenericData[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'selectionId')."'>\r"
			. $bts->InteractiveElementsObj->renderSubmitButton($SB).
			"</form>\r";
		}
		if ( $A['extension_etat'] == 1 ) {
			$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
				$infos , 'submit', 
				$bts->I18nTransObj->getI18nTransEntry('tab3'.$A['extension_etat']), 64, 
				'deleteButton', 
				3, 3, 
				"" 
			);

			$T['Content']['1'][$i]['5']['cont']		= 
			"<form ACTION='index.php?' method='post' name='Form01'>\r"
			."<input type='hidden' name='formGenericData[origin]'				value='AdminDashboard".$processStep."'>\r"
			."<input type='hidden' name='formGenericData[section]'				value='AdminExtensionManagementP02'>"
			."<input type='hidden' name='formCommand1'							value='".$commandType."'>"
			."<input type='hidden' name='formGenericData[extension_directory]'	value='".$A['extension_directory']."'>\r"
			."<input type='hidden' name='formGenericData[extension_requete]'	value='Retirer'>\r"
			."<input type='hidden' name='uni_gestion_des_extensions_p'			value='".$_REQUEST['uni_gestion_des_modules_p']."'>\r"
			.$bts->InteractiveElementsObj->renderSubmitButton($SB)
			."</form>\r";
		}
	}
	
	// --------------------------------------------------------------------------------------------
	//
	//	Display
	//
	//
	// --------------------------------------------------------------------------------------------
	$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
	$T['ContentCfg']['tabs'] = array(
			1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,5,1),
	);
	$Content .= $bts->RenderTablesObj->render($infos, $T);
}
else { $Content .= "!!!!!!!!!!!!!!!!"; }

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/

?>
