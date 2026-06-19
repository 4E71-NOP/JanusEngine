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

			// clean up 20260523
			// Height 100% is enough
			// let bodySizes = document.body.getBoundingClientRect();
			// divBG.style.height = Math.ceil(bodySizes.bottom + 32) + 'px';

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