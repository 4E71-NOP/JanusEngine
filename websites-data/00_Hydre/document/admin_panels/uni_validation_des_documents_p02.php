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
//	uni_gestion_des_documents_p02.php debut
// --------------------------------------------------------------------------------------------
$_REQUEST['M_DOCUME']['document_selection'] = 25;

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_correction_des_documents_p02.php";

// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT doc.*, shr.share_modification 
FROM ".$SQL_tab_abrege['document']." doc, ".$SQL_tab_abrege['document_share']." shr 
WHERE part.site_id = '".$site_web['sw_id']."' 
AND doc.docu_id = '".$_REQUEST['M_DOCUME']['document_selection']."' 
AND shr.docu_id = doc.docu_id 
AND doc.docu_origine = '".$site_web['sw_id']."' 
;");
if ( num_row_sql($dbquery) == 0 ) { 
	$tl_['eng']['perm_err'] = "You don't have the permission to modify this document";
	$tl_['fra']['perm_err'] = "Vous n'avez pas les permissions pour modifier ce document.";
	echo ("<p>".$tl_[$l]['perm_err']."</p>");
}
else {
	while ($dbp = fetch_array_sql($dbquery)) { 
		foreach ( $dbp as $A => $B ) { $document[$A] = $B; }
		$document['docu_correction_date']	= strftime ("%a %d %b %y - %H:%M", $dbp['docu_correction_date'] );
	}

	$tl_['eng']['doc_type0'] = "MWM code";		$tl_['eng']['doc_type1'] = "No code";			$tl_['eng']['doc_type2'] = "PHP";		$tl_['eng']['doc_type3'] = "Mixed";
	$tl_['fra']['doc_type0'] = "Code MWM";	$tl_['fra']['doc_type1'] = "Pas de code";	$tl_['fra']['doc_type2'] = "PHP";	$tl_['fra']['doc_type3'] = "Mix&eacute;";

	$tl_['eng']['docu_modif0'] = "No";			$tl_['eng']['docu_modif1'] = "Yes";
	$tl_['fra']['docu_modif0'] = "Non";		$tl_['fra']['docu_modif1'] = "Oui";

	$tl_['eng']['docu_correction0'] = "Not checked";			$tl_['eng']['docu_correction1'] = "Checked";
	$tl_['fra']['docu_correction0'] = "Non corrig&eacute;";	$tl_['fra']['docu_correction1'] = "corrig&eacute;";

	$tab_type['0']['t'] = $tl_[$l]['doc_type0'];	$tab_type['0']['db'] = "WMCODE";
	$tab_type['1']['t'] = $tl_[$l]['doc_type1'];	$tab_type['1']['db'] = "NOCODE";
	$tab_type['2']['t'] = $tl_[$l]['doc_type2'];	$tab_type['2']['db'] = "PHP";
	$tab_type['3']['t'] = $tl_[$l]['doc_type3'];	$tab_type['3']['db'] = "MIXED";

	$tab_modif['0']['t'] = $tl_[$l]['docu_modif0'];	$tab_modif['0']['db'] = "NO";
	$tab_modif['1']['t'] = $tl_[$l]['docu_modif1'];	$tab_modif['1']['db'] = "YES";

	$tab_correction['0']['t'] = $tl_[$l]['docu_correction0'];	$tab_correction['0']['db'] = "NO";
	$tab_correction['1']['t'] = $tl_[$l]['docu_correction1'];	$tab_correction['1']['db'] = "YES";

// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------
	$tl_['eng']['l11'] = "ID";		$tl_['eng']['l21'] = "Name";	$tl_['eng']['l31'] = "Type";		$tl_['eng']['l41'] = "Can be modified by another site";
	$tl_['fra']['l11'] = "ID";	$tl_['fra']['l21'] = "Nom";	$tl_['fra']['l31'] = "Type";	$tl_['fra']['l41'] = "Modifiable par un autre site";
	$tl_['eng']['l51'] = "Checked by";
	$tl_['fra']['l51'] = "Corrig&eacute; par";

	$pv['o1l32'] = "<select name ='M_DOCUME[type]' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1>\r";
	$tab_type[$document['docu_type']]['s'] = " selected";
	foreach ( $tab_type as $A ) { $pv['o1l32'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
	$pv['o1l32'] .= "</select>\r";

	$pv['o1l42'] = "<select name ='M_DOCUME[modification]' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	$tab_modif[$document['part_modification']]['s'] = " selected";
	foreach ( $tab_modif as $A ) { $pv['o1l42'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
	$pv['o1l42'] .= "</select>\r";

	$pv['o1l52'] = "<select name ='M_DOCUME[correction]' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	$tab_correction[$document['docu_correction']]['s'] = " selected";
	foreach ( $tab_correction as $A ) { $pv['o1l52'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
	$pv['o1l52'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
	if ( $_REQUEST['M_DOCUME']['confirmation_modification_oubli'] == 1 ) { 
		$tl_['eng']['err'] = "You didn't confirm the document updates.";
		$tl_['fra']['err'] = "Vous n'avez pas confirm&eacute; la modification du document.";
		echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur'>".$tl_[$l]['err']."<br>\r"); 
	}

	if ( $_REQUEST['M_DOCUME']['modification_effectuee'] == 1 ){ 
		$tl_['eng']['err1'] = "The document named ".$document['docu_nom']." has been updated.";
		$tl_['fra']['err1'] = "Le document ".$document['docu_nom']." a &eacute;t&eacute; mis a jour.";
		echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>".$tl_[$l]['err1']."</p><br>\r<hr>\r"); 
	}

	$tl_['eng']['invite1'] = "This part will allow you to check documents.";
	$tl_['fra']['invite1'] = "Cette partie va vous permettre de valider les documents.";
	echo ("
	<form ACTION='index.php?' method='post'>\r
	<p>
	".$tl_[$l]['invite1']."<br>\r
	</p>\r

	<br>\r
	<hr>\r
	");

	$AD['1']['1']['1']['cont'] = $tl_[$l]['l11'];
	$AD['1']['2']['1']['cont'] = $tl_[$l]['l21'];
	$AD['1']['3']['1']['cont'] = $tl_[$l]['l31'];
	$AD['1']['4']['1']['cont'] = $tl_[$l]['l41'];
	$AD['1']['5']['1']['cont'] = $tl_[$l]['l51'];

	$AD['1']['1']['2']['cont'] = $document['docu_id'];
	$AD['1']['2']['2']['cont'] = $document['docu_nom'];
	$AD['1']['3']['2']['cont'] = $pv['o1l32'];
	$AD['1']['4']['2']['cont'] = $pv['o1l42'];
	$AD['1']['5']['2']['cont'] = $pv['o1l52'];

	$ADC['onglet']['1']['nbr_ligne'] = 5;

	$tl_['eng']['onglet1'] = "Informations";
	$tl_['fra']['onglet1'] = "Informations";

	$tab_infos['AffOnglet']			= 1;
	$tab_infos['NbrOnglet']			= 1;
	$tab_infos['tab_comportement']	= 0;
	$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
	$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
	$tab_infos['doc_height']		= $pres_[$mn]['dim_y_22'] - ${$theme_tableau}[$_REQUEST['bloc']]['tab_y'] - 32 ;
	$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
	$tab_infos['groupe']			= "mb_grp1";
	$tab_infos['cell_id']			= "tab";
	$tab_infos['document']			= "doc";
	$tab_infos['cell_1_txt']		= $tl_[$l]['onglet1'];
	include ("routines/website/affichage_donnees.php");


// --------------------------------------------------------------------------------------------
	$tl_['eng']['text_confirm1'] = "I confirm the document validity.";				$tl_['eng']['bouton1'] = "OK";
	$tl_['fra']['text_confirm1'] = "Je reconnait la validit&eacute; du document.";		$tl_['fra']['bouton1'] = "OK";

	$tl_['eng']['bouton2'] = "Return to list";
	$tl_['fra']['bouton2'] = "Retour &agrave; la liste";

	$pv['ttrb'] = &${$theme_tableau}[$_REQUEST['blocT']];
	echo ("
	<table style='margin-left: auto; margin-right: auto;'>
	<tr>\r
	<td>\r
	<textarea name='M_DOCUME['cont']' cols='". floor((${$theme_tableau}['theme_module_largeur_interne'] / $pv['ttrb']['fonte_size_n3'] ) * 1.35 ) ."' rows='24' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>".$document['docu_cont']."</textarea><br>\r
	</td>\r
	</tr>\r
	</table>\r

	<input type='hidden' name='M_DOCUME[nom]'						value='".$document['docu_nom']."'>\r
	<input type='hidden' name='UPDATE_action'				value='UPDATE_DOCUMENT'>\r
	<input type='hidden' name='M_DOCUME[correction_activation]'	value='1'>\r
	<input type='hidden' name='M_DOCUME[correction]'				value='YES'>\r
	<input type='hidden' name='M_DOCUME[type]'					value='".$document['docu_type']."'>\r
	<input type='hidden' name='M_DOCUME[fichier]'					value=''>\r
	<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
	<tr>\r".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_arti_ref'].
	$bloc_html['post_hidden_arti_page'].
	$bloc_html['post_hidden_user_login'].
	$bloc_html['post_hidden_user_pass']."

	<td>\r<input type='checkbox' name='M_DOCUME[confirmation_modification]' value='1'>".$tl_[$l]['text_confirm1']."\r</td>\r
	<td style='text-align: right;'>\r");
	$_REQUEST['BS']['id']				= "bouton_modification";
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

	<form ACTION='index.php?' method='post'>\r".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_arti_ref']."
	<input type='hidden' name='arti_page'	value='1'>\r".
	$bloc_html['post_hidden_user_login'].
	$bloc_html['post_hidden_user_pass']."
	<tr>\r
	<td>\r</td>\r
	<td style='text-align: right;'>\r");
	$_REQUEST['BS']['id']				= "bouton_retour_liste";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['bouton2'];
	$_REQUEST['BS']['mode']				= 1;
	$_REQUEST['BS']['taille'] 			= 0;
	echo generation_bouton ();
	echo ("<br>\r&nbsp;</td>\r
	</tr>\r
	</form>\r
	</table>\r
	");
}

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$document,
		$dbp,
		$dbquery,
		$AD,
		$ADC,
		$pv, 
		$tab_modif,
		$tab_type,
		$tl_
	);
}

/*Hydre-contenu_fin*/
?>
