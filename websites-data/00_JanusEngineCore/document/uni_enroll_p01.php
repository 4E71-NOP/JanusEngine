<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

/*JanusEngine-IDE-begin*/
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
/*JanusEngine-IDE-end*/

/*JanusEngine-Content-Begin*/

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"Janus Engine, de manière a devenir international a besoin de traducteurs pour ses articles, code, commentaires.<br>\r
		<br>\r
		Si vous avez des sujets intéressants pour Janus Engine n'hésitez pas a en proposer.<br>\r
		<br>\r
		Si vous avez des suggestions (constructives) concernant Janus Engine vous pourrez nous contacter à l'adresse suivante.<br>\r
		<br>\r
		<p style='text-align: center;' >\r
		<a class='" . $Block . "_lien " . $Block . "_t4' href='mailto:someone@somedomain.net'>mailto:someone@somedomain.net</a>
		</p>
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		"
		),
		"eng" => array(
			"invite1"		=>	"In order to become international Janus Engine needs traducers for article, code, comments.<br>\r
		<br>\r
		If you have interesting topics for  Janus Engine don't hesitate to submit some.<br>\r
		<br>\r
		If you have suggestions for Janus Engine you can write to this address.<br>\r
		<br>\r
		<p style='text-align: center;' >\r
		<a class='" . $Block . "_lien " . $Block . "_t4' href='mailto:someone@somedomain.net'>mailto:someone@somedomain.net</a>
		</p>
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		"
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1') . "<br>\r<br>\r";

/*JanusEngine-Content-End*/
