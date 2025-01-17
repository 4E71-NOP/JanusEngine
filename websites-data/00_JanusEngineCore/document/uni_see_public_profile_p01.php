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
/* @var $cs CommonSystem                            */
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

// $RequestDataObj->setRequestDataEntry('script_source',"");
$bts->RequestDataObj->setRequestDataEntry('publicProfil',
		array(
				'userLogin' => "dieu",
				'userId' => 1,
		),
);
/*JanusEngine-Content-Begin*/

$bts->mapSegmentLocation(__METHOD__, "uni_see_public_profile_p01");

switch ($l) {
	case "fra":
		$i18nDoc = array(
		"invite1"		=>	"Fiche utilisateur",
		"cell_1_txt"	=>	"Informations",
		"l_1_txt"		=> "Login",
		"l_2_txt"		=> "Avatar",
		"l_3_txt"		=> "Inscription",
		);
		break;
	case "eng":
		$i18nDoc = array(
		"invite1"		=>	"User profile",
		"cell_1_txt"	=>	"Informations",
		"l_1_txt"		=> "Login",
		"l_2_txt"		=> "Avatar",
		"l_3_txt"		=> "Subscribed",
		);
		break;
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$currentUserObj = new User();
$currentUserObj->getDataFromDBUsingLogin($bts->RequestDataObj->getRequestDataSubEntry('publicProfil', 'userLogin'), $WebSiteObj);

$T = array();
$T['Content']['1']['1']['1']['cont'] = $i18nDoc['l_1_txt'];
$T['Content']['1']['2']['1']['cont'] = $i18nDoc['l_2_txt'];
$T['Content']['1']['3']['1']['cont'] = $i18nDoc['l_3_txt'];

$T['Content']['1']['1']['2']['cont'] = $currentUserObj->getUserEntry('user_login');
$T['Content']['1']['2']['2']['cont'] = "<img src='".$currentUserObj->getUserEntry('user_avatar_image')."' width='128' height='128' alt='Avatar'>";
$T['Content']['1']['3']['2']['cont'] = $bts->TimeObj->timestampToDate($currentUserObj->getUserEntry('user_subscription_date'));
// $RenderLayoutObj = RenderLayout::getInstance();
$T['ContentInfos']['EnableTabs']		= 1;
$T['ContentInfos']['NbrOfTabs']			= 1;
$T['ContentInfos']['TabBehavior']		= 0;
$T['ContentInfos']['RenderMode']		= 1;
$T['ContentInfos']['HighLightType']		= 0;
$T['ContentInfos']['Height']			= "70%";
$T['ContentInfos']['Width']				= $ThemeDataObj->getDefinitionValue('module_internal_width');
$T['ContentInfos']['GroupName']			= "list";
$T['ContentInfos']['CellName']			= "user";
$T['ContentInfos']['DocumentName']		= "doc";
$T['ContentInfos']['cell_1_txt']		= $i18nDoc['cell_1_txt'];

$T['ContentCfg']['tabs']['1']['NbrOfLines']	= 3;	$T['ContentCfg']['tabs']['1']['NbrOfCells']	= 2;	$T['ContentCfg']['tabs']['1']['TableCaptionPos']		= 2;


$config = array(
		"mode" => 1,
		"module_display_mode" => "normal",
		"module_z_index" => 2,
		"block"		=> $infos['block'],
		"blockG"	=> $infos['block']."G",
		"blockT"	=> $infos['block']."T",
		"deco_type"	=> 50,
		"module"	=> $infos['module'],
);
$Content .= $bts->RenderTablesObj->render($config, $T);

$bts->segmentEnding(__METHOD__);

/*JanusEngine-Content-End*/
?>
