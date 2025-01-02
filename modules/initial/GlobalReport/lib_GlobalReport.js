/*jshint globals: true*/
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
class GlobalReport {
	constructor() {
		this.dbgGr = 0;
	}

	switchDisplay(divBG, divGR, Tabs) {
		divBG = elm.Gebi(divBG);
		divGR = elm.Gebi(divGR);
		if (divBG.style.visibility == 'hidden') {
			divBG.style.display = 'block';
			divGR.style.display = 'block';

			dm.UpdateAllDecoModule(TabInfoModule);
			tm.TabsResize(Tabs);
			
			divGR.style.left = Math.floor((window.innerWidth - divGR.clientWidth) / 2) + "px";
			divGR.style.top = Math.floor(((window.innerHeight - divGR.clientHeight) / 2) + window.scrollY) + "px";

			let bodySizes = document.body.getBoundingClientRect();
			divBG.style.height = Math.ceil(bodySizes.bottom + 32) + 'px';

			l.Log[this.dbgGr](document.body.getBoundingClientRect());

			divBG.style.visibility = 'visible';
			divGR.style.visibility = 'visible';
		}
		else {
			divBG.style.visibility = 'hidden';
			divGR.style.visibility = 'hidden';
			divBG.style.display = 'none';
			divGR.style.display = 'none';
		}
	}

	getContentWidth(elm) {
		var cs = getComputedStyle(elm);
		return (elm.clientWidth - parseFloat(cs.paddingLeft) - parseFloat(cs.paddingRight));
	}
	getContentHeight(elm) {
		var cs = getComputedStyle(elm);
		return (elm.clientHeight - parseFloat(cs.paddingTop) - parseFloat(cs.paddingBottom));
	}


}