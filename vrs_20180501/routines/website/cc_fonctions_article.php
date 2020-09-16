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
//docu_type					WMCODE:0	NOCODE:1	WM:2	PHP:3	MIXED:4
//docu_validation_etat		NON_VALIDE:0	VALIDE:1
//docu_correction_etat		NON_CORRIGE:0 CORRIGE:1

$_REQUEST['liste_colonne']['article'] = array (
"arti_id",
"arti_ref",
"arti_bouclage",
"arti_nom",
"arti_desc",
"arti_titre",
"arti_sous_titre",
"arti_page",
"pres_nom_generique",
"config_id",
"arti_creation_createur",
"arti_creation_date",
"arti_validation_validateur",
"arti_validation_date",
"arti_validation_etat",
"arti_parution_date",
"docu_id",
"site_id"
);

$_REQUEST['liste_colonne']['article_reference'] = array (
"id",
"ref",
"bouclage",
"nom",
"desc",
"titre",
"sous_titre",
"page",
"pres_nom_generique",
"config_id",
"creation_createur",
"creation_date",
"validation_validateur",
"validation_date",
"validation_etat",
"parution_date",
"docu_id",
"site_id"
);

function initialisation_valeurs_article () {
	$R = &$_REQUEST['M_ARTICL'];

	$R['id']					= "";
	$R['ref']					= "0";
	$R['bouclage']				= "initial_offline";
	$R['nom']					= "Nouvel article";
	$R['desc']					= "Nouvel article";
	$R['titre']					= "Nouvel article";
	$R['sous_titre']			= "Nouvel article";
	$R['page']					= "1";

	$R['pres_nom_generique']	= "Presentation_par_defaut";
	$R['config_id']				= "par_defaut";

	$R['creation_createur']		= $_REQUEST['site_context']['user'];
	$R['creation_date']			= "0";
	$R['validation_validateur']	= $_REQUEST['site_context']['user'];
	$R['validation_date']		= "0";
	$R['validation_etat']		= "NON_VALIDE";

	$R['parution_date']			= "0";
	$R['docu_nom']				= "";
	$R['docu_id']				= 0;
	$R['filtre']				= "";
	$R['site_id']				= $_REQUEST['site_context']['site_id'];


	$R['deadline']				= &$R['bouclage'];
	$R['name']					= &$R['nom'];
	$R['article']				= &$R['nom'];
	$R['title']					= &$R['titre'];
	$R['sub_title']				= &$R['sous_titre'];

	$R['config']				= &$R['config_id'];

	$R['creation_creator']		= &$R['creation_createur'];
	$R['creation_date']			= &$R['creation_date'];
	$R['validation_examiner']	= &$R['validation_validateur'];
	$R['validation_date']		= &$R['validation_date'];
	$R['validation_state']		= &$R['validation_etat'];

	$R['reference']				= &$R['ref'];
	$R['presentation']			= &$R['pres_nom_generique'];
	$R['layout']				= &$R['pres_nom_generique'];

	$R['document']				= &$R['docu_nom'];
	$R['doc']					= &$R['docu_nom'];
	$R['document_name']			= &$R['docu_nom'];
	$R['filter']				= &$R['filtre'];

	reset ( $_REQUEST['liste_colonne']['article_reference'] );
	foreach ( $_REQUEST['liste_colonne']['article_reference'] as $A ) { $R['arti_'.$A] = &$R[$A];	}
}

function chargement_valeurs_article () {
	global $SQL_tab , $SQL_tab_abrege, $tab_conv_expr;
	$R = &$_REQUEST['M_ARTICL'];

	$tl_['eng']['log_init'] = "Loading article datas";
	$tl_['fra']['log_init'] = "Chargement valeurs de l'article";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT art.* , 
	usr1.user_login AS createur_nom, 
	usr2.user_login AS validateur_nom, 
	cfg.config_nom, 
	pres.pres_nom_generique, 
	bcl.bouclage_nom

	FROM ".$SQL_tab_abrege['article']." art, 
	".$SQL_tab_abrege['user']." usr1, 
	".$SQL_tab_abrege['user']." usr2, 
	".$SQL_tab_abrege['article_config']." cfg, 
	".$SQL_tab_abrege['presentation']." pres, 
	".$SQL_tab_abrege['site_web']." sit, 
	".$SQL_tab_abrege['theme_presentation']." sp, 
	".$SQL_tab_abrege['bouclage']." bcl 

	WHERE art.arti_nom = '".$R['arti_nom']."' 
	AND art.site_id = '".$_REQUEST['site_context']['site_id']."'
	AND art.site_id = sit.sw_id

	AND art.arti_creation_createur = usr1.user_id 
	AND art.arti_validation_validateur = usr2.user_id 

	AND cfg.config_id = art.config_id
	AND art.pres_nom_generique = pres.pres_nom_generique

	AND sit.theme_id = sp.theme_id 
	AND sp.pres_id = pres.pres_id 

	AND bcl.bouclage_id = art.arti_bouclage 
	;");

	if ( num_row_sql($dbquery) == 0 ) {
		$tl_['eng']['err_001'] = "The article named '".$R['nom']."' doesn't exists.";
		$tl_['fra']['err_001'] = "L'article '".$R['nom']."' n'existe pas.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CVA_0001" , $tl_[$l]['err_001'] ); 
	}
	else {
//		$tab_correction['0'] = "NON_CORRIGE";	$tab_correction['1'] = "CORRIGE";	
		$p = $tab_conv_expr['M_ARTICL']['non_valide'];	$tab_validation[$p] = "non_valide";	
		$p = $tab_conv_expr['M_ARTICL']['valide'];		$tab_validation[$p] = "valide";	

		while ($dbp = fetch_array_sql($dbquery)) { 
			foreach ( $dbp as $A => $B ) { $R[$A] = $B; }
			$R['bouclage']					= $dbp['bouclage_nom'];
			$R['config_id']					= $dbp['config_nom'];
		}

/*
			$R['id']						= $dbp['arti_id'];
			$R['ref']						= $dbp['arti_ref'];
			$R['nom']						= $dbp['arti_nom'];
			$R['desc']						= $dbp['arti_desc'];
			$R['titre']						= $dbp['arti_titre'];
			$R['sous_titre']				= $dbp['arti_sous_titre'];
			$R['page']						= $dbp['arti_page'];

			$R['pres_id']					= $dbp['pres_id'];
			$R['pres_nom_generique']		= $dbp['pres_nom_generique'];
			$R['config_id']					= $dbp['config_nom'];

			$R['creation_createur']			= $dbp['createur_nom'];
			$R['creation_date']				= $dbp['arti_creation_date'];

			$R['validation_validateur']		= $dbp['validateur_nom'];
			$R['validation_date']			= $dbp['arti_validation_date'];
*/
		$R['validation_etat']			= $tab_validation[$R['arti_validation_etat']];
		$R['validation_validateur']		= $R['validateur_nom'];
	}
unset ( $R );
}
?>
