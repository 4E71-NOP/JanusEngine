/* ---------------------------------------- */
/* Foreign keys: theme_id, layout_id			*/
/* ---------------------------------------- */
/*
default_layout_content		NON 0	OUI 1
*/

CREATE TABLE !table! (
layout_theme_id			BINARY(16) NOT NULL UNIQUE, 
layout_theme_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(layout_theme_id))),
fk_theme_id 			BINARY(16),
fk_layout_id 			BINARY(16),
default_layout_content	INTEGER,

PRIMARY KEY (layout_theme_id),
KEY idx_!IdxNom!_theme_id (fk_theme_id),
KEY idx_!IdxNom!_layout_id (fk_layout_id)

);
