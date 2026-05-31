<?php
 // // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end



$dbquery = requete_sql($_REQUEST['sql_initiateur'], "SELECT * FROM ".$SQL_tab_abrege['tl_fra']." WHERE document_nom ='doc_uni_execution_de_scripts_p01.php';" );
while ($dbp = fetch_array_sql($dbquery)) { $tl_[$dbp['lang_id']][$dbp['tl_nom']] = $dbp['tl_contenu']; }

echo ( print_r_html ( $tl_['48'] ) );

echo ( "<br><br>" );
echo ( $tl_['48']['invite1'] . "<br><br>" );
echo ( $tl_['48']['bouton_exec'] . "<br><br>" );
echo ( $tl_['48']['tf1'] . "<br><br>" );

?>

