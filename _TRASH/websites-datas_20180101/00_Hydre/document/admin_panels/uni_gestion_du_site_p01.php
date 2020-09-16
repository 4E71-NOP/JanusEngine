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

$_REQUEST['M_SITWEB']['etat_verification']	= 1 ;
$_REQUEST['M_SITWEB']['etat']				= 1 ; 
$_REQUEST['M_SITWEB']['confirmation_oubli']	= 0 ; 
// onClick=\"window.external.AddFavorite(location.href,document.title);\"
// onClick=\"bookmark_add ('$pv['nom_du_site_clean']','$pv['url_etat_site_clean']');\"
// <input type='hidden' name='wm_page_de_front' value='OFF'>\r
// &wm_page_de_front=OFF

// --------------------------------------------------------------------------------------------
//	2005 09 13 : fra_gestion_du_site_p01.php debut
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_gestion_du_site_p01";

$tl_['eng']['msg_01'] = "The site is actually : ";
$tl_['fra']['msg_01'] = "Le site est actuellement : ";

$tl_['eng']['select_o1_1_0'] = "Offline";		$tl_['eng']['select_o1_1_1'] = "Online";		$tl_['eng']['select_o1_1_2'] = "Deleted";			$tl_['eng']['select_o1_1_3'] = "Maintenance";
$tl_['fra']['select_o1_1_0'] = "Hors ligne";	$tl_['fra']['select_o1_1_1'] = "En ligne";		$tl_['fra']['select_o1_1_2'] = "Supprim&eacute;";	$tl_['fra']['select_o1_1_3'] = "Maintenance";

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT sw_etat, sw_lang 
FROM ".$SQL_tab['site_web']." 
WHERE sw_id = '".$site_web['sw_id']."'
;");

while ($dbp = fetch_array_sql($dbquery)) {
	$pv['sw_etat2'] = "select_o1_1_" . $dbp['sw_etat'];
	$pv['sw_etat'] = $dbp['sw_etat'];
	echo ("<p>" . $tl_[$l]['msg_01'] . $tl_[$l][$pv['sw_etat2']] . "<br>\r<br>\r</p>\r");
	$site_web['sw_lang_par_defaut'] = $dbp['sw_lang'];
}

// --------------------------------------------------------------------------------------------
if ( $_REQUEST['MSW']['confirmation_oubli'] == 1 ) { 
	$tl_['eng']['a'] = "You forgot to confirm (with the checkbox) the website update.";
	$tl_['fra']['a'] = "Vous n'avez pas confirm&eacute; les changements d'&eacute;tat du site.";

	echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur " . $theme_tableau . $_REQUEST['bloc']."_tb3'>".$tl_[$l]['a']."<br>\r</p>\r"); 
}

// --------------------------------------------------------------------------------------------

$tl_['1']['oui'] = "?";	$tl_['2']['oui'] = "?";	$tl_['eng']['oui'] = "Yes";		$tl_['4']['oui'] = "Si";	$tl_['fra']['oui'] = "Oui";	$tl_['6']['oui'] = "Ja";	$tl_['7']['oui'] = "Da";
$tl_['1']['non'] = "?";	$tl_['2']['non'] = "?";	$tl_['eng']['non'] = "No";		$tl_['4']['non'] = "No";	$tl_['fra']['non'] = "Non";	$tl_['6']['non'] = "?";	$tl_['7']['non'] = "Niet";

$tl_['eng']['modif_effectue1'] = "You have modified the site state.<br>\r<br>\rUse this URL to get back on this page:<br>\r";
$tl_['fra']['modif_effectue1'] = "Vous avez modifi&eacute; l'&eacute;tat du site.<br>\r<br>\rPour revenir a cette partie du site utilisez l'URL suivante:<br>\r";

$tl_['eng']['modif_effectue2'] = "Return to the site administration page";
$tl_['fra']['modif_effectue2'] = "Revenir a l'administration du site";

$tl_['eng']['modif_effectue3'] = "Use this link and make it a bookmark.";
$tl_['fra']['modif_effectue3'] = "Utilisez le lien pour en faire un signet.";

