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
//module_deco 		OFF:0		ON:1
//module_etat			OFFLINE:0	ONLINE:1	SUPPRIME:2
//module_adm_control	NO 0	YES 1

$_REQUEST['liste_colonne']['module'] = array (
"module_id",
"module_deco",
"module_deco_nbr",
"module_deco_txt_defaut",
"module_nom",
"module_titre",
"module_fichier",
"module_desc",
"module_conteneur_nom",
"module_groupe_pour_voir",
"module_groupe_pour_utiliser",
"module_adm_control",
"module_execution"
);

$_REQUEST['liste_colonne']['module_conversion'] = array (
"module_deco",
"module_etat",
"module_adm_control",
"module_execution",
);

$_REQUEST['liste_colonne']['module_reference'] = array (
"id",
"deco",
"deco_nbr",
"deco_txt_defaut",
"nom",
"titre",
"fichier",
"desc",
"conteneur_nom",
"groupe_pour_voir",
"groupe_pour_utiliser",
"etat",
"adm_control",
"execution",
"position"
);

function initialisation_valeurs_module () {
	$R = &$_REQUEST['M_MODULE'];

	$R['id']					= "";
	$R['deco']					= "ON";
	$R['deco_nbr']				= "1";
	$R['deco_txt_defaut']		= "3";
	$R['nom']					= "Nouveau module";
	$R['titre']					= "Nouveau module";
	$R['fichier']				= "NA";
	$R['desc']					= "Nouveau module";
	$R['groupe_pour_voir']		= 1;
	$R['groupe_pour_utiliser']	= 1;
	$R['etat']					= "ONLINE";
	$R['position']				= 1;
	$R['adm_control']			= "NO";
	$R['conteneur_nom']			= "";
	$R['execution']				= "DURING";
	$R['filtre']				= "";

	$R['name']					= &$R['nom'];
	$R['title']					= &$R['titre'];
	$R['file']					= &$R['fichier'];
	$R['group_who_can_see']		= &$R['groupe_pour_voir'];
	$R['group_who_can_use']		= &$R['groupe_pour_utiliser'];
	$R['state']					= &$R['etat'];
	$R['container_name']		= &$R['conteneur_nom'];
	$R['filter']				= &$R['filtre'];

	reset ( $_REQUEST['liste_colonne']['module_reference'] );
	foreach ( $_REQUEST['liste_colonne']['module_reference'] as $A ) { $R['module_'.$A] = &$R[$A];	}
}

function chargement_valeurs_module () {
	global $SQL_tab , $SQL_tab_abrege, $tab_conv_expr;
	$R = &$_REQUEST['M_MODULE'];

	$tl_['eng']['log_init'] = "Loading module datas";
	$tl_['fra']['log_init'] = "Chargement valeurs du module";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT grp.groupe_id,grp.groupe_nom
	FROM ".$SQL_tab_abrege['groupe']." grp , ".$SQL_tab_abrege['site_groupe']." sg  
	WHERE grp.groupe_id = sg.groupe_id
	AND sg.site_id = '".$_REQUEST['site_context']['site_id']."' 
	;"); 
	while ($dbp = fetch_array_sql($dbquery)) {
		$tab_info_groupe[$dbp['groupe_id']]['id'] = $dbp['groupe_id'];  
		$tab_info_groupe[$dbp['groupe_id']]['nom'] = $dbp['groupe_id'];  
	}

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['module']." a , ".$SQL_tab_abrege['site_module']." b 
	WHERE a.module_nom = '".$R['nom']."' 
	AND a.module_id = b.module_id 
	AND b.site_id = '".$_REQUEST['site_context']['site_id']."'	 
	;");
	if ( num_row_sql($dbquery) == 0 ) {
		$tl_['eng']['err_001'] = "The module named '".$R['nom']."' doesn't exists.";
		$tl_['fra']['err_001'] = "Le module '".$R['nom']."' n'existe pas.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CVM_001" ,$tl_[$l]['err_001'] ); 
	}
	else {
		$p = $tab_conv_expr['M_MODULE']['before'];		$tab_ex[$p] = "before";
		$p = $tab_conv_expr['M_MODULE']['after'];		$tab_ex[$p] = "after";
		$p = $tab_conv_expr['M_MODULE']['during'];		$tab_ex[$p] = "during";
		$p = $tab_conv_expr['M_MODULE']['no'];			$tab_yn[$p] = "no";
		$p = $tab_conv_expr['M_MODULE']['yes'];			$tab_yn[$p] = "yes";
		$p = $tab_conv_expr['M_MODULE']['offline'];		$tab_etat[$p] = "offline";
		$p = $tab_conv_expr['M_MODULE']['online'];		$tab_etat[$p] = "online";
		$p = $tab_conv_expr['M_MODULE']['deleted'];		$tab_etat[$p] = "deleted";
		$p = $tab_conv_expr['M_MODULE']['off'];			$tab_oo[$p] = "off";
		$p = $tab_conv_expr['M_MODULE']['on'];			$tab_oo[$p] = "on";

		while ($dbp = fetch_array_sql($dbquery)) { 
			$R['id']					= $dbp['module_id'];
			$R['deco']					= $tab_oo[$dbp['module_deco']];
			$R['deco_nbr']				= $dbp['module_deco_nbr'];
			$R['deco_txt_defaut']		= $dbp['module_deco_txt_defaut'];
			$R['nom']					= $dbp['module_nom'];
			$R['titre']					= $dbp['module_titre'];
			$R['fichier']				= $dbp['module_fichier'];
			$R['desc']					= $dbp['module_desc'];
			$R['conteneur_nom']			= $dbp['module_conteneur_nom'];
			$R['groupe_pour_voir']		= $tab_info_groupe[$dbp['module_groupe_pour_voir']]['nom'];
			$R['groupe_pour_utiliser']	= $tab_info_groupe[$dbp['module_groupe_pour_utiliser']]['nom'];
			$R['etat']					= $tab_etat[$dbp['module_etat']];
			$R['position']				= $dbp['module_position'];
			$R['adm_control']			= $tab_yn[$dbp['module_adm_control']];
			$R['execution']				= $tab_ex[$dbp['module_execution']];
		}
	}
}
?>
