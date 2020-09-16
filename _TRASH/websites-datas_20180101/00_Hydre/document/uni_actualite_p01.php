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
/*	uni_actualite_p01.php debut																	*/
/* -------------------------------------------------------------------------------------------- */
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_presentation_de_l_equipe_p01";

$tl_['fra']['invit'] = "
Novembre 2017 : revenu de l'enfer !<br>\r
<br>\r
Apr&egrave;s que l'impensable soit arriv&eacute;, le site &eacute;tait cass&eacute; pour de bon. Qui aurait pu penser qu'un Linux d&eacute;ciderai de synchroniser des gigaoctets de donn&eacute;es (sur un NAS) avec du rien juste avant No&euml;l… Dans ce genre de moment on reste stup&eacute;fait, sans voix, sans pouvoir y croire une seconde. Moralit&eacute; : &laquo; Utilisez le &agrave; vos risques et p&eacute;rils &raquo;.<br>\r
<br>\r
Mais il y avait une lueur d'espoir. Alors… Travailler l&agrave;-dessus &eacute;tait un pari risqu&eacute;. Cependant… J'ai pu r&eacute;cup&eacute;rer des donn&eacute;es depuis lesquelles je pouvais red&eacute;marrer. MWM rentrait dans la salle d'op&eacute;ration. <br>\r
<br>\r
5 mois plus tard. Tout ressemblait &agrave; un vase en morceaux. Toutes les sources (graphismes vectoriels, scripts, etc.) &eacute;vanouies. Beaucoup de scripts avaient l'air d'&ecirc;tre &agrave; l'envers. Impossible de lire &ccedil;a. Le recouvrement des fichiers leur donne un nom qui va de 000000 &agrave; xxxxxx. Petit blocage mental.<br>\r
<br>\r
Remettre tout ensemble &eacute;tait long et difficile. Non seulement il faut trier mais aussi trier par version de fichier. Pour arriver &agrave; s&eacute;lectionner la derni&egrave;re version de chaque script / image et enfin je pourrais voir &agrave; quoi ressemble ce Frankenstein.<br>\r
<br>\r
Refaire tout fonctionner a &eacute;t&eacute; plus facile que je l'imaginais. Mais ce n'est pas si simple. Des parties n'ont pas pu &ecirc;tre r&eacute;cup&eacute;r&eacute;es. Cela a pris encore un peu de temps pour refaire les morceaux manquants. <br>\r
<br>\r
Enfin nous revoil&agrave; avec ce site. C'est en ligne et le code est aussi propre qu'avant. <br>\r
<br>\r
Donc &laquo; ouais &raquo; MWM est revenu de l'enfer.<br>\r

<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
";

$tl_['eng']['invit'] = "
November 2017 : Back From Hell !

After that the unthinkable happened, the site was kind of out for good. Who could think that a Linux  decided to synchronize gigabytes of data (on a NAS) with nothing, just before Christmas… In this moment you just pause speechless not believing what is in front of your eyes. The bottom line is « use it at your own risk ». <br>\r<br>\r

But there was hope. So… Working on it was kind of a bet. Still… I could manage to recover some data from which I could start again. MWM was in the surgery room. <br>\r<br>\r

5 months later. Everything was kind of fragmented into pieces. All graphic sources (vectors graphics, scripts, etc.), gone. Many scripts looked like they were upside down. Can't read that. Recovering files makes their name go from 000000 to xxxxxx. Puzzling at least.<br>\r<br>\r

Putting everything back together for sure was long and painful. Not only you have to sort everything but also sorting by version the same file. After months sorting was done. Now selecting the last of each script / images and I will see how that frankenstein looks like. <br>\r<br>\r

Making it work again was less difficult than expected. But it's not that simple. Some parts were not recovered. It took some more time to restore what was missing.<br>\r<br>\r

In the end here we are with this website. It's up again and the code has been cleaned. <br>\r<br>\r

So yes MWM is back from hell.<br>\r<br>\r
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
