// --------------------------------------------------------------------------------------------
//
//	MWM - Multi Web Manager
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

var TabProcessusRegExp = {
};

function FormattageScriptMWM ( Form , src , dst ) {
	var ChaineSource = document.forms[Form].elements[src].value;
	var ChaineDst = "";

	for ( var ptr in TabProcessusRegExpRep ) {
		for ( var Nfois = 1 ; Nfois <= TabProcessusRegExpRep[ptr].n ; Nfois++ ) {
			ChaineSource = ChaineSource.replace( RegExp (TabProcessusRegExpRep[ptr].s, "g") , TabProcessusRegExpRep[ptr].d );
		}
	}
	ChaineDst = String(ChaineSource);
	document.forms[Form].elements[dst].value = 	ChaineDst;
}
