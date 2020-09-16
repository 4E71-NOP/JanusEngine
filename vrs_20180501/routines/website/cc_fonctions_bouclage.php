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
//bouclage_etat 				OFFLINE:0	ONLINE:1	SUPPRIME:2

$_REQUEST['liste_colonne']['bouclage'] = array (
"bouclage_id",
"bouclage_nom",
"bouclage_titre",
"bouclage_etat",
"bouclage_date_creation",
"bouclage_date_limite",
"site_id",
"user_id"
);


$_REQUEST['liste_colonne']['bouclage_reference'] = array (
"id",
"nom",
"titre",
"etat",
"date_creation",
"date_limite",
"site_id",
"user_id"
);

function initialisation_valeurs_bouclage () {
	$R = &$_REQUEST['M_BOUCLG'];

	$R['id']			= "";
	$R['nom']			= "Nouveau bouclage";
	$R['titre']			= "Nouveau titre";
	$R['etat']			= 0;				// OFFLINE
	$date = time ();
	$R['date_creation']	= $date; 
	$R['date_limite']	= $date + (60*60*24*31*12*10); //10ans
	$R['site_id']		= $_REQUEST['site_context']['site_id'];
	$R['user_id']		= "1";
	$R['filtre']		= "";

	$R['name']			= &$R['nom'];
	$R['title']			= &$R['titre'];
	$R['state']			= &$R['etat'];
	$R['creation_date']	= &$R['date_creation'];
	$R['limit']			= &$R['date_limite'];
	$R['filter']		= &$R['filtre'];

	reset ( $_REQUEST['liste_colonne']['bouclage_reference'] );
	foreach ( $_REQUEST['liste_colonne']['bouclage_reference'] as $A ) { $R['bouclage_'.$A] = &$R[$A];	}
}

function chargement_valeurs_bouclage () {
	global $SQL_tab , $SQL_tab_abrege, $tab_conv_expr;
	$R = &$_REQUEST['M_BOUCLG'];

	$tl_['eng']['log_init'] = "Loading deadline datas";
	$tl_['fra']['log_init'] = "Chargement valeurs du bouclage";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT bcl.*,usr.user_id 
	FROM ".$SQL_tab_abrege['bouclage']." bcl , ".$SQL_tab_abrege['user']." usr 
	WHERE site_id = '".$_REQUEST['site_context']['site_id']."' 
	AND usr.user_id = bcl.user_id 
	AND bouclage_nom ='".$R['nom']."' 
	;");

	if ( num_row_sql($dbquery) == 0 ) {
		$tl_['eng']['err_001'] = "The deadline named '".$_REQUEST['M_CATEGO']['nom']."' doesn't exists.";
		$tl_['fra']['err_001'] = "Le bouclage '".$_REQUEST['M_CATEGO']['nom']."' n'existe pas.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "CVC_001" ,$tl_[$l]['err_001'] ); 
	}
	else {
		$p = $tab_conv_expr['M_BOUCLG']['offline'];		$tab_etat[$p] = "offline";
		$p = $tab_conv_expr['M_BOUCLG']['online'];		$tab_etat[$p] = "online";
		$p = $tab_conv_expr['M_BOUCLG']['deleted'];		$tab_etat[$p] = "deleted";

		while ($dbp = fetch_array_sql($dbquery)) {
			$R['id']				= $dbp['bouclage_id'];
			$R['nom']				= $dbp['bouclage_nom'];
			$R['titre']				= $dbp['bouclage_titre'];
			$R['etat']				= $tab_etat[$dbp['cate_etat']];
			$R['date_creation']		= date ("Y-m-j G:i:s",$dbp['bouclage_date_creation']);
			$R['date_limite']		= date ("Y-m-j G:i:s" ,$dbp['bouclage_date_limite']);
			$R['user_id']			= $dbp['user_id'];
		}
	}
}

?>
