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
//	Tags are for sticking on an article in order to be able to use the internal search engine.
//	Keywords are for highlighting expression inside the article. 
// --------------------------------------------------------------------------------------------
//	Manipulation tag
// --------------------------------------------------------------------------------------------
function manipulation_tag () {
	global $WebSiteObj;
	$SqlTableListObj = SqlTableList::getInstance(null, null);
	$R = &$_REQUEST['M_TAG'];

	$_REQUEST['conv_expr_section'] = "M_TAG";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];																	// recupere la langue courante
	$tl_['eng']['si'] = "Tag processing ";
	$tl_['fra']['si'] = "Manipulation tag";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['M_TAG_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_TAG_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_TAG_00001" , $tl_[$l]['M_TAG_00001'] );
		$R['ERR'] = 1;
	}
	else {
		//$_REQUEST['site_context']['site_id'] = $_REQUEST['site_context']['site_id'];
		//$_REQUEST['site_context']['site_nom'] = $_REQUEST['site_context']['site_nom'];
		//$_REQUEST['site_context']['skin_id'] = $_REQUEST['site_context']['skin_id'];
		$timestamp_MT = time ();
		switch ($R['action']) {

// --------------------------------------------------------------------------------------------
//		Pas d'action
		case 0:
		break;

// --------------------------------------------------------------------------------------------
//		Creation de tag
		case 1:
			systeme_requete_unifiee ( 3 , "M_TAG_rdt" , $R['tag_nom'] , 0 , "M_TAG_1_0001" , $_REQUEST['fake'] );

			if ( $R['ERR'] != 1 ) {
				$R['tag_nom']	= strtolower ($R['tag_nom']) ;
				$R['tag_html']	= string_format_html ($R['tag_nom']);
				$R['tag_id']	= manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('tag') , "tag_id" );

				string_DB_escape ( $_REQUEST['liste_colonne']['tag'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['tag'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['tag'] as $A ) { $requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SqlTableListObj->getSQLTableName('tag')." VALUES ".$requete_valeurs.";";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['ok'] = "Job done!";
				$tl_['fra']['ok'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_TAG_1_0002" , $tl_[$l]['ok'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['tag_selection'] = $_REQUEST['M_TAG']['id'];
				if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
				$R['creation_effectuee'] = 1;
				$R['tag_selection'] = $pv['tag_selection'];
			}
		break;

// --------------------------------------------------------------------------------------------
//	Modification (toute modification de contenu)
// --------------------------------------------------------------------------------------------
//		insertion d'une relation tag - article
		case 21:
			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}
//			echo ( "***R***<br>" . print_r_html ( $R ) . "<br>" );
			systeme_requete_unifiee ( 2 , "M_TAG_ret" , $R['tag'] , 0 , "M_TAG_21_0001" , $R['tag_id'] );
			systeme_requete_unifiee ( 2 , "M_TAG_rea" , $R['arti_nom'] , 0 , "M_TAG_21_0002" , $R['arti_id'] );
			systeme_requete_unifiee ( 3 , "M_TAG_rela" , $R['tag_id'] , $R['arti_id'] , "M_TAG_21_0003" , $_REQUEST['fake'] );

			if ( $R['ERR'] != 1 ) {
				$R['article_tag_id']	= manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('article_tag') , "article_tag_id" );

				$requete1 = "
				INSERT INTO ".$SqlTableListObj->getSQLTableName('article_tag')." VALUES ( 
				'".$R['article_tag_id']."', 
				'".$R['arti_id']."', 
				'".$R['tag_id']."' 
				);";

				manipulation_traitement_requete ( $requete1 );
				$tl_['eng']['ok'] = "Job done!";
				$tl_['fra']['ok'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_TAG_2_0003" , $tl_[$l]['ok'] );
				$_REQUEST['CC']['status'] = "OK";
			}
		break;
// --------------------------------------------------------------------------------------------
//	Suppression
// --------------------------------------------------------------------------------------------
		case 3:
			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}
			systeme_requete_unifiee ( 2 , "M_TAG_ret" , $R['tag_nom'] , 0 , "M_TAG_3_0001" , $R['tag_id'] );

			if ( $R['ERR'] != 1 ) {
				$R['tag_id']	= manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('article_tag') , "article_tag_id" );
				$requete1 = "
				DELETE FROM ".$SqlTableListObj->getSQLTableName('article_tag')." 
				WHERE tag_id = '".$R['tag_id']."'
				;";

				manipulation_traitement_requete ( $requete1 );
				$tl_['eng']['M_TAG_3_0002'] = "Job done!";
				$tl_['fra']['M_TAG_3_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_TAG_3_0002" , $tl_[$l]['M_TAG_3_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['tag_selection'] = $_REQUEST['M_TAG']['id'];
				if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
				$R['modification_effectuee'] = 1;
				$R['tag_selection'] = $pv['tag_selection'];
			}
		break;
// --------------------------------------------------------------------------------------------
//		show
		case 5:
			$tl_['eng']['M_TAG_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_TAG_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_TAG_5_caption'];
			if ( $R['nom'] == "" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "AND tag_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT tag_nom 
				FROM ".$SqlTableListObj->getSQLTableName('tag')." 
				WHERE site_id = '".$_REQUEST['site_context']['site_id']."' 
				".$pv['clause']." 
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['tag_nom'] . ", "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT * 
				FROM ".$SqlTableListObj->getSQLTableName('tag')." 
				WHERE site_id = '".$_REQUEST['site_context']['site_id']."' 
				AND tag_nom = '".$R['nom']."' 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_TAG_5_001'] = "No tag named ".$R['nom']." exists.";
					$tl_['fra']['M_TAG_5_001'] = "Le tag nom&eacute; ".$R['nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_TAG_5_0001" , $tl_[$l]['M_TAG_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
	}
unset ( $R );
}
?>
