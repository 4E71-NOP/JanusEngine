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
//	Fonctions utilisable par tout script
// --------------------------------------------------------------------------------------------

$localisation = " / fonctions_universelles";
$_REQUEST['localisation'] .= $localisation;
statistique_checkpoint ("fonctions_universelles");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

function generation_bouton () {
	if ( strlen($_REQUEST['BS']['style_hover']) > 0 ) { 
		$animation = " onmouseover=\"buttonHover('".$_REQUEST['BS']['id']."', '".$_REQUEST['BS']['style_hover']."');\" onmouseout=\"buttonHover('".$_REQUEST['BS']['id']."', '".$_REQUEST['BS']['style_initial']."');\" ";
	}
	$data = "
	<table cellpadding='0' cellspacing='0'  
	style='
	border-width: 0px 0px 0px 0px; 
	border-spacing: 0px; 
	border-style: none none none none;
	'>\r 
	<tr>\r
	<td			id='".$_REQUEST['BS']['id']."01' class='".$_REQUEST['BS']['style_initial']."01' ".$animation."></td>\r
	<td><input	id='".$_REQUEST['BS']['id']."02' class='".$_REQUEST['BS']['style_initial']."02' ".$animation." 
	type='".$_REQUEST['BS']['type']."' value='".$_REQUEST['BS']['message']."' ";
	if ( strlen($_REQUEST['BS']['onclick']) > 0 ) { $data .= " onclick=\"".$_REQUEST['BS']['onclick']."\" "; }
	$data .= " style='";
	switch ($_REQUEST['BS']['mode'] == 1) {
	case TRUE:
		switch ($_REQUEST['BS']['taille'] != 0) {
		case TRUE:	$data .= "width: ".$_REQUEST['BS']['taille']."px; "; $_REQUEST['BS']['derniere_taille'] = $_REQUEST['BS']['taille'];	break;
		case FALSE:	$data .= "width: ".$_REQUEST['BS']['derniere_taille']."px; ";															break;
	}
	break;
	case FALSE:	$_REQUEST['BS']['derniere_taille'] = 0 ;	break;
	}

	$data .= "border: 0px; padding: 0px; margin: 0px'></td>\r
	<td			id='".$_REQUEST['BS']['id']."03' class='".$_REQUEST['BS']['style_initial']."03' ".$animation."></td>\r
	</tr>\r
	</table>\r
	";
	return $data ;
}

// --------------------------------------------------------------------------------------------
// Generation de selecteur de fichier avec icone.
function generation_icone_selecteur_fichier ( $cas , $FormNom , $ForgeFormElement, $taille , $InputVal , $SDFTab ) {
	global $theme_tableau, ${$theme_tableau};
	$X = ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_dim_x'];
	$Y = ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_dim_y'];

	$contenu_A = "
	<input type='text' readonly name='".$ForgeFormElement."' id='".$ForgeFormElement."' size='".$taille."' maxlength='255' value='".$InputVal."' class='".$theme_tableau.$_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_form_1' >\r
	<span class='".$theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_t3' Onclick=\"SDFTabRepCourant ( ".$SDFTab." , ".$SDFTab." , 'selecteur_de_fichier_dynamique' ); DivRemplissageEcran('selecteur_de_fichier_FondNoir', 1 ); CommuteAffichageCentre('selecteur_de_fichier_cadre')\">\r
	<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_repertoire'] . "' width='".$X."' height='".$Y."' border='0'>
	</span>
	";

	$contenu_B = "
	<span class='".$theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_t3' Onclick=\"document.forms['".$FormNom."'].elements['".$ForgeFormElement."'].value = '';\">
	<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_efface'] . "' width='".$X."' height='".$Y."' border='0'>
	</span>\r
	";

	$contenu_R = "";
	switch ( $cas ) {
	case 1 :	$contenu_R = $contenu_A; 				break;
	case 2 :	$contenu_R = $contenu_B; 				break;
	case 3 :	$contenu_R = $contenu_A . $contenu_B;	break;
	}
	return $contenu_R;
}

function generation_icone_selecteur_image ( $cas , $FormNom , $ForgeFormElement, $ForgeFormElementX, $ForgeFormElementY, $FormRepertoire , $InputVal , $DivCible , $JavascriptRoutine , $ModType ) {
	global $theme_tableau, ${$theme_tableau};
	$X = ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_dim_x'];
	$Y = ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_dim_y'];

	$contenu_A = "
	<input type='text' name='".$ForgeFormElement."' id='".$ForgeFormElement."' size='20' maxlength='255' value='".$InputVal."' class='".$theme_tableau.$_REQUEST['bloc']."_form_1' 
	onChange=\"
	var NewU = 'url(\'../graph/' + document.forms['".$FormNom."'].elements['".$FormRepertoire."'].value + '/'+ this.value + '\')';
	Gebi('".$DivCible."').style.backgroundImage = NewU;\r
	\">\r

	<span class='".$theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_t3' 
	Onclick=\"
	CDMExec.ModType = '".$ModType."';
	CDMExec.NomModule = '".$DivCible."';
	CDMExec.FormCible = '".$FormNom."';
	RenderFSJS('".$FormNom."','".$ForgeFormElement."', '".$ForgeFormElementX."', '".$ForgeFormElementY."', document.forms['".$FormNom."'].elements['".$FormRepertoire."'].value , 'FSJavaScript' , 'FSJS_C_' , '".$JavascriptRoutine."' )\">
	<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_repertoire'] . "' width='".$X."' height='".$Y."' border='0'></span>\r
	";

	$contenu_B = "
	<span class='".$theme_tableau.$_REQUEST['bloc']."_lien' Onclick=\"document.forms['".$FormNom."'].elements['".$ForgeFormElement."'].value = ''; 
	CDMExec.ModType = '".$ModType."';
	CDMExec.NomModule = '".$DivCible."';
	CDMExec.FormCible = '".$FormNom."';
	".$JavascriptRoutine."();\">\r
	<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_efface'] . "' width='".$X."' height='".$Y."' border='0' alt=''></span>\r
	";

	$contenu_R = "";
	switch ( $cas ) {
	case 1 :	$contenu_R = $contenu_A; 				break;
	case 2 :	$contenu_R = $contenu_B; 				break;
	case 3 :	$contenu_R = $contenu_A . $contenu_B;	break;
	}
	return $contenu_R;
}

// --------------------------------------------------------------------------------------------
//	Formattage expressions

