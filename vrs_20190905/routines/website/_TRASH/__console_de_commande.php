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
// Supprime les carateres blancs. http://fr3.php.net/manual/fr/function.trim.php


include_once ("cc_fonctions_de_verification.php");
include_once ("cc_fonctions_article.php");
include_once ("cc_fonctions_article_config.php");
include_once ("cc_fonctions_article_tag.php");
include_once ("cc_fonctions_bouclage.php");
include_once ("cc_fonctions_categorie.php");
include_once ("cc_fonctions_contexte.php");
include_once ("cc_fonctions_decoration.php");
include_once ("cc_fonctions_document.php");
include_once ("cc_fonctions_groupe.php");
include_once ("cc_fonctions_module.php");
include_once ("cc_fonctions_mot_cle.php");
include_once ("cc_fonctions_presentation.php");
include_once ("cc_fonctions_site_web.php");
include_once ("cc_fonctions_theme.php");
include_once ("cc_fonctions_tag.php");
include_once ("cc_fonctions_utilisateur.php");
include_once ("cc_fonctions_variable.php");

$_REQUEST['fake'] = 0;

$CC_m['pv']['commande'] = 99;
$CC_m['article']['f_init']			= "initialisation_valeurs_article";			$CC_m['article']['section']			= "M_ARTICL";	$CC_m['article']['f_manip']			= "manipulation_article";			$CC_m['article']['f_chrg']			= "chargement_valeurs_article";
$CC_m['bouclage']['f_init']			= "initialisation_valeurs_bouclage";		$CC_m['bouclage']['section']		= "M_BOUCLG";	$CC_m['bouclage']['f_manip']		= "manipulation_bouclage";			$CC_m['bouclage']['f_chrg']			= "chargement_valeurs_bouclage";
$CC_m['categorie']['f_init']		= "initialisation_valeurs_categorie";		$CC_m['categorie']['section']		= "M_CATEGO";	$CC_m['categorie']['f_manip']		= "manipulation_categorie";			$CC_m['categorie']['f_chrg']		= "chargement_valeurs_categorie";
$CC_m['decoration']['f_init']		= "initialisation_valeurs_decoration";		$CC_m['decoration']['section']		= "M_DECORA";	$CC_m['decoration']['f_manip']		= "manipulation_decoration";		$CC_m['decoration']['f_chrg']		= "chargement_valeurs_decoration";
$CC_m['document']['f_init']			= "initialisation_valeurs_document";		$CC_m['document']['section']		= "M_DOCUME";	$CC_m['document']['f_manip']		= "manipulation_document";			$CC_m['document']['f_chrg']			= "chargement_valeurs_document";
$CC_m['document_config']['f_init']	= "initialisation_valeurs_article_config";	$CC_m['document_config']['section']	= "M_ARTCFG";	$CC_m['document_config']['f_manip']	= "manipulation_article_config";	$CC_m['document_config']['f_chrg']	= "chargement_valeurs_article_config";
$CC_m['groupe']['f_init']			= "initialisation_valeurs_groupe";			$CC_m['groupe']['section']			= "M_GROUPE";	$CC_m['groupe']['f_manip']			= "manipulation_groupe";			$CC_m['groupe']['f_chrg']			= "chargement_valeurs_groupe";
$CC_m['module']['f_init']			= "initialisation_valeurs_module";			$CC_m['module']['section']			= "M_MODULE";	$CC_m['module']['f_manip']			= "manipulation_module";			$CC_m['module']['f_chrg']			= "chargement_valeurs_module";
$CC_m['mot_cle']['f_init']			= "initialisation_valeurs_mot_cle";			$CC_m['mot_cle']['section']			= "M_MOTCLE";	$CC_m['mot_cle']['f_manip']			= "manipulation_mot_cle";			$CC_m['mot_cle']['f_chrg']			= "chargement_valeurs_mot_cle";
$CC_m['presentation']['f_init']		= "initialisation_valeurs_presentation";	$CC_m['presentation']['section']	= "M_PRESNT";	$CC_m['presentation']['f_manip']	= "manipulation_presentation";		$CC_m['presentation']['f_chrg']		= "chargement_valeurs_presentation";
$CC_m['site_web']['f_init']			= "initialisation_valeurs_site_web";		$CC_m['site_web']['section']		= "M_SITWEB";	$CC_m['site_web']['f_manip']		= "manipulation_site";				$CC_m['site_web']['f_chrg']			= "chargement_valeurs_site_web";
$CC_m['theme']['f_init']			= "initialisation_valeurs_theme";			$CC_m['theme']['section']			= "M_THEME";	$CC_m['theme']['f_manip']			= "manipulation_theme";				$CC_m['theme']['f_chrg']			= "chargement_valeurs_theme";
$CC_m['tag']['f_init']				= "initialisation_valeurs_tag";				$CC_m['tag']['section']				= "M_TAG";		$CC_m['tag']['f_manip']				= "manipulation_tag";				$CC_m['tag']['f_chrg']				= "chargement_valeurs_tag";
$CC_m['utilisateur']['f_init']		= "initialisation_valeurs_utilisateur";		$CC_m['utilisateur']['section']		= "M_UTILIS";	$CC_m['utilisateur']['f_manip']		= "manipulation_utilisateur";		$CC_m['utilisateur']['f_chrg']		= "chargement_valeurs_utilisateur";

