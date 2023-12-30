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
var dbgMenu = 0;

class MenuSlide {

	md={};
	data={};
	EntryPoint=0;
	menu_id=0;
	currentMenu=0;
	maxMenuLevel=10
	level=1;
	tmpLevel=1;


	/**
	 * Init
	 * @param {*} data 
	 * @param {*} menuDivName 
	 */
	initialization (data, menuDivName) {
		this.EntryPoint = data.EntryPoint;
		this.data = data.Payload;

		this.currentMenu = this.EntryPoint;
		this.themeName = data.theme_name;
		this.menu_id = data.menu_id;
		this.block = data.block;
		this.level = 1;
		l.Log[dbgMenu]("MenuSlide.initialization / currentMenu:'"+this.currentMenu+"', menu_id:'"+this.menu_id+"', themeName:'"+this.themeName+"', block:'"+this.block+"'");
		
		for (let n=1; n<=this.maxMenuLevel; n++) { this.md[n] = elm.Gebi(menuDivName+n); }
		elm.Gebi('menuSlide').parentNode.style.overflow='hidden';
		
		// Sets the menu level/branch on the article at hand
		if ( this.locateMenuId(this.EntryPoint) == true ) {
			if ( this.level > 1 ) {	
				this.level--;		// We know level will get +1;
				this.slideDeeper(this.currentMenu); 
			}
			l.Log[dbgMenu]("MenuSlide.initialization / currentMenu:'"+this.currentMenu+"', menu_id:'"+this.menu_id+"', tmpLevel:'"+this.tmpLevel+"'");
		}
		for (let n=1; n<=this.maxMenuLevel; n++) { this.md[n].style.visibility = "visible"; }
	}

	/**
	 * Locate the menu_id in the menu tree 
	 * @param {*} id 
	 */
	locateMenuId (id) {
		l.Log[dbgMenu]("MenuSlide.locateMenuId / currentMenu:'"+this.currentMenu+"', menu_id:'"+this.menu_id+"', tmpLevel:'"+this.tmpLevel+"'");

		let d = this.data;
		for (let n in d ) {
			if ( d[n].menu_parent == id ) {
				if ( this.checkChildren(d[n].menu_id) === true ) {
					this.tmpLevel++;
					if ( this.locateMenuId(d[n].menu_id) === true ) { return true; }
					this.tmpLevel--;
				}
				if ( d[n].menu_id == this.menu_id) { 
					this.currentMenu = d[n].menu_parent;
					this.level = this.tmpLevel;
					l.Log[dbgMenu]("MenuSlide.locateMenuId Got it! id:'"+id+"'= menu_id:'"+this.menu_id+"', tmpLevel:'"+this.tmpLevel+"', level:'"+this.level+"'");
					return true;
				}
			}
		}
		return false
	}


	/**
	 * Stuff the a div with the menu children that has been clicked on
	 */
	makeMenu(){
		let c = this.data[this.currentMenu];
		l.Log[dbgMenu]("MenuSlide.makeMenu on: '"+c.menu_title+"' ("+c.menu_id+ "); slug:'"+ c.fk_arti_slug+"', level:'"+this.level+"'");
		elm.Gebi('menuTitle').innerHTML = this.data[this.currentMenu].menu_title;

		let str="<ul style='padding:0px 0px 0px 0.25cm'>";
		if ( this.level > 1) {
			str += "<li class='"
				+this.themeName
				+"menu_lvl_0_link' style='padding:0.05cm' onClick='ms.slideBack()'><div class='"
				+this.themeName+this.block
				+"_icon_left' style='width:16px;height:16px;'></div></li>";
		}
		let d = this.data;
		for ( let n in d ){
			if ( d[n].menu_parent == this.currentMenu ) {
				if ( this.checkChildren(d[n].menu_id) === true) {
					str += "<li class='"
						+this.themeName
						+"menu_lvl_0_link' style='padding:0.05cm' onClick=\"ms.slideDeeper('"
						+d[n].menu_id+"')\"><div class='"
						+this.themeName
						+this.block
						+"_icon_directory' style='width:16px;height:16px; display:inline-block'></div>"
						+d[n].menu_title+"</li>";
				}
				else {
					if ( d[n].menu_id == this.menu_id ) {
						str += "<li class='"
							+this.themeName
							+"menu_lvl_0_link' style='padding:0.05cm'>"
							+d[n].menu_title
							+"</li>";
					}
					else {
						str += "<li class='"
							+this.themeName
							+"menu_lvl_0_link' style='padding:0.05cm'><a href='/"
							+d[n].fk_arti_slug
							+"' style='display :block;'>"
							+d[n].menu_title+"</a></li>";
					}
				}
			}
		}
		str+="</ul>";
		this.md[this.level].innerHTML = str;
	}
	
	/**
	 * Checks for children of the entry in menu data
	 * @param {*} id 
	 * @returns boolean
	 */
	checkChildren(id){
		let d = this.data;
		for ( let n in d ){ 
			if ( d[n].menu_parent == id ) { return true; }
		}
		return false;
	}

	/**
	 * Finds the first children of a menu
	 * @param {*} id 
	 * @returns [string|boolean]
	 */
	findChildren (id){
		let d = this.data;
		for ( let n in d ){ 
			if ( d[n].menu_parent == id ) { return d[n].menu_id; }
		}
		return false;
	}

	/**
	 * Gets back one level
	 */
	slideBack(){
		if (this.level > 1) {
			l.Log[dbgMenu]("MenuSlide.slideBack level:'"+this.level+"'");
			this.currentMenu = this.data[this.currentMenu].menu_parent;
			this.level--;
			l.Log[dbgMenu]("MenuSlide.slideBack level:'"+this.level+"'");
			this.makeMenu();

			this.md[this.level].classList.remove('slideLeftExit');
			this.md[this.level].classList.toggle('moveIn');

			this.md[(this.level+1)].classList.remove('moveIn');
			this.md[(this.level+1)].classList.toggle('slideRightExit');
		}
	}

	/**
	 * Goes into the folder menu
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