// --------------------------------------------------------------------------------------------

echo ("
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']
);

$msw_etat['0']['t'] = $tl_[$l]['select_o1_1_0'];	$msw_etat['0']['db'] = "OFFLINE";		$msw_etat['0']['v'] = 0;
$msw_etat['1']['t'] = $tl_[$l]['select_o1_1_1'];	$msw_etat['1']['db'] = "ONLINE";		$msw_etat['1']['v'] = 1;
$msw_etat['2']['t'] = $tl_[$l]['select_o1_1_2'];	$msw_etat['2']['db'] = "SUPPRIME";		$msw_etat['2']['v'] = 2;
$msw_etat['3']['t'] = $tl_[$l]['select_o1_1_3'];	$msw_etat['3']['db'] = "MAINTENANCE";	$msw_etat['3']['v'] = 3;

if ( isset($_REQUEST['MSW']['etat_verification']) && $_REQUEST['MSW']['etat_verification'] != $pv['sw_etat'] ) {
	$pv['url_etat_site']		= "/scripts/index.php?index.php?arti_ref=".$DP_['arti_ref']."&arti_page=1&user_login=".$user['login']."&user_pass=".$user['pass'];
	$pv['url_etat_site_clean']	= $home_du_site;
	$pv['nom_du_site_clean']	= $nom_du_site;

	echo ("
<p>
".$tl_[$l]['modif_effectue1']."
<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href='index.php?
sw=".$site_web['sw_id']."
&l=".$site_web['sw_lang']."
&arti_ref=".$DP_['arti_ref']."
&arti_page=1
&user_login=".$user['login']."
&user_pass=".$user['pass']."'
 onMouseOver = \"window.status = 'Aller a la page ".$i."'; return true;\" 
 onMouseOut=\"window.status = '".$site_web['sw_barre_status']."'; return true;\" 
></p>\r

	<p class='" . $theme_tableau . $_REQUEST['bloc']."_txt_avert_col' >
	<span style='font-weight: bold;'>".$tl_[$l]['modif_effectue2']."</span></a><br>\r
	".$tl_[$l]['modif_effectue3']."<br>\r
	</p>
	");
}

$Tab = 0;
// --------------------------------------------------------------------------------------------
$Tab++;

$tl_['eng']['o'.$Tab.'_l1'] = "State";		$tl_['fra']['o'.$Tab.'_l1'] = "Etat";
$msw_etat[$pv['sw_etat']]['s'] = " selected "; 

$AD[$Tab]['1']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l1'];
$AD[$Tab]['1']['2']['cont'] = "<select name='M_SITWEB[etat]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
foreach ( $msw_etat as $A ) { $AD[$Tab]['1']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$AD[$Tab]['1']['2']['cont'] .= "</select>\r";

$ADC['onglet'][$Tab]['nbr_ligne'] = 1;	$ADC['onglet'][$Tab]['nbr_cellule'] = 2;	$ADC['onglet'][$Tab]['legende'] = 2;

// --------------------------------------------------------------------------------------------
$Tab++;

$tl_['eng']['o'.$Tab.'_l1'] = "Default laguage";			$tl_['fra']['o'.$Tab.'_l1'] = "Langue par defaut";	
$tl_['eng']['o'.$Tab.'_l2'] = "User can choose language";	$tl_['fra']['o'.$Tab.'_l2'] = "Choix du language pour l'utilisateur";
$tl_['eng']['o'.$Tab.'_l3'] = "Default theme";			$tl_['fra']['o'.$Tab.'_l3'] = "theme par defaut";	
$tl_['eng']['o'.$Tab.'_l4'] = "Debug level";				$tl_['fra']['o'.$Tab.'_l4'] = "Niveau de debug";	
$tl_['eng']['o'.$Tab.'_l5'] = "Stylesheet";				$tl_['fra']['o'.$Tab.'_l5'] = "Stylesheet";

$AD[$Tab]['1']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l1'];
$AD[$Tab]['2']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l2'];
$AD[$Tab]['3']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l3'];
$AD[$Tab]['4']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l4'];
$AD[$Tab]['5']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l5'];




$AD[$Tab]['1']['2']['cont'] = "<select name='M_SITWEB[lang]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT sl.lang_id FROM ".$SQL_tab_abrege['site_langue']." sl , ".$SQL_tab_abrege['site_web']." s 
WHERE s.sw_id ='".$site_web['sw_id']."' 
AND sl.site_id = s.sw_id
;");
while ($dbp = fetch_array_sql($dbquery)) { $langues[$dbp['lang_id']]['support'] = 1; }
$langues[$site_web['sw_lang_par_defaut']]['s'] = " selected ";
foreach ( $langues as $A ) { if ( $A['support'] == 1 ) { $AD[$Tab]['1']['2']['cont'] .= "<option value='".$A['langue_639_3']."' ".$A['s']."> ".$A['langue_nom_original']." </option>\r"; } }
$AD[$Tab]['1']['2']['cont'] .= "</select>\r";

$AD[$Tab]['2']['2']['cont'] = "<select name='M_SITWEB[lang_select]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$sw_lang_select['0']['t'] = $tl_[$l]['non'];	$sw_lang_select['0']['s'] = "";		$sw_lang_select['0']['cmd'] = "NO";
$sw_lang_select['1']['t'] = $tl_[$l]['oui'];	$sw_lang_select['1']['s'] = "";		$sw_lang_select['1']['cmd'] = "YES";
$sw_lang_select[$site_web['sw_lang_select']]['s'] = " selected ";
foreach ( $sw_lang_select as $A ) { $AD[$Tab]['2']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s']."> ".$A['t']."</option>\r"; }
$AD[$Tab]['2']['2']['cont'] .= "</select>\r";



$AD[$Tab]['3']['2']['cont'] = "<select name='M_SITWEB[theme]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT a.theme_id,a.theme_nom,a.theme_titre 
FROM ".$SQL_tab['theme_descripteur']." a, ".$SQL_tab['site_theme']." b 
WHERE b.site_id = '".$site_web['sw_id']."' 
AND a.theme_id  = b.theme_id;
;");
while ($dbp = fetch_array_sql($dbquery)) {
	if ( $site_web['theme_id'] == $dbp['theme_id'] ) { $AD[$Tab]['3']['2']['cont'] .= "<option value='".$dbp['theme_nom']."' selected>".$dbp['theme_titre']."</option>\r"; }
	else { $AD[$Tab]['3']['2']['cont'] .= "<option value='".$dbp['theme_nom']."'>".$dbp['theme_titre']."</option>\r"; }
}
$AD[$Tab]['3']['2']['cont'] .= "</select>\r";


$AD[$Tab]['4']['2']['cont'] = "<select name='M_SITWEB[info_debug]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$tl_['eng']['ids_01'] = "1 - Montre le minimum";				$tl_['fra']['ids_01'] = "1 - Montre le minimum";
$tl_['eng']['ids_02'] = "2 - Stats";							$tl_['fra']['ids_02'] = "2 - Statistiques";
$tl_['eng']['ids_03'] = "3 - Logs";								$tl_['fra']['ids_03'] = "3 - Journaux";
$tl_['eng']['ids_04'] = "4 - ";									$tl_['fra']['ids_04'] = "4 - ";
$tl_['eng']['ids_05'] = "5 - ";									$tl_['fra']['ids_05'] = "5 - ";
$tl_['eng']['ids_06'] = "6 - SQL queries";						$tl_['fra']['ids_06'] = "6 - Requ&ecirc;tes SQL";
$tl_['eng']['ids_07'] = "7 - Commands";							$tl_['fra']['ids_07'] = "7 - Commandes";
$tl_['eng']['ids_08'] = "8 - Memory";							$tl_['fra']['ids_08'] = "8 - M&eacute;moire";
$tl_['eng']['ids_09'] = "9 - Debug logs";						$tl_['fra']['ids_09'] = "9 - Journaux de d&eacute;boggage";
$tl_['eng']['ids_10'] = "10 - Show all debug and variables";	$tl_['fra']['ids_10'] = "10 - Montre tout avec les variables";

$sw_niv_debug['1']['t'] = $tl_[$l]['ids_01'];	$sw_niv_debug['1']['s'] = "";	$sw_niv_debug['1']['cmd'] = "1";
$sw_niv_debug['2']['t'] = $tl_[$l]['ids_02'];	$sw_niv_debug['2']['s'] = "";	$sw_niv_debug['2']['cmd'] = "2";
$sw_niv_debug['3']['t'] = $tl_[$l]['ids_03'];	$sw_niv_debug['3']['s'] = "";	$sw_niv_debug['3']['cmd'] = "3";
$sw_niv_debug['4']['t'] = $tl_[$l]['ids_04'];	$sw_niv_debug['4']['s'] = "";	$sw_niv_debug['4']['cmd'] = "4";
$sw_niv_debug['5']['t'] = $tl_[$l]['ids_05'];	$sw_niv_debug['5']['s'] = "";	$sw_niv_debug['5']['cmd'] = "5";
$sw_niv_debug['6']['t'] = $tl_[$l]['ids_06'];	$sw_niv_debug['6']['s'] = "";	$sw_niv_debug['6']['cmd'] = "6";
$sw_niv_debug['7']['t'] = $tl_[$l]['ids_07'];	$sw_niv_debug['7']['s'] = "";	$sw_niv_debug['7']['cmd'] = "7";
$sw_niv_debug['8']['t'] = $tl_[$l]['ids_08'];	$sw_niv_debug['8']['s'] = "";	$sw_niv_debug['8']['cmd'] = "8";
$sw_niv_debug['9']['t'] = $tl_[$l]['ids_09'];	$sw_niv_debug['9']['s'] = "";	$sw_niv_debug['9']['cmd'] = "9";
$sw_niv_debug['10']['t'] = $tl_[$l]['ids_10'];	$sw_niv_debug['10']['s'] = "";	$sw_niv_debug['10']['cmd'] = "10";
$sw_niv_debug[$site_web['sw_info_debug']]['s'] = " selected ";
foreach ( $sw_niv_debug as $A ) { $AD[$Tab]['4']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s'].">".$A['t']."</option>\r"; }
$AD[$Tab]['4']['2']['cont'] .= "</select>\r";


$AD[$Tab]['5']['2']['cont'] = "<select name='M_SITWEB[stylesheet]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$sw_CSS['0']['t'] = "Statique (fichier) recommand&eacute;";	$sw_CSS['0']['s'] = "";		$sw_CSS['0']['cmd'] = "STATIC";
$sw_CSS['1']['t'] = "Dynamique";							$sw_CSS['1']['s'] = "";		$sw_CSS['1']['cmd'] = "DYNAMIC";
$sw_CSS[$site_web['sw_stylesheet']]['s'] = " selected ";
foreach ( $sw_CSS as $A ) { $AD[$Tab]['5']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s'].">".$A['t']."</option>\r"; }
$AD[$Tab]['5']['2']['cont'] .= "</select>\r";


$ADC['onglet'][$Tab]['nbr_ligne'] = 5;	$ADC['onglet'][$Tab]['nbr_cellule'] = 2;	$ADC['onglet'][$Tab]['legende'] = 2;
// --------------------------------------------------------------------------------------------
$Tab++;
$tl_['eng']['o'.$Tab.'_l1'] = "Modify language support.";		$tl_['fra']['o'.$Tab.'_l1'] = "Modifer le support des langues.";

$AD[$Tab]['1']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l1'];
$AD[$Tab]['1']['1']['colspan'] = 8;
$AD[$Tab]['1']['2']['cont'] = "";
$AD[$Tab]['1']['3']['cont'] = "";
$AD[$Tab]['1']['4']['cont'] = "";
$AD[$Tab]['1']['5']['cont'] = "";
$AD[$Tab]['1']['6']['cont'] = "";
$AD[$Tab]['1']['7']['cont'] = "";
$AD[$Tab]['1']['8']['cont'] = "";

reset ($langues);
$i = 2;
$j = 1;

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"SELECT * FROM ".$SQL_tab['langues'].";");
while ($dbp = fetch_array_sql($dbquery)) {
	$B = "";
	if ( $langues[$dbp['langue_id']]['support'] == 1 ) { $B = " checked"; }
	$AD[$Tab][$i][$j]['cont'] = "<input type='checkbox' name='M_SITWEB[ajout_lang][".$dbp['langue_id']."]' ".$B.">\r";		$j++;
	$AD[$Tab][$i][$j]['cont'] = $dbp['langue_nom_original'];															$j++;
	if ( $j == 9 ) { $j = 1; $i++; }
}

$ADC['onglet'][$Tab]['nbr_ligne'] = $i;	$ADC['onglet'][$Tab]['nbr_cellule'] = 8;	$ADC['onglet'][$Tab]['legende'] = 1;
// --------------------------------------------------------------------------------------------
$Tab++;

$tl_['eng']['o'.$Tab.'_l1'] = "Name";					$tl_['fra']['o'.$Tab.'_l1'] = "Nom";
$tl_['eng']['o'.$Tab.'_l2'] = "Short name";			$tl_['fra']['o'.$Tab.'_l2'] = "Nom abr&eacute;g&eacute;";			
$tl_['eng']['o'.$Tab.'_l3'] = "Window title";			$tl_['fra']['o'.$Tab.'_l3'] = "Titre de fen&ecirc;tre";	
$tl_['eng']['o'.$Tab.'_l4'] = "Status bar";			$tl_['fra']['o'.$Tab.'_l4'] = "Barre de status";
$tl_['eng']['o'.$Tab.'_l5'] = "Homepage URL";			$tl_['fra']['o'.$Tab.'_l5'] = "URL home";

$AD[$Tab]['1']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l1'];
$AD[$Tab]['2']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l2'];
$AD[$Tab]['3']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l3'];
$AD[$Tab]['4']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l4'];
$AD[$Tab]['5']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l5'];

$AD[$Tab]['1']['2']['cont'] = "<input type='text' name='M_SITWEB[nom]'			size='20' maxlength='255' value='".$site_web['sw_nom']."'			class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD[$Tab]['2']['2']['cont'] = "<input type='text' name='M_SITWEB[abrege]'			size='20' maxlength='255' value='".$site_web['sw_abrege']."'		class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD[$Tab]['3']['2']['cont'] = "<input type='text' name='M_SITWEB[titre]'			size='20' maxlength='255' value='".$site_web['sw_titre']."'			class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD[$Tab]['4']['2']['cont'] = "<input type='text' name='M_SITWEB[barre_status]'	size='20' maxlength='255' value='".$site_web['sw_barre_status']."'	class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD[$Tab]['5']['2']['cont'] = "<input type='text' name='M_SITWEB[home]'			size='20' maxlength='255' value='".$site_web['sw_home']."'			class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";

$ADC['onglet'][$Tab]['nbr_ligne'] = 5;	$ADC['onglet'][$Tab]['nbr_cellule'] = 2;	$ADC['onglet'][$Tab]['legende'] = 2;
// --------------------------------------------------------------------------------------------
$Tab++;
$tl_['eng']['o'.$Tab.'_l1'] = "Insert modified content in the log entries.";	$tl_['fra']['o'.$Tab.'_l1'] = "Insertion dans les logs du contenu modifi&eacute; d'un article.";

$AD[$Tab]['1']['1']['cont'] = $tl_[$l]['o'.$Tab.'_l1'];
$AD[$Tab]['1']['2']['cont'] = "<select name='M_SITWEB[ma_diff]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$sw_ma_diff['0']['t'] = $tl_[$l]['non'];	$sw_ma_diff['0']['s'] = "";		$sw_ma_diff['0']['cmd'] = "NO";
$sw_ma_diff['1']['t'] = $tl_[$l]['oui'];	$sw_ma_diff['1']['s'] = "";		$sw_ma_diff['1']['cmd'] = "YES";
$sw_ma_diff[$site_web['sw_ma_diff']]['s'] = " selected ";
foreach ( $sw_ma_diff as $A ) { $AD[$Tab]['1']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s'].">".$A['t']."</option>\r"; }
$AD[$Tab]['1']['2']['cont'] .= "</select>";

$ADC['onglet'][$Tab]['nbr_ligne'] = 1;	$ADC['onglet'][$Tab]['nbr_cellule'] = 2;	$ADC['onglet'][$Tab]['legende'] = 2;

// --------------------------------------------------------------------------------------------
$tl_['eng']['cell_1_txt'] = "Site state"; 		$tl_['fra']['cell_1_txt'] = "Etat du site"; 
$tl_['eng']['cell_2_txt'] = "Configuration"; 	$tl_['fra']['cell_2_txt'] = "Configuration"; 
$tl_['eng']['cell_3_txt'] = "Language"; 		$tl_['fra']['cell_3_txt'] = "Langues"; 
$tl_['eng']['cell_4_txt'] = "Display"; 			$tl_['fra']['cell_4_txt'] = "Pr&eacute;sentation"; 
$tl_['eng']['cell_5_txt'] = "Misc"; 			$tl_['fra']['cell_5_txt'] = "Divers"; 

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= $Tab;
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 320;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -16 ;
$tab_infos['groupe']			= "ms_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['cell_1_txt'];
$tab_infos['cell_2_txt']		= $tl_[$l]['cell_2_txt'];
$tab_infos['cell_3_txt']		= $tl_[$l]['cell_3_txt'];
$tab_infos['cell_4_txt']		= $tl_[$l]['cell_4_txt'];
$tab_infos['cell_5_txt']		= $tl_[$l]['cell_5_txt'];
$tab_infos['cell_6_txt']		= $tl_[$l]['cell_6_txt'];
$theme_SW_['tab_interieur']		= ${$theme_tableau}['theme_module_largeur_interne'] - 16;
include ("routines/website/affichage_donnees.php");


// --------------------------------------------------------------------------------------------
$tl_['eng']['validation'] = "I confirm the website modification.";	$tl_['fra']['validation'] = "Je valide le changement d'&eacute;tat du site.";
$tl_['eng']['submit'] = "Modify the website";						$tl_['fra']['submit'] = "Modifier le site";

echo ("

<input type='hidden' name='site_context[site_id]'		value='".$site_web['sw_id']."'>
<input type='hidden' name='site_context[site_nom]'		value='".$site_web['sw_nom']."'>
<input type='hidden' name='M_SITWEB[repertoire]'				value='".$site_web['sw_repertoire']."'>\r
<input type='hidden' name='M_SITWEB[banner_bypass]'			value='1'>\r
<input type='hidden' name='UPDATE_action'				value='UPDATE_WEBSITE'>\r
<input type='hidden' name='UPDATE_action_complement'	value='COMPLETE_UPDATE'>\r
<input type='hidden' name='M_SITWEB[action]'					value='2'>\r

<table cellpadding='0' cellspacing='0' style='width :". (${$theme_tableau}['theme_module_largeur_interne'] - 16) ."px;'>
<tr>\r
<td>\r
<input type='checkbox' name='M_SITWEB[confirmation]'>".$tl_[$l]['validation']."\r
</td>\r
<td>\r
");
$_REQUEST['BS']['id']				= "bouton_modification_site";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['submit'];
$_REQUEST['BS']['mode']				= 0;
$_REQUEST['BS']['taille'] 			= 0;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();

echo ("
</table>\r
</form>\r
");

if ( $site_web['sw_info_debug'] < 10 ) { 
	unset (
		$A , 
		$dbp , 
		$dbquery , 
		$GAL_mode_select , 
		$msw_etat , 
		$l , 
		$pv	, 
		$sw_aide_dynamique , 
		$sw_CSS , 
		$sw_lang_select , 
		$sw_ma_diff , 
		$sw_niv_debug , 
		$tl
	);
}

/*Hydre-contenu_fin*/
?>
