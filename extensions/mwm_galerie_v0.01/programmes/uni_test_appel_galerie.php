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
/*
$_REQUEST['GG']['update'] = 1;
$_REQUEST['GG']['mode'] = 1;
$_REQUEST['GG']['qualite'] = 40;
$_REQUEST['GG']['x'] = 64;
$_REQUEST['GG']['y'] = 64;
$_REQUEST['GG']['liserai'] = 5;
$_REQUEST['GG']['tag'] = "Thumbplouf_";
*/
/*MWM-file_content*/
$_REQUEST['sql_initiateur'] = "Test du plugin MWMGalerie";

$pv['requete'] = "UPDATE ".$SQL_tab_abrege['pv']." SET pv_nombre = 1 WHERE pv_nom = 'galerie_ticket';";
manipulation_traitement_requete ( $pv['requete'] );
$pv['i'] = 1;


$PA = Plugin_Appel ( "MWM_Galerie"  );
$PLC = &$PA['plugin_config'];
$PLF = &$PA['plugin_fichiers'];




$GAL_table_colones = 3;
$GAL_table_lignes = 3;
$GAL_nom = "Photographie";
$GAL_dir = "../websites-datas/".$site_web['sw_repertoire']."/data/documents/".${$document_tableau}['arti_ref']."_p0".${$document_tableau}['arti_page'];
if (!isset($_REQUEST['GAL_page_selection'])) { $_REQUEST['GAL_page_selection'] = 1; }



$pv['fichier'] = "../plugins/".$PA['plugin_repertoire']."/programmes/".$PLF['vignette']['fichier_nom'];
$PLF = &$PA['plugin_fichiers'];

echo("
<img src='".$pv['fichier']."?
src=001-1.jpg
&m=".$PLC['mode']."
&x=".$PLC['x']."
&l=".$PLC['liserai']."
&q=".$PLC['qualite']."
&t=".$PLC['fichier_tag']."
&fc=".$fichier_config."
&n=".$pv['i']."
&debug=0
'>\r
");




echo ( 
	"<br><span class='" . $theme_tableau . $_REQUEST['bloc']."_t1'>".
	print_r_html ( $PA ) . "<br>".
	print_r_html ( $pv['fichier'] ) . "<br>".
	print_r_html ( $_REQUEST['server_infos'] ) . "<br></span>"
);



if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$PA,
		$PLC , 
		$PLF , 
		$dbp , 
		$GAL_mode_select,
		$PF_,
		$PFC_,
		$pv,
		$tl_
	);
}
/*MWM-content_end*/
?>
