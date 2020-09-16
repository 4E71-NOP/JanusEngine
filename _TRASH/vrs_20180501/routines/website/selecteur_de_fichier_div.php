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

/*
$_REQUEST['FS_index']++;
$pv['i'] = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$pv['i']['left']					= 16;
$pv['i']['top']						= 16;
$pv['i']['width']					= 768;
$pv['i']['height']					= 512;
$pv['i']['js_cs']					= "";
$pv['i']['formulaire']				= "formulaire_TST";
$pv['i']['champs']					= "fonkytext";
$pv['i']['lsdf_chemin']				= "../modules/";
$pv['i']['mode_selection']			= "fichier";
$pv['i']['lsdf_mode']				= "tout";
$pv['i']['lsdf_nivmax']				= 10;
$pv['i']['lsdf_indicatif']			= "TSTSDF";
$pv['i']['lsdf_parent_idx']			= 1;
$pv['i']['lsdf_parent']['0']		= "TabSDF_".$pv['i']['lsdf_indicatif'];
$pv['i']['lsdf_parent']['1']		= "TabSDF_".$pv['i']['lsdf_indicatif'];
$pv['i']['lsdf_racine']				= "F";
$pv['i']['lsdf_coupe_chemin']		= 1;
$pv['i']['lsdf_conserve_chemin']	= "modules/";
$pv['i']['lsdf_coupe_repertoire']	= 0;
$pv['i']['liste_fichier']		= array();

generation_icone_selecteur_fichier ( 1 , $pv['i']['formulaire'] , $pv['i']['champs'] , 50 , "selection fichier" , "TabSDF_".$pv['i']['lsdf_indicatif'] )
*/

$_REQUEST['lsdf']['fichier'] = 1;
$_REQUEST['lsdf']['repertoire'] = 2;
$_REQUEST['lsdf']['tout'] = 3;
$_REQUEST['lsdf_id'] = 0;
$_REQUEST['lsdf_colone1'] = "is_dir";
$_REQUEST['lsdf_colone2'] = "chemin";


// type			1 special	2 repertoire	3 lien_repertoire	4 fichier	5 lien_fichier	6 lien_cassé
// priorité		1			2				2					3			3				4
function compare_colone ( $a, $b ) {
	$r = strnatcmp( $a[$_REQUEST['lsdf_colone1']], $b[$_REQUEST['lsdf_colone1']] );
	if(!$r) { return strnatcmp( $a[$_REQUEST['lsdf_colone2']], $b[$_REQUEST['lsdf_colone2']] ); }
	return $r;
}

