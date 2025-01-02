// --------------------------------------------------------------------------------------------
//
//	JnsEng - Janus Engine
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.com
//
// --------------------------------------------------------------------------------------------

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
