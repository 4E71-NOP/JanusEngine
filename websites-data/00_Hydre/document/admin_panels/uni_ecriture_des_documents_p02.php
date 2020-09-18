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
//	uni_ecriture_des_documents_p02.php debut
// --------------------------------------------------------------------------------------------
$_REQUEST['M_DOCUME']['document_selection'] = 107;
$user['group_tag'] = 1;
$pv['execution_script'] = 1;


/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_ecriture_des_documents_p02.php";
// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------
$tl_['eng']['doc_type']['0'] = "MWM code";		$tl_['fra']['doc_type']['0'] = "Code MWM";
$tl_['eng']['doc_type']['1'] = "No code";		$tl_['fra']['doc_type']['1'] = "Pas de code";
$tl_['eng']['doc_type']['2'] = "PHP";			$tl_['fra']['doc_type']['2'] = "PHP";
$tl_['eng']['doc_type']['3'] = "Mixed";			$tl_['fra']['doc_type']['3'] = "Mix&eacute;";

$tl_['eng']['docu_modif']['0'] = "No";			$tl_['fra']['docu_modif']['0'] = "Non";
$tl_['eng']['docu_modif']['1'] = "Yes";			$tl_['fra']['docu_modif']['1'] = "Oui";

$tl_['eng']['lien_modif0'] = "Modify the document content.";
$tl_['fra']['lien_modif0'] = "Modifier le contenu de ce document.";

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT doc.*, shr.share_modification 
FROM ".$SQL_tab_abrege['document']." doc, ".$SQL_tab_abrege['document_share']." shr 
WHERE shr.ws_id = '".$website['ws_id']."' 
AND doc.docu_id = '".$_REQUEST['M_DOCUME']['document_selection']."' 
AND shr.docu_id = doc.docu_id 
AND doc.docu_origine = '".$website['ws_id']."' 
;");

while ($dbp = fetch_array_sql($dbquery)) { 
	foreach ( $dbp as $A => $B ) { $document[$A] = $B; }
	$document['docu_correction_date']	= strftime ("%a %d %b %y - %H:%M", $dbp['docu_correction_date'] );
	$document['docu_type_pres']		= $tl_[$l]['doc_type'][$dbp['docu_type']];
	$document['part_modification']	= $tl_[$l]['docu_modif'][$dbp['part_modification']];
}

switch ( $document['docu_type'] ) {
	case 0:		/*MWM code*/
		$document['docu_cont'] = str_replace("['BR']\n","\n", $document['docu_cont']);
		$document['docu_cont'] = str_replace("['BR']","\n", $document['docu_cont']);
	break;
	case 1:		/* no code*/
	break;
	case 2:		/*PHP*/
		$pv['rch'] = array ( "<textarea",		"</textarea" );
		$pv['rpl'] = array ( "<MWM_textarea",	"<MWM_/textarea" );
		$document['docu_cont'] = str_replace( $pv['rch'], $pv['rpl'], $document['docu_cont'] );
	break;
	case 3:		/*mixed : faire une routine d'analyse*/
	break;
}
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT usr.user_login,s.ws_name 
FROM ".$SQL_tab_abrege['user']." usr , ".$SQL_tab_abrege['group_user']." gu , ".$SQL_tab_abrege['group_website']." sg , ".$SQL_tab_abrege['website']." s 
WHERE usr.user_id = '".$document['docu_correcteur']."' 
AND gu.group_user_initial_group = '1' 
AND usr.user_id = gu.user_id 
AND gu.group_id = sg.group_id 
AND sg.ws_id = s.ws_id 
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	$document['docu_correcteur_login']	= $dbp['user_login'];
	$document['docu_correcteur_site']	= $dbp['ws_name'];
}
$document['edition'] = 1;


/* User check : URL hax*/

if ( $pv['execution_script'] == 1 ) { $_REQUEST['M_DOCUME']['haxorzfree'] = 1; }
else {
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT dcm.docu_id, art.arti_id, bcl.deadline_id, dcm.docu_nom 
	FROM ".$SQL_tab_abrege['article']." art, ".$SQL_tab_abrege['deadline']." bcl , ".$SQL_tab_abrege['document']." dcm
	WHERE art.docu_id = ".$_REQUEST['M_DOCUME']['document_selection']." 
	AND dcm.docu_id = art.docu_id 
	AND art.arti_deadline = bcl.deadline_id 
	AND bcl.deadline_state = '1' 
	AND art.ws_id = '".$website['ws_id']."'
	ORDER BY dcm.docu_id ASC 
	;");
	while ($dbp = fetch_array_sql($dbquery)) { 
		if ( $document['docu_id'] == $dbp['docu_id'] ) { $document['edition'] = 0; } 
	}
	$pv['level']['0'] = 2;	$pv['level']['1'] = 4;	$pv['level']['2'] = 8;	$pv['level']['3'] = 16;
	$pv['edlvl'] = $pv['level'][$user['group_tag']];
	$_REQUEST['M_DOCUME']['haxorzfree'] = 0;
	switch ( $pv['edlvl'] + $document['edition'] ) {
	case 9 :
	case 16 :
	case 17 :
		$_REQUEST['M_DOCUME']['haxorzfree'] = 1;
	break;
	} 
}

// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------
if ( $_REQUEST['M_DOCUME']['haxorzfree'] == 1 ) {
	$tl_['eng']['l11'] = "ID";										$tl_['fra']['l11'] = "ID";	
	$tl_['eng']['l21'] = "Name";									$tl_['fra']['l21'] = "Nom";	
	$tl_['eng']['l31'] = "Type";									$tl_['fra']['l31'] = "Type";	
	$tl_['eng']['l41'] = "Can be modified by another site";			$tl_['fra']['l41'] = "Modifiable par un autre site";
	$tl_['eng']['l51'] = "Checked by";								$tl_['fra']['l51'] = "Corrig&eacute; par";

	$pv['o1l52'] = "/ ". $document['docu_correcteur_site'] . " / " . $document['docu_correcteur_login'] . " : " . $document['docu_correction_date']; 
	$tl_['eng']['doc_type']['0'] = "MWM code";						$tl_['fra']['doc_type']['0'] = "Code MWM";	
	$tl_['eng']['doc_type']['1'] = "No code";						$tl_['fra']['doc_type']['1'] = "Pas de code";
	$tl_['eng']['doc_type']['2'] = "PHP";							$tl_['fra']['doc_type']['2'] = "PHP";
	$tl_['eng']['doc_type']['3'] = "Mixed";							$tl_['fra']['doc_type']['3'] = "Mix&eacute;";
	$tl_['eng']['docu_modif']['0'] = "No";							$tl_['fra']['docu_modif']['0'] = "Non";
	$tl_['eng']['docu_modif']['1'] = "Yes";							$tl_['fra']['docu_modif']['1'] = "Oui";
	$tl_['eng']['lien_modif0'] = "Modify the document content.";	$tl_['fra']['lien_modif0'] = "Modifier le contenu de ce document.";
	
// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
	$tl_['eng']['invite1'] = "This part will allow you to modify documents.";
	$tl_['fra']['invite1'] = "Cette partie va vous permettre de modifier les documents.";
	
	
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
	<p>
	".$tl_[$l]['invite1']."<br>\r
	</p>\r
	<br>\r
	");
	
	$AD['1']['1']['1']['cont'] = $tl_[$l]['l11'];
	$AD['1']['2']['1']['cont'] = $tl_[$l]['l21'];
	$AD['1']['3']['1']['cont'] = $tl_[$l]['l31'];
	$AD['1']['4']['1']['cont'] = $tl_[$l]['l41'];
	$AD['1']['5']['1']['cont'] = $tl_[$l]['l51'];
	
	$AD['1']['1']['2']['cont'] = $document['docu_id'];
	$AD['1']['2']['2']['cont'] = $document['docu_nom'];
	$AD['1']['3']['2']['cont'] = $document['docu_type_pres'];
	$AD['1']['4']['2']['cont'] = $document['part_modification'];
	$AD['1']['5']['2']['cont'] = $pv['o1l52'];
	
	$ADC['onglet']['1']['nbr_ligne'] = 5;
	$ADC['onglet']['1']['nbr_cellule'] = 2;
	$ADC['onglet']['1']['legende'] = 2;
	
	$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

	$tab_infos['AffOnglet']			= 1;
	$tab_infos['NbrOnglet']			= 1;
	$tab_infos['tab_comportement']	= 0;
	$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
	$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
	$tab_infos['doc_height']		= 160;
	$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -16 ;
	$tab_infos['groupe']			= "ed_grp1";
	$tab_infos['cell_id']			= "tab";
	$tab_infos['document']			= "doc";
	$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
	include ("routines/website/affichage_donnees.php");



// --------------------------------------------------------------------------------------------
	if ( $document['part_modification'] == 1 ) {


		echo ("<br>\r
	<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_tb4' href='index.php?
	&amp;M_DOCUME['document_selection']=".$document['docu_id'].
	$bloc_html['url_slup']."
	&amp;arti_ref=fra_correction_document
	&amp;arti_page=2'>".$tl_[$l]['lien_modif0']." &gt; &gt;</a>
	<br>\r
		");
	}

	$_REQUEST['FS_index']++;
	$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
	$fsi['left']					= 16;
	$fsi['top']						= 16;
	$fsi['width']					= 768;
	$fsi['height']					= 512;
	$fsi['js_cs']					= "";
	$fsi['formulaire']				= "formulaire_M_DOCUME";
	$fsi['champs']					= "M_DOCUME[fichier]";
	$fsi['lsdf_chemin']				= "../websites-datas/".$website['ws_directory']."/document/";
	$fsi['mode_selection']			= "fichier";
	$fsi['lsdf_mode']				= "tout";
	$fsi['lsdf_nivmax']				= 10;
	$fsi['lsdf_indicatif']			= "M_DOCUME";
	$fsi['lsdf_parent_idx']			= 1;
	$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
	$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
	$fsi['lsdf_racine']				= "F";
	$fsi['lsdf_coupe_chemin']		= 0;
	$fsi['lsdf_conserve_chemin']	= "";
	$fsi['lsdf_coupe_repertoire']	= 0;
	$fsi['liste_fichier']			= array();

	$tl_['eng']['text_confirm1'] = "I confirm the document modifications.";		$tl_['eng']['bouton1'] = "Modify";
	$tl_['fra']['text_confirm1'] = "Je valide la modification du document.";	$tl_['fra']['bouton1'] = "Modifier";
	
	$tl_['eng']['bouton2'] = "Return to list";					$tl_['fra']['bouton2'] = "Retour &agrave; la liste";
	$tl_['eng']['boutonEdition'] = "Edit the content";			$tl_['fra']['boutonEdition'] = "Editer le contenu";
	$tl_['eng']['gardcom'] = "Preserve source comments";		$tl_['fra']['gardcom'] = "Conserver les commentaires du source";
	$tl_['eng']['fichier'] = "File to insert for replacing";	$tl_['fra']['fichier'] = "Fichier a ins&eacute;rer en remplacement";
	
	$tl_['eng']['avertissement_modification'] = "
	<span class='" . $theme_tableau . $_REQUEST['bloc']."_tb3'>Some text string have been replaced due to HTML conflicts:</span><br>
	&lt;\textarea = &lt;MWM_textarea<br>
	&lt;/textarea = &lt;/MWM_textarea<br>
	Strings containing \"MWM_xxxx\" will be processed during insertion.
	";
	$tl_['fra']['avertissement_modification'] = "
	<span class='" . $theme_tableau . $_REQUEST['bloc']."_tb3'>Certaines chaine de texte ont &eacute;t&eacute; chang&eacute; pour cause de conflit HTML:</span><br>
	&lt;textarea = &lt;MWM_textarea<br>
	&lt;textarea = &lt;/MWM_textarea<br>
	Les chaines contenant \"MWM_xxxx\" seront converties durant l'insertion.
	";
	
	echo ("	
	</table>\r
	<br>\r
	<form name='formulaire_M_DOCUME' ACTION='index.php?' method='post'>\r

	<table ".${$theme_tableau}['tab_std_rules']." width='".(${$theme_tableau}['theme_module_largeur_interne']-16)."' style='margin-left: auto; margin-right: auto;'>
	<tr>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca' colspan='2'>\r
	<input type='checkbox' name ='M_DOCUME[gardcom]' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1' checked>\r
	".$tl_[$l]['gardcom']."</td>\r
	</tr>\r

	<tr>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'>\r
	".$tl_[$l]['fichier']."
	</td>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'>\r
	".
	generation_icone_selecteur_fichier ( 3 , $fsi['formulaire'] , $fsi['champs'] , 40 , "" , "TabSDF_".$fsi['lsdf_indicatif'] )
	."
	</td>\r
	</tr>\r
	</table>\r
	<br>\r

	");
	$_REQUEST['BS']['id']				= "bouton_bloc_edition";
	$_REQUEST['BS']['type']				= "button";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
	$_REQUEST['BS']['onclick']			= "CommuteAffichage ( 'EDD2_bloc_edition' )";
	$_REQUEST['BS']['message']			= $tl_[$l]['boutonEdition'];
	$_REQUEST['BS']['mode']				= 1;
	$_REQUEST['BS']['taille'] 			= 160;
	$_REQUEST['BS']['derniere_taille']	= 0;
	echo generation_bouton ();

	$pv['ttrb'] = &${$theme_tableau}[$_REQUEST['blocT']];
	echo ("
	<div id='EDD2_bloc_edition' style='visibility: hidden; display: none;'>\r
	<table style='margin-left: auto; margin-right: auto;'>\r
	<tr>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta'>\r
	".$tl_['fra']['avertissement_modification']."
	</td>\r
	</tr>\r

	<tr>\r
	<td>\r
	<textarea name='M_DOCUME[cont]' cols='". floor((${$theme_tableau}['theme_module_largeur_interne'] / $pv['ttrb']['fonte_size_n3'] ) * 1.35 ) ."' rows='24' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>
	".$document['docu_cont']."
	</textarea>
	</td>\r
	</tr>\r
	</table>\r
	</div>

	<br>\r
	<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
	<tr>\r

	<input type='hidden' name='M_DOCUME[nom]'				value='".$document['docu_nom']."'>\r
	<input type='hidden' name='M_DOCUME[type]'			value='".$document['docu_type']."'>\r
	<input type='hidden' name='UPDATE_action'		value='UPDATE_DOCUMENT'>\r".
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
	$_REQUEST['BS']['taille'] 			= 0;
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

else {
	$tl_['eng']['hax'] = "You are <b>NOT</b> allowed to modify this document.";
	$tl_['fra']['hax'] = "Vous n'&ecirc;tes <b>pas</b> autoris&eacute;é a modifier ce document.";
	echo ("!!! " . $tl_[$l]['hax'] . " !!!");
}

if ( $website['ws_info_debug'] < 10 ) {
	unset (
		$document,
		$dbp,
		$dbquery,
		$file,
		$file_stat,
		$FS_donnees,
		$handle,
		$liste_fichier,
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