function listage_systeme_de_fichier ( $niveau_courant ) {
	global $JavaScriptInitDonnees, $theme_tableau, ${$theme_tableau}, $l;
	$idx_ = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
	$realpath = realpath ( $idx_['lsdf_chemin'] );

	if ( $niveau_courant == 0 ) { $_REQUEST['SDFObj'] .= "racine:'TabSDF_".$idx_['lsdf_indicatif']."',\r ls:{\r"; }

	$Score['mode'] = $_REQUEST['lsdf'][$idx_['lsdf_mode']];
	switch ( $Score['mode'] ) {
		case 1: 	$Mode['fichier'] = 1;	$Mode['repertoire'] = 0;	break;
		case 2: 	$Mode['fichier'] = 0;	$Mode['repertoire'] = 1;	break;
		case 3: 	$Mode['fichier'] = 1;	$Mode['repertoire'] = 1;	break;
	}

	$Score['selection'] = $_REQUEST['lsdf'][$idx_['mode_selection']];
	switch ( $Score['selection'] ) {
		case 1: 	$Score['selection'] = 0;	break;
		case 2: 	$Score['selection'] = 16;	break;
	}

	$handle = opendir( $realpath );
	while (false !== ( $f = readdir($handle))) {

		$id = $idx_['lsdf_racine'] . $_REQUEST['lsdf_id'];
		$f_stat = stat( $realpath."/".$f );

		$RepEnCours[$id]['id']			= $id;
		$RepEnCours[$id]['ref']			= $idx_['lsdf_parent'][$idx_['lsdf_parent_idx']].".ls.".$id;
		$RepEnCours[$id]['niveau']		= $niveau_courant;
		$RepEnCours[$id]['valeur']		= $f;
		$RepEnCours[$id]['chemin']		= $realpath."/".$f;
		$RepEnCours[$id]['cible']		= realpath ( $RepEnCours[$id]['chemin'] ) ? : readlink ($RepEnCours[$id]['chemin'] );
		$RepEnCours[$id]['relatif']		= "-|-";
		$RepEnCours[$id]['taille']		= $f_stat['size'];
		$RepEnCours[$id]['date']		= strftime ("%a %d %b %y - %H:%M", $f_stat['mtime'] );
		$RepEnCours[$id]['parent']		= $idx_['lsdf_parent'][($idx_['lsdf_parent_idx']-1)];
		$RepEnCours[$id]['is_link']		= 0;
		$RepEnCours[$id]['is_link_ok']	= 0;
		$RepEnCours[$id]['is_dir']		= 1;
		$RepEnCours[$id]['priorite']	= 2;
		$RepEnCours[$id]['affichage']	= $Mode['fichier'];

		if ( is_dir( $RepEnCours[$id]['chemin'] ) ) {
			$RepEnCours[$id]['is_dir'] = 2;
			$RepEnCours[$id]['priorite'] = 1;
			$RepEnCours[$id]['affichage'] = $Mode['repertoire'];
		}
		if ( is_link ( $RepEnCours[$id]['chemin'] ) ) {
			$RepEnCours[$id]['is_link'] = 4;
			if ( file_exists($RepEnCours[$id]['cible']) ) { $RepEnCours[$id]['is_link_ok'] = 8; }
			$RepEnCours[$id]['relatif'] = readlink ($RepEnCours[$id]['chemin'] );
		}
		if ( $f == "." || $f == ".." )	{
			$RepEnCours[$id]['score'] = 99;
			$RepEnCours[$id]['priorite'] = 0;
		}
		else { $RepEnCours[$id]['score'] = $RepEnCours[$id]['is_dir'] + $RepEnCours[$id]['is_link'] + $RepEnCours[$id]['is_link_ok'] + $Score['selection']; }

		if ( $idx_['lsdf_coupe_chemin'] == 1 ) { 
			$RepEnCours[$id]['chemin'] = $idx_['lsdf_conserve_chemin'] . str_replace ( realpath ( $idx_['lsdf_chemin'] )."/" , "" , $RepEnCours[$id]['chemin'] ); 
		}
		elseif ( $idx_['lsdf_coupe_repertoire'] == 1 ) { $RepEnCours[$id]['chemin'] = substr ( $RepEnCours[$id]['chemin'] , strrpos($RepEnCours[$id]['chemin'],"/")+1 , strlen($RepEnCours[$id]['chemin']) ); }

		$_REQUEST['lsdf_id']++;
	}

	$_REQUEST['lsdf_colone1'] = "priorite";
	$_REQUEST['lsdf_colone2'] = "valeur";
	uasort($RepEnCours, 'compare_colone');
	reset ($RepEnCours);

	foreach ( $RepEnCours as $A ) {
		switch ( $A['score'] ) {
		case 18:
		case 30:
		case 1:		if ( $A['affichage'] == 1 ) { $_REQUEST['SDFObj'] .= str_repeat("\t",$niveau_courant).$A['id'].":{ ref:'".$A['ref']."',	score:'".$A['score']."', nom:'".$A['valeur']."', taille:'".$A['taille']."', date:'".$A['date']."',	r:'".$A['chemin']."' },\r"; }																	break;
		case 2:		if ( $A['affichage'] == 1 ) { $_REQUEST['SDFObj'] .= str_repeat("\t",$niveau_courant).$A['id'].":{ ref:'".$A['ref']."',	score:'".$A['score']."', nom:'".$A['valeur']."', taille:'".$A['taille']."', date:'".$A['date']."',	p:'".$A['parent']."',	ls: { \r"; }															break;
		case 5:
		case 22:
		case 13:	if ( $A['affichage'] == 1 ) { $_REQUEST['SDFObj'] .= str_repeat("\t",$niveau_courant).$A['id'].":{ ref:'".$A['ref']."',	score:'".$A['score']."', nom:'".$A['valeur']."', taille:'".$A['taille']."', date:'".$A['date']."',	r:'".$A['chemin']."',	cible:'".$A['relatif']."' },\r";  }										break;
		case 6:
		case 14:	if ( $A['affichage'] == 1 ) { $_REQUEST['SDFObj'] .= str_repeat("\t",$niveau_courant).$A['id'].":{ ref:'".$A['ref']."',	score:'".$A['score']."', nom:'".$A['valeur']."', taille:'".$A['taille']."', date:'".$A['date']."',	p:'".$A['parent']."',	cible:'".$A['relatif']."', ls: { \r"; }									break;
		case 99:	if ( $A['affichage'] == 1 ) { $_REQUEST['SDFObj'] .= str_repeat("\t",$niveau_courant).$A['id'].":{ ref:'".$A['ref']."',	score:'".$A['score']."', nom:'".$A['valeur']."', 													p:'".$A['parent']."',	n:'".$niveau_courant."' },\r"; }										break;
		}

		switch ( $A['score'] ) {
		case 2:
		case 6:
		case 14:
//			echo ( "<!-- ". $idx_['lsdf_indicatif'] ."|". $niveau_courant ."/". $idx_['lsdf_nivmax']." -->\r" );
			if ( $niveau_courant < $idx_['lsdf_nivmax'] ) {
				$sauvegarde['lsdf_chemin']	= $idx_['lsdf_chemin'];
				$idx_['lsdf_chemin']		= $idx_['lsdf_chemin']."/".$A['valeur']."/";
				$idx_['lsdf_parent_idx']++;
				$idx_['lsdf_parent'][$idx_['lsdf_parent_idx']]	= $idx_['lsdf_parent'][($idx_['lsdf_parent_idx']-1)].".ls.".$A['id'];

				listage_systeme_de_fichier ( ($niveau_courant+1) );
				$idx_['lsdf_parent_idx']--;
				$idx_['lsdf_chemin']		= $sauvegarde['lsdf_chemin'];
				if ( $A['affichage'] == 1 ) { $_REQUEST['SDFObj'] = substr($_REQUEST['SDFObj'],0,-3)."\r".str_repeat("\t",$niveau_courant)."} },\r"; }
			}
			else {
				if ( $A['affichage'] == 1 ) { $_REQUEST['SDFObj'] .= "rien:'rien' },\r"; }
			}
		}
	}

	$_REQUEST['SDFObj'] .= "\r";
	if ( $niveau_courant == 0 ) { 
		$idx_['wc1a'] =  floor( ( $idx_['width'] * 0.675 ) ); 
		$idx_['wc2a'] =  floor( ( $idx_['width'] * 0.10 ) ); 
		$idx_['wc3a'] =  floor( ( $idx_['width'] * 0.20 ) ); 
		$idx_['wc4a'] =  ( $idx_['width'] - $idx_['wc1a'] - $idx_['wc2a'] - $idx_['wc3a']);
		$tl_['eng']['c1'] = "File";					$tl_['fra']['c1'] = "Fichier";
		$tl_['eng']['c2'] = "Size";					$tl_['fra']['c2'] = "Taille";
		$tl_['eng']['c3'] = "Date";					$tl_['fra']['c3'] = "Date";

		$TableEntete = "
		<table style='border-spacing: 0px; empty-cells: show; width:".$idx_['width']."px;'>\r

		<colgroup>\r
		<col width='".$idx_['wc1a']."'>\r
		<col width='".$idx_['wc2a']."'>\r
		<col width='".$idx_['wc3a']."'>\r
		<col width='".$idx_['wc4a']."'>\r
		</colgroup>\r

		<tr>\r
		<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcta " . $theme_tableau.$_REQUEST['bloc']."_tb4'>&nbsp;</td>\r
		<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcta " . $theme_tableau.$_REQUEST['bloc']."_tb4'>&nbsp;</td>\r
		<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcta " . $theme_tableau.$_REQUEST['bloc']."_tb4' colspan='2' style='text-align:right;'>
		<a  class='" . $theme_tableau.$_REQUEST['bloc']."_lien' Onclick=\"AptitudeWindowPageScroll ( 0 ); DisparitionElement('selecteur_de_fichier_FondNoir');DisparitionElement('selecteur_de_fichier_cadre');\">
		<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_nok'] . "' width='24' height='24' border='0'>
		</a>\r</td>\r
		</tr>\r

		<tr>\r
		<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcta " . $theme_tableau.$_REQUEST['bloc']."_tb4 SdfTdDeco1' style='text-align: left;'>".$tl_[$l]['c1']."</td>\r
		<td class='" . $theme_tableau.$_REQUEST['bloc']."_fctb " . $theme_tableau.$_REQUEST['bloc']."_tb4 SdfTdDeco2' style='text-align: center;'>".$tl_[$l]['c2']."</td>\r
		<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcta " . $theme_tableau.$_REQUEST['bloc']."_tb4 SdfTdDeco3' style='text-align: center;'>".$tl_[$l]['c3']."</td>\r
		<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcta " . $theme_tableau.$_REQUEST['bloc']."_tb4 SdfTdDeco3' style='text-align: center;'>&nbsp;</td>\r
		</tr>\r

		</table>\r

		<div style='position:absolute; display:block; overflow:auto; width:".$idx_['width']."px; height:".($idx_['height']-64)."px;'>
		<table id='selecteur_de_fichier_dynamique' style='border-spacing: 0px; empty-cells: show; width:".($idx_['wc1a']+$idx_['wc2a']+$idx_['wc3a'])."px;'>\r
		</table>\r
		</div>
		";

		$_REQUEST['SDFObj'] = $_REQUEST['SDFObj'] = substr($_REQUEST['SDFObj'],0,-3)."\r},\rs:{\r
	StyleA:{ StyleN:'".$theme_tableau.$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t3',	StyleS:'".$theme_tableau.$_REQUEST['bloc']."_fcsa ".$theme_tableau.$_REQUEST['bloc']."_t3' },\r
	StyleB:{ StyleN:'".$theme_tableau.$_REQUEST['bloc']."_fcb ".$theme_tableau.$_REQUEST['bloc']."_t3',	StyleS:'".$theme_tableau.$_REQUEST['bloc']."_fcsb ".$theme_tableau.$_REQUEST['bloc']."_t3' },\r
	classes:{ 
	ok:'".$theme_tableau.$_REQUEST['bloc']."_ok', 
	erreur:'".$theme_tableau.$_REQUEST['bloc']."_erreur', 
	lien:'theme_princ_".$_REQUEST['bloc']."_lien'}\r
},\r

htmlform:{ form:'".$idx_['formulaire']."', champ:'".$idx_['champs']."' },\r

elements:{\r
TableEntete:`".$TableEntete."`,
TableCorps:`<colgroup>\r
	<col width='".$idx_['wc1a']."'>\r
	<col width='".$idx_['wc2a']."'>\r
	<col width='".$idx_['wc3a']."'>\r
	</colgroup>`\r
}\r
";
	}
}

?>
