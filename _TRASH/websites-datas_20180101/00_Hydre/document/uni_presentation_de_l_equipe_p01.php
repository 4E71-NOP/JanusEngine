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
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_presentation_de_l_equipe_p01";

$tl_['eng']['a'] = "The ".$site_web['sw_nom']." website staff.";
$tl_['fra']['a'] = "L'&eacute;quipe de ".$site_web['sw_nom'];

echo ("
<p class='".$theme_tableau.$_REQUEST['bloc']."_t3'> 
".$tl_[$l]['a']."<br>\r
<br>\r
<br>\r
");

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT usr.user_id, grp.groupe_id, grp.groupe_desc, usr.user_login, usr.user_image_avatar, grp.groupe_nom, grp.groupe_fichier
FROM ".$SQL_tab['user']." usr, ".$SQL_tab['groupe']." grp, ".$SQL_tab['groupe_user']." gu, ".$SQL_tab['site_groupe']." sg 
WHERE gu.groupe_premier = '1' 
AND sg.site_id = '".$site_web['sw_id']."' 
AND gu.user_id = usr.user_id 
AND sg.groupe_id = gu.groupe_id 
AND gu.groupe_id = grp.groupe_id
AND grp.groupe_tag = '2' 
AND usr.user_role_fonction = '2' 
ORDER BY grp.groupe_id,usr.user_login ASC
;");

while ($dbp = fetch_array_sql($dbquery)) { 
	$pv['i'] = $dbp['user_id'];
	foreach ( $dbp as $A => $B ) { $user_liste[$pv['i']][$A] = $B; }
}
$pv['current_group'] = 0;
foreach ( $user_liste as $B ) {
	if ( $B['groupe_id'] != $pv['current_group'] ) {	
		$pv['current_group'] = $B['groupe_id'];
		$pv['affiche_groupe_nom'] = 1 ;
		echo ("<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r<tr>\r");
		foreach ( $user_liste as $A ) {
			if ( $A['groupe_id'] == $pv['current_group'] ) {
				if ( $pv['affiche_groupe_nom'] == 1 ) {
					echo ("<td class='".$theme_tableau.$_REQUEST['bloc']."_fcta ".$theme_tableau.$_REQUEST['bloc']."_tb5' width='256'>".$A['groupe_nom']);
					if ( $pde_img_aff == 1 ) { echo ("<br>\r
						<span style='float: left;'>
						<img src='../".$A['groupe_fichier']."' height='".$pde_img_h."' width='".$pde_img_l."' alt='".$A['groupe_nom']."'>
						</span>\r
						"); }
					echo ("
					<span class='".$theme_tableau.$_REQUEST['bloc']."_t1'>".$A['groupe_desc']."</span></td>\r");
					$pv['affiche_groupe_nom'] = 0 ;
				}
				else { echo ("<td class='".$theme_tableau.$_REQUEST['bloc']."_tb3'> &nbsp; </td>\r"); }
				echo ("<td class='".$theme_tableau.$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t3'> ");
				if ( strlen($user['user_user_image_avatar']) != 0 ) { echo ("<img src='".$user['user_user_image_avatar']."' alt='Avatar'>"); }
				echo ($A['user_login']."<br>&nbsp </td>\r</tr>\r");
			}
		}
		echo ("</table>\r<br>\r");
	}
}

if ( $site_web['sw_info_debug'] < 10 ) { 
	unset (
		$A ,
		$B ,  
		$dbp , 
		$dbquery , 
		$pv , 
		$tl_ , 
		$user_list
	); 
}
/*Hydre-contenu_fin*/
?>
