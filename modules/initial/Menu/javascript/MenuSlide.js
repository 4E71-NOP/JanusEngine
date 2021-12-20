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
var dbgMenu = 1;

class MenuSlide {

	md={};

	/**
	 * 
	 * @param {*} data 
	 * @param {*} menuDivName 
	 */
	initialization (data, menuDivName) {
		this.EntryPoint = data.EntryPoint;
		this.currentPosition = data[this.EntryPoint].children;

		for (let n=1; n<=10; n++ ) {
			this.md[n] = elm.Gebi(menuDivName+n);
		}
		this.level = 1;
		elm.Gebi('menuTitle').innerHTML = '<b>' + data[this.EntryPoint].cate_title + '</b>';
	}

	/**
	 * Id is the menu clicked cate_id
	 * @param {*} id 
	 */
	PrepareMenuBeforeAnimation(){
		let ObjPtr = this.currentPosition;		
		let str="<ul>";
		for (let n in ObjPtr) {
			str += "<li><a href='/"+ObjPtr[n].fk_arti_slug+"'>"+ObjPtr[n].cate_title+"</a></li>";
		}
		str+="</ul>";
		this.md[this.level].innerHTML = str;
	}
}






