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
$ligne++;
$tampon_commande_buffer[$ligne] = "
add user	login \"".$_REQUEST['M_UTILIS']['login']."\"	";	

if ( isset($_REQUEST['M_UTILIS']['password']) )							{ $tampon_commande_buffer[$ligne] .= "password							\"".$_REQUEST['M_UTILIS']['password'].							"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['status']) )							{ $tampon_commande_buffer[$ligne] .= "status							\"".$_REQUEST['M_UTILIS']['status'].							"\"	\n";}
//if ( isset($_REQUEST['M_UTILIS']['tribune_access']) )					{ $tampon_commande_buffer[$ligne] .= "tribune_access					\"".$_REQUEST['M_UTILIS']['tribune_access'].					"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['forum_access']) )						{ $tampon_commande_buffer[$ligne] .= "forum_access						\"".$_REQUEST['M_UTILIS']['forum_access'].						"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['lang']) )								{ $tampon_commande_buffer[$ligne] .= "lang								\"".$_REQUEST['M_UTILIS']['lang'].								"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_theme']) )						{ $tampon_commande_buffer[$ligne] .= "pref_theme						\"".$_REQUEST['M_UTILIS']['pref_theme'].						"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_newsletter']) )					{ $tampon_commande_buffer[$ligne] .= "pref_newsletter					\"".$_REQUEST['M_UTILIS']['pref_newsletter'].					"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_show_email']) )					{ $tampon_commande_buffer[$ligne] .= "pref_show_email					\"".$_REQUEST['M_UTILIS']['pref_show_email'].					"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_show_online_status']) )			{ $tampon_commande_buffer[$ligne] .= "pref_show_online_status			\"".$_REQUEST['M_UTILIS']['pref_show_online_status'].			"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_notification_forum_answer']) )	{ $tampon_commande_buffer[$ligne] .= "pref_notification_forum_answer	\"".$_REQUEST['M_UTILIS']['pref_notification_forum_answer'].	"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_notification_new_pm']) )			{ $tampon_commande_buffer[$ligne] .= "pref_notification_new_pm			\"".$_REQUEST['M_UTILIS']['pref_notification_new_pm'].			"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_allow_bbcode']) )				{ $tampon_commande_buffer[$ligne] .= "pref_allow_bbcode					\"".$_REQUEST['M_UTILIS']['pref_allow_bbcode'].					"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_allow_html']) )					{ $tampon_commande_buffer[$ligne] .= "pref_allow_html					\"".$_REQUEST['M_UTILIS']['pref_allow_html'].					"\"	\n";}
if ( isset($_REQUEST['M_UTILIS']['pref_allow_smilies']) )				{ $tampon_commande_buffer[$ligne] .= "pref_allow_smilies				\"".$_REQUEST['M_UTILIS']['pref_allow_smilies'].				"\"	\n";}

if ( strlen($_REQUEST['M_UTILIS']['email']) > 0 )				{ $tampon_commande_buffer[$ligne] .= "	email				\"".$_REQUEST['M_UTILIS']['email']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['msn']) > 0 )					{ $tampon_commande_buffer[$ligne] .= "	msn					\"".$_REQUEST['M_UTILIS']['msn']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['aim']) > 0 )					{ $tampon_commande_buffer[$ligne] .= "	aim					\"".$_REQUEST['M_UTILIS']['aim']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['icq']) > 0 )					{ $tampon_commande_buffer[$ligne] .= "	icq					\"".$_REQUEST['M_UTILIS']['icq']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['yim']) > 0 )					{ $tampon_commande_buffer[$ligne] .= "	yim					\"".$_REQUEST['M_UTILIS']['yim']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['website']) > 0 )				{ $tampon_commande_buffer[$ligne] .= "	website				\"".$_REQUEST['M_UTILIS']['website']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['perso_nom']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	perso_name			\"".$_REQUEST['M_UTILIS']['perso_nom']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['perso_pays']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	perso_country		\"".$_REQUEST['M_UTILIS']['perso_pays']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['perso_ville']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "	perso_town			\"".$_REQUEST['M_UTILIS']['perso_ville']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['perso_occupation']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "	perso_occupation	\"".$_REQUEST['M_UTILIS']['perso_occupation']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['perso_interet']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "	perso_interest		\"".$_REQUEST['M_UTILIS']['perso_interet']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['image_avatar']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "	avatar				\"".$_REQUEST['M_UTILIS']['image_avatar']."\"\n"; }
if ( strlen($_REQUEST['M_UTILIS']['admin_commentaire']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "	admin_comment		\"".$_REQUEST['M_UTILIS']['admin_commentaire']."\"\n"; }

//$ligne++;
//$tampon_commande_buffer[$ligne] = "user \"".$_REQUEST['M_UTILIS']['login']."\"			join_group Lecteur						primary_group OUI;"


// --------------------------------------------------------------------------------------------
// 2012 12 10 A virer dès que la gestion de groupe hiérarchisé est en place.
$ligne++;
$tampon_commande_buffer[$ligne] = "user \"".$_REQUEST['M_UTILIS']['login']."\"			join_group Anonyme						primary_group NON;"
// --------------------------------------------------------------------------------------------

?>