$CC_m['atag']['f_init']				= "initialisation_valeurs_article_tag";		$CC_m['atag']['section']			= "M_TAG";		$CC_m['atag']['f_manip']			= "manipulation_tag";				$CC_m['atag']['f_chrg']				= "";
$CC_m['contexte']['f_init']			= "initialisation_valeurs_contexte";		$CC_m['contexte']['section']		= "SC";			$CC_m['contexte']['f_manip']		= "manipulation_contexte";			$CC_m['contexte']['f_chrg']			= "";
$CC_m['variable']['f_init']			= "initialisation_valeurs_variable";		$CC_m['variable']['section']		= "VAR";		$CC_m['variable']['f_manip']		= "manipulation_variable";			$CC_m['contexte']['f_chrg']			= "";
//$CC_m['a_']['f_init']				= "initialisation_valeurs_";				$CC_m['a_']['section']				= "M";			$CC_m['a_']['f_manip']				= "manipulation_";					$CC_m['a_']['f_chrg']				= "chargement_valeurs_";


// --------------------------------------------------------------------------------------------
// Fonctions
// --------------------------------------------------------------------------------------------
function CC_decomposition_expression ( $tampon_commande ) {
	$CC_TC['len'] = strlen($tampon_commande);
	$CC_TC_array_ptr = $CC_TC['ptr_d'] = $CC_TC['ptr_f'] = 0;

	while ( $CC_TC['ptr_d'] < $CC_TC['len'] ) {
		$CC_TC['chr_suivant'] = substr ( $tampon_commande , $CC_TC['ptr_d'] , 1 );
		switch ($CC_TC['chr_suivant']) {
		case "'":
		case '"':
			$CC_TC['ptr_d']++;
			$CC_TC['quote'] = $CC_TC['chr_suivant'];
			$CC_TC['ptr_f'] = strpos($tampon_commande, $CC_TC['quote'] , $CC_TC['ptr_d'] ); // y avait il des quotes sur celui du milieu?
			$CC_decomposition[$CC_TC_array_ptr] = substr($tampon_commande , $CC_TC['ptr_d'] , $CC_TC['ptr_f'] - $CC_TC['ptr_d'] );
		break;
		case " ":	$CC_TC_array_ptr--;		break;
		default:
			$CC_TC['ptr_f'] = strpos($tampon_commande, " ", $CC_TC['ptr_d'] );
			if ( $CC_TC['ptr_f'] !== FALSE && $CC_TC['ptr_d'] < $CC_TC['len']) {
				$CC_decomposition[$CC_TC_array_ptr] = substr($tampon_commande , $CC_TC['ptr_d'] , $CC_TC['ptr_f'] - $CC_TC['ptr_d'] );
			}
			if ( $CC_TC['ptr_f'] === FALSE ) {
				$CC_decomposition[$CC_TC_array_ptr] = substr($tampon_commande , $CC_TC['ptr_d'] , $CC_TC['len'] - $CC_TC['ptr_d'] );
				$CC_TC['ptr_d'] = $CC_TC['ptr_f'] = $CC_TC['len'];
			}
		break;
		}
		$CC_TC['ptr_f']++;
		$CC_TC['ptr_d'] = $CC_TC['ptr_f'];
		$CC_TC_array_ptr++;
	}
	return $CC_decomposition;
}

