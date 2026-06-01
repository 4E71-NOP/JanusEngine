// @JanusEngine:license-start
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

// Decorations management

function ManiPresTypCal ( MenuSelect , Ligne ) {
	var MsObj = elm.Gebi( MenuSelect );
	if ( MsObj.options[MsObj.selectedIndex].value == 'STATIC' ) {
		elm.Gebi( 'TabCalStatic_' + Ligne ).style.visibility = 'visible';
		elm.Gebi( 'TabCalStatic_' + Ligne ).style.display = 'block';
		elm.Gebi( 'TabCalDynamic_' + Ligne ).style.visibility = 'hidden';
		elm.Gebi( 'TabCalDynamic_' + Ligne ).style.display = 'none';
	}
	else {
		elm.Gebi( 'TabCalStatic_' + Ligne ).style.visibility = 'hidden';
		elm.Gebi( 'TabCalStatic_' + Ligne ).style.display = 'none';
		elm.Gebi( 'TabCalDynamic_' + Ligne ).style.visibility = 'visible';
		elm.Gebi( 'TabCalDynamic_' + Ligne ).style.display = 'block';
	}
}

