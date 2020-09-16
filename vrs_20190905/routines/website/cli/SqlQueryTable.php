<?php 


// Search Duplicate Article
// Search if Exists Article
// Articles
self::$SqlQueryTable['M_ARTICL_rda']['requete']		= "SELECT arti_id,arti_nom FROM ".$SqlTableListObj->getSQLTableName('article')." WHERE arti_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_ARTICL_rda']['element']		= "Article";

self::$SqlQueryTable['M_ARTICL_reb']['requete']		= "SELECT bouclage_id FROM ".$SqlTableListObj->getSQLTableName('bouclage')." WHERE bouclage_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_ARTICL_reb']['element']		= "Bouclage";
self::$SqlQueryTable['M_ARTICL_reb']['colone_1']	= "bouclage_id";

self::$SqlQueryTable['M_ARTICL_reac']['requete']	= "SELECT config_id FROM ".$SqlTableListObj->getSQLTableName('article_config')." WHERE config_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_ARTICL_reac']['element']	= "Article_config";
self::$SqlQueryTable['M_ARTICL_reac']['colone_1']	= "config_id";

self::$SqlQueryTable['M_ARTICL_rec']['requete']		= "SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('groupe_user')." gu, ".$SqlTableListObj->getSQLTableName('site_groupe')." sg WHERE user_login = '<A1>' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_ARTICL_rec']['element']		= "Createur";
self::$SqlQueryTable['M_ARTICL_rec']['colone_1']	= "user_id";

self::$SqlQueryTable['M_ARTICL_rev']['requete']		= "SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('groupe_user')." gu, ".$SqlTableListObj->getSQLTableName('site_groupe')." sg WHERE user_login = '<A1>' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_ARTICL_rev']['element']		= "Validateur";
self::$SqlQueryTable['M_ARTICL_rev']['colone_1']	= "user_id";

self::$SqlQueryTable['M_ARTICL_rep']['requete']		= "SELECT usr.pres_id AS pres_id, usr.pres_nom_generique AS pres_nom_generique FROM ".$SqlTableListObj->getSQLTableName('presentation')." usr , ".$SqlTableListObj->getSQLTableName('theme_presentation')." sp WHERE pres_nom_generique = '<A1>' AND usr.pres_id = sp.pres_id AND sp.theme_id = '<A2>';";
self::$SqlQueryTable['M_ARTICL_rep']['element']		= "Presentation";
self::$SqlQueryTable['M_ARTICL_rep']['colone_1']	= "pres_nom_generique";

self::$SqlQueryTable['M_ARTICL_rea']['requete']		= "SELECT arti_id,arti_nom FROM ".$SqlTableListObj->getSQLTableName('article')." WHERE arti_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_ARTICL_rea']['element']		= "Article";
self::$SqlQueryTable['M_ARTICL_rea']['colone_1']	= "arti_id";

self::$SqlQueryTable['M_ARTICL_red']['requete']		= "SELECT doc.docu_id AS docu_id, doc.docu_nom AS docu_nom FROM ".$SqlTableListObj->getSQLTableName('document')." doc , ".$SqlTableListObj->getSQLTableName('document_partage')." dp WHERE doc.docu_nom = '<A1>' AND dp.docu_id = doc.docu_id AND dp.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_ARTICL_red']['element']		= "Document";
self::$SqlQueryTable['M_ARTICL_red']['colone_1']	= "docu_id";

// Article config
self::$SqlQueryTable['M_ARTCFG_rdac']['requete']	= "SELECT config_id FROM ".$SqlTableListObj->getSQLTableName('article_config')." WHERE config_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_ARTCFG_rdac']['element']	= "Article_config";

// Bouclage
self::$SqlQueryTable['M_BOUCLG_rdb']['requete']		= "SELECT bouclage_id FROM ".$SqlTableListObj->getSQLTableName('bouclage')." WHERE bouclage_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_BOUCLG_rdb']['element']		= "Bouclage";
self::$SqlQueryTable['M_BOUCLG_reb']['requete']		= "SELECT bouclage_id FROM ".$SqlTableListObj->getSQLTableName('bouclage')." WHERE bouclage_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_BOUCLG_reb']['element']		= "Bouclage";
self::$SqlQueryTable['M_BOUCLG_reb']['colone_1']	= "bouclage_id";

