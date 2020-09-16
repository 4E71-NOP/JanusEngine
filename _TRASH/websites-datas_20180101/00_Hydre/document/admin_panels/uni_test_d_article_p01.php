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
$_REQUEST['WM_VFA_script_id'] = "01020203110001_p02.wmcode" ;
// --------------------------------------------------------------------------------------------
//	2005 05 11 : uni_test_d_article_p01.php debut
//	2007 05 07 : Derniere modification
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_test_d_article_p01";

$colone_taille = 48;
$colone_modification = 128;
$colone_nom = ${$theme_tableau}['theme_module_largeur_interne'] - $colone_taille - $colone_modification - 32;

echo ("
<p>
Cette partie va vous permettre de tester du code WebMachine.<br>\r
<br>\r
Entrez un nom de fichier qui contient un script wmode et vous pourrez le tester directement dans l'interface de MWM.<br>\r
<br>\r
Le fichier doit se trouver dans le repertoire 'article.wmcode'.<br>\r
<br>\r
<br>\r

<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
<tr>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fctab' colspan='3'>\rListe des fichiers pr&eacute;sents dans le r&eacute;pertoire 'article.wmcode'.</td>\r
</tr>\r

<tr>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta' width='".$colone_nom."'>\r Fichier </td>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta' width='".$colone_taille."'>\r Taille </td>\r
<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta' width='".$colone_modification."'>\r Derni&egrave;re modification </td>\r
</tr>\r
</table>\r

<div  class='" . $theme_tableau . "fileselector'>\r
<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
");

$handle = opendir("../websites-datas");
$i = 1 ;
while (false !== ($file = readdir($handle))) {
	if ( $file != "." && $file != ".." ) { $AW_liste_repertoire[$i] = $file; }
	$i++; 
}

foreach ($AW_liste_repertoire as $A ) { 
	$AW_liste_fichier = array();
	echo ("<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3' colspan='3'>Repertoire ".$A." (../websites-datas/".$A."/articles.wmcode/)</td>");
	$handle = opendir("../websites-datas/".$A."/articles.wmcode/");
	while (false !== ($file = readdir($handle))) {
		if ( $file != "." && $file != ".." ) { $AW_liste_fichier[] = $file; }
	}
	closedir($handle);
	sort ($AW_liste_fichier);
	reset ($AW_liste_fichier);

	while (list ($key, $val) = each ($AW_liste_fichier)) {
		$file_stat = stat("../websites-datas/".$A."/articles.wmcode/".$val);
		$mtime = strftime ("%a %d %b %y - %H:%M", $file_stat['mtime'] );
		echo ("
		<tr>\r
		<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca' width='".$colone_nom."'>\r 
		<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href='index.php?
&WM_VFA_script_id=".$val."
&WM_VFA_script_rep=".$A.
$bloc_html['url_sldup']."
&arti_page=".$DP_['arti_page']."
' onMouseOver = \"window.status = 'Execution du script ".$val."'; return true;\" 
 onMouseOut=\"window.status = '".$site_web['sw_barre_status']."'; return true;\" 
>".$val."</a>\r </td>\r
		<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb " . $theme_tableau . $_REQUEST['bloc']."_t1' width='".$colone_taille."'>\r ".$file_stat['size']."</td>\r
		<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca " . $theme_tableau . $_REQUEST['bloc']."_t1' width='".$colone_modification."'>\r".$mtime."</td>\r
		</tr>\r
		");
	}
}

if ( !isset($_REQUEST['WM_VFA_script_id']) ) { $_REQUEST['WM_VFA_script_id'] = "test1.wmcode"; }
if ( !isset($_REQUEST['WM_VFA_script_rep']) ) { $_REQUEST['WM_VFA_script_rep']= "base"; }
if ( !isset($_REQUEST['WM_VFA_script_file']) ) { $_REQUEST['WM_VFA_script_file'] = "../websites-datas/".$_REQUEST['WM_VFA_script_rep']."/articles.wmcode/".$_REQUEST['WM_VFA_script_id']; }

echo ("
</table>
</div>

<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."

<br>\r
<center><input type='text' name='WM_VFA_script_file' value='".$_REQUEST['WM_VFA_script_file']."' size='50' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
<input type='submit' name='Submit' value='Executer' class='" . $theme_tableau . $_REQUEST['bloc']."submit_s1_128x24'></center><br>\r
");
$tl_['eng']['exec'] = "Execute";
$tl_['fra']['exec'] = "Executer";

$_REQUEST['BS']['id']				= "bouton_execution";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['exec'];
$_REQUEST['BS']['mode']				= 0;
$_REQUEST['BS']['taille'] 			= 0;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();
echo ("
</form>
<hr>
");

if ( file_exists($_REQUEST['WM_VFA_script_file']) ) {
	$document_tableau_save = $document_tableau;
	$document_tableau = "VFA_";
	${$document_tableau}['docu_cont'] = file_get_contents ($_REQUEST['WM_VFA_script_file']);
	include ("routines/website/module_affiche_document_convert.php");
	echo ("<hr>");
	echo ${$document_tableau}['docu_cont'];
	echo ("<hr>");
	$document_tableau = $document_tableau_save;
}
else { echo ("Fichier non trouv&eacute; <br>\r"); }

/*Hydre-contenu_fin*/
?>
