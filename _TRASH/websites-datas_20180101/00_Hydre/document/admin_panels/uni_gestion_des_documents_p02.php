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
//	2008 04 22 : uni_gestion_des_documents_p02.php debut
//	2008 04 22 : Derniere modification
// --------------------------------------------------------------------------------------------
$_REQUEST['M_DOCUME']['document_selection'] = 79; // doit etre un document qui ne soit pas un document d'admin
$_REQUEST['uni_gestion_des_documents_p'] = 3;

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_gestion_des_documents_p02.php";

// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------
switch ( $_REQUEST['uni_gestion_des_documents_p'] ) {
case 2:
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT doc.*, part.part_modification 
	FROM ".$SQL_tab_abrege['document']." doc, ".$SQL_tab_abrege['document_partage']." part 
	WHERE part.site_id = '".$site_web['sw_id']."' 
	AND doc.docu_id = '".$_REQUEST['M_DOCUME']['document_selection']."' 
	AND part.docu_id = doc.docu_id 
	AND doc.docu_origine = '".$site_web['sw_id']."' 
	;");

	while ($dbp = fetch_array_sql($dbquery)) { 
		foreach ( $dbp as $A => $B ) { $document[$A] = $B; }
		$document['docu_correction_date']	= strftime ("%a %d %b %y - %H:%M", $dbp['docu_correction_date'] );
	}

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT usr.user_login,s.sw_nom 
	FROM ".$SQL_tab_abrege['user']." usr , ".$SQL_tab_abrege['groupe_user']." gu , ".$SQL_tab_abrege['site_groupe']." sg , ".$SQL_tab_abrege['site_web']." s 
	WHERE usr.user_id = '".$document['docu_correcteur']."' 
	AND gu.groupe_premier = '1' 
	AND usr.user_id = gu.user_id 
	AND gu.groupe_id = sg.groupe_id 
	AND sg.site_id = s.sw_id 
	;");
	while ($dbp = fetch_array_sql($dbquery)) { 
		$document['docu_correcteur_login']	= $dbp['user_login'];
		$document['docu_correcteur_site']	= $dbp['sw_nom'];
	}
break;
case 3:
	$document['docu_type'] = 0;
	$document['part_modification'] = 0;
	$document['docu_id'] = "N/A";
	$document['docu_nom'] = "<input type='text' name='M_DOCUME[nom]' size='35' maxlength='255' value='Nouveaux_document' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
break;
}
// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------
$tl_['eng']['l1'] = "ID";								$tl_['fra']['l1'] = "ID";
$tl_['eng']['l2'] = "Name";								$tl_['fra']['l2'] = "Nom";
$tl_['eng']['l3'] = "Type";								$tl_['fra']['l3'] = "Type";
$tl_['eng']['l4'] = "Can be modified by another site";	$tl_['fra']['l4'] = "Modifiable par un autre site";
$tl_['eng']['l5'] = "Checked by";						$tl_['fra']['l5'] = "Corrig&eacute; par";

$tl_['eng']['doc_type0'] = "MWM code";					$tl_['fra']['doc_type0'] = "Code MWM";
$tl_['eng']['doc_type1'] = "No code";					$tl_['fra']['doc_type1'] = "Pas de code";
$tl_['eng']['doc_type2'] = "PHP";						$tl_['fra']['doc_type2'] = "PHP";
$tl_['eng']['doc_type3'] = "Mixed";						$tl_['fra']['doc_type3'] = "Mix&eacute;";

$tl_['eng']['docu_modif0'] = "No";						$tl_['fra']['docu_modif0'] = "Non";
$tl_['eng']['docu_modif1'] = "Yes";						$tl_['fra']['docu_modif1'] = "Oui";

$tl_['eng']['lien_modif0'] = "Modify the document content.";	$tl_['fra']['lien_modif0'] = "Modifier le contenu de ce document.";


// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
$tl_['eng']['invite1'] = "This part will allow you to modify documents.";
$tl_['fra']['invite1'] = "Cette partie va vous permettre de modifier les documents.";

