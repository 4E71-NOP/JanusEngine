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
//	uni_gestion_des_historiques_p01.php debut
// --------------------------------------------------------------------------------------------
$_REQUEST['MH']['clause_type']['ok']	= "on";
$_REQUEST['MH']['clause_type']['avrt']	= "on";
$_REQUEST['MH']['clause_type']['err']	= "on";
$_REQUEST['MH']['clause_type']['info']	= "on";
$_REQUEST['MH']['clause_type']['autr']	= "on";
$_REQUEST['MH']['nbr_par_page']			= 10;

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_gestion_des_historiques_p01";

$tl_['eng']['t1cap'] = "Search criterias";		$tl_['fra']['t1cap'] = "Crit&egrave;res de recherche";
$tl_['eng']['t1r1'] = "View signal";			$tl_['fra']['t1r1'] = "Voir les signaux";
$tl_['eng']['t1r2'] = "Entries per page";		$tl_['fra']['t1r2'] = "Nombre par page";

$tl_['eng']['type_err'] = "Error";				$tl_['fra']['type_err'] = "Erreur";	
$tl_['eng']['type_avrt'] = "Warning";			$tl_['fra']['type_avrt'] = "Avertissement";
$tl_['eng']['type_ok'] = "Ok";					$tl_['fra']['type_ok'] = "Ok";
$tl_['eng']['type_info'] = "Information";		$tl_['fra']['type_info'] = "Information";
$tl_['eng']['type_autr'] = "Other";				$tl_['fra']['type_autr'] = "Autre";

// --------------------------------------------------------------------------------------------
//	Realisation des suppresions demandées
// --------------------------------------------------------------------------------------------
if ( isset($_REQUEST['MH']['action'])) {
	switch ( $_REQUEST['MH']['action'] ) {
	case "SUPPRESSION":
		$pv['selection_suppresion'] = " WHERE historique_id IN (";
		foreach ( $_REQUEST['MH']['selection'] as $K => $A ) { $pv['selection_suppresion'] .= $K.", "; }
		unset ($K,$A);
		$pv['selection_suppresion'] = substr($pv['selection_suppresion'], 0, -2) . ") ";
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		DELETE FROM ".$SQL_tab_abrege['historique']. 
		$pv['selection_suppresion']."
		;");
	break;
	}
}
// --------------------------------------------------------------------------------------------
//	Analyse des critere d'affichage
// --------------------------------------------------------------------------------------------
if ( isset($_REQUEST['MH']['clause_type']) && is_array($_REQUEST['MH']['clause_type']) ) {
	$pv['check_clause_type'] = 0;
	foreach ( $_REQUEST['MH']['clause_type'] as $A ) { if ( $A == "on" ) { $pv['check_clause_type']++; } }
	if ( $pv['check_clause_type'] == 0 ) {
		$_REQUEST['MH']['clause_type']['err']	= "on";
		$_REQUEST['MH']['clause_type']['ok']	= "on";
		$_REQUEST['MH']['clause_type']['avrt']	= "on";
	}
}

else {
	$_REQUEST['MH']['clause_type']['err']	= "on";
	$_REQUEST['MH']['clause_type']['ok']	= "on";
	$_REQUEST['MH']['clause_type']['avrt']	= "on";
}