function string_format_html	($expr)	{ return htmlentities($expr); }
function string_format_DB	($expr)	{ return addslashes($expr); }
function string_post_to_DB	($expr)	{
	$expr = str_replace ("\n", "[BR]", $expr);
	return addslashes($expr);
}
function string_post_to_textarea ($expr)	{
	$expr = str_replace ("[BR]", "\n", $expr);
	return addslashes($expr);
}

function tronquage_expression ( $expr , $l0 ) {
	$ls = strlen( $expr );
	$l1 = floor( $l0 / 2 );
	$l2 = $l1 - 4;
	switch (TRUE) {
	case ($ls < $l1 ):					$R = $expr;																	break;
	case ($ls < $l0 && $ls > $l2 ):		$R = substr ($expr,0,$l2) . " [...] ";										break;
	case ($ls > $l0 || $ls == $l0 ):	$R = substr ($expr,0,$l2) . " [...] " . substr ($expr,($ls - $l2) ,$ls );	break;
	}
	return $R;
}

function install_utilisateur_initial ( &$cibleL , &$cibleP ) {
	switch ( $_REQUEST['contexte_d_execution'] ) {
		case "Installation" :
		case "Admin_menu" :
		case "Extension_installation" :
			if ( $cibleL == "*utilisateur_install*" ) { $cibleL = $_REQUEST['form']['database_user_login']; }
			if ( $cibleP == "*utilisateur_install*" ) { $cibleP = $_REQUEST['form']['database_user_password']; }
			if ( $cibleP == "*utilisateur_standard*" ) { $cibleP = $_REQUEST['form']['standard_user_password']; }
		break;
	}
}

function string_utf8_to_html ( $str ){
	$str = utf8_decode( $str );
	$rch = array("é","è","à","ë","ê","û","ü","ù","î","ï", "ô", "ö");
	$rpl =array("&eacute;", "&egrave;", "&agrave;", "&euml;", "&ecirc;", "&ucirc;", "&uuml;", "&ugrave;", "&icirc;", "&iuml;", "&ocirc;", "&ouml;");
	$str = str_replace( $rch , $rpl , $str );
	return $str ;
}


function string_DB_escape ( &$Liste , $section ) {
	//global $db;
	//foreach ( $Liste as $A ) { $_REQUEST[$section][$A] = $db->escape($_REQUEST[$section][$A]); }
	foreach ( $Liste as $A ) { $_REQUEST[$section][$A] = addslashes($_REQUEST[$section][$A]); }
}

function string_DAL_escape ( $val ) {
	global $db, $db_;
	switch ( $db_['dal'] ) {
	case "MYSQLI":		$val = $db->real_escape_string($val);					break;
	case "PDOMYSQL":															break;
	case "SQLITE":																break;
	case "ADODB":		$val = $db->qstr($val);									break;
	case "PEARDB":	
	case "PEARSQLITE":	$val = $db->escape($val , $escape_wildcards = false);	break;
	}
	return ($val);
}


// Ne semble plus être utilisée. Investiguer et déprécier.
function string_DB_conversion_expression ( &$Liste , $section ) {
	global $tab_conv_expr;
	foreach ( $Liste as $A ) { 
		$_REQUEST[$A] = $tab_conv_expr[$section][strtolower( $_REQUEST[$A] )];
		if ( $_REQUEST['debug_conversion_expression'] == 1 ) { echo ("Section ".$_REQUEST['conv_expr_section']."; in: ".$expr." / ".$a." / out: ".$expr2." <br>"); }
	}
}

// --------------------------------------------------------------------------------------------
//	Generation de la table langues
function genere_table_langue ( $tab ) {
	global $SQL_tab_abrege, ${$tab}, $site_web;

	switch ( $_REQUEST['contexte_d_execution'] ) {
	case "Installation":
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"SELECT * FROM ".$SQL_tab_abrege['langues'].";");
		while ($dbp = fetch_array_sql($dbquery)) {
			$idx = $dbp['langue_id'];
			foreach ( $dbp as $A => $B ) { ${$tab}[$idx][$A] = $B; }
			${$tab}[$dbp['langue_639_3']]['id'] = $dbp['langue_id'];
		}
	break;
	case "Rendu":
	default:
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"SELECT * FROM ".$SQL_tab_abrege['site_langue']." WHERE site_id = '".$_REQUEST['sw']."';");
		while ($dbp = fetch_array_sql($dbquery)) { $TabLangueAdmises[] = $dbp['lang_id']; }
		sort ( $TabLangueAdmises );

		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"SELECT * FROM ".$SQL_tab_abrege['langues'].";");
		while ($dbp = fetch_array_sql($dbquery)) {
			$idx = $dbp['langue_id'];
			$TableRendu = 0;
			unset ($B);
			reset ( $TabLangueAdmises );
			foreach ( $TabLangueAdmises as $B ) { if ( $B == $dbp['langue_id'] ) { $TableRendu = 1; } }
			if ( $TableRendu == 1 ) {
				foreach ( $dbp as $A => $B ) { ${$tab}[$idx][$A] = $B; }
				${$tab}[$dbp['langue_639_3']]['id'] = $dbp['langue_id'];
			}
		}
	break;
	}
}

// --------------------------------------------------------------------------------------------
//	Couteau suisse

function print_r_html ($data,$return_data=true) {
	$data = print_r($data,true);
	$tab_rch = array ("&",		"<",		">",	" ",		"\r\n",		"\r",		"\n");
	$tab_rpl = array ("&amp;",	"&lt;",		"&gt;",	"&nbsp;",	"<br>\r",	"<br>\r",	"<br>\r");
	$data = str_replace ($tab_rch,$tab_rpl,$data);
	if ( !$return_data ) { echo $data; }
	else { return $data; }
}

function print_r_debug($data,$return_data=true) {
	$data = print_r($data,true);
	$tab_rch = array ("\r\n",		"\r",		"\n");
	$tab_rpl = array ("\n",			"\n",		"\n");
	$data = str_replace ($tab_rch,$tab_rpl,$data);
	if (!$return_data) { echo $data; }
	else { return $data; }
}

function print_r_code($data , $tab , $return_data=true) {
	foreach ($data as $key => $value) {
		if (is_array($value)) {
			$j = $tab . "\t";
			$new_array = print_r_code( $value , $j ); 
			$dump .= $tab."\"".$key."\" => array (\n ".$new_array."\n".$tab."),\n";
		}
		else { $dump .= $tab."\"".$key."\" => \"".$value."\",\n";}
	}
	$dump = substr( $dump , 0 , -2 );
	if (!$return_data) { echo $data; }
	else { return $dump; }
}


