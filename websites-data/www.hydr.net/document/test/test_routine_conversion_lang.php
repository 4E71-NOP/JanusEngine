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

$pv['test']['fra'] = "fra";
$pv['test']['eng'] = "eng";

$_REQUEST['conv_expr_section'] = "MSW";
$pv['test']['fra'] = conversion_expression ( $pv['test']['fra'] );
$pv['test']['eng'] = conversion_expression ( $pv['test']['eng'] );

echo ( print_r_html ( $pv['test'] ) );
outil_debug ( $language , "\$language");

?>
