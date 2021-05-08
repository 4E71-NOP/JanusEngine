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
/* @var $cs CommonSystem                            */
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

/*Hydr-Content-Begin*/

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"
			Novembre 2017 : revenu de l'enfer !<br>\r
			<br>\r
			Après que l'impensable soit arrivé, le site était cassé pour de bon. Qui aurait pu penser qu'un Linux déciderai de synchroniser des gigaoctets de données (sur un NAS) avec du rien juste avant No&euml;l… Dans ce genre de moment on reste stupéfait, sans voix, sans pouvoir y croire une seconde. Moralité : &laquo; Utilisez le à vos risques et périls &raquo;.<br>\r
			<br>\r
			Mais il y avait une lueur d'espoir. Alors… Travailler là-dessus était un pari risqué. Cependant… J'ai pu récupérer des données depuis lesquelles je pouvais redémarrer. Hydre rentrait dans la salle d'opération. <br>\r
			<br>\r
			5 mois plus tard. Tout ressemblait à un vase en morceaux. Toutes les sources (graphismes vectoriels, scripts, etc.) évanouies. Beaucoup de scripts avaient l'air d'être à l'envers. Impossible de lire ça. Le recouvrement des fichiers leur donne un nom qui va de 000000 à xxxxxx. Petit blocage mental.<br>\r
			<br>\r
			Remettre tout ensemble était long et difficile. Non seulement il faut trier mais aussi trier par version de fichier. Pour arriver à sélectionner la dernière version de chaque script / image et enfin je pourrais voir à quoi ressemble ce Frankenstein.<br>\r
			<br>\r
			Refaire tout fonctionner a été plus facile que je l'imaginais. Mais ce n'est pas si simple. Des parties n'ont pas pu être récupérées. Cela a pris encore un peu de temps pour refaire les morceaux manquants. <br>\r
			<br>\r
			Enfin nous revoilà avec ce site. C'est en ligne et le code est aussi propre qu'avant. <br>\r
			<br>\r
			Donc &laquo; ouais &raquo; Hydre est revenu de l'enfer.<br>\r
							
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		"),
		"eng" => array(
			"invite1"		=>	"
			November 2017 : Back From Hell !
			
			After that the unthinkable happened, the site was kind of out for good. Who could think that a Linux  decided to synchronize gigabytes of data (on a NAS) with nothing, just before Christmas… In this moment you just pause speechless not believing what is in front of your eyes. The bottom line is « use it at your own risk ». <br>\r<br>\r
			
			But there was hope. So… Working on it was kind of a bet. Still… I could manage to recover some data from which I could start again. Hydre was in the surgery room. <br>\r<br>\r
			
			5 months later. Everything was kind of fragmented into pieces. All graphic sources (vectors graphics, scripts, etc.), gone. Many scripts looked like they were upside down. Can't read that. Recovering files makes their name go from 000000 to xxxxxx. Puzzling at least.<br>\r<br>\r
			
			Putting everything back together for sure was long and painful. Not only you have to sort everything but also sorting by version the same file. After months sorting was done. Now selecting the last of each script / images and I will see how that frankenstein looks like. <br>\r<br>\r
			
			Making it work again was less difficult than expected. But it's not that simple. Some parts were not recovered. It took some more time to restore what was missing.<br>\r<br>\r
			
			In the end here we are with this website. It's up again and the code has been cleaned. <br>\r<br>\r
			
			So yes Hydre is back from hell.<br>\r<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		")
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

/*Hydr-Content-End*/
?>