// --------------------------------------------------------------------------------------------
//	Chasseur de mémoire

function Conversion_taille( $size ) {
	global $theme_tableau;
	$Tab_unite = array(
	"<span class='" . $theme_tableau .$_REQUEST['bloc']."_ok'>b</span>",
	"<span class='" . $theme_tableau .$_REQUEST['bloc']."_avert'>Kb</span>",
	"<span class='" . $theme_tableau .$_REQUEST['bloc']."_erreur " . $theme_tableau.$_REQUEST['bloc']."_tb3'>MB</span>",
	"<span class='" . $theme_tableau .$_REQUEST['bloc']."_erreur " . $theme_tableau.$_REQUEST['bloc']."_tb4'>GB</span>"
	);
	if ($size == 0 ) {
		return "0<span class='" . $theme_tableau .$_REQUEST['bloc']."_erreur " . $theme_tableau.$_REQUEST['bloc']."_tb3'>Kb</span>";
	}
	else {
		if ( $size < 0 ) { return "-".round(abs($size)/pow(1024,($i=floor(log(abs($size),1024)))),2)." ".$Tab_unite[$i]; }
		else { return round(abs($size)/pow(1024,($i=floor(log(abs($size),1024)))),2).' '.$Tab_unite[$i]; }
	}
}

function Taille_memoire_variable( $var ) {
  $start_memory = memory_get_usage();   
  $temp = unserialize(serialize( $var ));   
  $taille = memory_get_usage() - $start_memory;
  return Conversion_taille( $taille ) ;
}

function Taille_memoire_variable_brute ( $var ) {
  $start_memory = memory_get_usage();   
  $temp = unserialize(serialize( $var ));   
  $taille = memory_get_usage() - $start_memory;
  return ( $taille ) ;
}

// --------------------------------------------------------------------------------------------
//	Log
// --------------------------------------------------------------------------------------------
//	objectifs: Le demandeur reste mais ne doit plus etre le script
// Faire en sorte de ne pas logger un 'empty set' sur demande

function journalisation_evenement ( $Type , $initiateur , $action , $signal , $msgid , $text ) {
	switch ( $_REQUEST['contexte_d_execution'] ) {
	case "Installation":
		switch ( $_REQUEST['debug_option']['journalisation_cible'] ) {
		case "systeme" :
			$A = "MWM_install_log: ".$CC_index."|".$initiateur."|".$action."|".$signal."|".$msgid."|".$text."|";
			error_log ( html_entity_decode ( $A ) ,0 );
		break;
		case "echo" :
			echo ( "MWM_install_log: ".$CC_index."|".$initiateur."|".$action."|".$signal."|".$msgid."|".$text."|<br>" );
		break;
		}

		switch ( $signal ) {
		case "ERR" :	$Niveau = 0;	break;
		case "WARN" :	$Niveau = 1;	break;
		case "OK" :
		case "INFO" :	$Niveau = 2;	break;
		}

		switch ( $Type ) {
		case 1 :	$Reference = $_REQUEST['debug_option']['CC_debug_level'];		break;
		case 2 :	$Reference = $_REQUEST['debug_option']['SQL_debug_level'];		break;
		}

		if ( $Reference > $Niveau ) {
			$CC_index = $_REQUEST['manipulation_result']['nbr'];	
			$_REQUEST['manipulation_result'][$CC_index]['nbr']		= $CC_index;
			$_REQUEST['manipulation_result'][$CC_index]['signal']	= $signal;
			$_REQUEST['manipulation_result'][$CC_index]['nom']		= $initiateur;
			$_REQUEST['manipulation_result'][$CC_index]['action']	= $action;
			$_REQUEST['manipulation_result'][$CC_index]['msgid']	= $msgid;
			$_REQUEST['manipulation_result'][$CC_index]['msg']		= $text;
			$_REQUEST['manipulation_result']['nbr']++;
		}

		if ( $type == "ERR" ) {	$_REQUEST['manipulation_result']['error'] = 1; }
		if ( $_REQUEST['debug_log_force'] == 1 ) { echo ($CC_index . " - " . $initiateur . " - " . $text . "<br>"); }
	break;

	case "admin_menu":
	case "Admin_menu":
	case "Extension_installation":
	case "Rendu":
	default:
		global $site_web, $SQL_tab, $db , $db_;
		$tab['ERR'] = 0;		$tab['OK'] = 1;		$tab['WARN'] = 2;		$tab['INFO'] = 3;		$tab['AUTRE'] = 4;
		$signal = $tab[$signal];

		switch ( $db_['dal'] ) {
		case "MYSQLI":
			$initiateur		= $db->real_escape_string($initiateur);
			$action			= $db->real_escape_string($action);
			$text			= $db->real_escape_string($text);
		break;
		case "PDOMYSQL":
			$initiateur		= $db->quote($initiateur);
			$action			= $db->quote($action);
			$text			= $db->quote($text);
		break;
		case "SQLITE":
		break;
		case "ADODB":
			$initiateur		= $db->qstr($initiateur);
			$action			= $db->qstr($action);
			$text			= $db->qstr($text);
		break;
		case "PEARDB":
		case "PEARSQLITE":
			$initiateur		= $db->escape($initiateur , $escape_wildcards = false);
			$action			= $db->escape($action , $escape_wildcards = false);
			$text			= $db->escape($text , $escape_wildcards = false);
		break;
		}

		switch ( $_REQUEST['debug_option']['journalisation_cible'] ) {
		case "systeme" :
			$A = "MWM_Engine_log: ".$site_web['sw_id']."|".time ()."|".$initiateur."|".$action."|".$signal."|".$msgid."|".$text;
			error_log ( html_entity_decode ( $A ) ,0 );
		break;
		case "echo" :
			echo ( "MWM_Engine_log: ".$site_web['sw_id']."|".time ()."|".$initiateur."|".$action."|".$signal."|".$msgid."|".$text ."<br>" );
		break;
		case "interne" :
		default:
			$historique_id	= manipulation_trouve_id_suivant ( $SQL_tab['historique'] , historique_id );
			requete_sql( $initiateur ,"
			INSERT INTO ".$SQL_tab['historique']." VALUES (
			'".$historique_id."',
			'".$site_web['sw_id']."', 
			'".time ()."', 
			'".$initiateur."', 
			'".$action."', 
			'".$signal."', 
			'".$msgid."', 
			'".$text."')
			;");
		break;
		}
	break;
//	default :
		//echo ("Context d'execution  = '".$_REQUEST['contexte_d_execution']."' \n");
//	break;
	}
}

function outil_debug ( &$variable , $nom ) {
	global $Outil_debug;
	$Outil_debug[$_REQUEST['outil_debug_idx']]['nom'] = $nom."<br>\r".$_REQUEST['localisation'];
	$Outil_debug[$_REQUEST['outil_debug_idx']]['cont'] = $variable;
	$_REQUEST['outil_debug_idx']++;
}

// --------------------------------------------------------------------------------------------
//	Traitement de requete pour les manipulations

function manipulation_traitement_requete ( $requete ) {
	switch ( $_REQUEST['form']['mode_operatoire'] ) {
	case "installation_differee":
		$tab_rch = array (chr(13),	"\n",	"\r",	"\n\r",	"\r\n",	"	",	"*/");
		$tab_rpl = array (" ",		" ",	" ",	" ",	" ",	" ",	"*/\n");
		$requete = str_replace ($tab_rch,$tab_rpl,$requete);

		$_REQUEST['master_install_script'] .= $requete . "\n";

		$tab_rch = array ("AUTO_INCREMENT",	"NOT NULL",	"CHAR");
		$tab_rpl = array ("AUTOINCREMENT",	"",			"VARCHAR");
		$requete = str_replace ($tab_rch,$tab_rpl,$requete);
	break;
	case "connexion_directe":
	default:
	break;
	}
	requete_sql( $_REQUEST['sql_initiateur'], $requete );
}

//	Repond au besoin de SQL92 qui n'a pas de fonction d'auto increment.
//	On ne peut pas se servir d'un 'CREATE SEQUENCE' qui n'est pas SQL92/99 (petit Oracleuh va).
function manipulation_trouve_id_suivant ( $table , $colone ) {
	$_REQUEST['id_compteur'] = 0;
	$_REQUEST['id_valeur'] = 0;
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"SELECT ".$colone." FROM ".$table." ;");
	while ($dbp = fetch_array_sql($dbquery)) {
		$_REQUEST['id_compteur']++;
		if ( $dbp[$colone] > $_REQUEST['id_valeur'] ) { $_REQUEST['id_valeur'] = $dbp[$colone]; }
	}
	$_REQUEST['id_valeur']++;
	return $_REQUEST['id_valeur'];
}