$pv['bloc_critere'] = ""; 
$pv['clause_type'] = " AND historique_signal IN (";
if ( $_REQUEST['MH']['clause_type']['err'] == "on" )	{
	$pv['clause_tmp']['1'] = "0"; 
	$pv['bloc_critere'] .= "&amp;MH[clause_type][err]=".$_REQUEST['MH']['clause_type']['err'];		
	$pv['post_critere'] .= "<input type='hidden' name='MH[clause_type][err]'	value='".$_REQUEST['MH']['clause_type']['err']."'>\r";		
	$_REQUEST['MH']['clause_type']['err']	= " checked ";

}
if ( $_REQUEST['MH']['clause_type']['ok'] == "on" )	{
	$pv['clause_tmp']['2'] = "1";
	$pv['bloc_critere'] .= "&amp;MH[clause_type][ok]=".$_REQUEST['MH']['clause_type']['ok'];
	$pv['post_critere'] .= "<input type='hidden' name='MH[clause_type][ok]'	value='".$_REQUEST['MH']['clause_type']['ok']."'>\r";		
	$_REQUEST['MH']['clause_type']['ok']	= " checked ";
}
if ( $_REQUEST['MH']['clause_type']['avrt'] == "on" )	{
	$pv['clause_tmp']['3'] = "2";
	$pv['bloc_critere'] .= "&amp;MH[clause_type][avrt]=".$_REQUEST['MH']['clause_type']['avrt'];
	$pv['post_critere'] .= "<input type='hidden' name='MH[clause_type][avrt]'	value='".$_REQUEST['MH']['clause_type']['avrt']."'>\r";		
	$_REQUEST['MH']['clause_type']['avrt']	= " checked ";
}
if ( $_REQUEST['MH']['clause_type']['info'] == "on" )	{
	$pv['clause_tmp']['4'] = "3";
	$pv['bloc_critere'] .= "&amp;MH[clause_type][info]=".$_REQUEST['MH']['clause_type']['info'];
	$pv['post_critere'] .= "<input type='hidden' name='MH[clause_type][info]'	value='".$_REQUEST['MH']['clause_type']['info']."'>\r";		
	$_REQUEST['MH']['clause_type']['info']	= " checked ";
}
if ( $_REQUEST['MH']['clause_type']['autr'] == "on" )	{
	$pv['clause_tmp']['5'] = "4";
	$pv['bloc_critere'] .= "&amp;MH[clause_type][autr]=".$_REQUEST['MH']['clause_type']['autr'];
	$pv['post_critere'] .= "<input type='hidden' name='MH[clause_type][autr]'	value='".$_REQUEST['MH']['clause_type']['autr']."'>\r";		
	$_REQUEST['MH']['clause_type']['autr']	= " checked ";
}

foreach ( $pv['clause_tmp'] as $B ) { $pv['clause_type'] .= $B.", "; }
$pv['clause_type'] = substr($pv['clause_type'], 0, -2) . ") ";
unset ($A,$B);

if ( !isset($_REQUEST['MH']['nbr_par_page']) ) { $_REQUEST['MH']['nbr_par_page'] = 10 ;}
$pv['bloc_critere'] .= "&amp;MH[nbr_par_page]=".$_REQUEST['MH']['nbr_par_page'];
$pv['post_critere'] .= "<input type='hidden' name='MH[nbr_par_page]'	value='".$_REQUEST['MH']['nbr_par_page']."'>\r";		

