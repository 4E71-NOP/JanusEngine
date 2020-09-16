<?php
/*MWM-licence*/
// --------------------------------------------------------------------------------------------
//
//	MWM - Multi Web Manager
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@multiweb-manager.net
//
// --------------------------------------------------------------------------------------------
/*MWM-licence-fin*/

$GALdebug = 0;

if ( $GALdebug == 1 ) {
	$GAL_nom = "Debug";
	$GAL_dir = "../websites-datas/www.rootwave.net/data/documents/fra_galerie_dessin_peinture_p01/";
	if (!isset($_REQUEST['GAL_page_selection'])) { $_REQUEST['GAL_page_selection'] = 1; }
}
//	On cherche des fichiers dans le rep specifié et on range ca dans un tableau
// --------------------------------------------------------------------------------------------

$pv['requete'] = "UPDATE ".$SQL_tab_abrege['pv']." SET pv_nombre = 1 WHERE pv_nom = 'galerie_ticket';";
//manipulation_traitement_requete ( $pv['requete'] );
requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );

$pv['i'] = 1;

// --------------------------------------------------------------------------------------------

if ( is_dir( $GAL_dir ) ) {
	$GAL_dir_array = array();
	$handle = opendir( $GAL_dir );
	while (false !== ($file = readdir($handle))) {
		if ( $file != "." && $file != ".." && strpos($file , $site_web['sw_gal_fichier_tag'] ) === false ) { $GAL_dir_array[] = $file; }
	}
	closedir($handle);
	sort ($GAL_dir_array);
	reset ($GAL_dir_array);

	if ( $GALdebug == 1 ) { outil_debug ( $GAL_dir_array , "\$GAL_dir_array" ); }
	$GAL_nbr_page = count($GAL_dir_array) / ($GAL_table_colones * $GAL_table_lignes);				// Calcule le nombre de pages total
	$GAL_nbr_page_reste = count($GAL_dir_array) % ($GAL_table_colones * $GAL_table_lignes);			// Calcule le reste de la division
	if ( $GAL_nbr_page_reste != 0 ) { $GAL_nbr_page++ ; }											// Ajoute 1 si la division ne tombe pas juste
	$GAL_offset = ($_REQUEST['GAL_page_selection'] -1) * ($GAL_table_colones * $GAL_table_lignes);	// Positionne l'offset à l'endroit qu'il faut

	echo ("<p class='".$theme_tableau.$_REQUEST['bloc']."_t3' style='text-align: center;'>--&nbsp;&nbsp;");
	for ( $GAL_page = 1 ; $GAL_page <= $GAL_nbr_page ; $GAL_page++ ) {
		if ( $_REQUEST['GAL_page_selection'] != $GAL_page ) {
			echo ("<a class='".$theme_tableau.$_REQUEST['bloc']."_lien' href=\"index.php?arti_ref=".${$document_tableau}['arti_ref']."&amp;arti_page=".${$document_tableau}['arti_page']."&GAL_page_selection=".$GAL_page . $bloc_html['url_slup']."\">".$GAL_page."</a>&nbsp;&nbsp;");
		}
		else { echo ("<span class='".$theme_tableau.$_REQUEST['bloc']."_tb3 ".$theme_tableau.$_REQUEST['bloc']."_highlight'>(".$GAL_page.")</span>&nbsp;&nbsp;");
		}
	}
	$pv['tab_width'] = $theme_princ_['theme_module_largeur_interne'] - 32;
	$pv['tab_margin'] = floor ( $pv['tab_width'] / 2 );
	echo ("--
	</p>\r
	<table style='width:100%; margin:5px'>\r
	");
	// --------------------------------------------------------------------------------------------
	//	Construction de la table qui affiche les vignettes
	// --------------------------------------------------------------------------------------------

	$pv['fichier'] = "../extensions/".$PA['extension_repertoire']."/programmes/".$PLF['vignette']['fichier_nom'];
	$pv['i'] = 1;
	for ( $nline = 0 ; $nline < $GAL_table_lignes ; $nline ++ ) {
		echo ("<tr>\r");
		for ( $ncols = 0 ; $ncols < $GAL_table_colones ; $ncols++ ) {
			if ( isset($GAL_dir_array[$GAL_offset])) {
				$file_stat = stat($GAL_dir."/".$GAL_dir_array[$GAL_offset]);
				$GAL_fichier_taille = round ($file_stat['size'] / 1024 , 1);
				$GAL_nom_fichier = substr ( $GAL_dir_array[$GAL_offset] , 0, $GAL_taille_nom ) . "...";
				echo ("
				<td class='".$theme_tableau.$_REQUEST['bloc']."_fca'>\r
				<p class='".$theme_tableau.$_REQUEST['bloc']."_t1' style='text-align: left;'> 
				".$GAL_nom_fichier."
				</p>\r
				<p class='".$theme_tableau.$_REQUEST['bloc']."_t1' style='text-align: center;'>\r
				<a class='".$theme_tableau.$_REQUEST['bloc']."_lien' href='".$GAL_dir."/".$GAL_dir_array[$GAL_offset]."' target='".$GAL_dir_array[$GAL_offset]."'>\r
				<img src='".$pv['fichier']."?
				src=../../".$GAL_dir."/".$GAL_dir_array[$GAL_offset]."
				&m=".$PLC['mode']."
				&x=".$PLC['x']."
				&y=".$PLC['y']."
				&l=".$PLC['liserai']."
				&q=".$PLC['qualite']."
				&t=".$PLC['fichier_tag']."
				&fc=".$fichier_config."
				&n=".$pv['i']."
				&debug=0
				'>\r
				</a>\r
				</p>
				<p class='".$theme_tableau.$_REQUEST['bloc']."_t1' style='text-align: right;'> ".$GAL_fichier_taille." Ko
				</p>
				</td>\r
				");
				$GAL_offset++;
				$pv['i']++;
			}
		}
		echo ("</tr>\r");
	}

	echo ("
	</table>
	</center>\r
	");
}
else { 
	echo ("<br>ERR<br>");
}
?>
