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
/*Hydre-contenu_debut*/
$_REQUEST[sql_initiateur] = "uni_recrutement_p01";

$tl_['fra']['invit'] = "
Webmachine, de mani&egrave;re a devenir international a besoin de traducteurs pour ses articles, code, commentaires.<br>\r
<br>\r
Si vous avez des sujets int&eacute;ressants pour Multi-Web Manager n'h&eacute;sitez pas a en proposer.<br>\r
<br>\r
Si vous avez des suggestions (constructives) concernant Multi-Web Manager vous pourrez nous contacter a l'adresse suivante.<br>\r
<br>\r
<p style='text-align: center;' >\r
<a class='".$theme_tableau.$_REQUEST['bloc']."_lien skin_princ_".$_REQUEST['bloc']."_t4' href='mailto:faust@club-internet.fr'>mailto:faust@club-internet.fr</a>
</p>
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
";

$tl_['eng']['invit'] = "
In order to become international MultiWebManager needs traducers for article, code, comments.<br>\r
<br>\r
If you have interesting topics for  MultiWebManager don't hesitate to submit some.<br>\r
<br>\r
If you have suggestions for MultiWebManager you can write to this address.<br>\r
<br>\r
<p style='text-align: center;' >\r
<a class='".$theme_tableau.$_REQUEST['bloc']."_lien skin_princ_".$_REQUEST['bloc']."_t4' href='mailto:faust@club-internet.fr'>mailto:faust@club-internet.fr</a>
</p>
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
";

echo ("
<p class='".$theme_tableau.$_REQUEST['bloc']."_lien skin_princ_".$_REQUEST['bloc']."_t3' style='text-align: justify;' >\r
".$tl_[$l]['invit']."
</p>
");

if ( $site_web['sw_info_debug'] < 10 ) { 
	unset (
	$pv , 
	$tl_  
	); 
}

/*Hydre-contenu_fin*/
?>
