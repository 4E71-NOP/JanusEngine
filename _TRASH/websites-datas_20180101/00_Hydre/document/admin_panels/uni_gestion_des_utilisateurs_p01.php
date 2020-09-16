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
$_REQUEST['RCH']['user_status'] = 1;
$_REQUEST['M_UTILIS_nbr_par_page'] = 10;
$_REQUEST['RCH']['groupe_id'] = 0;
//$_REQUEST['RCH']['user_status'] = 0;
// --------------------------------------------------------------------------------------------
//	2005 05 11 : fra_gestion_des_utilisateurs_p01.php debut
//	2007 08 16 : Derniere modification
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "fra_gestion_des_utilisateurs_p01";

// --------------------------------------------------------------------------------------------

$GDU_['nbr_par_page'] = $_REQUEST['M_UTILIS_nbr_par_page'];
if ($GDU_['nbr_par_page'] < 1 ) { $GDU_['nbr_par_page'] = 10;}
if ( $_REQUEST['RCH']['groupe_id'] == 0 ) { $_REQUEST['RCH']['groupe_id'] = $NULL; }

$clause_sql_element['1'] = "WHERE";
$clause_sql_element['2'] = $clause_sql_element['3'] = $clause_sql_element['4'] = $clause_sql_element['5'] = $clause_sql_element['6'] = $clause_sql_element['7'] = $clause_sql_element['8'] = $clause_sql_element['9'] = $clause_sql_element['10'] = "AND";

$clause_sql_element_offset = 1;
$GDU_['clause_like'] = "";
if ( isset($_REQUEST['RCH']['query_like']) && strlen($_REQUEST['RCH']['query_like']) != 0 )	{ $GDU_['clause_like'] .= " ".	$clause_sql_element[$clause_sql_element_offset]." usr.user_login LIKE '%" . $_REQUEST['RCH']['query_like'] . "%' ";	$clause_sql_element_offset++; }
if ( isset($_REQUEST['RCH']['groupe_id']) && $_REQUEST['RCH']['groupe_id'] != 0 )			{ $GDU_['clause_like'] .= " ".	$clause_sql_element[$clause_sql_element_offset]." gr.groupe_id = '".$_REQUEST['RCH']['groupe_id']."' ";				$clause_sql_element_offset++; }
if ( isset($_REQUEST['RCH']['user_status']) )											{ $GDU_['clause_like'] .= " ".		$clause_sql_element[$clause_sql_element_offset]." usr.user_status = '".$_REQUEST['RCH']['user_status']."' ";		$clause_sql_element_offset++; }
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gr.groupe_tag != '0' ";						$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gu.groupe_premier = '1' ";					$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." sg.site_id = '".$site_web['sw_id']."' ";		$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gu.user_id = usr.user_id";					$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." sg.groupe_id = gu.groupe_id ";				$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gu.groupe_id = gr.groupe_id ";				$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." usr.user_nom != 'HydreBDD'";				$clause_sql_element_offset++;

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT COUNT(usr.user_id) AS mucount 
FROM ".$SQL_tab_abrege['user']." usr, ".$SQL_tab_abrege['groupe']." gr, ".$SQL_tab_abrege['groupe_user']." gu, ".$SQL_tab_abrege['site_groupe']." sg 
".$GDU_['clause_like'].";");
while ($dbp = fetch_array_sql($dbquery)) { $GDU_['login_count'] = $dbp['mucount']; }

// --------------------------------------------------------------------------------------------
if ( $GDU_['login_count'] > $GDU_['nbr_par_page'] ) {
	$GDU_['selection_page'] = "<p style='text-align: center;'>\r --\r";
	$GDU_['nbr_page']  = $GDU_['login_count'] / $GDU_['nbr_par_page'] ;
	$GDU_['reste'] = $GDU_['login_count'] % $GDU_['nbr_par_page'];
	if ( $GDU_['reste'] != 0 ) { $GDU_['nbr_page']++;}
	$GDU_['compteur_page'] = 0;
	for ( $i = 1 ; $i <= $GDU_['nbr_page'] ; $i++) {
		if ( $_REQUEST['M_UTILIS_page'] != $GDU_['compteur_page'] ) {
			$GDU_['selection_page'] .= "
			<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' style='display: inline;' href='index.php?
M_UTILIS_page=".$GDU_['compteur_page']."
&amp;M_UTILIS_nbr_par_page=".$GDU_['nbr_par_page']."
&amp;M_UTILIS_query_like=".$_REQUEST['RCH']['query_like']."
&amp;M_UTILIS_groupe_id=".$_REQUEST['RCH']['groupe_id']."
&amp;arti_page=1
".$bloc_html['url_sldup']."
' onMouseOver = \"window.status = 'Aller a la page ".$i."'; return true;\" 
 onMouseOut=\"window.status = '".$site_web['sw_barre_status']."'; return true;\" 
>&nbsp;".$i."&nbsp;</a> ";
		}
		else { $GDU_['selection_page'] .= "<span class='" . $theme_tableau . $_REQUEST['bloc']."_tb3'>&nbsp;[".$i."]&nbsp;</span> "; }
		$GDU_['compteur_page']++;
	}
	$GDU_['selection_page'] .= " --</p>\r";
	echo ($GDU_['selection_page']);
}

