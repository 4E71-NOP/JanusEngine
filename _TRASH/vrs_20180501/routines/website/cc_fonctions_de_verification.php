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
//1: Rend la donnée sans activation de l'erreur.
//2: Rend la donnée avec activation de l'erreur s'il y en a.
//3: Teste si un doublon existe.
function systeme_requete_unifiee ( $ordre , $sru_rid , $a1 , $a2 , $code_err , &$dest ) {
	$ta_rch = array ( "<A1>", "<A2>" );
	$ta_rpl = array ( $a1, $a2 );
	$sru_r = str_replace ( $ta_rch , $ta_rpl , $_REQUEST['CC_TR'][$sru_rid]['requete'] );
	$dbquery = requete_sql ( $_REQUEST['sql_initiateur'], $sru_r );
	unset ( $sru_r );

	switch ( $ordre ) {
	case 1:
		if ( num_row_sql($dbquery) > 0 ) { 
			$unique = $_REQUEST['CC_TR'][$sru_rid]['colone_1'];
			while ($dbp = fetch_array_sql($dbquery)) { $dest = $dbp[$unique]; }
		}
	break;
	case 2:
		if ( num_row_sql($dbquery) == 0 ) {
			$l = $_REQUEST['site_context']['site_lang'];
			$tl_['eng']['err'] = "The element named '".$a1."' doesn't exists.";
			$tl_['fra']['err'] = "L'&eacute;l&eacute;ment (".$_REQUEST['CC_TR'][$sru_rid]['element'].") nom&eacute; '".$a1."' n'existe pas.";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "ERR" , $code_err , $tl_[$l]['err'] );
			$_REQUEST['sru_ERR'] = 1;
		}
		else { 
			$unique = $_REQUEST['CC_TR'][$sru_rid]['colone_1'];
			while ($dbp = fetch_array_sql($dbquery)) { $dest = $dbp[$unique]; } 
		}
	break;
	case 3:
		if ( num_row_sql($dbquery) > 0 ) {
			$l = $_REQUEST['site_context']['site_lang'];
			$tl_['eng']['err'] = "The element (".$_REQUEST['CC_TR'][$sru_rid]['element'].") named '".$a1."' already exists.";
			$tl_['fra']['err'] = "L'&eacute;l&eacute;ment (".$_REQUEST['CC_TR'][$sru_rid]['element'].") nom&eacute; '".$a1."' existe d&eacute;j&agrave;.";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , "&gt;" . $_REQUEST['site_context']['site_nom'] . "&gt; ".$_REQUEST['tampon_commande'] , "ERR" , $code_err , $tl_[$l]['err'] );
			$_REQUEST['sru_ERR'] = 1;	
		}
	break;
	}
}

function mktime_from_canonical($date) {
	$tab_rch = array ("-", ":");		$tab_rpl = array (" ", " ");
	$date = str_replace ($tab_rch, $tab_rpl, $date);
	$pv = explode (" ", $date);
	$date = mktime ( intval($pv['3']), intval($pv['4']), intval($pv['5']), intval($pv['1']), intval($pv['2']), intval($pv['0']) );
	return $date;
}