// --------------------------------------------------------------------------------------------
function choix_decoration ( $decoration_type ) {
	global $module_ , $pres_, $theme_tableau;
	if ( $module_['module_deco'] != 1 ) { $decoration_type = 10000; }
	$_REQUEST['div_id']['un_div'] = $_REQUEST['div_id']['ex22'] = "id='".$module_['module_nom']."' ";
	switch ( $decoration_type ) {
	case 30:	case "1_div":		if ( !function_exists("module_deco_30_1_div") )		{ include ("module_deco_30_1_div.php"); }		module_deco_30_1_div ( $theme_tableau , "pres_" , "module_", 0 );		break;
	case 40:	case "elegance":	if ( !function_exists("module_deco_40_elegance") )	{ include ("module_deco_40_elegance.php"); }	module_deco_40_elegance ( $theme_tableau , "pres_" , "module_", 0 );	break;
	case 50:	case "exquise":		if ( !function_exists("module_deco_50_exquise") )	{ include ("module_deco_50_exquise.php"); }		module_deco_50_exquise ( $theme_tableau , "pres_" , "module_", 0 );		break;
	case 60:	case "elysion":		if ( !function_exists("module_deco_60_elysion") )	{ include ("module_deco_60_elysion.php"); }		module_deco_60_elysion ( $theme_tableau , "pres_" , "module_", 0 );		break;
	default:
		$mn = &$module_['module_nom'];
		echo ("<div id='".$mn."' class='".$theme_tableau.$_REQUEST['bloc']."_div_std' style='position: absolute; left:".$pres_[$mn]['px']."px; top:".$pres_[$mn]['py']."px; width:".$pres_[$mn]['dx']."px; height:".$pres_[$mn]['dy']."px; '>\r"); 
		${$theme_tableau}['theme_module_largeur_interne'] = $pres_[$mn]['dx'];			//no decoration
		${$theme_tableau}['theme_module_hauteur_interne'] = $pres_[$mn]['dy'];			//no decoration
		
	break;
	}
}

function decoration_nomage_bloc ( $debut , $nombre , $fin ) {
	$a = $debut . sprintf("%02u",$nombre) . $fin;
	return $a;
}

function CDS_liste_bloc_element ( $prefix , $liste , $suffix ) {
	$liste_tab = explode( " " , $liste );
	foreach ( $liste_tab as $A ) { $expr .= $prefix . $A . $suffix .", "; }
	$expr = substr ( $expr , 0 , -2 ) . " ";
	return $expr;
}

function CDS_traitement_couleurs ( ) {
	foreach ( $_REQUEST['Bloc_a_traiter_couleur'] as $A => &$B ) {
		if ( strpos ( $A , "_col" ) !== FALSE && strpos ( $A , "#" ) == FALSE && strlen( $B ) != 0 && $B != "transparent" ) { $B = "#" . $B; }
	}
}

function vide_module_div_ids () {
	foreach ( $_REQUEST['div_id'] as &$A ) { $A = ""; }
}

// --------------------------------------------------------------------------------------------
// Extensions
function Extension_Recherche_Id ( $nom  ) {
	global $SQL_tab_abrege, $site_web;
	$pv['requete'] = "SELECT ext.extension_id 
	FROM ".$SQL_tab_abrege['extension']." ext 
	WHERE ext.site_id = '".$site_web['sw_id']."' 
	AND ext.extension_nom = '".$nom."'
	;";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );
	while ($dbp = fetch_array_sql($dbquery)) { $cible = $dbp['extension_id']; }
	return ( $cible );
}