//$WM_limit_d = $GDU_['nbr_par_page'] * $_REQUEST['M_UTILIS_page'];

$tl_['txt']['eng']['invite1'] = "This part will allow you to modify user properties.";
$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de modifier les propri&eacute;t&eacute;s des utilisateurs.";

$tl_['txt']['eng']['col_1_txt'] = "ID";				$tl_['txt']['fra']['col_1_txt'] = "ID";
$tl_['txt']['eng']['col_2_txt'] = "Login";			$tl_['txt']['fra']['col_2_txt'] = "Identifiant";
$tl_['txt']['eng']['col_3_txt'] = "Group";			$tl_['txt']['fra']['col_3_txt'] = "Groupe";	
$tl_['txt']['eng']['col_4_txt'] = "Status";			$tl_['txt']['fra']['col_4_txt'] = "Statut";
$tl_['txt']['eng']['col_5_txt'] = "Last visit";		$tl_['txt']['fra']['col_5_txt'] = "Derni&egrave;re visite";

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT usr.user_id,usr.user_login,usr.user_derniere_visite,gr.groupe_titre,usr.user_status 
FROM ".$SQL_tab['user']." usr, ".$SQL_tab['groupe']." gr, ".$SQL_tab['groupe_user']." gu, ".$SQL_tab['site_groupe']." sg 
".$GDU_['clause_like']." 
LIMIT ".($GDU_['nbr_par_page'] * $_REQUEST['M_UTILIS_page']).",".$GDU_['nbr_par_page'].";");

$GDU_['nbr_par_page_reel'] = num_row_sql ( $dbquery );

$pv['tab_statut']['eng']['0'] = "Disabled";		$pv['tab_statut']['fra']['0'] = "Inactif";
$pv['tab_statut']['eng']['1'] = "Active";		$pv['tab_statut']['fra']['1'] = "Actif";
$pv['tab_statut']['eng']['2'] = "Deleted";		$pv['tab_statut']['fra']['2'] = "Supprim&eacute;";

$i = 1;
$AD['1'][$i]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];
$AD['1'][$i]['2']['cont']	= $tl_['txt'][$l]['col_2_txt'];
$AD['1'][$i]['3']['cont']	= $tl_['txt'][$l]['col_3_txt'];
while ($dbp = fetch_array_sql($dbquery)) { 
	$i++;
	$AD['1'][$i]['1']['cont'] = $dbp['user_id'];
	$pv['var_tmp'] = date ("Y M d - H:i:s",$dbp['user_derniere_visite']);
	$AD['1'][$i]['2']['cont'] = "
	<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href='index.php?
	M_UTILIS[fiche]=".$dbp['user_id']."
	&amp;arti_ref=".$DP_['arti_ref']."
	&amp;arti_page=2
	&amp;uni_gestion_des_utilisateurs_p=2".
	$bloc_html['url_slup'].
	"'";
	if ( $dbp['user_status'] == 2 ) { $trr['tableau'][$i]['c_2_txt'] .= "style='font-style: italic; text-decoration: line-through; font-weight: lighter;'"; }
	$AD['1'][$i]['2']['cont'] .= ">".$dbp['user_login']."</a>";
	$AD['1'][$i]['3']['cont'] = $dbp['groupe_titre'];
	$AD['1'][$i]['4']['cont'] = $pv['tab_statut'][$l][$dbp['user_status']];
	$AD['1'][$i]['5']['cont'] = $pv['var_tmp'];
}

$ADC['onglet']['1']['nbr_ligne'] = $i;	$ADC['onglet']['1']['nbr_cellule'] = 3;	$ADC['onglet']['1']['legende'] = 1;
$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "gdu_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------

echo ("<br>\r".$GDU_['selection_page']."<br>\r");

$tl_['eng']['table1_1'] = "Find login containing";		$tl_['fra']['table1_1'] = "Trouver le login contenant";
$tl_['eng']['table1_2'] = "From group";					$tl_['fra']['table1_2'] = "du groupe";
$tl_['eng']['table1_3'] = "User status";				$tl_['fra']['table1_3'] = "Etat de l'utilisateur";
$tl_['eng']['table1_41'] = "Display";					$tl_['fra']['table1_41'] = "Afficher";		
$tl_['eng']['table1_42'] = "entry per pages.";			$tl_['fra']['table1_42'] = "entr&eacute;es par page.";
$tl_['eng']['submit2'] = "Add users";					$tl_['fra']['submit2'] = "Ajouter un utilisateur";