// Categorie
self::$SqlQueryTable['M_CATEGO_rdc']['requete']		= "SELECT cate_id FROM ".$SqlTableListObj->getSQLTableName('categorie')." WHERE site_id = '".$webSiteId."' AND cate_nom = '<A1>';";
self::$SqlQueryTable['M_CATEGO_rdc']['element']		= "Categorie";
self::$SqlQueryTable['M_CATEGO_rep']['requete']		= "SELECT cate_id FROM ".$SqlTableListObj->getSQLTableName('categorie')." WHERE site_id = '".$webSiteId."' AND cate_nom = '<A1>';";
self::$SqlQueryTable['M_CATEGO_rep']['element']		= "Categorie";
self::$SqlQueryTable['M_CATEGO_rep']['colone_1']	= "cate_id";
self::$SqlQueryTable['M_CATEGO_reb']['requete']		= "SELECT bouclage_id FROM ".$SqlTableListObj->getSQLTableName('bouclage')." WHERE bouclage_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_CATEGO_reb']['element']		= "Bouclage";
self::$SqlQueryTable['M_CATEGO_reb']['colone_1']	= "bouclage_id";
self::$SqlQueryTable['M_CATEGO_reg']['requete']		= "SELECT grp.groupe_nom, grp.groupe_id FROM ".$SqlTableListObj->getSQLTableName('groupe')." grp , ".$SqlTableListObj->getSQLTableName('site_groupe')." sg  WHERE sg.site_id = '".$webSiteId."' AND grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id;";
self::$SqlQueryTable['M_CATEGO_reg']['element']		= "Groupe";
self::$SqlQueryTable['M_CATEGO_reg']['colone_1']	= "groupe_id";
self::$SqlQueryTable['M_CATEGO_rrp']['requete']		= "SELECT cate_id FROM ".$SqlTableListObj->getSQLTableName('categorie')." WHERE site_id = '".$webSiteId."' AND cate_role = '2' AND cate_lang = '".$A['Context']['sw_lang']."';";
self::$SqlQueryTable['M_CATEGO_rrp']['element']		= "Categorie";
self::$SqlQueryTable['M_CATEGO_rrp']['colone_1']	= "cate_id";

//decoration
self::$SqlQueryTable['M_DECORA_rddec']['requete']	= "SELECT deco_nom FROM ".$SqlTableListObj->getSQLTableName('decoration')." WHERE deco_nom = '<A1>';";
self::$SqlQueryTable['M_DECORA_rddec']['element']	= "Decoration";
self::$SqlQueryTable['M_DECORA_redec']['requete']	= "SELECT deco_ref_id FROM ".$SqlTableListObj->getSQLTableName('decoration')." WHERE deco_nom = '<A1>';";
self::$SqlQueryTable['M_DECORA_redec']['element']	= "Decoration";
self::$SqlQueryTable['M_DECORA_redec']['colone_1']	= "deco_ref_id";

//	self::$SqlQueryTable['M_DECORA_rtdec']['requete']	= "SELECT deco_type FROM ".$SqlTableListObj->getSQLTableName('decoration']." WHERE deco_id = '<A1>';";
//	self::$SqlQueryTable['M_DECORA_rtdec']['element']	= "Decoration";
//	self::$SqlQueryTable['M_DECORA_rtdec']['colone_1']	= "deco_type";

// Document
self::$SqlQueryTable['M_DOCUME_rdd']['requete']		= "SELECT docu_id,docu_nom FROM ".$SqlTableListObj->getSQLTableName('document')." WHERE docu_nom = '<A1>';";
self::$SqlQueryTable['M_DOCUME_rdd']['element']		= "Document";
self::$SqlQueryTable['M_DOCUME_red']['requete']		= "SELECT docu_id,docu_nom FROM ".$SqlTableListObj->getSQLTableName('document')." WHERE docu_nom = '<A1>';";
self::$SqlQueryTable['M_DOCUME_red']['element']		= "Document";
self::$SqlQueryTable['M_DOCUME_red']['colone_1']	= "docu_id";
self::$SqlQueryTable['M_DOCUME_res']['requete']		= "SELECT sw_id FROM ".$SqlTableListObj->getSQLTableName('site_web')." WHERE sw_nom = '<A1>';";
self::$SqlQueryTable['M_DOCUME_res']['element']		= "Site";
self::$SqlQueryTable['M_DOCUME_res']['colone_1']	= "sw_id";
self::$SqlQueryTable['M_DOCUME_rep']['requete']		= "SELECT part_id FROM ".$SqlTableListObj->getSQLTableName('document_partage')." WHERE site_id = '".$webSiteId."' AND docu_id = '<A1>';";
self::$SqlQueryTable['M_DOCUME_rep']['element']		= "Partage";

