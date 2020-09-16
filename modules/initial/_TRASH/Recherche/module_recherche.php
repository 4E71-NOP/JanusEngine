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
//	Module : Recherche
// --------------------------------------------------------------------------------------------
$localisation = " / module_recherche";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_recherche");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_recherche");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_recherche");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$_REQUEST['sql_initiateur'] = "Module Recherche";
$l = $langues[$WebSiteObj->getWebSiteEntry('sw_lang')]['langue_639_3'];

$tl_['fra']['txt1'] = "Rechercher:"; 					$tl_['eng']['txt1'] = "Search"; 
$tl_['fra']['txt2'] = "Valider"; 						$tl_['eng']['txt2'] = "Go"; 
$tl_['fra']['txt10'] = "Pas suppos&eacute; voir ca"; 	$tl_['eng']['txt10'] = "Not supposed to see it"; 
$tl_['fra']['radio1'] = "Tag";							$tl_['eng']['radio1'] = "Tag";
$tl_['fra']['radio2'] = "Contenu article";				$tl_['eng']['radio2'] = "Article content";

if ( $user['groupe'][$module_['module_groupe_pour_utiliser']] == 1 ) {
	echo ( "<span class='" . $theme_tableau . $_REQUEST['bloc']."_tb2'>" . $tl_[$l]['txt1'] . "</span>
	<form ACTION='index.php?' method='post'>\r".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_user_login'].
	$bloc_html['post_hidden_user_pass']."

	<input type='hidden' name='arti_ref'		value='".$l."_recherche'>\r
	<input type='hidden' name='arti_page'		value='1'>\r

	<table style='width:".(${$theme_tableau}['theme_module_largeur_interne']-16)."px; margin-right:auto; margin-left:auto' >
	<tr>\r
	<td>\r
	<input type='radio' name='type_recherche'	value='T'>".$tl_[$l]['radio1']."\r
	</td>\r
	<td>\r
	<input type='radio' name='type_recherche'	value='A' checked>".$tl_[$l]['radio2']."\r
	</td>\r
	</tr>\r

	<tr>\r
	<td colspan=2 style='text-align: center;'>\r
	<input type='text' name='expression_recherche' size='10' maxlength='64' value='' class='".$theme_tableau.$_REQUEST['bloc']."_form_2 ".$theme_tableau.$_REQUEST['bloc']."_t3'>
	</td>\r
	</tr>\r
	<tr>\r
	<td  colspan=2 style='text-align: center;'>\r
	");
	$_REQUEST['BS']['id']				= "bouton_module_recherche";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= $theme_tableau.$_REQUEST['bloc']."_t3 ".$theme_tableau.$_REQUEST['bloc']."_submit_s1_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau.$_REQUEST['bloc']."_t3 ".$theme_tableau.$_REQUEST['bloc']."_submit_s1_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['txt2'];
	$_REQUEST['BS']['mode']				= 0;
	$_REQUEST['BS']['taille'] 			= 0;
	$_REQUEST['BS']['derniere_taille']	= 0;
	echo generation_bouton ();
	echo ("
	</td>\r
	</tr>\r
	</table>\r
	</form>\r
	");
}

else {
	echo ( $tl_[$l]['txt10'] );
}

if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
	unset ( $tl_ );
}

?>
