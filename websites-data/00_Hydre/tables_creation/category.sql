/* ---------------------------------------- */
/* Foreign keys: ws_id, deadline_id		*/
/* ---------------------------------------- */
/*
cate_type		ARTICLE_RACINE 0	ARTICLE 1	MENU_ADMIN_RACINE 2		MENU_ADMIN 3
cate_lang		FRA 1	ENG 2		ESP 3
cate_state 		OFFLINE 0	ONLINE 1	SUPPRIME 2
cate_role		None 0	
*/

CREATE TABLE !table! (
cate_id 			INTEGER NOT NULL,
cate_name 			VARCHAR(255),
cate_title 			VARCHAR(255),
cate_desc 			VARCHAR(255),
cate_type			INTEGER,
ws_id				INTEGER,
cate_lang			INTEGER,
deadline_id 		INTEGER,
cate_state 			INTEGER,
cate_parent 		INTEGER,
cate_position 		INTEGER,
group_id 			INTEGER,
cate_last_update		INTEGER,
cate_role 			INTEGER,
cate_initial_document	INTEGER,
arti_ref 			VARCHAR(255),

PRIMARY KEY (cate_id),
KEY idx_!IdxNom!_ws_id (ws_id),
KEY idx_!IdxNom!_deadline_id (deadline_id),
KEY idx_!IdxNom!_group_id (group_id),
KEY idx_!IdxNom!_cate_initial_document (cate_initial_document)

);
