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
// Some definitions in order to ease the IDE's work.
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $InteractiveElementsObj InteractiveElements */
/* @var $RenderTablesObj RenderTables               */
/* @var $RequestDataObj RequestData                 */
/* @var $SDDMObj DalFacade                          */
/* @var $SqlTableListObj SqlTableList               */
/* @var $StringFormatObj StringFormat               */
/* @var $TimeObj Time                               */

/* @var $CurrentSetObj CurrentSet                   */
/* @var $DocumentDataObj DocumentData               */
/* @var $RenderLayoutObj RenderLayout               */
/* @var $ThemeDataObj ThemeData                     */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */

/* @var $Block String                               */
/* @var $infos array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

/*Hydre-contenu_debut*/

$localisation = " / uni_layout_de_l_equipe_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_layout_de_l_equipe_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_layout_de_l_equipe_p01");

switch ( $l ) {
	case "fra":
		$i18nDoc = array(
		"invit" => "L'équipe de ".$WebSiteObj->getWebSiteEntry('ws_name').".",
		);
		break;
	case "eng":
		$i18nDoc = array(
		"invit" => "The ".$WebSiteObj->getWebSiteEntry('ws_name')." staff.",
		);
		break;
}

$Content .= "<p class='".$Block."_t3'>".$i18nDoc['invit']."<br>\r
<br>\r
<br>\r
";

$dbquery = $SDDMObj->query("SELECT usr.user_id, grp.group_id, grp.group_desc, usr.user_login, usr.user_image_avatar, grp.group_name, grp.group_file
FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('groupe')." grp, ".$SqlTableListObj->getSQLTableName('groupe_user')." gu, ".$SqlTableListObj->getSQLTableName('group_website')." sg 
WHERE gu.group_user_initial_group = '1' 
AND sg.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND gu.user_id = usr.user_id 
AND sg.group_id = gu.group_id 
AND gu.group_id = grp.group_id
AND grp.group_tag = '2' 
AND usr.user_role_fonction = '2' 
ORDER BY grp.group_id,usr.user_login ASC
;");
$user_liste= array();
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
	$i = $dbp['user_id'];
	foreach ( $dbp as $A => $B ) { $user_liste[$i][$A] = $B; }
}

// image avatar controls
$pde_img_aff = 1;
$pde_img_h = 32; 
$pde_img_l = 32; 

$CurrentGroup = 0;
foreach ( $user_liste as $B ) {
	if ( $B['group_id'] != $CurrentGroup ) {	
		$CurrentGroup = $B['group_id'];
		$DisplayGroupName = 1 ;
		$Content .= "<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules')." width='".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."'>\r<tr>\r";
		foreach ( $user_liste as $A ) {
			if ( $A['group_id'] == $CurrentGroup ) {
				if ( $DisplayGroupName == 1 ) {
					$Content .= "<td class='".$Block."_fcta ".$Block."_tb5' width='256'>".$A['group_name'];
					if ( $pde_img_aff == 1 ) { $Content .= "<br>\r
						<span style='float: left;'>
						<img src='../".$A['group_file']."' height='".$pde_img_h."' width='".$pde_img_l."' alt='".$A['group_name']."'>
						</span>\r
						"; }
					$Content .= "
					<span class='".$Block."_t1'>".$A['group_desc']."</span></td>\r";
					$DisplayGroupName = 0 ;
				}
				else { $Content .= "<td class='".$Block."_tb3'> &nbsp; </td>\r"; }
				$Content .= "<td class='".$Block."_fca ".$Block."_t3'> ";
				if ( strlen($A['user_user_image_avatar']) != 0 ) { $Content .= "<img src='".$A['user_user_image_avatar']."' alt='Avatar'>"; }
				$Content .= $A['user_login']."<br>&nbsp </td>\r</tr>\r";
			}
		}
		$Content .= "</table>\r<br>\r";
	}
}

/*Hydre-contenu_fin*/
?>
;