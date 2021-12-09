/* ---------------------------------------- */
/* Foreign keys: theme_id, layout_id			*/
/* ---------------------------------------- */
/*
default_layout_content		NON 0	OUI 1
*/

CREATE TABLE !table! (
layout_theme_id BIGINT NOT NULL UNIQUE, 
fk_theme_id 				BIGINT,
fk_layout_id 				BIGINT,
default_layout_content		INTEGER,

PRIMARY KEY (layout_theme_id),
KEY idx_!IdxNom!_theme_id (fk_theme_id),
KEY idx_!IdxNom!_layout_id (fk_layout_id)

);