// Groupe
self::$SqlQueryTable['M_GROUPE_rdg']['requete']		= "SELECT grp.groupe_id FROM ".$SqlTableListObj->getSQLTableName('groupe')." grp , ".$SqlTableListObj->getSQLTableName('site_groupe')." sg , ".$SqlTableListObj->getSQLTableName('site_web')." sw WHERE grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$webSiteId."';";
self::$SqlQueryTable['M_GROUPE_rdg']['element']		= "Groupe";
self::$SqlQueryTable['M_GROUPE_reg']['requete']		= "SELECT grp.groupe_id FROM ".$SqlTableListObj->getSQLTableName('groupe')." grp , ".$SqlTableListObj->getSQLTableName('site_groupe')." sg , ".$SqlTableListObj->getSQLTableName('site_web')." sw WHERE grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$webSiteId."';";
self::$SqlQueryTable['M_GROUPE_reg']['element']		= "Groupe";
self::$SqlQueryTable['M_GROUPE_reg']['colone_1']	= "groupe_id";

// Module
self::$SqlQueryTable['M_MODULE_rdm']['requete']		= "SELECT mdl.module_id FROM ".$SqlTableListObj->getSQLTableName('module')." mdl , ".$SqlTableListObj->getSQLTableName('site_module')." sm WHERE mdl.module_nom = '<A1>' AND mdl.module_id = sm.module_id AND sm.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_MODULE_rdm']['element']		= "Module";
self::$SqlQueryTable['M_MODULE_regpv']['requete']	= "SELECT grp.groupe_id AS groupe_id, grp.groupe_nom AS groupe_nom FROM ".$SqlTableListObj->getSQLTableName('groupe')." grp, ".$SqlTableListObj->getSQLTableName('site_groupe')." sg WHERE grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id AND sg.site_id = '".$_REQUEST['site_context']['site_id']."';";
self::$SqlQueryTable['M_MODULE_regpv']['element']	= "Groupe";
self::$SqlQueryTable['M_MODULE_regpv']['colone_1']	= "groupe_id";
self::$SqlQueryTable['M_MODULE_regpu']['requete']	= "SELECT grp.groupe_id AS groupe_id, grp.groupe_nom AS groupe_nom FROM ".$SqlTableListObj->getSQLTableName('groupe')." grp, ".$SqlTableListObj->getSQLTableName('site_groupe')." sg WHERE grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id AND sg.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_MODULE_regpu']['element']	= "";
self::$SqlQueryTable['M_MODULE_regpu']['colone_1']	= "groupe_id";

// Mot cle
self::$SqlQueryTable['M_MOTCLE_rdmc']['requete']	= "SELECT mc_id FROM ".$SqlTableListObj->getSQLTableName('mot_cle')." WHERE mc_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_MOTCLE_rdmc']['element']	= "Mot cle";
self::$SqlQueryTable['M_MOTCLE_remc']['requete']	= "SELECT mc_id FROM ".$SqlTableListObj->getSQLTableName('mot_cle')." WHERE mc_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_MOTCLE_remc']['element']	= "Mot cle";
self::$SqlQueryTable['M_MOTCLE_remc']['colone_1']	= "mc_id";

// Presentation
self::$SqlQueryTable['M_PRESNT_rdp']['requete']		= "SELECT pres_id,pres_nom FROM ".$SqlTableListObj->getSQLTableName('presentation')." WHERE pres_nom = '<A1>';";
self::$SqlQueryTable['M_PRESNT_rdp']['element']		= "Presentation";
self::$SqlQueryTable['M_PRESNT_rep']['requete']		= "SELECT pres_id FROM ".$SqlTableListObj->getSQLTableName('presentation')." WHERE pres_nom = '<A1>';";
self::$SqlQueryTable['M_PRESNT_rep']['element']		= "Presentation";
self::$SqlQueryTable['M_PRESNT_rep']['colone_1']		= "pres_id";
self::$SqlQueryTable['M_PRESNT_res']['requete']		= "SELECT sd.theme_id AS theme_id, sd.theme_nom AS theme_nom FROM ".$SqlTableListObj->getSQLTableName('theme_descripteur')." sd, ".$SqlTableListObj->getSQLTableName('site_theme')." ss WHERE sd.theme_nom = '<A1>' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_PRESNT_res']['element']		= "Skin";
self::$SqlQueryTable['M_PRESNT_res']['colone_1']		= "theme_id";

// Theme
self::$SqlQueryTable['M_THEME_rdt']['requete']		= "SELECT sd.theme_id, sd.theme_nom FROM ".$SqlTableListObj->getSQLTableName('theme_descripteur')." sd, ".$SqlTableListObj->getSQLTableName('site_theme')." ss WHERE sd.theme_nom = '<A1>' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_THEME_rdt']['element']		= "Theme";
self::$SqlQueryTable['M_THEME_rdt']['colone_1']		= "theme_id";
self::$SqlQueryTable['M_THEME_ret']['requete']		= "SELECT sd.theme_id, sd.theme_nom FROM ".$SqlTableListObj->getSQLTableName('theme_descripteur')." sd, ".$SqlTableListObj->getSQLTableName('site_theme')." ss WHERE sd.theme_nom = '<A1>' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_THEME_ret']['element']		= "Theme";
self::$SqlQueryTable['M_THEME_ret']['colone_1']		= "theme_id";

