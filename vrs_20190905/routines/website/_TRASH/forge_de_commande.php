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
//	Forge de commandes
// --------------------------------------------------------------------------------------------
function forge_commande ( $action ) {
	global $user;

	$ligne = 1;
	$_REQUEST['SC_comportement'] = "interface_CC";
	$tampon_commande_buffer[$ligne] = "site_context site ".$_REQUEST['site_context']['site_nom']." user ".$user['login_decode']." password ".$user['pass_decode'];

	switch ( $action ) {
// --------------------------------------------------------------------------------------------
/*	Article																						*/
// --------------------------------------------------------------------------------------------
	case "DELETE_ARTICLE":		include ("forge_de_commande_delete_article.php");			break;
	case "ADD_ARTICLE":			include ("forge_de_commande_add_article.php");				break;
	case "UPDATE_ARTICLE":		include ("forge_de_commande_update_article.php");			break;
// --------------------------------------------------------------------------------------------
/*	Categories																					*/
// --------------------------------------------------------------------------------------------
	case "DELETE_CATEGORY":		include ("forge_de_commande_delete_category.php");			break;
	case "ADD_CATEGORY":		include ("forge_de_commande_add_category.php");				break;
	case "UPDATE_CATEGORY":		include ("forge_de_commande_update_category.php");			break;
// --------------------------------------------------------------------------------------------
/*	Deadlines																					*/
// --------------------------------------------------------------------------------------------
	case "DELETE_DEADLINE":		include ("forge_de_commande_delete_deadline.php");			break;
	case "ADD_DEADLINE":		include ("forge_de_commande_add_deadline.php");				break;
	case "UPDATE_DEADLINE":		include ("forge_de_commande_update_deadline.php");			break;
// --------------------------------------------------------------------------------------------
/*	Decorations																					*/
// --------------------------------------------------------------------------------------------
	case "DELETE_DECORATION":	include ("forge_de_commande_delete_decoration.php");		break;
	case "ADD_DECORATION":		include ("forge_de_commande_add_decoration.php");			break;
	case "UPDATE_DECORATION":	include ("forge_de_commande_update_decoration.php");		break;
// --------------------------------------------------------------------------------------------
/*	Display																						*/
// --------------------------------------------------------------------------------------------
	case "DELETE_DISPLAY":		include ("forge_de_commande_delete_display.php");			break;
	case "ADD_DISPLAY":			include ("forge_de_commande_add_display.php");				break;
	case "UPDATE_DISPLAY":		include ("forge_de_commande_update_display.php");			break;
// --------------------------------------------------------------------------------------------
/*	Document config																				*/
// --------------------------------------------------------------------------------------------
	case "DELETE_DOCUCONFIG":	include ("forge_de_commande_delete_docuconfig.php");		break;
	case "ADD_DOCUCONFIG":		include ("forge_de_commande_add_docuconfig.php");			break;
	case "UPDATED_OCUCONFIG":	include ("forge_de_commande_update_docuconfig.php");		break;
// --------------------------------------------------------------------------------------------
/*	Document																					*/
// --------------------------------------------------------------------------------------------
	case "DELETE_DOCUMENT":		include ("forge_de_commande_delete_document.php");			break;
	case "ADD_DOCUMENT":		include ("forge_de_commande_add_document.php");				break;
	case "UPDATE_DOCUMENT":		include ("forge_de_commande_update_document.php");			break;
// --------------------------------------------------------------------------------------------
/*	Modules																						*/
// --------------------------------------------------------------------------------------------
	case "DELETE_MODULE":		include ("forge_de_commande_delete_module.php");			break;
	case "ADD_MODULE":			include ("forge_de_commande_add_module.php");				break;
	case "UPDATE_MODULE":		include ("forge_de_commande_update_module.php");			break;
// --------------------------------------------------------------------------------------------
/*	mot_cles																					*/
// --------------------------------------------------------------------------------------------
	case "DELETE_KEYWORD":		include ("forge_de_commande_delete_mot_cle.php");			break;
	case "ADD_KEYWORD":			include ("forge_de_commande_add_mot_cle.php");				break;
	case "UPDATE_KEYWORD":		include ("forge_de_commande_update_mot_cle.php");			break;
// --------------------------------------------------------------------------------------------
/*	Groups																						*/
// --------------------------------------------------------------------------------------------
	case "DELETE_GROUP":		include ("forge_de_commande_delete_group.php");				break;
	case "ADD_GROUP":			include ("forge_de_commande_add_group.php");				break;
	case "UPDATE_GROUP":		include ("forge_de_commande_update_group.php");				break;
// --------------------------------------------------------------------------------------------
/*	Theme																						*/
// --------------------------------------------------------------------------------------------
	case "DELETE_THEME":		include ("forge_de_commande_delete_theme.php");				break;
	case "ADD_THEME":			include ("forge_de_commande_add_theme.php");				break;
	case "UPDATE_THEME":		include ("forge_de_commande_update_theme.php");				break;
// --------------------------------------------------------------------------------------------
/*	User																						*/
// --------------------------------------------------------------------------------------------
	case "DELETE_USER":			include ("forge_de_commande_delete_user.php");				break;
	case "ADD_USER":			include ("forge_de_commande_add_user.php");					break;
	case "UPDATE_USER":			include ("forge_de_commande_update_user.php");				break;
// --------------------------------------------------------------------------------------------
/*	Website																						*/
// --------------------------------------------------------------------------------------------
	case "UPDATE_WEBSITE":	include ("forge_de_commande_update_website.php");				break;
	}
}

?>