// --------------------------------------------------------------------------------------------
//	$mode 0 : fait attention aux valeurs vides; conserve la donnée chargée
//	$mode 1 : Ecrase les données avec celle fourni par la commande meme vide
// --------------------------------------------------------------------------------------------
function CC_traitement_argument ( $prefix_variable , $CC_decomposition , $mode ) {
	$ptr = $_REQUEST['CC_pointeur']; 
	$cmd_a = $CC_decomposition[$ptr];	$ptr++;
	$cmd_b = $CC_decomposition[$ptr];	$_REQUEST['CC_pointeur'] += 2;
	if ( array_key_exists( $cmd_a, $_REQUEST[$prefix_variable] ) ) {
		switch ( $mode ) {
		case "0":
			if ( strlen($cmd_b) != 0 ) { $_REQUEST[$prefix_variable][$cmd_a] = $cmd_b ; }
			else { 
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CC_TA_001" , $_REQUEST['site_context']['site_nom'] . " : Valeur incorrecte ou vide '".$cmd_a."'." ); 
			}
		break;
		case "1":
			$_REQUEST[$prefix_variable][$cmd_a] = $cmd_b ;
		break;
		}
	}
	else { journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CC_TA_002" , $_REQUEST['site_context']['site_nom'] . " : Colonne '".$cmd_a."' (".$_REQUEST['CC_pointeur'].") inconnue. Valeur suppos&eacute de '".$cmd_a."' est '".$cmd_b."'" ); }
}

// --------------------------------------------------------------------------------------------
function CC_recherche_argument ( $prefix_variable , $CC_decomposition ) {
	$result = 0;
	foreach ( $_REQUEST['CCRArch'] as $A ) {
		$ptr = $_REQUEST['CC_pointeur'];
		while ( $result == 0 && $ptr < $_REQUEST['CC_nbr_arg'] ) {
			$cmd_a = $CC_decomposition[$ptr]; $ptr++;
			$cmd_b = $CC_decomposition[$ptr]; $ptr++;
			if ( $cmd_a == $A ) {
				$_REQUEST[$prefix_variable][$cmd_a] = $cmd_b ;
				$result = 1 ;
			}
		}
		if ( !isset($result) ) { journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "WARN" , "CC_RA_001" , $_REQUEST['site_context']['site_nom'] . " : La recherche de ".$A." a echou&eacute." ); }
	}
}

// --------------------------------------------------------------------------------------------
function print_r_hexa( $data , $return_data=true ) {
	foreach ( $data as &$a ) {
		$str = $a;
		$b = strlen($a);
		$a .= " : ";
		for ($c = 0; $c <= $b; $c++) { $a .= dechex(ord($str[$c])) . " "; }
	}
	$data = print_r_html($data);
	if (!$return_data) { echo $data; }  
	else { return $data; }
}

