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

//add user login "dieu2" perso_name "Dieu2"  password dieu status ACTIVE	image_avatar "../websites-datas/www.rootwave.net/data/images/avatars/public/dieu.gif"	role_function PRIVATE;
//user dieu2 join_group Server_owner primary_group OUI;
//user dieu2 join_group Developpeurs_senior primary_group NON;
//user dieu2 join_group Developpeurs_confirme primary_group NON;
//user dieu2 join_group Developpeurs_debutant primary_group NON;
//show user;
$_REQUEST['CC']['fichier'] = "";
$_REQUEST['requete_insert'] = "show user";


/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_console_de_commande_p01.php";

// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------
$tl_['eng']['o1l1'] = "Last buffer";			$tl_['fra']['o1l1'] = "Dernier tampon de commande";

// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------

$tl_['eng']['msg1'] = "If a file is selected, it will take over the console box. Only the file content will be executed.";
$tl_['fra']['msg1'] = "Si un fichier est s&eacute;lectionn&eacute;, il prendra la priorit&eacute;. Seul le contenu du fichier sera ex&eacute;cut&eacute;.";

$tl_['eng']['bouton1'] = "Submit";
$tl_['fra']['bouton1'] = "Soumettre"; 
echo ("
<form ACTION='index.php?' method='post' name='formulaire_console'>\r
");

if ( $_REQUEST['ICC_controle']['affichage_requis'] == 1 ) {
	echo ("
	<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
	<caption class='" . $theme_tableau . $_REQUEST['bloc']."_fctb " . $theme_tableau . $_REQUEST['bloc']."_tb3'>".$_REQUEST['ICC_caption']."</caption>
	");
	foreach ( $_REQUEST['ICC'] as $cle => $valeur ) {
		echo ("
		<tr>\r
		<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_t1'>".$cle."</td>
		<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_t1'>".$valeur."</td>
		</tr>\r
		");
	}
	echo ("</table>\r<br>\r");
}

// --------------------------------------------------------------------------------------------
$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_console";
$fsi['champs']					= "CC[fichier]";
$fsi['lsdf_chemin']				= "../websites-datas/".$site_web['sw_repertoire']."/document";
$fsi['mode_selection']			= "fichier";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 10;
$fsi['lsdf_indicatif']			= "SDFGDGP2";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 1;
$fsi['lsdf_conserve_chemin']	= "../websites-datas/".$site_web['sw_repertoire']."/document";
$fsi['lsdf_coupe_repertoire']	= 0;
$fsi['liste_fichier']			= array();

$pv['ttrb'] = &${$theme_tableau}[$_REQUEST['blocT']];

$AD['1']['1']['1']['cont'] = "<textarea name='requete_insert' cols='".floor((${$theme_tableau}['theme_module_largeur_interne'] / $pv['ttrb']['fonte_size_n3'] ) * 1.35 ) ."' rows='6' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'></textarea>";
$AD['1']['1']['1']['style'] = "text-align:center;";

$tl_['eng']['fichier1'] = "Select a file:<br>\r";
$tl_['fra']['fichier1'] = "S&eacute;lectionnez un fichier:<br>\r";
$AD['2']['1']['1']['cont'] = $tl_[$l]['fichier1'].generation_icone_selecteur_fichier ( 1 , $fsi['formulaire'] , $fsi['champs'] , floor((${$theme_tableau}['theme_module_largeur_interne'] / $pv['ttrb']['fonte_size_n3'] ) * 1.35 ) , "" , "TabSDF_".$fsi['lsdf_indicatif'] );
$AD['2']['1']['1']['style'] = "text-align:center;";

$tl_['eng']['aide1'] = "Use ';' as separator.<br>\r<br>\rBasic commands list:<br>\r
show site name MultiWeb_Manager;
";

$tl_['fra']['aide1'] = "Utilisez ';' comme separateur.<br>\r<br>\r
<span style='text-decoration: underline;'>Liste de commandes basiques:</span>
<ul>
<li>show &lt;site|user|group|deadline|document|article|category|module|decoration|keyword&gt;; Affiche la liste du type donn&eacute;.</li>
<li>show &lt;site|user|group|deadline|document|article|category|module|decoration|keyword&gt; nom 'xxx'; Affiche les d&eacute;tails de l'&eacute;l&eacute;ment du type donn&eacute;.</li>
</ul>
";

$AD['3']['1']['1']['cont'] = $tl_[$l]['aide1'];

$ADC['onglet']['1']['nbr_ligne'] = 1;	$ADC['onglet']['1']['nbr_cellule'] = 1;	$ADC['onglet']['1']['legende'] = 0;
$ADC['onglet']['2']['nbr_ligne'] = 1;	$ADC['onglet']['2']['nbr_cellule'] = 1;	$ADC['onglet']['2']['legende'] = 0;
$ADC['onglet']['3']['nbr_ligne'] = 1;	$ADC['onglet']['3']['nbr_cellule'] = 1;	$ADC['onglet']['3']['legende'] = 0;

$tl_['eng']['onglet_1'] = "Command mode";	$tl_['fra']['onglet_1'] = "Mode Texte";
$tl_['eng']['onglet_2'] = "File mode";		$tl_['fra']['onglet_2'] = "Mode fichier";
$tl_['eng']['onglet_3'] = "Help";			$tl_['fra']['onglet_3'] = "Aide";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 3;
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 128;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "cc_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
$tab_infos['cell_2_txt']		= $tl_[$l]['onglet_2'];
$tab_infos['cell_3_txt']		= $tl_[$l]['onglet_3'];
include ("routines/website/affichage_donnees.php");


echo ("
<input type='hidden' name='CC_interface'				value='1'>\r
<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']." padding-left:auto; padding-right:0px;'>\r
<tr>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."

<td>\r&nbsp;</td>\r
<td>\r");
$_REQUEST['BS']['id']				= "bouton_soumission";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton1'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 128;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();
echo ("<br>\r&nbsp;</td>\r
</tr>\r
</form>\r

</table>\r
");

$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";
$tl_['eng']['onglet_2'] = "Logs";			$tl_['fra']['onglet_2'] = "Journaux";

$AD['1']['1']['1']['cont'] = $tl_[$l]['o1l1'];
$AD['1']['1']['2']['cont'] = $_REQUEST['requete_insert'];
$ADC['onglet']['1']['nbr_ligne'] = 1;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;

$AD['2']['1']['1']['cont'] = $tl_[$l]['o2l1'];
$ADC['onglet']['2']['nbr_ligne'] = 10;	$ADC['onglet']['2']['nbr_cellule'] = 7;	$ADC['onglet']['2']['legende'] = 1;

$tl_['eng']['c1']		= "N";			$tl_['fra']['c1']	= "N";			$AD['2']['1']['1']['cont'] = $tl_[$l]['c1'];
$tl_['eng']['c2']		= "Date";		$tl_['fra']['c2']	= "Date";		$AD['2']['1']['2']['cont'] = $tl_[$l]['c2'];
$tl_['eng']['c3']		= "Initiator";	$tl_['fra']['c3']	= "Initiateur";	$AD['2']['1']['3']['cont'] = $tl_[$l]['c3'];
$tl_['eng']['c4']		= "Action";		$tl_['fra']['c4']	= "Action";		$AD['2']['1']['4']['cont'] = $tl_[$l]['c4'];
$tl_['eng']['c5']		= "Signal";		$tl_['fra']['c5']	= "Signal";		$AD['2']['1']['5']['cont'] = $tl_[$l]['c5'];
$tl_['eng']['c6']		= "Message ID";	$tl_['fra']['c6']	= "ID Message";	$AD['2']['1']['6']['cont'] = $tl_[$l]['c6'];
$tl_['eng']['c7']		= "Message";	$tl_['fra']['c7']	= "Message";	$AD['2']['1']['7']['cont'] = $tl_[$l]['c7'];

$tab_signal['0'] = "ERR";	$tab_signal['0'] = "OK";	$tab_signal['2'] = "WARN";	$tab_signal['3'] = "INFO";	$tab_signal['4'] = "AUTRE";
$signal = $tab[$signal];

$historique_date = mktime();
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['historique']." 
WHERE site_id = '".$site_web['sw_id']."' 
ORDER BY historique_id DESC
LIMIT 0,10
;");

$tab['0'] = "<span class='" . $theme_tableau . $_REQUEST['bloc']."_erreur'>Erreur</span>";	
$tab['1'] = "<span class='" . $theme_tableau . $_REQUEST['bloc']."_ok " 	. $theme_tableau . $_REQUEST['bloc']."_t1'>OK</span>";		
$tab['2'] = "<span class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>Avertissement</span>";		
$tab['3'] = "Information";		
$tab['4'] = "Autre";
$pv['N_L'] = 2;
while ($dbp = fetch_array_sql($dbquery)) {
	$historique_action_longeur = strlen($dbp['historique_action']);
	switch (TRUE) {
	case ($historique_action_longeur < 128 && $historique_action_longeur > 64):	$dbp['historique_action'] = substr ($dbp['historique_action'],0,59) . " [...] ";		break;
	case ($historique_action_longeur > 128):									$dbp['historique_action'] = substr ($dbp['historique_action'],0,59) . " [...] " . substr ($dbp['historique_action'],($historique_action_longeur - 64) ,$historique_action_longeur );		break;
	}
	$AD['2'][$pv['N_L']]['1']['cont'] = $dbp['historique_id'];
	$AD['2'][$pv['N_L']]['2']['cont'] = date ( "Y m d H:i:s" , $dbp['historique_date'] );
	$AD['2'][$pv['N_L']]['3']['cont'] = $dbp['historique_initiateur'];
	$AD['2'][$pv['N_L']]['4']['cont'] = $dbp['historique_action'];
	$AD['2'][$pv['N_L']]['5']['cont'] = $tab[$dbp['historique_signal']];
	$AD['2'][$pv['N_L']]['6']['cont'] = $dbp['historique_msgid'];
	$AD['2'][$pv['N_L']]['7']['cont'] = $dbp['historique_contenu'];

	$tabfc_['tmp'] = $tabfc_['a'] ; $tabfc_['a'] = $tabfc_['c'] ; $tabfc_['c'] = $tabfc_['tmp'] ;
	$tabfc_['tmp'] = $tabfc_['b'] ; $tabfc_['b'] = $tabfc_['d'] ; $tabfc_['d'] = $tabfc_['tmp'] ;
	$pv['N_L']++;
}

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 2;
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 128;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "cc_grp2";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
$tab_infos['cell_2_txt']		= $tl_[$l]['onglet_2'];
include ("routines/website/affichage_donnees.php");



// --------------------------------------------------------------------------------------------

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp,
		$dbquery,
		$AD,
		$ADC,
		$pv,
		$tl_
	);
}

/*Hydre-contenu_fin*/
?>