// Tag
// 2017 12 23
// Usage de BINARY à cause de la collation : utf8mb4_general_ci
// https://stackoverflow.com/questions/5629111/how-can-i-make-sql-case-sensitive-string-comparison-on-mysql
// http://mysqlserverteam.com/new-collations-in-mysql-8-0-0/
self::$SqlQueryTable['M_TAG_rdt']['requete']		= "SELECT tag_id,tag_nom FROM ".$SqlTableListObj->getSQLTableName('tag')." WHERE BINARY tag_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_TAG_rdt']['element']		= "Tag";
self::$SqlQueryTable['M_TAG_ret']['requete']		= "SELECT tag_id,tag_nom FROM ".$SqlTableListObj->getSQLTableName('tag')." WHERE BINARY tag_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_TAG_ret']['element']		= "Tag";
self::$SqlQueryTable['M_TAG_ret']['colone_1']		= "tag_id";
self::$SqlQueryTable['M_TAG_rea']['requete']		= "SELECT arti_id,arti_nom FROM ".$SqlTableListObj->getSQLTableName('article')." WHERE arti_nom = '<A1>' AND site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_TAG_rea']['element']		= "Article";
self::$SqlQueryTable['M_TAG_rea']['colone_1']		= "arti_id";
self::$SqlQueryTable['M_TAG_rela']['requete']		= "SELECT tag_id FROM ".$SqlTableListObj->getSQLTableName('article_tag')." WHERE tag_id = '<A1>' AND arti_id = '<A2>';";
self::$SqlQueryTable['M_TAG_rela']['element']		= "Liaison";

// Utilisateur
// Recherche Doublon Login
// Recherche Existence Login
// Recherche Existence Site
// Recherche Existence Groupe
// Recherche Existence Relation (Groupe_user)
self::$SqlQueryTable['M_UTILIS_rdl']['requete']		= "SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('groupe_user')." gu, ".$SqlTableListObj->getSQLTableName('site_groupe')." sg WHERE usr.user_login = '<A1>' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_UTILIS_rdl']['element']		= "Utilisateur";
self::$SqlQueryTable['M_UTILIS_rel']['requete']		= "SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('groupe_user')." gu, ".$SqlTableListObj->getSQLTableName('site_groupe')." sg WHERE usr.user_login = '<A1>' AND usr.user_id = gu.user_id AND gu.groupe_id = sg.groupe_id AND gu.groupe_premier = '1' AND sg.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_UTILIS_rel']['element']		= "Utilisateur";
self::$SqlQueryTable['M_UTILIS_rel']['colone_1']	= "user_id";
self::$SqlQueryTable['M_UTILIS_res']['requete']		= "SELECT sd.theme_id AS theme_id, sd.theme_nom AS theme_nom FROM ".$SqlTableListObj->getSQLTableName('theme_descripteur')." sd , ".$SqlTableListObj->getSQLTableName('site_theme')." ss WHERE sd.theme_nom = '<A1>' AND sd.theme_id = ss.theme_id AND ss.site_id = '".$webSiteId."';";
self::$SqlQueryTable['M_UTILIS_res']['element']		= "Theme";
self::$SqlQueryTable['M_UTILIS_res']['colone_1']	= "theme_id";
self::$SqlQueryTable['M_UTILIS_reg']['requete']		= "SELECT grp.groupe_id AS groupe_id FROM ".$SqlTableListObj->getSQLTableName('groupe')." grp , ".$SqlTableListObj->getSQLTableName('site_groupe')." sg , ".$SqlTableListObj->getSQLTableName('site_web')." sw WHERE grp.groupe_nom = '<A1>' AND grp.groupe_id = sg.groupe_id AND sg.site_id = sw.sw_id AND sw.sw_id = '".$webSiteId."';";
self::$SqlQueryTable['M_UTILIS_reg']['element']		= "Groupe";
self::$SqlQueryTable['M_UTILIS_reg']['colone_1']	= "groupe_id";
self::$SqlQueryTable['M_UTILIS_rer']['requete']		= "SELECT groupe_user_id, groupe_id, user_id, groupe_premier FROM ".$SqlTableListObj->getSQLTableName('groupe_user')." WHERE groupe_id = '<A1>' AND user_id = '<A2>';";
self::$SqlQueryTable['M_UTILIS_rer']['element']		= "Relation";


?>