echo ("
<form id='MH_001' ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
<input type='hidden' name='MH[action]'	value='AFFICHAGE'>\r");


// --------------------------------------------------------------------------------------------
$pv['onglet'] = 1;
$lt = 1;

$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['t1cap'];
$AD[$pv['onglet']][$lt]['2']['cont'] = "";
$lt++;

$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['t1r1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = "<input type='checkbox' name ='MH[clause_type][ok]'		class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_form_1' ".$_REQUEST['MH']['clause_type']['ok'].">\r".$tl_[$l]['type_ok']."; \r
<input type='checkbox' name ='MH[clause_type][avrt]'	class='" . $theme_tableau.$_REQUEST['bloc']."_form_1' ".$_REQUEST['MH']['clause_type']['avrt'].">\r".$tl_[$l]['type_avrt']."; \r
<input type='checkbox' name ='MH[clause_type][err]'		class='" . $theme_tableau.$_REQUEST['bloc']."_form_1' ".$_REQUEST['MH']['clause_type']['err'].">\r".$tl_[$l]['type_err']."; \r
<input type='checkbox' name ='MH[clause_type][info]'	class='" . $theme_tableau.$_REQUEST['bloc']."_form_1' ".$_REQUEST['MH']['clause_type']['info'].">\r".$tl_[$l]['type_info']."; \r
<input type='checkbox' name ='MH[clause_type][autr]'	class='" . $theme_tableau.$_REQUEST['bloc']."_form_1' ".$_REQUEST['MH']['clause_type']['autr'].">\r".$tl_[$l]['type_autr']."\r
";
$lt++;

$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['t1r2'];
$AD[$pv['onglet']][$lt]['2']['cont'] = "<input type='text' name='MH[nbr_par_page]' size='15' value='".$_REQUEST['MH']['nbr_par_page']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_form_1'>";


$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $lt;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

$tab_infos['AffOnglet']		= 0;
$tab_infos['nbr']			= 1;
$tab_infos['doc_height']	= $pres_[$mn]['dim_y_22'] - ${$theme_tableau}[$_REQUEST['bloc']]['tab_y'] - 32 ;
$tab_infos['doc_height']	= 96;
$tab_infos['doc_width']		= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']		= "gh";
$tab_infos['cell_id']		= "tab";
$tab_infos['document']		= "doc";
$tab_infos['tab_comportement'] = 1;
$tab_infos['mode_rendu']	= 0;	// 0 echo 1 dans une variable
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------
$tl_['eng']['rfrsh'] = "Refresh display";
$tl_['fra']['rfrsh'] = "Rafraichir la vue";

$_REQUEST['BS']['id']				= "bouton_raffraichir";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['rfrsh'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 192;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();

echo ("
<br>\r
</form>\r
<form id='MH_002' ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
<input type='hidden' name='MH[action]'	value='SUPPRESSION'>\r
");

if ( !isset($_REQUEST['MH']['page']) ) { $_REQUEST['MH']['page'] = 0; }

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT COUNT(historique_id) as nbr_historique 
FROM ".$SQL_tab_abrege['historique']." 
WHERE site_id = '".$site_web['sw_id']."'
".$pv['clause_type'].
$pv['clause_msgid']."
;");
while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['MH']['historique_count'] = $dbp['nbr_historique']; } 

if ( $_REQUEST['MH']['historique_count'] > $_REQUEST['MH']['nbr_par_page'] ) {
	$_REQUEST['MH']['selection_page'] = "<p style='text-align: center;'>\r --\r";
	$_REQUEST['MH']['nbr_page']	= $_REQUEST['MH']['historique_count'] / $_REQUEST['MH']['nbr_par_page'];
	$_REQUEST['MH']['reste']	= $_REQUEST['MH']['historique_count'] % $_REQUEST['MH']['nbr_par_page'];
	if ( $_REQUEST['MH']['reste'] != 0 ) { $_REQUEST['MH']['nbr_page']++; }
	$_REQUEST['MH']['compteur_page'] = 0;
	for ( $pv['i'] = 1 ; $pv['i'] <= $_REQUEST['MH']['nbr_page'] ; $pv['i']++ ) {
		if ( $_REQUEST['MH']['page'] != $_REQUEST['MH']['compteur_page'] ) {
			$_REQUEST['MH']['selection_page'] .= "
			<a class='" . $theme_tableau.$_REQUEST['bloc']."_lien' href='index.php?
MH[page]=".$_REQUEST['MH']['compteur_page']."
&amp;arti_page=1".
$pv['bloc_critere'].
$bloc_html['url_sldup']."'

 onMouseOver = \"window.status = 'Aller a la page ".$pv['i']."'; return true;\" 
 onMouseOut=\"window.status = '".$site_web['sw_barre_status']."'; return true;\" 
>".$pv['i']."</a> ";
		}
		else { $_REQUEST['MH']['selection_page'] .= "<span style='font-weight: bold;'>[".$pv['i']."]</span> "; }
		$_REQUEST['MH']['compteur_page']++;
	}
	$_REQUEST['MH']['selection_page'] .= " --</p>\r";
 	echo $_REQUEST['MH']['selection_page'];
}

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['historique']." 
WHERE site_id = '".$site_web['sw_id']."'
".$pv['clause_type'].
$pv['clause_msgid']."
ORDER BY historique_date DESC, historique_id DESC 
LIMIT ".($_REQUEST['MH']['page'] * $_REQUEST['MH']['nbr_par_page']).",".$_REQUEST['MH']['nbr_par_page']."
;");

if ( num_row_sql($dbquery) == 0 ) {
	$tl_['txt']['eng']['raf1'] = "Nothing to display";	$tl_['txt']['fra']['raf1'] = "Rien a afficher";

	$pv['onglet'] = 1; $lt = 1;
	$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_['txt'][$l]['raf1'];

	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $lt;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 0;

	$tab_infos['AffOnglet']		= 0;
	$tab_infos['nbr']			= 1;
	$tab_infos['doc_height']	= $pres_[$mn]['dim_y_22'] - ${$theme_tableau}[$_REQUEST['bloc']]['tab_y'] - 32 ;
	$tab_infos['doc_height']	= 96;
	$tab_infos['doc_width']		= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
	$tab_infos['groupe']		= "gh2";
	$tab_infos['cell_id']		= "tab";
	$tab_infos['document']		= "doc";
	$tab_infos['tab_comportement'] = 1;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
	include ("routines/website/affichage_donnees.php");
}
else {
	$tl_['txt']['eng']['invite1'] = "This part will allow you to manage Logs.";
	$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de gerer les journaux d'evennement.";

	$tl_['txt']['eng']['col_1_txt'] = "ID";				$tl_['txt']['fra']['col_1_txt'] = "ID";
	$tl_['txt']['eng']['col_2_txt'] = "Date";			$tl_['txt']['fra']['col_2_txt'] = "Date";	
	$tl_['txt']['eng']['col_3_txt'] = "Signal";			$tl_['txt']['fra']['col_3_txt'] = "Signal";
	$tl_['txt']['eng']['col_4_txt'] = "Message ID";		$tl_['txt']['fra']['col_4_txt'] = "ID message";
	$tl_['txt']['eng']['col_5_txt'] = "Initiator";		$tl_['txt']['fra']['col_5_txt'] = "Initiateur";
	$tl_['txt']['eng']['col_6_txt'] = "Action";			$tl_['txt']['fra']['col_6_txt'] = "Action";
	$tl_['txt']['eng']['col_7_txt'] = "Message";		$tl_['txt']['fra']['col_7_txt'] = "Message";

	$tab['0'] = "<span class='" . $theme_tableau.$_REQUEST['bloc']."_erreur'>Erreur</span>";	
	$tab['1'] = "<span class='" . $theme_tableau.$_REQUEST['bloc']."_ok " . $theme_tableau.$_REQUEST['bloc']."_t1'>OK</span>";		
	$tab['2'] = "<span class='" . $theme_tableau.$_REQUEST['bloc']."_avert'>Avertissement</span>";		
	$tab['3'] = "Information";		
	$tab['4'] = "Autre";

	//$tl_['nbr_col'] = 7 ; 	$i = 1;
	$pv['onglet'] = 1; $lt = 1;

	$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_['txt'][$l]['col_1_txt'];
	$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_['txt'][$l]['col_2_txt'];
	$AD[$pv['onglet']][$lt]['3']['cont'] = $tl_['txt'][$l]['col_3_txt'];
	$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_['txt'][$l]['col_4_txt'];
	$AD[$pv['onglet']][$lt]['5']['cont'] = $tl_['txt'][$l]['col_5_txt'];
	$AD[$pv['onglet']][$lt]['6']['cont'] = $tl_['txt'][$l]['col_6_txt'];
	$AD[$pv['onglet']][$lt]['7']['cont'] = $tl_['txt'][$l]['col_7_txt'];

	while ($dbp = fetch_array_sql($dbquery)) { 
		$pv['historique_action_longeur'] = strlen($dbp['historique_action']);
		switch (TRUE) {
		case ($pv['historique_action_longeur'] < 128 && $pv['historique_action_longeur'] > 64):	$dbp['historique_action2'] = substr ($dbp['historique_action'],0,59) . " [...] ";		break;
		case ($pv['historique_action_longeur'] > 128):											$dbp['historique_action2'] = substr ($dbp['historique_action'],0,59) . " [...] " . substr ($dbp['historique_action'],($pv['historique_action_longeur'] - 64) ,$pv['historique_action_longeur'] );		break;
		case ($pv['historique_action_longeur'] < 64):											$dbp['historique_action2'] = $dbp['historique_action'];	break;
		}

		$lt++;
		$AD[$pv['onglet']][$lt]['1']['cont'] = $dbp['historique_id']. "<br>\r<input type='checkbox' name='MH[selection][".$dbp['historique_id']."]'>";
		$AD[$pv['onglet']][$lt]['2']['cont'] = date ( "Y m d H:i:s" , $dbp['historique_date'] );
		$AD[$pv['onglet']][$lt]['3']['cont'] = $tab[$dbp['historique_signal']];
		$AD[$pv['onglet']][$lt]['4']['cont'] = $dbp['historique_msgid'];
		$AD[$pv['onglet']][$lt]['5']['cont'] = $dbp['historique_initiateur'];
		$AD[$pv['onglet']][$lt]['6']['cont'] = "<span
		onMouseOver=\"Bulle('".string_DAL_escape(htmlentities($dbp['historique_action']))."');\"
		onMouseOut=\"Bulle();\">\r".$dbp['historique_action2']."</span>\r";
		$AD[$pv['onglet']][$lt]['7']['cont'] = $dbp['historique_contenu'];
		$AD[$pv['onglet']][$lt]['1']['tc'] = 1;
		$AD[$pv['onglet']][$lt]['2']['tc'] = 1;
		$AD[$pv['onglet']][$lt]['3']['tc'] = 1;
		$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
		$AD[$pv['onglet']][$lt]['5']['tc'] = 1;
		$AD[$pv['onglet']][$lt]['6']['tc'] = 1;
		$AD[$pv['onglet']][$lt]['7']['tc'] = 1;
	}
}

$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $lt;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 7;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

$tab_infos['AffOnglet']			= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['NbrOnglet']			= 1;
$tab_infos['doc_height']		= $pres_[$mn]['dim_y_22'] - ${$theme_tableau}[$_REQUEST['bloc']]['tab_y'] - 32 ;
$tab_infos['doc_height']		= 96;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "gh2";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
include ("routines/website/affichage_donnees.php");

echo (
$pv['post_critere']."
<input type='hidden' name='MH[page]'	value='".$_REQUEST['MH']['page']."'>\r
<input type='hidden' name='MH[action]'	value='SUPPRESSION'>\r
<br>\r");
$tl_['eng']['sup_selec'] = "Delete selection";
$tl_['fra']['sup_selec'] = "Supprime la selection";

$_REQUEST['BS']['id']				= "bouton_suppression_log";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_submit_s3_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_submit_s3_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['sup_selec'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 0;
echo generation_bouton ();

echo ("
</form>\r

".$_REQUEST['MH']['selection_page']."
");

$JavaScriptInitDonnees[] = "var AideDynamiqueDerogation = { 'Etat':1, 'X':196, 'Y':256 };\r";

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
 		$dbp , 
 		$dbquery ,
 		$_REQUEST['MH'] ,
 		$tl_, 
 		$tl_
	);
}

/*Hydre-contenu_fin*/
?>
