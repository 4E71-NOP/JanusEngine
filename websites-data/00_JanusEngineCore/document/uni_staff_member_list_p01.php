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

/*JanusEngine-Content-Begin*/

$bts->mapSegmentLocation(__METHOD__, "uni_staff_member_list_p01");

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

$dbquery = $bts->SDDMObj->query("
SELECT usr.user_id, grp.group_id, grp.group_desc, usr.user_login, usr.user_avatar_image, grp.group_name, grp.group_file
FROM "
.$SqlTableListObj->getSQLTableName('user')." usr, "
.$SqlTableListObj->getSQLTableName('group')." grp, "
.$SqlTableListObj->getSQLTableName('group_user')." gu, "
.$SqlTableListObj->getSQLTableName('group_website')." gw 
WHERE gu.group_user_initial_group = '1' 
AND gw.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND gu.fk_user_id = usr.user_id 
AND gw.fk_group_id = gu.fk_group_id 
AND gu.fk_group_id = grp.group_id
AND grp.group_tag = '2' 
AND usr.user_role_function = '2' 
ORDER BY grp.group_id,usr.user_login ASC
;");
$user_liste= array();
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
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
		$Content .= "<table class='".$Block._CLASS_TABLE01_."' ".$ThemeDataObj->getThemeDataEntry('tab_std_rules')." width='100%'>\r<tr>\r";
		foreach ( $user_liste as $A ) {
			if ( $A['group_id'] == $CurrentGroup ) {
				if ( $DisplayGroupName == 1 ) {
					$Content .= "<td width='256'><span style='font-size:135%; font-weight:bold;'>".$A['group_name']."</span>";
					if ( $pde_img_aff == 1 ) { $Content .= "<br>\r
						<span style='float: left;'>
						<img src='../".$A['group_file']."' height='".$pde_img_h."' width='".$pde_img_l."' alt='".$A['group_name']."'>
						</span>\r
						"; }
					$Content .= "
					<span style='font-size:75%'>".$A['group_desc']."</span></td>\r";
					$DisplayGroupName = 0 ;
				}
				else { $Content .= "<td class='".$Block."_tb3'> &nbsp; </td>\r"; }
				$Content .= "<td class='".$Block."_fca ".$Block."_t3'> ";
				if ( strlen($A['user_user_avatar_image']) != 0 ) { $Content .= "<img src='".$A['user_user_avatar_image']."' alt='Avatar'>"; }
				$Content .= $A['user_login']."<br>&nbsp </td>\r</tr>\r";
			}
		}
		$Content .= "</table>\r<br>\r";
	}
}

$bts->segmentEnding(__METHOD__);

/*JanusEngine-Content-End*/
?>
;