<?php
 // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see      : https://github.com/4E71-NOP/JanusEngine
//
// @license  : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author   : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note     : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//             without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


$pv['test']['fra'] = "fra";
$pv['test']['eng'] = "eng";

$_REQUEST['conv_expr_section'] = "MSW";
$pv['test']['fra'] = conversionExpression ( $pv['test']['fra'] );
$pv['test']['eng'] = conversionExpression ( $pv['test']['eng'] );

echo ( print_r_html ( $pv['test'] ) );
outil_debug ( $language , "\$language");

?>
