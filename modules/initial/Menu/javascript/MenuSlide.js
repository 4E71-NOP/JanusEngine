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
		this.themeName = data.theme_name;
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
	makeMenu(){
		let ObjPtr = this.currentPosition;		
		let str="<ul style='padding:0px 0px 0px 0.25cm'>";
		if ( this.level > 1) {
			str += "<li class='"+this.themeName+"menu_lvl_0_link' style='padding:0.05cm'><span onClick='ms.slideBack()'><-</span></li>";
		}
		for (let n in ObjPtr) {
			if (ObjPtr[n].children) {
				str += "<li class='"+this.themeName+"menu_lvl_0_link' style='padding:0.05cm'><span onClick='ms.slideDeeper("+ObjPtr[n].cate_id+")'>*"+ObjPtr[n].cate_title+"</span></li>";
			}
			else {
				str += "<li class='"+this.themeName+"menu_lvl_0_link' style='padding:0.05cm'><a href='/"+ObjPtr[n].fk_arti_slug+"'>"+ObjPtr[n].cate_title+"</a></li>";
			}
		}
		str+="</ul>";
		this.md[this.level].innerHTML = str;
	}

	slideBack(){
		let ObjPtr = this.currentPosition;
		this.currentPosition = ObjPtr.parentNode;
		this.level--;

	}

	slideDeeper(id){
		this.level++;
		let ObjPtr = this.currentPosition;
		let menuFound=false;
		let NextPtr=null;
		for (let n in ObjPtr) {
			if (ObjPtr[n].cate_id == id ) { NextPtr = ObjPtr[n].children;}
			menuFound=true;
		}
		if (menuFound==true){
			this.currentPosition = NextPtr;
			this.makeMenu();
			this.md[this.level].classList.toggle('slideLeftExit')
			this.md[(this.level+1)].classList.toggle('slideLeftEnter')
			
		}
		else { l.Log[dbgMenu]("Menu not found!") }
	}
}






