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
$_REQUEST['GDS_generation_stylesheet'] = 2;
$_REQUEST['GDS']['generation_go'] = 1;
$site_web['sw_stylesheet'] = 1;

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "fra_generation_stylesheet_p01";

$tl_['eng']['generation'] = "Build the stylesheet";
$tl_['fra']['generation'] = "G&eacute;n&eacute;rer le stylesheet";

$tl_['eng']['invite1'] = "This part will allow you to create dedicated Stylesheet (Cascading StyleSheet) for a MWM theme.";
$tl_['fra']['invite1'] = "Cette partie va vous permettre de g&eacute;n&eacute;rer un script au format CSS (Cascading StyleSheet) pour un des th&egrave;mes de MWM.<br>\r<br>\r";

$tl_['eng']['invite2'] = "Build the stylesheet of the theme : ";
$tl_['fra']['invite2'] = "G&eacute;n&eacute;rer le stylesheet du theme :";


if ( $site_web['sw_stylesheet'] != 1 ) { $site_web['sw_stylesheet'] = 1; }

echo ("<br>\r
<br>\r
".$tl_[$l]['invite1']."
<br>\r
<br>\r
");

echo ("
<form name='generationSS' ACTION='index.php?' method='post'>\r
<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto; '>
<tr>\r
<td>\r
".$tl_[$l]['invite2']."
<select name='GDS_generation_stylesheet' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>
");


$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT sd.theme_id,sd.theme_nom,sd.theme_titre,ss.theme_etat
FROM ".$SQL_tab['theme_descripteur']." sd , ".$SQL_tab['site_theme']." ss 
WHERE ss.site_id = '".$site_web['sw_id']."'  
AND sd.theme_id = ss.theme_id 
;");

$tl_['eng']['GDSetat0'] = "Offline";	$tl_['fra']['GDSetat0'] = "Hors ligne";
$tl_['eng']['GDSetat1'] = "Online";		$tl_['fra']['GDSetat1'] = "En ligne";
$tl_['eng']['GDSetat2'] = "Deleted";	$tl_['fra']['GDSetat2'] = "Supprim&eacute;";

$SGEtat['0'] = $tl_[$l]['GDSetat0'];
$SGEtat['1'] = $tl_[$l]['GDSetat1'];
$SGEtat['2'] = $tl_[$l]['GDSetat2'];

while ($dbp = fetch_array_sql($dbquery)) { 
	echo ("<option value='".$dbp['theme_id']."'>".$dbp['theme_titre']." (".$SGEtat[$dbp['theme_etat']].") </option>\r");
}
echo ("</select>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page']."
<input type='hidden' name='GDS[generation_go]' value='1'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
</td>\r
<td>\r
");
$_REQUEST['BS']['id']				= "bouton_election_stylesheet";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['generation'];
$_REQUEST['BS']['mode']				= 0;
$_REQUEST['BS']['taille'] 			= 0;
$_REQUEST['BS']['derniere_taille'] 	= 0;
echo generation_bouton ();
echo ("
</td>\r
</tr>\r
</table>\r
</form>\r
<br>\r
");

if ( $_REQUEST['GDS']['generation_go'] == 1 ) {

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab['theme_descripteur']." a , ".$SQL_tab['site_theme']." b 
	WHERE a.theme_id = '".$_REQUEST['GDS_generation_stylesheet']."' 
	AND a.theme_id = b.theme_id 
	;");

	$_REQUEST['bloc_backup'] = $_REQUEST['bloc'];
	$theme_tableau = "GDS_";
	$theme_tableau_a_ecrire = "theme_princ_";
	$_REQUEST['CDTTD_non_optimisation'] = 0;

	include ("routines/website/charge_donnees_theme_tableau.php");

	// --------------------------------------------------------------------------------------------
	$GDS_['largeur_ligne'] = 80;
	$GDS_['date'] = date("Y M d : H:i:s");

	$GDS_['ligne1'] = "MultiWeb Manager - ".$site_web['sw_titre'];
	$GDS_['ligne2'] = "Stylesheet du theme";
	$GDS_['ligne3'] = "Date de la generation";
	$GDS_['ligne4'] = "Nom du fichier";

	
	$stylesheet_entete = "
	/*" . str_repeat("-", ($GDS_['largeur_ligne']-4)) . "*/\r
	/* " . $GDS_['ligne1'] . str_repeat(" ", ( $GDS_['largeur_ligne'] - strlen($GDS_['ligne1']) -5) ) ."*/\r
	/*" . str_repeat("-", ($GDS_['largeur_ligne']-4)) . "*/\r
	/* ".$GDS_['ligne2']. str_repeat(" ", ( ($GDS_['largeur_ligne']/2) - strlen($GDS_['ligne2']) -3) ) . "| " . $GDS_['theme_nom'] 			. str_repeat(" ", ( ($GDS_['largeur_ligne']/2) - strlen($GDS_['theme_nom'])	-4) ) . "*/\r
	/* ".$GDS_['ligne3']. str_repeat(" ", ( ($GDS_['largeur_ligne']/2) - strlen($GDS_['ligne3']) -3) ) . "| " . $GDS_['date'] 				. str_repeat(" ", ( ($GDS_['largeur_ligne']/2) - strlen($GDS_['date']) 		-4) ) . "*/\r
	/* ".$GDS_['ligne4']. str_repeat(" ", ( ($GDS_['largeur_ligne']/2) - strlen($GDS_['ligne4']) -3) ) . "| " . $GDS_['theme_nom'].".css"	. str_repeat(" ", ( ($GDS_['largeur_ligne']/2) - strlen($GDS_['theme_nom'])	-8) ) . "*/\r
	/*" . str_repeat("-", ($GDS_['largeur_ligne']-4)) . "*/\r
	";
	include ("routines/website/charge_donnees_theme_stylesheet.php");
	$stylesheet = str_replace("	" , " ", $stylesheet);

	$theme_tableau = "theme_princ_";
	$theme_tableau_a_ecrire = "theme_princ_";
	$_REQUEST['bloc'] = $_REQUEST['bloc_backup'];
	$_REQUEST['blocG'] = decoration_nomage_bloc ( "B" , $_REQUEST['compteur_bloc'] , "G" );
	$_REQUEST['blocT'] = decoration_nomage_bloc ( "B" , $_REQUEST['compteur_bloc'] , "T" );
	$pv['ttrb'] = &${$theme_tableau}[$_REQUEST['blocT']];

	$tl_['eng']['instructions'] = "The stylesheet is in the box. Copy the text and save it in a file ( ".$GDS_['theme_nom'].".css ). Place this file in the directory named 'stylesheets'.<br>\r
	<br>\r
	This method is used for several reasons. The most common is about rights on the filesystem.<br>\r
	<br>\r";	
	$tl_['fra']['instructions'] = "Le stylesheet se trouve dans le cadre. Recopiez le texte dans un fichier dont le nom est indiqu&eacute; ( ".$GDS_['theme_nom'].".css ) que vous placerez dans le repertoire 'stylesheets'.<br>\r 
	<br>\r
	Cette m&eacute;thode est utilis&eacute;e pour diverses raisons. La principale est qu'il y a souvent des probl&egrave;mes de droits d'&eacute;criture sur le syst&egrave;me de fichier.<br>\r
	<br>\r";	

	$tl_['eng']['cadre1'] = "CSS :";
	$tl_['fra']['cadre1'] = "CSS :";

	$tl_['eng']['cadre2'] = "Memory varibles";
	$tl_['fra']['cadre2'] = "Variables m&eacute;moire";

	$theme_vars = "\$theme_princ_ = array (\n" . print_r_code ($GDS_ , "	" ) . "\n);";

	echo ("
	<br>\r
	<br>\r
	<hr>\r
	<br>\r
	".$tl_[$l]['instructions']."

	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
	<tr>\r
	<td>\r
	<form name='GDS_01' ACTION='' method='post'>\r
	".$tl_[$l]['cadre1']."<br>\r
	<textarea name='GDS_result' cols='". floor((${$theme_tableau}['theme_module_largeur_interne'] / $pv['ttrb']['fonte_size_n3'] ) * 1.35 ) ."' rows='6' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r".$stylesheet."\r</textarea>\r<br>\r
	</td>\r
	</tr>\r

	<tr>\r
	<td>\r

	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px;'>
	<tr>\r
	<td>\r
	");
	$tl_['eng']['selection'] = "Select the text";			$tl_['eng']['retour'] = "Return to selection";
	$tl_['fra']['selection'] = "Selectionner le texte";	$tl_['fra']['retour'] = "Retour a la liste";

	$_REQUEST['BS']['id']				= "bouton_selection_text1";
	$_REQUEST['BS']['type']				= "button";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
	$_REQUEST['BS']['onclick']			= "javascript:this.form.GDS_result.focus();this.form.GDS_result.select();";
	$_REQUEST['BS']['message']			= $tl_[$l]['selection'];
	$_REQUEST['BS']['mode']				= 0;
	$_REQUEST['BS']['taille'] 			= 0;
	$_REQUEST['BS']['derniere_taille'] 	= 0;
	echo generation_bouton ();

	echo ("
	</td>\r
	</tr>\r
	</table>\r

	</form>\r
	<br>\r
	<br>\r
	</td>\r
	</tr>\r

	<tr>\r
	<td>\r
	<form name='GDS_02' ACTION='' method='post'>\r
	".$tl_[$l]['cadre2']."<br>\r
	<textarea name='GDS_result' cols='". floor((${$theme_tableau}['theme_module_largeur_interne'] / $pv['ttrb']['fonte_size_n3'] ) * 1.35 ) ."' rows='6' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r".$theme_vars."\r</textarea>\r<br>\r

	<tr>\r
	<td>\r


	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px;'>
	<tr>\r
	<td>\r
	");
	$tl_['eng']['selection'] = "Select the text";			$tl_['eng']['retour'] = "Return to selection";
	$tl_['fra']['selection'] = "Selectionner le texte";	$tl_['fra']['retour'] = "Retour a la liste";

	$_REQUEST['BS']['id']				= "bouton_selection_text2";
	$_REQUEST['BS']['type']				= "button";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
	$_REQUEST['BS']['onclick']			= "javascript:this.form.GDS_result.focus();this.form.GDS_result.select();";
	$_REQUEST['BS']['message']			= $tl_[$l]['selection'];
	$_REQUEST['BS']['mode']				= 0;
	$_REQUEST['BS']['taille'] 			= 0;
	$_REQUEST['BS']['derniere_taille'] 	= 0;
	echo generation_bouton ();

	echo ("
	</td>\r
	</tr>\r
	</table>\r

	</form>\r
	<br>\r
	</td>\r
	</tr>\r
	</table>\r

	");
}

if ( $site_web['sw_info_debug'] < 10 ) { 
	unset (
		$dbp , 
		$dbquery , 
		$GDS_ , 
		$theme_tableau_a_ecrire , 
		$stylesheet , 
		$tl_,
		$stylesheet_entete
	);
}

/*Hydre-contenu_fin*/
?>