function Extension_Appel ( $nom  ) {
	global $SQL_tab_abrege, $site_web;

	$pv['requete'] = "SELECT ext.* 
	FROM ".$SQL_tab_abrege['extension']." ext 
	WHERE ext.site_id = '".$site_web['sw_id']."' 
	AND ext.extension_nom = '".$nom."'
	;";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );
	while ($dbp = fetch_array_sql($dbquery)) { foreach ( $dbp as $A => $B ) { $tab[$A] = $B; } }

	$pv['requete'] = "SELECT exf.* 
	FROM ".$SQL_tab_abrege['extension_fichiers']." exf 
	WHERE exf.extension_id = '".$tab['extension_id']."' 
	;";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );
	while ($dbp = fetch_array_sql($dbquery)) { 
		$T = &$tab['extension_fichiers'][$dbp['fichier_nom_generique']];
		foreach ( $dbp as $A => $B ) { $T[$A] = $B; }
	}

	$pv['requete'] = "SELECT exc.* 
	FROM ".$SQL_tab_abrege['extension_config']." exc 
	WHERE exc.extension_id = '".$tab['extension_id']."' 
	AND exc.site_id = '".$site_web['sw_id']."' 
	;";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );
	while ($dbp = fetch_array_sql($dbquery)) { 
		$tab['extension_config'][$dbp['extension_variable']] = $dbp['extension_valeur'];
	}
	return ( $tab );
}


// --------------------------------------------------------------------------------------------
function config_variable () {
	global $SQL_tab, $SQL_tab_abrege, $db_;
	$SQL_tab_abrege['article']				= $db_['tabprefix'] . "article";
	$SQL_tab_abrege['article_tag']			= $db_['tabprefix'] . "article_tag";
	$SQL_tab_abrege['auteurs']				= $db_['tabprefix'] . "auteurs";
	$SQL_tab_abrege['bouclage']				= $db_['tabprefix'] . "bouclage";
	$SQL_tab_abrege['categorie']			= $db_['tabprefix'] . "categorie";
	$SQL_tab_abrege['article_config']		= $db_['tabprefix'] . "article_config";
	$SQL_tab_abrege['document_partage']		= $db_['tabprefix'] . "document_partage";

	$SQL_tab_abrege['deco_10_menu']			= $db_['tabprefix'] . "deco_10_menu";
	$SQL_tab_abrege['deco_20_caligraphe']	= $db_['tabprefix'] . "deco_20_caligraphe";
	$SQL_tab_abrege['deco_30_1_div']		= $db_['tabprefix'] . "deco_30_1_div";
	$SQL_tab_abrege['deco_40_elegance']		= $db_['tabprefix'] . "deco_40_elegance";
	$SQL_tab_abrege['deco_50_exquise']		= $db_['tabprefix'] . "deco_50_exquise";
	$SQL_tab_abrege['deco_60_elysion']		= $db_['tabprefix'] . "deco_60_elysion";

	$SQL_tab_abrege['decoration']				= $db_['tabprefix'] . "decoration";
	$SQL_tab_abrege['document']					= $db_['tabprefix'] . "document";
	$SQL_tab_abrege['groupe']					= $db_['tabprefix'] . "groupe";
	$SQL_tab_abrege['groupe_user']				= $db_['tabprefix'] . "groupe_user";
	$SQL_tab_abrege['historique']				= $db_['tabprefix'] . "historique";
	$SQL_tab_abrege['installation']				= $db_['tabprefix'] . "installation";
	$SQL_tab_abrege['langues']					= $db_['tabprefix'] . "langues";
	$SQL_tab_abrege['module']					= $db_['tabprefix'] . "module";
	$SQL_tab_abrege['mot_cle']					= $db_['tabprefix'] . "mot_cle";
	$SQL_tab_abrege['note_renvoit']				= $db_['tabprefix'] . "note_renvoit";
	$SQL_tab_abrege['presentation']				= $db_['tabprefix'] . "presentation";
	$SQL_tab_abrege['presentation_contenu']		= $db_['tabprefix'] . "presentation_contenu";
	$SQL_tab_abrege['extension']				= $db_['tabprefix'] . "extension";
	$SQL_tab_abrege['extension_config']			= $db_['tabprefix'] . "extension_config";
	$SQL_tab_abrege['extension_dependances']	= $db_['tabprefix'] . "extension_dependances";
	$SQL_tab_abrege['extension_fichiers']		= $db_['tabprefix'] . "extension_fichiers";
	$SQL_tab_abrege['pv']						= $db_['tabprefix'] . "pv";
	$SQL_tab_abrege['site_groupe']				= $db_['tabprefix'] . "site_groupe";
	$SQL_tab_abrege['site_langue']				= $db_['tabprefix'] . "site_langue";
	$SQL_tab_abrege['site_module']				= $db_['tabprefix'] . "site_module";
	$SQL_tab_abrege['site_theme']				= $db_['tabprefix'] . "site_theme";
	$SQL_tab_abrege['site_web']					= $db_['tabprefix'] . "site_web";
	$SQL_tab_abrege['theme_descripteur']		= $db_['tabprefix'] . "theme_descripteur";
	$SQL_tab_abrege['theme_presentation']		= $db_['tabprefix'] . "theme_presentation";
	$SQL_tab_abrege['stat_document']			= $db_['tabprefix'] . "stat_document";
	$SQL_tab_abrege['stat_navigateur']			= $db_['tabprefix'] . "stat_navigateur";
	$SQL_tab_abrege['stat_utilisateur']			= $db_['tabprefix'] . "stat_utilisateur";
	$SQL_tab_abrege['tag']						= $db_['tabprefix'] . "tag";
	$SQL_tab_abrege['user']						= $db_['tabprefix'] . "user";
	$SQL_tab_abrege['tl_fra']					= $db_['tabprefix'] . "tl_fra";

	foreach  ( 	$SQL_tab_abrege as $A => $B ) { $SQL_tab[$A] = $db_['dbprefix'].".".$SQL_tab_abrege[$A]; }
}


// --------------------------------------------------------------------------------------------
//
//	Création des variables universelles et chacun des alias dans chaque section.
//

function conversion_expression ( $expr ) {
	global $tab_conv_expr;
	$a = strtolower($expr);
	$expr2 = $tab_conv_expr[$_REQUEST['conv_expr_section']][$a];
	if ( $_REQUEST['debug_conversion_expression'] == 1 ) { echo ("Section ".$_REQUEST['conv_expr_section']."; in: ".$expr." / ".$a." / out: ".$expr2." <br>"); }
	return $expr2;
}