$pv['o1l3'] = "<select name ='M_DOCUME[type]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$pv['tab_type']['0']['t'] = $tl_[$l]['doc_type0'];	$pv['tab_type']['0']['db'] = "WMCODE";
$pv['tab_type']['1']['t'] = $tl_[$l]['doc_type1'];	$pv['tab_type']['1']['db'] = "NOCODE";
$pv['tab_type']['2']['t'] = $tl_[$l]['doc_type2'];	$pv['tab_type']['2']['db'] = "PHP";
$pv['tab_type']['3']['t'] = $tl_[$l]['doc_type3'];	$pv['tab_type']['3']['db'] = "MIXED";
$pv['tab_type'][$document['docu_type']]['s'] = " selected";
foreach ( $pv['tab_type'] as $A ) { $pv['o1l3'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$pv['o1l3'] .= "</select>\r";

$pv['o1l4'] = "<select name ='M_DOCUME[modification]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$pv['tab_modif']['0']['t'] = $tl_[$l]['docu_modif0'];	$pv['tab_modif']['0']['db'] = "NO";
$pv['tab_modif']['1']['t'] = $tl_[$l]['docu_modif1'];	$pv['tab_modif']['1']['db'] = "YES";
$pv['tab_modif'][$document['part_modification']]['s'] = " selected";
foreach ( $pv['tab_modif'] as $A ) { $pv['o1l4'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$pv['o1l4'] .= "</select>\r";

if ( $document['part_modification'] == 1 ) {
	$pv['o1l5'] = "<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_tb4' href='index.php?
&amp;M_DOCUME[document_selection]=".$document['docu_id'].
$bloc_html['url_slup']."
&amp;arti_ref=fra_correction_document
&amp;arti_page=2'
 onMouseOver = \"window.status = 'Execution du script'; return true;\" 
 onMouseOut=\"window.status = '".$site_web['sw_barre_status']."'; return true;\" 
>".$tl_[$l]['lien_modif0']." &gt; &gt;</a>
";
	$pv['o1l5plus'] = 1;
}

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

echo ("
<form ACTION='index.php?' method='post'>\r
<p>".$tl_[$l]['invite1']."</p>
");

$AD['1']['1']['1']['cont'] = $tl_[$l]['l1'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['l2'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['l3'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['l4'];
$AD['1']['5']['1']['cont'] = $tl_[$l]['l5'];

$AD['1']['1']['2']['cont'] = $document['docu_id'];
$AD['1']['2']['2']['cont'] = $document['docu_nom'];
$AD['1']['3']['2']['cont'] = $pv['o1l3'];
$AD['1']['4']['2']['cont'] = $pv['o1l4'];
$AD['1']['5']['2']['cont'] = "/ ".$document['docu_correcteur_site']." / ".$document['docu_correcteur_login']." : ".$document['docu_correction_date'];

$ADC['onglet']['1']['nbr_ligne'] = 5 + $pv['o1l5plus'];
$ADC['onglet']['1']['nbr_cellule'] = 2;
$ADC['onglet']['1']['legende'] = 2;

$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 160;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "gd_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------
$tl_['eng']['bouton2'] = "Return to list";			$tl_['fra']['bouton2'] = "Retour &agrave; la liste";

echo ("	
<br>\r
<br>\r
");

switch ( $_REQUEST['uni_gestion_des_documents_p'] ) {
case 2:
	$tl_['eng']['bouton1'] = "Modify";			$tl_['fra']['bouton1'] = "Modifier";
	$pv['textebouton1'] = "<input type='checkbox' name='M_DOCUME[confirmation_modification]' value='1'>";
	$tl_['eng']['text_confirm1'] = $pv['textebouton1']."I confirm the document modifications.";
	$tl_['fra']['text_confirm1'] = $pv['textebouton1']."Je valide la modification du document.";
	echo ("
	<input type='hidden' name='M_DOCUME[nom]'			value='".$document['docu_nom']."'>\r
	<input type='hidden' name='uni_gestion_des_documents_p'			value='2'>\r
	<input type='hidden' name='UPDATE_action'			value='UPDATE_DOCUMENT'>\r
	");
break;
case 3:
	$tl_['eng']['bouton1'] = "Create";			$tl_['fra']['bouton1'] = "Cr&eacute;er";
	echo ("
	<input type='hidden' name='UPDATE_action'			value='ADD_DOCUMENT'>\r
	");
	$tl_['eng']['text_confirm1'] = "This will create a document and and directly moves you to the modification panel of this new document";
	$tl_['fra']['text_confirm1'] = "Ceci va cr&eacute;er un document et vous em&egrave;nera directement dans l'interface de modification de ce nouveau document.";
	//$pv['textebouton1'] = $tl_[$l]['text_confirm1'];

break;
}

echo ("	
<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
<tr>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."

<td>\r".$tl_[$l]['text_confirm1']."\r</td>\r
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
if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$document,
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
