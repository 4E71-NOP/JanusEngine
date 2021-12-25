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
	 * Init
	 * @param {*} data 
	 * @param {*} menuDivName 
	 */
	initialization (data, menuDivName) {
		this.EntryPoint = data.EntryPoint;
		this.data = data.Payload;
		elm.Gebi('menuTitle').innerHTML = this.data[this.EntryPoint].cate_title;

		this.currentMenu = this.EntryPoint;
		this.themeName = data.theme_name;
		this.block = data.block;
		this.level = 1;
		
		for (let n=1; n<=10; n++ ) { this.md[n] = elm.Gebi(menuDivName+n); }
		elm.Gebi('menuSlide').parentNode.style.overflow='hidden';
	}

	/**
	 * Stuff the nex div with the menu children tha has been clicked on
	 * @param {*} id 
	 */
	makeMenu(){
		let c = this.data[this.currentMenu];
		l.Log[dbgMenu]("makeMenu on: '"+c.cate_title+"' ("+c.cate_id+ "); slug:'"+ c.fk_arti_slug+"'");

		let str="<ul style='padding:0px 0px 0px 0.25cm'>";
		if ( this.level > 1) {
			str += "<li class='"+this.themeName+"menu_lvl_0_link' style='padding:0.05cm' onClick='ms.slideBack()'><div class='"+this.themeName+this.block+"_icon_left' style='width:24px;height:24px;'></li>";
		}
		let d = this.data;
		for ( let n in d ){
			if ( d[n].cate_parent == this.currentMenu ) {
				if ( this.checkChildren(d[n].cate_id) === true) {
					str += "<li class='"+this.themeName+"menu_lvl_0_link' style='padding:0.05cm' onClick=\"ms.slideDeeper('"+d[n].cate_id+"')\">*"+d[n].cate_title+"</li>";
				}
				else {
					str += "<li class='"+this.themeName+"menu_lvl_0_link' style='padding:0.05cm'><a href='/"+d[n].fk_arti_slug+"'>"+d[n].cate_title+"</a></li>";
				}
			}
		}
		str+="</ul>";
		this.md[this.level].innerHTML = str;
	}
	
	/**
	 * Check for children of the entry in menu data
	 * @param {*} id 
	 * @returns 
	 */
	checkChildren(id){
		let d = this.data;
		for ( let n in d ){ 
			if ( d[n].cate_parent == id ) { return true; }
		}
		return false;
	}

	/**
	 * Finds the first children of a menu
	 * @param {*} id 
	 * @returns 
	 */
	findChildren (id){
		let d = this.data;
		for ( let n in d ){ 
			if ( d[n].cate_parent == id ) { return d[n].cate_id; }
		}
		return false;
	}

	/**
	 * 
	 */
	slideBack(){
		if (this.level > 1) {
			this.currentMenu = this.data[this.currentMenu].cate_parent;
			this.md[(this.level-1)].classList.remove('slideLeftExit');
			this.md[(this.level-1)].classList.toggle('moveIn');

			this.md[(this.level)].classList.remove('moveIn');
			this.md[(this.level)].classList.toggle('slideRightExit');
			this.level--;
		}
	}

	/**
	 * 
	 * @param {*} id 
	 */
	slideDeeper(id){
		this.level++;
		this.currentMenu = id;
		this.makeMenu();
		this.md[(this.level-1)].classList.remove('moveIn');
		this.md[(this.level-1)].classList.toggle('slideLeftExit');
		this.md[(this.level)].classList.remove('slideRightExit');
		this.md[(this.level)].classList.toggle('moveIn');
	}

}

