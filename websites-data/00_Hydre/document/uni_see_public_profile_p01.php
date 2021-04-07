<?php
/*Hydre-licence-begin*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
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
/*Hydre-IDE-end*/

// $RequestDataObj->setRequestDataEntry('script_source',"");
$bts->RequestDataObj->setRequestDataEntry('publicProfil',
		array(
				'userLogin' => "dieu",
				'userId' => 1,
		),
);
/*Hydre-contenu_debut*/
$localisation = " / uni_see_public_profile_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_see_public_profile_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_see_public_profile_p01.php");

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
$currentUserObj->getUserDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('publicProfil', 'userLogin'), $WebSiteObj);

$T = array();
$T['AD']['1']['1']['1']['cont'] = $i18nDoc['l_1_txt'];
$T['AD']['1']['2']['1']['cont'] = $i18nDoc['l_2_txt'];
$T['AD']['1']['3']['1']['cont'] = $i18nDoc['l_3_txt'];

$T['AD']['1']['1']['2']['cont'] = $currentUserObj->getUserEntry('user_login');
$T['AD']['1']['2']['2']['cont'] = "<img src='".$currentUserObj->getUserEntry('user_avatar_image')."' width='128' height='128' alt='Avatar'>";
$T['AD']['1']['3']['2']['cont'] = $bts->TimeObj->timestampToDate($currentUserObj->getUserEntry('user_subscription_date'));
$RenderLayoutObj = RenderLayout::getInstance();
$T['tab_infos']['EnableTabs']		= 1;
$T['tab_infos']['NbrOfTabs']		= 1;
$T['tab_infos']['TabBehavior']		= 0;
$T['tab_infos']['RenderMode']		= 1;
$T['tab_infos']['HighLightType']	= 0;
$T['tab_infos']['Height']			= $RenderLayoutObj->getLayoutModuleEntry($infos['module_name'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-512;
$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
$T['tab_infos']['GroupName']		= "list";
$T['tab_infos']['CellName']			= "user";
$T['tab_infos']['DocumentName']		= "doc";
$T['tab_infos']['cell_1_txt']		= $i18nDoc['cell_1_txt'];

$T['ADC']['onglet']['1']['nbr_ligne']	= 3;	$T['ADC']['onglet']['1']['nbr_cellule']	= 2;	$T['ADC']['onglet']['1']['legende']		= 2;


$config = array(
		"mode" => 1,
		"affiche_module_mode" => "normal",
		"module_z_index" => 2,
		"block"		=> $infos['block'],
		"blockG"	=> $infos['block']."G",
		"blockT"	=> $infos['block']."T",
		"deco_type"	=> 50,
		"module"	=> $infos['module'],
);
$Content .= $bts->RenderTablesObj->render($config, $T);




/*Hydre-contenu_fin*/
?>