// --------------------------------------------------------------------------------------------
//	Analyse de la commande
// --------------------------------------------------------------------------------------------
function command_line ( $tampon_commande ) {
	global $SQL_tab, $SQL_tab_abrege, $db, $CC_m, $langues;

	$l = $_REQUEST['site_context']['site_lang'];

	$CC_m['pv']['commande'] = 99;
	$_REQUEST['tampon_commande'] = $tampon_commande;

	$_REQUEST['CC']['status'] = "ERR";

// --------------------------------------------------------------------------------------------
// Formatte la chaine de maniere a virer ce qui est de trop
	$tab_rch = array ("\n",	chr(13),	"				",	"			",	"		",	"	",	"      ",	"     ",	"    ",	"   ",	"  ");
	$tab_rpl = array (" ",	" ",		" ",				" ",			" ", 		" ",	" ",		" ",		" ",	" ",	" ");
	$tampon_commande = trim($tampon_commande);																
	$tampon_commande = str_replace ($tab_rch,$tab_rpl,$tampon_commande);
	journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'], "INFO" , "CC_001" , $tampon_commande ); 
	$CC_decomposition = CC_decomposition_expression ( $tampon_commande );

	foreach ( $CC_decomposition as &$a ) { $a = trim($a); }
	$_REQUEST['CC_nbr_arg'] = count($CC_decomposition);
	$_REQUEST['CC_pointeur'] = 0;

	$_REQUEST['manipulation_result']['error'] = 0;
	$CC_index = $_REQUEST['manipulation_result']['nbr'];
	$_REQUEST['manipulation_result'][$CC_index]['nbr'] = $_REQUEST['manipulation_result']['nbr'];
	$_REQUEST['manipulation_result'][$CC_index]['nom'] = "Console de commandes";

	$_REQUEST['accumulateur_commandes'][] = $tampon_commande;

	switch ( $CC_decomposition[$_REQUEST['CC_pointeur']] ) {
// --------------------------------------------------------------------------------------------
// COMMANDE SITE_CONTEXT
// --------------------------------------------------------------------------------------------
	case "site_context":
	case "contexte_site":	$CC_selection = "contexte";			$CC_m['pv']['commande'] = 1;	$_REQUEST['CC']['auth_bypass'] = 1;
	break; 

// --------------------------------------------------------------------------------------------
// ADD/AJOUT
// --------------------------------------------------------------------------------------------
	case "add":
	case "ajout":
		$_REQUEST['CC_pointeur']++;
		switch ( $CC_decomposition[$_REQUEST['CC_pointeur']] ) {
		case "article":			$CC_selection = "article";			$CC_m['pv']['commande'] = 1;		break; 
		case "deadline":
		case "bouclage":		$CC_selection = "bouclage";			$CC_m['pv']['commande'] = 1;		break;
		case "decoration":		$CC_selection = "decoration";		$CC_m['pv']['commande'] = 1;		break;
		case "document":		$CC_selection = "document";			$CC_m['pv']['commande'] = 1;		break;
		case "category":
		case "categorie":		$CC_selection = "categorie";		$CC_m['pv']['commande'] = 1;		break;
		case "document_config":	$CC_selection = "document_config";	$CC_m['pv']['commande'] = 1;		break;
		case "group":
		case "groupe":			$CC_selection = "groupe";			$CC_m['pv']['commande'] = 1;		break;
		case "module":			$CC_selection = "module";			$CC_m['pv']['commande'] = 1;		break;
		case "keyword":
		case "mot_cle":			$CC_selection = "mot_cle";			$CC_m['pv']['commande'] = 1;		break;
		case "presentation":
		case "layout":
		case "contenu_presentation":
		case "layout_content":
			$CC_m['pv']['commande'] = 99;		
			$CC_decomposition['pointeur_sauvegarde'] = $CC_decomposition[$_REQUEST['CC_pointeur']];
			initialisation_valeurs_presentation ();
			$_REQUEST['CC_pointeur']++;
			while ( $_REQUEST['CC_pointeur'] < $_REQUEST['CC_nbr_arg'] ) { CC_traitement_argument ( "M_PRESNT" , $CC_decomposition , 0 ); }
			if ( $_REQUEST['manipulation_result']['error'] != 1 ) {
				if ( $CC_decomposition['pointeur_sauvegarde'] == "layout_content" || $CC_decomposition['pointeur_sauvegarde'] == "contenu_presentation" ) { $_REQUEST['M_PRESNT']['action'] = 11; }
				else { $_REQUEST['M_PRESNT']['action'] = 1; }  
				manipulation_presentation ();
			}
		break; 
		case "site":			$CC_selection = "site_web";		$CC_m['pv']['commande'] = 1;	$_REQUEST['CC']['auth_bypass'] = 1;	break;
		case "theme":			$CC_selection = "theme";		$CC_m['pv']['commande'] = 1;										break;
		case "tag":				$CC_selection = "tag";			$CC_m['pv']['commande'] = 1;										break;
		case "user":					
		case "utilisateur":					
			$CC_m['pv']['commande'] = 99;		
			$_REQUEST['CC_pointeur']++;
			initialisation_valeurs_utilisateur();
			while ( $_REQUEST['CC_pointeur'] < $_REQUEST['CC_nbr_arg'] ) {
				$cmd_a = $CC_decomposition[$_REQUEST['CC_pointeur']]; $_REQUEST['CC_pointeur']++;
				$cmd_b = $CC_decomposition[$_REQUEST['CC_pointeur']]; $_REQUEST['CC_pointeur']++;
				if ( array_key_exists( $cmd_a , $_REQUEST['M_UTILIS'] )) {
					switch ( $cmd_a ) {
					//case "passwd":
					case "password":
						if ( strlen($cmd_b) == 0 ) {
							$tl_['eng']['CC_AU_01'] = "Incorrect value for '".$cmd_a."'.";
							$tl_['fra']['CC_AU_01'] = "Valeur incorrecte pour '".$cmd_a."'.";
							journalisation_evenement ( 1 , $tl_[$l]['log_init'] , $_REQUEST['tampon_commande'] , "ERR" , "CC_001" , $tl_[$l]['CC_AU_01'] ); 
						}
					break;
					}
					if ( strlen($cmd_b) != 0 ) { $_REQUEST['M_UTILIS'][$cmd_a] = $cmd_b ; }
					else { 
						$tl_['eng']['CC_AU_02'] = "Incorrect or empty value for '".$cmd_a."'.";
						$tl_['fra']['CC_AU_02'] = "Valeur incorrecte ou vide pour '".$cmd_a."'.";
						journalisation_evenement ( 1 , $tl_[$l]['log_init'] , $_REQUEST['tampon_commande'] , "ERR" , "CC_001" , $tl_[$l]['CC_AU_02'] ); 
					}
				}	
				else { 
					$tl_['eng']['CC_AU_03'] = "'".$cmd_a."' column unknown.";
					$tl_['fra']['CC_AU_03'] = "Colonne '".$cmd_a."' inconnue.";
					journalisation_evenement ( 1 , $tl_[$l]['log_init'] , $_REQUEST['tampon_commande'] , "ERR" , "CC_001" , $tl_[$l]['CC_AU_03'] ); 
				}
			}
			if ( $_REQUEST['manipulation_result']['error'] != 1 ) {
				$_REQUEST['M_UTILIS']['action'] = 1; 
				manipulation_utilisateur ();
			}
		break; 

		default:	
			$tl_['eng']['CC_001'] = "Command not aviable yet.";
			$tl_['fra']['CC_001'] = "Commande non disponible pour le moment.";
			journalisation_evenement ( 1 , $tl_[$l]['log_init'] , $_REQUEST['tampon_commande'] , "ERR" , "CC_001" , $tl_[$l]['CC_001'] ); 
		break; 
		}
	break;
// --------------------------------------------------------------------------------------------
// UPDATE/MODIFICATION
// --------------------------------------------------------------------------------------------
	case "update":
	case "modification":
		$_REQUEST['CC_pointeur']++;
		switch ( $CC_decomposition[$_REQUEST['CC_pointeur']] ) {
		case "article":			$CC_selection = "article";			$CC_m['pv']['commande'] = 2;		break; 
		case "deadline":
		case "bouclage":		$CC_selection = "bouclage";			$CC_m['pv']['commande'] = 2;		break;
		case "decoration":		$CC_selection = "decoration";		$CC_m['pv']['commande'] = 2;		break;
		case "document":		$CC_selection = "document";			$CC_m['pv']['commande'] = 2;		break;
		case "category":
		case "categorie":		$CC_selection = "categorie";		$CC_m['pv']['commande'] = 2;		break;
		case "document_config":	$CC_selection = "document_config";	$CC_m['pv']['commande'] = 2;		break;
		case "group":
		case "groupe":			$CC_selection = "groupe";			$CC_m['pv']['commande'] = 2;		break;
		case "module":			$CC_selection = "module";			$CC_m['pv']['commande'] = 2;		break;
		case "keyword":
		case "mot_cle":			$CC_selection = "mot_cle";			$CC_m['pv']['commande'] = 2;		break;
		case "site":			$CC_selection = "site_web";			$CC_m['pv']['commande'] = 2;		break;
		case "theme":			$CC_selection = "theme";			$CC_m['pv']['commande'] = 2;		break;
		case "tag":				$CC_selection = "tag";				$CC_m['pv']['commande'] = 2;		break;
		case "user":
		case "utilisateur":		$CC_selection = "utilisateur";		$CC_m['pv']['commande'] = 2;		break;
		}
	break;
// --------------------------------------------------------------------------------------------
//	Deletion/Suppression
// --------------------------------------------------------------------------------------------
	case "delete":
	case "suppression":
		$_REQUEST['CC_pointeur']++;
		switch ( $CC_decomposition[$_REQUEST['CC_pointeur']] ) {
		case "article":			$CC_selection = "article";			$CC_m['pv']['commande'] = 3;		break; 
		case "deadline":
		case "bouclage":		$CC_selection = "bouclage";			$CC_m['pv']['commande'] = 3;		break;
		case "decoration":		$CC_selection = "decoration";		$CC_m['pv']['commande'] = 3;		break;
		case "document":		$CC_selection = "document";			$CC_m['pv']['commande'] = 3;		break;
		case "category":
		case "categorie":		$CC_selection = "categorie";		$CC_m['pv']['commande'] = 3;		break;
		case "document_config":	$CC_selection = "document_config";	$CC_m['pv']['commande'] = 3;		break;
		case "group":
		case "groupe":			$CC_selection = "groupe";			$CC_m['pv']['commande'] = 3;		break;
		case "module":			$CC_selection = "module";			$CC_m['pv']['commande'] = 3;		break;
		case "keyword":
		case "mot_cle":			$CC_selection = "mot_cle";			$CC_m['pv']['commande'] = 3;		break;
		case "site":			$CC_selection = "site_web";			$CC_m['pv']['commande'] = 3;		break;
		case "theme":			$CC_selection = "theme";			$CC_m['pv']['commande'] = 3;		break;
		case "tag":				$CC_selection = "tag";				$CC_m['pv']['commande'] = 3;		break;
		case "user":
		case "utilisateur":		$CC_selection = "utilisateur";		$CC_m['pv']['commande'] = 3;		break;
		}
	break;

// --------------------------------------------------------------------------------------------
	case "show":
	case "affiche":
		$_REQUEST['CC_pointeur']++;
		switch ( $CC_decomposition[$_REQUEST['CC_pointeur']] ) {
		case "article":			$CC_selection = "article";			$CC_m['pv']['commande'] = 5;		break; 
		case "deadline":
		case "bouclage":		$CC_selection = "bouclage";			$CC_m['pv']['commande'] = 5;		break;
		case "decoration":		$CC_selection = "decoration";		$CC_m['pv']['commande'] = 5;		break;
		case "document":		$CC_selection = "document";			$CC_m['pv']['commande'] = 5;		break;
		case "category":
		case "categorie":		$CC_selection = "categorie";		$CC_m['pv']['commande'] = 5;		break;
		case "document_config":	$CC_selection = "document_config";	$CC_m['pv']['commande'] = 5;		break;
		case "group":
		case "groupe":			$CC_selection = "groupe";			$CC_m['pv']['commande'] = 5;		break;
		case "layout":
		case "presentation":	$CC_selection = "presentation";		$CC_m['pv']['commande'] = 5;		break;
		case "module":			$CC_selection = "module";			$CC_m['pv']['commande'] = 5;		break;
		case "keyword":
		case "mot_cle":			$CC_selection = "mot_cle";			$CC_m['pv']['commande'] = 5;		break;
		case "site":			$CC_selection = "site_web";			$CC_m['pv']['commande'] = 5;		break;
		case "theme":			$CC_selection = "theme";			$CC_m['pv']['commande'] = 5;		break;
		case "tag":				$CC_selection = "tag";				$CC_m['pv']['commande'] = 5;		break;
		case "user":
		case "utilisateur":		$CC_selection = "utilisateur";		$CC_m['pv']['commande'] = 5;		break;
		case "debug_state":		
			$CC_m['pv']['commande'] = 99;		
			$_REQUEST['CC_pointeur']++;
			$_REQUEST['server_infos']['memory_get_peak_usage'] =  round ( memory_get_peak_usage() / 1024 / 1024 , 2 ) . "M" ;
			$_REQUEST['server_infos']['memory_get_usage'] = round ( memory_get_usage() / 1024 / 1024 , 2 ) . "M" ;
			journalisation_evenement ( 1 , $tl_[$l]['log_init'] , "ECHO" , "INFO" , "CC_INFO" , print_r_html ( $_REQUEST['server_infos'] ) );
			$_REQUEST['CC']['status'] = "OK";

		break;
		case "echo":
			$CC_m['pv']['commande'] = 99;		$_REQUEST['CC_pointeur']++;
			journalisation_evenement ( 1 , $tl_[$l]['log_init'] , "ECHO" , "INFO" , "CC_INFO" , $CC_decomposition[2] ); 
			$_REQUEST['CC']['status'] = "OK";
		break;
		case "debug_on":
			$CC_m['pv']['commande'] = 99;	$_REQUEST['CC_pointeur']++;
			if ( isset($_REQUEST['debug_option']['CC_debug_level_sauvegarde']) ) { $_REQUEST['debug_option']['CC_debug_level'] = $_REQUEST['debug_option']['CC_debug_level_sauvegarde']; }
			else { $_REQUEST['debug_option']['CC_debug_level'] = 1; }
			$_REQUEST['CC']['status'] = "OK";
		break;
		case "debug_off":
			$CC_m['pv']['commande'] = 99;	$_REQUEST['CC_pointeur']++;
			$_REQUEST['debug_option']['CC_debug_level_sauvegarde'] = $_REQUEST['debug_option']['CC_debug_level'];
			$_REQUEST['debug_option']['CC_debug_level'] = 0;
			$_REQUEST['CC']['status'] = "OK";
		break;
		case "checkpoint":	statistique_checkpoint ( $CC_decomposition[2] );				$_REQUEST['CC']['status'] = "OK";			break;
		default:
			$tl_['eng']['CC_001'] = "Command not aviable yet.";
			$tl_['fra']['CC_001'] = "Commande non disponible pour le moment.";
			journalisation_evenement ( 1 , $tl_[$l]['log_init'] , $_REQUEST['tampon_commande'] , "ERR" , "CC_001" , $tl_[$l]['CC_001'] ); 
		break;
		}
	break; 
// --------------------------------------------------------------------------------------------
//	Autre commande
// --------------------------------------------------------------------------------------------
	case "variable":			$CC_selection = "variable";			$CC_m['pv']['commande'] = 1;		
		$_REQUEST['CC_pointeur']++;
		$_REQUEST['VAR']['variable'] = $CC_decomposition[$_REQUEST['CC_pointeur']]; 		$_REQUEST['CC_pointeur']++;
		$_REQUEST['VAR']['valeur'] = $CC_decomposition[$_REQUEST['CC_pointeur']]; 		$_REQUEST['CC_pointeur']++;
	break;

	case "assign_tag":
	case "assigne_tag":			$CC_selection = "atag";				$CC_m['pv']['commande'] = 21;		break;
	case "insert_content":
	case "insere_contenu":		$CC_selection = "document";			$CC_m['pv']['commande'] = 29;		break;
	case "journalisation":
	case "log":
		$CC_m['pv']['commande'] = 99;
		$_REQUEST['CC_pointeur']++;
		$pv['journalmsg01'] = $CC_decomposition[$_REQUEST['CC_pointeur']]; 		$_REQUEST['CC_pointeur']++;
		$pv['journalmsg02'] = $CC_decomposition[$_REQUEST['CC_pointeur']]; 		$_REQUEST['CC_pointeur']++;
		$pv['journalmsg03'] = $CC_decomposition[$_REQUEST['CC_pointeur']]; 		$_REQUEST['CC_pointeur']++;
		journalisation_evenement ( 1 , $tl_[$l]['log_init'] , $_REQUEST['tampon_commande'] , $pv['journalmsg01'] , $pv['journalmsg02'] , $pv['journalmsg03'] ); 
		$_REQUEST['CC']['status'] = "OK";
	break;

	case "link":
	case "lier":				$CC_selection = "article";			$CC_m['pv']['commande'] = 4;		break; 
	case "layout":
	case "presentation":		$CC_selection = "presentation";		$CC_m['pv']['commande'] = 4;		break;
	case "share_document":
	case "partage_document":	$CC_selection = "document";			$CC_m['pv']['commande'] = 4;		break;
	case "user":
	case "utilisateur":
		$CC_m['pv']['commande'] = 99;
		$_REQUEST['CC_pointeur']++;
		initialisation_valeurs_utilisateur();
		$_REQUEST['M_UTILIS']['user_login'] = $CC_decomposition[$_REQUEST['CC_pointeur']];
		$_REQUEST['CC_pointeur']++;

		while ( $_REQUEST['CC_pointeur'] < $_REQUEST['CC_nbr_arg'] ) { CC_traitement_argument ( "M_UTILIS" , $CC_decomposition , 0 ); }
		if ( $_REQUEST['manipulation_result']['error'] != 1 ) {
			$_REQUEST['M_UTILIS']['action'] = 4; 
			manipulation_utilisateur ();
		}
	break;
	case "exit":
		if ( function_exists ( "installation_log_manipulation" ) ) { installation_log_manipulation (); }
		echo ("<table>");
		unset ( $A );
		foreach ( $_REQUEST['manipulation_result'] as $A ) {
			if ( $A['signal'] != "OK" ) {
				echo ("<tr>
				<td>".$A['nbr']."</td>
				<td>".$A['nom']."</td>
				<td>".$A['action']."</td>
				<td>".$A['signal']."</td>
				<td>".$A['msgid']."</td>
				<td>".$A['msg']."</td>
				<td>".$A['']."</td>
				</tr>
				");
			}
		}
		echo ("</table>");
		exit(0);
	break;
	default:
		$CC_m['pv']['commande'] = 99;
		$CC_message = print_r_html ($CC_decomposition) . "<br>";
		$CC_message .= print_r_hexa ($CC_decomposition) . "<br>";
		journalisation_evenement ( 1 , $tl_[$l]['log_init'] , $tampon_commande , "ERR" , "CC_002" , $CC_message );
	break;
	}

// --------------------------------------------------------------------------------------------
// Authentification
	if ( $_REQUEST['CC']['auth_bypass'] != 1 ) {
		if ( $_REQUEST['site_context']['site_nom'] == "*website*" ) { //extensions
			global $WebSitObj;
			$_REQUEST['site_context']['site_nom'] == $WebSiteObj->getWebSiteEntry('sw_nom');
		}
		$_REQUEST['SC']['ERR'] = 0;
		$dbquery = requete_sql ($_REQUEST['sql_initiateur'] , "
		SELECT * 
		FROM ".$SQL_tab_abrege['site_web']." 
		WHERE sw_nom = '".$_REQUEST['site_context']['site_nom']."' 
		;");
		if ( num_row_sql($dbquery) == 0 ) {
			$tl_['eng']['CC_003'] = "Site context check : Error - Unknow website!";
			$tl_['fra']['CC_003'] = "V&eacute;rification context site : Erreur - Site inconnu!";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CC_003" , $tl_[$l]['CC_003'] );
			$_REQUEST['CC']['ERR'] = 1;
			$CC_m['pv']['commande'] = 99;
		}
		else {
			while ($dbp = fetch_array_sql($dbquery)) { $pv['site_id'] = $dbp['sw_id']; }
		}

		if ($_REQUEST['CC']['ERR'] == 0 ) {
			$dbquery = requete_sql ($_REQUEST['sql_initiateur'] , "
			SELECT usr.user_id AS user_id, usr.user_login AS user_login, usr.user_password AS user_password 
			FROM ".$SQL_tab_abrege['user']." usr, ".$SQL_tab_abrege['groupe_user']." gu, ".$SQL_tab_abrege['site_groupe']." grp 
			WHERE user_login = '".$_REQUEST['site_context']['user']."' 
			AND usr.user_id = gu.user_id 
			AND gu.groupe_id = grp.groupe_id 
			AND gu.groupe_premier = '1' 
			AND grp.site_id = '".$pv['site_id']."'
			;");
			if ( num_row_sql($dbquery) == 0 ) {
				$tl_['eng']['CC_004'] = "Site context check : User unknow";
				$tl_['fra']['CC_004'] = "V&eacute;rification context site : Utilisateur inconnu";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CC_004" , $tl_[$l]['CC_004'] );
				$_REQUEST['CC']['ERR'] = 1;
				$CC_m['pv']['commande'] = 99;
			}
			else {
				while ($dbp = fetch_array_sql($dbquery)) { 
					$_REQUEST['CC']['db_user_id'] = $dbp['user_id'];
					$_REQUEST['CC']['db_user_login'] = $dbp['user_login'];
					$_REQUEST['CC']['db_user_password'] = $dbp['user_password'];
				}
			}
		}
		if ( $_REQUEST['CC']['ERR'] == 0 ) {
			//$_REQUEST['CC']['pass_comp'] = hash("sha1",stripslashes($_REQUEST['site_context']['password']));
			if ( $_REQUEST['site_context']['password'] != $_REQUEST['CC']['db_user_password'] ) {
				$tl_['eng']['CC_005'] = "Site context check : Authentification failed";
				$tl_['fra']['CC_005'] = "V&eacute;rification context site : L'authentification a &eacute;chou&eacute; ";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CC_005" , $tl_[$l]['CC_005'] );
				$CC_m['pv']['commande'] = 99;
			}
		}
	}
// --------------------------------------------------------------------------------------------
// 1 creation ; 2 modification, 3 suppression 5 show
	if ( $CC_m['pv']['commande'] != 99 ) {
		$CC_section = $CC_m[$CC_selection]['section'];
		$CC_i = $CC_m[$CC_selection]['f_init'];		
		$CC_i();
		$_REQUEST['CC_pointeur']++;

		if ( $CC_m['pv']['commande'] == 2 ) {
			$_REQUEST['CCRArch']['1'] = "name" ; $_REQUEST['CCRArch']['2'] = "nom";	
			$_REQUEST['CCRArch']['3'] = "login";	$_REQUEST['CCRArch']['4'] = "identifiant";
			CC_recherche_argument ( $CC_section , $CC_decomposition );
			$CC_c = $CC_m[$CC_selection]['f_chrg'];
			$CC_c();
		}
		while ( $_REQUEST['CC_pointeur'] < $_REQUEST['CC_nbr_arg'] ) { CC_traitement_argument ( $CC_section , $CC_decomposition , 0 ); }
		if ( $_REQUEST['manipulation_result']['error'] != 1 ) { 
			$_REQUEST[$CC_section]['action'] = $CC_m['pv']['commande'];
			$CC_a = $CC_m[$CC_selection]['f_manip'];
			$CC_a();
		}
		//journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "INFO" , "CC_010" , "F=".$CC_i.",".$CC_c.",".$CC_m );
	}
	if ( $_REQUEST['contexte_d_execution'] != "Admin_menu" ) { unset ( $_REQUEST[$CC_section] ); }
	$_REQUEST['CC']['auth_bypass'] = 0;
}

?>
