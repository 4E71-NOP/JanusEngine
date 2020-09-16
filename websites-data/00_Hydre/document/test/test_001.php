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


$_REQUEST[server_infos][srv_hostname]		= gethostbyname('localhost'); 
$_REQUEST[server_infos][include_path]		= get_include_path(); 
$_REQUEST[server_infos][repertoire_courant]	= getcwd(); 
$_REQUEST[server_infos][uid]				= getmyuid(); 
$_REQUEST[server_infos][gid]				= getmygid(); 
$_REQUEST[server_infos][pid]				= getmypid(); 
/* $_REQUEST[server_infos][navigateur]			= get_browser(null, true); */ 
$_REQUEST[server_infos][proprietaire]		= get_current_user(); 

echo print_r_debug ( $_REQUEST[server_infos] ) ;

/*

$tab_[0] = "o";	$tab_[1] = "un";	$tab_[3] = "trois";	$tab_[4] = "quatre";	

sleep(2);
statistique_debut ( "Test001" , "test001" , 1 , 1 , "test001" );
for ( $i=1 ; $i < 2000 ; $i++ ) {
	$dbquery = requete_sql($_REQUEST[sql_initiateur],"
	SELECT bcl.*,usr.user_login 
	FROM $SQL_tab_abrege[bouclage] bcl , $SQL_tab_abrege[user] usr 
	WHERE site_id = '$site_web[sw_id]' 
	AND usr.user_id = bcl.user_id
	;");
	while ($dbp = fetch_array_sql($dbquery)) {
		foreach ( $dbp as $A => $V ) { $_REQUEST[MD][$A] = $V; } 
		$_REQUEST[MD][bouclage_id] = $tab_[$dbp[bouclage_id]];
		$_REQUEST[MD][bouclage_etat]			= $tab_[$dbp[bouclage_etat]];
		$_REQUEST[MD][site_id]			= $tab_[$dbp[site_id]];
	}
}
statistique_fin ( "test001" );


sleep(2);
statistique_debut ( "Test002" , "test002" , 1 , 1 , "test002" );
for ( $i=1 ; $i < 2000 ; $i++ ) {
	$dbquery = requete_sql($_REQUEST[sql_initiateur],"
	SELECT bcl.*,usr.user_login 
	FROM $SQL_tab_abrege[bouclage] bcl , $SQL_tab_abrege[user] usr 
	WHERE site_id = '$site_web[sw_id]' 
	AND usr.user_id = bcl.user_id
	;");
	while ($dbp = fetch_array_sql($dbquery)) {
		$_REQUEST[MD][bouclage_id]			= $tab_[$dbp[bouclage_id]];
		$_REQUEST[MD][bouclage_nom]			= $dbp[bouclage_nom];
		$_REQUEST[MD][bouclage_titre]			= $dbp[bouclage_titre];
		$_REQUEST[MD][bouclage_etat]			= $tab_[$dbp[bouclage_etat]];
		$_REQUEST[MD][bouclage_date_creation]			= $dbp[bouclage_date_creation];
		$_REQUEST[MD][bouclage_date_limite]			= $dbp[bouclage_date_limite];
		$_REQUEST[MD][site_id]			= $tab_[$dbp[site_id]];
		$_REQUEST[MD][user_id]			= $dbp[user_id];
		$_REQUEST[MD][user_login] 			= $dbp[user_login];
	}
}
statistique_fin ( "test002" );

*/


echo print_r_html ( $_REQUEST[MD] ) ;

?>
