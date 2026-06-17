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

var TabProcessusRegExpRep = {
	"rn":			{	"n":"1",	"s":"\r\n",	"d":""		},
	"n"	:			{	"n":"1",	"s":"\n",	"d":""		},
	"tt":			{	"n":"20",	"s":"\t\t",	"d":"\t"	},
	"tvirgule":		{	"n":"1",	"s":"\t;",	"d":";"		},
	"t"	:			{	"n":"1",	"s":"\t",	"d":" "		},
	"nvirgule":		{	"n":"1",	"s":";",	"d":";\n"	},
	"spcspc":		{	"n":"20",	"s":"  ",	"d":" "		},
	"nspc":			{	"n":"1",	"s":"\n ",	"d":"\n"	},
	"spcvirgule":	{	"n":"1",	"s":" ;",	"d":";"		}
};

function formatJnsEngScript ( Form , src , dst ) {
	var strSrc = document.forms[Form].elements[src].value;
	var strDst = "";

	for ( let ptr in TabProcessusRegExpRep ) {
		for ( let Nfois = 1 ; Nfois <= TabProcessusRegExpRep[ptr].n ; Nfois++ ) {
			strSrc = strSrc.replace( RegExp (TabProcessusRegExpRep[ptr].s, "g") , TabProcessusRegExpRep[ptr].d );
		}
	}
	strDst = String(strSrc);
	document.forms[Form].elements[dst].value = 	strDst;
}
