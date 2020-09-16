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
//docutag_id 
//docu_id
//tag_id

$_REQUEST['liste_colonne']['tag'] = array (
"tag_id",
"tag_nom",
"tag_html",
"site_id"
);

$_REQUEST['liste_colonne']['tag_reference'] = array (
"tag_id",
"tag_nom",
"tag_html",
"site_id"
);

function initialisation_valeurs_article_tag () {
	$R = &$_REQUEST['M_TAG'];

	$R['article_tag_id']	= "";
	$R['arti_nom']			= "";
	$R['tag_nom']			= "";
	$R['docutag_lang']		= "Fra";

	$R['article']			= &$R['arti_nom'];
	$R['article_name']		= &$R['arti_nom'];
	$R['tag']				= &$R['tag_nom'];

	reset ( $_REQUEST['liste_colonne']['tag_reference'] );
	foreach ( $_REQUEST['liste_colonne']['tag_reference'] as $A ) { $R['tag_'.$A] = &$R[$A];	}

}

?>
