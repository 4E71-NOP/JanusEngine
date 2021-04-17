<?php
/*Hydre-licence-begin*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $bts BaseToolSet                            */
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
/*Hydre-IDE-end*/

// $LOG_TARGET = $LMObj->getInternalLogTarget();
// $LMObj->setInternalLogTarget("both");

// --------------------------------------------------------------------------------------------
$bts->RequestDataObj->setRequestData('scriptFile', '01020203110001_p02.wmcode');
$bts->RequestDataObj->setRequestData('scriptFile', 'uni_recherche_p01.php');

// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$localisation = " / uni_article_test_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_article_test_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_article_test_p01.php");

$colone_taille = 48;
$colone_modification = 128;
$colone_nom = $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') - $colone_taille - $colone_modification - 32;

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
		"invite1"		=>	"Cette partie va vous permettre de tester du code Hydr (BBCode like).<br>\r
<br>\r
Entrez un nom de fichier qui contient un script wmode et vous pourrez le tester directement dans l'interface de MWM.<br>\r
<br>\r
Le fichier doit se trouver dans le repertoire 'article.wmcode'.<br>\r",
		"result"		=> "Résultat de votre recherche:",
		"noResult"		=> "Aucun résultat",
		"err1"			=> "Expression trop courte",
		"btn1"			=> "Exécuter",
		));
		break;
	case "eng":
		$bts->I18nTransObj->apply(array(
		"invite1"		=>	"This part will help you test Hydr code (BBcode like).<br>\r
<br>\r
Enter the filename containing a Hydr script and you will be able to test it directly into this interface.<br>\r
<br>\r
The file must be in the directory 'article.wmcode'.<br>\r",
		"result"		=> "Search results:",
		"noResult"		=> "No result",
		"err1"			=> "Expression too short",
		"btn1"			=> "Execute",
		));
		break;
}

// --------------------------------------------------------------------------------------------

$colone_taille = 48;
$colone_modification = 128;
$colone_nom = $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') - $colone_taille - $colone_modification - 32;

$Content .= "
<p>
".$bts->I18nTransObj->getI18nTransEntry('invite1')."
<br>\r
<br>\r

<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules')." width='".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."'>\r
<tr>\r
<td class='" . $Block."_fctab' colspan='3'>\rListe des fichiers pr&eacute;sents dans le r&eacute;pertoire 'article.wmcode'.</td>\r
</tr>\r

<tr>\r
<td class='" . $Block."_fcta' width='".$colone_nom."'>\r Fichier </td>\r
<td class='" . $Block."_fcta' width='".$colone_taille."'>\r Taille </td>\r
<td class='" . $Block."_fcta' width='".$colone_modification."'>\r Derni&egrave;re modification </td>\r
</tr>\r
</table>\r

<div  class='".$ThemeDataObj->getThemeName()."fileselector'>\r
<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules')." width='".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."'>\r
";

$handle = opendir("../websites-data");
$i = 1 ;
$AW_liste_repertoire = array();
while (false !== ($file = readdir($handle))) {
	if ( $file != "." && $file != ".." ) { $AW_liste_repertoire[$i] = $file; }
	$i++; 
}

foreach ($AW_liste_repertoire as $A ) { 
	$AW_liste_fichier = array();
	$Content .= "<td class='".$Block."_fcta ".$Block."_tb3' colspan='3'>Repertoire ".$A." (../websites-data/".$A."/document/)</td>";
	$handle = opendir("../websites-data/".$A."/document");
	while (false !== ($file = readdir($handle))) {
		$err = 0;
		if ($file == "." && $file == "..") {$err = 1;}
		if ($err == 0 ) { $AW_liste_fichier[] = $file; }
	}
	closedir($handle);
	sort ($AW_liste_fichier);
	reset ($AW_liste_fichier);

	while (list ($key, $val) = each ($AW_liste_fichier)) {
		$file_stat = stat("../websites-data/".$A."/document/".$val);
// 		if (!$file_stat) {
			$mtime = strftime ("%a %d %b %y - %H:%M", $file_stat['mtime'] );
			$Content .= "
			<tr>\r
			<td class='".$Block."_fca' width='".$colone_nom."'>\r 
			<a class='".$Block."_lien' href='index.php?
			&WM_VFA_script_id=".$val."
			&WM_VFA_script_rep=".$A.
			$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup')."
			&arti_page=".$DocumentDataObj->getDocumentDataEntry('arti_page')."'
			>".$val."</a>\r </td>\r
			<td class='".$Block."_fcb ".$Block."_t1' width='".$colone_taille."'>\r ".$file_stat['size']."</td>\r
			<td class='".$Block."_fca ".$Block."_t1' width='".$colone_modification."'>\r".$mtime."</td>\r
			</tr>\r
			";
// 		}
	}
}



if ( !isset($_REQUEST['WM_VFA_script_id']) )	{ $_REQUEST['WM_VFA_script_id'] = "test1.wmcode"; }
if ( !isset($_REQUEST['WM_VFA_script_rep']) )	{ $_REQUEST['WM_VFA_script_rep']= "base"; }
if ( !isset($_REQUEST['WM_VFA_script_file']) )	{ $_REQUEST['WM_VFA_script_file'] = "../websites-data/".$_REQUEST['WM_VFA_script_rep']."/articles.wmcode/".$_REQUEST['WM_VFA_script_id']; }

$Content .= "
</table>
</div>

<form ACTION='index.php?' method='post'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<br>\r
<center><input type='text' name='WM_VFA_script_file' value='".$_REQUEST['WM_VFA_script_file']."' size='50' maxlength='255' class='".$Block."_t3 ".$Block."_form_1'>\r
<input type='submit' name='Submit' value='Executer' class='".$Block."submit_s1_128x24'></center><br>\r
";

$SB = array(
		"id"				=> "execButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s1_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s1_h",
		"onclick"			=> "",
		"message"			=> $bts->I18nTransObj->getI18nTransEntry('btn1'),
		"mode"				=> 0,
		"size" 				=> 0,
		"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
$Content .= "
</form>
<hr>
";

if ( file_exists($_REQUEST['WM_VFA_script_file']) ) {
	$document_tableau_save = $ThemeDataObj->getThemeName();
	$document_tableau = "VFA_";
	${$document_tableau}['docu_cont'] = file_get_contents ($_REQUEST['WM_VFA_script_file']);
	include ("engine/module_affiche_document_convert.php");
	$Content .= "<hr>";
	$Content .= ${$document_tableau}['docu_cont'];
	$Content .= "<hr>";
	$document_tableau = $document_tableau_save;
}
else { $Content .= "Fichier non trouv&eacute; <br>\r"; }

/*Hydre-contenu_fin*/
?>
