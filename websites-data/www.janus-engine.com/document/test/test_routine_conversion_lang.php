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

$pv['test']['fra'] = "fra";
$pv['test']['eng'] = "eng";

$_REQUEST['conv_expr_section'] = "MSW";
$pv['test']['fra'] = conversionExpression ( $pv['test']['fra'] );
$pv['test']['eng'] = conversionExpression ( $pv['test']['eng'] );

echo ( print_r_html ( $pv['test'] ) );
outil_debug ( $language , "\$language");

?>