unset ( $pv['i'] );
for ( $pv['i'] = 0 ; $pv['i'] <= 200 ; $pv['i']++ ) { $tab_conv_expr['UNI'][$pv['i']] = $pv['i']; }
//lors du chargement des informations le programme cherche a retraduire certaines valeurs. Il faut donc qu'une valeur déjà traduite ne tombe pas sur une variable non définie.
$pv['liste_section'] = array ( 
1	=> array ( "s" => "M_SITWEB",	"n" => 200 ), 
2	=> array ( "s" => "M_UTILIS",	"n" => 200 ),
3	=> array ( "s" => "M_ARTCFG",	"n" => 10 ), 
4	=> array ( "s" => "M_ARTICL",	"n" => 10 ),
5	=> array ( "s" => "M_BOUCLG",	"n" => 10 ),
6	=> array ( "s" => "M_CATEGO",	"n" => 10 ),
7	=> array ( "s" => "M_DOCUME",	"n" => 10 ),
8	=> array ( "s" => "M_DECORA",	"n" => 10 ),
9	=> array ( "s" => "M_GROUPE",	"n" => 10 ),
10	=> array ( "s" => "M_MODULE",	"n" => 10 ),
11	=> array ( "s" => "M_MOTCLE",	"n" => 10 ), 
12	=> array ( "s" => "M_PRESNT", 	"n" => 10 ),
13	=> array ( "s" => "M_TAG",		"n" => 10 ),
14	=> array ( "s" => "M_THEME",	"n" => 10 )
);

unset ( $A );
foreach ( $pv['liste_section'] as $A ) {
	unset ( $pv['i'] );
	for ( $pv['i'] = 0 ; $pv['i'] <= $A['n'] ; $pv['i']++ ) { $tab_conv_expr[$A['s']][$pv['i']] = &$tab_conv_expr['UNI'][$pv['i']]; }
	sort ( $tab_conv_expr[$A['s']] );
	reset ( $tab_conv_expr[$A['s']] );
}

$pv['liste_section'] = array ( "UNI", "M_SITWEB", "M_UTILIS", "M_ARTCFG", "M_ARTICL", "M_BOUCLG", "M_CATEGO", "M_DOCUME", "M_DECORA", "M_GROUPE", "M_MODULE", "M_MOTCLE", "M_PRESNT", "M_TAG", "M_THEME" );
unset ( $A );
foreach ( $pv['liste_section'] as $A ) {
	$B = &$tab_conv_expr[$A];
	$B['non']	= $B['hors_ligne']	= $B['statique']	= $B['inactif']	= $B['desactive']	= $B['no']	= $B['off']	= $B['offline']	= $B['static']	= $B['inactive']	= $B['desactivated']	= &$tab_conv_expr['UNI']['0'];
	$B['oui']	= $B['en_ligne']	= $B['dynamique']	= $B['actif']	= $B['active']		= $B['yes']	= $B['on']	= $B['online']	= $B['dynamic']	= $B['active']		= $B['activated']		= &$tab_conv_expr['UNI']['1'];
	$B['supprime']	= $B['deleted']		= &$tab_conv_expr['UNI']['2'];
}

unset ( $A );
$pv['cpt'] = 1;
$pv['ListeLangue'] = array ( "aar", "abk", "ave", "afr", "aka", "amh", "arg", "ara", "asm", "ava", "aym", "aze", "bak", "bel", "bul", "--", "bis", "bam", "ben", "bod", "bre", "bos", "cat", "che", "cha", "cos", "cre", "ces", "chu", "chv", "cym", "dan", "deu", "div", "dzo", "ewe", "ell", "eng", "epo", "spa", "est", "eus", "fas", "ful", "fin", "fij", "fao", "fra", "fry", "gle", "gla", "glg", "grn", "guj", "glv", "hau", "heb", "hin", "hmo", "hrv", "hat", "hun", "hye", "her", "ina", "ind", "ile", "ibo", "iii", "ipk", "ido", "isl", "ita", "iku", "jpn", "jav", "kat", "kon", "kik", "kua", "kaz", "kal", "khm", "kan", "kor", "kau", "kas", "kur", "kom", "cor", "kir", "lat", "ltz", "lug", "lim", "lin", "lao", "lit", "lub", "lav", "mlg", "mah", "mri", "mkd", "mal", "mon", "mol", "mar", "msa", "mlt", "mya", "nau", "nob", "nde", "nep", "ndo", "nld", "nno", "nor", "nbl", "nav", "nya", "oci", "oji", "orm", "ori", "oss", "pan", "pli", "pol", "pus", "por", "que", "rcf", "roh", "run", "ron", "rus", "kin", "san", "srd", "snd", "sme", "sag", "hbs", "sin", "slk", "slv", "smo", "sna", "som", "sqi", "srp", "ssw", "sot", "sun", "swe", "swa", "tam", "tel", "tgk", "tha", "tir", "tuk", "tgl", "tsn", "ton", "tur", "tso", "tat", "twi", "tah", "uig", "ukr", "urd", "uzb", "ven", "vie", "vol", "wln", "wol", "xho", "yid", "yor", "zha", "zho", "zul" );
foreach ( $pv['ListeLangue'] as $A ) {
	$tab_conv_expr['UNI'][$A] = $pv['cpt'];
	$tab_conv_expr['M_SITWEB'][$A] = $tab_conv_expr['M_UTILIS'][$A]	= &$tab_conv_expr['UNI'][$A];
	$pv['cpt']++;
}
unset ( $A , $pv['ListeLangue'], $pv['liste_section']);

$tab_conv_expr['M_SITWEB']['base']			= 1;
$tab_conv_expr['M_SITWEB']['fichier']		= 2;
$tab_conv_expr['M_SITWEB']['database']		= &$tab_conv_expr['M_SITWEB']['base'];
$tab_conv_expr['M_SITWEB']['file']			= &$tab_conv_expr['M_SITWEB']['fichier'];

$tab_conv_expr['M_UTILIS']['publique']			= 2;
$tab_conv_expr['M_UTILIS']['prive']				= 1;
$tab_conv_expr['M_UTILIS']['privee']			= &$tab_conv_expr['M_UTILIS']['prive'];
$tab_conv_expr['M_UTILIS']['public']			= &$tab_conv_expr['M_UTILIS']['publique'];
$tab_conv_expr['M_UTILIS']['private']			= &$tab_conv_expr['M_UTILIS']['prive'];