echo("
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page'	value='2'>\r
<input type='hidden' name='uni_gestion_des_utilisateurs_p' value='3'>\r

<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r
<td>\r
");
$_REQUEST['BS']['id']				= "bouton_ajout_utilisateur";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['submit2'];
$_REQUEST['BS']['mode']				= 0;
$_REQUEST['BS']['taille'] 			= 0;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();
echo ("
</td>\r
</tr>\r
</table>\r
<br>\r

</form>\r
<br>\r
");

echo("
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass'].
"<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
<tr>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'>".$tl_[$l]['table1_1']."</td>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'><input type='text' name='RCH[query_like]' size='15' value='".$_REQUEST['RCH']['query_like']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'></td>\r
</tr>\r

<tr>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'>".$tl_[$l]['table1_2']."</td>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'><select name='RCH[groupe_id]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r");


$tl_['eng']['select1_0'] = "No group";
$tl_['fra']['select1_0'] = "Aucun groupe";

$gu_select1['0']['id'] = 0; 
$gu_select1['0']['titre'] = $tl_[$l]['select1_0']; 
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT a.groupe_id,a.groupe_titre 
FROM ".$SQL_tab['groupe']." a , ".$SQL_tab['site_groupe']." b 
WHERE b.site_id = ".$site_web['sw_id']." 
AND a.groupe_tag != '0' 
AND a.groupe_id = b.groupe_id ;
");
while ($dbp = fetch_array_sql($dbquery)) {
	$gu_select1[$dbp['groupe_id']]['id'] = $dbp['groupe_id'];
	$gu_select1[$dbp['groupe_id']]['titre'] = $dbp['groupe_titre'];
}
if ( isset($_REQUEST['RCH']['groupe_id']) && $_REQUEST['RCH']['groupe_id'] != 0 ) {
	$gu_select1[$_REQUEST['RCH']['groupe_id']]['s'] = " selected ";
}
foreach ( $gu_select1 as $A ) { echo ("<option value='".$A['id']."' ".$A['s'].">".$A['titre']."</option>"); }
echo ("
</select>\r
</td>\r
</tr>\r

<tr>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'>".$tl_[$l]['table1_3']."</td>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'>
<select name='RCH[user_status]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
");

// --------------------------------------------------------------------------------------------
//	Test explicite pour chaque cas. Il pourra y en avoir d'autre dans l'avenir
// --------------------------------------------------------------------------------------------
$tl_['eng']['select2_0'] = "Disabled";		$tl_['fra']['select2_0'] = "Inactif";
$tl_['eng']['select2_1'] = "Active";		$tl_['fra']['select2_1'] = "Actif";
$tl_['eng']['select2_2'] = "Deleted";		$tl_['fra']['select2_2'] = "Supprim&eacute;";

$gu_usestatus['0']['i'] = 0;		$gu_usestatus['0']['t'] = $tl_[$l]['select2_0'];		$gu_usestatus['0']['s'] = "";		$gu_usestatus['0']['db'] = "DISABLED";
$gu_usestatus['1']['i'] = 1;		$gu_usestatus['1']['t'] = $tl_[$l]['select2_1'];		$gu_usestatus['1']['s'] = "";		$gu_usestatus['1']['db'] = "ACTIVE";
$gu_usestatus['2']['i'] = 2;		$gu_usestatus['2']['t'] = $tl_[$l]['select2_2'];		$gu_usestatus['2']['s'] = "";		$gu_usestatus['2']['db'] = "DELETED";
if ( isset($_REQUEST['RCH']['user_status']) && $_REQUEST['RCH']['user_status'] != 0 ) { $gu_usestatus[$_REQUEST['RCH']['user_status']]['s'] = " selected "; }
else {$gu_usestatus['1']['s'] = " selected ";}
foreach ( $gu_usestatus as $A ) { echo ("<option value='".$A['i']."' ".$A['s'].">".$A['t']."</option>"); } 
echo ("</select>\r");

$tl_['eng']['submit1'] = "Find";
$tl_['fra']['submit1'] = "Rechercher";

echo("
</td>\r
</tr>\r

<tr>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'>".$tl_[$l]['table1_41']."</td>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'><input type='text' name='M_UTILIS_nbr_par_page' size='2' value='".$GDU_['nbr_par_page']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'> 
".$tl_[$l]['table1_42']."
</td>\r
</tr>\r
</table>\r
<br>\r

<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r
<td>\r
");
$_REQUEST['BS']['id']				= "bouton_rechercher_utilisateur";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['submit1'];
$_REQUEST['BS']['mode']				= 0;
$_REQUEST['BS']['taille'] 			= 0;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();
echo ("
</td>\r
</tr>\r
</table>\r
<br>\r

</form>\r
<br>\r
<br>\r
<br>\r
");

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$clause_sql_element , 
		$clause_sql_element_offset , 
		$dbp , 
		$dbquery ,
		$fc_class ,  
		$GDU_ , 
		$gu_select1 , 
		$gu_usestatus , 
		$tl_ , 
		$pv , 
		$WM_limit_d
	);
}
/*Hydre-contenu_fin*/
?>
