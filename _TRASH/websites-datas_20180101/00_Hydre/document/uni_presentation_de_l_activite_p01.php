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
/*	uni_presentation_de_l_equipe_p01.php debut													*/
/* -------------------------------------------------------------------------------------------- */
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_presentation_de_l_equipe_p01";

$tl_['fra']['invit'] = "Le but du site est de pouvoir permettre de faire des sites web. Rien de nouveau hein? L'accent est mis sur les possibilit&eacute;s graphique et les pr&eacute;sentations.<br>\r
<br>\r
Nous d&eacute;veloppons les modules du site afin d'am&eacute;liorer les fonctionnalit&eacute;s et aussi d'en cr&eacute;er de nouvelles.<br>\r
<br>\r
Nous sommes sensibles &agrave; vos suggestions qui pourront apporter, tant &agrave; vous m&ecirc;me qu'aux autres, des &eacute;volutions int&eacute;ressantes.<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
";

$tl_['eng']['invit'] = "
The engine goal is to provide an interface to create website. Nothing new huh? A particular touch was put on graphic possibilities and layouts.<br>\r
<br>\r
We are developping 'module' to enhace functionalities and to create new ones.<br>\r
<br>\r
We are listening to suggestions that will probably bring, for us and others, interresting and useful futur evolutions. <br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
";

echo $tl_[$l]['invit'];

if ( $site_web['sw_info_debug'] < 10 ) { 
	unset (
	$pv , 
	$tl_  
	); 
}

/*Hydre-contenu_fin*/
?>
