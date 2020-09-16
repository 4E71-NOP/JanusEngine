/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des catégories ( menu )																						*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/ 
/* site_id																															*/
/* bouclage_id																														*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/*
cate_type		ARTICLE_RACINE 0	ARTICLE 1	MENU_ADMIN_RACINE 2		MENU_ADMIN 3
cate_lang		FRA 1	ENG 2		ESP 3
cate_etat 		OFFLINE 0	ONLINE 1	SUPPRIME 2
cate_role		None 0	
*/

CREATE TABLE !table! (
cate_id 			INTEGER NOT NULL,
cate_nom 			VARCHAR(255),
cate_titre 			VARCHAR(255),
cate_desc 			VARCHAR(255),
cate_type			INTEGER,
site_id				INTEGER,
cate_lang			INTEGER,
bouclage_id 		INTEGER,
cate_etat 			INTEGER,
cate_parent 		INTEGER,
cate_position 		INTEGER,
groupe_id 			INTEGER,
derniere_modif		INTEGER,
cate_role 			INTEGER,
cate_doc_premier	INTEGER,
arti_ref 			VARCHAR(255),
PRIMARY KEY (cate_id)
);