function genere_tableau_requete ( $site ) {
	global $SQL_tab_abrege;
	unset ($_REQUEST['CC_TR']);
	$_REQUEST['CC_TR'] = array();
// Articles
	$_REQUEST['CC_TR']['M_ARTICL_rda']['requete']		= "SELECT arti_id,arti_nom FROM ".$SQL_tab_abrege['article']." WHERE arti_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_ARTICL_rda']['element']		= "Article";

	$_REQUEST['CC_TR']['M_ARTICL_reb']['requete']		= "SELECT bouclage_id FROM ".$SQL_tab_abrege['bouclage']." WHERE bouclage_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_ARTICL_reb']['element']		= "Bouclage";
	$_REQUEST['CC_TR']['M_ARTICL_reb']['colone_1']		= "bouclage_id";

	$_REQUEST['CC_TR']['M_ARTICL_reac']['requete']		= "SELECT config_id FROM ".$SQL_tab_abrege['article_config']." WHERE config_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_ARTICL_reac']['element']		= "Article_config";
	$_REQUEST['CC_TR']['M_ARTICL_reac']['colone_1']		= "config_id";

	$_REQUEST['CC_TR']['M_ARTICL_rec']['requete']		= "SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$SQL_tab_abrege['user']." usr, ".$SQL_tab_abrege['groupe_user']." gu, ".$SQL_tab_abrege['site_groupe']." sg WHERE user_login = '<A1>' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_ARTICL_rec']['element']		= "Createur";
	$_REQUEST['CC_TR']['M_ARTICL_rec']['colone_1']		= "user_id";

	$_REQUEST['CC_TR']['M_ARTICL_rev']['requete']		= "SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$SQL_tab_abrege['user']." usr, ".$SQL_tab_abrege['groupe_user']." gu, ".$SQL_tab_abrege['site_groupe']." sg WHERE user_login = '<A1>' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_ARTICL_rev']['element']		= "Validateur";
	$_REQUEST['CC_TR']['M_ARTICL_rev']['colone_1']		= "user_id";

	$_REQUEST['CC_TR']['M_ARTICL_rep']['requete']		= "SELECT usr.pres_id AS pres_id, usr.pres_nom_generique AS pres_nom_generique FROM ".$SQL_tab_abrege['presentation']." usr , ".$SQL_tab_abrege['theme_presentation']." sp WHERE pres_nom_generique = '<A1>' AND usr.pres_id = sp.pres_id AND sp.theme_id = '<A2>';";
	$_REQUEST['CC_TR']['M_ARTICL_rep']['element']		= "Presentation";
	$_REQUEST['CC_TR']['M_ARTICL_rep']['colone_1']		= "pres_nom_generique";

	$_REQUEST['CC_TR']['M_ARTICL_rea']['requete']		= "SELECT arti_id,arti_nom FROM ".$SQL_tab_abrege['article']." WHERE arti_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_ARTICL_rea']['element']		= "Article";
	$_REQUEST['CC_TR']['M_ARTICL_rea']['colone_1']		= "arti_id";

	$_REQUEST['CC_TR']['M_ARTICL_red']['requete']		= "SELECT doc.docu_id AS docu_id, doc.docu_nom AS docu_nom FROM ".$SQL_tab_abrege['document']." doc , ".$SQL_tab_abrege['document_partage']." dp WHERE doc.docu_nom = '<A1>' AND dp.docu_id = doc.docu_id AND dp.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_ARTICL_red']['element']		= "Document";
	$_REQUEST['CC_TR']['M_ARTICL_red']['colone_1']		= "docu_id";

// Article config
	$_REQUEST['CC_TR']['M_ARTCFG_rdac']['requete']		= "SELECT config_id FROM ".$SQL_tab_abrege['article_config']." WHERE config_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_ARTCFG_rdac']['element']		= "Article_config";

// Bouclage
	$_REQUEST['CC_TR']['M_BOUCLG_rdb']['requete']		= "SELECT bouclage_id FROM ".$SQL_tab_abrege['bouclage']." WHERE bouclage_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_BOUCLG_rdb']['element']		= "Bouclage";

	$_REQUEST['CC_TR']['M_BOUCLG_reb']['requete']		= "SELECT bouclage_id FROM ".$SQL_tab_abrege['bouclage']." WHERE bouclage_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_BOUCLG_reb']['element']		= "Bouclage";
	$_REQUEST['CC_TR']['M_BOUCLG_reb']['colone_1']		= "bouclage_id";

// Categorie
	$_REQUEST['CC_TR']['M_CATEGO_rdc']['requete']		= "SELECT cate_id FROM ".$SQL_tab_abrege['categorie']." WHERE site_id = '".$site."' AND cate_nom = '<A1>';";
	$_REQUEST['CC_TR']['M_CATEGO_rdc']['element']		= "Categorie";

	$_REQUEST['CC_TR']['M_CATEGO_rep']['requete']		= "SELECT cate_id FROM ".$SQL_tab_abrege['categorie']." WHERE site_id = '".$site."' AND cate_nom = '<A1>';";
	$_REQUEST['CC_TR']['M_CATEGO_rep']['element']		= "Categorie";
	$_REQUEST['CC_TR']['M_CATEGO_rep']['colone_1']		= "cate_id";

	$_REQUEST['CC_TR']['M_CATEGO_reb']['requete']		= "SELECT bouclage_id FROM ".$SQL_tab_abrege['bouclage']." WHERE bouclage_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_CATEGO_reb']['element']		= "Bouclage";
	$_REQUEST['CC_TR']['M_CATEGO_reb']['colone_1']		= "bouclage_id";

	$_REQUEST['CC_TR']['M_CATEGO_reg']['requete']		= "SELECT grp.groupe_nom, grp.groupe_id FROM ".$SQL_tab_abrege['groupe']." grp , ".$SQL_tab_abrege['site_groupe']." sg  WHERE sg.site_id = '".$site."' AND grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id;";
	$_REQUEST['CC_TR']['M_CATEGO_reg']['element']		= "Groupe";
	$_REQUEST['CC_TR']['M_CATEGO_reg']['colone_1']		= "groupe_id";

	$_REQUEST['CC_TR']['M_CATEGO_rrp']['requete']		= "SELECT cate_id FROM ".$SQL_tab_abrege['categorie']." WHERE site_id = '".$site."' AND cate_role = '2' AND cate_lang = '".$_REQUEST['site_context']['site_lang_id']."';";
	$_REQUEST['CC_TR']['M_CATEGO_rrp']['element']		= "Categorie";
	$_REQUEST['CC_TR']['M_CATEGO_rrp']['colone_1']		= "cate_id";

//decoration
	$_REQUEST['CC_TR']['M_DECORA_rddec']['requete']		= "SELECT deco_nom FROM ".$SQL_tab_abrege['decoration']." WHERE deco_nom = '<A1>';";
	$_REQUEST['CC_TR']['M_DECORA_rddec']['element']		= "Decoration";

	$_REQUEST['CC_TR']['M_DECORA_redec']['requete']		= "SELECT deco_ref_id FROM ".$SQL_tab_abrege['decoration']." WHERE deco_nom = '<A1>';";
	$_REQUEST['CC_TR']['M_DECORA_redec']['element']		= "Decoration";
	$_REQUEST['CC_TR']['M_DECORA_redec']['colone_1']	= "deco_ref_id";

//	$_REQUEST['CC_TR']['M_DECORA_rtdec']['requete']	= "SELECT deco_type FROM ".$SQL_tab_abrege['decoration']." WHERE deco_id = '<A1>';";
//	$_REQUEST['CC_TR']['M_DECORA_rtdec']['element']	= "Decoration";
//	$_REQUEST['CC_TR']['M_DECORA_rtdec']['colone_1']	= "deco_type";

// Document
	$_REQUEST['CC_TR']['M_DOCUME_rdd']['requete']		= "SELECT docu_id,docu_nom FROM ".$SQL_tab_abrege['document']." WHERE docu_nom = '<A1>';";
	$_REQUEST['CC_TR']['M_DOCUME_rdd']['element']		= "Document";

	$_REQUEST['CC_TR']['M_DOCUME_red']['requete']		= "SELECT docu_id,docu_nom FROM ".$SQL_tab_abrege['document']." WHERE docu_nom = '<A1>';";
	$_REQUEST['CC_TR']['M_DOCUME_red']['element']		= "Document";
	$_REQUEST['CC_TR']['M_DOCUME_red']['colone_1']		= "docu_id";

	$_REQUEST['CC_TR']['M_DOCUME_res']['requete']		= "SELECT sw_id FROM ".$SQL_tab_abrege['site_web']." WHERE sw_nom = '<A1>';";
	$_REQUEST['CC_TR']['M_DOCUME_res']['element']		= "Site";
	$_REQUEST['CC_TR']['M_DOCUME_res']['colone_1']		= "sw_id";

	$_REQUEST['CC_TR']['M_DOCUME_rep']['requete']		= "SELECT part_id FROM ".$SQL_tab_abrege['document_partage']." WHERE site_id = '".$site."' AND docu_id = '<A1>';";
	$_REQUEST['CC_TR']['M_DOCUME_rep']['element']		= "Partage";

// Groupe
	$_REQUEST['CC_TR']['M_GROUPE_rdg']['requete']		= "SELECT grp.groupe_id FROM ".$SQL_tab_abrege['groupe']." grp , ".$SQL_tab_abrege['site_groupe']." sg , ".$SQL_tab_abrege['site_web']." sw WHERE grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$site."';";
	$_REQUEST['CC_TR']['M_GROUPE_rdg']['element']		= "Groupe";

	$_REQUEST['CC_TR']['M_GROUPE_reg']['requete']		= "SELECT grp.groupe_id FROM ".$SQL_tab_abrege['groupe']." grp , ".$SQL_tab_abrege['site_groupe']." sg , ".$SQL_tab_abrege['site_web']." sw WHERE grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$site."';";
	$_REQUEST['CC_TR']['M_GROUPE_reg']['element']		= "Groupe";
	$_REQUEST['CC_TR']['M_GROUPE_reg']['colone_1']		= "groupe_id";

// Module
	$_REQUEST['CC_TR']['M_MODULE_rdm']['requete']		= "SELECT mdl.module_id FROM ".$SQL_tab_abrege['module']." mdl , ".$SQL_tab_abrege['site_module']." sm WHERE mdl.module_nom = '<A1>' AND mdl.module_id = sm.module_id AND sm.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_MODULE_rdm']['element']		= "Module";

	$_REQUEST['CC_TR']['M_MODULE_regpv']['requete']		= "SELECT grp.groupe_id AS groupe_id, grp.groupe_nom AS groupe_nom FROM ".$SQL_tab_abrege['groupe']." grp, ".$SQL_tab_abrege['site_groupe']." sg WHERE grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id AND sg.site_id = '".$_REQUEST['site_context']['site_id']."';";
	$_REQUEST['CC_TR']['M_MODULE_regpv']['element']		= "Groupe";
	$_REQUEST['CC_TR']['M_MODULE_regpv']['colone_1']	= "groupe_id";

	$_REQUEST['CC_TR']['M_MODULE_regpu']['requete']		= "SELECT grp.groupe_id AS groupe_id, grp.groupe_nom AS groupe_nom FROM ".$SQL_tab_abrege['groupe']." grp, ".$SQL_tab_abrege['site_groupe']." sg WHERE grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id AND sg.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_MODULE_regpu']['element']		= "";
	$_REQUEST['CC_TR']['M_MODULE_regpu']['colone_1']	= "groupe_id";

// Mot cle
	$_REQUEST['CC_TR']['M_MOTCLE_rdmc']['requete']		= "SELECT mc_id FROM ".$SQL_tab_abrege['mot_cle']." WHERE mc_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_MOTCLE_rdmc']['element']		= "Mot cle";

	$_REQUEST['CC_TR']['M_MOTCLE_remc']['requete']		= "SELECT mc_id FROM ".$SQL_tab_abrege['mot_cle']." WHERE mc_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_MOTCLE_remc']['element']		= "Mot cle";
	$_REQUEST['CC_TR']['M_MOTCLE_remc']['colone_1']		= "mc_id";

// Presentation
	$_REQUEST['CC_TR']['M_PRESNT_rdp']['requete']		= "SELECT pres_id,pres_nom FROM ".$SQL_tab_abrege['presentation']." WHERE pres_nom = '<A1>';";
	$_REQUEST['CC_TR']['M_PRESNT_rdp']['element']		= "Presentation";

	$_REQUEST['CC_TR']['M_PRESNT_rep']['requete']		= "SELECT pres_id FROM ".$SQL_tab_abrege['presentation']." WHERE pres_nom = '<A1>';";
	$_REQUEST['CC_TR']['M_PRESNT_rep']['element']		= "Presentation";
	$_REQUEST['CC_TR']['M_PRESNT_rep']['colone_1']		= "pres_id";

	$_REQUEST['CC_TR']['M_PRESNT_res']['requete']		= "SELECT sd.theme_id AS theme_id, sd.theme_nom AS theme_nom FROM ".$SQL_tab_abrege['theme_descripteur']." sd, ".$SQL_tab_abrege['site_theme']." ss WHERE sd.theme_nom = '<A1>' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_PRESNT_res']['element']		= "Skin";
	$_REQUEST['CC_TR']['M_PRESNT_res']['colone_1']		= "theme_id";

// Theme
	$_REQUEST['CC_TR']['M_THEME_rdt']['requete']		= "SELECT sd.theme_id, sd.theme_nom FROM ".$SQL_tab_abrege['theme_descripteur']." sd, ".$SQL_tab_abrege['site_theme']." ss WHERE sd.theme_nom = '<A1>' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_THEME_rdt']['element']		= "Theme";
	$_REQUEST['CC_TR']['M_THEME_rdt']['colone_1']		= "theme_id";

	$_REQUEST['CC_TR']['M_THEME_ret']['requete']		= "SELECT sd.theme_id, sd.theme_nom FROM ".$SQL_tab_abrege['theme_descripteur']." sd, ".$SQL_tab_abrege['site_theme']." ss WHERE sd.theme_nom = '<A1>' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_THEME_ret']['element']		= "Theme";
	$_REQUEST['CC_TR']['M_THEME_ret']['colone_1']		= "theme_id";

// Tag
// 2017 12 23
// Usage de BINARY à cause de la collation : utf8mb4_general_ci
// https://stackoverflow.com/questions/5629111/how-can-i-make-sql-case-sensitive-string-comparison-on-mysql
// http://mysqlserverteam.com/new-collations-in-mysql-8-0-0/


	$_REQUEST['CC_TR']['M_TAG_rdt']['requete']			= "SELECT tag_id,tag_nom FROM ".$SQL_tab_abrege['tag']." WHERE BINARY tag_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_TAG_rdt']['element']			= "Tag";

	$_REQUEST['CC_TR']['M_TAG_ret']['requete']			= "SELECT tag_id,tag_nom FROM ".$SQL_tab_abrege['tag']." WHERE BINARY tag_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_TAG_ret']['element']			= "Tag";
	$_REQUEST['CC_TR']['M_TAG_ret']['colone_1']			= "tag_id";

	$_REQUEST['CC_TR']['M_TAG_rea']['requete']			= "SELECT arti_id,arti_nom FROM ".$SQL_tab_abrege['article']." WHERE arti_nom = '<A1>' AND site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_TAG_rea']['element']			= "Article";
	$_REQUEST['CC_TR']['M_TAG_rea']['colone_1']			= "arti_id";

	$_REQUEST['CC_TR']['M_TAG_rela']['requete']			= "SELECT tag_id FROM ".$SQL_tab_abrege['article_tag']." WHERE tag_id = '<A1>' AND arti_id = '<A2>';";
	$_REQUEST['CC_TR']['M_TAG_rela']['element']			= "Liaison";

// Utilisateur
// Recherche Doublon Login
// Recherche Existence Login
// Recherche Existence Site
// Recherche Existence Groupe
// Recherche Existence Relation (Groupe_user)

	$_REQUEST['CC_TR']['M_UTILIS_rdl']['requete']		= "SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$SQL_tab_abrege['user']." usr, ".$SQL_tab_abrege['groupe_user']." gu, ".$SQL_tab_abrege['site_groupe']." sg WHERE usr.user_login = '<A1>' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_UTILIS_rdl']['element']		= "Utilisateur";

	$_REQUEST['CC_TR']['M_UTILIS_rel']['requete']		= "SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$SQL_tab_abrege['user']." usr, ".$SQL_tab_abrege['groupe_user']." gu, ".$SQL_tab_abrege['site_groupe']." sg WHERE usr.user_login = '<A1>' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_UTILIS_rel']['element']		= "Utilisateur";
	$_REQUEST['CC_TR']['M_UTILIS_rel']['colone_1']		= "user_id";

	$_REQUEST['CC_TR']['M_UTILIS_res']['requete']		= "SELECT sd.theme_id AS theme_id, sd.theme_nom AS theme_nom FROM ".$SQL_tab_abrege['theme_descripteur']." sd , ".$SQL_tab_abrege['site_theme']." ss WHERE sd.theme_nom = '<A1>' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$site."';";
	$_REQUEST['CC_TR']['M_UTILIS_res']['element']		= "Theme";
	$_REQUEST['CC_TR']['M_UTILIS_res']['colone_1']		= "theme_id";

	$_REQUEST['CC_TR']['M_UTILIS_reg']['requete']		= "SELECT grp.groupe_id AS groupe_id FROM ".$SQL_tab_abrege['groupe']." grp , ".$SQL_tab_abrege['site_groupe']." sg , ".$SQL_tab_abrege['site_web']." sw WHERE grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$site."';";
	$_REQUEST['CC_TR']['M_UTILIS_reg']['element']		= "Groupe";
	$_REQUEST['CC_TR']['M_UTILIS_reg']['colone_1']		= "groupe_id";

	$_REQUEST['CC_TR']['M_UTILIS_rer']['requete']		= "SELECT groupe_user_id, groupe_id, user_id, groupe_premier FROM ".$SQL_tab_abrege['groupe_user']." WHERE groupe_id = '<A1>' AND user_id = '<A2>';";
	$_REQUEST['CC_TR']['M_UTILIS_rer']['element']		= "Relation";

} 
genere_tableau_requete ( 1 );

//	$_REQUEST[CC_TR][][requete]			= "";
//	$_REQUEST[CC_TR][][element]			= "";
//	$_REQUEST[CC_TR][][colone_1]		= "";

//	$_REQUEST[CC_TR][][nbr_colones]	= "";
//	$_REQUEST[CC_TR][][colone_2]		= "";
//	$_REQUEST[CC_TR][][colone_3]		= "";

?>