$tab_conv_expr['M_ARTCFG']['table']			= 1;
$tab_conv_expr['M_ARTCFG']['menu_select']	= 2;
$tab_conv_expr['M_ARTCFG']['normal']		= 1;
$tab_conv_expr['M_ARTCFG']['float']			= 2;
$tab_conv_expr['M_ARTCFG']['none']			= 0;
$tab_conv_expr['M_ARTCFG']['left']			= 1;
$tab_conv_expr['M_ARTCFG']['right']			= 2;
$tab_conv_expr['M_ARTCFG']['no_menu']		= 0;
$tab_conv_expr['M_ARTCFG']['top']			= 1;
$tab_conv_expr['M_ARTCFG']['bottom']		= 2;
$tab_conv_expr['M_ARTCFG']['both']			= 3;
$tab_conv_expr['M_ARTCFG']['store']			= 4;
$tab_conv_expr['M_ARTCFG']['aucune']		= &$tab_conv_expr['M_ARTCFG']['none'];
$tab_conv_expr['M_ARTCFG']['gauche']		= &$tab_conv_expr['M_ARTCFG']['left'];
$tab_conv_expr['M_ARTCFG']['droite']		= &$tab_conv_expr['M_ARTCFG']['right'];
$tab_conv_expr['M_ARTCFG']['sans_menu']		= &$tab_conv_expr['M_ARTCFG']['no_menu'];
$tab_conv_expr['M_ARTCFG']['entete']		= &$tab_conv_expr['M_ARTCFG']['top'];
$tab_conv_expr['M_ARTCFG']['pied_de_page']	= &$tab_conv_expr['M_ARTCFG']['bottom'];
$tab_conv_expr['M_ARTCFG']['haut_et_bas']	= &$tab_conv_expr['M_ARTCFG']['both'];

$tab_conv_expr['M_ARTICL']['show_info_off']		= 0;
$tab_conv_expr['M_ARTICL']['show_info_on']		= 1;
$tab_conv_expr['M_ARTICL']['not_valid']			= 0;
$tab_conv_expr['M_ARTICL']['valid']				= 1;
$tab_conv_expr['M_ARTICL']['not_examined']		= 0;
$tab_conv_expr['M_ARTICL']['examined']			= 1;
$tab_conv_expr['M_ARTICL']['sans_info']			= &$tab_conv_expr['M_ARTICL']['show_info_off'];
$tab_conv_expr['M_ARTICL']['avec_info']			= &$tab_conv_expr['M_ARTICL']['show_info_on'];
$tab_conv_expr['M_ARTICL']['non_valide']		= &$tab_conv_expr['M_ARTICL']['not_valid'];
$tab_conv_expr['M_ARTICL']['valide']			= &$tab_conv_expr['M_ARTICL']['valid'];
$tab_conv_expr['M_ARTICL']['non_corrige']		= &$tab_conv_expr['M_ARTICL']['not_examined'];
$tab_conv_expr['M_ARTICL']['corrige']			= &$tab_conv_expr['M_ARTICL']['examined'];

$tab_conv_expr['M_CATEGO']['article_racine']		= 0;
$tab_conv_expr['M_CATEGO']['article']				= 1;
$tab_conv_expr['M_CATEGO']['menu_admin_racine']		= 2;
$tab_conv_expr['M_CATEGO']['menu_admin']			= 3;
$tab_conv_expr['M_CATEGO']['root_article']			= &$tab_conv_expr['M_CATEGO']['article_racine'];
$tab_conv_expr['M_CATEGO']['article']				= &$tab_conv_expr['M_CATEGO']['article'];
$tab_conv_expr['M_CATEGO']['root_admin_menu']		= &$tab_conv_expr['M_CATEGO']['menu_admin_racine'];
$tab_conv_expr['M_CATEGO']['admin_menu']			= &$tab_conv_expr['M_CATEGO']['menu_admin'];
$tab_conv_expr['M_CATEGO']['correction_article']	= 1;
$tab_conv_expr['M_CATEGO']['article_examination']	= &$tab_conv_expr['M_CATEGO']['correction_article'];
$tab_conv_expr['M_CATEGO']['admin_conf_extension']		= 2;

$tab_conv_expr['M_DOCUME']['mwmcode']			= 0;
$tab_conv_expr['M_DOCUME']['wmcode']			= 0;
$tab_conv_expr['M_DOCUME']['nocode']			= 1;
$tab_conv_expr['M_DOCUME']['php']				= 2;
$tab_conv_expr['M_DOCUME']['mixed']				= 3;
$tab_conv_expr['M_DOCUME']['codemwm']			= &$tab_conv_expr['M_DOCUME']['mwmcode'];
$tab_conv_expr['M_DOCUME']['sanscode']			= &$tab_conv_expr['M_DOCUME']['nocode'];
$tab_conv_expr['M_DOCUME']['mixe']				= &$tab_conv_expr['M_DOCUME']['mixed'];

$tab_conv_expr['M_DECORA']['top-left']			= 0;
$tab_conv_expr['M_DECORA']['bottom-left']		= 1;
$tab_conv_expr['M_DECORA']['center-left']		= 2;
$tab_conv_expr['M_DECORA']['top-right']			= 4;
$tab_conv_expr['M_DECORA']['bottom-right']		= 5;
$tab_conv_expr['M_DECORA']['center-right']		= 6;
$tab_conv_expr['M_DECORA']['top-center']		= 8;
$tab_conv_expr['M_DECORA']['bottom-center']		= 9;
$tab_conv_expr['M_DECORA']['center-center']		= 10;
$tab_conv_expr['M_DECORA']['haut-gauche']		= &$tab_conv_expr['M_DECORA']['top-left'];
$tab_conv_expr['M_DECORA']['bas-gauche']		= &$tab_conv_expr['M_DECORA']['bottom-left'];
$tab_conv_expr['M_DECORA']['centre-gauche']		= &$tab_conv_expr['M_DECORA']['center-left'];
$tab_conv_expr['M_DECORA']['haut-droite']		= &$tab_conv_expr['M_DECORA']['top-right'];
$tab_conv_expr['M_DECORA']['bas-droite']		= &$tab_conv_expr['M_DECORA']['bottom-right'];
$tab_conv_expr['M_DECORA']['centre-droite']		= &$tab_conv_expr['M_DECORA']['center-right'];
$tab_conv_expr['M_DECORA']['haut-centre']		= &$tab_conv_expr['M_DECORA']['top-center'];
$tab_conv_expr['M_DECORA']['bas-centre']		= &$tab_conv_expr['M_DECORA']['bottom-center'];
$tab_conv_expr['M_DECORA']['centre-centre']		= &$tab_conv_expr['M_DECORA']['center-center'];
$tab_conv_expr['M_DECORA']['bottom-banner']		= 10;
$tab_conv_expr['M_DECORA']['menu']				= 10;
$tab_conv_expr['M_DECORA']['caligraph']			= 20;
$tab_conv_expr['M_DECORA']['1_div']				= 30;
$tab_conv_expr['M_DECORA']['elegance']			= 40;
$tab_conv_expr['M_DECORA']['exquise']			= 50;
$tab_conv_expr['M_DECORA']['elysion']			= 60;
$tab_conv_expr['M_DECORA']['exquisite']			= &$tab_conv_expr['M_DECORA']['exquise'];
$tab_conv_expr['M_DECORA']['caligraphe']		= &$tab_conv_expr['M_DECORA']['caligraph'];

