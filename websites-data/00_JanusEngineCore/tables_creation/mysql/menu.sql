/* ---------------------------------------- */
/* Foreign keys: ws_id, deadline_id		*/
/* ---------------------------------------- */
/*
menu_type		ARTICLE_RACINE 0	ARTICLE 1	MENU_ADMIN_RACINE 2		MENU_ADMIN 3
lang_id			FRA 1	ENG 2		ESP 3
menu_state 		OFFLINE 0	ONLINE 1	SUPPRIME 2
menu_role		None 0	
*/

CREATE TABLE !table! (
menu_id 				BIGINT NOT NULL UNIQUE, 
menu_name 				VARCHAR(255),
menu_title 				VARCHAR(255),
menu_desc 				VARCHAR(255),
menu_type				INTEGER,
menu_visibility			INTEGER,
fk_ws_id				BIGINT,
fk_lang_id				BIGINT,
fk_deadline_id 			BIGINT,
menu_state 				INTEGER,
menu_parent 			BIGINT,
menu_position 			INTEGER,
fk_perm_id 				BIGINT,
menu_last_update		INTEGER,
menu_role 				INTEGER,
menu_initial_document	BIGINT,
fk_arti_slug			VARCHAR(255),
fk_arti_ref 			VARCHAR(255),


PRIMARY KEY (menu_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_deadline_id (fk_deadline_id),
KEY idx_!IdxNom!_group_id (fk_perm_id),
KEY idx_!IdxNom!_menu_initial_document (menu_initial_document)

);
