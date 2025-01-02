<?php
 /*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

$dbquery = requete_sql($_REQUEST['sql_initiateur'], "SELECT * FROM ".$SQL_tab_abrege['tl_fra']." WHERE document_nom ='doc_uni_execution_de_scripts_p01.php';" );
while ($dbp = fetch_array_sql($dbquery)) { $tl_[$dbp['lang_id']][$dbp['tl_nom']] = $dbp['tl_contenu']; }

echo ( print_r_html ( $tl_['48'] ) );

echo ( "<br><br>" );
echo ( $tl_['48']['invite1'] . "<br><br>" );
echo ( $tl_['48']['bouton_exec'] . "<br><br>" );
echo ( $tl_['48']['tf1'] . "<br><br>" );

?>