$tab_conv_expr['M_GROUPE']['anonyme']			= 0;
$tab_conv_expr['M_GROUPE']['lecteur']			= 1;
$tab_conv_expr['M_GROUPE']['staff']				= 2;
$tab_conv_expr['M_GROUPE']['senior_staff']		= 3;
$tab_conv_expr['M_GROUPE']['anonymous']			= &$tab_conv_expr['M_GROUPE']['anonyme'];
$tab_conv_expr['M_GROUPE']['reader']			= &$tab_conv_expr['M_GROUPE']['lecteur'];
$tab_conv_expr['M_GROUPE']['staff_senior']		= &$tab_conv_expr['M_GROUPE']['senior_staff'];

$tab_conv_expr['M_MODULE']['before']			= 1;
$tab_conv_expr['M_MODULE']['after']				= 2;
$tab_conv_expr['M_MODULE']['during']			= 0;
$tab_conv_expr['M_MODULE']['avant']				= &$tab_conv_expr['M_MODULE']['before'];
$tab_conv_expr['M_MODULE']['apres']				= &$tab_conv_expr['M_MODULE']['after'];
$tab_conv_expr['M_MODULE']['pendant']			= &$tab_conv_expr['M_MODULE']['during'];

$tab_conv_expr['M_MOTCLE']['vers_categorie']		= 1;
$tab_conv_expr['M_MOTCLE']['vers_url']				= 2;
$tab_conv_expr['M_MOTCLE']['vers_aide_dynamique']	= 3;
$tab_conv_expr['M_MOTCLE']['to_category']			= &$tab_conv_expr['M_MOTCLE']['vers_categorie'];
$tab_conv_expr['M_MOTCLE']['to_url']				= &$tab_conv_expr['M_MOTCLE']['vers_url'];
$tab_conv_expr['M_MOTCLE']['to_tooltip'] 			= &$tab_conv_expr['M_MOTCLE']['vers_aide_dynamique'];

$tab_conv_expr['M_PRESNT']['top']				= 1;
$tab_conv_expr['M_PRESNT']['bottom']			= 2;
$tab_conv_expr['M_PRESNT']['left']				= 1;
$tab_conv_expr['M_PRESNT']['right']				= 2;
$tab_conv_expr['M_PRESNT']['null']				= 0;
$tab_conv_expr['M_PRESNT']['haut']				= &$tab_conv_expr['M_PRESNT']['top'];
$tab_conv_expr['M_PRESNT']['bas']				= &$tab_conv_expr['M_PRESNT']['bottom'];
$tab_conv_expr['M_PRESNT']['gauche']			= &$tab_conv_expr['M_PRESNT']['left'];
$tab_conv_expr['M_PRESNT']['droite']			= &$tab_conv_expr['M_PRESNT']['right'];

$tab_conv_expr['M_TAG']['top-left']			= 0;
$tab_conv_expr['M_TAG']['bottom-left']		= 1;
$tab_conv_expr['M_TAG']['center-left']		= 2;
$tab_conv_expr['M_TAG']['top-right']		= 4;
$tab_conv_expr['M_TAG']['bottom-right']		= 5;
$tab_conv_expr['M_TAG']['center-right']		= 6;
$tab_conv_expr['M_TAG']['top-center']		= 8;
$tab_conv_expr['M_TAG']['bottom-center']	= 9;
$tab_conv_expr['M_TAG']['center-center']	= 10;
$tab_conv_expr['M_TAG']['haut-gauche']		= &$tab_conv_expr['M_TAG']['top-left'];
$tab_conv_expr['M_TAG']['bas-gauche']		= &$tab_conv_expr['M_TAG']['bottom-left'];
$tab_conv_expr['M_TAG']['centre-gauche']	= &$tab_conv_expr['M_TAG']['center-left'];
$tab_conv_expr['M_TAG']['haut-droite']		= &$tab_conv_expr['M_TAG']['top-right'];
$tab_conv_expr['M_TAG']['bas-droite']		= &$tab_conv_expr['M_TAG']['bottom-right'];
$tab_conv_expr['M_TAG']['centre-droite']	= &$tab_conv_expr['M_TAG']['center-right'];
$tab_conv_expr['M_TAG']['haut-centre']		= &$tab_conv_expr['M_TAG']['top-center'];
$tab_conv_expr['M_TAG']['bas-centre']		= &$tab_conv_expr['M_TAG']['bottom-center'];
$tab_conv_expr['M_TAG']['centre-centre']	= &$tab_conv_expr['M_TAG']['center-center'];

$tab_conv_expr['M_THEME']['top-left']			= 0;
$tab_conv_expr['M_THEME']['bottom-left']		= 1;
$tab_conv_expr['M_THEME']['center-left']		= 2;
$tab_conv_expr['M_THEME']['top-right']			= 4;
$tab_conv_expr['M_THEME']['bottom-right']		= 5;
$tab_conv_expr['M_THEME']['center-right']		= 6;
$tab_conv_expr['M_THEME']['top-center']			= 8;
$tab_conv_expr['M_THEME']['bottom-center']		= 9;
$tab_conv_expr['M_THEME']['center-center']		= 10;
$tab_conv_expr['M_THEME']['haut-gauche']		= &$tab_conv_expr['M_THEME']['top-left'];
$tab_conv_expr['M_THEME']['bas-gauche']			= &$tab_conv_expr['M_THEME']['bottom-left'];
$tab_conv_expr['M_THEME']['centre-gauche']		= &$tab_conv_expr['M_THEME']['center-left'];
$tab_conv_expr['M_THEME']['haut-droite']		= &$tab_conv_expr['M_THEME']['top-right'];
$tab_conv_expr['M_THEME']['bas-droite']			= &$tab_conv_expr['M_THEME']['bottom-right'];
$tab_conv_expr['M_THEME']['centre-droite']		= &$tab_conv_expr['M_THEME']['center-right'];
$tab_conv_expr['M_THEME']['haut-centre']		= &$tab_conv_expr['M_THEME']['top-center'];
$tab_conv_expr['M_THEME']['bas-centre']			= &$tab_conv_expr['M_THEME']['bottom-center'];
$tab_conv_expr['M_THEME']['centre-centre']		= &$tab_conv_expr['M_THEME']['center-center'];

?>
